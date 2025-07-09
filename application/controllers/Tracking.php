<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking extends CI_Controller {

	 function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->load->helper('url');
          $this->load->library('session');
     }

	public function index()
	{
		$this->load->model('trips_model');
		$data['vechiclelist'] = $this->trips_model->getall_vechicle();
		$this->template->template_render('tracking',$data);
	}
	public function livestatus()
	{
		$this->template->template_render('livelocation');
	}

}
