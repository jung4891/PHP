<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail_test extends CI_Controller {
  function __construct() {
      parent::__construct();
      $this->load->helper('url');
  }

  public function index(){
    $this->load->view('test/mail_list');
  }

  public function mail_detail(){
    $this->load->view('test/mail_detail');
  }

}




 ?>
