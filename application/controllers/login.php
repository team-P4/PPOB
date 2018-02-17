<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
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
		 					   'kode_pegawai' => $cek[0]->kode_pegawai,
		 					   'saldo' => $cek[0]->saldo,
		 					   'status' => 'login' );
		 $this->session->set_userdata($data_session);
		 helper_log("login", "User ".$cek[0]->username." telah login");
		 redirect('admin');
		}elseif ($cek[0]->level == 'loket') {
		 $data_session = array('nama' => $this->input->post('user') ,
		 					   'kode_pegawai' => $cek[0]->kode_pegawai,
		 					   'saldo' => $cek[0]->saldo,
		 					   'status' => 'login' );
		 $this->session->set_userdata($data_session);
		 helper_log("login", "User ".$cek[0]->username." telah login");
		 redirect('loket');
		}else{
			redirect('login');
		}

	}

	public function logout()
	{
		helper_log("logout", "User ".$cek[0]->username." telah logout");
		$this->session->sess_destroy();
		redirect('login');
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */