<?php
header("Content-type: text/html; charset=utf-8");

class STC_User extends CI_Model {

	function __construct() {

		parent::__construct();

	}

	// 공지사항 리스트
	function user_list($searchkeyword, $search1, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "001") {
				$searchstring = " AND user_name LIKE '{$keyword}' ";
			}else if($search1 == "002"){
				$searchstring = " AND user_id LIKE '{$keyword}' ";
			}else if($search1 == "003"){
				$searchstring = " AND user_email LIKE '{$keyword}' ";
			}

		} else {
			$searchstring = "";
		}

		if($this->admin == 'N') {
			$searchstring .= " AND seq = {$this->seq}";
		}

		$sql = "SELECT * from user where 1=1 {$searchstring} ORDER BY seq DESC";

		if  ( $offset <> 0 ) {
			$sql = $sql." LIMIT {$start_limit}, {$offset}";
		}
		$query = $this->db->query( $sql );
		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

	//공지사항 리스트개수
	function user_list_count($searchkeyword, $search1) {

		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "001") {
				$searchstring = " AND user_name LIKE '{$keyword}' ";
			}else if($search1 == "002"){
				$searchstring = " AND user_id LIKE '{$keyword}' ";
			}else if($search1 == "003"){
				$searchstring = " AND user_email LIKE '{$keyword}' ";
			}

		} else {
			$searchstring = "";

		}

		$sql = "SELECT count(seq) AS ucount FROM user WHERE 1=1".$searchstring." ORDER BY seq DESC";
		$query = $this->db->query( $sql );
		return $query->row();
	}

	//	공지사항 뷰내용 가져오기
	function user_view( $seq = 0 ) {
		$sql = "select * from user where seq = {$seq}";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	// 공지사항 추가및 수정
	function user_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('user', $data );
		} else{
			return $this->db->update('user', $data, array('seq' => $seq));
		}
	}

	// 공지사항 삭제
	function user_delete( $seq ) {
		$sql = "delete from user where seq = {$seq}";
		$query = $this->db->query( $sql );

		return	$query;
	}

}
?>
