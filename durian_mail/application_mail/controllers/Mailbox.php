<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
메일함      Mailbox
전체메일    mail_list
받은편지함  Inbox
별표편지함  Starred
중요편지함  Important
보낸편지함  Sent Mail
임시보관함  Drafts
*/

class Mailbox extends CI_Controller {
  function __construct() {
      parent::__construct();
      $this->load->helper('url');

      // IMAP(Internet Message Access Protocol) : 메일서버에 접속하여 메일을 가져오기 위한 프로토콜
      // PHP에서 imap 기능을 사용하려면 php.ini의 extension=imap 부분 주석 해제해야함 (디폴드가 해제상태)

      // $user_id = $this->input->post('inputId');
      // $user_pwd = $this->input->post('inputPass');

      // 100서버
      // $user_id = "hjsong@durianit.co.kr";
      // $user_pwd = "durian12#";
      // $mailserver = "192.168.0.100";

      // 50서버
      // $user_id = "test2@durianict.co.kr";
      // $user_pwd = "durian12#";
      // $mailserver = "192.168.0.50";

      // 네이버(테스트용)
      // $user_id = "go_go_ssing";
      // $user_pwd = "gurwndA!23";
      // $mailserver = "imap.naver.com";

      // POP3 서버
      //$mailbox = @imap_open("{" . $mailserver . ":110/pop3}INBOX", $user_id, $user_pwd);

      // IMAP 서버
      // $mailbox = @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $user_id, $user_pwd);

      // Gmail/NaverMail 서버
      // $mailbox = imap_open("{" . $mailserver . ":993/imap/novalidate-cert/ssl}INBOX", $user_id, $user_pwd);

  }

  public function index(){
    // $this->load->view('test/mail_list');
    $this->mail_list();
  }

  // 전체메일 출력
  public function mail_list(){

    // 메일서버 접속정보 설정
    $user_id = "hjsong@durianit.co.kr";
    $user_pwd = "durian12#";
    $mailserver = "192.168.0.100";

    // 메일함 접속
    // imap_open() : 메일서버에 접속하기 위한 함수
    //							 (접속에 성공하면 $mailbox에 IMAP 스트림(mailstream)이 할당됨)
    // @ : 오류메시지를 무효로 처리하여 경고 문구가 표시되지 않게함
    // INBOX는 사용자 개인의 메일박스를 의미함
    $mails= @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $user_id, $user_pwd);

    // 메일함에 있는 메일들의 헤더정보(제목, 날짜, 보낸이 등등)를 뷰로 넘김
    // imap_check() : 메일박스의 정보를 객체(object)로 돌려줌
    // imap_header() : num번째 메일의 제목이나 날짜같은 메일정보를 넣어둔 객체를 돌려줌
    $data = array();
    if($mails) {
      $mails_info = imap_check($mails);
      $mails_cnt = $mails_info->Nmsgs;			// 메일함의 전체메일 개수를 가져옴
      $data['mails_cnt'] = $mails_cnt;
      if($mails_cnt >= 1) {
        $data['test_msg'] = "메일이 {$mails_cnt}건 있습니다.";
        for($num=1; $num<=$mails_cnt; $num++) {
          $data['head'][$num] = imap_header($mails, $num);
        }
      } else {
        $data['test_msg'] = "메일이 없습니다.";
      }
      imap_close($mails);				// IMAP 스트림을 닫음
    } else {
      $data['test_msg'] = '사용자명 또는 패스워드가 틀립니다.';
    }

    $this->load->view('mailbox/mail_list_v', $data);

    // 메일함 구성 조회부분. 정리ㄱㄱ
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
  public function mail_detail($num){

    $user_id = "hjsong@durianit.co.kr";
    $user_pwd = "durian12#";
    $mailserver = "192.168.0.100";

    $mails = @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $user_id, $user_pwd);

    $data = array();
    $head = imap_header($mails, $num);
    $data['title'] = imap_utf8($head->subject);
    $data['from_addr'] = htmlspecialchars(mb_decode_mimeheader($head->fromaddress));
    $data['to_addr'] = htmlspecialchars(mb_decode_mimeheader($head->toaddress));

    $struct = imap_fetchstructure($mails, $num);
    $subtype = $struct->subtype;
    switch($subtype) {
      case "ALTERNATIVE":
      $content = imap_fetchbody($mails, $num, 1);
      break;
      case "MIXED":
      $content = imap_fetchbody($mails, $num, '1.1');
      break;
    }
    $data['contents'] =imap_base64($content);
    imap_close($mails);
    $this->load->view('mailbox/mail_detail_v', $data);
  }

}




 ?>
