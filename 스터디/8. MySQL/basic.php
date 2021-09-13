<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      connect_mysql();
      // create_db('php200');
      // connect_db('php200');


      // 고객테이블 생성
      // txt파일에 ""있으면 오류남. 쿼테이션 빼야함.
      // $sql_createCustomerTBL = get_file('createCustomerTBL.txt');
      // execute_query('php200', $sql_createCustomerTBL);

      function get_file($fileName) {
        if (file_exists($fileName)) {
          $fopen = fopen($fileName, 'r+');
          if ($fopen) {
            $fread = fread($fopen, filesize($fileName));
            if ($fread) {
              fclose($fopen);
              return $fread;
            } else { echo "파일 읽기에 실패했습니다.";}
          } else { echo "파일 열기에 실패했습니다.";}
        } else { echo "파일이 존재하지 않습니다.";}
      }

      // MySQL 접속
      // PHP에서는 mysqli라는 클래스가 MySQL에 접속할 수 있는 기능을 갖고 있다.
      // $dbConnect = new mysqli(호스트, 유저명, 비밀번호);
      function connect_mysql() {
        $host = 'localhost';
        $user = 'root';
        $pw = 'root';
        $dbConnect = new mysqli($host, $user, $pw);    // MySQL 접속
        $dbConnect->set_charset('utf8');

        if (mysqli_connect_errno()) {   // 접속 여부를 알려주는 함수
          echo 'DB 접속 실패 <br>';
          echo mysqli_connect_error();
        } else {
          echo '접속 성공 <br>';
        }
      }

      // 데이터베이스 생성
      // 쿼리문을 실행하려면 mysqli클래스의 query메소드를 사용함.
      function create_db($dbName) {
        $host = 'localhost';
        $user = 'root';
        $pw = 'root';
        $mysqli = new mysqli($host, $user, $pw);
        $mysqli->set_charset('utf8');

        $sql = "create database {$dbName}";
        $res = $mysqli->query($sql);

        if ($res) {
          echo "db_{$dbName} 생성완료 <br>";
        } else {
          echo "db 생성실패 <br>";
        }
      }

      // 데이터베이스 접속
      function connect_db($dbName) {
        $host = 'localhost';
        $user = 'root';
        $pw = 'root';
        $mysqli = new mysqli($host, $user, $pw, $dbName);
        $mysqli->set_charset('utf8');

        if (mysqli_connect_errno()) {
          echo "db_$dbName 접속 실패 <br>";
          echo mysqli_connect_error();
        } else {
          echo "db_$dbName 접속 성공! <br>";
        }
      }

      // 쿼리 실행 함수
      // include $_SERVER['DOCUMENT_ROOT'].'/8. MySQL/connectDB.php';
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

     ?>
  </body>
</html>
