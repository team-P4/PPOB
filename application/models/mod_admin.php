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

    public function get_id_gardu()
    {
        $query = $this->db->query("SELECT MAX(id_gardu) AS id_gardu FROM gardu");
        return $query->row_array();
    }

    public function get_kode_gardu()
    {
        $query = $this->db->query("SELECT MAX(kode_gardu) AS kode_gardu FROM gardu");
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
                    "saldo" => 500000,
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
            $this->db->where('name', $worksheet[$key]["B"]);
            $prov = $this->db->get('provinces')->result();

            $this->db->where('name', $worksheet[$key]["C"]);
            $kab = $this->db->get('regencies')->result();

            $this->db->where('name', $worksheet[$key]["D"]);
            $kec = $this->db->get('districts')->result();

            $this->db->where('name', $worksheet[$key]["E"]);
            $kel = $this->db->get('villages')->result();
            
            $ins = array(
                    "id_pelanggan" => $nilai_baru2,
                    "nama"     => $worksheet[$key]["A"],
                    "provinsi"     => $prov[0]->id,
                    "kabupaten_kota"     => $kab[0]->id,
                    "kecamatan"     => $kec[0]->id,
                    "kelurahan_desa"     => $kel[0]->id,
                    "kodepos"     => $worksheet[$key]["F"],
                    "alamat"   => $worksheet[$key]["G"],
                    "kodetarif" => $worksheet[$key]["H"],
                    "id_gardu"  => $worksheet[$key]["I"]
            );
            $this->db->insert('pelanggan', $ins);
        }
	}

    public function convert_pdf($nama)
    {
        $paper_size  = 'A4'; //paper size or (array(0,0,450,360))
        $orientation = 'landscape'; //tipe format kertas
        $html = $this->output->get_output();
                     
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream($nama, array('Attachment'=> true));
    }

    public function convert_pdf1($ukur,$type,$nama)
    {
        $paper_size  = $ukur; //paper size or (array(0,0,450,360))
        $orientation = $type; //tipe format kertas 
        $html = $this->output->get_output();
                     
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream($nama, array('Attachment'=> true));
    }

    function provinsi(){
        $this->db->order_by('name','ASC');
        $provinces= $this->db->get('provinces');
        return $provinces->result_array();
    }

    function kabupaten($provId){
        $kabupaten="<option value='0'>-- Pilih Kabupaten --</option>";
        $this->db->order_by('name','ASC');
        $kab= $this->db->get_where('regencies',array('province_id'=>$provId));
        foreach ($kab->result_array() as $data ){
            $kabupaten.= "<option value='$data[id]'>$data[name]</option>";
        }
        return $kabupaten; 
    }

    function kecamatan($kabId){
        $kecamatan="<option value='0'>-- Pilih Kecamatan --</option>";
        $this->db->order_by('name','ASC');
        $kec= $this->db->get_where('districts',array('regency_id'=>$kabId));
        foreach ($kec->result_array() as $data ){
        $kecamatan.= "<option value='$data[id]'>$data[name]</option>";
        }
        return $kecamatan;
    }   

    function kelurahan($kecId){
        $kelurahan="<option value='0'>-- Pilih Kelurahan --</option>";
        $this->db->order_by('name','ASC');
        $kel= $this->db->get_where('villages',array('district_id'=>$kecId));
        foreach ($kel->result_array() as $data ){
        $kelurahan.= "<option value='$data[id]'>$data[name]</option>";
        }
        return $kelurahan;
    }

}

/* End of file mod_admin.php */
/* Location: ./application/models/mod_admin.php */