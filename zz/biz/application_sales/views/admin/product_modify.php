<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
	p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
</style>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> <!-- 조직도 생성 -->
<link rel="stylesheet" href="/misc/css/tech_schedule/proton/style.min.css" /> <!-- 조직도 생성 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
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
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
	<div class="dash1-1">
		<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<form name="cform" action="<?php echo site_url();?>/admin/company/product_input_action" method="post" onSubmit="javascript:chkForm();return false;">
				<input type="hidden" name="seq" value="<?php echo $seq;?>">
				<tr height="5%">
					<td class="dash_title">
						제품명
					</td>
				</tr>
				<tr>
					<td height="40"></td>
				</tr>
				<tr>
					<td align="right">
		<?php if($admin_lv > 0){ ?>
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
          			<td class="tbl-title">제품명</td>
          			<td class="tbl-cell">
									<input name="product_name" type="text" class="input-common" id="product_name" value="<?php echo $view_val['product_name'];?>"/>
								</td>
          			<td class="tbl-title">하드웨어/소프트웨어</td>
          			<td class="tbl-cell">
									<select name ="product_type" id ="product_type" class="select-common" style="width:255px;">
										<option value="" <?php if($view_val['product_type'] == ''){echo "selected";} ?>>하드웨어/소프트웨어</option>
										<option value="hardware" <?php if($view_val['product_type'] == 'hardware'){echo "selected";} ?>>하드웨어</option>
										<option value="software" <?php if($view_val['product_type'] == 'software'){echo "selected";} ?>>소프트웨어</option>
										<option value="appliance" <?php if($view_val['product_type'] == 'appliance'){echo "selected";} ?>>어플라이언스</option>
									</select>
								</td>
              </tr>
              <tr>
                <td class="tbl-title">제조사</td>
                <td class="tbl-cell">
									<input name="product_company" type="text" class="input-common" id="product_company" value="<?php echo $view_val['product_company'];?>"/>
								</td>
                <td class="tbl-title">품목</td>
                <td class="tbl-cell">
									<input name="product_item" type="text" class="input2" id="product_item" value="<?php echo $view_val['product_item'];?>"/>
								</td>
              </tr>
              <tr>
								<td colspan="4" class="tbl-title">하드웨어스펙</td>
              </tr>
							<tr>
								<td colspan="4" class="tbl-contents" style="padding-top:10px;">
									<textarea name="hardware_spec" id="hardware_spec" class="input2" style="resize:none; width:98%; height:300px;"><?php echo $view_val['hardware_spec'];?></textarea>
								</td>
							</tr>
            </table>
					</td>
				</tr>
			</form>
		</table>
	</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
</html>
