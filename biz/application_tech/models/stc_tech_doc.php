<?php
header("Content-type: text/html; charset=utf-8");

class STC_tech_doc extends CI_Model {

	function __construct() {

		parent::__construct();
//		$this->user_id = $this->phpsession->get( 'id', 'stc' );
		$this->at = $this->phpsession->get( 'at', 'stc' );
		$this->name= $this->phpsession->get( 'name', 'stc' );
		$this->pGroupName= $this->phpsession->get( 'pGroupName', 'stc' );
	}


	// 고객사 정보 가저오기
	//카테고리 알아오기
	function get_customer() {
		// $sql = "select seq as forcasting_seq, customer_companyname as customer, customer_username, exception_saledate2 as maintain_start, exception_saledate3 as maintain_end , project_name from sales_forcasting WHERE (sub_project_add IS NULL) or (sub_project_add IS not NULL AND sub_project_add not like CONCAT('%',seq,'%')) order by binary(customer)";
		//	$sql = "select distinct (customer_companyname) as customer from sales_forcasting order by binary(customer)";
		// $sql = "select t1.seq as maintain_seq,t1.forcasting_seq ,t1. customer_companyname as customer,t1.customer_username, t1.exception_saledate2 as maintain_start, t1.exception_saledate3 as maintain_end , t1.project_name from sales_maintain AS t1,(select max(seq) as max_sort,forcasting_seq from sales_maintain WHERE NOW() between exception_saledate2 AND exception_saledate3 group by forcasting_seq) as t2 where t1.seq = t2.max_sort order by binary(customer_companyname)";
		$sql = "select seq as maintain_seq, forcasting_seq , customer_companyname as customer, customer_username, exception_saledate2 as maintain_start, exception_saledate3 as maintain_end , project_name from sales_maintain WHERE NOW() between exception_saledate2 AND exception_saledate3 order by binary(customer_companyname)";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_customer2() {
		// $sql = "select seq as forcasting_seq, customer_companyname as customer, customer_username, exception_saledate2 as maintain_start, exception_saledate3 as maintain_end , project_name from sales_forcasting WHERE (sub_project_add IS NULL) or (sub_project_add IS not NULL AND sub_project_add not like CONCAT('%',seq,'%')) order by binary(customer)";
		//	$sql = "select distinct (customer_companyname) as customer from sales_forcasting order by binary(customer)";
		$sql = "select t1.seq as forcasting_seq,t1.customer_companyname as customer,t1.customer_username, t1.exception_saledate2 as maintain_start, t1.exception_saledate3 as maintain_end , t1.project_name from sales_forcasting AS t1 order by binary(customer_companyname)";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 기술지원보고서 문서번호 카운트 세기
	function tech_doc_num_count( $year = 0 ,$month = 0, $seq = 0 ) {
		if ($seq != 0) {

		$searchstring = " where YEAR(income_time) like ? AND MONTH(income_time) like ? AND seq BETWEEN 1 AND ? ";
		$sql = "select seq from tech_doc_basic".$searchstring;
		$query = $this->db->query( $sql, array($year, $month, $seq-1) );

		}//  수정포인트 -
		if ($seq == 0){
		$searchstring = " where YEAR(income_time) like ? AND MONTH(income_time) like ?"; //  수정포인트 -
		$sql = "select seq from tech_doc_basic".$searchstring;
		$query = $this->db->query( $sql, array($year, $month) );
		}
		return $query->num_rows();
	}

	//기술지원 보고서 파일체크
	function tech_doc_file( $seq, $filelcname){
		$sql = "select seq, file_realname, file_changename from tech_doc_basic where seq = ? and file_changename = ?";
		$query = $this->db->query( $sql, array($seq, $filelcname) );
		return $query->row_array();
	}

	// 기술지원 보고서 파일삭제
	function tech_doc_filedel($seq) {
		$sql = "update tech_doc_basic set file_changename = ?, file_realname = ? where seq = ?";
		$result = $this->db->query($sql, array(NULL,NULL,$seq));
		return $result;
	}

//기술지원보고서 리스트
function tech_doc_list( $searchkeyword, $searchkeyword2, $search1, $start_limit = 0, $offset = 0) {
	$keyword = "%".$searchkeyword."%";
	$keyword2 = "%".$searchkeyword2."%";

	if($searchkeyword != "") {
		if($search1 == "001") {
			$searchstring = " where subject like ? "; //  수정포인트 -작업명
		} else if($search1 == "002" ) {
			$searchstring = " where customer like ? "; //  수정포인트 - 고객사
		} else if($search1 == "003" ) {
			$searchstring = " where writer like ? "; //  수정포인트 - 작성자
		} else if($search1 == "004" ) {
			$searchstring = " where income_time like ? "; //  수정포인트 - 작업일
		} else if($search1 == "005" ) {
			if($keyword=="%완료%"){
				$keyword="기술지원 완료%";
			}
			$searchstring = " where result like ? "; //  수정포인트 - 결과
		} else if($search1 == "006" ){

		$searchstring = " where produce like ? and version like '$keyword2'";
		}

	} else {
		$searchstring = "";
	}

	//읽기 권한
	if(substr($this->at,0,1) >= 4){
		if(substr($this->at,1,1) < 4 && substr($this->at,2,1) < 4){
			$sql = "select * from tech_doc_basic".$searchstring." where writer ='{$this->name}' order by seq desc";
		}else if(substr($this->at,1,1) >= 4 && substr($this->at,2,1) < 4){
			$sql = "select tdb.* from tech_doc_basic ".$searchstring."as tdb JOIN (SELECT tu.seq,ug.parentGroupName FROM (SELECT t. seq ,u.user_group from tech_doc_basic AS t JOIN user u ON t.writer = u.user_name) tu JOIN user_group ug ON tu.user_group = ug.groupName)as pgn ON tdb.seq = pgn.seq WHERE pgn.parentGroupName ='".$this->pGroupName."' order by tdb.seq desc";
		}else{
			$sql = "select * from tech_doc_basic".$searchstring." order by seq desc";
		}
	}else if((substr($this->at,0,1) < 4)){
		if(substr($this->at,1,1) < 4 && substr($this->at,2,1) < 4){ //읽기에 대한 권한이 아무것도 없음
			$sql = "select * from tech_doc_basic".$searchstring." where seq <0 order by seq desc";
		}else if(substr($this->at,1,1) >= 4 && substr($this->at,2,1) < 4){
			$sql = "select tdb.* from tech_doc_basic ".$searchstring."as tdb JOIN (SELECT tu.seq,ug.parentGroupName FROM (SELECT t. seq ,u.user_group from tech_doc_basic AS t JOIN user u ON t.writer = u.user_name) tu JOIN user_group ug ON tu.user_group = ug.groupName)as pgn ON tdb.seq = pgn.seq WHERE pgn.parentGroupName ='".$this->pGroupName."' order by tdb.seq desc";
		}else{
			$sql = "select * from tech_doc_basic".$searchstring." order by seq desc";
		}
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


// 기술지원보고서 리스트개수
function tech_doc_list_count( $searchkeyword,$searchkeyword2, $search1, $start_limit = 0, $offset = 0) {
	$keyword = "%".$searchkeyword."%";
	$keyword2 = "%".$searchkeyword2."%";

	if($searchkeyword != "") {
		if($search1 == "001") {
			$searchstring = " where subject like ? "; //  수정포인트 -작업명
		} else if($search1 == "002" ) {
			$searchstring = " where customer like ? "; //  수정포인트 - 고객사
		} else if($search1 == "003" ) {
			$searchstring = " where writer like ? "; //  수정포인트 - 작성자
		} else if($search1 == "004" ) {
			$searchstring = " where income_time like ? "; //  수정포인트 - 작업일
		} else if($search1 == "005" ) {
			$searchstring = " where result like ? "; //  수정포인트 - 작업일
		} else if($search1 == "006" ) {

			$searchstring = " where produce like ? and version like '$keyword2'";

		}

	} else {
		$searchstring = "";
	}

	//읽기 권한
	if(substr($this->at,0,1) >= 4){
		if(substr($this->at,1,1) < 4 && substr($this->at,2,1) < 4){
			$sql = "select count(seq) as ucount from tech_doc_basic".$searchstring." where writer ='{$this->name}' order by seq desc";
		}else if(substr($this->at,1,1) >= 4 && substr($this->at,2,1) < 4){
			$sql = "select count(seq) as ucount from tech_doc_basic ".$searchstring."as tdb JOIN (SELECT tu.seq,ug.parentGroupName FROM (SELECT t. seq ,u.user_group from tech_doc_basic AS t JOIN user u ON t.writer = u.user_name) tu JOIN user_group ug ON tu.user_group = ug.groupName)as pgn ON tdb.seq = pgn.seq WHERE pgn.parentGroupName ='".$this->pGroupName."' order by tdb.seq desc";
		}else{
			$sql = "select count(seq) as ucount from tech_doc_basic".$searchstring." order by seq desc"; //  수정포인트
		}
	}else if((substr($this->at,0,1) < 4)){
		if(substr($this->at,1,1) < 4 && substr($this->at,2,1) < 4){
			$sql = "select count(seq) as ucount from tech_doc_basic".$searchstring." where seq < 0 order by seq desc";
		}else if(substr($this->at,1,1) >= 4 && substr($this->at,2,1) < 4){
			$sql = "select count(seq) as ucount from tech_doc_basic ".$searchstring."as tdb JOIN (SELECT tu.seq,ug.parentGroupName FROM (SELECT t. seq ,u.user_group from tech_doc_basic AS t JOIN user u ON t.writer = u.user_name) tu JOIN user_group ug ON tu.user_group = ug.groupName)as pgn ON tdb.seq = pgn.seq WHERE pgn.parentGroupName ='".$this->pGroupName."' order by tdb.seq desc";
		}else{
			$sql = "select count(seq) as ucount from tech_doc_basic".$searchstring." order by seq desc"; //  수정포인트
		}
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

	function tech_doc_insert( $data, $mode = 0 , $seq = 0) {
		if( $mode == 0 ) { //insert
			$result = $this->db->insert('tech_doc_basic', $data );

			if($result){
				//수정이 필요한 부분
				$engineer = $data['engineer'];
				$sql3 = "SELECT * FROM weekly_report WHERE (SELECT income_time from tech_doc_basic order by seq desc limit 1) BETWEEN s_date AND e_date AND (";
				if(strpos($engineer, ',') !== false){ //엔지니어 여러명일때
					$engineer = explode(',',$engineer);
					for($i =0; $i <count($engineer); $i++){
						$name = mb_substr(trim($engineer[$i]),0,3);
						if($i==0){
							$sql3 .= "group_name = (SELECT user_group FROM user where user_name = '{$name}')";
						}else{
							$sql3 .= " or group_name = (SELECT user_group FROM user where user_name = '{$name}')";
						}
					}
				}else{//엔지니어 한명 일 때
					$name = mb_substr(trim($engineer),0,3);
					$sql3 .= "group_name = (SELECT user_group FROM user where user_name = '{$name}')";
				}
				$sql3 .= "or group_name ='기술본부')";
				//이거 쿼리로 한번에 할 수 있게 수정해바

				$query = $this->db->query($sql3);
				if ($query->num_rows() <= 0) {
					return $result;
				} else {
					$weekly_report = $query->result_array();
					$produceinfo='';
					$produce= explode(",",$data['produce']);
					$host= explode(",",$data['host']);
					$version= explode(",",$data['version']);
					$hardware= explode(",",$data['hardware']);
					$license= explode(",",$data['license']);
					for($i=0; $i < count($produce); $i++){
						if($i!=count($produce)){
							$produceinfo .= "{$produce[$i]}/{$host[$i]}/{$version[$i]}/{$hardware[$i]}/{$license[$i]}\n";
						}else{
							$produceinfo .= "{$produce[$i]}/{$host[$i]}/{$version[$i]}/{$hardware[$i]}/{$license[$i]}";
						}
					}

					for($i =0; $i < count($weekly_report); $i++){
						$sql3 = "INSERT INTO weekly_report_doc (report_seq,tech_seq,group_name,year,month,week,type,work_name,produce,customer,subject,writer,income_time,insert_time) values ({$weekly_report[$i]['seq']},(SELECT seq from tech_doc_basic order by seq desc limit 1),'{$weekly_report[$i]['group_name']}','{$weekly_report[$i]['year']}','{$weekly_report[$i]['month']}','{$weekly_report[$i]['week']}',0,'{$data['work_name']}','{$produceinfo}','{$data['customer']}','{$data['subject']}','{$data['engineer']}','{$data['income_time']}', NOW())";
						$query3 = $this->db->query($sql3);
					}
					return $query3;
				}
			}else{
				return $result;
			}
		} else {
			$sql2 = "SELECT * FROM weekly_report_doc WHERE tech_seq ={$seq}";
			$query2 = $this->db->query($sql2);
			if($query2->num_rows() <= 0){
				$result =  $this->db->update('tech_doc_basic', $data, array('seq' => $seq));
				//////
				$engineer = $data['engineer'];
				$sql3 = "SELECT * FROM weekly_report WHERE (SELECT income_time from tech_doc_basic order by seq desc limit 1) BETWEEN s_date AND e_date AND (";
				if(strpos($engineer, ',') !== false){ //엔지니어 여러명일때
					$engineer = explode(',',$engineer);
					for($i =0; $i <count($engineer); $i++){
						$name = mb_substr(trim($engineer[$i]),0,3);
						if($i==0){
							$sql3 .= "group_name = (SELECT user_group FROM user where user_name = '{$name}')";
						}else{
							$sql3 .= " or group_name = (SELECT user_group FROM user where user_name = '{$name}')";
						}
					}
				}else{//엔지니어 한명 일 때
					$name = mb_substr(trim($engineer),0,3);
					$sql3 .= "group_name = (SELECT user_group FROM user where user_name = '{$name}')";
				}
				$sql3 .= "or group_name ='기술본부')";
				//이거 쿼리로 한번에 할 수 있게 수정해바

				$query = $this->db->query($sql3);
				if ($query->num_rows() <= 0) {
					return $result;
				} else {
					$weekly_report = $query->result_array();
					$produceinfo='';
					$produce= explode(",",$data['produce']);
					$host= explode(",",$data['host']);
					$version= explode(",",$data['version']);
					$hardware= explode(",",$data['hardware']);
					$license= explode(",",$data['license']);
					for($i=0; $i < count($produce); $i++){
						if($i!=count($produce)){
							$produceinfo .= "{$produce[$i]}/{$host[$i]}/{$version[$i]}/{$hardware[$i]}/{$license[$i]}\n";
						}else{
							$produceinfo .= "{$produce[$i]}/{$host[$i]}/{$version[$i]}/{$hardware[$i]}/{$license[$i]}";
						}
					}

					for($i =0; $i < count($weekly_report); $i++){
						$sql3 = "INSERT INTO weekly_report_doc (report_seq,tech_seq,group_name,year,month,week,type,work_name,produce,customer,subject,writer,income_time,insert_time) values ({$weekly_report[$i]['seq']},{$seq},'{$weekly_report[$i]['group_name']}','{$weekly_report[$i]['year']}','{$weekly_report[$i]['month']}','{$weekly_report[$i]['week']}',0,'{$data['work_name']}','{$produceinfo}','{$data['customer']}','{$data['subject']}','{$data['engineer']}','{$data['income_time']}', NOW())";
						$query3 = $this->db->query($sql3);
					}
				}
				return $result;
			}else{

				$produceinfo='';
				$produce= explode(",",$data['produce']);
				$host= explode(",",$data['host']);
				$version= explode(",",$data['version']);
				$hardware= explode(",",$data['hardware']);
				$license= explode(",",$data['license']);
				for($i=0; $i < count($produce); $i++){
					if($i!=count($produce)){
						$produceinfo .= "{$produce[$i]}/{$host[$i]}/{$version[$i]}/{$hardware[$i]}/{$license[$i]}\n";
					}else{
						$produceinfo .= "{$produce[$i]}/{$host[$i]}/{$version[$i]}/{$hardware[$i]}/{$license[$i]}";
					}
				}

				$result = $this->db->update('tech_doc_basic', $data, array('seq' => $seq));

				if($result){
					$weekly=$query2->result_array();

					for($i=0; $i<count($weekly); $i++){
						$sql3="update weekly_report_doc set work_name='{$data['work_name']}' ,income_time='{$data['income_time']}' ,customer='{$data['customer']}', produce='{$produceinfo}',writer='{$data['engineer']}', update_time = now() where seq = {$weekly[$i]['seq']}";
						$result = $this->db->query($sql3);
					}
					return $result;
				}else{
					return $result;
				}
			}
		}
	}

	//정기점검보고서 썼을때 유지보수에서 점검여부 완료로 수정 하는고
	// function maintain_result($some_inspection,$data,$mode){
	function maintain_result($some_inspection,$data){
		$maintain_type='';
		$maintain_result ='';
		$file='';

		if($data['handle'] == "현장지원"){
			$maintain_type=1;
		}else{
			$maintain_type=2;
		}

		if($some_inspection == 'N'){ //전체완료 일땐 완료
			$maintain_result = 1;
		}else{ 						//부분 완료일때는 미완료
			$maintain_result = 0;
		}

		if(isset($data['file_realname']) && isset($data['file_changename'])){ //첨부파일 여부
			$file='Y';
		}else{
			$file='N';
		}

		// if($mode == 0){ //기존 프로젝트로 update
		// 	$sql="update sales_forcasting set maintain_date='".$data['income_time']."', maintain_result={$maintain_result}, maintain_user='".$data['writer']."', file='{$file}', maintain_type='{$maintain_type}'
		// 	WHERE seq in (select * from (SELECT seq FROM sales_forcasting WHERE sub_project_add = (SELECT sub_project_add FROM sales_forcasting where seq ={$data['forcasting_seq']}) OR seq = {$data['forcasting_seq']})as t)";
		// 	$result = $this->db->query($sql);
		// }else{//제품의 프로젝트로
		// 	$sql="select forcasting_seq as seq from sales_forcasting as t1 join sales_forcasting_product as t2 on t1.seq = t2.forcasting_seq WHERE t2.seq IN ({$data['produce_seq']}) GROUP BY forcasting_seq";
		// 	$update_seq = $this->db->query($sql)->result_array();

		// 	for($i=0; $i<count($update_seq); $i++){
		// 		$sql1="update sales_forcasting set maintain_date='".$data['income_time']."', maintain_result={$maintain_result}, maintain_user='".$data['writer']."', file='{$file}', maintain_type='{$maintain_type}'
		// 		where seq in (select * from (SELECT seq FROM sales_forcasting WHERE sub_project_add = (SELECT sub_project_add FROM sales_forcasting where seq ={$update_seq[$i]['seq']}) OR seq ={$update_seq[$i]['seq']})as t)";
		// 		$result = $this->db->query($sql1);
		// 	}
		// }
		if($data['maintain_seq'] == null || $data['maintain_seq'] == ""){//이전 데이터 기지보 수정 할때 maintain_seq 없을때
			// $sql = "update sales_maintain set maintain_date='{$data['income_time']}', maintain_result={$maintain_result}, maintain_user='{$data['writer']}', file='{$file}', maintain_type='{$maintain_type}' WHERE seq = {$data['maintain_seq']} ";
			$sql = "UPDATE sales_maintain SET maintain_date='{$data['income_time']}', maintain_result={$maintain_result}, maintain_user='{$data['writer']}', file='{$file}', maintain_type='{$maintain_type}' WHERE forcasting_seq = {$data['forcasting_seq']} ORDER BY seq DESC  LIMIT 1";
		}else{
			$sql = "update sales_maintain set maintain_date='{$data['income_time']}', maintain_result={$maintain_result}, maintain_user='{$data['writer']}', file='{$file}', maintain_type='{$maintain_type}' WHERE seq = {$data['maintain_seq']} ";
		}
		$result = $this->db->query($sql);
		return $result;
	}

	//	공지사항 뷰내용 가져오기
	function tech_doc_view( $seq ) {

		///test////
		if(strpos($seq,',') == false){
			$sql = "select * from tech_doc_basic where seq = ?";
			$query = $this->db->query( $sql, $seq);

		}else{
			$seq = explode(',',$seq);

			$sql = "select * from tech_doc_basic where seq = {$seq[0]}";
			for($i=1; $i<count($seq); $i++){
				$sql = $sql." or seq={$seq[$i]}";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	//메일 보냈는지 확인
	function tech_mail_send($mail_send,$seq){

		if(strpos($seq,',') == false){
			$sql = "update tech_doc_basic set mail_send=? where seq=?";
			$query = $this->db->query($sql,array($mail_send,$seq));
		}else{
			$seq = explode(',',$seq);
			$sql = "update tech_doc_basic set mail_send='{$mail_send}' where seq = {$seq[0]}";
			for($i=1; $i<count($seq); $i++){
				$sql = $sql." or seq = {$seq[$i]}";
			}
			$query = $this->db->query($sql);
		}
	}

	// 삭제
	function tech_doc_delete( $seq ) {
		$sql = "delete from tech_doc_basic where seq = ?";
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}





	//===========================================================

	//Site 장비등록 관린 쿼리
	// db table : sales_forcasting_product
	//
	//
		// 추가및 수정
	function tech_device_insert( $data, $mode , $seq) {
			$result = $this->db->update('sales_maintain_product', $data, array('seq' => $seq));
			$sql = "select * from sales_maintain_product where seq = {$seq}";
			$update_data = $this->db->query($sql)->row_array();
			// echo "<script>alert('{$update_data['integration_maintain_product_seq']}')</script>";
			if($update_data['integration_maintain_product_seq'] != "" || $update_data['integration_maintain_product_seq']!= null){
				$result =  $this->db->update('sales_integration_maintain_product', $data, array('seq' => $update_data['integration_maintain_product_seq']));
			}
			return $result;
	}

	//장비등록  보기/수정  장비 뷰
	function tech_device_view( $seq ) {
		// $sql = "select * from sales_forcasting as t1 join sales_forcasting_product as t2 join product as t3 on t1.seq=t2.forcasting_seq and t2.product_code=t3.seq where t2.seq = ?";
		$sql = "select * from sales_maintain as t1 join sales_maintain_product as t2 join product as t3 on t1.seq=t2.maintain_seq and t2.product_code=t3.seq where t2.seq = ?";
		$query = $this->db->query( $sql, $seq );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	// 삭제
	function tech_device_delete( $seq ) {
		$sql = "delete from site_device where seq = ?";
		$query = $this->db->query( $sql, $seq );

		return	$query;
	}

	//점검항목 템플릿 가져오기
	function check_list_template($seq){
		if($seq == 'all'){
			$sql = "select * from product_check_list_template";
		}else{
			$sql = "select * from product_check_list_template where seq = '{$seq}'";
		}

		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//정기점검 2 기술지원 보고서에서 템플릿 가져오기
	function template($product){
		// $sql = "select * from product_check_list_template where seq = (SELECT sp.product_check_list from sales_forcasting_product AS sp JOIN sales_forcasting AS sf ON sp.forcasting_seq = sf.seq WHERE sp.seq={$product}) or product_name =(SELECT sp.product_check_list from sales_forcasting_product AS sp JOIN sales_forcasting AS sf ON sp.forcasting_seq = sf.seq WHERE sp.seq={$product})";
		$sql ="select * from product_check_list_template where seq = (SELECT sp.product_check_list from sales_maintain_product AS sp JOIN sales_maintain AS sf ON sp.maintain_seq = sf.seq WHERE sp.seq={$product})";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	// 기술지원보고서 리스트
	function tech_device_list( $searchkeyword, $search1, $start_limit = 0, $offset = 0) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "001") {
				$searchstring = " where product_name like ? ";
			} else if($search1 == "002" ) {
				$searchstring = " where customer_companyname like ? ";
			} else if($search1 == "003" ) {
				$searchstring = " where product_serial like ? ";
			}

		} else {
			$searchstring = "";
		}

		//$sql = "select seq, customer, produce, writer, end_date from site_device".$searchstring." order by seq desc";
		// $sql = "select t2.seq,customer_companyname,product_version,product_name,product_item,product_serial,product_state,t2.product_check_list,t2.product_host from sales_forcasting as t1 join sales_forcasting_product as t2 join product as t3 on t1.seq=t2.forcasting_seq and t2.product_code=t3.seq".$searchstring." order by t1.seq desc,t2.seq desc";
		$sql = "select t2.seq,customer_companyname,product_version,product_name,product_item,product_serial,product_state,t2.product_check_list,t2.product_host,t1.project_name
		from (SELECT * from sales_maintain WHERE NOW() between exception_saledate2 AND exception_saledate3) as t1 join sales_maintain_product as t2 join product as t3 on t1.seq=t2.maintain_seq and t2.product_code=t3.seq".$searchstring." order by t1.seq desc,t2.seq DESC";
		if  ( $offset <> 0 )
			$sql = $sql." limit ?, ?";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
		else
			$query = $this->db->query( $sql, array( $start_limit, $offset ) );

		return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
	}

	// 리스트개수
	function tech_device_list_count($searchkeyword, $search1) {
		$keyword = "%".$searchkeyword."%";

		if($searchkeyword != "") {
			if($search1 == "001") {
				$searchstring = " where product_name like ? ";
			} else if($search1 == "002" ) {
				$searchstring = " where customer_companyname like ? ";
			} else if($search1 == "003" ) {
				$searchstring = " where product_serial like ? ";
			}

		} else {
			$searchstring = "";
		}

		$sql = "select count(*) as ucount from (SELECT * from sales_maintain WHERE NOW() between exception_saledate2 AND exception_saledate3) as t1 join sales_forcasting_product as t2 join product as t3 on t1.seq=t2.forcasting_seq and t2.product_code=t3.seq".$searchstring." order by t1.seq desc,t2.seq desc";

		if  ( $searchkeyword != "" )
			$query = $this->db->query( $sql, $keyword  );
		else
			$query = $this->db->query( $sql );
		return $query->row();
	}

	//점검항목 템플릿 insert
	function product_check_list_input($data){
		$sql="insert into product_check_list_template (product_name,check_list) values('{$data['product_name']}','{$data['check_list']}')";
		$query =$this->db->query($sql);
		return	$query;
	}

	//점검항목 템플릿 delete
	function product_check_list_delete($seq){
		$sql="delete from product_check_list_template where seq= '{$seq}'";
		$query =$this->db->query($sql);
		return	$query;
	}

	//점검항목 템플릿 update
	function product_check_list_update($data){
		$sql="update product_check_list_template set product_name='{$data['product_name']}', check_list='{$data['check_list']}' where seq={$data['seq']}";
		$query =$this->db->query($sql);
		return	$query;
	}

	//cover insert
	function cover_insert($cover_name){
		$sql="insert into cover (cover_name) values ('{$cover_name}') ";
		$query =$this->db->query($sql);
		return	$query;
	}

	//cover select
	function cover_select($seq=''){
		if($seq == '' || $seq =='basic'){
			$sql="select * from cover";
		}else{
			$sql="select * from cover where seq={$seq}";
		}

		$query =$this->db->query($sql);
		return $query->result_array();
	}

	//cover delete
	function cover_delete($seq){
		$sql="delete from cover where seq ={$seq}";
		$query =$this->db->query($sql);
		return	$query;

	}

	function cover_coordinate_update($data,$seq){
		return $this->db->update('cover', $data, array('seq' => $seq)) ;
	}


	//KI1
	function schedule_update($schedule_seq){
		$sql = "UPDATE tech_schedule_list SET tech_report = 'Y' WHERE seq ={$schedule_seq} AND tech_report != 'Y'";
		$query =$this->db->query($sql);
	}

	function schedule_delete($seq){
		$sql = "UPDATE tech_schedule_list SET tech_report = 'N' WHERE seq = (SELECT schedule_seq FROM tech_doc_basic WHERE seq = {$seq}) AND tech_report != 'N'";
		$query =$this->db->query($sql);
	}

	function user_name_duty($participantArr){
		if(is_array($participantArr)){ //담당SE가 여러 명일 때
			$participant = implode( '|', $participantArr );
			$sql = "SELECT concat(user_name,' ',user_duty) as val FROM user where user_name regexp '$participant'";
			$query =$this->db->query($sql);
			// $result = $query->result_array();
			$result = '';
			foreach ($query->result_array() as $row){
				if($result == ''){
					$result = $row['val'];
				}else{
					$result = $result.', '.$row['val'];
				}
			}
			return	$result;
		}else{ //담당SE가 한 명일 때
			$participant = $participantArr;
			$sql = "SELECT user_duty FROM user where user_name='{$participant}'";
			$query =$this->db->query($sql);
			$result = $query->result_array();
			return	$result;
		}

	}
	//KI2

	//KI1 20210125  일정을 통하지 않은 기지보 작성일 때 일정과 동일한 내용인지 검사하고 일치하는 일정의 seq를 받아온다.
	function unthrough_schedule($data_match){
		if($data_match['writer'] != null){
			$writer = " AND (user_name='{$data_match['writer']}' OR participant LIKE '%{$data_match['writer']}%')";
		}else{
			$writer = "";
		}
		if($data_match['income_time'] != null){
			$start_day = " AND start_day='".$data_match['income_time']."'";
		}else{
			$start_day = "";
		}
		if($data_match['work_name'] != null){
			$work_name = " AND work_name='".$data_match['work_name']."'";
		}else{
			$work_name = "";
		}
		if($data_match['handle'] != null){
			$support_method = " AND support_method='".$data_match['handle']."'";
		}else{
			$support_method = "";
		}
		if($data_match['forcasting_seq'] != null){
			$forcasting_seq = " AND forcasting_seq='".$data_match['forcasting_seq']."'";
		}else{
			$forcasting_seq = "";
		}
		if($data_match['customer'] != null){
			$customer = " AND customer='".$data_match['customer']."'";
		}else{
			$customer = "";
		}
		if($data_match['project_name'] != null){
			$project = " AND project='".$data_match['project_name']."'";
		}else{
			$project = "";
		}

		$sql = "SELECT seq FROM tech_schedule_list WHERE tech_report='N'".$writer.$start_day.$work_name.$support_method.$forcasting_seq.$customer.$project;
		$query =$this->db->query($sql);
		$result = $query->row();
		return $result->seq;
		// $result = $query->result();
		// return $result;
	}
	//KI2 20210125

}

?>
