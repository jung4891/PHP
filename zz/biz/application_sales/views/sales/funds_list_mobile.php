<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<body>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	  ?>
	<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
	<style>
	.menu_div {
		margin-top:10px;
		padding: 10px;
		border-bottom: thin #EFEFEF solid;
		overflow-x: scroll;
		white-space:nowrap;
	}
	.menu_div::-webkit-scrollbar {
		display: none;
	}
	.menu_list {
		cursor:pointer;margin:10px;font-weight:bold;font-size:15px;
	}
	.content_list {
		width:100%;
	 display: inline-block;
	 padding-bottom:20px;
	}
	.approval_list_tbl {
		padding-top: 20px;
		padding-left: 15px;
		padding-right:15px;
		border-spacing: 0 10px;
		table-layout: fixed;
	}
	.approval_list_tbl td {
		overflow:hidden;
		white-space : nowrap;
		text-overflow: ellipsis;
	}
	#paging_tbl {
		margin-top:10px;
		width:100%;
	}
	#paging_tbl a {
		font-size: 18px;
	}
	.input-common, .select-common, .btn-common {
		height: 35px !important;
		border-radius: 3px !important;
	}
	.dayBtn {
		background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
	</style>
	<link rel="stylesheet" href="/misc/css/view_page_common.css">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script language="javascript">
	function GoSearch() {
	  var year = document.mform.search1.value;
	  var company = document.mform.search1.value;
		var mode = "?mode=" + getParam('mode');

	  document.mform.action = "<?php echo site_url();?>/sales/funds/funds_list"+mode;
	  document.mform.submit();
	}

	function moveList(page){
     location.href="<?php echo site_url();?>/sales/funds/funds_list"+page;
  }
	</script>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  ?>

     <div class="menu_div">
   		<a class="menu_list" onclick ="moveList('?mode=month')" style='color:<?php if($_GET["mode"] == "month"){echo "#0575E6";} else {echo "#B0B0B0";} ?>'>월별매출현황</a>
   		<a class="menu_list" onclick ="moveList('?mode=division')" style='color:<?php if($_GET["mode"] == "division"){echo "#0575E6";} else {echo "#B0B0B0";} ?>'>분기별매출현황</a>
   	</div>
	<div style="width:90%;margin:0 auto;height:auto;">
		<?php
		if($search2 == 'IT'){
			$com = '두리안정보기술';
		} else if ($search2 == 'D_1') {
			$com = '사업1부';
		} else if ($search2 == 'D_2') {
			$com = '사업2부';
		} else if ($search2 == 'ICT') {
			$com = '두리안정보통신기술';
		} else if ($search2 == 'MG') {
			$com = '더망고';
		} ?>
		<p style="font-weight:bold; font-size:16px;line-height:10px;"><?php echo $com.'-'.$search1;; ?></p>
		<p style="line-height:10px;height:auto;"><span style="color:red;margin-right:5px;">*</span><?php echo $title; ?> 검색 시 우측 하단에 검색 아이콘을 눌러주세요.</p>
		<div id="chart_div" style="width: 100%; height: 200px;margin:0 auto;"></div>
	</div>
	<div style="width:100%;border-bottom:thin #DEDEDE solid;margin-top:10px;">
		<div style="width:90%;margin:0 auto;height:30px;">
			<span style="color:#626262">합계(년): </span>
			<span id="total_benefit" style="color:#0575E6;font-size:16px;font-weight:bold;"></span>
		</div>
	</div>
	<div class="content_list" style="padding-bottom:60px;">
		<table class="approval_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="50%">
				<col width="50%">
			</colgroup>
			<tbody id="month_tbl" style="<?php if($_GET['mode']=='division'){echo 'display:none';} ?>">
<?php $benefit_sum = 0; ?>
<?php for($i=1; $i<13; $i++) { ?>
				<tr>
					<td align="left" colspan="2" style="height:40px;font-size:16px;color:#1C1C1C;font-weight:bold;"><?php echo $i; ?>월</td>
				</tr>
				<tr>
					<td align="left" style="color:#828282;">목표</td>
					<td align="right" style="color:#1C1C1C;font-weight:bold;" id="m_purpose_<?php echo $i; ?>"><?php echo number_format($item[0]['purpose_'.$i]); ?></td>
				</tr>
<?php
$achieve_sum = $forcasting["sale"][$i][0]['sum']+$forcasting["service"][$i][0]['sum']+$forcasting["support"][$i][0]['sum']+$maintain[$i][0]['sum'];
$purpose = $item[0]['purpose_'.$i];
?>
				<tr>
					<td align="left" style="color:#828282;">달성율(%)</td>
					<td align="right" style="color:#1C1C1C;font-weight:bold;">
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
<?php
$achieve_sum = $forcasting["sale"][$i][0]['sum']+$forcasting["service"][$i][0]['sum']+$forcasting["support"][$i][0]['sum']+$maintain[$i][0]['sum'];
?>
					<td class="money_td" align="right" id="m_achieve_<?php echo $i; ?>" style="display:none;">
						<?php
						if ($achieve_sum==0){
							echo "-";
						} else {
							echo number_format($achieve_sum);
						}
						 ?>
					</td>
				</tr>
				<tr>
					<td align="left" style="color:#828282;">매입</td>
					<td align="right" style="color:#FF4747;font-weight:bold;">
						<?php
						if($purchase_forcasting[$i][0]['sum']+$purchase_maintain[$i][0]['sum']+$purchase_request[$i][0]['sum']==0){
							echo "-";
						}else{
							echo number_format($purchase_forcasting[$i][0]['sum']+$purchase_maintain[$i][0]['sum']+$purchase_request[$i][0]['sum']);
						}
						?>
					</td>
				</tr>
				<tr>
					<td align="left" style="color:#828282;">이익</td>
					<td align="right" style="color:#379BFF;font-weight:bold;" id="m_benefit_<?php echo $i; ?>">
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
				</tr>
<?php } ?>
			</tbody>


			<tbody id="division_tbl" style="<?php if($_GET['mode']=='month'){echo 'display:none';} ?>">
<?php $benefit_sum = 0; $j=1;?>
<?php for($i=1;$i<13;$i+=3){ ?>
				<tr>
					<td align="left" colspan="2" style="height:40px;font-size:16px;color:#1C1C1C;font-weight:bold;"><?php echo $j;$j++; ?>분기</td>
				</tr>
				<tr>
					<td align="left" style="color:#828282;">목표</td>
					<td align="right" style="color:#1C1C1C;font-weight:bold;" id="d_purpose_<?php echo $i; ?>"><?php echo number_format($item[0]['purpose_'.$i]+$item[0]['purpose_'.($i+1)]+$item[0]['purpose_'.($i+2)]);?></td>
				</tr>
<?php
$sale_sum = $forcasting["sale"][$i][0]['sum'] + $forcasting["sale"][$i+1][0]['sum'] + $forcasting["sale"][$i+2][0]['sum'];

$service_sum = $forcasting["service"][$i][0]['sum'] + $forcasting["service"][$i+1][0]['sum'] + $forcasting["service"][$i+2][0]['sum'];

$support_sum = $forcasting["support"][$i][0]['sum'] + $forcasting["support"][$i+1][0]['sum'] + $forcasting["support"][$i+2][0]['sum'];

$maintain_sum = $maintain[$i][0]['sum'] + $maintain[$i+1][0]['sum'] + $maintain[$i+2][0]['sum'];

$achieve_sum = $sale_sum + $service_sum + $support_sum + $maintain_sum;
$purpose = $item[0]['purpose_'.$i]+$item[0]['purpose_'.($i+1)]+$item[0]['purpose_'.($i+2)];
?>
				<tr>
					<td align="left" style="color:#828282;">달성율(%)</td>
					<td align="right" style="color:#1C1C1C;font-weight:bold;">
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
<?php
$sale_sum = $forcasting["sale"][$i][0]['sum'] + $forcasting["sale"][$i+1][0]['sum'] + $forcasting["sale"][$i+2][0]['sum'];

$service_sum = $forcasting["service"][$i][0]['sum'] + $forcasting["service"][$i+1][0]['sum'] + $forcasting["service"][$i+2][0]['sum'];

$support_sum = $forcasting["support"][$i][0]['sum'] + $forcasting["support"][$i+1][0]['sum'] + $forcasting["support"][$i+2][0]['sum'];

$maintain_sum = $maintain[$i][0]['sum'] + $maintain[$i+1][0]['sum'] + $maintain[$i+2][0]['sum'];

$total_sum = $sale_sum + $service_sum + $support_sum + $maintain_sum;
?>
					<td class="money_td" align="right" id="d_achieve_<?php echo $i; ?>" style="display:none;">
						<?php
						if ($total_sum==0){
							echo "-";
						} else {
							echo number_format($total_sum);
						}
						 ?>
					</td>
				</tr>
				<tr>
					<td align="left" style="color:#828282;">매입</td>
					<td align="right" style="color:#FF4747;font-weight:bold;">
						<?php
						$sum_forcasting = $purchase_forcasting[$i][0]['sum'] + $purchase_forcasting[$i+1][0]['sum'] + $purchase_forcasting[$i+2][0]['sum'];
						$sum_maintain = $purchase_maintain[$i][0]['sum'] + $purchase_maintain[$i+1][0]['sum'] + $purchase_maintain[$i+2][0]['sum'];
						$sum_request = $purchase_request[$i][0]['sum'] + $purchase_request[$i+1][0]['sum'] + $purchase_request[$i+2][0]['sum'];

						if($sum_forcasting+$sum_maintain==0){
							echo "-";
						}else{
							echo number_format($sum_forcasting+$sum_maintain+$sum_request);
						}
						?>
					</td>
				</tr>
				<tr>
					<td align="left" style="color:#828282;">이익</td>
					<td align="right" style="color:#379BFF;font-weight:bold;" id="d_benefit_<?php echo $i; ?>">
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
				</tr>
<?php } ?>
			</tbody>
		</table>
	</div>

	<!-- 검색 모달 시작 -->
  <div id="search_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:16px; color:#1C1C1C;font-weight:bold;">
			<form name="mform" method="post" onkeydown="if(event.keyCode==13) return GoSearch();">
	      <table style="width:100%;padding:5%;" cellspacing="0">
					<colgroup>
						<col width="50%">
						<col width="50%">
					</colgroup>
					<tr>
	      		<td align="left" height="40">
							<select class="select-common" name="search1" id="search1" style="margin-right:10px;color:black;width:92%;">
	              <option  option value="0"> 연도 선택</option>
								<?php
								$year = date("Y");
								for($i=2019;$i<$year+3;$i++){ ?>
									<option value="<?php echo $i; ?>" <?php if($search1 == $i){ echo "selected";}?>><?php echo $i; ?></option>
								<?php } ?>
							</select>
						</td>
						<td align="left" height="40">
							<select class="select-common" name="search2" id="search2" style="margin-right:10px;color:black;width:92%;">
								<option value="0"> 업체 선택</option>
								<option value="IT" <?php if($search2 == "IT"){ echo "selected";}?>>두리안정보기술</option>
								<option value="D_1" <?php if($search2 == "D_1"){ echo "selected";}?>>사업1부</option>
								<option value="D_2" <?php if($search2 == "D_2"){ echo "selected";}?>>사업2부</option>
								<option value="ICT" <?php if($search2 == "ICT"){ echo "selected";}?>>두리안정보통신기술</option>
								<option value="MG" <?php if($search2 == "MG"){ echo "selected";}?>>더망고</option>
							</select>
						</td>
	      	</tr>
					<tr>
	          <td height="20"></td>
	        </tr>
					<tr>
						<td>
							<input type="button" class="btn-common btn-color1" style="width:95%" value="취소" onclick="$('#search_div').bPopup().close();">
						</td>
						<td align="right">
							<input type="button" class="btn-common btn-color2" style="width:95%" value="검색" onclick="return GoSearch();">
						</td>
					</tr>
	      </table>
			</form>
    </div>
  </div>
	<!-- 검색 모달 끝 -->
	<div style="width:90%;margin:0 auto;margin-bottom:10px;">
    <?php if($tech_lv == 3) { ?>
			<!-- <a href="<?php echo site_url();?>/tech/board/manual_input"> -->
				<!-- <input style="width:100%" type="button" class="btn-common btn-color2" value="글쓰기"> -->
			<!-- </a> -->
    <?php } ?>
	</div>
	<div id="top_btn" style="position:fixed;bottom:100px;right:5px;">
			<img src="<?php echo $misc; ?>img/mobile/btn_top.svg" onclick="$('html').scrollTop(0);">
	</div>
	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>
	<script>
	$(function() {
		$("#top_btn").draggable();
	})
	function open_search() {
		$('#search_div').bPopup();
	}
	$(window).bind("pageshow", function(event) {
		if (event.originalEvent.persisted) {
				document.location.reload();
		}
	});

	$('#total_benefit').text('<?php echo number_format($benefit_sum); ?>')

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
				// title : t_company+'-'+t_year,
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
