<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct() {
			parent::__construct();
			if(!isset($_SESSION)){
					session_start();
			}
			$this->load->helper('url');
			$this->load->model('admin/M_alias');
		  $this->load->model('admin/M_main');
			// $this->load->library('session');
			// $this->id = $_SESSION['userid'];
			// $this->roles = $_SESSION['roles'];
			// $this->domain = $_SESSION['domain'];

	}

    public function index(){
			if(isset($_SESSION['userid'])){
				if($_SESSION['userid'] != "" && $_SESSION['roles'] == "admin"){
					$domain_info = $this->M_main->domain_box();
					$data["domain_info"] = $domain_info;
					// $data['domain_info'] = array();
					// foreach ($domain_info as $di) {
					// 	$arr = array( $di->domain => round($di->quota));
					// 	array_push($data['domain_info'], $arr);
					//
					// }


					$this->load->view("admin/main", $data);
				}
			}else{
				redirect("");
			}

    }

		function total_info(){
			// $data = $this->M_main->
		}

		function viewlog(){
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
			$log_list = $this->M_main->admin_log($search_domain, $search_keyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
			$data["count"] = $log_list["rows"];
			$data["log_list"] = $log_list["list"];

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
			$this->load->view("admin/log_list", $data);
		}


		// public function main(){
		//
		//
		// }


}

?>
