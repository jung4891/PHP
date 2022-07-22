<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style type="text/css">
#dropdown-list, .k-animation-container, .k-list-container
{
	font-size:12px !important;
	visibility:hidden !important;
}
.k-input
{
	/*padding-bottom:25px !important;*/
}
</style>
<script>
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

	if (mform.represent_name.value == "") {
		mform.represent_name.focus();
		alert("대표자 성명을 입력해 주세요.");
		return false;
	}

	var size = document.cform.elements['cnum_flag'].length;

	for(var i = 0; i < size; i++) {
	  if(document.cform.elements["cnum_flag"][i].checked) {
		   var strVal = document.cform.elements['cnum_flag'][i].value;
		   if(strVal == "Y") {
			mform.cnum_part.value = mform.cnum_part1.value;
		   } else {
			mform.cnum_part.value = mform.cnum_part2.value;
		   }
		   break;
	  }
	}
	// if (mform.company_post.value == "") {
	// 	mform.company_post.focus();
	// 	alert("주소를 선택해 주세요.");
	// 	return false;
	// }
	// if (mform.company_addr1.value == "") {
	// 	mform.company_addr1.focus();
	// 	alert("주소를 선택해 주세요.");
	// 	return false;
	// }
	if (mform.company_addr2.value == "") {
		mform.company_addr2.focus();
		alert("주소를 선택해 주세요.");
		return false;
	}
	if (mform.represent_tel.value == "") {
		mform.represent_tel.focus();
		alert("회사 대표전화를 입력해 주세요.");
		return false;
	}
	if (mform.represent_fax.value == "") {
		mform.represent_fax.focus();
		alert("대표 FAX번호를 입력해 주세요.");
		return false;
	}
	
	mform.submit();
	return false;
}

// 위와동일 체크
function ckbox_check() {
	var mform = document.cform;
	if (mform.ckbox.checked == true) {
		mform.post_post.value = mform.company_post.value;
		mform.post_addr1.value = mform.company_addr1.value;
		mform.post_addr2.value = mform.company_addr2.value;
		return false;
	} else {
		mform.post_post.value = "";
		mform.post_addr1.value = "";
		mform.post_addr2.value = "";
		return false;
	}
}

function openDaumPostcode() {
	new daum.Postcode({
		oncomplete: function(data) {
			// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
			// 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.
			document.getElementById('company_post').value = data.zonecode
			document.getElementById('company_addr1').value = data.address;
			document.getElementById('company_addr2').focus();
		}
	}).open();
}

function openDaumPostcode2() {
	new daum.Postcode({
		oncomplete: function(data) {
			// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
			// 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.
			document.getElementById('post_post').value = data.zonecode
			document.getElementById('post_addr1').value = data.address;
			document.getElementById('post_addr2').focus();
		}
	}).open();
}
</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="cform" action="<?php echo site_url();?>/customer/customer_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
<input type="hidden" name="seq" value="<?php echo $seq;?>">
<input type="hidden" name="cnum_part" value="">
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
                    <li style="float:left;"><a href="<?php echo site_url();?>/customer/customer_view?seq=<?php echo $seq;?>&mode=modify"><img src="<?php echo $misc;?>img/sales_tab_1_on.jpg" /></a></li>
                    <li style="float:left;"><a href="<?php echo site_url();?>/customer/customer_view2/<?php echo $seq;?>"><img src="<?php echo $misc;?>img/sales_tab_2.jpg" /></a></li>
                    <li style="float:left;"><a href="<?php echo site_url();?>/customer/customer_view3/<?php echo $seq;?>"><img src="<?php echo $misc;?>img/sales_tab_3.jpg" /></a></li>
                    <li style="float:left;"><a href="<?php echo site_url();?>/customer/customer_view4/<?php echo $seq;?>"><img src="<?php echo $misc;?>img/sales_tab_4.jpg" /></a></li>
                    <li style="float:left;"><a href="<?php echo site_url();?>/customer/customer_view5/<?php echo $seq;?>"><img src="<?php echo $misc;?>img/sales_tab_5.jpg" /></a></li>
                    <li style="float:left;"><a href="<?php echo site_url();?>/customer/customer_view6/<?php echo $seq;?>"><img src="<?php echo $misc;?>img/sales_tab_6.jpg" /></a></li>
                    </ul>
                </td>
              </tr>
              <!--//탭-->
              <tr>
                <td>&nbsp;</td>
              </tr>
              
              <!--작성-->
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
                    <td height="40" colspan="4" align="center" style="font-weight:bold; font-size:16px;">업체정보</td>
                  </tr>  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                   <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">업체구분</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><select name="company_part" id="company_part" class="input">
                      <option value="001" <?php if($view_val['company_part'] == "001") { echo "selected"; }?>>전체</option>
                      <option value="002" <?php if($view_val['company_part'] == "002") { echo "selected"; }?>>매입</option>
					  <option value="003" <?php if($view_val['company_part'] == "003") { echo "selected"; }?>>매출</option>
					  <option value="004" <?php if($view_val['company_part'] == "004") { echo "selected"; }?>>협력사</option>
                    </select> <span style="color:#999; font-size:10px;"></span></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">기업형태</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><select name="company_form" id="company_form" class="input">
					  <option value="" <?php if($view_val['company_form'] == "") { echo "selected"; }?>>미선택</option>
                      <option value="001" <?php if($view_val['company_form'] == "001") { echo "selected"; }?>>대기업</option>
                      <option value="002" <?php if($view_val['company_form'] == "002") { echo "selected"; }?>>중소기업</option>
					  <option value="003" <?php if($view_val['company_form'] == "003") { echo "selected"; }?>>개인</option>
                      <option value="004" <?php if($view_val['company_form'] == "004") { echo "selected"; }?>>외자기업</option>
                    </select> <span style="color:#999; font-size:10px;">※중소기업대상:상시고용 근무 종업원수가300인 미만 또는 자본금 80억 미만이 해당됩니다.</span></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*회사명</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="company_name" type="text" class="input2" id="company_name" value="<?php echo $view_val['company_name'];?>"/></td>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">법인번호</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="rnum" type="text" class="input2" id="rnum" value="<?php echo $view_val['rnum'];?>" onclick="checkNum(this);" onKeyUp="checkNum(this);"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*사업자번호('-'빼고 입력)</td>
                     <td align="left" class="t_border" style="padding-left:10px;"><input name="cnum" type="text" class="input" id="cnum" value="<?php echo $view_val['cnum'];?>" onclick="checkNum(this);" onKeyUp="checkNum(this);" maxlength="10"/> 
					 <?php if($view_val['cnumfile_changename']) {?><a href="<?php echo site_url();?>/customer/customer_download/<?php echo $seq;?>/<?php echo $view_val['cnumfile_changename'];?>"><?php echo $view_val['cnumfile_realname'];?></a><?php } else {?>파일없음<?php }?> <input type="file" name="cnum_file" id="cnum_file" value="<?php echo $view_val['company_name'];?>">
					 <!-- <?php if ($view_val['file_changename']) { ?><a href="<?php echo site_url(); ?>/tech_board/tech_doc_download/<?php echo $seq; ?>/<?php echo $view_val['file_changename']; ?>"><?php echo $view_val['file_realname']; ?></a> <a href="javascript:filedel('<?php echo $seq; ?>','<?php echo $view_val['file_changename']; ?>');"><img src="<?php echo $misc; ?>img/del.png" width="8" height="8" /></a>&nbsp;&nbsp;<input name="cfile" id="cfile" type="file" size="78" disabled><?php } else { ?><input name="cfile" type="file" size="78"> <span class="point0 txt_s">(용량제한 100MB)<?php } ?> -->
					 </td>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">구매거래 통화</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><select name="perchase_part" id="perchase_part" class="input">
                      <option value="001" <?php if($view_val['perchase_part'] == "001") { echo "selected"; }?>>유럽 유로</option>
                      <option value="002" <?php if($view_val['perchase_part'] == "002") { echo "selected"; }?>>일본 엔화</option>
					  <option value="003" <?php if($view_val['perchase_part'] == "003") { echo "selected"; }?>>한국 원화</option>
                      <option value="004" <?php if($view_val['perchase_part'] == "004") { echo "selected"; }?>>중국 위안</option>
					  <option value="005" <?php if($view_val['perchase_part'] == "005") { echo "selected"; }?>>미국 달러</option>
                    </select></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*대표자 성명</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><input name="represent_name" type="text" class="input" id="represent_name" value="<?php echo $view_val['represent_name'];?>"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">업태</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="company_category" type="text" class="input" id="company_category" value="<?php echo $view_val['company_category'];?>"/> <span style="color:#999; font-size:10px;">사업자등록기준</span></td>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">*업종</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="company_sector" type="text" class="input" id="company_sector" value="<?php echo $view_val['company_sector'];?>"/> <span style="color:#999; font-size:10px;">사업자등록기준</span></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">설립일자</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="establish_date" type="date" class="input" id="establish_date" style="float:left;" value="<?php echo $view_val['establish_date'];?>" /> <!-- <img src="<?php echo $misc;?>img/btn_calendar.jpg" /> --></td>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">진입사유</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="entry_reason" id="entry_reason" type="radio" value="N" checked="checked" style=" float:left;" /> <span style=" display:block; float:left; line-height:18px; padding:0 5px;">신규</span> <input name="entry_reason" type="radio" id="entry_reason" value="R" checked="checked" style="float:left;" /> <span style=" display:block; float:left; line-height:18px; padding:0 5px;">추천</span></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">당사추천인정보</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><input name="recommand_name" type="text" class="input" id="recommand_name" value="<?php echo $view_val['recommand_name'];?>"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">사업자등록증</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;">
                    <input name="cnum_flag" type="radio" value="Y" style=" float:left;" <?php if($view_val['cnum_flag'] == "Y") { echo "checked"; }?>/> <span style=" display:block; float:left; line-height:18px; padding:0 5px;">(유)</span> <select name="cnum_part1" id="cnum_part1" class="input" style="float:left; margin-right:10px;">
                      <option value="001" <?php if($view_val['cnum_part'] == "001") { echo "selected"; }?>>국내(법인-일반)</option>
                      <option value="002" <?php if($view_val['cnum_part'] == "002") { echo "selected"; }?>>국내(개인)</option>
                    </select>
					<input name="cnum_flag" type="radio" value="N" style="float:left;" <?php if($view_val['cnum_flag'] == "N") { echo "checked"; }?>/> <span style=" display:block; float:left; line-height:18px; padding:0 5px;">(무)</span> <select name="cnum_part2" id="cnum_part2" class="input" style="float:left;">
                      <option value="003" <?php if($view_val['cnum_part'] == "003") { echo "selected"; }?>>해외(법인)</option>
                      <option value="004" <?php if($view_val['cnum_part'] == "004") { echo "selected"; }?>>국내(개인)</option>
					  <option value="005" <?php if($view_val['cnum_part'] == "005") { echo "selected"; }?>>해외(개인)</option>
                    </select></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*주소</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;">
                    <span style="display:block; line-height:35px;"><input name="company_post" type="text" class="input" id="company_post" readonly value="<?php echo $view_val['company_post'];?>"/> <input type="button" value="우편번호" class="button" onclick="javascript:openDaumPostcode();" style="cursor:pointer;"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="company_addr1" type="text" class="input2" id="company_addr1" readonly value="<?php echo $view_val['company_addr1'];?>"/></span>
                    <span style="display:block; line-height:35px; height:30px;"><input name="company_addr2" type="text" class="input6" id="company_addr2" value="<?php echo $view_val['company_addr2'];?>"/></span>
                    </td>
                  </tr> 
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">우편물수령 주소</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;">
                    <span style="display:block; line-height:35px;"><input name="post_post" type="text" class="input" id="post_post" readonly value="<?php echo $view_val['post_post'];?>"/> <input type="button" value="우편번호" class="button" onclick="javascript:openDaumPostcode2();" style="cursor:pointer;"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="post_addr1" type="text" class="input2" id="post_addr1" readonly value="<?php echo $view_val['post_addr1'];?>"/></span>
                    <span style="display:block; line-height:35px; height:30px; float:left;"><input name="post_addr2" type="text" class="input6" id="post_addr2" value="<?php echo $view_val['post_addr2'];?>"/></span> <input name="ckbox" type="checkbox" id="ckbox" onclick="javascript:ckbox_check();"value="위와 동일" style="float:left; padding:5px 0 0 10px;" /> <span style=" display:block; float:left; line-height:22px; padding:0 5px;">위와동일</span>
                    </td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*회사대표전화</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><input name="represent_tel" type="text" class="input" id="represent_tel" value="<?php echo $view_val['represent_tel'];?>" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#999; font-size:10px;">예) 020000000</span></td>
                  </tr> 
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">대표자 이동전화</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="represent_handphone" type="text" class="input" id="represent_handphone" value="<?php echo $view_val['represent_handphone'];?>" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#999; font-size:10px;">예) 01000000000</span></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">*대표 FAX번호</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="represent_fax" type="text" class="input" id="represent_fax" value="<?php echo $view_val['represent_fax'];?>" onclick="checkNum(this);" onKeyUp="checkNum(this);"/></td>
                  </tr> 
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">대표 E-mail</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><input name="represent_email" type="text" class="input" id="represent_email" value="<?php echo $view_val['represent_email'];?>"/></td>
                  </tr>     
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">지역코드</td>
					<td align="left" class="t_border" style="padding-left:10px;"><select name="local_code" id="local_code" class="input" style="float:left;">
					  <option value="" <?php if($view_val['local_code'] == "") { echo "selected"; }?>>미선택</option>
                      <option value="001" <?php if($view_val['local_code'] == "001") { echo "selected"; }?>>제주도</option>
                      <option value="002" <?php if($view_val['local_code'] == "002") { echo "selected"; }?>>전라북도</option>
					  <option value="003" <?php if($view_val['local_code'] == "003") { echo "selected"; }?>>전라남도</option>
                      <option value="004" <?php if($view_val['local_code'] == "004") { echo "selected"; }?>>충청북도</option>
					  <option value="005" <?php if($view_val['local_code'] == "005") { echo "selected"; }?>>충청남도</option>
                      <option value="006" <?php if($view_val['local_code'] == "006") { echo "selected"; }?>>인천광역시</option>
					  <option value="007" <?php if($view_val['local_code'] == "007") { echo "selected"; }?>>강원도</option>
                      <option value="008" <?php if($view_val['local_code'] == "008") { echo "selected"; }?>>광주광역시</option>
					  <option value="009" <?php if($view_val['local_code'] == "009") { echo "selected"; }?>>경기도</option>
                      <option value="010" <?php if($view_val['local_code'] == "010") { echo "selected"; }?>>경상북도</option>
					  <option value="011" <?php if($view_val['local_code'] == "011") { echo "selected"; }?>>경상남도</option>
                      <option value="012" <?php if($view_val['local_code'] == "012") { echo "selected"; }?>>부산광역시</option>
					  <option value="013" <?php if($view_val['local_code'] == "013") { echo "selected"; }?>>서울특별시</option>
					  <option value="014" <?php if($view_val['local_code'] == "014") { echo "selected"; }?>>대구광역시</option>
					  <option value="015" <?php if($view_val['local_code'] == "015") { echo "selected"; }?>>대전광역시</option>
					  <option value="016" <?php if($view_val['local_code'] == "016") { echo "selected"; }?>>울산광역시</option>
                    </select></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">국가코드</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><select name="ccountry_code" id="ccountry_code" class="input" style="float:left;">
						<option value='' <?php if($view_val['ccountry_code'] == "") { echo "selected"; }?>>미선택</option>
						<option value='GH' <?php if($view_val['ccountry_code'] == "GH") { echo "selected"; }?>>가나	</option>
						<option value='GH' <?php if($view_val['ccountry_code'] == "GH") { echo "selected"; }?>>가봉	</option>
						<option value='GY' <?php if($view_val['ccountry_code'] == "GY") { echo "selected"; }?>>가이아나	</option>
						<option value='GM' <?php if($view_val['ccountry_code'] == "GM") { echo "selected"; }?>>갬비아	</option>
						<option value='GT' <?php if($view_val['ccountry_code'] == "GT") { echo "selected"; }?>>과테말라	</option>
						<option value='GU' <?php if($view_val['ccountry_code'] == "GU") { echo "selected"; }?>>괌	</option>
						<option value='GP' <?php if($view_val['ccountry_code'] == "GP") { echo "selected"; }?>>구아데루프	</option>
						<option value='GD' <?php if($view_val['ccountry_code'] == "GD") { echo "selected"; }?>>그레나다	</option>
						<option value='GR' <?php if($view_val['ccountry_code'] == "GR") { echo "selected"; }?>>그리스	</option>
						<option value='GL' <?php if($view_val['ccountry_code'] == "GL") { echo "selected"; }?>>그린란드	</option>
						<option value='GN' <?php if($view_val['ccountry_code'] == "GN") { echo "selected"; }?>>기니	</option>
						<option value='GW' <?php if($view_val['ccountry_code'] == "GW") { echo "selected"; }?>>기니비사우</option>
						<option value='NA' <?php if($view_val['ccountry_code'] == "NA") { echo "selected"; }?>>나미비아	</option>
						<option value='NR' <?php if($view_val['ccountry_code'] == "NR") { echo "selected"; }?>>나우루	</option>
						<option value='NG' <?php if($view_val['ccountry_code'] == "NG") { echo "selected"; }?>>나이지리아	</option>
						<option value='AQ' <?php if($view_val['ccountry_code'] == "AQ") { echo "selected"; }?>>남극대륙	</option>
						<option value='ZA' <?php if($view_val['ccountry_code'] == "ZA") { echo "selected"; }?>>남아프리카	</option>
						<option value='AN' <?php if($view_val['ccountry_code'] == "AN") { echo "selected"; }?>>네덜란드 엔틸스</option>
						<option value='NL' <?php if($view_val['ccountry_code'] == "NL") { echo "selected"; }?>>네덜란드	</option>
						<option value='NP' <?php if($view_val['ccountry_code'] == "NP") { echo "selected"; }?>>네팔	</option>
						<option value='NO' <?php if($view_val['ccountry_code'] == "NO") { echo "selected"; }?>>노르웨이	</option>
						<option value='NF' <?php if($view_val['ccountry_code'] == "NF") { echo "selected"; }?>>노퍽군도	</option>
						<option value='NZ' <?php if($view_val['ccountry_code'] == "NZ") { echo "selected"; }?>>뉴질랜드	</option>
						<option value='NC' <?php if($view_val['ccountry_code'] == "NC") { echo "selected"; }?>>뉴캘러도니아	</option>
						<option value='NU' <?php if($view_val['ccountry_code'] == "NU") { echo "selected"; }?>>니우제도	</option>
						<option value='NE' <?php if($view_val['ccountry_code'] == "NE") { echo "selected"; }?>>니제르	</option>
						<option value='NI' <?php if($view_val['ccountry_code'] == "NI") { echo "selected"; }?>>니카라과	</option>
						<option value='TW' <?php if($view_val['ccountry_code'] == "TW") { echo "selected"; }?>>대만	</option>
						<option value='DK' <?php if($view_val['ccountry_code'] == "DK") { echo "selected"; }?>>덴마크	</option>
						<option value='DM' <?php if($view_val['ccountry_code'] == "DM") { echo "selected"; }?>>도미니카	</option>
						<option value='DO' <?php if($view_val['ccountry_code'] == "DO") { echo "selected"; }?>>도미니카공화국</option>
						<option value='DE' <?php if($view_val['ccountry_code'] == "DE") { echo "selected"; }?>>독일	</option>
						<option value='TP' <?php if($view_val['ccountry_code'] == "TP") { echo "selected"; }?>>동 티모르	</option>
						<option value='LA' <?php if($view_val['ccountry_code'] == "LA") { echo "selected"; }?>>라오스	</option>
						<option value='LR' <?php if($view_val['ccountry_code'] == "LR") { echo "selected"; }?>>라이베리아	</option>
						<option value='LV' <?php if($view_val['ccountry_code'] == "LV") { echo "selected"; }?>>라트비아	</option>
						<option value='RU' <?php if($view_val['ccountry_code'] == "RU") { echo "selected"; }?>>러시아연방	</option>
						<option value='LB' <?php if($view_val['ccountry_code'] == "LB") { echo "selected"; }?>>레바논	</option>
						<option value='LS' <?php if($view_val['ccountry_code'] == "LS") { echo "selected"; }?>>레소토	</option>
						<option value='RE' <?php if($view_val['ccountry_code'] == "RE") { echo "selected"; }?>>레유니온	</option>
						<option value='RO' <?php if($view_val['ccountry_code'] == "RO") { echo "selected"; }?>>루마니아	</option>
						<option value='LU' <?php if($view_val['ccountry_code'] == "LU") { echo "selected"; }?>>룩셈부르크	</option>
						<option value='RW' <?php if($view_val['ccountry_code'] == "RW") { echo "selected"; }?>>르완다	</option>
						<option value='LY' <?php if($view_val['ccountry_code'] == "LY") { echo "selected"; }?>>리비아	</option>
						<option value='LI' <?php if($view_val['ccountry_code'] == "LI") { echo "selected"; }?>>리이텐슈타인	</option>
						<option value='LT' <?php if($view_val['ccountry_code'] == "LT") { echo "selected"; }?>>리투아니아	</option>
						<option value='MG' <?php if($view_val['ccountry_code'] == "MG") { echo "selected"; }?>>마다가스카르	</option>
						<option value='MH' <?php if($view_val['ccountry_code'] == "MH") { echo "selected"; }?>>마샬군도	</option>
						<option value='YT' <?php if($view_val['ccountry_code'] == "YT") { echo "selected"; }?>>마요트	</option>
						<option value='MO' <?php if($view_val['ccountry_code'] == "MO") { echo "selected"; }?>>마카오	</option>
						<option value='MK' <?php if($view_val['ccountry_code'] == "MK") { echo "selected"; }?>>마케도니아	</option>
						<option value='MQ' <?php if($view_val['ccountry_code'] == "MQ") { echo "selected"; }?>>마티니끄	</option>
						<option value='MW' <?php if($view_val['ccountry_code'] == "MW") { echo "selected"; }?>>말라위	</option>
						<option value='MY' <?php if($view_val['ccountry_code'] == "MY") { echo "selected"; }?>>말레이지아	</option>
						<option value='ML' <?php if($view_val['ccountry_code'] == "ML") { echo "selected"; }?>>말리	</option>
						<option value='MT' <?php if($view_val['ccountry_code'] == "MT") { echo "selected"; }?>>말타	</option>
						<option value='MX' <?php if($view_val['ccountry_code'] == "MX") { echo "selected"; }?>>멕시코	</option>
						<option value='MC' <?php if($view_val['ccountry_code'] == "MC") { echo "selected"; }?>>모나코	</option>
						<option value='MA' <?php if($view_val['ccountry_code'] == "MA") { echo "selected"; }?>>모로코	</option>
						<option value='MU' <?php if($view_val['ccountry_code'] == "MU") { echo "selected"; }?>>모리셔스	</option>
						<option value='MR' <?php if($view_val['ccountry_code'] == "MR") { echo "selected"; }?>>모리타니아	</option>
						<option value='MZ' <?php if($view_val['ccountry_code'] == "MZ") { echo "selected"; }?>>모잠비크	</option>
						<option value='MS' <?php if($view_val['ccountry_code'] == "MS") { echo "selected"; }?>>몬트세랏	</option>
						<option value='MD' <?php if($view_val['ccountry_code'] == "MD") { echo "selected"; }?>>몰다비아	</option>
						<option value='MV' <?php if($view_val['ccountry_code'] == "MV") { echo "selected"; }?>>몰디브	</option>
						<option value='MN' <?php if($view_val['ccountry_code'] == "MN") { echo "selected"; }?>>몽고	</option>
						<option value='VI' <?php if($view_val['ccountry_code'] == "VI") { echo "selected"; }?>>미국 버진제도	</option>
						<option value='US' <?php if($view_val['ccountry_code'] == "US") { echo "selected"; }?>>미국	</option>
						<option value='MM' <?php if($view_val['ccountry_code'] == "MM") { echo "selected"; }?>>미얀마	</option>
						<option value='FM' <?php if($view_val['ccountry_code'] == "FM") { echo "selected"; }?>>미크로네시아	</option>
						<option value='VU' <?php if($view_val['ccountry_code'] == "VU") { echo "selected"; }?>>바누아투	</option>
						<option value='BH' <?php if($view_val['ccountry_code'] == "BH") { echo "selected"; }?>>바레인	</option>
						<option value='BB' <?php if($view_val['ccountry_code'] == "BB") { echo "selected"; }?>>바베이도즈	</option>
						<option value='VA' <?php if($view_val['ccountry_code'] == "VA") { echo "selected"; }?>>바티칸시	</option>
						<option value='BS' <?php if($view_val['ccountry_code'] == "BS") { echo "selected"; }?>>바하마	</option>
						<option value='WF' <?php if($view_val['ccountry_code'] == "WF") { echo "selected"; }?>>발리,푸투나	</option>
						<option value='BD' <?php if($view_val['ccountry_code'] == "BD") { echo "selected"; }?>>방글라데시	</option>
						<option value='BY' <?php if($view_val['ccountry_code'] == "BY") { echo "selected"; }?>>백러시아	</option>
						<option value='BM' <?php if($view_val['ccountry_code'] == "BM") { echo "selected"; }?>>버뮤다	</option>
						<option value='BJ' <?php if($view_val['ccountry_code'] == "BJ") { echo "selected"; }?>>베냉	</option>
						<option value='VE' <?php if($view_val['ccountry_code'] == "VE") { echo "selected"; }?>>베네수엘라	</option>
						<option value='VN' <?php if($view_val['ccountry_code'] == "VN") { echo "selected"; }?>>베트남	</option>
						<option value='BE' <?php if($view_val['ccountry_code'] == "BE") { echo "selected"; }?>>벨기에	</option>
						<option value='BZ' <?php if($view_val['ccountry_code'] == "BZ") { echo "selected"; }?>>벨리즈	</option>
						<option value='BA' <?php if($view_val['ccountry_code'] == "BA") { echo "selected"; }?>>보스니아-헤르즈</option>
						<option value='BW' <?php if($view_val['ccountry_code'] == "BW") { echo "selected"; }?>>보츠와나	</option>
						<option value='BO' <?php if($view_val['ccountry_code'] == "BO") { echo "selected"; }?>>볼리비아	</option>
						<option value='BI' <?php if($view_val['ccountry_code'] == "BI") { echo "selected"; }?>>부룬디	</option>
						<option value='BF' <?php if($view_val['ccountry_code'] == "BF") { echo "selected"; }?>>부르키나-파소</option>
						<option value='BV' <?php if($view_val['ccountry_code'] == "BV") { echo "selected"; }?>>부베군도인	</option>
						<option value='BT' <?php if($view_val['ccountry_code'] == "BT") { echo "selected"; }?>>부탄	</option>
						<option value='MP' <?php if($view_val['ccountry_code'] == "MP") { echo "selected"; }?>>북마리아나제도</option>
						<option value='KP' <?php if($view_val['ccountry_code'] == "KP") { echo "selected"; }?>>북한	</option>
						<option value='BG' <?php if($view_val['ccountry_code'] == "BG") { echo "selected"; }?>>불가리아	</option>
						<option value='BR' <?php if($view_val['ccountry_code'] == "BR") { echo "selected"; }?>>브라질	</option>
						<option value='BN' <?php if($view_val['ccountry_code'] == "BN") { echo "selected"; }?>>브루네이	</option>
						<option value='AS' <?php if($view_val['ccountry_code'] == "AS") { echo "selected"; }?>>사모아,미국	</option>
						<option value='SA' <?php if($view_val['ccountry_code'] == "SA") { echo "selected"; }?>>사우디아라비아</option>
						<option value='SM' <?php if($view_val['ccountry_code'] == "SM") { echo "selected"; }?>>산마리노	</option>
						<option value='EH' <?php if($view_val['ccountry_code'] == "EH") { echo "selected"; }?>>서부사하라	</option>
						<option value='WS' <?php if($view_val['ccountry_code'] == "WS") { echo "selected"; }?>>서사모아	</option>
						<option value='GS' <?php if($view_val['ccountry_code'] == "GS") { echo "selected"; }?>>성 샌드위치섬</option>
						<option value='KN' <?php if($view_val['ccountry_code'] == "KN") { echo "selected"; }?>>성 키츠&네비스</option>
						<option value='ST' <?php if($view_val['ccountry_code'] == "ST") { echo "selected"; }?>>성 톰,프린시프</option>
						<option value='PM' <?php if($view_val['ccountry_code'] == "PM") { echo "selected"; }?>>성 피에르,미켈</option>
						<option value='SH' <?php if($view_val['ccountry_code'] == "SH") { echo "selected"; }?>>성 헬레나	</option>
						<option value='SN' <?php if($view_val['ccountry_code'] == "SN") { echo "selected"; }?>>세네갈	</option>
						<option value='SC' <?php if($view_val['ccountry_code'] == "SC") { echo "selected"; }?>>세이셸	</option>
						<option value='LC' <?php if($view_val['ccountry_code'] == "LC") { echo "selected"; }?>>세인트루시아	</option>
						<option value='VC' <?php if($view_val['ccountry_code'] == "VC") { echo "selected"; }?>>세인트빈센트	</option>
						<option value='SO' <?php if($view_val['ccountry_code'] == "SO") { echo "selected"; }?>>소말리아	</option>
						<option value='SB' <?php if($view_val['ccountry_code'] == "SB") { echo "selected"; }?>>솔로몬군도	</option>
						<option value='SD' <?php if($view_val['ccountry_code'] == "SD") { echo "selected"; }?>>수단	</option>
						<option value='SR' <?php if($view_val['ccountry_code'] == "SR") { echo "selected"; }?>>수리남	</option>
						<option value='LK' <?php if($view_val['ccountry_code'] == "LK") { echo "selected"; }?>>스리랑카	</option>
						<option value='SJ' <?php if($view_val['ccountry_code'] == "SJ") { echo "selected"; }?>>스발바드	</option>
						<option value='SZ' <?php if($view_val['ccountry_code'] == "SZ") { echo "selected"; }?>>스와질란드	</option>
						<option value='SE' <?php if($view_val['ccountry_code'] == "SE") { echo "selected"; }?>>스웨덴	</option>
						<option value='CH' <?php if($view_val['ccountry_code'] == "CH") { echo "selected"; }?>>스위스	</option>
						<option value='ES' <?php if($view_val['ccountry_code'] == "ES") { echo "selected"; }?>>스페인	</option>
						<option value='SK' <?php if($view_val['ccountry_code'] == "SK") { echo "selected"; }?>>슬로바키아	</option>
						<option value='SI' <?php if($view_val['ccountry_code'] == "SI") { echo "selected"; }?>>슬로베니아	</option>
						<option value='SY' <?php if($view_val['ccountry_code'] == "SY") { echo "selected"; }?>>시리아	</option>
						<option value='SL' <?php if($view_val['ccountry_code'] == "SL") { echo "selected"; }?>>시에라리온	</option>
						<option value='SG' <?php if($view_val['ccountry_code'] == "SG") { echo "selected"; }?>>싱가폴	</option>
						<option value='AE' <?php if($view_val['ccountry_code'] == "AE") { echo "selected"; }?>>아랍에미리트	</option>
						<option value='AW' <?php if($view_val['ccountry_code'] == "AW") { echo "selected"; }?>>아루바	</option>
						<option value='AM' <?php if($view_val['ccountry_code'] == "AM") { echo "selected"; }?>>아르메니아	</option>
						<option value='AR' <?php if($view_val['ccountry_code'] == "AR") { echo "selected"; }?>>아르헨티나	</option>
						<option value='IS' <?php if($view_val['ccountry_code'] == "IS") { echo "selected"; }?>>아이슬란드	</option>
						<option value='HT' <?php if($view_val['ccountry_code'] == "HT") { echo "selected"; }?>>아이티	</option>
						<option value='IE' <?php if($view_val['ccountry_code'] == "IE") { echo "selected"; }?>>아일랜드	</option>
						<option value='AZ' <?php if($view_val['ccountry_code'] == "AZ") { echo "selected"; }?>>아제르바이잔	</option>
						<option value='AF' <?php if($view_val['ccountry_code'] == "AF") { echo "selected"; }?>>아프가니스탄	</option>
						<option value='AD' <?php if($view_val['ccountry_code'] == "AD") { echo "selected"; }?>>안도라	</option>
						<option value='AL' <?php if($view_val['ccountry_code'] == "AL") { echo "selected"; }?>>알바니아	</option>
						<option value='DZ' <?php if($view_val['ccountry_code'] == "DZ") { echo "selected"; }?>>알제리	</option>
						<option value='AO' <?php if($view_val['ccountry_code'] == "AO") { echo "selected"; }?>>앙골라	</option>
						<option value='AG' <?php if($view_val['ccountry_code'] == "AG") { echo "selected"; }?>>앤티가/바바드</option>
						<option value='AI' <?php if($view_val['ccountry_code'] == "AI") { echo "selected"; }?>>앵글리어	</option>
						<option value='ER' <?php if($view_val['ccountry_code'] == "ER") { echo "selected"; }?>>에리트리아	</option>
						<option value='EE' <?php if($view_val['ccountry_code'] == "EE") { echo "selected"; }?>>에스토니아	</option>
						<option value='EC' <?php if($view_val['ccountry_code'] == "EC") { echo "selected"; }?>>에콰도르	</option>
						<option value='ET' <?php if($view_val['ccountry_code'] == "ET") { echo "selected"; }?>>에티오피아	</option>
						<option value='SV' <?php if($view_val['ccountry_code'] == "SV") { echo "selected"; }?>>엘살바도르	</option>
						<option value='GB' <?php if($view_val['ccountry_code'] == "GB") { echo "selected"; }?>>영국	</option>
						<option value='YE' <?php if($view_val['ccountry_code'] == "YE") { echo "selected"; }?>>예멘	</option>
						<option value='OM' <?php if($view_val['ccountry_code'] == "OM") { echo "selected"; }?>>오만	</option>
						<option value='AT' <?php if($view_val['ccountry_code'] == "AT") { echo "selected"; }?>>오스트리아	</option>
						<option value='HN' <?php if($view_val['ccountry_code'] == "HN") { echo "selected"; }?>>온두라스	</option>
						<option value='JO' <?php if($view_val['ccountry_code'] == "JO") { echo "selected"; }?>>요르단	</option>
						<option value='UG' <?php if($view_val['ccountry_code'] == "UG") { echo "selected"; }?>>우간다	</option>
						<option value='UY' <?php if($view_val['ccountry_code'] == "UY") { echo "selected"; }?>>우루과이	</option>
						<option value='UZ' <?php if($view_val['ccountry_code'] == "UZ") { echo "selected"; }?>>우즈베키스탄	</option>
						<option value='UA' <?php if($view_val['ccountry_code'] == "UA") { echo "selected"; }?>>우크라이나	</option>
						<option value='YU' <?php if($view_val['ccountry_code'] == "YU") { echo "selected"; }?>>유고슬라비아	</option>
						<option value='IQ' <?php if($view_val['ccountry_code'] == "IQ") { echo "selected"; }?>>이라크	</option>
						<option value='IR' <?php if($view_val['ccountry_code'] == "IR") { echo "selected"; }?>>이란	</option>
						<option value='IL' <?php if($view_val['ccountry_code'] == "IL") { echo "selected"; }?>>이스라엘	</option>
						<option value='EG' <?php if($view_val['ccountry_code'] == "EG") { echo "selected"; }?>>이집트	</option>
						<option value='IT' <?php if($view_val['ccountry_code'] == "IT") { echo "selected"; }?>>이탈리아	</option>
						<option value='IN' <?php if($view_val['ccountry_code'] == "IN") { echo "selected"; }?>>인도	</option>
						<option value='ID' <?php if($view_val['ccountry_code'] == "ID") { echo "selected"; }?>>인도네시아	</option>
						<option value='JP' <?php if($view_val['ccountry_code'] == "JP") { echo "selected"; }?>>일본	</option>
						<option value='JM' <?php if($view_val['ccountry_code'] == "JM") { echo "selected"; }?>>자메이카	</option>
						<option value='ZM' <?php if($view_val['ccountry_code'] == "ZM") { echo "selected"; }?>>잠비아	</option>
						<option value='GQ' <?php if($view_val['ccountry_code'] == "GQ") { echo "selected"; }?>>적도기니공화국</option>
						<option value='GE' <?php if($view_val['ccountry_code'] == "GE") { echo "selected"; }?>>조지아	</option>
						<option value='CN' <?php if($view_val['ccountry_code'] == "CN") { echo "selected"; }?>>중국	</option>
						<option value='CF' <?php if($view_val['ccountry_code'] == "CF") { echo "selected"; }?>>중앙아프리카	</option>
						<option value='DJ' <?php if($view_val['ccountry_code'] == "DJ") { echo "selected"; }?>>지부티	</option>
						<option value='GI' <?php if($view_val['ccountry_code'] == "GI") { echo "selected"; }?>>지브롤터	</option>
						<option value='ZW' <?php if($view_val['ccountry_code'] == "ZW") { echo "selected"; }?>>짐바브웨	</option>
						<option value='TD' <?php if($view_val['ccountry_code'] == "TD") { echo "selected"; }?>>챠드	</option>
						<option value='CZ' <?php if($view_val['ccountry_code'] == "CZ") { echo "selected"; }?>>체코공화국	</option>
						<option value='CL' <?php if($view_val['ccountry_code'] == "CL") { echo "selected"; }?>>칠레	</option>
						<option value='CM' <?php if($view_val['ccountry_code'] == "CM") { echo "selected"; }?>>카메룬	</option>
						<option value='KY' <?php if($view_val['ccountry_code'] == "KY") { echo "selected"; }?>>카이만제도	</option>
						<option value='KZ' <?php if($view_val['ccountry_code'] == "KZ") { echo "selected"; }?>>카자흐	</option>
						<option value='QA' <?php if($view_val['ccountry_code'] == "QA") { echo "selected"; }?>>카타르	</option>
						<option value='CV' <?php if($view_val['ccountry_code'] == "CV") { echo "selected"; }?>>카포베르데	</option>
						<option value='KH' <?php if($view_val['ccountry_code'] == "KH") { echo "selected"; }?>>캄보디아	</option>
						<option value='CA' <?php if($view_val['ccountry_code'] == "CA") { echo "selected"; }?>>캐나다	</option>
						<option value='KE' <?php if($view_val['ccountry_code'] == "KE") { echo "selected"; }?>>케냐	</option>
						<option value='KM' <?php if($view_val['ccountry_code'] == "KM") { echo "selected"; }?>>코모로	</option>
						<option value='CR' <?php if($view_val['ccountry_code'] == "CR") { echo "selected"; }?>>코스타리카	</option>
						<option value='CC' <?php if($view_val['ccountry_code'] == "CC") { echo "selected"; }?>>코코넛아일랜드</option>
						<option value='CI' <?php if($view_val['ccountry_code'] == "CI") { echo "selected"; }?>>코트디부아르	</option>
						<option value='CO' <?php if($view_val['ccountry_code'] == "CO") { echo "selected"; }?>>콜롬비아	</option>
						<option value='CG' <?php if($view_val['ccountry_code'] == "CG") { echo "selected"; }?>>콩고	</option>
						<option value='CD' <?php if($view_val['ccountry_code'] == "CD") { echo "selected"; }?>>콩고	</option>
						<option value='CU' <?php if($view_val['ccountry_code'] == "CU") { echo "selected"; }?>>쿠바	</option>
						<option value='KW' <?php if($view_val['ccountry_code'] == "KW") { echo "selected"; }?>>쿠웨이트	</option>
						<option value='CK' <?php if($view_val['ccountry_code'] == "CK") { echo "selected"; }?>>쿡아일랜드	</option>
						<option value='HR' <?php if($view_val['ccountry_code'] == "HR") { echo "selected"; }?>>크로아티아	</option>
						<option value='CX' <?php if($view_val['ccountry_code'] == "CX") { echo "selected"; }?>>크리스마스제도</option>
						<option value='KG' <?php if($view_val['ccountry_code'] == "KG") { echo "selected"; }?>>키르기즈탄	</option>
						<option value='KI' <?php if($view_val['ccountry_code'] == "KI") { echo "selected"; }?>>키리바시	</option>
						<option value='CY' <?php if($view_val['ccountry_code'] == "CY") { echo "selected"; }?>>키프로스	</option>
						<option value='TJ' <?php if($view_val['ccountry_code'] == "TJ") { echo "selected"; }?>>타지크공화국	</option>
						<option value='TZ' <?php if($view_val['ccountry_code'] == "TZ") { echo "selected"; }?>>탄자니아	</option>
						<option value='TH' <?php if($view_val['ccountry_code'] == "TH") { echo "selected"; }?>>태국	</option>
						<option value='TC' <?php if($view_val['ccountry_code'] == "TC") { echo "selected"; }?>>터어키 카이코진</option>
						<option value='TR' <?php if($view_val['ccountry_code'] == "TR") { echo "selected"; }?>>터키	</option>
						<option value='TG' <?php if($view_val['ccountry_code'] == "TG") { echo "selected"; }?>>토고	</option>
						<option value='TK' <?php if($view_val['ccountry_code'] == "TK") { echo "selected"; }?>>토클로 제도	</option>
						<option value='TO' <?php if($view_val['ccountry_code'] == "TO") { echo "selected"; }?>>통가	</option>
						<option value='TM' <?php if($view_val['ccountry_code'] == "TM") { echo "selected"; }?>>투르크메니스탄</option>
						<option value='TV' <?php if($view_val['ccountry_code'] == "TV") { echo "selected"; }?>>투발루	</option>
						<option value='TN' <?php if($view_val['ccountry_code'] == "TN") { echo "selected"; }?>>튀니지	</option>
						<option value='TT' <?php if($view_val['ccountry_code'] == "TT") { echo "selected"; }?>>트리니닷,토바고</option>
						<option value='PA' <?php if($view_val['ccountry_code'] == "PA") { echo "selected"; }?>>파나마	</option>
						<option value='PY' <?php if($view_val['ccountry_code'] == "PY") { echo "selected"; }?>>파라과이	</option>
						<option value='PK' <?php if($view_val['ccountry_code'] == "PK") { echo "selected"; }?>>파키스탄	</option>
						<option value='PG' <?php if($view_val['ccountry_code'] == "PG") { echo "selected"; }?>>파푸아뉴기니	</option>
						<option value='PW' <?php if($view_val['ccountry_code'] == "PW") { echo "selected"; }?>>팔라우	</option>
						<option value='PE' <?php if($view_val['ccountry_code'] == "PE") { echo "selected"; }?>>페루	</option>
						<option value='PT' <?php if($view_val['ccountry_code'] == "PT") { echo "selected"; }?>>포르투갈	</option>
						<option value='FK' <?php if($view_val['ccountry_code'] == "FK") { echo "selected"; }?>>포클랜드제도	</option>
						<option value='PL' <?php if($view_val['ccountry_code'] == "PL") { echo "selected"; }?>>폴란드	</option>
						<option value='PF' <?php if($view_val['ccountry_code'] == "PF") { echo "selected"; }?>>폴리네시아(프)</option>
						<option value='PR' <?php if($view_val['ccountry_code'] == "PR") { echo "selected"; }?>>푸에르토리코	</option>
						<option value='FR' <?php if($view_val['ccountry_code'] == "FR") { echo "selected"; }?>>프랑스	</option>
						<option value='GF' <?php if($view_val['ccountry_code'] == "GF") { echo "selected"; }?>>프랑스령 기니</option>
						<option value='FJ' <?php if($view_val['ccountry_code'] == "FJ") { echo "selected"; }?>>피지	</option>
						<option value='PN' <?php if($view_val['ccountry_code'] == "PN") { echo "selected"; }?>>피트케언제도	</option>
						<option value='FI' <?php if($view_val['ccountry_code'] == "FI") { echo "selected"; }?>>핀란드	</option>
						<option value='PH' <?php if($view_val['ccountry_code'] == "PH") { echo "selected"; }?>>필리핀	</option>
						<option value='KR' <?php if($view_val['ccountry_code'] == "KR") { echo "selected"; }?>>한국	</option>
						<option value='HM' <?php if($view_val['ccountry_code'] == "HM") { echo "selected"; }?>>허드/맥도날드섬</option>
						<option value='HU' <?php if($view_val['ccountry_code'] == "HU") { echo "selected"; }?>>헝가리	</option>
						<option value='AU' <?php if($view_val['ccountry_code'] == "AU") { echo "selected"; }?>>호주	</option>
						<option value='HK' <?php if($view_val['ccountry_code'] == "HK") { echo "selected"; }?>>홍콩	</option>
						<option value='IO' <?php if($view_val['ccountry_code'] == "IO") { echo "selected"; }?>>Brit.Ind.Oc.Ter</option>
						<option value='VG' <?php if($view_val['ccountry_code'] == "VG") { echo "selected"; }?>>Brit.Virgin Is.</option>
						<option value='FO' <?php if($view_val['ccountry_code'] == "FO") { echo "selected"; }?>>Faroe Islands</option>
						<option value='TF' <?php if($view_val['ccountry_code'] == "TF") { echo "selected"; }?>>French S.Territ</option>
						<option value='UM' <?php if($view_val['ccountry_code'] == "UM") { echo "selected"; }?>>Minor Outl.Ins.</option>
                    </select></td>
                  </tr> 
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">출생년월일</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="birth_date" type="date" class="input" id="birth_date" style="float:left;" value="<?php echo $view_val['birth_date'];?>"/><!-- <img src="<?php echo $misc;?>img/btn_calendar.jpg" /> --></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">출신고교</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="highschool" type="text" class="input2" id="highschool" value="<?php echo $view_val['highschool'];?>"/></td>
                  </tr>  
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">출신대학교</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="university" type="text" class="input2" id="university" value="<?php echo $view_val['university'];?>"/></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">전공</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="specialty" type="text" class="input2" id="specialty" value="<?php echo $view_val['specialty'];?>"/></td>
                  </tr>                   
                  <!--마지막라인-->
                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->
                  
                  <tr>
                	<td>&nbsp;</td>
              	  </tr>
                  <tr>
                	<td>&nbsp;</td>
              	  </tr>
                  
                  <!--시작라인-->
                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//시작라인-->
                  <tr>
                    <td height="40" colspan="4" align="center" style="font-weight:bold; font-size:16px;">은행정보</td>
                  </tr>  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">국가코드</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><select name="bcountry_code" id="bcountry_code" class="input" style="float:left;">
						<option value='' <?php if($view_val['bcountry_code'] == "") { echo "selected"; }?>>미선택</option>
						<option value='GH' <?php if($view_val['bcountry_code'] == "GH") { echo "selected"; }?>>가나	</option>
						<option value='GH' <?php if($view_val['bcountry_code'] == "GH") { echo "selected"; }?>>가봉	</option>
						<option value='GY' <?php if($view_val['bcountry_code'] == "GY") { echo "selected"; }?>>가이아나	</option>
						<option value='GM' <?php if($view_val['bcountry_code'] == "GM") { echo "selected"; }?>>갬비아	</option>
						<option value='GT' <?php if($view_val['bcountry_code'] == "GT") { echo "selected"; }?>>과테말라	</option>
						<option value='GU' <?php if($view_val['bcountry_code'] == "GU") { echo "selected"; }?>>괌	</option>
						<option value='GP' <?php if($view_val['bcountry_code'] == "GP") { echo "selected"; }?>>구아데루프	</option>
						<option value='GD' <?php if($view_val['bcountry_code'] == "GD") { echo "selected"; }?>>그레나다	</option>
						<option value='GR' <?php if($view_val['bcountry_code'] == "GR") { echo "selected"; }?>>그리스	</option>
						<option value='GL' <?php if($view_val['bcountry_code'] == "GL") { echo "selected"; }?>>그린란드	</option>
						<option value='GN' <?php if($view_val['bcountry_code'] == "GN") { echo "selected"; }?>>기니	</option>
						<option value='GW' <?php if($view_val['bcountry_code'] == "GW") { echo "selected"; }?>>기니비사우</option>
						<option value='NA' <?php if($view_val['bcountry_code'] == "NA") { echo "selected"; }?>>나미비아	</option>
						<option value='NR' <?php if($view_val['bcountry_code'] == "NR") { echo "selected"; }?>>나우루	</option>
						<option value='NG' <?php if($view_val['bcountry_code'] == "NG") { echo "selected"; }?>>나이지리아	</option>
						<option value='AQ' <?php if($view_val['bcountry_code'] == "AQ") { echo "selected"; }?>>남극대륙	</option>
						<option value='ZA' <?php if($view_val['bcountry_code'] == "ZA") { echo "selected"; }?>>남아프리카	</option>
						<option value='AN' <?php if($view_val['bcountry_code'] == "AN") { echo "selected"; }?>>네덜란드 엔틸스</option>
						<option value='NL' <?php if($view_val['bcountry_code'] == "NL") { echo "selected"; }?>>네덜란드	</option>
						<option value='NP' <?php if($view_val['bcountry_code'] == "NP") { echo "selected"; }?>>네팔	</option>
						<option value='NO' <?php if($view_val['bcountry_code'] == "NO") { echo "selected"; }?>>노르웨이	</option>
						<option value='NF' <?php if($view_val['bcountry_code'] == "NF") { echo "selected"; }?>>노퍽군도	</option>
						<option value='NZ' <?php if($view_val['bcountry_code'] == "NZ") { echo "selected"; }?>>뉴질랜드	</option>
						<option value='NC' <?php if($view_val['bcountry_code'] == "NC") { echo "selected"; }?>>뉴캘러도니아	</option>
						<option value='NU' <?php if($view_val['bcountry_code'] == "NU") { echo "selected"; }?>>니우제도	</option>
						<option value='NE' <?php if($view_val['bcountry_code'] == "NE") { echo "selected"; }?>>니제르	</option>
						<option value='NI' <?php if($view_val['bcountry_code'] == "NI") { echo "selected"; }?>>니카라과	</option>
						<option value='TW' <?php if($view_val['bcountry_code'] == "TW") { echo "selected"; }?>>대만	</option>
						<option value='DK' <?php if($view_val['bcountry_code'] == "DK") { echo "selected"; }?>>덴마크	</option>
						<option value='DM' <?php if($view_val['bcountry_code'] == "DM") { echo "selected"; }?>>도미니카	</option>
						<option value='DO' <?php if($view_val['bcountry_code'] == "DO") { echo "selected"; }?>>도미니카공화국</option>
						<option value='DE' <?php if($view_val['bcountry_code'] == "DE") { echo "selected"; }?>>독일	</option>
						<option value='TP' <?php if($view_val['bcountry_code'] == "TP") { echo "selected"; }?>>동 티모르	</option>
						<option value='LA' <?php if($view_val['bcountry_code'] == "LA") { echo "selected"; }?>>라오스	</option>
						<option value='LR' <?php if($view_val['bcountry_code'] == "LR") { echo "selected"; }?>>라이베리아	</option>
						<option value='LV' <?php if($view_val['bcountry_code'] == "LV") { echo "selected"; }?>>라트비아	</option>
						<option value='RU' <?php if($view_val['bcountry_code'] == "RU") { echo "selected"; }?>>러시아연방	</option>
						<option value='LB' <?php if($view_val['bcountry_code'] == "LB") { echo "selected"; }?>>레바논	</option>
						<option value='LS' <?php if($view_val['bcountry_code'] == "LS") { echo "selected"; }?>>레소토	</option>
						<option value='RE' <?php if($view_val['bcountry_code'] == "RE") { echo "selected"; }?>>레유니온	</option>
						<option value='RO' <?php if($view_val['bcountry_code'] == "RO") { echo "selected"; }?>>루마니아	</option>
						<option value='LU' <?php if($view_val['bcountry_code'] == "LU") { echo "selected"; }?>>룩셈부르크	</option>
						<option value='RW' <?php if($view_val['bcountry_code'] == "RW") { echo "selected"; }?>>르완다	</option>
						<option value='LY' <?php if($view_val['bcountry_code'] == "LY") { echo "selected"; }?>>리비아	</option>
						<option value='LI' <?php if($view_val['bcountry_code'] == "LI") { echo "selected"; }?>>리이텐슈타인	</option>
						<option value='LT' <?php if($view_val['bcountry_code'] == "LT") { echo "selected"; }?>>리투아니아	</option>
						<option value='MG' <?php if($view_val['bcountry_code'] == "MG") { echo "selected"; }?>>마다가스카르	</option>
						<option value='MH' <?php if($view_val['bcountry_code'] == "MH") { echo "selected"; }?>>마샬군도	</option>
						<option value='YT' <?php if($view_val['bcountry_code'] == "YT") { echo "selected"; }?>>마요트	</option>
						<option value='MO' <?php if($view_val['bcountry_code'] == "MO") { echo "selected"; }?>>마카오	</option>
						<option value='MK' <?php if($view_val['bcountry_code'] == "MK") { echo "selected"; }?>>마케도니아	</option>
						<option value='MQ' <?php if($view_val['bcountry_code'] == "MQ") { echo "selected"; }?>>마티니끄	</option>
						<option value='MW' <?php if($view_val['bcountry_code'] == "MW") { echo "selected"; }?>>말라위	</option>
						<option value='MY' <?php if($view_val['bcountry_code'] == "MY") { echo "selected"; }?>>말레이지아	</option>
						<option value='ML' <?php if($view_val['bcountry_code'] == "ML") { echo "selected"; }?>>말리	</option>
						<option value='MT' <?php if($view_val['bcountry_code'] == "MT") { echo "selected"; }?>>말타	</option>
						<option value='MX' <?php if($view_val['bcountry_code'] == "MX") { echo "selected"; }?>>멕시코	</option>
						<option value='MC' <?php if($view_val['bcountry_code'] == "MC") { echo "selected"; }?>>모나코	</option>
						<option value='MA' <?php if($view_val['bcountry_code'] == "MA") { echo "selected"; }?>>모로코	</option>
						<option value='MU' <?php if($view_val['bcountry_code'] == "MU") { echo "selected"; }?>>모리셔스	</option>
						<option value='MR' <?php if($view_val['bcountry_code'] == "MR") { echo "selected"; }?>>모리타니아	</option>
						<option value='MZ' <?php if($view_val['bcountry_code'] == "MZ") { echo "selected"; }?>>모잠비크	</option>
						<option value='MS' <?php if($view_val['bcountry_code'] == "MS") { echo "selected"; }?>>몬트세랏	</option>
						<option value='MD' <?php if($view_val['bcountry_code'] == "MD") { echo "selected"; }?>>몰다비아	</option>
						<option value='MV' <?php if($view_val['bcountry_code'] == "MV") { echo "selected"; }?>>몰디브	</option>
						<option value='MN' <?php if($view_val['bcountry_code'] == "MN") { echo "selected"; }?>>몽고	</option>
						<option value='VI' <?php if($view_val['bcountry_code'] == "VI") { echo "selected"; }?>>미국 버진제도	</option>
						<option value='US' <?php if($view_val['bcountry_code'] == "US") { echo "selected"; }?>>미국	</option>
						<option value='MM' <?php if($view_val['bcountry_code'] == "MM") { echo "selected"; }?>>미얀마	</option>
						<option value='FM' <?php if($view_val['bcountry_code'] == "FM") { echo "selected"; }?>>미크로네시아	</option>
						<option value='VU' <?php if($view_val['bcountry_code'] == "VU") { echo "selected"; }?>>바누아투	</option>
						<option value='BH' <?php if($view_val['bcountry_code'] == "BH") { echo "selected"; }?>>바레인	</option>
						<option value='BB' <?php if($view_val['bcountry_code'] == "BB") { echo "selected"; }?>>바베이도즈	</option>
						<option value='VA' <?php if($view_val['bcountry_code'] == "VA") { echo "selected"; }?>>바티칸시	</option>
						<option value='BS' <?php if($view_val['bcountry_code'] == "BS") { echo "selected"; }?>>바하마	</option>
						<option value='WF' <?php if($view_val['bcountry_code'] == "WF") { echo "selected"; }?>>발리,푸투나	</option>
						<option value='BD' <?php if($view_val['bcountry_code'] == "BD") { echo "selected"; }?>>방글라데시	</option>
						<option value='BY' <?php if($view_val['bcountry_code'] == "BY") { echo "selected"; }?>>백러시아	</option>
						<option value='BM' <?php if($view_val['bcountry_code'] == "BM") { echo "selected"; }?>>버뮤다	</option>
						<option value='BJ' <?php if($view_val['bcountry_code'] == "BJ") { echo "selected"; }?>>베냉	</option>
						<option value='VE' <?php if($view_val['bcountry_code'] == "VE") { echo "selected"; }?>>베네수엘라	</option>
						<option value='VN' <?php if($view_val['bcountry_code'] == "VN") { echo "selected"; }?>>베트남	</option>
						<option value='BE' <?php if($view_val['bcountry_code'] == "BE") { echo "selected"; }?>>벨기에	</option>
						<option value='BZ' <?php if($view_val['bcountry_code'] == "BZ") { echo "selected"; }?>>벨리즈	</option>
						<option value='BA' <?php if($view_val['bcountry_code'] == "BA") { echo "selected"; }?>>보스니아-헤르즈</option>
						<option value='BW' <?php if($view_val['bcountry_code'] == "BW") { echo "selected"; }?>>보츠와나	</option>
						<option value='BO' <?php if($view_val['bcountry_code'] == "BO") { echo "selected"; }?>>볼리비아	</option>
						<option value='BI' <?php if($view_val['bcountry_code'] == "BI") { echo "selected"; }?>>부룬디	</option>
						<option value='BF' <?php if($view_val['bcountry_code'] == "BF") { echo "selected"; }?>>부르키나-파소</option>
						<option value='BV' <?php if($view_val['bcountry_code'] == "BV") { echo "selected"; }?>>부베군도인	</option>
						<option value='BT' <?php if($view_val['bcountry_code'] == "BT") { echo "selected"; }?>>부탄	</option>
						<option value='MP' <?php if($view_val['bcountry_code'] == "MP") { echo "selected"; }?>>북마리아나제도</option>
						<option value='KP' <?php if($view_val['bcountry_code'] == "KP") { echo "selected"; }?>>북한	</option>
						<option value='BG' <?php if($view_val['bcountry_code'] == "BG") { echo "selected"; }?>>불가리아	</option>
						<option value='BR' <?php if($view_val['bcountry_code'] == "BR") { echo "selected"; }?>>브라질	</option>
						<option value='BN' <?php if($view_val['bcountry_code'] == "BN") { echo "selected"; }?>>브루네이	</option>
						<option value='AS' <?php if($view_val['bcountry_code'] == "AS") { echo "selected"; }?>>사모아,미국	</option>
						<option value='SA' <?php if($view_val['bcountry_code'] == "SA") { echo "selected"; }?>>사우디아라비아</option>
						<option value='SM' <?php if($view_val['bcountry_code'] == "SM") { echo "selected"; }?>>산마리노	</option>
						<option value='EH' <?php if($view_val['bcountry_code'] == "EH") { echo "selected"; }?>>서부사하라	</option>
						<option value='WS' <?php if($view_val['bcountry_code'] == "WS") { echo "selected"; }?>>서사모아	</option>
						<option value='GS' <?php if($view_val['bcountry_code'] == "GS") { echo "selected"; }?>>성 샌드위치섬</option>
						<option value='KN' <?php if($view_val['bcountry_code'] == "KN") { echo "selected"; }?>>성 키츠&네비스</option>
						<option value='ST' <?php if($view_val['bcountry_code'] == "ST") { echo "selected"; }?>>성 톰,프린시프</option>
						<option value='PM' <?php if($view_val['bcountry_code'] == "PM") { echo "selected"; }?>>성 피에르,미켈</option>
						<option value='SH' <?php if($view_val['bcountry_code'] == "SH") { echo "selected"; }?>>성 헬레나	</option>
						<option value='SN' <?php if($view_val['bcountry_code'] == "SN") { echo "selected"; }?>>세네갈	</option>
						<option value='SC' <?php if($view_val['bcountry_code'] == "SC") { echo "selected"; }?>>세이셸	</option>
						<option value='LC' <?php if($view_val['bcountry_code'] == "LC") { echo "selected"; }?>>세인트루시아	</option>
						<option value='VC' <?php if($view_val['bcountry_code'] == "VC") { echo "selected"; }?>>세인트빈센트	</option>
						<option value='SO' <?php if($view_val['bcountry_code'] == "SO") { echo "selected"; }?>>소말리아	</option>
						<option value='SB' <?php if($view_val['bcountry_code'] == "SB") { echo "selected"; }?>>솔로몬군도	</option>
						<option value='SD' <?php if($view_val['bcountry_code'] == "SD") { echo "selected"; }?>>수단	</option>
						<option value='SR' <?php if($view_val['bcountry_code'] == "SR") { echo "selected"; }?>>수리남	</option>
						<option value='LK' <?php if($view_val['bcountry_code'] == "LK") { echo "selected"; }?>>스리랑카	</option>
						<option value='SJ' <?php if($view_val['bcountry_code'] == "SJ") { echo "selected"; }?>>스발바드	</option>
						<option value='SZ' <?php if($view_val['bcountry_code'] == "SZ") { echo "selected"; }?>>스와질란드	</option>
						<option value='SE' <?php if($view_val['bcountry_code'] == "SE") { echo "selected"; }?>>스웨덴	</option>
						<option value='CH' <?php if($view_val['bcountry_code'] == "CH") { echo "selected"; }?>>스위스	</option>
						<option value='ES' <?php if($view_val['bcountry_code'] == "ES") { echo "selected"; }?>>스페인	</option>
						<option value='SK' <?php if($view_val['bcountry_code'] == "SK") { echo "selected"; }?>>슬로바키아	</option>
						<option value='SI' <?php if($view_val['bcountry_code'] == "SI") { echo "selected"; }?>>슬로베니아	</option>
						<option value='SY' <?php if($view_val['bcountry_code'] == "SY") { echo "selected"; }?>>시리아	</option>
						<option value='SL' <?php if($view_val['bcountry_code'] == "SL") { echo "selected"; }?>>시에라리온	</option>
						<option value='SG' <?php if($view_val['bcountry_code'] == "SG") { echo "selected"; }?>>싱가폴	</option>
						<option value='AE' <?php if($view_val['bcountry_code'] == "AE") { echo "selected"; }?>>아랍에미리트	</option>
						<option value='AW' <?php if($view_val['bcountry_code'] == "AW") { echo "selected"; }?>>아루바	</option>
						<option value='AM' <?php if($view_val['bcountry_code'] == "AM") { echo "selected"; }?>>아르메니아	</option>
						<option value='AR' <?php if($view_val['bcountry_code'] == "AR") { echo "selected"; }?>>아르헨티나	</option>
						<option value='IS' <?php if($view_val['bcountry_code'] == "IS") { echo "selected"; }?>>아이슬란드	</option>
						<option value='HT' <?php if($view_val['bcountry_code'] == "HT") { echo "selected"; }?>>아이티	</option>
						<option value='IE' <?php if($view_val['bcountry_code'] == "IE") { echo "selected"; }?>>아일랜드	</option>
						<option value='AZ' <?php if($view_val['bcountry_code'] == "AZ") { echo "selected"; }?>>아제르바이잔	</option>
						<option value='AF' <?php if($view_val['bcountry_code'] == "AF") { echo "selected"; }?>>아프가니스탄	</option>
						<option value='AD' <?php if($view_val['bcountry_code'] == "AD") { echo "selected"; }?>>안도라	</option>
						<option value='AL' <?php if($view_val['bcountry_code'] == "AL") { echo "selected"; }?>>알바니아	</option>
						<option value='DZ' <?php if($view_val['bcountry_code'] == "DZ") { echo "selected"; }?>>알제리	</option>
						<option value='AO' <?php if($view_val['bcountry_code'] == "AO") { echo "selected"; }?>>앙골라	</option>
						<option value='AG' <?php if($view_val['bcountry_code'] == "AG") { echo "selected"; }?>>앤티가/바바드</option>
						<option value='AI' <?php if($view_val['bcountry_code'] == "AI") { echo "selected"; }?>>앵글리어	</option>
						<option value='ER' <?php if($view_val['bcountry_code'] == "ER") { echo "selected"; }?>>에리트리아	</option>
						<option value='EE' <?php if($view_val['bcountry_code'] == "EE") { echo "selected"; }?>>에스토니아	</option>
						<option value='EC' <?php if($view_val['bcountry_code'] == "EC") { echo "selected"; }?>>에콰도르	</option>
						<option value='ET' <?php if($view_val['bcountry_code'] == "ET") { echo "selected"; }?>>에티오피아	</option>
						<option value='SV' <?php if($view_val['bcountry_code'] == "SV") { echo "selected"; }?>>엘살바도르	</option>
						<option value='GB' <?php if($view_val['bcountry_code'] == "GB") { echo "selected"; }?>>영국	</option>
						<option value='YE' <?php if($view_val['bcountry_code'] == "YE") { echo "selected"; }?>>예멘	</option>
						<option value='OM' <?php if($view_val['bcountry_code'] == "OM") { echo "selected"; }?>>오만	</option>
						<option value='AT' <?php if($view_val['bcountry_code'] == "AT") { echo "selected"; }?>>오스트리아	</option>
						<option value='HN' <?php if($view_val['bcountry_code'] == "HN") { echo "selected"; }?>>온두라스	</option>
						<option value='JO' <?php if($view_val['bcountry_code'] == "JO") { echo "selected"; }?>>요르단	</option>
						<option value='UG' <?php if($view_val['bcountry_code'] == "UG") { echo "selected"; }?>>우간다	</option>
						<option value='UY' <?php if($view_val['bcountry_code'] == "UY") { echo "selected"; }?>>우루과이	</option>
						<option value='UZ' <?php if($view_val['bcountry_code'] == "UZ") { echo "selected"; }?>>우즈베키스탄	</option>
						<option value='UA' <?php if($view_val['bcountry_code'] == "UA") { echo "selected"; }?>>우크라이나	</option>
						<option value='YU' <?php if($view_val['bcountry_code'] == "YU") { echo "selected"; }?>>유고슬라비아	</option>
						<option value='IQ' <?php if($view_val['bcountry_code'] == "IQ") { echo "selected"; }?>>이라크	</option>
						<option value='IR' <?php if($view_val['bcountry_code'] == "IR") { echo "selected"; }?>>이란	</option>
						<option value='IL' <?php if($view_val['bcountry_code'] == "IL") { echo "selected"; }?>>이스라엘	</option>
						<option value='EG' <?php if($view_val['bcountry_code'] == "EG") { echo "selected"; }?>>이집트	</option>
						<option value='IT' <?php if($view_val['bcountry_code'] == "IT") { echo "selected"; }?>>이탈리아	</option>
						<option value='IN' <?php if($view_val['bcountry_code'] == "IN") { echo "selected"; }?>>인도	</option>
						<option value='ID' <?php if($view_val['bcountry_code'] == "ID") { echo "selected"; }?>>인도네시아	</option>
						<option value='JP' <?php if($view_val['bcountry_code'] == "JP") { echo "selected"; }?>>일본	</option>
						<option value='JM' <?php if($view_val['bcountry_code'] == "JM") { echo "selected"; }?>>자메이카	</option>
						<option value='ZM' <?php if($view_val['bcountry_code'] == "ZM") { echo "selected"; }?>>잠비아	</option>
						<option value='GQ' <?php if($view_val['bcountry_code'] == "GQ") { echo "selected"; }?>>적도기니공화국</option>
						<option value='GE' <?php if($view_val['bcountry_code'] == "GE") { echo "selected"; }?>>조지아	</option>
						<option value='CN' <?php if($view_val['bcountry_code'] == "CN") { echo "selected"; }?>>중국	</option>
						<option value='CF' <?php if($view_val['bcountry_code'] == "CF") { echo "selected"; }?>>중앙아프리카	</option>
						<option value='DJ' <?php if($view_val['bcountry_code'] == "DJ") { echo "selected"; }?>>지부티	</option>
						<option value='GI' <?php if($view_val['bcountry_code'] == "GI") { echo "selected"; }?>>지브롤터	</option>
						<option value='ZW' <?php if($view_val['bcountry_code'] == "ZW") { echo "selected"; }?>>짐바브웨	</option>
						<option value='TD' <?php if($view_val['bcountry_code'] == "TD") { echo "selected"; }?>>챠드	</option>
						<option value='CZ' <?php if($view_val['bcountry_code'] == "CZ") { echo "selected"; }?>>체코공화국	</option>
						<option value='CL' <?php if($view_val['bcountry_code'] == "CL") { echo "selected"; }?>>칠레	</option>
						<option value='CM' <?php if($view_val['bcountry_code'] == "CM") { echo "selected"; }?>>카메룬	</option>
						<option value='KY' <?php if($view_val['bcountry_code'] == "KY") { echo "selected"; }?>>카이만제도	</option>
						<option value='KZ' <?php if($view_val['bcountry_code'] == "KZ") { echo "selected"; }?>>카자흐	</option>
						<option value='QA' <?php if($view_val['bcountry_code'] == "QA") { echo "selected"; }?>>카타르	</option>
						<option value='CV' <?php if($view_val['bcountry_code'] == "CV") { echo "selected"; }?>>카포베르데	</option>
						<option value='KH' <?php if($view_val['bcountry_code'] == "KH") { echo "selected"; }?>>캄보디아	</option>
						<option value='CA' <?php if($view_val['bcountry_code'] == "CA") { echo "selected"; }?>>캐나다	</option>
						<option value='KE' <?php if($view_val['bcountry_code'] == "KE") { echo "selected"; }?>>케냐	</option>
						<option value='KM' <?php if($view_val['bcountry_code'] == "KM") { echo "selected"; }?>>코모로	</option>
						<option value='CR' <?php if($view_val['bcountry_code'] == "CR") { echo "selected"; }?>>코스타리카	</option>
						<option value='CC' <?php if($view_val['bcountry_code'] == "CC") { echo "selected"; }?>>코코넛아일랜드</option>
						<option value='CI' <?php if($view_val['bcountry_code'] == "CI") { echo "selected"; }?>>코트디부아르	</option>
						<option value='CO' <?php if($view_val['bcountry_code'] == "CO") { echo "selected"; }?>>콜롬비아	</option>
						<option value='CG' <?php if($view_val['bcountry_code'] == "CG") { echo "selected"; }?>>콩고	</option>
						<option value='CD' <?php if($view_val['bcountry_code'] == "CD") { echo "selected"; }?>>콩고	</option>
						<option value='CU' <?php if($view_val['bcountry_code'] == "CU") { echo "selected"; }?>>쿠바	</option>
						<option value='KW' <?php if($view_val['bcountry_code'] == "KW") { echo "selected"; }?>>쿠웨이트	</option>
						<option value='CK' <?php if($view_val['bcountry_code'] == "CK") { echo "selected"; }?>>쿡아일랜드	</option>
						<option value='HR' <?php if($view_val['bcountry_code'] == "HR") { echo "selected"; }?>>크로아티아	</option>
						<option value='CX' <?php if($view_val['bcountry_code'] == "CX") { echo "selected"; }?>>크리스마스제도</option>
						<option value='KG' <?php if($view_val['bcountry_code'] == "KG") { echo "selected"; }?>>키르기즈탄	</option>
						<option value='KI' <?php if($view_val['bcountry_code'] == "KI") { echo "selected"; }?>>키리바시	</option>
						<option value='CY' <?php if($view_val['bcountry_code'] == "CY") { echo "selected"; }?>>키프로스	</option>
						<option value='TJ' <?php if($view_val['bcountry_code'] == "TJ") { echo "selected"; }?>>타지크공화국	</option>
						<option value='TZ' <?php if($view_val['bcountry_code'] == "TZ") { echo "selected"; }?>>탄자니아	</option>
						<option value='TH' <?php if($view_val['bcountry_code'] == "TH") { echo "selected"; }?>>태국	</option>
						<option value='TC' <?php if($view_val['bcountry_code'] == "TC") { echo "selected"; }?>>터어키 카이코진</option>
						<option value='TR' <?php if($view_val['bcountry_code'] == "TR") { echo "selected"; }?>>터키	</option>
						<option value='TG' <?php if($view_val['bcountry_code'] == "TG") { echo "selected"; }?>>토고	</option>
						<option value='TK' <?php if($view_val['bcountry_code'] == "TK") { echo "selected"; }?>>토클로 제도	</option>
						<option value='TO' <?php if($view_val['bcountry_code'] == "TO") { echo "selected"; }?>>통가	</option>
						<option value='TM' <?php if($view_val['bcountry_code'] == "TM") { echo "selected"; }?>>투르크메니스탄</option>
						<option value='TV' <?php if($view_val['bcountry_code'] == "TV") { echo "selected"; }?>>투발루	</option>
						<option value='TN' <?php if($view_val['bcountry_code'] == "TN") { echo "selected"; }?>>튀니지	</option>
						<option value='TT' <?php if($view_val['bcountry_code'] == "TT") { echo "selected"; }?>>트리니닷,토바고</option>
						<option value='PA' <?php if($view_val['bcountry_code'] == "PA") { echo "selected"; }?>>파나마	</option>
						<option value='PY' <?php if($view_val['bcountry_code'] == "PY") { echo "selected"; }?>>파라과이	</option>
						<option value='PK' <?php if($view_val['bcountry_code'] == "PK") { echo "selected"; }?>>파키스탄	</option>
						<option value='PG' <?php if($view_val['bcountry_code'] == "PG") { echo "selected"; }?>>파푸아뉴기니	</option>
						<option value='PW' <?php if($view_val['bcountry_code'] == "PW") { echo "selected"; }?>>팔라우	</option>
						<option value='PE' <?php if($view_val['bcountry_code'] == "PE") { echo "selected"; }?>>페루	</option>
						<option value='PT' <?php if($view_val['bcountry_code'] == "PT") { echo "selected"; }?>>포르투갈	</option>
						<option value='FK' <?php if($view_val['bcountry_code'] == "FK") { echo "selected"; }?>>포클랜드제도	</option>
						<option value='PL' <?php if($view_val['bcountry_code'] == "PL") { echo "selected"; }?>>폴란드	</option>
						<option value='PF' <?php if($view_val['bcountry_code'] == "PF") { echo "selected"; }?>>폴리네시아(프)</option>
						<option value='PR' <?php if($view_val['bcountry_code'] == "PR") { echo "selected"; }?>>푸에르토리코	</option>
						<option value='FR' <?php if($view_val['bcountry_code'] == "FR") { echo "selected"; }?>>프랑스	</option>
						<option value='GF' <?php if($view_val['bcountry_code'] == "GF") { echo "selected"; }?>>프랑스령 기니</option>
						<option value='FJ' <?php if($view_val['bcountry_code'] == "FJ") { echo "selected"; }?>>피지	</option>
						<option value='PN' <?php if($view_val['bcountry_code'] == "PN") { echo "selected"; }?>>피트케언제도	</option>
						<option value='FI' <?php if($view_val['bcountry_code'] == "FI") { echo "selected"; }?>>핀란드	</option>
						<option value='PH' <?php if($view_val['bcountry_code'] == "PH") { echo "selected"; }?>>필리핀	</option>
						<option value='KR' <?php if($view_val['bcountry_code'] == "KR") { echo "selected"; }?>>한국	</option>
						<option value='HM' <?php if($view_val['bcountry_code'] == "HM") { echo "selected"; }?>>허드/맥도날드섬</option>
						<option value='HU' <?php if($view_val['bcountry_code'] == "HU") { echo "selected"; }?>>헝가리	</option>
						<option value='AU' <?php if($view_val['bcountry_code'] == "AU") { echo "selected"; }?>>호주	</option>
						<option value='HK' <?php if($view_val['bcountry_code'] == "HK") { echo "selected"; }?>>홍콩	</option>
						<option value='IO' <?php if($view_val['bcountry_code'] == "IO") { echo "selected"; }?>>Brit.Ind.Oc.Ter</option>
						<option value='VG' <?php if($view_val['bcountry_code'] == "VG") { echo "selected"; }?>>Brit.Virgin Is.</option>
						<option value='FO' <?php if($view_val['bcountry_code'] == "FO") { echo "selected"; }?>>Faroe Islands</option>
						<option value='TF' <?php if($view_val['bcountry_code'] == "TF") { echo "selected"; }?>>French S.Territ</option>
						<option value='UM' <?php if($view_val['bcountry_code'] == "UM") { echo "selected"; }?>>Minor Outl.Ins.</option>
                    </select></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">은행코드</td>
					<td align="left" class="t_border" style="padding-left:10px;"><select name="bank_code" id="bank_code" class="input" style="float:left;">
						<option value='' <?php if($view_val['bank_code'] == "") { echo "selected"; }?>>미선택</option>
						<option value='039' <?php if($view_val['bank_code'] == "039") { echo "selected"; }?>>경남은행</option>
						<option value='034' <?php if($view_val['bank_code'] == "034") { echo "selected"; }?>>광주은행</option>
						<option value='004' <?php if($view_val['bank_code'] == "004") { echo "selected"; }?>>국민은행</option>
						<option value='003' <?php if($view_val['bank_code'] == "003") { echo "selected"; }?>>기업은행</option>
						<option value='011' <?php if($view_val['bank_code'] == "011") { echo "selected"; }?>>농협</option>
						<option value='012' <?php if($view_val['bank_code'] == "012") { echo "selected"; }?>>단위농협</option>
						<option value='031' <?php if($view_val['bank_code'] == "031") { echo "selected"; }?>>대구은행</option>
						<option value='055' <?php if($view_val['bank_code'] == "055") { echo "selected"; }?>>도이</option>
						<option value='059' <?php if($view_val['bank_code'] == "059") { echo "selected"; }?>>도쿄</option>
						<option value='058' <?php if($view_val['bank_code'] == "058") { echo "selected"; }?>>미즈</option>
						<option value='032' <?php if($view_val['bank_code'] == "032") { echo "selected"; }?>>부산은행</option>
						<option value='002' <?php if($view_val['bank_code'] == "002") { echo "selected"; }?>>산업은행</option>
						<option value='050' <?php if($view_val['bank_code'] == "050") { echo "selected"; }?>>상호신용금고</option>
						<option value='045' <?php if($view_val['bank_code'] == "045") { echo "selected"; }?>>새마을금고</option>
						<option value='007' <?php if($view_val['bank_code'] == "007") { echo "selected"; }?>>수협</option>
						<option value='053' <?php if($view_val['bank_code'] == "053") { echo "selected"; }?>>시티은행</option>
						<option value='026' <?php if($view_val['bank_code'] == "026") { echo "selected"; }?>>신한은행</option>
						<option value='048' <?php if($view_val['bank_code'] == "048") { echo "selected"; }?>>신협</option>
						<option value='056' <?php if($view_val['bank_code'] == "056") { echo "selected"; }?>>암로</option>
						<option value='005' <?php if($view_val['bank_code'] == "005") { echo "selected"; }?>>외환은행</option>
						<option value='020' <?php if($view_val['bank_code'] == "020") { echo "selected"; }?>>우리은행</option>
						<option value='071' <?php if($view_val['bank_code'] == "071") { echo "selected"; }?>>우체국</option>
						<option value='037' <?php if($view_val['bank_code'] == "037") { echo "selected"; }?>>전북은행</option>
						<option value='023' <?php if($view_val['bank_code'] == "023") { echo "selected"; }?>>제일은행</option>
						<option value='035' <?php if($view_val['bank_code'] == "035") { echo "selected"; }?>>제주은행</option>
						<option value='021' <?php if($view_val['bank_code'] == "021") { echo "selected"; }?>>조흥은행</option>
						<option value='081' <?php if($view_val['bank_code'] == "081") { echo "selected"; }?>>하나은행</option>
						<option value='027' <?php if($view_val['bank_code'] == "027") { echo "selected"; }?>>한미은행</option>
						<option value='017' <?php if($view_val['bank_code'] == "017") { echo "selected"; }?>>합병된은행(사용안함)</option>
						<option value='054' <?php if($view_val['bank_code'] == "054") { echo "selected"; }?>>홍콩</option>
						<option value='057' <?php if($view_val['bank_code'] == "057") { echo "selected"; }?>>UF</option>
                    </select></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">계좌번호</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="bnum" type="text" class="input" id="bnum" value="<?php echo $view_val['bnum'];?>" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <?php if($view_val['bnumfile_changename']) {?><a href="<?php echo site_url();?>/customer/customer_download2/<?php echo $seq;?>/<?php echo $view_val['bnumfile_changename'];?>"><?php echo $view_val['bnumfile_realname'];?></a><?php } else {?>파일없음<?php }?> <input type="file" name="bnum_file" id="bnum_file"></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">예금주</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="deposit_name" type="text" class="input" id="deposit_name" value="<?php echo $view_val['deposit_name'];?>"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">결제계좌 신고업체</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><select name="payment_account" id="payment_account" class="input" style="float:left;">
                      <option value="001" <?php if($view_val['payment_account'] == "001") { echo "selected"; }?>>No</option>
                      <option value="002" <?php if($view_val['payment_account'] == "002") { echo "selected"; }?>>Yes</option>
                    </select></td>
                  </tr>  
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">과세구분</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><select name="tax_part" id="tax_part" class="input" style="float:left;">
	        		  <option value="001" <?php if($view_val['tax_part'] == "001") { echo "selected"; }?>>과세</option>
                      <option value="002" <?php if($view_val['tax_part'] == "002") { echo "selected"; }?>>면세</option>
					  <option value="003" <?php if($view_val['tax_part'] == "003") { echo "selected"; }?>>영세</option>
                    </select></td>
                  </tr>  
                  
                  <!--마지막라인-->
                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->
                </table></td>
              </tr>
              <!--//작성-->
              
              <tr>
                <td height="10"></td>
              </tr>
              <!--버튼-->
               <tr>
                <td align="right"><input type="image" src="<?php echo $misc;?>img/btn_b_next.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;"/> <img src="<?php echo $misc;?>img/btn_b_prev.jpg" width="64" height="31" style="cursor:pointer" border="0" onclick="javascript:history.go(-1)"/></td>
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