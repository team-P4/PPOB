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
		$this->load->model('mod_admin');
	}
	public function index()
	{
		$this->load->view('loket/index');	
	}
	public function payment()
	{
		$data['number'] = 1;
		$this->load->view('loket/form-bayar',$data);
	}
	public function laporan()
	{
		$this->load->view('loket/laporan');
	}
	public function search()
	{
		$id = $this->input->get('id');
		$where = array('id_pelanggan' => $id,
					   'status' => '0');
		$where2 = array('id_pelanggan' => $id,
					   'status' => '1');
		$where1 = array('id_pelanggan' => $id);
		$data['data']=$this->mod_admin->tampil_di('tagihan',$where);
		$data['number'] = 0;
		$data['name']=$this->mod_admin->tampil_di('pelanggan',$where1);
		$data['lunas']=$this->mod_admin->tampil_di('tagihan',$where2);
		$this->load->view('loket/form-bayar', $data);
	}
}

/* End of file loket.php */
/* Location: ./application/controllers/loket.php */