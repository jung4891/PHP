<?php
header("Content-type: text/html; charset=utf-8");

class STC_Approval extends CI_Model {

	function __construct() {

		parent::__construct();
		$this->user_id = $this->phpsession->get( 'id', 'rms' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->seq = $this->phpsession->get( 'seq', 'stc' );
	}

	//사용자 가져오기
	function select_user($seq){
		$sql = "SELECT * FROM user WHERE seq = '{$seq}'";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}
	//서식함 카테고리 가져오기
	function select_format_category() {
		$sql = "SELECT * FROM format_category ORDER BY idx";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//전자결재 양식 작성 결재정보 저장
	function approval_info_save($data,$mode){
		if($mode == "insert"){
			$this->db->insert('electronic_approval_form',$data);
			return $this->db->insert_id();
		}else{
			$result = $this->db->update('electronic_approval_form',$data,array('seq' => $data['seq']));
			return $result;
		}

	}

	//전자결재 양식 작성 양식내용 저장
	function template_info_save($data,$seq){
		$result = $this->db->update('electronic_approval_form',$data,array('seq' => $seq));
		return $result;
	}

	//조직도 그룹 별로 보기 & 부서변경 페이지에서 memeber 보기
	function groupView($group){
		if(strpos($group,",") === false){
			if($group == "all"){
				$sql = "SELECT * FROM user ORDER BY seq ASC";
			}else{
				$sql = "SELECT * FROM user WHERE user_group='".$group."' ORDER BY seq ASC";
			}
		}else{
			$seq = explode(',',$group);
			$sql = "SELECT * FROM user WHERE seq ='{$seq[1]}' ";

			for($i=2; $i<count($seq); $i++){
				$sql .= "or seq = '{$seq[$i]}'" ;
			}

		}

		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//그룹 전체 가져오기
	function group(){
		$sql = "SELECT * FROM user_group ";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}


	//상위그룹 가져오기
	function parentGroup(){
		$sql = "SELECT * FROM user_group WHERE groupName=parentGroupName ORDER BY seq ASC";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//상위 그룹에 맞는 하위그룹 가져오기
	function childGroup($parentGroup){
		$sql = "SELECT * FROM user_group WHERE parentGroupName='{$parentGroup}' and groupName<>'{$parentGroup}'";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//전자결재 폼 list
	function approval_form_list($filter,$mode){
		if($filter == ""){
			$sql = "SELECT * FROM electronic_approval_form";
			if($mode != "admin"){
				$sql .= " WHERE template_use = 'Y' ORDER BY template_sort_seq";
			}else{
				$sql .= " ORDER BY seq DESC";
			}
		}else{
			$searchString ="";
			$filter =explode(',',$filter);
			if($filter[0] != ""){
				$searchString .= " AND template_category = '{$filter[0]}'";
			}
			if($filter[1] != ""){
				$searchString .= " AND template_name LIKE '%{$filter[1]}%' ";
			}
			if(trim($searchString)!=""){
				$searchString = ltrim($searchString,' AND');
				$searchString = "WHERE ".$searchString;
			}
			$sql = "SELECT * FROM electronic_approval_form {$searchString} ";
			if($mode != "admin"){
				if(trim($searchString) == ""){
					$sql .= " WHERE template_use = 'Y' ORDER BY template_sort_seq ";
				}else{
					$sql .= " AND template_use = 'Y' ORDER BY template_sort_seq ";
				}
			}else{
				$sql .= " ORDER BY seq DESC";
			}
		}
		$query = $this->db->query( $sql );
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//전자결재 폼 보여줘
	function approval_form_view($seq){
		$sql = "SELECT * FROM electronic_approval_form WHERE seq={$seq}";
		$query = $this->db->query( $sql );
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	//기안문 저장!
	function electronic_approval_doc_insert($data,$mode){
		if($mode == 1){
			//문서번호 만들기 (같은 그룹 글에서 제일 큰값찾아서 +1)
			$sql = "SELECT max(doc_num) AS max_doc_num FROM electronic_approval_doc WHERE writer_group = '{$data['writer_group']}'" ;
			$query = $this->db->query($sql);
			$max_doc_num = $query->row_array();
			$max_doc_num = $max_doc_num['max_doc_num'];
			if($max_doc_num == null || $max_doc_num == ""){
				$num = sprintf('%010d',1);
			}else{
				$num = sprintf('%010d',$max_doc_num+1);
			}
			$data['doc_num']= $num;
			$result = $this->db->insert('electronic_approval_doc',$data);
			return $this->db->insert_id();
		}else{
			$sql = "DELETE FROM electronic_approval_line WHERE approval_doc_seq = {$data['seq']} "; //결재라인 삭제
			$this->db->query( $sql );
			$result = $this->db->update('electronic_approval_doc',$data,array('seq' => $data['seq']));
			return $result;
		}
	}

	//기안문 뷰
	function approval_doc_view($seq){
		$sql = "SELECT ead.*,eaf.template_name,eaf.template_category,eaf.editor_use,u.user_duty
		FROM electronic_approval_doc AS ead
		left JOIN electronic_approval_form eaf
		ON ead.approval_form_seq = eaf.seq
		join user as u
		on ead.writer_id = u.user_id
		where ead.seq = {$seq}";
		$query = $this->db->query( $sql );
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	//결재요청함 / 임시저장함 리스트
	function approval_doc_list($type,$searchkeyword=""){
		$searchstring='';

		if ($searchkeyword != "") {
			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //양식명
				$searchstring .= " AND template_name LIKE '%{$searchkeyword[0]}%'";
			}
			if(trim($searchkeyword[1])!=''){ //문서제목
				$searchstring .= " AND approval_doc_name LIKE '%{$searchkeyword[1]}%'";
			}
			if(trim($searchkeyword[2])!=''){
				if($type == 'attachment') { // 기안자
					$searchstring .= " AND writer_name = '{$searchkeyword[2]}'";
				} else { //문서상태
					$searchstring .= " AND approval_doc_status = '{$searchkeyword[2]}'";
				}
			}
			if(trim($searchkeyword[3])!=''){//문서내용
				$searchstring .= " AND contents_html LIKE '%{$searchkeyword[3]}%'";
			}
			if(trim($searchkeyword[4])!=''){ //기안일
				$searchstring .= " AND write_date >= '{$searchkeyword[4]}'";
			}
			if(trim($searchkeyword[5])!=''){//기안일
				$searchstring .= " AND write_date <= '{$searchkeyword[5]}'";
			}
			if(trim($searchkeyword[6])!=''){ //완료일
				$searchstring .= " AND completion_date >= '{$searchkeyword[6]}'";
			}
			if(trim($searchkeyword[7])!=''){//완료일
				$searchstring .= " AND completion_date <= '{$searchkeyword[7]}'";
			}
		}

		if($type == "request"){ //결재요청함
			$sql = "select t.* from (SELECT ead.*,eaf.template_category,
			case
			when ead.approval_form_seq = 'annual' then '연차신청서'
			when ead.approval_form_seq = 'attendance' then '근태조정계'
			else eaf.template_name end as template_name FROM electronic_approval_doc AS  ead
			left JOIN electronic_approval_form AS eaf
			ON ead.approval_form_seq = eaf.seq) as t where approval_doc_status != '005' and writer_id = '{$this->id}' {$searchstring}";
		}else if ($type == "temporary"){ //임시저장함
			$sql = "select t.* from (SELECT ead.*,eaf.template_category,
			case
			when ead.approval_form_seq = 'annual' then '연차신청서'
			when ead.approval_form_seq = 'attendance' then '근태조정계'
			else eaf.template_name end as template_name FROM electronic_approval_doc AS  ead
			left JOIN electronic_approval_form AS eaf
			ON ead.approval_form_seq = eaf.seq) as t where approval_doc_status = '005' and writer_id = '{$this->id}' {$searchstring}";
		}else if ($type == "attachment"){//기결재 첨부
			if($this->pGroupName == '영업본부') {
				$authority = "AND ((writer_id = '{$this->id}' || referrer LIKE '%{$this->name}%' || user_seq = '{$this->seq}') || (select category_name from format_category where seq = t.template_category) = '영업')";
			} else {
				$authority = "AND (writer_id = '{$this->id}' || referrer LIKE '%{$this->name}%' || user_seq = '{$this->seq}')";
			}

			$sql = "select t.* from (SELECT ead.*,eaf.template_category,
			case
			when ead.approval_form_seq = 'annual' then '연차신청서'
			when ead.approval_form_seq = 'attendance' then '근태조정계'
			else eaf.template_name end as template_name ,eal.user_seq FROM electronic_approval_doc AS  ead
			left JOIN electronic_approval_form AS eaf
			ON ead.approval_form_seq = eaf.seq
			left JOIN (SELECT * from electronic_approval_line WHERE user_seq= '{$this->seq}')  AS eal
			ON ead.seq = eal.approval_doc_seq) as t
			where approval_doc_status = '002' {$authority} {$searchstring}";
		}
		else{
			$sql = "select t.* from (SELECT ead.*,eaf.template_category,
			case
			when ead.approval_form_seq = 'annual' then '연차신청서'
			when ead.approval_form_seq = 'attendance' then '근태조정계'
			else eaf.template_name end as template_name FROM electronic_approval_doc AS  ead
			left JOIN electronic_approval_form AS eaf
			ON ead.approval_form_seq = eaf.seq) as t where approval_doc_status = '{$type}' and writer_id = '{$this->id}' {$searchstring}";
		}
		if ($type == 'attachment') {
			$sql .= ' ORDER BY completion_date DESC, seq DESC';
		} else {
			$sql .= " order by seq desc";
		}

		$query = $this->db->query( $sql );
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	function electronic_approval_line_insert($doc_seq,$user_seq,$step,$approval_type){
		$sql = "select approval_doc_status from electronic_approval_doc where seq = {$doc_seq} ";
		$query = $this->db->query( $sql );
		if ($query->num_rows() > 0) {
			$approval_doc = $query->row_array();
		}
		if($step == '0'){
			if($approval_doc['approval_doc_status'] != "004"){
				$sql = "INSERT INTO electronic_approval_line (approval_doc_seq,user_seq,approval_type,assignment_date,step) VALUES('{$doc_seq}','{$user_seq}','{$approval_type}','".date("Y-m-d H:i:s")."','{$step}')";
			}else{
				$sql = "INSERT INTO electronic_approval_line (approval_doc_seq,user_seq,approval_type,step) VALUES('{$doc_seq}','{$user_seq}','{$approval_type}','{$step}')";
			}
		}else{
			$sql = "INSERT INTO electronic_approval_line (approval_doc_seq,user_seq,approval_type,step) VALUES('{$doc_seq}','{$user_seq}','{$approval_type}','{$step}')";
		}

		return $this->db->query( $sql );
	}

	// 읽음 처리
	function read_doc($seq,$type,$user_seq) {
		$read_seq = $type.'_'.$user_seq;

		$read_chk_sql = "SELECT COUNT(*) as cnt from electronic_approval_doc where seq = {$seq} and read_seq like '%{$read_seq}%'";
		$query = $this->db->query($read_chk_sql);
		$read_chk = $query->result_array();

		if ($read_chk[0]['cnt'] == 0) {
			$sql = "UPDATE electronic_approval_doc set read_seq = concat(ifnull(read_seq, ''), ',', '{$read_seq}') where seq = {$seq}";
			// echo $sql;
			$result = $this->db->query($sql);
		}
	}

	// 전체 읽음 처리
	function all_read($type, $user_seq) {
		$read_seq = $type.'_'.$user_seq;

		$sql = "UPDATE electronic_approval_doc SET read_seq = concat(ifnull(read_seq, ''), ',', '{$read_seq}') where read_seq not like '%{$read_seq}%' or read_seq is null";

		return $this->db->query($sql);
	}

	function approval_list($type,$searchkeyword="",$user_seq='',$mode='list'){
		$read_seq = substr($type,0,1).'_'.$user_seq;
		$searchstring='';

		$authority = "(ead.referrer like '%".$this->name."%') and ead.approval_doc_security !='Y'";
		if($this->pGroupName == '영업본부') {
			$authority = "(((select category_name from format_category where seq = eaf.template_category) = '영업' and ead.approval_doc_status = '002') || ead.referrer like '%".$this->name."%') and ead.approval_doc_security !='Y'";
		}

		if ($searchkeyword != "") {
			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //문서상태
				if(trim($searchkeyword[0]=='006')) {
					$searchstring .= " AND ead.approval_doc_hold = 'Y'";
				} else {
					$searchstring .= " AND ead.approval_doc_status = '{$searchkeyword[0]}'";
				}
			}

			if(trim($searchkeyword[1])!=''){ //양식명
				$searchstring .= " and ( ";
				$searchstring2 = "";
				$annual = "차신청서";
				$annual_y = false;
				$attendance = "근태조정";
				$attendance_y = false;

				for($i=0; $i < mb_strlen($annual)-1; $i++){
					if(strpos(trim($searchkeyword[1]),mb_substr($annual,$i,1)) !== false){
						$annual_y = true;
					}
				}

				for($i=0; $i < mb_strlen($attendance); $i++){
					if(strpos(trim($searchkeyword[1]),mb_substr($attendance,$i,1)) !== false){
						$attendance_y = true;
					}
				}

				if($annual_y){
					$searchstring2 .="OR ead.approval_form_seq = 'annual' ";
				}
				if($attendance_y){
					$searchstring2 .="OR ead.approval_form_seq = 'attendance' ";
				}
				$searchstring2 .= "OR eaf.template_name LIKE '%{$searchkeyword[1]}%' ";
				$searchstring2 = ltrim($searchstring2, "OR");
				$searchstring .= $searchstring2." ) " ;
			}
			if(trim($searchkeyword[2])!=''){ //기안자
				$searchstring .= " AND ead.writer_name LIKE '%{$searchkeyword[2]}%'";
			}
			if(trim($searchkeyword[4])!=''){ //기안일, 완료일
				$searchstring .= " AND date_format(ead.".$searchkeyword[3].", '%Y-%m-%d') >= '{$searchkeyword[4]}'";
			}
			if(trim($searchkeyword[5])!=''){//기안일, 완료일
				$searchstring .= " AND date_format(ead.".$searchkeyword[3].", '%Y-%m-%d') <= '{$searchkeyword[5]}'";
			}
			if(trim($searchkeyword[7])!=''){
				if($searchkeyword[6] == 'doc_num') {
					$searchstring .= " AND concat(ead.writer_group, '-',ead.".$searchkeyword[6].") LIKE '%{$searchkeyword[7]}%'";
				} else {
					$searchstring .= " AND ead.".$searchkeyword[6]." LIKE '%{$searchkeyword[7]}%'";
				}
			}
// date_format(datetime, '%Y-%m-%d')

			// if(trim($searchkeyword[5])!=''){ //완료일
			// 	$searchstring .= " AND ead.completion_date >= '{$searchkeyword[5]}'";
			// }
			// if(trim($searchkeyword[6])!=''){ //완료일
			// 	$searchstring .= " AND ead.completion_date <= '{$searchkeyword[6]}'";
			// }
			// if(trim($searchkeyword[1])!=''){ //서식함
			// 	if(trim($searchkeyword[1]=='annual')) {
			// 		$searchstring .= " AND ead.approval_form_seq = 'annual'";
			// 	} else {
			// 		$searchstring .= " AND eaf.template_category = '{$searchkeyword[1]}'";
			// 	}
			// }
			// if(trim($searchkeyword[0])!=''){ //기안자
			// 	$searchstring .= " AND ead.writer_name LIKE '%{$searchkeyword[0]}%'";
			// }
			// if(trim($searchkeyword[2])!=''){ //문서제목
			// 	$searchstring .= " AND ead.approval_doc_name LIKE '%{$searchkeyword[2]}%'";
			// }
			// if(trim($searchkeyword[3])!=''){ //문서번호
			// 	$searchstring .= " AND concat(ead.writer_group,'-',ead.doc_num) LIKE '%{$searchkeyword[3]}%'";
			// }
			// if(trim($searchkeyword[9])!=''){ //기안부서
			// 	$searchstring .= " AND ead.writer_group LIKE '%{$searchkeyword[9]}%'";
			// }
			// if(trim($searchkeyword[11])!=''){ //문서내용
			// 	$searchstring .= " AND ead.contents_html LIKE '%{$searchkeyword[11]}%'";
			// }
		}
		if ($mode == 'no_read_cnt') {
			$searchstring = '';
		}

		if($type == "standby"){
			$target = "FROM
							(
							SELECT eal.approval_doc_seq, eal.user_seq, eal.approval_type, eal.approval_status, eal.assignment_date, eal.check_date, eal.approval_date, u.user_id,u.user_name,u.user_group,ead.*,eaf.template_category, CASE WHEN ead.approval_form_seq = 'annual' THEN '연차신청서' WHEN ead.approval_form_seq = 'attendance' THEN '근태조정계' ELSE eaf.template_name END AS template_name
							FROM electronic_approval_line AS eal
							JOIN user u ON eal.user_seq = u.seq
							JOIN electronic_approval_doc AS ead ON ead.seq = eal.approval_doc_seq
							LEFT JOIN electronic_approval_form AS eaf ON eaf.seq = ead.approval_form_seq
							WHERE ead.approval_doc_status = '001' AND eal.assignment_date != '' AND ead.approval_doc_security !='Y' && eal.approval_date IS NULL AND u.user_id ='{$this->id}' {$searchstring}
							ORDER BY ead.seq DESC) t
							LEFT JOIN (
							SELECT COUNT(seq) AS comment_cnt, approval_doc_seq
							FROM electronic_approval_comment
							GROUP BY approval_doc_seq) c ON t.seq = c.approval_doc_seq";
			$sql = "SELECT t.*, CASE WHEN c.comment_cnt IS NULL THEN 0 ELSE c.comment_cnt END AS comment_cnt ".$target.' order by t.seq desc';
			$sql2 = "SELECT COUNT(*) as cnt ".$target." where t.read_seq not like '%{$read_seq}%' OR t.read_seq IS null";

    }else if($type== "progress"){
			$target = "FROM
							(
							SELECT ead.*,al.*,eaf.template_category, CASE WHEN ead.approval_form_seq = 'annual' THEN '연차신청서' WHEN ead.approval_form_seq = 'attendance' THEN '근태조정계' ELSE eaf.template_name END AS template_name
							FROM electronic_approval_doc AS ead
							LEFT JOIN (
							SELECT eal.approval_doc_seq,eal.user_seq,eal.approval_type,eal.approval_status,eal.assignment_date,eal.check_date,eal.approval_date,eal.approval_opinion,eal.details,eal.step,u.user_id,u.user_name,ead.mandatary AS mandatary,us.user_name AS mandatary_name,us.user_duty AS mandatary_duty,us.user_group AS mandatary_group
							FROM electronic_approval_line AS eal
							JOIN user AS u ON eal.user_seq = u.seq
							LEFT JOIN electronic_approval_delegation AS ead ON ead.seq= eal.delegation_seq
							LEFT JOIN user AS us ON ead.mandatary_seq = us.seq) AS al ON al.approval_doc_seq = ead.seq
							LEFT JOIN electronic_approval_form AS eaf ON eaf.seq = ead.approval_form_seq
							WHERE ((al.user_name ='".$this->name."' and al.approval_date is not null) or (al.mandatary like '%{$this->name}%')
							OR (ead.writer_name ='".$this->name."')) and ead.approval_doc_status = '001' and ead.approval_doc_security !='Y' {$searchstring} GROUP BY ead.seq order by ead.seq desc) t
							LEFT JOIN (
							SELECT COUNT(seq) AS comment_cnt, approval_doc_seq
							FROM electronic_approval_comment
							GROUP BY approval_doc_seq) c ON t.seq = c.approval_doc_seq";
			$sql = "SELECT t.*, CASE WHEN c.comment_cnt IS NULL THEN 0 ELSE c.comment_cnt END AS comment_cnt ".$target.' order by t.seq desc';
			$sql2 = "SELECT COUNT(*) as cnt ".$target." where t.read_seq not like '%{$read_seq}%' OR t.read_seq IS null";

    }else if($type == "completion"){
			$target = "FROM
							(
							SELECT ead.*,al.*,eaf.template_category, CASE WHEN ead.approval_form_seq = 'annual' THEN '연차신청서' WHEN ead.approval_form_seq = 'attendance' THEN '근태조정계' ELSE eaf.template_name END AS template_name
							FROM electronic_approval_doc AS ead
							LEFT JOIN (
							SELECT eal.approval_doc_seq,eal.user_seq,eal.approval_type,eal.approval_status,eal.assignment_date,eal.check_date,eal.approval_date,eal.approval_opinion,eal.details,eal.step,u.user_id,u.user_name,ead.mandatary AS mandatary,us.user_name AS mandatary_name,us.user_duty AS mandatary_duty,us.user_group AS mandatary_group
							FROM electronic_approval_line AS eal
							JOIN user AS u ON eal.user_seq = u.seq
							LEFT JOIN electronic_approval_delegation AS ead ON ead.seq= eal.delegation_seq
							LEFT JOIN user AS us ON ead.mandatary_seq = us.seq) AS al ON al.approval_doc_seq = ead.seq
							LEFT JOIN electronic_approval_form AS eaf ON eaf.seq = ead.approval_form_seq
							WHERE (al.user_name ='".$this->name."' OR al.mandatary_name = '{$this->name}' OR ead.writer_name ='".$this->name."') and ead.approval_doc_status = '002' and ead.approval_doc_security !='Y' and ead.completion_date IS not NULL {$searchstring} GROUP BY ead.seq order by ead.completion_date desc) t
							LEFT JOIN (
							SELECT COUNT(seq) AS comment_cnt, approval_doc_seq
							FROM electronic_approval_comment
							GROUP BY approval_doc_seq) c ON t.seq = c.approval_doc_seq";
			$sql = "SELECT t.*, CASE WHEN c.comment_cnt IS NULL THEN 0 ELSE c.comment_cnt END AS comment_cnt ".$target.' order by t.completion_date desc';
			$sql2 = "SELECT COUNT(*) as cnt ".$target." where t.read_seq not like '%{$read_seq}%' OR t.read_seq IS null";

    }else if($type == "back"){
		$target = "FROM
						(
						SELECT ead.*,al.*,eaf.template_category, CASE WHEN ead.approval_form_seq = 'annual' THEN '연차신청서' WHEN ead.approval_form_seq = 'attendance' THEN '근태조정계' ELSE eaf.template_name END AS template_name
						FROM electronic_approval_doc AS ead
						LEFT JOIN (
						SELECT eal.approval_doc_seq,eal.user_seq,eal.approval_type,eal.approval_status,eal.assignment_date,eal.check_date,eal.approval_date,eal.approval_opinion,eal.details,eal.step,u.user_id,u.user_name,ead.mandatary AS mandatary,us.user_name AS mandatary_name,us.user_duty AS mandatary_duty,us.user_group AS mandatary_group
						FROM electronic_approval_line AS eal
						JOIN user AS u ON eal.user_seq = u.seq
						LEFT JOIN electronic_approval_delegation AS ead ON ead.seq= eal.delegation_seq
						LEFT JOIN user AS us ON ead.mandatary_seq = us.seq) AS al ON al.approval_doc_seq = ead.seq
						LEFT JOIN electronic_approval_form AS eaf ON eaf.seq = ead.approval_form_seq
						WHERE (al.user_name ='".$this->name."' OR al.mandatary_name = '{$this->name}' OR ead.writer_name ='".$this->name."') and ead.approval_doc_status = '003' and ead.approval_doc_security !='Y' {$searchstring} GROUP BY ead.seq order by ead.completion_date desc) t
						LEFT JOIN (
						SELECT COUNT(seq) AS comment_cnt, approval_doc_seq
						FROM electronic_approval_comment
						GROUP BY approval_doc_seq) c ON t.seq = c.approval_doc_seq";
			$sql = "SELECT t.*, CASE WHEN c.comment_cnt IS NULL THEN 0 ELSE c.comment_cnt END AS comment_cnt ".$target.' order by t.completion_date desc';
			$sql2 = "SELECT COUNT(*) as cnt ".$target." where t.read_seq not like '%{$read_seq}%' OR t.read_seq IS null";

    }else if($type == "reference"){
		$target = "FROM
						(
						SELECT ead.*,al.*,eaf.template_category, CASE WHEN ead.approval_form_seq = 'annual' THEN '연차신청서' WHEN ead.approval_form_seq = 'attendance' THEN '근태조정계' ELSE eaf.template_name END AS template_name
						FROM electronic_approval_doc AS ead
						LEFT JOIN (
						SELECT eal.approval_doc_seq,eal.user_seq,eal.approval_type,eal.approval_status,eal.assignment_date,eal.check_date,eal.approval_date,eal.approval_opinion,eal.details,eal.step,u.user_id,u.user_name,ead.mandatary AS mandatary,us.user_name AS mandatary_name,us.user_duty AS mandatary_duty,us.user_group AS mandatary_group
						FROM electronic_approval_line AS eal
						JOIN user AS u ON eal.user_seq = u.seq
						LEFT JOIN electronic_approval_delegation AS ead ON ead.seq= eal.delegation_seq
						LEFT JOIN user AS us ON ead.mandatary_seq = us.seq) AS al ON al.approval_doc_seq = ead.seq
						LEFT JOIN electronic_approval_form AS eaf ON eaf.seq = ead.approval_form_seq
						WHERE {$authority} {$searchstring} GROUP BY ead.seq order by ead.completion_date desc) t
						LEFT JOIN (
						SELECT COUNT(seq) AS comment_cnt, approval_doc_seq
						FROM electronic_approval_comment
						GROUP BY approval_doc_seq) c ON t.seq = c.approval_doc_seq";
				$sql = "SELECT t.*, CASE WHEN c.comment_cnt IS NULL THEN 0 ELSE c.comment_cnt END AS comment_cnt ".$target.' order by t.completion_date desc';
				$sql2 = "SELECT COUNT(*) as cnt ".$target." where t.read_seq not like '%{$read_seq}%' OR t.read_seq IS null";

		}else if ($type == "admin"){
			$target = "FROM
							(
							SELECT ead.*,al.*,eaf.template_category, CASE WHEN ead.approval_form_seq = 'annual' THEN '연차신청서' WHEN ead.approval_form_seq = 'attendance' THEN '근태조정계' ELSE eaf.template_name END AS template_name
							FROM electronic_approval_doc AS ead
							LEFT JOIN (
							SELECT eal.approval_doc_seq,eal.user_seq,eal.approval_type,eal.approval_status,eal.assignment_date,eal.check_date,eal.approval_date,eal.approval_opinion,eal.details,eal.step,u.user_id,u.user_name,ead.mandatary AS mandatary,us.user_name AS mandatary_name,us.user_duty AS mandatary_duty,us.user_group AS mandatary_group
							FROM electronic_approval_line AS eal
							JOIN user AS u ON eal.user_seq = u.seq
							LEFT JOIN electronic_approval_delegation AS ead ON ead.seq= eal.delegation_seq
							LEFT JOIN user AS us ON ead.mandatary_seq = us.seq) AS al ON al.approval_doc_seq = ead.seq
							LEFT JOIN electronic_approval_form AS eaf ON eaf.seq = ead.approval_form_seq
							WHERE ead.approval_doc_status != '005' {$searchstring}
							GROUP BY ead.seq
							ORDER BY ead.seq DESC) t
							LEFT JOIN (
							SELECT COUNT(seq) AS comment_cnt, approval_doc_seq
							FROM electronic_approval_comment
							GROUP BY approval_doc_seq) c ON t.seq = c.approval_doc_seq";
			$sql = "SELECT t.*, CASE WHEN c.comment_cnt IS NULL THEN 0 ELSE c.comment_cnt END AS comment_cnt ".$target.' order by t.seq desc';
			$sql2 = "SELECT COUNT(*) as cnt ".$target." where t.read_seq not like '%{$read_seq}%' OR t.read_seq IS null";
			// echo $sql;
		}else if ($type == "wage"){
			$target = "FROM
							(
							SELECT ead.*,al.*,eaf.template_category, CASE WHEN ead.approval_form_seq = 'annual' THEN '연차신청서' WHEN ead.approval_form_seq = 'attendance' THEN '근태조정계' ELSE eaf.template_name END AS template_name
							FROM electronic_approval_doc AS ead
							LEFT JOIN (
							SELECT eal.approval_doc_seq,eal.user_seq,eal.approval_type,eal.approval_status,eal.assignment_date,eal.check_date,eal.approval_date,eal.approval_opinion,eal.details,eal.step,u.user_id,u.user_name,ead.mandatary AS mandatary,us.user_name AS mandatary_name,us.user_duty AS mandatary_duty,us.user_group AS mandatary_group
							FROM electronic_approval_line AS eal
							JOIN user AS u ON eal.user_seq = u.seq
							LEFT JOIN electronic_approval_delegation AS ead ON ead.seq= eal.delegation_seq
							LEFT JOIN user AS us ON ead.mandatary_seq = us.seq) AS al ON al.approval_doc_seq = ead.seq
							LEFT JOIN electronic_approval_form AS eaf ON eaf.seq = ead.approval_form_seq
							WHERE (al.user_name ='".$this->name."' OR al.mandatary_name = '{$this->name}' OR ead.writer_name ='".$this->name."') and ead.approval_doc_security !='Y' and ead.approval_form_seq = 71 {$searchstring} GROUP BY ead.seq order by ead.completion_date desc) t
							LEFT JOIN (
							SELECT COUNT(seq) AS comment_cnt, approval_doc_seq
							FROM electronic_approval_comment
							GROUP BY approval_doc_seq) c ON t.seq = c.approval_doc_seq";
			$sql = "SELECT t.*, CASE WHEN c.comment_cnt IS NULL THEN 0 ELSE c.comment_cnt END AS comment_cnt ".$target.' order by t.seq desc';
			$sql2 = "SELECT COUNT(*) as cnt ".$target." where t.read_seq not like '%{$read_seq}%' OR t.read_seq IS null";
			// echo $sql;
		}
// echo $type.'::'.$sql2.'<br><br>';
// echo $sql.';<br><br>';
		if($mode == 'list') {
			$query = $this->db->query( $sql );
		} else {
			$query = $this->db->query( $sql2 );
		}
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//현재 결재자 라인
	function cur_approval_line($seq){
		// $sql = "select eal.*,u.user_id,u.user_name,u.user_group from electronic_approval_line as eal join user as u on eal.user_seq=u.seq where approval_doc_seq = {$seq} and u.user_name ='{$this->name}'";
		$sql = "SELECT eal.*,u.user_id,u.user_name,u.user_group FROM electronic_approval_line AS eal JOIN user AS u ON eal.user_seq = u.seq WHERE approval_doc_seq = {$seq} AND assignment_date IS NOT NULL AND approval_date IS NULL ORDER BY step ASC LIMIT 1";
		$query = $this->db->query( $sql );
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	//다음 스텝의 결재자
	function next_approval_line($seq,$cur_approval_seq){
		$sql = "SELECT eal.*,u.user_id,u.user_name,u.user_group FROM electronic_approval_line AS eal JOIN user AS u ON eal.user_seq=u.seq WHERE eal.approval_doc_seq = {$seq} AND eal.step = (SELECT eal.step+1 AS step FROM electronic_approval_line AS eal JOIN user AS u ON eal.user_seq=u.seq WHERE eal.seq={$cur_approval_seq}) ";
		$query = $this->db->query( $sql );
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

    //해당기안문의 결재라인 다 가져와
	function approval_line($seq){
		// $sql = "select eal.*,u.user_id,u.user_name,u.user_group,u.user_duty from electronic_approval_line as eal join user as u on eal.user_seq=u.seq where eal.approval_doc_seq={$seq}";
		$sql = "SELECT eal.*,u.user_id,u.user_name,u.user_group,u.user_duty,u.user_email,ead.mandatary_seq,ead.mandatary,us.user_group AS mandatary_group
			from electronic_approval_line as eal
			join user as u on eal.user_seq=u.seq
			left join electronic_approval_delegation AS ead
			ON ead.seq= eal.delegation_seq
			left join user AS us
			ON ead.mandatary_seq = us.seq
			where eal.approval_doc_seq = {$seq} order by eal.step";
		$query = $this->db->query( $sql );
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//결재 저장 (승인인지 반려인지 결재 취소인지 등등)
	function approval_save($data,$next_seq){
		$result = $this->db->update('electronic_approval_line',$data,array('seq' => $data['seq']));
		if($data['approval_status'] == ""){//결재취소일때
			$sql2 = "UPDATE electronic_approval_doc SET approval_doc_status = '001' WHERE seq = {$data['approval_doc_seq']}";
			$result = $this->db->query( $sql2 );
		}

		if($next_seq != ""){
			if($data['approval_status'] == "Y"){//결재
				$sql = "UPDATE electronic_approval_line SET assignment_date = '".date("Y-m-d H:i:s")."' WHERE seq = {$next_seq}";
				$result = $this->db->query( $sql );
			}else if($data['approval_status'] == ""){//결재취소할때
				$sql = "UPDATE electronic_approval_line SET assignment_date = null,check_date = null WHERE seq = {$next_seq}";
				$this->db->query( $sql );
			}
		}
		return $result;
	}

	// 전자결재 기안문 수정
	function electronic_approval_doc_update($data){
		if(isset($data['approval_doc_status'])){
			if($data['approval_doc_status']== "004"){
				$sql = "UPDATE electronic_approval_line SET approval_status = null,assignment_date= null,check_date=null ,approval_date = null,approval_opinion =null, delegation_seq =null WHERE approval_doc_seq = {$data['seq']}";
				$result = $this->db->query( $sql );
			}
		}
		$result = $this->db->update('electronic_approval_doc',$data,array('seq' => $data['seq']));
		return $result;
	}

	// // 결재라인 삭제
	// function electronic_approval_line_delete($seq){
	// 	$sql = "delete from electronic_approval_line where approval_doc_seq = '{$seq}'";
	// 	$result = $this->db->query( $sql );
	// 	return $result;
	// }

	function electronic_approval_hold_insert($data,$mode){
		if($mode == "1"){//insert
			$result = $this->db->insert('electronic_approval_hold',$data);
		}else{//update
			$sql = "UPDATE electronic_approval_hold SET
			hold_status = '{$data['hold_status']}',
			processing_date = '{$data['processing_date']}'
			WHERE approval_doc_seq = {$data['approval_doc_seq']} ORDER BY seq DESC LIMIT 1";
			$result = $this->db->query( $sql );
		}

		return $result;
	}


	function approval_hold_select($seq){
		$sql = "SELECT * FROM electronic_approval_hold WHERE approval_doc_seq= {$seq} ";
		$query = $this->db->query( $sql );
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	function electronic_approval_line_update($data){
		$result = $this->db->update('electronic_approval_line',$data,array('seq' => $data['seq']));
		return $result;
	}

	//사용자 결재선 저장
	function user_approval_line_save($data,$type){
		if($type == 1){ //insert
			return  $this->db->insert('user_approval_line',$data);
		}else if ($type == 2){
			return  $this->db->update('user_approval_line',$data,array('seq' => $data['seq']));
		}else if ($type == 3){
			$sql = "DELETE FROM user_approval_line WHERE seq IN ({$data})";
			return $this->db->query($sql);
		}
	}

	//사용자 결재선 조회
	function user_approval_line_select($id){
		$sql = "SELECT * FROM user_approval_line WHERE user_id = '{$id}' OR user_id='admin' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//seq로 결재선 조회
	function approval_line_select($seq){
		$sql = "SELECT * FROM electronic_approval_line WHERE seq = '{$seq}' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	// //사용자 가져오기
	// function select_user($seq){
	// 	$sql = "select * from user where seq = '{$seq}'";
	// 	$query = $this->db->query($sql);
	// 	if ($query->num_rows() <= 0) {
	// 		return false;
	// 	} else {
	// 		return $query->row_array();
	// 	}
	// }

	//위임저장
	function delegation_save($data,$type){
		if($type == 1){ //위임저장
			return $this->db->insert('electronic_approval_delegation',$data);
		}else{//위임 설정해제
			$sql = "UPDATE electronic_approval_delegation SET status='N' WHERE seq IN ($data)";
			return $this->db->query($sql);
		}
	}

	//위임 리스트
	function electronic_approval_delegation_list(){
		$sql = "SELECT * FROM electronic_approval_delegation WHERE write_id = '{$this->id}' ORDER BY seq DESC";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//수임받은 기안문 리스트~
	function delegation_list(){
		$sql = 	"SELECT eal.*,u.user_id,u.user_name,u.user_group,ead.*,eaf.template_category,eaf.template_name FROM electronic_approval_line as eal JOIN user u
		 	ON eal.user_seq = u.seq
		 	JOIN electronic_approval_doc AS ead
		 	ON ead.seq = eal.approval_doc_seq
		 	LEFT JOIN electronic_approval_form AS eaf
		 	ON eaf.seq = ead.approval_form_seq
		 	WHERE ead.approval_doc_status = '001' and eal.assignment_date != '' && eal.approval_date IS NULL
			AND u.user_id in (SELECT ead.write_id from electronic_approval_delegation AS ead LEFT JOIN user AS u ON ead.mandatary_seq = u.seq WHERE ead.status='Y' and u.user_id ='{$this->id}' AND (start_date  <= CURDATE() AND end_date >= CURDATE()))";

		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//위임여부
	function mandatary_whether($approver_id){
		$sql = "SELECT ead.*,u.user_id,user_duty from electronic_approval_delegation AS ead LEFT JOIN user AS u
		ON ead.mandatary_seq = u.seq
		WHERE ead.write_id ='{$approver_id}' AND (start_date <= CURDATE() AND end_date >= CURDATE()) AND ead.status = 'Y'
		AND u.user_id ='{$this->id}'";

		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	//위임상세보기
	function delegation_detail_view($seq){
		$sql = "SELECT * from electronic_approval_line WHERE delegation_seq = {$seq}";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$approval_doc = $query->result_array();

			$sql2 = "select ead.*,eaf.template_category from electronic_approval_doc AS ead JOIN electronic_approval_form AS eaf ON ead.approval_form_seq = eaf.seq
			 where ead.seq in (";
			for($i=0; $i<count($approval_doc); $i++){
				if($i == 0){
					$sql2 .= $approval_doc[$i]['approval_doc_seq'];
				}else{
					$sql2 .= ','.$approval_doc[$i]['approval_doc_seq'];
				}

			}
			$sql2 .= ")";

			$query2 = $this->db->query($sql2);
			if ($query2->num_rows() <= 0) {
				return false;
			} else {
				return $query2->result_array();
			}
		}else{
			return false;
		}
	}

	//개인보관함 추가/수정/삭제
	function storageSave($data,$type){
		if($type == 1){ // 추가
			$result = $this->db->insert('electronic_approval_personal_storage',$data);
		}else if($type == 2){ // 수정
			$result = $this->db->update('electronic_approval_personal_storage',$data,array('seq' => $data['seq']));
		}else if($type == 3){
			$sql = "DELETE FROM electronic_approval_personal_storage WHERE seq = {$data} OR parent_id={$data}";
			$result = $this->db->query($sql);
		}else if($type == 4){
			$sql = "SELECT * FROM electronic_approval_personal_storage WHERE seq={$data['seq']} AND save_doc_seq LIKE '%{$data['save_doc_seq']}%'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				$result = "duplicate";
			} else {
				$sql = "UPDATE electronic_approval_personal_storage SET save_doc_seq =concat(ifnull(save_doc_seq,''),'{$data['save_doc_seq']}'),update_date='{$data['update_date']}' WHERE seq = {$data['seq']}";
				$result = $this->db->query($sql);
			}
		}
		return $result;
	}

	//본인 개인보관함 가져오기
	function electronic_approval_personal_storage_select($seq){
		// $sql = "SELECT * ,(SELECT COUNT(*)  FROM electronic_approval_personal_storage WHERE parent_id = seq ) AS cnt FROM electronic_approval_personal_storage WHERE user_id ='{$this->id}'";
		if($seq == "all"){
			$sql = "SELECT eaps.* ,(SELECT COUNT(*)  FROM electronic_approval_personal_storage WHERE parent_id = eaps.seq ) AS cnt FROM electronic_approval_personal_storage AS eaps WHERE eaps.user_id ='{$this->id}'";
		}else{
			$sql = "SELECT eaps.* ,(SELECT COUNT(*)  FROM electronic_approval_personal_storage WHERE parent_id = eaps.seq ) AS cnt FROM electronic_approval_personal_storage AS eaps WHERE eaps.user_id ='{$this->id}' and eaps.parent_id = {$seq}";
		}
		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//개인보관함에 저장 되어있는 문서 리스트
	function electronic_approval_personal_storage_list($seq){
		if($seq == "all"){
			$sql = "SELECT group_concat(save_doc_seq SEPARATOR '') AS save_doc_seq from electronic_approval_personal_storage where user_id = '{$this->id}' AND save_doc_seq != '' ";
			$query = $this->db->query($sql);
			if ($query->num_rows() <= 0) {
				return false;
			} else {
				$doc_seq = $query->row_array();
				$doc_seq = $doc_seq['save_doc_seq'];
				if($doc_seq != ""){
					if(substr($doc_seq,0,1) == ","){
						$doc_seq = substr($doc_seq,1);
					}
					$doc_seq = explode(',',$doc_seq);
					$sql2 = "select ead.*,eaf.template_category FROM electronic_approval_doc AS  ead
					JOIN electronic_approval_form AS eaf
					ON ead.approval_form_seq = eaf.seq where ead.seq in ( ";
					for($i=0; $i<count($doc_seq); $i++){
						if($i == 0){
							$sql2 .= "{$doc_seq[$i]}";
						}else{
							$sql2 .= ",{$doc_seq[$i]}";
						}
					}
					$sql2 .= ")";

					$query2 = $this->db->query($sql2);
					if ($query2->num_rows() <= 0) {
						return false;
					}else{
						return $query2->result_array();
					}
				}else{
					return false;
				}

			}
		}else{
			$sql = "SELECT * from electronic_approval_personal_storage where user_id = '{$this->id}' AND seq = {$seq} AND save_doc_seq != '' ";
			$query = $this->db->query($sql);
			if ($query->num_rows() <= 0) {
				return false;
			} else {
				$doc_seq = $query->row_array();
				$doc_seq = $doc_seq['save_doc_seq'];

				if(substr($doc_seq,0,1) == ","){
					$doc_seq = substr($doc_seq,1);
				}
				$doc_seq = explode(',',$doc_seq);
				$sql2 = "select ead.*,eaf.template_category FROM electronic_approval_doc AS  ead
				JOIN electronic_approval_form AS eaf
				ON ead.approval_form_seq = eaf.seq where ead.seq in ( ";
				for($i=0; $i<count($doc_seq); $i++){
					if($i == 0){
						$sql2 .= "{$doc_seq[$i]}";
					}else{
						$sql2 .= ",{$doc_seq[$i]}";
					}
				}
				$sql2 .= ")";

				$query2 = $this->db->query($sql2);
				if ($query2->num_rows() <= 0) {
					return false;
				}else{
					return $query2->result_array();
				}
			}
		}

	}

	//개인보관함 내 문서 삭제
	function storage_doc_delete($seq,$delete_doc_seq){
		$sql = "UPDATE electronic_approval_personal_storage SET save_doc_seq= REPLACE(save_doc_seq, '{$delete_doc_seq}', '') WHERE seq = {$seq}";
		return $this->db->query($sql);
	}

	//댓글 저장
	function commentSave($data,$type){
		if($type == 0){
			return $this->db->insert('electronic_approval_comment',$data);
		}else if($type == 1){
			return $this->db->update('electronic_approval_comment',$data,array('seq' => $data['seq']));
		}else{
			$sql = "DELETE FROM electronic_approval_comment WHERE seq = {$data}";
			return $this->db->query($sql);
		}

	}

	//댓글 불러왕
	function approval_comment_select($seq){
		$sql = "SELECT * FROM electronic_approval_comment WHERE approval_doc_seq = {$seq} ORDER BY insert_date DESC ";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		}else{
			return $query->result_array();
		}
	}

	//즐겨찾기
	function form_bookmark($seq,$id,$type){
		if($type == 0){
			$sql = "UPDATE electronic_approval_form SET bookmark = concat(IFNULL(bookmark,''),',','{$id}') WHERE seq = {$seq}";
		}else{
			$sql = "UPDATE electronic_approval_form SET bookmark = REPLACE(bookmark, ',{$id}', '') WHERE seq = {$seq}";
		}
		return $this->db->query($sql);
	}

	//서식함 관리 수정삭제
	function format_category_modify($type,$data){
		if($type == 0 ){
			return $this->db->insert('format_category',$data);
		}else if ($type == 1){
			return $this->db->update('format_category',$data,array('seq' => $data['seq']));
		}else if ($type == 2){
			return $this->db->delete('format_category', $data);
		}else{
			return $this->db->update('format_category',$data,array('seq' => $data['seq']));
		}
	}

	//결재복원
	function restore_approval($approval_doc_seq,$step,$num){
		if($num == 0){ // assignment_date 살려놔야해
			$sql = "UPDATE electronic_approval_line SET approval_status = null,check_date=null ,approval_date = null,approval_opinion =null, delegation_seq =null WHERE approval_doc_seq ={$approval_doc_seq} AND step={$step}";
		}else{
			$sql = "UPDATE electronic_approval_line SET approval_status = null,assignment_date= null,check_date=null ,approval_date = null,approval_opinion =null, delegation_seq =null WHERE approval_doc_seq ={$approval_doc_seq} AND step={$step}";
		}
		$sql2 = "UPDATE electronic_approval_doc SET approval_doc_status = '001' WHERE seq = {$approval_doc_seq}"; // 진행중으로 바꿔버리기
		$this->db->query($sql2);
		return $this->db->query($sql);
	}

	//결재선 삭제
	function electronic_approval_line_delete($seq,$delete_row_num){
		$sql = "DELETE FROM electronic_approval_line WHERE approval_doc_seq = {$seq} and step >= {$delete_row_num}";
		return $this->db->query($sql);
	}

	//기안문 삭제
	function electronic_approval_doc_delete($seq){
		$sql = "DELETE FROM electronic_approval_doc WHERE seq = {$seq}";
		$result = $this->db->query($sql);
		$sql2 = "DELETE FROM electronic_approval_line WHERE approval_doc_seq = {$seq}";
		$this->db->query($sql2);
		$sql3 = "DELETE FROM electronic_approval_hold WHERE approval_doc_seq = {$seq}";
		$this->db->query($sql3);
		$sql4 = "DELETE FROM electronic_approval_comment WHERE approval_doc_seq = {$seq}";
		$this->db->query($sql4);
		return $result;
	}

	//본인 연차
	function annual($id,$year){
		$sql = "SELECT * FROM user_annual WHERE user_id='{$id}' AND annual_period = '{$year}'";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		}else{
			return $query->row_array();
		}
	}

	//연차 신청서 등록 / 수정
	function electronic_approval_annual_insert($data,$mode){
		if($mode == 1){
			return $this->db->insert('electronic_approval_annual',$data);
		}else{
			return $this->db->update('electronic_approval_annual',$data,array('approval_doc_seq' => $data['approval_doc_seq']));
		}
	}

	//기안문의 연차 신청서
	function electronic_approval_annual_select($doc_seq){
		$sql = "SELECT eaa.*,u.user_name,u.user_group,ug.parentGroupName,au.ws_time,au.wc_time FROM electronic_approval_annual AS eaa LEFT JOIN user AS u
		ON eaa.user_id = u.user_id
		LEFT JOIN user_group AS ug
		ON u.user_group = ug.groupName
		LEFT JOIN attendance_user AS au
		ON u.seq = au.user_seq
		WHERE approval_doc_seq = {$doc_seq}";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		}else{
			return $query->row_array();
		}
	}

	//연차 사용 수, 남은 연차 수 수정
	function user_annual_update($cnt,$user_id,$year){
		$sql = "UPDATE user_annual SET use_annual_cnt=use_annual_cnt+{$cnt}, remainder_annual_cnt=remainder_annual_cnt-{$cnt} WHERE user_id = '{$user_id}' AND annual_period='{$year}'";
		return $this->db->query($sql);
	}
	//연차신청서 중복값 체크
	function electronic_approal_annual_duplication_check($doc_seq,$annual_start_date,$annual_end_date,$user_id){
		if($doc_seq == ""){
			$sql = "SELECT * FROM electronic_approval_annual
			WHERE ('{$annual_start_date}' BETWEEN annual_start_date AND annual_end_date
			OR '{$annual_end_date}' BETWEEN annual_start_date AND annual_end_date)
			AND user_id = '{$user_id}'
			AND (annual_status != 'N' || annual_status IS null)";
		}else{
			$sql = "SELECT * FROM electronic_approval_annual
			WHERE ('{$annual_start_date}' BETWEEN annual_start_date AND annual_end_date
			OR '{$annual_end_date}' BETWEEN annual_start_date AND annual_end_date)
			AND user_id = '{$user_id}'
			AND (annual_status != 'N' || annual_status IS null)
			AND approval_doc_seq != {$doc_seq}";
		}
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		}else{
			return $query->result_array();
		}
	}

	//나의 수임자
	function select_mandatary($user_id,$date){
		$date = substr($date,0,10);
		$sql = "SELECT ead.*,u.user_email FROM electronic_approval_delegation as ead left join user as u on ead.mandatary_seq = u.seq WHERE ead.write_id = '{$user_id}' AND ead.insert_date BETWEEN '{$date} 00:00:00' AND '{$date} 23:59:59' and ead.status='Y' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		}else{
			return $query->result_array();
		}
	}

	//기안문양식 삭제
	function template_delete($seq){
		$sql = "DELETE FROM electronic_approval_form WHERE seq = {$seq}";
		return $this->db->query($sql);
	}

	//양식 작성기 서식
	function form_management_select(){
		$sql = "SELECT * FROM electronic_approval_form_management";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		}else{
			return $query->result_array();
		}
	}

	//양식 작성기 서식 저장
	function form_management_save($type,$data){
		if($type == 0){
			return $this->db->insert('electronic_approval_form_management',$data);
		}else if ($type == 1){
			return $this->db->update('electronic_approval_form_management',$data,array('seq' => $data['seq']));
		}else{
			$sql = "DELETE FROM electronic_approval_form_management WHERE seq = '{$data}'";
			return $this->db->query($sql);
		}
	}

	//근태조정 기안문 작성시 insert
	function electronic_approval_attendance_insert($data,$mode){
		if($mode == 1){
			return $this->db->insert('electronic_approval_attendance',$data);
		}else{
			return $this->db->update('electronic_approval_attendance',$data,array('approval_doc_seq' => $data['approval_doc_seq']));
		}
	}

	//근태조정 연차 신청서
	function electronic_approval_attendance_select($doc_seq){
		$sql = "SELECT * FROM electronic_approval_attendance WHERE approval_doc_seq = {$doc_seq}";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		}else{
			return $query->row_array();
		}
	}

	//근태조정 결재완료시 근태조회정보 수정
	function user_attandance_update($data){
		return $this->db->update('attendance_manual',$data,array('seq' => $data['seq']));
	}

	//연차신청서 작성시 일정 등록
	function insert_schedule($data){
		return $this->db->insert('tech_schedule_list',$data);
	}

	//id로 user_seq 가져오기
	function user_seq($user_id){
		$sql = "SELECT * FROM user WHERE user_id ='{$user_id}'";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		}else{
			return $query->row_array();
		}
	}

	function delegation_info($user_seq){
		$sql = "SELECT * FROM electronic_approval_delegation WHERE mandatary_seq = '{$user_seq}' and date(NOW()) between start_date AND end_date";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		}else{
			return $query->row_array();
		}
	}

	//결재요청함 / 임시저장함 리스트
	function approval_doc_list_request($type,$searchkeyword=""){
		$searchstring='';

		if ($searchkeyword != "") {
			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //문서상태
				$searchstring .= " AND approval_doc_status = '{$searchkeyword[0]}'";
			}
			if(trim($searchkeyword[1])!=''){ //기안일
				$searchstring .= " AND write_date >= '{$searchkeyword[1]}'";
			}
			if(trim($searchkeyword[2])!=''){//기안일
				$searchstring .= " AND write_date <= '{$searchkeyword[2]}'";
			}
			if(trim($searchkeyword[3])!=''){ //완료일
				$searchstring .= " AND completion_date >= '{$searchkeyword[3]}'";
			}
			if(trim($searchkeyword[4])!=''){//완료일
				$searchstring .= " AND completion_date <= '{$searchkeyword[4]}'";
			}
			if(trim($searchkeyword[5])!=''){ //양식명, 문서제목, 문서내용
				$searchstring .= " AND (template_name LIKE '%{$searchkeyword[5]}%' OR approval_doc_name LIKE '%{$searchkeyword[5]}%' OR contents_html LIKE '%{$searchkeyword[5]}%')";
			}
		}

		if($type == "request"){ //결재요청함
			$sql = "select t.* from (SELECT ead.*,eaf.template_category,
			case
			when ead.approval_form_seq = 'annual' then '연차신청서'
			when ead.approval_form_seq = 'attendance' then '근태조정계'
			else eaf.template_name end as template_name FROM electronic_approval_doc AS  ead
			left JOIN electronic_approval_form AS eaf
			ON ead.approval_form_seq = eaf.seq) as t where approval_doc_status != '005' and writer_id = '{$this->id}' {$searchstring}";
		}else if ($type == "temporary"){ //임시저장함
			$sql = "select t.* from (SELECT ead.*,eaf.template_category,
			case
			when ead.approval_form_seq = 'annual' then '연차신청서'
			when ead.approval_form_seq = 'attendance' then '근태조정계'
			else eaf.template_name end as template_name FROM electronic_approval_doc AS  ead
			left JOIN electronic_approval_form AS eaf
			ON ead.approval_form_seq = eaf.seq) as t where approval_doc_status = '005' and writer_id = '{$this->id}' {$searchstring}";
		}else if ($type == "attachment"){//기결재 첨부
			$sql = "select t.* from (SELECT ead.*,eaf.template_category,
			case
			when ead.approval_form_seq = 'annual' then '연차신청서'
			when ead.approval_form_seq = 'attendance' then '근태조정계'
			else eaf.template_name end as template_name ,eal.user_seq FROM electronic_approval_doc AS  ead
			left JOIN electronic_approval_form AS eaf
			ON ead.approval_form_seq = eaf.seq
			left JOIN (SELECT * from electronic_approval_line WHERE user_seq= '{$this->seq}')  AS eal
			ON ead.seq = eal.approval_doc_seq) as t
			where approval_doc_status = '002' AND (writer_id = '{$this->id}' || referrer LIKE '%{$this->name}%' || user_seq = '{$this->seq}') {$searchstring}";
		}
		else{
			$sql = "select t.* from (SELECT ead.*,eaf.template_category,
			case
			when ead.approval_form_seq = 'annual' then '연차신청서'
			when ead.approval_form_seq = 'attendance' then '근태조정계'
			else eaf.template_name end as template_name FROM electronic_approval_doc AS  ead
			left JOIN electronic_approval_form AS eaf
			ON ead.approval_form_seq = eaf.seq) as t where approval_doc_status = '{$type}' and writer_id = '{$this->id}' {$searchstring}";
		}
		if ($type == 'attachment') {
			$sql .= ' ORDER BY completion_date DESC, seq DESC';
		} else {
			$sql .= " order by seq desc";
		}

		// echo $sql;

		$query = $this->db->query( $sql );
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	function user_parents_group_mobile() {
    $sql = "SELECT DISTINCT(ug.parentGroupName) FROM user_group ug JOIN user u ON ug.groupName = u.user_group ORDER BY ug.seq";

    $query = $this->db->query($sql);

    return $query->result_array();
  }

  function user_group_mobile() {
    $sql = "SELECT * FROM user_group";

    $query = $this->db->query($sql);

    return $query->result_array();
  }

  function depth1_user_mobile() {
    $sql = "SELECT DISTINCT(ug.parentGroupName)
            FROM user_group ug
            JOIN (
            SELECT u.user_name, u.user_duty, u.user_group, ug.parentgroupname
            FROM user u
            JOIN user_group ug ON u.user_group = ug.groupName
            WHERE u.user_group = ug.parentGroupName) u ON ug.parentGroupName = u.user_group";

    $query = $this->db->query($sql);
    $d1_pgn = $query->result_array();

    $result = array();

    foreach($d1_pgn as $r) {
      $t = $r['parentGroupName'];

      $sql2 = "SELECT u.seq, u.user_name, u.user_duty, u.user_group, ug.parentgroupname
              FROM user u
              JOIN user_group ug ON u.user_group = ug.groupName
              WHERE u.user_group = ug.parentGroupName AND user_group = '{$t}' and quit_date is null
              ORDER BY FIELD(user_duty, '대표', '상무이사', '이사', '부장', '차장', '과장', '팀장', '대리', '주임', '사원');";
      $query = $this->db->query($sql2);
      $result[$t] = $query->result_array();
    }

    return $result;
  }

  function depth2_user_mobile() {
    $sql = "SELECT DISTINCT(ug.groupName)
            FROM user_group ug
            JOIN (
            SELECT u.user_name, u.user_duty, u.user_group, ug.parentgroupname
            FROM user u
            JOIN user_group ug ON u.user_group = ug.groupName
            WHERE u.user_group != ug.parentGroupName) u ON ug.groupName = u.user_group";

    $query = $this->db->query($sql);
    $d1_pgn = $query->result_array();

    $result = array();

    foreach($d1_pgn as $r) {
      $t = $r['groupName'];

      $sql2 = "SELECT u.seq, u.user_name, u.user_duty, u.user_group, ug.parentgroupname
              FROM user u
              JOIN user_group ug ON u.user_group = ug.groupName
              WHERE u.user_group = ug.groupName AND user_group = '{$t}' and quit_date is null
              ORDER BY FIELD(user_duty, '대표', '상무이사', '이사', '부장', '차장', '과장', '팀장', '대리', '주임', '사원');";
      $query = $this->db->query($sql2);
      $result[$t] = $query->result_array();
    }

    return $result;
  }

	function delete_expense_list($seq) {
		$sql = "delete from expense_list where approval_seq = {$seq}";

		$this->db->query($sql);
	}

	function delete_expense_list_tech($seq) {
		$sql = "delete from expense_list_tech where approval_seq = {$seq}";

		$this->db->query($sql);
	}

	// 던킨, 지출결의서 지출내역 저장
	function save_expense_list($data) {
		$this->db->insert('expense_list', $data);
	}

	// 출장보고서 지출내역 저장
	function save_expense_list_tech($data) {
		$this->db->insert('expense_list_tech', $data);
	}

	function corporation_card_num($id) {
		$sql = "SELECT corporation_card_yn, corporation_card_num from user where user_id = '{$id}'";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function expense_list_tech($attach_seq) {
		$sql = "SELECT * FROM expense_list_tech WHERE approval_seq IN ({$attach_seq}) ORDER BY t_date, seq";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function find_user_seq($name_duty) {
		$sql = "SELECT * FROM user WHERE CONCAT(user_name, ' ', user_duty) = '{$name_duty}'";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function save_salary_contract($data) {
		$this->db->insert('electronic_approval_salary_contract', $data);
	}

	function salary_contract_data($seq) {
		$sql = "SELECT * FROM electronic_approval_salary_contract where approval_seq = {$seq} order by seq desc limit 1";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function contract_user_data($seq) {
		$sql = "SELECT user_name, user_group, user_duty, user_tel, user_birthday, sign_realname, sign_changename FROM user where seq = {$seq}";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function contract_party_val($seq) {
		$sql = "SELECT easc.*, u.user_birthday, u.sign_changename FROM electronic_approval_salary_contract easc LEFT JOIN user u ON easc.contracting_party_seq = u.seq WHERE approval_seq = {$seq}";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function pwcheck($seq) {
		$sql = "SELECT sign_password FROM user where seq = {$seq}";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function tech_data($seq) { //기지보 데이터 -> 보고서 작성
		$sql = "SELECT * FROM tech_doc_basic WHERE seq = {$seq}";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function save_employment_doc($data) {
		return $this->db->insert('electronic_employment_doc', $data);
	}

	function update_employment_doc($data, $doc_seq) {
		return $this->db->update('electronic_employment_doc', $data, array('approval_seq' => $doc_seq));
	}

	function employment_doc_val($seq) {
		$sql = "SELECT * FROM electronic_employment_doc WHERE approval_seq = {$seq}";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function employment_doc_user_data($seq) {
		$sql = "SELECT user_name, join_company_date, user_birthday, user_group FROM user WHERE user_id = (SELECT writer_id FROM electronic_approval_doc WHERE seq = {$seq})";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function employment_doc_approve($approval_doc_seq) {
		$date = date('ymd');

		$sql1 = "SELECT LPAD(IFNULL(MAX(emd.doc_num2), 0) + 1, 4, '0') as doc_num2
		FROM electronic_employment_doc emd
		JOIN electronic_approval_doc ead ON emd.approval_seq = ead.seq
		WHERE ead.approval_doc_status = '002'";

		$doc_num2 = $this->db->query($sql1);
		$doc_num2 = $doc_num2->row_array();
		$data['doc_num2'] = $doc_num2['doc_num2'];

		$data['doc_num4'] = $date;

		$sql2 = "SELECT LPAD(IFNULL(MAX(emd.doc_num5), 0) + 1, 3, '0') as doc_num5
		FROM electronic_employment_doc emd
		JOIN electronic_approval_doc ead ON emd.approval_seq = ead.seq
		WHERE ead.approval_doc_status = '002' AND emd.doc_num4 = '{$date}'";

		$doc_num5 = $this->db->query($sql2);
		$doc_num5 = $doc_num5->row_array();
		$data['doc_num5'] = $doc_num5['doc_num5'];

		$this->db->update('electronic_employment_doc', $data ,array('approval_seq' => $approval_doc_seq));
	}

}
?>
