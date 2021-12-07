<link href="<?php echo $misc; ?>css/sidebar.css" type="text/css" rel="stylesheet">
<style media="screen">
  .side_top2{
    height:70px;
    width:30%;
    cursor: pointer;
  }
</style>
<style media="screen">
.tree{
  margin-top: 5px;
}
.tree, .tree ul{
  list-style: none; /* 기본 리스트 스타일 제거 */
  padding-left:10px;
}
.tree *:before{
  width:15px;
  height:15px;
  display:inline-block;
}
.tree label{
  cursor: pointer;
  font-family: NotoSansKrMedium, sans-serif !important;
  font-size: 14px;
  color: #0055CC;
}
.tree label:hover{
  color: #00AACC;
}
.tree label:before{
  content: '+'
}
.tree label:hover:before{
  content: '+'
}
.tree label.lastTree:before{
  content:'o';
}
.tree label.lastTree:hover:before{
  content:'o';
}
.tree input[type="checkbox"] {
  display: none;
}
.tree input[type="checkbox"]:checked~ul {
  display: none;
}
.tree input[type="checkbox"]:checked+label:before{
  content: '↘';
}
.tree input[type="checkbox"]:checked+label:hover:before{
  content: '↘';
}

.tree input[type="checkbox"]:checked+label.lastTree:before{
  content: 'o';
}
.tree input[type="checkbox"]:checked+label.lastTree:hover:before{
  content: 'o';
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

      <?php
      if(isset($mbox)) {
        $mbox = str_replace('&', '%26', $mbox);
        $mbox = str_replace(' ', '+', $mbox);
      } else {
        $mbox = "inbox";
      }
       ?>

      <div class="" style="display:flex;justify-content: center;">
        <div class="side_top2" align="center" onclick="location.href='<?php echo site_url(); ?>/mailbox/mail_list?boxname=<?php echo $mbox; ?>&type=unseen'">
          <img src="<?php echo $misc;?>img/icon/schedule.svg" width="25"><br>
          안읽음
        </div>
        <div class="side_top2" align="center">
          <img src="<?php echo $misc;?>img/icon/side_important.svg" width="25" onclick="location.href='<?php echo site_url(); ?>/mailbox/mail_list?boxname=<?php echo $mbox; ?>&type=important'"><br>
          중&nbsp요
        </div>
        <div class="side_top2" align="center" onclick="location.href='<?php echo site_url(); ?>/mailbox/mail_list?boxname=<?php echo $mbox; ?>&type=attachments'">
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
          <a href="<?php echo site_url(); ?>/option/mailbox">설정</a>
        </div>
      </div>

      <!-- <ul>
        <li>
          <input type="checkbox" id="node21">
          <label for="node21" class="lastTree">node21</label>
        </li>
        <li>
          <input type="checkbox" id="node22">
          <label for="node21" class="lastTree">node22</label>
        </li>
      </ul> -->
      <div class="">
        <?php
          // var_dump($boxname_full_arr);
          echo $mbox_list_html;
         ?>
      </div>


    </div>
    <div id="sideMini">

    </div>
    <div id="dragbar" class="resize-handle-x" data-target="aside">

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

    // success: function (result) {
    //   // console.log(result);
    //   $('#sidetree').jstree({
    //     'core' :{
    //       'data' : result,
    //       'check_callback' : true
    //       },
    //       "plugins" : [ "wholerow", "contextmenu", "dnd"],
    //       'contextmenu' : {
    //         "items" : {
    //           "create" : {
    //             "separator_before" : false,
    //             "separator_after" : true,
    //             "label" : "하위폴더 생성",
    //             "action" : function(obj){
    //               // alert('하위폴더 생성')
    //               // console.log('aaa');
    //               var parentId = $('#sidetree').jstree('get_selected').attr('id');
    //               console.log(parentId);
    //             }
    //           }
    //         }
    //       },
    //     });
    // }
  });


  $.ajax({
    url: "<?php echo site_url(); ?>/home/get_side",
    // type: 'POST',
    dataType: 'json',
    async:true,
    success: function (result) {
      console.log(result);
      if(result == 'defalt'){
        $("#sideBar").css("width", 250);

      }else{
        var width = result;
        $("#sideBar").css("width", result);
      }

    }
  });

})

$('#sidetree').on("select_node.jstree", function (e, data) {

  // 우클릭시 이벤트 방지
  // var evt =  window.event || event;
  // var button = evt.which || evt.button;
  // if( button != 1 && ( typeof button != "undefined")) return false;

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


// var i = 0;
// $('#dragbar').mousedown(function(e) {

$(document).on('mousedown', '#dragbar', function(e){
  e.preventDefault();
  var x = e.pageX;
  var side_width = $("#sideBar").width();
  var diff = x - side_width;
  // var side_width = side_width + diff;
  console.log(diff);
  console.log(side_width);
  // console.log(x);

  $(document).mousemove(function(e) {
    var x2 = e.pageX;
    console.log(x2);
    var gap = (x) - (x2);
    gap = gap * -2;
    console.log(gap);
    // $("#dragbar").css('left', e.pageX + 2);
    c_width = side_width + gap;
    // console.log(gap);
    // console.log(c_width);

    $('#sideBar').css("width", e.pageX + 2);

  })
  // console.log("leaving mouseDown");
  $(document).mouseup(function(e) {
    // $('#clickevent').html('in another mouseUp event' + i++);
      $(document).unbind('mousemove');
      var side_width = $("#sideBar").width();
      $.ajax({
        url: "<?php echo site_url(); ?>/home/side_width_update",
        type: 'POST',
        dataType: 'json',
        data:{ side_width : side_width },
        async:true,
        success: function (result) {

        }
      });


  });
});



</script>
