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

  public function connect_mailserver($mbox="INBOX") {
    $mailserver = "192.168.0.50";
    $host = "{" . $mailserver . ":143/imap/novalidate-cert}$mbox";
    $user_id = "test2@durianict.co.kr";
    $user_pwd = "durian12#";
    return @imap_open($host, $user_id, $user_pwd);
  }

  function select_test() {
    $mbox = "INBOX";
    $mails = $this->connect_mailserver($mbox);
    $mailno_arr = imap_sort($mails, SORTDATE, 1);

    $mailID_arr_server = array();
    // var_dump($mailno_arr);
    foreach($mailno_arr as $no) {
      $header = imap_headerinfo($mails, $no);
      $mail_id = htmlspecialchars($header->message_id);
      array_push($mailID_arr_server, $mail_id);
    }
    $mailID_arr_db = array();
    $mailID_arr_tmp = $this->todo_m->get_mailID($mbox);
    foreach($mailID_arr_tmp as $arr) {
      array_push($mailID_arr_db, htmlspecialchars($arr["mail_id"]));
    }

    $mailID_arr_add = array_diff($mailID_arr_server, $mailID_arr_db);
    $mailID_arr_del = array_diff($mailID_arr_db, $mailID_arr_server);
    echo '서버 메일개수: '.count($mailID_arr_server).'<br>';
    echo 'DB 메일개수: '.count($mailID_arr_db).'<br>';
    echo '새로운 메일 개수(서버-db): '.count($mailID_arr_add).'<br>';
    echo '삭제된 메일 개수(db-서버): '.count($mailID_arr_del);

    // db에서 검색
    // $mailno_arr_res = array();
    // foreach($mailno_arr as $no) {
    //   $header = imap_headerinfo($mails, $no);
    //   $mail_id = htmlspecialchars($header->message_id);
    //   if(in_array($mail_id, $mail_id_arr)) {
    //     array_push($mailno_arr_res, $no);
    //   }
    // }
    // var_dump($mailno_arr_res);
  }

  function insert_test() {
    $start = $this->get_time();
    set_time_limit(0);

    $mbox = "INBOX";
    $mails = $this->connect_mailserver($mbox);
    $mailno_arr = imap_sort($mails, SORTDATE, 1);
    // echo ini_get('max_execution_time');
    // exit;
    $cnt = 0;
    // $mail_id_arr = array();
    // $contents_arr = array();
    foreach($mailno_arr as $index => $no) {
      $header = imap_headerinfo($mails, $no);
      $mail_id = $header->message_id;
      // array_push($mail_id_arr, $mail_id);
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
      // array_push($contents_arr, $contents);
      $this->todo_m->insert_test($mbox, $mail_id, $contents);
      // if($cnt == 1000)   break;
      $cnt++;
    }
    // $this->todo_m->insert_test($mbox, $mail_id_arr, $contents_arr);
    $end = $this->get_time();
    $time = $end - $start;
    echo "INSERT : ".$mbox." -> ".$cnt."개<br>";
    echo "소요시간 : ".number_format($time,2) . "초<br>";
    echo '완료';
    // 1000개(45초), 3000개(150초)
    // 배열로 보내 insert 한번만 해도 1000개 44초 걸림. (max_allowed_packet=1M -> 16M로 변경해야함)
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

}
