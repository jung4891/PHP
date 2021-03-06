<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
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

function chkForm () {
	var mform = document.cform;
  var userPart = '';

  //11을 011로 자릿수에 맞춰주는 함수
  function pad(n, width) {
    n = n + '';
    return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
  }

  for(i=0; i<document.getElementsByName('user_part1').length; i++){
    userPart = userPart+document.getElementsByName('user_part2')[i].value;
  }


  mform.user_part.value = pad(userPart,3);
  
	if (mform.user_id.value == "") {
		mform.user_id.focus();
		alert("아이디를 입력해 주세요.");
		return false;
	}
	if (mform.user_password.value == "") {
		mform.user_password.focus();
		alert("패스워드를 입력해 주세요.");
		return false;
	}
	if ( !passwordvalidcheck( mform.user_password.value ) ){		//	패스워드 길이가 6보다 작거나, 숫자만 입력된 경우
		alert( "보안수준이 안전한 비밀번호를 입력해 주세요.\n\n(6자 이상의 영문,숫자,특수문자 조합)" );
		mform.user_password.value = "";
		mform.user_password.focus();
		return;
	}
	if (mform.company_name.value == "") {
		mform.company_name.focus();
		alert("회사명을 입력해 주세요.");
		return false;
	}
	if (mform.company_num.value == "") {
		mform.company_num.focus();
		alert("사업자등록번호를 입력해 주세요.");
		return false;
	}
	if (mform.user_name.value == "") {
		mform.user_name.focus();
		alert("이름을 입력해 주세요.");
		return false;
	}
	if (mform.user_duty.value == "") {
		mform.user_duty.focus();
		alert("직급을 입력해 주세요.");
		return false;
	}
	if (mform.user_email.value == "") {
		mform.user_email.focus();
		alert("이메일을 입력해 주세요.");
		return false;
	}
	var regex=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
	if(regex.test(mform.user_email.value) === false) {  
		alert("잘못된 이메일 형식입니다.");
		mform.user_email.focus();
		return false;  
	} 
	if (mform.user_tel.value == "") {
		mform.user_tel.focus();
		alert("전화번호를 입력해 주세요.");
		return false;
	}
	
	if (c == "004") {
		mform.user_level.value = "3";
	} else {
		mform.user_level.value = "1";
	}
	
	mform.submit();
	return false;
}

</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="cform" action="<?php echo site_url();?>/account/user_input_action" method="get" onSubmit="javascript:chkForm();return false;">
<input type="hidden" name="user_part" value="">
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/admin_header.php";
?>
  <tr>
    <td align="center" valign="top">
    
    <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
            
            <td width="923" align="center" valign="top">
            
            <!--내용-->
            <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <!--타이틀-->
              <tr>
                <td class="title3">회원정보</td>
              </tr>
              <!--//타이틀-->

              <tr>
                <td>&nbsp;</td>
              </tr>
             <!--등록-->
              <tr>
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <colgroup>
                  	<col width="15%" />
                    <col width="35%" />
                    <col width="15%" />
                    <col width="35%" />
                  </colgroup>
                  <!--시작라인-->
                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//시작라인-->
                  
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">회원구분</td>
                    <td id="userPart" align="left" class="t_border" style="padding-left:10px;">
                      <div>
                        <!-- <select name="user_part1" id="user_part1" class="input">
                          <option value=100>영업</option> 
                          <option value=10>기술</option>
                          <option value=1>관리자</option>
                        </select> -->
                        <?php for($i=0; $i<count($pageList); $i++){ ?>
                            <span name="user_part1" id="page<?php echo ($i+1) ;?>" style="display:inline-block;width:80px;text-align:center"><?php echo $pageList[$i]['page_name'];?></span>
                            <select name="user_part2" id="user_part2" class="input">
                              <option value=0>권한없음</option>   
                              <option value=1>일반</option>
                              <option value=2>팀관리자</option>  
                              <option value=3>관리자</option>
                            </select><br>
                        <?php } ?>
                        <!-- <img src="<?php echo $misc; ?>img/btn_add.jpg" style="cursor:pointer;float:right;margin-right:20px;" onclick = "addUserPart();"> -->
                      </div>
                    </td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">승인요청</td>
                    <td align="left" class="t_border" style="padding-left:10px;">
                    <select name="confirm_flag" id="confirm_flag" class="input">
                      <option value="Y">승인</option>
                      <option value="N">미승인</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*아이디</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="user_id" type="text" class="input" id="user_id" onkeyup="idcheck()"/><span id="id_message" style="display:inline"><span class="error_1">* 3자~12자의 영문,숫자만 사용</span></span></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">*비밀번호</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="user_password" type="password" class="input" id="user_password"/></td>
                  </tr>
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*회사명</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="company_name" type="text" class="input" id="company_name"/></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">*사업자등록번호</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="company_num" type="text" class="input" id="company_num" onclick="checkNum(this);" onKeyUp="checkNum(this);" maxlength="10"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">이름</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="user_name" type="text" class="input" id="user_name"/></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">직급</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="user_duty" type="text" class="input" id="user_duty"/></td>
                  </tr>
                  <!-- 부서 선영추가 -->
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">부서</td>
                    <td align="left" class="t_border" style="padding-left:10px;">
                      <select name="user_group" id="user_group" class="input">
                      <?php foreach($groupList as $group){ ?>
                        <option value="<?php echo $group['groupName']; ?>"><?php echo $group['groupName']; ?></option>
                      <?php } ?>
                      </select>
                    </td>
                  </tr>
                  <!-- 추가 끝 -->
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">이메일</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="user_email" type="text" class="input" id="user_email"/></td>
                    <td height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">연락처</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="user_tel" type="text" class="input" id="user_tel"/></td>
                  </tr>
                    
                    
                  <!--마지막라인-->
                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->
                </table></td>
              </tr>
              <!--//등록-->
              
              <tr>
                <td height="10"></td>
              </tr>
              <!--버튼-->
              <tr>
                <td align="right"><input type="image" src="<?php echo $misc;?>img/btn_ok.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;"/> <img src="<?php echo $misc;?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer" border="0" onclick="javascript:history.go(-1)"/></td>
              </tr>
              <!--//버튼-->
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
            <!--//내용-->
            
            </td>
      
        </tr>
     </table>
    
    </td>
  </tr>
  <!--하단-->
  <tr>
  	<td align="center" height="100" bgcolor="#CCCCCC"><table width="1130" cellspacing="0" cellpadding="0" >      
      <tr>
        <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img src="<?php echo $misc;?>img/f_ci.png"/></td>
        <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?></td>
      </tr>
    </table></td>
  </tr>
  <!--//하단-->
</form>
</table>
</body>
</html>