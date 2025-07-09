<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Api extends REST_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('api_model');
        $this->load->model('geofence_model');

    }
    public function index_get() {
         $write_content = var_export($_GET, true);
            file_put_contents("myloggets.php", $write_content);
    }

    public function index_post()   //Get GPS feed in device
    { 
       if(isset($_GET)) {
           $id = isset($_GET['id']) ? $_GET['id'] : ''; 
           $checklogin = $this->api_model->checkgps_auth($id);   
           if($checklogin) 
           { 
            echo $v_id = $checklogin[0]['v_id'];
            $lat = isset($_GET["lat"]) ? $_GET["lat"] : NULL;
            $lon = isset($_GET["lon"]) ? $_GET["lon"] : NULL;
            $timestamp = isset($_GET["timestamp"]) ? $_GET["timestamp"] : NULL;
            $altitude = isset($_GET["altitude"]) ? $_GET["altitude"] : NULL;
            $speed = isset($_GET["speed"]) ? $_GET["speed"] : NULL;
            $bearing = isset($_GET["bearing"]) ? $_GET["bearing"] : NULL;
            $accuracy = isset($_GET["accuracy"]) ? $_GET["accuracy"] : NULL;
            $comment = isset($_GET["comment"]) ? $_GET["comment"] : NULL;
            $postarray = array('v_id'=>$v_id,'latitude'=>$lat,'longitude'=>$lon,'time'=>date('Y-m-d h:i:s'),'altitude'=>$altitude,'speed'=>$speed,'bearing'=>$bearing,'accuracy'=>$accuracy,'comment'=>$comment);
            $this->api_model->add_postion($postarray);
            $this->checkgeofence($v_id,$lat,$lon);
            $response = array('error'=>false,'message'=>['v_id' => $v_id]);
            $this->set_response($response);
           } 
       } else {
           $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; 
           $checklogin = $this->api_model->checkgps_auth($id);   
           if($checklogin) 
           { 
            echo $v_id = $checklogin[0]['v_id'];
            $lat = isset($_REQUEST["lat"]) ? $_REQUEST["lat"] : NULL;
            $lon = isset($_REQUEST["lon"]) ? $_REQUEST["lon"] : NULL;
            $timestamp = isset($_REQUEST["timestamp"]) ? $_REQUEST["timestamp"] : NULL;
            $altitude = isset($_REQUEST["altitude"]) ? $_REQUEST["altitude"] : NULL;
            $speed = isset($_REQUEST["speed"]) ? $_REQUEST["speed"] : NULL;
            $bearing = isset($_REQUEST["bearing"]) ? $_REQUEST["bearing"] : NULL;
            $accuracy = isset($_REQUEST["accuracy"]) ? $_REQUEST["accuracy"] : NULL;
            $comment = isset($_REQUEST["comment"]) ? $_REQUEST["comment"] : NULL;
            $postarray = array('v_id'=>$v_id,'latitude'=>$lat,'longitude'=>$lon,'time'=>date('Y-m-d h:i:s'),'altitude'=>$altitude,'speed'=>$speed,'bearing'=>$bearing,'accuracy'=>$accuracy,'comment'=>$comment);
            $this->api_model->add_postion($postarray);
            $this->checkgeofence($v_id,$lat,$lon);
            $response = array('error'=>false,'message'=>['v_id' => $v_id]);
            $this->set_response($response);
           } 
       }
    }
    // public function positions_post()     //Postion feed to front end   
    // {
    //     $this->db->select("*");
    //     $this->db->from('positions');
    //     $this->db->where('v_id',$this->post('t_vechicle'));
    //     $this->db->where('date(time) >=', date("Y-m-d", strtotime(str_replace('/', '-', $this->post('fromdate')))));
    //     $this->db->where('date(time) <=', date("Y-m-d", strtotime(str_replace('/', '-', $this->post('todate')))));
    //     $query = $this->db->get();
    //     $data = $query->result_array();
    //     $distancefrom = reset($data);
    //     $distanceto = end($data);
    //     $totaldist = $this->totaldistance($distancefrom,$distanceto);
    //     $returndata = array('status'=>1,'data'=>$data,'totaldist'=>$totaldist,'message'=>'data');
    //     $this->set_response($returndata);
    // }
    
    public function totaldistance($distancefrom,$distanceto,$earthRadius = 6371000)
    {
        $latFrom = deg2rad($distancefrom['latitude']);
        $lonFrom = deg2rad($distancefrom['longitude']);
        $latTo = deg2rad($distanceto['latitude']);
        $lonTo = deg2rad($distanceto['longitude']);
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }
    public function positions_post() {
        $this->load->database();
        $unit = sitedata()['s_mapunit']; // 'km' or 'mile'
        $conversionFactor = ($unit === 'mile') ? 0.621371 : 1; // Conversion factor for miles
        $input_start_date = date("Y-m-d", strtotime(str_replace('/', '-', $this->post('fromdate'))));
        $input_end_date = date("Y-m-d", strtotime(str_replace('/', '-', $this->post('todate'))));
        $v_id = $this->post('t_vechicle');
        // Query database
        $query = $this->db->query("
            SELECT 
                p.*,
                t.t_start_date,
                t.t_end_date,
                t.t_trip_fromlocation,
                t.t_trip_tolocation,
                t.t_trip_stops,
                t.t_id
            FROM 
                positions p
            LEFT JOIN 
                trips t 
            ON 
                p.v_id = t.t_vechicle 
                AND p.time BETWEEN t.t_start_date AND t.t_end_date
            WHERE 
                p.time BETWEEN '$input_start_date' AND '$input_end_date' AND p.v_id = '$v_id'
            ORDER BY 
                p.time
        ");
        
        $trips = [];
        $idle = [];
        $totalIdleTime = 0;
        $previousPosition = null;
        $previousIdleTime = null;

        $haversine = function ($lat1, $lon1, $lat2, $lon2) use ($conversionFactor) {
            $earthRadius = 6371; // Radius in kilometers
            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);
            $a = sin($dLat / 2) * sin($dLat / 2) +
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            return $earthRadius * $c * $conversionFactor;
        };

        foreach ($query->result_array() as $row) {
            $distance = 0;
            if ($previousPosition) {
                $distance = $haversine(
                    $previousPosition['latitude'],
                    $previousPosition['longitude'],
                    $row['latitude'],
                    $row['longitude']
                );
            }
            if (!empty($row['t_id'])) {
                $tripId = $row['t_id'];
                if (!isset($trips[$tripId])) {
                    $trips[$tripId] = [
                        'start_time' => $row['t_start_date'],
                        'end_time' => $row['t_end_date'],
                        'fromlocation' => $row['t_trip_fromlocation'],
                        'tolocation' => $row['t_trip_tolocation'],
                        'trip_stops' => $row['t_trip_stops'],
                        'total_distance' => 0,
                        'total_time_hours' => 0,
                        'average_speed' => 0,
                        'positions' => [] // Store positions in an array for each trip
                    ];
                }
                // Add the position to the trip's positions array
                $trips[$tripId]['positions'][] = $row;
                $trips[$tripId]['total_distance'] += round($distance);
                $startTime = strtotime($row['t_start_date']);
                $endTime = strtotime($row['t_end_date']);
                $trips[$tripId]['total_time_hours'] = round(($endTime - $startTime) / 3600, 2);
                $timeInHours = $trips[$tripId]['total_time_hours'];
                $trips[$tripId]['average_speed'] = $timeInHours > 0
                    ? round($trips[$tripId]['total_distance'] / $timeInHours, 2) . " $unit/h"
                    : "0 $unit/h";
            } else {
                $idle[] = $row;

                // Calculate idle time
                if ($previousIdleTime) {
                    $currentIdleTime = strtotime($row['time']);
                    $totalIdleTime += ($currentIdleTime - $previousIdleTime);
                }
                $previousIdleTime = strtotime($row['time']);
            }

            $previousPosition = $row;
        }

        // Convert idle time to hours
        $totalIdleHours = round($totalIdleTime / 3600, 2);
        $output = [
            'trips' => $trips,
            'idle' => $idle,
            'total_idle_hours' => $totalIdleHours
        ];
        $status = (!empty($trips) || !empty($idle)) ? 1 : 0;
        $returndata = array('status'=>$status,'data'=>$output,'totaldist'=>'','message'=>'data');
        $this->set_response($returndata);
    }

    // public function currentpositions_get()     
    // { 
    //     $data = array();
    //     $postions = array();
    //     $this->db->select("p.*,v.v_name,v.v_type,v.v_color");
    //     $this->db->from('positions p');
    //     $this->db->join('vehicles v', 'v.v_id = p.v_id');
    //     $this->db->where('v.v_is_active', 1);
        
    //     if(isset($_GET['uname'])) { $this->db->where('v.v_api_username',$_GET['uname']);  }

    //     if(isset($_GET['gr'])) { $this->db->where('v.v_group',$_GET['gr']);  }

    //     if(isset($_GET['v_id'])) { $this->db->where('v.v_id',$_GET['v_id']);  }

    //     $this->db->where('`id` IN (SELECT MAX(id) FROM positions GROUP BY `v_id`)', NULL, FALSE);
    //     $query = $this->db->get();
    //     $data = $query->result_array();
    //     if(count($data)>=1) {
    //         $resp = array('status'=>1,'data'=>$data);
    //     } else {
    //         $resp = array('status'=>0,'message'=>'No live GPS feed found');
    //     }
    //     $this->set_response($resp);
    // }

    public function currentpositions_get()     
    { 
        $data = array();
        $trips = array();
        $idleVehicles = array();
        $this->db->select("
            v.v_id,
            v.v_name,
            v.v_type,
            v.v_color,
            CASE 
                WHEN NOW() BETWEEN t.t_start_date AND t.t_end_date THEN 'in_trip'
                ELSE 'idle'
            END AS vehicle_status,
            p.latitude,
            p.longitude,
            p.speed,
            p.time AS last_update_time
        ");
        $this->db->from('vehicles v');
        $this->db->join('positions p', 'v.v_id = p.v_id AND p.id = (SELECT MAX(id) FROM positions WHERE v_id = p.v_id)', 'left'); 
        $this->db->join('trips t', 'v.v_id = t.t_vechicle AND NOW() BETWEEN t.t_start_date AND t.t_end_date', 'left');
        $this->db->where('v.v_is_active', 1);
        $this->db->where('p.latitude IS NOT NULL');
        $this->db->where('p.longitude IS NOT NULL');
        $query = $this->db->get();
        $data = $query->result_array();
        foreach ($data as $vehicle) {
            if($vehicle['last_update_time']!='') {
                $vehicle['last_update_time_ago'] = timeAgo($vehicle['last_update_time']);
            } else {
                $vehicle['last_update_time_ago'] = 'No GPS Data';
            }
            if ($vehicle['vehicle_status'] == 'in_trip') {
                $trips[] = $vehicle;
            } else {
                $idleVehicles[] = $vehicle;
            }
        }
        if (count($data) >= 1) {
            $resp = array(
                'status' => 1,
                'in_trip' => $trips,
                'idle' => $idleVehicles,
            );
        } else {
            $resp = array(
                'status' => 0,
                'message' => 'No live GPS feed found'
            );
        }
        $this->set_response($resp);
    }


    public function checkgeofence($vid,$lat,$log)     
    { 
        $vgeofence = $this->geofence_model->getvechicle_geofence($vid);
        if(!empty($vgeofence)) {
            $points = array("$lat $log");
            foreach($vgeofence as $geofencedata) {
                $lastgeo = explode(" ,",$geofencedata['geo_area']);
                $polygon = $geofencedata['geo_area'].$lastgeo[0];
                $polygondata = explode(' , ',$polygon);
                foreach($polygondata as $polygoncln) {
                    $geopolygondata[] = str_replace("," , ' ',$polygoncln); 
                }
                foreach($points as $key => $point) {
                    $geocheck = pointInPolygon($point, $geopolygondata,false);
                    if($geocheck=='outside' || $geocheck=='boundary' || $geocheck=='inside') {
                        $wharray = array('ge_v_id' => $vid, 'ge_geo_id' => $geofencedata['geo_id'], 'ge_event' => $geocheck,
                            'DATE(ge_timestamp)'=>date('Y-m-d'));
                        $geofence_events = $this->db->select('*')->from('geofence_events')->where($wharray)->get()->result_array();
                       
                        if(count($geofence_events)==0) {
                            $insertarray = array('ge_v_id'=>$vid,'ge_geo_id'=>$geofencedata['geo_id'],'ge_event'=>$geocheck,'ge_timestamp'=>
                                       date('Y-m-d h:i:s'));
                            $resp = $this->db->insert('geofence_events',$insertarray);
                            if($resp) {
                                // foreach ($new_notify_members as $member) {
                                //     list($contact, $email, $name, $role) = explode('|', $member);
                                //     if (!isset($existing_notify_map[$contact])) {
                                //         if ($notifyType === 'email' || $notifyType === 'both') {
                                //             $this->send_email($email, $name,$m_id);
                                //         }
                                //         if ($notifyType === 'sms' || $notifyType === 'both') {
                                //             $this->send_sms($contact, $name,$m_id);
                                //         }
                                //     }
                                //     $updated_notify_members[] = $member;
                                // }
                            }
                        } 
                    }
                }
            }
        }
    }
}
