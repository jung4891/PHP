<?php
header("Content-type: text/html; charset=utf-8");

class STC_User extends CI_Model {

	function __construct() {

		parent::__construct();
		$this->user_id = $this->phpsession->get( 'id', 'rms' );
	}


	//	아이디 중복체크
	function idcheck( $uid ) {
		$query = $this->db->query("select user_id from user where user_id = '".$uid."'");

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return true;
		}
	}

	//	회원 뷰내용 가져오기
	function user_view( $seq = 0 ) {
		$sql = "select * from user where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	// 회원리스트 사용자 추가및 수정
	function insert_user( $data, $mode = 0 , $seq = 0) {
//		$data['RegUserId'] = $this->phpsession->get( 'idx', 'wtf' );

		if( $mode == 0 ) {
			$this->db->insert('user', $data );
			return $this->db->insert('user', $data );
		}
		else {
			$this->db->update('user', $data, array('seq' => $seq));
			return $this->db->update('user', $data, array('seq' => $seq));
		}
	}

	function annual_check($seq){
		$sql="SELECT * FROM user_annual WHERE user_seq = {$seq}";
		$query = $this->db->query($sql);
		if ($query->num_rows() == 0) {
			$sql="INSERT INTO user_annual (user_seq, user_id, annual_period, annual_standard) SELECT seq, user_id, DATE_FORMAT(NOW(), '%Y'), 'calcDt' FROM user WHERE seq = {$seq}";
$query = $this->db->query($sql);
return $query;
		}

	}

	// 로그인 사용자 추가및 수정
	function insert_user2( $data, $mode = 0 , $id = 0) {
//		$data['RegUserId'] = $this->phpsession->get( 'idx', 'wtf' );

		if( $mode == 0 ) {
			return $this->db->insert('user', $data );
		}
		else {
			return $this->db->update('user', $data, array('user_id' => $id));
		}
	}

	// 사용자 삭제
	function user_delete( $seq ) {
		$sql = "delete from user where seq = ?";
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	// 회원 리스트
	function user_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0, $resignation, $user_type) {
		$keyword = "%".$searchkeyword."%";
		if($resignation == "y"){
			$quit_yn = " WHERE quit_date is not null";
		} else {
			$quit_yn = " WHERE quit_date is null";
		}
		if($user_type == 'd') {
			$cooperation_yn = " AND cooperation_yn = 'N'";
		} else {
			$cooperation_yn = " AND cooperation_yn = 'Y'";
		}

		if($searchkeyword != "") {
			if($search2 == "001") {
				$searchstring = " and user_group like '%{$searchkeyword}%' ";
			} else if($search2 == "002") {
				$searchstring = " and user_name like '%{$searchkeyword}%' ";
			} else if($search2 == "003") {
				$searchstring = " and user_id like '%{$searchkeyword}%' ";
			} else if($search2 == "004") {
				$searchstring = " and user_email like '%{$searchkeyword}%' ";
			}
		} else {
			$searchstring = "";
		}

		$sql = "select * from user".$quit_yn.$cooperation_yn.$searchstring." order by seq desc";
		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";

		$query = $this->db->query( $sql, array( $start_limit, $offset ) );

		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

	//회원 리스트개수
	function user_list_count($searchkeyword, $search1, $search2, $resignation, $user_type) {
		$keyword = "%".$searchkeyword."%";
		if($resignation == "y"){
			$quit_yn = " WHERE quit_date is not null";
		} else {
			$quit_yn = " WHERE quit_date is null";
		}
		if($user_type == 'd') {
			$cooperation_yn = " AND cooperation_yn = 'N'";
		} else {
			$cooperation_yn = " AND cooperation_yn = 'Y'";
		}

		if($searchkeyword != "") {
			if($search2 == "001") {
				$searchstring = " and user_group like '%{$searchkeyword}%' ";
			} else if($search2 == "002") {
				$searchstring = " and user_name like '%{$searchkeyword}%' ";
			} else if($search2 == "003") {
				$searchstring = " and user_id like '%{$searchkeyword}%' ";
			} else if($search2 == "004") {
				$searchstring = " and user_email like '%{$searchkeyword}%' ";
			}
		} else {
			$searchstring = "";
		}

		$sql = "select count(seq) as ucount from user".$quit_yn.$cooperation_yn.$searchstring." order by seq desc";

		$query = $this->db->query( $sql );

		return $query->row();
	}

	//조직도 그룹 별로 보기 & 부서변경 페이지에서 memeber 보기
	function groupView($group){
		if(strpos($group,",") === false){
			if($group == "all"){
				$sql = "select * from user order by seq asc";
			}else{
				$sql = "select * from user where user_group='".$group."' order by seq asc";
			}
		}else{
			$seq = explode(',',$group);
			$sql = "select * from user where seq ='{$seq[1]}' ";

			for($i=2; $i<count($seq); $i++){
				$sql .= "or seq = '{$seq[$i]}'" ;
			}

		}

		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//그룹 전체 가져오기
	function group(){
		$sql = "select * from user_group ";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}


	//상위그룹 가져오기
	function parentGroup(){
		$sql = "select * from user_group where groupName=parentGroupName order by seq asc";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//상위 그룹에 맞는 하위그룹 가져오기
	function childGroup($parentGroup){
		$sql = "select * from user_group where parentGroupName='{$parentGroup}' and groupName<>'{$parentGroup}'";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//부서 이동
	function changeGroup($seq,$group){
		$sql = "update user set user_group = '{$group}' where seq = {$seq}";
		$query = $this->db->query( $sql );

		return	$query;
	}

	//권한 수정
	function changeUserPart($seq,$userPart){
		$sql = "update user set user_part = '{$userPart}' where seq = {$seq}";
		$query = $this->db->query( $sql );

		return	$query;
	}

	//그룹별 권한 수정
	function groupChangeUserPart($groupName,$userPart,$userLevel){
		$sql = "update user set user_part = INSERT(user_part, {$userPart}, 1, '{$userLevel}') where user_group = '{$groupName}'";
		$query = $this->db->query( $sql );

		return	$query;
	}

	//부서 다 지우기
	function groupAllDelete(){
		$sql = "delete from user_group";
		$query = $this->db->query( $sql );

		return	$query;
	}

	//부서 관리
	function groupUpdate($groupName,$parentGroupName,$childGroupNum,$depth){
		$sql = "insert into user_group (groupName,parentGroupName,childGroupNum,depth) values('{$groupName}','{$parentGroupName}',{$childGroupNum},{$depth})";
		$query = $this->db->query( $sql );

		return	$query;
	}

	//durian 페이지들
	function page(){
		$sql = "select * from management_page";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//페이지 추가
	function insertPage($pageName,$pageAddress){
		$sql = "insert into management_page (page_name,page_address) values('{$pageName}','{$pageAddress}')";
		$query = $this->db->query( $sql );
		return	$query;
	}

	//페이지 insert 할때 user_part 수정
	function insertPageChangeUserPart(){
		$sql = "update user set user_part = CONCAT(user_part,'0')";
		$query = $this->db->query( $sql );
		return	$query;
	}

	//페이지 삭제
	function deletePage($seq){
		$sql = "delete from management_page where seq={$seq}";
		// update user set user_part = INSERT(user_part,(SELECT row_num FROM (SELECT @ROWNUM:=@ROWNUM+1 AS row_num, A.* FROM management_page A, (SELECT @ROWNUM:=0) R) row WHERE page_name = "관리자"), 1, '') ;

		$query = $this->db->query( $sql );
		return	$query;
	}
	//페이지 삭제할 때 user_part 수정해주는거
	function deletePageChangeUserPart($seq){
		$sql = "update user set user_part = INSERT(user_part,(SELECT row_num FROM (SELECT @ROWNUM:=@ROWNUM+1 AS row_num, A.* FROM management_page A, (SELECT @ROWNUM:=0) R) row WHERE seq = '{$seq}'), 1, '')";
		$query = $this->db->query( $sql );
		return	$query;
	}

	//페이지 수정
	function updatePage($seq,$pageName,$pageAddress){
		$sql = "update management_page set page_name='{$pageName}',page_address='{$pageAddress}' where seq={$seq}";
		$query = $this->db->query( $sql );
		return	$query;
	}

	//페이지별 권한 수정
	function page_rights_update($seq,$authority,$group_authority){
		$sql = "update management_page set default_authority='{$authority}',group_authority='{$group_authority}' where seq={$seq}";
		$query = $this->db->query($sql);
		return	$query;
	}

	//협력사 멤버인지
	function cooperative_company_member($email){
		$sql = "SELECT * FROM sales_customer_staff cs JOIN sales_customer_basic cb ON cs.customer_seq = cb.seq WHERE cb.company_part ='004' and cs.user_email = '{$email}' and cs.manager='Y'";
		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	// 퇴사 처리
	function resignation($seq, $date){
		$sql = "UPDATE user SET user_part = '0000', confirm_flag = 'N', quit_date = '{$date}' WHERE seq = {$seq}";
		$query = $this->db->query($sql);
		return $query;
	}

	function management_user_list($checked_group) {
		if(in_array(1, $checked_group)) {
			$sql =  "SELECT * FROM user WHERE quit_date is null and cooperation_yn = 'N' order by seq";
		} else {
			$group = implode("','", $checked_group);
			$sql =  "SELECT * FROM user WHERE user_group in (SELECT groupName FROM user_group WHERE seq IN ('{$group}'))
			and quit_date is null order by seq";
		}
		// echo $sql;
		$query = $this->db->query($sql);

		return $query->result_array();
	}
}
?>
