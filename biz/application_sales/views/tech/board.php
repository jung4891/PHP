<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Board extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->lv = $this->phpsession->get( 'lv', 'stc' );
		$this->email = $this->phpsession->get('email','stc'); //김수성추가
	}

	//글쓴거 mail 보내주는 함수 김수성-161228
	function _send_content( $to, $fromemail, $mail_subject, $mail_content) {
		$charset='UTF-8';												// 문자셋 : UTF-8
		$mail_subject="=?".$charset."?B?".base64_encode($mail_subject)."?=\n";	// 인코딩된 제목
		$header = "MIME-Version: 1.0\n".
				"Content-Type: text/html; charset=".$charset."; format=flowed\n".
				"From: =?utf-8?B?".base64_encode("Tech-QnA요청")."?= <".$fromemail."> \n".
				"X-sender : ".$fromemail."\n".
				"X-Mailer : PHP ".phpversion( )."\n".
				"X-Priority : 1\n".
				"Return-Path: ".$fromemail."\n".
				"Content-Transfer-Encoding: 8bit\n";

		return	mail( $to, $mail_subject, $mail_content, $header );
	}

	//글쓴거 mail 보내주는 함수 김수성-161228
	function _send_comment( $to, $fromemail, $mail_subject, $mail_content) {
		$charset='UTF-8';												// 문자셋 : UTF-8
		$mail_subject="=?".$charset."?B?".base64_encode($mail_subject)."?=\n";	// 인코딩된 제목
		$header = "MIME-Version: 1.0\n".
				"Content-Type: text/html; charset=".$charset."; format=flowed\n".
				"From: =?utf-8?B?".base64_encode("두리안정보기술센터")."?= <".$fromemail."> \n".
				"X-sender : ".$fromemail."\n".
				"X-Mailer : PHP ".phpversion( )."\n".
				"X-Priority : 1\n".
				"Return-Path: ".$fromemail."\n".
				"Content-Transfer-Encoding: 8bit\n";

		return	mail( $to, $mail_subject, $mail_content, $header );
	}


	//공지사항 리스트(공통)
	function notice_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
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
		
		if(isset($_GET['search1'])) { 
			$search1 = $_GET['search1'];
		} 
		else { 
			$search1 = "";
		}

		if(isset($_GET['search2'])) { 
			$search2 = $_GET['search2'];
		} 
		else { 
			$search2 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;
		$data['search2'] = $search2;
		
		if  ( $cur_page <= 0 )
			$cur_page = 1;
		
		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Board->notice_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Board->notice_list_count($search_keyword, $search1, $search2)->ucount;
		
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
		
		$this->load->view( 'notice_list', $data );
	}
	

function tech_device_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_tech_doc'));
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
		
		if(isset($_GET['search1'])) { 
			$search1 = $_GET['search1'];
		} 
		else { 
			$search1 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;
		
		if  ( $cur_page <= 0 )
			$cur_page = 1;
		
		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_tech_doc->tech_device_list($search_keyword, $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_tech_doc->tech_device_list_count($search_keyword, $search1)->ucount;
		
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
		
		$this->load->view( 'tech_device_list', $data );
	}

function tech_device_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_tech_doc'));
//		$user_id = $this->idx;
		
		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );
		
		$data['view_val'] = $this->STC_tech_doc->tech_device_view($seq);
		$data['seq'] = $seq;
		
		if($mode == "view") {
			$this->load->view( 'tech_device_view', $data );
		} else {
			$this->load->view( 'tech_device_modify', $data );
		}
	}

	
	// 공지사항 첨부파일 다운로드처리
	function notice_download($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		$this->load->Model('STC_Board');

		ini_set('memory_limit', '200M'); // 김수성 수정 2017-01-04 

		$fdata = $this->STC_Board->notice_file($seq, $filelcname);

		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/customer/notice/".$fdata['file_changename']);
		
		if (!force_download(urlencode($fdata['file_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 공지사항 첨부파일 삭제처리
	function notice_filedel($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		$this->load->Model('STC_Board');
		
		$fdata = $this->STC_Board->notice_file($seq, $filelcname);
		
		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		} else {
			$fdata2 = $this->STC_Board->notice_filedel($seq);
			if($fdata2) {
				unlink("/var/www/html/stc/misc/upload/customer/notice/".$fdata['file_changename']);
			}
			alert('파일이 정상적으로 삭제되었습니다.', site_url().'/board/notice_view?seq='.$seq.'&mode=modify');
		}
	}
	

	//공지사항 입력/수정 처리
	function notice_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->model( 'STC_Board' );
		$seq = $this->input->post('seq');

		$filename = NULL;
		$lcfilename = NULL;
		
		$csize = $_FILES["cfile"]["size"];
		$cname = $_FILES["cfile"]["name"];
		$ext = substr(strrchr($cname,"."),1);
		$ext = strtolower($ext);	
		
		if ($csize > 0 && $cname) {
			if ($csize > 104857600) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n100MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>"; /* 김수성 수정 2017-01-06 */
				exit;
			}
			
			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}
			
			$upload_dir = "/var/www/html/stc/misc/upload/customer/notice";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );
			
			if( $this->upload->do_upload('cfile') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}
			$data = array(
				'category_code' => $this->input->post('category_code'),
				'subject' => addslashes($this->input->post('subject')),
				'contents' => $this->input->post('contents'),
				'user_id' => $this->id,
				'user_name' => $this->name,
				'file_changename' => $lcfilename,
				'file_realname' => $filename,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			 );
		} else {
			$data = array(
				'category_code' => $this->input->post('category_code'),
				'subject' => addslashes($this->input->post('subject')),
				'contents' => $this->input->post('contents'),
				'user_id' => $this->id,
				'user_name' => $this->name,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			 );
		}
		
		if ($seq == null) {
			$result = $this->STC_Board->notice_insert($data, $mode = 0);
		} else {
			$result = $this->STC_Board->notice_insert($data, $mode = 1, $seq);
		}
		
		if($result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/board/notice_list'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
		
	}
	
	//공지사항 입력/수정시 ckeditor 이미지 본문삽입 처리
	function notice_input_action_image() {
		$this->load->model( 'STC_Board' );	
		$upload_dir = "/var/www/html/stc/misc/upload/customer/notice/image";

		$conf_file['upload_path'] = $upload_dir;
		$conf_file['allowed_types'] = 'gif|jpg|png|jpeg';
		$conf_file['max_size'] = '3000';
		$conf_file['max_width']  = '1024';
		$conf_file['max_height']  = '500';
		$conf_file['overwrite']  = false;
		$conf_file['encrypt_name']  = true;
		$conf_file['remove_spaces']  = true;

		$this->load->library( 'upload', $conf_file );
		
		if( $this->upload->do_upload('upload') ) {
			$CKEditorFuncNum = $this->input->get('CKEditorFuncNum');

			$data = $this->upload->data();
			$filename = $data['file_name'];
			$url = "/misc/upload/customer/notice/image/".$filename;
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('".$CKEditorFuncNum."', '".$url."', '전송에 성공했습니다.')</script>";
		} else {
			echo "<script>alert('업로드에 실패했습니다.".$this->upload->display_errors('','')."')</script>";
			exit;
		}	
	}

	// 공지사항 쓰기 뷰
	function notice_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
		$this->load->view( 'notice_input', $data );
	}

	// 공지사항 보기/수정 뷰
	function notice_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
//		$user_id = $this->idx;
		
		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );
		
		$data['view_val'] = $this->STC_Board->notice_view($seq);
		$data['seq'] = $seq;
		
		if($mode == "view") {
			$this->load->view( 'notice_view', $data );
		} else {
			$this->load->view( 'notice_modify', $data );
		}
	}
	
	// 공지사항 삭제
	function notice_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		$this->load->model( 'STC_Board' );
		$seq = $this->input->get( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_Board->notice_delete($seq);
		} 
		
		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/board/notice_list'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}

	//매뉴얼 리스트(공통)
	function manual_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
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
		
		if(isset($_GET['search1'])) { 
			$search1 = $_GET['search1'];
		} 
		else { 
			$search1 = "";
		}

		if(isset($_GET['search2'])) { 
			$search2 = $_GET['search2'];
		} 
		else { 
			$search2 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;
		$data['search2'] = $search2;
		
		if  ( $cur_page <= 0 )
			$cur_page = 1;
		
		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Board->manual_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Board->manual_list_count($search_keyword, $search1, $search2)->ucount;
		
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
		
		$this->load->view( 'manual_list', $data );
	}
	
	// 매뉴얼 첨부파일 다운로드처리
	function manual_download($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		$this->load->Model('STC_Board');

		ini_set('memory_limit', '500M'); // 김수성 수정 2017-01-04 


		$fdata = $this->STC_Board->manual_file($seq, $filelcname);

		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/customer/manual/".$fdata['file_changename']);
		
		if (!force_download(urlencode($fdata['file_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 매뉴얼 첨부파일 삭제처리
	function manual_filedel($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		$this->load->Model('STC_Board');
		
		$fdata = $this->STC_Board->manual_file($seq, $filelcname);
		
		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		} else {
			$fdata2 = $this->STC_Board->manual_filedel($seq);
			if($fdata2) {
				unlink("/var/www/html/stc/misc/upload/customer/manual/".$fdata['file_changename']);
			}
			alert('파일이 정상적으로 삭제되었습니다.', site_url().'/board/manual_view?seq='.$seq.'&mode=modify');
		}
	}
	

	//매뉴얼 입력/수정 처리
	function manual_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->model( 'STC_Board' );
		$seq = $this->input->post('seq');

		$filename = NULL;
		$lcfilename = NULL;
		
		$csize = $_FILES["cfile"]["size"];
		$cname = $_FILES["cfile"]["name"];
		$ext = substr(strrchr($cname,"."),1);
		$ext = strtolower($ext);	
		print_r($_FILES); 
		
		if ($csize > 0 && $cname) {
			if ($csize > 104857600) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n100MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>"; /* 김수성 수정 2017-01-06 */
				exit; 
			}
			
			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}
			
			$upload_dir = "/var/www/html/stc/misc/upload/customer/manual";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );
			
			if( $this->upload->do_upload('cfile') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}
			$data = array(
				'category_code' => $this->input->post('category_code'),
				'subject' => addslashes($this->input->post('subject')),
				'contents' => $this->input->post('contents'),
				'user_id' => $this->id,
				'user_name' => $this->name,
				'file_changename' => $lcfilename,
				'file_realname' => $filename,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			 );
		} else {
			$data = array(
				'category_code' => $this->input->post('category_code'),
				'subject' => addslashes($this->input->post('subject')),
				'contents' => $this->input->post('contents'),
				'user_id' => $this->id,
				'user_name' => $this->name,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			 );
		}
		
		if ($seq == null) {
			$result = $this->STC_Board->manual_insert($data, $mode = 0);
		} else {
			$result = $this->STC_Board->manual_insert($data, $mode = 1, $seq);
		}
		
		if($result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/board/manual_list'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
		
	}
	
	//매뉴얼 입력/수정시 ckeditor 이미지 본문삽입 처리
	function manual_input_action_image() {
		$this->load->model( 'STC_Board' );	
		$upload_dir = "/var/www/html/stc/misc/upload/customer/manual/image";

		$conf_file['upload_path'] = $upload_dir;
		$conf_file['allowed_types'] = 'gif|jpg|png|jpeg';
		$conf_file['max_size'] = '3000';
		$conf_file['max_width']  = '1024';
		$conf_file['max_height']  = '500';
		$conf_file['overwrite']  = false;
		$conf_file['encrypt_name']  = true;
		$conf_file['remove_spaces']  = true;

		$this->load->library( 'upload', $conf_file );
		
		if( $this->upload->do_upload('upload') ) {
			$CKEditorFuncNum = $this->input->get('CKEditorFuncNum');

			$data = $this->upload->data();
			$filename = $data['file_name'];
			$url = "/misc/upload/customer/manual/image/".$filename;
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('".$CKEditorFuncNum."', '".$url."', '전송에 성공했습니다.')</script>";
		} else {
			echo "<script>alert('업로드에 실패했습니다.".$this->upload->display_errors('','')."')</script>";
			exit;
		}	
	}

	// 매뉴얼 쓰기 뷰
	function manual_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
		$this->load->view( 'manual_input', $data );
	}

	// 매뉴얼 보기/수정 뷰
	function manual_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
//		$user_id = $this->idx;
		
		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );
		
		$data['view_val'] = $this->STC_Board->manual_view($seq);
		$data['seq'] = $seq;
		
		if($mode == "view") {
			$this->load->view( 'manual_view', $data );
		} else {
			$this->load->view( 'manual_modify', $data );
		}
	}
	
	// 매뉴얼 삭제
	function manual_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		$this->load->model( 'STC_Board' );
		$seq = $this->input->get( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_Board->manual_delete($seq);
		} 
		
		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/board/manual_list'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}

	//교육자료 리스트(공통)
	function edudata_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
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
		
		if(isset($_GET['search1'])) { 
			$search1 = $_GET['search1'];
		} 
		else { 
			$search1 = "";
		}

		if(isset($_GET['search2'])) { 
			$search2 = $_GET['search2'];
		} 
		else { 
			$search2 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;
		$data['search2'] = $search2;
		
		if  ( $cur_page <= 0 )
			$cur_page = 1;
		
		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Board->edudata_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Board->edudata_list_count($search_keyword, $search1, $search2)->ucount;
		
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
		
		$this->load->view( 'edudata_list', $data );
	}
	
	// 교육자료 첨부파일 다운로드처리
	function edudata_download($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		$this->load->Model('STC_Board');

		ini_set('memory_limit', '200M'); // 김수성 수정 2017-01-04 

		$fdata = $this->STC_Board->edudata_file($seq, $filelcname);

		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/customer/edudata/".$fdata['file_changename']);
		
		if (!force_download(urlencode($fdata['file_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 교육자료 첨부파일 삭제처리
	function edudata_filedel($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		$this->load->Model('STC_Board');
		
		$fdata = $this->STC_Board->edudata_file($seq, $filelcname);
		
		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		} else {
			$fdata2 = $this->STC_Board->edudata_filedel($seq);
			if($fdata2) {
				unlink("/var/www/html/stc/misc/upload/customer/edudata/".$fdata['file_changename']);
			}
			alert('파일이 정상적으로 삭제되었습니다.', site_url().'/board/edudata_view?seq='.$seq.'&mode=modify');
		}
	}
	

	//교육자료 입력/수정 처리
	function edudata_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->model( 'STC_Board' );
		$seq = $this->input->post('seq');

		$filename = NULL;
		$lcfilename = NULL;
		
		$csize = $_FILES["cfile"]["size"];
		$cname = $_FILES["cfile"]["name"];
		$ext = substr(strrchr($cname,"."),1);
		$ext = strtolower($ext);	
		
		if ($csize > 0 && $cname) {
			if ($csize > 104857600) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n100MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>"; /* 김수성 수정 2017-01-06 */
				exit;
			}
			
			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}
			
			$upload_dir = "/var/www/html/stc/misc/upload/customer/edudata";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );
			
			if( $this->upload->do_upload('cfile') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}
			$data = array(
				'category_code' => $this->input->post('category_code'),
				'subject' => addslashes($this->input->post('subject')),
				'contents' => $this->input->post('contents'),
				'user_id' => $this->id,
				'user_name' => $this->name,
				'file_changename' => $lcfilename,
				'file_realname' => $filename,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			 );
		} else {
			$data = array(
				'category_code' => $this->input->post('category_code'),
				'subject' => addslashes($this->input->post('subject')),
				'contents' => $this->input->post('contents'),
				'user_id' => $this->id,
				'user_name' => $this->name,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			 );
		}
		
		if ($seq == null) {
			$result = $this->STC_Board->edudata_insert($data, $mode = 0);
		} else {
			$result = $this->STC_Board->edudata_insert($data, $mode = 1, $seq);
		}
		
		if($result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/board/edudata_list'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
		
	}
	
	//교육자료 입력/수정시 ckeditor 이미지 본문삽입 처리
	function edudata_input_action_image() {
		$this->load->model( 'STC_Board' );	
		$upload_dir = "/var/www/html/stc/misc/upload/customer/edudata/image";

		$conf_file['upload_path'] = $upload_dir;
		$conf_file['allowed_types'] = 'gif|jpg|png|jpeg';
		$conf_file['max_size'] = '3000';
		$conf_file['max_width']  = '1024';
		$conf_file['max_height']  = '500';
		$conf_file['overwrite']  = false;
		$conf_file['encrypt_name']  = true;
		$conf_file['remove_spaces']  = true;

		$this->load->library( 'upload', $conf_file );
		
		if( $this->upload->do_upload('upload') ) {
			$CKEditorFuncNum = $this->input->get('CKEditorFuncNum');

			$data = $this->upload->data();
			$filename = $data['file_name'];
			$url = "/misc/upload/customer/edudata/image/".$filename;
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('".$CKEditorFuncNum."', '".$url."', '전송에 성공했습니다.')</script>";
		} else {
			echo "<script>alert('업로드에 실패했습니다.".$this->upload->display_errors('','')."')</script>";
			exit;
		}	
	}

	// 교육자료 쓰기 뷰
	function edudata_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
		$this->load->view( 'edudata_input', $data );
	}

	// 교육자료 보기/수정 뷰
	function edudata_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
//		$user_id = $this->idx;
		
		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );
		
		$data['view_val'] = $this->STC_Board->edudata_view($seq);
		$data['seq'] = $seq;
		
		if($mode == "view") {
			$this->load->view( 'edudata_view', $data );
		} else {
			$this->load->view( 'edudata_modify', $data );
		}
	}
	
	// 교육자료 삭제
	function edudata_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		$this->load->model( 'STC_Board' );
		$seq = $this->input->get( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_Board->edudata_delete($seq);
		} 
		
		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/board/edudata_list'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}

	//FAQ 리스트(공통)
	function faq_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
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
		
		if(isset($_GET['search1'])) { 
			$search1 = $_GET['search1'];
		} 
		else { 
			$search1 = "";
		}

		if(isset($_GET['search2'])) { 
			$search2 = $_GET['search2'];
		} 
		else { 
			$search2 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;
		$data['search2'] = $search2;
		
		if  ( $cur_page <= 0 )
			$cur_page = 1;
		
		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Board->faq_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Board->faq_list_count($search_keyword, $search1, $search2)->ucount;
		
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
		
		$this->load->view( 'faq_list', $data );
	}
	
	// FAQ 첨부파일 다운로드처리
	function faq_download($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		$this->load->Model('STC_Board');

		ini_set('memory_limit', '200M'); // 김수성 수정 2017-01-04 

		$fdata = $this->STC_Board->faq_file($seq, $filelcname);

		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/customer/faq/".$fdata['file_changename']);
		
		if (!force_download(urlencode($fdata['file_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// FAQ 첨부파일 삭제처리
	function faq_filedel($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		$this->load->Model('STC_Board');
		
		$fdata = $this->STC_Board->faq_file($seq, $filelcname);
		
		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		} else {
			$fdata2 = $this->STC_Board->faq_filedel($seq);
			if($fdata2) {
				unlink("/var/www/html/stc/misc/upload/customer/faq/".$fdata['file_changename']);
			}
			alert('파일이 정상적으로 삭제되었습니다.', site_url().'/board/faq_view?seq='.$seq.'&mode=modify');
		}
	}
	

	//FAQ 입력/수정 처리
	function faq_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->model( 'STC_Board' );
		$seq = $this->input->post('seq');

		$filename = NULL;
		$lcfilename = NULL;
		
		$csize = $_FILES["cfile"]["size"];
		$cname = $_FILES["cfile"]["name"];
		$ext = substr(strrchr($cname,"."),1);
		$ext = strtolower($ext);	
		
		if ($csize > 0 && $cname) {
			if ($csize > 104857600) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n100MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>"; /* 김수성 수정 2017-01-06 */
				exit;
			}
			
			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}
			
			$upload_dir = "/var/www/html/stc/misc/upload/customer/faq";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );
						if ( ! $this->upload->do_upload('cfile'))
			{
			$error = array('error' => $this->upload->display_errors());
			
			$this->load->view('upload_form', $error);
			}else if( $this->upload->do_upload('cfile') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}
			$data = array(
				'category_code' => $this->input->post('category_code'),
				'subject' => addslashes($this->input->post('subject')),
				'contents' => $this->input->post('contents'),
				'user_id' => $this->id,
				'user_name' => $this->name,
				'file_changename' => $lcfilename,
				'file_realname' => $filename,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			 );
		} else {
			$data = array(
				'category_code' => $this->input->post('category_code'),
				'subject' => addslashes($this->input->post('subject')),
				'contents' => $this->input->post('contents'),
				'user_id' => $this->id,
				'user_name' => $this->name,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			 );
		}
		
		if ($seq == null) {
			$result = $this->STC_Board->faq_insert($data, $mode = 0);
		} else {
			$result = $this->STC_Board->faq_insert($data, $mode = 1, $seq);
		}
		
		if($result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/board/faq_list'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
		
	}
	
	//FAQ 입력/수정시 ckeditor 이미지 본문삽입 처리
	function faq_input_action_image() {
		$this->load->model( 'STC_Board' );	
		$upload_dir = "/var/www/html/stc/misc/upload/customer/faq/image";

		$conf_file['upload_path'] = $upload_dir;
		$conf_file['allowed_types'] = 'gif|jpg|png|jpeg';
		$conf_file['max_size'] = '3000';
		$conf_file['max_width']  = '1024';
		$conf_file['max_height']  = '500';
		$conf_file['overwrite']  = false;
		$conf_file['encrypt_name']  = true;
		$conf_file['remove_spaces']  = true;

		$this->load->library( 'upload', $conf_file );
		
		if( $this->upload->do_upload('upload') ) {
			$CKEditorFuncNum = $this->input->get('CKEditorFuncNum');

			$data = $this->upload->data();
			$filename = $data['file_name'];
			$url = "/misc/upload/customer/faq/image/".$filename;
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('".$CKEditorFuncNum."', '".$url."', '전송에 성공했습니다.')</script>";
		} else {
			echo "<script>alert('업로드에 실패했습니다.".$this->upload->display_errors('','')."')</script>";
			exit;
		}	
	}

	// FAQ 쓰기 뷰
	function faq_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
		$this->load->view( 'faq_input', $data );
	}

	// FAQ 보기/수정 뷰
	function faq_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
//		$user_id = $this->idx;
		
		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );
		
		$data['view_val'] = $this->STC_Board->faq_view($seq);
		$data['seq'] = $seq;
		
		if($mode == "view") {
			$this->load->view( 'faq_view', $data );
		} else {
			$this->load->view( 'faq_modify', $data );
		}
	}
	
	// FAQ 삭제
	function faq_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		$this->load->model( 'STC_Board' );
		$seq = $this->input->get( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_Board->faq_delete($seq);
		} 
		
		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/board/faq_list'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}

	//건의사항 리스트(공통)
	function suggest_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
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
		
		if(isset($_GET['search1'])) { 
			$search1 = $_GET['search1'];
		} 
		else { 
			$search1 = "";
		}

		if(isset($_GET['search2'])) { 
			$search2 = $_GET['search2'];
		} 
		else { 
			$search2 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;
		$data['search2'] = $search2;
		
		if  ( $cur_page <= 0 )
			$cur_page = 1;
		
		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Board->suggest_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Board->suggest_list_count($search_keyword, $search1, $search2)->ucount;
		
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
		
		$this->load->view( 'suggest_list', $data );
	}
	
	// 건의사항 첨부파일 다운로드처리
	function suggest_download($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		$this->load->Model('STC_Board');

		ini_set('memory_limit', '200M'); // 김수성 수정 2017-01-04 

		$fdata = $this->STC_Board->suggest_file($seq, $filelcname);

		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/customer/suggest/".$fdata['file_changename']);
		
		if (!force_download(urlencode($fdata['file_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 건의사항 첨부파일 삭제처리
	function suggest_filedel($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		$this->load->Model('STC_Board');
		
		$fdata = $this->STC_Board->suggest_file($seq, $filelcname);
		
		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		} else {
			$fdata2 = $this->STC_Board->suggest_filedel($seq);
			if($fdata2) {
				unlink("/var/www/html/stc/misc/upload/customer/suggest/".$fdata['file_changename']);
			}
			alert('파일이 정상적으로 삭제되었습니다.', site_url().'/board/suggest_view?seq='.$seq.'&mode=modify');
		}
	}
	

	//건의사항 입력/수정 처리
	function suggest_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->model( 'STC_Board' );
		$seq = $this->input->post('seq');

		$filename = NULL;
		$lcfilename = NULL;
		
		$csize = $_FILES["cfile"]["size"];
		$cname = $_FILES["cfile"]["name"];
		$ext = substr(strrchr($cname,"."),1);
		$ext = strtolower($ext);	
		
		if ($csize > 0 && $cname) {
			if ($csize > 104857600) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n100MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>"; /* 김수성 수정 2017-01-06 */
				exit;
			}
			
			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}
			
			$upload_dir = "/var/www/html/stc/misc/upload/customer/suggest";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'hwp|zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );
			
			if( $this->upload->do_upload('cfile') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}
			$data = array(
				'category_code' => $this->input->post('category_code'),
				'subject' => addslashes($this->input->post('subject')),
				'contents' => $this->input->post('contents'),
				'user_id' => $this->id,
				'user_name' => $this->name,
				'file_changename' => $lcfilename,
				'file_realname' => $filename,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			 );
		} else {
			$data = array(
				'category_code' => $this->input->post('category_code'),
				'subject' => addslashes($this->input->post('subject')),
				'contents' => $this->input->post('contents'),
				'user_id' => $this->id,
				'user_name' => $this->name,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			 );
		}
		
		if ($seq == null) {
			$result = $this->STC_Board->suggest_insert($data, $mode = 0);
		} else {
			$result = $this->STC_Board->suggest_insert($data, $mode = 1, $seq);
		}
		
		if($result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/board/suggest_list'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
		
	}
	
	//건의사항 입력/수정시 ckeditor 이미지 본문삽입 처리
	function suggest_input_action_image() {
		$this->load->model( 'STC_Board' );	
		$upload_dir = "/var/www/html/stc/misc/upload/customer/suggest/image";

		$conf_file['upload_path'] = $upload_dir;
		$conf_file['allowed_types'] = 'gif|jpg|png|jpeg';
		$conf_file['max_size'] = '3000';
		$conf_file['max_width']  = '1024';
		$conf_file['max_height']  = '500';
		$conf_file['overwrite']  = false;
		$conf_file['encrypt_name']  = true;
		$conf_file['remove_spaces']  = true;

		$this->load->library( 'upload', $conf_file );
		
		if( $this->upload->do_upload('upload') ) {
			$CKEditorFuncNum = $this->input->get('CKEditorFuncNum');

			$data = $this->upload->data();
			$filename = $data['file_name'];
			$url = "/misc/upload/customer/suggest/image/".$filename;
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('".$CKEditorFuncNum."', '".$url."', '전송에 성공했습니다.')</script>";
		} else {
			echo "<script>alert('업로드에 실패했습니다.".$this->upload->display_errors('','')."')</script>";
			exit;
		}	
	}

	// 건의사항 쓰기 뷰
	function suggest_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
		$this->load->view( 'suggest_input', $data );
	}

	// 건의사항 보기/수정 뷰
	function suggest_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
//		$user_id = $this->idx;
		
		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );
		
		$data['view_val'] = $this->STC_Board->suggest_view($seq);
		$data['seq'] = $seq;
		
		if($mode == "view") {
			$this->load->view( 'suggest_view', $data );
		} else {
			$this->load->view( 'suggest_modify', $data );
		}
	}
	
	// 건의사항 삭제
	function suggest_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		$this->load->model( 'STC_Board' );
		$seq = $this->input->get( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_Board->suggest_delete($seq);
		} 
		
		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/board/suggest_list'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}

	//QnA 리스트(공통)
	function qna_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
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
		
		if(isset($_GET['search1'])) { 
			$search1 = $_GET['search1'];
		} 
		else { 
			$search1 = "";
		}

		if(isset($_GET['search2'])) { 
			$search2 = $_GET['search2'];
		} 
		else { 
			$search2 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;
		$data['search2'] = $search2;
		
		if  ( $cur_page <= 0 )
			$cur_page = 1;
		
		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Board->qna_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Board->qna_list_count($search_keyword, $search1, $search2)->ucount;
		
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
		
		$this->load->view( 'qna_list', $data );
	}
	
	// QnA 첨부파일 다운로드처리
	function qna_download($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		$this->load->Model('STC_Board');

		
		ini_set('memory_limit', '200M'); // 김수성 수정 2017-01-04 

		$fdata = $this->STC_Board->qna_file($seq, $filelcname);

		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/customer/qna/".$fdata['file_changename']);
		
		if (!force_download(urlencode($fdata['file_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// QnA 첨부파일 삭제처리
	function qna_filedel($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		$this->load->Model('STC_Board');
		
		$fdata = $this->STC_Board->qna_file($seq, $filelcname);
		
		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		} else {
			$fdata2 = $this->STC_Board->qna_filedel($seq);
			if($fdata2) {
				unlink("/var/www/html/stc/misc/upload/customer/qna/".$fdata['file_changename']);
			}
			alert('파일이 정상적으로 삭제되었습니다.', site_url().'/board/qna_view?seq='.$seq.'&mode=modify');
		}
	}
	

	//QnA 입력/수정 처리
	function qna_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->model( 'STC_Board' );
		$seq = $this->input->post('seq');

		$filename = NULL;
		$lcfilename = NULL;
		
		$csize = $_FILES["cfile"]["size"];
		$cname = $_FILES["cfile"]["name"];
		$ext = substr(strrchr($cname,"."),1);
		$ext = strtolower($ext);	
		
		if ($csize > 0 && $cname) {
			if ($csize > 104857600) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n100MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>"; /* 김수성 수정 2017-01-06 */
				exit;
			}
			
			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}
			
			$upload_dir = "/var/www/html/stc/misc/upload/customer/qna";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );
			if ( ! $this->upload->do_upload())
			{
			$error = array('error' => $this->upload->display_errors());
			
			$this->load->view('upload_form', $error);
			}else if( $this->upload->do_upload('cfile') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}
			$data = array(
				'category_code' => $this->input->post('category_code'),
				'subject' => addslashes($this->input->post('subject')),
				'contents' => $this->input->post('contents'),
				'user_id' => $this->id,
				'user_name' => $this->name,
				'user_email' => $this->email,//김수성추가 161226
				'file_changename' => $lcfilename,
				'file_realname' => $filename,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			 );
		} else {
			$data = array(
				'category_code' => $this->input->post('category_code'),
				'subject' => addslashes($this->input->post('subject')),
				'contents' => $this->input->post('contents'),
				'user_id' => $this->id,
				'user_name' => $this->name,
				'user_email' => $this->email,//김수성추가 161226
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			 );
		}
		// 메일발송-김수성수정-161228
		$to_email = "tech@durianit.co.kr";									//	받을 사람 email
		$from_email = $this->email;								//	보내는 사람 email
		$mail_subject = "[QnA]제목:";
		$mail_subject = $mail_subject.$data['subject'];		//	메일 제목
		$mail_content = "QnA에 글이 등록되었습니다. 내용은 아래와 같습니다.<br/>\n<br/>\n";
		$mail_content = $mail_content."===============================";
		$mail_content = $mail_content.$data['contents'];
		$mailresult = $this->_send_content( $to_email, $from_email, $mail_subject, $mail_content );
		// 메일발송 끝

		if  ( !$mailresult ){
				echo "<script>alert('이메일 보내기가 실패했습니다.');history.go(-1);</script>";
			}

		if ($seq == null) {
			$result = $this->STC_Board->qna_insert($data, $mode = 0);
		} else {
			$result = $this->STC_Board->qna_insert($data, $mode = 1, $seq);
		}
	
		if($result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/board/qna_list'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
		
		
	}
	
	//QnA 입력/수정시 ckeditor 이미지 본문삽입 처리
	function qna_input_action_image() {
		$this->load->model( 'STC_Board' );	
		$upload_dir = "/var/www/html/stc/misc/upload/customer/qna/image";

		$conf_file['upload_path'] = $upload_dir;
		$conf_file['allowed_types'] = 'gif|jpg|png|jpeg';
		$conf_file['max_size'] = '3000';
		$conf_file['max_width']  = '1024';
		$conf_file['max_height']  = '500';
		$conf_file['overwrite']  = false;
		$conf_file['encrypt_name']  = true;
		$conf_file['remove_spaces']  = true;

		$this->load->library( 'upload', $conf_file );
		
		if( $this->upload->do_upload('upload') ) {
			$CKEditorFuncNum = $this->input->get('CKEditorFuncNum');

			$data = $this->upload->data();
			$filename = $data['file_name'];
			$url = "/misc/upload/customer/qna/image/".$filename;
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('".$CKEditorFuncNum."', '".$url."', '전송에 성공했습니다.')</script>";
		} else {
			echo "<script>alert('업로드에 실패했습니다.".$this->upload->display_errors('','')."')</script>";
			exit;
		}	
	}

	// QnA 쓰기 뷰
	function qna_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
		$this->load->view( 'qna_input', $data );
	}

	// QnA 보기/수정 뷰
	function qna_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
//		$user_id = $this->idx;
		
		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );
		
		$data['view_val'] = $this->STC_Board->qna_view($seq);
		$data['clist_val'] = $this->STC_Board->qna_comment_list($seq);

//		print "<pre>";
//		print_r($data['clist_val']);
//		print "</pre>";
//		exit;

		$data['seq'] = $seq;
		
		if($mode == "view") {
			$this->load->view( 'qna_view', $data );
		} else {
			$this->load->view( 'qna_modify', $data );
		}
	}
	
	// QnA 삭제
	function qna_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		$this->load->model( 'STC_Board' );
		$seq = $this->input->get( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_Board->qna_delete($seq);
		} 
		
		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/board/qna_list'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}
	
	//QnA 코멘트 등록 처리
	function qna_comment_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}
		$this->load->Model(array('STC_Board', 'STC_Common'));
		
		$data = array(
			'bbs_seq' => $this->input->post('seq'),
			'user_id' => $this->id,
			'user_name' => $this->name,
			'user_email' => $this->email, // 메일발송용/김수성수정-161228
			'contents' => $this->input->post('comment'),
			'insert_date' => date("Y-m-d H:i:s")
		);

		// 메일발송
		$seq1 = $data['bbs_seq'];
		$test = $this->STC_Board->qna_get_email($seq1);
		foreach ($test as $row)
		{	$row['user_email']; $row['subject']; }
		$to_email = $row['user_email'];
		$from_email = $this->email;
		$mail_subject = "[Durianit-QnA답글]요청질문:".$row['subject'];
		$mail_content = "요청 주신 QnA에 대한 답글이 등록되었습니다. 내용은 아래와 같습니다.<br/>\n<br/>\n";
		$mail_content = $mail_content."===============================<br/>\n";
		$mail_content = $mail_content.$data['contents'];
		$mailresult = $this->_send_comment( $to_email, $from_email, $mail_subject, $mail_content );

		if  ( !$mailresult ){
		echo "<script>alert('이메일 보내기가 실패했습니다.');history.go(-1);</script>";
		}

		$result = $this->STC_Board->qna_comment_insert($data);
		$result2 = $this->STC_Board->qna_cnum_update($this->input->post('seq'));
		
		if($result && $result2) {
			echo "<script>alert('정상적으로 처리되었습니다.');history.go(-1);</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	
		
	}

	// QnA 코멘트 삭제처리
	function qna_comment_delete() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		$this->load->model( 'STC_Board' );
		$seq = $this->input->post( 'seq' );
		$cseq = $this->input->post( 'cseq' );
		
		if ($seq != null && $cseq != null) {
			$tdata = $this->STC_Board->qna_comment_delete($seq, $cseq);
			$result = $this->STC_Board->qna_cnum_update2($this->input->post('seq'));
		} 
		
		if ($tdata && $result) {
			echo "<script>alert('삭제완료 되었습니다.');history.go(-1);</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}

	//교육&행사 리스트(공통)
	function eduevent_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
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
		
		if(isset($_GET['search1'])) { 
			$search1 = $_GET['search1'];
		} 
		else { 
			$search1 = "";
		}

		if(isset($_GET['search2'])) { 
			$search2 = $_GET['search2'];
		} 
		else { 
			$search2 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;
		$data['search2'] = $search2;
		
		if  ( $cur_page <= 0 )
			$cur_page = 1;
		
		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Board->eduevent_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Board->eduevent_list_count($search_keyword, $search1, $search2)->ucount;
		
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
		
		$this->load->view( 'eduevent_list', $data );
	}
	
	// 교육&행사 첨부파일 다운로드처리
	function eduevent_download($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		$this->load->Model('STC_Board');

		ini_set('memory_limit', '200M'); // 김수성 수정 2017-01-04 


		$fdata = $this->STC_Board->eduevent_file($seq, $filelcname);

		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/customer/eduevent/".$fdata['file_changename']);
		
		if (!force_download(urlencode($fdata['file_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 교육&행사 첨부파일 삭제처리
	function eduevent_filedel($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		$this->load->Model('STC_Board');
		
		$fdata = $this->STC_Board->eduevent_file($seq, $filelcname);
		
		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		} else {
			$fdata2 = $this->STC_Board->eduevent_filedel($seq);
			if($fdata2) {
				unlink("/var/www/html/stc/misc/upload/customer/eduevent/".$fdata['file_changename']);
			}
			alert('파일이 정상적으로 삭제되었습니다.', site_url().'/board/eduevent_view?seq='.$seq.'&mode=modify');
		}
	}
	

	//교육&행사 입력/수정 처리
	function eduevent_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->model( 'STC_Board' );
		$seq = $this->input->post('seq');

		$filename = NULL;
		$lcfilename = NULL;
		
		$csize = $_FILES["cfile"]["size"];
		$cname = $_FILES["cfile"]["name"];
		$ext = substr(strrchr($cname,"."),1);
		$ext = strtolower($ext);	
		
		if ($csize > 0 && $cname) {
			if ($csize > 104857600) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n100MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>"; /* 김수성 수정 2017-01-06 */
				exit;
			}
			
			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}
			
			$upload_dir = "/var/www/html/stc/misc/upload/customer/eduevent";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );
			
			if( $this->upload->do_upload('cfile') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}
			$data = array(
				'category_code' => $this->input->post('category_code'),
				'subject' => addslashes($this->input->post('subject')),
				'contents' => $this->input->post('contents'),
				'user_id' => $this->id,
				'user_name' => $this->name,
				'file_changename' => $lcfilename,
				'file_realname' => $filename,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			 );
		} else {
			$data = array(
				'category_code' => $this->input->post('category_code'),
				'subject' => addslashes($this->input->post('subject')),
				'contents' => $this->input->post('contents'),
				'user_id' => $this->id,
				'user_name' => $this->name,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			 );
		}
		
		if ($seq == null) {
			$result = $this->STC_Board->eduevent_insert($data, $mode = 0);
		} else {
			$result = $this->STC_Board->eduevent_insert($data, $mode = 1, $seq);
		}
		
		if($result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/board/eduevent_list'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
		
	}
	
	//교육&행사 입력/수정시 ckeditor 이미지 본문삽입 처리
	function eduevent_input_action_image() {
		$this->load->model( 'STC_Board' );	
		$upload_dir = "/var/www/html/stc/misc/upload/customer/eduevent/image";

		$conf_file['upload_path'] = $upload_dir;
		$conf_file['allowed_types'] = 'gif|jpg|png|jpeg';
		$conf_file['max_size'] = '3000';
		$conf_file['max_width']  = '1024';
		$conf_file['max_height']  = '500';
		$conf_file['overwrite']  = false;
		$conf_file['encrypt_name']  = true;
		$conf_file['remove_spaces']  = true;

		$this->load->library( 'upload', $conf_file );
		
		if( $this->upload->do_upload('upload') ) {
			$CKEditorFuncNum = $this->input->get('CKEditorFuncNum');

			$data = $this->upload->data();
			$filename = $data['file_name'];
			$url = "/misc/upload/customer/eduevent/image/".$filename;
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('".$CKEditorFuncNum."', '".$url."', '전송에 성공했습니다.')</script>";
		} else {
			echo "<script>alert('업로드에 실패했습니다.".$this->upload->display_errors('','')."')</script>";
			exit;
		}	
	}

	// 교육&행사 쓰기 뷰
	function eduevent_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
		$this->load->view( 'eduevent_input', $data );
	}

	// 교육&행사 보기/수정 뷰
	function eduevent_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
//		$user_id = $this->idx;
		
		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );
		
		$data['view_val'] = $this->STC_Board->eduevent_view($seq);
		$data['clist_val'] = $this->STC_Board->eduevent_comment_list($seq);

//		print "<pre>";
//		print_r($data['clist_val']);
//		print "</pre>";
//		exit;

		$data['seq'] = $seq;
		
		if($mode == "view") {
			$this->load->view( 'eduevent_view', $data );
		} else {
			$this->load->view( 'eduevent_modify', $data );
		}
	}
	
	// 교육&행사 삭제
	function eduevent_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		$this->load->model( 'STC_Board' );
		$seq = $this->input->get( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_Board->eduevent_delete($seq);
		} 
		
		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/board/eduevent_list'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}
	
	//교육&행사 코멘트 등록 처리
	function eduevent_comment_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->Model(array('STC_Board', 'STC_Common'));
		
		$data = array(
			'bbs_seq' => $this->input->post('seq'),
			'user_id' => $this->id,
			'user_name' => $this->name,
			'contents' => $this->input->post('comment'),
			'insert_date' => date("Y-m-d H:i:s")
		);
		
		$result = $this->STC_Board->eduevent_comment_insert($data);
		$result2 = $this->STC_Board->eduevent_cnum_update($this->input->post('seq'));
		
		if($result && $result2) {
			echo "<script>alert('정상적으로 처리되었습니다.');history.go(-1);</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
		
	}

	// 교육&행사 코멘트 삭제처리
	function eduevent_comment_delete() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		$this->load->model( 'STC_Board' );
		$seq = $this->input->post( 'seq' );
		$cseq = $this->input->post( 'cseq' );
		
		if ($seq != null && $cseq != null) {
			$tdata = $this->STC_Board->eduevent_comment_delete($seq, $cseq);
			$result = $this->STC_Board->eduevent_cnum_update2($this->input->post('seq'));
		} 
		
		if ($tdata && $result) {
			echo "<script>alert('삭제완료 되었습니다.');history.go(-1);</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}
}
?>
