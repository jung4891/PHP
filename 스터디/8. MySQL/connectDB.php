<?php 
  $host = 'localhost';
  $user = 'root';
  $pw = 'root';
  $dbName = 'php200';
  $mysqli = new mysqli($host, $user, $pw, $dbName);
  $mysqli->set_charset('utf8');

  if (mysqli_connect_errno()) {
    echo "db_$dbName 접속 실패 <br>";
    echo mysqli_connect_error();
  } else {
    echo "db 접속성공 <br>";
  }
 ?>
