<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Fetch all coupons
    public function get_all_coupons() {
        return $this->db->get('coupons')->result_array();
    }
    
    // Fetch a single coupon by ID
    public function get_coupon_by_id($cp_id) {
        return $this->db->get_where('coupons', ['cp_id' => $cp_id])->row_array();
    }
    
    // Insert a new coupon
    public function insert_coupon($data) {
        return $this->db->insert('coupons', $data);
    }
    
    // Update an existing coupon
    public function update_coupon($cp_id, $data) {
        $this->db->where('cp_id', $cp_id);
        return $this->db->update('coupons', $data);
    }
    
    // Delete a coupon
    public function delete_coupon($cp_id) {
        $this->db->where('cp_id', $cp_id);
        return $this->db->delete('coupons');
    }
}
