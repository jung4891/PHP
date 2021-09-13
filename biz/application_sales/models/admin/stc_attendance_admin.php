<?php
header("Content-type: text/html; charset=utf-8");

class STC_Attendance_admin extends CI_Model {

	function __construct() {

		parent::__construct();
//		$this->user_id = $this->phpsession->get( 'id', 'stc' );
	}


  function attendance_user_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
    $sql = "SELECT u.seq, u.user_name, u.user_duty, a.card_num, a.ws_time, a.wc_time FROM user u left JOIN attendance_user a ON u.seq = a.user_seq WHERE u.quit_date is null order by a.card_num, u.seq";
    if  ( $offset <> 0 )
    $sql = $sql." limit ?, ?";

    if  ( $searchkeyword != "" )
    $query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
    else
    $query = $this->db->query( $sql, array( $start_limit, $offset ) );

    return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
  }


  function attendance_user_list_count($searchkeyword, $search1, $search2) {
    $sql = "SELECT count(u.seq) as ucount FROM user u left JOIN attendance_user a ON u.seq = a.user_seq WHERE u.quit_date is null";

    if  ( $searchkeyword != "" )
    $query = $this->db->query( $sql, $keyword  );
    else
    $query = $this->db->query( $sql );

		// echo $sql;
    return $query->row();
  }


  function attendance_list( $searchkeyword, $start_limit = 0, $offset = 0) {
		if ($searchkeyword != ""){
			$searchstring='';
			$searchstring2='';

			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!='' && $searchkeyword[1]!=''){ // day or period
				$start_day = date("Ymd", strtotime($searchkeyword[1]));
				$end_day = date("Ymd", strtotime($searchkeyword[2]));
				if ($searchkeyword[0]=='day'){
					$searchstring = " AND e_date=".$start_day;
				} else if ($searchkeyword[0]=='period'){
					$searchstring = " AND (e_date>={$start_day} AND e_date<={$end_day})";
				}
			}
			if(trim($searchkeyword[3])!=''){ // user_name
				$searchstring2 = " AND user_name like '%{$searchkeyword[4]}%'";
			}
			$searchstring = $searchstring.$searchstring2;
			$searchstring = " where ".ltrim($searchstring," AND");

		} else {
			$searchstring = "";
		}

// 구버전 secom 데이타 조회
 	// $sql = "SELECT u.user_name, u.user_duty,au.user_seq, am.seq, am.card_num,am.date AS workdate,am.ws_time as wstime,am.wc_time as wctime,am.ws_ip_address,am.wc_ip_address,am.update_time,am.status, am.date_type FROM attendance_manual as am
	// LEFT JOIN attendance_user AS au
	// ON am.card_num = au.card_num
	// JOIN user AS u
	// ON au.user_seq = u.seq and u.quit_date is null  {$searchstring} order by am.date desc, cast(user_seq AS UNSIGNED)";

	// echo $sql;

// caps 데이타 조회
	$sql = "SELECT a.seq, u_seq, u.user_group, u.user_name, u.user_duty, dayoftheweek, date_name, annual_type, e_date, go_time, leave_time, work_time
FROM adt_attendance AS a
LEFT JOIN user AS u
ON a.u_seq = u.seq
{$searchstring} ORDER BY e_date DESC, CAST(u_seq AS UNSIGNED)";


	if  ( $offset <> 0 ){
		$sql = $sql." limit ?, ?";
	}

    $query = $this->db->query( $sql, array( $start_limit, $offset ) );
		// echo $sql;

    return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
  }


  function attendance_list_count($searchkeyword) {
	if ($searchkeyword != ""){
		$searchstring='';
		$searchstring2='';

		$searchkeyword = explode(',',$searchkeyword);
		if(trim($searchkeyword[0])!='' && $searchkeyword[1]!=''){ // day or period
			$start_day = date("Ymd", strtotime($searchkeyword[1]));
			$end_day = date("Ymd", strtotime($searchkeyword[2]));
			if ($searchkeyword[0]=='day'){
				$searchstring = " AND e_date=".$start_day;
			} else if ($searchkeyword[0]=='period'){
				$searchstring = " AND (e_date>={$start_day} AND e_date<={$end_day})";
			}
		}
		if(trim($searchkeyword[3])!=''){ // user_name
			$searchstring2 = " AND user_name like '%{$searchkeyword[4]}%'";
		}
		$searchstring = $searchstring.$searchstring2;
		$searchstring = " where ".ltrim($searchstring," AND");

	} else {
		$searchstring = "";
	}

	// $sql = "SELECT count(*) as ucount
	// FROM attendance_manual as am
	// LEFT JOIN attendance_user AS au
	// ON am.card_num = au.card_num
	// JOIN user AS u
	// ON au.user_seq = u.seq and u.quit_date is null {$searchstring} order by am.date desc, cast(user_seq AS UNSIGNED)";
	$sql = "SELECT count(*) as ucount
FROM adt_attendance AS a
LEFT JOIN user AS u
ON a.u_seq = u.seq
{$searchstring} ORDER BY e_date DESC, CAST(u_seq AS UNSIGNED)";

		$query = $this->db->query( $sql );
    return $query->row();
  }

	function user_count(){
		$sql = "SELECT count(*) as ucount from attendance_user where card_num is not null";
		$query = $this->db->query($sql);
		return $query->row();
	}


  function attendance_user_info($seq){
    $sql = "SELECT u.seq, u.user_name, u.user_duty, a.card_num, a.ws_time, a.wc_time FROM user u left JOIN attendance_user a ON u.seq = a.user_seq WHERE u.seq = {$seq}";
    $query = $this->db->query($sql);
	  return $query->result_array();
  }

  function attendance_card_info($name){
    $sql = "SELECT DISTINCT(e_id) FROM adt_access_log WHERE e_name LIKE '%{$name}%'";
    $query = $this->db->query($sql);
	  return $query->result_array();
  }

  function attendance_user_count($user_seq){
    $sql = "SELECT count(seq) as ucount from attendance_user where user_seq={$user_seq}";
    $query = $this->db->query( $sql );
    return $query->row();
  }

  function attendance_user_insert( $data, $mode = 0 , $user_seq = 0) {
    if( $mode == 0 ) {
      return $this->db->insert('attendance_user', $data );
    }
    else {
      return $this->db->update('attendance_user', $data, array('user_seq' => $user_seq));
    }
  }

  function attendance_individual($type,$data){
	if($type == 0){
		$sql = "SELECT u.user_name, u.user_duty,au.user_seq, am.seq, am.card_num,am.date AS workdate,am.ws_time as wstime,am.wc_time as wctime,am.ws_ip_address,am.wc_ip_address,am.update_time,am.status FROM attendance_manual as am
		LEFT JOIN attendance_user AS au
		ON am.card_num = au.card_num
		LEFT JOIN user AS u
		ON au.user_seq = u.seq where am.seq = {$data}";
		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}else if ($type == 1){ //seq 로 update
		return $this->db->update('attendance_manual', $data, array('seq' => $data['seq']));
	}else if ($type ==2){ //오늘꺼 출퇴근 기록 찾아서 업데이트!
		$today = date("Ymd");
		return $this->db->update('attendance_manual', $data, array('card_num' => $data['card_num'],'date' => $today));
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


	function working_hours_biz($sdate, $edate, $search_group = ""){
		if($search_group != ""){
			$group_keyword = " AND u.pgroup = '{$search_group}'";

		}else{
			$group_keyword = "";
		}
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
FROM (SELECT u_seq, card_num, ws_time, wc_time, e_date, dayoftheweek, annual_type, go_time, leave_time, work_time as w_time
FROM adt_attendance
WHERE e_date >= '{$sdate}' AND e_date <= '{$edate}') AS a
LEFT JOIN
(SELECT u.seq, user_name, user_duty, user_group, IF(user_group = '기술연구소', user_group, parentGroupName) AS pgroup FROM user AS u
JOIN user_group AS g
ON u.user_group = g.groupName) AS u
ON a.u_seq = u.seq
WHERE u.pgroup != '기술본부' {$group_keyword}) AS d
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
ON a.u_seq = u.seq WHERE u.pgroup = '기술본부') AS d
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
GROUP BY card_num) AS su
ORDER BY FIELD(user_name, '김갑진') DESC, user_group, u_seq ASC
";


	$query = $this->db->query($sql);
	// var_dump($query->result_array());
	if ($query->num_rows() <= 0) {
		return false;
	} else {
		return $query->result_array();
	}

	}


}
?>