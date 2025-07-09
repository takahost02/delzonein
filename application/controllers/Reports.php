<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends CI_Controller {
	function __construct()   {
          parent::__construct();
          $this->load->helper('url');
          $this->load->database();
          $this->load->model('vehicle_model');
          $this->load->model('incomexpense_model');
		  $this->load->model('drivers_model');
          $this->load->model('fuel_model');
          $this->load->model('trips_model');
          $this->load->library('session');
    }
	public function booking()	{
		if(isset($_POST['bookingreport'])) {
			$triplist = $this->trips_model->trip_reports(date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('booking_from')))),date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('booking_to')))),$this->input->post('booking_vechicle'));
			if(empty($triplist)) {
				$this->session->set_flashdata('warningmessage', 'No bookings found..');
				$data['triplist'] = '';
			} else {
				unset($_SESSION['warningmessage']);
				$data['triplist'] = $triplist;
			}
		}
		$data['vehiclelist'] = $this->vehicle_model->getall_vehicle();
		$this->template->template_render('report_booking',$data);
	}
	public function incomeexpense()	{
		if(isset($_POST['incomeexpensereport'])) {
			$from_date = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('incomeexpense_from')))); 
			$to_date = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('incomeexpense_to')))); 
			$v_id = $this->input->post('incomeexpense_vechicle');  
			if ($from_date && $to_date && $v_id) {
				$this->db->select('
					at.id,
					at.transaction_date,
					aa.account_name,
					at.transaction_type,
					at.account_id,
					at.cat_id,
					at.note,
					at.reference_number,
					at.v_id,
					at.trip_id,
					at.amount,
					at.created_by,
					at.created_date,
					atc.ie_cat_name,
					v.v_registration_no,v.v_name
				');
				$this->db->from('ac_transactions at');
				$this->db->join('ac_accounts aa', 'at.account_id = aa.id');
				$this->db->join('vehicles v', 'v.v_id = at.v_id');
				$this->db->join('ac_transactions_category atc', 'at.cat_id = atc.ie_cat_id');
				$this->db->where('at.transaction_date >=', $from_date);
				$this->db->where('at.transaction_date <=', $to_date);
				if($this->input->post('incomeexpense_vechicle')!='all') {
					$this->db->where('at.v_id', $v_id);
				}
				$query = $this->db->get();
				if ($query->num_rows() > 0) {
					$incomeexpensereport = $query->result_array(); 
					unset($_SESSION['warningmessage']);
					$data['incomexpense'] = $incomeexpensereport;
				} else {
					$this->session->set_flashdata('warningmessage', 'No data found..');
					$data['incomexpense'] = '';
				}
			} else {
				$this->session->set_flashdata('warningmessage', 'No data found..');
				$data['incomexpense'] = '';
			}
		}
		$data['vehiclelist'] = $this->vehicle_model->getall_vehicle();
		$this->template->template_render('report_incomeexpense',$data);
	}
	public function fuels()	{
		if(isset($_POST['fuelreport'])) {
			$fuelreport = $this->fuel_model->fuel_reports(date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('fuel_from')))),date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('fuel_to')))),$this->input->post('fuel_vechicle'));
			if(empty($fuelreport)) {
				$this->session->set_flashdata('warningmessage', 'No data found..');
				$data['fuel'] = '';
			} else {
				unset($_SESSION['warningmessage']);
				$data['fuel'] = $fuelreport;
			}
		}
		$data['vehiclelist'] = $this->vehicle_model->getall_vehicle();
		$this->template->template_render('report_fuel',$data);
	}
	public function driversreport()	{
		$data['dlist'] = $this->drivers_model->getall_drivers();
		if(isset($_POST['driverreport'])) {
			$d_id = $_POST['d_id'];
			if($d_id=='all') {
				$where = array('t_start_date >='=>date("Y-m-d", strtotime(str_replace('/', '-', $_POST['r_from']))),'t_start_date<='=>date("Y-m-d", strtotime(str_replace('/', '-', $_POST['r_to']))));
			} else {
				$where = array('t_start_date >='=>date("Y-m-d", strtotime(str_replace('/', '-', $_POST['r_from']))),'t_start_date<='=>date("Y-m-d", strtotime(str_replace('/', '-', $_POST['r_to']))),'t_driver'=>$d_id);
			}
			$driverrep = $this->db->select('t_id,t_bookingid,t_vechicle,t_driver,t_trip_fromlocation,t_trip_tolocation,t_start_date,t_end_date,t_totaldistance,t_created_date')->from('trips')->where($where)->order_by('t_id','desc')->get()->result_array();
			
			if(empty($driverrep)) {
				$this->session->set_flashdata('warningmessage', 'No data found..');
				$data['drivers'] = '';
			} else {
				unset($_SESSION['warningmessage']);

				if(!empty($driverrep)) {
			foreach ($driverrep as $key => $tripdataval) {
				$newdata[$key] = $tripdataval;
				$newdata[$key]['t_vechicle_details'] =  $this->db->select('v_registration_no,v_name')->from('vehicles')->where('v_id',$tripdataval['t_vechicle'])->get()->row();
				$newdata[$key]['t_driver_details'] =   $this->db->select('d_name')->from('drivers')->where('d_id',$tripdataval['t_driver'])->get()->row();
			}
			$data['drivers'] = $newdata;
			}
		}
		}
		
		$data['vehiclelist'] = $this->vehicle_model->getall_vehicle();
		$this->template->template_render('report_drivers',$data);
	}

	public function couponreport()	{
		$data = [];
		if(isset($_POST['couponreport'])) {
			$from_date = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('from')))); 
			$to_date = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('to')))); 
    		$query = $this->db->query(
                "SELECT cp.cp_code, COUNT(tr.t_id) AS usage_count, COALESCE(SUM(tr.t_discountamount), 0) AS total_discount
                 FROM coupons cp
                 LEFT JOIN trips tr ON cp.cp_code = tr.t_discountcode 
                     AND tr.t_start_date BETWEEN ? AND ?
                 GROUP BY cp.cp_code",
                [$from_date, $to_date]
            );
            
            if ($query && $query->num_rows() > 0) {  // Check if query is valid before using num_rows()
                unset($_SESSION['warningmessage']);
                $data['coupon'] = $query->result_array();
            } else {
                $this->session->set_flashdata('warningmessage', 'No data found.');
                $data['coupon'] = [];
            }
		}
		$this->template->template_render('report_coupon',$data);
	}
	public function remindersreport()	{
		$data = [];
		if(isset($_POST['report_reminders'])) {
			$from_date = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('from')))); 
			$to_date = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('to')))); 
			$remindersreport = $this->db->query(
                "SELECT  r.r_date, r.r_message, v.v_name, 
                        GROUP_CONCAT(rs.rs_name SEPARATOR ', ') AS services,r.r_isread
                 FROM reminder r
                 LEFT JOIN vehicles v ON r.r_v_id = v.v_id
                 LEFT JOIN reminder_services rs ON FIND_IN_SET(rs.rs_id, r.`r_services`)
                 WHERE r.`r_date` BETWEEN ? AND ?
                 GROUP BY r.`r_id`",
                [$from_date, $to_date]
            )->result_array();
			
			if(empty($remindersreport)) {
				$this->session->set_flashdata('warningmessage', 'No data found..');
				$data['reminders'] = '';
			} else {
				unset($_SESSION['warningmessage']);
				$data['reminders'] = $remindersreport;
			}
		}
		$this->template->template_render('report_reminders',$data);
	}
	public function maintenancereport()	{
		$data['vehiclelist'] = $this->db->select('v_name,v_id')->from('vehicles')->where('v_is_active', 1)->get()->result_array();
		$data['report'] = [];
		$data['vehicle_costs'] = [];
		if(isset($_POST['report_maintenance'])) {
			$vehicle_id = $this->input->post('vehicle_id');
			$start_date = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('from')))); 
			$end_date = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('to')))); 
					$query = "SELECT 
								vm.*, 
								v.v_name, 
								GROUP_CONCAT(DISTINCT vmme.mm_name SEPARATOR ', ') AS mechanics, 
								GROUP_CONCAT(DISTINCT vmv.mv_name SEPARATOR ', ') AS vendors,
								GROUP_CONCAT(DISTINCT si.s_name SEPARATOR ', ') AS parts_used
							FROM 
								vehicle_maintenance vm
							LEFT JOIN 
								vehicles v ON vm.m_v_id = v.v_id
							LEFT JOIN 
								vehicle_maintenance_mechanic vmme ON vmme.mm_id = vm.m_mechanic_id
							LEFT JOIN 
								vehicle_maintenance_vendor vmv ON vmv.mv_id = vm.m_vendor_id
							LEFT JOIN 
								vehicle_maintenance_parts_used vmpu ON vmpu.pu_m_id = vm.m_id
							LEFT JOIN 
								stockinventory si ON si.s_id = vmpu.pu_s_id
							WHERE 
								vm.m_start_date  BETWEEN ? AND ? ";

				$params = [$start_date, $end_date];

				if (!empty($vehicle_id) && $vehicle_id !== 'all') {
				$query .= " AND vm.m_v_id = ? ";
				$params[] = $vehicle_id;
				}

				$query .= " GROUP BY vm.m_id ORDER BY vm.m_start_date DESC";

				$data['report'] = $this->db->query($query, $params)->result_array();
				

				// Vehicle-wise total cost
				$vehicle_cost_query = "SELECT v.v_name, SUM(vm.m_cost) AS total_cost
						FROM vehicle_maintenance vm
						LEFT JOIN vehicles v ON vm.m_v_id = v.v_id
						WHERE vm.m_start_date BETWEEN ? AND ? ";

				$params = [$start_date, $end_date];

				if (!empty($vehicle_id) && $vehicle_id !== 'all') {
				$vehicle_cost_query .= " AND vm.m_v_id = ? ";
				$params[] = $vehicle_id;
				}

				$vehicle_cost_query .= " GROUP BY vm.m_v_id";

				$data['vehicle_costs'] = $this->db->query($vehicle_cost_query, $params)->result_array();

				if(empty($data['report'])) {
					$this->session->set_flashdata('warningmessage', 'No data found..');
					$data['report'] = [];
					$data['vehicle_costs'] = [];
				} else {
					unset($_SESSION['warningmessage']);
				}
		}
		
		$this->template->template_render('report_maintenance',$data);
	} 
	public function topincome()	{
		$data['vehiclelist'] = $this->db->select('v_name,v_id')->from('vehicles')->where('v_is_active', 1)->get()->result_array();
		$data['transaction_data'] = [];
		$data['transaction_graph'] = [];
	
		if(isset($_POST['topincome'])) {
			$from_date = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('from')))); 
			$to_date = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('to')))); 
			$v_id = $this->input->post('v_id');  
	
			if ($from_date && $to_date) {
				$this->db->select('
					v.v_registration_no, 
					v.v_name, 
					v.v_group, 
					atc.ie_cat_name AS category, 
					at.amount AS total_amount, 
					at.transaction_date, 
					at.note
				');
				$this->db->from('ac_transactions at');
				$this->db->join('ac_transactions_category atc', 'at.cat_id = atc.ie_cat_id');
				$this->db->join('vehicles v', 'at.v_id = v.v_id');
				if ($v_id != 'all') {
					$this->db->where('at.v_id', $v_id);
				}
				$this->db->where('at.transaction_type', 'Credit');
				$this->db->where('DATE(at.transaction_date) >=', $from_date);
				$this->db->where('DATE(at.transaction_date) <=', $to_date);
				
				
				$this->db->order_by('at.amount', 'DESC');
				$query = $this->db->get();
	
				if ($query->num_rows() > 0) {
					$data['topincome'] = $query->result_array();
	
					// Prepare data for the graph
					$graph_labels = [];
					$graph_amounts = [];
					foreach ($data['topincome'] as $transaction) {
						$graph_labels[] = $transaction['v_name'] . ' (' . $transaction['category'] . ')';
						$graph_amounts[] = $transaction['total_amount'];
					}
	
					// Pass graph data
					$data['transaction_graph'] = [
						'labels' => $graph_labels,
						'amounts' => $graph_amounts
					];
				} else {
					$this->session->set_flashdata('warningmessage', 'No data found..');
				}
			} else {
				$this->session->set_flashdata('warningmessage', 'No data found..');
			}
		}
		
		$this->template->template_render('report_topincome',$data);
	}
	public function topexpense()	{
		$data['vehiclelist'] = $this->db->select('v_name,v_id')->from('vehicles')->where('v_is_active', 1)->get()->result_array();
		$data['transaction_data'] = [];
		$data['transaction_graph'] = [];
	
		if(isset($_POST['topexpense'])) {
			$from_date = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('from')))); 
			$to_date = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('to')))); 
			$v_id = $this->input->post('v_id');  
			if ($from_date && $to_date) {
				$this->db->select('
					v.v_registration_no, 
					v.v_name, 
					v.v_group, 
					atc.ie_cat_name AS category, 
					at.amount AS total_amount, 
					at.transaction_date, 
					at.note
				');
				$this->db->from('ac_transactions at');
				$this->db->join('ac_transactions_category atc', 'at.cat_id = atc.ie_cat_id');
				$this->db->join('vehicles v', 'at.v_id = v.v_id');
				if ($v_id != 'all') {
					$this->db->where('at.v_id', $v_id);
				}
				$this->db->where('at.transaction_type', 'Debit');
				$this->db->where('DATE(at.transaction_date) >=', $from_date);
				$this->db->where('DATE(at.transaction_date) <=', $to_date);
				
				
				$this->db->order_by('at.amount', 'DESC');
				$query = $this->db->get();
	
				if ($query->num_rows() > 0) {
					$data['topincome'] = $query->result_array();
	
					// Prepare data for the graph
					$graph_labels = [];
					$graph_amounts = [];
					foreach ($data['topincome'] as $transaction) {
						$graph_labels[] = $transaction['v_name'] . ' (' . $transaction['category'] . ')';
						$graph_amounts[] = $transaction['total_amount'];
					}
	
					// Pass graph data
					$data['transaction_graph'] = [
						'labels' => $graph_labels,
						'amounts' => $graph_amounts
					];
				} else {
					$this->session->set_flashdata('warningmessage', 'No data found..');
				}
			} else {
				$this->session->set_flashdata('warningmessage', 'No data found..');
			}
		}
		
		$this->template->template_render('report_topexpense',$data);
	}

	public function topvehicles()	{
		if(isset($_POST['topvehicles'])) {
			$from = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['from'])));
			$to = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['to'])));
			$this->db->select('vehicles.v_name AS vehicle, SUM(trips.t_trip_amount) AS total_amount,trips.t_start_date');
			$this->db->from('trips');
			$this->db->join('vehicles', 'trips.t_vechicle = vehicles.v_id', 'LEFT');
			$this->db->join('vehicle_group', 'vehicles.v_group = vehicle_group.gr_id', 'LEFT');
			if(isset($_POST['vehicle_group']) && $_POST['vehicle_group']!='') {
				$selected_vehicle_group = $this->input->post('vehicle_group'); 
				$this->db->where('vehicle_group.gr_id', $selected_vehicle_group); 
			}
			$this->db->where(array('trips.t_start_date >='=>$from,'trips.t_start_date<='=>$to));
			$this->db->group_by('vehicles.v_name');
			$this->db->order_by('total_amount', 'DESC');
			$query = $this->db->get();
			if($query !== FALSE && $query->num_rows() > 0) {
				unset($_SESSION['warningmessage']);
				$data['topvehicles'] = $query->result_array();
			} else {
				$this->session->set_flashdata('warningmessage', 'No data found..');
				$data['topvehicles'] = '';
			}
		}

		$data['v_group'] = $this->vehicle_model->get_vehiclegroup();
		$this->template->template_render('report_topvehicles',$data);
	}

	public function toproutes()	{
		$data['toproutes'] = '';
		if(isset($_POST['toproutes'])) {
			$from = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['from'])));
			$to = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['to'])));
			$this->db->select('vehicle_route.vr_name AS route, SUM(trips.t_trip_amount) AS total_amount');
			$this->db->from('trips');
			$this->db->join('vehicle_route', 'trips.t_route = vehicle_route.vr_id', 'LEFT');
			$this->db->join('vehicles', 'trips.t_vechicle = vehicles.v_id', 'LEFT');
			$this->db->join('vehicle_group', 'vehicles.v_group = vehicle_group.gr_id', 'LEFT');
			if(isset($_POST['vehicle_group']) && $_POST['vehicle_group']!='') {
				$selected_vehicle_group = $this->input->post('vehicle_group'); 
				$this->db->where('vehicle_group.gr_id', $selected_vehicle_group); 
			}
			$this->db->where(array('date(trips.t_start_date) >='=>$from,'date(trips.t_start_date)<='=>$to));
			$this->db->group_by('vehicle_route.vr_name');
			$this->db->order_by('total_amount', 'DESC');
			$query = $this->db->get();
			if($query !== FALSE && $query->num_rows() > 0) {
				unset($_SESSION['warningmessage']);
				$data['toproutes'] = $query->result_array();
			} else {
				$this->session->set_flashdata('warningmessage', 'No data found..');
				$data['toproutes'] = '';
			}
		}
		
		$data['v_group'] = $this->vehicle_model->get_vehiclegroup();
		$this->template->template_render('report_toproutes',$data);
	}

}
