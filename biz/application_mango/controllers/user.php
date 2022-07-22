<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class User extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'mango' );
		$this->name = $this->phpsession->get( 'name', 'mango' );
		$this->seq = $this->phpsession->get( 'seq', 'mango' );
		$this->admin = $this->phpsession->get( 'admin', 'mango' );

		$this->load->Model(array('STC_User', 'STC_Common'));
		$this->load->library('user_agent');
	}

	//회원 리스트(공통)
	function user_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		} else {
			$cur_page = 0;
		}														//	현재 페이지

		if(!isset($_GET['lpp']) || $_GET['lpp']=='') {
			$no_page_list = 15;										//	한페이지에 나타나는 목록 개수
		} else {
			$no_page_list = (int)$_GET['lpp'];
		}
		$data['lpp'] = $no_page_list;

		if(isset($_GET['searchkeyword'])) {
			$search_keyword = $_GET['searchkeyword'];
		} else {
			$search_keyword = "";
		}

		if(isset($_GET['search1'])) {
			$search1 = $_GET['search1'];
		} else {
			$search1 = "";
		}


		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;
		if  ( $cur_page <= 0 )
			$cur_page = 1;

		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_User->user_list($search_keyword, $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_User->user_list_count($search_keyword, $search1)->ucount;

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

		$this->load->view( 'user/user_list', $data );
	}

	function user_modify() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$seq = $this->input->get('seq');
		$mode = $this->input->get('mode');

		$data['view_val'] = $this->STC_User->user_view($seq);
		$data['seq'] = $seq;

		$this->load->view( 'user/user_modify', $data );
	}

	//공지사항 입력/수정 처리
	function user_modify_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$seq = $this->input->post('seq');
		$admin = $this->input->post( 'admin' );
		$confirm_flag = $this->input->post( 'confirm_flag' );
		$user_email = $this->input->post( 'user_email' );
		$user_tel = $this->input->post( 'user_tel' );
		$health_certificate_term_s = $this->input->post( 'health_certificate_term_s' );
		$health_certificate_term_e = $this->input->post( 'health_certificate_term_e' );
		$work_start = $this->input->post( 'work_start' );
		$work_end = $this->input->post( 'work_end' );
		$user_passwd = trim($this->input->post('user_password'));

		if($health_certificate_term_s == '') {
			$health_certificate_term_s = null;
		}
		if($health_certificate_term_e == '') {
			$health_certificate_term_e = null;
		}

		$work_start = join('*/*', $work_start);
		$work_end = join('*/*', $work_end);

		$data = array(
			'admin'                     => $admin,
			'confirm_flag'              => $confirm_flag,
			'user_email'                => $user_email,
			'user_tel'                  => $user_tel,
			'health_certificate_term_s' => $health_certificate_term_s,
			'health_certificate_term_e' => $health_certificate_term_e,
			'work_start'                => $work_start,
			'work_end'                  => $work_end,
		);

		if($user_passwd != '') {
			$data['user_password'] = sha1($user_passwd);
		}

		$health_file = NULL;
		$lchealth_file = NULL;
		$resume_file = NULL;
		$lcresume_file = NULL;
		$attestedcopy_file = NULL;
		$lcattestedcopy_file = NULL;

		// var_dump($_FILES['files']);
		$file_count = count($_FILES['files']['name']);

		$upload_dir = "/var/www/html/stc/misc/upload_mango/user";
		// $upload_dir = "c:/xampp/htdocs/biz/misc/upload_mango/user";

		for($i = 0; $i < $file_count; $i++) {
			$_FILES['f[]']['name'] = $_FILES['files']['name'][$i];
			$_FILES['f[]']['type'] = $_FILES['files']['type'][$i];
			$_FILES['f[]']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
			$_FILES['f[]']['error'] = $_FILES['files']['error'][$i];
			$_FILES['f[]']['size'] = $_FILES['files']['size'][$i];

			$csize = $_FILES['files']['size'][$i];
			$cname = $_FILES['files']['name'][$i];

			if($csize > 0) {
				$ext = substr(strrchr($cname,"."),1);
				$ext = strtolower($ext);

				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}

				if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}

				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('f[]') ) {
					$udata = array('upload_data' => $this->upload->data());
					$filename = $udata['upload_data']['orig_name'];
					$lcfilename = $udata['upload_data']['file_name'];
					if($i == 0) {
						$data['health_realname'] = $filename;
						$data['health_changename'] = $lcfilename;
					} else if ($i == 1) {
						$data['resume_realname'] = $filename;
						$data['resume_changename'] = $lcfilename;
					} else if ($i == 2) {
						$data['attestedcopy_realname'] = $filename;
						$data['attestedcopy_changename'] = $lcfilename;
					}
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
			}
		}

		$result = $this->STC_User->user_insert($data, $mode = 1, $seq);

		if($result) {
			echo "<script>alert('수정되었습니다.');location.href='".site_url()."/user/user_list'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	}

	function user_input_action() {
		$admin = $this->input->post( 'admin' );
		$confirm_flag = $this->input->post( 'confirm_flag' );
		$user_id = $this->input->post( 'user_id' );
		$user_name = $this->input->post( 'user_name' );
		$user_email = $this->input->post( 'user_email' );
		$user_tel = $this->input->post( 'user_tel' );
		$user_passwd = trim($this->input->post('user_password'));

		$data = array(
			'admin'                   => $admin,
			'confirm_flag'            => $confirm_flag,
			'user_id'                 => $user_id,
			'user_name'               => $user_name,
			'user_password'           => sha1($user_passwd),
			'user_email'              => $user_email,
			'user_tel'                => $user_tel
		);

		$result = $this->STC_User->user_insert($data, $mode = 0);

		if($result) {
			echo "<script>alert('저장되었습니다.');location.href='".site_url()."/user/user_list'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	}

	// 회원 삭제
	function user_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		// $this->load->Model( 'STC_User' );
		$seq = $this->input->post( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_User->user_delete($seq);
		}

		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/user/user_list'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
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

	function del_file() {
		$seq = $this->input->post('seq');
		$target = $this->input->post('target');
		$fname = $this->input->post('fname');

		$upload_dir = "/var/www/html/stc/misc/upload_mango/user/";
		// $upload_dir = "c:/xampp/htdocs/biz/misc/upload_mango/user/";

		$del_file = unlink($upload_dir.$fname);

		if($del_file) {
			if($target == 'resume') {
				$data['resume_realname'] = null;
				$data['resume_changename'] = null;
			} else if($target == 'health') {
				$data['health_realname'] = null;
				$data['health_changename'] = null;
			} else if($target == 'attestedcopy') {
				$data['attestedcopy_realname'] = null;
				$data['attestedcopy_changename'] = null;
			}

			$result = $this->STC_User->user_insert($data, $mode = 1, $seq);
		}

		echo json_encode($result);
	}

}
?>
