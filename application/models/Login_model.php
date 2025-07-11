<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function check_login($data) {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        // 1. Try login from `login` table
        $this->db->where('u_username', $username);
        $this->db->where('u_password', $password);
        $query = $this->db->get("login");

        if ($query->num_rows() >= 1) {
            $user = $query->row_array();
            $user['user_type'] = 'admin'; // or internal staff
            return $user;
        }

        // 2. Try login from `drivers` table
        $this->db->where('d_email', $username);
        $this->db->where('d_password', $password);
        $query = $this->db->get("drivers");

        if ($query->num_rows() >= 1) {
            $user = $query->row_array();
            $user['user_type'] = 'driver';
            return $user;
        }

        // 3. Try login from `vehicle_vendors` table
        $this->db->where('vn_email', $username);
        $this->db->where('vn_password', $password);
        $query = $this->db->get("vehicle_vendors");

        if ($query->num_rows() >= 1) {
            $user = $query->row_array();
            $user['user_type'] = 'vendor';
            return $user;
        }

        // Login failed
        return false;
    }

    public function userroles($u_id) { 
        $userroles = $this->db->select('*')->from('login_roles')->where('lr_u_id', $u_id)->get()->result_array();
        if (!empty($userroles)) {
            return $userroles[0];
        } else {
            return array();
        }
    }
}
