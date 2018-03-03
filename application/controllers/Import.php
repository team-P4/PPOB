<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form','url');
		$this->load->library(array('upload','PHPExcel','dompdf_gen'));
		$this->load->model('mod_admin');
	}

	public function import()
	{
		$config['upload_path'] = './assets/excel/';
		$config['allowed_types'] = 'xls|xlsx|csv';
		$config['max_size']  = '100000';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('file')){
			// $error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('pesan', '
				<div class="alert alert-default" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Maaf!</strong> pastikan anda telah milih file yang ingin diupload sebelum anda mengklik import!
				</div>
				');
			redirect('Admin/tloket');
		}
		else{
			$data = array('upload_data' => $this->upload->data());
		    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
		    $filename = $upload_data['file_name'];
		    $this->mod_admin->import_mod($filename);
		    unlink('./assets/excel/'.$filename);
			$this->session->set_flashdata('pesan', '
				<div class="alert alert-success" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Success!</strong> anda telah berhasil mengimport data user loket!
				</div>
				');
			redirect('Admin/tloket');
		}
	}

	public function import_pel()
	{
		$config['upload_path'] = './assets/excel/';
		$config['allowed_types'] = 'xls|xlsx|csv';
		$config['max_size']  = '100000';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('file')){
			// $error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('pesan', '
				<div class="alert alert-default" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Maaf!</strong> pastikan anda telah milih file yang ingin diupload sebelum anda mengklik import!
				</div>
				');
			redirect('Admin/tpelanggan');
		}
		else{
			$data = array('upload_data' => $this->upload->data());
		    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
		    $filename = $upload_data['file_name'];
		    $this->mod_admin->import1_mod($filename);
		    unlink('./assets/excel/'.$filename);
			$this->session->set_flashdata('pesan', '
				<div class="alert alert-success" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Success!</strong> anda telah berhasil mengimport data pelanggan!
				</div>
				');
			redirect('Admin/tpelanggan');
		}
	}

	public function export_loket_xlsx()
	{
		helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Loket versi excel");
		$objPHPExcel = new PHPExcel();
		$this->db->where('level', 'loket');
		$data = $this->db->get('user');

		$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
		$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
		 
		$objget->setTitle('Sample Sheet'); //sheet title

		$cols = array("A","B","C","D");

		$val = array("kode_pegawai","username","password","level");

		for ($a=0; $a<4 ; $a++) { 
		$objset->setCellValue($cols[$a].'1', $val[$a]);

		  //Setting lebar cell
		  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
		  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
		  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
		  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
		            
		            
		}

		// Mengambil Data
		$baris = 2;
		foreach($data->result() as $data)
		{
		     //pemanggilan sesuaikan dengan nama kolom tabel
		      $objset->setCellValue("A".$baris, $data->kode_pegawai); 
		      $objset->setCellValue("B".$baris, $data->username); 
		      $objset->setCellValue("C".$baris, $data->password); 
		      $objset->setCellValue("D".$baris, $data->level); 

		      $baris++;
		}
		$objPHPExcel->setActiveSheetIndex(0);

		//Set Title
		$objPHPExcel->getActiveSheet()->setTitle('laporan data loket');
		 
		//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		 
		//Header
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		//Nama File
		header('Content-Disposition: attachment;filename="laporan_loket.xlsx"');

		//Download
		$objWriter->save("php://output");
	}

	public function export_loket_pdf()
	{
		$this->db->where('level', 'loket');
		$data['pdf'] = $this->db->get('user')->result();
		$this->load->view('admin/laporan_loket', $data);

		$paper_size  = 'A4'; //paper size
		$orientation = 'landscape'; //tipe format kertas
		$html = $this->output->get_output();
		 
		$this->dompdf->set_paper($paper_size, $orientation);
		//Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("laporan_loket.pdf", array('Attachment'=> true));

	}

	public function export_pelanggan_xlsx()
	{
		helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data pelanggan versi excel");
		$objPHPExcel = new PHPExcel();
		$this->db->where('kode_pegawai', $this->session->userdata('kode_pegawai'));
		$bang = $this->db->get('user')->result();
		if ($bang[0]->level == 'admin') {
			$data = $this->db->get('pelanggan');
		} else {
			$data = $this->db->get('pelanggan');
		}

		$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
		$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
		 
		$objget->setTitle('Sample Sheet'); //sheet title

		$cols = array("A","B","C","D","E","F","G","H","I","J");

		$val = array("id_pelanggan","nama","gardu","provinsi","kabupaten","kecamatan","kelurahan","kode pos","alamat","kodetarif");

		for ($a=0; $a<10 ; $a++) { 
		$objset->setCellValue($cols[$a].'1', $val[$a]);

		  //Setting lebar cell
		  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
		  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
		  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
		  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
		  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
		  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
		  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25); 
		  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25); 
		  $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25); 
		            
		}

		// Mengambil Data
		$baris = 2;
		foreach($data->result() as $data)
		{
			  $this->db->where('id', $data->provinsi);
              $prov = $this->db->get('provinces')->result();

              $this->db->where('id', $data->kabupaten_kota);
              $kab = $this->db->get('regencies')->result();

              $this->db->where('id',$data->kecamatan);
              $kec = $this->db->get('districts')->result();

              $this->db->where('id', $data->kelurahan_desa);
              $kel = $this->db->get('villages')->result();

              $this->db->where('id_tarif', $data->kodetarif);
			  $dsb = $this->db->get('tarif')->result();
		     //pemanggilan sesuaikan dengan nama kolom tabel
		      $objset->setCellValue("A".$baris, $data->id_pelanggan); 
		      $objset->setCellValue("B".$baris, $data->nama); 
		      $objset->setCellValue("C".$baris, $data->id_gardu); 
		      $objset->setCellValue("D".$baris, $prov[0]->name);
		      $objset->setCellValue("E".$baris, $kab[0]->name);  
		      $objset->setCellValue("F".$baris, $kec[0]->name);
		      $objset->setCellValue("G".$baris, $kel[0]->name);
		      $objset->setCellValue("H".$baris, $data->kodepos);   
		      $objset->setCellValue("I".$baris, $data->alamat); 
		      $objset->setCellValue("J".$baris, $dsb[0]->kode_tarif); 

		      $baris++;
		}
		$objPHPExcel->setActiveSheetIndex(0);

		//Set Title
		$objPHPExcel->getActiveSheet()->setTitle('laporan data pelanggan');
		 
		//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		 
		//Header
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		//Nama File
		header('Content-Disposition: attachment;filename="laporan_pelanggan.xlsx"');

		//Download
		$objWriter->save("php://output");
	}

	public function export_pelanggan_pdf()
	{
		helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data pelanggan versi PDF");
		$this->db->where('kode_pegawai', $this->session->userdata('kode_pegawai'));
		$where = array('kode_pegawai' => $this->session->userdata('kode_pegawai') );
		$bang = $this->db->get('user')->result();
		if ($bang[0]->level == 'admin') {
			$data['pel'] = $this->db->get('pelanggan')->result();
		} else {
			$data['pel'] = $this->db->get_where('pelanggan', $where)->result();
		}
		$this->load->view('admin/laporan_pelanggan', $data);
		$this->mod_admin->convert_pdf("Laporan Pelanggan.pdf");
	}

	public function laporan_loket()
	{
		$hari = $this->input->post('hari');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$laporan = $this->input->post('laporan');
		$berdasarkan = $this->input->post('berdasarkan');

		if ($laporan == "excel") {
			if ($berdasarkan == "transaksi") {
				if ($hari == "semua" && $bulan == "semua" && $tahun == "semua") {
					helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi vesri excel");
					$objPHPExcel = new PHPExcel();
					$this->db->where('id_loket', $this->session->userdata('kode_pegawai'));
					$data = $this->db->get('pembayaran');
					
					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G","H","I","J");

					$val = array("ID Pembayaran","Pelanggan","Loket","Jumlah Tagihan","Biaya PLN","Biaya Loket","Total Keseluruhan","Yang dibayar","Status","Tanggal");

					for ($a=0; $a<10 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					foreach($data->result() as $data)
					{
						$this->db->where('id_pelanggan', $data->id_pelanggan);
						 $apa = $this->db->get('pelanggan')->result();
						 $pelanggan = $apa[0]->nama;


						 $this->db->where('kode_pegawai', $data->id_loket);
						 $ata = $this->db->get('user')->result();
						 $loket = $ata[0]->username; 
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $loket); 
					      $objset->setCellValue("D".$baris, $data->jml_tagihan); 
					      $objset->setCellValue("E".$baris, $data->biaya_pln); 
					      $objset->setCellValue("F".$baris, $data->biaya_loket); 
					      $objset->setCellValue("G".$baris, $data->total); 
					      $objset->setCellValue("H".$baris, $data->uang_bayar); 
					      $objset->setCellValue("I".$baris, $data->status); 
					      $objset->setCellValue("J".$baris, $data->tglbayar); 

					      $baris++;
					}
					$objPHPExcel->setActiveSheetIndex(0);

					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data transaksi');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
				} elseif ($hari == "semua" && $bulan == "semua" && $tahun != "semua") {
					
					helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi excel");
					$objPHPExcel = new PHPExcel();
					$loket = $this->session->userdata('kode_pegawai');
					$data = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%Y')='$tahun' ");

					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G","H","I","J");

					$val = array("ID Pembayaran","Pelanggan","Loket","Jumlah Tagihan","Biaya PLN","Biaya Loket","Total Keseluruhan","Yang dibayar","Status","Tanggal");

					for ($a=0; $a<10 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					foreach($data->result() as $data)
					{
						 $this->db->where('id_pelanggan', $data->id_pelanggan);
						 $apa = $this->db->get('pelanggan')->result();
						 $pelanggan = $apa[0]->nama;


						 $this->db->where('kode_pegawai', $data->id_loket);
						 $ata = $this->db->get('user')->result();
						 $loket = $ata[0]->username; 
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $loket); 
					      $objset->setCellValue("D".$baris, $data->jml_tagihan); 
					      $objset->setCellValue("E".$baris, $data->biaya_pln); 
					      $objset->setCellValue("F".$baris, $data->biaya_loket); 
					      $objset->setCellValue("G".$baris, $data->total); 
					      $objset->setCellValue("H".$baris, $data->uang_bayar); 
					      $objset->setCellValue("I".$baris, $data->status); 
					      $objset->setCellValue("J".$baris, $data->tglbayar); 

					      $baris++;
					}
					$objPHPExcel->setActiveSheetIndex(0);

					

					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data transaksi');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
				} elseif ($hari == "semua" && $bulan != "semua" && $tahun == "semua") {
					helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi excel");
					$objPHPExcel = new PHPExcel();
					$loket = $this->session->userdata('kode_pegawai');
					$data = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%m')='$bulan' ");

					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G","H","I","J");

					$val = array("ID Pembayaran","Pelanggan","Loket","Jumlah Tagihan","Biaya PLN","Biaya Loket","Total Keseluruhan","Yang dibayar","Status","Tanggal");

					for ($a=0; $a<10 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					foreach($data->result() as $data)
					{
						 $this->db->where('id_pelanggan', $data->id_pelanggan);
						 $apa = $this->db->get('pelanggan')->result();
						 $pelanggan = $apa[0]->nama;


						 $this->db->where('kode_pegawai', $data->id_loket);
						 $ata = $this->db->get('user')->result();
						 $loket = $ata[0]->username; 
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $loket); 
					      $objset->setCellValue("D".$baris, $data->jml_tagihan); 
					      $objset->setCellValue("E".$baris, $data->biaya_pln); 
					      $objset->setCellValue("F".$baris, $data->biaya_loket); 
					      $objset->setCellValue("G".$baris, $data->total); 
					      $objset->setCellValue("H".$baris, $data->uang_bayar); 
					      $objset->setCellValue("I".$baris, $data->status); 
					      $objset->setCellValue("J".$baris, $data->tglbayar); 

					      $baris++;
					}
					$objPHPExcel->setActiveSheetIndex(0);

					

					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data transaksi');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
				} elseif ($hari != "semua" && $bulan == "semua" && $tahun == "semua") {
					helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi excel");
					$objPHPExcel = new PHPExcel();
					$loket = $this->session->userdata('kode_pegawai');
					$data = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%d')='$hari' ");

					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G","H","I","J");

					$val = array("ID Pembayaran","Pelanggan","Loket","Jumlah Tagihan","Biaya PLN","Biaya Loket","Total Keseluruhan","Yang dibayar","Status","Tanggal");

					for ($a=0; $a<10 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					foreach($data->result() as $data)
					{
						 $this->db->where('id_pelanggan', $data->id_pelanggan);
						 $apa = $this->db->get('pelanggan')->result();
						 $pelanggan = $apa[0]->nama;


						 $this->db->where('kode_pegawai', $data->id_loket);
						 $ata = $this->db->get('user')->result();
						 $loket = $ata[0]->username; 
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $loket); 
					      $objset->setCellValue("D".$baris, $data->jml_tagihan); 
					      $objset->setCellValue("E".$baris, $data->biaya_pln); 
					      $objset->setCellValue("F".$baris, $data->biaya_loket); 
					      $objset->setCellValue("G".$baris, $data->total); 
					      $objset->setCellValue("H".$baris, $data->uang_bayar); 
					      $objset->setCellValue("I".$baris, $data->status); 
					      $objset->setCellValue("J".$baris, $data->tglbayar); 

					      $baris++;
					}
					$objPHPExcel->setActiveSheetIndex(0);

					

					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data transaksi');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
				} elseif ($hari != "semua" && $bulan != "semua" && $tahun != "semua") {
					helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi excel");
					$objPHPExcel = new PHPExcel();
					$loket = $this->session->userdata('kode_pegawai');
					$data = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m')='$bulan' AND date_format(tglbayar, '%Y')='$tahun' ");

					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G","H","I","J");

					$val = array("ID Pembayaran","Pelanggan","Loket","Jumlah Tagihan","Biaya PLN","Biaya Loket","Total Keseluruhan","Yang dibayar","Status","Tanggal");

					for ($a=0; $a<10 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					foreach($data->result() as $data)
					{
						 $this->db->where('id_pelanggan', $data->id_pelanggan);
						 $apa = $this->db->get('pelanggan')->result();
						 $pelanggan = $apa[0]->nama;


						 $this->db->where('kode_pegawai', $data->id_loket);
						 $ata = $this->db->get('user')->result();
						 $loket = $ata[0]->username; 
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $loket); 
					      $objset->setCellValue("D".$baris, $data->jml_tagihan); 
					      $objset->setCellValue("E".$baris, $data->biaya_pln); 
					      $objset->setCellValue("F".$baris, $data->biaya_loket); 
					      $objset->setCellValue("G".$baris, $data->total); 
					      $objset->setCellValue("H".$baris, $data->uang_bayar); 
					      $objset->setCellValue("I".$baris, $data->status); 
					      $objset->setCellValue("J".$baris, $data->tglbayar); 

					      $baris++;
					}
					$objPHPExcel->setActiveSheetIndex(0);

					

					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data transaksi');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
				} elseif ($hari != "semua" && $bulan != "semua" && $tahun == "semua") {
					helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi excel");
					$objPHPExcel = new PHPExcel();
					$loket = $this->session->userdata('kode_pegawai');
					$data = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m')='$bulan' ");

					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G","H","I","J");

					$val = array("ID Pembayaran","Pelanggan","Loket","Jumlah Tagihan","Biaya PLN","Biaya Loket","Total Keseluruhan","Yang dibayar","Status","Tanggal");

					for ($a=0; $a<10 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					foreach($data->result() as $data)
					{
						 $this->db->where('id_pelanggan', $data->id_pelanggan);
						 $apa = $this->db->get('pelanggan')->result();
						 $pelanggan = $apa[0]->nama;


						 $this->db->where('kode_pegawai', $data->id_loket);
						 $ata = $this->db->get('user')->result();
						 $loket = $ata[0]->username; 
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $loket); 
					      $objset->setCellValue("D".$baris, $data->jml_tagihan); 
					      $objset->setCellValue("E".$baris, $data->biaya_pln); 
					      $objset->setCellValue("F".$baris, $data->biaya_loket); 
					      $objset->setCellValue("G".$baris, $data->total); 
					      $objset->setCellValue("H".$baris, $data->uang_bayar); 
					      $objset->setCellValue("I".$baris, $data->status); 
					      $objset->setCellValue("J".$baris, $data->tglbayar); 

					      $baris++;
					}
					$objPHPExcel->setActiveSheetIndex(0);

					

					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data transaksi');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
				} elseif ($hari != "semua" && $bulan == "semua" && $tahun != "semua") {
					helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi excel");
					$objPHPExcel = new PHPExcel();
					$loket = $this->session->userdata('kode_pegawai');
					$data = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%Y')='$tahun' ");
					
					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G","H","I","J");

					$val = array("ID Pembayaran","Pelanggan","Loket","Jumlah Tagihan","Biaya PLN","Biaya Loket","Total Keseluruhan","Yang dibayar","Status","Tanggal");

					for ($a=0; $a<10 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					foreach($data->result() as $data)
					{
						 $this->db->where('id_pelanggan', $data->id_pelanggan);
						 $apa = $this->db->get('pelanggan')->result();
						 $pelanggan = $apa[0]->nama;


						 $this->db->where('kode_pegawai', $data->id_loket);
						 $ata = $this->db->get('user')->result();
						 $loket = $ata[0]->username; 
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $loket); 
					      $objset->setCellValue("D".$baris, $data->jml_tagihan); 
					      $objset->setCellValue("E".$baris, $data->biaya_pln); 
					      $objset->setCellValue("F".$baris, $data->biaya_loket); 
					      $objset->setCellValue("G".$baris, $data->total); 
					      $objset->setCellValue("H".$baris, $data->uang_bayar); 
					      $objset->setCellValue("I".$baris, $data->status); 
					      $objset->setCellValue("J".$baris, $data->tglbayar); 

					      $baris++;
					}
					$objPHPExcel->setActiveSheetIndex(0);

					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data transaksi');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
				} elseif ($hari == "semua" && $bulan != "semua" && $tahun != "semua") {
					helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi excel");
					$objPHPExcel = new PHPExcel();
					$loket = $this->session->userdata('kode_pegawai');
					$data = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%m')='$bulan' AND date_format(tglbayar, '%Y')='$tahun' ");

					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G","H","I","J");

					$val = array("ID Pembayaran","Pelanggan","Loket","Jumlah Tagihan","Biaya PLN","Biaya Loket","Total Keseluruhan","Yang dibayar","Status","Tanggal");

					for ($a=0; $a<10 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					foreach($data->result() as $data)
					{
						 $this->db->where('id_pelanggan', $data->id_pelanggan);
						 $apa = $this->db->get('pelanggan')->result();
						 $pelanggan = $apa[0]->nama;


						 $this->db->where('kode_pegawai', $data->id_loket);
						 $ata = $this->db->get('user')->result();
						 $loket = $ata[0]->username; 
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $loket); 
					      $objset->setCellValue("D".$baris, $data->jml_tagihan); 
					      $objset->setCellValue("E".$baris, $data->biaya_pln); 
					      $objset->setCellValue("F".$baris, $data->biaya_loket); 
					      $objset->setCellValue("G".$baris, $data->total); 
					      $objset->setCellValue("H".$baris, $data->uang_bayar); 
					      $objset->setCellValue("I".$baris, $data->status); 
					      $objset->setCellValue("J".$baris, $data->tglbayar); 

					      $baris++;
					}
					$objPHPExcel->setActiveSheetIndex(0);

					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data transaksi');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
				}
			} else {
				if ($hari == "semua" && $bulan == "semua" && $tahun == "semua") {
					helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data pendapatan versi excel");
					$objPHPExcel = new PHPExcel();
					$this->db->where('id_loket', $this->session->userdata('kode_pegawai'));
					$data = $this->db->get('pembayaran');
					$eh = 0;
					
					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G");

					$val = array("ID Pembayaran","Pelanggan","Loket","Status","Tanggal","Total Keseluruhan","Yang dibayar");

					for ($a=0; $a<7 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					$jum = $data->num_rows();
					$tot = 2 + $jum;
					foreach($data->result() as $data)
					{
						$eh += $data->total;
						 $this->db->where('id_pelanggan', $data->id_pelanggan);
						 $apa = $this->db->get('pelanggan')->result();
						 $pelanggan = $apa[0]->nama;


						 $this->db->where('kode_pegawai', $data->id_loket);
						 $ata = $this->db->get('user')->result();
						 $loket = $ata[0]->username; 
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $loket); 
					      $objset->setCellValue("D".$baris, $data->status); 
					      $objset->setCellValue("E".$baris, $data->tglbayar);  
					      $objset->setCellValue("F".$baris, number_format($data->total,2,',','.'))
					      	->getStyle("F".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
					      $objset->setCellValue("G".$baris, number_format($data->uang_bayar,2,',','.'))
					      	->getStyle("G".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

					      $baris++;
					}

					$objset->setCellValue("A".$tot, "Total Keseluruhan");
					$objset->setCellValue("F".$tot, number_format($eh,2,',','.'))
						->getStyle("F".$tot)
    					->getAlignment()
    					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$objPHPExcel->setActiveSheetIndex(0);



					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data pendapatan');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
				} elseif ($hari == "semua" && $bulan == "semua" && $tahun != "semua") {
					helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi excel");
					$objPHPExcel = new PHPExcel();
					$loket = $this->session->userdata('kode_pegawai');
					$data = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%Y')='$tahun' ");
					$eh = 0;
					
					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G");

					$val = array("ID Pembayaran","Pelanggan","Loket","Status","Tanggal","Total Keseluruhan","Yang dibayar");

					for ($a=0; $a<7 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					$jum = $data->num_rows();
					$tot = 2 + $jum;
					foreach($data->result() as $data)
					{
						$eh += $data->total;
						 $this->db->where('id_pelanggan', $data->id_pelanggan);
						 $apa = $this->db->get('pelanggan')->result();
						 $pelanggan = $apa[0]->nama;


						 $this->db->where('kode_pegawai', $data->id_loket);
						 $ata = $this->db->get('user')->result();
						 $loket = $ata[0]->username; 
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $loket); 
					      $objset->setCellValue("D".$baris, $data->status); 
					      $objset->setCellValue("E".$baris, $data->tglbayar);  
					      $objset->setCellValue("F".$baris, number_format($data->total,2,',','.'))
					      	->getStyle("F".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
					      $objset->setCellValue("G".$baris, number_format($data->uang_bayar,2,',','.'))
					      	->getStyle("G".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

					      $baris++;
					}

					$objset->setCellValue("A".$tot, "Total Keseluruhan");
					$objset->setCellValue("F".$tot, number_format($eh,2,',','.'))
						->getStyle("F".$tot)
    					->getAlignment()
    					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$objPHPExcel->setActiveSheetIndex(0);



					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data transaksi');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
				} elseif ($hari == "semua" && $bulan != "semua" && $tahun == "semua") {
					helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi excel");
					$objPHPExcel = new PHPExcel();
					$loket = $this->session->userdata('kode_pegawai');
					$data = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%m')='$bulan' ");
					$eh = 0;

					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G");

					$val = array("ID Pembayaran","Pelanggan","Loket","Status","Tanggal","Total Keseluruhan","Yang dibayar");

					for ($a=0; $a<7 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					$jum = $data->num_rows();
					$tot = 2 + $jum;
					foreach($data->result() as $data)
					{
						$eh += $data->total;
						 $this->db->where('id_pelanggan', $data->id_pelanggan);
						 $apa = $this->db->get('pelanggan')->result();
						 $pelanggan = $apa[0]->nama;


						 $this->db->where('kode_pegawai', $data->id_loket);
						 $ata = $this->db->get('user')->result();
						 $loket = $ata[0]->username; 
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $loket); 
					      $objset->setCellValue("D".$baris, $data->status); 
					      $objset->setCellValue("E".$baris, $data->tglbayar);  
					      $objset->setCellValue("F".$baris, number_format($data->total,2,',','.'))
					      	->getStyle("F".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
					      $objset->setCellValue("G".$baris, number_format($data->uang_bayar,2,',','.'))
					      	->getStyle("G".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

					      $baris++;
					}

					$objset->setCellValue("A".$tot, "Total Keseluruhan");
					$objset->setCellValue("F".$tot, number_format($eh,2,',','.'))
						->getStyle("F".$tot)
    					->getAlignment()
    					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$objPHPExcel->setActiveSheetIndex(0);



					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data transaksi');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
				} elseif ($hari != "semua" && $bulan == "semua" && $tahun == "semua") {
					helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi excel");
					$objPHPExcel = new PHPExcel();
					$loket = $this->session->userdata('kode_pegawai');
					$data = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%d')='$hari' ");
					$eh = 0;

					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G");

					$val = array("ID Pembayaran","Pelanggan","Loket","Status","Tanggal","Total Keseluruhan","Yang dibayar");

					for ($a=0; $a<7 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					$jum = $data->num_rows();
					$tot = 2 + $jum;
					foreach($data->result() as $data)
					{
						$eh += $data->total;
						 $this->db->where('id_pelanggan', $data->id_pelanggan);
						 $apa = $this->db->get('pelanggan')->result();
						 $pelanggan = $apa[0]->nama;


						 $this->db->where('kode_pegawai', $data->id_loket);
						 $ata = $this->db->get('user')->result();
						 $loket = $ata[0]->username; 
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $loket); 
					      $objset->setCellValue("D".$baris, $data->status); 
					      $objset->setCellValue("E".$baris, $data->tglbayar);  
					      $objset->setCellValue("F".$baris, number_format($data->total,2,',','.'))
					      	->getStyle("F".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
					      $objset->setCellValue("G".$baris, number_format($data->uang_bayar,2,',','.'))
					      	->getStyle("G".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

					      $baris++;
					}

					$objset->setCellValue("A".$tot, "Total Keseluruhan");
					$objset->setCellValue("F".$tot, number_format($eh,2,',','.'))
						->getStyle("F".$tot)
    					->getAlignment()
    					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$objPHPExcel->setActiveSheetIndex(0);



					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data transaksi');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
				} elseif ($hari != "semua" && $bulan != "semua" && $tahun != "semua") {
					helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi excel");
					$objPHPExcel = new PHPExcel();
					$loket = $this->session->userdata('kode_pegawai');
					$data = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m')='$bulan' AND date_format(tglbayar, '%Y')='$tahun' ");
					$eh = 0;

					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G");

					$val = array("ID Pembayaran","Pelanggan","Loket","Status","Tanggal","Total Keseluruhan","Yang dibayar");

					for ($a=0; $a<7 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					$jum = $data->num_rows();
					$tot = 2 + $jum;
					foreach($data->result() as $data)
					{
						$eh += $data->total;
						 $this->db->where('id_pelanggan', $data->id_pelanggan);
						 $apa = $this->db->get('pelanggan')->result();
						 $pelanggan = $apa[0]->nama;


						 $this->db->where('kode_pegawai', $data->id_loket);
						 $ata = $this->db->get('user')->result();
						 $loket = $ata[0]->username; 
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $loket); 
					      $objset->setCellValue("D".$baris, $data->status); 
					      $objset->setCellValue("E".$baris, $data->tglbayar);  
					      $objset->setCellValue("F".$baris, number_format($data->total,2,',','.'))
					      	->getStyle("F".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
					      $objset->setCellValue("G".$baris, number_format($data->uang_bayar,2,',','.'))
					      	->getStyle("G".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

					      $baris++;
					}

					$objset->setCellValue("A".$tot, "Total Keseluruhan");
					$objset->setCellValue("F".$tot, number_format($eh,2,',','.'))
						->getStyle("F".$tot)
    					->getAlignment()
    					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$objPHPExcel->setActiveSheetIndex(0);



					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data transaksi');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
				} elseif ($hari != "semua" && $bulan != "semua" && $tahun == "semua") {
					helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi excel");
					$objPHPExcel = new PHPExcel();
					$loket = $this->session->userdata('kode_pegawai');
					$data = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m')='$bulan' ");
					$eh = 0;

					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G");

					$val = array("ID Pembayaran","Pelanggan","Loket","Status","Tanggal","Total Keseluruhan","Yang dibayar");

					for ($a=0; $a<7 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					$jum = $data->num_rows();
					$tot = 2 + $jum;
					foreach($data->result() as $data)
					{
						$eh += $data->total;
						 $this->db->where('id_pelanggan', $data->id_pelanggan);
						 $apa = $this->db->get('pelanggan')->result();
						 $pelanggan = $apa[0]->nama;


						 $this->db->where('kode_pegawai', $data->id_loket);
						 $ata = $this->db->get('user')->result();
						 $loket = $ata[0]->username; 
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $loket); 
					      $objset->setCellValue("D".$baris, $data->status); 
					      $objset->setCellValue("E".$baris, $data->tglbayar);  
					      $objset->setCellValue("F".$baris, number_format($data->total,2,',','.'))
					      	->getStyle("F".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
					      $objset->setCellValue("G".$baris, number_format($data->uang_bayar,2,',','.'))
					      	->getStyle("G".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

					      $baris++;
					}

					$objset->setCellValue("A".$tot, "Total Keseluruhan");
					$objset->setCellValue("F".$tot, number_format($eh,2,',','.'))
						->getStyle("F".$tot)
    					->getAlignment()
    					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$objPHPExcel->setActiveSheetIndex(0);



					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data transaksi');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
				} elseif ($hari != "semua" && $bulan == "semua" && $tahun != "semua") {
					helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi excel");
					$objPHPExcel = new PHPExcel();
					$loket = $this->session->userdata('kode_pegawai');
					$data = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%Y')='$tahun' ");
					$eh = 0;

					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G");

					$val = array("ID Pembayaran","Pelanggan","Loket","Status","Tanggal","Total Keseluruhan","Yang dibayar");

					for ($a=0; $a<7 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					$jum = $data->num_rows();
					$tot = 2 + $jum;
					foreach($data->result() as $data)
					{
						$eh += $data->total;
						 $this->db->where('id_pelanggan', $data->id_pelanggan);
						 $apa = $this->db->get('pelanggan')->result();
						 $pelanggan = $apa[0]->nama;


						 $this->db->where('kode_pegawai', $data->id_loket);
						 $ata = $this->db->get('user')->result();
						 $loket = $ata[0]->username; 
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $loket); 
					      $objset->setCellValue("D".$baris, $data->status); 
					      $objset->setCellValue("E".$baris, $data->tglbayar);  
					      $objset->setCellValue("F".$baris, number_format($data->total,2,',','.'))
					      	->getStyle("F".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
					      $objset->setCellValue("G".$baris, number_format($data->uang_bayar,2,',','.'))
					      	->getStyle("G".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

					      $baris++;
					}

					$objset->setCellValue("A".$tot, "Total Keseluruhan");
					$objset->setCellValue("F".$tot, number_format($eh,2,',','.'))
						->getStyle("F".$tot)
    					->getAlignment()
    					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$objPHPExcel->setActiveSheetIndex(0);



					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data transaksi');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
				} elseif ($hari == "semua" && $bulan != "semua" && $tahun != "semua") {
					helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi excel");
					$objPHPExcel = new PHPExcel();
					$loket = $this->session->userdata('kode_pegawai');
					$data = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%m')='$bulan' AND date_format(tglbayar, '%Y')='$tahun' ");
					$eh = 0;

					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G");

					$val = array("ID Pembayaran","Pelanggan","Loket","Status","Tanggal","Total Keseluruhan","Yang dibayar");

					for ($a=0; $a<7 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					$jum = $data->num_rows();
					$tot = 2 + $jum;
					foreach($data->result() as $data)
					{
						$eh += $data->total;
						 $this->db->where('id_pelanggan', $data->id_pelanggan);
						 $apa = $this->db->get('pelanggan')->result();
						 $pelanggan = $apa[0]->nama;


						 $this->db->where('kode_pegawai', $data->id_loket);
						 $ata = $this->db->get('user')->result();
						 $loket = $ata[0]->username; 
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $loket); 
					      $objset->setCellValue("D".$baris, $data->status); 
					      $objset->setCellValue("E".$baris, $data->tglbayar);  
					      $objset->setCellValue("F".$baris, number_format($data->total,2,',','.'))
					      	->getStyle("F".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
					      $objset->setCellValue("G".$baris, number_format($data->uang_bayar,2,',','.'))
					      	->getStyle("G".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

					      $baris++;
					}

					$objset->setCellValue("A".$tot, "Total Keseluruhan");
					$objset->setCellValue("F".$tot, number_format($eh,2,',','.'))
						->getStyle("F".$tot)
    					->getAlignment()
    					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$objPHPExcel->setActiveSheetIndex(0);



					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data transaksi');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
				}
			}
					
		} else {
			if ($berdasarkan == "transaksi") {
				if ($hari == "semua" AND $bulan == "semua" && $tahun == "semua") {
					$this->db->where('id_loket', $this->session->userdata('kode_pegawai'));
					$data['trk'] = $this->db->get('pembayaran')->result();
					helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi PDF");
					$this->load->view('loket/laporan/laporan_semua',$data);

					$this->mod_admin->convert_pdf("Laporan Transaksi.pdf");
				} elseif ($hari == "semua" AND $bulan == "semua" && $tahun != "semua") {
					$loket = $this->session->userdata('kode_pegawai');
					$data['trk'] = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%Y')='$tahun' ")->result();
					helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi PDF");
					$this->load->view('loket/laporan/laporan_semua',$data);

					$this->mod_admin->convert_pdf("Laporan Transaksi.pdf");
				} elseif ($hari == "semua" AND $bulan != "semua" && $tahun == "semua") {
					$loket = $this->session->userdata('kode_pegawai');
					$data['trk'] = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%m')='$bulan' ")->result();
					helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi PDF");
					$this->load->view('loket/laporan/laporan_semua',$data);

					$this->mod_admin->convert_pdf("Laporan Transaksi.pdf");
				} elseif ($hari != "semua" AND $bulan == "semua" && $tahun == "semua") {
					$loket = $this->session->userdata('kode_pegawai');
					$data['trk'] = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%d')='$hari' ")->result();
					helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi PDF");
					$this->load->view('loket/laporan/laporan_semua',$data);

					$this->mod_admin->convert_pdf("Laporan Transaksi.pdf");
				} elseif ($hari != "semua" AND $bulan != "semua" && $tahun != "semua") {
					$loket = $this->session->userdata('kode_pegawai');
					$data['trk'] = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m')='$bulan' AND date_format(tglbayar, '%Y')='$tahun' ")->result();
					helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi PDF");
					$this->load->view('loket/laporan/laporan_semua',$data);

					$this->mod_admin->convert_pdf("Laporan Transaksi.pdf");
				} elseif ($hari != "semua" AND $bulan == "semua" && $tahun != "semua") {
					$loket = $this->session->userdata('kode_pegawai');
					$data['trk'] = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%d') = '$hari' AND date_format(tglbayar, '%Y')='$tahun' ")->result();
					helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi PDF");
					$this->load->view('loket/laporan/laporan_semua',$data);

					$this->mod_admin->convert_pdf("Laporan Transaksi.pdf");
				} elseif ($hari != "semua" AND $bulan != "semua" && $tahun == "semua") {
					$loket = $this->session->userdata('kode_pegawai');
					$data['trk'] = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%d') = '$hari' AND date_format(tglbayar, '%m')='$bulan' ")->result();
					helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi PDF");
					$this->load->view('loket/laporan/laporan_semua',$data);

					$this->mod_admin->convert_pdf("Laporan Transaksi.pdf");
				} elseif ($hari == "semua" AND $bulan != "semua" && $tahun != "semua") {
					$loket = $this->session->userdata('kode_pegawai');
					$data['trk'] = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%m') = '$bulan' AND date_format(tglbayar, '%Y') = '$tahun' ")->result();
					helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi PDF");
					$this->load->view('loket/laporan/laporan_semua',$data);
					$this->mod_admin->convert_pdf("Laporan Transaksi.pdf");
				}
			} else {
				if ($hari == "semua" AND $bulan == "semua" && $tahun == "semua") {
					$this->db->where('id_loket', $loket = $this->session->userdata('kode_pegawai'));
					$data['pen'] = $this->db->get('pembayaran')->result();
					helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
					$this->load->view('loket/laporan/laporan_penbul', $data);

					$this->mod_admin->convert_pdf("Laporan Pendapatan.pdf");
				} elseif ($hari == "semua" AND $bulan == "semua" && $tahun != "semua") {
					$loket = $this->session->userdata('kode_pegawai');
					$data['pen'] = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%Y')='$tahun' ")->result();
					helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
					$this->load->view('loket/laporan/laporan_penbul', $data);	

					$this->mod_admin->convert_pdf("Laporan Pendapatan.pdf");
				} elseif ($hari == "semua" AND $bulan != "semua" && $tahun == "semua") {
					$loket = $this->session->userdata('kode_pegawai');
					$data['pen'] = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%m')='$bulan' ")->result();
					helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
					$this->load->view('loket/laporan/laporan_penbul', $data);	

					$this->mod_admin->convert_pdf("Laporan Pendapatan.pdf");
				} elseif ($hari != "semua" AND $bulan == "semua" && $tahun == "semua") {
					$loket = $this->session->userdata('kode_pegawai');
					$data['pen'] = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%d')='$hari' ")->result();
					helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
					$this->load->view('loket/laporan/laporan_penbul', $data);	

					$this->mod_admin->convert_pdf("Laporan Pendapatan.pdf");
				} elseif ($hari != "semua" AND $bulan != "semua" && $tahun == "semua") {
					$loket = $this->session->userdata('kode_pegawai');
					$data['pen'] = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m')='$bulan' ")->result();
					helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
					$this->load->view('loket/laporan/laporan_penbul', $data);

					$this->mod_admin->convert_pdf("Laporan Pendapatan.pdf");
				} elseif ($hari != "semua" AND $bulan == "semua" && $tahun != "semua") {
					$loket = $this->session->userdata('kode_pegawai');
					$data['pen'] = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%Y')='$tahun' ")->result();
					helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
					$this->load->view('loket/laporan/laporan_penbul', $data);	

					$this->mod_admin->convert_pdf("Laporan Pendapatan.pdf");
				} elseif ($hari == "semua" AND $bulan != "semua" && $tahun != "semua") {
					$loket = $this->session->userdata('kode_pegawai');
					$data['pen'] = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%m')='$bulan' AND date_format(tglbayar, '%Y')='$tahun' ")->result();
					helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
					$this->load->view('loket/laporan/laporan_penbul', $data);	

					$this->mod_admin->convert_pdf("Laporan Pendapatan.pdf");
				} elseif ($hari != "semua" AND $bulan != "semua" && $tahun != "semua") {
					$loket = $this->session->userdata('kode_pegawai');
					$data['pen'] = $this->db->query("SELECT * FROM pembayaran WHERE id_loket='$loket' AND date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m')='$bulan' AND date_format(tglbayar, '%Y')='$tahun' ")->result();
					helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
					$this->load->view('loket/laporan/laporan_penbul', $data);

					$this->mod_admin->convert_pdf("Laporan Pendapatan.pdf");
				}
			}
		}	
	}

	public function laporan_loketbeet()
	{
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
		$loket = $this->input->post('loket');
		$berdasarkan = $this->input->post('berdasarkan');
		$laporan = $this->input->post('laporan');

		if ($laporan == "excel") {
			helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data pendapatan versi excel");
					$objPHPExcel = new PHPExcel();
					if ($loket == "semua") {
						$data = $this->db->query("SELECT * FROM pembayaran WHERE (tglbayar BETWEEN '$tgl1' AND '$tgl2')");
					} else {
						$data = $this->db->query("SELECT * FROM pembayaran WHERE (tglbayar BETWEEN '$tgl1' AND '$tgl2') AND id_loket='$loket' ");
					}
					$eh = 0;
					foreach ($data->result() as $key) {
						$eh += $key->total;
					}

					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F");

					$val = array("ID Pembayaran","Pelanggan","Status","Tanggal","Total Keseluruhan","Yang dibayar");

					for ($a=0; $a<6; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					$jum = $data->num_rows();
					$tot = 2 + $jum;
					foreach($data->result() as $data)
					{

						$this->db->where('id_pelanggan', $data->id_pelanggan);
						$apa = $this->db->get('pelanggan')->result();
						$pelanggan = $apa[0]->nama;
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan);
					      $objset->setCellValue("C".$baris, $data->status); 
					      $objset->setCellValue("D".$baris, $data->tglbayar);  
					      $objset->setCellValue("E".$baris, number_format($data->total,2,',','.'))
					      	->getStyle("E".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
					      $objset->setCellValue("F".$baris, number_format($data->uang_bayar,2,',','.'))
					      	->getStyle("F".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

					      $baris++;
					}

					$objset->setCellValue("A".$tot, "Total Keseluruhan");
					$objset->setCellValue("E".$tot, number_format($eh,2,',','.'))
						->getStyle("E".$tot)
    					->getAlignment()
    					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$objPHPExcel->setActiveSheetIndex(0);



					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data pendapatan');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_pendapatan.xlsx"');

					//Download
					$objWriter->save("php://output");
		} else {
			if ($loket == "semua") {
				$data['pen'] = $this->db->query("SELECT * FROM pembayaran WHERE (tglbayar BETWEEN '$tgl1' AND '$tgl2') ")->result();			
			} else {
				$data['pen'] = $this->db->query("SELECT * FROM pembayaran WHERE (tglbayar BETWEEN '$tgl1' AND '$tgl2') AND id_loket='$loket' ")->result();			
			}
			helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
			$this->load->view('loket/laporan/laporan_penbul', $data);

			$this->mod_admin->convert_pdf("Laporan Pendapatan.pdf");
		}
	}

	public function laporan_loketming()
	{
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
		$sess = $this->session->userdata('kode_pegawai');
		$berdasarkan = $this->input->post('berdasarkan');
		$laporan = $this->input->post('laporan');

		if ($laporan == "excel") {
			if ($berdasarkan == "transaksi") {
				helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi excel");
					$objPHPExcel = new PHPExcel();
					$data = $this->db->query("SELECT * FROM pembayaran WHERE (tglbayar BETWEEN '$tgl1' AND '$tgl2') AND id_loket='$sess' ");

					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F","G","H","I");

					$val = array("ID Pembayaran","Pelanggan","Jumlah Tagihan","Biaya PLN","Biaya Loket","Total Keseluruhan","Yang dibayar","Status","Tanggal");

					for ($a=0; $a<9 ; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					foreach($data->result() as $data)
					{

						$this->db->where('id_pelanggan', $data->id_pelanggan);
						$apa = $this->db->get('pelanggan')->result();
						$pelanggan = $apa[0]->nama;
					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan); 
					      $objset->setCellValue("C".$baris, $data->jml_tagihan); 
					      $objset->setCellValue("D".$baris, $data->biaya_pln); 
					      $objset->setCellValue("E".$baris, $data->biaya_loket); 
					      $objset->setCellValue("F".$baris, $data->total); 
					      $objset->setCellValue("G".$baris, $data->uang_bayar); 
					      $objset->setCellValue("H".$baris, $data->status); 
					      $objset->setCellValue("I".$baris, $data->tglbayar); 

					      $baris++;
					}
					$objPHPExcel->setActiveSheetIndex(0);

					

					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data transaksi');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');

					//Download
					$objWriter->save("php://output");
			} else {
				helper_log("cetak_excel", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data pendapatam versi excel");
					$objPHPExcel = new PHPExcel();
					$data = $this->db->query("SELECT * FROM pembayaran WHERE (tglbayar BETWEEN '$tgl1' AND '$tgl2') AND id_loket='$sess' ");
					$eh = 0;
					foreach ($data->result() as $key) {
						$eh += $key->total;
					}

					$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
					$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
					 
					$objget->setTitle('Sample Sheet'); //sheet title

					$cols = array("A","B","C","D","E","F");

					$val = array("ID Pembayaran","Pelanggan","Status","Tanggal","Total Keseluruhan","Yang dibayar");

					for ($a=0; $a<6; $a++) { 
					$objset->setCellValue($cols[$a].'1', $val[$a]);

					  //Setting lebar cell
					  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
					  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
					            
					}

					// Mengambil Data
					$baris = 2;
					$jum = $data->num_rows();
					$tot = 2 + $jum;
					foreach($data->result() as $data)
					{
						$this->db->where('id_pelanggan', $data->id_pelanggan);
						$apa = $this->db->get('pelanggan')->result();
						$pelanggan = $apa[0]->nama;

					     //pemanggilan sesuaikan dengan nama kolom tabel
					      $objset->setCellValue("A".$baris, $data->id_pembayaran); 
					      $objset->setCellValue("B".$baris, $pelanggan);
					      $objset->setCellValue("C".$baris, $data->status); 
					      $objset->setCellValue("D".$baris, $data->tglbayar);  
					      $objset->setCellValue("E".$baris, number_format($data->total,2,',','.'))
					      	->getStyle("E".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
					      $objset->setCellValue("F".$baris, number_format($data->uang_bayar,2,',','.'))
					      	->getStyle("F".$baris)
    						->getAlignment()
    						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

					      $baris++;
					}

					$objset->setCellValue("A".$tot, "Total Keseluruhan");
					$objset->setCellValue("E".$tot, number_format($eh,2,',','.'))
						->getStyle("E".$tot)
    					->getAlignment()
    					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$objPHPExcel->setActiveSheetIndex(0);



					//Set Title
					$objPHPExcel->getActiveSheet()->setTitle('laporan data pendapatan');
					 
					//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					 
					//Header
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					//Nama File
					header('Content-Disposition: attachment;filename="laporan_pendapatan.xlsx"');

					//Download
					$objWriter->save("php://output");
			}
		} else {
			if ($berdasarkan == "transaksi") {
				$data['trk'] = $this->db->query("SELECT * FROM pembayaran WHERE (tglbayar BETWEEN '$tgl1' AND '$tgl2') AND id_loket='$sess' ")->result();
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data transaksi versi PDF");
				$this->load->view('loket/laporan/laporan_semua',$data);

				$this->mod_admin->convert_pdf("Laporan Transaksi.pdf");
			} else {
				$data['pen'] = $this->db->query("SELECT * FROM pembayaran WHERE (tglbayar BETWEEN '$tgl1' AND '$tgl2') AND id_loket='$sess' ")->result();
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->load->view('loket/laporan/laporan_penbul', $data);

				$this->mod_admin->convert_pdf("Laporan Pendapatan.pdf");
			}
		}
	}

	public function laporan_admin()
	{
		$loket = $this->input->post('loket');
		$hari = $this->input->post('hari');	
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$laporan = $this->input->post('laporan');
		
		$where = array('level' => 'loket');
		$data['loket'] = $this->mod_admin->tampil_di('user',$where); 
		if ($laporan == "excel") {
			
		} else {
			if ($loket == "semua" && $hari == "semua" && $bulan == "semua" && $tahun == "semua") {
				$this->load->view('admin/laporan/laporan_pen1');
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->mod_admin->convert_pdf("Laporan pendapatan.pdf");
			} elseif ($loket == "semua" && $hari == "semua" && $bulan == "semua" && $tahun != "semua") {
				$data['tahun'] = $tahun;
				$this->load->view('admin/laporan/laporan_pen2',$data);
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->mod_admin->convert_pdf("Laporan pendapatan.pdf");
			} elseif ($loket == "semua" && $hari == "semua" && $bulan != "semua" && $tahun == "semua") {
				$data['bulan'] = $bulan;
				$this->load->view('admin/laporan/laporan_pen3',$data);
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->mod_admin->convert_pdf1(array(0,0,700,1000),"landscape","Laporan pendapatan.pdf");
			} elseif ($loket == "semua" && $hari != "semua" && $bulan == "semua" && $tahun == "semua") {
				$data['hari'] = $hari;
				$this->load->view('admin/laporan/laporan_pen4',$data);
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->mod_admin->convert_pdf1(array(0,0,700,1000),"landscape","Laporan pendapatan.pdf");
			} elseif ($loket != "semua" && $hari == "semua" && $bulan == "semua" && $tahun == "semua") {
				$data['loket'] = $loket;
				$this->load->view('admin/laporan/laporan_pen5',$data);
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->mod_admin->convert_pdf("Laporan pendapatan.pdf");
			} elseif ($loket != "semua" && $hari == "semua" && $bulan == "semua" && $tahun != "semua") {
				$data['loket'] = $loket; $data['tahun'] = $tahun; 
				$this->load->view('admin/laporan/laporan_pen6',$data);
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->mod_admin->convert_pdf("Laporan pendapatan.pdf");
			} elseif ($loket != "semua" && $hari == "semua" && $bulan != "semua" && $tahun == "semua") {
				$data['loket'] = $loket; $data['bulan'] = $bulan; 
				$this->load->view('admin/laporan/laporan_pen7', $data);
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->mod_admin->convert_pdf("Laporan pendapatan.pdf");
			} elseif ($loket == "semua" && $hari != "semua" && $bulan != "semua" && $tahun == "semua") {
				$data['hari'] = $hari; $data['bulan'] = $bulan; 
				$this->load->view('admin/laporan/laporan_pen8', $data);
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->mod_admin->convert_pdf("Laporan pendapatan.pdf");
			} elseif ($loket == "semua" && $hari != "semua" && $bulan == "semua" && $tahun != "semua") {
				$data['hari'] = $hari; $data['tahun'] = $tahun; 
				$this->load->view('admin/laporan/laporan_pen9', $data);
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->mod_admin->convert_pdf("Laporan pendapatan.pdf");
			} elseif ($loket != "semua" && $hari != "semua" && $bulan != "semua" && $tahun != "semua") {
				$data['loket'] = $loket; $data['hari'] = $hari; $data['bulan'] = $bulan; $data['tahun'] = $tahun;
				$this->load->view('admin/laporan/laporan_pen10', $data);
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->mod_admin->convert_pdf("Laporan pendapatan.pdf");
			} elseif ($loket != "semua" && $hari != "semua" && $bulan != "semua" && $tahun == "semua") {
				$data['loket'] = $loket; $data['hari'] = $hari; $data['bulan'] = $bulan;
				$this->load->view('admin/laporan/laporan_pen11', $data);
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->mod_admin->convert_pdf("Laporan pendapatan.pdf");
			} elseif ($loket != "semua" && $hari != "semua" && $bulan == "semua" && $tahun != "semua") {
				$data['loket'] = $loket; $data['hari'] = $hari; $data['tahun'] = $tahun;
				$this->load->view('admin/laporan/laporan_pen12', $data);
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->mod_admin->convert_pdf("Laporan pendapatan.pdf");
			} elseif ($loket != "semua" && $hari == "semua" && $bulan != "semua" && $tahun != "semua") {
				$data['loket'] = $loket; $data['bulan'] = $bulan; $data['tahun'] = $tahun;
				$this->load->view('admin/laporan/laporan_pen13', $data);
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->mod_admin->convert_pdf("Laporan pendapatan.pdf");
			} elseif ($loket == "semua" && $hari != "semua" && $bulan != "semua" && $tahun != "semua") {
				$data['hari'] = $hari; $data['bulan'] = $bulan; $data['tahun'] = $tahun;
				$this->load->view('admin/laporan/laporan_pen14', $data);
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->mod_admin->convert_pdf("Laporan pendapatan.pdf");
			} elseif ($loket == "semua" && $hari == "semua" && $bulan != "semua" && $tahun != "semua") {
				$data['bulan'] = $bulan; $data['tahun'] = $tahun;	
				$this->load->view('admin/laporan/laporan_pen15', $data);
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->mod_admin->convert_pdf("Laporan pendapatan.pdf");
			} elseif ($loket != "semua" && $hari != "semua" && $bulan == "semua" && $tahun == "semua") {
				$data['loket'] = $loket; $data['hari'] = $hari;	
				$this->load->view('admin/laporan/laporan_pen16', $data);
				helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mengexport data Pendapatan versi PDF");
				$this->mod_admin->convert_pdf("Laporan pendapatan.pdf");
			} else {
				$this->load->view('errors/index');
			}
		}
	}

	public function cetak_pelanggan($id)
	{
		$where0 = array('id_pelanggan' => $id );
		$where = array('id_pelanggan' => $id,
					   'status' => 0 );
		$where1 = array('id_pelanggan' => $id,
					   'status' => 1  );
		$data['name']=$this->mod_admin->tampil_di('pelanggan',$where0);
		$data['b_l'] = $this->mod_admin->tampil_di('tagihan',$where);
		$data['l'] = $this->mod_admin->tampil_di('tagihan',$where1);
		$this->load->view('loket/laporan/cetak_pelanggan',$data);
		helper_log("cetak_pdf", "User ".$this->session->userdata('kode_pegawai')." telah mencetak data pelanggam di Pembayaran versi PDF");
		$this->mod_admin->convert_pdf("cetak_pelanggan.pdf");
	}
}

/* End of file Import.php */
/* Location: ./application/controllers/Import.php */