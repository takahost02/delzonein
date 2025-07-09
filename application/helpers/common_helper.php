<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	function reformatDate($date, $to_format = 'Y-m-d') {
		$from_format = dateformat();
		$date_aux = date_create_from_format($from_format, $date);
		return date_format($date_aux,$to_format);
	}

	function reformatDatetime($date, $to_format = 'Y-m-d H:i') {
		$from_format = datetimeformat();
		$date_aux = date_create_from_format($from_format, $date);
		return date_format($date_aux,$to_format);
	}

	function xssclean($post)
	{
		$rtn = true; 
		if($post) {
			foreach ($post as $key => $data) {
				if (preg_match("/</i", $data, $match))  {
   					$rtn = false; 
   				}
			}
		}
		return $rtn;
	}

	function output($data) 
	{
		if(isset($data)) {
			return html_escape($data);
		} else {
			return '';
		}
	}
	function pointInPolygon($point, $polygon, $pointOnVertex = true) {
	    $pointOnVertex = $pointOnVertex;
	    $point = pointStringToCoordinates($point);
	    $vertices = array(); 
	    foreach ($polygon as $vertex) {
	        $vertices[] = pointStringToCoordinates($vertex); 
	    }
	    if ($pointOnVertex == true and pointOnVertex($point, $vertices) == true) {
	        return "vertex";
	    }
	    $intersections = 0; 
	    $vertices_count = count($vertices);
	    for ($i=1; $i < $vertices_count; $i++) {
	        $vertex1 = $vertices[$i-1]; 
	        $vertex2 = $vertices[$i];
	        if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
	            return "boundary";
	        }
	        if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) { 
	            $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']; 
	            if ($xinters == $point['x']) { // Check if lat lng is on the polygon boundary (other than horizontal)
	                return "boundary";
	            }
	            if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
	                $intersections++; 
	            }
	        } 
	    } 
	    if ($intersections % 2 != 0) {
	        return "inside";
	    } else {
	        return "outside";
	    }
	}

	function pointOnVertex($point, $vertices) {
	  foreach($vertices as $vertex) {
	      if ($point == $vertex) {
	          return true;
	      }
	  }
	}
	function pointStringToCoordinates($pointString) {
	    $coordinates = explode(" ", $pointString);
	    return array("x" => $coordinates[0], "y" => $coordinates[1]);
	}

	function sitedata() {
		static $cachedSiteInfo = null;
		if ($cachedSiteInfo === null) {
			$CI =& get_instance();
			$CI->db->from('settings');
			$query = $CI->db->get();
			$siteinfo = $query->result_array();
			if (count($siteinfo) >= 1) {
				$cachedSiteInfo = $siteinfo[0];
			} else {
				$cachedSiteInfo = [];
			}
		}
		return $cachedSiteInfo;
	}
	

    function userpermission($link) {
    	$permissons = $_SESSION['userroles'];
    	if(isset($permissons[$link]) && $permissons[$link]==1) {
    		return true;
    	} else {
    		return false;
    	}
    }
	function dateformat() {
    	return substr(sitedata()['s_date_format'], 0, strrpos(sitedata()['s_date_format'], ' '));
    }
	function datetimeformat() {
    	return sitedata()['s_date_format'];
    }
	function traccar_call($service,$data,$method=false) {
        $traccaruname = sitedata()['s_traccar_username'];
        $traccarpassword = sitedata()['s_traccar_password'];
	    $CI =& get_instance();
	    $path=gethostbyname(sitedata()['s_traccar_url']).$service;
	    $ch = curl_init(); 
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    if($method) {
	        curl_setopt($ch, CURLOPT_URL, $path);
	        if($data) {
	            curl_setopt($ch, CURLOPT_POST, 1);
	            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	        }
	        if($method == 'PUT'){
	            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	        }
	        if($method == 'DELETE'){
	            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	        }
	    }
	    $headers = array(
		    'Content-Type:application/json',
		    'Authorization: Basic '. base64_encode($traccaruname.':'.$traccarpassword)
		);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    $result = curl_exec($ch);
	    curl_close($ch);
      
	    return $result;
	}
	function daysUntilDueDate($dueDate) {
		$currentDate = new DateTime();
		$dueDate = new DateTime($dueDate);
		$interval = $currentDate->diff($dueDate);
		if ($interval->days === 0 && $interval->invert === 0) {
			return "today";
		}
		if ($dueDate < $currentDate) {
			return "past"; // Return "past" for past due dates
		}
		return $interval->days;
	}


	function daysRemaining($expirationDate) {
		if (empty($expirationDate)) {
			return "<small class='text-warning'>No expiration date provided.</small>";
		}
	
		$expirationDateTimestamp = strtotime($expirationDate);
		$currentDateTimestamp = strtotime(date('Y-m-d'));
	
		if ($expirationDateTimestamp === false) {
			return "<small class='text-danger'>Invalid expiration date.</small>";
		}
	
		$diffInSeconds = $expirationDateTimestamp - $currentDateTimestamp;
		$daysRemaining = ceil($diffInSeconds / (60 * 60 * 24));
	
		if ($daysRemaining > 0) {
			return "<small class='text-success'>Expires in $daysRemaining days.</small>";
		} elseif ($daysRemaining == 0) {
			return "<small class='text-success'>Expires today.</small>";
		} else {
			return "<small class='text-danger'>Expired " . abs($daysRemaining) . " days ago.</small>";
		}
	}
	

	function encodeId($id) {
		return rtrim(strtr(base64_encode($id), '+/', '-_'), '=');
	}
	
	function decodeId($encodedId) {
		return base64_decode(str_pad(strtr($encodedId, '-_', '+/'), strlen($encodedId) % 4, '=', STR_PAD_RIGHT));
	}
	function showdate($input_date) {
		if (empty($input_date)) {
			return $input_date; // Return as is if null or empty
		}
	
		$selected_format = dateformat();
	
		if (is_string($input_date) && strpos($input_date, ':') !== false) {
			$date = DateTime::createFromFormat('Y-m-d H:i:s', $input_date);
			if ($date === false) {
				$date = DateTime::createFromFormat('Y-m-d H:i', $input_date);
			}
		} else {
			$date = DateTime::createFromFormat('Y-m-d', $input_date);
		}
	
		return $date ? $date->format($selected_format) : $input_date;
	}
	


	if (!function_exists('get_trip_payment_details')) {
		function get_trip_payment_details($t_id) {
			$CI = &get_instance();
			$sql = "SELECT t_withouttax_trip_amount,t_trip_tax,t.t_discountamount,t_trip_final_amount,(SELECT SUM(te_amount) FROM trip_expenses WHERE te_trip_id = t.t_id) AS total_expenses, 
					COALESCE(SUM(at.amount), 0) AS paid_amount FROM trips AS t LEFT JOIN ac_transactions AS at ON t.t_id = at.trip_id WHERE t.t_id = $t_id GROUP BY t.t_id";
			$query = $CI->db->query($sql);
			if ($query->num_rows() > 0) {
				$row = $query->result_array();
				$row[0]['pendingamount'] = $row[0]['t_trip_final_amount'] + $row[0]['total_expenses'] - $row[0]['paid_amount'];
				$row[0]['totalamount'] = $row[0]['t_trip_final_amount'] + $row[0]['total_expenses'];
				return (!empty($row[0]))?$row[0]:array();
			} else {
				return null; 
			}
		}
	}
	function get_coupon_usage($coupon_code)
	{
		$CI = &get_instance();
		$CI->db->where('t_discountcode', $coupon_code);
		$CI->db->from('trips');
		return $CI->db->count_all_results();
	}

	if (!function_exists('get_all_users_and_drivers')) {
		function get_all_users_and_drivers() {
			$CI =& get_instance(); // Get CodeIgniter instance
			$CI->load->database(); // Load the database
			$sql = "
				SELECT u_name AS name, u_email AS email, u_mobile AS phone, 'login' AS source
				FROM login
				UNION
				SELECT d_name AS name, d_email AS email, d_mobile AS phone, 'driver' AS source
				FROM drivers
			";
			$query = $CI->db->query($sql);
			return $query->result_array(); // Return the result as an array
		}
	}
	function timeAgo($timestamp)
	{
		$time_ago = strtotime($timestamp);
		$current_time = time();
		$time_difference = $current_time - $time_ago;
		$seconds = $time_difference;
		
		$minutes      = round($seconds / 60);           // value 60 is seconds
		$hours        = round($seconds / 3600);         // value 3600 is 60 minutes * 60 sec
		$days         = round($seconds / 86400);        // value 86400 is 24 hours * 60 minutes * 60 sec
		$weeks        = round($seconds / 604800);       // value 604800 is 7 days * 24 hours * 60 minutes * 60 sec
		$months       = round($seconds / 2629440);      // value 2629440 is ((365+365+365+365+365)/5/12) days * 24 hours * 60 minutes * 60 sec
		$years        = round($seconds / 31553280);     // value 31553280 is 365.25 days * 24 hours * 60 minutes * 60 sec

		if ($seconds <= 60) {
			return "Just Now";
		} else if ($minutes <= 60) {
			if ($minutes == 1) {
				return "one minute ago";
			} else {
				return "$minutes minutes ago";
			}
		} else if ($hours <= 24) {
			if ($hours == 1) {
				return "an hour ago";
			} else {
				return "$hours hours ago";
			}
		} else if ($days <= 7) {
			if ($days == 1) {
				return "yesterday";
			} else {
				return "$days days ago";
			}
		} else if ($weeks <= 4.3) { // 4.3 == 30/7
			if ($weeks == 1) {
				return "a week ago";
			} else {
				return "$weeks weeks ago";
			}
		} else if ($months <= 12) {
			if ($months == 1) {
				return "a month ago";
			} else {
				return "$months months ago";
			}
		} else {
			if ($years == 1) {
				return "one year ago";
			} else {
				return "$years years ago";
			}
		}
	}
	function convertToMySQLDateTime($date, $time) {
		try {
			$dateTime = new DateTime("$date $time");
			return $dateTime->format('Y-m-d H:i');
		} catch (Exception $e) {
			return "";
		}
	}
	function generateTimeOptions($selectedTime) {
		$options = '';
		for ($hour = 0; $hour < 24; $hour++) {
			for ($minute = 0; $minute < 60; $minute += 15) {
				$time = sprintf('%02d:%02d', $hour, $minute);
				$selected = ($time === $selectedTime) ? 'selected' : '';
				$options .= "<option value=\"$time\" $selected>$time</option>\n";
			}
		}
		return $options;
	}
	function getNearestNextInterval($time, $intervalMinutes = 15) {
		$timestamp = strtotime($time);
		$roundedMinutes = ceil(date('i', $timestamp) / $intervalMinutes) * $intervalMinutes;
		$roundedTime = strtotime(date('H', $timestamp) . ":$roundedMinutes");
		if ($roundedMinutes >= 60) {
			$roundedTime = strtotime('+1 hour', strtotime(date('H:00', $timestamp)));
		}
		return date('H:i', $roundedTime);
	}
	function generateTimezoneOptionsWithOffset($selectedTimezone = 'UTC') {
		$timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
		$options = '';
		foreach ($timezones as $timezone) {
			$tz = new DateTimeZone($timezone);
			$offset = $tz->getOffset(new DateTime("now", $tz)) / 3600;
			$offsetFormatted = ($offset >= 0 ? '+' : '') . number_format($offset, 1);
			$displayName = "UTC $offsetFormatted - $timezone";
			$selected = ($timezone === $selectedTimezone) ? 'selected' : '';
			$options .= "<option value=\"$timezone\" $selected>$displayName</option>\n";
		}
		return $options;
	}
	
	$ci =& get_instance();
	if (!isset($ci->db)) {
		$ci->load->database();
	}
	$query = $ci->db->get_where('settings');
	$result = $query->row();
	return (!empty($result->s_timezone)) ? date_default_timezone_set($result->s_timezone) : 'UTC';
	
	function sendtripemail($data) {
		$CI = &get_instance();
		$CI->load->model('emailsms_model');	
		$gettemplate = $CI->db->select('*')->from('email_template')->where('et_name', 'booking')->get()->result_array();
		if (!empty($gettemplate)) {
			$template = $gettemplate[0]['et_body'];
			$CI->db->select('trips.t_bookingid, trips.t_vechicle, trips.t_trip_fromlocation, trips.t_trackingcode, trips.t_trip_tolocation, trips.t_driver, trips.t_start_date, trips.t_end_date, trips.t_totaldistance, trips.t_tripstartreading, trips.t_trip_stops, trips.t_trip_amount, trips.t_trip_status, vehicles.v_name, drivers.d_name, trips.t_customer_id');
			$CI->db->from('trips');
			$CI->db->join('vehicles', 'vehicles.v_id = trips.t_vechicle', 'left');
			$CI->db->join('drivers', 'drivers.d_id = trips.t_driver', 'left');
			$CI->db->where('t_id', $data['t_id']);
			$query = $CI->db->get();
			if ($query->num_rows() > 0) {
				$trip_data = $query->row_array();  
				$pymentdetails = get_trip_payment_details($data['t_id']);
				$email_data = [
					'bookingid'        => $trip_data['t_bookingid'],
					'vehicle'          => ($trip_data['v_name']!='')?$trip_data['v_name']:'Pending', 
					'driver'           => ($trip_data['d_name']!='')?$trip_data['d_name']:'Pending', 
					'start_date'       => $trip_data['t_start_date'],
					'end_date'         => $trip_data['t_end_date'],
					'totaldistance'    => ($trip_data['t_totaldistance']!='')?$trip_data['t_totaldistance']:'N/A', 
					'tripstartreading' => ($trip_data['t_tripstartreading']!='')?$trip_data['t_tripstartreading']:'N/A', 
					'trip_stops' => !empty($trip_data['t_trip_stops']) && ($trip_stops = json_decode($trip_data['t_trip_stops'], true)) ? implode(", ", $trip_stops): 'N/A',
					'trip_amount'      => $pymentdetails['totalamount'],
					'trip_status'      => $trip_data['t_trip_status'],
					'amount_due'       => $pymentdetails['pendingamount'],
					'from'             => $trip_data['t_trip_fromlocation'],
					'to'               => $trip_data['t_trip_tolocation'],
					'url'              => base_url() . '/triptracking/' . $trip_data['t_trackingcode'],
				];
				foreach ($email_data as $key => $value) {
					$template = str_replace("{{" . $key . "}}", $value, $template);
				}
				$custemail = $CI->db->select('c_email')->from('customers')->where('c_id', $trip_data['t_customer_id'])->get()->row()->c_email;
				$emailresp = $CI->emailsms_model->sendemail($custemail, $gettemplate[0]['et_subject'], $template);
				$log_data = [
					'ref_id' => $data['t_id'],
					'module' => 'trips',
					'content' => $gettemplate[0]['et_subject'],
					'status' => $emailresp === 'true' ? 1 : 0,
					'error_description' => $emailresp === 'true' ? null : $emailresp,
					'to_email' => $custemail,
					'created_at' => date('Y-m-d h:i:s'),
				];
				$CI->db->insert('email_log', $log_data);
				if ($emailresp === 'true') {
					$CI->session->set_flashdata('successmessage', 'Email sent successfully.');
				} else {
					$CI->session->set_flashdata('warningmessage', 'Unexpected error..Try again');
				}
			}
		}
	}

	