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
                        } else if($search1 == "000" && $search2 == "001") {
                                $searchstring = "";
                        } else if($search1 == "000" && $search2 == "002") {
                                $searchstring = "";
                        }
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
                        } else if($search1 == "000" && $search2 == "001") {
                                $searchstring = "";
                        } else if($search1 == "000" && $search2 == "002") {
                                $searchstring = "";
                        }
		}

		$sql = "select count(seq) as ucount from sales_notice_basic".$searchstring." order by seq desc";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );
		else
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// 공지사항 최근글표시
	function notice_new() {
		$sql = "select seq, update_date from sales_notice_basic order by seq desc";
		$query = $this->db->query( $sql );
		return $query->result_array();
	}

}
?>
