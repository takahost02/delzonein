<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
    //To load initial libraries, functions
	function __construct( )
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('directory');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();
	}
	//To load login page
	public function index()    //Login Controller
	{
	  if (isset($this->session->userdata['session_data'])) {
            $url = base_url() . "dashboard";
            header("location: $url");
        } else {
            $this->load->view('login');
        }
	}
	//To login functionality check
	public function login_action() 
	{
		
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if($this->form_validation->run() == FALSE) 
		{
		  $this->session->set_flashdata('warningmessage', "Email and Password is required and can't be empty.");
		  redirect('login');
		}
		else 
		{ 
		$this->load->model('login_model');
		$result = $this->login_model->check_login($this->input->post());
			if($result != FALSE)
			{
				$session_data = array('u_id' => $result['u_id'],
									  'name' => $result['u_name'],
									  'email' => $result['u_username'],
									  'u_isactive' =>$result['u_isactive']); 
				$userroles = $this->login_model->userroles($result['u_id']);
				if($result['u_isactive']==0) {
					$this->session->set_flashdata('warningmessage', 'User not active.Please contact admin');
					redirect('login');
				} else if(empty($userroles)) {
					$this->session->set_flashdata('warningmessage', 'User role is not defined.Please contact admin');
					redirect('login');
				} else {
					$this->session->set_userdata('userroles', $userroles);
				}
				$this->db->set('u_lastlogin', 'NOW()', false)->where('u_id', $result['u_id'])->update('login');
				$this->session->set_userdata('session_data', $session_data);
				redirect('dashboard');
			}
			else 
			{
			$this->session->set_flashdata('warningmessage', 'Invalid email or Password !');
			redirect('login');
			}
		}
	}
	//To logout session from browser
	public function logout() {
		// Removing session data
		$sess_array = array('u_id' => '');
		$this->session->unset_userdata('session_data', $sess_array);
		$this->session->unset_userdata('userroles', array());
		$this->session->set_flashdata('successmessage', 'Successfully Logged out !');
		redirect('login');
	}
	public function forgetpassword() 
	{
		$this->load->view('forgetpassword');
	}
	public function forgetpassword_action()
    {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username/Email', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('warningmessage', 'Username / Email cant be empty.');
			redirect('login/forgetpassword');
		} else {
			$username = $this->input->post('username'); 
			$this->load->database();
			$this->db->where('u_username', $username);
			$this->db->or_where('u_email', $username);
			$query = $this->db->get('login');
			$user = $query->row();
			if ($user->u_id!='') {
				$reset_token = bin2hex(random_bytes(32)); 
				$expires_at = date('Y-m-d H:i:s', strtotime('+15 minutes'));
				$this->db->where('u_id', $user->u_id);
				$this->db->update('login', [
					'u_reset_token' => $reset_token,
					'u_reset_expires_at' => $expires_at
				]);
				$reset_link = base_url("login/changepassword/$reset_token");
				$this->load->model('emailsms_model');	
				$gettemplate = $this->db->select('*')->from('email_template')->where('et_name','resetpassword')->get()->result_array();
				if(!empty($gettemplate)) {
					$this->load->model('emailsms_model');	
					$template = $gettemplate[0]['et_body'];
					$template = str_replace("{{link}}", $reset_link, $template);
					$emailresp = $this->emailsms_model->sendemail($user->u_email,$gettemplate[0]['et_subject'],$template);
					if($emailresp) {
						$this->session->set_flashdata('successmessage', 'Password reset link has been sent to your email.');
						redirect('login');
					} else {
						$this->session->set_flashdata('warningmessage', 'Failed to send email. Please try again later.');
						redirect('login');
					}
				} else {
					$this->session->set_flashdata('warningmessage', 'Failed to send email. Please try again later.');
					redirect('login');
				}
			} else {
				$this->session->set_flashdata('warningmessage', 'Username or Email not found.');
				redirect('login');
			}
    	}
	}
	
	public function changepassword($token = null)
	{
		$this->load->database();
		if (!$token) {
			show_404();
		}
		$this->db->where('u_reset_token', $token);
		$this->db->where('u_reset_expires_at >=', date('Y-m-d H:i:s')); 
		$query = $this->db->get('login');
		$user = $query->row();
		if (!$user) {
			$this->session->set_flashdata('warningmessage', 'Invalid or expired reset link.');
			redirect('login');
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('password', 'New Password', 'required');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
			if ($this->form_validation->run() == TRUE) {
				$new_password = md5($this->input->post('password'));
				$this->db->where('u_id', $user->u_id);
				$this->db->update('login', [
					'u_password' => $new_password,
					'u_reset_token' => null,
					'u_reset_expires_at' => null
				]);
				$this->session->set_flashdata('successmessage', 'Your password has been updated. Please log in.');
				redirect('login');
			} else {
				$this->session->set_flashdata('warningmessage', strip_tags(validation_errors()));
				redirect('login');
			}
		}
		$this->load->view('forgetpassword_update', ['token' => $token]);
	}
}
