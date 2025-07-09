<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fuel_model extends CI_Model{
	
	public function add_fuel($data) { 
		//unset($data['exp']);
		$data['v_fuelfilldate'] = reformatDate($data['v_fuelfilldate']);
		$id = $this->db->insert('fuel',$data);
		if ($id && isset($data['v_fuelsource']) && $data['v_fuelsource'] == 'fueltank') {
			$this->db->set('totalstock', 'totalstock - ' . (int)$data['v_fuel_quantity'], FALSE);
			$this->db->update('fuel_stock');
		}
		return $id;
	} 
    public function getall_fuel() { 
		$fuel = $this->db->select('*')->from('fuel')->order_by('v_fuel_id','desc')->get()->result_array();
		if(!empty($fuel)) {
			foreach ($fuel as $key => $fuels) {
				$newfuel[$key] = $fuels;
				$newfuel[$key]['vech_name'] =  $this->db->select('v_registration_no,v_name')->from('vehicles')->where('v_id',$fuels['v_id'])->get()->row();
				$newfuel[$key]['filled_by'] =  $this->db->select('d_name')->from('drivers')->where('d_id',$fuels['v_fueladdedby'])->get()->row();
			}
			return $newfuel;
		} else 
		{
			return false;
		}
	} 
	public function editfuel($f_id) { 
		return $this->db->select('*')->from('fuel')->where('v_fuel_id',$f_id)->get()->result_array();
	}

	public function getall_fuelvendor() { 
		return $this->db->select('*')->from('fuel_vendor')->get()->result_array();
	}
	public function updatefuel() { 
		$_POST['v_fuelfilldate'] = reformatDate($_POST['v_fuelfilldate']);
		$this->db->where('v_fuel_id',$this->input->post('v_fuel_id'));
		$success = $this->db->update('fuel',$this->input->post());
		if($success) {
			return true;
		} else {
			return false;
		}
	}
	public function fuel_reports($from,$to,$v_id) { 
		$newincomexpense = array();
		if($v_id=='all') {
			$where = array('v_fuelfilldate >='=>$from,'v_fuelfilldate<='=>$to);
		} else {
			$where = array('v_fuelfilldate >='=>$from,'v_fuelfilldate<='=>$to,'v_id'=>$v_id);
		}
		$fuel = $this->db->select('*')->from('fuel')->where($where)->order_by('v_fuel_id','desc')->get()->result_array();
		if(!empty($fuel)) {
			foreach ($fuel as $key => $fuels) {
				$newfuel[$key] = $fuels;
				$newfuel[$key]['vech_name'] =  $this->db->select('v_registration_no,v_name')->from('vehicles')->where('v_id',$fuels['v_id'])->get()->row();
				$newfuel[$key]['filled_by'] =  $this->db->select('d_name')->from('drivers')->where('d_id',$fuels['v_fueladdedby'])->get()->row();
			}
			return $newfuel;
		} else {
			return false;
		}
	} 
	public function update_stock($quantity) {
        $query = $this->db->query("SELECT totalstock FROM fuel_stock LIMIT 1");
        $result = $query->row();
        if ($result) {
            $currentStock = (int) $result->totalstock; // Ensure it's an integer
            $newStock = $currentStock + (int) $quantity;
            $this->db->update('fuel_stock', ['totalstock' => $newStock]);
        } else {
            // If no row exists, insert a new record
            $this->db->insert('fuel_stock', ['totalstock' => (int) $quantity]);
        }
    }
	public function get_fuelvendor() { 
		return $this->db->select('*')->from('fuel_vendor')->get()->result_array();
	}
	public function fuelvendor_delete($vendor_id) { 
		$this->db->where('fv_id', $vendor_id);
		$this->db->delete('fuel_vendor');
		return true;
	}
	

} 