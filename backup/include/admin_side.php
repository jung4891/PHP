<link href="/misc/css/sidebar.css" type="text/css" rel="stylesheet">
<style media="screen">
  #adminside{
    width: 100%;
    margin: 20px 0px 0px 20px;
  }

  #adminside tr{
    cursor: pointer;
  }

  #adminside td{
    font-size: 18px;
  }

  #adminside td img{
    display: block;
    margin-left: auto;
    margin-right: auto;

}

  .select_side{
    color:#0575E6;
  }

  #sideBar{
    width:250px;
    border-right: 3px solid #dedede;
  }
</style>
<div id="main">
    <div id="sideBar">

      <table id="adminside" border="0" cellspacing="0" cellpadding="0">
        <colgroup>
          <col width="20%">
          <col width="80%">
        </colgroup>
        <tr onclick="location.href='<?php echo site_url(); ?>/admin/manager/adminlist'">
          <td height="40"><img src="<?php echo $misc;?>img/icon/send1.svg" width="25"></td>
          <td id="td_adminlist">관리자</td>
        </tr>
        <tr onclick="location.href='<?php echo site_url(); ?>/admin/mailbox/mail_list'">
          <td height="40" align="right"><img src="<?php echo $misc;?>img/icon/mail1.svg" width="25"></td>
          <td id="td_mail_list">메일박스</td>
        </tr>
        <tr onclick="location.href='<?php echo site_url(); ?>/admin/alias/alias_list'">
          <td height="40" align="right"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="25"></td>
          <td id="td_alias_list">그룹메일</td>
        </tr>
        <tr onclick="location.href='<?php echo site_url(); ?>/admin/main/viewlog'">
          <td height="40" align="right"><img src="<?php echo $misc;?>img/icon/list.svg" width="25"></td>
          <td id="td_viewlog">로그</td>
        </tr>
      </table>

    </div>
    <div id="sideMini">
      <table id="adminside" border="0" cellspacing="0" cellpadding="0">

        <tr onclick="location.href='<?php echo site_url(); ?>/admin/manager/adminlist'">
          <td height="40" align="center"><img src="<?php echo $misc;?>img/icon/send1.svg" width="25"></td>
        </tr>
        <tr onclick="location.href='<?php echo site_url(); ?>/admin/mailbox/mail_list'">
          <td height="40" align="center"><img src="<?php echo $misc;?>img/icon/mail1.svg" width="25"></td>

        </tr>
        <tr onclick="location.href='<?php echo site_url(); ?>/admin/alias/alias_list'">
          <td height="40" align="center"><img src="<?php echo $misc;?>img/icon/schedule.svg" width="25"></td>

        </tr>
        <tr onclick="location.href='<?php echo site_url(); ?>/admin/main/viewlog'">
          <td height="40" align="center"><img src="<?php echo $misc;?>img/icon/list.svg" width="25"></td>
        </tr>
      </table>
    </div>

<script type="text/javascript">
$(function (){
  <?php
  if(strpos($_SERVER['REQUEST_URI'],'admin/manager/') !== false){
    ?>
    $("#td_adminlist").addClass("select_side");
    <?php
  }
  ?>

  <?php
  if(strpos($_SERVER['REQUEST_URI'],'admin/mailbox/') !== false){
    ?>
    $("#td_mail_list").addClass("select_side");
    <?php
  }
  ?>

  <?php
  if(strpos($_SERVER['REQUEST_URI'],'admin/alias/') !== false){
    ?>
    $("#td_alias_list").addClass("select_side");
    <?php
  }
  ?>

  <?php
  if(strpos($_SERVER['REQUEST_URI'],'admin/main/viewlog') !== false){
    ?>
    $("#td_viewlog").addClass("select_side");
    <?php
  }
  ?>

})
</script>
