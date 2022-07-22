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
</style>
<script language="javascript">

function chkForm () {
	var mform = document.cform;

	if (mform.room_name.value == "") {
		mform.room_name.focus();
		alert("회의실 명을 입력해 주세요.");
		return false;
	}
	if (mform.location.value == "") {
		mform.location.focus();
		alert("위치를 입력해 주세요.");
		return false;
	}

	mform.submit();
	return false;
}

function chkForm2 () {
	if (confirm("정말 삭제하시겠습니까?") == true){
		var mform = document.cform;
		mform.action="<?php echo site_url();?>/admin/equipment/meeting_room_delete_action";
		mform.submit();
		return false;
	}
}
</script>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style media="screen">
	.input-common {
		width: 100%;
		box-sizing: border-box;
	}
</style>
<body>
<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
	?>
<div style="max-width:90%;margin: 0 auto; padding-bottom: 60px;margin-top:30px;">
	<div width="100%">
		<form name="cform" action="<?php echo site_url();?>/admin/equipment/meeting_room_input_action" method="post" onSubmit="javascript:chkForm();return false;">
			<input type="hidden" name="seq" value="<?php echo $seq;?>">
			<table class="basic_table">
				<col width="30%">
				<col width="70%">
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">*회의실 명</td>
					<td>
						<input name="room_name" type="text" class="input-common" id="room_name" value="<?php echo stripslashes($view_val['room_name']);?>"/>
					</td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">*위치</td>
					<td>
						<input name="location" type="text" class="input-common" id="location" value="<?php echo stripslashes($view_val['location']);?>"/>
					</td>
				</tr>
				</table>
				<div class="btn_div" style="margin-top:20px;">
					<?php if($admin_lv == 3){?>
						<input type="button" class="btn-common btn-color1" value="삭제" onclick="javascript:chkForm2();return false;" style="float:right;">
						<input type="button" class="btn-common btn-color1" value="수정" onclick="javascript:chkForm();return false;" style="float:right;margin-right:10px;">
					<?php } ?>
					<input type="button" class="btn-common btn-color1" value="목록" onClick="javascript:history.go(-1)" style="float:right;margin-right:10px;">
				</div>
		</form>
	</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
</html>
