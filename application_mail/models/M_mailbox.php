<?php
header("Content-type: text/html; charset=utf-8");

class M_mailbox extends CI_Model {

	function __construct() {

		parent::__construct();

	}



  function domain_list(){
    $sql = "SELECT distinct domain FROM mailbox
ORDER BY FIELD(domain, 'durianit.com', 'durianit.co.kr') DESC";
    $query = $this->db->query($sql);
    if ($query->num_rows() <= 0) {
        return false;
    } else {
        return $query->result();
    }

  }


}
?>
