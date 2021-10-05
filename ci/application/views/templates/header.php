<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="\misc\js\jquery.bpopup-0.1.1.min.js"></script>
    <!-- <script src="jquery.bpopup-0.1.1.min.js"></script> 이렇게 하면 안됨 -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bPopup/0.11.0/jquery.bpopup.js"></script> -->
    <title>header test</title>
  </head>
  <body>
    <?php
      // echo 'DOCUMENT_ROOT -> '.$_SERVER['DOCUMENT_ROOT'].'<br>';
     ?>

     <!-- 경로를 application안으로는 접근이 안된다. CI 내부구조가 그렇게 되어 있는듯 -->
     <!-- 아예 최상위 아래 application폴더와 같은 위치에 폴더를 만들어 접근해야 함 -->
     <!-- 위 스크립트처럼(8line) 이 파일 위치하는 곳에 가져올 js파일 두고 가져와도 소용없음 -->
     <!-- <img src="/misc/img/menu_icon.png" style="width:75px;height:75px;cursor:pointer;"> -->
