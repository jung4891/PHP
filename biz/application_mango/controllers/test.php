<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Test extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'mango' );
		$this->name = $this->phpsession->get( 'name', 'mango' );
		$this->seq = $this->phpsession->get( 'seq', 'mango' );
		$this->admin = $this->phpsession->get( 'admin', 'mango' );

		$this->load->Model(array('STC_User', 'STC_Common'));
		$this->load->library('simplehtmldom/simple_html_dom');
	}

	function test22() {
		$this->load->view('test');
	}



}
?>
