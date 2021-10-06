<link href="/misc/css/sidebar.css" type="text/css" rel="stylesheet">

<div id="main">
    <div id="sideBar">
      <div class="">
        <button type="button" name="button">메일쓰기</button>
        <button type="button" name="button">내게쓰기</button>
      </div>
      <div class="">
          <a href="#">

          <span style="align:center;">
            <img src="<?php echo $misc;?>img/icon/schedule.svg" width="20">
          </span><br>
          <span>
            안읽음
          </span>
          </a>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 중요</a>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 첨부</a>
      </div>
      <div class="">
        <ul>
          <a href="<?php echo site_url(); ?>/mail/mom_list"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> biz_mom</a>
        </ul>
        <ul>
          <a href="<?php echo site_url(); ?>/mail/get_all_mails"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 전체메일</a>
        </ul>
        <ul>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 받은메일함</a>
        </ul>
        <ul>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 내게쓴메일함</a>
        </ul>
        <ul>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 보낸메일함</a>
        </ul>
        <ul>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 임시보관함</a>
        </ul>
      </div>
      <div class="">
        <ul>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 스팸메일함</a>
        </ul>
        <ul>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 휴지통</a>
        </ul>
      </div>
      <div class="">
        <ul>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 주소록</a>
        </ul>
        <ul>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 중요연락처</a>
        </ul>

        <ul>
          <a href="<?php echo site_url(); ?>/equipment/meeting_room_list"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 회의실</a>
        </ul>
      </div>
    </div>
    <div id="sideMini">
aa
    </div>


<script type="text/javascript">
  $("#headMenu").on("click", function(){

      $("#sideBar, #sideMini").toggle();

  })
</script>
