<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->model('todo_m');
    $this->load->helper(array('url', 'date'));
  }

  public function index() {
    echo 'aa';
    $this->lists();
  }

  // todo 리스트 불러옴
  // 뷰에 데이터를 넘길 때는 꼭!! 2차 배열 형태로 넘겨야함!!
  public function lists() {
    $data['list'] = $this->todo_m->get_list();
    $this->load->view('templates/header_todo');
    $this->load->view('todo/list_v', $data);
    $this->load->view('templates/footer_todo');
    // $num = 11;
    // echo "('{$num}', '{$num}')";
  }

  // todo 항목 조회 (view_row($id)로도 된다. 전달할때 view_row(안에 argument넣으면 된다))
  // uri라이브러리는 주소 처리에 관련된 라이브러리로 코드이그나이터 시작시 자동으로 로딩됨
  // segment(0)은 index.php부분을 가리킨다. segment는 주소에서 /로 구분된 내용을 일컬음
  function view_row() {
    $id = $this->uri->segment(3);
    $data['row'] = $this->todo_m->get_row($id);
    $this->load->view('templates/header_todo');
    $this->load->view('todo/row_v', $data);
    $this->load->view('templates/footer_todo');
  }

  // 쓰기
  function write() {
      if ($_POST) {
        // 글쓰기로 POST 보내서 받는경우
        // $content = $_POST['content'];
        $content = $this->input->post('content', TRUE); // TRUE는 XXS공격을 막을 수 있게 자동처리함 (무조건 사용)
        $created_on = $this->input->post('created_on', TRUE);
        $due_date = $this->input->post('due_date', TRUE);

        $this->todo_m->insert_todo($content, $created_on, $due_date);
        redirect('/todo/lists');
        // redirect('http://local/todo/index.php/main/lists');
        // redirect('/main/lists');   // 요렇게 할 경우 localhost/todo/index.php/main~ 요렇게 감
        // redirect는 CI의 url헬퍼의 함수. JS의 document.location.href와 같은 역할을 함.
        exit;
      } else {
        // POST 받는게 없는경우엔 쓰기 폼 호출됨
        $this->load->view('todo/write_v');
      }
  }

  function select_test() {
    // php.ini > max_input_time=600 으로 수정(기본 60초는 넘 짧음)
    $start = $this->get_time();
    set_time_limit(0);  // 2분이상 되어도 멈추지 않게함

    // $user_id = "jwjung@durianit.co.kr";
    $user_id = "test4@durianict.co.kr";
    $user_id = substr($user_id, 0, strpos($user_id, '@'));

    // $mbox = "&vPSwuA- &07jJwNVo-";
    $mbox = "INBOX.test1";
    $mails = $this->connect_mailserver($mbox);
    $mailno_arr = imap_sort($mails, SORTDATE, 1);

    // 1) 동기화

    // 메일서버와 db에서 메일ID정보 가져오기
    $mail_arr_server = array();
    // $mailNO_arr_server = array();
    foreach($mailno_arr as $no) {
      $header = imap_headerinfo($mails, $no);
      $mail_no = trim($header->Msgno);
      if(isset($header->message_id)) {
        $mail_id = $header->message_id;
      }else {     // 보낸메일의 경우 message_id가 없어서 임의로 id 생성함.
        $mail_id = $header->udate."_".$header->Size;
      }
      $mail_arr_server[$mail_no] = $mail_id;
      // array_push($mailID_arr_server, $mail_id);
      // array_push($mailNO_arr_server, $mail_no);
    }
    // echo '<pre>';
    // var_dump($mail_arr_server);
    // // var_dump($mailNO_arr_server);
    // echo '</pre>';
    // exit;

    $mailID_arr_db = array();
    $mailID_arr_tmp = $this->todo_m->get_mailID_arr($user_id, $mbox);
    foreach($mailID_arr_tmp as $arr) {
      array_push($mailID_arr_db, $arr["mail_id"]);
    }
    // echo '<pre>';
    // var_dump($mailID_arr_db);
    // echo '</pre>';
    // exit;

    // 새로온 메일, 삭제된 메일 조회
    $mail_arr_add = array_diff($mail_arr_server, $mailID_arr_db);
    // $mailID_arr_add = array_diff($mailID_arr_server, $mailID_arr_db);
    $mail_arr_del = array_diff($mailID_arr_db, $mail_arr_server);
    echo '새로운 메일 개수(서버-db): '.count($mail_arr_add).'<br>';
    echo '삭제된 메일 개수(db-서버): '.count($mail_arr_del).'<br>';
    // echo '<pre>';
    // var_dump($mail_arr_add);
    // var_dump($mail_arr_del);
    // echo '</pre>';
    // exit;

    // 새로온 메일의 경우 db에 insert.
    if(count($mail_arr_add) > 0) {
    //   $mail_arr_add = array();
    //   foreach($mailID_arr_add as $id) {
    //       $index = array_search($id, $mailID_arr_server);
    //       $tree = array(
    //         // "name" => $folders[$i],
    //         "id" => $mailID_arr_server[$index],
    //         "no" => $mailNO_arr_server[$index]
    //       );
    //       array_push($mail_arr_add, $tree);
    //   }
    //   echo '<pre>';
    //   var_dump($mail_arr_add);
    //   echo '</pre>';
    // exit;

      // for($i=3000; $i<3001; $i++) {
      // for($i=0; $i<count($mail_no); $i++) {
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
        $this->todo_m->insert_mail($user_id, $mbox, $mail_id, $contents);
        // if($i == 2000) {
        //   // echo '일단 스톱';
        //   // break;
        // }
        // echo $i.'<br>';
      }
      imap_close($mails);
    }

    // 삭제된 메일의 경우 db에서 delete.
    if(count($mail_arr_del) > 0) {
      foreach($mail_arr_del as $mail_id) {
        $this->todo_m->delete_mail($user_id, $mbox, $mail_id);
      }
      // echo '삭제된 메일 db delete 완료<br>';
    }

    // 2) db에서 검색후 server에서 msgno 가져오기
    $search_word = '재택치료';
    $mailID_arr_tmp = $this->todo_m->get_mailID_arr_search($user_id, $mbox, $search_word);
    $mailID_arr = array();
    foreach($mailID_arr_tmp as $arr) {
      array_push($mailID_arr, $arr["mail_id"]);
      // array_push($mailID_arr, htmlspecialchars($arr["mail_id"]));
    }
    $mailNO_arr_res = array();
    foreach($mailID_arr as $id) {
      $index = array_search($id, $mail_arr_server);
      array_push($mailNO_arr_res, $index);
    }
    $end = $this->get_time();
    $time = $end - $start;
    echo "<br>검색 소요시간 : ".number_format($time,2) . "초<br>";
    echo '<br>검색 결과<br>';
    var_dump($mailNO_arr_res);
    // db 3800개(4초)
    // 새로운메일 100개, 삭제된 메일 100개 -> 5.16초
    // 새로운메일 10개, 삭제된 메일 10개 -> 0.72초
  }

  public function connect_mailserver($mbox="") {
    $mailserver = "192.168.0.100";
    $user_id = "jwjung@durianit.co.kr";
    $user_pwd = "bogus2011";
    // $mailserver = "192.168.0.50";
    // $user_id = "test4@durianict.co.kr";
    // $user_pwd = "durian12#";
    $host = "{" . $mailserver . ":143/imap/novalidate-cert}$mbox";
    return @imap_open($host, $user_id, $user_pwd);
  }

  function insert_all() {
    $start = $this->get_time();
    set_time_limit(0);  // 2분이상 되어도 멈추지 않게함

    $user_id = "jwjung@durianit.co.kr";
    $mailserver = "192.168.0.100";
    // $user_id = "test4@durianict.co.kr";
    // $mailserver = "192.168.0.50";

    $user_id = substr($user_id, 0, strpos($user_id, '@'));

    $mails= $this->connect_mailserver();
    $folders = imap_list($mails, "{" . $mailserver . "}", '*');
    $folders = str_replace("{" . $mailserver . "}", "", $folders);
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
          $mbox = mb_convert_encoding($f, 'UTF-8', 'UTF7-IMAP');
          if($cnt_each != $mails_cnt) {
            $sql .= " ('$user_id', '$mbox', '$mail_id', '$contents'), ";
          }else {
            $sql .= " ('$user_id', '$mbox', '$mail_id', '$contents')";
          }
          $cnt_all++;
        }
        // echo $sql.'<br><br>';
        // echo htmlspecialchars($sql);
        // echo '<br>================================<br><br><br>';
        $this->todo_m->insert_mail_all($sql);
      }
    }
    $end = $this->get_time();
    $time = $end - $start;
    echo "모든메일 INSERT : ".$cnt_all."개<br>";
    echo "소요시간 : ".number_format($time,2) . "초<br>";
    // 3800개(417초. 7분)  1200개 (68초)
    // 3841/3756(실제 insert)(434초)
    // 배열로 보내 insert 한번만 해도 1000개 44초 걸림. (max_allowed_packet=1M -> 16M로 변경해야함)
  }

  function insert_each($mbox, $mail_arr) {
    $mails = $this->connect_mailserver($mbox);
    foreach($mail_arr as $mail) {
      $mail_id = $mail['id'];
      $mail_no = $mail['no'];
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
      $this->todo_m->insert_mail($mbox, $mail_id, $contents);
    }
  }


  function getPart($connection, $messageNumber, $partNumber, $encoding, $charset) {
    $data = imap_fetchbody($connection, $messageNumber, $partNumber);
    $body = imap_body($connection, $messageNumber);

    switch($encoding) {
      case 0: return $data; // 7BIT
      case 1: return $data; // 8BIT
      case 2: return $data; // BINARY
      case 3:
        $data = base64_decode($data);
        if($charset == "EUC-KR")
          $data = iconv('cp949', 'utf-8', $data);
        return $data;
      case 4:
        $data = quoted_printable_decode($data);    // QUOTED_PRINTABLE (업무일지 서식)
        if ($charset == 'ks_c_5601-1987')          // else는 charset이 utf-8로 iconv 불필요
          $data = iconv('cp949', 'utf-8', $data);
        return $data;
      case 5: return $data; // OTHER
    }
  }

  public function flattenParts($messageParts, $flattenedParts = array(), $prefix = '', $index = 1, $fullPrefix = true) {
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

  function get_time() { $t=explode(' ',microtime()); return (float)$t[0]+(float)$t[1]; }



  // 수정
  function update($id) {
      if ($_POST) {
        $id = $this->input->post('id', TRUE);
        $content = $this->input->post('content', TRUE);
        $created_on = $this->input->post('created_on', TRUE);
        $due_date = $this->input->post('due_date', TRUE);

        $this->todo_m->update_todo($id, $content, $created_on, $due_date);
        redirect('http://local/todo/index.php/main/lists');
        exit;
      } else {
        $data['row'] = $this->todo_m->get_row($id);
        $this->load->view('todo/update_v', $data);
      }
  }

  // 삭제
  function delete() {
    $id = $this->uri->segment(3);
    $this->todo_m->delete_todo($id);
    redirect('http://local/todo/index.php/main/lists');
  }

}
