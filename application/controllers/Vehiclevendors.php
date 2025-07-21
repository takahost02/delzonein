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
        $data['vehiclevendorslist'] = $this->vehiclevendors_model->getall_vehiclevendors();
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

            // Password hashing is now handled in the model
            $response = $this->vehiclevendors_model->add_vehiclevendors($input);

            if ($response) {
                $this->session->set_flashdata('successmessage', 'New vehiclevendor added successfully..');
                redirect('vehiclevendors');
            }
        } else {
            $errormsg = preg_replace("/\r|\n/", "", trim(str_replace('.', ',', strip_tags(validation_errors()))));
            if (!$testxss) {
                $errormsg = 'Error Your input are not allowed.Please try again';
            }
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

            // Handle file uploads
            if (!empty($_FILES)) {
                $config['upload_path'] = 'assets/uploads/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|docx';
                $this->load->library('upload', $config);

                // File 1: 'vn_file'
                if (!empty($_FILES['vn_file']['name'])) {
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('vn_file')) {
                        $uploadData = $this->upload->data();
                        $input['vn_file'] = $uploadData['file_name'];
                    }
                }

                // File 2: 'vn_file1'
                if (!empty($_FILES['vn_file1']['name'])) {
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('vn_file1')) {
                        $uploadData = $this->upload->data();
                        $input['vn_file1'] = $uploadData['file_name'];
                    }
                }
            }

            // Reformat Date
            if (!empty($input['vn_doj'])) {
                $input['vn_doj'] = reformatDate($input['vn_doj']); // assume this returns Y-m-d
            }

            // Hash password if needed
            if (!empty($input['vn_password']) && !preg_match('/^[a-f0-9]{32}$/i', $input['vn_password'])) {
                $input['vn_password'] = md5($input['vn_password']);
            } else if (empty($input['vn_password'])) {
                unset($input['vn_password']); // retain old password
            }

            // Update using model
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
