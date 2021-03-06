<?php
header("Content-type: text/html; charset=utf-8");

class STC_User extends CI_Model {

	function __construct() {

		parent::__construct();
		$this->user_id = $this->phpsession->get( 'id', 'rms' );
	}
	

	
	// 사용자 삭제
	function delete_user( $user_id ) {
		$sql = "delete from user where user_id = ?";		
		$query = $this->db->query( $sql, $user_id );

		return	$query;
	}

	
	// 회원 리스트
	function user_list( $searchkeyword, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";
		if  ( $searchkeyword != "" )
			$searchstring = " where ( restarea_name like ? )";
		else
			$searchstring = "";

		$sql = "select user_seq, user_id, user_name, user_passwd, user_tel, restarea_name, user_email from user".$searchstring." order by user_seq desc";
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

	//서명 확인 업데이트
	function signConsentUpdate($seq){
		$sql = "UPDATE tech_doc_basic SET sign_consent ='true' WHERE seq=?";
		$query = $this->db->query( $sql, $seq );
		return $query;
	}

	//서명 취소 업데이트	
	function signConsentCancle($seq){
		$sql = "UPDATE tech_doc_basic SET sign_consent ='0' WHERE seq=?";
		$query = $this->db->query( $sql, $seq );
		return $query;
	}

	//고객사 서명 확인 업데이트
	function customerSignConsentUpdate($seq){
		$sql = "UPDATE tech_doc_basic SET customer_sign_consent ='true' WHERE seq=?";
		$query = $this->db->query( $sql, $seq );
		return $query;
	}
	
	//고객사 서명 취소 업데이트	
	function customerSignConsentCancle($seq){
		$sql = "UPDATE tech_doc_basic SET customer_sign_consent ='0' WHERE seq=?";
		$query = $this->db->query( $sql, $seq );
		return $query;
	}

	//고객사 서명 이미지 src 업데이트
	function customerSignSrc($seq,$src,$signer){
		$sql = "UPDATE tech_doc_basic SET customer_sign_src = ?,signer = ? WHERE seq=?";
		$query = $this->db->query( $sql,array($src,$signer,$seq));
		return $query;
	}
	
	//같은 그룹멤버
	function same_group_member($group){
		// $sql = "SELECT u.*,ug.parentGroupName FROM user u JOIN user_group ug ON u.user_group = ug.groupName WHERE parentGroupName = '{$parentGroup}';";
		$sql = "SELECT u.*,ug.parentGroupName FROM user u JOIN user_group ug ON u.user_group = ug.groupName WHERE u.user_group = '{$group}'";
		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//협력사 멤버인지
	function cooperative_company_member($email){
		$sql = "SELECT * FROM sales_customer_staff cs JOIN sales_customer_basic cb ON cs.customer_seq = cb.seq WHERE cb.company_part ='004' and cs.user_email = '{$email}' ";
		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//정기점검 여부 가져오자
	function periodic_inspection($group){
		// $sql = "SELECT * from sales_forcasting WHERE (maintain_result=0 || maintain_result=9 || maintain_result=3) and progress_step > '014' and maintain_cycle != 7 and maintain_cycle != 9 and maintain_cycle != 0 AND NOW() < exception_saledate3 AND (sub_project_add IS NULL or sub_project_add NOT LIKE CONCAT('%', seq, '%')) ORDER BY maintain_date";
		$sql = "SELECT * from sales_maintain
		WHERE (maintain_result=0 || maintain_result=9 || maintain_result=3) 
		and maintain_cycle != 7 and maintain_cycle != 9 and maintain_cycle != 0 
		AND CURDATE() between exception_saledate2 AND exception_saledate3 ORDER BY maintain_date";
		
		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}
}
?>
