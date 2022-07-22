<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link rel="stylesheet" href="/misc/daumeditor-7.4.9/css/editor.css" type="text/css" charset="utf-8"/>
<script src="/misc/daumeditor-7.4.9/js/editor_loader.js" type="text/javascript" charset="utf-8"></script>
<script language="javascript">
function filedel(seq, filename) {
	if (confirm("정말 삭제하시겠습니까?") == true){
		location.href = "<?php echo site_url();?>/biz/board/notice_filedel/" + seq + "/" + filename;
		return false;
	}
}

</script>
<script language="javascript">
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
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet"> -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script> -->
	<script src="<?php echo $misc;?>js/ckeditor/ckeditor.js"></script>
<form name="tx_editor_form" id="tx_editor_form" action="<?php echo site_url();?>/biz/board/notice_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
<input type="hidden" name="seq" value="<?php echo $seq;?>">
<input type="hidden" id="type" name="type" value="0" />
<input type="hidden" id="temporary" name="temporary" value="N">
<tr height="5%">
  <td class="dash_title">
		<!-- <img src="<?php echo $misc;?>img/dashboard/title_notice_list.png"/> -->
		전체공지사항
	</td>
</tr>
<tr>
	<td align="right">
		<!-- <input type="image" src="<?php echo $misc;?>img/dashboard/btn/btn_adjust.png" width="64" height="31" style="cursor:pointer" onClick="javascript:chkForm();return false;"/>
		<img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" width="64" height="31" onClick="javascript:history.go(-1)" style="cursor:pointer"/> -->
		<input style="margin-top:20px;margin-right:10px;" type="button" class="btn-common btn-color4" value="취소"  onClick="javascript:history.go(-1)"/>
		<input style="margin-top:20px;margin-right:10px;" type="button" class="btn-common btn-color3" value="임시저장"  onClick="javascript:temporary_save();"/>
		<input style="margin-top:20px;" type="button" class="btn-common btn-color4" value="수정"  onClick="javascript:chkForm();return false;">
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
									<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top: thin solid #DFDFDF;">
										<colgroup>
											<col width="15%">
											<col width="35%">
											<col width="15%">
											<col width="35%">
										</colgroup>
									<tr>
										<td height="40" align="center" class="row-color1" style="font-weight:bold;border-left: thin solid #DFDFDF;">카테고리</td>
										<td style="padding-left:10px;">
											<select name="category_code" id="category_code" class="select-common" onchange="change_category(this);"style="width:305px;">
												<option value="001" <?php if($view_val['category_code'] == '001'){ echo 'selected'; } ?>>운영공지</option>
												<?php
													if($group == '기술연구소'){
														echo '<option value="002"';
														if($view_val['category_code'] == '002'){
															echo 'selected';
														}
														echo '>개발공지</option>';
														echo '<option value="003"';
														if($view_val['category_code'] == '003'){
															echo 'selected';
														}
														echo '>버전관리</option>';
														// if($view_val['category_code'] == '002'){
														// 	echo '<option value="002" selected >개발공지</option>';
														// 	echo '<option value="003" >버전관리</option>';
														// }else if($view_val['category_code'] == '003'){
														// 	echo '<option value="002" >개발공지</option>';
														// 	echo '<option value="003" selected >버전관리</option>';
														// }
													}
												?>
												<!-- <option value="002" <?php if($view_val['category_code'] == '002'){ echo 'selected'; } ?>>개발공지</option>
												<option value="003" <?php if($view_val['category_code'] == '003'){ echo 'selected'; } ?>>버전관리</option> -->
											</select>
										</td>
                    <td align="center" class="row-color1" style="font-weight:bold;">날짜</td>
                    <td align="center" style="border-right: thin solid #DFDFDF;" ><?php echo $view_val['update_date'];?></td>

                  </tr>
                  <tr>
                    <td height="40" align="center" class="row-color1" style="font-weight:bold;border-left: thin solid #DFDFDF;">제목</td>
                    <td style="padding-left:10px;">
											<input type="text" name="subject" id="subject" class="input-common" value="<?php echo stripslashes($view_val['subject']);?>" style="width:300px;"/>
										</td>
										<td align="center" class="row-color1" style="font-weight:bold;">등록자</td>
										<td align="center" style="border-right: thin solid #DFDFDF;"><?php echo $view_val['user_name'];?></td>
                  </tr>
									<tr>
										<td height="40" align="center" class="row-color1 border-l" style="font-weight:bold;border-bottom:none;">숨김</td>
										<td align="left" style="padding-left:10px;">
											<input type="checkbox" name="hide_chk" onclick="ynCheck(this);" <?php if($view_val['hide_btn'] == 'Y') {
												echo "checked";
											} ?> >
											<input type="hidden" name="hide_btn" value="<?php echo $view_val['hide_btn'] ?>">
										</td>
										<td></td>
										<td align="center" class="border-r"></td>
									</tr>
									<tr>
				            <td colspan="4" style="border-bottom:none">
											<textarea name="content" id="content" style="display:none;"><?php echo $view_val['contents']; ?></textarea>
											<input type="hidden" name="contents" id="contents" value="">
											<?php include $this->input->server('DOCUMENT_ROOT')."/misc/daumeditor-7.4.9/editor.php"; ?>
										</td>
				          </tr><tr>

				        </tr>

                </table>
              </tr>
							<tr>
								<td colspan="4" height="40" align="center" style="font-weight:bold;">
									<div style="margin-top:30px;">
										 <img src="<?php echo $misc; ?>/img/file_upload.png" style="width:20px;float:left;vertical-align:middle;"><h3 style="float:left;margin:0px;">&nbsp;파일업로드</h3><br>
										 <!-- <form name="uploadForm" id="uploadForm" enctype="multipart/form-data" method="post" > -->
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
												<table class="basic_table" width="100%" class="row-color1" height="auto" style="margin-top:20px;" >
															<tbody id="fileTableTbody">
																 <tr>
																		<td id="dropZone" class="row-color1" height="100px">
																					이곳에 파일을 드래그 하세요.
																		</td>
																 </tr>
															</tbody>
															<?php echo $file_html; ?>
												</table>
										 <!-- </form> -->
										 <!-- <a href="#" onclick="uploadFile(); return false;" class="btn bg_01">파일 업로드</a> -->
									</div>
								</td>
							</tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>


            </td>

        </tr>
     </table>
</div>
</div>
    </td>
  </tr>
</form>
</table>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
var file_realname = "<?php echo $view_val['file_realname']; ?>".split("*/*");
var file_changename = "<?php echo $view_val['file_changename']; ?>".split("*/*");

var loc = $("#category_code option:selected").val();

var request_url = "<?php echo site_url(); ?>/biz/board/notice_input_action";
var response_url = "<?php echo site_url(); ?>/biz/board/notice_list?category="+loc;

function change_category(el) {
	loc = $(el).val();
	response_url = "<?php echo site_url(); ?>/biz/board/notice_list?category="+loc;
}

function ynCheck(obj){
	if($(obj).is(":checked")){
		$("input[name=hide_btn]").val('Y');
	} else {
		$("input[name=hide_btn]").val('N');
	}
}

function temporary_save() {
	$('#temporary').val('Y');
	chkForm();
}

</script>
<script type="text/javascript" src="/misc/js/board/board_script_daum.js"></script>
</html>
