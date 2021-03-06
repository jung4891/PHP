<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/dashboard.css">
<link rel="stylesheet" href="/misc/css/simple-calendar.css">
<link rel="stylesheet" href="/misc/css/nice-select.css">
<script type="text/javascript" src="/misc/js/jquery.simple-calendar.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="/misc/js/jquery.nice-select.min.js"></script>
<style>
body {
  background-color: #EBF0F3;
  -ms-overflow-style: none; /* IE and Edge */
  scrollbar-width: none; /* Firefox */
}
body::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera*/
}
  .rez_btn {
    border: 2px solid black;
    background-color: white;
    width:80px;
    border-radius:12px;
    background:white;
    border-color:#6e6f6c;
    color:rgb(110, 111, 108);
  }
  .rez_btn:hover {
    background-color: #6e6f6c;
    color:white;
  }

  #mail_tbl tr:hover{
    background-color:#FAFAFA;
    cursor: pointer;
  }

  @keyframes spinner {
    from {transform: rotate(0deg); }
    to {transform: rotate(360deg);}
  }

  .img_spin{
     animation: spinner .8s ease infinite;
  }

  .seen0 td{
    color:#0575E6;
  }

  .mail_select{
    /* height: 30px; */
    border: none;
    outline: none;
    border-radius: 3px;
    color: black;
    vertical-align: middle;
    font-family: "Noto Sans KR", sans-serif !important;
    font-size: 20px;
    font-weight: 600;
  }

  .mail_select option {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    font-size: 14px;
}

.nice-select {
  height:unset;
  line-height: unset;
  padding-left: unset;
}

.nice-select.open .list{
  max-height: 400px;
  overflow-y: scroll;
}

.nice-select .list{
  font-size: 14px;
}

.read_n td {
  font-weight:bold;
}
</style>
<script type="text/javascript">


function getToday(){
  var date = new Date();
  var year = date.getFullYear();
  var month = ("0" + (1 + date.getMonth())).slice(-2);
  var day = ("0" + date.getDate()).slice(-2);

  return year + '-' + month + '-' + day;
}
var day = getToday();
google.charts.load('current', {'packages':['timeline']});

google.charts.setOnLoadCallback(room_drawChart);
google.charts.setOnLoadCallback(car_drawChart);

$(window).resize(function(){
  google.charts.load('current', {'packages':['timeline']});

  google.charts.setOnLoadCallback(room_drawChart);
  google.charts.setOnLoadCallback(car_drawChart);
});


function room_drawChart() {
  var container = document.getElementById('room_timeline');
  var chart = new google.visualization.Timeline(container);
  var dataTable = new google.visualization.DataTable();

  dataTable.addColumn({ type: 'string', id: 'President' });
  dataTable.addColumn({type: 'string', id: 'BarLabel'});
  dataTable.addColumn({ type: 'date', id: 'Start' });
  dataTable.addColumn({ type: 'date', id: 'End' });

  $.ajax({
    type:"POST",
    async: false,
    url:"/index.php/home/reservartion_room",
    dataType:"json",
    data:{
      day:day
    },
    success: function(data) {
      rez_room = data;
    }
  })

  for(var i=0; i<rez_room.length; i++){
    if (rez_room[i].seq!=null){
      var st = rez_room[i].start_time;
      st = st.split(":");
      var sh = st[0];
      var sm = st[1];
      var et = rez_room[i].end_time;
      et = et.split(":");
      var eh = et[0];
      var em = et[1];
      dataTable.addRows([[rez_room[i].room, rez_room[i].title+" [?????????:"+rez_room[i].user_name+"]", new Date(0,0,0,sh,em),new Date(0,0,0,eh,em)]]);
    } else {
      dataTable.addRows([[rez_room[i].room, null, new Date(0,0,0,8,0), new Date(0,0,0,8,0)]]);
    }
  }

  dataTable.insertColumn(2, {type: 'string', role: 'tooltip', p: {html: true}});

  var dateFormat = new google.visualization.DateFormat({
      pattern: 'h:mm a'
    });

  for (var i = 0; i < dataTable.getNumberOfRows(); i++) {
    var tooltip = '<div class="ggl-tooltip"><span>' + dataTable.getValue(i, 1) + '</span></div><div class="ggl-tooltip"><span>' + dataTable.getValue(i, 0) + '</span>: ' + dateFormat.formatValue(dataTable.getValue(i, 3)) + ' - ' + dateFormat.formatValue(dataTable.getValue(i, 4)) + '</div>';

    dataTable.setValue(i, 2, tooltip);
  }

  var options = {
    timeline: {
      singleColor: 'red',
      showBarLabels: false
    },
    hAxis: {
      minValue: new Date(0, 0, 0, 8, 0),
      maxValue: new Date(0, 0, 0, 22, 0),
      format: 'HH'
    },
    height: 173
  };

  chart.draw(dataTable, options);
  (function(){
    var el=container.getElementsByTagName("rect");
    var width=5;
    var elToRem=[];
    for(var i=0;i<el.length;i++){
      var cwidth=parseInt(el[i].getAttribute("width"));
      if(cwidth<width){
        elToRem=[el[i]];
        width=cwidth;
      } else if(cwidth==width){
        elToRem.push(el[i]);
      }
    }
    for(var i=0;i<elToRem.length;i++) {
      elToRem[i].setAttribute("fill","none");
    }
  })();
}

function car_drawChart() {
  var container = document.getElementById('car_timeline');
  var chart = new google.visualization.Timeline(container);
  var dataTable = new google.visualization.DataTable();

  dataTable.addColumn({ type: 'string', id: 'Position' });
  dataTable.addColumn({type: 'string', id: 'BarLabel'});
  dataTable.addColumn({ type: 'date', id: 'Start' });
  dataTable.addColumn({ type: 'date', id: 'End' });

  $.ajax({
    type:"POST",
    async: false,
    url:"/index.php/home/reservartion_car",
    dataType:"json",
    data:{
      day:day
    },
    success: function(data) {
      // console.log(data);
      rez_car = data;
    }
  })

  for(var i=0; i<rez_car.length; i++){
    if (rez_car[i].seq!=null){
      var st = rez_car[i].start_time;
      st = st.split(":");
      var sh = st[0];
      var sm = st[1];
      var et = rez_car[i].end_time;
      et = et.split(":");
      var eh = et[0];
      var em = et[1];
      if (sh < 09){
        sh = 09;
        sm = 00;
      }
      if (eh < 09){
        eh = 09;
        em = 09;
      }
      if (sh >= 22){
        sh = 22;
        sm = 00;
      }
      if (eh >= 22){
        eh = 22;
        em = 00;
      }
      if (rez_car[i].start_day<day){
        sh = 09;
        sm = 00;
      }
      if (rez_car[i].end_day>day){
        eh = 22;
        em = 00;
      }
      dataTable.addRows([[rez_car[i].type, rez_car[i].title+" [?????????:"+rez_car[i].user_name+"]", new Date(0,0,0,sh,em),new Date(0,0,0,eh,em)]]);
    } else {
      dataTable.addRows([[rez_car[i].type, null, new Date(0,0,0,8,0), new Date(0,0,0,8,0)]]);
    }
  }

  dataTable.insertColumn(2, {type: 'string', role: 'tooltip', p: {html: true}});

  var dateFormat = new google.visualization.DateFormat({
      pattern: 'h:mm a'
    });

  for (var i = 0; i < dataTable.getNumberOfRows(); i++) {
    var tooltip = '<div class="ggl-tooltip"><span>' + dataTable.getValue(i, 1) + '</span></div><div class="ggl-tooltip"><span>' + dataTable.getValue(i, 0) + '</span>: ' + dateFormat.formatValue(dataTable.getValue(i, 3)) + ' - ' + dateFormat.formatValue(dataTable.getValue(i, 4)) + '</div>';

    dataTable.setValue(i, 2, tooltip);
  }

  var options = {
    timeline: {
      singleColor: 'blue',
      showBarLabels: false
    },
    hAxis: {
      minValue: new Date(0, 0, 0, 8, 0),
      maxValue: new Date(0, 0, 0, 22, 0),
      format: 'HH'
    },
    height: 173
  };

  chart.draw(dataTable, options);

  (function(){
    var el=container.getElementsByTagName("rect");
    var width=5;
    var elToRem=[];
    for(var i=0;i<el.length;i++){
      var cwidth=parseInt(el[i].getAttribute("width"));
      if(cwidth<width){
        elToRem=[el[i]];
        width=cwidth;
      } else if(cwidth==width){
        elToRem.push(el[i]);
      }
    }
    for(var i=0;i<elToRem.length;i++) {
      elToRem[i].setAttribute("fill","none");
    }
  })();
}
</script>
<body>
  <?php
    include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
  ?>
  <?php

  if ($holiday_count > 0){
    $holiday_count = 0;
    foreach($holiday_list as $value) {
      $locdate = $value['locdate'];
      $target = strtotime($locdate);
      if(date("N",$target) <= 5){
        $holiday_count++;
      }
    }
  }

    $now_year = date("Y");
    $now_month = date("m");
    $last_day = date("t", mktime(0, 0, 1, $now_month, 1, $now_year));

    $from = date("Y-m-01");
    $to = date("Y-m-");
    $to = $to.$last_day;

  function number_of_working_days($from, $to) {
    $target = strtotime($from);
    $days = 0;
    while ($target <= strtotime(date("Y-m-d",strtotime($to)))) {
      // echo date("Y-m-d",$target)."---".$to."<br>";
        if(date("N",$target) <= 5) $days++;
        $target += (60*60*24);
      }
      return $days;
  }
  $work_day = number_of_working_days($from,$to) - $holiday_count;

  function get_client_ip() {
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
          $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
      else
          $ipaddress = 'UNKNOWN';
      return $ipaddress;
  }

  // ????????????
  // echo $mail_count."<br>".$header."<br>".$body;
  // echo imap_utf8($header[1]['subject']);
  // print_r($subject);
  //
  // for ($i=1;$i<count($subject)+1;$i++){
  //   echo imap_utf8($subject[$i])."<br>";
  // }
  // var_dump($subject);
  // echo $connection;
   ?>
<!-- ????????? -->
  <div align="center" class="main_dash_div"><?php // echo phpinfo(); ?>
    <div class="main_dash1">
      <div style="height:370px">
        <table id="maintain" class="main_dash_tbl main_dash_tbl_1" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="dash_title_td"><div class="dash_title">?????????</div></td>
            <!-- <td align="right" style="padding-right:10px;"><img src="<?php echo $misc;?>img/dashboard/dash_detail.svg" width="25" onclick="go_detail(this)" style="cursor:pointer;"/></td> -->
          </tr>
          <tr>
            <td height="16"></td>
          </tr>
          <tr>
            <td colspan="2" height="10" style="border-top: 1px solid rgba(0, 0, 0, 0.19);"></td>
          </tr>
          <tr>
            <td height="10"></td>
          </tr>
          <tr>
            <td colspan="2" valign="top">
              <table class="content_dash" align="center" width="100%" border="0" cellpadding="0">
                <tr>
                  <td align="center"><img src="<?php echo $misc;?>img/dashboard/user.svg" width="60"/></td>
                </tr>
                <tr>
                  <td height="10"></td>
                </tr>
                <tr>
                  <td align="center" style="font-size:20px; font-weight:bold; color:#1C1C1C;"><span style="color:#0575E6;"><?php echo $user_name; ?></span>??? ???????????????.</td>
                </tr>
                <tr>
                  <td align="center" height="30" style="font-size:15px;color:#626262;"><?php echo $user_group; ?></td>
                </tr>
                <tr>
                  <td height="5"></td>
                </tr>
                <tr>
                  <td align="center" style="color:#1C1C1C;">???????????? : <?php echo $login_time; ?></td>
                </tr>
                <tr>
                  <td align="center" valign="middle" style="color:#B0B0B0;">
                    <img src="<?php echo $misc;?>img/dashboard/IP.svg" width="32" style="vertical-align:bottom"/>
                    <span><?php echo get_client_ip(); ?></span>
                  </td>
                </tr>
                <tr>
                  <td align="center" height="30">
                    <div class="myinfo_btn_div">
                      <div class="myinfo_btn1 myinfo_btn_l no_pointer" style="margin-top:20px;" onclick="go_detail('mail');">
                        <span class="span_left">??????</span>
                        <span class="span_right" id="all_mailcnt">--</span>
                      </div>
                      <div class="myinfo_btn1 myinfo_btn_r" style="margin-top:20px;" onclick="location.href='<?php echo site_url(); ?>/biz/approval/electronic_approval_list?type=standby'">
                        <span class="span_left">??????</span>
                        <span class="span_right"><?php echo $approval_count; ?></span>
                      </div>
                    </div>
                  </td>
                  <!-- <td align="center" height="30">
                  </td> -->
                </tr>
                <tr>
                  <td align="center" height="30">
                    <div class="myinfo_btn_div">
                      <div class="myinfo_btn1 myinfo_btn_l" onclick="location.href='<?php echo site_url(); ?>/biz/schedule/tech_schedule'">
                        <span class="span_left">??????</span>
                        <span class="span_right"><?php echo $schedule_count; ?></span>
                      </div>
                      <div class="myinfo_btn1 myinfo_btn_r no_pointer">
                        <span class="span_left">??????</span>
                        <span class="span_right">--</span>
                      </div>
                    </div>
                  </td>
                  <!-- <td align="center" height="30">
                  </td> -->
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
<!-- ???????????? -->
<?php
$week = array("???", "???", "???", "???", "???", "???", "???");
if (!isset($day)){
  $day = date("Y-m-d");
}
$s = $week[date("w",strtotime($day))];
 ?>
      <div style="height:542px;">
        <table id="attendance" class="main_dash_tbl main_dash_tbl_1" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="dash_title_td"><div class="dash_title">????????????</div></td>
            <td align="right" style="padding-right:10px;vertical-align:middle;">
              <div style="padding-top:15px;"><img src="<?php echo $misc;?>img/dashboard/dash_plus.svg" width="25" onclick="go_detail(this)" style="cursor:pointer;"/></div>
            </td>
          </tr>
          <tr>
            <td height="16"></td>
          </tr>
          <tr>
            <td colspan="2" height="10" style="border-top: 1px solid rgba(0, 0, 0, 0.19);"></td>
          </tr>
          <tr>
            <td height="10"></td>
          </tr>
          <tr>
            <td colspan="2" valign="top">
              <table class="content_dash attendance_tbl" align="center" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2" align="center" style="font-size:14px;color:#0575E6;"><?php echo date("Y - n - j($s)",strtotime($day)); ?></td>
                </tr>
                <tr>
                  <td colspan="2" height="40" align="center" style="font-size:30px;font-weight:bold;color:#1C1C1C;">
                    <div id="clock"><?php echo date("H:i:s"); ?></div>
                  </td>
                </tr>
                <tr>
                  <td height="10"></td>
                </tr>
                <tr>
                  <td height="25" align="left" style="padding-left:2px;">????????????</td>
                  <td align="right" id="work_on_time" style="padding-right:2px;"><?php
                    if (isset($attendance_today['ws_time'])&&$attendance_today['ws_time']!=""){
                      $date = new DateTime($attendance_today['ws_time']);
                      $ws_time = $date->format('H:i:s');
                      $designated_ws = $attendance_info['designate_ws'];
                      if(strtotime($ws_time)>strtotime($designated_ws)){
                        echo $ws_time." (??????)";
                      } else {
                        echo $ws_time;
                      }
                    } else {
                      echo "?????????";
                    }
                    ?></td>
                </tr>
                <tr>
                  <td height="25" align="left" style="padding-left:2px;">????????????</td>
                  <td align="right" id="work_off_time" style="padding-right:2px;"><?php
                      if (isset($attendance_today['wc_time'])&&$attendance_today['wc_time']!=""){
                        $date = new DateTime($attendance_today['wc_time']);
                        echo $date->format('H:i:s');
                      } else {
                        echo "?????????";
                      }
                    ?>
                  </td>
                </tr>
                <tr>
                  <td height="25" align="left" style="padding-left:2px;">?????? ????????????</td>
                  <td align="right" id="total_work_time_text" style="padding-right:2px;"><?php
                    if (isset($attendance_today['ws_time'])&&$attendance_today['ws_time']!=""){
                      if ($attendance_today['wc_time']=="") {
                        $on_time = date($attendance_today['ws_time']);
                        $now = date('Y-m-d H:i:s');
                        $time_diff = strtotime($now) - strtotime($on_time);
                        $days = floor($time_diff/86400);
                        $time = $time_diff - ($days*86400);
                        $hours = floor($time/3600);
                        $time = $time - ($hours*3600);
                        $min = floor($time/60);
                        $sec = $time - ($min*60);
                        echo $hours."?????? ".$min."??? ".$sec."???";
                      } else if ($attendance_today['ws_time']!=""){
                        $on_time = date($attendance_today['ws_time']);
                        $now = date($attendance_today['wc_time']);
                        $time_diff = strtotime($now) - strtotime($on_time);
                        $days = floor($time_diff/86400);
                        $time = $time_diff - ($days*86400);
                        $hours = floor($time/3600);
                        $time = $time - ($hours*3600);
                        $min = floor($time/60);
                        $sec = $time - ($min*60);
                        echo $hours."?????? ".$min."??? ".$sec."???";
                      }
                    } else {
                      echo "--";
                    }
                     ?></td>
                     <input type="hidden" id="total_work_time" value="<?php if(isset($attendance_today['ws_time'])&&$attendance_today['ws_time']!=''){echo $hours.":".$min.":".$sec;} ?>">
                </tr>
                <tr>
                  <td height="10"></td>
                </tr>
              </table>
              <table class="content_dash attendance_tbl" align="center" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="5"></td>
                </tr>
                <tr>
                  <!-- <td align="left"><button class="attendance_btn" onclick="input_work('on');">????????????</button></td>
                  <td align="right"><button class="attendance_btn" onclick="input_work('off');">????????????</button></td> -->
                  <td align="left" height="30" width="50%">
                    <div style="width:100%">
                      <img id="btn_work_on" src="<?php echo $misc;?>img/dashboard/btn/btn_on_work_off.svg" onclick="input_work('on');" width='90%' style="cursor:pointer;"/>
                    </div>
                  </td>
                  <td align="right" height="30" width="50%">
                    <div style="width:100%">
                      <img id="btn_work_off" src="<?php echo $misc;?>img/dashboard/btn/btn_off_work_off.svg" onclick="input_work('off');" width='90%' style="cursor:pointer;"/>
                    </div>
                  </td>
                </tr>
                <!-- <tr>
                  <td height="5"></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><button class="attendance_btn2" disabled>??????????????????</button></td>
                </tr> -->
                <tr>
                  <td height="10"></td>
                </tr>
              </table>
              <table class="content_dash attendance_tbl" align="center" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center">
                    <div class="attendance_btn_div work_day_div">
                      <span class="attendance_span span_left">???????????????</span>
                      <span class="attendance_span span_right"><?php echo $work_day; ?></span>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td align="center">
                    <div class="attendance_btn_div real_work_div">
                      <span class="attendance_span span_left">???????????????</span>
                      <span class="attendance_span span_right"><?php echo $real_work['cnt']; ?></span>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td align="center">
                    <div class="attendance_btn_div normal_work_div">
                      <span class="attendance_span span_left">????????????</span>
                      <span class="attendance_span span_right"><?php echo $normal_work['cnt']; ?></span>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td align="center">
                    <div class="attendance_btn_div abnormal_work_div">
                      <span class="attendance_span span_left">?????????</span>
                      <span class="attendance_span span_right"><?php echo $abnormal_work['cnt']; ?></span>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td height="5"></td>
                </tr>
                <tr>
                  <td colspan="2" align="center">
                    <div align="center" onclick="location.href='<?php echo site_url();?>/biz/attendance/annual_usage_status_list'">
                      <img src="<?php echo $misc;?>img/dashboard/btn/btn_annual_status.svg" style="min-width:100%;cursor:pointer;"/>
                    </div>
                  </a>
                  </td>
                </tr>
                <tr>
                  <td height="10"></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
    </div>

<!-- ?????? -->
    <div class="main_dash2">
      <div style="height:299px;">
        <table id="mail" class="main_dash_tbl main_dash_tbl_2" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="dash_title_td" style="width:80%;">
              <div style="padding-left:20px;padding-top:10px;width:100%;" id="mlist_td">
                <span id="mail_title_span" style="font-size: 20px;font-weight:600;display:none;">??????</span>
              <!-- <select class="mail_select" name="">
                <option value="">??????</option>
              </select> -->
            </div>
          </td>
            <td align="right" style="padding-right:10px;vertical-align:middle;width:20%;">
              <div style="padding-top:15px;display:flex;flex-direction:row;align-items:center;justify-content: flex-end;width:100%;">
                <span id="minfo_td" style="font-size:14px;padding-right: 5px;"></span>
                <span>
                  <img src="<?php echo $misc;?>img/dashboard/dash_plus.svg" width="25" onclick="go_detail(this)" style="cursor:pointer;"/>

                </span>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="2" height="16"></td>
          </tr>
          <tr>
            <td colspan="2" height="10" style="border-top: 1px solid rgba(0, 0, 0, 0.19);"></td>
          </tr>

          <tr id="mbox_tr" style="display:none;">
            <td colspan="2" valign="top" style="height:1px;">
            <table class="" id="mbox_tbl" align="center" width="90%" border="0" cellspacing="0" cellpadding="0">
              <colgroup>
                <col width="35%">
                <col width="45%">
                <col width="20%">
              </colgroup>
              <tr>
                <td></td>
                <td id="f5_td"></td>
                <td>
                </td>
                <!-- <td></td> -->
              </tr>
            </table>
          </td>
          </tr>
          <!-- <tr>
            <td height="10"></td>
          </tr> -->
          <tr>
            <td colspan="2" valign="top">
              <table class="content_tbl" id="mail_tbl" align="left" width="90%" border="0" cellspacing="0" cellpadding="0" style="padding-left: 20px">
                <colgroup>
                  <col width="35%">
                  <col width="45%">
                  <col width="20%">
                </colgroup>
                <tbody>

                </tbody>
              </table>

              <table class="content_tbl" id="mailauth_tbl" align="center" width="90%" border="0" cellspacing="0" cellpadding="0" style="display:none;margin-top:20px;">
                <colgroup>
                  <col width="20%">
                  <col width="60%">
                  <col width="20%">
                </colgroup>
                <tbody>
                  <tr>
                    <td colspan="3" align="center" class="no_list">
                      ?????? ????????? ?????????????????????.
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center">
                      <input type="text" id="authMail" name="" style="width:200px;height:30px;" value="<?php echo $email; ?>" disabled>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center">
                      <input type="password" id="authMail_pass" name="" style="width:200px;height:30px;" value="" placeholder="??????????????? ???????????????" onkeyup="if(window.event.keyCode==13){ping_mail(1)}">
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center">
                      <input type="button" name="" value="??? ???" onclick="ping_mail(1)" style="-webkit-appearance: none;-moz-appearance: none;appearance: none;height: 30px;width:210px;cursor: pointer;  border:none; background-color: #E7F3FF; color: #1A8DFF;">
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td height="10"></td>
          </tr>
        </table>
      </div>
<!-- ?????? -->
      <div style="height:299px;">
        <table id="approval" class="main_dash_tbl main_dash_tbl_2" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="dash_title_td" style="padding-top:1px;">
              <div class="dash_title">
                ??????
                <span class="no_read_cnt_s">(<?php echo $no_read_cnt_s[0]['cnt']; ?>)</span>
                <span class="no_read_cnt_p" style="display:none;">(<?php echo $no_read_cnt_p[0]['cnt']; ?>)</span>
                <span class="no_read_cnt_c" style="display:none;">(<?php echo $no_read_cnt_c[0]['cnt']; ?>)</span>
                <span class="no_read_cnt_b" style="display:none;">(<?php echo $no_read_cnt_b[0]['cnt']; ?>)</span>
                <span class="no_read_cnt_w" style="display:none;">(<?php echo $no_read_cnt_w[0]['cnt']; ?>)</span>
              </div>
            </td>
            <td align="right" style="padding-right:10px;vertical-align:middle;">
              <div style="padding-top:15px;"><img src="<?php echo $misc;?>img/dashboard/dash_plus.svg" width="25" onclick="go_detail(this)" style="cursor:pointer;"/></div>
            </td>
          </tr>
          <tr>
            <td height="16"></td>
          </tr>
          <tr>
            <td colspan="2" height="10" style="border-top: 1px solid rgba(0, 0, 0, 0.19);"></td>
          </tr>
          <tr height="20" id="approval_btn">
            <td class="btn_menu_1" style="float:left" style="padding-left:10px;">
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_2-1_on.svg" id="approval_dash_2-1:on" class="approval_btn_on" onclick="change_tbl(this.id);" width="90" name="standby"/>
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_2-1_off.svg" id="approval_dash_2-1:off" class="approval_btn_off" onclick="change_tbl(this.id);" style="display:none;" width="90"/>
            </td>
            <td class="btn_menu_2" style="float:left" style="padding-left:10px;">
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_2-2_on.svg" id="approval_dash_2-2:on" class="approval_btn_on" onclick="change_tbl(this.id);" style="display:none;" width="90" name="progress"/>
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_2-2_off.svg" id="approval_dash_2-2:off" class="approval_btn_off" onclick="change_tbl(this.id);"width="90"/>
            </td>
            <td class="btn_menu_2 btn_menu_ex" style="float:left" style="padding-left:10px;">
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_2-3_on.svg" id="approval_dash_2-3:on" class="approval_btn_on" onclick="change_tbl(this.id);" style="display:none;" width="90" name="completion"/>
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_2-3_off.svg" id="approval_dash_2-3:off" class="approval_btn_off" onclick="change_tbl(this.id);" width="90"/>
            </td>
            <td class="btn_menu_2 btn_menu_ex btn_menu_ex2" style="float:left" style="padding-left:10px;">
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_2-4_on.svg" id="approval_dash_2-4:on" class="approval_btn_on" onclick="change_tbl(this.id);" style="display:none;" width="90" name="back"/>
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_2-4_off.svg" id="approval_dash_2-4:off" class="approval_btn_off" onclick="change_tbl(this.id);" width="90"/>
            </td>
            <td class="btn_menu_2 btn_menu_ex btn_menu_ex2" style="float:left" style="padding-left:10px;">
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_2-5_on.svg" id="approval_dash_2-5:on" class="approval_btn_on" onclick="change_tbl(this.id);" style="display:none;" width="90" name="wage"/>
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_2-5_off.svg" id="approval_dash_2-5:off" class="approval_btn_off" onclick="change_tbl(this.id);" width="90"/>
            </td>
          </tr>
          <tr>
            <td height="10"></td>
          </tr>

          <!-- ??????????????? -->
          <tr>
            <td colspan="2" valign="top">
              <table id="tbl_approval_dash_2-1" class="approval_dash_2" width="100%">
                <tr>
                  <td colspan="2" valign="top">
                    <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                      <colgroup>
                        <col width="63%">
                        <col width="13%">
                        <col width="24%">
                      </colgroup>
                      <?php
                      if(empty($standby) != true){
                         $idx = $standby_count-$start_row;
                         for($i = $start_row; $i<$start_row+$end_row; $i++){
                            if(!empty( $standby[$i])){
                               $doc = $standby[$i];
                               $read_yn = '';
                               $read_seq = 's_'.$this->seq;
                               if(strpos($doc['read_seq'],$read_seq)===false) {
                                 $read_yn = 'read_n';
                               } else {
                                 $read_yn = 'read_y';
                               }
                      ?>
                      <tr align='center' onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style='cursor:pointer;' onclick="eletronic_approval_view('<?php echo $doc['seq']; ?>', 'standby')" class="<?php echo $read_yn; ?>">
                       <td class="board_title" height="30" align="left" style="text-overflow:ellipsis; overflow:hidden;padding-left:18px;">
                         <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;"><?php
                         if($doc['approval_doc_hold'] == "N"){
                            echo $doc['approval_doc_name'];
                         }else{
                            echo $doc['approval_doc_name']." (??????)";
                         }
                         ?></div>
                       </td>
                       <td class="board_writer" align="right"><?php echo $doc['writer_name']?></td>
                       <td class="board_date" align="right" style="padding-right:18px;">
                         <?php
                         $tmp=explode(" ",$doc['write_date']);
                         $tmp2 = $tmp[0];
                         echo $tmp2;
                         ?></td>
                     </tr>
                         <?php
                          $idx--;
                        }
                        }
                      } else {
                    ?>
                      <tr>
                        <td width="100%" height="80" align="center" colspan="9" class="no_list">????????? ???????????? ????????????.</td>
                      </tr>
            <?php
            }
            ?>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- ??????????????? -->
          <tr>
            <td colspan="2" valign="top">
              <table id="tbl_approval_dash_2-2" class="approval_dash_2" width="100%" style="display:none;">
                <tr>
                  <td colspan="2" valign="top">
                    <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                      <colgroup>
                        <col width="63%">
                        <col width="13%">
                        <col width="24%">
                      </colgroup>
                      <?php
                      if(empty($progress) != true){
                         $idx = $progress_count-$start_row;
                         for($i = $start_row; $i<$start_row+$end_row; $i++){
                            if(!empty( $progress[$i])){
                               $doc = $progress[$i];
                               $read_yn = '';
                               $read_seq = 'p_'.$this->seq;
                               if(strpos($doc['read_seq'],$read_seq)===false) {
                                 $read_yn = 'read_n';
                               } else {
                                 $read_yn = 'read_y';
                               }
                      ?>
                      <tr align='center' onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style='cursor:pointer;' onclick="eletronic_approval_view('<?php echo $doc['seq']; ?>', 'progress')" class="<?php echo $read_yn; ?>">
                       <td class="board_title" height="30" align="left" style="text-overflow:ellipsis; overflow:hidden;padding-left:18px;">
                         <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;"><?php
                         if($doc['approval_doc_hold'] == "N"){
                            echo $doc['approval_doc_name'];
                         }else{
                            echo $doc['approval_doc_name']." (??????)";
                         }
                         ?></div>
                       </td>
                       <td class="board_writer" align="right"><?php echo $doc['writer_name'];?></td>
                       <td class="board_date" align="right" style="padding-right:18px;">
                         <?php
                         $tmp=explode(" ",$doc['write_date']);
                         $tmp2 = $tmp[0];
                         echo $tmp2;
                         ?></td>
                     </tr>
                         <?php
                          $idx--;
                        }
                        }
                      } else {
                    ?>
                      <tr>
                        <td width="100%" height="80" align="center" colspan="9" class="no_list">????????? ???????????? ????????????.</td>
                      </tr>
            <?php
            }
            ?>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>


          <!-- ??????????????? -->
          <tr>
            <td colspan="2" valign="top">
              <table id="tbl_approval_dash_2-3" class="approval_dash_2" width="100%" style="display:none;">
                <tr>
                  <td colspan="2" valign="top">
                    <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                      <colgroup>
                        <col width="63%">
                        <col width="13%">
                        <col width="24%">
                      </colgroup>
                      <?php
                      if(empty($completion) != true){
                         $idx = $completion_count-$start_row;
                         for($i = $start_row; $i<$start_row+$end_row; $i++){
                            if(!empty( $completion[$i])){
                               $doc = $completion[$i];
                               $read_yn = '';
                               $read_seq = 'c_'.$this->seq;
                               if(strpos($doc['read_seq'],$read_seq)===false) {
                                 $read_yn = 'read_n';
                               } else {
                                 $read_yn = 'read_y';
                               }
                      ?>
                      <tr align='center' onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style='cursor:pointer;' onclick="eletronic_approval_view('<?php echo $doc['seq']; ?>', 'completion')" class="<?php echo $read_yn; ?>">
                       <td class="board_title" height="30" align="left" style="text-overflow:ellipsis; overflow:hidden;padding-left:18px;">
                         <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;"><?php
                         if($doc['approval_doc_hold'] == "N"){
                            echo $doc['approval_doc_name'];
                         }else{
                            echo $doc['approval_doc_name']." (??????)";
                         }
                         ?></div>
                       </td>
                       <td class="board_writer" align="right"><?php echo $doc['writer_name']?></td>
                       <td class="board_date" align="right" style="padding-right:18px;">
                         <?php
                         $tmp=explode(" ",$doc['write_date']);
                         $tmp2 = $tmp[0];
                         echo $tmp2;
                         ?></td>
                     </tr>
                         <?php
                          $idx--;
                        }
                        }
                      } else {
                    ?>
                      <tr>
                        <td width="100%" height="80" align="center" colspan="9" class="no_list">????????? ???????????? ????????????.</td>
                      </tr>
            <?php
            }
            ?>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>


          <!-- ??????????????? -->
          <tr>
            <td colspan="2" valign="top">
              <table id="tbl_approval_dash_2-4" class="approval_dash_2" width="100%" style="display:none;">
                <tr>
                  <td colspan="2" valign="top">
                    <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                      <colgroup>
                        <col width="63%">
                        <col width="13%">
                        <col width="24%">
                      </colgroup>
                      <?php
                      if(empty($back) != true){
                         $idx = $back_count-$start_row;
                         for($i = $start_row; $i<$start_row+$end_row; $i++){
                            if(!empty( $back[$i])){
                               $doc = $back[$i];
                               $read_yn = '';
                               $read_seq = 'b_'.$this->seq;
                               if(strpos($doc['read_seq'],$read_seq)===false) {
                                 $read_yn = 'read_n';
                               } else {
                                 $read_yn = 'read_y';
                               }
                      ?>
                      <tr align='center' onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style='cursor:pointer;' onclick="eletronic_approval_view('<?php echo $doc['seq']; ?>', 'back')" class="<?php echo $read_yn; ?>">
                       <td class="board_title" height="30" align="left" style="text-overflow:ellipsis; overflow:hidden;padding-left:18px;">
                         <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;"><?php
                         if($doc['approval_doc_hold'] == "N"){
                            echo $doc['approval_doc_name'];
                         }else{
                            echo $doc['approval_doc_name']." (??????)";
                         }
                         ?></div>
                       </td>
                       <td class="board_writer" align="right"><?php echo $doc['writer_name'];?></td>
                       <td class="board_date" align="right" style="padding-right:18px;">
                         <?php
                         $tmp=explode(" ",$doc['write_date']);
                         $tmp2 = $tmp[0];
                         echo $tmp2;
                         ?></td>
                     </tr>
                         <?php
                          $idx--;
                        }
                        }
                      } else {
                    ?>
                      <tr>
                        <td width="100%" height="80" align="center" colspan="9" class="no_list">????????? ???????????? ????????????.</td>
                      </tr>
            <?php
            }
            ?>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>


          <!-- ??????????????? -->
          <tr>
            <td colspan="2" valign="top">
              <table id="tbl_approval_dash_2-5" class="approval_dash_2" width="100%" style="display:none;">
                <tr>
                  <td colspan="2" valign="top">
                    <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                      <colgroup>
                        <col width="63%">
                        <col width="13%">
                        <col width="24%">
                      </colgroup>
                      <?php
                      if(empty($wage) != true){
                         $idx = $wage_count-$start_row;
                         for($i = $start_row; $i<$start_row+$end_row; $i++){
                            if(!empty( $wage[$i])){
                               $doc = $wage[$i];
                               $read_yn = '';
                               $read_seq = 'w_'.$this->seq;
                               if(strpos($doc['read_seq'],$read_seq)===false) {
                                 $read_yn = 'read_n';
                               } else {
                                 $read_yn = 'read_y';
                               }
                      ?>
                      <tr align='center' onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style='cursor:pointer;' onclick="eletronic_approval_view('<?php echo $doc['seq']; ?>', 'wage')" class="<?php echo $read_yn; ?>">
                       <td class="board_title" height="30" align="left" style="text-overflow:ellipsis; overflow:hidden;padding-left:18px;">
                         <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;"><?php
                         if($doc['approval_doc_hold'] == "N"){
                            echo $doc['approval_doc_name'];
                         }else{
                            echo $doc['approval_doc_name']." (??????)";
                         }
                         ?></div>
                       </td>
                       <td class="board_writer" align="right"><?php echo $doc['writer_name'];?></td>
                       <td class="board_date" align="right" style="padding-right:18px;">
                         <?php
                         $tmp=explode(" ",$doc['write_date']);
                         $tmp2 = $tmp[0];
                         echo $tmp2;
                         ?></td>
                     </tr>
                         <?php
                          $idx--;
                        }
                        }
                      } else {
                    ?>
                      <tr>
                        <td width="100%" height="80" align="center" colspan="9" class="no_list">????????? ???????????? ????????????.</td>
                      </tr>
            <?php
            }
            ?>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
<!-- ???????????? -->
      <div style="height:299px;">
        <table id="notice" class="main_dash_tbl main_dash_tbl_2" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="dash_title_td" style="padding-top:1px;">
              <div class="dash_title">
                ????????????
                <span class="management_nread_count">(<?php echo $management_nread_count; ?>)</span>
                <span class="development_nread_count" style="display:none;">(<?php echo $development_nread_count; ?>)</span>
                <span class="version_nread_count" style="display:none;">(<?php echo $version_nread_count; ?>)</span>
              </div>
            </td>
            <td align="right" style="padding-right:10px;vertical-align:middle;">
              <div style="padding-top:15px;"><img src="<?php echo $misc;?>img/dashboard/dash_plus.svg" width="25" onclick="go_detail(this)" style="cursor:pointer;"/></div>
            </td>
          </tr>
          <tr>
            <td height="16"></td>
          </tr>
          <tr>
            <td colspan="2" height="10" style="border-top: 1px solid rgba(0, 0, 0, 0.19);"></td>
          </tr>
          <!-- <tr>
            <td height="20"></td>
          </tr> -->

          <tr height="20" id="notice_btn">
            <td class="btn_menu_1" style="float:left" style="padding-left:10px;">
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_6-1_on.svg" id="notice_dash_6-1:on" class="notice_btn_on" onclick="change_tbl(this.id);"  width="90" name="001"/>
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_6-1_off.svg" id="notice_dash_6-1:off" class="notice_btn_off" onclick="change_tbl(this.id);" style="display:none;" width="90"/>
            </td>
            <td class="btn_menu_2" style="float:left" style="padding-left:10px;">
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_6-2_on.svg" id="notice_dash_6-2:on" class="notice_btn_on" onclick="change_tbl(this.id);" style="display:none;" width="90" name="002"/>
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_6-2_off.svg" id="notice_dash_6-2:off" class="notice_btn_off" onclick="change_tbl(this.id);" width="90"/>
            </td>
            <td class="btn_menu_2 btn_menu_ex" style="float:left" style="padding-left:10px;">
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_6-3_on.svg" id="notice_dash_6-3:on" class="notice_btn_on" onclick="change_tbl(this.id);" style="display:none;" width="90" name="003"/>
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_6-3_off.svg" id="notice_dash_6-3:off" class="notice_btn_off" onclick="change_tbl(this.id);" width="90"/>
            </td>
          </tr>
          <tr>
            <td height="10"></td>
          </tr>
          <!-- <tr>
          <td height="20"></td>
        </tr> -->

          <!-- ???????????? -->
          <tr>
            <td colspan="2" valign="top">
              <table id="tbl_notice_dash_6-1" class="notice_dash_6" width="100%">
                <tr>
                  <td colspan="2" valign="top">
                    <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                      <colgroup>
                        <col width="63%">
                        <col width="13%">
                        <col width="24%">
                      </colgroup>
                      <?php
                        if ($management_count > 0) {
                          $i = $management_count;
                          $icounter = 0;

                          foreach ( $management as $item ) {
                            if($item['user_seq'] == '') {
                              $read = "font-weight:bold;";
                            } else {
                              $read = '';
                            }
                        // if ($notice_list_count > 0) {
                        //   $i = $notice_list_count;
                        //   $icounter = 0;
                        //
                        //   foreach ( $notice_list as $item ) {
                      ?>
                      <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style="<?php echo $read; ?>">
                       <td class="board_title" align="left" height="30" style="text-overflow:ellipsis; overflow:hidden;padding-left:18px;">
                         <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;">
                           <a href="JavaScript:ViewBoard('<?php echo $item['seq'];?>','<?php echo $item['category_code'] ?>')"><?php echo $item['subject'];?></a>
                        </div>
                       </td>
                       <td class="board_writer" align="right"><?php echo $item['user_name'];?></td>
                       <td class="board_date" align="right" style="padding-right:18px;"><?php echo substr($item['update_date'], 0, 10);?></td>
                      </tr>
                    <?php
                  				$i--;
                  				$icounter++;
                  			}
                  		} else {
                  	?>
                      <tr>
                        <td width="100%" height="80" align="center" colspan="9" class="no_list">????????? ???????????? ????????????.</td>
                      </tr>
                  	<?php
                  		}
                  	?>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- ???????????? -->
          <tr>
            <td colspan="2" valign="top">
              <table id="tbl_notice_dash_6-2" class="notice_dash_6" width="100%" style="display:none;">
                <tr>
                  <td colspan="2" valign="top">
                    <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                      <colgroup>
                        <col width="63%">
                        <col width="13%">
                        <col width="24%">
                      </colgroup>
                      <?php
                        if ($development_count > 0) {
                          $i = $development_count;
                          $icounter = 0;

                          foreach ( $development as $item ) {
                            if($item['user_seq'] == '') {
                              $read = "font-weight:bold;";
                            } else {
                              $read = '';
                            }
                      ?>
                      <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style="<?php echo $read; ?>">
                       <td class="board_title" align="left" height="30" style="text-overflow:ellipsis; overflow:hidden;padding-left:18px;">
                         <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;">
                           <a href="JavaScript:ViewBoard('<?php echo $item['seq'];?>','<?php echo $item['category_code'] ?>')"><?php echo $item['subject'];?></a>
                        </div>
                       </td>
                       <td class="board_writer" align="right"><?php echo $item['user_name'];?></td>
                       <td class="board_date" align="right" style="padding-right:18px;"><?php echo substr($item['update_date'], 0, 10);?></td>
                      </tr>
                    <?php
                  				$i--;
                  				$icounter++;
                  			}
                  		} else {
                  	?>
                      <tr>
                        <td width="100%" height="80" align="center" colspan="9" class="no_list">????????? ???????????? ????????????.</td>
                      </tr>
                  	<?php
                  		}
                  	?>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- ???????????? -->
          <tr>
            <td colspan="2" valign="top">
              <table id="tbl_notice_dash_6-3" class="notice_dash_6" width="100%" style="display:none;">
                <tr>
                  <td colspan="2" valign="top">
                    <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                      <colgroup>
                        <col width="63%">
                        <col width="13%">
                        <col width="24%">
                      </colgroup>
                      <?php
                        if ($version_count > 0) {
                          $i = $version_count;
                          $icounter = 0;

                          foreach ( $version as $item ) {
                            if($item['user_seq'] == '') {
                              $read = "font-weight:bold;";
                            } else {
                              $read = '';
                            }
                      ?>
                      <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style="<?php echo $read; ?>">
                       <td class="board_title" align="left" height="30" style="text-overflow:ellipsis; overflow:hidden;padding-left:18px;">
                         <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;">
                           <a href="JavaScript:ViewBoard('<?php echo $item['seq'];?>','<?php echo $item['category_code'] ?>')"><?php echo $item['subject'];?></a>
                        </div>
                       </td>
                       <td class="board_writer" align="right"><?php echo $item['user_name'];?></td>
                       <td class="board_date" align="right" style="padding-right:18px;"><?php echo substr($item['update_date'], 0, 10);?></td>
                      </tr>
                    <?php
                  				$i--;
                  				$icounter++;
                  			}
                  		} else {
                  	?>
                      <tr>
                        <td width="100%" height="80" align="center" colspan="9" class="no_list">????????? ???????????? ????????????.</td>
                      </tr>
                  	<?php
                  		}
                  	?>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
    </div>

    <!-- ?????????????????? -->
    <div class="main_dash3">
      <div style="height:409px;">
        <table id="weekly_report" class="main_dash_tbl" border="0" cellspacing="0" cellpadding="0">
          <tr valign="top">
            <td class="dash_title_td" style="padding-top:1px;"><div class="dash_title">?????????????????? (<?php echo $weekly_report_nread_count['cnt']; ?>)</div></td>
            <td align="right" style="padding-right:10px; padding-top:15px"><img src="<?php echo $misc;?>img/dashboard/dash_plus.svg" width="25" onclick="go_detail(this)" style="cursor:pointer;"/></td>
          </tr>
          <tr>
            <td height="16"></td>
          </tr>
          <tr>
            <td colspan="2" height="10" style="border-top: 1px solid rgba(0, 0, 0, 0.19);"></td>
          </tr>
          <tr>
            <td height="5"></td>
          </tr>
          <tr>
            <td colspan="3" valign="top">
              <table class="content_tbl" align="left" width="90%" border="0" cellspacing="0" cellpadding="0" style="padding-left: 20px;">
                <colgroup>
                  <col width="54%">
                  <col width="22%">
                  <col width="24%">
                </colgroup>
                <?php
                  if ($weekly_report_list_count > 0) {
                    $i = $weekly_report_list_count;
                    $icounter = 0;

                    foreach ( $weekly_report_list as $item ) {
                      if($item['user_seq'] == '') {
                        $read = "font-weight:bold;";
                      } else {
                        $read = '';
                      }
                      ?>
                <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" onclick="JavaScript:ViewWeekly('<?php echo $item['seq'];?>')" style="cursor:pointer;height:30px;<?php echo $read; ?>">
                 <td class="board_title" align="left" height="30" style="text-overflow:ellipsis; overflow:hidden;">
                   <?php
                   	$tmp=explode(" ",$item['s_date']);
                   	$tmp2=explode("-",$tmp[0]);
                     echo $tmp2[0]."??? ".$item['month']."??? ".$item['week']."??????" ;
                   ?>
                 </td>
                 <td class="board_writer" align="left"><?php echo $item['group_name'];?></td>
                 <td class="board_date" align="right"><?php echo substr($item['update_time'], 0, 10);?></td>
                </tr>
                   <?php
            				$i--;
            				$icounter++;
            			}
            		} else {
            	?>
                <tr>
                  <td width="100%" height="80" align="center" colspan="9" class="no_list">????????? ???????????? ????????????.</td>
                </tr>
  	<?php
  		}
  	?>
              </table>
            </td>
          </tr>
        </table>
      </div>
<!-- ???????????? -->
      <div style="height:180px;margin-bottom:21px;">
        <table id="diquitaca" class="main_dash_tbl" border="0" cellspacing="0" cellpadding="0" style="display:inline-block;">
          <tr valign="top">
            <td class="dash_title_td" style="padding-top:1px;"><div class="dash_title">???????????? (<?php echo $diquitaca_nread_count['cnt']; ?>)</div></td>
            <td align="right" style="padding-right:10px;vertical-align:middle;width:45px;">
              <div style="padding-top:15px;"><img src="<?php echo $misc;?>img/dashboard/dash_plus.svg" width="25" onclick="go_detail(this)" style="cursor:pointer;"/></div>
            </td>
          </tr>
          <tr>
            <td height="16"></td>
          </tr>
          <tr>
            <td colspan="4" height="10" style="border-top: 1px solid rgba(0, 0, 0, 0.19);"></td>
          </tr>
          <tr>
            <td colspan="3" valign="top">
              <table class="content_tbl" align="left" width="90%" border="0" cellspacing="0" cellpadding="0" style="padding-left: 20px">
                <colgroup>
                  <col width="54%">
                  <col width="11%">
                  <col width="11%">
                  <col width="24%">
                </colgroup>
      <?php if(!empty($diquitaca)) {
              foreach($diquitaca as $item) {
                if($item['vote_yn'] == 'Y') {
                  $vote = true;
                } else {
                  $vote = false;
                }
                if($vote) {
                  $deadline = strtotime($item['vote_deadline']);
                  $now = strtotime("Now");
                  if($now > $deadline) {
                    $vote_progress = '????????????';
                  } else if($now < $deadline) {
                    $vote_progress = "?????????";
                  }
                }
                if($item['user_seq'] == '') {
                  $read = "font-weight:bold;";
                } else {
                  $read = '';
                }
                ?>
                <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" onclick="JavaScript:ViewDiquitaca('<?php echo $item['seq'];?>')" style="cursor:pointer;height:30px;<?php echo $read; ?>">
                  <td class="board_title" align="left" height="30" style="text-overflow:ellipsis; overflow:hidden;">
                    <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;">
                      <?php echo stripslashes($item['title']); ?>
                    </div>
                  </td>
                  <td align="right">
                    <?php
                    if($vote) {
                      if($vote_progress == "????????????") {
                        echo "<span style='color:#767676'>?????????</span>";
                      } else if($vote_progress == '?????????') {
                        echo "<span style='color:#5938E4'>?????????</span>";
                      }
                    } else {
                      echo "<span style='color:".$item['color']."'>".$item['category_name']."</span>";
                    } ?>
                  </td>
                  <td class="board_writer" align="right"><?php echo $item['user_name'];?></td>
                  <td class="board_date" align="right"><?php echo date('Y-m-d', strtotime($item['insert_date'])); ?></td>
                </tr>
        <?php }
            } else { ?>
                <tr>
                  <td width="100%" height="80" align="center" colspan="9" class="no_list">????????? ???????????? ????????????.</td>
                </tr>
        <?php } ?>
            </table>
            </td>
          </tr>
        </table>
      </div>
<!-- ????????? -->
      <div style="height:303px">
        <table id="address" class="main_dash_tbl" border="0" cellspacing="0" cellpadding="0" style="display:inline-block;">
          <tr valign="top">
            <td class="dash_title_td" style="padding-top:1px;"><div class="dash_title">?????????</div></td>
            <td align="right" style="width:40px">
              <div style="padding-top:6px;">
                <img style="cursor:pointer;margin-top:10px;" onclick="prev_address();" src="<?php echo $misc;?>img/dashboard/btn/btn_left.svg" width="25" />
              </div>
            </td>
            <td align="right" style="width:40px;">
              <div style="padding-top:6px;">
                <img style="cursor:pointer;margin-top:10px;" onclick="next_address();" src="<?php echo $misc;?>img/dashboard/btn/btn_right.svg" width="25"/>
              </div>
            </td>
            <td align="right" style="padding-right:10px;vertical-align:middle;width:45px;">
              <div style="padding-top:15px;"><img src="<?php echo $misc;?>img/dashboard/dash_plus.svg" width="25" onclick="go_detail(this)" style="cursor:pointer;"/></div>
            </td>
          </tr>
          <tr>
            <td height="16"></td>
          </tr>
          <tr>
            <td colspan="4" height="10" style="border-top: 1px solid rgba(0, 0, 0, 0.19);"></td>
          </tr>


          <?php
          $j=0;
          for($i=0; $i < count($user_data); $i=$i+5) { ?>
            <tr>
              <td colspan="4" valign="top">
                <table id="tbl_dash_3-<?php echo $j+1; ?>" width="100%" style="padding-left:10px;padding-right:10px;<?php if($j>0){echo "display:none;";} ?>">
                  <tr>
                    <td colspan="2" valign="top">
                      <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0" style="">
                        <colgroup>
                          <col width="18%">
                          <col width="22%">
                          <col width="30%">
                          <col width="30%">
                        </colgroup>
                <?php for($k = 0; $k < 5; $k++) { ?>
                        <tr>
                          <td style="font-weight:bold;color:#1C1C1C;height:40px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;padding-left:10px;">
                            <?php if(isset($user_data[$i+$k])){echo $user_data[$i+$k]['user_name'].' '.mb_substr($user_data[$i+$k]['user_duty'],0,2);} ?>
                          </td>
                          <td style="color:#1C1C1C;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            <?php if(isset($user_data[$i+$k])){echo $user_data[$i+$k]['user_group'];} ?>
                          </td>
                          <td style="align:right;color:#1C1C1C;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="<?php if(isset($user_data[$i+$k]['extension_number']) && $user_data[$i+$k]['extension_number'] != null) {echo $user_data[$i+$k]['extension_number'].' / ';} ?><?php if(isset($user_data[$i+$k])){echo $user_data[$i+$k]['user_tel'];} ?>">
                            <?php if(isset($user_data[$i+$k]['extension_number']) && $user_data[$i+$k]['extension_number'] != null) {echo $user_data[$i+$k]['extension_number'].' / ';} ?>
                            <?php if(isset($user_data[$i+$k])){echo $user_data[$i+$k]['user_tel'];} ?>
                          </td>
                          <td style="color:#B0B0B0;padding-left:5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="<?php if(isset($user_data[$i+$k])){echo $user_data[$i+$k]['user_email'];} ?>">
                            <?php if(isset($user_data[$i+$k])){echo $user_data[$i+$k]['user_email'];} ?>
                          </td>
                        </tr>
                <?php } ?>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
    <?php $j++;
          } ?>


        </table>
      </div>
    </div>

<!-- ?????? -->
    <div class="main_dash4">
      <div style="height:450px;">
        <table id="schedule" class="main_dash_tbl dash_tbl_4" border="0" cellspacing="0" cellpadding="0">
          <tr valign="top">
            <td class="dash_title_td" style="padding-top:1px;"><div class="dash_title">??????</div></td>
            <td align="right" style="padding-right:10px;vertical-align:middle;">
              <div style="padding-top:15px;"><img src="<?php echo $misc;?>img/dashboard/dash_plus.svg" width="25" onclick="go_detail(this)" style="cursor:pointer;"/></div>
            </td>
          </tr>
          <tr>
            <td height="16"></td>
          </tr>
          <tr>
            <td colspan="2" height="10" style="border-top: 1px solid rgba(0, 0, 0, 0.19);"></td>
          </tr>
          <tr>
            <td colspan="3" valign="top">
              <table class="content_tbl" align="center" width="90%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="3" align="center" style="padding-top:20px;">
                    <div id="calendar"></div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
<!-- ??????????????? -->
      <div style="max-height:430px !important;">
        <table id="tech_support" class="main_dash_tbl dash_tbl_4" border="0" cellspacing="0" cellpadding="0">
          <tr valign="top">
            <td class="dash_title_td">
              <div class="dash_title" style="float:left;">???????????????</div>
              <div style="float:right;margin-top:20px;margin-right:10px">
                <img src="<?php echo $misc; ?>/img/dashboard/btn/reservation_on.svg" onclick="rez_equipment();" width='100' style="cursor:pointer;">
                <!-- <img src="<?php echo $misc; ?>/img/dashboard/btn/reservation_off.svg" width='100'> -->
                <!-- <button type="button" class="rez_btn" onclick="rez_equipment();">????????????</button> -->
              </div>
            </td>
          </tr>
          <tr>
            <td height="16"></td>
          </tr>
          <tr>
            <td colspan="4" height="10" style="border-top: 1px solid rgba(0, 0, 0, 0.19);"></td>
          </tr>
          <tr>
            <td align="center" style="font-weight:bold;font-size:17px;display:flex;justify-content: center;">
              <div>
                <img style="margin-right:20px;" src="<?php echo $misc;?>img/dashboard/btn/btn_left.svg" width="25" onclick="change_date('pre')"/>
              </div>
              <a id="rez_date" style="color:#0575E6;margin-top:4px;"></a>
              <div>
                <img style="margin-left:20px;" src="<?php echo $misc;?>img/dashboard/btn/btn_right.svg" width="25" onclick="change_date('next')"/>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="2" valign="top">
              <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">

                <div id="room_timeline" style="margin-top:20px;padding-left:10px;padding-right:10px;"></div>
                <div id="car_timeline" style="margin-top:0px;padding-left:10px;padding-right:10px;"></div>
              </table>
            </td>
          </tr>
        </table>
      </div>
    </div>

    <!-- ????????? ????????? ?????? -->
    <?php if($parent_group == "????????????" || $parent_group == '???????????????'){ ?>
    <div id="modal" class="searchModal">
      <div class="search-modal-content">
        <!-- <button onClick="closeModal();" style="float:right;">??????</button> -->

        <div class="row">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-12">
                <h2>???????????? ?????????</h2>
              </div>
              <div>
                <table  width="100%" border="1" cellspacing="0" cellpadding="0" style="font-weight:bold;font-size:13px;">
                    <tr width="100%" height=30>
                        <td align="center" width="10%" bgcolor="f8f8f9" >idx</td>
                        <td align="center" width="20%" bgcolor="f8f8f9" >?????????</td>
                        <td align="center" width="20%" bgcolor="f8f8f9" >???????????????</td>
                        <td align="center" width="10%" bgcolor="f8f8f9" >????????????</td>
                        <td align="center" width="10%" bgcolor="f8f8f9" >??????????????????</td>
                        <td align="center" width="10%" bgcolor="f8f8f9" >?????????</td>
                        <td align="center" width="10%" bgcolor="f8f8f9" >?????????</td>
                        <td align="center" width="10%" bgcolor="f8f8f9" >?????????</td>
                    </tr>

                    <?php
                    $idx=1;
                    foreach($periodic_inspection as $val){
                      $font_color='';
                      if($val['maintain_result']==9){
                        $font_color="style='color:red'";
                      }
                        echo "<tr height=30 align='center'><td>{$idx}</td>";
                        echo "<td>{$val['customer_companyname']}</td>";
                        echo "<td>{$val['project_name']}</td>";
                        echo "<td>";
                        if ($val['maintain_cycle'] == "1") {
                            echo "?????????";
                        }else if ($val['maintain_cycle'] == "3") {
                            echo "????????????";
                        }else if ($val['maintain_cycle'] == "6") {
                            echo "????????????";
                        }else if ($val['maintain_cycle'] == "0") {
                            echo "?????????";
                        }else if ($val['maintain_cycle'] == "7") {
                            echo "?????????";
                        }else{
                            echo "";
                        }
                        echo "</td>";
                        echo "<td {$font_color}>{$val['maintain_date']}</td>";
                        echo "<td>";
                        if ($val['manage_team'] == "1") {
                          echo "?????? 1???";
                        }else if ($val['manage_team'] == "2") {
                            echo "?????? 2???";
                        }else if ($val['manage_team'] == "3") {
                            echo "?????? 3???";
                        }else{
                            echo "";
                        }
                        echo "</td>";
                        echo "<td>{$val['maintain_user']}</td>";
                        echo "<td>{$val['maintain_comment']}</td></tr>";

                        $idx=$idx+1;
                    }
                    ?>
                </table>
              </div>
            </div>
          </div>
        </div>
          <div style="cursor:pointer;background-color:#DDDDDD;text-align: center;padding-bottom: 10px;padding-top: 10px;margin-top:20px;" onClick="closeModal();">
            <span class="pop_bt modalCloseBtn" style="font-size: 13pt;">??????</span>
          </div>
      </div>
    </div>

    <div id="modal2" class="searchModal">
      <div class="search-modal-content">
        <!-- <button onClick="closeModal();" style="float:right;">??????</button> -->

        <div class="row">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-12">
                <h2>??????????????? ?????? ???????????? ?????????</h2>
              </div>
              <div>
                <table  width="100%" border="1" cellspacing="0" cellpadding="0" style="font-weight:bold;font-size:13px;">
                    <tr width="100%" height=30>
                        <td align="center" width="10%" bgcolor="f8f8f9" >idx</td>
                        <td align="center" width="20%" bgcolor="f8f8f9" >?????????</td>
                        <td align="center" width="20%" bgcolor="f8f8f9" >???????????????</td>
                        <td align="center" width="10%" bgcolor="f8f8f9" >?????????</td>
                        <td align="center" width="10%" bgcolor="f8f8f9" >?????????</td>
                    </tr>

                    <?php
                    $idx=1;
                    foreach($fortigate_project as $val){
                      echo "<tr height=30 align='center' style='cursor:pointer;' onclick=''><td>{$idx}</td>";
                      echo  "<td>{$val['customer_companyname']}</td>";
                      echo  "<td>{$val['project_name']}</td>";
                      echo "<td>";
                      if ($val['manage_team'] == "1") {
                        echo "?????? 1???";
                      }else if ($val['manage_team'] == "2") {
                          echo "?????? 2???";
                      }else if ($val['manage_team'] == "3") {
                          echo "?????? 3???";
                      }else{
                          echo "";
                      }
                      echo "</td>";
                      echo  "<td>{$val['maintain_user']}</td>";
                      echo "</tr>";

                      $idx=$idx+1;
                    }
                    ?>
                </table>
              </div>
            </div>
          </div>
        </div>
          <div style="cursor:pointer;background-color:#DDDDDD;text-align: center;padding-bottom: 10px;padding-top: 10px;margin-top:20px;" onClick="closeModal2();">
            <span class="pop_bt modalCloseBtn" style="font-size: 13pt;">??????</span>
          </div>
      </div>
    </div>
    <?php } ?>
    <!-- ????????? ????????? ?????? ??? -->


  </div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">

  jQuery(document).ready(function () {
    <?php if(isset($_GET['login'])){?>
    $("#modal").show();
    $("#modal2").show();
    <?php } ?>

    <?php  if ($id == "bhkim") { ?>
    <?php } ?>
    ping_mail(0);
  });

  function closeModal() {
    $("#modal").hide();
  };
  function closeModal2() {
    $("#modal2").hide();
  };
// + ?????? ???????????? ?????? ????????? ??????
  function go_detail(el) {
    if (el == 'mail') {
      var page = "mail";
    } else {
      var page = $(el).closest('table').attr('id');

    }
    if (page=="mail") {
      // location.href = "https://mail.durianit.co.kr/";
      var mail_address = "<?php echo $email ?>";

      $.ajax({
        type:"POST",
        async:true,
        url:"/index.php/mail/get_pkey",
        dataType:"json",
        success : function(data){
          // console.log(data);
          var newForm = $('<form name="winName"></form>');
          newForm.attr("method","post");
          newForm.attr("action", "https://mail.durianit.co.kr/index.php/account/biz_login");
          newForm.append($('<input>', {type: 'hidden', name: 'login_mode', value: 'general'}));
          newForm.append($('<input>', {type: 'hidden', name: 'inputId', value: mail_address }));
          newForm.append($('<input>', {type: 'hidden', name: 'inputPass', value:data.pkey }));
          newForm.append($('<input>', {type: 'hidden', name: 'biz_mode', value:'y' }));
          newForm.appendTo('#mail_tbl');
          newForm.attr("target", "winName");
          var gsWin = window.open("", "winName");
          newForm.submit();
          },
        error : function(request, status, error){
            console.log("AJAX_ERROR");
          }

      })
    } else if (page=="approval") {
      var type = '';
      $("#approval_btn").find(".approval_btn_on").each(function(){
        if ($(this).is(':visible')) {
          type = $(this).attr('name');
        }
      })
      location.href = "<?php echo site_url();?>/biz/approval/electronic_approval_list?type="+type;
    } else if (page=="notice") {
      var category = '';
      $("#notice_btn").find(".notice_btn_on").each(function(){
        if ($(this).is(':visible')) {
          category = $(this).attr('name');
        }
      })
      location.href = "<?php echo site_url();?>/biz/board/notice_list?category="+category;
    } else if (page=="address") {
      location.href = "<?php echo site_url();?>/admin/account/user";
    } else if (page=="schedule") {
      location.href = "<?php echo site_url();?>/biz/schedule/tech_schedule";
    } else if (page=="attendance") {
      location.href = "<?php echo site_url();?>/biz/attendance/attendance_user";
    } else if (page=="diquitaca") {
      location.href = "<?php echo site_url(); ?>/biz/diquitaca/qna_list";
    } else if (page == 'weekly_report') {
      location.href = "<?php echo site_url(); ?>/biz/weekly_report/weekly_report_list";
    }
  }

// [????????????] ?????? ????????? ?????? ??????
function change_tbl(id) {
    var btn_type = id.split('_');
    var type = btn_type[0];
    var btn_id = id.split(":");
    var id = btn_id[0];
    $("."+type+"_btn_on").hide();
    $("."+type+"_btn_off").show();
    // $(".btn_on").hide();
    // $(".btn_off").show();
    $("#"+id+"\\:on").show();
    $("#"+id+"\\:off").hide();
    var cname = id.split("-")[0];
    $("."+cname).hide();
    $("."+cname).closest('tr').hide();
    $("#tbl_"+id).show();
    $("#tbl_"+id).closest('tr').show();
    // console.log('type:'+type+' id:'+id+' cname:'+cname);
    if(id == 'notice_dash_6-1') {
      $('.management_nread_count').show();
      $('.development_nread_count').hide();
      $('.version_nread_count').hide();
    } else if (id == 'notice_dash_6-2') {
      $('.management_nread_count').hide();
      $('.development_nread_count').show();
      $('.version_nread_count').hide();
    } else if (id == 'notice_dash_6-3') {
      $('.management_nread_count').hide();
      $('.development_nread_count').hide();
      $('.version_nread_count').show();
    } else if (id == 'approval_dash_2-1') {
      $('.no_read_cnt_s').show();
      $('.no_read_cnt_p').hide();
      $('.no_read_cnt_c').hide();
      $('.no_read_cnt_b').hide();
      $('.no_read_cnt_w').hide();
    } else if (id == 'approval_dash_2-2') {
      $('.no_read_cnt_s').hide();
      $('.no_read_cnt_p').show();
      $('.no_read_cnt_c').hide();
      $('.no_read_cnt_b').hide();
      $('.no_read_cnt_w').hide();
    } else if (id == 'approval_dash_2-3') {
      $('.no_read_cnt_s').hide();
      $('.no_read_cnt_p').hide();
      $('.no_read_cnt_c').show();
      $('.no_read_cnt_b').hide();
      $('.no_read_cnt_w').hide();
    } else if (id == 'approval_dash_2-4') {
      $('.no_read_cnt_s').hide();
      $('.no_read_cnt_p').hide();
      $('.no_read_cnt_c').hide();
      $('.no_read_cnt_b').show();
      $('.no_read_cnt_w').hide();
    } else if (id == 'approval_dash_2-5') {
      $('.no_read_cnt_s').hide();
      $('.no_read_cnt_p').hide();
      $('.no_read_cnt_c').hide();
      $('.no_read_cnt_b').hide();
      $('.no_read_cnt_w').show();
    }
  }

// [????????????] ?????? ?????? ??????
  function clock(){
    var date = new Date();

    var hours = date.getHours();
    var minutes = date.getMinutes();
    if (minutes<10) {
      minutes = "0"+minutes;
    }
    var seconds = date.getSeconds();
    if (seconds<10) {
      seconds = "0"+seconds;
    }

    $("#clock").empty();
    $("#clock").append(hours+":"+minutes+":"+seconds);
  }

// [????????????] ?????? ?????? ?????? ??????
  function work_time(){
    var work_time = $("#total_work_time").val();
    // console.log(work_time);
    work_time = work_time.split(":");
    var hour = work_time[0];
    var min = work_time[1];
    var sec = work_time[2];

    if($("#work_on_time").text().trim()!="?????????"&&$("#work_off_time").text().trim()=="?????????"){
      // alert(1)
      sec++;
      if (sec>59){
        sec = 0;
        min++
        if (min>59){
          min = 0;
          hour++
        }
      }

      var total_work_time = hour+":"+min+":"+sec;
      $("#total_work_time").val(total_work_time);
      var total_work_time_text = hour+"?????? "+min+"??? "+sec+"???";
      $("#total_work_time_text").text(total_work_time_text);
    }
  }

// ?????? ??????, ?????? ?????? ?????? ??????
  setInterval(clock, 1000);
  setInterval(work_time, 1000);

  // alert($("#work_off_time").text());

// [??????] ?????? ??????
  $(document).ready(function () {
    $("#calendar").simpleCalendar({
      fixedStartDay: 0, // begin weeks by sunday
      disableEmptyDetails: true,
      events: [
        // generate new event after tomorrow for one hour
        <?php
        foreach ($schedule as $v) {
          if($v['work_type']=='tech'){
            echo "{startDate:'".$v['start_day']."T".$v['start_time']."',";
            echo "endDate:'".$v['end_day']."T".$v['end_time']."',";
            echo "summary:'".$v['customer']."/".$v['work_name']."/".$v['support_method']."'";
            echo "},";


          } else {
            echo "{startDate:'".$v['start_day']."T".$v['start_time']."',";
            echo "endDate:'".$v['end_day']."T".$v['end_time']."',";
            echo "summary:'".$v['title']."'";
            echo "},";
          }
        }
         ?>
      ],
      months : ['01','02','03','04','05','06','07','08','09','10','11','12'],
      days: ['???','???','???','???','???','???','???']
    });

    // var today = new Date();

    // [????????? ??????] ?????? ?????? ??????
    $("#rez_date").text(getToday());
  });

  var first_address = 1;
  var last_address = "<?php echo ceil(count($user_data) / 5); ?>";
// [?????????] < ?????? ?????? ???
  function prev_address() {
    if(first_address != 1) {
      $('#tbl_dash_3-'+(first_address)+'').hide();
      $('#tbl_dash_3-'+(first_address-1)+'').show();
      first_address--;
    }
  }
// [?????????] > ?????? ?????? ???
  function next_address() {
    if(first_address < last_address) {
      $('#tbl_dash_3-'+(first_address)+'').hide();
      $('#tbl_dash_3-'+(first_address+1)+'').show();
      first_address++;
    }
  }

// ???????????? ???????????? ??????
  function ViewBoard(seq,category_code) {
    if(category_code == "004"){
      window.location = "<?php echo site_url(); ?>/biz/board/lab_notice_view?dash=Y&category="+category_code+"&mode=view&seq="+seq;
    }else{

      window.location = "<?php echo site_url(); ?>/biz/board/notice_view?dash=Y&category="+category_code+"&mode=view&seq="+seq;
    }
  }
// ???????????? ???????????? ??????
  function ViewWeekly (seq){
    window.location = "<?php echo site_url();?>/biz/weekly_report/weekly_report_view?dash=Y&mode=view&seq="+seq;
  }
// ???????????? ???????????? ??????
  function eletronic_approval_view(seq, page) {
    window.location = "<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_view?seq="+seq+"&type="+page;
  }

// ???????????? ???????????? ??????
  function ViewDiquitaca(seq) {
    window.location = "<?php echo site_url(); ?>/biz/diquitaca/qna_view?seq=" + seq;
  }

// ?????? +- ??????
  function dateAddDel(sDate, nNum, type) {
    var yy = parseInt(sDate.substr(0, 4), 10);
    var mm = parseInt(sDate.substr(5, 2), 10);
    var dd = parseInt(sDate.substr(8), 10);

    if (type == "d") {
      d = new Date(yy, mm - 1, dd + nNum);
    } else if (type == "m") {
      d = new Date(yy, mm - 1, dd + (nNum * 31));
    } else if (type == "y") {
      d = new Date(yy + nNum, mm - 1, dd);
    }

    yy = d.getFullYear();
    mm = d.getMonth() + 1; mm = (mm < 10) ? '0' + mm : mm;
    dd = d.getDate(); dd = (dd < 10) ? '0' + dd : dd;

    return '' + yy + '-' +  mm  + '-' + dd;
  }

// [????????? ??????] < > ?????? ?????? ???
  function change_date(type) {
    var date = $("#rez_date").text();
    if (type=='pre'){
      date = dateAddDel(date,-1,'d');
      $("#rez_date").text(date);
      if (getToday()==date){
        $("#rez_date").css('color','#0575E6');
      } else {
        $("#rez_date").css('color','');
      }
      day = date;
      google.charts.setOnLoadCallback(room_drawChart);
      google.charts.setOnLoadCallback(car_drawChart);
    } else {
      date = dateAddDel(date,+1,'d');
      $("#rez_date").text(date);
      if (getToday()==date){
        $("#rez_date").css('color','#0575E6');
      } else {
        $("#rez_date").css('color','');
      }
      day = date;
      google.charts.setOnLoadCallback(room_drawChart);
      google.charts.setOnLoadCallback(car_drawChart);
    }
  }

// ????????? ?????? - ???????????? ?????? ?????? ???
  function rez_equipment() {
    var rez_date = $("#rez_date").text();
    sessionStorage.setItem("dash_rez_date", rez_date);
    window.location = "<?php echo site_url(); ?>/biz/schedule/tech_schedule";
  }

//???????????? ????????????
  function input_work(status) {
    if (status=="on") {
      if ($("#work_on_time").text().trim()!="?????????") {
        alert("?????? ?????? ????????? ????????????.");
        return false;
      } else {
        var ws_time = getTimeStamp();
        var wc_time = '';
      }
    } else {
      if ($("#work_on_time").text().trim()=="?????????") {
        alert("?????? ????????? ????????????.");
        return false;
      } else {
        var ws_time = '';
        var wc_time = getTimeStamp();
      }
    }
    // alert(today);
    $.ajax({
      type:"POST",
      // async:false,
      url:"/index.php/home/input_attendance_manual",
      dataType:"json",
      data:{
        ws_time:ws_time,
        wc_time:wc_time
      }
    }).done(function(response) {
      if(response == "true"){
        if (status=="on"){
          alert("?????? ?????????????????????.");
          location.reload();
        } else {
          alert("?????? ?????????????????????.");
          location.reload();
        }
      } else if (response=="nocard"){
        alert('????????? ???????????? ???????????????.');
      }
    })
  }

  function getTimeStamp() {
    var d = new Date();
    var s =
        leadingZeros(d.getFullYear(), 4) +
        leadingZeros(d.getMonth() + 1, 2) +
        leadingZeros(d.getDate(), 2) +
        leadingZeros(d.getHours(), 2) +
        leadingZeros(d.getMinutes(), 2) +
        leadingZeros(d.getSeconds(), 2);
    return s;
  }

  function leadingZeros(n, digits) {
    var zero = '';
    n = n.toString();

    if (n.length < digits) {
        for (i = 0; i < digits - n.length; i++)
            zero += '0';
    }
    return zero + n;
  }

  $("#btn_work_on").hover(function(){
    $(this).attr('src', '<?php echo $misc;?>img/dashboard/btn/btn_on_work_on.svg');
  }, function() {
    $(this).attr('src', '<?php echo $misc;?>img/dashboard/btn/btn_on_work_off.svg');
  })
  $("#btn_work_off").hover(function(){
    $(this).attr('src', '<?php echo $misc;?>img/dashboard/btn/btn_off_work_on.svg');
  }, function() {
    $(this).attr('src', '<?php echo $misc;?>img/dashboard/btn/btn_off_work_off.svg');
  })


  function ping_mail(mode){

    if(mode == 0){
      var mail_address ="";
      var password = "";
      <?php if(isset($mail_key)){ ?>

        mail_address = '<?php echo $mail_key->uid; ?>';
        password = '<?php echo $mail_key->pkey; ?>';

        <?php } ?>
    } else {
      var mail_address = $("#authMail").val();
      var password = $("#authMail_pass").val();
      if(mail_address == ""){
        alert("??????????????? ??????????????????");
        return false;
      }
      if(password == ""){
        alert("??????????????? ??????????????????");
        return false;
      }
      $.ajax({
        type:"POST",
        async: false,
        url:"/index.php/mail/make_key",
        dataType:"json",
        data:{input_pass : password},
        success : function(data){
          console.log(data);
          password = data;
        }
      })
    }
    $.ajax({
      // crossDomain:true,
      // processData: false,

      type:"POST",
      async: false,
      url:"https://mail.durianit.co.kr/index.php/biz_mail/imap_ping",
      // contentType: 'application/x-www-form-urlencoded; charset=utf-8',
      dataType:"json",
      timeout: 2000,
      data:{
        mail_address: mail_address,
        password : password,
        mailbox:"INBOX"

      },

      success : function(data){

          if(data == "false"){
            $("#mail_title_span").show();
            $("#mailauth_tbl").show();
            if (mode == 1) {
              alert("????????????");
            }
          } else {
            if(mode != 0){
              $.ajax({
                type:"POST",
                async: false,
                url:"/index.php/mail/update_key",
                dataType:"json",
                data:{input_pass : password},
                success : function(data){
                  console.log(data);
                }
              })
            }
            var unseen_cnt = data.unseen_cnt;
            $("#all_mailcnt").text(unseen_cnt);
            var input = "<select class='mail_select' id='mbox_input' style='height:30px;width:90%;'>";
            var data = data.mailbox_tree;
            var boxlen = data.length;
            for (var i = 0; i < boxlen; i++) {
              var input_val = data[i].id;
              var child_num = data[i].child_num;
              if (child_num > 0) {
                var nbsp = "";
                for (var j = 0; j < child_num; j++) {
                  nbsp += "&nbsp;&nbsp;";
                }
                var text = nbsp + "???" + data[i].text;
              } else {
                var text = data[i].text;
              }
              input += "<option value='"+input_val+"'>"+text+"</option>";
            }
            input += "</select>";
            // var img = '<img id="mail_reload_img" src="<?php echo $misc;?>img/dashboard/f5.svg" width="25" onclick="$(\'#mbox_input\').change()"; style="cursor:pointer;"/>';

            $("#mlist_td").append(input);
            // $("#f5_td").append(img);
            $("#mbox_tr").show();
            $("#mailauth_tbl").hide();
            $("#mail_title_span").hide();
            $("#mbox_input").change();
            $("#mbox_input").niceSelect();
            // get_mail(mail_address, password, "INBOX");

          }
       },
      error : function(request, status, error){
          // console.log(error);
          $("#authMail_pass").val("");
          $("#mailauth_tbl").show();
          $("#mbox_tr").hide();
        }
    })
  }

  $(document).on("change", "#mbox_input", function(){
    var mbox = $(this).val();
    $.ajax({
      type:"POST",
      // async: false,
      url:"/index.php/mail/get_pkey",
      dataType:"json",
      success : function(data){

        get_mail(data.uid, data.pkey, mbox);
      }
    })
  })

  function get_mail(mail_address, password, mailbox){

    $.ajax({
      // crossDomain:true,
      // processData: false,
      type:"POST",
      async: false,
      url:"https://mail.durianit.co.kr/index.php/biz_mail/get_mail",
      // contentType: 'application/x-www-form-urlencoded; charset=utf-8',
      dataType:"json",
      data:{
        mail_address: mail_address,
        password : password,
        mailbox: mailbox
      },
      success : function(data){
        if(data){
          $("#mailauth_tbl").hide();
          $("#mail_tbl tr").remove();

          if(data == "empty"){
            var html ="<tr onclick='event.cancelBubble=true' height='60'><td></td></tr><tr onclick='event.cancelBubble=true'><td colspan='3' align='center' class='no_list'>";
            html += "???????????? ????????? ????????????.";
            html += "</td></tr>";
            $("#mail_tbl tbody").append(html);
            $("#minfo_td").text("");
          }else{
            var m_stat = data.mbox_status;
            var m_head = data.mail_head;
            var box_info = m_stat.unseen + " / " + m_stat.messages;
            // console.log(m_stat);
            for (var i = 0; i < m_head.length; i++) {
              // console.log(m_head[i]);
              // if(m_head[i].from_name == ''){
              //   var from = m_head[i].from_mail;
              // }else{
              //   var from = m_head[i].from_name;
              // }

              if(m_head[i].from['from_name'] == ''){
                var from = "????????????";
              }else{
                var from = m_head[i].from['from_name'];
              }

              var html = "<tr class='seen"+m_head[i].read+"' data-uid='" + m_head[i].uid +"'>";
              html+="<td class='board_title' align='left' height='30' style='text-overflow:ellipsis; overflow:hidden; white-space:nowrap;'>"+ from +"</td>";
              html+="<td class='board_title' align='left' style='text-overflow:ellipsis; overflow:hidden; white-space:nowrap;'>"+ m_head[i].subject +"</td>";
              html+="<td class='board_date' align='right' style='text-overflow:ellipsis; overflow:hidden; white-space:nowrap;'>"+ m_head[i].udate +"</td>";
              html+="</tr>"
              // console.log(html);
              $("#mail_tbl tbody:last").append(html);
            }
            $("#minfo_td").text(box_info);
          }

          }
        },
      error : function(request, status, error){
          console.log(error);

        }

    })
  }

  $(document).on("click", "#mail_tbl tr", function(){
    var mail_address = "<?php echo $email ?>";
    var mailbox = $("#mlist_td option:selected").val();
    var mailid = $(this).attr("data-uid");

    if($(this).hasClass("seen0")){
      $(this).removeClass("seen0");
      $(this).addClass("seen1");
    }

    // var seen = $(this).attr("data-seen");
    // if(seen == 0){
    //   $(this).removeClass("seen0");
    //   // $(this).addClass("");
    // }

    $.ajax({
      type:"POST",
      async:true,
      url:"/index.php/mail/get_pkey",
      dataType:"json",
      success : function(data){
        // console.log(data);
        var newForm = $('<form name="winName"></form>');
        newForm.attr("method","post");
        newForm.attr("action", "https://mail.durianit.co.kr/index.php/account/biz_login");
        newForm.append($('<input>', {type: 'hidden', name: 'login_mode', value: 'general'}));
        newForm.append($('<input>', {type: 'hidden', name: 'inputId', value: mail_address }));
        newForm.append($('<input>', {type: 'hidden', name: 'inputPass', value:data.pkey }));
        newForm.append($('<input>', {type: 'hidden', name: 'biz_mode', value:'y' }));
        newForm.append($('<input>', {type: 'hidden', name: 'mailbox', value:mailbox }));
        newForm.append($('<input>', {type: 'hidden', name: 'mailid', value:mailid }));
        newForm.appendTo('#mail_tbl');
        newForm.attr("target", "winName");
        var gsWin = window.open("", "winName");
        newForm.submit();
        },
      error : function(request, status, error){
          console.log("AJAX_ERROR");
        }

    })



});




</script>
</html>
