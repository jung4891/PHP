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
<style type="text/css">
 <!--
/*** Login form ***/

-->
 </style>
<script language="javascript">
function checkNum(obj) {
	var word = obj.value;
	var str = "1234567890";
	for (i=0;i< word.length;i++){
		if(str.indexOf(word.charAt(i)) < 0){
			alert("숫자 조합만 가능합니다.");
			obj.value="";
			obj.focus();
			return false;
		}
	}
}
	 	

var chkForm = function () {
	var mform = document.cform;
	
	if (mform.company_name.value == "") {
		mform.company_name.focus();
		alert("회사명을 입력해 주세요.");
		return false;
	}
	if (mform.company_num.value == "") {
		alert("사업자등록번호를 입력해 주세요.");
		mform.company_num.focus();
		return false;
	}
	if (mform.user_password.value == "") {
		alert("패스워드를 입력해 주세요.");
		mform.user_password.focus();
		return false;
	}
	if (mform.user_name.value == "") {
		alert("이름을 입력해 주세요.");
		mform.user_name.focus();
		return false;
	}
	if(mform.user_duty.value == ""){
		alert("직급을 입력해 주세요.");
		mform.user_duty.focus();
		return false;
	}
	if(mform.user_email.value == ""){
		alert("이메일을 입력해 주세요.");
		mform.user_email.focus();
		return false;
	}
	
	var regex=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
	if(regex.test(mform.user_email.value) === false) {  
		alert("잘못된 이메일 형식입니다.");
		mform.user_email.focus();
		return false;  
	} 

	if(mform.user_tel.value == ""){
		alert("연락처를 입력해 주세요.");
		mform.user_tel.focus();
		return false;
	}
	
	mform.submit();
	return false;
}

</script>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table id="__01" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="cform" action="<?php echo site_url();?>/account/modify_ok2" method="get" onSubmit="javascript:chkForm();return false;">
 <tr>
    <td align="center" height="100"></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><table width="740" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="80" align="center"><a href="<?php echo site_url();?>"><img src="<?php echo $misc;?>img/m_login_ci3.png"></a></td>
      </tr>
      <tr>
        <td height="5" bgcolor="#0277c3"></td>
      </tr>
      <tr>
        <td height="30"></td>
      </tr>
      <tr>
        <td align="center" class="title3">회원수정</td>
      </tr>
      <tr>
        <td height="30"></td>
      </tr>
      <tr>
        <td align="center"><table width="740" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><input type="text" name="company_name" id="company_name" placeholder="회사명" class="login_input" value="<?php echo $company_name;?>"></td>
            <td width="18"></td>
            <td><input type="text" name="company_num" id="company_num" placeholder="사업자등록번호('-' 제외하고 입력)" class="login_input" onclick="checkNum(this);" onKeyUp="checkNum(this);" value="<?php echo $company_num;?>"></td>
          </tr>
          <tr>
            <td height="10"></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td><input type="text" name="user_id" id="user_id" placeholder="아이디" class="login_input" disabled value="<?php echo $user_id;?>"></td>
            <td width="18"></td>
            <td><input type="password" name="user_password" id="user_password" placeholder="비밀번호" class="login_input" value=""></td>
          </tr>
          <tr>
            <td height="10"></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td><input type="text" name="user_name" id="user_name" placeholder="이름" class="login_input" disabled value="<?php echo $user_name;?>"></td>
            <td width="18"></td>
            <td><input type="text" name="user_duty" id="user_duty" placeholder="직급" class="login_input" value="<?php echo $user_duty;?>"></td>
          </tr>
          <tr>
            <td height="10"></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td><input type="text" name="user_email" id="user_email" placeholder="이메일" class="login_input" value="<?php echo $user_email;?>"></td>
            <td width="18"></td>
            <td><input type="text" name="user_tel" id="user_tel" placeholder="연락처" class="login_input" value="<?php echo $user_tel;?>"></td>
          </tr>

        </table></td>
      </tr>
      <tr>
        <td height="30"></td>
      </tr>
      <tr>
        <td align="center"><input type="image" src="<?php echo $misc;?>img/m_btn_join_adjust.jpg" width="267" height="45" style="cursor:pointer" onclick="javascript:chkForm();return false;"></td>
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

