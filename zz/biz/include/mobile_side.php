<style>
.nav_item img {margin-right: 10px;}
.nav_container {
	display: grid;
  grid-template-columns: 1fr 1fr;
  color:#1C1C1C;
  font-family:"Noto Sans KR", sans-serif!important;

}
.nav_item:nth-child(1) {
  grid-column: 1 / span 2;
  padding: 15px;
	/* grid-column: 1 / 4; */
	/* grid-row: 1 / 2; */
}
.nav_item h2{
  padding-left: 15px;
}
.nav_item a{

  padding-left: 20px;
  display:flex;
  align-items: center;
}

.menu2{
  margin: 10px 0px 10px 0px!important;
  color:#1C1C1C !important;
  font-weight : 600 !important;
  font-size : 17px !important;
	font-family:"Noto Sans KR", sans-serif!important;
}

.menu3{
  margin: 12px 0px 12px 0px!important;
	padding-left : 50px !important;
  color:#1C1C1C !important;
	font-weight : 600 !important;
	font-size : 14px !important;
	font-family:"Noto Sans KR", sans-serif!important;
  /* font-weight : 450 !important; */
  /* font-size : 15px !important; */
}


.logout_contain{

  height:33%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family:"Noto Sans KR", sans-serif;
}

.skyBtn{
 cursor:pointer;
 height:40px;
 width:100px;
 background-color:#41beeb;
 color:#FFFFFF;
 vertical-align:top;
 font-size:16px;
 font-weight:bold;
 border: none;
 border-radius: 19px;
 outline:none;
 margin:5px;
}
</style>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script type="text/javascript">

function nav_open(){

  $("#mobile_nav").bPopup({
    position: [0, 0],
    speed: 500,
    transition: 'slideIn',
    transitionClose: 'slideIn'
  });
}

function logoutopen(){
  $("#logout_div").bPopup({
    speed: 450,
    transition: 'slideDown'
  })
}
</script>
<!-- 네비 영역 -->
<div id="mobile_nav" style="height:100vh;width:80%;background-color:#ffffff; display:none; border-radius: 0px 10px 10px 0px;">
  <div class="nav_container">
    <div class="nav_item">
<!-- <img src="<?php echo $misc;?>img/mobile/list.png" height="25" onclick="$('#mobile_nav').bPopup().close();"> -->
    </div>

    <div class="nav_item">
      <?php if($biz_lv > 0){ ?>
        <h2>BIZ</h2>

    		<a href="<?php echo site_url();?>/biz/schedule/tech_schedule_mobile" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/schedule.svg" width="20"> 일정관리</a>
				<a href="<?php echo site_url();?>/biz/attendance/attendance_user" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/attendance.svg" width="20"> 근태관리</a>
    		<a href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=standby" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/electronic.svg" width="20"> 전자결재</a>
					<a href="<?php echo site_url();?>/biz/approval/electronic_approval_form_list?mode=user" class="menu3">기안</a>
					<a href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=standby" class="menu3">결재</a>
					<a href="<?php echo site_url();?>/biz/approval/electronic_approval_personal_storage_list?seq=all" class="menu3">개인보관함</a>
					<a href="<?php echo site_url();?>/biz/approval/electronic_approval_delegation_management" class="menu3">환경설정</a>
				<?php if ($biz_lv == 3 || ($parent_group =="경영지원실" || $parent_group =="영업본부" || $group =="기술연구소")){ ?>
					<a href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=admin" class="menu3">관리자</a>
				<?php } ?>
        <a href="<?php echo site_url();?>/biz/weekly_report/weekly_report_list" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/weekly_report.svg" width="20"> 주간보고</a>
        <a href="<?php echo site_url();?>/biz/durian_car/car_drive_list" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/car_drive.svg" width="20"> 차량일지</a>
        <a href="<?php echo site_url();?>/biz/meeting_minutes/mom_list?type=y" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/meeting_minutes.svg" width="20"> 회의록</a>
        <a href="<?php echo site_url();?>/biz/board/notice_list?category=001" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/notice.svg" width="20"> 공지사항</a>
        <?php } ?>

        <?php if($tech_lv > 0){ ?>
        <h2>TECH</h2>
        <a href="<?php echo site_url();?>/tech/board/manual_list" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/manual.svg" width="20"> 자료실</a>
        <a href="<?php echo site_url();?>/tech/board/edudata_list" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/eduevent.svg" width="20"> 교육자료</a>
        <a href="<?php echo site_url();?>/tech/board/release_note_list" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/release_note.svg" width="20"> 릴리즈노트</a>
        <a href="<?php echo site_url();?>/tech/tech_board/tech_device_list" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/tech_device.svg" width="20"> 장비/시스템</a>
        <a href="<?php echo site_url();?>/tech/tech_board/tech_doc_list?type=Y" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/customer.svg" width="20"> 고객사</a>
        <?php } ?>


    </div>
    <div class="nav_item">
      <?php if($sales_lv > 0){ ?>
        <h2>SALES</h2>
        <a href="<?php echo site_url();?>/sales/funds/funds_list" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/fundlist.svg" width="20"> 매출현황</a>
        <a href="<?php echo site_url();?>/sales/board/manual_list" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/sales_manual.svg" width="20"> 영업자료</a>
        <a href="<?php echo site_url();?>/sales/forcasting/forcasting_list?mode=forcasting" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/forecasting.svg" width="20"> 포캐스팅</a>
        <a href="<?php echo site_url();?>/sales/forcasting/order_completed_list" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/order_completed.svg" width="20"> 수주완료</a>
        <a href="<?php echo site_url();?>/sales/maintain/maintain_list" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/maintain.svg" width="20"> 유지보수</a>
        <?php if($group == "CEO" || $group=="경영지원실" || $group == "기술연구소" || $parent_group == "영업본부" ){?>
        <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_list/page/200?company=DUIT" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/fund_reporting.svg" width="20"> 자금관리</a>
        <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_list/page/200?company=DUIT" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/purchase_sales.svg" width="20"> 매입매출장</a>
        <?php }
        }?>


        <?php if($admin_lv > 0){ ?>
        <h2>ADMIN</h2>
        <!-- <a href="<?php echo site_url();?>/admin/company/companynum_list" class="menu2">사업자등록번호</a> -->
        <a href="<?php echo site_url();?>/admin/company/product_list" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/product_name.svg" width="20"> 제품명</a>
        <a href="<?php echo site_url();?>/admin/customer/customer_list" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/customer_list.svg" width="20"> 거래처</a>
        <?php if($admin_lv == 3){?>
        <a href="<?php echo site_url();?>/admin/equipment/car_list" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/manual_list.svg" width="20"> 설비관리</a>
        <?php } ?>
        <a href="<?php echo site_url();?>/admin/account/user" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/user.svg" width="20"> 회원관리</a>
        <?php } ?>
        <?php if($admin_lv == 3 && ($group =="경영지원실" || $group == "기술연구소" || $group == "CEO")){?>
        <a href="<?php echo site_url()?>/admin/attendance_admin/attendance_user_list" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/attendance.svg" width="20"/>근태관리</a>
        <a href="<?php echo site_url()?>/admin/annual_admin/annual_management" class="menu2"><img src="<?php echo $misc;?>img/mobile/nav_mobile/annual.svg" width="20"/>연차관리</a>
      <?php } ?>
    </div>
  </div>
</div>
<!-- 로그아웃 창 영역 -->
<!-- <div id="logout_div" style="height:30%;width:90%;background-color:#ffffff; display:none;border-radius:2em;"> -->
<div id="logout_div" style="height:auto;width:90%;background-color:#ffffff; display:none;border-radius:1em;">
  <!-- <div class="logout_contain"> -->
    <div class="logout_contain" style="font-size:18px; color:#1C1C1C;font-weight:bold;">
      <table style="width:100%;" cellspacing="0">
      	<tr>
      		<td align="center" colspan="2" style="padding-top:20%;padding-bottom:20%;">로그아웃 하시겠습니까?</td>
      	</tr>
				<tr>
					<td align="center" style="height:60px;cursor:pointer;border-top:thin solid #EFEFEF;" onclick="$('#logout_div').bPopup().close();">취소</td>
					<td align="center" style="color:#0575E6;cursor:pointer;border-top:thin solid #EFEFEF;" onclick="location.href='<?php echo site_url();?>/account/logout'">확인</td>
				</tr>
      </table>
    </div>
<!-- </div> -->
</div>
