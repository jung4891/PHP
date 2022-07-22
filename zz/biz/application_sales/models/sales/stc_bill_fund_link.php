<?php
header("Content-type: text/html; charset=utf-8");

class STC_Bill_fund_link extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get('id', 'stc');
		$this->name = $this->phpsession->get('name', 'stc');
		$this->lv = $this->phpsession->get('lv', 'stc');
		$this->cnum = $this->phpsession->get('cnum', 'stc');
	}

  function bill_fund_link_delete($bill_seq, $target) {
    if ($target == 'forcasting') {
      $t = 'f_';
    } else if ($target == 'maintain') {
      $t = 'm_';
    } else if ($target == 'request_tech_support') {
      $t = 'r_';
    }
    $sql = "DELETE from fund_list where idx = (select fund_list_seq from bill_fund_link where bill_seq = '{$t}{$bill_seq}')";
    $this->db->query($sql);
    $sql2 = "DELETE from bill_fund_link where bill_seq = '{$t}{$bill_seq}'";
    $this->db->query($sql2);
  }

  function bill_fund_link($bill_seq, $issuance_status, $issuance_month, $target) {
    if ($target == 'forcasting') {
      $t = 'f_';
    } else if ($target == 'maintain') {
      $t = 'm_';
    } else if ($target == 'request_tech_support') {
      $t = 'r_';
    }

		$issuance_month = str_replace('-', '', $issuance_month);

    if ($issuance_status == 'Y' && $issuance_month >= 202201) {
			if ($target == 'forcasting') {
				$sql = "SELECT sfb.seq, sfb.type, sfb.company_name, sfb.total_amount, sfb.issuance_date, sf.customer_companyname, sf.project_name, sf.cooperation_companyname as fund_company
				FROM sales_forcasting_bill sfb
				JOIN sales_forcasting sf ON sfb.forcasting_seq = sf.seq
				where sfb.seq = {$bill_seq}";
			} else if ($target == 'maintain') {
				$sql = "SELECT smb.seq, smb.type, smb.company_name, smb.total_amount, smb.issuance_date, sm.customer_companyname, sm.project_name, sm.cooperation_companyname as fund_company, smb.pay_session
				FROM sales_maintain_bill smb
				JOIN sales_maintain sm ON smb.maintain_seq = sm.seq
				where smb.seq = {$bill_seq}";
			} else if ($target == 'request_tech_support') {
				$sql = "SELECT rtsb.seq, '002' AS type, rtsb.total_amount, rtsb.issuance_date, rts.cooperative_company AS company_name, rts.customer_company AS customer_companyname, '두리안정보기술' as fund_company,
				ead.approval_doc_name AS project_name
				FROM request_tech_support_bill rtsb
				JOIN electronic_approval_doc ead ON rtsb.annual_doc_seq = ead.seq
				JOIN request_tech_support rts ON SUBSTRING_INDEX(ead.req_support_seq,'_',1) = rts.seq
				WHERE rtsb.seq = {$bill_seq}";
			}
			// echo $sql;
      $result = $this->db->query($sql);
      $bill_info = $result->row_array();

			$fund_company = $bill_info['fund_company'];
			if($fund_company == '두리안정보통신기술') {
				$fund_company = 'DUICT';
			} else if ($fund_company == '더망고') {
				$fund_company = 'MG';
			} else {
				$fund_company = 'DUIT';
			}

      $bill_seq = $bill_info['seq'];
      $dateOfIssue = $bill_info['issuance_date'];
      if ($bill_info['type'] == '001') {
        $type = '매출채권';
      } else {
        $type = '매입채무';
      }
      $customer = $bill_info['company_name'];
      $endUser = $bill_info['customer_companyname'];
			if ($target != 'request_tech_support') {
				$breakdown = addslashes($bill_info['project_name']);
			} else {
				$breakdown = explode(']', $bill_info['project_name']);
				$breakdown = $breakdown[1];
			}

			if($target == 'maintain') {
				$breakdown .= ' ('.$bill_info['pay_session'].'회차)';
			}

      $requisition = $bill_info['total_amount'];

			$check_sql = "SELECT count(*) as cnt FROM fund_list WHERE idx in (SELECT fund_list_seq from bill_fund_link WHERE bill_seq = '{$t}{$bill_seq}')";
			$check_query = $this->db->query($check_sql);
			$check_cnt = $check_query->row_array();
			if($check_cnt['cnt'] == 0) {
				$sql2 = "INSERT INTO fund_list (dateOfIssue, fixedDate, dueDate, type, customer, endUser, breakdown, requisition, company, id) VALUES ('{$dateOfIssue}', DATE_ADD('{$dateOfIssue}', INTERVAL 30 DAY), DATE_ADD('{$dateOfIssue}', INTERVAL 60 DAY), '{$type}', '{$customer}', '{$endUser}', '{$breakdown}', '{$requisition}', '{$fund_company}', '세금계산서')";
				$result2 = $this->db->query($sql2);
				$fund_list_seq = $this->db->insert_id();

				$sql3 = "INSERT INTO bill_fund_link (fund_list_seq, bill_seq) values ('{$fund_list_seq}', '{$t}{$bill_seq}')";
				$result3 = $this->db->query($sql3);
			}
    } else if ($issuance_status == 'C') {
      $sql = "DELETE from fund_list where idx = (select fund_list_seq from bill_fund_link where bill_seq = '{$t}{$bill_seq}')";
      $this->db->query($sql);
      $sql2 = "DELETE from bill_fund_link where bill_seq = '{$t}{$bill_seq}'";
      $this->db->query($sql2);
    }
  }

  function update_bankType($fund_data, $fund_idx) {
    // 자금보고와 연결된 계산서 seq
    $sql = "SELECT bill_seq FROM bill_fund_link where fund_list_seq = {$fund_idx}";
    $result = $this->db->query($sql);
    $bill_seq = $result->row_array();

    if (!empty($bill_seq)) {
      $bill_seq = $bill_seq['bill_seq'];

      if (strpos($bill_seq, 'f_') !== false) {
        $bill_table = 'sales_forcasting_bill';
      } else if (strpos($bill_seq, 'm_') !== false) {
        $bill_table = 'sales_maintain_bill';
      } else if (strpos($bill_seq, 'r_') !== false) {
        $bill_table = 'request_tech_support_bill';
      }

      $bill_seq2 = explode('_', $bill_seq);
      $bill_seq2 = $bill_seq2[1];

      // 해당 계산서의 발행 금액
      $sql2 = "SELECT * FROM {$bill_table} WHERE seq = {$bill_seq2}";
      $result2 = $this->db->query($sql2);
      $bill_info = $result2->row_array();
      if (!empty($bill_info)) {
        $bill_total_amount = $bill_info['total_amount'];
      } else {
        $bill_total_amount = 0;
      }

			if ($bill_table == 'request_tech_support_bill') {
				$bill_info['type'] = '002';
			}

			if ($bill_info['type'] == '001') {
				// 매출채권
				$calc = '(SUM(IFNULL(deposit, 0)) - SUM(IFNULL(withdraw, 0)))';
			} else {
				$calc = '(SUM(IFNULL(withdraw, 0)) - SUM(IFNULL(deposit, 0)))';
			}

      // 해당 계산서와 연결된 자금보고(은행구분 작성된)의 총합 (입금 + 출금)
      $sql3 = "SELECT {$calc} AS sum, MAX(dueDate) AS dueDate FROM fund_list WHERE idx IN (SELECT fund_list_seq FROM bill_fund_link WHERE bill_seq = '{$bill_seq}') AND bankType IS NOT NULL";

      $result3 = $this->db->query($sql3);
      $fund_info = $result3->row_array();

      if(isset($fund_info['sum'])) {
        $fund_total = $fund_info['sum'];
      } else {
        $fund_total = 0;
      }

      if(isset($fund_info['dueDate'])) {
        $dueDate = $fund_info['dueDate'];
      } else {
        $dueDate = NULL;
      }

      if ($fund_total == 0) {
        $deposit_status = 'N';
      } else if ($fund_total > $bill_total_amount) {
        $deposit_status = 'O';
      } else if ($fund_total < $bill_total_amount) {
        $deposit_status = 'L';
      } else if ($fund_total == $bill_total_amount) {
        $deposit_status = 'Y';
      }

      $update_data = array(
        'deposit_date'   => $dueDate,
        'deposit_status' => $deposit_status
      );

      // var_dump($update_data);

      // 계산서 입금 상태 업데이트
      $where = "seq = '{$bill_seq2}'";
      $this->db->update($bill_table, $update_data, $where);
    }
  }

	function insert_bill_fund_link($upper_seq, $fund_seq) {
		$sql = "SELECT * from bill_fund_link where fund_list_seq = {$upper_seq}";
		$result = $this->db->query($sql);
		$bill_seq = $result->row_array();
		$bill_seq = $bill_seq['bill_seq'];

		$data = array(
			'fund_list_seq' => $fund_seq,
			'bill_seq'      => $bill_seq
		);

		$this->db->insert('bill_fund_link', $data);
	}


}
