<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/dashboard.css">
<style>
.dash_tbl1-1{
  margin:20px;
  display:grid;
}

.contents_tbl{
  width: 95%;
  border-color:black;
  border-style:solid;
  border-width:1px;
  text-align:center;
}

.contents_tbl th{
  font-size: 16px;
}

</style>
<body>
  <?php
    include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
  ?>

  <!-- <div align="center"> -->
  	<div class="dash_tbl1-1" align="center">
  		<div><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
        <tr height="5%">
          <td class="dash_title">
            <img src="<?php echo $misc;?>img/dashboard/title_fund_quater.png"/>매입매출대장이미지넣을꺼
          </td>
        </tr>
      </table></div>

      <div>top
					<form class="month_form" action="<?php echo site_url();?>/sales/purchase_sales/purchase_sales_view" method="get">
					  <select class="select7" name="year">
					    <option value="2021">2021년</option>
					  </select>
					  <select class="select7" name="month">
					    <option value="4">4월</option>
					  </select>
					</form>
      </div>

      <div>total

			</div>

			<div>상품(포캐스팅)

			</div>

			<div>용역(유지보수)

        <table class="contents_tbl">
        <thead>
          <tr>
						<!-- type 002 -->
            <th colspan="8">매입(용역)</th>
            <th rowspan="2">end-user</th>
						<!-- type 001 -->
            <th colspan="7">매출(용역)</th>
          </tr>
          <tr>
            <td>사업부</td>
            <td>세금계산서No.</td>
            <td>일자</td>
            <td>매입처</td>
            <td>품목</td>
            <td>공금가액</td>
            <td>세액</td>
            <td>합계</td>
            <td></td>
            <td>일자</td>
            <td>매출처</td>
            <td>품목</td>
            <td>공급가액</td>
            <td>세액</td>
            <td>합계</td>
            <td>세금계산서No</td>
          </tr>
        </thead>
        <tbody>
					<?php
					foreach($maintain_seq as $ms){ ?>
						<?php foreach($maintain_income_list as $ml){
							if ($ml['maintain_seq']==$ms){
								?>
								<tr>
								<td><?php echo $ml['dept']; ?></td>
		            <td><?php echo $ml['tax_approval_number']; ?></td>
		            <td><?php echo $ml['issuance_date']; ?></td>
		            <td><?php echo $ml['company_name']; ?></td>
		            <td><?php echo $ml['project_name']; ?></td>
		            <td><?php echo $ml['issuance_amount']; ?></td>
		            <td><?php // echo ($ml['issuance_amount']*0.1) ?>세액</td>
		            <td><?php // echo ?>합계</td>
								<?php
							}
						} ?>
						<?php foreach($maintain_customer as $mc){
							if($mc['maintain_seq']==$ms){
								echo '<td>'.$mc['customer_companyname'].'</td>';
							}
						} ?>
						<?php foreach($maintain_outcome_list as $ml){
							if ($ml['maintain_seq']==$ms){
								?>
								<td><?php echo $ml['tax_approval_number']; ?></td>
								<td><?php echo $ml['issuance_date']; ?></td>
								<td><?php echo $ml['company_name']; ?></td>
								<td><?php echo $ml['project_name']; ?></td>
								<td><?php echo $ml['issuance_amount']; ?></td>
								<td><?php // echo ($ml['issuance_amount']*0.1) ?>세액</td>
								<td><?php // echo ?>합계</td>
								<?php
							}
						} ?>
          </tr>
				<?php } ?>
        </tbody>
        </table>

      </div>

			<div>조달

			</div>

			<div>예정

			</div>

			<div>운영

			</div>

			<div>아래

			</div>
    </div>
  <!-- </div> -->
  <!--하단-->
  <?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
  <!--하단-->
  <script>
  </script>
</body>
</html>
