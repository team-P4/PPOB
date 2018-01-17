<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('mod');
	}

	public function index()
	{
		$this->load->view('login/index');		
	}

	public function proses()
	{

		$where = array('username'=>$this->input->post('user'),
					  'password'=>$this->input->post('password'));
		
		$cek = $this->mod->cek('user',$where)->result();
		
		if ($cek[0]->level == 'admin') {
		 $data_session = array('nama' => $this->input->post('user') ,
		 						'status' => 'login' );
		 $this->session->set_userdata($data_session);
		 redirect('admin');
		}elseif ($cek[0]->level == 'loket') {
		 $data_session = array('nama' => $this->input->post('user') ,
		 						'status' => 'login' );
		 $this->session->set_userdata($data_session);
		 redirect('loket');
		}else{
			redirect('login');
		}

	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */