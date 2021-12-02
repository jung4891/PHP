<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Maintain extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->lv = $this->phpsession->get( 'lv', 'stc' );
    $this->company = $this->phpsession->get( 'company', 'stc' );
		$this->cnum = $this->phpsession->get( 'cnum', 'stc' );
		$this->load->library('user_agent');

		$this->load->Model(array('tech/STC_Maintain', 'STC_Common', 'tech/STC_User', 'tech/STC_Forcasting'));
	}

	//포캐스팅 리스트(공통)
	function maintain_list() {

		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Maintain', 'STC_Common','STC_User'));
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

		if(isset($_GET['searchkeyword2'])) {
                        $search_keyword2 = $_GET['searchkeyword2'];
                }
                else {
                        $search_keyword2 = "";
                }


//		if(isset($_GET['search1'])) {
//			$search1 = $_GET['search1'];
//		}
//		else {
//			$search1 = "";
//		}

		$search1 = "";
		if(isset($_GET['search2'])) {
			$search2 = $_GET['search2'];
		}
		else {
			$search2 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search_keyword2'] = $search_keyword2;
//		$data['search1'] = $search1;
		$data['search2'] = $search2;

		if  ( $cur_page <= 0 )
			$cur_page = 1;

		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Maintain->maintain_list($search_keyword,$search_keyword2, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list, $this->cnum);
		$data['count'] = $this->STC_Maintain->maintain_list_count($search_keyword,$search_keyword2, $search1, $search2, $this->cnum)->ucount;

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

		$data['category'] = $this->STC_Common->get_category();

		$data['no_page_list'] = $no_page_list;
		$data['total_page'] = $total_page;
		$data['start_page'] = $start_page;
		$data['end_page'] = $end_page;
		$data['cnum'] = $this->cnum;

		$data['group'] = $this->input->get('group');
		$data['view_val']=$this->STC_Common->periodic_inspection($data['group']);

		if($this->agent->is_mobile()) {
			$data['title'] = '유지보수';
			$this->load->view('tech/maintain_list_mobile', $data );
		} else {
			$this->load->view('tech/maintain_list', $data );
		}
	}


	//유지보수 입력/수정 처리
	function maintain_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model( 'STC_Maintain' );
		$seq = $this->input->post('seq');


		$data_type = $this->input->post('data_type');
		if($data_type == "1"){//고객사 정보
			$customer_companyname = $this->input->post('customer_companyname');
			$customer_username = $this->input->post('customer_username');
			$customer_tel = $this->input->post('customer_tel');
			$customer_email = $this->input->post('customer_email');

			$data = array(
				'customer_companyname' => $customer_companyname,
				'customer_username' => $customer_username,
				'customer_tel' => $customer_tel,
				'customer_email' => $customer_email,
				'write_id' => $this->id,
				'update_date' => date("Y-m-d H:i:s")
			);

		}else if($data_type == "2"){//영업 정보
			$project_name = $this->input->post('project_name');
			if($this->input->post('subProjectAddInput')==""){
				$sub_project_add = null;
			}else{
				$sub_project_add = $this->input->post('subProjectAddInput');
			}
			$progress_step = $this->input->post('progress_step');
			$type = $this->input->post('type');
			$cooperation_companyname = $this->input->post('cooperation_companyname');
			$cooperation_username = $this->input->post('cooperation_username');
			$dept = $this->input->post('dept');

			$data = array(
				'project_name' => $project_name,
				'sub_project_add' =>$sub_project_add,
				'progress_step' => $progress_step,
				'type' => $type,
				'cooperation_companyname' => $cooperation_companyname,
				'cooperation_username' => $cooperation_username,
				'dept' => $dept,
				'write_id' => $this->id,
				'update_date' => date("Y-m-d H:i:s")
			);
		}else if($data_type == "3"){//매출처 정보
			$sales_companyname = $this->input->post('sales_companyname');
			$sales_username = $this->input->post('sales_username');
			$sales_tel = $this->input->post('sales_tel');
			$sales_email = $this->input->post('sales_email');
			$data = array(
				'sales_companyname' => $sales_companyname,
				'sales_username' => $sales_username,
				'sales_tel' => $sales_tel,
				'sales_email' => $sales_email,
				'write_id' => $this->id,
				'update_date' => date("Y-m-d H:i:s")
			);
		}else if($data_type == "4"){//매입처 정보
			$update_main_array = $this->input->post('update_main_array');
			$delete_main_array = $this->input->post('delete_main_array');
			$data = array(
				'update_main_array' => $update_main_array,
				'delete_main_array' => $delete_main_array,
				'write_id' => $this->id,
				'update_date' => date("Y-m-d H:i:s")
			);
		}else if($data_type == "5"){//제품 정보
			$update_product_array = $this->input->post('update_product_array');
			$update_sub_product_array = $this->input->post('update_sub_product_array');
			$forcasting_sales = str_replace( ',', '', $this->input->post('forcasting_sales'));
			$forcasting_purchase = str_replace( ',', '', $this->input->post('forcasting_purchase'));
			$forcasting_profit = str_replace( ',', '', $this->input->post('forcasting_profit'));
			$division_month = $this->input->post('division_month');
			$exception_saledate2 = trim($this->input->post('exception_saledate2'));
			$exception_saledate3 = trim($this->input->post('exception_saledate3'));

			$data = array(
				'update_product_array' => $update_product_array,
				'update_sub_product_array' => $update_sub_product_array,
				'forcasting_sales' => $forcasting_sales,
				'forcasting_purchase' => $forcasting_purchase,
				'forcasting_profit' => $forcasting_profit,
				'division_month' => $division_month,
				'exception_saledate2' => $exception_saledate2,
				'exception_saledate3' => $exception_saledate3,
				'write_id' => $this->id,
				'update_date' => date("Y-m-d H:i:s")
			);
		}else if($data_type == "6"){
			$complete_status = $this->input->post('complete_status');

			$data = array(
				'complete_status' => $complete_status,
				'write_id' => $this->id,
				'update_date' => date("Y-m-d H:i:s")
			);
		}else if($data_type == "7"){
			$manage_team = $this->input->post('manage_team');
			$maintain_cycle = $this->input->post('maintain_cycle');
			$maintain_date = $this->input->post('maintain_date');
			$maintain_user = $this->input->post('maintain_user');
			$maintain_type = $this->input->post('maintain_type');
			$maintain_result = $this->input->post('maintain_result');
			$maintain_comment = $this->input->post('maintain_comment');

			$data = array(
				'manage_team' => $manage_team,
				'maintain_cycle' => $maintain_cycle,
				'maintain_date' => $maintain_date,
				'maintain_user' => $maintain_user,
				'maintain_type' => $maintain_type,
				'maintain_result' => $maintain_result,
				'maintain_comment' => $maintain_comment,
				'write_id' => $this->id,
				'update_date' => date("Y-m-d H:i:s")
			);

		}

		if ($seq == null) {
			$result = $this->STC_Maintain->maintain_insert($data);
		} else {
			$result = $this->STC_Maintain->maintain_insert($data,$seq,$data_type);
		}

		if($result) {
			echo "<script>alert('정상적으로 처리되었습니다.');opener.location.reload();self.close();</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}

	}

	// 포캐스팅 쓰기 뷰
	function maintain_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Maintain', 'STC_Common'));
		$data['product'] = $this->STC_Common->get_product();   //제조사, 품목, 제품명
		$this->load->view('tech/maintain_input', $data);
	}

	// 유지보수 뷰
	function maintain_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Maintain', 'STC_Common','STC_Forcasting','STC_User'));
//		$user_id = $this->idx;

		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );
		$customer_companyname = $this->input->post('customer_companyname');
		$project_name = $this->input->post('project_name');

		$data['view_val'] = $this->STC_Maintain->maintain_view($seq);		//기본
		$data['view_val2'] = $this->STC_Maintain->maintain_view2($seq);		//주사업자
		$data['view_val3'] = $this->STC_Maintain->maintain_view3($seq);		//제품명
		$data['bill_val'] = $this->STC_Maintain->maintain_sales_bill_view($seq); //계산서

		$data['sub_project'] = $this->STC_Maintain->sub_project_select($seq);	//연계 프로젝트 조회
		$data['sub_project_cancel'] = $this->STC_Maintain->sub_project_cancel($seq);  //조회취소 연계 프로젝트 조회
		$data['clist_val'] = $this->STC_Maintain->maintain_comment_list($seq);	//코멘트
		$data['product_company'] = $this->STC_Maintain->product_company();//제품 전체 제조사 조회
		// $data['sales_customer'] = $this->STC_User->sales_customer();
		$data['product'] = $this->STC_Common->get_product();	//제조사, 품목, 제품명
		$data['complete_status_val'] = $this->STC_Maintain->maintain_complete_status_comment_list($seq);	//수주여부 댓글

		$sub_project = explode(",",$data['view_val']['sub_project_add']);
		for($i=0; $i<count($sub_project); $i++){
			$data['sub_project_add'][$i] = $this->STC_Maintain->subProjectAdd($sub_project[$i]);  // 조회추가한 연계프로젝트 가져오기
		}

		$data['seq'] = $seq;

		$this->load->view('tech/maintain_view', $data );
	}

	// 포캐스팅 수정 뷰
	function maintain_modify() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Maintain', 'STC_Common'));
//		$user_id = $this->idx;

		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );

		$data['view_val'] = $this->STC_Maintain->maintain_view($seq);		//기본
		$data['view_val2'] = $this->STC_Maintain->maintain_view2($seq);		//주사업자
		$data['view_val3'] = $this->STC_Maintain->maintain_view3($seq);		//제품명
		$data['sub_project'] = $this->STC_Maintain->sub_project_select($seq);	//연계 프로젝트 조회
		$data['sub_project_cancel'] = $this->STC_Maintain->sub_project_cancel($seq);  //조회취소 연계 프로젝트 조회
		$data['clist_val'] = $this->STC_Maintain->maintain_comment_list($seq);	//코멘트
		$data['product_company'] = $this->STC_Maintain->product_company();//제품 전체 제조사 조회

		$data['product'] = $this->STC_Common->get_product();	//제조사, 품목, 제품명
		$data['complete_status_val'] = $this->STC_Maintain->maintain_complete_status_comment_list($seq);	//수주여부 댓글
		$sub_project = explode(",",$data['view_val']['sub_project_add']);
		for($i=0; $i<count($sub_project); $i++){
			$data['sub_project_add'][$i] = $this->STC_Maintain->subProjectAdd($sub_project[$i]);  // 조회추가한 연계프로젝트 가져오기
		}

		$data['seq'] = $seq;

		$this->load->view('tech/maintain_modify', $data );
	}



	// 포캐스팅 삭제
	function maintain_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		// $this->load->Model( 'STC_Maintain' );
		$seq = $this->input->post( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_Maintain->maintain_delete($seq);
		}

		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/tech/maintain/maintain_list'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}

	//포캐스팅 코멘트 등록 처리
	function maintain_comment_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Maintain', 'STC_Common'));

		$data = array(
			'maintain_seq' => $this->input->post('seq'),
			'user_id' => $this->id,
			'user_name' => $this->name,
			'contents' => $this->input->post('comment'),
			'insert_date' => date("Y-m-d H:i:s")
		);

		$result = $this->STC_Maintain->maintain_comment_insert($data);
		$result2 = $this->STC_Maintain->maintain_cnum_update($this->input->post('seq'));

		if($result && $result2) {
			echo "<script>alert('정상적으로 처리되었습니다.');history.go(-1);</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}

	}

	// 포캐스팅 코멘트 삭제처리
	function maintain_comment_delete() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		// $this->load->Model( 'STC_Maintain' );
		$seq = $this->input->post( 'seq' );
		$cseq = $this->input->post( 'cseq' );

		if ($seq != null && $cseq != null) {
			$tdata = $this->STC_Maintain->maintain_comment_delete($seq, $cseq);
			$result = $this->STC_Maintain->maintain_cnum_update2($this->input->post('seq'));
		}

		if ($tdata && $result) {
			echo "<script>alert('삭제완료 되었습니다.');history.go(-1);</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}

}
?>
