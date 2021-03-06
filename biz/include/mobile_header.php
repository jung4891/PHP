<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
<style media="screen">
html, body {
  max-width: 100%;
  height: 100%;
  min-width: 100%;
}
input:not([type='checkbox']):not([type='radio']), textarea, button {
  appearance: none; -moz-appearance: none; -webkit-appearance: none; border-radius: 0; -webkit-border-radius: 0; -moz-border-radius: 0;font-size:16px;
}
select {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  background:url(<?php echo $misc; ?>img/mobile/select_icon.svg) no-repeat 98% 50% #fff;
  font-size: 16px;
  height:20px;
  width:100%;
}
.mobile_header{
  height:auto;
  width:100vw;
  padding-bottom: 10px;
}
.top_containter {
  margin-left: 10px;
  margin-right: 10px;
  display:flex;
}
.top_containter > .left {
  margin-top:15px;
  flex:1;
}
.top_containter > .center {
  margin-top:15px;
  flex:3;
  text-align: center;
  color:#1C1C1C;
  font-size: 25px;
  font-weight: bold;
}
.top_containter > .right {
  margin-top:15px;
  flex:1;
  text-align: right;
}
</style>

<div class="mobile_header">
  <div class="top_containter">
    <div class="left">
      <img src="<?php echo $misc;?>img/mobile/back.svg" height="25" onclick="history.back();">
    </div>
    <div class="center" id="header_title">
      <?php if(isset($title)){echo $title;} ?>
    </div>
    <div class="right">
      <!-- <img src="<?php echo $misc;?>img/mobile/alarm.png" height="25"> -->
      <img src="<?php echo $misc;?>img/mobile/logout.svg" height="25" onclick="logoutopen();" style="float:left">
      <img src="<?php echo $misc;?>img/mobile/list.svg" height="25" onclick="nav_open();" style="float:right">
    </div>
  </div>
</div>
