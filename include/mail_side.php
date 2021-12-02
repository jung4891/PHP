<link href="<?php echo $misc; ?>css/sidebar.css" type="text/css" rel="stylesheet">
<style media="screen">
  .side_top2{
    height:70px;
    width:30%;
    cursor: pointer;
  }
</style>
<div id="main">
  <form class="" id="write_form" name="write_form" action="" method="post">
    <input type="hidden" id="self_write" name="self_write" value="">
  </form>
    <div id="sideBar">
      <div class="" align="center" style="margin-top:20px;margin-bottom:20px;">
        <button class="btn_basic btn_blue" type="button" name="button" onclick = "location.href='<?php echo site_url(); ?>/mail_write/page'" style="width:40%;">메일쓰기</button>
        <!-- <button type="button" name="button">메일쓰기</button> -->
        <button class="btn_basic btn_sky" type="button" name="button" onclick = "self_write();" style="width:40%">내게쓰기</button>
      </div>


      <div class="" style="display:flex;justify-content: center;">
        <div class="side_top2" align="center" onclick="location.href='<?php echo site_url(); ?>/mailbox/mail_list?boxname=inbox&type=unseen'">
          <img src="<?php echo $misc;?>img/icon/schedule.svg" width="25"><br>
          안읽음
        </div>
        <div class="side_top2" align="center">
          <img src="<?php echo $misc;?>img/icon/side_important.svg" width="25" onclick="location.href='<?php echo site_url(); ?>/mailbox/mail_list?boxname=inbox&type=important'"><br>
          중&nbsp요
        </div>
        <div class="side_top2" align="center" onclick="location.href='<?php echo site_url(); ?>/mailbox/mail_list?boxname=inbox&type=attachments'">
          <img src="<?php echo $misc;?>img/icon/side_attach.svg" width="25"><br>
          첨&nbsp부
        </div>
      </div>
      <form name="boxform" id="boxform" class="" action="" method="get">
        <input type="hidden" name="curpage" id="curpage" value="">
        <input type="hidden" name="searchbox" id="searchbox" value="">
        <input type="hidden" name="boxname" id="boxname" value="">
        <div id="sidetree">

        </div>
      </form>

      <div class="">
        <div class="" align="right" style="margin-right:5px;">
          <a href="<?php echo site_url(); ?>/option">설정</a>
        </div>
      </div>
    </div>
    <div id="sideMini">

    </div>


<script type="text/javascript">

// $("#headMenu").on("click", function(){
//   $("#sideBar, #sideMini").toggle();
// })

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

$('#sidetree').on("select_node.jstree", function (e, data) {
  var box_name = data.node.id;
  $("#boxname").val(box_name);
  var action = "<?php echo site_url(); ?>/mailbox/mail_list";
  $("#boxform").attr("action", action);
  $("#boxform").submit();
});

function self_write(){
  $("#self_write").val(4);
  $("#write_form").attr("method","post");
  $("#write_form").attr("action", "<?php echo site_url(); ?>/mail_write/page");
  $("#write_form").submit();
}



</script>