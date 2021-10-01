<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->model('todo_m');
    $this->load->helper(array('url', 'date'));
  }

  public function index() {
    $this->lists();
  }

  // todo 리스트 불러옴
  // 뷰에 데이터를 넘길 때는 꼭!! 2차 배열 형태로 넘겨야함!!
  public function lists() {
    $data['list'] = $this->todo_m->get_list();
    $this->load->view('templates/header');
    $this->load->view('todo/list_v', $data);
    $this->load->view('templates/footer');
  }

  // todo 항목 조회
  // uri라이브러리는 주소 처리에 관련된 라이브러리로 코드이그나이터 시작시 자동으로 로딩됨
  // segment(0)은 index.pop부분을 가리킨다. segment는 주소에서 /로 구분된 내용을 일컬음
  function view_row() {
    $id = $this->uri->segment(3);
    $data['row'] = $this->todo_m->get_row($id);
    $this->load->view('todo/row_v', $data);
  }
// view_row($id)로 해보기
}
