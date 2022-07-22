<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<script language="javascript">
function chkForm () {
	var mform = document.cform;
	
	if (mform.product_name.value == "") {
		mform.product_name.focus();
		alert("제품명을 입력해 주세요.");
		return false;
	}
  if (mform.product_name.value.indexOf(',') != -1){
    alert("제품명에 , 를 입력하실 수 없습니다.");
    $("#product_name").focus();
    return false;
  }
  if (mform.product_item.value.indexOf(',') != -1){
    alert("품목에 , 를 입력하실 수 없습니다.");
    $("#product_item").focus();
    return false;
  }
	if (mform.product_company.value == "") {
		mform.product_company.focus();
		alert("제조사를 입력해 주세요.");
		return false;
	}
	if (mform.product_item.value == "") {
		mform.product_item.focus();
		alert("품목을 입력해 주세요.");
		return false;
	}
	if (mform.hardware_spec.value == "") {
		mform.hardware_spec.focus();
		alert("하드웨어 스팩을 입력해 주세요.");
		return false;
	}

  if (mform.product_type.value == "") {
		mform.hardware_spec.focus();
		alert("하드웨어/소프트웨어를 구분해 주세요.");
		return false;
	}
	
	mform.submit();
	return false;
}

function chkForm2 () {
	if (confirm("정말 삭제하시겠습니까?") == true){
		var mform = document.cform;
		mform.action="<?php echo site_url();?>/company/product_delete_action";
		mform.submit();
		return false;
	}
}
</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="cform" action="<?php echo site_url();?>/company/product_input_action" method="post" onSubmit="javascript:chkForm();return false;">
<input type="hidden" name="seq" value="<?php echo $seq;?>">
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/admin_header.php";
?>
  <tr>
    <td align="center" valign="top">
    
    <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
            
            <td width="923" align="center" valign="top">
            
            <!--내용-->
            <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <!--타이틀-->
              <tr>
                <td class="title3">제품명</td>
              </tr>
              <!--//타이틀-->
              <tr>
                <td>&nbsp;</td>
              </tr>
              
             <!--리스트-->
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <colgroup>
                    <col width="15%" />
                    <col width="35%" />
                    <col width="15%" />
                    <col width="35%" />
                  </colgroup>
                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <tr class="t_top">
                    <td height="40" bgcolor="f8f8f9"  align="center">제품명</td>
                    <td  align="left" class="t_border" style="padding-left:10px;"><input name="product_name" type="text" class="input2" id="product_name" value="<?php echo $view_val['product_name'];?>"/></td>
                    <td height="40" bgcolor="f8f8f9"  class="t_border" align="center">하드웨어/소프트웨어</td>
                    <td  align="left" class="t_border" style="padding-left:10px;">
                      <select name ="product_type" id ="product_type" class="input2">
                        <option value="" <?php if($view_val['product_type'] == ''){echo "selected";} ?>>하드웨어/소프트웨어</option>
                        <option value="hardware" <?php if($view_val['product_type'] == 'hardware'){echo "selected";} ?>>하드웨어</option>
                        <option value="software" <?php if($view_val['product_type'] == 'software'){echo "selected";} ?>>소프트웨어</option>
                      </select>
                    </td>
                  </tr>

                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr class="t_top">
                    <td height="40" bgcolor="f8f8f9"  align="center">제조사</td>
                    <td  align="left" class="t_border" style="padding-left:10px;"><input name="product_company" type="text" class="input2" id="product_company" value="<?php echo $view_val['product_company'];?>"/></td>
                    <td height="40" bgcolor="f8f8f9"  class="t_border" align="center">품목</td>
                    <td  align="left" class="t_border" style="padding-left:10px;"><input name="product_item" type="text" class="input2" id="product_item" value="<?php echo $view_val['product_item'];?>"/></td>
                  </tr>
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr class="t_top">
                    <td height="40" bgcolor="f8f8f9"  align="center">하드웨어스펙</td>
                    <td  align="left" colspan="3" class="t_border" style="padding:15px 10px;"><textarea name="hardware_spec" id="hardware_spec" cols="45" rows="5" class="input4"><?php echo $view_val['hardware_spec'];?></textarea></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
                </table></td>
              </tr>
              <!--//리스트-->
              
              <tr>
                <td height="10"></td>
              </tr>
              <!--버튼-->
              <tr>
                <td align="right"><img src="<?php echo $misc;?>img/btn_list.jpg" width="64" height="31" onClick="javascript:history.go(-1)" style="cursor:pointer"/> <input type="image" src="<?php echo $misc;?>img/btn_adjust.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;"/> <img src="<?php echo $misc;?>img/btn_delete.jpg" width="64" height="31" style="cursor:pointer" border="0" onclick="javascript:chkForm2();return false;"/></td>
              </tr>
              <!--//버튼-->       

              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
            <!--//내용-->
            
            </td>
         
        </tr>
     </table>
    
    </td>
  </tr>
  <!--하단-->
  <tr>
  	<td align="center" height="100" bgcolor="#CCCCCC"><table width="1130" cellspacing="0" cellpadding="0" >      
      <tr>
        <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img src="<?php echo $misc;?>img/f_ci.png"/></td>
        <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?></td>
      </tr>
    </table></td>
  </tr>
  <!--//하단-->
</form>
</table>

</body>
</html>