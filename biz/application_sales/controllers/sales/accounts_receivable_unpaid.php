<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class accounts_receivable_unpaid extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->lv = $this->phpsession->get( 'lv', 'stc' );
		$this->cnum = $this->phpsession->get( 'cnum', 'stc' );
		$this->seq = $this->phpsession->get( 'seq', 'stc' );
		$this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );

		if($this->cooperation_yn == 'Y') {
			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
		}
		$this->load->Model('sales/STC_accounts_receivable_unpaid');
	}


function accounts_receivable_unpaid_view() {
	if( $this->id === null ) {
		redirect( 'account' );
	}

	if(!isset($_GET['sort_condition']) || $_GET['sort_condition'] == '') {
		$sort_condition = 'endUser';
	} else {
		$sort_condition = $_GET['sort_condition'];
	}

	// forcasting : 상품, maintain : 용역, procurement : 조달
	$dfs = $this->STC_accounts_receivable_unpaid->distinct_forcasting_seq();
	$dms = $this->STC_accounts_receivable_unpaid->distinct_maintain_seq();
	$dps = $this->STC_accounts_receivable_unpaid->distinct_procurement_seq();
	$forcasting_sales_data      = array();
	$forcasting_purchase_data   = array();
	$maintain_sales_data       = array();
	$maintain_purchase_data    = array();
	$procurement_sales_data    = array();
	$procurement_purchase_data = array();

	$bill_data_count = array();
	// 001: 매출(sales), 002 :매입(purchase)
	if(!empty($dfs)) {
		foreach($dfs as $key => $f) {
			$fs = $this->STC_accounts_receivable_unpaid->bill_data($f['rseq'], '001');
			$fp = $this->STC_accounts_receivable_unpaid->bill_data($f['rseq'], '002');
			$bill_data_count[$f['rseq']] = max(count($fs),count($fp));
			$forcasting_sales_data[$f['rseq']]    = $fs;
			$forcasting_purchase_data[$f['rseq']] = $fp;
			if(isset($fs[0]['deposit_date']) && $fs[0]['deposit_date'] != '') {
				$dfs[$key]['deposit_date'] = $fs[0]['deposit_date'];
			}
		}
	}

	if(!empty($dms)) {
		foreach($dms as $key => $m) {
			if(strpos($m['rseq'], 'm_') !== false) {
				$ms = array();
				$mp = $this->STC_accounts_receivable_unpaid->bill_data($m['rseq'], '002');
				foreach($mp as $v) {
					if(isset($v['pay_session']) && $v['deposit_status'] != 'Y') {
						$tmp = $this->STC_accounts_receivable_unpaid->pay_session_data($m['rseq'], $v['pay_session']);
						foreach($tmp as $t) {
							array_push($ms, $t);
						}
					}
				}
				$tmp2 = $this->STC_accounts_receivable_unpaid->bill_data($m['rseq'], '001');
				foreach($tmp2 as $t2) {
					array_push($ms, $t2);
				}
				$ms = array_unique($ms, SORT_REGULAR);
			} else {
				$ms = $this->STC_accounts_receivable_unpaid->bill_data($m['rseq'], '001');
				$mp = $this->STC_accounts_receivable_unpaid->bill_data($m['rseq'], '002');
			}


			$bill_data_count[$m['rseq']] = max(count($ms),count($mp));
			if(isset($tmp2) && count($tmp2) > 0) {
				$bill_data_count[$m['rseq']] += count($tmp2);
			}
			$maintain_sales_data[$m['rseq']]    = $ms;
			$maintain_purchase_data[$m['rseq']] = $mp;
			if(isset($ms[0]['deposit_date']) && $ms[0]['deposit_date'] != '') {
				$dms[$key]['deposit_date'] = $ms[0]['deposit_date'];
			}
		}
	}

	if(!empty($dps)) {
		foreach($dps as $key => $p) {
			$ps = $this->STC_accounts_receivable_unpaid->bill_data($p['rseq'], '001');
			$pp = $this->STC_accounts_receivable_unpaid->bill_data($p['rseq'], '002');
			$bill_data_count[$p['rseq']] = max(count($ps),count($pp));
			$procurement_sales_data[$p['rseq']]    = $ps;
			$procurement_purchase_data[$p['rseq']] = $pp;
			if(isset($ps[0]['deposit_date']) && $ps[0]['deposit_date'] != '') {
				$dps[$key]['deposit_date'] = $ps[0]['deposit_date'];
			}
		}
	}

	if($sort_condition == 'deposit_date') {
		$sort = array();
		$sort2 = array();
		$sort3 = array();

		foreach($dfs as $k => $v) {
			$sort['customer_companyname'][$k] = $v['customer_companyname'];
			if($v['deposit_date'] != '') {
				$sort['deposit_date'][$k] = $v['deposit_date'];
			} else {
				$sort['deposit_date'][$k] = '9999-99-99';
			}
		}
		foreach($dms as $k => $v) {
			$sort2['customer_companyname'][$k] = $v['customer_companyname'];
			if($v['deposit_date'] != '') {
				$sort2['deposit_date'][$k] = $v['deposit_date'];
			} else {
				$sort2['deposit_date'][$k] = '9999-99-99';
			}
		}
		foreach($dps as $k => $v) {
			$sort3['customer_companyname'][$k] = $v['customer_companyname'];
			if($v['deposit_date'] != '') {
				$sort3['deposit_date'][$k] = $v['deposit_date'];
			} else {
				$sort3['deposit_date'][$k] = '9999-99-99';
			}
		}

		if(!empty($dfs)) {
			array_multisort($sort['deposit_date'], SORT_ASC, $sort['customer_companyname'], SORT_ASC, $dfs);
		}
		if(!empty($dms)) {
			array_multisort($sort2['deposit_date'], SORT_ASC, $sort2['customer_companyname'], SORT_ASC, $dms);
		}
		if(!empty($dps)) {
			array_multisort($sort3['deposit_date'], SORT_ASC, $sort3['customer_companyname'], SORT_ASC, $dps);
		}
	}

	$data = array(
		'sort_condition'            => $sort_condition,
		'distinct_forcasting_seq'   => $dfs,
		'distinct_maintain_seq'     => $dms,
		'distinct_procurement_seq'  => $dps,
		'bill_data_count'           => $bill_data_count,
		'forcasting_sales_data'     => $forcasting_sales_data,
		'forcasting_purchase_data'  => $forcasting_purchase_data,
		'maintain_sales_data'       => $maintain_sales_data,
		'maintain_purchase_data'    => $maintain_purchase_data,
		'procurement_sales_data'    => $procurement_sales_data,
		'procurement_purchase_data' => $procurement_purchase_data,
	);

	$this->load->view('sales/accounts_receivable_unpaid_view', $data);
}


// 유지보수인지 통합유지보수인지
	function check_maintain() {
		$seq = $this->input->post('seq');

		$data = $this->STC_accounts_receivable_unpaid->check_maintain($seq);

		echo json_encode($data);
	}


}

?>
