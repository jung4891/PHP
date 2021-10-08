<?php
	require_once("../dbconfig.php");
	$bNo = $_GET['bno'];

	
	$sql = 'select * from device where b_no = ' . $bNo;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>기술지원보고서 | Kurien's Library</title>
	<link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="./css/board.css" />
</head>
<body>
	<article class="boardArticle">
		<div id="boardView">
			<h3 id="boardTitle"><?php echo $row['customer']?></h3>
			<div id="boardInfo">
				<span id="produce">제품명<?php echo $row['produce']?></span><br>
				<span id="version">버전<?php echo $row['version']?></span><br>
				<span id="hardware">서버<?php echo $row['hardware']?></span><br>
				<span id="license">라이선스<?php echo $row['license']?></span><br>
			</div>
			<div class="btnSet">
				<a href="./write_device.php?bno=<?php echo $bNo?>">수정</a>
				<a href="./delete_update.php?bno=<?php echo $bNo?>&mode=device">삭제</a>
				<a href="./index_device.php">목록</a>
			</div>
		</div>
	</article>
</body>
</html>
