<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style type="text/css">
.ui-datepicker{ font-size: 13.2px; width: 293px; height:190px; z-index:100; margin-left:10px;} 

#dropdown-list, .k-animation-container, .k-list-container
{
	font-size:12px !important;
	visibility:hidden !important;
}
.k-input
{
	/*padding-bottom:25px !important;*/
}

#ui-datepicker-div
{
	height:210px;
}
</style>
<script>
$(function() {
	//미니달력 공통 설정
	$.datepicker.setDefaults({
		showMonthAfterYear:true,
		dateFormat: 'yy-mm-dd',
		//buttonImageOnly: true,
		buttonImageOnly: true,
//		showOn: "both",
		//buttonText: "달력",
		changeYear: true,
		changeMonth: true,
		yearRange: 'c-100:c+10',
		nextText: '>',
		prevText: '<',
		dayNamesMin: ['월', '화', '수', '목', '금', '토', '일'], // 요일의 한글 형식.
		monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'], // 월의 한글 형식.
		yearSuffix: '년',
		buttonImage: "<?php echo $misc;?>img/btn_calendar.jpg",
		regional: 'ko'
	});
	
	$("#eval_date").datepicker();
	$("#early_date").datepicker();
});

function chkForm () {
	var mform = document.cform;
	
//	if (mform.eval_company.value == "") {
//		mform.eval_company.focus();
//		alert("평가기관을 입력해 주세요.");
//		return false;
//	}
//	if (mform.rate.value == "") {
//		mform.rate.focus();
//		alert("등급을 입력해 주세요.");
//		return false;
//	}
//	if (mform.eval_date.value == "") {
//		mform.eval_date.focus();
//		alert("평가기준일을 선택해 주세요.");
//		return false;
//	}
//	if (mform.early_date.value == "") {
//		mform.early_date.focus();
//		alert("조기경보를 선택해 주세요.");
//		return false;
//	}
	
	mform.submit();
	return false;
}
</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="cform" action="<?php echo site_url();?>/customer/customer_input_action6" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
<input type="hidden" name="seq" value="<?php echo $seq;?>">
<input type="hidden" name="mode" value="1">
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
                <td class="title3">거래처</td>
              </tr>
              <!--//타이틀-->
              <tr>
                <td>&nbsp;</td>
              </tr>
			 <!--탭-->
              <tr>
              	<td height="40">
                   <ul style="list-style:none; padding:0; margin:0;">
                    <li style="float:left;"><a href="<?php echo site_url();?>/customer/customer_view?seq=<?php echo $seq;?>&mode=modify"><img src="<?php echo $misc;?>img/sales_tab_1.jpg" /></a></li>
                    <li style="float:left;"><a href="<?php echo site_url();?>/customer/customer_view2/<?php echo $seq;?>"><img src="<?php echo $misc;?>img/sales_tab_2.jpg" /></a></li>
                    <li style="float:left;"><a href="<?php echo site_url();?>/customer/customer_view3/<?php echo $seq;?>"><img src="<?php echo $misc;?>img/sales_tab_3.jpg" /></a></li>
                    <li style="float:left;"><a href="<?php echo site_url();?>/customer/customer_view4/<?php echo $seq;?>"><img src="<?php echo $misc;?>img/sales_tab_4.jpg" /></a></li>
                    <li style="float:left;"><a href="<?php echo site_url();?>/customer/customer_view5/<?php echo $seq;?>"><img src="<?php echo $misc;?>img/sales_tab_5.jpg" /></a></li>
                    <li style="float:left;"><a href="<?php echo site_url();?>/customer/customer_view6/<?php echo $seq;?>"><img src="<?php echo $misc;?>img/sales_tab_6_on.jpg" /></a></li>
                    </ul>
                </td>
              </tr>
              <!--//탭-->
              <tr>
                <td>&nbsp;</td>
              </tr>

              <!--신용정보-->
              <tr>
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <colgroup>
                  	<col width="15%" />
                    <col width="85%" />
                  </colgroup>
                  <!--시작라인-->
                  <tr>
                    <td colspan="2" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//시작라인-->
                  
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*평가기관</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><span style="color:#333; font-size:14px;"><input name="eval_company" type="text" class="input" id="eval_company" value="<?php echo $view_val['eval_company'];?>"/></span></td>
                  </tr>
                  
                  <tr>
                    <td colspan="9" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*등급</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><span style="color:#333; font-size:14px;"><input name="rate" type="text" class="input" id="rate" value="<?php echo $view_val['rate'];?>"/></span>&nbsp;&nbsp;&nbsp;&nbsp;<?php if($view_val['file_changename']) {?><a href="<?php echo site_url();?>/customer/customer_download10/<?php echo $seq;?>/<?php echo $view_val['file_changename'];?>"><?php echo $view_val['file_realname'];?></a>&nbsp;<input name="cfile" type="file" id="cfile"/><?php } else {?><input name="cfile" type="file" id="cfile"/><?php }?></td>
                  </tr>
                  
                  <tr>
                    <td colspan="9" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*평가기준일</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><span style="color:#333; font-size:14px;"><input name="eval_date" type="text" class="input" id="eval_date" readonly value="<?php echo $view_val['eval_date'];?>"/></span></td>
                  </tr>
                  
                  <tr>
                    <td colspan="9" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*조기경보</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><span style="color:#333; font-size:14px;"><input name="early_date" type="text" class="input" id="early_date" readonly value="<?php echo $view_val['early_date'];?>"/></span></td>
                  </tr>

                  <!--마지막라인-->
                  <tr>
                    <td colspan="2" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->
                </table></td>
              </tr>
              <!--//신용정보-->
              <tr>
                <td height="10"></td>
              </tr>
              <!--버튼-->
               <tr>
                <td align="right"><input type="image" src="<?php echo $misc;?>img/btn_b_next.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;"/> <img src="<?php echo $misc;?>img/btn_b_prev.jpg" width="64" height="31" style="cursor:pointer" border="0" onclick="javascript:history.go(-1)"/></td>
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