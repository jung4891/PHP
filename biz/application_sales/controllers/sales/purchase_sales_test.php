<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Purchase_sales extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->lv = $this->phpsession->get( 'lv', 'stc');
		$this->cnum = $this->phpsession->get( 'cnum', 'stc' );
		$this->seq = $this->phpsession->get( 'seq', 'stc' );
		$this->load->Model(array('sales/STC_Maintain', 'STC_Common', 'sales/STC_Forcasting', 'sales/STC_User', 'sales/STC_Purchase_sales'));
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

		$data['forcasting_val'] = $this->STC_Purchase_sales->purchase_forcasting_bill($date);
		$data['maintain_val'] = $this->STC_Purchase_sales->purchase_sales_view($date);
		$data['operating_val'] = $this->STC_Purchase_sales->operating_bill($date);

		$this->load->view('sales/purchase_sales_view', $data);
	}

	function operating_insert(){

		$customer_name = $this->input->post('new_customer');
		$end_user = $this->input->post('new_enduser');
		$item = $this->input->post('new_project_name');
		$issuance_amount = $this->input->post('new_issuance');
		$tax_amount = $this->input->post('new_tax');
		$total_amount = $this->input->post('new_sum');
		$issuance_date = $this->input->post('new_issuance_month');
		$bill_type = $this->input->post('new_tax_type');
		$insert_date = array();

		for ($i=0; $i < count($total_amount); $i++) {
			$arr = array(
				'type'            => '002',
				'customer_name'   => $customer_name[$i],
				'end_user'        => $end_user[$i],
				'item'            => $item[$i],
				'issuance_amount' => str_replace(',','',$issuance_amount[$i]),
				'tax_amount'      => str_replace(',','',$tax_amount[$i]),
				'total_amount'    => str_replace(',','',$total_amount[$i]),
				'issuance_date'   => $issuance_date[$i],
				'issuance_month'  => substr($issuance_date[$i],0,7),
				'bill_type'       => $bill_type[$i],
				'write_id'        => $this->id,
				'insert_date'     => date("Y-m-d H:i:s")
			);
			array_push($insert_date, $arr);
		}

		$this->STC_Purchase_sales->operating_insert($insert_date);
	}

	function quaterly_purchase_sales_view(){
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->view('sales/purchase_sales_quarterly_view');
	}

	function quarterly_purchase_sales(){
		if( $this->id === null ) {
			redirect( 'account' );
		}

		if(isset($_POST['year'])){
			$year = $_POST['year'];
			$month = $_POST['quarter']*3 //분기에 3을 곱해서 임의의 분기 내 월을 지정
		}else{
			$year = date("Y");
			$month = date("m");
		}
		$dept_code = $_POST['dept'];

	//여기서 각각 상품 용역 조달 쿼리문으로 보내자 달별 for문은 model에서 돌려서 배열로 뽑아오자
		$data['result1'] = $this->STC_Purchase_sales->quarterly_forcasting($year, $month, $dept_code, 1);
		$data['result2'] = $this->STC_Purchase_sales->quarterly_maintain($year, $month, $dept_code, 2);
		$data['result3'] = $this->STC_Purchase_sales->quarterly_forcasting($year, $month, $dept_code, 4);
		$data['result4'] = $this->STC_Purchase_sales->quarterly_operation($year, $month, $dept_code);
		// $data['product'] = $this->STC_Purchase_sales->quarterly_forcasting($year, $month, $dept_code, 1);
		// $data['service'] = $this->STC_Purchase_sales->quarterly_maintain($year, $month, $dept_code, 2);
		// $data['support'] = $this->STC_Purchase_sales->quarterly_forcasting($year, $month, $dept_code, 4);
		// $data['operation'] = $this->STC_Purchase_sales->quarterly_operation($year, $month, $dept_code);
	  echo json_encode($data);
	}

}
 ?>
