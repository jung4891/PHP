<link href="/misc/css/sidebar.css" type="text/css" rel="stylesheet">

<div id="main">
    <div id="sideBar">
      <div class="">
        <button type="button" name="button" onclick = "location.href='<?php echo site_url(); ?>/mail_write/page'">메일쓰기</button>
        <!-- <button type="button" name="button">메일쓰기</button> -->
        <button type="button" name="button" onclick = "location.href='<?php echo site_url(); ?>/mail/mail_self_write'">내게쓰기</button>
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
          <a href="<?php echo site_url(); ?>/mailbox/mail_list/inbox">
            <img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 전체메일</a>
        </ul>
        <ul>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 받은메일함</a>
        </ul>
        <ul>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 내게쓴메일함</a>
        </ul>
        <ul>
          <a href="<?php echo site_url(); ?>/mailbox/mail_list/sent">
            <img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 보낸메일함</a>
        </ul>
        <ul>

          <!-- 기존 url로 디코딩된 메일함명 보냈던 부분 -->
          <!-- // $box = mb_convert_encoding('임시 보관함', 'UTF7-IMAP', 'UTF-8');    // UTF-8 -> UTF7-IMAP 인코딩 -->
          <!-- <a href="<?php echo site_url(); ?>/Mailbox/mail_list/<?php echo $box ?>"><img src="<?php echo $misc;?>img/ico  n/schedule.svg" width="20"> 임시보관함</a> -->

          <!-- 기존 동적 form 사용해서 post로 보냈던 부분 (페이징에서 오류) -->
          <!-- <a href="javascript:mailbox('<?php echo mb_convert_encoding('임시 보관함', 'UTF7-IMAP', 'UTF-8'); ?>')"> -->

          <a href="<?php echo site_url(); ?>/mailbox/mail_list/tmp">
            <img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 임시보관함</a>
        </ul>
      </div>
      <div class="">
        <ul>
          <a href="<?php echo site_url(); ?>/mailbox/mail_list/spam">
            <img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 스팸메일함</a>
        </ul>
        <ul>
          <a href="<?php echo site_url(); ?>/mailbox/mail_list/trash">
            <img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 휴지통</a>
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
