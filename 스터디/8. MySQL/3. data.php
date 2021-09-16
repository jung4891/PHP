<?php

  include 'connectDB.php';

  // 데이터 출력
  $select = "SELECT name, id FROM customer WHERE name LIKE '송_'";
  $res = $mysqli->query($select);
  $dataCount = $res->num_rows;    // 불러온 레코드의 수를 반환함

  for ($i=0; $i < $dataCount; $i++) {
    $member_info = $res->fetch_array(MYSQLI_ASSOC);
    echo "이름: ".$member_info['name']."<br>";
    echo "아이디: ".$member_info['id']."<hr>";
  }

  // 데이터 입력
  $insert = "insert into customer ";
  $insert .= "(id, name, password, phone, email, birthday, gender, regtime) values ";
  
  $member = array();
  $member[0] = "('id_1', '송1', '1234', '010-1111-2222', ";
  $member[0] .= "'go_go_ssing@naver.com', '1990-02-18', 'm', now())";
  $member[1] = "('id_2', '송2', '2345', '010-2222-3333', ";
  $member[1] .= "'go_go_ssing2@naver.com', '1992-02-18', 'w', now())";

  // foreach($member as $m) {
  //   $query = $insert.$m;
  //   execute_query('php200', $query);
  // }

  function execute_query($dbName, $sql) {
    $host = 'localhost';
    $user = 'root';
    $pw = 'root';
    $mysqli = new mysqli($host, $user, $pw, $dbName);
    $mysqli->set_charset('utf8');

    if ($mysqli->query($sql)) {
      echo "쿼리 실행완료~! <br>";
    } else {
      echo "쿼리 실행실패.. <br>";
      echo mysqli_error($mysqli);
    }
  }

 ?>
