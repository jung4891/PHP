<?php
header("Content-type: text/html; charset=utf-8");

class STC_Health_certificate extends CI_Model {

	function __construct() {

		parent::__construct();

	}

	function doc_list($searchkeyword, $search1, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "001") {
				$searchstring = " AND CONCAT('건강검진(보건증) 관리대장_', year, '년 ', month, '월') LIKE '{$keyword}' ";
			}else if($search1 == "002"){
				$searchstring = " AND user_name LIKE '{$keyword}' ";
			}

		} else {
			$searchstring = "";

		}

		$sql = "SELECT hc.seq, year, month, write_id, user_name, hc.update_date, IFNULL(br.read_cnt, 0) AS read_cnt, br2.user_seq
FROM health_certificate hc
LEFT JOIN (
SELECT table_seq, COUNT(user_seq) AS read_cnt, target
FROM board_read
GROUP BY target, table_seq
HAVING target = 'health_certificate') AS br ON hc.seq = br.table_seq
LEFT JOIN (
SELECT user_seq, table_seq, target
FROM board_read
GROUP BY target, table_seq, user_seq HAVING target = 'health_certificate' AND user_seq = {$this->seq}
) AS br2 ON hc.seq = br2.table_seq
LEFT JOIN user u ON hc.write_id = u.user_id
	WHERE 1=1 ".$searchstring."
	ORDER BY seq DESC";

		if  ( $offset <> 0 ) {
			$sql = $sql." LIMIT {$start_limit}, {$offset}";
		}
		$query = $this->db->query( $sql );
		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

	function doc_list_count($searchkeyword, $search1) {

		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "001") {
				$searchstring = " AND CONCAT('건강검진(보건증) 관리대장_', year, '년 ', month, '월') LIKE '{$keyword}' ";
			}else if($search1 == "002"){
				$searchstring = " AND user_name LIKE '{$keyword}' ";
			}

		} else {
			$searchstring = "";

		}

		$sql = "SELECT count(hc.seq) AS ucount FROM health_certificate hc LEFT JOIN user u ON hc.write_id = u.user_id WHERE 1=1".$searchstring." ORDER BY hc.seq DESC";
		$query = $this->db->query( $sql );
		return $query->row();
	}

	function user_health_list() {
		$sql = "SELECT seq, user_name, health_certificate_term_s, health_certificate_term_e FROM user WHERE (admin = 'N' || (admin = 'Y' AND health_certificate_term_s IS NOT NULL AND health_certificate_term_e IS NOT NULL))";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function duple_check($year, $month) {
		$sql = "SELECT * FROM health_certificate WHERE year = '{$year}' AND month = '{$month}'";

		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return true;
		}
	}

	function gen_doc($data) {
		$this->db->insert('health_certificate', $data);
		return $this->db->insert_id();
	}

	function insert_doc_contents($data) {
		return $this->db->insert('health_certificate_content', $data);
	}

	function doc_data($seq) {
		$sql = "SELECT hc.*, u.user_name FROM health_certificate hc LEFT JOIN user u ON hc.write_id = u.user_id WHERE hc.seq = {$seq}";

		$query = $this->db->query($sql);

		return  $query->row_array();
	}

	function contents_data($doc_seq) {
		$sql = "SELECT * FROM health_certificate_content WHERE upper_seq = {$doc_seq}";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function doc_delete($seq) {
		$sql = "DELETE FROM health_certificate WHERE seq = {$seq}";

		$this->db->query($sql);

		$sql2 = "DELETE FROM health_certificate_content WHERE upper_seq = {$seq}";

		return $this->db->query($sql2);
	}

}
?>
