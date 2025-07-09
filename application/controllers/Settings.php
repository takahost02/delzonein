<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
   
   function __construct( )
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->database();
	}
	public function websitesetting()   
	{
		$data['website_setting'] = $this->db->select('*')->from('settings')->get()->result_array();
		$this->template->template_render('websitesetting',$data);
	}
	public function websitesetting_save()   
	{
		$upload_path = 'assets/marker';
		if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true); 
        }
		$insertarray = $this->input->post();
		$testxss = xssclean($this->input->post());
		if($testxss){
			$success=true;
			if(!empty($_FILES['file']['name'])) { 
			    $data = array(); 
				    $image = time().'-'.$_FILES['file']['name']; 
					$config = array(
							'upload_path' => 'assets/uploads', 
							'allowed_types' =>'jpg|jpeg|png',
							'overwrite' => TRUE,
							'file_name' => $image
						);
				    	$this->load->library('upload',$config); 
				   		if($this->upload->do_upload('file')){ 
						     $uploadData = $this->upload->data(); 
						     $insertarray['s_logo'] = $uploadData['file_name'];
					    } else { 
					    	 $success=false;
					    	 $msg = $this->upload->display_errors();
					    } 
			}

			if(!empty($_FILES['icon_file']['name'])) { 
			    $data = array(); 
				    $image_1 = time().'-'.$_FILES['icon_file']['name']; 
					$config_1 = array(
							'upload_path' => 'assets/uploads', 
							'allowed_types' =>'jpg|jpeg|png',
							'overwrite' => TRUE,
							'file_name' => $image_1
						);
				    	$this->load->library('upload',$config_1); 
				   		if($this->upload->do_upload('icon_file')){ 
						     $uploadData_1 = $this->upload->data(); 
						     $insertarray['s_icon'] = $uploadData_1['file_name'];
					    } else { 
					    	 $success=false;
					    	 $msg = $this->upload->display_errors();
					    } 
			}
		
			 if (!empty($_FILES['s_mapstarting_marker']['name'])) {
				$image = time() . '-' . $_FILES['s_mapstarting_marker']['name'];
				$config = array(
					'upload_path' => 'assets/marker',
					'allowed_types' => 'jpg|jpeg|png',
					'overwrite' => TRUE,
					'max_size' => "1024",  // max file size in KB
					'max_height' => "250",
					'max_width' => "50",
					'file_name' => $image
				);
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('s_mapstarting_marker')) {
					$uploadData = $this->upload->data();
					$insertarray['s_mapstarting_marker'] = 'assets/marker/'.$uploadData['file_name'];
				} else {
					$success = false;
					$msg = $this->upload->display_errors();
				}
			}
	
			// Handle Map Ending Marker File Upload
			if (!empty($_FILES['s_mapending_marker']['name'])) {
				$image = time() . '-' . $_FILES['s_mapending_marker']['name'];
				$config = array(
					'upload_path' => 'assets/marker',
					'allowed_types' => 'jpg|jpeg|png',
					'overwrite' => TRUE,
					'max_size' => "1024",  // max file size in KB
					'max_height' => "250",
					'max_width' => "50",
					'file_name' => $image
				);
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('s_mapending_marker')) {
					$uploadData = $this->upload->data();
					$insertarray['s_mapending_marker'] = 'assets/marker/'.$uploadData['file_name'];
				} else {
					$success = false;
					$msg = $this->upload->display_errors();
				}
			}

			if($success) {
			     $ws = $this->db->select('*')->from('settings')->get()->num_rows();
			     if($ws=='' || $ws==0) {
			     	$this->db->insert('settings',$insertarray); 
			     } else {
			     	$this->db->update('settings',$insertarray);
			     }
			     $success=true;
			     $msg = 'successfully uploaded '; 
				$this->session->set_flashdata('successmessage', 'Setting saved successfully!.');
				redirect('settings/websitesetting');
			} else {
				$this->session->set_flashdata('warningmessage', $msg);
				redirect('settings/websitesetting');
			}
			
		} else {
			$this->session->set_flashdata('warningmessage', 'Error! Your input are not allowed.Please try again');
			redirect('settings/websitesetting');
		}
	}
	public function logodelete()   
	{
		$updatearray = array('s_logo'=>'');
		$this->db->update('settings', $updatearray);
		echo true;
	}
	public function smtpconfig()   
	{
		$data['smtpconfig'] = $this->db->select('*')->from('settings_smtp')->get()->result_array();
		$this->template->template_render('smtpconfig',$data);
	}
	public function smtpconfigsave()   
	{
		$settings_smtp = $this->db->select('*')->from('settings_smtp')->get()->num_rows();
        if($settings_smtp =='' || $settings_smtp ==0) {
     		$response = $this->db->insert('settings_smtp',$this->input->post()); 
        } else {
     	  	$response = $this->db->update('settings_smtp',$this->input->post());
        }
        if($response) {
				$this->session->set_flashdata('successmessage', 'SMTP config saved successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again');
		}
		redirect('settings/smtpconfig');
	}
	public function smtpconfigtestemail()   
	{
		$this->load->model('emailsms_model');
		$email = $this->input->post('testemailto');
		$response = $this->emailsms_model->sendemail($email,'SMTP Config Test','Test Email');
		if($response=='true') {
			$this->session->set_flashdata('successmessage', 'Email sent successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', $response);
		}
		redirect('settings/smtpconfig');
	}
	public function email_template()   
	{
		$data['emailtemplate'] = $this->db->select('*')->from('email_template')->get()->result_array();
		$this->template->template_render('email_template',$data);
	}
	public function update_template() { 
		$this->db->where('et_id',$this->input->post('et_id'));
		$response = $this->db->update('email_template',$this->input->post());
		if($response) {
			$this->session->set_flashdata('successmessage', 'Template updated successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again');
		}
		redirect('settings/email_template');
	}
	public function websitesetting_traccar()   
	{
		$data['website_setting'] = $this->db->select('*')->from('settings')->get()->result_array();
		$this->template->template_render('websitesetting_traccar',$data);
	}
	public function traccarconfigsave()   
	{
		$_POST['s_traccar_url'] = rtrim($_POST['s_traccar_url'], '/') . '/';
		$response = $this->db->update('settings',$_POST);
        if($response) {
				$this->session->set_flashdata('successmessage', 'Traccar settings saved successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again');
		}
		redirect('settings/websitesetting_traccar');
	}
	public function smsconfig() {
		$data['twilioconfig'] = $this->db->select('*')->from('settings_twilio')->get()->result_array();
		$this->template->template_render('websitesetting_sms',$data);
	}
	public function twilioconfigsave() {
		$settings_twilio = $this->db->select('*')->from('settings_twilio')->get()->num_rows();
        if($settings_twilio =='' || $settings_twilio ==0) {
     		$response = $this->db->insert('settings_twilio',$this->input->post()); 
        } else {
     	  	$response = $this->db->update('settings_twilio',$this->input->post());
        }
        if($response) {
				$this->session->set_flashdata('successmessage', 'Twilio config saved successfully.');
		} else {
			$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again');
		}
		redirect('settings/smsconfig');
	}
	public function twilioconfigtestsms() {
		$this->load->library('twilio');
		$response = $this->twilio->sendSMS('+'.$this->input->post('testsmsto'),'test sms from LMS');
		if($response->IsError){
			$this->session->set_flashdata('warningmessage', 'Something went wrong. Please check sms settings and try again');
		} else {
			$this->session->set_flashdata('successmessage', 'SMS sent successfully.');
		}
		redirect('settings/smsconfig');
	}
	public function sms_template()   
	{
		$data['smstemplate'] = $this->db->select('*')->from('sms_template')->get()->result_array();
		$this->template->template_render('sms_template',$data);
	}
	public function update_sms_template() { 
		$this->db->where('st_id',$this->input->post('st_id'));
		$response = $this->db->update('sms_template',$this->input->post());
		if($response) {
			$this->session->set_flashdata('successmessage', 'SMS Template updated successfully.');
		} else {
			$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again');
		}
		redirect('settings/sms_template');
	}
	public function frontendcontent() { 
		$frontend_content = $this->db->select('*')->from('frontendwebsite_content')->get()->result_array();
		$data['content'] = isset($frontend_content[0])?$frontend_content[0]:'';
		$this->template->template_render('frontend_content',$data);
	}
	public function frontendcontent_save() { 
		if(!empty($_FILES['file']['name'])) { 
			$data = array(); 
			$image = time().'-'.$_FILES['file']['name']; 
			$config = array(
					'upload_path' => 'assets/uploads', 
					'allowed_types' =>'jpg|jpeg|png',
					'overwrite' => TRUE,
					'file_name' => $image
				);
				$this->load->library('upload',$config); 
					if($this->upload->do_upload('file')){ 
						$uploadData = $this->upload->data(); 
						$_POST['mainbg_img'] = $uploadData['file_name'];
				} else { 
						$success=false;
						$msg = $this->upload->display_errors();
				} 
		}
		$this->db->where('id',$this->input->post('id'));
		$response = $this->db->update('frontendwebsite_content',$this->input->post());
		if($response) {
			$this->session->set_flashdata('successmessage', 'Content updated successfully.');
		} else {
			$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again');
		}
		redirect('settings/frontendcontent');
	}
}
 