<?php

?>
<script language="javascript">
function chkForm( type ) {
	if(type == 1) {
		if (confirm("정말 삭제하시겠습니까?") == true){
			var mform = document.cform;
			mform.action="<?php echo site_url();?>/sales/board/notice_delete_action";
			mform.submit();
			return false;
		}
	} else {
		var mform = document.cform;
		mform.action="<?php echo site_url();?>/sales/board/notice_view";
		mform.submit();
		return false;
	}
}
//$(document).ready(function() {
//   $('li > ul').show();
//});
</script>
<body>

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="cform" method="get">
<input type="hidden" name="seq" value="<?php echo $seq;?>">
<input type="hidden" name="mode" value="modify">
  <tr>
    <td align="center" valign="top">

    <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>

            <td width="923" align="center" valign="top">


            <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">

              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;">
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
                    <td width="35%" align="center" class="t_border"><?php echo $view_val['update_date'];?></td>
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
                    <td class="t_border" style="padding-left:10px;" colspan="3"><?php if($view_val['file_changename']) {?><a href="<?php echo site_url();?>/test/board/notice_download/<?php echo $seq;?>/<?php echo $view_val['file_changename'];?>"><?php echo $view_val['file_realname'];?></a><?php } else {?>파일없음<?php }?> </td>
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
</body>
</html>
