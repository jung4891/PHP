<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/dashboard.css">
<link rel="stylesheet" href="/misc/daumeditor-7.4.9/css/editor.css" type="text/css" charset="utf-8"/>
<script src="/misc/daumeditor-7.4.9/js/editor_loader.js" type="text/javascript" charset="utf-8"></script>
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
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet"> -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script> -->
	<script src="<?php echo $misc;?>js/ckeditor/ckeditor.js"></script>
<form name="tx_editor_form" id="tx_editor_form" action="<?php echo site_url();?>/biz/board/notice_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
	<input type="hidden" id="type" name="type" value="1" />
	<tr height="5%">
	  <td class="dash_title"><img src="<?php echo $misc;?>img/dashboard/title_notice_list.png"/></td>
	</tr>
  <tr>
    <td align="center" valign="top">

    <table width="90%" height="100%" cellspacing="0" cellpadding="0" >
        <tr>

            <td width="90%" align="center" valign="top">

            <table width="90%" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="6" height="2" bgcolor="#797c88"></td>
                  </tr>
									<tr>
										<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">카테고리</td>
										<td class="t_border" style="padding-left:10px;">
											<select name="category_code" id="category_code" class="input" onchange="change_category(this);">
												<option value="001">운영공지</option>
											<?php
												if($group == '기술연구소'){
													echo '<option value="002">개발공지</option>';
													echo '<option value="003">버전관리</option>';
												}
											?>
											</select>
										</td>
          					<td align="center" bgcolor="f8f8f9" style="font-weight:bold;">날짜</td>
                    <td align="center" class="t_border"><?php echo date("Y-m-d");?></td>
										<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">등록자</td>
										<td align="center" class="t_border"><?php echo $name;?></td>
                  </tr>
                  <tr>
                    <td colspan="6" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제목</td>
                    <td class="t_border" colspan="4" style="padding-left:10px;"><input type="text" name="subject" id="subject" class="input2"/></td>
                  </tr>
                  <tr>
                    <td colspan="6" height="1" bgcolor="#797c88"></td>
                  </tr>
									<tr>
										<td colspan="6">
											<textarea name="content" id="content" style="display:none;"></textarea>
											<input type="hidden" name="contents" id="contents" value="">
											<?php include $this->input->server('DOCUMENT_ROOT')."/misc/daumeditor-7.4.9/editor.php"; ?>
									</td>
                  </tr>
                  <tr>
										<td colspan="6">
											<div style="margin-top:30px;">
												 <img src="<?php echo $misc; ?>/img/file_upload.png" style="width:20px;float:left;vertical-align:middle;"><h3 style="float:left;margin:0px;">&nbsp;파일업로드</h3><br>
												 <table class="basic_table" width="100%" bgcolor="f8f8f9" height="auto" border="1px" style="margin-top:20px;" >
															 <tbody id="fileTableTbody">
																	<tr>
																		 <td id="dropZone" height="100px">
																					 이곳에 파일을 드래그 하세요.
																		 </td>
																	</tr>
															 </tbody>
												 </table>
											</div>
										</td>
                  </tr>
                  <tr>
                  <tr>
                    <td colspan="6" height="2" bgcolor="#797c88"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="center"><input type="image" src="<?php echo $misc;?>img/dashboard/btn/btn_add.png" width="70" height="35" style="cursor:pointer" onClick="javascript:chkForm();return false;"/>  <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" width="70" height="35" style="cursor:pointer" onClick="javascript:history.go(-1)"/></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
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
var loc = $("#category_code option:selected").val();

var request_url = "<?php echo site_url(); ?>/biz/board/notice_input_action";
var response_url = "<?php echo site_url(); ?>/biz/board/notice_list?category="+loc;

function change_category(el) {
	loc = $(el).val();
	response_url = "<?php echo site_url(); ?>/biz/board/notice_list?category="+loc;
}

</script>
<script type="text/javascript" src="/misc/js/board/board_script.js"></script>
<script type="text/javascript">
</script>
</html>
