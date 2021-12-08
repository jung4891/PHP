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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.9.2/jquery.contextMenu.js" integrity="sha512-2ABKLSEpFs5+UK1Ol+CgAVuqwBCHBA0Im0w4oRCflK/n8PUVbSv5IY7WrKIxMynss9EKLVOn1HZ8U/H2ckimWg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.9.2/jquery.ui.position.js" integrity="sha512-vBR2rismjmjzdH54bB2Gx+xSe/17U0iHpJ1gkyucuqlTeq+Q8zwL8aJDIfhQtnWMVbEKMzF00pmFjc9IPjzR7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<?php
$encryp_password = $this->M_account->mbox_conf($_SESSION['userid']);
$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
$key = $this->db->password;
$key = substr(hash('sha256', $key, true), 0, 32);
$decrypted = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);
$mailserver = "192.168.0.50";
$user_id = $_SESSION["userid"];
$user_pwd = $decrypted;
$defalt_folder = array(
  "INBOX",
  "&vPSwuA- &07jJwNVo-",
  "&x4TC3A- &vPStANVo-",
  "&yBXQbA- &ulTHfA-",
  "&ycDGtA- &07jJwNVo-"
);
$mbox="";
$host = "{" . $mailserver . ":143/imap/novalidate-cert}$mbox";
$mails = @imap_open($host, $user_id, $user_pwd);
$folders = imap_list($mails, "{" . $mailserver . "}", '*');
$folders = str_replace("{" . $mailserver . "}", "", $folders);
sort($folders);

$folders_root = $defalt_folder;
$folders_sub = array();

foreach($folders as $f) {
  if(substr_count($f, '.') == 0) {
    if(in_array($f,$folders_root )){
        continue;
    }

    array_push($folders_root, $f);
  } else {
    array_push($folders_sub, $f);
  }
}
$folders_sorted = array();
foreach($folders_root as $root) {
  array_push($folders_sorted, $root);
  foreach($folders_sub as $sub) {
    $pos_dot = strpos($sub, '.');
    $sub_root = substr($sub, 0, $pos_dot);
    if($sub_root == $root) {
      array_push($folders_sorted, $sub);
    }
  }
}
$folders = $folders_sorted;
$mailbox_tree = array();
for ($i=0; $i < count($folders); $i++) {
  $fid = $folders[$i];
  $mbox_status = imap_status($mails, "{" . $mailserver . "}".$fid, SA_UNSEEN);
  $exp_folder = explode(".", $folders[$i]);
  $length = count($exp_folder);
  $text = mb_convert_encoding($exp_folder[$length-1], 'UTF-8', 'UTF7-IMAP');
  switch($text) {
    case "INBOX":  $text="받은메일함";  break;
    // case "보낸 편지함":  $text="보낸메일함";  break;
    // case "임시 보관함":  $text="임시보관함";  break;
    // case "정크 메일":  $text="스팸메일함";  break;
    // case "지운 편지함":  $text="휴지통";  break;
  }

  $substr_count = substr_count($folders[$i], ".");
  if($substr_count > 1){
    $parent_folder = implode(".", explode(".", $folders[$i], -1));
  }elseif ($substr_count == 1) {
    $parent_folder = $exp_folder[0];
  }else{
    $parent_folder = "#";
  }
  $tree = array(
    // "name" => $folders[$i],
    "id" => $fid,
    "parent" => $parent_folder,
    "text" => $text,
    "child_num" => $substr_count,
    "unseen" => $mbox_status->unseen,
    "state" => array("opened" => true)
  );
  array_push($mailbox_tree, $tree);
}

 ?>

<div id="main">
  <form class="" id="write_form" name="write_form" action="" method="post">
    <input type="hidden" id="self_write" name="self_write" value="">
  </form>
  <?php
  if ($_SESSION['s_width'] == "" || !isset($_SESSION['s_width'])) {
    $side_w = 250;
  } else {
    $side_w =$_SESSION['s_width'];
  }
  ?>
    <div id="sideBar" width="<?php echo $side_w; ?>">
      <?php
      // echo '<pre>';
      // var_dump($mailbox_tree);
      // echo '</pre>';

      ?>

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
      <div class="">
        <table>
        <?php foreach ($mailbox_tree as $b) {
          $dept = $b['child_num'];
          $padding = $dept * 20;
          $parent = mb_convert_encoding($b['parent'], 'UTF-8', 'UTF7-IMAP');
          $parent = str_replace('#', '', $parent);
          $parent = str_replace('.', '_', $parent);
          $child = ($b["text"] == "받은메일함")? "INBOX" : $b["text"] ;
          $name_full = ($parent == '')? $child : $parent.'_'.$child;
        ?>
        <tr class="box_tr context-menu-one2" id="<?php echo $b["id"]; ?>">
          <td style="padding-left:<?php echo $padding.'px'; ?>;" dept="<?php echo $dept; ?>">
            <!-- <img src="<?php echo $misc;?>img/icon/아래3.svg" class="down_btn" style="cursor:pointer;" onclick="updown(this, 'down');">
            <img src="<?php echo $misc;?>img/icon/오른쪽.svg" class="up_btn" style="display:none;cursor:pointer;" onclick="updown(this, 'up');"> -->
            <?php if($dept != 0) {echo 'ㄴ';} ?>
            <?php
              echo $b['text'];
            ?>
          </td>
          <td>
            <?php echo ($b['unseen'] == 0)?"":$b['unseen']; ?>
          </td>
        </tr>
        <tr style="display: none">
            <?php
            // $box_name = $b["text"];
            // $box_name = str_replace('.', '_', $box_name);
             ?>
            <td style="padding-left:<?php echo $padding.'px'; ?>;" id="<?php echo $b["id"].'_add'; ?>">
              <input type="text" style="width: 100px;" id="<?php echo $b["id"].'_text'; ?>" name="" value="">
              <input type="button" name="" value="추가" onclick="add_mbox(this);">
            </td>
          </tr>
          <?php
        }
          ?>
        </table>
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


    </div>
    <div id="sideMini">

    </div>
    <div id="dragbar" class="resize-handle-x" data-target="aside">

    </div>


<script type="text/javascript">

// $("#headMenu").on("click", function(){
//   $("#sideBar, #sideMini").toggle();
// })

function add_mbox(ths) {
  let text = $(ths).closest('td').find("input").eq(0).val();
  console.log(text);
  let id = $(ths).closest('td').find("input").eq(0).attr('id');
  console.log(id);
  id = id.replace(/_/gi, '.');
  id = id.replace('.text', '');
  let new_mbox = id + '.' + text;
  console.log(new_mbox);
  $.ajax({
    url: "<?php echo site_url(); ?>/option/add_mailbox2",
    type : "post",
    data : {mbox: new_mbox},
    success: function (res) {
      if(res=='o')  alert("메일함 [" + new_mbox + "] 생성완료");
      else {
        console.log(res);
        alert("메일함 생성 실패");
      }
      location.reload();
    }
  });
}

$(function (){

  $(`#aa`).show();

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

  $.contextMenu({
    selector: '.context-menu-one2',
    items: {
       editCard: {
           name: "메일함 추가",
           callback: function(key, opt){
               // console.log(key);
               // console.log(opt);
               // console.log(opt.$trigger);
               // console.log(opt.$trigger[0]);
               // console.log(opt.$trigger[0].id);
               // let id = opt.$trigger[0].id;
               // let id = opt.$trigger[0].next();
               $(this).next()[0].style.display = "block";
               // console.log($(this).next()[0].style.display);

               // $(this).next()[0].show();
               // console.log(id);

               // $('#'+id+'_add').show();

               // id = id.replace('.', '_');
               // id = id.replace(/\./gi, '_');
               // let add_id = id + '_add';
               // console.log('id : ' + id);
               // console.log('add_id: ' + add_id);


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

$('#sidetree').bind('loaded.jstree', function(e, data) {
  var box_name = '<?php echo urldecode($mbox); ?>';

  if(box_name == 'inbox') {
    box_name = 'INBOX';
  }

  $('.jstree-anchor').each(function() {
    var node_id = $(this).attr('id');
    if(node_id.indexOf(box_name) != -1) {
      $(this).css('font-weight', 'bold');
      return false;
    }
    // if (box_name.indexOf('INBOX') || box_name == 'INBOX') {
    //   $('#INBOX_anchor').css('font-weight', 'bold');
    // }
  })
})

function self_write(){
  $("#self_write").val(4);
  $("#write_form").attr("method","post");
  $("#write_form").attr("action", "<?php echo site_url(); ?>/mail_write/page");
  $("#write_form").submit();
}


// var i = 0;
$('#dragbar').mousedown(function(e) {

// $(document).on('mousedown', '#dragbar', function(e){
  // e.preventDefault();
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
    gap = gap * -2.2;
    console.log(gap);
    // $("#dragbar").css('left', e.pageX + 2);
    c_width = side_width + gap;
    // console.log(gap);
    // console.log(c_width);

    $('#sideBar').css("width", c_width);

  })
  // console.log("leaving mouseDown");
  .mouseup(function(e) {
    // $('#clickevent').html('in another mouseUp event' + i++);
      // $(document).unbind('mousemove');
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
      $(document).unbind('mousemove');
      $(document).unbind('mouseup');
  });

});



</script>
