<?php
header("Content-type: text/html; charset=utf-8");

class Ajax extends CI_Controller {
	var $id = '';

	function __construct() {
		 parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
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
			$this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_User->idcheck($uid);
			
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
		$this->load->model('WF_Command');

		
		$hp_ip = $this->input->post( 'hp_ip' );
		$hp_no = $this->input->post( 'hp_no' );
		$mc_ip = $this->input->post( 'mip' );
		
		$return_flag = $this->WF_Command->csocket(8, $hp_ip, $hp_no, $mc_ip);
		
		
		$arr = array('socket_result' => $return_flag);
		echo json_encode($arr);
	}

	//조직도 그룹 별로 보기
	function groupView(){
		$group = $this->input->post('group');
		if( $group == null ) {
			redirect('');
		} else {
			$this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_User->groupView($group);
			echo json_encode($result);
		}
	}

	//상위그룹에 맞는 하위 그룹 보기
	function childGroup(){
		$parentGroup = $this->input->post('parentGroup');
		if( $parentGroup == null ) {
			redirect('');
		} else {
			$this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_User->childGroup($parentGroup);
			echo json_encode($result);
		}
	}
	
	//부서 그룹 전체 가져오기
	function group(){
		$this->load->Model(array('STC_User', 'STC_Common'));
		$result = $this->STC_User->group();
		echo json_encode($result);
	}

	//부서 이동하기
	function changeGroup(){
		$this->load->Model(array('STC_User', 'STC_Common'));
		$seq = $this->input->post( 'seq' );
		$group = $this->input->post( 'changeGroup' );
		$result = $this->STC_User->changeGroup($seq,$group);
		echo json_encode($result);
	}

	//권한 수정하기
	function changeUserPart(){
		$this->load->Model(array('STC_User', 'STC_Common'));
		$seq = $this->input->post( 'seq' );
		$userPart = $this->input->post( 'userPart' );
		$result = $this->STC_User->changeUserPart($seq,$userPart);
		echo json_encode($result);
	}

	//부서별 권한 수정
	function groupChangeUserPart(){
		$this->load->Model(array('STC_User', 'STC_Common'));
		$groupName = $this->input->post( 'groupName' );
		$userPart = $this->input->post( 'userPart' );
		$userLevel = $this->input->post( 'userLevel' );
		$result = $this->STC_User->groupChangeUserPart($groupName,$userPart,$userLevel);
		echo json_encode($result);
	}

	//부서 전체 삭제
	function groupAllDelete(){
		$this->load->Model(array('STC_User', 'STC_Common'));
		$result = $this->STC_User->groupAllDelete();
		echo json_encode($result);
	}

	//부서관리
	function groupUpdate(){
		$this->load->Model(array('STC_User', 'STC_Common'));
		$groupName = $this->input->post( 'groupName' );
		$parentGroupName = $this->input->post( 'parentGroupName' );
		$childGroupNum = $this->input->post( 'childGroupNum' );
		$depth = $this->input->post( 'depth' );
		$result = $this->STC_User->groupUpdate($groupName,$parentGroupName,$childGroupNum,$depth);
		echo json_encode($result);
	}

	//페이지 추가
	function insertPage(){
		$this->load->Model(array('STC_User', 'STC_Common'));
		$pageName = $this->input->post( 'pageName' );
		$pageAddress = $this->input->post( 'pageAddress' );
		$result = $this->STC_User->insertPage($pageName,$pageAddress);
		if($result == true){
			$result2 = $this->STC_User->insertPageChangeUserPart();
			echo json_encode($result2);
		}else{
			echo json_encode($result);
		}
	}

	//페이지 삭제
	function deletePage(){
		$this->load->Model(array('STC_User', 'STC_Common'));
		$seq = $this->input->post( 'seq' );
		$result = $this->STC_User->deletePageChangeUserPart($seq);
		if($result == true){
			$result2 = $this->STC_User->deletePage($seq);
			echo json_encode($result2);
		}else{
			echo json_encode($result);
		}
	}

	//페이지 수정
	function updatePage(){
		$this->load->Model(array('STC_User', 'STC_Common'));
		$seq = $this->input->post( 'seq' );
		$pageName = $this->input->post( 'pageName' );
		$pageAddress = $this->input->post( 'pageAddress' );
		$result = $this->STC_User->updatePage($seq,$pageName,$pageAddress);
		echo json_encode($result);
	}

	//페이지별 권한 수정
	function page_rights_update(){
		$this->load->Model(array('STC_User', 'STC_Common'));
		$seq = $this->input->post( 'seq' );
		$authority = $this->input->post( 'authority' );
		$group_authority = $this->input->post( 'group_authority' );
		$result = $this->STC_User->page_rights_update($seq,$authority,$group_authority);
		echo json_encode($result);
	}

	//협력사 멤버인지 확인
	function cooperative_company_member(){
		$this->load->Model('STC_User');

		$email = $this->input->post( 'email' );
		$cooperative_member= $this->STC_User->cooperative_company_member($email);
		echo json_encode($cooperative_member);
	}
}
?>
