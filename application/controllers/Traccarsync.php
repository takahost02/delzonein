<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Traccarsync extends REST_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('api_model');
        $this->load->model('geofence_model');

    }  
    public function index_get()     
    {
        $allvech = $this->db->select('v_traccar_id, v_id')
            ->from('vehicles')
            ->where(['v_is_active' => '1'])
            ->where('v_traccar_id !=', '')
            ->get()
            ->result_array();
    
        if (empty($allvech)) {
            echo 'No vehicles';
            return;
        }
        foreach ($allvech as $_ => $vech) {
            $lastSync = $this->db->select_max('time')
                ->from('positions')
                ->where('v_id', $vech['v_id'])
                ->get()
                ->row()
                ->time;
            $startTime = $lastSync ? $this->toUTC($lastSync) : $this->toUTC(date("Y-m-d 00:00:00", strtotime("-1 year")));
            $endTime = $this->toUTC(date("Y-m-d\TH:i:s.000\Z"));
            $apicall = json_decode(traccar_call(
                'api/positions?deviceId=' . $vech['v_traccar_id'] . '&from=' . $startTime . '&to=' . $endTime, '', 'GET'
            ), true);
            if (!is_array($apicall) || empty($apicall)) {
                echo 'No new data for device ' . $vech['v_traccar_id'] . '<br>';
                continue;
            }
            $existing_ids = $this->db->select('traccar_pos_id')
                ->from('positions')
                ->where_in('traccar_pos_id', array_column($apicall, 'id'))
                ->get()
                ->result_array();
            $existing_ids = array_column($existing_ids, 'traccar_pos_id');
            $insert_data = [];
            $total_inserted = 0;
            foreach ($apicall as $_ => $tdata) {
                if (in_array($tdata['id'], $existing_ids)) {
                    echo 'Already sync done for ID ' . $tdata['id'] . '<br>';
                    continue;
                }
                $insert_data[] = [
                    'time'          => date('Y-m-d H:i:s', strtotime($tdata['deviceTime'])), // Match Traccar format
                    'v_id'          => $vech['v_id'],
                    'latitude'      => $tdata['latitude'],
                    'longitude'     => $tdata['longitude'],
                    'altitude'      => $tdata['altitude'],
                    'speed'         => $tdata['speed'],
                    'bearing'       => $tdata['course'],
                    'accuracy'      => $tdata['accuracy'] ?? null,
                    'provider'      => $tdata['protocol'],
                    'comment'       => null,
                    'traccar_pos_id'=> $tdata['id'],
                    'battery_level' => $tdata['attributes']['batteryLevel'] ?? '',
                    'motion'        => $tdata['attributes']['motion'] ?? '',
                    'address'       => $tdata['address'] ?? '',
                ];
                $this->checkgeofence($vech['v_id'], $tdata['latitude'], $tdata['longitude']);
            }
            if (!empty($insert_data)) {
                $this->db->insert_batch('positions', $insert_data);
                $inserted_count = count($insert_data);
                $total_inserted += $inserted_count; // Increment the total count
                echo 'Synced ' . count($insert_data) . ' records for device ' . $vech['v_traccar_id'] . '<br>';
            }
        }
        $summary_log = [
            'tl_time'         => date('Y-m-d H:i:s'),
            'tl_total_records' => $total_inserted
        ];
        $this->db->insert('traccarsync_log', $summary_log);
    }

    function toUTC($dateTime){
        $dt = new DateTime($dateTime, new DateTimeZone(date_default_timezone_get()));
        $dt->setTimezone(new DateTimeZone('UTC'));
        $utcTime = $dt->format('Y-m-d H:i:s');
        $returnObject = new DateTime($utcTime);
        $returnIso = substr($returnObject->format(DateTime::ATOM), 0, -6) . '.000Z';
        return $returnIso;
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
                            $this->db->insert('geofence_events',$insertarray);
                            $this->handle_notifications($geofencedata);
                        } 
                    }
                }
            }
        }
    }

    public function handle_notifications($geo_data) {
        if ($geo_data['geo_notify_type'] === 'both') {
            $notify_members = json_decode($geo_data['geo_notify_members'], true);
            foreach ($notify_members as $member) {
                list($mobile, $email, $role, $type) = explode('|', $member);
                $mobile = isset($mobile) && strpos($mobile, '+') !== 0 ? '+' . $mobile : $mobile;
                $this->send_sms_notification($mobile, $geo_data['geo_id'], $geo_data['geo_name']); 
                $this->send_email_notification($email, $geo_data['geo_id'], $geo_data['geo_name']);
            }
        }
    }
    
    private function send_sms_notification($mobile, $geo_id, $geo_name) {
        $this->load->library('twilio');
        $template = "Your vehicle has reached the geofence: $geo_name";
        echo $smsresp = $this->twilio->sendsms($mobile, $template, $geo_id, 'geofence');
    }
    
    private function send_email_notification($email, $geo_id, $geo_name) {
        $this->load->model('emailsms_model');
        $template = "Your vehicle has reached the geofence: $geo_name.<br><br>";
        $emailsubject = "Geofence Alert - $geo_name";
        $emailresp = $this->emailsms_model->sendemail($email, $emailsubject, $template);
        $log_data = [
            'ref_id' => $geo_id,
            'module' => 'trips',
            'content' => $emailsubject,
            'status' => ($emailresp == 'true') ? 1 : 0,
            'error_description' => ($emailresp == 'true') ? null : $emailresp,
            'to_email' => $email,
            'created_at' => date('Y-m-d H:i:s')
        ];
    
        $this->db->insert('email_log', $log_data);
    
        if ($emailresp == 'true') {
            $this->session->set_flashdata('successmessage', 'Email sent successfully.');
        } else {
            $this->session->set_flashdata('warningmessage', 'Unexpected error..Try again.');
        }
    }
}
