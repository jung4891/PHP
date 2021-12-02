<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/dashboard.css">
<link rel="stylesheet" href="/misc/css/simple-calendar.css">
<script type="text/javascript" src="/misc/js/jquery.simple-calendar.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
      dataTable.addRows([[rez_room[i].room, rez_room[i].title+" [등록자:"+rez_room[i].user_name+"]", new Date(0,0,0,sh,em),new Date(0,0,0,eh,em)]]);
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
      dataTable.addRows([[rez_car[i].type, rez_car[i].title+" [등록자:"+rez_car[i].user_name+"]", new Date(0,0,0,sh,em),new Date(0,0,0,eh,em)]]);
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

  // 메일연동
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
<!-- 내정보 -->
  <div align="center" class="main_dash_div">
    <div class="main_dash1">
      <div style="height:370px">
        <table id="maintain" class="main_dash_tbl main_dash_tbl_1" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="dash_title_td"><div class="dash_title">내정보</div></td>
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
                  <td align="center" style="font-size:20px; font-weight:bold; color:#1C1C1C;"><span style="color:#0575E6;"><?php echo $user_name; ?></span>님 안녕하세요.</td>
                </tr>
                <tr>
                  <td align="center" height="30" style="font-size:15px;color:#626262;"><?php echo $user_group; ?></td>
                </tr>
                <tr>
                  <td height="5"></td>
                </tr>
                <tr>
                  <td align="center" style="color:#1C1C1C;">접속시간 : <?php echo $login_time; ?></td>
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
                      <div class="myinfo_btn1 myinfo_btn_l no_pointer" style="margin-top:20px;">
                        <span class="span_left">메일</span>
                        <span class="span_right">--</span>
                      </div>
                      <div class="myinfo_btn1 myinfo_btn_r" style="margin-top:20px;" onclick="location.href='<?php echo site_url(); ?>/biz/approval/electronic_approval_list?type=standby'">
                        <span class="span_left">결재</span>
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
                        <span class="span_left">일정</span>
                        <span class="span_right"><?php echo $schedule_count; ?></span>
                      </div>
                      <div class="myinfo_btn1 myinfo_btn_r no_pointer">
                        <span class="span_left">복지</span>
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
<!-- 근태관리 -->
<?php
$week = array("일", "월", "화", "수", "목", "금", "토");
if (!isset($day)){
  $day = date("Y-m-d");
}
$s = $week[date("w",strtotime($day))];
 ?>
      <div style="height:542px;">
        <table id="attendance" class="main_dash_tbl main_dash_tbl_1" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="dash_title_td"><div class="dash_title">근태관리</div></td>
            <td align="right" style="padding-right:10px;vertical-align:middle;">
              <div style="padding-top:15px;"><img src="<?php echo $misc;?>img/dashboard/dash_detail.svg" width="25" onclick="go_detail(this)" style="cursor:pointer;"/></div>
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
                  <td height="25" align="left" style="padding-left:2px;">출근시간</td>
                  <td align="right" id="work_on_time" style="padding-right:2px;"><?php
                    if (isset($attendance_today['ws_time'])&&$attendance_today['ws_time']!=""){
                      $date = new DateTime($attendance_today['ws_time']);
                      $ws_time = $date->format('H:i:s');
                      $designated_ws = $attendance_info['designate_ws'];
                      if(strtotime($ws_time)>strtotime($designated_ws)){
                        echo $ws_time." (지각)";
                      } else {
                        echo $ws_time;
                      }
                    } else {
                      echo "미등록";
                    }
                    ?></td>
                </tr>
                <tr>
                  <td height="25" align="left" style="padding-left:2px;">퇴근시간</td>
                  <td align="right" id="work_off_time" style="padding-right:2px;"><?php
                      if (isset($attendance_today['wc_time'])&&$attendance_today['wc_time']!=""){
                        $date = new DateTime($attendance_today['wc_time']);
                        echo $date->format('H:i:s');
                      } else {
                        echo "미등록";
                      }
                    ?>
                  </td>
                </tr>
                <tr>
                  <td height="25" align="left" style="padding-left:2px;">누적 근무시간</td>
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
                        echo $hours."시간 ".$min."분 ".$sec."초";
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
                        echo $hours."시간 ".$min."분 ".$sec."초";
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
                  <!-- <td align="left"><button class="attendance_btn" onclick="input_work('on');">출근하기</button></td>
                  <td align="right"><button class="attendance_btn" onclick="input_work('off');">퇴근하기</button></td> -->
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
                  <td colspan="2" align="center"><button class="attendance_btn2" disabled>근무상태변경</button></td>
                </tr> -->
                <tr>
                  <td height="10"></td>
                </tr>
              </table>
              <table class="content_dash attendance_tbl" align="center" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center">
                    <div class="attendance_btn_div work_day_div">
                      <span class="attendance_span span_left">소정근무일</span>
                      <span class="attendance_span span_right"><?php echo $work_day; ?></span>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td align="center">
                    <div class="attendance_btn_div real_work_div">
                      <span class="attendance_span span_left">실제근무일</span>
                      <span class="attendance_span span_right"><?php echo $real_work['cnt']; ?></span>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td align="center">
                    <div class="attendance_btn_div normal_work_div">
                      <span class="attendance_span span_left">정상처리</span>
                      <span class="attendance_span span_right"><?php echo $normal_work['cnt']; ?></span>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td align="center">
                    <div class="attendance_btn_div abnormal_work_div">
                      <span class="attendance_span span_left">미처리</span>
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

<!-- 메일 -->
    <div class="main_dash2">
      <div style="height:299px;">
        <table id="mail" class="main_dash_tbl main_dash_tbl_2" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="dash_title_td"><div class="dash_title">메일</div></td>
            <td align="right" style="padding-right:10px;vertical-align:middle;">
              <div style="padding-top:15px;"><img src="<?php echo $misc;?>img/dashboard/dash_detail.svg" width="25" onclick="go_detail(this)" style="cursor:pointer;"/></div>
            </td>
          </tr>
          <tr>
            <td height="16"></td>
          </tr>
          <tr>
            <td colspan="2" height="10" style="border-top: 1px solid rgba(0, 0, 0, 0.19);"></td>
          </tr>
          <tr>
            <td colspan="2" valign="top">
              <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">

              </table>
            </td>
          </tr>
          <tr>
            <td height="10"></td>
          </tr>
        </table>
      </div>
<!-- 결재 -->
      <div style="height:299px;">
        <table id="approval" class="main_dash_tbl main_dash_tbl_2" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="dash_title_td" style="padding-top:1px;"><div class="dash_title">결재</div></td>
            <td align="right" style="padding-right:10px;vertical-align:middle;">
              <div style="padding-top:15px;"><img src="<?php echo $misc;?>img/dashboard/dash_detail.svg" width="25" onclick="go_detail(this)" style="cursor:pointer;"/></div>
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
          </tr>
          <tr>
            <td height="10"></td>
          </tr>

          <!-- 결재대기함 -->
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
                      ?>
                      <tr align='center' onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style='cursor:pointer;' onclick="eletronic_approval_view('<?php echo $doc['seq']; ?>', 'standby')">
                       <td class="board_title" height="30" align="left" style="text-overflow:ellipsis; overflow:hidden;padding-left:18px;">
                         <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;"><?php
                         if($doc['approval_doc_hold'] == "N"){
                            echo $doc['approval_doc_name'];
                         }else{
                            echo $doc['approval_doc_name']." (보류)";
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
                        <td width="100%" height="80" align="center" colspan="9" class="no_list">등록된 게시물이 없습니다.</td>
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

          <!-- 결재진행함 -->
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
                      ?>
                      <tr align='center' onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style='cursor:pointer;' onclick="eletronic_approval_view('<?php echo $doc['seq']; ?>', 'progress')">
                       <td class="board_title" height="30" align="left" style="text-overflow:ellipsis; overflow:hidden;padding-left:18px;">
                         <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;"><?php
                         if($doc['approval_doc_hold'] == "N"){
                            echo $doc['approval_doc_name'];
                         }else{
                            echo $doc['approval_doc_name']." (보류)";
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
                        <td width="100%" height="80" align="center" colspan="9" class="no_list">등록된 게시물이 없습니다.</td>
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


          <!-- 완료문서함 -->
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
                      ?>
                      <tr align='center' onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style='cursor:pointer;' onclick="eletronic_approval_view('<?php echo $doc['seq']; ?>', 'completion')">
                       <td class="board_title" height="30" align="left" style="text-overflow:ellipsis; overflow:hidden;padding-left:18px;">
                         <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;"><?php
                         if($doc['approval_doc_hold'] == "N"){
                            echo $doc['approval_doc_name'];
                         }else{
                            echo $doc['approval_doc_name']." (보류)";
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
                        <td width="100%" height="80" align="center" colspan="9" class="no_list">등록된 게시물이 없습니다.</td>
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


          <!-- 반려문서함 -->
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
                      ?>
                      <tr align='center' onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style='cursor:pointer;' onclick="eletronic_approval_view('<?php echo $doc['seq']; ?>', 'back')">
                       <td class="board_title" height="30" align="left" style="text-overflow:ellipsis; overflow:hidden;padding-left:18px;">
                         <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;"><?php
                         if($doc['approval_doc_hold'] == "N"){
                            echo $doc['approval_doc_name'];
                         }else{
                            echo $doc['approval_doc_name']." (보류)";
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
                        <td width="100%" height="80" align="center" colspan="9" class="no_list">등록된 게시물이 없습니다.</td>
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
<!-- 공지사항 -->
      <div style="height:299px;">
        <table id="notice" class="main_dash_tbl main_dash_tbl_2" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="dash_title_td" style="padding-top:1px;"><div class="dash_title">공지사항</div></td>
            <td align="right" style="padding-right:10px;vertical-align:middle;">
              <div style="padding-top:15px;"><img src="<?php echo $misc;?>img/dashboard/dash_detail.svg" width="25" onclick="go_detail(this)" style="cursor:pointer;"/></div>
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

          <!-- 운영공지 -->
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
                        // if ($notice_list_count > 0) {
                        //   $i = $notice_list_count;
                        //   $icounter = 0;
                        //
                        //   foreach ( $notice_list as $item ) {
                      ?>
                      <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
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
                        <td width="100%" height="80" align="center" colspan="9" class="no_list">등록된 게시물이 없습니다.</td>
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

          <!-- 개발공지 -->
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
                      ?>
                      <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
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
                        <td width="100%" height="80" align="center" colspan="9" class="no_list">등록된 게시물이 없습니다.</td>
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

          <!-- 버전관리 -->
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
                      ?>
                      <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
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
                        <td width="100%" height="80" align="center" colspan="9" class="no_list">등록된 게시물이 없습니다.</td>
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

    <!-- 주간업무보고 -->
    <div class="main_dash3">
      <div style="height:420px;">
        <table id="tech_doc" class="main_dash_tbl" border="0" cellspacing="0" cellpadding="0">
          <tr valign="top">
            <td class="dash_title_td" style="padding-top:1px;"><div class="dash_title">주간업무보고</div></td>
            <!-- <td align="right" style="padding-right:10px; padding-top:10px"><img src="<?php echo $misc;?>img/dashboard/dash_detail.svg" width="25" onclick="go_detail(this)" style="cursor:pointer;"/></td> -->
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
              <table class="content_tbl" align="center" width="90%" border="0" cellspacing="0" cellpadding="0">
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
                      ?>
                <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" onclick="JavaScript:ViewWeekly('<?php echo $item['seq'];?>')" style="cursor:pointer;height:30px;">
                 <td class="board_title" align="left" height="30" style="text-overflow:ellipsis; overflow:hidden;">
                   <?php
                   	$tmp=explode(" ",$item['s_date']);
                   	$tmp2=explode("-",$tmp[0]);
                     echo $tmp2[0]."년 ".$item['month']."월 ".$item['week']."주차" ;
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
                  <td width="100%" height="80" align="center" colspan="9" class="no_list">등록된 게시물이 없습니다.</td>
                </tr>
  	<?php
  		}
  	?>
              </table>
            </td>
          </tr>
        </table>
      </div>
<!-- 주소록 -->
      <div style="height:493px">
        <table id="address" class="main_dash_tbl" border="0" cellspacing="0" cellpadding="0" style="display:inline-block;">
          <tr valign="top">
            <td class="dash_title_td" style="padding-top:1px;"><div class="dash_title">주소록</div></td>
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
              <div style="padding-top:15px;"><img src="<?php echo $misc;?>img/dashboard/dash_detail.svg" width="25" onclick="go_detail(this)" style="cursor:pointer;"/></div>
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
          for($i=0; $i < count($user_data); $i++){
            for($k=0; $k<count($user_data[$i]);$k=$k+3){
            ?>
          <tr>
            <td colspan="4" valign="top">
              <table id="tbl_dash_3-<?php echo $j+1; ?>" width="100%" style="<?php if($j>2){echo "display:none";} ?>">
                <tr>
                  <td colspan="2" valign="top">
                    <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                      <colgroup>
                        <col width="33%">
                        <col width="33%">
                        <col width="33%">
                      </colgroup>

                      <tr>
                        <td align="center" height="50"><img src="<?php echo $misc;?>img/dashboard/user.svg" width="40"/></td>
                        <?php if(isset($user_data[$i][$k+1])){ ?>
                        <td align="center"><img src="<?php echo $misc;?>img/dashboard/user.svg" width="40"/></td>
                      <?php } ?>
                      <?php if(isset($user_data[$i][$k+2])){ ?>
                        <td align="center"><img src="<?php echo $misc;?>img/dashboard/user.svg" width="40"/></td>
                      <?php } ?>
                      </tr>
                      <tr>
                        <td align="center" height="15" class="user_name"><?php echo $user_data[$i][$k]['user_name']." ".$user_data[$i][$k]['user_duty']; ?></td>
                        <?php if(isset($user_data[$i][$k+1])){ ?>
                        <td align="center" height="15" class="user_name"><?php echo $user_data[$i][$k+1]['user_name']." ".$user_data[$i][$k+1]['user_duty']; ?></td>
                        <?php } ?>
                        <?php if(isset($user_data[$i][$k+2])){ ?>
                        <td align="center" height="15" class="user_name"><?php echo $user_data[$i][$k+2]['user_name']." ".$user_data[$i][$k+2]['user_duty']; ?></td>
                        <?php } ?>
                      </tr>
                      <tr>
                        <td align="center" style="font-weight:bold;color:#3C3C3C;font-size:12px;font-weight:normal;"><?php echo $user_data[$i][$k]['user_group'] ?></td>
                        <?php if(isset($user_data[$i][$k+1])){ ?>
                        <td align="center" style="font-weight:bold;color:#3C3C3C;font-size:12px;font-weight:normal;"><?php echo $user_data[$i][$k+1]['user_group'] ?></td>
                      <?php } ?>
                      <?php if(isset($user_data[$i][$k+2])){ ?>
                        <td align="center" style="font-weight:bold;color:#3C3C3C;font-size:12px;font-weight:normal;"><?php echo $user_data[$i][$k+2]['user_group'] ?></td>
                        <?php } ?>
                      </tr>
                      <tr>
                        <td align="center" style="font-weight:bold;color:#3C3C3C;font-size:12px;font-weight:normal;" title="<?php echo $user_data[$i][$k]['user_tel'] ?>">
                          <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;">
                          <?php echo $user_data[$i][$k]['user_tel'] ?>
                          </div>
                        </td>
                        <?php if(isset($user_data[$i][$k+1])){ ?>
                        <td align="center" style="font-weight:bold;color:#3C3C3C;font-size:12px;font-weight:normal;" title="<?php echo $user_data[$i][$k+1]['user_tel'] ?>">
                          <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;">
                          <?php echo $user_data[$i][$k+1]['user_tel'] ?>
                          </div>
                        </td>
                      <?php } ?>
                      <?php if(isset($user_data[$i][$k+2])){ ?>
                        <td align="center" style="font-weight:bold;color:#3C3C3C;font-size:12px;font-weight:normal;" title="<?php echo $user_data[$i][$k+2]['user_tel'] ?>">
                          <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;">
                          <?php echo $user_data[$i][$k+2]['user_tel'] ?>
                          </div>
                        </td>
                        <?php } ?>
                      </tr>
                      <tr>
                        <td align="center" style="color:#B0B0B0;font-size:10px;text-overflow:ellipsis; overflow:hidden;" title="<?php echo $user_data[$i][$k]['user_email'] ?>">
                          <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;">
                          <?php echo $user_data[$i][$k]['user_email'] ?>
                          </div>
                        </td>
                        <?php if(isset($user_data[$i][$k+1])){ ?>
                        <td align="center" style="color:#B0B0B0;font-size:10px;text-overflow:ellipsis; overflow:hidden;" title="<?php echo $user_data[$i][$k+1]['user_email'] ?>">
                          <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;">
                          <?php echo $user_data[$i][$k+1]['user_email'] ?>
                          </div>
                        </td>
                      <?php } ?>
                      <?php if(isset($user_data[$i][$k+2])){ ?>
                        <td align="center" style="color:#B0B0B0;font-size:10px;text-overflow:ellipsis; overflow:hidden;" title="<?php echo $user_data[$i][$k+2]['user_email'] ?>">
                          <div style="overflow:hidden;text-overflow:ellipsis;;white-space:nowrap;">
                          <?php echo $user_data[$i][$k+2]['user_email'] ?>
                          </div>
                        </td>
                        <?php } ?>
                      </tr>

                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        <?php
        $j++;
            }
          }
          ?>


        </table>
      </div>
    </div>

<!-- 일정 -->
    <div class="main_dash3">
      <div style="height:450px;">
        <table id="schedule" class="main_dash_tbl dash_tbl_4" border="0" cellspacing="0" cellpadding="0">
          <tr valign="top">
            <td class="dash_title_td" style="padding-top:1px;"><div class="dash_title">일정</div></td>
            <td align="right" style="padding-right:10px;vertical-align:middle;">
              <div style="padding-top:15px;"><img src="<?php echo $misc;?>img/dashboard/dash_detail.svg" width="25" onclick="go_detail(this)" style="cursor:pointer;"/></div>
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
                  <td colspan="3" align="center">
                    <div id="calendar"></div>
                  </td>
                </tr>
                <tr>
                  <td colspan="3" height="10" style="border-top: 1px solid rgba(0, 0, 0, 0.19);"></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
<!-- 시설물예약 -->
      <div style="max-height:430px !important;">
        <table id="tech_support" class="main_dash_tbl dash_tbl_4" border="0" cellspacing="0" cellpadding="0">
          <tr valign="top">
            <td class="dash_title_td">
              <div class="dash_title" style="float:left;">시설물예약</div>
              <div style="float:right;margin-top:20px;margin-right:10px">
                <img src="<?php echo $misc; ?>/img/dashboard/btn/reservation_on.svg" onclick="rez_equipment();" width='100' style="cursor:pointer;">
                <!-- <img src="<?php echo $misc; ?>/img/dashboard/btn/reservation_off.svg" width='100'> -->
                <!-- <button type="button" class="rez_btn" onclick="rez_equipment();">예약하기</button> -->
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

    <!-- 기술부 미점검 모달 -->
    <?php if($parent_group == "기술본부"){ ?>
    <div id="modal" class="searchModal">
      <div class="search-modal-content">
        <!-- <button onClick="closeModal();" style="float:right;">닫기</button> -->

        <div class="row">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-12">
                <h2>정기점검 미완료</h2>
              </div>
              <div>
                <table  width="100%" border="1" cellspacing="0" cellpadding="0" style="font-weight:bold;font-size:13px;">
                    <tr width="100%" height=30>
                        <td align="center" width="10%" bgcolor="f8f8f9" >idx</td>
                        <td align="center" width="20%" bgcolor="f8f8f9" >고객사</td>
                        <td align="center" width="20%" bgcolor="f8f8f9" >프로젝트명</td>
                        <td align="center" width="10%" bgcolor="f8f8f9" >점검주기</td>
                        <td align="center" width="10%" bgcolor="f8f8f9" >마지막점검일</td>
                        <td align="center" width="10%" bgcolor="f8f8f9" >관리팀</td>
                        <td align="center" width="10%" bgcolor="f8f8f9" >점검자</td>
                        <td align="center" width="10%" bgcolor="f8f8f9" >코멘트</td>
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
                            echo "월점검";
                        }else if ($val['maintain_cycle'] == "3") {
                            echo "분기점검";
                        }else if ($val['maintain_cycle'] == "6") {
                            echo "반기점검";
                        }else if ($val['maintain_cycle'] == "0") {
                            echo "장애시";
                        }else if ($val['maintain_cycle'] == "7") {
                            echo "미점검";
                        }else{
                            echo "";
                        }
                        echo "</td>";
                        echo "<td {$font_color}>{$val['maintain_date']}</td>";
                        echo "<td>";
                        if ($val['manage_team'] == "1") {
                          echo "기술 1팀";
                        }else if ($val['manage_team'] == "2") {
                            echo "기술 2팀";
                        }else if ($val['manage_team'] == "3") {
                            echo "기술 3팀";
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
            <span class="pop_bt modalCloseBtn" style="font-size: 13pt;">닫기</span>
          </div>
      </div>
    </div>
    <?php } ?>
    <!-- 기술부 미점검 모달 끝 -->


  </div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
<?php if(isset($_GET['login'])){?>

  jQuery(document).ready(function () {
    $("#modal").show();
  });

  function closeModal() {
    $("#modal").hide();
  };
<?php } ?>
// + 버튼 눌렀을때 해당 페이지 이동
  function go_detail(el) {
    var page = $(el).closest('table').attr('id');
    if (page=="mail") {
      location.href = "http://mail.durianit.co.kr/";
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
    }
  }

// [전자결재] 종류 클릭시 내용 변경
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
  }

// [근태관리] 현재 시간 출력
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

// [근태관리] 누적 근무 시간 출력
  function work_time(){
    var work_time = $("#total_work_time").val();
    // console.log(work_time);
    work_time = work_time.split(":");
    var hour = work_time[0];
    var min = work_time[1];
    var sec = work_time[2];

    if($("#work_on_time").text().trim()!="미등록"&&$("#work_off_time").text().trim()=="미등록"){
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
      var total_work_time_text = hour+"시간 "+min+"분 "+sec+"초";
      $("#total_work_time_text").text(total_work_time_text);
    }
  }

// 현재 시간, 누적 근무 시간 갱신
  setInterval(clock, 1000);
  setInterval(work_time, 1000);

  // alert($("#work_off_time").text());

// [일정] 달력 출력
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
      days: ['일','월','화','수','목','금','토']
    });

    // var today = new Date();

    // [시설물 예약] 오늘 날짜 출력
    $("#rez_date").text(getToday());
  });

  var first_address=1;
  var last_address=3;
// [주소록] < 버튼 클릭 시
  function prev_address() {
    if(first_address<=1) {
      // alert('첫번째');
    } else {
      $("#tbl_dash_3-"+(first_address)+"").hide();
      $("#tbl_dash_3-"+(first_address+1)+"").hide();
      $("#tbl_dash_3-"+(first_address+2)+"").hide();
      $("#tbl_dash_3-"+(first_address-1)+"").show();
      $("#tbl_dash_3-"+(first_address-2)+"").show();
      $("#tbl_dash_3-"+(first_address-3)+"").show();
      first_address -= 3;
      last_address -= 3;
    }
  }
// [주소록] > 버튼 클릭 시
  function next_address() {
    var address_count = "<?php echo $user_data_count/3; ?>";
    if(last_address>=address_count) {
      // alert('마지막');
    } else {
      $("#tbl_dash_3-"+last_address+"").hide();
      $("#tbl_dash_3-"+(last_address-1)+"").hide();
      $("#tbl_dash_3-"+(last_address-2)+"").hide();
      $("#tbl_dash_3-"+(last_address+1)+"").show();
      $("#tbl_dash_3-"+(last_address+2)+"").show();
      $("#tbl_dash_3-"+(last_address+3)+"").show();
      first_address += 3;
      last_address += 3;
    }
  }

// 공지사항 게시물로 이동
  function ViewBoard(seq,category_code) {
    if(category_code == "004"){
      window.location = "<?php echo site_url(); ?>/biz/board/lab_notice_view?dash=Y&category="+category_code+"&mode=view&seq="+seq;
    }else{

      window.location = "<?php echo site_url(); ?>/biz/board/notice_view?dash=Y&category="+category_code+"&mode=view&seq="+seq;
    }
  }
// 주간업무 게시물로 이동
  function ViewWeekly (seq){
    window.location = "<?php echo site_url();?>/biz/weekly_report/weekly_report_view?dash=Y&mode=view&seq="+seq;
  }
// 전자결재 게시물로 이동
  function eletronic_approval_view(seq, page) {
    window.location = "<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_view?seq="+seq+"&type="+page;
  }

// 날짜 +- 함수
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

// [시설물 예약] < > 버튼 클릭 시
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

// 시설물 예약 - 예약하기 버튼 클릭 시
  function rez_equipment() {
    var rez_date = $("#rez_date").text();
    sessionStorage.setItem("dash_rez_date", rez_date);
    window.location = "<?php echo site_url(); ?>/biz/schedule/tech_schedule";
  }

//출근하기 퇴근하기
  function input_work(status) {
    if (status=="on") {
      if ($("#work_on_time").text().trim()!="미등록") {
        alert("이미 출근 기록이 있습니다.");
        return false;
      } else {
        var ws_time = getTimeStamp();
        var wc_time = '';
      }
    } else {
      if ($("#work_on_time").text().trim()=="미등록") {
        alert("출근 기록이 없습니다.");
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
          alert("정상 출근하였습니다.");
          location.reload();
        } else {
          alert("정상 퇴근하였습니다.");
          location.reload();
        }
      } else if (response=="nocard"){
        alert('카드가 등록되지 않았습니다.');
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

</script>
</html>
