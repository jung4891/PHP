<link href="/misc/css/sidebar.css" type="text/css" rel="stylesheet">
<style media="screen">
  #adminside{
    width: 100%;
    margin: 20px 0px 0px 20px;
  }

  #adminside tr{
    cursor: pointer;
  }

  #adminside tr:hover{
    /* background-color: #e7f3ff; */
  }

  .select_side td img{
    filter: invert(39%) sepia(74%) saturate(5687%) hue-rotate(197deg) brightness(98%) contrast(96%);
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

  /* .select_side td img{
    filter: invert(39%) sepia(74%) saturate(5687%) hue-rotate(197deg) brightness(98%) contrast(96%);
  } */

  #sideBar{
    width:250px;
    border-right: 3px solid #dedede;
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

#adminminitbl {
    width: 100%;
    font-size: 12px;
    font-weight: bold;
    border-collapse: separate;
    border-spacing: 0 10px;
}

</style>
<?php
if(strpos($_SERVER['REQUEST_URI'],'admin/manager') !== false){
  $manager_img = "manager2.svg";
} else {
  $manager_img = "manager.svg";
}

if(strpos($_SERVER['REQUEST_URI'],'admin/domain') !== false){
  $domain_img = "domain2.svg";
} else {
  $domain_img = "domain.svg";
}

if(strpos($_SERVER['REQUEST_URI'],'admin/mailbox') !== false){
  $mailbox_img = "mailbox2.svg";
} else {
  $mailbox_img = "mailbox.svg";
}

if(strpos($_SERVER['REQUEST_URI'],'admin/alias') !== false){
  $alias_img = "alias2.svg";
} else {
  $alias_img = "alias.svg";
}

if(strpos($_SERVER['REQUEST_URI'],'admin/main/viewlog') !== false){
  $log_img = "log2.svg";
} else {
  $log_img = "log.svg";
}
?>
<div id="main">
    <div id="sideBar">

      <table id="adminside" border="0" cellspacing="0" cellpadding="0">
        <colgroup>
          <col width="20%">
          <col width="80%">
        </colgroup>
        <tr onclick="location.href='<?php echo site_url(); ?>/admin/manager/adminlist'">
          <td height="40"><img src="<?php echo $misc;?>img/adminicon/<?php echo $manager_img; ?>" width="25"></td>
          <td id="td_adminlist">관리자</td>
        </tr>
        <tr onclick="location.href='<?php echo site_url(); ?>/admin/domain/domain_list'">
          <td height="40" align="right"><img src="<?php echo $misc;?>img/adminicon/<?php echo $domain_img; ?>" width="25"></td>
          <td id="td_domain_list">도메인</td>
        </tr>
        <tr onclick="location.href='<?php echo site_url(); ?>/admin/mailbox/mail_list'">
          <td height="40" align="right"><img src="<?php echo $misc;?>img/adminicon/<?php echo $mailbox_img; ?>" width="25"></td>
          <td id="td_mail_list">메일박스</td>
        </tr>
        <tr onclick="location.href='<?php echo site_url(); ?>/admin/alias/alias_list'">
          <td height="40" align="right"><img src="<?php echo $misc;?>img/adminicon/<?php echo $alias_img; ?>" width="25"></td>
          <td id="td_alias_list">그룹메일</td>
        </tr>
        <tr onclick="location.href='<?php echo site_url(); ?>/admin/main/viewlog'">
          <td height="40" align="right"><img src="<?php echo $misc;?>img/adminicon/<?php echo $log_img; ?>" width="25"></td>
          <td id="td_viewlog">로그</td>
        </tr>
      </table>

    </div>
    <div id="sideMini" align="center">
      <table id="adminminitbl" align="center">

        <tr class="box_tr" onclick="location.href='<?php echo site_url(); ?>/admin/manager/adminlist'">
          <td height="40" align="center"><img src="<?php echo $misc;?>img/adminicon/<?php echo $manager_img; ?>" style="height:35px;"><span id="mini_adminlist">관리자</span></td>
        </tr>

        <tr class="box_tr" onclick="location.href='<?php echo site_url(); ?>/admin/domain/domain_list'">
          <td height="40" align="center"><img src="<?php echo $misc;?>img/adminicon/<?php echo $domain_img; ?>" style="height:35px;"><span id="mini_domain_list">도메인</span></td>

        </tr>
        <tr class="box_tr" onclick="location.href='<?php echo site_url(); ?>/admin/mailbox/mail_list'">
          <td height="40" align="center"><img src="<?php echo $misc;?>img/adminicon/<?php echo $mailbox_img; ?>" style="height:35px;"><span id="mini_mail_list">메일박스</span></td>

        </tr>
        <tr class="box_tr" onclick="location.href='<?php echo site_url(); ?>/admin/alias/alias_list'">
          <td height="40" align="center"><img src="<?php echo $misc;?>img/adminicon/<?php echo $alias_img; ?>" style="height:35px;"><span id="mini_alias_list">그룹메일</span></td>

        </tr>
        <tr class="box_tr" onclick="location.href='<?php echo site_url(); ?>/admin/main/viewlog'">
          <td height="40" align="center"><img src="<?php echo $misc;?>img/adminicon/<?php echo $log_img; ?>" style="height:35px;"> <span id="mini_viewlog">로 그</span>
          </td>
        </tr>
      </table>
    </div>

<script type="text/javascript">

var sidetype = sessionStorage.getItem("adminsidemode");
if(sidetype == "mini"){
  $("#sideBar, #sideMini").toggle();
}

$("#headMenu").on("click", function(){
  $("#sideBar, #sideMini").toggle();
  var mode = sessionStorage.getItem("adminsidemode");
  if(mode == null){
    sessionStorage.setItem("adminsidemode", "mini");
  }else if(mode == "mini"){
    sessionStorage.setItem("adminsidemode", "general");
  }else{
    sessionStorage.setItem("adminsidemode", "mini");
  }
})

// $("#headMenu").on("click", function(){
//
//   $("#sideBar, #sideMini").toggle();
//
// })

$(function (){
  <?php
  if(strpos($_SERVER['REQUEST_URI'],'admin/manager/') !== false){
    ?>
    $("#td_adminlist, #mini_adminlist").addClass("select_side");
    <?php
  }
  ?>

  <?php
  if(strpos($_SERVER['REQUEST_URI'],'admin/domain/') !== false){
    ?>
    $("#td_domain_list, #mini_domain_list").addClass("select_side");
    <?php
  }
  ?>

  <?php
  if(strpos($_SERVER['REQUEST_URI'],'admin/mailbox/') !== false){
    ?>
    $("#td_mail_list, #mini_mail_list").addClass("select_side");
    <?php
  }
  ?>

  <?php
  if(strpos($_SERVER['REQUEST_URI'],'admin/alias/') !== false){
    ?>
    $("#td_alias_list, #mini_alias_list").addClass("select_side");
    <?php
  }
  ?>

  <?php
  if(strpos($_SERVER['REQUEST_URI'],'admin/main/viewlog') !== false){
    ?>
    $("#td_viewlog, #mini_viewlog").addClass("select_side");
    <?php
  }
  ?>

})
</script>
