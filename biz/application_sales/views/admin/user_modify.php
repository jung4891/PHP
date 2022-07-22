<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  if($admin_lv != 3){
    echo "<script>alert('권한이 없습니다.');history.go(-1);</script>";
  }
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style>
.list_tbl input:not(input[type=radio]), .list_tbl select {
	width: 210px !important;
}
textarea {
  resize:none;
  overflow-y:hidden;
  height:25px;
	box-sizing: border-box;
}
</style>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
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
		console.log(userPart);
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
	if (mform.user_birthday.value == "") {
		mform.user_birthday.focus();
		alert("생년월일을 입력해 주세요.");
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
		mform.action="<?php echo site_url();?>/admin/account/user_delete_action";
		mform.submit();
		return false;
	}
}
</script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
	<div class="dash1-1">
		<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<form name="cform" action="<?php echo site_url();?>/admin/account/modify_ok" method="get" onSubmit="javascript:chkForm();return false;">
				<input type="hidden" name="seq" value="<?php echo $seq;?>">
				<input type="hidden" name="user_part" value="">
				<input type="hidden" name="user_level" value="">
				<tr height="5%">
					<td class="dash_title">
						회원정보
					</td>
				</tr>
				<tr>
					<td height="40"></td>
				</tr>
				<tr>
					<td align="right">
		<?php if($view_val['quit_date'] == ''){ ?>
						<input type="button" class="btn-common btn-color1" value="권한 제거" onclick="quitopen();" style="margin-right:10px">
		<?php } ?>
		<?php if($sales_lv == 3) {?>
						<input type="button" class="btn-common btn-color4" value="삭제" onclick="javascript:chkForm2();return false;" style="margin-right:10px">
						<input type="button" class="btn-common btn-color4" value="수정" onclick="javascript:chkForm();return false;" style="margin-right:10px">
		<?php }?>
						<input type="button" class="btn-common btn-color2" value="목록" onClick="javascript:history.go(-1)">
					</td>
				</tr>
    		<tr>
      		<td width="100%" align="center" valign="top">
						<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border: thin solid #DFDFDF;margin-bottom:50px;margin-top:20px;">
							<colgroup>
								<col width="15%">
								<col width="35%">
								<col width="15%">
								<col width="35%">
							</colgroup>
        			<tr>
          			<td class="tbl-title">회원구분</td>
          			<td class="tbl-cell">
									두리안<input type="radio" name="cooperation_yn" value="N" <?php if($view_val['cooperation_yn'] == 'N'){echo 'checked';} ?>>
									외주<input type="radio" name="cooperation_yn" value="Y" <?php if($view_val['cooperation_yn'] == 'Y'){echo 'checked';} ?>>
							<?php
							$num = 0;
							for($i=0; $i<strlen($view_val['user_part']); $i++){
								// if(substr($view_val['user_part'],$i,1) != "0"){
									$num++;
							?>
									<div class="durian">
								<?php
								$part = array("비즈", "영업", "기술", "관리");
								for($i=0; $i<count($part); $i++){ ?>
										<span name="user_part1" id="page<?php echo ($i+1) ;?>" style="display:none;width:80px;text-align:center"><?php echo $part[$i];?></span>
										<select name="user_part2" id="user_part2" class="select-common">
											<option value=0 <?php if(substr($view_val['user_part'],$i,1) == "0"){echo "selected";} ?>>권한없음(<?php echo $part[$i];?>)</option>
											<option value=1 <?php if(substr($view_val['user_part'],$i,1) == "1"){echo "selected";} ?>>일반(<?php echo $part[$i];?>)</option>
											<option value=2 <?php if(substr($view_val['user_part'],$i,1) == "2"){echo "selected";} ?>>팀관리자(<?php echo $part[$i];?>)</option>
											<option value=3 <?php if(substr($view_val['user_part'],$i,1) == "3"){echo "selected";} ?>>관리자(<?php echo $part[$i];?>)</option>
										</select><br>
								<?php } ?>
									</div>
						<?php } ?>
								</td>
          			<td class="tbl-title">승인요청</td>
          			<td class="tbl-cell">
									<select name="confirm_flag" id="confirm_flag" class="select-common">
										<option value="Y" <?php if($view_val['confirm_flag'] == "Y") { echo "selected"; }?>>승인</option>
										<option value="N" <?php if($view_val['confirm_flag'] == "N") { echo "selected"; }?>>미승인</option>
									</select>
								</td>
              </tr>
              <tr>
                <td class="tbl-title">*아이디</td>
                <td class="tbl-cell"><input name="user_id" type="text" class="input-common" id="user_id" value="<?php echo $view_val['user_id'];?>" disabled/></td>
                <td class="tbl-title">*비밀번호</td>
                <td class="tbl-cell"><input name="user_password" type="password" class="input-common" id="user_password"/></td>
              </tr>
              <tr>
                <td class="tbl-title">*회사명</td>
                <td class="tbl-cell"><input name="company_name" type="text" class="input-common" id="company_name" value="<?php echo $view_val['company_name'];?>"/></td>
                <td class="tbl-title">*사업자등록번호</td>
                <td class="tbl-cell"><input name="company_num" type="text" class="input-common" id="company_num" value="<?php echo $view_val['company_num'];?>" onclick="checkNum(this);" onKeyUp="checkNum(this);" maxlength="10"/></td>
              </tr>
              <tr>
                <td class="tbl-title">이름</td>
                <td class="tbl-cell"><input name="user_name" type="text" class="input-common" id="user_name" value="<?php echo $view_val['user_name'];?>" disabled/></td>
								<td class="tbl-title durian">부서</td>
                <td class="tbl-cell durian">
									<select name="user_group" id="user_group" class="select-common">
										<?php if($view_val['quit_date'] != ''){ ?>
											<option value="<?php echo $view_val['user_group'] ?> selected"><?php echo $view_val['user_group'] ?></option>
										<?php } ?>
									<?php foreach($groupList as $group){ ?>
										<option value="<?php echo $group['groupName']; ?>" <?php if($view_val['user_group'] == $group['groupName']) { echo "selected"; }?>><?php echo $group['groupName']; ?></option>
									<?php } ?>
								</td>
              </tr>
              <tr>
								<td class="tbl-title">직급</td>
                <td class="tbl-cell"><input name="user_duty" type="text" class="input-common" id="user_duty" value="<?php echo $view_val['user_duty'];?>"/></td>
								<td class="tbl-title">직책</td>
                <td class="tbl-cell"><input name="user_position" type="text" class="input-common" id="user_position" value="<?php echo $view_val['user_position'];?>"/></td>
              </tr>
							<tr class="durian">
								<?php if($view_val['quit_date'] != ''){
									$date_text = "입사일 ~ 퇴사일";
								}else{
									$date_text = "입사일";
								}
								?>
		                <td class="tbl-title"><?php echo $date_text; ?></td>
		                <td class="tbl-cell">
											<input type="date" name="join_company_date" id="join_company_date" class="input-common" value="<?php echo $view_val['join_company_date'] ;?>" />
								<?php if($view_val['quit_date'] != ''){ ?>
											~ <input type="date" name="quit_date" id="quit_date" class="input-common" value="<?php echo $view_val['quit_date'] ;?>" />
								<?php } ?>
								<td class="tbl-title">최종진급일자</td>
                <td class="tbl-cell"><input type="date" name="update_date" id="update_date" class="input-common" value="<?php echo $view_val['update_date'] ;?>" /></td>
							</tr>
							<tr>
                <td class="tbl-title">이메일</td>
                <td class="tbl-cell"><input name="user_email" type="text" class="input-common" id="user_email" value="<?php echo $view_val['user_email'];?>"/></td>
                <td class="tbl-title">연락처</td>
                <td class="tbl-cell"><input name="user_tel" type="text" class="input-common" id="user_tel" value="<?php echo $view_val['user_tel'];?>"/></td>
              </tr>
							<tr class="durian">
                <td class="tbl-title">내선번호</td>
                <td class="tbl-cell"><input name="extension_number" type="text" class="input-common" id="extension_number" value="<?php echo $view_val['extension_number'];?>"/></td>
                <td class="tbl-cell"></td>
                <td class="tbl-cell"></td>
              </tr>
							<tr class="durian">
                <td class="tbl-title">법인카드 사용</td>
                <td class="tbl-cell">
									미사용<input type="radio" name="corporation_card_yn" value="N" style="width:20px !important;" <?php if($view_val['corporation_card_yn'] == "N"){echo 'checked';} ?>>
									사용<input type="radio" name="corporation_card_yn" value="Y" style="width:20px !important;" <?php if($view_val['corporation_card_yn'] == "Y"){echo 'checked';} ?>>
								</td>
                <td class="tbl-title corporation_card_num" style="<?php if($view_val['corporation_card_yn']=='N'){echo 'display:none;';} ?>">카드번호</td>
                <td class="tbl-cell corporation_card_num" style="<?php if($view_val['corporation_card_yn']=='N'){echo 'display:none;';} ?>">
									<input name="corporation_card_num" type="text" class="input-common" id="corporation_card_num" value="<?php echo $view_val['corporation_card_num'];?>"/>
								</td>
              </tr>
							<tr>
                <td class="tbl-title">생년월일</td>
                <td class="tbl-cell"><input name="user_birthday" type="date" class="input-common" id="user_birthday" value="<?php if($view_val['user_birthday']!=''){echo $view_val['user_birthday'];}?>"/></td>
                <td class="tbl-title">사인</td>
                <td class="tbl-cell">
					<?php if($view_val['sign_changename'] != '') { ?>
									<img src="/misc/upload/user_sign/<?php echo $view_val['sign_changename']; ?>" style="height:40px;" alt="">
					<?php } ?>
								</td>
              </tr>
							<tr>
								<td class="tbl-title">비고</td>
								<td class="tbl-cell" colspan="3" style="padding:0px 10px;">
									<textarea name="note" class="textarea-common" style="width:100%;box-sizing:border-box;" onkeyup="resize(this)"><?php echo $view_val['note']; ?></textarea>
								</td>
							</tr>
            </table>
					</td>
				</tr>
			</form>
		</table>


		<div id="quit_div" style="display:none; position: absolute; background-color: white; width: 300px; height: 200px; border-radius:5px;">
			<form method="post" id="qform">
				<table style="margin:10px 30px; border-collapse: separate; border-spacing: 0;">
					<colgroup>
						<col width="30%">
						<col width="70%">
					</colgroup>
					<tr>
						<td height="20"></td>
					</tr>
					<tr>
						<td colspan="2" class="modal_title" align="left" style="padding-bottom:10px; font-size:20px; font-weight:bold;">
						회원 권한 제거
						</td>
					</tr>
					<tr>
						<td height="20"></td>
					</tr>
					<tr class="tbl-tr">
						<td align="left" valign="center" style="font-weight:bold; width:10%;">퇴사일</td>
						<td align="left">
							<input type="hidden" name="user_seq" id="user_seq" value="<?php echo $seq;?>">
							<input type="date" name="quit_date" id="quit_date" value="">
						</td>
					</tr>
					<tr>
						<td height="20"></td>
					</tr>
					<tr>
						<td style="width:17%;"></td>
						<td align="right">
							<input type="button" class="btn-common btn-color4" style="width:70px; margin-right:10px;" value="취소" onclick="$('#quit_div').bPopup().close();">
							<input type="button" class="btn-common btn-color2" style="width:70px;" value="확인" onclick="quit_confirm();">
						</td>
					</tr>
				</table>
			</form>
		</div>


	</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script>
$(function() {
	$('textarea[name=note]').keyup();
	$('input[name=cooperation_yn]').change();
})

function quitopen(){
	$("#quit_div").bPopup({
		speed: 450,
		transition: 'slideDown'
	})
}

function quit_confirm(){
	var quit_date = $("#quit_date").val();
	if(quit_date == ""){

		alert("날짜를 입력해주세요.");
		return false;
	}

var act = "<?php echo site_url();?>/admin/account/resignation";
$("#qform").attr("action", act);
$("#qform").submit();

}

$('input[name="corporation_card_yn"]').on('change', function() {
	if($(this).val() == 'Y') {
		$('.corporation_card_num').show();
	} else {
		$('.corporation_card_num').hide();
	}
})

function resize(el) {
	el.style.height = '26px';
	el.style.height = el.scrollHeight + 'px';
}

$('input[name=cooperation_yn]').change(function() {
	var chk_val = $('input[name=cooperation_yn]:checked').val();

	if(chk_val == 'Y') {
		$('.durian').hide();
	} else {
		$('.durian').show();
	}
})
</script>
</html>
