<link href="<?php echo $misc; ?>css/sidebar.css" type="text/css" rel="stylesheet">
<style media="screen">
  .side_top2{
    height:70px;
    width:30%;
    cursor: pointer;
  }
</style>

<!-- jquery-contextmenu -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.9.2/jquery.contextMenu.css" integrity="sha512-EF5k2tHv4ShZB7zESroCVlbLaZq2n8t1i8mr32tgX0cyoHc3GfxuP7IoT8w/pD+vyoq7ye//qkFEqQao7Ofrag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.9.2/jquery.contextMenu.js" integrity="sha512-2ABKLSEpFs5+UK1Ol+CgAVuqwBCHBA0Im0w4oRCflK/n8PUVbSv5IY7WrKIxMynss9EKLVOn1HZ8U/H2ckimWg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.9.2/jquery.ui.position.js" integrity="sha512-vBR2rismjmjzdH54bB2Gx+xSe/17U0iHpJ1gkyucuqlTeq+Q8zwL8aJDIfhQtnWMVbEKMzF00pmFjc9IPjzR7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
        <table>
       <?php
       foreach($boxname_full_arr as $b) {
         $dept = substr_count($b, '.');
         $padding = $dept * 20;
       ?>
           <tr class="box_tr context-menu-one2" id="<?php echo $b; ?>">
             <td style="padding-top:10px;padding-left:<?php echo $padding.'px'; ?>;<?php // if($dept==0){echo 'font-weight:bold;';} ?>" dept="<?php echo $dept; ?>">
               <img src="<?php echo $misc;?>img/icon/아래3.svg" class="down_btn" style="cursor:pointer;" onclick="updown(this, 'down');">
               <img src="<?php echo $misc;?>img/icon/오른쪽.svg" class="up_btn" style="display:none;cursor:pointer;" onclick="updown(this, 'up');">
               <?php if($dept != 0) {echo 'ㄴ';} ?>
               <?php
               if ($dept == 0) {
                 echo $b;
               } else {
                 $b_arr = explode('.', $b);
                 echo $b_arr[count($b_arr)-1];
               }
               ?>
             </td>
           </tr>
           <tr>
             <?php
             $b = str_replace('.', '_', $b);
              ?>
             <td style="padding-left:<?php echo $padding.'px'; ?>; display: none" id="<?php echo $b.'_add'; ?>">
               <input type="text" style="width: 100px;" id="<?php echo $b.'_text'; ?>" name="" value="">
               <input type="button" name="" value="추가" onclick="add_mbox(this);">
             </td>
           </tr>

       <?php
        }
       ?>
        </table>
         <!-- <span class="context-menu-one2 btn btn-neutral">right click me2</span> -->
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

// 메일함 목록 출력
$('td').each(function() {
  if($(this).attr('dept') == '0') {
    // $(this).find('img').hide();
  }
})

function updown(el, type) {
  var tr = $(el).closest('tr');
  var id = $(el).closest('tr').attr('id');
  console.log(id);
  if(type == 'down') {
    $('.box_tr').each(function() {
      var box_id = $(this).attr('id');
      if(box_id.indexOf(id+'.') != -1) {
        $(this).hide();
      }
    })
    tr.find('.up_btn').show();
    tr.find('.down_btn').hide();
  } else {
    $('.box_tr').each(function() {
      var box_id = $(this).attr('id');
      if(box_id.indexOf(id+'.') != -1) {
        $(this).show();
      }
    })
    tr.find('.down_btn').show();
    tr.find('.up_btn').hide();
  }
}

function add_mbox(ths) {
  let text = $(ths).closest('td').find("input").eq(0).val();
  console.log(text);
  let id = $(ths).closest('td').find("input").eq(0).attr('id');
  id = id.replace(/_/gi, '.');
  id = id.replace('.text', '');
  let new_mbox = id + '.' + text;
  $.ajax({
    url: "<?php echo site_url(); ?>/option/add_mailbox",
    type : "post",
    data : {mbox: new_mbox},
    success: function (res) {
      if(res=='o')  alert("메일함 [" + new_mbox + "] 생성완료");
      else  alert("메일함 생성 실패");
      location.reload();
    }
  });
}

$(function (){

  // $.ajax({
  //   url: "<?php echo site_url(); ?>/mailbox/decode_mailbox",
  //   type: 'POST',
  //   dataType: 'json',
  //   // cache: false,
  //   async:true,
  //   success: function (result) {
  //     $('#sidetree').jstree({
  //       'core' :{
  //         'data' : result
  //         },
  //         "plugins" : [ "wholerow" ]
  //       });
  //   }
  // });

  $.contextMenu({
    selector: '.context-menu-one2',
    items: {
       editCard: {
           name: "메일함 추가",
           callback: function(key, opt){
             console.log(key);
             console.log(opt);
               // alert("Clicked on " + key);
               // console.log(opt.$trigger);
               // console.log(opt.$trigger[0]);
               // console.log(opt.$trigger[0].id);
               let id = opt.$trigger[0].id;
               // id = id.replace('.', '_');
               id = id.replace(/\./gi, '_');
               let add_id = id + '_add';
               console.log(id);
               console.log(add_id);
               $('#'+add_id).show();

               // let new_mbox = opt.$trigger[0].id + '.' + 'test';
               // $.ajax({
               //   url: "<?php echo site_url(); ?>/option/add_mailbox",
               //   type : "post",
               //   data : {mbox: new_mbox},
               //   success: function (res) {
               //     if(res=='o')  alert("메일함 [" + new_mbox + "] 생성완료");
               //     else  alert("메일함 생성 실패");
               //     location.reload();
               //   }
               // });
           }
       },
       // deleteCard: {
       //     name: "카드 삭제",
       //     callback: function(key, opt){
       //         alert("Clicked on " + key);
       //     }
       // }
   }
  });

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
