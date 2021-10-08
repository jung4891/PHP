<?php
	require_once("../dbconfig.php");
	$bNo = $_GET['bno'];

	if(!empty($bNo) && empty($_COOKIE['tech_board_' . $bNo])) {
		$sql = 'update board_free set b_hit = b_hit + 1 where b_no = ' . $bNo;
		$result = $db->query($sql); 
		if(empty($result)) {
			?>
			<script>
			//	alert('오류가 발생했습니다.');
			//	history.back();
			</script>
			<?php 
		} else {
			setcookie('board_free_' . $bNo, TRUE, time() + (60 * 60 * 24), '/');
		}
	}
	
	$sql = 'select * from tech_board where b_no = ' . $bNo;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>자유게시판 | Kurien's Library</title>
	<link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="./css/board.css" />
</head>
<body>
	<article class="boardArticle">
		<h3>자유게시판 글쓰기</h3>
		<div id="boardView">
			<h3 id="boardTitle"><?php echo $row['request']?></h3>
			<div id="boardInfo">
				<span id="boardID">고객사:<?php echo $row['customer']?></span>
				<span id="boardDate">작업명: <?php echo $row['work_name']?></span><br>
				<span id="boardDate">장비명: <?php echo $row['produce']?></span><br>
				<span id="boardHit">작성자: <?php echo $row['writer']?></span>
				<span id="boardHit">접수시간: <?php echo $row['income_time']?></span><br>
				<span id="boardHit">시작시간: <?php echo $row['start_time']?></span>
				<span id="boardHit">종료시간: <?php echo $row['end_time']?></span><br>
				<span id="boardHit">지원SE: <?php echo $row['enginer']?></span>
				<span id="boardHit">지원방법: <?php echo $row['handle']?></span>
			</div>
			<div id="boardContent">지원 내용: <br><?php echo $row['request']?></div>
			<div id="boardContent">지원 절차: <br><?php echo $row['work_process']?></div>
			<div id="boardContent">지원 결과: <br><?php echo $row['result']?></div>
			<div class="btnSet">
				<a href="./write.php?bno=<?php echo $bNo?>">수정</a>
				<a href="./delete_update.php?bno=<?php echo $bNo?>&mode=tech">삭제</a>
				<a href="./">목록</a>
			</div>
		</div>
	</article>
</body>
</html>
