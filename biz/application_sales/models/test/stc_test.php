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
			sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate,sf.company_num, p.product_company, p.product_item,product_name, sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month,sf.bill_progress_step
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
			sp.product_serial = '$sn'
		order by
			replace(sf.exception_saledate,'-','') DESC, sf.project_name DESC
		";
		$query = $this->db->query($sql);
    return $query->result_array();
	}

}
?>
