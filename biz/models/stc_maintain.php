<?php
header("Content-type: text/html; charset=utf-8");

class STC_Maintain extends CI_Model {

	function __construct() {

		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->lv = $this->phpsession->get( 'lv', 'stc' );
		$this->cnum = $this->phpsession->get( 'cnum', 'stc' );
	}

	// 포캐스팅 기본사항 추가및 수정
	function maintain_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			$sql = "insert into sales_maintain (customer_companyname,customer_username,customer_tel,customer_email,project_name,progress_step,cooperation_companyname,cooperation_username,cooperation_tel,cooperation_email,exception_saledate,complete_status,company_num,write_id,insert_date,update_date) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,now(),now())";

			$this->db->query($sql, array($data['customer_companyname'],$data['customer_username'],$data['customer_tel'],$data['customer_email'],$data['project_name'],$data['progress_step'],$data['cooperation_companyname'],$data['cooperation_username'],$data['cooperation_tel'],$data['cooperation_email'],$data['exception_saledate'],$data['complete_status'],$this->cnum,$data['write_id']));

			$sql2 = "select max(seq) as max_seq from sales_maintain";
			$query = $this->db->query( $sql2 );
			$mseq = $query->row()->max_seq;

			$product_array = explode("||", $data['product_array']);

			for($i=1;$i<count($product_array);$i++)
			{
				$product_list = explode("~",$product_array[$i]);

				$sql3 = "insert into sales_maintain_product (maintain_seq,product_code,product_licence,product_serial,product_state,insert_date) values(?,?,?,?,?,now())";
				$this->db->query($sql3, array($mseq,$product_list[0],$product_list[1],$product_list[2],$product_list[3]));
			}

			$main_array = explode("||", $data['main_array']);

			for($i=1;$i<count($main_array);$i++)
			{
				$main_list = explode("~",$main_array[$i]);

				$sql4 = "insert into sales_maintain_mcompany (maintain_seq,main_companyname,main_username,main_tel,main_email,insert_date) values(?,?,?,?,?,now())";
				$result = $this->db->query($sql4, array($mseq,$main_list[0],$main_list[1],$main_list[2],$main_list[3]));
			}
			return $result;
		}
		else {
			$sql = "update sales_maintain set customer_companyname=?,customer_username=?,customer_tel=?,customer_email=?,project_name=?,progress_step=?,cooperation_companyname=?,cooperation_username=?,cooperation_tel=?,cooperation_email=?,exception_saledate=?,complete_status=?,update_date=now() where seq=?";

			$this->db->query($sql, array($data['customer_companyname'],$data['customer_username'],$data['customer_tel'],$data['customer_email'],$data['project_name'],$data['progress_step'],$data['cooperation_companyname'],$data['cooperation_username'],$data['cooperation_tel'],$data['cooperation_email'],$data['exception_saledate'],$data['complete_status'],$seq));

			$sql2 = "delete from sales_maintain_product where maintain_seq=?";
			$this->db->query($sql2, $seq);

			$product_array = explode("||", $data['product_array']);

			for($i=1;$i<count($product_array);$i++)
			{
				$product_list = explode("~",$product_array[$i]);

				$sql3 = "insert into sales_maintain_product (maintain_seq,product_code,product_licence,product_serial,product_state,insert_date) values(?,?,?,?,?,now())";
				$this->db->query($sql3, array($seq,$product_list[0],$product_list[1],$product_list[2],$product_list[3]));
			}

			$sql4 = "delete from sales_maintain_mcompany where maintain_seq=?";
			$this->db->query($sql4, $seq);

			$main_array = explode("||", $data['main_array']);

			for($i=1;$i<count($main_array);$i++)
			{
				$main_list = explode("~",$main_array[$i]);

				$sql5 = "insert into sales_maintain_mcompany (maintain_seq,main_companyname,main_username,main_tel,main_email,insert_date) values(?,?,?,?,?,now())";
				$result = $this->db->query($sql5, array($seq,$main_list[0],$main_list[1],$main_list[2],$main_list[3]));
			}
			return $result;
		}
	}

	//	포캐스팅 뷰내용 가져오기(기본)
	function maintain_view( $seq = 0 ) {
		$sql = "select * from sales_maintain where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	//	포캐스팅 뷰내용 가져오기(주사업자)
	function maintain_view2( $seq = 0 ) {
		$sql = "select * from sales_maintain_mcompany where maintain_seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//	포캐스팅 뷰내용 가져오기(제품명)
	function maintain_view3( $seq = 0 ) {
		$sql = "select sp.seq, sp.product_code, sp.product_licence, sp.product_serial, sp.product_state, p.product_company, p.product_name, p.product_item from sales_maintain_product sp, product p where sp.product_code = p.seq and sp.maintain_seq = ? order by sp.seq asc, p.product_company desc";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	// 포캐스팅 삭제
	function maintain_delete( $seq ) {
		$sql = "delete from sales_maintain where seq = ?";
		$this->db->query( $sql, $seq );
		$sql2 = "delete from sales_maintain_mcompany where maintain_seq = ?";
		$this->db->query( $sql2, $seq );
		$sql3 = "delete from sales_maintain_product where maintain_seq = ?";
		$this->db->query( $sql3, $seq );
		$sql4 = "delete from sales_maintain_comment where maintain_seq = ?";
		$query = $this->db->query( $sql4, $seq );

		return	$query;
	}

	// 포캐스팅 리스트
	function maintain_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0, $cnum) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search2 == "001") {
				$searchstring = " and sf.customer_companyname like ? ";
			} else if($search2 == "002") {
				$searchstring = " and sf.project_name like ? ";
			} else if($search2 == "003") {
				$searchstring = " and p.product_company like ? ";
			} else if($search2 == "004") {
				$searchstring = " and p.product_item like ? ";
			} else if($search2 == "005") {
				$searchstring = " and p.product_name like ? ";
			} else if($search2 == "006") {
				$searchstring = " and sf.cooperation_username like ? ";
			} else if($search2 == "007") {
				$searchstring = " and sf.exception_saledate like ? ";
			}
		} else {
			$searchstring = "";
		}

		if($this->lv == 1) {
			$sql = "select sf.seq, sf.customer_companyname, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name from sales_maintain sf, (select * from sales_maintain_product group by maintain_seq) sp, product p where sf.seq = sp.maintain_seq and p.seq = sp.product_code".$searchstring." and company_num = ? order by sf.seq desc";
			if  ( $offset <> 0 )
				$sql = $sql." limit ?, ?";

			if  ( $searchkeyword != "" )
				$query = $this->db->query( $sql, array( $keyword, $cnum, $start_limit, $offset ) );
			else
				$query = $this->db->query( $sql, array( $cnum, $start_limit, $offset ) );
		} else {
			$sql = "select sf.seq, sf.customer_companyname, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name from sales_maintain sf, (select * from sales_maintain_product group by maintain_seq) sp, product p where sf.seq = sp.maintain_seq and p.seq = sp.product_code".$searchstring." order by sf.seq desc";
			if  ( $offset <> 0 )
				$sql = $sql." limit ?, ?";

			if  ( $searchkeyword != "" )
				$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
			else
				$query = $this->db->query( $sql, array( $start_limit, $offset ) );
		}

		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

	//포캐스팅 리스트개수
	function maintain_list_count($searchkeyword, $search1, $search2, $cnum) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search2 == "001") {
				$searchstring = " and sf.customer_companyname like ? ";
			} else if($search2 == "002") {
				$searchstring = " and sf.project_name like ? ";
			} else if($search2 == "003") {
				$searchstring = " and p.product_company like ? ";
			} else if($search2 == "004") {
				$searchstring = " and p.product_item like ? ";
			} else if($search2 == "005") {
				$searchstring = " and p.product_name like ? ";
			} else if($search2 == "006") {
				$searchstring = " and sf.cooperation_username like ? ";
			} else if($search2 == "007") {
				$searchstring = " and sf.exception_saledate like ? ";
			}
		} else {
			$searchstring = "";
		}

		if($this->lv == 1) {
			$sql = "select count(sf.seq) as ucount from sales_maintain sf, (select * from sales_maintain_product group by maintain_seq) sp, product p where sf.seq = sp.maintain_seq and p.seq = sp.product_code".$searchstring." and company_num = ? order by sf.seq desc";

			if  ( $searchkeyword != "" )
				$query = $this->db->query( $sql, array($keyword, $cnum));
			else
				$query = $this->db->query( $sql, $cnum );
		} else {
			$sql = "select count(sf.seq) as ucount from sales_maintain sf, (select * from sales_maintain_product group by maintain_seq) sp, product p where sf.seq = sp.maintain_seq and p.seq = sp.product_code".$searchstring." order by sf.seq desc";

			if  ( $searchkeyword != "" )
				$query = $this->db->query( $sql, $keyword);
			else
				$query = $this->db->query( $sql );
		}
		return $query->row();
	}

	// 포캐스팅 코멘트 추가
	function maintain_comment_insert( $data ) {
		return $this->db->insert('sales_maintain_comment', $data );
	}

	// 포캐스팅 코멘트 등록시 본문 카운트 증가
	function maintain_cnum_update( $seq = 0) {
		$sql = "update sales_maintain set cnum = cnum + 1 where seq = ?";
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	// 포캐스팅 코멘트 리스트
	function maintain_comment_list($seq) {
		$sql = "select seq, maintain_seq, user_id, user_name, contents, insert_date from sales_maintain_comment where maintain_seq = ? order by seq desc";
		$query = $this->db->query( $sql, $seq );

		return $query->result_array();
	}

	// 포캐스팅 코멘트 삭제
	function maintain_comment_delete( $seq, $cseq ) {
		$sql = "delete from sales_maintain_comment where seq = ? and maintain_seq = ?";
		$query = $this->db->query( $sql, array( $cseq, $seq ) );

		return	$query;
	}

	// 포캐스팅 코멘트 삭제시 본문 카운트 감소
	function maintain_cnum_update2( $seq = 0) {
		$sql = "update sales_maintain set cnum = cnum - 1 where seq = ?";
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

}
?>
