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

		$this->load->Model('sales/STC_Bill_fund_link');
	}

	// 포캐스팅 기본사항 추가및 수정
	function maintain_insert($data,$seq,$data_type){
		$result='';
		if($data_type == '1'){//고객사
			$result =  $this->db->update('sales_maintain', $data, array('seq' => $seq));
		}else if($data_type == '2'){//영업
			$result =  $this->db->update('sales_maintain', $data, array('seq' => $seq));
		}else if($data_type == '3'){//매출
			$sql = "select * from sales_maintain where seq = {$seq}";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				$before_data = $query->row_array();
			}
			//매출처 이름 다르면 다시 넣어주는고야!
			if($before_data['sales_companyname'] != $data['sales_companyname']){
				$sql = "update sales_maintain_bill set company_name = '{$data['sales_companyname']}' where maintain_seq = {$seq} and type='001'";
				$this->db->query($sql);
			}

			// //납부회차 달라졌을때 세금계산서도 수정되게(잘못 수정했을때 쫌 위험할듯)
			// $bill_sql = "select * from sales_maintain_bill where maintain_seq = {$seq} and type='001' order by pay_session";
			// $bill_query = $this->db->query($bill_sql);

			// if ($bill_query->num_rows() > 0) {
			// 	$bill = $bill_query -> result_array();
			// 	$before_max_session = $bill[(count($bill)-1)];
			// 	if($before_data['sales_pay_session'] != $data['sales_pay_session']){
			// 		if($before_data['sales_pay_session'] > $data['sales_pay_session']){ //줄어들어야할때
			// 			$delete_sql = "delete from sales_maintain_bill where maintain_seq = {$seq} and pay_session > {$data['sales_pay_session']} and issuance_status != 'Y' and type ='001' ";
			// 			$this->db->query($delete_sql);
			// 		}else if($before_max_session['pay_session'] < $data['sales_pay_session']){ // 늘어나야할때
			// 			for($i=($before_max_session['pay_session']+1); $i <= $data['sales_pay_session'] ; $i++){
			// 				$insert_sql = "insert into sales_maintain_bill (maintain_seq, type, company_name, pay_session,insert_date) values ('{$seq}','001','{$data['sales_companyname']}','{$i}',now()) ";
			// 				$this->db->query($insert_sql);
			// 			}
			// 		}
			// 	}
			// }else{
			// 	$bill_sql = "select * from sales_maintain_bill where maintain_seq = {$seq}";
			// 	$bill_query = $this->db->query($bill_sql);

			// 	if ($bill_query->num_rows() > 0) {
			// 		for($i=1; $i <= $data['sales_pay_session']; $i++){
			// 			$insert_sql = "insert into sales_maintain_bill (maintain_seq, type, company_name, pay_session,insert_date) values ('{$seq}','001','{$data['sales_companyname']}','{$i}',now()) ";
			// 			$this->db->query($insert_sql);
			// 		}
			// 	}
			// }

			$result =  $this->db->update('sales_maintain', $data, array('seq' => $seq));
		}else if($data_type == '4'){//매입
			//forcasting_mcompany_delete
			$delete_main_array = explode(",", $data['delete_main_array']);

			for($i=1; $i<count($delete_main_array); $i++){
				$sql = "delete from sales_maintain_bill where maintain_seq = (select maintain_seq from sales_maintain_mcompany where seq = {$delete_main_array[$i]}) and type='002' and company_name = (select main_companyname from sales_maintain_mcompany where seq = {$delete_main_array[$i]})";
				$this->db->query($sql);
				$sql1 = "delete from sales_maintain_mcompany where seq = {$delete_main_array[$i]}";
				$result = $this->db->query($sql1);
			}

			//maintain_mcompany insert
			$insert_main_array = explode("||", $data['insert_main_array']);

			for ($i = 1; $i < count($insert_main_array); $i++) {
				$main_list = explode("~", $insert_main_array[$i]);

				$sql4 = "insert into sales_maintain_mcompany (maintain_seq,forcasting_seq,main_companyname,main_username,main_tel,main_email,insert_date) values({$seq},";
				for($j=0; $j<count($main_list); $j++){
					$sql4 .= "'{$main_list[$j]}',";
				}
				$sql4 .= "now())";
				$result = $this->db->query($sql4);

				// $bill_sql = "select * from sales_maintain_bill where maintain_seq = {$seq} ";
				// $bill_query = $this->db->query($bill_sql);
				// if ($bill_query->num_rows() > 0) {
				// 	for($k=1; $k <= $main_list[5] ; $k++){
				// 		$insert_sql = "insert into sales_maintain_bill (maintain_seq, type, company_name, pay_session,insert_date) values ('{$seq}','002','{$main_list[1]}','{$k}',now()) ";
				// 		$this->db->query($insert_sql);
				// 	}
				// }
			}

			//forcasting_mcompany 업데이트
			$update_main_array = explode("||", $data['update_main_array']);

			$update_column = explode(",","main_companyname,main_username,main_tel,main_email");

			for ($i = 1; $i < count($update_main_array); $i++) {
				$main_list = explode("~", $update_main_array[$i]);
				//수정전에 데이터가져오기
				$sql = "select * from sales_maintain_mcompany where seq = {$main_list[count($update_column)]}";
				$query = $this->db->query($sql);
				if ($query->num_rows() > 0) {
					$before_data = $query->row_array();
				}

				//매입처 이름 달라져쓸때 세금계싼서랑 제품에서도 바꿔졍
				if($before_data['main_companyname'] != $main_list[0]){
					$sql = "update sales_maintain_bill set company_name = '{$main_list[0]}' where maintain_seq = {$seq} and type='002' and company_name = '{$before_data['main_companyname']}'";
					$sql2= "update sales_maintain_product set product_supplier = '{$main_list[0]}' where maintain_seq = {$seq}  and product_supplier = '{$before_data['main_companyname']}' ";
					$this->db->query($sql);
					$this->db->query($sql2);
				}
				// $bill_sql = "select * from sales_maintain_bill where maintain_seq = {$seq} and type='002' and company_name = '{$main_list[0]}' order by pay_session";
				// $bill_query = $this->db->query($bill_sql);
				// if ($bill_query->num_rows() > 0) {
				// 	$bill = $bill_query -> result_array();
				// 	$before_max_session = $bill[(count($bill)-1)];
				// 	if($before_data['purchase_pay_session'] != $main_list[4]){
				// 		if($before_data['purchase_pay_session'] > $main_list[4]){ //줄어들어야할때
				// 			$delete_sql = "delete from sales_maintain_bill where maintain_seq = {$seq} and pay_session > {$main_list[4]} and issuance_status != 'Y' and company_name = '{$main_list[0]}' and type='002' ";
				// 			$this->db->query($delete_sql);
				// 		}else if($before_max_session['pay_session'] < $main_list[4]){ // 늘어나야할때
				// 			for($k=($before_max_session['pay_session']+1); $k <= $main_list[4] ; $k++){
				// 				$insert_sql = "insert into sales_maintain_bill (maintain_seq, type, company_name, pay_session,insert_date) values ('{$seq}','002','{$main_list[0]}','{$k}',now()) ";
				// 				$this->db->query($insert_sql);
				// 			}
				// 		}
				// 	}
				// }else{
				// 	$bill_sql = "select * from sales_maintain_bill where maintain_seq = {$seq} ";
				// 	$bill_query = $this->db->query($bill_sql);
				// 	if ($bill_query->num_rows() > 0) {
				// 		for($k=1; $k <= $main_list[4] ; $k++){
				// 			$insert_sql = "insert into sales_maintain_bill (maintain_seq, type, company_name, pay_session,insert_date) values ('{$seq}','002','{$main_list[0]}','{$k}',now()) ";
				// 			$this->db->query($insert_sql);
				// 		}
				// 	}
				// }

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

			for ($i = 1; $i < count($update_product_array); $i++) {
				$product_list = explode("~", $update_product_array[$i]);
				$update_column = array(
					'product_code' => $product_list[0],
					'product_supplier' => $product_list[1],
					'product_licence' => $product_list[2],
					'product_serial' => $product_list[3],
					'product_state' => $product_list[4],
					'maintain_begin' => $product_list[5],
					'maintain_expire' => $product_list[6],
					'maintain_yn' => $product_list[7],
					'maintain_target' => $product_list[8],
					'product_sales' => $product_list[9],
					'product_purchase' => $product_list[10],
					'product_profit' => $product_list[11],
					'comment' => $product_list[12],
					'seq' => $product_list[13],
					'update_date' => date("Y-m-d H:i:s")
				);

				$integration_check = "select * from sales_maintain_product where seq = {$product_list[13]}";
				$query = $this->db->query($integration_check);

				if ($query->num_rows() > 0) {
					$update_data = $query->row_array();
				}

				//유지보수 제품 수정
				if($update_data['integration_maintain_product_seq'] == null || $update_data['integration_maintain_product_seq'] == ""){
					$result =  $this->db->update('sales_maintain_product', $update_column, array('seq' => $update_column['seq']));
				}else{//통합유지보수 제품 일 때 product_code 수정 x
					$result =  $this->db->update('sales_maintain_product', $update_column, array('seq' => $update_column['seq']));
					unset($update_column['product_code']);
					$update_column['seq'] = $update_data['integration_maintain_product_seq'];
					$result =  $this->db->update('sales_integration_maintain_product', $update_column, array('seq' => $update_column['seq']));
				}

			}

			//제품 insert
			$insert_product_array = explode("||", $data['insert_product_array']);
			for ($i = 1; $i < count($insert_product_array); $i++) {
				$product_list = explode("~", $insert_product_array[$i]);

				$insert_column = array(
					'maintain_seq' => $product_list[0],
					'org_maintain_seq' => $product_list[1],
					'forcasting_seq' => $product_list[2],
					'product_code' => $product_list[3],
					'product_supplier' => $product_list[4],
					'product_licence' => $product_list[5],
					'product_serial' => $product_list[6],
					'product_state' => $product_list[7],
					'maintain_begin' => $product_list[8],
					'maintain_expire' => $product_list[9],
					'maintain_yn' => $product_list[10],
					'maintain_target' => $product_list[11],
					'product_sales' => $product_list[12],
					'product_purchase' => $product_list[13],
					'product_profit' => $product_list[14],
					'comment' => $product_list[15],
					'insert_date' => date("Y-m-d H:i:s")
				);

				$result = $this->db->insert('sales_maintain_product', $insert_column);
			}

			//나머지~고객사총매출가랑 이론거
			$sql =  "update sales_maintain set forcasting_sales=?,forcasting_purchase=?,forcasting_profit=?,division_month=?,exception_saledate2=?,exception_saledate3=?,write_id=?,update_date=? where seq=?";
			$result = $this->db->query($sql, array($data['forcasting_sales'], $data['forcasting_purchase'], $data['forcasting_profit'], $data['division_month'], $data['exception_saledate2'], $data['exception_saledate3'], $data['write_id'], $data['update_date'],$seq));

		}else if($data_type == '6'){//수주
			$result =  $this->db->update('sales_maintain', $data, array('seq' => $seq));

		}else if($data_type == '7'){//점검
			$result =  $this->db->update('sales_maintain', $data, array('seq' => $seq));
		}else if ($data_type == '8'){//세금계산서
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

	//	유지보수 제품 가져오기(제품명)
	function maintain_view3($seq = 0)
	{
		// $sql = "(select sp.seq,sp.integration_maintain_seq, sp.product_code, (SELECT project_name FROM sales_forcasting WHERE seq = (SELECT forcasting_seq FROM sales_maintain WHERE seq = sp.org_maintain_seq )) AS project_name,(SELECT exception_saledate FROM sales_maintain WHERE seq = sp.org_maintain_seq ) AS exception_saledate, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, p.product_company, p.product_type, p.product_name, sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit from sales_maintain_product sp, product p where sp.product_code = p.seq and sp.maintain_seq = {$seq} order by sp.seq asc, p.product_company DESC)
		// 		UNION
		// 		(select sp.seq,sp.integration_maintain_seq, sp.product_code,(SELECT project_name FROM sales_integration_maintain WHERE seq = sp.integration_maintain_seq ) AS project_name,(SELECT exception_saledate FROM sales_maintain WHERE seq = sp.org_maintain_seq ) AS exception_saledate, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, ip.product_company, ip.product_type, ip.product_name, sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit from sales_maintain_product sp, sales_integration_maintain_product ip where ip.seq = sp.integration_maintain_product_seq and sp.maintain_seq = {$seq} order by ip.product_company DESC,sp.seq asc)";
		$sql = "select sp.seq,sp.integration_maintain_seq, sp.product_code, (SELECT project_name FROM sales_forcasting WHERE seq = (SELECT forcasting_seq FROM sales_maintain WHERE seq = sp.org_maintain_seq )) AS project_name,(SELECT exception_saledate FROM sales_maintain WHERE seq = sp.org_maintain_seq ) AS exception_saledate, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, p.product_company, p.product_type, p.product_name, sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit,sp.comment from sales_maintain_product sp, product p where sp.product_code = p.seq and sp.maintain_seq = {$seq} order by project_name ,sp.seq ";
		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//	통합 유지보수 제품 가져오기(제품명)
	function maintain_view5($seq = 0)
	{
		$sql = "select sp.seq,sp.integration_maintain_seq, sp.product_code,(SELECT project_name FROM sales_integration_maintain WHERE seq = sp.integration_maintain_seq ) AS project_name,(SELECT exception_saledate FROM sales_maintain WHERE seq = sp.org_maintain_seq ) AS exception_saledate, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, ip.product_company, ip.product_type, ip.product_name, sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit,sp.comment from sales_maintain_product sp, sales_integration_maintain_product ip where ip.seq = sp.integration_maintain_product_seq and sp.maintain_seq = {$seq} order by project_name ,sp.seq";
		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//	유지보수 제품 프로젝트명 가져오기(제품명)
	function maintain_view4($seq = 0)
	{
		$sql = "SELECT t.* FROM ((select sp.seq,(SELECT project_name FROM sales_forcasting WHERE seq = (SELECT forcasting_seq FROM sales_maintain WHERE seq = sp.org_maintain_seq )) AS project_name from sales_maintain_product sp, product p where sp.product_code = p.seq and sp.maintain_seq = {$seq})
		UNION
		(select sp.seq ,(SELECT project_name FROM sales_integration_maintain WHERE seq = sp.integration_maintain_seq ) AS project_name from sales_maintain_product sp, sales_integration_maintain_product ip where ip.seq = sp.integration_maintain_product_seq and sp.maintain_seq = {$seq})
		)AS t group by project_name order BY t.seq asc";

		$query = $this->db->query($sql, $seq);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//매입처별로 그룹바이해서 금액 카운트해
	function maintain_view6($seq = 0){
		$sql = "SELECT *,SUM(product_purchase) as total,COUNT(*) as product_cnt,SUM(distinct(product_r)) AS product_row
		FROM ((select sp.seq,sp.integration_maintain_seq, sp.product_code, (SELECT project_name FROM sales_forcasting WHERE seq = (SELECT forcasting_seq FROM sales_maintain WHERE seq = sp.org_maintain_seq )) AS project_name,(SELECT exception_saledate FROM sales_maintain WHERE seq = sp.org_maintain_seq ) AS exception_saledate, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, p.product_company, p.product_type, p.product_name, sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit,sp.comment,
		(select COUNT(*) FROM ( SELECT * FROM sales_maintain_product WHERE maintain_seq = {$seq} GROUP BY product_code) AS z where product_supplier = sp.product_supplier) as product_r
		from sales_maintain_product sp, product p where sp.product_code = p.seq and sp.maintain_seq = {$seq} order by project_name ,sp.seq)
		UNION
		(select sp.seq,sp.integration_maintain_seq, sp.product_code,(SELECT project_name FROM sales_integration_maintain WHERE seq = sp.integration_maintain_seq ) AS project_name,(SELECT exception_saledate FROM sales_maintain WHERE seq = sp.org_maintain_seq ) AS exception_saledate, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, ip.product_company, ip.product_type, ip.product_name, sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit,sp.comment,
		(select COUNT(*) FROM (SELECT * FROM (select sp.seq,sp.integration_maintain_seq, sp.product_code,(SELECT project_name FROM sales_integration_maintain WHERE seq = sp.integration_maintain_seq ) AS project_name,(SELECT exception_saledate FROM sales_maintain WHERE seq = sp.org_maintain_seq ) AS exception_saledate, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, ip.product_company, ip.product_type, ip.product_name, sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit,sp.comment from sales_maintain_product sp, sales_integration_maintain_product ip where ip.seq = sp.integration_maintain_product_seq and sp.maintain_seq = {$seq} order by project_name ,sp.seq
		) AS t GROUP BY product_name) AS z where product_supplier = sp.product_supplier) as product_r
		from sales_maintain_product sp, sales_integration_maintain_product ip where ip.seq = sp.integration_maintain_product_seq and sp.maintain_seq = {$seq} order by project_name ,sp.seq)
		) AS ut GROUP BY ut.product_supplier";

		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}



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

	// 유지보수 검색 조건 생성 함수
	function maintain_search($search_mode, $searchkeyword, $page='', $mode='') {
		if ($searchkeyword != "") {
			$searchstring='';
			$searchkeyword = explode(',',$searchkeyword);
			$search_columns = array();
			if($search_mode == 'detail') {
				if(trim($searchkeyword[0])!=''){ //고객사
					$searchstring = " and customer_companyname like '%{$searchkeyword[0]}%'";
					array_push($search_columns, '고객사');
				}
				if(trim($searchkeyword[1])!=''){ //프로젝트명
					$searchstring .= " and project_name like '%{$searchkeyword[1]}%'";
					array_push($search_columns, '프로젝트명');
				}
				if(trim($searchkeyword[2])!=''){ //유지보수 시작일
					$searchstring .= " and exception_saledate2 between '{$searchkeyword[2]}' and '{$searchkeyword[16]}'";
					array_push($search_columns, '유지보수시작일');
				}
				if(trim($searchkeyword[3])!=''){ //유지보수 종료일
					$searchstring .= " and exception_saledate3 between '{$searchkeyword[3]}' and '{$searchkeyword[17]}'";
					array_push($search_columns, '유지보수종료일');
				}
				if(trim($searchkeyword[4])!=''){ //영업담당자(두리안)
					$searchstring .= " and cooperation_username like '%{$searchkeyword[4]}%'";
					array_push($search_columns, '영업담당자');
				}
				if(trim($searchkeyword[5])!=''){//제조사
					$searchstring .= " and product_company like '%{$searchkeyword[5]}%'";
					array_push($search_columns, '제조사');
				}
				if(trim($searchkeyword[6])!=''){ //품목
					$searchstring .= " and product_item like '%{$searchkeyword[6]}%'";
					array_push($search_columns, '품목');
				}
				if(trim($searchkeyword[7])!=''){ //제품명
					$searchstring .= " and product_name like '%{$searchkeyword[7]}%'";
					array_push($search_columns, '제품명');
				}
				if(trim($searchkeyword[8])!=''){ //관리팀
					$searchstring .= " and manage_team = '{$searchkeyword[8]}'";
					array_push($search_columns, '관리팀');
				}

				if(trim($searchkeyword[15])!=''){ //영업부서
					$searchstring .= " and sf.dept like '%{$searchkeyword[15]}%'";
					array_push($search_columns, '영업부서');
				}

				if(trim($searchkeyword[9])!=''){ //점검여부
					$searchstring .= " and maintain_result = '{$searchkeyword[9]}'";
					array_push($search_columns, '점검여부');
				}
				if(trim($searchkeyword[10])!=''){ // 계산서 발행 단계
					if($searchkeyword[10] == 0){
						$searchstring .= " and bill_progress_step = 0";
					}else if($searchkeyword[10] == 1){
						$searchstring .= " and bill_progress_step > 0 and bill_progress_step < sales_pay_session";
					}else{
						$searchstring .= " and bill_progress_step > 0 and bill_progress_step = sales_pay_session";
					}
					array_push($search_columns, '계산서발행');
				}
				if(trim($searchkeyword[11])!=''){ //정보통신공사업
					$searchstring .= " and infor_comm_corporation = '{$searchkeyword[11]}'";
					array_push($search_columns, '정보통신공사업');
				}

				//매출금액 검색
				if(trim($searchkeyword[12])!=''){
					$searchstring .= " and forcasting_sales >= {$searchkeyword[12]}";
				}

				if(trim($searchkeyword[13])!=''){
					$searchstring .= " and forcasting_sales <= {$searchkeyword[13]}";
				}

				if(trim($searchkeyword[12])!='' || trim($searchkeyword[13])!= '') {
					array_push($search_columns, '매출금액');
				}

				if(trim($searchkeyword[14])!=''){ // 매출처
					$searchstring .= " and sales_companyname like '%{$searchkeyword[14]}%'";
					array_push($search_columns, '매출처');
				}


			} else if ($search_mode == 'simple') {

				if(trim($searchkeyword[0])!=''){ //관리팀
					$searchstring .= " and manage_team = '{$searchkeyword[0]}'";
					array_push($search_columns, '관리팀');
				}
				if(trim($searchkeyword[1])!=''){ //점검여부
					$searchstring .= " and maintain_result = '{$searchkeyword[1]}'";
					array_push($search_columns, '점검여부');
				}
				if(trim($searchkeyword[2])!=''){ // 계산서 발행 단계
					if($searchkeyword[2] == 0){
						$searchstring .= " and bill_progress_step = 0";
					}else if($searchkeyword[2] == 1){
						$searchstring .= " and bill_progress_step > 0 and bill_progress_step < sales_pay_session";
					}else{
						$searchstring .= " and bill_progress_step > 0 and bill_progress_step = sales_pay_session";
					}
					array_push($search_columns, '계산서발행');
				}
				if(trim($searchkeyword[3])!=''){ //정보통신공사업
					$searchstring .= " and infor_comm_corporation = '{$searchkeyword[3]}'";
					array_push($search_columns, '정보통신공사업');
				}
				if(trim($searchkeyword[4])!=''){ //유지보수 시작일
					$searchstring .= " and exception_saledate2 >= '{$searchkeyword[4]}'";
					array_push($search_columns, '유지보수시작일');
				}
				if(trim($searchkeyword[5])!=''){ //유지보수 종료일
					$searchstring .= " and exception_saledate3 <= '{$searchkeyword[5]}'";
					array_push($search_columns, '유지보수종료일');
				}
				//매출금액 검색
				if(trim($searchkeyword[6])!=''){
					$searchstring .= " and forcasting_sales >= {$searchkeyword[6]}";
				}

				if(trim($searchkeyword[7])!=''){
					$searchstring .= " and forcasting_sales <= {$searchkeyword[7]}";
				}

				if(trim($searchkeyword[6])!='' || trim($searchkeyword[7])!= '') {
					array_push($search_columns, '매출금액');
				}

				if(trim($searchkeyword[8])!=''){
					$searchstring .= " and (";
					$searchstring .= " customer_companyname like '%{$searchkeyword[8]}%' || project_name like '%{$searchkeyword[8]}%' || cooperation_username like '%{$searchkeyword[8]}%' || product_company like '%{$searchkeyword[8]}%' || product_item like '%{$searchkeyword[8]}%' || product_name like '%{$searchkeyword[8]}%' || sales_companyname like '%{$searchkeyword[8]}%'";
					$searchstring .= " )";
					array_push($search_columns, '통합검색');
				}

			}

			$searchstring = ltrim($searchstring,' and');
			$searchstring = "where ".$searchstring;

			if ($page != '' && $mode == 'list') {
				$this->search_count($search_columns, $page);
			}

		} else {
			$searchstring = "";
		}

		return $searchstring;
	}

	function search_count($search_columns, $page) {
		foreach($search_columns as $sc) {
			$sql = "SELECT * from search_columns_count where page = '{$page}' and target = '{$sc}'";
			$result = $this->db->query($sql);
			if( $result->num_rows() == 0 ) {
				$sql = "INSERT INTO search_columns_count (page, target, count) values ('{$page}', '{$sc}', 1)";
				$this->db->query($sql);
			} else {
				$sql = "UPDATE search_columns_count set count = count + 1 where page = '{$page}' and target = '{$sc}'";
				$this->db->query($sql);
			}
		}
	}

	// 유지보수 리스트
	function maintain_list($search_mode,$type, $type2, $searchkeyword , $start_limit = 0, $offset = 0, $cnum, $mode=''){
		if($type=='001' || $type == '003') {
			$page = 'maintain';
		} else {
			$page = 'intergrated maintain';
		}

		if($type == '003') {
			$forcasting = " where s.progress_step <= '014' or s.progress_step is null or s.progress_step = '' ";
		} else {
			$forcasting = " where s.progress_step > '014' ";
		}

		$sub_sql = "SELECT GROUP_CONCAT(sub_project_add SEPARATOR ',') AS seq FROM sales_maintain ORDER BY sub_project_add";
		$sub_query = $this->db->query($sub_sql);
		$sub_seq = $sub_query->row_array();
		$sub_seq = $sub_seq['seq'];

		$forcasting .= " AND s.seq NOT IN ({$sub_seq}) || s.seq = 401 || s.seq = 731";

		$searchstring = $this->maintain_search($search_mode, $searchkeyword, $page, $mode);

		if($type == "001"){
			if($type2 == 'list') {
				$f_sql = 'SELECT sf.seq, sf.generate_type, sf.forcasting_seq, sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.sales_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase, sf.forcasting_profit, sf.sales_pay_session,sf.bill_progress_step, sf.dept';
			}
			if ($type2 == 'sum') {
				$f_sql = 'SELECT SUM(IFNULL(sf.forcasting_sales,0)) AS forcasting_sales, SUM(IFNULL(sf.forcasting_purchase,0)) AS forcasting_purchase, SUM(IFNULL(sf.forcasting_profit,0)) AS forcasting_profit';
			}
			if ($type2 == 'count') {
				$f_sql = 'SELECT count(sf.seq) as cnt';
			}
		    $sql = " FROM (SELECT *,(SELECT count(*) FROM sales_maintain_bill WHERE maintain_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_maintain AS s {$forcasting}) sf
					join
					(SELECT a.* FROM(SELECT maintain_seq,product_code FROM sales_maintain_product group by maintain_seq) AS a
					left JOIN
					(select maintain_seq from sales_maintain_product WHERE integration_maintain_seq IS not null group by maintain_seq) AS b
					ON a.maintain_seq = b.maintain_seq
					WHERE b.maintain_seq IS NULL) sp
					on sf.seq = sp.maintain_seq
					left join stc.product p on p.seq = sp.product_code " . $searchstring . " order by replace(exception_saledate2,'-','') DESC, exception_saledate3 ASC";
				$sql = $f_sql.$sql;
		}else if ($type == '002'){

			if($type2 == 'list') {
				$f_sql = 'SELECT sf.seq, sf.generate_type, sf.forcasting_seq, sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.sales_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase, sf.forcasting_profit, sf.sales_pay_session,sf.bill_progress_step,sf.dept';
			}
			if ($type2 == 'sum') {
				$f_sql = 'SELECT SUM(IFNULL(sf.forcasting_sales,0)) AS forcasting_sales, SUM(IFNULL(sf.forcasting_purchase,0)) AS forcasting_purchase, SUM(IFNULL(sf.forcasting_profit,0)) AS forcasting_profit';
			}
			if ($type2 == 'count') {
				$f_sql = 'SELECT count(sf.seq) as cnt';
			}

			$sql = " FROM (SELECT *,(SELECT count(*) FROM sales_maintain_bill WHERE maintain_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_maintain AS s {$forcasting}) sf
					join
					(select * from stc.sales_maintain_product WHERE integration_maintain_seq IS not null group by maintain_seq) sp
					on sf.seq = sp.maintain_seq
					left join stc.sales_integration_maintain_product p on p.seq = sp.integration_maintain_product_seq " . $searchstring . " order by replace(exception_saledate2,'-','') DESC, exception_saledate3 ASC";
			$sql = $f_sql.$sql;


		} else if ($type == '003') {


			if($type2 == 'list') {
				$f_sql1 = 'SELECT sf.seq, sf.generate_type, sf.forcasting_seq, sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.sales_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase, sf.forcasting_profit, sf.sales_pay_session,sf.bill_progress_step, sf.dept';
			}
			if ($type2 == 'sum') {
				$f_sql1 = 'SELECT SUM(IFNULL(sf.forcasting_sales,0)) AS forcasting_sales, SUM(IFNULL(sf.forcasting_purchase,0)) AS forcasting_purchase, SUM(IFNULL(sf.forcasting_profit,0)) AS forcasting_profit';
			}
			if ($type2 == 'count') {
				$f_sql1 = 'SELECT count(sf.seq) as cnt';
			}
		    $sql1 = " FROM (SELECT *,(SELECT count(*) FROM sales_maintain_bill WHERE maintain_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_maintain AS s {$forcasting}) sf
					join
					(SELECT a.* FROM(SELECT maintain_seq,product_code FROM sales_maintain_product group by maintain_seq) AS a
					left JOIN
					(select maintain_seq from sales_maintain_product WHERE integration_maintain_seq IS not null group by maintain_seq) AS b
					ON a.maintain_seq = b.maintain_seq
					WHERE b.maintain_seq IS NULL) sp
					on sf.seq = sp.maintain_seq
					left join stc.product p on p.seq = sp.product_code " . $searchstring;
				$sql1 = $f_sql1.$sql1;

				if($type2 == 'list') {
					$f_sql2 = 'SELECT sf.seq, sf.generate_type, sf.forcasting_seq, sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.sales_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase, sf.forcasting_profit, sf.sales_pay_session,sf.bill_progress_step,sf.dept';
				}
				if ($type2 == 'sum') {
					$f_sql2 = 'SELECT SUM(IFNULL(sf.forcasting_sales,0)) AS forcasting_sales, SUM(IFNULL(sf.forcasting_purchase,0)) AS forcasting_purchase, SUM(IFNULL(sf.forcasting_profit,0)) AS forcasting_profit';
				}
				if ($type2 == 'count') {
					$f_sql2 = 'SELECT count(sf.seq) as cnt';
				}

				$sql2 = " FROM (SELECT *,(SELECT count(*) FROM sales_maintain_bill WHERE maintain_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_maintain AS s {$forcasting}) sf
						join
						(select * from stc.sales_maintain_product WHERE integration_maintain_seq IS not null group by maintain_seq) sp
						on sf.seq = sp.maintain_seq
						left join stc.sales_integration_maintain_product p on p.seq = sp.integration_maintain_product_seq " . $searchstring;
				$sql2 = $f_sql2.$sql2;

				if($type2 == 'sum') {
					$sql = "SELECT SUM(IFNULL(t.forcasting_sales,0)) AS forcasting_sales, SUM(IFNULL(t.forcasting_purchase,0)) AS forcasting_purchase, SUM(IFNULL(t.forcasting_profit,0)) AS forcasting_profit FROM ".'(' . '('. $sql1 . ')' . ' union ' . '(' . $sql2 . ')' . ')t';
				} else if ($type2 == 'count') {
					$sql = "SELECT sum(t.cnt) as cnt FROM ".'(' . '('. $sql1 . ')' . ' union ' . '(' . $sql2 . ')' . ')t';
				} else {
					$sql = "SELECT * FROM ((". $sql1 . ')' . ' union ' . '(' . $sql2 . "))t order by replace(t.exception_saledate2,'-','') DESC, t.exception_saledate3 ASC";
				}
		}

		if ($offset <> 0){
			$sql = $sql . " limit ".$start_limit.", ".$offset;

		}
		$query = $this->db->query($sql);

		if($type2!='count') {
			return array('count' => $query->num_rows(), 'data' => $query->result_array());
		} else {
			return $query->row_array();
		}
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
	function sub_project_select($seq, $customer_seq){
	  if($customer_seq != null){
	    // $check_sql = "SELECT DISTINCT before_company_name FROM sales_customer_basic_history WHERE customer_seq = {$customer_seq}";
	    // $query = $this->db->query($check_sql);
	    // if($query->num_rows > 0){
	    //   $sql = "SELECT distinct a.seq, a.forcasting_seq, a.customer_companyname, a.project_name FROM sales_maintain AS a JOIN sales_customer_basic_history AS b ON a.customer_companyname = b.before_company_name WHERE b.customer_seq = '{$customer_seq}' AND a.seq != '{$seq}' AND a.seq GROUP BY a.project_name";
			//
	    // }else{
	    //   $sql = "SELECT seq, customer_companyname, project_name FROM sales_maintain WHERE customer_seq = '{$customer_seq}' and seq != '{$seq}' AND seq IN (SELECT MAX(seq) FROM sales_maintain GROUP BY forcasting_seq)";
	    // }

			$sql = "SELECT c.* FROM (SELECT distinct a.seq, a.forcasting_seq, a.customer_seq, a.customer_companyname, a.project_name FROM sales_maintain AS a JOIN sales_customer_basic_history AS b ON a.customer_companyname REGEXP b.before_company_name OR b.before_company_name REGEXP a.customer_companyname WHERE b.customer_seq = '{$customer_seq}' AND a.seq != '{$seq}' UNION ALL SELECT seq, forcasting_seq, customer_seq, customer_companyname, project_name FROM sales_maintain WHERE customer_seq = '{$customer_seq}' and seq != '{$seq}') AS c WHERE c.seq NOT REGEXP (SELECT IF(sub_project_add IS NULL ,',', REPLACE(sub_project_add,',','|')) FROM sales_maintain WHERE seq='{$seq}') GROUP BY project_name, forcasting_seq, customer_companyname";

	  }else{

	    $sql1 = " and customer_companyname REGEXP (SELECT customer_companyname FROM sales_maintain WHERE seq={$seq})";
	    $sql2 = " and customer_companyname REGEXP (SUBSTRING_INDEX((SELECT customer_companyname FROM sales_maintain WHERE seq={$seq}),'(',1)";

	    // $sql = "select seq,customer_companyname,project_name from sales_maintain where project_name <>(SELECT project_name FROM sales_maintain WHERE seq={$seq}) and (SELECT concat(IF(sub_project_add IS NULL ,'', sub_project_add),',') FROM sales_maintain WHERE seq='{$seq}') NOT LIKE CONCAT(seq,',') AND (SELECT forcasting_seq FROM sales_maintain WHERE seq='{$seq}') <> forcasting_seq and ((SELECT customer_companyname FROM sales_maintain WHERE seq={$seq}) not like '%(%'" . $sql1 . " or (SELECT customer_companyname FROM sales_maintain WHERE seq={$seq}) like '%(%'" . $sql2 . ")) order by replace(exception_saledate,'-','') ASC";

	    $sql = "SELECT uni.* FROM (select seq,forcasting_seq,customer_seq,customer_companyname,project_name,exception_saledate from sales_maintain where project_name <>(SELECT project_name FROM sales_maintain WHERE seq={$seq}) and (SELECT concat(IF(sub_project_add IS NULL ,'', sub_project_add),',') FROM sales_maintain WHERE seq='{$seq}') NOT LIKE CONCAT(seq,',') AND (SELECT forcasting_seq FROM sales_maintain WHERE seq='{$seq}') <> forcasting_seq and ((SELECT customer_companyname FROM sales_maintain WHERE seq={$seq}) not like '%(%'" . $sql1 . " or (SELECT customer_companyname FROM sales_maintain WHERE seq={$seq}) like '%(%'" . $sql2 . ")) UNION SELECT main.seq, main.forcasting_seq,main.customer_seq, main.customer_companyname, main.project_name, main.exception_saledate FROM (SELECT a.seq, a.forcasting_seq, b.customer_seq, a.customer_companyname, b.company_name, b.before_company_name FROM sales_maintain AS a JOIN sales_customer_basic_history AS b ON a.customer_companyname REGEXP b.before_company_name OR b.before_company_name REGEXP a.customer_companyname WHERE a.seq = {$seq})AS cs JOIN sales_maintain AS main ON cs.customer_seq = main.customer_seq OR cs.company_name REGEXP main.customer_companyname OR main.customer_companyname REGEXP cs.company_name) AS uni WHERE uni.seq != {$seq} AND uni.seq NOT REGEXP (SELECT IF(sub_project_add IS NULL ,',', REPLACE(sub_project_add,',','|')) FROM sales_maintain WHERE seq='{$seq}') GROUP BY project_name order by replace(exception_saledate,'-','') ASC";
	  }

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
	function maintain_excel_download($search_mode,$type,$searchkeyword,$cnum){

		$searchstring = $this->maintain_search($search_mode, $searchkeyword);

		if($type == "001"){
			// $sql = "select * FROM (select sf.seq, sf.forcasting_seq, sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase, sf.forcasting_profit, sf.sales_pay_session,sf.bill_progress_step from (SELECT *,(SELECT count(*) FROM sales_maintain_bill WHERE maintain_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_maintain AS s) sf left join (select * from stc.sales_maintain_product group by maintain_seq) sp on sf.seq = sp.maintain_seq left join stc.product p on p.seq = sp.product_code ) as mt left join (SELECT * from sales_maintain_product WHERE integration_maintain_seq IS NOT NULL) AS smp on mt.seq= smp.maintain_seq group by mt.seq) as tt " . $searchstring . " order by replace(exception_saledate2,'-','') DESC, exception_saledate3 asc";
		    $sql = "SELECT sf.seq, sf.forcasting_seq, sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase, sf.forcasting_profit, sf.sales_pay_session,sf.bill_progress_step FROM (SELECT *,(SELECT count(*) FROM sales_maintain_bill WHERE maintain_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_maintain AS s) sf
					join
					(SELECT a.* FROM(SELECT maintain_seq,product_code FROM sales_maintain_product group by maintain_seq) AS a
					left JOIN
					(select maintain_seq from sales_maintain_product WHERE integration_maintain_seq IS not null group by maintain_seq) AS b
					ON a.maintain_seq = b.maintain_seq
					WHERE b.maintain_seq IS NULL) sp
					on sf.seq = sp.maintain_seq
					left join stc.product p on p.seq = sp.product_code " . $searchstring . " order by replace(exception_saledate2,'-','') DESC, exception_saledate3 ASC";
		}else{
			// $sql = "select * from (SELECT mt.*, if(smp.integration_maintain_seq IS NOT NULL,'통합유지보수','유지보수') AS type FROM (select sf.seq, sf.forcasting_seq, sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase, sf.forcasting_profit, sf.sales_pay_session,sf.bill_progress_step from (SELECT *,(SELECT count(*) FROM sales_maintain_bill WHERE maintain_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_maintain AS s) sf left join (select * from stc.sales_maintain_product group by maintain_seq) sp on sf.seq = sp.maintain_seq left join stc.product p on p.seq = sp.product_code ) as mt left join (SELECT * from sales_maintain_product WHERE integration_maintain_seq IS NOT NULL) AS smp on mt.seq= smp.maintain_seq group by mt.seq) as tt " . $searchstring . " order by replace(exception_saledate2,'-','') DESC, exception_saledate3 asc";
			$sql = "SELECT sf.seq, sf.forcasting_seq, sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase, sf.forcasting_profit, sf.sales_pay_session,sf.bill_progress_step FROM (SELECT *,(SELECT count(*) FROM sales_maintain_bill WHERE maintain_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_maintain AS s) sf
					join
					(select * from stc.sales_maintain_product WHERE integration_maintain_seq IS not null group by maintain_seq) sp
					on sf.seq = sp.maintain_seq
					left join stc.sales_integration_maintain_product p on p.seq = sp.integration_maintain_product_seq " . $searchstring . " order by replace(exception_saledate2,'-','') DESC, exception_saledate3 ASC";
		}
		$query = $this->db->query($sql);

		return  $query->result_array();
	}

	//유지보수 만료 30일전부터 가져오기
	function maintain_expiration_mail(){
		$sub_sql = "SELECT GROUP_CONCAT(sub_project_add SEPARATOR ',') AS seq FROM sales_maintain ORDER BY sub_project_add";
		$sub_query = $this->db->query($sub_sql);
		$sub_seq = $sub_query->row_array();
		$sub_seq = $sub_seq['seq'];

		$target_sql = "SELECT GROUP_CONCAT(seq SEPARATOR ',') AS seq FROM sales_maintain
WHERE (forcasting_seq, exception_saledate3) IN (
SELECT forcasting_seq, MAX(exception_saledate3) AS exception_saledate3
FROM sales_maintain WHERE progress_step > '014'
GROUP BY forcasting_seq) ORDER BY forcasting_seq";
		$target_query = $this->db->query($target_sql);
		$target_seq = $target_query->row_array();
		$target_seq = $target_seq['seq'];

		$except_add = " AND seq NOT IN ({$sub_seq})";
		$target_seq = " AND seq IN ({$target_seq})";

		$sql1= "SELECT customer_companyname, project_name, exception_saledate2 AS maintain_start, exception_saledate3 AS maintain_end FROM sales_maintain where exception_saledate3 <= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 30 DAY), '%Y-%m-%d') AND exception_saledate3 >= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 16 DAY), '%Y-%m-%d') {$except_add} {$target_seq} order by binary(customer_companyname)";

		$sql2 = "SELECT customer_companyname, project_name, exception_saledate2 AS maintain_start, exception_saledate3 AS maintain_end FROM sales_maintain where exception_saledate3 <= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 15 DAY), '%Y-%m-%d') AND exception_saledate3 >= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 0 DAY), '%Y-%m-%d') {$except_add} {$target_seq} ORDER BY BINARY(customer_companyname);";

		$sql3 = "SELECT customer_companyname, project_name, exception_saledate2 AS maintain_start, exception_saledate3 AS maintain_end FROM sales_maintain where exception_saledate3 < DATE_FORMAT(NOW(),'%Y-%m-%d') {$except_add} {$target_seq} order by binary(customer_companyname)";

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


	//세금계산서 가져오기(매출)
	function maintain_sales_bill_view($seq){
		$sql = "select * from sales_maintain_bill where maintain_seq = {$seq} and type='001' order by pay_session";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}
	//세금계산서 가져오기(매입)
	function maintain_purchase_bill_view($seq){
		$sql = "select * from sales_maintain_bill where maintain_seq = {$seq} and type='002' order by pay_session";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//세금계산서 가져오기(매입) 매입처 로 그룹바이한거...
	function maintain_purchase_bill_groupby_view($seq){
		$sql = "select * from sales_maintain_bill where maintain_seq = {$seq} and type='002' group by company_name order by pay_session";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	// //매출 계산서 발행 금액합계
	// function sales_total_issuance_amount($seq){
	// 	$sql = "select SUM(issuance_amount) AS sales_total_issuance_amount from sales_maintain_bill where maintain_seq = {$seq} AND TYPE = '001'";
	// }


	//세금계산서 저장/수정/삭제
	function maintain_sales_bill_save($data,$type){
		if($type == 0){//insert
			$result = $this->db->insert('sales_maintain_bill',$data);
			$bill_seq = $this->db->insert_id();
			$this->STC_Bill_fund_link->bill_fund_link($bill_seq, $data['issuance_status'], $data['issuance_month'], 'maintain');
			return $result;
		}else if($type == 1){//update
			$result = $this->db->update('sales_maintain_bill',$data, array('seq' => $data['seq']));
			$bill_seq = $data['seq'];
			$this->STC_Bill_fund_link->bill_fund_link($bill_seq, $data['issuance_status'], $data['issuance_month'], 'maintain');
			return $result;
		}else{//delete
			$sql = "delete from sales_maintain_bill where seq in ($data)";
			$this->STC_Bill_fund_link->bill_fund_link_delete($data, 'maintain');
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
		// $sql = "SELECT sp.*, p.product_type,p.product_company,p.product_name FROM sales_integration_maintain_product as sp left join product p
		// on sp.product_code = p.seq WHERE integration_maintain_seq = {$seq}";
		$sql ="SELECT * FROM sales_integration_maintain_product WHERE integration_maintain_seq = {$seq}";
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
		(maintain_seq,org_maintain_seq,integration_maintain_seq,integration_maintain_product_seq,product_supplier,
		product_count,product_serial,product_state,product_licence,product_version,product_purpose,product_host,product_check_list)
		SELECT
		{$maitain_seq} as maintain_seq,{$maitain_seq} as org_maintain_seq,integration_maintain_seq,seq as integration_maintain_product_seq,product_supplier,
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

	//통합유지보수 삭제
	function integrationDelete($seq){
		$sql = "DELETE a,b
		FROM sales_integration_maintain a
		left JOIN sales_integration_maintain_product b
		ON a.seq = b.integration_maintain_seq
		WHERE a.seq = {$seq}";
		return $this->db->query($sql);
	}

	//유지보수 테이블 있나 확인
	function select_sales_maintain($seq){
		$sql = "SELECT * FROM sales_maintain WHERE forcasting_seq = {$seq}";
		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//포캐스팅 테이블 -> 유지보수 테이블 복사(sales_forcasting,sales_forcasting_proudct,sales_forcasting_mocompany)
	function forcasting_duplication($data){
		$seq = $data['forcasting_seq'];
		$sql = "INSERT INTO sales_maintain
		(forcasting_seq,
		TYPE,
		customer_seq,
		customer_companyname,
		customer_username,
		customer_tel,
		customer_email,
		project_name,
		progress_step,
		upper_seq,
		sales_companyname,
		sales_username,
		dept,
		sales_tel,
		sales_email,
		cooperation_companyname,
		cooperation_username,
		cooperation_tel,
		cooperation_email,
		first_saledate,
		exception_saledate,
		exception_saledate2,
		exception_saledate3,
		complete_status,
		cnum,
		company_num,
		write_id,
		insert_date,
		manage_team,
		maintain_cycle,
		maintain_date,
		maintain_user,
		maintain_type,
		maintain_result,
		maintain_comment,
		procurement_sales_amount,
		forcasting_sales,
		forcasting_purchase,
		forcasting_profit,
		division_month,
		sub_project_add,
		file) SELECT seq as forcasting_seq,
		TYPE,
		customer_seq,
		customer_companyname,
		customer_username,
		customer_tel,
		customer_email,
		'{$data['project_name']}' as project_name,
		'{$data['progress_step']}' as progress_step,
		upper_seq,
		sales_companyname,
		sales_username,
		dept,
		sales_tel,
		sales_email,
		cooperation_companyname,
		cooperation_username,
		cooperation_tel,
		cooperation_email,
		first_saledate,
		exception_saledate,
		exception_saledate2,
		DATE_ADD(exception_saledate2, INTERVAL 1 YEAR) as exception_saledate3,
		complete_status,
		cnum,
		company_num,
		write_id,
		now() as insert_date,
		manage_team,
		maintain_cycle,
		maintain_date,
		maintain_user,
		maintain_type,
		maintain_result,
		maintain_comment,
		procurement_sales_amount,
		0 as forcasting_sales,
		0 as forcasting_purchase,
		0 as forcasting_profit,
		division_month,
		sub_project_add,
		file FROM sales_forcasting WHERE seq = {$seq} ";
		$query1 = $this->db->query($sql);
		$maintain_seq = $this->db->insert_id();

		$sql2 = "INSERT INTO sales_maintain_product
		(forcasting_seq,
		org_maintain_seq,
		maintain_seq,
		forcasting_product_seq,
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
		product_sales,
		product_purchase,
		product_profit,
		product_check_list
		) SELECT forcasting_seq,
		{$maintain_seq} AS maintain_seq,
		{$maintain_seq} AS org_maintain_seq,
		seq as forcasting_product_seq,
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
		0 as product_sales,
		0 as product_purchase,
		0 as product_profit,
		product_check_list FROM sales_forcasting_product WHERE forcasting_seq = {$seq}";

		$sql3 = "INSERT INTO sales_maintain_mcompany
		(forcasting_seq,
		maintain_seq,
		main_companyname,
		main_username,
		main_tel,
		main_email,
		insert_date
		)
		SELECT forcasting_seq,
		{$maintain_seq} as maintain_seq,
		main_companyname,
		main_username,
		main_tel,
		main_email,
		now() as insert_date
	    FROM sales_forcasting_mcompany WHERE forcasting_seq = {$seq}";

		$sql4 = "UPDATE sales_maintain set write_id = '{$this->id}' where seq = {$maintain_seq}";

		$query2 = $this->db->query($sql2);
		$query3 = $this->db->query($sql3);
		$query4 = $this->db->query($sql4);

		if($query1 == true && $query2 == true && $query3 == true){
			return $maintain_seq;
		}else{
			return false;
		}
	}

	// 작성자, 수정자 로그 기록
	function maintain_log_insert($data){
		$result = $this->db->insert('sales_maintain_log',$data);
	}

	function maintain_log_delete($seq){
		$sql = "delete from sales_maintain_log where maintain_seq = {$seq}";
		$this->db->query($sql);
	}

	function log_data($log_type, $seq) {
		if ($log_type=="insert"){
			$sql = "SELECT sml.*, u.user_name FROM sales_maintain_log sml JOIN user u ON sml.write_seq = u.seq WHERE log_type = '{$log_type}' AND maintain_seq = {$seq}";
		} else {
			$sql ="SELECT sml.*, u.user_name FROM sales_maintain_log sml JOIN user u ON sml.write_seq = u.seq WHERE log_type = '{$log_type}' AND maintain_seq = {$seq} ORDER BY update_date DESC LIMIT 1";
		}
		$query = $this->db->query($sql);
		if($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	//매입처 insert update
	function maintain_mcompany_insert($type,$data){
		if($type == 0){//insert
			return $this->db->insert('sales_maintain_mcompany',$data);
		}else{//update
			return $this->db->update('sales_maintain_mcompany',$data,array('seq' => $data['seq']));
		}

	}


	// 계산서 미발행 리스트
	function maintain_unissued_list($searchkeyword, $start_limit = 0, $offset = 0){
		if ($searchkeyword != "") {
			$searchstring='';
			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //매입인가 매출인가
				$searchstring .= " AND u.type = '{$searchkeyword[0]}'";
			}
			if(trim($searchkeyword[1])!=''){ //회사
				if(trim($searchkeyword[1]!='IT')) {
					$searchstring .= " AND u.dept = '{$searchkeyword[1]}'";
				} else { // 부서
					if($searchkeyword[2]=='전체') {
						$searchstring .= " AND u.dept in ('사업1부', '사업2부', '기술지원부')";
					} else {
						$searchstring .= " AND u.dept = '{$searchkeyword[2]}'";
					}
				}
			}
			if(trim($searchkeyword[3])!=''){ //유지보수인가 통합유지보수인가
				$searchstring .= " and u.main_type = '{$searchkeyword[3]}'";
			}
			if(trim($searchkeyword[4])!='' && trim($searchkeyword[5])!=''){ //시작기간
				$searchstring .= " and u.issue_schedule_date between '{$searchkeyword[4]}' and '{$searchkeyword[5]}'";
			}
		} else {
			$searchstring = "";
		}
		// $sql = "SELECT bill.*, bill.maintain_seq, main.customer_companyname, main.project_name, main.cooperation_companyname, main.cooperation_username,main.dept, if(main.integration_maintain_seq IS null, '유지보수', '통합유지보수') as main_type, main.view_type FROM sales_maintain_bill AS bill LEFT JOIN (SELECT a.seq, a.type AS view_type , a.customer_companyname, a.project_name, a.cooperation_companyname, a.cooperation_username,a.dept, b.integration_maintain_seq FROM sales_maintain AS a LEFT JOIN (SELECT DISTINCT maintain_seq, integration_maintain_seq FROM sales_maintain_product) AS b ON a.seq = b.maintain_seq) AS main ON bill.maintain_seq = main.seq WHERE bill.issuance_status = 'n'{$searchstring} GROUP BY seq ORDER BY issue_schedule_date is null ASC, issue_schedule_date ASC, maintain_seq DESC, TYPE ASC, pay_session asc";

		$sql = "SELECT * FROM (
(SELECT bill.*, main.customer_companyname, main.project_name, main.cooperation_companyname, main.cooperation_username,main.dept, if(main.integration_maintain_seq IS NULL, '유지보수', '통합유지보수') AS main_type, main.view_type, main.progress_step
FROM sales_maintain_bill AS bill
LEFT JOIN (
SELECT a.seq, a.type AS view_type, a.customer_companyname, a.project_name, a.cooperation_companyname, a.cooperation_username,a.dept, a.progress_step, b.integration_maintain_seq
FROM sales_maintain AS a
LEFT JOIN (
SELECT DISTINCT maintain_seq, integration_maintain_seq
FROM sales_maintain_product) AS b ON a.seq = b.maintain_seq) AS main ON bill.maintain_seq = main.seq WHERE main.progress_step >='014'
GROUP BY seq)
UNION
(
SELECT CONCAT('r_',rtsb.seq) AS seq, CONCAT('r_',rts.seq) as maintain_seq, '002' AS TYPE, rts.cooperative_company AS company_name, '-' AS pay_session,
rtsb.issuance_amount, rtsb.tax_amount, rtsb.total_amount, rtsb.tax_approval_number, rtsb.issue_schedule_date, rtsb.issuance_month, rtsb.issuance_date, rtsb.issuance_status,
rtsb.deposit_date, rtsb.deposit_status, rtsb.write_id, rtsb.insert_date, rtsb.update_date, rts.customer_company AS customer_companyname, ead.approval_doc_name AS project_name, '두리안정보기술' AS cooperation_companyname,
'김갑진' AS cooperation_username, '사업2부' AS dept, '기술지원요청' AS main_type, NULL AS view_type, '019' AS progress_step
FROM request_tech_support_bill rtsb
LEFT JOIN electronic_approval_doc ead ON ead.seq = rtsb.annual_doc_seq
LEFT JOIN request_tech_support rts ON rts.seq = SUBSTRING_INDEX(ead.req_support_seq, '_', 1)
) ) AS u
WHERE u.issuance_status = 'n'{$searchstring}
ORDER BY issue_schedule_date IS NULL ASC, issue_schedule_date ASC, maintain_seq DESC, TYPE ASC, pay_session ASC";

		if ($offset <> 0){
			$sql = $sql . " limit ?, ?";
		}
		$query = $this->db->query($sql, array($start_limit, $offset));
// echo $sql;
		return array('count' => $query->num_rows(), 'data' => $query->result());
	}



	function maintain_unissued_list_count($searchkeyword){
		if ($searchkeyword != "") {
			$searchstring='';
			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //매입인가 매출인가
				$searchstring .= " AND u.type = '{$searchkeyword[0]}'";
			}
			if(trim($searchkeyword[1])!=''){ //회사
				if(trim($searchkeyword[1]!='IT')) {
					$searchstring .= " AND u.dept = '{$searchkeyword[1]}'";
				} else { // 부서
					if($searchkeyword[2]=='전체') {
						$searchstring .= " AND u.dept in ('사업1부', '사업2부', '기술지원부')";
					} else {
						$searchstring .= " AND u.dept = '{$searchkeyword[2]}'";
					}
				}
			}
			if(trim($searchkeyword[3])!=''){ //유지보수인가 통합유지보수인가
				$searchstring .= " and u.main_type = '{$searchkeyword[3]}'";
			}
			if(trim($searchkeyword[4])!='' && trim($searchkeyword[5])!=''){ //시작기간
				$searchstring .= " and u.issue_schedule_date between '{$searchkeyword[4]}' and '{$searchkeyword[5]}'";
			}
		} else {
			$searchstring = "";
		}

		$sql = "SELECT count(*) as ucount FROM (
(SELECT bill.*, main.customer_companyname, main.project_name, main.cooperation_companyname, main.cooperation_username,main.dept, if(main.integration_maintain_seq IS NULL, '유지보수', '통합유지보수') AS main_type, main.view_type, main.progress_step
FROM sales_maintain_bill AS bill
LEFT JOIN (
SELECT a.seq, a.type AS view_type, a.customer_companyname, a.project_name, a.cooperation_companyname, a.cooperation_username,a.dept, a.progress_step, b.integration_maintain_seq
FROM sales_maintain AS a
LEFT JOIN (
SELECT DISTINCT maintain_seq, integration_maintain_seq
FROM sales_maintain_product) AS b ON a.seq = b.maintain_seq) AS main ON bill.maintain_seq = main.seq WHERE main.progress_step >='014'
GROUP BY seq)
UNION
(
SELECT CONCAT('r_',rtsb.seq) AS seq, CONCAT('r_',rts.seq) as maintain_seq, '002' AS TYPE, rts.cooperative_company AS company_name, '-' AS pay_session,
rtsb.issuance_amount, rtsb.tax_amount, rtsb.total_amount, rtsb.tax_approval_number, rtsb.issue_schedule_date, rtsb.issuance_month, rtsb.issuance_date, rtsb.issuance_status,
rtsb.deposit_date, rtsb.deposit_status, rtsb.write_id, rtsb.insert_date, rtsb.update_date, rts.customer_company AS customer_companyname, ead.approval_doc_name AS project_name, '두리안정보기술' AS cooperation_companyname,
'김갑진' AS cooperation_username, '사업2부' AS dept, '기술지원요청' AS main_type, NULL AS view_type, '019' AS progress_step
FROM request_tech_support_bill rtsb
LEFT JOIN electronic_approval_doc ead ON ead.seq = rtsb.annual_doc_seq
LEFT JOIN request_tech_support rts ON rts.seq = SUBSTRING_INDEX(ead.req_support_seq, '_', 1)
) ) AS u
WHERE u.issuance_status = 'n'{$searchstring}
ORDER BY issue_schedule_date IS NULL ASC, issue_schedule_date ASC, maintain_seq DESC, TYPE ASC, pay_session ASC";

		$query = $this->db->query($sql);
		return $query->row();
	}

	// 계산서 미발행 리스트
	function maintain_unissued_list_excel($searchkeyword){
		if ($searchkeyword != "") {
			$searchstring='';
			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //매입인가 매출인가
				$searchstring .= " AND u.type = '{$searchkeyword[0]}'";
			}
			if(trim($searchkeyword[1])!=''){ //회사
				if(trim($searchkeyword[1]!='IT')) {
					$searchstring .= " AND u.dept = '{$searchkeyword[1]}'";
				} else { // 부서
					if($searchkeyword[2]=='전체') {
						$searchstring .= " AND u.dept in ('사업1부', '사업2부', '기술지원부')";
					} else {
						$searchstring .= " AND u.dept = '{$searchkeyword[2]}'";
					}
				}
			}
			if(trim($searchkeyword[3])!=''){ //유지보수인가 통합유지보수인가
				$searchstring .= " and u.main_type = '{$searchkeyword[3]}'";
			}
			if(trim($searchkeyword[4])!='' && trim($searchkeyword[5])!=''){ //시작기간
				$searchstring .= " and u.issue_schedule_date between '{$searchkeyword[4]}' and '{$searchkeyword[5]}'";
			}
		} else {
			$searchstring = "";
		}
		$sql = "SELECT * FROM (
(SELECT bill.*, main.customer_companyname, main.project_name, main.cooperation_companyname, main.cooperation_username,main.dept, if(main.integration_maintain_seq IS NULL, '유지보수', '통합유지보수') AS main_type, main.view_type, main.progress_step
FROM sales_maintain_bill AS bill
LEFT JOIN (
SELECT a.seq, a.type AS view_type, a.customer_companyname, a.project_name, a.cooperation_companyname, a.cooperation_username,a.dept, a.progress_step, b.integration_maintain_seq
FROM sales_maintain AS a
LEFT JOIN (
SELECT DISTINCT maintain_seq, integration_maintain_seq
FROM sales_maintain_product) AS b ON a.seq = b.maintain_seq) AS main ON bill.maintain_seq = main.seq WHERE main.progress_step >='014'
GROUP BY seq)
UNION
(
SELECT CONCAT('r_',rtsb.seq) AS seq, CONCAT('r_',rts.seq) as maintain_seq, '002' AS TYPE, rts.cooperative_company AS company_name, '-' AS pay_session,
rtsb.issuance_amount, rtsb.tax_amount, rtsb.total_amount, rtsb.tax_approval_number, rtsb.issue_schedule_date, rtsb.issuance_month, rtsb.issuance_date, rtsb.issuance_status,
rtsb.deposit_date, rtsb.deposit_status, rtsb.write_id, rtsb.insert_date, rtsb.update_date, rts.customer_company AS customer_companyname, ead.approval_doc_name AS project_name, '두리안정보기술' AS cooperation_companyname,
'김갑진' AS cooperation_username, '사업2부' AS dept, '기술지원요청' AS main_type, NULL AS view_type, '019' AS progress_step
FROM request_tech_support_bill rtsb
LEFT JOIN electronic_approval_doc ead ON ead.seq = rtsb.annual_doc_seq
LEFT JOIN request_tech_support rts ON rts.seq = SUBSTRING_INDEX(ead.req_support_seq, '_', 1)
) ) AS u
WHERE u.issuance_status = 'n'{$searchstring}
ORDER BY issue_schedule_date IS NULL ASC, issue_schedule_date ASC, maintain_seq DESC, TYPE ASC, pay_session ASC";

		$query = $this->db->query($sql);

		return $query->result();
	}

	function maintain_memo($seq) {
		$sql = "SELECT * FROM sales_maintain_memo WHERE maintain_seq = {$seq}";

		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	function save_memo($data, $mode) {
		if ($mode == 1) {
			$result = $this->db->insert('sales_maintain_memo', $data);
		} else {
			$result = $this->db->update('sales_maintain_memo', $data, array('seq' => $data['seq']));
		}

		return $result;
	}

	function infor_comm_corporation_bill($type, $search_mode, $searchkeyword, $target_year) {
		$searchstring = $this->maintain_search($search_mode, $searchkeyword, 'intergrated maintain');

		$f_sql = 'SELECT sf.seq';
		$sql = " FROM (SELECT *,(SELECT count(*) FROM sales_maintain_bill WHERE maintain_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_maintain AS s) sf
				join
				(select * from stc.sales_maintain_product WHERE integration_maintain_seq IS not null group by maintain_seq) sp
				on sf.seq = sp.maintain_seq
				left join stc.sales_integration_maintain_product p on p.seq = sp.integration_maintain_product_seq " . $searchstring . " order by replace(exception_saledate2,'-','') DESC, exception_saledate3 ASC";
		$sql = $f_sql.$sql;

		if($type == 'done') {
			$t = " AND issuance_status = 'Y'";
		} else {
			$t = '';
		}

		$sql2 = "SELECT
						SUM(CASE WHEN `type` = '002' then issuance_amount END) AS purchase_sum,
						SUM(CASE WHEN `type` = '001' then issuance_amount END) AS sales_sum
						FROM sales_maintain_bill
						WHERE
						maintain_seq
						IN ({$sql})
						AND ((issuance_status = 'Y' AND issuance_date LIKE '{$target_year}%')
						OR (issuance_status = 'N' AND issue_schedule_date LIKE '{$target_year}%')) {$t}";
// echo $sql2.'<br><br>';
		$result = $this->db->query($sql2);

		return $result->row_array();
	}

	function maintain_term($seq) {
		$sql = "SELECT TIMESTAMPDIFF(MONTH, exception_saledate2, exception_saledate3) + 1 AS nom FROM sales_maintain WHERE seq = {$seq}";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function generate_maintain_forcasting($maintain_seq, $nom) {
		$sql = "INSERT INTO sales_maintain (forcasting_seq,type,upper_seq,generate_type,customer_companyname,customer_username,customer_tel,customer_email,
		 		project_name,sales_companyname,sales_username,dept,sales_tel,sales_email,cooperation_companyname,cooperation_username,exception_saledate2, exception_saledate3,
				complete_status,company_num,write_id,insert_date,manage_team,maintain_cycle,maintain_date,maintain_user,maintain_type,maintain_result,maintain_comment,sub_project_add,procurement_sales_amount,forcasting_sales,forcasting_purchase,forcasting_profit,division_month, issue_cycle)
				select forcasting_seq,type,{$maintain_seq},'갱신',customer_companyname,customer_username,customer_tel,customer_email, project_name,sales_companyname,sales_username,dept,sales_tel,sales_email,cooperation_companyname,cooperation_username, DATE_ADD(exception_saledate3, INTERVAL 1 DAY) as exception_saledate2,
				DATE_ADD(exception_saledate3, INTERVAL {$nom} MONTH) as exception_saledate3,
				complete_status,company_num,write_id, now() as insert_date,manage_team,maintain_cycle,null,maintain_user,maintain_type,null,null,sub_project_add,procurement_sales_amount,forcasting_sales,forcasting_purchase,forcasting_profit,division_month, issue_cycle from sales_maintain where seq = {$maintain_seq}";
		$this->db->query( $sql );
		$renewal_seq  = $this->db->insert_id();

		$sql2 = "INSERT INTO sales_maintain_product (maintain_seq,org_maintain_seq,forcasting_seq,integration_maintain_seq,integration_maintain_product_seq,product_code,product_supplier,
		product_serial,product_state,product_licence,product_version,product_purpose,product_host,maintain_yn,maintain_target,insert_date,product_check_list,product_sales,product_purchase,product_profit,maintain_begin,maintain_expire)
		SELECT {$renewal_seq} as maintain_seq,org_maintain_seq,forcasting_seq,integration_maintain_seq,integration_maintain_product_seq,product_code,product_supplier,
		product_serial,product_state,product_licence,product_version,product_purpose,product_host,maintain_yn,maintain_target,now() as insert_date,product_check_list,product_sales,product_purchase,product_profit, DATE_ADD(maintain_expire, INTERVAL 1 DAY) as maintain_begin, DATE_ADD(maintain_expire, INTERVAL {$nom} MONTH) as maintain_expire from sales_maintain_product WHERE maintain_seq = {$maintain_seq}";

		$result = $this->db->query( $sql2 );

		$sql3= "INSERT INTO sales_maintain_mcompany (maintain_seq,forcasting_seq,main_companyname,main_username,main_tel,main_email,insert_date, purchase_pay_session, issue_cycle)
		SELECT {$renewal_seq} as maintain_seq,forcasting_seq,main_companyname,main_username,main_tel,main_email,now() insert_date, purchase_pay_session, issue_cycle from sales_maintain_mcompany WHERE maintain_seq ={$maintain_seq}";

		$result = $this->db->query( $sql3 );

		$sql4 = "INSERT INTO sales_maintain_bill
		(maintain_seq, type, company_name, pay_session, issuance_amount, tax_amount, total_amount, issue_schedule_date, issuance_status, deposit_status, write_id, insert_date)
		SELECT {$renewal_seq} as maintain_seq, type, company_name, pay_session, issuance_amount, tax_amount, total_amount,
		case
		when issue_schedule_date is not null and issue_schedule_date != '0000-00-00'
		then DATE_ADD(issue_schedule_date, INTERVAL {$nom} MONTH)
		else DATE_ADD(issuance_date, INTERVAL {$nom} MONTH) end as issue_schedule_date,
		'N', 'N', '{$this->id}' as write_id, now() from sales_maintain_bill WHERE maintain_seq = {$maintain_seq} AND issuance_status in ('Y', 'N')";

		$this->db->query($sql4);

		return $renewal_seq;

	}

	function forcasting_cnt($seq) {
		$sql = "SELECT count(*) as cnt from sales_maintain where upper_seq = {$seq}";

		$query = $this->db->query($sql);

		return $query->row_array();
	}


}
