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
		$this->seq = $this->phpsession->get( 'seq', 'stc' );
		$this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );

		if($this->cooperation_yn == 'Y') {
			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
		}

		$this->load->library('user_agent');

		$this->load->Model(array('sales/STC_Forcasting', 'STC_Common', 'sales/STC_Maintain', 'sales/STC_User'));
	}

	//포캐스팅 리스트(공통)
	function forcasting_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$mode = $_GET['mode'];//forcasting인지 실주인지 구분
		$data['mode'] = $mode ;

		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		}
		else {
			$cur_page = 0;
		}														//	현재 페이지
		if(isset($_GET['lpp'])==false || $_GET['lpp']=='') {
			$no_page_list = 10;										//	한페이지에 나타나는 목록 개수
		} else {
			$no_page_list = (int)$_GET['lpp'];
		}

		$data['lpp'] = $no_page_list;

		if(isset($_GET['search_mode'])) {
			$search_mode = $_GET['search_mode'];
		} else {
			$search_mode = 'simple';
		}

		if(isset($_GET['searchkeyword'])) {
			$search_keyword = $_GET['searchkeyword'];
		} else {
			$search_keyword = "";
		}

		$data['search_keyword'] = $search_keyword;

		if  ( $cur_page <= 0 )
			$cur_page = 1;

		$data['cur_page'] = $cur_page;

		//amount 금액조회
		$amount_list_data = $this->STC_Forcasting->forcasting_list($search_mode,$search_keyword,0, 0, $this->cnum, $mode);
		$data['amount_list_val'] = $amount_list_data['data'];

		$user_list_data = $this->STC_Forcasting->forcasting_list($search_mode,$search_keyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list, $this->cnum, $mode, 'list');
		$data['count'] = $this->STC_Forcasting->forcasting_list_count($search_mode,$search_keyword, $this->cnum, $mode)->ucount;

		$excel_data = $this->STC_Forcasting->forcasting_excel_download($search_mode,$search_keyword, $this->cnum,$mode);


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

		if($this->agent->is_mobile()) {
			$data['title'] = '포캐스팅';
			if($mode == 'mistake') {
				$data['title'] = '실주';
			}
			$this->load->view( 'sales/forcasting_list_mobile', $data );
		} else {
			$this->load->view( 'sales/forcasting_list', $data );
		}
	}


	//포캐스팅 입력/수정 처리
	function forcasting_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model( 'STC_Forcasting' );
		// $this->load->Model( 'STC_Maintain' );
		$seq = $this->input->post('seq');

		if ($seq == null) { // insert
			$customer_seq = $this->input->post('select_customer_company');
			if($customer_seq == ""){
				$customer_seq = null;
			}
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
			$warranty_end_date = trim($this->input->post('warranty_end_date'));

			$complete_status = $this->input->post('complete_status');
			$mistake_order_reason = $this->input->post('mistake_order_reason');
			$infor_comm_corporation = $this->input->post('infor_comm_corporation');

			$sales_type = $this->input->post('sales_type');

			// 기본
			$data = array(
				'customer_seq'             => $customer_seq,
				'customer_companyname'     => $customer_companyname,
				'customer_username'        => $customer_username,
				'customer_tel'             => $customer_tel,
				'customer_email'           => $customer_email,
				'project_name'             => $project_name,
				'progress_step'            => $progress_step,
				'type'                     => $type,
				'procurement_sales_amount' => $procurement_sales_amount,
				'cooperation_companyname'  => $cooperation_companyname,
				'cooperation_username'     => $cooperation_username,
				'dept'                     => $dept,
				'cooperation_tel'          => $cooperation_tel,
				'cooperation_email'        => $cooperation_email,
				'sales_companyname'        => $sales_companyname,
				'sales_username'           => $sales_username,
				'sales_tel'                => $sales_tel,
				'sales_email'              => $sales_email,
				'first_saledate'           => $first_saledate,
				'exception_saledate'       => $exception_saledate,
				'warranty_end_date'        => $warranty_end_date,
				'complete_status'          => $complete_status,
				'write_id'                 => $this->id,
				'forcasting_sales'         => $forcasting_sales,
				'forcasting_purchase'      => $forcasting_purchase,
				'forcasting_profit'        => $forcasting_profit,
				'division_month'           => $division_month,
				'mistake_order_reason'     => $mistake_order_reason,
				'infor_comm_corporation'   => $infor_comm_corporation,
				'sales_type'               => $sales_type,
				'insert_date'              => date("Y-m-d H:i:s")
			);
			$forcasting_seq = $this->STC_Forcasting->forcasting_insert($data, $mode = 0);

			//매입처 등록
			$insert_main_array = explode("||",$insert_main_array);
			for ($i = 1; $i < count($insert_main_array); $i++) {
				$main_list = explode("~", $insert_main_array[$i]);
				$main_data = array(
					'forcasting_seq' => $forcasting_seq,
					'main_companyname' => $main_list[0],
					'main_username' => $main_list[1],
					'main_tel' => $main_list[2],
					'main_email' =>$main_list[3],
					'insert_date' => date("Y-m-d H:i:s")
				);
				$result = $this->STC_Forcasting->forcasting_main_insert($main_data,$mode=0,$forcasting_seq);
			}

			//제품등록
			$insert_product_array = explode("||", $insert_product_array);
			for ($i = 1; $i < count($insert_product_array); $i++) {
				$product_list = explode("~", $insert_product_array[$i]);
				$product_data = array(
					'forcasting_seq'   => $forcasting_seq,
					'product_code'     => $product_list[0],
					'product_supplier' => $product_list[1],
					'product_licence'  => $product_list[2],
					'product_serial'   => $product_list[3],
					'product_state'    => $product_list[4],
					'product_sales'    => $product_list[5],
					'product_purchase' => $product_list[6],
					'product_profit'   => $product_list[7],
					'comment'   	   => $product_list[8],
					'insert_date'      => date("Y-m-d H:i:s")
				);
				$result = $this->STC_Forcasting->forcasting_product_insert($product_data,$mode=0,$forcasting_seq);
			}

			// 최초 작성자 로그에 남기기
			$log_data = array(
				'forcasting_seq'  => $forcasting_seq,
				'log_type'        => 'insert',
				'write_seq'       => $this->seq,
				'update_date'     => date("Y-m-d H:i:s")
			);
			$this->STC_Forcasting->forcasting_log_insert($log_data);

			if($result) {
				if($progress_step >'014'){
					echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/forcasting/order_completed_list'</script>";
				}else if($progress_step == '000') {
					echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/forcasting/forcasting_list?mode=mistake'</script>";
				}else{
					echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/forcasting/forcasting_list?mode=forcasting'</script>";
				}
			} else {
				echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
			}
		} else {
			$data_type = $this->input->post('data_type');
			if($data_type == "1"){//고객사 정보
				$customer_seq = $this->input->post('select_customer_company');
				if($customer_seq == ""){
					$customer_seq = null;
				}
				$customer_companyname = $this->input->post('customer_companyname');
				$customer_username = $this->input->post('customer_username');
				$customer_tel = $this->input->post('customer_tel');
				$customer_email = $this->input->post('customer_email');
				$data = array(
					'customer_seq' =>$customer_seq,
					'customer_companyname' => $customer_companyname,
					'customer_username' => $customer_username,
					'customer_tel' => $customer_tel,
					'customer_email' => $customer_email,
					'write_id' => $this->id,
					'update_date' => date("Y-m-d H:i:s")
				);
			    // $this->STC_Forcasting->forcasting_maintain_interlock_modify($customer_companyname, $seq);

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
				$mistake_order_reason = $this->input->post('mistake_order_reason');
				$infor_comm_corporation = $this->input->post('infor_comm_corporation');
				$sales_type = $this->input->post('sales_type');

				$data = array(
					'project_name'             => $project_name,
					'progress_step'            => $progress_step,
					'type'                     => $type,
					'procurement_sales_amount' => $procurement_sales_amount,
					'cooperation_companyname'  => $cooperation_companyname,
					'cooperation_username'     => $cooperation_username,
					'dept'                     => $dept,
					'cooperation_tel'          => $cooperation_tel,
					'cooperation_email'        => $cooperation_email,
					'mistake_order_reason'     => $mistake_order_reason,
					'infor_comm_corporation'   => $infor_comm_corporation,
					'sales_type'               => $sales_type,
					'write_id'                 => $this->id,
					'update_date'              => date("Y-m-d H:i:s")
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
				//매입처 등록
				$insert_main_array = explode("||",$this->input->post('insert_main_array'));
				for ($i = 1; $i < count($insert_main_array); $i++) {
					$main_list = explode("~", $insert_main_array[$i]);
					$main_data = array(
						'forcasting_seq' => $seq,
						'main_companyname' => $main_list[0],
						'main_username' => $main_list[1],
						'main_tel' => $main_list[2],
						'main_email' =>$main_list[3],
						'insert_date' => date("Y-m-d H:i:s")
					);
					$result = $this->STC_Forcasting->forcasting_main_insert($main_data,$mode=0,$seq);
				}

				//매입처 수정
				$update_main_array = explode("||",$this->input->post('update_main_array'));
				for ($i = 1; $i < count($update_main_array); $i++) {
					$main_list = explode("~", $update_main_array[$i]);
					$main_data = array(
						'forcasting_seq' => $seq,
						'main_companyname' => $main_list[0],
						'main_username' => $main_list[1],
						'main_tel' => $main_list[2],
						'main_email' =>$main_list[3],
						'seq' => $main_list[4],
						'update_date' => date("Y-m-d H:i:s")
					);
					$result = $this->STC_Forcasting->forcasting_main_insert($main_data,$mode=1,$seq);
				}

				//매입처 삭제
				$delete_main_array = explode(",",$this->input->post('delete_main_array'));

				for($i=1; $i<count($delete_main_array); $i++){
					$main_data = $delete_main_array[$i];
					$result = $this->STC_Forcasting->forcasting_main_insert($main_data,$mode=2,$seq);
				}

				// $data = array(
				// 	'write_id' => $this->id,
				// 	'update_date' => date("Y-m-d H:i:s")
				// );

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
				$warranty_end_date = trim($this->input->post('warranty_end_date'));
				echo $warranty_end_date;

				//제품 delete
				$delete_product_array = explode(",", $delete_product_array);

				for($i=1; $i<count($delete_product_array); $i++){
					$product_data = $delete_product_array[$i];
					$result = $this->STC_Forcasting->forcasting_product_insert($product_data,$mode=2,$seq);
				}

				//제품 update
				$update_product_array = explode("||", $update_product_array);
				for ($i = 1; $i < count($update_product_array); $i++) {
					$product_list = explode("~", $update_product_array[$i]);
					$product_data = array(
						'forcasting_seq' => $seq,
						'product_code' => $product_list[0],
						'product_supplier' => $product_list[1],
						'product_licence' => $product_list[2],
						'product_serial' =>$product_list[3],
						'product_state' => $product_list[4],
						'product_sales' => $product_list[5],
						'product_purchase' => $product_list[6],
						'product_profit' => $product_list[7],
						'comment' => $product_list[8],
						'seq' => $product_list[9],
						'update_date' => date("Y-m-d H:i:s")
					);
					$result = $this->STC_Forcasting->forcasting_product_insert($product_data,$mode=1,$seq);
				}

				//제품등록
				$insert_product_array = explode("||", $insert_product_array);
				for ($i = 1; $i < count($insert_product_array); $i++) {
					$product_list = explode("~", $insert_product_array[$i]);
					$product_data = array(
						'forcasting_seq'   => $seq,
						'product_code'     => $product_list[0],
						'product_supplier' => $product_list[1],
						'product_licence'  => $product_list[2],
						'product_serial'   => $product_list[3],
						'product_state'    => $product_list[4],
						'product_sales'    => $product_list[5],
						'product_purchase' => $product_list[6],
						'product_profit'   => $product_list[7],
						'comment'          => $product_list[8],
						'insert_date'      => date("Y-m-d H:i:s")

					);
					$result = $this->STC_Forcasting->forcasting_product_insert($product_data,$mode=0,$seq);
				}

				$data = array(
					'forcasting_sales' => $forcasting_sales,
					'forcasting_purchase' => $forcasting_purchase,
					'forcasting_profit' => $forcasting_profit,
					'division_month' => $division_month,
					'first_saledate' => $first_saledate,
					'exception_saledate' => $exception_saledate,
					'warranty_end_date' => $warranty_end_date,
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

			if($data_type != "4"){ //매입처일땐 안해줄꺼야
				$result = $this->STC_Forcasting->forcasting_insert($data, $mode = 1, $seq, $data_type);
			}

			// 수정자 로그에 남기기
			$log_data = array(
				'forcasting_seq'  => $seq,
				'log_type'        => 'modify',
				'write_seq'       => $this->seq,
				'update_date'     => date("Y-m-d H:i:s")
			);
			$this->STC_Forcasting->forcasting_log_insert($log_data);

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

		// $this->load->Model(array('STC_Forcasting', 'STC_Common','STC_User'));
		$data['product'] = $this->STC_Common->get_product();   //제조사, 품목, 제품명
		$data['check_list'] = $this->STC_Forcasting->check_list_template(); //점검항목 템플릿
		$data['sales_customer'] = $this->STC_User->sales_customer();
		$data['product_company'] = $this->STC_Forcasting->product_company();//제품 전체 제조사 조회
		$this->load->view( 'sales/forcasting_input', $data);
	}

	// 포캐스팅 뷰
	function forcasting_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Forcasting', 'STC_Common','STC_User'));

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

		$data['modify_name'] = $this->STC_Common->user_info('user_id', $data['view_val']['write_id']);
		$data['writer'] = $this->STC_Forcasting->log_data('insert', $seq); // 작성자
		$data['modifier'] = $this->STC_Forcasting->log_data('modify', $seq); // 수정자

		$this->load->view( 'sales/forcasting_view', $data );
	}

		// 포캐스팅 수정 뷰
		function forcasting_modify() {
			if( $this->id === null ) {
				redirect( 'account' );
			}

			// $this->load->Model(array('STC_Forcasting', 'STC_Common','STC_User'));

			$seq = $this->input->get( 'seq' );
			$mode = $this->input->get( 'mode' );

			$data['view_val'] = $this->STC_Forcasting->forcasting_view($seq);		//기본
			$data['view_val2'] = $this->STC_Forcasting->forcasting_view2($seq);		//주사업자
			$data['view_val3'] = $this->STC_Forcasting->forcasting_view3($seq);		//제품명
			$data['clist_val'] = $this->STC_Forcasting->forcasting_comment_list($seq);	//코멘트
			$data['complete_status_val'] = $this->STC_Forcasting->forcasting_complete_status_comment_list($seq);	//수주여부 댓글

			$data['product'] = $this->STC_Common->get_product();	//제조사, 품목, 제품명
			$data['check_list'] = $this->STC_Forcasting->check_list_template(); //점검항목 템플릿
			//고객사랑 담당자 가져오기
			$data['sales_customer'] = $this->STC_User->sales_customer();
			$customer_seq = $data['view_val']['customer_seq'];
			if($customer_seq != ""){

				$data['customer_staff'] = $this->STC_User->sales_customer_staff($customer_seq);
			}

			$data['product_company'] = $this->STC_Forcasting->product_company();//제품 전체 제조사 조회


			$data['seq'] = $seq;

			$this->load->view( 'sales/forcasting_modify', $data );
		}

	// 포캐스팅 삭제
	function forcasting_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		// $this->load->Model( 'STC_Forcasting' );
		// $this->load->Model( 'STC_Maintain' );
		$seq = $this->input->get( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_Forcasting->forcasting_delete($seq);
			// $tdata = $this->STC_Maintain->maintain_delete($seq);
		}

		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/sales/forcasting/forcasting_list?mode=forcasting'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}

	//포캐스팅 코멘트 등록 처리
	function forcasting_comment_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Forcasting', 'STC_Common'));

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
		// $this->load->Model( 'STC_Forcasting' );
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
		// // $this->load->Model(array('STC_tech_doc'));

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
		// $this->load->Model('STC_Forcasting');

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

		// $this->load->Model(array('STC_Forcasting', 'STC_Common'));
//		$cur_page = $this->input->get( 'cur_page' );			//	현재 페이지
		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		}
		else {
			$cur_page = 0;
		}														//	현재 페이지
		if(isset($_GET['lpp'])==false || $_GET['lpp']=='') {
			$no_page_list = 10;										//	한페이지에 나타나는 목록 개수
		} else {
			$no_page_list = (int)$_GET['lpp'];
		}

		$data['lpp'] = $no_page_list;

		if(isset($_GET['search_mode'])) {
			$search_mode = $_GET['search_mode'];
		} else {
			$search_mode = 'simple';
		}

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

		//amount 금액조회
		$amount_list_data = $this->STC_Forcasting->order_completed_list($search_mode, $search_keyword,0, 0, $this->cnum);
		$data['amount_list_val'] = $amount_list_data['data'];

		$user_list_data = $this->STC_Forcasting->order_completed_list($search_mode, $search_keyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list, $this->cnum, 'list');
		$data['count'] = $this->STC_Forcasting->order_completed_list_count($search_mode, $search_keyword, $this->cnum)->ucount;

		$excel_data = $this->STC_Forcasting->order_completed_excel_download($search_mode, $search_keyword, $this->cnum);

		$data['forcasting_minus'] = $this->STC_Forcasting->forcasting_adjust($search_mode, $search_keyword, 'minus');
		$data['forcasting_plus']  = $this->STC_Forcasting->forcasting_adjust($search_mode, $search_keyword, 'plus');

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

		if($this->agent->is_mobile()) {
			$data['title'] = '수주완료';
			$this->load->view( 'sales/order_completed_list_mobile', $data );
		} else {
			$this->load->view( 'sales/order_completed_list', $data );
		}
	}

	// 수주완료 뷰
	function order_completed_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Forcasting', 'STC_Common','STC_User'));

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
		$data['approval_doc'] = $this->STC_Forcasting->approval_doc("forcasting_seq=".$seq); //해당하는 기안문 있늬?

		$data['modify_name'] = $this->STC_Common->user_info('user_id', $data['view_val']['write_id']);
		$data['writer'] = $this->STC_Forcasting->log_data('insert', $seq); // 작성자
		$data['modifier'] = $this->STC_Forcasting->log_data('modify', $seq); // 수정자

		$this->load->view( 'sales/order_completed_view', $data );
	}

	// 수주완료 modify
	function order_completed_modify() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Forcasting', 'STC_Common','STC_User'));

		$seq = $this->input->get( 'seq' );

		$data['view_val'] = $this->STC_Forcasting->forcasting_view($seq);		//기본
		$data['view_val2'] = $this->STC_Forcasting->forcasting_view2($seq);		//주사업자
		$data['view_val3'] = $this->STC_Forcasting->forcasting_view3($seq);		//제품명
		$data['seq'] = $seq;

		$data['bill_val'] = $this->STC_Forcasting->forcasting_sales_bill_view($seq);//계산서

		$this->load->view( 'sales/order_completed_modify', $data );
	}

	//수주완료 세금계산서 insert/update/delete
	function completed_modfiy_action(){
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Forcasting', 'STC_Common','STC_User'));
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
				if(!empty($insert_bill_array['value'][$i])){
					$val = explode("||",$insert_bill_array['value'][$i]);
					$data = array(
						'forcasting_seq' => $forcasting_seq,
						'type' => $val[0],
						'company_name' => $val[1],
						'pay_session' => $val[2],
						'percentage' => $val[3],
						'issuance_amount' => str_replace(',','',$val[4]),
						'tax_amount' => str_replace(',','',$val[5]),
						'total_amount' => str_replace(',','',$val[6]),
						'tax_approval_number' => $val[7],
						'issuance_month' => $val[8],
						'issuance_date' => $val[9],
						'issuance_status' => $val[10],
						'deposit_date' => $val[11],
						'deposit_status' => $val[12],
						'write_id' => $this->id,
						'insert_date' => date("Y-m-d H:i:s")
					);
					if ($data['issuance_date']=='') {
						$data['issuance_date'] = null;
					}
					if ($data['deposit_date']=='') {
						$data['deposit_date'] = null;
					}
					$result = $this->STC_Forcasting->forcasting_sales_bill_save($data,0);
				}
			}
		}

		if(!empty($update_bill_array['value'])){

			for($i=0; $i<count($update_bill_array['value']); $i++){
				if(!empty($update_bill_array['value'][$i])){
					$val = explode("||",$update_bill_array['value'][$i]);
					$data = array(
						'seq' => $val[0],
						'pay_session' => $val[1],
						'percentage' => $val[2],
						'issuance_amount' => str_replace(',','',$val[3]),
						'tax_amount' => str_replace(',','',$val[4]),
						'total_amount' => str_replace(',','',$val[5]),
						'tax_approval_number' => $val[6],
						'issuance_month' => $val[7],
						'issuance_date' => $val[8],
						'issuance_status' => $val[9],
						'deposit_date' => $val[10],
						'deposit_status' => $val[11],
						'write_id' => $this->id,
						'insert_date' => date("Y-m-d H:i:s")
					);
					if ($data['issuance_date']=='') {
						$data['issuance_date'] = null;
					}
					if ($data['deposit_date']=='') {
						$data['deposit_date'] = null;
					}
					$result = $this->STC_Forcasting->forcasting_sales_bill_save($data,1);
				}
			}
		}

		// 발행 완료시 예상매출일 업데이트
		$exception_saledate = $this->input->post('exception_saledate');
		if($exception_saledate != '') {
			$exception_saledate = array(
				'exception_saledate' => $exception_saledate
			);
			$result = $this->STC_Forcasting->forcasting_insert($exception_saledate, 1, $forcasting_seq, 5);
		}

		// 수정자 로그에 남기기
		$log_data = array(
			'forcasting_seq'  => $forcasting_seq,
			'log_type'        => 'modify',
			'write_seq'       => $this->seq,
			'update_date'     => date("Y-m-d H:i:s")
		);
		$this->STC_Forcasting->forcasting_log_insert($log_data);

		if($result) {
			echo "<script>alert('정상적으로 처리되었습니다.');opener.location.reload();self.close();</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	}

	//subproject seq가져오기
	function subProjectAdd()
	{
		$subProjectSeq = $this->input->post('subProjectSeq');

		if ($subProjectSeq == null) {
			redirect('');
		} else {
			// $this->load->Model(array('STC_Maintain', 'STC_Common'));
			$result = $this->STC_Maintain->subProjectAdd($subProjectSeq);
			echo json_encode($result);
		}
	}

	// //연계 프로젝트 sub_project_add update문
	// function sub_project_add_update(){
	// 	$subProjectSeq = $this->input->post('subProjectSeq');
	// 	$seq = $this->input->post('seq');

	// 	if ($subProjectSeq == null or $seq == null) {
	// 		redirect('');
	// 	} else {
	// 		// $this->load->Model(array('STC_Maintain', 'STC_Common'));
	// 		$result = $this->STC_Maintain->sub_project_add_update($seq, $subProjectSeq);
	// 		echo json_encode($result);
	// 	}
	// }

	// //연계 프로젝트 sub_project_remove update문
	// function sub_project_remove_update()
	// {
	// 	$seq = $this->input->post('seq');
	// 	$parent_seq = $this->input->post('parent_seq');
	// 	if ($seq == null) {
	// 		redirect('');
	// 	} else {
	// 		// $this->load->Model(array('STC_Maintain', 'STC_Common'));
	// 		$result = $this->STC_Maintain->sub_project_remove_update($seq,$parent_seq);
	// 		echo json_encode($result);
	// 	}
	// }

	//수주 정보 코멘트 파일업로드
	function forcasting_complete_status_file_upload(){
		$filename = NULL;
		$lcfilename = NULL;

		$csize = $_FILES['file']["size"];
		$cname = $_FILES['file']["name"];

		$ext = substr(strrchr($cname,"."),1);
		$ext = strtolower($ext);

		if ($csize > 0 && $cname) {
			if ($csize > 104857600) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n100MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>"; /* 김수성 수정 2017-01-06 */
				exit;
			}
			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}

			$upload_dir = "/var/www/html/stc/misc/upload/sales/complete_status_comment";

			$conf_file['upload_path'] = $upload_dir;
			if($ext == 'hwp') {
				$conf_file['allowed_types'] = '*';
			} else {
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			}
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );

			if( $this->upload->do_upload('file') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
				$arr = array('file_real_name' => $filename,'file_change_name' => $lcfilename );
				echo json_encode($arr);
			} else {
				echo json_encode("false");
				exit;
			}
		}
	}


	//수주 정보 코멘트 insert
	function forcasting_complete_status_comment_insert(){
		$forcasting_seq = $this->input->post('seq');
		$user_id = $this->id;
		$user_name = $this->name;
		$complete_status = $this->input->post('status');
		$contents = $this->input->post('contents');
		$file_change_name = $this->input->post('file_change_name');
		$file_real_name = $this->input->post('file_real_name');

		$data = array(
			'forcasting_seq' => $forcasting_seq,
			'user_id' => $user_id,
			'user_name' => $user_name,
			'complete_status' => $complete_status,
			'contents' => $contents,
			'file_change_name' => $file_change_name,
			'file_real_name' => $file_real_name,
			'insert_date' =>date("Y-m-d H:i:s")
		);

		// $this->load->Model(array('STC_Forcasting'));
		$result = $this->STC_Forcasting->forcasting_complete_status_comment_insert($data);
		if ($result == false) {
			$arr = array('result' => 'false');
			echo json_encode($arr);
		} else {
			$arr = array('result' => 'true');
			echo json_encode($arr);
		}
	}

	//수주 정보 코멘트 delete
	function forcasting_complete_status_comment_delete(){
		$seq = $this->input->post('seq');
		// $this->load->Model(array('STC_Forcasting'));
		$result = $this->STC_Forcasting->forcasting_complete_status_comment_delete($seq);
		if ($result == false) {
			$arr = array('result' => 'false');
			echo json_encode($arr);
		} else {
			$arr = array('result' => 'true');
			echo json_encode($arr);
		}
	}

// 고객사 이력검색 추가할게야
	function search_history_customer(){
		$customer_seq = $this->input->post('customer_seq');
		$result = $this->STC_Forcasting->search_history_customer($customer_seq);

		echo json_encode($result);
	}


	function select_customer(){
		$keyword = $this->input->post('keyword');

			$result = $this->STC_Forcasting->select_customer($keyword);


		$items = array();
		foreach ($result as $customer) {
			$arr['id'] = $customer->seq;
			$arr['text'] = $customer->company_name;
			array_push($items, $arr);
		}

		echo json_encode($items);
	}


	function forcasting_copy(){
			$seq = $this->input->post('org_seq');
			$copy_project_name = $this->input->post('copy_project_name');
			$forcasting_data = $this->STC_Forcasting->forcasting_view($seq);		//기본
			$data = array(
				'type' => $forcasting_data['type'],
				'customer_seq' => $forcasting_data['customer_seq'],
				'org_seq' => $forcasting_data['seq'],
				'customer_companyname' => $forcasting_data['customer_companyname'],
				'customer_username' => $forcasting_data['customer_username'],
				'customer_tel' => $forcasting_data['customer_tel'],
				'customer_email' => $forcasting_data['customer_email'],
				'project_name' =>$copy_project_name,
				'progress_step' =>$forcasting_data['progress_step'],
				'upper_seq' =>$forcasting_data['upper_seq'],
				'sales_companyname' =>$forcasting_data['sales_companyname'],
				'sales_username' =>$forcasting_data['sales_username'],
				'dept' =>$forcasting_data['dept'],
				'sales_tel' =>$forcasting_data['sales_tel'],
				'sales_email' =>$forcasting_data['sales_email'],
				'cooperation_companyname' =>$forcasting_data['cooperation_companyname'],
				'cooperation_username' =>$forcasting_data['cooperation_username'],
				'cooperation_tel' =>$forcasting_data['cooperation_tel'],
				'cooperation_email' =>$forcasting_data['cooperation_email'],
				'first_saledate' =>$forcasting_data['first_saledate'],
				'exception_saledate' =>$forcasting_data['exception_saledate'],
				'exception_saledate2' =>$forcasting_data['exception_saledate2'],
				'exception_saledate3' =>$forcasting_data['exception_saledate3'],
				'warranty_end_date' =>$forcasting_data['warranty_end_date'],
				'complete_status' =>$forcasting_data['complete_status'],
				'cnum' =>$forcasting_data['cnum'],
				'company_num' =>$forcasting_data['company_num'],
				'write_id' => $this->id,
				'insert_date' => date("Y-m-d H:i:s"),
				'procurement_sales_amount' =>$forcasting_data['procurement_sales_amount'],
				'forcasting_sales' =>$forcasting_data['forcasting_sales'],
				'forcasting_purchase' =>$forcasting_data['forcasting_purchase'],
				'forcasting_profit' =>$forcasting_data['forcasting_profit'],
				'division_month' => $forcasting_data['division_month']
			);
			$copy_seq = $this->STC_Forcasting->forcasting_copy($data, $seq);

			$m_company_data = $this->STC_Forcasting->forcasting_view2($seq);		//주사업자

			for ($i=0; $i < count($m_company_data); $i++) {
				$data = array(
					'forcasting_seq'=> $copy_seq,
					'main_companyname'=> $m_company_data[$i]['main_companyname'],
					'main_username'=> $m_company_data[$i]['main_username'],
					'main_tel'=> $m_company_data[$i]['main_tel'],
					'main_email'=> $m_company_data[$i]['main_email'],
					'insert_date'=> date("Y-m-d H:i:s")
				);
				$this->STC_Forcasting->mcompany_copy($data, "mcompany");
			}
			$product_data = $this->STC_Forcasting->forcasting_view3($seq);		//제품명

			for ($i=0; $i < count($product_data); $i++) {
				$data = array(
					'forcasting_seq'=> $copy_seq,
					'product_code'=> $product_data[$i]['product_code'],
					'product_supplier'=> $product_data[$i]['product_supplier'],
					'product_licence'=> $product_data[$i]['product_licence'],
					'product_serial'=> $product_data[$i]['product_serial'],
					'product_state'=> $product_data[$i]['product_state'],
					'maintain_yn'=> $product_data[$i]['maintain_yn'],
					'maintain_target'=> $product_data[$i]['maintain_target'],
					'product_check_list'=> $product_data[$i]['product_check_list'],
					'maintain_begin'=> $product_data[$i]['maintain_begin'],
					'maintain_expire'=> $product_data[$i]['maintain_expire'],
					'product_version'=> $product_data[$i]['product_version'],
					'product_sales'=> $product_data[$i]['product_sales'],
					'product_purchase'=> $product_data[$i]['product_purchase'],
					'product_profit'=> $product_data[$i]['product_profit'],
					'comment'=> $product_data[$i]['comment'],
					'insert_date'=> date("Y-m-d H:i:s")

				);

				$this->STC_Forcasting->mcompany_copy($data, "product");

			}

			echo "<script>alert('생성되었습니다.');history.go(-1);</script>";
	}



}
?>
