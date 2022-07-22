<?php
header("Content-type: text/html; charset=utf-8");

class Home extends CI_Controller {

	var $site_type = '';
	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->load->helper('alert');
	}

	function index() {
		
		//if($this->phpsession->get( 'id' ) == "")
		//{
			//alert("로그인해주세요.","/dbs/business/login");
		//}

		//print_r($_SESSION);


		redirect( 'account/user' );
	}

	function sessiton_destroy()
	{
		session_destroy();
	}
}
?>