<?php

function helper_log($tipe = "", $str = ""){
    $CI =& get_instance();
 
    if (strtolower($tipe) == "login"){
        $log_tipe   = 0;
    }
    elseif(strtolower($tipe) == "logout")
    {
        $log_tipe   = 1;
    }
    elseif(strtolower($tipe) == "tambah"){
        $log_tipe   = 2;
    }
    elseif(strtolower($tipe) == "edit"){
        $log_tipe  = 3;
    }
    elseif (strtolower($tipe) == "delete") {
        $log_tipe  = 4;
    } 
    elseif (strtolower($tipe) == "pembayaran") {
        $log_tipe  = 5;  
    }
    elseif (strtolower($tipe) == "cetak_excel") {
        $log_tipe  = 6;  
    }
    elseif (strtolower($tipe) == "cetak_pdf") {
        $log_tipe  = 7;     
    }
 
    // paramter
    $param['log_user']      = $CI->session->userdata('kode_pegawai');
    $param['log_tipe']      = $log_tipe;
    $param['log_desc']      = $str;
 
    //load model log
    $CI->load->model('mod_admin');
 
    //save to database
    $CI->mod_admin->save_log($param);
 
}