<?php
	require_once("../dbconfig.php");
	$bNo = $_GET['bno'];

	$sql = 'select * from buyer where b_no = ' . $bNo;
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
			<h3 id="boardTitle"><?php echo "고객정보"?></h3>
			<div id="boardInfo">
				<span id="customer">고객명 : <?php echo $row['customer']?></span><br>
				<span id="manager">관리자 : <?php echo $row['manager']?></span><br>
				<span id="manager_tel">연락처 : <?php echo $row['manager_tel']?></span><br>
			</div>
			<div class="btnSet">
				<a href="./write_buyer.php?bno=<?php echo $bNo?>">수정</a>
				<a href="./delete_update.php?bno=<?php echo $bNo?>&mode=buyer">삭제</a>
				<a href="./index_buyer.php">목록</a>
			</div>
		</div>
	</article>
</body>
</html>
