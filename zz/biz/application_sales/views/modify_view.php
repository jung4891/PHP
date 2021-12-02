<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
//	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<html>
<head>
<title><?php echo $this->config->item('site_title');?></title>
<link href="/misc/css/styles.css" type="text/css" rel="stylesheet">
<link href="/misc/css/m_styles.css" type="text/css" rel="stylesheet">
<script src="/misc/js/m_script.js"></script>
<script type="text/javascript" src="/misc/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/misc/js/jquery.min.js"></script>
<link rel="stylesheet" href="/misc/css/jquery-ui.css">
<script src="/misc/js/jquery-ui.js"></script>
<script src="http://dmaps.daum.net/map_js_init/postcode.js"></script>
<script type="text/javascript" src="/misc/js/common.js"></script>
<script type="text/javascript" src="/misc/js/jquery.validate.js"></script>
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
	 	
function idcheck(){
	var uid =  $("#user_id").val();
//	alert(uid);
//	return;
	$.ajax({
		type: "POST",
		cache:false,
		url: "<?php echo site_url();?>/ajax/idcheck",
		dataType: "json",
		async: false,
		data: {id: uid},
		success: function(data){
			if(data.result == "true"){
				document.getElementById("id_message").innerHTML = "<font color=red><span id='id_message'><span class='error_1'>* 중복되는 아이디가 있습니다</span></span></font>";
			} else {
				document.getElementById("id_message").innerHTML = "<span id='id_message'><span class='error_1'>* 3자~12자의 영문,숫자만 사용</span></span>";
			}
		}
	});
}

function PWAnnounce() {
	userpassword = document.cform.user_password.value.trim();
	if  ( !passwordvalidcheck( userpassword ) ){		//	패스워드 길이가 6보다 작거나, 숫자만 입력된 경우
		document.getElementById("pw_message").innerHTML = "<span class='error_1'>* 보안낮음</span> <span class='error'>: 6자 이상의 영문,숫자,특수문자 조합만 가능</span>";
	} else{
		document.getElementById("pw_message").innerHTML = "<font color=green><span class='error_2'>* 보안안전</span></font> <span class='error'>: 6자 이상의 영문,숫자,특수문자 조합만 가능</span>";
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
	if ( !passwordvalidcheck( mform.user_password.value ) ){		//	패스워드 길이가 6보다 작거나, 숫자만 입력된 경우
		alert( "보안수준이 안전한 비밀번호를 입력해 주세요.\n\n(6자 이상의 영문,숫자,특수문자 조합)" );
		mform.user_password.value = "";
		mform.user_passwordconfirm.value = "";
		mform.user_password.focus();
		return;
	}

	if ( mform.user_passwordconfirm.value == "" ){				//	비밀번호 확인값이 입력되어 있지 않을 경우
		alert( "비밀번호 확인을 입력해 주세요." );
		mform.user_passwordconfirm.value = "";
		mform.user_passwordconfirm.focus();
		return;
	}

	if ( mform.user_password.value != mform.user_passwordconfirm.value ){	//	비밀번호 값이 다르게 입력된 경우
		alert( "비밀번호 확인이 일치하지 않습니다." );
		mform.user_passwordconfirm.value = "";
		mform.user_passwordconfirm.focus();
		return;
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
<table id="_01" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="cform" action="<?php echo site_url();?>/account/modify_ok" method="get" onSubmit="javascript:chkForm();return false;">
 <tr>
    <td align="center" height="100"></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><table width="740" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="80" align="center"><a href="<?php echo site_url();?>"><img src="<?php echo $misc;?>img/m_login_ci2.png"></a></td>
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
        <td align="center"><table width="550" border="0" cellspacing="0" cellpadding="0">
        	<colgroup>
                <col width="200px"/>
                <col width="#"/>
            </colgroup>
          <tr>
            <td colspan="2"><input name="company_name" type="text" class="login_input" id="company_name" placeholder="회사명" value="<?php echo $company_name;?>"></td>
          </tr>
          <tr>
            <td height="10" colspan="2"></td>
          </tr>
          <tr>
            <td><input type="text" name="company_num" id="company_num" placeholder="사업자등록번호('-' 제외하고 입력)" class="login_input" disabled maxlength="10" value="<?php echo $company_num;?>"></td>
            <td class="login_tex">* ' - ' 제외하고 입력</td>
          </tr>
          <tr>
            <td height="10" colspan="2"></td>
          </tr>
          <tr>
            <td><input name="user_id" type="text" class="login_input" id="user_id" placeholder="아이디" disabled value="<?php echo $user_id;?>"></td>
            <td class="login_tex"><span id="id_message" style="display:inline"><span class="error_1">* 3자~12자의 영문,숫자만 사용</span></span></td>
          </tr>
          <tr>
            <td height="10" colspan="2"></td>
          </tr>
          <tr>
            <td><input name="user_password" type="password" class="login_input" id="user_password" placeholder="비밀번호" onkeyup="PWAnnounce()"></td>
            <td class="login_tex"><span id="pw_message" style="display:inline"><span class="error_1">* 보안낮음</span> <span class="error">: 6자 이상의 영문,숫자,특수문자 조합만 가능</span></span></td>
          </tr>
          <tr>
            <td height="10" colspan="2"></td>
          </tr>
          <tr>
            <td><input name="user_passwordconfirm" type="password" class="login_input" id="user_passwordconfirm" placeholder="비밀번호확인"></td>
            <td class="login_tex"><span id="pwcfrm_message" style="display:inline"><span class="error_1">* 비밀번호 재확인</span></span></td>
          </tr>
          <tr>
            <td height="10" colspan="2"></td>
          </tr>
          <tr>
            <td colspan="2"><input name="user_name" type="text" class="login_input" id="user_name" placeholder="이름" disabled value="<?php echo $user_name;?>"></td>
          </tr>
          <tr>
            <td height="10" colspan="2"></td>
          </tr>
          <tr>  
            <td colspan="2"><input name="user_duty" type="text" class="login_input" id="user_duty" placeholder="직급" value="<?php echo $user_duty;?>"></td>
          </tr>
          <tr>
            <td height="10" colspan="2"></td>
          </tr>
          <tr>
            <td colspan="2"><input name="user_email" type="text" class="login_input" id="user_email" placeholder="이메일" value="<?php echo $user_email;?>"></td>
          </tr>
          <tr>
            <td height="10" colspan="2"></td>
          </tr>
          <tr>  
            <td colspan="2"><input name="user_tel" type="text" class="login_input" id="user_tel" placeholder="연락처" value="<?php echo $user_tel;?>"></td>
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