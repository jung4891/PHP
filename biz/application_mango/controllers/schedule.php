<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Schedule extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'mango' );
		$this->name = $this->phpsession->get( 'name', 'mango' );
		$this->seq = $this->phpsession->get( 'seq', 'mango' );
		$this->admin = $this->phpsession->get( 'admin', 'mango' );

		$this->load->Model(array('STC_Schedule', 'STC_Common'));
		$this->load->library('user_agent');
	}

	//일정 페이지 메인화면 출력
  function schedule_list(){
    if( $this->id === null ) {
      redirect( 'account' );
    }

    $participant = $this->name;

    $data['events']          = $this->STC_Schedule->schedule_list($participant);
    $data['session_id']      = $this->id;
    $data['session_name']    = $this->name;
    $data['session_admin']   = $this->admin;

		$data['work_color']      = $this->STC_Schedule->work_color_list();

		$data['work_name']       = $this->STC_Schedule->group_list();
		$data['work_user_list']  = $this->STC_Schedule->work_user_list();

		$data['user_info']       = $this->STC_Schedule->work_user_list();

    $data['title'] = '일정관리';

    $this->load->view('schedule_list', $data);

  }

	function events_maker(){

    $params = $this->input->post('userArr');
    $select_start = $this->input->post('select_start');
    $select_start = explode('T', $select_start);
    $select_end = $this->input->post('select_end');
    $select_end = explode('T', $select_end);

    $user['participant'] = $params;

		$scheduled_schedule    = $this->input->post('scheduled_schedule_chk');
		$actual_schedule       = $this->input->post('actual_schedule_chk');
		$confirmation_schedule = $this->input->post('confirmation_schedule_chk');

    $list = $this->STC_Schedule->schedule_list_user($user, $select_start[0], $select_end[0], $scheduled_schedule, $actual_schedule, $confirmation_schedule);

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

			if($event->schedule_type == 'actual') {
				$schedule_type = "[자동] ";
				$arr['color']     = "#FFF1EC";
	      $arr['textColor'] = "#FA4C06";
				$arr['borderColor'] = "#FFF1EC"; //배경색이랑 동일
			} else if ($event->schedule_type == 'scheduled') {
				$schedule_type = "[예정] ";
			} else if ($event->schedule_type == 'confirmation') {
				$schedule_type = "[확정] ";
			} else {
				$schedule_type = "";
			}

			$arr['title'] = $schedule_type.$participant." 근무";

      $arr['extendedProps']['title']          = $event->title;
      $arr['extendedProps']['schedule_type']  = $event->schedule_type;
      $arr['extendedProps']['participant']    = $event->participant;
      $arr['extendedProps']['user_name']      = $event->user_name;
      $arr['extendedProps']['user_id']        = $event->user_id;
      $arr['extendedProps']['modifier_name']  = $event->modifier_name;
      $arr['extendedProps']['modifier_id']    = $event->modifier_id;
      $arr['extendedProps']['insert_date']    = $event->insert_date;
      $arr['extendedProps']['modify_date']    = $event->modify_date;
			$arr['extendedProps']['work_color_seq'] = $event->work_color_seq;

      $arr['display']   = 'block';
			$arr['color']     = $event->color;
      $arr['textColor'] = $event->textColor;
			$arr['borderColor'] = $event->color;

      array_push($events, $arr);
    }

    echo json_encode($events);
  }

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

		$result = $this->STC_Schedule->insert_schedule($seq, $data);

		if($result) {
			echo 'OK';
		}
  }

	// B일정 상세보기
  function schedule_detail(){
    if( $this->id === null ) {
          redirect( 'account' );
    }

    $data['session_id'] = $this->id;
    $data['session_name'] = $this->name;
    $data['session_admin'] = $this->admin;

    $seq = $this->input->get('seq');

    $data['details'] = $this->STC_Schedule->details($seq);

    echo json_encode($data);
  }

	function add_scheduled_batch() {
		$seq             = $this->input->post('seq');
    $schedule_type   = $this->input->post('schedule_type');
    $contents        = $this->input->post('contents');
		$participant     = $this->input->post('participant');
		$participant_seq = $this->input->post('participant_seq');
		$start_time      = $this->input->post('start_time');
		$end_time        = $this->input->post('end_time');
		$contents        = $this->input->post('contents');

		$scheduled_batch_month = $this->input->post('scheduled_batch_month');

		$target_date = date('Y-m-d', strtotime($scheduled_batch_month.'-01'));

		$last_date = date('Y-m-t', strtotime($target_date));

		for($td = $target_date; $td < $last_date; $td = date('Y-m-d', strtotime('+1 days', strtotime($td)))) {
			$w = date('w', strtotime($td));

			if($w != 0 && $w != 6) {
				$schedule_check = $this->STC_Schedule->schedule_check($td, $participant_seq, 'scheduled');

				$stime = $start_time[$w - 1];
				$etime = $end_time[$w - 1];

				if($stime != '' && $etime != '') {
					$data = array(
						'schedule_type' => 'scheduled',
						'start_day' => $td,
						'start_time' => $stime,
						'end_day' => $td,
						'end_time' => $etime,
						'participant' => $participant,
						'participant_seq' => $participant_seq,
						'contents' => $contents
					);

					if($schedule_check['cnt'] == 0) {
						$data['user_id'] = $this->id;
						$data['user_name'] = $this->name;
						$result = $this->STC_Schedule->insert_schedule($schedule_check['seq'], $data);
					} else {
						$data['modifier_id'] = $this->id;
						$data['modifier_name'] = $this->name;
						$data['modify_date']   = date('Y-m-d H:i:s');
						$result = $this->STC_Schedule->insert_schedule($schedule_check['seq'], $data);
					}

				} else {
					if($schedule_check['cnt'] > 0) {
						$result = $this->STC_Schedule->delete_schedule($schedule_check['seq']);
					}
				}

			}
		}

		echo json_encode($result);


	}

	function add_schedule(){
    // $this->output->enable_profiler(TRUE);

		$seq             = $this->input->post('seq');
    $startDay        = $this->input->post('startDay');
    $startTime       = $this->input->post('startTime');
    $endDay          = $this->input->post('endDay');
    $endTime         = $this->input->post('endTime');
    $schedule_type   = $this->input->post('schedule_type');
    $contents        = $this->input->post('contents');
    $title           = $this->input->post('title');
		$participant     = $this->input->post('participant');
		$participant_seq = $this->input->post('participant_seq');

    $data = array(
      'start_day'       => $startDay,
      'start_time'      => $startTime,
      'end_day'         => $endDay,
      'end_time'        => $endTime,
      'schedule_type'   => $schedule_type,
      'participant'     => $participant,
      'participant_seq' => $participant_seq,
      'title'           => $title,
      'contents'        => $contents,
    );

		if($seq == '') {
			$data['user_id'] = $this->id;
			$data['user_name'] = $this->name;
		} else {
			$data['modifier_id'] = $this->id;
			$data['modifier_name'] = $this->name;
			$data['modify_date']   = date('Y-m-d H:i:s');
		}

		$result = $this->STC_Schedule->insert_schedule($seq, $data);

    echo json_encode($result);
  }

	function delete_schedule() {
		$seq = $this->input->post('seq');

		$result = $this->STC_Schedule->delete_schedule($seq);

		echo json_encode($result);
	}

	function make_timeTable() {
		$user_seq = $this->input->post('user_seq');

		$result = $this->STC_Schedule->make_timeTable($user_seq);

		echo json_encode($result);
	}

}
?>
