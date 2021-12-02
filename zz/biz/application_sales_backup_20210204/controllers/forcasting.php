<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Forcasting extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->lv = $this->phpsession->get( 'lv', 'stc' );
		$this->cnum = $this->phpsession->get( 'cnum', 'stc' );
	}

	//포캐스팅 리스트(공통)
	function forcasting_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Forcasting', 'STC_Common'));
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

		$data['search_keyword'] = $search_keyword;

		if  ( $cur_page <= 0 )
			$cur_page = 1;
		
		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Forcasting->forcasting_list($search_keyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list, $this->cnum);
		$data['count'] = $this->STC_Forcasting->forcasting_list_count($search_keyword, $this->cnum)->ucount;

		$excel_data = $this->STC_Forcasting->forcasting_excel_download($search_keyword, $this->cnum);
		
		
		$data['list_val'] = $user_list_data['data'];
		$data['list_val_count'] = $user_list_data['count'];
		$data['excel_val'] = $excel_data['data'];
		$data['excel_val_count'] = $excel_data['count'];
		
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
		
		$this->load->view( 'forcasting_list', $data );
	}
	
	
	//포캐스팅 입력/수정 처리
	function forcasting_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}
		
		$this->load->model( 'STC_Forcasting' );
		$this->load->model( 'STC_Maintain' );
		$seq = $this->input->post('seq');

		if ($seq == null) { // insert
			$customer_companyname = $this->input->post('customer_companyname');
			$customer_username = $this->input->post('customer_username');
			$customer_tel = $this->input->post('customer_tel');
			$customer_email = $this->input->post('customer_email');

			$project_name = $this->input->post('project_name');
			$progress_step = $this->input->post('progress_step');
			$type = $this->input->post('type');
			$procurement_sales_amount = $this->input->post('procurement_sales_amount');
			$cooperation_companyname = $this->input->post('cooperation_companyname');
			$cooperation_username = $this->input->post('cooperation_username');
			$cooperation_tel = $this->input->post('cooperation_tel');
			$dept = $this->input->post('dept');
			$cooperation_email = $this->input->post('cooperation_email');

			$sales_companyname = $this->input->post('sales_companyname');
			$sales_username = $this->input->post('sales_username');
			$sales_tel = $this->input->post('sales_tel');
			$sales_email = $this->input->post('sales_email');
			
			$update_main_array = $this->input->post('update_main_array');
			$insert_main_array = $this->input->post('insert_main_array');
			$delete_main_array = $this->input->post('delete_main_array');
			
			$update_product_array = $this->input->post('update_product_array');
			$insert_product_array = $this->input->post('insert_product_array');
			$delete_product_array = $this->input->post('delete_product_array');
			$forcasting_sales = str_replace( ',', '', $this->input->post('forcasting_sales'));
			$forcasting_purchase = str_replace( ',', '', $this->input->post('forcasting_purchase'));
			$forcasting_profit = str_replace( ',', '', $this->input->post('forcasting_profit'));
			$division_month = $this->input->post('division_month');
			$first_saledate = trim($this->input->post('first_saledate'));
			$exception_saledate = trim($this->input->post('exception_saledate'));

			$complete_status = $this->input->post('complete_status');
			
			// 기본
			$data = array(
				'customer_companyname' => $customer_companyname,
				'customer_username' => $customer_username,
				'customer_tel' => $customer_tel,
				'customer_email' => $customer_email,
				'project_name' => $project_name,
				'progress_step' => $progress_step,
				'type' => $type,
				'procurement_sales_amount' => $procurement_sales_amount,
				'cooperation_companyname' => $cooperation_companyname,
				'cooperation_username' => $cooperation_username,
				'dept' => $dept,
				'cooperation_tel' => $cooperation_tel,
				'cooperation_email' => $cooperation_email,
				'sales_companyname' => $sales_companyname,
				'sales_username' => $sales_username,
				'sales_tel' => $sales_tel,
				'sales_email' => $sales_email,
				'first_saledate' => $first_saledate,
				'exception_saledate' => $exception_saledate,
				'complete_status' => $complete_status,
				'write_id' => $this->id,
				'insert_main_array' => $insert_main_array,
				'update_main_array' => $update_main_array,
				'delete_main_array' => $delete_main_array,
				'forcasting_sales' => $forcasting_sales,
				'forcasting_purchase' => $forcasting_purchase,
				'forcasting_profit' => $forcasting_profit,
				'division_month' => $division_month,
				'insert_product_array' => $insert_product_array,
				'update_product_array' => $update_product_array,
				'delete_product_array' => $delete_product_array,
			);
			$result = $this->STC_Forcasting->forcasting_insert($data, $mode = 0);

			//유지보수 테이블을 생성해주기 85% 이상이 되었을 때
			if($progress_step == "015"){
				$maintain_data = $this->STC_Forcasting->select_sales_maintain($result);
				if($maintain_data == false){
					$result = $this->STC_Forcasting->forcasting_duplication($result);
				}
			}

			if($result) {
				echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/forcasting/forcasting_list'</script>";
			} else {
				echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
			}
		} else {
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
			}else if($data_type == "2"){
				$project_name = $this->input->post('project_name');
				$progress_step = $this->input->post('progress_step');
				$type = $this->input->post('type');
				$procurement_sales_amount= $this->input->post('procurement_sales_amount');
				$cooperation_companyname = $this->input->post('cooperation_companyname');
				$cooperation_username = $this->input->post('cooperation_username');
				$dept = $this->input->post('dept');
				$cooperation_tel = $this->input->post('cooperation_tel');
				$cooperation_email = $this->input->post('cooperation_email');
				$create_maintain_table = $this->input->post('create_maintain_table');

				$data = array(
					'project_name' => $project_name,
					'progress_step' => $progress_step,
					'type' => $type,
					'procurement_sales_amount' => $procurement_sales_amount,
					'cooperation_companyname' => $cooperation_companyname,
					'cooperation_username' => $cooperation_username,
					'dept' => $dept,
					'cooperation_tel' => $cooperation_tel,
					'cooperation_email' => $cooperation_email,
					'write_id' => $this->id,
					'update_date' => date("Y-m-d H:i:s")
				);
			}else if($data_type == "3"){
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
			}else if($data_type == "4"){
				$update_main_array = $this->input->post('update_main_array');
				$insert_main_array = $this->input->post('insert_main_array');
				$delete_main_array = $this->input->post('delete_main_array');
				$data = array(
					'insert_main_array' => $insert_main_array,
					'update_main_array' => $update_main_array,
					'delete_main_array' => $delete_main_array,
					'write_id' => $this->id,
					'update_date' => date("Y-m-d H:i:s")
				);
			}else if($data_type == "5"){
				$update_product_array = $this->input->post('update_product_array');
				$insert_product_array = $this->input->post('insert_product_array');
				$delete_product_array = $this->input->post('delete_product_array');
				$forcasting_sales = str_replace( ',', '', $this->input->post('forcasting_sales'));
				$forcasting_purchase = str_replace( ',', '', $this->input->post('forcasting_purchase'));
				$forcasting_profit = str_replace( ',', '', $this->input->post('forcasting_profit'));
				$division_month = $this->input->post('division_month');
				$first_saledate = trim($this->input->post('first_saledate'));
				$exception_saledate = trim($this->input->post('exception_saledate'));

				$data = array(
					'insert_product_array' => $insert_product_array,
					'update_product_array' => $update_product_array,
					'delete_product_array' => $delete_product_array,
					'forcasting_sales' => $forcasting_sales,
					'forcasting_purchase' => $forcasting_purchase,
					'forcasting_profit' => $forcasting_profit,
					'division_month' => $division_month,
					'first_saledate' => $first_saledate,
					'exception_saledate' => $exception_saledate,
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
			}
			$result = $this->STC_Forcasting->forcasting_insert($data, $mode = 1, $seq, $data_type);
			if($result == true && $data_type == "2"){
				//유지보수 테이블을 생성해주기 85% 이상이 되었을 때
				if($create_maintain_table == "Y"){
					$maintain_data = $this->STC_Forcasting->select_sales_maintain($seq);
					if($maintain_data == false){
						$result = $this->STC_Forcasting->forcasting_duplication($seq);
					}else{
						echo "<script>alert('해당 포캐스팅에 대한 유지보수가 존재합니다. 삭제 후 다시 생성됩니다.');</script>";
						$result = $this->STC_Forcasting->delete_sales_maintain($seq);
						$result = $this->STC_Forcasting->forcasting_duplication($seq);
					}
				}
			}
			if($result) {
				echo "<script>alert('정상적으로 처리되었습니다.');opener.location.reload();self.close();</script>";
			} else {
				echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
			}
		}		
	}

	// 포캐스팅 쓰기 뷰
	function forcasting_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Forcasting', 'STC_Common','STC_User'));
		$data['product'] = $this->STC_Common->get_product();   //제조사, 품목, 제품명
		$data['check_list'] = $this->STC_Forcasting->check_list_template(); //점검항목 템플릿
		$data['sales_customer'] = $this->STC_User->sales_customer();
		$data['product_company'] = $this->STC_Forcasting->product_company();//제품 전체 제조사 조회
		$this->load->view( 'forcasting_input', $data);
	}

	// 포캐스팅 뷰
	function forcasting_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Forcasting', 'STC_Common','STC_User'));
		
		$seq = $this->input->get( 'seq' );
		
		$data['view_val'] = $this->STC_Forcasting->forcasting_view($seq);		//기본
		$data['view_val2'] = $this->STC_Forcasting->forcasting_view2($seq);		//주사업자
		$data['view_val3'] = $this->STC_Forcasting->forcasting_view3($seq);		//제품명
		$data['clist_val'] = $this->STC_Forcasting->forcasting_comment_list($seq);	//코멘트
		$data['complete_status_val'] = $this->STC_Forcasting->forcasting_complete_status_comment_list($seq);	//수주여부 댓글

		$data['product'] = $this->STC_Common->get_product();	//제조사, 품목, 제품명
		$data['check_list'] = $this->STC_Forcasting->check_list_template(); //점검항목 템플릿
		$data['sales_customer'] = $this->STC_User->sales_customer();
		$data['product_company'] = $this->STC_Forcasting->product_company();//제품 전체 제조사 조회
		$data['seq'] = $seq;
		
		$this->load->view( 'forcasting_view', $data );
	}

		// 포캐스팅 수정 뷰
		function forcasting_modify() {
			if( $this->id === null ) {
				redirect( 'account' );
			}
	
			$this->load->Model(array('STC_Forcasting', 'STC_Common','STC_User'));
			
			$seq = $this->input->get( 'seq' );
			$mode = $this->input->get( 'mode' );
			
			$data['view_val'] = $this->STC_Forcasting->forcasting_view($seq);		//기본
			$data['view_val2'] = $this->STC_Forcasting->forcasting_view2($seq);		//주사업자
			$data['view_val3'] = $this->STC_Forcasting->forcasting_view3($seq);		//제품명
			$data['clist_val'] = $this->STC_Forcasting->forcasting_comment_list($seq);	//코멘트
			$data['complete_status_val'] = $this->STC_Forcasting->forcasting_complete_status_comment_list($seq);	//수주여부 댓글
	
			$data['product'] = $this->STC_Common->get_product();	//제조사, 품목, 제품명
			$data['check_list'] = $this->STC_Forcasting->check_list_template(); //점검항목 템플릿
			$data['sales_customer'] = $this->STC_User->sales_customer();
			$data['product_company'] = $this->STC_Forcasting->product_company();//제품 전체 제조사 조회
	
			$data['seq'] = $seq;
			
			$this->load->view( 'forcasting_modify', $data );
		}
	
	// 포캐스팅 삭제
	function forcasting_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		$this->load->model( 'STC_Forcasting' );
		$this->load->model( 'STC_Maintain' );
		$seq = $this->input->get( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_Forcasting->forcasting_delete($seq);
			// $tdata = $this->STC_Maintain->maintain_delete($seq);
		} 
		
		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/forcasting/forcasting_list'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}

	//포캐스팅 코멘트 등록 처리
	function forcasting_comment_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Forcasting', 'STC_Common'));
		
		$data = array(
			'forcasting_seq' => $this->input->post('seq'),
			'user_id' => $this->id,
			'user_name' => $this->name,
			'contents' => $this->input->post('comment'),
			'insert_date' => date("Y-m-d H:i:s")
		);
		
		$result = $this->STC_Forcasting->forcasting_comment_insert($data);
		$result2 = $this->STC_Forcasting->forcasting_cnum_update($this->input->post('seq'));
		
		if($result && $result2) {
			echo "<script>alert('정상적으로 처리되었습니다.');history.go(-1);</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
		
	}

	// 포캐스팅 코멘트 삭제처리
	function forcasting_comment_delete() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		$this->load->model( 'STC_Forcasting' );
		$seq = $this->input->post( 'seq' );
		$cseq = $this->input->post( 'cseq' );
		
		if ($seq != null && $cseq != null) {
			$tdata = $this->STC_Forcasting->forcasting_comment_delete($seq, $cseq);
			$result = $this->STC_Forcasting->forcasting_cnum_update2($this->input->post('seq'));
		} 
		
		if ($tdata && $result) {
			echo "<script>alert('삭제완료 되었습니다.');history.go(-1);</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}

	// 수주여부코멘트 첨부파일 다운로드처리
	function complete_status_comment_download($file_real_name,$file_change_name) {
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model(array('STC_tech_doc'));
	
		ini_set('memory_limit', '200M'); // 김수성 수정 2017-01-04
	
		// $fdata = $this->STC_tech_doc->tech_doc_file($seq, $filelcname);
		
	
		$data = file_get_contents("/var/www/html/stc/misc/upload/sales/complete_status_comment/".$file_change_name);

		$file_real_name = str_replace("&#40;","(",$file_real_name);
		$file_real_name = str_replace("&#41;",")",$file_real_name);
	
		if (!force_download($file_real_name, $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 수주여부 코멘트 첨부파일 삭제처리
	function forcasting_complete_status_filedel($seq, $filelcname){
		$this->load->helper('alert');
		$this->load->helper('download');
		$this->load->Model('STC_Forcasting');
	
		$fdata = $this->STC_Forcasting->forcasting_complete_status_filedel($seq);
		if($fdata) {
			$result = unlink("/var/www/html/stc/misc/upload/sales/complete_status_comment/".$filelcname);
			if ($result == false) {
				alert('파일이 정상적으로 삭제 되지 않았습니다.');
				echo '<script>history.go(-1);</script>';
			} else {
				alert('파일이 정상적으로 삭제되었습니다.');
				echo '<script>history.go(-1);</script>';
			}
		}
	}

//////////////////////////////////  수주완료 스타뜨! //////////////////////////////////////
	//수주완료 리스트
	function order_completed_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Forcasting', 'STC_Common'));
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

		$data['search_keyword'] = $search_keyword;

		if( $cur_page <= 0 ){
			$cur_page = 1;
		}
			
		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Forcasting->order_completed_list($search_keyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list, $this->cnum);
		$data['count'] = $this->STC_Forcasting->order_completed_list_count($search_keyword, $this->cnum)->ucount;

		$excel_data = $this->STC_Forcasting->order_completed_excel_download($search_keyword, $this->cnum);
		
		
		$data['list_val'] = $user_list_data['data'];
		$data['list_val_count'] = $user_list_data['count'];
		$data['excel_val'] = $excel_data['data'];
		$data['excel_val_count'] = $excel_data['count'];
		
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
		
		$this->load->view( 'order_completed_list', $data );
	}

	// 수주완료 뷰
	function order_completed_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Forcasting', 'STC_Common','STC_User'));
		
		$seq = $this->input->get( 'seq' );
		
		$data['view_val'] = $this->STC_Forcasting->forcasting_view($seq);		//기본
		$data['view_val2'] = $this->STC_Forcasting->forcasting_view2($seq);		//주사업자
		$data['view_val3'] = $this->STC_Forcasting->forcasting_view3($seq);		//제품명
		$data['clist_val'] = $this->STC_Forcasting->forcasting_comment_list($seq);	//코멘트
		$data['complete_status_val'] = $this->STC_Forcasting->forcasting_complete_status_comment_list($seq);	//수주여부 댓글

		$data['product'] = $this->STC_Common->get_product();	//제조사, 품목, 제품명
		$data['check_list'] = $this->STC_Forcasting->check_list_template(); //점검항목 템플릿
		$data['sales_customer'] = $this->STC_User->sales_customer();
		$data['product_company'] = $this->STC_Forcasting->product_company();//제품 전체 제조사 조회
		$data['seq'] = $seq;
		$data['bill_val'] = $this->STC_Forcasting->forcasting_sales_bill_view($seq);//계산서
		
		$this->load->view( 'order_completed_view', $data );
	}

	// 수주완료 modify
	function order_completed_modify() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Forcasting', 'STC_Common','STC_User'));
		
		$seq = $this->input->get( 'seq' );
		
		$data['view_val'] = $this->STC_Forcasting->forcasting_view($seq);		//기본
		$data['view_val2'] = $this->STC_Forcasting->forcasting_view2($seq);		//주사업자
		$data['view_val3'] = $this->STC_Forcasting->forcasting_view3($seq);		//제품명
		$data['seq'] = $seq;

		$data['bill_val'] = $this->STC_Forcasting->forcasting_sales_bill_view($seq);//계산서
		
		$this->load->view( 'order_completed_modify', $data );
	}

	//수주완료 세금계산서 insert/update/delete
	function completed_modfiy_action(){
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Forcasting', 'STC_Common','STC_User'));
		$result = true;
		$forcasting_seq = $this->input->post( 'forcasting_seq' ); 
		$delete_bill_array = $this->input->post( 'delete_bill_array' );
		$sales_total_issuance_amount = $this->input->post( 'sales_total_issuance_amount' );
		$insert_bill_array = $this->input->post('insert_bill_array');
		$insert_bill_array = json_decode($insert_bill_array, true);
		$update_bill_array = $this->input->post('update_bill_array');
		$update_bill_array = json_decode($update_bill_array, true); 

		if($sales_total_issuance_amount == 1){
			$result = $this->STC_Forcasting->sales_forcasting_progress_step_change('016',$forcasting_seq); // 1일 경우 progress step 016 으로 수정
		}else if($sales_total_issuance_amount == 2){
			$result = $this->STC_Forcasting->sales_forcasting_progress_step_change('018',$forcasting_seq); // 2일 경우 progress step 016 으로 수정	
		}

		if($delete_bill_array != ""){
			$result = $this->STC_Forcasting->forcasting_sales_bill_save($delete_bill_array,2);
		}

		if(!empty($insert_bill_array['value'])){

			for($i=0; $i<count($insert_bill_array['value']); $i++){
				$val = explode("||",$insert_bill_array['value'][$i]);
				$data = array(
					'forcasting_seq' => $forcasting_seq,
					'type' => $val[0],
					'company_name' => $val[1],
					'percentage' => $val[2],
					'issuance_amount' => str_replace(',','',$val[3]),
					'tax_approval_number' => $val[4],
					'issuance_month' => $val[5],
					'issuance_date' => $val[6],
					'issuance_status' => $val[7],
					'deposit_date' => $val[8],
					'deposit_status' => $val[9],
					'write_id' => $this->id,
					'insert_date' => date("Y-m-d H:i:s")
				);
				$result = $this->STC_Forcasting->forcasting_sales_bill_save($data,0);
			}
		}

		if(!empty($update_bill_array['value'])){

			for($i=0; $i<count($update_bill_array['value']); $i++){
				$val = explode("||",$update_bill_array['value'][$i]);
				$data = array(
					'seq' => $val[0],
					'percentage' => $val[1],
					'issuance_amount' => str_replace(',','',$val[2]),
					'tax_approval_number' => $val[3],
					'issuance_month' => $val[4],
					'issuance_date' => $val[5],
					'issuance_status' => $val[6],
					'deposit_date' => $val[7],
					'deposit_status' => $val[8],
					'write_id' => $this->id,
					'insert_date' => date("Y-m-d H:i:s")
				);
				$result = $this->STC_Forcasting->forcasting_sales_bill_save($data,1);
			}
		}

		if($result) {
			echo "<script>alert('정상적으로 처리되었습니다.');opener.location.reload();self.close();</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	}
	
}
?>