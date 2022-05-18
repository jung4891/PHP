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
    <!-- <script src="/misc/js/jquery-ui.min.js"></script> -->
    <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
    <script src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.9.2/jquery.contextMenu.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.9.2/jquery.contextMenu.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.9.2/jquery.ui.position.js"></script>

  </head>

  <body>
      <div id="header">
          <div id="headMenu" style="width:75px;height:75px;text-align:center;cursor:pointer;">
            <span><img src="/misc/img/icon/list.svg" style="width:38px;height:38px;margin-top:18px;"></span>
          </div>
          <div id="headLogo" style="cursor:pointer;">
              <span id="mailLogo">
                D-mail
              </span>
          <?php if(isset($_SESSION['roles']) && $_SESSION['roles'] == 'admin') { ?>
              <span style="font-size:24px;font-weight: bolder;color:#0575E6;">
                  관리자
              </span>
          <?php } ?>
          </div>
          <div id="headBtn">
                <span onclick="myinfo();" style="margin-right:30px;font-weight:bold;cursor:pointer;">

                  <?php if($_SESSION['roles'] == 'admin') { ?>
                        <?php echo $_SESSION['userid']; ?>
                  <?php } else { ?>
                      <?php echo $_SESSION['name']; ?>님 안녕하세요.
                  <?php } ?>



                </span>
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