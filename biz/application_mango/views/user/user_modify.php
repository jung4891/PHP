<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css_mango/view_page_common_mango.css">
<style media="screen">
.basic_table {
	border: 1px solid #DEDEDE;
}
.list_tbl {
	border-top: 1px solid #DEDEDE;
	border-bottom: none;
}
.border-l {
	border-left: 1px solid #DEDEDE;
}
.border-r {
	border-right: 1px solid #DEDEDE;
}
.box-file-input label{
  display:inline-block;
  background:#565656;
  color:#fff;
  cursor:pointer;
	border-radius: 3px;
	padding: 0px 15px;
	height:25px;
	line-height:23px;
}
.box-file-input label:after{
  content:"파일찾기";
}
.box-file-input .file-input{
  display:none;
}
.filename_div {
	width:175px;
	float:left;
}
.filename {
	width:175px;
	overflow: hidden;
	text-overflow:ellipsis;
}
.box-file-input .filename{
  display:inline-block;
	line-height:26px;
}
</style>
<script type="text/javascript">
	$(document).on("change", ".file-input", function(){
		$filename = $(this).val();
		if($filename == "") {
			$filename = "파일을 선택해주세요.";
		} else {
			$filename = $filename.split('\\');
			$filename = $filename[$filename.length - 1];
			console.log($filename);
		}
		$(this).closest("div").find(".filename").text($filename);
	})
</script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/mango_header.php";
?>
	<div align="center">
		<div class="dash1-1">
			<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
				<form name="cform" action="<?php echo site_url();?>/user/user_modify_action" method="post" onSubmit="javascript:chkForm();return false;" enctype="multipart/form-data">
					<input type="hidden" name="seq" id="seq" value="<?php echo $seq;?>">
					<tr>
	  				<td class="dash_title">
							회원관리
						</td>
					</tr>
					<tr>
						<td align="right">
							<input style="margin-top:20px;margin-right:5px;" type="button" class="btn-common btn-color1 btn-size1" value="취소" onClick="javascript:history.go(-1)">
							<input style="margin-top:20px;margin-right:5px;" type="button" class="btn-common btn-color1 btn-size1" value="삭제" onClick="javascript:chkForm2();return false;">
							<input style="margin-top:20px;" type="button" class="btn-common btn-color4 btn-size1" value="수정" onClick="javascript:chkForm();return false;">
						</td>
					</tr>
  				<tr>
    				<td align="center" valign="top">

    					<table width="100%" height="100%" cellspacing="0" cellpadding="0" >
        				<tr>
            			<td width="100%" align="center" valign="top">
            				<table width="100%" border="0" style="margin-top:20px;">
              				<tr>
                				<td>
													<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
														<colgroup>
															<col width="15%">
															<col width="35%">
															<col width="15%">
															<col width="35%">
														</colgroup>
														<tr>
															<td height="40" class="tbl-title2">회원구분</td>
															<td align="left" style="padding-left:10px;">
																<select class="select-common" name="admin" style="width:250px;">
																	<option value="N" <?php if($view_val['admin']=='N'){echo "selected";} ?>>직원</option>
																	<option value="Y" <?php if($view_val['admin']=='Y'){echo "selected";} ?>>관리자</option>
																</select>
															</td>
					          					<td height="40" class="tbl-title2">승인요청</td>
					                    <td align="left" style="padding-left:10px;">
																<select class="select-common" name="confirm_flag" style="width:250px;">
																	<option value="N" <?php if($view_val['confirm_flag']=='N'){echo "selected";} ?>>미승인</option>
																	<option value="Y" <?php if($view_val['confirm_flag']=='Y'){echo "selected";} ?>>승인</option>
																</select>
															</td>
                  					</tr>
														<tr>
															<td height="40" class="tbl-title2"><span style="color:red;">*</span>아이디</td>
															<td align="left" style="padding-left:10px;">
																<input type="text" class="input-common" name="user_id" value="<?php echo $view_val['user_id']; ?>" disabled>
															</td>
					          					<td height="40" class="tbl-title2">비밀번호</td>
					                    <td align="left" style="padding-left:10px;">
																<input type="password" class="input-common" name="user_password" value="">
															</td>
                  					</tr>
														<tr>
															<td height="40" class="tbl-title2"><span style="color:red;">*</span>이름</td>
															<td align="left" style="padding-left:10px;">
																<input type="text" class="input-common" name="user_name" value="<?php echo $view_val['user_name']; ?>" disabled>
															</td>
					          					<td height="40" class="tbl-title2"><span style="color:red;">*</span>이메일</td>
					                    <td align="left" style="padding-left:10px;">
																<input type="text" class="input-common" name="user_email" value="<?php echo $view_val['user_email']; ?>">
															</td>
                  					</tr>
														<tr>
															<td height="40" class="tbl-title2">전화번호</td>
															<td align="left" style="padding-left:10px;">
																<input type="text" class="input-common" name="user_tel" value="<?php echo $view_val['user_tel']; ?>">
															</td>
					          					<td height="40" class="tbl-title2">보건증 기간</td>
					                    <td align="left" style="padding-left:10px;">
																<input type="text" class="input-common datepicker" name="health_certificate_term_s" value="<?php echo $view_val['health_certificate_term_s']; ?>" style="width:100px;">
																~
																<input type="text" class="input-common datepicker" name="health_certificate_term_e" value="<?php echo $view_val['health_certificate_term_e']; ?>" style="width:100px;">
															</td>
                  					</tr>

														<tr>
															<td height="40" class="tbl-title2">보건증</td>
															<td align="left" style="padding-left:10px;">
												<?php if($view_val['health_changename'] == '') { ?>
																<div class="box-file-input">
																	<div class="filename_div">
																		<span class="filename">파일을 선택해주세요.
																	</div>
																	<label style="float:left;">
																		<input type="file" name="files[]" class="file-input" accept="image/*" id="health_file">
																	</label>
																</div>
												<?php } else {
																echo "<p style='line-height:30px;'>";
																echo $view_val['health_realname'];
																$href = "/misc/upload_mango/user/{$view_val['health_changename']}"; ?>
																<input type="file" name="files[]" id="health_file" style="display:none;" value="">
																<input type="button" class="btn-common btn-color4 btn-size1" style="padding:0;width:35px;float:right;height:24px;margin-top:2px;margin-right:10px;" onclick="dbDeleteFile('health', '<?php echo $view_val['health_changename']; ?>'); return false;" value="삭제">

																<span style="margin-left:10px;margin-right:10px;margin-top:3px;border: 1px solid #D1D1D1;border-radius: 3px;padding:2px;font-weight:bold;line-height:18px;" class="down_btn">
																	<a href="<?php echo $href; ?>" download="<?php echo $view_val['health_realname']; ?>">
																		<img src="/misc/img/download_btn.svg" width="12px;" style="margin-right:2px;">
																		다운로드
																	</a>
																</span>
																</p>
												<?php } ?>
															</td>
															<td height="40" class="tbl-title2">이력서</td>
															<td align="left" style="padding-left:10px;">
												<?php if($view_val['resume_changename'] == '') { ?>
																<div class="box-file-input">
																	<div class="filename_div">
																		<span class="filename">파일을 선택해주세요.
																	</div>
																	<label style="float:left;">
																		<input type="file" name="files[]" class="file-input" accept="image/*" id="resume_file">
																	</label>
																</div>
												<?php } else {
																echo "<p style='line-height:30px;'>";
																echo $view_val['resume_realname'];
																$href = "/misc/upload_mango/user/{$view_val['resume_changename']}"; ?>
																<input type="file" name="files[]" id="resume_file" style="display:none;" value="">
																<input type="button" class="btn-common btn-color4 btn-size1" style="padding:0;width:35px;float:right;height:24px;margin-top:2px;margin-right:10px;" onclick="dbDeleteFile('resume', '<?php echo $view_val['resume_changename']; ?>'); return false;" value="삭제">

																<span style="margin-left:10px;margin-right:10px;margin-top:3px;border: 1px solid #D1D1D1;border-radius: 3px;padding:2px;font-weight:bold;line-height:18px;" class="down_btn">
																	<a href="<?php echo $href; ?>" download="<?php echo $view_val['resume_changename']; ?>">
																		<img src="/misc/img/download_btn.svg" width="12px;" style="margin-right:2px;">
																		다운로드
																	</a>
																</span>
																</p>
												<?php } ?>
															</td>
														</tr>
														<tr>
															<td height="40" class="tbl-title2">등본</td>
															<td align="left" style="padding-left:10px;border-right:none;">
												<?php if($view_val['attestedcopy_changename'] == '') { ?>
																<div class="box-file-input">
																	<div class="filename_div">
																		<span class="filename">파일을 선택해주세요.
																	</div>
																	<label style="float:left;">
																		<input type="file" name="files[]" class="file-input" accept="image/*" id="attestedcopy_file">
																	</label>
																</div>
												<?php } else {
																echo "<p style='line-height:30px;'>";
																echo $view_val['attestedcopy_realname'];
																$href = "/misc/upload_mango/user/{$view_val['attestedcopy_changename']}"; ?>
																<input type="file" name="files[]" id="attestedcopy_file" style="display:none;" value="">
																<input type="button" class="btn-common btn-color4 btn-size1" style="padding:0;width:35px;float:right;height:24px;margin-top:2px;margin-right:10px;" onclick="dbDeleteFile('attestedcopy', '<?php echo $view_val['attestedcopy_changename']; ?>'); return false;" value="삭제">

																<span style="margin-left:10px;margin-right:10px;margin-top:3px;border: 1px solid #D1D1D1;border-radius: 3px;padding:2px;font-weight:bold;line-height:18px;" class="down_btn">
																	<a href="<?php echo $href; ?>" download="<?php echo $view_val['attestedcopy_changename']; ?>">
																		<img src="/misc/img/download_btn.svg" width="12px;" style="margin-right:2px;">
																		다운로드
																	</a>
																</span>
																</p>
												<?php } ?>
															</td>
															<td colspan="2"></td>
														</tr>
                						</table>

														<p style="font-weight:bold;font-size:18px;margin-top:30px;margin-bottom:20px;">근무시간표</p>

														<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
															<colgroup>
																<col width="20%">
																<col width="16%">
																<col width="16%">
																<col width="16%">
																<col width="16%">
																<col width="16%">
															</colgroup>
															<tr>
																<td class="tbl-title2"></td>
																<td class="tbl-title2" style="text-align:center;padding-left:0px;">월요일</td>
																<td class="tbl-title2" style="text-align:center;padding-left:0px;">화요일</td>
																<td class="tbl-title2" style="text-align:center;padding-left:0px;">수요일</td>
																<td class="tbl-title2" style="text-align:center;padding-left:0px;">목요일</td>
																<td class="tbl-title2" style="text-align:center;padding-left:0px;">금요일</td>
															</tr>
<?php
$stime_arr = explode('*/*', $view_val['work_start']);
$etime_arr = explode('*/*', $view_val['work_end']);
?>

															<tr>
																<td class="tbl-title2">근무시작시간</td>
																<td style="padding:3px 10px;">
																	<input type="text" class="input-common timepicker" name="work_start[]" style="box-sizing:border-box;width:100%;" value="<?php if(isset($stime_arr[0])){echo $stime_arr[0];} ?>" readonly>
																</td>
																<td style="padding:3px 10px;">
																	<input type="text" class="input-common timepicker" name="work_start[]" style="box-sizing:border-box;width:100%;" value="<?php if(isset($stime_arr[1])){echo $stime_arr[1];} ?>" readonly>
																</td>
																<td style="padding:3px 10px;">
																	<input type="text" class="input-common timepicker" name="work_start[]" style="box-sizing:border-box;width:100%;" value="<?php if(isset($stime_arr[2])){echo $stime_arr[2];} ?>" readonly>
																</td>
																<td style="padding:3px 10px;">
																	<input type="text" class="input-common timepicker" name="work_start[]" style="box-sizing:border-box;width:100%;" value="<?php if(isset($stime_arr[3])){echo $stime_arr[3];} ?>" readonly>
																</td>
																<td style="padding:3px 10px;">
																	<input type="text" class="input-common timepicker" name="work_start[]" style="box-sizing:border-box;width:100%;" value="<?php if(isset($stime_arr[4])){echo $stime_arr[4];} ?>" readonly>
																</td>
															</tr>
															<tr>
																<td class="tbl-title2">근무종료시간</td>
																<td style="padding:3px 10px;">
																	<input type="text" class="input-common timepicker" name="work_end[]" style="box-sizing:border-box;width:100%;" value="<?php if(isset($etime_arr[0])){echo $etime_arr[0];} ?>" readonly>
																</td>
																<td style="padding:3px 10px;">
																	<input type="text" class="input-common timepicker" name="work_end[]" style="box-sizing:border-box;width:100%;" value="<?php if(isset($etime_arr[1])){echo $etime_arr[1];} ?>" readonly>
																</td>
																<td style="padding:3px 10px;">
																	<input type="text" class="input-common timepicker" name="work_end[]" style="box-sizing:border-box;width:100%;" value="<?php if(isset($etime_arr[2])){echo $etime_arr[2];} ?>" readonly>
																</td>
																<td style="padding:3px 10px;">
																	<input type="text" class="input-common timepicker" name="work_end[]" style="box-sizing:border-box;width:100%;" value="<?php if(isset($etime_arr[3])){echo $etime_arr[3];} ?>" readonly>
																</td>
																<td style="padding:3px 10px;">
																	<input type="text" class="input-common timepicker" name="work_end[]" style="box-sizing:border-box;width:100%;" value="<?php if(isset($etime_arr[4])){echo $etime_arr[4];} ?>" readonly>
																</td>
															</tr>
														</table>
													</td>
              					</tr>
            					</table>
            				</td>
        					</tr>
     						</table>
    					</td>
  					</tr>
					</form>
				</table>
			</div>
		</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/mango_bottom.php"; ?>
</body>
<link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="/misc/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/misc/js/bootstrap-timepicker.js"></script>
<script language="javascript">
$(function() {
	$('.timepicker').timepicker({
			minuteStep: 10,
			showMeridian: false,
			defaultTime: null
	});
	$('.datepicker').datepicker();
})

function chkForm2 () {
	if (confirm("정말 삭제하시겠습니까?") == true){
		var mform = document.cform;
		mform.action="<?php echo site_url();?>/user/user_delete_action";
		mform.submit();
		return false;
	}
}

function chkForm () {
	var mform = document.cform;

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

	mform.submit();
	return false;
}

function dbDeleteFile(target, fname) {
	var seq = $('#seq').val();

	if(confirm("파일을 삭제하시겠습니까?")) {
		$.ajax({
			url: "<?php echo site_url(); ?>/user/del_file",
			type: "POST",
			dataType: "json",
			data: {
				seq: seq,
				target: target,
				fname: fname
			},
			cache: false,
			async: false,
			success: function(data) {
				if(data) {
					alert('삭제되었습니다.');
					location.reload();
				} else {
					alert('삭제에 실패하였습니다.');
					location.reload();
				}
			}
		})
	}
}
</script>
</html>
