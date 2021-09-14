<?php
  $host = 'localhost';
  $user = 'root';
  $pw = 'root';
  $dbName = 'php200';
  $mysqli = new mysqli($host, $user, $pw, $dbName);
  $mysqli->set_charset('utf8');

  /* check connection */
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  } else {
    echo "[db 접속성공] <br><br>";
  }
 ?>
