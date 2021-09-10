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
		$this->cnum = $this->phpsession->get( 'cnum', 'stc' );
		$this->seq = $this->phpsession->get( 'seq', 'stc' );
		$this->load->library('user_agent');
		$this->load->Model(array('sales/STC_Maintain', 'STC_Common','sales/STC_Forcasting','sales/STC_User'));
	}

	//포캐스팅 리스트(공통)
	function maintain_list() {
		// $this->output->enable_profiler(TRUE);
		if( $this->id === null ) {
			redirect( 'account' );
		}

		if(isset($_GET['type'])) { // 유지보수인지001  통합유지보수인지 002
			$type = $_GET['type'];
		}else {
			$type = "001";
		}
		$data['type'] = $type;

		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		}else {
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

		if  ( $cur_page <= 0 )
			$cur_page = 1;

		$data['cur_page'] = $cur_page;

		//amount 금액조회
		$amount_list_data = $this->STC_Maintain->maintain_list($search_mode,$type, 'sum', $search_keyword,0, 0, $this->cnum);
		$data['amount_list_val'] = $amount_list_data['data'];
		$user_list_data = $this->STC_Maintain->maintain_list($search_mode,$type,'list',$search_keyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list, $this->cnum, 'list');
		// $data['count'] = $this->STC_Maintain->maintain_list_count($type,$search_keyword,$this->cnum)->ucount;
		$list_count = $this->STC_Maintain->maintain_list($search_mode,$type, 'count', $search_keyword,0, 0, $this->cnum);
		// var_dump($list_count);
		$data['count'] = $list_count['cnt'];
		// echo($data['count']);

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

		$data['product'] = $this->STC_Common->get_product();   //제조사, 품목, 제품명
		$forcasting_list = $this->STC_Forcasting->order_completed_excel_download("","", $this->cnum);
		$data['forcasting_list'] = $forcasting_list['data'];

		if($this->agent->is_mobile()){
			if($type == '001') {
				$data['title'] = '유지보수';
			} else {
				$data['title'] = '통합유지보수';
			}
			$this->load->view( 'sales/maintain_list_mobile', $data );
		} else {
			$this->load->view( 'sales/maintain_list', $data );
		}
	}

	function excel_data(){
		$type = $this->input->post('type');
		$search_keyword = $this->input->post('search_keyword');
		$search_mode = $this->input->post('search_mode');
		$result = $this->STC_Maintain->maintain_excel_download($search_mode,$type,$search_keyword,$this->cnum);
		echo json_encode($result);

	}

	// 점검 정보 불러와서 메일에 첨부
	function check_info_mail($seq){
		$maintain_data = $this->STC_Maintain->maintain_view($seq);
		// var_dump($maintain_data);

		if ($maintain_data['manage_team'] == "1"){
			$manage_team = '기술 1팀';
		} else if ($maintain_data['manage_team'] == "2"){
			$manage_team = "기술 2팀";
		} else if ($maintain_data['manage_team'] == "3"){
			$manage_team = "기술 3팀";
		} else {
			$manage_team = "관리팀 미선택";
		}

		if ($maintain_data['maintain_cycle'] == "0") {
			$maintain_cycle = "장애시";
		} else if ($maintain_data['maintain_cycle'] == "1"){
			$maintain_cycle = "월점검";
		} else if ($maintain_data['maintain_cycle'] == "3"){
			$maintain_cycle = "분기점검";
		} else if ($maintain_data['maintain_cycle'] == "6"){
			$maintain_cycle = "반기점검";
		} else if ($maintain_data['maintain_cycle'] == "7"){
			$maintain_cycle = "미점검";
		} else {
			$maintain_cycle = "점검주기 미선택";
		}

		if ($maintain_data['maintain_type'] == "1"){
			$maintain_type = "방문점검";
		} else if ($maintain_data['maintain_type'] == "2") {
			$maintain_type = "원격점검";
		} else {
			$maintain_type = "점검방법 미선택";
		}

		if ($maintain_data['maintain_result'] == "0") {
			$maintain_result = "미완료";
		} else if ($maintain_data['maintain_result'] == "1"){
			$maintain_result = '완료';
		} else if ($maintain_data['maintain_result'] == "2"){
			$maintain_result = '미해당';
		} else if ($maintain_data['maintain_result'] == "3"){
			$maintain_result = '연기';
		} else if ($maintain_data['maintain_result'] == "4"){
			$maintain_result = '협력사 점검';
		} else if ($maintain_data['maintain_result'] == "9"){
			$maintain_result = '예정';
		} else {
			$maintain_result = "점검여부 미선택";
		}

		$check_info_txt = '<table border=1 cellspacing=0 cellpadding=0>';
		$check_info_txt .= "<tr align='center'><td>관리팀</td><td>{$manage_team}</td><td>점검주기</td><td>{$maintain_cycle}</td><td>점검코멘트</td><td colspan=3>{$maintain_data['maintain_comment']}</td></tr>";
		$check_info_txt .= "<tr align='center'><td>점검일자</td><td>{$maintain_data['maintain_date']}</td><td>점검자</td><td>{$maintain_data['maintain_user']}</td><td>점검방법</td><td>{$maintain_type}</td><td>점검여부</td><td>{$maintain_result}</td></tr>";
		$check_info_txt .= '</table><br><br>';

		return $check_info_txt;
	}

	//유지보수 입력/수정 처리
	function maintain_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->model( 'STC_Maintain' );
		$seq = $this->input->post('seq');


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
				'customer_seq' => $customer_seq,
				'customer_companyname' => $customer_companyname,
				'customer_username' => $customer_username,
				'customer_tel' => $customer_tel,
				'customer_email' => $customer_email,
				'write_id' => $this->id,
				'update_date' => date("Y-m-d H:i:s")
			);
			$result = $this->STC_Maintain->maintain_insert($data,$seq,$data_type);
		}else if($data_type == "2"){//영업 정보
			$project_name = $this->input->post('project_name');
			$progress_step = $this->input->post('progress_step');
			$type = $this->input->post('type');
			$procurement_sales_amount = $this->input->post('procurement_sales_amount');
			$cooperation_companyname = $this->input->post('cooperation_companyname');
			$cooperation_username = $this->input->post('cooperation_username');
			$dept = $this->input->post('dept');
			$infor_comm_corporation = $this->input->post('infor_comm_corporation');

			$data = array(
				'project_name' => $project_name,
				// 'sub_project_add' =>$sub_project_add,
				'progress_step' => $progress_step,
				'type' => $type,
				'procurement_sales_amount' => $procurement_sales_amount,
				'cooperation_companyname' => $cooperation_companyname,
				'cooperation_username' => $cooperation_username,
				'dept' => $dept,
				'infor_comm_corporation' => $infor_comm_corporation,
				'write_id' => $this->id,
				'update_date' => date("Y-m-d H:i:s")
			);
			$result = $this->STC_Maintain->maintain_insert($data,$seq,$data_type);
			if($this->input->post('subProjectRemoveInput') != ""){
				$result = $this->STC_Maintain->sub_project_remove_update($this->input->post('subProjectRemoveInput'),$seq);
			}
			if($this->input->post('subProjectAddInput') != ""){
				$result = $this->STC_Maintain->sub_project_add_update($this->input->post('subProjectAddInput'),$seq);
			}
		}else if($data_type == "3"){//매출처 정보
			$sales_companyname = $this->input->post('sales_companyname');
			$sales_username = $this->input->post('sales_username');
			$sales_tel = $this->input->post('sales_tel');
			$sales_email = $this->input->post('sales_email');
			// $sales_pay_session = $this->input->post('sales_pay_session');
			$data = array(
				'sales_companyname' => $sales_companyname,
				'sales_username' => $sales_username,
				'sales_tel' => $sales_tel,
				'sales_email' => $sales_email,
				// 'sales_pay_session' => $sales_pay_session,
				'write_id' => $this->id,
				'update_date' => date("Y-m-d H:i:s")
			);
			$result = $this->STC_Maintain->maintain_insert($data,$seq,$data_type);
		}else if($data_type == "4"){//매입처 정보
			$insert_main_array = $this->input->post('insert_main_array');
			$update_main_array = $this->input->post('update_main_array');
			$delete_main_array = $this->input->post('delete_main_array');
			$data = array(
				'insert_main_array' => $insert_main_array,
				'update_main_array' => $update_main_array,
				'delete_main_array' => $delete_main_array,
				'write_id' => $this->id,
				'update_date' => date("Y-m-d H:i:s")
			);
			$result = $this->STC_Maintain->maintain_insert($data,$seq,$data_type);
		}else if($data_type == "5"){//제품 정보
			$update_product_array = $this->input->post('update_product_array');
			$insert_product_array = $this->input->post('insert_product_array');
			$delete_product_array = $this->input->post('delete_product_array');
			// $update_sub_product_array = $this->input->post('update_sub_product_array');
			$forcasting_sales = str_replace( ',', '', $this->input->post('forcasting_sales'));
			$forcasting_purchase = str_replace( ',', '', $this->input->post('forcasting_purchase'));
			$forcasting_profit = str_replace( ',', '', $this->input->post('forcasting_profit'));
			$division_month = $this->input->post('division_month');
			$exception_saledate2 = trim($this->input->post('exception_saledate2'));
			$exception_saledate3 = trim($this->input->post('exception_saledate3'));
			// $update_exception_saledate2 = $this->input->post('update_exception_saledate2');
			$update_exception_saledate3 = $this->input->post('update_exception_saledate3');
			$update_produce_saledate= trim($this->input->post('update_produce_saledate'),"/");
			$customer_companyname = $this->input->post('customer_companyname');
			$project_name = $this->input->post('project_name');
			$maintain_cycle = $this->input->post('maintain_cycle');

			$check_info_txt = $this->check_info_mail($seq); // 점검 정보 메일 함수 호출

			if(($update_produce_saledate != "" || $update_exception_saledate3 != "") && $maintain_cycle != "7"){
				$txt = '<table border=1 cellspacing=0 cellpadding=0><tr align="center"><td>고객사</td><td>프로젝트명</td><td>구분</td><td>제품명</td><td>변경항목</td><td>수정전</td><td>수정후</td></tr>';

				$division = '신규';
				// if($update_exception_saledate2 != ""){
				// 	$txt .= "<tr><td>{$customer_companyname}</td><td>{$project_name}</td><td>갱신</td><td></td><td>유지보수 시작일</td><td>{$update_exception_saledate2}</td><td>{$exception_saledate2}</td></tr>";
				// }

				if($update_exception_saledate3 != ""){
					if($update_exception_saledate3 != "new"){
						$division = '갱신';
					}

					$txt .= "<tr><td>{$customer_companyname}</td><td>{$project_name}</td><td>{$division}</td><td></td><td>유지보수 종료일</td><td>";
					if($update_exception_saledate3 == "new"){
						$txt .= "";
					}else{
						$txt .=	$update_exception_saledate3;
					}
					$txt .= "</td><td>{$exception_saledate3}</td></tr>";
				}

				if($update_produce_saledate != ""){
					$each_update_produce_saledate = explode("/",$update_produce_saledate);

					for($i=0; $i<count($each_update_produce_saledate); $i++){
						$produce_info = explode(",",$each_update_produce_saledate[$i]);
						// $type = '';
						// if($produce_info[1] == "begin"){
						// 	$type = "장비유지보수 시작일";
						// }else{
						// 	$type = "장비유지보수 만료일";
						// }
						$type = "장비 유지보수 만료일";

						if($produce_info[2] == ""){
							$division = "신규";
						}else{
							$division = "갱신";
						}

						$txt .= "<tr><td>{$customer_companyname}</td><td>{$project_name}</td><td>{$division}</td><td>{$produce_info[0]}</td><td>{$type}</td><td>{$produce_info[2]}</td><td>{$produce_info[3]}</td></tr>";
					}
				}

				$txt .= "</table>";
				$txt .= "<table border=0 cellspacing=0 cellpadding=0>
				<tr height=30 style='border:none;'><td colspan=9 style='border:none'></td></tr>
				<tr style='border:none;'><td colspan=9 style='border:none;'><img src='http://support.durianit.co.kr/misc/img/mail_img.png' alt='' width=800 style='display:block;width:100%;max-width:100%;'></td></tr>
				</table>";

				$total_txt = "{$this->input->post('customer_companyname')} - {$this->input->post('project_name')} 의 유지보수 기간 수정을 알려드립니다. <br><br>";
				$total_txt .= $check_info_txt.$txt;
				//메일 제목 작성
				$subject = "유지보수 기간 변경 알림입니다.";
				$subject = "=?EUC-KR?B?".base64_encode(iconv("UTF-8","EUC-KR",$subject))."?=\r\n";

				//메일 본문 작성
				$html_code = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
				<html xmlns='http://www.w3.org/1999/xhtml'>
				<head>
					<title>두리안정보기술센터-Tech Center</title>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
				</head>
				<body>
					{$total_txt}
				</body>
				</html>";

				$headers = "From: =?utf-8?B?".base64_encode("support@durianit.co.kr")."?= <support@durianit.co.kr> \n";
				$headers .= 'Cc: sylim@durianit.co.kr' . "\r\n";
				$headers .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$headers .= "Content-Transfer-Encoding: base64\r\n";
				$headers .= 'Message-ID: <>';

				//메일 보내기
				$project_name = $this->input->post('project_name');
				if ($project_name =="서녕test"){
					// echo $html_code;
					$result = mail('hbhwang@durianit.co.kr', $subject, chunk_split(base64_encode($html_code)), $headers);
				} else {
					// echo $html_code;
					$result = mail('tech@durianit.co.kr', $subject, chunk_split(base64_encode($html_code)), $headers);
				}
				$headers = "";
			}

			$data = array(
				'insert_product_array' => $insert_product_array,
				'update_product_array' => $update_product_array,
				'delete_product_array' => $delete_product_array,
				// 'update_sub_product_array' => $update_sub_product_array,
				'forcasting_sales' => $forcasting_sales,
				'forcasting_purchase' => $forcasting_purchase,
				'forcasting_profit' => $forcasting_profit,
				'division_month' => $division_month,
				'exception_saledate2' => $exception_saledate2,
				'exception_saledate3' => $exception_saledate3,
				'write_id' => $this->id,
				'update_date' => date("Y-m-d H:i:s")
			);
			$result = $this->STC_Maintain->maintain_insert($data,$seq,$data_type);
		}else if($data_type == "6"){
			$complete_status = $this->input->post('complete_status');

			$data = array(
				'complete_status' => $complete_status,
				'write_id' => $this->id,
				'update_date' => date("Y-m-d H:i:s")
			);
			$result = $this->STC_Maintain->maintain_insert($data,$seq,$data_type);
		}else if($data_type == "7"){
			$manage_team = $this->input->post('manage_team');
			$maintain_cycle = $this->input->post('maintain_cycle');
			$maintain_date = $this->input->post('maintain_date');
			$maintain_user = $this->input->post('maintain_user');
			$maintain_type = $this->input->post('maintain_type');
			$maintain_result = $this->input->post('maintain_result');
			$maintain_comment = $this->input->post('maintain_comment');

			$maintain_data = $this->STC_Maintain->maintain_view($seq);

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
			$result = $this->STC_Maintain->maintain_insert($data,$seq,$data_type);

			$check_info_txt = $this->check_info_mail($seq); // 점검 정보 메일 함수 호출
			$check_info_txt .= "고객사유지보수종료일 : {$maintain_data['exception_saledate3']}";

			$check_info_txt .= "<table border=0 cellspacing=0 cellpadding=0>
			<tr height=30 style='border:none;'><td colspan=9 style='border:none'></td></tr>
			<tr style='border:none;'><td colspan=9 style='border:none;'><img src='http://support.durianit.co.kr/misc/img/mail_img.png' alt='' width=800 style='display:block;width:100%;max-width:100%;'></td></tr>
			</table>";

			$total_txt = "{$maintain_data['customer_companyname']} - {$maintain_data['project_name']} 의 점검 정보 수정을 알려드립니다. <br><br>";
			$total_txt .= $check_info_txt;
			//메일 제목 작성
			$subject = "유지보수 점검 정보 변경 알림입니다.";
			$subject = "=?EUC-KR?B?".base64_encode(iconv("UTF-8","EUC-KR",$subject))."?=\r\n";

			//메일 본문 작성
			$html_code = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
			<html xmlns='http://www.w3.org/1999/xhtml'>
			<head>
				<title>두리안정보기술센터-Tech Center</title>
				<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
			</head>
			<body>
				{$total_txt}
			</body>
			</html>";

			$headers = "From: =?utf-8?B?".base64_encode("support@durianit.co.kr")."?= <support@durianit.co.kr> \n";
			$headers .= 'Cc: sylim@durianit.co.kr' . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers .= "Content-Transfer-Encoding: base64\r\n";
			$headers .= 'Message-ID: <>';

			//메일 보내기
			$project_name = $maintain_data['project_name'];
			if ($project_name =="서녕test"){
				echo $html_code;
				$result = mail('hbhwang@durianit.co.kr', $subject, chunk_split(base64_encode($html_code)), $headers);
			} else {
				echo $html_code;
				$result = mail('tech@durianit.co.kr', $subject, chunk_split(base64_encode($html_code)), $headers);
			}
			$headers = "";


		}else if ($data_type == "8"){ //세금계산서

			//매출 발행주기
			$data = array(
				'issue_cycle' => $this->input->post('sales_issue_cycle'),
				'sales_pay_session' => $this->input->post('sales_pay_session'),
				'write_id' => $this->id,
				'update_date' => date("Y-m-d H:i:s")
			);
			$result = $this->STC_Maintain->maintain_insert($data,$seq,$data_type);

			//매입 발행주기
			$purchase_issue_cycle = $this->input->post('purchase_issue_cycle');
			$purchase_issue_cycle = explode(",",$purchase_issue_cycle);
			for($i=0; $i<count($purchase_issue_cycle); $i++){
				$cycle = explode("||",$purchase_issue_cycle[$i]);
				$cycle_data = array(
					'seq' => $cycle[0],
					'issue_cycle' => $cycle[1],
					'purchase_pay_session' => $cycle[2],
					'update_date' => date("Y-m-d H:i:s")
				);

				$result = $this->STC_Maintain->maintain_mcompany_insert(1,$cycle_data);
			}


			// $result = true;
			$maintain_seq = $this->input->post('seq');
			$delete_bill_array = $this->input->post( 'delete_bill_array' );
			$sales_total_issuance_amount = $this->input->post( 'sales_total_issuance_amount' );
			$insert_bill_array = $this->input->post('insert_bill_array');
			$insert_bill_array = json_decode($insert_bill_array, true);
			$update_bill_array = $this->input->post('update_bill_array');
			$update_bill_array = json_decode($update_bill_array, true);

			// if($sales_total_issuance_amount == 1){
			// 	$result = $this->STC_Maintain->sales_forcasting_progress_step_change('016',$forcasting_seq); // 1일 경우 progress step 016 으로 수정
			// }else if($sales_total_issuance_amount == 2){
			// 	$result = $this->STC_Maintain->sales_forcasting_progress_step_change('018',$forcasting_seq); // 2일 경우 progress step 016 으로 수정
			// }

			if($delete_bill_array != ""){
				$result = $this->STC_Maintain->maintain_sales_bill_save($delete_bill_array,2);
			}

			if(!empty($insert_bill_array['value'])){
				for($i=0; $i<count($insert_bill_array['value']); $i++){
					$val = explode("||",$insert_bill_array['value'][$i]);
					$data = array(
						'maintain_seq' => $maintain_seq,
						'type' => $val[0],
						'company_name' => $val[1],
						'pay_session' => $val[2],
						'issuance_amount' => str_replace(',','',$val[3]),
						'tax_amount' => str_replace(',','',$val[4]),
						'total_amount' => str_replace(',','',$val[5]),
						'tax_approval_number' => $val[6],
						'issuance_month' => $val[7],
						'issuance_date' => $val[8],
						'issuance_status' => $val[9],
						'deposit_date' => $val[10],
						'deposit_status' => $val[11],
						'issue_schedule_date' => $val[12],
						'write_id' => $this->id,
						'insert_date' => date("Y-m-d H:i:s")
					);

					if ($data['pay_session']=='') {
						$data['pay_session'] = null;
					}
					if ($data['issuance_amount']=='') {
						$data['issuance_amount'] = null;
					}
					if ($data['tax_approval_number']=='') {
						$data['tax_approval_number'] = null;
					}
					if ($data['issuance_month']=='') {
						$data['issuance_month'] = null;
					}
					if ($data['issuance_date']=='') {
						$data['issuance_date'] = null;
					}
					if ($data['deposit_date']=='') {
						$data['deposit_date'] = null;
					}
					if ($data['issue_schedule_date']=='') {
						$data['issue_schedule_date'] = null;
					}
					$result = $this->STC_Maintain->maintain_sales_bill_save($data,0);
				}
			}

			if(!empty($update_bill_array['value'])){
				for($i=0; $i<count($update_bill_array['value']); $i++){
					$val = explode("||",$update_bill_array['value'][$i]);
					$data = array(
						'seq' => $val[0],
						'pay_session' => $val[1],
						'issuance_amount' => str_replace(',','',$val[2]),
						'tax_amount' => str_replace(',','',$val[3]),
						'total_amount' => str_replace(',','',$val[4]),
						'tax_approval_number' => $val[5],
						'issuance_month' => $val[6],
						'issuance_date' => $val[7],
						'issuance_status' => $val[8],
						'deposit_date' => $val[9],
						'deposit_status' => $val[10],
						'issue_schedule_date' => $val[11],
						'write_id' => $this->id,
						'insert_date' => date("Y-m-d H:i:s")
					);

					if ($data['pay_session']=='') {
						$data['pay_session'] = null;
					}
					if ($data['issuance_amount']=='') {
						$data['issuance_amount'] = null;
					}
					if ($data['tax_approval_number']=='') {
						$data['tax_approval_number'] = null;
					}
					if ($data['issuance_month']=='') {
						$data['issuance_month'] = null;
					}
					if ($data['issuance_date']=='') {
						$data['issuance_date'] = null;
					}
					if ($data['deposit_date']=='') {
						$data['deposit_date'] = null;
					}
					if ($data['issue_schedule_date']=='') {
						$data['issue_schedule_date'] = null;
					}
					$result = $this->STC_Maintain->maintain_sales_bill_save($data,1);
				}
			}

		}

		// if($data_type != "8"){
		// 	if ($seq == null) {
		// 		$result = $this->STC_Maintain->maintain_insert($data);
		// 	} else {

		// 	}
		// }

		// 수정자 로그에 남기기
		$log_data = array(
			'maintain_seq'  => $seq,
			'log_type'        => 'modify',
			'write_seq'       => $this->seq,
			'update_date'     => date("Y-m-d H:i:s")
		);
		$this->STC_Maintain->maintain_log_insert($log_data);

		if($result) {
			echo "<script>alert('정상적으로 처리되었습니다.');opener.location.reload();self.close();</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}

	}

	// 유지보수 생성 뷰
	function maintain_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$data['product'] = $this->STC_Common->get_product();   //제조사, 품목, 제품명
		$forcasting_list = $this->STC_Forcasting->order_completed_excel_download("","", $this->cnum);
		$data['forcasting_list'] = $forcasting_list['data'];
		$this->load->view( 'sales/maintain_input', $data);
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
		$data['view_val5'] = $this->STC_Maintain->maintain_view5($seq);		//통합유지보수 제품명
		$data['view_val4'] = $this->STC_Maintain->maintain_view4($seq);		//제품 프로젝트명

		// $data['bill_val'] = $this->STC_Maintain->maintain_sales_bill_view($seq); //계산서
		$data['sales_bill_val'] = $this->STC_Maintain->maintain_sales_bill_view($seq); //계산서(매출)
		$data['purchase_bill_val'] = $this->STC_Maintain->maintain_purchase_bill_view($seq);//계산서(매입)

		$customer_seq = $data['view_val']['customer_seq'];

		$data['sub_project'] = $this->STC_Maintain->sub_project_select($seq, $customer_seq);	//연계 프로젝트 조회
		$data['sub_project_cancel'] = $this->STC_Maintain->sub_project_cancel($seq);  //조회취소 연계 프로젝트 조회
		$data['clist_val'] = $this->STC_Maintain->maintain_comment_list($seq);	//코멘트
		$data['product_company'] = $this->STC_Forcasting->product_company();//제품 전체 제조사 조회
		$data['sales_customer'] = $this->STC_User->sales_customer();
		$data['product'] = $this->STC_Common->get_product();	//제조사, 품목, 제품명
		$data['complete_status_val'] = $this->STC_Maintain->maintain_complete_status_comment_list($seq);	//수주여부 댓글

		$sub_project = explode(",",$data['view_val']['sub_project_add']);
		for($i=0; $i<count($sub_project); $i++){
			// echo "<script>alert('{$sub_project[$i]}')</script>";
			$data['sub_project_add'][$i] = $this->STC_Maintain->subProjectAdd($sub_project[$i]);  // 조회추가한 연계프로젝트 가져오기
		}

		$data['approval_doc'] = $this->STC_Forcasting->approval_doc("maintain_seq=".$seq); //해당하는 기안문 있늬?

		$data['seq'] = $seq;

		$data['modify_name'] = $this->STC_Common->user_info('user_id', $data['view_val']['write_id']);
		$data['writer'] = $this->STC_Maintain->log_data('insert', $seq); // 작성자
		$data['modifier'] = $this->STC_Maintain->log_data('modify', $seq); // 수정자

		$data['memo'] = $this->STC_Maintain->maintain_memo($seq);

		$this->load->view( 'sales/maintain_view', $data );
	}

		// 유지보수 수정 뷰
	function maintain_modify() {
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
		$data['view_val5'] = $this->STC_Maintain->maintain_view5($seq);		//통합유지보수 제품명
		// $data['bill_val'] = $this->STC_Maintain->maintain_sales_bill_view($seq); //계산서
		$data['sales_bill_val'] = $this->STC_Maintain->maintain_sales_bill_view($seq); //계산서(매출)
		$data['purchase_bill_val'] = $this->STC_Maintain->maintain_purchase_bill_view($seq);//계산서(매입)

		// $product_seq = '';
		// for($i=0; $i<count($data['view_val3']); $i++){
		// 	$product_seq .= ",".$data['view_val3'][$i]['seq'];
		// }
		// $product_seq = trim($product_seq,',');
		// $data['view_val4'] = $this->STC_Maintain->maintain_view4($product_seq);	 //제품유지보수 정보

		$customer_seq = $data['view_val']['customer_seq'];

		$data['sub_project'] = $this->STC_Maintain->sub_project_select($seq, $customer_seq);	//연계 프로젝트 조회
		$data['sub_project_cancel'] = $this->STC_Maintain->sub_project_cancel($seq);  //조회취소 연계 프로젝트 조회
		$data['clist_val'] = $this->STC_Maintain->maintain_comment_list($seq);	//코멘트
		$data['product_company'] = $this->STC_Forcasting->product_company();//제품 전체 제조사 조회
		$data['sales_customer'] = $this->STC_User->sales_customer();
		// 담당자 정보 가져오기
		$customer_seq = $data['view_val']['customer_seq'];
		if($customer_seq != ""){

			$data['customer_staff'] = $this->STC_User->sales_customer_staff($customer_seq);
		}

		$data['product'] = $this->STC_Common->get_product();	//제조사, 품목, 제품명
		$data['complete_status_val'] = $this->STC_Forcasting->forcasting_complete_status_comment_list($seq);	//수주여부 댓글

		$sub_project = explode(",",$data['view_val']['sub_project_add']);
		for($i=0; $i<count($sub_project); $i++){
			$data['sub_project_add'][$i] = $this->STC_Maintain->subProjectAdd($sub_project[$i]);  // 조회추가한 연계프로젝트 가져오기
		}

		$data['seq'] = $seq;

		//print_r($data);

		$this->load->view( 'sales/maintain_modify', $data );
	}

	// 포캐스팅 삭제
	function maintain_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		$this->load->model( 'STC_Maintain' );
		$seq = $this->input->post( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_Maintain->maintain_delete($seq);
			$this->STC_Maintain->maintain_log_delete($seq);
		}

		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/sales/maintain/maintain_list'</script>";
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
		$this->load->model( 'STC_Maintain' );
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

	// 유지보수 만료 메일
	function maintain_expiration_mail() {

		// $this->load->Model(array('STC_Maintain'));
		$maintain_expiration = $this->STC_Maintain->maintain_expiration_mail();

		$data['expiration30'] = $maintain_expiration['expiration30']; //만료 16일 ~ 30일
		$data['expiration15'] = $maintain_expiration['expiration15']; //만료 0일 ~ 15일
		$data['after_expiration'] = $maintain_expiration['after_expiration']; //만료 경과 누적
		// $data['after_expiration'] = $maintain_expiration['after_expiration']; //만료 15일 후

		$this->load->view( 'sales/maintain_expiration_mail', $data);
	}

	//연계프로젝트 뒷 수습좀 해봐...
	function hahaha(){
		// $this->load->Model(array('STC_Maintain'));
		$result = $this->STC_Maintain->hahaha();
		echo "<script>alert('{$result}')</script>";
	}

	// 수주여부코멘트 첨부파일 다운로드처리
	function complete_status_comment_download($file_real_name,$file_change_name) {
		$this->load->helper('alert');
		$this->load->helper('download');

		ini_set('memory_limit', '200M'); // 김수성 수정 2017-01-04

		$data = file_get_contents("/var/www/html/stc/misc/upload/sales/complete_status_comment/".$file_change_name);

		$file_real_name = str_replace("&#40;","(",$file_real_name);
		$file_real_name = str_replace("&#41;",")",$file_real_name);

		if (!force_download($file_real_name, $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 수주여부 코멘트 첨부파일 삭제처리
	function maintain_complete_status_filedel($seq, $filelcname){
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model('STC_Maintain');

		$fdata = $this->STC_Maintain->maintain_complete_status_filedel($seq);
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

	//통합 유지보수 리스트
	function integration_maintain_list(){
		if( $this->id === null ) {
			redirect( 'account' );
		}
		// $this->load->Model('STC_Maintain');
		$data['list_val'] = $this->STC_Maintain->integration_maintain_list();   //제조사, 품목, 제품명
		$this->load->view('sales/integration_maintain_list', $data);
	}

	//통합 유지보수 작성
	function integration_maintain_input(){
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Forcasting', 'STC_Common','STC_User','STC_Maintain'));
		$data['product'] = $this->STC_Common->get_product();   //제조사, 품목, 제품명
		// $data['check_list'] = $this->STC_Forcasting->check_list_template(); //점검항목 템플릿
		// $data['sales_customer'] = $this->STC_User->sales_customer();
		// $data['product_company'] = $this->STC_Forcasting->product_company();//제품 전체 제조사 조회
		if(isset($_GET['seq'])){
			$seq = $_GET['seq'];
			$data['view_val'] = $this->STC_Maintain->integration_maintain_view($seq);
			$data['view_val2']= $this->STC_Maintain->integration_maintain_product_view($seq);
		}
		$this->load->view('sales/integration_maintain_input',$data);
	}

	function integration_maintain_input_action(){
		// $this->load->Model(array('STC_Forcasting', 'STC_Common','STC_User','STC_Maintain'));
		$type = $this->input->post('type');
		$project_name = $this->input->post('project_name');
		if($type == 0){
			$data = array(
				'project_name' => $project_name,
				'write_id' => $this->id,
				'insert_date' => date("Y-m-d H:i:s")
			);
			$integration_maintain_seq = $this->STC_Maintain->integration_maintain_insert($type,$data);
			$insert_product_array = $this->input->post('insert_product_array');
			$insert_product_array = explode("||",$insert_product_array);
			for($i=1;$i<count($insert_product_array); $i++){
				$insert_data = explode("~",$insert_product_array[$i]);
				$data = array(
					'integration_maintain_seq' => $integration_maintain_seq,
					'product_name' => $insert_data[0],
					'product_company' => $insert_data[1],
					'product_type' => $insert_data[2],
					'product_licence' => $insert_data[3],
					'product_serial' => $insert_data[4],
					'product_item' => $insert_data[5],
					'insert_date' => date("Y-m-d H:i:s")
				);
				$result = $this->STC_Maintain->integration_maintain_product_insert($type,$data);
			}
			echo json_encode($result);
		}else{
			$data = array(
				'seq' =>$this->input->post('seq'),
				'project_name' => $project_name,
				'write_id' => $this->id,
				'update_date' => date("Y-m-d H:i:s")
			);
			$this->STC_Maintain->integration_maintain_insert($type,$data);

			$delete_product_array = $this->input->post('delete_product_array');
			$delete_product_array = explode(',',$delete_product_array);
			for($i=1; $i<count($delete_product_array); $i++){
				$data = $delete_product_array[$i];
				$result = $this->STC_Maintain->integration_maintain_product_insert(2,$data);
			}

			$update_product_array = $this->input->post('update_product_array');
			$update_product_array = explode("||",$update_product_array);
			for($i=1;$i<count($update_product_array); $i++){
				$update_data = explode("~",$update_product_array[$i]);
				$data = array(
					'seq' => $update_data[6],
					'product_name' => $update_data[0],
					'product_company' => $update_data[1],
					'product_type' => $update_data[2],
					'product_licence' => $update_data[3],
					'product_serial' => $update_data[4],
					'product_item' => $update_data[5],
					'update_date' => date("Y-m-d H:i:s")
				);
				$result = $this->STC_Maintain->integration_maintain_product_insert(1,$data);
			}

			$insert_product_array = $this->input->post('insert_product_array');
			$insert_product_array = explode("||",$insert_product_array);
			for($i=1;$i<count($insert_product_array); $i++){
				$insert_data = explode("~",$insert_product_array[$i]);
				$data = array(
					'integration_maintain_seq' => $this->input->post('seq'),
					'product_name' => $insert_data[0],
					'product_company' => $insert_data[1],
					'product_type' => $insert_data[2],
					'product_licence' => $insert_data[3],
					'product_serial' => $insert_data[4],
					'product_item' => $insert_data[5],
					'insert_date' => date("Y-m-d H:i:s")
				);
				$result = $this->STC_Maintain->integration_maintain_product_insert(0,$data);
			}
			echo json_encode($result);
		}
	}

	//통합 유지보수 뷰
	function integration_maintain_view(){
		if( $this->id === null ) {
			redirect( 'account' );
		}
		$seq = $_GET['seq'];
		// $this->load->Model(array('STC_Maintain'));
		$data['view_val'] = $this->STC_Maintain->integration_maintain_view($seq);
		$data['view_val2']= $this->STC_Maintain->integration_maintain_product_view($seq);
		$this->load->view('sales/integration_maintain_view',$data);
	}

	//통합유지보수 제품들 유지보수에 연결하는고
	function integration_maintain_add(){
		// $this->load->Model(array('STC_Maintain'));
		$maintain_seq = $this->input->post('maintain_seq');
		$product_seq = $this->input->post('product_seq');
		$product_seq = explode(',',$product_seq);
		for($i=0; $i<count($product_seq); $i++){
			$result = $this->STC_Maintain->integration_maintain_add($product_seq[$i],$maintain_seq);
		}
		// 수정자 로그에 남기기
		$log_data = array(
			'maintain_seq'  => $maintain_seq,
			'log_type'      => 'modify',
			'write_seq'     => $this->seq,
			'update_date'   => date("Y-m-d H:i:s")
		);
		$this->STC_Maintain->maintain_log_insert($log_data);

		echo json_encode($result);
	}

	//유지보수 갱신
	function maintain_renewal(){
		// $this->load->Model(array('STC_Maintain'));
		$maintain_seq = $this->input->post('maintain_seq');
		$integration_maintain = $this->input->post('integration_maintain');
		$project_name =$this->input->post('project_name');
		$result = $this->STC_Maintain->maintain_renewal($maintain_seq,$project_name,$integration_maintain);
		echo json_encode($result);
	}

	//유지보수 수주 정보 코멘트 파일업로드
	function maintain_complete_status_file_upload(){
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
			if ($ext == 'hwp') {
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

	//유지보수 수주 정보 코멘트 insert
	function maintain_complete_status_comment_insert(){
		$maintain_seq = $this->input->post('seq');
		$user_id = $this->id;
		$user_name = $this->name;
		$complete_status = $this->input->post('status');
		$contents = $this->input->post('contents');
		$file_change_name = $this->input->post('file_change_name');
		$file_real_name = $this->input->post('file_real_name');

		$data = array(
			'maintain_seq' => $maintain_seq,
			'user_id' => $user_id,
			'user_name' => $user_name,
			'complete_status' => $complete_status,
			'contents' => $contents,
			'file_change_name' => $file_change_name,
			'file_real_name' => $file_real_name,
			'insert_date' =>date("Y-m-d H:i:s")
		);

		$this->load->Model(array('STC_Maintain'));
		$result = $this->STC_Maintain->maintain_complete_status_comment_insert($data);
		if ($result == false) {
			$arr = array('result' => 'false');
			echo json_encode($arr);
		} else {
			$arr = array('result' => 'true');
			echo json_encode($arr);
		}
	}

	//수주 정보 코멘트 delete
	function maintain_complete_status_comment_delete(){
		$seq = $this->input->post('seq');
		$this->load->Model(array('STC_Maintain'));
		$result = $this->STC_Maintain->maintain_complete_status_comment_delete($seq);
		if ($result == false) {
			$arr = array('result' => 'false');
			echo json_encode($arr);
		} else {
			$arr = array('result' => 'true');
			echo json_encode($arr);
		}
	}

	//통합 유지보수 삭제
	function integrationDelete(){
		$seq = $this->input->post('seq');
		$result = $this->STC_Maintain->integrationDelete($seq);
		echo json_encode($result);
	}

	//유지보수 이미 있나 체크
	function maintainDuplicate(){
		$forcasting_seq = $this->input->post('seq');
		$maintain_data = $this->STC_Maintain->select_sales_maintain($forcasting_seq);
		echo json_encode($maintain_data);
	}

	//유지보수 생성
	function forcasting_duplication(){
		$forcasting_seq = $this->input->post('forcasting_seq');
		$project_name = $this->input->post('project_name');
		$progress_step = $this->input->post('progress_step');
		$data = array(
			'forcasting_seq' => $forcasting_seq,
			'project_name' => $project_name,
			'progress_step' => $progress_step,
			'insert_date' =>date("Y-m-d H:i:s")
		);
		$result = $this->STC_Maintain->forcasting_duplication($data);

		// 최초 작성자 로그에 남기기
		$log_data = array(
			'maintain_seq'  => $result,
			'log_type'        => 'insert',
			'write_seq'       => $this->seq,
			'update_date'     => date("Y-m-d H:i:s")
		);
		$this->STC_Maintain->maintain_log_insert($log_data);

		if($result) {
			echo "<script>alert('정상적으로 생성되었습니다. 생성된 유지보수로 이동합니다.');
			location.href='".site_url()."/sales/maintain/maintain_view?seq={$result}&type=001'
			</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	}


	//계산서 미발행  리스트
	function maintain_unissued() {
		if( $this->id === null ) {
			redirect( 'account' );
		}
		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		}else {
			$cur_page = 0;
		}														//	현재 페이지
		if(isset($_GET['lpp'])==false || $_GET['lpp']=='') {
			$no_page_list = 10;										//	한페이지에 나타나는 목록 개수
		} else {
			$no_page_list = (int)$_GET['lpp'];
		}

		$data['lpp'] = $no_page_list;

		if(isset($_GET['searchkeyword'])) {
			$search_keyword = $_GET['searchkeyword'];
		}
		else {
			$today = date("Y-m-d");
			$last = date("t", strtotime($today));
			$first_day = date("Y-m")."-01";
			$last_day = date("Y-m")."-".$last;
			$search_keyword = ",,,,{$first_day},{$last_day}";
		}

		$data['search_keyword'] = $search_keyword;

		if  ( $cur_page <= 0 )
			$cur_page = 1;

		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Maintain->maintain_unissued_list($search_keyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Maintain->maintain_unissued_list_count($search_keyword)->ucount;

		$data['view_val'] = $user_list_data['data'];
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

		if($this->agent->is_mobile()) {
			$data['title'] = '계산서 미발행 목록';
			$this->load->view( 'sales/maintain_unissued_mobile', $data);
		} else {
			$this->load->view( 'sales/maintain_unissued', $data);
		}
	}

	function maintain_unissued_excel() {
		if (isset($_POST['searchkeyword'])) {
			$search_keyword = $_POST['searchkeyword'];
		}

		$user_list_data = $this->STC_Maintain->maintain_unissued_list_excel($search_keyword);

		echo json_encode($user_list_data);
	}

	// 유지보수 메모 저장
	function save_memo() {
		$seq = $this->input->post('seq');
		$maintain_seq = $this->input->post('maintain_seq');
		$memo = $this->input->post('memo');

		if($seq == '') {
			$data = array(
				'maintain_seq' => $maintain_seq,
				'memo'         => $memo,
				'writer'       => $this->id,
				'insert_date'  => date("Y-m-d H:i:s")
			);
			$result = $this->STC_Maintain->save_memo($data, $mode = 1); // 입력
		} else {
			$data = array(
				'seq'          => $seq,
				'maintain_seq' => $maintain_seq,
				'memo'         => $memo,
				'modifier'     => $this->id,
				'modify_date'  => date("Y-m-d H:i:s")
			);
			$result = $this->STC_Maintain->save_memo($data, $mode = 2); // 수정
		}

		echo json_encode($result);
	}



}
?>
