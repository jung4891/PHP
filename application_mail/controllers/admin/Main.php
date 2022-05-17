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
					$data["domain_list"] = $this->M_alias->domain_list();
					$data["domain_info"] = $domain_info;

					if(isset($_GET['searchdomain'])) {
						$search_domain = $_GET['searchdomain'];
					} else {
						$search_domain = "durianit.co.kr";
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
					$data["count"] = $this->M_main->mailbox_list_count($search_domain)->ucount;
					$data["mail_list"] = $this->M_main->mailbox_list($search_domain,( $cur_page - 1 ) * $no_page_list, $no_page_list);

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

					$data['cnt_domain'] = $this->M_main->cnt_domain($search_domain);
					$data['avg_domain'] = $this->M_main->avg_domain($search_domain);

					$this->load->view("admin/main", $data);
				}
			}else{
				redirect("");
			}

    }

		function total_info(){
			$domain = $this->input->post("selectDomain");
			$total_quota = $this->M_main->total_quota($domain);
			echo json_encode($total_quota);
		}

		function top_five(){
			$domain = $this->input->post("selectDomain");
			$total_quota = $this->M_main->top_five($domain);
			$top_name = array();
			$top_quota = array('용량');
			$top_msg = array('메세지수');

			foreach ($total_quota as $tq) {
				array_push($top_name, $tq->uname);
				array_push($top_quota, $tq->bytes);
				array_push($top_msg, $tq->messages);
			}
			$result_arr = array(
				'top_name' => $top_name,
				'top_quota' => $top_quota,
				'top_msg' => $top_msg
			);
			echo json_encode($result_arr);
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
