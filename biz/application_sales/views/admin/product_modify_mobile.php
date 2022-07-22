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

	if (mform.product_name.value == "") {
		mform.product_name.focus();
		alert("제품명을 입력해 주세요.");
		return false;
	}
  if (mform.product_name.value.indexOf(',') != -1){
    alert("제품명에 , 를 입력하실 수 없습니다.");
    $("#product_name").focus();
    return false;
  }
  if (mform.product_item.value.indexOf(',') != -1){
    alert("품목에 , 를 입력하실 수 없습니다.");
    $("#product_item").focus();
    return false;
  }
	if (mform.product_company.value == "") {
		mform.product_company.focus();
		alert("제조사를 입력해 주세요.");
		return false;
	}
	if (mform.product_item.value == "") {
		mform.product_item.focus();
		alert("품목을 입력해 주세요.");
		return false;
	}
	if (mform.hardware_spec.value == "") {
		mform.hardware_spec.focus();
		alert("하드웨어 스팩을 입력해 주세요.");
		return false;
	}

  if (mform.product_type.value == "") {
		mform.hardware_spec.focus();
		alert("하드웨어/소프트웨어를 구분해 주세요.");
		return false;
	}

	mform.submit();
	return false;
}

function chkForm2 () {
	if (confirm("정말 삭제하시겠습니까?") == true){
		var mform = document.cform;
		mform.action="<?php echo site_url();?>/admin/company/product_delete_action";
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
	<form name="cform" action="<?php echo site_url();?>/admin/company/product_input_action" method="post" onSubmit="javascript:chkForm();return false;">
		<input type="hidden" name="seq" value="<?php echo $seq;?>">
<div style="max-width:90%;margin: 0 auto; padding-bottom: 60px;margin-top:30px;">
	<div width="100%">
		<table class="basic_table">
			<col width="30%">
			<col width="70%">
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">제품명</td>
				<td>
					<input name="product_name" type="text" class="input-common" id="product_name" value="<?php echo $view_val['product_name'];?>"/>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">하드웨어/소프트웨어</td>
				<td>
					<select name ="product_type" id ="product_type" class="select-common" style="width:255px;">
						<option value="" <?php if($view_val['product_type'] == ''){echo "selected";} ?>>하드웨어/소프트웨어</option>
						<option value="hardware" <?php if($view_val['product_type'] == 'hardware'){echo "selected";} ?>>하드웨어</option>
						<option value="software" <?php if($view_val['product_type'] == 'software'){echo "selected";} ?>>소프트웨어</option>
						<option value="appliance" <?php if($view_val['product_type'] == 'appliance'){echo "selected";} ?>>어플라이언스</option>
					</select>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">제조사</td>
				<td>
					<input name="product_company" type="text" class="input-common" id="product_company" value="<?php echo $view_val['product_company'];?>"/>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">품목</td>
				<td>
					<input name="product_item" type="text" class="input-common" id="product_item" value="<?php echo $view_val['product_item'];?>"/>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">하드웨어 스펙</td>
				<td>
					<textarea name="hardware_spec" id="hardware_spec" class="textarea-common" style="resize:none; height:300px;"><?php echo $view_val['hardware_spec'];?></textarea>
				</td>
			</tr>
		</table>
		<div class="btn_div" style="margin-top:20px;text-align:right;">
			<input type="button" class="btn-common btn-color1" value="목록" onClick="javascript:history.go(-1);" style="margin-right:10px">
			<?php if($admin_lv > 0){ ?>
				<input type="button" class="btn-common btn-color1" value="수정" onclick="javascript:chkForm();return false;" style="margin-right:10px">
				<input type="button" class="btn-common btn-color1" value="삭제" onclick="javascript:chkForm2();return false;">
			<?php }?>
		</div>
	</div>
</div>
</form>
<!-- <div style="position:fixed;bottom:100px;right:5px;">
		<img src="<?php echo $misc; ?>img/mobile/btn_top.svg" onclick="$('html').scrollTop(0);">
</div> -->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
</html>
