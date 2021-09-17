<?php
  include "./connectDB.php";
  // $phone과 birthday 0 넣기
  // myMember 테이블에 데이터 입력

  echo $_POST['date1'];

  // 폰번호 010123(4)5555 -> 010-123(4)-5555
  $phone = $_POST['phone'];
  $phone_length = strlen($phone);
  if ( $phone_length == 10 OR $phone_length  == 11) {
    $head = substr($phone, 0, 3);       // 010
    $mid = substr($phone, 3, -4);       // 7124 or 712(3자)
    $tail = substr($phone, -4);         // 4891
    $phone = $head.'-'.$mid.'-'.$tail;
  }
  // 생년월일 -로 묶기
  $birth = $_POST['birth_year'].'-'.$_POST['birth_month'].'-'.$_POST['birth_day'];
  $query = "insert into mymember
            (userid, name, password, phone, email, birthday, gender, regtime) values
            ('{$_POST['id']}', '{$_POST['name']}', '{$_POST['pw']}', '{$phone}',
             '{$_POST['email']}', '{$birth}', '{$_POST['gender']}', now())";
  $res = $mysqli->query($query);
  if ($res) {
    echo "[insert 성공] <br>";
    echo $query.'<br>';
  } else {
    echo "[insert 실패] <br>";
    echo $query.'<br>';
    echo mysqli_error($mysqli);
  }
  echo '<br>';

  // prodReview 테이블에 textarea데이터 입력
  $text = addslashes($_POST['longtext']);   // 따옴표 앞에 \추가되어 문자열로 인식함
  $query = "insert into prodreview(content, regtime) values ('{$text}',NOW())";
  $res = $mysqli->query($query);
  if ($res) {
    echo "[textarea insert 성공] <br>";
    echo $query.'<br>';
  } else {
    echo "[textarea insert 실패] <br>";
    echo $query.'<br>';
    echo mysqli_error($mysqli);
  }
  echo '<br>';

  // prodReview 테이블의 데이터 불러와 출력
  $query = "select * from prodreview ORDER BY prodReviewID DESC LIMIT 1"; // 마지막입력된 내용
  $res = $mysqli->query($query);

  $review = $res->fetch_array(MYSQLI_ASSOC);
  echo nl2br($review['content']).'<br>';    // 엔터 친곳에 \n이 있는데 이를 <br>태그로 변경

  // textArea 내용 파일로 저장

 ?>
