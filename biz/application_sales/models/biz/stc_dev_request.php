<?php
header("Content-type: text/html; charset=utf-8");

class STC_dev_request extends CI_Model {

	function __construct() {

		parent::__construct();
	}

	// 공지사항 리스트
	function dev_request_list($searchkeyword, $search1, $start_limit = 0, $offset = 0) {
		if($this->group == 'CEO' || $this->pGroupName == '기술연구소') {
			$group = " WHERE 1=1 ";
		} else {
			$group = " WHERE parentGroupName = '{$this->pGroupName}' ";
		}

		$keyword = "%".$searchkeyword."%";

    if($searchkeyword != '') {
      if($search1 == '001') {
        $searchstring = " AND dr.subject LIKE '{$keyword}'";
      } else if($search1 == '002') {
        $searchstring = " AND u.user_name LIKE '{$keyword}'";
      }
    } else {
      $searchstring = "";
    }

		$sql = "SELECT dr.*, u.user_name, responsibility FROM dev_request dr JOIN user u ON dr.insert_id = u.user_id LEFT JOIN dev_request_detail drd ON dr.seq = drd.dev_request_seq {$group} {$searchstring} ORDER BY seq DESC";

		$sql = "SELECT dr.*, u.user_name, responsibility, ug.parentGroupName FROM dev_request dr JOIN user u ON dr.insert_id = u.user_id LEFT JOIN dev_request_detail drd ON dr.seq = drd.dev_request_seq  LEFT JOIN user_group ug ON u.user_group = ug.groupName {$group} {$searchstring} ORDER BY seq DESC";

		if  ( $offset <> 0 ) {
			$sql = $sql." LIMIT {$start_limit}, {$offset}";
		}
		$query = $this->db->query( $sql );

		return $query->result_array(); // 결과값 전부 리턴
	}

	// 공지사항 리스트갯수
	function dev_request_list_count($searchkeyword, $search1) {
		if($this->group == 'CEO' || $this->pGroupName == '기술연구소') {
			$group = " WHERE 1=1 ";
		} else {
			$group = " WHERE parentGroupName = '{$this->pGroupName}' ";
		}

		$keyword = "%".$searchkeyword."%";

    if($searchkeyword != '') {
      if($search1 == '001') {
        $searchstring = " AND dr.subject LIKE '{$keyword}'";
      } else if($search1 == '002') {
        $searchstring = " AND u.user_name LIKE '{$keyword}'";
      }
    } else {
      $searchstring = "";
    }

		$sql = "SELECT count(*) as ucount FROM dev_request dr JOIN user u ON dr.insert_id = u.user_id LEFT JOIN dev_request_detail drd ON dr.seq = drd.dev_request_seq  LEFT JOIN user_group ug ON u.user_group = ug.groupName {$group} {$searchstring}";

		$query = $this->db->query($sql);

		return $query->row();
	}

	// 공지사항 추가 및 수정
	function dev_request_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
				return $this->db->insert('dev_request', $data );
			} else{
				return $this->db->update('dev_request', $data, array('seq' => $seq));
			}
	}

	// 첫등록인지 수정인지 구분위한 카운트
	function dev_request_lab_check( $seq ) {
			$sql = "SELECT COUNT(*) AS cnt FROM dev_request_detail WHERE dev_request_seq = {$seq}";

			$query = $this->db->query($sql);

			return $query->row_array();
	}

	// 기술연구소만 추가 및 수정
	function dev_request_lab_insert( $data, $mode = 0, $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('dev_request_detail', $data );
			} else{
	  		return $this->db->update('dev_request_detail', $data, array('dev_request_seq' => $seq));
		}
	}

	// 개발진행 update
	function progress_step_insert( $pro_data, $seq) {
		return $this->db->update('dev_request', $pro_data, array('seq' => $seq));

	}

	//	공지사항 뷰내용 가져오기
	function dev_request_view( $seq = 0 ) {
		$sql = "SELECT dr.*, u.user_name from dev_request dr
		JOIN user u
		ON dr.insert_id = u.user_id
		WHERE dr.seq = {$seq}";
		$query = $this->db->query( $sql );

		if($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ; // 한 줄만 리턴
		}
	}

	// 공지사항 뷰내용 상세보기 가져오기
	function dev_request_view_detail( $seq = 0 ){
		$sql = "SELECT * FROM dev_request_detail WHERE dev_request_seq = {$seq}";
		$query = $this->db->query( $sql );

		if($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ; // 한 줄만 리턴
		}
	}

	// 파일체크
	function file_check($seq, $filelcname){
		 $sql = "SELECT seq, file_realname, file_changename FROM dev_request WHERE seq = ? AND file_changename = ?";
		 $query = $this->db->query( $sql, array($seq, $filelcname) );
		 return $query->row_array();
	}

	function dev_request_modify(){
		$sql = "SELECT * FROM dev_request_detail";
		$query = $this->db->query( $sql );

		return $query->row_array();
	}

	function dev_request_delete($seq) {
    return $this->db->where('seq', $seq)->delete('dev_request');
  }

	function dev_lab_delete($seq) {
    return $this->db->where('dev_request_seq', $seq)->delete('dev_request_detail');
  }

	function comment_list($seq) {
    $sql = "SELECT drc.*, u.user_name FROM dev_request_comment drc JOIN user u on drc.writer = u.user_id WHERE dev_request_seq = {$seq} order by seq";

    $query = $this->db->query($sql);

    return $query->result_array();
  }

	function insert_comment($data) {
    return $this->db->insert('dev_request_comment', $data);
  }

  function delete_comment($seq) {
    return $this->db->where('seq', $seq)->delete('dev_request_comment');
  }

}
?>
