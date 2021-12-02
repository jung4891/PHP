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
        // TRUE는 XXS공격을 막을 수 있게 자동처리함 (무조건 사용)
        $content = $this->input->post('content', TRUE);
        $created_on = $this->input->post('created_on', TRUE);
        $due_date = $this->input->post('due_date', TRUE);

        $this->todo_m->insert_todo($content, $created_on, $due_date);
        redirect('http://local/todo/index.php/main/lists');
        // redirect('/main/lists');   // 요렇게 할 경우 localhost/todo/index.php/main~ 요렇게 감
        // redirect는 CI의 url헬퍼의 함수. JS의 document.location.href와 같은 역할을 함.

        exit;
      } else {
        // POST 받는게 없는경우엔 쓰기 폼 호출됨
        $this->load->view('todo/write_v');
      }
  }

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
