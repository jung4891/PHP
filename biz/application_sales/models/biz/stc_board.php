<?php
header("Content-type: text/html; charset=utf-8");

class STC_Board extends CI_Model {

	function __construct() {

		parent::__construct();
//		$this->user_id = $this->phpsession->get( 'id', 'stc' );
	}

	// 공지사항 추가및 수정
	function notice_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
				return $this->db->insert('biz_notice_basic', $data );
			} else{
				return $this->db->update('biz_notice_basic', $data, array('seq' => $seq));
			}
		}

	function get_notice_seq(){

			$sql ="SELECT AUTO_INCREMENT as notice_seq FROM information_schema.tables WHERE table_name = 'biz_notice_basic' AND table_schema = DATABASE()";
			$query = $this->db->query($sql)->row();
			$notice_seq = $query->notice_seq-1;
			return $notice_seq;

	}
// 개발 공지 입력
	function notice_insert_lab($data){
	  $result = $this->db->insert_batch('biz_notice_lab', $data);
	  return $result;
	}

// 개발 공지 수정
	function notice_content_update($data, $seq){
		$this->db->where('seq', $seq);
	  $result = $this->db->update('biz_notice_lab', $data);
	  return $result;
	}
// 개발공지 내용 제거
	function notice_content_del($seq, $mode){
		if($mode == 'all'){

			$sql = "DELETE FROM biz_notice_lab WHERE notice_seq ='{$seq}'";
			$query = $this->db->query( $sql );
			return $query;
		}else{
			$sql = "DELETE FROM biz_notice_lab WHERE seq ={$seq}";
		  $query = $this->db->query( $sql );
		  return $query;
		}
	}

	//	공지사항 뷰내용 가져오기
	function notice_view( $seq = 0 ) {
		$sql = "select * from biz_notice_basic where seq = {$seq}";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	function notice_view_lab( $seq = 0 ) {
		$sql = "SELECT * FROM biz_notice_lab WHERE notice_seq = {$seq} ORDER BY tr_index";

		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array() ;
		}
	}
// 개발 구분별 완료여부 카운트 ( then은 의미 없음)
	function notice_type_count($seq = 0){
		$sql="SELECT
COUNT(CASE WHEN dev_type='new' AND complete_yn = 'Y' THEN 1 END) AS new_y,
COUNT(CASE WHEN dev_type='new' AND complete_yn = 'N' THEN 1 END) AS new_n,
COUNT(CASE WHEN dev_type='imp' AND complete_yn = 'Y' THEN 1 END) AS imp_y,
COUNT(CASE WHEN dev_type='imp' AND complete_yn = 'N' THEN 1 END) AS imp_n,
COUNT(CASE WHEN dev_type='bug' AND complete_yn = 'Y' THEN 1 END) AS bug_y,
COUNT(CASE WHEN dev_type='bug' AND complete_yn = 'N' THEN 1 END) AS bug_n
FROM biz_notice_lab
WHERE notice_seq = {$seq}";
$query = $this->db->query($sql);

if ($query->num_rows() <= 0) {
	return false;
} else {
	return $query->row();
}

	}

	//공지사항 파일체크
	function notice_file( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from biz_notice_basic where seq = {$seq} and file_changename = {$filelcname}";
		$query = $this->db->query( $sql );
		return $query->row_array();
	}

	// 공지사항 파일삭제
	function notice_filedel($seq) {
		$sql = "update biz_notice_basic set file_changename = NULL, file_realname = NULL where seq = {$seq}";
		$result = $this->db->query( $sql );
		return $result;

	}

	// 공지사항 삭제
	function notice_delete( $seq ) {
		$sql = "delete from biz_notice_basic where seq = {$seq}";
		$query = $this->db->query( $sql );

		return	$query;
	}

	// 공지사항 리스트
	function notice_list( $category, $searchkeyword, $search1, $start_limit = 0, $offset = 0) {
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

		if($category == "002"){
			$category_query = " (category_code = '002' OR category_code = '004')";
		}else{
			$category_query = " category_code = '{$category}'";
		}

		// $sql = "SELECT seq, category_code, subject, user_id, user_name, file_changename, update_date FROM biz_notice_basic WHERE{$category_query}".$searchstring." ORDER BY seq DESC";

		$sql = "SELECT seq, category_code, subject, user_id, user_name, file_changename, update_date, bnr.read_cnt FROM biz_notice_basic bnb
left JOIN (SELECT notice_seq, COUNT(user_seq) AS read_cnt FROM biz_notice_read GROUP BY notice_seq) AS bnr ON bnb.seq = bnr.notice_seq WHERE{$category_query}".$searchstring." ORDER BY seq desc";

		if  ( $offset <> 0 ) {
			$sql = $sql." LIMIT {$start_limit}, {$offset}";
		}
		$query = $this->db->query( $sql );
		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

	//공지사항 리스트개수
	function notice_list_count($category, $searchkeyword, $search1) {
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

		$sql = "SELECT count(seq) AS ucount FROM biz_notice_basic WHERE category_code = '{$category}'".$searchstring." ORDER BY seq DESC";
		$query = $this->db->query( $sql );
		return $query->row();
	}

	// 공지사항 최근글표시
	function notice_new() {
		$sql = "select seq, update_date from biz_notice_basic order by seq desc";
		$query = $this->db->query( $sql );
		return $query->result_array();
	}

	function notice_read_count($notice_seq, $user_seq) {
		$sql = "select count(*) as cnt from biz_notice_read where notice_seq = {$notice_seq} and user_seq = {$user_seq}";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	function notice_read_insert($notice_seq, $user_seq, $data) {
		$this->db->insert('biz_notice_read', $data );
	}

	function reader_list($notice_seq) {
		$sql = "SELECT bnr.*, u.user_name, user_duty FROM biz_notice_read bnr left JOIN user u ON bnr.user_seq = u.seq WHERE notice_seq = {$notice_seq} order by seq desc";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

}
?>
