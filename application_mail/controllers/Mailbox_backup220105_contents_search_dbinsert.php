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
      $this->load->Model('M_account');
      // $this->load->Model('M_contents');

      $encryp_password = $this->M_account->mbox_conf($_SESSION['userid']);
			$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
      $key = $this->db->password;
      $key = substr(hash('sha256', $key, true), 0, 32);
			$decrypted = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);
      // $this->mailserver = "192.168.0.100";
      $this->mailserver = "192.168.0.50";
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

  function get_time() { $t=explode(' ',microtime()); return (float)$t[0]+(float)$t[1]; }

  // 상세검색때 db insert했던부분 아까워서 남겨둠
  public function insert_all($user_id) {
    $start = $this->get_time();
    set_time_limit(0);  // 2분이상 되어도 멈추지 않게함

    $mails= $this->connect_mailserver();
    $mailserver = $this->mailserver;
    $folders = imap_list($mails, "{" . $mailserver . "}", '*');
    $folders = str_replace("{" . $mailserver . "}", "", $folders);
    echo '<pre>';
    var_dump($folders);
    echo '</pre>';
    exit;
    imap_close($mails);

    $cnt_all = 0;
    foreach($folders as $f) {
      $mbox = $f;
      $mails = $this->connect_mailserver($mbox);
      $mailno_arr = imap_sort($mails, SORTDATE, 1);
      $mails_cnt = count($mailno_arr);
      $sql = " INSERT IGNORE INTO contents (user_id, mbox, mail_id, contents) VALUES ";
      $cnt_each = 0;
      if($mails_cnt > 0) {
        foreach($mailno_arr as $index => $no) {
          $header = imap_headerinfo($mails, $no);
          if(!$header)  continue;     // 간혹 아웃룩이랑 총 메일개수 다를때가 있음. 버그인듯.
          if(isset($header->message_id)) {
            $mail_id = $header->message_id;
          }else {     // 보낸메일의 경우 message_id가 없음
            $mail_id = $header->udate."_".$header->Size;
          }
          $struct = imap_fetchstructure($mails, $no);
          $contents = '';
          if (isset($struct->parts)) {
            $flattenedParts = $this->flattenParts($struct->parts);
            foreach($flattenedParts as $partNumber => $part) {
              switch($part->type) {
                case 0:
                if($part->subtype == "PLAIN") break;
                if($part->ifparameters) {
                  foreach($part->parameters as $object) {
                    if(strtolower($object->attribute) == 'charset') {
                      $charset = $object->value;
                    }
                  }
                }
                $message = $this->getPart($mails, $no, $partNumber, $part->encoding, $charset);
                $contents .= $message;
                break;
              }
            }
          }else {
            $message = $this->getPart($mails, $no, 1, $struct->encoding, $struct->parameters[0]->value);
            $contents .= $message;
          }
          $contents = strtolower(strip_tags($contents));
          $contents = str_replace("'", "\'", $contents);

          $contents = str_replace("&nbsp;", "", $contents);
          $contents = str_replace(" ", "", $contents);
          $contents = str_replace("-", "", $contents);

          $cnt_each++;
          $mbox_decoded = mb_convert_encoding($f, 'UTF-8', 'UTF7-IMAP');
          if($cnt_each != $mails_cnt) {
            $sql .= " ('$user_id', '$mbox_decoded', '$mail_id', '$contents'), ";
          }else {
            $sql .= " ('$user_id', '$mbox_decoded', '$mail_id', '$contents')";
          }
          $cnt_all++;
        }
        $this->M_contents->insert_mail_all($sql);
      }
    }
    $end = $this->get_time();
    $time = $end - $start;
    echo "모든메일 INSERT : ".$cnt_all."개<br>";
    echo "소요시간 : ".number_format($time,2) . "초<br>";
    // 3841/3756(실제 insert)(445초)
    // 배열로 보내 insert 한번만 해도 1000개 44초 걸림. (max_allowed_packet=1M -> 16M로 변경해야함)
  }

  public function subject_decode($subject) {
    if(!isset($subject) || $subject == "") return '(제목 없음)';

    $utf8_decoded = imap_utf8($subject);
    if(strpos($utf8_decoded, '=?') === false) {
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

  public function mail_list(){
    if(!isset($_SESSION['userid']) && ($_SESSION['userid'] == "")){
      redirect("");
    }

    // $user_id = $_SESSION['userid'];
    // $user_id = substr($user_id, 0, strpos($user_id, '@'));
    // $db_mails_cnt = $this->M_contents->count_mails($user_id);
    // if($db_mails_cnt == 0)    $this->insert_all($user_id);    // db에 메일정보가 없는상태 (첫로그인)

    $data = array();
    $mbox = $this->input->get("boxname");
    $mbox = (isset($mbox))? $mbox : "INBOX";
    $mails= $this->connect_mailserver($mbox);
    $data['mbox'] = $mbox;

    if($mails) {
      $mails_cnt = imap_num_msg($mails);
      if($this->input->get('type') == "attachments") {
        $mailno_arr = imap_sort($mails, SORTDATE, 1);
        $mailno_attached_arr = array();
        foreach ($mailno_arr as $no) {
          $struct = imap_fetchstructure($mails, $no);
          if(isset($struct->parts)) {
            foreach($struct->parts as $part) {
              // .txt 첨부파일의 type은 0, ifdisposition은 1, disposition은 attachment 들어가있음.
              // 엑셀, 파워포인트 첨부파일의 type은 3임.
              // img파일은 type은 5이고 ifdisposition이 1인경우만 첨부파일. 0이면 inline이미지.
              if($part->type === 0 && $part->ifdisposition === 1 || $part->type === 3 || $part->type === 5 && $part->ifdisposition === 1) {
                array_push($mailno_attached_arr, $no);
                break;
              }
            }
          }
        }
        $mailno_arr = $mailno_attached_arr;
        $mails_cnt = count($mailno_arr);
        $data['type'] = "attachments";
      } else if ($this->input->get('type') == "unseen") {
        $mailno_arr = imap_sort($mails, SORTDATE, 1, 0, "UNSEEN");
        $mails_cnt = count($mailno_arr);
        $data['type'] = "unseen";
      } else if ($this->input->get('type') == "important") {
        $mailno_arr = imap_sort($mails, SORTDATE, 1, 0, "FLAGGED");
        $mails_cnt = count($mailno_arr);
        $data['type'] = "important";
      } else if($this->input->get('type') == "search") {
        $mailno_arr_target = array();
        $from_target = trim(strtolower($this->input->get("from")));
        if($from_target != "") {
          $mailno_arr_target = imap_sort($mails, SORTDATE, 1, 0, "FROM $from_target");
        }
        $data['from'] = $from_target;

        $to_target = trim(strtolower($this->input->get("to")));
        if($to_target != "") {
          if(count($mailno_arr_target) == 0) {
            $mailno_arr_target = imap_sort($mails, SORTDATE, 1, 0, "TO $to_target");
          }else {
            $mailno_arr_target = array_intersect($mailno_arr_target, imap_sort($mails, SORTDATE, 1, 0, "TO $to_target"));
          }
        }
        $data['to'] = $to_target;

        $subject_target = trim(strtolower($this->input->get("subject")));
        if($subject_target != "") {

          // db로 내용검색으로 테스트(지우기 아깝..)
          $start = $this->get_time();
          set_time_limit(0);  // 2분이상 되어도 멈추지 않게함

          $user_id = $_SESSION['userid'];
          $user_id = substr($user_id, 0, strpos($user_id, '@'));
          $mbox_decoded = mb_convert_encoding($mbox, 'UTF-8', 'UTF7-IMAP');
          $mailno_arr = imap_sort($mails, SORTDATE, 1);


          // 1) 동기화

          // 메일서버와 db에서 메일ID정보 가져오기
          $mail_arr_server = array();
          foreach($mailno_arr as $no) {
            $header = imap_headerinfo($mails, $no);
            $mail_no = trim($header->Msgno);
            if(isset($header->message_id)) {
              $mail_id = $header->message_id;
            }else {     // 보낸메일의 경우 message_id가 없어서 임의로 id 생성함.
              $mail_id = $header->udate."_".$header->Size;
            }
            $mail_arr_server[$mail_no] = $mail_id;
          }

          $mailID_arr_db = array();
          $mailID_arr_tmp = $this->M_contents->get_mailID_arr($user_id, $mbox_decoded);
          foreach($mailID_arr_tmp as $arr) {
            array_push($mailID_arr_db, $arr["mail_id"]);
          }

          // 새로온 메일, 삭제된 메일 조회
          $mail_arr_add = array_diff($mail_arr_server, $mailID_arr_db);
          // $mailID_arr_add = array_diff($mailID_arr_server, $mailID_arr_db);
          $mail_arr_del = array_diff($mailID_arr_db, $mail_arr_server);
          // echo '새로운 메일 개수(서버-db): '.count($mail_arr_add).'<br>';
          // echo '삭제된 메일 개수(db-서버): '.count($mail_arr_del).'<br>';

          // 새로온 메일의 경우 db에 insert.
          if(count($mail_arr_add) > 0) {
            foreach($mail_arr_add as $mail_no => $mail_id) {
              $struct = imap_fetchstructure($mails, $mail_no);
              $contents = '';
              if (isset($struct->parts)) {
                $flattenedParts = $this->flattenParts($struct->parts);
                foreach($flattenedParts as $partNumber => $part) {
                  switch($part->type) {
                    case 0:
                      if($part->subtype == "PLAIN") break;
                      if($part->ifparameters) {
                        foreach($part->parameters as $object) {
                          if(strtolower($object->attribute) == 'charset') {
                            $charset = $object->value;
                          }
                        }
                      }
                      $message = $this->getPart($mails, $mail_no, $partNumber, $part->encoding, $charset);
                      $contents .= $message;
                      break;
                  }
                }
              }else {
                $message = $this->getPart($mails, $mail_no, 1, $struct->encoding, $struct->parameters[0]->value);
                $contents .= $message;
              }
              $contents = strtolower(strip_tags($contents));
              $contents = str_replace("'", "\'", $contents);

              $contents = str_replace("&nbsp;", "", $contents);
              $contents = str_replace(" ", "", $contents);
              $contents = str_replace("-", "", $contents);
              $this->M_contents->insert_mail($user_id, $mbox_decoded, $mail_id, $contents);
            }
          }

          // 삭제된 메일의 경우 db에서 delete.
          if(count($mail_arr_del) > 0) {
            foreach($mail_arr_del as $mail_id) {
              $this->M_contents->delete_mail($user_id, $mbox_decoded, $mail_id);
            }
          }

          // 2) db에서 검색후 server에서 msgno 가져오기
          $search_word = $subject_target;
          $mailID_arr_tmp = $this->M_contents->get_mailID_arr_search($user_id, $mbox_decoded, $search_word);
          $mailID_arr = array();
          foreach($mailID_arr_tmp as $arr) {
            array_push($mailID_arr, $arr["mail_id"]);
          }
          // $mailNO_arr_res = array();
          foreach($mailID_arr as $id) {
            $index = array_search($id, $mail_arr_server);
            array_push($mailno_arr_target, $index);
            // array_push($mailNO_arr_res, $index);
          }
          $end = $this->get_time();
          $time = $end - $start;
          echo "검색 소요시간 : ".number_format($time,2) . "초<br>";
          // echo '<br>검색 결과<br>';
          // var_dump($mailNO_arr_res);

          // db 3800개(4초)
          // 새로운메일 100개, 삭제된 메일 100개 -> 5.16초
          // 새로운메일 10개, 삭제된 메일 10개 -> 0.72초


          // 기존 제목검색부분
          // $mailno_arr = imap_sort($mails, SORTDATE, 1);
          // if(count($mailno_arr_target) == 0) {
          //   foreach($mailno_arr as $index => $no) {
          //     $subject = imap_utf8(imap_headerinfo($mails, $no)->subject);
          //     $subject = strtolower($subject);
          //     if(strpos($subject, $subject_target) !== false)  {
          //       array_push($mailno_arr_target, $no);
          //     }
          //   }
          // }else {
          //   foreach($mailno_arr_target as $index => $no) {
          //     $subject = strtolower(imap_utf8(imap_headerinfo($mails, $no)->subject));
          //     if(strpos($subject, $subject_target) === false)  {
          //       unset($mailno_arr_target[$index]);
          //     }
          //   }
          // }
          $data['subject'] = $subject_target;
        }

        // 기존 내용검색부분(사긴 너무 오래걸려서 리눅스 명령어 실행으로 대체)
        $contents_target = trim(strtolower($this->input->get("contents")));
        if($contents_target != "") {
          $mailno_arr = imap_sort($mails, SORTDATE, 1);
          if(count($mailno_arr_target) == 0) {
            foreach($mailno_arr as $index => $no) {
              $struct = imap_fetchstructure($mails, $no);
              $contents = '';
              if (isset($struct->parts)) {
                $flattenedParts = $this->flattenParts($struct->parts);
                foreach($flattenedParts as $partNumber => $part) {
                  switch($part->type) {
                    case 0:
                      if($part->subtype == "PLAIN") break;
                      if($part->ifparameters) {
                        foreach($part->parameters as $object) {
                          if(strtolower($object->attribute) == 'charset') {
                            $charset = $object->value;
                          }
                        }
                      }
                      $message = $this->getPart($mails, $no, $partNumber, $part->encoding, $charset);
                      $contents .= $message;
                      break;
                  }
                }
              }else {
                $message = $this->getPart($mails, $no, 1, $struct->encoding, $struct->parameters[0]->value);
                $contents .= $message;
              }
              $contents = strtolower(strip_tags($contents));
              if(strpos($contents, $contents_target) !== false)  {
                array_push($mailno_arr_target, $no);
              }
            }
          }else {
            foreach($mailno_arr_target as $index => $no) {
              $struct = imap_fetchstructure($mails, $no);
              $contents = '';
              if (isset($struct->parts)) {
                $flattenedParts = $this->flattenParts($struct->parts);
                foreach($flattenedParts as $partNumber => $part) {
                  switch($part->type) {
                    case 0:
                      if($part->subtype == "PLAIN") break;
                      if($part->ifparameters) {
                        foreach($part->parameters as $object) {
                          if(strtolower($object->attribute) == 'charset') {
                            $charset = $object->value;
                          }
                        }
                      }
                      $message = $this->getPart($mails, $no, $partNumber, $part->encoding, $charset);
                      $contents .= $message;
                      break;
                  }
                }
              }else {
                $message = $this->getPart($mails, $no, 1, $struct->encoding, $struct->parameters[0]->value);
                $contents .= $message;
              }
              $contents = strtolower(strip_tags($contents));
              if(strpos($contents, $contents_target) === false)  {
                unset($mailno_arr_target[$index]);
              }
            }
            // $mailno_arr_target = array_values($mailno_arr_target);    // 인덱싱 초기화 (안하면 리스트뷰에서 제대로 출력 안됨)
          }
          $data['contents'] = $contents_target;
      } // contents 검색 끝

      $start_date = trim(strtolower($this->input->get("start_date")));
      if($start_date != "") {
        if(count($mailno_arr_target) == 0) {
          $mailno_arr_target = imap_sort($mails, SORTDATE, 1, 0, "SINCE $start_date");
        }else {
          $mailno_arr_target = array_intersect($mailno_arr_target, imap_sort($mails, SORTDATE, 1, 0, "SINCE $start_date"));
        }
      }
      $data['start_date'] = $start_date;

      $end_date = trim(strtolower($this->input->get("end_date")));
      if($end_date != "") {
        if(count($mailno_arr_target) == 0) {
          $mailno_arr_target = imap_sort($mails, SORTDATE, 1, 0, "BEFORE $end_date");
        }else {
          $mailno_arr_target = array_intersect($mailno_arr_target, imap_sort($mails, SORTDATE, 1, 0, "BEFORE $end_date"));
        }
      }
      $data['end_date'] = $end_date;

      $mailno_arr_target = array_values($mailno_arr_target);
        $mailno_arr = $mailno_arr_target;
        $data['type'] = "search";
      } else {
        $mailno_arr = imap_sort($mails, SORTDATE, 1);
      }
      $mails_cnt = count($mailno_arr);
      $data['mailno_arr'] = $mailno_arr;

      // php 페이징
      $curpage = $this->input->get("curpage");
      $mail_cnt_show = $this->input->get("mail_cnt_show");

      $curpage = ($curpage == "")? 1:$curpage;                    // 1페이지라 가정
      $total_rows = $mails_cnt;                                   // 총 16개 데이터라 가정.
      $per_page = ($mail_cnt_show == "")? 15:$mail_cnt_show;      // 한 페이지에 보여줄 데이터 갯수
      $pagingNum_cnt = 10;                                        // 페이징 블록에서의 페이징 번호 갯수 (5개로 가정하면)

      $paging_block = ceil($curpage/$pagingNum_cnt);              // 1/5 -> 1번째 페이징 블록
      $block_start = (($paging_block - 1) * $pagingNum_cnt) + 1;  // (1-1)*5 + 1 -> 1
      $block_end = $block_start + $pagingNum_cnt - 1;             // 1 + 5 -1 -> 5 (1~5)

      $total_pages = ceil($total_rows/$per_page);                 // 16/15 -> 총 2페이지

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
        for($i=$start_row; $i<$start_row+$per_page; $i++) {
          if (isset($mailno_arr[$i])) {             // 마지막 페이지에서 15개가 안될경우 오류처리
            $data['head'][$mailno_arr[$i]] = imap_headerinfo($mails, $mailno_arr[$i]);

            // 메일제목만 디코딩 따로처리
            $subject = $data['head'][$mailno_arr[$i]]->subject;
            $subject_decoded = $this->subject_decode($subject);
            $data['subject_decoded'][$mailno_arr[$i]] = $subject_decoded;

            // 첨부파일 유무 확인
            $data['attached'][$mailno_arr[$i]] = false;
            $struct = imap_fetchstructure($mails, $mailno_arr[$i]);
            if(isset($struct->parts)) {
              foreach($struct->parts as $part) {
                if($part->type === 0 && $part->ifdisposition === 1 || $part->type === 3 || $part->type === 5 && $part->ifdisposition === 1) {
                  $data['attached'][$mailno_arr[$i]] = true;
                  break;
                }
              }
            }
          }
        }
      } else {
        $data['test_msg'] = "메일이 없습니다.";
      }
      imap_close($mails);			              	// IMAP 스트림을 닫음
    }else {
      $data['test_msg'] = '사용자명 또는 패스워드가 틀립니다.';
    }
    $this->load->view('mailbox/mail_list_v', $data);
  } // function(mail_list)

  // flag 지정 (중요메일)
  public function set_flag() {
    $mbox = $this->input->get("boxname");

    if(isset($mbox)) {
      $mbox = str_replace('%26', '&', $mbox);
      $mbox = str_replace('+', ' ',  $mbox);
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

      $name         = imap_utf8($headerinfos->personal);
      // $name         = $name[0]->text;
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
    $mails= $this->connect_mailserver($mbox);
    $mails_cnt = imap_num_msg($mails);

    $data = array();
    $data['mbox'] = $mbox;
    $head = imap_headerinfo($mails, $mailno);
    $msg_no = trim($head->Msgno);

    $struct = imap_fetchstructure($mails, $msg_no);
    $data['struct'] = $struct;
    $body = imap_body($mails, $msg_no);
    $data['body'] = $body;

    // 내용 가져오는 부분
    $contents = '';       // 내용 부분 담을 변수
    $attachments = '';    // 첨부파일 부분 담을 변수

    if (isset($struct->parts)) {
      $flattenedParts = $this->flattenParts($struct->parts);  // 메일구조 평면화

      // 테스트용
      $data['flattenedParts'] = $flattenedParts;

      $html_cnt = 0;    // 발송실패 메일중 .eml파일은 뒤에 html이 또 나와 첨부파일이 출력되는 오류 처리.
      foreach($flattenedParts as $partNumber => $part) {
       switch($part->type) {
         case 0:    // the HTML or plain text part of the email
           if ($part->subtype == "PLAIN" && $part->ifdisposition == 0) {
             break;
           }else if($part->subtype == "PLAIN" && $part->ifdisposition == 1) {   // .txt 첨부파일은 여기 들어있음
             $filename = $this-> getFilenameFromPart($part);
             if ($filename) {
               $down_link = "&nbsp;<a href=\"javascript:download('{$mbox}', '{$msg_no}',
               '{$partNumber}', '{$filename}');\">".$filename.'</a><br>';
             } else {
               $down_link = "(파일명 없음)";
             }
             $attachments .= $down_link;
           }else if($part->subtype == "HTML") {
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
           }
           break;
         case 1:  // multi-part headers, can ignore  (MIXED, ALTERNATIVE, RELATED)
           break;
         case 2:  // attached message headers, can ignore (.eml 첨부파일은 2로 넘어와서 break 해제하면 되는데)
           //break;                                         // 그렇게되면 다른부분 또 애러 생겨서 우선 살려둠
         case 3: // application	(엑셀, 파워포인트등 첨부파일은 3임)
         case 4: // audio
         case 5: // image		(PNG 인라인출력 or 첨부 모두 type이 5임. 여기서는 삽입된거만 처리 첨부는 아래로 내려감)
           if ($part->ifdisposition == 0 || $part->disposition == "inline") {

             $img_data = imap_fetchbody($mails, $msg_no, $partNumber);

             // 리턴, 줄개행코드 제거. $img_data에 이게 있으면 애러발생함(HTML로 보내질때)
             $img_data = str_replace("\r\n", " ", $img_data);

             // contents의 기존 src 속성값을 이미지 데이터로 교체후 contents 변수에 다시 넣어줌
             // 삽입된 이미지의 경우 디코딩 안하고 fetchbody으로 추출한 내용을 src에 아래처럼 넣어줌
             $pattern = '/src="cid:[a-zA-Z0-9.@]+"/';
             preg_match_all($pattern, $contents, $matches);
             if(isset($matches[0][0]))
              $contents = str_replace($matches[0][0], "src='data:image/png;base64,$img_data'", $contents);
             break;
           }
         case 6: // video
         case 7: // other (첨부파일)
           $filename = $this-> getFilenameFromPart($part);
           if ($filename) {
             $down_link = "&nbsp;<a href=\"javascript:download('{$mbox}', '{$msg_no}',
             '{$partNumber}', '{$filename}');\">".$filename.'</a><br>';
           } else {
             $down_link = "(파일명 없음)";
           }
           $attachments .= $down_link;
         break;
       } // switch (type)
     } // foreach (part)
      $data['contents'] = $contents;
      $data['attachments'] = $attachments;
    } else {
      // MS-TNEF는 MAPI 메시지 속성을 캡슐화하기 위한 Microsoft 관련 형식. 일단 오류메시지 제거.
      if($struct->subtype == "MS-TNEF") {
        $data['contents'] = '메시지가 전부 또는 일부 받는 사람에게 도착하지 않았습니다.';
      } else {
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
      'from'        => isset($head->from[0]) ? (array)$this->to_address($head->from[0]) : array(),
      'to'          => isset($head->to) ? (array)$this->array_to_address($head->to) : array(),
      'cc'          => isset($head->cc) ? (array)$this->array_to_address($head->cc) : array(),
      'bcc'         => isset($head->bcc) ? (array)$this->array_to_address($head->bcc) : array(),
      'reply_to'    => isset($head->reply_to) ? (array)$this->array_to_address($head->reply_to) : array(),
      //'return_path' => isset($header->return_path) ? (array)$this->array_to_address($header->return_path) : [],
      // 'message_id'  => $head->message_id,
      'in_reply_to' => isset($head->in_reply_to) ? (string)$head->in_reply_to : '',
      'references'  => isset($head->references) ? explode(' ', $head->references) : array(),
      'date'        => isset($head->date) ? $head->date : '',//date('c', strtotime(substr($header->date, 0, 30))),
      'udate'       => (int)$head->udate,
      'subject'     => $this->subject_decode($head->subject),
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
    $this->load->view('mailbox/mail_detail_v', $data);
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
      case 1: return $data; // 8BIT
      case 2: return $data; // BINARY
      case 3:
        $data_decoded = base64_decode($data);
        if($charset == "euc-kr")
          $data_decoded = iconv('cp949', 'utf-8', $data_decoded);
        // $res = 'encoding: '.$encoding.'<br><br>charset: '.$charset.'<br><br>rawData: <br>'.$data.'<br>decoded: <br>'.$data_decoded;
        return $data_decoded;
      case 4:
        $data_decoded = quoted_printable_decode($data);    // QUOTED_PRINTABLE (업무일지 서식)
        if ($charset == 'ks_c_5601-1987')                  // else는 charset이 utf-8로 iconv 불필요
          $data_decoded = iconv('cp949', 'utf-8', $data_decoded);
          // 아래로 디코딩 안되는 메일 가끔 있어서 이걸로 해야함 (대표님 메일중 발견)
          // $data = iconv('euc-kr', 'utf-8', $data);  // charset 변경
        // $res = 'encoding: '.$encoding.'<br><br>charset: '.$charset.'<br><br>rawData: <br>'.$data.'<br>decoded: <br>'.$data_decoded;
        return $data_decoded;
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

    // eml형식은 따로 제외하여 html로 파일 다운로드 (eml는 outlook에서만 열리는 듯함)
    if(strpos($_POST['f_name'], '.eml')) {
      $fileSource = substr($fileSource, strpos($fileSource, 'text/html'));
      $fileSource = substr($fileSource, strpos($fileSource, 'base64')+7);
      $fileSource = substr($fileSource, 0, strpos($fileSource, '-------Boundary'));
      force_download($_POST['f_name'].'.html', imap_base64($fileSource));
    }else {
      // .svg파일의 경우 uoted_printable로 encode되어서 따로 잡아줘야 파일 다운후 정상적으로 열린다.
      $fileSource = strpos($_POST['f_name'], '.svg')? quoted_printable_decode($fileSource) : imap_base64($fileSource);
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
}


 ?>
