<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link rel="stylesheet" href="/misc/daumeditor-7.4.9/css/editor.css" type="text/css" charset="utf-8"/>
<script src="/misc/daumeditor-7.4.9/js/editor_loader.js" type="text/javascript" charset="utf-8"></script>
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script> -->
<body>
  <?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
	<div class="dash1-1">
		<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<form id="tx_editor_form" name="tx_editor_form" action="<?php echo site_url();?>/tech/board/release_note_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
				<input type="hidden" id="type" name="type" value="1" />
				<tr height="5%">
					<td class="dash_title">
						릴리즈노트
					</td>
				</tr>
				<tr>
					<td height="40"></td>
				</tr>
    		<tr>
      		<td width="100%" align="center" valign="top">
						<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border-top: thin solid #DFDFDF;margin-bottom:50px;margin-top:20px;">
							<colgroup>
								<col width="15%">
								<col width="35%">
								<col width="15%">
								<col width="35%">
							</colgroup>
        			<tr>
          			<td class="tbl-title border-l">카테고리</td>
          			<td class="tbl-cell">
                  <select name="category_code" id="category_code" class="select-common">
                     <?php
                     foreach ($category  as $val) {
                      echo '<option value="'.$val['seq'].'"';
                      echo '>'.$val['company_name'].'</option>';
                    }
                    ?>
                  </select>
								</td>
          			<td class="tbl-title">날짜</td>
          			<td class="tbl-mid border-r"><?php echo date("Y-m-d");?></td>
              </tr>
              <tr>
                <td class="tbl-title border-l">제목</td>
                <td class="tbl-cell"><input type="text" name="subject" id="subject" class="input-common"/></td>
                <td class="tbl-title">등록자</td>
                <td class="tbl-mid border-r"><?php echo $name;?></td>
              </tr>
              <tr>
                <td colspan="4" style="border-bottom:none">
                  <textarea name="content" id="content" style="display:none;"></textarea>
                  <input type="hidden" name="contents" id="contents" value="">
                  <?php include $this->input->server('DOCUMENT_ROOT')."/misc/daumeditor-7.4.9/editor.php"; ?>
								</td>
              </tr>
            </table>
						<div class="">
							<img src="<?php echo $misc; ?>/img/file_upload.png" style="width:20px;float:left;vertical-align:middle;"><h3 style="float:left;margin:0px;">&nbsp;파일업로드</h3><br>
						</div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border: thin solid #DFDFDF;margin-bottom:50px;margin-top:20px;">
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
						<input type="button" class="btn-common btn-color2" value="등록" onClick="javascript:chkForm();return false;">
					</td>
				</tr>
			</form>
		</table>
	</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
var request_url = "<?php echo site_url(); ?>/tech/board/release_note_input_action";
var response_url = "<?php echo site_url(); ?>/tech/board/release_note_list";
</script>
<script type="text/javascript" src="/misc/js/board/board_script_daum.js"></script>
</html>
