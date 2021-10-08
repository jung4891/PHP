<?php 
session_start();

?>
<html>
	<head>
		<title>메인페이지</title>
	</head>
	<BODY BGCOLOR="#006699" LINK="#99CCFF" VLINK="#99CCCC" TEXT="#FFFFFF">
	메인페이지<br/>
	</body>
	<?php 
	if(($_SESSION['is_logged']==1)){
		$id = $_SESSION['id'];
		echo "$id 로그인 되었습니다";	
	}else{
		echo "로그인 실패";
	}
	session_destroy();
	?>
