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
  // $mailserver = "192.168.0.100";
  $mailserver = "mail.durianit.co.kr";
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
      $head_title = "{$last_child} ({$parent})";
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
    grid-template-columns: 5px 50px auto 50px 50px 5px;
    align-items: center;
    column-gap: 5px;
    font-family:"Noto Sans KR", sans-serif !important;
  }

  .img_div img{
    display: block;
    margin-left: auto;
    margin-right: auto;
}

#mobile_side{
  display: grid;
  grid-template-rows: 100px 100px auto 150px;
}
  </style>
  <body>
      <div id="m_header">
          <div>
          </div>
          <div id="historyback_div" class="img_div" onClick="javascript:history.back();">
            <img src="/misc/img/back.svg" style="width:40px;">
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

          <div id="" class="img_div">
            <img src="/misc/img/sideicon/sent.svg" style="width:40px;">
          </div>

          <div id="listBtn" class="img_div">
            <img src="/misc/img/side_list.svg" style="width:40px;">
          </div>
          <div>
          </div>

      </div>
<!-- 사이드바 -->
      <div id="mobile_nav" style="height: calc(100vh - 75px);width:calc(100vw - 100px);background-color:#ffffff; display:none; border-radius: 30px 0px 0px 0px;">
        <div id="mobile_side" class="" style="width:100%;height:100%;padding:20px;">
          <div class="" style="margin-top:10px; ">
            <span onclick="myinfo();" style="font-weight:bold;font-size:18px;">
              <?php if($_SESSION['roles'] == 'admin') { ?>
                    <?php echo $_SESSION['userid']; ?>
              <?php } else { ?>
                  <?php echo $_SESSION['name'].'님'; ?>
              <?php } ?>
            </span>
          </div>

          <div class="" style="display:flex;justify-content: center;">
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
                $font_style = "font-weight: bold; color: #0575E6;";
              }else {
                $url_route = $mbox_urlencode.'&type=unseen';
                $font_style = "";
              }
             ?>
            <div class="side_top2" align="center" onclick="location.href='<?php echo site_url(); ?>/mailbox/mail_list?boxname=<?php echo $url_route; ?>'">
              <!-- <img src="<?php echo $misc;?>img/icon/schedule.svg" width="25"><br> -->
             <div class="" style="padding-bottom: 3px; font-size: 18px; <?php echo $font_style?>">
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
              <span style="<?php if(isset($type) && $type == 'unseen') echo 'font-weight: bold;'?>">안읽음</span>
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
              <span style="<?php if(isset($type) && $type == 'important') echo 'font-weight: bold;'?>">중&nbsp;요</span>
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
              <span style="<?php if(isset($type) && $type == 'attachments') echo 'font-weight: bold;'?>">첨&nbsp;부</span>
            </div>
          </div>

          <!-- <div class="">
            안읽음중요메일쓰기
          </div> -->

          <div class="">
            메일함
          </div>
          <div class="">
            설정로그아웃
          </div>
          <div class="">
            설정로그아웃2
          </div>
          <div class="">
            설정로그아웃3
          </div>
        </div>
      </div>


<script type="text/javascript">

  $(function(){


  });


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
