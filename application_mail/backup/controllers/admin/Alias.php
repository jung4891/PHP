<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alias extends CI_Controller {

	function __construct() {
			parent::__construct();
			if(!isset($_SESSION)){
					session_start();
			}
      $this->load->helper('url');
			$this->id = $_SESSION['userid'];
			$this->roles = $_SESSION['roles'];
			$this->domain = $_SESSION['domain'];
      $this->load->model('admin/M_alias');

	}

  public function alias_list(){
    if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
      redirect("");
    }

    if(isset($_GET['searchkeyword'])) {
      $search_keyword = $_GET['searchkeyword'];
    } else {
      $search_keyword = "";
    }

		if(isset($_GET['searchdomain'])) {
      $search_domain = $_GET['searchdomain'];
    } else {
      $search_domain = "";
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
		$data['search_domain'] = $search_domain;
    $data['search_keyword'] = $search_keyword;
    $data["domain_list"] = $this->M_alias->domain_list();
    $alias_list = $this->M_alias->alias_list($search_domain, $search_keyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
    $data["count"] = $alias_list["rows"];
    $data["alias_list"] = $alias_list["list"];

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
    $this->load->view("admin/alias_list", $data);

  }

  function alias_add(){
		if(!isset($_SESSION['userid'])||($_SESSION['userid'] =="" && $_SESSION['roles']!="admin")){
      redirect("");
    }

    $this->load->model('admin/M_mailbox');
    $data["domain_list"] = $this->M_mailbox->domain_list();
		$data["goto_list"] = $this->M_alias->goto_list();
		if(isset($_GET["input_mode"])){
			$data["input_mode"] = $this->input->get("input_mode");
			$modify_id = $this->input->get("modify_id");
			$alias_info = $this->M_alias->alias_info($modify_id);
			$goto = $alias_info->goto;
			$data["goto"] = explode(",", $goto);
			$data["mail_address"] = $alias_info->address;
			$data["alias_active"] = $alias_info->active;
		}
    $this->load->view("admin/alias_input", $data);
  }

	function alias_add_action(){
		$input_mode = $this->input->post("input_mode");

		$id = $this->input->post('mail_id');
		$goto = $this->input->post('selected_input');
		$goto = array_filter($goto);
		$goto = implode(",",$goto);


		if($input_mode == "insert"){
			$domain = $this->input->post('mail_domain');
			$address = $id."@".$domain;

			$insert_data = array(
				'address' => $address,
				'goto' => $goto,
				'domain' => $domain,
				'created' => date("Y-m-d H:i:s"),
				'modified' => date("Y-m-d H:i:s"),
				'active' => 1
			);

			$sess_id = $this->id;
			$sess_ip = $_SERVER["REMOTE_ADDR"];
			$log_name = $sess_id." ({$sess_ip})";
			// $log_domain = explode("@", $id);
			// $log_domain = $log_domain[1];
			$insert_log = array(
				'timestamp' => date("Y-m-d H:i:s"),
				'username' => $log_name,
				'domain' => $domain,
				// 'domain' => explode("@", $id)[1], 이대로 쓰면 php5에서 에러남
				'action' => 'create_alias',
				'data' => $address."=>".$goto
			);

			$result = $this->M_alias->insert_alias($insert_data, $insert_log);
			if($result){
				echo "<script>alert('등록되었습니다.');location.href='".site_url()."/admin/alias/alias_list';</script>";
			}

		}else{
			$check_active = $this->input->post("check_active");
			if($check_active == NULL){
				$check_active = 0;
			}
			$update_data = array(
				"goto" => $goto,
				"modified" => date("Y-m-d H:i:s"),
				"active" => $check_active
			);

			$sess_id = $this->id;
			$sess_ip = $_SERVER["REMOTE_ADDR"];
			$log_name = $sess_id." ({$sess_ip})";
			$log_domain = explode("@", $id);
			$log_domain = $log_domain[1];
			$update_log = array(
				'timestamp' => date("Y-m-d H:i:s"),
				'username' => $log_name,
				'domain' => $log_domain,
				// 'domain' => explode("@", $id)[1], 이대로 쓰면 php5에서 에러남
				'action' => 'edit_alias',
				'data' => $id."=>".$goto
			);

			$result = $this->M_alias->update_mailbox($update_data, $id, $update_log);
			if($result){
				echo "<script>alert('수정되었습니다.');location.href='".site_url()."/admin/alias/alias_list';</script>";
			}
		}
	}

	function search_alias(){
		$keyword = $this->input->post("keyword");
		$result = $this->M_alias->goto_list($keyword);
		echo json_encode($result);
	}
	// function alias_modify(){
	// 	$this->load->model('admin/M_mailbox');
	// 	$data["domain_list"] = $this->M_mailbox->domain_list();
	// 	$data["goto_list"] = $this->M_alias->goto_list();
	// 	$this->load->view("admin/alias_input", $data);
	// }
	public function del_alias(){
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
			// 'domain' => explode("@", $id)[1], 이대로 쓰면 php5에서 에러남
			'action' => 'delete_alias',
			'data' => $id
		);
		$result = $this->M_alias->del_alias($id, $insert_log);
		if($result){
			echo "<script>alert('삭제되었습니다.');location.href='".site_url()."/admin/alias/alias_list';</script>";
		}
	}

}

?>
