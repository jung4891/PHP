<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Option extends CI_Controller {

	function __construct() {
			parent::__construct();
			if(!isset($_SESSION)){
					session_start();
			}
			$this->load->helper('url');
			$this->load->model('M_option');
	}


		public function index(){
			if(isset($_SESSION['userid']) && ($_SESSION['userid'] != "")){
        $this->load->view('option_list');
			}else{
				$this->load->view('login');
			}
		}

		function mailbox() {
			$this->load->view('mailbox/mailbox_set');
		}

		function sign_list(){
			$user_id = $_SESSION["userid"];
			$result = $this->M_option->get_signlist($user_id);
			echo json_encode($result);
		}

		function sign_input(){
			$sign_seq = $this->input->post("seq");
			$sign_name = $this->input->post("sign_name");
			if($sign_seq == "new"){
				$user_id = $_SESSION["userid"];
				$s_count = $this->M_option->get_signcount($user_id)->s_count;
				$active = ($s_count > 0)?"N":"Y";

				$data = array(
					'usermail' => $user_id,
					'sign_name' => $sign_name,
					'active' => $active
				);
				$result = $this->M_option->sign_input_action($data);
			}else{
				$data = array("sign_name" => $sign_name);
				$result = $this->M_option->sign_save($data, $sign_seq);
			}

			echo json_encode($result);

		}

		function get_signcontent(){
			$user_id = $_SESSION["userid"];
			$sign_seq = $this->input->post("seq");
			$result = $this->M_option->get_signcontent($sign_seq, $user_id);
			echo json_encode($result);
		}

		function sign_save(){
			$content = $this->input->post("content");
			$seq = $this->input->post("seq");
			$data = array("sign_content" => $content);
			$result = $this->M_option->sign_save($data, $seq);
			echo json_encode($result);
		}

		function sign_del(){
			$seq = $this->input->post("seq");
			$result = $this->M_option->sign_del($seq);
			echo json_encode($result);
		}



}

?>
