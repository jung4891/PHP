<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Ttest_c extends CI_Controller {

	// var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get('id', 'stc');
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->lv = $this->phpsession->get( 'lv', 'stc' );

		$this->load->Model('ttest/STC_ttest');
	}

  function index() {
		echo 'index 페이지';
  }

	function test_f() {
		$data['serial_num'] = $this->input->get('serial_num');
		$data['user_list'] = $this->STC_ttest->user_list($data['serial_num']);

		$this->load->view('ttest/test_v', $data);

	}


}
