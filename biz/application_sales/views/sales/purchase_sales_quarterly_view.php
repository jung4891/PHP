<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script type="text/javascript" src="/misc/js/excel/jquery.table2excel.js"></script>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<style media="screen">
	.list_tbl th {
		background-color:#DEDEDE;
		text-align:center;
		font-weight: bold;
	}
	.list_tbl td {
		text-align:center;
	}
	.money {
		text-align:right !important;
		padding-right: 20px;
	}
	.boundary {
		border-left: thin solid #DFDFDF;
	}
</style>
<body>
  <?php
    include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
  ?>
	<div class="dash1-1" align="center">
		<div>
      <table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
		    <tr height="5%">
        	<td class="dash_title">
          	분기별 매입매출장
          </td>
        </tr>
        <tr>
          <td height="70"></td>
        </tr>
      </table>
		</div>

		<div style="margin-bottom:30px;">
			<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
				<tr style="width:100%;">
					<td style="width:50%;">
						<form class="month_form" name="month_form" action="<?php echo site_url();?>/sales/purchase_sales/quarterly_purchase_sales_view" method="get">
							<?php
							if(isset($_GET['dept_code'])){
								$dept_code = $_GET['dept_code'];
							} else {
								$dept_code = 'DUIT';
							}
								?>
							<select class="select-common" id="dept_code" name="dept_code" style="width:150px;">
								<option value="DUIT" <?php if($dept_code=='DUIT'){echo 'selected';} ?>>두리안정보기술</option>
								<option value="DBS" <?php if($dept_code=='DBS'){echo 'selected';} ?>>두리안정보기술 부산지점</option>
								<option value="ICT" <?php if($dept_code=='ICT'){echo 'selected';} ?>>두리안정보통신기술</option>
								<option value="MG" <?php if($dept_code=='MG'){echo 'selected';} ?>>더망고</option>
							</select>
							<select class="select-common" id="year" name="year">
							<?php
							if(isset($_GET['year'])){
								$year = $_GET['year'];
							} else {
								$year = date("Y");
							}
								for($i=2019;$i<$year+3;$i++){
								?>
									<option value="<?php echo $i; ?>" <?php if($year == $i){echo 'selected';} ?>><?php echo $i; ?></option>
							<?php } ?>
							</select>
							<?php
							if(isset($_GET['quarter'])){
								$quarter = $_GET['quarter'];
							} else {
								if(date("m") < 4){$quarter=1;}
								if(date("m") > 3 && date("m") < 7){$quarter=2;}
								if(date("m") > 6 && date("m") < 10){$quarter=3;}
								if(date("m") > 9){$quarter=4;}
							}
							 ?>
							<select class="select-common" id="quarter" name="quarter">
								<option value="1" <?php if($quarter==1){echo 'selected';} ?>>1분기</option>
								<option value="2" <?php if($quarter==2){echo 'selected';} ?>>2분기</option>
								<option value="3" <?php if($quarter==3){echo 'selected';} ?>>3분기</option>
								<option value="4" <?php if($quarter==4){echo 'selected';} ?>>4분기</option>
							</select>
							<input class="btn-common btn-style1" type="submit" value="검색" >
						</form>
					</td>
					<td style="width:50%; text-align:right;">
            <!-- <img src="<?php echo $misc; ?>/img/dashboard/btn/excel_download.png" alt="" style="margin-right: 5%; cursor: pointer;" onclick="excel_export();"> -->
            <input class="btn-common btn-color1" type="button" onclick="excel_export();" value="excel_download" style="width:150px;">
          </td>
				</tr>
			</table>
		</div>

		<div style="margin-bottom:50px;">
      <table id="total_tbl" class="list_tbl" cellspacing=0 cellpadding=0 width="95%">
        <colgroup>
          <col width="6.2%" /><!-- 구분-->
          <col width="9%" /> <!-- 공급가액-->
          <col width="9%" /> <!-- 세액-->
          <col width="9%" /> <!-- 합계 -->
          <col width="6%" /> <!-- 구분 -->
          <col width="5.3%" /> <!--국세청전송건수-->
          <col width="6%" /> <!--구분-->
          <col width="5.3%" /> <!--국세청전송건수-->
          <col width="6%" /> <!--구분-->
          <col width="9%" /> <!--공급가액-->
          <col width="9%" /> <!--세액-->
          <col width="9%" /> <!-- 합계 -->
          <col width="6%" /> <!--구분-->
          <col width="5.3%" /> <!--국세청전송건수-->
        </colgroup>
        <thead>
          <tr>
            <!-- type 002 -->
            <th colspan="8">매입(<?php echo $quarter; ?>분기)</th>
            <th></th>
            <!-- type 001 -->
            <th colspan="6">매출(<?php echo $quarter; ?>분기)</th>
          </tr>
          <tr style="font-weight:bold;">
            <td class="row-color6">구분</td>
            <td class="row-color6">공급가액</td>
            <td class="row-color6">세액</td>
            <td class="row-color6">합계</td>
            <td class="row-color6">구분</td>
            <td class="row-color6">국세청 전송건수</td>
            <td class="row-color6">구분</td>
            <td class="row-color6">국세청 전송건수</td>
            <td class="row-color6 boundary">구분</td>
            <td class="row-color6">공급가액</td>
            <td class="row-color6">세액</td>
            <td class="row-color6">합계</td>
            <td class="row-color6">구분</td>
            <td class="row-color6">국세청 전송건수</td>
          </tr>
        </thead>
        <tbody>
					<tr>
						<td>상품매입</td>
						<td class="money total" id="purchase_product_bill" name="p_bill">0</td>
						<td class="money total" id="purchase_product_tax" name="p_tax">0</td>
						<td class="money total" id="purchase_product_total" name="p_total">0</td>
						<td>상품매입</td>
						<td class="money total" id="purchase_product_count">0</td>
						<td>전자계산서</td>
						<td class="money total" id="purchase_operation_electronic_bill_type">0</td>
						<td class="boundary">상품매출</td>
						<td class="money total" id="sales_product_bill" name="s_bill">0</td>
						<td class="money total" id="sales_product_tax" name="s_tax">0</td>
						<td class="money total" id="sales_product_total" name="s_total">0</td>
						<td>상품매출</td>
						<td class="money" id="sales_product_count">0</td>
					</tr>
					<tr>
						<td>용역매입</td>
						<td class="money total" id="purchase_service_bill" name="p_bill">0</td>
						<td class="money total" id="purchase_service_tax" name="p_tax">0</td>
						<td class="money total" id="purchase_service_total" name="p_total">0</td>
						<td>용역매입</td>
						<td class="money" id="purchase_service_count">0</td>
						<td>종이계산서</td>
						<td class="money" id="sales_operation_paper_bill_type">0</td>
						<td class="boundary">용역매출</td>
						<td class="money total" id="sales_service_bill" name="s_bill">0</td>
						<td class="money total" id="sales_service_tax" name="s_tax">0</td>
						<td class="money total" id="sales_service_total" name="s_total">0</td>
						<td>용역매출</td>
						<td class="money" id="sales_service_count">0</td>
					</tr>
					<tr>
						<td>조달매입</td>
						<td class="money total" id="purchase_support_bill" name="p_bill">0</td>
						<td class="money total" id="purchase_support_tax" name="p_tax">0</td>
						<td class="money total" id="purchase_support_total" name="p_total">0</td>
						<td>조달매입</td>
						<td class="money" id="purchase_support_count">0</td>
						<td></td>
						<td></td>
						<td class="boundary">조달매출</td>
						<td class="money total" id="sales_support_bill" name="s_bill">0</td>
						<td class="money total" id="sales_support_tax" name="s_tax">0</td>
						<td class="money total" id="sales_support_total" name="s_total">0</td>
						<td>조달매출</td>
						<td class="money" id="sales_support_count">0</td>
					</tr>
					<tr>
						<td>운영비</td>
						<td class="money total" id="purchase_operation_bill" name="p_bill">0</td>
						<td class="money total" id="purchase_operation_tax" name="p_tax">0</td>
						<td class="money total" id="purchase_operation_total" name="p_total">0</td>
						<td>운영비</td>
						<td class="money" id="purchase_operation_count">0</td>
						<td></td>
						<td></td>
						<td class="boundary">운영비</td>
						<td class="money total" id="sales_operation_bill" name="s_bill">0</td>
						<td class="money total" id="sales_operation_tax" name="s_tax">0</td>
						<td class="money total" id="sales_operation_total" name="s_total">0</td>
						<td>운영비</td>
						<td class="money" id="sales_operation_count">0</td>
					</tr>
          <tr class="">
            <td class="row-color4">매입액</td>
            <td class="row-color4" id="p_bill" style="text-align:right;padding-right:20px;"></td>
            <td class="row-color4" id="p_tax" style="text-align:right;padding-right:20px;"></td>
            <td class="row-color4" id="p_total" style="text-align:right;padding-right:20px;"></td>
            <td colspan="4" class="row-color4"></td>
            <td class="row-color3 boundary">매출액</td>
            <td class="row-color3" id="s_bill" style="text-align:right;padding-right:20px;"></td>
            <td class="row-color3" id="s_tax" style="text-align:right;padding-right:20px;"></td>
            <td class="row-color3" id="s_total" style="text-align:right;padding-right:20px;"></td>
            <td colspan="2" class="row-color3"></td>
          </tr>
        </tbody>
      </table>
    </div>


<?php
$j = 2;
			for($i=0; $i<3; $i++){
				$sum_purchase_bill = $sum_purchase_tax = $sum_purchase_total = $sum_sales_bill = $sum_sales_tax = $sum_sales_total = 0;
	?>

    <div style="margin-bottom:50px;">
      <table id="month_tbl_<?php echo $i; ?>" class="list_tbl" cellspacing=0 cellpadding=0 width="95%">
        <colgroup>
          <col width="6.2%" /><!-- 구분-->
          <col width="9%" /> <!-- 공급가액-->
          <col width="9%" /> <!-- 세액-->
          <col width="9%" /> <!-- 합계 -->
          <col width="6%" /> <!-- 구분 -->
          <col width="5.3%" /> <!--국세청전송건수-->
          <col width="6%" /> <!--구분-->
          <col width="5.3%" /> <!--국세청전송건수-->
          <col width="6%" /> <!--구분-->
          <col width="9%" /> <!--공급가액-->
          <col width="9%" /> <!--세액-->
          <col width="9%" /> <!-- 합계 -->
          <col width="6%" /> <!--구분-->
          <col width="5.3%" /> <!--국세청전송건수-->
        </colgroup>
        <thead>
          <tr>
            <!-- type 002 -->
            <th colspan="8">매입(<?php echo $quarter * 3 - $j;$j--; ?>월)</th>
            <th></th>
            <!-- type 001 -->
            <th colspan="6">매출(분기)</th>
          </tr>
          <tr style="font-weight:bold;">
            <td class="row-color6">구분</td>
            <td class="row-color6">공급가액</td>
            <td class="row-color6">세액</td>
            <td class="row-color6">합계</td>
            <td class="row-color6">구분</td>
            <td class="row-color6">국세청 전송건수</td>
            <td class="row-color6">구분</td>
            <td class="row-color6">국세청 전송건수</td>
            <td class="row-color6 boundary">구분</td>
            <td class="row-color6">공급가액</td>
            <td class="row-color6">세액</td>
            <td class="row-color6">합계</td>
            <td class="row-color6">구분</td>
            <td class="row-color6">국세청 전송건수</td>
          </tr>
        </thead>
        <tbody>
					<tr>
						<td>상품매입</td>
						<td class="money" name="purchase_product_bill">
							<?php
							echo number_format($product[$i]['purchase_product_bill']);
							$sum_purchase_bill += $product[$i]['purchase_product_bill'];
							?>
						</td>
						<td class="money" name="purchase_product_tax">
							<?php
							echo number_format($product[$i]['purchase_product_tax']);
							$sum_purchase_tax += $product[$i]['purchase_product_tax'];
							?>
						</td>
						<td class="money" name="purchase_product_total">
							<?php
							echo number_format($product[$i]['purchase_product_total']);
							$sum_purchase_total += $product[$i]['purchase_product_total'];
						?></td>
						<td>상품매입</td>
						<td class="money" name="purchase_product_count"><?php echo number_format($product[$i]['purchase_product_count']); ?></td>
						<td>전자계산서</td>
						<td class="money" name="purchase_operation_electronic_bill_type"><?php echo number_format($operation[$i]['purchase_operation_electronic_bill_type']); ?></td>
						<td class="boundary">상품매출</td>
						<td class="money" name="sales_product_bill">
							<?php
							echo number_format($product[$i]['sales_product_bill']);
							$sum_sales_bill += $product[$i]['sales_product_bill'];
							?>
						</td>
						<td class="money" name="sales_product_tax">
							<?php
							echo number_format($product[$i]['sales_product_tax']);
							$sum_sales_tax += $product[$i]['sales_product_tax'];
							?>
						</td>
						<td class="money" name="sales_product_total">
							<?php
							echo number_format($product[$i]['sales_product_total']);
							$sum_sales_total += $product[$i]['sales_product_total'];
							?>
						</td>
						<td>상품매출</td>
						<td class="money" name="sales_product_count"><?php echo number_format($product[$i]['sales_product_count']); ?></td>
					</tr>
					<tr>
						<td>용역매입</td>
						<td class="money" name="purchase_service_bill">
							<?php
							echo number_format($maintain[$i]['purchase_service_bill']);
							$sum_purchase_bill += $maintain[$i]['purchase_service_bill'];
							?>
						</td>
						<td class="money" name="purchase_service_tax">
							<?php
							echo number_format($maintain[$i]['purchase_service_tax']);
							$sum_purchase_tax += $maintain[$i]['purchase_service_tax'];
							?>
						</td>
						<td class="money" name="purchase_service_total">
							<?php
							echo number_format($maintain[$i]['purchase_service_total']);
							$sum_purchase_total += $maintain[$i]['purchase_service_total'];
							?>
						</td>
						<td>용역매입</td>
						<td class="money" name="purchase_service_count"><?php echo number_format($maintain[$i]['purchase_service_count']); ?></td>
						<td>종이계산서</td>
						<td class="money" name="sales_operation_paper_bill_type"><?php echo number_format($operation[$i]['sales_operation_paper_bill_type']); ?></td>
						<td class="boundary">용역매출</td>
						<td class="money" name="sales_service_bill">
							<?php
							echo number_format($maintain[$i]['sales_service_bill']);
							$sum_sales_bill += $maintain[$i]['sales_service_bill'];
							?>
						</td>
						<td class="money" name="sales_service_tax">
							<?php
							echo number_format($maintain[$i]['sales_service_tax']);
							$sum_sales_tax += $maintain[$i]['sales_service_tax'];
							?>
						</td>
						<td class="money" name="sales_service_total">
							<?php
							echo number_format($maintain[$i]['sales_service_total']);
							$sum_sales_total += $maintain[$i]['sales_service_total'];
							?>
						</td>
						<td>용역매출</td>
						<td class="money" name="sales_service_count"><?php echo number_format($maintain[$i]['sales_service_count']); ?></td>
					</tr>
					<tr>
						<td>조달매입</td>
						<td class="money" name="purchase_support_bill">
							<?php
							echo number_format($support[$i]['purchase_support_bill']);
							$sum_purchase_bill += $support[$i]['purchase_support_bill'];
							?>
						</td>
						<td class="money" name="purchase_support_tax">
							<?php
							echo number_format($support[$i]['purchase_support_tax']);
							$sum_purchase_tax += $support[$i]['purchase_support_tax'];
							?>
						</td>
						<td class="money" name="purchase_support_total">
							<?php
							echo number_format($support[$i]['purchase_support_total']);
							$sum_purchase_total += $support[$i]['purchase_support_total'];
							?>
						</td>
						<td>조달매입</td>
						<td class="money" name="purchase_support_count"><?php echo number_format($support[$i]['purchase_support_count']); ?></td>
						<td></td>
						<td></td>
						<td class="boundary">조달매출</td>
						<td class="money" name="sales_support_bill">
							<?php
							echo number_format($support[$i]['sales_support_bill']);
							$sum_sales_bill += $support[$i]['sales_support_bill'];
							?>
						</td>
						<td class="money" name="sales_support_tax">
							<?php
							echo number_format($support[$i]['sales_support_tax']);
							$sum_sales_tax += $support[$i]['sales_support_tax'];
							?>
						</td>
						<td class="money" name="sales_support_total">
							<?php
							echo number_format($support[$i]['sales_support_total']);
							$sum_sales_total += $support[$i]['sales_support_total'];
							?>
						</td>
						<td>조달매출</td>
						<td class="money" name="sales_support_count"><?php echo number_format($support[$i]['sales_support_count']); ?></td>
					</tr>
					<tr>
						<td>운영비</td>
						<td class="money" name="purchase_operation_bill">
							<?php
							echo number_format($operation[$i]['purchase_operation_bill']);
							$sum_purchase_bill += $operation[$i]['purchase_operation_bill'];
							?>
						</td>
						<td class="money" name="purchase_operation_tax">
							<?php
							echo number_format($operation[$i]['purchase_operation_tax']);
							$sum_purchase_tax += $operation[$i]['purchase_operation_tax'];
							?>
						</td>
						<td class="money" name="purchase_operation_total">
							<?php
							echo number_format($operation[$i]['purchase_operation_total']);
							$sum_purchase_total += $operation[$i]['purchase_operation_total'];
							?>
						</td>
						<td>운영비</td>
						<td class="money" name="purchase_operation_count"><?php echo number_format($operation[$i]['purchase_operation_count']); ?></td>
						<td></td>
						<td></td>
						<td class="boundary">운영비</td>
						<td class="money" name="sales_operation_bill">
							<?php
							echo number_format($operation[$i]['sales_operation_bill']);
							$sum_sales_bill += $operation[$i]['sales_operation_bill'];
							?>
						</td>
						<td class="money" name="sales_operation_tax">
							<?php
							echo number_format($operation[$i]['sales_operation_tax']);
							$sum_sales_tax += $operation[$i]['sales_operation_tax'];
							?>
						</td>
						<td class="money" name="sales_operation_total">
							<?php
							echo number_format($operation[$i]['sales_operation_total']);
							$sum_sales_total += $operation[$i]['sales_operation_total'];
							?>
						</td>
						<td>운영비</td>
						<td class="money" name="sales_operation_count"><?php echo number_format($operation[$i]['sales_operation_count']); ?></td>
					</tr>

          <tr class="">
            <td class="row-color4">매입액</td>
            <td class="row-color4" style="text-align:right;padding-right:20px;"><?php echo number_format($sum_purchase_bill); ?></td>
            <td class="row-color4" style="text-align:right;padding-right:20px;"><?php echo number_format($sum_purchase_tax); ?></td>
            <td class="row-color4" style="text-align:right;padding-right:20px;"><?php echo number_format($sum_purchase_total); ?></td>
            <td colspan="4" class="row-color4"></td>
            <td class="row-color3 boundary">매출액</td>
            <td class="row-color3" style="text-align:right;padding-right:20px;"><?php echo number_format($sum_sales_bill); ?></td>
            <td class="row-color3" style="text-align:right;padding-right:20px;"><?php echo number_format($sum_sales_tax); ?></td>
            <td class="row-color3" style="text-align:right;padding-right:20px;"><?php echo number_format($sum_sales_total); ?></td>
            <td colspan="2" class="row-color3"></td>
          </tr>
        </tbody>
      </table>
    </div>

<?php } ?>

	</div>

	<!-- excel export table -->
	<div class="excel_div" style="display:none;">
		<table class="excel_table">

		</table>
	</div>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--하단-->
<script>


	var cnt = $('.money').length;

	$(".money").each(function() {
		var name = $(this).attr('name');
		if(name!=undefined){
			var t = deCommaStr($('#'+name).text());
			t += Number(deCommaStr($(this).text()));
			$('#'+name).text(commaStr(t));
		}
		cnt--;
		if(cnt==0){
			sum_total();
		}
	})

	function sum_total() {
		$('.total').each(function() {
			var name = $(this).attr('name');
			if(name!=undefined){
				console.log(name);
				var t = deCommaStr($('#'+name).text());
				t += Number(deCommaStr($(this).text()));
				$('#'+name).text(commaStr(t));
			}
		})
	}

	// 금액 부분 콤마 추가
	function commaStr(n) {
	  var reg = /(^[+-]?\d+)(\d{3})/;
	  n += "";

	  while (reg.test(n))
	    n = n.replace(reg, "$1" + "," + "$2");
	  return n;
	}

	// 금액 부분 콤마 제거
	function deCommaStr(comma_num) { //콤마가 붙은 숫자값을 파라미터로 받아오기
		var text = comma_num.toString().replace(/,/g, ""); //값을 문자열로 변경해서 replace로 콤마제거(문자열만 replace가능)
		var num = Number(text); //문자열을 숫자로 변경
		return num;
	}

	$(document).ready(function(){
		//excel_table
		$('.excel_table').html(''); //엑셀 출력용 테이블을 비워놓기(분기를 바꿀 때마다 테이블이 중첩되지 않도록)
		excel_table();
	});

	// excel_table
	function excel_table(){
		// $(document).ready(function () {
		var excel_download_table = $("#total_tbl").html();

		for (i=0;i<3;i++){
			excel_download_table += '<br><br>' + $("#month_tbl_"+i).html();
		}

		// console.log(excel_download_table);

		$(".excel_table").append(excel_download_table);
		// console.log($(".excel_table").html());
		// });
	};


	function excel_export(){

		var date = '<?php echo $year; ?>' + '년 ' + '<?php echo $quarter; ?>' + '분기';
		var dept = '<?php echo $dept_code; ?>';
		if(dept == 'DUIT'){
			var company = '두리안정보기술 ';
		}else if(dept == 'DBS'){
			var company = '두리안정보기술 부산지점 ';
		}else if(dept == 'ICT'){
			var company = '두리안정보통신기술 ';
		}else if(dept == 'MG'){
			var company = '더망고 ';
		}
		var title = company + date;

		var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
		tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
		tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
		tab_text = tab_text + '<x:Name>'+title+'</x:Name>';
		tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
		tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
		tab_text = tab_text + "<table border='1px'>";

		var exportTable = $('.excel_table').clone();
		exportTable.find('td').css('font-size','15px');
		exportTable.find('.parents_div').prop('font-size','15px');
		exportTable.find('.child_div').prop('font-size','15px');
		exportTable.find('.child_div2').prop('font-size','15px');
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
</script>
</body>
</html>
