<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod extends CI_Model {

	public function cek($table,$where)
	{
		$this->db->get($table);
		$this->db->where($where);
	}

}

/* End of file mod.php */
/* Location: ./application/models/mod.php */