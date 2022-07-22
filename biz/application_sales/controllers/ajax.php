<?php
header("Content-type: text/html; charset=utf-8");

class Ajax extends CI_Controller {
	var $id = '';

	function __construct() {
		 parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->load->Model(array('sales/STC_Customer', 'STC_Common', 'admin/STC_User', 'sales/STC_Maintain', 'sales/STC_Forcasting', 'biz/STC_Approval','tech/STC_request_tech_support'));
		// $this->load->Model(array('admin/STC_User', 'admin/STC_Common'));
	}

	function index() {
		redirect('');
	}

	// 아이디체크
	function idcheck() {
		$uid = $this->input->post( 'id' );

		if( $uid == null ) {
			redirect('');
		} else {
			// $this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_Common->idcheck($uid);

			if($result == false) {
				$arr = array('result' => 'false');
				echo json_encode($arr);
			} else {
				$arr = array('result' => 'true');
				echo json_encode($arr);
			}
		}
	}

	// wakeup
	function wakeup() {
		// $this->load->Model('WF_Command');

		$hp_ip = $this->input->post( 'hp_ip' );
		$hp_no = $this->input->post( 'hp_no' );
		$mc_ip = $this->input->post( 'mip' );

		$return_flag = $this->WF_Command->csocket(8, $hp_ip, $hp_no, $mc_ip);

		$arr = array('socket_result' => $return_flag);
		echo json_encode($arr);
	}

	//거래처 사람들 데려오기
	function sales_customer_staff(){
		$seq = $this->input->post('seq');

		if ($seq == null) {
			redirect('');
		} else {
			// $this->load->Model(array('STC_User'));
			$result = $this->STC_Common->sales_customer_staff($seq);
			echo json_encode($result);
		}
	}

	//조직도 부서 별로 보기
	function groupView(){
		$group = $this->input->post('group');
		if( $group == null ) {
			redirect('');
		} else {
			$result = $this->STC_Common->groupView($group);
			echo json_encode($result);
		}
	}

	//상위부서에 맞는 하위 부서 보기
	function childGroup(){
		$parentGroup = $this->input->post('parentGroup');
		if( $parentGroup == null ) {
			redirect('');
		} else {
			// $this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_Common->childGroup($parentGroup);
			echo json_encode($result);
		}
	}

	//부서 부서 전체 가져오기
	function group(){
		// $this->load->Model(array('STC_User', 'STC_Common'));
		$result = $this->STC_Common->group();
		echo json_encode($result);
	}

	//부서 이동하기
	function changeGroup(){
		// $this->load->Model(array('STC_User', 'STC_Common'));
		$seq = $this->input->post( 'seq' );
		$group = $this->input->post( 'changeGroup' );
		$result = $this->STC_Common->changeGroup($seq,$group);
		echo json_encode($result);
	}

	//부서위치 이동하기
	function moveGroup(){
		$groupSeq = $this->input->post( 'seq' );
		$parentGroupName = $this->input->post( 'changeGroup' );
		$groupName = $this->input->post( 'id' );

		$beforeParents = $this->STC_Common->beforeParents($groupSeq); //이전 상위부서
		$beforeParents = $beforeParents['parentGroupName'];
		if ($groupName != $beforeParents) { //이전 상위부서가 자기자신일땐 제외
			$this->STC_Common->minusChildGroup($beforeParents); //이전 상위부서의 childGroupNum -1
		}
		$this->STC_Common->plusChildGroup($parentGroupName); //현재 상위부서의 childGroupNum +1

		if ($parentGroupName == '(주)두리안정보기술') { //맨 상위부서일때 -> 자기이름으로 변경
			$parentGroupName = $groupName;
			$depth = 1;
		} else {
			$depth2 = $this->STC_Common->depth($parentGroupName); //현재 상위부서의 depth보다 +1이므로
			$depth = $depth2['depth']+1;
		}

		$result = $this->STC_Common->moveGroup($groupSeq,$parentGroupName,$depth); //위치 이동한 부서 정보 수정

		echo json_encode($result);
	}

	//부서 수정 or 추가
	function modifyGroup(){
		$seq = $this->input->post('seq');
		$groupName = $this->input->post('group_name');
		$mode = $this->input->post( 'mode' ); //수정인지 추가인지 구분

		if($mode == 1) { //수정
			$data = array(
				"groupName" => $groupName
			);

		} else if($mode == 3) { //추가
			if($seq == 1) { //맨상위(두리안정보기술)일 경우
				$parentGroupName = $groupName; //상위부서에도 자기이름들어감
				$depth = 1;
			} else {
				$parentDepth = $this->STC_Common->groupName($seq);
				$parentGroupName = $parentDepth['groupName']; //상위부서 이름
				$depth = $parentDepth['depth']+1; //상위부서depth + 1 = 새부서depth
				$this->STC_Common->plusChildGroup($parentGroupName); //상위부서의 childGroupNum +1
			}

			$data = array(
				"groupName" => $groupName,
				"parentGroupName" => $parentGroupName,
				"depth" => $depth,
				"childGroupNum" => 1
			);

		}
		$result = $this->STC_Common->modifyGroup($mode,$seq,$data);

		echo json_encode($result);
	}

	//부서 삭제
	function removeGroup(){
		$seq = $this->input->post('seq');

		$groupName = $this->STC_Common->groupName($seq); //부서명
		$groupName = $groupName['groupName'];
		$parentsName = $this->STC_Common->beforeParents($seq); //상위부서
		$parentsName = $parentsName['parentGroupName'];
		if ($groupName != $parentsName) { //상위부서가 자기자신일땐 제외
			$this->STC_Common->minusChildGroup($parentsName); //상위부서의 childGroupNum -1
		}

		$result = $this->STC_Common->removeGroup($seq,$groupName);

		echo json_encode($result);
	}

	//부서 추가
	function addGroup(){
		// $this->load->Model(array('STC_User', 'STC_Common'));
		$seq = $this->input->post( 'seq' );
		$group = $this->input->post( 'changeGroup' );
		$result = $this->STC_Common->changeGroup($seq,$group);
		echo json_encode($result);
	}

	//권한 수정하기
	function changeUserPart(){
		// $this->load->Model(array('STC_User', 'STC_Common'));
		$seq = $this->input->post( 'seq' );
		$userPart = $this->input->post( 'userPart' );
		$result = $this->STC_Common->changeUserPart($seq,$userPart);
		echo json_encode($result);
	}

	//부서별 권한 수정
	function groupChangeUserPart(){
		// $this->load->Model(array('STC_User', 'STC_Common'));
		$groupName = $this->input->post( 'groupName' );
		$userPart = $this->input->post( 'userPart' );
		$userLevel = $this->input->post( 'userLevel' );
		$result = $this->STC_Common->groupChangeUserPart($groupName,$userPart,$userLevel);
		echo json_encode($result);
	}

	//부서 전체 삭제
	function groupAllDelete(){
		// $this->load->Model(array('STC_User', 'STC_Common'));
		$result = $this->STC_Common->groupAllDelete();
		echo json_encode($result);
	}

	//부서관리
	function groupUpdate(){
		// $this->load->Model(array('STC_User', 'STC_Common'));
		$groupName = $this->input->post( 'groupName' );
		$parentGroupName = $this->input->post( 'parentGroupName' );
		$childGroupNum = $this->input->post( 'childGroupNum' );
		$depth = $this->input->post( 'depth' );
		$result = $this->STC_Common->groupUpdate($groupName,$parentGroupName,$childGroupNum,$depth);
		echo json_encode($result);
	}

	//페이지 추가
	function insertPage(){
		// $this->load->Model(array('STC_User', 'STC_Common'));
		$pageName = $this->input->post( 'pageName' );
		$pageAddress = $this->input->post( 'pageAddress' );
		$result = $this->STC_Common->insertPage($pageName,$pageAddress);
		if($result == true){
			$result2 = $this->STC_User->insertPageChangeUserPart();
			echo json_encode($result2);
		}else{
			echo json_encode($result);
		}
	}

	//페이지 삭제
	function deletePage(){
		// $this->load->Model(array('STC_User', 'STC_Common'));
		$seq = $this->input->post( 'seq' );
		$result = $this->STC_Common->deletePageChangeUserPart($seq);
		if($result == true){
			$result2 = $this->STC_Common->deletePage($seq);
			echo json_encode($result2);
		}else{
			echo json_encode($result);
		}
	}

	//페이지 수정
	function updatePage(){
		// $this->load->Model(array('STC_User', 'STC_Common'));
		$seq = $this->input->post( 'seq' );
		$pageName = $this->input->post( 'pageName' );
		$pageAddress = $this->input->post( 'pageAddress' );
		$result = $this->STC_Common->updatePage($seq,$pageName,$pageAddress);
		echo json_encode($result);
	}

	//페이지별 권한 수정
	function page_rights_update(){
		// $this->load->Model(array('STC_User', 'STC_Common'));
		$seq = $this->input->post( 'seq' );
		$authority = $this->input->post( 'authority' );
		$group_authority = $this->input->post( 'group_authority' );
		$result = $this->STC_User->page_rights_update($seq,$authority,$group_authority);
		echo json_encode($result);
	}

	//협력사 정보 가져오기
	function cooperative_company(){
		// $this->load->Model('STC_request_tech_support');

		$seq = $this->input->post( 'seq' );
		$cooperative_staff = $this->STC_request_tech_support->cooperative_company_staff($seq);
		echo json_encode($cooperative_staff);
	}

	//협력사 엔지니어 정보 가져오기
	function cooperative_company_engineer(){
		// $this->load->Model('STC_request_tech_support');

		$seq = $this->input->post( 'seq' );
		$cooperative_engineer = $this->STC_request_tech_support->cooperative_company_engineer($seq);
		echo json_encode($cooperative_engineer);
	}

	//협력사 멤버인지 확인
	function cooperative_company_member(){
		// $this->load->Model('STC_User');

		$email = $this->input->post( 'email' );
		$cooperative_member= $this->STC_Common->cooperative_company_member($email);
		echo json_encode($cooperative_member);
	}

	// 비번체크
	function pwcheck() {
		$uname = $this->input->post( 'name' );

		if( $uname == null ) {
			redirect('');
		} else {
			// $this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_Common->pwcheck($uname);

			echo json_encode($result);
		}
	}

	//제품 검색
	function product_search(){
		$product_company = $this->input->post('productCompany');
		$product_type = $this->input->post('productType');

		// $this->load->Model(array('STC_Common'));
		$result = $this->STC_Common->get_product($product_company,$product_type);
		echo json_encode($result);
	}
}
?>
