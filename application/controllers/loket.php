<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loket extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
	public function index()
	{
		$this->load->view('loket/index');	
	}

}

/* End of file loket.php */
/* Location: ./application/controllers/loket.php */