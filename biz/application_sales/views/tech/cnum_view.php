<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
//	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->config->item('site_title');?></title>
<link href="<?php echo $misc;?>css/styles.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="generator" content="WebEditor">
<script language="javascript">
function checkNum(obj) {
	var word = obj.value;
	var str = "1234567890";
	for (i=0;i< word.length;i++){
		if(str.indexOf(word.charAt(i)) < 0){
			alert("숫자 조합만 가능합니다.");
			obj.value="";
			obj.focus();
			return false;
		}
	}
}

var chkForm = function chkForm() {
	var mform = document.mform;
	mform.cnum.value = mform.cnum.value.trim();

	if(mform.cnum.value == ""){
		alert("사업자번호를 입력하세요.");
		mform.cnum.focus();
		return false;
	}

	mform.submit();
	return false;
}
</script>
</head>


<body>
<table width="550" border="0" cellspacing="0" cellpadding="0">
<form name="mform" method="get" action="<?php echo site_url().'/account/cnum_check';?>" onSubmit="javascript:chkForm();return false;">
<input type="hidden" name="type" value="<?php echo $type;?>">
  <tr>
  	<td class="t_border4" bgcolor="#0277c3">
    <table width="100%" border="0" cellspacing="0" cellpadding="7">
      <tr>
        <td height="45" class="pop_title">사업자번호 조회('-'빼고 입력)</td>
      </tr>
    </table></td>
  </tr>
  <tr>
  	<td valign="top">
    <table width="100%" border="0" cellspacing="10" cellpadding="0">
      <tr>
        <td bgcolor="b0b0b0"><table width="100%" border="0" cellspacing="1" cellpadding="5">
          <tr>
            <td bgcolor="f1f1f1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="1" bgcolor="d7d7d7"></td>
              </tr>
              <tr>
                <td class="t_border3" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="10" cellpadding="0">
                  <tr>
                    <td><input type="text" name="cnum" id="cnum" placeholder="사업자번호" class="login_input" onclick="checkNum(this);" onKeyUp="checkNum(this);"></td>
                    <td width="75"><input type="image" src="<?php echo $misc;?>img/btn_pop_find.jpg" width="74" height="53" style="cursor:pointer" onClick='return chkForm();'/></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>      
      <tr>
  		<td align="center"><img src="<?php echo $misc;?>img/btn_pop_close.jpg" width="64" height="31" style="cursor:pointer" onClick='self.close();'/></td>
      </tr>
    </table>
    </td>
  </tr>
</form>
</table>

</body>
</html>