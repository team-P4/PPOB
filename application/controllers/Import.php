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
			echo "gagal";
		}
		else{
			$data = array('upload_data' => $this->upload->data());
		    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
		    $filename = $upload_data['file_name'];
		    $this->mod_admin->import_mod($filename);
		    unlink('./assets/excel/'.$filename);
			echo "success";
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
			echo "gagal";
		}
		else{
			$data = array('upload_data' => $this->upload->data());
		    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
		    $filename = $upload_data['file_name'];
		    $this->mod_admin->import1_mod($filename);
		    unlink('./assets/excel/'.$filename);
			echo "success";
		}
	}

	public function export_loket_xlsx()
	{
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
		$objPHPExcel = new PHPExcel();
		$data = $this->db->get('pelanggan');

		$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
		$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
		 
		$objget->setTitle('Sample Sheet'); //sheet title

		$cols = array("A","B","C","D","E");

		$val = array("id_pelanggan","kode_pegawai","nama","alamat","kodetarif");

		for ($a=0; $a<5 ; $a++) { 
		$objset->setCellValue($cols[$a].'1', $val[$a]);

		  //Setting lebar cell
		  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
		  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
		  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
		  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
		  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
		            
		}

		// Mengambil Data
		$baris = 2;
		foreach($data->result() as $data)
		{
		     //pemanggilan sesuaikan dengan nama kolom tabel
		      $objset->setCellValue("A".$baris, $data->id_pelanggan); 
		      $objset->setCellValue("B".$baris, $data->kode_pegawai); 
		      $objset->setCellValue("C".$baris, $data->nama); 
		      $objset->setCellValue("D".$baris, $data->alamat); 
		      $objset->setCellValue("E".$baris, $data->kodetarif); 

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
		$data['pel'] = $this->db->get('pelanggan')->result();
		$this->load->view('admin/laporan_pelanggan', $data);

		$paper_size  = 'A4'; //paper size
		$orientation = 'landscape'; //tipe format kertas
		$html = $this->output->get_output();
		 
		$this->dompdf->set_paper($paper_size, $orientation);
		//Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("laporan_pelanggan.pdf", array('Attachment'=> true));
	}
}

/* End of file Import.php */
/* Location: ./application/controllers/Import.php */