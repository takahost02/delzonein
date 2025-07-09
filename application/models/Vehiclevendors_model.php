<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehiclevendors_model extends CI_Model{
    
    public function add_vehiclevendors($data) {
        if(!empty($_FILES)) {
            $config['upload_path'] = 'assets/uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|docx'; 
            $this->load->library('upload', $config); 
            if(!empty($_FILES['file']['name'][0])){ 
                $uploadData = '';
                $this->upload->initialize($config); 
                $_FILES['file']['name']     = $_FILES['file']['name']; 
                $_FILES['file']['type']     = $_FILES['file']['type']; 
                $_FILES['file']['tmp_name'] = $_FILES['file']['tmp_name']; 
                $_FILES['file']['error']     = $_FILES['file1']['error']; 
                $_FILES['file']['size']     = $_FILES['file']['size']; 
                if($this->upload->do_upload('file')){ 
                    $uploadData = $this->upload->data();
                    $data['vn_file'] = $uploadData['file_name'];
                }
            } 
        }
		
		if($data['vn_doj']!='') {
        	$data['vn_doj'] = reformatDate($data['vn_doj']);
		}
        return $this->db->insert('vehicle_vendors', $data);
    } 

    public function getall_vehiclevendors() {
        return $this->db->select('*')->from('vehicle_vendors')->order_by('vn_id', 'desc')->get()->result_array();
    } 

    public function getall_activevehiclevendors() {
        return $this->db->select('*')->from('vehicle_vendors')->where('vn_is_active', 1)->order_by('vn_id', 'desc')->get()->result_array();
    } 

    public function get_vehiclevendordetails($vn_id) {
        return $this->db->select('*')->from('vehicle_vendors')->where('vn_id', $vn_id)->get()->result_array();
    } 

    public function edit_vehiclevendor() {
        if(!empty($_FILES)) {
            $config['upload_path'] = 'assets/uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|docx'; 
            $this->load->library('upload', $config); 
            if(!empty($_FILES['file']['name'][0])){ 
                $uploadData = '';
                $this->upload->initialize($config); 
                $_FILES['file']['name']     = $_FILES['file']['name']; 
                $_FILES['file']['type']     = $_FILES['file']['type']; 
                $_FILES['file']['tmp_name'] = $_FILES['file']['tmp_name']; 
                $_FILES['file']['error']     = $_FILES['file']['error']; 
                $_FILES['file']['size']     = $_FILES['file']['size']; 
                if($this->upload->do_upload('file')){ 
                    $uploadData = $this->upload->data();
                    $_POST['vn_file'] = $uploadData['file_name'];
                }
            } 
        }
       
        $_POST['vn_doj'] = reformatDate($_POST['vn_doj']);
        $this->db->where('vn_id', $this->input->post('vn_id'));
        return $this->db->update('vehicle_vendors', $this->input->post());
    }
}