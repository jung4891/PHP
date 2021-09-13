
<?php
  // include $_SERVER['DOCUMENT_ROOT'].'/스터디/8. MySQL/connectDB.php';
  include 'connectDB.php';

 
  // 테이블 목록 보기
  $sql = 'SHOW TABLES';
  $res = $mysqli->query($sql);

  if ($res) {
    $list = $res->fetch_array(MYSQLI_NUM);
    echo "테이블 목록 <br>";
    echo count($list);
    echo '<pre>';
    echo var_dump($list);
    echo '</pre>';
    for ($i = 0; $i<(count($list) - 1); $i++) {
      echo $list[$i];
      echo '<br>';
    }
  } else {
    echo "테이블 존재 안함";
  }
 ?>
