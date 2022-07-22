<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crontab extends CI_Controller {

	var $id = '';

	function __construct() {
     parent::__construct();
		 $this->load->Model('STC_Crontab');
  }

	function scheduled_work_insert() {
		$target_month = $this->input->get('target_date');

		if($target_month != '') {
			$target_date = date('Y-m-d', strtotime($target_month.'-01'));
		} else {
			$target_date = date("Y-m-01",strtotime("+1 month"));
		}

		$last_date = date('Y-m-t', strtotime($target_date));

		echo $target_date.'<br>';
		echo $last_date;

		$work_user_list = $this->STC_Crontab->work_user_list();

		foreach($work_user_list as $wul) {
			if($wul['work_start'] != '' && $wul['work_end'] != '') {
				for($td = $target_date; $td < $last_date; $td = date('Y-m-d', strtotime("+1 days", strtotime($td)))) {
					$w = date('w', strtotime($td));
					if($w != 0 && $w != 6) {
						$schedule_check = $this->STC_Crontab->schedule_check($td, $wul['seq'], 'scheduled');

						if($schedule_check['cnt'] == 0) {
							$data = array(
								'schedule_type' => 'scheduled',
								'start_day' => $td,
								'start_time' => $wul['work_start'],
								'end_day' => $td,
								'end_time' => $wul['work_end'],
								'participant' => $wul['user_name'],
								'participant_seq' => $wul['seq'],
								'user_name' => '자동등록'
							);

							$this->STC_Crontab->scheduled_work_insert($data);
						}
					}
				}
			}
		}
  }

	function access_log_insert() {
		$target_date = $this->input->get('target_date');

		if($target_date != '') {
			$target_date = date('Ymd', strtotime($target_date));
		} else {
			$target_date = date('Ymd', strtotime('-4 day'));
		}

		$work_user_list = $this->STC_Crontab->work_user_list();

		foreach($work_user_list as $wul) {
			for($td = $target_date; $td < date('Ymd'); $td = date('Ymd', strtotime("+1 days", strtotime($td)))) {
				echo $td.'<br>';
				$access_log = $this->STC_Crontab->access_log($td, $wul['user_name']);
				// var_dump($access_log);
				$schedule_check = $this->STC_Crontab->schedule_check($td, $wul['seq'], 'actual');

				$data = array(
					'schedule_type' => 'actual',
					'start_day' => $td,
					'start_time' => $access_log['start_time'],
					'end_day' => $td,
					'end_time' => $access_log['end_time'],
					'participant' => $wul['user_name'],
					'participant_seq' => $wul['seq'],
					'user_name' => '자동등록'
				);

				if($schedule_check['cnt'] == 0) {
					$this->STC_Crontab->scheduled_work_insert($data);
				} else {
					$this->STC_Crontab->scheduled_work_update($data, $schedule_check['seq']);
				}
			}
		}
	}

}
