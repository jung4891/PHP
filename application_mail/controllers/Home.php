<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
			parent::__construct();
			if(!isset($_SESSION)){
					session_start();
			}
			$this->load->helper('url');
			$this->load->Model('M_account');
	}


		public function index(){
			$this->load->library('user_agent');
			if(isset($_SESSION['userid'])){
				if($_SESSION['userid'] != "" && $_SESSION['roles'] == "admin"){

					echo "<script>location.href='".site_url()."/admin/main'</script>";

				}else{
					echo "<script>location.href='".site_url()."/mailbox/mail_list'</script>";
				}

			}else{
				// phpinfo();
				if ($this->agent->is_mobile()) {
					$this->load->view('mobile/login');
				} else {
					$this->load->view('login');
				}
			}

		}


		function side_width_update(){
				$width = $this->input->post("side_width");
				$user_id = $_SESSION["userid"];
				// $data = array(
				// 	'side_width' => $width
				// );
				$result = $this->M_account->change_side($width, $user_id);
				$_SESSION['s_width'] = $width;
				echo json_encode($result);
		}

		function get_side(){
			$user_id = $_SESSION["userid"];
			$result = $this->M_account->get_side($user_id);

			echo json_encode($result);
		}


}
