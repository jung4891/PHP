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


function purchase_maintain_seq(){

	$sql = "SELECT smb.maintain_seq, sm.customer_companyname FROM sales_maintain_bill smb JOIN sales_maintain sm ON smb.maintain_seq = sm.seq WHERE issuance_date LIKE '2021-04%' ORDER BY issuance_date";

	$query = $this->db->query($sql);

	return $query->result_array();
}

function purchase_maintain_income(){
	$sql = "SELECT * FROM sales_maintain_bill smb JOIN sales_maintain sm ON smb.maintain_seq = sm.seq WHERE issuance_date LIKE '2021-04%' and smb.type = '002' ORDER BY issuance_date";

	$query = $this->db->query($sql);

	return $query->result_array();
}

function purchase_maintain_outcome(){
	$sql = "SELECT * FROM sales_maintain_bill smb JOIN sales_maintain sm ON smb.maintain_seq = sm.seq WHERE issuance_date LIKE '2021-04%' and smb.type = '001' ORDER BY issuance_date";

	$query = $this->db->query($sql);

	return $query->result_array();
}

}

 ?>
