<?php
header("Content-type: text/html; charset=utf-8");

class STC_Customer extends CI_Model {

	function __construct() {

		parent::__construct();
		$this->user_id = $this->phpsession->get( 'id', 'stc' );
		$this->cooperative_id = $this->phpsession->get( 'cooperative_id', 'stc' );
	}
	
	// 가입하고자 하는 사업자번호가 존재하는지 검사
	function check_num_exist( $cnum ) {
		$sql = "select seq from sales_customer_basic where cnum = ?";
		$query = $this->db->query( $sql, $cnum );

		if  ( $query->num_rows() == 0 ){		//	해당 사업자번호가 존재하지 않음
			return	0;
		}

		return	1;
	}
	
	//1. 거래처 기본사항의 max(seq)구하기
	function customer_max_seq() {
		$sql = "select max(seq) as seq from sales_customer_basic";
		$query = $this->db->query( $sql);		
		return $query->row_array();
	}

	// 1. 거래처 기본 추가및 수정
	function customer_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('sales_customer_basic', $data );
		}
		else {
			return $this->db->update('sales_customer_basic', $data, array('seq' => $seq));
		}
	}

	// 2. 거래처 담당자 추가및 수정
	function customer_insert2( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			$person_array = explode("||", $data['person_array']);

			for($i=1;$i<count($person_array);$i++)
			{
				$person_list = explode("~",$person_array[$i]);
				
				$sql = "insert into sales_customer_staff (customer_seq,user_branch,user_duty,user_name,user_tel,user_email,user_work,manager,bill_flag,default_flag,user_id,insert_date,update_date) values(?,?,?,?,?,?,?,?,?,?,?,now(),now())";
				$result = $this->db->query($sql, array($data['seq'],$person_list[0],$person_list[1],$person_list[2],$person_list[3],$person_list[4],$person_list[5],$person_list[6],$person_list[7],$person_list[8],$data['user_id']));
			}

			return $result;
		} else {
			// $sql2 = "delete from sales_customer_staff where customer_seq=?";
			// $this->db->query($sql2, $data['seq']);

			// $person_array = explode("||", $data['person_array']);

			// for($i=1;$i<count($person_array);$i++)
			// {
			// 	$person_list = explode("~",$person_array[$i]);
				
			// 	$sql = "insert into sales_customer_staff (customer_seq,user_branch,user_duty,user_name,user_tel,user_email,user_work,manager,bill_flag,default_flag,user_id,insert_date,update_date) values(?,?,?,?,?,?,?,?,?,?,?,now(),now())";
			// 	$result = $this->db->query($sql, array($data['seq'],$person_list[0],$person_list[1],$person_list[2],$person_list[3],$person_list[4],$person_list[5],$person_list[6],$person_list[7],$person_list[8],$data['user_id']));
			// }

			// return $result;
		}
	}

	// 거래처 담당자 insert
	function customer_staff_insert($data){
		return $this->db->insert('sales_customer_staff', $data);
	}

	// 거래처 담당자 update
	function customer_staff_update($data){
		return $this->db->update('sales_customer_staff', $data, array('seq' => $data['seq']));
	}

	// 거래처 담당자 삭제
	function customer_staff_delete($data) {
		$delete_person = explode(",", $data);
		for($i=0;$i<count($delete_person);$i++){
			$sql = "delete from sales_customer_staff where seq = {$delete_person[$i]} ";
			$result = $this->db->query($sql);
		}
		return $result;
	}
	
	// 3. 거래처 서비스(상품) 추가및 수정
	function customer_insert3( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('sales_customer_awards', $data );
		}
		else {
			return $this->db->update('sales_customer_awards', $data, array('customer_seq' => $seq));
		}
	}
	
	// 4. 거래처 서비스(용역-서비스제공정보) 추가및 수정
	function customer_insert4( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			$service_array = explode("||", $data['service_array']);

			for($i=1;$i<count($service_array);$i++)
			{
				$service_list = explode("~",$service_array[$i]);
				
				$sql = "insert into sales_customer_supply (customer_seq,service_supply,expert_work,insert_date,update_date) values(?,?,?,now(),now())";
				$this->db->query($sql, array($data['seq'],$service_list[0],$service_list[1]));
			}

			$project_array = explode("||", $data['project_array']);

			for($i=1;$i<count($project_array);$i++)
			{
				$project_list = explode("~",$project_array[$i]);
				
				$sql2 = "insert into sales_customer_record (customer_seq,project_name,perform_company,start_date,end_date,main_role,main_service,expertise,solution,insert_date,update_date) values(?,?,?,?,?,?,?,?,?,now(),now())";
				$this->db->query($sql2, array($data['seq'],$project_list[0],$project_list[1],$project_list[2],$project_list[3],$project_list[4],$project_list[5],$project_list[6],$project_list[7]));
			}
			
			$sql3 = "insert into sales_customer_etc (customer_seq,homepage,insert_date,update_date) values(?,?,now(),now())";
			$result = $this->db->query($sql3, array($data['seq'],$data['homepage']));

			return $result;
		} else {
			$sql = "delete from sales_customer_supply where customer_seq=?";
			$this->db->query($sql, $data['seq']);

			$service_array = explode("||", $data['service_array']);

			for($i=1;$i<count($service_array);$i++)
			{
				$service_list = explode("~",$service_array[$i]);
				
				$sql2 = "insert into sales_customer_supply (customer_seq,service_supply,expert_work,insert_date,update_date) values(?,?,?,now(),now())";
				$this->db->query($sql2, array($data['seq'],$service_list[0],$service_list[1]));
			}
			
			$sql3 = "delete from sales_customer_record where customer_seq=?";
			$this->db->query($sql3, $data['seq']);

			$project_array = explode("||", $data['project_array']);

			for($i=1;$i<count($project_array);$i++)
			{
				$project_list = explode("~",$project_array[$i]);
				
				$sql4 = "insert into sales_customer_record (customer_seq,project_name,perform_company,start_date,end_date,main_role,main_service,expertise,solution,insert_date,update_date) values(?,?,?,?,?,?,?,?,?,now(),now())";
				$this->db->query($sql4, array($data['seq'],$project_list[0],$project_list[1],$project_list[2],$project_list[3],$project_list[4],$project_list[5],$project_list[6],$project_list[7]));
			}
			
			$sql5 = "update sales_customer_etc set homepage=? where customer_seq=?";
			$result = $this->db->query($sql5, array($data['homepage'], $data['seq']));

			return $result;
		}
	}
	
	// 5. 거래처 재무정보 추가및 수정
	function customer_insert5( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('sales_customer_finance', $data );
		}
		else {
			return $this->db->update('sales_customer_finance', $data, array('customer_seq' => $seq));
		}
	}

	// 6. 거래처 신용정보 추가및 수정
	function customer_insert6( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('sales_customer_credit', $data );
		}
		else {
			return $this->db->update('sales_customer_credit', $data, array('customer_seq' => $seq));
		}
	}

	//1-1. 거래처 기본사항(사업자등록번호) 파일체크
	function customer_file( $seq, $filelcname ) {
		$sql = "select seq, cnumfile_realname, cnumfile_changename from sales_customer_basic where seq = ? and cnumfile_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );		
		return $query->row_array();
	}

	//1-2. 거래처 기본사항(계좌번호) 파일체크
	function customer_file2( $seq, $filelcname ) {
		$sql = "select seq, bnumfile_realname, bnumfile_changename from sales_customer_basic where seq = ? and bnumfile_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );		
		return $query->row_array();
	}
	
	//3-1. 거래처 서비스(상품) 파일체크
	function customer_file3( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from sales_customer_awards where customer_seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );		
		return $query->row_array();
	}

	//3-2. 거래처 서비스(소싱그룹) 파일체크
	function customer_file4( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from sales_sourcing_group where seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );		
		return $query->row_array();
	}

	//5-1. 거래처 전기 재무정보 파일체크
	function customer_file5( $seq, $filelcname ) {
		$sql = "select seq, bfile_realname, bfile_changename from sales_customer_finance where customer_seq = ? and bfile_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );		
		return $query->row_array();
	}
	
	// 5-1 거래처 전기 재무정보 파일삭제
	function customer_filedel5($seq) {
		$sql = "update sales_customer_finance set bfile_changename = ?, bfile_realname = ? where customer_seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	//5-2. 거래처 전전기 재무정보 파일체크
	function customer_file6( $seq, $filelcname ) {
		$sql = "select seq, bfile_realname2, bfile_changename2 from sales_customer_finance where customer_seq = ? and bfile_changename2 = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );		
		return $query->row_array();
	}
	
	// 5-2 거래처 전전기 재무정보 파일삭제
	function customer_filedel6($seq) {
		$sql = "update sales_customer_finance set bfile_changename2 = ?, bfile_realname2 = ? where customer_seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	//5-3. 거래처 기본정보 파일체크
	function customer_file7( $seq, $filelcname ) {
		$sql = "select seq, dfile_realname, dfile_changename from sales_customer_finance where customer_seq = ? and dfile_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );		
		return $query->row_array();
	}
	
	// 5-3 거래처 기본정보 파일삭제
	function customer_filedel7($seq) {
		$sql = "update sales_customer_finance set dfile_changename = ?, dfile_realname = ? where customer_seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	//5-4. 거래처 국세납세증명서  파일체크
	function customer_file8( $seq, $filelcname ) {
		$sql = "select seq, cfile_realname, cfile_changename from sales_customer_finance where customer_seq = ? and cfile_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );		
		return $query->row_array();
	}
	
	// 5-4 거래처 국세납세증명서 파일삭제
	function customer_filedel8($seq) {
		$sql = "update sales_customer_finance set cfile_changename = ?, cfile_realname = ? where customer_seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}

	//5-5. 거래처 지방세증명서  파일체크
	function customer_file9( $seq, $filelcname ) {
		$sql = "select seq, gfile_realname, gfile_changename from sales_customer_finance where customer_seq = ? and gfile_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );		
		return $query->row_array();
	}
	
	// 5-5 거래처 지방세증명서 파일삭제
	function customer_filedel9($seq) {
		$sql = "update sales_customer_finance set gfile_changename = ?, gfile_realname = ? where customer_seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;

	}
	
	//6. 거래처 신용정보  파일체크
	function customer_file10( $seq, $filelcname ) {
		$sql = "select seq, file_realname, file_changename from sales_customer_credit where customer_seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );		
		return $query->row_array();
	}

	//	1. 거래처 기본사항 뷰내용 가져오기
	function customer_view( $seq = 0 ) {
		$sql = "select * from sales_customer_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}
	
	//	2. 거래처 담당자 뷰내용 가져오기
	function customer_view2( $seq = 0 ) {
		$sql = "select * from sales_customer_staff where customer_seq = ? order by default_flag asc";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array() ;
		}
	}

	//	3. 거래처 서비스(상품) 뷰내용 가져오기
	function customer_view3( $seq = 0 ) {
		$sql = "select * from sales_customer_awards where customer_seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	//	4-1. 거래처 서비스(용역-서비스제공정보) 뷰내용 가져오기
	function customer_view4( $seq = 0 ) {
		$sql = "select * from sales_customer_supply where customer_seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//	4-2. 거래처 서비스(용역-프로젝트수행이력) 뷰내용 가져오기
	function customer_view5( $seq = 0 ) {
		$sql = "select * from sales_customer_record where customer_seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//	4-3. 거래처 서비스(용역-기타사항) 뷰내용 가져오기
	function customer_view6( $seq = 0 ) {
		$sql = "select * from sales_customer_etc where customer_seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	//	5. 거래처 재무정보 뷰내용 가져오기
	function customer_view7( $seq = 0 ) {
		$sql = "select * from sales_customer_finance where customer_seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	//	6. 거래처 신용정보 뷰내용 가져오기
	function customer_view8( $seq = 0 ) {
		$sql = "select * from sales_customer_credit where customer_seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	// 거래처 삭제
	function customer_delete( $seq ) {
		$sql = "delete from sales_customer_basic where seq = ?";		
		$query = $this->db->query( $sql, $seq );
		$sql2 = "delete from sales_customer_staff where customer_seq = ?";		
		$query = $this->db->query( $sql2, $seq );
		$sql3 = "delete from sales_customer_awards where customer_seq = ?";		
		$query = $this->db->query( $sql3, $seq );
		$sql4 = "delete from sales_customer_supply where customer_seq = ?";		
		$query = $this->db->query( $sql4, $seq );
		$sql5 = "delete from sales_customer_record where customer_seq = ?";		
		$query = $this->db->query( $sql5, $seq );
		$sql6 = "delete from sales_customer_etc where customer_seq = ?";		
		$query = $this->db->query( $sql6, $seq );
		$sql7 = "delete from sales_customer_finance where customer_seq = ?";		
		$query = $this->db->query( $sql7, $seq );
		$sql8 = "delete from sales_customer_credit where customer_seq = ?";		
		$query = $this->db->query( $sql8, $seq );

		return	$query;
	}

	// 거래처 리스트
	function customer_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";
		
		if($searchkeyword != "") {
			if($search2 == "001") {
				$searchstring = " where seq like ? ";
			} else if($search2 == "002") {
				$searchstring = " where company_name like ? ";
			} else if($search2 == "003") {
				$searchstring = " where cnum like ? ";
			} else if($search2 == "004") {
				$searchstring = " where represent_name like ? ";
			} else if($search2 == "005") {
				$searchstring = " where represent_tel like ? ";
			} else if($search2 == "006") {
				$searchstring = " where represent_handphone like ? ";
			} else if($search2 == "007") {
				$searchstring = " where represent_email like ? ";
			}
		} else {
			$searchstring = "";
		}

		if (isset($this->cooperative_id) && !isset($this->id)){
			$sql = "select scb.* from sales_customer_basic AS scb JOIN sales_customer_staff AS scs ON scb.seq=scs.customer_seq".$searchstring." and scs.user_email='".$this->cooperative_id."' AND scs.manager='Y' order by scb.seq DESC";
		}else{
			$sql = "select * from sales_customer_basic".$searchstring." order by seq desc";
		}
		
		
		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );	
		else 
			$query = $this->db->query( $sql, array( $start_limit, $offset ) );

		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}
	
	//거래처 리스트개수
	function customer_list_count($searchkeyword, $search1, $search2) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search2 == "001") {
				$searchstring = " where seq like ? ";
			} else if($search2 == "002") {
				$searchstring = " where company_name like ? ";
			} else if($search2 == "003") {
				$searchstring = " where cnum like ? ";
			} else if($search2 == "004") {
				$searchstring = " where represent_name like ? ";
			} else if($search2 == "005") {
				$searchstring = " where represent_tel like ? ";
			} else if($search2 == "006") {
				$searchstring = " where represent_handphone like ? ";
			} else if($search2 == "007") {
				$searchstring = " where represent_email like ? ";
			}
		} else {
			$searchstring = "";
		}
		
		if (isset($this->cooperative_id) && !isset($this->id)){ //협력사 로그인
			$sql = "select count(scb.seq) as ucount from sales_customer_basic AS scb JOIN sales_customer_staff AS scs ON scb.seq=scs.customer_seq".$searchstring." and scs.user_email='".$this->cooperative_id."' AND scs.manager='Y' order by scb.seq DESC";
		}else{
			$sql = "select count(seq) as ucount from sales_customer_basic".$searchstring." order by seq desc";
		}
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );	
		else 
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// 거래처 3단계 SourcingGroup 리스트
	function sourcing_list2( $searchkeyword, $search1, $search2) {
		$keyword = "%".$searchkeyword."%";
		
		if($searchkeyword != "") {
			if($search2 == "001") {
				$searchstring = " where solution_group like ? ";
			} else if($search2 == "002") {
				$searchstring = " where product_company like ? ";
			} else if($search2 == "003") {
				$searchstring = " where product_capacity like ? ";
			} else if($search2 == "004") {
				$searchstring = " where ecount like ? ";
			} else if($search2 == "005") {
				$searchstring = " where dcount like ? ";
			} else if($search2 == "006") {
				$searchstring = " where manage like ? ";
			} 
		} else {
			$searchstring = "";
		}
		
		$sql = "select * from sales_sourcing_group".$searchstring." order by seq desc";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword );	
		else 
			$query = $this->db->query( $sql );

		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}
	
	//거래처 3단계 SourcingGroup 리스트개수
	function sourcing_list_count2($searchkeyword, $search1, $search2) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search2 == "001") {
				$searchstring = " where solution_group like ? ";
			} else if($search2 == "002") {
				$searchstring = " where product_company like ? ";
			} else if($search2 == "003") {
				$searchstring = " where product_capacity like ? ";
			} else if($search2 == "004") {
				$searchstring = " where ecount like ? ";
			} else if($search2 == "005") {
				$searchstring = " where dcount like ? ";
			} else if($search2 == "006") {
				$searchstring = " where manage like ? ";
			} 
		} else {
			$searchstring = "";
		}
		
		$sql = "select count(seq) as ucount from sales_sourcing_group".$searchstring." order by seq desc";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );	
		else 
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// SourcingGroup 리스트
	function sourcing_list( $searchkeyword, $search1, $search2, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";
		
		if($searchkeyword != "") {
			if($search2 == "001") {
				$searchstring = " where solution_group like ? ";
			} else if($search2 == "002") {
				$searchstring = " where product_company like ? ";
			} else if($search2 == "003") {
				$searchstring = " where product_capacity like ? ";
			} else if($search2 == "004") {
				$searchstring = " where ecount like ? ";
			} else if($search2 == "005") {
				$searchstring = " where dcount like ? ";
			} else if($search2 == "006") {
				$searchstring = " where manage like ? ";
			} 
		} else {
			$searchstring = "";
		}
		
		$sql = "select * from sales_sourcing_group".$searchstring." order by seq desc";
		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );	
		else 
			$query = $this->db->query( $sql, array( $start_limit, $offset ) );

		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}
	
	//SourcingGroup 리스트개수
	function sourcing_list_count($searchkeyword, $search1, $search2) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search2 == "001") {
				$searchstring = " where solution_group like ? ";
			} else if($search2 == "002") {
				$searchstring = " where product_company like ? ";
			} else if($search2 == "003") {
				$searchstring = " where product_capacity like ? ";
			} else if($search2 == "004") {
				$searchstring = " where ecount like ? ";
			} else if($search2 == "005") {
				$searchstring = " where dcount like ? ";
			} else if($search2 == "006") {
				$searchstring = " where manage like ? ";
			} 
		} else {
			$searchstring = "";
		}
		
		$sql = "select count(seq) as ucount from sales_sourcing_group".$searchstring." order by seq desc";
		
		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );	
		else 
			$query = $this->db->query( $sql );
		return $query->row();
	}

	// SourcingGroup 추가및 수정
	function sourcing_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) {
			return $this->db->insert('sales_sourcing_group', $data );
		}
		else {
			return $this->db->update('sales_sourcing_group', $data, array('seq' => $seq));
		}
	}
	
	//	SourcingGroup 뷰내용 가져오기
	function sourcing_view( $seq = 0 ) {
		$sql = "select * from sales_sourcing_group where seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	// SourcingGroup 삭제
	function sourcing_delete( $seq ) {
		$sql = "delete from sales_sourcing_group where seq = ?";		
		$query = $this->db->query( $sql, $seq );
		
		return	$query;
	}
}
?>