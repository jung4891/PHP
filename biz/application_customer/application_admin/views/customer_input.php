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
	if (mform.company_post.value == "") {
		mform.company_post.focus();
		alert("주소를 선택해 주세요.");
		return false;
	}
	if (mform.company_addr1.value == "") {
		mform.company_addr1.focus();
		alert("주소를 선택해 주세요.");
		return false;
	}
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
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_1_on.jpg" /></li>
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_2.jpg" /></li>
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_3.jpg" /></li>
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_4.jpg" /></li>
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_5.jpg" /></li>
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_6.jpg" /></li>
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
                      <option value="001">전체</option>
                      <option value="002">매입</option>
					  <option value="003">매출</option>
					  <option value="004">협력사</option>
                    </select> <span style="color:#999; font-size:10px;"></span></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">기업형태</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><select name="company_form" id="company_form" class="input">
					  <option value="">미선택</option>
					  <option value="001">대기업</option>
                      <option value="002" selected>중소기업</option>
					  <option value="003">개인</option>
                      <option value="004">외자기업</option>
                    </select> <span style="color:#999; font-size:10px;">※중소기업대상:상시고용 근무 종업원수가300인 미만 또는 자본금 80억 미만이 해당됩니다.</span></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*회사명</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="company_name" type="text" class="input2" id="company_name"/></td>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">법인번호</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="rnum" type="text" class="input2" id="rnum" onclick="checkNum(this);" onKeyUp="checkNum(this);"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*사업자번호('-'빼고 입력)</td>
                     <td align="left" class="t_border" style="padding-left:10px;"><input name="cnum" type="text" class="input" id="cnum" onclick="checkNum(this);" onKeyUp="checkNum(this);" maxlength="10"/> <input type="file" name="cnum_file" id="cnum_file"></td>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">구매거래 통화</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><select name="perchase_part" id="perchase_part" class="input">
                      <option value="001">유럽 유로</option>
                      <option value="002">일본 엔화</option>
					  <option value="003" selected>한국 원화</option>
                      <option value="004">중국 위안</option>
					  <option value="005">미국 달러</option>
                    </select></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*대표자 성명</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><input name="represent_name" type="text" class="input" id="represent_name"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">업태</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="company_category" type="text" class="input" id="company_category"/> <span style="color:#999; font-size:10px;">사업자등록기준</span></td>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">업종</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="company_sector" type="text" class="input" id="company_sector"/> <span style="color:#999; font-size:10px;">사업자등록기준</span></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">설립일자</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="establish_date" type="date" class="input" id="establish_date" style="float:left;" />
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">진입사유</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="entry_reason" id="entry_reason" type="radio" value="N" checked="checked" style=" float:left;" /> <span style=" display:block; float:left; line-height:18px; padding:0 5px;">신규</span> <input name="entry_reason" type="radio" id="entry_reason" value="R" checked="checked" style="float:left;" /> <span style=" display:block; float:left; line-height:18px; padding:0 5px;">추천</span></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">당사추천인정보</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><input name="recommand_name" type="text" class="input" id="recommand_name"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">사업자등록증</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;">
                    <input name="cnum_flag" type="radio" value="Y" checked style=" float:left;" /> <span style=" display:block; float:left; line-height:18px; padding:0 5px;">(유)</span> <select name="cnum_part1" id="cnum_part1" class="input" style="float:left; margin-right:10px;">
                      <option value="001">국내(법인-일반)</option>
                      <option value="002">국내(개인)</option>
                    </select>
					<input name="cnum_flag" type="radio" value="N" style="float:left;" /> <span style=" display:block; float:left; line-height:18px; padding:0 5px;">(무)</span> <select name="cnum_part2" id="cnum_part2" class="input" style="float:left;">
                      <option value="003">해외(법인)</option>
                      <option value="004">국내(개인)</option>
					  <option value="005">해외(개인)</option>
                    </select></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*주소</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;">
                    <span style="display:block; line-height:35px;"><input name="company_post" type="text" class="input" id="company_post" readonly/> <input type="button" value="우편번호" class="button" onclick="javascript:openDaumPostcode();" style="cursor:pointer;"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="company_addr1" type="text" class="input2" id="company_addr1" readonly/></span>
                    <span style="display:block; line-height:35px; height:30px;"><input name="company_addr2" type="text" class="input6" id="company_addr2"/></span>
                    </td>
                  </tr> 
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">우편물수령 주소</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;">
                    <span style="display:block; line-height:35px;"><input name="post_post" type="text" class="input" id="post_post" readonly/> <input type="button" value="우편번호" class="button" onclick="javascript:openDaumPostcode2();" style="cursor:pointer;"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="post_addr1" type="text" class="input2" id="post_addr1" readonly/></span>
                    <span style="display:block; line-height:35px; height:30px; float:left;"><input name="post_addr2" type="text" class="input6" id="post_addr2"/></span> <input name="ckbox" type="checkbox" id="ckbox" onclick="javascript:ckbox_check();"value="위와 동일" style="float:left; padding:5px 0 0 10px;" /> <span style=" display:block; float:left; line-height:22px; padding:0 5px;">위와동일</span>
                    </td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*회사대표전화</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><input name="represent_tel" type="text" class="input" id="represent_tel" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#999; font-size:10px;">예) 020000000</span></td>
                  </tr> 
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">대표자 이동전화</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="represent_handphone" type="text" class="input" id="represent_handphone" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#999; font-size:10px;">예) 01000000000</span></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">*대표 FAX번호</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="represent_fax" type="text" class="input" id="represent_fax" onclick="checkNum(this);" onKeyUp="checkNum(this);"/></td>
                  </tr> 
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">대표 E-mail</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><input name="represent_email" type="text" class="input" id="represent_email"/></td>
                  </tr>     
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">지역코드</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><select name="local_code" id="local_code" class="input" style="float:left;">
                      <option value="001">제주도</option>
                      <option value="002">전라북도</option>
					  <option value="003">전라남도</option>
                      <option value="004">충청북도</option>
					  <option value="005">충청남도</option>
                      <option value="006">인천광역시</option>
					  <option value="007">강원도</option>
                      <option value="008">광주광역시</option>
					  <option value="009">경기도</option>
                      <option value="010">경상북도</option>
					  <option value="011">경상남도</option>
                      <option value="012">부산광역시</option>
					  <option value="013" selected>서울특별시</option>
					  <option value="014">대구광역시</option>
					  <option value="015">대전광역시</option>
					  <option value="016">울산광역시</option>
                    </select></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">국가코드</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><select name="ccountry_code" id="ccountry_code" class="input" style="float:left;">
						<option value='GH' >가나	</option>
						<option value='GA' >가봉	</option>
						<option value='GY' >가이아나	</option>
						<option value='GM' >갬비아	</option>
						<option value='GT' >과테말라	</option>
						<option value='GU' >괌	</option>
						<option value='GP' >구아데루프	</option>
						<option value='GD' >그레나다	</option>
						<option value='GR' >그리스	</option>
						<option value='GL' >그린란드	</option>
						<option value='GN' >기니	</option>
						<option value='GW' >기니비사우</option>
						<option value='NA' >나미비아	</option>
						<option value='NR' >나우루	</option>
						<option value='NG' >나이지리아	</option>
						<option value='AQ' >남극대륙	</option>
						<option value='ZA' >남아프리카	</option>
						<option value='AN' >네덜란드 엔틸스</option>
						<option value='NL' >네덜란드	</option>
						<option value='NP' >네팔	</option>
						<option value='NO' >노르웨이	</option>
						<option value='NF' >노퍽군도	</option>
						<option value='NZ' >뉴질랜드	</option>
						<option value='NC' >뉴캘러도니아	</option>
						<option value='NU' >니우제도	</option>
						<option value='NE' >니제르	</option>
						<option value='NI' >니카라과	</option>
						<option value='TW' >대만	</option>
						<option value='DK' >덴마크	</option>
						<option value='DM' >도미니카	</option>
						<option value='DO' >도미니카공화국</option>
						<option value='DE' >독일	</option>
						<option value='TP' >동 티모르	</option>
						<option value='LA' >라오스	</option>
						<option value='LR' >라이베리아	</option>
						<option value='LV' >라트비아	</option>
						<option value='RU' >러시아연방	</option>
						<option value='LB' >레바논	</option>
						<option value='LS' >레소토	</option>
						<option value='RE' >레유니온	</option>
						<option value='RO' >루마니아	</option>
						<option value='LU' >룩셈부르크	</option>
						<option value='RW' >르완다	</option>
						<option value='LY' >리비아	</option>
						<option value='LI' >리이텐슈타인	</option>
						<option value='LT' >리투아니아	</option>
						<option value='MG' >마다가스카르	</option>
						<option value='MH' >마샬군도	</option>
						<option value='YT' >마요트	</option>
						<option value='MO' >마카오	</option>
						<option value='MK' >마케도니아	</option>
						<option value='MQ' >마티니끄	</option>
						<option value='MW' >말라위	</option>
						<option value='MY' >말레이지아	</option>
						<option value='ML' >말리	</option>
						<option value='MT' >말타	</option>
						<option value='MX' >멕시코	</option>
						<option value='MC' >모나코	</option>
						<option value='MA' >모로코	</option>
						<option value='MU' >모리셔스	</option>
						<option value='MR' >모리타니아	</option>
						<option value='MZ' >모잠비크	</option>
						<option value='MS' >몬트세랏	</option>
						<option value='MD' >몰다비아	</option>
						<option value='MV' >몰디브	</option>
						<option value='MN' >몽고	</option>
						<option value='VI' >미국 버진제도	</option>
						<option value='US' >미국	</option>
						<option value='MM' >미얀마	</option>
						<option value='FM' >미크로네시아	</option>
						<option value='VU' >바누아투	</option>
						<option value='BH' >바레인	</option>
						<option value='BB' >바베이도즈	</option>
						<option value='VA' >바티칸시	</option>
						<option value='BS' >바하마	</option>
						<option value='WF' >발리,푸투나	</option>
						<option value='BD' >방글라데시	</option>
						<option value='BY' >백러시아	</option>
						<option value='BM' >버뮤다	</option>
						<option value='BJ' >베냉	</option>
						<option value='VE' >베네수엘라	</option>
						<option value='VN' >베트남	</option>
						<option value='BE' >벨기에	</option>
						<option value='BZ' >벨리즈	</option>
						<option value='BA' >보스니아-헤르즈</option>
						<option value='BW' >보츠와나	</option>
						<option value='BO' >볼리비아	</option>
						<option value='BI' >부룬디	</option>
						<option value='BF' >부르키나-파소</option>
						<option value='BV' >부베군도인	</option>
						<option value='BT' >부탄	</option>
						<option value='MP' >북마리아나제도</option>
						<option value='KP' >북한	</option>
						<option value='BG' >불가리아	</option>
						<option value='BR' >브라질	</option>
						<option value='BN' >브루네이	</option>
						<option value='AS' >사모아,미국	</option>
						<option value='SA' >사우디아라비아</option>
						<option value='SM' >산마리노	</option>
						<option value='EH' >서부사하라	</option>
						<option value='WS' >서사모아	</option>
						<option value='GS' >성 샌드위치섬</option>
						<option value='KN' >성 키츠&네비스</option>
						<option value='ST' >성 톰,프린시프</option>
						<option value='PM' >성 피에르,미켈</option>
						<option value='SH' >성 헬레나	</option>
						<option value='SN' >세네갈	</option>
						<option value='SC' >세이셸	</option>
						<option value='LC' >세인트루시아	</option>
						<option value='VC' >세인트빈센트	</option>
						<option value='SO' >소말리아	</option>
						<option value='SB' >솔로몬군도	</option>
						<option value='SD' >수단	</option>
						<option value='SR' >수리남	</option>
						<option value='LK' >스리랑카	</option>
						<option value='SJ' >스발바드	</option>
						<option value='SZ' >스와질란드	</option>
						<option value='SE' >스웨덴	</option>
						<option value='CH' >스위스	</option>
						<option value='ES' >스페인	</option>
						<option value='SK' >슬로바키아	</option>
						<option value='SI' >슬로베니아	</option>
						<option value='SY' >시리아	</option>
						<option value='SL' >시에라리온	</option>
						<option value='SG' >싱가폴	</option>
						<option value='AE' >아랍에미리트	</option>
						<option value='AW' >아루바	</option>
						<option value='AM' >아르메니아	</option>
						<option value='AR' >아르헨티나	</option>
						<option value='IS' >아이슬란드	</option>
						<option value='HT' >아이티	</option>
						<option value='IE' >아일랜드	</option>
						<option value='AZ' >아제르바이잔	</option>
						<option value='AF' >아프가니스탄	</option>
						<option value='AD' >안도라	</option>
						<option value='AL' >알바니아	</option>
						<option value='DZ' >알제리	</option>
						<option value='AO' >앙골라	</option>
						<option value='AG' >앤티가/바바드</option>
						<option value='AI' >앵글리어	</option>
						<option value='ER' >에리트리아	</option>
						<option value='EE' >에스토니아	</option>
						<option value='EC' >에콰도르	</option>
						<option value='ET' >에티오피아	</option>
						<option value='SV' >엘살바도르	</option>
						<option value='GB' >영국	</option>
						<option value='YE' >예멘	</option>
						<option value='OM' >오만	</option>
						<option value='AT' >오스트리아	</option>
						<option value='HN' >온두라스	</option>
						<option value='JO' >요르단	</option>
						<option value='UG' >우간다	</option>
						<option value='UY' >우루과이	</option>
						<option value='UZ' >우즈베키스탄	</option>
						<option value='UA' >우크라이나	</option>
						<option value='YU' >유고슬라비아	</option>
						<option value='IQ' >이라크	</option>
						<option value='IR' >이란	</option>
						<option value='IL' >이스라엘	</option>
						<option value='EG' >이집트	</option>
						<option value='IT' >이탈리아	</option>
						<option value='IN' >인도	</option>
						<option value='ID' >인도네시아	</option>
						<option value='JP' >일본	</option>
						<option value='JM' >자메이카	</option>
						<option value='ZM' >잠비아	</option>
						<option value='GQ' >적도기니공화국</option>
						<option value='GE' >조지아	</option>
						<option value='CN' >중국	</option>
						<option value='CF' >중앙아프리카	</option>
						<option value='DJ' >지부티	</option>
						<option value='GI' >지브롤터	</option>
						<option value='ZW' >짐바브웨	</option>
						<option value='TD' >챠드	</option>
						<option value='CZ' >체코공화국	</option>
						<option value='CL' >칠레	</option>
						<option value='CM' >카메룬	</option>
						<option value='KY' >카이만제도	</option>
						<option value='KZ' >카자흐	</option>
						<option value='QA' >카타르	</option>
						<option value='CV' >카포베르데	</option>
						<option value='KH' >캄보디아	</option>
						<option value='CA' >캐나다	</option>
						<option value='KE' >케냐	</option>
						<option value='KM' >코모로	</option>
						<option value='CR' >코스타리카	</option>
						<option value='CC' >코코넛아일랜드</option>
						<option value='CI' >코트디부아르	</option>
						<option value='CO' >콜롬비아	</option>
						<option value='CG' >콩고	</option>
						<option value='CD' >콩고	</option>
						<option value='CU' >쿠바	</option>
						<option value='KW' >쿠웨이트	</option>
						<option value='CK' >쿡아일랜드	</option>
						<option value='HR' >크로아티아	</option>
						<option value='CX' >크리스마스제도</option>
						<option value='KG' >키르기즈탄	</option>
						<option value='KI' >키리바시	</option>
						<option value='CY' >키프로스	</option>
						<option value='TJ' >타지크공화국	</option>
						<option value='TZ' >탄자니아	</option>
						<option value='TH' >태국	</option>
						<option value='TC' >터어키 카이코진</option>
						<option value='TR' >터키	</option>
						<option value='TG' >토고	</option>
						<option value='TK' >토클로 제도	</option>
						<option value='TO' >통가	</option>
						<option value='TM' >투르크메니스탄</option>
						<option value='TV' >투발루	</option>
						<option value='TN' >튀니지	</option>
						<option value='TT' >트리니닷,토바고</option>
						<option value='PA' >파나마	</option>
						<option value='PY' >파라과이	</option>
						<option value='PK' >파키스탄	</option>
						<option value='PG' >파푸아뉴기니	</option>
						<option value='PW' >팔라우	</option>
						<option value='PE' >페루	</option>
						<option value='PT' >포르투갈	</option>
						<option value='FK' >포클랜드제도	</option>
						<option value='PL' >폴란드	</option>
						<option value='PF' >폴리네시아(프)</option>
						<option value='PR' >푸에르토리코	</option>
						<option value='FR' >프랑스	</option>
						<option value='GF' >프랑스령 기니</option>
						<option value='FJ' >피지	</option>
						<option value='PN' >피트케언제도	</option>
						<option value='FI' >핀란드	</option>
						<option value='PH' >필리핀	</option>
						<option value='KR' selected>한국	</option>
						<option value='HM' >허드/맥도날드섬</option>
						<option value='HU' >헝가리	</option>
						<option value='AU' >호주	</option>
						<option value='HK' >홍콩	</option>
						<option value='IO' >Brit.Ind.Oc.Ter</option>
						<option value='VG' >Brit.Virgin Is.</option>
						<option value='FO' >Faroe Islands</option>
						<option value='TF' >French S.Territ</option>
						<option value='UM' >Minor Outl.Ins.</option>
                    </select></td>
                  </tr> 
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">출생년월일</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="birth_date" type="date" class="input" id="birth_date" style="float:left;" /><!-- <img src="<?php echo $misc;?>img/btn_calendar.jpg" /> --></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">출신고교</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="highschool" type="text" class="input2" id="highschool"/></td>
                  </tr>  
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">출신대학교</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="university" type="text" class="input2" id="university"/></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">전공</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="specialty" type="text" class="input2" id="specialty"/></td>
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
						<option value='GH' >가나	</option>
						<option value='GA' >가봉	</option>
						<option value='GY' >가이아나	</option>
						<option value='GM' >갬비아	</option>
						<option value='GT' >과테말라	</option>
						<option value='GU' >괌	</option>
						<option value='GP' >구아데루프	</option>
						<option value='GD' >그레나다	</option>
						<option value='GR' >그리스	</option>
						<option value='GL' >그린란드	</option>
						<option value='GN' >기니	</option>
						<option value='GW' >기니비사우</option>
						<option value='NA' >나미비아	</option>
						<option value='NR' >나우루	</option>
						<option value='NG' >나이지리아	</option>
						<option value='AQ' >남극대륙	</option>
						<option value='ZA' >남아프리카	</option>
						<option value='AN' >네덜란드 엔틸스</option>
						<option value='NL' >네덜란드	</option>
						<option value='NP' >네팔	</option>
						<option value='NO' >노르웨이	</option>
						<option value='NF' >노퍽군도	</option>
						<option value='NZ' >뉴질랜드	</option>
						<option value='NC' >뉴캘러도니아	</option>
						<option value='NU' >니우제도	</option>
						<option value='NE' >니제르	</option>
						<option value='NI' >니카라과	</option>
						<option value='TW' >대만	</option>
						<option value='DK' >덴마크	</option>
						<option value='DM' >도미니카	</option>
						<option value='DO' >도미니카공화국</option>
						<option value='DE' >독일	</option>
						<option value='TP' >동 티모르	</option>
						<option value='LA' >라오스	</option>
						<option value='LR' >라이베리아	</option>
						<option value='LV' >라트비아	</option>
						<option value='RU' >러시아연방	</option>
						<option value='LB' >레바논	</option>
						<option value='LS' >레소토	</option>
						<option value='RE' >레유니온	</option>
						<option value='RO' >루마니아	</option>
						<option value='LU' >룩셈부르크	</option>
						<option value='RW' >르완다	</option>
						<option value='LY' >리비아	</option>
						<option value='LI' >리이텐슈타인	</option>
						<option value='LT' >리투아니아	</option>
						<option value='MG' >마다가스카르	</option>
						<option value='MH' >마샬군도	</option>
						<option value='YT' >마요트	</option>
						<option value='MO' >마카오	</option>
						<option value='MK' >마케도니아	</option>
						<option value='MQ' >마티니끄	</option>
						<option value='MW' >말라위	</option>
						<option value='MY' >말레이지아	</option>
						<option value='ML' >말리	</option>
						<option value='MT' >말타	</option>
						<option value='MX' >멕시코	</option>
						<option value='MC' >모나코	</option>
						<option value='MA' >모로코	</option>
						<option value='MU' >모리셔스	</option>
						<option value='MR' >모리타니아	</option>
						<option value='MZ' >모잠비크	</option>
						<option value='MS' >몬트세랏	</option>
						<option value='MD' >몰다비아	</option>
						<option value='MV' >몰디브	</option>
						<option value='MN' >몽고	</option>
						<option value='VI' >미국 버진제도	</option>
						<option value='US' >미국	</option>
						<option value='MM' >미얀마	</option>
						<option value='FM' >미크로네시아	</option>
						<option value='VU' >바누아투	</option>
						<option value='BH' >바레인	</option>
						<option value='BB' >바베이도즈	</option>
						<option value='VA' >바티칸시	</option>
						<option value='BS' >바하마	</option>
						<option value='WF' >발리,푸투나	</option>
						<option value='BD' >방글라데시	</option>
						<option value='BY' >백러시아	</option>
						<option value='BM' >버뮤다	</option>
						<option value='BJ' >베냉	</option>
						<option value='VE' >베네수엘라	</option>
						<option value='VN' >베트남	</option>
						<option value='BE' >벨기에	</option>
						<option value='BZ' >벨리즈	</option>
						<option value='BA' >보스니아-헤르즈</option>
						<option value='BW' >보츠와나	</option>
						<option value='BO' >볼리비아	</option>
						<option value='BI' >부룬디	</option>
						<option value='BF' >부르키나-파소</option>
						<option value='BV' >부베군도인	</option>
						<option value='BT' >부탄	</option>
						<option value='MP' >북마리아나제도</option>
						<option value='KP' >북한	</option>
						<option value='BG' >불가리아	</option>
						<option value='BR' >브라질	</option>
						<option value='BN' >브루네이	</option>
						<option value='AS' >사모아,미국	</option>
						<option value='SA' >사우디아라비아</option>
						<option value='SM' >산마리노	</option>
						<option value='EH' >서부사하라	</option>
						<option value='WS' >서사모아	</option>
						<option value='GS' >성 샌드위치섬</option>
						<option value='KN' >성 키츠&네비스</option>
						<option value='ST' >성 톰,프린시프</option>
						<option value='PM' >성 피에르,미켈</option>
						<option value='SH' >성 헬레나	</option>
						<option value='SN' >세네갈	</option>
						<option value='SC' >세이셸	</option>
						<option value='LC' >세인트루시아	</option>
						<option value='VC' >세인트빈센트	</option>
						<option value='SO' >소말리아	</option>
						<option value='SB' >솔로몬군도	</option>
						<option value='SD' >수단	</option>
						<option value='SR' >수리남	</option>
						<option value='LK' >스리랑카	</option>
						<option value='SJ' >스발바드	</option>
						<option value='SZ' >스와질란드	</option>
						<option value='SE' >스웨덴	</option>
						<option value='CH' >스위스	</option>
						<option value='ES' >스페인	</option>
						<option value='SK' >슬로바키아	</option>
						<option value='SI' >슬로베니아	</option>
						<option value='SY' >시리아	</option>
						<option value='SL' >시에라리온	</option>
						<option value='SG' >싱가폴	</option>
						<option value='AE' >아랍에미리트	</option>
						<option value='AW' >아루바	</option>
						<option value='AM' >아르메니아	</option>
						<option value='AR' >아르헨티나	</option>
						<option value='IS' >아이슬란드	</option>
						<option value='HT' >아이티	</option>
						<option value='IE' >아일랜드	</option>
						<option value='AZ' >아제르바이잔	</option>
						<option value='AF' >아프가니스탄	</option>
						<option value='AD' >안도라	</option>
						<option value='AL' >알바니아	</option>
						<option value='DZ' >알제리	</option>
						<option value='AO' >앙골라	</option>
						<option value='AG' >앤티가/바바드</option>
						<option value='AI' >앵글리어	</option>
						<option value='ER' >에리트리아	</option>
						<option value='EE' >에스토니아	</option>
						<option value='EC' >에콰도르	</option>
						<option value='ET' >에티오피아	</option>
						<option value='SV' >엘살바도르	</option>
						<option value='GB' >영국	</option>
						<option value='YE' >예멘	</option>
						<option value='OM' >오만	</option>
						<option value='AT' >오스트리아	</option>
						<option value='HN' >온두라스	</option>
						<option value='JO' >요르단	</option>
						<option value='UG' >우간다	</option>
						<option value='UY' >우루과이	</option>
						<option value='UZ' >우즈베키스탄	</option>
						<option value='UA' >우크라이나	</option>
						<option value='YU' >유고슬라비아	</option>
						<option value='IQ' >이라크	</option>
						<option value='IR' >이란	</option>
						<option value='IL' >이스라엘	</option>
						<option value='EG' >이집트	</option>
						<option value='IT' >이탈리아	</option>
						<option value='IN' >인도	</option>
						<option value='ID' >인도네시아	</option>
						<option value='JP' >일본	</option>
						<option value='JM' >자메이카	</option>
						<option value='ZM' >잠비아	</option>
						<option value='GQ' >적도기니공화국</option>
						<option value='GE' >조지아	</option>
						<option value='CN' >중국	</option>
						<option value='CF' >중앙아프리카	</option>
						<option value='DJ' >지부티	</option>
						<option value='GI' >지브롤터	</option>
						<option value='ZW' >짐바브웨	</option>
						<option value='TD' >챠드	</option>
						<option value='CZ' >체코공화국	</option>
						<option value='CL' >칠레	</option>
						<option value='CM' >카메룬	</option>
						<option value='KY' >카이만제도	</option>
						<option value='KZ' >카자흐	</option>
						<option value='QA' >카타르	</option>
						<option value='CV' >카포베르데	</option>
						<option value='KH' >캄보디아	</option>
						<option value='CA' >캐나다	</option>
						<option value='KE' >케냐	</option>
						<option value='KM' >코모로	</option>
						<option value='CR' >코스타리카	</option>
						<option value='CC' >코코넛아일랜드</option>
						<option value='CI' >코트디부아르	</option>
						<option value='CO' >콜롬비아	</option>
						<option value='CG' >콩고	</option>
						<option value='CD' >콩고	</option>
						<option value='CU' >쿠바	</option>
						<option value='KW' >쿠웨이트	</option>
						<option value='CK' >쿡아일랜드	</option>
						<option value='HR' >크로아티아	</option>
						<option value='CX' >크리스마스제도</option>
						<option value='KG' >키르기즈탄	</option>
						<option value='KI' >키리바시	</option>
						<option value='CY' >키프로스	</option>
						<option value='TJ' >타지크공화국	</option>
						<option value='TZ' >탄자니아	</option>
						<option value='TH' >태국	</option>
						<option value='TC' >터어키 카이코진</option>
						<option value='TR' >터키	</option>
						<option value='TG' >토고	</option>
						<option value='TK' >토클로 제도	</option>
						<option value='TO' >통가	</option>
						<option value='TM' >투르크메니스탄</option>
						<option value='TV' >투발루	</option>
						<option value='TN' >튀니지	</option>
						<option value='TT' >트리니닷,토바고</option>
						<option value='PA' >파나마	</option>
						<option value='PY' >파라과이	</option>
						<option value='PK' >파키스탄	</option>
						<option value='PG' >파푸아뉴기니	</option>
						<option value='PW' >팔라우	</option>
						<option value='PE' >페루	</option>
						<option value='PT' >포르투갈	</option>
						<option value='FK' >포클랜드제도	</option>
						<option value='PL' >폴란드	</option>
						<option value='PF' >폴리네시아(프)</option>
						<option value='PR' >푸에르토리코	</option>
						<option value='FR' >프랑스	</option>
						<option value='GF' >프랑스령 기니</option>
						<option value='FJ' >피지	</option>
						<option value='PN' >피트케언제도	</option>
						<option value='FI' >핀란드	</option>
						<option value='PH' >필리핀	</option>
						<option value='KR' selected>한국	</option>
						<option value='HM' >허드/맥도날드섬</option>
						<option value='HU' >헝가리	</option>
						<option value='AU' >호주	</option>
						<option value='HK' >홍콩	</option>
						<option value='IO' >Brit.Ind.Oc.Ter</option>
						<option value='VG' >Brit.Virgin Is.</option>
						<option value='FO' >Faroe Islands</option>
						<option value='TF' >French S.Territ</option>
						<option value='UM' >Minor Outl.Ins.</option>
                    </select></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">은행코드</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><select name="bank_code" id="bank_code" class="input" style="float:left;">
						<option value='' >미선택</option>
						<option value='039' >경남은행</option>
						<option value='034' >광주은행</option>
						<option value='004' >국민은행</option>
						<option value='003' >기업은행</option>
						<option value='011' >농협</option>
						<option value='012' >단위농협</option>
						<option value='031' >대구은행</option>
						<option value='055' >도이</option>
						<option value='059' >도쿄</option>
						<option value='058' >미즈</option>
						<option value='032' >부산은행</option>
						<option value='002' >산업은행</option>
						<option value='050' >상호신용금고</option>
						<option value='045' >새마을금고</option>
						<option value='007' >수협</option>
						<option value='053' >시티은행</option>
						<option value='026' >신한은행</option>
						<option value='048' >신협</option>
						<option value='056' >암로</option>
						<option value='005' >외환은행</option>
						<option value='020' selected>우리은행</option>
						<option value='071' >우체국</option>
						<option value='037' >전북은행</option>
						<option value='023' >제일은행</option>
						<option value='035' >제주은행</option>
						<option value='021' >조흥은행</option>
						<option value='081' >하나은행</option>
						<option value='027' >한미은행</option>
						<option value='017' >합병된은행(사용안함)</option>
						<option value='054' >홍콩</option>
						<option value='057' >UF</option>
                    </select></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">계좌번호</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="bnum" type="text" class="input" id="bnum" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <input type="file" name="bnum_file" id="bnum_file"></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">예금주</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="deposit_name" type="text" class="input" id="deposit_name"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">결제계좌 신고업체</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><select name="payment_account" id="payment_account" class="input" style="float:left;">
                      <option value="001">No</option>
                      <option value="002">Yes</option>
                    </select></td>
                  </tr>  
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">과세구분</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><select name="tax_part" id="tax_part" class="input" style="float:left;">
                      <option value="001">과세</option>
                      <option value="002">면세</option>
					  <option value="003">영세</option>
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