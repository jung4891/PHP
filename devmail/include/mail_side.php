<link href="<?php echo $misc; ?>css/sidebar.css" type="text/css" rel="stylesheet">

<div id="main">
    <div id="sideBar">
      <div class="">
        <button type="button" name="button" onclick = "location.href='<?php echo site_url(); ?>/mail_write/page'">메일쓰기</button>
        <!-- <button type="button" name="button">메일쓰기</button> -->
        <button type="button" name="button" onclick = "location.href='<?php echo site_url(); ?>/mail/mail_self_write'">내게쓰기</button>
      </div>
      <?php
        $mbox2 = str_replace('&', '%26', $mbox);
        $mbox2 = str_replace(' ', '+', $mbox2);
      ?>
      <br>
      <div class="">
          <a href="<?php echo site_url(); ?>/mailbox/mail_list?boxname=<?php echo $mbox2?>&type=unseen">
            <img src="<?php echo $misc;?>img/icon/schedule.svg" width="20">안읽음</a>
          <a href="#"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 중요</a>
          <a href="<?php echo site_url(); ?>/mailbox/mail_list?boxname=<?php echo $mbox2?>&type=attachments">
            <img src="<?php echo $misc;?>img/icon/schedule.svg" width="20"> 첨부</a>
      </div>
      <br>
      <form name="boxform" id="boxform" class="" action="" method="get">
        <input type="hidden" name="curpage" id="curpage" value="">
        <input type="hidden" name="searchbox" id="searchbox" value="">
        <input type="hidden" name="boxname" id="boxname" value="">
        <div id="sidetree">

        </div>
      </form>

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


$(function (){
  $.ajax({
    url: "<?php echo site_url(); ?>/mailbox/decode_mailbox",
    type: 'POST',
    dataType: 'json',
    // cache: false,
    async:true,
    success: function (result) {
      $('#sidetree').jstree({
        'core' :{
          'data' : result
          },
          "plugins" : [ "wholerow" ]
        });
    }
  });
})

  $("#headMenu").on("click", function(){
      $("#sideBar, #sideMini").toggle();
  })

  $('#sidetree').on("select_node.jstree", function (e, data) {
    var box_name = data.node.id;
    $("#boxname").val(box_name);
    var action = "<?php echo site_url(); ?>/mailbox/mail_list";
    $("#boxform").attr("action", action);
    $("#boxform").submit();
  });



</script>
