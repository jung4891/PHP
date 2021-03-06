<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
?>
<style>
/* 헤더 폰트 */
@import url(//fonts.googleapis.com/earlyaccess/notosanskr.css);
.searchModal {
  display: none;
  position: fixed;
  /* z-index: 10; */
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0, 0, 0);
  background-color: rgba(0, 0, 0, 0.4);
  z-index: 1004;
}

.search-modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 70%;
  z-index: 1004;
}

.search_menu_modal {
  background-color: rgba(0, 0, 0, 0.9) !important;
}

.search_menu_content {
  background-color: rgba( 255, 255, 255, 0 );
  border: none;
}

ul:not(.not_padding) {
  list-style: none;
  padding-left: 0px;
  margin-bottom: 0px;
}

li {
  margin-top: 0px;
  list-style: none;
  padding-left: 0px;
}

#header {
  height:65px;
  font-size:15px;
  background-color:white;
  font-family:"Noto Sans KR", sans-serif !important;
  color: #484848;
  font-size:16px;
  font-weight:bold;
  position:relative;
  z-index:1003;
  box-shadow: 0px 3px 6px rgba(0,0,0,0.1);
  /* rgba(0,0,0,0.36) */
}

.search_btn {
  height: 20px;
  background: none;
  border-radius: 20px;
  border: solid 1.8px #ffffff;
  outline: none;
  background-image: url('<?php echo $misc;?>img/headericon/btn_search.png');
  background-repeat: no-repeat;
  background-position: 5px;
  background-size: 16px;
  vertical-align: middle;
}

.menu_wrap li{
  padding-bottom:30px;

}
.menu_wrap li a{
  color:#ffffff;
  font-family:"Noto Sans KR", sans-serif;
}

.header_menu{
  display:inline-block;
  cursor:pointer;
  height:100%;
  min-width:200px;
  margin-left:20px;
  font-size:25px;
  line-height:60px;
  text-align:center;
  /* clear: both; */
  float:left;
}

.header_menu div{
  float:left;
  width:150px;
  font-size:20px;
}

.sidenav{
  min-height:100%;
  width:400px;
  position: absolute;
  z-index:1003;
  top: 60;
  left: 0;
  background-color:#41494d;
  transition:0.5s ease-in-out;
  padding: 10px 0px 10px 0px;
  display:none;
}

.sidenav a{
  font-family:"Noto Sans KR", sans-serif !important;
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  /* font-size: 25px; */
  display: block;
  transition: 0.2s ease-in-out;
}

.menu1{
  margin: 20px 0px 10px 0px!important;
  color:#ffffff !important;
  font-weight : bold !important;
  font-size : 23px !important;
}

.menu2{
  margin: 5px 0px 5px 0px!important;
  color:#ffffff !important;
  font-weight : 600 !important;
  font-size : 17px !important;
}

.menu3{
  margin: 10px 0px 0px 0px!important;
  color:#ffffff !important;
  font-weight : 450 !important;
  font-size : 15px !important;
}

.menu4{
  margin: 1px 0px 1px 0px!important;
  color:#ffffff !important;
  font-weight : 400 !important;
  font-size : 13px !important;
}

.point_menu{
  color:#3C3C3C;
}

.sidenav2{
  min-height:90%;
  width:200px;
  position: absolute;
  z-index:1003;
  /* top: 65;
  left: 65; */
  background-color:#f8f8f9;
  transition:0.5s ease-in-out;
  /* padding: 10px 0px 10px 0px; */
  margin-left:65px;
  padding: 20px 0px 0px 30px;
  display:none;
}
.sidenav2 a {
  display: block;
  font-family:"Noto Sans KR", sans-serif !important;
  color: #3C3C3C !important;
  min-width:65px;
  padding: 15px 0px 10px 0px;
  font-size : 13px !important;
}


.sidebar_sub_off{
  display:none;
}

.sidebar_sub_on{
  display:inline-block;
  background-color:#626262;
  min-height:100%;
  position:absolute;left:65px;right:0px;
  width:15%;
  vertical-align:top;
  overflow-y:auto;
}

#sidebar_open_div{
  display:inline-block;
  position:absolute;left:65px;right:0px;
  min-height:100%;
  width:40px;
  vertical-align:top;
  overflow:hidden;
  /* z-index: 1003; */
}

.main_content_cut{
  display:inline-block;
  min-height:100%;
  width:80%;
  float:right;
  /* position:absolute; */
  overflow:hidden;
}

.main_content_extend{
  display:inline-block;
  min-height:100%;
  position:absolute;

  left:65px;right:0px;
  overflow:hidden;
}

.subside_btn:hover {
  transform: scale(1.5, 1.5);
  -webkit-transform:scale(1.5, 1.5);
  -moz-transform:scale(1.5, 1.5);
  -o-transform:scale(1.5, 1.5);
  -webkit-transition: 1s;
  -moz-transition: 1s;
  -o-transition: 1s;
}

.subside_btn {
  transform: scale(1);
  -webkit-transform:scale(1);
  -moz-transform:scale(1);
  -o-transform:scale(1);
  -webkit-transition: 1s;
  -moz-transition: 1s;
  -o-transition: 1s;
}

.search_input {
    width: 60%;
    padding: 12px 40px;
    background-color: rgba( 255, 255, 255, 0 ) !important;
    transition: transform 250ms ease-in-out;
    font-size: 14px;
    line-height: 18px;

    color: white;
    background-color: white;
/*         background-image: url(http://mihaeltomic.com/codepen/input-search/ic_search_black_24px.svg); */

    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Cpath d='M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z'/%3E%3Cpath d='M0 0h24v24H0z' fill='none'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-size: 18px 18px;
    background-position: 95% center;
    border-radius: 50px;
    border: 1px solid white;
    transition: all 250ms ease-in-out;
    backface-visibility: hidden;
    transform-style: preserve-3d;
  }
.search_input:placeholder {
    color: color(white);
    text-transform: uppercase;
    letter-spacing: 1.5px;
}

.search_input:hover,
.search_input:focus {
    padding: 12px 0;
    outline:none;
    border: 1px solid transparent;
    border-bottom: 1px solid white;
    border-radius: 0;
    background-position: 100% center;
}
.ui-menu {
  z-index: 1004 !important;
  width:40%;
}
.ui-menu .ui-menu-item {
    height:20px !important;
    font-size:14px !important;
    z-index:1003 !important;
    background-color: white !important;
}

.ui-state-focus {
  border:none !important;
}

.ui-state-focus div{
  border:none;
  background-color: #bcd6f1;
  border-color: #bcd6f1;
  font-weight: bold;
}

.header_btn {
  cursor: pointer;
  /* margin-right: 0px; */
  border: 2px solid black;
  background-color: white;
  width: 90px;
  height: 30px;
  font-weight: 400;
  border-radius: 3px;
  background: #a9abac;
  border-color: #a9abac;
  color: rgb(255, 255, 255);
  font-family: "Noto Sans KR", sans-serif;
  margin-top:17px;
  line-height: 0;
  float:left;
  margin-right:10px;
}

.header_modify_btn {
  color: #1A8DFF;
  background-color: #E7F3FF;
  border-color: #E7F3FF;
}

.side_part{
  display:block;
  border-bottom:1px solid rgba(255,255,255,0.6);
}

.side_part a {
  display: block;
  font-family:"Noto Sans KR", sans-serif !important;
  color: #ffffff !important;
  min-width:65px;
  padding: 15px 0px 15px 15px;
  font-size : 14px !important;
}
.reverse_btn{
  transform: scaleY(-1);
}

.middle_menu_div{
  display:flex;
  justify-content:space-between;
  align-items: center;
  padding-left: 15px;
  color:white;
  font-size: 14px;
}


.sidenav3 a:hover {

  color: #41BEEB !important;

}

.href_div a{
  display: block;
  font-family:"Noto Sans KR", sans-serif !important;
  color: #ffffff !important;
  min-width:65px;
  padding: 10px 0px 10px 15px;
  font-size : 14px !important;
  opacity: 0.6;
}

.href_div a:last-child {
  padding-bottom:20px;
}

.sidebar_title{
  font-family:"Noto Sans KR", sans-serif !important;
  font-size:16px;
  color:white;
  padding-left:14px;
}

</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<script type="text/javascript" src="/misc/js/mousetrap.js"></script> <!--  단축키 js -->
<script src="https://cdn.jsdelivr.net/npm/inko@1.1.1/inko.min.js"></script>
<?php
$this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );
?>
<div id="header">
  <header style="height:100%;">
      <div id="detail_menu" onclick="sidenav_view();" style="width:65px; height:65px; display:inline-block; background-color:#484848;float:left;cursor:pointer;">
        <img src="<?php echo $misc;?>img/headericon/btn_detail_list.svg" align="absmiddle" style="width:45%;height:45%;padding:25%" />
      </div>
      <div class="header_menu" style="font-weight:bold;font-size:30px;margin-left:50px;" OnClick="location.href ='<?php echo site_url();?>/biz/'">
          BIZ CENTER
      </div>
      <div class="header_menu" style="width:fit-content;">
        <?php if($biz_lv > 0){ ?>
          <div id="biz_head" OnClick="change_sidebar('biz', 'click');" <?php if(strpos($_SERVER['REQUEST_URI'],'biz/') !== false){echo "class='point_menu'";} ?> style="font-weight:500;">
              BIZ
          </div>
        <?php } ?>
        <?php if($sales_lv > 0){ ?>
          <div id="sales_head" OnClick="change_sidebar('sales', 'click');" <?php if(strpos($_SERVER['REQUEST_URI'],'sales/') !== false){echo "class='point_menu'";} ?> style="font-weight:500;">
              SALES
          </div>
        <?php } ?>
        <?php if($tech_lv > 0 || (isset($this->cooperation_yn) && $this->cooperation_yn == 'Y')){ ?>
          <div id="tech_head"  OnClick="change_sidebar('tech', 'click');" <?php if(strpos($_SERVER['REQUEST_URI'],'tech/') !== false){echo "class='point_menu'";} ?> style="font-weight:500;">
              TECH
          </div>
        <?php } ?>
        <?php if($admin_lv > 0){ ?>
          <div id="admin_head" OnClick="change_sidebar('admin', 'click');" <?php if(strpos($_SERVER['REQUEST_URI'],'admin/') !== false){echo "class='point_menu'";} ?> style="font-weight:500;">
              ADMIN
          </div>
        <?php } ?>
      </div>
      <div class="header_menu" style="float:right;padding-right:50px;">
          <!-- <input type="text" class="search_btn" style="vertical-align: middle;"> &nbsp; -->
          <?php if( $id != null ) {?>
              <a href="<?php echo site_url();?>/account/modify_view">
                <!-- <span style="font-family:Noto Sans KR ;color: #ffffff;font-size:13px;margin-right:10px;"><?php echo $name;?> 님 환영합니다.</span> -->
                <!-- <img src="<?php echo $misc;?>img/headericon/btn_user.png" style="width:25px;height:25px;" align="absmiddle" /> -->
                <button type="button" class="header_btn header_modify_btn" onclick="modalOpen();">정보수정</button>
              </a>
              <!-- <a href="<?php echo site_url();?>/account/modify_view"><?php echo $name;?></a> 님 -->
              &nbsp;
              <!-- <a href="<?php echo site_url();?>/account/logout"> -->
                <!-- <img src="<?php echo $misc;?>img/headericon/btn_logout.png" align="absmiddle" /> -->
              <!-- </a> -->
              <button type="button" class="header_btn" onclick="location.href='<?php echo site_url();?>/account/logout'">로그아웃</button>
          <?php }else if( $this->cooperative_id != null ) {?>
              <?php echo  $this->cooperative_id; ?>님
              &nbsp;
              <!-- <a href="<?php echo site_url();?>/account/logout"> -->
                <!-- <img src="<?php echo $misc;?>img/headericon/btn_logout.png" align="absmiddle" /> -->
              <!-- </a> -->
              <button type="button" class="header_btn" onclick="location.href='<?php echo site_url();?>/account/logout'">로그아웃</button>
          <?php } else {?>
              <!-- <a href="<?php echo site_url();?>/account"> -->
                <!-- <img src="<?php echo $misc;?>img/headericon/btn_logout.png" align="absmiddle" /> -->
              <!-- </a> -->
              <button type="button" class="header_btn" onclick="location.href='<?php echo site_url();?>/account/logout'">로그아웃</button>
          <?php }?>
      </div>
    </header>
</div>
<div id="sidenav" class="sidenav" >
  <div style="width:50%;float:left;">
  <?php if($biz_lv > 0){ ?>
    <div name="BIZ">
      <a href="<?php echo site_url();?>/biz" class="menu1">BIZ</a>
  		<a href="<?php echo site_url();?>/biz/schedule/tech_schedule" class="menu2">일정관리</a>
  		<a href="<?php echo site_url();?>/biz/attendance/attendance_working_hours" class="menu2">근태관리</a>
  		<a href="<?php echo site_url();?>/biz/attendance/attendance_working_hours" class="menu3">근로시간통계</a>
  		<a href="<?php echo site_url();?>/biz/attendance/annual_usage_status" class="menu3">휴가사용현황</a>
  		<a href="<?php echo site_url();?>/biz/attendance/annual_usage_status_list" class="menu3">휴가사용내역</a>
  		<a href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=standby" class="menu2">전자결재</a>
  		<a href="<?php echo site_url();?>/biz/approval/electronic_approval_form_list?mode=user" class="menu3">기안</a>
  		<a href="<?php echo site_url();?>/biz/approval/electronic_approval_form_list?mode=user" class="menu4">-기안문작성</a>
      <a href="<?php echo site_url();?>/biz/approval/electronic_approval_doc_list?type=request" class="menu4"> -결재요청함</a>
      <a href="<?php echo site_url();?>/biz/approval/electronic_approval_doc_list?type=temporary" class="menu4"> -임시저장함</a>
      <a href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=standby" class="menu3">결재</a>
      <a href="<?php echo site_url();?>/biz/approval/electronic_approval_delegation_management" class="menu3">환경설정</a>
      <a href="<?php echo site_url();?>/biz/approval/electronic_approval_delegation_management" class="menu4"> -위임관리</a>
      <a href="<?php echo site_url();?>/biz/approval/electronic_approval_personal_storage" class="menu4"> -개인보관함관리</a>
      <a href="<?php echo site_url();?>/biz/approval/electronic_approval_personal_storage_list?seq=all" class="menu3">개인보관함</a>
      <a href="<?php echo site_url();?>/biz/official_doc/official_doc_list?mode=user" class="menu3">공문함</a>
      <?php if ($biz_lv == 3 || ($parent_group =="경영지원실" || $parent_group =="영업본부" || $parent_group =="기술연구소")){ ?>
      <a href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=admin" class="menu3">관리자</a>
      <?php if($parent_group =="경영지원실" || $parent_group =="기술연구소" || $group =="CEO"  ){?>
      <a href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=admin" class="menu4"> -결재문서관리</a>
      <a href="<?php echo site_url();?>/biz/official_doc/official_doc_list?mode=admin" class="menu4"> -공문관리</a>
      <?php } ?>
      <a href="<?php echo site_url();?>/biz/approval/electronic_approval_form_list?mode=admin" class="menu4"> -양식관리</a>
      <a href="<?php echo site_url();?>/biz/approval/electronic_approval_format_category" class="menu4"> -서식함관리</a>
      <a href="<?php echo site_url();?>/biz/approval/electronic_approver_line_list" class="menu4"> -결재선관리</a>
      <?php } ?>
      <a href="<?php echo site_url();?>/biz/weekly_report/weekly_report_list" class="menu2">주간보고</a>
      <a href="<?php echo site_url();?>/biz/durian_car/car_drive_list" class="menu2">차량일지</a>
      <a href="<?php echo site_url();?>/biz/board/notice_list?category=001" class="menu2">회의록</a>
      <a href="<?php echo site_url();?>/biz/board/notice_list?category=001" class="menu2">공지사항</a>
      <a href="<?php echo site_url();?>/biz/diquitaca/qna_list" class="menu2">디키타카</a>
      <a href="<?php echo site_url();?>/biz/dev_request/dev_request_list" class="menu2">개발요청</a>
      <?php } ?>
    </div>

    <div name="TECH">
      <?php if($tech_lv > 0){ ?>
      <a href="<?php echo site_url();?>/tech" class="menu1">TECH</a>
      <a href="<?php echo site_url();?>/tech/board/manual_list" class="menu2">자료실</a>
  		<a href="<?php echo site_url();?>/tech/board/manual_list" class="menu3">자료실</a>
      <a href="<?php echo site_url();?>/tech/board/faq_list" class="menu3">FAQ</a>
      <a href="<?php echo site_url();?>/tech/board/edudata_list" class="menu2">교육자료</a>
      <a href="<?php echo site_url();?>/tech/board/release_note_list" class="menu2">릴리즈노트</a>
      <a href="<?php echo site_url();?>/tech/tech_board/tech_device_list" class="menu2">장비/시스템등록</a>
      <a href="<?php echo site_url();?>/tech/maintain/tech_doc_list" class="menu2">고객사</a>
  		<a href="<?php echo site_url();?>/tech/maintain/maintain_list" class="menu3">유지보수</a>
      <a href="<?php echo site_url();?>/tech/board/network_map_list" class="menu3">구성도</a>
      <a href="<?php echo site_url();?>/tech/tech_board/tech_doc_list?type=Y" class="menu3">기술지원보고서</a>
      <a href="<?php echo site_url();?>/tech/tech_board/request_tech_support_list" class="menu3">기술지원요청</a>
    <?php }
    if ((isset($this->cooperation_yn) && $this->cooperation_yn == 'Y')) { ?>
      <a href="<?php echo site_url();?>/tech/tech_board/tech_doc_list?type=Y" class="menu3">기술지원보고서</a>
    <?php } ?>
    </div>
  </div>
  <div style="width:50%;float:left;">
  <?php if($sales_lv > 0){ ?>
    <div name="SALES">
      <a href="<?php echo site_url();?>/sales" class="menu1">SALES</a>
      <a href="<?php echo site_url();?>/sales/funds/funds_list?mode=month" class="menu2">매출현황</a>
      <a href="<?php echo site_url();?>/sales/board/manual_list" class="menu2">영업자료</a>
      <a href="<?php echo site_url();?>/sales/forcasting/forcasting_list?mode=forcasting" class="menu2">포캐스팅</a>
      <a href="<?php echo site_url();?>/sales/forcasting/order_completed_list" class="menu2">수주완료</a>
      <a href="<?php echo site_url();?>/sales/forcasting/forcasting_list?mode=mistake" class="menu2">실주</a>
      <a href="<?php echo site_url();?>/sales/maintain/maintain_list" class="menu2">유지보수</a>
      <a href="<?php echo site_url();?>/sales/maintain/maintain_list?type=002" class="menu2">통합유지보수</a>
      <?php if($group == "CEO" || $group=="경영지원실" || $parent_group == "기술연구소" || $parent_group == "영업본부" ){?>
      <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_list/page/200?company=DUIT" class="menu2">자금관리</a>
      <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_list/page/200?company=DUIT" class="menu3">두리안정보기술</a>
      <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_list?company=DUITOLD" class="menu3">두리안정보기술(구)</a>
      <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_list?company=DUICT" class="menu3">두리안정보통신기술</a>
      <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_list?company=MG" class="menu3">더망고</a>
      <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_list?company=DBS" class="menu3">두리안정보기술부산지점</a>
      <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_list?company=DK" class="menu3">던킨</a>
      <?php if($parent_group != "영업본부"){?>
      <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_history_list?company=HIS_LIST" class="menu3">히스토리</a>
      <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_history_list?company=HIS_LIST" class="menu4">-거래리스트로그</a>
      <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_history_bank?company=HIS_BANK" class="menu4">-은행관리로그</a>
      <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_page_log?company=HIS_USER" class="menu4">-접속로그</a>
      <?php }} ?>
      <a href="<?php echo site_url();?>/sales/purchase_sales/purchase_sales_view" class="menu2">매입매출</a>
      <a href="<?php echo site_url();?>/sales/purchase_sales/purchase_sales_view" class="menu3">월별매입매출장</a>
      <a href="<?php echo site_url();?>/sales/accounts_receivable_unpaid/accounts_receivable_unpaid_view" class="menu3">미수금미지급</a>
      <a href="<?php echo site_url();?>/sales/purchase_sales/quarterly_purchase_sales_view" class="menu3">분기별매입매출장</a>
    </div>
    <?php
    }?>

  <?php if($admin_lv > 0){ ?>
    <div name="ADMIN">
      <a href="<?php echo site_url();?>/admin" class="menu1">ADMIN</a>
      <!-- <a href="<?php echo site_url();?>/admin/company/companynum_list" class="menu2">사업자등록번호</a> -->
      <a href="<?php echo site_url();?>/admin/company/product_list" class="menu2">제품명</a>
      <a href="<?php echo site_url();?>/admin/customer/customer_list" class="menu2">거래처</a>
      <?php if($admin_lv == 3){?>
      <a href="<?php echo site_url();?>/admin/equipment/car_list" class="menu2">설비관리</a>
      <a href="<?php echo site_url();?>/admin/equipment/car_list" class="menu3">차량관리</a>
      <a href="<?php echo site_url();?>/admin/equipment/meeting_room_list" class="menu3">회의실관리</a>
      <?php } ?>
      <a href="<?php echo site_url();?>/admin/account/user" class="menu2">회원관리</a>
      <a href="<?php echo site_url();?>/admin/account/user" class="menu3">회원정보</a>
      <a href="<?php echo site_url();?>/admin/account/group_tree_management" class="menu3">조직도관리</a>
      <?php if(($group =="경영지원실" || $parent_group == "기술연구소" || $group == "CEO" || $group == '영업본부' || $group == '사업1부' || $group == '사업2부')){?>
      <a href="<?php echo site_url();?>/admin/management/site_management" class="menu2">사이트관리</a>
      <?php } ?>
      <a href="<?php echo site_url();?>/admin/attendance_admin/attendance_user_list" class="menu2">근태관리</a>
      <a href="<?php echo site_url();?>/admin/attendance_admin/attendance_user_list" class="menu3">근태설정</a>
      <a href="<?php echo site_url();?>/admin/attendance_admin/attendance_list" class="menu3">근태조회</a>
      <a href="<?php echo site_url();?>/admin/attendance_admin/attendance_working_hours" class="menu3">근로시간통계</a>
      <a href="<?php echo site_url();?>/admin/annual_admin/annual_management" class="menu2">연차관리</a>
      <a href="<?php echo site_url();?>/admin/annual_admin/annual_usage_status" class="menu3">휴가사용현황</a>
      <a href="<?php echo site_url();?>/admin/annual_admin/annual_usage_status_list" class="menu3">휴가사용내역</a>
    </div>
  <?php } ?>
  </div>
</div>
<!-- 임시사이드바 -->
<!-- 임시사이드바 끝 -->
<!-- 점검모달 -->
<div id="notice_modal" class="searchModal">
    <div class="search-modal-content">
        <h2>* 점검공지 *</h2>
        <div style="margin:30px 0px 30px 0px;font-size:14px;">
        <!-- 서버 이전 - biz.durianit.co.kr 로 접속 부탁드립니다.<br><br> -->
        점검 일시 : <?php echo date("Y-m-d");?> 18:00 ~ 2021-10-14 19:00
        </div>
    </div>
</div>
<div id="search_menu_modal" class="searchModal search_menu_modal">
    <div class="search-modal-content search_menu_content">
        <h2 align="center">메뉴 검색</h2>
        <div align="center">
        <input type="text" id="search_menu_input" class="search_input" placeholder="메뉴 검색" value="" onkeydown="checkkey(event)">
        <input type="hidden" id="menu_href" value="">
        </div>
    </div>
</div>
<!-- 점검모달 끝 -->
<div class="container" style="position:relative;width:100%;height:100%;">
  <div id="sidebar_left" style="display:inline-block;width:65px;min-height:100%;background-color:#484848;z-index:1003;">
    <?php include $this->input->server('DOCUMENT_ROOT')."/include/biz_sidebar.php"; ?>
  </div>
  <!-- <div id="sidebar_sub" class="sidebar_sub" style="display:inline-block; background-color:#41feeb;min-height:100%;width:15%;position:absolute;left:65px;right:0px;overflow:hidden;">
  </div> -->
  <div id="sidebar_sub" class="sidebar_sub_off">
    <div id="approval_sidenav" class="sidenav3">
      <div style="width:100%; height:8vh; background-color:#3C3C3C;display:flex;align-items:center;justify-content:space-between">
        <span class="sidebar_title">전자결재</span>
        <img class="subside_btn" src="<?php echo $misc;?>img/sideicon/side_close.png" width="13px;" heigth="10px;" align="right" style ="cursor:pointer; padding:15px 15px 15px 0px;" onClick="subside_close();">
      </div>
      <div class="side_part">
        <div class = "middle_menu_div">
            <span>기안</span>
            <img src="<?php echo $misc;?>img/sideicon/side_up.svg" height="20px;" style ="cursor:pointer; padding:15px 15px 15px 0px;" onclick="updown(this);">
        </div>
        <div class="href_div">
            <a href="<?php echo site_url();?>/biz/approval/electronic_approval_form_list?mode=user" >&emsp;· 기안문작성</a>
            <a href="<?php echo site_url();?>/biz/approval/electronic_approval_doc_list?type=temporary" >&emsp;· 임시저장함</a>
            <a href="<?php echo site_url();?>/biz/approval/electronic_approval_doc_list?type=request" >&emsp;· 결재요청함</a>
        </div>
      </div>

    <div class="side_part">
      <div class = "middle_menu_div">
          <span>결재</span>
          <img src="<?php echo $misc;?>img/sideicon/side_up.svg" height="20px;" style ="cursor:pointer; padding:15px 15px 15px 0px;" onclick="updown(this);">
      </div>
      <div class="href_div">
        <a href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=standby" >&emsp;· 결재대기함</a>
        <a href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=progress" >&emsp;· 결재진행함</a>
        <a href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=completion" >&emsp;· 완료문서함</a>
        <a href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=back" >&emsp;· 반려문서함</a>
        <a href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=reference" >&emsp;· 참조/열람문서함</a>
        <a href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=wage" >&emsp;· 연봉계약서</a>
    </div>
  </div>

    <div class="side_part">
      <a href="<?php echo site_url();?>/biz/approval/electronic_approval_personal_storage_list?seq=all">개인보관함</a>
    </div>

    <div class="side_part">
      <a href="<?php echo site_url();?>/biz/official_doc/official_doc_list?mode=user">공문함</a>
    </div>

    <div class="side_part">
      <div class = "middle_menu_div">
          <span>환경설정</span>
          <img src="<?php echo $misc;?>img/sideicon/side_up.svg" height="20px;" style ="cursor:pointer; padding:15px 15px 15px 0px;" onclick="updown(this);">
      </div>
      <div class="href_div">
        <a href="<?php echo site_url();?>/biz/approval/electronic_approval_delegation_management" >&emsp;· 위임관리</a>
        <a href="<?php echo site_url();?>/biz/approval/electronic_approval_personal_storage" >&emsp;· 개인보관함관리</a>
      </div>
    </div>
      <?php if ($biz_lv == 3 || ($parent_group =="경영지원실" || $parent_group =="영업본부" || $parent_group =="기술연구소")){ ?>
    <div class="side_part" style="margin-bottom:200px;">
      <div class = "middle_menu_div">
          <span>관리자</span>
          <img src="<?php echo $misc;?>img/sideicon/side_up.svg" height="20px;" style ="cursor:pointer; padding:15px 15px 15px 0px;" onclick="updown(this);">
      </div>
      <div class="href_div">
      <?php if($parent_group =="경영지원실" || $parent_group =="기술연구소" || $group =="CEO" ){?>
      <a href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=admin" >&emsp;· 결재문서관리</a>
      <a href="<?php echo site_url();?>/biz/official_doc/official_doc_list?mode=admin" >&emsp;· 공문관리</a>
      <?php } ?>
      <a href="<?php echo site_url();?>/biz/approval/electronic_approval_form_list?mode=admin" >&emsp;· 양식관리</a>
      <a href="<?php echo site_url();?>/biz/approval/electronic_approval_format_category" >&emsp;· 서식함관리</a>
      <a href="<?php echo site_url();?>/biz/approval/electronic_approver_line_list" >&emsp;· 결재선관리</a>
    </div>
    </div>
      <?php }?>

    </div>

    <div id="funds_list_sidenav" class="sidenav3">
      <div style="width:100%; height:8vh; background-color:#3C3C3C;display:flex;align-items:center;justify-content:space-between">
        <span class="sidebar_title">매출현황</span>
        <img class="subside_btn" src="<?php echo $misc;?>img/sideicon/side_close.png" width="13px;" heigth="10px;" align="right" style ="cursor:pointer; padding:15px 15px 15px 0px;" onClick="subside_close();">
      </div>
      <div class="side_part">
          <a href="<?php echo site_url();?>/sales/funds/funds_list?mode=month" style="font-weight:bold;" >월별매출현황</a>
      </div>
      <div class="side_part">
          <a href="<?php echo site_url();?>/sales/funds/funds_list?mode=division" style="font-weight:bold;">분기별매출현황</a>
      </div>
    </div>

    <div id="order_completed_sidenav" class="sidenav3">
      <div style="width:100%; height:8vh; background-color:#3C3C3C;display:flex;align-items:center;justify-content:space-between">
        <span class="sidebar_title">수주여부</span>
        <img class="subside_btn" src="<?php echo $misc;?>img/sideicon/side_close.png" width="13px;" heigth="10px;" align="right" style ="cursor:pointer; padding:15px 15px 15px 0px;" onClick="subside_close();">
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/sales/forcasting/order_completed_list" style="font-weight:bold;" >수주완료</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/sales/forcasting/forcasting_list?mode=mistake" style="font-weight:bold;">실주</a>
      </div>
    </div>

    <div id="maintain_sidenav" class="sidenav3">
      <div style="width:100%; height:8vh; background-color:#3C3C3C;display:flex;align-items:center;justify-content:space-between">
        <span class="sidebar_title">유지보수</span>
        <img class="subside_btn" src="<?php echo $misc;?>img/sideicon/side_close.png" width="13px;" heigth="10px;" align="right" style ="cursor:pointer; padding:15px 15px 15px 0px;" onClick="subside_close();">
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/sales/maintain/maintain_list?type=001" style="font-weight:bold;">유지보수</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/sales/maintain/maintain_list?type=002" style="font-weight:bold;">통합유지보수</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/sales/maintain/maintain_unissued" style="font-weight:bold;">계산서 미발행 목록</a>
      </div>
    </div>

    <div id="fundreporting_sidenav" class="sidenav3">
      <div style="width:100%; height:8vh; background-color:#3C3C3C;display:flex;align-items:center;justify-content:space-between">
        <span class="sidebar_title">자금관리</span>
        <img class="subside_btn" src="<?php echo $misc;?>img/sideicon/side_close.png" width="13px;" heigth="10px;" align="right" style ="cursor:pointer; padding:15px 15px 15px 0px;" onClick="subside_close();">
      </div>
      <div class="side_part">
        <div class = "middle_menu_div">
            <span>자금보고</span>
            <img src="<?php echo $misc;?>img/sideicon/side_up.svg" height="20px;" style ="cursor:pointer; padding:15px 15px 15px 0px;" onclick="updown(this);">
        </div>
        <div class="href_div">
          <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_list?company=DUIT" style="font-weight:bold;" >&emsp;· 두리안정보기술</a>
          <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_list?company=DUITOLD" style="font-weight:bold;" >&emsp;· 두리안정보기술(구)</a>
          <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_list?company=DUICT" style="font-weight:bold;" >&emsp;· 두리안정보통신기술</a>
          <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_list?company=MG" style="font-weight:bold;" >&emsp;· 더망고</a>
          <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_list?company=DBS" style="font-weight:bold;" >&emsp;· 두리안정보기술부산지점</a>
          <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_list?company=DK" style="font-weight:bold;" >&emsp;· 던킨</a>
        </div>
      </div>
      <div class="side_part">
        <div class = "middle_menu_div">
            <span>히스토리</span>
            <img src="<?php echo $misc;?>img/sideicon/side_up.svg" height="20px;" style ="cursor:pointer; padding:15px 15px 15px 0px;" onclick="updown(this);">
        </div>
        <div class="href_div">
          <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_history_list?company=HIS_LIST" >&emsp;· 거래리스트로그</a>
          <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_history_bank?company=HIS_BANK" >&emsp;· 은행관리로그</a>
          <a href="<?php echo site_url();?>/sales/fundreporting/fundreporting_page_log?company=HIS_USER" >&emsp;· 접속로그</a>
        </div>
      </div>
    </div>
    <div id="purchase_sales_sidenav" class="sidenav3">
      <div style="width:100%; height:8vh; background-color:#3C3C3C;display:flex;align-items:center;justify-content:space-between">
        <span class="sidebar_title">매입매출장</span>
        <img class="subside_btn" src="<?php echo $misc;?>img/sideicon/side_close.png" width="13px;" heigth="10px;" align="right" style ="cursor:pointer; padding:15px 15px 15px 0px;" onClick="subside_close();">
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/sales/purchase_sales/purchase_sales_view" style="font-weight:bold;" >월별매입매출장</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/sales/purchase_sales/quarterly_purchase_sales_view" style="font-weight:bold;" >분기별매입매출장</a>
      </div>
    </div>

    <div id="attendance_admin_sidenav" class="sidenav3">
      <div style="width:100%; height:8vh; background-color:#3C3C3C;display:flex;align-items:center;justify-content:space-between">
        <span class="sidebar_title">근태관리</span>
        <img class="subside_btn" src="<?php echo $misc;?>img/sideicon/side_close.png" width="13px;" heigth="10px;" align="right" style ="cursor:pointer; padding:15px 15px 15px 0px;" onClick="subside_close();">
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/admin/attendance_admin/attendance_user_list" style="font-weight:bold;" >근태설정</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/admin/attendance_admin/attendance_list" style="font-weight:bold;" >근태조회</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/admin/attendance_admin/attendance_working_hours" style="font-weight:bold;" >근로시간통계</a>
      </div>
    </div>


    <div id="attendance_user_sidenav" class="sidenav3">
      <div style="width:100%; height:8vh; background-color:#3C3C3C;display:flex;align-items:center;justify-content:space-between">
        <span class="sidebar_title">근태관리</span>
        <img class="subside_btn" src="<?php echo $misc;?>img/sideicon/side_close.png" width="13px;" heigth="10px;" align="right" style ="cursor:pointer; padding:15px 15px 15px 0px;" onClick="subside_close();">
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/biz/attendance/attendance_user" style="font-weight:bold;" >출근기록</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/biz/attendance/attendance_working_hours" style="font-weight:bold;" >근로시간통계</a>
      </div>
      <!-- <div class="side_part">
        <a href="<?php echo site_url();?>/biz/attendance/attendance_statistics" style="font-weight:bold;" >통계</a>
      </div> -->
      <div class="side_part">
        <a href="<?php echo site_url();?>/biz/attendance/annual_usage_status" style="font-weight:bold;" >휴가사용현황</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/biz/attendance/annual_usage_status_list" style="font-weight:bold;" >휴가사용내역</a>
      </div>
    </div>

    <div id="annual_admin_sidenav" class="sidenav3">
      <div style="width:100%; height:8vh; background-color:#3C3C3C;display:flex;align-items:center;justify-content:space-between">
        <span class="sidebar_title">연차관리</span>
        <img class="subside_btn" src="<?php echo $misc;?>img/sideicon/side_close.png" width="13px;" heigth="10px;" align="right" style ="cursor:pointer; padding:15px 15px 15px 0px;" onClick="subside_close();">
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/admin/annual_admin/annual_management" style="font-weight:bold;">연차관리</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/admin/annual_admin/annual_usage_status" style="font-weight:bold;" >휴가사용현황</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/admin/annual_admin/annual_usage_status_list" style="font-weight:bold;" >휴가사용내역</a>
      </div>
    </div>


    <div id="manual_sidenav" class="sidenav3">
      <div style="width:100%; height:8vh; background-color:#3C3C3C;display:flex;align-items:center;justify-content:space-between">
        <span class="sidebar_title">자료실</span>
        <img class="subside_btn" src="<?php echo $misc;?>img/sideicon/side_close.png" width="13px;" heigth="10px;" align="right" style ="cursor:pointer; padding:15px 15px 15px 0px;" onClick="subside_close();">
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/tech/board/manual_list" style="font-weight:bold;" >자료실</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/tech/board/faq_list" style="font-weight:bold;">FAQ</a>
      </div>
      <!-- <a href="<?php echo site_url();?>/tech/board/edudata_list" style="font-weight:bold;">교육자료</a>
      <a href="<?php echo site_url();?>/tech/board/release_note_list" style="font-weight:bold;">릴리즈노트</a>
      <a href="<?php echo site_url();?>/tech/tech_board/tech_device_list" style="font-weight:bold;">장비/시스템등록</a> -->
    </div>

    <div id="education_sidenav" class="sidenav3">
      <div style="width:100%; height:8vh; background-color:#3C3C3C;display:flex;align-items:center;justify-content:space-between">
        <span class="sidebar_title">교육자료</span>
        <img class="subside_btn" src="<?php echo $misc;?>img/sideicon/side_close.png" width="13px;" heigth="10px;" align="right" style ="cursor:pointer; padding:15px 15px 15px 0px;" onClick="subside_close();">
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/tech/board/edudata_list" style="font-weight:bold;" >교육자료</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/tech/board/dailyWorkLog_list" style="font-weight:bold;">일일업무일지</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/tech/board/study_document_list" style="font-weight:bold;">스터디 자료</a>
      </div>
    </div>

    <div id="customer_sidenav" class="sidenav3">
      <div style="width:100%; height:8vh; background-color:#3C3C3C;display:flex;align-items:center;justify-content:space-between">
        <span class="sidebar_title">고객사</span>
        <img class="subside_btn" src="<?php echo $misc;?>img/sideicon/side_close.png" width="13px;" heigth="10px;" align="right" style ="cursor:pointer; padding:15px 15px 15px 0px;" onClick="subside_close();">
      </div>
<?php if((isset($this->cooperation_yn) && $this->cooperation_yn == 'Y')) { ?>
      <div class="side_part">
        <a href="<?php echo site_url();?>/tech/tech_board/tech_doc_list?type=Y" style="font-weight:bold;" >기술지원보고서</a>
      </div>
<?php } else { ?>
      <div class="side_part">
        <a href="<?php echo site_url();?>/tech/maintain/maintain_list" style="font-weight:bold;" >유지보수</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/tech/board/network_map_list" style="font-weight:bold;" >구성도</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/tech/tech_board/tech_doc_list?type=Y" style="font-weight:bold;" >기술지원보고서</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/tech/tech_board/request_tech_support_list" style="font-weight:bold;" >기술지원요청</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/tech/tech_board/tech_issue" style="font-weight:bold;">요청/이슈</a>
      </div>
<?php } ?>
    </div>

    <div id="equipment_sidenav" class="sidenav3">
      <div style="width:100%; height:8vh; background-color:#3C3C3C;display:flex;align-items:center;justify-content:space-between">
        <span class="sidebar_title">설비관리</span>
        <img class="subside_btn" src="<?php echo $misc;?>img/sideicon/side_close.png" width="13px;" heigth="10px;" align="right" style ="cursor:pointer; padding:15px 15px 15px 0px;" onClick="subside_close();">
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/admin/equipment/car_list" style="font-weight:bold;" >차량관리</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/admin/equipment/meeting_room_list" style="font-weight:bold;" >회의실관리</a>
      </div>
    </div>

    <div id="user_sidenav" class="sidenav3">
      <div style="width:100%; height:8vh; background-color:#3C3C3C;display:flex;align-items:center;justify-content:space-between">
        <span class="sidebar_title">회원관리</span>
        <img class="subside_btn" src="<?php echo $misc;?>img/sideicon/side_close.png" width="13px;" heigth="10px;" align="right" style ="cursor:pointer; padding:15px 15px 15px 0px;" onClick="subside_close();">
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/admin/account/user" style="font-weight:bold;" >회원정보</a>
      </div>
      <div class="side_part">
        <a href="<?php echo site_url();?>/admin/account/group_tree_management" style="font-weight:bold;" >조직도관리</a>
      </div>
      <?php if(($group =="경영지원실" || $parent_group == "기술연구소" || $group == "CEO")){?>
      <div class="side_part">
        <a href="<?php echo site_url();?>/admin/account/expense_list" style="font-weight:bold;" >지출통계</a>
      </div>
      <?php } ?>
    </div>

  </div>

  <div id="sidebar_open_div" style="display:none;">
      <img class="subside_btn" id="sub_open_btn" onClick="sub_open_btn();" src="<?php echo $misc;?>img/sideicon/side_open.png" width="13px;" heigth="10px;" align="right" style ="cursor:pointer; padding:15px 15px 15px 0px;">
  </div>
  <!-- <div id="main_contents" style="display:inline-block;min-height:100%;position:absolute;left:65px;right:0px;overflow:hidden;" > -->
  <div id="main_contents" class="main_content_extend">

<script type="text/javascript">
//점검 공지 띄울때 주석 제거
// <?php
// if($group != "기술연구소"){
// if(strpos($_SERVER['REQUEST_URI'], '/official_doc')!== false || strpos($_SERVER['REQUEST_URI'], '/approval')!== false){
// ?>
// $("#notice_modal").show();
// <?php
// }
// }
// ?>

var url_path = location.pathname.split('/')[3];

if (url_path != 'fundreporting') {
  var con = '정상 로그아웃';
  var login_time = sessionStorage.getItem('login_time');

    $.ajax({
      type: 'POST',
      url: '<?php echo site_url();?>/sales/fundreporting/logout',
      datatype: 'json',
      data: {
        con:con,
        login_time:login_time
      },
      success: function(data) {
        //console.log(data);
      }
    });
    // sessionStorage.clear();
    sessionStorage.removeItem("page");
    sessionStorage.removeItem("login_time");
}


function sidenav_view(){
  $("#sidenav").toggle();
}

// $(".sidenav2").bind("mouseleave", function(){
//   $(".sidenav2").hide();
// })
$('.menulist').click(function(){
  sessionStorage.setItem('subside', 'on');
})

function change_sidebar(menu, click_yn){
  // $("#sidebar_left").css({
  //   'min-height':'0%'
  // })
  if(click_yn =="click"){
  $("#sidebar_left").animate({
     width:'0%'
     // 'min-height':'0%',
     // height:'0%',
   }, 500,function(){
     $(".menulist").hide();
     switch (menu) {
       case 'biz':
         $(".point_menu").removeClass("point_menu");
         $("#biz_head").addClass("point_menu");
         $("#biz_side").show();
         break;

       case 'sales':
         $(".point_menu").removeClass("point_menu");
         $("#sales_head").addClass("point_menu");
         $("#sales_side").show();
         break;


       case 'tech':
         $(".point_menu").removeClass("point_menu");
         $("#tech_head").addClass("point_menu");
         $("#tech_side").show();
         break;


       case 'admin':
         $(".point_menu").removeClass("point_menu");
         $("#admin_head").addClass("point_menu");
         $("#admin_side").show();
         break;

     }
   })
   // var con_height = $("#main_contents").height();
   $("#sidebar_left").animate({
     // 'min-height':'100%',
     // 'height': con_height
     width:'65px'
   }, 500)

 }else{
   $(".menulist").hide();
   switch (menu) {
     case 'biz':
       $(".point_menu").removeClass("point_menu");
       $("#biz_head").addClass("point_menu");
       $("#biz_side").show();
       break;

     case 'sales':
       $(".point_menu").removeClass("point_menu");
       $("#sales_head").addClass("point_menu");
       $("#sales_side").show();
       break;


     case 'tech':
       $(".point_menu").removeClass("point_menu");
       $("#tech_head").addClass("point_menu");
       $("#tech_side").show();
       break;


     case 'admin':
       $(".point_menu").removeClass("point_menu");
       $("#admin_head").addClass("point_menu");
       $("#admin_side").show();
       break;

   }

 }




   var sub_class = $('#sidebar_sub').attr('class');
   if(sub_class == 'sidebar_sub_on'){
     subside_close();
      $("#sidebar_open_div").hide();
   }

}


$(document).ready(function(){
  // alert("zz");
  var path = $(location).attr('pathname');
  if(path=='/'){
    location.href ='<?php echo site_url();?>/biz/';
    }

  var path = path.split('/');
  var manu = path[2];
  change_sidebar(manu, "load");

  if (sessionStorage.getItem('menu_autocomplete') == null) {
    var menu_autocomplete = new Array();

    var m2 = '';
    var m3 = '';
    $('#sidenav a').each(function() {
      var data = new Object();

      var e = $(this);
      var c = e.attr('class');
      var t = $.trim(e.text()).replace('-','');
      var t2 = $.trim(e.text()).replace('-','');
      var h = e.attr('href');

      if (c != 'menu1') {
        var d = e.closest('div').attr('name');
        if (c == 'menu2') {
          t = d + ' -> ' + t;
        } else {
          var temp2 = $.trim(e.prev('.menu2').text()).replace('-', '');
          var temp3 = $.trim(e.prev('.menu3').text()).replace('-', '');
          if (temp2 != '') {
            m2 = temp2;
          }
          if (temp3 != '') {
            m3 = temp3;
          }
          if (c == 'menu3') {
            t = d + ' -> ' + m2 + ' -> ' + t;
          }
          if (c == 'menu4') {
            t = d + ' -> ' + m2 + ' -> ' + m3 + ' -> ' + t;
          }
        }

        data.href = h;
        data.label = t;
        data.value = t2;
        menu_autocomplete.push(data);
      }
    })
    console.log(menu_autocomplete);
    sessionStorage.setItem('menu_autocomplete', JSON.stringify(menu_autocomplete));
  }

  // var menus = JSON.parse(sessionStorage.getItem('menu_autocomplete'));
  //
  // $("#search_menu_input").autocomplete({
  //   minLength: 0,
  //   delay:0,
  //   source:JSON.parse(sessionStorage.getItem('menu_autocomplete')),
  //   minLength:2,
  //   autoFocus: true,
  //   select: function (event, ui) {
  //     // $('#menu_href').val(ui.item.href);
  //     window.location.href = ui.item.href;
  //   },focus: function( event, ui ) {
  //     return false;
  //   }
  // }).autocomplete( "instance" )._renderItem = function( ul, item ) {
  // //.autocomplete( "instance" )._renderItem 설절 부분이 핵심
  //     return $( "<li>" )	//기본 tag가 li로 되어 있음
  //       .append( "<div>" + item.label + "</div>" )	//여기에다가 원하는 모양의 HTML을 만들면 UI가 원하는 모양으로 변함.
  //       .appendTo( ul );	//웹 상으로 보이는 건 정상적인 "김치 볶음밥" 인데 내부에서는 ㄱㅊㅂㅇㅂ,김치 볶음밥 에서 검색을 함.
  //   };;

})

Mousetrap.bind('ctrl+space', function(e) {
  $("#search_menu_input").val('');
  $("#search_menu_modal").show();
  $("#search_menu_input").focus();
});
Mousetrap.bind('esc', function(e) {
  $("#search_menu_modal").hide();
});

function checkkey(e) {
  if (e.keyCode==27) {
    $("#search_menu_modal").hide();
  }
}

function updown(e){
  $(e).closest(".side_part").find(".href_div").slideToggle();

  const clsname = "reverse_btn";
  if($(e).hasClass(clsname)===true){
    $(e).removeClass(clsname);
  }else{
    $(e).addClass(clsname);
  }
}

</script>
