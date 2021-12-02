<?php
header("Content-type: text/html; charset=utf-8");

class STC_Forcasting extends CI_Model
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
	function forcasting_insert($data, $mode = 0, $seq = 0 ,$data_type = 0)
	{
		if ($mode == 0) {
			$sql = "insert into sales_forcasting (customer_companyname,customer_username,dept,customer_tel,customer_email,project_name,progress_step,type,procurement_sales_amount,cooperation_companyname,cooperation_username,cooperation_tel,cooperation_email,sales_companyname,sales_username,sales_tel,sales_email,first_saledate,exception_saledate,exception_saledate2,forcasting_sales,forcasting_purchase,forcasting_profit,division_month,complete_status,company_num,write_id,insert_date,update_date) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now(),now())";

			$this->db->query($sql, array($data['customer_companyname'], $data['customer_username'], $data['dept'], $data['customer_tel'], $data['customer_email'], $data['project_name'], $data['progress_step'], $data['type'], $data['procurement_sales_amount'], $data['cooperation_companyname'], $data['cooperation_username'], $data['cooperation_tel'], $data['cooperation_email'], $data['sales_companyname'], $data['sales_username'], $data['sales_tel'], $data['sales_email'], $data['first_saledate'], $data['exception_saledate'], $data['exception_saledate'], $data['forcasting_sales'], $data['forcasting_purchase'], $data['forcasting_profit'], $data['division_month'], $data['complete_status'], $this->cnum, $data['write_id']));

			$sql2 = "select max(seq) as max_seq from sales_forcasting";
			$query = $this->db->query($sql2);
			$mseq = $query->row()->max_seq;

			//forcasting_product 등록
			$insert_product_array = explode("||", $data['insert_product_array']);
			for ($i = 1; $i < count($insert_product_array); $i++) {
				$product_list = explode("~", $insert_product_array[$i]);
				$sql3 = "insert into sales_forcasting_product (forcasting_seq,product_code,product_supplier,product_licence,product_serial,product_state,product_sales,product_purchase,product_profit,insert_date) values({$mseq},";
				for($j=0; $j<count($product_list); $j++){
					$sql3 .= "'{$product_list[$j]}',";
				}
				$sql3 .= "now())";
				$this->db->query($sql3);
			}
			//forcasting_mcompany 등록
			$insert_main_array = explode("||", $data['insert_main_array']);

			for ($i = 1; $i < count($insert_main_array); $i++) {
				$main_list = explode("~", $insert_main_array[$i]);

				$sql4 = "insert into sales_forcasting_mcompany (forcasting_seq,main_companyname,main_username,main_tel,main_email,insert_date) values({$mseq},";
				for($j=0; $j<count($main_list); $j++){
					$sql4 .= "'{$main_list[$j]}',";
				}
				$sql4 .= "now())";
				$result = $this->db->query($sql4);
			}
			return $mseq;
		} else {
			$result='';
			if($data_type == '1'){
				$result =  $this->db->update('sales_forcasting', $data, array('seq' => $seq));
			}else if($data_type == '2'){
				$result =  $this->db->update('sales_forcasting', $data, array('seq' => $seq));
			}else if($data_type == '3'){
				$result =  $this->db->update('sales_forcasting', $data, array('seq' => $seq));
			}else if($data_type == '4'){ //매입처
				//forcasting_mcompany_delete
				$delete_main_array = explode(",", $data['delete_main_array']); 

				for($i=1; $i<count($delete_main_array); $i++){
					$sql6 = "delete from sales_forcasting_mcompany where seq = {$delete_main_array[$i]}";
					$this->db->query($sql6);
				}
				
				//forcasting_mcompany insert
				$insert_main_array = explode("||", $data['insert_main_array']);

				for ($i = 1; $i < count($insert_main_array); $i++) {
					$main_list = explode("~", $insert_main_array[$i]);

					$sql4 = "insert into sales_forcasting_mcompany (forcasting_seq,main_companyname,main_username,main_tel,main_email,insert_date) values({$seq},";
					for($j=0; $j<count($main_list); $j++){
						$sql4 .= "'{$main_list[$j]}',";
					}
					$sql4 .= "now())";
					$result = $this->db->query($sql4);
				}

				//forcasting_mcompany update
				$update_main_array = explode("||", $data['update_main_array']);
				$update_column = explode(",","main_companyname,main_username,main_tel,main_email");

				for ($i = 1; $i < count($update_main_array); $i++) {
					$main_list = explode("~", $update_main_array[$i]);

					$sql5 = "update sales_forcasting_mcompany set forcasting_seq={$seq},";
					for($j=0; $j<count($update_column); $j++){
						$sql5 .= "{$update_column[$j]} = '{$main_list[$j]}',";
					}
					$sql5 .= "update_date=now() where seq={$main_list[count($update_column)]}";
					$result = $this->db->query($sql5);
				}
			}else if($data_type == '5'){
				//제품 delete
				$delete_product_array = explode(",", $data['delete_product_array']); 

				for($i=1; $i<count($delete_product_array); $i++){
					$sql1 = "delete from sales_forcasting_product where seq = {$delete_product_array[$i]}";
					$this->db->query($sql1);
				}

				//제품 update
				$update_product_array = explode("||", $data['update_product_array']);
				$update_column = explode(",","product_code,product_supplier,product_licence,product_serial,product_state,product_sales,product_purchase,product_profit");

				for ($i = 1; $i < count($update_product_array); $i++) {
					$product_list = explode("~", $update_product_array[$i]);
					$sql2 = "update sales_forcasting_product set forcasting_seq={$seq},";
					for($j=0; $j<count($update_column); $j++){
						$sql2 .= "{$update_column[$j]} = '{$product_list[$j]}',";
					}
					$sql2 .= "update_date=now() where seq={$product_list[count($update_column)]}";
					$this->db->query($sql2);
				}

				//제품 insert
				$insert_product_array = explode("||", $data['insert_product_array']);
				for ($i = 1; $i < count($insert_product_array); $i++) {
					$product_list = explode("~", $insert_product_array[$i]);
					$sql3 = "insert into sales_forcasting_product (forcasting_seq,product_code,product_supplier,product_licence,product_serial,product_state,product_sales,product_purchase,product_profit,insert_date) values({$seq},";
					for($j=0; $j<count($product_list); $j++){
						$sql3 .= "'{$product_list[$j]}',";
					}
					$sql3 .= "now())";
					$this->db->query($sql3);
				}

				//나머지~고객사총매출가랑 이론거
				$sql4 =  "update sales_forcasting set forcasting_sales=?,forcasting_purchase=?,forcasting_profit=?,division_month=?,first_saledate=?,exception_saledate=?,write_id=?,update_date=? where seq=?";
				$result = $this->db->query($sql4, array($data['forcasting_sales'], $data['forcasting_purchase'], $data['forcasting_profit'], $data['division_month'], $data['first_saledate'], $data['exception_saledate'], $data['write_id'], $data['update_date'],$seq));

			}else if($data_type == '6'){
				$result =  $this->db->update('sales_forcasting', $data, array('seq' => $seq));
			}
			// $sql = "update sales_forcasting set customer_companyname=?,customer_username=?,dept=?,customer_tel=?,customer_email=?,project_name=?,progress_step=?,type=?,cooperation_companyname=?,cooperation_username=?,cooperation_tel=?,cooperation_email=?,sales_companyname=?,sales_username=?,sales_tel=?,sales_email=?,first_saledate=?,exception_saledate=?,forcasting_sales=?,forcasting_purchase=?,forcasting_profit=?,division_month=?,complete_status=?,update_date=now() where seq=?";

			// $this->db->query($sql, array($data['customer_companyname'], $data['customer_username'], $data['dept'], $data['customer_tel'], $data['customer_email'], $data['project_name'], $data['progress_step'], $data['type'], $data['cooperation_companyname'], $data['cooperation_username'], $data['cooperation_tel'], $data['cooperation_email'], $data['sales_companyname'], $data['sales_username'], $data['sales_tel'], $data['sales_email'], $data['first_saledate'], $data['exception_saledate'], $data['forcasting_sales'], $data['forcasting_purchase'], $data['forcasting_profit'], $data['division_month'], $data['complete_status'], $seq));		
			return $result;
		}
	}

	//	포캐스팅 뷰내용 가져오기(기본)
	function forcasting_view($seq = 0)
	{
		$sql = "select * from sales_forcasting where seq = ?";
		$query = $this->db->query($sql, $seq);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	//	포캐스팅 뷰내용 가져오기(주사업자)
	function forcasting_view2($seq = 0)
	{
		$sql = "select * from sales_forcasting_mcompany where forcasting_seq = ?";
		$query = $this->db->query($sql, $seq);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//	포캐스팅 뷰내용 가져오기(제품명)
	function forcasting_view3($seq = 0)
	{
		$sql = "select sp.seq, sp.product_code, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host, p.product_company, p.product_type, p.product_name, p.product_item, sp.maintain_begin, sp.maintain_expire ,sp.product_version,sp.product_sales,sp.product_purchase,sp.product_profit from sales_forcasting_product sp, product p where sp.product_code = p.seq and sp.forcasting_seq = ? order by sp.seq asc, p.product_company desc";
		$query = $this->db->query($sql, $seq);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	// 포캐스팅 삭제
	function forcasting_delete($seq)
	{
		//연계프로젝트 삭제 되었을때 연계프로젝트들의 sub_project_add컬럼에서 삭제되는 seq 지워주기
		$subProject = "select seq from sales_forcasting WHERE sub_project_add =(SELECT sub_project_add FROM sales_forcasting WHERE seq={$seq}) AND sub_project_add regexp seq AND sub_project_add IS NOT null ";
		$subSeq = $this->db->query($subProject);

		$parentProject ="select seq from sales_forcasting WHERE sub_project_add =(SELECT sub_project_add FROM sales_forcasting WHERE seq={$seq}) AND sub_project_add NOT regexp seq AND sub_project_add IS NOT null ";
		$parentSeq = $this->db->query($parentProject);
		$parentRow = $parentSeq->row_array();

		if($parentSeq->num_rows() > 0 && $subSeq->num_rows() > 0){
			if($parentRow['seq'] == $seq){
				foreach($subSeq->result_array() as $row){
					$subUpdate = "UPDATE sales_forcasting SET sub_project_add = null WHERE seq ={$row['seq']}";
					$this->db->query($subUpdate);
				}
			}else{
					foreach($subSeq->result_array() as $row){
						$subUpdate = "UPDATE sales_forcasting SET sub_project_add = trim(BOTH ',' from replace(sub_project_add,'{$seq}','')) WHERE seq ={$row['seq']}";
						$this->db->query($subUpdate);
					}

					$subUpdate = "UPDATE sales_forcasting SET sub_project_add = trim(BOTH ',' from replace(sub_project_add,'{$seq}','')) WHERE seq = {$parentRow['seq']}";
					$this->db->query($subUpdate);
			}

		}

		$sql = "delete from sales_forcasting where seq = ?";
		$this->db->query($sql, $seq);
		$sql2 = "delete from sales_forcasting_mcompany where forcasting_seq = ?";
		$this->db->query($sql2, $seq);
		$sql3 = "delete from sales_forcasting_product where forcasting_seq = ?";
		$this->db->query($sql3, $seq);
		$sql4 = "delete from sales_forcasting_comment where forcasting_seq = ?";
		$this->db->query($sql4, $seq);
		$sql5 = "delete from sales_forcasting_complete_status_comment where forcasting_seq = ?";
		$query = $this->db->query($sql5, $seq);

		return	$query;
	}

	// 포캐스팅 리스트
	function forcasting_list($searchkeyword, $start_limit = 0, $offset = 0, $cnum)
	{
	
		if ($searchkeyword != "") {

			$searchstring='';
			$searchstring2='';

			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //고객사
				$searchstring = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
				$searchstring2 = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
			}
			if(trim($searchkeyword[1])!=''){ //프로젝트명
				$searchstring .= " and sf.project_name like '%{$searchkeyword[1]}%'";
				$searchstring2 .= " and sf.project_name like '%{$searchkeyword[1]}%'";
			}

			if(trim($searchkeyword[2])!=''){ //제조사
				$searchstring .= " and p.product_company like '%{$searchkeyword[2]}%'";
				$searchstring2 .= " and p.product_company like '%{$searchkeyword[2]}%'";
			}

			if(trim($searchkeyword[3])!=''){ //제품명
				$searchstring .= " and p.product_name like '%{$searchkeyword[3]}%'";
				$searchstring2 .= " and p.product_name like '%{$searchkeyword[3]}%'";
			}

			if(trim($searchkeyword[4])!=''){ //영업부서
				$searchstring .= " and sf.dept like '%{$searchkeyword[4]}%'";
				$searchstring2 .= " and sf.dept like '%{$searchkeyword[4]}%'";
			}


			if(trim($searchkeyword[5])!=''){//영업회사
				$searchstring .= " and sf.cooperation_companyname like '%{$searchkeyword[5]}%'";
				$searchstring2 .= " and sf.cooperation_companyname like '%{$searchkeyword[5]}%'";
			}

			if(trim($searchkeyword[6])!=''){ //영업담당자(두리안)
				$searchstring .= " and sf.cooperation_username like '%{$searchkeyword[6]}%' ";
				$searchstring2 .= " and sf.cooperation_username like '%{$searchkeyword[6]}%' ";
			}


			if(trim($searchkeyword[7])!=''){ //예상월
				$searchstring .= " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') % sf.division_month)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') between 0 and 11";
				$searchstring2 .= " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') % 1)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') between 0 and (replace(sf.division_month,'m','')-1)";
			}

			if(trim($searchkeyword[8])!=''){ // 판매종류
				$searchstring .= " and sf.type = '{$searchkeyword[8]}'";
				$searchstring2 .= " and sf.type = '{$searchkeyword[8]}'";
			}
			if(trim($searchkeyword[9])!=''){ // 진척단계
				$searchstring .= " and sf.progress_step = '{$searchkeyword[9]}'";
				$searchstring2 .= " and sf.progress_step = '{$searchkeyword[9]}'";
			}
		} else {
			$searchstring = "";
			$searchstring2 = "";
		}

		if ($this->lv == 1) {
			$sql = "select sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and progress_step<='014' and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") and company_num = ? order by replace(sf.exception_saledate,'-','') DESC";
			if ($offset <> 0){
				$sql = $sql . " limit ?, ?";
			}

			$query = $this->db->query($sql, array($cnum, $start_limit, $offset));
		} else {
			$sql = "select sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name, sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and progress_step<='014' and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") order by replace(sf.exception_saledate,'-','') DESC";
			if ($offset <> 0){
				$sql = $sql . " limit ?, ?";
			}

			$query = $this->db->query($sql, array($start_limit, $offset));
		}
		return array('count' => $query->num_rows(), 'data' => $query->result_array());
	}

	//포캐스팅 리스트개수
	function forcasting_list_count($searchkeyword,$cnum){

		if ($searchkeyword != "") {
			$searchstring='';
			$searchstring2='';

			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //고객사
				$searchstring = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
				$searchstring2 = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
			}
			if(trim($searchkeyword[1])!=''){ //프로젝트명
				$searchstring .= " and sf.project_name like '%{$searchkeyword[1]}%'";
				$searchstring2 .= " and sf.project_name like '%{$searchkeyword[1]}%'";
			}

			if(trim($searchkeyword[2])!=''){ //제조사
				$searchstring .= " and p.product_company like '%{$searchkeyword[2]}%'";
				$searchstring2 .= " and p.product_company like '%{$searchkeyword[2]}%'";
			}

			if(trim($searchkeyword[3])!=''){ //제품명
				$searchstring .= " and p.product_name like '%{$searchkeyword[3]}%'";
				$searchstring2 .= " and p.product_name like '%{$searchkeyword[3]}%'";
			}

			if(trim($searchkeyword[4])!=''){ //영업부서
				$searchstring .= " and sf.dept like '%{$searchkeyword[4]}%'";
				$searchstring2 .= " and sf.dept like '%{$searchkeyword[4]}%'";
			}


			if(trim($searchkeyword[5])!=''){//영업회사
				$searchstring .= " and sf.cooperation_companyname like '%{$searchkeyword[5]}%'";
				$searchstring2 .= " and sf.cooperation_companyname like '%{$searchkeyword[5]}%'";
			}

			if(trim($searchkeyword[6])!=''){ //영업담당자(두리안)
				$searchstring .= " and sf.cooperation_username like '%{$searchkeyword[6]}%' ";
				$searchstring2 .= " and sf.cooperation_username like '%{$searchkeyword[6]}%' ";
			}


			if(trim($searchkeyword[7])!=''){ //예상월
				$searchstring .= " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') % sf.division_month)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') between 0 and 11";
				$searchstring2 .= " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') % 1)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') between 0 and (replace(sf.division_month,'m','')-1)";
			}

			if(trim($searchkeyword[8])!=''){ // 판매종류
				$searchstring .= " and sf.type = '{$searchkeyword[8]}'";
				$searchstring2 .= " and sf.type = '{$searchkeyword[8]}'";
			}

			if(trim($searchkeyword[9])!=''){ // 진척단계
				$searchstring .= " and sf.progress_step = '{$searchkeyword[9]}'";
				$searchstring2 .= " and sf.progress_step = '{$searchkeyword[9]}'";
			}
		} else {
			$searchstring = "";
			$searchstring2 = "";
		}

		if ($this->lv == 1) {
			$sql = "select count(sf.seq) as ucount from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and progress_step<='014' and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") and company_num = ? order by sf.seq desc";
			$query = $this->db->query($sql, $cnum);
		} else {
			$sql = "select count(sf.seq) as ucount from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and progress_step<='014' and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") order by sf.seq desc";
			$query = $this->db->query($sql);
		}
		return $query->row();
	}

	// 포캐스팅 코멘트 추가
	function forcasting_comment_insert($data)
	{
		return $this->db->insert('sales_forcasting_comment', $data);
	}

	// 포캐스팅 코멘트 등록시 본문 카운트 증가
	function forcasting_cnum_update($seq = 0)
	{
		$sql = "update sales_forcasting set cnum = cnum + 1 where seq = ?";
		$query = $this->db->query($sql, $seq);

		return	$query;
	}

	// 포캐스팅 코멘트 리스트
	function forcasting_comment_list($seq)
	{
		$sql = "select seq, forcasting_seq, user_id, user_name, contents, insert_date from sales_forcasting_comment where forcasting_seq = ? order by seq desc";
		$query = $this->db->query($sql, $seq);

		return $query->result_array();
	}

	// 포캐스팅 코멘트 삭제
	function forcasting_comment_delete($seq, $cseq)
	{
		$sql = "delete from sales_forcasting_comment where seq = ? and forcasting_seq = ?";
		$query = $this->db->query($sql, array($cseq, $seq));

		return	$query;
	}

	// 포캐스팅 코멘트 삭제시 본문 카운트 감소
	function forcasting_cnum_update2($seq = 0)
	{
		$sql = "update sales_forcasting set cnum = cnum - 1 where seq = ?";
		$query = $this->db->query($sql, $seq);

		return	$query;
	}

	//점검항목 템플릿 가져오기
	function check_list_template(){
		$sql = "select * from product_check_list_template order by seq desc";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//포캐스팅 excel download
	function forcasting_excel_download($searchkeyword,$cnum)
	{
		if ($searchkeyword != "") {
			$searchstring='';
			$searchstring2='';

			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //고객사
				$searchstring = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
				$searchstring2 = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
			}
			if(trim($searchkeyword[1])!=''){ //프로젝트명
				$searchstring .= " and sf.project_name like '%{$searchkeyword[1]}%'";
				$searchstring2 .= " and sf.project_name like '%{$searchkeyword[1]}%'";
			}

			if(trim($searchkeyword[2])!=''){ //제조사
				$searchstring .= " and p.product_company like '%{$searchkeyword[2]}%'";
				$searchstring2 .= " and p.product_company like '%{$searchkeyword[2]}%'";
			}

			if(trim($searchkeyword[3])!=''){ //제품명
				$searchstring .= " and p.product_name like '%{$searchkeyword[3]}%'";
				$searchstring2 .= " and p.product_name like '%{$searchkeyword[3]}%'";
			}

			if(trim($searchkeyword[4])!=''){ //영업부서
				$searchstring .= " and sf.dept like '%{$searchkeyword[4]}%'";
				$searchstring2 .= " and sf.dept like '%{$searchkeyword[4]}%'";
			}


			if(trim($searchkeyword[5])!=''){//영업회사
				$searchstring .= " and sf.cooperation_companyname like '%{$searchkeyword[5]}%'";
				$searchstring2 .= " and sf.cooperation_companyname like '%{$searchkeyword[5]}%'";
			}

			if(trim($searchkeyword[6])!=''){ //영업담당자(두리안)
				$searchstring .= " and sf.cooperation_username like '%{$searchkeyword[6]}%' ";
				$searchstring2 .= " and sf.cooperation_username like '%{$searchkeyword[6]}%' ";
			}


			if(trim($searchkeyword[7])!=''){ //예상월
				$searchstring .= " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') % sf.division_month)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') between 0 and 11";
				$searchstring2 .= " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') % 1)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') between 0 and (replace(sf.division_month,'m','')-1)";
			}

			if(trim($searchkeyword[8])!=''){ // 판매종류
				$searchstring .= " and sf.type = '{$searchkeyword[8]}'";
				$searchstring2 .= " and sf.type = '{$searchkeyword[8]}'";
			}

			if(trim($searchkeyword[9])!=''){ // 진척단계
				$searchstring .= " and sf.progress_step = '{$searchkeyword[9]}'";
				$searchstring2 .= " and sf.progress_step = '{$searchkeyword[9]}'";
			}
		} else {
			$searchstring = "";
			$searchstring2 = "";
		}

		if ($this->lv == 1) {
			$sql = "select sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and progress_step<='014' and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") and company_num = ? order by replace(sf.exception_saledate,'-','') DESC";
			$query = $this->db->query($sql, array($cnum));
		} else {
			$sql = "select sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name, sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and progress_step<='014' and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") order by replace(sf.exception_saledate,'-','') DESC";
			$query = $this->db->query($sql);
		}
		return array('count' => $query->num_rows(), 'data' => $query->result_array());
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

	//수주 여부 코멘트 리스트
	function forcasting_complete_status_comment_list($seq){
		$sql = "SELECT * FROM sales_forcasting_complete_status_comment WHERE forcasting_seq = {$seq}";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//수주 여부 코멘트 insert
	function forcasting_complete_status_comment_insert($data){
		return $this->db->insert('sales_forcasting_complete_status_comment',$data);
	}

	//수주 여부 코멘트 delete
	function forcasting_complete_status_comment_delete($seq){
		$sql = "delete FROM sales_forcasting_complete_status_comment WHERE seq = '{$seq}';";
		$query = $this->db->query( $sql );
		return $query;
	}

	//수주여부 코멘트 첨부파일 삭제 delete
	function forcasting_complete_status_filedel($seq){
		$sql = "update sales_forcasting_complete_status_comment set file_change_name = ?, file_real_name = ? where seq = ?";
		$result = $this->db->query($sql, array('','',$seq));
		return $result;
	}



	////////////////////////////////////////// 수주완료 스타뜨! ////////////////////////////////////////////

	// 수주완료 리스트
	function order_completed_list($searchkeyword, $start_limit = 0, $offset = 0, $cnum){
		if ($searchkeyword != "") {

			$searchstring='';
			$searchstring2='';

			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //고객사
				$searchstring = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
				$searchstring2 = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
			}
			if(trim($searchkeyword[1])!=''){ //프로젝트명
				$searchstring .= " and sf.project_name like '%{$searchkeyword[1]}%'";
				$searchstring2 .= " and sf.project_name like '%{$searchkeyword[1]}%'";
			}

			if(trim($searchkeyword[2])!=''){ //제조사
				$searchstring .= " and p.product_company like '%{$searchkeyword[2]}%'";
				$searchstring2 .= " and p.product_company like '%{$searchkeyword[2]}%'";
			}

			if(trim($searchkeyword[3])!=''){ //제품명
				$searchstring .= " and p.product_name like '%{$searchkeyword[3]}%'";
				$searchstring2 .= " and p.product_name like '%{$searchkeyword[3]}%'";
			}

			if(trim($searchkeyword[4])!=''){ //영업부서
				$searchstring .= " and sf.dept like '%{$searchkeyword[4]}%'";
				$searchstring2 .= " and sf.dept like '%{$searchkeyword[4]}%'";
			}


			if(trim($searchkeyword[5])!=''){//영업회사
				$searchstring .= " and sf.cooperation_companyname like '%{$searchkeyword[5]}%'";
				$searchstring2 .= " and sf.cooperation_companyname like '%{$searchkeyword[5]}%'";
			}

			if(trim($searchkeyword[6])!=''){ //영업담당자(두리안)
				$searchstring .= " and sf.cooperation_username like '%{$searchkeyword[6]}%' ";
				$searchstring2 .= " and sf.cooperation_username like '%{$searchkeyword[6]}%' ";
			}


			if(trim($searchkeyword[7])!=''){ //예상월
				$searchstring .= " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') % sf.division_month)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') between 0 and 11";
				$searchstring2 .= " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') % 1)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') between 0 and (replace(sf.division_month,'m','')-1)";
			}

			if(trim($searchkeyword[8])!=''){ // 판매종류
				$searchstring .= " and sf.type = '{$searchkeyword[8]}'";
				$searchstring2 .= " and sf.type = '{$searchkeyword[8]}'";
			}
			if(trim($searchkeyword[9])!=''){ // 진척단계
				$searchstring .= " and sf.progress_step = '{$searchkeyword[9]}'";
				$searchstring2 .= " and sf.progress_step = '{$searchkeyword[9]}'";
			}
			if(trim($searchkeyword[10])!=''){ // 계산서 발행 단계
				if($searchkeyword[10] == 0){
					$searchstring .= " and bill_progress_step is null";
					$searchstring2 .= " and bill_progress_step is null";
				}else if($searchkeyword[10] == 1){
					$searchstring .= " and bill_progress_step > 0 and bill_progress_step <100";
					$searchstring2 .= " and bill_progress_step > 0 and bill_progress_step <100";
				}else{
					$searchstring .= " and bill_progress_step = 100";
					$searchstring2 .= " and bill_progress_step = 100";
				}
			}
		} else {
			$searchstring = "";
			$searchstring2 = "";
		}

		if ($this->lv == 1) {
			$sql = "select sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month,sf.bill_progress_step from (SELECT *,(SELECT sum(percentage) FROM sales_forcasting_bill WHERE forcasting_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_forcasting AS s) sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") and company_num = ? and progress_step>'014' order by replace(sf.exception_saledate,'-','') DESC";
			if ($offset <> 0){
				$sql = $sql . " limit ?, ?";
			}

			$query = $this->db->query($sql, array($cnum, $start_limit, $offset));
		} else {
			$sql = "select sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name, sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month,sf.bill_progress_step from (SELECT *,(SELECT sum(percentage) FROM sales_forcasting_bill WHERE forcasting_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_forcasting AS s) sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") and progress_step>'014' order by replace(sf.exception_saledate,'-','') DESC";
			if ($offset <> 0){
				$sql = $sql . " limit ?, ?";
			}

			$query = $this->db->query($sql, array($start_limit, $offset));
		}
		return array('count' => $query->num_rows(), 'data' => $query->result_array());
	}

	//수주완료 리스트개수
	function order_completed_list_count($searchkeyword,$cnum){

		if ($searchkeyword != "") {
			$searchstring='';
			$searchstring2='';

			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //고객사
				$searchstring = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
				$searchstring2 = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
			}
			if(trim($searchkeyword[1])!=''){ //프로젝트명
				$searchstring .= " and sf.project_name like '%{$searchkeyword[1]}%'";
				$searchstring2 .= " and sf.project_name like '%{$searchkeyword[1]}%'";
			}

			if(trim($searchkeyword[2])!=''){ //제조사
				$searchstring .= " and p.product_company like '%{$searchkeyword[2]}%'";
				$searchstring2 .= " and p.product_company like '%{$searchkeyword[2]}%'";
			}

			if(trim($searchkeyword[3])!=''){ //제품명
				$searchstring .= " and p.product_name like '%{$searchkeyword[3]}%'";
				$searchstring2 .= " and p.product_name like '%{$searchkeyword[3]}%'";
			}

			if(trim($searchkeyword[4])!=''){ //영업부서
				$searchstring .= " and sf.dept like '%{$searchkeyword[4]}%'";
				$searchstring2 .= " and sf.dept like '%{$searchkeyword[4]}%'";
			}


			if(trim($searchkeyword[5])!=''){//영업회사
				$searchstring .= " and sf.cooperation_companyname like '%{$searchkeyword[5]}%'";
				$searchstring2 .= " and sf.cooperation_companyname like '%{$searchkeyword[5]}%'";
			}

			if(trim($searchkeyword[6])!=''){ //영업담당자(두리안)
				$searchstring .= " and sf.cooperation_username like '%{$searchkeyword[6]}%' ";
				$searchstring2 .= " and sf.cooperation_username like '%{$searchkeyword[6]}%' ";
			}


			if(trim($searchkeyword[7])!=''){ //예상월
				$searchstring .= " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') % sf.division_month)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') between 0 and 11";
				$searchstring2 .= " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') % 1)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') between 0 and (replace(sf.division_month,'m','')-1)";
			}

			if(trim($searchkeyword[8])!=''){ // 판매종류
				$searchstring .= " and sf.type = '{$searchkeyword[8]}'";
				$searchstring2 .= " and sf.type = '{$searchkeyword[8]}'";
			}

			if(trim($searchkeyword[9])!=''){ // 진척단계
				$searchstring .= " and sf.progress_step = '{$searchkeyword[9]}'";
				$searchstring2 .= " and sf.progress_step = '{$searchkeyword[9]}'";
			}
			if(trim($searchkeyword[10])!=''){ // 계산서 발행 단계
				if($searchkeyword[10] == 0){
					$searchstring .= " and bill_progress_step is null";
					$searchstring2 .= " and bill_progress_step is null";
				}else if($searchkeyword[10] == 1){
					$searchstring .= " and bill_progress_step > 0 and bill_progress_step <100";
					$searchstring2 .= " and bill_progress_step > 0 and bill_progress_step <100";
				}else{
					$searchstring .= " and bill_progress_step = 100";
					$searchstring2 .= " and bill_progress_step = 100";
				}
			}
		} else {
			$searchstring = "";
			$searchstring2 = "";
		}

		if ($this->lv == 1) {
			$sql = "select count(sf.seq) as ucount from (SELECT *,(SELECT sum(percentage) FROM sales_forcasting_bill WHERE forcasting_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_forcasting AS s) sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") and company_num = ? and progress_step>'014' order by sf.seq desc";
			$query = $this->db->query($sql, $cnum);
		} else {
			$sql = "select count(sf.seq) as ucount from (SELECT *,(SELECT sum(percentage) FROM sales_forcasting_bill WHERE forcasting_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_forcasting AS s) sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") and progress_step>'014' order by sf.seq desc";
			$query = $this->db->query($sql);
		}
		return $query->row();
	}

	//수주완료 excel download
	function order_completed_excel_download($searchkeyword,$cnum)
	{
		if ($searchkeyword != "") {
			$searchstring='';
			$searchstring2='';

			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //고객사
				$searchstring = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
				$searchstring2 = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
			}
			if(trim($searchkeyword[1])!=''){ //프로젝트명
				$searchstring .= " and sf.project_name like '%{$searchkeyword[1]}%'";
				$searchstring2 .= " and sf.project_name like '%{$searchkeyword[1]}%'";
			}

			if(trim($searchkeyword[2])!=''){ //제조사
				$searchstring .= " and p.product_company like '%{$searchkeyword[2]}%'";
				$searchstring2 .= " and p.product_company like '%{$searchkeyword[2]}%'";
			}

			if(trim($searchkeyword[3])!=''){ //제품명
				$searchstring .= " and p.product_name like '%{$searchkeyword[3]}%'";
				$searchstring2 .= " and p.product_name like '%{$searchkeyword[3]}%'";
			}

			if(trim($searchkeyword[4])!=''){ //영업부서
				$searchstring .= " and sf.dept like '%{$searchkeyword[4]}%'";
				$searchstring2 .= " and sf.dept like '%{$searchkeyword[4]}%'";
			}


			if(trim($searchkeyword[5])!=''){//영업회사
				$searchstring .= " and sf.cooperation_companyname like '%{$searchkeyword[5]}%'";
				$searchstring2 .= " and sf.cooperation_companyname like '%{$searchkeyword[5]}%'";
			}

			if(trim($searchkeyword[6])!=''){ //영업담당자(두리안)
				$searchstring .= " and sf.cooperation_username like '%{$searchkeyword[6]}%' ";
				$searchstring2 .= " and sf.cooperation_username like '%{$searchkeyword[6]}%' ";
			}


			if(trim($searchkeyword[7])!=''){ //예상월
				$searchstring .= " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') % sf.division_month)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') between 0 and 11";
				$searchstring2 .= " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') % 1)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') between 0 and (replace(sf.division_month,'m','')-1)";
			}

			if(trim($searchkeyword[8])!=''){ // 판매종류
				$searchstring .= " and sf.type = '{$searchkeyword[8]}'";
				$searchstring2 .= " and sf.type = '{$searchkeyword[8]}'";
			}

			if(trim($searchkeyword[9])!=''){ // 진척단계
				$searchstring .= " and sf.progress_step = '{$searchkeyword[9]}'";
				$searchstring2 .= " and sf.progress_step = '{$searchkeyword[9]}'";
			}
			if(trim($searchkeyword[10])!=''){ // 계산서 발행 단계
				if($searchkeyword[10] == 0){
					$searchstring .= " and bill_progress_step is null";
					$searchstring2 .= " and bill_progress_step is null";
				}else if($searchkeyword[10] == 1){
					$searchstring .= " and bill_progress_step > 0 and bill_progress_step <100";
					$searchstring2 .= " and bill_progress_step > 0 and bill_progress_step <100";
				}else{
					$searchstring .= " and bill_progress_step = 100";
					$searchstring2 .= " and bill_progress_step = 100";
				}
			}
		} else {
			$searchstring = "";
			$searchstring2 = "";
		}

		if ($this->lv == 1) {
			$sql = "select sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month,sf.bill_progress_step from (SELECT *,(SELECT sum(percentage) FROM sales_forcasting_bill WHERE forcasting_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_forcasting AS s) sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") and company_num = ? and progress_step>'014' order by replace(sf.exception_saledate,'-','') DESC";
			$query = $this->db->query($sql, array($cnum));
		} else {
			$sql = "select sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name, sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month,sf.bill_progress_step from (SELECT *,(SELECT sum(percentage) FROM sales_forcasting_bill WHERE forcasting_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_forcasting AS s) sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") and progress_step>'014' order by replace(sf.exception_saledate,'-','') DESC";
			$query = $this->db->query($sql);
		}
		return array('count' => $query->num_rows(), 'data' => $query->result_array());
	}

	//세금계산서 저장/수정/삭제
	function forcasting_sales_bill_save($data,$type){
		if($type == 0){//insert
			return $this->db->insert('sales_forcasting_bill',$data);
		}else if($type == 1){//update
			return $this->db->update('sales_forcasting_bill',$data, array('seq' => $data['seq']));
		}else{//delete
			$sql = "delete from sales_forcasting_bill where seq in ($data)";
			return $this->db->query( $sql );
		}

	}

	//세금계산서 가져오기
	function forcasting_sales_bill_view($seq){
		$sql = "select * from sales_forcasting_bill where forcasting_seq = {$seq}";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//진척단계 수정
	function sales_forcasting_progress_step_change($data,$seq){
		$sql = "update sales_forcasting set progress_step = '{$data}' where seq = {$seq} " ;
		return $this->db->query( $sql );
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
	function forcasting_duplication($seq){
		$sql = "INSERT INTO sales_maintain
		(forcasting_seq,
		TYPE,
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
		update_date,
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
		update_date,
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
		update_date,
		custom_title,
		custom_detail,
		product_sales,
		product_purchase,
		product_profit,
		product_check_list
		) SELECT forcasting_seq,
		{$maintain_seq} AS maintain_seq,
		{$maintain_seq} AS org_maintain_seq,  
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
		update_date,
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
		insert_date,
		update_date
		)
		SELECT forcasting_seq,
		{$maintain_seq} as maintain_seq,
		main_companyname,
		main_username,
		main_tel,
		main_email,
		insert_date,
		update_date FROM sales_forcasting_mcompany WHERE forcasting_seq = {$seq}";

		// $sql4 = "INSERT INTO sales_maintain_product_period
		// (forcasting_seq,
		// maintain_product_seq,
		// maintain_start_date,
		// maintain_end_date) 
		// select sp.forcasting_seq, sp.seq, sp.maintain_begin, sp.maintain_expire from sales_maintain_product sp, product p 
		// where sp.product_code = p.seq AND sp.forcasting_seq = {$seq} order by sp.seq asc, p.product_company desc";

		// $query1 = $this->db->query($sql);
		$query2 = $this->db->query($sql2);
		$query3 = $this->db->query($sql3);
		// $query4 = $this->db->query($sql4);

		if($query1 == true && $query2 == true && $query3 == true){
			return true;
		}else{
			return false;
		}
	}

	//유지보수 삭제
	function delete_sales_maintain($seq){
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
				WHERE a.forcasting_seq={$seq}";
		return $this->db->query($sql);
	}

}