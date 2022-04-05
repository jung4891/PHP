<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $this->config->item('site_title');?></title>
    <link href="/misc/css/mobile/main_mobile.css" type="text/css" rel="stylesheet">
    <link href="/misc/css/jquery-ui.css" type="text/css" rel="stylesheet">
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
  ?>

  <body>
      <div id="header" style="border-bottom: none">
          <!-- <div id="headMenu" style="width:75px;height:75px;text-align:center;cursor:pointer;">
            <span><img src="/misc/img/icon/list.svg" style="width:38px;height:38px;margin-top:18px;"></span>
          </div> -->
          <div id="headLogo" style="cursor:pointer;">
              <span id="mailLogo" style="font-size: 20px; color: black">
                <?php
                  // 메일함명 상단출력
                  $mbox_decoded = mb_convert_encoding($mbox, 'UTF-8', 'UTF7-IMAP');
                  $mbox_decoded = str_replace('INBOX', '받은 편지함', $mbox_decoded);
                  if(strpos($mbox_decoded, '.')) {
                    $exp_folder = explode(".", $mbox_decoded);
                    $parent =  $exp_folder[0];
                    $last_child = $exp_folder[count($exp_folder)-1];
                    echo "{$last_child} ({$parent})";
                  }else {
                    echo $mbox_decoded;
                  }
                ?>
              </span>

              <!-- 읽지 않은 메일수 옆에 출력 -->
              <span style="font-size: 20px; color: red">
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

          <?php if(isset($_SESSION['roles']) && $_SESSION['roles'] == 'admin') { ?>
              <span style="font-size:24px;font-weight: bolder;color:#0575E6;">
                  관리자
              </span>
          <?php } ?>
          </div>
          <div id="headBtn">
                <!-- <span onclick="myinfo();" style="margin-right:30px;font-weight:bold;cursor:pointer;">
                  <?php if($_SESSION['roles'] == 'admin') { ?>
                        <?php echo $_SESSION['userid']; ?>
                  <?php } else { ?>
                      <?php echo $_SESSION['name']; ?>님 안녕하세요.
                  <?php } ?>
                </span> -->
            <!-- <button type="button" class="btn_basic btn_gray" id="logoutBtn" name="button">로그아웃</button> -->
            <input type="button" class="btn_basic btn_gray" id="logoutBtn" name="button" style="margin-right:30px;width:90px;height:35px;" value="로그아웃">
          </div>
      </div>


<script type="text/javascript">
  // $("#headMenu").on("click", function(){
  //
  //     $("#sideBar, #sideMini").toggle();
  //
  // })
  function myinfo(){
    <?php if($_SESSION['roles'] == 'admin') { ?>
        console.log();
    <?php } else { ?>
        location.href='<?php echo site_url(); ?>/option/user'
    <?php } ?>
  }


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
