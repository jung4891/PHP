<?php
header("Content-type: text/html; charset=utf-8");
class M_write extends CI_Model {

	function __construct() {

		parent::__construct();

	}

  function get_signlist($uid){
    $sql = "SELECT * FROM signature WHERE usermail = '{$uid}'";
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
      return $query->result();
    }else{
      return false;
    }
  }

	function get_recentmail($uid){
		$sql = "(SELECT goto FROM recent_address WHERE uid = '{$uid}' ORDER BY seq DESC LIMIT 10)
UNION
(SELECT IF(ISNULL(NAME), email, CONCAT(NAME,'<',email,'>')) AS goto FROM address_book WHERE id ='{$uid}')";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	function insert_recentmail($recentmail){
		$this->db->insert_batch('recent_address', $recentmail);
	}

}



 ?>