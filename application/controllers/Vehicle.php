<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vehicle extends CI_Controller {
	function __construct()
    {
          parent::__construct();
          $this->load->database();
          $this->load->model('vehicle_model');
		  $this->load->model('vehiclevendors_model');
          $this->load->model('incomexpense_model');
          $this->load->model('geofence_model');
          $this->load->helper(array('form', 'url','string'));
          $this->load->library('form_validation');
          $this->load->library('session');
    }
	public function index()
	{
		$data['vehiclelist'] = $this->vehicle_model->getall_vehicle();
		$this->template->template_render('vehicle_management',$data);
	}
	public function addvehicle()
	{
		$data['trip_statuses'] = $this->db->get('trip_status_master')->result();
		$data['v_group'] = $this->vehicle_model->get_vehiclegroup();
		$data['vehiclevendors'] = $this->vehiclevendors_model->getall_activevehiclevendors();
		$data['traccar_list'] = json_decode(traccar_call('api/devices','','GET'),true);
		$this->template->template_render('vehicle_add',$data);
	}
	public function insertvehicle()
	{
		$this->form_validation->set_rules('v_registration_no','Registration Number','required|trim|is_unique[vehicles.v_registration_no]');
		$this->form_validation->set_message('is_unique', '%s is already exist');
		$this->form_validation->set_rules('v_model','Model','required|trim');
		$this->form_validation->set_rules('v_chassis_no','Chassis No','required|trim');
        $this->form_validation->set_rules('v_engine_no', 'Engine No', 'required|trim');
		$this->form_validation->set_rules('v_manufactured_by','Manufactured By','required|trim');
		$this->form_validation->set_rules('v_type','Vehicle Type','required|trim');
		$this->form_validation->set_rules('v_color','Vehicle Color','required|trim');
		if($this->form_validation->run()==TRUE){
			$response = $this->vehicle_model->add_vehicle($this->input->post());
			if($response) {
				$this->session->set_flashdata('successmessage', 'New vehicle added successfully..');
			    redirect('vehicle');
			} else {
				$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again');
				redirect('vehicle');
			}
		} else	{
			$this->session->set_flashdata('warningmessage',preg_replace( "/\r|\n/", "", trim(str_replace('.',',',strip_tags(validation_errors())))));
			redirect('vehicle/addvehicle');
		}
	}
	public function editvehicle()
	{
		$data['trip_statuses'] = $this->db->get('trip_status_master')->result();
		$data['vehiclevendors'] = $this->vehiclevendors_model->getall_activevehiclevendors();
		$v_id = decodeId($this->uri->segment(3));
		$data['v_group'] = $this->vehicle_model->get_vehiclegroup();
		$data['vehicledetails'] = $this->vehicle_model->get_vehicledetails($v_id);
		$data['traccar_list'] = json_decode(traccar_call('api/devices','','GET'),true);
		$this->template->template_render('vehicle_add',$data);
	}

	public function updatevehicle()
	{
		if(!empty($_FILES)) {
			$config['upload_path'] = 'assets/uploads/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|docx'; 
			$this->load->library('upload', $config); 
			if(!empty($_FILES['file']['name'][0])){ 
				$uploadData = '';
				$this->upload->initialize($config); 
				$_FILES['file']['name']     = $_FILES['file']['name']; 
				$_FILES['file']['type']     = $_FILES['file']['type']; 
				$_FILES['file']['tmp_name'] = $_FILES['file']['tmp_name']; 
				$_FILES['file']['error']     = $_FILES['file1']['error']; 
				$_FILES['file']['size']     = $_FILES['file']['size']; 
				if($this->upload->do_upload('file')){ 
					$uploadData = $this->upload->data();
					$_POST['v_file'] = $uploadData['file_name'];
				}
			} 
			if(!empty($_FILES['file1']['name'][1])){ 
				$uploadData = '';
				$this->upload->initialize($config); 
				$_FILES['file']['name']     = $_FILES['file1']['name']; 
				$_FILES['file']['type']     = $_FILES['file1']['type']; 
				$_FILES['file']['tmp_name'] = $_FILES['file1']['tmp_name']; 
				$_FILES['file']['error']     = $_FILES['file1']['error']; 
				$_FILES['file']['size']     = $_FILES['file1']['size']; 
				if($this->upload->do_upload('file1')){ 
					$uploadData = $this->upload->data();
					$_POST['v_file1'] = $uploadData['file_name'];
				}
			} 
		}
		
		$testxss = true;
		if($testxss){
			$response = $this->vehicle_model->edit_vehicle($this->input->post());
				if($response) {
					$this->session->set_flashdata('successmessage', 'Vehicle updated successfully..');
				    redirect('vehicle');
				} else
				{
					$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again');
				    redirect('vehicle');
				}
		} else {
			$this->session->set_flashdata('warningmessage', 'Error! Your input are not allowed.Please try again');
			redirect('vehicle');
		}
	}
	public function viewvehicle()
	{
		$v_id = decodeId($this->uri->segment(3));
		$vehicledetails = $this->vehicle_model->get_vehicledetails($v_id);
		$bookings = $this->vehicle_model->getall_bookings($v_id);
		$vgeofence = $this->geofence_model->getvechicle_geofence($v_id);
		//$vincomexpense = $this->incomexpense_model->getvechicle_incomexpense($v_id);
		$geofence_events = $this->geofence_model->countvehiclengeofence_events($v_id);
		if(isset($vehicledetails[0]['v_id'])) {
			$data['vehicledetails'] = $vehicledetails[0];
			$data['bookings'] = $bookings;
			$data['vechicle_geofence'] = $vgeofence;
			//$data['vechicle_incomexpense'] = $vincomexpense;
			$data['geofence_events'] = $geofence_events;
			$data['maintenancelist'] = $this->servicehistory($v_id);
			$data['group'] = $this->db->query("SELECT gr_name FROM vehicle_group WHERE gr_id = ?", array($vehicledetails[0]['v_group']))->row()->gr_name ?? null;
			$this->template->template_render('vehicle_view',$data);
		} else {
			$this->template->template_render('pagenotfound');
		}
	}
	public function servicehistory($v_id) { 
		$this->db->select("vehicle_maintenance.*, vehicles.v_name, vehicle_maintenance_vendor.mv_name, vehicle_maintenance_mechanic.mm_name");
		$this->db->from('vehicle_maintenance');
		$this->db->join('vehicles', 'vehicle_maintenance.m_v_id = vehicles.v_id', 'LEFT');
		$this->db->join('vehicle_maintenance_vendor', 'vehicle_maintenance.m_vendor_id = vehicle_maintenance_vendor.mv_id', 'LEFT');
		$this->db->join('vehicle_maintenance_mechanic', 'vehicle_maintenance.m_mechanic_id = vehicle_maintenance_mechanic.mm_id', 'LEFT');
		$this->db->where('m_v_id', $v_id);
		$this->db->order_by('m_id', 'desc');
		$query = $this->db->get();
		$all_maintenance = $query->result_array();
		if (!empty($all_maintenance)) {
			foreach ($all_maintenance as $key => $am) {
				$newdata[$key] = $am;
				if (!empty($am)) {
					$this->db->select("vehicle_maintenance_parts_used.pu_qty, stockinventory.s_name");
					$this->db->from('vehicle_maintenance_parts_used');
					$this->db->join('stockinventory', 'vehicle_maintenance_parts_used.pu_s_id = stockinventory.s_id', 'LEFT');
					$this->db->where('pu_m_id', $am['m_id']);
					$query = $this->db->get();
					if ($query->num_rows() > 0) {
						$partsused = $query->result_array();
						$newdata[$key]['partsused'] = $partsused;
					} else {
						$newdata[$key]['partsused'] = '';
					}
				} else {
					$newdata[$key]['partsused'] = '';
				}
			}
			return $newdata;
		}
	}
	public function vehiclegroup()
	{
		$data['vehiclegroup'] = $this->vehicle_model->get_vehiclegroup();
		$this->template->template_render('vehicle_group',$data);
	}
	public function vehiclegroup_delete()
	{ 
		$gr_id = decodeId($this->input->post('del_id'));
		$returndata = $this->vehicle_model->vehiclegroup_delete($gr_id);
		if($returndata) {
			$this->session->set_flashdata('successmessage', 'Vehicle type deleted successfully..');
			redirect('vehicle/vehiclegroup');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error..! Some vechicle are mapped with this group. Please remove from vechicle management');
		    redirect('vehicle/vehiclegroup');
		}
	}
	public function addgroup()
	{
		$this->load->helper('file');
		$data = $this->input->post();
		if (!empty($_FILES['group_image']['name'])) {
			$config['upload_path'] = './uploads/'; // Define upload path
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['file_name'] = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['group_image']['name']);
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('group_image')) {
				$uploadData = $this->upload->data();
				$data['gr_image'] = $uploadData['file_name'];
			} else {
				$this->session->set_flashdata('warningmessage', $this->upload->display_errors());
				redirect('vehicle/vehiclegroup');
				return;
			}
		}
		$response = $this->db->insert('vehicle_group', $data);
		if ($response) {
			$this->session->set_flashdata('successmessage', 'Vehicle type added successfully.');
			redirect('vehicle/vehiclegroup');
		} else {
			$this->session->set_flashdata('warningmessage', 'Something went wrong. Try again.');
			redirect('vehicle/vehiclegroup');
		}
	}
	public function deletevehicle()
	{
		$v_id = $this->input->post('del_id');
		$deleteresp = $this->db->delete('vehicles', array('v_id' => $v_id)); 
		if($deleteresp) {
			$this->session->set_flashdata('successmessage', 'Vehicle deleted successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', 'Unexpected error..Try again');
		}
		redirect('vehicle');
	}

	public function updategroup()
	{
		$id = $this->input->post('gr_id');
		$data = $this->input->post();
		unset($data['gr_id']);
		if (!empty($_FILES['group_image']['name'])) {
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['file_name'] = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['group_image']['name']);
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('group_image')) {
				$uploadData = $this->upload->data();
				$data['gr_image'] = $uploadData['file_name'];
				$existingImage = $this->input->post('existing_image');
				if ($existingImage && file_exists('./uploads/' . $existingImage)) {
					unlink('./uploads/' . $existingImage);
				}
			} else {
				$this->session->set_flashdata('warningmessage', $this->upload->display_errors());
				redirect('vehicle/vehiclegroup');
				return;
			}
		}
		$data['gr_visibletobooking'] = isset($_POST['gr_visibletobooking']) ? 1 : 0;
		$this->db->where('gr_id', $id);
		$response = $this->db->update('vehicle_group', $data);
		if ($response) {
			$this->session->set_flashdata('successmessage', 'Vehicle type updated successfully.');
		} else {
			$this->session->set_flashdata('warningmessage', 'Failed to update group.');
		}
		redirect('vehicle/vehiclegroup');
	}


	public function vehicleroute()
	{
		$data['vehicleroute'] = $this->vehicle_model->get_vehicleroute();
		$this->template->template_render('vehicle_route', $data);
	}

	public function vehicleroute_delete()
	{
		$t_id = $this->input->post('del_id');
		$deleteresp = $this->db->delete('vehicle_route', array('vr_id' => $t_id)); 
		if ($deleteresp) {
			$this->session->set_flashdata('successmessage', 'Route deleted successfully.');
			redirect('vehicle/vehicleroute');
		} else {
			$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again.');
			redirect('vehicle/vehicleroute');
		}
	}

	public function addroute()
	{
		$response = $this->db->insert('vehicle_route', $this->input->post());
		if ($response) {
			$this->session->set_flashdata('successmessage', 'Route added successfully.');
			redirect('vehicle/vehicleroute');
		} else {
			$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again.');
			redirect('vehicle/vehicleroute');
		}
	}

	public function download_template() {
        $this->load->helper('download');
        $file_path = './uploads/templates/vehicle.csv';
        if (file_exists($file_path)) {
            $data = file_get_contents($file_path); // Read the file's contents
            force_download('vehicle_template.csv', $data);
        } else {
            $this->session->set_flashdata('message', 'The template file does not exist.');
            redirect('vehicle');
        }
    }

	public function import_csv() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
		$this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            $file_data = $this->upload->data();
            $file_path = $file_data['full_path'];
            if (($handle = fopen($file_path, 'r')) !== FALSE) {
                fgetcsv($handle); // Skip the header row
                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    $this->db->insert('vehicles', [
                        'v_registration_no' => $data[0],
                        'v_name' => $data[1],
                        'v_model' => $data[2],
                        'v_chassis_no' => $data[3],
                        'v_engine_no' => $data[4],
                        'v_manufactured_by' => $data[5],
                        'v_type' => $data[6],
                        'v_color' => $data[7],
                        'v_mileageperlitre' => $data[8],
                        'v_is_active' => $data[9],
                        'v_group' => $data[10],
                        'v_reg_exp_date' => $data[11],
                        'v_api_url' => $data[12],
                        'v_api_username' => $data[13],
                        'v_api_password' => $data[14],
                        'v_traccar_id' => $data[15],
                        'v_file' => $data[16],
                        'v_file1' => $data[17],
                        'v_created_by' => $data[18],
                        'v_created_date' => date('Y-m-d H:i:s'),
                    ]);
                }
                fclose($handle);
            }
            unlink($file_path);
            $this->session->set_flashdata('message', 'CSV data successfully imported.');
			redirect('vehicle');
        } else {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('warningmessage', $error);
				redirect('vehicle');
        }
    }

}
