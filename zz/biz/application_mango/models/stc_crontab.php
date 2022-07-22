<?php
header("Content-type: text/html; charset=utf-8");

class STC_Crontab extends CI_Model {

	function __construct() {

		parent::__construct();

	}

	function work_user_list() {
		$sql = "SELECT * FROM user WHERE confirm_flag = 'Y'";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function scheduled_work_insert($data) {
		$this->db->insert('schedule_list', $data);
	}

	function access_log($target_date, $user_name) {
		$sql = "SELECT MIN(e_time) as start_time, MAX(e_time) as end_time FROM stc.adt_access_log WHERE e_name = '{$user_name}' AND e_date = '{$target_date}' AND g_id = '0001' ORDER BY e_date DESC, e_time DESC";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function scheduled_work_update($data, $seq) {
		$this->db->where('seq', $seq);
		$this->db->update('schedule_list', $data);
	}

	function schedule_check($date, $user_seq, $schedule_type) {
		$sql = "SELECT count(*) as cnt, seq FROM schedule_list WHERE start_day = '{$date}' and participant_seq = {$user_seq} and schedule_type = '{$schedule_type}'";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

}
?>
