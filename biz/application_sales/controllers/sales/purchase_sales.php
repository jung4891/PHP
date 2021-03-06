<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Purchase_sales extends CI_Controller {

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
		$this->load->Model(array('sales/STC_Maintain', 'STC_Common','sales/STC_Forcasting','sales/STC_User', 'sales/STC_Purchase_sales'));
	}


function purchase_sales_view() {

		if( $this->id === null ) {
			redirect( 'account' );
		}

		if(isset($_GET['year']) && isset($_GET['month'])) {
			$month = str_pad($_GET['month'], 2, "0", STR_PAD_LEFT);
			$date = $_GET['year']."-".$month;
		}else{
			$date = date("Y-m");
		}

		if(isset($_GET['company'])) {
			$company = $_GET['company'];
		}else{
			$company = "DUIT";
		}
		$data['company'] = $company;

		$data['req_maintain_val'] = array();
		if($company == "DUIT"){
			$company = "'사업1부','사업2부','기술지원부'";
			$data['req_maintain_val'] = $this->STC_Purchase_sales->req_maintain_val($date);
		}else if ($company == "ICT"){
			$company = "'ICT'";
		}else if ($company == "MG"){
			$company = "'MG'";
		}else if ($company == "DBS"){
			$company = "'DBS'";
		}

		// $data['operating_sum'] = $this->STC_Purchase_sales->operating_sum($date, $company); // 운영비
		//
		// $data['maintain_ext'] = $this->STC_Purchase_sales->monthly_sum($date, 'maintain_ext', $company); // 수주완료 내 유지보수

		$data['sum_bill_cnt'][0] = $this->STC_Purchase_sales->sum_bill_cnt('계', $date, $company); // 전자계산서
		$data['sum_bill_cnt'][1] = $this->STC_Purchase_sales->sum_bill_cnt('종', $date, $company); // 종이계산서


		$data['forcasting_val'] = $this->STC_Purchase_sales->purchase_forcasting_bill($date,$company);
		$data['forcasting_val2'] = $this->STC_Purchase_sales->purchase_forcasting_bill2($date,$company);
		$data['distinct_forcasting_seq'] = $this->STC_Purchase_sales->distinct_forcasting_seq($date,$company);

		$data['maintain_val'] = $this->STC_Purchase_sales->purchase_maintain_bill($date,$company);
		$data['distinct_maintain_seq'] = $this->STC_Purchase_sales->distinct_maintain_seq($date,$company);

		$data['procurement_val'] = $this->STC_Purchase_sales->purchase_procurement_bill($date,$company);
		$data['procurement_val2'] = $this->STC_Purchase_sales->purchase_procurement_bill2($date,$company);
		$data['distinct_procurement_seq'] = $this->STC_Purchase_sales->distinct_procurement_seq($date,$company);


		$data['operating_val'] = $this->STC_Purchase_sales->operating_bill($date, $company);

		// 사업부별 합계
		$data['dept_sum'] = $this->STC_Purchase_sales->dept_sum($date);

		$this->load->view('sales/purchase_sales_view', $data);
}


function operating_insert(){


// 새로운거 인서트
if (isset($_POST['new_issuance_month'])) {
	$issuance_date = $this->input->post('new_issuance_month');
	$customer_name = $this->input->post('new_customer');
	$end_user = $this->input->post('new_enduser');
	$item = $this->input->post('new_project_name');
	$issuance_amount = $this->input->post('new_issuance');
	$tax_amount = $this->input->post('new_tax');
	$total_amount = $this->input->post('new_sum');
	$bill_type = $this->input->post('new_tax_type');
	$type = $this->input->post('new_type');
	$dept = $this->input->post('dept');
	$oper_yn = $this->input->post('new_oper_yn');
	$comment = $this->input->post('new_comment');
	// if($company == "DUIT"){
	// 	$dept = "사업1부";
	// }else{
	// 	$dept = $company;
	// }

	for ($i=0; $i < count($total_amount); $i++) {

		$arr = array(
			'type'            => $type[$i],
			'customer_name'   => $customer_name[$i],
			'end_user'        => $end_user[$i],
			'item'            => $item[$i],
			'issuance_amount' => $issuance_amount[$i] == '' ? 0 : str_replace(',','',$issuance_amount[$i]),
			'tax_amount'      => $tax_amount[$i] == '' ? 0 :str_replace(',','',$tax_amount[$i]),
			'total_amount'    => $total_amount[$i] == '' ? 0 :str_replace(',','',$total_amount[$i]),
			'issuance_date'   => $issuance_date[$i],
			'issuance_month'  => substr($issuance_date[$i],0,7),
			'dept'            => $dept,
			'bill_type'       => $bill_type[$i],
			'comment'         => $comment[$i] == '' ? 0 :str_replace(',','',$comment[$i]),
			'oper_yn'         => $oper_yn[$i],
			'write_id'        => $this->id,
			'insert_date'     => date("Y-m-d H:i:s")
		);
		$this->STC_Purchase_sales->operating_insert($arr);
	}


}

// 기조ㅗㄴ꺼 딜라이트
$del_seq = $this->input->post('operating_del_seq');
if ($del_seq != "") {
	$del_arr = explode(",",$del_seq);
	// var_dump($del_arr);
	for ($i=1; $i < count($del_arr); $i++) {
		$seq = $del_arr[$i];
		$this->STC_Purchase_sales->operating_del($seq);
	}
}


// 수정된거 업돠이투
$m_issuance_date = $this->input->post('modify_issuance_month');
$m_customer_name = $this->input->post('modify_customer');
$m_end_user = $this->input->post('modify_enduser');
$m_item = $this->input->post('modify_project_name');
$m_issuance_amount = $this->input->post('modify_issuance');
$m_tax_amount = $this->input->post('modify_tax');
$m_total_amount = $this->input->post('modify_sum');
$m_bill_type = $this->input->post('modify_tax_type');
$m_type = $this->input->post('modify_type');
$m_seq = $this->input->post('modify_operating_seq');
$m_comment = $this->input->post('modify_comment');

if (isset($_POST['modify_issuance_month'])) {
	for ($i=0; $i < count($m_issuance_date); $i++) {
		$update_arr = array(
				'issuance_date'   => $m_issuance_date[$i],
				'issuance_month'  => substr($m_issuance_date[$i],0,7),
				'customer_name'   => $m_customer_name[$i],
				'end_user'        => $m_end_user[$i],
				'item'            => $m_item[$i],
				'issuance_amount' => $m_issuance_amount[$i] == '' ? 0 :str_replace(',','',$m_issuance_amount[$i]),
				'tax_amount'      => $m_tax_amount[$i] == '' ? 0 :str_replace(',','',$m_tax_amount[$i]),
				'total_amount'    => $m_total_amount[$i] == '' ? 0 :str_replace(',','',$m_total_amount[$i]),
				'bill_type'       => $m_bill_type[$i],
				'type'            => $m_type[$i],
				'comment'         => $m_comment[$i] == '' ? 0 :str_replace(',','',$m_comment[$i]),
				'update_id'       => $this->id,
				'update_date'     => date("Y-m-d H:i:s")
		);
	$seq = $m_seq[$i];
	$this->STC_Purchase_sales->operating_update($update_arr, $seq);

	}
}

        echo "<script>alert('처리되었습니다.');history.go(-1);</script>";
}


function quarterly_purchase_sales_view(){
		if( $this->id === null ) {
			redirect( 'account' );
		}

		if(isset($_GET['year'])){
			$year = $_GET['year'];
			$month = $_GET['quarter']*3; //분기에 3을 곱해서 임의의 분기 내 월을 지정
		}else{
			$year = date("Y");
			$month = date("m");
		}

		if(isset($_GET['dept_code'])) {
			$dept_code = $_GET['dept_code'];
		} else {
			$dept_code = 'DUIT';
		}

		//여기서 각각 상품 용역 조달 쿼리문으로 보내자 달별 for문은 model에서 돌려서 배열로 뽑아오자
		$data['product'] = $this->STC_Purchase_sales->quarterly_forcasting($year, $month, $dept_code, 1);
		$data['maintain'] = $this->STC_Purchase_sales->quarterly_maintain($year, $month, $dept_code, 2);
		$data['support'] = $this->STC_Purchase_sales->quarterly_forcasting($year, $month, $dept_code, 4);
		$data['operation'] = $this->STC_Purchase_sales->quarterly_operation($year, $month, $dept_code);

		$this->load->view('sales/purchase_sales_quarterly_view', $data);
}

// 유지보수인지 통합유지보수인지
	function check_maintain() {
		$seq = $this->input->post('seq');

		$data = $this->STC_Purchase_sales->check_maintain($seq);

		echo json_encode($data);
	}

// 메모 저장
	function save_memo() {
		$tex_num = $this->input->post('tex_num');
		$month = $this->input->post('month');
		$memo = $this->input->post('memo');


		$count = $this->STC_Purchase_sales->count_memo($tex_num);

		if($count[0]['cnt'] == 0) {
			// insert
			$data = array(
				'tex_num' => $tex_num,
				'month'   => $month,
				'memo'    => $memo
			);

			$result = $this->STC_Purchase_sales->save_memo($data, $tex_num, 'insert');
		} else {
			// update
			$data = array(
				'month'   => $month,
				'memo'    => $memo
			);

			$result = $this->STC_Purchase_sales->save_memo($data, $tex_num, 'update');
		}

		echo json_encode($result);
	}

	// 메모 삭제
	function del_memo() {
		$tex_num = $this->input->post('tex_num');
		$month = $this->input->post('month');

		$result = $this->STC_Purchase_sales->del_memo($tex_num, $month);

		echo json_encode($result);
	}

	function memo_list() {
		$month = $this->input->post('month');

		$result = $this->STC_Purchase_sales->memo_list($month);

		echo json_encode($result);
	}


}


 ?>
