<?php
class M_group extends CI_Model {

	function __construct() {

		parent::__construct();

	}

  function group($data){

  }

	function address_insert_action($data){
		// var_dump($data2);
		$result = $this->db->insert('address_book', $data); // 3. insert할 데이터 true false
		return $result;
	}


	function address_book_view($address_data=""){
		if($address_data == ""){
			$where = "";
		} else{
			$where = " WHERE id ='{$address_data}'";
		}
		$sql = "select * from address_book{$where}";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
}

	function detail_address_update($seq=""){
		if($seq == ""){
			$where = "";
		} else{
			$where = " WHERE seq ='{$seq}'";
		}
		$sql = "select * from address_book{$where}";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}


	function detail_address_delete(){

	}
 ?>
