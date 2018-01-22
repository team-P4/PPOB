<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loket extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		if ($this->session->userdata('status')!='login') {
			redirect('login/index');
		}
	}
	public function index()
	{
		$this->load->view('loket/index');	
	}
	public function payment()
	{
		$this->load->view('loket/form-bayar');
	}
	public function laporan()
	{
		$this->load->view('loket/laporan');
	}
}

/* End of file loket.php */
/* Location: ./application/controllers/loket.php */