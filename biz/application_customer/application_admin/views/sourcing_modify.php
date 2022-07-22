<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
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

function chkForm () {
	var mform = document.cform;
	
	if (mform.solution_group.value == "") {
		mform.solution_group.focus();
		alert("솔루션그룹을 입력해 주세요.");
		return false;
	}
	if (mform.product_company.value == "") {
		mform.product_company.focus();
		alert("제조사를 입력해 주세요.");
		return false;
	}
	if (mform.product_capacity.value == "") {
		mform.product_capacity.focus();
		alert("자격을 입력해 주세요.");
		return false;
	}
	if (mform.ecount.value == "") {
		mform.ecount.focus();
		alert("엔지니어수를 입력해 주세요.");
		return false;
	}
	if (mform.manage.value == "") {
		mform.manage.focus();
		alert("관리를 입력해 주세요.");
		return false;
	}
	
	mform.submit();
	return false;
}

</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="cform" action="<?php echo site_url();?>/customer/sourcing_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
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
                <td class="title3">Sourcing Group</td>
              </tr>
              <!--//타이틀-->

              <tr>
                <td>&nbsp;</td>
              </tr>
             <!--등록-->
              <tr>
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <colgroup>
                  	<col width="15%" />
                    <col width="35%" />
                    <col width="15%" />
                    <col width="35%" />
                  </colgroup>
                  <!--시작라인-->
                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//시작라인-->
                  
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">구분</td>
                    <td align="left" class="t_border" style="padding-left:10px;">
                    <select name="part" id="part" class="input">
                      <option value="001" <?php if($view_val['part'] == "001") { echo "selected"; }?>>SW</option>
					  <option value="002" <?php if($view_val['part'] == "002") { echo "selected"; }?>>HW</option>
					  <option value="003" <?php if($view_val['part'] == "003") { echo "selected"; }?>>기타</option>
                    </select>
                    </td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">Solution Group</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="solution_group" type="text" class="input" id="solution_group" value="<?php echo $view_val['solution_group'];?>"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제조사</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="product_company" type="text" class="input" id="product_company" value="<?php echo $view_val['product_company']?>"/></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">자격</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="product_capacity" type="text" class="input" id="product_capacity" value="<?php echo $view_val['product_capacity'];?>"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">엔지니어 수</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="ecount" type="text" class="input0" id="ecount" value="<?php echo $view_val['ecount'];?>" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#333; font-size:12px;">명</span></td>
                    <td height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">거래실적</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="dcount" type="text" class="input0" id="dcount" value="<?php echo $view_val['dcount'];?>" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#333; font-size:12px;">건,&nbsp;&nbsp;<input name="dprice" type="text" class="input0" id="dprice" value="<?php echo $view_val['dprice'];?>" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#333; font-size:12px;">(백만원)</span></td>
                  </tr>  
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">증빙서류</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><?php if($view_val['file_changename']) {?><a href="<?php echo site_url();?>/customer/customer_download4/<?php echo $seq;?>/<?php echo $view_val['file_changename'];?>"><?php echo $view_val['file_realname'];?></a><?php } else {?>파일없음<?php }?> <input type="file" name="cfile" id="cfile"></td>
                    <td height="40" align="center" class="t_border"  bgcolor="f8f8f9" style="font-weight:bold;">관리</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="manage" type="text" class="input" id="manage" value="<?php echo $view_val['manage'];?>"/></td>
                  </tr>  
                  
                  <!--마지막라인-->
                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->
                </table></td>
              </tr>
              <!--//등록-->
              
              <tr>
                <td height="10"></td>
              </tr>
              <!--버튼-->
              <tr>
                <td align="right"><input type="image" src="<?php echo $misc;?>img/btn_ok.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;"/> <img src="<?php echo $misc;?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer" border="0" onclick="javascript:history.go(-1)"/></td>
              </tr>
              <!--//버튼-->
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