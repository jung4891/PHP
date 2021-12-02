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


}



 ?>
