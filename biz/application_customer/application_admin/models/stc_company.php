<?php
header("Content-type: text/html; charset=utf-8");

class STC_Company extends CI_Model {

	function __construct() {

		parent::__construct();
//		$this->user_id = $this->phpsession->get( 'id', 'stc' );
	}

	// 사업자등록번호 추가및 수정
	function companynum_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('company_number', $data );
		}
		else {
			return $this->db->update('company_number', $data, array('seq' => $seq));
		}
	}
	
	//	사업자등록번호 뷰내용 가져오기
	function companynum_view( $seq = 0 ) {
		$sql = "select seq, company_name, company_num, insert_date from company_number where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	// 사업자등록번호 삭제
	function companynum_delete( $seq ) {
		$sql = "delete from company_number where seq = ?";		
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	// 사업자등록번호 리스트
	function companynum_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
		$sql = "select seq, company_name, company_num, insert_date from company_number order by seq desc";
		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );	
		else 
			$query = $this->db->query( $sql, array( $start_limit, $offset ) );

		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}
	
	//사업자등록번호 리스트개수
	function companynum_list_count($searchkeyword, $search1, $search2) {
		$sql = "select count(seq) as ucount from company_number order by seq desc";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );	
		else 
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// 제품명 추가및 수정
	function product_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('product', $data );
		}
		else {
			return $this->db->update('product', $data, array('seq' => $seq));
		}
	}
	
	//	제품명 뷰내용 가져오기
	function product_view( $seq = 0 ) {
		$sql = "select * from product where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	// 제품명 삭제
	function product_delete( $seq ) {
		$sql = "delete from product where seq = ?";		
		$query = $this->db->query( $sql, $seq );
		
		// 삭제시 포캐스팅 제품명의 데이터도 삭제한다. 
		$sql2 = "delete from sales_forcasting_product where product_code = ?";		
		$query2 = $this->db->query( $sql2, $seq );

		return	$query2;
	}

	// 제품명 리스트
	function product_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";
		
		if($searchkeyword != "") {
			if($search2 == "001") {
				$searchstring = " where product_name like ? ";
			} else if($search2 == "002") {
				$searchstring = " where product_company like ? ";
			} else if($search2 == "003") {
				$searchstring = " where product_item like ? ";
			}
		} else {
			$searchstring = "";
		}
		
		$sql = "select * from product".$searchstring." order by seq desc";
		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );	
		else 
			$query = $this->db->query( $sql, array( $start_limit, $offset ) );

		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}
	
	//제품명 리스트개수
	function product_list_count($searchkeyword, $search1, $search2) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search2 == "001") {
				$searchstring = " where product_name like ? ";
			} else if($search2 == "002") {
				$searchstring = " where product_company like ? ";
			} else if($search2 == "003") {
				$searchstring = " where product_item like ? ";
			}
		} else {
			$searchstring = "";
		}
		
		$sql = "select count(seq) as ucount from product".$searchstring." order by seq desc";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );	
		else 
			$query = $this->db->query( $sql );
		return $query->row();
	}

}
?>