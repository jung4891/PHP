<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
//	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
body {
	font-family: 'Nanum Gothic', '나눔고딕', Tahoma, 'Georgia', '맑은 고딕', sans-serif;
	font-size:15px;
	color: #333;
	padding:0; margin:0;
}

img {border:0;}
.warp {width:735px; height:558px; margin:50px auto 0 auto;}
.idpw_top {height:98px; border-bottom:5px solid #0277c3; text-align:center;}
.idpw_title {height:80px; text-align:center;}
.idpw_text { height:60px; padding:59px 0; text-align:center; border:1px solid #ddd; overflow:hidden;}
.idpw_text p { height:30px;line-height:30px;  font-weight:600; padding:0; margin:0;}
.idpw_text p span {font-weight:normal;}
.email_btn {height:65px; text-align:center; overflow:hidden;}
.idpw_footer {height:58px; margin-top:50px; border-top:1px solid #b7b7b7;  text-align:center;}
</style>
</head>


<body>
	<div class="warp">
  	<div>
        <!--아이디/비밀번호-->
        <div class="idpw_text" >
            <p><span>아이디:</span> <?php echo $user_id;?></p>
            <p><span>비밀번호:</span> <?php echo $user_password;?></p>
        </div>
        <!--//아이디/비밀번호-->
    </div>
</div>
</body>
</html>
