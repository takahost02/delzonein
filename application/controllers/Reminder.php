<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reminder extends CI_Controller {

	 function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->load->model('reminder_model');
          $this->load->model('trips_model');
          $this->load->helper(array('form', 'url','string'));
          $this->load->library('form_validation');
          $this->load->library('session');
     }

	public function index()
	{
		$data['reminderlist'] = $this->reminder_model->getall_reminder();
		$this->template->template_render('reminder_management',$data);
	}
	public function addreminder()
	{
		$data['reminder_services'] = $this->db->select('*')->from('reminder_services')->order_by('rs_id','DESC')->get()->result_array();
		$data['vechiclelist'] = $this->trips_model->getall_vechicle();
		$this->template->template_render('reminder_add',$data);
	}
	public function insertreminder()
	{
		$testxss = $_POST;
		if($testxss){
			$response = $this->reminder_model->add_reminder($this->input->post());
			if($response) {
				$this->session->set_flashdata('successmessage', 'New reminder added successfully..');
			} else {
				$this->session->set_flashdata('warningmessage', validation_errors());
			}
			redirect('reminder');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error! Your input are not allowed.Please try again');
			redirect('reminder');
		}
	}
	public function deletereminder()
	{
		$r_id = $this->uri->segment(3);
		$returndata = $this->reminder_model->deletereminder($r_id);
		if($returndata) {
			$this->session->set_flashdata('successmessage', 'Reminder deleted successfully..');
			redirect('reminder');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error..! Try again..');
		    redirect('reminder');
		}
	}

	public function services()
	{
		$data['reminder_services'] = $this->db->select('*')->from('reminder_services')->order_by('rs_id','DESC')->get()->result_array();
		
		$this->template->template_render('reminder_services_add',$data);
	}
	public function insertreminderservices()
	{
		$testxss = xssclean($_POST);
		if($testxss){
			$response = $this->db->insert('reminder_services',$this->input->post());
			if($response) {
				$this->session->set_flashdata('successmessage', 'New service added successfully.');
			} else {
				$this->session->set_flashdata('warningmessage', 'Error..! Try again..');
			}
			redirect('reminder/services');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error! Your inputs are not allowed. Please try again.');
			redirect('reminder/services');
		}
	}

	public function deletereminderservices()
	{
		$rs_id = $this->uri->segment(3);
		$this->db->where('rs_id', $rs_id);
		$returndata = $this->db->delete('reminder_services');
		if($returndata) {
			$this->session->set_flashdata('successmessage', 'Service deleted successfully.');
			redirect('reminder/services');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error..! Try again..');
			redirect('reminder/services');
		}
	}

	public function update_read_status() {
		$id = $this->input->post('r_id');
		$r_isread = $this->input->post('r_isread');
		$this->db->where('r_id', $id);
		$this->db->update('reminder', array('r_isread' => $r_isread));
		echo json_encode(array('status' => 'success'));
	}
	


}
