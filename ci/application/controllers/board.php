<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// 게시판 메인 컨트롤러
class Board extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->model('board_m');
  }

  // 주소에서 메서드 생략시 실행되는 기본 메서드
  public function index() {
    $this->lists();
  }

  // header와 footer 자동으로 추가됨
  public function _remap($method) {
    $this->load->view('board/header_v');         // header include
    if( method_exists($this, $method) ) {  // 메소드 있을시 로드되는 뷰에 다 적용됨
      $this->$method();
      // $this->{"{$method}"}();           // 교재
    }
    $this->load->view('board/footer_v');
  }

  public function lists() {
    echo 'test<br>';

    // $data['list'] = $this->board_m->get_list();
    $data['list'] = $this->board_m->get_list($this->uri->segment(3));
    // http://ci/board/lists/ci_board
    // segment    1      2      3     (0은 index.php인데 현재 virtualhost에 의해 생략되어 null임)
    $this->load->view('board/list_v', $data);
  }
}
