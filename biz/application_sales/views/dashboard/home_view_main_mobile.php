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
	html, body {
	  max-width: 100%;
	  height: 100%;
	  min-width: 100%;
		font-family: "Noto Sans KR", sans-serif !important;
		background-color: #F9F9F9;
		line-height: normal;
	}
	.mobile-content {
	  padding-bottom: 60px;
	}
	.center_container {
	  margin-top: 20px;
	  text-align: center;
	}
	.name {
	  font-weight: bold;
	  font-size:35px;
	}
	.bottom_containter {
	  margin:0 auto;
	  width: 50%;
	  display: flex;
	}
	.bottom_containter > .left {
	  flex:1;
	}
	.bottom_containter > .center {
	  flex:3;
	  text-align: center;
	}
	.bottom_containter > .right {
	  flex:1;
	  text-align: right;
	}
	.mobile_main {
		text-align: center;
	}
	.mobile_dash {
	  text-align:center;
		position:relative;
		width:100%;
		height:80px;
	}
	.dash_tbl {
		padding:10px;
		width:90%;
		margin:0 auto;
		border: thin solid #DEDEDE;
		border-radius: 5px;
		background-color: #fff;
	}
	.dash_tr {
		font-weight:bold;padding-left:10px;padding-right:10px;font-weight:bold;font-size:18px;color:#1C1C1C;
	}
	.footer_containter {
	  height:5vh;
	  background-color: #5d5d5d;
	  display: flex;
	  justify-content: space-between;
	}
	.footer_item {
	  flex-basis: 25%;
	  text-align: center;
	  padding: 5px;
	}
	.user_info {
		margin-top: 8%;
		margin-left: 5%;
	}
	p{
		margin: 0px 0px 0px 0px; line-height: 120%;
	}

	</style>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
	  ?>
	<div class="mobile-content">
		<div>
			<div class="user_info">
				<p class="name" style="color:#0575E6;"><?php echo $user_name.'님'; ?></p>
				<p class="name" style="color:#1C1C1C;line-height:1.2">안녕하세요.</p>
				<p style="font-size:20px;color:#626262;line-height:4.0"><?php echo $user_group; ?></p>
			</div>
		</div>
		<div class="mobile_main">
			<table class="dash_tbl" style="height:100%">
				<tr style="height:40px;">
					<!-- <img src="<?php echo $misc;?>img/mobile/dash_mail.svg" width="70%"> -->
					<td width="25%" align="center">
						<div style="background:url('<?php echo $misc;?>img/mobile/dash_mail.svg');background-size:contain;background-repeat:no-repeat;width:50%;height:100%;margin:0 auto;">
							<!-- <img style="position:absolute;width:20px;" src="<?php echo $misc;?>img/cnt_5.svg"> -->
						</div>
					</td>
					<td width="25%" align="center">
						<div id="approval" style="background:url('<?php echo $misc;?>img/mobile/dash_approval.svg');background-size:contain;background-repeat:no-repeat;width:50%;height:100%;margin:0 auto;" onclick="go_page(this.id);">
							<?php
							if ($approval_count > 0) {
								if ($approval_count > 5) {
									$img = "5over";
								} else {
									$img = $approval_count;
								}
								?>
								<img style="position:absolute;width:20px;" src="<?php echo $misc;?>img/cnt_<?php echo $img; ?>.svg">
								<?php
							} ?>
						</div>
					</td>
					<td width="25%" align="center">
						<div id="schedule" style="background:url('<?php echo $misc;?>img/mobile/dash_schedule.svg');background-size:contain;background-repeat:no-repeat;width:50%;height:100%;margin:0 auto;" onclick="go_page(this.id);">
							<?php
							if ($schedule_count > 0) {
								if ($schedule_count > 5) {
									$img = "5over";
								} else {
									$img = $schedule_count;
								}
								?>
								<img style="position:absolute;width:20px;" src="<?php echo $misc;?>img/cnt_<?php echo $img; ?>.svg">
								<?php
							} ?>
						</div>
					</td>
					<td width="25%" align="center">
						<div style="background:url('<?php echo $misc;?>img/mobile/dash_welfare.svg');background-size:contain;background-repeat:no-repeat;width:50%;height:100%;margin:0 auto;">
						</div>
					</td>
				</tr>
				<tr style="font-weight:bold;">
					<td width="25%" align="center">메일</td>
					<td width="25%" align="center">결재</td>
					<td width="25%" align="center">일정</td>
					<td width="25%" align="center">복지</td>
				</tr>
			</table>
			<table class="dash_tbl" style="margin-top:20px;height:100%;">
				<tr class="dash_tr">
					<td id='attendance' style="text-align:left;vertical-align:middle" onclick="go_page(this.id);">
						<img src="<?php echo $misc;?>img/mobile/dash_attendance.svg" width="30px" style="float:left;">
						<span style="width:100px;margin-left:20px;">근태관리</span>
						<img src="<?php echo $misc;?>img/mobile/dash_right.svg" width="30px" style="float:right;">
					</td>
				</tr>
			</table>
			<table class="dash_tbl" style="margin-top:10px;">
				<tr class="dash_tr">
					<td id="notice" style="text-align:left" onclick="go_page(this.id);">
						<img src="<?php echo $misc;?>img/mobile/dash_notice.svg" width="30px" style="float:left;">
						<span style="width:100px;margin-left:20px;">공지사항</span>
						<img src="<?php echo $misc;?>img/mobile/dash_right.svg" width="30px" style="float:right;">
					</td>
				</tr>
			</table>
			<table id ="weeklyreport" class="dash_tbl" style="margin-top:10px;" onclick="go_page(this.id);">
				<tr class="dash_tr">
					<td style="text-align:left">
						<img src="<?php echo $misc;?>img/mobile/dash_weeklyreport.svg" width="30px" style="float:left;">
						<span style="width:100px;margin-left:20px;">주간보고</span>
						<img src="<?php echo $misc;?>img/mobile/dash_right.svg" width="30px" style="float:right;">
					</td>
				</tr>
			</table>
			<table class="dash_tbl" style="margin-top:10px;">
				<tr class="dash_tr">
					<td id="address" style="text-align:left" onclick="go_page(this.id);">
						<img src="<?php echo $misc;?>img/mobile/dash_address.svg" width="30px" style="float:left;">
						<span style="width:100px;margin-left:20px;">주소록</span>
						<img src="<?php echo $misc;?>img/mobile/dash_right.svg" width="30px" style="float:right;">
					</td>
				</tr>
			</table>
			<!-- <table class="dash_tbl" style="margin-top:10px;">
				<tr class="dash_tr">
					<td style="text-align:left">
						<img src="<?php echo $misc;?>img/mobile/dash_equipment.svg" width="30px" style="float:left;">
						<span style="width:100px;margin-left:20px;">시설물예약</span>
						<img src="<?php echo $misc;?>img/mobile/dash_right.svg" width="30px" style="float:right;">
					</td>
				</tr>
			</table> -->
		</div>
	</div>
	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>
</body>
