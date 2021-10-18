<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// 공통 게시판 모델
class Board_m extends CI_Model {
  function __construct() {
    parent::__construct();
  }

  function get_list($table='ci_board') {      // argument가 없을때 디폴트 적용
    // echo var_dump($table===null);          // true;  argument에 없는 segment넣으면 NULL들어감
    // echo var_dump($table=='');             // 근데 이것도 true가 나오긴 함
    $sql = "SELECT * FROM {$table} ORDER BY board_id DESC";
    $result = $this->db->query($sql)->result();
    return $result;
  }
}
