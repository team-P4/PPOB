<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loket extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url','log');
		$this->load->library('dompdf_gen');
		$this->load->model('mod_admin');
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
		$data['id'] = $id;
		$data['data']=$this->mod_admin->tampil_di('tagihan',$where);
		$data['number'] = 0;
		$data['name']=$this->mod_admin->tampil_di('pelanggan',$where1);
		$data['lunas']=$this->mod_admin->tampil_di('tagihan',$where2);
		$this->load->view('loket/form-bayar', $data);
	}

	public function tambah_pembayaran()
	{	
		$where = array('kode_pegawai' => $this->session->userdata('kode_pegawai') );
		$ia = $this->mod_admin->tampil_di('user',$where);

		$saldo = $ia[0]->saldo;

		if ($saldo <= 0) {
			$this->session->set_flashdata('pesan', '
				<div class="alert alert-default" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Maaf!</strong> Saldo yang anda miliki tidak mencukupi untuk melakukan Transaksi Pembayaran Listrik Pascabayar!
				</div>
				');
			$data['number'] = 1;
			redirect('loket/search/?id='.$this->input->post('id_pelanggan'));
		} else {
			$byr = $this->input->post('bayar');

			$byr1 = $saldo - $byr;

			$object = array('saldo' => $byr1 );
			$this->mod_admin->update('user', $where, $object);

			$id = $this->mod_admin->get_id_pembayaran();
			if ($id) {
				$nilai = substr($id['id_pembayaran'], 2);
				$nilai_baru = (int) $nilai;
				$nilai_baru++;
				$nilai_baru2 = "BR".str_pad($nilai_baru, 4, "0", STR_PAD_LEFT);
			}else{
				$nilai_baru2 = "BR0001";
			}
			// $id_pel = $this->input->post('id');
			$plgn = array('id_pelanggan' => $this->input->post('id_pelanggan'));
			$plgn1 = $this->mod_admin->tampil_di('pelanggan',$plgn);


			$list = $this->input->post('list');
			$num = count($list);

			for ($i=0; $i < $num ; $i++) { 
				$where = array('id_tagihan' => $list[$i] );
				$object = array('status' => 1,
								'id_pembayaran' => $nilai_baru2 );

				$this->mod_admin->update('tagihan',$where,$object);
			}
			$object2 = array('id_pembayaran' => $nilai_baru2,
							'id_pelanggan' => $this->input->post('id_pelanggan'),
							'id_loket' => $this->session->userdata('kode_pegawai'),
							'jml_tagihan' => $this->input->post('jumlah_tagihan'),
							'biaya_pln' => 5000,
							'biaya_loket' => 2500, 
							'total' => $this->input->post('biaya_total1'),
							'uang_bayar' => $this->input->post('bayar'),
							'status' => "lunas" );
			$this->mod_admin->insert('pembayaran', $object2);

			helper_log("pembayaran", "Pelanggan ".$this->input->post('id_pelanggan')." telah melunasi tunggakan listrik");

			$this->db->select('pembayaran.*,tagihan.*');
			$this->db->from('pembayaran');
			$this->db->join('tagihan', 'pembayaran.id_pembayaran = tagihan.id_pembayaran', 'left');
			$this->db->where('pembayaran.id_pembayaran', $nilai_baru2);
			$data['pemb'] = $this->db->get()->result();
			$this->load->view('loket/laporan/struk', $data);
		}
	}

	public function noc($id)
	{
		$plgn = array('id_pelanggan' => $id);
		$plgn1 = $this->mod_admin->tampil_di('pelanggan',$plgn);
		$this->session->set_flashdata('pesan', '
				<div class="alert alert-success" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Success!</strong> Pembayaran Tagihan pelanggan '.$plgn1[0]->nama.' telah berhasil dilakukan
				</div>
				');
		redirect('loket/search/?id='.$id);//$this->input->post('id_pelanggan')
	}
}

/* End of file loket.php */
/* Location: ./application/controllers/loket.php */