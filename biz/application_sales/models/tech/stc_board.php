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
			return $this->db->insert('customer_notice_basic', $data );
		}
		else {
			return $this->db->update('customer_notice_basic', $data, array('seq' => $seq));
		}
	}

	//	공지사항 뷰내용 가져오기
	function notice_view( $seq = 0 ) {
		$sql = "select category_code, subject, contents, user_id, user_name, file_changename, file_realname, insert_date from customer_notice_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	//공지사항 파일체크
	function notice_file( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from customer_notice_basic where seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );
		return $query->row_array();
	}

	// 공지사항 파일삭제
	function notice_filedel($seq) {
		$sql = "update customer_notice_basic set file_changename = ?, file_realname = ? where seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	// 공지사항 삭제
	function notice_delete( $seq ) {
		$sql = "delete from customer_notice_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	// 공지사항 리스트
	function notice_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "001" && $search2 == "001") {
				$searchstring = " where category_code = '001' and subject like ? ";
			} else if($search1 == "001" && $search2 == "002") {
				$searchstring = " where category_code = '001' and user_name like ? ";
			} else if($search1 == "002" && $search2 == "001") {
				$searchstring = " where category_code = '002' and subject like ? ";
			} else if($search1 == "002" && $search2 == "002") {
				$searchstring = " where category_code = '002' and user_name like ? ";
			} else if($search1 == "003" && $search2 == "001") {
				$searchstring = " where category_code = '003' and subject like ? ";
			} else if($search1 == "003" && $search2 == "002") {
				$searchstring = " where category_code = '003' and user_name like ? ";
			} else if($search1 == "004" && $search2 == "001") {
				$searchstring = " where category_code = '004' and subject like ? ";
			} else if($search1 == "004" && $search2 == "002") {
				$searchstring = " where category_code = '004' and user_name like ? ";
                        } else if($search1 == "005" && $search2 == "001") {
                                $searchstring = " where category_code = '005' and subject like ? ";
                        } else if($search1 == "005" && $search2 == "002") {
                                $searchstring = " where category_code = '005' and user_name like ? ";
                        } else if($search1 == "006" && $search2 == "001") {
                                $searchstring = " where category_code = '006' and subject like ? ";
                        } else if($search1 == "006" && $search2 == "002") {
                                $searchstring = " where category_code = '006' and user_name like ? ";
                        } else if($search1 == "007" && $search2 == "001") {
                                $searchstring = " where category_code = '007' and subject like ? ";
                        } else if($search1 == "007" && $search2 == "002") {
                                $searchstring = " where category_code = '007' and user_name like ? ";
                        } else if($search1 == "008" && $search2 == "001") {
                                $searchstring = " where category_code = '008' and subject like ? ";
                        } else if($search1 == "008" && $search2 == "002") {
                                $searchstring = " where category_code = '008' and user_name like ? ";
                        } else if($search1 == "009" && $search2 == "001") {
                                $searchstring = " where category_code = '009' and subject like ? ";
                        } else if($search1 == "009" && $search2 == "002") {
                                $searchstring = " where category_code = '009' and user_name like ? ";
                        } else if($search1 == "010" && $search2 == "001") {
                                $searchstring = " where category_code = '010' and subject like ? ";
                        } else if($search1 == "010" && $search2 == "002") {
                                $searchstring = " where category_code = '010' and user_name like ? ";
                        } else if($search1 == "011" && $search2 == "001") {
                                $searchstring = " where category_code = '011' and subject like ? ";
                        } else if($search1 == "011" && $search2 == "002") {
                                $searchstring = " where category_code = '011' and user_name like ? ";
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
                        if($search1 == "001" && $search2 == "001") {
                                $searchstring = " where category_code = '001' ";
                        } else if($search1 == "001" && $search2 == "002") {
                                $searchstring = " where category_code = '001' ";
                        } else if($search1 == "002" && $search2 == "001") {
                                $searchstring = " where category_code = '002' ";
                        } else if($search1 == "002" && $search2 == "002") {
                                $searchstring = " where category_code = '002' ";
                        } else if($search1 == "003" && $search2 == "001") {
                                $searchstring = " where category_code = '003' ";
                        } else if($search1 == "003" && $search2 == "002") {
                                $searchstring = " where category_code = '003' ";
                        } else if($search1 == "004" && $search2 == "001") {
                                $searchstring = " where category_code = '004' ";
                        } else if($search1 == "004" && $search2 == "002") {
                                $searchstring = " where category_code = '004' ";
                        } else if($search1 == "005" && $search2 == "001") {
                                $searchstring = " where category_code = '005' ";
                        } else if($search1 == "005" && $search2 == "002") {
                                $searchstring = " where category_code = '005' ";
                        } else if($search1 == "006" && $search2 == "001") {
                                $searchstring = " where category_code = '006' ";
                        } else if($search1 == "006" && $search2 == "002") {
                                $searchstring = " where category_code = '006' ";
                        } else if($search1 == "007" && $search2 == "001") {
                                $searchstring = " where category_code = '007' ";
                        } else if($search1 == "007" && $search2 == "002") {
                                $searchstring = " where category_code = '007' ";
                        } else if($search1 == "008" && $search2 == "001") {
                                $searchstring = " where category_code = '008' ";
                        } else if($search1 == "008" && $search2 == "002") {
                                $searchstring = " where category_code = '008' ";
                        } else if($search1 == "009" && $search2 == "001") {
                                $searchstring = " where category_code = '009' ";
                        } else if($search1 == "009" && $search2 == "002") {
                                $searchstring = " where category_code = '009' ";
                        } else if($search1 == "010" && $search2 == "001") {
                                $searchstring = " where category_code = '010' ";
                        } else if($search1 == "010" && $search2 == "002") {
                                $searchstring = " where category_code = '010' ";
                        } else if($search1 == "011" && $search2 == "001") {
                                $searchstring = " where category_code = '011' ";
                        } else if($search1 == "011" && $search2 == "002") {
                                $searchstring = " where category_code = '011' ";
                        } else if($search1 == "000" && $search2 == "001") {
                                $searchstring = "";
                        } else if($search1 == "000" && $search2 == "002") {
                                $searchstring = "";
                        }
		}

		$sql = "select seq, category_code, subject, user_id, user_name, file_changename, insert_date from customer_notice_basic".$searchstring." order by seq desc";
		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
		else
			$query = $this->db->query( $sql, array( $start_limit, $offset ) );

		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

	//공지사항 리스트개수
	function notice_list_count($searchkeyword, $search1, $search2) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "001" && $search2 == "001") {
				$searchstring = " where category_code = '001' and subject like ? ";
			} else if($search1 == "001" && $search2 == "002") {
				$searchstring = " where category_code = '001' and user_name like ? ";
			} else if($search1 == "002" && $search2 == "001") {
				$searchstring = " where category_code = '002' and subject like ? ";
			} else if($search1 == "002" && $search2 == "002") {
				$searchstring = " where category_code = '002' and user_name like ? ";
			} else if($search1 == "003" && $search2 == "001") {
				$searchstring = " where category_code = '003' and subject like ? ";
			} else if($search1 == "003" && $search2 == "002") {
				$searchstring = " where category_code = '003' and user_name like ? ";
			} else if($search1 == "004" && $search2 == "001") {
				$searchstring = " where category_code = '004' and subject like ? ";
			} else if($search1 == "004" && $search2 == "002") {
				$searchstring = " where category_code = '004' and user_name like ? ";
                        } else if($search1 == "005" && $search2 == "001") {
                                $searchstring = " where category_code = '005' and subject like ? ";
                        } else if($search1 == "005" && $search2 == "002") {
                                $searchstring = " where category_code = '005' and user_name like ? ";
                        } else if($search1 == "006" && $search2 == "001") {
                                $searchstring = " where category_code = '006' and subject like ? ";
                        } else if($search1 == "006" && $search2 == "002") {
                                $searchstring = " where category_code = '006' and user_name like ? ";
                        } else if($search1 == "007" && $search2 == "001") {
                                $searchstring = " where category_code = '007' and subject like ? ";
                        } else if($search1 == "007" && $search2 == "002") {
                                $searchstring = " where category_code = '007' and user_name like ? ";
                        } else if($search1 == "008" && $search2 == "001") {
                                $searchstring = " where category_code = '008' and subject like ? ";
                        } else if($search1 == "008" && $search2 == "002") {
                                $searchstring = " where category_code = '008' and user_name like ? ";
                        } else if($search1 == "009" && $search2 == "001") {
                                $searchstring = " where category_code = '009' and subject like ? ";
                        } else if($search1 == "009" && $search2 == "002") {
                                $searchstring = " where category_code = '009' and user_name like ? ";
                        } else if($search1 == "010" && $search2 == "001") {
                                $searchstring = " where category_code = '010' and subject like ? ";
                        } else if($search1 == "010" && $search2 == "002") {
                                $searchstring = " where category_code = '010' and user_name like ? ";
                        } else if($search1 == "011" && $search2 == "001") {
                                $searchstring = " where category_code = '011' and subject like ? ";
                        } else if($search1 == "011" && $search2 == "002") {
                                $searchstring = " where category_code = '011' and user_name like ?";
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
                        if($search1 == "001" && $search2 == "001") {
                                $searchstring = " where category_code = '001' ";
                        } else if($search1 == "001" && $search2 == "002") {
                                $searchstring = " where category_code = '001' ";
                        } else if($search1 == "002" && $search2 == "001") {
                                $searchstring = " where category_code = '002' ";
                        } else if($search1 == "002" && $search2 == "002") {
                                $searchstring = " where category_code = '002' ";
                        } else if($search1 == "003" && $search2 == "001") {
                                $searchstring = " where category_code = '003' ";
                        } else if($search1 == "003" && $search2 == "002") {
                                $searchstring = " where category_code = '003' ";
                        } else if($search1 == "004" && $search2 == "001") {
                                $searchstring = " where category_code = '004' ";
                        } else if($search1 == "004" && $search2 == "002") {
                                $searchstring = " where category_code = '004' ";
                        } else if($search1 == "005" && $search2 == "001") {
                                $searchstring = " where category_code = '005' ";
                        } else if($search1 == "005" && $search2 == "002") {
                                $searchstring = " where category_code = '005' ";
                        } else if($search1 == "006" && $search2 == "001") {
                                $searchstring = " where category_code = '006' ";
                        } else if($search1 == "006" && $search2 == "002") {
                                $searchstring = " where category_code = '006' ";
                        } else if($search1 == "007" && $search2 == "001") {
                                $searchstring = " where category_code = '007' ";
                        } else if($search1 == "007" && $search2 == "002") {
                                $searchstring = " where category_code = '007' ";
                        } else if($search1 == "008" && $search2 == "001") {
                                $searchstring = " where category_code = '008' ";
                        } else if($search1 == "008" && $search2 == "002") {
                                $searchstring = " where category_code = '008' ";
                        } else if($search1 == "009" && $search2 == "001") {
                                $searchstring = " where category_code = '009' ";
                        } else if($search1 == "009" && $search2 == "002") {
                                $searchstring = " where category_code = '009' ";
                        } else if($search1 == "010" && $search2 == "001") {
                                $searchstring = " where category_code = '010' ";
                        } else if($search1 == "010" && $search2 == "002") {
                                $searchstring = " where category_code = '010' ";
                        } else if($search1 == "011" && $search2 == "001") {
                                $searchstring = " where category_code = '011' ";
                        } else if($search1 == "011" && $search2 == "002") {
                                $searchstring = " where category_code = '011' ";
                        } else if($search1 == "000" && $search2 == "001") {
                                $searchstring = "";
                        } else if($search1 == "000" && $search2 == "002") {
                                $searchstring = "";
                        }
		}

		$sql = "select count(seq) as ucount from customer_notice_basic".$searchstring." order by seq desc";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );
		else
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// 공지사항 최근글표시
	function notice_new() {
		$sql = "select seq, update_date from customer_notice_basic order by seq desc";
		$query = $this->db->query( $sql );
		return $query->result_array();
	}

	// 자료실 최근글표시
	function manual_new() {
		$sql = "select seq, update_date from customer_manual_basic order by seq desc";
		$query = $this->db->query( $sql );
		return $query->result_array();
	}

	// 건의사항 최근글표시
	function suggest_new() {
		$sql = "select seq, update_date from customer_suggest_basic order by seq desc";
		$query = $this->db->query( $sql );
		return $query->result_array();
	}

	// FAQ 최근글표시
	function faq_new() {
		$sql = "select seq, update_date from customer_faq_basic order by seq desc";
		$query = $this->db->query( $sql );
		return $query->result_array();
	}

	// QNA 최근글표시
	function qna_new() {
		$sql = "select seq, update_date from customer_qna_basic order by seq desc";
		$query = $this->db->query( $sql );
		return $query->result_array();
	}

	// 매뉴얼 추가및 수정
	function manual_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('customer_manual_basic', $data );
		}
		else {
			return $this->db->update('customer_manual_basic', $data, array('seq' => $seq));
		}
	}

	//	매뉴얼 뷰내용 가져오기
	function manual_view( $seq = 0 ) {
		$sql = "select category_code, subject, contents, user_id, user_name, file_changename, file_realname, insert_date from customer_manual_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	//매뉴얼 파일체크
	function manual_file( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from customer_manual_basic where seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );
		return $query->row_array();
	}

	// 매뉴얼 파일삭제
	function manual_filedel($seq) {
		$sql = "update customer_manual_basic set file_changename = ?, file_realname = ? where seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	// 매뉴얼 삭제
	function manual_delete( $seq ) {
		$sql = "delete from customer_manual_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	// 매뉴얼 리스트
	function manual_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			} else if ($search1 != '000' && $search2 == '001') {
				$searchstring = " where category_code = '{$search1}' and subject like ?";
			} else if ($search1 != '000' && $search2 == '002') {
				$searchstring = " where category_code = '{$search1}' and user_name like ?";
			}
		} else {
			$searchstring = "";
			if($search1 == "000") {
				$searchstring = "";
			} else {
				$searchstring = " where category_code = '{$search1}'";
			}
		}
		if ($search1 == '') {
			$searchstring = '';
		}

		$sql = "select seq, category_code, subject, user_id, user_name, file_changename, insert_date from customer_manual_basic".$searchstring." order by seq desc";
		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
		else
			$query = $this->db->query( $sql, array( $start_limit, $offset ) );

		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

	//매뉴얼 리스트개수
	function manual_list_count($searchkeyword, $search1, $search2) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			} else if ($search1 != '000' && $search2 == '001') {
				$searchstring = " where category_code = '{$search1}' and subject like ?";
			} else if ($search1 != '000' && $search2 == '002') {
				$searchstring = " where category_code = '{$search1}' and user_name like ?";
			}
		} else {
			$searchstring = "";
			if($search1 == "000") {
				$searchstring = "";
			} else {
				$searchstring = " where category_code = '{$search1}'";
			}
		}
		if ($search1 == '') {
			$searchstring = '';
		}

		$sql = "select count(seq) as ucount from customer_manual_basic".$searchstring." order by seq desc";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );
		else
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// 교육자료 추가및 수정
	function edudata_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('customer_manageredu_basic', $data );
		}
		else {
			return $this->db->update('customer_manageredu_basic', $data, array('seq' => $seq));
		}
	}

	//	교육자료 뷰내용 가져오기
	function edudata_view( $seq = 0 ) {
		$sql = "select category_code, subject, contents, user_id, user_name, file_changename, file_realname, insert_date from customer_manageredu_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	//교육자료 파일체크
	function edudata_file( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from customer_manageredu_basic where seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );
		return $query->row_array();
	}

	// 교육자료 파일삭제
	function edudata_filedel($seq) {
		$sql = "update customer_manageredu_basic set file_changename = ?, file_realname = ? where seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	// 교육자료 삭제
	function edudata_delete( $seq ) {
		$sql = "delete from customer_manageredu_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	// 교육자료 리스트
	function edudata_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";
		if($searchkeyword != "") {
			if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			} else if ($search1 != '000' && $search2 == '001') {
				$searchstring = " where category_code = '{$search1}' and subject like ?";
			} else if ($search1 != '000' && $search2 == '002') {
				$searchstring = " where category_code = '{$search1}' and user_name like ?";
			}
		} else {
			$searchstring = "";
			if($search1 == "000") {
				$searchstring = "";
			} else {
				$searchstring = " where category_code = '{$search1}'";
			}
		}
		if ($search1 == '') {
			$searchstring = '';
		}

		$sql = "select seq, category_code, subject, user_id, user_name, file_changename, insert_date from customer_manageredu_basic".$searchstring." order by seq desc";
		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
		else
			$query = $this->db->query( $sql, array( $start_limit, $offset ) );

		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

	//교육자료 리스트개수
	function edudata_list_count($searchkeyword, $search1, $search2) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			} else if ($search1 != '000' && $search2 == '001') {
				$searchstring = " where category_code = '{$search1}' and subject like ?";
			} else if ($search1 != '000' && $search2 == '002') {
				$searchstring = " where category_code = '{$search1}' and user_name like ?";
			}
		} else {
			$searchstring = "";
			if($search1 == "000") {
				$searchstring = "";
			} else {
				$searchstring = " where category_code = '{$search1}'";
			}
		}
		if ($search1 == '') {
			$searchstring = '';
		}

		$sql = "select count(seq) as ucount from customer_manageredu_basic".$searchstring." order by seq desc";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );
		else
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// FAQ 추가및 수정
	function faq_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('customer_faq_basic', $data );
		}
		else {
			return $this->db->update('customer_faq_basic', $data, array('seq' => $seq));
		}
	}

	//	FAQ 뷰내용 가져오기
	function faq_view( $seq = 0 ) {
		$sql = "select category_code, subject, contents, user_id, user_name, file_changename, file_realname, insert_date from customer_faq_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	//FAQ 파일체크
	function faq_file( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from customer_faq_basic where seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );
		return $query->row_array();
	}

	// FAQ 파일삭제
	function faq_filedel($seq) {
		$sql = "update customer_faq_basic set file_changename = ?, file_realname = ? where seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	// FAQ 삭제
	function faq_delete( $seq ) {
		$sql = "delete from customer_faq_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}


		        // 릴리즈노트 삭제
        function network_map_delete( $seq ) {
                $sql = "delete from tech_network_map_basic where seq = ?";
                $query = $this->db->query( $sql, $seq );

                return  $query;
        }

	        // 릴리즈노트 추가및 수정
        function network_map_insert( $data, $mode = 0 , $seq = 0) {
                if( $mode == 0 ) {
                        return $this->db->insert('tech_network_map_basic', $data );
                }
                else {
                        return $this->db->update('tech_network_map_basic', $data, array('seq' => $seq));
                }
        }

//릴리즈노트 뷰
        function network_map_view( $seq = 0 ) {
                $sql = "select category_code, subject, contents, user_id, user_name, file_changename, file_realname, insert_date from tech_network_map_basic where seq = ?";
                $query = $this->db->query( $sql, $seq );

                if ($query->num_rows() <= 0) {
                        return false;
                } else {
                        return $query->row_array() ;
                }
        }

        //릴리즈노트 파일체크
        function network_map_file( $seq, $filelcname ) {
                $sql = "select seq, file_realname, file_changename from tech_network_map_basic where seq = ? and file_changename = ?";
                $query = $this->db->query( $sql, array($seq, $filelcname) );
                return $query->row_array();
        }

        // 릴리즈노트 파일삭제
        function network_map_filedel($seq) {
                $sql = "update tech_network_map_basic set file_changename = ?, file_realname = ? where seq = ?";
                $result = $this->db->query($sql, array(NULL,NULL,$seq));
                return $result;

        }




	// FAQ 리스트
	function faq_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			} else if ($search1 != '000' && $search2 == '001') {
				$searchstring = " where category_code = '{$search1}' and subject like ?";
			} else if ($search1 != '000' && $search2 == '002') {
				$searchstring = " where category_code = '{$search1}' and user_name like ?";
			}
		} else {
			$searchstring = "";
			if($search1 == "000") {
				$searchstring = "";
			} else {
				$searchstring = " where category_code = '{$search1}'";
			}
		}
		if ($search1 == '') {
			$searchstring = '';
		}

		$sql = "select seq, category_code, subject, user_id, user_name, file_changename, insert_date from customer_faq_basic".$searchstring." order by seq desc";
		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
		else
			$query = $this->db->query( $sql, array( $start_limit, $offset ) );

		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

	//FAQ 리스트개수
	function faq_list_count($searchkeyword, $search1, $search2) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			} else if ($search1 != '000' && $search2 == '001') {
				$searchstring = " where category_code = '{$search1}' and subject like ?";
			} else if ($search1 != '000' && $search2 == '002') {
				$searchstring = " where category_code = '{$search1}' and user_name like ?";
			}
		} else {
			$searchstring = "";
			if($search1 == "000") {
				$searchstring = "";
			} else {
				$searchstring = " where category_code = '{$search1}'";
			}
		}
		if ($search1 == '') {
			$searchstring = '';
		}

		$sql = "select count(seq) as ucount from customer_faq_basic".$searchstring." order by seq desc";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );
		else
			$query = $this->db->query( $sql );
		return $query->row();
	}

        // FAQ 리스트
        function network_map_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
                $keyword = "%".$searchkeyword."%";

                if($searchkeyword != "") {
                        if($search1 == "001") {
                                $searchstring = " where category_code like ? ";
                        } else if($search1 == "002") {
                                $searchstring = " where subject like ? ";
                        } else if($search1 == "003") {
                                $searchstring = " where user_name like ? ";
                        }
                } else {
                        $searchstring = "";
                }

                $sql = "select seq, category_code, subject, user_id, user_name, file_changename, insert_date from tech_network_map_basic".$searchstring." order by seq desc";
                if  ( $offset <> 0 )
                        $sql = $sql." limit ?, ?";

                if  ( $searchkeyword != "" )
                        $query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
                else
                        $query = $this->db->query( $sql, array( $start_limit, $offset ) );

                return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
        }





	//릴리즈노트 리스트개수
	function network_map_list_count($searchkeyword, $search1, $search2) {
			$keyword = "%".$searchkeyword."%";

			if($searchkeyword != "") {
					if($search1 == "001") {
							$searchstring = " where category_code like ? ";
					} else if($search1 == "002") {
							$searchstring = " where subject like ? ";
					} else if($search1 == "003") {
							$searchstring = " where user_name like ? ";
					}
			} else {
					$searchstring = "";
			}

			$sql = "select count(seq) as ucount from tech_network_map_basic".$searchstring." order by seq desc";

			if  ( $searchkeyword != "" )
					$query = $this->db->query( $sql, $keyword  );
			else
					$query = $this->db->query( $sql );
			return $query->row();
	}


	// 릴리즈노트 추가및 수정
	function release_note_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('tech_release_note_basic', $data );
		}
		else {
			return $this->db->update('tech_release_note_basic', $data, array('seq' => $seq));
		}
	}
	//	릴리즈노트 뷰내용 가져오기
	function release_note_view( $seq = 0 ) {
		$sql = "select category_code, subject, contents, user_id, user_name, user_email, file_changename, file_realname, insert_date from tech_release_note_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}
	//릴리즈노트 파일체크
	function release_note_file( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from tech_release_note_basic where seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );			return $query->row_array();
	}
	// 릴리즈노트 파일삭제
	function release_note_filedel($seq) {
		$sql = "update tech_release_note_basic set file_changename = ?, file_realname = ? where seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	// 릴리즈노트 삭제
	function release_note_delete( $seq ) {
		$sql = "delete from tech_release_note_basic where seq = ?";			$query = $this->db->query( $sql, $seq );

		$sql2 = "delete from tech_release_note_comment where bbs_seq = ?";			$query2 = $this->db->query( $sql2, $seq );

		return	$query;
	}

	// 릴리즈노트 리스트
	function release_note_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			} else if ($search1 != '000' && $search2 == '001') {
				$searchstring = " where category_code = '{$search1}' and subject like ?";
			} else if ($search1 != '000' && $search2 == '002') {
				$searchstring = " where category_code = '{$search1}' and user_name like ?";
			}
		} else {
			$searchstring = "";
			if($search1 == "000") {
				$searchstring = "";
			} else {
				$searchstring = " where category_code = '{$search1}'";
			}
		}
		if ($search1 == '') {
			$searchstring = '';
		}

		$sql = "select seq, category_code, subject, user_id, user_name, file_changename, cnum, insert_date from tech_release_note_basic".$searchstring." order by seq desc";
		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";
			if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );		else
			$query = $this->db->query( $sql, array( $start_limit, $offset ) );

		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}
	//릴리즈노트 리스트개수
	function release_note_list_count($searchkeyword, $search1, $search2) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			} else if ($search1 != '000' && $search2 == '001') {
				$searchstring = " where category_code = '{$search1}' and subject like ?";
			} else if ($search1 != '000' && $search2 == '002') {
				$searchstring = " where category_code = '{$search1}' and user_name like ?";
			}
		} else {
			$searchstring = "";
			if($search1 == "000") {
				$searchstring = "";
			} else {
				$searchstring = " where category_code = '{$search1}'";
			}
		}
		if ($search1 == '') {
			$searchstring = '';
		}

		$sql = "select count(seq) as ucount from tech_release_note_basic".$searchstring." order by seq desc";
		if  ( $searchkeyword != "" )
		$query = $this->db->query( $sql, $keyword  );		else
		$query = $this->db->query( $sql );
		return $query->row();
	}

	// 릴리즈노트 코멘트 추가
	function release_note_comment_insert( $data ) {
		return $this->db->insert('tech_release_note_comment', $data );
	}
	// 릴리즈노트 코멘트에 글쓴이 E-mail 정보 보내기  김수성 수정 -161228
	function release_note_get_email($seq){
			$sql = "select subject, user_email from tech_release_note_basic where seq = '".$seq."'";				$query = $this->db->query( $sql );
			return $query->result_array();
	}

	// 릴리즈노트 코멘트 등록시 본문 카운트 증가
	function release_note_cnum_update( $seq = 0) {
		$sql = "update tech_release_note_basic set cnum = cnum + 1 where seq = ?";			$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	// 릴리즈노트 코멘트 리스트
	function release_note_comment_list($seq) {
		$sql = "select seq, bbs_seq, user_id, user_name, contents, insert_date from tech_release_note_comment where bbs_seq = ? order by seq desc";
		$query = $this->db->query( $sql, $seq );

		return $query->result_array();
	}
	// 릴리즈노트 코멘트 삭제
	function release_note_comment_delete( $seq, $cseq ) {
		$sql = "delete from tech_release_note_comment where seq = ? and bbs_seq = ?";			$query = $this->db->query( $sql, array( $cseq, $seq ) );

		return	$query;
	}

	// 릴리즈노트 코멘트 삭제시 본문 카운트 감소
	function release_note_cnum_update2( $seq = 0) {
		$sql = "update tech_release_note_basic set cnum = cnum - 1 where seq = ?";			$query = $this->db->query( $sql, $seq );

		return	$query;
	}



	// 건의사항 추가및 수정
	function suggest_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('customer_suggest_basic', $data );
		}
		else {
			return $this->db->update('customer_suggest_basic', $data, array('seq' => $seq));
		}
	}

	//	건의사항 뷰내용 가져오기
	function suggest_view( $seq = 0 ) {
		$sql = "select category_code, subject, contents, user_id, user_name, file_changename, file_realname, insert_date from customer_suggest_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	//건의사항 파일체크
	function suggest_file( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from customer_suggest_basic where seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );
		return $query->row_array();
	}

	// 건의사항 파일삭제
	function suggest_filedel($seq) {
		$sql = "update customer_suggest_basic set file_changename = ?, file_realname = ? where seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	// 건의사항 삭제
	function suggest_delete( $seq ) {
		$sql = "delete from customer_suggest_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	// 건의사항 리스트
	function suggest_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "001" && $search2 == "001") {
				$searchstring = " where category_code = '001' and subject like ? ";
			} else if($search1 == "001" && $search2 == "002") {
				$searchstring = " where category_code = '001' and user_name like ? ";
			} else if($search1 == "002" && $search2 == "001") {
				$searchstring = " where category_code = '002' and subject like ? ";
			} else if($search1 == "002" && $search2 == "002") {
				$searchstring = " where category_code = '002' and user_name like ? ";
			} else if($search1 == "003" && $search2 == "001") {
				$searchstring = " where category_code = '003' and subject like ? ";
			} else if($search1 == "003" && $search2 == "002") {
				$searchstring = " where category_code = '003' and user_name like ? ";
			} else if($search1 == "004" && $search2 == "001") {
				$searchstring = " where category_code = '004' and subject like ? ";
			} else if($search1 == "004" && $search2 == "002") {
				$searchstring = " where category_code = '004' and user_name like ? ";
                        } else if($search1 == "005" && $search2 == "001") {
                                $searchstring = " where category_code = '005' and subject like ? ";
                        } else if($search1 == "005" && $search2 == "002") {
                                $searchstring = " where category_code = '005' and user_name like ? ";
                        } else if($search1 == "006" && $search2 == "001") {
                                $searchstring = " where category_code = '006' and subject like ? ";
                        } else if($search1 == "006" && $search2 == "002") {
                                $searchstring = " where category_code = '006' and user_name like ? ";
                        } else if($search1 == "007" && $search2 == "001") {
                                $searchstring = " where category_code = '007' and subject like ? ";
                        } else if($search1 == "007" && $search2 == "002") {
                                $searchstring = " where category_code = '007' and user_name like ? ";
                        } else if($search1 == "008" && $search2 == "001") {
                                $searchstring = " where category_code = '008' and subject like ? ";
                        } else if($search1 == "008" && $search2 == "002") {
                                $searchstring = " where category_code = '008' and user_name like ? ";
                        } else if($search1 == "009" && $search2 == "001") {
                                $searchstring = " where category_code = '009' and subject like ? ";
                        } else if($search1 == "009" && $search2 == "002") {
                                $searchstring = " where category_code = '009' and user_name like ? ";
                        } else if($search1 == "010" && $search2 == "001") {
                                $searchstring = " where category_code = '010' and subject like ? ";
                        } else if($search1 == "010" && $search2 == "002") {
                                $searchstring = " where category_code = '010' and user_name like ? ";
                        } else if($search1 == "011" && $search2 == "001") {
                                $searchstring = " where category_code = '011' and subject like ? ";
                        } else if($search1 == "011" && $search2 == "002") {
                                $searchstring = " where category_code = '011' and user_name like ?";
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
                        if($search1 == "001" && $search2 == "001") {
                                $searchstring = " where category_code = '001' ";
                        } else if($search1 == "001" && $search2 == "002") {
                                $searchstring = " where category_code = '001' ";
                        } else if($search1 == "002" && $search2 == "001") {
                                $searchstring = " where category_code = '002' ";
                        } else if($search1 == "002" && $search2 == "002") {
                                $searchstring = " where category_code = '002' ";
                        } else if($search1 == "003" && $search2 == "001") {
                                $searchstring = " where category_code = '003' ";
                        } else if($search1 == "003" && $search2 == "002") {
                                $searchstring = " where category_code = '003' ";
                        } else if($search1 == "004" && $search2 == "001") {
                                $searchstring = " where category_code = '004' ";
                        } else if($search1 == "004" && $search2 == "002") {
                                $searchstring = " where category_code = '004' ";
                        } else if($search1 == "005" && $search2 == "001") {
                                $searchstring = " where category_code = '005' ";
                        } else if($search1 == "005" && $search2 == "002") {
                                $searchstring = " where category_code = '005' ";
                        } else if($search1 == "006" && $search2 == "001") {
                                $searchstring = " where category_code = '006' ";
                        } else if($search1 == "006" && $search2 == "002") {
                                $searchstring = " where category_code = '006' ";
                        } else if($search1 == "007" && $search2 == "001") {
                                $searchstring = " where category_code = '007' ";
                        } else if($search1 == "007" && $search2 == "002") {
                                $searchstring = " where category_code = '007' ";
                        } else if($search1 == "008" && $search2 == "001") {
                                $searchstring = " where category_code = '008' ";
                        } else if($search1 == "008" && $search2 == "002") {
                                $searchstring = " where category_code = '008' ";
                        } else if($search1 == "009" && $search2 == "001") {
                                $searchstring = " where category_code = '009' ";
                        } else if($search1 == "009" && $search2 == "002") {
                                $searchstring = " where category_code = '009' ";
                        } else if($search1 == "010" && $search2 == "001") {
                                $searchstring = " where category_code = '010' ";
                        } else if($search1 == "010" && $search2 == "002") {
                                $searchstring = " where category_code = '010' ";
                        } else if($search1 == "011" && $search2 == "001") {
                                $searchstring = " where category_code = '011' ";
                        } else if($search1 == "011" && $search2 == "002") {
                                $searchstring = " where category_code = '011' ";
                        } else if($search1 == "000" && $search2 == "001") {
                                $searchstring = "";
                        } else if($search1 == "000" && $search2 == "002") {
                                $searchstring = "";
                        }
		}

		$sql = "select seq, category_code, subject, user_id, user_name, file_changename, insert_date from customer_suggest_basic".$searchstring." order by seq desc";
		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
		else
			$query = $this->db->query( $sql, array( $start_limit, $offset ) );

		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

	//건의사항 리스트개수
	function suggest_list_count($searchkeyword, $search1, $search2) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "001" && $search2 == "001") {
				$searchstring = " where category_code = '001' and subject like ? ";
			} else if($search1 == "001" && $search2 == "002") {
				$searchstring = " where category_code = '001' and user_name like ? ";
			} else if($search1 == "002" && $search2 == "001") {
				$searchstring = " where category_code = '002' and subject like ? ";
			} else if($search1 == "002" && $search2 == "002") {
				$searchstring = " where category_code = '002' and user_name like ? ";
			} else if($search1 == "003" && $search2 == "001") {
				$searchstring = " where category_code = '003' and subject like ? ";
			} else if($search1 == "003" && $search2 == "002") {
				$searchstring = " where category_code = '003' and user_name like ? ";
			} else if($search1 == "004" && $search2 == "001") {
				$searchstring = " where category_code = '004' and subject like ? ";
			} else if($search1 == "004" && $search2 == "002") {
				$searchstring = " where category_code = '004' and user_name like ? ";
                        } else if($search1 == "005" && $search2 == "001") {
                                $searchstring = " where category_code = '005' and subject like ? ";
                        } else if($search1 == "005" && $search2 == "002") {
                                $searchstring = " where category_code = '005' and user_name like ? ";
                        } else if($search1 == "006" && $search2 == "001") {
                                $searchstring = " where category_code = '006' and subject like ? ";
                        } else if($search1 == "006" && $search2 == "002") {
                                $searchstring = " where category_code = '006' and user_name like ? ";
                        } else if($search1 == "007" && $search2 == "001") {
                                $searchstring = " where category_code = '007' and subject like ? ";
                        } else if($search1 == "007" && $search2 == "002") {
                                $searchstring = " where category_code = '007' and user_name like ? ";
                        } else if($search1 == "008" && $search2 == "001") {
                                $searchstring = " where category_code = '008' and subject like ? ";
                        } else if($search1 == "008" && $search2 == "002") {
                                $searchstring = " where category_code = '008' and user_name like ? ";
                        } else if($search1 == "009" && $search2 == "001") {
                                $searchstring = " where category_code = '009' and subject like ? ";
                        } else if($search1 == "009" && $search2 == "002") {
                                $searchstring = " where category_code = '009' and user_name like ? ";
                        } else if($search1 == "010" && $search2 == "001") {
                                $searchstring = " where category_code = '010' and subject like ? ";
                        } else if($search1 == "010" && $search2 == "002") {
                                $searchstring = " where category_code = '010' and user_name like ? ";
                        } else if($search1 == "011" && $search2 == "001") {
                                $searchstring = " where category_code = '011' and subject like ? ";
                        } else if($search1 == "011" && $search2 == "002") {
                                $searchstring = " where category_code = '011' and user_name like ?";
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
                        if($search1 == "001" && $search2 == "001") {
                                $searchstring = " where category_code = '001' ";
                        } else if($search1 == "001" && $search2 == "002") {
                                $searchstring = " where category_code = '001' ";
                        } else if($search1 == "002" && $search2 == "001") {
                                $searchstring = " where category_code = '002' ";
                        } else if($search1 == "002" && $search2 == "002") {
                                $searchstring = " where category_code = '002' ";
                        } else if($search1 == "003" && $search2 == "001") {
                                $searchstring = " where category_code = '003' ";
                        } else if($search1 == "003" && $search2 == "002") {
                                $searchstring = " where category_code = '003' ";
                        } else if($search1 == "004" && $search2 == "001") {
                                $searchstring = " where category_code = '004' ";
                        } else if($search1 == "004" && $search2 == "002") {
                                $searchstring = " where category_code = '004' ";
                        } else if($search1 == "005" && $search2 == "001") {
                                $searchstring = " where category_code = '005' ";
                        } else if($search1 == "005" && $search2 == "002") {
                                $searchstring = " where category_code = '005' ";
                        } else if($search1 == "006" && $search2 == "001") {
                                $searchstring = " where category_code = '006' ";
                        } else if($search1 == "006" && $search2 == "002") {
                                $searchstring = " where category_code = '006' ";
                        } else if($search1 == "007" && $search2 == "001") {
                                $searchstring = " where category_code = '007' ";
                        } else if($search1 == "007" && $search2 == "002") {
                                $searchstring = " where category_code = '007' ";
                        } else if($search1 == "008" && $search2 == "001") {
                                $searchstring = " where category_code = '008' ";
                        } else if($search1 == "008" && $search2 == "002") {
                                $searchstring = " where category_code = '008' ";
                        } else if($search1 == "009" && $search2 == "001") {
                                $searchstring = " where category_code = '009' ";
                        } else if($search1 == "009" && $search2 == "002") {
                                $searchstring = " where category_code = '009' ";
                        } else if($search1 == "010" && $search2 == "001") {
                                $searchstring = " where category_code = '010' ";
                        } else if($search1 == "010" && $search2 == "002") {
                                $searchstring = " where category_code = '010' ";
                        } else if($search1 == "011" && $search2 == "001") {
                                $searchstring = " where category_code = '011' ";
                        } else if($search1 == "011" && $search2 == "002") {
                                $searchstring = " where category_code = '011' ";
                        } else if($search1 == "000" && $search2 == "001") {
                                $searchstring = "";
                        } else if($search1 == "000" && $search2 == "002") {
                                $searchstring = "";
                        }
		}

		$sql = "select count(seq) as ucount from customer_suggest_basic".$searchstring." order by seq desc";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );
		else
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// QnA 추가및 수정
	function qna_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('customer_qna_basic', $data );
		}
		else {
			return $this->db->update('customer_qna_basic', $data, array('seq' => $seq));
		}
	}

	//	QnA 뷰내용 가져오기
	function qna_view( $seq = 0 ) {
		$sql = "select category_code, subject, contents, user_id, user_name, user_email, file_changename, file_realname, insert_date from customer_qna_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	//QnA 파일체크
	function qna_file( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from customer_qna_basic where seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );
		return $query->row_array();
	}

	// QnA 파일삭제
	function qna_filedel($seq) {
		$sql = "update customer_qna_basic set file_changename = ?, file_realname = ? where seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	// QnA 삭제
	function qna_delete( $seq ) {
		$sql = "delete from customer_qna_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		$sql2 = "delete from customer_qna_comment where bbs_seq = ?";
		$query2 = $this->db->query( $sql2, $seq );

		return	$query;
	}

	// QnA 리스트
	function qna_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "001" && $search2 == "001") {
				$searchstring = " where category_code = '001' and subject like ? ";
			} else if($search1 == "001" && $search2 == "002") {
				$searchstring = " where category_code = '001' and user_name like ? ";
			} else if($search1 == "002" && $search2 == "001") {
				$searchstring = " where category_code = '002' and subject like ? ";
			} else if($search1 == "002" && $search2 == "002") {
				$searchstring = " where category_code = '002' and user_name like ? ";
			} else if($search1 == "003" && $search2 == "001") {
				$searchstring = " where category_code = '003' and subject like ? ";
			} else if($search1 == "003" && $search2 == "002") {
				$searchstring = " where category_code = '003' and user_name like ? ";
			} else if($search1 == "004" && $search2 == "001") {
				$searchstring = " where category_code = '004' and subject like ? ";
			} else if($search1 == "004" && $search2 == "002") {
				$searchstring = " where category_code = '004' and user_name like ? ";
                        } else if($search1 == "005" && $search2 == "001") {
                                $searchstring = " where category_code = '005' and subject like ? ";
                        } else if($search1 == "005" && $search2 == "002") {
                                $searchstring = " where category_code = '005' and user_name like ? ";
                        } else if($search1 == "006" && $search2 == "001") {
                                $searchstring = " where category_code = '006' and subject like ? ";
                        } else if($search1 == "006" && $search2 == "002") {
                                $searchstring = " where category_code = '006' and user_name like ? ";
                        } else if($search1 == "007" && $search2 == "001") {
                                $searchstring = " where category_code = '007' and subject like ? ";
                        } else if($search1 == "007" && $search2 == "002") {
                                $searchstring = " where category_code = '007' and user_name like ? ";
                        } else if($search1 == "008" && $search2 == "001") {
                                $searchstring = " where category_code = '008' and subject like ? ";
                        } else if($search1 == "008" && $search2 == "002") {
                                $searchstring = " where category_code = '008' and user_name like ? ";
                        } else if($search1 == "009" && $search2 == "001") {
                                $searchstring = " where category_code = '009' and subject like ? ";
                        } else if($search1 == "009" && $search2 == "002") {
                                $searchstring = " where category_code = '009' and user_name like ? ";
                        } else if($search1 == "010" && $search2 == "001") {
                                $searchstring = " where category_code = '010' and subject like ? ";
                        } else if($search1 == "010" && $search2 == "002") {
                                $searchstring = " where category_code = '010' and user_name like ? ";
                        } else if($search1 == "011" && $search2 == "001") {
                                $searchstring = " where category_code = '011' and subject like ? ";
                        } else if($search1 == "011" && $search2 == "002") {
                                $searchstring = " where category_code = '011' and user_name like ?";
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
                        if($search1 == "001" && $search2 == "001") {
                                $searchstring = " where category_code = '001' ";
                        } else if($search1 == "001" && $search2 == "002") {
                                $searchstring = " where category_code = '001' ";
                        } else if($search1 == "002" && $search2 == "001") {
                                $searchstring = " where category_code = '002' ";
                        } else if($search1 == "002" && $search2 == "002") {
                                $searchstring = " where category_code = '002' ";
                        } else if($search1 == "003" && $search2 == "001") {
                                $searchstring = " where category_code = '003' ";
                        } else if($search1 == "003" && $search2 == "002") {
                                $searchstring = " where category_code = '003' ";
                        } else if($search1 == "004" && $search2 == "001") {
                                $searchstring = " where category_code = '004' ";
                        } else if($search1 == "004" && $search2 == "002") {
                                $searchstring = " where category_code = '004' ";
                        } else if($search1 == "005" && $search2 == "001") {
                                $searchstring = " where category_code = '005' ";
                        } else if($search1 == "005" && $search2 == "002") {
                                $searchstring = " where category_code = '005' ";
                        } else if($search1 == "006" && $search2 == "001") {
                                $searchstring = " where category_code = '006' ";
                        } else if($search1 == "006" && $search2 == "002") {
                                $searchstring = " where category_code = '006' ";
                        } else if($search1 == "007" && $search2 == "001") {
                                $searchstring = " where category_code = '007' ";
                        } else if($search1 == "007" && $search2 == "002") {
                                $searchstring = " where category_code = '007' ";
                        } else if($search1 == "008" && $search2 == "001") {
                                $searchstring = " where category_code = '008' ";
                        } else if($search1 == "008" && $search2 == "002") {
                                $searchstring = " where category_code = '008' ";
                        } else if($search1 == "009" && $search2 == "001") {
                                $searchstring = " where category_code = '009' ";
                        } else if($search1 == "009" && $search2 == "002") {
                                $searchstring = " where category_code = '009' ";
                        } else if($search1 == "010" && $search2 == "001") {
                                $searchstring = " where category_code = '010' ";
                        } else if($search1 == "010" && $search2 == "002") {
                                $searchstring = " where category_code = '010' ";
                        } else if($search1 == "011" && $search2 == "001") {
                                $searchstring = " where category_code = '011' ";
                        } else if($search1 == "011" && $search2 == "002") {
                                $searchstring = " where category_code = '011' ";
                        } else if($search1 == "000" && $search2 == "001") {
                                $searchstring = "";
                        } else if($search1 == "000" && $search2 == "002") {
                                $searchstring = "";
                        }
		}

		$sql = "select seq, category_code, subject, user_id, user_name, file_changename, cnum, insert_date from customer_qna_basic".$searchstring." order by seq desc";
		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
		else
			$query = $this->db->query( $sql, array( $start_limit, $offset ) );

		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

	//QnA 리스트개수
	function qna_list_count($searchkeyword, $search1, $search2) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "001" && $search2 == "001") {
				$searchstring = " where category_code = '001' and subject like ? ";
			} else if($search1 == "001" && $search2 == "002") {
				$searchstring = " where category_code = '001' and user_name like ? ";
			} else if($search1 == "002" && $search2 == "001") {
				$searchstring = " where category_code = '002' and subject like ? ";
			} else if($search1 == "002" && $search2 == "002") {
				$searchstring = " where category_code = '002' and user_name like ? ";
			} else if($search1 == "003" && $search2 == "001") {
				$searchstring = " where category_code = '003' and subject like ? ";
			} else if($search1 == "003" && $search2 == "002") {
				$searchstring = " where category_code = '003' and user_name like ? ";
			} else if($search1 == "004" && $search2 == "001") {
				$searchstring = " where category_code = '004' and subject like ? ";
			} else if($search1 == "004" && $search2 == "002") {
				$searchstring = " where category_code = '004' and user_name like ? ";
                        } else if($search1 == "005" && $search2 == "001") {
                                $searchstring = " where category_code = '005' and subject like ? ";
                        } else if($search1 == "005" && $search2 == "002") {
                                $searchstring = " where category_code = '005' and user_name like ? ";
                        } else if($search1 == "006" && $search2 == "001") {
                                $searchstring = " where category_code = '006' and subject like ? ";
                        } else if($search1 == "006" && $search2 == "002") {
                                $searchstring = " where category_code = '006' and user_name like ? ";
                        } else if($search1 == "007" && $search2 == "001") {
                                $searchstring = " where category_code = '007' and subject like ? ";
                        } else if($search1 == "007" && $search2 == "002") {
                                $searchstring = " where category_code = '007' and user_name like ? ";
                        } else if($search1 == "008" && $search2 == "001") {
                                $searchstring = " where category_code = '008' and subject like ? ";
                        } else if($search1 == "008" && $search2 == "002") {
                                $searchstring = " where category_code = '008' and user_name like ? ";
                        } else if($search1 == "009" && $search2 == "001") {
                                $searchstring = " where category_code = '009' and subject like ? ";
                        } else if($search1 == "009" && $search2 == "002") {
                                $searchstring = " where category_code = '009' and user_name like ? ";
                        } else if($search1 == "010" && $search2 == "001") {
                                $searchstring = " where category_code = '010' and subject like ? ";
                        } else if($search1 == "010" && $search2 == "002") {
                                $searchstring = " where category_code = '010' and user_name like ? ";
                        } else if($search1 == "011" && $search2 == "001") {
                                $searchstring = " where category_code = '011' and subject like ? ";
                        } else if($search1 == "011" && $search2 == "002") {
                                $searchstring = " where category_code = '011' and user_name like ?";
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
                        if($search1 == "001" && $search2 == "001") {
                                $searchstring = " where category_code = '001' ";
                        } else if($search1 == "001" && $search2 == "002") {
                                $searchstring = " where category_code = '001' ";
                        } else if($search1 == "002" && $search2 == "001") {
                                $searchstring = " where category_code = '002' ";
                        } else if($search1 == "002" && $search2 == "002") {
                                $searchstring = " where category_code = '002' ";
                        } else if($search1 == "003" && $search2 == "001") {
                                $searchstring = " where category_code = '003' ";
                        } else if($search1 == "003" && $search2 == "002") {
                                $searchstring = " where category_code = '003' ";
                        } else if($search1 == "004" && $search2 == "001") {
                                $searchstring = " where category_code = '004' ";
                        } else if($search1 == "004" && $search2 == "002") {
                                $searchstring = " where category_code = '004' ";
                        } else if($search1 == "005" && $search2 == "001") {
                                $searchstring = " where category_code = '005' ";
                        } else if($search1 == "005" && $search2 == "002") {
                                $searchstring = " where category_code = '005' ";
                        } else if($search1 == "006" && $search2 == "001") {
                                $searchstring = " where category_code = '006' ";
                        } else if($search1 == "006" && $search2 == "002") {
                                $searchstring = " where category_code = '006' ";
                        } else if($search1 == "007" && $search2 == "001") {
                                $searchstring = " where category_code = '007' ";
                        } else if($search1 == "007" && $search2 == "002") {
                                $searchstring = " where category_code = '007' ";
                        } else if($search1 == "008" && $search2 == "001") {
                                $searchstring = " where category_code = '008' ";
                        } else if($search1 == "008" && $search2 == "002") {
                                $searchstring = " where category_code = '008' ";
                        } else if($search1 == "009" && $search2 == "001") {
                                $searchstring = " where category_code = '009' ";
                        } else if($search1 == "009" && $search2 == "002") {
                                $searchstring = " where category_code = '009' ";
                        } else if($search1 == "010" && $search2 == "001") {
                                $searchstring = " where category_code = '010' ";
                        } else if($search1 == "010" && $search2 == "002") {
                                $searchstring = " where category_code = '010' ";
                        } else if($search1 == "011" && $search2 == "001") {
                                $searchstring = " where category_code = '011' ";
                        } else if($search1 == "011" && $search2 == "002") {
                                $searchstring = " where category_code = '011' ";
                        } else if($search1 == "000" && $search2 == "001") {
                                $searchstring = "";
                        } else if($search1 == "000" && $search2 == "002") {
                                $searchstring = "";
                        }
		}

		$sql = "select count(seq) as ucount from customer_qna_basic".$searchstring." order by seq desc";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );
		else
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// QnA 코멘트 추가
	function qna_comment_insert( $data ) {
		return $this->db->insert('customer_qna_comment', $data );
	}

	// QnA 코멘트에 글쓴이 E-mail 정보 보내기  김수성 수정 -161228
	function qna_get_email($seq){
			$sql = "select subject, user_email from customer_qna_basic where seq = '".$seq."'";
			$query = $this->db->query( $sql );
			return $query->result_array();
	}

	// QnA 코멘트 등록시 본문 카운트 증가
	function qna_cnum_update( $seq = 0) {
		$sql = "update customer_qna_basic set cnum = cnum + 1 where seq = ?";
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	// QnA 코멘트 리스트
	function qna_comment_list($seq) {
		$sql = "select seq, bbs_seq, user_id, user_name, contents, insert_date from customer_qna_comment where bbs_seq = ? order by seq desc";
		$query = $this->db->query( $sql, $seq );

		return $query->result_array();
	}

	// QnA 코멘트 삭제
	function qna_comment_delete( $seq, $cseq ) {
		$sql = "delete from customer_qna_comment where seq = ? and bbs_seq = ?";
		$query = $this->db->query( $sql, array( $cseq, $seq ) );

		return	$query;
	}

	// QnA 코멘트 삭제시 본문 카운트 감소
	function qna_cnum_update2( $seq = 0) {
		$sql = "update customer_qna_basic set cnum = cnum - 1 where seq = ?";
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	// 교육&행사 추가및 수정
	function eduevent_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('customer_eduevent_basic', $data );
		}
		else {
			return $this->db->update('customer_eduevent_basic', $data, array('seq' => $seq));
		}
	}

	//	교육&행사 뷰내용 가져오기
	function eduevent_view( $seq = 0 ) {
		$sql = "select category_code, subject, contents, user_id, user_name, file_changename, file_realname, insert_date from customer_eduevent_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	//교육&행사 파일체크
	function eduevent_file( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from customer_eduevent_basic where seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );
		return $query->row_array();
	}

	// 교육&행사 파일삭제
	function eduevent_filedel($seq) {
		$sql = "update customer_eduevent_basic set file_changename = ?, file_realname = ? where seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	// 교육&행사 삭제
	function eduevent_delete( $seq ) {
		$sql = "delete from customer_eduevent_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		$sql2 = "delete from customer_eduevent_comment where bbs_seq = ?";
		$query2 = $this->db->query( $sql2, $seq );

		return	$query;
	}

	// 교육&행사 리스트
	function eduevent_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "001" && $search2 == "001") {
				$searchstring = " where category_code = '001' and subject like ? ";
			} else if($search1 == "001" && $search2 == "002") {
				$searchstring = " where category_code = '001' and user_name like ? ";
			} else if($search1 == "002" && $search2 == "001") {
				$searchstring = " where category_code = '002' and subject like ? ";
			} else if($search1 == "002" && $search2 == "002") {
				$searchstring = " where category_code = '002' and user_name like ? ";
			} else if($search1 == "003" && $search2 == "001") {
				$searchstring = " where category_code = '003' and subject like ? ";
			} else if($search1 == "003" && $search2 == "002") {
				$searchstring = " where category_code = '003' and user_name like ? ";
			} else if($search1 == "004" && $search2 == "001") {
				$searchstring = " where category_code = '004' and subject like ? ";
			} else if($search1 == "004" && $search2 == "002") {
				$searchstring = " where category_code = '004' and user_name like ? ";
                        } else if($search1 == "005" && $search2 == "001") {
                                $searchstring = " where category_code = '005' and subject like ? ";
                        } else if($search1 == "005" && $search2 == "002") {
                                $searchstring = " where category_code = '005' and user_name like ? ";
                        } else if($search1 == "006" && $search2 == "001") {
                                $searchstring = " where category_code = '006' and subject like ? ";
                        } else if($search1 == "006" && $search2 == "002") {
                                $searchstring = " where category_code = '006' and user_name like ? ";
                        } else if($search1 == "007" && $search2 == "001") {
                                $searchstring = " where category_code = '007' and subject like ? ";
                        } else if($search1 == "007" && $search2 == "002") {
                                $searchstring = " where category_code = '007' and user_name like ? ";
                        } else if($search1 == "008" && $search2 == "001") {
                                $searchstring = " where category_code = '008' and subject like ? ";
                        } else if($search1 == "008" && $search2 == "002") {
                                $searchstring = " where category_code = '008' and user_name like ? ";
                        } else if($search1 == "009" && $search2 == "001") {
                                $searchstring = " where category_code = '009' and subject like ? ";
                        } else if($search1 == "009" && $search2 == "002") {
                                $searchstring = " where category_code = '009' and user_name like ? ";
                        } else if($search1 == "010" && $search2 == "001") {
                                $searchstring = " where category_code = '010' and subject like ? ";
                        } else if($search1 == "010" && $search2 == "002") {
                                $searchstring = " where category_code = '010' and user_name like ? ";
                        } else if($search1 == "011" && $search2 == "001") {
                                $searchstring = " where category_code = '011' and subject like ? ";
                        } else if($search1 == "011" && $search2 == "002") {
                                $searchstring = " where category_code = '011' and user_name like ?";
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
                        if($search1 == "001" && $search2 == "001") {
                                $searchstring = " where category_code = '001' ";
                        } else if($search1 == "001" && $search2 == "002") {
                                $searchstring = " where category_code = '001' ";
                        } else if($search1 == "002" && $search2 == "001") {
                                $searchstring = " where category_code = '002' ";
                        } else if($search1 == "002" && $search2 == "002") {
                                $searchstring = " where category_code = '002' ";
                        } else if($search1 == "003" && $search2 == "001") {
                                $searchstring = " where category_code = '003' ";
                        } else if($search1 == "003" && $search2 == "002") {
                                $searchstring = " where category_code = '003' ";
                        } else if($search1 == "004" && $search2 == "001") {
                                $searchstring = " where category_code = '004' ";
                        } else if($search1 == "004" && $search2 == "002") {
                                $searchstring = " where category_code = '004' ";
                        } else if($search1 == "005" && $search2 == "001") {
                                $searchstring = " where category_code = '005' ";
                        } else if($search1 == "005" && $search2 == "002") {
                                $searchstring = " where category_code = '005' ";
                        } else if($search1 == "006" && $search2 == "001") {
                                $searchstring = " where category_code = '006' ";
                        } else if($search1 == "006" && $search2 == "002") {
                                $searchstring = " where category_code = '006' ";
                        } else if($search1 == "007" && $search2 == "001") {
                                $searchstring = " where category_code = '007' ";
                        } else if($search1 == "007" && $search2 == "002") {
                                $searchstring = " where category_code = '007' ";
                        } else if($search1 == "008" && $search2 == "001") {
                                $searchstring = " where category_code = '008' ";
                        } else if($search1 == "008" && $search2 == "002") {
                                $searchstring = " where category_code = '008' ";
                        } else if($search1 == "009" && $search2 == "001") {
                                $searchstring = " where category_code = '009' ";
                        } else if($search1 == "009" && $search2 == "002") {
                                $searchstring = " where category_code = '009' ";
                        } else if($search1 == "010" && $search2 == "001") {
                                $searchstring = " where category_code = '010' ";
                        } else if($search1 == "010" && $search2 == "002") {
                                $searchstring = " where category_code = '010' ";
                        } else if($search1 == "011" && $search2 == "001") {
                                $searchstring = " where category_code = '011' ";
                        } else if($search1 == "011" && $search2 == "002") {
                                $searchstring = " where category_code = '011' ";
                        } else if($search1 == "000" && $search2 == "001") {
                                $searchstring = "";
                        } else if($search1 == "000" && $search2 == "002") {
                                $searchstring = "";
                        }
		}

		$sql = "select seq, category_code, subject, user_id, user_name, file_changename, cnum, insert_date from customer_eduevent_basic".$searchstring." order by seq desc";
		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
		else
			$query = $this->db->query( $sql, array( $start_limit, $offset ) );

		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

	//교육&행사 리스트개수
	function eduevent_list_count($searchkeyword, $search1, $search2) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "001" && $search2 == "001") {
				$searchstring = " where category_code = '001' and subject like ? ";
			} else if($search1 == "001" && $search2 == "002") {
				$searchstring = " where category_code = '001' and user_name like ? ";
			} else if($search1 == "002" && $search2 == "001") {
				$searchstring = " where category_code = '002' and subject like ? ";
			} else if($search1 == "002" && $search2 == "002") {
				$searchstring = " where category_code = '002' and user_name like ? ";
			} else if($search1 == "003" && $search2 == "001") {
				$searchstring = " where category_code = '003' and subject like ? ";
			} else if($search1 == "003" && $search2 == "002") {
				$searchstring = " where category_code = '003' and user_name like ? ";
			} else if($search1 == "004" && $search2 == "001") {
				$searchstring = " where category_code = '004' and subject like ? ";
			} else if($search1 == "004" && $search2 == "002") {
				$searchstring = " where category_code = '004' and user_name like ? ";
                        } else if($search1 == "005" && $search2 == "001") {
                                $searchstring = " where category_code = '005' and subject like ? ";
                        } else if($search1 == "005" && $search2 == "002") {
                                $searchstring = " where category_code = '005' and user_name like ? ";
                        } else if($search1 == "006" && $search2 == "001") {
                                $searchstring = " where category_code = '006' and subject like ? ";
                        } else if($search1 == "006" && $search2 == "002") {
                                $searchstring = " where category_code = '006' and user_name like ? ";
                        } else if($search1 == "007" && $search2 == "001") {
                                $searchstring = " where category_code = '007' and subject like ? ";
                        } else if($search1 == "007" && $search2 == "002") {
                                $searchstring = " where category_code = '007' and user_name like ? ";
                        } else if($search1 == "008" && $search2 == "001") {
                                $searchstring = " where category_code = '008' and subject like ? ";
                        } else if($search1 == "008" && $search2 == "002") {
                                $searchstring = " where category_code = '008' and user_name like ? ";
                        } else if($search1 == "009" && $search2 == "001") {
                                $searchstring = " where category_code = '009' and subject like ? ";
                        } else if($search1 == "009" && $search2 == "002") {
                                $searchstring = " where category_code = '009' and user_name like ? ";
                        } else if($search1 == "010" && $search2 == "001") {
                                $searchstring = " where category_code = '010' and subject like ? ";
                        } else if($search1 == "010" && $search2 == "002") {
                                $searchstring = " where category_code = '010' and user_name like ? ";
                        } else if($search1 == "011" && $search2 == "001") {
                                $searchstring = " where category_code = '011' and subject like ? ";
                        } else if($search1 == "011" && $search2 == "002") {
                                $searchstring = " where category_code = '011' and user_name like ?";
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
                        if($search1 == "001" && $search2 == "001") {
                                $searchstring = " where category_code = '001' ";
                        } else if($search1 == "001" && $search2 == "002") {
                                $searchstring = " where category_code = '001' ";
                        } else if($search1 == "002" && $search2 == "001") {
                                $searchstring = " where category_code = '002' ";
                        } else if($search1 == "002" && $search2 == "002") {
                                $searchstring = " where category_code = '002' ";
                        } else if($search1 == "003" && $search2 == "001") {
                                $searchstring = " where category_code = '003' ";
                        } else if($search1 == "003" && $search2 == "002") {
                                $searchstring = " where category_code = '003' ";
                        } else if($search1 == "004" && $search2 == "001") {
                                $searchstring = " where category_code = '004' ";
                        } else if($search1 == "004" && $search2 == "002") {
                                $searchstring = " where category_code = '004' ";
                        } else if($search1 == "005" && $search2 == "001") {
                                $searchstring = " where category_code = '005' ";
                        } else if($search1 == "005" && $search2 == "002") {
                                $searchstring = " where category_code = '005' ";
                        } else if($search1 == "006" && $search2 == "001") {
                                $searchstring = " where category_code = '006' ";
                        } else if($search1 == "006" && $search2 == "002") {
                                $searchstring = " where category_code = '006' ";
                        } else if($search1 == "007" && $search2 == "001") {
                                $searchstring = " where category_code = '007' ";
                        } else if($search1 == "007" && $search2 == "002") {
                                $searchstring = " where category_code = '007' ";
                        } else if($search1 == "008" && $search2 == "001") {
                                $searchstring = " where category_code = '008' ";
                        } else if($search1 == "008" && $search2 == "002") {
                                $searchstring = " where category_code = '008' ";
                        } else if($search1 == "009" && $search2 == "001") {
                                $searchstring = " where category_code = '009' ";
                        } else if($search1 == "009" && $search2 == "002") {
                                $searchstring = " where category_code = '009' ";
                        } else if($search1 == "010" && $search2 == "001") {
                                $searchstring = " where category_code = '010' ";
                        } else if($search1 == "010" && $search2 == "002") {
                                $searchstring = " where category_code = '010' ";
                        } else if($search1 == "011" && $search2 == "001") {
                                $searchstring = " where category_code = '011' ";
                        } else if($search1 == "011" && $search2 == "002") {
                                $searchstring = " where category_code = '011' ";

                        } else if($search1 == "000" && $search2 == "001") {
                                $searchstring = "";
                        } else if($search1 == "000" && $search2 == "002") {
                                $searchstring = "";
                        }
		}

		$sql = "select count(seq) as ucount from customer_eduevent_basic".$searchstring." order by seq desc";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );
		else
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// 교육&행사 코멘트 추가
	function eduevent_comment_insert( $data ) {
		return $this->db->insert('customer_eduevent_comment', $data );
	}

	// 교육&행사 코멘트 등록시 본문 카운트 증가
	function eduevent_cnum_update( $seq = 0) {
		$sql = "update customer_eduevent_basic set cnum = cnum + 1 where seq = ?";
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	// 교육&행사 코멘트 리스트
	function eduevent_comment_list($seq) {
		$sql = "select seq, bbs_seq, user_id, user_name, contents, insert_date from customer_eduevent_comment where bbs_seq = ? order by seq desc";
		$query = $this->db->query( $sql, $seq );

		return $query->result_array();
	}

	// 교육&행사 코멘트 삭제
	function eduevent_comment_delete( $seq, $cseq ) {
		$sql = "delete from customer_eduevent_comment where seq = ? and bbs_seq = ?";
		$query = $this->db->query( $sql, array( $cseq, $seq ) );

		return	$query;
	}

	// 교육&행사 코멘트 삭제시 본문 카운트 감소
	function eduevent_cnum_update2( $seq = 0) {
		$sql = "update customer_eduevent_basic set cnum = cnum - 1 where seq = ?";
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

        //기술지원 보고서 파일체크
        function tech_doc_file( $seq, $filelcname ) {

$sql = "select seq, file_realname, file_changename from tech_doc_basic where seq = ? and file_changename = '?'";
                $query = $this->db->query( $sql, array($seq, $filelcname) );
                return $sql;
                //return $query->row_array();
        }

        // 기술지원 보고서 파일삭제
        function tech_doc_filedel($seq) {
                $sql = "update customer_eduevent_basic set file_changename = ?, file_realname = ? where seq = ?";
                $result = $this->db->query($sql, array(NULL,NULL,$seq));
                return $result;

        }



		public function STC_tech_doc(){
/*
1. b_no : 번호
2. customer : 고객사
3. produce : 제품명
4. work_name : 작업명
5. writer : 작성자
6. total_time : 투입시간
7. start_time : 시작시간
8. end_time : 종료시간
9. enginer : 담당 엔지니어
10. handle : 지원 방법
11. subject : 주제
12. work_process : 작업내용
13. result : 지원 결과

*/
/*추가하는 값 validatioon 체크*/
/*	$this->load->library('form_validation');
	$this->form_validation->set_rules('customer','고객사','required');
	$this->form_validation->set_rules('produce','제품명','required');
	$this->form_validation->set_rules('work_name','작업명','required');
	$this->form_validation->set_rules('writer','작성자','required');
	$this->form_validation->set_rules('total_time','투입시간','required');
	$this->form_validation->set_rules('start_time','시작시간','required');
	$this->form_validation->set_rules('end_time','종료시간','required');
	$this->form_validation->set_rules('engihaner','담당SE','required');
	$this->form_validation->set_rules('handle','지원방법','required');
	$this->form_validation->set_rules('subject','주제','required');
	$this->form_validation->set_rules('work_process','작업내용','required');
	$this->form_validation->set_rules('result','지원결과','required');
*/
	$customer = $_POST['customer'];
	$produce = $_POST['produce'];
	$work_name = $_POST['work_name'];
	$writer = $_POST['writer'];
	$total_time = $_POST['total_time'];
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	$enginer = $_POST['enginer'];
	$handle = $_POST['handle'];
	$subject = $_POST['subject'];
	$result = $_POST['result'];

//{[시간:분-시간:분]} 형식으로 생성
	for($i=0;$i<count($_POST['work_time_s']);$i++){
		$work_time ="{[";		$work_time .=$_POST['work_time_s'][$i];
		$work_time .="-";
		$work_time .= $_POST['work_time_e'][$i];
		$work_time .= "]}";		$work_process =$work_time;
		$work_process .=$_POST['work_text'][$i];
		}

//echo $work_process;
echo "test";
//		$this->db->query('insert into tech_doc_basic values(NULL, "' . $customer . '", "' . $produce . '", "' . $work_name . '" , "' . $writer . '", "' . $total_time . '", "' . $start_time . '", "' . $end_time . '", "' . $enginer . '", "' . $handle . '", "' . $subject . '", "' . $work_process . '", "' . $result . '")')->result();
//echo 'insert into tech_board values(NULL, "' . $customer . '", "' . $produce . '", "' . $work_name . '" , "' . $writer . '", "' . $total_time . '", "' . $start_time . '", "' . $end_time . '", "' . $enginer . '", "' . $handle . '", "' . $subject . '", "' . $work_process . '", "' . $result . '")';



	}

}
?>
