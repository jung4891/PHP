<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
?>
<script language="javascript">
function chkForm( type ) {
	if(type == 1) {
		if (confirm("등록된 모든 코멘트들도 삭제됩니다. 정말 삭제하시겠습니까?") == true){

			var mform = document.cform;
			mform.action="<?php echo site_url();?>/board/release_note_delete_action";
			mform.submit();
			return false;
		}
	} else {
		var mform = document.cform;
		mform.action="<?php echo site_url();?>/board/release_note_view";
		mform.submit();
		return false;
	}
}

function chkForm2() {
	var rform = document.rform;
	
	if (rform.comment.value == "") {
		rform.comment.focus();
		alert("답변을 등록해 주세요.");
		return false;
	}
	
	rform.action="<?php echo site_url();?>/board/release_note_comment_action";
	rform.submit();
	return false;
}

function chkForm3(seq) {
	if (confirm("정말 삭제하시겠습니까?") == true){
		var rform = document.rform;
		rform.cseq.value = seq;
		rform.action="<?php echo site_url();?>/board/release_note_comment_delete";
		rform.submit();
		return false;
	}
}
</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
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
                <td class="title3">릴리즈노트</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;">
				<form name="cform" method="get">
				<input type="hidden" name="seq" value="<?php echo $seq;?>">
				<input type="hidden" name="mode" value="modify">
                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <tr>
                    <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">카테고리</td>
                    <td width="35%" class="t_border" style="padding-left:10px;">
					<?php
					foreach ($category  as $val) {
						if( $view_val['category_code'] && ( $val['code'] == $view_val['category_code'] ) ) {
							echo $val['code_name'];
						}
					}
					?></td>
                    <td width="15%" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">날짜</td>
                    <td width="35%" align="center" class="t_border"><?php echo substr($view_val['insert_date'], 0, 10);?></td>
                  </tr>
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제목</td>
                    <td class="t_border" style="padding-left:10px;"><?php echo stripslashes($view_val['subject']);?></td>
                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">등록자</td>
                    <td align="center" class="t_border"><?php echo $view_val['user_name'];?></td>
                  </tr>
                  <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  <tr>
                    <td valign="top" colspan="4" style="padding:20px;"><?php echo $view_val['contents'];?></td>
                  </tr>
                   <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">첨부파일</td>
                    <td class="t_border" style="padding-left:10px;" colspan="3"><?php if($view_val['file_changename']) {?><a href="<?php echo site_url();?>/board/release_note_download/<?php echo $seq;?>/<?php echo $view_val['file_changename'];?>"><?php echo $view_val['file_realname'];?></a><?php } else {?>파일없음<?php }?> </td>
                  </tr>
                  <tr>
                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
				  </form>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right"><img src="<?php echo $misc;?>img/btn_list.jpg" border="0" style="cursor:pointer" onClick="javascript:history.go(-1);"/> <?php if($id == $view_val['user_id'] || $lv == 3) {?><img src="<?php echo $misc;?>img/btn_adjust.jpg" style="cursor:pointer" border="0" onClick="javascript:chkForm(0);return false;"/> <img src="<?php echo $misc;?>img/btn_delete.jpg" style="cursor:pointer" border="0" onClick="javascript:chkForm(1);return false;"/><?php }?></td>
              </tr>
              <tr>
                <td></td>
              </tr>
              <tr>
                <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				 <form name="rform" method="post">
				 <input type="hidden" name="seq" value="<?php echo $seq;?>">
				 <input type="hidden" name="cseq" value="">
                  <tr>
                    <td height="2" bgcolor="#797c88"></td>
                  </tr>
                <?php
					foreach ( $clist_val as $item ) {
				?>
                  <tr>
                    <td bgcolor="f8f8f9"><table width="185" border="0" cellspacing="0" cellpadding="5">
                      <tr>
                        <td width="40%" class="answer"><?php echo $item['user_name'];?></td>
                        <td width="50%"><?php echo substr($item['insert_date'], 0, 10);?></td>
                        <td width="10%" align="right"><?php if($id == $item['user_id'] or $lv == 3) {?><img src="<?php echo $misc;?>img/btn_del.jpg" width="18" height="17" style="cursor:pointer" border="0" onClick="javascript:chkForm3('<?php echo $item['seq']?>');return false;"/><?php }?></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td class="answer2"><?php echo nl2br(str_replace(" ", "&nbsp;", htmlspecialchars($item['contents'])))?></td>
                  </tr>
                  <tr>
                    <td height="1" bgcolor="#e8e8e8"></td>
                  </tr>
				<?php
					}
				?>
                  <tr>
                    <td bgcolor="f8f8f9"><table width="170" border="0" cellspacing="0" cellpadding="5">
                        <tr>
                          <td width="40%" class="answer"><?php echo $name;?></td>
                          <td width="50%"><?php echo date("Y-m-d");?></td>
                          <td width="10%" align="right"><!-- <img src="<?php echo $misc;?>img/btn_del.jpg" width="18" height="17" /> --></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td class="answer2" align="center"><textarea name="comment" id="comment" cols="130" rows="5" class="input_answer1"></textarea></td>
                  </tr>
                  <tr>
                    <td height="2" bgcolor="#797c88"></td>
                  </tr>
				</form>
                </table></td>
              </tr>              
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="center"><input type="image" src="<?php echo $misc;?>img/btn_answer2.jpg" width="60" height="20" style="cursor:pointer" onClick="javascript:chkForm2();return false;"/></td>
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
        <td><td><?php include $this->input->server('DOCUMENT_ROOT')."/include/customer_bottom.php"; ?></td></td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>
 
