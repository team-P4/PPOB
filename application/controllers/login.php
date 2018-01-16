<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}
	public function index()
	{
		$this->load->view('login/index');		
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */