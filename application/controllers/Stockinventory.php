<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stockinventory extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('stockinventory_model');
        $this->load->helper(array('form', 'url', 'string'));
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        $data['stockinventorylist'] = $this->stockinventory_model->getall_stockinventory();
        $this->template->template_render('stockinventory_management', $data);
    }

    public function addstockinventory() {
        $this->template->template_render('stockinventory_add');
    }

    public function insertstockinventory() {
        $testxss = xssclean($_POST);
        if ($testxss) {
            $response = $this->stockinventory_model->add_stockinventory($this->input->post());
            if ($response) {
                $this->session->set_flashdata('successmessage', 'New stockinventory added successfully.');
            } else {
                $this->session->set_flashdata('warningmessage', validation_errors());
            }
            redirect('stockinventory');
        } else {
            $this->session->set_flashdata('warningmessage', 'Error! Your input is not allowed. Please try again.');
            redirect('stockinventory');
        }
    }

    public function editstock() {
        $s_id = $this->uri->segment(3);
        $data['stockdetails'] = $this->stockinventory_model->get_stockdetails($s_id);
        $this->template->template_render('stockinventory_add', $data);
    }

    public function updatestockinventory() {   
        $this->db->where('s_id', $this->input->post('s_id'));
        $response = $this->db->update('stockinventory', $this->input->post());
        if ($response) {
            $this->session->set_flashdata('successmessage', 'Stockinventory updated successfully.');
        } else {
            $this->session->set_flashdata('warningmessage', validation_errors());
        }
        redirect('stockinventory');
    }

    public function deletestockinventory() {
        $s_id = $_POST['del_id'];
        $returndata = $this->stockinventory_model->deletestockinventory($s_id);
        if ($returndata) {
            $this->session->set_flashdata('successmessage', 'Stockinventory deleted successfully.');
        } else {
            $this->session->set_flashdata('warningmessage', 'Error..! Try again.');
        }
        redirect('stockinventory');
    }

    public function addstock() {   
        $stock_id = $this->input->post('s_id');
        $new_value = $this->input->post('sh_stock');

        $this->db->select('s_stock');
        $this->db->from('stockinventory');
        $this->db->where('s_id', $stock_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $existing_value = $row->s_stock;
            $updated_value = $existing_value + $new_value;
            $this->db->set('s_stock', $updated_value);
            $this->db->where('s_id', $stock_id);
            $this->db->update('stockinventory');
            $_POST['sh_s_id'] = $_POST['s_id'];
            unset($_POST['s_id']);
            $this->db->insert('stockinventory_history',$_POST);
            
            $this->session->set_flashdata('successmessage', 'Stock updated successfully.');
        } else {
            $this->session->set_flashdata('warningmessage', 'Error..! Try again.');
        }
        redirect('stockinventory');
    }
    public function purchasehistory($s_id='') {
        $this->db->select('sh.*, si.s_name');
        $this->db->from('stockinventory_history as sh');
        $this->db->join('stockinventory as si', 'sh.sh_s_id = si.s_id', 'left'); 
        if(isset($s_id) && $s_id!='') {
            $this->db->where('sh.sh_s_id', $s_id); 
        }
        $query = $this->db->get();
       
        $data['stockinventorylist'] = (!empty($query->result_array()))?$query->result_array():array();
        
        $this->template->template_render('stockinventory_purchasehistory', $data);
    }

}
