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
    // $this->load->Model('stc_schedule');
    $this->load->Model(array('STC_User', 'STC_Common', 'stc_schedule'));
    $this->load->helper('url');

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
        if($pGroupName != 'CEO' && $pGroupName != '기술본부'){
    echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
  }

    $participant = $this->name;




    //KI1 20210125 고객사를 불러오기 위해 doc모델을 연결
    $this->load->Model('STC_schedule');
    // $this->load->Model(array('STC_tech_doc','STC_schedule'));
    //KI2 20210125
    $data['events'] = $this->stc_schedule->schedule_list($participant);

    $data['report'] = $this->stc_schedule->weekly_report_list();
    //KI1 20210125 고객사를 불러오는 부분
    // $data['customer'] = $this->stc_schedule->customer_list();
    $data['customer'] = $this->stc_schedule->get_customer();
    $data['customer2'] = $this->stc_schedule->get_customer2();
    // $data['customer'] = $this->STC_tech_doc->get_customer();
    //KI2 20210125
    // $data['color'] = $result["color"];
    // $data['textColor'] = $result["textColor"];
//////////////////KI
    $data['session_id'] = $this->id;
    $data['session_name'] = $this->name;
    $data['parentGroup'] = $this->stc_schedule->parentGroup();
    $data['user_group'] = $this->stc_schedule->user_group();
    $data['userInfo'] = $this->stc_schedule->userInfo();
    $data['userDepth'] = $this->stc_schedule->userDepth();
    $data['work_color'] = $this->stc_schedule->work_color_list();
    $data['work_name'] = $this->stc_schedule->group_list();
    $data['pGroupName'] = $this->pGroupName;

    $data['group'] = $this->group;
    $data['login_group'] = $this->stc_schedule->my_group($this->id)->user_group;
    $data['login_user_duty'] = $this->stc_schedule->login_user_duty($this->id)->user_duty;

    $this->load->view('tech_schedule', $data);

  }

// BH
  function modify(){
    //수정 요청이 있을 시
    if($this->input->get('updateSubmit')){
      $seq = $this->input->get('seq');
      $startDay = $this->input->get('startDay');
      $startTime = $this->input->get('startTime');
      $endDay = $this->input->get('endDay');
      $endTime = $this->input->get('endTime');
      $workname = $this->input->get('workname');
      //KI1 20210125 고객사를 포캐스팅형으로 변경하여 새로 추가되는 부분
      // $customer = $this->input->post('customer');
      $customer = $this->input->get('customerName');
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
      $project = $this->input->get('project');
      //KI2 20210125
      // KI1 20210125_22
      // $customer2 =$this->input->post('insertDirect');
      // KI2 20210125_22
      $supportMethod = $this->input->get('supportMethod');
      $participant = $this->input->get('participant');
      $contents = $this->input->get('contents');
      $modifyDay = date("Y-m-d H:i:s");

      // KI1 20210125_22
      // if($customer == '직접입력'){
      //   $customer = $customer2;
      // }
      // KI2 20210125_22
      $user_id = $this->id;
      $my_group = $this->stc_schedule->my_group($user_id)->user_group;
      $data = array(
        'seq' => $seq,
        'start_day' => $startDay,
        'start_time' => $startTime,
        'end_day' => $endDay,
        'end_time' => $endTime,
        'work_name' => $workname,
        //KI1 20210125 고객사를 포캐스팅형으로 변경하여 새로 추가되는 부분
        'customer' => $customer,
        'forcasting_seq' => $forcasting_seq,
        'maintain_seq' => $maintain_seq,
        'project' => $project,
        //KI2 20210125
        'support_method' => $supportMethod,
        'participant' => $participant,
        'contents' => $contents,
        'user_id' => $user_id,
        'user_name' => $this->name,
        'modify_date' => $modifyDay,
        'group' => $my_group,
        'p_group' => $this->pGroupName

      );
      $this->stc_schedule->schedule_update($data);

      $data = array(
        'schedule_seq'=>$seq,
        'group_name'=>$my_group,
        'work_name'=>$workname,
        'customer'=>$customer,
        'writer'=>$participant,
        'income_time'=>$startDay
      );
      $this->stc_schedule->update_next_week_doc($data);
      redirect("/schedule/tech_schedule", "refresh") ;
    // 삭제요청이 있을시
  }elseif ($this->input->get('delSubmit')) {
        $seq = $this->input->get('seq');
        $this->stc_schedule->schedule_delete($seq);
        $this->stc_schedule->delete_next_week_doc($seq);
        redirect("/schedule/tech_schedule", "refresh") ;

    }
  }


// BH 일정 추가
  function add_schedule(){
    // $this->output->enable_profiler(TRUE);


      $startDay = $this->input->post('startDay');
      $startTime = $this->input->post('startTime');
      $endDay = $this->input->post('endDay');
      $endTime = $this->input->post('endTime');
      $workname = $this->input->post('workname');
      //KI1 20210125 고색사 포캐스팅형으로 변경하여 새로 추가되는 부분
      // $customer = $this->input->post('customer');
      $customer = $this->input->post('customerName');
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
      $customer_manager = $this->input->post('customer_manager');
      //KI2 20210125
      $supportMethod = $this->input->post('supportMethod');
      $participant = $this->input->post('participant');
      $contents = $this->input->post('contents');
      $curday = date("Y-m-d");
      $user_id = $this->id;
      $my_group = $this->stc_schedule->my_group($user_id)->user_group;

      // $this->load->model('stc_schedule');
      $writer = preg_replace("/\s+/", "", $participant);
      $writer = explode( ',', $writer );
      $num = count($writer);

      $data = array(
        'start_day' => $startDay,
        'start_time' => $startTime,
        'end_day' => $endDay,
        'end_time' => $endTime,
        'work_name' => $workname,
        //KI1 20210125 고객사 포캐스팅형으로 변경하여 새로 추가되는 부분
        // 'customer' => $customer,
        'customer' => $customer,
        'project' => $project,
        'forcasting_seq' => $forcasting_seq,
        'maintain_seq' => $maintain_seq,
        'customer_manager' => $customer_manager,
        //KI2 20210125
        'support_method' => $supportMethod,
        'participant'=> $participant,
        'contents' => $contents,
        'user_id' => $user_id,
        'user_name' => $this->name,
        'group' => $my_group,
        'p_group' => $this->pGroupName,
        'tech_report' => 'N',
      );
     $this->stc_schedule->schedule_insert($data);
      // $this->load->view('tech_schedule');
      for ($i=0; $i < $num ; $i++) {
         $linker = $writer[$i];
         $linker_group = $this->stc_schedule->linker_group($linker)->user_group;
         $linker_id = $this->stc_schedule->linker_id($linker)->user_id;
         $before_day =  date("Y-m-d", strtotime($startDay." -7day"));
         $check_report = $this ->stc_schedule->check_report($before_day, $linker_group, $linker);
         $report_seq = "NULL";
         $year = "NULL";
         $month = "NULL";
         $week = "NULL";
         if($check_report){
           $report_seq = $check_report->seq;
           $year = $check_report->year;
           $month = $check_report->month;
           $week = $check_report->week;
         }
         $this->stc_schedule->insert_next_week_doc($workname, $customer, $linker_group, $participant, $startDay, $linker, $linker_id, $user_id, $report_seq, $year, $month, $week);
     };
      redirect("/schedule/tech_schedule", "refresh") ;
  }

// BH 일정 상세보기
function tech_schedule_detail(){
  // $this->output->enable_profiler(TRUE);
  if( $this->id === null ) {
        redirect( 'account' );
      }
      $pGroupName =  $this->pGroupName;
      $group = $this->group;
      //패치 전 수정
      if($pGroupName != 'CEO' && $pGroupName != '기술본부'){
    echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
  }

  $seq = $this->input->get('hiddenSeq');

  $this->load->Model('stc_schedule');
  // $this->load->Model(array('STC_tech_doc','STC_schedule'));
//KI2 20210125

  $data['details'] = $this->stc_schedule->details($seq);
  $custo = $data['details']->customer;
  $data['direct_yn'] = $this ->stc_schedule->direct_check($custo);

  //KI1 20210125 고객사를 불러오는 부분
  // $data['customer'] = $this->stc_stc_schedule->customer_list();
  // $data['customer'] = $this->STC_tech_doc->get_customer();
  $data['customer'] = $this->stc_schedule->get_customer();
  $data['customer2'] = $this->stc_schedule->get_customer2();
  //KI2 20210125


  // $result = $this->stc_schedule->group_list();
  $data['work_name'] = $this->stc_schedule->group_list();
  //////////////////KI
  $data['parentGroup'] = $this->stc_schedule->parentGroup();
  $data['user_group'] = $this->stc_schedule->user_group();
  $data['userInfo'] = $this->stc_schedule->userInfo();
  $data['userDepth'] = $this->stc_schedule->userDepth();
//////////////////////////
  $data['login_gruop'] = $this->input->get('login_group');
  $data['login_pgroup'] = $this->input->get('login_pgroup');
  $data['login_user_duty'] = $this->input->get('login_user_duty');

  $this->load->view('tech_schedule_detail', $data);

}

// BH 일정 드래그시 날짜 업데이트
  function drop_update(){
    $seq = $this->input->post("seq");
    $start_day = $this->input->post("start_day");
    $start_time = $this->input->post("start_time");
    $end_day = $this->input->post("end_day");
    $end_time = $this->input->post("end_time");
    $modifyDay = date("Y-m-d H:i:s");
    $data = array(
      'seq' => $seq,
      'start_day' => $start_day,
      'start_time' => $start_time,
      'end_day' => $end_day,
      'end_time' => $end_time,
      'user_id' => $this->id,
      'user_name' =>$this->name,
      'modify_date' => $modifyDay
    );
    $data2 = array(
      'schedule_seq'=>$seq,
      'income_time'=>$start_day
    );
    $this->stc_schedule->update_next_week_doc($data2);
    $result = $this->stc_schedule->schedule_update($data);

    echo "OK";
  }

  // KI 유저DB에 조회할 대상 입력
function user333(){
  // $this->output->enable_profiler(TRUE);
////////////BH
    $data['events2'] = array();

    $result = $this->stc_schedule->group_list();
    $len = $result["len"];
    // $result = $this->stc_schedule->selectUser($this->name);
    // $user_schecdule = $result["user_schecdule"];
    for ($i=0; $i <= $len-1 ; $i++) {
      $user['work_name'] = $result["work_list"][$i]->work_name;
      $userArr = $_POST['userArr'];
      // echo $userArr;
      // var_dump($userArr);
      $user['participant'] = $userArr;
      // $user['user_name'] = $this->name;
      $event = $this->stc_schedule->schedule_list($user);
      // var_dump($event);
      array_push($data['events2'], $event);
  }
  $data['report'] = $this->stc_schedule->weekly_report_list();
  $data['customer'] = $this->stc_schedule->customer_list();
  $data['work_name'] = $result["work_list"];

  $data['parentGroup'] = $this->stc_schedule->parentGroup();
  $data['user_group'] = $this->stc_schedule->user_group();
  $data['userInfo'] = $this->stc_schedule->userInfo();
  $data['userDepth'] = $this->stc_schedule->userDepth();

  // $this->load->view('tech_schedule', $data);
  return $event;
}

function user(){
  $result_obj = new stdClass();
  // $data['events'] = array();

  $params = $this->input->post('userArr');
  $param_flag = isset($params) && !empty($params);


    $userArr = $_POST['userArr'];
    $user['participant'] = $userArr;
    $data['events'] = $this->stc_schedule->schedule_list_user($user);



  echo json_encode($data['events']);
}

function user_null() {
  $participant = $this->name;

  $data['events'] = $this->stc_schedule->schedule_list($participant);

  echo json_encode($data['events']);
}



  function updateWorkColor(){
    $seq = $this->input->post('seq');
    $data['color'] = $this->input->post('color');
    $data['textColor'] = $this->input->post('textColor');

    $updateResult = $this->stc_schedule->updateWorkColor($data, $seq);

    if($updateResult == 'true'){
      echo json_encode("true");
    } else {
      echo json_encode("false");
    }
  }

  function search() {
      $data['searchTarget'] = $this->input->post('searchOpt');
      $searchUser = $this->input->post('segment');
      $searchArr = explode( ',', $searchUser );
      // $searchArr = $searchUser.split(', ');
      $data['searchKeyword'] = $searchArr;
      // $data['searchKeyword'] = $this->input->get('search_keyword');

      $data['events'] = $this->stc_schedule->search($data);
      echo json_encode($data['events']);
      // $data['listview'] = 'true';
  }


  function tech_report(){
    $reportData['today'] = $this->input->post('today');
    $reportData['sessionName'] = $this->input->post('sessionName');
    $data['unwritten_report'] = $this->stc_schedule->search_tech_report($reportData);
    echo json_encode($data['unwritten_report']);
  }

  function tech_seq_find(){
    $data['schedule_seq'] = $this->input->post('schedule_seq');
    $data['tech_doc_seq'] = $this->stc_schedule->tech_seq_find($data);
    echo json_encode($data['tech_doc_seq']);
  }


  // KI1 20210125 고객사 담당자를 불러오는 부분
  function search_manager(){
    $tmp = $_GET['name'];
    // $this->load->Model(array('STC_tech_doc','STC_schedule'));
    $data = $this->db->query("select * from sales_forcasting where seq='".$tmp."'")->result();
    $this->load->view('search_manager',array('input'=>$data));
  }
  // KI2 20210125

}


 ?>
