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

	function notice_list(){
		$sql = "select seq, category_code, subject, user_id, user_name, file_changename, update_date from biz_notice_basic order by seq desc limit 5";

		$query = $this->db->query($sql);

    return $query->result_array();
	}

	function notice_list_count() {
		$sql = "select count(seq) as ucount from biz_notice_basic order by seq desc";

		$query = $this->db->query($sql);

		return $query->row();
	}

	function user_data(){
		$sql = "select user_id, user_name, user_duty, user_email, user_tel, user_group from user order by seq";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function schedule(){
		$sql = "select * from tech_schedule_list where participant like '%{$this->name}%'";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function attendance_info(){
		$sql = "select card_num, ws_time as designate_ws, wc_time as designate_wc from attendance_user where user_seq = '{$this->seq}'";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	function attendance_today($card_num=0){
		$today = date("Ymd");
		$sql = "SELECT ws_time, wc_time from attendance_manual where card_num = '{$card_num}' and date = '$today'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	function attendance_count($card_num=0,$mode){
		$today = date("Ym");
		if ($mode == "normal"){
			$str = ' AND ((ws_time != "" and wc_time != "") or status in ("연차","오전반차","오후반차","보건휴가","출산휴가","특별유급휴가","공가")) and date != DATE_FORMAT(now(), "%Y%m%d")';
		} else if ($mode == "abnormal"){
			$str = ' AND ((ws_time != "" and wc_time = "") or (ws_time = "" and wc_time != "") or (ws_time = "" and wc_time ="" and date_type is null and status not in ("연차","오전반차","오후반차","보건휴가","출산휴가","특별유급휴가","공가"))) and date != DATE_FORMAT(now(), "%Y%m%d")';
		} else if ($mode == 'real'){
			$str = ' AND (ws_time != "" or wc_time != "") and date != DATE_FORMAT(now(), "%Y%m%d")';
		}
		$sql = "SELECT COUNT(*) AS cnt FROM attendance_manual WHERE card_num = '{$card_num}' AND date LIKE '{$today}%'".$str;
		$query = $this->db->query($sql);
		// echo $mode." : ".$sql."<br>";
		return $query->row_array();
	}

	function count_attendance_manual($card_num, $date) {
		$sql = "select count(seq) as ucount from attendance_manual where card_num = '{$card_num}' and date = '{$date}'";

		$query = $this->db->query($sql);

		return $query->row();
	}

	function info_attendance_manual($card_num, $date) {
		$sql = "select * from attendance_manual where card_num = '{$card_num}' and date = '{$date}'";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function input_attendance_manual($data) {
		$result = $this->db->insert('attendance_manual', $data );

		$sql = "update attendance_manual SET STATUS = (SELECT CASE WHEN ((am.STATUS != '연차' && am.STATUS != '오전반차' && am.STATUS != '오후반차' && am.STATUS != '보건휴가' && am.STATUS != '출산휴가' && am.STATUS != '특별유급휴가' && am.STATUS != '공가') && (am.ws_time = '' || am.wc_time= '')) THEN '미처리'
	  	        ELSE am.status
	            END as STATUS  FROM attendance_manual as am left JOIN attendance_user AS au ON am.card_num = au.card_num WHERE am.card_num = '{$data['card_num']}' AND am.DATE < '{$data['date']}' ORDER BY DATE DESC LIMIT 1)
				WHERE card_num ='{$data['card_num']}' AND DATE < '{$data['date']}' ORDER BY DATE DESC LIMIT 1";

		$result = $this->db->query($sql);
		if($result){
			return "true";
		}else{
			return "false";
		}

	}

	function update_attendance_manual($card_num, $date, $sc_time, $ip_address, $mode) {
		if ($mode == 'ws_time'){
			$sql = "update attendance_manual set ws_time = '{$sc_time}', ws_ip_address = '{$ip_address}', write_id = '{$this->id}' where card_num = '{$card_num}' and date = '{$date}'";
		} else {
			$sql = "update attendance_manual set wc_time = '{$sc_time}', wc_ip_address = '{$ip_address}', write_id = '{$this->id}' where card_num = '{$card_num}' and date = '{$date}'";
		}
		// echo $sql;
		$result = $this->db->query($sql);
		if($result){
			return "true";
		}else{
			return "false";
		}
	}

	// function attendance_today_count(){
	// 	$sql = "select count(*) as cnt from attendance where name = '{$this->name}' and work_date = curdate()";
	//
	// 	$query = $this->db->query($sql);
	//
	// 	return $query->row();
	// }

	function my_schedule($name) {
	  $sql = "SELECT count(*) as cnt from tech_schedule_list where participant like '%{$name}%' and curdate() between start_day and end_day";
	  $query = $this->db->query($sql);

	  return $query->row();
	}

	function holiday_list($target_date) {
		$sql = "SELECT locdate from holiday where locdate like '{$target_date}%'";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function holiday_count($target_date) {
		$sql = "SELECT count(*) as cnt from holiday where locdate like '{$target_date}%'";

		$query = $this->db->query($sql);

		return $query->row();
	}

	function reservartion_room($day) {
	  $sql = "SELECT a.room_name AS room, b.* FROM meeting_room a LEFT JOIN ( SELECT * FROM tech_schedule_list WHERE '{$day}' BETWEEN start_day AND end_day) b ON b.room_name LIKE CONCAT('%',a.room_name,'%') ORDER BY a.room_name DESC;";
	  $query = $this->db->query($sql);
	  return $query->result_array();
	}

	function reservartion_car($day) {
	  $sql = "SELECT a.type, b.* FROM (select * from admin_car where user_name = '공용') a left join (SELECT * FROM tech_schedule_list where '{$day}' BETWEEN start_day AND end_day) b ON concat(a.type,a.number) = b.car_name ORDER BY a.seq";
	  $query = $this->db->query($sql);
	  return $query->result_array();
	}

	function weekly_report_list() {
		$sql = "SELECT * from weekly_report order by seq desc limit 10";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function weekly_report_list_count() {
		$sql = "SELECT count(*) as cnt from weekly_report";

		$query = $this->db->query($sql);

		return $query->row();
	}

}
 ?>
