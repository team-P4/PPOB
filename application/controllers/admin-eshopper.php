<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form','url','download');
		$this->load->library('upload');
		$this->load->model('mod');
		if($this->session->userdata('status')!='login'){
			redirect('login/index');
		}
	}

	public function index()
	{
		$data['tahun'] = "";
		$this->load->view('admin/index', $data);
	}

	public function tambahbarang()
	{
		$this->load->view('admin/barang/tambahbarang');
	}

	public function tambahkategori()
	{
		$kategori=$this->input->post('kategori');
		$object = array('nama' => $kategori);
		$this->mod->tambahdata('kategori',$object);
		redirect('admin/viewbarang');
	}

	public function viewbarang()
	{
		$this->load->database();
		$jumlah_data = $this->mod->jumlah_data('barang');
		$this->load->library('pagination');
		$config['base_url'] = base_url('index.php/admin/viewbarang');
		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = 10;

		$from = $this->uri->segment(3);

		$config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
 
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
 
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
 
        $config['prev_link'] = '&larr; Prev';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
 
        $config['cur_tag_open'] = '<li class="current"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
 
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);		
		$data['barang'] = $this->mod->data('barang',$config['per_page'],$from);
		//$data['barang'] = $this->mod->tampil('barang')->result();
		$this->load->view('admin/barang/barang', $data);
	}

	public function cari_barang()
	{
		$this->load->database();

		$key = $this->input->get('key');

		$search = array('nama_barang' => $key,
						'kategori' => $key,
						'qty' => $key);

		$jumlah_data = $this->mod->jumlah_data_cari('barang', $search);
		$this->load->library('pagination');
		$config['base_url'] = base_url('index.php/admin/viewbarang');
		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = 10;

		$from = $this->uri->segment(3);

		$config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
 
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
 
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
 
        $config['prev_link'] = '&larr; Prev';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
 
        $config['cur_tag_open'] = '<li class="current"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
 
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);		
		$data['barang'] = $this->mod->data_cari('barang',$config['per_page'],$from,$search);
		//$data['barang'] = $this->mod->tampil('barang')->result();
		$this->load->view('admin/barang/barang', $data);
	}

	public function viewimport()
	{
		$data['barang'] = $this->mod->tampil('barang')->result();
		$this->load->view('admin/barang/import.php',$data);
	}

	public function edit($id_barang)
	{
		$where = array('id_barang' => $id_barang );
		$up['data'] = $this->mod->detaildata('barang', $where)->result();
		$this->load->view('admin/barang/updatebarang', $up);
	}

	public function unduh_berpage()
	{
		$this->load->database();
		$jumlah_data = $this->mod->jumlah_data('barang');
		$this->load->library('pagination');
		$config['base_url'] = base_url('index.php/admin/viewbarang');
		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = 10;

		$from = $this->uri->segment(3);

		$data['barang'] = $this->mod->data('barang',$config['per_page'],$from);
		$this->load->view('admin/barang/barang_pdf.php', $data);
	}
	
	public function unduh_pdf()
	{
		$data['barang'] = $this->mod->tampil('barang')->result();
		$this->load->view('admin/barang/barang_pdf.php', $data);
	}

	public function view_updateimgbrg($id_barang)
	{
		$where = array('id_barang' => $id_barang );
		$data['view'] = $this->mod->detaildata('barang', $where)->result();
		$this->load->view('admin/barang/view_updateimgbrg.php', $data);
	}

	public function update_image()
	{
		$image = $this->input->post('image');

		unlink('./uploads/'.$image);
		
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']  = '10000';
		$config['max_width']  = '6144';
		$config['max_height']  = '6144';
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('gambar')){
			$gambar = "";
		}
		else{
			$gambar = $this->upload->file_name;
		}

		$id_barang = $this->input->post('id_barang');

		$where = array('id_barang' => $id_barang );

		$object = array('image' => $gambar);

		$this->mod->updatedata('barang', $where, $object);
		redirect('admin/viewbarang');
	}

	public function update()
	{
			$id_barang = $this->input->post('id_barang');
			$nama_barang = $this->input->post('nama_barang');
			$kategori = $this->input->post('kategori');
			$qty = $this->input->post('qty');
			$harga_barang = $this->input->post('harga_barang');
			$discount = $this->input->post('discount');
			$suplier = $this->input->post('suplier');
			$alamat_suplier = $this->input->post('alamat_suplier');
			$spesifikasi = $this->input->post('spesifikasi');

			$where = array('id_barang' => $id_barang);

			$object = array('id_barang' => $id_barang,
							'nama_barang' => $nama_barang,
							'kategori' => $kategori,
							'qty' => $qty,
							'harga_barang' => $harga_barang,
							'discount' => $discount,
							'suplier' => $suplier,
							'alamat_suplier' => $alamat_suplier,
							'spesifikasi' => $spesifikasi);

			$this->mod->updatedata('barang', $where, $object);
			redirect('admin/viewbarang');
	}

	public function info()
	{	
		$id_barang = $this->input->post('id_barang');
		$nama_barang = $this->input->post('nama_barang');
		$kategori = $this->input->post('kategori');
		$harga_barang = $this->input->post('harga_barang');
		$discount = $this->input->post('discount');
		$spesifikasi = $this->input->post('spesifikasi');
		$gambar = $this->input->post('image');
		$where = array('id_barang' => $id_barang );

		$object = array('id_barang' => $id_barang, 
						'nama_barang' => $nama_barang,
						'kategori' => $kategori,
						'harga_barang' => $harga_barang,
						'discount' => $discount,
						'spesifikasi' => $spesifikasi);

		$this->mod->updatedata('barang', $where, $object);
		redirect('admin/viewbarang');
	}

	public function tambah()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']  = '5000';
		$config['max_width']  = '6000';
		$config['max_height']  = '2048';
		
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('gambar')){
			$gambar = "";
		}
		else{
			$gambar = $this->upload->file_name;
		}

			$nama_barang = $this->input->post('nama_barang');
			$kategori = $this->input->post('kategori');
			$qty = $this->input->post('qty');
			$harga_barang = $this->input->post('harga_barang');
			$discount = $this->input->post('discount');
			$suplier = $this->input->post('suplier');
			$alamat_suplier = $this->input->post('alamat_suplier');
			$spesifikasi = $this->input->post('spesifikasi');

			$object = array('nama_barang' => $nama_barang,
							'kategori' => $kategori,
							'qty' => $qty,
							'harga_barang' => $harga_barang,
							'discount' => $discount,
							'suplier' => $suplier,
							'alamat_suplier' => $alamat_suplier,
							'spesifikasi' => $spesifikasi,
							'image' => $gambar );

			$this->mod->tambahdata2('barang', $object);
			redirect('admin/viewbarang');
	}

	public function hapus($id_barang)
	{
		$where = array('id_barang' => $id_barang );

		$tampil = $this->mod->detaildata('barang', $where)->result();

		foreach ($tampil as $le) {
			$gambar = $le->image;
		}
		unlink('./uploads/'.$gambar);

		$this->mod->hapusdata('barang',$where);
		redirect('admin/viewbarang');
	}

	public function buat_template()
	{
		//$this->load->view('admin/barang/tabel-barang');
		force_download('./assets/images/template.xlsx',NULL);
	}

	public function profil_admin($id_admin)
	{
		$where = array('id_admin' => $id_admin);
		$data['admin'] = $this->mod->detaildata('admin', $where)->result();
		$this->load->view('admin/akun_admin', $data);
	}

	public function edit_admin()
	{
		$id_admin = $this->input->post('id_admin');
		$nama_lengkap = $this->input->post('nama_lengkap');
		$nama_user = $this->input->post('nama_user');
		$password = $this->input->post('password');
		$tempat_lahir = $this->input->post('tempat_lahir'); 
		$tanggal_lahir = $this->input->post('tanggal_lahir');
		$alamat_lengkap = $this->input->post('alamat_lengkap');
		$no_hp = $this->input->post('no_hp');
		$no_telepon = $this->input->post('no_telepon');
		$email = $this->input->post('email');

		$object = array('id_admin' => $id_admin,
						'nama_lengkap' => $nama_lengkap,
						'nama_user' => $nama_user,
						'password' => $password,
						'tempat_lahir' => $tempat_lahir,
						'tanggal_lahir' => $tanggal_lahir,
						'alamat_lengkap' => $alamat_lengkap,
						'no_hp' => $no_hp,
						'no_telepon' => $no_telepon,
						'email' => $email
						);
		$where = array('id_admin' => $id_admin );

		$this->mod->updatedata('admin', $where, $object);

		redirect('admin/index');
	}

	public function view_imgadmn($id_admin)
	{
		$where = array('id_admin' => $id_admin );
		$data['img'] = $this->mod->detaildata('admin', $where)->result();

		$this->load->view('admin/view_imgadmn.php', $data);
	}

	public function update_imgadmn()
	{
		$img = $this->input->post('image');

		unlink('./uploads/'.$img);

		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']  = '100000';
		$config['max_width']  = '6144';
		$config['max_height']  = '6144';
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('gambar')){
			$gambar = "";
		}
		else{
			$gambar = $this->upload->file_name;
		}

		$id_admin = $this->input->post('id_admin');

		$where = array('id_admin' => $id_admin );
		$object = array('image' => $gambar );

		$this->mod->updatedata('admin', $where, $object);

		redirect('admin/index');
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */