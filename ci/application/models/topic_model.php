<?php

// 보통 모델명은 데이터를 핸들링할 테이블명_model로 지음
// 테이블마다 하나씩 모델을 생성함.
// 그리고 꼭 class이름은 앞글자는 대문자로!! CI_Model은 꼭 상속해야함!

class Topic_model extends CI_Model {
  function __construct() {    // 생성자는 메소드마다 공통되는 작업 넣어서 초기화하면됨
    parent::__construct();
  }

  public function gets(){
    // $this->db->     // 현재 설정한 데이터베이스에 접속해서 쿼리실행

    // result()        // 질의를 통해 가져온 결과값을 result()방식(객체형태)으로 가져온다
    return $this->db->query("SELECT * FROM topic")->result();

    // result_array()  // array형태로 가져옴
    // return $this->db->query("SELECT * FROM topic")->result_array();

  }
}
