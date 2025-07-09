<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties]
class Vech_check {
    protected $expiry_date;
    public function __construct() {
        $this->CI =& get_instance();
        $this->expiry_date = '2024-07-25';
    }
    public function is_license_valid() {
         $current_date = date('Y-m-d'); 
        if ($current_date <= $this->expiry_date) {
            return true;
        } else {
            return false;
        }
    }
}
