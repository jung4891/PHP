<?php
header("Content-type: text/html; charset=utf-8");

class STC_Official_doc extends CI_Model {

	function __construct() {

		parent::__construct();
		$this->user_id = $this->phpsession->get( 'id', 'rms' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->seq = $this->phpsession->get( 'seq', 'stc' );
	}

	function official_doc_list($mode, $id, $searchkeyword='', $start_limit = 0, $offset = 0) {
		$searchstring = "";
		if($searchkeyword != '') {
			$searchkeyword = explode(',', $searchkeyword);
			if(trim($searchkeyword[0])!='') { // 결재상태
				$searchstring .= " AND ead.approval_doc_status = '{$searchkeyword[0]}'";
			}

			if(trim($searchkeyword[1])!='') { // 문서양식
				$searchstring .= " AND odl.doc_type = '{$searchkeyword[1]}'";
			}

			if(trim($searchkeyword[2])!='') { // 작성일
				$searchstring .= " AND date_format(odl.write_date, '%Y-%m-%d') >= '{$searchkeyword[2]}'";
			}

			if(trim($searchkeyword[3])!='') { // 작성일
				$searchstring .= " AND date_format(odl.write_date, '%Y-%m-%d') <= '{$searchkeyword[3]}'";
			}

			if(trim($searchkeyword[5])!='') {
				if($searchkeyword[4] == 'doc_num') {
					$searchstring .= " AND CONCAT(odl.doc_num, CONCAT(SUBSTR(odl.doc_num2,1,4), '-', SUBSTR(odl.doc_num2,5,8))) like '%{$searchkeyword[5]}%'";
				} else {
					$searchstring .= " AND odl.".$searchkeyword[4]." LIKE '%{$searchkeyword[5]}%'";
				}
			}
		}

		if($mode == 'list') {
			$sql = "SELECT odl.*, ead.approval_doc_status FROM official_doc_list odl LEFT JOIN electronic_approval_doc ead ON odl.approval_seq = ead.seq where odl.write_id='{$id}' {$searchstring} order by seq desc";
		}else if ($mode == 'admin') {
			$sql = "SELECT odl.*, ead.approval_doc_status FROM official_doc_list odl LEFT JOIN electronic_approval_doc ead ON odl.approval_seq = ead.seq where ead.approval_doc_status = '002' {$searchstring} order by doc_num2 desc";
		} else if ($mode == 'attachment') {
			$sql = "SELECT odl.*, ead.approval_doc_status
							FROM official_doc_list odl
							LEFT JOIN electronic_approval_doc ead ON odl.approval_seq = ead.seq
							WHERE odl.write_id = '{$id}' and
							(ead.approval_doc_status IS NULL || ead.approval_doc_status NOT IN ('001','002')) {$searchstring}
							ORDER BY seq DESC";
		}
// echo $sql;
		if  ( $offset <> 0 ) {
			$sql = $sql." LIMIT {$start_limit}, {$offset}";
		}

		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	function official_doc_view($seq) {
		$sql = "select odl.*, ead.approval_doc_status from official_doc_list odl LEFT JOIN electronic_approval_doc ead ON odl.approval_seq = ead.seq where odl.seq = {$seq}";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function my_prev_data($id) {
		$sql = "select count(*) as cnt from official_doc_preview where user_id = '{$id}'";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function insert_prev_data($data, $mode) {
		if($mode == 1) {
			$this->db->insert('official_doc_preview', $data);
		} else {
			$this->db->where('user_id', $data['user_id']);
			$this->db->update('official_doc_preview', $data);
		}
	}

	function official_doc_preview($id) {
		$sql = "select * from official_doc_preview where user_id = '{$id}'";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function official_doc_input($data, $mode) {
		if ($mode == 1) {
			$result = $this->db->insert('official_doc_list', $data);
		} else {
			$this->db->where('seq', $data['seq']);
			$result = $this->db->update('official_doc_list', $data);
		}

		return $result;
	}

	function official_doc_delete($seq) {
		$sql = "delete from official_doc_list where seq = {$seq}";

		$result = $this->db->query($sql);

		return $result;
	}

	function official_doc_attach_approval($doc_seq, $oda_seq) {
		$sql = "update official_doc_list set approval_seq = {$doc_seq} where seq = {$oda_seq}";

		$this->db->query($sql);
	}

	function official_doc_yn($form_seq) {
		$sql = "select official_doc from electronic_approval_form where seq = {$form_seq}";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function official_doc_approval($approval_doc_seq) {
		$sql = "select * from official_doc_list where approval_seq = {$approval_doc_seq}";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function official_doc_approve($seq) {
		$data['doc_num'] = 'DUIT-11-';
		$sql = "SELECT max(doc_num2) as max_doc_num from official_doc_list";
		$query = $this->db->query($sql);
		$max_doc_num = $query->row_array();
		$max_doc_num = $max_doc_num['max_doc_num'];
		if($max_doc_num == null || $max_doc_num == '') {
			$num = sprintf('%08d', 1);
		} else {
			$num = sprintf('%08d', $max_doc_num + 1);
		}
		$data['doc_num2'] = $num;

		$this->db->where('seq', $seq);
		$this->db->update('official_doc_list', $data);
	}

	function official_doc_personal_text($id) {
		$sql = "SELECT * FROM official_doc_personal_text where user_id = '{$id}'";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function official_doc_form($seq) {
		if ($seq == 'all') {
			$where = '';
		} else {
			$where = " WHERE seq = {$seq}";
		}
		$sql = "SELECT * FROM official_doc_form {$where} order by doc_name";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function my_headerfooter($id) {
		$sql = "select count(*) as cnt from official_doc_personal_text where user_id = '{$id}'";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function save_headerfooter($data, $mode) {
		if($mode == 1) {
			$this->db->insert('official_doc_personal_text', $data);
		} else {
			$this->db->where('user_id', $data['user_id']);
			$result = $this->db->update('official_doc_personal_text', $data);

			return $result;
		}
	}

	function official_doc_approval_doc_form() {
		$sql = "SELECT eaf.*, fc.category_name from electronic_approval_form eaf left join format_category fc on eaf.template_category = fc.seq where official_doc = 'Y'";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function official_doc_data($seq) {
		$order = $seq;
		$seq = str_replace(',',"','", $seq);
		$sql = "SELECT * from official_doc_list where seq in ('{$seq}') order by field(seq, {$order})";
// echo $sql;
		$query = $this->db->query($sql);

		return $query->result_array();
	}

}
?>
