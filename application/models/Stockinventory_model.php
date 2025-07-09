<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stockinventory_model extends CI_Model {

    public function add_stockinventory($data) { 
        return $this->db->insert('stockinventory', $data);
    }

    public function getall_stockinventory() { 
        $this->db->select("*");
        $this->db->from('stockinventory');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function deletestockinventory($s_id) { 
        $this->db->where('s_id', $s_id);
        $this->db->delete('stockinventory');
        return true;
    }

    public function get_stockdetails($s_id) { 
        $this->db->select("*");
        $this->db->from('stockinventory');
        $this->db->where('s_id', $s_id);
        $query = $this->db->get();
        return $query->result_array();
    } 
}
