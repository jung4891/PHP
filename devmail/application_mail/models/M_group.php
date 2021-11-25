<?php
header("Content-type: text/html; charset=utf-8");
class M_group extends CI_Model {

	function __construct() {

		parent::__construct();

	}

		// '주소록 추가' 버튼에서 주소록 정보 insert
	function address_insert_action($data){
		// var_dump($data2);
		$result = $this->db->insert('address_book', $data); // 3. insert할 데이터 true false
		return $result;
	}


	function address_book_count($address_data=""){
		if($address_data == ""){
			$where = "";
		} else{
			$where = " WHERE id ='{$address_data}'";
		}
		$sql = "SELECT COUNT(*) as totalCount FROM address_book{$where}";
		$query = $this->db->query($sql);
		$result = $query->row();
		return $result;
	}

	// 주소록 화면
	function address_book_view($address_data="",  $start_limit = 0, $offset = 0){
		if($address_data == ""){
			$where = "";
		} else{
			$where = " where id='{$address_data}' ORDER BY insert_date DESC";
		}
		$sql = "select * from address_book{$where}";
		if  ( $offset <> 0 ) {
			$sql = $sql." LIMIT {$start_limit}, {$offset}";
		}

		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}



	// 주소록 수정
	function get_detail_address($seq=""){
		if($seq == ""){
			$where = "";
		} else{
			$where = " WHERE seq ='{$seq}'";
		}
		$sql = "select * from address_book{$where}";
		$query = $this->db->query($sql);

		if($query->num_rows() > 0){
			$result = $query->row();
			return $result;
		}else{
			return false;
		}
	}


	// 주소록 삭제
		function address_delete($data1){
			for ($i=0; $i < count($data1); $i++) {
				$this->db->where('seq', $data1[$i]);
				$result=$this->db->delete('address_book');
				if(!$result){
					return false;
					break;
				}
			}
			return true;
		}

}








 ?>
