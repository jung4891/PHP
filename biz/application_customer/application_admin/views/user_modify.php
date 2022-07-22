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

function chkForm () {
	var mform = document.cform;
  var userPart = '';

  //11을 011로 자릿수에 맞춰주는 함수
  function pad(n, width) {
    n = n + '';
    return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
  }

  // for(i=0; i<document.getElementsByName('user_part1').length; i++){
  //   userPart = Number(userPart)+Number(document.getElementsByName('user_part1')[i].value)*Number(document.getElementsByName('user_part2')[i].value);
  // }

  for(i=0; i<document.getElementsByName('user_part1').length; i++){
    userPart = userPart+document.getElementsByName('user_part2')[i].value;
  }

  mform.user_part.value = pad(userPart,3);
	
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
	
	if (mform.user_part.value == "004") {
		mform.user_level.value = "3";
	} else {
		mform.user_level.value = "1";
	}
	
	mform.submit();
	return false;
}

function chkForm2 () {
	if (confirm("정말 삭제하시겠습니까?") == true){
		var mform = document.cform;
		mform.action="<?php echo site_url();?>/account/user_delete_action";
		mform.submit();
		return false;
	}
}
</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="cform" action="<?php echo site_url();?>/account/modify_ok" method="get" onSubmit="javascript:chkForm();return false;">
<input type="hidden" name="seq" value="<?php echo $seq;?>">
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
                    <?php
                    $num = 0; 
                    for($i=0; $i<strlen($view_val['user_part']); $i++){
                      // if(substr($view_val['user_part'],$i,1) != "0"){
                        $num++;
                    ?>
                      <div>
                        <!-- <select name="user_part1" id="user_part1" class="input">
                          <option value=100 <?php if($i == "0" and substr($view_val['user_part'],$i,1) != "0"){echo "selected";} ?>>영업</option> 
                          <option value=10 <?php if($i == "1" and substr($view_val['user_part'],$i,1)  != "0"){echo "selected";} ?>>기술</option>
                          <option value=1 <?php if($i == "2" and substr($view_val['user_part'],$i,1)  != "0"){echo "selected";} ?>>관리자</option>
                        </select> -->
                        <!-- <select name="user_part2" id="user_part2" class="input">
                          <option value=1 <?php if(substr($view_val['user_part'],$i,1) == "1"){echo "selected";} ?>>일반</option> 
                          <option value=3 <?php if(substr($view_val['user_part'],$i,1) == "3"){echo "selected";} ?>>관리자</option>
                        </select> -->
                        <?php for($i=0; $i<count($pageList); $i++){ ?>
                            <span name="user_part1" id="page<?php echo ($i+1) ;?>" style="display:inline-block;width:80px;text-align:center"><?php echo $pageList[$i]['page_name'];?></span>
                            <select name="user_part2" id="user_part2" class="input">
                              <option value=0 <?php if(substr($view_val['user_part'],$i,1) == "0"){echo "selected";} ?>>권한없음</option>   
                              <option value=1 <?php if(substr($view_val['user_part'],$i,1) == "1"){echo "selected";} ?>>일반</option>
                              <option value=2 <?php if(substr($view_val['user_part'],$i,1) == "2"){echo "selected";} ?>>팀관리자</option>  
                              <option value=3 <?php if(substr($view_val['user_part'],$i,1) == "3"){echo "selected";} ?>>관리자</option>
                            </select><br>
                        <?php } ?>
                      </div>
                    <?php 
                    // }
                  }
                     ?>
                    </td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">승인요청</td>
                    <td align="left" class="t_border" style="padding-left:10px;">
                    <select name="confirm_flag" id="confirm_flag" class="input">
                      <option value="Y" <?php if($view_val['confirm_flag'] == "Y") { echo "selected"; }?>>승인</option>
                      <option value="N" <?php if($view_val['confirm_flag'] == "N") { echo "selected"; }?>>미승인</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*아이디</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="user_id" type="text" class="input" id="user_id" value="<?php echo $view_val['user_id'];?>" disabled/></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">*비밀번호</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="user_password" type="password" class="input" id="user_password"/></td>
                  </tr>
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*회사명</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="company_name" type="text" class="input" id="company_name" value="<?php echo $view_val['company_name'];?>"/></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">*사업자등록번호</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="company_num" type="text" class="input" id="company_num" value="<?php echo $view_val['company_num'];?>" id="company_num" onclick="checkNum(this);" onKeyUp="checkNum(this);" maxlength="10"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">이름</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="user_name" type="text" class="input" id="user_name" value="<?php echo $view_val['user_name'];?>" disabled/></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">직급</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="user_duty" type="text" class="input" id="user_duty" value="<?php echo $view_val['user_duty'];?>"/></td>
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
                        <option value="<?php echo $group['groupName']; ?>" <?php if($view_val['user_group'] == $group['groupName']) { echo "selected"; }?>><?php echo $group['groupName']; ?></option>
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
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="user_email" type="text" class="input" id="user_email" value="<?php echo $view_val['user_email'];?>"/></td>
                    <td height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">연락처</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="user_tel" type="text" class="input" id="user_tel" value="<?php echo $view_val['user_tel'];?>"/></td>
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
                <td align="right">
                  <img src="<?php echo $misc;?>img/btn_list.jpg" width="64" height="31" onClick="javascript:history.go(-1)" style="cursor:pointer"/>
                  <?php if($at == "777") {?>
                    <input type="image" src="<?php echo $misc;?>img/btn_adjust.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;"/>
                    <img src="<?php echo $misc;?>img/btn_delete.jpg" width="64" height="31" style="cursor:pointer" border="0" onclick="javascript:chkForm2();return false;"/>
                  <?php } ?>  
              </td>
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