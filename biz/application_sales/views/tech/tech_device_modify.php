<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style>
.select2-selection{
	font-family:"Noto Sans KR", sans-serif !important;
  font-size:12px;
  border: 1px solid #DEDEDE !important;
  border-radius: 20px !important;
  opacity: 1 !important;
  outline: none !important;
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<script language="javascript">

  var k =9;

  var chkForm = function () {
    var mform = document.cform;

    if (mform.product_host.value.indexOf(',') != -1){
      alert("host에 , 를 입력하실 수 없습니다.");
      $("#product_host").focus();
      return false;
    }

    if (mform.product_licence.value.indexOf(',') != -1){
      alert("라이선스에 , 를 입력하실 수 없습니다.");
      $("#product_licence").focus();
      return false;
    }

    if (mform.product_version.value.indexOf(',') != -1){
      alert("Version에 , 를 입력하실 수 없습니다.");
      $("#product_version").focus();
      return false;
    }

    var tmp = document.getElementsByName('custom_title[]');
    var tmp2 = document.getElementsByName('custom_detail[]');
    var custom_title_tmp =""
    var custom_detail_tmp =""
    for(var i=0; i<tmp.length ; i++){
      custom_title_tmp+=tmp[i].value;
      custom_detail_tmp+=tmp2[i].value;

      if(i>=0 && i<tmp.length){
        custom_title_tmp+=";;";
        custom_detail_tmp+=";;";

      }
    }

    document.getElementsByName('custom_title[]')[0].value=custom_title_tmp;
    document.getElementsByName('custom_detail[]')[0].value=custom_detail_tmp;
    mform.submit();
    return false;
  }

function addRow(){

   table = document.getElementById('input_table');

   rowCount = table.rows.length;
   row = table.insertRow(rowCount-1);
   row.innerHTML = table.rows[k-3].innerHTML;

   rowCount = table.rows.length;
   row = table.insertRow(rowCount-1);
   row.innerHTML = table.rows[k-2].innerHTML;

   rowCount = table.rows.length;
   row = table.insertRow(rowCount-1);
   //row.innerHTML = table.rows[k-1].innerHTML;
   //row.innerHTML = table.rows[k].innerHTML;
   //row.innerHTML = table.rows[k+1].innerHTML;
   k++;
	alert(row.innerHTML);
}

function deleteRow(TABLEID){

 alert("test2");

}
</script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
	<div class="dash1-1">
		<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<form name="cform" action="<?php echo site_url();?>/tech/tech_board/tech_device_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
				<input type="hidden" name="seq" value="<?php echo $_GET['seq'];?>">
	      <input type="hidden" name="mode" value="modify">
				<tr height="5%">
					<td class="dash_title">
						장비/시스템
					</td>
				</tr>
				<tr>
					<td height="40"></td>
				</tr>
				<tr>
					<td align="right">
		<?php if($tech_lv > 0) {?>
						<input type="button" class="btn-common btn-color1" value="수정" onClick="javascript:chkForm();return false;" style="margin-right:10px">
		<?php }?>
						<input type="button" class="btn-common btn-color2" value="취소" onClick="javascript:history.go(-1);">
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
          			<td class="tbl-title">고객사</td>
          			<td class="tbl-cell"><?php echo $view_val['customer_companyname'];?></td>
          			<td class="tbl-title">프로젝트명</td>
          			<td class="tbl-cell"><?php echo $view_val['project_name'];?></td>
              </tr>
              <tr>
                <td class="tbl-title">장비명</td>
                <td class="tbl-cell"><?php echo $view_val['product_name'];?></td>
                <td class="tbl-title">제품명</td>
                <td class="tbl-cell"><?php echo $view_val['product_item'];?></td>
              </tr>
              <tr>
                <td class="tbl-title">제조사</td>
                <td class="tbl-cell"><?php echo $view_val['product_company'];?></td>
                <td class="tbl-title">Serial Number</td>
                <td class="tbl-cell"><?php echo $view_val['product_serial'];?></td>
              </tr>
              <tr>
                <td class="tbl-title">Version</td>
                <td class="tbl-cell"><input type="text" name="product_version" id="product_version" class="input-common" value="<?php echo $view_val['product_version'];?>"/></td>
                <td class="tbl-title">상태</td>
                <td class="tbl-cell">
									<select name="product_state" id="product_state" class="select-common">
									<option value="0">- 제품 상태 -</option>
										<option value="001" <?php if($view_val['product_state'] == "001") { echo "selected"; }?> >입고 전</option>
										<option value="002" <?php if($view_val['product_state'] == "002") { echo "selected"; }?> >창고</option>
										<option value="003" <?php if($view_val['product_state'] == "003") { echo "selected"; }?> >고객사 출고</option>
										<option value="004" <?php if($view_val['product_state'] == "004") { echo "selected"; }?> >장애반납</option>
									</select>
                </td>
              </tr>
              <tr>
                <td class="tbl-title">라이선스</td>
                <td class="tbl-cell"><input type="text" name="product_licence" id="product_licence" class="input-common" value="<?php echo $view_val['product_licence'];?>"/></td>
                <td class="tbl-title">용도</td>
                <td class="tbl-cell"><input type="text" name="product_purpose" class="input-common" value="<?php echo $view_val['product_purpose'];?>"/></td>
              </tr>
              <tr>
                <td class="tbl-title">host</td>
                <td class="tbl-cell">
                  <input type="text" id="product_host" class="input-common" name="product_host" value="<?php echo $view_val['product_host']; ?>" />
                </td>
                <td class="tbl-title">점검항목 리스트</td>
                <td class="tbl-cell">
									<div>
										<select name="product_check_list" id="product_check_list" class="select-common form-control" >
											<?php
												foreach($check_list as $check_item){
											?>
												<option value="<?php echo $check_item['seq'];?>"<?php if($view_val['product_check_list']== $check_item['seq']){echo " selected" ;} ?>><?php echo $check_item['product_name']; ?></option>
											<?php
												}
											?>
										</select>
										<br>
										<br>
										<input type="button" class="btn-common btn-color1" value="view" style="cursor:pointer" onclick="checkListView();" />
										<input type="button" class="btn-common btn-color2" value="custom" style="cursor:pointer" onclick="checkListCustom();" />
									</div>
                </td>
              </tr>
							<input type="hidden" name="custom_title[]" id="custom_title[]"  style="width:95%;" value=""/>
							<input type="hidden" name="custom_detail[]" id="custom_detail[]"  style="width:95%;" value=""/>
            </table>
					</td>
				</tr>
			</form>
		</table>
	</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script>
  //템플릿 검색 기능
  $("#product_check_list").select2();

  //템플릿 뷰
  function checkListView(){
    var seq =  $("#product_check_list").val();
    window.open('/index.php/tech/tech_board/product_check_list_view?seq='+seq,'_blank','height=600,width=1000');
  }

  //템플릿 커스텀
  function checkListCustom(){
    var seq =  $("#product_check_list").val();
    window.open('/index.php/tech/tech_board/product_check_list_custom?seq='+seq);
  }

</script>
</html>
