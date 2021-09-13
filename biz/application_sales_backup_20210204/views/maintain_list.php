<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

if($search_keyword != ''){
	$filter = explode(',',str_replace('"', '&uml;',$search_keyword));
}
?>
<style>
.toggleUpBtn {
	width: 0px;
	height: 0px;
	margin: 8px 0px 0px 10px;
	border-bottom: 8px solid black;
	border-right: 7px solid transparent;
	border-left: 7px solid transparent;
	cursor: pointer;
}
.toggleDownBtn {
	width: 0px;
	height: 0px;
	margin: 8px 0px 0px 10px;
	border-top: 8px solid black;
	border-right: 7px solid transparent;
	border-left: 7px solid transparent;
	cursor: pointer;
}
</style>
<script language="javascript">

function GoSearch(){
	var searchkeyword = '';
  for (i = 1; i <= $(".filtercolumn").length; i++) {
    if (i == 1) {
      searchkeyword += $("#filter" + i).val();
    } else {
      searchkeyword += ',' + $("#filter" + i).val();
    }
  }

  $("#searchkeyword").val(searchkeyword)

  if (searchkeyword.replace(/,/g, "") == "") {
    alert("검색어가 없습니다.");
	location.href="<?php echo site_url();?>/maintain/maintain_list";
	return false;
  }

  document.mform.action = "<?php echo site_url();?>/maintain/maintain_list";
  document.mform.cur_page.value = "";
  document.mform.submit();
}

</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="mform" action="<?php echo site_url();?>/maintain/maintain_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">
<input type="hidden" id="searchkeyword" name="searchkeyword" value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
	<tr>
    <td align="center" valign="top">

    <table width="90%" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
            <td width="100%" align="center" valign="top">
            <table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <!--타이틀-->
              <tr>
                <td class="title3">유지보수</td>
              </tr>
              <!--타이틀-->
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td bgcolor="f8f8f9">
                  <div class="toggleUpBtn" onclick="showhide('up');"></div>
                  <div class="toggleDownBtn" onclick="showhide('down');" style="display:none;"></div>
                  <table width="80%" id="filter_table" style="margin-left:30px;margin-bottom:18px;">
                    <tr align="center">
                      <td>고객사</td>
                      <td><input type="text" id="filter1" class="input7 filtercolumn" value='<?php if(isset($filter)){echo $filter[0];} ?>'  /></td>
                      <td>프로젝트명</td>
                      <td><input type="text" id="filter2" class="input7 filtercolumn" value='<?php if(isset($filter)){echo $filter[1];} ?>' /></td>
                      <td>유지보수 시작일</td>
					  <td><input type="date" id="filter3" class="input7 filtercolumn" value='<?php if(isset($filter)){echo $filter[2];} ?>'/></td>
					  <td>유지보수 종료일</td>
                      <td><input type="date" id="filter4" class="input7 filtercolumn" value='<?php if(isset($filter)){echo $filter[3];} ?>'/></td>
                      <td rowspan=2 >
                        <input type="image" style='cursor:hand;margin-left:30px;' onclick="return GoSearch();" src="<?php echo $misc;?>img/btn_search.jpg" align="middle" border="0" />
                      </td>
                    </tr>
                    <tr align="center">
                      <td>영업담당자(두리안)</td>
                      <td><input type="text" id="filter5" class="input7 filtercolumn" value='<?php if(isset($filter)){echo $filter[4];} ?>' /></td>
					  <td>제조사</td>
                      <td><input type="text" id="filter6" class="input7 filtercolumn" value='<?php if(isset($filter)){echo $filter[5];} ?>' /></td>
					  <td>품목</td>
                      <td><input type="text" id="filter7" class="input7 filtercolumn" value='<?php if(isset($filter)){echo $filter[6];} ?>' /></td> 
					  <td>제품명</td>
                      <td><input type="text" id="filter8" class="input7 filtercolumn" value='<?php if(isset($filter)){echo $filter[7];} ?>' /></td>
					  
                    </tr>
                    <tr align="center">
					  <td>관리팀</td>
                      <td>
					  	<select id="filter9" class="input7 filtercolumn">
                          <option value="" >관리팀 선택</option>
                          <option value="1" <?php if(isset($filter) && $filter[8] == '1'){echo "selected";} ?> >기술1팀</option>
                          <option value="2" <?php if(isset($filter) && $filter[8] == '2'){echo "selected";} ?> >기술2팀</option>
                          <option value="3" <?php if(isset($filter) && $filter[8] == '3'){echo "selected";} ?> >기술3팀</option>
                        </select>
					  </td>
					  <td>점검여부</td>
                      <td>
					  	<select id="filter10" class="input7 filtercolumn">
                          <option value="" >점검여부 선택</option>
                          <option value="1" <?php if(isset($filter) && $filter[9] == '1'){echo "selected";} ?> >점검완료</option>
                          <option value="0" <?php if(isset($filter) && $filter[9] == '0'){echo "selected";} ?> >점검미완료</option>
						  <option value="2" <?php if(isset($filter) && $filter[9] == '2'){echo "selected";} ?> >점검미해당</option>
						  <option value="9" <?php if(isset($filter) && $filter[9] == '9'){echo "selected";} ?> >예정</option>
						  <option value="3" <?php if(isset($filter) && $filter[9] == '3'){echo "selected";} ?> >연기</option>
						  <option value="4" <?php if(isset($filter) && $filter[9] == '4'){echo "selected";} ?> >협력사 점검</option>
                        </select>
					  </td>		
                      <!-- <td>판매종류</td>
                      <td>
                        <select id="filter11" class="input7 filtercolumn">
                          <option value="" >판매종류 선택</option>
                          <option value="1" <?php if(isset($filter) && $filter[10] == '1'){echo "selected";} ?> >판매</option>
                          <option value="2" <?php if(isset($filter) && $filter[10] == '2'){echo "selected";} ?> >용역</option>
						  <option value="3" <?php if(isset($filter) && $filter[10] == '3'){echo "selected";} ?> >유지보수</option>
                          <option value="4" <?php if(isset($filter) && $filter[10] == '4'){echo "selected";} ?> >조달</option>
                          <option value="0" <?php if(isset($filter) && $filter[10] == '0'){echo "selected";} ?> >선택없음</option>
                        </select>
                      </td> -->
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td align="right">
                  <input type="button" class="basicBtn" value="excel download" onclick="excelDownload('excelTable','maintain');" style="margin:5px 0px 5px 20px;"/>
                </td>
              </tr>
              <!--리스트-->
              <tr>
                <td id="tablePlus"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <colgroup>
                    <col width="5%" /> <!-- 번호-->
                    <col width="5%" /> <!-- 종류-->
                    <col width="15%" /> <!-- 고객사 -->
                    <col width="10%" /> <!-- 프로젝트 -->
                    <col width="5%" /> <!--제조사-->
                    <col width="5%" /> <!--품목-->
                    <col width="10%" /> <!--제품명-->
                    <col width="6%" /> <!--유지보수시작일-->
                    <col width="6%" /> <!--유지보수종료일-->
                    <col width="5%" /> <!--매출금액-->
                    <col width="5%" /> <!--매입금액-->
                    <col width="6%" /> <!--마진금액-->
                    <col width="5%" /> <!--마진율-->
                    <col width="4%" /> <!--점검주기-->
                    <col width="4%" /> <!--관리팀-->
                    <col width="4%" /> <!--점검여부-->
                  </colgroup>
                  <tr>
                    <td colspan="16" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <tr bgcolor="f8f8f9" class="t_top">
                    <td rowspan="2" height="60" align="center">번호</td>
                    <td rowspan="2" align="center" class="t_border">종류</td>
                    <td rowspan="2" align="center" class="t_border">고객사</td>
                    <td rowspan="2" align="center" class="t_border">프로젝트</td>
                    <td colspan="3" align="center" class="t_border" style="height:30px;">제안제품</td>
		   			<td rowspan="2" align="center" class="t_border">유지보수시작일</td>
		    		<td rowspan="2" align="center" class="t_border">유지보수종료일</td>
                    <td rowspan="2" align="center" class="t_border">매출금액</td>
                    <td rowspan="2" align="center" class="t_border">매입금액</td>
                    <td rowspan="2" align="center" class="t_border">마진금액</td>
                    <td rowspan="2" align="center" class="t_border">마진율</td>
		    		<td rowspan="2" align="center" class="t_border">점검주기</td>
                    <td rowspan="2" align="center" class="t_border">관리팀</td>
                    <td rowspan="2" align="center" class="t_border">점검여부</td>
                  </tr>
				  <tr>
                  	<td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">제조사</td>
                    <td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">품목</td>
                    <td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">제품명</td>
                  </tr>
                  <tr>
                    <td colspan="16" height="1" bgcolor="#797c88"></td>
                  </tr>
			<?php
				if ($count > 0) {
					$i = $count - $no_page_list * ( $cur_page - 1 );
					$icounter = 0;

					foreach ( $list_val as $item ) {
						// if($item['type']==1){
						// 	$strType = "판매";
						// }else if($item['type']==2){
						// 	$strType = "용역";
						// }else if($item['type']==3){
						// 	$strType = "유지보수";
						// }else if($item['type']==4){
						// 	$strType = "조달";
						// }else{
						// 	$strType = "";
						// }


						if($item['manage_team']=="1"){
							$strstep ="기술1팀";
						}else if($item['manage_team']=="2"){
							$strstep ="기술2팀";
						}else if($item['manage_team']=="3"){
							$strstep ="기술3팀";
						}else{
							$strstep ="없음";
						}


//						echo "로그인cnum::".$cnum."<br>";
//						echo "가져온cnum::".$item['company_num']."<br>";
						/*
						if($item['progress_step'] == "001") {
							$strStep = "영업보류(0%)";
						} else if($item['progress_step'] == "002") {
							$strStep = "고객문의(5%)";
						} else if($item['progress_step'] == "003") {
							$strStep = "영업방문(10%)";
						} else if($item['progress_step'] == "004") {
							$strStep = "일반제안(15%)";
						} else if($item['progress_step'] == "005") {
							$strStep = "견적제출(20%)";
						} else if($item['progress_step'] == "006") {
							$strStep = "맞춤제안(30%)";
						} else if($item['progress_step'] == "007") {
							$strStep = "수정견적(35%)";
						} else if($item['progress_step'] == "008") {
							$strStep = "RFI(40%)";
						} else if($item['progress_step'] == "009") {
							$strStep = "RFP(45%)";
						} else if($item['progress_step'] == "010") {
							$strStep = "BMT(50%)";
						} else if($item['progress_step'] == "011") {
							$strStep = "DEMO(55%)";
						} else if($item['progress_step'] == "012") {
							$strStep = "가격경쟁(60%)";
						} else if($item['progress_step'] == "013") {
							$strStep = "Spen in(70%)";
						} else if($item['progress_step'] == "014") {
							$strStep = "수의계약(80%)";
						} else if($item['progress_step'] == "015") {
							$strStep = "수주완료(85%)";
						} else if($item['progress_step'] == "016") {
							$strStep = "매출발생(90%)";
						} else if($item['progress_step'] == "017") {
							$strStep = "미수잔금(95%)";
						} else if($item['progress_step'] == "018") {
							$strStep = "수금완료(100%)";
						}*/
			?>
                 <?php if($cnum == $item['company_num'] || $lv == 3) { ?><tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $item['seq'];?>')"><?php } else {?><tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'"><?php } ?>
                    <td height="40" align="center"><?php echo $i;?></td>
                    <td align="center" class="t_border">유지보수</td>
                    <td align="center" class="t_border"><?php echo $item['customer_companyname'];?></td>
                    <td align="center" class="t_border"><?php echo $item['project_name'];?></td>
                    <td align="center" class="t_border"><?php echo $item['product_company'];?></td>
                    <td align="center" class="t_border"><?php echo $item['product_item'];?></td>
                    <td align="center" class="t_border"><?php echo $item['product_name'];?></td>
                    <td align="center" class="t_border"><?php echo $item['exception_saledate2'];?></td>
                    <td align="center" class="t_border"><?php echo $item['exception_saledate3'];?></td>
					 <td align="center" class="t_border">
						<?php 
						// if($item['sub_project_add']==''){
							echo number_format($item['forcasting_sales']);
						// }else{
						// 	echo number_format($item['sum_forcasting_sales']);
						// };	
						?>
					</td>
					<td align="center" class="t_border">
						<?php 
						//  if($item['sub_project_add']==''){
							 echo number_format($item['forcasting_purchase']);
						// }else{
						// 	echo number_format($item['sum_forcasting_purchase']);	
						// };	
						?>
					</td>
					<td align="center" class="t_border">
						<?php
						// if($item['sub_project_add']==''){
							if($item['forcasting_profit']!=0) {
								echo number_format($item['forcasting_profit']);
							}else{
								echo 0;
							}
						// }else{
						// 	if($item['sum_forcasting_profit']!=0) {
						// 		echo number_format($item['sum_forcasting_profit']);
						// 	}else{
						// 		echo 0;
						// 	}
						// };	
						
						 ?>
					</td>
					<td align="center" class="t_border">
						<?php
							// if($item['sub_project_add']==''){
								if($item['forcasting_profit']!=0 && $item['forcasting_profit'] > 0) {
									echo number_format($item['forcasting_profit']*100/$item['forcasting_sales'],1)."%";
								}
							// }else{
							// 	if($item['sum_forcasting_profit']!=0 && $item['sum_forcasting_profit'] > 0) {
							// 		echo number_format($item['sum_forcasting_profit']*100/$item['sum_forcasting_sales'],1)."%";	
							// 	}
							// }	
						?>
					 </td>
                    <td align="center" class="t_border">
				<?php 
				// switch($item['maintain_cycle']){ //이거 왜 제대로 작동안해??
				// case 0:
				// 	echo "장애시";
				// 	break;
				// case 1:
				// 	echo "월점검";
				// 	break;
				// case 3:
				// 	echo "분기점검";
				// 	break;
				// case 6: 
				// 	echo "반기점검";
				// 	break;
				// case 7:
				// 	echo "미점검";
				// 	break;
				// default:
				// 	echo "미선택";
				// 	break;
				// }
				if ($item['maintain_cycle'] == "1") {
					echo "월점검";
				}else if ($item['maintain_cycle'] == "3") {
					echo "분기점검";
				}else if ($item['maintain_cycle'] == "6") {
					echo "반기점검";
				}else if ($item['maintain_cycle'] == "0") {
					echo "장애시";
				}else if ($item['maintain_cycle'] == "7") {
					echo "미점검";
				}else{
					echo "미선택";
				}
			?>
		    </td>
                    <!--<td align="center" class="t_border"><?php// echo $strStep;?></td>-->
                    <td align="center" class="t_border"><?php echo $strstep;?></td>
                    <td align="center" class="t_border">
			<?php
				switch($item['maintain_result']){
					case 0:
						echo "미완료";
						break;
					case 1:
						echo "완료";
						break;
					case 2:
						echo "미해당";
						break;
					case 9:
						echo "예정";
						break;
					default:
						echo "미선택";
						break;
				}
			?>
			</td></a>
                  </tr>
                  <tr>
                    <td colspan="16" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
		   <?php
						$i--;
						$icounter++;
						
					}
				} else {
			?>
				<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
                    <td width="100%" height="40" align="center" colspan="16">등록된 게시물이 없습니다.</td>
                  </tr>
                  <tr>
                    <td colspan="16" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
			<?php
				}
			?>
                    <td colspan="16" height="2" bgcolor="#797c88"></td>
                  </tr>
                </table></td>
              </tr>
              <!--리스트-->
<script language="javascript">

// <?php 
// for($i=0; $i<=count($sub_list_data); $i++){
// if($item['sub_project_add'] == $sub_list_data[$i]['sub_project_add']){
//         echo $sub_list_data[$i]['forcasting_sales']
//     }
// }
// ?>

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

function ViewBoard (seq){
	document.mform.action = "<?php echo site_url();?>/maintain/maintain_view";
	document.mform.seq.value = seq;
	document.mform.mode.value = "modify";

	document.mform.submit();
}
</script>
              <tr>
                <td height="15"></td>
              </tr>
              <!--버튼-->
              <tr>
<!--                <td align="right"><a href="<?php echo site_url();?>/maintain/maintain_input" title="작성하기"><img src="<?php echo $misc;?>img/btn_make.jpg" width="64" height="31" /></a></td>-->
              </tr>
              <!--버튼-->

              <!--페이징-->
              <tr>
                <td align="center">
		<?php if ($count > 0) {?>
				<table width="400" border="0" cellspacing="0" cellpadding="0">
                  <tr>
				<?php
					if ($cur_page > 10){
				?>
                    <td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/btn_prev.jpg" /></a></td>
                    <td width="2"></td>
                    <td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/btn_left.jpg" /></a></td>
				<?php
					} else {
				?>
					<td width="19"></td>
                    <td width="2"></td>
                    <td width="19"></td>
				<?php
					}
				?>
                    <td align="center">
					<?php
						for  ( $i = $start_page; $i <= $end_page ; $i++ ){
							if( $i == $end_page ) {
								$strSection = "";
							} else {
								$strSection = "&nbsp;<span class=\"section\">|</span>&nbsp;";
							}

							if  ( $i == $cur_page ) {
								echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\"><font color=\"#33ccff\">".$i."</font></a>".$strSection;
							} else {
								echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\">".$i."</a>".$strSection;
							}
						}
					?></td>
                    <?php
						if   ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
					?>
					<td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/btn_right.jpg"/></a></td>
                    <td width="2"></td>
                    <td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/btn_next.jpg" /></a></td>
					<?php
						} else {
					?>
					<td width="19"></td>
                    <td width="2"></td>
                    <td width="19"></td>
					<?php
						}
					?>
                  </tr>
                </table>
		<?php }?>
				</td>
              </tr>
              <!--페이징-->
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
            <!--내용-->

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
  <!--하단-->
</form>
</table>
<script>
function excelDownload(id, title) {
    var excel_download_table = "";
    excel_download_table += '<table id="excelTable" width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;"><colgroup><col width="5%" /><col width="5%" /><col width="15%" /><col width="10%" /><col width="5%" /><col width="5%" /><col width="10%" /><col width="6%" /><col width="6%" /><col width="5%" /><col width="5%" /><col width="6%" /><col width="5%" /><col width="4%" /> <col width="4%" /><col width="4%" /></colgroup>';
	// excel_download_table += '<tr><td colspan="16" height="2" bgcolor="#797c88"></td></tr>';
	excel_download_table += '<tr bgcolor="f8f8f9" class="t_top"><td rowspan="2" height="60" align="center">번호</td><td rowspan="2" align="center" class="t_border">종류</td><td rowspan="2" align="center" class="t_border">고객사</td><td rowspan="2" align="center" class="t_border">프로젝트</td><td colspan="3" align="center" class="t_border" style="height:30px;">제안제품</td><td rowspan="2" align="center" class="t_border">유지보수시작일</td><td rowspan="2" align="center" class="t_border">유지보수종료일</td>';
	excel_download_table += '<td rowspan="2" align="center" class="t_border">매출금액</td><td rowspan="2" align="center" class="t_border">매입금액</td><td rowspan="2" align="center" class="t_border">마진금액</td><td rowspan="2" align="center" class="t_border">마진율</td><td rowspan="2" align="center" class="t_border">점검주기</td><td rowspan="2" align="center" class="t_border">관리팀</td><td rowspan="2" align="center" class="t_border">점검여부</td></tr>';
	excel_download_table += '<tr><td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">제조사</td><td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">품목</td><td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">제품명</td></tr>';
	<?php
		$cnt = 1;
			foreach ( $excel_val as $item ) {
				// if($item['type']==1){
				// 	$strType = "판매";
				// }else if($item['type']==2){
				// 	$strType = "용역";
				// }else if($item['type']==3){
				// 	$strType = "유지보수";
				// }else if($item['type']==4){
				// 	$strType = "조달";
				// }else{
				// 	$strType = "";
				// }

				if($item['manage_team']=="1"){
					$strstep ="기술1팀";
				}else if($item['manage_team']=="2"){
					$strstep ="기술2팀";
				}else if($item['manage_team']=="3"){
					$strstep ="기술3팀";
				}else{
					$strstep ="없음";
				}
	?>
				 <?php if($cnum == $item['company_num'] || $lv == 3) { ?>
					excel_download_table +='<tr onmouseover="this.style.backgroundColor='+'#FAFAFA'+'" onmouseout="this.style.backgroundColor='+'#fff'+'" style="cursor:pointer" onclick="ViewBoard(<?php echo $item['seq'];?>)">';
				<?php } else {?>
					excel_download_table +='<tr onmouseover="this.style.backgroundColor='+'#FAFAFA'+'" onmouseout="this.style.backgroundColor='+'#fff'+'">';
				<?php } ?>
					excel_download_table += '<td height="40" align="center"><?php echo $cnt;?></td><td align="center" class="t_border">유지보수</td><td align="center" class="t_border"><?php echo $item['customer_companyname'];?></td><td align="center" class="t_border"><?php echo $item['project_name'];?></td>';
					excel_download_table += '<td align="center" class="t_border"><?php echo $item['product_company'];?></td><td align="center" class="t_border"><?php echo $item['product_item'];?></td><td align="center" class="t_border"><?php echo $item['product_name'];?></td><td align="center" class="t_border"><?php echo $item['exception_saledate2'];?></td><td align="center" class="t_border"><?php echo $item['exception_saledate3'];?></td><td align="center" class="t_border">';
				
					excel_download_table += '<?php echo number_format($item['forcasting_sales']);?>'; 	
				
					excel_download_table += '</td><td align="center" class="t_border">';
				
					excel_download_table += '<?php echo number_format($item['forcasting_purchase']); ?>';
					excel_download_table += '</td><td align="center" class="t_border">';
				<?php if($item['forcasting_profit']!=0) { ?>
					excel_download_table += '<?php echo number_format($item['forcasting_profit']); ?>';
					<?php }else{ ?>
						excel_download_table += '<?php echo 0; ?>';
					<?php }?>
					excel_download_table += '</td><td align="center" class="t_border">';
						<?php if($item['forcasting_profit']!=0 && $item['forcasting_profit'] > 0) { ?>
								excel_download_table += '<?php echo number_format($item['forcasting_profit']*100/$item['forcasting_sales'],1)."%";?>';
						<?php } ?>
					excel_download_table += '</td><td align="center" class="t_border">';
				<?php switch($item['maintain_cycle']){
					case 0:?>
					excel_download_table +='<?php echo "장애시";?>';
				<?php	break;
				case 1: ?>
					excel_download_table +='<?php echo "월점검";?>';
				<?php	break;
				case 3: ?>
					excel_download_table +='<?php echo "분기점검";?>';
				<?php break;
				case 6: ?>
					excel_download_table +='<?php echo "반기점검";?>';
				<?php break;
				case 7:?>
					excel_download_table +='<?php echo "미점검";?>';
				<?php break;
				default:?>
					excel_download_table +='<?php echo "미선택";?>';
				<?php break;}  ?>

				excel_download_table +='</td><td align="center" class="t_border"><?php echo $strstep;?></td><td align="center" class="t_border">';
			<?php
				switch($item['maintain_result']){
					case 0: ?>
						excel_download_table +='<?php echo "미완료";?>';
				<?php break;
					case 1: ?>
						excel_download_table +='<?php echo "완료"; ?>';
				<?php break;
					case 2: ?>
						excel_download_table +='<?php echo "미해당"; ?>';
				<?php break;
					case 9:?>
						excel_download_table +='<?php echo "예정";?>';
				<?php break; 
					default:?>
						excel_download_table +='<?php echo "미선택";?>';
				<?php break; } ?>
				excel_download_table +='</td></a></tr>';
		   <?php
		    $cnt++;						
			}
			?>
				excel_download_table +='<td colspan="16" height="2" bgcolor="#797c88"></td></tr></table>';
        
	$("#tablePlus").append(excel_download_table);

    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
    tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
    tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
    tab_text = tab_text + "<table border='1px'>";
    var exportTable = $('#' + id).clone();
    exportTable.find('input').each(function (index, elem) {
      $(elem).remove();
    });
    tab_text = tab_text + exportTable.html();
    tab_text = tab_text + '</table></body></html>';
    var data_type = 'data:application/vnd.ms-excel';
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    var fileName = title + '.xls';
    //Explorer 환경에서 다운로드
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
      if (window.navigator.msSaveBlob) {
        var blob = new Blob([tab_text], {
          type: "application/csv;charset=utf-8;"
        });
        navigator.msSaveBlob(blob, fileName);
      }
    } else {
      var blob2 = new Blob([tab_text], {
        type: "application/csv;charset=utf-8;"
      });
      var filename = fileName;
      var elem = window.document.createElement('a');
      elem.href = window.URL.createObjectURL(blob2);
      elem.download = filename;
      document.body.appendChild(elem);
      elem.click();
      document.body.removeChild(elem);
    }
}

function showhide(type){
    $("#filter_table").toggle();
    $(".toggleDownBtn").toggle();
    $(".toggleUpBtn").toggle();
  }
</script>

</body>
</html>