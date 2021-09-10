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
			return $this->db->insert('sales_notice_basic', $data );
		}
		else {
			return $this->db->update('sales_notice_basic', $data, array('seq' => $seq));
		}
	}
	
	//	공지사항 뷰내용 가져오기
	function notice_view( $seq = 0 ) {
		$sql = "select category_code, subject, contents, user_id, user_name, file_changename, file_realname, update_date from sales_notice_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}
	
	//공지사항 파일체크
	function notice_file( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from sales_notice_basic where seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );		
		return $query->row_array();
	}
	
	// 공지사항 파일삭제
	function notice_filedel($seq) {
		$sql = "update sales_notice_basic set file_changename = ?, file_realname = ? where seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	// 공지사항 삭제
	function notice_delete( $seq ) {
		$sql = "delete from sales_notice_basic where seq = ?";		
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
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
		}
		
		$sql = "select seq, category_code, subject, user_id, user_name, file_changename, update_date from sales_notice_basic".$searchstring." order by seq desc";
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
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
		}
		
		$sql = "select count(seq) as ucount from sales_notice_basic".$searchstring." order by seq desc";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );	
		else 
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// 매뉴얼 추가및 수정
	function manual_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('sales_manual_basic', $data );
		}
		else {
			return $this->db->update('sales_manual_basic', $data, array('seq' => $seq));
		}
	}
	
	//	매뉴얼 뷰내용 가져오기
	function manual_view( $seq = 0 ) {
		$sql = "select category_code, subject, contents, user_id, user_name, file_changename, file_realname, update_date from sales_manual_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}
	
	//매뉴얼 파일체크
	function manual_file( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from sales_manual_basic where seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );		
		return $query->row_array();
	}
	
	// 매뉴얼 파일삭제
	function manual_filedel($seq) {
		$sql = "update sales_manual_basic set file_changename = ?, file_realname = ? where seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	// 매뉴얼 삭제
	function manual_delete( $seq ) {
		$sql = "delete from sales_manual_basic where seq = ?";		
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	// 매뉴얼 리스트
	function manual_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
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
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
		}
		
		$sql = "select seq, category_code, subject, user_id, user_name, file_changename, update_date from sales_manual_basic".$searchstring." order by seq desc";
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
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
		}
		
		$sql = "select count(seq) as ucount from sales_manual_basic".$searchstring." order by seq desc";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );	
		else 
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// 교육자료 추가및 수정
	function edudata_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('sales_manageredu_basic', $data );
		}
		else {
			return $this->db->update('sales_manageredu_basic', $data, array('seq' => $seq));
		}
	}
	
	//	교육자료 뷰내용 가져오기
	function edudata_view( $seq = 0 ) {
		$sql = "select category_code, subject, contents, user_id, user_name, file_changename, file_realname, update_date from sales_manageredu_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}
	
	//교육자료 파일체크
	function edudata_file( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from sales_manageredu_basic where seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );		
		return $query->row_array();
	}
	
	// 교육자료 파일삭제
	function edudata_filedel($seq) {
		$sql = "update sales_manageredu_basic set file_changename = ?, file_realname = ? where seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	// 교육자료 삭제
	function edudata_delete( $seq ) {
		$sql = "delete from sales_manageredu_basic where seq = ?";		
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	// 교육자료 리스트
	function edudata_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
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
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
		}
		
		$sql = "select seq, category_code, subject, user_id, user_name, file_changename, update_date from sales_manageredu_basic".$searchstring." order by seq desc";
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
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
		}
		
		$sql = "select count(seq) as ucount from sales_manageredu_basic".$searchstring." order by seq desc";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );	
		else 
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// FAQ 추가및 수정
	function faq_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('sales_faq_basic', $data );
		}
		else {
			return $this->db->update('sales_faq_basic', $data, array('seq' => $seq));
		}
	}
	
	//	FAQ 뷰내용 가져오기
	function faq_view( $seq = 0 ) {
		$sql = "select category_code, subject, contents, user_id, user_name, file_changename, file_realname, update_date from sales_faq_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}
	
	//FAQ 파일체크
	function faq_file( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from sales_faq_basic where seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );		
		return $query->row_array();
	}
	
	// FAQ 파일삭제
	function faq_filedel($seq) {
		$sql = "update sales_faq_basic set file_changename = ?, file_realname = ? where seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	// FAQ 삭제
	function faq_delete( $seq ) {
		$sql = "delete from sales_faq_basic where seq = ?";		
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	// FAQ 리스트
	function faq_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
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
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
		}
		
		$sql = "select seq, category_code, subject, user_id, user_name, file_changename, update_date from sales_faq_basic".$searchstring." order by seq desc";
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
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
		}
		
		$sql = "select count(seq) as ucount from sales_faq_basic".$searchstring." order by seq desc";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );	
		else 
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// 건의사항 추가및 수정
	function suggest_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('sales_suggest_basic', $data );
		}
		else {
			return $this->db->update('sales_suggest_basic', $data, array('seq' => $seq));
		}
	}
	
	//	건의사항 뷰내용 가져오기
	function suggest_view( $seq = 0 ) {
		$sql = "select category_code, subject, contents, user_id, user_name, file_changename, file_realname, update_date from sales_suggest_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}
	
	//건의사항 파일체크
	function suggest_file( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from sales_suggest_basic where seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );		
		return $query->row_array();
	}
	
	// 건의사항 파일삭제
	function suggest_filedel($seq) {
		$sql = "update sales_suggest_basic set file_changename = ?, file_realname = ? where seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	// 건의사항 삭제
	function suggest_delete( $seq ) {
		$sql = "delete from sales_suggest_basic where seq = ?";		
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
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
		}
		
		$sql = "select seq, category_code, subject, user_id, user_name, file_changename, update_date from sales_suggest_basic".$searchstring." order by seq desc";
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
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
		}
		
		$sql = "select count(seq) as ucount from sales_suggest_basic".$searchstring." order by seq desc";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );	
		else 
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// QnA 추가및 수정
	function qna_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('sales_qna_basic', $data );
		}
		else {
			return $this->db->update('sales_qna_basic', $data, array('seq' => $seq));
		}
	}
	
	//	QnA 뷰내용 가져오기
	function qna_view( $seq = 0 ) {
		$sql = "select category_code, subject, contents, user_id, user_name, file_changename, file_realname, update_date from sales_qna_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}
	
	//QnA 파일체크
	function qna_file( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from sales_qna_basic where seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );		
		return $query->row_array();
	}
	
	// QnA 파일삭제
	function qna_filedel($seq) {
		$sql = "update sales_qna_basic set file_changename = ?, file_realname = ? where seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	// QnA 삭제
	function qna_delete( $seq ) {
		$sql = "delete from sales_qna_basic where seq = ?";		
		$query = $this->db->query( $sql, $seq );

		$sql2 = "delete from sales_qna_comment where bbs_seq = ?";		
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
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
		}
		
		$sql = "select seq, category_code, subject, user_id, user_name, file_changename, cnum, update_date from sales_qna_basic".$searchstring." order by seq desc";
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
			} else if($search1 == "000" && $search2 == "001") {
				$searchstring = " where subject like ? ";
			} else if($search1 == "000" && $search2 == "002") {
				$searchstring = " where user_name like ? ";
			}
		} else {
			$searchstring = "";
		}
		
		$sql = "select count(seq) as ucount from sales_qna_basic".$searchstring." order by seq desc";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );	
		else 
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// QnA 코멘트 추가
	function qna_comment_insert( $data ) {
		return $this->db->insert('sales_qna_comment', $data );
	}
	
	// QnA 코멘트 등록시 본문 카운트 증가
	function qna_cnum_update( $seq = 0) {
		$sql = "update sales_qna_basic set cnum = cnum + 1 where seq = ?";		
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	// QnA 코멘트 리스트
	function qna_comment_list($seq) {
		$sql = "select seq, bbs_seq, user_id, user_name, contents, insert_date from sales_qna_comment where bbs_seq = ? order by seq desc";
		$query = $this->db->query( $sql, $seq );

		return $query->result_array();
	}
	
	// QnA 코멘트 삭제
	function qna_comment_delete( $seq, $cseq ) {
		$sql = "delete from sales_qna_comment where seq = ? and bbs_seq = ?";		
		$query = $this->db->query( $sql, array( $cseq, $seq ) );

		return	$query;
	}

	// QnA 코멘트 삭제시 본문 카운트 감소
	function qna_cnum_update2( $seq = 0) {
		$sql = "update sales_qna_basic set cnum = cnum - 1 where seq = ?";		
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}
}
?>