<?php

class Schedule extends CI_Controller {

  function __construct(){
    parent::__construct();

    $this->id = $this->phpsession->get( 'id', 'stc' );
    $this->name = $this->phpsession->get( 'name', 'stc' );
    $this->lv = $this->phpsession->get( 'lv', 'stc' );
    $this->cnum = $this->phpsession->get( 'cnum', 'stc' );
    $this->group = $this->phpsession->get( 'group', 'stc' );
    $this->pGroupName = $this->phpsession->get( 'pGroupName', 'stc' );
    $this->company = $this->phpsession->get( 'company', 'stc' );
    $this->seq = $this->phpsession->get( 'seq', 'stc' );
    $this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );

    if($this->cooperation_yn == 'Y') {
      echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    }
    $this->load->database();
    ob_start();
    $config['url_suffix'] = 'html';
    // // $this->load->Model('stc_schedule');
    $this->load->Model(array('tech/STC_User', 'STC_Common', 'biz/STC_Schedule', 'tech/STC_Tech_doc'));
    $this->load->helper('url');
    $this->load->library('user_agent');
  }

  function tech_schedule_mobile() {
    if( $this->id === null ) {
      redirect( 'account' );
    }

    if (isset($_GET['month'])) {
      $mode = 'month';
      $date = $_GET['month'];
    } else {
      $mode = 'day';
      if (isset($_GET['date'])) {
        $date = $_GET['date'];
      } else {
        $date = date('Y-m-d');
      }
    }

    if (isset($_GET['selUser'])) {
      $selUser = $_GET['selUser'];
    } else {
      $selUser = $this->seq;
    }

    if ($selUser != '') {
      $data['sel_user'] = $selUser;
    } else {
      $data['sel_user'] = $this->seq;
    }

    $data['session_id']      = $this->id;
    $data['session_name']    = $this->name;

    $data['schedule'] = $this->STC_Schedule->schedule_mobile($selUser); // 달력 보이는 일정 (전체 일정 날짜 X)
    $data['schedule_list'] = $this->STC_Schedule->schedule_list_mobile($selUser, $date, $mode); // 달력 하단에 일정 리스트

    // 참석자
    $data['depth1_user'] = $this->STC_Schedule->depth1_user_mobile();
    $data['depth2_user'] = $this->STC_Schedule->depth2_user_mobile();
    $data['user_parents_group'] = $this->STC_Schedule->user_parents_group_mobile();
    $data['user_group'] = $this->STC_Schedule->user_group_mobile();

    //유지보수에서
    $data['customer'] = $this->STC_Schedule->get_customer3();
    $data['search_customer'] = $this->STC_Schedule->ser_customer();
    //포캐스팅에서
    $data['customer2'] = $this->STC_Schedule->get_customer2();

    $data['rooms']           = $this->STC_Schedule->rooms();
    $data['cars']            = $this->STC_Schedule->cars();

    $data['work_name']       = $this->STC_Schedule->group_list();

    $data['title'] = '일정관리';

    $this->load->view('biz/tech_schedule_mobile', $data);
  }

  function schedule_list_mobile() {
    $date = $this->input->post('date');
    if (isset($_POST['selUser'])) {
      $selUser = $_POST['selUser'];
    } else {
      $selUser = $this->seq;
    }

    $result = $this->STC_Schedule->schedule_list_mobile($selUser,$date);

    echo json_encode($result);
  }

  //일정 페이지 메인화면 출력
  function tech_schedule(){
    // $this->output->enable_profiler(TRUE);
    if( $this->id === null ) {
      redirect( 'account' );
    }
    $pGroupName =  $this->pGroupName;
    $group = $this->group;
    //패치 전 수정
  //       if($pGroupName != 'CEO' && $pGroupName != '기술본부'){
  //       echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
  // }
    $participant = $this->name;

    //KI1 20210125 고객사를 불러오기 위해 doc모델을 연결
    // $this->load->Model('STC_schedule');
    // // $this->load->Model(array('STC_tech_doc','STC_schedule'));
    //KI2 20210125
    $data['events'] = $this->STC_Schedule->schedule_list($participant);

    $data['report'] = $this->STC_Schedule->weekly_report_list();
    //KI1 20210125 고객사를 불러오는 부분
    // $data['customer'] = $this->STC_Schedule->customer_list();
    //유지보수에서
    $data['customer'] = $this->STC_Schedule->get_customer3();
    $data['search_customer'] = $this->STC_Schedule->ser_customer();
    //포캐스팅에서
    $data['customer2'] = $this->STC_Schedule->get_customer2();
    // $data['customer'] = $this->STC_tech_doc->get_customer();
    //KI2 20210125
    // $data['color'] = $result["color"];
    // $data['textColor'] = $result["textColor"];
//////////////////KI
    $data['session_id']      = $this->id;
    $data['session_name']    = $this->name;

    $data['user_count'] = $this->STC_Schedule->user_count();
    $data['user_group_count'] = $this->STC_Schedule->user_group_count();
    $data['parent_group_count'] = $this->STC_Schedule->parent_group_count();

    $data['parentGroup']     = $this->STC_Schedule->parentGroup();
    $data['user_group']      = $this->STC_Schedule->user_group();
    $data['userInfo']        = $this->STC_Schedule->userInfo();
    $data['userDepth']       = $this->STC_Schedule->userDepth();

    $data['work_color']      = $this->STC_Schedule->work_color_list();
    $data['work_name']       = $this->STC_Schedule->group_list();
    $data['pGroupName']      = $this->pGroupName;

    $data['group']           = $this->group;
    $data['login_group']     = $this->STC_Schedule->my_group($this->id)->user_group;
    $data['login_user_duty'] = $this->STC_Schedule->login_user_duty($this->id)->user_duty;

    $data['rooms']           = $this->STC_Schedule->rooms();
    $data['cars']            = $this->STC_Schedule->cars();

    // if($pGroupName == '기술본부' && ( ($this->id == 'kkj') || $data['login_user_duty'] == '팀장' )) {
    //   $data['no_written_report'] = $this->STC_Schedule->no_written_report();
    // }


    $data['title'] = '일정관리';

    $this->load->view('biz/tech_schedule', $data);

  }


  function events_maker(){
    if($_POST['search'] == 'true'){
      // $params = $this->input->post('userArr');
      // $data['participant'] = $params;
      $data['searchTarget'] = $this->input->post('searchOpt');
      $searchUser = $this->input->post('segment');
      $searchArr = explode( ',', $searchUser );
      // $searchArr = $searchUser.split(', ');
      $data['searchKeyword'] = $searchArr;
      // $data['searchKeyword'] = $this->input->get('search_keyword');
      // $data['events'] = $this->STC_Schedule->search($data);
      $list = $this->STC_Schedule->search($data);
    }else{

      $params = $this->input->post('userArr');
      $select_start = $this->input->post('select_start');
      $select_start = explode('T', $select_start);
      $select_end = $this->input->post('select_end');
      $select_end = explode('T', $select_end);

      // echo print_r($params);
      // var_dump($params);
      // $param_flag = isset($params) && !empty($params);
      $user['participant'] = $params;
      $list = $this->STC_Schedule->schedule_list_user($user, $select_start[0], $select_end[0]);
    }


    // var_dump($data);
    // $list = $this->STC_Schedule->schedule_list($participant);
    $events = array();

    foreach ($list as $event) {
      if($event->start_time == "00:00:00" && $event->end_time == "00:00:00"){
        $arr['start'] = $event->start_day;
        $arr['end']   = $event->end_day;
      }else{
        $arr['start'] = $event->start_day."T".$event->start_time;
        $arr['end']   = $event->end_day."T".$event->end_time;
      }
      $arr['id'] = $event->seq;
      $participant = $event->participant;
      $exp_participant = explode(",", $participant);
      $cnt = count($exp_participant)-1;
      if($cnt == 0){
        $participant = $exp_participant[0];
      }else{
        $participant = $exp_participant[0]." 외 ".$cnt."명";
      }

      if($event->work_name==""){
        $work_name = "";
      }else{
        $work_name = "/".$event->work_name;
      }


      if($event->support_method ==""){
        $support_method = "";
      }else{
        $support_method = "/".$event->support_method;
      }

      $outside_work = '';
      if($event->outside_work == "Y") {
        $outside_work = '[직출]';
      }

      if($event->work_type == 'tech'){
        $arr['title'] = "[".$participant."]".$outside_work." ".$event->customer.$work_name.$support_method;
      }else{
        if($event->customer != '' || $event->customer != null){
          $arr['title'] = "[".$participant."]".$outside_work." ".$event->work_name."/".$event->customer."/".$event->title;
        }else{
          $arr['title'] = "[".$participant."]".$outside_work." ".$event->work_name."/".$event->title;
        }
        $arr['extendedProps']['place'] = $event->place;
      }

      $arr['extendedProps']['project']        = $event->project;
      $arr['extendedProps']['title']          = $event->title;
      $arr['extendedProps']['customer']       = $event->customer;
      $arr['extendedProps']['work_name']      = $event->work_name;
      $arr['extendedProps']['support_method'] = $event->support_method;
      $arr['extendedProps']['work_color_seq'] = $event->work_color_seq;
      $arr['extendedProps']['participant']    = $event->participant;
      $arr['extendedProps']['user_name']      = $event->user_name;
      $arr['extendedProps']['user_id']        = $event->user_id;
      $arr['extendedProps']['modifier_name']  = $event->modifier_name;
      $arr['extendedProps']['modifier_id']    = $event->modifier_id;
      $arr['extendedProps']['group']          = $event->group;
      $arr['extendedProps']['p_group']        = $event->p_group;
      $arr['extendedProps']['insert_date']    = $event->insert_date;
      $arr['extendedProps']['modify_date']    = $event->modify_date;
      $arr['extendedProps']['room_name']      = $event->room_name;
      $arr['extendedProps']['car_name']       = $event->car_name;
      $arr['extendedProps']['work_type']      = $event->work_type;
      $arr['extendedProps']['recurring_seq']  = $event->recurring_seq;
      $arr['extendedProps']['recurring_count']  = $event->recurring_count;
      $arr['extendedProps']['recurring_setting']  = $event->recurring_setting;
      $arr['extendedProps']['s_file_changename']  = $event->s_file_changename;
      $arr['extendedProps']['e_file_changename']  = $event->e_file_changename;
      $arr['extendedProps']['start_reason']  = $event->start_reason;
      $arr['extendedProps']['end_reason']  = $event->end_reason;
      $arr['extendedProps']['outside_work']  = $event->outside_work;

      $arr['color']     = $event->color;
      $arr['textColor'] = $event->textColor;
      $arr['display']   = 'block';

      if(($event->tech_report > 0) && ($event->start_day < date("Y-m-d")) && ($event->end_day < date("Y-m-d"))){
        // $arr['borderColor'] = "#a2ff00"; //형광연두
        $arr['borderColor'] = "#ff0000"; //제일 빨간색
        // var borderColor = "#DB4455"; //빨간색
      }else if( $event->nondisclosure == 'Y'){
        $arr['borderColor'] = "#0307fc"; //파란색

      }else{
        $arr['borderColor'] = $event->color; //배경색이랑 동일
        // $arr['borderColor'] = "#00ff0000"; //투명
      }
      array_push($events, $arr);
    }

    $holiday_list = $this->STC_Schedule->holiday_list();

    foreach($holiday_list as $hl) {
      $arr=array();
      $arr['title'] = $hl->dateName;
      $arr['start'] = $hl->locdate;
      $arr['end'] = $hl->locdate;
      $arr['display'] = 'background';
      $arr['className'] = 'koHolidays';
      $arr['color'] = '#ffffff';
      $arr['textColor'] = 'red';
      $arr['editable'] = false;
      $arr['eventClick'] = false;
      array_push($events, $arr);
    }

    echo json_encode($events);
  }







  function events_maker_company_schedule(){

    // if($_POST['csc'] === 'true'){
    $data['csc'] = $_POST['csc'];
    $list = $this->STC_Schedule->company_schedule($data);
    // }else{
    //   return false;
    // }

    $events = array();

    foreach ($list as $event) {
      if($event->start_time == "00:00:00" && $event->end_time == "00:00:00"){
        $arr['start'] = $event->start_day;
        $arr['end'] = $event->end_day;
      }else{
        $arr['start'] = $event->start_day."T".$event->start_time;
        $arr['end'] = $event->end_day."T".$event->end_time;
      }
      $arr['id'] = $event->seq;
      $participant = $event->participant;
      $exp_participant = explode(",", $participant);
      $cnt = count($exp_participant)-1;
      if($cnt == 0){
        $participant = $exp_participant[0];
      }else{
        $participant = $exp_participant[0]." 외 ".$cnt."명";
      }

      if($event->work_name==""){
        $work_name = "";
      }else{
        $work_name = "/".$event->work_name;
      }

      if($event->support_method ==""){
        $support_method = "";
      }else{
        $support_method = "/".$event->support_method;
      }

      $arr['title'] = "[공지사항]".$event->title;
      $arr['extendedProps']['project']        = $event->project;
      $arr['extendedProps']['title']          = $event->title;
      $arr['extendedProps']['customer']       = $event->customer;
      $arr['extendedProps']['work_name']      = $event->work_name;
      $arr['extendedProps']['support_method'] = $event->support_method;
      $arr['extendedProps']['work_color_seq'] = $event->work_color_seq;
      $arr['extendedProps']['participant']    = "두리안정보기술";
      $arr['extendedProps']['user_name']      = $event->user_name;
      $arr['extendedProps']['user_id']        = $event->user_id;
      $arr['extendedProps']['group']          = $event->group;
      $arr['extendedProps']['p_group']        = $event->p_group;
      $arr['extendedProps']['insert_date']    = $event->insert_date;
      $arr['extendedProps']['room_name']      = $event->room_name;
      $arr['extendedProps']['car_name']       = $event->car_name;
      $arr['extendedProps']['work_type']      = $event->work_type;

      $arr['color']       = $event->color;
      $arr['textColor']   = $event->textColor;
      $arr['display']     = 'block';
      $arr['borderColor'] = $event->color; //배경색이랑 동일

      array_push($events, $arr);
    }
  echo json_encode($events);
  }

//반복일정 recurring
  // function events_maker_recurring_schedule(){
  //   $params = $this->input->post('userArr');
  //   $user['participant'] = $params;
  //   $list = $this->STC_Schedule->recurring_schedule($user);
  //
  //   $events = array();
  //
  //   foreach ($list as $event) {
  //     if($event->start_time == "00:00:00" && $event->end_time == "00:00:00"){
  //       $arr['start'] = $event->start_day;
  //       $arr['end'] = $event->end_day;
  //     }else{
  //       $arr['start'] = $event->start_day."T".$event->start_time;
  //       $arr['end'] = $event->end_day."T".$event->end_time;
  //     }
  //     $arr['id'] = $event->seq;
  //     $participant = $event->participant;
  //     $exp_participant = explode(",", $participant);
  //     $cnt = count($exp_participant)-1;
  //     if($cnt == 0){
  //       $participant = $exp_participant[0];
  //     }else{
  //       $participant = $exp_participant[0]." 외 ".$cnt."명";
  //     }
  //
  //     if($event->work_name==""){
  //       $work_name = "";
  //     }else{
  //       $work_name = "/".$event->work_name;
  //     }
  //
  //     if($event->support_method ==""){
  //       $support_method = "";
  //     }else{
  //       $support_method = "/".$event->support_method;
  //     }
  //
  //     if($event->work_type == 'tech'){
  //       $arr['title'] = "[".$participant."]"." ".$event->customer.$work_name.$support_method;
  //     }else{
  //       if($event->customer != '' || $event->customer != null){
  //         $arr['title'] = "[".$participant."]"." ".$event->work_name."/".$event->customer."/".$event->title;
  //       }else{
  //         $arr['title'] = "[".$participant."]"." ".$event->work_name."/".$event->title;
  //       }
  //       $arr['extendedProps']['place'] = $event->place;
  //     }
  //
  //     $arr['extendedProps']['project']        = $event->project;
  //     $arr['extendedProps']['title']          = $event->title;
  //     $arr['extendedProps']['customer']       = $event->customer;
  //     $arr['extendedProps']['work_name']      = $event->work_name;
  //     $arr['extendedProps']['support_method'] = $event->support_method;
  //     $arr['extendedProps']['work_color_seq'] = $event->work_color_seq;
  //     $arr['extendedProps']['participant']    = "두리안정보기술";
  //     $arr['extendedProps']['user_name']      = $event->user_name;
  //     $arr['extendedProps']['user_id']        = $event->user_id;
  //     $arr['extendedProps']['group']          = $event->group;
  //     $arr['extendedProps']['p_group']        = $event->p_group;
  //     $arr['extendedProps']['insert_date']    = $event->insert_date;
  //     $arr['extendedProps']['room_name']      = $event->room_name;
  //     $arr['extendedProps']['car_name']       = $event->car_name;
  //     $arr['extendedProps']['work_type']      = $event->work_type;
  //
  //     $arr['color']       = $event->color;
  //     $arr['textColor']   = $event->textColor;
  //     $arr['display']     = 'block';
  //     $arr['borderColor'] = $event->color; //배경색이랑 동일
  //
  //     $arr['rrule']    = $event->recurring_rrule;
  //
  //     // $arr['rrule']['bysetpos']     = "1"; // 1빼고 다른 양수는 버퍼가 심하고 음수는 아예 안먹히는데 1도 뭐가 변한지 모르겠다. 1이 첫째주(첫번째) -1이 마지막주
  //     // $arr['rrule']['byweekday']     = "['MO','FR']";
  //     // $arr['rrule']['byweekno']         = '2'; //exrrule로 별도의 rrule을 정의하여 사용할 수 있다.
  //     // $arr['rrule']['interval']      = '5'; //각 일정 사이의 간격(freq 단위에 따름 weekly면 2주 month면 두달) 근데 weekly에서만 먹히나 지금
  //
  //     // $arr['exrrule']['byday']     = "4";
  //     // $arr['exrrule']['freq']     = "MONTHLY";
  //     // $arr['exrrule']['dtstart']     = "2021-05-08";
  //
  //     // $arr['exdate']                 = '2021-06-09'; //특정일자 반복 제외->RRule Plugin
  //     // $arr['rrule']['until']         = "2021-06-25";
  //     // $arr['rrule']['freq']          = 'YEARLY'; //해당 일정이 등록된 날짜 기준으로 년별 반복(매년 5월 5일)
  //     // $arr['rrule']['freq']          = 'MONTHLY'; //해당 일정이 등록된 날짜 기준으로 월별 반복(매월 5일)
  //     // $arr['rrule']['freq']          = 'WEEKLY'; //해당 일정이 등록된 요일 기준으로 주별 반복(매주 수요일)
  //     // $arr['rrule']['freq']          = 'DAILY'; //해당 일정 매일 반복
  //     // $arr['rrule']['dtstart']       = '2021-05-05'; //반복일정 시작일
  //     // $arr['rrule']['count']         = '8'; //반복 횟수
  //     // $arr['exrrule']['count']         = '2'; //exrrule로 별도의 rrule을 정의하여 사용할 수 있다.
  //
  //     // $arr['rrule']         = 'RRULE:FREQ=MONTHLY;DTSTART=20210501;BYDAY=SA;BYSETPOS=1;INTERVAL=2';
  //     // $arr['rrule']         = 'RRULE:FREQ=MONTHLY;DTSTART=20210501;BYDAY=SA;COUNT=2;BYSETPOS=5';
  //     // $arr['rrule']         = 'RRULE:FREQ=MONTHLY;UNTIL=20210731;DTSTART=20210501;BYDAY=SA;BYSETPOS=5';
  //     // $arr['rrule']         = 'RRULE:FREQ=MONTHLY;UNTIL=20210625;DTSTART=20210505;BYDAY=SA';
  //     // $arr['rrule']         = 'RRULE:FREQ=MONTHLY;UNTIL=20210625;DTSTART=20210505;BYEASTER=2';
  //     // $arr['rrule']         = 'RRULE:FREQ=WEEKLY;UNTIL=20210625;DTSTART=20210505;INTERVAL=4';
  //     //COUNT : 종료회수
  //     //BYSETPOS : n번째 요일
  //     //UNTIL: 종료일자
  //     //BYDAY : 반복요일 - MO TU WE TH FR SA SU
  //     //INTERVAL : 반복주기
  //
  //     // $arr['daysOfWeek']      = "['4']"; //일:0 월:1 화:2 수:3 목:4 금:5 토:6 매주 특정 요일 반복 ->Recurring Events
  //     // // daysOfWeek와 rrule freq 중에서는 dayOfWeek가 더 우선순위로 작동
  //     // $arr['startRecur']      = '2021-05-15'; //반복일정 시작일자->Recurring Events
  //     // $arr['endRecur']      = '2021-06-25'; //반복일정 종료일자->Recurring Events
  //     array_push($events, $arr);
  //   }
  // echo json_encode($events);
  // }

// BH
  function modify(){
    //수정 요청이 있을 시
    $seq = $this->input->get('seq');
    $work_type = $this->input->get('work_type');
    $startDay = $this->input->get('startDay');
    $startTime = $this->input->get('startTime');
    $endDay = $this->input->get('endDay');
    $endTime = $this->input->get('endTime');
    $workname = $this->input->get('workname');
    //KI1 20210125 고객사를 포캐스팅형으로 변경하여 새로 추가되는 부분
    if($work_type == "tech"){
      $customer = $this->input->get('customerName');
    }else if($work_type == "general"){
      if($this->input->get('customerName2') == '' || $this->input->get('customerName2') == null){
        $customer = '';
      }else{
        $customer = $this->input->get('customerName2');
      }
    }else{
      $customer = '';
    }

    if($this->input->get('forcasting_seq') == ''){
      $forcasting_seq = null;
    }else{
      $forcasting_seq = $this->input->get('forcasting_seq');
    }

    if($this->input->get('maintain_seq') == ''){
      $maintain_seq = null;
    }else{
      $maintain_seq = $this->input->get('maintain_seq');
    }

    if($this->input->get('room_name') == ''){
      $room_name = null;
    }else{
      $room_name = $this->input->get('room_name');
    }

    if($this->input->get('car_name') == ''){
      $car_name = null;
    }else{
      $car_name = $this->input->get('car_name');
    }

    if($this->input->get('start_reason') == ''){
      $start_reason = null;
    }else{
      $start_reason = $this->input->get('start_reason');
    }

    if($this->input->get('end_reason') == ''){
      $end_reason = null;
    }else{
      $end_reason = $this->input->get('end_reason');
    }


    $project = $this->input->get('project');

    $supportMethod = $this->input->get('supportMethod');
    //비공개 일정
    $nondisclosure = $this->input->get('nondisclosure');
    //공지사항
    if($work_type === 'company'){
      $participant = "";
    }else{
      // if($this->input->get('participant') == '' || $this->input->get('participant') == null){
      //   $participant = $this->name;
      // }else{
      //   $participant = $this->input->get('participant');
      // }
      $participant_val = $this->input->get('participant');
      $participant_val_arr = explode(',',$participant_val);
      $participant = array();
      $participant_seq = array();
      foreach ($participant_val_arr as $arr) {
        $val = explode('_',$arr);
        $name_val = $val[0];
        $seq_val = $val[1];
        // $name_val = explode('_',$arr)[0];
        // $seq_val = explode('_',$arr)[1];
        array_push($participant, $name_val);
        array_push($participant_seq, $seq_val);
      }
      $participant = implode(',',$participant);
      $participant_seq = implode(',',$participant_seq);
    }
    //공지사항

    //recurring 반복일정
    $recurring_seq = $this->input->get('recurring_seq');
    $recurring_date = $this->input->get('recurring_date');
    $recurring_setting = $this->input->get('recurring_setting');
    $recurring_modify_choose = $this->input->get('recurring_modify_choose');
    $recurring_count = $this->input->get('recurring_count');


    //내용분할1
    //일장 내영 분할 tech_schedule_contents 입력용
    $contents_arr = $this->input->get('contents');
    // var_dump($contents_arr);

    $title = $this->input->get('title');
    $place = $this->input->get('place');
    $visit_company = $this->input->get('visitCompany');
    $modifyDay = date("Y-m-d H:i:s");

    $outside_work = $this->input->get('outside_work');

    $user_id = $this->id;
    $my_group = $this->STC_Schedule->my_group($user_id)->user_group;
    $data = array(
      'seq'             => $seq,
      'work_type'       => $work_type,
      'start_day'       => $startDay,
      'start_time'      => $startTime,
      'end_day'         => $endDay,
      'end_time'        => $endTime,
      'work_name'       => $workname,
      //KI1 20210125 고객사를 포캐스팅형으로 변경하여 새로 추가되는 부분
      'customer'        => $customer,
      'visit_company'        => $visit_company,
      'forcasting_seq'  => $forcasting_seq,
      'maintain_seq'    => $maintain_seq,
      'project'         => $project,
      //KI2 20210125
      'support_method'  => $supportMethod,
      'participant'     => $participant,
      'participant_seq' => $participant_seq,
      'modifier_id'     => $user_id,
      'modifier_name'   => $this->name,
      // 'user_id' => $user_id,
      // 'user_name' => $this->name,
      'modify_date'     => $modifyDay,
      'group'           => $my_group,
      'p_group'         => $this->pGroupName,
      'title'           => $title,
      'place'           => $place,
      'room_name'       => $room_name,
      'car_name'        => $car_name,
      'start_reason'        => $start_reason,
      'end_reason'        => $end_reason,
      // 'weekly_report' => null,
      'nondisclosure'   => $nondisclosure,
      'outside_work'    => $outside_work,
      'recurring_date'          => $recurring_date,
      'recurring_modify_choose' => (!empty($recurring_modify_choose)) ? $recurring_modify_choose : NULL,
      'recurring_setting'       => (!empty($recurring_setting)) ? $recurring_setting : NULL, //반복일정이었던걸 반복취소 할 경우에 null값을 넣어줘야하기 때문에
      'recurring_seq'           => (!empty($recurring_seq)) ? $recurring_seq : NULL, //반복일정이었던걸 반복취소 할 경우에 null값을 넣어줘야하기 때문에
      'recurring_count'         => (!empty($recurring_count)) ? $recurring_count : NULL //반복일정이었던걸 반복취소 할 경우에 null값을 넣어줘야하기 때문에
    );

    $written_rep_cnt = $this->STC_Schedule->written_rep_cnt($seq)->cnt;
    if ($written_rep_cnt > 0){
      echo json_encode("report_written");
      return false;
    }

    // $detail_info = $this->STC_Schedule->details($seq);
    // $work_type = $detail_info->work_type;
    // $before_sday = $detail_info->start_day;
    // $before_eday = $detail_info->end_day;
    // if ($work_type=='tech'){
    //   if ($startDay != $before_sday || $endDay != $before_eday){
    //     $report_cnt = abs(strtotime($startDay) - strtotime($endDay))/60/60/24+1;
    //     $written_rep_cnt = $this->STC_Schedule->written_rep_cnt($seq)->cnt;
    //     $data['tech_report'] = $report_cnt - $written_rep_cnt;
    //   }
    // }






    if($data['recurring_modify_choose'] == null){
        if($data['recurring_seq'] == null){

            // 반복일정이 아닐 경우
            unset($data['recurring_modify_choose']); //data에서 recurring_modify_choose 값 제외
            unset($data['recurring_date']); //data에서 recurring_date 값 제외
            array_values($data);

            $sql = "SELECT count(seq) AS num FROM tech_schedule_list WHERE recurring_seq = (SELECT recurring_seq FROM tech_schedule_list WHERE seq = {$seq})";
            $query = $this->db->query($sql);
            $num = $query->row()->num;
            if($num > 0){ //반복일정이었다가 반복일정이 아니게 된것
                $sql2 = "SELECT seq FROM tech_schedule_list WHERE recurring_seq = (SELECT recurring_seq FROM tech_schedule_list WHERE seq = {$seq}) ORDER BY seq ASC";
                $query = $this->db->query($sql2);
                $db_seq = $query->result_array();
                for($i = 0; $i < $num; $i++){
                    if($i == 0){
                      $up_seq = $db_seq[$i]['seq'];
                      $where = array(
                        'seq' => $up_seq
                      );
                      $this->db->where($where);
                      unset($data['start_day']);
                      unset($data['end_day']);
                      array_values($data);
                      $result = $this->STC_Schedule->schedule_update('update', $data, $where);
                      // echo json_encode($result);
                      $this->STC_Schedule->schedule_contents_update($contents_arr,$up_seq);
                    }else{
                      $del_seq = $db_seq[$i]['seq'];
                      $where = array(
                        'seq' => $del_seq
                      );
                      $where2 = array(
                        'schedule_seq' => $del_seq
                      );
                      $result = $this->STC_Schedule->schedule_update('delete', $data, $where, $where2);
                      // echo json_encode($result);
                    }
                }
            }else{ //원래 반복일정이 아닌것
                $where = array(
                  'seq' => $seq
                );
                $result = $this->STC_Schedule->schedule_update('update', $data, $where);
                // echo json_encode($result);
                $this->STC_Schedule->schedule_contents_update($contents_arr,$seq);
            }

        }else{ //반복일정이 아닌 것이 반복일정이 되는 경우

            unset($data['recurring_modify_choose']);

            if(is_array($data['recurring_date']) || is_object($data['recurring_date'])){
              $recurring_date_length = count($data['recurring_date']);
              // $recurring_date_length = sizeof($data['recurring_date']);
            }
            $recurring_date = $data['recurring_date'];
            $date_diff_num = 0;

            for($i = 0; $i < $recurring_date_length; $i++){

                $data['start_day'] = $recurring_date[$i];

                if($i == 0 ){
                    $start = new DateTime($data['start_day']);
                    $end = new DateTime($data['end_day']);
                    $date_diff = date_diff($start, $end);
                    $date_diff_num = (int)$date_diff->days;
                }
                if( 0 < $date_diff_num){ //일정이 이틀 이상일 때
                    $data['end_day'] = date("Y-m-d",strtotime("{$data['start_day']} +{$date_diff_num} day"));
                }else{ //일정이 하루일 때
                    $data['end_day'] = $data['start_day'];
                }
                unset($data['recurring_date']); //data에서 recurring_seq 값 제외
                unset($data['recurring_count']);
                array_values($data);

                if($i == 0 ){
                    $data['recurring_count'] = $i;
                    $where = array(
                      'seq' => $seq
                    );
                    $result = $this->STC_Schedule->schedule_update('update', $data, $where);
                    // echo json_encode($result);
                    $this->STC_Schedule->schedule_contents_update($contents_arr,$seq);
                }else{
                    $data['recurring_count'] = $i;
                    unset($data['tech_report']);
                    if(!empty($data['modifier_id']) == true){
                        $data['user_id'] = $data['modifier_id'];
                        $data['user_name'] = $data['modifier_name'];
                        $data['insert_date'] = $data['modify_date'];
                        unset($data['modifier_id']);
                        unset($data['modifier_name']);
                        unset($data['modify_date']);
                    }
                    array_values($data);
                    $result = $this->STC_Schedule->schedule_update('insert', $data, null, null, $contents_arr);
                    // echo json_encode($result);
                }
            }

        }

    }else{
        // 반복일정인 경우
        if(is_array($data['recurring_date']) || is_object($data['recurring_date'])){
          $recurring_date_length = count($data['recurring_date']);
          // $recurring_date_length = sizeof($data['recurring_date']);
        }

        $recurring_date = $data['recurring_date'];
        $date_diff_num = 0;

        $db_sql = "SELECT seq,recurring_count FROM tech_schedule_list WHERE recurring_seq = {$data['recurring_seq']} ORDER BY seq ASC";
        $db_query = $this->db->query($db_sql);
        $db_val = $db_query->result_array();
        $db_recurring_count ='';
        foreach($db_val as $count){
          $db_recurring_count = $count['recurring_count'];
        }
        $db_seq_count = $db_query->num_rows();

        if($data['recurring_modify_choose'] == 'all_sch'){
            unset($data['recurring_modify_choose']); //data에서 recurring_modify_choose 값 제외

            // $sql = "SELECT start_day, start_time, end_day, end_time FROM tech_schedule_list WHERE recurring_seq = {$recurring_seq} ORDER BY seq ASC";
            // $query = $this->db->query($sql);
            // $org_val = $query->result_array();
            // $org_val_num = $query->num_rows();
            // $change_date_enum = '';
            //
            // for($org = 0; $org < $org_val_num; $org++;){
            //   $org_start_day = $org_val[$org]['start_day'];
            //   $org_start_time = $org_val[$org]['start_time'];
            //   $org_end_day = $org_val[$org]['end_day'];
            //   $org_end_time = $org_val[$org]['end_time'];
            //
            //   if($data['start_day'] <> $org_start_day || $data['start_time'] <> $org_start_time || $data['end_day'] <> $org_end_day || $data['end_time'] <> $org_end_time){
            //     $change_date_enum = "Y";
            //   }else{
            //     $change_date_enum = "N";
            //   }
            // }



            //시작 날짜와 끝나는 날짜 차이값 구하기
            for($i = 0; $i < $recurring_date_length; $i++){
                $data['start_day'] = $recurring_date[$i];

                if($i == 0){
                    $start = new DateTime($data['start_day']);
                    $end = new DateTime($data['end_day']);
                    $date_diff = date_diff($start, $end);
                    $date_diff_num = (int)$date_diff->days;
                }

                if( 0 < $date_diff_num){ //일정이 이틀 이상일 때
                    $data['end_day'] = date("Y-m-d",strtotime("{$data['start_day']} +{$date_diff_num} day"));
                }else{ //일정이 하루일 때
                    $data['end_day'] = $data['start_day'];
                }
                unset($data['recurring_date']); //data에서 recurring_date 값 제외
                unset($data['recurring_count']);
                array_values($data);
                //이 일정의 re_seq와 일치하는 모든 일정 update

                if($i <= $db_recurring_count){
                // if($i < $db_seq_count){
                    $where = array(
                      'recurring_seq' => $data['recurring_seq'],
                      'recurring_count' => $i
                    );
                    $result = $this->STC_Schedule->schedule_update('update', $data, $where);
                    if($result == 'false'){
                      continue;
                    }
                    // echo json_encode($result);

                }else if($db_recurring_count < $i){ //반복일수가 기본 데이터보다 늘었을 때 insert
                // }else if($db_seq_count <= $i){ //반복일수가 기본 데이터보다 늘었을 때 insert
                    $data['recurring_count'] = $i;
                    unset($data['tech_report']);
                    array_values($data);
                    $result = $this->STC_Schedule->schedule_update('insert', $data, null, null, $contents_arr);
                    // echo json_encode($result);
                }
            }
            $sql = "SELECT seq FROM tech_schedule_list WHERE recurring_seq = {$data['recurring_seq']}";
            $query = $this->db->query($sql);
            $update_seq = $query->result_array();
            foreach($update_seq as $row){
              $this->STC_Schedule->schedule_contents_update($contents_arr,$row['seq']);
            }

            if($recurring_date_length < $db_seq_count){ //반복일수가 기본 데이터보다 줄어들었을 때
              //반복횟수 이상의 데이터는 삭제
                for($j = $recurring_date_length; $j < $db_seq_count; $j++){
                  $del_seq = $db_val[$j]['seq'];
                  $where = array(
                    'seq' => $del_seq
                  );
                  $where2 = array(
                    'schedule_seq' => $del_seq
                  );
                  $result = $this->STC_Schedule->schedule_update('delete', null, $where, $where2);
                  // echo json_encode($result);
                }
            }

        }else if($data['recurring_modify_choose'] == 'forward_sch'){
            unset($data['recurring_modify_choose']); //data에서 recurring_modify_choose 값 제외

            // $sql = "SELECT recurring_setting FROM tech_schedule_list WHERE recurring_seq = {$data['recurring_seq']} ORDER BY seq ASC LIMIT 1";
            if($recurring_seq == $seq){
              $sql = "SELECT recurring_setting FROM tech_schedule_list WHERE seq = {$seq}";
            }else{
              $sql = "SELECT recurring_setting FROM tech_schedule_list WHERE recurring_seq = {$recurring_seq} AND seq < {$seq} ORDER BY seq ASC LIMIT 1";
            }
            $query = $this->db->query($sql);
            $org_recurring_setting = $query->row()->recurring_setting;

            $sql3 = "SELECT recurring_count FROM tech_schedule_list WHERE recurring_seq = {$recurring_seq} AND seq >= {$seq} ORDER BY seq ASC";
            $query3 = $this->db->query($sql3);
            $org_fsch_val = $query3->result_array();
            $org_fsch_val_num = $query3->num_rows();

            $org_recurring_seq = $data['recurring_seq'];

            if($recurring_setting == $org_recurring_setting){ //recurring_setting값이 변하지 않은, 즉 반복세팅이 변경되지 않은 일정의 향후모든 일정 수정
                unset($data['recurring_date']); //data에서 recurring_seq 값 제외
                unset($data['recurring_count']);
                unset($data['recurring_setting']);
                // unset($data['start_day']);
                // unset($data['start_time']);
                // unset($data['end_day']);
                // unset($data['end_time']);
                array_values($data);


                for($i = 0; $i < $org_fsch_val_num; $i++){
                    $org_recurring_count = $org_fsch_val[$i]['recurring_count'];

                    if( $org_recurring_count == NULL){
                      continue;
                    }

                    $data['start_day'] = $recurring_date[$i];

                    if($i == 0 ){
                        $start = new DateTime($data['start_day']);
                        $end = new DateTime($data['end_day']);
                        $date_diff = date_diff($start, $end);
                        $date_diff_num = (int)$date_diff->days;
                    }
                    if( 0 < $date_diff_num){ //일정이 이틀 이상일 때
                        $data['end_day'] = date("Y-m-d",strtotime("{$data['start_day']} +{$date_diff_num} day"));
                    }else{ //일정이 하루일 때
                        $data['end_day'] = $data['start_day'];
                    }

                    $where = array(
                      'recurring_seq' => $data['recurring_seq'],
                      'recurring_count' => $org_recurring_count,
                      'seq >=' => $seq
                    );
                    $result = $this->STC_Schedule->schedule_update('update', $data, $where);

                    $sql2 = "SELECT seq FROM tech_schedule_list WHERE recurring_seq = {$data['recurring_seq']} AND seq >= $seq";
                    $query2 = $this->db->query($sql2);
                    $update_seq = $query2->result_array();
                    foreach($update_seq as $row){
                      $seq2 = $row['seq'];
                      if($seq2 != null){
                        $this->STC_Schedule->schedule_contents_update($contents_arr,$seq2);
                      }
                    }

                }



            }else{ //recurring_setting값이 변한, 즉 반복세팅이 변경된 일정의 향후모든 일정 수정

                //반복세팅이 변경되어 새로 분리되기 전 원본 일정들
                $explode_arr1 = explode(';;;',$org_recurring_setting);
                $arr = array();
                for($j = 0; $j < count($explode_arr1); $j++){
                  $explode_arr2 = explode(':', $explode_arr1[$j]);
                  $arr[$explode_arr2[0]] = $explode_arr2[1]; //arr에 key value값으로 넣기
                }

                $data2 = array();
                $data2['recurring_setting'] = 'cycle:'.$arr['cycle'].';;;cycle_ex:1'.';;;endday:'.date("Y-m-d",strtotime("{$recurring_date[0]} -1 day"));
                $data2['seq'] = $seq;

                $where = array(
                'recurring_seq' => $data['recurring_seq'],
                'seq <' => $seq
                );
                $result = $this->STC_Schedule->schedule_update('update', $data2, $where);

              //반복세팅이 변경되어 새로 분리되는 일정들
                $sql1 = "SELECT seq FROM tech_schedule_list WHERE recurring_seq = {$recurring_seq} AND seq >= {$seq} ORDER BY seq ASC";
                $query1 = $this->db->query($sql1);
                $seq_arr = $query1->result_array();

                for($i = 0; $i < $recurring_date_length; $i++){
                  $data['start_day'] = $recurring_date[$i];

                  if($i == 0){
                    $start = new DateTime($data['start_day']);
                    $end = new DateTime($data['end_day']);
                    $date_diff = date_diff($start, $end);
                    $date_diff_num = (int)$date_diff->days;
                  }
                  if( 0 < $date_diff_num){ //일정이 이틀 이상일 때
                    $data['end_day'] = date("Y-m-d",strtotime("{$data['start_day']} +{$date_diff_num} day"));
                  }else{ //일정이 하루일 때
                    $data['end_day'] = $data['start_day'];
                  }

                  unset($data['recurring_date']); //data에서 recurring_seq 값 제외
                  array_values($data);

                  if(empty($seq_arr[$i]['seq']) == false){
                    $where = array(
                      'recurring_seq' => $org_recurring_seq,
                      'seq' => $seq_arr[$i]['seq']
                    );
                    $data['recurring_seq'] = $seq; //해당 일정부터 원래 반복에서 recurring_seq를 분리
                    $data['recurring_count'] = $i; //해당 일정부터 recurring_count를 다시 매김
                    $data['recurring_setting'] = $recurring_setting;
                    $result = $this->STC_Schedule->schedule_update('update', $data, $where);
                    $this->STC_Schedule->schedule_contents_update($contents_arr,$seq_arr[$i]['seq']);

                  }else{
                    $data['recurring_count'] = $data['recurring_count']+1;
                    $data['recurring_setting'] = $recurring_setting;
                    $modifier_id = '';
                    $modifier_name = '';
                    $modify_date = '';
                    if(!empty($data['modifier_id']) && !empty($data['modifier_name']) && !empty($data['modify_date'])){
                      $modifier_id = $data['modifier_id'];
                      $modifier_name = $data['modifier_name'];
                      $modify_date = $data['modify_date'];
                      $data['user_id'] = $data['modifier_id'];
                      $data['user_name'] = $data['modifier_name'];
                      $data['insert_date'] = $data['modify_date'];
                    }else{
                      $data['user_id'] = $modifier_id;
                      $data['user_name'] = $modifier_name;
                      $data['insert_date'] = $modify_date;
                    }
                    unset($data['modifier_id']);
                    unset($data['modifier_name']);
                    unset($data['modify_date']);
                    unset($data['tech_report']);
                    array_values($data);
                    $result = $this->STC_Schedule->schedule_update('insert', $data, null, null, $contents_arr);
                  }
                  // echo json_encode($result);
                }
                $del_sql = "SELECT seq FROM tech_schedule_list WHERE recurring_seq = {$org_recurring_seq} AND seq > (SELECT seq FROM tech_schedule_list WHERE recurring_seq = {$data['recurring_seq']} ORDER BY seq DESC LIMIT 1)";
                $del_query = $this->db->query($del_sql);
                $del_seq_val = $del_query->result_array();
                // $del_num = $del_query->num_rows();
                foreach ($del_seq_val as $del_seq_val2) {
                  $del_seq = $del_seq_val2['seq'];
                  $where = array(
                    'seq' => $del_seq
                  );
                  $where2 = array(
                    'schedule_seq' => $del_seq
                  );
                  $result = $this->STC_Schedule->schedule_update('delete', null, $where, $where2);
                }
                // if($del_num > 0){
                //   for($d = 0; $d < $del_num; $d++){
                //     $del_seq = $db_seq[$d]['seq'];
                //     $where = array(
                //       'seq' => $del_seq
                //     );
                //     $where2 = array(
                //       'schedule_seq' => $del_seq
                //     );
                //     $result = $this->STC_Schedule->schedule_update('delete', $data, $where, $where2);
                //   }
                // }
            }


        }else if($data['recurring_modify_choose'] == 'only_this_sch'){
            unset($data['recurring_modify_choose']); //data에서 recurring_modify_choose 값 제외
            unset($data['recurring_date']); //data에서 recurring_date 값 제외
            unset($data['recurring_count']);
            unset($data['recurring_setting']);
            //이 일정의 seq만 가져가서 해당 일정만 update
            $where = array(
            'recurring_seq' => $data['recurring_seq'],
            'seq' => $seq
            );
            unset($data['recurring_seq']);
            array_values($data);
            $result = $this->STC_Schedule->schedule_update('update', $data, $where);
            // echo json_encode($result);
            $this->STC_Schedule->schedule_contents_update($contents_arr,$seq);
        }
    }

    // if($recurring_modify_choose == 'all_sch'){
    //   //반복세팅 수정 된 상태
    //   $data['recurring_setting'] = $recurring_setting;
    //
    //   //이 일정의 re_seq와 일치하는 모든 일정 update
    //   $this->db->where('recurring_seq', $recurring_seq);
    //   $result = $this->db->update('tech_schedule_list', $data);
    //
    //   //시작일자 종료일자도 수정해야함
    //
    // }else if($recurring_modify_choose == 'forward_sch'){
    //   //반복세팅 수정 된 상태
    //   $data['recurring_setting'] = $recurring_setting;
    //
    //   //이 일정의 re_seq와 일치하는 일정들을 seq로 정렬해서 이 일정과 그 이후의 모든 일정 update
    //   // $sql = "SELECT * FROM tech_schedule_list WHERE recurring_seq = {$recurring_seq} AND seq >= {$seq};"
    //   $where = array(
    //     'recurring_seq' => $recurring_seq,
    //     'seq >=' => $seq
    //   )
    //   $this->db->select('seq');
    //   $this->db->get_where('tech_schedule_list', $where);
    //
    //   $this->db->where('seq', $seq);
    //   $result = $this->db->update('tech_schedule_list', $data);
    //
    //   //시작일자 종료일자도 수정해야함
    //
    // }else if($recurring_modify_choose == 'only_this_sch'){
    //   //반복세팅 수정 안된 상태
    //   //이 일정의 seq만 가져가서 해당 일정만 update
    //   $where = array(
    //     'recurring_seq' => $recurring_seq,
    //     'seq' => $seq
    //   );
    //   $this->db->where($where);
    //   $result = $this->db->update('tech_schedule_list', $data);
    //
    // }


    // $result = $this->STC_Schedule->schedule_update($data);
    echo json_encode($result);


    //내용분할1 일정 내용 분할 저장
    // $this->STC_Schedule->schedule_contents_update($contents_arr,$seq);

    if(!empty($contents_arr)){
      $contents='';
      // $weekly_report = "N";
      // $contents_length = count($contents_arr);
      // for($i=0; $i<$contents_length; $i++){
      //   $weekly_report_val = $contents_arr[$i]['weekly_report'];
      //   $contents_val = $contents_arr[$i]['contents'];
      //
      //   if($weekly_report_val == "Y"){
      //     if($contents == ''){
      //       $contents = $contents_val;
      //     }else{
      //       $contents = $contents.'<br>'.$contents_val;
      //     }
      //     $weekly_report = "Y"; //하나라도 Y가 있으면 Y로 한다.
      //   }
      //
      // }
      $weekly_report='';
      foreach ($contents_arr as $contents_val) {
        $contents = $contents_val['contents'];
        $contents_num = $contents_val['contents_num'];
        $weekly_report = $contents_val['weekly_report'];
        //내용분할2

        //기술연구소 주간보고 연동
        if($work_type == 'lab'){
          $data_lab1 = array(
            'contents_num' => $contents_num,
            'group_name'   => '기술연구소',
            'produce'      => $title,
            'writer'       => $participant,
            'income_time'  => $startDay
          );

          $val_arr = explode(',,,',$contents);
          $val_arr_length = count($val_arr);
          for($p = 0; $p < $val_arr_length; $p++){

            $val_arr2 = explode(':::', $val_arr[$p]);
            $val_arr_key = $val_arr2[0];
            $val_arr_value = $val_arr2[1];

            if($val_arr_key == 'dev_type'){

              $data_lab1['work_name'] = $val_arr_value;

            }else if($val_arr_key == 'dev_page'){

              $data_lab1['customer'] = $val_arr_value;

            }else if($val_arr_key == 'dev_requester'){

              $data_lab1['type'] = $val_arr_value;

            }else if($val_arr_key == 'dev_develop'){

              $data_lab1['subject'] = $val_arr_value;

            }else if($val_arr_key == 'dev_complete'){

              if($val_arr_value == 'Y'){
                $data_lab1['result'] = '완료';
                $data_lab1['completion_time'] = $endDay;
              }else{
                $data_lab1['result'] = '미완료';
                $data_lab1['completion_time'] = null;
              }

            }
          }

          //작성된 금주 주간보고서가 있는지 확인
          $check_report2 = $this ->STC_Schedule->check_report($startDay, '기술연구소');
          if($check_report2 != 'false'){
            //작성값을 넣을 금주 주간보고서 정보 가져오기
            $report_seq = $check_report2->seq;
            $year = $check_report2->year;
            $month = $check_report2->month;
            $week = $check_report2->week;

            //해당 일정 seq를 가진 금주 주간업무보고가 등록되어있는지 확인
            $check_sch_current_report_lab = $this->STC_Schedule->check_current_week_doc($seq, $contents_num);
            if( $check_sch_current_report_lab == 'false'){ //해당 일정으로 등록된 주간업무보고가 없을 경우 insert
              //금주 주간보고서가 있으면 입력할 값 받아오기
              //주간업무보고의 마지막 tech_seq값의 -1 한 값을 가져오기
              $tech_seq = $this->STC_Schedule->check_tech_seq(); //금주
              $tech_seq = $tech_seq->m1;
              $data_lab2 = array(
                'tech_seq'    => $tech_seq,
                'report_seq'  => $report_seq,
                'year'        => $year,
                'month'       => $month,
                'week'        => $week,
                'insert_time' => date("Y-m-d H:i:s")
              );
              $data = array_merge($data_lab1, $data_lab2);
              $this->STC_Schedule->insert_current_week_doc($data);
            }else{
              $data_lab2 = array(
                'report_seq'   => $report_seq,
                'year'         => $year,
                'month'        => $month,
                'week'         => $week,
                'schedule_seq' => $seq,
                'update_time'  => date("Y-m-d H:i:s")
              );
              $data = array_merge($data_lab1, $data_lab2);
              $this->STC_Schedule->update_current_week_doc($data);
            }
          }

          //작성된 차주 주간보고서가 있는지 확인
          $before_day =  date("Y-m-d", strtotime($startDay." -7day"));
          $check_report1 = $this ->STC_Schedule->check_report($before_day, '기술연구소');
          if($check_report1 != 'false'){
            //작성값을 넣을 차주 주간보고서 정보 가져오기
            $report_seq = $check_report1->seq;
            $year = $check_report1->year;
            $month = $check_report1->month;
            $week = $check_report1->week;

            //해당 일정 seq를 가진 금주 주간업무보고가 등록되어있는지 확인
            $check_sch_next_report_lab = $this->STC_Schedule->check_next_week_doc($seq, $contents_num);
            if( $check_sch_next_report_lab == 'false'){ //해당 일정으로 등록된 주간업무보고가 없을 경우 insert
              //차주 주간보고서가 있으면 입력할 값 받아오기
              //주간업무보고의 마지막 tech_seq값의 -1 한 값을 가져오기
              $tech_seq2 = $this->STC_Schedule->check_tech_seq2(); //차주
              $tech_seq2 = $tech_seq2->m1;
              $data_lab2 = array(
                'tech_seq'    => $tech_seq2,
                'report_seq'  => $report_seq,
                'year'        => $year,
                'month'       => $month,
                'week'        => $week,
                'insert_time' => date("Y-m-d H:i:s")
              );
              unset($data_lab1['result']);
              array_values($data_lab1); //unset으로 빵꾸난 $data_lab1의 index 재정렬
              $data = array_merge($data_lab1, $data_lab2);
              $this->STC_Schedule->insert_next_week_doc($data);
            }else{ //해당 일정으로 등록된 주간업무보고가 있을 경우 update
              $data_lab2 = array(
                'report_seq'   => $report_seq,
                'year'         => $year,
                'month'        => $month,
                'week'         => $week,
                'schedule_seq' => $seq,
                'update_time'  => date("Y-m-d H:i:s")
              );
              unset($data_lab1['result']);
              array_values($data_lab1); //unset으로 빵꾸난 $data_lab1의 index 재정렬
              $data = array_merge($data_lab1, $data_lab2);
              $this->STC_Schedule->update_next_week_doc($data);
            }
          }
        }


        //기술연구소 외 주간보고 연동
        if($weekly_report == "Y" && $work_type != 'lab'){
        // if($work_type == 'tech' || $weekly_report == "Y"){

          $writer = preg_replace("/\s+/", "", $participant);
          $writer = explode( ',', $writer );
          $num = count($writer);
          $group_arr = array();
          for ($i=0; $i < $num ; $i++) {
            $linker = $writer[$i];
            $linker_data = $this->STC_Schedule->linker_group($linker);
            if($linker_data != 'false'){
              array_push($group_arr, $linker_data);
            }
          }

          //php버전 5대에서 array_column 사용 가능하도록 하는 함수
          if (! function_exists('array_column')) {
            function array_column(array $input, $columnKey, $indexKey = null) {
              $array = array();
              foreach ($input as $value) {
                if ( !array_key_exists($columnKey, $value)) {
                  trigger_error("Key \"$columnKey\" does not exist in array");
                  return false;
                }
                if (is_null($indexKey)) {
                  $array[] = $value->$columnKey;
                }
                else {
                  if ( !array_key_exists($indexKey, $value)) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                  }
                  if ( ! is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                  }
                  $array[$value[$indexKey]] = $value[$columnKey];
                }
              }
              return $array;
            }
          }
          $temp = array_unique(array_column($group_arr, 'user_group'));
          $group_arr = array_intersect_key($group_arr, $temp);


          //해당 일정 seq를 가진 금주 주간업무보고가 등록되어있는지 확인
          $check_sch_current_report_arr = $this->STC_Schedule->check_current_week_doc($seq, $contents_num);
          //php 5.4버전 이상부터만 가능한 배열선언방식
          // $check_sch_current_report = [];
          $check_sch_current_report = array();
          if( $check_sch_current_report_arr != 'false'){
            for($i=0; $i<count($check_sch_current_report_arr);$i++) {

              $cscr_arr = $check_sch_current_report_arr[$i]->group_name;
              array_push($check_sch_current_report, $cscr_arr);

            }
          }else{

            array_push($check_sch_current_report, 'false');

          }
          $check_sch_current_report = array_unique($check_sch_current_report);


          $current_insert_group_name = array();
          $current_update_group_name = array();
          $current_delete_group_name = array();
          //php 5.4버전 이상부터만 가능한 배열선언방식
          // $current_insert_group_name = [];
          // $current_update_group_name = [];
          // $current_delete_group_name = [];

          //해당 일정 seq를 가진 차주 주간업무보고가 등록되어있는지 확인
          $check_sch_next_report_arr = $this->STC_Schedule->check_next_week_doc($seq, $contents_num);
          $check_sch_next_report =array();
          //php 5.4버전 이상부터만 가능한 배열선언방식
          // $check_sch_next_report =[];
          if( $check_sch_next_report_arr != 'false'){
            for($i=0; $i<count($check_sch_next_report_arr);$i++) {

              $csnr_arr = $check_sch_next_report_arr[$i]->group_name;
              array_push($check_sch_next_report, $csnr_arr);

            }
          }else{
            array_push($check_sch_next_report, 'false');
          }
          $check_sch_next_report = array_unique($check_sch_next_report);

          $next_insert_group_name = array();
          $next_update_group_name = array();
          $next_delete_group_name = array();
          //php 5.4버전 이상부터만 가능한 배열선언방식
          // $next_insert_group_name = [];
          // $next_update_group_name = [];
          // $next_delete_group_name = [];

          foreach ($group_arr as $group_arr4) {
            $writer_group = $group_arr4->user_group;
            $writer_pgroup = $group_arr4->parentGroupName;
            if($writer_group <> '기술연구소'){
              if($writer_pgroup <> '기술본부'){

                // //작성된 금주 주간보고서가 있는지 검색
                // $check_report2 = $this ->STC_Schedule->check_report($startDay, $writer_group);
                // //금주 주간보고서가 있을 경우 insert/update진행
                //
                // if($check_report2 != 'false'){

                foreach($check_sch_current_report as $cscr){
                  if($cscr === 'false' || $writer_group != $cscr){

                    array_push($current_insert_group_name,$writer_group);
                    array_push($current_delete_group_name,$cscr);

                  }else if($writer_group == $cscr){

                    array_push($current_update_group_name,$writer_group);
                    // //기존에 있는 그룹과 받아온 그룹이름이 동일한 그룹은 이미 주간보고가 등록된 그룹이기에 update해주고 배열에서 제거
                    // $c_key = array_search( $writer_group, $check_sch_current_report );
                    // array_splice( $check_sch_current_report, $c_key, 1 );
                  }
                }
                // }
              }
              // // //작성된 전주 주간보고서가 있는지 검색
              // $before_day =  date("Y-m-d", strtotime($startDay." -7day"));
              // $check_report3 = $this ->STC_Schedule->check_report($before_day, $writer_group);
              // // //전주 주간보고서가 있을 경우 insert/update진행
              // if($check_report3 != 'false'){

              foreach($check_sch_next_report as $csnr){
                if($csnr === 'false' || $writer_group != $csnr){

                  array_push($next_insert_group_name,$writer_group);
                  array_push($next_delete_group_name,$csnr);

                }else if($writer_group == $csnr){

                  array_push($next_update_group_name,$writer_group);
                  // //기존에 있는 그룹과 받아온 그룹이름이 동일한 그룹은 이미 주간보고가 등록된 그룹이기에 update해주고 배열에서 제거
                  // $n_key = array_search( $writer_group, $check_sch_next_report );
                  // array_splice( $check_sch_next_report, $n_key, 1 );
                }
              }
              // }
            }
          }

          //insert/update/delete 할 그룹명들 중복제거
          $next_insert_group_name = array_unique($next_insert_group_name);
          $next_delete_group_name = array_unique($next_delete_group_name);
          $next_update_group_name = array_unique($next_update_group_name);

          //insert와 delete배열에서 update 배열과 동일한 값이 존재하면 제거한다.
          $next_insert_group_name = array_diff($next_insert_group_name, $next_update_group_name);
          $next_delete_group_name = array_diff($next_delete_group_name, $next_update_group_name);

          $crruent_insert_group_name = array_unique($current_insert_group_name);
          $current_delete_group_name = array_unique($current_delete_group_name);
          $current_update_group_name = array_unique($current_update_group_name);

          $current_insert_group_name = array_diff($current_insert_group_name, $current_update_group_name);
          $current_delete_group_name = array_diff($current_delete_group_name, $current_update_group_name);

          //insert나 update에 기술1,2팀이 하나라도 존재하면 삭제 부분에서 기술본부는 제거한다.
          $find_1_in_nign = in_array('기술1팀',$next_insert_group_name);
          $find_1_in_nugn = in_array('기술1팀',$next_update_group_name);
          $find_2_in_nign = in_array('기술2팀',$next_insert_group_name);
          $find_2_in_nugn = in_array('기술2팀',$next_update_group_name);

          if( ($find_1_in_nign == true) || ($find_1_in_nugn == true) || ($find_2_in_nign == true) || ($find_2_in_nugn == true)){
            // array_splice($next_delete_group_name, array_search('기술본부',$next_delete_group_name),1);
            $next_delete_group_name = array_diff($next_delete_group_name, array('기술본부'));
          }


          //금주 insert/update/delete
          // echo count($next_insert_group_name).' '.count($next_update_group_name).' '.count($next_delete_group_name);
          // var_dump($current_insert_group_name);
          // var_dump($current_update_group_name);
          // var_dump($current_delete_group_name);

          if(count($current_insert_group_name)>0){
            foreach ($current_insert_group_name as $cign) {
              //해당 일정으로 등록된 주간업무보고가 없으므로 insert진행
              //주간업무보고의 마지막 tech_seq값의 -1 한 값을 가져오기
              $tech_seq = $this->STC_Schedule->check_tech_seq(); //금주
              $tech_seq = $tech_seq->m1;
              //작성값을 넣을 차주 주간보고서 정보 가져오기
              $check_report2 = $this ->STC_Schedule->check_report($startDay, $cign);
              if($check_report2 != 'false'){
                $report_seq = $check_report2->seq;
                $year = $check_report2->year;
                $month = $check_report2->month;
                $week = $check_report2->week;
                $data = array(
                  'tech_seq'    => $tech_seq,
                  'schedule_seq'=> $seq,
                  'contents_num'=> $contents_num,
                  'group_name'  => $cign,
                  'customer'    => $customer,
                  'visit_company'    => $visit_company,
                  'subject'     => $contents,
                  'writer'      => $participant,
                  'report_seq'  => $report_seq,
                  'year'        => $year,
                  'month'       => $month,
                  'week'        => $week,
                  'income_time' => $startDay,
                  'insert_time' => date("Y-m-d H:i:s")
                );
                if($writer_pgroup == '기술본부'){
                  $data['work_name'] = $workname;
                }
                $this->STC_Schedule->insert_current_week_doc($data);
              }
            }
          }
          if(count($current_update_group_name)>0){
            foreach ($current_update_group_name as $cugn) {
              //해당 일정으로 등록된 주간업무보고가 있을 경우 update
              //작성값을 넣을 차주 주간보고서 정보 가져오기
              $check_report2 = $this ->STC_Schedule->check_report($startDay, $cugn);
              if($check_report2 != 'false'){
                //등록된 주간업무보고가 입력하려는 그룹과 일치할 때 업데이트
                $data = array(
                  'schedule_seq' => $seq,
                  'contents_num' => $contents_num,
                  'group_name'   => $cugn,
                  'work_name'    => $workname,
                  'customer'     => $customer,
                  'visit_company'     => $visit_company,
                  'writer'       => $participant,
                  'subject'      => $contents,
                  'income_time'  => $startDay,
                  'update_time'  => date("Y-m-d H:i:s")
                );
                $this->STC_Schedule->update_current_week_doc($data);
              }
            }
          }
          if(count($current_delete_group_name)>0){
            foreach ($current_delete_group_name as $cdgn) {
              //등록된 주간업무보고가 입력하려는 그룹과 일치하지 않으면 주간업무보고 삭제
              if($cdgn <> 'false'){
                $group_name = $cdgn;
                $this->STC_Schedule->delete_current_week_doc($group_name,$seq,'false');
              }
            }
          }

          if(count($current_delete_group_name)==0 && count($current_update_group_name)==0 && count($current_insert_group_name)==0){
            $this->STC_Schedule->delete_current_week_doc('false',$seq,$contents_num);
          }

          // 차주 insert/update/delete
          // echo count($next_insert_group_name).' '.count($next_update_group_name).' '.count($next_delete_group_name);
          // var_dump($next_insert_group_name);
          // var_dump($next_update_group_name);
          // var_dump($next_delete_group_name);

          if(count($next_insert_group_name)>0){
            foreach ($next_insert_group_name as $nign) {
              // echo 'count:'.count($next_insert_group_name).' val:'.$nign;
              //해당 일정으로 등록된 주간업무보고가 없으므로 insert진행
              //주간업무보고의 마지막 tech_seq값의 -1 한 값을 가져오기
              $tech_seq2 = $this->STC_Schedule->check_tech_seq2(); //차주
              $tech_seq2 = $tech_seq2->m1;
              //작성값을 넣을 차주 주간보고서 정보 가져오기
              $before_day =  date("Y-m-d", strtotime($startDay." -7day"));
              $check_report3 = $this ->STC_Schedule->check_report($before_day, $nign);
              // echo $check_report3.' - '.$before_day.' - '.$nign;
              if($check_report3 != 'false'){
                // echo $before_day.' - '.$nign;
                $report_seq = $check_report3->seq;
                $year = $check_report3->year;
                $month = $check_report3->month;
                $week = $check_report3->week;
                $data = array(
                  'tech_seq'     => $tech_seq2,
                  'schedule_seq' => $seq,
                  'contents_num' => $contents_num,
                  'group_name'   => $nign,
                  'work_name'    => $workname,
                  'customer'     => $customer,
                  'visit_company'     => $visit_company,
                  'subject'      => $contents,
                  'writer'       => $participant,
                  'report_seq'   => $report_seq,
                  'year'         => $year,
                  'month'        => $month,
                  'week'         => $week,
                  'income_time'  => $startDay,
                  'insert_time'  => date("Y-m-d H:i:s")
                );
                $this->STC_Schedule->insert_next_week_doc($data);
              }
            }
          }
          if(count($next_update_group_name)>0){
            foreach ($next_update_group_name as $nugn) {
              //해당 일정으로 등록된 주간업무보고가 있을 경우 update
              //작성값을 넣을 차주 주간보고서 정보 가져오기
              $before_day =  date("Y-m-d", strtotime($startDay." -7day"));
              $check_report3 = $this ->STC_Schedule->check_report($before_day, $nugn);
              if($check_report3 != 'false'){
                //등록된 주간업무보고가 입력하려는 그룹과 일치할 때 업데이트
                $data = array(
                  'schedule_seq' => $seq,
                  'contents_num' => $contents_num,
                  'group_name'   => $nugn,
                  'work_name'    => $workname,
                  'customer'     => $customer,
                  'visit_company'     => $visit_company,
                  'writer'       => $participant,
                  'subject'      => $contents,
                  'income_time'  => $startDay,
                  'update_time'  => date("Y-m-d H:i:s")
                );
                $this->STC_Schedule->update_next_week_doc($data);
              }
            }
          }
          if(count($next_delete_group_name)>0){
            foreach ($next_delete_group_name as $ndgn) {
              //등록된 주간업무보고가 입력하려는 그룹과 일치하지 않으면 주간업무보고 삭제
              if($ndgn <> 'false'){
                $group_name = $ndgn;
                $this->STC_Schedule->delete_next_week_doc($group_name,$seq,'false');
              }
            }
          }
          if(count($next_delete_group_name)==0 && count($next_update_group_name)==0 && count($next_insert_group_name)==0){
            $this->STC_Schedule->delete_next_week_doc('false',$seq,$contents_num);
          }

        }else if($weekly_report == "N"){ //tech와 lab이 무조건 y이니까 n은 영업/경영일정밖에 없다 = general일정 중 n인 일정
        // }else if($work_type != 'tech' && $weekly_report == "N"){ //general일정이고 weekly_report가 n일 경우
          $this->STC_Schedule->delete_current_week_doc('false',$seq,$contents_num);
          $this->STC_Schedule->delete_next_week_doc('false',$seq,$contents_num);
        }
    //내용분할1
      }
    }
    //내용분할2

  }

  //KI1 20210208_modify 분리
  function delete(){
    $seq = $this->input->post('seq');
    $recurring_modify_choose = $this->input->post('recurring_modify_choose');
    $recurring_seq = $this->input->post('recurring_seq');

    $written_rep_cnt = $this->STC_Schedule->written_rep_cnt($seq)->cnt;
    if ($written_rep_cnt > 0){
      echo json_encode("report_written");
      return false;
    }

    if($recurring_modify_choose == 'all_sch'){
      $sql = "SELECT seq FROM tech_schedule_list WHERE recurring_seq = {$recurring_seq}";
      $query = $this->db->query($sql);
      $result_seq = $query->result_array();
      foreach ($result_seq as $row) {
        $result = $this->STC_Schedule->schedule_delete($row['seq']);
      }
      // $result = $this->STC_Schedule->schedule_delete($seq, $recurring_seq);
    }else if($recurring_modify_choose == 'forward_sch'){
      $sql = "SELECT seq FROM tech_schedule_list WHERE recurring_seq = {$recurring_seq} AND seq >= {$seq}";
      $query = $this->db->query($sql);
      $result_seq = $query->result_array();
      foreach ($result_seq as $row) {
        $result = $this->STC_Schedule->schedule_delete($row['seq']);
      }
      // $result = $this->STC_Schedule->schedule_delete($seq);
    }else if($recurring_modify_choose == 'only_this_sch' || $recurring_modify_choose == null){
      $result = $this->STC_Schedule->schedule_delete($seq);
    }


    // $result = $this->STC_Schedule->schedule_delete($seq);
    echo json_encode($result);
    $this->STC_Schedule->delete_next_week_doc('false',$seq,'false');
    $this->STC_Schedule->delete_current_week_doc('false',$seq,'false');
    // redirect("/biz/schedule/tech_schedule", "refresh") ;
  }
  //KI2 20210208_modify 분리


// BH 일정 추가
  function add_schedule(){
    // $this->output->enable_profiler(TRUE);


    $startDay = $this->input->post('startDay');
    $startTime = $this->input->post('startTime');
    $endDay = $this->input->post('endDay');
    $endTime = $this->input->post('endTime');
    $work_type = $this->input->post('work_type');
    $workname = $this->input->post('workname');

    $room_name = $this->input->post('room_name');
    $car_name = $this->input->post('car_name');
    $outside_work = $this->input->post('outside_work'); // 직출 추가
    // $de_outside_work = $this->input->post('de_outside_work');

    //KI1 20210125 고색사 포캐스팅형으로 변경하여 새로 추가되는 부분
    // $customer = $this->input->post('customer');

    if($work_type == "general"){
      if($this->input->post('customer2') == '' || $this->input->post('customer2') == null){
        $customer = '';
      }else{
        $customer = $this->input->post('customer2');
      }
    }else if($work_type == "tech"){
      $customer = $this->input->post('customer');
    }else{
      $customer = '';
    }

    $project = $this->input->post('project');

    if($this->input->post('forcasting_seq') == ''){
      $forcasting_seq = null;
    }else{
      $forcasting_seq = $this->input->post('forcasting_seq');
    }

    if($this->input->post('maintain_seq') == ''){
      $maintain_seq = null;
    }else{
      $maintain_seq = $this->input->post('maintain_seq');
    }
      // $customer_manager = $this->input->post('customer_manager');
      //KI2 20210125
    $supportMethod = $this->input->post('supportMethod');

      //주간업무보고
      // $weekly_report = $this->input->post('weekly_report');

      //공지사항
    if($work_type === 'company'){
      $participant = "";
      $participant_seq = "";
    }else{
      // if($this->input->post('participant') == '' || $this->input->post('participant') == null){
      //   $participant = $this->name;
      // }else{
      //   $participant = $this->input->post('participant');
      // }
      $participant_val = $this->input->post('participant');
      $participant_val_arr = explode(',',$participant_val);
      $participant = array();
      $participant_seq = array();
      foreach ($participant_val_arr as $arr) {
        $val = explode('_',$arr);
        $name_val = $val[0];
        $seq_val = $val[1];
        // $name_val = explode('_',$arr)[0];
        // $seq_val = explode('_',$arr)[1];
        array_push($participant, $name_val);
        array_push($participant_seq, $seq_val);
      }
      $participant = implode(',',$participant);
      $participant_seq = implode(',',$participant_seq);
    }

    //내용분할1
    //일장 내영 분할 tech_schedule_contents 입력용
    $contents_arr = $this->input->post('contents');

    //일정 내용 분할 tech_schedule_list 입력용
    // $contents = $this->input->post('contents');

    // if(!empty($contents_arr)){
    //   $contents_length = count($contents_arr);
    //   $contents = "";
    //   for($i=0; $i<$contents_length; $i++){
    //     if($contents == ""){
    //       $contents = $contents_arr[$i]['contents'];
    //     }else{
    //       $contents = $contents.';@;'.$contents_arr[$i]['contents'];
    //     }
    //   }
    // }
    //내용분할2

    $title = $this->input->post('title');
    $place = $this->input->post('place');
    $visit_company = $this->input->post('visitCompany');
    $curday = date("Y-m-d");
    $user_id = $this->id;
    $my_group = $this->STC_Schedule->my_group($user_id)->user_group;

    //비공개일정
    $nondisclosure = $this->input->post('nondisclosure');
    if($nondisclosure === 'Y'){
      // $participant = $this->name;
      $room_name = "";
      $car_name = "";
    }

    //recurring 반복일정
    $recurring_date = $this->input->post('recurring_date');
    $recurring_setting = $this->input->post('recurring_setting');

    if(is_array($recurring_date) || is_object($recurring_date)){
      $recurring_date_length = sizeof(($recurring_date));
    }else{
      $recurring_date_length = 0;
    }


    // // $this->load->Model('stc_schedule');
    // $writer = preg_replace("/\s+/", "", $participant);
    // $writer = explode( ',', $writer );
    // $num = count($writer);

    $data = array(
      // 'start_day'       => $startDay,
      'start_time'      => $startTime,
      'end_day'         => $endDay,
      'end_time'        => $endTime,
      'work_type'       => $work_type,
      'work_name'       => $workname,
      'room_name'       => $room_name,
      'car_name'        => $car_name,
      'outside_work'    => $outside_work,  // 직출 추가
      //KI1 20210125 고객사 포캐스팅형으로 변경하여 새로 추가되는 부분
      'customer'        => $customer,
      'visit_company'        => $visit_company,
      'project'         => $project,
      'forcasting_seq'  => $forcasting_seq,
      'maintain_seq'    => $maintain_seq,
      // 'customer_manager' => $customer_manager,
      //KI2 20210125
      'support_method'  => $supportMethod,
      'participant'     => $participant,
      'participant_seq' => $participant_seq,
      'title'           => $title,
      'place'           => $place,
      // 'contents' => $contents,
      'user_id'         => $user_id,
      'user_name'       => $this->name,
      'group'           => $my_group,
      'p_group'         => $this->pGroupName,
      // 'weekly_report' => $weekly_report,
      'nondisclosure'   => $nondisclosure
      // 'tech_report' => 'N',
    );

    // $date_diff = date_diff($startDay, $endDay);
    // if( 0 < $date_diff ){
    //
    //   if( 0 < $recurring_date_length ){
    //     $data['recurring_date'] = $recurring_date;
    //     $data['end_day'] = $recurring_date;
    //   }else{
    //     $data['recurring_date'] = $startDay;
    //     $data['end_day'] = $endDay;
    //   }
    // }else{

    if( 0 < $recurring_date_length ){
      $data['recurring_date'] = $recurring_date;
      $data['recurring_setting'] = $recurring_setting;
    }else{
      $data['recurring_date'] = $startDay;
    }
    // }

    if ($work_type == 'tech'){
      $report_cnt = abs(strtotime($startDay) - strtotime($endDay))/60/60/24+1;
      if($report_cnt > 1 ){
        $report_cnt = 1;
      }
      $data['tech_report'] = $report_cnt;
    }




    if(is_array($data['recurring_date']) || is_object($data['recurring_date'])){
      $recurring_date_length = sizeof($data['recurring_date']);
    }else{
      $recurring_date_length = 0;
    }
    $recurring_date = $data['recurring_date'];
    if( 0 < $recurring_date_length ){
      $recurring_seq = null;
      //시작 날짜와 끝나는 날짜 차이값 구하기
      $date_diff_num = 0;
      // $date_diff_num = intval($date_diff->days);

      for($i = 0; $i < $recurring_date_length; $i++){
        $data['recurring_count'] = $i;
        $data['start_day'] = $recurring_date[$i];

        if($i == 0){
          $start = new DateTime($data['start_day']);
          $end = new DateTime($data['end_day']);
          $date_diff = date_diff($start, $end);
          $date_diff_num = (int)$date_diff->days;
          if( 0 < $date_diff_num){ //일정이 이틀 이상일 때
            $data['end_day'] = date("Y-m-d",strtotime("{$data['start_day']} +{$date_diff_num} day"));
            // $data['end_day'] = date("Y-m-d",strtotime("+{$date_diff_num} day", time($data['start_day'])));
          }else{ //일정이 하루일 때
            $data['end_day'] = $data['start_day'];
          }

          // //recurring_seq의 값은 일정seq와 같게할 것이기 때문에 일정이 등록되기 전에 미리
          $sql = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'tech_schedule_list' AND table_schema = DATABASE( )";
          $query = $this->db->query($sql)->row();
          $recurring_seq = $query->AUTO_INCREMENT;
          $data['recurring_seq'] = $recurring_seq;

          unset($data['recurring_date']); //data에서 recurring_seq 값 제외
          array_values($data);

        }else{
          if( 0 < $date_diff_num){ //일정이 이틀 이상일 때
            $data['end_day'] = date("Y-m-d",strtotime("{$data['start_day']} +{$date_diff_num} day"));
            // $data['end_day'] = date("Y-m-d",strtotime("+{$date_diff_num} day", time($data['start_day'])));
          }else{ //일정이 하루일 때
            $data['end_day'] = $data['start_day'];
          }

          $data['recurring_seq'] = $recurring_seq;

          unset($data['recurring_date']); //data에서 recurring_seq 값 제외
          array_values($data);
        }

        $result = $this->STC_Schedule->schedule_insert($data, $contents_arr);
      }
    }else if( $recurring_date_length == 0 ){
      $data['start_day'] = $data['recurring_date'];
      unset($data['recurring_date']); //data에서 recurring_seq 값 제외
      array_values($data); //unset으로 빵꾸난 $data의 index 재정렬
      $result = $this->STC_Schedule->schedule_insert($data, $contents_arr);
    }
    // $result = $this->STC_Schedule->schedule_insert($data, $contents_arr);
    echo json_encode($result);

    // //내용분할1 일정 내용 분할 저장
    // $this->STC_Schedule->schedule_contents_insert($contents_arr);

     //주간업무보고서 내용
    if(!empty($contents_arr)){
      $contents='';

      // $weekly_report = "N";
      // $contents_length = count($contents_arr);
      // for($i=0; $i<$contents_length; $i++){
      //   $weekly_report_val = $contents_arr[$i]['weekly_report'];
      //   $contents_val = $contents_arr[$i]['contents'];
      //
      //   if($weekly_report_val == "Y"){
      //     if($contents == ''){
      //       $contents = $contents_val;
      //     }else{
      //       $contents = $contents.'<br>'.$contents_val;
      //     }
      //     $weekly_report = "Y"; //하나라도 Y가 있으면 Y로 한다.
      //   }
      //
      // }

      $weekly_report='';
      $contents_num = '';
      $contents_length = count($contents_arr);
      for($k=0; $k<$contents_length; $k++){
        $weekly_report = $contents_arr[$k]['weekly_report'];
        $contents = $contents_arr[$k]['contents'];
        $contents_num = $contents_arr[$k]['contents_num'];

        //기술연구소 주간보고 연동
        if($work_type == 'lab'){
          $data_lab1 = array(
            'contents_num' => $contents_num,
            'group_name'   => '기술연구소',
            'produce'      => $title,
            'writer'       => $participant,
            'income_time'  => $startDay,
            'insert_time'  => date("Y-m-d H:i:s")
          );

          $val_arr = explode(',,,',$contents);
          $val_arr_length = count($val_arr);
          for($p = 0; $p < $val_arr_length; $p++){
            $val_arr2 = explode(':::', $val_arr[$p]);
            $val_arr_key = $val_arr2[0];
            $val_arr_value = $val_arr2[1];

            if($val_arr_key == 'dev_type'){

              $data_lab1['work_name'] = $val_arr_value;

            }else if($val_arr_key == 'dev_page'){

              $data_lab1['customer'] = $val_arr_value;

            }else if($val_arr_key == 'dev_requester'){

              $data_lab1['type'] = $val_arr_value;

            }else if($val_arr_key == 'dev_develop'){

              $data_lab1['subject'] = $val_arr_value;

            }else if($val_arr_key == 'dev_complete'){

              if($val_arr_value == 'Y'){
                $data_lab1['result'] = '완료';
                $data_lab1['completion_time'] = $endDay;
              }else{
                $data_lab1['result'] = '미완료';
                $data_lab1['completion_time'] = null;
              }

            }
          }

          //작성된 금주 주간보고서가 있는지 확인
          $check_report2 = $this ->STC_Schedule->check_report($startDay, '기술연구소');
          if($check_report2 != 'false'){
            //금주 주간보고서가 있으면 입력할 값 받아오기
            //주간업무보고의 마지막 tech_seq값의 -1 한 값을 가져오기
            $tech_seq = $this->STC_Schedule->check_tech_seq(); //금주
            $tech_seq = $tech_seq->m1;
            //작성값을 넣을 금주 주간보고서 정보 가져오기
            $report_seq = $check_report2->seq;
            $year = $check_report2->year;
            $month = $check_report2->month;
            $week = $check_report2->week;
            $data_lab2 = array(
              'tech_seq'   => $tech_seq,
              'report_seq' => $report_seq,
              'year'       => $year,
              'month'      => $month,
              'week'       => $week,
            );
            $data = array_merge($data_lab1, $data_lab2);
            $this->STC_Schedule->insert_current_week_doc($data);
          }


          //작성된 차주 주간보고서가 있는지 확인
          $before_day =  date("Y-m-d", strtotime($startDay." -7day"));
          $check_report1 = $this ->STC_Schedule->check_report($before_day, '기술연구소');
          if($check_report1 != 'false'){
            //차주 주간보고서가 있으면 입력할 값 받아오기
            //주간업무보고의 마지막 tech_seq값의 -1 한 값을 가져오기
            $tech_seq2 = $this->STC_Schedule->check_tech_seq2(); //차주
            $tech_seq2 = $tech_seq2->m1;
            //작성값을 넣을 차주 주간보고서 정보 가져오기
            $report_seq = $check_report1->seq;
            $year = $check_report1->year;
            $month = $check_report1->month;
            $week = $check_report1->week;
            $data_lab2 = array(
              'tech_seq'   => $tech_seq2,
              'report_seq' => $report_seq,
              'year'       => $year,
              'month'      => $month,
              'week'       => $week,
            );
            unset($data_lab1['result']);
            array_values($data_lab1); //unset으로 빵꾸난 $data_lab1의 index 재정렬
            $data = array_merge($data_lab1, $data_lab2);
            $this->STC_Schedule->insert_next_week_doc($data);
          }

        }

      //내용분할2

        //기술연구소 주간보고 연동
        if($weekly_report == "Y" && $work_type != 'lab'){
        // if($work_type == 'tech' || ($weekly_report == "Y" && $work_type != 'lab')){
        // if($work_type == 'tech' || $weekly_report == "Y"){
          $writer = preg_replace("/\s+/", "", $participant);
          $writer = explode( ',', $writer );
          $num = count($writer);
          $group_arr = array();
          for ($i=0; $i < $num ; $i++) {
            $linker = $writer[$i];
            $linker_data = $this->STC_Schedule->linker_group($linker);
            if($linker_data != 'false'){
              array_push($group_arr, $linker_data);
            }

          }
          // 그룹 중복제거
          // $group_arr = array_unique($group_arr);
          // 배열의 키값 초기화
          // $group_arr = array_values($group_arr);
          // $group_num = count($group_arr);

          // //user_group 컬럼만으로 새배열 생성
          // $group_arr_c = array_column($group_arr, 'user_group');
          // //group_arr_c 배열의 중복제거(user_group의 중복이 제거됨)
          // $group_arr_u = array_unique($group_arr_c);
          // //user_group중복이 제거되고 key와 value값이 살아있는 상태로 새배열 생성
          // $group_arr = array_filter($group_arr, function ($key, $value) use ($group_arr_u) {
          //      return in_array($value, array_keys($group_arr_u));
          // }, ARRAY_FILTER_USE_BOTH);

          // 그룹 중복제거
          //php버전 5대에서 array_column 사용 가능하도록 하는 함수
          if (! function_exists('array_column')) {
            function array_column(array $input, $columnKey, $indexKey = null) {
              $array = array();
              foreach ($input as $value) {
                if ( !array_key_exists($columnKey, $value)) {
                  trigger_error("Key \"$columnKey\" does not exist in array");
                  return false;
                }
                if (is_null($indexKey)) {
                  $array[] = $value->$columnKey;
                } else {
                  if ( !array_key_exists($indexKey, $value)) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                  }
                  if ( ! is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                  }
                  $array[$value[$indexKey]] = $value[$columnKey];
                }
              }
              return $array;
            }
          }
          $temp = array_unique(array_column($group_arr, 'user_group'));
          $group_arr = array_intersect_key($group_arr, $temp);


          foreach ($group_arr as $group_arr2) {
            $writer_group = $group_arr2->user_group;
            $writer_pgroup = $group_arr2->parentGroupName;
            //기술연구소 주간보고 연동
            // if($writer_group <> '기술연구소'){
            //기술연구소 주간보고 연동
              // $writer_group = $group_arr[$i];
              //작성된 차주 주간보고서가 있는지 확인
              $before_day =  date("Y-m-d", strtotime($startDay." -7day"));
              $check_report = $this ->STC_Schedule->check_report($before_day, $writer_group);
              if($check_report != 'false'){
                //차주 주간보고서가 있으면 입력할 값 받아오기
                //주간업무보고의 마지막 tech_seq값의 -1 한 값을 가져오기
                $tech_seq2 = $this->STC_Schedule->check_tech_seq2(); //차주
                $tech_seq2 = $tech_seq2->m1;
                //작성값을 넣을 차주 주간보고서 정보 가져오기
                $report_seq = $check_report->seq;
                $year = $check_report->year;
                $month = $check_report->month;
                $week = $check_report->week;
                $data = array(
                  'tech_seq'     => $tech_seq2,
                  'contents_num' => $contents_num,
                  'group_name'   => $writer_group,
                  'work_name'    => $workname,
                  'customer'     => $customer,
                  'visit_company'     => $visit_company,
                  'subject'      => $contents,
                  'writer'       => $participant,
                  'report_seq'   => $report_seq,
                  'year'         => $year,
                  'month'        => $month,
                  'week'         => $week,
                  'income_time'  => $startDay,
                  'insert_time'  => date("Y-m-d H:i:s")
                );
                // if($writer_pgroup == '기술본부'){
                //   $data['work_name'] = $workname;
                // }
                $this->STC_Schedule->insert_next_week_doc($data);
                // $this->STC_Schedule->insert_next_week_doc($tech_seq, $workname, $customer, $writer_group, $participant, $startDay, $contents, $report_seq, $year, $month, $week, $writer_pgroup);
              }
            //기술연구소 주간보고 연동
            // }
            //기술연구소 주간보고 연동
          };

          //미리 생성된 이번주 주간보고서에도 이번주 등록한 내용이 들어가도록
          // for ($i=0; $i<$group_num; $i++) {
          foreach ($group_arr as $group_arr3) {
            $writer_group = $group_arr3->user_group;
            $writer_pgroup = $group_arr3->parentGroupName;
            if($writer_pgroup <> '기술본부'){
              //작성된 금주 주간보고서가 있는지 확인
              $check_report = $this ->STC_Schedule->check_report($startDay, $writer_group);
              if($check_report != 'false'){
                //금주 주간보고서가 있으면 입력할 값 받아오기
                //주간업무보고의 마지막 tech_seq값의 -1 한 값을 가져오기
                $tech_seq = $this->STC_Schedule->check_tech_seq(); //금주
                $tech_seq = $tech_seq->m1;
                //작성값을 넣을 금주 주간보고서 정보 가져오기
                $report_seq = $check_report->seq;
                $year = $check_report->year;
                $month = $check_report->month;
                $week = $check_report->week;
                $data = array(
                  'tech_seq'     => $tech_seq,
                  'contents_num' => $contents_num,
                  'group_name'   => $writer_group,
                  'work_name'    => $workname,
                  'customer'     => $customer,
                  'visit_company'     => $visit_company,
                  'subject'      => $contents,
                  'writer'       => $participant,
                  'report_seq'   => $report_seq,
                  'year'         => $year,
                  'month'        => $month,
                  'week'         => $week,
                  'income_time'  => $startDay,
                  'insert_time'  => date("Y-m-d H:i:s")
                );
                $this->STC_Schedule->insert_current_week_doc($data);
              }
            };
          }

        }
    //내용분할1
      }
    }
   //내용분할2

  }

  // B일정 상세보기
  function tech_schedule_detail(){
    // $this->output->enable_profiler(TRUE);
    if( $this->id === null ) {
          redirect( 'account' );
    }

    $data['session_id'] = $this->id;
    $data['session_name'] = $this->name;
    $data['login_pgroup'] = $this->pGroupName;
    $data['login_gruop'] = $this->group;
    $data['login_user_duty'] = $this->STC_Schedule->login_user_duty($this->id)->user_duty;
        //패치 전 수정
    //     if($pGroupName != 'CEO' && $pGroupName != '기술본부'){
    //   echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
    // }

    $seq = $this->input->get('seq');

    // $this->load->Model('stc_schedule');
    // // $this->load->Model(array('STC_tech_doc','STC_schedule'));
  //KI2 20210125

    $data['details'] = $this->STC_Schedule->details($seq);
    //내용분할1
    $data['contents'] = $this->STC_Schedule->details_contents($seq);
    //내용분할2
    // $custo = $data['details']->customer;
    // $data['direct_yn'] = $this ->STC_Schedule->direct_check($custo);

    //KI1 20210125 고객사를 불러오는 부분
    // $data['customer'] = $this->stc_stc_schedule->customer_list();
    // $data['customer'] = $this->STC_tech_doc->get_customer();
    //이게 유지보수에서
    // $data['customer'] = $this->STC_Schedule->get_customer();
    $data['customer'] = $this->STC_Schedule->get_customer3();
    //나머지는 납품 데모 미팅? 일때 포캐스팅에서
    $data['customer2'] = $this->STC_Schedule->get_customer2();
    //KI2 20210125
    $data['search_customer'] = $this->STC_Schedule->ser_customer();


    // $result = $this->STC_Schedule->group_list();
    $data['work_name'] = $this->STC_Schedule->group_list();
    //////////////////KI
    $data['parentGroup'] = $this->STC_Schedule->parentGroup();
    $data['user_group'] = $this->STC_Schedule->user_group();
    $data['userInfo'] = $this->STC_Schedule->userInfo();
    $data['userDepth'] = $this->STC_Schedule->userDepth();
  //////////////////////////
    // $data['login_gruop'] = $this->input->get('login_group');
    // $data['login_pgroup'] = $this->input->get('login_pgroup');
    // $data['login_user_duty'] = $this->input->get('login_user_duty');


    echo json_encode($data);
    // $this->load->view('biz/tech_schedule_detail', $data);

  }

  //근무품의서 작성여부 확인
  function create_document() {
    $seq = $this->input->post('seq');
    // $data['trip'] = $this->STC_Schedule->trip_document($seq);
    // $data['night'] = $this->STC_Schedule->night_document($seq);
    // 20220622 주석처리 / 문제없을시 삭제
    $data['weekend'] = $this->STC_Schedule->weekend_document($seq);
    echo json_encode($data);
  }

// BH 일정 드래그시 날짜 업데이트
  function drop_update(){
    $seq = $this->input->post("seq");
    $start_day = $this->input->post("start_day");
    $start_time = $this->input->post("start_time");
    $end_day = $this->input->post("end_day");
    $end_time = $this->input->post("end_time");
    $participant = $this->input->post("participant");
    $modifyDay = date("Y-m-d H:i:s");
    $data = array(
      'seq'           => $seq,
      'start_day'     => $start_day,
      'start_time'    => $start_time,
      'end_day'       => $end_day,
      'end_time'      => $end_time,
      'modifier_id'   => $this->id,
      'modifier_name' => $this->name,
      'modify_date'   => $modifyDay
    );
    $written_rep_cnt = $this->STC_Schedule->written_rep_cnt($seq)->cnt;
    if ($written_rep_cnt > 0){
      echo "report_written";
      return false;
    }

    // $work_type = $this->STC_Schedule->details($seq)->work_type;
    // $before_sday = $this->STC_Schedule->details($seq)->start_day;
    // $before_eday = $this->STC_Schedule->details($seq)->end_day;
    // if ($work_type=='tech'){
    //   if ($start_day != $before_sday || $end_day != $before_eday){
    //     $report_cnt = abs(strtotime($start_day) - strtotime($end_day))/60/60/24+1;
    //     if($report_cnt > 1 ){
    //       $report_cnt = 1;
    //     }
    //     $data['tech_report'] = $report_cnt;
    //     // $written_rep_cnt = $this->STC_Schedule->written_rep_cnt($seq)->cnt;
    //     // $data['tech_report'] = $report_cnt - $written_rep_cnt;
    //   }
    // }

    $approval_yn = $this->STC_Schedule->sch_report_approval($seq);
    // echo $approval_yn;
    if($approval_yn == 'Y'){
      echo "<script>alert('주간업무보고 결제가 완료된 일정은 수정할 수 없습니다.');return false';</script>";
    }else{

      //주간업무보고서부분
      // 이동한 날짜의 주간업무보고서가 있는지 확인해서 있으면 해당 report_seq로 update 없으면 next_weekly에서 삭제
      $writer = preg_replace("/\s+/", "", $participant);
      $writer = explode( ',', $writer );
      $num = count($writer);
      $group_arr = array();
      for ($i=0; $i < $num ; $i++) {
        $linker = $writer[$i];
        $linker_data = $this->STC_Schedule->linker_group($linker);
        if($linker_data != 'false'){
          array_push($group_arr, $linker_data);
        }
      }

      //php버전 5대에서 array_column 사용 가능하도록 하는 함수
      if (! function_exists('array_column')) {
        function array_column(array $input, $columnKey, $indexKey = null) {
          $array = array();
          foreach ($input as $value) {
            if ( !array_key_exists($columnKey, $value)) {
              trigger_error("Key \"$columnKey\" does not exist in array");
              return false;
            }
            if (is_null($indexKey)) {
              $array[] = $value->$columnKey;
            }
            else {
              if ( !array_key_exists($indexKey, $value)) {
                trigger_error("Key \"$indexKey\" does not exist in array");
                return false;
              }
              if ( ! is_scalar($value[$indexKey])) {
                trigger_error("Key \"$indexKey\" does not contain scalar value");
                return false;
              }
              $array[$value[$indexKey]] = $value[$columnKey];
            }
          }
          return $array;
        }
      }
      $temp = array_unique(array_column($group_arr, 'user_group'));
      $group_arr = array_intersect_key($group_arr, $temp);

      foreach ($group_arr as $group_arr4) {

        $writer_group = $group_arr4->user_group;
        $writer_pgroup = $group_arr4->parentGroupName;

        //일정 이동 후 주간보고서, 이동 전 주간보고서 seq 찾기
        // $a_c_check_report = $this ->STC_Schedule->check_report($start_day, $writer_group); // 이동 후 주간보고서 seq
        // $before_day =  date("Y-m-d", strtotime($start_day." -7day"));
        // $b_c_check_report = $this ->STC_Schedule->check_report($before_day, $writer_group); // 이동 후의 전주 주간보고서 seq
        // $after_day =  date("Y-m-d", strtotime($start_day." +7day"));
        // $a_c_a_check_report = $this ->STC_Schedule->check_report($after_day, $writer_group); // 이동 후의 차주 주간보고서 seq

        //20210503 변경
        $check_sch_next_report = $this->STC_Schedule->check_next_week_doc($seq);
        $current_report = $this ->STC_Schedule->check_report($start_day, $writer_group); // 이동 후 주간보고서 seq
        $check_sch_current_report = $this->STC_Schedule->check_current_week_doc($seq);

        if($check_sch_current_report == 'false'){ //테이블에 해당 일정 seq로 등록된 내용이 없을 때
          if($current_report != 'false'){ //내용을 넣으려는 주에 생성된 보고서가 없을 때
            //내용을 넣으려는 주에 생성된 보고서가 있을 때
            //주간업무보고의 마지막 tech_seq값의 -1 한 값을 가져오기
            $tech_seq = $this->STC_Schedule->check_tech_seq(); //금주
            $tech_seq = $tech_seq->m1;
            //작성값을 넣을 금주 주간보고서 정보 가져오기
            $report_seq = $current_report->seq;
            $year = $current_report->year;
            $month = $current_report->month;
            $week = $current_report->week;

            $data2 = array(
              'seq'         => $seq,
              'tech_seq'    => $tech_seq,
              'report_seq'  => $report_seq,
              'year'        => $year,
              'month'       => $month,
              'week'        => $week,
              'group_name'  => $writer_group,
              'income_time' => $start_day
            );
            // array_merge($data, $data2);
            $this->STC_Schedule->date_insert_current_week_doc($data2);
          }
        }else{ //테이블에 해당 일정 seq로 등록된 내용이 있을 때
          if($current_report == 'false'){ //내용을 넣으려는 주에 생성된 보고서가 없을 때
            $this->STC_Schedule->date_delete_current_week_doc($seq,$writer_group);
          }else{ //내용을 넣으려는 주에 생성된 보고서가 있을 때
            //작성값을 넣을 금주 주간보고서 정보 가져오기
            $report_seq = $current_report->seq;
            $year = $current_report->year;
            $month = $current_report->month;
            $week = $current_report->week;
            $data2 = array(
              'seq'         => $seq,
              'report_seq'  => $report_seq,
              'year'        => $year,
              'month'       => $month,
              'week'        => $week,
              'income_time' => $start_day,
              'update_time' => date("Y-m-d H:i:s")
            );
            // array_merge($data, $data2);
            $this->STC_Schedule->date_update_current_week_doc($data2);
          }
        }

        $before_day =  date("Y-m-d", strtotime($start_day." -7day"));
        $next_report = $this ->STC_Schedule->check_report($before_day, $writer_group); // 이동 후의 차주 주간보고서 seq
        $check_sch_next_report = $this->STC_Schedule->check_next_week_doc($seq); //그룹이름

        if($check_sch_next_report == 'false'){ //테이블에 해당 일정 seq로 등록된 내용이 없을 때
          if($next_report != 'false'){ //내용을 넣으려는 주에 생성된 보고서가 없을 때
            //내용을 넣으려는 주에 생성된 보고서가 있을 때
            //주간업무보고의 마지막 tech_seq값의 -1 한 값을 가져오기
            $tech_seq2 = $this->STC_Schedule->check_tech_seq2(); //차주
            $tech_seq2 = $tech_seq2->m1;
            //작성값을 넣을 금주 주간보고서 정보 가져오기
            $report_seq = $next_report->seq;
            $year = $next_report->year;
            $month = $next_report->month;
            $week = $next_report->week;
            $data2 = array(
              'seq'         => $seq,
              'tech_seq'    => $tech_seq2,
              'report_seq'  => $report_seq,
              'year'        => $year,
              'month'       => $month,
              'week'        => $week,
              'group_name'  => $writer_group,
              'income_time' => $start_day
            );
            // array_merge($data, $data2);
            $this->STC_Schedule->date_insert_next_week_doc($data2);
          }
        }else{ //테이블에 해당 일정 seq로 등록된 내용이 있을 때
          for($i = 0; $i < COUNT($check_sch_next_report); $i++){
            $check_next_week_group_name = $check_sch_next_report[$i]->group_name;
            $next_report = $this ->STC_Schedule->check_report($before_day, $check_next_week_group_name); // 이동 후의 차주 주간보고서 seq
            // var_dump($next_report);

            if($next_report == 'false'){ //내용을 넣으려는 주에 생성된 보고서가 없을 때
              $this->STC_Schedule->date_delete_next_week_doc($seq,$next_report->group_name);
              // $this->STC_Schedule->date_delete_next_week_doc($seq,$writer_group);
            }else{ //내용을 넣으려는 주에 생성된 보고서가 있을 때
              //작성값을 넣을 금주 주간보고서 정보 가져오기
              $report_seq = $next_report->seq;
              $year = $next_report->year;
              $month = $next_report->month;
              $week = $next_report->week;
              $data2 = array(
                'seq'         => $seq,
                'report_seq'  => $report_seq,
                'year'        => $year,
                'month'       => $month,
                'week'        => $week,
                'income_time' => $start_day,
                'update_time' => date("Y-m-d H:i:s"),
                'group_name'  => $next_report->group_name
              );
              // array_merge($data, $data2);
              $this->STC_Schedule->date_update_next_week_doc($data2);
            }
          } //for
        }





        //20210503 변경
      } //for

      // $data['recurring_modify_choose'] = null;
      // $data['recurring_seq'] = null;
      $where = array(
        'seq' => $data['seq']
      );
      $result = $this->STC_Schedule->schedule_update('drop',$data, $where);
      echo "OK";
    }

  }


  function user(){
    $result_obj = new stdClass();
    // $data['events'] = array();

    $params = $this->input->post('userArr');
    $param_flag = isset($params) && !empty($params);


    $userArr = $_POST['userArr'];
    $user['participant'] = $userArr;
    $data['events'] = $this->STC_Schedule->schedule_list_user($user);

    echo json_encode($data['events']);
  }

  function user_null() {
    $participant = $this->name;

    $data['events'] = $this->STC_Schedule->schedule_list($participant);

    echo json_encode($data['events']);
  }



  function updateWorkColor(){
    $seq = $this->input->post('seq');
    $data['color'] = $this->input->post('color');
    $data['textColor'] = $this->input->post('textColor');

    $updateResult = $this->STC_Schedule->updateWorkColor($data, $seq);

    if($updateResult == 'true'){
      echo json_encode("true");
    } else {
      echo json_encode("false");
    }
  }

  // function search() {
  //     $data['searchTarget'] = $this->input->post('searchOpt');
  //     $searchUser = $this->input->post('segment');
  //     $searchArr = explode( ',', $searchUser );
  //     // $searchArr = $searchUser.split(', ');
  //     $data['searchKeyword'] = $searchArr;
  //     // $data['searchKeyword'] = $this->input->get('search_keyword');
  //
  //     $data['events'] = $this->STC_Schedule->search($data);
  //     echo json_encode($data['events']);
  //     // $data['listview'] = 'true';
  // }


  function tech_report(){
    $reportData['today'] = $this->input->post('today');
    $reportData['sessionName'] = $this->input->post('sessionName');
    $data['unwritten_report'] = $this->STC_Schedule->search_tech_report($reportData);
    echo json_encode($data['unwritten_report']);
  }

  //@@@
  function tech_seq_find(){
    $data['schedule_seq'] = $this->input->post('schedule_seq');
    $data['start_day'] = $this->input->post('start_day');
    $data['customer'] = $this->input->post('customer');
    $data['type'] = $this->input->post('type');
    // $data['participant'] = $this->name;

    $result = $this->STC_Schedule->tech_seq_find($data);
    if($result === 'false'){
      $data['tech_doc_seq'] = $this->STC_Schedule->same_report_schedule($data);
    }else{
      $data['tech_doc_seq'] = $result;
    }
    echo json_encode($data['tech_doc_seq']);
  }


  // KI1 20210125 고객사 담당자를 불러오는 부분
  // function search_manager(){
  //   $seq = $this->input->get('seq');
  //   $mode = $this->input->get('mode');
  //   // // $this->load->Model(array('STC_tech_doc','STC_schedule'));
  //   $data = $this->STC_Schedule->search_manager($seq, $mode);
  //   echo json_encode($data);
  // }
  // KI2 20210125


  function search_conference_room(){
    $search_day = $this->input->get('select_day');
    $data = $this->STC_Schedule->search_conference_room($search_day);

    echo json_encode($data);
  }

  // function duplicate_checkroom(){
  //   $seq = $this->input->post('schedule_seq');
  //   $search_day = $this->input->post('select_day');
  //   $search_start = $this->input->post('start');
  //   $search_end = $this->input->post('end');
  //   $search_room = $this->input->post('room_name');
  //
  //   $data = $this->STC_Schedule->duplicate_checkroom($seq, $search_day, $search_start, $search_end, $search_room);
  //
  //   echo json_encode($data);
  // }

  function search_car(){
    $search_car_day = $this->input->get('select_car_day');
    $data = $this->STC_Schedule->search_car($search_car_day);

    echo json_encode($data);
  }

  function duplicate_check(){
    $seq = $this->input->post('schedule_seq');
    $search_day = $this->input->post('select_day');
    $search_start = $this->input->post('start');
    $search_end = $this->input->post('end');
    $search_place = $this->input->post('name');
    $search_place_name = $this->input->post('type');


    $search_place = str_replace("+", "|", $search_place);

    // if(($this->input->post('room_name') != '' || $this->input->post('room_name') != null) && ($this->input->post('car_name') == '' || $this->input->post('car_name') == null)){
    //   $search_place = $this->input->post('room_name');
    //   $search_place_name = 'room_name';
    // }else if(($this->input->post('room_name') == '' || $this->input->post('room_name') == null) && ($this->input->post('car_name') != '' || $this->input->post('car_name') != null)){
    //   $search_place = $this->input->post('car_name');
    //   $search_place_name = 'car_name';
    // }

    $data = $this->STC_Schedule->duplicate_check($seq, $search_day, $search_start, $search_end,  $search_place, $search_place_name);

    echo json_encode($data);
  }

  function select_report_day(){
    $seq = $this->input->post('seq');

    $result = $this->STC_Schedule->select_report_day($seq);

    echo json_encode($result);
  }


  function search_entered_participant(){
    $val = $this->input->post('val');
    $result = $this->STC_Schedule->search_entered_participant($val);
    echo json_encode($result);
  }

//20210326
  function sch_duplicate_check(){
    $data['start_day'] = $this->input->post('startDay');
    $data['customer'] = $this->input->post('customer');
    $result = $this->STC_Schedule->sch_duplicate_check($data);
    echo json_encode($result);
  }


  function sch_report_approval(){
    // $data['schedule_seq'] = $this->input->post('schedule_seq');
    // $data['work_name'] = $this->input->post('work_name');
    // $result = $this->STC_Schedule->sch_report_approval($data);
    // echo 'here';
    $seq = $this->input->post('schedule_seq');
    $result = $this->STC_Schedule->sch_report_approval($seq);
    echo json_encode($result);
  }

  function find_participant_seq(){
    $participant_val = $this->input->post('participant');
    $participant_val_arr = explode(',', $participant_val);
    $return_val = '';
    foreach ($participant_val_arr as $name) {
      $seq = $this->STC_Schedule->find_participant_seq($name);
      if($return_val == ''){
        $return_val = $name.'_'.$seq;
      }else{
        $return_val = $return_val.','.$name.'_'.$seq;
      }
    }
    echo json_encode($return_val);
  }



  function find_recurring_original_sch(){
    $recurring_seq = $this->input->post('recurring_seq');
    $seq = $this->input->post('seq');
    $result = $this->STC_Schedule->find_recurring_original_sch($recurring_seq,$seq);
    echo json_encode($result);
  }
  // function find_recurring_after_this_sch(){
  //   $recurring_seq = $this->input->podt('recurring_seq');
  //   $seq = $this->input->podt('seq');
  //   $result = $this->STC_Schedule->find_recurring_after_this_sch($recurring_seq, $seq);
  //   echo json_encode($result);
  // }

  function recurring_drop_seq(){
    $seq = $this->input->post('seq');
    $result = $this->STC_Schedule->recurring_drop_seq($seq);
    // return $result;
    echo json_encode($result);
  }



  function find_seq_in_tech_doc_basic_temporary_save(){
    $seq = $this->input->post('seq');
    $income_time = $this->input->post('income_time');
    $result = $this->STC_Schedule->find_seq_in_tech_doc_basic_temporary_save($seq, $income_time);
    if($result){
      echo json_encode($result);
    }else{
      return false;
    }
  }

  function tech_doc_basic_temporary_save_delete(){
    $sch_seq = $this->input->post('schedule_seq');
    $result = $this->STC_Schedule->tech_doc_basic_temporary_save_delete($sch_seq);
    if($result == 'true'){
      echo json_encode($result);
    }else{
      return false;
    }
  }

  function tech_img_upload() {
    $file_count = $_POST['fileCount'];
    $file_type = explode(',', $_POST['fileType']);
    $seq = $_POST['seq'];

    if($file_count > 0) {
      for($i=0; $i<$file_count; $i++){
				// $csize = $_FILES["files".$i]["size"];
				$f = "file_".$i;
				$cname = $_FILES[$f]["name"];
				$ext = substr(strrchr($cname,"."),1);
				$ext = strtolower($ext);
				// if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp" && $ext != "xlsm") {
				//     echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				//     exit;
				// }
				// $upload_dir = "C:/xampp/htdocs/biz/misc/upload/biz/schedule";
				$upload_dir = "/var/www/html/stc/misc/upload/biz/schedule";
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = '*';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library('upload', $conf_file );
				$result = $this->upload->do_upload($f);
				if($result) {
						$file_data = array('upload_data' => $this->upload->data());
						$file_realname = $file_data['upload_data']['orig_name'];
						$file_changename = $file_data['upload_data']['file_name'];

            $data = array(
              $file_type[$i].'_file_changename' => $file_changename,
              $file_type[$i].'_file_realname'   => $file_realname
            );
            $this->STC_Schedule->update_img($seq, $data);
            echo json_encode(true);
				} else {
						echo json_encode(false);
						exit;
				}
      }
    }
  }

  function tech_img_del() {
    $seq = $this->input->post("seq");
    $type = $this->input->post("type");
    $change_filename = $this->input->post('change_filename');

    $fdata = $this->STC_Schedule->img_file($seq, $type, $change_filename);

    $t = $type."_file_changename";

    if (!isset($fdata[$t])) {
      alert("파일 정보가 존재하지 않습니다.");
    } else {
      $fdata2 = $this->STC_Schedule->img_filedel($seq, $type);
      if($fdata2) {
        // $result = unlink("C:/xampp/htdocs/biz/misc/upload/biz/schedule/".$fdata[$t]);
        $result = unlink("/var/www/html/stc/misc/upload/biz/schedule/".$fdata[$t]);

        echo json_encode($result);
      }
    }
  }

}


?>
