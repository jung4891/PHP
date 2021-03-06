<div class="sidebar_contents" style="text-align:center;vertical-align:middle;margin-top:30px;">
<?php
  if($biz_lv > 0){
?>
  <div class="menulist" name="biz" id="biz_side">
    <ul class="menu_wrap">
    <li>
      <a href="<?php echo site_url();?>/biz/schedule/tech_schedule">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/schedule.svg" width="40px;" heigth="40px;" />
            <br>일정관리
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url();?>/biz/attendance/attendance_user">
      <span style="font-size:12px;">
          <img src="<?php echo $misc;?>img/sideicon/attendance.svg" width="40px;" heigth="40px;"/>
          <br>근태관리
      </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/biz/approval/electronic_approval_list?type=standby">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/electronic.svg" width="40px;" heigth="40px;"/>
            <br>전자결재
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/biz/weekly_report/weekly_report_list">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/weekly_report.svg" width="40px;" heigth="40px;"/>
            <br>주간보고
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/biz/durian_car/car_drive_list">
        <span style="font-size:12px;">
          <img src="<?php echo $misc;?>img/sideicon/car_drive.svg" width="40px;" heigth="40px;"/>
          <br>차량일지
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/biz/meeting_minutes/mom_list?type=y">
        <span style="font-size:12px;">
          <img src="<?php echo $misc;?>img/sideicon/meeting_minutes.svg" width="40px;" heigth="40px;"/>
          <br>회의록
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/biz/board/notice_list?category=001">
        <span style="font-size:12px;">
          <img src="<?php echo $misc;?>img/sideicon/notice.svg" width="40px;" heigth="40px;"/>
          <br>공지사항
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/biz/diquitaca/qna_list">
        <span style="font-size:12px;">
          <img src="<?php echo $misc;?>img/sideicon/diquitaca_qna.svg" width="40px;" heigth="40px;"/>
          <br>디키타카
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/biz/dev_request/dev_request_list">
        <span style="font-size:12px;">
          <img src="<?php echo $misc;?>img/sideicon/dev_request.svg" width="40px;" heigth="40px;"/>
          <br>개발요청
        </span>
      </a>
    </li>
    </ul>
  </div>
<?php
  }
?>

<?php
  if($sales_lv > 0){
?>
  <div class="menulist" name="sales" id="sales_side">
    <ul class="menu_wrap">
    <li>
      <a href="<?php echo site_url()?>/sales/funds/funds_list?mode=month">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/fundlist.svg" width="40px;" heigth="40px;"/>
            <br>매출현황
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/sales/board/manual_list">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/notice.svg" width="40px;" heigth="40px;"/>
            <br>영업자료
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/sales/forcasting/forcasting_list?mode=forcasting">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/forcasting.svg" width="40px;" heigth="40px;"/>
            <br>포캐스팅
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/sales/forcasting/order_completed_list">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/order_completed.svg" width="40px;" heigth="40px;"/>
            <br>수주여부
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/sales/maintain/maintain_list?type=003">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/maintain_forcasting.svg" width="40px;" heigth="40px;"/>
            <br>유지보수<br>포캐스팅
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/sales/maintain/maintain_list?type=001">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/maintain.svg" width="40px;" heigth="40px;"/>
            <br>유지보수
        </span>
      </a>
    </li>
    <?php if($group == "CEO" || $group=="경영지원실" || $parent_group == "기술연구소" || $parent_group == "영업본부" ){?>
    <li>
      <a href="<?php echo site_url()?>/sales/fundreporting/fundreporting_list?company=DUIT">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/fund_reporting.svg" width="40px;" heigth="40px;"/>
            <br>자금관리
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/sales/purchase_sales/purchase_sales_view">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/purchase_sales.svg" width="40px;" heigth="40px;"/>
            <br>매입매출장
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/sales/accounts_receivable_unpaid/accounts_receivable_unpaid_view">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/accounts_receivable_unpaid.svg" width="40px;" heigth="40px;"/>
            <br>미수금미지급
        </span>
      </a>
    </li>
    <?php } ?>
    </ul>
  </div>
<?php
  }
?>

<?php
  if($tech_lv > 0){
?>
  <div class="menulist" name="tech" id="tech_side">
    <ul class="menu_wrap">
    <li>
      <a href="<?php echo site_url()?>/tech/board/manual_list">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/notice.svg" width="40px;" heigth="40px;"/>
            <br>자료실
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/tech/board/edudata_list">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/eduevent.svg" width="40px;" heigth="40px;"/>
            <br>교육자료
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/tech/board/release_note_list">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/manual_list.svg" width="40px;" heigth="40px;"/>
            <br>릴리즈노트
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo site_url()?>/tech/tech_board/tech_device_list">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/product_system_list.svg" width="40px;" heigth="40px;"/>
            <br>장비/시스템
        </span>
      </a>
    </li>
    <li>
    <a href="<?php echo site_url()?>/tech/maintain/maintain_list" >
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/customer.svg" width="40px;" heigth="40px;"/>
            <br>고객사
        </span>
      </a>
    </li>
    </ul>
  </div>
<?php
  }
  if((isset($this->cooperation_yn) && $this->cooperation_yn == 'Y')) { ?>
    <div class="menulist" name="tech" id="tech_side">
      <ul class="menu_wrap">
        <li>
          <a href="<?php echo site_url()?>/tech/tech_board/tech_doc_list?type=Y" >
            <span style="font-size:12px;">
              <img src="<?php echo $misc;?>img/sideicon/customer.svg" width="40px;" heigth="40px;"/>
              <br>고객사
            </span>
          </a>
        </li>
      </ul>
    </div>
<?php }
?>

<?php
  if($admin_lv > 0){
?>
  <div class="menulist" name="admin" id ="admin_side">
    <ul class="menu_wrap">
    <!-- <li>
      <a href="<?php echo site_url();?>/admin/company/companynum_list" >
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/company_num.svg" width="40px;" heigth="40px;"/>
            <br>사업자<br>등록번호
        </span>
      </a>
    </li> -->
    <li>
      <a href="<?php echo site_url()?>/admin/company/product_list">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/product_name.svg" width="40px;" heigth="40px;"/>
            <br>제품명
        </span>
      </a>
    </li>
    <li>
      <span style="font-size:12px;">
          <a href="<?php echo site_url()?>/admin/customer/customer_list">
              <img src="<?php echo $misc;?>img/sideicon/customer_list.svg" width="40px;" heigth="40px;"/>
          <br>거래처</a>
      </span>
    </li>
    <?php if($admin_lv == 3){?>
    <li>
<a href="<?php echo site_url()?>/admin/equipment/car_list">
        <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/equipment_list.svg" width="40px;" heigth="40px;"/>
            <br>설비관리
        </span>
      </a>
    </li>
    <?php } ?>
    <li>
      <a href="<?php echo site_url()?>/admin/account/user">
      <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/user.svg" width="40px;" heigth="40px;"/>
            <br>회원관리
        </span>
      </a>
    </li>
    <?php if(($group =="경영지원실" || $parent_group == "기술연구소" || $group == "CEO" || $group == '영업본부' || $group == '사업1부' || $group == '사업2부')){?>
    <li>
      <a href="<?php echo site_url()?>/admin/management/site_management">
      <span style="font-size:12px;">
            <img src="<?php echo $misc;?>img/sideicon/management.svg" width="40px;" heigth="40px;"/>
            <br>사이트관리
        </span>
      </a>
    </li>
    <?php } ?>
    <?php if($admin_lv == 3 && ($group =="경영지원실" || $parent_group == "기술연구소" || $group == "CEO")){?>
    <li>
      <a href="<?php echo site_url()?>/admin/attendance_admin/attendance_user_list">
      <span style="font-size:12px;">
          <img src="<?php echo $misc;?>img/sideicon/attendance.svg" width="40px;" heigth="40px;"/>
          <br>근태관리
      </span>
      </a>
    </li>
    <li>
      <a href="javascript:void(0)" onClick="subside_open('annual_admin');" >
      <span style="font-size:12px;">
          <img src="<?php echo $misc;?>img/sideicon/annual.svg" width="40px;" heigth="40px;"/>
          <br>연차관리
      </span>
      </a>
    </li>
    <?php } ?>
    </ul>
  </div>
<?php
  }
?>
</div>
