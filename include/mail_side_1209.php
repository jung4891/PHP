<link href="<?php echo $misc; ?>css/sidebar.css" type="text/css" rel="stylesheet">
<style media="screen">
  .side_top2{
    height:70px;
    width:30%;
    cursor: pointer;
  }


  .select_side{
    color:#0575E6;
    font-weight: bold;
  }

  .box_tr:hover{
    background-color: #c7f1ff;
  }

  .box_tr td img{
    display: block;
    margin-left: auto;
    margin-right: auto;

}
</style>

<?php
$encryp_password = $this->M_account->mbox_conf($_SESSION['userid']);
$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
$key = $this->db->password;
$key = substr(hash('sha256', $key, true), 0, 32);
$decrypted = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);
$mailserver = "192.168.0.50";
$user_id = $_SESSION["userid"];
$user_pwd = $decrypted;
$default_folder = array(
  "INBOX",
  "&vPSwuA- &07jJwNVo-",
  "&x4TC3A- &vPStANVo-",
  "&yBXQbA- &ulTHfA-",
  "&ycDGtA- &07jJwNVo-"
);
// $defalt_fkey = array(
//   "inbox",
//   "sent",
//   "draft",
//   "spam",
//   "trash"
// );


// $mbox="";
$host = "{" . $mailserver . ":143/imap/novalidate-cert}";
$mails = @imap_open($host, $user_id, $user_pwd);
$folders = imap_list($mails, "{" . $mailserver . "}", '*');
$folders = str_replace("{" . $mailserver . "}", "", $folders);
sort($folders);

$folders_root = $default_folder;
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
  $folderkey = "custom";
  switch($text) {
    case "INBOX":  $text="받은메일함"; $folderkey="inbox";  break;
    case "보낸 편지함": $folderkey="sent"; break;
    case "임시 보관함": $folderkey="draft";  break;
    case "정크 메일":   $folderkey="spam";  break;
    case "지운 편지함": $folderkey="trash";  break;
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
    "folderkey" => $folderkey,
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
      <div class="" align="center" style="margin-top:20px;margin-bottom:20px;">

        <button class="btn_basic btn_blue" type="button" name="button" onclick = "location.href='<?php echo site_url(); ?>/mail_write/page'" style="width:40%;">메일쓰기</button>
        <!-- <button type="button" name="button">메일쓰기</button> -->
        <button class="btn_basic btn_sky" type="button" name="button" onclick = "self_write();" style="width:40%">내게쓰기</button>
      </div>
      <?php // echo $mbox ?>
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
        <div class="side_top2" align="center" onclick="location.href='<?php echo site_url(); ?>/mailbox/mail_list?boxname=<?php echo $mbox; ?>&type=important'">
          <img src="<?php echo $misc;?>img/icon/side_important.svg" width="25"><br>
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
      <div class="mailbox_div">
        <table>
        <?php foreach ($mailbox_tree as $b) {
          $i = 0;
          $box_len = count($mailbox_tree);
          $dept = $b['child_num'];
          $padding = $dept * 10;
          if($b["parent"] == "#"){
            ?>
          </table>
          <table class="mbox_tbl" id="<?php echo $b["id"]; ?>_tbl" border="0" cellspacing="0" cellpadding="0">
            <?php
          }
            ?>
        <tr class="box_tr context-menu-one2" id="<?php echo $b["id"]; ?>">
          <td height=30>
            <?php if($b["parent"] == "#" && $b["folderkey"] != "custom"){ ?>
            <img src="<?php echo $misc;?>img/sideicon/<?php echo $b["folderkey"]; ?>.svg" class="up_btn" style="cursor:pointer;">
          <?php } ?>
          </td>
          <td style="padding-left:<?php echo $padding.'px'; ?>;" dept="<?php echo $dept; ?>">
            <!-- <img src="<?php echo $misc;?>img/icon/아래3.svg" class="down_btn" style="cursor:pointer;" onclick="updown(this, 'down');">
            <img src="<?php echo $misc;?>img/icon/오른쪽.svg" class="up_btn" style="display:none;cursor:pointer;" onclick="updown(this, 'up');"> -->
            <?php if($dept != 0) {echo 'ㄴ';} ?>
            <?php
              echo $b['text'];
            ?>
          </td>
          <td style="color:#0575E6;">
            <?php echo ($b['unseen'] == 0)?"":$b['unseen']; ?>
          </td>
        </tr>
        <tr style="display: none">
            <td></td>
            <td style="padding-left:<?php echo $padding.'px'; ?>;" id="<?php echo $b["id"].'_add'; ?>">
              <input type="text" style="width: 100px;" id="<?php echo $b["id"].'_text'; ?>" name="" value="">
              <input type="button" name="" value="추가" onclick="add_mbox(this);">
            </td>
            <td></td>
          </tr>
          <?php
          if($i == $box_len){
            echo "</table>";
          }
          $i++;
        }
          ?>
        </table>
      </div>

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

$(function (){
  <?php
  if(strpos($_SERVER['REQUEST_URI'],'mailbox/') !== false){
    if(isset($_GET["boxname"])){

        $select_box = $_GET["boxname"];
        if($select_box == ""){
          $select_box = "INBOX";
        }
    } else {
      $select_box = "INBOX";
    }
    ?>
    $("[id='<?php echo $select_box; ?>']").addClass("select_side");
    <?php
  }
  ?>


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
               // console.log($(this)[0]);
               // console.log(this.next()[0].style.cssText);

               this.next()[0].style.cssText = "dispaly: contents";
               $(this).next()[0].childNodes[3].childNodes[1].focus();
               // this.next()[0].style.display = "contents";
               // $(this).next()[0].style.display = "contents";
               // console.log($(this).next()[0].find("input"));
               // console.log();
               // $(this).next()[0].show();
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
      // console.log(result);
      if(result == 'defalt'){
        $("#sideBar").css("width", 250);

      }else{
        var width = result;
        $("#sideBar").css("width", result);
      }

    }
  });

})


$(".mailbox_div").on("click", ".box_tr", function(){
  var trid = $(this).attr("id");
  $("#boxname").val(trid);
  var action = "<?php echo site_url(); ?>/mailbox/mail_list";
  $("#boxform").attr("action", action);
  $("#boxform").submit();
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


function add_mbox(ths) {
  let text = $(ths).closest('td').find("input").eq(0).val();
  let id = $(ths).closest('td').find("input").eq(0).attr('id');
  id = id.replace(/_/gi, '.');
  id = id.replace('.text', '');
  console.log(id);
  console.log(text);
  // let new_mbox = id + '.' + text;
  // console.log(new_mbox);
  $.ajax({
    url: "<?php echo site_url(); ?>/option/add_mailbox2",
    type : "post",
    data : {parent: id, child_input: text},
    success: function (res) {
      if(res=='o')  alert("메일함 [" + text + "] 생성완료");
      else {
        console.log(res);
        alert("메일함 생성 실패");
      }
      location.reload();
    }
  });
}


</script>
