<?php
header("Content-type: text/html; charset=utf-8");

class STC_Common extends CI_Model {

	function __construct() {

		parent::__construct();
//		$this->user_id = $this->phpsession->get( 'id', 'stc' );
	}

	//카테고리 알아오기
	function get_category() {
		$sql = "select code, code_name from category";
		$query = $this->db->query($sql);		
		return $query->result_array();
	}

	//제조사, 품목, 제품명 알아오기
	function get_product() {
		$sql = "select seq, product_name, product_item, product_company from product order by product_company desc";
		$query = $this->db->query($sql);		
		return $query->result_array();
	}
}
?>