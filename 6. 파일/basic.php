<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

      // include "파일경로 및 파일명" : 공통의 기능을 하는 파일을 다른 곳에서 불러올때.
      // include_once : 이전에 불러온적이 없으면 불러오고 한번이라도 있으면 실행안됨.
      // include "./hello.php";
      // include_once "./hello.php";

      // include와 require
      // include는 불러오는 파일명이나 경로에 문제가 있어도 오류안나고 실행은 됨.
      // require는 오류가 발생하여 그 이후로는 로드가 되지 않음.
      echo "test1 ~~";
      require "./hello2.php";
      echo "test2 ~~";

     ?>
  </body>
</html>
