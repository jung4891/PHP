<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style media="screen">
.basic_table{
	width:100%;
	 border-collapse:collapse;
	 border:1px solid;
	 border-color:#DEDEDE;
	 table-layout: auto !important;
	 border-left:none;
	 border-right:none;
}

.basic_table td{
	height:35px;
	 padding:0px 10px 0px 10px;
	 border:1px solid;
	 border-color:#DEDEDE;
}
.border_n {
	border:none;
}
.border_n td {
	border:none;
}
.basic_table tr > td:first-child {
	border-left:none;
}
.basic_table tr > td:last-child {
	border-right:none;
}
.contents_div {
	overflow-x: scroll;
	white-space: nowrap;
}
</style>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<body>
<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
	?>
<div style="max-width:90%;margin: 0 auto; padding-bottom: 60px;margin-top:30px;">
	<div width="100%">
		<table class="basic_table">
			<col width="30%">
			<col width="70%">
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">고객사</td>
				<td><?php echo $view_val['customer_companyname'];?></td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">프로젝트명</td>
				<td><?php echo $view_val['project_name'];?></td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">장비명</td>
				<td><?php echo $view_val['product_name'];?></td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">제품명</td>
				<td><?php echo $view_val['product_item'];?></td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">제조사</td>
				<td><?php echo $view_val['product_company'];?></td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">Serial Number</td>
				<td><?php echo $view_val['product_serial'];?></td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">Version</td>
				<td><?php echo $view_val['product_version'];?></td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">상태</td>
				<td>
          <?php
          if($view_val['product_state'] == "0") { echo "미입력상태"; }
          else if($view_val['product_state'] == "001") { echo "입고 전"; }
          else if($view_val['product_state'] == "002") { echo "창고"; }
          else if($view_val['product_state'] == "003") { echo "고객사 출고"; }
          else if($view_val['product_state'] == "004") { echo "장애 반납"; }
          ?>
        </td>
			</tr>
      <tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">라이선스</td>
				<td><?php echo $view_val['product_licence'];?></td>
			</tr>
      <tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">용도</td>
				<td><?php echo $view_val['product_purpose'];?></td>
			</tr>
      <tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">host</td>
				<td><?php echo $view_val['product_host'];?></td>
			</tr>
      <tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">점검항목 리스트</td>
				<td>
          <?php
              foreach($check_list as $check_item){
                if( $view_val['product_check_list'] == $check_item['seq'] ){
                  echo $check_item['product_name'];
                }
              }
          ?>
        </td>
			</tr>
		</table>
		<div class="btn_div" style="margin-top:20px;">
			<input type="button" style="float:right;" class="btn-common btn-color1" value="목록" onClick="javascript:history.go(-1);">
		</div>
	</div>
</div>
<div style="position:fixed;bottom:100px;right:5px;">
		<img src="<?php echo $misc; ?>img/mobile/btn_top.svg" onclick="$('html').scrollTop(0);">
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
</html>
