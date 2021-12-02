<?php
header("Content-type: text/html; charset=utf-8");

class STC_Purchase_sales extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->id = $this->phpsession->get('id', 'stc');
		$this->name = $this->phpsession->get('name', 'stc');
		$this->lv = $this->phpsession->get('lv', 'stc');
		$this->cnum = $this->phpsession->get('cnum', 'stc');
	}

	function quarterly_forcasting($year,$month,$dept_code,$type){

		if($dept_code=="DUIT"){
			$dept_code = "사업1부','사업2부','기술지원부";
		}

		if($type == 1){
			$name = 'product';
		}else if($type == 4){
			$name = 'support';
		}

		if($month < 4){
			$month1 = '01';
			$month2 = '02';
			$month3 = '03';
		}else if($month > 3 && $month < 7){
			$month1 = '04';
			$month2 = '05';
			$month3 = '06';
		}else if($month > 6 && $month < 10){
			$month1 = '07';
			$month2 = '08';
			$month3 = '09';
		}else{
			$month1 = '10';
			$month2 = '11';
			$month3 = '12';
		}

		$return_arr = array();
		for($i = 1; $i < 4; $i++){
			$sql = "SELECT
				SUM(CASE WHEN bill.`type` = '002' THEN bill.issuance_amount END) AS purchase_".$name."_bill,
				SUM(CASE WHEN bill.`type` = '002' THEN bill.tax_amount END) AS purchase_".$name."_tax,
				SUM(CASE WHEN bill.`type` = '002' THEN bill.total_amount END) AS purchase_".$name."_total,
				COUNT(CASE WHEN bill.`type`='002' THEN 1 END) AS purchase_".$name."_count,
				SUM(CASE WHEN bill.`type`='001' THEN bill.issuance_amount END) AS sales_".$name."_bill,
				SUM(CASE WHEN bill.`type` = '001' THEN bill.tax_amount END) AS sales_".$name."_tax,
				SUM(CASE WHEN bill.`type` = '001' THEN bill.total_amount END) AS sales_".$name."_total,
				COUNT(CASE WHEN bill.`type`='001' THEN 1 END) AS sales_".$name."_count
				FROM (
					SELECT a.issuance_amount, a.tax_amount, a.total_amount, a.`type`
					FROM sales_forcasting_bill a
					JOIN sales_forcasting b ON a.forcasting_seq = b.seq
					WHERE a.issuance_status ='Y' AND a.`type` = '001' AND issuance_month = '{$year}-{${"month".$i}}' AND b.dept IN ('{$dept_code}') AND b.`type` = {$type}
					UNION ALL
					SELECT a.issuance_amount, a.tax_amount, a.total_amount, a.`type`
					FROM sales_forcasting_bill a
					JOIN sales_forcasting b ON a.forcasting_seq = b.seq
					WHERE a.issuance_status ='Y' AND a.`type` = '002' AND issuance_month = '{$year}-{${"month".$i}}' AND b.dept IN ('{$dept_code}') AND b.`type` = {$type}
				) AS bill;";


			$query = $this->db->query($sql);
			if($query->num_rows() <= 0 ){
				return false;

			}else{

				$result = $query->result();


				$result_val = array(
					"purchase_".$name."_bill" => $result[0]->{'purchase_'.$name.'_bill'},
					"purchase_".$name."_tax" => $result[0]->{'purchase_'.$name.'_tax'},
					"purchase_".$name."_total" => $result[0]->{'purchase_'.$name.'_total'},
					"purchase_".$name."_count" => $result[0]->{'purchase_'.$name.'_count'},
					"sales_".$name."_bill" => $result[0]->{'sales_'.$name.'_bill'},
					"sales_".$name."_tax" => $result[0]->{'sales_'.$name.'_tax'},
					"sales_".$name."_total" => $result[0]->{'sales_'.$name.'_total'},
					"sales_".$name."_count" => $result[0]->{'sales_'.$name.'_count'}
				);
				array_push($return_arr,$result_val);
			}
		}
		return $return_arr;
	}


	function quarterly_maintain($year, $month, $dept_code, $type){

		if($dept_code=="DUIT"){
			$dept_code = "사업1부','사업2부','기술지원부";
		}

		if($month < 4){
			$month1 = '01';
			$month2 = '02';
			$month3 = '03';
		}else if($month > 3 && $month < 7){
			$month1 = '04';
			$month2 = '05';
			$month3 = '06';
		}else if($month > 6 && $month < 10){
			$month1 = '07';
			$month2 = '08';
			$month3 = '09';
		}else{
			$month1 = '10';
			$month2 = '11';
			$month3 = '12';
		}

		$return_arr = array();
		for($i = 1; $i < 4; $i++){
			// ${"month".$i}
			$sql = "SELECT
				SUM(CASE WHEN bill.`type` = '002' THEN bill.issuance_amount END) AS purchase_service_bill,
				SUM(CASE WHEN bill.`type` = '002' THEN bill.tax_amount END) AS purchase_service_tax,
				SUM(CASE WHEN bill.`type` = '002' THEN bill.total_amount END) AS purchase_service_total,
				COUNT(CASE WHEN bill.`type`='002' THEN 1 END) AS purchase_service_count,
				SUM(CASE WHEN bill.`type`='001' THEN bill.issuance_amount END) AS sales_service_bill,
				SUM(CASE WHEN bill.`type` = '001' THEN bill.tax_amount END) AS sales_service_tax,
				SUM(CASE WHEN bill.`type` = '001' THEN bill.total_amount END) AS sales_service_total,
				COUNT(CASE WHEN bill.`type`='001' THEN 1 END) AS sales_service_count
				FROM (
					SELECT a.issuance_amount, a.tax_amount, a.total_amount, a.`type`
					FROM sales_maintain_bill a
					JOIN sales_maintain b ON a.maintain_seq = b.seq
					WHERE a.issuance_status ='Y' AND a.`type` = '001' AND issuance_month = '{$year}-{${"month".$i}}' AND b.dept IN ('{$dept_code}')
					UNION ALL
					SELECT a.issuance_amount, a.tax_amount, a.total_amount, a.`type`
					FROM sales_maintain_bill a
					JOIN sales_maintain b ON a.maintain_seq = b.seq
					WHERE a.issuance_status ='Y' AND a.`type` = '002' AND issuance_month = '{$year}-{${"month".$i}}' AND b.dept IN ('{$dept_code}')
					UNION ALL
					SELECT a.issuance_amount, a.tax_amount, a.total_amount, a.`type`
					FROM sales_forcasting_bill a
					JOIN sales_forcasting b ON a.forcasting_seq = b.seq
					WHERE a.issuance_status ='Y' AND a.`type` = '001' AND issuance_month = '{$year}-{${"month".$i}}' AND b.dept IN ('{$dept_code}') AND b.`type` = {$type}
					UNION ALL
					SELECT a.issuance_amount, a.tax_amount, a.total_amount, a.`type`
					FROM sales_forcasting_bill a
					JOIN sales_forcasting b ON a.forcasting_seq = b.seq
					WHERE a.issuance_status ='Y' AND a.`type` = '002' AND issuance_month = '{$year}-{${"month".$i}}' AND b.dept IN ('{$dept_code}') AND b.`type` = {$type}";

			if ($dept_code == "사업1부','사업2부','기술지원부") {
			$sql .= " UNION ALL SELECT issuance_amount, tax_amount, total_amount, '002' AS TYPE
FROM request_tech_support_bill
WHERE issuance_status = 'Y' AND issuance_month = '{$year}-{${"month".$i}}'";
			}
			$sql .= ") AS bill;";

				$query = $this->db->query($sql);

				if($query->num_rows() <= 0 ){
					return false;

				}else{
					$result = $query->result();

					$result_val = array(
						'purchase_service_bill' => $result[0]->purchase_service_bill,
						'purchase_service_tax' => $result[0]->purchase_service_tax,
						'purchase_service_total' => $result[0]->purchase_service_total,
						'purchase_service_count' => $result[0]->purchase_service_count,
						'sales_service_bill' => $result[0]->sales_service_bill,
						'sales_service_tax' => $result[0]->sales_service_tax,
						'sales_service_total' => $result[0]->sales_service_total,
						'sales_service_count' => $result[0]->sales_service_count
					);
					array_push($return_arr,$result_val);
				}
		}
		return $return_arr;
	}


	function quarterly_operation($year, $month, $dept_code){

		if($month < 4){
			$month1 = '01';
			$month2 = '02';
			$month3 = '03';
		}else if($month > 3 && $month < 7){
			$month1 = '04';
			$month2 = '05';
			$month3 = '06';
		}else if($month > 6 && $month < 10){
			$month1 = '07';
			$month2 = '08';
			$month3 = '09';
		}else{
			$month1 = '10';
			$month2 = '11';
			$month3 = '12';
		}

		$return_arr = array();
		for($i = 1; $i < 4; $i++){

			$sql = "SELECT
				SUM(CASE WHEN bill.`type` = '002' THEN bill.issuance_amount END) AS purchase_operation_bill,
				SUM(CASE WHEN bill.`type` = '002' THEN bill.tax_amount END) AS purchase_operation_tax,
				SUM(CASE WHEN bill.`type` = '002' THEN bill.total_amount END) AS purchase_operation_total,
				COUNT(CASE WHEN bill.`type`='002' THEN 1 END) AS purchase_operation_count,
				COUNT(CASE WHEN bill.`type` = '002' AND bill.bill_type = '계' THEN 1 END) AS purchase_operation_electronic_bill_type,
				COUNT(CASE WHEN bill.`type` = '002' AND bill.bill_type = '종' THEN 1 END) AS purchase_operation_paper_bill_type,
				SUM(CASE WHEN bill.`type`='001' THEN bill.issuance_amount END) AS sales_operation_bill,
				SUM(CASE WHEN bill.`type` = '001' THEN bill.tax_amount END) AS sales_operation_tax,
				SUM(CASE WHEN bill.`type` = '001' THEN bill.total_amount END) AS sales_operation_total,
				COUNT(CASE WHEN bill.`type`='001' THEN 1 END) AS sales_operation_count,
				COUNT(CASE WHEN bill.`type` = '001' AND bill.bill_type = '계' THEN 1 END) AS sales_operation_electronic_bill_type,
				COUNT(CASE WHEN bill.`type` = '001' AND bill.bill_type = '종' THEN 1 END) AS sales_operation_paper_bill_type
				FROM (
					SELECT issuance_amount, tax_amount, total_amount, `type`, bill_type
					FROM sales_operating_bill
					WHERE `type` = '001' AND issuance_month = '{$year}-{${"month".$i}}' AND dept IN ('{$dept_code}')
					UNION ALL
					SELECT issuance_amount, tax_amount, total_amount, `type`, bill_type
					FROM sales_operating_bill
					WHERE `type` = '002' AND issuance_month = '{$year}-{${"month".$i}}' AND dept IN ('{$dept_code}')
				) AS bill";

				$query = $this->db->query($sql);

				if($query->num_rows() <= 0 ){
					return false;
					// $result_val = array(
					// 	'sales_operation_bill' => null,
					// 	'purchase_operation_bill' => null
					// );
					// array_push($return_arr,$result_val);
				}else{
					$result = $query->result();
					$result_val = array(
						'purchase_operation_bill' => $result[0]->purchase_operation_bill,
						'purchase_operation_tax' => $result[0]->purchase_operation_tax,
						'purchase_operation_total' => $result[0]->purchase_operation_total,
						'purchase_operation_count' => $result[0]->purchase_operation_count,
						'purchase_operation_electronic_bill_type' => $result[0]->purchase_operation_electronic_bill_type,
						'purchase_operation_paper_bill_type' => $result[0]->purchase_operation_paper_bill_type,
						'sales_operation_bill' => $result[0]->sales_operation_bill,
						'sales_operation_tax' => $result[0]->sales_operation_tax,
						'sales_operation_total' => $result[0]->sales_operation_total,
						'sales_operation_count' => $result[0]->sales_operation_count,
						'sales_operation_electronic_bill_type' => $result[0]->sales_operation_electronic_bill_type,
						'sales_operation_paper_bill_type' => $result[0]->sales_operation_paper_bill_type
					);
					array_push($return_arr,$result_val);
				}
		}
		return $return_arr;

	}

	// 월별 매입매출장 합계
	function monthly_sum ($month, $dept_code) {

		$sql = "SELECT TYPE AS bill_type, SUM(issuance_amount) AS issuance_amount, SUM(tax_amount) AS tax_amount, SUM(total_amount) AS total_amount, COUNT(seq) AS cnt
		FROM sales_operating_bill a
		WHERE issuance_month = '{$month}' AND type = '002' AND DEPT in ({$dept_code}) GROUP BY a.type";

		$sql2 = "SELECT TYPE AS bill_type, SUM(issuance_amount) AS issuance_amount, SUM(tax_amount) AS tax_amount, SUM(total_amount) AS total_amount, COUNT(seq) AS cnt
		FROM sales_operating_bill a
		WHERE issuance_month = '{$month}' AND type = '001' AND DEPT in ({$dept_code}) GROUP BY a.type";

		$result[0] = $this->db->query($sql)->row_array();
		$result[1] = $this->db->query($sql2)->row_array();

		return $result;
	}

	/* 합계 황현빈 추가 */
	function sum_bill_cnt($type, $month, $dept_code) {
		if($dept_code == "'사업1부','사업2부','기술지원부'") {
			$dept_code = "'DUIT'";
		}
		$sql = "SELECT COUNT(*) AS cnt FROM sales_operating_bill WHERE issuance_month = '{$month}' and bill_type = '{$type}' AND DEPT in ({$dept_code}) AND type='002'";

		$query = $this->db->query($sql);

		return $query->row_array();
	}



	// 운병비 테이블에다가 인서트
	function operating_insert($data){
	  $result = $this->db->insert_batch('sales_operating_bill', $data);
	  return $result;
	}

// 운영비 select
	function operating_bill($date, $company){

		if($company == "'사업1부','사업2부','기술지원부'") {
			$company = "'DUIT'";
		}

		$sql = "SELECT * FROM sales_operating_bill WHERE issuance_month = '{$date}' AND dept IN ({$company}) ORDER BY issuance_date asc";
		$query = $this->db->query($sql);

		return $query->result();

	}

	//운영비 delete
	function operating_del($seq){
		$this->db->where('seq', $seq);
		$this->db->delete('sales_operating_bill');
	}

	function operating_update($data, $seq){

	  $this->db->where('seq', $seq);
	  $result = $this->db->update('sales_operating_bill', $data);
	  return $result;
	}

	// 사업부별 합계
	function dept_sum($date) {
		$sql = "SELECT a.type, a.dept, c.issuance_amount
FROM (
SELECT '001' AS TYPE,'사업1부' AS dept UNION
SELECT '002' AS TYPE,'사업1부' AS dept UNION
SELECT '001' AS TYPE,'사업2부' AS dept UNION
SELECT '002' AS TYPE,'사업2부' AS dept UNION
SELECT '001' AS TYPE,'기술지원부' AS dept UNION
SELECT '002' AS TYPE,'기술지원부' AS dept) AS a
LEFT JOIN
(
SELECT SUM(issuance_amount) AS issuance_amount, TYPE, dept
FROM
(
SELECT SUM(smb.issuance_amount) AS issuance_amount, smb.`type`, sm.dept
FROM sales_maintain_bill smb
JOIN sales_maintain sm ON smb.maintain_seq = sm.seq
WHERE smb.issuance_month = '{$date}'
GROUP BY smb.type, sm.dept UNION
SELECT SUM(sfb.issuance_amount) AS issuance_amount, sfb.`type`, sf.dept
FROM sales_forcasting_bill sfb
JOIN sales_forcasting sf ON sfb.forcasting_seq = sf.seq
WHERE sfb.issuance_month = '{$date}'
GROUP BY sfb.type, sf.dept UNION
SELECT SUM(issuance_amount) AS issuance_amount, '002' AS `type`, '사업2부' AS dept
FROM request_tech_support_bill WHERE issuance_month = '{$date}'
) b
GROUP BY TYPE, dept
) c ON a.type = c.type AND a.dept = c.dept;";

		$query = $this->db->query($sql);

		return $query->result();
	}


	// 상품 매입장 select
	function purchase_forcasting_bill($date,$company){
		$sql ="select distinct pay_session,seq,rseq,customer_companyname,project_name,exception_saledate,dept,tax_approval_number,issuance_date,company_name,issuance_amount,tax_amount,total_amount,issuance_month,issuance_status,p_seq
		from(SELECT *, DATE_FORMAT(exception_saledate,'%Y-%m') AS issue_schedule_date,IFNULL(rseq,s_rseq) AS p_seq FROM
		(SELECT sfb.pay_session,sfb.seq,sf.seq AS rseq, sf.customer_companyname,sf.project_name ,sf.exception_saledate, sf.dept,sfb.tax_approval_number,sfb.issuance_date,sfb.company_name,sfb.issuance_amount,sfb.tax_amount,sfb.total_amount,issuance_month,sfb.issuance_status FROM sales_forcasting AS sf
		LEFT JOIN
		(SELECT *,SUM(issuance_amount) AS s_issuance_amount, SUM(tax_amount) AS s_tax_amount, SUM(total_amount) AS s_total_amount from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 1 AND sfb.issuance_status != 'N' AND sfb.type ='002') AS a
		left join
		(SELECT sfb.pay_session as s_pay_session,sfb.seq AS s_seq, sf.seq AS s_rseq,sf.customer_companyname AS s_customer_companyname,sf.project_name AS s_project_name ,sf.exception_saledate AS s_exception_saledate, sf.dept AS s_dept, sfb.tax_approval_number AS s_tax_approval_number,sfb.issuance_date AS s_issuance_date,sfb.company_name AS s_company_name,sfb.issuance_amount AS s_issuance_amount,sfb.tax_amount AS s_tax_amount,sfb.total_amount as s_total_amount,issuance_month AS s_issuance_month,issuance_status as s_issuance_status FROM sales_forcasting AS sf
		LEFT JOIN (SELECT *,SUM(issuance_amount) AS s_issuance_amount, SUM(tax_amount) AS s_tax_amount, SUM(total_amount) AS s_total_amount from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 1 AND sfb.issuance_status != 'N' AND sfb.type ='001') AS b
		on a.rseq = b.s_rseq
		WHERE a.issuance_month ='{$date}' AND a.dept IN ({$company})
		UNION
		SELECT *, DATE_FORMAT(exception_saledate,'%Y-%m') AS issue_schedule_date,IFNULL(rseq,s_rseq) AS p_seq FROM
		(SELECT sfb.pay_session,sfb.seq,sf.seq AS rseq, sf.customer_companyname,sf.project_name ,sf.exception_saledate, sf.dept, sfb.tax_approval_number,sfb.issuance_date,sfb.company_name,sfb.issuance_amount,sfb.tax_amount,sfb.total_amount,issuance_month,issuance_status FROM sales_forcasting AS sf
		LEFT JOIN
		(SELECT *,SUM(issuance_amount) AS s_issuance_amount, SUM(tax_amount) AS s_tax_amount, SUM(total_amount) AS s_total_amount from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 1 AND sfb.issuance_status != 'N' AND sfb.type ='002') AS a
		right join
		(SELECT sfb.pay_session as s_pay_session ,sfb.seq AS s_seq, sf.seq AS s_rseq,sf.customer_companyname AS s_customer_companyname,sf.project_name AS s_project_name ,sf.exception_saledate AS s_exception_saledate, sf.dept AS s_dept, sfb.tax_approval_number AS s_tax_approval_number,sfb.issuance_date AS s_issuance_date,sfb.company_name AS s_company_name,sfb.issuance_amount AS s_issuance_amount,sfb.tax_amount AS s_tax_amount,sfb.total_amount as s_total_amount,issuance_month AS s_issuance_month, issuance_status as s_issuance_status FROM sales_forcasting AS sf
		LEFT JOIN (SELECT *,SUM(issuance_amount) AS s_issuance_amount, SUM(tax_amount) AS s_tax_amount, SUM(total_amount) AS s_total_amount from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 1 AND sfb.issuance_status != 'N' AND sfb.type ='001') AS b
		on a.rseq = b.s_rseq
		WHERE s_issuance_month ='{$date}' AND s_dept IN ({$company}) ORDER BY p_seq,pay_session,seq)as tt";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 상품 매출장 select
	function purchase_forcasting_bill2($date,$company){
		$sql ="select distinct s_pay_session,s_seq,s_rseq,s_customer_companyname,s_project_name,s_exception_saledate,s_dept,s_tax_approval_number,s_issuance_date,s_company_name,s_issuance_amount,s_tax_amount,s_total_amount,s_issuance_month,s_issuance_status,p_seq
		from(SELECT *, DATE_FORMAT(exception_saledate,'%Y-%m') AS issue_schedule_date,IFNULL(rseq,s_rseq) AS p_seq FROM
		(SELECT sfb.pay_session,sfb.seq,sf.seq AS rseq, sf.customer_companyname,sf.project_name ,sf.exception_saledate, sf.dept,sfb.tax_approval_number,sfb.issuance_date,sfb.company_name,sfb.issuance_amount,sfb.tax_amount,sfb.total_amount,issuance_month,issuance_status FROM sales_forcasting AS sf
		LEFT JOIN
		(SELECT *,SUM(issuance_amount) AS s_issuance_amount, SUM(tax_amount) AS s_tax_amount, SUM(total_amount) AS s_total_amount from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 1 AND sfb.issuance_status != 'N' AND sfb.type ='002') AS a
		left join
		(SELECT sfb.pay_session as s_pay_session,sfb.seq AS s_seq, sf.seq AS s_rseq,sf.customer_companyname AS s_customer_companyname,sf.project_name AS s_project_name ,sf.exception_saledate AS s_exception_saledate, sf.dept AS s_dept, sfb.tax_approval_number AS s_tax_approval_number,sfb.issuance_date AS s_issuance_date,sfb.company_name AS s_company_name,sfb.issuance_amount AS s_issuance_amount,sfb.tax_amount AS s_tax_amount,sfb.total_amount as s_total_amount,issuance_month AS s_issuance_month,issuance_status as s_issuance_status FROM sales_forcasting AS sf
		LEFT JOIN (SELECT *,SUM(issuance_amount) AS s_issuance_amount, SUM(tax_amount) AS s_tax_amount, SUM(total_amount) AS s_total_amount from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 1 AND sfb.issuance_status != 'N' AND sfb.type ='001') AS b
		on a.rseq = b.s_rseq
		WHERE a.issuance_month ='{$date}' AND a.dept IN ({$company})
		UNION
		SELECT *, DATE_FORMAT(exception_saledate,'%Y-%m') AS issue_schedule_date,IFNULL(rseq,s_rseq) AS p_seq FROM
		(SELECT sfb.pay_session,sfb.seq,sf.seq AS rseq, sf.customer_companyname,sf.project_name ,sf.exception_saledate, sf.dept, sfb.tax_approval_number,sfb.issuance_date,sfb.company_name,sfb.issuance_amount,sfb.tax_amount,sfb.total_amount,issuance_month,issuance_status FROM sales_forcasting AS sf
		LEFT JOIN
		(SELECT *,SUM(issuance_amount) AS s_issuance_amount, SUM(tax_amount) AS s_tax_amount, SUM(total_amount) AS s_total_amount from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 1 AND sfb.issuance_status != 'N' AND sfb.type ='002') AS a
		right join
		(SELECT sfb.pay_session as s_pay_session ,sfb.seq AS s_seq, sf.seq AS s_rseq,sf.customer_companyname AS s_customer_companyname,sf.project_name AS s_project_name ,sf.exception_saledate AS s_exception_saledate, sf.dept AS s_dept, sfb.tax_approval_number AS s_tax_approval_number,sfb.issuance_date AS s_issuance_date,sfb.company_name AS s_company_name,sfb.issuance_amount AS s_issuance_amount,sfb.tax_amount AS s_tax_amount,sfb.total_amount as s_total_amount,issuance_month AS s_issuance_month,issuance_status as s_issuance_status FROM sales_forcasting AS sf
		LEFT JOIN (SELECT *,SUM(issuance_amount) AS s_issuance_amount, SUM(tax_amount) AS s_tax_amount, SUM(total_amount) AS s_total_amount from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 1 AND sfb.issuance_status != 'N' AND sfb.type ='001') AS b
		on a.rseq = b.s_rseq
		WHERE s_issuance_month ='{$date}' AND s_dept IN ({$company}) ORDER BY p_seq,pay_session,seq, s_seq)as tt";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function distinct_forcasting_seq($date,$company){
		$sql = "SELECT distinct sf.seq AS rseq , sf.project_name, sf.customer_companyname,sf.dept,sf.exception_saledate FROM sales_forcasting AS sf
		LEFT JOIN sales_forcasting_bill AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 1 AND sfb.issuance_status != 'N' AND issuance_month = '{$date}' AND sf.dept IN ({$company})
		ORDER BY (CASE
WHEN ASCII(SUBSTRING(REPLACE(customer_companyname,'(주)',''),1)) BETWEEN 48 AND 57 THEN 3
WHEN ASCII(SUBSTRING(REPLACE(customer_companyname,'(주)',''),1)) < 128 THEN 2
ELSE 1 END),
replace(customer_companyname,'(주)',''), rseq";

		$query = $this->db->query($sql);
		return $query->result_array();
	}


	// 조달 매입장 select
	function purchase_procurement_bill($date,$company){
		$sql ="select distinct pay_session,seq,rseq,customer_companyname,project_name,exception_saledate,dept,tax_approval_number,issuance_date,company_name,issuance_amount,tax_amount,total_amount,issuance_month,issuance_status,p_seq
		from(SELECT *, DATE_FORMAT(exception_saledate,'%Y-%m') AS issue_schedule_date,IFNULL(rseq,s_rseq) AS p_seq FROM
		(SELECT sfb.pay_session,sfb.seq,sf.seq AS rseq, sf.customer_companyname,sf.project_name ,sf.exception_saledate, sf.dept,sfb.tax_approval_number,sfb.issuance_date,sfb.company_name,sfb.issuance_amount,sfb.tax_amount,sfb.total_amount,issuance_month,issuance_status FROM sales_forcasting AS sf
		LEFT JOIN
		(SELECT *,SUM(issuance_amount) AS s_issuance_amount, SUM(tax_amount) AS s_tax_amount, SUM(total_amount) AS s_total_amount from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 4 AND sfb.issuance_status != 'N' AND sfb.type ='002') AS a
		left join
		(SELECT sfb.pay_session as s_pay_session,sfb.seq AS s_seq, sf.seq AS s_rseq,sf.customer_companyname AS s_customer_companyname,sf.project_name AS s_project_name ,sf.exception_saledate AS s_exception_saledate, sf.dept AS s_dept, sfb.tax_approval_number AS s_tax_approval_number,sfb.issuance_date AS s_issuance_date,sfb.company_name AS s_company_name,sfb.issuance_amount AS s_issuance_amount,sfb.tax_amount AS s_tax_amount,sfb.total_amount as s_total_amount,issuance_month AS s_issuance_month,issuance_status as s_issuance_status FROM sales_forcasting AS sf
		LEFT JOIN (SELECT *,SUM(issuance_amount) AS s_issuance_amount, SUM(tax_amount) AS s_tax_amount, SUM(total_amount) AS s_total_amount from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 4 AND sfb.issuance_status != 'N' AND sfb.type ='001') AS b
		on a.rseq = b.s_rseq
		WHERE a.issuance_month ='{$date}' AND a.dept IN ({$company})
		UNION
		SELECT *, DATE_FORMAT(exception_saledate,'%Y-%m') AS issue_schedule_date,IFNULL(rseq,s_rseq) AS p_seq FROM
		(SELECT sfb.pay_session,sfb.seq,sf.seq AS rseq, sf.customer_companyname,sf.project_name ,sf.exception_saledate, sf.dept, sfb.tax_approval_number,sfb.issuance_date,sfb.company_name,sfb.issuance_amount,sfb.tax_amount,sfb.total_amount,issuance_month,issuance_status FROM sales_forcasting AS sf
		LEFT JOIN
		(SELECT *,SUM(issuance_amount) AS s_issuance_amount, SUM(tax_amount) AS s_tax_amount, SUM(total_amount) AS s_total_amount from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 4 AND sfb.issuance_status != 'N' AND sfb.type ='002') AS a
		right join
		(SELECT sfb.pay_session as s_pay_session ,sfb.seq AS s_seq, sf.seq AS s_rseq,sf.customer_companyname AS s_customer_companyname,sf.project_name AS s_project_name ,sf.exception_saledate AS s_exception_saledate, sf.dept AS s_dept, sfb.tax_approval_number AS s_tax_approval_number,sfb.issuance_date AS s_issuance_date,sfb.company_name AS s_company_name,sfb.issuance_amount AS s_issuance_amount,sfb.tax_amount AS s_tax_amount,sfb.total_amount as s_total_amount,issuance_month AS s_issuance_month,issuance_status as s_issuance_status FROM sales_forcasting AS sf
		LEFT JOIN (SELECT *,SUM(issuance_amount) AS s_issuance_amount, SUM(tax_amount) AS s_tax_amount, SUM(total_amount) AS s_total_amount from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 4 AND sfb.issuance_status != 'N' AND sfb.type ='001') AS b
		on a.rseq = b.s_rseq
		WHERE s_issuance_month ='{$date}' AND s_dept IN ({$company}) ORDER BY p_seq,pay_session,seq)as tt";


		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 조달 매출장 select
	function purchase_procurement_bill2($date,$company){
		$sql ="select distinct s_pay_session,s_seq,s_rseq,s_customer_companyname,s_project_name,s_exception_saledate,s_dept,s_tax_approval_number,s_issuance_date,s_company_name,s_issuance_amount,s_tax_amount,s_total_amount,s_issuance_month,s_issuance_status,p_seq
		from(SELECT *, DATE_FORMAT(exception_saledate,'%Y-%m') AS issue_schedule_date,IFNULL(rseq,s_rseq) AS p_seq FROM
		(SELECT sfb.pay_session,sfb.seq,sf.seq AS rseq, sf.customer_companyname,sf.project_name ,sf.exception_saledate, sf.dept,sfb.tax_approval_number,sfb.issuance_date,sfb.company_name,sfb.issuance_amount,sfb.tax_amount,sfb.total_amount,issuance_month,issuance_status FROM sales_forcasting AS sf
		LEFT JOIN
		(SELECT *,SUM(issuance_amount) AS s_issuance_amount, SUM(tax_amount) AS s_tax_amount, SUM(total_amount) AS s_total_amount from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 4 AND sfb.issuance_status != 'N' AND sfb.type ='002') AS a
		left join
		(SELECT sfb.pay_session as s_pay_session,sfb.seq AS s_seq, sf.seq AS s_rseq,sf.customer_companyname AS s_customer_companyname,sf.project_name AS s_project_name ,sf.exception_saledate AS s_exception_saledate, sf.dept AS s_dept, sfb.tax_approval_number AS s_tax_approval_number,sfb.issuance_date AS s_issuance_date,sfb.company_name AS s_company_name,sfb.issuance_amount AS s_issuance_amount,sfb.tax_amount AS s_tax_amount,sfb.total_amount as s_total_amount,issuance_month AS s_issuance_month,issuance_status as s_issuance_status FROM sales_forcasting AS sf
		LEFT JOIN (SELECT *,SUM(issuance_amount) AS s_issuance_amount, SUM(tax_amount) AS s_tax_amount, SUM(total_amount) AS s_total_amount from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 4 AND sfb.issuance_status != 'N' AND sfb.type ='001') AS b
		on a.rseq = b.s_rseq
		WHERE a.issuance_month ='{$date}' AND a.dept IN ({$company})
		UNION
		SELECT *, DATE_FORMAT(exception_saledate,'%Y-%m') AS issue_schedule_date,IFNULL(rseq,s_rseq) AS p_seq FROM
		(SELECT sfb.pay_session,sfb.seq,sf.seq AS rseq, sf.customer_companyname,sf.project_name ,sf.exception_saledate, sf.dept, sfb.tax_approval_number,sfb.issuance_date,sfb.company_name,sfb.issuance_amount,sfb.tax_amount,sfb.total_amount,issuance_month,issuance_status FROM sales_forcasting AS sf
		LEFT JOIN
		(SELECT *,SUM(issuance_amount) AS s_issuance_amount, SUM(tax_amount) AS s_tax_amount, SUM(total_amount) AS s_total_amount from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 4 AND sfb.issuance_status != 'N' AND sfb.type ='002') AS a
		right join
		(SELECT sfb.pay_session as s_pay_session ,sfb.seq AS s_seq, sf.seq AS s_rseq,sf.customer_companyname AS s_customer_companyname,sf.project_name AS s_project_name ,sf.exception_saledate AS s_exception_saledate, sf.dept AS s_dept, sfb.tax_approval_number AS s_tax_approval_number,sfb.issuance_date AS s_issuance_date,sfb.company_name AS s_company_name,sfb.issuance_amount AS s_issuance_amount,sfb.tax_amount AS s_tax_amount,sfb.total_amount as s_total_amount,issuance_month AS s_issuance_month,issuance_status as s_issuance_status FROM sales_forcasting AS sf
		LEFT JOIN (SELECT *,SUM(issuance_amount) AS s_issuance_amount, SUM(tax_amount) AS s_tax_amount, SUM(total_amount) AS s_total_amount from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 4 AND sfb.issuance_status != 'N' AND sfb.type ='001') AS b
		on a.rseq = b.s_rseq
		WHERE s_issuance_month ='{$date}' AND s_dept IN ({$company}) ORDER BY p_seq,pay_session,seq)as tt";


		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function distinct_procurement_seq($date,$company){
		$sql = "SELECT distinct sf.seq AS rseq , sf.project_name, sf.customer_companyname,sf.dept,sf.exception_saledate FROM sales_forcasting AS sf
		LEFT JOIN sales_forcasting_bill AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE sf.TYPE = 4 AND sfb.issuance_status != 'N' AND issuance_month = '{$date}' AND sf.dept IN ({$company})
		ORDER BY(CASE
WHEN ASCII(SUBSTRING(REPLACE(customer_companyname,'(주)',''),1)) BETWEEN 48 AND 57 THEN 3
WHEN ASCII(SUBSTRING(REPLACE(customer_companyname,'(주)',''),1)) < 128 THEN 2
ELSE 1 END),
replace(customer_companyname,'(주)',''), rseq";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function purchase_maintain_bill($date,$company){
		$sql = "(SELECT sfb.pay_session,sfb.seq,sf.seq AS rseq, sf.customer_companyname,sf.project_name ,sf.exception_saledate, sf.dept,sfb.type,sfb.tax_approval_number,sfb.issuance_date,sfb.company_name,sum(sfb.issuance_amount) AS issuance_amount,sum(sfb.tax_amount) AS tax_amount,sum(sfb.total_amount) AS total_amount,issuance_month,issuance_status,
		(SELECT COUNT(*) FROM sales_maintain AS a LEFT JOIN (SELECT * from sales_maintain_bill GROUP BY tax_approval_number,maintain_seq) AS b ON a.seq = b.maintain_seq WHERE b.issuance_status != 'N' AND b.type =sfb.type AND b.issuance_month = '{$date}' AND a.seq=sf.seq)AS cnt
		FROM sales_maintain AS sf
		LEFT JOIN sales_maintain_bill AS sfb ON sf.seq = sfb.maintain_seq
		WHERE sfb.issuance_status != 'N' AND issuance_month = '{$date}' AND sf.dept IN ({$company}) GROUP BY tax_approval_number,rseq)
		union
		(SELECT sfb.pay_session,sfb.seq,CONCAT('f',sf.seq) AS rseq, sf.customer_companyname,sf.project_name ,sf.exception_saledate, sf.dept,sfb.type,sfb.tax_approval_number,sfb.issuance_date,sfb.company_name,sum(sfb.issuance_amount) AS issuance_amount,sum(sfb.tax_amount) AS tax_amount,sum(sfb.total_amount) AS total_amount,issuance_month,issuance_status,
		(SELECT COUNT(*) FROM sales_forcasting AS a LEFT JOIN (SELECT * from sales_forcasting_bill GROUP BY tax_approval_number,forcasting_seq) AS b ON a.seq = b.forcasting_seq WHERE (a.type ='2' || a.type ='3') and b.issuance_status != 'N' AND b.type =sfb.type AND b.issuance_month = '{$date}' AND a.seq=sf.seq)AS cnt
		FROM sales_forcasting AS sf
		LEFT JOIN sales_forcasting_bill AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE (sf.type ='2' || sf.type ='3') and sfb.issuance_status != 'N' AND issuance_month = '{$date}' AND sf.dept IN ({$company}) GROUP BY tax_approval_number,rseq)
		ORDER BY rseq,company_name, pay_session,
 issuance_date,seq";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function req_maintain_val($date) {
		$sql = "SELECT '사업2부' AS dept, rtsb.tax_approval_number, rtsb.issuance_date, rts.cooperative_company, ead.approval_doc_name, rtsb.issuance_amount, rtsb.tax_amount, rtsb.total_amount, rts.customer_company
FROM request_tech_support_bill rtsb
JOIN electronic_approval_doc ead ON rtsb.annual_doc_seq = ead.seq
JOIN request_tech_support rts ON SUBSTRING_INDEX(ead.req_support_seq,'_',1) = rts.seq
WHERE rtsb.issuance_status != 'N' AND rtsb.issuance_month = '{$date}'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function distinct_maintain_seq($date,$company){
		$sql = "(SELECT distinct sf.seq AS rseq , sf.project_name, sf.customer_companyname,sf.dept FROM sales_maintain AS sf
		LEFT JOIN sales_maintain_bill AS sfb ON sf.seq = sfb.maintain_seq
		WHERE sfb.issuance_status != 'N' AND issuance_month = '{$date}' AND sf.dept IN ({$company}))
		union
		(SELECT distinct concat('f',sf.seq) AS rseq , sf.project_name, sf.customer_companyname,sf.dept FROM sales_forcasting AS sf
		LEFT JOIN sales_forcasting_bill AS sfb ON sf.seq = sfb.forcasting_seq
		WHERE (sf.type='2' || sf.type='3') and sfb.issuance_status != 'N' AND issuance_month = '{$date}' AND sf.dept IN ({$company}))
		ORDER BY (CASE
WHEN ASCII(SUBSTRING(REPLACE(customer_companyname,'(주)',''),1)) BETWEEN 48 AND 57 THEN 3
WHEN ASCII(SUBSTRING(REPLACE(customer_companyname,'(주)',''),1)) < 128 THEN 2
ELSE 1 END),
replace(customer_companyname,'(주)',''), rseq";



		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function check_maintain($seq) {
		$sql = "SELECT COUNT(*) AS cnt FROM sales_maintain_product WHERE integration_maintain_seq and maintain_seq = {$seq}";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function count_memo($tex_num) {
		$sql = "SELECT COUNT(*) AS cnt FROM sales_bill_memo WHERE tex_num = '{$tex_num}'";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function save_memo($data, $tex_num, $mode) {
		if ($mode == 'insert') {
			$result = $this->db->insert('sales_bill_memo', $data);
		} else {
			$this->db->where('tex_num', $tex_num);
		  $result = $this->db->update('sales_bill_memo', $data);
		}

		return $result;
	}

	function del_memo($tex_num, $month) {
		$sql = "DELETE FROM sales_bill_memo WHERE tex_num = '{$tex_num}' AND month = '{$month}'";

		$result = $this->db->query($sql);

		return $result;
	}

	function memo_list($month) {
		$sql = "SELECT * FROM sales_bill_memo WHERE month = '{$month}'";

		$query = $this->db->query($sql);

		return $query->result_array();
	}


	// function purchase_sales_view($date){

	// 	$sql="SELECT bill.*, main.seq, main.`type`, main.customer_seq, main.customer_companyname, main.dept, main.project_name FROM (SELECT purchase.* FROM (SELECT pur.seq AS purchase_seq, pur.maintain_seq, pur.type AS purchase_type, pur.company_name AS purchase_company_name, pur.pay_session AS purchase_pay_session, pur.issuance_amount AS purchase_issuance_amount, pur.sum_amount AS purchase_sum_amount, pur.tax_approval_number AS purchase_tax_approval_number, pur.issuance_date AS purchase_issuance_date, pur.issuance_month AS purchase_issuance_month, sale.seq AS sale_seq, sale.type AS sale_type, sale.company_name AS sale_company_name, sale.pay_session AS sale_pay_session, sale.issuance_amount AS sale_issuance_amount, sale.sum_amount AS sale_sum_amount, sale.tax_approval_number AS sale_tax_approval_number, sale.issuance_date AS sale_issuance_date, sale.issuance_month AS sale_issuance_month
	// 	FROM (SELECT distinct a.seq, a.maintain_seq, a.`type`, a.company_name, a.pay_session, a.issuance_amount, SUM(a.issuance_amount) AS sum_amount, a.tax_approval_number, a.issuance_date, a.issuance_month FROM sales_maintain_bill a WHERE a.tax_approval_number !='' AND a.tax_approval_number IS NOT NULL and a.`type` = '002' AND a.issuance_month = '{$date}' GROUP BY a.tax_approval_number) AS pur
	// 	LEFT JOIN (SELECT distinct a.seq, a.maintain_seq, a.`type`, a.company_name, a.pay_session, a.issuance_amount, SUM(a.issuance_amount) AS sum_amount, a.tax_approval_number, a.issuance_date, a.issuance_month FROM sales_maintain_bill a WHERE a.tax_approval_number !='' AND a.tax_approval_number IS NOT NULL and a.`type` = '001' AND a.issuance_month = '{$date}' GROUP BY a.tax_approval_number) AS sale
	// 	ON pur.maintain_seq = sale.maintain_seq
	// 	GROUP BY pur.seq ORDER BY pur.maintain_seq) AS purchase
	// 	UNION
	// 	SELECT sales.* FROM (SELECT pur.seq AS purchase_seq, sale.maintain_seq, pur.type AS purchase_type, pur.company_name AS purchase_company_name, pur.pay_session AS purchase_pay_session, pur.issuance_amount AS purchase_issuance_amount, pur.sum_amount AS purchase_sum_amount, pur.tax_approval_number AS purchase_tax_approval_number, pur.issuance_date AS purchase_issuance_date, pur.issuance_month AS purchase_issuance_month, sale.seq AS sale_seq, sale.type AS sale_type, sale.company_name AS sale_company_name, sale.pay_session AS sale_pay_session, sale.issuance_amount AS sale_issuance_amount, sale.sum_amount AS sale_sum_amount, sale.tax_approval_number AS sale_tax_approval_number, sale.issuance_date AS sale_issuance_date, sale.issuance_month AS sale_issuance_month
	// 	FROM (SELECT distinct a.seq, a.maintain_seq, a.`type`, a.company_name, a.pay_session, a.issuance_amount, SUM(a.issuance_amount) AS sum_amount, a.tax_approval_number, a.issuance_date, a.issuance_month FROM sales_maintain_bill a WHERE a.tax_approval_number !='' AND a.tax_approval_number IS NOT NULL and a.`type` = '001' AND a.issuance_month = '{$date}' GROUP BY a.tax_approval_number) AS sale
	// 	LEFT JOIN (SELECT distinct a.seq, a.maintain_seq, a.`type`, a.company_name, a.pay_session, a.issuance_amount, SUM(a.issuance_amount) AS sum_amount, a.tax_approval_number, a.issuance_date, a.issuance_month FROM sales_maintain_bill a WHERE a.tax_approval_number !='' AND a.tax_approval_number IS NOT NULL and a.`type` = '002' AND a.issuance_month = '{$date}' GROUP BY a.tax_approval_number) AS pur
	// 	ON pur.maintain_seq = sale.maintain_seq
	// 	WHERE pur.seq IS NULL
	// 	GROUP BY sale.seq) AS sales) AS bill
	// 	LEFT JOIN sales_maintain AS main
	// 	ON bill.maintain_seq = main.seq
	// 	ORDER BY customer_companyname, seq";

	//   $query = $this->db->query($sql);
	//   return $query->result();
	// }


}

 ?>
