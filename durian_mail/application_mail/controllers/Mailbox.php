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

/*
  # 메일함 구성부분. 정리ㄱㄱ

  - 원래 있던자료
  $folders = imap_listmailbox($mailbox, "{". $mailserver .":143}", "*");
  $folders = imap_getmailboxes($mailbox, "{". $mailserver .":143}", "*");

  echo ".&ycDGtA- &07jJwNVo-"; (UTF16 문자셋에 base64로 인코딩 되어있음)
  echo imap_utf7_decode(".&ycDGtA- &07jJwNVo-");
  echo mb_convert_encoding(".&ycDGtA- &07jJwNVo-", "UTF-8", "EUC-KR");
  echo mb_convert_encoding(".&ycDGtA- &07jJwNVo-", 'EUC-KR', 'UTF7-IMAP');


  - 정리하던 자료
  $mailboxes = imap_list($mailstream, $host, '*');
  echo '<pre>';
  var_dump($mailboxes);
  echo '</pre>';

  $mailbox = $mailboxes[0];
  $pos = strpos($mailbox, '&');
  $mailbox_name = substr($mailbox, $pos);
  echo mb_convert_encoding('&vPSwuA- &07jJwNVo-', 'UTF-8', 'UTF7-IMAP');

  array(5) {
   [0]=>
   string(59) "{192.168.0.100:143/imap/novalidate-cert}&vPSwuA- &07jJwNVo-"  -> 보낸편지함
   [1]=>
   string(59) "{192.168.0.100:143/imap/novalidate-cert}&ycDGtA- &07jJwNVo-"  -> 지운편지함
   [2]=>
   string(59) "{192.168.0.100:143/imap/novalidate-cert}&x4TC3A- &vPStANVo-"  -> 임시보관함
   [3]=>
   string(57) "{192.168.0.100:143/imap/novalidate-cert}&yBXQbA- &ulTHfA-"    -> 정크메일
   [4]=>
   string(45) "{192.168.0.100:143/imap/novalidate-cert}INBOX"  -> 전체 메일함
  }

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

  // 전체메일 출력: 메일함에 있는 메일들의 헤더정보(제목, 날짜, 보낸이 등등)를 뷰로 넘김
  public function mail_list(){

    /*
    - imap_open() : 메일서버에 접속하기 위한 함수
                   (접속에 성공하면 $mailbox에 IMAP 스트림(mailstream)이 할당됨)
      - @ : 오류메시지를 무효로 처리하여 경고 문구가 표시되지 않게함
    - imap_check() : 메일박스의 정보를 객체(object)로 돌려줌
    - imap_header() : num번째 메일의 제목이나 날짜같은 메일정보를 넣어둔 객체를 돌려줌
    - imap_num_recent($mailbox) : 새로운 메일의 개수를 리턴
    - imap_num_msg($mailbox) : 메일의 총 개수를 리턴
    - $mailno = imap_sort($mailstream, SORTDATE, 1);
      메일을 날짜순으로 내림차순(1)/오름차순(0)하여 정렬된 메일번호가 배열에 담겨 변수에 들어감
    */

    // 메일서버 접속정보 설정
    $user_id = "hjsong@durianit.co.kr";
    $user_pwd = "durian12#";
    $mailserver = "192.168.0.100";

    // 메일함 접속
    $mails= @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $user_id, $user_pwd);

    // 뷰로 보낼 정보들 가져옴
    $data = array();
    if($mails) {
      $mails_info = imap_check($mails);
      $recent = imap_num_recent($mails);
      $mails_cnt = $mails_info->Nmsgs;			// 메일함의 전체메일 개수를 가져옴
      $data['mails_cnt'] = $mails_cnt;
      if($mails_cnt >= 1) {
        $data['test_msg'] = "총 메일수: {$mails_cnt}건<br> 새편지: {$recent}건";
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
  }


  // 메일 조회 : body부분의 내용을 구조를 분석해 내용(string)을 뷰로 보냄
  public function mail_detail($num){

    // 접속정보
    $user_id = "hjsong@durianit.co.kr";
    $user_pwd = "durian12#";
    $mailserver = "192.168.0.100";
    $mails = @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $user_id, $user_pwd);

    // 내용을 제외한 부분 헤더에서 가져옴
    $data = array();
    $head = imap_header($mails, $num);
    $data['date'] = date("Y/m/d H:i", $head->udate);
    $data['from_addr'] = htmlspecialchars(mb_decode_mimeheader($head->fromaddress));
    $data['to_addr'] = htmlspecialchars(mb_decode_mimeheader($head->toaddress));
    $data['title'] = imap_utf8($head->subject);

    // 내용을 구조를 분석해서 가져옴 ( checkstruct() -> (디코딩 필요한경우) printbody() )
    $contents = '';
    $msg_no = trim($head->Msgno);
    $contents .= $this->checkstruct($mails, $msg_no);
    $data['contents'] = $contents;

    // 테스트용
    $struct = imap_fetchstructure($mails, $msg_no);
    $body = imap_body($mails, $msg_no);
    $data['struct'] = $struct;
    $data['body'] = $body;

    imap_close($mails);
    $this->load->view('mailbox/mail_detail_v', $data);
  }


  // 메일의 구조를 분석
  function checkstruct($mailstream, $MSG_NO) {
    /*
      - imap_fetchstructure($mailstream, $MSG_NO) : 메일구조를 객체로 리턴
      - imap_fetchbody($mailstream, $MSG_NO) : 메일내용을 객체로 리턴
      - imap_body($mailstream, $MSG_NO) : 메일내용을 객체로 리턴  ????

     - $type
       - PLAIN : 그냥 텍스트 메일. 이건 그냥 출력만 해주면됨
       - MIXED : 첨부파일이 있는 메일. 이게 가장 복잡. 아래 switch문 참고
       - ALTERNATIVE : HTML 형식으로 메일을 보내면 이게 됩니다. (Outlook)
       - RELATED : HTML 형식으로 보낼때 보면 메일안에 이미지를 삽입해서 보낼 수 있습니다. (outlook 본문에 이미지 삽입)
    */
    $tmp = '';
    $struct = imap_fetchstructure($mailstream, $MSG_NO);
    $type = $struct->subtype;

    switch($type) {
      case "HTML":    // 인코딩이 안되어 있으므로 바로 출력하면 됨.
      /*
        9/3 Microsoft Office Outlook 테스트 메시지 (텍스트)
        HTML (utf-8/x) -> body엔 string만 들어있다. -> fetchbody("1")
      */
        $val = imap_fetchbody($mailstream, $MSG_NO, (string)(1));
        $tmp .= $val;
        break;

      case "ALTERNATIVE":
      /*
        9/3 test (텍스트)
        ALTERNATIVE
        - parts[0]_PLAIN (제목)
        - parts[1]_HTML (내용, utf-8 / base64(encode:3) ) -> fetchbody("2") -> imap_base64

        10/15 메일 테스트 (서명)
        ALTERNATIVE
        - parts[0]_PLAIN (ks_c_5601-1987 / base64)
        - parts[1]_HTML (ks_c_5601-1987 / quoted-printable(encode:4) ) -> fetchbody("2")

        10/20 텍스트테스트 (CK 에디터)
        ALTERNATIVE
        - parts[0]_PLAIN (utf-8 / 8bit(encode:1) )
        - parts[1]_HTML (utf-8 / quoted-printable(encode:4) ) -> fetchbody("2")
      */
        for($i=1; $i<=count($struct->parts); $i++) {
          $part = $struct->parts[$i-1];
          $mime = $part->subtype;
          $encode = $part->encoding;

          if($mime == "HTML") {
            $charset = $part->parameters[0]->value;   // 10/20 CK에디터에서 보낸게 10/15꺼랑 충돌되서 설정
            $val = $this->printbody($mailstream, $MSG_NO, $i, $encode, $mime, $charset);
                                    // mailbox      80     2      3    "HTML"   (9/3 테스트)
                                    // mailbox      93     2      4    "HTML"   (10/15 서명)
            $tmp .= $val;
          } else if ($mime == "RELATED"){
            /*
              10/13 10월 13일 test (텍스트, 사진)
              ALTERNATIVE
              - parts[0]_PLAIN
              - parts[1]_RELATED
                - parts[0]_HTML (utf-8 / base64(encode:3) ) -> fetchbody("2.1") -> imap_base64
                - parts[1]_PNG	( / base64(encode:3) ) -> fetchbody("2.2") -> <img>
            */
            for($j=1; $j<=count($part->parts); $j++) {
              $part_inner = $part->parts[$j-1];
              $mime = $part_inner->subtype;
              $encode = $part_inner->encoding;
              $val = $this->printbody($mailstream, $MSG_NO, $i+(0.1*$j), $encode, $mime);
            }
            $tmp .= $val;
          }
        }
        break;

      case "RELATED":
      /*
        10/18 테스트(서명 + 이미지)
        RELATED
        - parts[0]_ALTERNATIVE
          - parts[0]_PLAIN
          - parts[1]_HTML (charset: ks_c_5601-1987) (encoding(4): quoted-printable)
        - parts[1]_PNG	(사진)
      */
        for($i=1; $i<count($struct->parts); $i++) {
          $part = $struct->parts[$i-1];
          $mime = $part->subtype;
          $encode = $part->encoding;

          if ($mime == "ALTERNATIVE"){
            for($j=1; $j<count($part->parts); $j++) {
              $part_inner = $part->parts[$j-1];
              $mime = $part_inner->subtype;
              $encode = $part_inner->encoding;
              $charset = $part_inner->parameters[0]->value;
              $val = $this->printbody($mailstream, $MSG_NO, $i+(0.1*$j), $encode, $mime, $charset);
            }
            $tmp .= $val;
          } else {    // PNG(사진) 출력
            $val = $this->printbody($mailstream, $MSG_NO, $i, $encode, $mime);
            $tmp .= $val;
          }
        }
        break;
    } // switch($type)

    return $tmp;
  } // func checkstruct


  // 디코딩 해야할 메일내용을 MIME별로 디코딩하여 가져옴
  function printbody($mailstream, $MSG_NO, $numpart, $encode, $mime, $charset='', $file_name='') {
    /*
      디코딩 관련 정리예정
    */
    $tmp = '';
    $val = imap_fetchbody($mailstream, $MSG_NO, (string)($numpart)); // 해당 part의 body 가져옴

    // 인자값으로 넘어온 $encode에 의해 먼저 본문을 decoding 해줌
    switch($encode) {
      case 3:   // base64
        // 이미지파일도 $encode가 3이여서 if문사용함 이미지는 디코딩 안해야 img태그로 출력가능
        if ($mime == 'HTML') {
          $val = imap_base64($val);
        }
        break;
      case 4:   // quoted-print
        $val = quoted_printable_decode($val);
        if ($charset == 'ks_c_5601-1987') {     // else는 charset이 utf-8로 iconv 불필요
          $val = iconv('euc-kr', 'utf-8', $val);
        }
        // $val = imap_base64(imap_binary(imap_qprint($val)));   -> 원래 있던건데 출력안됨.
        break;
    }

    // mime type에 따라 내용 가져옴
    switch($mime) {
      case "HTML":
        $tmp .= $val;
        break;

      // PNG, JPEG등 메일에 삽입된 이미지 출력(디코딩 안하고 바로 출력해야함)
      // base64 png를 디코드해서 출력(오리지날 확장자 상관 없는듯)
      default:
        $tmp .='<img src="data:image/png;base64,' . $val . '" />';
    }
    return $tmp;
  } // func printbody

}


 ?>
