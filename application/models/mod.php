<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod extends CI_Model {

	public function tampil($table)
	{
		return $this->db->get($table);
	}	

	public function detaildata($table,$where)
	{
		return $this->db->get_where($table,$where);
	}

	public function updatedata($table,$where,$object)
	{
		$this->db->where($where);
		$this->db->update($table, $object);
	}

	public function tambahdata2($table,$object)
	{
		$this->db->insert($table, $object);
		return $this->db->insert_id();
	}

	public function tambahdata($table,$object)
	{
		$this->db->insert($table, $object);
	}

	public function hapusdata($table,$where)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}
	public function cek_login($table,$where){		
		return $this->db->get_where($table,$where);
	}

	public function data($table,$number,$offset)
	{
		return $query = $this->db->get($table,$number,$offset)->result();
	}

	public function data_cari($table,$number,$offset,$search)
	{
		$this->db->or_like($search);
		return $query = $this->db->get($table,$number,$offset)->result();
	}

	public function jumlah_data($table)
	{
		return $this->db->get($table)->num_rows();
	}

	public function jumlah_data_cari($table,$search)
	{
		$this->db->or_like($search);
		return $query = $this->db->get($table)->num_rows();
	}

	public function php_excelmodel($filename)
	{
		ini_set('memory_limit', '-1');
        $inputFileName = './uploads/'.$filename;
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
                    "id_barang"     => $worksheet[$i]["A"],
                    "nama_barang"   => $worksheet[$i]["B"],
                    "kategori"      => $worksheet[$i]["C"],
                    "qty"           => $worksheet[$i]["D"],
                    "harga_barang"  => $worksheet[$i]["E"],
                    "discount"      => $worksheet[$i]["F"],
                    "spesifikasi"   => $worksheet[$i]["G"],
                    "suplier"       => $worksheet[$i]["H"],
                    "alamat_suplier"=> $worksheet[$i]["I"] 
                   );

            $this->db->insert('barang', $ins);
        }
	}
}

/* End of file mod.php */
/* Location: ./application/models/mod.php */