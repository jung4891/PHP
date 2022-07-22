<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css_mango/view_page_common_mango.css">
<script language="javascript">
function chkForm( type ) {
	if(type == 1) {
		if (confirm("정말 삭제하시겠습니까?") == true){
			var mform = document.cform;
			mform.action="<?php echo site_url();?>/board/notice_delete_action";
			mform.submit();
			return false;
		}
	} else {
		var mform = document.cform;
		mform.action="<?php echo site_url();?>/board/notice_view";
		mform.submit();
		return false;
	}
}
//$(document).ready(function() {
//   $('li > ul').show();
//});
</script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/mango_header.php";
?>
<div align="center">
<div class="dash1-1">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<form name="cform" method="get">
<input type="hidden" name="seq" value="<?php echo $seq;?>">
<input type="hidden" name="mode" value="modify">
<tr height="5%">
  <td class="dash_title">
		<!-- <img src="<?php echo $misc;?>img/dashboard/title_notice_list.png"/> -->
		공지사항
	</td>
</tr>
<tr>
	<td height="40"></td>
</tr>
<tr>
	<td align="right">
	<?php
			if( $view_val['user_id'] == $this->id ) {
	?>
			<input type="button" class="btn-common btn-color1 btn-size1" value="삭제" onClick="javascript:chkForm(1);return false;"style="margin-right:5px;">
			<input type="button" class="btn-common btn-color4 btn-size1" value="수정" onClick="javascript:chkForm(0);return false;"style="margin-right:5px;">
	<?php
			}
	?>
	<input type="button" class="btn-common btn-style1 btn-size1" value="목록" onClick="history.go(-1);">
	</td>
</tr>
  <tr>
    <td align="center" valign="top">

    <table width="100%" height="100%" cellspacing="0" cellpadding="0" >
        <tr>

            <td width="100%" align="center" valign="top">


            <table width="100%" border="0" style="margin-top:20px;">
									<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border: thin solid #DFDFDF;margin-bottom:50px;border-left:none; border-right:none;">
										<colgroup>
											<col width="15%">
											<col width="35%">
											<col width="15%">
											<col width="35%">
										</colgroup>

									<!-- <tr style="display:none;"> -->
									<tr>
										<td height="40" class="tbl-title2">카테고리</td>
										<td align="left" style="padding-left:10px;">공지사항</td>
                    <td height="40" class="tbl-title2">날짜</td>
                    <td align="left" style="padding-left:10px;"><?php echo $view_val['update_date'];?></td>
                  </tr>
                  <tr>
                    <td height="40" class="tbl-title2">제목</td>
                    <td align="left" style="padding-left:10px;"><?php echo stripslashes($view_val['subject']);?></td>
										<td height="40" class="tbl-title2">등록자</td>
										<td align="left" style="padding-left:10px;"><?php echo $view_val['user_name'];?></td>
                  </tr>
									<tr>
										<td height="40" class="tbl-title2" style="vertical-align:top;padding-top:15px;">첨부파일</td>
										<td align="left" style="padding-left:10px;line-height:200%;border-right:none;">
											<?php
												if($view_val['file_realname'] != ""){
													 $file = explode('*/*',$view_val['file_realname']);
													 $file_url = explode('*/*',$view_val['file_changename']);
													 for($i=0; $i<count($file); $i++){
														 echo "<p>";
															echo $file[$i];
															$href = "{$misc}upload_mango/notice/{$file_url[$i]}"; ?>
													<span class="down_btn">
														<a href="<?php echo $href; ?>" download="<?php echo $file[$i]; ?>">
															<img src="/misc/img/download_btn.svg" width="12px;" style="margin-right:2px;margin-bottom:3px;">
															파일 다운로드
														</a>
													</span></p>
										<?php }
												}
										 ?>
										</td>
										<td colspan="2"></td>
									</tr>
                  <tr>
                    <td valign="top" colspan="4" style="padding:20px;"><?php echo $view_val['contents'];?></td>
                  </tr>
                </table>
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
</html>
