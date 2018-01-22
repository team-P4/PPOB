<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
<<<<<<< HEAD
		$this->load->model('mod_admin');
		$this->load->helper('url','form','download');
=======
		if ($this->session->userdata('status')!='login') {
			redirect('login/index');
		}
>>>>>>> loket
	}

	public function index()
	{
		$this->load->view('admin/index');
	}

	public function tloket()
	{
		$this->db->where('level', 'loket');
		$data['loket'] = $this->db->get('user')->result();
		$this->load->view('admin/tambah_loket', $data);
	}

	public function tpelanggan()
	{
		$data['pel'] = $this->mod_admin->tampil('pelanggan');
		$this->load->view('admin/tambah_pelanggan',$data);
	}

	public function laporan()
	{
		$this->load->view('admin/laporan');
	}

	public function input_loket()
	{
		$object = array('username' => $this->input->post('username'),
						'password' => $this->input->post('password'),
						'level' => $this->input->post('level') );
		$this->mod_admin->insert('user',$object);
		redirect('Admin/tloket');
	}

	public function input_pelanggan()
	{
		$object = array('id' => $this->input->post('id'),
						'nama' => $this->input->post('nama'),
						'alamat' => $this->input->post('alamat'),
						'kodetarif' => $this->input->post('kodetarif') );
		$this->mod_admin->insert('pelanggan', $object);
		redirect('Admin/tpelanggan');
	}

	public function edit_loket($id)
	{
		$where = array('id' => $id);
		$data['upd'] = $this->mod_admin->tampil_di('user',$where);
		$this->load->view('admin/update_loket',$data);
	}

	public function update_loket()
	{
		$where = array('id' => $this->input->post('id_loket'));
		$object = array('id' => $this->input->post('id_loket'),
						'username' => $this->input->post('username'),
						'password' => $this->input->post('password'),
						'level' => $this->input->post('level')
						);
		$this->mod_admin->update('user', $where, $object);
		redirect('Admin/tloket');
	}

	public function del_loket()
	{
		$list = $this->input->post('list');
		$jumlah_list = count($list);

		for ($i=0; $i < $jumlah_list ; $i++) { 
			$this->db->query("DELETE FROM user WHERE id='$list[$i]' ");
		}
		redirect('Admin/tloket');
	}

	public function edit_pelanggan($id)
	{
		$where = array('id_pelanggan' => $id);
		$data['plg'] = $this->mod_admin->tampil_di('pelanggan', $where);
		$this->load->view('admin/update_pelanggan',$data);
	}

	public function update_pelanggan()
	{
		$where = array('id_pelanggan' => $this->input->post('id_pelanggan'));
		$object = array('id_pelanggan' => $this->input->post('id_pelanggan'),
						'id' => $this->input->post('id'),
						'nama' => $this->input->post('nama'),
						'alamat' => $this->input->post('alamat'),
						'kodetarif' => $this->input->post('kodetarif') );
		$this->mod_admin->update('pelanggan', $where, $object);
		redirect('Admin/tpelanggan');
	}

	public function del_pelanggan()
	{
		$pel = $this->input->post('pel');
		$jumlah_pel = count($pel);

		for ($i=0; $i < $jumlah_pel; $i++) { 
			$this->db->query("DELETE FROM pelanggan WHERE id_pelanggan='$pel[$i]' ");
		}
		redirect('Admin/tpelanggan');
	}

	public function d_loket()
	{
		force_download('./assets/excel/template_loket.xlsx', NULL);
	}

	public function d_pelanggan()
	{
		force_download('./assets/excel/template_pelanggan.xlsx', NULL);
	}
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */