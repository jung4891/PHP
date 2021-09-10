<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
?>
<script language="javascript">
var chkForm = function () {
	var mform = document.cform;
	
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
//	if (mform.contents.value == "") {
//		mform.contents.focus();
//		alert("내용을 입력해 주세요.");
//		return false;
//	}
	
	mform.submit();
	return false;
}
//$(document).ready(function() {
//   $('li > ul').show();
//});
</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<script src="<?php echo $misc;?>ckeditor/ckeditor.js"></script>
<form name="cform" action="<?php echo site_url();?>/board/eduevent_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/tech_header.php";
?>
  <tr>
    <td align="center" valign="top">
    
    <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
            
            <td width="923" align="center" valign="top">
            
            
            <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <tr>
                <td class="title3">교육 &amp; 행사</td>
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
						echo '>'.$val['code_name'].'</option>';
					}
					?>
                      <!-- <option value="000">제조사별</option>
                      <option value="001">모두스원</option>
                      <option value="002">모니터랩</option>
                      <option value="003">SK 인포섹</option>
                      <option value="004">시큐아이</option> -->
                    </select></td>
                    <td width="15%" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">날짜</td>
                    <td width="35%" align="center" class="t_border"><?php echo date("Y-m-d");?></td>
                  </tr>
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제목</td>
                    <td class="t_border" style="padding-left:10px;"><input type="text" name="subject" id="subject" class="input2"/></td>
                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">등록자</td>
                    <td align="center" class="t_border"><?php echo $name;?></td>
                  </tr>
                  <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  <tr>
                    <td colspan="4" style="padding:20px;"><textarea name="contents" id="contents" cols="45" rows="5" class="input4"></textarea>
					<script>
					CKEDITOR.replace( 'contents', {
						filebrowserUploadUrl: '<?php echo site_url();?>/board/eduevent_input_action_image'
					});
					</script></td>
                  </tr><tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">첨부파일</td>
                    <td class="t_border" style="padding-left:10px;" colspan="3"><input type="file" name="cfile" id="cfile" />
                      (용량제한 100MB)</td>
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
                <td align="right"><input type="image" src="<?php echo $misc;?>img/btn_ok.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:chkForm();return false;"/>  <img src="<?php echo $misc;?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:history.go(-1)"/></td>
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
  <tr>
  	<td align="center" height="100" bgcolor="#CCCCCC"><table width="1130" cellspacing="0" cellpadding="0" >      
      <tr>
        <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img src="<?php echo $misc;?>img/f_ci.png"/></td>
        <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/customer_bottom.php"; ?></td>
      </tr>
    </table></td>
  </tr>
</form>
</table>

</body>
</html>
 
