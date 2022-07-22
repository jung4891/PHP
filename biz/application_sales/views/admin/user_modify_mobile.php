<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style media="screen">
.basic_table{
	width:100%;
	 border-collapse:collapse;
	 border:1px solid;
	 border-color:#DEDEDE;
	 table-layout: auto !important;
	 border-left:none;
	 border-right:none;
}

.basic_table td{
	height:35px;
	 padding:0px 10px 0px 10px;
	 border:1px solid;
	 border-color:#DEDEDE;
}
.border_n {
	border:none;
}
.border_n td {
	border:none;
}
.basic_table tr > td:first-child {
	border-left:none;
}
.basic_table tr > td:last-child {
	border-right:none;
}
.contents_div {
	overflow-x: scroll;
	white-space: nowrap;
}
.dayBtn {
	background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
	background-size: 20px;
}
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
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style media="screen">
	.input-common, .select-common, .textarea-common {
		box-sizing: border-box;
		border-radius: 3px;
		width: 100%;
	}
</style>
<body>
<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
	?>
	<form name="cform" action="<?php echo site_url();?>/admin/account/modify_ok" method="get" onSubmit="javascript:chkForm();return false;">
		<input type="hidden" name="seq" value="<?php echo $seq;?>">
		<input type="hidden" name="user_part" value="">
		<input type="hidden" name="user_level" value="">
<div style="max-width:90%;margin: 0 auto; padding-bottom: 60px;margin-top:30px;">
	<div width="100%">
		<table class="basic_table">
			<col width="30%">
			<col width="70%">
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">회원구분</td>
				<td>
					<?php
					$num = 0;
					for($i=0; $i<strlen($view_val['user_part']); $i++){
						// if(substr($view_val['user_part'],$i,1) != "0"){
							$num++;
					?>
							<div>
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
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">승인요청</td>
				<td>
					<select name="confirm_flag" id="confirm_flag" class="select-common">
						<option value="Y" <?php if($view_val['confirm_flag'] == "Y") { echo "selected"; }?>>승인</option>
						<option value="N" <?php if($view_val['confirm_flag'] == "N") { echo "selected"; }?>>미승인</option>
					</select>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">*아이디</td>
				<td>
					<input name="user_id" type="text" class="input-common" id="user_id" value="<?php echo $view_val['user_id'];?>" disabled/>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">*비밀번호</td>
				<td>
					<input name="user_password" type="password" class="input-common" id="user_password"/>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">*회사명</td>
				<td>
					<input name="company_name" type="text" class="input-common" id="company_name" value="<?php echo $view_val['company_name'];?>"/>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">*사업자등록번호</td>
				<td>
					<input name="company_num" type="text" class="input-common" id="company_num" value="<?php echo $view_val['company_num'];?>" onclick="checkNum(this);" onKeyUp="checkNum(this);" maxlength="10"/>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">이름</td>
				<td>
					<input name="user_name" type="text" class="input-common" id="user_name" value="<?php echo $view_val['user_name'];?>" disabled/>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">직급</td>
				<td>
					<input name="user_duty" type="text" class="input-common" id="user_duty" value="<?php echo $view_val['user_duty'];?>"/>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">부서</td>
				<td>
					<select name="user_group" id="user_group" class="select-common">
						<?php if($view_val['quit_date'] != ''){ ?>
							<option value="<?php echo $view_val['user_group'] ?> selected"><?php echo $view_val['user_group'] ?></option>
						<?php } ?>
					<?php foreach($groupList as $group){ ?>
						<option value="<?php echo $group['groupName']; ?>" <?php if($view_val['user_group'] == $group['groupName']) { echo "selected"; }?>><?php echo $group['groupName']; ?></option>
					<?php } ?>
				</td>
			</tr>
			<?php if($view_val['quit_date'] != ''){
				$date_text = "입사일 ~ 퇴사일";
			}else{
				$date_text = "입사일";
			}
			?>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;"><?php echo $date_text; ?></td>
				<td>
					<input type="date" name="join_company_date" id="join_company_date" class="input-common dayBtn" value="<?php echo $view_val['join_company_date'] ;?>" />
		<?php if($view_val['quit_date'] != ''){ ?>
					~ <input type="date" name="quit_date" id="quit_date" class="input-common dayBtn" value="<?php echo $view_val['quit_date'] ;?>" />
		<?php } ?>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">이메일</td>
				<td>
					<input name="user_email" type="text" class="input-common" id="user_email" value="<?php echo $view_val['user_email'];?>"/>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">연락처</td>
				<td>
					<input name="user_tel" type="text" class="input-common" id="user_tel" value="<?php echo $view_val['user_tel'];?>"/>
				</td>
			</tr>
		</table>
		<div class="btn_div" style="margin-top:20px;text-align:right;">
			<?php if($sales_lv == 3) { ?>
				<?php if($view_val['quit_date'] == ''){ ?>
								<input type="button" class="btn-common btn-color1" value="권한 제거" onclick="quitopen();">
				<?php } ?>
			<?php } ?>
		</div>
		<div class="btn_div" style="margin-top:10px;text-align:right;">
			<input type="button" class="btn-common btn-color1" value="목록" onClick="javascript:history.go(-1);" style="margin-right:10px">
			<?php if($sales_lv == 3) { ?>
				<input type="button" class="btn-common btn-color1" value="수정" onclick="javascript:chkForm();return false;" style="margin-right:10px">
				<input type="button" class="btn-common btn-color1" value="삭제" onclick="javascript:chkForm2();return false;">
			<?php }?>
		</div>
	</div>
</div>
</form>

<div id="quit_div" style="height:auto;width:300px;background-color:#ffffff; display:none;border-radius:5px;">
	<div class="modal_contain" style="font-size:16px; color:#1C1C1C;font-weight:bold;">
		<form method="post" id="qform">
			<table style="width:100%;padding:5%;" cellspacing="0">
				<colgroup>
					<col width="50%">
					<col width="50%">
				</colgroup>
				<tr>
					<td align="left" height="40">퇴사일</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="user_seq" id="user_seq" value="<?php echo $seq;?>">
						<input type="date" class="input-common dayBtn" name="quit_date" id="quit_date" value="">
					</td>
				</tr>
				<tr>
					<td height="20"></td>
				</tr>
				<tr>
					<td>
						<input type="button" class="btn-common btn-color1" style="width:95%; border-radius:3px;" value="취소" onclick="$('#quit_div').bPopup().close();">
					</td>
					<td align="right">
						<input type="button" class="btn-common btn-color2" style="width:95%; border-radius:3px;" value="확인" onclick="quit_confirm();">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<!-- <div style="position:fixed;bottom:100px;right:5px;">
		<img src="<?php echo $misc; ?>img/mobile/btn_top.svg" onclick="$('html').scrollTop(0);">
</div> -->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script>
function quitopen(){
	$("#quit_div").bPopup();
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
</script>
</html>
