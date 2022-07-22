<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
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
	var obj = document.getElementsByName("scheck[]");
	var cnt = 0;
	
	for (var i = 0 ; i < obj.length; i++) {
		if (obj[i].checked == true) { 
			cnt++;
		}
	} 
	
	if(cnt == 0){ 
		mform.checksum.value = "0";
	}
	mform.action = "<?php echo site_url();?>/admin/customer/customer_input_action3";
	mform.submit();
	return false;
}
</script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="cform" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
<input type="hidden" name="seq" value="<?php echo $seq;?>">
<input type="hidden" name="mode" value="0">
<input type="hidden" name="checksum" value="1">
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
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_3_on.jpg" /></li>
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
              
             <!--리스트-->
              <tr>
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <colgroup>
                  	<col width="5%" />
                    <col width="10%" />
                    <col width="15%" />
                    <col width="15%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="15%" />
                    <col width="10%" />
                    <col width="10%" />
                  </colgroup>
                  <!--시작라인-->
                  <tr>
                    <td colspan="9" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//시작라인-->
                  <tr>
                    <td height="40" colspan="9" align="center" style="font-weight:bold; font-size:16px;">Sourcing Group 등록 리스트</td>
                  </tr>  
                  <tr>
                    <td colspan="9" height="1" bgcolor="#797c88"></td>
                  </tr>
                  
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" >선택</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">구분</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">Sourcing Group</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">제조사</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">자격</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">엔지니어 수</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">거래실적</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">증빙서류</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">관리</td>
                  </tr>
                  
                  <tr>
                    <td colspan="9" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
				  <?php
				if ($count > 0) {
					$i = $count - $no_page_list * ( $cur_page - 1 );
					$icounter = 0;
					
					foreach ( $list_val as $item ) {
						if($item['part'] == "001") {
							$strPart = "SW";
						} else if($item['part'] == "002") {
							$strPart = "HW";
						} if($item['part'] == "003") {
							$strPart = "기타";
						}
						
						if($item['file_changename']) {
							$strFile = "<a href='".site_url()."/admin/customer/customer_download4/".$item['seq']."/".$item['file_changename']."'>".$item['file_realname']."</a>";
						} else {
							$strFile = "-";
						}

						foreach ($category  as $val) {
//							if( $item['product_company'] && ( $val['code'] == $item['product_company'] ) ) {
//								$strCompany = $val['code_name'];
//							}
						}
				?>
                  <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
                    <td height="40" align="center"><input type="checkbox" name="scheck[]" value="<?php echo $item['seq'];?>"></td>
                    <td  align="center" class="t_border"><?php echo $strPart;?></td>
                    <td  align="center" class="t_border"><?php echo $item['solution_group'];?></td>
                    <td  align="center" class="t_border"><?php echo $item['product_company'];?></td>
                    <td  align="center" class="t_border"><?php echo $item['product_capacity'];?></td>
                    <td  align="center" class="t_border"><?php echo $item['ecount'];?></td>
                    <td  align="center" class="t_border"><?php echo $item['dcount'];?></td>
                    <td  align="center" class="t_border"><?php echo $strFile;?></td>
                    <td  align="center" class="t_border"><?php echo $item['manage'];?></td>
                  </tr>
                <?php
						$i--;
						$icounter++;
					}
				} else {
				?>
				<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
                    <td width="100%" height="40" align="center" colspan="9">등록된 게시물이 없습니다.</td>
                 </tr>
				<?php
				}	
				?>   
                  <!--total-->
                  <tr>
                    <td colspan="9" height="1" bgcolor="#797c88"></td>
                  </tr>
                  <tr>
                    <td height="40" colspan="9" align="left"  style="font-size:14px; color:#666; padding-left:10px;">Total Records: <?php echo $count;?></td>
                  </tr> 
                  <!--//total-->

                  <!--마지막라인-->
                  <tr>
                    <td colspan="9" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->
                </table></td>
              </tr>
              <!--//리스트-->
<script language="javascript">
function GoFirstPage (){
	document.mform.cur_page.value = 1;
	document.mform.submit();
}

function GoPrevPage (){
	var	cur_start_page = <?php echo $cur_page;?>;

	document.mform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
	document.mform.submit( );
}

function GoPage(nPage){
	document.mform.cur_page.value = nPage;
	document.mform.submit();
}

function GoNextPage (){
	var	cur_start_page = <?php echo $cur_page;?>;

	document.mform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
	document.mform.submit();
}

function GoLastPage (){
	var	total_page = <?php echo $total_page;?>;
//	alert(total_page);

	document.mform.cur_page.value = total_page;
	document.mform.submit();
}

//function ViewBoard (seq){
//	document.mform.action = "<?php echo site_url();?>/customer/sourcing_view";
//	document.mform.seq.value = seq;
//	document.mform.mode.value = "modify";
//
//	document.mform.submit();
//}
</script>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <!--페이징-->
              <!--//페이징-->
              <tr>
                <td>&nbsp;</td>
              </tr>
              <!--안내글-->
              <tr>
                <td align="left" style="color:#888; font-size:12px; line-height:20px;">
                ※ Sourcing Group 등록은 최초 등록 시만 가능합니다. 공급가능한 품목을 최대한 등록하시기 바랍니다.(승인 후 수정 불가)<br />
                ※ 협력사 승인이 완료된 후에 추가 Sourcing Group을 추가/수정하시기 위해서는 담당구매원에게 요청 바랍니다
                </td>
              </tr>
              <!--//안내글-->
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <!--작성-->
              <tr>
                <td valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                    <td height="40" colspan="4" align="center" style="font-weight:bold; font-size:16px;">수상 정보</td>
                  </tr>  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*수상경력</td>
                    <td align="left" class="t_border" style="padding-left:10px;">
                    <input name="awards_experience" type="radio" value="001" checked="checked" style=" float:left;" /> <span style=" display:block; float:left; line-height:18px; padding:0 5px;">장관이상</span> 
                    <input name="awards_experience" type="radio" value="002" checked="checked" style="float:left;" /> <span style=" display:block; float:left; line-height:18px; padding:0 5px;">협회장이상</span>
                    <input name="awards_experience" type="radio" value="003" checked="checked" style="float:left;" /> <span style=" display:block; float:left; line-height:18px; padding:0 5px;">없음</span>
                    </td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">품질인증여부</td>
                    <td align="left" class="t_border" style="padding-left:10px;">
                    <input name="quality_flag" type="radio" value="Y" checked="checked" style=" float:left;" /> <span style=" display:block; float:left; line-height:18px; padding:0 5px;">Yes</span> 
                    <input name="quality_flag" type="radio" value="N" checked="checked" style="float:left;" /> <span style=" display:block; float:left; line-height:18px; padding:0 5px;">No</span>
                    </td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">대상수상경력</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="major_awards" type="text" class="input2" id="major_awards"/></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">품질인증명</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="quality_certification" type="text" class="input2" id="quality_certification"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">수상정보 파일</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><input name="cfile" type="file" id="cfile"/> </td>
                  </tr>  
                  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                  	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">수상횟수</td>
                    <td align="left" colspan="3" class="t_border" style="padding-left:10px;"><input name="awards_count" type="text" class="input0" id="awards_count" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> <span style="color:#333; font-size:12px;">회</span></td>
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
                <td align="right"><input type="image" src="<?php echo $misc;?>img/btn_b_next.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;"/> <a href="<?php echo site_url();?>/admin/customer/customer_list"><img src="<?php echo $misc;?>img/btn_list.jpg" width="64" height="31" border="0"/></a></td>
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
 </form>
</table>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->
</body>
</html>