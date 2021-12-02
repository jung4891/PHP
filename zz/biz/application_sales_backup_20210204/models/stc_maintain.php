<?php
header("Content-type: text/html; charset=utf-8");

class STC_Maintain extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->id = $this->phpsession->get('id', 'stc');
		$this->name = $this->phpsession->get('name', 'stc');
		$this->lv = $this->phpsession->get('lv', 'stc');
		$this->cnum = $this->phpsession->get('cnum', 'stc');
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

			//forcasting_mcompany insert
			$insert_main_array = explode("||", $data['insert_main_array']);

			for ($i = 1; $i < count($insert_main_array); $i++) {
				$main_list = explode("~", $insert_main_array[$i]);

				$sql4 = "insert into sales_maintain_mcompany (maintain_seq,forcasting_seq,main_companyname,main_username,main_tel,main_email,purchase_pay_session,insert_date) values({$seq},";
				for($j=0; $j<count($main_list); $j++){
					$sql4 .= "'{$main_list[$j]}',";
				}
				$sql4 .= "now())";
				$result = $this->db->query($sql4);
			}

			//forcasting_mcompany 업데이트
			$update_main_array = explode("||", $data['update_main_array']);
			$update_column = explode(",","main_companyname,main_username,main_tel,main_email,purchase_pay_session");

			for ($i = 1; $i < count($update_main_array); $i++) {
				$main_list = explode("~", $update_main_array[$i]);

				$sql2 = "update sales_maintain_mcompany set ";
				for($j=0; $j<count($update_column); $j++){
					$sql2 .= "{$update_column[$j]} = '{$main_list[$j]}',";
				}
				$sql2 .= "update_date=now() where seq={$main_list[count($update_column)]}";
				$result = $this->db->query($sql2);
			}
		}else if($data_type == '5'){//장비
			//제품 delete
			$delete_product_array = explode(",", $data['delete_product_array']); 

			for($i=1; $i<count($delete_product_array); $i++){
				$sql1 = "delete from sales_maintain_product where seq = {$delete_product_array[$i]}";
				$this->db->query($sql1);
			}

			//제품 업데이트
			$update_product_array = explode("||", $data['update_product_array']);
			$update_column = explode(",","product_code,product_supplier,product_licence,product_serial,product_state,maintain_begin,maintain_expire,maintain_yn,maintain_target,product_sales,product_purchase,product_profit");

			for ($i = 1; $i < count($update_product_array); $i++) {
				$product_list = explode("~", $update_product_array[$i]);
				$sql2 = "update sales_maintain_product set ";
				for($j=0; $j<count($update_column); $j++){
					$sql2 .= "{$update_column[$j]} = '{$product_list[$j]}',";
				}
				$sql2 .= "update_date=now() where seq={$product_list[count($update_column)]}";
				$result = $this->db->query($sql2);
				$sql3 = "select * from sales_maintain_product where seq = {$product_list[count($update_column)]}";
				$update_data = $this->db->query($sql3)->row_array();
				if($update_data['integration_maintain_product_seq'] != "" || $update_data['integration_maintain_product_seq']!= null){
					$sql4 = "update sales_integration_maintain_product set ";
					for($j=0; $j<count($update_column); $j++){
						$sql4 .= "{$update_column[$j]} = '{$product_list[$j]}',";
					}
					$sql4 .= "update_date=now() where seq='{$update_data['integration_maintain_product_seq']}'";
					$result = $this->db->query($sql4);
				} 
			}

			//제품 insert
			$insert_product_array = explode("||", $data['insert_product_array']);
			for ($i = 1; $i < count($insert_product_array); $i++) {
				$product_list = explode("~", $insert_product_array[$i]);
				$sql3 = "insert into sales_maintain_product (maintain_seq,org_maintain_seq,forcasting_seq,product_code,product_supplier,product_licence,product_serial,product_state,maintain_begin,maintain_expire,maintain_yn,maintain_target,product_sales,product_purchase,product_profit,insert_date) values(";
				for($j=0; $j<count($product_list); $j++){
					$sql3 .= "'{$product_list[$j]}',";
				}
				$sql3 .= "now())";
				$this->db->query($sql3);
			}

			// //연계 프로젝트 제품 업데이트
			// $update_sub_product_array = explode("||", $data['update_sub_product_array']);
			
			// for ($i = 1; $i<count($update_sub_product_array); $i++) {
			// 	$product_list = explode("~", $update_sub_product_array[$i]);
			// 	$sql3 = "update sales_forcasting_product set ";
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

	//	포캐스팅 뷰내용 가져오기(기본)
	function maintain_view($seq = 0)
	{
		$sql = "select * from sales_maintain where seq = ?";
		$query = $this->db->query($sql, $seq);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	//	포캐스팅 뷰내용 가져오기(주사업자)
	function maintain_view2($seq = 0)
	{
		$sql = "select * from sales_maintain_mcompany where maintain_seq = ?";
		$query = $this->db->query($sql, $seq);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//	포캐스팅 뷰내용 가져오기(제품명)
	function maintain_view3($seq = 0)
	{
		// $sql = "select sp.seq, sp.product_code,(SELECT project_name FROM sales_maintain WHERE seq = sp.org_maintain_seq ) AS project_name,(SELECT project_name FROM sales_integration_maintain WHERE seq = sp.integration_maintain_seq ) AS integration_maintain_project_name,(SELECT exception_saledate FROM sales_maintain WHERE seq = sp.org_maintain_seq ) AS exception_saledate, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, p.product_company, p.product_type, p.product_name, p.product_item, sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit from sales_maintain_product sp, product p where sp.product_code = p.seq and sp.maintain_seq = ? order by sp.seq asc, p.product_company desc";
		$sql = "select sp.seq, sp.product_code, if(sp.integration_maintain_seq = '' || sp.integration_maintain_seq IS NULL,(SELECT project_name FROM sales_forcasting WHERE seq = (SELECT forcasting_seq FROM sales_maintain WHERE seq = sp.org_maintain_seq )),(SELECT project_name FROM sales_integration_maintain WHERE seq = sp.integration_maintain_seq )) AS project_name,(SELECT exception_saledate FROM sales_maintain WHERE seq = sp.org_maintain_seq ) AS exception_saledate, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, p.product_company, p.product_type, p.product_name, p.product_item, sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit from sales_maintain_product sp, product p where sp.product_code = p.seq and sp.maintain_seq = ? order by sp.seq asc, p.product_company desc";
		
		// $sql = "SELECT * FROM (select sp.seq,sp.forcasting_seq ,sp.product_code, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, p.product_company, p.product_type, p.product_name, p.product_item, sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit 
		// from sales_maintain_product sp, product p where sp.product_code = p.seq and sp.forcasting_seq = ? order by sp.seq asc, p.product_company DESC) AS spp
		// JOIN sales_maintain_product_period AS smpp ON spp.seq = smpp.maintain_product_seq";
		$query = $this->db->query($sql, $seq);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//	유지보수 제품 프로젝트명 가져오기(제품명)
	function maintain_view4($seq = 0)
	{
		// $sql = "select sp.seq, sp.product_code,(SELECT project_name FROM sales_maintain WHERE seq = sp.org_maintain_seq ) AS project_name,(SELECT project_name FROM sales_integration_maintain WHERE seq = sp.integration_maintain_seq ) AS integration_maintain_project_name,(SELECT exception_saledate FROM sales_maintain WHERE seq = sp.org_maintain_seq ) AS exception_saledate, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, p.product_company, p.product_type, p.product_name, p.product_item, sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit from sales_maintain_product sp, product p where sp.product_code = p.seq and sp.maintain_seq = ? order by sp.seq asc, p.product_company desc";
		$sql = "select if(sp.integration_maintain_seq = '' || sp.integration_maintain_seq IS NULL,(SELECT project_name FROM sales_forcasting WHERE seq = (SELECT forcasting_seq FROM sales_maintain WHERE seq = sp.org_maintain_seq )),(SELECT project_name FROM sales_integration_maintain WHERE seq = sp.integration_maintain_seq )) AS project_name from sales_maintain_product sp, product p where sp.product_code = p.seq and sp.maintain_seq = ? group by project_name order by sp.seq asc";
		
		// $sql = "SELECT * FROM (select sp.seq,sp.forcasting_seq ,sp.product_code, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, p.product_company, p.product_type, p.product_name, p.product_item, sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit 
		// from sales_maintain_product sp, product p where sp.product_code = p.seq and sp.forcasting_seq = ? order by sp.seq asc, p.product_company DESC) AS spp
		// JOIN sales_maintain_product_period AS smpp ON spp.seq = smpp.maintain_product_seq";
		$query = $this->db->query($sql, $seq);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	// //	유지보수 뷰내용 가져오기(제품_유지보수)
	// function maintain_view4($seq = 0){
	// 	$seq = explode(',',$seq);
		 
	// 	$sql = "select * from sales_maintain_product_period WHERE maintain_product_seq in (";
	// 	for($i=0; $i<count($seq); $i++){
	// 		if($i == 0){
	// 			$sql .= "{$seq[$i]}";
	// 		}else{
	// 			$sql .= ",{$seq[$i]}";
	// 		}
	// 	}
	// 	$sql .= ")";

	// 	$query = $this->db->query($sql, $seq);

	// 	if ($query->num_rows() <= 0) {
	// 		return false;
	// 	} else {
	// 		return $query->result_array();
	// 	}
	// }

	// 포캐스팅 삭제
	function maintain_delete($seq)
	{
		// //연계프로젝트 삭제 되었을때 연계프로젝트들의 sub_project_add컬럼에서 삭제되는 seq 지워주기
		// $subProject = "select seq from sales_forcasting WHERE sub_project_add =(SELECT sub_project_add FROM sales_forcasting WHERE seq={$seq}) AND sub_project_add regexp seq AND sub_project_add IS NOT null ";
		// $subSeq = $this->db->query($subProject);

		// $parentProject ="select seq from sales_forcasting WHERE sub_project_add =(SELECT sub_project_add FROM sales_forcasting WHERE seq={$seq}) AND sub_project_add NOT regexp seq AND sub_project_add IS NOT null ";
		// $parentSeq = $this->db->query($parentProject);
		// $parentRow = $parentSeq->row_array();

		// if($parentSeq->num_rows() > 0 && $subSeq->num_rows() > 0){
		// 	if($parentRow['seq'] == $seq){
		// 		foreach($subSeq->result_array() as $row){
		// 			$subUpdate = "UPDATE sales_forcasting SET sub_project_add = null WHERE seq ={$row['seq']}";
		// 			$this->db->query($subUpdate);
		// 		}
		// 	}else{
		// 			foreach($subSeq->result_array() as $row){
		// 				$subUpdate = "UPDATE sales_forcasting SET sub_project_add = trim(BOTH ',' from replace(sub_project_add,'{$seq}','')) WHERE seq ={$row['seq']}";
		// 				$this->db->query($subUpdate);
		// 			}

		// 			$subUpdate = "UPDATE sales_forcasting SET sub_project_add = trim(BOTH ',' from replace(sub_project_add,'{$seq}','')) WHERE seq = {$parentRow['seq']}";
		// 			$this->db->query($subUpdate);
		// 	}

		// }
		
		// $sql = "delete from sales_forcasting where seq = ?";
		// $this->db->query($sql, $seq);
		// $sql2 = "delete from sales_forcasting_mcompany where forcasting_seq = ?";
		// $this->db->query($sql2, $seq);
		// $sql3 = "delete from sales_forcasting_product where forcasting_seq = ?";
		// $this->db->query($sql3, $seq);
		// $sql4 = "delete from sales_forcasting_comment where forcasting_seq = ?";
		// $this->db->query($sql4, $seq);
		// $sql5 = "delete from sales_forcasting_complete_status_comment where forcasting_seq = ?";
		// $query = $this->db->query($sql5, $seq);
		$sql = "DELETE a,b,c,e,d,f 
		FROM sales_maintain a
		left JOIN sales_maintain_product b
		ON a.seq = b.maintain_seq
		left JOIN sales_maintain_mcompany c
		ON a.seq = c.maintain_seq
		LEFT JOIN sales_maintain_bill d
		ON a.seq = d.maintain_seq
		LEFT JOIN sales_maintain_comment e
		on a.seq = e.maintain_seq
		LEFT JOIN sales_maintain_complete_status_comment f
		on a.seq = f.maintain_seq
		WHERE a.seq={$seq}";
		return $this->db->query($sql);
	}

	// 포캐스팅 리스트
	function maintain_list($searchkeyword, $start_limit = 0, $offset = 0, $cnum){
		if ($searchkeyword != "") {
			$searchstring='';
			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //고객사
				$searchstring = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
			}
			if(trim($searchkeyword[1])!=''){ //프로젝트명
				$searchstring .= " and sf.project_name like '%{$searchkeyword[1]}%'";
			}
			if(trim($searchkeyword[2])!=''){ //유지보수 시작일
				$searchstring .= " and sf.exception_saledate2 >= '{$searchkeyword[2]}'";
			}
			if(trim($searchkeyword[3])!=''){ //유지보수 종료일
				$searchstring .= " and sf.exception_saledate3 <= '{$searchkeyword[3]}'";
			}
			if(trim($searchkeyword[4])!=''){ //영업담당자(두리안)
				$searchstring .= " and sf.cooperation_username like '%{$searchkeyword[4]}%'";
			}
			if(trim($searchkeyword[5])!=''){//제조사
				$searchstring .= " and p.product_company like '%{$searchkeyword[5]}%'";
			}
			if(trim($searchkeyword[6])!=''){ //품목
				$searchstring .= " and p.product_item like '%{$searchkeyword[6]}%'";
			}
			if(trim($searchkeyword[7])!=''){ //제품명
				$searchstring .= " and p.product_name like '%{$searchkeyword[7]}%'";
			}
			if(trim($searchkeyword[8])!=''){ //관리팀
				$searchstring .= " and sf.manage_team = '{$searchkeyword[8]}'";
			}
			if(trim($searchkeyword[9])!=''){ //점검여부
				$searchstring .= " and sf.maintain_result = '{$searchkeyword[9]}'";
			}
			// if(trim($searchkeyword[10])!=''){ //판매종류
			// 	$searchstring .= " and sf.type = '{$searchkeyword[10]}'";
			// }
		} else {
			$searchstring = "";
		}

		if ($this->lv == 1) {
			// $sql = "select * from(select sf.seq,sf.type,sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2, sf.exception_saledate3, sf.company_num, sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code" . $searchstring . " and company_num = ? and progress_step>'014' and (sub_project_add not REGEXP sf.seq or sub_project_add IS NULL))a left join(SELECT sub_project_add,SUM(forcasting_sales) AS sum_forcasting_sales,SUM(forcasting_purchase) AS sum_forcasting_purchase,SUM(forcasting_profit) AS sum_forcasting_profit FROM sales_forcasting GROUP BY sub_project_add)b ON a.sub_project_add = b.sub_project_add order by replace(exception_saledate2,'-','') DESC";
			// $sql = "select * from (select sf.seq, sf.forcasting_seq, sf.type,sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2, sf.exception_saledate3, sf.company_num, sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit from sales_maintain sf, (select * from sales_main_product group by forcasting_seq) sp, product p where sf.forcasting_seq = sp.forcasting_seq and p.seq = sp.product_code" . $searchstring . " and company_num = ?  and (sub_project_add not REGEXP sf.forcasting_seq or sub_project_add IS NULL))a left join(SELECT sub_project_add,SUM(forcasting_sales) AS sum_forcasting_sales,SUM(forcasting_purchase) AS sum_forcasting_purchase,SUM(forcasting_profit) AS sum_forcasting_profit FROM sales_forcasting GROUP BY sub_project_add)b ON a.sub_project_add = b.sub_project_add order by replace(exception_saledate2,'-','') DESC";
			$sql = "select sf.seq, sf.forcasting_seq, sf.type,sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit from stc.sales_maintain sf, (select * from stc.sales_maintain_product group by maintain_seq) sp, stc.product p where sf.seq = sp.maintain_seq and p.seq = sp.product_code and company_num = '{$$cnum}' " . $searchstring . "  order by replace(exception_saledate2,'-','') DESC";
			
			if ($offset <> 0){
				$sql = $sql . " limit ?, ?";
			}
			$query = $this->db->query($sql, array($start_limit, $offset));
		} else {
			// $sql = "select* from(select sf.seq,sf.type,sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit from stc.sales_forcasting sf, (select * from stc.sales_forcasting_product group by forcasting_seq) sp, stc.product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code" . $searchstring . " and progress_step>'014' and (sub_project_add not REGEXP sf.seq or sub_project_add IS NULL))a left join (SELECT sub_project_add,SUM(forcasting_sales) AS sum_forcasting_sales,SUM(forcasting_purchase) AS sum_forcasting_purchase,SUM(forcasting_profit) AS sum_forcasting_profit FROM sales_forcasting GROUP BY sub_project_add)b ON a.sub_project_add = b.sub_project_add order by replace(exception_saledate2,'-','') DESC";
			// $sql = "select* FROM(select sf.seq, sf.forcasting_seq, sf.type,sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit from stc.sales_maintain sf, (select * from stc.sales_maintain_product group by forcasting_seq) sp, stc.product p where sf.forcasting_seq = sp.forcasting_seq and p.seq = sp.product_code" . $searchstring . " and progress_step>'014' and (sub_project_add not REGEXP sf.forcasting_seq or sub_project_add IS NULL))a left join (SELECT sub_project_add,SUM(forcasting_sales) AS sum_forcasting_sales,SUM(forcasting_purchase) AS sum_forcasting_purchase,SUM(forcasting_profit) AS sum_forcasting_profit FROM sales_maintain GROUP BY sub_project_add)b ON a.sub_project_add = b.sub_project_add order by replace(exception_saledate2,'-','') DESC";
			$sql = "select sf.seq, sf.forcasting_seq, sf.type,sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit from stc.sales_maintain sf, (select * from stc.sales_maintain_product group by maintain_seq) sp, stc.product p where sf.seq = sp.maintain_seq and p.seq = sp.product_code" . $searchstring . "  order by replace(exception_saledate2,'-','') DESC, exception_saledate3 asc";
			if ($offset <> 0){
				$sql = $sql . " limit ?, ?";
			}
			$query = $this->db->query($sql, array($start_limit, $offset));
		}

		return array('count' => $query->num_rows(), 'data' => $query->result_array());
	}

	//포캐스팅 리스트개수
	function maintain_list_count($searchkeyword, $cnum){
		if ($searchkeyword != "") {
			$searchstring='';
			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //고객사
				$searchstring = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
			}
			if(trim($searchkeyword[1])!=''){ //프로젝트명
				$searchstring .= " and sf.project_name like '%{$searchkeyword[1]}%'";
			}
			if(trim($searchkeyword[2])!=''){ //유지보수 시작일
				$searchstring .= " and sf.exception_saledate2 >= '{$searchkeyword[2]}'";
			}
			if(trim($searchkeyword[3])!=''){ //유지보수 종료일
				$searchstring .= " and sf.exception_saledate3 <= '{$searchkeyword[3]}'";
			}
			if(trim($searchkeyword[4])!=''){ //영업담당자(두리안)
				$searchstring .= " and sf.cooperation_username like '%{$searchkeyword[4]}%'";
			}
			if(trim($searchkeyword[5])!=''){//제조사
				$searchstring .= " and p.product_company like '%{$searchkeyword[5]}%'";
			}
			if(trim($searchkeyword[6])!=''){ //품목
				$searchstring .= " and p.product_item like '%{$searchkeyword[6]}%'";
			}
			if(trim($searchkeyword[7])!=''){ //제품명
				$searchstring .= " and p.product_name like '%{$searchkeyword[7]}%'";
			}
			if(trim($searchkeyword[8])!=''){ //관리팀
				$searchstring .= " and sf.manage_team = '{$searchkeyword[8]}'";
			}
			if(trim($searchkeyword[9])!=''){ //점검여부
				$searchstring .= " and sf.maintain_result = '{$searchkeyword[9]}'";
			}
			// if(trim($searchkeyword[10])!=''){ //판매종류
			// 	$searchstring .= " and sf.type = '{$searchkeyword[10]}'";
			// }
		} else {
			$searchstring = "";
		}

		if ($this->lv == 1) {
			// $sql = "select count(sf.seq) as ucount from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code" . $searchstring . " and company_num = ? and progress_step>'014' and (sub_project_add not REGEXP sf.seq or sub_project_add IS NULL) order by replace(sf.exception_saledate2,'-','') DESC";
			// $sql = "select count(sf.seq) as ucount from sales_maintain sf, (select * from sales_maintain_product group by forcasting_seq) sp, product p where sf.forcasting_seq = sp.forcasting_seq and p.seq = sp.product_code" . $searchstring . " and company_num = ? and (sub_project_add not REGEXP sf.forcasting_seq or sub_project_add IS NULL) order by replace(sf.exception_saledate2,'-','') DESC";
			$sql = "select count(sf.seq) as ucount from stc.sales_maintain sf, (select * from stc.sales_maintain_product group by maintain_seq) sp, stc.product p where sf.seq = sp.maintain_seq and p.seq = sp.product_code and company_num = '{$cnum}'" . $searchstring . " order by replace(exception_saledate2,'-','') DESC";
			$query = $this->db->query($sql);
		} else {
			// $sql = "select count(sf.seq) as ucount from sales_maintain sf, (select * from sales_maintain_product group by forcasting_seq) sp, product p where sf.forcasting_seq = sp.forcasting_seq and p.seq = sp.product_code" . $searchstring . " and progress_step>'014' and (sub_project_add not REGEXP sf.forcasting_seq or sub_project_add IS NULL) order by replace(sf.exception_saledate2,'-','') DESC";
			$sql = "select count(sf.seq) as ucount from stc.sales_maintain sf, (select * from stc.sales_maintain_product group by maintain_seq) sp, stc.product p where sf.seq = sp.maintain_seq and p.seq = sp.product_code" . $searchstring . " order by replace(exception_saledate2,'-','') DESC";
			$query = $this->db->query($sql);
		}
		return $query->row();
	}

	// 유지보수 코멘트 추가
	function maintain_comment_insert($data)
	{
		return $this->db->insert('sales_maintain_comment', $data);
	}

	// 유지보수 코멘트 등록시 본문 카운트 증가
	function maintain_cnum_update($seq = 0)
	{
		$sql = "update sales_maintain set cnum = cnum + 1 where seq = ?";
		$query = $this->db->query($sql, $seq);

		return	$query;
	}

	// 포캐스팅 코멘트 리스트
	function maintain_comment_list($seq)
	{
		$sql = "select * from sales_maintain_comment where maintain_seq = ? order by seq desc";
		$query = $this->db->query($sql, $seq);

		return $query->result_array();
	}

	// 포캐스팅 코멘트 삭제
	function maintain_comment_delete($seq, $cseq)
	{
		$sql = "delete from sales_maintain_comment where seq = ? and maintain_seq = ?";
		$query = $this->db->query($sql, array($cseq, $seq));

		return	$query;
	}

	// 포캐스팅 코멘트 삭제시 본문 카운트 감소
	function maintain_cnum_update2($seq = 0)
	{
		$sql = "update sales_maintain set cnum = cnum - 1 where seq = ?";
		$query = $this->db->query($sql, $seq);

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
		$sql = "select sf.project_name, sf.seq as sfSeq ,sf.exception_saledate,sp.seq, sp.product_code, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, p.product_company,p.product_type, p.product_name, p.product_item,sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit from sales_forcasting_product sp, product p,sales_forcasting sf where sp.product_code = p.seq and sp.forcasting_seq = ? and sf.seq =? order by sp.seq asc, p.product_company desc";
		$query = $this->db->query($sql, array($subProjectSeq, $subProjectSeq));
		// if ($query->num_rows() <= 0) {
		// 	return false;
		// } else {
		// 	return true;
		// }
		return $query->result_array();
	}

	//연계 프로젝트add sub_project_add update문
	function sub_project_add_update($subProjectSeq,$seq)
	{
		$sql = "select sub_project_add from sales_maintain where seq = {$seq}";
		$original_data = $this->db->query($sql)->row_array();
		if(trim($original_data['sub_project_add']) == "" || $original_data['sub_project_add'] == null){
			$sql1 = "UPDATE sales_maintain SET sub_project_add = '{$subProjectSeq}' WHERE seq = {$seq}";
			$this->db->query($sql1);
			$sub = explode(',',$subProjectSeq);
			for($i =0; $i< count($sub); $i++){
				$sql2 = "INSERT INTO sales_maintain_product
				(maintain_seq,
				org_maintain_seq,
				forcasting_seq,
				product_code,
				product_supplier,
				product_count,
				product_serial,
				product_state,
				product_licence,
				product_version,
				product_purpose,
				product_host,
				maintain_begin,
				maintain_expire,
				maintain_yn,
				maintain_target,
				insert_date,
				custom_title,
				custom_detail,
				product_check_list) 
				SELECT {$seq} as maintain_seq,
				maintain_seq as org_maintain_seq,
				forcasting_seq,
				product_code,
				product_supplier,
				product_count,
				product_serial,
				product_state,
				product_licence,
				product_version,
				product_purpose,
				product_host,
				maintain_begin,
				maintain_expire,
				maintain_yn,
				maintain_target,
				insert_date,
				custom_title,
				custom_detail,
				product_check_list FROM sales_maintain_product WHERE maintain_seq = {$sub[$i]}";
				$query2 = $this->db->query($sql2);
			}
		}else{
			$org_sub_project = explode(',',$original_data['sub_project_add']);
			$sub = explode(',',$subProjectSeq);
			for($i=0; $i<count($org_sub_project); $i++){
				for($j=0; $j<count($sub); $j++){
					if($org_sub_project[$i] == $sub[$j]){
						array_splice($sub,$j,1);
						$j--;
					}
				}
			}

			for($i =0; $i< count($sub); $i++){
				$sql2 = "INSERT INTO sales_maintain_product
				(maintain_seq,
				org_maintain_seq,
				forcasting_seq,
				product_code,
				product_supplier,
				product_count,
				product_serial,
				product_state,
				product_licence,
				product_version,
				product_purpose,
				product_host,
				maintain_begin,
				maintain_expire,
				maintain_yn,
				maintain_target,
				insert_date,
				custom_title,
				custom_detail,
				product_check_list) 
				SELECT {$seq} as maintain_seq,
				maintain_seq as org_maintain_seq,
				forcasting_seq,
				product_code,
				product_supplier,
				product_count,
				product_serial,
				product_state,
				product_licence,
				product_version,
				product_purpose,
				product_host,
				maintain_begin,
				maintain_expire,
				maintain_yn,
				maintain_target,
				insert_date,
				custom_title,
				custom_detail,
				product_check_list FROM sales_maintain_product WHERE maintain_seq = {$sub[$i]}";
				$query2 = $this->db->query($sql2);
			}

			$subProjectSeq = implode(',', $sub);
			if($subProjectSeq != ""){
				$subProjectSeq = ",".$subProjectSeq;
			}
			$sql1 = "UPDATE sales_maintain SET sub_project_add = concat(sub_project_add,'{$subProjectSeq}') WHERE seq = {$seq}";
		}
		$query2 = $this->db->query($sql1);

		return $query2;
	}

	//연계 프로젝트remove sub_project_add update문
	function sub_project_remove_update($subProjectSeq,$seq)
	{
		$sql = "select sub_project_add from sales_maintain where seq = {$seq}";
		$original_data = $this->db->query($sql)->row_array();
		$sub = explode(',',$original_data['sub_project_add']);
		$delete_sub_seq = explode(',',$subProjectSeq);
		for($i=0; $i<count($sub); $i++){
			for($j=0; $j<count($delete_sub_seq); $j++){
				if($sub[$i] == $delete_sub_seq[$j]){
					array_splice($sub,$i,1);
					$i--;
				}
			}
		}

		for($j=0; $j<count($delete_sub_seq); $j++){
			$sql2 = "delete from sales_maintain_product WHERE maintain_seq ={$seq} AND org_maintain_seq = {$delete_sub_seq[$j]}";
			$query2 = $this->db->query($sql2);
		}

		$subProjectSeq = implode(',', $sub);
		if($subProjectSeq != ""){
			$sql3 = "UPDATE sales_maintain SET sub_project_add = '{$subProjectSeq}' WHERE seq = {$seq}";

		}else{
			$sql3 = "UPDATE sales_maintain SET sub_project_add = null WHERE seq = {$seq}";
		}
		$this->db->query($sql3);

		//조회취소 후 장비유지보수 금액 합계 다시 계산하자
		$sql4="update sales_maintain X
		inner join (SELECT SUM(product_sales) AS forcasting_sales,SUM(product_purchase) AS forcasting_purchase,SUM(product_profit) AS forcasting_profit,maintain_seq FROM sales_maintain_product GROUP BY maintain_seq) Y 
		on X.seq = Y.maintain_seq
		set X.forcasting_sales = Y.forcasting_sales,
		X.forcasting_purchase = Y.forcasting_purchase,
		X.forcasting_profit = Y.forcasting_profit 
		WHERE X.seq = {$seq}";

		return $this->db->query($sql4);
	}

	// 유지보수 excel download
	function maintain_excel_download($searchkeyword,$cnum){
		if ($searchkeyword != "") {
			$searchstring='';
			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //고객사
				$searchstring = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
			}
			if(trim($searchkeyword[1])!=''){ //프로젝트명
				$searchstring .= " and sf.project_name like '%{$searchkeyword[1]}%'";
			}
			if(trim($searchkeyword[2])!=''){ //유지보수 시작일
				$searchstring .= " and sf.exception_saledate2 >= '{$searchkeyword[2]}'";
			}
			if(trim($searchkeyword[3])!=''){ //유지보수 종료일
				$searchstring .= " and sf.exception_saledate3 <= '{$searchkeyword[3]}'";
			}
			if(trim($searchkeyword[4])!=''){ //영업담당자(두리안)
				$searchstring .= " and sf.cooperation_username like '%{$searchkeyword[4]}%'";
			}
			if(trim($searchkeyword[5])!=''){//제조사
				$searchstring .= " and p.product_company like '%{$searchkeyword[5]}%'";
			}
			if(trim($searchkeyword[6])!=''){ //품목
				$searchstring .= " and p.product_item like '%{$searchkeyword[6]}%'";
			}
			if(trim($searchkeyword[7])!=''){ //제품명
				$searchstring .= " and p.product_name like '%{$searchkeyword[7]}%'";
			}
			if(trim($searchkeyword[8])!=''){ //관리팀
				$searchstring .= " and sf.manage_team = '{$searchkeyword[8]}'";
			}
			if(trim($searchkeyword[9])!=''){ //점검여부
				$searchstring .= " and sf.maintain_result = '{$searchkeyword[9]}'";
			}
			// if(trim($searchkeyword[10])!=''){ //판매종류
			// 	$searchstring .= " and sf.type = '{$searchkeyword[10]}'";
			// }
		} else {
			$searchstring = "";
		}

		if ($this->lv == 1) {
			// $sql = "select * from(select sf.seq,sf.type,sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2, sf.exception_saledate3, sf.company_num, sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code" . $searchstring . " and company_num = ? and progress_step>'014' and (sub_project_add not REGEXP sf.seq or sub_project_add IS NULL) order by replace(sf.exception_saledate2,'-','') DESC)a left join(SELECT sub_project_add,SUM(forcasting_sales) AS sum_forcasting_sales,SUM(forcasting_purchase) AS sum_forcasting_purchase,SUM(forcasting_profit) AS sum_forcasting_profit FROM sales_forcasting GROUP BY sub_project_add)b ON a.sub_project_add = b.sub_project_add";
			$sql = "select sf.seq, sf.forcasting_seq, sf.type,sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit from stc.sales_maintain sf, (select * from stc.sales_maintain_product group by maintain_seq) sp, stc.product p where sf.seq = sp.maintain_seq and p.seq = sp.product_code and company_num = '{$cnum}'" . $searchstring . "  order by replace(exception_saledate2,'-','') DESC";
			
			$query = $this->db->query($sql);
		} else {
			// $sql = "select * from(select sf.seq,sf.type,sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit from stc.sales_forcasting sf, (select * from stc.sales_forcasting_product group by forcasting_seq) sp, stc.product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code" . $searchstring . " and progress_step>'014' and (sub_project_add not REGEXP sf.seq or sub_project_add IS NULL) order by replace(sf.exception_saledate2,'-','') DESC)a left join (SELECT sub_project_add,SUM(forcasting_sales) AS sum_forcasting_sales,SUM(forcasting_purchase) AS sum_forcasting_purchase,SUM(forcasting_profit) AS sum_forcasting_profit FROM sales_forcasting GROUP BY sub_project_add)b ON a.sub_project_add = b.sub_project_add";
			$sql = "select sf.seq, sf.forcasting_seq, sf.type,sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit from stc.sales_maintain sf, (select * from stc.sales_maintain_product group by maintain_seq) sp, stc.product p where sf.seq = sp.maintain_seq and p.seq = sp.product_code" . $searchstring . "  order by replace(exception_saledate2,'-','') DESC";
			$query = $this->db->query($sql);
		}

		return array('count' => $query->num_rows(), 'data' => $query->result_array());
	}

	//유지보수 만료 30일전부터 가져오기
	function maintain_expiration_mail(){
		// $sql1 = "SELECT sf.*,p.product_name FROM sales_forcasting AS sf JOIN sales_forcasting_product AS sfp on sf.seq =sfp.forcasting_seq JOIN product AS p on sfp.product_code = p.seq WHERE sf.exception_saledate3 = DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 30 DAY), '%Y-%m-%d')";
				// $sql2 = "SELECT sf.*,p.product_name FROM sales_forcasting AS sf JOIN sales_forcasting_product AS sfp on sf.seq =sfp.forcasting_seq JOIN product AS p on sfp.product_code = p.seq WHERE sf.exception_saledate3 = DATE_FORMAT(NOW(),'%Y-%m-%d')";
		// $sql3 = "SELECT sf.*,p.product_name FROM sales_forcasting AS sf JOIN sales_forcasting_product AS sfp on sf.seq =sfp.forcasting_seq JOIN product AS p on sfp.product_code = p.seq WHERE DATE_FORMAT(DATE_ADD(sf.exception_saledate3,INTERVAL 15 DAY), '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')";
		//연계프로젝트는 부모의 프로젝트명과,유지보수기간 가져가기
		//제품까지 들고오는 쿼리
		// $sql1 ="SELECT * FROM (SELECT sf.*,p.product_name,
		// 		(select exception_saledate3 from sales_forcasting WHERE sub_project_add = (SELECT sub_project_add FROM sales_forcasting WHERE seq=sf.seq) AND sub_project_add NOT regexp seq AND sub_project_add IS NOT NULL) AS parent_exception_salesdate,
		// 		(select project_name from sales_forcasting WHERE sub_project_add = (SELECT sub_project_add FROM sales_forcasting WHERE seq=sf.seq) AND sub_project_add NOT regexp seq AND sub_project_add IS NOT NULL) AS parent_project_name
		// 		FROM sales_forcasting AS sf JOIN sales_forcasting_product AS sfp 
		// 		on sf.seq =sfp.forcasting_seq JOIN product AS p on sfp.product_code = p.seq) AS t 
		// 		WHERE
		// 		((t.parent_exception_salesdate IS NULL AND (t.exception_saledate3 <= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 30 DAY), '%Y-%m-%d')) AND t.exception_saledate3 >= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 16 DAY), '%Y-%m-%d') ) 
		// 		OR 
		// 		(t.parent_exception_salesdate IS not NULL AND (t.parent_exception_salesdate <= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 30 DAY), '%Y-%m-%d')) AND t.parent_exception_salesdate >= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 16 DAY), '%Y-%m-%d') ))";
		
		// $sql2 ="SELECT * FROM (SELECT sf.*,p.product_name,
		// (select exception_saledate3 from sales_forcasting WHERE sub_project_add = (SELECT sub_project_add FROM sales_forcasting WHERE seq=sf.seq) AND sub_project_add NOT regexp seq AND sub_project_add IS NOT NULL) AS parent_exception_salesdate,
		// (select project_name from sales_forcasting WHERE sub_project_add = (SELECT sub_project_add FROM sales_forcasting WHERE seq=sf.seq) AND sub_project_add NOT regexp seq AND sub_project_add IS NOT NULL) AS parent_project_name
		// FROM sales_forcasting AS sf JOIN sales_forcasting_product AS sfp 
		// on sf.seq =sfp.forcasting_seq JOIN product AS p on sfp.product_code = p.seq) AS t 
		// WHERE
		// ((t.parent_exception_salesdate IS NULL AND (t.exception_saledate3 <= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 15 DAY), '%Y-%m-%d')) AND t.exception_saledate3 >= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 0 DAY), '%Y-%m-%d') ) 
		// OR 
		// (t.parent_exception_salesdate IS not NULL AND (t.parent_exception_salesdate <= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 15 DAY), '%Y-%m-%d')) AND t.parent_exception_salesdate >= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 0 DAY), '%Y-%m-%d') ))";

		
		// $sql1 = "SELECT * FROM (SELECT sf.*,
		// (select exception_saledate3 from sales_forcasting WHERE sub_project_add = (SELECT sub_project_add FROM sales_forcasting WHERE seq=sf.seq) AND sub_project_add NOT regexp seq AND sub_project_add IS NOT NULL) AS parent_exception_salesdate,
		// (select project_name from sales_forcasting WHERE sub_project_add = (SELECT sub_project_add FROM sales_forcasting WHERE seq=sf.seq) AND sub_project_add NOT regexp seq AND sub_project_add IS NOT NULL) AS parent_project_name
		// FROM sales_forcasting AS sf) AS t 
		// WHERE
		// ((t.parent_exception_salesdate IS NULL AND (t.exception_saledate3 <= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 30 DAY), '%Y-%m-%d')) AND t.exception_saledate3 >= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 16 DAY), '%Y-%m-%d')) 
		// OR 
		// (t.parent_exception_salesdate IS not NULL AND (t.parent_exception_salesdate <= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 30 DAY), '%Y-%m-%d')) AND t.parent_exception_salesdate >= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 16 DAY), '%Y-%m-%d'))) ORDER BY t.exception_saledate3 desc";

		// $sql2 ="SELECT * FROM (SELECT sf.*,
		// (select exception_saledate3 from sales_forcasting WHERE sub_project_add = (SELECT sub_project_add FROM sales_forcasting WHERE seq=sf.seq) AND sub_project_add NOT regexp seq AND sub_project_add IS NOT NULL) AS parent_exception_salesdate,
		// (select project_name from sales_forcasting WHERE sub_project_add = (SELECT sub_project_add FROM sales_forcasting WHERE seq=sf.seq) AND sub_project_add NOT regexp seq AND sub_project_add IS NOT NULL) AS parent_project_name
		// FROM sales_forcasting AS sf) AS t 
		// WHERE
		// ((t.parent_exception_salesdate IS NULL AND (t.exception_saledate3 <= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 15 DAY), '%Y-%m-%d')) AND t.exception_saledate3 >= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 0 DAY), '%Y-%m-%d')) 
		// OR 
		// (t.parent_exception_salesdate IS not NULL AND (t.parent_exception_salesdate <= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 15 DAY), '%Y-%m-%d')) AND t.parent_exception_salesdate >= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 0 DAY), '%Y-%m-%d'))) ORDER BY t.exception_saledate3 desc";

		// $sql3="SELECT * FROM (SELECT sf.*,
		// (select exception_saledate3 from sales_forcasting WHERE sub_project_add = (SELECT sub_project_add FROM sales_forcasting WHERE seq=sf.seq) AND sub_project_add NOT regexp seq AND sub_project_add IS NOT NULL) AS parent_exception_salesdate,
		// (select project_name from sales_forcasting WHERE sub_project_add = (SELECT sub_project_add FROM sales_forcasting WHERE seq=sf.seq) AND sub_project_add NOT regexp seq AND sub_project_add IS NOT NULL) AS parent_project_name
		// FROM sales_forcasting AS sf) AS t
		// WHERE
		// ((t.parent_exception_salesdate IS NULL AND (t.exception_saledate3 < DATE_FORMAT(NOW(),'%Y-%m-%d'))) 
		// OR 
		// (t.parent_exception_salesdate IS not NULL AND (t.parent_exception_salesdate < DATE_FORMAT(NOW(),'%Y-%m-%d'))))
		// ORDER BY t.exception_saledate3 desc";

		$sql1= "select t1.seq as maintain_seq,t1.forcasting_seq ,t1. customer_companyname as customer,t1.customer_username, t1.exception_saledate2 as maintain_start, t1.exception_saledate3 as maintain_end , t1.project_name from sales_maintain AS t1,(select max(seq) as max_sort,forcasting_seq from sales_maintain group by forcasting_seq) as t2 
		where t1.seq = t2.max_sort 
		AND t1.exception_saledate3 <= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 30 DAY), '%Y-%m-%d') AND t1.exception_saledate3 >= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 16 DAY), '%Y-%m-%d')
		order by binary(customer_companyname)";

		$sql2 = "select t1.seq as maintain_seq,t1.forcasting_seq ,t1. customer_companyname as customer,t1.customer_username, t1.exception_saledate2 as maintain_start, t1.exception_saledate3 as maintain_end , t1.project_name from sales_maintain AS t1,(select max(seq) as max_sort,forcasting_seq from sales_maintain group by forcasting_seq) as t2 
		where t1.seq = t2.max_sort 
		AND t1.exception_saledate3 <= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 15 DAY), '%Y-%m-%d') AND t1.exception_saledate3 >= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 0 DAY), '%Y-%m-%d')
		order by binary(customer_companyname)";

		$sql3 = "select t1.seq as maintain_seq,t1.forcasting_seq ,t1. customer_companyname as customer,t1.customer_username, t1.exception_saledate2 as maintain_start, t1.exception_saledate3 as maintain_end , t1.project_name from sales_maintain AS t1,(select max(seq) as max_sort,forcasting_seq from sales_maintain group by forcasting_seq) as t2 
		where t1.seq = t2.max_sort AND t1.exception_saledate3 < DATE_FORMAT(NOW(),'%Y-%m-%d')
		order by binary(customer_companyname)";

		$query1 = $this->db->query($sql1);
		$query2 = $this->db->query($sql2);
		$query3 = $this->db->query($sql3);
		// $query3 = $this->db->query($sql3);

		return array('expiration30' => $query1->result_array(), 'expiration15' => $query2->result_array(),'after_expiration' => $query3->result_array());
	}

	// //제품 연도별 유지보수 정보 insert/modify/delete
	// function sales_maintain_product_period_action($type,$data){
	// 	if($type == 0){ // insert
	// 		return $this->db->insert('sales_maintain_product_period', $data);
	// 	}else if ($type == 1){ // modify
	// 		return $this->db->update('sales_maintain_product_period', $data , array('seq' => $data['seq']));
	// 	}else { // delete
	// 		return $this->db->delete('sales_maintain_product_period', $data);
	// 	}
	// }

	//연계프로젝트 뒷 수습좀 해봐...
	function hahaha(){
		$tlqkf = "update sales_maintain set sub_project_add = null";
		$this->db->query($tlqkf);
		$first = "UPDATE sales_forcasting SET sub_project_add = NULL WHERE sub_project_add IS NOT NULL AND  sub_project_add =''";
		$this->db->query($first);
		//연계프로젝트 부모새꾸 찾는거였
		$sql = "SELECT * from sales_forcasting WHERE sub_project_add IS NOT NULL AND sub_project_add NOT LIKE CONCAT('%',seq,'%')";
		$query = $this->db->query($sql);
		$sub_project = $query->result_array(); //부모들 

		for($i=0; $i<count($sub_project); $i++){
			// echo "<script>alert('{$i}')</script>";
			$sql1 = "select * from sales_maintain where forcasting_seq ='{$sub_project[$i]['seq']}'";//부모
			$query1 = $this->db->query($sql1);
			$parent_maintain = $query1->row_array();
			//아니아니? 우선 모든 sub_project_add를 null 시키자.
			// $update1 = "update sales_maintain set sub_project_add = null where seq ={$parent_maintain['seq']} ";
			// $this->db->query($update1);
			
			$sub_project_seq = explode(',',$sub_project[$i]['sub_project_add']);
			$sub_project_maintain_seq="";
			for($j=0; $j<count($sub_project_seq); $j++){
			  $sql2 = "select * from sales_maintain where forcasting_seq ={$sub_project_seq[$j]}";
			  $query2 = $this->db->query($sql2);
			  $sub_maintain = $query2->row_array();
			  if(!empty($sub_maintain)){
				$sub_project_maintain_seq .= ','.$sub_maintain['seq'];
				// $update2 = "update sales_maintain set sub_project_add = '{$parent_maintain['seq']}' where seq ={$sub_maintain['seq']} ";
				// $this->db->query($update2);
  
				$insert_product = "INSERT INTO sales_maintain_product
					  (maintain_seq,
					  org_maintain_seq,
					  forcasting_seq,
					  product_code,
					  product_supplier,
					  product_count,
					  product_serial,
					  product_state,
					  product_licence,
					  product_version,
					  product_purpose,
					  product_host,
					  maintain_begin,
					  maintain_expire,
					  maintain_yn,
					  maintain_target,
					  insert_date,
					  custom_title,
					  custom_detail,
					  product_check_list) 
					  SELECT 
					  {$parent_maintain['seq']} as maintain_seq,
					  {$sub_maintain['seq']} as org_maintain_seq,
					  {$sub_project_seq[$j]} as forcasting_seq,
					  product_code,
					  product_supplier,
					  product_count,
					  product_serial,
					  product_state,
					  product_licence,
					  product_version,
					  product_purpose,
					  product_host,
					  maintain_begin,
					  maintain_expire,
					  maintain_yn,
					  maintain_target,
					  insert_date,
					  custom_title,
					  custom_detail,
					  product_check_list FROM sales_maintain_product WHERE maintain_seq = {$sub_maintain['seq']}";
  
			  		 $result =  $this->db->query($insert_product);
			  }
			}

			$sub_project_maintain_seq = trim($sub_project_maintain_seq,',');
			$update2 = "update sales_maintain set sub_project_add = '{$sub_project_maintain_seq}' where seq ={$parent_maintain['seq']} ";
			$this->db->query($update2);
		}
		return $result;
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
	
	//세금계산서 저장/수정/삭제
	function maintain_sales_bill_save($data,$type){
		if($type == 0){//insert
			return $this->db->insert('sales_maintain_bill',$data);
		}else if($type == 1){//update
			return $this->db->update('sales_maintain_bill',$data, array('seq' => $data['seq']));
		}else{//delete
			$sql = "delete from sales_maintain_bill where seq in ($data)";
			return $this->db->query( $sql );
		}
	}
	
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

	//수주 여부 코멘트 insert
	function maintain_complete_status_comment_insert($data){
		return $this->db->insert('sales_maintain_complete_status_comment',$data);
	}

	//수주 여부 코멘트 delete
	function maintain_complete_status_comment_delete($seq){
		$sql = "delete FROM sales_maintain_complete_status_comment WHERE seq = '{$seq}';";
		$query = $this->db->query( $sql );
		return $query;
	}

	//수주여부 코멘트 첨부파일 삭제 delete
	function maintain_complete_status_filedel($seq){
		$sql = "update sales_maintain_complete_status_comment set file_change_name = ?, file_real_name = ? where seq = ?";
		$result = $this->db->query($sql, array('','',$seq));
		return $result;
	}


	//////////////////////////////////////  통합유지보수 /////////////////////////////////
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
		 		project_name,sales_companyname,sales_username,dept,sales_tel,sales_email,cooperation_companyname,cooperation_username,exception_saledate2,
				complete_status,company_num,write_id,insert_date,manage_team,maintain_cycle,maintain_date,maintain_user,maintain_type,maintain_result,maintain_comment,sub_project_add)
				select forcasting_seq,customer_companyname,customer_username,customer_tel,customer_email,
		 		'{$project_name}' as project_name,sales_companyname,sales_username,dept,sales_tel,sales_email,cooperation_companyname,cooperation_username, DATE_ADD(exception_saledate3, INTERVAL 1 DAY) as exception_saledate2,
				complete_status,company_num,write_id, now() as insert_date,manage_team,maintain_cycle,maintain_date,maintain_user,maintain_type,maintain_result,maintain_comment,sub_project_add from sales_maintain where seq = {$maintain_seq}";
		$this->db->query( $sql );
		$renewal_seq  = $this->db->insert_id();

		if($integration_maintain == "true"){
			$sql2 = "INSERT INTO sales_maintain_product (maintain_seq,org_maintain_seq,forcasting_seq,integration_maintain_seq,integration_maintain_product_seq,product_code,product_supplier,
			product_serial,product_state,product_licence,product_version,product_purpose,product_host,maintain_yn,maintain_target,insert_date,product_check_list) 
			SELECT {$renewal_seq} as maintain_seq,org_maintain_seq,forcasting_seq,integration_maintain_seq,integration_maintain_product_seq,product_code,product_supplier,
			product_serial,product_state,product_licence,product_version,product_purpose,product_host,maintain_yn,maintain_target,now() as insert_date,product_check_list from sales_maintain_product WHERE maintain_seq = {$maintain_seq}";
		}else{
			$sql2 = "INSERT INTO sales_maintain_product (maintain_seq,org_maintain_seq,forcasting_seq,integration_maintain_seq,integration_maintain_product_seq,product_code,product_supplier,
			product_serial,product_state,product_licence,product_version,product_purpose,product_host,maintain_yn,maintain_target,insert_date,product_check_list) 
			SELECT {$renewal_seq} as maintain_seq,org_maintain_seq,forcasting_seq,integration_maintain_seq,integration_maintain_product_seq,product_code,product_supplier,
			product_serial,product_state,product_licence,product_version,product_purpose,product_host,maintain_yn,maintain_target,now() as insert_date,product_check_list from sales_maintain_product WHERE maintain_seq = {$maintain_seq} and (integration_maintain_seq ='' || integration_maintain_seq is null) and (integration_maintain_product_seq ='' || integration_maintain_product_seq is null) ";
		}
		$result = $this->db->query( $sql2 );

		$sql3= "INSERT INTO sales_maintain_mcompany (maintain_seq,forcasting_seq,main_companyname,main_username,main_tel,main_email,insert_date)
		SELECT {$renewal_seq} as maintain_seq,forcasting_seq,main_companyname,main_username,main_tel,main_email,now() insert_date from sales_maintain_mcompany WHERE maintain_seq ={$maintain_seq}";
		
		$result = $this->db->query( $sql3 );
		return $renewal_seq;
	}
}