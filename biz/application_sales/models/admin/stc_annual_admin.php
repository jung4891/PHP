<?php
header("Content-type: text/html; charset=utf-8");

class STC_Annual_admin extends CI_Model {

	function __construct() {

		parent::__construct();
		// $this->user_id = $this->phpsession->get( 'id', 'stc' );
	}

  // 연차관리
  function annual_management($seq=0,$searchkeyword="") {
	if ($searchkeyword != "") {
		$searchstring='';
		$searchkeyword = explode(',',$searchkeyword);
		if(trim($searchkeyword[0])!=''){ //기준연도
			$searchstring .= "and annual_period = '{$searchkeyword[0]}' ";
		}
		if(trim($searchkeyword[1])!=''){ //휴가관리기준
			$searchstring .= "and annual_standard = '{$searchkeyword[1]}' ";
		}
		if(trim($searchkeyword[2])!=''){ //검색어 타입
			$searchstring .= "and {$searchkeyword[2]} like '%{$searchkeyword[3]}%' ";
		}

		if(trim($searchkeyword[4])!=''){ //연차생성여부
			if($searchkeyword[4] == "true"){//생성
				$searchstring .= "and ifnull(month_annual_cnt,0)+ifnull(annual_cnt,0)+ifnull(adjust_annual_cnt,0) != 0 ";
			}else{
				$searchstring .= "and ifnull(month_annual_cnt,0)+ifnull(annual_cnt,0)+ifnull(adjust_annual_cnt,0) = 0 ";
			}
		}

		$searchstring = ltrim($searchstring,'and');
		$searchstring = "where ".$searchstring;

	} else {
		$searchstring = "";
	}
	if($seq == 0){
		$sql = "SELECT ua.*, u.user_name,u.user_group,u.join_company_date,
		(SELECT COUNT(*) FROM electronic_approval_annual WHERE user_id = u.user_id  AND (annual_status IS NULL || annual_status = '') ) as approval_cnt  
		FROM user_annual AS ua LEFT JOIN user as u ON ua.user_seq = u.seq {$searchstring} order by u.join_company_date,u.seq";
	
		$query = $this->db->query( $sql);
	
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}else{
		$sql = "SELECT ua.*, u.user_name,u.user_group,u.join_company_date,
		(SELECT COUNT(*) FROM electronic_approval_annual WHERE user_id = u.user_id AND (annual_status IS NULL || annual_status = '') ) as approval_cnt  
		FROM user_annual AS ua LEFT JOIN user as u ON ua.user_seq = u.seq 
		where ua.seq = {$seq} order by u.join_company_date,u.seq";
	
		$query = $this->db->query( $sql);
	
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}
  }

  //휴가사용현황
  function annual_usage_status(){
	$sql =" SELECT eaa.*,u.user_name FROM electronic_approval_annual as eaa
	left join user AS u 
	on eaa.user_id = u.user_id WHERE annual_status = 'Y' ";

	$query = $this->db->query($sql);

	if ($query->num_rows() <= 0) {
		return false;
	} else {
		return $query->result_array();
	} 
  }

	//휴가사용현황
	function annual_usage_status_list($searchkeyword){
		$searchstring = '';
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
			if(trim($searchkeyword[4])!=''){ //검색어
				$searchstring .= " and {$searchkeyword[3]} like '%{$searchkeyword[4]}%'";
			}
			if(trim($searchkeyword[5])!=''){//휴가항목
				$searchstring .= " and eaa.annual_type = '{$searchkeyword[5]}'";
			}
		}else{
			$searchstring = " and eaa.annual_start_date between DATE_FORMAT(CURDATE(), '%Y-%m-01') and curdate()";
		}
		$searchstring = ltrim($searchstring," and");
		$sql = "SELECT eaa.*,u.user_name,u.user_group,user_duty,ead.approval_doc_status FROM electronic_approval_annual as eaa left join user AS u
		on eaa.user_id = u.user_id
		left join electronic_approval_doc as ead 
		on eaa.approval_doc_seq = ead.seq 
		WHERE {$searchstring} order by annual_start_date";

		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		} 
	}

	//연차관리 수정
	function user_annual_update($type,$data){
		$result = $this->db->update('user_annual', $data, array('seq' => $data['seq']));
		if($type == 1){//생성일때
			$sql = "update user_annual set remainder_annual_cnt=(ifnull(month_annual_cnt,0)+ifnull(annual_cnt,0)+ifnull(adjust_annual_cnt,0)-ifnull(use_annual_cnt,0)) where seq = {$data['seq']}";
			$result = $this->db->query($sql);
		}else if($type == 2){ //삭제일때 
			$sql1 = "delete from adjust_annual where annual_seq = {$data['seq']}"; //조정연차도 같이 다 없애
			$sql2 = "update user_annual set adjust_annual_cnt = null,remainder_annual_cnt=(ifnull(month_annual_cnt,0)+ifnull(annual_cnt,0)-ifnull(use_annual_cnt,0)) where seq = {$data['seq']}";
			$result = $this->db->query($sql1);
			$result = $this->db->query($sql2);
		}
		return $result; 
	}

	//조정연차관리
	function adjust_annual_save($type,$data){
		if($type == 0){
			$sql= "select * from adjust_annual where annual_seq = {$data}";
			$query = $this->db->query($sql);
			if ($query->num_rows() <= 0) {
				return false;
			} else {
				return $query->result_array();
			} 
		}else if($type == 1){//생성일때
			$result = $this->db->insert('adjust_annual', $data);
			$sql1 = "update user_annual set adjust_annual_cnt=(SELECT SUM(adjust_annual_cnt) FROM adjust_annual WHERE annual_seq ={$data['annual_seq']}) where seq ={$data['annual_seq']}";
			$sql2 = "update user_annual set remainder_annual_cnt=(ifnull(month_annual_cnt,0)+ifnull(annual_cnt,0)+ifnull(adjust_annual_cnt,0)-ifnull(use_annual_cnt,0)) where seq = {$data['annual_seq']}";
			$this->db->query($sql1);
			$this->db->query($sql2);
			return $result; 
		}else if($type == 2){//삭제일때
			$sql = "delete from adjust_annual where seq = {$data['seq']}";
			$result = $this->db->query($sql);
			$sql1 = "update user_annual set adjust_annual_cnt=(SELECT SUM(adjust_annual_cnt) FROM adjust_annual WHERE annual_seq ={$data['annual_seq']}) where seq ={$data['annual_seq']}";
			$sql2 = "update user_annual set remainder_annual_cnt=(ifnull(month_annual_cnt,0)+ifnull(annual_cnt,0)+ifnull(adjust_annual_cnt,0)-ifnull(use_annual_cnt,0)) where seq = {$data['annual_seq']}";
			$this->db->query($sql1);
			$this->db->query($sql2);
			return $result;
		}
	}

	//1월 1일 user_annual_생성하는 크론탭
	function make_user_annual(){
		$sql = "INSERT INTO user_annual (user_seq,user_id,annual_period,annual_standard,insert_date)
		SELECT seq,user_id,DATE_FORMAT(now(),'%Y'),'calcDt',NOW() FROM user";
		return $this->db->query($sql);
	}
}
?>
