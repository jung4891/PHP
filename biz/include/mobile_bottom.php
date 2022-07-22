<style media="screen">
  .footer {
    height: 50px;
    background-color:#fff;
    /* clear:both; */
    position: fixed;
    bottom: 0;
    width: 100%;
  }
</style>
<div class="footer">
  <table style="height:50px;width:100%;">
    <tr>
      <td width="33.3%" align="center" style="vertical-align:middle;">
        <img src="<?php echo $misc;?>img/mobile/footer_home.svg" width="30px" onclick="go_page('home');">
      </td>
      <td width="33.3%" align="center" style="vertical-align:middle;">
        <img src="<?php echo $misc;?>img/mobile/footer_schedule.svg" width="30px" onclick="go_page('schedule');">
      </td>
      <td width="33.3%" align="center" style="vertical-align:middle;">
        <!-- 검색 기능은 페이지마다 달라서 페이지 마다 추가 -->
        <img src="<?php echo $misc;?>img/mobile/footer_search.svg" width="30px" onclick="open_search();">
      </td>
    </tr>
  </table>
</div>
<script type="text/javascript">
function go_page(id) {
  if(id=='schedule') {
    location.href = "<?php echo site_url(); ?>/biz/schedule/tech_schedule_mobile";
  } else if (id=='durian_car') {
    location.href = "<?php echo site_url(); ?>/biz/durian_car/car_drive_list";
  } else if (id=='approval') {
    location.href = "<?php echo site_url(); ?>/biz/approval/electronic_approval_list?type=standby";
  } else if (id=='home') {
    location.href = "<?php echo site_url(); ?>";
  } else if (id=='notice') {
    location.href = "<?php echo site_url(); ?>/biz/board/notice_list?category=001";
  } else if (id=='attendance') {
    location.href = "<?php echo site_url(); ?>/biz/attendance/attendance_user";
  } else if (id=='address') {
    location.href = "<?php echo site_url(); ?>/admin/account/user";
  } else if (id=='weeklyreport') {
    location.href = "<?php echo site_url(); ?>/biz/weekly_report/weekly_report_list";
  } else {
    alert('준비 중입니다.');
  }
}
</script>
