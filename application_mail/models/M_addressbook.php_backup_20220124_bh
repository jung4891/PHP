<?php
header("Content-type: text/html; charset=utf-8");

class M_addressbook extends CI_Model {

	function __construct() {

		parent::__construct();

	}



  function test(){


		// return $this->db->insert('usertbl', $data);
    $sql = "select * from user";
    $query = $this->db->query($sql);
    $result = $query->result_array();
	// $this->db->insert('usertbl', $data);
    return $result;
}

	function test2(){
		$sql = "select * from user_group";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;

	// return $this->db->insert('buytbl',$data);
	}

	function group_button($keyword){
		$id = $_SESSION["userid"];
		if($keyword == 'all'){
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


	// 2. insert할 데이터를 함수안 ()에 넣어야 한다 ($data와 변수 명 달라도 상관 없음 model에서 받는 변수이기 때문)
	function insert_test($data2){
		var_dump($data2); // 찍어보기

		$result = $this->db->insert('usertbl', $data2); // 3. insert할 데이터 true false

		return $result; // 4. 결과값 리턴 (함수는 결과값을 리턴한다)
	}

	function update_test($data3, $mode = 0, $seq = 0){
		var_dump($data3);

	    if( $mode == 0 ) {
	      return $this->db->insert('usertbl', $data3 );
	    }
	    else {
	      return $this->db->update('usertbl', $data3, array('userID' => $seq));
	    }

	}

	function delete_test($data){
		var_dump($data);

    $result = $this->db->delete('usertbl', array('userID' => $data));


	 // $sql = "delete from meeting_room where seq = ?";
	// $query = $this->db->query( $sql, $seq );

			return	$result;
	}

	function biz_mom($keyword=""){ // 값을 받는 것, 파라미터
		if($keyword == ""){
			$where = "";
		}	else{
			$where = " WHERE place ='{$keyword}'";
		}
		$sql = "select * from biz_mom{$where} order by day desc";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}




}
?>
