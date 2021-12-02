<SCRIPT language="javaScript">

var winObject=null;

function popupWindow(){

        var settings ='height=500,width=1000,left=0,top=0';

        winObject=window.open("search_buyer.php","Search",settings);

}
</SCRIPT>


<?php
	require_once("../dbconfig.php");

	//$_GET['bno']이 있을 때만 $bno 선언
	if(isset($_GET['bno'])) {
		$bNo = $_GET['bno'];
	}
		 
	if(isset($bNo)) {
		$sql = 'select * from device where b_no = ' . $bNo;
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
			<form name='form1' action="./write_update_device.php" method="post">
				<?php
				if(isset($bNo)) {
					echo '<input type="hidden" name="bno" value="' . $bNo . '">';
				}
				?>
				<table id="boardWrite">
					<caption class="readHide">장비등록</caption>
					<tbody>
						<tr>
							<th scope="row"><label for="customer">고객명</label></th>
							<td class="customer">
								<?php
								if(isset($bNo)) {
                                                                        ?>
                                                                        <input type="text" name="customer" id="customer" readonly="readonly" value="<?php echo $row['customer']?>">
                                                                <?php

								} else { ?>
									<input type="text" name="customer" id="customer"  readonly="readonly" value="시큐아이">
								<?php } ?>
							</td>
<td>
                                                                <input type=button value="검색" onclick="popupWindow();"/>
                                                        </td>
						</tr>
                                                                <?php
                                                                if(isset($bNo)) {?>
                                                                        <input type="hidden" name="manager" id="manager" value="<?php echo $row['manager']?>">
                                                                <?php

                                                                } else { ?>
                                                                        <input type="hidden" name="manager" id="manager" value="조희찬">
                                                                <?php } ?>
     
                                                <tr>
                                                        <th scope="row"><label for="produce">제품명</label></th>
                                                        <td class="produce">
                                                                <?php
                                                                if(isset($bNo)) {
                                                                        ?>
                                                                        <input type="text" name="produce" id="produce" value="<?php echo $row['produce']?>">
                                                                <?php
								 } else { ?>
                                                                        <input type="text" name="produce" id="produce" value="MF2 1500">
                                                                <?php } ?>
                                                        </td>
                                                </tr>
                                           <tr>
                                                        <th scope="row"><label for="version">버전</label></th>
                                                        <td class="version">
                                                                <?php
                                                                if(isset($bNo)) {
                                                                        ?>
                                                                        <input type="text" name="version" id="version" value="<?php echo $row['version']?>">
                                                                <?php

                                                                } else { ?>
                                                                        <input type="text" name="version" id="version" value="1.0">
                                                                <?php } ?>
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <th scope="row"><label for="hardware">서버</label></th>
                                                        <td class="hardware">
                                                                <?php
                                                                if(isset($bNo)) {
                                                                        
									?>
                                                                        <input type="text" name="hardware" id="hardware" value="<?php echo $row['hardware']?>">
                                                                <?php

                                                                } else { ?>
                                                                        <input type="text" name="hardware" id="hardware" value="테스트 서버">
                                                                <?php } ?>
                                                        </td>
                                                </tr>
                                              <tr>
                                                        <th scope="row"><label for="license">라이선스</label></th>
                                                        <td class="license">
                                                                <?php
                                                                if(isset($bNo)) {
                                                                        ?>
                                                                        <input type="text" name="license" id="license" value="<?php echo $row['license']?>">
                                                                <?php
                                                                } else { ?>
                                                                        <input type="text" name="license" id="license" value="100node">
                                                                <?php } ?>
                                                        </td>
                                                </tr>
					</tbody>
				</table>
				<div class="btnSet">
					<button type="submit" class="btnSubmit btn">
						<?php echo isset($bNo)?'수정':'작성'?>
					</button>
					<a href="./index_device.php" class="btnList btn">목록</a>
				</div>
			</form>
		</div>
	</article>
</body>
</html>
