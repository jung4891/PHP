<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<script language="javascript">
function filedel(seq, filename) {
	if (confirm("정말 삭제하시겠습니까?") == true){
		location.href = "<?php echo site_url();?>/sales/board/notice_filedel/" + seq + "/" + filename;
		return false;
	}
}

</script>
<script language="javascript">
var chkForm = function () {
	var mform = document.cform;
	var cfile_check = '<?php echo $view_val['file_changename'];?>';

//	if (mform.category_code.value == "000") {
//		mform.category_code.focus();
//		alert("카테고리를 선택해 주세요.");
//		return false;
//	}
	if (mform.subject.value == "") {
		mform.subject.focus();
		alert("제목을 입력해 주세요.");
		return false;
	}
	// if (mform.contents.value == "") {
	// 	mform.contents.focus();
	// 	alert("내용을 입력해 주세요.");
	// 	return false;
	// }
	if(cfile_check) {
		mform.cfile.disabled = false;
	}
	mform.submit();
	return false;
}
//$(document).ready(function() {
//   $('li > ul').show();
//});
</script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<script src="<?php echo $misc;?>ckeditor/ckeditor.js"></script>
<form name="cform" action="<?php echo site_url();?>/sales/board/notice_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
<input type="hidden" name="seq" value="<?php echo $seq;?>">
  <tr>
    <td align="center" valign="top">
    <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
            <td width="923" align="center" valign="top">
            <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <tr>
                <td class="title3">공지사항</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <tr>
                    <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">카테고리</td>
                    <td width="35%" class="t_border" style="padding-left:10px;"><select name="category_code" id="category_code" class="input">
					<?php
					foreach ($category  as $val) {
						echo '<option value="'.$val['code'].'"';
						if( $view_val['category_code'] && ( $val['code'] == $view_val['category_code'] ) ) {
							echo ' selected';
						}

						echo '>'.$val['code_name'].'</option>';
					}
					?>
                    </select></td>
                    <td width="15%" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">날짜</td>
                    <td width="35%" align="center" class="t_border"><?php echo $view_val['update_date'];?></td>
                  </tr>
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제목</td>
                    <td class="t_border" style="padding-left:10px;"><input type="text" name="subject" id="subject" class="input2" value="<?php echo stripslashes($view_val['subject']);?>"/></td>
                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">등록자</td>
                    <td align="center" class="t_border"><?php echo $view_val['user_name'];?></td>
                  </tr>
                  <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  <tr>
                    <td colspan="4" style="padding:20px;"><textarea name="contents" id="contents" cols="45" rows="5" class="input4"><?php echo $view_val['contents'];?></textarea>
					<script>
					CKEDITOR.replace( 'contents', {
						filebrowserUploadUrl: '<?php echo site_url();?>/sales/board/notice_input_action_image'
					});
					</script></td>
                  </tr><tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">첨부파일</td>
                    <td class="t_border" style="padding-left:10px;" colspan="3"><?php if($view_val['file_changename']) {?><a href="<?php echo site_url();?>/sales/board/notice_download/<?php echo $seq;?>/<?php echo $view_val['file_changename'];?>"><?php echo $view_val['file_realname'];?></a> <a href="javascript:filedel('<?php echo $seq;?>','<?php echo $view_val['file_changename'];?>');"><img src="<?php echo $misc;?>img/del.png" width="8" height="8" /></a>&nbsp;&nbsp;<input name="cfile" id="cfile" type="file" size="78" disabled><?php } else {?><input name="cfile" type="file" size="78"> <span class="point0 txt_s">(용량제한 200MB)<?php }?> </td>
                  </tr>
                  <tr>
                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right"><input type="image" src="<?php echo $misc;?>img/btn_adjust.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:chkForm();return false;"/> <img src="<?php echo $misc;?>img/btn_cancel.jpg" width="64" height="31" onClick="javascript:history.go(-1)" style="cursor:pointer"/></td>
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
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
</html>
