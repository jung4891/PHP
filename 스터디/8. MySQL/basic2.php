
<?php
  // include $_SERVER['DOCUMENT_ROOT'].'/스터디/8. MySQL/connectDB.php';
  include 'connectDB.php';

  // 테이블 목록 보기
  // fetch_array() : 실행결과를 배열에 담아 $row에 들어가게 됨.
  //                 각 배열인 $row가 $rows배열에 들어가게 되는 구조
  // MYSQLI_NUM(ASSOC/BOTH) -> 인덱스를 숫자(문자/둘다)로 사용
  $query = 'SHOW TABLES';
  $res = $mysqli->query($query);

  if ($res) {
    while($row = $res->fetch_array(MYSQLI_NUM)) {
      $rows[] = $row;
    }
    // echo '<pre>';
    // echo var_dump($rows);
    // echo '</pre>';
    echo "테이블 목록 <br>";
    foreach($rows as $row) {
      echo $row[0].'<br>';
    }
  } else {
    echo "테이블 존재 안함";
  }
 ?>
