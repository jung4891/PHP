<?php
header("Content-type: text/html; charset=utf-8");

class STC_Test extends CI_Model {

	function __construct() {

		parent::__construct();
//		$this->user_id = $this->phpsession->get( 'id', 'stc' );
	}

  function user_list($sn) {
    if($sn != '') {
      $where = " AND user_name like '%{$sn}%'";
    } else {
      $where = '';
    }

    $sql = "SELECT * FROM user WHERE quit_date is null {$where} ORDER BY seq";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

	function order_completed_serial($sn) {
		$sql = "
		select
			sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate,sf.company_num, p.product_company, p.product_item,product_name, sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month,sf.bill_progress_step, sp.product_serial
		from
			(SELECT *,
				(SELECT sum(percentage) FROM sales_forcasting_bill WHERE forcasting_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step
			 FROM sales_forcasting AS s) sf,
			(select * from sales_forcasting_product) sp,
			product p
		where
			sf.seq = sp.forcasting_seq and
			p.seq = sp.product_code and
			(sf.division_month not like 'm%' or sf.division_month like 'm%') and
			progress_step>'014'and
			sp.product_serial LIKE '%$sn%'
		order by
			replace(sf.exception_saledate,'-','') DESC, sf.project_name DESC
		";
		$query = $this->db->query( $sql );
		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

	function maintain_serial($sn) {
		$forcasting = " where s.progress_step > '014' ";
		$sub_sql = "SELECT GROUP_CONCAT(sub_project_add SEPARATOR ',') AS seq FROM sales_maintain ORDER BY sub_project_add";
		$sub_query = $this->db->query($sub_sql);
		$sub_seq = $sub_query->row_array();
		$sub_seq = $sub_seq['seq'];
		$forcasting .= " AND s.seq NOT IN ({$sub_seq}) || s.seq = 401 || s.seq = 731";

		$sql = "
		SELECT
			sf.seq, sf.generate_type, sf.forcasting_seq, sf.manage_team,sf.maintain_cycle, sf.customer_companyname, sf.sales_companyname,
			sf.project_name, sf.maintain_result, sf.progress_step, sf.write_id, sf.exception_saledate2,sf.exception_saledate3,sf.company_num,
			sf.sub_project_add, p.product_company, p.product_item, p.product_name,sf.forcasting_sales,sf.forcasting_purchase, sf.forcasting_profit,
			sf.sales_pay_session,sf.bill_progress_step, sf.dept, sp.product_serial
		FROM
			(SELECT *, (SELECT count(*) FROM sales_maintain_bill WHERE maintain_seq =s.seq AND TYPE='001' AND issuance_status='Y') AS bill_progress_step
			 FROM sales_maintain AS s {$forcasting}
			) sf
			JOIN
			(SELECT a.* FROM(SELECT maintain_seq,product_code,product_serial FROM sales_maintain_product group by maintain_seq) AS a
			 	LEFT JOIN
			(select maintain_seq from sales_maintain_product WHERE integration_maintain_seq IS not null group by maintain_seq) AS b
			 	ON a.maintain_seq = b.maintain_seq
				WHERE b.maintain_seq IS NULL
			) sp
			ON sf.seq = sp.maintain_seq
		LEFT JOIN stc.product p
		ON p.seq = sp.product_code WHERE sp.product_serial LIKE '%$sn%'
		ORDER BY replace(exception_saledate2,'-','') DESC, exception_saledate3 ASC
		";
		$query = $this->db->query( $sql );
		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

	function tech_doc_serial($sn) {
		$sql = "
		SELECT *
		FROM
			tech_doc_basic tdb
			LEFT JOIN
			(SELECT basic_seq, COUNT(*) as ex_cnt FROM tech_doc_excellent_report GROUP BY basic_seq) tder
			ON tdb.seq = tder.basic_seq
		WHERE tdb.sn LIKE '%$sn%'
		ORDER BY
			tdb.seq DESC
		";
		$query = $this->db->query( $sql );
		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

}
?>
