<?php
header("Content-type: text/html; charset=utf-8");

class STC_Dashboard extends CI_Model {

	function __construct() {

		parent::__construct();
    $this->id = $this->phpsession->get( 'id', 'stc' );
    $this->name = $this->phpsession->get( 'name', 'stc' );
    $this->lv = $this->phpsession->get( 'lv', 'stc' );
    $this->cnum = $this->phpsession->get( 'cnum', 'stc' );
		$this->seq = $this->phpsession->get( 'seq', 'stc' );
	}

  // 회원관리
  function member_management(){
    $sql = "SELECT seq, user_id, user_name, confirm_flag FROM user order by seq";
  // echo $sql;
    $query = $this->db->query($sql);

    return $query->result_array();
  }

  // 건강검진 관리대장
  function health_certificate(){
    $sql = "SELECT hc.*, u.user_name FROM health_certificate hc JOIN user u ON u.user_id = hc.write_id ORDER BY seq desc LIMIT 5";
// echo $sql;
		$query = $this->db->query($sql);

		return $query->result_array();
  }

  // 내부서류
  function document_basic(){
    $sql = "SELECT seq, document_name, user_name, update_date FROM document_basic ORDER BY seq DESC LIMIT 5";
  // echo $sql;
    $query = $this->db->query($sql);

    return $query->result_array();
  }

  // 공지사항
  function notice_basic(){
    $sql = "SELECT seq, subject, user_name, update_date FROM notice_basic ORDER BY seq desc LIMIT 5";
  // echo $sql;
    $query = $this->db->query($sql);

    return $query->result_array();
  }

	function schedule_count($admin, $user_seq) {
		if($admin == 'Y') {
			$participant = '';
		} else {
			$participant = " AND participant_seq = {$user_seq}";
		}

		$sql = "SELECT COUNT(CASE WHEN schedule_type = 'scheduled' THEN 1 END) AS 'scheduled_cnt', COUNT(CASE WHEN schedule_type = 'actual' THEN 1 END) AS 'actual_cnt', COUNT(CASE WHEN schedule_type = 'confirmation' THEN 1 END) AS 'confirmation_cnt'
FROM schedule_list
WHERE DATE_FORMAT(NOW(), '%Y-%m-%d') >= start_day AND DATE_FORMAT(NOW(), '%Y-%m-%d') <= end_day {$participant}";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function schedule($admin, $user_seq) {
		if($admin == 'Y') {
			$participant = '';
		} else {
			$participant = " AND participant_seq = {$user_seq}";
		}

		$sql = "SELECT * FROM schedule_list WHERE 1=1 {$participant}";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function schedule_list($admin, $user_seq, $date, $schedule_type) {
		if($admin == 'Y') {
			$participant = '';
		} else {
			$participant = " AND participant_seq = {$user_seq}";
		}

		if($schedule_type != '') {
			$schedule_type = join("','", $schedule_type);
			$schedule_type = " AND schedule_type IN ('{$schedule_type}')";
		} else {
			$schedule_type = " AND schedule_type IN ('')";
		}

		// $sql = "SELECT * FROM schedule_list WHERE $날짜 >= start_day AND $날짜 <= end_day {$participant}";
		$sql = "SELECT * FROM schedule_list WHERE start_day <= '{$date}' AND end_day >= '{$date}' {$participant} {$schedule_type} order by start_time asc";

		$query = $this->db->query($sql);

		return $query->result_array();
	}
}

?>
