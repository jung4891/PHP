<?php
header("Content-type: text/html; charset=utf-8");

class M_addressbook extends CI_Model {

	function __construct() {

		parent::__construct();

	}





	function group_button($keyword){
		$id = $_SESSION["userid"];
		if($keyword == 'address'){
			// $where = " WHERE parentGroupName != '기술본부' and parentGroupName != '영업본부'";
			$sql = "SELECT name as user_name, email as user_email, department as parentGroupName FROM address_book WHERE id = '{$id}'";
			$query = $this->db->query($sql);
			$result = $query->result_array();
			return $result;
		}	else if($keyword == 'tech'){
			// $where = " WHERE parentGroupName = '기술본부'";
			$sql = "SELECT alias.address,
	    alias.goto as user_email,
	    alias.domain,
	    alias.modified,
	    alias.active,
	    mailbox.name as user_name
	    FROM alias LEFT JOIN mailbox ON alias.address=mailbox.username
	    WHERE mailbox.maildir IS NOT NULL
	    AND alias.active = 1";
			$query = $this->db->query($sql);
			$result = $query->result_array();
			return $result;
		} else{
				$where = " WHERE parentGroupName = '영업본부'";
		}
		// $sql = "SELECT a.seq, a.user_name, a.user_email, a.user_duty, b.parentGroupName FROM user a JOIN user_group b ON a.user_group = b.groupName {$where}";
		// $query = $this->db->query($sql);
		// $result = $query->result_array();
		// return $result;
	}


	function get_address($id, $keyword = ""){
		if($keyword == ""){
			$search = "";
		} else {
			$search = " AND (name LIKE '%{$keyword}%' OR email LIKE '%{$keyword}%')";
		}
		$sql = "SELECT seq, name, email FROM address_book a WHERE id = '{$id}'{$search}  ORDER BY seq DESC";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}

	function get_mailbox($id, $keyword = ""){
		if($keyword == ""){
			$search = "";
		} else {
			$search = " AND (mailbox.name LIKE '%{$keyword}%' OR alias.goto LIKE '%{$keyword}%')";
		}
		$sql = "SELECT
    alias.goto as email,
    mailbox.name as name
    FROM alias LEFT JOIN mailbox ON alias.address=mailbox.username
    WHERE mailbox.maildir IS NOT NULL{$search} ORDER BY goto";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}

	function check_lmtp($mail){
		$sql = "SELECT count(*) as cnt FROM alias WHERE address = '{$mail}'";
		$query = $this->db->query($sql);
		$result = $query->row();
		return $result;
	}



}
?>
