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

		$this->load->Model(array('test/STC_Board', 'STC_Common', 'ttest/STC_Test'));
	}

	function test_2() {
		$data['serial_num'] = $this->input->get('serial_num');
		$data['user_list'] = $this->STC_Test->user_list($data['serial_num']);

		$this->load->view('ttest/test2', $data);
	}


}
