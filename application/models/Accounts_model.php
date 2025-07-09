<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class Accounts_model extends CI_Model
{
   
    public function getall_accounts()
    {
        return $this->db->select('ac_accounts.*, login.*')->from('ac_accounts')->join('login', 'ac_accounts.created_by = login.u_id', 'inner')->get()->result_array();
    }

    public function getall_transactions()
    {
		return $this->db->select('ac_accounts.*, ac_transactions.*, login.u_name, vehicles.v_registration_no, vehicles.v_name,ac_transactions_category.ie_cat_name')
		->from('ac_accounts')
		->join('ac_transactions', 'ac_accounts.id = ac_transactions.account_id', 'inner')
		->join('login', 'ac_transactions.created_by = login.u_id', 'left')
		->join('vehicles', 'ac_transactions.v_id = vehicles.v_id', 'left')
		->join('ac_transactions_category', 'ac_transactions.cat_id = ac_transactions_category.ie_cat_id', 'left')
		->order_by('ac_transactions.id', 'DESC') 
		->get()
		->result_array();
    }

    public function add_transactions($data) { 
		$data['v_id'] = $data['transactionsv_id'];
		unset($data['transactionsv_id']);
		$data['transaction_date'] = reformatDate($data['transaction_date']);
		return	$this->db->insert('ac_transactions',$data);
	} 

	public function edittransactions($e_id) { 
		return $this->db->select('*')->from('ac_transactions')->where('ie_id',$e_id)->get()->result_array();
	}
	public function updatetransactions() { 
		$_POST['v_id'] = $_POST['transactionsv_id'];
		unset($_POST['transactionsv_id']);
		$_POST['transaction_date'] = reformatDate($_POST['transaction_date']);
		$this->db->where('id',$this->input->post('id'));
		return $this->db->update('ac_transactions',$this->input->post());
	}
	public function getvechicle_transactions($v_id) { 
		return $this->db->select('*')->from('ac_transactions')->where('ie_v_id',$v_id)->order_by('ie_id','DESC')->get()->result_array();
	} 
	public function transactions_reports($from,$to,$v_id) { 
		$newtransactions = array();
		if($v_id=='all') {
			$where = array('date(transaction_date)>='=>$from,'date(transaction_date)<='=>$to);
		} else {
			$where = array('date(transaction_date)>='=>$from,'date(transaction_date)<='=>$to,'ie_v_id'=>$v_id);
		}

		$transactions = $this->db->select('*')->from('ac_transactions')->where($where)->order_by('ie_id','desc')->get()->result_array();
		if(!empty($transactions)) {
			foreach ($transactions as $key => $transactionss) {
				$newtransactions[$key] = $transactionss;
				$newtransactions[$key]['vech_name'] =  $this->db->select('v_registration_no,v_name')->from('vehicles')->where('v_id',$transactionss['ie_v_id'])->get()->row();
			}
			return $newtransactions;
		} else 
		{
			return array();
		}
	}

	public function get_balance($account_id) {
        $this->db->select('balance');
        $this->db->from('ac_accounts');
        $this->db->where('id', $account_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->balance;
        }
        return 0; // Return 0 if account not found
    }

    public function update_balance($account_id, $new_balance) {
        $this->db->where('id', $account_id);
        $this->db->update('ac_accounts', ['balance' => $new_balance]);

    }
   
}