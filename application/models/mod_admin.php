<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_admin extends CI_Model {

    public function save_log($param)
    {
        $sql        = $this->db->insert_string('tabel_log',$param);
        $ex         = $this->db->query($sql);
        return $this->db->affected_rows($sql);
    }
    
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

    public function get_id_loket()
    {
        $query = $this->db->query("SELECT MAX(kode_pegawai) AS kode_pegawai FROM user");
        return $query->row_array();
    }

    public function get_id_pelanggan()
    {
        $query = $this->db->query("SELECT MAX(id_pelanggan) AS id_pelanggan FROM pelanggan");
        return $query->row_array();
    }

    public function get_id_tagihan()
    {
        $query = $this->db->query("SELECT MAX(id_tagihan) AS id_tagihan FROM tagihan");
        return $query->row_array();
    }

    public function get_id_pembayaran()
    {
        $query = $this->db->query("SELECT MAX(id_pembayaran) AS id_pembayaran FROM pembayaran");
        return $query->row_array();
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
        unset($worksheet['1']);

        foreach ($worksheet as $key => $value) {
            $id = $this->db->query("SELECT MAX(kode_pegawai) AS kode_pegawai FROM user")->row_array();
            
            if ($id) {
                $nilai = substr($id['kode_pegawai'], 2);
                $nilai_baru = (int) $nilai;
                $nilai_baru++;
                $nilai_baru2 = "LK".str_pad($nilai_baru, 4, "0", STR_PAD_LEFT);
            }else{
                $nilai_baru2 = "LK0001";
            }
            
            // $tgl_asli = str_replace('/', '-', $worksheet[$i]['B']);
            // $exp_tgl_asli = explode('-', $tgl_asli);
            // $exp_tahun = explode(' ', $exp_tgl_asli[2]);
            // $tgl_sql = $exp_tahun[0].'-'.$exp_tgl_asli[0].'-    '.$exp_tgl_asli[1].' '.$exp_tahun[1];
            
            
            $ins = array(
                    "kode_pegawai" => $nilai_baru2, 
                    "username"     => $worksheet[$key]['A'],
                    "password"   => $worksheet[$key]["B"],
                    "level"      => $worksheet[$key]["C"]
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
        unset($worksheet['1']);

        foreach ($worksheet as $key => $value) {
            $id = $this->db->query("SELECT MAX(id_pelanggan) AS id_pelanggan FROM pelanggan")->row_array();
            
            if ($id) {
                $nilai = substr($id['id_pelanggan'], 2);
                $nilai_baru = (int) $nilai;
                $nilai_baru++;
                $nilai_baru2 = "PL".str_pad($nilai_baru, 4, "0", STR_PAD_LEFT);
            }else{
                $nilai_baru2 = "PL0001";
            }
            
            // $tgl_asli = str_replace('/', '-', $worksheet[$i]['B']);
            // $exp_tgl_asli = explode('-', $tgl_asli);
            // $exp_tahun = explode(' ', $exp_tgl_asli[2]);
            // $tgl_sql = $exp_tahun[0].'-'.$exp_tgl_asli[0].'-    '.$exp_tgl_asli[1].' '.$exp_tahun[1];
            
            
            $ins = array(
                    "id_pelanggan" => $nilai_baru2,
                    "kode_pegawai" => $worksheet[$key]['A'], 
                    "nama"     => $worksheet[$key]["B"],
                    "alamat"   => $worksheet[$key]["C"],
                    "kodetarif" => $worksheet[$key]["D"],
                    "kwhterbaru"  => $worksheet[$key]["E"]
            );
            $this->db->insert('pelanggan', $ins);
        }
	}
}

/* End of file mod_admin.php */
/* Location: ./application/models/mod_admin.php */