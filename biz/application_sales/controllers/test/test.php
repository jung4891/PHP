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
		$data['serial_num'] = $this->input->get('serial_num');
		$data['list_val'] = $this->STC_Test->order_completed_serial($data['serial_num']);
		$data['cnum'] = $this->cnum;
		// var_dump($data['user_list']);
		$this->load->view('test/serial_search_v', $data);
	}


}
