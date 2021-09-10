<?php
header("Content-type: text/html; charset=utf-8");

class STC_User extends CI_Model {

	function __construct() {

		parent::__construct();
		$this->user_id = $this->phpsession->get( 'id', 'src' );
	}


	// //	로그인후 해당 아이디로 내용 가져오기
	// function selected_user( $uid ) {
	// 	$query = $this->db->query("select * from user where user_id = '".$uid."'");
		
	// 	if ($query->num_rows() <= 0) {
	// 		return false;
	// 	} else {
	// 		return $query->row_array() ;
	// 	}
	// }
	


	
// 	// 사용자 삭제
// 	function delete_user( $user_id ) {
// 		$sql = "delete from user where user_id = ?";		
// 		$query = $this->db->query( $sql, $user_id );

// 		return	$query;
// 	}

// 	// 가입하고자 하는 ID가 존재하는지 검사
// 	function check_user_id_exist( $user_id ) {
// 		$sql = "select user_id from user where user_id = ?";
// 		$query = $this->db->query( $sql, $user_id );

// 		if  ( $query->num_rows() == 0 ){		//	해당 ID가 존재하지 않음
// 			return	0;
// 		}

// 		return	1;
// 	}
	
	// 회원 리스트
	function user_list( $searchkeyword, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";
		if  ( $searchkeyword != "" )
			$searchstring = " where ( restarea_name like ? )";
		else
			$searchstring = "";

		$sql = "select user_seq, user_id, user_name, user_passwd, user_tel, user_level, restarea_name, user_email from user".$searchstring." order by user_seq desc";
		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );	
		else 
			$query = $this->db->query( $sql, array( $start_limit, $offset ) );
		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}
	
	 // 전체 게시물에서 몇번째부터 몇개(페이지당 표시 개수)가져오기
    function GetLimit($tlimit,$toffset) {
        $query = $this->db->get('user',$tlimit,$toffset);
        if ( $query->num_rows() > 0 )
            return $query->result();
        else
            return FALSE;
    }


	//회원 리스트개수
	function user_list_count($searchkeyword) {
		$keyword = "%".$searchkeyword."%";
		if  ( $searchkeyword != "" )
			$searchstring = " where ( restarea_name like ? )";
		else
			$searchstring = "";

		$sql = "select count(user_seq) as ucount from user".$searchstring." order by user_seq desc";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );	
		else 
			$query = $this->db->query( $sql );
		return $query->row();
	}
		
	//같은 그룹멤버
	function same_group_member($parentGroup){
		$sql = "SELECT u.*,ug.parentGroupName FROM user u JOIN user_group ug ON u.user_group = ug.groupName WHERE parentGroupName = '{$parentGroup}';";
		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//거래처 가져오기
    function sales_customer() {
		$sql = "select * from sales_customer_basic";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	//거래처 담당자들 select
	function sales_customer_staff($seq) {
		$sql = "select * from sales_customer_staff where customer_seq = {$seq}";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
?>