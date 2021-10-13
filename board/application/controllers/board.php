<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// 게시판 메인 컨트롤러
class Board extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->database();
  }

  // 주소에서 메서드 생략시 실행되는 기본 메서드
  public function index() {
    $this->lists();
  }

  public function lists() {
    $this->load->view('board/list_v');
  }
}
