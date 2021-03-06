<?php
header("Content-type: text/html; charset=utf-8");

class STC_Common extends CI_Model {

	function __construct() {

		parent::__construct();
//		$this->user_id = $this->phpsession->get( 'id', 'stc' );
	}

	//	로그인시 해당 아이디로 내용 가져오기
	function select_user( $uid, $upass ) {
		$query = $this->db->query("select u.*, g.parentGroupName from user as u left join user_group as g on u.user_group = g.groupName where confirm_flag = 'Y' AND user_id = '".$uid."' and user_password = '".$upass."' ");

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	//현재 페이지에 대한 정보
	function select_page($pageName){
		$sql = "SELECT rp.row,mp.seq,mp.page_name,mp.page_address,mp.default_authority,mp.group_authority FROM management_page mp JOIN (SELECT @rownum:=@rownum+1 AS row, p.* FROM management_page p , (SELECT @rownum:=0) r) AS rp ON mp.seq=rp.seq WHERE mp.page_name = '{$pageName}'";
		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	//	해당 사업자번호 조회(사업자번호테이블)
	function selected_cnum( $cnum ) {
		$query = $this->db->query("select seq from company_number where company_num = '".$cnum."'");

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}

	//	해당 사업자번호 조회2(사용자테이블)
	function selected_cnum2( $cnum, $user_email ) {
		// $query = $this->db->query("select seq, user_id, user_password, user_email from user where company_num = '".$cnum."' and user_email = '".$user_email."' and user_part = '001'");
		$query = $this->db->query("select seq, user_id, user_password, user_email from user where company_num = '".$cnum."' and user_email = '".$user_email."'");
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

	// 가입하고자 하는 ID가 존재하는지 검사
	function check_user_id_exist( $user_id ) {
		$sql = "select user_id from user where user_id = ?";
		$query = $this->db->query( $sql, $user_id );

		if  ( $query->num_rows() == 0 ){		//	해당 ID가 존재하지 않음
			return	0;
		}

		return	1;
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

	//	로그인후 해당 아이디로 내용 가져오기
	function selected_user( $uid ) {
		$query = $this->db->query("select * from user where user_id = '".$uid."'");

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array() ;
		}
	}
//
	//카테고리 알아오기
	function get_category() {
		$sql = "select code, code_name from category";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_manufacturing_com(){
		$sql = "SELECT seq, company_name FROM sales_customer_basic WHERE manufacturing_com = 'Y' || seq = 4 ORDER BY seq DESC;";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//제조사, 품목, 제품명 알아오기
	function get_product($product_company='',$product_type='') {
		if($product_company == '' && $product_type == ''){
			$sql = "select seq, product_name, product_item, product_company from product order by product_company desc";
		}else if($product_company == ""){
			$sql = "select seq, product_name, product_item, product_company from product where product_type = '{$product_type}' order by product_company desc";

		}else if($product_type == ""){
			$sql = "select seq, product_name, product_item, product_company from product where product_company = '{$product_company}' order by product_company desc";
		}else{
			$sql = "select seq, product_name, product_item, product_company from product where product_type = '{$product_type}' and product_company = '{$product_company}' order by product_company desc";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//정기점검 여부 가져오자
	function periodic_inspection(){
		// $sql = "SELECT * from sales_forcasting WHERE (maintain_result=0 || maintain_result=9 || maintain_result=3) and progress_step > '014' and maintain_cycle != 7 and maintain_cycle != 9 and maintain_cycle != 0 AND NOW() < exception_saledate3 AND (sub_project_add IS NULL or sub_project_add NOT LIKE CONCAT('%', seq, '%')) ORDER BY maintain_date";
		$sql = "SELECT * from sales_maintain
		WHERE (maintain_result=0 || maintain_result=9 || maintain_result=3)
		and maintain_cycle != 7 and maintain_cycle != 9 and maintain_cycle != 0
		AND CURDATE() between exception_saledate2 AND exception_saledate3 ORDER BY maintain_date";

		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
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

	//	아이디로 패스워드 가져오기
	function pwcheck( $uname ) {
		$query = $this->db->query("select user_password from user where user_name = '".$uname."' ");

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	//거래처 담당자들 select
	function sales_customer_staff($seq) {
		$sql = "select * from sales_customer_staff where customer_seq = {$seq}";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//조직도 그룹 별로 보기 & 부서변경 페이지에서 memeber 보기
	function groupView($group){
		if(strpos($group,",") === false){
			if($group == "all"){
				$sql = "select * from user where quit_date is null and cooperation_yn = 'N' order by seq asc";
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

	//부서 이동
	function changeGroup($seq,$group){
		$sql = "update user set user_group = '{$group}' where seq = {$seq}";
		$query = $this->db->query( $sql );

		return	$query;
	}

	// //부서위치 이동
	// function moveGroup($seq,$group){
	// 	$sql = "update user_group set parentGroupName = '{$group}' where groupName = '{$seq}'";
	// 	$query = $this->db->query( $sql );
	//
	// 	return	$query;
	// }

	//권한 수정
	function changeUserPart($seq,$userPart){
		$sql = "update user set user_part = '{$userPart}' where seq = {$seq}";
		$query = $this->db->query( $sql );

		return	$query;
	}

	//그룹별 권한 수정
	function groupChangeUserPart($groupName,$userPart,$userLevel){
		$sql = "update user set user_part = INSERT(user_part, {$userPart}, 1, '{$userLevel}') where user_group = '{$groupName}'";
		$query = $this->db->query( $sql );

		return	$query;
	}

	//부서 다 지우기
	function groupAllDelete(){
		$sql = "delete from user_group";
		$query = $this->db->query( $sql );

		return	$query;
	}

	//이전 상위부서
	function beforeParents($groupSeq){
		$sql = "SELECT parentGroupName FROM user_group WHERE seq = {$groupSeq}";
		$query = $this->db->query( $sql );

		return	$query->row_array();
	}

	//이전 상위부서의 childGroupNum -1
	function minusChildGroup($beforeParents){
		$sql = "UPDATE user_group SET childGroupNum = childGroupNum-1 WHERE groupName = '{$beforeParents}'";
		$query = $this->db->query( $sql );

		return	$query;
	}

	//현재 상위부서의 childGroupNum +1
	function plusChildGroup($parentGroupName){
		$sql = "UPDATE user_group SET childGroupNum = childGroupNum+1 WHERE groupName = '{$parentGroupName}'";
		$query = $this->db->query( $sql );

		return	$query;
	}

	//현재 상위부서의 depth보다 +1이므로
	function depth($parentGroupName){
		$sql = "SELECT depth FROM user_group WHERE groupName = '{$parentGroupName}'";
		$query = $this->db->query( $sql );

		return	$query->row_array();
	}

	//위치 이동한 부서 수정
	function moveGroup($groupSeq,$parentGroupName,$depth){
		$sql = "UPDATE user_group SET parentGroupName = '{$parentGroupName}', depth = {$depth} WHERE seq = {$groupSeq}";
		$query = $this->db->query( $sql );

		return	$query;
	}

	//부모부서 이름&depth 구하기
	function groupName($seq){
		$sql = "SELECT groupName, depth FROM user_group WHERE seq = {$seq}";
		$query = $this->db->query( $sql );

		return	$query->row_array();
	}

	//부서 수정 or 추가
	function modifyGroup($mode,$seq,$data){
		if($mode == 1) { //수정
			$sql = "UPDATE user SET user_group = '{$data['groupName']}' WHERE user_group = (SELECT groupName FROM user_group WHERE seq = {$seq})";
			$this->db->query($sql);
			return $this->db->update('user_group', $data, array('seq' => $seq));
		} else if($mode == 3) { //추가
			return $this->db->insert('user_group', $data);
		}

	}

	//부서 삭제
	function removeGroup($groupSeq,$groupName){
		$sql = "DELETE FROM user_group WHERE seq = {$groupSeq} OR parentGroupName = '{$groupName}'";
		$query = $this->db->query( $sql );

		return	$query;
	}

	//durian 페이지들
	function page(){
		$sql = "select * from management_page";
		$query = $this->db->query( $sql );

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	//페이지 추가
	function insertPage($pageName,$pageAddress){
		$sql = "insert into management_page (page_name,page_address) values('{$pageName}','{$pageAddress}')";
		$query = $this->db->query( $sql );
		return	$query;
	}

	//페이지 insert 할때 user_part 수정
	function insertPageChangeUserPart(){
		$sql = "update user set user_part = CONCAT(user_part,'0')";
		$query = $this->db->query( $sql );
		return	$query;
	}

	//페이지 삭제
	function deletePage($seq){
		$sql = "delete from management_page where seq={$seq}";
		// update user set user_part = INSERT(user_part,(SELECT row_num FROM (SELECT @ROWNUM:=@ROWNUM+1 AS row_num, A.* FROM management_page A, (SELECT @ROWNUM:=0) R) row WHERE page_name = "관리자"), 1, '') ;

		$query = $this->db->query( $sql );
		return	$query;
	}
	//페이지 삭제할 때 user_part 수정해주는거
	function deletePageChangeUserPart($seq){
		$sql = "update user set user_part = INSERT(user_part,(SELECT row_num FROM (SELECT @ROWNUM:=@ROWNUM+1 AS row_num, A.* FROM management_page A, (SELECT @ROWNUM:=0) R) row WHERE seq = '{$seq}'), 1, '')";
		$query = $this->db->query( $sql );
		return	$query;
	}

	//페이지 수정
	function updatePage($seq,$pageName,$pageAddress){
		$sql = "update management_page set page_name='{$pageName}',page_address='{$pageAddress}' where seq={$seq}";
		return $this->db->query( $sql );
	}

	//페이지별 권한 수정
	function page_rights_update($seq,$authority,$group_authority){
		$sql = "update management_page set default_authority='{$authority}',group_authority='{$group_authority}' where seq={$seq}";
		$query = $this->db->query($sql);
		return	$query;
	}

	//협력사 멤버인지
	function cooperative_company_member($email){
		$sql = "SELECT * FROM sales_customer_staff cs JOIN sales_customer_basic cb ON cs.customer_seq = cb.seq WHERE cb.company_part ='004' and cs.user_email = '{$email}' and cs.manager='Y'";
		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	// id or seq 로 유저 정보 seq가져오기
	function user_info($key, $val) {
		$sql = "SELECT * FROM user WHERE {$key} = '{$val}'";
		$query = $this->db->query($sql);
		// echo $sql;

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	// 검색어 수정
	function keyword_replace($keyword, $category, $page) {
		$sql = "SELECT replace_keyword from search_keyword where keyword = '{$keyword}' and category = '{$category}' and page = '{$page}'";
		$query = $this->db->query($sql);

		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row_array();
		}
	}
}
?>
