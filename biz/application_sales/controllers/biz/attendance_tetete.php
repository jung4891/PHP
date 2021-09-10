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

    $this->load->Model(array('STC_Common', 'biz/STC_Attendance'));
  }

  function attendance_user() {
    if ( $this->id === null ) {
      redirect( 'account' );
    }

    $this->load->view('biz/attendance_user');
  }

  function attnedance_user_val() {
    $result = $this->STC_Attendance->attendance_user();
    echo json_encode($result);
  }

  function attendance_statistics() {
    $data['attendance_info'] = $this->STC_Attendance->attendance_info();
    $card_num = $data['attendance_info']['card_num'];

    if( $card_num == false ) {
      echo "<script>alert('근퇴설정이 되지 않았습니다.');window.history.back();</script>";
    }

    if( isset($_GET['search_month']) ) {
      $date = date($_GET['search_month'].'-01');
      $today = explode(' ~ ', $_GET['search_week']);
      $today = date($today[1]);
    } else {
      $date = date('Y-m-01');
      $today = date('Y-m-d');
    }

    $data['week_array'] = $this->get_find_weeks_in_month($date);

    if( $data['week_array'][0]['start'] > $today ) {
      $date = date('Y-m-01', strtotime('-1 month', time()));
    }
    $data['week_array'] = $this->get_find_weeks_in_month($data);

    foreach( $data['week_array'] as $wq ) {
      if( ( $today >= $wa['start'] ) && ( $today <= $wa['end'] ) ){
        $date_1 = $wa['start'];
        $date_2 = $today;
      }
    }

    $d1_strtotime = strtotime($date_1);
    $d2_strtotime = strtotime($date_2);

    $data['work_count'] = 0;
    $off_day = 0;
    $off_harf_day = 0;
    $deducted = 0;
    $overtime = 0;

    $d1_strtotime = strtotime('-1 day', $d1_strtotime);
    $holiday_arr = array('연차', '오전반차', '보건휴가', '출산휴가', '특별유급휴가', '공가');
  }
}

 ?>
