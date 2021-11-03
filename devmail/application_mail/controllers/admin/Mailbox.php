<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailbox extends CI_Controller {

	function __construct() {
			parent::__construct();
			if(!isset($_SESSION)){
					session_start();
			}
			$this->load->helper('url');
			$this->id = $_SESSION['userid'];
			$this->roles = $_SESSION['roles'];
			$this->domain = $_SESSION['domain'];
      $this->load->model('admin/M_mailbox');

	}

    public function mail_list(){
			if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
        redirect("");
			}

			if(isset($_GET['searchdomain'])) {
				$search_domain = $_GET['searchdomain'];
			} else {
				$search_domain = "";
			}

			if(isset($_GET['searchkeyword'])) {
				$search_keyword = $_GET['searchkeyword'];
			} else {
				$search_keyword = "";
			}

			if(isset($_GET['cur_page'])) {
				$cur_page = $_GET['cur_page'];
			} else {
				$cur_page = 0;
			}														//	현재 페이지
			$no_page_list = 10;										//	한페이지에 나타나는 목록 개수

			if  ( $cur_page <= 0 ){
				$cur_page = 1;
			}

			$data['cur_page'] = $cur_page;
			$data['search_keyword'] = $search_keyword;
			$data['search_domain'] = $search_domain;
      $data["domain_list"] = $this->M_mailbox->domain_list();
			$mail_list = $this->M_mailbox->mailbox_list($search_domain, $search_keyword,( $cur_page - 1 ) * $no_page_list, $no_page_list);
			$data["count"] = $mail_list["rows"];
			$data["mail_list"] = $mail_list["list"];

			$total_page = 1;
			if  ( $data['count'] % $no_page_list == 0 )
				$total_page = floor( ( $data['count'] / $no_page_list ) );
			else
				$total_page = floor( ( $data['count'] / $no_page_list + 1 ) );			//	전체 페이지 개수

			$start_page =  floor(($cur_page - 1 ) / 10) * 10  + 1 ;
			$end_page = 0;
			if  ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) )
				$end_page = ( floor( ( $cur_page - 1 ) / 10 ) + 1 ) * 10;
			else
				$end_page = $total_page;

			$data['no_page_list'] = $no_page_list;
			$data['total_page'] = $total_page;
			$data['start_page'] = $start_page;
			$data['end_page'] = $end_page;
      $this->load->view("admin/mail_list", $data);

    }



		function mail_add(){
			if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
				redirect("");
			}

			$data["domain_list"] = $this->M_mailbox->domain_list();
			$this->load->view("admin/mail_input", $data);
		}

		function dupl_mailbox(){
      $id = $this->input->post("username");
      $result = $this->M_mailbox->dupl_mailbox($id);
      echo json_encode($result);
    }

		public function mail_add_action(){
			if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
				redirect("");
			}

			$input_id = $this->input->post('mail_id');
			$id_domain = $this->input->post('mail_domain');
			$id = $input_id."@".$id_domain;
			$password = $this->input->post('mail_password');
			$check_pass = $this->input->post('chk_password');
			$rand = $this->getRandStr();
			$hash_salt = "$1$".$rand."$";
			$hashed_password = crypt($password, $hash_salt);
			$name = $this->input->post('user_name');
			$maildir = $id_domain."/".$input_id."/";
			$quota = $this->input->post('quota') * 1024000;
			$insert_date = date("Y-m-d H:i:s");
			$modify = date("Y-m-d H:i:s");

			$insert_user = array(
				'username' => $id,
				'password' => $hashed_password,
				'name' => $name,
				'maildir' => $maildir,
				'quota' => $quota,
				'local_part' => $input_id,
				'domain' => $id_domain,
				'created' => $insert_date,
				'modified' => $modify,
				'active' => 1
			);

			$insert_aliases = array(
				'address' => $id,
				'goto' => $id,
				'domain' =>  $id_domain,
				'created' => $insert_date,
				'modified' => $modify,
				'active' => 1
			);

			$insert_quota = array(
				'username' => $id,
				'bytes' => 0,
				'messages' => 0
			);
			$sess_id = $this->id;
			$sess_ip = $_SERVER["REMOTE_ADDR"];
			$log_name = $sess_id." ({$sess_ip})";
			$insert_log = array(
				'timestamp' => date("Y-m-d H:i:s"),
				'username' => $log_name,
				'domain' => $id_domain,
				'action' => 'create_mailbox',
				'data' => $id
			);


			$result = $this->M_mailbox->insert_mailbox($insert_user, $insert_aliases, $insert_quota, $insert_log);
			if($result){
				echo "<script>alert('등록되었습니다.');location.href='".site_url()."/admin/mailbox/mail_list';</script>";
			}
		}

		public function del_mailbox(){
      if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
        redirect("");
      }
      if(!isset($_GET["id"]) || $_GET["id"] == ""){
        redirect("");
      }
      $id = $_GET["id"];

			$sess_id = $this->id;
			$sess_ip = $_SERVER["REMOTE_ADDR"];
			$log_name = $sess_id." ({$sess_ip})";
			$log_domain = explode("@", $id);
			$log_domain = $log_domain[1];

			$insert_log = array(
				'timestamp' => date("Y-m-d H:i:s"),
				'username' => $log_name,
				'domain' => $log_domain,
				'action' => 'delete_mailbox',
				'data' => $id
			);
      $result = $this->M_mailbox->del_mailbox($id, $insert_log);
      if($result){
        echo "<script>alert('삭제되었습니다.');location.href='".site_url()."/admin/mailbox/mail_list';</script>";
      }
    }

		function mailbox_update(){
			if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
				redirect("");
			}

			if(!isset($_POST['modify_id'])){
				echo "<script>history.back();</script>";
			}
			$user_id = $this->input->post("modify_id");
			$data['modify_data'] = $this->M_mailbox->mailbox_info($user_id);
			// var_dump($data);
			$this->load->view("admin/mail_modify", $data);
		}


		function getRandStr($length = 8) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; $charactersLength = strlen($characters); $randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}

		function mail_modify_action(){
			if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
				redirect("");
			}

			if(!isset($_POST['modify_id'])){
				echo "<script>history.back();</script>";
			}

			$modify_id = $this->input->post("modify_id");
			$user_name = $this->input->post("user_name");
			$quota = $this->input->post("quota");
			$chk_active = $this->input->post("chk_active");
			if($chk_active == NULL){
				$chk_active = 0;
			}
			$modify_array = array(
				'name' => $user_name,
				'quota' => $quota * 1024000,
				'active' => $chk_active
			);

			$sess_id = $this->id;
			$sess_ip = $_SERVER["REMOTE_ADDR"];
			$log_name = $sess_id." ({$sess_ip})";
			$log_domain = explode("@", $id);
			$log_domain = $log_domain[1];
			$insert_log = array(
				'timestamp' => date("Y-m-d H:i:s"),
				'username' => $log_name,
				'domain' => $log_domain,
				'action' => 'edit_mailbox',
				'data' => $modify_id
			);
			$result = $this->M_mailbox->update_mailbox($modify_array, $modify_id, $insert_log);
			if($result){
					echo "<script>alert('수정되었습니다.');location.href='".site_url()."/admin/mailbox/mail_list';</script>";
			}
		}

		function change_password(){
			if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
				redirect("");
			}

			if(!isset($_POST['username'])){
				echo "<script>history.back();</script>";
			}

			$user_id = $this->input->post('username');
			$password = $this->input->post('password');
			$check_pass = $this->input->post('chk_pass');
			$rand = $this->getRandStr();
			$hash_salt = "$1$".$rand."$";
			$hashed_password = crypt($password, $hash_salt);

			$modify_array = array(
				'password' => $hashed_password
			);
			$result = $this->M_mailbox->update_mailbox($modify_array, $user_id);
			if($result){
				echo json_encode($result);
			}
		}


}

?>
