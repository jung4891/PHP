<?php
header("Content-type: text/html; charset=utf-8");
class M_option extends CI_Model {

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

  function get_signcount($uid){
    $sql = "SELECT count(*) as s_count FROM signature WHERE usermail = '{$uid}'";
    $query = $this->db->query($sql);
    $result = $query->row();
    return $result;

  }

	function get_signcontent($seq, $uid){
		$sql = "SELECT sign_content FROM signature WHERE usermail = '{$uid}' AND seq = '{$seq}'";
		$query = $this->db->query($sql);
		$result = $query->row();
		return $result;
	}

	function sign_input_action($data){

		$result = $this->db->insert('signature', $data);
		return $result;
	}

	function sign_save($data, $seq){
		$this->db->where('seq', $seq);
		$result = $this->db->update('signature', $data);
		return $result;
	}

	function sign_del($seq){
		$this->db->where('seq', $seq);
		$result = $this->db->delete('signature');
		return $result;
	}



}



 ?>
