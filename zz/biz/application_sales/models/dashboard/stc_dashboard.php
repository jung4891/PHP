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

	function notice_list($category_code){
		if($category_code == "002"){
			$category_query = " (category_code = '002' OR category_code = '004')";
		}else{
			$category_query = " category_code = '{$category_code}'";
		}

		$sql = "SELECT seq, category_code, subject, user_id, user_name, file_changename, update_date FROM biz_notice_basic WHERE{$category_query} ORDER BY seq DESC LIMIT 5";

		$query = $this->db->query($sql);

    return $query->result_array();
	}

	function notice_list_count($category_code) {
		if($category_code == "002"){
			$category_query = " (category_code = '002' OR category_code = '004')";
		}else{
			$category_query = " category_code = '{$category_code}'";
		}
		$sql = "SELECT count(seq) AS ucount FROM biz_notice_basic WHERE$category_query ORDER BY seq DESC";

		$query = $this->db->query($sql);

		return $query->row();
	}

	function user_data(){
		$sql = "SELECT user_id, user_name, user_duty, user_email, user_tel, user_group FROM user WHERE quit_date is null ORDER BY seq";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function schedule(){
		$sql = "SELECT * FROM tech_schedule_list WHERE participant LIKE '%{$this->name}%'";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function attendance_info(){
		$sql = "SELECT card_num, ws_time AS designate_ws, wc_time AS designate_wc FROM attendance_user WHERE user_seq = '{$this->seq}'";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	function attendance_today($card_num=0){
		$today = date("Ymd");
		$sql = "SELECT ws_time, wc_time FROM attendance_manual WHERE card_num = '{$card_num}' AND date = '$today'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	function attendance_count($card_num=0,$mode){
		$today = date("Ym");
		if ($mode == "normal"){
			$str = ' AND ((ws_time != "" AND wc_time != "") OR status in ("연차","오전반차","오후반차","보건휴가","출산휴가","특별유급휴가","공가")) AND date != DATE_FORMAT(now(), "%Y%m%d")';
		} else if ($mode == "abnormal"){
			$str = ' AND ((ws_time != "" AND wc_time = "") OR (ws_time = "" AND wc_time != "") OR (ws_time = "" AND wc_time ="" AND date_type IS NULL AND status NOT IN ("연차","오전반차","오후반차","보건휴가","출산휴가","특별유급휴가","공가"))) AND date != DATE_FORMAT(now(), "%Y%m%d")';
		} else if ($mode == 'real'){
			$str = ' AND (ws_time != "" OR wc_time != "") AND date != DATE_FORMAT(now(), "%Y%m%d")';
		}
		$sql = "SELECT COUNT(*) AS cnt FROM attendance_manual WHERE card_num = '{$card_num}' AND date LIKE '{$today}%'".$str;
		$query = $this->db->query($sql);
		// echo $mode." : ".$sql."<br>";
		return $query->row_array();
	}

	function count_attendance_manual($card_num, $date) {
		$sql = "SELECT count(seq) AS ucount FROM attendance_manual WHERE card_num = '{$card_num}' AND date = '{$date}'";

		$query = $this->db->query($sql);

		return $query->row();
	}

	function info_attendance_manual($card_num, $date) {
		$sql = "SELECT * FROM attendance_manual WHERE card_num = '{$card_num}' AND date = '{$date}'";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function input_attendance_manual($data) {
		$result = $this->db->insert('attendance_manual', $data );

		$sql = "update attendance_manual SET STATUS = (SELECT CASE WHEN ((am.STATUS != '연차' && am.STATUS != '오전반차' && am.STATUS != '오후반차' && am.STATUS != '보건휴가' && am.STATUS != '출산휴가' && am.STATUS != '특별유급휴가' && am.STATUS != '공가') && (am.ws_time = '' || am.wc_time= '')) THEN '미처리'
	  	        ELSE am.status
	            END AS STATUS  FROM attendance_manual AS am LEFT JOIN attendance_user AS au ON am.card_num = au.card_num WHERE am.card_num = '{$data['card_num']}' AND am.DATE < '{$data['date']}' ORDER BY DATE DESC LIMIT 1)
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
			$sql = "UPDATE attendance_manual SET ws_time = '{$sc_time}', ws_ip_address = '{$ip_address}', write_id = '{$this->id}' WHERE card_num = '{$card_num}' AND date = '{$date}'";
		} else {
			$sql = "UPDATE attendance_manual SET wc_time = '{$sc_time}', wc_ip_address = '{$ip_address}', write_id = '{$this->id}' WHERE card_num = '{$card_num}' AND date = '{$date}'";
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
	// 	$sql = "SELECT count(*) AS cnt FROM attendance WHERE name = '{$this->name}' AND work_date = curdate()";
	//
	// 	$query = $this->db->query($sql);
	//
	// 	return $query->row();
	// }

	function my_schedule($name) {
	  $sql = "SELECT count(*) AS cnt FROM tech_schedule_list WHERE participant LIKE '%{$name}%' AND curdate() between start_day AND end_day";
	  $query = $this->db->query($sql);

	  return $query->row();
	}

	function holiday_list($target_date) {
		$sql = "SELECT locdate FROM holiday WHERE locdate LIKE '{$target_date}%'";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function holiday_count($target_date) {
		$sql = "SELECT count(*) AS cnt FROM holiday WHERE locdate like '{$target_date}%'";

		$query = $this->db->query($sql);

		return $query->row();
	}

	function reservartion_room($day) {
	  $sql = "SELECT a.room_name AS room, b.* FROM meeting_room a LEFT JOIN ( SELECT * FROM tech_schedule_list WHERE '{$day}' BETWEEN start_day AND end_day) b ON b.room_name LIKE CONCAT('%',a.room_name,'%') ORDER BY a.room_name DESC;";
	  $query = $this->db->query($sql);
	  return $query->result_array();
	}

	function reservartion_car($day) {
	  $sql = "SELECT a.type, b.* FROM (select * FROM admin_car WHERE user_name = '공용') a LEFT join (SELECT * FROM tech_schedule_list WHERE '{$day}' BETWEEN start_day AND end_day) b ON concat(a.type,a.number) = b.car_name ORDER BY a.seq";
	  $query = $this->db->query($sql);
	  return $query->result_array();
	}

	function weekly_report_list() {
		$sql = "SELECT * FROM weekly_report ORDER BY seq DESC LIMIT 10";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function weekly_report_list_count() {
		$sql = "SELECT count(*) AS cnt FROM weekly_report";

		$query = $this->db->query($sql);

		return $query->row();
	}

}
?>