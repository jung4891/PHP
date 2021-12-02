<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
//	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo $this->config->item('site_title');?></title>
	</head>
	<link rel="stylesheet" href="/misc/css/view_page_common.css">
	<style media="screen">
		@import url(//fonts.googleapis.com/earlyaccess/notosanskr.css);
		/* 아이폰 버튼 초기화 */
		input, textarea, button { appearance: none; -moz-appearance: none; -webkit-appearance: none; border-radius: 0; -webkit-border-radius: 0; -moz-border-radius: 0; }
		body {
			font-family: "Noto Sans KR", sans-serif !important;
		}
		.main-container {
			width:100%;
			height: 100vh;
			padding-top:30%;
			height:auto;
		}
		.logo-div {
			width:100%;
			/* background-color: blue; */
		}
		.login_title{
			color: #0575E6;
			font-size: 40px;
			font-weight: bold;
		}
		.input-common {
			height: 48px;
			border-color: #DEDEDE;
			padding-left: 10px;
			font-size: 16px;
		}
		div.copyright{
			margin-top:100px;
			width: 100%;
		}
	</style>
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
	<script language="javascript">
	var chkForm = function chkForm() {
		var mform = document.login;
		mform.user_id.value = mform.user_id.value.trim();
		mform.user_password.value = mform.user_password.value.trim();

		if(mform.user_id.value == ""){
			alert("아이디를 입력하세요.");
			mform.user_id.focus();
			return false;
		} else if(mform.user_password.value == ""){
			alert("비밀번호를 입력하세요.");
			mform.user_password.focus();
			return false;
		}

		mform.submit();
		return false;
	}
	$(document).ready(function() {
		$("#user_id, #user_password").keydown(function(key) {
			if (key.keyCode == 13) {
				chkForm();
			}
		});
	});
	</script>
	<body>
		<form name="login" method="post" action="<?php echo site_url().'/account/login';?>" onSubmit="javascript:chkForm();return false;">
			<div class="main-container">
				<div class="logo-div">

					<table style="width:100%;" border="0" cellspacing="5">
						<colgroup><col width="49%"><col width="2%"><col width="49%"></colgroup>
						<tr>
							<th colspan="3" align="center">
								<div class="login_title">BIZ CENTER</div>
							</th>
						</tr>
						<tr>
							<td height="40"></td>
						</tr>
						<tr style="padding-top:50px;">
							<td colspan="3" align="center">
								<input type="text" name="user_id" id="user_id" placeholder="아이디를 입력하세요." class="input-common" style="width:90%">
							</td>
						</tr>
						<tr>
							<td colspan="3" align="center">
								<input type="password" name="user_password" id="user_password" placeholder="패스워드를 입력하세요." class="input-common" style="width:90%">
							</td>
						</tr>
						<tr>
							<td height="15"></td>
						</tr>
						<tr>
							<td colspan="3" align="center">
								<a href="#" onClick="return chkForm();">
									<input type="button" class="btn-common btn-color2" value="로그인" style="width:90%;height: 48px;">
								</a>
							</td>
						</tr>
						<tr>
							<td height="10"></td>
						</tr>
						<tr style="font-size:12px;color:#626262">
							<td align="center" style="padding-left:10px;">아이디 신규신청</td>
							<td align="center">|</td>
							<td align="center" style="padding-right:10px;">아이디/비밀번호 분실신고</td>
						</tr>
						<tr>
							<td height="20"></td>
						</tr>
					</table>
				</div>
				<div class="copyright">
					<table width="100%">
						<tr>
							<td align="center" style="color:#B0B0B0;font-size: 10px;">Copyright © DurianIT All rights Reserved</td>
						</tr>
					</table>
				</div>
			</div>
		</form>
	</body>
</html>
