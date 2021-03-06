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

		$this->load->Model('sales/STC_Bill_fund_link');
	}

	// 포캐스팅 기본사항 추가및 수정
	function forcasting_insert($data, $mode = 0, $seq = 0 ,$data_type = 0)
	{
		if ($mode == 0) {

			$result = $this->db->insert('sales_forcasting',$data);
			return $this->db->insert_id();

		} else {
			$result = '';
			if($data_type == '1'){
				$result =  $this->db->update('sales_forcasting', $data, array('seq' => $seq));
				$maintain_sql = "update sales_maintain set customer_companyname = '{$data['customer_companyname']}' where forcasting_seq = {$seq}";
				$this->db->query($maintain_sql);
			}else if($data_type == '2'){
				$result =  $this->db->update('sales_forcasting', $data, array('seq' => $seq));
			}else if($data_type == '3'){//매출처
				$sql = "select * from sales_forcasting where seq = {$seq}";
				$query = $this->db->query($sql);
				if ($query->num_rows() > 0) {
					$before_data = $query->row_array();
				}
				if($before_data['sales_companyname'] != $data['sales_companyname']){
					$sql = "update sales_forcasting_bill set company_name = '{$data['sales_companyname']}' where forcasting_seq = {$seq} and type='001'";
					$this->db->query($sql);
				}
				$result =  $this->db->update('sales_forcasting', $data, array('seq' => $seq));
			}else if($data_type == '4'){ //매입처
				$result =  $this->db->update('sales_forcasting', $data, array('seq' => $seq));
			}else if($data_type == '5'){
				$result =  $this->db->update('sales_forcasting', $data, array('seq' => $seq));
			}else if($data_type == '6'){
				$result =  $this->db->update('sales_forcasting', $data, array('seq' => $seq));
			}

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
		$sql = "select sp.seq, sp.product_code, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host, p.product_company, p.product_type, p.product_name, p.product_item, sp.maintain_begin, sp.maintain_expire ,sp.product_version,sp.product_sales,sp.product_purchase,sp.product_profit,sp.comment from sales_forcasting_product sp, product p where sp.product_code = p.seq and sp.forcasting_seq = ? order by sp.seq asc, p.product_company desc";
		$query = $this->db->query($sql, $seq);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//매입처별로 그룹바이해서 금액 카운트해
	function forcasting_view4($seq = 0){
		$sql = "select sp.seq, sp.product_code, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host, p.product_company, p.product_type, p.product_name, p.product_item, sp.maintain_begin, sp.maintain_expire ,sp.product_version,
		sum(sp.product_sales) AS product_sales,sum(sp.product_purchase) AS product_purchase,sum(sp.product_profit) AS product_profit ,sp.comment,
		COUNT(*) as product_cnt ,(SELECT sum(product_purchase) AS product_purchase FROM sales_forcasting_product WHERE forcasting_seq = {$seq} and product_supplier=sp.product_supplier group BY product_supplier) AS total,
		(select COUNT(*) FROM ( SELECT * FROM sales_forcasting_product WHERE forcasting_seq = {$seq} GROUP BY product_code) AS z where product_supplier = sp.product_supplier) as product_row
		from sales_forcasting_product sp, product p where sp.product_code = p.seq and sp.forcasting_seq = {$seq} group BY product_supplier";
		$query = $this->db->query($sql, $seq);
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	function forcasting_view5($seq = 0) {
		$sql = "SELECT count(DISTINCT(product_code)) AS cnt
						FROM sales_forcasting_product sp, product p
						WHERE sp.product_code = p.seq AND sp.forcasting_seq = ?
						ORDER BY sp.seq ASC, p.product_company DESC";

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
		$sql6 = "delete from sales_forcasting_log where forcasting_seq = ?";
		$query = $this->db->query($sql6, $seq);

		return	$query;
	}

	function forcasting_search($search_mode, $searchkeyword, $mode='', $type='') {
		if ($searchkeyword != "") {

			$searchstring='';
			$searchstring2='';

			$search_columns = array();

			$searchkeyword = explode(',',$searchkeyword);
			if($search_mode == 'detail') {
				if(trim($searchkeyword[0])!=''){ //고객사
					$searchstring = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
					$searchstring2 = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
					array_push($search_columns, '고객사');
				}
				if(trim($searchkeyword[1])!=''){ //프로젝트명
					$searchstring .= " and sf.project_name like '%{$searchkeyword[1]}%'";
					$searchstring2 .= " and sf.project_name like '%{$searchkeyword[1]}%'";
					array_push($search_columns, '프로젝트명');
				}

				if(trim($searchkeyword[2])!=''){ //제조사
					$searchstring .= " and p.product_company like '%{$searchkeyword[2]}%'";
					$searchstring2 .= " and p.product_company like '%{$searchkeyword[2]}%'";
					array_push($search_columns, '제조사');
				}

				if(trim($searchkeyword[3])!=''){ //제품명
					$searchstring .= " and p.product_name like '%{$searchkeyword[3]}%'";
					$searchstring2 .= " and p.product_name like '%{$searchkeyword[3]}%'";
					array_push($search_columns, '제품명');
				}

				if(trim($searchkeyword[4])!=''){ //영업부서
					$searchstring .= " and sf.dept like '%{$searchkeyword[4]}%'";
					$searchstring2 .= " and sf.dept like '%{$searchkeyword[4]}%'";
					array_push($search_columns, '영업부서');
				}


				if(trim($searchkeyword[5])!=''){//영업회사
					$searchstring .= " and sf.cooperation_companyname like '%{$searchkeyword[5]}%'";
					$searchstring2 .= " and sf.cooperation_companyname like '%{$searchkeyword[5]}%'";
					array_push($search_columns, '영업회사');
				}

				if(trim($searchkeyword[6])!=''){ //영업담당자(두리안)
					$searchstring .= " and sf.cooperation_username like '%{$searchkeyword[6]}%' ";
					$searchstring2 .= " and sf.cooperation_username like '%{$searchkeyword[6]}%' ";
					array_push($search_columns, '영업담당자');
				}


				if(trim($searchkeyword[7])!=''){ //예상월 시작
					// $searchstring .= " and (TIMESTAMPDIFF(DAY,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}') % sf.division_month)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}') between 0 and 11";
					// $searchstring2 .= " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') % 1)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'{$searchkeyword[7]}-01') between 0 and (replace(sf.division_month,'m','')-1)";
					$searchstring .= " and sf.exception_saledate >= '{$searchkeyword[7]}'";
					$searchstring2 .= " and sf.exception_saledate >= '{$searchkeyword[7]}'";
					array_push($search_columns, '예상월');
				}

				if(trim($searchkeyword[12])!=''){ //예상월 종료
					$searchstring .= " and sf.exception_saledate <= '{$searchkeyword[12]}'";
					$searchstring2 .= " and sf.exception_saledate <= '{$searchkeyword[12]}'";
					array_push($search_columns, '예상월');
				}

				if(trim($searchkeyword[8])!=''){ // 판매종류
					$searchstring .= " and sf.type = '{$searchkeyword[8]}'";
					$searchstring2 .= " and sf.type = '{$searchkeyword[8]}'";
					array_push($search_columns, '판매종류');
				}
				if(trim($searchkeyword[9])!=''){ // 진척단계
					$searchstring .= " and sf.progress_step = '{$searchkeyword[9]}'";
					$searchstring2 .= " and sf.progress_step = '{$searchkeyword[9]}'";
					array_push($search_columns, '진척단계');
				}
				if(trim($searchkeyword[10])!=''){ //정보통신공사업
					$searchstring .= " and infor_comm_corporation = '{$searchkeyword[10]}'";
					$searchstring2 .= " and infor_comm_corporation = '{$searchkeyword[10]}'";
					array_push($search_columns, '정보통신공사업');
				}
				if(trim($searchkeyword[11])!=''){ // 매출처
					$searchstring .= " and sf.sales_companyname like '%{$searchkeyword[11]}%' ";
					$searchstring2 .= " and sf.sales_companyname like '%{$searchkeyword[11]}%' ";
					array_push($search_columns, '매출처');
				}

			} else if ($search_mode == 'simple') {

				if(trim($searchkeyword[0])!=''){ // 판매종류
					$searchstring .= " and sf.type = '{$searchkeyword[0]}'";
					$searchstring2 .= " and sf.type = '{$searchkeyword[0]}'";
					array_push($search_columns, '판매종류');
				}
				if(trim($searchkeyword[1])!=''){ // 진척단계
					$searchstring .= " and sf.progress_step = '{$searchkeyword[1]}'";
					$searchstring2 .= " and sf.progress_step = '{$searchkeyword[1]}'";
					array_push($search_columns, '진척단계');
				}
				if(trim($searchkeyword[2])!=''){ //정보통신공사업
					$searchstring .= " and infor_comm_corporation = '{$searchkeyword[2]}'";
					$searchstring2 .= " and infor_comm_corporation = '{$searchkeyword[2]}'";
					array_push($search_columns, '정보통신공사업');
				}
				if(trim($searchkeyword[3])!='') {
					$searchstring .= " and (";
					$searchstring .= " sf.customer_companyname like '%{$searchkeyword[3]}%' || sf.project_name like '%{$searchkeyword[3]}%' || p.product_company like '%{$searchkeyword[3]}%' || p.product_name like '%{$searchkeyword[3]}%' || sf.dept like '%{$searchkeyword[3]}%' || sf.cooperation_companyname like '%{$searchkeyword[3]}%' || sf.cooperation_username like '%{$searchkeyword[3]}%' || sf.sales_companyname like '%{$searchkeyword[3]}%'";
					$searchstring .= " || (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[3]}-01') % sf.division_month)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[3]}-01') between 0 and 11";
					$searchstring .= " )";

					$searchstring2 .= " and (";
					$searchstring2 .= " sf.customer_companyname like '%{$searchkeyword[3]}%' || sf.project_name like '%{$searchkeyword[3]}%' || p.product_company like '%{$searchkeyword[3]}%' || p.product_name like '%{$searchkeyword[3]}%' || sf.dept like '%{$searchkeyword[3]}%' || sf.cooperation_companyname like '%{$searchkeyword[3]}%' || sf.cooperation_username like '%{$searchkeyword[3]}%' || sf.sales_companyname like '%{$searchkeyword[3]}%'";
					$searchstring2 .= " || (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[3]}-01') % 1)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'{$searchkeyword[3]}-01') between 0 and (replace(sf.division_month,'m','')-1)";
					$searchstring2 .= " )";

					array_push($search_columns, '통합검색');

				}
			}

			if ($mode != '' && $type == 'list') {
				$this->search_count($search_columns, $mode);
			}

		} else {
			$searchstring = "";
			$searchstring2 = "";
		}

		$search['searchstring'] = $searchstring;
		$search['searchstring2'] = $searchstring2;


		return $search;
	}

	function search_count($search_columns, $mode) {
		foreach($search_columns as $sc) {
			$sql = "SELECT * from search_columns_count where page = '{$mode}' and target = '{$sc}'";
			$result = $this->db->query($sql);
			if( $result->num_rows() == 0 ) {
				$sql = "INSERT INTO search_columns_count (page, target, count) values ('{$mode}', '{$sc}', 1)";
				$this->db->query($sql);
			} else {
				$sql = "UPDATE search_columns_count set count = count + 1 where page = '{$mode}' and target = '{$sc}'";
				$this->db->query($sql);
			}
		}
	}

	// 포캐스팅 리스트
	function forcasting_list($search_mode,$searchkeyword, $start_limit = 0, $offset = 0, $cnum,$mode,$type='')	{

		$search = $this->forcasting_search($search_mode, $searchkeyword, $mode, $type);

		$searchstring = $search['searchstring'];
		$searchstring2 = $search['searchstring2'];

		if($mode == 'forcasting'){
			$sql = "select sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name, sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and progress_step <='014' and progress_step != '000' and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") order by replace(sf.exception_saledate,'-','') DESC, sf.project_name DESC";
		}else{
			$sql = "select sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name, sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and progress_step = '000' and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") order by replace(sf.exception_saledate,'-','') DESC, sf.project_name DESC";
		}

		if ($offset <> 0){
			$sql = $sql . " limit ".$start_limit.", ".$offset;
		}

		$query = $this->db->query($sql);

		return array('count' => $query->num_rows(), 'data' => $query->result_array());
	}

	//포캐스팅 리스트개수
	function forcasting_list_count($search_mode,$searchkeyword,$cnum,$mode){

		$search = $this->forcasting_search($search_mode, $searchkeyword);

		$searchstring = $search['searchstring'];
		$searchstring2 = $search['searchstring2'];

		if($mode == "forcasting"){
			$sql = "select count(sf.seq) as ucount from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and progress_step <='014' and progress_step != '000' and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") order by sf.seq desc, sf.project_name DESC";
		}else{
			$sql = "select count(sf.seq) as ucount from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and progress_step = '000' and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") order by sf.seq desc, sf.project_name DESC";
		}
		$query = $this->db->query($sql);

		return $query->row();
	}

	//포캐스팅 excel download
	function forcasting_excel_download($search_mode,$searchkeyword,$cnum,$mode) {

		$search = $this->forcasting_search($search_mode, $searchkeyword);

		$searchstring = $search['searchstring'];
		$searchstring2 = $search['searchstring2'];

		if($mode == "forcasting"){
			$sql = "select sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name, sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and progress_step <= '014' and progress_step !='000' and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") order by replace(sf.exception_saledate,'-','') DESC, sf.project_name DESC";
		}else{
			$sql = "select sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name, sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and progress_step = '000' and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") order by replace(sf.exception_saledate,'-','') DESC, sf.project_name DESC";
		}
		$query = $this->db->query($sql);

		return array('count' => $query->num_rows(), 'data' => $query->result_array());
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
	function order_completed_search($search_mode, $searchkeyword, $mode='', $type='') {
		if ($searchkeyword != "") {

			$searchstring='';
			$searchstring2='';

			$search_columns = array();

			$searchkeyword = explode(',',$searchkeyword);
			if($search_mode == 'detail') {
				if(trim($searchkeyword[0])!=''){ //고객사
					$searchstring = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
					$searchstring2 = " and sf.customer_companyname like '%{$searchkeyword[0]}%'";
					array_push($search_columns, '고객사');
				}
				if(trim($searchkeyword[1])!=''){ //프로젝트명
					$searchstring .= " and sf.project_name like '%{$searchkeyword[1]}%'";
					$searchstring2 .= " and sf.project_name like '%{$searchkeyword[1]}%'";
					array_push($search_columns, '프로젝트명');
				}

				if(trim($searchkeyword[2])!=''){ //제조사
					$searchstring .= " and p.product_company like '%{$searchkeyword[2]}%'";
					$searchstring2 .= " and p.product_company like '%{$searchkeyword[2]}%'";
					array_push($search_columns, '제조사');
				}

				if(trim($searchkeyword[3])!=''){ //제품명
					$searchstring .= " and p.product_name like '%{$searchkeyword[3]}%'";
					$searchstring2 .= " and p.product_name like '%{$searchkeyword[3]}%'";
					array_push($search_columns, '제품명');
				}

				if(trim($searchkeyword[4])!=''){ //영업부서
					$searchstring .= " and sf.dept like '%{$searchkeyword[4]}%'";
					$searchstring2 .= " and sf.dept like '%{$searchkeyword[4]}%'";
					array_push($search_columns, '영업부서');
				}


				if(trim($searchkeyword[5])!=''){//영업회사
					$searchstring .= " and sf.cooperation_companyname like '%{$searchkeyword[5]}%'";
					$searchstring2 .= " and sf.cooperation_companyname like '%{$searchkeyword[5]}%'";
					array_push($search_columns, '영업회사');
				}

				if(trim($searchkeyword[6])!=''){ //영업담당자(두리안)
					$searchstring .= " and sf.cooperation_username like '%{$searchkeyword[6]}%' ";
					$searchstring2 .= " and sf.cooperation_username like '%{$searchkeyword[6]}%' ";
					array_push($search_columns, '영업담당자');
				}


				if(trim($searchkeyword[7])!=''){ //예상월
					$searchstring .= " and sf.exception_saledate >= '{$searchkeyword[7]}'";
					$searchstring2 .= " and sf.exception_saledate >= '{$searchkeyword[7]}'";
					array_push($search_columns, '예상월');
				}

				if(trim($searchkeyword[15])!=''){ //예상월
					$searchstring .= " and sf.exception_saledate <= '{$searchkeyword[15]}'";
					$searchstring2 .= " and sf.exception_saledate <= '{$searchkeyword[15]}'";
					array_push($search_columns, '예상월');
				}

				if(trim($searchkeyword[8])!=''){ // 판매종류
					$searchstring .= " and sf.type = '{$searchkeyword[8]}'";
					$searchstring2 .= " and sf.type = '{$searchkeyword[8]}'";
					array_push($search_columns, '판매종류');
				}
				if(trim($searchkeyword[9])!=''){ // 진척단계
					$searchstring .= " and sf.progress_step = '{$searchkeyword[9]}'";
					$searchstring2 .= " and sf.progress_step = '{$searchkeyword[9]}'";
					array_push($search_columns, '진척단계');
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
					array_push($search_columns, '계산서발행');
				}
				if(trim($searchkeyword[11])!=''){ // 정보통신공사업
					$searchstring .= " and infor_comm_corporation = '{$searchkeyword[11]}'";
					$searchstring2 .= " and infor_comm_corporation = '{$searchkeyword[11]}'";
					array_push($search_columns, '정보통신공사업');
				}
				//매출금액 검색
				if(trim($searchkeyword[12])!=''){
					$searchstring .= " and forcasting_sales >= {$searchkeyword[12]}";
					$searchstring2 .= " and forcasting_sales >= {$searchkeyword[12]}";
				}

				if(trim($searchkeyword[13])!=''){
					$searchstring .= " and forcasting_sales <= {$searchkeyword[13]}";
					$searchstring2 .= " and forcasting_sales <= {$searchkeyword[13]}";
				}

				if(trim($searchkeyword[12])!='' || trim($searchkeyword[13]!='')) {
					array_push($search_columns, '매출금액');
				}

				if(trim($searchkeyword[14])!=''){ // 매출처
					$searchstring .= " and sf.sales_companyname like '%{$searchkeyword[14]}%' ";
					$searchstring2 .= " and sf.sales_companyname like '%{$searchkeyword[14]}%' ";
					array_push($search_columns, '매출처');
				}

			} else if ($search_mode == 'simple') {

				if(trim($searchkeyword[0])!=''){ // 판매종류
					$searchstring .= " and sf.type = '{$searchkeyword[0]}'";
					$searchstring2 .= " and sf.type = '{$searchkeyword[0]}'";
					array_push($search_columns, '판매종류');
				}

				if(trim($searchkeyword[1])!=''){ // 진척단계
					$searchstring .= " and sf.progress_step = '{$searchkeyword[1]}'";
					$searchstring2 .= " and sf.progress_step = '{$searchkeyword[1]}'";
					array_push($search_columns, '진척단계');
				}

				if(trim($searchkeyword[2])!=''){ // 정보통신공사업
					$searchstring .= " and infor_comm_corporation = '{$searchkeyword[2]}'";
					$searchstring2 .= " and infor_comm_corporation = '{$searchkeyword[2]}'";
					array_push($search_columns, '정보통신공사업');
				}

				//매출금액 검색
				if(trim($searchkeyword[3])!=''){
					$searchstring .= " and forcasting_sales >= {$searchkeyword[3]}";
					$searchstring2 .= " and forcasting_sales >= {$searchkeyword[3]}";
				}

				if(trim($searchkeyword[4])!=''){
					$searchstring .= " and forcasting_sales <= {$searchkeyword[4]}";
					$searchstring2 .= " and forcasting_sales <= {$searchkeyword[4]}";
				}

				if(trim($searchkeyword[3])!='' || trim($searchkeyword[4]!='')) {
					array_push($search_columns, '매출금액');
				}

				if(trim($searchkeyword[5]!='')) {
					$searchstring .= " and (";
					$searchstring .= " sf.customer_companyname like '%{$searchkeyword[5]}%' || sf.project_name like '%{$searchkeyword[5]}%' || p.product_company like '%{$searchkeyword[5]}%' || p.product_name like '%{$searchkeyword[5]}%' || sf.dept like '%{$searchkeyword[5]}%' || sf.cooperation_companyname like '%{$searchkeyword[5]}%' || sf.cooperation_username like '%{$searchkeyword[5]}%' || sf.sales_companyname like '%{$searchkeyword[5]}%'";
					$searchstring .= " || (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[5]}-01') % sf.division_month)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[5]}-01') between 0 and 11";
					$searchstring .= " )";

					$searchstring2 .= " and (";
					$searchstring2 .= " sf.customer_companyname like '%{$searchkeyword[5]}%' || sf.project_name like '%{$searchkeyword[5]}%' || p.product_company like '%{$searchkeyword[5]}%' || p.product_name like '%{$searchkeyword[5]}%' || sf.dept like '%{$searchkeyword[5]}%' || sf.cooperation_companyname like '%{$searchkeyword[5]}%' || sf.cooperation_username like '%{$searchkeyword[5]}%' || sf.sales_companyname like '%{$searchkeyword[5]}%'";
					$searchstring2 .= " || (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$searchkeyword[5]}-01') % 1)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'{$searchkeyword[5]}-01') between 0 and (replace(sf.division_month,'m','')-1)";
					$searchstring2 .= " )";

					array_push($search_columns, '통합검색');
				}

			}

			if ($mode != '' && $type == 'list') {
				$this->search_count($search_columns, $mode);
			}

		} else {
			$searchstring = "";
			$searchstring2 = "";
		}

		$search['searchstring'] = $searchstring;
		$search['searchstring2'] = $searchstring2;

		return $search;
	}

	// 수주완료 리스트
	function order_completed_list($search_mode, $searchkeyword, $start_limit = 0, $offset = 0, $cnum, $type=''){

		$search = $this->order_completed_search($search_mode, $searchkeyword, 'order_completed', $type);

		$searchstring = $search['searchstring'];
		$searchstring2 = $search['searchstring2'];

		$sql = "select sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name, sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month,sf.bill_progress_step from (SELECT *,(SELECT sum(percentage) FROM sales_forcasting_bill WHERE forcasting_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_forcasting AS s) sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") and progress_step>'014' order by replace(sf.exception_saledate,'-','') DESC, sf.project_name DESC";
		if ($offset <> 0){
			$sql = $sql . " limit ".$start_limit.", ".$offset;
		}

		$query = $this->db->query($sql);

		return array('count' => $query->num_rows(), 'data' => $query->result_array());
	}

	//수주완료 리스트개수
	function order_completed_list_count($search_mode, $searchkeyword,$cnum){

		$search = $this->order_completed_search($search_mode, $searchkeyword);

		$searchstring = $search['searchstring'];
		$searchstring2 = $search['searchstring2'];

		$sql = "select count(sf.seq) as ucount from (SELECT *,(SELECT sum(percentage) FROM sales_forcasting_bill WHERE forcasting_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_forcasting AS s) sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") and progress_step>'014' order by sf.seq desc, sf.project_name DESC";
		$query = $this->db->query($sql);

		return $query->row();
	}

	//수주완료 excel download
	function order_completed_excel_download($search_mode,$searchkeyword,$cnum) {

		$search = $this->order_completed_search($search_mode, $searchkeyword);

		$searchstring = $search['searchstring'];
		$searchstring2 = $search['searchstring2'];

		$sql = "select sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name, sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month,sf.bill_progress_step from (SELECT *,(SELECT sum(percentage) FROM sales_forcasting_bill WHERE forcasting_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step FROM sales_forcasting AS s) sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") and progress_step>'014' order by replace(sf.exception_saledate,'-','') DESC, sf.project_name DESC";
		$query = $this->db->query($sql);
		// }
		return array('count' => $query->num_rows(), 'data' => $query->result_array());
	}

	//세금계산서 저장/수정/삭제
	function forcasting_sales_bill_save($data,$type){
		if($type == 0){//insert
			$result = $this->db->insert('sales_forcasting_bill',$data);
			$bill_seq = $this->db->insert_id();
			$this->STC_Bill_fund_link->bill_fund_link($bill_seq, $data['issuance_status'], $data['issuance_month'], 'forcasting');
			return $result;
		}else if($type == 1){//update
			$result = $this->db->update('sales_forcasting_bill',$data, array('seq' => $data['seq']));
			$bill_seq = $data['seq'];
			$this->STC_Bill_fund_link->bill_fund_link($bill_seq, $data['issuance_status'], $data['issuance_month'], 'forcasting');
			return $result;
		}else{//delete
			$sql = "delete from sales_forcasting_bill where seq in ($data)";
			$this->STC_Bill_fund_link->bill_fund_link_delete($data, 'forcasting');
			return $this->db->query( $sql );
		}

	}

	//세금계산서 가져오기
	function forcasting_sales_bill_view($seq){
		$sql = "select * from sales_forcasting_bill where forcasting_seq = {$seq} order by pay_session,seq";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//진척단계 수정
	function sales_forcasting_progress_step_change($data,$seq){
		$sql = "update sales_forcasting set progress_step = '{$data}',
		update_date = now(),
		write_id = '{$this->id}' where seq = {$seq} " ;
		return $this->db->query( $sql );
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

	//매입처 등록/수정/삭제
	function forcasting_main_insert($data,$mode,$forcasting_seq){
		if($mode == 0) { //forcasting_mcompany insert
			$result = $this->db->insert('sales_forcasting_mcompany',$data);
			$bill_sql = "select * from sales_forcasting_bill where forcasting_seq = {$forcasting_seq} ";
			$bill_query = $this->db->query($bill_sql);
			if ($bill_query->num_rows() > 0) {
				$insert_sql = "insert into sales_forcasting_bill
				(forcasting_seq, type, company_name, percentage,issuance_amount,write_id,insert_date)
				values
				('{$forcasting_seq}','002','{$data['main_companyname']}','0','0','{$this->id}' ,now()) ";
				$this->db->query($insert_sql);
			}
		}else if ($mode == 1) {//forcasting_mcompany update
			$sql = "select * from sales_forcasting_mcompany where seq = {$data['seq']}";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				$before_data = $query->row_array();
			}
			if($before_data['main_companyname'] != $data['main_companyname']){
				$sql = "update sales_forcasting_bill set company_name = '{$data['main_companyname']}' where forcasting_seq = {$forcasting_seq} and type='002' and company_name = '{$before_data['main_companyname']}'";
				$sql2= "update sales_forcasting_product set product_supplier = '{$data['main_companyname']}' where forcasting_seq = {$forcasting_seq}  and product_supplier = '{$before_data['main_companyname']}' ";
				$this->db->query($sql);
				$this->db->query($sql2);
			}
			$result =  $this->db->update('sales_forcasting_mcompany',$data, array('seq' => $data['seq']));
		}else{//forcasting_mcompany delete
			$sql = "delete from sales_forcasting_bill where forcasting_seq = {$forcasting_seq} and type='002' and company_name = (select main_companyname from sales_forcasting_mcompany where seq = {$data})";
			$this->db->query($sql);
			$sql1 = "delete from sales_forcasting_mcompany where seq = {$data}";
			$result = $this->db->query($sql1);
		}
		return $result;
	}

	//제품 등록/수정/삭제
	function forcasting_product_insert($data,$mode,$forcasting_seq){
		if($mode == 0) { //forcasting_product insert
			$result = $this->db->insert('sales_forcasting_product',$data);
		}else if ($mode == 1) {//modify
			$result =  $this->db->update('sales_forcasting_product',$data, array('seq' => $data['seq']));
			$maintain_sql = "update sales_maintain_product set product_code = '{$data['product_code']}' where forcasting_product_seq = {$data['seq']} ";
			$result = $this->db->query($maintain_sql);
		}else{//delete
			$sql = "delete from sales_forcasting_product where seq = {$data}";
			$result = $this->db->query($sql);
		}
		return $result;
	}


	// 고객사 셀렉트창 검색이요
		function select_customer($keyword){
		if($keyword==""){
			$sql = "SELECT * FROM sales_customer_basic";
		}else{
			// $sql= "SELECT a.seq, a.company_name FROM sales_customer_basic AS a WHERE a.company_name LIKE '%{$keyword}%' or a.seq = (SELECT b.customer_seq FROM sales_customer_basic_history AS b WHERE b.before_company_name LIKE '%{$keyword}%')";
			$sql = "SELECT customer_seq FROM sales_customer_basic_history WHERE before_company_name LIKE '%{$keyword}%'";
			$query = $this->db->query($sql);
		 if ($query->num_rows() > 0) {
			 $target_customer = array();
			 $target_seq = $query->result();
			 foreach ($target_seq as $ts) {

				 if(!in_array($ts->customer_seq, $target_customer)){
					 array_push($target_customer, $ts->customer_seq);
				 }
			 }
			 $target_customer = implode("|", $target_customer);
			 $search_customer = " OR seq REGEXP '{$target_customer}'";
		 }else{
			 $search_customer = "";
		 }
		 $sql = "SELECT seq, company_name FROM sales_customer_basic WHERE company_name LIKE '%{$keyword}%'{$search_customer}";

		}
			$query = $this->db->query($sql);
			return $query->result();
		}


		//해당하는 품의서가 있나 찾아아바 ^0^
		function approval_doc($seq){
			$sql = "select * from electronic_approval_doc WHERE sales_seq = '{$seq}' AND approval_doc_status not in ('003','004') ORDER BY seq DESC LIMIT 1";
			$query = $this->db->query( $sql );

			if ($query->num_rows() <= 0) {
				return false;
			} else {
				return $query->row_array();
			}
		}

		// 작성자, 수정자 로그 기록
		function forcasting_log_insert ($data) {
			$result = $this->db->insert('sales_forcasting_log', $data);
		}

		function log_data($log_type, $seq) {
			if ($log_type=="insert"){
				$sql = "SELECT sfl.*, u.user_name FROM sales_forcasting_log sfl JOIN user u ON sfl.write_seq = u.seq WHERE log_type = '{$log_type}' AND forcasting_seq = {$seq}";
			} else {
				$sql ="SELECT sfl.*, u.user_name FROM sales_forcasting_log sfl JOIN user u ON sfl.write_seq = u.seq WHERE log_type = '{$log_type}' AND forcasting_seq = {$seq} ORDER BY update_date DESC LIMIT 1";
			}
			$query = $this->db->query($sql);
			if($query->num_rows() <= 0) {
				return false;
			} else {
				return $query->row_array();
			}
		}

		function forcasting_copy($data, $seq){
			$forcasting_insert = $this->db->insert('sales_forcasting', $data);
			if($forcasting_insert){
				$this->db->where('seq', $seq);
				$this->db->update('sales_forcasting', array('org_seq' => 'org'));

				$sql = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'sales_forcasting' AND table_schema = DATABASE( )";
				$query = $this->db->query($sql)->row();
				$copy_seq = $query->AUTO_INCREMENT-1;

				return $copy_seq;

			}else{

				return false;

			}


		}

		function mcompany_copy($data, $type){
			if($type == 'mcompany'){

				$this->db->insert('sales_forcasting_mcompany', $data);
			}else{
				$this->db->insert('sales_forcasting_product', $data);
			}
		}

		function forcasting_adjust($search_mode, $searchkeyword, $mode) {
			$target = false;
			$dept_string = '';
			$company_string = '';
			$calc_string = '';

			if($searchkeyword != '') {
				if($search_mode == 'detail') {
					$searchkeyword = explode(',',$searchkeyword);

					if(trim($searchkeyword[7]) != '') { // 예상월 시작
						$target = true;
						$s_date = substr($searchkeyword[7], 0, 8).'01';
						if($mode == 'minus') {
							$calc_string .= " AND DATE_FORMAT(exception_saledate, '%Y-%m-01') >= '{$s_date}'";
						} else {
							$calc_string .= " AND DATE_FORMAT(issuance_date, '%Y-%m-01') >= '{$s_date}'";
						}
					}

					if(trim($searchkeyword[15]) != '') { // 예상월 종료
						$target = true;
						$t = date('t', strtotime($searchkeyword[15]));
						$e_date = substr($searchkeyword[15], 0, 8).$t;
						if($mode == 'minus') {
							$calc_string .= " AND DATE_FORMAT(exception_saledate, '%Y-%m-{$t}') <= '{$e_date}'";
						} else {
							$calc_string .= " AND DATE_FORMAT(issuance_date, '%Y-%m-{$t}') <= '{$e_date}'";
						}
					}

					if(trim($searchkeyword[4]) != '') { // 부서
						$dept_string = " AND dept like '%{$searchkeyword[4]}%'";
					}

					if(trim($searchkeyword[5]) != '') { // 회사
						$company_string = " AND cooperation_companyname like '%{$searchkeyword[5]}%'";
					}
				}
			}

			if($target) {
				$sql = "SELECT IFNULL(SUM(issuance_amount),0) AS sum
		            FROM sales_forcasting_bill sfb
		            JOIN sales_forcasting sf ON sfb.forcasting_seq = sf.seq
		            WHERE sfb.`type` = '001'
		            AND sfb.issuance_status = 'Y'
		            {$dept_string} {$company_string} {$calc_string}";
				$query = $this->db->query($sql);

				return $query->row_array();
			} else {
				return false;
			}
			
		}


}
