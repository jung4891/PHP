<?php
header("Content-type: text/html; charset=utf-8");

class STC_Board extends CI_Model {

	function __construct() {

		parent::__construct();

	}

	// 공지사항 리스트
	function notice_list($searchkeyword, $search1, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "001") {
				$searchstring = " AND subject LIKE '{$keyword}' ";
			}else if($search1 == "002"){
				$searchstring = " AND user_name LIKE '{$keyword}' ";
			}

		} else {
			$searchstring = "";

		}

		// $sql = "SELECT seq, category_code, subject, user_id, user_name, file_changename, update_date FROM biz_notice_basic WHERE{$category_query}".$searchstring." ORDER BY seq DESC";

	// 		$sql = "SELECT seq, category_code, subject, user_id, user_name, file_changename, update_date, bnr.read_cnt FROM biz_notice_basic bnb
	// left JOIN (SELECT notice_seq, COUNT(user_seq) AS read_cnt FROM biz_notice_read GROUP BY notice_seq) AS bnr ON bnb.seq = bnr.notice_seq WHERE{$category_query}".$searchstring." ORDER BY seq desc";

		$sql = "SELECT seq, subject, user_id, user_name, file_changename, update_date, IFNULL(br.read_cnt, 0) AS read_cnt, br2.user_seq
FROM notice_basic nb
LEFT JOIN (
SELECT table_seq, COUNT(user_seq) AS read_cnt, target
FROM board_read
GROUP BY target, table_seq
HAVING target = 'notice') AS br ON nb.seq = br.table_seq
LEFT JOIN (
SELECT user_seq, table_seq, target
FROM board_read
GROUP BY target, table_seq, user_seq HAVING target = 'notice' AND user_seq = {$this->seq}
) AS br2 ON nb.seq = br2.table_seq
	WHERE 1=1 ".$searchstring."
	ORDER BY seq DESC";

		if  ( $offset <> 0 ) {
			$sql = $sql." LIMIT {$start_limit}, {$offset}";
		}
		$query = $this->db->query( $sql );
		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

	//공지사항 리스트개수
	function notice_list_count($searchkeyword, $search1) {

		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "001") {
				$searchstring = " AND subject LIKE '{$keyword}' ";
			}else if($search1 == "002"){
				$searchstring = " AND user_name LIKE '{$keyword}' ";
			}

		} else {
			$searchstring = "";

		}

		$sql = "SELECT count(seq) AS ucount FROM notice_basic WHERE 1=1".$searchstring." ORDER BY seq DESC";
		$query = $this->db->query( $sql );
		return $query->row();
	}

	//	공지사항 뷰내용 가져오기
	function notice_view( $seq = 0 ) {
		$sql = "select * from notice_basic where seq = {$seq}";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	// 공지사항 추가및 수정
	function notice_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('notice_basic', $data );
		} else{
			return $this->db->update('notice_basic', $data, array('seq' => $seq));
		}
	}

	// 공지사항 삭제
	function notice_delete( $seq ) {
		$sql = "delete from notice_basic where seq = {$seq}";
		$query = $this->db->query( $sql );

		return	$query;
	}

}
?>
