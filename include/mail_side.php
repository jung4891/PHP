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

  .sideunseen{
    position:absolute;
    left:43px;
    color:#ffffff;
    background-color:#a1a1a1;
    font:16px;
    width:17px;
    height: 17px;
    border-radius: 50%;
  }

  .select_side td:not(:first-child) img{
    /* filter: invert(39%) sepia(74%) saturate(5687%) hue-rotate(197deg) brightness(98%) contrast(96%); */
  }


  .box_tr{
    cursor: pointer;
  }

  .box_tr:hover{
    background-color: #e7f3ff;
  }

  .box_tr td img{
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.mbox_tbl{
  width: 80%;
}
</style>

<?php
$encryp_password = $this->M_account->mbox_conf($_SESSION['userid']);
$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
$key = $this->db->password;
$key = substr(hash('sha256', $key, true), 0, 32);
$decrypted = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);
// $mailserver = "192.168.0.100";
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
    case "INBOX":  $text="받은 편지함"; $folderkey="inbox";  break;
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
    $side_w = 300;
  } else {
    $side_w =$_SESSION['s_width'];
  }
  ?>
    <div id="sideBar" style="width:<?php echo $side_w; ?>px">
      <div class="" align="center" style="margin-top:20px;margin-bottom:20px;">

        <button class="btn_basic btn_blue" type="button" name="button" onclick = "location.href='<?php echo site_url(); ?>/mail_write/page'" style="width:40%;height:40px;">메일쓰기</button>
        <!-- <button type="button" name="button">메일쓰기</button> -->
        <button class="btn_basic btn_sky" type="button" name="button" onclick = "self_write();" style="width:40%;height:40px;">내게쓰기</button>
      </div>

      <?php
      if(isset($mbox)) {
        $mbox2 = str_replace('&', '%26', $mbox);
        $mbox2 = str_replace(' ', '+', $mbox2);
      } else {
        $mbox2 = "INBOX";
      }
       ?>

      <div class="" style="display:flex;justify-content: center;">
        <?php
          if(isset($type) && $type == "unseen") {
            $url_route = $mbox2;
            $font_style = "font-weight: bold; color: #0575E6;";
          }else {
            $url_route = $mbox2.'&type=unseen';
            $font_style = "";
          }
         ?>
        <div class="side_top2" align="center" onclick="location.href='<?php echo site_url(); ?>/mailbox/mail_list?boxname=<?php echo $url_route; ?>'">
          <!-- <img src="<?php echo $misc;?>img/icon/schedule.svg" width="25"><br> -->
         <div class="" style="padding-bottom: 3px; font-size: 18px; <?php echo $font_style?>">
           <?php
           if(isset($mbox)) {   // 메일쓰기 페이지에서 오류방지
             $key = array_search($mbox, array_column($mailbox_tree, "id"));
             $unseen_cnt = $mailbox_tree[$key]["unseen"];
             echo $unseen_cnt;
           }else {
             echo 0;
           }
            ?>
         </div>
          <span style="<?php if(isset($type) && $type == 'unseen') echo 'font-weight: bold;'?>">안읽음</span>
        </div>
        <?php
        if(isset($type) && $type == "important") {
          $url_route = $mbox2;
          $img_flag = "중요(본문)2.svg";
        }else {
          $url_route = $mbox2.'&type=important';
          $img_flag = "중요(본문).svg";
        }
         ?>
        <div class="side_top2" align="center" onclick="location.href='<?php echo site_url(); ?>/mailbox/mail_list?boxname=<?php echo $url_route; ?>'">
          <img src="<?php echo $misc;?>img/icon/<?php echo $img_flag ?>" width="25"><br>
          <span style="<?php if(isset($type) && $type == 'important') echo 'font-weight: bold;'?>">중&nbsp;요</span>
        </div>
        <?php
        if(isset($type) && $type == "attachments") {
          $url_route = $mbox2;
          $img_attach = "첨부2(사이드바).svg";
        }else {
          $url_route = $mbox2.'&type=attachments';
          $img_attach = "첨부(본문).svg";
        }
         ?>
        <div class="side_top2" align="center" onclick="location.href='<?php echo site_url(); ?>/mailbox/mail_list?boxname=<?php echo $url_route; ?>'">
          <img src="<?php echo $misc;?>img/icon/<?php echo $img_attach ?>" width="25"><br>
          <span style="<?php if(isset($type) && $type == 'attachments') echo 'font-weight: bold;'?>">첨&nbsp;부</span>
        </div>
      </div>
      <form name="boxform" id="boxform" class="" action="" method="get">
        <input type="hidden" name="curpage" id="curpage" value="">
        <input type="hidden" name="searchbox" id="searchbox" value="">
        <input type="hidden" name="boxname" id="boxname" value="">
      </form>
      <div class="mailbox_div" id="side_mbox" align="center">
        <?php
        $i = 0;
        if(strpos($_SERVER['REQUEST_URI'],'mailbox/') !== false){
          if(isset($_GET["boxname"])){

              $sel_box = $_GET["boxname"];
              if($sel_box == ""){
                $sel_box = "INBOX";
              }
          } else {
            $sel_box = "INBOX";
          }
        }
        foreach ($mailbox_tree as $b) {
          if(isset($sel_box)){
            $sel_img = ($sel_box == $b["id"])?"2":"";
          }else{
            $sel_img = "";
          }
          $box_len = count($mailbox_tree);
          $dept = $b['child_num'];
          $padding = $dept * 15;
          if($b["parent"] == "#"){
            ?>
          <table class="mbox_tbl" id="<?php echo $b["id"]; ?>_tbl" border="0" cellspacing="0" cellpadding="0">
          <col width="12%">
          <col width="78%">
          <!-- <col width="7%"> -->
          <col width="15%">

            <?php
          }
            ?>
        <tr class="box_tr <?php if($b["folderkey"] == "custom") echo 'context-menu-one2'; else  echo 'context-menu-default'; ?>" id="<?php echo $b["id"]; ?>" child_num="<?php echo $b["child_num"]; ?>">
        <td height=30 align="left">
          <?php if($b["parent"] == "#" && $b["folderkey"] != "custom"){ ?>
          <img src="<?php echo $misc;?>img/sideicon/<?php echo $b["folderkey"].$sel_img; ?>.svg" style="cursor:pointer;">
        <?php } ?>
        </td>
        <?php
          $arr = explode('.', $b["id"]);
          $id_me = $arr[count($arr)-1];
         ?>
        <td id="<?php echo $b['text'] ?>" align="left" style="padding-left:<?php echo $padding.'px'; ?>;" dept="<?php echo $dept; ?>">
          <?php
            echo $b['text'];
          ?>
          <?php echo ($b['unseen'] == 0)?"":"(".$b['unseen'].")"; ?>
        </td>
        <!-- <td align="right" style="color:#0575E6;">
        </td> -->
          <td height=30 align="center" onclick="event.cancelBubble=true">
            <?php
            if ($i+1 < $box_len) {

              if ($b["id"] == $mailbox_tree[$i+1]["parent"]) {
              ?>
                <img src="<?php echo $misc;?>img/icon/아래3.svg" class="down_btn" style="cursor:pointer;" onclick="updown(this, 'down');">
                <img src="<?php echo $misc;?>img/icon/오른쪽.svg" class="up_btn" style="display:none;cursor:pointer;" onclick="updown(this, 'up');">
            <?php
              }
            }
            ?>
          </td>
        </tr>
        <tr style="display: none" class="right_click_event">
            <td></td>
        <td colspan="2" style="padding-left:<?php echo $padding.'px'; ?>;" >
          <input type="text" style="width: 70px" class="except_event" id="<?php echo $b["id"].'_text'; ?>"  name="" value="">
          <input type="button"  value="추가" class="except_event" onclick="add_mbox(this);">
              <input type="button" name="" value="취소" class="except_event" onclick="cancel(this);">
              <span style="display: none" id="<?php echo $b["parent"] ?>"></span>
            </td>
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

        <div class="" style="border-top:2px solid #dedede;padding-top:10px;" align="center">
          <table class="mbox_tbl" border="0" cellspacing="0" cellpadding="0">
            <colgroup>
            <col width="1%">
            <col width="50%">
            <!-- <col width="7%"> -->
            <col width="35%">
            </colgroup>
            <tr class="box_tr" onclick="document.location='<?php echo site_url(); ?>/option/user'" id="option_tr">
            <td height=30 align="left">
              <img id="setting_img" src="<?php echo $misc;?>img/sideicon/setting2.svg" style="cursor:pointer;">
              </td>
            <td style="padding-left:2px">
                설정
              </td>
              <td></td>
            </tr>
          </table>
        </div>
      </div>


    </div>
    <div id="sideMini" align="center">
      <table id="minitbl" align="center">
        <tr onclick = "location.href='<?php echo site_url(); ?>/mail_write/page'">
          <td>
            <img src="<?php echo $misc;?>img/sideicon/side_write.svg">
          </td>
        </tr>
        <?php
        $i = 0;
        foreach ($mailbox_tree as $b) {
          if(isset($sel_box)){
            $sel_img = ($sel_box == $b["id"])?"2":"";
          }else{
            $sel_img = "";
          }
          $box_len = count($mailbox_tree);
          $dept = $b['child_num'];
          $padding = $dept * 20;
          if($b["parent"] == "#" && $b["folderkey"] != "custom"){
        ?>
<tr class="box_tr" id="<?php echo $b["id"]; ?>">
  <td height=30 align="center">
    <div class="sideunseen" <?php if($b['unseen'] == 0) echo "style='display:none';"; ?>>
      <?php echo ($b['unseen'] == 0)?"":$b['unseen']; ?>
    </div>
    <img src="<?php echo $misc;?>img/sideicon/<?php echo $b["folderkey"].$sel_img; ?>.svg" style="height:35px;">
    <?php echo $b['text']; ?>
  </td>
</tr>
            <?php
          }
        }
            ?>
      </table>
    </div>

    <div id="dragbar" class="resize-handle-x" data-target="aside">

    </div>


<script type="text/javascript">
var sidetype = sessionStorage.getItem("sidemode");
if(sidetype == "mini"){
  $("#sideBar, #sideMini, #dragbar").toggle();
}



$("#headMenu").on("click", function(){
  $("#sideBar, #sideMini, #dragbar").toggle();
  var mode = sessionStorage.getItem("sidemode");
  if(mode == null){
    sessionStorage.setItem("sidemode", "mini");
  }else if(mode == "mini"){
    sessionStorage.setItem("sidemode", "general");
  }else{
    sessionStorage.setItem("sidemode", "mini");
  }
})

$(function (){
  var mboxtoggle = sessionStorage.getItem("mboxtoggle");
  // alert(mboxtoggle);
  // console.log(mboxtoggle);
  if(mboxtoggle != null && mboxtoggle !=""){
    var mb_arr = mboxtoggle.split(",");
    // console.log(mb_arr);
    // var mb_arr = JSON.parse(mboxtoggle);
    // console.log(mb_arr);
    for (var i = 0; i < mb_arr.length; i++) {
      var target = mb_arr[i];
      // var btn = $("[id='"+ target + "']").find('.down_btn');
      $('.box_tr').each(function() {
        var box_id = $(this).attr('id');
        if(box_id.indexOf(target+'.') != -1) {
          $(this).hide();
        }
      })
      $("[id='"+ target + "']").find('.up_btn').show();
      $("[id='"+ target + "']").find('.down_btn').hide();

      // btn.click();
      // console.log(btn);
      // btn.trigger("click");
      // console.log(mb_arr.length);
    }
  }

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

  if(strpos($_SERVER['REQUEST_URI'],'option/') !== false){
  ?>
  $("#option_tr").addClass("select_side");
  $("#setting_img").attr("src", "<?php echo $misc;?>img/sideicon/setting.svg");
  <?php
  }
  ?>

  $.contextMenu({
    selector: '.context-menu-one2',
    items: {
       add: {
           name: "메일함 추가",
           callback: function(key, opt){

            this.next()[0].style.cssText = "display: contents";
            $(this).next()[0].childNodes[3].childNodes[1].value = '';   // 수정버튼뒤 추가버튼 누를때 공백으로
            $(this).next()[0].childNodes[3].childNodes[1].focus();
           }
       },
       modify: {
           name: "메일함 수정",
           callback: function(key, opt){

            this.next()[0].style.cssText = "display: contents";
            // let target = $(this)[0].childNodes[3].childNodes[0].nodeValue;
            let target = $(this)[0].childNodes[3].id;
            // target = target.replace('ㄴ', '');
            target = $.trim(target);
            $(this).next()[0].childNodes[3].childNodes[1].value = target;
            $(this).next()[0].childNodes[3].childNodes[3].value = "수정";
            // $(this).next()[0].childNodes[5].childNodes[1].val;
            // $(this).next()[0].childNodes[3].childNodes[1].focus().select();
            // $(this).next().find('input')[0].focus();
            $(this).next().find('input')[0].select();
           }
       },
       delete: {
           name: "메일함 삭제",
           callback: function(key, opt){
             let id = this[0].id;
             let folders = [];
             folders.push(id);

             let mbox_tree = '<?php echo json_encode($mailbox_tree) ?>';
             mbox_tree = JSON.parse(mbox_tree);
             let target_i = 0;
             $.each(mbox_tree, function(index, el) {
               if(el['id'] == id) {
                 target_i = index;
                 return;
               }
             });
             for(var i=target_i+1; i<mbox_tree.length; i++) {
               // console.log(mbox_tree[i]['parent'].indexOf(id));
               if(mbox_tree[i]['parent'].indexOf(id) != -1) {
                 folders.push(mbox_tree[i]['id']);
               }else {
                 break;
               }
             };

             let alert = (folders.length == 1)? "메일함을 삭제합니다. \n해당메일함의 모든 메일은 휴지통으로 이동됩니다. \n\n계속하시겠습니까?" : "메일함을 삭제합니다. \n해당메일함 및 하위 메일함의 모든 메일은 휴지통으로 이동됩니다. \n\n계속하시겠습니까?";

             if(confirm(alert) == true) {
               $.ajax({
                 url: "<?php echo site_url(); ?>/option/del_mailbox",
                 type : "post",
                 data : {folders: folders},
                 success: function (res) {
                   var mbox = '<?php if(isset($mbox)) echo $mbox; ?>';
                   var mbox_exist = false;
                   for(var i=0; i<folders.length; i++) {
                     if(folders[i] == mbox) {
                       mbox_exist = true;
                       break;
                     }
                   }
                   if(mbox_exist) {
                     var url =  "<?php echo site_url(); ?>/mailbox/mail_list";
                     location.href = url;
                   }else {
                     location.reload();
                   }
                 },
                 error : function(request, status, error){
                   console.log(error);
                 }
               });
             } else {
               return;
             }
           }
         },
       }
     });


  $.contextMenu({
    selector: '.context-menu-default',
    items: {
       add: {
           name: "메일함 추가",
           callback: function(key, opt){
             this.next()[0].style.cssText = "display: contents";
            $(this).next()[0].childNodes[3].childNodes[1].value = '';
            $(this).next()[0].childNodes[3].childNodes[1].focus();
           }
       },

   }
  });


  $.ajax({
    url: "<?php echo site_url(); ?>/home/get_side",
    // type: 'POST',
    dataType: 'json',
    async:true,
    success: function (result) {
      // console.log(result);
      if(result == 'default'){
        $("#sideBar").css("width", 250);

      }else{
        var width = result;
        $("#sideBar").css("width", result);
      }

    }
  });

})

function updown(el, type) {
  var mboxtoggle = sessionStorage.getItem("mboxtoggle");
  // alert(mboxtoggle);
  // console.log(mboxtoggle);
  if(mboxtoggle != null && mboxtoggle !=""){
    var downarr = mboxtoggle.split(",");
  }else{
    var downarr = [];

  }
  var tr = $(el).closest('tr');
  var child_num = $(el).closest('tr').attr('child_num');
  var id = $(el).closest('tr').attr('id');

  if(type == 'down') {
    $('.box_tr').each(function() {
      var box_id = $(this).attr('id');
      if(box_id.indexOf(id+'.') != -1) {
        $(this).hide();
      }
    })

    if(downarr.indexOf(id) == -1) {
      downarr.push(id);
    }
    sessionStorage.setItem("mboxtoggle", downarr);
    tr.find('.up_btn').show();
    tr.find('.down_btn').hide();
  }
  else {
    $('.box_tr').each(function() {
      var box_id = $(this).attr('id');
      if(box_id.indexOf(id+'.') != -1) {
        $(this).show();
      }
    })

    if(downarr.indexOf(id) != -1) {
      for(let i = 0; i < downarr.length; i++) {
        if(downarr[i] === id)  {
          downarr.splice(i, 1);
          i--;
        }
      }
    }

    tr.find('.down_btn').show();
    tr.find('.up_btn').hide();
    sessionStorage.setItem("mboxtoggle", downarr);
  }

  // console.log(downarr);
}

$(".mailbox_div, #sideMini").on("click", ".box_tr", function(){
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
// $('#dragbar').mousedown(function(e) {

$(document).on('mousedown', '#dragbar', function(e){
  e.preventDefault();
  var x = e.pageX;
  console.log(x);
  var side_width = document.getElementById('sideBar' ).style.width;
  side_width = parseInt(side_width);
  // console.log("siw"+side_width);
  var diff = x - side_width;
  // var side_width = side_width + diff;
  // console.log(diff);
  // console.log(side_width);
  // console.log(x);

  $(document).on("mousemove.sidemove",function(e){
    var x2 = e.pageX;
    var gap = (x) - (x2);
    gap = (gap * -1);
    gap = (gap)+(gap*0.8);


    // $("#dragbar").css('left', e.pageX + 2);
    var c_width = side_width + gap;
    // console.log(gap);
    console.log(c_width);
    var min_width = 250;
    var max_width = 900;
    if (c_width < min_width) {
      c_width = min_width;
    }

    if (c_width > max_width) {
      c_width = max_width;
    }
    $('#sideBar').css("width", c_width);

  })

  .on("mouseup.sideup",function(e){

      // var side_width = $("#sideBar").width();
      // console.log(side_width);
      // console.log(c_width);
      var after_width =document.getElementById('sideBar' ).style.width;
      $.ajax({
        url: "<?php echo site_url(); ?>/home/side_width_update",
        type: 'POST',
        dataType: 'json',
        data:{ side_width : after_width },
        async:true,
        success: function (result) {

        }
      });
      $(document).unbind('mousemove.sidemove');
      $(document).unbind('mouseup.sideup');
  });

});


function add_mbox(ths) {
  let text = $(ths).closest('td').find("input").eq(0).val();
  var pattern = /[,\.]/;
  if(pattern.test(text)) {
    alert('메일함 이름에 ,와 .는 포함할 수 없습니다.');
    // $(ths).closest('td').find("input").eq(0).focus();
    $(ths).closest('td').find("input").eq(0).select();
    return;
  }

  let mode = $(ths).closest('td').find("input").eq(1).val();
  if(mode === "추가") {
    let parent = $(ths).closest('tr').prev()[0].id;
    let mbox_tree = '<?php echo json_encode($mailbox_tree) ?>';
    mbox_tree = JSON.parse(mbox_tree);
    let children = [];
    $.each(mbox_tree, function(index, el) {
      if(el['parent'] == parent) {
        children.push(el['text']);
      }
    });
    if($.inArray(text, children) != -1) {
      alert("이미 동일한 이름의 메일함이 존재합니다.");
      // $(ths).closest('td').find("input").eq(0).focus();
      $(ths).closest('td').find("input").eq(0).select();
      return;
    }else {
      let id = $(ths).closest('td').find("input").eq(0).attr('id');
      id = id.replace(/_/gi, '.');
      id = id.replace('.text', '');
      $.ajax({
        url: "<?php echo site_url(); ?>/option/add_mailbox",
        type : "post",
        data : {parent_mbox: id, new_mbox: text},
        success: function (res) {
          // if(res=='o')  alert("메일함 [" + text + "] 생성완료");
          // else {
          //   console.log(res);
          //   alert("메일함 생성 실패");
          // }
          location.reload();
        }
      });
    }
  }else {
    // mode == 수정
    let parent = $(ths).next().next()[0].id;
    let mbox_tree = '<?php echo json_encode($mailbox_tree) ?>';
    mbox_tree = JSON.parse(mbox_tree);
    let children = [];
    $.each(mbox_tree, function(index, el) {
      if(el['parent'] == parent) {
        children.push(el['text']);
      }
    });
    if($.inArray(text, children) != -1) {
      alert("이미 동일한 이름의 메일함이 존재합니다.");
      // $(ths).closest('td').find("input").eq(0).focus();
      $(ths).closest('td').find("input").eq(0).select();
      return;
    }else {
      let parent = $(ths).next().next().attr('id');
      parent = (parent === "#")? '' : parent;
      let target = $(ths).closest('tr').prev()[0].childNodes[3].id;
      target = $.trim(target);
      $.ajax({
        url: "<?php echo site_url(); ?>/option/rename_mailbox",
        type : "post",
        data : {parent: parent, old_mbox: target, new_mbox: text},
        success: function (res) {
          let className = $(ths).closest('tr').prev()[0].className;
          if(className.indexOf('select_side') == -1) {
            location.reload();
          } else {
            var mbox = parent+'.'+text;
            var page = '<?php echo (isset($_GET["curpage"]))? $_GET["curpage"] : "" ?>';
            var newForm = $('<form></form>');
            newForm.attr("method","get");
            newForm.attr("action", "<?php echo site_url(); ?>/mailbox/mail_list");
            newForm.append($('<input>', {type: 'hidden', name: 'curpage', value: page }));
            newForm.append($('<input>', {type: 'hidden', name: 'boxname', value: mbox }));
            newForm.appendTo('body');
            newForm.submit();
          }
        }
      });
    }
  }
}

function cancel(ths) {
  $(ths).closest('tr')[0].style.display = "none";
}

$('html').on('mousedown', function(e){
  if(!$(e.target).hasClass('except_event')) {
    $('.right_click_event').hide();
  }
});

</script>
