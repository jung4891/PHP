<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  // @ IMAP(Internet Message Access Protocol) : 메일서버에 접속하여 메일을 가져오기 위한 프로토콜
  // PHP에서 imap 기능을 사용하려면 php.ini의 extension=imap 부분 주석 해제해야함 (디폴드가 해제상태)

  // @ 메일박스 구조
    // array(5) {
    //  [0]=>
    //  string(59) "{192.168.0.100:143/imap/novalidate-cert}&vPSwuA- &07jJwNVo-"  -> 보낸 편지함
    //  [1]=>                                               %26vPSwuA-+%2607jJwNVo-  -> ajax get방식으로 보낼때 이렇게 변환됨
    //  string(59) "{192.168.0.100:143/imap/novalidate-cert}&ycDGtA- &07jJwNVo-"  -> 지운 편지함
    //  [2]=>
    //  string(59) "{192.168.0.100:143/imap/novalidate-cert}&x4TC3A- &vPStANVo-"  -> 임시 보관함
    //  [3]=>
    //  string(57) "{192.168.0.100:143/imap/novalidate-cert}&yBXQbA- &ulTHfA-"    -> 정크 메일
    //  [4]=>
    //  string(45) "{192.168.0.100:143/imap/novalidate-cert}INBOX"  -> 전체 메일함
    // }

  // @ 메일박스 url segment
  //   메일함       Mailbox
  //   전체메일     inbox
  //   보낸편지함   sent
  //   임시보관함   tmp
  //   스팸메일함   spam
  //   휴지통       trash
  //
  //   받은편지함
  //   별표편지함  Starred
  //   중요편지함  Important

  // @ 접속정보 설정
  //   $user_id = $this->input->post('inputId');
  //   $user_pwd = $this->input->post('inputPass');
  //
  //   100서버
  //   $mailserver = "192.168.0.100";
  //   $user_id = "hjsong@durianit.co.kr";
  //   $user_pwd = "durian12#";
  //
  //   50서버
  //   $mailserver = "192.168.0.50";
  //   $user_id = "test2@durianict.co.kr";
  //   $user_pwd = "durian12#";
  //
  //   네이버(테스트용)
  //   $mailserver = "imap.naver.com";
  //   $user_id = "go_go_ssing";
  //   $user_pwd = "gurwndA!23";
  //
  //   POP3 서버
  //   $mailbox = @imap_open("{" . $mailserver . ":110/pop3}INBOX", $user_id, $user_pwd);
  //
  //   IMAP 서버
  //   $mailbox = @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $user_id, $user_pwd);
  //
  //   Gmail/NaverMail 서버
  //   $mailbox = imap_open("{" . $mailserver . ":993/imap/novalidate-cert/ssl}INBOX", $user_id, $user_pwd);

class Mailbox extends CI_Controller {
  function __construct() {
      parent::__construct();
      if(!isset($_SESSION)){
          session_start();
      }
      $this->load->helper(array('url', 'download'));
      $this->load->library('pagination', 'email');
      $this->load->Model('M_account');

      $encryp_password = $this->M_account->mbox_conf($_SESSION['userid']);
			$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
      $key = $this->db->password;
      $key = substr(hash('sha256', $key, true), 0, 32);
			$decrypted = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
      $this->mailserver = "192.168.0.100";
      $this->user_id = $_SESSION["userid"];
      $this->user_pwd = $decrypted;
  }

  public function index(){
    $this->mail_list();
  }

  // 메일서버 접속후 메일박스 접근
  public function connect_mailserver($mbox="") {

    // 접속정보 설정
    $mailserver = $this->mailserver;
    $host = "{" . $mailserver . ":143/imap/novalidate-cert}$mbox";
    $user_id = $this->user_id;
    $user_pwd = $this->user_pwd;

    // 메일함 접속
    // imap_open() : 메일서버에 접속하기 위한 함수 (접속에 성공하면 $mailbox에 IMAP 스트림(mailstream)이 할당됨)
    // (@ : 오류메시지를 무효로 처리하여 경고 문구가 표시되지 않게함)
    return @imap_open($host, $user_id, $user_pwd);
  }

  public function get_folders(){
    $mails= $this->connect_mailserver();
    $mailserver = $this->mailserver;
    $folders = imap_list($mails, "{" . $mailserver . "}", '*');
    $folders = str_replace("{" . $mailserver . "}", "", $folders);
    sort($folders);

    // 인덱스 초기화
    $folders_sorted = array();
    $folders_sorted[0] = "INBOX";
    $folders_sorted[1] = "&vPSwuA- &07jJwNVo-";   // 보낸메일함
    $folders_sorted[2] = "&x4TC3A- &vPStANVo-";   // 임시보관함
    foreach($folders as $f) {
      if($f == "INBOX") continue;
      elseif($f == "&vPSwuA- &07jJwNVo-") continue;
      elseif($f == "&x4TC3A- &vPStANVo-") continue;
      array_push($folders_sorted, $f);
    }
    return $folders_sorted;
  }

  function decode_mailbox(){
    $folders = $this->get_folders();
    $mailbox_tree = array();
    for ($i=0; $i < count($folders); $i++) {
      $id = $folders[$i];
      $exp_folder = explode(".", $folders[$i]);
      $length = count($exp_folder);
      $text = mb_convert_encoding($exp_folder[$length-1], 'UTF-8', 'UTF7-IMAP');
      switch($text) {
        case "INBOX":  $text="전체메일";  break;
        case "보낸 편지함":  $text="보낸메일함";  break;
        case "임시 보관함":  $text="임시보관함";  break;
        case "정크 메일":  $text="스팸메일함";  break;
        case "지운 편지함":  $text="휴지통";  break;
      }

      $substr_count = substr_count($folders[$i], ".");
      if($substr_count > 1){
        $parent_folder = implode(".", explode(".", $folders[$i], -1));
      }elseif ($substr_count == 1) {
        $parent_folder = $exp_folder[0];
      }else{
        $parent_folder = "#";
      }
      $tree = array(
        // "name" => $folders[$i],
        "id" => $id,
        "parent" => $parent_folder,
        "text" => $text
      );
      array_push($mailbox_tree, $tree);
    }
    echo json_encode($mailbox_tree);
  }


  // 전체메일 출력: 메일함에 있는 메일들의 헤더정보(제목, 날짜, 보낸이 등등)를 뷰로 넘김
  // imap_check() : 메일박스의 정보(driver(imap), Mailbox(~~INBOX), Nmsgs)를 객체(object)로 돌려줌
  public function mail_list(){

    // echo imap_base64("송혁중");
    // echo iconv('utf-8', 'euc-kr', "테스트");

    $data = array();

    // 메일함 이동 selectbox 내용
    $boxname_arr = array();
    $folders = $this->get_folders();
    for ($i=0; $i < count($folders); $i++) {
      $exp_folder = explode(".", $folders[$i]);
      $length = count($exp_folder);
      $text = mb_convert_encoding($exp_folder[$length-1], 'UTF-8', 'UTF7-IMAP');
      switch($text) {
        case "INBOX":  $text="전체메일";  break;
        case "보낸 편지함":  $text="보낸메일함";  break;
        case "임시 보관함":  $text="임시보관함";  break;
        case "정크 메일":  $text="스팸메일함";  break;
        case "지운 편지함":  $text="휴지통";  break;
      }
      $boxname_arr[$text] = $folders[$i];
    }
    $data['boxname_arr'] = $boxname_arr;

    // 메일 리스트 가져오기
    $mbox = $this->input->get("boxname");
    $mails= $this->connect_mailserver($mbox);
    $data['mbox'] = $mbox;

    if($mails) {
      $mails_cnt = imap_num_msg($mails);    // 메일의 총 개수를 리턴
      // $recent = imap_num_recent($mails);    // 새로운 메일의 개수를 리턴(메일리스트만 봐도 개수 적용 제외됨)

      // imap_sort($mailstream, SORTDATE, 1); 메일을 날짜순으로 내림차순(1)/오름차순(0)하여 정렬된 메일번호가 배열에 담겨 변수에 들어감
      //                                      메일번호가 날짜순으로 되어있지 않기에 설정해줘야함.
      // $mailno_arr = imap_sort($mails, SORTDATE, 1);
      if($this->input->get('type') == "attachments") {
        $mailno_arr = imap_sort($mails, SORTDATE, 1);
        $mailno_attached_arr = array();
        foreach($mailno_arr as $no) {
          if(imap_headerinfo($mails, $no)->Size > 30000)
            array_push($mailno_attached_arr, $no);
        }
        $mailno_arr = $mailno_attached_arr;
        $mails_cnt = count($mailno_arr);
        $data['type'] = "attachments";
      }else if($this->input->get('type') == "unseen") {
        $mailno_arr = imap_sort($mails, SORTDATE, 1);
        $mailno_unseen_arr = array();
        foreach($mailno_arr as $no) {
          if(imap_headerinfo($mails, $no)->Unseen == "U")
            array_push($mailno_unseen_arr, $no);
        }
        $mailno_arr = $mailno_unseen_arr;
        $mails_cnt = count($mailno_arr);
        $data['type'] = "unseen";
      }else if($this->input->get('type') == "important") {
        $mailno_arr = imap_sort($mails, SORTDATE, 1);
        $mailno_unseen_arr = array();
        foreach($mailno_arr as $no) {
          if(imap_headerinfo($mails, $no)->Flagged == "F")
            array_push($mailno_unseen_arr, $no);
        }
        $mailno_arr = $mailno_unseen_arr;
        $mails_cnt = count($mailno_arr);
        $data['type'] = "important";
      }else if($this->input->get('type') == "search") {
        $subject_target = $this->input->get("subject");
        $mailno_arr = imap_sort($mails, SORTDATE, 1);

        if($mailno_arr) {   // 검색결과 없으면 false반환되어 count(false)로 애러방지
          $mailno_arr_target = array();
          foreach($mailno_arr as $index => $no) {
            $subject= imap_utf8(imap_headerinfo($mails, $no)->subject);
            if(strpos($subject, $subject_target))  array_push($mailno_arr_target, $no);
          }
          $mailno_arr = $mailno_arr_target;
          $mails_cnt = count($mailno_arr);
          // echo $mails_cnt;
        }
        /*
        imap_search로 제목 검색하는부분 일단 보류....

        $subject = iconv('utf-8', 'euc-kr', $subject);
        $mailno_arr = imap_search($mails, "SUBJECT \"$subject\"");
        $mailno_arr = imap_search($mails, "SUBJECT $subject", SE_FREE, "euc-kr");
        $mailno_arr = array_reverse($mailno_arr);   // 날짜 최신순으로

        검색 테스트2 (이놈이 검색이 안됨. outlook에서 보낸것들.)
        =?ks_c_5601-1987?B?sMu79iDF1726xq4y?=		iconv(utf8-> euc-kr): Ʈ ??

        검색 테스트1 (일일업무일지, 이건됨 브라우저 메일홈피에서 보낸것들)
        =?UTF-8?Q?=EC=9D=B8=ED=84=B4=EC=82=AC=EC=9B=90=20=EC=86=A1?= =?UTF-8?Q?=ED=98=81=EC=A4=91=20=EC=9D=BC=EC=9D=BC=EC=97=85=EB=AC=B4?= =?UTF-8?Q?=EC=9D=BC=EC=A7=80=20=EC=9E=85=EB=8B=88=EB=8B=A4=2E=28=EA=B2=80?= =?UTF-8?Q?=EC=83=89=20=ED=85=8C=EC=8A=A4=ED=8A=B8=31=29?=
        */
        $data['type'] = "search";
        $data['subject'] = $subject_target;
      }else {
        $mailno_arr = imap_sort($mails, SORTDATE, 1);
      }
      $data['mailno_arr'] = $mailno_arr;

      // php 페이징
      $curpage = $this->input->get("curpage");
      $mail_cnt_show = $this->input->get("mail_cnt_show");

      $curpage = ($curpage == "")? 1:$curpage;  // 1페이지라 가정
      $total_rows = $mails_cnt;      // 총 16개 데이터라 가정.
      $per_page = ($mail_cnt_show == "")? 15:$mail_cnt_show; // 한 페이지에 보여줄 데이터 갯수
      $pagingNum_cnt = 5;            // 페이징 블록에서의 페이징 번호 갯수

      $paging_block = ceil($curpage/$pagingNum_cnt);   // 1/5 -> 1번째 페이징 블록
      $block_start = (($paging_block - 1) * $pagingNum_cnt) + 1;   // (1-1)*5 + 1 -> 1
      $block_end = $block_start + $pagingNum_cnt - 1;  // 1 + 5 -1 -> 5 (1~5)

      $total_pages = ceil($total_rows/$per_page);    // 16/15 -> 총 2페이지
      if($block_end > $total_pages)  $block_end = $total_pages;   // 페이징 블록을 1~2로 수정
      $total_blocks = ceil($total_pages/$pagingNum_cnt);    // 2/5 -> 페이징 블록 총 1개
      $start_row = ($curpage-1) * $per_page;    // (1-1)*15 -> 0번째 데이터부터 출력.
                                                // (만일 2페이지일경우 16번째(인덱스15) 데이터 출력)
      $data['per_page'] = $per_page;
      $data['start_row'] = $start_row;
      $data['curpage'] = $curpage;

      $paging = '';
      if($curpage == 1) {
        $paging .= '<a href="" class="link" style="color: silver"> << </a>';
      }else {
        $paging .= "<a href='javascript:go_page(1);' class='link' style='font-weight: 700'> << </a>";
      }
      if($paging_block == 1) {
        $paging .= '<a href="" class="link" style="color: silver"> &nbsp; < &nbsp;</a>';
      }else {
        $p = (($paging_block-2)*$pagingNum_cnt) + 1;
        $paging .= "<a href='javascript:go_page($p);' class='link' style='font-weight: 700'> &nbsp; < &nbsp;</a>";
      }
      for($i=$block_start; $i<=$block_end; $i++) {
        if($curpage == $i) {
          $paging .= "<a href='' style='color:red'> &nbsp;[$i] </a>";
        }else {
          $paging .= "<a href='javascript:go_page($i);' class='link' style=''> &nbsp;[$i] </a>";
        }
      }
      if($paging_block == $total_blocks) {
        $paging .= '<a href="" class="link" style="color: silver"> &nbsp;&nbsp; > </a>';
      }else {
        $p = ($paging_block*$pagingNum_cnt) + 1;
        $paging .= "<a href='javascript:go_page($p);' class='link' style='font-weight: 700'> &nbsp;&nbsp; > </a>";
      }
      if($curpage == $total_pages) {
        $paging .= '<a href="" class="link" style="color: silver"> &nbsp; >> </a>';
      }else {
        $paging .= "<a href='javascript:go_page($total_pages);' class='link' style='font-weight: 700;'> &nbsp; >> </a>";
      }
      $paging .= "<style> .link {color:black; } </style>";
      $data['links'] = $paging;

      // 메일박스 head 정보를 배열에 담아 뷰에 보낼 data에 세팅
      // imap_headerinfo : 메일의 제목이나 날짜같은 메일정보를 넣어둔 객체를 돌려줌
      if($mails_cnt >= 1) {
        // $data['test_msg'] = "총 메일수: {$mails_cnt}건<br> 새편지: {$recent}건";
        for($i=$start_row; $i<$start_row+$per_page; $i++) {
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

  // flag 지정 (중요메일)
  public function set_flag() {
    $mbox = $this->input->get("boxname");
    $mailno = $this->input->get("mailno");
    $state = $this->input->get("state");
    $mails= $this->connect_mailserver($mbox);

    if($state == "emptyStar") {
      imap_setflag_full($mails, $mailno, "\\Flagged");
    } else {
      imap_clearflag_full($mails, $mailno, "\\Flagged");
    }
  }


  // 메일 조회 : body부분의 내용을 구조를 분석해 내용(string)을 뷰로 보냄
  public function mail_detail(){

    $mbox = $this->input->get("boxname");
    $mailno = $this->input->get("mailno");
    $mails= $this->connect_mailserver($mbox);
    $mails_cnt = imap_num_msg($mails);

    // 내용을 제외한 부분 헤더에서 가져옴
    $data = array();
    $data['mbox'] = $mbox;
    $head = imap_headerinfo($mails, $mailno);
    $data['date'] = date("Y/m/d H:i", $head->udate);
    $data['from_addr'] = imap_utf8($head->fromaddress);
    $data['to_addr'] = imap_utf8($head->toaddress);
    // $data['title'] = $head->subject;
    $data['title'] = imap_utf8($head->subject);
    $msg_no = trim($head->Msgno);
    $data['msg_no'] = $msg_no;

    // 테스트용
    /*
    - imap_fetchstructure($mailstream, $MSG_NO) : 메일구조를 객체로 리턴
    - imap_fetchbody($mailstream, $MSG_NO) : 메일내용 전체(HTML, 삽입이미지, 첨푸파일 등)를 객체로 리턴
    - imap_body($mailstream, $MSG_NO) : 메일내용을 특정부분을 객체로 리턴
    */
    $struct = imap_fetchstructure($mails, $msg_no);
    $data['struct'] = $struct;
    $body = imap_body($mails, $msg_no);
    $data['body'] = $body;

    // 내용 가져오는 부분
    $contents = '';       // 내용 부분 담을 변수
    $attachments = '';    // 첨부파일 부분 담을 변수
    if (isset($struct->parts)) {
      $flattenedParts = $this->flattenParts($struct->parts);  // 메일구조 평면화

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
             // 리턴, 줄개행코드 제거. $img_data에 이게 있으면 애러발생함(HTML로 보내질때)
             $img_data = str_replace("\r\n", " ", $img_data);

             // contents의 기존 src 속성값을 이미지 데이터로 교체후 contents 변수에 다시 넣어줌
             // 삽입된 이미지의 경우 디코딩 안하고 fetchbody으로 추출한 내용을 src에 아래처럼 넣어줌
             $pattern = '/src="cid:[a-zA-Z0-9.@]+"/';
             preg_match_all($pattern, $contents, $matches);
             $contents = str_replace($matches[0][0], "src='data:image/png;base64,$img_data'", $contents);
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
       } // switch (type)
     } // foreach (part)
      $data['contents'] = $contents;
      $data['attachments'] = $attachments;
    } else {
      // Microsoft Office Outlook 테스트 메시지	( 2021/09/03 11:04 )는
      // parts가 없고 html만 있어서 제어문 처리함
      // + [전자결재]결재문서 최종 승인 메일은 역시 parts가 없는데 base64로 디코딩됨
      $contents = $this->getPart($mails, $msg_no, 1, $struct->encoding, $struct->parameters[0]->value);
      $data['contents'] = $contents;
      $data['attachments'] = $attachments;
    }
    imap_close($mails);
    $this->load->view('mailbox/mail_detail_v', $data);
  } // mail_detail

  // 메일함 이동 (휴지통으로 이동 포함)
  function mail_move() {
    $mbox = $this->input->post("mbox");
    $mails= $this->connect_mailserver($mbox);
    $to_box = $this->input->post("to_box");

    $arr = $this->input->post("mail_arr");
    $arr_str = implode(',', $arr);
    $res = imap_mail_move($mails, $arr_str, $to_box);
    // imap_expunge() : Deletes all the messages marked for deletion
    //                  by imap_delete(), imap_mail_move(), or imap_setflag_full().
    // imap_expunge() 안해주면 삭제버튼 클릭시 이동은 되는데 본 메일박스에 남아있음
    imap_expunge($mails);
    imap_close($mails);
    echo $res;
  }

  // 메일 완전삭제
  function mail_delete() {
    $mbox = $this->input->post("mbox");
    $mails= $this->connect_mailserver($mbox);
    $arr = $_POST['mail_arr'];
    $arr_str = implode(',', $arr);
    $res = imap_delete($mails, $arr_str);
    imap_expunge($mails);
    imap_close($mails);
    echo $res;
  }
  // 주로 HTML 부분 가져오되 인코딩 여부에 따라 디코딩후 내용 가져옴
  function getPart($connection, $messageNumber, $partNumber, $encoding, $charset) {
    $data = imap_fetchbody($connection, $messageNumber, $partNumber);
    $body = imap_body($connection, $messageNumber);

    switch($encoding) {
      case 0: return $data; // 7BIT
      case 1: return $data; // 8BIT
      case 2: return $data; // BINARY
      case 3: return base64_decode($data); // BASE64
      case 4:
        $data = quoted_printable_decode($data);    // QUOTED_PRINTABLE (업무일지 서식)
        if ($charset == 'ks_c_5601-1987')          // else는 charset이 utf-8로 iconv 불필요
          $data = iconv('euc-kr', 'utf-8', $data);  // charset 변경
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
    return imap_utf8($filename);   // 한글일 경우 ?ks_c_5601-1987?여서 디코딩 해야함
  }

  // 첨부파일 클릭시 다운로드 되는 부분
  function download() {
    $mails = $this->connect_mailserver($_POST['box']);
    $fileSource = imap_fetchbody($mails, $_POST['msg_no'], $_POST['part_no']);
    $fileSource = imap_base64($fileSource);
    force_download($_POST['f_name'], $fileSource);
    imap_close($mails);
  }

  // 메일의 입체구조 -> 평면화
  /*
     $type
     - PLAIN : 그냥 텍스트 메일. 이건 그냥 출력만 해주면됨
     - MIXED : 첨부파일이 있는 메일.
     - ALTERNATIVE : HTML 형식으로 메일을 보낼시.
     - RELATED : HTML 형식으로 본문에 이미지 삽입시.
  */
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
}


 ?>
