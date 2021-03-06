<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Tech_board extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->lv = $this->phpsession->get( 'lv', 'stc' );
		$this->email = $this->phpsession->get('email','stc'); //김수성추가
	}

	// 기술지원보고서 용
	// 김수성 201702 중에...
	//

	function tech_doc_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model('STC_tech_doc');
//		$cur_page = $this->input->get( 'cur_page' );			//	현재 페이지
		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		}
		else {
			$cur_page = 0;
		}														//	현재 페이지
		$no_page_list = 10;										//	한페이지에 나타나는 목록 개수

		if(isset($_GET['searchkeyword'])) {
			$search_keyword = $_GET['searchkeyword'];
		}
		else {
			$search_keyword = "";
		}

		if(isset($_GET['search1'])) {
			$search1 = $_GET['search1'];
		}
		else {
			$search1 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;

		if  ( $cur_page <= 0 )
			$cur_page = 1;

		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_tech_doc->tech_doc_list($search_keyword, $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_tech_doc->tech_doc_list_count($search_keyword, $search1)->ucount;

		$data['list_val'] = $user_list_data['data'];
		$data['list_val_count'] = $user_list_data['count'];

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

		$this->load->view( 'tech_doc_list', $data );
	}



	function tech_doc_input() {

		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_tech_doc'));
		$data['customer'] = $this->STC_tech_doc->get_customer();
		$this->load->view( 'tech_doc_input', $data );
	}

	function tech_doc_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}
		$this->load->model(array( 'STC_tech_doc' ));
		$seq = $this->input->post('seq');
		// 문서번호 생성 함수
		$today_month = date("n");
		alert('정상적으로'."date(n)");

		$doc_final = "DUIT-TECH-08-16-".date("n")."-";
		$doc_last = $this->STC_tech_doc->tech_doc_num_count($today_month);
		$doc_final = $doc_final.$doc_last;
		// insert / modify 기본 내용
		$data = array(
				'customer' 				=> $this->input->post('customer'),
				'customer_manager' 		=> $this->input->post('customer_manager'),
				'produce' 				=> $this->input->post('produce'),
				`work_name`				=> $this->input->post('work_name'),
				`doc_num`				=> $doc_final,
				`income_time`			=> $this->input->post('income_time'),
				`start_time`			=> $this->input->post('start_time'),
				`end_time`				=> $this->input->post('end_time'),
				`engineer`				=> $this->input->post('engineer'),
				`handle`				=> $this->input->post('handle'),
				`request`				=> $this->input->post('request'),
				'work_process_time'		=> $this->input->post('work_process_time'),
				'work_process' 			=> $this->input->post('work_process'),
				'err_type' 			=> $this->input->post('err_type'),
				'warn_level' 			=> $this->input->post('warn_level'),
				'warn_type' 			=> $this->input->post('warn_type'),
				'work_action' 			=> $this->input->post('work_action'),
				'result' 				=> $this->input->post('result'),
				`update_date` 			=> date("Y-m-d H:i:s")
			 );


		if ($seq == null) {			// insert 모드
			$date = array(
				'writer' 				=> $this->name,
				`insert_date` 			=> date("Y-m-d H:i:s")
				);
			$result = $this->STC_tech_doc->tech_doc_insert($data, $mode = 0);
		} else {					// modify 모드
			$date = array(
				'writer' 				=> $this->input->post('name'),
				);
			$result = $this->STC_tech_doc->tech_doc_insert($data, $mode = 1, $seq);
		}

		if($result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/tech_board/tech_doc_list'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	}


	function tech_device_doc_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		$this->load->model(array( 'STC_tech_doc' ));
		$seq = $this->input->get( 'seq' );
		if ($seq != null) {
			$tdata = $this->STC_tech_doc->tech_doc_delete($seq);
		}

		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/tech_board/tech_doc_list'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}




		// 장비등록 관련 페이지
		// 작성자 : 김수성
		// View에서 쓸 변수 : SQL정보를 배열로 받을 변수 view_val
		// 여기서는
		// $data['view_val'] = $this->STC_tech_doc->tech_device_view($seq);
		// 으로 정의
		//
	function tech_device_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_tech_doc'));
//		$cur_page = $this->input->get( 'cur_page' );			//	현재 페이지
		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		}
		else {
			$cur_page = 0;
		}														//	현재 페이지
		$no_page_list = 10;										//	한페이지에 나타나는 목록 개수

		if(isset($_GET['searchkeyword'])) {
			$search_keyword = $_GET['searchkeyword'];
		}
		else {
			$search_keyword = "";
		}

		if(isset($_GET['search1'])) {
			$search1 = $_GET['search1'];
		}
		else {
			$search1 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;

		if  ( $cur_page <= 0 )
			$cur_page = 1;

		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_tech_doc->tech_device_list($search_keyword, $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_tech_doc->tech_device_list_count($search_keyword, $search1)->ucount;

		$data['list_val'] = $user_list_data['data'];
		$data['list_val_count'] = $user_list_data['count'];

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

		$this->load->view( 'tech_device_list', $data );
	}


		// 장비등록  보기/수정 뷰
	function tech_device_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_tech_doc'));
//		$user_id = $this->idx;

		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );

		$data['customer'] = $this->STC_tech_doc->get_customer();
		$data['view_val'] = $this->STC_tech_doc->tech_device_view($seq);
		$data['seq'] = $seq;

		if($mode == "view") {
			$this->load->view( 'tech_device_view', $data );
		} else {
			$this->load->view( 'tech_device_modify', $data );
		}
	}


	function tech_device_input() {

		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_tech_doc'));
		$data['customer'] = $this->STC_tech_doc->get_customer();
		$this->load->view( 'tech_device_input', $data );
	}

	function tech_device_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}
		$this->load->model(array( 'STC_tech_doc' ));
		$seq = $this->input->post('seq');

		$data = array(
				'produce' 		=> $this->input->post('produce'),
				'customer' 		=> $this->input->post('customer'),
				'sn'			=> $this->input->post('sn'),
				'version' 		=> $this->input->post('version'),
				'license' 		=> $this->input->post('license'),
				'writer' 		=> $this->name,
				'end_date' 		=> date("Y-m-d H:i:s")
			 );

		if ($seq == null) {
			$result = $this->STC_tech_doc->tech_device_insert($data, $mode = 0);
		} else {
			$result = $this->STC_tech_doc->tech_device_insert($data, $mode = 1, $seq);
		}

		if($result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/tech_board/tech_device_list'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	}


	function tech_device_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		$this->load->model(array( 'STC_tech_doc' ));
		$seq = $this->input->get( 'seq' );
		if ($seq != null) {
			$tdata = $this->STC_tech_doc->tech_device_delete($seq);
		}

		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/tech_board/tech_device_list'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}


}
?>
