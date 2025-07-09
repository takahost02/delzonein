<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reminder_model extends CI_Model{
	
	public function add_reminder($data) { 
		$data['r_date'] = reformatDate($data['r_date']); 
		$data['r_services'] = implode(",", $data['r_services']);
		return	$this->db->insert('reminder',$data);
	} 
    public function getall_reminder() { 
		$this->db->select("reminder.*, vehicles.v_name");
		$this->db->from('reminder');
		$this->db->join('vehicles', 'reminder.r_v_id = vehicles.v_id', 'LEFT');
		$this->db->order_by('r_v_id', 'desc');
		$query = $this->db->get();
		$reminder_data = $query->result_array();
		foreach ($reminder_data as &$reminder) {
			$services_str = $reminder['r_services'] ?? '';
			$services = $services_str ? explode(',', $services_str) : [];
			if (!empty($services)) {
				$this->db->select('rs_name');
				$this->db->from('reminder_services');
				$this->db->where_in('rs_id', $services);
				$query = $this->db->get();
				$service_data = $query->result_array();
			} else {
				$service_data = [];
			}
			$reminder['services'] = $service_data;
		}
		return $reminder_data;
	} 
	public function deletereminder($r_id) { 
		$this->db->where('r_id', $r_id);
    	$this->db->delete('reminder');
    	return true;
    }
	
} 