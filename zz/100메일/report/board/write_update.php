<?php

	require_once("../dbconfig.php");

	//$_POST['bno']이 있을 때만 $bno 선언
	if(isset($_POST['bno'])) {
		$bNo = $_POST['bno'];
	}

	//bno이 없다면(글 쓰기라면) 변수 선언
	if(empty($bNo)) {
	}

	//항상 변수 선언

	$customer = $_POST['customer'];
	$manager = $_POST['manager'];
	$produce =$_POST['produce'];
	$work_name = $_POST['work_name'];
	$writer = $_POST['writer'];
	$income_time = $_POST['income_time'];
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	$enginer = $_POST['enginer'];
	$handle = $_POST['handle'];
	$request = $_POST['request'];
	$work_process = $_POST['work_process'];
	$result = $_POST['result'];

//글 수정
if(isset($bNo)) {

		$sql = 'update tech_board set customer="' . $customer . '", produce="' . $produce . '", work_name="' . $work_name . '", writer="' . $writer .'", income_time="' . $income_time .'", start_time="' . $start_time .'", end_time="' . $end_time .'", enginer="' . $enginer .'", handle="' . $handle .'", request="' . $request .'", work_process="' . $work_process .'", result="' . $result .'" where b_no = ' . $bNo;

		$msgState = '수정';
	//틀리다면 메시지 출력 후 이전화면으로
	
	
//글 등록
} else {
	$sql = 'insert into tech_board (b_no, customer, produce, work_name, writer, income_time,start_time,end_time,enginer,handle,request,work_process,result) values(NULL, "' . $customer . '", "' . $produce . '", "' . $work_name . '" , "' . $writer . '", "' . $income_time . '", "' . $start_time . '", "' . $end_time . '", "' . $enginer . '", "' . $handle . '", "' . $request . '", "' . $work_process . '", "' . $result . '")';
	$msgState = '등록';
}

//메시지가 없다면 (오류가 없다면)
if(empty($msg)) {
	$result = $db->query($sql);
	
	//쿼리가 정상 실행 됐다면,
	if($result) {
		$msg = '정상적으로 글이 ' . $msgState . '되었습니다.';
		if(empty($bNo)) {
			$bNo = $db->insert_id;
		}
		$replaceURL = './view.php?bno=' . $bNo;
	} else {
		$msg = '글을 ' . $msgState . '하지 못했습니다.';
}?>
		<script>
//			alert("<?php echo $msg?>");
//			history.back();
		</script>
<?php
		exit;
	
}

?>
<script>
	alert("<?php echo $sql?>");
	alert("<?php echo $replaceURL?>");
//	location.replace("<?php echo $replaceURL?>");
</script>


