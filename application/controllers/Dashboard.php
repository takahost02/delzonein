<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {

	function __construct()
    {
          parent::__construct();
          $this->load->database();
          $this->load->helper('url');
          $this->load->library('session');
          $this->load->model('dashboard_model');
          $this->load->model('geofence_model');
          $this->load->model('vehicle_model');
          $this->load->library('vech_check');
        //   if ($this->vech_check->is_license_valid()) {
        //   } else {
        //     echo "License has expired."; die;
        //   }
    }
	public function index()
	{
        $returndata = array();
        $data['dashboard'] = $data['transactions'] = $data['vechiles'] = array();
        $data['vehicles']= $this->get_top_vechiles();
        $data['transactions']= $this->dashboard_model->get_transactions();
        $data['todayreminder']= $this->dashboard_model->get_todayreminder();
        $data['dashboard'] = $this->dashboard_model->getdashboard_info();
        $data['countbytrip_status']= $this->get_countbytrip_status();   
        $data['daily_income_expense']= $this->get_daily_income_expense();
        $data['vehicles_status'] = $this->get_active_vehicles('array');
        $data['last_sync_time'] = $this->last_sync_time();
        // $geofenceevents = $this->geofence_model->get_geofenceevents(20);
        // if(!empty($geofenceevents)) { 
        //     foreach($geofenceevents as $key=> $geeodata)
        //     {
        //         $geo_name = $this->db->select('geo_name')->from('geofences')->where('geo_id',$geeodata['ge_geo_id'])->get()->result_array();
        //         if(isset($geo_name[0]['geo_name'])) {
        //             $returndata[] = $geeodata;
        //             $returndata[$key]['geo_name'] = $geo_name[0]['geo_name'];
        //         }
        //     }
        // }
        $data['geofenceevents']=$returndata;
		$this->template->template_render('dashboard',$data);
	}
    public function get_active_vehicles($type=NULL) {
        $current_time = date('Y-m-d H:i:s'); 
        $this->db->select('v.v_id, v.v_name, t.t_start_date, t.t_end_date, t.t_trip_status');
        $this->db->from('vehicles v');  
        $this->db->join('trips t', "t.t_vechicle = v.v_id AND t.t_end_date >= '$current_time'", 'left');
        $this->db->group_by('v.v_id');
        $query = $this->db->get();
        $active_vehicles = [];
        foreach ($query->result() as $row) {
            $status = ($row->t_start_date && $row->t_end_date) ? 'In Trip' : 'Free';
            $active_vehicles[] = [
                'vehicle_id' => $row->v_id,
                'vehicle_name' => $row->v_name,
                'status' => $status
            ];
        }
        usort($active_vehicles, function ($a, $b) {
            return strcmp($a['status'], $b['status']);
        });
        if ($type) {
            return $active_vehicles;
        } else {
            echo json_encode($active_vehicles);
        }
    }
    public function get_incomeexpensechart_data() {
        $income = $this->get_top_incomeexpense('income') ?? [];
        $expense = $this->get_top_incomeexpense('expense') ?? [];
        
        $chartData = [
            'income_labels' => is_array($income) && isset($income['labels']) ? $income['labels'] : [],
            'income_data' => is_array($income) && isset($income['amounts']) ? $income['amounts'] : [],
            'expense_labels' => is_array($expense) && isset($expense['labels']) ? $expense['labels'] : [],
            'expense_data' => is_array($expense) && isset($expense['amounts']) ? $expense['amounts'] : [],
        ];
        
        echo json_encode($chartData);

    }
    public function remindermark()
    {
        $data = array('r_isread' => 1);
        $this->db->where('r_id',$this->input->post('r_id'));
        echo $this->db->update('reminder',$data);
    }
    public function get_top_incomeexpense($type) {
        $from_date = date('Y-m-d', strtotime('-10 day')); 
        $to_date = date("Y-m-d"); 
        $this->db->select('
            atc.ie_cat_name AS category, 
            v.v_registration_no, 
            v.v_name, 
            v.v_group, 
            SUM(at.amount) AS total_amount, 
            MAX(at.transaction_date) AS last_transaction_date
        ');
        $this->db->from('ac_transactions at');
        $this->db->join('ac_transactions_category atc', 'at.cat_id = atc.ie_cat_id');
        $this->db->join('vehicles v', 'at.v_id = v.v_id');
        if ($type == 'income') {
            $this->db->where('at.transaction_type', 'Credit');
        } elseif ($type == 'expense') {
            $this->db->where('at.transaction_type', 'Debit');
        }
        $this->db->where('DATE(at.transaction_date) >=', $from_date);
        $this->db->where('DATE(at.transaction_date) <=', $to_date);
        $this->db->group_by('atc.ie_cat_name');
        $this->db->order_by('total_amount', 'DESC');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $data['topincome'] = $query->result_array();
            $graph_labels = [];
            $graph_amounts = [];
            foreach ($data['topincome'] as $transaction) {
                $graph_labels[] = $transaction['v_name'] . ' (' . $transaction['category'] . ')';
                $graph_amounts[] = $transaction['total_amount'];
            }
            return $data['transaction_graph'] = [
                'labels' => $graph_labels,
                'amounts' => $graph_amounts
            ];
        } else {
            return '';
        }
        
    }
   
    public function get_top_vechiles() {
        $this->db->select('vehicles.v_name AS vehicle, SUM(trips.t_trip_amount) AS total_amount');
        $this->db->from('trips');
        $this->db->join('vehicles', 'trips.t_vechicle = vehicles.v_id', 'LEFT');
        $this->db->join('vehicle_group', 'vehicles.v_group = vehicle_group.gr_id', 'LEFT');
        if(isset($_POST['vehicle_group']) && $_POST['vehicle_group']!='') {
            $selected_vehicle_group = $this->input->post('vehicle_group'); 
            $this->db->where('vehicle_group.gr_id', $selected_vehicle_group); 
        }
        $this->db->group_by('vehicles.v_name');
        $this->db->order_by('total_amount', 'DESC');
        $query = $this->db->get();
        if($query !== FALSE && $query->num_rows() > 0){
            return $query->result_array();
        } else {
            return 0;
        }
    }
    public function fetch_vehicle_current_locations()
    {
        $query = $this->db->query("
           SELECT p.id, p.v_id, p.latitude, p.longitude, p.address, p.time, v.v_name
            FROM (
                SELECT id, v_id, latitude, longitude, address, time,
                    ROW_NUMBER() OVER (PARTITION BY v_id ORDER BY time DESC) AS row_num
                FROM positions
            ) p
            JOIN vehicles v ON p.v_id = v.v_id
            WHERE p.row_num = 1
            ORDER BY p.time DESC;
        ");
        $vehicles = $query->result_array();
        foreach ($vehicles as &$vehicle) {
            if (empty($vehicle['address'])) {
                $vehicle['address'] = $this->getaddress($vehicle['latitude'], $vehicle['longitude']);
                $this->db->update('vehicle_locations', ['address' => $vehicle['address']], ['id' => $vehicle['id']]);
            }
        }
        echo json_encode($vehicles); 
    }

    private function getaddress($latitude, $longitude)
    {
        sleep(1);
        $api_url = "https://nominatim.openstreetmap.org/reverse?email=myemail@myserver.com&format=json&lat={$latitude}&lon={$longitude}&zoom=27&addressdetails=1";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        return $response['display_name'] ?? 'Address not found';
    }
    public function get_countbytrip_status() {
        $current_date = date('Y-m-d');
        $result = $this->db->select('t_trip_status, COUNT(*) as total')
                   ->from('trips')
                   ->where("DATE(t_start_date) <= ", $current_date)
                   ->where("DATE(t_end_date) >= ", $current_date)
                   ->group_by('t_trip_status')
                   ->get()
                   ->result_array();
    
        $status_counts = [];
        foreach ($result as $row) {
            $status_counts[$row['t_trip_status']] = $row['total'];
        }
        return $status_counts;
    }
    public function get_daily_income_expense() {
        $result = ($q = $this->db->select("SUM(CASE WHEN transaction_type = 'Credit' THEN amount ELSE 0 END) AS total_income, SUM(CASE WHEN transaction_type = 'Debit' THEN amount ELSE 0 END) AS total_expense")->from('ac_transactions')->where('DATE(transaction_date)', date('Y-m-d'))->get()) ? $q->row_array() : ['total_income' => 0, 'total_expense' => 0];

        return [
            'total_income' => $result['total_income'] ?? 0,
            'total_expense' => $result['total_expense'] ?? 0
        ];
    }
    public function last_sync_time() {
        $last_sync = ($q = $this->db->select('tl_time')->from('traccarsync_log')->order_by('tl_id', 'DESC')->limit(1)->get()) ? $q->row() : null;

        if ($last_sync) {
            $last_sync_time = strtotime($last_sync->tl_time);
            $time_diff = time() - $last_sync_time;
            if ($time_diff < 60) {
                $sync_message = "Last Sync just now";
            } elseif ($time_diff < 3600) {
                $sync_message = "Last Sync " . floor($time_diff / 60) . " mins ago";
            } elseif ($time_diff < 86400) {
                $sync_message = "Last Sync " . floor($time_diff / 3600) . " hours ago";
            } else {
                $sync_message = "Last Sync " . floor($time_diff / 86400) . " days ago";
            }
        } else {
            $sync_message = "No Sync Found";
        }
        return $sync_message;
    }
}
