<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<body>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	  ?>
	<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
  	<link rel="stylesheet" href="/misc/css/view_page_common.css">
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
	 padding-top:20px;
	 padding-bottom:20px;
	}
	.content_list_tbl {
		padding-left: 15px;
		padding-right:15px;
		border-spacing: 0 10px;
		table-layout: fixed;
	}
	.content_list_tbl td {
		overflow:hidden;
		white-space : nowrap;
		text-overflow: ellipsis;
	}

	.input-common, .select-common, .btn-common {
		height: 35px !important;
		border-radius: 3px !important;
    box-sizing : border-box !important;
	}
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
	.select_box {
		background-color: rgb(5, 117, 230, 0.6);

	}
	.box_name {
		padding-left: 10px;
	}
	</style>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
	  ?>
  <div class="menu_div">
    <a class="menu_list" onclick ="movePage('electronic_approval_list?type=admin')" style='color:#B0B0B0'>결재문서관리</a>
		<a class="menu_list" onclick ="movePage('electronic_approval_form_list?mode=admin')" style='color:#B0B0B0'>양식관리</a>
		<a class="menu_list" onclick ="movePage('electronic_approval_format_category')" style='color:#B0B0B0'>서식함관리</a>
		<a class="menu_list" style='color:#0575E6'>결재선관리</a>
	</div>

  <div style="width:90%;margin: 0 auto;margin-top:10px;">
    <table id="storage_table" class="basic_table" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:16px;">

    </table>
		<div class="btn_div" style="margin-top:10px;text-align:center;display:none;">
			<input type="button" class="btn-common btn-color1" value="추가" onclick="storageBtn(1);" style="width:32%">
			<input type="button" class="btn-common btn-color1" value="수정" onclick="storageBtn(2);" style="width:32%">
			<input type="button" class="btn-common btn-color2" value="삭제" onclick="storageBtn(3);" style="width:32%">
		</div>
		<div class="save_div" style="margin-top:10px;text-align:center;display:none;">
			<input type="button" class="btn-common btn-color2" value="저장" onclick="storageSave();" style="width:100%;">
		</div>
  </div>

	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>

</body>

<script type="text/javascript">
  function movePage(page) {
    location.href = "<?php echo site_url(); ?>/biz/approval/" + page;
  }
</script>
