<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {

	 function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->load->model('maintenance_model');
          $this->load->model('Incomexpense_model');
		  $this->load->model('stockinventory_model');
          $this->load->model('trips_model');
          $this->load->helper(array('form', 'url','string'));
          $this->load->library('form_validation');
          $this->load->library('session');
     }

	public function index()
	{
		$data['maintenancelist'] = $this->maintenance_model->getall_maintenance();
		$this->template->template_render('maintenance_management',$data);
	}
	public function addmaintenance()
	{
		$data['mechanic'] = $this->maintenance_model->get_mechanic();
 		$data['maintenance_vendor'] = $this->maintenance_model->get_maintenance_vendor();
		$data['partsinventory'] = $this->stockinventory_model->getall_stockinventory();
		$data['vechiclelist'] = $this->trips_model->getall_vechicle();
		$this->template->template_render('maintenance_add',$data);
	}
	public function insertmaintenance()
	{
		$testxss = true;
		if($testxss){
			$pu_s_id = $_POST['pu_s_id'];
			$pu_qty = $_POST['pu_qty'];
			unset($_POST['pu_s_id']);
			unset($_POST['pu_qty']);
			if(isset($_POST['m_notify_members'])) {
				$_POST['m_notify_members'] = json_encode($_POST['m_notify_members']);
			} else {
				$_POST['m_notify_members'] = json_encode(array());
			}
			$response = $this->maintenance_model->add_maintenance($this->input->post());
		
			if($response) {
				$pu_m_id  = $this->db->insert_id();
				foreach ($pu_s_id as $key => $itemName) {
					if($pu_s_id[$key]!='') {
						$my_data[$key]['pu_m_id'] = $pu_m_id;
						$my_data[$key]['pu_s_id'] = $pu_s_id[$key];
						$my_data[$key]['pu_qty'] = $pu_qty[$key];
						$my_data[$key]['pu_created_date'] = date('Y-m-d H:i:s');
					}
				}
				if(!empty($my_data)) {
					foreach($my_data as $partsused) {
						$this->db->set('s_stock', 's_stock - '.$partsused["pu_qty"],false);
						$this->db->where('s_id', $partsused['pu_s_id']);
						$this->db->update('stockinventory');
					}
					$this->db->insert_batch('vehicle_maintenance_parts_used',$my_data); 
				}
				$notifyType = $this->input->post('m_notify_type');
				if(isset($_POST['m_notify_members'])) {
					$m_notify_members = json_decode($this->input->post('m_notify_members'), true);
					if (is_array($m_notify_members)) {
						foreach ($m_notify_members as $item) {
							list($contact, $email, $name) = explode('|', $item);
							if ($notifyType === 'email') {
								$this->send_email($email, $name,$pu_m_id);
							}
							if ($notifyType === 'sms') {
								$this->send_sms($contact, $name,$pu_m_id);
							}
							if ($notifyType === 'both') {
								$this->send_email($email, $name,$pu_m_id);
								$this->send_sms($contact, $name,$pu_m_id);
							}
						}
					}
				}
				$this->session->set_flashdata('successmessage', 'New maintenance added successfully..');
			} else {
				$this->session->set_flashdata('warningmessage', validation_errors());
			}
			redirect('maintenance');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error! Your input are not allowed.Please try again');
			redirect('maintenance');
		}
	}

	public function maintenance_edit()
	{
		$m_id = $this->input->get('m_id');
		$this->db->select('
			vm.*,
			v.v_name AS vehicle_name,
			vmv.mv_name AS vendor_name,
			vmm.mm_name AS mechanic_name,
		');
		$this->db->from('vehicle_maintenance vm');
		$this->db->join('vehicles v', 'v.v_id = vm.m_v_id', 'left');
		$this->db->join('vehicle_maintenance_vendor vmv', 'vmv.mv_id = vm.m_vendor_id', 'left');
		$this->db->join('vehicle_maintenance_mechanic vmm', 'vmm.mm_id = vm.m_mechanic_id', 'left');
		$this->db->where('vm.m_id', $m_id);
		$query = $this->db->get();
		$maintenancedetails = $query->row_array();
		$data['maintenancedetails'] = $maintenancedetails;
		$this->db->select('si.s_name AS part_name, si.s_price AS part_price,vp.pu_qty as quantity');
		$this->db->from('vehicle_maintenance_parts_used vp');
		$this->db->join('stockinventory si', 'si.s_id = vp.pu_s_id', 'left');
		$this->db->where('vp.pu_m_id', $m_id);
		$parts_query = $this->db->get();
		$data['parts_used'] = $parts_query->result_array();
		if($maintenancedetails['m_notify_members']!='') {
			$data['m_notify_members'] = json_decode($maintenancedetails['m_notify_members']);
		} else {
			$data['m_notify_members'] = array();
		}
		$data['mechanic'] = $this->maintenance_model->get_mechanic();
 		$data['maintenance_vendor'] = $this->maintenance_model->get_maintenance_vendor();
		$data['partsinventory'] = $this->stockinventory_model->getall_stockinventory();
		$data['vechiclelist'] = $this->trips_model->getall_vechicle();
		$this->template->template_render('maintenance_add',$data);
	}
	public function updatemaintenance()
	{
		$testxss = true;
		if ($testxss) {
			$pu_s_id = $_POST['pu_s_id'];
			$m_notify_members = $_POST['m_notify_members'];
			$pu_qty = $_POST['pu_qty'];
			unset($_POST['pu_s_id'], $_POST['pu_qty'],$_POST['m_notify_members']);
			$m_id = $this->input->post('m_id'); // Maintenance ID
			$this->db->where('m_id', $m_id);
			$response = $this->db->update('vehicle_maintenance', $_POST);
			
			if ($response) {
				$this->db->where('pu_m_id', $m_id);
				$current_parts = $this->db->get('vehicle_maintenance_parts_used')->result_array();
				$current_parts_map = [];
				foreach ($current_parts as $part) {
					$current_parts_map[$part['pu_s_id']] = $part;
				}
				$parts_to_insert = [];
				foreach ($pu_s_id as $key => $part_id) {
					if ($part_id != '') {
						$new_qty = $pu_qty[$key];
						if (isset($current_parts_map[$part_id])) {
							$existing_qty = $current_parts_map[$part_id]['pu_qty'];
							if ($new_qty != $existing_qty) {
								$qty_diff = $new_qty - $existing_qty;
								$this->db->set('s_stock', "s_stock - ($qty_diff)", false);
								$this->db->where('s_id', $part_id);
								$this->db->update('stockinventory');

								$this->db->set('pu_qty', $new_qty);
								$this->db->where('pu_m_id', $m_id);
								$this->db->where('pu_s_id', $part_id);
								$this->db->update('vehicle_maintenance_parts_used');
							}
							unset($current_parts_map[$part_id]); // Mark as processed
						} else {
							// New part to insert
							$parts_to_insert[] = [
								'pu_m_id' => $m_id,
								'pu_s_id' => $part_id,
								'pu_qty' => $new_qty,
								'pu_created_date' => date('Y-m-d H:i:s'),
							];
							$this->db->set('s_stock', "s_stock - $new_qty", false);
							$this->db->where('s_id', $part_id);
							$this->db->update('stockinventory');
						}
					}
				}
				if (!empty($parts_to_insert)) {
					$this->db->insert_batch('vehicle_maintenance_parts_used', $parts_to_insert);
				}
				foreach ($current_parts_map as $part_id => $part) {
					$this->db->set('s_stock', "s_stock + {$part['pu_qty']}", false);
					$this->db->where('s_id', $part_id);
					$this->db->update('stockinventory');

					$this->db->where('pu_m_id', $m_id);
					$this->db->where('pu_s_id', $part_id);
					$this->db->delete('vehicle_maintenance_parts_used');
				}

				$notifyType = $this->input->post('m_notify_type');
				$new_notify_members = $m_notify_members; // New members from the form
				$this->db->select('m_notify_members');
				$this->db->where('m_id', $m_id);
				$existing_notify_members_json = $this->db->get('vehicle_maintenance')->row()->m_notify_members;
				$existing_notify_members = json_decode($existing_notify_members_json, true);
				$existing_notify_map = [];
				if (!empty($existing_notify_members)) {
					foreach ($existing_notify_members as $member) {
						list($contact, $email, $name, $role) = explode('|', $member);
						$existing_notify_map[$contact] = $member; // Key by contact
					}
				}
				$updated_notify_members = [];
				

				foreach ($new_notify_members as $member) {
					list($contact, $email, $name, $role) = explode('|', $member);
					if (!isset($existing_notify_map[$contact])) {
						if ($notifyType === 'email' || $notifyType === 'both') {
							$this->send_email($email, $name,$m_id);
						}
						if ($notifyType === 'sms' || $notifyType === 'both') {
							$this->send_sms($contact, $name,$m_id);
						}
					}
					$updated_notify_members[] = $member;
				}
				$updated_notify_members_json = json_encode($updated_notify_members);
				$this->db->where('m_id', $m_id);
				$this->db->update('vehicle_maintenance', ['m_notify_members' => $updated_notify_members_json]);
				$this->session->set_flashdata('successmessage', $m_id ? 'Maintenance updated successfully.' : 'New maintenance added successfully.');
			} else {
				$this->session->set_flashdata('warningmessage', $m_id ? 'Failed to update maintenance.' : validation_errors());
			}
			redirect('maintenance');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error! Your input is not allowed. Please try again.');
			redirect('maintenance');
		}
	}

	public function send_email($email, $name,$m_id)
	{
		$this->load->model('emailsms_model');
		$this->db->select("vehicle_maintenance.*, vehicles.v_name,vehicles.v_registration_no");
		$this->db->from('vehicle_maintenance');
		$this->db->join('vehicles', 'vehicle_maintenance.m_v_id = vehicles.v_id', 'LEFT');
		$this->db->where('m_id', $m_id);
		$query = $this->db->get();
		$maintenance = $query->result_array();
		if(!empty($maintenance)) {
			$gettemplate = $this->db->get_where('email_template', ['et_name' => 'maintenance'])->row_array();
			$email_data = [
				'vehicle'        => $maintenance[0]['v_name'],
				'vehicle_number' => $maintenance[0]['v_registration_no'],  // Vehicle name from vehicles table
				'service_date'   => $maintenance[0]['m_start_date'].' to '.$maintenance[0]['m_end_date'],   // Driver name from drivers table
				'odometer_reading' => $maintenance[0]['m_odometer_reading'],
				'status'         => strtoupper($maintenance[0]['m_status'])
			];
			
			$template = $gettemplate['et_body'];
			foreach ($email_data as $key => $value) {
				$template = str_replace("{{" . $key . "}}", $value, $template);
			}
			$emailresp = $this->emailsms_model->sendemail($email,$gettemplate['et_subject'],$template);
			if($emailresp=='true') {
				$data = ['ref_id' => $m_id,'content' => $gettemplate['et_subject'],'status' => 1,'error_description' => null,'module' => 'maintenance','to_email' => $email,'created_at'=>date('Y-m-d h:i:s')];
				$this->db->insert('email_log', $data);
			} else {
				$data = ['ref_id' => $m_id,'content' => $gettemplate['et_subject'],'status' => 0,'error_description' => $emailresp,'module' => 'maintenance','to_email' => $email,'created_at'=>date('Y-m-d h:i:s')];
				$this->db->insert('email_log', $data);
			}
		}
	}
	public function send_sms($contact, $name,$m_id)
	{
		$this->load->library('twilio');
		$this->db->select("vehicle_maintenance.*, vehicles.v_name,vehicles.v_registration_no");
		$this->db->from('vehicle_maintenance');
		$this->db->join('vehicles', 'vehicle_maintenance.m_v_id = vehicles.v_id', 'LEFT');
		$this->db->where('m_id', $m_id);
		$query = $this->db->get();
		$maintenance = $query->result_array();
		if(!empty($maintenance)) {
			$gettemplate = $this->db->get_where('sms_template', ['st_name' => 'Maintenance'])->row_array();
			$sms_data = [
				'vehicle'        => $maintenance[0]['v_name'],
				'vehicle_number' => $maintenance[0]['v_registration_no'],  // Vehicle name from vehicles table
				'service_date'   => $maintenance[0]['m_start_date'].' to '.$maintenance[0]['m_end_date'],   // Driver name from drivers table
				'odometer_reading' => $maintenance[0]['m_odometer_reading'],
				'status'         => strtoupper($maintenance[0]['m_status'])
			];
			$template = $gettemplate['st_body'];
			foreach ($sms_data as $key => $value) {
				$template = str_replace("{{" . $key . "}}", $value, $template);
			}
			
			$contact = isset($contact) && strpos($contact, '+') !== 0 ? '+' . $contact : $contact;
			$smsresp = $this->twilio->sendsms($contact,$template,$m_id,'maintenance');
		}
	}

	public function deletemaintenance()
	{
		$r_id = $_POST['del_id'];
		$returndata = $this->maintenance_model->deletemaintenance($r_id);
		if($returndata) {
			$this->session->set_flashdata('successmessage', 'Maintenance deleted successfully..');
			redirect('maintenance');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error..! Try again..');
		    redirect('maintenance');
		}
	}

	public function mechanic() {
		$data['mechanic'] = $this->maintenance_model->get_mechanic();
		$this->template->template_render('vehicle_mechanic', $data);
	}

	public function mechanic_delete() {
		$mech_id = $this->uri->segment(3);
		$returndata = $this->maintenance_model->mechanic_delete($mech_id);
		if ($returndata) {
			$this->session->set_flashdata('successmessage', 'Mechanic deleted successfully.');
			redirect('maintenance/mechanic');
		} else {
			$this->session->set_flashdata('warningmessage', 'Something went wrong.. Try again.');
			redirect('maintenance/mechanic');
		}
	}

	public function addmechanic() {
		$response = $this->db->insert('vehicle_maintenance_mechanic', $this->input->post());
		if ($response) {
			$this->session->set_flashdata('successmessage', 'Mechanic added successfully.');
			redirect('maintenance/mechanic');
		} else {
			$this->session->set_flashdata('warningmessage', 'Something went wrong.. Try again.');
			redirect('maintenance/mechanic');
		}
	}
	public function updatemechanic() {
		$mm_id = $this->input->post('mm_id');
		$data = [
			'mm_name' => $this->input->post('mm_name'),
			'mm_email' => $this->input->post('mm_email'),
			'mm_phone' => $this->input->post('mm_phone'),
			'mm_category' => $this->input->post('mm_category'),
		];
		$response = $this->maintenance_model->update_mechanic($mm_id, $data);
		if($response) {
			$this->session->set_flashdata('successmessage', 'Mechanic updated successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', 'Something went wrong.. Try again');
		}
		redirect('maintenance/mechanic');
	}

	public function maintenance_vendor() {
        $data['maintenance_vendor'] = $this->maintenance_model->get_maintenance_vendor();
        $this->template->template_render('vehicle_maintenance_vendor', $data);
    }

    public function maintenance_vendor_delete() {
        $mv_id = $this->uri->segment(3);
        $returndata = $this->maintenance_model->maintenance_vendor_delete($mv_id);
        if ($returndata) {
            $this->session->set_flashdata('successmessage', 'Maintenance vendor deleted successfully.');
            redirect('maintenance/maintenance_vendor');
        } else {
            $this->session->set_flashdata('warningmessage', 'Something went wrong.. Try again.');
            redirect('maintenance/maintenance_vendor');
        }
    }

    public function addmaintenance_vendor() {
        $response = $this->db->insert('vehicle_maintenance_vendor', $this->input->post());
        if ($response) {
            $this->session->set_flashdata('successmessage', 'Maintenance vendor added successfully.');
            redirect('maintenance/maintenance_vendor');
        } else {
            $this->session->set_flashdata('warningmessage', 'Something went wrong.. Try again.');
            redirect('maintenance/maintenance_vendor');
        }
    }

    public function updatemaintenance_vendor() {
        $mv_id = $this->input->post('mv_id');
        $data = [
            'mv_name' => $this->input->post('mv_name'),
            'mv_email' => $this->input->post('mv_email'),
            'mv_phone' => $this->input->post('mv_phone'),
        ];
        $response = $this->maintenance_model->update_maintenance_vendor($mv_id, $data);
        if ($response) {
            $this->session->set_flashdata('successmessage', 'Maintenance vendor updated successfully.');
        } else {
            $this->session->set_flashdata('warningmessage', 'Something went wrong.. Try again.');
        }
        redirect('maintenance/maintenance_vendor');
    }
	public function getMaintenanceDetails()
	{
		$m_id = $this->input->get('m_id');
		if (!$m_id) {
			echo json_encode([]);
			return;
		}
		$this->db->select('
			vm.m_id,
			vm.m_v_id,
			v.v_name AS vehicle_name,
			vmv.mv_name AS vendor_name,
			vmm.mm_name AS mechanic_name,
			vm.m_start_date,
			vm.m_end_date,
			vm.m_service_info,
			vm.m_cost,
			vm.m_odometer_reading,
			vm.m_notify_members,
			vm.m_notify_type,
			vm.m_status,
			vm.m_created_date
		');
		$this->db->from('vehicle_maintenance vm');
		$this->db->join('vehicles v', 'v.v_id = vm.m_v_id', 'left');
		$this->db->join('vehicle_maintenance_vendor vmv', 'vmv.mv_id = vm.m_vendor_id', 'left');
		$this->db->join('vehicle_maintenance_mechanic vmm', 'vmm.mm_id = vm.m_mechanic_id', 'left');
		$this->db->where('vm.m_id', $m_id);
		$query = $this->db->get();
		$maintenance = $query->row_array();
		$this->db->select('si.s_name AS part_name, si.s_price AS part_price,vp.pu_qty as quantity');
		$this->db->from('vehicle_maintenance_parts_used vp');
		$this->db->join('stockinventory si', 'si.s_id = vp.pu_s_id', 'left');
		$this->db->where('vp.pu_m_id', $m_id);
		$parts_query = $this->db->get();
		$maintenance['parts_used'] = $parts_query->result_array();
		$maintenance['m_notify_members'] = json_decode($maintenance['m_notify_members']);
		echo json_encode($maintenance);
	}
	public function updatemaintenance_status() {
		$mid = $this->uri->segment(3);
		$status = $this->uri->segment(4);
        $this->db->where('m_id', $mid);
        $this->db->update('vehicle_maintenance', array('m_status'=>$status));
		$this->session->set_flashdata('successmessage', 'Maintenance updated successfully.');
		redirect('maintenance');
	}
}
