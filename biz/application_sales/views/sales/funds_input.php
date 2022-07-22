<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
  <div class="dash1-1">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="width:95%">
			<form name="mform" action="<?php echo site_url();?>/sales/funds/funds_list" method="post" onkeydown="if(event.keyCode==13) return GoSearch();">
				<input type="hidden" name="seq" value="">
				<input type="hidden" name="mode" value="">
				<tbody>
					<tr height="5%">
			      <td class="dash_title">월별 매출현황</td>
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
										<select name="search2" id="search2" class="select-common" style="margin-right:10px;">
											<option value="0"> 업체 선택</option>
											<!-- <option value="IT" <?php //if($search2 == "IT"){ echo "selected";}?>>두리안정보기술</option> -->
											<option value="D_1" <?php if($search2 == "D_1"){ echo "selected";}?>>사업1부</option>
											<option value="D_2" <?php if($search2 == "D_2"){ echo "selected";}?>>사업2부</option>
											<option value="ICT" <?php if($search2 == "ICT"){ echo "selected";}?>>두리안정보통신기술</option>
											<option value="MG" <?php if($search2 == "MG"){ echo "selected";}?>>더망고</option>
										</select>
										<input type="button" class="btn-common btn-style2" onclick="return GoSearch();" value="검색">

										<input type="button" class="btn-common btn-color4" value="수정" onclick="return GoModify();" style="width:auto;float:right;vertical-align:middle;padding:0 10px">
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
												<table class="list_tbl list" width="100%" border="0" cellspacing="0" cellpadding="0">
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
													<tr class="t_top row-color1">
														<th></th>
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
														<th></th>
				                  </tr>

													<tr>
														<td></td>
				                    <td align="center" style="font-weight:bold;">목표</td>
														<?php for($i=1;$i<13;$i++){ ?>
					                    <td align="right">
																<input type="text" id="purpose_<?php echo $i ?>" name="purpose_<?php echo $i ?>" value="<?php echo number_format($item[0]['purpose_'.$i]);?>" class="input-common" style="width:90px;padding-left:5px;" onkeyup="number_comma(this);">
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

				</tbody>
			</form>
		</table>
	</div>
</div>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->


</body>
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
</html>
