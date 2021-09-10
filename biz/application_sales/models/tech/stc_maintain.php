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

	// // 포캐스팅 기본사항 추가및 수정
	// function maintain_insert( $data, $mode = 0 , $seq = 0) {
	// 	if( $mode == 0 ) {
	// 		$sql = "insert into sales_forcasting (customer_companyname,customer_username,customer_tel,customer_email,project_name,progress_step,cooperation_companyname,cooperation_username,cooperation_tel,cooperation_email,exception_saledate2,exception_saledate3,complete_status,company_num,write_id,insert_date,update_date) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now(),now())";

	// 		$this->db->query($sql, array($data['customer_companyname'],$data['customer_username'],$data['customer_tel'],$data['customer_email'],$data['project_name'],$data['progress_step'],$data['cooperation_companyname'],$data['cooperation_username'],$data['cooperation_tel'],$data['cooperation_email'],$data['exception_saledate2'],$data['exception_saledate3'],$data['complete_status'],$this->cnum,$data['write_id']));

	// 		$sql2 = "select max(seq) as max_seq from sales_forcasting";
	// 		$query = $this->db->query( $sql2 );
	// 		$mseq = $query->row()->max_seq;

	// 		$product_array = explode("||", $data['product_array']);
	// 		print_r($product_array);
			
	// 		for($i=1;$i<count($product_array);$i++)
	// 		{
	// 			$product_list = explode("~",$product_array[$i]);

	// 			$sql3 = "insert into sales_forcasting_product (forcasting_seq,product_code,product_licence,product_serial,product_state,maintain_yn,insert_date) values(?,?,?,?,?,?,now())";
	// 			$this->db->query($sql3, array($mseq,$product_list[0],$product_list[1],$product_list[2],$product_list[3],$product_list[4]));
	// 		}

	// 		$main_array = explode("||", $data['main_array']);

	// 		for($i=1;$i<count($main_array);$i++)
	// 		{
	// 			$main_list = explode("~",$main_array[$i]);

	// 			$sql4 = "insert into sales_forcasting_mcompany (forcasting_seq,main_companyname,main_username,main_tel,main_email,insert_date) values(?,?,?,?,?,now())";
	// 			$result = $this->db->query($sql4, array($mseq,$main_list[0],$main_list[1],$main_list[2],$main_list[3]));
	// 		}
	// 		return $result;
	// 	}
	// 	else {
	// 		$sql = "update sales_forcasting set customer_companyname=?,customer_username=?,customer_tel=?,customer_email=?,project_name=?,progress_step=?,cooperation_companyname=?,cooperation_username=?,cooperation_tel=?,cooperation_email=?,exception_saledate2=?,exception_saledate3=?,complete_status=?,update_date=now() where seq=?";

	// 		$this->db->query($sql, array($data['customer_companyname'],$data['customer_username'],$data['customer_tel'],$data['customer_email'],$data['project_name'],$data['progress_step'],$data['cooperation_companyname'],$data['cooperation_username'],$data['cooperation_tel'],$data['cooperation_email'],$data['exception_saledate2'],$data['exception_saledate3'],$data['complete_status'],$seq));



	// 		$sql2 = "delete from sales_forcasting_product where forcasting_seq=?";
	// 		$this->db->query($sql2, $seq);

	// 		$product_array = explode("||", $data['product_array']);

	// 		for($i=1;$i<count($product_array);$i++)
	// 		{
	// 			$product_list = explode("~",$product_array[$i]);

	// 			$sql3 = "insert into sales_forcasting_product (forcasting_seq,product_code,product_licence,product_serial,product_state,maintain_yn,insert_date) values(?,?,?,?,?,?,now())";
	// 			$this->db->query($sql3, array($seq,$product_list[0],$product_list[1],$product_list[2],$product_list[3],$product_list[4]));
	// 		}

	// 		$sql4 = "delete from sales_forcasting_mcompany where forcasting_seq=?";
	// 		$this->db->query($sql4, $seq);

	// 		$main_array = explode("||", $data['main_array']);

	// 		for($i=1;$i<count($main_array);$i++)
	// 		{
	// 			$main_list = explode("~",$main_array[$i]);

	// 			$sql5 = "insert into sales_forcasting_mcompany (forcasting_seq,main_companyname,main_username,main_tel,main_email,insert_date) values(?,?,?,?,?,now())";
	// 			$result = $this->db->query($sql5, array($seq,$main_list[0],$main_list[1],$main_list[2],$main_list[3]));
	// 		}
	// 		return $result;
	// 	}
	// }

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
	function maintain_view3($seq = 0)
	{
		$sql = "select sp.seq, sp.product_code,(SELECT project_name FROM sales_forcasting WHERE seq = (SELECT forcasting_seq FROM sales_maintain WHERE seq = sp.org_maintain_seq )) AS project_name,(SELECT project_name FROM sales_integration_maintain WHERE seq = sp.integration_maintain_seq ) AS integration_maintain_project_name,(SELECT exception_saledate FROM sales_maintain WHERE seq = sp.org_maintain_seq ) AS exception_saledate, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, p.product_company, p.product_type, p.product_name, p.product_item, sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit from sales_maintain_product sp, product p where sp.product_code = p.seq and sp.maintain_seq = ? order by sp.seq asc, p.product_company desc";
		$query = $this->db->query($sql, $seq);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	// 포캐스팅 기본사항 추가및 수정
	function maintain_insert($data,$seq,$data_type){
		$result='';
		if($data_type == '1'){//고객사
			$result =  $this->db->update('sales_maintain', $data, array('seq' => $seq));
		}else if($data_type == '2'){//영업
			$result =  $this->db->update('sales_maintain', $data, array('seq' => $seq));
		}else if($data_type == '3'){//매출
			$result =  $this->db->update('sales_maintain', $data, array('seq' => $seq));
		}else if($data_type == '4'){//매입
			//forcasting_mcompany_delete
			$delete_main_array = explode(",", $data['delete_main_array']); 

			for($i=1; $i<count($delete_main_array); $i++){
				$sql1 = "delete from sales_maintain_mcompany where seq = {$delete_main_array[$i]}";
				$result = $this->db->query($sql1);
			}

			//forcasting_mcompany 업데이트
			$update_main_array = explode("||", $data['update_main_array']);
			$update_column = explode(",","main_companyname,main_username,main_tel,main_email");

			for ($i = 1; $i < count($update_main_array); $i++) {
				$main_list = explode("~", $update_main_array[$i]);

				$sql2 = "update sales_maintain_mcompany set forcasting_seq={$seq},";
				for($j=0; $j<count($update_column); $j++){
					$sql2 .= "{$update_column[$j]} = '{$main_list[$j]}',";
				}
				$sql2 .= "update_date=now() where seq={$main_list[count($update_column)]}";
				$result = $this->db->query($sql2);
			}
		}else if($data_type == '5'){//장비

			//제품 업데이트
			$update_product_array = explode("||", $data['update_product_array']);
			$update_column = explode(",","product_code,product_licence,product_serial,product_state,maintain_begin,maintain_expire,maintain_yn,maintain_target,product_sales,product_purchase,product_profit");

			for ($i = 1; $i < count($update_product_array); $i++) {
				$product_list = explode("~", $update_product_array[$i]);
				$sql2 = "update sales_maintain_product set forcasting_seq={$seq},";
				for($j=0; $j<count($update_column); $j++){
					$sql2 .= "{$update_column[$j]} = '{$product_list[$j]}',";
				}
				$sql2 .= "update_date=now() where seq={$product_list[count($update_column)]}";
				$result = $this->db->query($sql2);
			}

			// //연계 프로젝트 제품 업데이트
			// $update_sub_product_array = explode("||", $data['update_sub_product_array']);
			
			// for ($i = 1; $i<count($update_sub_product_array); $i++) {
			// 	$product_list = explode("~", $update_sub_product_array[$i]);
			// 	$sql3 = "update sales_maintain_product set ";
			// 	for($j=0; $j<count($update_column); $j++){
			// 		$sql3 .= "{$update_column[$j]} = '{$product_list[$j]}',";
			// 	}
			// 	$sql3 .= "update_date=now() where seq={$product_list[count($update_column)]}";
			// 	$result = $this->db->query($sql3);

			// 	$sql4 = "SELECT forcasting_seq,SUM(product_sales) AS forcasting_sales,SUM(product_purchase) AS forcasting_purchase ,SUM(product_profit) AS forcasting_profit FROM sales_forcasting_product WHERE forcasting_seq = (select forcasting_seq from sales_forcasting_product where seq = {$product_list[count($update_column)]});";

			// 	$updateColumn = $this->db->query($sql4)->row_array();
				
			// 	$sql5 = "update sales_forcasting set forcasting_sales ='{$updateColumn['forcasting_sales']}',forcasting_purchase='{$updateColumn['forcasting_purchase']}',forcasting_profit='{$updateColumn['forcasting_profit']}',update_date=now() where seq ={$updateColumn['forcasting_seq']}";
				
			// 	$this->db->query($sql5);
			// }

			//나머지~고객사총매출가랑 이론거
			$sql =  "update sales_maintain set forcasting_sales=?,forcasting_purchase=?,forcasting_profit=?,division_month=?,exception_saledate2=?,exception_saledate3=?,write_id=?,update_date=? where seq=?";
			$result = $this->db->query($sql, array($data['forcasting_sales'], $data['forcasting_purchase'], $data['forcasting_profit'], $data['division_month'], $data['exception_saledate2'], $data['exception_saledate3'], $data['write_id'], $data['update_date'],$seq));

		}else if($data_type == '6'){//수주
			$result =  $this->db->update('sales_maintain', $data, array('seq' => $seq));

		}else if($data_type == '7'){//점검
			$result =  $this->db->update('sales_maintain', $data, array('seq' => $seq));
		}

		return $result;
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
	function maintain_list( $searchkeyword,$searchkeyword2, $search1, $search2, $start_limit = 0, $offset = 0, $cnum) {
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
				$searchstring = " and sf.exception_saledate2 < ? ";
				$keyword =$searchkeyword;
			} else if($search2 == "008") {
				$searchstring = " and sf.exception_saledate3 < ? ";
				$keyword =$searchkeyword;
			} else if($search2 == "009") {
					$searchstring = " and sf.manage_team=? and sf.maintain_result=".$searchkeyword2;
					$keyword = $searchkeyword;
			} else if($search2 == "010"){
				$searchstring = " and sf.maintain_user like concat('%',?,'%') and sf.maintain_result=".$searchkeyword2;
				$keyword = $searchkeyword;
			}
		} else {
			$searchstring = "";
		}

		if($this->lv == "") {
			// $sql = "select * from(select sf.seq,sf.type,sf.manage_team, sf.maintain_user, sf.file, sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2, sf.exception_saledate3, sf.company_num, sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code" . $searchstring . " and company_num = ? and progress_step>'014' and (sub_project_add not REGEXP sf.seq or sub_project_add IS NULL) order by replace(sf.exception_saledate2,'-','') DESC)a left join(SELECT sub_project_add,SUM(forcasting_sales) AS sum_forcasting_sales,SUM(forcasting_purchase) AS sum_forcasting_purchase,SUM(forcasting_profit) AS sum_forcasting_profit FROM sales_forcasting GROUP BY sub_project_add)b ON a.sub_project_add = b.sub_project_add";
			$sql = "select sf.seq, sf.forcasting_seq, sf.type,sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.maintain_user,sf.file, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit from stc.sales_maintain sf, (select * from stc.sales_maintain_product group by maintain_seq) sp, stc.product p where sf.seq = sp.maintain_seq and p.seq = sp.product_code and company_num = '{$cnum}' " . $searchstring . "  order by replace(exception_saledate2,'-','') DESC";
			
			if  ( $offset <> 0 )
				$sql = $sql." limit ?, ?";

			if  ( $searchkeyword != "" )
				$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
			else
				$query = $this->db->query( $sql, array( $start_limit, $offset ) );
		} else {
			// $sql = "select * from(select sf.seq,sf.type,sf.manage_team, sf.maintain_user, sf.file, sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit from stc.sales_forcasting sf, (select * from stc.sales_forcasting_product group by forcasting_seq) sp, stc.product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code" . $searchstring . " and progress_step>'014' and (sub_project_add not REGEXP sf.seq or sub_project_add IS NULL) order by replace(sf.exception_saledate2,'-','') DESC)a left join (SELECT sub_project_add,SUM(forcasting_sales) AS sum_forcasting_sales,SUM(forcasting_purchase) AS sum_forcasting_purchase,SUM(forcasting_profit) AS sum_forcasting_profit FROM sales_forcasting GROUP BY sub_project_add)b ON a.sub_project_add = b.sub_project_add";
			$sql = "select sf.seq, sf.forcasting_seq, sf.type,sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.maintain_user,sf.file, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit from stc.sales_maintain sf, (select * from stc.sales_maintain_product group by maintain_seq) sp, stc.product p where sf.seq = sp.maintain_seq and p.seq = sp.product_code" . $searchstring . "  order by replace(exception_saledate2,'-','') DESC";
			
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
	function maintain_list_count($searchkeyword,$searchkeyword2, $search1, $search2, $cnum) {
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
				$searchstring = " and sf.exception_saledate2 < ? ";
				$keyword = $searchkeyword;
			} else if($search2 == "008") {
				$searchstring = " and sf.exception_saledate3 < ? ";
				$keyword = $searchkeyword;
			}else if($search2 == "009") {
                                $searchstring = " and sf.manage_team=? and sf.maintain_result=".$searchkeyword2;
                                $keyword = $searchkeyword;
			} else if($search2 == "010"){
				$searchstring = " and sf.maintain_user like concat('%',?,'%') and sf.maintain_result=".$searchkeyword2;
				$keyword = $searchkeyword;
			}

		} else {
			$searchstring = "";
		}

		if($this->lv == "") {
			// $sql = "select count(sf.seq) as ucount from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code" . $searchstring . " and company_num = ? and progress_step>'014' and (sub_project_add not REGEXP sf.seq or sub_project_add IS NULL) order by replace(sf.exception_saledate2,'-','') DESC";
			$sql = "select count(sf.seq) as ucount from stc.sales_maintain sf, (select * from stc.sales_maintain_product group by maintain_seq) sp, stc.product p where sf.seq = sp.maintain_seq and p.seq = sp.product_code and company_num = '{$cnum}' " . $searchstring . " order by replace(exception_saledate2,'-','') DESC";

			if  ( $searchkeyword != "" )
				$query = $this->db->query( $sql,$keyword);
			else
				$query = $this->db->query( $sql );
		} else {
			// $sql = "select count(sf.seq) as ucount from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code" . $searchstring . " and progress_step>'014' and (sub_project_add not REGEXP sf.seq or sub_project_add IS NULL) order by replace(sf.exception_saledate2,'-','') DESC";
			$sql = "select count(sf.seq) as ucount from stc.sales_maintain sf, (select * from stc.sales_maintain_product group by maintain_seq) sp, stc.product p where sf.seq = sp.maintain_seq and p.seq = sp.product_code" . $searchstring . " order by replace(exception_saledate2,'-','') DESC";

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
		// $sql = "select seq, forcasting_seq, user_id, user_name, contents, insert_date from sales_forcasting_comment where forcasting_seq = ? order by seq desc";
		$sql = "select * from sales_maintain_comment where maintain_seq = ? order by seq desc";
		
		$query = $this->db->query( $sql, $seq );

		return $query->result_array();
	}

	// 포캐스팅 코멘트 삭제
	function maintain_comment_delete( $seq, $cseq ) {
		// $sql = "delete from sales_forcasting_comment where seq = ? and forcasting_seq = ?";
		$sql = "delete from sales_maintain_comment where seq = ? and maintain_seq = ?";
		
		$query = $this->db->query( $sql, array( $cseq, $seq ) );

		return	$query;
	}

	// 포캐스팅 코멘트 삭제시 본문 카운트 감소
	function maintain_cnum_update2( $seq = 0) {
		// $sql = "update sales_forcasting set cnum = cnum - 1 where seq = ?";
		$sql = "update sales_maintain set cnum = cnum - 1 where seq = ?";
		
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	//연계 프로젝트 조회(조회추가 할 수 있는애들!)
	function sub_project_select($seq){
		$sql1 = " and customer_companyname REGEXP (SELECT customer_companyname FROM sales_maintain WHERE seq={$seq})";
        $sql2 = " and customer_companyname REGEXP (SUBSTRING_INDEX((SELECT customer_companyname FROM sales_maintain WHERE seq={$seq}),'(',1)";
		// $sql = "select seq,customer_companyname,project_name from sales_maintain where (sub_project_add is null or sub_project_add = '' OR sub_project_add NOT LIKE '%{$seq}%') and progress_step>'014' and project_name <>(SELECT project_name FROM sales_maintain WHERE seq=?) and ((SELECT customer_companyname FROM sales_maintain WHERE seq=?) not like '%(%'" . $sql1 . " or (SELECT customer_companyname FROM sales_maintain WHERE seq=?) like '%(%'" . $sql2 . ")) order by replace(exception_saledate,'-','') ASC";
		$sql = "select seq,customer_companyname,project_name from sales_maintain where project_name <>(SELECT project_name FROM sales_maintain WHERE seq={$seq}) and (SELECT concat(IF(sub_project_add IS NULL ,'', sub_project_add),',') FROM sales_maintain WHERE seq='{$seq}') NOT LIKE CONCAT(seq,',') AND (SELECT forcasting_seq FROM sales_maintain WHERE seq='{$seq}') <> forcasting_seq and ((SELECT customer_companyname FROM sales_maintain WHERE seq={$seq}) not like '%(%'" . $sql1 . " or (SELECT customer_companyname FROM sales_maintain WHERE seq={$seq}) like '%(%'" . $sql2 . ")) order by replace(exception_saledate,'-','') ASC";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	//조회추가 한 연계 프로젝트 조회(조회취소할때 사용)
	function sub_project_cancel($seq)
	{
		// $sql = "select seq,customer_companyname,project_name from sales_maintain WHERE sub_project_add =(SELECT sub_project_add FROM sales_maintain WHERE seq=?) AND sub_project_add regexp seq AND sub_project_add IS NOT null order by replace(exception_saledate,'-','') ASC";
		// $sql = "select seq,customer_companyname,project_name,sub_project_add from sales_maintain WHERE sub_project_add = '{$seq}'";
		$sql = "SELECT sub_project_add FROM sales_maintain WHERE seq = {$seq}";
		$sub_data = $this->db->query($sql)->row_array();
		if($sub_data['sub_project_add'] != ""){
			$sql = "select seq,customer_companyname,project_name,sub_project_add from sales_maintain WHERE seq IN ({$sub_data['sub_project_add']})";
			$query = $this->db->query($sql);

			return $query->result_array();
		}else{
			return array();
		}
	}

	//선택한 연계 프로젝트 제품
	function subProjectAdd($subProjectSeq)
	{
		$sql = "select sf.project_name, sf.seq as sfSeq ,sf.exception_saledate,sp.seq, sp.product_code, sp.product_licence, sp.product_serial, sp.product_state, p.product_company,p.product_type, p.product_name, p.product_item,sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit from sales_forcasting_product sp, product p,sales_forcasting sf where sp.product_code = p.seq and sp.forcasting_seq = ? and sf.seq =? order by sp.seq asc, p.product_company desc";
		$query = $this->db->query($sql, array($subProjectSeq, $subProjectSeq));
		// if ($query->num_rows() <= 0) {
		// 	return false;
		// } else {
		// 	return true;
		// }
		return $query->result_array();
	}

	//제품 제조사(중복없이)가져오기
	function product_company(){
		$sql = "SELECT DISTINCT product_company FROM product";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	// //수주 여부 코멘트 리스트
	// function forcasting_complete_status_comment_list($seq){
	// 	$sql = "SELECT * FROM sales_forcasting_complete_status_comment WHERE forcasting_seq = {$seq};";
	// 	$query = $this->db->query( $sql );

	// 	if ($query->num_rows() <= 0) {
	// 		return false;
	// 	} else {
	// 		return $query->result_array();
	// 	}
	// }

	//수주 여부 코멘트 리스트
	function maintain_complete_status_comment_list($seq){
		$sql = "SELECT * FROM sales_maintain_complete_status_comment WHERE maintain_seq = {$seq}";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

		/////////////  통합유지보수 ///////
		function integration_maintain_list(){
			$sql = "SELECT * FROM sales_integration_maintain";
			$query = $this->db->query( $sql );
	
			if ($query->num_rows() <= 0) {
				return false;
			} else {
				return $query->result_array();
			}
		}
	
		//통합유지보수 등록 /수정
		function integration_maintain_insert($type,$data){
			if($type == 0){
				 $this->db->insert('sales_integration_maintain',$data);
				 return $this->db->insert_id();
			}else{
				return $this->db->update('sales_integration_maintain',$data,array('seq' => $data['seq']));
			}
		}
	
		//통합유지보수제품 등록 /수정
		function integration_maintain_product_insert($type,$data){
			if($type == 0){
				return $this->db->insert('sales_integration_maintain_product',$data);
		   }else if ($type == 1){
				return $this->db->update('sales_integration_maintain_product',$data,array('seq' => $data['seq']));
		   }else{
			   $sql = "delete from sales_integration_maintain_product where seq = {$data}";
			   return $this->db->query( $sql );
		   }
		}
	
		//통합유지보수 뷰
		function integration_maintain_view($seq){
			$sql = "SELECT * FROM sales_integration_maintain where seq = {$seq}";
			$query = $this->db->query( $sql );
	
			if ($query->num_rows() <= 0) {
				return false;
			} else {
				return $query->row_array();
			}
		}
	
		//통합유지보수 제품 뷰
		function integration_maintain_product_view($seq){
			// $sql = "SELECT * FROM sales_integration_maintain_product where integration_maintain_seq = {$seq}";
			$sql = "SELECT sp.*, p.product_type,p.product_company,p.product_name FROM sales_integration_maintain_product as sp left join product p 
			on sp.product_code = p.seq WHERE integration_maintain_seq = {$seq}";
			$query = $this->db->query( $sql );
	
			if ($query->num_rows() <= 0) {
				return false;
			} else {
				return $query->result_array();
			}
		}
	
		// 통합유지보수 제품 유지보수로 연결
		function integration_maintain_add($product_seq,$maitain_seq){
			$sql = "INSERT INTO sales_maintain_product
			(maintain_seq,org_maintain_seq,integration_maintain_seq,integration_maintain_product_seq,product_code,product_supplier,
			product_count,product_serial,product_state,product_licence,product_version,product_purpose,product_host,product_check_list)
			SELECT 
			{$maitain_seq} as maintain_seq,{$maitain_seq} as org_maintain_seq,integration_maintain_seq,seq as integration_maintain_product_seq,product_code,product_supplier,
			product_count,product_serial,product_state,product_licence,product_version,product_purpose,product_host,product_check_list
			from sales_integration_maintain_product WHERE seq = {$product_seq}";
		   
			return $this->db->query( $sql );
		}
		//유지보수 갱신
		function maintain_renewal($maintain_seq,$project_name,$integration_maintain){
			$sql = "INSERT INTO sales_maintain (forcasting_seq,customer_companyname,customer_username,customer_tel,customer_email,
					 project_name,sales_companyname,sales_username,dept,sales_tel,sales_email,cooperation_companyname,cooperation_username,
					complete_status,company_num,write_id,insert_date,manage_team,maintain_cycle,maintain_date,maintain_user,maintain_type,maintain_result,maintain_comment,sub_project_add)
					select forcasting_seq,customer_companyname,customer_username,customer_tel,customer_email,
					 '{$project_name}' as project_name,sales_companyname,sales_username,dept,sales_tel,sales_email,cooperation_companyname,cooperation_username,
					complete_status,company_num,write_id, now() as insert_date,manage_team,maintain_cycle,maintain_date,maintain_user,maintain_type,maintain_result,maintain_comment,sub_project_add from sales_maintain where seq = {$maintain_seq}";
			$this->db->query( $sql );
			$renewal_seq  = $this->db->insert_id();
	
			if($integration_maintain == true){
				$sql2 = "INSERT INTO sales_maintain_product (maintain_seq,org_maintain_seq,forcasting_seq,integration_maintain_seq,integration_maintain_product_seq,product_code,product_supplier,
				product_serial,product_state,product_licence,product_version,product_purpose,product_host,maintain_yn,maintain_target,insert_date,product_check_list) 
				SELECT {$renewal_seq} as maintain_seq,org_maintain_seq,forcasting_seq,integration_maintain_seq,integration_maintain_product_seq,product_code,product_supplier,
				product_serial,product_state,product_licence,product_version,product_purpose,product_host,maintain_yn,maintain_target,now() as insert_date,product_check_list from sales_maintain_product WHERE maintain_seq = {$maintain_seq}";
			}else{
				$sql2 = "INSERT INTO sales_maintain_product (maintain_seq,org_maintain_seq,forcasting_seq,integration_maintain_seq,integration_maintain_product_seq,product_code,product_supplier,
				product_serial,product_state,product_licence,product_version,product_purpose,product_host,maintain_yn,maintain_target,insert_date,product_check_list) 
				SELECT {$renewal_seq} as maintain_seq,org_maintain_seq,forcasting_seq,integration_maintain_seq,integration_maintain_product_seq,product_code,product_supplier,
				product_serial,product_state,product_licence,product_version,product_purpose,product_host,maintain_yn,maintain_target,now() as insert_date,product_check_list from sales_maintain_product WHERE maintain_seq = {$maintain_seq} and (integration_maintain_seq =='' || integration_maintain_seq is null) and (integration_maintain_product_seq =='' || integration_maintain_product_seq is null) ";
			}
			$result = $this->db->query( $sql2 );
	
			$sql3= "INSERT INTO sales_maintain_mcompany (maintain_seq,forcasting_seq,main_companyname,main_username,main_tel,main_email,insert_date)
			SELECT {$renewal_seq} as maintain_seq,forcasting_seq,main_companyname,main_username,main_tel,main_email,now() insert_date from sales_maintain_mcompany WHERE maintain_seq ={$maintain_seq}";
			
			$result = $this->db->query( $sql3 );
			return $renewal_seq;
		}

	//세금계산서 가져오기
	function maintain_sales_bill_view($seq){
		$sql = "select * from sales_maintain_bill where maintain_seq = {$seq}";
		$query = $this->db->query( $sql );
		
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}


}
?>
