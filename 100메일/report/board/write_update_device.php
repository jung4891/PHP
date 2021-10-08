<?php

	require_once("../dbconfig.php");

	//$_POST['bno']이 있을 때만 $bno 선언
	if(isset($_POST['bno'])) {
		$bNo = $_POST['bno'];
	}

	//bno이 없다면(글 쓰기라면) 변수 선언
	$customer= $_POST['customer'];
	//항상 변수 선언
	//$manager = $_POST['manager'];
	$dev_id = "AA";
	$produce = $_POST['produce'];
	$version = $_POST['version'];
	$hardware= $_POST['hardware'];
	$license= $_POST['license'];

//글 수정
if(isset($bNo)) {

		$sql = 'update device set dev_id="' . $dev_id .'", customer ="' . $customer . '", produce ="' . $produce . '", version ="' . $version . '", hardware ="' . $hardware .'", license="' . $license.'" where b_no = ' . $bNo;

		$msgState = '수정';
	//틀리다면 메시지 출력 후 이전화면으로
	
	
//글 등록
} else {
	$sql = 'insert into device (b_no,device, customer,produce,version,hardware,license) values(NULL,"' . $dev_id . '", "' . $customer . '", "' . $produce . '", "' . $version . '" , "' . $hardware . '", "' . $license . '")';
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

		$replaceURL = './view_device.php?bno=' . $bNo;
	} else {
		$msg = '글을 ' . $sql . '하지 못했습니다.';

echo $sql;


}?>
		<script>
			alert("<?php echo $sql?>");
/			history.back();
		</script>
<?php
//		exit;
	
}

?>
<script>
	alert("<?php echo $msg?>");
	location.replace("<?php echo $replaceURL?>");
</script>


