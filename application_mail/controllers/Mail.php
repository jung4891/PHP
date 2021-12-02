<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends CI_Controller {

	function __construct() {
			parent::__construct();
			$this->load->helper('url');
			// $this->load->helper('form');
			// $this->load->helper('url');
			// $this->load->Model('m_login');
			// $this->load->Model('M_test2');
			$this->load->library('email');




	}


		public function main(){
			$this->load->view('read');
		}


}
