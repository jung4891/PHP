<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crontab extends CI_Controller {

	function __construct() {
    parent::__construct();
    $this->load->Model("M_crontab");

	}

  function delete_bigfile(){

    $del_file_list = $this->M_crontab->get_delfilelist();
    $file_dir = $_SERVER['DOCUMENT_ROOT']."/misc/upload/bigfile/";

    foreach ($del_file_list as $fl) {
      $filename = $fl->filename;
      $file_delete = @unlink($file_dir.$filename);
      if ($file_delete) {
        $file_seq = $fl->seq;
        $this->M_crontab->complete_deletefile($file_seq);
      }
    }

  }


  function test_trigger(){
    $uid = $this->input->get("uid");
    $this->M_crontab->test_trig($uid);
  }

}