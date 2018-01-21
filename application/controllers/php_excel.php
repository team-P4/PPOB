<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Php_excel extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
    $this->load->helper('form','url');
		$this->load->library(array('upload','PHPExcel'));
    $this->load->model('mod');
    if($this->session->userdata('status') != "login"){
      redirect('login/index');
    }
	}

	public function index() 
	{
    $data['barang'] = $this->db->get('barang')->result();
		$this->load->view('admin/barang/import.php', $data);
	}

  public function importfile()
  {
    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'xls|xlsx|csv';
    $config['max_size']  = '5000';
    
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    
    if ( ! $this->upload->do_upload('file')){
      $error = array('error' => $this->upload->display_errors());
      $this->session->set_flashdata('message','Ada kesalah dalam upload');
      redirect('php_excel/index', 'refresh');
    }
    else{
      $data = array('upload_data' => $this->upload->data());
      $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
      $filename = $upload_data['file_name'];
      $this->mod->php_excelmodel($filename);
      unlink('./uploads/'.$filename);

      $data['pesan'] = '<div class="alert alert-success alert-dismissible">';
      $data['pesan'] .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
      $data['pesan'] .= '<h4><i class="icon fa fa-check"></i> Alert!</h4>';
      $data['pesan'] .= 'Success.. data berhasil dikirim';
      $data['pesan'] .= '</div>';
      $data['barang'] = $this->db->get('barang')->result();

      $this->load->view('admin/barang/import.php', $data);
    }
  }

}

/* End of file php_excel.php */
/* Location: ./application/controllers/php_excel.php */