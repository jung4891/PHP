<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $this->config->item('site_title');?></title>
    <link href="/misc/css/jquery-ui.css" type="text/css" rel="stylesheet">
    <link href="/misc/css/mobile/main_mobile.css" type="text/css" rel="stylesheet">
    <link href="/misc/css/mobile/style_mobile.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
    <!-- <script src="/misc/js/jquery-ui.min.js"></script> -->
    <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
    <script src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.9.2/jquery.contextMenu.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.9.2/jquery.contextMenu.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.9.2/jquery.ui.position.js"></script>

  </head>

  <!-- header에서 mailbox_tree 배열 가져오기 위해 side에서 아래 php부분 옮김 -->
  <?php
  $encryp_password = $this->M_account->mbox_conf($_SESSION['userid']);
  $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
  $key = $this->db->password;
  $key = substr(hash('sha256', $key, true), 0, 32);
  $decrypted = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);
  $mailserver = "192.168.0.100";
  // $mailserver = "mail.durianit.co.kr";
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
      "id" => addslashes($fid),
      "parent" => addslashes($parent_folder),
      "text" => $text,
      "child_num" => $substr_count,
      "unseen" => $mbox_status->unseen,
      "folderkey" => $folderkey
      // "state" => array("opened" => true)
    );
    array_push($mailbox_tree, $tree);
  }

    // 메일함명 상단출력
    $mbox_decoded = mb_convert_encoding($mbox, 'UTF-8', 'UTF7-IMAP');
    $mbox_decoded = str_replace('INBOX', '받은 편지함', $mbox_decoded);
    if(strpos($mbox_decoded, '.')) {
      $exp_folder = explode(".", $mbox_decoded);
      $parent =  $exp_folder[0];
      $last_child = $exp_folder[count($exp_folder)-1];
      $head_title = $last_child;
      // $head_title = "{$last_child} ({$parent})"; // 테스트(받은 편지함) 이런식으로 출력되면 너무 길어져서 주석처리
    }else {
      $head_title = $mbox_decoded;
    }

  ?>
  <meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
  <style media="screen">
  @import url(//fonts.googleapis.com/earlyaccess/notosanskr.css);
  html, body {
    /* max-width: 100%; */
    /* min-width: 100%; */
    width:100%;
    height: 100%;
    margin: 0;
  }

  #m_header{
    height: 75px;
    width: 100%;
    display: grid;
    grid-template-columns: 10px 35px auto 50px 50px 5px;
    align-items: center;
    column-gap: 5px;
    font-family:"Noto Sans KR", sans-serif !important;
  }

  .img_div img{
    display: block;
    margin-left: auto;
    margin-right: auto;
}

/* #mobile_side{
  display: grid;
  grid-template-rows: 50px 60px 0px auto 110px;
} */
#mobile_nav{
  position: fixed !important;
}
#mobile_side{
  width:100%;
  height:100%;
  /* display: grid; */
  /* grid-template-rows: 60px 60px auto 60px 30px; */
  display: flex;
  flex-direction: column;
}

#side_mbox{
  /* max-height: 60%; */
  /* width:100%; */
  overflow-y: scroll;
  border-top: 1px solid #dedede;
  border-bottom: 1px solid #dedede;

}
.mailbox_div{
   /* padding: 0px 20px; */
}

.mbox_tbl{
  width:90%;
}

.mbox_tbl td img{
  display: block;
  margin-left: auto;
  margin-right: auto;

}
  </style>
  <body>
      <div id="m_header">
          <div>
          </div>
          <div id="historyback_div" class="img_div" onClick="javascript:history.back();">
            <img src="/misc/img/back.svg" style="width:25px;">
          </div>
          <div>
              <span id="mailLogo" style="font-size: 22px;font-weight: bolder; color: black">
                <?php echo $head_title; ?>
              </span>

              <!-- 읽지 않은 메일수 옆에 출력 -->
              <span style="font-size: 22px; color: red">
              <?php
              if(isset($mbox)) {   // 메일쓰기 페이지에서 오류방지
                $mbox_addslash = addslashes($mbox);
                $key = array_search($mbox_addslash, array_column($mailbox_tree, "id"));
                $unseen_cnt = $mailbox_tree[$key]["unseen"];
                if($unseen_cnt !== 0)  echo '&nbsp'.$unseen_cnt;
              }else {
                echo '';
              }
               ?>
              </span>
          </div>

          <div class="img_div" onclick="location.href='<?php echo site_url(); ?>/mail_write/page'">
            <img src="/misc/img/sideicon/sent.svg" style="width:33px;">
          </div>

          <div id="listBtn" class="img_div">
            <img src="/misc/img/side_list.svg" style="width:33px;">
          </div>
          <div>
          </div>

      </div>
<!-- 사이드바 -->
      <div id="mobile_nav" style="height: calc(100vh - 75px);width:calc(100vw - 100px);background-color:#ffffff; display:none; border-radius: 30px 0px 0px 0px;">
        <div id="mobile_side" class="" style="">
          <div class="" style="height:60px;display: flex;flex-direction: column;justify-content: center;padding-left:20px;" onclick="myinfo();">
            <span style="font-weight:bold;font-size:18px;">
                  <?php echo $_SESSION['name']; ?>
            </span>
            <span onclick="myinfo();" style="font-weight:bold;font-size:14px;color:grey;">
                  <?php echo $_SESSION['userid']; ?>
            </span>
          </div>

          <div class="" style="height:60px;display:flex;justify-content: space-around;">
            <?php
              if(isset($mbox)) {
                // $mbox2 = str_replace('&', '%26', $mbox);
                // $mbox2 = str_replace(' ', '+', $mbox2);
                $mbox_urlencode = urlencode($mbox);
              } else {
                $mbox_urlencode = "INBOX";
              }

              if(isset($type) && $type == "unseen") {
                $url_route = $mbox_urlencode;
                $font_style = "font-weight: bold;";
              }else {
                $url_route = $mbox_urlencode.'&type=unseen';
                $font_style = "";
              }
             ?>
            <div class="side_top2" align="center" onclick="location.href='<?php echo site_url(); ?>/mailbox/mail_list?boxname=<?php echo $url_route; ?>'">
              <!-- <img src="<?php echo $misc;?>img/icon/schedule.svg" width="25"><br> -->
             <div class="" style="padding-bottom: 3px; font-size: 18px; color: #F25757; <?php echo $font_style?>">
               <?php
               if(isset($mbox)) {   // 메일쓰기 페이지에서 오류방지
                 $mbox_addslash = addslashes($mbox);
                 $key = array_search($mbox_addslash, array_column($mailbox_tree, "id"));
                 $unseen_cnt = $mailbox_tree[$key]["unseen"];
                 echo $unseen_cnt;
               }else {
                 echo 0;
               }
                ?>
             </div>
              <span style="<?php if(isset($type) && $type == 'unseen') echo 'font-weight: bold;'?>; font-size: small; display: block;">안읽음</span>
            </div>
            <?php
            if(isset($type) && $type == "important") {
              $url_route = $mbox_urlencode;
              $img_flag = "중요(본문)2.svg";
            }else {
              $url_route = $mbox_urlencode.'&type=important';
              $img_flag = "중요(본문).svg";
            }
             ?>
            <div class="side_top2" align="center" onclick="location.href='<?php echo site_url(); ?>/mailbox/mail_list?boxname=<?php echo $url_route; ?>'">
              <img src="<?php echo $misc;?>img/icon/<?php echo $img_flag ?>" width="25"><br>
              <span style="<?php if(isset($type) && $type == 'important') echo 'font-weight: bold;'?> font-size: small; display: block;">중&nbsp;요</span>
            </div>
            <?php
            if(isset($type) && $type == "attachments") {
              $url_route = $mbox_urlencode;
              $img_attach = "첨부2(사이드바).svg";
            }else {
              $url_route = $mbox_urlencode.'&type=attachments';
              $img_attach = "첨부(본문).svg";
            }
             ?>
            <div class="side_top2" align="center" onclick="location.href='<?php echo site_url(); ?>/mailbox/mail_list?boxname=<?php echo $url_route; ?>'">
              <img src="<?php echo $misc;?>img/icon/<?php echo $img_attach ?>" width="25"><br>
              <span style="<?php if(isset($type) && $type == 'attachments') echo 'font-weight: bold;'?> font-size: small; display: block;">첨&nbsp;부</span>
            </div>
            <div class="side_top2" align="center" onclick="location.href='<?php echo site_url(); ?>/mail_write/page'">
              <img src="<?php echo $misc;?>img/sideicon/sent.svg" width="25"><br>
              <span style="font-size: small; display: block;">메일쓰기</span>
            </div>
          </div>


          <div class="mailbox_div" id="side_mbox" style="max-height:50%;">
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
                $sel_img = ($sel_box == $b["id"])?"":"";
              }else{
                $sel_img = "";
              }
              $box_len = count($mailbox_tree);
              $dept = $b['child_num'];
              $padding = $dept * 15;
              if($b["parent"] == "#"){
                ?>
              <table class="mbox_tbl" id="<?php echo $b["id"]; ?>_tbl" border="0" cellspacing="0" cellpadding="0">
              <col width="10%">
              <col width="80%">
              <!-- <col width="7%"> -->
              <col width="10%">

                <?php
              }
                ?>
            <tr class="box_tr <?php if($b["folderkey"] == "custom") echo 'context-menu-one2'; else  echo 'context-menu-default'; ?>" id="<?php echo $b["id"]; ?>" child_num="<?php echo $b["child_num"]; ?>">
              <td height=30 align="right">
                <?php if($b["parent"] == "#" && $b["folderkey"] != "custom"){ ?>
                <img src="<?php echo $misc;?>img/sideicon/<?php echo $b["folderkey"].$sel_img; ?>.svg" style="cursor:pointer; padding-top: 5px">
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
                <span style="color:#F25757; margin-right:5px;">
                <?php echo ($b['unseen'] == 0)? "" : ( ($b['unseen'] > 99)? "99+" : $b['unseen'] ) ; ?>
                </span>
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
              <?php
              if($i == $box_len){
                echo "</table>";
              }
              $i++;
            }
              ?>
            </table>
          </div>
          <div class="mailbox_div">
            <table class="mbox_tbl" border="0" cellspacing="0" cellpadding="0" style="padding-top:10px;">
                <colgroup>
                  <col width="10%">
                  <col width="80%">
                  <col width="10%">
                </colgroup>
                <tr class="" onclick="document.location='<?php echo site_url(); ?>/option/user'" id="option_tr">
                  <td height=30 align="right">
                    <img id="setting_img" src="<?php echo $misc;?>img/sideicon/setting2.svg" style="cursor:pointer;">
                  </td>
                  <td style="">
                    설정
                  </td>
                  <td></td>
                </tr>
                <tr class="" onclick="document.location='<?php echo site_url(); ?>/account/logout'" id="logout_tr">
                  <td height=30 align="right">
                    <img src="<?php echo $misc;?>img/sideicon/로그아웃.svg" style="cursor:pointer;">
                  </td>
                  <td style="">
                    로그아웃
                  </td>
                  <td></td>
                </tr>
              </table>

          </div>
          <div class="">
            <form name="boxform" id="boxform" class="" action="" method="get">
              <!-- <input type="hidden" name="curpage" id="curpage" value="">
              <input type="hidden" name="searchbox" id="searchbox" value=""> -->
              <input type="hidden" name="boxname" id="boxname" value="">
            </form>

          </div>

        </div>
      </div>


<script type="text/javascript">

  $(function(){


  });

    <?php
  if(strpos($_SERVER['REQUEST_URI'],'option/') !== false){
  ?>
    $("#option_tr").addClass("select_side");
    $("#setting_img").attr("src", "<?php echo $misc;?>img/sideicon/setting.svg");
  <?php
  }
  ?>

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
    trid = trid.replace(/\\'/g, "'");  // 메일함에 '있는경우 애러처리
    $("#boxname").val(trid);
    var action = "<?php echo site_url(); ?>/mailbox/mail_list";
    $("#boxform").attr("action", action);
    $("#boxform").submit();
  })

  $("#listBtn").click(function(){
    // alert('testtt');
    nav_open();
    // $(".modal").fadeIn();          // 모달창 서서히 보이게함
  });

  function nav_open(){

    $("#mobile_nav").bPopup({
      // follow: [false, false], //x, y
      position: [100, 75], //x, y
      speed: 500,
      transition: 'slideBack',
      transitionClose: 'slideBack'
    });
}



  // $("#headMenu").on("click", function(){
  //
  //     $("#sideBar, #sideMini").toggle();
  //
  // })

  // function myinfo(){
  //   <?php if($_SESSION['roles'] == 'admin') { ?>
  //       console.log();
  //   <?php } else { ?>
  //       location.href='<?php echo site_url(); ?>/option/user'
  //   <?php } ?>
  // }


  $("#headLogo").on("click", function(){
<?php if($_SESSION['roles'] == 'admin') { ?>
      location.href='<?php echo site_url() ?>/admin/main';
<?php } else { ?>
      location.href='<?php echo site_url() ?>/mailbox/mail_list';
<?php } ?>
  })

  $("#logoutBtn").on("click", function(){

      location.href='<?php echo site_url() ?>/account/logout';

  })

</script>