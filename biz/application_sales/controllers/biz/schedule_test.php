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
    $this->load->database();
    ob_start();
    $config['url_suffix'] = 'html';
    // // $this->load->Model('stc_schedule');
    $this->load->Model(array('tech/STC_User', 'STC_Common', 'biz/STC_Schedule', 'tech/STC_Tech_doc'));
    $this->load->helper('url');
    $this->load->library('user_agent');
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
      // echo print_r($params);
      // var_dump($params);
      // $param_flag = isset($params) && !empty($params);
      $user['participant'] = $params;
      $list = $this->STC_Schedule->schedule_list_user($user);
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

      if($event->work_type == 'tech'){
        $arr['title'] = "[".$participant."]"." ".$event->customer.$work_name.$support_method;
      }else{
        if($event->customer != '' || $event->customer != null){
          $arr['title'] = "[".$participant."]"." ".$event->work_name."/".$event->customer."/".$event->title;
        }else{
          $arr['title'] = "[".$participant."]"." ".$event->work_name."/".$event->title;
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

    //내용분할1
    //일장 내영 분할 tech_schedule_contents 입력용
    $contents_arr = $this->input->get('contents');
    // var_dump($contents_arr);

    $title = $this->input->get('title');
    $place = $this->input->get('place');
    $modifyDay = date("Y-m-d H:i:s");

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
      // 'weekly_report' => null,
      'nondisclosure'   => $nondisclosure
    );

    $written_rep_cnt = $this->STC_Schedule->written_rep_cnt($seq)->cnt;
    if ($written_rep_cnt > 0){
      echo json_encode("report_written");
      return false;
    }

    $work_type = $this->STC_Schedule->details($seq)->work_type;
    $before_sday = $this->STC_Schedule->details($seq)->start_day;
    $before_eday = $this->STC_Schedule->details($seq)->end_day;
    if ($work_type=='tech'){
      if ($startDay != $before_sday || $endDay != $before_eday){
        $report_cnt = abs(strtotime($startDay) - strtotime($endDay))/60/60/24+1;
        $written_rep_cnt = $this->STC_Schedule->written_rep_cnt($seq)->cnt;
        $data['tech_report'] = $report_cnt - $written_rep_cnt;
      }
    }



    $result = $this->STC_Schedule->schedule_update($data);
    echo json_encode($result);


    //내용분할1 일정 내용 분할 저장
    $this->STC_Schedule->schedule_contents_update($contents_arr,$seq);

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
              $tech_seq2 = $this->STC_Schedule->check_tech_seq2();
              $tech_seq2 = $tech_seq2->m1;
              $data_lab2 = array(
                'tech_seq'    => $tech_seq2,
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
              $tech_seq = $this->STC_Schedule->check_tech_seq();
              $tech_seq = $tech_seq->m1;
              $data_lab2 = array(
                'tech_seq'    => $tech_seq,
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


        //기술연구소 주간보고 연동
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
              $tech_seq = $this->STC_Schedule->check_tech_seq();
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
              $tech_seq2 = $this->STC_Schedule->check_tech_seq2();
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
                  'subject'      => $contents,
                  'writer'       => $participant,
                  'report_seq'   => $report_seq,
                  'year'         => $year,
                  'month'        => $month,
                  'week'         => $week,
                  'income_time'  => $startDay,
                  'insert_time' => date("Y-m-d H:i:s")
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

    $written_rep_cnt = $this->STC_Schedule->written_rep_cnt($seq)->cnt;
    if ($written_rep_cnt > 0){
      echo json_encode("report_written");
      return false;
    }

    $result = $this->STC_Schedule->schedule_delete($seq);
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
    $curday = date("Y-m-d");
    $user_id = $this->id;
    $my_group = $this->STC_Schedule->my_group($user_id)->user_group;

    //비공개일정
    $nondisclosure = $this->input->post('nondisclosure');
    if($nondisclosure === 'Y'){
      $participant = $this->name;
      $room_name = "";
      $car_name = "";
    }

    // // $this->load->Model('stc_schedule');
    // $writer = preg_replace("/\s+/", "", $participant);
    // $writer = explode( ',', $writer );
    // $num = count($writer);

    $data = array(
      'start_day'       => $startDay,
      'start_time'      => $startTime,
      'end_day'         => $endDay,
      'end_time'        => $endTime,
      'work_type'       => $work_type,
      'work_name'       => $workname,
      'room_name'       => $room_name,
      'car_name'        => $car_name,
      //KI1 20210125 고객사 포캐스팅형으로 변경하여 새로 추가되는 부분
      'customer'        => $customer,
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

    if ($work_type=='tech'){
      $report_cnt = abs(strtotime($startDay) - strtotime($endDay))/60/60/24+1;
      $data['tech_report'] = $report_cnt;
    }

    $result = $this->STC_Schedule->schedule_insert($data);

    echo json_encode($result);

    //내용분할1 일정 내용 분할 저장
    $this->STC_Schedule->schedule_contents_insert($contents_arr);

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
            $tech_seq2 = $this->STC_Schedule->check_tech_seq2();
            $tech_seq2 = $tech_seq2->m1;
            //작성값을 넣을 금주 주간보고서 정보 가져오기
            $report_seq = $check_report2->seq;
            $year = $check_report2->year;
            $month = $check_report2->month;
            $week = $check_report2->week;
            $data_lab2 = array(
              'tech_seq'   => $tech_seq2,
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
            $tech_seq = $this->STC_Schedule->check_tech_seq();
            $tech_seq = $tech_seq->m1;
            //작성값을 넣을 차주 주간보고서 정보 가져오기
            $report_seq = $check_report1->seq;
            $year = $check_report1->year;
            $month = $check_report1->month;
            $week = $check_report1->week;
            $data_lab2 = array(
              'tech_seq'   => $tech_seq,
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
                $tech_seq = $this->STC_Schedule->check_tech_seq();
                $tech_seq = $tech_seq->m1;
                //작성값을 넣을 차주 주간보고서 정보 가져오기
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
                $tech_seq2 = $this->STC_Schedule->check_tech_seq2();
                $tech_seq2 = $tech_seq2->m1;
                //작성값을 넣을 금주 주간보고서 정보 가져오기
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

    $work_type = $this->STC_Schedule->details($seq)->work_type;
    $before_sday = $this->STC_Schedule->details($seq)->start_day;
    $before_eday = $this->STC_Schedule->details($seq)->end_day;
    if ($work_type=='tech'){
      if ($start_day != $before_sday || $end_day != $before_eday){
        $report_cnt = abs(strtotime($start_day) - strtotime($end_day))/60/60/24+1;
        $written_rep_cnt = $this->STC_Schedule->written_rep_cnt($seq)->cnt;
        $data['tech_report'] = $report_cnt - $written_rep_cnt;
      }
    }

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
        //주간업무보고의 마지막 tech_seq값의 -1 한 값을 가져오기
        $tech_seq = $this->STC_Schedule->check_tech_seq();
        $tech_seq = $tech_seq->m1;
        //일정 이동 후 주간보고서, 이동 전 주간보고서 seq 찾기
        $a_c_check_report = $this ->STC_Schedule->check_report($start_day, $writer_group); // 이동 후 주간보고서 seq
        $before_day =  date("Y-m-d", strtotime($start_day." -7day"));
        $b_c_check_report = $this ->STC_Schedule->check_report($before_day, $writer_group); // 이동 후의 전주 주간보고서 seq
        $after_day =  date("Y-m-d", strtotime($start_day." +7day"));
        $a_c_a_check_report = $this ->STC_Schedule->check_report($after_day, $writer_group); // 이동 후의 차주 주간보고서 seq

        //20210503 변경
        $check_sch_next_report = $this->STC_Schedule->check_next_week_doc($seq);
        $current_report = $this ->STC_Schedule->check_report($start_day, $writer_group); // 이동 후 주간보고서 seq

        $check_sch_current_report = $this->STC_Schedule->check_current_week_doc($seq);

        if($check_sch_current_report == 'false'){ //테이블에 해당 일정 seq로 등록된 내용이 없을 때
          if($current_report == 'false'){ //내용을 넣으려는 주에 생성된 보고서가 없을 때
            continue;
          }else{ //내용을 넣으려는 주에 생성된 보고서가 있을 때
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
        $check_sch_next_report = $this->STC_Schedule->check_next_week_doc($seq);

        if($check_sch_next_report == 'false'){ //테이블에 해당 일정 seq로 등록된 내용이 없을 때
          if($next_report == 'false'){ //내용을 넣으려는 주에 생성된 보고서가 없을 때
            continue;
          }else{ //내용을 넣으려는 주에 생성된 보고서가 있을 때
            //작성값을 넣을 금주 주간보고서 정보 가져오기
            $report_seq = $next_report->seq;
            $year = $next_report->year;
            $month = $next_report->month;
            $week = $next_report->week;
            $data2 = array(
              'seq'        => $seq,
              'tech_seq'   => $tech_seq,
              'report_seq' => $report_seq,
              'year'       => $year,
              'month'      => $month,
              'week'       => $week,
              'group_name' => $writer_group,
              'income_time' => $start_day
            );
            // array_merge($data, $data2);
            $this->STC_Schedule->date_insert_next_week_doc($data2);
          }
        }else{ //테이블에 해당 일정 seq로 등록된 내용이 있을 때
          if($next_report == 'false'){ //내용을 넣으려는 주에 생성된 보고서가 없을 때
            $this->STC_Schedule->date_delete_next_week_doc($seq,$writer_group);
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
              'update_time' => date("Y-m-d H:i:s")
            );
            // array_merge($data, $data2);
            $this->STC_Schedule->date_update_next_week_doc($data2);
          }
        }
        //20210503 변경
      }

      $result = $this->STC_Schedule->schedule_update($data);
      echo "OK";
    }

  }

  // KI 유저DB에 조회할 대상 입력
  function user333(){
    // $this->output->enable_profiler(TRUE);
  ////////////BH
    $data['events2'] = array();

    $result = $this->STC_Schedule->group_list();
    $len = $result["len"];
    // $result = $this->STC_Schedule->selectUser($this->name);
    // $user_schecdule = $result["user_schecdule"];
    for ($i=0; $i <= $len-1 ; $i++) {
      $user['work_name'] = $result["work_list"][$i]->work_name;
      $userArr = $_POST['userArr'];
      // echo $userArr;
      // var_dump($userArr);
      $user['participant'] = $userArr;
      // $user['user_name'] = $this->name;
      $event = $this->STC_Schedule->schedule_list($user);
      // var_dump($event);
      array_push($data['events2'], $event);
    }
    $data['report'] = $this->STC_Schedule->weekly_report_list();
    $data['customer'] = $this->STC_Schedule->customer_list();
    $data['work_name'] = $result["work_list"];

    $data['parentGroup'] = $this->STC_Schedule->parentGroup();
    $data['user_group'] = $this->STC_Schedule->user_group();
    $data['userInfo'] = $this->STC_Schedule->userInfo();
    $data['userDepth'] = $this->STC_Schedule->userDepth();

    // $this->load->view('tech/tech_schedule', $data);
    return $event;
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



}


?>
