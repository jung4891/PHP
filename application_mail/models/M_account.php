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
		} else {
			 return $query->row_array();
		}
 }

 function aes_key($uid, $password){

	 	$sql = "SELECT COUNT(*) AS ucount FROM aes_key WHERE uid = '{$uid}'";
		$query = $this->db->query($sql);
		$num_rows = $query->row();
		if($num_rows->ucount > 0){
			$sql = "UPDATE aes_key SET pkey = '{$password}' WHERE uid = '${uid}'";
			$query = $this->db->query($sql);
		}else{
			$sql = "INSERT INTO aes_key (uid, pkey) VALUES ('{$uid}','{$password}')";
			$query = $this->db->query($sql);
		}

		if($query){
			return true;
		}
 }

 function change_password($mailbox, $id){

	$change_pass = $this->db->update('mailbox', $mailbox, array('username' => $id));

		if($change_pass){
			return true;
		}else{
			return false;
		}
	}

 function mbox_conf($uid){
	 $sql = "SELECT uid, pkey FROM aes_key WHERE uid = '{$uid}'";
	 $query = $this->db->query($sql);
	 if($query->num_rows() > 0){
		 return $query->row()->pkey;
	 }else{
		 return false;
	 }
 }


}
?>
