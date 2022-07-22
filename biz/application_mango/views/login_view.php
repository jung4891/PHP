<!-- <?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
//	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?> -->
<html>
<head>
<title><?php echo $this->config->item('site_title');?></title>
<!-- <link href="<?php echo $misc;?>css/styles.css" type="text/css" rel="stylesheet"> -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="generator" content="WebEditor">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/misc/css_mango/view_page_common_mango.css">
<style type="text/css">
	@import url(//fonts.googleapis.com/earlyaccess/notosanskr.css);
	.login_title{
		position: absolute;
		left: 49%;
		transform:translateX(-50%);
		top: 15%
	}
	.copyright{
		position: absolute;
		left: 50%;
		transform:translateX(-50%);
		bottom: 30px;
	}
	.login_table{
		position: absolute;
		left: 50%;
		transform:translateX(-50%);
		top: 30%
	}
	.user_id{
		width: 460px;
		height: 60px;
		border-radius: 5px;
		border: 1px solid #DEDEDE;
	}
	.user_password{
		width: 460px;
		height: 60px;
		border-radius: 5px;
		border: 1px solid #DEDEDE;
	}
	.login_button{
		width: 460px;
		height: 60px;
		border-radius: 5px;
		border: none;
		background-color: #FFC705;
		color: #FFFFFF;
		font-weight:bold;
		font-size: 17px;
		cursor: pointer;
	}
	.sign_up{
		position: absolute;
		left: 38%;
		transform:translateX(-38%);;
		bottom: 20%
		/* font-color: #626262; */

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
</head>
<body>
	<div class="main">
		<form class="" name="login" action="<?php echo site_url().'/account/login';?>" method="post"  onsubmit="javascript:chkForm();return false;">
			<div class="">
				<div class="title_content">
					<table style="">
						<tr>
							<th class="login_title">
								<img src="/misc/img_mango/themango_logo.svg" style="width:140%">
							</th>
						</tr>
					</table>
				</div>
				<div class="copyright">
						<p>copyright ⓒ 2019 themango co.ltd. all rights reserved.<p>
				</div>
			</div>

			<div class="login_input">
				<table class="login_table" border="0" cellspacing="10">
					<tr>
						<td colspan="3"><input type="text" name="user_id" id="user_id" placeholder="아이디를 입력하세요." class="user_id" style="padding-left:10px;color:#B0B0B0"></td>
					</tr>
					<tr>
						<td colspan="3"><input type="password" name="user_password" id="user_password" placeholder="패스워드를 입력하세요." class="user_password" style="padding-left:10px;color:#B0B0B0"></td>
					</tr>
					<tr>
						<td style="color:#626262; font-size:12px;">
							<!-- <input type="checkbox" name="" value="">로그인 상태 유지 -->
						</td>
					</tr>
					<tr>
						<td>
							<div>
								<button type="submit" class="login_button" name="login_button">로그인
									<a href="#" onclick="retrun chkForm();"></a>
								</button>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<a href="<?php echo site_url().'/account/sign_up'; ?>" style="text-decoration: none;color:#626262;font-size:12px;margin-right:5px;">회원가입</a>
							<a href="<?php echo site_url().'/account/find_id'; ?>" style="text-decoration: none;color:#626262;font-size:12px;margin-right:5px;">ID 찾기</a>
							<a href="<?php echo site_url().'/account/find_password'; ?>" style="text-decoration: none;color:#626262;font-size:12px;">비밀번호 찾기</a>
						</td>
					</tr>
				</table>
			</div>
		</form>
	</div>

</body>
</html>
