<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mod_admin');
		$this->load->library(array('dompdf_gen','PHPExcel'));
		$this->load->helper('url','form','download','log');
		if ($this->session->userdata('status')!='login') {
			redirect('login/index');
		}
	}
	//TAMPILAN
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
		$data['provinsi']=$this->mod_admin->provinsi();
		$data['pel'] = $this->mod_admin->tampil('pelanggan');
		$this->load->view('admin/tambah_pelanggan',$data);
	}

	public function laporan()
	{
		$this->load->view('admin/laporan');
	}
	public function tagihan()
	{
		$data['data'] = $this->mod_admin->tampil('pelanggan');
		$this->load->view('admin/tagihan',$data);
	}

	//PROSES//
	public function input_loket()
	{
		$id = $this->mod_admin->get_id_loket();
		if ($id) {
			$nilai = substr($id['kode_pegawai'], 2);
			$nilai_baru = (int) $nilai;
			$nilai_baru++;
			$nilai_baru2 = "LK".str_pad($nilai_baru, 4, "0", STR_PAD_LEFT);
		}else{
			$nilai_baru2 = "LK0001";
		}
		$object = array('kode_pegawai' => $nilai_baru2,
						'username' => $this->input->post('username'),
						'password' => $this->input->post('password'),
						'level' => $this->input->post('level') );
		$this->mod_admin->insert('user',$object);
		redirect('Admin/tloket');
	}

	public function input_pelanggan()
	{
		$id = $this->mod_admin->get_id_pelanggan();
		if ($id) {
			$nilai = substr($id['id_pelanggan'], 2);
			$nilai_baru = (int) $nilai;
			$nilai_baru++;
			$nilai_baru2 = "PL".str_pad($nilai_baru, 4, "0", STR_PAD_LEFT);
		}else{
			$nilai_baru2 = "PL0001";
		}

		$w1 = array('id' => $this->input->post('provinsi'));
		$row_prov = $this->mod_admin->tampil_di('provinces',$w1);
		$w2 = array('id' => $this->input->post('kabupaten'));
		$row_kab = $this->mod_admin->tampil_di('regencies',$w2);
		$w3 = array('id' => $this->input->post('kecamatan'));
		$row_kec = $this->mod_admin->tampil_di('districts',$w3);
		$w4 = array('id' => $this->input->post('kelurahan'));
		$row_kel = $this->mod_admin->tampil_di('villages',$w4);

		$object = array('id_pelanggan' => $nilai_baru2,
						'nama' => $this->input->post('nama'),
						'provinsi' => $row_prov[0]->name,
						'kabupaten_kota' => $row_kab[0]->name,
						'kecamatan' => $row_kec[0]->name,
						'kelurahan_desa' => $row_kel[0]->name,
						'kodepos' => $this->input->post('kode_pos'),
						'alamat' => $this->input->post('alamat'),
						'kodetarif' => $this->input->post('kodetarif'),
						'id_gardu' => $this->input->post('gardu') );
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

		$new_saldo = $this->input->post('saldo1') + $this->input->post('saldo2');

		$object = array('id' => $this->input->post('id_loket'),
						'kode_pegawai' => $this->input->post('kode_pegawai'),
						'username' => $this->input->post('username'),
						'password' => $this->input->post('password'),
						'saldo' => $new_saldo,
						'level' => $this->input->post('level')
						);
		$this->mod_admin->update('user', $where, $object);
		redirect('Admin/tloket');
	}
	public function input_tagihan($id_pel)
	{
		$id = $this->mod_admin->get_id_tagihan();
		if ($id) {
			$nilai = substr($id['id_tagihan'], 2);
			$nilai_baru = (int) $nilai;
			$nilai_baru++;
			$nilai_baru2 = "TG".str_pad($nilai_baru, 4, "0", STR_PAD_LEFT);
		}else{
			$nilai_baru2 = "TG0001";
		}

		$where = array('kode_tarif'=>$this->input->post('kode'));
		$cek  = $this->mod_admin->tampil_di('tarif',$where);
		$num = rand(500,1500);
		$res = $num * $cek[0]->tarifperkwh;
		$object = array('id_tagihan' => $nilai_baru2,
						'tgl_tagihan' => $this->input->post('tgl'),
						'kode_tarif' => $this->input->post('kode'),
						'pemakaian' => $num,
						'total_biaya' => $res ,
						'status' => '0',
						'id_pelanggan' => $id_pel
					);
		$this->mod_admin->insert('tagihan',$object);
		redirect('admin/tagihan');
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
		$data['provinsi']=$this->mod_admin->provinsi();
		$this->load->view('admin/update_pelanggan',$data);
	}

	public function update_pelanggan()
	{
		$where = array('id_pelanggan' => $this->input->post('id_pelanggan'));

		$w1 = array('id' => $this->input->post('provinsi'));
		$row_prov = $this->mod_admin->tampil_di('provinces',$w1);
		$w2 = array('id' => $this->input->post('kabupaten'));
		$row_kab = $this->mod_admin->tampil_di('regencies',$w2);
		$w3 = array('id' => $this->input->post('kecamatan'));
		$row_kec = $this->mod_admin->tampil_di('districts',$w3);
		$w4 = array('id' => $this->input->post('kelurahan'));
		$row_kel = $this->mod_admin->tampil_di('villages',$w4);
		
		$object = array('id_pelanggan' => $this->input->post('id_pelanggan'),
						'nama' => $this->input->post('nama'),
						'provinsi' => $row_prov[0]->name,
						'kabupaten_kota' => $row_kab[0]->name,
						'kecamatan' => $row_kec[0]->name,
						'kelurahan_desa' => $row_kel[0]->name,
						'kodepos' => $this->input->post('kode_pos'),
						'alamat' => $this->input->post('alamat'),
						'kodetarif' => $this->input->post('kodetarif'),
						'id_gardu' => $this->input->post('gardu') );
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

    function ambil_data(){
		$modul=$this->input->post('modul');
		$id=$this->input->post('id');
		if($modul=="kabupaten"){
			echo $this->mod_admin->kabupaten($id);
		}
		else if($modul=="kecamatan"){
			echo $this->mod_admin->kecamatan($id);

		}
		else if($modul=="kelurahan"){
			echo $this->mod_admin->kelurahan($id);
		}
	}

	public function gardu()
	{
		$id1 = $this->mod_admin->get_id_gardu();
		if ($id1) {
			$nilai1 = substr($id1['id_gardu'], 0);
			$nilai_baru1 = (int) $nilai1;
			$nilai_baru1++;
			$nilai_baru1 = str_pad($nilai_baru1, 5, "0", STR_PAD_LEFT);
		}else{
			$nilai_baru1 = "00001";
		}

		$id = $this->mod_admin->get_kode_gardu();
		if ($id) {
			$nilai = substr($id['kode_gardu'], 1);
			$nilai_baru = (int) $nilai;
			$nilai_baru++;
			$nilai_baru2 = "A".str_pad($nilai_baru, 4, "0", STR_PAD_LEFT);
		}else{
			$nilai_baru2 = "A0001";
		}

		$object = array('id_gardu' => $nilai_baru1,
						'nama_gardu' => $this->input->post('grd'),
						'kode_gardu' => $nilai_baru2,
						'jln' => $this->input->post('jln') );
		$this->mod_admin->insert('gardu', $object);
		redirect('Admin/tpelanggan');
	}

	public function laporan_tagihan()
	{
		$this->load->view('admin/laporan_tagihan');

		$this->mod_admin->convert_pdf("Laporan Belum Bayar.pdf");
	}
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */