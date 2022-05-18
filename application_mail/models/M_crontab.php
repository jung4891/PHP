<?php
header("Content-type: text/html; charset=utf-8");

class M_crontab extends CI_Model {

	function __construct() {

		parent::__construct();

	}

  function get_delfilelist(){

    $sql = "SELECT * FROM bigfile WHERE insert_date = date_format(DATE_ADD(DATE_ADD(NOW(), INTERVAL -2 MONTH), INTERVAL -1 DAY),'%Y-%m-%d') AND delete_date IS NULL";

    $query = $this->db->query($sql);
    $result = $query->result();
    return $result;

  }

  function complete_deletefile($seq){
    $data = array(
               'delete_date' => date("Y-m-d")
            );
    $this->db->where('seq', $seq);
    $this->db->update('bigfile', $data);
  }

  function test_trig($uid){
    $data = array(
   'mailid' => $uid
);

$this->db->insert('quota33', $data);
  }


}
?>