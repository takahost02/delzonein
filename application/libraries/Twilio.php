<?php


defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/third_party/twilio/sdk/src/Twilio/autoload.php';

use Twilio\Rest\Client;

class Twilio {  
    private $sid;
    private $token;
    private $client;
    private $from;
    private $ci;

    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->database();
        $settings_twilio = $this->ci->db->select('*')->from('settings_twilio')->get()->result_array();
        $this->sid = (isset($settings_twilio[0]['ss_account_sid']) && $settings_twilio[0]['ss_account_sid']!='') ? $settings_twilio[0]['ss_account_sid']:'';
        $this->token  = (isset($settings_twilio[0]['ss_auth_token']) && $settings_twilio[0]['ss_auth_token']!='') ? $settings_twilio[0]['ss_auth_token']:'';
        $this->from      = (isset($settings_twilio[0]['ss_number']) && $settings_twilio[0]['ss_number']!='') ? $settings_twilio[0]['ss_number']:'';
        $this->client = new Client($this->sid, $this->token);
    }
    public function sendsms($to, $message,$t_id,$module=NULL) {
        try {
            $resp = $this->client->messages->create(
                $to,
                [
                    'from' => $this->from,
                    'body' => $message
                ]
            );
           
            $data = [
                'ref_id' => $t_id,
                'content' => $message,
                'status' => '1',
                'error_code' => null, // No error
                'error_description' => null, // No error description
                'mobile_number' => $to,
                'module' =>$module,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->ci->db->insert('sms_log', $data);
            return true;
        } catch (Exception $e) {
            $data = [
                'ref_id' => $t_id,
                'status' => '0',
                'module' =>$module,
                'content' => $message,
                'error_code' => $e->getCode(),
                'error_description' => $e->getMessage(),
                'mobile_number' => $to,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->ci->db->insert('sms_log', $data);
            return false;
        }
    }
    
}
