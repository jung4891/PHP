<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

      // $_SERVER는 슈퍼 글로벌 변수 중 하나.
      // 슈퍼 글로벌 변수는 PHP 자체적으로 내장된 변수이며 데이터형은 배열이다.
      // 인덱스 값에 따라 여러 정보를 획득할 수 있다.

      echo 'DOCUMENT_ROOT -> '.$_SERVER['DOCUMENT_ROOT'].'<br>';  // 현재 실행파일의 경로
      echo 'HTTP_ACCEPT_LANGUAGE -> '.$_SERVER['HTTP_ACCEPT_LANGUAGE'].'<br>';
      echo 'HTTP_HOST -> '.$_SERVER['HTTP_HOST'].'<br>';
      echo 'HTTP_USER_AGENT -> '.$_SERVER['HTTP_USER_AGENT'].'<br>';
      echo 'SERVER_PORT -> '.$_SERVER['SERVER_PORT'].'<br>';
      echo 'SCRIPT_NAME -> '.$_SERVER['SCRIPT_NAME'].'<br>';
      echo 'REQUEST_URI -> '.$_SERVER['REQUEST_URI'].'<br>';
      echo 'PHP_SELF -> '.$_SERVER['PHP_SELF'].'<br>';         // 루트 디렉토리의 현재 실행중인 파일의 경로와 파일명
      echo 'QUERY_STRING -> '.$_SERVER['QUERY_STRING'].'<br>'; // 검색인수 표시
      echo 'REMOTE_ADDR -> '.$_SERVER['REMOTE_ADDR'].'<br>';   // 페이지에 접속한 사용자의 IP주소
      echo 'SERVER_ADDR -> '.$_SERVER['SERVER_ADDR'].'<br>';   // 현재 사용 중인 서버의 IP주소

     ?>
  </body>
</html>
