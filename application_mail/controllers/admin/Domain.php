<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Domain extends CI_Controller {

	function __construct() {
			parent::__construct();
			if(!isset($_SESSION)){
					session_start();
			}
			$this->load->helper('url');
			$this->id = $_SESSION['userid'];
			$this->roles = $_SESSION['roles'];
			$this->domain = $_SESSION['domain'];
      $this->load->model('admin/M_domain');

	}

    public function domain_list(){
			if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
        redirect("");
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
      $data["domain_list"] = $this->M_domain->domain_list(( $cur_page - 1 ) * $no_page_list, $no_page_list);
      $data["count"] = $this->M_domain->domain_list_count()->ucount;

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
      $this->load->view("admin/domain_list", $data);

    }



		function domain_add(){
			if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
				redirect("");
			}

			// $data["domain_list"] = $this->M_mailbox->domain_list();
			$this->load->view("admin/domain_input");
		}

		function dupl_domain(){
      $id = $this->input->post("domain");
      $result = $this->M_domain->dupl_domain($id);
      echo json_encode($result);
    }

		public function domain_add_action(){
			if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
				redirect("");
			}

			$domain_id = $this->input->post('domain_id');
			$description = $this->input->post('description');
			$alias_len = $this->input->post('alias_len');
			$box_len = $this->input->post('box_len');
			$maxquota = $this->input->post('maxquota');
			// $transport = $this->input->post('delivery');
			$insert_date = date("Y-m-d H:i:s");
			$modify = date("Y-m-d H:i:s");

			$insert_domain = array(
				'domain' => $domain_id,
				'description' => $description,
				'aliases' => $alias_len,
				'mailboxes' => $box_len,
				'maxquota' => $maxquota,
				'quota' => 0,
				'transport' => "virtual",
				'backupmx' => 0,
				'created' => $insert_date,
				'modified' => $modify,
				'active' => 1
			);



			$result = $this->M_domain->insert_domain($insert_domain);
			if($result){
				echo "<script>alert('등록되었습니다.');location.href='".site_url()."/admin/domain/domain_list';</script>";
			}
		}

		public function del_domain(){
      if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
        redirect("");
      }
      if(!isset($_GET["id"]) || $_GET["id"] == ""){
        redirect("");
      }
      $id = $_GET["id"];

			// $sess_id = $this->id;
			// $sess_ip = $_SERVER["REMOTE_ADDR"];
			// $log_name = $sess_id." ({$sess_ip})";
			// $log_domain = explode("@", $id);
			// $log_domain = $log_domain[1];
			//
			// $insert_log = array(
			// 	'timestamp' => date("Y-m-d H:i:s"),
			// 	'username' => $log_name,
			// 	'domain' => $log_domain,
			// 	'action' => 'delete_mailbox',
			// 	'data' => $id
			// );
      $result = $this->M_domain->del_domain($id);
      if($result){
        echo "<script>alert('삭제되었습니다.');location.href='".site_url()."/admin/domain/domain_list';</script>";
      }
    }

		function domain_update(){
			if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
				redirect("");
			}

			if(!isset($_POST['modify_id'])){
				echo "<script>history.back();</script>";
			}
			$user_id = $this->input->post("modify_id");
			// echo $user_id;
			$data['modify_data'] = $this->M_domain->domain_info($user_id);
			// var_dump($data);
			// exit;
			$this->load->view("admin/domain_modify", $data);
		}


		function getRandStr($length = 8) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; $charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}

		function domain_modify_action(){
			if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
				redirect("");
			}

			if(!isset($_POST['modify_domain'])){
				echo "<script>history.back();</script>";
			}

			$modify_domain = $this->input->post("modify_domain");
			$description = $this->input->post("description");
			$alias_len = $this->input->post("alias_len");
			$box_len = $this->input->post("box_len");
			$maxquota = $this->input->post("maxquota");
			$chk_active = $this->input->post("chk_active");
			if($chk_active == NULL){
				$chk_active = 0;
			}
			$modify_array = array(
				// 'domain' => $modify_domain,
				'description' => $description,
				'aliases' => $alias_len,
				'mailboxes' => $box_len,
				'maxquota' => $maxquota,
				'active' => $chk_active
			);
			// var_dump($modify_array);
			// exit;
			// $sess_id = $this->id;
			// $sess_ip = $_SERVER["REMOTE_ADDR"];
			// $log_name = $sess_id." ({$sess_ip})";
			// $log_domain = explode("@", $modify_id);
			// $log_domain = $log_domain[1];
			// $insert_log = array(
			// 	'timestamp' => date("Y-m-d H:i:s"),
			// 	'username' => $log_name,
			// 	'domain' => $log_domain,
			// 	'action' => 'edit_mailbox',
			// 	'data' => $modify_id
			// );
			$result = $this->M_domain->update_domain($modify_array, $modify_domain);
			if($result){
					echo "<script>alert('수정되었습니다.');location.href='".site_url()."/admin/domain/domain_list';</script>";
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
			$result = $this->M_mailbox->update_mailbox($modify_array, $user_id, "password");
			if($result){
				echo json_encode($result);
			}
		}


}

?>
