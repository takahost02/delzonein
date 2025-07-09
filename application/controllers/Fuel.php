<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fuel extends CI_Controller {

	 function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->load->model('fuel_model');
          $this->load->helper(array('form', 'url','string'));
          $this->load->library('form_validation');
          $this->load->library('session');

     }

	public function index()
	{
		$data['fuel'] = $this->fuel_model->getall_fuel();
		$this->template->template_render('fuel',$data);
	}
	public function addfuel()
	{
		$this->load->model('trips_model');
		$data['fuelvendor'] = $this->fuel_model->getall_fuelvendor();
		$data['driverlist'] = $this->trips_model->getall_driverlist();
		$data['vechiclelist'] = $this->trips_model->getall_vechicle();
		$this->template->template_render('fuel_add',$data);
	}
	public function insertfuel()
	{
		$testxss = xssclean($_POST);
		if($testxss){
			$response = $this->fuel_model->add_fuel($this->input->post());
			if($response) {
					// $result = $this->db->get_where('incomeexpense_category', ['ie_cat_name' => 'Fuel'])->row();
					// if(!empty($result)) {
					// 		$addincome = array('ie_cat'=>$result->ie_cat_id,'ie_v_id'=>$this->input->post('v_id'),'ie_date'=>date('Y-m-d'),'ie_type'=>'expense','ie_description'=>'Added fuel - '.$this->input->post('v_fuelcomments'),'ie_amount'=>$this->input->post('v_fuelprice'),'ie_created_date'=>date('Y-m-d'));
					// 		$this->db->insert('incomeexpense',$addincome);
					// } else {
					// 	$this->session->set_flashdata('warningmessage', 'Fuel details added successfully but failed to add in expense due to Fuel cateogry not found.');
					// 	redirect('fuel');
					// }
				$this->session->set_flashdata('successmessage', 'Fuel details added successfully..');
			} else {
				$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again');
			}
			redirect('fuel');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error! Your input are not allowed.Please try again');
			redirect('fuel');
		}
	}
	public function editfuel()
	{
		$f_id = $this->uri->segment(3);
		$this->load->model('trips_model');
		$data['fuelvendor'] = $this->fuel_model->getall_fuelvendor();
		$data['vechiclelist'] = $this->trips_model->getall_vechicle();
		$data['driverlist'] = $this->trips_model->getall_driverlist();
		$data['fueldetails'] = $this->fuel_model->editfuel($f_id);
		$this->template->template_render('fuel_add',$data);
	}

	public function updatefuel()
	{
		$testxss = xssclean($_POST);
		if($testxss){
			$response = $this->fuel_model->updatefuel($this->input->post());
			if($response) {
				$this->session->set_flashdata('successmessage', 'Fuel details updated successfully..');
			    redirect('fuel');
			} else
			{
				$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again');
			    redirect('fuel');
			}
		} else {
			$this->session->set_flashdata('warningmessage', 'Error! Your input are not allowed.Please try again');
			redirect('fuel');
		}
	}
	public function deletefuel()
	{
		$v_fuel_id = $this->input->post('del_id');
		$deleteresp = $this->db->delete('fuel', array('v_fuel_id' => $v_fuel_id)); 
		if($deleteresp) {
			$this->session->set_flashdata('successmessage', 'Fuel deleted successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', 'Unexpected error..Try again');
		}
		redirect('fuel');
	}

	public function update_stock() {
        $stockQuantity = $this->input->post('stockQuantity');
        if(is_numeric($stockQuantity) && $stockQuantity > 0) {
            $this->fuel_model->update_stock($stockQuantity);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
    public function get_current_stock() {
        $query = $this->db->query("SELECT totalstock FROM fuel_stock LIMIT 1");
        $result = $query->row();
        if ($result) {
            echo $result->totalstock;
        } else {
            echo "0";
        }
    }
	public function fuelvendor()
	{
		$data['fuelvendor'] = $this->fuel_model->get_fuelvendor();
		$this->template->template_render('fuel_vendor', $data);
	}

	public function fuelvendor_delete()
	{
		$vendor_id = $this->uri->segment(3);
		$returndata = $this->fuel_model->fuelvendor_delete($vendor_id);
		if ($returndata) {
			$this->session->set_flashdata('successmessage', 'Vendor deleted successfully.');
			redirect('fuel/fuelvendor');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error..! Some vehicles are mapped with this vendor. Please remove them from vehicle management.');
			redirect('fuel/fuelvendor');
		}
	}

	public function addfuelvendor()
	{
		$response = $this->db->insert('fuel_vendor', $this->input->post());
		if ($response) {
			$this->session->set_flashdata('successmessage', 'Vendor added successfully.');
			redirect('fuel/fuelvendor');
		} else {
			$this->session->set_flashdata('warningmessage', 'Something went wrong.. Try again.');
			redirect('fuel/fuelvendor');
		}
	}


}
