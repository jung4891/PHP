<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends CI_Controller {
  function __construct() {
      parent::__construct();
      $this->load->helper('url');
  }

  public function index(){
    $this->load->view('mail_list');
  }

  public function mail_detail(){
    $this->load->view('mail_detail');
  }

}




 ?>
