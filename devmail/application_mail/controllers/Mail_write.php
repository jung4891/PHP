<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail_write extends CI_Controller {

	function __construct() {
			parent::__construct();
			$this->load->helper('url');
			// $this->load->helper('form');
			// $this->load->helper('url');
			// $this->load->Model('m_login');
			$this->load->Model('M_addressbook');
			$this->load->library('email', 'imap');

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
			// $this->load->view('read');
		}


		public function mail_test(){
			// $user_id = $this->input->post('inputId');
			// $user_pass = $this->input->post('inputPass');
			$mailserver = "192.168.0.100";
			$user_id = $this->input->post('inputId');
			$user_pass = $this->input->post('inputPass');
			$user_id = "bhkim@durianit.co.kr";
			$mailserver = "192.168.0.50";
      $user_id = "test2@durianict.co.kr";
			$user_pass = "durian12#";
			$mailbox = @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $user_id, $user_pass);
			// $folders = imap_listmailbox($mailbox, "{". $mailserver .":143}", "*");
      $folders = imap_getmailboxes($mailbox, "{". $mailserver .":143}", "*");
      // var_dump($folders);
			if ($folders == false) {
    		echo "no";
			} else {
    		foreach ($folders as $fd) {
			// 		// $a = mb_convert_encoding($fd, 'UTF7-IMAP', mb_detect_encoding($fd, 'UTF-8, ISO-8859-1, ISO-8859-15', true));
			// // 		// $a = mb_convert_encoding($fd, 'ISO-8859-1', 'UTF7-IMAP');
      //   	$a = imap_utf7_decode($fd);
			// // 		// $a = utf8_encode($a);
			// 		echo $a;
			// // 		echo mb_convert_encoding(imap_utf7_decode($fd), "ISO-8859-1", "UTF-8");
      echo mb_convert_encoding($fd->name, 'UTF-8', 'UTF7-IMAP');
    		}
			}
			// echo ".&ycDGtA- &07jJwNVo-";
			// echo imap_utf7_decode(".&ycDGtA- &07jJwNVo-");
			// echo mb_convert_encoding(".&ycDGtA- &07jJwNVo-", "UTF-8", "EUC-KR");
      // $this->load->view('read');
			// echo mb_convert_encoding(".&ycDGtA- &07jJwNVo-", 'EUC-KR', 'UTF7-IMAP');

		}

		public function mail_test2(){

			// $user = $this->M_adressbook->test();
			$data['user'] =  $this->M_adressbook->test();
			$data['group'] = $this->M_adressbook->test2();

			// var_dump($user);
			$this->load->view('read', $data);
		}


		// // 메일 쓰기
		// public function mail_write(){
		// 	$data['title'] = "제목";
		// 	$data['recipient'] = "수신자";
		//
		// 	$this->load->view('write', $data);
		//
		// }

		// 메일쓰기
			function page(){
				// echo Imap::$folder;
				$return_val = $this->email->return_val();
				var_dump($return_val);
				// $this->load->view('mail_write_page');
			}


			function mail_write_action(){
			$recipient=$this->input->post("recipient");
			$contents=$this->input->post("contents"); //뷰에서 ck에디터 textarea의 name값 가져온다!!!!!!!
			$title=$this->input->post("title");
			// $attachment=$this->input->post('attachment'); //뷰에서 첨부파일  name값 가져와
// echo $_FILES['attachment']['name'].'<br><br>';
// var_dump($_FILES['attachment']).'<br><br>';
			if(isset($_FILES['files']['name'])){
				$file_num = count($_FILES['files']['name']);

			}

			// $this->load->library('email');
			//
			// $config['useragent'] = '';
			// $config['protocol'] = 'smtp';
			// $config['smtp_host'] = '192.168.0.50';
			// $config['smtp_user'] = 'test4@durianict.co.kr';
			// $config['smtp_pass'] = 'durian12#';
			// $config['smtp_host'] = '192.168.0.100';
			// $config['smtp_user'] = 'yjjo@durianit.co.kr';
			// $config['smtp_pass'] = 'durian12#';
			// $config['smtp_port'] = 25;
			// $config['smtp_timeout'] = 5;
			// $config['wordwrap'] = TRUE;
			// $config['wrapchars'] = 76;
			// $config['mailtype'] = 'html';
			// $config['charset'] = 'utf-8';
			// $config['validate'] = FALSE;
			// $config['priority'] = 3;
			// $config['crlf'] = "\r\n";
			// $config['newline'] = "\r\n";
			// $config['bcc_batch_mode'] = FALSE;
			// $config['bcc_batch_size'] = 200;
			//
			// $this->email->initialize($config);
			$to_address = $this->input->post('recipient');
			if($to_address){

			}

			$this->email->clear();
			// $this->email->from($config['smtp_user']);
			$recipients = array($to_address);
			$this->email->to(implode(',' ,$recipients));  //$recipient

			$this->email->subject($title);
			           $this->email->message($contents);
			if(isset($file_num)){
					for ($i=0; $i < $file_num; $i++) {
						$att_real = $_FILES['files']['name'][$i];
						$this->email->attach($_FILES['files']['tmp_name'][$i], 'attachment', $att_real);
						// echo $_FILES['attachment']['name'][$i];

					}
				}

								 // $att_real = $_FILES['attachment']['name'];
								 // $this->email->attach($_FILES['attachment']['tmp_name'], 'attachment', $att_real);
								 // echo $_FILES['attachment']['name'];
			           $result = $this->email->send();
								 $this->email->clear(TRUE);
								 if(!$result){
									 $err_msg = $this->email->print_debugger();
									 echo json_encode($err_msg);
								 }else{
									 echo json_encode("success");
								 }


						 // $filename =basename($userfile['name']);  // 파일명만 추출 후 $filename에 저장
					   // $fp = fopen($userfile[tmp_name], "rw");    // 파일 open
					   // $file = fread($fp, $userfile['size']);  // 파일 내용을 읽음
					   // fclose($fp);          // 파일 close

// 			 $mailbody .= "--$boundary\r\n";    // 내용 구분자 추가
// // 여기부터는 어떤 내용이라는 것을 알려줌
// $mailbody.= "Content-Type:".$userfile['type']."; name=\"".$filename."\"\r\n";
// //암호화 방식을 알려줌
// $mailbody .= "Content-Transfer-Encoding:base64\r\n";
// // 첨부파일임을 알려줌
// $mailbody .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
// // 파일 내용을 암호화 하여 추가
//
// echo base64_encode($file);
//
// $mailbody .= base64_encode($file)."\r\n\r\n";

				// $filename = '/c/test1.png';
				// $this->email->attach($filename);
				// foreach ($list as $address)
				// {
        // 	$this->email->to($address);
        // 	$cid = $this->email->attach_cid($filename);
        // 	$this->email->message('<img src='cid:". $cid ."' alt="test1" />');
        // 	$this->email->send();
				// }

			}


			// 보낸 메일함 함수
			function mail_outbox(){
				$this->load->view('mail_outbox');
			}

			// 주소록 그룹버튼(ajax사용, db에서 모든 데이터 가져오기)
			function group_button(){

				$keyword = $this->input->get('g_name');
				$result= $this->M_addressbook->group_button($keyword);
				echo json_encode($result);
			}




			// 내게 쓰기
			function mail_self_write(){
				$this->load->view('mail_self_write');
			}


			// 주소록
			function address(){
				$this->load->view('address');

			}



			// insert
			public function mail_insert(){
				$data = array(
	        'userID' => 'lsa',
	        'name' => '이승아', //머구 어무니 기가쌤
					'birthYear' => '1997',
					'addr' => '제주',
					'mobile1' => '010',
					'mobile2' => '11111111',
					'height' => '163',
					'mDate' => '2021-10-01'
				);

				$result = $this->M_addressbook->insert_test($data);  // 1. insert할 데이터를 담은 변수를 함수안 ()에 넣어야 한다. / 모델에서 결과 값 리턴해준 값이 다시 여기에 담김

				// var_dump($result);

	// if($result){
	// 	echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."'</script>";
	// }
	// else{
	// 	"<script>alert('정상적으로 처리되지못했습니다.');location.href='".site_url()."'</script>";
	// }

			}

			// update
			public function mail_update(){

				  $userID = $this->input->post('userID');

					$data = array(
		        'name' => '박지영' //파주
					);

					$seq = 'pjy';
					if ($seq == null) { // 등록
						 $result = $this->M_addressbook->update_test($data, $mode = 0);
					} else { // 수정
						 $result = $this->M_addressbook->update_test($data, $mode = 1, $seq);
					}

					$result = $this->M_addressbook->update_test($data);  // 1. insert할 데이터를 담은 변수를 함수안 ()에 넣어야 한다. / 모델에서 결과 값 리턴해준 값이 다시 여기에 담김

					// var_dump($result);

		// if($result){
		// 	echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."'</script>";
		// }
		// else{
		// 	"<script>alert('정상적으로 처리되지못했습니다.');location.href='".site_url()."'</script>";
		// }

				}

				// delete
				function mail_delete() {
					 // if( $this->id === null ) {
					 //    redirect( 'account' );
					 // }

					 // $this->load->helper('alert');
					 // $this->load->Model( 'STC_Equipment' );
					 // $userID = $this->input->post( 'userID' );

					$seq = 'jyj';
					 if ($seq != null) {
							$data = $this->M_addressbook->delete_test($seq);
					 }

					 // if ($tdata) {
						// 	echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/equipment/meeting_room_list'</script>";
					 // } else {
						// 	alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
					 // }
				}

				// 화면에 띄우기
				function biz_mom(){

						$keyword = $this->input->get('search');
						if($keyword == ""){
							$result['data'] = $this->M_addressbook->biz_mom(); // 보낼 값이 없으면 넘길게 없어서 모델의 파라미터에 기본값을 설정해줘야한다(기본값 keyword="")
						}else{
							$result['data'] = $this->M_addressbook->biz_mom($keyword); // 값을 보내는  것, 아규먼트

						}

					$this->load->view('biz_mom', $result);
				}
}
