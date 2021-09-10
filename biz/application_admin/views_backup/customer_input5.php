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
	
	$("#ccert_date").datepicker();
	$("#gcert_date").datepicker();
});

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
	
//	if (mform.closing_year.value == "") {
//		mform.closing_year.focus();
//		alert("결산년도를 입력해 주세요.");
//		return false;
//	}
//	if (mform.total_asset.value == "") {
//		mform.total_asset.focus();
//		alert("총자산을 입력해 주세요.");
//		return false;
//	}
//	if (mform.sales_amount.value == "") {
//		mform.sales_amount.focus();
//		alert("매출액을 입력해 주세요.");
//		return false;
//	}
//	if (mform.capital.value == "") {
//		mform.capital.focus();
//		alert("자본금을 입력해 주세요.");
//		return false;
//	}
//	if (mform.profit.value == "") {
//		mform.profit.focus();
//		alert("순이익을 입력해 주세요.");
//		return false;
//	}
//	if (mform.working_capital.value == "") {
//		mform.working_capital.focus();
//		alert("유동자산을 입력해 주세요.");
//		return false;
//	}
//	if (mform.working_ratio.value == "") {
//		mform.working_ratio.focus();
//		alert("유동비율을 입력해 주세요.");
//		return false;
//	}
//	if (mform.closing_year2.value == "") {
//		mform.closing_year2.focus();
//		alert("결산년도를 입력해 주세요.");
//		return false;
//	}
//	if (mform.total_asset2.value == "") {
//		mform.total_asset2.focus();
//		alert("총자산 입력해 주세요.");
//		return false;
//	}
//	if (mform.sales_amount2.value == "") {
//		mform.sales_amount2.focus();
//		alert("매출액을 입력해 주세요.");
//		return false;
//	}
//	if (mform.capital2.value == "") {
//		mform.capital2.focus();
//		alert("자본금을 입력해 주세요.");
//		return false;
//	}
//	if (mform.profit2.value == "") {
//		mform.profit2.focus();
//		alert("순이익을 입력해 주세요.");
//		return false;
//	}
//	if (mform.working_capital2.value == "") {
//		mform.working_capital2.focus();
//		alert("유동자산을 입력해 주세요.");
//		return false;
//	}
//	if (mform.working_ratio2.value == "") {
//		mform.working_ratio2.focus();
//		alert("유동비율을 입력해 주세요.");
//		return false;
//	}
//	if (mform.dfile.value == "") {
//		mform.dfile.focus();
//		alert("기본정보파일을 선택해 주세요.");
//		return false;
//	}
//	if (mform.ccert_date.value == "") {
//		mform.ccert_date.focus();
//		alert("증명서발급일을 선택해 주세요.");
//		return false;
//	}
//	if (mform.cfile.value == "") {
//		mform.cfile.focus();
//		alert("납세증명서파일을 선택해 주세요.");
//		return false;
//	}
//	if (mform.gcert_date.value == "") {
//		mform.gcert_date.focus();
//		alert("증명서발급일을 선택해 주세요.");
//		return false;
//	}
//	if (mform.gfile.value == "") {
//		mform.gfile.focus();
//		alert("납세증명서파일을 선택해 주세요.");
//		return false;
//	}
	
	mform.submit();
	return false;
}
</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="cform" action="<?php echo site_url();?>/customer/customer_input_action5" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
<input type="hidden" name="seq" value="<?php echo $seq;?>">
<input type="hidden" name="mode" value="0">
  <tr>
  	<td height="203" align="center" background="<?php echo $misc;?>img/customer08_bg.jpg">
    <table width="1130" cellspacing="0" cellpadding="0" >
    	<tr>
            <td width="197" height="30" background="<?php echo $misc;?>img/customer_t.png"></td>
          <td align="right"><table width="15%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="right"><?php if( $id != null ) {?>
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
               <li style="float: left"><a href='<?php echo site_url();?>/company/companynum_list'><span>사업자등록번호</span></a></li>
               <li style="float: left"><a href='<?php echo site_url();?>/company/product_list'><span>제품명</span></a></li>
               <li  style="float: left"><a href='<?php echo site_url();?>/customer/customer_list'><span class="point">거래처</span></a></li>
               <li class="last"  style="float: left"><a href='<?php echo site_url();?>/customer/sourcing_list'><span>Sourcing Group</span></a></li>
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
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_1.jpg" /></li>
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_2.jpg" /></li>
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_3.jpg" /></li>
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_4.jpg" /></li>
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_5_on.jpg" /></li>
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_6.jpg" /></li>
                    </ul>
                </td>
              </tr>
              <!--//탭-->
              <tr>
                <td>&nbsp;</td>
              </tr>

              <!--전기 재무정보-->
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
                    <td height="40" colspan="4" align="center" style="font-weight:bold; font-size:16px;">전기 재무정보</td>
                  </tr>  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*결산년도</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><input name="closing_year" type="text" class="input2" id="closing_year" onclick="checkNum(this);" onKeyUp="checkNum(this);"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*총자산</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="total_asset" type="text" class="input" id="total_asset" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#666; font-size:12px;">(단위:천원)</span></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">*매출액</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="sales_amount" type="text" class="input" id="sales_amount" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#666; font-size:12px;">(단위:천원)</span></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*자본금</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="capital" type="text" class="input" id="capital" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#666; font-size:12px;">(단위:천원)</span></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">*순이익</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="profit" type="text" class="input" id="profit" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#666; font-size:12px;">(단위:천원)</span></td>
                  </tr> 
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*유동자산</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="working_capital" type="text" class="input" id="working_capital" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#666; font-size:12px;">(단위:천원)</span></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">*유동비율</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="working_ratio" type="text" class="input" id="working_ratio" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#666; font-size:12px;">%</span></td>
                  </tr>  
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*전기재무정보 파일</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><input name="bfile" type="file" id="bfile"/></td>
                  </tr>
                  
                  <!--마지막라인-->
                  <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->
                </table></td>
              </tr>
              <!--//전기 재무정보-->
              
              <tr>
                <td>&nbsp;</td>
              </tr>

              <!--전전기 재무정보-->
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
                    <td height="40" colspan="4" align="center" style="font-weight:bold; font-size:16px;">이전 전기 재무정보</td>
                  </tr>  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*결산년도</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><input name="closing_year2" type="text" class="input2" id="closing_year2" onclick="checkNum(this);" onKeyUp="checkNum(this);"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*총자산</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="total_asset2" type="text" class="input" id="total_asset2" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#666; font-size:12px;">(단위:천원)</span></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">*매출액</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="sales_amount2" type="text" class="input" id="sales_amount2" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#666; font-size:12px;">(단위:천원)</span></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*자본금</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="capital2" type="text" class="input" id="capital2" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#666; font-size:12px;">(단위:천원)</span></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">*순이익</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="profit2" type="text" class="input" id="profit2" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#666; font-size:12px;">(단위:천원)</span></td>
                  </tr> 
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*유동자산</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="working_capital2" type="text" class="input" id="working_capital2" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#666; font-size:12px;">(단위:천원)</span></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">*유동비율</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="working_ratio2" type="text" class="input" id="working_ratio2" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#666; font-size:12px;">%</span></td>
                  </tr>  
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*전기재무정보 파일</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><input name="bfile2" type="file" id="bfile2"/></td>
                  </tr>
                  
                  <!--마지막라인-->
                  <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->
                </table></td>
              </tr>
              <!--//전전기 재무정보-->
              
              <tr>
                <td>&nbsp;</td>
              </tr>

              <!--기본정보-->
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
                    <td height="40" colspan="2" align="center" style="font-weight:bold; font-size:16px;">기본정보</td>
                  </tr>  
                  <tr>
                    <td colspan="2" height="1" bgcolor="#797c88"></td>
                  </tr>
                  
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*기본정보파일</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="dfile" type="file" id="dfile"/></td>
                  </tr>

                  <!--마지막라인-->
                  <tr>
                    <td colspan="2" height="1" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->
                </table></td>
              </tr>
              <!--//기본정보-->
              
              <tr>
                <td>&nbsp;</td>
              </tr>

              <!--국세-->
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
                    <td height="40" colspan="4" align="center" style="font-weight:bold; font-size:16px;">국세 납세증명서 내역</td>
                  </tr>  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*증명서 발급일</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="ccert_date" type="text" class="input" id="ccert_date" style="float:left;" readonly/> <!-- <a href="#" title="달력" style="display:block; line-height:20px; float:left; padding:1px 0 0 5px;" ><img src="<?php echo $misc;?>img/btn_calendar.jpg" /></a> --></td>
                    <td height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*납세증명서파일</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="cfile" type="file" id="cfile"/></td>
                  </tr>

                  <!--마지막라인-->
                  <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->
                </table></td>
              </tr>
              <!--//국세-->
              
              <tr>
                <td>&nbsp;</td>
              </tr>

              <!--지방세-->
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
                    <td height="40" colspan="4" align="center" style="font-weight:bold; font-size:16px;">지방세 납세증명서 내역</td>
                  </tr>  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*증명서 발급일</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="gcert_date" type="text" class="input" id="gcert_date" style="float:left;" readonly/> <!-- <a href="#" title="달력" style="display:block; line-height:20px; float:left; padding:1px 0 0 5px;" ><img src="<?php echo $misc;?>img/btn_calendar.jpg" /></a> --></td>
                    <td height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*납세증명서파일</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="gfile" type="file" id="gfile"/></td>
                  </tr>

                  <!--마지막라인-->
                  <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->
                </table></td>
              </tr>
              <!--//지방세-->
              
              <tr>
                <td height="10"></td>
              </tr>
              <!--버튼-->
              <tr>
                <td align="right"><input type="image" src="<?php echo $misc;?>img/btn_b_next.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;"/> <a href="<?php echo site_url();?>/customer/customer_list"><img src="<?php echo $misc;?>img/btn_list.jpg" width="64" height="31" border="0"/></a></td>
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