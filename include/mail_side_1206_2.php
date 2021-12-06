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
      <!-- <form name="boxform" id="boxform" class="" action="" method="get">
        <input type="hidden" name="curpage" id="curpage" value="">
        <input type="hidden" name="searchbox" id="searchbox" value="">
        <input type="hidden" name="boxname" id="boxname" value="">
        <div id="sidetree">

        </div>
      </form> -->

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
        <!-- tree형 메뉴 -->
        <ul class="tree">
          <li>
            <input type="checkbox" id="root">
            <label for="root">받은메일함</label>
            <ul>
              <li>
                <input type="checkbox" id="node1">
                <label for="node1" class="lastTree">node1</label>
              </li>
              <li>
                <input type="checkbox" id="node2">
                <label for="node2">node2</label>

              </li>
            </ul>
          </li>
        </ul>

        <?php
        $folder_root = array();
        for($i=0; $i<count($boxname_full_arr); $i++) {
          $folder = $boxname_full_arr[$i];
          if(substr_count($folder, '.') == 0) {
            array_push($folder_root, $folder);
          }
        }
        $folders = array();
        for($i=0; $i<count($folder_root); $i++) {
          $folders[$i]['root'] = $folder_root[$i];
        }

        for($i=0; $i<count($folder_root); $i++) {
        ?>
        <ul class="tree">
          <li>
            <input type="checkbox" id="root2">
            <label for="root2" class="lastTree"><?php echo $folder_root[$i]; ?></label>
          </li>
        </ul>
        <?php
        }

         ?>
      </div>

      <pre>
      <?php
        var_dump($folders);
        // var_dump($boxname_full_arr);
       ?>
     </pre>

    </div>
    <div id="sideMini">

    </div>

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

<script type="text/javascript">

// $("#headMenu").on("click", function(){
//   $("#sideBar, #sideMini").toggle();
// })

// 새로운 메일함 출력
$(function (){
  $.ajax({
    url: "<?php echo site_url(); ?>/mailbox/decode_mailbox2",
    type: 'POST',
    dataType: 'json',
    // cache: false,
    async:true,
    success: function (result) {
      console.log(result);
    }
  });
})

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



</script>
