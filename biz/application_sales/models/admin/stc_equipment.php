<?php
header("Content-type: text/html; charset=utf-8");

class STC_Equipment extends CI_Model {

	function __construct() {

		parent::__construct();
//		$this->user_id = $this->phpsession->get( 'id', 'stc' );
	}

	function make_search_string($searchkeyword, $search1, $search2) {
		$where = '';
		// 1일땐 검색input창이 보여야해
		if($search1 == '1') {
			if ($searchkeyword != '') {
				$where = "AND number like '%{$searchkeyword}%'";
			} else {
				$where = '';
			}
		// 2일땐 selectbox라서 selectbox가 보여야해
		} else if ($search1 == '2') {
			$where = "AND sell_yn = '{$search2}'";
		}

		return $where;
	}

  // 차량 리스트
  function car_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
		$where = $this->make_search_string($searchkeyword, $search1, $search2);

    $sql = "select * from admin_car where 1=1 {$where} order by seq desc";
    if  ( $offset <> 0 )
    $sql = $sql." limit ?, ?";

    $query = $this->db->query( $sql, array( $start_limit, $offset ) );

    return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
  }

  // 차량 리스트개수
  function car_list_count($searchkeyword, $search1, $search2) {
		$where = $this->make_search_string($searchkeyword, $search1, $search2);

    $sql = "select count(seq) as ucount from admin_car where 1=1 {$where} order by seq desc";

    $query = $this->db->query( $sql );
    return $query->row();
  }

  // 차량 추가및 수정
  function car_insert( $data, $mode = 0 , $seq = 0) {
    if( $mode == 0 ) {
      return $this->db->insert('admin_car', $data );
    }
    else {
      return $this->db->update('admin_car', $data, array('seq' => $seq));
    }
  }

  //	차량 뷰내용 가져오기
  function car_view( $seq = 0 ) {
    $sql = "select * from admin_car where seq = ?";
    $query = $this->db->query( $sql, $seq );

    if ($query->num_rows() <= 0) {
      return false;
    } else {
      return $query->row_array() ;
    }
  }

  // 차량 삭제
  function car_delete( $seq ) {
    $sql = "delete from admin_car where seq = ?";
    $query = $this->db->query( $sql, $seq );

    return	$query;
  }

  // 회의실 리스트
  function meeting_room_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
    $sql = "select * from meeting_room order by seq desc";
    if  ( $offset <> 0 )
    $sql = $sql." limit ?, ?";

    if  ( $searchkeyword != "" )
    $query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
    else
    $query = $this->db->query( $sql, array( $start_limit, $offset ) );

    return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
  }

  // 회의실 리스트개수
  function meeting_room_list_count($searchkeyword, $search1, $search2) {
    $sql = "select count(seq) as ucount from meeting_room order by seq desc";

    if  ( $searchkeyword != "" )
    $query = $this->db->query( $sql, $keyword  );
    else
    $query = $this->db->query( $sql );
    return $query->row();
  }

  // 회의실 추가및 수정
  function meeting_room_insert( $data, $mode = 0 , $seq = 0) {
    if( $mode == 0 ) {
      return $this->db->insert('meeting_room', $data );
    }
    else {
      return $this->db->update('meeting_room', $data, array('seq' => $seq));
    }
  }

  //	회의실 뷰내용 가져오기
  function meeting_room_view( $seq = 0 ) {
    $sql = "select * from meeting_room where seq = ?";
    $query = $this->db->query( $sql, $seq );

    if ($query->num_rows() <= 0) {
      return false;
    } else {
      return $query->row_array() ;
    }
  }

  // 회의실 삭제
  function meeting_room_delete( $seq ) {
    $sql = "delete from meeting_room where seq = ?";
    $query = $this->db->query( $sql, $seq );

    return	$query;
  }


}
?>
