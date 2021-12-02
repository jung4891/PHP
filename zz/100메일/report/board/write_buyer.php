
<?php
	require_once("../dbconfig.php");

	//$_GET['bno']이 있을 때만 $bno 선언

	if(isset($_GET['bno'])) {
		$bNo = $_GET['bno'];
	}
		 
	if(isset($bNo)) {
		$sql = 'select * from buyer where b_device' . $bNo;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>기술지원보고서 | Durian IT&ICT</title>
	<link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="./css/board.css" />
</head>
<body>
	<article class="boardArticle">
		<div id="boardWrite">
			<form action="./write_update_buyer.php" method="post">
<script>
alert(opener.document.customer.value);
</script>
				<?php
				if(isset($bNo)) {
					echo '<input type="hidden" name="bno" value="' . $bNo . '">';
				}
				?>
				<table id="boardWrite">
					<caption class="readHide">고객사 등록</caption>
					<tbody>
						<tr>
							<th scope="row"><label for="customer">고객명</label></th>
							<td class="customer">
								<?php
								if(isset($bNo)) {
                                                                        ?>
                                                                        <input type="text" name="customer" id="customer" value="<?php echo $row['customer']?>">
                                                                <?php

								} else { ?>
									<input type="text" name="customer" id="customer" value="시큐아이">
								<?php } ?>
							</td>
						</tr>
     
                                                <tr>
                                                        <th scope="row"><label for="manager">관리자</label></th>
                                                        <td class="manager">
                                                                <?php
                                                                if(isset($bNo)) {
                                                                  ?>
                                                                        <input type="text" name="manager" id="manager" value="<?php echo $row['manager']?>">
                                                                <?php
								 } else { ?>
                                                                        <input type="text" name="manager" id="manager" value="테스트 담당자">
                                                                <?php } ?>
                                                        </td>
                                                </tr>
                                        <tr>
                                                    <th scope="row"><label for="manager_tel">연락처</label></th>
                                                   <td class="manager_tel">
                                                                <?php
                                                                if(isset($bNo)) {
                                                                        ?>
                                                                        <input type="text" name="manager_tel" id="manager_tel" value="<?php echo $row['manager_tel']?>">
                                                                <?php

                                                                } else { ?>
                                                                        <input type="text" name="manager_tel" id="manager_tel" value="010-1234-1234">
<?php 
} ?>
                                                        </td>
                                           </tr>
					</tbody>
				</table>
				
				<div class="btnSet">
					<button type="submit" class="btnSubmit btn">
						<?php echo isset($bNo)?'수정':'작성'?>
					</button>
					<a href=index_buyer.php class="btnLisbtn">목록</a>

			</form>

	</div>
	</article>
</body>
</html>
