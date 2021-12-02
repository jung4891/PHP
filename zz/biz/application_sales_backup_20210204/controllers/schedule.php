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
  function sales_schedule(){
    // $this->output->enable_profiler(TRUE);
    // echo $this->session->userdata['userArr'];

    if( $this->id === null ) {
          redirect( 'account' );
        }
        $pGroupName =  $this->pGroupName;
        $group = $this->group;
        //패치 전 수정

    $participant = $this->name;





    $data['events'] = $this->stc_schedule->schedule_list($participant);

    $data['report'] = $this->stc_schedule->weekly_report_list();
    $data['customer'] = $this->stc_schedule->customer_list();
    // $data['color'] = $result["color"];
    // $data['textColor'] = $result["textColor"];
//////////////////KI
    $data['session_id'] = $this->id;
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
    $this->load->view('sales_schedule', $data);

  }

// BH
  function modify(){
    //수정 요청이 있을 시
    if($this->input->post('updateSubmit')){
      $seq = $this->input->post('seq');
      $startDay = $this->input->post('startDay');
      $startTime = $this->input->post('startTime');
      $endDay = $this->input->post('endDay');
      $endTime = $this->input->post('endTime');
      $workname = $this->input->post('workname');
      $customer = $this->input->post('customer');
      $supportMethod = $this->input->post('supportMethod');
      $participant = $this->input->post('participant');
      $contents = $this->input->post('contents');
      $title = $this->input->post('title');
      $modifyDay = date("Y-m-d H:i:s");

      $user_id = $this->id;
      $my_group = $this->stc_schedule->my_group($user_id)->user_group;
      $data = array(
        'seq' => $seq,
        'start_day' => $startDay,
        'start_time' => $startTime,
        'end_day' => $endDay,
        'end_time' => $endTime,
        'work_name' => $workname,
        'customer' => $customer,
        'support_method' => $supportMethod,
        'participant' => $participant,
        'contents' => $contents,
        'user_id' => $user_id,
        'user_name' => $this->name,
        'modify_date' => $modifyDay,
        'group' => $my_group,
        'p_group' => $this->pGroupName,
        'title' => $title

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
      redirect("/schedule/sales_schedule", "refresh") ;
    // 삭제요청이 있을시
    }elseif ($this->input->post('delSubmit')) {
        $seq = $this->input->post('seq');
        $this->stc_schedule->schedule_delete($seq);
        $this->stc_schedule->delete_next_week_doc($seq);
        redirect("/schedule/sales_schedule", "refresh") ;

    }
  }


// BH 일정 추가
  function add_schedule(){
    // $this->output->enable_profiler(TRUE);


      $startDay = $this->input->post('startDay');
      $startTime = $this->input->post('startTime');
      $endDay = $this->input->post('endDay');
      $endTime = $this->input->post('endTime');
      $participant = $this->input->post('participant');
      $contents = $this->input->post('contents');
      $title = $this->input->post('title');
      $curday = date("Y-m-d");
      $user_id = $this->id;
      $my_group = $this->stc_schedule->my_group($user_id)->user_group;

      // $this->load->model('stc_schedule');
      $data = array(
        'start_day' => $startDay,
        'start_time' => $startTime,
        'end_day' => $endDay,
        'end_time' => $endTime,
        'work_name' => $workname,
        'customer' => $customer,
        'support_method' => $supportMethod,
        'participant'=> $participant,
        'contents' => $contents,
        'user_id' => $user_id,
        'user_name' => $this->name,
        'group' => $my_group,
        'p_group' => $this->pGroupName,
        'title' => $title
      );
      $this->stc_schedule->schedule_insert($data);
      // $this->load->view('sales_schedule');
     $this->stc_schedule->insert_next_week_doc($workname, $customer, $my_group, $participant, $startDay);
      redirect("/schedule/sales_schedule", "refresh") ;
  }

// BH 일정 상세보기
function sales_schedule_detail(){
  // $this->output->enable_profiler(TRUE);
  if( $this->id === null ) {
        redirect( 'account' );
      }
      $pGroupName =  $this->pGroupName;
      $group = $this->group;
      //패치 전 수정


  $seq = $this->input->post('hiddenSeq');

  $this->load->Model('stc_schedule');
  $data['details'] = $this->stc_schedule->details($seq);
  $data['customer'] = $this->stc_schedule->customer_list();
  // $result = $this->stc_schedule->group_list();
  $data['work_name'] = $this->stc_schedule->group_list();
  //////////////////KI
  $data['parentGroup'] = $this->stc_schedule->parentGroup();
  $data['user_group'] = $this->stc_schedule->user_group();
  $data['userInfo'] = $this->stc_schedule->userInfo();
  $data['userDepth'] = $this->stc_schedule->userDepth();

//////////////////////////
  $data['login_gruop'] = $this->input->post('login_group');
  $data['login_pgroup'] = $this->input->post('login_pgroup');
  $data['login_user_duty'] = $this->input->post('login_user_duty');

  $this->load->view('sales_schedule_detail', $data);

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
  $this->output->enable_profiler(TRUE);
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

  // $this->load->view('sales_schedule', $data);
  return $event;
}

function user(){
  $result_obj = new stdClass();
  // $data['events'] = array();
  // $sessionData = array('userArr' => $this->input->post('userArr'));
  // $this->session->set_userdata($sessionData);

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

}


 ?>