<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drivers extends CI_Controller {

	 function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->load->model('drivers_model');
          $this->load->helper(array('form', 'url','string'));
          $this->load->library('form_validation');
          $this->load->library('session');
     }

	public function index()
	{
		$data['driverslist'] = $this->drivers_model->getall_drivers();
		$this->template->template_render('drivers_management',$data);
	}
	public function adddrivers()
	{
		$this->template->template_render('drivers_add');
	}
	public function insertdriver()
	{
		$this->form_validation->set_rules('d_licenseno','License Number','required|trim|is_unique[vehicles.v_registration_no]');
		$this->form_validation->set_message('is_unique', '%s is already exist');
		$this->form_validation->set_rules('d_name','Name','required|trim');
		$this->form_validation->set_rules('d_mobile','Mobile','required|trim');
        $this->form_validation->set_rules('d_address', 'Address', 'required|trim');
		$this->form_validation->set_rules('d_age','Age','required|trim');
		$this->form_validation->set_rules('d_licenseno','License Number','required|trim');
		$this->form_validation->set_rules('d_license_expdate','License Exp Date','required|trim');
		$this->form_validation->set_rules('d_total_exp','Total Experiance','required|trim');
		$this->form_validation->set_rules('d_doj','Date of Joining','required|trim');
		$testxss = true;
		if($this->form_validation->run()==TRUE && $testxss){
			$response = $this->drivers_model->add_drivers($this->input->post());
			if($response) {
				$this->session->set_flashdata('successmessage', 'New driver added successfully..');
			    redirect('drivers');
			}
		} else {
			$errormsg = preg_replace( "/\r|\n/", "", trim(str_replace('.',',',strip_tags(validation_errors()))));
			if(!$testxss) {
				$errormsg = 'Error! Your input are not allowed.Please try again';
			}
			$this->session->set_flashdata('warningmessage',$errormsg);
			redirect('drivers/adddrivers');
		}
	}
	public function editdriver()
	{
		$d_id = $this->uri->segment(3);
		$data['driverdetails'] = $this->drivers_model->get_driverdetails($d_id);
		$this->template->template_render('drivers_add',$data);
	}

	public function updatedriver()
	{
		$testxss = xssclean($_POST);
		if($testxss){
			$response = $this->drivers_model->edit_driver($this->input->post());
				if($response) {
					$this->session->set_flashdata('successmessage', 'Driver updated successfully..');
				    redirect('drivers');
				} else
				{
					$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again');
				    redirect('drivers');
				}
		} else {
			$this->session->set_flashdata('warningmessage', 'Error! Your input are not allowed.Please try again');
			redirect('drivers');
		}
	}
	public function deletedriver()
	{
		$d_id = $this->input->post('del_id');
		$deleteresp = $this->db->delete('drivers', array('d_id' => $d_id)); 
		if($deleteresp) {
			$this->session->set_flashdata('successmessage', 'Driver deleted successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', 'Unexpected error..Try again');
		}
		redirect('drivers');
	}
	public function download_template() {
        $this->load->helper('download');
        $file_path = './uploads/templates/drivers.csv';
        if (file_exists($file_path)) {
            $data = file_get_contents($file_path); // Read the file's contents
            force_download('drivers_template.csv', $data);
        } else {
            $this->session->set_flashdata('message', 'The template file does not exist.');
            redirect('drivers');
        }
    }

	public function import_csv() {
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
					$this->db->insert('drivers', [
						'd_name' => $data[0],
						'd_mobile' => $data[1],
						'd_address' => $data[2],
						'd_age' => $data[3],
						'd_licenseno' => $data[4],
						'd_license_expdate' => $data[5],
						'd_total_exp' => $data[6],
						'd_ref' => $data[7],
						'd_is_active' => 1,  // Assuming active by default
						'd_created_date' => date('Y-m-d H:i:s'),
						'd_retest_exp' => $data[8],
						'd_ddc' => $data[9],
						'd_doj' => $data[10]
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
			redirect('drivers');
		} else {
			$error = $this->upload->display_errors();
			$this->session->set_flashdata('warningmessage', $error);
			redirect('drivers');
		}
	}
	
}
