<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script language="javascript">
function filedel(seq, filename) {
	if (confirm("정말 삭제하시겠습니까?") == true){
		location.href = "<?php echo site_url();?>/tech/board/faq_filedel/" + seq + "/" + filename;
		return false;
	}
}

</script>
<script language="javascript">
$(document).ready(function() {
 $('li > ul').show();
});
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>
<body>
  <?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
	<div class="dash1-1">
		<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<form id="cform" name="cform" action="<?php echo site_url();?>/tech/board/faq_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
				<input type="hidden" name="seq" value="<?php echo $seq;?>">
				<input type="hidden" id="type" name="type" value="0" />
				<tr height="5%">
					<td class="dash_title">
						FAQ
					</td>
				</tr>
				<tr>
					<td height="40"></td>
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
          			<td class="tbl-title">카테고리</td>
          			<td class="tbl-cell">
									<select name="category_code" id="category_code" class="select-common">
										<?php
										foreach ($category  as $val) {
											echo '<option value="'.$val['code'].'"';
											if( $view_val['category_code'] && ( $val['code'] == $view_val['category_code'] ) ) {
												echo ' selected';
											}

											echo '>'.$val['code_name'].'</option>';
										}
										?>
									</select>
								</td>
          			<td class="tbl-title">날짜</td>
          			<td class="tbl-mid"><?php echo $view_val['insert_date'];?></td>
              </tr>
              <tr>
                <td class="tbl-title">제목</td>
                <td class="tbl-cell"><input type="text" name="subject" id="subject" class="input-common" value="<?php echo stripslashes($view_val['subject']);?>"/></td>
                <td class="tbl-title">등록자</td>
                <td class="tbl-mid"><?php echo $view_val['user_name'];?></td>
              </tr>
              <tr>
                <td colspan="4">
									<div id="summernote"><?php echo $view_val['contents'];?></div>
									<input type="hidden" name="contents" id="contents" >
								</td>
              </tr>
            </table>
						<div class="">
							<img src="<?php echo $misc; ?>/img/file_upload.png" style="width:20px;float:left;vertical-align:middle;"><h3 style="float:left;margin:0px;">&nbsp;파일업로드</h3><br>
						</div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border: thin solid #DFDFDF;margin-bottom:50px;margin-top:20px;">
							<?php
								 $file_html = "";
								 if($view_val['file_realname'] != ""){
										$file = explode('*/*',$view_val['file_realname']);
										for($i=0; $i<count($file); $i++){
											 $file_html .= "<tr id='dbfileTr_{$i}'>";
											 $file_html .= "<td class='left' >";
											 $file_html .= $file[$i]." <a href='#' onclick='dbDeleteFile({$i}); return false;' class='btn small bg_02'><img src='{$misc}/img/btn_del2.jpg' style='vertical-align:middle;'></a>";
											 $file_html .= "</td>";
											 $file_html .= "</tr>";
										}
								 }
							?>
							<tr>
								<td>
									<div>
										<table class="basic_table" width="100%" bgcolor="f8f8f9" height="auto" >
											 <tbody id="fileTableTbody">
												<tr>
													<td id="dropZone" height="100px">
														이곳에 파일을 드래그 하세요.
													</td>
												</tr>
											</tbody>
                      <?php echo $file_html; ?>
										</table>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="right">
						<input type="button" class="btn-common btn-color1" value="취소" onClick="javascript:history.go(-1)" style="margin-right:10px">
						<input type="button" class="btn-common btn-color2" value="수정" onClick="javascript:chkForm();return false;">
					</td>
				</tr>
			</form>
		</table>
	</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
var file_realname = "<?php echo $view_val['file_realname']; ?>".split("*/*");
var file_changename = "<?php echo $view_val['file_changename']; ?>".split("*/*");

var request_url = "<?php echo site_url(); ?>/tech/board/faq_input_action";
var response_url = "<?php echo site_url(); ?>/tech/board/faq_list";
</script>
<script type="text/javascript" src="/misc/js/board/board_script.js"></script>
</html>
