<?php
header("Content-type: text/html; charset=utf-8");

class STC_Common extends CI_Model {

	function __construct() {

		parent::__construct();

	}

  //	로그인시 해당 아이디로 내용 가져오기
  function select_user( $userid, $userpw ) {
    $query = $this->db->query("SELECT * FROM user where user_id='$userid'&& user_password='$userpw'");

    if ($query->num_rows() <= 0) {
      return false;
    } else {
      return $query->row_array();
    }
  }

	// 게시글 읽음 여부 확인
	function board_read_count($target, $seq, $user_seq) {

	}

	// 게시글 읽음 처리
	function board_read_insert($data) {
		$sql = "SELECT count(*) as cnt FROM board_read WHERE target = '{$data['target']}' AND table_seq = {$data['table_seq']} AND user_seq = {$data['user_seq']}";

		$query = $this->db->query($sql);

		$count = $query->row_array();

		if($count['cnt'] == 0) {
			$this->db->insert('board_read', $data);
		}
	}

	//	아이디 중복체크
	function idcheck( $uid ) {
		$query = $this->db->query("select user_id from user where user_id = '".$uid."'");

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return true;
		}
	}

	// 회원가입 추가
	function sign_up( $data, $mode = 0 ) {
		if( $mode == 0 ) {
				return $this->db->insert('user', $data );
			}
			else{
			  // return $this->db->update('user', $data, array('seq' => $seq));
				$query = $this->db->query("select user_id from user where user_id = '".$user_id."' ");
				// echo $user_id;
				// exit;

				if ($query->num_rows() > 0) { // 아이디 중복
		      return "no";
		    } else { // 아이디 없음
		      return "ok";
		    }
			}
	}

	function find_id($name, $email) {
		$sql = "SELECT user_id FROM user WHERE user_name = '{$name}' AND user_email = '{$email}'";

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}

	function find_user( $user_id, $user_email ) {
		$query = $this->db->query("select seq, user_id, user_password, user_email from user where user_id = '".$user_id."' and user_email = '".$user_email."'");
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	// 임시 비밀번호 저장
	function save_temp_password ( $id, $temppassword ) {
		$curdate = date("Y-m-d H:i:s");
		$sql = "update user set user_password = ?, update_date = ? where user_id = ?";
		$query = $this->db->query( $sql, array( sha1( $temppassword ), $curdate, $id ) );

		return	$query;
	}

	function personal_modify($data, $seq) {
		$this->db->where('seq', $seq);
		return $this->db->update('user', $data);
	}
}
?>
