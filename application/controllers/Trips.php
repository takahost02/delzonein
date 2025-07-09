<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trips extends CI_Controller {

	 function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->load->model('trips_model');
          $this->load->model('customer_model');	
          $this->load->model('drivers_model');	
          $this->load->helper(array('form', 'url','string'));
          $this->load->library('form_validation');
          $this->load->library('session');
		  //error_reporting(E_ALL & ~E_DEPRECATED);
		  //$this->output->enable_profiler(TRUE);

     }

	public function index()
	{
		$data['triplist'] = $this->trips_model->getall_trips();
		$this->template->template_render('trips_management',$data);
	}
	public function addtrips()
	{
		$data['customerlist'] = $this->trips_model->getall_customer();
		$data['route'] = $this->trips_model->getall_route();
		$data['vechiclelist'] = $this->trips_model->getall_vechicle();
		$data['driverlist'] = $this->trips_model->getall_driverlist();
		$data['trip_statuses'] = $this->db->get('trip_status_master')->result();
		$data['tax'] = $this->db->get('settings_tax')->result();
		$this->template->template_render('trips_add',$data);
	}
	public function inserttrips() 
	{
		$testxss = true;
		if($testxss){
			$response = $this->trips_model->add_trips($this->input->post());
			$bookingemail = $this->input->post('t_bookingemail');
			if(isset($bookingemail)) {
				sendtripemail($this->input->post());
			}
			if($response) {
				$this->session->set_flashdata('successmessage', 'New trip added successfully..');
			} else {
				$this->session->set_flashdata('warningmessage', 'Unexpected error..Try again');
			}
			redirect('trips');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error! Your input are not allowed.Please try again');
			redirect('trips');
		}
	}
	public function edittrip()
	{   
		$data['trip_statuses'] = $this->db->get('trip_status_master')->result();
		$data['tax'] = $this->db->get('settings_tax')->result();
		$data['route'] = $this->trips_model->getall_route();
		$data['customerlist'] = $this->trips_model->getall_customer();
		$data['vechiclelist'] = $this->trips_model->getall_vechicle();
		$data['driverlist'] = $this->trips_model->getall_driverlist();
		$t_id = decodeId($this->uri->segment(3));
		$data['tripdetails'] = $this->trips_model->get_tripdetails($t_id);
		$this->template->template_render('trips_add',$data);
	}

	public function updatetrips()
	{
		$response = $this->trips_model->update_trips($this->input->post());
		if($response) {
			$this->session->set_flashdata('successmessage', 'New transaction added successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', 'Unexpected error..Try again');
		}
		redirect('trips');
	}
	public function details()
	{
		$data = array();
		$b_id = decodeId($this->uri->segment(3));
		$tripdetails = $this->trips_model->get_tripdetails($b_id);
		if(!empty($tripdetails)) {
			$data['cat'] = $this->db->select('*')->from('ac_transactions_category')->get()->result_array();
			$data['account'] = $this->db->select('id,account_name')->from('ac_accounts')->get()->result_array();
			if(isset($tripdetails[0]['t_id'])) {
				$customerdetails = $this->customer_model->get_customerdetails($tripdetails[0]['t_customer_id']);
				$driverdetails = $this->drivers_model->get_driverdetails($tripdetails[0]['t_driver']);
				$data['paymentdetails'] = $this->trips_model->get_paymentdetails($tripdetails[0]['t_id']);
				$data['tripdetails'] = $tripdetails[0];
				$data['trip_expenses'] = $this->db->select('*')->from('trip_expenses')->where(['te_trip_id' => $tripdetails[0]['t_id']])->order_by('te_id', 'DESC')->get()->result_array();
				$trip_includeexpensequery = $this->db->select_sum('te_amount')
                  ->where(['te_trip_id' => $tripdetails[0]['t_id'], 'te_includetocustomer' => 1])
                  ->get('trip_expenses');
				if ($trip_includeexpensequery && $trip_includeexpensequery->num_rows() > 0) {
					$data['trip_includeexpense'] = $trip_includeexpensequery->row()->te_amount;
				} else {
					$data['trip_includeexpense'] = 0; 
				}
				
				$data['email_log'] = $this->db->select('*')->from('email_log')->where(['ref_id' => $tripdetails[0]['t_id'],'module' => 'trips'])->order_by('id', 'DESC')->get()->result_array();
				$data['sms_log'] = $this->db->select('*')->from('sms_log')->where(['ref_id' => $tripdetails[0]['t_id'],'module' => 'trips'])->order_by('id', 'DESC')->get()->result_array();
				$data['customerdetails'] = (isset($customerdetails[0]['c_id']))?$customerdetails[0]:'';
				$data['driverdetails'] =  (isset($driverdetails[0]['d_id']))?$driverdetails[0]:'';
			}
			$this->template->template_render('trips_details',$data);
		} else {
			$this->template->template_render('404');
		}
	}
	public function invoice()
	{
		$data = array();
		$b_id = decodeid($this->uri->segment(3));
		$tripdetails = $this->trips_model->get_tripdetails($b_id);
		if(isset($tripdetails[0]['t_id'])) {
			$data['trip_includeexpense'] = $this->db->select('*')->where(['te_trip_id' => $tripdetails[0]['t_id'], 'te_includetocustomer' => 1])->get('trip_expenses')->result_array();
			$customerdetails = $this->customer_model->get_customerdetails($tripdetails[0]['t_customer_id']);
			$driverdetails = $this->drivers_model->get_driverdetails($tripdetails[0]['t_driver']);
			$data['paymentdetails'] = $this->trips_model->get_paymentdetails($tripdetails[0]['t_id']);
			$data['tripdetails'] = $tripdetails[0];
			$data['route'] = $this->get_routename($tripdetails[0]['t_route']);
			$data['vehiclename'] = $this->get_vehiclename($tripdetails[0]['t_vechicle']);
			$data['customerdetails'] = (isset($customerdetails[0]['c_id']))?$customerdetails[0]:'';
			$data['driverdetails'] =  (isset($driverdetails[0]['d_id']))?$driverdetails[0]:'';
		}
		$this->load->view('invoice_type'.sitedata()['s_invoice_template'],$data);
	}
	public function get_routename($rid)
	{

		$query = $this->db->where('vr_id', $rid)
                  ->get('vehicle_route');
		return $query->result_array();

	}
	public function get_vehiclename($rid)
	{
		$query = $this->db->select('v_name')->where('v_id', $rid)
                  ->get('vehicles');
		return $query->result_array();

	}
	
	public function trippayment()
	{
		$this->load->model('accounts_model');	
		$response = $this->accounts_model->add_transactions($this->input->post());
		if($response) {
			$transaction_type = $this->input->post('transaction_type');
			$current_balance = $this->accounts_model->get_balance($this->input->post('account_id'));
			if ($transaction_type === 'Credit') {
				$new_balance = $current_balance + $this->input->post('amount');
			} elseif ($transaction_type === 'Debit') {
				$new_balance = $current_balance - $this->input->post('amount');
			}
			if($new_balance) {
				$this->accounts_model->update_balance($this->input->post('account_id'), $new_balance);
			}
			$this->session->set_flashdata('successmessage', 'New '.$this->input->post('transaction_type').' added successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again');
		}
		redirect('trips/details/'.encodeId($this->input->post('trip_id')));
	}

	public function addtripexpense() 	{
		$addtripexpense = $this->input->post();
		$response =  $this->db->insert('trip_expenses',$addtripexpense);
		if($response) {
			$this->session->set_flashdata('successmessage', 'Trip expense added successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', 'Unexpected error..Try again');
		}
		redirect('trips/details/'.encodeId($this->input->post('te_trip_id')));
	}


	public function deletetrip()
	{
		$t_id = $this->input->post('del_id');
		$deleteresp = $this->db->delete('trips', array('t_id' => $t_id)); 
		if($deleteresp) {
			$this->session->set_flashdata('successmessage', 'Trip deleted successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', 'Unexpected error..Try again');
		}
		redirect('trips');
	}

	public function deletetripexpense()
	{
		$te_id = $this->input->post('del_id');
		$deleteresp = $this->db->delete('trip_expenses', array('te_id' => $te_id)); 
		if($deleteresp) {
			$this->session->set_flashdata('successmessage', 'Trip expense deleted successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', 'Unexpected error..Try again');
		}
		redirect($this->input->server('HTTP_REFERER'));
	}

	public function validate_coupon()
	{
		$coupon_code = $this->input->post('coupon_code');
		$original_amount = $this->input->post('original_amount'); // Get the original amount from the POST data

		// Query the coupon based on the provided table schema
		$this->db->where('cp_code', $coupon_code);
		$this->db->where('cp_status', 1); // Ensure the coupon is active
		$this->db->where('cp_start_date <=', date('Y-m-d')); // Check if the coupon is valid from start date
		$this->db->where('cp_end_date >=', date('Y-m-d')); // Check if the coupon is not expired
		$query = $this->db->get('coupons');

		if ($query->num_rows() > 0) {
			$coupon = $query->row();
			if ($coupon->cp_usage_limit > 0 && get_coupon_usage($coupon->cp_code) < $coupon->cp_usage_limit) {
				$discount_amount = 0;
				if ($coupon->cp_discount_method == 'percentage') {
					$discount_amount = ($original_amount * $coupon->cp_discount) / 100;
				} elseif ($coupon->cp_discount_method == 'fixed') {
					$discount_amount = $coupon->cp_discount;
				}
				$final_amount = $original_amount - $discount_amount;
				echo json_encode([
					'status' => 'success',
					'discount_method' => $coupon->cp_discount_method,
					'discount_value' => $coupon->cp_discount,
					'discount_amount' => $discount_amount,
					'final_amount' => $final_amount,
					'message' => 'Coupon applied successfully!'
				]);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Coupon usage limit reached.']);
			}
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Invalid or expired coupon code.']);
		}
	}
	public function get_sms_templates() {
		$templates = $this->db->where('st_status',1)->get('sms_template')->result_array();
		echo json_encode($templates);
	}
	public function get_email_templates() {
		$templates = $this->db->where('et_status',1)->get('email_template')->result_array();
		echo json_encode($templates);
	}
	public function customemail() {
			$this->load->model('emailsms_model');	
			$this->db->select('trips.t_bookingid, trips.t_vechicle ,trips.t_trip_fromlocation,trips.t_trackingcode,trips.t_trip_tolocation,trips.t_trip_final_amount ,trips.t_discountamount , trips.t_trackingcode , trips.t_driver, trips.t_start_date, trips.t_end_date, trips.t_totaldistance, trips.t_tripstartreading, trips.t_trip_stops, trips.t_trip_amount, trips.t_trip_status, vehicles.v_name, drivers.d_name');
			$this->db->from('trips');
			$this->db->join('vehicles', 'vehicles.v_id = trips.t_vechicle', 'left');  // Left join with vehicles table
			$this->db->join('drivers', 'drivers.d_id = trips.t_driver', 'left');        // Left join with drivers table
			$this->db->where('t_id', $_POST['t_id']);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				$trip_data = $query->row_array();  
				$pymentdetails = get_trip_payment_details($_POST['t_id']);
				$email_data = [
					'bookingid'        => $trip_data['t_bookingid'],
					'vehicle'          => $trip_data['v_name'],  // Vehicle name from vehicles table
					'driver'           => $trip_data['d_name'],   // Driver name from drivers table
					'start_date'       => $trip_data['t_start_date'],
					'end_date'         => $trip_data['t_end_date'],
					'totaldistance'    => $trip_data['t_totaldistance'],
					'tripstartreading' => $trip_data['t_tripstartreading'],
					'trip_stops'       => !empty($trip_stops = json_decode($trip_data['t_trip_stops'], true)) ? implode(", ", $trip_stops) : '',
					'trip_amount'      => $pymentdetails['totalamount'],
					'trip_status'      => $trip_data['t_trip_status'],
					'amount_due'      => $pymentdetails['pendingamount'],
					'from'      => $trip_data['t_trip_fromlocation'],
					'to'      => $trip_data['t_trip_tolocation'],
					'url'      => base_url().'/triptracking/'.$trip_data['t_trackingcode']
				];
				
				$template = $_POST['emailmessage'];
				foreach ($email_data as $key => $value) {
					$template = str_replace("{{" . $key . "}}", $value, $template);
				}
				
				$emailresp = $this->emailsms_model->sendemail($_POST['email'],$_POST['emailsubject'],$template);
				if($emailresp=='true') {
					$data = ['ref_id' => $_POST['t_id'],'module'=>'trips','content' => $_POST['emailsubject'],'status' => 1,'error_description' => null,'to_email' => $_POST['email'],'created_at'=>date('Y-m-d h:i:s')];
					$this->db->insert('email_log', $data);
					$this->session->set_flashdata('successmessage', 'Email send successfully.');
				} else {
					$data = ['ref_id' => $_POST['t_id'],'module'=>'trips','content' => $_POST['emailsubject'],'status' => 0,'error_description' => $emailresp,'to_email' => $_POST['email'],'created_at'=>date('Y-m-d h:i:s')];
					$this->db->insert('email_log', $data);
					$this->session->set_flashdata('warningmessage', 'Unexpected error..Try again');
				}
			}
		redirect($this->input->server('HTTP_REFERER'));
	}

	public function sendsms() {
		    $this->load->library('twilio');
			$this->db->select('trips.t_bookingid, trips.t_vechicle ,trips.t_trip_fromlocation,trips.t_trip_tolocation,trips.t_trip_final_amount ,trips.t_discountamount , trips.t_trackingcode , trips.t_driver, trips.t_start_date, trips.t_end_date, trips.t_totaldistance, trips.t_tripstartreading, trips.t_trip_stops, trips.t_trip_amount, trips.t_trip_status, vehicles.v_name, drivers.d_name');
			$this->db->from('trips');
			$this->db->join('vehicles', 'vehicles.v_id = trips.t_vechicle', 'left');  // Left join with vehicles table
			$this->db->join('drivers', 'drivers.d_id = trips.t_driver', 'left');        // Left join with drivers table
			$this->db->where('t_id', $_POST['t_id']);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				$trip_data = $query->row_array();  
				$pymentdetails = get_trip_payment_details($_POST['t_id']);
				$email_data = [
					'bookingid'        => $trip_data['t_bookingid'],
					'vehicle'          => $trip_data['v_name'],  // Vehicle name from vehicles table
					'driver'           => $trip_data['d_name'],   // Driver name from drivers table
					'start_date'       => $trip_data['t_start_date'],
					'end_date'         => $trip_data['t_end_date'],
					'totaldistance'    => $trip_data['t_totaldistance'],
					'tripstartreading' => $trip_data['t_tripstartreading'],
					'trip_stops'       => !empty($trip_stops = json_decode($trip_data['t_trip_stops'], true)) ? implode(", ", $trip_stops) : '',
					'trip_amount'      => $pymentdetails['totalamount'],
					'trip_status'      => $trip_data['t_trip_status'],
					'amount_due'      => $pymentdetails['pendingamount'],
					'from'      => $trip_data['t_trip_fromlocation'],
					'to'      => $trip_data['t_trip_tolocation'],
					'url'      => base_url().'/triptracking/'.$trip_data['t_trackingcode']
				];
				
				$template = $_POST['smsmessage'];
				foreach ($email_data as $key => $value) {
					$template = str_replace("{{" . $key . "}}", $value, $template);
				}
				$_POST['mobile_number'] = isset($_POST['mobile_number']) && strpos($_POST['mobile_number'], '+') !== 0 ? '+' . $_POST['mobile_number'] : $_POST['mobile_number'];
				$smsresp = $this->twilio->sendsms($_POST['mobile_number'],$template,$_POST['t_id'],'trips');
			}
		redirect($this->input->server('HTTP_REFERER'));
	}

}




