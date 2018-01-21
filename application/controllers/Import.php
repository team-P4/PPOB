<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form','url');
		$this->load->library(array('upload','PHPExcel'));
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

}

/* End of file Import.php */
/* Location: ./application/controllers/Import.php */