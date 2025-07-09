<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

	 function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->load->model('customer_model');
          $this->load->helper(array('form', 'url','string'));
          $this->load->library('form_validation');
          $this->load->library('session');
		  $this->load->library('template');
		  $data = sitedata();
		  if (!isset($data['version']) || empty($data['version'])) {
			$this->load->library('database_comparison');
			$this->database_comparison->compare_dbs();
		  }
		  $frontend_content = $this->db->select('*')->from('frontendwebsite_content')->get()->result_array();
		  $this->content = isset($frontend_content[0])?$frontend_content[0]:'';
     }

	public function index()
	{
		$this->load->model('trips_model');
		$data['content'] = $this->content;
		$data['vechiclelist'] = $this->trips_model->getall_vechicle();
		$query = $this->db->select('*')->from('vehicle_group')->where('gr_visibletobooking', 1)->where('gr_image !=', '')->get();
		$data['group'] = $query ? $query->result_array() : [];
		$this->load->view('frontend/index',$data);
	}
	public function myaccount()
	{
		$data['content'] = $this->content;
		$page = $this->input->get();
		if(isset($this->session->userdata['session_data_fr']['c_id'])) {
			if(isset($page['profile'])) {
				$data['customerdetails'] = $this->customer_model->get_customerdetails($this->session->userdata['session_data_fr']['c_id']);
				$this->load->view('frontend/profile',$data);
			} else {
				$this->load->model('trips_model');
				$data['mybookings'] = $this->trips_model->getall_mybookings($this->session->userdata['session_data_fr']['c_id']);
				$this->load->view('frontend/myaccount',$data);
			}
		} else {
			redirect('booking/login');
		}
	}
	public function updateprofile()
	{
		$password = $this->input->post('user_password');
		$confirmPassword = $this->input->post('user_password_re-enter');
		if ($password !== $confirmPassword) {
			$this->session->set_flashdata('warningmessage', 'Passwords do not match.');
			redirect('booking/myaccount?profile');
			return;
		}
		
		$id = $this->input->post('id');
        $updateData = [
            'c_name' => $this->input->post('c_name'),
            'c_email' => $this->input->post('email_address'),
            'c_mobile' => $this->input->post('mobile_number'),
            'c_address' => $this->input->post('address'),
        ];
        if (!empty($password)) {
            $updateData['c_pwd'] = md5($password); 
        }
		$this->db->where('c_id',$this->session->userdata['session_data_fr']['c_id']);
		$response = $this->db->update('customers',$updateData);
		if($response) {
			$this->session->set_flashdata('successmessage', 'Customer updated successfully..');
			redirect('booking/myaccount?profile');
		} else
		{
			$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again');
			redirect('booking/myaccount?profile');
		}
	}
	public function signup()
	{
		$data['content'] = $this->content;
		if ($this->input->post()) {
			$this->form_validation->set_rules('c_name', 'Name', 'required');
			$this->form_validation->set_rules('c_mobile', 'Mobile', 'required');
			$this->form_validation->set_rules('c_email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('c_pwd', 'Password', 'required');
			$this->form_validation->set_rules('c_address', 'Address', 'required');
			if ($this->form_validation->run() == FALSE) {
				$data['warningmessage'] = validation_errors();
			} else {
				$inputData = $this->input->post(NULL, TRUE); 
				$exist = $this->db->get_where('customers', ['c_email' => $inputData['c_email']])->row_array();
				if (!$exist) {
					$inputData['c_pwd'] = md5($inputData['c_pwd']);
					$inputData['c_created_date'] = date('Y-m-d H:i:s');
					$inputData['c_isactive'] = 1;
					$response = $this->customer_model->add_customer($inputData);
					if ($response) {
						$this->session->set_flashdata('successmessage', 'Account created successfully.');
						redirect('booking/login'); 
					} else {
						$data['warningmessage'] = 'Something went wrong. Please try again.';
					}
				} else {
					$data['warningmessage'] = 'An account with this email already exists. Please login.';
				}
			}
			$this->session->set_flashdata('warningmessage', $data['warningmessage']);
			redirect('booking/signup?erere');
		}
		$this->load->view('frontend/signup', $data);
	}
	
	public function login() 
	{
		$data['content'] = $this->content;
		if(isset($_POST['username'])) {
			$this->db->where('c_email', $this->input->post('username'));
			$this->db->where('c_pwd', md5($this->input->post('password')));
			$query = $this->db->get("customers");
			if ($query->num_rows() >= 1) {
				$result = $query->row_array();
				$session_data = array('c_id' => $result['c_id'],
									'c_name' => $result['c_name'],
									'c_email' => $result['c_email']); 
				if($result['c_isactive']==0) {
					$this->session->set_flashdata('warningmessage', 'User not active.Please contact admin');
					redirect('booking/login');
				} else {
					$this->session->set_flashdata('successmessage', 'You got logged in successfully..');
					$this->session->set_userdata('session_data_fr', $session_data);
					redirect('booking/myaccount');
				}
			} else {
				$this->session->set_flashdata('warningmessage', 'Invalid email or Password !');
				redirect('booking/login?asfd');
			}
		} else if(isset($this->session->userdata['session_data_fr']['c_id'])) {
			$this->load->model('trips_model');
			$data['mybookings'] = $this->trips_model->getall_mybookings($this->session->userdata['session_data_fr']['c_id']);
			$this->load->view('frontend/myaccount',$data);
		} else { 
			$this->load->view('frontend/login',$data);
		}
	}
	public function logout() {
		$sess_array = array('c_id' => '');
		$this->session->unset_userdata('session_data_fr', $sess_array);
		$this->session->set_flashdata('successmessage', 'Successfully Logged out !');
		redirect('/');
	}
	public function book() {
		$data['content'] = $this->content;
		$bookingemail = $this->input->post('bookingemail');
		$_POST['t_start_date'] = convertToMySQLDateTime($_POST['t_start_date'], $_POST['t_start_time']);
		$_POST['t_end_date'] = convertToMySQLDateTime($_POST['t_end_date'], $_POST['t_end_time']);
		unset($_POST['t_start_time']);
		unset($_POST['t_end_time']);
		unset($_POST['bookingemail']);
		$this->load->model('trips_model');
		if($this->input->post('t_created_by')!='') {
			$this->form_validation->set_rules('t_trip_fromlocation', 'From Location', 'required');
			$this->form_validation->set_rules('t_trip_tolocation', 'To Location', 'required');
			if($this->form_validation->run() == FALSE) {
			  $this->session->set_flashdata('warningmessage', validation_errors());
			  redirect('/');
			} else {
				$response = $this->trips_model->add_trips($this->input->post());
				$_POST['t_id'] = $response;
				if(isset($bookingemail)) {
					sendtripemail($this->input->post());
				}
				if($response) {
					$this->session->set_flashdata('successmessage', 'Booking completed successfully.We will contact you shortly..');
				} else {
					$this->session->set_flashdata('warningmessage', 'Unexpected error..Try again');
				}
				redirect('booking');
			}
		} else {
			$this->session->set_flashdata('warningmessage', 'Please login before trying to book..');
			redirect('booking');
		}
	}
	public function canceltrip()
	{
		$t_id = $this->input->post('del_id');
		$data = array(
			't_trip_status' => 'Trip Cancelled'
		);
		$this->db->where('t_id', $t_id); 
		$deleteresp = $this->db->update('trips', $data);
		if($deleteresp) {
			$this->session->set_flashdata('successmessage', 'Trip cancelled successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', 'Unexpected error..Try again');
		}
		redirect('booking/myaccount');
	}
}
