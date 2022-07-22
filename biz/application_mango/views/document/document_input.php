<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css_mango/view_page_common_mango.css">
<link rel="stylesheet" href="/misc/daumeditor-7.4.9/css/editor.css" type="text/css" charset="utf-8"/>
<script src="/misc/daumeditor-7.4.9/js/editor_loader.js" type="text/javascript" charset="utf-8"></script>
<script language="javascript">

//$(document).ready(function() {
//   $('li > ul').show();
//});
</script>
<style media="screen">
.basic_table {
	border: 1px solid #DEDEDE;
}
.list_tbl {
	border-top: 1px solid #DEDEDE;
	border-bottom: none;
}
.border-l {
	border-left: 1px solid #DEDEDE;
}
.border-r {
	border-right: 1px solid #DEDEDE;
}
</style>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/mango_header.php";
?>
	<div align="center">
		<div class="dash1-1">
			<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet"> -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script> -->
				<form name="tx_editor_form" id="tx_editor_form" action="<?php echo site_url();?>/biz/document/document_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
					<input type="hidden" id="type" name="type" value="1" />
					<tr>
	  				<td class="dash_title">
							내부서류
						</td>
					</tr>
					<tr>
						<td align="right">
							<input style="margin-top:20px;margin-right:5px;" type="button" class="btn-common btn-color1 btn-size1" value="취소" onClick="javascript:history.go(-1)">
							<input style="margin-top:20px;" type="button" class="btn-common btn-style1 btn-size1" value="등록" onClick="javascript:chkForm();return false;">
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
													<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border: thin solid #DFDFDF;margin-bottom:50px;border-left:none; border-right:none;">

														<colgroup>
															<col width="15%">
															<col width="35%">
															<col width="15%">
															<col width="35%">
														</colgroup>
														<tr>
															<td height="40" class="tbl-title2">카테고리</td>
															<td align="left" style="padding-left:10px;">
																내부서류
															</td>
					          					<td height="40" class="tbl-title2">날짜</td>
					                    <td align="left" style="padding-left:10px;"><?php echo date("Y-m-d");?></td>
                  					</tr>
                  					<tr>
					                    <td height="40" class="tbl-title2">서류명</td>
					                    <td style="padding-left:10px;padding-right:10px;">
																<input type="text" name="subject" id="subject" class="input-common" style="width:100%;"/>
															</td>
															<td height="40" class="tbl-title2">등록자</td>
															<td align="left" style="padding-left:10px;"><?php echo $this->name;?></td>
                  					</tr>
                  					<tr>
					                    <td height="40" class="tbl-title2" style="border-bottom:none;">링크</td>
					                    <td style="padding-left:10px;padding-right:10px;border-bottom:none;">
																<input type="text" name="url_link" id="url_link" class="input-common" style="width:100%;"/>
															</td>
															<td height="40" class="tbl-title2" style="border-bottom:none;">파일업로드</td>
															<td style="padding-left:10px;padding-right:10px;border-bottom:none;">
																<table width="100%" height="auto" style="border:none;">
																	<tbody id="fileTableTbody">
																		<tr>
																			<td id="dropZone" style="border:thin solid #DFDFDF;border-radius:3px;color:#B0B0B0;padding-left:10px;background-color:#FCFCFC;height:25px;">
																				 이곳에 파일을 드래그 하세요.
																		 </td>
																	 </tr>
																	</tbody>
																</table>
															</td>
                  					</tr>
														<tr>
															<td colspan="4" style="border-bottom:none">
																<textarea name="content" id="content" style="display:none;"></textarea>
																<input type="hidden" name="contents" id="contents" value="">
																<?php include $this->input->server('DOCUMENT_ROOT')."/misc/daumeditor-7.4.9/editor.php"; ?>
															</td>
                  					</tr>

                						</table>
													</td>
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
<?php include $this->input->server('DOCUMENT_ROOT')."/include/mango_bottom.php"; ?>
</body>
<script type="text/javascript">
	var request_url = "<?php echo site_url(); ?>/document/document_input_action";
	var response_url = "<?php echo site_url(); ?>/document/document_list";
</script>
<script type="text/javascript" src="/misc/js/board/board_script_daum.js"></script>
<script type="text/javascript">
</script>
</html>
