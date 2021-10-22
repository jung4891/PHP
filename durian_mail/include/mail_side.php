<link href="/misc/css/sidebar.css" type="text/css" rel="stylesheet">

<div id="main">
    <div id="sideBar">
      <div class=""> <br> &nbsp&nbsp
        <button type="button" name="button">메일쓰기</button> &nbsp&nbsp
        <button type="button" name="button">내게쓰기</button>
      </div>
      <div class="">
          <!-- <a href="#">

          <span style="align:center;">
            <img src="<?php echo $misc;?>img/icon/schedule.svg" width="20">
          </span><br>
          <span>
            안읽음
          </span>
          </a> -->
          <!-- <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 중요</a>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 첨부</a> -->
      </div>
      <div class="">
        <!-- <ul>
          <a href="<?php echo site_url(); ?>/mail/mom_list"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> biz_mom</a>
        </ul> -->
        <ul>
          <a href="<?php echo site_url(); ?>/mail_test"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 테스트</a>
        </ul>
        <ul>
          <?php
            // $config['permitted_uri_chars'] = 'a-zA-Z 0-9~%$&.:_\-';   ->  URL에 허용되는 문자 추가해야함
            $box = 'INBOX';
           ?>
          <a href="<?php echo site_url(); ?>/Mailbox/mail_list/<?php echo $box ?>"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 전체메일</a>
        </ul>
        <ul>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 받은메일함</a>
        </ul>
        <ul>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 내게쓴메일함</a>
        </ul>
        <ul>
          <?php
            $box = mb_convert_encoding('보낸 편지함', 'UTF7-IMAP', 'UTF-8');    // UTF-8 -> UTF7-IMAP 인코딩
           ?>
          <a href="<?php echo site_url(); ?>/Mailbox/mail_list/<?php echo $box ?>"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 보낸메일함</a>
        </ul>
        <ul>
          <?php
            $box = mb_convert_encoding('임시 보관함', 'UTF7-IMAP', 'UTF-8');
           ?>
          <a href="<?php echo site_url(); ?>/Mailbox/mail_list/<?php echo $box ?>"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 임시보관함</a>
        </ul>
      </div>
      <div class="">
        <ul>
          <?php
            $box = mb_convert_encoding('정크 메일', 'UTF7-IMAP', 'UTF-8');
           ?>
          <a href="<?php echo site_url(); ?>/Mailbox/mail_list/<?php echo $box ?>"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 스팸메일함</a>
        </ul>
        <ul>
          <?php
            $box = mb_convert_encoding('지운 편지함', 'UTF7-IMAP', 'UTF-8');
           ?>
          <a href="<?php echo site_url(); ?>/Mailbox/mail_list/<?php echo $box ?>"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 휴지통</a>
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
aaaaaa <br>
aaaaa
    </div>


<script type="text/javascript">
  $("#headMenu").on("click", function(){

      $("#sideBar, #sideMini").toggle();

  })
</script>
