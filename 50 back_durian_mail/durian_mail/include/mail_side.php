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
          <a href="/index.php/Mailbox/mail_list/INBOX">
            <img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 전체메일</a>
        </ul>
        <ul>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 받은메일함</a>
        </ul>
        <ul>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 내게쓴메일함</a>
        </ul>
        <ul>
          <a href="/index.php/Mailbox/mail_list/SENT">
            <img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 보낸메일함</a>
        </ul>
        <ul>

          <!-- 기존 url로 디코딩된 메일함명 보냈던 부분 -->
          <!-- // $box = mb_convert_encoding('임시 보관함', 'UTF7-IMAP', 'UTF-8');    // UTF-8 -> UTF7-IMAP 인코딩 -->
          <!-- <a href="<?php echo site_url(); ?>/Mailbox/mail_list/<?php echo $box ?>"><img src="<?php echo $misc;?>img/ico  n/schedule.svg" width="20"> 임시보관함</a> -->

          <!-- 기존 동적 form 사용해서 post로 보냈던 부분 (페이징에서 오류) -->
          <!-- <a href="javascript:mailbox('<?php echo mb_convert_encoding('임시 보관함', 'UTF7-IMAP', 'UTF-8'); ?>')"> -->

          <a href="/index.php/Mailbox/mail_list/TMP">
            <img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 임시보관함</a>
        </ul>
      </div>
      <div class="">
        <ul>
          <a href="/index.php/Mailbox/mail_list/SPAM">
            <img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 스팸메일함</a>
        </ul>
        <ul>
          <a href="/index.php/Mailbox/mail_list/TRASH">
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

    </div>

<script type="text/javascript">

  // js 매개변수를 php로 받을 수가 없어서 아얘 선처리후 매개변수에 넣음 (하지만 페이징처리가 안되어서 x)
  function mailbox(box) {
    // alert(box);
    var newForm = $('<form></form>');
    // newForm.attr("name","newForm");
    newForm.attr("method","post");
    newForm.attr("action", "/index.php/Mailbox/mail_list/"+box);
    // newForm.attr("target","_blank");

    newForm.append($('<input/>', {type: 'hidden', name: 'mailbox', value: box }));
    newForm.appendTo('body');
    newForm.submit();
  }
  $("#headMenu").on("click", function(){
      $("#sideBar, #sideMini").toggle();
  })
</script>
