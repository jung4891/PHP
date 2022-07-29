<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Test extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->lv = $this->phpsession->get( 'lv', 'stc' );
		$this->cnum = $this->phpsession->get( 'cnum', 'stc' );

		$this->load->Model(array('test/STC_Board', 'STC_Common', 'test/STC_Test'));
	}

	function test_2() {
		$data['serial_num'] = $this->input->get('serial_num');
		$data['user_list'] = $this->STC_Test->user_list($data['serial_num']);

		$this->load->view('test/test2', $data);
	}

	function serial_search() {
		$data['sales_lv'] = '3';
		$data['cnum'] = $this->cnum;
		$data['serial_num'] = $this->input->get('serial_num');

		if($data['serial_num'] == '') {
			$data['order_completed_count'] = 0;
			$data['maintain_count'] = 0;
			$data['tech_doc_count'] = 0;
		} else {
			$order_completed_data = $this->STC_Test->order_completed_serial($data['serial_num']);
			$data['order_completed_count'] = $order_completed_data['count'];
			$data['order_completed_list'] = $order_completed_data['data'];

			$maintain_list_data = $this->STC_Test->maintain_serial($data['serial_num']);
			$data['maintain_count'] = $maintain_list_data['count'];
			$data['maintain_list'] = $maintain_list_data['data'];

			// $tech_doc_data = $this->STC_Test->tech_doc_serial($data['serial_num']);
			// $data['tech_doc_count'] = $tech_doc_data['count'];
			// $data['tech_doc_list'] = $tech_doc_data['data'];
		}
		$this->load->view('test/serial_search_v', $data);
	}


}
