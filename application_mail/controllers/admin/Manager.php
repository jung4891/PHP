<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends CI_Controller {

	function __construct() {
			parent::__construct();
			if(!isset($_SESSION)){
					session_start();
			}
			$this->load->helper('url');
			$this->id = $_SESSION['userid'];
			$this->roles = $_SESSION['roles'];
			$this->domain = $_SESSION['domain'];
      $this->load->model('admin/M_manager');

	}

    public function adminlist(){
			if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
        redirect("");
			}

      $data["domain_list"] = $this->M_manager->domain_list();
      $list_val = $this->M_manager->admin_list();
      $data["count"] = $list_val["rows"];
      $data["list_val"] = $list_val["lists"];

      $this->load->view("admin/manager_list", $data);

    }

		function getRandStr($length = 8) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; $charactersLength = strlen($characters); $randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}

		public function add_admin(){
			if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
				redirect("");
			}
			$data["domain_list"] = $this->M_manager->domain_list();
			$this->load->view("admin/manager_input", $data);
		}

    public function add_admin_action(){
      if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
        redirect("");
      }

      $id = $this->input->post('mail_id');
      $id_domain = $this->input->post('mail_domain');
      $id = $id."@".$id_domain;
      $password = $this->input->post('mail_password');
      $check_pass = $this->input->post('chk_password');
			$rand = $this->getRandStr();
			$hash_salt = "$1$".$rand."$";
			$hashed_password = crypt($password, $hash_salt);

      $domain = "ALL";
      $active = "1";
      $insert_date = date("Y-m-d H:i:s");
      $modify = date("Y-m-d H:i:s");

      $insert_admin = array(
        'username' => $id,
        'password' => $hashed_password,
        'created' => $insert_date,
        'modified' => $modify,
        'active' => $active
      );

      $insert_domain = array(
        'username' => $id,
        'domain' => $domain,
        'created' => $insert_date,
        'active' => $active
      );
      $result = $this->M_manager->insert_admin($insert_admin, $insert_domain);
      if($result){
				echo "<script>alert('등록되었습니다.');location.href='".site_url()."/admin/manager/adminlist';</script>";
      }
    }


		public function modify_admin(){
			if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
				redirect("");
			}
			$data["domain_list"] = $this->M_manager->domain_list();
			$admin_id = $this->input->get('modi_id');
			$data["admin_info"] = $this->M_manager->admin_info($admin_id);
			$this->load->view("admin/manager_modify", $data);
		}

    public function modify_action(){
      if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
        redirect("");
      }

      $id = $this->input->post('modify_user');
      // $password = $this->input->post('modify_pass');
      // $check_pass = $this->input->post('chk_pass');
      // $hashed_password = crypt($password);
      $domain = $this->input->post('hidden_domain');
      $active = $this->input->post('chk_active');
      $modify = date("Y-m-d H:i:s");
			$password = $this->input->post('modify_pass');
			$check_pass = $this->input->post('chk_pass');
			$update_admin = array(
				'modified' => $modify,
				'active' => $active
			);
			if($password != "" && $password == $check_pass){
				$rand = $this->getRandStr();
				$hash_salt = "$1$".$rand."$";
				$hashed_password = crypt($password, $hash_salt);
				$update_admin['password'] = $hashed_password;
			}

      $update_domain = array(
        // 'domain' => $domain,
        'active' => $active
      );
      $result = $this->M_manager->update_admin($update_admin, $update_domain, $id);
      if($result){
				echo "<script>alert('수정되었습니다.');location.href='".site_url()."/admin/manager/adminlist';</script>";
      }
    }


    public function del_admin(){
      if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
        redirect("");
      }
      if(!isset($_GET["id"]) || $_GET["id"] == ""){
        redirect("");
      }
      $id = $_GET["id"];

      $result = $this->M_manager->del_admin($id);
      if($result){
        echo "<script>alert('삭제되었습니다.');location.href='".site_url()."/admin/manager/adminlist';</script>";
      }
    }

    function dupl_id(){
      $id = $this->input->post("username");
      $result = $this->M_manager->dupl_chkid($id);
      echo json_encode($result);
    }


}

?>
