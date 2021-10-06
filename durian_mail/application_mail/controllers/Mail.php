<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends CI_Controller {

	function __construct() {
			parent::__construct();
			$this->load->helper('url');
			// $this->load->helper('form');
			// $this->load->helper('url');
			// $this->load->Model('m_login');
			$this->load->Model('m_test');
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

			// $username = "bhkim@durianit.co.kr";
			// $password = "durian12#";
			// $mailserver = "192.168.0.100";

			// $username = "test1@durianict.co.kr";
			// $password = "durian12#";
			// $mailserver = "192.168.0.50";

			// POP3 서버
			//$mailbox = @imap_open("{" . $mailserver . ":110/pop3}INBOX", $username, $password);

			// IMAP 서버
			// $mailbox = @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $username, $password);



	}


		public function index(){
			$this->load->view('home');
		}

		// 전체메일
		public function get_all_mails(){

			// $user_id = $this->input->post('inputId');
			// $user_pass = $this->input->post('inputPass');
			// $mailserver = "192.168.0.100";
			// $user_id = $this->input->post('inputId');
			// $user_pass = $this->input->post('inputPass');
			// $user_id = "bhkim@durianit.co.kr";

			$mailserver = "192.168.0.50";
      $user_id = "test2@durianict.co.kr";
			$user_pass = "durian12#";
			$mailbox = @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $user_id, $user_pass);

			$data = array();
			if($mailbox) {
				$mails = imap_check($mailbox);
				$count_mails = $mails->Nmsgs;
				$data['count_mails'] = $count_mails;
				if($count_mails >= 1) {
					$data['test_msg'] = "메일이 {$count_mails}건 있습니다.";
					for($num=1; $num<=$count_mails; $num++) {
						$data['head'][$num] = imap_header($mailbox, $num);
					}
				} else {
					$data['test_msg'] = "메일이 없습니다.";
				}
			} else {
				$data['test_msg'] = '사용자명 또는 패스워드가 틀립니다.';
			}

			// $folders = imap_listmailbox($mailbox, "{". $mailserver .":143}", "*");
			// var_dump($mailbox);
		// echo '<br>';
		// $folders = imap_getmailboxes($mailbox, "{". $mailserver .":143}", "*");
      // var_dump($folders);
		// if ($folders == false) {
  	// 	echo "no";
		// } else {
  	// 	foreach ($folders as $fd) {
			// 		// $a = mb_convert_encoding($fd, 'UTF7-IMAP', mb_detect_encoding($fd, 'UTF-8, ISO-8859-1, ISO-8859-15', true));
			// // 		// $a = mb_convert_encoding($fd, 'ISO-8859-1', 'UTF7-IMAP');
      //   	$a = imap_utf7_decode($fd);
			// // 		// $a = utf8_encode($a);
			// 		echo $a;
			// // 		echo mb_convert_encoding(imap_utf7_decode($fd), "ISO-8859-1", "UTF-8");
    // 		echo mb_convert_encoding($fd->name, 'UTF-8', 'UTF7-IMAP');
  	// 	}
		// }
			// echo ".&ycDGtA- &07jJwNVo-";
			// echo imap_utf7_decode(".&ycDGtA- &07jJwNVo-");
			// echo mb_convert_encoding(".&ycDGtA- &07jJwNVo-", "UTF-8", "EUC-KR");
      // $this->load->view('read');
			// echo mb_convert_encoding(".&ycDGtA- &07jJwNVo-", 'EUC-KR', 'UTF7-IMAP');

			$this->load->view('mail_list', $data);


		}

		public function mail_test2(){

			// $user = $this->m_test->test();
			$data['user'] =  $this->m_test->test();
			$data['group'] = $this->m_test->test2();

			// var_dump($user);
			$this->load->view('read', $data);
		}


	// function insert_car(){
	// 	$carName = $this->input->post('car');
	// 	$carNum = $this->input->post('num');
	//
	// 	$data = array(
	// 	        'type' => $carName,
	// 	        'number' => $carNum
	// 	);
	//
	// 	$result['result'] = $this->m_test->insert_car($data);
	//
	// 	$this->load->view('write', $result);
	// }

	// 임시 테스트
	public function mom_list(){

		// 참석자들 id를 이름으로 변환
		$rows =  $this->m_test->get_biz_mom_participant();
		$name_arr = array();
		foreach($rows as $row) {
			$person_ids = $row->participant;
			$person_id_arr = explode(',', $person_ids);
			$tmpArr = array();
			foreach($person_id_arr as $person_id) {
				$dataName = $this->m_test->get_biz_mom_participant_name($person_id);
				array_push($tmpArr, $dataName->user_name);
			}
			$res = implode(",", $tmpArr);
			array_push($name_arr, $res);
		}

		$data['biz_mom'] =  $this->m_test->get_biz_mom();
		$data['name_arr'] = $name_arr;
		$this->load->view('mom_list', $data);

		// $data['group'] = $this->m_test->test2();
		// $this->load->view('read', $data);
	}

}
