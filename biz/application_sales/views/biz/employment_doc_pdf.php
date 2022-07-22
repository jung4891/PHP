<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title></title>
		<style media="screen">
			body { font-family: "Malgun Gothic", "굴림", "Gulim", "Arial"; }
			/* .contents {page-break-after: always;} */
			p {word-break: keep-all; font-size:17px;}
			.sub1 {padding-left:20px;}
			.sub2 {padding-left:1cm;}
			.personal_tbl p {font-size: 13px;}
			.content_tbl td {
				text-align: center;
				height: 50px;
			}
			.content_tbl td:not(:last-child) {
				border-left: 1px black solid;
				border-top: 1px black solid;
			}
<?php if($view_val['approval_doc_status'] == '002') { ?>
			.durianStamp {
				position: static;
	      background:url('/misc/img/duit_stamp.png');
	      background-size:127px;
	      background-position: right bottom;
	      background-repeat:no-repeat;
	      padding-top:30px;
	      padding-bottom:30px;
	      padding-right:10px;
	      padding-left:10px;
	    }
<?php } ?>
		</style>
		<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
	</head>
	<body>
		<div class="book">
			<div class="page">
				<div class="subpage">
					<div class="contents">
						<p style="text-align:center;font-weight:bold;font-size:40px;">
							<span style="border-bottom:solid black">재&nbsp;&nbsp;&nbsp;직&nbsp;&nbsp;&nbsp;증&nbsp;&nbsp;&nbsp;명&nbsp;&nbsp;&nbsp;서</span>
						</p>
						<table width="50%" border="0" cellpadding="0" cellspacing="0" style="text-align:center;border:2px solid black;border-bottom:none;">
							<col width="40%">
							<col width="60%">
							<tr style="height:40px;">
								<td style="background-color:#DEDEDE;border-right:2px solid black;">양식번호</td>
								<td style="background-color:#DEDEDE;">
									<?php if($view_val['approval_doc_status'] == '002') {
										echo $employment_doc_data['doc_num1'].'-'.$employment_doc_data['doc_num2'].$employment_doc_data['doc_num3'].'-'.$employment_doc_data['doc_num4'].'-'.$employment_doc_data['doc_num5'];
									} else {
										echo '자동발급';
									} ?>
								</td>
							</tr>
						</table>
						<table width="100%" border="0" cellpadding="0" cellspacing="0" style="text-align:center;border:2px solid black;">
							<col width="20%">
							<col width="30%">
							<col width="20%">
							<col width="30%">
							<tr style="height:40px;">
								<td style="border-right:2px solid black;border-bottom:2px solid black;">소속부서</td>
								<td style="border-right:2px solid black;border-bottom:2px solid black;"><?php echo $user_data['user_group']; ?></td>
								<td style="border-right:2px solid black;border-bottom:2px solid black;">직&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;위</td>
								<td style="border-bottom:2px solid black;"><?php echo $employment_doc_data['user_duty']; ?></td>
							</tr>
							<tr style="height:40px;">
								<td style="border-right:2px solid black;border-bottom:2px solid black;">입사년월일</td>
								<td style="border-right:2px solid black;border-bottom:2px solid black;"><?php echo date('Y년 m월 d일', strtotime($user_data['join_company_date'])); ?></td>
								<td style="border-right:2px solid black;border-bottom:2px solid black;">이&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;름</td>
								<td style="border-bottom:2px solid black;"><?php echo $user_data['user_name']; ?></td>
							</tr>
							<tr style="height:40px;">
								<td style="border-right:2px solid black;border-bottom:2px solid black;">주민등록번호</td>
								<td style="border-right:2px solid black;border-bottom:2px solid black;"><?php echo date('ymd', strtotime($user_data['user_birthday'])); ?>-*******</td>
								<td style="border-right:2px solid black;border-bottom:2px solid black;">사용용도</td>
								<td style="border-bottom:2px solid black;"><?php echo $employment_doc_data['purpose_of_use']; ?></td>
							</tr>
							<tr style="height:40px;">
								<td style="border-right:2px solid black;border-bottom:2px solid black;">주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</td>
								<td colspan="3" style="border-bottom:2px solid black;">경기도 성남시 분당구 판교로 255번길 9-22 (삼평동, 판교우림W-CITY  603호)</td>
							</tr>
							<tr>
								<td colspan="4" style="height:800px;vertical-align:top;">
									<p style="margin-top:100px;font-size:20px;">상기와 같이 재직하고 있음을 증명함.</p>
									<p style="margin-top:100px;font-size:20px;"><?php
										if($view_val['approval_doc_status'] == '002') {
											echo date('Y년 m월 d일', strtotime($view_val['completion_date']));
										} else {
											echo 'YYYY년 mm월 dd일';
										}
									?></p>
									<!-- <p style="margin-top:400px;font-size:20px;">주식회사 두리안정보기술</p>
									<p style="margin-top:50px;font-size:20px;">대표이사 정&nbsp;&nbsp;&nbsp;재&nbsp;&nbsp;&nbsp;욱</p> -->
									<div style="font-size:20px;font-size:25pt;width:340px;margin:0 auto;margin-top:400px;" class="durianStamp">
										(주)두리안정보기술<br>
						        대 표 이 사&nbsp;&nbsp;정 재 욱
									</div>
									<!-- <span class="durianStamp"></span> -->
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div style="margin-top:10px;text-align:right;">
					<img src="/misc/img/ci_durianit.png" height="35px;" style="opacity: 0.4;">
				</div>
			</div>
		</div>
	</body>
</html>
