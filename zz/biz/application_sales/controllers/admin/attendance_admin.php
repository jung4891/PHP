<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Attendance_admin extends CI_Controller {

   var $id = '';

   function __construct() {
      parent::__construct();
      $this->id = $this->phpsession->get( 'id', 'stc' );
      $this->name = $this->phpsession->get( 'name', 'stc' );
      $this->lv = $this->phpsession->get( 'lv', 'stc' );

      $this->load->Model(array('STC_Common', 'admin/STC_Attendance_admin'));
   }

   function attendance_user_list() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      if(isset($_GET['cur_page'])) {
         $cur_page = $_GET['cur_page'];
      }
      else {
         $cur_page = 0;
      }                                          //   현재 페이지
      $no_page_list = 10;                              //   한페이지에 나타나는 목록 개수

      $search_keyword = "";
      $search1 = "";
      $search2 = "";

      if  ( $cur_page <= 0 )
         $cur_page = 1;

      $data['cur_page'] = $cur_page;

      $user_list_data = $this->STC_Attendance_admin->attendance_user_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
      $data['count'] = $this->STC_Attendance_admin->attendance_user_list_count($search_keyword, $search1, $search2)->ucount;

      $data['list_val'] = $user_list_data['data'];
      $data['list_val_count'] = $user_list_data['count'];

      $total_page = 1;
      if  ( $data['count'] % $no_page_list == 0 )
         $total_page = floor( ( $data['count'] / $no_page_list ) );
      else
         $total_page = floor( ( $data['count'] / $no_page_list + 1 ) );         //   전체 페이지 개수

      $start_page =  floor(($cur_page - 1 ) / 10) * 10  + 1 ;
      $end_page = 0;
      if  ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) )
         $end_page = ( floor( ( $cur_page - 1 ) / 10 ) + 1 ) * 10;
      else
         $end_page = $total_page;

      $data['no_page_list'] = $no_page_list;
      $data['total_page'] = $total_page;
      $data['start_page'] = $start_page;
      $data['end_page'] = $end_page;



      $this->load->view('admin/attendance_user_list', $data );
   }

   function attendance_list() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      if(isset($_GET['cur_page'])) {
         $cur_page = $_GET['cur_page'];
      }
      else {
         $cur_page = 0;
      }                                          //   현재 페이지
      $no_page_list = (int)$this->STC_Attendance_admin->user_count()->ucount;                              //   한페이지에 나타나는 목록 개수

      if(isset($_GET['searchkeyword'])) {
  			$search_keyword = $_GET['searchkeyword'];
  		}
  		else {
  			$search_keyword = "";
  		}

      $data['search_keyword'] = $search_keyword;

      if  ( $cur_page <= 0 )
         $cur_page = 1;

      $data['cur_page'] = $cur_page;

      $user_list_data = $this->STC_Attendance_admin->attendance_list($search_keyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
      $data['count'] = $this->STC_Attendance_admin->attendance_list_count($search_keyword)->ucount;

      $data['list_val'] = $user_list_data['data'];
      $data['list_val_count'] = $user_list_data['count'];

      $total_page = 1;
      if  ( $data['count'] % $no_page_list == 0 )
         $total_page = floor( ( $data['count'] / $no_page_list ) );
      else
         $total_page = floor( ( $data['count'] / $no_page_list + 1 ) );         //   전체 페이지 개수

      $start_page =  floor(($cur_page - 1 ) / 10) * 10  + 1 ;
      $end_page = 0;
      if  ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) )
         $end_page = ( floor( ( $cur_page - 1 ) / 10 ) + 1 ) * 10;
      else
         $end_page = $total_page;

      $data['no_page_list'] = $no_page_list;
      $data['total_page'] = $total_page;
      $data['start_page'] = $start_page;
      $data['end_page'] = $end_page;



      $this->load->view('admin/attendance_list', $data );
   }

   function attendance_input_action() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      // $this->load->Model( 'STC_Equipment' );
      $user_seq = $this->input->post('user_seq');
      $card_num = $this->input->post('card_num');
      $ws_time = $this->input->post('ws_time');
      $wc_time = $this->input->post('wc_time');

      $data = array(
         'user_seq' => $user_seq,
         'card_num' => $card_num,
         'ws_time' => $ws_time,
         'wc_time' => $wc_time,
         'insert_date' => date("Y-m-d H:i:s")
      );

     $count = $this->STC_Attendance_admin->attendance_user_count($user_seq)->ucount;

      if ($count == 0) {
         $result = $this->STC_Attendance_admin->attendance_user_insert($data, $mode = 0);
      } else {
         $result = $this->STC_Attendance_admin->attendance_user_insert($data, $mode = 1, $user_seq);
      }

      //지정 출퇴근시간 오늘꺼 attendance_manual 에서 찾아서 수정해드려
      $data=array(
         'card_num' =>$card_num,
         'official_ws_time' => $ws_time,
         'official_wc_time' => $wc_time
      );
      $result = $this->STC_Attendance_admin->attendance_individual(2,$data);



      if($result) {
         echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/admin/attendance_admin/attendance_user_list'</script>";
      } else {
         echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
      }

   }

   function attendance_user_info(){
     $seq = $this->input->post('seq');

     $result = $this->STC_Attendance_admin->attendance_user_info($seq);

     echo json_encode($result);
   }

   function attendance_card_info(){
     $name = $this->input->post('name');

     $result = $this->STC_Attendance_admin->attendance_card_info($name);

     echo json_encode($result);
   }

   //근태관리 수정!
   function attendance_individual(){
      $type = $this->input->post('type');
	   $seq = $this->input->post('seq');

      if($type ==0){//select
         $result = $this->STC_Attendance_admin->attendance_individual($type,$seq);
      }else if ($type ==1){//update
         $date = $this->input->post('date');
         $wstime = $this->input->post('wstime');
         $wctime = $this->input->post('wctime');

         if($wstime != ""){
               $wstime = explode(':',$wstime);
               $wstime = $date.(str_pad($wstime[0],2,"0",STR_PAD_LEFT)).$wstime[1]."00";
         }else{
            $wstime =null;
         }

         if($wctime != ""){
               $wctime = explode(':',$wctime);
               $wctime = $date.(str_pad($wctime[0],2,"0",STR_PAD_LEFT)).$wctime[1]."00";
         }else{
            $wctime =null;
         }

         $data=array(
            'seq' => $this->input->post('seq'),
            'ws_time' => $wstime,
            'wc_time' => $wctime,
            'status' => $this->input->post('status'),
            'update_time' => date("Y-m-d H:i:s"),
            'write_id' => 'admin'
         );
         $result = $this->STC_Attendance_admin->attendance_individual($type,$data);
      }
      echo json_encode($result);
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

       if (isset($_GET['search_group'])) {
         $search_group = $this->input->get('search_group');
       } else {
         $search_group = '';
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

  if($search_group == ''){
    $user_work = $this->STC_Attendance_admin->working_hours_biz($sdate,$edate,$search_group);
    $tech_work = $this->STC_Attendance_admin->working_hours_tech($sdate,$edate);
  }elseif($search_group =='기술본부'){
    $tech_work = $this->STC_Attendance_admin->working_hours_tech($sdate,$edate);
  }else{
    $user_work = $this->STC_Attendance_admin->working_hours_biz($sdate,$edate,$search_group);
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


  $data["pgroup_name"] = $this->STC_Attendance_admin->get_pgroup();
  $data["work_data"] = $work_data;

  $this->load->view('/admin/attendance_working_hours', $data);

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

}
?>
