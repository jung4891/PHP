
<?php
  // show_tables();
  // desc();

  // 테이블 삭제
  $create_table = 'CREATE TABLE test2 (no varchar(10) NOT NULL)';
  $drop_table = 'DROP TABLE test';
  execute_query('php200', $drop_table);

  // 테이블 필드 삭제
  $alter_drop = 'ALTER TABLE customer DROP nationality';

  // 테이블 필드 옵션 변경
  $alter_modify = 'ALTER TABLE customer MODIFY nationality varchar(15) COMMENT "국적"';

  // 테이블 필드명 변경
  $alter_change = 'ALTER TABLE customer CHANGE currentAge nationality ';
  $alter_change .= 'int COMMENT "국적 정보"';

  // 테이블 필드 추가
  // AFTER 안적으면 제일 뒤에 위치하게됨.
  $alter_add = 'ALTER TABLE customer ADD currentAge ';
  $alter_add .= 'int unsigned COMMENT "현재 나이" AFTER gender';


  function execute_query($dbName, $sql) {
    $host = 'localhost';
    $user = 'root';
    $pw = 'root';
    $mysqli = new mysqli($host, $user, $pw, $dbName);   // db접속
    $mysqli->set_charset('utf8');

    if ($mysqli->query($sql)) {
      echo "쿼리 실행완료~!";
    } else {
      echo "쿼리 실행실패..";
      echo mysqli_error($mysqli);   // 쿼리 오류메시지 띄움
    }
  }

  // 테이블 구조 보기
  function desc() {
    include 'connectDB.php';
    $query = 'DESC customer';
    $res = $mysqli->query($query);

    while ($list = $res->fetch_array(MYSQLI_ASSOC)) {
      echo '필드명: '.$list['Field'].'<br>';
      echo '타입  : '.$list['Type'].'<br>';
      echo 'NULL  : '.$list['Null'].'<br>';
      echo 'Key   : '.$list['Key'].'<br>';
      echo '기본값: '.$list['Default'].'<br>';
      echo '기타  : '.$list['Extra'].'<br>';
      echo '<br>';
    };
  }

  // 테이블 목록 보기
  // fetch_array() : 실행결과를 배열에 담아 $row에 들어가게 됨.
  // MYSQLI_NUM(ASSOC/BOTH) -> 인덱스를 숫자(문자/둘다)로 사용
  function show_tables() {
    include 'connectDB.php';
    // include $_SERVER['DOCUMENT_ROOT'].'/스터디/8. MySQL/connectDB.php';
    $query = 'SHOW TABLES';
    $res = $mysqli->query($query);

    if ($res) {
      echo "테이블 목록 <br>";
      while($row = $res->fetch_array(MYSQLI_NUM)) {
        echo $row[0].'<br>';
      }
    } else {
      echo "테이블 존재 안함 <br>";
    }
  }
 ?>
