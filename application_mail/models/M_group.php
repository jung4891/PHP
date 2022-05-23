<?php
header("Content-type: text/html; charset=utf-8");
class M_group extends CI_Model {

	function __construct() {

		parent::__construct();

	}

	function add_group_act($data){
		$result = $this->db->insert('address_group', $data); // 3. insert할 데이터 true false
		return $result;
	}

	function group_list($userid){
		$sql = "SELECT * FROM address_group WHERE user = '{$userid}'";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function group_del($seq){
		$this->db->where('seq', $seq);
		$del = $this->db->delete('address_group');
		if($del){
			$data = array(
               'group_seq' => null
            );

			$this->db->where('group_seq', $seq);
			$result = $this->db->update('address_book', $data);
			return $result;
		}else{
			return 'false';
		}
	}

	function rename_group($seq, $name){
		$data = array(
						 'group_name' => $name
					);

		$this->db->where('seq', $seq);
		$result = $this->db->update('address_group', $data);
		return $result;
	}

		// '주소록 추가' 버튼에서 주소록 정보 insert
	function address_insert_action($data){
		// var_dump($data2);
		$result = $this->db->insert('address_book', $data); // 3. insert할 데이터 true false
		return $result;

	}


	function address_book_count($address_data="", $group_seq = 'all'){
		if($address_data == ""){
			$where = "";
		} else{
			$where = " WHERE id ='{$address_data}'";
		}

		if($group_seq != 'all'){
			$where .= " AND group_seq = '{$group_seq}'";
		}
		$sql = "SELECT COUNT(*) as totalCount FROM address_book{$where}";
		$query = $this->db->query($sql);
		$result = $query->row();
		return $result;
	}

	// 주소록 화면
	function address_book_view($address_data="", $group_seq = 'all', $start_limit = 0, $offset = 0){
		if($address_data == ""){
			$where = "";
		} else{
			$where = " where id='{$address_data}'";
		}

		if($group_seq != 'all'){
			$where .= " AND group_seq = '{$group_seq}'";
		}
		$sql = "select * from address_book{$where} ORDER BY insert_date DESC";
		if  ( $offset <> 0 ) {
			$sql = $sql." LIMIT {$start_limit}, {$offset}";
		}


		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function address_mobile_view($address_data="", $group_seq = 'all'){
		if($address_data == ""){
			$where = "";
		} else{
			$where = " where id='{$address_data}'";
		}

		if($group_seq != 'all'){
			$where .= " AND group_seq = '{$group_seq}'";
		}
		$sql = "select * from address_book{$where} ORDER BY insert_date DESC";
		// if  ( $offset <> 0 ) {
		// 	$sql = $sql." LIMIT {$start_limit}, {$offset}";
		// }


		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}



	// 주소록 수정
	function get_detail_address($seq=""){
		if($seq == ""){
			$where = "";
		} else{
			$where = " WHERE a.seq ='{$seq}'";
		}
		$sql = "SELECT a.*, b.group_name from address_book a
LEFT JOIN address_group b
ON a.group_seq = b.seq{$where}";

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


		function address_modify_action($update_data, $seq){
			$address_update = $this->db->update('address_book', $update_data, array('seq' => $seq));
			if($address_update){
				return true;
			}else{
				return false;
			}
		}

}








 ?>
