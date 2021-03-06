<?php
header("Content-type: text/html; charset=utf-8");

class STC_request_tech_support extends CI_Model {

	function __construct() {

		parent::__construct();
//		$this->user_id = $this->phpsession->get( 'id', 'stc' );
		$this->at = $this->phpsession->get( 'at', 'stc' );
		$this->name= $this->phpsession->get( 'name', 'stc' );
		$this->pGroupName= $this->phpsession->get( 'pGroupName', 'stc' );
		$this->id= $this->phpsession->get( 'id', 'stc' );
		$this->cooperative_id= $this->phpsession->get( 'cooperative_id', 'stc' );
    }
    
    //협력사 가져오기
    function cooperative_company() {
		$sql = "select * from sales_customer_basic where company_part = '004'";

	//	$sql = "select distinct (customer_companyname) as customer from sales_forcasting order by binary(customer)";
		$query = $this->db->query($sql);
		return $query->result_array();
    }
    
    //협력사 담당자랑 엔지니어 가져오기
    function cooperative_company_staff($seq) {
		$sql = "select * from sales_customer_staff where customer_seq ='{$seq}'";
		$query = $this->db->query($sql);
		return $query->result_array();
    }

    //협력사 엔지니어 정보 가져오기
    function cooperative_company_engineer($seq) {
        $sql = "select * from sales_customer_staff where seq ='{$seq}'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //기술지원요청 insert/update
    function request_tech_support_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			$result =  $this->db->insert('request_tech_support', $data );
			if($result){
				// $lastid = $this->db->query("select last_insert_id()");
				return $this->db->insert_id();
			}else{
				return $result;
			}	
		}else {
			$result = $this->db->update('request_tech_support', $data, array('seq' => $seq));
			if($result){
				return $seq;
			}else{
				return $result;
			}
		}
	}

	//기술지원요청 리스트 불러와야지
	function request_tech_support_list( $searchkeyword, $searchkeyword2, $search1, $start_limit = 0, $offset = 0){
		$keyword = "%".$searchkeyword."%";
		$keyword2 = "%".$searchkeyword2."%";
	
		if($searchkeyword != "") {
			if($search1 == "001") {
				$searchstring = " where customer_company like ? ";
			} else if($search1 == "002" ) {
				$searchstring = " where cooperative_company like ? "; 
			} else if($search1 == "003" ) {
				$searchstring = " where workplace_name like ? ";
			} else if($search1 == "004" ) {
				$searchstring = " where produce like ? and version like '$keyword2'";
			} else if($search1 == "005" ) {
				$searchstring = " where result like ? ";
			} else if($search1 == "006" ){
				$searchstring = " where final_approval like ?";	
			} else if($search1 == "007" ){
				$searchstring = " where installation_date like ?";			
			} else if($search1 == "008" ){
				$searchstring = " where tax like ?";			
			}else if($search1 == "009" ){
				$searchstring = " where serial like ?";			
			}
		} else {
			$searchstring = "";
		}

		if (isset($this->cooperative_id) && !isset($this->id)){
			$sql = "select * from request_tech_support".$searchstring." where cooperative_email like '%{$this->cooperative_id}%' or engineer_email like '%{$this->cooperative_id}%' order by seq desc";
		}else{
			$sql = "select * from request_tech_support".$searchstring." order by seq desc";
		}


		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";
	
		if  ( $searchkeyword != "" )
			if($searchkeyword2 == ""){
				$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
			}else{
				$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
			}
		else
			$query = $this->db->query( $sql, array( $start_limit, $offset ) );
	
		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );

	}

	function request_tech_support_list_count( $searchkeyword,$searchkeyword2, $search1, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";
		$keyword2 = "%".$searchkeyword2."%";
	
		if($searchkeyword != "") {
			if($search1 == "001") {
				$searchstring = " where customer_company like ? ";
			} else if($search1 == "002" ) {
				$searchstring = " where cooperative_company like ? "; 
			} else if($search1 == "003" ) {
				$searchstring = " where workplace_name like ? ";
			} else if($search1 == "004" ) {
				$searchstring = " where produce like ? and version like '$keyword2'";
			} else if($search1 == "005" ) {
				$searchstring = " where result like ? ";
			} else if($search1 == "006" ){
				$searchstring = " where final_approval like ?";	
			} else if($search1 == "007" ){
				$searchstring = " where installation_date like ?";			
			} else if($search1 == "008" ){
				$searchstring = " where tax like ?";			
			}else if($search1 == "009" ){
				$searchstring = " where serial like ?";			
			}
		} else {
			$searchstring = "";
		}

		if (isset($this->cooperative_id) && !isset($this->id)){
			$sql = "select count(seq) as ucount from request_tech_support".$searchstring." where cooperative_email like '%{$this->cooperative_id}%' or engineer_email like '%{$this->cooperative_id}%' order by seq desc";
		}else{
			$sql = "select count(seq) as ucount from request_tech_support".$searchstring." order by seq desc";
		}


		if( $searchkeyword != "" ){
			if( $searchkeyword2 == "" ){
				$query = $this->db->query( $sql, $keyword  );
			}else{
				$query = $this->db->query( $sql, $keyword);
			}
		}else{
			$query = $this->db->query( $sql );
		}
		return $query->row();
	}

	//기술지원요청 view,modify 
	function request_tech_support_view($seq){
		if(strpos($seq,',') !== false){
			$sql = "select * from request_tech_support where seq in ({$seq})";
			$query = $this->db->query($sql);
	
			if ($query->num_rows() <= 0) {
				return false;
			} else {
				return $query->result_array() ;
				
			}
		}else{
			$sql = "select * from request_tech_support where seq = ?";
			$query = $this->db->query( $sql, $seq);
	
			if ($query->num_rows() <= 0) {
				return false;
			} else {
				return $query->row_array() ;
			}
		}
	}

	//기술지원요청 delete
	function request_tech_support_delete($seq){
		$sql = "delete from request_tech_support where seq = ?";
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	//협력사 메일 보냈으면 Y로 고치기
	function mailSendCheck($seq,$check,$check_value){
		$sql = "update request_tech_support set {$check} = '{$check_value}' where seq = ?";
		$query = $this->db->query( $sql, $seq );
		return	$query;
	}

	//기술지원요청 파일체크
	function request_tech_support_file( $seq, $filelcname){
		$sql = "select seq, file_real_name, file_change_name from request_tech_support where seq = ? and file_change_name = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );
		return $query->row_array();
	}

	// 기술지원요청 파일삭제
	function request_tech_support_del($seq) {
		$sql = "update request_tech_support set file_change_name = ?, file_real_name = ? where seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;
	}

	//기술지원요청 최종승인
	function finalApproval($seq){
		$sql = "update request_tech_support set final_approval = 'Y' where seq in ({$seq})";
		$result = $this->db->query($sql);
		return $result;
	}

	//세금계산서 승인번호 저장
	function taxNumber($seq,$tax){
		$sql = "update request_tech_support set tax='{$tax}' where seq in ({$seq})";
		$result = $this->db->query($sql);
		return $result;
	}

	//협력사 영업 담당자 찾기 + 담당자
	function cooperative_sales_manager($company_name){
		$sql = "SELECT * from sales_customer_staff WHERE customer_seq = (SELECT seq FROM sales_customer_basic WHERE company_name = ?) AND (user_work = '영업' or manager='Y') ";
		$query = $this->db->query($sql,$company_name);
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array() ;
		}
	}
}

?>
