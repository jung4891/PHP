<?php
header("Content-type: text/html; charset=utf-8");

class STC_accounts_receivable_unpaid extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->id = $this->phpsession->get('id', 'stc');
		$this->name = $this->phpsession->get('name', 'stc');
		$this->lv = $this->phpsession->get('lv', 'stc');
		$this->cnum = $this->phpsession->get('cnum', 'stc');
	}

	function distinct_forcasting_seq() {
		$sql = "SELECT distinct(t.rseq), customer_companyname, null as deposit_date, cooperation_companyname FROM (SELECT DISTINCT(CONCAT('f_',sf.seq)) AS rseq, customer_companyname, cooperation_companyname
						FROM sales_forcasting sf
						JOIN sales_forcasting_bill sfb ON sf.seq = sfb.forcasting_seq
						WHERE sf.type = 1 AND sfb.issuance_status = 'Y' AND sfb.issuance_date >= '2022-01-01' AND sfb.deposit_status != 'Y' ORDER BY SUBSTRING(REPLACE(customer_companyname,'(주)',''),1)) t";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function distinct_maintain_seq() {
		$sql = "SELECT DISTINCT(t.rseq), customer_companyname, NULL AS deposit_date, cooperation_companyname
FROM ((
SELECT DISTINCT(CONCAT('m_', sm.seq)) AS rseq, customer_companyname, smb.issuance_date, project_name, cooperation_companyname
FROM sales_maintain sm
JOIN sales_maintain_bill smb ON sm.seq = smb.maintain_seq
WHERE smb.issuance_status = 'Y' AND smb.issuance_date >= '2022-01-01' AND smb.deposit_status != 'Y' and smb.maintain_seq != 778) UNION
						(
SELECT DISTINCT(CONCAT('f_',sf.seq)) AS rseq, customer_companyname, sfb.issuance_date, project_name, cooperation_companyname
FROM sales_forcasting sf
JOIN sales_forcasting_bill sfb ON sf.seq = sfb.forcasting_seq
WHERE (sf.type = '2' OR sf.type = '3') AND sfb.issuance_status = 'Y' AND sfb.issuance_date >= '2022-01-01' AND sfb.deposit_status != 'Y') UNION
						(
SELECT DISTINCT(CONCAT('r_', rts.seq)) AS rseq, rts.customer_company AS customer_companyname, rtsb.issuance_date, NULL AS project_name, '두리안정보기술' AS cooperation_companyname
FROM request_tech_support_bill rtsb
JOIN electronic_approval_doc ead ON rtsb.annual_doc_seq = ead.seq
JOIN request_tech_support rts ON SUBSTRING_INDEX(ead.req_support_seq, '_', 1) = rts.seq
WHERE rtsb.issuance_status = 'Y' AND rtsb.issuance_date >= '2022-01-01' AND rtsb.deposit_status != 'Y')
					) t
ORDER BY SUBSTRING(
REPLACE(customer_companyname,'(주)',''),1), issuance_date";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function distinct_procurement_seq() {
		$sql = "SELECT DISTINCT(t.rseq), customer_companyname, NULL AS deposit_date, cooperation_companyname
FROM (
SELECT DISTINCT(CONCAT('f_',sf.seq)) AS rseq, customer_companyname, cooperation_companyname
FROM sales_forcasting sf
JOIN sales_forcasting_bill sfb ON sf.seq = sfb.forcasting_seq
WHERE sf.type = 4 AND sfb.issuance_status = 'Y' AND sfb.issuance_date >= '2022-01-01' AND sfb.deposit_status != 'Y'
ORDER BY SUBSTRING(
REPLACE(customer_companyname,'(주)',''),1)) t";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function bill_data($seq, $type) {
		$table_seq = explode('_', $seq);
		$table_seq = $table_seq[1];

		if (strpos($seq, 'f_') !== false) {
			$sql = "SELECT CONCAT('f_', sf.seq) AS rseq, sfb.issuance_date, sfb.tax_approval_number, sfb.company_name, sf.project_name, sfb.total_amount, sfb.deposit_date, sfb.deposit_status, sfb.issuance_month
			FROM sales_forcasting_bill sfb
			JOIN sales_forcasting sf ON sfb.forcasting_seq = sf.seq
			WHERE sfb.type = '{$type}' AND sfb.issuance_date >= '2022-01-01' AND sfb.issuance_status = 'Y' AND sfb.deposit_status != 'Y' AND sf.seq = '{$table_seq}'";

		} else if (strpos($seq, 'm_') !== false) {
			$sql = "SELECT CONCAT('m_', sm.seq) AS rseq, smb.pay_session, smb.issuance_date, smb.tax_approval_number, smb.company_name, sm.project_name, smb.pay_session, smb.total_amount, smb.deposit_date, smb.deposit_status, smb.issuance_month
			FROM sales_maintain_bill smb
			JOIN sales_maintain sm ON smb.maintain_seq = sm.seq
			WHERE smb.type = '{$type}' AND smb.issuance_date >= '2022-01-01' AND smb.issuance_status = 'Y' AND smb.deposit_status != 'Y' AND sm.seq = '{$table_seq}' ORDER BY smb.issuance_month";
		} else if (strpos($seq, 'r_') !== false) {
			if ($type == '002') {
				$sql = "SELECT CONCAT('r_', rts.seq) AS rseq, rtsb.issuance_date, rtsb.tax_approval_number, rts.cooperative_company AS company_name, SUBSTRING_INDEX(ead.approval_doc_name, ']', -1) AS project_name,
				rtsb.total_amount, rtsb.deposit_date, rtsb.deposit_status, rtsb.issuance_month
				FROM request_tech_support_bill rtsb
				JOIN electronic_approval_doc ead ON rtsb.annual_doc_seq = ead.seq
				JOIN request_tech_support rts ON SUBSTRING_INDEX(ead.req_support_seq,'_',1) = rts.seq
				WHERE rtsb.issuance_date >= '2022-01-01' AND rtsb.issuance_status = 'Y' AND rtsb.deposit_status != 'Y' AND rts.seq = {$table_seq}";
			} else {
				$sql = "SELECT * from request_tech_support_bill where seq = 0";
			}
		}
		$query = $this->db->query($sql);

		$row = $query->num_rows();

		if ($row == 0) {
			$result = $this->bill_data_adjust($seq, $type);
		} else {
			$result = $query->result_array();
		}
		return $result;
	}

	function pay_session_data($seq, $pay_session) {
		$table_seq = explode('_', $seq);
		$table_seq = $table_seq[1];

		if (strpos($seq, 'f_') !== false) {
			$sql = "SELECT CONCAT('f_', sf.seq) AS rseq, sfb.issuance_date, sfb.tax_approval_number, sfb.company_name, sf.project_name, sfb.total_amount, sfb.deposit_date, sfb.deposit_status, sfb.issuance_month
			FROM sales_forcasting_bill sfb
			JOIN sales_forcasting sf ON sfb.forcasting_seq = sf.seq
			WHERE sfb.type = '001' AND sfb.issuance_date >= '2022-01-01' AND sfb.issuance_status = 'Y' AND sfb.deposit_status = 'Y' AND sfb.pay_session = '{$pay_session}' AND sf.seq = '{$table_seq}'";

		} else if (strpos($seq, 'm_') !== false) {
			$sql = "SELECT CONCAT('m_', sm.seq) AS rseq, smb.pay_session, smb.issuance_date, smb.tax_approval_number, smb.company_name, sm.project_name, smb.total_amount, smb.deposit_date, smb.deposit_status, smb.issuance_month
			FROM sales_maintain_bill smb
			JOIN sales_maintain sm ON smb.maintain_seq = sm.seq
			WHERE smb.type = '001' AND smb.issuance_date >= '2022-01-01' AND smb.issuance_status = 'Y' AND smb.deposit_status = 'Y' AND smb.pay_session = '{$pay_session}' AND sm.seq = '{$table_seq}'";
		}

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function bill_data_adjust($seq, $type) {
		$table_seq = explode('_', $seq);
		$table_seq = $table_seq[1];

		if(strpos($seq, 'f_') !== false) {
			$sql = "SELECT forcasting_sales, forcasting_purchase FROM sales_forcasting WHERE seq = {$table_seq}";
		} else if (strpos($seq, 'm_') !== false) {
			$sql = "SELECT forcasting_sales, forcasting_purchase FROM sales_maintain WHERE seq = {$table_seq}";
		} else if (strpos($seq, 'r_') !== false) {
			$sql = "SELECT 0 as forcasting_sales, 0 as forcasting_purchase";
		}

		$query = $this->db->query($sql);
		$result = $query->row_array();

		if ($type == '001') {
			$target = $result['forcasting_sales'];
		} else {
			$target = $result['forcasting_purchase'];
		}

		if($target == 0) {
			$sql = "SELECT 'null' as rseq";
		} else {
			if (strpos($seq, 'f_') !== false) {
				$sql = "SELECT CONCAT('f_', sf.seq) AS rseq, sfb.issuance_date, sfb.tax_approval_number, sfb.company_name, sf.project_name, sfb.total_amount, sfb.deposit_date, sfb.deposit_status, sfb.issuance_month
				FROM sales_forcasting_bill sfb
				JOIN sales_forcasting sf ON sfb.forcasting_seq = sf.seq
				WHERE sfb.type = '{$type}' AND sfb.issuance_date >= '2022-01-01' AND sfb.issuance_status = 'Y' AND sfb.deposit_status = 'Y' AND sf.seq = '{$table_seq}' ORDER BY sfb.deposit_date DESC, sfb.seq DESC limit 1";

			} else if (strpos($seq, 'm_') !== false) {
				$sql = "SELECT CONCAT('m_', sm.seq) AS rseq, smb.pay_session, smb.issuance_date, smb.tax_approval_number, smb.company_name, sm.project_name, smb.total_amount, smb.deposit_date, smb.deposit_status, smb.issuance_month
				FROM sales_maintain_bill smb
				JOIN sales_maintain sm ON smb.maintain_seq = sm.seq
				WHERE smb.type = '{$type}' AND smb.issuance_date >= '2022-01-01' AND smb.issuance_status = 'Y' AND smb.deposit_status = 'Y' AND sm.seq = '{$table_seq}' ORDER BY smb.deposit_date DESC, smb.seq DESC limit 1";
			} else if (strpos($seq, 'r_') !== false) {
				if ($type == '002') {
					$sql = "SELECT CONCAT('r_', rts.seq) AS rseq, rtsb.issuance_date, rtsb.tax_approval_number, rts.cooperative_company AS company_name, SUBSTRING_INDEX(ead.approval_doc_name, ']', -1) AS project_name,
					rtsb.total_amount, rtsb.deposit_date, rtsb.deposit_status, rtsb.issuance_month
					FROM request_tech_support_bill rtsb
					JOIN electronic_approval_doc ead ON rtsb.annual_doc_seq = ead.seq
					JOIN request_tech_support rts ON SUBSTRING_INDEX(ead.req_support_seq,'_',1) = rts.seq
					WHERE rtsb.issuance_date >= '2022-01-01' AND rtsb.issuance_status = 'Y' AND rtsb.deposit_status = 'Y' AND rts.seq = '{$table_seq}' ORDER BY rtsb.deposit_date DESC, rtsb.seq DESC limit 1";
				} else {
					$sql = "SELECT NULL AS rseq, NULL AS issuance_date, NULL AS tax_approval_number, NULL AS company_name, NULL AS project_name, NULL AS total_amount, NULL AS deposit_date, NULL AS deposit_status
					FROM request_tech_support_bill where seq = 0 LIMIT 1";
				}
			}
		}

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function check_maintain($seq) {
		$sql = "SELECT COUNT(*) AS cnt FROM sales_maintain_product WHERE integration_maintain_seq and maintain_seq = {$seq}";

		$query = $this->db->query($sql);

		return $query->result_array();
	}


}

 ?>
