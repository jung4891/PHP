<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script language="javascript">
  function chkForm( type ) {
    if(type == 1) {
      if (confirm("정말 삭제하시겠습니까?") == true){
        var mform = document.cform;
        mform.action="<?php echo site_url();?>/tech/tech_board/tech_device_delete_action";
        mform.submit();
        return false;
      }
    } else {
      var mform = document.cform;
      // var seq = document.cform.seq.value;
       mform.action="<?php echo site_url();?>/tech/tech_board/tech_device_view";
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
			<form name="cform" method="get">
				<input type="hidden" name="seq" value="<?php echo $seq;?>">
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
						<input type="button" class="btn-common btn-color1" value="수정" onClick="javascript:chkForm(0);return false;" style="margin-right:10px">
		<?php }?>
						<input type="button" class="btn-common btn-color2" value="목록" onClick="javascript:history.go(-1);">
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
                <td class="tbl-cell"><?php echo $view_val['product_version'];?></td>
                <td class="tbl-title">상태</td>
                <td class="tbl-cell">
                  <?php
                  if($view_val['product_state'] == "0") { echo "미입력상태"; }
                  else if($view_val['product_state'] == "001") { echo "입고 전"; }
                  else if($view_val['product_state'] == "002") { echo "창고"; }
                  else if($view_val['product_state'] == "003") { echo "고객사 출고"; }
                  else if($view_val['product_state'] == "004") { echo "장애 반납"; }
                  ?>
                </td>
              </tr>
              <tr>
                <td class="tbl-title">라이선스</td>
                <td class="tbl-cell"><?php echo $view_val['product_licence'];?></td>
                <td class="tbl-title">용도</td>
                <td class="tbl-cell"><?php echo $view_val['product_purpose'];?></td>
              </tr>
              <tr>
                <td class="tbl-title">host</td>
                <td>
                  <div class="tbl-cell">
                    <?php echo $view_val['product_host']; ?>
                  </div>
                </td>
                <td class="tbl-title">점검항목 리스트</td>
                <td>
                  <div class="tbl-cell">
                    <?php
                        foreach($check_list as $check_item){
                          if( $view_val['product_check_list'] == $check_item['seq'] ){
                            echo $check_item['product_name'];
                          }
                        }
                    ?>
                  </div>
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
<script type="text/javascript">
  $(".tbl-cell").each(function() {
    if($.trim($(this).text()) == '') {
      $(this).text('-');
    }
  })
</script>
</html>
