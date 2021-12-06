<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $this->config->item('site_title');?></title>
    <link href="/misc/css/main.css" type="text/css" rel="stylesheet">
    <link href="/misc/css/jquery-ui.css" type="text/css" rel="stylesheet">
    <link href="/misc/css/style.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
    <script src="/misc/js/jquery-ui.min.js"></script>
    <script src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>

  </head>
  <body>
      <div id="header">
          <div id="headMenu">
            <img src="/misc/img/icon/menu_icon.png" style="width:75px;height:75px;cursor:pointer;">
          </div>
          <div id="headLogo">
              <span id="mailLogo">
                D-mail
              </span>
          </div>
          <div id="headBtn">
            <?php echo $_SESSION["userid"]; ?>
            <button type="button" class="btn_basic btn_gray" id="logoutBtn" name="button">로그아웃</button>
          </div>
      </div>


<script type="text/javascript">
  // $("#headMenu").on("click", function(){
  //
  //     $("#sideBar, #sideMini").toggle();
  //
  // })


  $("#mailLogo").on("click", function(){
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
