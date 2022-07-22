<?php
header("Content-type: text/html; charset=utf-8");

class Crontab extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->Model("STC_Crontab");
		$this->load->Model("sales/STC_Forcasting");
		$this->load->Model("sales/STC_Maintain");
	}

	// 공휴일 저장 크론
	function holiday_crontab(){

    $service_key = "64MNVtaO1eTfTnjoRxWoym8WuBjnsF9SYFZfvDnGdq9l08UyjAccxkB9K8Ik5sDxbtX3GJu22hACTnOvcfxdBQ%3D%3D";

		$time = time();
		$date = explode("-",date("Y-m",strtotime("+1 month", $time)));

		$year = $date[0];
		$month = $date[1];

    $url = "http://apis.data.go.kr/B090041/openapi/service/SpcdeInfoService/getRestDeInfo?serviceKey=".$service_key."&solYear=".$year."&solMonth=".$month;

		echo $url;

    $data = file_get_contents($url);
    $xml = simplexml_load_string($data);
    $items = $xml->body[0]->items->item;

    $count = count($items);

    if ($count>0){
      for($i=0;$i<$count;$i++){
        $holiday[$i]['dateName'] = $items[$i]->dateName;
        $holiday[$i]['locdate'] = $items[$i]->locdate;
      }

      echo "<pre>";
      echo var_dump($holiday);
      echo "</pre>";

			foreach($holiday as $h){
				$locdate = $h['locdate'];
				$dateName = $h['dateName'];
				$holiday_count = $this->STC_Crontab->holiday_count($locdate)->cnt;
				if ($holiday_count == 0) {
					$this->STC_Crontab->holiday_insert($locdate, $dateName);
				}
			}
    } else {
      echo "공휴일 없음";
    }

  }


	// 근퇴 생성 크론탭
	function attendance_manual_input() {

		$date = date('Ymd');
		$beforeDay = date("Ymd", strtotime($date." -1 day"));

		$before_attendance = $this->STC_Crontab->before_attendance($beforeDay);

		foreach ($before_attendance as $ba) {

			if($ba['ws_time']=="" || $ba['wc_time']=="") {
				$this->STC_Crontab->update_before_attendance($ba['seq'],'미처리');
			}

		}


		$attendance_user = $this->STC_Crontab->attendance_user();

		foreach($attendance_user as $au) {

			$official_time = $this->STC_Crontab->official_time($au['card_num']);

			$data = array(
				'card_num' => $au['card_num'],
				'date' => $date,
				// 'status' => $status,
				// 'date_type' => $date_type,
				'official_ws_time' => $official_time['ws_time'],
				'official_wc_time' => $official_time['wc_time']
			);

			$attendance_count = $this->STC_Crontab->attendance_count($au['card_num'], $date)->cnt;
			if ($attendance_count == 0) {
				$this->STC_Crontab->attendance_input($data);
			}
		}

	}


	function attendance_crontab(){

		$date = date('Ymd');
		$beforeDay = date("Ymd", strtotime($date." -1 day"));

// for ($i=1; $i < 29; $i++) {

		// $date = "20210720";
		// $beforeDay = date("Ymd", strtotime($date." +{$i} day"));
		// $beforeDay = "20210817";
		$user_info = $this->STC_Crontab->attendance_user();
		// $i = 0;
		foreach ($user_info as $ui) {
			// if($i >= 1){
			// 	break;
			// }
			$date_info = $this->STC_Crontab->date_info($beforeDay, $ui['user_id']);
			$work_info = $this->work_time($beforeDay, $ui['card_num'], $ui['user_group']);
			$user_info = array(
				"u_seq" => $ui["seq"],
				"u_name" => $ui["user_name"],
				"card_num" => $ui["card_num"],
				"ws_time" => $ui["ws_time"],
				"wc_time" => $ui["wc_time"]
			);
			$data1 = array_merge($user_info, $date_info);
			$data2 = array_merge($data1, $work_info);

			$this->STC_Crontab->insert_adt($data2);

			// $i++;
		}
// }
		// $data = array_merge($user_info, $date_info);
		// var_dump($data);

	}


	function work_time($date, $id, $group){

		$go_leave = $this->STC_Crontab->go_leave_work($date, $id);


		$data = $this->STC_Crontab->work_time($date, $id);


		$check_in = '0002';
		$check_out = '0003';
		$room_in = '0004';
		$room_out = '0005';
		if($group == "기술연구소" || $group == "CEO"){

			$sum_time = 0;
			for ($i=0; $i < count($data); $i++) {
				if($data[$i]['g_id'] == $check_in){
					$in_time = strtotime($data[$i]['work_time']);
				}elseif (isset($in_time) && $data[$i]['g_id'] == $check_out) {
					$out_time = strtotime($data[$i]['work_time']);
					$diff = $out_time - $in_time;
					$sum_time += $diff;
					unset($in_time);
				}else{
					continue;
				}
			}
		}else{

			$sum_time = 0;
			$sum_room = 0;
			$sum_office = 0;
			for ($i=0; $i < count($data); $i++) {
				if($data[$i]['g_id'] == $room_in){
					if(isset($in_time2)){
						unset($in_time2);
						$in_time = strtotime($data[$i]['work_time']);
					}else{
						$in_time = strtotime($data[$i]['work_time']);
					}
				}elseif (isset($in_time) && ($data[$i]['g_id'] == $room_out || $data[$i]['g_id'] == $check_out)) {
					$out_time = strtotime($data[$i]['work_time']);
					$diff = $out_time - $in_time;
					$sum_room += $diff;
					unset($in_time);
				}elseif($data[$i]['g_id'] == $check_in){
					if(isset($in_time)){
						unset($in_time);
					}else{
						$in_time2 = strtotime($data[$i]['work_time']);
					}
				}elseif(isset($in_time2) && $data[$i]['g_id'] == $room_out){
						$out_time2 = strtotime($data[$i]['work_time']);
						$diff2 = $out_time2 - $in_time2;
						$sum_office += $diff2;
						unset($in_time2);
				}else{
					unset($in_time2);
				}
			}
				$sum_time = $sum_room + $sum_office;
		}


		$minute =  (int)($sum_time/60);
		$time1 = (int)($minute / 60);
		$time1 = str_pad($time1, 2, "0", STR_PAD_LEFT);
    $time2 = $minute % 60;
		$time2 = str_pad($time2, 2, "0", STR_PAD_LEFT);
    $work_time = $time1 .':'. $time2;

		$result = array(
			"go_time" => $go_leave->s_time,
			"leave_time" => $go_leave->e_time,
			"work_time" => $work_time
		);

		return $result;
		// var_dump($result);
	}

	// 무상보증종료된 수주완료 유지보수 자동 생성 크론
	function forcasting_duplication() {
		$today = date('Y-m-d');
		$target_seq = $this->STC_Crontab->maintain_auto_generate_target($today);
		var_dump($target_seq);

		if(!empty($target_seq)) {
			foreach($target_seq as $ts) {
				$forcasting_info = $this->STC_Forcasting->forcasting_view($ts['seq']);
				$data = array(
					'forcasting_seq' => $ts['seq'],
					'project_name'   => $forcasting_info['project_name'],
					'progress_step'  => NULL,
					'generate_type'  => $forcasting_info['type'],
					'insert_date'    => date('Y-m-d H:i:s')
				);

				$result = $this->STC_Crontab->forcasting_duplication($data);
			}
		}
	}

	function maintain_setting() {
		$today = date('Y-m-d');
		$target_seq = $this->STC_Crontab->maintain_auto_renewal($today);

		// var_dump($target_seq);
		// echo count($target_seq);

		foreach($target_seq as $ts) {
			$maintain_term = $this->STC_Maintain->maintain_term($ts['seq']);
			// if ($maintain_term['nom'] == '') {
			// 	$maintain_term['nom'] = 0;
			// }
			$result = $this->STC_Maintain->generate_maintain_forcasting($ts['seq'], $maintain_term['nom']);
		}
	}

	// function maintain_renewal() {
	// 	$today = date('Y-m-d');
	// 	$target_seq = $this->STC_Crontab->maintain_auto_renewal($today);
	//
	// 	var_dump($target_seq);
	// }

	function fund_list_paysession_update() {
		$target = $this->STC_Crontab->fund_list_paysession_target();

		foreach($target as $t) {
			$paysession = $this->STC_Crontab->paysession($t['bill_seq']);

			$result = $this->STC_Crontab->fund_list_paysession_update($t['idx'], $t['breakdown'], $paysession['pay_session']);
		}
	}

	function all_read_board() {
		$user = $this->STC_Crontab->user_list();
		$board_list = $this->STC_Crontab->board_list();
var_dump($user);
		foreach($user as $u) {
			foreach($board_list as $bl) {
				// echo $u['seq'];
				$data = array(
					'user_seq' => $u['seq'],
					'notice_seq' => $bl['seq'],
					'read_time' => date('Y-m-d H:i:s')
				);
				$this->STC_Crontab->all_read_baord($data);
			}
		}
	}

	// 출장품의서 데이터 추출
	function cron_data_extract() {
		$data['approval_list'] = $this->STC_Crontab->cron_data_extract();

		$this->load->view('cron_data_extract', $data);
	}

	function cron_data_extract_schedule() {
		$data['schedule_list'] = $this->STC_Crontab->cron_data_extract_schedule();

		$this->load->view('cron_data_extract_schedule', $data);
	}

}
?>
