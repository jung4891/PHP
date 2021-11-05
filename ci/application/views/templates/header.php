<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- 모바일 지원 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Twitter bootstrap core css file-->
    <link href="/misc/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <!-- 상단 메뉴바보다 컨텐츠영역이 아래로 가게끔 설정하는건데
         일단 안해도 내용이 보이고, 적용해도 뭐.. 잘 모르겠슴  -->
    <!-- <style media="screen">
      body{
        padding-top: 2000px;
      }
    </style> -->
    <!-- 반응형 웹 (Fluid layout) css file -->
    <link href="/misc/lib/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
    <!-- <link rel="stylesheet" href="/misc/css/topic.css"> -->
    <title>header test</title>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="/misc/lib/bootstrap/js/bootstrap.min.js"></script>
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

    <!-- Responsive Navbar  -->
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">

          <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>

          <!-- Be sure to leave the brand out there if you want it shown -->
          <a class="brand" href="#">jQuery</a>

          <!-- Everything you want hidden at 940px or less, place within here -->
          <div class="nav-collapse">
            <!-- .nav, .navbar-search, .navbar-form, etc -->
          </div>

        </div>
      </div>
    </div>

    <!-- Fluid layout -->
    <div class="container-fluid">
        <div class="row-fluid">
