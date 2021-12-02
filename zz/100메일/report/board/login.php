<?php
session_start();
$id = $_POST ["id"];
$pw = $_POST ["pw"];

$connect = mysql_connect ( 'localhost:3306', 'root', 'durian12#' );
if (! $connect) {
	die ( 'Could not connect: ' . mysql_error () );
}
echo 'Connected successfully';
echo '<br/>';

// 한글 깨짐 방지
mysql_query ( "set names euckr" );

mysql_select_db ( "login" );

$query = "select * from user where user_id='$id'";

$result = mysql_query ( $query, $connect );

// 연관 색인 및 숫자 색인으로 된 배열로 결과 행을 반환
$data = mysql_fetch_array ( $result, MYSQL_NUM );

if ($data [0] == $id) {
	echo "no erorr  id = $id <br/>";
	if ($data [1] == $pw) {
		echo "no error pw = $pw <br/>";

		$_SESSION['id']=$id;
		$_SESSION['is_logged']=1;
		
		header("Location: main.php");
		exit();
	}else{
		//에러메세지 출력 문제
		echo "<script>alert(\"실패 \");
				history.back(1);
				</script>";
		$_SESSION['is_logged']=2;
	
	}
		
}else{
	$_SESSION['is_logged']=2;
	echo "<script>alert(\"실패 \");
			history.back(1);
			</script>";
}

mysql_close ( $connect );
?>
