<?php
  include "./connectDB.php";

  // 폰번호 010123(4)5555 -> 010-123(4)-5555
  $phone = $_POST['phone'];
  $phone_length = strlen($phone);
  if ( $phone_length == 10 OR $phone_length  == 11) {
    $head = substr($phone, 0, 3);       // 010
    $mid = substr($phone, 3, -4);       // 1234 or 123(3자)
    $tail = substr($phone, -4);         // 5555
    $phone = $head.'-'.$mid.'-'.$tail;
  }
  // myMember테이블에 form데이터들 입력
  $query = "insert into mymember
            (userid, name, password, phone, email, birthday, gender, regtime) values
            ('{$_POST['id']}', '{$_POST['name']}', '{$_POST['pw']}', '{$phone}',
             '{$_POST['email']}', '{$_POST['date']}', '{$_POST['gender']}', now())";
  $res = $mysqli->query($query);
  if ($res) {
    echo "[insert 성공] <br>";
    // echo $query.'<br>';
  } else {
    echo "[insert 실패] <br>";
    // echo $query.'<br>';
    echo mysqli_error($mysqli);
  }

 ?>
