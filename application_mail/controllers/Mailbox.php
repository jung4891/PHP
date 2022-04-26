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

class Mailbox extends CI_Controller { 
  function __construct() {
      parent::__construct();
      if(!isset($_SESSION)){
          session_start();
      }
      $this->load->helper(array('url', 'download'));
      $this->load->library('pagination', 'email');
      $this->load->library('user_agent');
      $this->load->Model('M_account');

      $encryp_password = $this->M_account->mbox_conf($_SESSION['userid']);
			$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
      $key = $this->db->password;
      $key = substr(hash('sha256', $key, true), 0, 32);
			$decrypted = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);
      // ip 변경시 -> mailbox, option, mbox_setting, side(모바일은 header) 모두 변경!
      // 서버에 192.~ 으로 해야지 mail.durianit.으로 하면 버퍼 상상히 심해짐.
      $this->mailserver = "192.168.0.100";
      // $this->mailserver = "mail.durianit.co.kr";
      $this->user_id = $_SESSION["userid"];
      $this->user_pwd = $decrypted;
      $this->defalt_folder = array(
        "INBOX",
        "&vPSwuA- &07jJwNVo-",
        "&x4TC3A- &vPStANVo-",
        "&yBXQbA- &ulTHfA-",
        "&ycDGtA- &07jJwNVo-"
      );
  }

  public function index(){
    $this->mail_list();
  }

  public function connect_mailserver($mbox="") {
    $mailserver = $this->mailserver;
    $host = "{" . $mailserver . ":143/imap/novalidate-cert}$mbox";
    $user_id = $this->user_id;
    $user_pwd = $this->user_pwd;
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
    $folders_sorted[3] = "&yBXQbA- &ulTHfA-";     // 스팸메일함
    $folders_sorted[4] = "&ycDGtA- &07jJwNVo-";   // 휴지통
    foreach($folders as $f) {
      if($f == "INBOX") continue;
      elseif($f == "&vPSwuA- &07jJwNVo-") continue;
      elseif($f == "&x4TC3A- &vPStANVo-") continue;
      elseif($f == "&yBXQbA- &ulTHfA-") continue;
      elseif($f == "&ycDGtA- &07jJwNVo-") continue;
      array_push($folders_sorted, $f);
    }
    return $folders_sorted;
  }

  function decode_mailbox(){
    $folders = $this->get_folders2();
    $mailserver = $this->mailserver;
    $mailbox_tree = array();
    for ($i=0; $i < count($folders); $i++) {
      $id = $folders[$i];
      $mails = $this->connect_mailserver($id);
      $mbox_status = imap_status($mails, "{" . $mailserver . "}".$id, SA_UNSEEN);
      $exp_folder = explode(".", $folders[$i]);
      $length = count($exp_folder);
      $text = mb_convert_encoding($exp_folder[$length-1], 'UTF-8', 'UTF7-IMAP');
      switch($text) {
        case "INBOX":  $text="받은메일함";  break;
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
        "id" => $id,
        "parent" => $parent_folder,
        "text" => $text,
        "child_num" => $substr_count,
        "unseen" => $mbox_status->unseen,
        "state" => array("opened" => true)
      );
      array_push($mailbox_tree, $tree);
    }
    echo json_encode($mailbox_tree);
  }


  public function get_folders2(){
    $mails= $this->connect_mailserver();
    $mailserver = $this->mailserver;
    $folders = imap_list($mails, "{" . $mailserver . "}", '*');
    $folders = str_replace("{" . $mailserver . "}", "", $folders);
    sort($folders);

    $folders_root = $this->defalt_folder;
    $folders_sub = array();

    foreach($folders as $f) {
      if(substr_count($f, '.') == 0) {
        if(in_array($f,$folders_root )){
            continue;
        }
        array_push($folders_root, $f);
      } else {
        array_push($folders_sub, $f);
      }
    }
    $folders_sorted = array();
    foreach($folders_root as $root) {
      array_push($folders_sorted, $root);
      foreach($folders_sub as $sub) {
        $pos_dot = strpos($sub, '.');
        $sub_root = substr($sub, 0, $pos_dot);
        if($sub_root == $root) {
          array_push($folders_sorted, $sub);
        }
      }
    }
    return $folders_sorted;
  }

  // 초기에 제목만 디코딩 애러가 많이나서 제목만 처리했는데 추후 보낸사람, 첨부파일명도 다 애러나서 다 이 함수로 처리함
  // + 원래 함수명은 subject_decode 였음.
  public function decode($subject) {
    // return 'test';
    if(!isset($subject) || $subject == "") return '(제목 없음)';

    $utf8_decoded = imap_utf8($subject);
    if(strpos($utf8_decoded, '=?') === false) {
      // 가끔 광고성메일의 제목 인코딩이 EUC-KR이라 ��으로 뜨는 경우가 있다.
      // + mb_detect_encoding 함수가 이게 좀 확실하진 않는데 실험해보니 EUC-KR은 반드시 잡아낸다.
      // + 반면 UTF-8로 인코딩된 애들은 ASCII로 나온다.
      $charset = strtolower(mb_detect_encoding("$utf8_decoded", array('ASCII','EUC-KR','UTF-8')));
      if($charset == "euc-kr")
        $utf8_decoded = iconv("euc-kr", "utf-8", $utf8_decoded);
      else
        $utf8_decoded = ($utf8_decoded == "")? "(제목 없음)" : $utf8_decoded;
      return $utf8_decoded;
    }else {   // =?utf-8?B?, 2개이상 있는 경우 인코딩부분 디코딩 안된채로 그대로 출력됨.
      $ques_mark_2 = strpos($subject, '?', 2);
      $charset = strtolower(substr($subject, 2, $ques_mark_2-2));
      $encoding = substr($subject, 8, 1);
      if($charset == "utf-8") {
        if($encoding == "B") {
          $subject_part_arr = explode('?=', $subject);
          // $subject_part_arr = explode('?= ', $subject);  // 이유는 모르겠는데 '?= '를 strpos로 잡히지 않는 경우도 있어서 공백제거함
                                                            // 근데 strpos로 '?'를 찾아보면 string(5) '?'로 나옴. 뭔가 줄개행기호가 들어있는건지..
          for($i=0; $i<count($subject_part_arr); $i++) {
            $subject_part_arr[$i] = str_replace(array("=?utf-8?B?", "=?UTF-8?B?", "?="), array("", "", ""), $subject_part_arr[$i]);
            $subject_part_arr[$i] = imap_base64($subject_part_arr[$i]);
          }
        }else {   // Q인경우 (간혹 Q로 디코딩 된경우 골때리게 imap_utf8이 안통하는 경우가 있음)
          $subject_part_arr = explode('?= ', $subject);
          for($i=0; $i<count($subject_part_arr); $i++) {
            $subject_part_arr[$i] = str_replace(array("=?utf-8?Q?", "=?UTF-8?Q?", "?=", "_"), array("", "", "", " "), $subject_part_arr[$i]);
            $subject_part_arr[$i] = quoted_printable_decode($subject_part_arr[$i]);
          }
        }
        $subject_merge = implode('', $subject_part_arr);
      }else {   // "euc-kr"  =?euc-kr?B?의 경우는 아예 출력이 안되서 따로처리함
        $subject_part_arr = explode('?= ', $subject);
        for($i=0; $i<count($subject_part_arr); $i++) {
          $subject_part_arr[$i] = str_replace(array("=?euc-kr?B?", "=?EUC-KR?B?", "?="), array("", "", ""), $subject_part_arr[$i]);
          $subject_part_arr[$i] = imap_base64($subject_part_arr[$i]);
          $subject_part_arr[$i] = mb_convert_encoding($subject_part_arr[$i], 'CP949', 'euc-kr');    // Notice iconv(): Detected an incomplete multibyte character in input string 애러처리
          $subject_part_arr[$i] = iconv('CP949', 'UTF-8', $subject_part_arr[$i]);
        }
        $subject_merge = implode('', $subject_part_arr);
      }
      return $subject_merge;
    }
  }

  // 상세검색에서 내용검색시에만 검색어 > 실제 메일이름 > uid(msg_no)
  public function exec_search($mbox, $user_id, $search_word) {
    $mails= $this->connect_mailserver($mbox);
    $domain = substr($user_id, strpos($user_id, '@')+1);
    $user_id = substr($user_id, 0, strpos($user_id, '@'));
    $src = ($mbox == "INBOX")? '' : '.'.$mbox.'/';

    $word_encoded_arr = array();
    // 거의 대부분이 quoted_printable(4)이고 가끔 광고성메일이 base_64(3)임 (test4 > 정크메일에 종류별로 다 넣음)
    // utf-8 / quoted_printable(4) -> 7J6s7YOd7LmY66OM(테스트)
    $word_encoded_utf8_quoted = quoted_printable_encode($search_word);
    array_push($word_encoded_arr, $word_encoded_utf8_quoted);
    // ks_c_5601-1987 / quoted_printable -> =BE=C8=B3=E7=C7=CF=BC=BC=BF=E4(안녕하세요)
    $word_encoded_1987_quoted = quoted_printable_encode(iconv('utf-8', 'cp949', $search_word));
    array_push($word_encoded_arr, $word_encoded_1987_quoted);
    // utf-8 / base64(3) -> (재택치료)
    $word_encoded_utf8_base64 = base64_encode($search_word);
    array_push($word_encoded_arr, $word_encoded_utf8_base64);
    // euc-kr / base64 -> xde9usau(테스트), wM7Fz7vnv/g=(인턴사원), wM7Fz7vnv/gg(인턴사원 )
    // 완벽하지 않음(딱 오로지 제목 텍스트만 써야만, 즉 글자수까지 똑같아야만 검색됨)
    // '업무'  vve5qw==  /  '업무 '	vve5qyA=  /  '업무일지'	 vve5q8DPwfY=  /  '일지업무' 	wM/B9r73uas=
    $word_encoded_euc_base64 = base64_encode(iconv('utf-8', 'cp949', $search_word));
    array_push($word_encoded_arr, $word_encoded_euc_base64);
    $word_encoded_arr = array_unique($word_encoded_arr);
    $word_encoded_imp = implode('\|', $word_encoded_arr);   // OR 조건으로 exec 검색하기 위해 설정함

    $msg_no_arr = array();
    exec("sudo grep -r '$word_encoded_imp' /home/vmail/'$domain'/'$user_id'/'$src'cur", $output, $error);
    if(count($output) != 0) {
      $name_arr = array();
      foreach($output as $i => $v) {
        $v = substr($v, 0, strpos($v, ":"));
        $v = substr($v, strpos($v, "cur")+4);
        array_push($name_arr, $v);
      }
      $name_arr = array_unique($name_arr);
      rsort($name_arr);     // 최신날짜로 정렬
      $name_arr_imp = implode('\|', $name_arr);
      exec("sudo grep -r '$name_arr_imp' /home/vmail/'$domain'/'$user_id'/'$src'dovecot-uidlist", $output2, $error2);
      foreach($output2 as $i => $uid) {
        $uid = explode(' :', $uid)[0];
        $msg_no = imap_msgno($mails, (int)$uid);    // A non well formed numeric value encountered 애러처리
        array_push($msg_no_arr, $msg_no);
      }
    }
    return $msg_no_arr;
  }

  // 대표검색 및 첨부파일 검색시 검색어 > 실제 메일이름
  public function exec_name_search($mbox, $user_id, $search_word) {
    $mails= $this->connect_mailserver($mbox);
    $domain = substr($user_id, strpos($user_id, '@')+1);
    $user_id = substr($user_id, 0, strpos($user_id, '@'));
    $src = ($mbox == "INBOX")? '' : '.'.$mbox.'/';

    if($search_word == "Content-Disposition: attachment") {
      $word_encoded_imp = $search_word;
    }else {
      $word_encoded_arr = array();
      $word_encoded_utf8_quoted = quoted_printable_encode($search_word);
      array_push($word_encoded_arr, $word_encoded_utf8_quoted);
      $word_encoded_1987_quoted = quoted_printable_encode(iconv('utf-8', 'cp949', $search_word));
      array_push($word_encoded_arr, $word_encoded_1987_quoted);
      $word_encoded_utf8_base64 = base64_encode($search_word);
      array_push($word_encoded_arr, $word_encoded_utf8_base64);
      $word_encoded_euc_base64 = base64_encode(iconv('utf-8', 'cp949', $search_word));
      array_push($word_encoded_arr, $word_encoded_euc_base64);
      $word_encoded_arr = array_unique($word_encoded_arr);
      $word_encoded_imp = implode('\|', $word_encoded_arr);
    }
    // -r        : 하위 디렉토리 탐색.
    // -l        : 패턴이 존재하는 파일 이름만 표시. (중복안되게 검색됨)
    exec("sudo grep -rl '$word_encoded_imp' /home/vmail/'$domain'/'$user_id'/'$src'cur", $output, $error);
    $name_arr = array();
    foreach($output as $i => $v) {
      $v = explode(':', explode('cur/', $v)[1])[0];
      array_push($name_arr, $v);
    }
    rsort($name_arr);     // 최신날짜로 정렬 (이후 exec_no_search에서 index로 정렬되게됨)
    return $name_arr;
  }

  // 대표검색 및 첨부파일 검색시 : 실제 메일이름 > uid > msg_no
  public function exec_no_search($mbox, $user_id, $name_arr, $start_i) {
    $mails= $this->connect_mailserver($mbox);
    $domain = substr($user_id, strpos($user_id, '@')+1);
    $user_id = substr($user_id, 0, strpos($user_id, '@'));
    $src = ($mbox == "INBOX")? '' : '.'.$mbox.'/';
    // $name_arr_imp = implode('\|', $name_arr);      // 한번에 명령문 실행시 list_v에서 mail_no와 mail_name이 서로 안맞는 애러생겨서 주석처리

    $msg_no_arr = array();
    $cnt = 0;   // idx가 name_arr이 15~29가 넘어오면 30~44가 되어 no_arr로 가기에 페이지 이동시 애러발생하기에 cnt 처리
    foreach($name_arr as $mail_name) {
      $output = array();    // exec는 반복하면 $output에 array_push 맹키로 계속 배열 요소가 덧붙지기에 반복할 때마다 초기화
      exec("sudo grep '$mail_name' /home/vmail/'$domain'/'$user_id'/'$src'dovecot-uidlist", $output, $error);
      $uid = explode(' :', $output[0])[0];
      $msg_no = imap_msgno($mails, (int)$uid);
      $msg_no_arr[$cnt+$start_i] = $msg_no;
      $cnt++;
    }
    return $msg_no_arr;
  }

  public function mail_list(){
    if(!isset($_SESSION['userid']) && ($_SESSION['userid'] == "")){
      redirect("");
    }

    $data = array();
    $mbox = $this->input->get("boxname");
    // $mbox = stripslashes($mbox);              // 메일함명 '처리

    $mbox = (isset($mbox))? $mbox : "INBOX";
    $user_id = $this->user_id;
    $mails= $this->connect_mailserver($mbox);
    $data['mbox'] = $mbox;

    if($mails) {
      $type = $this->input->get('type');
      // 없어도 될것 같음
      // if($type === NULL || $type === "") {
      //   $mailno_arr = imap_sort($mails, SORTDATE, 1);
      // }
      if($type == "attachments") {
        $session = $this->input->get("session");
        if(isset($session)) {
          $mailno_arr = $_SESSION['mailno_arr'];
        }else {
          $mailno_arr = $this->exec_name_search($mbox, $user_id, "Content-Disposition: attachment");
          // $_SESSION['mailno_arr'] = $mailno_arr;
        }
        $data['search_flag'] = true;
        $data['type'] = "attachments";
      }else if ($type == "unseen") {
        $mailno_arr = imap_sort($mails, SORTDATE, 1, 0, "UNSEEN");
        $data['type'] = "unseen";
      }else if ($type == "important") {
        $mailno_arr = imap_sort($mails, SORTDATE, 1, 0, "FLAGGED");
        $data['type'] = "important";
      }else if ($type == "search") {
        // 대표검색으로 제목+내용+보낸사람+받는사람 검색
        $search_word = trim(strtolower($this->input->get("search_word")));
        $session = $this->input->get("session");
        if(isset($session)) {
          // 검색후 페이지 링크 클릭시에는 세션에서 검색값 가져와서 빠르게 출력처리
          $mailno_arr = $_SESSION['mailno_arr'];
        }else {
          // 처음 검색시
          // 날짜로 대표검색시 (22-01-17, 22/1/17, 2022.01.17 모두 검색되도록 처리)
          $pattern = '/[0-9]+(-|\/|\.)[0-9]+(-|\/|\.)[0-9]+/';
          if(preg_match($pattern, $search_word)) {
            $delimiter = (strpos($search_word, '-'))? '-' : ( (strpos($search_word, '/'))? '/' : '.' );
            $search_word_arr = explode($delimiter, $search_word);
            $year = $search_word_arr[0];
            $year = (strlen($year) == 2)? 2000 + (int)$year : (int)$year;
            $month = (int)$search_word_arr[1];
            $day = (int)$search_word_arr[2];
            $start_date = $year.'-'.$month.'-'.$day;
            $timestamp = mktime(0, 0, 0, $month, $day, $year) + (24*60*60);
            $end_date = date('Y-m-d', $timestamp);
            $mailno_arr = imap_sort($mails, SORTDATE, 1, 0, "SINCE $start_date BEFORE $end_date");
          }else {
            $mailno_arr = $this->exec_name_search($mbox, $user_id, $search_word);
          }
          // $_SESSION['mailno_arr'] = $mailno_arr;    // 처음 검색할때는 세션에 넣어줌
        }
        $data['search_word'] = $search_word;
        $data['type'] = "search";
      }else if($type == "search_detail") {
        $session = $this->input->get("session");
        if(isset($session)) {
          $mailno_arr = $_SESSION['mailno_arr'];
        }else {
          $mailno_arr_target = array(); // 상단조회해서 배열 나오는 경우 중복검색
          $overlap_flag = false;        // 상단조회에서 배열 안나오는경우(count가 0인 경우) 중복검색

          $from_target = trim(strtolower($this->input->get("from")));
          if($from_target != "") {
            $data['from'] = $from_target;   // 아래에서 charset 인코딩을 변경하기에 그전에 값을 넣어줌
            $from_target = iconv("utf-8", "euc-kr", $from_target);  // 보낸이가 ks_c_5601-1987로 인코딩된경우 검색안되는 애러 처리(utf8도 같이 처리됨. but 아래에서 같은 방식으로 받는이는 처리가 안됨...)
            $mailno_arr_target = imap_sort($mails, SORTDATE, 1, 0, "FROM $from_target", "ks_c_5601-1987");
            $overlap_flag = true;
          }

          $to_target = trim(strtolower($this->input->get("to")));
          if($to_target != "") {
            if(count($mailno_arr_target) == 0 && $overlap_flag == false) {    // 위에서 중복검색 안들른경우, to가 최초방문.
              $mailno_arr_target = imap_sort($mails, SORTDATE, 1, 0, "TO $to_target");
              $overlap_flag = true;
            }
            if(count($mailno_arr_target) != 0 && $overlap_flag == true){      // 위에서 중복검색 이미 들러서 0이 아닌 결과가 나온경우
              $mailno_arr_target = array_intersect($mailno_arr_target, imap_sort($mails, SORTDATE, 1, 0, "TO $to_target"));
            }
            // count가 0이고 flag가 true인 경우는 이미 결과가 0이므로 처리하지 않음
          }
          $data['to'] = $to_target;

          $subject_target = trim(strtolower($this->input->get("subject")));
          if($subject_target != "") {
            $mailno_arr = imap_sort($mails, SORTDATE, 1);
            if(count($mailno_arr_target) == 0 && $overlap_flag == false) {
              foreach($mailno_arr as $index => $no) {
                $subject = imap_headerinfo($mails, $no)->subject;
                $subject_decoded = strtolower($this->decode($subject));
                if(strpos($subject_decoded, $subject_target) !== false)  {
                  array_push($mailno_arr_target, $no);
                }
              }
              $overlap_flag = true;
            }
            if(count($mailno_arr_target) != 0 && $overlap_flag == true){
              foreach($mailno_arr_target as $index => $no) {
                $subject = imap_headerinfo($mails, $no)->subject;
                $subject_decoded = strtolower($this->decode($subject));
                if(strpos($subject_decoded, $subject_target) === false)  {
                  unset($mailno_arr_target[$index]);
                }
              }
            }
            $data['subject'] = $subject_target;
          }

          $start_date = trim(strtolower($this->input->get("start_date")));
          if($start_date != "") {
            if(count($mailno_arr_target) == 0 && $overlap_flag == false) {
              $mailno_arr_target = imap_sort($mails, SORTDATE, 1, 0, "SINCE $start_date"); // 22-01-17, 2022-1-17 모두 검색됨.
              $overlap_flag = true;
            }
            if(count($mailno_arr_target) != 0 && $overlap_flag == true) {
              $mailno_arr_target = array_intersect($mailno_arr_target, imap_sort($mails, SORTDATE, 1, 0, "SINCE $start_date"));
            }
          }
          $data['start_date'] = $start_date;

          $end_date = trim(strtolower($this->input->get("end_date")));
          if($end_date != "") {
            if(count($mailno_arr_target) == 0 && $overlap_flag == false) {
              $mailno_arr_target = imap_sort($mails, SORTDATE, 1, 0, "BEFORE $end_date");
              $overlap_flag = true;
            }
            if(count($mailno_arr_target) != 0 && $overlap_flag == true) {
              $mailno_arr_target = array_intersect($mailno_arr_target, imap_sort($mails, SORTDATE, 1, 0, "BEFORE $end_date"));
            }
          }
          $data['end_date'] = $end_date;

          $contents_target = trim(strtolower($this->input->get("contents")));
          if($contents_target != "") {
            if(count($mailno_arr_target) == 0 && $overlap_flag == false) {
              // 순수 내용만 검색한경우에는 대표검색으로 검색한것과 같게 처리함
              $mailno_arr_target = $this->exec_name_search($mbox, $user_id, $contents_target);
              // $mailno_arr_target = $this->exec_search($mbox, $user_id, $contents_target);
              $data['search_flag'] = true;
            }
            if(count($mailno_arr_target) != 0 && $overlap_flag == true){
              // 상세검색시 위에서 중복검색되는 요소 있는경우엔 시간걸리더라도 exec_search로 배열 가져오게 처리.
              $user_id = $this->user_id;
              $mailno_arr_exec = $this->exec_search($mbox, $user_id, $contents_target);
              $mailno_arr_target = array_intersect($mailno_arr_target, $mailno_arr_exec);
            }
            $data['contents'] = $contents_target;
          }
          $mailno_arr = array_values($mailno_arr_target);
          // $_SESSION['mailno_arr'] = $mailno_arr;
        }
      $data['type'] = "search_detail";
      }else {
        $mailno_arr = imap_sort($mails, SORTDATE, 1);
      }
      $mails_cnt = count($mailno_arr);

      // php 페이징
      $curpage = $this->input->get("curpage");
      $mail_cnt_show = $this->input->get("mail_cnt_show");

      $curpage = ($curpage == "")? 1:$curpage;                    // 1페이지라 가정
      $total_rows = $mails_cnt;                                   // 총 16개 데이터라 가정.
      $per_page = ($mail_cnt_show == "")? 15:$mail_cnt_show;      // 한 페이지에 보여줄 데이터 갯수
      $pagingNum_cnt = 10;                                        // 페이징 블록에서의 페이징 번호 갯수 (5개로 가정하면)
      if($this->agent->is_mobile()) {
        $per_page = 8;
        $pagingNum_cnt = 5;
      }
      $total_pages = ceil($total_rows/$per_page);                 // 16/15 -> 총 2페이지
      $curpage = ($curpage > $total_pages)? $total_pages : $curpage;    // 보기개수 변경시(10개>30개) 없는 페이지 처리

      $paging_block = ceil($curpage/$pagingNum_cnt);              // 1/5 -> 1번째 페이징 블록
      $block_start = (($paging_block - 1) * $pagingNum_cnt) + 1;  // (1-1)*5 + 1 -> 1
      $block_end = $block_start + $pagingNum_cnt - 1;             // 1 + 5 -1 -> 5 (1~5)


      if ($block_end > $total_pages)  $block_end = $total_pages;  // 페이징 블록을 1~2로 수정
      $total_blocks = ceil($total_pages/$pagingNum_cnt);          // 2/5 -> 페이징 블록 총 1개
      $start_row = ($curpage-1) * $per_page;                      // (1-1)*15 -> 0번째 데이터부터 출력.
                                                // (만일 2페이지일경우 16번째(인덱스15) 데이터 출력)
      $data['per_page'] = $per_page;
      $data['start_row'] = $start_row;
      $data['curpage'] = $curpage;

      $paging = '';
      if($mails_cnt != 0) {
      if ($curpage == 1) {
          $paging .= "<img src='/misc/img/icon/처음.svg' style='position: relative; top: 4px;'>";
      } else {
          $paging .= "<a href='javascript:go_page(1);'><img src='/misc/img/icon/처음.svg' style='position: relative; top: 4px; cursor: pointer; '></a>";
      }
      if ($paging_block == 1) {
          $paging .= "<img src='/misc/img/icon/왼쪽.svg' style='position: relative; top: 4px; padding-left:8px; padding-right: 5px'>";
      } else {
        $p = (($paging_block-2)*$pagingNum_cnt) + 1;
          $paging .= "<a href='javascript:go_page($p);'><img src='/misc/img/icon/왼쪽.svg' style='position: relative; top: 4px; padding-left:8px; padding-right: 5px; cursor: pointer; '></a>";
      }
      for ($i=$block_start; $i<=$block_end; $i++) {
        if ($curpage == $i) {
            $paging .= "<a href='' style='color:#3399FF; font-weight: bold; padding-left:13px'>$i</a>";
        } else {
            $paging .= "<a href='javascript:go_page($i);' class='link' style='padding-left:13px'>$i</a>";
        }
      }
      if ($paging_block == $total_blocks || count($mailno_arr) == 0 ) {       // 메일 없는경우 페이지링크 비활성화
          $paging .= "<img src='/misc/img/icon/오른쪽.svg' style='position: relative; top: 4px; padding-left: 20px; padding-right:8px'>";
      } else {
        $p = ($paging_block*$pagingNum_cnt) + 1;
          $paging .= "<a href='javascript:go_page($p);'><img src='/misc/img/icon/오른쪽.svg' style='position: relative; top: 4px; cursor: pointer; padding-left: 20px; padding-right:8px'></a>";
      }
      if ($curpage == $total_pages || count($mailno_arr) == 0 ) {
          $paging .= "<img src='/misc/img/icon/끝.svg' style='position: relative; top: 4px;'>";
      } else {
          $paging .= "<a href='javascript:go_page($total_pages);'><img src='/misc/img/icon/끝.svg' style='position: relative; top: 4px; cursor: pointer; '></a>";
      }
      $paging .= "<style> .link {color:black; } </style>";
      }
      $data['links'] = $paging;

      if($mails_cnt >= 1) {
        $_SESSION['mailno_arr'] = $mailno_arr;  // 위에서 각각 처리하지 않고 일단 넣어줌. get방식의 session값에 따라 세션값 적용유무가 갈리므로.
                                                //  + 대표검색/첨부파일은 속도를 위해 아래에서 cnt_show만큼 배열이 잘리므로 미리 세션 넣어줌

        // 검색시 name_arr로 넘어온 배열을 no_arr로 변경해줌
        $mailname_arr_tmp = array();
        if( (isset($data['type']) && $data['type'] == "search") || (isset($data['search_flag']) && $data['search_flag']  == true) ) {
          if(gettype($mailno_arr[0]) == "string") {       // 처음 검색시에만 아래 for문 작동. 날짜검색 or 검색후 링크클릭시에는 skip함.
            for($i=$start_row; $i<$start_row+$per_page; $i++) {
              if(isset($mailno_arr[$i])) {                // 여기서 mailno_arr은 exec_name_search로 반환된 메일명들이 들어있음. 번호x
                $mailname_arr_tmp[$i] = $mailno_arr[$i];  // 페이지에서 보여지는 수만큼만 메일명들 담음
              }
            }
            $mailno_arr = $this->exec_no_search($mbox, $user_id, $mailname_arr_tmp, $start_row);  // index 유지한채 msg_no 배열로 반환됨.
          }
        }

        // 여기서부턴 mailno_arr엔 msg_no만 들어있음
        for($i=$start_row; $i<$start_row+$per_page; $i++) {
          if (isset($mailno_arr[$i])) {                   // 마지막 페이지에서 15개가 안될경우 오류처리
            $mail_no = $mailno_arr[$i];
            $mail_name = isset($mailname_arr_tmp[$i])?  $mailname_arr_tmp[$i] : "";   // 첨부 및 대표검색시 목록/상하위메일 이동버튼 구현시 필요
            $m_uid = imap_uid($mails, $mail_no);
            $headerinfo = imap_headerinfo($mails, $mail_no);
            $attached = false;
            $struct = imap_fetchstructure($mails, $mail_no);
            if(isset($struct->parts)) {
              foreach($struct->parts as $part) {
                if($part->type === 0 && $part->ifdisposition === 1 || $part->type === 3 || $part->type === 5 && $part->ifdisposition === 1) {
                  $attached = true;
                  break;
                }
              }
            }

            if (isset($headerinfo->from[0])) {
              $from_obj = $headerinfo->from[0];
              $from_addr = imap_utf8($from_obj->mailbox).'@'.imap_utf8($from_obj->host);
              $from_name_full = $from_addr;
              if (isset($from_obj->personal)) {
                $from_name = $this->decode($from_obj->personal);    // 대표님 보낸사람 디코딩 애러처리.  (utf-8/Q)
                // $from_name = imap_utf8($from_obj->personal);
                $from_name_full = $from_name.' <'.$from_addr.'>';
              } else {
                $from_name = $from_addr;
              }
              // $encoding = strtolower(mb_detect_encoding("$from_name", array('ASCII','EUC-KR','UTF-8')));  // 광고성 메일 euc-kr 인코딩부분 애러처리 (위 subject_decode에 포함되어서 주석처리)
              // if($encoding == "euc-kr")
              //   $from_name = iconv("euc-kr", "utf-8", $from_name);
            }else {
              $from_name = "(이름 없음)";
              $from_name_full = "(이름 없음)";
            }
            if(isset($headerinfo->to[0])) {
              $to_obj = $headerinfo->to[0];
              if(isset($to_obj->host))
                $to_addr = imap_utf8($to_obj->mailbox).'@'.imap_utf8($to_obj->host);    // host없는경우 애러처리
              else
                $to_addr = imap_utf8($to_obj->mailbox);
              $to_name_full = $to_addr;
              if (isset($to_obj->personal)) {
                $to_name = imap_utf8($to_obj->personal);
                $to_name_full = $to_name.' <'.$to_addr.'>';
              } else {
                $to_name = $to_addr;
              }
            }else {
              $to_name = "(이름 없음)";
              $to_name_full = "(이름 없음)";
            }

            $subject_decoded = $this->decode($headerinfo->subject);
            $udate = isset($headerinfo->date)? strtotime($headerinfo->date) : (int)$headerinfo->udate;
            $date = date("y.m.d", $udate);
            // 오늘 날짜일 경우 시간으로 출력처리
            $date = ($date == date("y.m.d", time()))? date("H:i", $udate) : $date;
            if(isset($headerinfo->Size)) {
              $size = $headerinfo->Size * 0.73076;    // 첨부파일이 실제크기보다 bytes가 높게 출력되어 임의로 수정.
            	$size = round($size / 1024);
            	($size < 1024)? $size .= 'KB' : $size = round($size/1024).'MB';
            } else {
            	$size = '';
            }

            $data["mail_list_info"][$i] = array(
            	'mail_no'		=>		$mail_no,
              'mail_name' =>    $mail_name,
            	// 'ipinfo'		=>		$this->get_senderip($m_uid, $mbox),
              'ipinfo'    =>    array('ip'=> '192.', 'country' => 'kr'),
            	'flagged'		=>		$headerinfo->Flagged,
            	'attached'	=>		$attached,
            	'unseen'		=>		$headerinfo->Unseen,
            	'from'			=>		array('from_name' => $from_name, 'from_name_full' => $from_name_full),
            	'to'		   	=>		array('to_name' => $to_name, 'to_name_full' => $to_name_full),
            	'subject'		=>		$subject_decoded,
            	'date'			=>		$date,
            	'size'			=>		$size
            );
            // echo '<pre>';
            // var_dump($headerinfo);
            // echo '</pre>';
            // exit;
          }
        }
        // echo '<pre>';
        // var_dump($data["mail_list_info"]);
        // echo '</pre>';
        // exit;
      }else {
        $data['test_msg'] = "메일이 없습니다.";
      }

      // 방금 전 읽은 메일 표시처리
      // var_dump($_SESSION['visited_arr']);
      if(isset($_SESSION['visited_arr'])) {
        if($_SESSION["visited_arr"]["boxname"] == $mbox) {
          $data['visited_no'] = $_SESSION["visited_arr"]["mailno"];
        }
      }
      $data['mailno_arr'] = $mailno_arr;      // 메일 상세페이지에서 상위/하위메일 가져올때 요 정보가 필요함
      imap_close($mails);			              	// IMAP 스트림을 닫음
    }else {
      $data['test_msg'] = '사용자명 또는 패스워드가 틀립니다.';
    }
    // var_dump($mailno_arr);
    // exit;
    if ($this->agent->is_mobile()) {
      $this->load->view('mobile/mail_list_v_mobile', $data);
    } else {
      $this->load->view('mailbox/mail_list_v', $data);
    }

  } // function(mail_list)

  function get_senderip($uid, $mbox){

    $this->load->model('M_dbmail');
    $ip_arr = array(
      "ip" => "",
      "country" => ""
    );
    $box = ($mbox == "INBOX") ? "" : "'/.{$mbox}'";
    // $uid = imap_uid($this->connect_mailserver(), $msg_no);
    $mail = $this->user_id;
    $domain = explode("@",$mail)[1];
    $user = explode("@",$mail)[0];
    $path = "/home/vmail/{$domain}/{$user}{$box}";
    exec("sudo awk '$1=={$uid} && /:/ {print}' {$path}/dovecot-uidlist",$file);
    // exec("cat /home/vmail/dovecot-deliver.log",$output);
    // exec("cat /var/www/html/index.php",$output);
    // echo '$output : ';
    // print_r($output);;
    // var_dump($output);
    // echo $return_var;
    if(count($file) > 0){
      $file = substr($file[0],1);
      $filename = explode(":", $file)[1];
      // find /home/vmail/durianict.co.kr/bhkim/cur -name "*1638934312.M750010P166364.DEVMAIL,S=3713,W=3786*"
      // $path = ($mbox == "INBOX")?$path:"/home/vmail/{$domain}/{$user}/'.{$mbox}'";
      // echo "sudo find {$path}/cur -name '*{$filename}*' -exec grep 'SENDERIP' {} \\;";
      //   exit;
      exec("sudo find {$path}/cur -name '*{$filename}*' -exec grep 'SENDERIP' {} \\;",$senderip);
      if(count($senderip) > 0){
        // var_dump($sendip);
        $ip = $senderip[0];
        $ip = explode(": ", $ip)[1];
        if(strpos($ip,"192.168.")!==false){
          $country = "kr";
        } else {

          $get_country = $this->M_dbmail->get_country($ip);
          if($get_country){
              $country = $get_country->country;
          }else{
              $country = "";
          }
        }
        $ip_arr = array(
          "ip" => $ip,
          "country" => $country
        );
        return $ip_arr;
      } else {
        return $ip_arr;
      }
      // exec("grep 'SENDERIP' {$path}/cur/1638934312.M750010P166364.DEVMAIL,S=3713,W=3786:2,S", $ip);
      // var_dump($ip);
    } else {
      return $ip_arr;
    }
  }

  function get_senderip2(){

    $this->load->model('M_dbmail');
    $msgno_arr = $this->input->post("ip_arr");
    $mbox = $this->input->post("mail_box");

    $mbox = (isset($mbox))? $mbox : "INBOX";
    $mails= $this->connect_mailserver($mbox);
    $box = ($mbox == "INBOX") ? "" : "/'.{$mbox}'";
    $mail = $this->user_id;
    $domain = explode("@",$mail)[1];
    $user = explode("@",$mail)[0];
    $path = "/home/vmail/{$domain}/{$user}{$box}";

    $ip_collect = array();
    foreach ($msgno_arr as $no) {
      $ip_arr = array(
        "ip" => "",
        "country" => ""
      );
      $uid = imap_uid($mails, $no);
      exec("sudo awk '$1=={$uid} && /:/ {print}' {$path}/dovecot-uidlist",$file);

      if(count($file) > 0){
        $file = substr($file[0],1);
        $filename = explode(":", $file)[1];
        $senderip = array();
        exec("sudo find {$path}/cur -name '*{$filename}*' -exec grep -E 'Originating-IP|SENDERIP|X-Session-IP' {} \\;",$senderip);
        // var_dump($senderip);
        if(count($senderip) > 0){

          $ip = $senderip[0];
          $ip = explode(": ", $ip)[1];
          if(strpos($ip,"192.168.")!==false){
            $country = "kr";
          } else {

            $get_country = $this->M_dbmail->get_country($ip);
            if($get_country){
                $country = $get_country->country;
            }else{
                $country = "";
            }
          }
          $ip_arr = array(
            "ip" => $ip,
            "country" => $country
          );
          array_push($ip_collect, $ip_arr);
        } else {


          array_push($ip_collect, $ip_arr);
        }

      } else {
        array_push($ip_collect, $ip_arr);
      }


    }
    echo json_encode($ip_collect);

  }



  // flag 지정 (중요메일)
  public function set_flag() {
    $mbox = $this->input->get("boxname");

    if(isset($mbox)) {
      // echo '여기는 set_flag: '.$mbox.'<br>';
      $mbox = urldecode($mbox);     // 없어도 작동은 하는데 일단 넣어줌.
      // 여기랑 mail_list_v도 mbox2부분 수정 동시에 해줘야함(아닌가? 아래 주석해도 별 문제 없네? 음.. )
      // $mbox = str_replace(array('%23', '%26', '+'), array('#', '&', ' '), $mbox);
    } else {
      $mbox = "INBOX";
    }
    $mailno = $this->input->get("mailno");
    $state = $this->input->get("state");
    $mails= $this->connect_mailserver($mbox);

    if($state == "emptyStar") {
      imap_setflag_full($mails, $mailno, "\\Flagged");
    } else {
      imap_clearflag_full($mails, $mailno, "\\Flagged");
    }
  }


  protected function array_to_address($addresses)
  {
    $formated = array();

    foreach ($addresses as $address)
    {
      $formated[] = $this->to_address($address);
    }

    return $formated;
  }

  /**
   * [to_address description]
   *
   * @param object $headerinfos
   *
   * @return array
   */
  protected function to_address($headerinfos)
  {
    $from = array(
      'email' => '',
      'name'  => '',
    );

    if (isset($headerinfos->mailbox) && isset($headerinfos->host))
    {
      $from['email'] = $headerinfos->mailbox . '@' . $headerinfos->host;
    }

    if (! empty($headerinfos->personal))
    {
      // imap_mime_header_decode는 인코딩된 문자열의 charset => 인코딩 양식과 text => 디코딩된 값으로 배열이 반환된다.
      // $name         = imap_mime_header_decode($headerinfos->personal);
      // $name         = $name[0]->text;
      // $from['name'] = empty($name) ? '' : imap_utf8($name);

      $name         = $this->decode($headerinfos->personal);    // 대표님 보낸사람 디코딩 애러처리 (utf-8/Q)
      // $name         = imap_utf8($headerinfos->personal);
      // $name         = $name[0]->text;

      // 광고성 메일 euc-kr 인코딩부분 애러처리
      // $encoding = strtolower(mb_detect_encoding("$name", array('ASCII','EUC-KR','UTF-8')));
      // if($encoding == "euc-kr")
      //   $name = iconv("euc-kr", "utf-8", $name);

      $from['name'] = empty($name) ? '' : $name;
    }
    return $from;
  }

  // protected function struc_decoding(string $text, int $encoding = 5)
  // {
  //   switch ($encoding)
  //   {
  //     case ENC7BIT: // 0 7bit
  //       return $text;
  //     case ENC8BIT: // 1 8bit
  //       return imap_8bit($text);
  //     case ENCBINARY: // 2 Binary
  //       return imap_binary($text);
  //     case ENCBASE64: // 3 Base64
  //       return imap_base64($text);
  //     case ENCQUOTEDPRINTABLE: // 4 Quoted-Printable
  //       return quoted_printable_decode($text);
  //     case ENCOTHER: // 5 other
  //       return $text;
  //     default:
  //       return $text;
  //   }
  // }


  // protected function _get_attachments(int $uid, $structure, string $part_number = '',	int $index = null)
	// {
  //   $mbox = $this->input->get("boxname");
  //   $mails= $this->connect_mailserver($mbox);
	// 	// $id          = imap_msgno($mails, $uid);
  //   $id =$uid;
	// 	$attachments = [];
  //
	// 	if (isset($structure->parts))
	// 	{
	// 		foreach ($structure->parts as $key => $sub_structure)
	// 		{
	// 			$new_part_number = empty($part_number) ? $key + 1 : $part_number . '.' . ($key + 1);
  //
	// 			$results = $this->_get_attachments($uid, $sub_structure, $new_part_number);
  //
	// 			if (count($results))
	// 			{
	// 				if (isset($results[0]['name']))
	// 				{
	// 					foreach ($results as $result)
	// 					{
	// 						array_push($attachments, $result);
	// 					}
	// 				}
	// 				else
	// 				{
	// 					array_push($attachments, $results);
	// 				}
	// 			}
  //
	// 			// If we already have the given indexes return here
	// 			if (! is_null($index) && isset($attachments[$index]))
	// 			{
	// 				return $attachments[$index];
	// 			}
	// 		}
	// 	}
	// 	else
	// 	{
	// 		$attachment = [];
  //
	// 		if (isset($structure->dparameters[0]))
	// 		{
	// 			$bodystruct   = imap_bodystruct($mails, $id, $part_number);
	// 			$decoded_name = imap_mime_header_decode($bodystruct->dparameters[0]->value);
	// 			$filename     = imap_utf8($decoded_name[0]->text);
	// 			$content      = imap_fetchbody($mails, $id, $part_number);
	// 			$content      = (string)$this->struc_decoding($content, $bodystruct->encoding);
  //
	// 			$attachment = [
	// 				'name'         => (string)$filename,
	// 				'part_number'  => (string)$part_number,
	// 				'encoding'     => (int)$bodystruct->encoding,
	// 				'size'         => (int)$structure->bytes,
	// 				'reference'    => isset($bodystruct->id) ? (string)$bodystruct->id : '',
	// 				'disposition'  => (string)strtolower($structure->disposition),
	// 				'type'         => (string)strtolower($structure->subtype),
	// 				'content'      => $content,
	// 				'content_size' => strlen($content),
	// 			];
	// 		}
  //
	// 		return $attachment;
	// 	}
  //
	// 	return $attachments;
	// }

  // protected function get_body(int $uid)
	// {
	// 	return [
	// 		'html'  => $this->get_part($uid, 'TEXT/HTML'),
	// 		'plain' => $this->get_part($uid, 'TEXT/PLAIN'),
	// 	];
	// }

  // protected function get_mime_type($structure)
  // {
  //   $primary_body_types = [
  //     TYPETEXT        => 'TEXT',
  //     TYPEMULTIPART   => 'MULTIPART',
  //     TYPEMESSAGE     => 'MESSAGE',
  //     TYPEAPPLICATION => 'APPLICATION',
  //     TYPEAUDIO       => 'AUDIO',
  //     TYPEIMAGE       => 'IMAGE',
  //     TYPEVIDEO       => 'VIDEO',
  //     TYPEMODEL       => 'MODEL',
  //     TYPEOTHER       => 'OTHER',
  //   ];
  //
  //   if ($structure->ifsubtype)
  //   {
  //     return strtoupper($primary_body_types[(int)$structure->type] . '/' . $structure->subtype);
  //   }
  //
  //   return 'TEXT/PLAIN';
  // }

  // protected function get_part(int $uid, $mimetype = '', $structure = false, $part_number = '')
  // {
  //   $mbox = $this->input->get("boxname");
  //   $mails= $this->connect_mailserver($mbox);
  //
  //   if (! $structure)
  //   {
  //     $structure = imap_fetchstructure($mails, $uid, FT_UID);
  //   }
  //
  //   if ($structure)
  //   {
  //     if ($mimetype === $this->get_mime_type($structure))
  //     {
  //       if (! $part_number)
  //       {
  //         $part_number = '1';
  //       }
  //
  //       $text = imap_fetchbody($mails, $uid, $part_number, FT_UID | FT_PEEK);
  //
  //       return $this->struc_decoding($text, $structure->encoding);
  //     }
  //
  //     if ($structure->type === TYPEMULTIPART) // 1 multipart
  //     {
  //       foreach ($structure->parts as $index => $subStruct)
  //       {
  //         $prefix = '';
  //
  //         if ($part_number)
  //         {
  //           $prefix = $part_number . '.';
  //         }
  //
  //         $data = $this->get_part($uid, $mimetype, $subStruct, $prefix . ($index + 1));
  //
  //         if ($data)
  //         {
  //           return $data;
  //         }
  //       }
  //     }
  //   }
  //
  //   return false;
  // }

  // protected function embed_images(array $email) {
  //   foreach ($email['attachments'] as $key => $attachment) {
  //     if ($attachment['disposition'] === 'inline' && ! empty($attachment['reference'])) {
  //       $reference = str_replace(['<', '>'], '', $attachment['reference']);
  //       $img_embed = 'data:image/' . $attachment['type'] . ';base64,' . base64_encode($attachment['content']);
  //
  //       $email['body']['html'] = str_replace('cid:' . $reference, $img_embed, $email['body']['html']);
  //     }
  //   }
  //
  //   return $email;
  // }

  // function mail_detail(){
  //   $mbox = $this->input->get("boxname");
  //   $mailno = $this->input->get("mailno");
  //   $mails= $this->connect_mailserver($mbox);
  //   $mails_cnt = imap_num_msg($mails);
  //
  //   $data = array();
  //   $data['mbox'] = $mbox;
  //   $head = imap_headerinfo($mails, $mailno);
  //   // var_dump($head);
  //
  //   // Check Priority
	// 	preg_match('/X-Priority: ([\d])/mi', imap_fetchheader($mails, $mailno), $matches);
	// 	$priority = isset($matches[1]) ? $matches[1] : 3;
  //   // echo "<br><br>".$priority."<br>";
  //
  //   if (isset($head->subject) && strlen($head->subject) > 0){
  //       $subject = imap_utf8($head->subject);
  //   }
  //
  //   // echo $subject;
  //
  //   $email = [
  //     'id'          => (int)$mailno,
  //     'uid'         => (int)$mailno,
  //     'from'        => isset($head->from[0]) ? (array)$this->to_address($head->from[0]) : [],
  //     'to'          => isset($head->to) ? (array)$this->array_to_address($head->to) : [],
  //     'cc'          => isset($head->cc) ? (array)$this->array_to_address($head->cc) : [],
  //     'bcc'         => isset($head->bcc) ? (array)$this->array_to_address($head->bcc) : [],
  //     'reply_to'    => isset($head->reply_to) ? (array)$this->array_to_address($head->reply_to) : [],
  //     //'return_path' => isset($header->return_path) ? (array)$this->array_to_address($header->return_path) : [],
  //     // 'message_id'  => $head->message_id,
  //     'in_reply_to' => isset($head->in_reply_to) ? (string)$head->in_reply_to : '',
  //     'references'  => isset($head->references) ? explode(' ', $head->references) : [],
  //     'date'        => $head->date,//date('c', strtotime(substr($header->date, 0, 30))),
  //     'udate'       => (int)$head->udate,
  //     'subject'     => $subject,
  //     'priority'    => (int)$priority,
  //     'recent'      => strlen(trim($head->Recent)) > 0,
  //     'read'        => strlen(trim($head->Unseen)) < 1,
  //     'answered'    => strlen(trim($head->Answered)) > 0,
  //     'flagged'     => strlen(trim($head->Flagged)) > 0,
  //     'deleted'     => strlen(trim($head->Deleted)) > 0,
  //     'draft'       => strlen(trim($head->Draft)) > 0,
  //     'size'        => (int)$head->Size,
  //     'attachments' => (array)$this->_get_attachments($mailno, imap_fetchstructure($mails, $mailno)),
  //     'body'        => $this->get_body($mailno),
  //     'struct' => imap_fetchstructure($mails, $mailno)
  //   ];
  //
  //   $email = $this->embed_images($email);
  //
  //   for ($i = 0; $i < count($email['attachments']); $i++)
  //   {
  //     if ($email['attachments'][$i]['disposition'] !== 'attachment')
  //     {
  //       unset($email['attachments'][$i]);
  //     }
  //   }
  //     imap_close($mails);
  //     $data["mail_info"] = $email;
  //     $this->load->view('mailbox/mail_detail_v', $data);
  // }


  public function mail_detail(){

    $mbox = $this->input->get("boxname");
    $mailno = $this->input->get("mailno");
    $mailname = $this->input->get("mailname");
    $mails= $this->connect_mailserver($mbox);
    $mails_cnt = imap_num_msg($mails);

    $data = array();
    $data['mbox'] = $mbox;
    $data['mailno'] = $mailno;
    $data['mailname'] = $mailname;
    $head = imap_headerinfo($mails, $mailno);
    $msg_no = trim($head->Msgno);

    $struct = imap_fetchstructure($mails, $msg_no);
    $data['struct'] = $struct;
    $body = imap_body($mails, $msg_no);
    $data['body'] = $body;

    // 내용 가져오는 부분
    $contents = '';       // 내용 부분 담을 변수
    // $attachments = '';    // 첨부파일 부분 담을 변수
    $attachments = array();
    if (isset($struct->parts)) {
      $flattenedParts = $this->flattenParts($struct->parts);  // 메일구조 평면화

      // 테스트용
      $data['flattenedParts'] = $flattenedParts;

      $plain_cnt = 0;   // 상대방 메일함 용량초과로 리턴되는 메시지가 plain이 2개인데 첫번쨰가 inline속성이고 다음은 제외시킴.
      $html_cnt = 0;    // 발송실패 메일중 .eml파일은 뒤에 html이 또 나와 첨부파일이 출력되는 오류 처리.
      foreach($flattenedParts as $partNumber => $part) {
       switch($part->type) {
         case 0:    // the HTML or plain text part of the email
           // parts에 Plain 하나만 있는경우 || 메일 전송때 첨부파일 용량초과시 리턴되는 메일출력 || plain 하나는 아닌데 inline으로 출력되는경우
           if ($part->subtype == "PLAIN" && count($flattenedParts) == 1 || $part->subtype == "PLAIN" && $part->encoding == 0 && $part->ifdisposition != 1 &&  $plain_cnt == 0 || $part->subtype == "PLAIN" && $part->ifdisposition == 1 && $part->disposition == "inline" ) {
             foreach($part->parameters as $object) {          // charset이 parameters 배열에 [0] or [1]에 있음
               if(strtolower($object->attribute) == 'charset') {
                 $charset = $object->value;
                 break;
               }
             }
             $message = $this->getPart($mails, $msg_no, $partNumber, $part->encoding, $charset);
             $message = htmlspecialchars($message); // 내용에 <> 있을경우 그대로 출력(아랫부분과 동일)
             // $message = str_replace(array("<", ">"), array("&lt;", "&gt;"), $message);
             $contents .= $message;
             $plain_cnt += 1;
             break;
           }else if($part->subtype == "PLAIN" && $part->ifdisposition == 0) {
             break;   // 그외 일반적인 plain은 출력하지 않음
           // // .txt 첨부파일은 여기 들어있음 + Undelivered Message Headers.txt도 여기로 빠짐
           }else if( ($part->subtype == "PLAIN" || $part->subtype == "RFC822-HEADERS") && $part->ifdisposition == 1 ) {
           // }else if($part->subtype == "PLAIN" && $part->ifdisposition == 1) {   // 이전부분
             // $filename = $this-> getFilenameFromPart($part);
             // if ($filename) {
             //   $down_link = "&nbsp;<a href=\"javascript:download('{$mbox}', '{$msg_no}',
             //   '{$partNumber}', '$part->encoding', '{$filename}');\">".$filename.'</a><br>';
             // } else {
             //   $down_link = "(파일명 없음)";
             // }
             // $attachments .= $down_link;
             $attachment = $this->makeDownloadLink($mbox, $msg_no, $partNumber, $part);
             array_push($attachments, $attachment);
           }else if($part->subtype == "HTML" && $part->ifdisposition == 0) {    // html 본문 출력부분
             if($html_cnt >=  1) break;
             foreach($part->parameters as $object) {  // charset이 parameters 배열에 [0] or [1]에 있음
               if(strtolower($object->attribute) == 'charset') {
                 $charset = $object->value;
                 break;
               }
             }
             $message = $this->getPart($mails, $msg_no, $partNumber, $part->encoding, $charset);
             $contents .= $message;
             $html_cnt++;
           }else if($part->subtype == "HTML" && $part->ifdisposition == 1) {    // .html 첨부파일 처리
             // $filename = $this-> getFilenameFromPart($part);
             // if ($filename) {
             //   $down_link = "&nbsp;<a href=\"javascript:download('{$mbox}', '{$msg_no}',
             //   '{$partNumber}', '$part->encoding', '{$filename}');\">".$filename.'</a><br>';
             // } else {
             //   $down_link = "(파일명 없음)";
             // }
             // $attachments .= $down_link;
             $attachment = $this->makeDownloadLink($mbox, $msg_no, $partNumber, $part);
             array_push($attachments, $attachment);
           }
           break;
         case 1:  // multi-part headers, can ignore  (MIXED, ALTERNATIVE, RELATED)
           break;
         case 2:  // attached message headers, can ignore
                  // (.eml 첨부파일은 2로 넘어와서 break 해제하면 되는데 그렇게되면 다른부분 또 애러 생겨서 우선 살려둠)
           // 첨부파일 용량 초과시 리턴되는 메일의 첨부파일부분 처리 || 상대방 메일함 용량 초과시 리턴되는 첨부파일부분(.txt와 .msg)
           if($part->subtype == "DELIVERY-STATUS" || $part->subtype == "RFC822") {
              // $filename = $this->getFilenameFromPart($part);
              // if ($filename) {
              //   if(isset($part->bytes)) {
              //     $size = $part->bytes;
              //     $size = ($size < 1024)? $size .= 'B' : (($size < 1024*1024)? $size .= round($size/1024, 1).'KB' : $size = round($size/1024*1024, 1).'MB');
              //   } else {
              //     $size = '';
              //   }
              //   $down_link = "&nbsp;<a href=\"javascript:download('{$mbox}', '{$msg_no}',
              //   '{$partNumber}', '$part->encoding', '{$filename}');\">".$filename."</a>&nbsp;
              //   <span style='color: silver;'>$size</span><br>";
              // } else {
              //   $down_link = "(파일명 없음)";
              // }
              $attachment = $this->makeDownloadLink($mbox, $msg_no, $partNumber, $part);
              array_push($attachments, $attachment);
           }
           break;                                         //
         case 3: // application	(엑셀, 파워포인트등 첨부파일은 3임)
         case 4: // audio
         case 5: // image		(PNG 인라인출력 or 첨부 모두 type이 5임. 여기서는 삽입된거만 처리 첨부는 아래로 내려감)
           if ($part->ifdisposition == 0 || $part->disposition == "inline") {

             $img_data = imap_fetchbody($mails, $msg_no, $partNumber);
             $img_data = str_replace("\r\n", " ", $img_data);   // 리턴, 줄개행코드 제거. $img_data에 이게 있으면 애러발생함(HTML로 보내질때)

             // contents의 기존 src 속성값을 이미지 데이터로 교체후 contents 변수에 다시 넣어줌
             //  + 삽입된 이미지의 경우 디코딩 안하고 fetchbody으로 추출한 내용을 src에 아래처럼 넣어줌
             if($part->ifid == 1) {
               $img_name = str_replace(array("<", ">"), array("", ""), $part->id);     // id가 있는경우 id로 아래 이름명보다 더 정확함 (어떤 메일을 메일명 image.png로만 나와서 아래만으로는 처리안됨)
             }else {
               $type = gettype($part->parameters);    // 이미지 삽입된 메일중 parameters에 빈 object만 있는경우 흰색창만 뜨게됨
               $img_name = ($type == 'array')? $part->parameters[0]->value: $part->dparameters[0]->value;
             }
             $pattern = '/src="cid:[a-zA-Z0-9.@_\-]+"/';
             preg_match_all($pattern, $contents, $matches);
             $matched_arr = $matches[0];

             $target = '';
             foreach($matched_arr as $e) {
               if(strpos($e, $img_name) !== false)    // 이미지 위치 바뀌는 애러처리 (이미지 2개이상일 경우 이미지 파일명으로 찾아감. id있으면 id로 찾아감)
                  $target = $e;
             }
            $contents = str_replace($target, "src='data:image/png;base64,$img_data'", $contents);
            break;
           }
         case 6: // video
         case 7: // other (첨부파일)
           // $filename = $this-> getFilenameFromPart($part);
           // if ($filename) {
           //   $down_link = "&nbsp;<a href=\"javascript:download('{$mbox}', '{$msg_no}',
           //   '{$partNumber}', '$part->encoding', '{$filename}');\">".$filename.'</a><br>';
           // } else {
           //   $down_link = "(파일명 없음)";
           // }
           // $attachments .= $down_link;
           $attachment = $this->makeDownloadLink($mbox, $msg_no, $partNumber, $part);
           array_push($attachments, $attachment);
         break;
       } // switch (type)
     } // foreach (part)
      $data['contents'] = $contents;
      $data['attachments'] = $attachments;
    } else {
      // MS-TNEF는 MAPI 메시지 속성을 캡슐화하기 위한 Microsoft 관련 형식. 일단 오류메시지 제거.
      if($struct->subtype == "MS-TNEF") {
        $data['contents'] = '메시지가 전부 또는 일부 받는 사람에게 도착하지 않았습니다.';
      }else if($struct->subtype == "HTML") {  // 팀장님 신용보증재단 기능문의 디코딩 오류제거
        $contents = $this->getPart($mails, $msg_no, 1, $struct->encoding, $struct->parameters[0]->value);
        $data['contents'] = $contents;
      }else {
        // Microsoft Office Outlook 테스트 메시지	( 2021/09/03 11:04 )는
        // parts가 없고 html만 있어서 제어문 처리함
        // + [전자결재]결재문서 최종 승인 메일은 역시 parts가 없는데 base64로 디코딩됨
        $contents = $this->getPart($mails, $msg_no, 1, $struct->encoding, $struct->parameters[0]->value);
        $data['contents'] = $contents;
      }
      $data['attachments'] = $attachments;
    }

    $data["mail_info"] = array(
      'id'          => (int)$mailno,
      'uid'         => (int)$mailno,
      'from'        => isset($head->from[0]) ? (array)$this->to_address($head->from[0]) : array('email'=>'', 'name'=>''),
      'to'          => isset($head->to) ? (array)$this->array_to_address($head->to) : array(),
      'cc'          => isset($head->cc) ? (array)$this->array_to_address($head->cc) : array(),
      'bcc'         => isset($head->bcc) ? (array)$this->array_to_address($head->bcc) : array(),
      'reply_to'    => isset($head->reply_to) ? (array)$this->array_to_address($head->reply_to) : array(),
      //'return_path' => isset($header->return_path) ? (array)$this->array_to_address($header->return_path) : [],
      // 'message_id'  => $head->message_id,
      'in_reply_to' => isset($head->in_reply_to) ? (string)$head->in_reply_to : '',
      'references'  => isset($head->references) ? explode(' ', $head->references) : array(),
      'date'        => isset($head->date) ? $head->date : '',//date('c', strtotime(substr($header->date, 0, 30))),
      'udate'       => isset($head->date) ? strtotime($head->date) : (int)$head->udate,
      // 'udate'       => (int)$head->udate,
      'subject'     => $this->decode($head->subject),
      // 'subject'     => isset($head->subject) ? imap_utf8($head->subject) : '(제목 없음)',
      'recent'      => strlen(trim($head->Recent)) > 0,
      'read'        => strlen(trim($head->Unseen)) < 1,
      'answered'    => strlen(trim($head->Answered)) > 0,
      'flagged'     => strlen(trim($head->Flagged)) > 0,
      'deleted'     => strlen(trim($head->Deleted)) > 0,
      'draft'       => strlen(trim($head->Draft)) > 0,
      'size'        => (int)$head->Size,
      'msg_no'      => $msg_no
      // 'struct'      => imap_fetchstructure($mails, $msg_no),
      // 'body'        => imap_fetchstructure($mails, $msg_no)
    );
    imap_close($mails);

    if ($this->agent->is_mobile()) {
      $this->load->view('mobile/mail_detail_v_mobile', $data);
    } else {
      $this->load->view('mailbox/mail_detail_v', $data);
    }
  }

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
    $charset = strtolower($charset);

    switch($encoding) {
      case 0: return $data; // 7BIT
      case 1:
        // 팀장님 신용보증재단 메일 디코딩 애러처리
        if ($charset == 'ks_c_5601-1987' || $charset == 'us-ascii' || $charset == 'euc-kr')
          return iconv('cp949', 'utf-8', $data);
        else
          return $data; // 8BIT
      case 2: return $data; // BINARY
      case 3:   // base64
        $data_decoded = base64_decode($data);
        if($charset == "euc-kr" || $charset == 'ks_c_5601-1987')
          $data_decoded = iconv('cp949', 'utf-8', $data_decoded);
        // $res = 'encoding: '.$encoding.'<br><br>charset: '.$charset.'<br><br>rawData: <br>'.$data.'<br>decoded: <br>'.$data_decoded;
        return $data_decoded;
      case 4:   // quoted_printable
        $data_decoded = quoted_printable_decode($data);    // QUOTED_PRINTABLE (업무일지 서식)
        if ($charset == 'ks_c_5601-1987' || $charset == 'us-ascii' || $charset == 'euc-kr')   // else는 charset이 utf-8로 iconv 불필요
          $data_decoded = iconv('cp949', 'utf-8', $data_decoded);     // us-ascii도 변경해줘야 제대로 출력됨
          // 아래로 디코딩 안되는 메일 가끔 있어서 이걸로 해야함 (대표님 메일중 발견)
          // $data = iconv('euc-kr', 'utf-8', $data);  // charset 변경
        // $res = 'encoding: '.$encoding.'<br><br>charset: '.$charset.'<br><br>rawData: <br>'.$data.'<br>decoded: <br>'.$data_decoded;
        return $data_decoded;
      case 5: return $data; // OTHER
    }
  }

  // 첨부파일 링크 만드는 부분
  function makeDownloadLink($mbox, $msg_no, $partNumber, $part) {
    $return_val = array(
      'mbox' => '',
      'msgno' => '',
      'part_num' => '',
      'content_type' => '',
      'encoding' => '',
      'subtype' => '',
      'disposition' => '',
      'filename' => '',
      'realname' => '',
      'size' => ''
    );
    $realname = $this->getFilenameFromPart($part);
    $filename = imap_utf8($realname);
    if ($filename) {
      if(isset($part->bytes)) {
        $size = $part->bytes * 0.73076;   // 첨부파일 실제크기보다 bytes가 높게 출력되어 임의로 수정.
        $size = ($size < 1024)? $size = round($size).'B' : (($size < 1024*1024)? $size = round($size/1024).'KB' : $size = round($size/(1024*1024)).'MB');
      } else {
        $size = '';
      }
      // $down_link = "&nbsp;<a href=\"javascript:download('{$mbox}', '{$msg_no}',
      // '{$partNumber}', '$part->encoding', '{$filename}');\">".$filename."</a>&nbsp;
      // <span style='color: silver;'>$size</span><br>";
      $return_val = array(
        'mbox' => $mbox,
        'msgno' => $msg_no,
        'part_num' => $partNumber,
        'content_type' => $part->type,
        'encoding' => $part->encoding,
        'subtype' => $part->subtype,
        'disposition' => (isset($part->disposition))? $part->disposition : '',
        'filename' => $filename,
        'realname' => $realname,
        'size' => $size
      );
    }
    // else {
    //   $down_link = "(파일명 없음)";
    // }
    // return $down_link;
    return $return_val;
  }

  // 첨부파일 다운로드 링크의 파일명 가져오는 부분
  function getFilenameFromPart($part) {
    $filename = '';
    if($part->ifdparameters == 1) {   // 아래 parameters에 파일명이 아닌 charset이 들어가 있는 경우 첨부파일 출력안되는 애러처리.
      foreach($part->dparameters as $object) {
        if(strtolower($object->attribute) == 'filename') {
          $filename = $this->decode($object->value);    // =?utf-8?B? 인코딩된경우 애러처리
        }
      }
    }else {
      foreach($part->parameters as $object) {
        if(strtolower($object->attribute) == 'name') {
          $filename = $this->decode($object->value);    // =?utf-8?B? 인코딩된경우 애러처리
        }
      }
    }
    if($filename === '') {
      if($part->subtype == "DELIVERY-STATUS") {   // 메일함 가득차서 메시지 발송이 안될경우 리턴되는 txt 첨부파일 처리
        $filename = 'delivery-status.txt';
      }
      if($part->subtype == "RFC822") {   // 메일함 가득차서 메시지 발송이 안될경우 리턴되는 .msg(아웃룩 확장자인듯) 첨부파일 처리
        $filename = 'details.txt';
      }

    }
    return $filename;   // 한글일 경우 ?ks_c_5601-1987?여서 디코딩 해야함
    // return imap_utf8($filename);   // 한글일 경우 ?ks_c_5601-1987?여서 디코딩 해야함
  }

  // 첨부파일 클릭시 다운로드 되는 부분
  function download() {
    $mails = $this->connect_mailserver($_POST['box']);
    $fileSource = imap_fetchbody($mails, $_POST['msg_no'], $_POST['part_no']);
    $encoding = $_POST['encoding'];

    // eml형식은 따로 제외하여 html로 파일 다운로드 (eml는 outlook에서만 열리는 듯함)
    if(strpos($_POST['f_name'], '.eml')) {
      $fileSource = substr($fileSource, strpos($fileSource, 'text/html'));
      $fileSource = substr($fileSource, strpos($fileSource, 'base64')+7);
      $fileSource = substr($fileSource, 0, strpos($fileSource, '-------Boundary'));
      force_download($_POST['f_name'].'.html', imap_base64($fileSource));
    }else {
      // 아래 switch 인코딩에 따라 아얘 깔끔하게 처리함.
      // .svg파일의 경우 quoted_printable로 encode되어서 따로 잡아줘야 파일 다운후 정상적으로 열린다.(+ .html 파일도 마찬가지)
      // $quoted_encode = strpos($_POST['f_name'], '.svg') || strpos($_POST['f_name'], '.html');
      // $fileSource = ($quoted_encode)? quoted_printable_decode($fileSource) : imap_base64($fileSource);
      switch($encoding) {
        case 3:
          $fileSource = imap_base64($fileSource);
          break;
        case 4:
          $fileSource = quoted_printable_decode($fileSource);
      }
      force_download($_POST['f_name'], $fileSource);
    }
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

  // 상세페이지에서 목록/상하위메일 이동시
  function get_next_mailno() {
    $mbox = $this->input->post("mbox");
    $mail_no = $this->input->post("mail_no");
    $way = $this->input->post("way");
    // biz에서 바로 넘어올경우 세션이 없어서 다시 넣어줌
    $mails= $this->connect_mailserver($mbox);
    $mailno_arr = isset($_SESSION['mailno_arr'])? $_SESSION['mailno_arr'] : imap_sort($mails, SORTDATE, 1);
    // $mailno_arr = $_SESSION['mailno_arr'];

    $index_now = array_search($mail_no, $mailno_arr);
    if($way == "up") {
      if($index_now == 0) {
        echo "x";
      }else {
        echo $mailno_arr[$index_now - 1];
      }
    }else {
      if($index_now == count($mailno_arr)-1) {
        echo "x";
      }else {
        echo $mailno_arr[$index_now + 1];
      }
    }
  }

  // 첨부/대표검색시 상세페이지 목록/상하위메일 이동시
  function get_next_no_name() {
    $mbox = $this->input->post("mbox");
    $mail_name = $this->input->post("mail_name");
    $way = $this->input->post("way");
    $mailno_arr = $_SESSION['mailno_arr'];

    $next_arr = array();
    // 현재 mail_name -> 다음 mail_name
    $index_now = array_search($mail_name, $mailno_arr);
    if($way == "up") {
      if($index_now == 0) {
        echo "x";
        exit;
      }else {
        array_push($next_arr, $mailno_arr[$index_now - 1]);
      }
    }else {
      if($index_now == count($mailno_arr)-1) {
        echo "x";
        exit;
      }else {
        array_push($next_arr, $mailno_arr[$index_now + 1]);
      }
    }

    // mail_name -> mail_no
    $mbox = urldecode($mbox);   // 여기서는 urlencoded 형태로 %가 그대로 남음. decode해야함.
    $mails= $this->connect_mailserver($mbox);
    $user_id = $this->user_id;
    $domain = substr($user_id, strpos($user_id, '@')+1);
    $user_id = substr($user_id, 0, strpos($user_id, '@'));
    $src = ($mbox == "INBOX")? '' : '.'.$mbox.'/';
    $mail_name = $next_arr[0];
    $output = array();
    exec("sudo grep '$mail_name' /home/vmail/'$domain'/'$user_id'/'$src'dovecot-uidlist", $output, $error);
    $uid = explode(' :', $output[0])[0];
    $msg_no = imap_msgno($mails, (int)$uid);
    array_push($next_arr, $msg_no);

    echo implode(' ', $next_arr);
  }


}


 ?>
