<?php
header("Content-type: text/html; charset=utf-8");

class M_test extends CI_Model {

	function __construct() {

		parent::__construct();

	}



  function test(){
    $sql = "select * from user";
    $query = $this->db->query($sql);
    $result = $query->result_array();
    return $result;
  }


	function test2(){
		$sql = "select * from user_group";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}

	function insert_car($car){
		return $this->db->insert('admin_car', $car);
	}

  function get_biz_mom() {
		$sql = "SELECT B.seq, B.title, U.user_name, B.user_group, B.participant, B.insert_day
						FROM biz_mom AS B
						  JOIN `user` AS U
						  ON B.writer_id = U.user_id
						ORDER BY DAY DESC";
		$res = $this->db->query($sql)->result();
		return $res;
	}

	function get_biz_mom_participant() {
		$sql = "SELECT participant
						FROM biz_mom
						ORDER BY DAY DESC";
		$res = $this->db->query($sql)->result();
		return $res;
	}

	function get_biz_mom_participant_name($person_id) {
		$sql = "SELECT user_name
						FROM user
						WHERE user_id = '".$person_id."'";
		$res = $this->db->query($sql)->row();
		return $res;
	}


}
?>
