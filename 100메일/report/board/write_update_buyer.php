<?php

	require_once("../dbconfig.php");

	//$_POST['bno']이 있을 때만 $bno 선언
	if(isset($_POST['bno'])) {
		$bNo = $_POST['bno'];
	}

	//항상 변수 선언
	$custom_id = "AA";
	$customer= $_POST['customer'];
	$manager = $_POST['manager'];
	$manager_tel = $_POST['manager_tel'];
//글 수정
if(isset($bNo)) {

echo -1;
		$sql = 'update buyer set customer ="' . $customer . '", manager ="' . $manager . '", manager_tel ="' . $manager_tel .'" where b_no = ' . $bNo;

		$msgState = '수정';
	//틀리다면 메시지 출력 후 이전화면으로
	
//글 등록
} else {
$sql = 'select count(*) as cnt from buyer where customer="' .$customer .'"';
        $result = $db->query($sql);
        $row = $result->fetch_assoc();

        $tmp = $row['cnt']; //전체

	$sql = 'insert into buyer (b_no,custom_id, customer, manager,manager_tel) values(NULL,"' . $custom_id . '", "' . $customer . '", "' . $manager . '", "' . $manager_tel . '")';
	$msgState = '등록';



}

//메시지가 없다면 (오류가 없다면)
if(empty($msg)&&$tmp<1) {
	$result = $db->query($sql);
	//쿼리가 정상 실행 됐다면,
	if($result) {
		$msg = '정상적으로 글이 ' . $msgState . '되었습니다.';
		if(empty($bNo)) {
			$bNo = $db->insert_id;
		}
		$replaceURL = './view_buyer.php?bno=' . $bNo;
	} 

}else {
		$msg = '고객사가 중복됩니다.';

}?>
		<script>

			alert("<?php echo $msg?>");
			history.back();
		</script>
<?php
 


?>
<script>
	alert("<?php echo $msg?>");
	location.replace("<?php echo $replaceURL?>");
</script>


