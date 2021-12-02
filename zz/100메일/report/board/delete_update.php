<?php
	require_once("../dbconfig.php");

	//$_POST['bno']이 있을 때만 $bno 선언
	if(isset($_POST['bno'])) {
		$bNo = $_POST['bno'];
	}
	
		$bNo = $_GET['bno'];
	$mode=$_GET['mode'];

//	$bPassword = $_POST['bPassword'];

//글 삭제
/*if(isset($bNo)) {
	//삭제 할 글의 비밀번호가 입력된 비밀번호와 맞는지 체크
	$sql = 'select count(b_password) as cnt from board_free where b_password=password("' . $bPassword . '") and b_no = ' . $bNo;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();

	//비밀번호가 맞다면 삭제 쿼리 작성
	if($row['cnt']) {*/
	if($mode=='tech'){
	
		$sql = 'delete from tech_board where b_no = ' . $bNo;
		$msg = '글을 삭제하였습니다';

	}else if($mode=='device'){
	
		$sql = 'delete from device where b_no = ' . $bNo;
		$msg = '장비 정보를 삭제하였습니다';		

	}else if($mode=='buyer'){
		
		$sql = 'delete from buyer where b_no = ' . $bNo;
		$msg = '고객사 정보를 삭제 하였습니다';
	
	}else{
		
		$msg = '삭제할 정보가 없습니다';

	}

	//틀리다면 메시지 출력 후 이전화면으로
/*	} else {
		$msg = '비밀번호가 맞지 않습니다.';
	?>
		<script>
			alert("<?php echo $msg?>");
			history.back();
		</script>
	<?php
		exit;
	}
}*/

	$result = $db->query($sql);
	
//쿼리가 정상 실행 됐다면,
if($result) {
	if($mode=='buyer'){

		$replaceURL = './index_buyer.php';

	}else if($mode=='device'){

		$replaceURL = './index_device.php';

	}else{
		$replaceURL = './';
	}
 }else {
	$msg = '글을 삭제하지 못했습니다.';
?>
	<script>
		alert("<?php echo $sql?>");
		alert("<?php echo $bNo?>");
		history.back();
	</script>
<?php
	exit;
}


?>
<script>
	alert("<?php echo $msg?>");
	location.replace("<?php echo $replaceURL?>");
</script>
