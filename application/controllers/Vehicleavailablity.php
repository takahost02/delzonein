<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Vehicleavailablity extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url', 'string'));
		$this->load->library('form_validation');
		$this->load->library('session');
	}
	public function index()
	{
		$user_type = $this->session->userdata('u_user_type');
		$user_id   = $this->session->userdata('u_id');

		// Filter condition
		if ($user_type == 'driver') {
			$this->db->select('trips.t_vechicle');
			$this->db->from('trips');
			$this->db->where('trips.t_driver', $user_id);
			$vehicle_ids = array_column($this->db->get()->result_array(), 't_vechicle');
		} elseif ($user_type == 'vendor') {
			$this->db->select("v_id");
			$this->db->from("vehicles");
			$this->db->where("v_vendor_name", $user_id);
			$veh_res = $this->db->get()->result_array();
			$vehicle_ids = array_column($veh_res, 'v_id');
		} else {
			$vehicle_ids = [];
		}

		// Trips
		$this->db->select("date(trips.t_start_date) as start,date(trips.t_end_date) as end,trips.t_trip_fromlocation,trips.t_trip_tolocation,CONCAT(vehicles.v_registration_no, '-', vehicles.v_name) as title,'green' as color");
		$this->db->from('trips');
		$this->db->join('vehicles', 'trips.t_vechicle=vehicles.v_id');

		if (!empty($vehicle_ids)) {
			$this->db->where_in('vehicles.v_id', $vehicle_ids);
		}

		$query = $this->db->get();
		$vechdata = $query->result_array();

		$newdata = array();
		if (!empty($vechdata)) {
			foreach ($vechdata as $key => $vdata) {
				$newdata[$key] = $vdata;
				$newdata[$key]['title'] = $vdata['title'] . ' [' . $vdata['t_trip_fromlocation'] . ' to ' . $vdata['t_trip_tolocation'] . '] ';
				unset($newdata[$key]['t_trip_fromlocation']);
				unset($newdata[$key]['t_trip_tolocation']);
			}
			$trips = $newdata;
		} else {
			$trips = array();
		}

		// Maintenance
		$this->db->select("date(vm.m_start_date) as start,date(vm.m_end_date) as end,CONCAT(vehicles.v_registration_no, '-', vehicles.v_name) as title,'red' as color,vm.m_service_info");
		$this->db->from('vehicle_maintenance vm');
		$this->db->join('vehicles', 'vm.m_v_id=vehicles.v_id');

		if (!empty($vehicle_ids)) {
			$this->db->where_in('vehicles.v_id', $vehicle_ids);
		}

		$query = $this->db->get();
		$vmresult = $query->result_array();

		if (!empty($vmresult)) {
			foreach ($vmresult as $keys => $vm) {
				$vmnewdata[$keys] = $vm;
				$vmnewdata[$keys]['title'] = 'Maintenance : ' . $vm['title'] . ' [' . $vm['m_service_info'] . '] ';
				unset($vmnewdata[$keys]['m_service_info']);
			}

			$vehicle_maintenance = $vmnewdata;
		} else {
			$vehicle_maintenance = array();
		}

		$data['vechavail'] = array_merge($trips, $vehicle_maintenance);
		$this->template->template_render('vehicle_availability', $data);
	}
}
