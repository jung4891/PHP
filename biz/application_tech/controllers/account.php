<?php
header("Content-type: text/html; charset=utf-8");

class Account extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->lv = $this->phpsession->get( 'lv', 'stc' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->at = $this->phpsession->get( 'at', 'stc' );
		$this->pg = $this->phpsession->get( 'pg', 'stc' );
		$this->customerid = $this->phpsession->get( 'customerid', 'stc' );
	}

	function index( $referer = null ) {
		$data['login_status'] = "";
		$data['referer'] = $referer;
		$data['login_error'] = "";
		$data['view'] = 'login_view';
		$this->load->view( 'login_view', $data );
	}

	function login_view( $referer = null ) {
		$data['login_status'] = "";
		$data['referer'] = $referer;
		$data['login_error'] = "";
		$data['view'] = 'login_view';
		$this->load->view( 'login_view', $data );
	}

	function cooperative_login_view( $referer = null ) {
		$data['login_status'] = "";
		$data['referer'] = $referer;
		$data['login_error'] = "";
		$data['view'] = 'login_view';
		$this->load->view( 'cooperative_login_view', $data );
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

	//회원리스트
	function user() {
//		if( $this->id === null ) {
//			redirect( 'account' );
//		}
		
//		if( $this->lv != 3 ) {
//			echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
//		}

		$this->load->model('STC_User');
		
//		$cur_page = $this->input->get( 'cur_page' );			//	현재 페이지
		if(isset($_GET['cur_page'])) { 
			$cur_page = $_GET['cur_page'];
		} 
		else { 
			$cur_page = 0; 
		}														//	현재 페이지
		$no_page_list = 1;										//	한페이지에 나타나는 목록 개수
		
		if(isset($_GET['searchkeyword'])) { 
			$search_keyword = $_GET['searchkeyword'];
		} 
		else { 
			$search_keyword = "";
		}	
		$data['search_keyword'] = $search_keyword;
//		echo "search_keyword::".$this->input->post( 'search_keyword' )."<br>";
//		exit;

		if  ( $cur_page <= 0 )
			$cur_page = 1;
		
		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_User->user_list($search_keyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_User->user_list_count($search_keyword)->ucount;
		
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

		$data['no_page_list'] = $no_page_list;
		$data['total_page'] = $total_page;
		$data['start_page'] = $start_page;
		$data['end_page'] = $end_page;
			
		$this->load->view( 'user_list', $data );
	}
	
	//회원리스트에서 회원삭제
	function user_delete() {
		if( $this->id === null ) {
			redirect( 'account' );
		}
		
		if( $this->lv != 3 ) {
			echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
		}

		$this->load->model('STC_User');
		$user_id = $this->input->post( "user_id" );
		$this->STC_User->delete_user( $user_id );

		echo "<script>alert('삭제되었습니다.');location.href='".site_url()."account/user'</script>";
	}
	
	//회원리스트에서 회원정보 수정뷰
	function user_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}
		
		if( $this->lv != 3 ) {
			echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
		}

		$this->load->model( 'User' );
		
		$user_id = $this->input->post( "user_id" );
		$userdata = $this->STC_User->selected_user( $user_id );

		$data['user_id'] = $userdata['user_id'];
		$data['user_name'] = $userdata['user_name'];
		$data['user_passwd'] = $userdata['user_passwd'];
		$data['restarea_name'] = $userdata['restarea_name'];
		$data['user_tel'] = $userdata['user_tel'];
		$data['user_email'] = $userdata['user_email'];
		$data['user_level'] = $userdata['user_level'];
		$data['user_comment'] = $userdata['user_comment'];

		$this->load->view( 'modify_view', $data );
	}
	
	//회원가입 뷰
	function join() {
		$data['view'] = 'join_view';
		$this->load->view( 'join_view', $data );
	}
	
	//사업자번호 뷰(아이디 신규신청/분실신고)
	function cnum_view($type) {
		$data['type'] = $type;
		if($type == 1) {
			$this->load->view( 'cnum_view', $data );
		} else {
			$this->load->view( 'cnum_view2', $data );
		}
	}

	//회원가입처리
	function join_ok() {	
		$this->load->model( 'STC_User' );
		$user_id = $this->input->get('user_id');
		$id_check = $this->STC_User->check_user_id_exist( $user_id );
		
		// 이미 회원가입되어 있음
		if($id_check == 1) {
			echo "<script>alert('해당 아이디로 가입되어 있는 회원이 있습니다.\\n\\n다른 아이디로 가입하여 주시기 바랍니다.');history.go(-1);</script>";
			exit;
		}
		
		$data = array(
			'user_part' => '000',
			'user_id' => $this->input->get('user_id'),
			'user_password' => sha1($this->input->get('user_password')),
			'user_name' => $this->input->get('user_name'),
			'company_name' => $this->input->get('company_name'),
			'company_num' => $this->input->get('company_num'),
			'confirm_flag' => 'N',
			'user_duty' => $this->input->get('user_duty'),
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
		로그인 회원정보 수정 뷰
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
		로그인, 회원리스트 회원정보수정 처리
	*/
	function modify_ok() {
		$this->load->model( 'STC_User' );
		
//		$user_name = $this->input->get('user_name');
		$user_passwd = $this->input->get('user_password');
		$company_name = $this->input->get('company_name');
//		$company_num = $this->input->get('company_num');
		$user_email = $this->input->get('user_email');
		$user_tel = $this->input->get('user_tel');
		$user_duty = $this->input->get('user_duty');

		$data = array(
			'user_password' => sha1($user_passwd),
			'company_name' => $company_name,
//			'company_num' => $company_num,
			'user_tel' => $user_tel,
			'user_email' => $user_email,
			'user_duty' => $user_duty,
			'update_date' => date("Y-m-d H:i:s")
		 );
				
		$result = $this->STC_User->insert_user( $data, $mode = 1, $this->id);
		
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
			$pagedata = $this->STC_User->select_page('기술');
			$page_authority = explode(',',$pagedata['default_authority']);
			$pageRowNum = $pagedata['row']-1;
			$user_level = substr($userdata['user_part'],$pageRowNum,1);
			
			if( $userdata['user_id']){
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
				$var = array( 'id' => $userdata['user_id'], 'name' => $userdata['user_name'], 'lv' => $user_level, 'at' => $user_authority, 'pg' => $pageRowNum ,'email' => $userdata['user_email'], 'company' => $userdata['company_num'],'pGroupName'=>$userdata['parentGroupName'],'group'=>$userdata['user_group']);
				
				//그룹 나누기
				// $group = '';
				// if(strpos($userdata['user_group'],'1팀') !== false){
				// 	$group = "1";
				// }else if(strpos($userdata['user_group'],'2팀') !== false){
				// 	$group = "2";
				// }else if(strpos($userdata['user_group'],'기술') !== false){
				// 	$group = "all";
				// }

				foreach( $var as $k => $v ){$this->phpsession->save( $k, $v, "stc" );}
				
				setcookie("cookieid", "" ,time()+60*60*24*30, "/");


				// echo '<script>window.open("'.site_url().'/account/periodic_inspection","","width = 900")</script>';
				
				echo "<script>location.href='".site_url()."?login=1'</script>";
			} else{																	//	해당 ID가 존재하지 않음
				echo "<script>alert('로그인에 실패하였습니다.\\n\\n아이디, 비밀번호를 확인후 로그인해 주시기 바랍니다.');location.href='".site_url()."/account'</script>";
			}
		}
	}
	
	// 로그아웃 
	function logout($referer = null) {
		$var = array( 'id', 'name', 'lv' , 'at', 'pg','customerid','cooperative_id','timeout');

		foreach( $var as $v ) {
			$this->phpsession->clear( $v, 'stc' );
		}

		echo "<script>location.href='".site_url()."'</script>";
	}
	
	// 사업자번호 확인체크
	function cnum_check() {
		$cnum = $this->input->get( 'cnum' );
		$type = $this->input->get( 'type' );
		$user_email = $this->input->get( 'user_email' );
				
		$this->load->model( 'STC_User' );

		$cnumdata2 = $this->STC_User->selected_cnum2($cnum, $user_email);
		if ($cnumdata2['seq']){
			//	임시 비번 생성
			$vowels = "aeuyAEUY1";
			$consonants = "bdghjmnpqrstvzBDGHJLMNPQRSTVWXZ2345678";

			$temppassword = "";
			$alt = time() % 2;
			for  ( $i = 0 ; $i < 9 ; $i++ ){
				if  ( $alt == 1 ){
					$temppassword .= $consonants[(rand() % strlen($consonants))];
					$alt = 0;
				}
				else{
					$temppassword .= $vowels[(rand() % strlen($vowels))];
					$alt = 1;
				}
			}
			
			//	임시 비번 내역 저장
			$this->STC_User->save_temp_password( $cnumdata2['user_id'], $temppassword );
			$uid = $cnumdata2['user_id'];

			//	메일 발송
			$to_email = $cnumdata2['user_email'];									//	받을 사람 email
			$from_email = "marketing@durianit.co.kr";								//	보내는 사람 email
			$subject = "[두리안정보기술센터]아이디, 패스워드 안내메일입니다.";		//	메일 제목
			$data['user_id'] = $uid;
			$data['user_password'] = $temppassword;
			$content = $this->load->view( 'idpw_email', $data, true );
			
			$mailresult = $this->_sendmail( $to_email, $from_email, $subject, $content );

			if  ( !$mailresult ){
				echo "<script>alert('이메일 보내기가 실패했습니다.');history.go(-1);</script>";
			}

			echo "<script>alert('사업자등록번호가 확인되었습니다.\\n\\n회원가입시 등록한 이메일로 아이디와 패스워드를 보내드렸습니다.');self.close();opener.location.href='".site_url()."/account'</script>";
		} else {
			echo "<script>alert('사업자등록번호가 존재하지 않습니다.\\n\\n다시 확인해 주시기 바랍니다.');history.go(-1);</script>";
		}
	}

	//고객사 로그인 뷰
	function customer_login() {
		$seq = explode('?',$_SERVER['REQUEST_URI']);
		$seq = base64_decode($seq[1]);
		$seq = str_replace("seq=","",$seq);
		$this->load->Model('STC_tech_doc');
		$data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq);
		$data['view'] = 'customer_login_view';
		$this->load->view('customer_login_view',$data);
	}

	//otp mail 전송 
	function customer_otp_send() {
		$data['view'] = 'customer_otp_send';
		$this->load->view( 'customer_otp_send',$data);
	}

	// 기술지원보고서 로그인
	function customer_login2( $referer = null ) {
		$userotp = $this->input->post( 'user_otp' );
		$checkotp = $this->input->post( 'otp' );
		$viewSeq = $this->input->post( 'viewSeq' );
		$loginName = $this->input->post( 'loginName' );
		$loginMail = $this->input->post( 'user_email' );
		
		if( $userotp == null){
			redirect('');
		}else {
			if($checkotp == $userotp){
				$this->phpsession->save('customerid',$loginMail,"stc");
				$_SESSION['timeout'] = time();
				setcookie("cookieid", "" ,time()+60*10, "/");
				echo "<script>location.href='".site_url()."/tech_board/tech_doc_print_action?".$viewSeq."&login=".$loginName." '</script>";
			}else{
				echo "<script>alert('로그인에 실패하였습니다.\\n\\n인증번호 재발급 후 로그인해 주시기 바랍니다.');history.go(-1);</script>";
			}			
		}
	}

	// 협력사 로그인
	function cooperative_login( $referer = null ) {
		$managerYN =  $this->input->post( 'managerYN' );
		$user_email= $this->input->post( 'user_email' );
		$userotp = $this->input->post( 'user_otp' );
		$checkotp = $this->input->post( 'otp' );
		$seq = $this->input->post( 'seq' );
		
		if( $userotp == null){
			redirect('');
		}else {
			if($checkotp == $userotp){
				$this->phpsession->save('cooperative_id',$user_email,"stc");
				$this->phpsession->save('lv',$managerYN,"stc");
				$_SESSION['timeout'] = time();
				setcookie("cookieid", "" ,time()+60*10, "/");
				if($seq == null){
					echo "<script>location.href='".site_url()."/tech_board/request_tech_support_list'</script>";
				}else{
					echo "<script>location.href='".site_url()."/tech_board/request_tech_support_view?seq={$seq}&mode=view'</script>";
				}
			}else{
				echo "<script>alert('로그인에 실패하였습니다.\\n\\n인증번호 재발급 후 로그인해 주시기 바랍니다.');history.go(-1);</script>";
			}			
		}
	}


	function periodic_inspection() {
		$this->load->model( 'STC_User' );
		$data['group'] = $this->input->get('group');
		$data['view_val']=$this->STC_User->periodic_inspection($data['group']);
		$this->load->view( 'periodic_inspection', $data );
	}
}
?>
