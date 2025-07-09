<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Geofence extends CI_Controller {

	 function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->load->helper('url');
          $this->load->library('session');
          $this->load->model('geofence_model');
          $this->load->model('vehicle_model');
     }

	public function index()
	{
		$geodata = array();
		$geofencelist = $this->geofence_model->getall_geofence();
		if(!empty($geofencelist)) {
			foreach($geofencelist as $key=> $geofencelists) {
				$geodata[$key] = $geofencelists;
				$geodata[$key]['geo_vehiclename'] = $this->getvehiclename($geofencelists['geo_vehicles']);
			}
		}
		$data['geofencelist'] = $geodata;
		$this->template->template_render('geofence',$data);
	}
	public function getvehiclename($geo_vehicles) {
		$name = array();
		$geo_vehicles = explode(',',$geo_vehicles);
		if(!empty($geo_vehicles)) {
		    foreach($geo_vehicles as $value)
		    {
		        $data = $this->db->select('v_name')->from('vehicles')->where('v_id',$value)->get()->result_array();
		        if(isset($data[0]['v_name'])) { 
		        	$name[] = $data[0]['v_name'];
		    	}
		    }
		}
		return implode(', ',$name);
	}
	public function geofence_save()
	{
		$response = $this->geofence_model->add_geofence($this->input->post());
		if($response) {
			$this->session->set_flashdata('successmessage', 'Geofence added successfully..');
		    redirect('geofence');
		} else {
			$this->session->set_flashdata('warningmessage', 'Failed to insert geofence..Try again.');
		    redirect('geofence');
		}
	}
	public function addgeofence()
	{
		$data['vehicles'] = $this->vehicle_model->getall_vehicle();
		$this->template->template_render('geofence_add',$data);
	}
	public function geofence_get()
	{
		$geo_id = $_POST['id'];
		$geofence = $this->geofence_model->get_geofence($geo_id);
		if(isset($geofence[0]['geo_id'])) {
			$lastgeo = explode(" ,",$geofence[0]['geo_area']);
			$geofenceval = $geofence[0]['geo_area'].$lastgeo[0];
			$geo_area = array_filter(explode(" , ",$geofenceval));
			echo json_encode($geo_area);
		} else {
			echo 'false';
		}
	}
	public function geofencedelete()
	{
		$v_id = $this->input->post('del_id');
		$deleteresp = $this->db->delete('geofences', array('geo_id' => $v_id)); 
		if($deleteresp) {
			$this->session->set_flashdata('successmessage', 'Geofence deleted successfully..');
		    redirect('geofence');
		} else {
			$this->session->set_flashdata('warningmessage', 'Failed to delete geofence.Try again.');
		    redirect('geofence');
		}
	}
	public function geofenceevents()
	{
		$returndata = array();
		$geofenceevents = $this->geofence_model->get_geofenceevents();
		if(!empty($geofenceevents)) {
		    foreach($geofenceevents as $key=> $geeodata)
		    {
		        $data = $this->db->select('geo_name')->from('geofences')->where('geo_id',$geeodata['ge_geo_id'])->get()->result_array();
		        if(isset($data[0]['geo_name'])) {
		            $returndata[] = $geeodata;
		        	$returndata[$key]['geo_name'] = $data[0]['geo_name'];
		    	}
		    }
		}
		$data['geofenceevents']=$returndata;
		$this->template->template_render('geofence_events',$data);
	}
	public function get_geofence_events() {
        $geo_id = $this->input->get('geo_id');
		$this->db->select('geofence_events.ge_id, geofence_events.ge_v_id, geofence_events.ge_geo_id, geofence_events.ge_event, geofence_events.ge_timestamp, vehicles.v_name, geofences.geo_name');
		$this->db->from('geofence_events');
		$this->db->join('geofences', 'geofences.geo_id = geofence_events.ge_geo_id', 'left'); 
		$this->db->join('vehicles', 'vehicles.v_id = geofence_events.ge_v_id', 'left'); 
		$this->db->where('geofence_events.ge_geo_id', $geo_id); 
		$query = $this->db->get();
        if ($query->num_rows() > 0) {
            echo json_encode($query->result_array());
        } else {
            echo json_encode([]);
        }
    }
}
