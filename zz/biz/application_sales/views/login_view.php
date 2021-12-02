<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
//	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<html>
<head>
<title><?php echo $this->config->item('site_title');?></title>
<link href="<?php echo $misc;?>css/styles.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="generator" content="WebEditor">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css">
@import url(//fonts.googleapis.com/earlyaccess/notosanskr.css);


/* 모바일 csss */
@media (max-width: 575px) {

	html, body { width:100%;
	             height:100%;
	             min-width: unset;
				 }

	#line_css,
	.copyright {
		display: none !important;
	}

	.main {
		width: 100% !important;
		min-height: 100% !important;
		background-size: 200vh, 100vh !important;
	}

	div.left {
		float: none !important;
		width: 100% !important;
		height: 0px !important;
	}

	.title_content {
		width: 100% !important;
		height: 1px !important;
		margin: 0px !important;
	}

	.title_content table,
	.title_div {
		width: 100% !important;
	}

	.login_title {
		padding-top: 20% !important;
		width: 100% !important;
		font-size: 40px !important;
		text-align: center !important;
	}

	div.right {
		margin-top: 50% !important;
		min-width: 100% !important;
		height: auto !important;
	}

	.login_content {
		margin: 0px 0px 0px 0px !important;
	}
}

@media (max-width: 768px) {
	#line_css,.copyright {
		display:none !important;
	}
	.main{
		width:100% !important;
		min-height:100% !important;
		background-size:200vh,100vh !important;
	}
	div.left {
		float:none !important;
		width:100% !important;
		height:0px !important;
	}
	.title_content{
		width:100% !important;
		height:1px !important;
		margin: 0px !important;
	}
	.title_content table,.title_div{
		width:100% !important;
	}

	.login_title{
		padding-top:20% !important;
		width:100% !important;
		font-size: 40px !important;
		text-align:center !important;
	}

	div.right{
		margin-top:50% !important;
		min-width:100% !important;
		height:auto !important;
	}

	.login_content{
		margin : 0px 0px 0px 0px !important;
	}
}

/* 기존css */
div.left {
	position: relative;
	display: table;
	width: 50%;
	height:100%;
	float: left;
	background-color: #ffffff;
	background-color: rgba( 255, 255, 255, 0.5 );
}


.login_title{
	font-family: "Noto Sans KR", sans-serif !important;
	color: #187dbf;
	font-size: 60px;
	font-weight: bold;
	/* text-align:center; */
}
div.main {
	width: 100%;
 	height: 100%;
}

div.title_div{
	display: table-cell;
  vertical-align: middle;
}
div.title_content{
	float:right;
	margin-right:10%;
}
div.copyright{
	position: absolute;
	right: 10%;
	bottom: 30px;
}
div.right {
	width: 50%;
	height:100%;
	display: table;
}
div.login_div{
	display: table-cell;
  vertical-align: middle;
	width:60%;
}
div.login_content{
	float:left;
	margin-left: 10%;
}
.login_table input{
	font-family: "Noto Sans KR", sans-serif !important;
	background-color:transparent;
	color:white;
	font-size: 17px;
	border-radius:50px;
	padding-left: 30px;
	height:60px;
}
.login_table input::placeholder{
	color: white;
}
.login_table input:focus{
	outline:none;
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
	<div class="main" style=" background:url(../../misc/img/login_bg.jpg) no-repeat; background-size:100%,100%;" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form name="login" method="post" action="<?php echo site_url().'/account/login';?>" onSubmit="javascript:chkForm();return false;">
		<div class="left">
				<div class="title_div">
					<div class="title_content">
						<table style="margin-right:10px;">
							<tr>
								<th class="login_title" align="right">BIZ CENTER</th>
							</tr>
							<!-- <tr>
								<td height="40"></td>
							</tr> -->
							<tr>
								<td id="line_css" colspan="1" height="1" bgcolor="#636363"></td>
							</tr>
						</table>
					</div>
					<div class="copyright">
							<p>Copyright © DurianIT All rights Reserved<p>
					</div>
				</div>
			</div>

			<div class="right">
				<div class="login_div">
					<div class="login_content">
						<table class="login_table" border="0" cellspacing="10">
							<tr>
								<td colspan="3"><input type="text" name="user_id" id="user_id" placeholder="아이디를 입력하세요." class="login_input"></td>
							</tr>
							<tr>
								<td colspan="3"><input type="password" name="user_password" id="user_password" placeholder="패스워드를 입력하세요." class="login_input"></td>
							</tr>
							<tr>
								<td colspan="3" ><a href="#" onClick="return chkForm();"><img src="<?php echo $misc;?>img/biz_btn_login.png" height="60" width="100%"></a></td>
							</tr>
							<tr>
								<td height="20"></td>
							</tr>
							<tr>
								<td>
									<a href="#" onClick="window.open('<?php echo site_url();?>/account/cnum_view/1','','width=550,height=220,scrollbars=no,left=100,top=200');return false" target="space"><img src="<?php echo $misc;?>img/biz_btn_newg.png" height="60" width="100%"></a>
								</td>
								<td width="10"></td>
								<td>
									<a href="#" onClick="window.open('<?php echo site_url();?>/account/cnum_view/2','','width=550,height=220,scrollbars=no,left=100,top=200');return false" target="space"><img src="<?php echo $misc;?>img/biz_btn_find.png" height="60" width="100%"></a>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>

	</form>
</div>
</body>
</html>
