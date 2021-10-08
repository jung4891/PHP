<SCRIPT language="javaScript">

var winObject=null;

function popupWindow(){

	var settings ='height=500,width=1000,left=0,top=0';

	winObject=window.open("search_buyer.php","Search",settings);

}

function popupWindow2(customer){

	var settings ='height=500,width=1000,left=0,top=0';

	winObject=window.open("search_device.php?customer="+customer,"Search",settings);

}

</SCRIPT>
<?php

	require_once("../dbconfig.php");

	//$_GET['bno']이 있을 때만 $bno 선언
	if(isset($_GET['bno'])) {
		$bNo = $_GET['bno'];
	}
		 
	if(isset($bNo)) {


		$sql = 'select * from tech_board as t1 join buyer as t2 on t1.customer= t2.customer where t1.b_no = ' . $bNo ;
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
			<form name="form1" action="./write_update.php" method="post">
				<?php
				if(isset($bNo)) {
					echo '<input type="hidden" name="bno" value="' . $bNo . '">';
				}
				?>
				<table id="boardWrite">
					<caption class="readHide">기술지원보고서 작성</caption>
					<tbody>
						<tr>
							<th scope="row"><label for="customer">고객명</label></th>
							<td class="customer">
								<?php
								if(isset($bNo)) {

$customer= $row['customer'];
?>

                                                                        <input type="text" readonly="readonly" name="customer" id="customer" value="<?php echo $customer?>">
                                                                <?php
								} else { ?>
									<input type="text" readonly="readonly"  name="customer" id="customer" value="소만사">
								<?php } ?>
							</td>
							<td>
								<input type=button value="검색" onclick="popupWindow();"/>
							</td>
						</tr>
     
                                                <tr>
                                                        <th scope="row"><label for="manager">담당자명</label></th>
                                                        <td class="manager">
                                                                <?php
                                                                if(isset($bNo)) {?>
                                                                        <input type="text" name="manager" id="manager" value="<?php echo $row['manager']?>">
                                                                <?php

                                                                } else { ?>
                                                                        <input type="text" name="manager" id="manager" value="조희찬">
                                                                <?php } ?>
                                                        </td>
                                                </tr>
                                           <tr>
                                                        <th scope="row"><label for="work_name">작업명</label></th>
                                                        <td class="work_name">
                                                                <?php
                                                                if(isset($bNo)) {?>
                                                                        <input type="text" name="work_name" id="work_name" value="<?php echo $row['work_name']?>">
                                                                <?php
                                                                } else { ?>
                                                                        <input type="text" name="work_name" id="work_name" value="방화벽설치">
                                                                <?php } ?>
                                                        </td>
                                                </tr>
                                           <tr>
                                                        <th scope="row"><label for="produce">장비명</label></th>
                                                        <td class="produce">
                                                                <?php
                                                                if(isset($bNo)) {?>
                                                                        <input type="text" name="produce" id="produce" value="<?php echo $row['produce']?>">
                                                                <?php
                                                                } else { ?>
                                                                        <input type="text" name="produce" id="produce" value="방화벽설치">
                                                                <?php } ?>
                                                        </td>
							<td>
								<input type=button value="검색" onclick="popupWindow2(document.form1.customer.value);"/>
								<!--<input type=button value="검색" onclick="popupWindow2('<?php echo $customer ?>');"/>-->
							</td>
                                                </tr>
                                                <tr>
                                                        <th scope="row"><label for="writer">작성자</label></th>
                                                        <td class="writer">
                                                                <?php
                                                                if(isset($bNo)) {?>
									<input type="text" name="writer" id="writer" value="<?php echo $row['writer']?>">
								<?php
                                                                } else { ?>
                                                                        <input type="text" name="writer" id="writer" value="조희찬 사원">
                                                                <?php } ?>
                                                        </td>
                                                </tr>
                                              <tr>
                                                        <th scope="row"><label for="income_time">접수시간</label></th>
                                                        <td class="income_time">
                                                                <?php
                                                                if(isset($bNo)) {?>
                                                                       <input type="text" name="income_time" id="income_time" value="<?php echo $row['income_time']?>">
                                                                <?php
                                                                } else { ?>
                                                                        <input type="text" name="income_time" id="income_time" value="2016-12-29 19:10:00">
                                                                <?php } ?>
                                                        </td>
                                                </tr>
                                                <tr>    
                                                        <th scope="row"><label for="start_time">시작시간</label></th>
                                                        <td class="id">
                                                                <?php
                                                                if(isset($bNo)) {?>
                                                                       <input type="text" name="start_time" id="start_time" value="<?php echo $row['start_time']?>">
                                                                <?php
                                                                } else { ?>
                                                                        <input type="text" name="start_time" id="start_time" value="2016-12-29 19:20:00">
                                                                <?php } ?>
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <th scope="row"><label for="end_time">종료시간</label></th>
                                                        <td class="id">
                                                                <?php
                                                                if(isset($bNo)) {?>
									<input type="text" name="end_time" id="end_time" value="<?php echo $row['end_time']?>">
<?php
                                                                } else { ?>
                                                                        <input type="text" name="end_time" id="end_time" value="2016-12-29 19:30:00">
                                                                <?php } ?>
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <th scope="row"><label for="enginer">담당SE</label></th>
                                                        <td class="enginer">
                                                                <?php
                                                                if(isset($bNo)) {?>
									<input type="text" name="enginer" id="enginer" value="<?php echo $row['enginer']?>">
<?php
                                                                } else { ?>
                                                                        <input type="text" name="enginer" id="enginer" value="조희찬 사원, 김수성 사원">
                                                                <?php } ?>
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <th scope="row"><label for="handle">지원방법</label></th>
                                                        <td class="id">
                                                                <?php
                                                                if(isset($bNo)) {?>
									<input type="text" name="handle" id="handle" value="<?php echo $row['handle']?>">
								
<?php
                                                                } else { ?>
                                                                        <input type="text" name="handle" id="handle" value="방문지원">
                                                                <?php } ?>                                                        </td>
                                                </tr>
						<tr>
							<th scope="row"><label for="request">요청사항</label></th>
							<td class="title"><input type="text" name="request" id="request" value="<?php echo isset($row['request'])?$row['request']:"방화벽설치"?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="work_process">처리절차</label></th>
							<td class="content"><textarea name="work_process" id="work_process"><?php echo isset($row['work_process'])?$row['work_process']:"방화벽3식 설치완료"?></textarea></td>
						</tr>
<tr>
                                                        <th scope="row"><label for="result">처리결과</label></th>
                                                        <td class="content"><textarea name="result" id="result"><?php echo isset($row['result'])?$row['result']:"방화벽 차주 재설치 예정"?></textarea></td>
                                                </tr>

					</tbody>
				</table>
				<div class="btnSet">
					<button type="submit" class="btnSubmit btn">
						<?php echo isset($bNo)?'수정':'작성'?>
					</button>
					<a href="./index.php" class="btnList btn">목록</a>
				</div>
			</form>
		</div>
	</article>
</body>
</html>

