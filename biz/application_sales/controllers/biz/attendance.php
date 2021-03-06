<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Attendance extends CI_Controller {

  var $id = '';

  function __construct() {
    parent::__construct();
    $this->id = $this->phpsession->get( 'id', 'stc' );
    $this->name = $this->phpsession->get( 'name', 'stc' );
    $this->lv = $this->phpsession->get( 'lv', 'stc' );
    $this->pGroupName = $this->phpsession->get( 'pGroupName', 'stc' );
    $this->group = $this->phpsession->get( 'group', 'stc' );
    $this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );

    if($this->cooperation_yn == 'Y') {
      echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    }

    $this->load->library('user_agent');

    $this->load->Model(array('STC_Common', 'biz/STC_Attendance'));
  }

  function attendance_user() {
    if( $this->id === null ) {
      redirect( 'account' );
    }

    if($this->agent->is_mobile()) {
      $t_month = date('Ym');
      if ($this->input->get('month')) {
        $t_month = $this->input->get('month');
        $t_month = str_replace('-', '', $t_month);
      }

      $data['list_val'] = $this->STC_Attendance->attendance_user_mobile($t_month);

      $data['title'] = '근태관리';
      $this->load->view('biz/attendance_user_mobile', $data);
    } else {
      $this->load->view('biz/attendance_user');
    }
  }

  function attendance_user_val(){
    $result = $this->STC_Attendance->attendance_user();
    echo json_encode($result);
  }

  function attendance_statistics() {
    $data['attendance_info'] = $this->STC_Attendance->attendance_info(); // 근태 정보
    $card_num = $data['attendance_info']['card_num']; // 카드번호

    if ($card_num==false){ // 카드번호 지정 되어 있지 않으면
      echo "<script>alert('근퇴설정이 되지 않았습니다.');window.history.back();</script>";
    }

    if (isset($_GET['search_month'])) {
      $date = date($_GET['search_month']."-01");
      $today = explode(' ~ ', $_GET['search_week']);
      $today = date($today[1]);
    } else {
      $date = date('Y-m-01'); // 이번달의 1일
      $today = date('Y-m-d'); // 오늘 날짜
    }

    $data['week_array'] = $this->get_find_weeks_in_month($date); // 이번달 주차 가져오기
    // var_dump($data['week_array']);

    if ($data['week_array'][0]['start']> $today) {
      $date = date('Y-m-01', strtotime("-1 month", time()));
    }
    $data['week_array'] = $this->get_find_weeks_in_month($date);

    foreach ($data['week_array'] as $wa) {
      if(($today>=$wa['start'])&&($today<=$wa['end'])){ // 오늘이 주차에 포함되면
        $date_1 = $wa['start']; // $date_1 해당 주차의 시작일
        $date_2 = $today; // $date_2 오늘
      }
    }
    // $date_1 = date('Y-m-01');
    $d1_strtotime = strtotime($date_1);
    $d2_strtotime = strtotime($date_2);

    $data['work_count'] = 0; // 출근 한 날짜
    $off_day = 0; // 휴가 날짜
    $off_harf_day = 0; // 반차 날짜
    $deducted = 0; // 차감 시간
    $overtime = 0; // 소정외근로시간

    $d1_strtotime = strtotime("-1 day",$d1_strtotime); // 시작일 하루 빼주고 (while 돌리기 위해)
    $holiday_arr = array('연차','오전반차','오후반차','보건휴가','출산휴가','특별유급휴가','공가');

    while($d1_strtotime != $d2_strtotime) { // 반복문 돌려돌려 돌림
      $d1_strtotime = strtotime("+1 day",$d1_strtotime); // 시작일 바로 +1일 해주고 (시작일이 오늘이면 한번만 돈다!)
      $target_day = date("Ymd",$d1_strtotime); // target_day
      $a_data = $this->STC_Attendance->attendance_data($target_day,$card_num);

      if ($a_data){ // 데이터가 있으면!
        $designated_ws = str_replace(":","",$a_data['official_ws_time']); // 출근 지정 시간
        $designated_wc = str_replace(":","",$a_data['official_wc_time']); // 퇴근 지정 시간

        if(in_array($a_data['status'],$holiday_arr)==false){ // 휴일이 아닐때 !!!!
          if(($a_data['ws_time']!='' or $a_data['wc_time']!='') && $a_data['date_type']!='h'){ // 출근이 있고 휴일이 아니면
              $data['work_count'] ++; // 출근일 +
          }
          if($a_data['ws_time']!='' && strtotime($a_data['ws_time'])>strtotime($target_day.$designated_ws) && $a_data['date_type']!='h'){ // 지각! 차감근로시간 ++
            $ws_time = date($a_data['ws_time']);
            $d_ws = date($target_day.$designated_ws);
            $time_diff = strtotime($ws_time) - strtotime($d_ws);
            $deducted += $time_diff;
          }
          if($a_data['wc_time']!='' && strtotime($a_data['wc_time'])<strtotime($target_day.$designated_wc) && $a_data['date_type']!='h'){ // 일퇴! 차감근로시간 ++
            $wc_time = date($a_data['wc_time']);
            $d_wc = date($target_day.$designated_wc);
            $time_diff = strtotime($d_wc) - strtotime($wc_time);
            $deducted += $time_diff;
          }
          if($a_data['wc_time']!='' && strtotime($a_data['wc_time'])>strtotime($target_day.$designated_wc) && $a_data['date_type']!='h'){ // 늦퇴! 소정외근로시간 ++
            $wc_time = date($a_data['wc_time']);
            $o_wc = date($target_day.$designated_wc);
            $time_diff = strtotime($wc_time) - strtotime($o_wc);
            // echo "늦퇴 : ".$wc_time." diff : ".$time_diff."<br>";
            $overtime += $time_diff;
          }
          if($a_data['date_type']=='h') { // 휴일근무... 소정외근로시간 ++
            $wc_time = date($a_data['wc_time']);
            $ws_time = date($a_data['ws_time']);
            $time_diff = strtotime($wc_time) - strtotime($ws_time);
            // echo "휴일 근무 : ".$ws_time.", ".$wc_time." diff : ".$time_diff."<br>";
            $overtime += $time_diff;
          }
        } else { // 휴일일때!!!
          if (strpos($a_data['status'],'반차') !== false){ // 반차일때
            if ($a_data['status'] == '오전반차') {
              $harf_designated_ws = $designated_ws + 50000;
              $harf_designated_wc = $designated_wc;
            } else {
              $harf_designated_ws = $designated_ws;
              $harf_designated_wc = $designated_wc - 50000;
            }
            if ($a_data['ws_time']!='' && strtotime($a_data['ws_time'])>strtotime($target_day.$harf_designated_ws)){
              $ws_time = date($a_data['ws_time']);
              $d_ws = date($target_day.$harf_designated_ws);
              $time_diff = strtotime($ws_time) - strtotime($d_ws);
              $deducted += $time_diff;
            }
            if ($a_data['wc_time']!='' && strtotime($a_data['wc_time'])<strtotime($target_day.$harf_designated_wc)){
              $wc_time = date($a_data['wc_time']);
              $d_wc = date($target_day.$harf_designated_wc);
              $time_diff = strtotime($d_wc) - strtotime($wc_time);
              $deducted += $time_diff;
            }
            if ($a_data['ws_time'] == '' && $a_data['wc_time'] == ''){ // 반차인데 출퇴근 시간 없으면 4시간만 ++
              $off_harf_day ++;
            }
            if ($a_data['ws_time'] != '' || $a_data['wc_time'] != ''){
              $off_day ++; // 출근이나 퇴근 시간 있으면 8 ++
            }
          } else { // 반차가 아닌 휴일일때
            $off_day ++; // 반차가 아닌 휴일은 8시간 ++
          }
        }
      }

    }

    $work_on_time = 8 * $data['work_count']; // 근무일수 X 8
    $work_on_time += 8 * $off_day; // 휴일 * 8시간
    $work_on_time += 4 * $off_harf_day; // 반차 * 4시간
    $work_on_time = strtotime("+".$work_on_time." hours", (int)"00:00:00"); // 소정근로시간(누적)
    $residue_work_on_time = 8 * 5;
    $residue_work_on_time = strtotime("+".$residue_work_on_time." hours", (int)"00:00:00"); // 최대 소정근로시간
    $residue_overtime = strtotime("+12 hours", (int)"00:00:00"); // 최대 소정외근로시간
    // echo date($residue_work_on_time);
    // echo $residue_work_on_time."<br>";
    // echo $work_on_time;
    $usergroup = $this->STC_Attendance->user_group();
    $data['user_group'] = $usergroup['user_group'];
    $data['work_on_time'] =  $this->timetostr($work_on_time); // 소정근로시간 (누적)
    $data['overtime'] = $this->timetostr($overtime); // 소정외근로시간 (누적)
    $data['deducted'] = $this->timetostr($deducted); // 차감근로시간 (누적)
    $data['total_work_time'] = $this->timetostr($work_on_time+$overtime-$deducted); // 총근로시간
    if ($residue_work_on_time-$work_on_time+$deducted < 0){
      $data['residue_work_on_time'] = $this->timetostr($work_on_time+$deducted-$residue_work_on_time,"-");
    } else {
      $data['residue_work_on_time'] = $this->timetostr($residue_work_on_time-$work_on_time+$deducted,'residue_w'); // 소정근로시간 (잔여) -> 최대소정근로시간 - 소정근로시간(누적) + 차감근로시간 (누적)
    }
    if ($residue_overtime-$overtime < 0) {
      $data['residue_overtime'] = $this->timetostr($overtime-$residue_overtime,"-");
    } else {
      $data['residue_overtime'] = $this->timetostr($residue_overtime-$overtime,'residue_o'); // 소정외근로시간 (잔여) -> 최대 소정외근로시간 - 소정외근로시간(누적)
    }

     $this->load->view('/biz/attendance_statistics', $data);
  }


  function attendance_working_hours() {

      if (isset($_GET['search_month'])) {
        $date = date($_GET['search_month']."-01");
        $today = explode(' ~ ', $_GET['search_week']);
        $sdate = date($today[0]);
        $edate = date($today[1]);
      } else {
        $date = date('Y-m-01'); // 이번달의 1일
        $today = date('Y-m-d'); // 오늘 날짜
      }

      $data['week_array'] = $this->get_find_weeks_in_month($date); // 이번달 주차 가져오기
      // var_dump($data['week_array']);

      if ($data['week_array'][0]['start']> $today) {
        $date = date('Y-m-01', strtotime("-1 month", time()));
      }


      $data['week_array'] = $this->get_find_weeks_in_month($date); // 이번달 주차 가져오기
      foreach ($data['week_array'] as $wa) {
        if(($today>=$wa['start'])&&($today<=$wa['end'])){ // 오늘이 주차에 포함되면
          $sdate = $wa['start']; // $date_1 해당 주차의 시작일
          $edate = $today; // $date_2 오늘
        }
      }
 $work_data = array();

 if($this->pGroupName = '기술본부' && $this->group != '기술연구소'){
   $tech_work = $this->STC_Attendance->working_hours_tech($sdate,$edate);
 }else{
   $user_work = $this->STC_Attendance->working_hours_biz($sdate,$edate);
 }


 if(isset($user_work)){

   if($user_work){
     foreach ($user_work as $uw) {

       $percent = $this->get_percent($uw['t_time']);
       $percent = explode(',', $percent);
           $wdata = array(
             'u_seq' => $uw['u_seq'],
             'card_num' => $uw['card_num'],
             'user_name' => $uw['user_name'],
             'user_duty' => $uw['user_duty'],
             'pgroup'    => $uw['pgroup'],
             'work_hour' => $this->gettime_string($uw['w_time']),
             'over_time' => $this->gettime_string($uw['over_time']),
             'total_time' => $this->gettime_string($uw['t_time']),
             // 'minus_time' => $this->gettime_string($tw['minus_time']),
             'rest_worktime' => $this->gettime_string($uw['rest_wtime']),
             'rest_overtime' => $this->gettime_string($uw['rest_overtime']),
             'work_per' => $percent[0],
             'over_per' => $percent[1]
           );
           array_push($work_data, $wdata);
     }
   }
 }

 if(isset($tech_work)){

   if($tech_work){
     foreach ($tech_work as $tw) {
       $percent = $this->get_percent($tw['t_time']);
       $percent = explode(',', $percent);
       $wdata = array(
         'u_seq' => $tw['u_seq'],
         'card_num' => $tw['card_num'],
         'user_name' => $tw['user_name'],
         'pgroup'    => $tw['pgroup'],
         'work_hour' => $this->gettime_string($tw['w_time']),
         'over_time' => $this->gettime_string($tw['over_time']),
         'total_time' => $this->gettime_string($tw['t_time']),
         // 'minus_time' => $this->gettime_string($tw['minus_time']),
         'rest_worktime' => $this->gettime_string($tw['rest_wtime']),
         'rest_overtime' => $this->gettime_string($tw['rest_overtie']),
         'work_per' => $percent[0],
         'over_per' => $percent[1]
       );
       array_push($work_data, $wdata);
     }
   }
 }


 $data["pgroup_name"] = $this->STC_Attendance->get_pgroup();
 $data["work_data"] = $work_data;

    if($this->agent->is_mobile()) {
      $data['title'] = '근태관리';
      $this->load->view('/biz/attendance_working_hours_mobile', $data);
    } else {
      $this->load->view('/biz/attendance_working_hours', $data);
    }

    }

  function gettime_string($time){
    if($time == null){
      $time = "00:00:00";
    }
    $target = explode(':', $time);
    return $target[0].'시간 '.$target[1].'분';
  }

  // 'HH:mm:ss' 형태의 시간을 초로 환산
  function get_seconds($hms){

      $tmp = explode(':', $hms);
      $std = mktime(0,0,0,date('n'),date('j'),date('Y'));
      $scd = mktime(intval($tmp[0]), intval($tmp[1]), intval($tmp[2]));

      return intval($scd-$std);

  }

  // 초를 'HH:mm:ss' 형태로 환산
  function seconds_totime($seconds){
      $h = sprintf("%02d", intval($seconds) / 3600);
      $tmp = $seconds % 3600;
      $m = sprintf("%02d", $tmp / 60);
      $s = sprintf("%02d", $tmp % 60);

      return $h.'시간'.$m.'분';
  }

  function get_percent($time){
    $target = $this->get_seconds($time);
    $standard = $this->get_seconds('40:00:00');
    if($standard >= $target){
      $result = (int)$target/(int)$standard*100;
      $result = round($result);
      return $result.',0';
    }else{
      $target = $target - $standard;
      $standard = $this->get_seconds('12:00:00');
      $result = (int)$target/(int)$standard*100;
      $result = round($result);
      return '100,'.$result;
    }
  }


  function get_week_array() {
    $target = $this->input->post("target_month");
    $target = explode("-",$target);
    $year = $target[0];
    $month = $target[1];

    $date = date($year.$month.'01');

    $result = $this->get_find_weeks_in_month($date);

    echo json_encode($result);
  }

  function get_find_weeks_in_month($date) {// date format => Y-m-d  특정 month에 week 구하기
    $day = date('w', strtotime($date) );//xxxx년 xx월 1일에 대한 요일구함
    if( $day != 1 )//월요일이 아니면
    $date = date('Y-m-d', strtotime("next monday", strtotime($date)));// xxx년 xx월에 첫번째 월요일 구함.

    $start_week = date( "W", strtotime($date) ); //첫번쨰 월요일이 몇번쨰 주인지.
    $year = date( "Y", strtotime( $date ) ); //년도
    $temp_week = date( "Y-m-t", strtotime($date) ); //xxxx년 xx월 마지막 날짜 구하고
    $last_week = date("W", strtotime($temp_week)); // xxxx년 xx월 마지막 날짜가 년도기준 몇번째 주인지.

    $result = array();
    for( $i=$start_week; $i<=$last_week; $i++ ) {
      $data = $this->get_week($i,$year);
      $result[] = $data;
    }
    return $result;
  }

  function get_week( $week, $year ) { // week => xxxx년 기준 주차 year => xxxx
    $date_time = new DateTime();
    $result['start'] = $date_time->setISODate($year, $week, 1)->format('Y-m-d');//월요일
    $result['end'] = $date_time->setISODate($year, $week, 7)->format('Y-m-d');//일요일

    return $result;
  }

  // strtotime 을 경과시간으로 표시
  function timetostr ($strtotime, $mode="") {
    $d_days = floor($strtotime/86400);
    $d_time = $strtotime - ($d_days*86400);
    $d_hours = floor($d_time/3600);
    $d_time = $d_time - ($d_hours*3600);
    $d_min = floor($d_time/60);
    $hours = $d_hours+($d_days*24);

    if($mode == '-'){
      $hours = "-".$hours;
    }

    if ($mode == "residue_w" && $hours >= 40){
      return "40시간 0분";
    }
    if ($mode == "residue_o" && $hours >= 12){
      return "12시간 0분";
    }

    return $hours."시간 ".$d_min."분";
  }

  //휴가 사용 현황
  function annual_usage_status() {
    if( $this->id === null ) {
        redirect( 'account' );
    }
    $data['view_val'] = $this->STC_Attendance->annual_usage_status();
    $data['annual_status'] = $this->STC_Attendance->annual_management();

    if($this->agent->is_mobile()) {
      $data['title'] = '근태관리';
      $this->load->view('biz/annual_usage_status_mobile', $data);
    } else {
      $this->load->view('biz/annual_usage_status', $data );
    }
  }

  //휴가 사용 내역
  function annual_usage_status_list() {
    if( $this->id === null ) {
       redirect( 'account' );
    }

    //필터
    if(isset($_GET['searchkeyword'])) {
       $search_keyword = $_GET['searchkeyword'];
    }
    else {
       $search_keyword = "";
    }
    $data['search_keyword'] = $search_keyword;

    $data['view_val'] = $this->STC_Attendance->annual_usage_status_list($search_keyword);
    if($this->agent->is_mobile()) {
      $data['title'] = '근태관리';
      $this->load->view('biz/annual_usage_status_list_mobile', $data );
    } else {
      $this->load->view('biz/annual_usage_status_list', $data );
    }
 }

 // 모바일 달력 선택 해당일 연차 사용 내역
 function annual_usage_status_day() {
   $date = $this->input->post('date');

   $result = $this->STC_Attendance->annual_usage_status_day($date);

   echo json_encode($result);
 }

}
?>
