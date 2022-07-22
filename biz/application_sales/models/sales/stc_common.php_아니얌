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
	function get_product($product_company='',$product_type='') {
		if($product_company == '' && $product_type == ''){
			$sql = "select seq, product_name, product_item, product_company from product order by product_company desc";
		}else if($product_company == ""){
			$sql = "select seq, product_name, product_item, product_company from product where product_type = '{$product_type}' order by product_company desc";
		
		}else if($product_type == ""){
			$sql = "select seq, product_name, product_item, product_company from product where product_company = '{$product_company}' order by product_company desc";
		}else{
			$sql = "select seq, product_name, product_item, product_company from product where product_type = '{$product_type}' and product_company = '{$product_company}' order by product_company desc";
		}
		$query = $this->db->query($sql);		
		return $query->result_array();
	}
}
?>
