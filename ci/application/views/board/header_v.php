<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="viewport" content="width=device-width,initial-scale=1, user-scalable=no" />
	<title>CodeIgniter</title>
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<!-- <link href="/board/include/css/test.css" type="text/css" rel="stylesheet"> ㅠㅠㅠ 이렇게 해야함..-->
	<?php
	// include $this->input->server('DOCUMENT_ROOT')."/board/include/css/test.css";		// 이렇게 하면 그냥 내용이 출력됨
	echo $_SERVER['DOCUMENT_ROOT'];
	?>
	<!-- <link href="/board/include/css/bootstrap.css" type="text/css" rel="stylesheet"> 적용안됨 이건. 음.. -->


</head>
<body>
<div id="main">

	<header id="header" data-role="header" data-position="fixed"><!-- Header Start -->
		<!-- <blockquote>
			<p>만들면서 배우는 CodeIgniter</p>
			<small>실행 예제</small>
			<p>
<?php
if( @$this->session->userdata['logged_in'] == TRUE )
{
?>
<?php echo $this->session->userdata['username']?>님 환영합니다. <a href="/bbs/auth/logout" class="btn">로그아웃</a>
<?php
} else {
?>
<a href="/bbs/auth/login" class="btn btn-primary">로그인</a>
<?php
}
?>
		</p>
		</blockquote> -->
	</header><!-- Header End -->

	<br><br>
	<nav id="gnb"><!-- gnb Start -->
		<ul>
			<li><a rel="external" href="/<?php echo $this->uri->segment(1);?>/lists/<?php echo $this->uri->segment(3);?>">게시판 프로젝트</a></li>
		</ul>
	</nav><!-- gnb End -->
