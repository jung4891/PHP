<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends CI_Controller {

	function __construct() {
			parent::__construct();
			$this->load->helper('url');
			$this->load->Model('m_test');
			// $this->load->helper('form');
			// $this->load->Model('m_login');
			//
			// $this->load->library('email');
			// $config['protocol'] = 'smtp';
			// $config['mailpath'] = '/usr/sbin/sendmail';
			// $config['charset'] = 'UTF-8';
			// $config['wordwrap'] = TRUE;
			// $config['newline'] = '\r\n';
			// $config['smtp_host'] = '';
			// $config['smtp_user'] = '';
			// $config['smtp_pass'] = '';
			// $configuration = $this->m_login->get_configuration();
			// if(!empty($configuration)){
			// 	$config['smtp_host'] = $configuration['mail_ip'];
			// 	$config['smtp_user'] = $configuration['mail_address'];
			// 	$config['smtp_pass'] = $configuration['mail_password'];
			// }
			// $config['mailtype'] = 'html';
			//
			// $this->email->initialize($config);
	}

	public function index(){
		// $data['user'] =  $this->m_test->test();
		// $data['group'] = $this->m_test->test2();
		$this->load->view('test/mail_test');
	}


	// 임시 테스트
	// public function mom_list(){
	//
	// 	// 참석자들 id를 이름으로 변환
	// 	$rows =  $this->m_test->get_biz_mom_participant();
	// 	$name_arr = array();
	// 	foreach($rows as $row) {
	// 		$person_ids = $row->participant;
	// 		$person_id_arr = explode(',', $person_ids);
	// 		$tmpArr = array();
	// 		foreach($person_id_arr as $person_id) {
	// 			$dataName = $this->m_test->get_biz_mom_participant_name($person_id);
	// 			array_push($tmpArr, $dataName->user_name);
	// 		}
	// 		$res = implode(",", $tmpArr);
	// 		array_push($name_arr, $res);
	// 	}
	//
	// 	$data['biz_mom'] =  $this->m_test->get_biz_mom();
	// 	$data['name_arr'] = $name_arr;
	// 	$this->load->view('mom_list', $data);
	// }

}
