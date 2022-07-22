<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script language="javascript">
function chkForm( type ) {
	if(type == 1) {
		if (confirm("정말 삭제하시겠습니까?") == true){
			var mform = document.cform;
			mform.action="<?php echo site_url();?>/biz/board/notice_delete_action";
			mform.submit();
			return false;
		}
	} else {
		var mform = document.cform;
		mform.action="<?php echo site_url();?>/biz/board/notice_view";
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
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
<div class="dash1-1">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<form name="cform" method="get">
<input type="hidden" name="seq" value="<?php echo $seq;?>">
<input type="hidden" name="category" value="<?php echo $category;?>">
<input type="hidden" name="mode" value="modify">
<tr height="5%">
  <td class="dash_title">
		<!-- <img src="<?php echo $misc;?>img/dashboard/title_notice_list.png"/> -->
		전체공지사항
	</td>
</tr>
<tr>
	<td height="40"></td>
</tr>
<tr>
	<td align="right">
	<?php
		if($category == '002' || $category == '003'){
			if( $this->pGroupName == '기술연구소'){
	?>
				<input type="button" class="btn-common btn-color4" value="삭제" onClick="javascript:chkForm(1);return false;" style="margin-right:10px;">
				<input type="button" class="btn-common btn-color4" value="수정" onClick="javascript:chkForm(0);return false;"style="margin-right:10px;">
	<?php
			}
		}else{
			if( $view_val['user_id'] == $this->id ) {
	?>
			<input type="button" class="btn-common btn-color4" value="삭제" onClick="javascript:chkForm(1);return false;"style="margin-right:10px;">
			<input type="button" class="btn-common btn-color4" value="수정" onClick="javascript:chkForm(0);return false;"style="margin-right:10px;">
	<?php
			}
		}
	?>
	<input type="button" class="btn-common btn-color2" value="목록" onClick="<?php if (isset($_GET['dash'])){echo "go_list('dash','".$category."');";}else{echo "go_list('notice','".$category."');";} ?>">
	</td>
</tr>
  <tr>
    <td align="center" valign="top">

    <table width="100%" height="100%" cellspacing="0" cellpadding="0" >
        <tr>

            <td width="100%" align="center" valign="top">


            <table width="100%" border="0" style="margin-top:20px;">
									<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border: thin solid #DFDFDF;margin-bottom:50px;">
										<colgroup>
											<col width="15%">
											<col width="35%">
											<col width="15%">
											<col width="35%">
										</colgroup>

									<!-- <tr style="display:none;"> -->
									<tr>
										<td height="40" align="center" class="row-color1" style="font-weight:bold;">카테고리</td>
										<td align="center" style="padding-left:10px;">
										<?php
											if($view_val['category_code'] == '001'){
												echo '운영공지';
											}else if($view_val['category_code'] == '002'){
												echo '개발공지';
											}else if($view_val['category_code'] == '003'){
												echo '버전관리';
											}
										?>
										</td>
										<!-- <td width="10%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">카테고리</td>
										<td width="10%" class="t_border" style="padding-left:10px;"> -->

                    <td height="40" align="center" class="row-color1" style="font-weight:bold;">날짜</td>
                    <td align="center"><?php echo $view_val['update_date'];?></td>
                    <!-- <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">날짜</td>
                    <td width="35%" align="center" class="t_border"><?php echo $view_val['update_date'];?></td> -->

                  </tr>
                  <tr>
                    <td height="40" align="center" class="row-color1" style="font-weight:bold;">제목</td>
                    <td align="left" style="padding-left:10px;"><?php echo stripslashes($view_val['subject']);?></td>
										<td align="center" class="row-color1" style="font-weight:bold;">등록자</td>
										<td align="center"><?php echo $view_val['user_name'];?></td>
                  </tr>
									<tr>
										<td height="40" align="center" class="row-color1" style="font-weight:bold;">숨김</td>
										<td align="left" style="padding-left:10px;">
											<!-- <input type="hidden" name="hide_btn" value="N"> -->
											<input type="checkbox" id="hide_btn" name="hide_btn" value="<?php echo $view_val['hide_btn']?>" <?php if ($view_val['hide_btn'] == 'Y') {
												echo "checked";
											} ?> onclick="return false">
											<input type="hidden" name="hide_btn" value="<?php echo $view_val['hide_btn']?>">
										</td>
										<td></td>
										<td></td>
									</tr>
                  <tr>
                    <td valign="top" colspan="4" style="padding:20px;"><?php echo $view_val['contents'];?></td>
                  </tr>
                  <tr>
										<td width="15%" align="center" height=40 class="basic_td row-color1">첨부파일</td>
										<td colspan="3" class="basic_td">
											 <?php
													if($view_val['file_realname'] != ""){
														 $file = explode('*/*',$view_val['file_realname']);
														 $file_url = explode('*/*',$view_val['file_changename']);
														 for($i=0; $i<count($file); $i++){
																echo $file[$i];
																echo "<a href='{$misc}upload/sales/notice/{$file_url[$i]}' download='{$file[$i]}'> <img src='{$misc}img/download.svg' style='width:15px;vertical-align:middle;cursor:pointer;margin:5px 0px 5px 10px;'></a><br>";
														 }
													}
											 ?>
										</td>
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
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
	function go_list(page,category){
		if (page=="dash") {
			window.location = "<?php echo site_url(); ?>/biz/board/notice_list?category="+category;
		} else {
			history.go(-1);
		}
	}
</script>
</html>
