<?php
header("Content-type: text/html; charset=utf-8");

class STC_User extends CI_Model {

	function __construct() {

		parent::__construct();
		$this->user_id = $this->phpsession->get( 'id', 'rms' );
	}

	//	로그인시 해당 아이디로 내용 가져오기
	function select_user( $uid, $upass ) {
		$query = $this->db->query("select user_id, user_name, user_level from user where user_id = '".$uid."' and user_password = '".$upass."' and user_part in ('002','004') and confirm_flag = 'Y'");
		
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	//	로그인후 해당 아이디로 내용 가져오기
	function selected_user( $uid ) {
		$query = $this->db->query("select user_part, user_id, user_name, user_password, company_name, company_num, confirm_flag, user_tel, user_duty, user_level, user_email, update_date from user where user_id = '".$uid."'");
		
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}
	
	//	아이디 중복체크
	function idcheck( $uid ) {
		$query = $this->db->query("select user_id from user where user_id = '".$uid."' and user_part = '002'");
		
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return true;
		}
	}

	//	해당 사업자번호 조회2(사용자테이블)
	function selected_cnum2( $cnum, $user_email ) {
		$query = $this->db->query("select seq, user_id, user_password, user_email from user where company_num = '".$cnum."' and user_email = '".$user_email."' and user_part = '002'");
		
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

	// 사용자 추가및 수정
	function insert_user( $data, $mode = 0 , $id = 0) {
//		$data['RegUserId'] = $this->phpsession->get( 'idx', 'wtf' );

		if( $mode == 0 ) {
			return $this->db->insert('user', $data );
		}
		else {
			return $this->db->update('user', $data, array('user_id' => $id));
		}
	}
	
	// 사용자 삭제
	function delete_user( $user_id ) {
		$sql = "delete from user where user_id = ?";		
		$query = $this->db->query( $sql, $user_id );

		return	$query;
	}

	// 가입하고자 하는 ID가 존재하는지 검사
	function check_user_id_exist( $user_id ) {
		$sql = "select user_id from user where user_id = ?";
		$query = $this->db->query( $sql, $user_id );

		if  ( $query->num_rows() == 0 ){		//	해당 ID가 존재하지 않음
			return	0;
		}

		return	1;
	}
	
	// 회원 리스트
	function user_list( $searchkeyword, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";
		if  ( $searchkeyword != "" )
			$searchstring = " where ( restarea_name like ? )";
		else
			$searchstring = "";

		$sql = "select user_seq, user_id, user_name, user_passwd, user_tel, user_level, restarea_name, user_email from user".$searchstring." order by user_seq desc";
		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );	
		else 
			$query = $this->db->query( $sql, array( $start_limit, $offset ) );
		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}
	
	 // 전체 게시물에서 몇번째부터 몇개(페이지당 표시 개수)가져오기
    function GetLimit($tlimit,$toffset) {
        $query = $this->db->get('user',$tlimit,$toffset);
        if ( $query->num_rows() > 0 )
            return $query->result();
        else
            return FALSE;
    }


	//회원 리스트개수
	function user_list_count($searchkeyword) {
		$keyword = "%".$searchkeyword."%";
		if  ( $searchkeyword != "" )
			$searchstring = " where ( restarea_name like ? )";
		else
			$searchstring = "";

		$sql = "select count(user_seq) as ucount from user".$searchstring." order by user_seq desc";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );	
		else 
			$query = $this->db->query( $sql );
		return $query->row();
	}
}
?>