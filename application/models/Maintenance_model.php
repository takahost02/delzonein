<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance_model extends CI_Model{
	
	public function add_maintenance($data) { 
		$data['m_start_date'] = reformatDate($data['m_start_date']); 
		$data['m_end_date'] = reformatDate($data['m_end_date']); 
		return	$this->db->insert('vehicle_maintenance',$data);
	} 
    public function getall_maintenance() { 
		$this->db->select("vehicle_maintenance.*, vehicles.v_name, vehicle_maintenance_vendor.mv_name, vehicle_maintenance_mechanic.mm_name");
		$this->db->from('vehicle_maintenance');
		$this->db->join('vehicles', 'vehicle_maintenance.m_v_id = vehicles.v_id', 'LEFT');
		$this->db->join('vehicle_maintenance_vendor', 'vehicle_maintenance.m_vendor_id = vehicle_maintenance_vendor.mv_id', 'LEFT');
		$this->db->join('vehicle_maintenance_mechanic', 'vehicle_maintenance.m_mechanic_id = vehicle_maintenance_mechanic.mm_id', 'LEFT');
		$this->db->order_by('m_id', 'desc');
		$query = $this->db->get();
		$all_maintenance = $query->result_array();
		if (!empty($all_maintenance)) {
			foreach ($all_maintenance as $key => $am) {
				$newdata[$key] = $am;
				if (!empty($am)) {
					$this->db->select("vehicle_maintenance_parts_used.pu_qty, stockinventory.s_name");
					$this->db->from('vehicle_maintenance_parts_used');
					$this->db->join('stockinventory', 'vehicle_maintenance_parts_used.pu_s_id = stockinventory.s_id', 'LEFT');
					$this->db->where('pu_m_id', $am['m_id']);
					$query = $this->db->get();
					$partsused = $query->result_array();
					$newdata[$key]['partsused'] = $partsused;
				} else {
					$newdata[$key]['partsused'] = '';
				}
			}
			return $newdata;
		}
	}
	
	public function deletemaintenance($r_id) { 
		$this->db->where('m_id', $r_id);
    	$this->db->delete('vehicle_maintenance');
    	return true;
    }
	public function get_mechanic()
    {
        $query = $this->db->get('vehicle_maintenance_mechanic');
        return $query->result_array();
    }
    public function mechanic_delete($mech_id)
    {
        $this->db->where('mm_id', $mech_id);
        return $this->db->delete('vehicle_maintenance_mechanic');
    }
    public function add_mechanic($data)
    {
        return $this->db->insert('vehicle_maintenance_mechanic', $data);
    }
	public function update_mechanic($mm_id, $data) {
		$this->db->where('mm_id', $mm_id);
		return $this->db->update('vehicle_maintenance_mechanic', $data);
	}

	public function get_maintenance_vendor() {
		$this->db->order_by('mv_id', 'DESC');
        $query = $this->db->get('vehicle_maintenance_vendor');
        return $query->result_array();
    }
    public function maintenance_vendor_delete($mv_id) {
        $this->db->where('mv_id', $mv_id);
        return $this->db->delete('vehicle_maintenance_vendor');
    }
    public function add_maintenance_vendor($data) {
        return $this->db->insert('vehicle_maintenance_vendor', $data);
    }
    public function update_maintenance_vendor($mv_id, $data) {
        $this->db->where('mv_id', $mv_id);
        return $this->db->update('vehicle_maintenance_vendor', $data);
    }
	
} 