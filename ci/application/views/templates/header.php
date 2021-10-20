<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- 모바일 지원 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Twitter bootstrap -->
    <link href="/misc/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="/misc/css/topic.css">
    <title>header test</title>
    <style media="screen">
      /* body {
        background-color: pink;
      } */
    </style>
  </head>
  <body>
<?php
  // echo 'DOCUMENT_ROOT -> '.$_SERVER['DOCUMENT_ROOT'].'<br>';
 ?>

 <!-- 외부 js, css파일에 접근되는지 브라우저에서 확인  -->
 <!-- C:/xampp/htdocs/ci/misc/css/topic.css   ->  드라이브에 접근해서 확인
      http://ci/misc/css/topic.css    ->  서버가 해당 파일 오픈 (index.php 제외!) -->

 <!-- 외부 css파일 연동하기 -->
 <!-- 간혹가다 경로 잘 되어있는데 가져오지 못하는 경우엔 헤더에 직접 style태그 사용해서
      적용여부 보고 다시 해보면 되는경우 있음. or ★ f12 > 새로고침 우클릭 > 캐시비우기 및 강력새로고침!! -->
 <!-- 잘 연동되었는지 확인은 개발자도구 > 네트워크 탭에서 열어놓고 새로고침해보면 나옴
      가령 topic.css 눌러보면 요청 URL이 나오는데 그게 불러오는 주소임.
      즉, topic.css 더블클릭 해보면 바로 해당 파일로 접근해서 브라우저에 출력확인 가능함
      보니까 href에 "misc/~" 는 ci/index.php/misc로 접근되고 (컨트롤러로 인식됨)
                    "/misc~" 는 ci/misc로 접근됨. (경로로 인식됨)  이래서 그동안 헷갈렸던거임... -->

    <div class="container-fluid">
        <div class="row-fluid">
