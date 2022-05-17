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

	function get_mygroup($uid){
		$sql = "SELECT * FROM address_group WHERE user = '{$uid}'";
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
(SELECT IF(ISNULL(NAME), email, CONCAT(NAME,'<',email,'>')) AS goto FROM address_book WHERE id ='{$uid}')
UNION
(SELECT IF(ISNULL(IF(b.name = '', NULL, b.name)), a.address, concat(b.name,'<',a.address,'>')) AS goto FROM alias AS a
LEFT JOIN mailbox as b
ON a.address = b.username)";
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

	function insert_bigfile($insert_arr){
		$this->db->insert('bigfile', $insert_arr);
	}

	function sendmail_classify($to){
		$from = $_SESSION["userid"];

		if(strpos($to, ',') !== false) {
				return 'default';
		}

		preg_match_all( "/[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/i", $to, $matches );
		$match_mail = $matches[0][0];
		$domain = explode("@", $match_mail)[1];
		$sql = "SELECT mailbox FROM categori_mail
	WHERE sendtype = 1 AND userid = '{$from}'
	AND (address = '{$match_mail}' OR address = '{$domain}')
	ORDER BY usertype, seq DESC LIMIT 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row()->mailbox;
			}else{
			return 'default';
			}
		}

}



 ?>
