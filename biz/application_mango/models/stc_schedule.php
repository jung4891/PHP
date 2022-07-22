<?php
header("Content-type: text/html; charset=utf-8");

class STC_Schedule extends CI_Model {

	function __construct() {

		parent::__construct();

	}

	function schedule_list() {
		$sql = "SELECT * FROM schedule_list";

		$query = $this->db->query($sql);

		return $query->result();
	}

	function schedule_list_user($group_list, $start, $end, $scheduled_schedule, $actual_schedule, $confirmation_schedule){
    if(is_array($group_list['participant'])){
      $participant_name = implode( '|', $group_list['participant'] );
    }else{
      $participant_name = "no_one";
    }

		$schedule_type = '';

		if($scheduled_schedule != 'true') {
			$schedule_type .= ' AND sl.schedule_type != "scheduled"';
		}

		if($actual_schedule != 'true') {
			$schedule_type .= ' AND sl.schedule_type != "actual"';
		}

		if($confirmation_schedule != 'true') {
			$schedule_type .= ' AND sl.schedule_type != "confirmation"';
		}

		if($schedule_type != '') {
			$schedule_type = " and (1=1 ".$schedule_type.")";
		}

		$sql = "SELECT * FROM schedule_list WHERE (participant regexp '{$participant_name}' or user_name regexp '{$participant_name}') AND start_day >= '{$start}' AND end_day < '{$end}'";
		$sql = "SELECT sl.*, sw.seq as work_color_seq, sw.color, sw.textColor FROM schedule_list sl left join schedule_work sw on sl.schedule_type = sw.schedule_type WHERE (participant regexp '{$participant_name}' or user_name regexp '{$participant_name}') AND start_day >= '{$start}' AND end_day < '{$end}' {$schedule_type}";
// echo $sql.'<br>';
    $query = $this->db->query($sql);
    return $query->result();
  }

	function work_color_list(){
		$sql = "SELECT * FROM schedule_work ORDER BY seq";
		return $this->db->query($sql)->result();
	}

	function details($seq){
	  $where = "WHERE seq={$seq}";

	  $sql = "SELECT * FROM schedule_list {$where}";

	  $query = $this->db->query($sql);
	  $result = $query->row();
	  return $result;
	}

	function group_list(){
	  $sql = "SELECT schedule_type FROM schedule_work";
	  $query = $this->db->query($sql);
	  $result = $query->result();
	  return $result;
	}

	function work_user_list() {
		$searchString = "";
		if($this->admin == 'N') {
			$searchString = " AND seq = '{$this->seq}'";
		}

		$sql = "SELECT * FROM user WHERE confirm_flag = 'Y' {$searchString} order by user_name";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function insert_schedule($seq, $data) {
		if($seq == '') {
			$result = $this->db->insert('schedule_list', $data);
		} else {
			$this->db->where('seq', $seq);
			$result = $this->db->update('schedule_list', $data);
		}

		return $result;
	}

	function delete_schedule($seq) {
		$sql = "DELETE FROM schedule_list where seq = {$seq}";

		$query = $this->db->query($sql);

		return $query;
	}

	function make_timeTable($user_seq) {
		$sql = "SELECT work_start, work_end FROM user WHERE seq = {$user_seq}";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function schedule_check($date, $user_seq, $schedule_type) {
		$sql = "SELECT count(*) as cnt, seq FROM schedule_list WHERE start_day = '{$date}' and participant_seq = {$user_seq} and schedule_type = '{$schedule_type}'";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

}
?>
