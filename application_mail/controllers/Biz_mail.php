<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biz_mail extends CI_Controller {
  function __construct() {

    if (isset($_SERVER['REQUEST_URI'])) {
    $req_uri = explode('/',$_SERVER['REQUEST_URI']);
    // if ($req_uri[1] == API_URI) {
    // echo $req_uri[1];
        get_config(array('csrf_protection' => false));
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
    // }
  }
      parent::__construct();
      // if(!isset($_SESSION)){
      //     session_start();
      // }

      // $this->load->helper(array('url', 'download'));
      // $this->load->library('pagination', 'email');
      // $this->load->Model('M_account');
      // $this->load->Model('M_dbmail');

      $this->mail = $this->input->post("mail_address");
      $encryp_password = $this->input->post("password");
      $this->mailbox = $this->input->post("mailbox");

      // $this->mail = "test3@durianict.co.kr";
      // $this->password = "durian12#";
      // $this->mailbox = "INBOX";
      $this->mailserver = "192.168.0.100";
      // $this->mailserver = "mail.durianit.co.kr";
      // $encryp_password = $this->M_account->mbox_conf($_SESSION['userid']);
			$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
      $key = $this->db->password;
      $key = substr(hash('sha256', $key, true), 0, 32);
			$this->password = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);

      // $this->mailserver = "192.168.0.50";
      // $this->user_id = $_SESSION["userid"];
      // $this->user_pwd = $decrypted;
      // $this->defalt_folder = array(
      //   "INBOX",
      //   "&vPSwuA- &07jJwNVo-",
      //   "&x4TC3A- &vPStANVo-",
      //   "&yBXQbA- &ulTHfA-",
      //   "&ycDGtA- &07jJwNVo-"
      // );
  }



  function imap_ping(){
    // $imap = $this->connect_mailserver();
    $mailserver = $this->mailserver;
    $host = "{" . $mailserver . ":143/imap/novalidate-cert}";
    $user_id = $this->mail;
    $user_pwd = $this->password;
    $imap = @imap_open($host, $user_id, $user_pwd, OP_HALFOPEN, 1);
    if ($imap) {
      $default_folder = array(
        "INBOX",
        "&vPSwuA- &07jJwNVo-",
        "&x4TC3A- &vPStANVo-",
        "&yBXQbA- &ulTHfA-",
        "&ycDGtA- &07jJwNVo-"
      );

      $folders = imap_list($imap, "{" . $mailserver . "}", '*');
      $folders = str_replace("{" . $mailserver . "}", "", $folders);
      sort($folders);

      $folders_root = $default_folder;
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
      $folders = $folders_sorted;
      $mailbox_tree = array();
      $folder_len = count($folders);
      $all_unseen = 0;
      for ($i=0; $i < $folder_len; $i++) {
        $fid = $folders[$i];
        $mbox_stat = imap_status($imap, "{" . $mailserver . "}".$fid, SA_ALL);
        $mbox_unseen = $mbox_stat->unseen;
        $mbox_recent = $mbox_stat->recent;
        $all_unseen += $mbox_unseen;
        $exp_folder = explode(".", $fid);
        $length = count($exp_folder);
        $text = mb_convert_encoding($exp_folder[$length-1], 'UTF-8', 'UTF7-IMAP');
        if ($text == "INBOX") {
          $text="받은 편지함";
        }

        $tree = array(
          "id" => $fid,
          "text" => $text,
          "child_num" => substr_count($fid, ".")
        );

        array_push($mailbox_tree, $tree);
      }
      $return_val = array("mailbox_tree" => $mailbox_tree, "unseen_cnt" => $all_unseen);
      echo json_encode($return_val);
    } else {
      echo json_encode("false");
    }
  }

  // function head_test(){
  //   $mailserver = $this->mailserver;
  //   $host = "{" . $mailserver . ":143/imap/novalidate-cert}";
  //   $user_id = "bhkim@durianit.co.kr";
  //   $user_pwd = "durian12##";
  //
  //   $stream = @imap_open($host, $user_id, $user_pwd);
  //   $mailno_arr = imap_sort($stream, SORTDATE, 1);
  //   for ($i=0; $i < 5; $i++) {
  //     $msgno = $mailno_arr[$i];
  //     $head_info = imap_headerinfo($stream, $msgno);
  //     var_dump($head_info);
  //   }
  // }


  public function connect_mailserver($mbox="") {

    // 접속정보 설정
    // $mbox = "&vPSwuA- &07jJwNVo-";
    $mbox = $this->mailbox;
    $mailserver = $this->mailserver;
    $host = "{" . $mailserver . ":143/imap/novalidate-cert}$mbox";
    $user_id = $this->mail;
    $user_pwd = $this->password;

    return @imap_open($host, $user_id, $user_pwd);
  }

  function get_mail(){
    $mbox = $this->mailbox;
    $mailserver = $this->mailserver;
    $host = "{" . $mailserver . ":143/imap/novalidate-cert}";
    $user_id = $this->mail;
    $user_pwd = $this->password;
    $imap = @imap_open($host, $user_id, $user_pwd, OP_HALFOPEN, 1);
    $mbox_status = imap_status($imap, "{" . $mailserver . "}".$mbox, SA_ALL);

    $mailno_arr = $this->imap_sort();
    $mail_head = array();
    if(count($mailno_arr) > 0){
      $mail_count = (count($mailno_arr) >= 7)?7:count($mailno_arr);
      for ($i=0; $i < $mail_count ; $i++) {
        $msgno = $mailno_arr[$i];
        $head_info = imap_headerinfo($this->connect_mailserver(), $msgno);

				$from = isset($head_info->from[0]) ? (array)$this->to_address($head_info->from[0]) : array();
        $udate = isset($head_info->date)? strtotime($head_info->date) : (int)$head_info->udate;
        $date = date("y-m-d", $udate);
        // 오늘 날짜일 경우 시간으로 출력처리
        $date = ($date == date("y-m-d", time()))? date("H:i", $udate) : $date;
        $decode_head = array(
           'msgno' => $msgno,
           'uid' => imap_uid($this->connect_mailserver(), $msgno),
					 'mbox' => "INBOX",
					 'address' => $this->mail,
           'from_name' => $from['name'],
					 'from_mail' => $from['email'],
           // 'to' => isset($head_info->to) ? (array)$this->array_to_address($head_info->to) : array(),
           // 'cc' => isset($head_info->cc) ? (array)$this->array_to_address($head_info->cc) : array(),
           // 'bcc' => isset($head_info->bcc) ? (array)$this->array_to_address($head_info->bcc) : array(),
           // 'date' => $head_info->date,
           // 'udate' => date("Y-m-d H:i:s", $head_info->udate),
           'udate' => $date,
           'subject' => isset($head_info->subject) ? $this->decode($head_info->subject) : '(제목 없음)',
           'size' => (int)$head_info->Size,
					 // 'read' => $head_info->Unseen
           'read' => (strlen(trim($head_info->Unseen)) < 1)?1:0
        );

				array_push($mail_head, $decode_head);
      }
      $data["mbox_status"] = $mbox_status;
      $data["mail_head"] = $mail_head;
      echo json_encode($data);

    } else {

      echo json_encode("empty");

    }


  }

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

  public function subject_decode($subject) {
    if(!isset($subject) || $subject == "") return '(제목 없음)';

    $utf8_decoded = imap_utf8($subject);
    if(strpos($utf8_decoded, '=?') === false) {
      $utf8_decoded = ($utf8_decoded == "")? "(제목 없음)" : $utf8_decoded;
      return $utf8_decoded;
    }else {   // =?utf-8?B?, 2개이상 있는 경우 인코딩부분 디코딩 안된채로 그대로 출력됨.
      $ques_mark_2 = strpos($subject, '?', 2);
      $charset = strtolower(substr($subject, 2, $ques_mark_2-2));

      if($charset == "utf-8") {
        $subject_part_arr = explode('?= ', $subject);
        for($i=0; $i<count($subject_part_arr); $i++) {
          $subject_part_arr[$i] = str_replace(array("=?utf-8?B?", "=?UTF-8?B?", "?="), array("", "", ""), $subject_part_arr[$i]);
          $subject_part_arr[$i] = imap_base64($subject_part_arr[$i]);
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


  protected function _set_date()
  {
    $timezone = date('Z');
    $operator = ($timezone[0] === '-') ? '-' : '+';
    $timezone = abs($timezone);
    $timezone = floor($timezone/3600) * 100 + ($timezone % 3600) / 60;

    return sprintf('%s %s%04d', date('D, j M Y H:i:s'), $operator, $timezone);
  }





  function imap_sort($sort_by = 'date', $descending = 1, $search_criteria = "ALL"){
  // SORTDATE - 메시지 날짜
  // SORTARRIVAL - 도착 일
  // SORTFROM - 첫 번째 보낸 사람 주소의 사서함
  // SORTSUBJECT - 메시지 제목
  // SORTTO - 첫 번째 받는 사람 주소의 사서함
  // SORTCC - 첫 번째 참조 주소의 사서함
  // SORTSIZE - 옥텟의 메시지 크기
  $mail = $this->connect_mailserver();
    $criterias = array(
        'date'    => SORTDATE,
        'arrival' => SORTARRIVAL,
        'from'    => SORTFROM,
        'subject' => SORTSUBJECT,
        'to'      => SORTTO,
        'cc'      => SORTCC,
        'size'    => SORTSIZE,
    );

    // $search_criteria = "UNSEEN";

    return imap_sort($mail, $criterias[$sort_by], $descending, 0, $search_criteria);
}


 function array_to_address($addresses){
  $formated = array();
  foreach ($addresses as $address)
  {
    $formated[] = $this->to_address($address);
  }

  return $formated;
 }


 function to_address($headerinfos){
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

    $name         = imap_utf8($headerinfos->personal);
    // $name         = $name[0]->text;
    $from['name'] = empty($name) ? '' : $name;
  }

  return $from;
}

}


 ?>
