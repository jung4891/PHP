<?php
header("Content-type: text/html; charset=utf-8");

class M_account extends CI_Model {

	function __construct() {

		parent::__construct();

	}



  function admin_check($uid){
    $sql = "SELECT password FROM admin WHERE username = '{$uid}' AND active = 1";
    $query = $this->db->query($sql);
    if ($query->num_rows() <= 0) {
        return false;
    } else {
        return $query->row_array();
    }

  }

  function domain_check($uid){
    $sql = "SELECT username, domain FROM domain_admins WHERE username = '{$uid}' AND active = 1";
    $query = $this->db->query($sql);
    if ($query->num_rows() <= 0) {
        return false;
    } else {
        return $query->row_array();
    }

  }

	function user_check($uid){

		$sql = "SELECT username, password, name FROM mailbox WHERE username = '{$uid}' AND active = 1";
		// echo $sql;
		// exit;
		$query = $this->db->query($sql);
		if($query->num_rows()<=0){
			 return false;
		} else{
			 return $query->row_array();
		}
 }


}
?>
