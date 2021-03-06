<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
	p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
</style>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> <!-- 조직도 생성 -->
<link rel="stylesheet" href="/misc/css/tech_schedule/proton/style.min.css" /> <!-- 조직도 생성 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script language="javascript">
function GoSearch(){
	var searchkeyword = document.mform.searchkeyword.value;
	var searchkeyword = searchkeyword.trim();

	if(searchkeyword == ""){
		alert( "검색어를 입력해 주세요." );
		return false;
	}

	document.mform.action = "<?php echo site_url();?>/admin/customer/customer_list";
	document.mform.cur_page.value = "";
//	document.mform.search_keyword.value = searchkeyword;
	document.mform.submit();
}

</script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
  <div class="dash1-1">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="width:95%">
			<form name="mform" action="<?php echo site_url();?>/admin/customer/customer_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
			<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
			<input type="hidden" name="seq" value="">
			<input type="hidden" name="mode" value="">
			<!-- 타이틀 부분 시작 -->
				<tr height="5%">
					<td class="dash_title">
						거래처
					</td>
				</tr>
				<tr>
					<td height="70"></td>
				</tr>
				<!-- 타이틀 부분 끝 -->
				<!-- 검색 부분 시작 -->
				<tr height="10%">
          <td align="left" valign="bottom">
			    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		        	<tr>
								<td>
            <!--내용-->
                	<select name="search2" id="search2" class="select-common" style="margin-right:10px; width:140px;">
                    <option value="002" <?php if($search2 == "002"){ echo "selected";}?>>업체명</option>
                    <option value="003" <?php if($search2 == "003"){ echo "selected";}?>>사업자번호</option>
                    <option value="004" <?php if($search2 == "004"){ echo "selected";}?>>대표자명</option>
                    <option value="005" <?php if($search2 == "005"){ echo "selected";}?>>회사대표전화</option>
                    <option value="006" <?php if($search2 == "006"){ echo "selected";}?>>대표자 이동전화</option>
                    <option value="007" <?php if($search2 == "007"){ echo "selected";}?>>대표 E-Mail</option>
                	</select>
									<span>
										<input type="text" style="margin-right:10px; width:240px;" class="input-common" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
									</span>
									<span>
										<input class="btn-common btn-style2" type="button" onclick="return GoSearch();" value="검색" >
									</span>
								</td>
								<td align="right">
								<?php
									if($admin_lv == 3) {
								?>
										<input class="btn-common btn-color2" type="button" onclick="location.href='<?php echo site_url();?>/admin/customer/customer_input';" value="추가" >
								<?php
									}
								?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- 콘텐트시작 -->
    		<tr height="45%">
					<td valign="top" style="padding:15px 0px;">
						<table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<table width="100%" class="month_tbl list" border="0" cellspacing="0" cellpadding="0">
										<colgroup>
	                  	<col width="15%" />
	                  	<col width="5%" />
	                    <col width="8%" />
	                    <col width="5%" />
	                    <col width="8%" />
	                    <col width="8%" />
	                    <col width="5%" />
	                    <col width="5%" />
	                    <col width="8%" />
	                    <col width="8%" />
											<col width="5%" />
											<col width="15%" />
              			</colgroup>
										<tr class="t_top row-color1">
											<th></th>
	                    <th height="40" align="center">번호</th>
	                    <th align="center">업체명</th>
	                    <th align="center">업체구분</td>
						          <th align="center">사업자번호</th>
	                    <th align="center">법인번호</th>
	                    <th align="center">대표자명</th>
	                    <th align="center">은행</th>
	                    <th align="center">계좌번호</th>
	                    <th align="center">예금주</th>
											<th align="center">삭제</th>
											<th></th>
	                  </tr>
<?php
	if ($count > 0) {
		$i = $count - $no_page_list * ( $cur_page - 1 );
		$icounter = 0;

		foreach ( $list_val as $item ) {
			if($item['company_part'] == "001") {
				$strPart = "전체";
			} else if($item['company_part'] == "002") {
				$strPart = "고객사";
			} else if($item['company_part'] == "004") {
				$strPart = "협력사";
			}
?>
             				<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
											<td></td>
	                    <td height="40" align="center"><?php echo $i;?></td>
	                    <!-- <td align="center" class="t_border"><?php echo $item['seq'];?></td> -->
	                    <td align="center">
												<a class="list" href="javascript:ViewBoard('<?php echo $item['seq'];?>');"><?php echo $item['company_name'];?>
												</a>
											</td>
	                    <td align="center">
												<a class="list" href="javascript:ViewBoard('<?php echo $item['seq'];?>');"><?php echo $strPart;?>
												</a>
											</td>
	                    <td align="center">
												<a class="list" href="javascript:ViewBoard('<?php echo $item['seq'];?>');"><?php echo $item['cnum'];?>
												</a>
											</td>
	                    <td align="center">
												<a class="list" href="javascript:ViewBoard('<?php echo $item['seq'];?>');"><?php echo $item['rnum'];?>
												</a>
											</td>
	                    <td align="center">
												<a class="list" href="javascript:ViewBoard('<?php echo $item['seq'];?>');"><?php echo $item['represent_name'];?>
												</a>
											</td>
	                    <td align="center">
												<a class="list" href="javascript:ViewBoard('<?php echo $item['seq'];?>');">
                <?php
                  if($item['bank_code'] == ""){
                    echo "";
                  }else if ($item['bank_code'] == "039"){
                    echo "경남은행";
                  }else if ($item['bank_code'] == "034"){
                    echo "광주은행";
                  }else if ($item['bank_code'] == "004"){
                    echo "국민은행";
                  }else if ($item['bank_code'] == "003"){
                    echo "기업은행";
                  }else if ($item['bank_code'] == "011"){
                    echo "농협";
                  }else if ($item['bank_code'] == "012"){
                    echo "단위농협";
                  }else if ($item['bank_code'] == "031"){
                    echo "대구은행";
                  }else if ($item['bank_code'] == "055"){
                    echo "도이";
                  }else if ($item['bank_code'] == "059"){
                    echo "도쿄";
                  }else if ($item['bank_code'] == "058"){
                    echo "미즈";
                  }else if ($item['bank_code'] == "032"){
                    echo "부산은행";
                  }else if ($item['bank_code'] == "002"){
                    echo "산업은행";
                  }else if ($item['bank_code'] == "050"){
                    echo "상호신용금고";
                  }else if ($item['bank_code'] == "045"){
                    echo "새마을금고";
                  }else if ($item['bank_code'] == "007"){
                    echo "수협";
                  }else if ($item['bank_code'] == "053"){
                    echo "시티은행";
                  }else if ($item['bank_code'] == "026"){
                    echo "신한은행";
                  }else if ($item['bank_code'] == "048"){
                    echo "신협";
                  }else if ($item['bank_code'] == "056"){
                    echo "암로";
                  }else if ($item['bank_code'] == "005"){
                    echo "외환은행";
                  }else if ($item['bank_code'] == "020"){
                    echo "우리은행";
                  }else if ($item['bank_code'] == "071"){
                    echo "우체국";
                  }else if ($item['bank_code'] == "037"){
                    echo "전북은행";
                  }else if ($item['bank_code'] == "023"){
                    echo "제일은행";
                  }else if ($item['bank_code'] == "035"){
                    echo "제주은행";
                  }else if ($item['bank_code'] == "021"){
                    echo "조흥은행";
                  }else if ($item['bank_code'] == "081"){
                    echo "하나은행";
                  }else if ($item['bank_code'] == "027"){
                    echo "한미은행";
                  }else if ($item['bank_code'] == "017"){
                    echo "합병된은행(사용안함)";
                  }else if ($item['bank_code'] == "054"){
                    echo "홍콩";
                  }else if ($item['bank_code'] == "057"){
                    echo "UF";
                  }
                ?>
                				</a>
											</td>
	                    <td align="center">
												<a class="list" href="javascript:ViewBoard('<?php echo $item['seq'];?>');"><?php echo $item['bnum'];?>
												</a>
											</td>
	                    <td align="center">
												<a class="list" href="javascript:ViewBoard('<?php echo $item['seq'];?>');"><?php echo $item['deposit_name'];?>
												</a>
											</td>
                			<td align="center">
                  <?php if($admin_lv > 0){?>
                    		<a class="list" href="javascript:chkForm2('<?php echo $item['seq'];?>');">삭제</a>
                  <?php } ?>
                  		</td>
											<td></td>
              			</tr>
<?php
			$i--;
			$icounter++;
		}
	} else {
?>
										<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
                			<td width="100%" height="40" align="center" colspan="10">등록된 게시물이 없습니다.</td>
              			</tr>
<?php
	}
?>
		              </table>
								</td>
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

function ViewBoard (seq){
	document.mform.action = "<?php echo site_url();?>/admin/customer/customer_view";
	document.mform.seq.value = seq;
	document.mform.mode.value = "modify";

	document.mform.submit();
}

function chkForm2(seq) {
	if (confirm("정말 삭제하시겠습니까?") == true){
		var mform = document.mform;
		mform.action="<?php echo site_url();?>/admin/customer/customer_delete_action/" +seq;
		mform.submit();
		return false;
	}
}
</script>

						</table>
					</td>
				</tr>
<!-- 컨텐트 테이블 끝 -->
			  <tr height="40%">
        	<td align="left" valign="top">
						<table width="100%" cellspacing="0" cellpadding="0">
				    	<tr>
				      	<td width="19%">
				        	<tr height="20%">
				          	<td align="center" valign="top">
<!-- 페이징 시작 -->
<?php
	if ($count > 0) {
?>
											<table width="400" border="0" cellspacing="0" cellpadding="0">
                  			<tr>
<?php
		if ($cur_page > 10){
?>
			                    <td width="19">
														<a href="JavaScript:GoFirstPage()">
															<img src="<?php echo $misc;?>img/dashboard/btn/btn_last_left.svg" width="20" height="20"/>
														</a>
													</td>
			                    <td width="2"></td>
			                    <td width="19">
														<a href="JavaScript:GoPrevPage()">
															<img src="<?php echo $misc;?>img/dashboard/btn/btn_left.svg" width="20" height="20"/>
														</a>
													</td>
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
				$strSection = "&nbsp;<span class=\"section\">&nbsp;&nbsp;</span>&nbsp;";
			}

			if  ( $i == $cur_page ) {
				echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\"><font color=\"#33ccff\">".$i."</font></a>".$strSection;
			} else {
				echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\">".$i."</a>".$strSection;
			}
		}
?>
													</td>
<?php
		if( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
?>
													<td width="19">
														<a href="JavaScript:GoNextPage()">
															<img src="<?php echo $misc;?>img/dashboard/btn/btn_right.svg" width="20" height="20"/>
														</a>
													</td>
			                    <td width="2"></td>
			                    <td width="19">
														<a href="JavaScript:GoLastPage()">
															<img src="<?php echo $misc;?>img/dashboard/btn/btn_last_right.svg" width="20" height="20"/>
														</a>
													</td>
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
<?php
	}
?>
										</td>
              		</tr>
              <!--//페이징-->
          			</td>
      				</tr>

     				</table>
    			</td>
  			</tr>
			</form>
		</table>
	</div>
</div>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->

</body>
</html>
