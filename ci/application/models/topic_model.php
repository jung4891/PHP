<?php

// 보통 모델명은 데이터를 핸들링할 테이블명_model로 지음
// 테이블마다 하나씩 모델을 생성함.
// 그리고 꼭 class이름은 앞글자는 대문자로!! CI_Model은 꼭 상속해야함!

class Topic_model extends CI_Model {
  function __construct() {    // 생성자는 메소드마다 공통되는 작업 넣어서 초기화하면됨
    parent::__construct();
  }

  public function gets(){
    // $this->db->query()    // 현재 설정한 데이터베이스에 접속해서 쿼리실행
    // result()        // 질의를 통해 가져온 결과값을 result()방식(객체형태)으로 가져온다
    return $this->db->query("SELECT * FROM topic")->result();
    // result_array()  // array형태로 가져옴
    // $this->db->get('topic')->result();
  }

  public function get($topic_id){
    // Active Record 방식으로 표준 SQL문을 사용하기때문에 타 db와의 이식성, 호환성이 좋다.
    // 단 한건의 row만 가져오기에 row()를 사용하면 된다.
    return $this->db->get_where('topic', array('id'=>$topic_id))->row();  // 객체로 받게된다
    // =
    // return $this->db->query("SELECT * FROM topic WHERE id =".$topic_id)->row();
  }

  // Pagination
  public function count_users() {
    return $this->db->count_all("user");    // 특정테이블의 레코드 수를 리턴
  }
  public function fetch_users($limit, $start) {
    $this->db->limit($limit, $start);
    // 아래에서 db->query(~~) 이런식으로 하면 작동안함. (이럴땐 쿼리문에 변수에 넣어야함)
    // limit(int) -> SELECT * FROM table LIMIT int;
    // limit(5, 2) ->  SELECT * FROM table LIMIT 5 OFFSET 2 (3번째부터(인덱스(2)) 5개)
    return $this->db->get('user')->result();
  }


}
