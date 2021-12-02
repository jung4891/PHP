<?php

	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

//print_r($_POST);

?>
<link rel="stylesheet" href="/misc/css/dashboard.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<script language="javascript">


function GoSearch(){
	var year = document.mform.search1.value;
	var company = document.mform.search1.value;

	document.mform.action = "<?php echo site_url();?>/sales/funds/funds_input";
	document.mform.submit();
}

function number_comma(el) {
	x = $(el).val().replace(/[^0-9]/g,'');
	x = x.replace(/,/g,'');
	$(el).val(x.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
}
</script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>

<div align="center">
	<div class="dash1-1">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<form name="mform" action="<?php echo site_url();?>/sales/funds/funds_list" method="post" onkeydown="if(event.keyCode==13) return GoSearch();">
				<input type="hidden" name="seq" value="">
				<input type="hidden" name="mode" value="">
				<tbody>
					<tr height="5%">
						<td class="dash_title">
							<img src="<?php echo $misc; ?>img/dashboard/title_fund_month.png"/>
						</td>
					</tr>
					<!-- 검색창 -->
					<tr height="10%">
						<td align="left" valign="bottom">
							<table border="0" cellspacing="0" cellpadding="0" width="100%">
								<tr>
									<td>
										<select name="search1" id="search1" class="select7">
											<option  option value="0"> 연도 선택</option>
											<?php
											$year = date("Y");
											for($i=2019;$i<$year+3;$i++){ ?>
												<option value="<?php echo $i; ?>" <?php if($search1 == $i){ echo "selected";}?>><?php echo $i; ?></option>
											<?php } ?>
										</select>
										<select name="search2" id="search2" class="select7" style="width:150px">
											<option value="0"> 업체 선택</option>
											<!-- <option value="IT" <?php //if($search2 == "IT"){ echo "selected";}?>>두리안정보기술</option> -->
											<option value="D_1" <?php if($search2 == "D_1"){ echo "selected";}?>>사업1부</option>
											<option value="D_2" <?php if($search2 == "D_2"){ echo "selected";}?>>사업2부</option>
											<option value="ICT" <?php if($search2 == "ICT"){ echo "selected";}?>>두리안정보통신기술</option>
											<option value="MG" <?php if($search2 == "MG"){ echo "selected";}?>>더망고</option>
										</select>
										<input type="image" style='cursor:hand;vertical-align:middle' onclick="return GoSearch();" src="<?php echo $misc;?>img/btn_search.jpg" align="middle" border="0" />
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2" valign="top" style="padding:10px 0px;height:10px;">
							<table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<colgroup>
														<col width="5%" />
														<col width="3.6%" /> <!-- 연 -->
				                    <col width="7.2%" /> <!-- 1 -->
				                    <col width="7.2%" /> <!-- 2  -->
				                    <col width="7.2%" /> <!-- 3  -->
				                    <col width="7.2%" /> <!-- 4 -->
				                    <col width="7.2%" /> <!-- 5 -->
				                    <col width="7.2%" /> <!-- 6 -->
				                    <col width="7.2%" /> <!-- 7 -->
				                    <col width="7.2%" /> <!-- 8 -->
				                    <col width="7.2%" /> <!-- 9 -->
				                    <col width="7.2%" /> <!--10 -->
				                    <col width="7.2%" /> <!--11 -->
				                    <col width="7.2%" /> <!--12 -->
														<col width="5%" />
													</colgroup>
													<tr class="t_top">
														<th></th>
				                    <th align="center">월</th>
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
														<th></th>
				                  </tr>

													<tr>
														<td></td>
				                    <td align="center">목표</td>
														<?php for($i=1;$i<13;$i++){ ?>
					                    <td align="right">
																<input type="text" id="purpose_<?php echo $i ?>" name="purpose_<?php echo $i ?>" value="<?php echo number_format($item[0]['purpose_'.$i]);?>" class="input2" style="width:90px" onkeyup="number_comma(this);">
															</td>
														<?php } ?>
														<td></td>
				                  </tr>
												</table>
<script language="javascript">

function GoModify(){

	document.mform.action = "<?php echo site_url();?>/sales/funds/funds_input_action";

	document.mform.submit();
}
</script>
											</td>
										</tr>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="center"><img src="<?php echo $misc;?>img/dashboard/btn/btn_adjust.png" onclick="return GoModify();"width="64" height="31" /></a></td>
					</tr>

				</tbody>

			</form>
		</table>
	</div>
</div>

<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--하단-->
</body>
</html>
