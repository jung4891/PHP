<?php

	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

//print_r($_POST);

?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script language="javascript">

// window.onload = function () {
//   change();
// }

function GoSearch() {
  var year = document.mform.search1.value;
  var company = document.mform.search1.value;
	var mode = "?mode=" + getParam('mode');

  document.mform.action = "<?php echo site_url();?>/sales/funds/funds_list"+mode;
  document.mform.submit();
}

// function change() {
//   var search2 = document.getElementById("search2").selectedIndex;
//
//   var searchkeyword2 = document.getElementById("searchkeyword2");
//
//   if (search2 == 8) {
//     searchkeyword2.style = "width:130px;";
//   } else {
//     searchkeyword2.style = "display:none;";
//   }
// }
</script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>

<div align="center">
	<div class="dash1-1">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="width:95%">
			<form name="mform" action="<?php echo site_url();?>/sales/maintain/maintain_list" method="post" onkeydown="if(event.keyCode==13) return GoSearch();">
				<input type="hidden" name="seq" value="">
				<input type="hidden" name="mode" value="">
				<tbody>
					<tr height="5%">
			      <td class="dash_title">
							<?php if($_GET['mode']=='month'){ ?>
			        월별매출현황
						<?php } else if ($_GET['mode']=='division'){ ?>
							분기별매출현황
						<?php } ?>
			      </td>
			    </tr>
					<tr>
						<td height="70"></td>
					</tr>
					<!-- 검색창 -->
					<tr height="10%">
						<td align="left" valign="bottom">
							<table border="0" cellspacing="0" cellpadding="0" width="100%">
								<tr>
									<td>
										<select name="search1" id="search1" class="select-common" style="margin-right:10px;">
											<option  option value="0"> 연도 선택</option>
											<?php
											$year = date("Y");
											for($i=2019;$i<$year+3;$i++){ ?>
												<option value="<?php echo $i; ?>" <?php if($search1 == $i){ echo "selected";}?>><?php echo $i; ?></option>
											<?php } ?>
										</select>
										<select name="search2" id="search2" class="select-common" style="width:150px;margin-right:10px;">
											<option value="0"> 업체 선택</option>
											<option value="IT" <?php if($search2 == "IT"){ echo "selected";}?>>두리안정보기술</option>
											<option value="D_1" <?php if($search2 == "D_1"){ echo "selected";}?>>사업1부</option>
											<option value="D_2" <?php if($search2 == "D_2"){ echo "selected";}?>>사업2부</option>
											<option value="ICT" <?php if($search2 == "ICT"){ echo "selected";}?>>두리안정보통신기술</option>
											<option value="MG" <?php if($search2 == "MG"){ echo "selected";}?>>더망고</option>
										</select>
										<input class="btn-common btn-style1" type="button" onclick="return GoSearch();" value="검색" >
										<input type="button" class="btn-common btn-color2" value="작성" onclick="location.href='<?php echo site_url();?>/sales/funds/funds_input';" style="float:right;width:80px;">
										<!-- <a href="<?php echo site_url();?>/sales/funds/funds_input" class="btn-common">작성</a> -->
										<input type="button" class="btn-common btn-color1" value="상세내역보기" style="float:right;margin-right:10px;width:120px;" onclick="detailView();" >
										<select id="detail_view_month" class="select-common" style="float:right; margin-right:10px;<?php if($_GET['mode']=='division'){echo 'display:none';} ?>">
											<option value="">해당월 선택</option>
											<?php for($i=1; $i<=12; $i++){ ?>
												<option value="<?php echo $i; ?>"><?php echo $i; ?>월</option>
											<?php } ?>
										</select>
										<select id="detail_view_division" class="select-common" style="float:right; margin-right:10px;<?php if($_GET['mode']=='month'){echo 'display:none';} ?>">
											<option value="">해당분기 선택</option>
											<?php for($i=1; $i<5; $i++){ ?>
												<option value="<?php echo $i; ?>"><?php echo $i; ?>분기</option>
											<?php } ?>
										</select>
									</td>
								</tr>
							</table>
						</td>
					</tr>

					<!-- 리스트 -->
					<tr>
						<td colspan="2" valign="top" style="padding:10px 0px; height:1px;">
							<table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>

												<!-- 월별보기 -->
												<table id="month_tbl" class="month_tbl" width="100%" cellspacing="0" cellpadding="0" style="<?php if($_GET['mode']=='division'){echo 'display:none';} ?>">
													<colgroup>
														<col width="5.3%" /> <!-- 연 -->
				                    <col width="7.19%" /> <!-- 1 -->
				                    <col width="7.19%" /> <!-- 2  -->
				                    <col width="7.19%" /> <!-- 3  -->
				                    <col width="7.19%" /> <!-- 4 -->
				                    <col width="7.19%" /> <!-- 5 -->
				                    <col width="7.19%" /> <!-- 6 -->
				                    <col width="7.19%" /> <!-- 7 -->
				                    <col width="7.19%" /> <!-- 8 -->
				                    <col width="7.19%" /> <!-- 9 -->
				                    <col width="7.19%" /> <!--10 -->
				                    <col width="7.19%" /> <!--11 -->
				                    <col width="7.19%" /> <!--12 -->
				                    <col width="8.42%" /> <!--총합 -->
													</colgroup>

													<tr class="t_top row-color1">
														<th align="center">구분</th>
				                    <th align="center">1월</th>
				                    <th align="center">2월</th>
				                    <th align="center">3월</th>
				                    <th align="center">4월</th>
				                    <th align="center">5월</th>
				                    <th align="center">6월</th>
				                    <th align="center">7월</th>
				                    <th align="center">8월</th>
				                    <th align="center">9월</th>
				                    <th align="center">10월</th>
				                    <th align="center">11월</th>
				                    <th align="center">12월</th>
				                    <th align="center">합계 (년)</th>
													</tr>

													<tr>
				                    <td align="center" style="font-weight:bold;">목표</td>
													<?php for($i=1;$i<13;$i++){ ?>
				                    <td class="money_td" align="right" id="m_purpose_<?php echo $i; ?>"><?php echo number_format($item[0]['purpose_'.$i]);?></td>
													<?php } ?>
				                    <td class="money_td" align="right"><?php echo number_format($sum_purpose);?></td>
				                  </tr>

													<tr>
														<td align="center" style="font-weight:bold;">Forcasting</td>
														<td class="money_td" align="right"><?php echo number_format($forcasting_1[0]['sum']);?></td>
														<td class="money_td" align="right"><?php echo number_format($forcasting_2[0]['sum']);?></td>
														<td class="money_td" align="right"><?php echo number_format($forcasting_3[0]['sum']);?></td>
														<td class="money_td" align="right"><?php echo number_format($forcasting_4[0]['sum']);?></td>
														<td class="money_td" align="right"><?php echo number_format($forcasting_5[0]['sum']);?></td>
														<td class="money_td" align="right"><?php echo number_format($forcasting_6[0]['sum']);?></td>
														<td class="money_td" align="right"><?php echo number_format($forcasting_7[0]['sum']);?></td>
														<td class="money_td" align="right"><?php echo number_format($forcasting_8[0]['sum']);?></td>
														<td class="money_td" align="right"><?php echo number_format($forcasting_9[0]['sum']);?></td>
														<td class="money_td" align="right"><?php echo number_format($forcasting_10[0]['sum']);?></td>
														<td class="money_td" align="right"><?php echo number_format($forcasting_11[0]['sum']);?></td>
														<td class="money_td" align="right"><?php echo number_format($forcasting_12[0]['sum']);?></td>
														<td class="money_td" align="right"><?php echo number_format($sum_forcasting);?></td>
													</tr>

													<tr>
														<td align="center" style="font-weight:bold;">달성(판매)</td>
													<?php
													for($i=1; $i<13; $i++) { ?>
														<td class="money_td" align="right"><?php if($forcasting['sale'][$i][0]['sum']==0){echo "-";}else{echo number_format($forcasting["sale"][$i][0]['sum']);} ?></td>
													<?php } ?>
														<td class="money_td" align="right"><?php echo number_format($sum_sale);?></td>
													</tr>

													<tr>
														<td align="center" style="font-weight:bold;">달성(용역)</td>
													<?php
													for($i=1; $i<13; $i++) { ?>
														<td class="money_td" align="right"><?php if($forcasting['service'][$i][0]['sum']==0){echo "-";}else{echo number_format($forcasting["service"][$i][0]['sum']);} ?></td>
													<?php } ?>
														<td class="money_td" align="right"><?php echo number_format($sum_service);?></td>
													</tr>

													<tr>
														<td align="center" style="font-weight:bold;">달성(조달)</td>
													<?php
													for($i=1; $i<13; $i++) { ?>
														<td class="money_td" align="right"><?php if($forcasting['support'][$i][0]['sum']==0){echo "-";}else{echo number_format($forcasting["support"][$i][0]['sum']);} ?></td>
													<?php } ?>
														<td class="money_td" align="right"><?php echo number_format($sum_support);?></td>
													</tr>

													<tr>
														<td align="center" style="font-weight:bold;">달성(유지보수)</td>
											<?php
													for($i=1; $i<13; $i++) { ?>
														<td class="money_td" align="right"><?php if($maintain[$i][0]['sum']==0){echo "-";}else{echo number_format($maintain[$i][0]['sum']);} ?></td>
											<?php } ?>
														<td class="money_td" align="right"><?php echo number_format($sum_maintain);?></td>
													</tr>

													<tr class="row-color2">
														<td align="center" style="font-weight:bold;">달성(합계)</td>
											<?php
													for($i=1; $i<13; $i++) {
														$achieve_sum = $forcasting["sale"][$i][0]['sum']+$forcasting["service"][$i][0]['sum']+$forcasting["support"][$i][0]['sum']+$maintain[$i][0]['sum'];
														 ?>
														<td class="money_td" align="right" id="m_achieve_<?php echo $i; ?>">
															<?php
															if ($achieve_sum==0){
																echo "-";
															} else {
																echo number_format($achieve_sum);
															}
															 ?>
														</td>
											<?php } ?>
														<td class="money_td" align="right"><?php echo number_format($sum_sale+$sum_service+$sum_support+$sum_maintain);?></td>
													</tr>

													<tr>
														<td align="center" style="font-weight:bold;">달성율(%)</td>
											<?php
													for($i=1; $i<13; $i++) {
														$achieve_sum = $forcasting["sale"][$i][0]['sum']+$forcasting["service"][$i][0]['sum']+$forcasting["support"][$i][0]['sum']+$maintain[$i][0]['sum'];
														$purpose = $item[0]['purpose_'.$i];
														 ?>
														<td class="money_td" align="right">
															<?php
															if ($purpose==0) {
																echo "-";
															} else {
																$percent = $achieve_sum/$purpose*100;
																if ($percent==0){
																	echo "-";
																} else {
																	echo round($achieve_sum/$purpose*100)."%";
																}
															}
															 ?>
														</td>
											<?php } ?>
														<td class="money_td" align="right"><?php
														 $sa = $sum_sale+$sum_service+$sum_support+$sum_maintain;
														 if ($sum_purpose==0){
															 echo "-";
														 } else {
															 $s_percent = $sa / $sum_purpose * 100;
															 if($s_percent==0){
																 echo "-";
															 } else {
																 echo round($s_percent)."%";
															 }
														 }
														 ?></td>
													</tr>

													<tr class="row-color3">
														<td align="center" style="font-weight:bold;">매입</td>
											<?php
													for($i=1; $i<13; $i++) { ?>
														<td class="money_td" align="right">
															<?php
															if($purchase_forcasting[$i][0]['sum']+$purchase_maintain[$i][0]['sum']+$purchase_request[$i][0]['sum']==0){
																echo "-";
															}else{
																echo number_format($purchase_forcasting[$i][0]['sum']+$purchase_maintain[$i][0]['sum']+$purchase_request[$i][0]['sum']);
															}
															?>
														</td>
											<?php } ?>
														<td class="money_td" align="right"><?php echo number_format($sum_purchase);?></td>
													</tr>

													<tr class="row-color4">
														<td align="center" style="font-weight:bold;">이익</td>
											<?php
													$benefit_sum = 0;
													for($i=1; $i<13; $i++) { ?>
														<td class="money_td" align="right" id="m_benefit_<?php echo $i; ?>">
															<?php
															$achieve_sum = $forcasting["sale"][$i][0]['sum']+$forcasting["service"][$i][0]['sum']+$forcasting["support"][$i][0]['sum']+$maintain[$i][0]['sum'];
															$purchase_sum = $purchase_forcasting[$i][0]['sum']+$purchase_maintain[$i][0]['sum']+$purchase_request[$i][0]['sum'];
															if ($achieve_sum-$purchase_sum==0){
																echo "-";
															} else {
																echo number_format($achieve_sum-$purchase_sum);
															}
															$benefit_sum += $achieve_sum-$purchase_sum;
															?>
														</td>
											<?php } ?>
														<td class="money_td" align="right"><?php echo number_format($benefit_sum);?></td>
													</tr>

												</table>

												<!-- 분기별보기 -->
												<table id="division_tbl" class="division_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="<?php if($_GET['mode']=='month'){echo 'display:none';} ?>">
													<colgroup>
														<col width="6.19%" /> <!-- 연 -->
				                    <col width="21.14%" /> <!-- 1 분기 -->
				                    <col width="21.14%" /> <!-- 2 분기 -->
				                    <col width="21.14%" /> <!-- 3 분기 -->
				                    <col width="21.14%" /> <!-- 4 분기 -->
				                    <col width="9.25%" /> <!--총합 -->
													</colgroup>

													<tr class="t_top row-color1">
														<th align="center">구분</th>
				                    <th align="center">1분기</th>
				                    <th align="center">2분기</th>
				                    <th align="center">3분기</th>
				                    <th align="center">4분기</th>
				                    <th align="center">합계 (년)</th>
													</tr>

													<tr>
				                    <td align="center" style="font-weight:bold;">목표</td>
													<?php for($i=1;$i<13;$i+=3){ ?>
				                    <td class="money_td" align="right" id="d_purpose_<?php echo $i; ?>"><?php echo number_format($item[0]['purpose_'.$i]+$item[0]['purpose_'.($i+1)]+$item[0]['purpose_'.($i+2)]);?></td>
													<?php } ?>
				                    <td class="money_td" align="right"><?php echo number_format($sum_purpose);?></td>
				                  </tr>

													<tr>
														<td align="center" style="font-weight:bold;">Forcasting</td>
														<td class="money_td" align="right"><?php echo number_format($forcasting_1[0]['sum']+$forcasting_2[0]['sum']+$forcasting_3[0]['sum']);?></td>
														<td class="money_td" align="right"><?php echo number_format($forcasting_4[0]['sum']+$forcasting_5[0]['sum']+$forcasting_6[0]['sum']);?></td>
														<td class="money_td" align="right"><?php echo number_format($forcasting_7[0]['sum']+$forcasting_8[0]['sum']+$forcasting_9[0]['sum']);?></td>
														<td class="money_td" align="right"><?php echo number_format($forcasting_10[0]['sum']+$forcasting_11[0]['sum']+$forcasting_12[0]['sum']);?></td>
														<td class="money_td" align="right"><?php echo number_format($sum_forcasting);?></td>
													</tr>

													<tr>
														<td align="center" style="font-weight:bold;">달성(판매)</td>
													<?php
													for($i=1; $i<13; $i+=3) {
														$m = $forcasting['sale'][$i][0]['sum'] + $forcasting['sale'][$i+1][0]['sum'] + $forcasting['sale'][$i+2][0]['sum'];
														?>
														<td class="money_td" align="right">
															<?php
															if($m==0){
																echo "-";
															}else{
																echo number_format($m);
															} ?>
														</td>
													<?php } ?>
														<td class="money_td" align="right"><?php echo number_format($sum_sale);?></td>
													</tr>

													<tr>
														<td align="center" style="font-weight:bold;">달성(용역)</td>
													<?php
													for($i=1; $i<13; $i+=3) {
														$m = $forcasting['service'][$i][0]['sum'] + $forcasting['service'][$i+1][0]['sum'] + $forcasting['service'][$i+2][0]['sum'];
														?>
														<td class="money_td" align="right">
															<?php
															if($m==0){
																echo "-";
															}else{
																echo number_format($m);
															} ?>
														</td>
													<?php } ?>
														<td class="money_td" align="right"><?php echo number_format($sum_service);?></td>
													</tr>

													<tr>
														<td align="center" style="font-weight:bold;">달성(조달)</td>
														<?php
														for($i=1; $i<13; $i+=3) {
															$m = $forcasting['support'][$i][0]['sum'] + $forcasting['support'][$i+1][0]['sum'] + $forcasting['support'][$i+2][0]['sum'];
															?>
															<td class="money_td" align="right">
														<?php
														if($m==0){
															echo "-";
														}else{
															echo number_format($m);
														} ?>
													</td>
												<?php } ?>
													<td class="money_td" align="right"><?php echo number_format($sum_support);?></td>
													</tr>

													<tr>
														<td align="center" style="font-weight:bold;">달성(유지보수)</td>
														<?php
														for($i=1; $i<13; $i+=3) {
															$m = $maintain[$i][0]['sum'] + $maintain[$i+1][0]['sum'] + $maintain[$i+2][0]['sum'];
															?>
															<td class="money_td" align="right">
														<?php
														if($m==0){
															echo "-";
														}else{
															echo number_format($m);
														} ?>
													</td>
												<?php } ?>
													<td class="money_td" align="right"><?php echo number_format($sum_maintain);?></td>
													</tr>

													<tr class="row-color2">
														<td align="center" style="font-weight:bold;">달성(합계)</td>
											<?php
													for($i=1; $i<13; $i+=3) {
														$sale_sum = $forcasting["sale"][$i][0]['sum'] + $forcasting["sale"][$i+1][0]['sum'] + $forcasting["sale"][$i+2][0]['sum'];

														$service_sum = $forcasting["service"][$i][0]['sum'] + $forcasting["service"][$i+1][0]['sum'] + $forcasting["service"][$i+2][0]['sum'];

														$support_sum = $forcasting["support"][$i][0]['sum'] + $forcasting["support"][$i+1][0]['sum'] + $forcasting["support"][$i+2][0]['sum'];

														$maintain_sum = $maintain[$i][0]['sum'] + $maintain[$i+1][0]['sum'] + $maintain[$i+2][0]['sum'];

														$total_sum = $sale_sum + $service_sum + $support_sum + $maintain_sum;
														 ?>
														<td class="money_td" align="right" id="d_achieve_<?php echo $i; ?>">
															<?php
															if ($total_sum==0){
																echo "-";
															} else {
																echo number_format($total_sum);
															}
															 ?>
														</td>
											<?php } ?>
														<td class="money_td" align="right"><?php echo number_format($sum_sale+$sum_service+$sum_support+$sum_maintain);?></td>
													</tr>

													<tr>
														<td align="center" style="font-weight:bold;">달성율(%)</td>
											<?php
													for($i=1; $i<13; $i+=3) {
														$sale_sum = $forcasting["sale"][$i][0]['sum'] + $forcasting["sale"][$i+1][0]['sum'] + $forcasting["sale"][$i+2][0]['sum'];

														$service_sum = $forcasting["service"][$i][0]['sum'] + $forcasting["service"][$i+1][0]['sum'] + $forcasting["service"][$i+2][0]['sum'];

														$support_sum = $forcasting["support"][$i][0]['sum'] + $forcasting["support"][$i+1][0]['sum'] + $forcasting["support"][$i+2][0]['sum'];

														$maintain_sum = $maintain[$i][0]['sum'] + $maintain[$i+1][0]['sum'] + $maintain[$i+2][0]['sum'];

														$achieve_sum = $sale_sum + $service_sum + $support_sum + $maintain_sum;
														$purpose = $item[0]['purpose_'.$i]+$item[0]['purpose_'.($i+1)]+$item[0]['purpose_'.($i+2)];
														 ?>
														<td class="money_td" align="right">
															<?php
															if ($purpose==0) {
																echo "-";
															} else {
																$percent = $achieve_sum/$purpose*100;
																if ($percent==0){
																	echo "-";
																} else {
																	echo round($achieve_sum/$purpose*100)."%";
																}
															}
															 ?>
														</td>
											<?php } ?>
														<td class="money_td" align="right"><?php
														 $sa = $sum_sale+$sum_service+$sum_support+$sum_maintain;
														 if ($sum_purpose==0){
															 echo "-";
														 } else {
															 $s_percent = $sa / $sum_purpose * 100;
															 if($s_percent==0){
																 echo "-";
															 } else {
																 echo round($s_percent)."%";
															 }
														 }
														 ?></td>
													</tr>

													<tr class="row-color3">
														<td align="center" style="font-weight:bold;">매입</td>
											<?php
													for($i=1; $i<13; $i+=3) {
														$sum_forcasting = $purchase_forcasting[$i][0]['sum'] + $purchase_forcasting[$i+1][0]['sum'] + $purchase_forcasting[$i+2][0]['sum'];
														$sum_maintain = $purchase_maintain[$i][0]['sum'] + $purchase_maintain[$i+1][0]['sum'] + $purchase_maintain[$i+2][0]['sum'];
														$sum_request = $purchase_request[$i][0]['sum'] + $purchase_request[$i+1][0]['sum'] + $purchase_request[$i+2][0]['sum'];
														?>
														<td class="money_td" align="right">
															<?php
															if($sum_forcasting+$sum_maintain==0){
																echo "-";
															}else{
																echo number_format($sum_forcasting+$sum_maintain+$sum_request);
															}
															?>
														</td>
											<?php } ?>
														<td class="money_td" align="right"><?php echo number_format($sum_purchase);?></td>
													</tr>

													<tr class="row-color4">
														<td align="center" style="font-weight:bold;">이익</td>
											<?php
													$benefit_sum = 0;
													for($i=1; $i<13; $i+=3) { ?>
														<td class="money_td" align="right" id="d_benefit_<?php echo $i; ?>">
															<?php
															$sale_sum = $forcasting["sale"][$i][0]['sum'] + $forcasting["sale"][$i+1][0]['sum'] + $forcasting["sale"][$i+2][0]['sum'];

															$service_sum = $forcasting["service"][$i][0]['sum'] + $forcasting["service"][$i+1][0]['sum'] + $forcasting["service"][$i+2][0]['sum'];

															$support_sum = $forcasting["support"][$i][0]['sum'] + $forcasting["support"][$i+1][0]['sum'] + $forcasting["support"][$i+2][0]['sum'];

															$maintain_sum = $maintain[$i][0]['sum'] + $maintain[$i+1][0]['sum'] + $maintain[$i+2][0]['sum'];

															$achieve_sum = $sale_sum + $service_sum + $support_sum + $maintain_sum;

															$sum_forcasting_p = $purchase_forcasting[$i][0]['sum'] + $purchase_forcasting[$i+1][0]['sum'] + $purchase_forcasting[$i+2][0]['sum'];
															$sum_maintain_p = $purchase_maintain[$i][0]['sum'] + $purchase_maintain[$i+1][0]['sum'] + $purchase_maintain[$i+2][0]['sum'];
															$sum_request_p = $purchase_request[$i][0]['sum'] + $purchase_request[$i+1][0]['sum'] + $purchase_request[$i+2][0]['sum'];

															$purchase_sum = $sum_forcasting_p+$sum_maintain_p;
															if ($achieve_sum-$purchase_sum==0){
																echo "-";
															} else {
																echo number_format($achieve_sum-$purchase_sum);
															}
															$benefit_sum += $achieve_sum-$purchase_sum;
															?>
														</td>
											<?php } ?>
														<td class="money_td" align="right"><?php echo number_format($benefit_sum);?></td>
													</tr>

												</table>



									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div id="chart_div" style="width: 100%; height: 500px;"></div>
						</td>
					</tr>

				</tbody>
			</form>
		</table>
	</div>
</div>


<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--하단-->
<script>

	// get 값 가져오는 함수
	function getParam(sname) {
	  var params = location.search.substr(location.search.indexOf("?") + 1);
	  var sval = "";
	  params = params.split("&");
	  for (var i = 0; i < params.length; i++) {
	    temp = params[i].split("=");
	    if ([temp[0]] == sname) {
	      sval = temp[1];
	    }
	  }
	  return sval;
	}


  function detailView(){
		var mode = getParam('mode');

		if (mode == 'month'){
	    if($("#detail_view_month").val() == ""){
	      alert("해당월을 선택해주세요");
	      $("#detail_view_month").focus();
	      return false;
	    }else{
	      var year = $("#search1").val();
	      var month = $("#detail_view_month").val();
	      var company = $("#search2").val();

	      window.open("<?php echo site_url();?>/sales/funds/funds_list_detail_view/month?year="+year+"&month="+month+"&company="+company);
	    }
		} else {
			if($("#detail_view_division").val() == ""){
	      alert("해당분기를 선택해주세요");
	      $("#detail_view_division").focus();
	      return false;
	    }else{
	      var year = $("#search1").val();
	      var division = $("#detail_view_division").val();
	      var company = $("#search2").val();

	      window.open("<?php echo site_url();?>/sales/funds/funds_list_detail_view/division?year="+year+"&division="+division+"&company="+company);
	    }
		}
  }

	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawVisualization);

	function drawVisualization() {
		if ($("#month_tbl").is(":visible")){
			var chart_contents = [];

			// chart_contents.push(['Month', '경영계획', '달성(합계)', '이익']);
			for(var i=1;i<13;i++) {
				var content = [];
				var purpose = $.trim($("#m_purpose_"+i+"").text().replace(/,/g, ''));
				if (purpose=="-"){
					purpose=0;
				} else {
					purpose = Number(purpose);
				}
				var achieve = $.trim($("#m_achieve_"+i+"").text().replace(/,/g, ''));
				if (achieve=="-"){
					achieve=0;
				} else {
					achieve = Number(achieve);
				}
				var benefit = $.trim($("#m_benefit_"+i+"").text().replace(/,/g, ''));
				if (benefit=="-"){
					benefit=0;
				} else {
					benefit = Number(benefit);
				}
				content.push(i+"월",purpose,achieve,benefit);
				chart_contents.push(content);
			}


		} else if ($("#division_tbl").is(":visible")){
			var chart_contents = [];

			// chart_contents.push(['Division', '경영계획', '달성(합계)', '이익']);
			var j = 1;
			for(var i=1;i<13;i+=3) {
				var content = [];
				var purpose = $.trim($("#d_purpose_"+i+"").text().replace(/,/g, ''));
				if (purpose=="-"){
					purpose=0;
				} else {
					purpose = Number(purpose);
				}
				var achieve = $.trim($("#d_achieve_"+i+"").text().replace(/,/g, ''));
				if (achieve=="-"){
					achieve=0;
				} else {
					achieve = Number(achieve);
				}
				var benefit = $.trim($("#d_benefit_"+i+"").text().replace(/,/g, ''));
				if (benefit=="-"){
					benefit=0;
				} else {
					benefit = Number(benefit);
				}
				content.push(j+"분기",purpose,achieve,benefit);
				chart_contents.push(content);
				j++;
			}
		}
		console.log(chart_contents);

		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Month');
		data.addColumn('number', '경영계획');
		data.addColumn('number', '달성(합계)');
		data.addColumn('number', '이익');
		data.addRows(chart_contents);

		var t_year = $("#search1 option:selected").val();
		var t_company = $("#search2 option:selected").text();

		var options = {
			title : '<?php if($_GET['mode']=='month'){echo '월별';}else{echo '분기별';} ?> 매출현황 ('+t_company+'-'+t_year+')',
			seriesType: 'bars',
			series: {1: {type: 'line'},2: {type: 'line'}},
			legend: 'bottom',
			chartArea: {'width': '100%'},
               legend: {'position': 'bottom'}
		};

		var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
		chart.draw(data, options);
	}
</script>
</body>
</html>