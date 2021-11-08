<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
  @ 메일박스 구조
    array(5) {
     [0]=>
     string(59) "{192.168.0.100:143/imap/novalidate-cert}&vPSwuA- &07jJwNVo-"  -> 보낸 편지함
     [1]=>
     string(59) "{192.168.0.100:143/imap/novalidate-cert}&ycDGtA- &07jJwNVo-"  -> 지운 편지함
     [2]=>
     string(59) "{192.168.0.100:143/imap/novalidate-cert}&x4TC3A- &vPStANVo-"  -> 임시 보관함
     [3]=>
     string(57) "{192.168.0.100:143/imap/novalidate-cert}&yBXQbA- &ulTHfA-"    -> 정크 메일
     [4]=>
     string(45) "{192.168.0.100:143/imap/novalidate-cert}INBOX"  -> 전체 메일함
    }


  @ 메일박스 url segment
    메일함       Mailbox
    전체메일     inbox
    보낸편지함   sent
    임시보관함   tmp
    스팸메일함   spam
    휴지통       trash

    받은편지함
    별표편지함  Starred
    중요편지함  Important


  @ IMAP(Internet Message Access Protocol) : 메일서버에 접속하여 메일을 가져오기 위한 프로토콜
    PHP에서 imap 기능을 사용하려면 php.ini의 extension=imap 부분 주석 해제해야함 (디폴드가 해제상태)


  @ 접속정보 설정
    $user_id = $this->input->post('inputId');
    $user_pwd = $this->input->post('inputPass');

    100서버
    $mailserver = "192.168.0.100";
    $user_id = "hjsong@durianit.co.kr";
    $user_pwd = "durian12#";

    50서버
    $mailserver = "192.168.0.50";
    $user_id = "test2@durianict.co.kr";
    $user_pwd = "durian12#";

    네이버(테스트용)
    $mailserver = "imap.naver.com";
    $user_id = "go_go_ssing";
    $user_pwd = "gurwndA!23";

    POP3 서버
    $mailbox = @imap_open("{" . $mailserver . ":110/pop3}INBOX", $user_id, $user_pwd);

    IMAP 서버
    $mailbox = @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $user_id, $user_pwd);

    Gmail/NaverMail 서버
    $mailbox = imap_open("{" . $mailserver . ":993/imap/novalidate-cert/ssl}INBOX", $user_id, $user_pwd);
*/

class Mailbox extends CI_Controller {
  function __construct() {
      parent::__construct();
      $this->load->helper(array('url', 'download'));
      $this->load->library('pagination', 'email');
  }

  public function index(){
    $this->mail_list();
  }

  // 메일박스명 IMAP 규격에 맞게 인코딩
  public function box_name_encode($box) {
    switch($box) {
      case "inbox":
        return $box;
      case "sent":
        return mb_convert_encoding('보낸 편지함', 'UTF7-IMAP', 'UTF-8');
      case "tmp":
        return mb_convert_encoding('임시 보관함', 'UTF7-IMAP', 'UTF-8');
      case "spam":
        return mb_convert_encoding('정크 메일', 'UTF7-IMAP', 'UTF-8');
      case "trash":
        return mb_convert_encoding('지운 편지함', 'UTF7-IMAP', 'UTF-8');
    }
  }

  // 전체메일 출력: 메일함에 있는 메일들의 헤더정보(제목, 날짜, 보낸이 등등)를 뷰로 넘김
  // imap_check() : 메일박스의 정보(driver(imap), Mailbox(~~INBOX), Nmsgs)를 객체(object)로 돌려줌
  public function mail_list($box='inbox'){

    // 메일박스명 인코딩 (side페이지에서 post로 전송시 페이징 처리시 애러남. 페이징 링크 생성시에는 post로 보내질 않으니 받질 못함.)
    $mbox = $this->box_name_encode($box);

    // 접속정보 설정
    $mailserver = "192.168.0.100";
    $host = "{" . $mailserver . ":143/imap/novalidate-cert}$mbox";
    $user_id = "hjsong@durianit.co.kr";
    $user_pwd = "durian12#";

    // 메일함 접속
    // imap_open() : 메일서버에 접속하기 위한 함수 (접속에 성공하면 $mailbox에 IMAP 스트림(mailstream)이 할당됨)
    // (@ : 오류메시지를 무효로 처리하여 경고 문구가 표시되지 않게함)
    $mails= @imap_open($host, $user_id, $user_pwd);

    // 메일박스 리스트 (테스트용)
    $mailboxes = imap_list($mails, "{" . $mailserver . ":143}", '*');

    // 뷰로 보낼 내용들 세팅
    $data = array();
    $data['box'] = $box;
    $data['mailboxes'] = $mailboxes;

    if($mails) {
      $mails_cnt = imap_num_msg($mails);  // 메일의 총 개수를 리턴

      // 페이징 처리 (동적)
      $page = ($this->uri->segment(4))? $this->uri->segment(4)+1:1;
      $config = array();
      $config['base_url'] = "/devmail/index.php/Mailbox/mail_list/$box";
      $config['total_rows'] = $mails_cnt;
      $config['per_page'] = 14;
      $data['per_page'] = $config['per_page'];
      $data['page'] = $page;

      // 페이징 처리 (정적)
      $config['num_links'] = 2;
      $config['first_link'] = '<< &nbsp&nbsp';
      $config['first_tag_open'] = '<span style="letter-spacing:0px;">';
      $config['first_tag_close'] = '</span>';
      $config['last_link'] = ' >>';
      $config['last_tag_open'] = '<span style="letter-spacing:0px;">';
      $config['last_tag_close'] = '</span>';
      $config['next_link'] = '';
      $config['prev_link'] = '';
      $config['cur_tag_open'] = '<span style="color:red;">';
      $config['cur_tag_close'] = '</span>';
      $this->pagination->initialize($config);
      $data['links'] = $this->pagination->create_links();

      // imap_sort($mailstream, SORTDATE, 1); 메일을 날짜순으로 내림차순(1)/오름차순(0)하여 정렬된 메일번호가 배열에 담겨 변수에 들어감
      //                                      메일번호가 날짜순으로 되어있지 않기에 설정해줘야함.
      $mailno_arr = imap_sort($mails, SORTDATE, 1);
      $data['mailno_arr'] = $mailno_arr;
      $recent = imap_num_recent($mails);      // 새로운 메일의 개수를 리턴(메일리스트만 봐도 개수 적용 제외됨)

      // 메일박스 head 정보를 배열에 담아 뷰에 보낼 data에 세팅
      // imap_headerinfo : 메일의 제목이나 날짜같은 메일정보를 넣어둔 객체를 돌려줌
      if($mails_cnt >= 1) {
        $data['test_msg'] = "총 메일수: {$mails_cnt}건<br> 새편지: {$recent}건";
        for($i=$page-1; $i<$page+($config['per_page']-1); $i++) {
          if (isset($mailno_arr[$i]))         // 마지막 페이지에서 15개가 안될경우 오류처리
          $data['head'][$mailno_arr[$i]] = imap_headerinfo($mails, $mailno_arr[$i]);
        }
      } else {
        $data['test_msg'] = "메일이 없습니다.";
      }
      imap_close($mails);			              	// IMAP 스트림을 닫음
    } else {
      $data['test_msg'] = '사용자명 또는 패스워드가 틀립니다.';
    }
    $this->load->view('mailbox/mail_list_v', $data);
  } // function(mail_list)


  // 메일 조회 : body부분의 내용을 구조를 분석해 내용(string)을 뷰로 보냄
  public function mail_detail($box, $num){

    $mbox = $this->box_name_encode($box);

    // 메일서버 접속정보 설정
    $mailserver = "192.168.0.100";
    $host = "{" . $mailserver . ":143/imap/novalidate-cert}$mbox";
    $user_id = "hjsong@durianit.co.kr";
    $user_pwd = "durian12#";

    // 메일함 접속
    $mails= @imap_open($host, $user_id, $user_pwd);
    $mails_cnt = imap_num_msg($mails);

    // 내용을 제외한 부분 헤더에서 가져옴
    $data = array();
    $data['mbox'] = $mbox;
    $head = imap_headerinfo($mails, $num);
    $data['date'] = date("Y/m/d H:i", $head->udate);
    $data['from_addr'] = htmlspecialchars(mb_decode_mimeheader($head->fromaddress));
    $data['to_addr'] = htmlspecialchars(mb_decode_mimeheader($head->toaddress));
    $data['title'] = imap_utf8($head->subject);
    $msg_no = trim($head->Msgno);
    $data['msg_no'] = $msg_no;

    // 테스트용
    $struct = imap_fetchstructure($mails, $msg_no);
    $data['struct'] = $struct;
    $body = imap_body($mails, $msg_no);   // 본문 전체
    $data['body'] = $body;

    // 내용 가져오는 부분
    if (isset($struct->parts)) {
      $contents = '';
      $scripts = '';
      $attachments = '';
      $flattenedParts = $this->flattenParts($struct->parts);

      foreach($flattenedParts as $partNumber => $part) {
         switch($part->type) {
           case 0:    // the HTML or plain text part of the email
             if ($part->subtype == "PLAIN") break;

             // HTML
             // charset이 parameters 배열에 [0] or [1]에 있음 그래서 반복문 돌려서 charset 구함.
             if($part->ifparameters) {
               foreach($part->parameters as $object) {
                 if(strtolower($object->attribute) == 'charset') {
                   $charset = $object->value;
                 }
               }
             }
             $message = $this->getPart($mails, $msg_no, $partNumber, $part->encoding, $charset);
             $contents .= $message;
             break;
           case 1:  // multi-part headers, can ignore  (MIXED, ALTERNATIVE, RELATED)
             break;
           case 2:  // attached message headers, can ignore
             break;
           case 3: // application	(attachment)
           case 4: // audio
           case 5: // image		(PNG 인라인출력 or 첨부 모두 type아 5임. 여기서는 삽입된거만 처리 첨부는 아래로 내려감)
             if ($part->ifdisposition == 0 || $part->disposition == "inline") {

               $img_data = imap_fetchbody($mails, $msg_no, $partNumber);
               $img_data = str_replace("\r\n", " ", $img_data);    // 리턴, 줄개행코드 제거. $img_data에 이게 있으면 애러남

               $pattern = '/src="cid:[a-zA-Z0-9.@]+"/';
               preg_match_all($pattern, $contents, $matches);
               $contents = str_replace($matches[0][0], "src='data:image/png;base64,$img_data'", $contents);

               // $filename = getFilenameFromPart($part);
               // $script =
               // "<script language='javascript'>
               //   var imgArr = $('img');
               //   // console.log(filename);
               //   for(var i=0; i<imgArr.length; i++) {
               //     var src = imgArr.eq(i).attr('src');
               //         // var is_target = src.indexOf(filename);
               //         // 네이버에서 보낸 이미지 삽입 메일은 src에 파일명이 없어서 위 라인 주석처리.
               //     var is_target = src.indexOf('cid');
               //         // 대상 문자열(src 값) 안에 특정한 부분 문자열(이미지 파일명)이 있는지 찾을땐
               //         // String 객체의 내장 indexOf를 사용하면 된다.
               //     if(is_target != -1) {
               //       console.log(i);
               //       imgArr.eq(i).attr('src', 'data:image/png;base64,$img_data');
               //       break;
               //     }
               //   }
               // </script>";
               // $contents .= $script;
               break;
             }
           case 6: // video
           case 7: // other (첨부파일)
             $filename = $this-> getFilenameFromPart($part);
             if ($filename)
             $down_link = "&nbsp;<a href=\"javascript:download('{$mbox}', '{$msg_no}',
                     '{$partNumber}', '{$filename}');\">".$filename.'</a><br>';
             $attachments .= $down_link;
           break;
        } // type switch
      } // part foreach
      $data['contents'] = $contents;
      $data['attachments'] = $attachments;
    } else {
      // Microsoft Office Outlook 테스트 메시지	( 2021/09/03 11:04 )는 parts가 없고 html만 있어서 제어문 처리함
      $data = imap_fetchbody($mails, $msg_no, 1);
      $data['contents'] = $data;
    }
    // var_dump($data);
    imap_close($mails);
    $this->load->view('mailbox/mail_detail_v', $data);
  } // mail_detail

  // 메일의 입체구조 -> 평면화
  function flattenParts($messageParts, $flattenedParts = array(), $prefix = '', $index = 1, $fullPrefix = true) {
    foreach($messageParts as $part) {
      $flattenedParts[$prefix.$index] = $part;
      if(isset($part->parts)) {
        if($part->type == 2) {
          $flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix.$index.'.', 0, false);
        }
        elseif($fullPrefix) {
          $flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix.$index.'.');
        }
        else {
          $flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix);
        }
        unset($flattenedParts[$prefix.$index]->parts);
      }
      $index++;
    }
    return $flattenedParts;
  }

  // 주로 HTML 부분 가져오되 인코딩 여부에 따라 디코딩후 내용 가져옴
  function getPart($connection, $messageNumber, $partNumber, $encoding, $charset) {
    $data = imap_fetchbody($connection, $messageNumber, $partNumber);
    $body = imap_body($connection, $messageNumber);
    // echo '<pre>';
    // var_dump($body);
    // echo '<br>여기까지가 body<br>';
    // echo '</pre>';
    switch($encoding) {
      case 0: return $data; // 7BIT
      case 1: return $data; // 8BIT
      case 2: return $data; // BINARY
      case 3: return base64_decode($data); // BASE64
      case 4:
      // echo $data;
        $data = quoted_printable_decode($data);    // QUOTED_PRINTABLE

        if ($charset == 'ks_c_5601-1987')          // else는 charset이 utf-8로 iconv 불필요
          $data = iconv('euc-kr', 'utf-8', $data);
        return $data;

      case 5: return $data; // OTHER
    }
  }

  // 첨부파일 다운로드 링크의 파일명 가져오는 부분
  function getFilenameFromPart($part) {
    $filename = '';
    foreach($part->parameters as $object) {
      if(strtolower($object->attribute) == 'name') {
        $filename = $object->value;
      }
    }
    // if(!$filename && $part->ifparameters) {
    // 	foreach($part->parameters as $object) {
    // 		if(strtolower($object->attribute) == 'name') {
    // 			$filename = $object->value;
    // 		}
    // 	}
    // }
    return imap_utf8($filename);   // 한글일 경우 ?ks_c_5601-1987?여서 디코딩 해야함
  }

  // 첨부파일 클릭시 다운로드 되는 부분
  function download() {
    // 메일서버 접속정보 설정
    $mailserver = "192.168.0.100";
    $host = "{" . $mailserver . ":143/imap/novalidate-cert}" . $_POST['mbox'];
    $user_id = "hjsong@durianit.co.kr";
    $user_pwd = "durian12#";

    // 메일함 접속
    $mails= @imap_open($host, $user_id, $user_pwd);
    $fileSource = imap_fetchbody($mails, $_POST['msg_no'], (string)$_POST['part_no']);
    $fileSource = imap_base64($fileSource);
    force_download($_POST['f_name'], $fileSource);

    imap_close($mails);
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

              flatten시키면
              $flattenedParts = array()
              $flattenedParts[1] = PLAIN
              $flattenedParts[2.1] = HTML
              $flattenedParts[2.2] = PNG
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
        9/2 test (텍스트, 사진, 사진)  - 업무일지 첨부x
        RELATED
         - parts[0]_ALTERNATIVE
           - parts[0]_PLAIN	(전체적인게 다 담김. 근데 디코딩 잘 안됨)
           - parts[1]_HTML (charset: ks_c_5601-1987) (encoding: quoted-printable)
         - parts[1]_PNG	(사진)
         - parts[2]_PNG

          10/18 테스트(서명 + 이미지)
          RELATED
          - parts[0]_ALTERNATIVE
            - parts[0]_PLAIN
            - parts[1]_HTML (charset: ks_c_5601-1987) (encoding(4): quoted-printable)
          - parts[1]_PNG	(사진)
      */
        for($i=1; $i<=count($struct->parts); $i++) {
          $part = $struct->parts[$i-1];
          $mime = $part->subtype;
          $encode = $part->encoding;
          if ($mime == "ALTERNATIVE"){
            for($j=1; $j<=count($part->parts); $j++) {
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

        case "MIXED":
        /*
          10/29 첨부파일 테스트 (only 엑셀파일)  -> 첨부파일은 위에서 처리함
          MIXED
           - parts[0]_ALTERNATIVE
             - parts[0]_PLAIN
             - parts[1]_HTML (tyep(0), encoding(4), charset: ks_c_5601-1987)
           - parts[1]_attachment
               Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
               Content-Transfer-Encoding: base64
               Content-Disposition: attachment;
        */
          for($i=1; $i<=count($struct->parts); $i++) {
            $part = $struct->parts[$i-1];
            $mime = $part->subtype;
            $encode = $part->encoding;
            if ($mime == "ALTERNATIVE"){
              for($j=1; $j<=count($part->parts); $j++) {
                $part_inner = $part->parts[$j-1];
                $mime = $part_inner->subtype;
                $encode = $part_inner->encoding;
                $charset = $part_inner->parameters[0]->value;
                if ($mime == "RELATED") {
                  for($k=1; $k<=count($part_inner->parts); $k++) {
                    $part_inner2 = $part_inner->parts[$k-1];
                    $mime = $part_inner2->subtype;
                    $encode = $part_inner2->encoding;
                    // echo $encode;
                    $charset = $part_inner2->parameters[0]->value;
                    $val = $this->printbody($mailstream, $MSG_NO, $i+(0.1*$j)+(0.01*$k), $encode, $mime, $charset);
                    // echo $val;
                    $tmp .= $val;
                  }
                }
              }
              // $tmp .= $val;
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
        // echo $charset;
        // echo '123';

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
