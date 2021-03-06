<?php
header("Content-type: text/html; charset=utf-8");

class Account extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->lv = $this->phpsession->get( 'lv', 'stc' );
		$this->at = $this->phpsession->get( 'at', 'stc' );
		$this->pg = $this->phpsession->get( 'pg', 'stc' );
	}

	function index( $referer = null ) {
		$data['login_status'] = "";
		$data['referer'] = $referer;
		$data['login_error'] = "";
		$data['view'] = 'login_view';
		$this->load->view( 'login_view', $data );
	}
	
	//mail 보내주는 함수
	function _sendmail( $to, $fromemail, $subject, $content) {
		$charset='UTF-8';												// 문자셋 : UTF-8
		$subject="=?".$charset."?B?".base64_encode($subject)."?=\n";	// 인코딩된 제목
		$header = "MIME-Version: 1.0\n".
				"Content-Type: text/html; charset=".$charset."; format=flowed\n".
				"From: =?utf-8?B?".base64_encode("두리안정보기술센터")."?= <marketing@durianit.co.kr> \n".
				"X-sender : ".$fromemail."\n".
				"X-Mailer : PHP ".phpversion( )."\n".
				"X-Priority : 1\n".
				"Return-Path: ".$fromemail."\n".
				"Content-Transfer-Encoding: 8bit\n";

		return	mail( $to, $subject, $content, $header );
	}

	//회원리스트(공통)
	function user() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_User', 'STC_Common'));
//		$cur_page = $this->input->get( 'cur_page' );			//	현재 페이지
		if(isset($_GET['cur_page'])) { 
			$cur_page = $_GET['cur_page'];
		} 
		else { 
			$cur_page = 0; 
		}														//	현재 페이지
		$no_page_list = 10;										//	한페이지에 나타나는 목록 개수

		if(isset($_GET['searchkeyword'])) { 
			$search_keyword = $_GET['searchkeyword'];
		} 
		else { 
			$search_keyword = "";
		}
		
		
		$search1 = "";

		if(isset($_GET['search2'])) { 
			$search2 = $_GET['search2'];
		} 
		else { 
			$search2 = "";
		}
		
		$data['search_keyword'] = $search_keyword;
		$data['search2'] = $search2;
		
		if  ( $cur_page <= 0 )
			$cur_page = 1;
		
		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_User->user_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_User->user_list_count($search_keyword, $search1, $search2)->ucount;
		
		$data['list_val'] = $user_list_data['data'];
		$data['list_val_count'] = $user_list_data['count'];
		
		$total_page = 1;
		if  ( $data['count'] % $no_page_list == 0 )
			$total_page = floor( ( $data['count'] / $no_page_list ) );
		else
			$total_page = floor( ( $data['count'] / $no_page_list + 1 ) );			//	전체 페이지 개수

		$start_page =  floor(($cur_page - 1 ) / 10) * 10  + 1 ;
		$end_page = 0;
		if  ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) )
			$end_page = ( floor( ( $cur_page - 1 ) / 10 ) + 1 ) * 10;
		else
			$end_page = $total_page;
		
		$data['category'] = $this->STC_Common->get_category();

		$data['no_page_list'] = $no_page_list;
		$data['total_page'] = $total_page;
		$data['start_page'] = $start_page;
		$data['end_page'] = $end_page;
		
		$this->load->view( 'user_list', $data );
	}
	
	// 회원 삭제
	function user_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		$this->load->model( 'STC_User' );
		$seq = $this->input->get( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_User->user_delete($seq);
		} 
		
		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/account/user'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}
	
	// 회원 쓰기 뷰
	function user_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_User', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
		$data['groupList'] = $this->STC_User->group();
		$data['pageList'] = $this->STC_User->page();
		$this->load->view( 'user_input', $data);
	}

	// 회원 보기/수정 뷰
	function user_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_User', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
		$data['pageList'] = $this->STC_User->page();
//		$user_id = $this->idx;
		
		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );
		
		$data['view_val'] = $this->STC_User->user_view($seq);
		$data['groupList'] = $this->STC_User->group();
		$data['seq'] = $seq;
		
		$this->load->view( 'user_modify', $data );
	}
	
	//회원가입처리
	function user_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}
		
		$this->load->model( 'STC_User' );
		$user_id = $this->input->get('user_id');
		$id_check = $this->STC_User->check_user_id_exist( $user_id );
		
		// 이미 회원가입되어 있음
		if($id_check == 1) {
			echo "<script>alert('해당 아이디로 가입되어 있는 회원이 있습니다.\\n\\n다른 아이디로 가입하여 주시기 바랍니다.');history.go(-1);</script>";
			exit;
		}
		
		$data = array(
			'user_part' => $this->input->get('user_part'),
			'user_id' => $this->input->get('user_id'),
			'user_password' => sha1($this->input->get('user_password')),
			'user_name' => $this->input->get('user_name'),
			'company_name' => $this->input->get('company_name'),
			'company_num' => $this->input->get('company_num'),
			'confirm_flag' => $this->input->get('confirm_flag'),
			// 'user_level' => $this->input->get('user_level'),
			'user_duty' => $this->input->get('user_duty'),
			'user_group' => $this->input->get('user_group'),
			'user_tel' => $this->input->get('user_tel'),
			'user_email' => $this->input->get('user_email'),
			'insert_date' => date("Y-m-d H:i:s"),
			'update_date' => date("Y-m-d H:i:s")
		 );
		
		$result = $this->STC_User->insert_user( $data, $mode = 0);
		
		if($result) {
			echo "<script>alert('입력되었습니다.');location.href='".site_url()."'</script>";
			exit;
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
			exit;
		}
		
	}
	
	/*
		로그인한 회원정보 수정 뷰
	*/
	function modify_view() {
		$this->load->model( 'STC_User' );
		
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$user_id = $this->id;
		$userdata = $this->STC_User->selected_user( $user_id );
		
		$data['user_part'] = $userdata['user_part'];
		$data['user_id'] = $userdata['user_id'];
		$data['user_name'] = $userdata['user_name'];
		$data['user_password'] = $userdata['user_password'];
		$data['company_name'] = $userdata['company_name'];
		$data['company_num'] = $userdata['company_num'];
		$data['confirm_flag'] = $userdata['confirm_flag'];
		$data['user_tel'] = $userdata['user_tel'];
		$data['user_email'] = $userdata['user_email'];
		// $data['user_level'] = $userdata['user_level'];
		$data['user_duty'] = $userdata['user_duty'];
		$data['user_comment'] = $userdata['update_date'];

		$this->load->view( 'modify_view', $data );
	}

	/*
		회원리스트 회원정보수정 처리
	*/
	function modify_ok() {
		$this->load->model( 'STC_User' );
		
		$seq = $this->input->get('seq');
		$user_part = $this->input->get('user_part');
		$user_passwd = trim($this->input->get('user_password'));
		$company_name = $this->input->get('company_name');
		$company_num = $this->input->get('company_num');
		$user_email = $this->input->get('user_email');
		$user_tel = $this->input->get('user_tel');
		$user_duty = $this->input->get('user_duty');
		$confirm_flag = $this->input->get('confirm_flag');
		// $user_level = $this->input->get('user_level');
		$user_group = $this->input->get('user_group');
		
		if($user_passwd != "") {
			$data = array(
				'user_part' => $user_part,
				'user_password' => sha1($user_passwd),
				'company_name' => $company_name,
				'company_num' => $company_num,
				'user_tel' => $user_tel,
				'confirm_flag' => $confirm_flag,
				'user_email' => $user_email,
				'user_duty' => $user_duty,
				// 'user_level' => $user_level,
				'update_date' => date("Y-m-d H:i:s"),
				'user_group' => $user_group
			 );
		} else {
			$data = array(
				'user_part' => $user_part,
				'company_name' => $company_name,
				'company_num' => $company_num,
				'user_tel' => $user_tel,
				'confirm_flag' => $confirm_flag,
				'user_email' => $user_email,
				'user_duty' => $user_duty,
				// 'user_level' => $user_level,
				'update_date' => date("Y-m-d H:i:s"),
				'user_group' => $user_group
			 );
		}
				
		$result = $this->STC_User->insert_user( $data, $mode = 1, $seq);
		
		if($result) {
			echo "<script>alert('수정되었습니다.');location.href='".site_url()."/account/user'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	}
	
	/*
		로그인한 회원정보수정 처리
	*/
	function modify_ok2() {
		$this->load->model( 'STC_User' );
		
		$user_name = $this->input->get('user_name');
		$user_passwd = $this->input->get('user_password');
		$company_name = $this->input->get('company_name');
		$company_num = $this->input->get('company_num');
		$user_email = $this->input->get('user_email');
		$user_tel = $this->input->get('user_tel');
		$user_duty = $this->input->get('user_duty');

		$data = array(
			'user_password' => sha1($user_passwd),
			'company_name' => $company_name,
			'company_num' => $company_num,
			'user_tel' => $user_tel,
			'user_email' => $user_email,
			'user_duty' => $user_duty,
			'update_date' => date("Y-m-d H:i:s")
		 );
				
		$result = $this->STC_User->insert_user2( $data, $mode = 1, $this->id);
		
		if($result) {
			echo "<script>alert('수정되었습니다.');location.href='".site_url()."'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	}

	// 로그인
	function login( $referer = null ) {
		$userid = $this->input->post( 'user_id' );
		$userpassword = $this->input->post( 'user_password' );
		$user_level = '';
		$user_authority='';
		
		if( $userid == null || $userpassword == null )
			redirect('');
		else {
			$this->load->model( 'STC_User' );
			$userdata = $this->STC_User->select_user($userid, sha1($userpassword));			//	해당 ID가 존재하는지와 임시 로그인 상태인지 검사
			$pagedata = $this->STC_User->select_page('관리자');
			$page_authority = explode(',',$pagedata['default_authority']);
			$pageRowNum = $pagedata['row']-1;
			$user_level = substr($userdata['user_part'],$pageRowNum,1);
			
			if($userdata['user_id']){
				if(substr($userdata['user_part'],$pageRowNum,1) == 1){
					$user_authority = $page_authority[0];
				}else if(substr($userdata['user_part'],$pageRowNum,1) == 2){
					$user_authority = $page_authority[1];
				}else if(substr($userdata['user_part'],$pageRowNum,1) == 3){
					$user_authority = $page_authority[2];
				}else{
					$user_authority = '000';
				}

				if($pagedata['group_authority'] != ''){
					$group_authority = explode('|',$pagedata['group_authority']);
					for($i=0; $i<count($group_authority); $i++){
						if(strpos($group_authority[$i],$userdata['parentGroupName']) !== false){
							if(substr($userdata['user_part'],$pageRowNum,1) == 1){
								$user_authority = explode(',',$group_authority[$i]);
								$user_authority = $user_authority[0] ;
							}else if(substr($userdata['user_part'],$pageRowNum,1) == 2){
								$user_authority = explode(',',$group_authority[$i]);
								$user_authority = $user_authority[1] ;
							}else if(substr($userdata['user_part'],$pageRowNum,1) == 3){
								$user_authority = explode(',',$group_authority[$i]);
								$user_authority = $user_authority[2] ;
							}else{
								$user_authority ='000';	
							}
						}
					}
				}	
	
				//	해당 아이디가 존재하는 경우
				$var = array( 'id' => $userdata['user_id'], 'name' => $userdata['user_name'], 'lv' => $user_level, 'at' => $user_authority, 'pg' => $pageRowNum);
				
				foreach( $var as $k => $v )
					$this->phpsession->save( $k, $v, "stc" );
					setcookie("cookieid", "" ,time()+60*60*24*30, "/");
					echo "<script>location.href='".site_url()."'</script>";
			} else{																	//	해당 ID가 존재하지 않음
				echo "<script>alert('로그인에 실패하였습니다.\\n\\n아이디, 비밀번호를 확인후 로그인해 주시기 바랍니다.');location.href='".site_url()."/account'</script>";
			}
		}
	}

	function cooperative_login_view( $referer = null ) {
		$data['login_status'] = "";
		$data['referer'] = $referer;
		$data['login_error'] = "";
		$data['view'] = 'login_view';
		$this->load->view( 'cooperative_login_view', $data );
	}
	
	// 로그아웃 
	function logout($referer = null) {
		$var = array( 'id', 'name', 'lv' ,'at', 'pg','cooperative_id','time_out','customerid' );

		foreach( $var as $v ) {
			$this->phpsession->clear( $v, 'stc' );
		}

		echo "<script>location.href='".site_url()."'</script>";
	}

	//조직도 
	function group_tree_management(){
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_User', 'STC_Common'));
		$data['view_val'] = $this->STC_User->parentGroup();
		$this->load->view('group_tree_management',$data);

	}

	//부서이동 페이지
	function group_change(){
		if( $this->id === null ) {
			redirect( 'account' );
		}
		$this->load->Model(array('STC_User','STC_Common'));
		$this->load->view('group_change');
	}

	//권한 관리 페이지
	function level_change(){
		if( $this->id === null ) {
			redirect( 'account' );
		}
		$this->load->Model(array('STC_User','STC_Common'));
		$data['pageList'] = $this->STC_User->page();
		$this->load->view('level_change',$data);
	}
	//부서별 권한 관리 페이지
	function group_level_change(){
		if( $this->id === null ) {
			redirect( 'account' );
		}
		$this->load->Model(array('STC_User','STC_Common'));
		$data['pageList'] = $this->STC_User->page();
		$this->load->view('group_level_change',$data);

	}

	//부서 관리 페이지
	function group_management(){
		if( $this->id === null ) {
			redirect( 'account' );
		}
		$this->load->Model(array('STC_User','STC_Common'));
		$data['view_val'] = $this->STC_User->group();
		$this->load->view('group_management',$data);

	}

	//페이지 관리 페이지
	function page_management(){
		if( $this->id === null ) {
			redirect( 'account' );
		}
		$this->load->Model(array('STC_User','STC_Common'));
		$data['pageList'] = $this->STC_User->page();
		$this->load->view('page_management',$data);

	}

	//페이지별 권한 관리 페이지
	function page_rights_management(){
		if( $this->id === null ) {
			redirect( 'account' );
		}
		$this->load->Model(array('STC_User','STC_Common'));
		$data['pageList'] = $this->STC_User->page();
		$data['groupList'] = $this->STC_User->parentGroup();
		$this->load->view('page_rights_management',$data);
	}

	// 협력사 로그인
	function cooperative_login( $referer = null ) {
		$user_email= $this->input->post( 'user_email' );
		$userotp = $this->input->post( 'user_otp' );
		$checkotp = $this->input->post( 'otp' );
		// $seq = $this->input->post( 'seq' );
		
		if( $userotp == null){
			redirect('');
		}else {
			if($checkotp == $userotp){
				$this->phpsession->save('cooperative_id',$user_email,"stc");
				$_SESSION['timeout'] = time();
				setcookie("cookieid", "" ,time()+60*10, "/");
				echo "<script>location.href='".site_url()."/customer/customer_list'</script>";	
			}else{
				echo "<script>alert('로그인에 실패하였습니다.\\n\\n인증번호 재발급 후 로그인해 주시기 바랍니다.');history.go(-1);</script>";
			}			
		}
	}
}
?>