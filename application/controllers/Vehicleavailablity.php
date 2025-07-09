<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vehicleavailablity extends CI_Controller {
	function __construct()
    {
          parent::__construct();
          $this->load->database();
          $this->load->helper(array('form', 'url','string'));
          $this->load->library('form_validation');
          $this->load->library('session');
    }
	public function index()
	{
		$this->db->select("date(trips.t_start_date) as start,date(trips.t_end_date) as end,trips.t_trip_fromlocation,trips.t_trip_tolocation,CONCAT(vehicles.v_registration_no, '-', vehicles.v_name) as title,'green' as color");
	    $this->db->from('trips');
	    $this->db->join('vehicles', 'trips.t_vechicle=vehicles.v_id');
	    $query = $this->db->get();
	    $vechdata = $query->result_array();
		$newdata = array('');
        if (!empty($vechdata)) {
			foreach ($vechdata as $key => $vdata) {
                $newdata[$key] = $vdata;
				$newdata[$key]['title'] = $vdata['title'].' ['.$newdata[$key]['t_trip_fromlocation'].' to '.$newdata[$key]['t_trip_tolocation'].'] ';
				unset($newdata[$key]['t_trip_fromlocation']); unset($newdata[$key]['t_trip_tolocation']);
            }
            $trips = $newdata;
        } else {
            $trips = array();
        }
		
		$this->db->select("date(vm.m_start_date) as start,date(vm.m_end_date) as end,CONCAT(vehicles.v_registration_no, '-', vehicles.v_name) as title,'red' as color,vm.m_service_info");
	    $this->db->from('vehicle_maintenance vm');
	    $this->db->join('vehicles', 'vm.m_v_id=vehicles.v_id');
	    $query = $this->db->get();
	    $vmresult = $query->result_array();
		
		if(!empty($vmresult)) {
			foreach ($vmresult as $keys => $vm) {
                $vmnewdata[$keys] = $vm;
				$vmnewdata[$keys]['title'] = 'Maintenance : '.$vm['title'].' ['.$vm['m_service_info'].'] ';
				unset($vmnewdata[$keys]['m_service_info']);
            }
			
			$vehicle_maintenance = $vmnewdata;
		} else {
			$vehicle_maintenance = array();
		}
		$data['vechavail'] = array_merge($trips, $vehicle_maintenance);
		$this->template->template_render('vehicle_availability',$data);
	}
	
}
