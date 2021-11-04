<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
			parent::__construct();
			if(!isset($_SESSION)){
					session_start();
			}
			$this->load->helper('url');

	}


		public function index(){
			if(isset($_SESSION['userid'])){
				if($_SESSION['userid'] != "" && $_SESSION['roles'] == "admin"){

					$this->load->view("admin/main");

				}
				// var_dump($_SESSION);
			}else{
				$this->load->view('login');

			}

		}



}