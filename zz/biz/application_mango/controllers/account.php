<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	var $id = '';

	function __construct() {
     parent::__construct();
		 $this->id = $this->phpsession->get( 'id', 'mango' );
		 $this->admin = $this->phpsession->get( 'admin', 'mango' );
		 $this->seq = $this->phpsession->get( 'seq', 'mango' );
		 $this->name = $this->phpsession->get( 'name', 'mango' );

     $this->load->Model(array('STC_Common','STC_Dashboard'));
  }

	public function index()	{
		if( $this->id === null ) {
			$this->load->view('login_view');
		} else {
			// redirect('schedule/schedule_list');

			// 일정
			$data['schedule_count'] = $this->STC_Dashboard->schedule_count($this->admin, $this->seq);
			// 회원관리
			$data['user_data'] = $this->STC_Dashboard->member_management();
			// 건강검진 관리대장
			$data['health_certificate'] = $this->STC_Dashboard->health_certificate();
			// 내부서류
			$data['document_basic'] = $this->STC_Dashboard->document_basic();
			// 공지사항
			$data['notice_basic'] = $this->STC_Dashboard->notice_basic();

			$data['schedule'] = $this->STC_Dashboard->schedule($this->admin, $this->seq);


			$this->load->view( 'home_view', $data );

		}

		if (isset($_GET['selUser'])) {
      $selUser = $_GET['selUser'];
    } else {
      $selUser = $this->seq;
    }

    if ($selUser != '') {
      $data['sel_user'] = $selUser;
    } else {
      $data['sel_user'] = $this->seq;
    }

	}

	function login( $referer = null ) {
		$userid = $this->input->post( 'user_id' );
    $userpassword = $this->input->post( 'user_password' );

    if( $userid == null || $userpassword == null ) {
			redirect('');
		} else {
			$userdata = $this->STC_Common->select_user($userid, sha1($userpassword));         //   해당 ID가 존재하는지와 임시 로그인 상태인지 검사

      if(isset($userdata['user_id'])) {
				if($userdata['confirm_flag'] == 'N') {
					echo "<script>alert('승인되지 않은 계정입니다.\\n관리자에게 문의하세요.');location.href='".site_url()."/account'</script>";
				} else {
					//   해당 아이디가 존재하는 경우
					$var = array(
						'id'    => $userdata['user_id'],
						'name'  => $userdata['user_name'],
						'email' => $userdata['user_email'],
						'seq'   => $userdata['seq'],
						'admin' => $userdata['admin']
					);

					foreach( $var as $k => $v ) {
						$this->phpsession->save( $k, $v, "mango" );
						setcookie("cookieid", "" ,time()+60*60*24*30, "/");
						// echo "<script>location.href='".site_url()."/schedule/schedule_list?login=1'</script>";

						echo "<script>location.href='".site_url()."'</script>";
					}
				}
      } else{
				echo "<script>alert('로그인에 실패하였습니다.\\n\\n아이디, 비밀번호를 확인후 로그인해 주시기 바랍니다.');location.href='".site_url()."/account'</script>";
      }
    }
  }

	// 로그아웃
	function logout($referer = null) {
		 session_destroy();

		 echo "<script>location.href='".site_url()."'</script>";
	}

	//회원가입
	function sign_up(){

		$this->load->view('sign_up_view');

		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_id','아이디','required');
		$this->form_validation->set_rules('password','패스워드','required');
		$this->form_validation->set_rules('name','이름','required');
		$this->form_validation->set_rules('user_birthday','생년월일','required');
		$this->form_validation->set_rules('user_tel','전화번호','required');
		$this->form_validation->set_rules('email','이메일 주소','required');

		$this->form_validation->run();
	}


	function sign_up_action(){
		$this->load->Model( 'STC_common' );

		$userid = $this->input->post("user_id");
	  $userpassword = $this->input->post("user_password");
	  $username = $this->input->post("user_name");
	 	$useremail = $this->input->post("user_email");
		$usertel1 = $this->input->post("user_tel1");
		$usertel2 = $this->input->post("user_tel2");
		$workstart = $this->input->post("work_start");
		$workend = $this->input->post("work_end");
		if($workstart == '') {
			$workstart = null;
		}
		if($workend == '') {
			$workend = null;
		}

		$work_start = join('*/*', $workstart);
		$work_end = join('*/*', $workend);

		$data = array(
			'user_id'              => $userid,
			'user_password'        => sha1($userpassword),
			'user_name'            => $username,
			'user_email'           => $useremail,
			'user_tel'             => $usertel1.'-'.$usertel2,
			'work_start'           => $work_start,
			'work_end'             => $work_end
		);

		$result = $this->STC_Common->sign_up($data);
		if($result) {
			echo "<script>alert('회원가입이 완료되었습니다.');location.href='".site_url()."/account'</script>";
		}

	}


	function duplicate_id(){
		$id = $this->input->post("id");
		$result = $this->STC_Common->idcheck($id);
		if ($result) {
			echo json_encode("dupl");
		} else {
			echo json_encode("no");
		}
	}

	function find_id() {
		$this->load->view('find_id');
	}

	function find_id_action() {
		$user_name = $this->input->post('user_name');
		$user_email = $this->input->post('user_email');

		$result = $this->STC_Common->find_id($user_name, $user_email);

		if($result) {
			echo "<script>alert('가입하신 아이디는 ".$result['user_id']."입니다.');location.href='".site_url()."/account'</script>";
		} else {
			echo "<script>alert('조회된 아이디가 없습니다.');history.go(-1);</script>";
		}
	}

	function find_password() {
		$this->load->view('find_password');
	}

	function find_password_action() {
		 $user_id = $this->input->post( 'user_id' );
		 $user_email = $this->input->post( 'user_email' );

		$user_data = $this->STC_Common->find_user($user_id, $user_email);
		if ($user_data){
			 //   임시 비번 생성
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

			 //   임시 비번 내역 저장
			 $this->STC_Common->save_temp_password( $user_data['user_id'], $temppassword );
			 $uid = $user_data['user_id'];

			 //   메일 발송
			 $to_email = $user_data['user_email'];                           //   받을 사람 email
			 $from_email = "lab@durianit.co.kr";                        //   보내는 사람 email
			 $subject = "[더망고]아이디, 패스워드 안내메일입니다.";      //   메일 제목
			 $data['user_id'] = $uid;
			 $data['user_password'] = $temppassword;
			 $content = $this->load->view( 'idpw_email', $data, true );

			 $mailresult = $this->_sendmail( $to_email, $from_email, $subject, $content );

			 if  ( !$mailresult ){
					echo "<script>alert('이메일 보내기가 실패했습니다.');history.go(-1);</script>";
			 }

			 echo "<script>alert('확인되었습니다.\\n\\n회원가입시 등록한 이메일로 아이디와 임시 패스워드를 보내드렸습니다.');location.href='".site_url()."/account'</script>";
		} else {
			 echo "<script>alert('일치하는 회원 정보가 존재하지 않습니다.\\n\\n다시 확인해 주시기 바랍니다.');history.go(-1);</script>";
		}
	}

	function _sendmail( $to, $fromemail, $subject, $content) {
		 $charset='UTF-8';                                    // 문자셋 : UTF-8
		 $subject="=?".$charset."?B?".base64_encode($subject)."?=\n";   // 인코딩된 제목
		 $header = "MIME-Version: 1.0\n".
					 "Content-Type: text/html; charset=".$charset."; format=flowed\n".
					 "From: =?utf-8?B?".base64_encode("두리안정보기술센터")."?= <lab@durianit.co.kr> \n".
					 "X-sender : ".$fromemail."\n".
					 "X-Mailer : PHP ".phpversion( )."\n".
					 "X-Priority : 1\n".
					 "Return-Path: ".$fromemail."\n".
					 "Content-Transfer-Encoding: 8bit\n";

		 return   mail( $to, $subject, $content, $header );
	}

	function personal_modify() {
		$user_seq = $this->seq;

		$this->load->Model('STC_User');

		$data['view_val'] = $this->STC_User->user_view($user_seq);
		$data['seq']      = $user_seq;

		$this->load->view('personal_modify', $data);
	}

	function personal_modify_action(){
		$this->load->Model( 'STC_common' );

		$seq = $this->input->post('seq');

		$userpassword = $this->input->post("user_password");
		$username = $this->input->post("user_name");
		$useremail = $this->input->post("user_email");
		$usertel1 = $this->input->post("user_tel1");
		$usertel2 = $this->input->post("user_tel2");
		$workstart = $this->input->post("work_start");
		$workend = $this->input->post("work_end");
		if($workstart == '') {
			$workstart = null;
		}
		if($workend == '') {
			$workend = null;
		}

		$work_start = join('*/*', $workstart);
		$work_end = join('*/*', $workend);

		$data = array(
			'user_password'        => sha1($userpassword),
			'user_name'            => $username,
			'user_email'           => $useremail,
			'user_tel'             => $usertel1.'-'.$usertel2,
			'work_start'           => $work_start,
			'work_end'             => $work_end
		);

		$result = $this->STC_Common->personal_modify($data, $seq);
		if($result) {
			echo "<script>alert('수정이 완료되었습니다.');history.go(-1);</script>";
		}

	}

	function schedule_list() {
		$date = $this->input->post( 'date' );
		$schedule_type = $this->input->post( 'schedule_type' );

		$data = $this->STC_Dashboard->schedule_list($this->admin, $this->seq, $date, $schedule_type);

		echo json_encode($data);
	}

}
