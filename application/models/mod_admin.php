<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_admin extends CI_Model {

	public function tampil($table)
	{
		$query = $this->db->get($table)->result();
		return $query;
	}

	public function tampil_di($table,$where)
	{
		$dor = $this->db->get_where($table,$where)->result();
		return $dor;
	}	

	public function insert($table,$object)
	{
		$this->db->insert($table, $object);
	}

	public function update($table,$where,$object)
	{
		$this->db->where($where);
		$this->db->update($table, $object);
	}

	public function delete($table,$where)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}

	public function import_mod($filename)
	{
		ini_set('memory_limit', '-1');
        $inputFileName = './assets/excel/'.$filename;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);

        for ($i=2; $i < ($numRows+1) ; $i++) { 
            /*
            $tgl_asli = str_replace('/', '-', $worksheet[$i]['B']);
            $exp_tgl_asli = explode('-', $tgl_asli);
            $exp_tahun = explode(' ', $exp_tgl_asli[2]);
            $tgl_sql = $exp_tahun[0].'-'.$exp_tgl_asli[0].'-    '.$exp_tgl_asli[1].' '.$exp_tahun[1];
            */
            $ins = array(
                    "username"     => $worksheet[$i]["A"],
                    "password"   => $worksheet[$i]["B"],
                    "level"      => $worksheet[$i]["C"]
                   );

            $this->db->insert('user', $ins);
        }
	}

	public function import1_mod($filename)
	{
		ini_set('memory_limit', '-1');
        $inputFileName = './assets/excel/'.$filename;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);

        for ($i=2; $i < ($numRows+1) ; $i++) { 
            /*
            $tgl_asli = str_replace('/', '-', $worksheet[$i]['B']);
            $exp_tgl_asli = explode('-', $tgl_asli);
            $exp_tahun = explode(' ', $exp_tgl_asli[2]);
            $tgl_sql = $exp_tahun[0].'-'.$exp_tgl_asli[0].'-    '.$exp_tgl_asli[1].' '.$exp_tahun[1];
            */
            $ins = array(
                    "id"     => $worksheet[$i]["A"],
                    "nama"   => $worksheet[$i]["B"],
                    "alamat"      => $worksheet[$i]["C"],
                    "kodetarif" => $worksheet[$i]["D"],
                    "kwhterbaru" => $worksheet[$i]["E"]
                   );

            $this->db->insert('pelanggan', $ins);
        }
	}
}

/* End of file mod_admin.php */
/* Location: ./application/models/mod_admin.php */