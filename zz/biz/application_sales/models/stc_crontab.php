<?php
header("Content-type: text/html; charset=utf-8");

class STC_Crontab extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function holiday_count($locdate, $mode = 0) {
		$where = '';
		if($mode == 'attendance'){
			$where = " and dateName NOT IN ('임시공휴일', '대체공휴일')";
		}
		$sql = "select count(*) as cnt from holiday where locdate = {$locdate} {$where}";

		$query = $this->db->query($sql);

		return $query->row();
	}

	function holiday_insert($locdate, $dateName) {
		$sql = "insert into holiday (locdate, dateName, insert_date) values ('{$locdate}','{$dateName}',now())";

		$query = $this->db->query($sql);
	}

	function attendance_user() {
		$sql = "SELECT u.*, a.card_num, a.ws_time, a.wc_time FROM (SELECT seq, user_id, user_name, user_duty, user_group FROM user WHERE quit_date IS NULL) AS u
LEFT JOIN attendance_user AS a
ON u.seq = a.user_seq";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function date_info($date, $user){

		$sql = "SELECT d.*, a.* FROM (SELECT '{$date}' AS e_date,
		   CASE WEEKDAY('{$date}')
		   	WHEN '0' THEN '월'
		   	WHEN '1' THEN '화'
		   	WHEN '2' THEN '수'
		   	WHEN '3' THEN '목'
		   	WHEN '4' THEN '금'
		   	WHEN '5' THEN '토'
		   	WHEN '6' THEN '일'
		   END AS dayoftheweek,
		   (SELECT dateName FROM holiday WHERE locdate = '{$date}') AS date_name) d
LEFT JOIN
(SELECT annual_start_date, annual_end_date,
			CASE
				WHEN (annual_type = '003' && annual_type2 = '001') THEN '연차'
				WHEN (annual_type = '003' && annual_type2 = '002') THEN '오전반차'
				WHEN (annual_type = '003' && annual_type2 = '003') THEN '오후반차'
				WHEN (annual_type = '001') THEN '보건휴가'
				WHEN (annual_type = '002') THEN '출산휴가'
				WHEN (annual_type = '004') THEN '특별유급휴가'
				WHEN (annual_type = '005') THEN '공가'
		      ELSE ''
		   END AS annual_type
FROM electronic_approval_annual
WHERE user_id = '{$user}'
AND annual_status = 'Y') AS a
ON d.e_date >= REPLACE(a.annual_start_date,'-','') AND d.e_date <= REPLACE(a.annual_end_date,'-','')";

 $query = $this->db->query($sql);
 $result = $query->row_array();
 return $result;

}



	function before_attendance($beforeDay) {
		$sql = "select * from attendance_manual where date = '{$beforeDay}' and status not in ('연차', '오전반차', '오후반차', '보건휴가', '출산휴가', '특별유급휴가', '공가')";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function update_before_attendance($seq,$status) {
		$sql = "update attendance_manual set status = '{$status}' where seq = {$seq}";

		$this->db->query($sql);
	}

	function attendance_count($card_num, $date) {
		$sql = "select count(*) as cnt from attendance_manual where card_num = '{$card_num}' and date = '{$date}'";

		$query = $this->db->query($sql);

		return $query->row();
	}

	function annual($card_num, $date) {
		$sql = "SELECT eaa.*, u.seq AS user_seq, au.card_num
FROM electronic_approval_annual eaa
JOIN USER u ON eaa.user_id = u.user_id
JOIN attendance_user au ON u.seq = au.user_seq
WHERE annual_status = 'Y' AND card_num = '{$card_num}' AND '{$date}' BETWEEN annual_start_date AND annual_end_date";

		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	function official_time($card_num) {
		$sql = "select ws_time, wc_time from attendance_user where card_num = '{$card_num}'";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function attendance_input($data) {
		$this->db->insert('attendance_manual', $data);
	}


	function work_time($date, $id){
		$sql = "SELECT *, IF(e_time <= 090000, '090000', e_time ) AS work_time FROM adt_access_log WHERE e_id ='{$id}' AND e_date = '{$date}' ORDER BY e_time";
		$query = $this->db->query($sql);
		return $query->result_array();

	}

	function go_leave_work($date, $id){
		$sql = "SELECT (SELECT MIN(e_time) FROM adt_access_log WHERE e_id ='{$id}' AND e_date = '{$date}' AND (g_id='0002' OR g_id = '0004')) AS s_time,
(SELECT MAX(e_time) FROM adt_access_log WHERE e_id ='{$id}' AND e_date = '{$date}' AND g_id='0003') AS e_time";

		$query = $this->db->query($sql);
		return $query->row();
	}

	function insert_adt($data){
		$this->db->insert('adt_attendance', $data);
	}

}
?>