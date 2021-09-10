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
     mform.action="<?php echo site_url();?>/tech/board/network_map_delete_action";
     mform.submit();
     return false;
   }
 } else {
  var mform = document.cform;
  mform.action="<?php echo site_url();?>/tech/board/network_map_view";
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
						구성도
					</td>
				</tr>
				<tr>
					<td height="40"></td>
				</tr>
				<tr>
					<td align="right">
		<?php if($tech_lv == 3 or $id == $view_val['user_id']) {?>
						<input type="button" class="btn-common btn-color1" value="삭제" onclick="javascript:chkForm(1);return false;" style="margin-right:10px">
						<input type="button" class="btn-common btn-color1" value="수정" onclick="javascript:chkForm(0);return false;" style="margin-right:10px">
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
          			<td class="tbl-cell">
                  <?php
                    echo $view_val['category_code'];
                  ?>
                </td>
          			<td class="tbl-title">날짜</td>
          			<td class="tbl-mid"><?php echo $view_val['insert_date'];?></td>
              </tr>
              <tr>
                <td class="tbl-title">제목</td>
                <td class="tbl-cell"><?php echo stripslashes($view_val['subject']);?></td>
                <td class="tbl-title">등록자</td>
                <td class="tbl-mid"><?php echo $view_val['user_name'];?></td>
              </tr>
              <tr>
                <td colspan="4" class="tbl-contents"><?php echo $view_val['contents'];?></td>
              </tr>
							<tr>
								<td class="tbl-title">첨부파일</td>
								<td colspan=3 class="tbl-cell">
									 <?php
                     if($view_val['file_realname'] != ""){
                        $file = explode('*/*',$view_val['file_realname']);
                        $file_url = explode('*/*',$view_val['file_changename']);
                        for($i=0; $i<count($file); $i++){
                           echo $file[$i];
                           echo "<a href='{$misc}upload/tech/network_map/{$file_url[$i]}' download='{$file[$i]}'> <img src='{$misc}img/download.svg' style='width:15px;vertical-align:middle;cursor:pointer;margin:5px 0px 5px 10px;'></a><br>";
                        }
                     }
									 ?>
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
