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

		$sql = "SELECT bnb.seq, bnb.category_code, bnb.subject, bnb.user_id, bnb.user_name, bnb.file_changename, bnb.update_date, bnr2.user_seq FROM biz_notice_basic bnb LEFT JOIN ( SELECT user_seq, notice_seq FROM biz_notice_read GROUP BY notice_seq, user_seq HAVING user_seq = ".$this->seq." ) AS bnr2 ON bnb.seq = bnr2.notice_seq WHERE{$category_query} ORDER BY seq DESC LIMIT 5";

		$sql = "SELECT bnb.seq, bnb.category_code, bnb.subject, bnb.user_id, bnb.user_name, bnb.file_changename, bnb.update_date, bnr2.user_seq FROM biz_notice_basic bnb LEFT JOIN ( SELECT user_seq, notice_seq FROM biz_notice_read GROUP BY notice_seq, user_seq HAVING user_seq = ".$this->seq." ) AS bnr2 ON bnb.seq = bnr2.notice_seq WHERE{$category_query} AND hide_btn = 'N' AND temporary = 'N' ORDER BY seq DESC LIMIT 5";

		$query = $this->db->query($sql);

    return $query->result_array();
	}

	function notice_list_count($category_code) {
		if($category_code == "002"){
			$category_query = " (category_code = '002' OR category_code = '004')";
		}else{
			$category_query = " category_code = '{$category_code}'";
		}
		$sql = "SELECT count(seq) AS ucount FROM biz_notice_basic WHERE$category_query AND hide_btn = 'N' AND temporary = 'N' ORDER BY seq DESC";

		$query = $this->db->query($sql);

		return $query->row();
	}

	function notice_list_nread_count($category_code) {
		if($category_code == "002"){
			$category_query = " (category_code = '002' OR category_code = '004')";
		}else{
			$category_query = " category_code = '{$category_code}'";
		}
		$sql = "SELECT COUNT(*) AS ucount FROM biz_notice_basic bnb LEFT JOIN ( SELECT user_seq, notice_seq FROM biz_notice_read GROUP BY notice_seq, user_seq HAVING user_seq = ".$this->seq." ) AS bnr2 ON bnb.seq = bnr2.notice_seq WHERE$category_query AND user_seq IS null AND hide_btn = 'N'  AND temporary = 'N' ORDER BY seq DESC;";

		$query = $this->db->query($sql);

		return $query->row();
	}

	function user_data(){
		$sql = "SELECT user_id, user_name, user_duty, user_email, user_tel, extension_number, user_group FROM user WHERE quit_date is null ORDER BY seq";

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
		$user_seq = $this->seq;
		$user_group = $this->group;
		$pGroupName = $this->pGroupName;

		if($user_group == "CEO" || $pGroupName == "기술연구소") {
			$group = "";
		} else if($pGroupName == '기술본부') { //김갑진 이사님
			$group = " WHERE group_name like '기술%' and group_name != '기술연구소'";
		} else if($pGroupName == '영업본부') {
			$group = " WHERE group_name like '사업%'";
		} else {
			$group = " WHERE group_name = '{$user_group}'";
		}

		$sql = "SELECT * FROM weekly_report LEFT JOIN (SELECT user_seq, notice_seq FROM weekly_report_read GROUP BY notice_seq, user_seq HAVING user_seq = {$user_seq}) AS wrr ON seq = wrr.notice_seq".$group." ORDER BY seq DESC LIMIT 10";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function weekly_report_list_nread_count() {
		$user_seq = $this->seq;
		$user_group = $this->group;
		$pGroupName = $this->pGroupName;

		if($user_group == "CEO" || $pGroupName == "기술연구소") {
			$group = "";
		} else if($pGroupName == '기술본부') { //김갑진 이사님
			$group = " AND group_name like '기술%' and group_name != '기술연구소'";
		} else if($pGroupName == '영업본부') {
			$group = " AND group_name like '사업%'";
		} else {
			$group = " AND group_name = '{$user_group}'";
		}

		$sql = "SELECT count(*) as cnt FROM weekly_report LEFT JOIN (SELECT user_seq, notice_seq FROM weekly_report_read GROUP BY notice_seq, user_seq HAVING user_seq = {$user_seq}) AS wrr ON seq = wrr.notice_seq WHERE wrr.user_seq is null ".$group." ORDER BY seq DESC";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function weekly_report_list_count() {
		$user_seq = $this->seq;
		$user_group = $this->group;
		$pGroupName = $this->pGroupName;

		if($user_group == "CEO" || $pGroupName == "기술연구소") {
			$group = "";
		} else if($pGroupName == '기술본부') { //김갑진 이사님
			$group = " WHERE group_name like '기술%' and group_name != '기술연구소'";
		} else if($pGroupName == '영업본부') {
			$group = " WHERE group_name like '사업%'";
		} else {
			$group = " WHERE group_name = '{$user_group}'";
		}

		$sql = "SELECT count(*) AS cnt FROM weekly_report".$group;

		$query = $this->db->query($sql);

		return $query->row();
	}

	function diquitaca_qna_list() {
		$sql = "SELECT dq.*, u.user_name, dqc.comment_cnt, dqr.user_seq, dc.category_name, dc.color FROM diquitaca_qna dq LEFT JOIN user u ON dq.insert_id = u.user_id LEFT JOIN (SELECT qna_seq, COUNT(*) AS comment_cnt FROM diquitaca_qna_comment GROUP BY qna_seq) dqc ON dq.seq = dqc.qna_seq LEFT JOIN (SELECT user_seq, notice_seq FROM diquitaca_qna_read GROUP BY notice_seq, user_seq HAVING user_seq = {$this->seq}) AS dqr ON dq.seq = dqr.notice_seq LEFT JOIN diquitaca_category dc ON dq.category = dc.seq order by dq.seq desc limit 3";
// echo $sql;
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function diquitaca_qna_list_nread_count() {
		$sql = "SELECT count(*) as cnt FROM diquitaca_qna dq LEFT JOIN user u ON dq.insert_id = u.user_id LEFT JOIN (SELECT qna_seq, COUNT(*) AS comment_cnt FROM diquitaca_qna_comment GROUP BY qna_seq) dqc ON dq.seq = dqc.qna_seq LEFT JOIN (SELECT user_seq, notice_seq FROM diquitaca_qna_read GROUP BY notice_seq, user_seq HAVING user_seq = {$this->seq}) AS dqr ON dq.seq = dqr.notice_seq where dqr.user_seq is null";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function fortigate_project() {
		$sql = "(SELECT sf.customer_companyname, sf.project_name, sf.manage_team, sf.maintain_user
FROM product p
JOIN sales_forcasting_product sfp ON p.seq = sfp.product_code
JOIN sales_forcasting sf ON sfp.forcasting_seq = sf.seq
WHERE (p.product_name LIKE '%fortigate%' || p.product_name LIKE '%fg-%') AND (sfp.fortigate_licence IS NULL || sfp.fortigate_licence = '') AND progress_step > '014' GROUP BY sf.seq)
UNION
(SELECT sm.customer_companyname, sm.project_name, sm.manage_team, sm.maintain_user
FROM product p
JOIN sales_maintain_product smp ON p.seq = smp.product_code
JOIN sales_maintain sm ON smp.maintain_seq = sm.seq
WHERE (p.product_name LIKE '%fortigate%' || p.product_name LIKE '%fg-%') AND (smp.fortigate_licence IS NULL || smp.fortigate_licence = '') AND progress_step > '014' GROUP BY sm.seq) order by manage_team desc";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

}
?>
