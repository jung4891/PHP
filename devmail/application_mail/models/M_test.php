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


}
?>
