<?php
header("Content-type: text/html; charset=utf-8");
class M_categori extends CI_Model {

	function __construct() {

		parent::__construct();

	}

  function add_category_act($data){
    $result = $this->db->insert('categori_mail', $data); // 3. insert할 데이터 true false
    return $result;
  }


	function category_list_count($userid=""){
		$sql = "SELECT COUNT(*) as totalCount FROM categori_mail WHERE userid = '{$userid}'";
		$query = $this->db->query($sql);
		$result = $query->row();
		return $result;
	}

	// 주소록 화면
	function category_list($userid="", $start_limit = 0, $offset = 0){

		$sql = "SELECT * FROM categori_mail WHERE userid = '{$userid}' ORDER BY seq DESC";
		if  ( $offset <> 0 ) {
			$sql = $sql." LIMIT {$start_limit}, {$offset}";
		}


		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function category_delete($data){

			$this->db->where('seq', $data);
			$result=$this->db->delete('categori_mail');

			return $result;
	}

	function get_detail_category($seq){
		$sql = "SELECT * FROM categori_mail WHERE seq = '{$seq}'";
		$query = $this->db->query($sql);
		$result = $query->row();
		return $result;
	}

	function modify_category_act($update_data, $seq){
		$address_update = $this->db->update('categori_mail', $update_data, array('seq' => $seq));
		if($address_update){
			return true;
		}else{
			return false;
		}
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
