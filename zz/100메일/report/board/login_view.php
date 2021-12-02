<?php
	include "/var/www/html/durianit/stc/include/base.php";

//	include "/var/www/html/durianit/stc/include/customer_top.php";
?>
<html>
<head>
<title><?php echo $this->config->item('site_title');?></title>
<link href="<?php echo $misc;?>css/styles.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="generator" content="WebEditor">
<style type="text/css">
 <!--
/*** Login form ***/

-->
 </style>
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
</script>
</head>
<body style=" background:url(../../misc/img/tech_bg.jpg) no-repeat;" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table id="__01" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="login" method="post" action="<?php echo site_url().'/account/login';?>" onSubmit="javascript:chkForm();return false;">
 <tr>
    <td align="center" height="100"></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><table style="background-color:#FFF; padding:20px; opacity:0.85;" width="485" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="80" align="center"><a href="<?php echo site_url();?>"><img src="<?php echo $misc;?>img/m_login_ci.png"></a></td>
      </tr>
      <tr>
        <td height="5" bgcolor="#0277c3"></td>
      </tr>
      <tr>
        <td height="30"></td>
      </tr>
      <tr>
        <td align="center"><table width="460" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><input type="text" name="user_id" id="user_id" placeholder="아이디를 입력하세요." class="login_input"></td>
          </tr>
          <tr>
            <td height="5"></td>
          </tr>
          <tr>
            <td><input type="password" name="user_password" id="user_password" placeholder="패스워드를 입력하세요." class="login_input"></td>
          </tr>
          <tr>
            <td height="30"></td>
          </tr>
          <tr>
            <td><input type="image" src="<?php echo $misc;?>img/m_btn_login.jpg" width="460" height="61" style="cursor:pointer" onClick='return chkForm();'></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="30"></td>
      </tr>
      <tr>
        <td align="center"><table width="460" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><a href="<?php echo site_url().'/account/join';?>"><img src="<?php echo $misc;?>img/m_btn_newg.jpg" width="225" height="44"></a></td>
            <td width="10"></td>
            <td><a href="#" onClick="window.open('<?php echo site_url();?>/account/cnum_view/2','','width=550,height=220,scrollbars=no,left=100,top=200');return false" target="space"><img src="<?php echo $misc;?>img/m_btn_find.jpg" width="225" height="44"></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="30"></td>
      </tr>
      <tr>
        <td height="1" bgcolor="#b7b7b7"></td>
      </tr>
      <tr>
        <td height="60" align="center" class="text_copyright">Copyright ©<span class="style1"> DurianIT</span> All rights Reserved</td>
      </tr>
    </table></td>
  </tr>
   <tr>
    <td align="center" height="200"></td>
  </tr>
</form>
</table>
</body>
</html>
