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
	
	if (mform.company_name.value == "") {
		mform.company_name.focus();
		alert("회사명을 입력해 주세요.");
		return false;
	}
	if (mform.company_num.value == "") {
		mform.company_num.focus();
		alert("사업자번호를 입력해 주세요.");
		return false;
	}
	
	mform.submit();
	return false;
}

function chkForm2 () {
	if (confirm("정말 삭제하시겠습니까?") == true){
		var mform = document.cform;
		mform.action="<?php echo site_url();?>/company/companynum_delete_action";
		mform.submit();
		return false;
	}
}
</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="cform" action="<?php echo site_url();?>/company/companynum_input_action" method="post" onSubmit="javascript:chkForm();return false;">
<input type="hidden" name="seq" value="<?php echo $seq;?>">
  <tr>
  	<td height="203" align="center" background="<?php echo $misc;?>img/customer05_bg.jpg">
    <table width="1130" cellspacing="0" cellpadding="0" >
    	<tr>
            <td width="197" height="30" background="<?php echo $misc;?>img/customer_t.png"></td>
          <td align="right"><table width="15%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="right"> <?php if( $id != null ) {?>
			  <a href="<?php echo site_url();?>/account/modify_view"><?php echo $name;?></a> 님 | <a href="<?php echo site_url();?>/account/logout"><img src="<?php echo $misc;?>img/btn_logout.jpg" align="absmiddle" /></a>
			  <?php } else {?>
				<a href="<?php echo site_url();?>/account"><img src="<?php echo $misc;?>img/btn_login.jpg" align="absmiddle" /></a>
			  <?php }?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
            <td height="173"><a href="<?php echo site_url();?>"><img src="<?php echo $misc;?>img/admin_title.png" width="197" height="173" /></a></td>
            <td align="center" class="title1">고객의 미래를 생각하는 기업
            <p class="title2">두리안정보기술센터에 오신것을 환영합니다.</p></td>
        </tr>
     </table>
    </td>
  </tr>
	<tr style="height: 0px;">
	<td width="197" valign="top" style="background-color: #666666">
            
            <div id='cssmenu'>
            <ul>
               <li style="float: left"><a href='<?php echo site_url();?>/account/user'><span>회원정보</span></a></li>
               <!--<li class='has-sub'><a href='#'><span>자료실</span></a>
                  <ul>
                     <li><a href='#'><span>매뉴얼</span></a>
                     </li>
                     <li><a href='#'><span>교육자료</span></a>
                     </li>
                  </ul>
               </li>-->
               <li style="float: left"><a href='<?php echo site_url();?>/company/companynum_list'><span class="point">사업자등록번호</span></a></li>
               <li style="float: left"><a href='<?php echo site_url();?>/company/product_list'><span>제품명</span></a></li>
               <li  style="float: left"><a href='<?php echo site_url();?>/customer/customer_list'><span>거래처</span></a></li>
               <li class="last"  style="float: left"><a href='<?php echo site_url();?>/customer/sourcing_list'><span>Sourcing Group</span></a></li>
               <li class="last" style="float: left"><a href='<?php echo site_url();?>/account/group_tree_management'><span>조직도관리</span></a></li> 
              </ul>
            </div>
            
            
            
            </td>
		</tr>
  <tr>
    <td align="center" valign="top">
    
    <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
            
            <td width="923" align="center" valign="top">
            
            <!--내용-->
            <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <!--타이틀-->
              <tr>
                <td class="title3">사업자등록번호</td>
              </tr>
              <!--//타이틀-->

              <tr>
                <td>&nbsp;</td>
              </tr>
             <!--등록-->
              <tr>
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <colgroup>
                  	<col width="20%" />
                    <col width="80%" />

                  </colgroup>
                  <!--시작라인-->
                  <tr>
                    <td colspan="2" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//시작라인-->
                  
                  <tr>
                  	<td height="60" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*회사명</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="company_name" type="text" class="input7" id="company_name" value="<?php echo stripslashes($view_val['company_name']);?>"/></td>
                 </tr>
                 <tr>
                    <td colspan="2" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                 <tr>   
                    <td height="60" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*사업자등록번호('-' 빼고 입력)</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="company_num" type="text" class="input7" id="company_num" value="<?php echo $view_val['company_num'];?>" onclick="checkNum(this);" onKeyUp="checkNum(this);" maxlength="10"/></td>
                  </tr>

                  <!--마지막라인-->
                  <tr>
                    <td colspan="2" height="2" bgcolor="#797c88"></td>
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
                <td align="right"><img src="<?php echo $misc;?>img/btn_list.jpg" width="64" height="31" onClick="javascript:history.go(-1)" style="cursor:pointer"/> <input type="image" src="<?php echo $misc;?>img/btn_adjust.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;"/> <img src="<?php echo $misc;?>img/btn_delete.jpg" width="64" height="31" style="cursor:pointer" border="0" onclick="javascript:chkForm2();return false;"/></td>
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