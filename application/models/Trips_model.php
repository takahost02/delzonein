<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Trips_model extends CI_Model{
	public function add_trips($data) {   
		$insertdata = $data;
		$insertdata['t_trackingcode'] = uniqid();
		$insertdata['t_bookingid'] = sitedata()['s_booking_prefix'].$this->get_next_trip_id();
		$insertdata['t_totaldistance'] = $data['t_totaldistance'].''.sitedata()['s_mapunit'];
		$regEx = '/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/';
		preg_match($regEx, $data['t_start_date'], $result);
		if(!empty($result)) {
			$insertdata['t_start_date'] = reformatDatetime($data['t_start_date']);
			$insertdata['t_end_date'] = reformatDatetime($data['t_end_date']);
		} else {
			$insertdata['t_start_date'] = $data['t_start_date'];
			$insertdata['t_end_date'] = $data['t_end_date'];
		}
		if(!empty($data['t_trip_stops'])) {
			$insertdata['t_trip_stops'] = json_encode(array_filter($data['t_trip_stops']));
		}
		$this->db->insert('trips',$insertdata);
		return $this->db->insert_id();
	} 
    public function getall_customer() { 
		return $this->db->select('*')->from('customers')->order_by('c_name','asc')->get()->result_array();
	} 
	public function getall_conductors() { 
		return $this->db->select('*')->from('conductors')->get()->result_array();
	} 
	public function getall_route() { 
		return $this->db->select('*')->from('vehicle_route')->get()->result_array();
	} 
	public function getall_vechicle() { 
		$this->db->select("vehicles.*,vehicle_group.gr_name");
		$this->db->from('vehicles');
		$this->db->join('vehicle_group', 'vehicles.v_group=vehicle_group.gr_id','LEFT');
		$this->db->order_by('vehicles.v_id', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	} 
	public function getall_mybookings($c_id) { 
		$newtripdata = array();
		$tripdata = $this->db->select('*')->from('trips')->where('t_customer_id',$c_id)->order_by('t_id','DESC')->get()->result_array();
		if(!empty($tripdata)) {
			foreach ($tripdata as $key => $tripdataval) {
				$newtripdata[$key] = $tripdataval;
				$newtripdata[$key]['t_customer_details'] =  $this->db->select('*')->from('customers')->where('c_id',$tripdataval['t_customer_id'])->get()->row();
				$this->db->select("vehicles.*, vehicle_group.gr_name")->from('vehicles')->join('vehicle_group', 'vehicles.v_group = vehicle_group.gr_id', 'LEFT')
				->where('vehicles.v_id', $tripdataval['t_vechicle']);
	   			$newtripdata[$key]['t_vechicle_details'] = $this->db->get()->row();				
				$newtripdata[$key]['t_driver_details'] =   $this->db->select('*')->from('drivers')->where('d_id',$tripdataval['t_driver'])->get()->row();
				$newtripdata[$key]['t_route_details'] =  $this->db->select('*')->from('vehicle_route')->where('vr_id',$tripdataval['t_route'])->get()->row();
			}
			return $newtripdata;
		} else 
		{
			return false;
		}
	}
	public function getall_driverlist() { 
		return $this->db->select('*')->from('drivers')->get()->result_array();
	}
	public function getall_trips_expense($t_id) { 
		return $this->db->select('*')->from('trips_expense')->where('e_trip_id',$t_id)->get()->result_array();
	} 
	public function get_paymentdetails($t_id) { 
		return $this->db->select('ac_accounts.*, ac_transactions.*, login.u_name, ac_transactions_category.ie_cat_name')
		->from('ac_accounts')
		->join('ac_transactions', 'ac_accounts.id = ac_transactions.account_id', 'inner')
		->join('login', 'ac_transactions.created_by = login.u_id', 'left')
		->join('ac_transactions_category', 'ac_transactions.cat_id = ac_transactions_category.ie_cat_id', 'left')
		->where('ac_transactions.trip_id',$t_id)
		->order_by('ac_transactions.id', 'DESC') 
		->get()
		->result_array();
	}
	
	public function getall_trips($trackingcode=false) { 
		$tripdata = $this->db
			->select('
				trips.*,
				customers.c_name, customers.c_mobile, customers.c_email, 
				vehicles.v_registration_no, vehicles.v_model, vehicle_group.gr_name,
				drivers.d_name, drivers.d_mobile,
				vehicle_route.vr_name
			')
			->from('trips')
			->order_by('trips.t_id', 'desc')
			->join('customers', 'customers.c_id = trips.t_customer_id', 'left')
			->join('vehicles', 'vehicles.v_id = trips.t_vechicle', 'left')
			->join('vehicle_group', 'vehicles.v_group = vehicle_group.gr_id', 'left')
			->join('drivers', 'drivers.d_id = trips.t_driver', 'left')
			->join('vehicle_route', 'vehicle_route.vr_id = trips.t_route', 'left');
		if (!empty($trackingcode)) {
			$this->db->where('trips.t_trackingcode', $trackingcode);
		}
		$query = $this->db->get();
		$tripdata = $query->result_array();
		return !empty($tripdata) ? $tripdata : false;
	}
	public function getaddress($lat,$lng)
	{
	 $google_api_key = $this->config->item('google_api_key'); 
	 $url = 'https://maps.googleapis.com/maps/api/geocode/json?key='.$google_api_key.'&latlng='.trim($lat).','.trim($lng).'&sensor=false';
	$json = @file_get_contents($url);
	$data = json_decode($json);
        if (!empty($data)) {
            $status = $data->status;
            if ($status == "OK") {
                return $data->results[1]->formatted_address;
            } else {
                return false;
            }
        } else {
            return '';
        }
    }
	public function get_tripdetails($t_id) { 
		return $this->db->select('*')->from('trips')->where('t_id',$t_id)->get()->result_array();
	}
	public function update_trips($data) { 
		if(!empty($data['t_trip_stops'])) {
			$data['t_trip_stops'] = json_encode(array_filter($data['t_trip_stops']));
		}
		$data['t_start_date'] = reformatDatetime($data['t_start_date']);
		$data['t_end_date'] = reformatDatetime($data['t_end_date']);
		$this->db->where('t_id',$this->input->post('t_id'));
		$this->db->update('trips',$data);
		return $this->input->post('t_id');
	}
	public function trip_reports($from,$to,$v_id) { 
		$newtripdata = array();
		if($v_id=='all') {
			$where = array('t_start_date>='=>$from,'t_start_date<='=>$to);
		} else {
			$where = array('t_start_date>='=>$from,'t_start_date<='=>$to,'t_vechicle'=>$v_id);
		}
		
		$tripdata = $this->db->select('*')->from('trips')->where($where)->order_by('t_id','desc')->get()->result_array();
		if(!empty($tripdata)) {
			foreach ($tripdata as $key => $tripdataval) {
				$newtripdata[$key] = $tripdataval;
				$newtripdata[$key]['t_customer_details'] =  $this->db->select('*')->from('customers')->where('c_id',$tripdataval['t_customer_id'])->get()->row();
				$newtripdata[$key]['t_vechicle_details'] =  $this->db->select('*')->from('vehicles')->where('v_id',$tripdataval['t_vechicle'])->get()->row();
				$newtripdata[$key]['t_driver_details'] =   $this->db->select('*')->from('drivers')->where('d_id',$tripdataval['t_driver'])->get()->row();
			}
			return $newtripdata;
		} else 
		{
			return array();
		}
	}
	public function get_next_trip_id() {
		$this->db->select('t_id');
		$this->db->from('trips');
		$this->db->order_by('t_id', 'DESC'); // Get the latest record
		$this->db->limit(1); // Only one record
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$last_id = $query->row()->t_id;
			return $last_id + 1; // Return the next ID
		} else {
			return 1; // Start from 1 if there are no records
		}
	}
} 