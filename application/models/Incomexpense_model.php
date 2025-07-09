<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Incomexpense_model extends CI_Model{
	
	public function add_incomexpense($data) { 
		$data['ie_date'] = reformatDate($data['ie_date']);
		return	$this->db->insert('incomeexpense',$data);
	} 

    public function getall_incomexpense() { 
		$incomexpense = $this->db->select('incomeexpense.*, incomeexpense_category.*')
                         ->from('incomeexpense')
                         ->join('incomeexpense_category', 'incomeexpense.ie_cat = incomeexpense_category.ie_cat_id', 'LEFT')
                         ->order_by('incomeexpense.ie_id', 'desc')
                         ->get()
                         ->result_array();

		if(!empty($incomexpense)) {
			foreach ($incomexpense as $key => $incomexpenses) {
				$newincomexpense[$key] = $incomexpenses;
				$newincomexpense[$key]['vech_name'] =  $this->db->select('v_registration_no,v_name')->from('vehicles')->where('v_id',$incomexpenses['ie_v_id'])->get()->row();
			}
			return $newincomexpense;
		} else 
		{
			return false;
		}
	} 
	public function editincomexpense($e_id) { 
		return $this->db->select('*')->from('incomeexpense')->where('ie_id',$e_id)->get()->result_array();
	}
	public function updateincomexpense() { 
		$_POST['ie_date'] = reformatDate($_POST['ie_date']);
		$this->db->where('ie_id',$this->input->post('ie_id'));
		return $this->db->update('incomeexpense',$this->input->post());
	}
	public function getvechicle_incomexpense($v_id) { 
		return $this->db->select('*')->from('incomeexpense')->where('ie_v_id',$v_id)->order_by('ie_id','DESC')->get()->result_array();
	} 
	public function incomexpense_reports($from,$to,$v_id) { 
		$newincomexpense = array();
		if($v_id=='all') {
			$where = array('date(ie_date)>='=>$from,'date(ie_date)<='=>$to);
		} else {
			$where = array('date(ie_date)>='=>$from,'date(ie_date)<='=>$to,'ie_v_id'=>$v_id);
		}

		$incomexpense = $this->db->select('*')->from('incomeexpense')->where($where)->order_by('ie_id','desc')->get()->result_array();
		if(!empty($incomexpense)) {
			foreach ($incomexpense as $key => $incomexpenses) {
				$newincomexpense[$key] = $incomexpenses;
				$newincomexpense[$key]['vech_name'] =  $this->db->select('v_registration_no,v_name')->from('vehicles')->where('v_id',$incomexpenses['ie_v_id'])->get()->row();
			}
			return $newincomexpense;
		} else 
		{
			return array();
		}
	}
} 