<?php
header("Content-type: text/html; charset=utf-8");

class STC_Approval extends CI_Model {

	function __construct() {

		parent::__construct();
		$this->user_id = $this->phpsession->get( 'id', 'rms' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->id = $this->phpsession->get( 'id', 'stc' );
	}

	//서식함 카테고리 가져오기
	function select_format_category() {
		$sql = "select * from format_category order by idx";
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
				$sql = "select * from user order by seq asc";
			}else{
				$sql = "select * from user where user_group='".$group."' order by seq asc";
			}
		}else{
			$seq = explode(',',$group);
			$sql = "select * from user where seq ='{$seq[1]}' ";

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
		$sql = "select * from user_group ";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}
	

	//상위그룹 가져오기
	function parentGroup(){
		$sql = "select * from user_group where groupName=parentGroupName order by seq asc";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//상위 그룹에 맞는 하위그룹 가져오기
	function childGroup($parentGroup){
		$sql = "select * from user_group where parentGroupName='{$parentGroup}' and groupName<>'{$parentGroup}'";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//전자결재 폼 list
	function approval_form_list($category){
		if($category == ""){
			$sql = "select * from electronic_approval_form";
		}else{
			$sql = "select * from electronic_approval_form where template_category = '{$category}'";
		}
		$sql .= " order by seq desc"; 
		$query = $this->db->query( $sql );
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//전자결재 폼 보여줘
	function approval_form_view($seq){
		$sql = "select * from electronic_approval_form where seq={$seq}";
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
			$result = $this->db->insert('electronic_approval_doc',$data);
			return $this->db->insert_id();
		}else{
			$sql = "delete from electronic_approval_line where approval_doc_seq = {$data['seq']} "; //결재라인 삭제
			$this->db->query( $sql );
			$result = $this->db->update('electronic_approval_doc',$data,array('seq' => $data['seq']));
			return $result;
		}
	}

	//기안문 뷰
	function approval_doc_view($seq){
		$sql = "select ead.*,eaf.template_name,eaf.template_category,eaf.editor_use,u.user_duty 
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
	function approval_doc_list($type){
		if($type == "request"){ //결재요청함
			$sql = "SELECT ead.*,eaf.template_category FROM electronic_approval_doc AS  ead
			left JOIN electronic_approval_form AS eaf
			ON ead.approval_form_seq = eaf.seq where ead.approval_doc_status != '005' and ead.writer_id = '{$this->id}'";
		}else if ($type == "temporary"){ //임시저장함
			$sql = "SELECT ead.*,eaf.template_category FROM electronic_approval_doc AS  ead
			left JOIN electronic_approval_form AS eaf
			ON ead.approval_form_seq = eaf.seq where ead.approval_doc_status = '005' and ead.writer_id = '{$this->id}'";
		}else{
			$sql = "SELECT ead.*,eaf.template_category FROM electronic_approval_doc AS  ead
			left JOIN electronic_approval_form AS eaf
			ON ead.approval_form_seq = eaf.seq where ead.approval_doc_status = '{$type}' and ead.writer_id = '{$this->id}'";
		}
		$sql .= " order by seq desc";

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
				$sql = "insert into electronic_approval_line (approval_doc_seq,user_seq,approval_type,assignment_date,step) values('{$doc_seq}','{$user_seq}','{$approval_type}','".date("Y-m-d H:i:s")."','{$step}')";
			}else{
				$sql = "insert into electronic_approval_line (approval_doc_seq,user_seq,approval_type,step) values('{$doc_seq}','{$user_seq}','{$approval_type}','{$step}')";
			}
		}else{
			$sql = "insert into electronic_approval_line (approval_doc_seq,user_seq,approval_type,step) values('{$doc_seq}','{$user_seq}','{$approval_type}','{$step}')";
		}
		
		return $this->db->query( $sql );
	}
	
	function approval_list($type){
		if($type == "standby"){
			$sql = "SELECT eal.*,u.user_id,u.user_name,u.user_group,ead.*,eaf.template_category,eaf.template_name  FROM electronic_approval_line as eal JOIN user u
			ON eal.user_seq = u.seq
			JOIN electronic_approval_doc AS ead
			ON ead.seq = eal.approval_doc_seq
			left JOIN electronic_approval_form AS eaf
			ON eaf.seq = ead.approval_form_seq 
			WHERE ead.approval_doc_status = '001' and eal.assignment_date != '' and ead.approval_doc_security !='Y' && eal.approval_date IS NULL AND u.user_id ='{$this->id}'";
        }else if($type== "progress"){
            $sql = "SELECT ead.*,al.*,eaf.template_category,eaf.template_name  FROM electronic_approval_doc AS ead
			LEFT JOIN (SELECT eal.approval_doc_seq,eal.user_seq,eal.approval_type,eal.approval_status,eal.assignment_date,eal.check_date,eal.approval_date,eal.approval_opinion,eal.details,eal.step,u.user_id,u.user_name,ead.mandatary AS mandatary,us.user_name AS mandatary_name,us.user_duty AS mandatary_duty,us.user_group AS mandatary_group
			from electronic_approval_line AS eal JOIN user AS u ON eal.user_seq = u.seq 
			left join electronic_approval_delegation AS ead ON ead.seq= eal.delegation_seq left join user AS us ON ead.mandatary_seq = us.seq) AS al
			ON  al.approval_doc_seq = ead.seq
			left JOIN electronic_approval_form AS eaf
			ON eaf.seq = ead.approval_form_seq
			WHERE ((al.user_name ='".$this->name."' and al.approval_date is not null) or (al.mandatary like '%{$this->name}%')
			OR (ead.writer_name ='".$this->name."')) and ead.approval_doc_status = '001' and ead.approval_doc_security !='Y' GROUP BY ead.seq";
        }else if($type == "completion"){
			$sql = "SELECT ead.*,al.*,eaf.template_category,eaf.template_name FROM electronic_approval_doc AS ead
			LEFT JOIN (SELECT eal.approval_doc_seq,eal.user_seq,eal.approval_type,eal.approval_status,eal.assignment_date,eal.check_date,eal.approval_date,eal.approval_opinion,eal.details,eal.step,u.user_id,u.user_name,ead.mandatary AS mandatary,us.user_name AS mandatary_name,us.user_duty AS mandatary_duty,us.user_group AS mandatary_group
			from electronic_approval_line AS eal JOIN user AS u ON eal.user_seq = u.seq 
			left join electronic_approval_delegation AS ead ON ead.seq= eal.delegation_seq left join user AS us ON ead.mandatary_seq = us.seq) AS al
			ON  al.approval_doc_seq = ead.seq
			left JOIN electronic_approval_form AS eaf
			ON eaf.seq = ead.approval_form_seq
			WHERE (al.user_name ='".$this->name."' OR al.mandatary_name = '{$this->name}' OR ead.writer_name ='".$this->name."') and ead.approval_doc_status = '002' and ead.approval_doc_security !='Y' and ead.completion_date IS not NULL GROUP BY ead.seq";
        }else if($type == "back"){
			$sql = "SELECT ead.*,al.*,eaf.template_category,eaf.template_name FROM electronic_approval_doc AS ead
			LEFT JOIN (SELECT eal.approval_doc_seq,eal.user_seq,eal.approval_type,eal.approval_status,eal.assignment_date,eal.check_date,eal.approval_date,eal.approval_opinion,eal.details,eal.step,u.user_id,u.user_name,ead.mandatary AS mandatary,us.user_name AS mandatary_name,us.user_duty AS mandatary_duty,us.user_group AS mandatary_group
			from electronic_approval_line AS eal JOIN user AS u ON eal.user_seq = u.seq 
			left join electronic_approval_delegation AS ead ON ead.seq= eal.delegation_seq left join user AS us ON ead.mandatary_seq = us.seq) AS al
			ON  al.approval_doc_seq = ead.seq
			left JOIN electronic_approval_form AS eaf
			ON eaf.seq = ead.approval_form_seq
			WHERE (al.user_name ='".$this->name."' OR al.mandatary_name = '{$this->name}' OR ead.writer_name ='".$this->name."') and ead.approval_doc_status = '003' and ead.approval_doc_security !='Y' GROUP BY ead.seq";
        }else if($type == "reference"){
			$sql = "SELECT ead.*,al.*,eaf.template_category,eaf.template_name FROM electronic_approval_doc AS ead
			LEFT JOIN (SELECT eal.approval_doc_seq,eal.user_seq,eal.approval_type,eal.approval_status,eal.assignment_date,eal.check_date,eal.approval_date,eal.approval_opinion,eal.details,eal.step,u.user_id,u.user_name,ead.mandatary AS mandatary,us.user_name AS mandatary_name,us.user_duty AS mandatary_duty,us.user_group AS mandatary_group
			from electronic_approval_line AS eal JOIN user AS u ON eal.user_seq = u.seq 
			left join electronic_approval_delegation AS ead ON ead.seq= eal.delegation_seq left join user AS us ON ead.mandatary_seq = us.seq) AS al
			ON  al.approval_doc_seq = ead.seq
			left JOIN electronic_approval_form AS eaf
			ON eaf.seq = ead.approval_form_seq
			WHERE (ead.referrer like '%".$this->name."%') and ead.approval_doc_security !='Y' GROUP BY ead.seq";
		}else if ($type == "admin"){
			$sql = "SELECT ead.*,al.*,eaf.template_category,eaf.template_name  FROM electronic_approval_doc AS ead
			LEFT JOIN (SELECT eal.approval_doc_seq,eal.user_seq,eal.approval_type,eal.approval_status,eal.assignment_date,eal.check_date,eal.approval_date,eal.approval_opinion,eal.details,eal.step,u.user_id,u.user_name,ead.mandatary AS mandatary,us.user_name AS mandatary_name,us.user_duty AS mandatary_duty,us.user_group AS mandatary_group
			from electronic_approval_line AS eal JOIN user AS u ON eal.user_seq = u.seq 
			left join electronic_approval_delegation AS ead ON ead.seq= eal.delegation_seq left join user AS us ON ead.mandatary_seq = us.seq) AS al
			ON  al.approval_doc_seq = ead.seq
			left JOIN electronic_approval_form AS eaf
			ON eaf.seq = ead.approval_form_seq
			where ead.approval_doc_status != '005'
		    GROUP BY ead.seq";
		}

		$sql .= " order by ead.seq desc";

		$query = $this->db->query( $sql );
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//결재자 라인에 내가 잇으면 가져와봥!
	function cur_approval_line($seq){
		// $sql = "select eal.*,u.user_id,u.user_name,u.user_group from electronic_approval_line as eal join user as u on eal.user_seq=u.seq where approval_doc_seq = {$seq} and u.user_name ='{$this->name}'";
		$sql = "select eal.*,u.user_id,u.user_name,u.user_group from electronic_approval_line as eal join user as u on eal.user_seq=u.seq where approval_doc_seq = {$seq} and assignment_date IS NOT NULL AND approval_date IS null";
		$query = $this->db->query( $sql );
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	//내 다음 스텝의 결재자
	function next_approval_line($seq,$cur_approval_seq){
		$sql = "select eal.*,u.user_id,u.user_name,u.user_group from electronic_approval_line as eal join user as u on eal.user_seq=u.seq where eal.approval_doc_seq = {$seq} and eal.step = (select eal.step+1 as step from electronic_approval_line as eal join user as u on eal.user_seq=u.seq where eal.seq={$cur_approval_seq}) ";
		$query = $this->db->query( $sql );
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

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

		if($next_seq != ""){
			if($data['approval_status'] == "Y"){//결재 
				$sql = "update electronic_approval_line set assignment_date = '".date("Y-m-d H:i:s")."' where seq = {$next_seq}";
				$result = $this->db->query( $sql );
			}else if($data['approval_status'] == ""){//결재취소할때
				$sql = "update electronic_approval_line set assignment_date = null where seq = {$next_seq}";
				$result = $this->db->query( $sql );
			}
			
		}
		return $result;
	}

	// 전자결재 기안문 수정
	function electronic_approval_doc_update($data){
		if(isset($data['approval_doc_status'])){
			if($data['approval_doc_status']== "004"){
				$sql = "update electronic_approval_line set approval_status = null,assignment_date= null,check_date=null ,approval_date = null,approval_opinion =null, delegation_seq =null where approval_doc_seq = {$data['seq']}";
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
			$sql = "update electronic_approval_hold set 
			hold_status = '{$data['hold_status']}',
			processing_date = '{$data['processing_date']}'
			where approval_doc_seq = {$data['approval_doc_seq']} order by seq desc limit 1";
			$result = $this->db->query( $sql );
		}
		
		return $result;
	}

	
	function approval_hold_select($seq){
		$sql = "select * from electronic_approval_hold where approval_doc_seq= {$seq} ";
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
			$sql = "delete from user_approval_line where seq in ({$data})";
			return $this->db->query($sql);
		}
	}
	
	//사용자 결재선 조회
	function user_approval_line_select($id){
		$sql = "select * from user_approval_line where user_id = '{$id}' or user_id='admin' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//사용자 가져오기
	function select_user($seq){
		$sql = "select * from user where seq = '{$seq}'";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}
	
	//위임저장
	function delegation_save($data,$type){
		if($type == 1){ //위임저장
			return $this->db->insert('electronic_approval_delegation',$data);
		}else{//위임 설정해제
			$sql = "update electronic_approval_delegation set status='N' where seq in ($data)";
			return $this->db->query($sql);
		}
	}

	//위임 리스트
	function electronic_approval_delegation_list(){
		$sql = "select * from electronic_approval_delegation where write_id = '{$this->id}' order by seq desc";
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
		 	JOIN electronic_approval_form AS eaf
		 	ON eaf.seq = ead.approval_form_seq 
		 	WHERE ead.approval_doc_status = '001' and eal.assignment_date != '' && eal.approval_date IS NULL 
			AND u.user_id = (SELECT ead.write_id from electronic_approval_delegation AS ead LEFT JOIN user AS u ON ead.mandatary_seq = u.seq WHERE ead.status='Y' and u.user_id ='{$this->id}' AND (start_date  <= CURDATE() AND end_date >= CURDATE()))";
		
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
			$sql = "delete from electronic_approval_personal_storage where seq = {$data} or parent_id={$data}";
			$result = $this->db->query($sql);
		}else if($type == 4){
			$sql = "SELECT * from electronic_approval_personal_storage where seq={$data['seq']} and save_doc_seq LIKE '%{$data['save_doc_seq']}%'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				$result = "duplicate";
			} else {
				$sql = "update electronic_approval_personal_storage set save_doc_seq =concat(save_doc_seq,'{$data['save_doc_seq']}'),update_date='{$data['update_date']}' where seq = {$data['seq']}";
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
					$sql2 = "SELECT ead.*,eaf.template_category FROM electronic_approval_doc AS  ead
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
				$sql2 = "SELECT ead.*,eaf.template_category FROM electronic_approval_doc AS  ead
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
			$sql = "delete from electronic_approval_comment where seq = {$data}";
			return $this->db->query($sql);
		}
		
	}

	//댓글 불러왕
	function approval_comment_select($seq){
		$sql = "select * from electronic_approval_comment where approval_doc_seq = {$seq} order by insert_date desc ";
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
			$sql = "update electronic_approval_form set bookmark = concat(IFNULL(bookmark,''),',','{$id}') where seq = {$seq}";
		}else{
			$sql = "update electronic_approval_form set bookmark = REPLACE(bookmark, ',{$id}', '') where seq = {$seq}";
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
			$sql = "update electronic_approval_line set approval_status = null,check_date=null ,approval_date = null,approval_opinion =null, delegation_seq =null where approval_doc_seq ={$approval_doc_seq} and step={$step}";
		}else{
			$sql = "update electronic_approval_line set approval_status = null,assignment_date= null,check_date=null ,approval_date = null,approval_opinion =null, delegation_seq =null where approval_doc_seq ={$approval_doc_seq} and step={$step}";
		}
		return $this->db->query($sql);
	}
	
	//결재선 삭제
	function electronic_approval_line_delete($seq,$delete_row_num){
		$sql = "delete from electronic_approval_line where approval_doc_seq = {$seq} and step >= {$delete_row_num}";
		return $this->db->query($sql);
	}

	//기안문 삭제
	function electronic_approval_doc_delete($seq){
		$sql = "delete from electronic_approval_doc where seq = {$seq}";
		$result = $this->db->query($sql);
		$sql2 = "delete from electronic_approval_line where approval_doc_seq = {$seq}";
		$this->db->query($sql2);
		$sql3 = "delete from electronic_approval_hold where approval_doc_seq = {$seq}";
		$this->db->query($sql3);
		$sql4 = "delete from electronic_approval_comment where approval_doc_seq = {$seq}";
		$this->db->query($sql4);
		return $result;
	}

	//본인 연차 
	function annual($id,$year){
		$sql = "select * from user_annual where user_id='{$id}' and annual_period = '{$year}'";
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
		$sql = "select * from electronic_approval_annual where approval_doc_seq = {$doc_seq}";
		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			return false;
		}else{
			return $query->row_array();
		}
	}

	//연차 사용 수, 남은 연차 수 수정
	function user_annual_update($cnt,$user_id,$year){
		$sql = "update user_annual set use_annual_cnt=use_annual_cnt+{$cnt}, remainder_annual_cnt=remainder_annual_cnt-{$cnt} where user_id = '{$user_id}' and annual_period='{$year}'";
		return $this->db->query($sql);
	}
	//연차신청서 중복값 체크
	function electronic_approal_annual_duplication_check($doc_seq,$annual_start_date,$annual_end_date,$user_id){
		if($doc_seq == ""){
			$sql = "select * from electronic_approval_annual 
			WHERE ('{$annual_start_date}' BETWEEN annual_start_date AND annual_end_date
			or '{$annual_end_date}' BETWEEN annual_start_date AND annual_end_date)
			AND user_id = '{$user_id}'
			AND (annual_status != 'N' || annual_status IS null)";
		}else{
			$sql = "select * from electronic_approval_annual 
			WHERE ('{$annual_start_date}' BETWEEN annual_start_date AND annual_end_date
			or '{$annual_end_date}' BETWEEN annual_start_date AND annual_end_date)
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
}
?>