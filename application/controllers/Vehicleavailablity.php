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
		$session_data = $this->session->userdata('session_data');
		$user_type = $session_data['user_type'] ?? null;
		$user_id   = $session_data['u_id'] ?? null;

		$vehicle_ids = [];

		// Determine accessible vehicle IDs based on user type
		if ($user_type == 'driver') {
			$this->db->select('t_vechicle');
			$this->db->from('trips');
			$this->db->where('t_driver', $user_id);
			$vehicle_ids = array_column($this->db->get()->result_array(), 't_vechicle');
		} elseif ($user_type == 'vendor') {
			// Get vehicle IDs owned by vendor
			$this->db->select('v_id');
			$this->db->from('vehicles');
			$this->db->where('v_vendor_name', $user_id);
			$vehicle_ids = array_column($this->db->get()->result_array(), 'v_id');
		}

		// ---- Trips ----
		$this->db->select("DATE(trips.t_start_date) AS start, DATE(trips.t_end_date) AS end, trips.t_trip_fromlocation, trips.t_trip_tolocation, CONCAT(vehicles.v_registration_no, '-', vehicles.v_name) AS title, 'green' AS color");
		$this->db->from('trips');
		$this->db->join('vehicles', 'trips.t_vechicle = vehicles.v_id');

		// Filter by accessible vehicles
		if (!empty($vehicle_ids)) {
			$this->db->where_in('trips.t_vechicle', $vehicle_ids);
		}

		// Extra filter for driver
		// if ($user_type == 'driver') {
		// 	$this->db->where('trips.t_driver', $user_id);
		// }

		$query = $this->db->get();
		$vechdata = $query->result_array();

		$trips = [];
		if (!empty($vechdata)) {
			foreach ($vechdata as $key => $vdata) {
				$trips[$key] = $vdata;
				$trips[$key]['title'] = $vdata['title'] . ' [' . $vdata['t_trip_fromlocation'] . ' to ' . $vdata['t_trip_tolocation'] . ']';
				unset($trips[$key]['t_trip_fromlocation'], $trips[$key]['t_trip_tolocation']);
			}
		}

		// ---- Vehicle Maintenance ----
		$this->db->select("DATE(vm.m_start_date) AS start, DATE(vm.m_end_date) AS end, CONCAT(vehicles.v_registration_no, '-', vehicles.v_name) AS title, 'red' AS color, vm.m_service_info");
		$this->db->from('vehicle_maintenance vm');
		$this->db->join('vehicles', 'vm.m_v_id = vehicles.v_id');

		// Filter by accessible vehicles
		if (!empty($vehicle_ids)) {
			$this->db->where_in('vm.m_v_id', $vehicle_ids);
		}

		$query = $this->db->get();
		$vmresult = $query->result_array();

		$vehicle_maintenance = [];
		if (!empty($vmresult)) {
			foreach ($vmresult as $key => $vm) {
				$vehicle_maintenance[$key] = $vm;
				$vehicle_maintenance[$key]['title'] = 'Maintenance: ' . $vm['title'] . ' [' . $vm['m_service_info'] . ']';
				unset($vehicle_maintenance[$key]['m_service_info']);
			}
		}

		// Merge trips and maintenance
		$data['vechavail'] = array_merge($trips, $vehicle_maintenance);
		$this->template->template_render('vehicle_availability', $data);
	}
}
