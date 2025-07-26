<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vehiclevendors extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('vehiclevendors_model');
        $this->load->helper(array('form', 'url', 'string'));
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index()
    {
        $session_data = $this->session->userdata('session_data');
        $user_type = $session_data['user_type'] ?? null;
        $user_id   = $session_data['u_id'] ?? null;

        $vendor_ids = [];

        if ($user_type === 'admin') {
            // Admin sees all vehicle vendors
            $data['vehiclevendorslist'] = $this->vehiclevendors_model->getall_vehiclevendors();
        } elseif ($user_type === 'vendor') {
            // Vendor sees only their own vendor record
            $vendor_ids = [$user_id];
            $data['vehiclevendorslist'] = $this->vehiclevendors_model->getall_vehiclevendors($vendor_ids);
        } elseif ($user_type === 'driver') {
            // Step 1: Join trips and vehicles to get vendor IDs
            $this->db->select('vehicles.v_vendor_name');
            $this->db->from('trips');
            $this->db->join('vehicles', 'vehicles.v_id = trips.t_vehicle', 'left');
            $this->db->where('trips.t_driver', $user_id);

            $results = $this->db->get()->result_array();
            $vendor_ids = array_unique(array_column($results, 'v_vendor_name'));

            // Ensure all IDs are valid integers
            $vendor_ids = array_filter($vendor_ids, function ($val) {
                return is_numeric($val) && $val > 0;
            });

            $data['vehiclevendorslist'] = $this->vehiclevendors_model->getall_vehiclevendors($vendor_ids);
        } else {
            // Other user types see nothing
            $data['vehiclevendorslist'] = [];
        }

        $this->template->template_render('vehiclevendors_management', $data);
    }



    public function addvehiclevendors()
    {
        $this->template->template_render('vehiclevendors_add');
    }

    public function insertvehiclevendor()
    {
        $testxss = true;

        if ($testxss) {
            $input = $this->input->post();
            $this->vehiclevendors_model->add_vehiclevendors($input); // original model call

            // Get last inserted vendor ID
            $vendor_id = $this->db->insert_id();

            if ($vendor_id) {
                $role_data = array(
                    'lr_u_id' => $vendor_id,
                    'lr_user_type' => 'vendor',
                    'lr_vech_list' => 1,
                    'lr_vech_list_view' => 1,
                    'lr_vech_list_edit' => 1,
                    'lr_vech_add' => 1,
                    'lr_vech_group' => 1,
                    'lr_vech_group_add' => 1,
                    'lr_vech_group_action' => 1,
                    'lr_drivers_list' => 1,
                    'lr_drivers_list_edit' => 1,
                    'lr_drivers_add' => 1,
                    'lr_trips_list' => 1,
                    'lr_trips_list_edit' => 1,
                    'lr_trips_add' => 1,
                    'lr_cust_list' => 1,
                    'lr_cust_edit' => 1,
                    'lr_cust_add' => 1,
                    'lr_fuel_list' => 1,
                    'lr_fuel_edit' => 1,
                    'lr_fuel_add' => 1,
                    'lr_reminder_list' => 1,
                    'lr_reminder_delete' => 1,
                    'lr_reminder_add' => 1,
                    'lr_ie_list' => 1,
                    'lr_ie_edit' => 1,
                    'lr_ie_add' => 1,
                    'lr_tracking' => 1,
                    'lr_liveloc' => 1,
                    'lr_geofence_add' => 1,
                    'lr_geofence_list' => 1,
                    'lr_geofence_delete' => 1,
                    'lr_geofence_events' => 1,
                    'lr_reports' => 1,
                    'lr_settings' => 1,
                    'lr_vech_del' => 1,
                    'lr_driver_del' => 1,
                    'lr_booking_del' => 1,
                    'lr_cust_del' => 1,
                    'lr_fuel_del' => 1,
                    'lr_reminder_del' => 1,
                    'lr_ie_del' => 1,
                    'lr_maintenace' => 1,
                    'lr_maintenace_add' => 1,
                    'lr_vech_availablity' => 1,
                    'lr_parts' => 1,
                    'lr_vehiclevendors' => 1,
                    'lr_vehiclevendors_add' => 1,
                    'lr_vehiclevendors_del' => 1,
                    'lr_mechanic' => 1,
                    'lr_mechanic_add' => 1,
                    'lr_mechanic_del' => 1,
                    'lr_vendor' => 1,
                    'lr_vendor_add' => 1,
                    'lr_vendor_del' => 1,
                    'lr_fuel_vendor' => 1,
                    'lr_ie_cat' => 1,
                    'lr_route' => 1,
                    'lr_route_add' => 1,
                    'lr_route_del' => 1,
                    'lr_dashboard' => 1,
                    'lr_employees' => 1,
                    'lr_coupon' => 1,
                    'lr_stock_add' => 1,
                    'lr_stock' => 1,
                    'lr_accounts' => 1,
                    'lr_role' => 1
                );
                $this->db->insert('login_roles', $role_data);
            }


            $this->session->set_flashdata('successmessage', 'New vehiclevendor added successfully..');
            redirect('vehiclevendors');
        } else {
            $errormsg = preg_replace("/\r|\n/", "", trim(str_replace('.', ',', strip_tags(validation_errors()))));
            $this->session->set_flashdata('warningmessage', $errormsg);
            redirect('vehiclevendors/addvehiclevendors');
        }
    }



    public function editvehiclevendor()
    {
        $c_id = decodeId($this->uri->segment(3));
        $data['vehiclevendordetails'] = $this->vehiclevendors_model->get_vehiclevendordetails($c_id);
        $this->template->template_render('vehiclevendors_add', $data);
    }

    public function updatevehiclevendor()
    {
        $testxss = xssclean($_POST);
        if ($testxss) {
            $input = $this->input->post();

            // Password hashing is now handled in model
            $response = $this->vehiclevendors_model->edit_vehiclevendor($input);

            if ($response) {
                $this->session->set_flashdata('successmessage', 'Vehicle vendor updated successfully.');
            } else {
                $this->session->set_flashdata('warningmessage', 'Something went wrong. Try again.');
            }
            redirect('vehiclevendors');
        } else {
            $this->session->set_flashdata('warningmessage', 'Error! Your input is not allowed. Please try again.');
            redirect('vehiclevendors');
        }
    }



    public function deletevehiclevendor()
    {
        $c_id = $this->input->post('del_id');
        $deleteresp = $this->db->delete('vehiclevendors', array('c_id' => $c_id));
        if ($deleteresp) {
            $this->session->set_flashdata('successmessage', 'vehiclevendor deleted successfully..');
        } else {
            $this->session->set_flashdata('warningmessage', 'Unexpected error..Try again');
        }
        redirect('vehiclevendors');
    }

    public function download_template()
    {
        $this->load->helper('download');
        $file_path = './uploads/templates/vehiclevendor.csv';
        if (file_exists($file_path)) {
            $data = file_get_contents($file_path); // Read the file's contents
            force_download('vehiclevendor_template.csv', $data);
        } else {
            $this->session->set_flashdata('message', 'The template file does not exist.');
            redirect('vehiclevendors');
        }
    }

    public function import_csv()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file')) {
            $file_data = $this->upload->data();
            $file_path = $file_data['full_path'];

            if (($handle = fopen($file_path, 'r')) !== FALSE) {
                fgetcsv($handle); // Skip the header row
                $this->db->trans_start();
                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    $this->db->insert('vehiclevendors', [
                        'c_name' => $data[0],
                        'c_mobile' => $data[1],
                        'c_address' => $data[2],
                        'c_age' => $data[3],
                        'c_licenseno' => $data[4],
                        'c_license_expdate' => $data[5],
                        'c_total_exp' => $data[6],
                        'c_ref' => $data[7],
                        'c_is_active' => 1,
                        'c_created_date' => date('Y-m-d H:i:s'),
                    ]);
                }
                $this->db->trans_complete();
                fclose($handle);
                if ($this->db->trans_status() === FALSE) {
                    $this->session->set_flashdata('warningmessage', 'Error occurred while importing CSV data.');
                } else {
                    $this->session->set_flashdata('message', 'CSV data successfully imported.');
                }
            } else {
                $this->session->set_flashdata('warningmessage', 'Error opening CSV file.');
            }
            unlink($file_path);
            redirect('vehiclevendors');
        } else {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('warningmessage', $error);
            redirect('vehiclevendors');
        }
    }
}
