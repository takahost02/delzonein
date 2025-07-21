<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vehiclevendors_model extends CI_Model
{

    public function add_vehiclevendors($data)
    {
        if (!empty($_FILES)) {
            $config['upload_path'] = 'assets/uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|docx';
            $this->load->library('upload', $config);

            if (!empty($_FILES['file']['name'][0])) {
                $this->upload->initialize($config);
                $_FILES['file']['name']     = $_FILES['file']['name'];
                $_FILES['file']['type']     = $_FILES['file']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['file']['tmp_name'];
                $_FILES['file']['error']    = $_FILES['file']['error'];  // fixed from $_FILES['file1']
                $_FILES['file']['size']     = $_FILES['file']['size'];

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();
                    $data['vn_file'] = $uploadData['file_name'];
                }
            }
        }

        if (!empty($data['vn_doj'])) {
            $data['vn_doj'] = reformatDate($data['vn_doj']);
        }

        // Hash password only if not already md5
        if (!empty($data['vn_password']) && !preg_match('/^[a-f0-9]{32}$/i', $data['vn_password'])) {
            $data['vn_password'] = md5($data['vn_password']);
        }

        return $this->db->insert('vehicle_vendors', $data);
    }


    public function getall_vehiclevendors()
    {
        return $this->db->select('*')->from('vehicle_vendors')->order_by('vn_id', 'desc')->get()->result_array();
    }

    public function getall_activevehiclevendors()
    {
        return $this->db->select('*')->from('vehicle_vendors')->where('vn_is_active', 1)->order_by('vn_id', 'desc')->get()->result_array();
    }

    public function get_vehiclevendordetails($vn_id)
    {
        return $this->db->select('*')->from('vehicle_vendors')->where('vn_id', $vn_id)->get()->result_array();
    }

    public function edit_vehiclevendor($data)
    {
        if (isset($data['vn_id'])) {
            $this->db->where('vn_id', $data['vn_id']);
            unset($data['vn_id']); // prevent updating the ID field
            return $this->db->update('vehicle_vendors', $data);
        }
        return false;
    }
}
