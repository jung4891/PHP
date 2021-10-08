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



			// IMAP(Internet Message Access Protocol) : 메일서버에 접속하여 메일을 가져오기 위한 프로토콜
			// PHP에서 imap 기능을 사용하려면 php.ini의 extension=imap 부분 주석 해제해야함 (디폴드가 해제상태)

			// $username = "bhkim@durianit.co.kr";
			// $password = "durian12#";
			// $mailserver = "192.168.0.100";

			// $username = "test1@durianict.co.kr";
			// $password = "durian12#";
			// $mailserver = "192.168.0.50";

			// $username = "go_go_ssing";
			// $password = "gurwndA!23";
			// $mailserver = "imap.naver.com";


			// POP3 서버
			//$mailbox = @imap_open("{" . $mailserver . ":110/pop3}INBOX", $username, $password);

			// IMAP 서버
			// $mailbox = @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $username, $password);

			// Gmail/NaverMail 서버
			// $mailbox = imap_open("{" . $mailserver . ":993/imap/novalidate-cert/ssl}INBOX", $username, $password);

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

			$mails= @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $user_id, $user_pass);
			// imap_open() : 메일서버에 접속하기 위한 함수
			//							 (접속에 성공하면 $mailbox에 IMAP 스트림(mailstream)이 할당됨)
			// @ : 오류메시지를 무효로 처리하여 경고 문구가 표시되지 않게함
			// INBOX는 사용자 개인의 메일박스를 의미함

			$data = array();
			if($mails) {
				$mails_info = imap_check($mails);		// imap_check() : 메일박스의 정보를 객체(object)로 돌려줌
				$mails_cnt = $mails_info->Nmsgs;			// 메일박스의 메일 개수를 가져옴
				$data['mails_cnt'] = $mails_cnt;
				if($mails_cnt >= 1) {
					$data['test_msg'] = "메일이 {$mails_cnt}건 있습니다.";
					// var_dump($mails_info->Mailbox) 	// string(77) "{192.168.0.50:143/imap/tls/novalidate-cert/user="test2@durianict.co.kr"}INBOX"
					for($num=1; $num<=$mails_cnt; $num++) {
						$data['head'][$num] = imap_header($mails, $num);
						// imap_header : $num번째 메일의 제목이나 날짜같은 메일정보를 넣어둔 객체를 돌려줌
					}
				} else {
					$data['test_msg'] = "메일이 없습니다.";
				}
				imap_close($mails);		// IMAP 스트림을 닫음
			} else {
				$data['test_msg'] = '사용자명 또는 패스워드가 틀립니다.';
			}

			$this->load->view('mail_list', $data);

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

		}

		// 메일 조회
		public function get_mail($num){

			$username = "test2@durianict.co.kr";
			$password = "durian12#";
			$mailserver = "192.168.0.50";

			$mailbox = @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $username, $password);

			$head = imap_header($mailbox, $num);
			$struct = imap_fetchstructure($mailbox, $num);
			$subtype = $struct->subtype;
			switch($subtype) {
				case "ALTERNATIVE":
				$content = imap_fetchbody($mailbox, $num, 1);
				break;
				case "MIXED":
				$content = imap_fetchbody($mailbox, $num, '1.1');
				break;
			}

			echo "제목 : ".imap_utf8($head->subject)."<br>";
			echo "보낸사람 : ".htmlspecialchars(mb_decode_mimeheader($head->fromaddress))."<br>";
			echo "받는사람 : ".htmlspecialchars(mb_decode_mimeheader($head->toaddress))."<br>";
			echo "내용 : ".imap_base64($content)."<br>";
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
