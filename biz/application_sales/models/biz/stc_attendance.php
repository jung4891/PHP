<?php
header("Content-type: text/html; charset=utf-8");

class STC_Attendance extends CI_Model {

	function __construct() {

		parent::__construct();
    $this->id = $this->phpsession->get( 'id', 'stc' );
    $this->name = $this->phpsession->get( 'name', 'stc' );
    $this->lv = $this->phpsession->get( 'lv', 'stc' );
    $this->cnum = $this->phpsession->get( 'cnum', 'stc' );
    $this->seq = $this->phpsession->get( 'seq', 'stc' );
	}

	//사용자 가져오기
	function attendance_user(){
		// $sql = "SELECT u.user_name, u.user_duty,au.user_seq, am.card_num,am.date AS workdate,am.ws_time as wstime,am.wc_time as wctime,am.ws_ip_address,am.wc_ip_address,am.update_time,au.ws_time ,au.wc_time
		// FROM attendance_manual as am LEFT JOIN attendance_user AS au ON am.card_num = au.card_num LEFT JOIN user AS u ON au.user_seq = u.seq
		// WHERE u.user_id ='{$this->id}'  AND left(am.date,6) = '{$date}'";

		// $sql = "SELECT u.user_name, u.user_duty,au.user_seq,am.seq ,am.card_num,am.date AS workdate,am.ws_time as wstime,am.wc_time as wctime,am.ws_ip_address,am.wc_ip_address,am.update_time,am.official_ws_time as ws_time ,am.official_wc_time as wc_time,am.status
		// FROM attendance_manual as am LEFT JOIN attendance_user AS au ON am.card_num = au.card_num LEFT JOIN user AS u ON au.user_seq = u.seq
		// WHERE u.user_id ='{$this->id}'";

		$sql = "SELECT * FROM adt_attendance WHERE u_seq = {$this->seq}";


		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//사용자 가져오기
	function attendance_user_mobile($t_month){
		$sql = "SELECT DATE_ADD(date_format(e_date, '%Y-%m-%d'), INTERVAL -1 DAY) AS e_date, go_time, leave_time, ws_time, wc_time FROM adt_attendance WHERE u_seq = {$this->seq} and e_date like '{$t_month}%'";

		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

  function attendance_info() {
    $sql = "SELECT u.user_name, au.card_num, au.ws_time as designate_ws, au.wc_time as designate_wc from attendance_user au JOIN user u ON au.user_seq = u.seq where user_seq='{$this->seq}'";
    $query = $this->db->query($sql);
    if ($query->num_rows() <= 0) {
      return false;
    } else {
      return $query->row_array() ;
    }
  }

	function attendance_data($date,$card_num){
		$sql = "SELECT * from attendance_manual where card_num='{$card_num}' and date = {$date}";
		$query = $this->db->query($sql);
		// echo $sql."<br>";
		if($query->num_rows()<=0){
			return false;
		} else {
			return $query->row_array();
		}
	}

	function user_group() {
		$sql = "SELECT user_group from user where seq='{$this->seq}'";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
		return false;
		} else {
		return $query->row_array() ;
		}
	}

	//휴가사용현황
	function annual_usage_status(){
		$sql =" SELECT eaa.*,u.user_name FROM electronic_approval_annual as eaa
		left join user AS u
		on eaa.user_id = u.user_id WHERE annual_status = 'Y' and eaa.user_id='{$this->id}'";

	  $query = $this->db->query($sql);

	  if ($query->num_rows() <= 0) {
		  return false;
	  } else {
		  return $query->result_array();
	  }
	}

	// 연차관리
	function annual_management() {
		$sql = "SELECT ua.*, u.user_name,u.user_group,u.join_company_date,
			(SELECT COUNT(*) FROM electronic_approval_annual WHERE user_id = u.user_id AND (annual_status IS NULL || annual_status = '') ) as approval_cnt
			FROM user_annual AS ua LEFT JOIN user as u ON ua.user_seq = u.seq where u.user_id='{$this->id}' order by u.join_company_date,u.seq";

		$query = $this->db->query( $sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//휴가사용내역
	function annual_usage_status_list($searchkeyword){
		$searchstring = "";
		if ($searchkeyword != "") {
			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //사용기간 시작
				$searchstring .= " and eaa.annual_start_date >= '{$searchkeyword[0]}'";
			}
			if(trim($searchkeyword[1])!=''){ //사용기간 끝
				$searchstring .= " and eaa.annual_end_date <= '{$searchkeyword[1]}'";
			}
			if(trim($searchkeyword[2])!=''){ //전자결재상태
				$searchstring .= " and ead.approval_doc_status = '{$searchkeyword[2]}'";
			}
			// if(trim($searchkeyword[4])!=''){ //검색어
			// 	$searchstring .= " and {$searchkeyword[3]} like '%{$searchkeyword[4]}%'";
			// }
			if(trim($searchkeyword[3])!=''){//휴가항목
				$searchstring .= " and eaa.annual_type = '{$searchkeyword[3]}'";
			}
		}else{
			$searchstring = " and eaa.annual_start_date between DATE_FORMAT(CURDATE(), '%Y-%m-01') and curdate()";
		}
		$sql ="SELECT eaa.*,u.user_name,u.user_group,user_duty,ead.approval_doc_status FROM electronic_approval_annual as eaa left join user AS u
		on eaa.user_id = u.user_id
		left join electronic_approval_doc as ead
		on eaa.approval_doc_seq = ead.seq
		WHERE u.user_id = '{$this->id}' {$searchstring}  order by annual_start_date";

		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

function get_pgroup(){
	$sql="SELECT IF(groupName = '기술연구소', groupName, parentGroupName) pgroup FROM user_group GROUP BY pgroup";
	$query = $this->db->query($sql);
	if ($query->num_rows() <= 0) {
		return false;
	} else {
		return $query->result_array();
	}

}

function working_hours_biz($sdate, $edate){

	$sdate = str_replace('-','',$sdate);
	$edate = str_replace('-','',$edate);

	$sql = "SELECT u_seq, card_num, user_name, user_duty, pgroup,
SEC_TO_TIME(TRUNCATE(SUM(TIME_TO_SEC(w_time)), 0)) AS t_time,
SEC_TO_TIME(TRUNCATE(SUM(TIME_TO_SEC(work_time)), 0)) AS w_time,
SEC_TO_TIME(TRUNCATE(SUM(TIME_TO_SEC(over_time)), 0)) AS over_time,
SEC_TO_TIME(TRUNCATE(TIME_TO_SEC('40:00:00') - SUM(TIME_TO_SEC(work_time)),0)) AS rest_wtime,
SEC_TO_TIME(TRUNCATE(TIME_TO_SEC('12:00:00') - SUM(TIME_TO_SEC(over_time)),0)) AS rest_overtime
FROM(SELECT a.*,
IF(a.w_time > '08:00', '08:00', a.w_time) AS work_time,
IF(a.w_time > '08:00', TIMEDIFF(a.w_time, '08:00'), '00:00') AS over_time,
u.user_name, u.user_duty, u.user_group, u.pgroup
FROM (SELECT u_seq, card_num, ws_time, wc_time, e_date, dayoftheweek, annual_type, go_time, leave_time,
work_time as w_time
FROM adt_attendance
WHERE e_date >= '{$sdate}' AND e_date <= '{$edate}') AS a
LEFT JOIN
(SELECT u.seq, user_name, user_duty, user_group, IF(user_group = '기술연구소', user_group, parentGroupName) AS pgroup FROM user AS u
JOIN user_group AS g
ON u.user_group = g.groupName) AS u
ON a.u_seq = u.seq
WHERE u.seq = {$this->seq}) AS d
GROUP BY card_num ORDER BY pgroup, u_seq";

	$query = $this->db->query($sql);
	if ($query->num_rows() <= 0) {
		return false;
	} else {
		return $query->result_array();
	}


}

function working_hours_tech($sdate,$edate){
	$sdate = str_replace('-','',$sdate);
	$edate = str_replace('-','',$edate);
	$sql="SELECT u_seq, card_num, user_name, user_duty, user_group, pgroup,
SEC_TO_TIME(TRUNCATE(totaltime, 0)) AS t_time,
SEC_TO_TIME(TRUNCATE(w_time,0)) AS w_time,
SEC_TO_TIME(TRUNCATE(over_time,0)) AS over_time,
SEC_TO_TIME(TRUNCATE(TIME_TO_SEC('40:00:00') - w_time, 0)) AS rest_wtime,
SEC_TO_TIME(TRUNCATE(TIME_TO_SEC('12:00:00') - over_time, 0)) AS rest_overtie
FROM (SELECT d.u_seq, d.card_num, d.user_name, d.user_duty, d.user_group, d.pgroup,
SUM(TIME_TO_SEC(w_time) + IFNULL(t.total_time, 0)) AS totaltime ,
SUM(IF(TIME_TO_SEC(w_time) + IFNULL(t.total_time, 0) > TIME_TO_SEC('08:00:00'), TIME_TO_SEC('08:00:00'), TIME_TO_SEC(w_time) + IFNULL(t.total_time, 0))) AS w_time,
SUM(IF(TIME_TO_SEC(w_time) + IFNULL(t.total_time, 0) > TIME_TO_SEC('08:00:00'), (TIME_TO_SEC(w_time) + IFNULL(t.total_time, 0)) - TIME_TO_SEC('08:00:00'), 0)) AS over_time
FROM (SELECT a.*,
u.user_name, u.user_duty, u.user_group, u.pgroup
FROM (SELECT u_seq, card_num, ws_time, wc_time, e_date, dayoftheweek, annual_type, go_time, leave_time,
work_time as w_time
FROM adt_attendance
WHERE e_date >= '{$sdate}' AND e_date <= '{$edate}') AS a
LEFT JOIN
(SELECT u.seq, user_name, user_duty, user_group, IF(user_group = '기술연구소', user_group, parentGroupName) AS pgroup FROM user AS u
JOIN user_group AS g
ON u.user_group = g.groupName) AS u
ON a.u_seq = u.seq WHERE u.seq = '{$this->seq}') AS d
LEFT JOIN
(SELECT
SUBSTRING_INDEX (SUBSTRING_INDEX(tech.engineer_seq,',',numbers.n),',',-1) as div_engineer_seq,
tech.doc_seq, tech.workdate,
SUM(TIME_TO_SEC(tech.total_time)) AS total_time, tech.start_time, tech.end_time, tech.handle
from
 (select  1 n union  all  select 2
	union  all  select  3  union  all select 4
	union  all  select  5  union  all  select  6) numbers
JOIN (SELECT seq AS doc_seq, DATE_FORMAT(income_time, '%Y%m%d') AS workdate, engineer_seq,
total_time, start_time, end_time, handle
FROM tech_doc_basic
WHERE DATE_FORMAT(income_time, '%Y%m%d') >= '{$sdate}'
AND DATE_FORMAT(income_time, '%Y%m%d') <= '{$edate}'
AND handle = '현장지원') AS tech
ON CHAR_LENGTH ( tech.engineer_seq ) - CHAR_LENGTH ( REPLACE ( tech.engineer_seq ,  ',' ,  '' )) >= numbers . n-1
WHERE SUBSTRING_INDEX (SUBSTRING_INDEX(tech.engineer_seq,',',numbers.n),',',-1) != ''
GROUP BY workdate, div_engineer_seq) AS t
ON d.u_seq=t.div_engineer_seq AND d.e_date = t.workdate
GROUP BY card_num) AS su";


$query = $this->db->query($sql);
// var_dump($query->result_array());
if ($query->num_rows() <= 0) {
	return false;
} else {
	return $query->result_array();
}

}

function annual_usage_status_day($date) {
	$sql =" SELECT eaa.*,u.user_name FROM electronic_approval_annual as eaa
	left join user AS u
	on eaa.user_id = u.user_id WHERE annual_status = 'Y' and eaa.user_id='{$this->id}' AND '{$date}' BETWEEN annual_start_date AND annual_end_date";

	$query = $this->db->query($sql);

	if ($query->num_rows() <= 0) {
		return false;
	} else {
		return $query->result_array();
	}
}


}
?>
