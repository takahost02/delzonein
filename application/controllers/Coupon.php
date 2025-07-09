<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('coupon_model');
        $this->load->helper(array('form', 'url','string'));
        $this->load->library('form_validation');
        $this->load->library('session');
        //Update status to inactive if expired
        $this->db->set('cp_status', 0);
        $this->db->where('cp_end_date <', date('Y-m-d')); 
        $this->db->where('cp_status', 1);
        $this->db->update('coupons');
    }

    public function index() {
        $data['coupons'] = $this->coupon_model->get_all_coupons();
        $this->template->template_render('coupons', $data);
    }

    public function create() {
        $this->template->template_render('coupons');
    }

    public function add() {
        $data = [
            'cp_code' => $this->input->post('cp_code'),
            'cp_discount' => $this->input->post('cp_discount'),
            'cp_start_date' => $this->input->post('cp_start_date'),
            'cp_end_date' => $this->input->post('cp_end_date'),
            'cp_usage_limit' => $this->input->post('cp_usage_limit'),
            'cp_discount_method' => $this->input->post('cp_discount_method'),
            'cp_status' => $this->input->post('cp_status'),
            'cp_created_at' => date('Y-m-d H:i:s'),
            'cp_updated_at' => date('Y-m-d H:i:s')
        ];
        $response = $this->coupon_model->insert_coupon($data);
        if($response) {
            $this->session->set_flashdata('successmessage', 'Coupon added successfully..');
        } else {
            $this->session->set_flashdata('warningmessage', 'Error..! Try again..');
        }
        redirect('coupon');
    }

    public function edit($cp_id) {
        $data['coupon'] = $this->coupon_model->get_coupon_by_id($cp_id);
        $this->template->template_render('coupons', $data);
    }

    public function update() {
        $cp_id = $this->input->post('cp_id');
        $data = [
            'cp_code' => $this->input->post('cp_code'),
            'cp_discount' => $this->input->post('cp_discount'),
            'cp_start_date' => $this->input->post('cp_start_date'),
            'cp_end_date' => $this->input->post('cp_end_date'),
            'cp_usage_limit' => $this->input->post('cp_usage_limit'),
            'cp_discount_method' => $this->input->post('cp_discount_method'),
            'cp_status' => $this->input->post('cp_status'),
            'cp_updated_at' => date('Y-m-d H:i:s')
        ];
        $response = $this->coupon_model->update_coupon($cp_id, $data);
        if($response) {
            $this->session->set_flashdata('successmessage', 'Coupon added successfully..');
        } else {
            $this->session->set_flashdata('warningmessage', 'Error..! Try again..');
        }
        redirect('coupon');
    }

    public function delete() {
        $cp_id = $this->input->post('del_id');
        $response = $this->coupon_model->delete_coupon($cp_id);
        if($response) {
            $this->session->set_flashdata('successmessage', 'Coupon added successfully..');
        } else {
            $this->session->set_flashdata('warningmessage', 'Error..! Try again..');
        }
        redirect('coupon');
    }
}
