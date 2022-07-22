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

	function maintain_auto_generate_target($today) {
		$sql = "SELECT seq
						FROM sales_forcasting
						WHERE warranty_end_date IS NOT NULL
						AND warranty_end_date != ''
						AND ((TYPE = '4' OR TYPE = '1') AND sales_type = 'delivery')
						AND warranty_end_date = DATE_ADD('{$today}', INTERVAL -6 MONTH)
						ORDER BY seq";
// echo $sql;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//포캐스팅 테이블 -> 유지보수 테이블 복사(sales_forcasting,sales_forcasting_proudct,sales_forcasting_mocompany)
	function forcasting_duplication($data){
		$seq = $data['forcasting_seq'];
		$sql = "INSERT INTO sales_maintain
		(forcasting_seq,
		TYPE,
		generate_type,
		customer_seq,
		customer_companyname,
		customer_username,
		customer_tel,
		customer_email,
		project_name,
		progress_step,
		upper_seq,
		sales_companyname,
		sales_username,
		dept,
		sales_tel,
		sales_email,
		cooperation_companyname,
		cooperation_username,
		cooperation_tel,
		cooperation_email,
		first_saledate,
		exception_saledate,
		exception_saledate2,
		exception_saledate3,
		complete_status,
		cnum,
		company_num,
		manage_team,
		maintain_cycle,
		maintain_date,
		maintain_user,
		maintain_type,
		maintain_result,
		maintain_comment,
		procurement_sales_amount,
		forcasting_sales,
		forcasting_purchase,
		forcasting_profit,
		division_month,
		sub_project_add,
		file) SELECT seq as forcasting_seq,
		TYPE,
		'신규' as generate_type,
		customer_seq,
		customer_companyname,
		customer_username,
		customer_tel,
		customer_email,
		'{$data['project_name']}' as project_name,
		'{$data['progress_step']}' as progress_step,
		upper_seq,
		sales_companyname,
		sales_username,
		dept,
		sales_tel,
		sales_email,
		cooperation_companyname,
		cooperation_username,
		cooperation_tel,
		cooperation_email,
		first_saledate,
		exception_saledate,
		exception_saledate2,
		DATE_ADD(exception_saledate2, INTERVAL 1 YEAR) as exception_saledate3,
		complete_status,
		cnum,
		company_num,
		manage_team,
		maintain_cycle,
		maintain_date,
		maintain_user,
		maintain_type,
		maintain_result,
		maintain_comment,
		procurement_sales_amount,
		0 as forcasting_sales,
		0 as forcasting_purchase,
		0 as forcasting_profit,
		division_month,
		sub_project_add,
		file FROM sales_forcasting WHERE seq = {$seq} ";
		$query1 = $this->db->query($sql);
		$maintain_seq = $this->db->insert_id();

		$sql2 = "INSERT INTO sales_maintain_product
		(forcasting_seq,
		org_maintain_seq,
		maintain_seq,
		forcasting_product_seq,
		product_code,
		product_supplier,
		product_count,
		product_serial,
		product_state,
		product_licence,
		product_version,
		product_purpose,
		product_host,
		maintain_begin,
		maintain_expire,
		maintain_yn,
		maintain_target,
		insert_date,
		custom_title,
		custom_detail,
		product_sales,
		product_purchase,
		product_profit,
		product_check_list
		) SELECT forcasting_seq,
		{$maintain_seq} AS maintain_seq,
		{$maintain_seq} AS org_maintain_seq,
		seq as forcasting_product_seq,
		product_code,
		product_supplier,
		product_count,
		product_serial,
		product_state,
		product_licence,
		product_version,
		product_purpose,
		product_host,
		maintain_begin,
		maintain_expire,
		maintain_yn,
		maintain_target,
		insert_date,
		custom_title,
		custom_detail,
		0 as product_sales,
		0 as product_purchase,
		0 as product_profit,
		product_check_list FROM sales_forcasting_product WHERE forcasting_seq = {$seq}";

		$sql3 = "INSERT INTO sales_maintain_mcompany
		(forcasting_seq,
		maintain_seq,
		main_companyname,
		main_username,
		main_tel,
		main_email,
		insert_date
		)
		SELECT forcasting_seq,
		{$maintain_seq} as maintain_seq,
		main_companyname,
		main_username,
		main_tel,
		main_email,
		now() as insert_date
	    FROM sales_forcasting_mcompany WHERE forcasting_seq = {$seq}";

		// $sql4 = "UPDATE sales_maintain set write_id = '{$this->id}' where seq = {$maintain_seq}";

		$query2 = $this->db->query($sql2);
		$query3 = $this->db->query($sql3);
		// $query4 = $this->db->query($sql4);

		if($query1 == true && $query2 == true && $query3 == true){
			return $maintain_seq;
		}else{
			return false;
		}
	}

	function maintain_auto_renewal($today) {
		// $sql = "SELECT seq FROM sales_maintain WHERE (exception_saledate2 is not null and exception_saledate2 != '') and exception_saledate3 < '{$today}' AND (progress_step > '014' and progress_step is not null and progress_step != '' )";

		$sql = "SELECT seq FROM sales_maintain WHERE (forcasting_seq, seq) IN (SELECT forcasting_seq, MAX(seq) AS seq FROM sales_maintain GROUP BY forcasting_seq) AND (exception_saledate2 is not null and exception_saledate2 != '') and (exception_saledate3 is not null and exception_saledate3 != '') AND (forcasting_sales > 0 or forcasting_purchase > 0) ORDER BY seq DESC";
echo $sql;
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function fund_list_paysession_target() {
		$sql = "SELECT
REPLACE(bfl.bill_seq, 'm_', '') AS bill_seq, fl.*
FROM bill_fund_link bfl
JOIN fund_list fl ON bfl.fund_list_seq = fl.idx
WHERE breakdown NOT LIKE '%회차%' AND bill_seq LIKE '%m_%'";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function paysession($seq) {
		$sql = "SELECT pay_session FROM sales_maintain_bill where seq = $seq";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function fund_list_paysession_update($idx, $breakdown, $paysession) {
		$breakdown = addslashes($breakdown);
		$sql = "UPDATE fund_list SET breakdown = '{$breakdown} ({$paysession}회차)' where idx = $idx";

		$this->db->query($sql);
	}

	function user_list() {
		$sql = "select seq from user";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function board_list() {
		$sql = "select seq from weekly_report where concat(year, month, week) != '202232'";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function all_read_baord($data) {
		$this->db->insert('weekly_report_read', $data);
	}

	function cron_data_extract() {
		$sql = "SELECT * FROM electronic_approval_doc WHERE approval_form_seq = 16 AND approval_doc_status = '002' order by seq desc";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function cron_data_extract_schedule() {
		$sql = "SELECT * FROM tech_schedule_list WHERE work_type = 'tech' ORDER BY start_day, start_time";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

}
?>
