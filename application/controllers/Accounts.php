<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('accounts_model');
        $this->load->helper(array('form', 'url', 'string'));
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        $data['accountslist'] = $this->accounts_model->getall_accounts();
        $this->template->template_render('accounts_management', $data);
    }
    public function add() { 
		$this->db->insert('ac_accounts',$_POST);
        redirect('accounts');
	} 
    public function update() { 
		$this->db->where('id',$this->input->post('id'));
	    $this->db->update('ac_accounts',$this->input->post());
        redirect('accounts');
	}
    public function transactions() {
		$this->load->model('trips_model');
		$data['vechiclelist'] = $this->trips_model->getall_vechicle();
		$data['cat'] = $this->db->select('*')->from('ac_transactions_category')->get()->result_array();
        $data['accountlist'] = $this->db->select('id,account_name')->from('ac_accounts')->get()->result_array();
        $data['transactionslist'] = $this->accounts_model->getall_transactions();
		
        $this->template->template_render('accounts_transactions', $data);
    }
    public function addtransactions()
	{
		$this->load->model('trips_model');
		$data['vechiclelist'] = $this->trips_model->getall_vechicle();
		$data['cat'] = $this->db->select('*')->from('ac_transactions_category')->get()->result_array();
        $data['account'] = $this->db->select('id,account_name')->from('ac_accounts')->get()->result_array();
		$this->template->template_render('accounts_transactions_add',$data);
	}
	public function inserttransactions()
	{
		$testxss = xssclean($_POST);
		if($testxss){
			$response = $this->accounts_model->add_transactions($this->input->post());
			if($response) {
				$transaction_type = $this->input->post('transaction_type');
				$current_balance = $this->accounts_model->get_balance($this->input->post('account_id'));
				if ($transaction_type === 'Credit') {
					$new_balance = $current_balance + $this->input->post('amount');
				} elseif ($transaction_type === 'Debit') {
					$new_balance = $current_balance - $this->input->post('amount');
				}
				if($new_balance) {
					$this->accounts_model->update_balance($this->input->post('account_id'), $new_balance);
				}
				$this->session->set_flashdata('successmessage', 'New '.$this->input->post('transaction_type').' added successfully..');
			} else {
				$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again');
			}
			redirect('accounts/transactions');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error! Your input are not allowed.Please try again');
			redirect('accounts/transactions');
		}
	}
	public function edittransactions()
	{
		$this->load->model('trips_model');
		$data['cat'] = $this->db->select('*')->from('ac_transactions_category')->get()->result_array();
		$data['vechiclelist'] = $this->trips_model->getall_vechicle();
		$e_id = $this->uri->segment(3);
		$data['transactionsdetails'] = $this->accounts_model->edittransactions($e_id);
		$this->template->template_render('accounts_transactions_add',$data);
	}

	
	public function deletetransactions()
	{
		$ie_id = $this->input->post('del_id');
		$this->db->where('id', $ie_id);
        $transaction = $this->db->get('ac_transactions')->row();
		$deleteresp = $this->db->delete('ac_transactions', array('id' => $ie_id)); 
		if($deleteresp) {
			$this->update_account_balance($transaction);
			$this->session->set_flashdata('successmessage', 'Record deleted successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', 'Unexpected error..Try again');
		}
		redirect($this->input->server('HTTP_REFERER'));
	}

	private function update_account_balance($transaction) {
        $amount = $transaction->amount;
        $account_id = $transaction->account_id;
        if ($transaction->transaction_type === 'Credit') {
            $this->db->set('balance', 'balance - ' . $amount, FALSE);
        } else if ($transaction->transaction_type === 'Debit') {
            $this->db->set('balance', 'balance + ' . $amount, FALSE);
        }
        $this->db->where('id', $account_id);
        $this->db->update('ac_accounts');
    }

	public function category()
	{
		$data['categories'] = $this->db->select('*')->from('ac_transactions_category')->get()->result_array();
		$this->template->template_render('accounts_transactions_category', $data);
	}

	public function category_delete()
	{
		$t_id = $this->input->post('del_id');
		$deleteresp = $this->db->delete('ac_transactions_category', array('t_cat_id' => $t_id)); 
		if ($deleteresp) {
			$this->session->set_flashdata('successmessage', 'Category deleted successfully.');
			redirect('accounts/category');
		} else {
			$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again.');
			redirect('accounts/category');
		}
	}

	public function addcategory()
	{
		$response = $this->db->insert('ac_transactions_category', $this->input->post());
		if ($response) {
			$this->session->set_flashdata('successmessage', 'Category added successfully.');
			redirect('accounts/category');
		} else {
			$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again.');
			redirect('accounts/category');
		}
	}
	public function transfers()
	{
		$data['accounts'] = $this->accounts_model->getall_accounts();
        $this->template->template_render('accounts_transfers', $data);
	}
    public function execute_transfer() {
        $from_account_id = $this->input->post('from_account');
		$amount = $this->input->post('amount');
		$to_account_id = $this->input->post('to_account');
		$to_account = $this->db->get_where('ac_accounts', ['id' => $to_account_id])->row();
		if($from_account_id!='') {
			$from_account = $this->db->get_where('ac_accounts', ['id' => $from_account_id])->row();
			if ($from_account && $to_account && $from_account->balance >= $amount) {
				$this->accounts_model->update_balance($from_account_id, $from_account->balance - $amount);
				$this->accounts_model->update_balance($to_account_id, $to_account->balance + $amount);
				$this->session->set_flashdata('successmessage', 'Account transfer completed sucessfully');
				redirect('accounts');
			} else {
				$this->session->set_flashdata('warningmessage', 'Transfer failed. Check account details and balance.');
				redirect('accounts');
			}
		} else {
			$this->accounts_model->update_balance($to_account_id, $to_account->balance + $amount);
			$this->session->set_flashdata('successmessage', 'Account deposited sucessfully');
			redirect('accounts');
		}
    }
}
