<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Board extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->lv = $this->phpsession->get( 'lv', 'stc',);

		$this->load->Model( array( 'sales/STC_Board', 'STC_Common' ) );
	}

	function notice_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		} else {
			$cur_page = 0;
		}
		$no_page_list = 10;

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

		if(issert($_GET['search2'])) {
			$search2 = $_GET['search2'];
		} else {
			$search2 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;
		$data['search2'] = $search2;

		if ($cur_page <= 0) {
			$cur_page = 1;
		}

		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Board->notice_list($search_keyword, $search1, $search2, ( $cur_page -1 ), * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Board->notice_list_count($search_keyword, $search1, $search2)->ucount;

		$data['list_val'] = $user_list_data['data'];
		$data['list_val_count'] = $user_list_data['count'];

		$total_page = 1;
		if ($data['count'] % $no_page_list == 0) {
			$total_page = floor( ( $data['count'] / $no_page_list ) );
		} else {
			$total_page = floor( ( $data['count'] / $no_page_list + 1 ) );
		}

		$start_page = floor( ( $cur_page - 1 ) / 10 ) * 10 + 1;
		$end_page = 0;
		if ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
			$end_page = ( floor( ( $cur_page - 1 ) /10 ) + 1 ) * 10;
		} else {
			$end_page = $total_page;
		}

		$data['category'] = $this->STC_Common->get_category();

		$data['no_page_list'] = $no_page_list;
		$data['total_page'] = $total_page;
		$data['start_page'] = $start_page;
		$data['end_page'] = $end_page;

		$this->load->view( 'sales/notice_list', $data );
	}

	function notice_download($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');

		$fdata = $this->STC_Board->notice_file($seq, $filelcname);

		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/sales/notice/".$fdata['file_changename']);

		if (!force_download(urlencode($fdata['file_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	function notice_filedel($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');

		$fdata = $this->STC_Board->notice_file($seq, $filelcname);

		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		} else {
			$fdata2 = $this->STC_Board->notice_filedel($seq);
			if($fdata2) {
				unlink("/var/www/html/stc/misc/upload/sales/notice/".$fdata['file_changename']);
			}
			alert('파일이 정상적으로 삭제되었습니다.', site_url().'/sales/board/notice_view?seq='.$seq.'&mode=modify');
		}
	}

	function notice_input_action() {
		if ( $this->id === null ) {
			redirect( 'account' );
		}

		$seq = $this->input->post('seq');

		$filename = NULL;
		$lcfilename = NULL;

		$csize = $_FILES["cfile"]["size"];
		$cname = $_FILES["cfile"]["name"];
		$ext = substr(strrchr($cname,"."),1);
		$ext = strtolower($ext);

		if ($csize > 0 && $cname) {
			if($csize > 104857600) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다. \\n100MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
				exit;
			}

			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}

			$upload_dir = "/var/www/html/stc/misc/upload/sales/notice";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite'] = false;
			$conf_file['encrypt_name'] = true;
			$conf_file['remove_spaces'] = true;

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
				'category_code'   => $this->input->post('category_code');
				'subject'         => addslashes($this->input->post('subject')),
				'contents'        => $this->input->post('contents'),
				'user_id'         => $this->id,
				'user_name'       => $this->name,
				'file_changename' => $lcfilename,
				'file_realname'   => $filename,
				'insert_date'     => date("Y-m-d H:i:s"),
				'update_date'     => date("Y-m-d H:i:s")
			);
		} else {
			$data = array(
				'category_code' => $this->input->post('category_code'),
				'subject'       => addslashes($this->input->post('subject')),
				'contents'      => $this->input->post('contents'),
				'user_id'       => $this->id,
				'user_name'     => $this->name,
				'insert_date'   => date("Y-m-d H:i:s"),
				'update_date'   => date("Y-m-d H:i:s")
			);
		}

		if ($seq == null) {
			$result = $this->STC_Board->notice_insert($data, $mode = 0);
		} else {
			$result = $this->STC_Board->notice_insert($data, $mode = 1, $seq);
		}

		if($result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/board/notice_list'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	}

	function notice_input_action_image() {
		$upload_dir = "/var/www/html/stc/misc/upload/sales/notice/image";

		$conf_file['upload_path'] = $upload_dir;
		$conf_file['allowed_types'] = 'gif|jpg|png|jpeg';
		$conf_file['max_size'] = '3000';
		$conf_file['max_width'] = '1024';
		$conf_file['max_height'] = '500';
		$conf_file['overwrite'] = false;
		$conf_file['encrypt_name'] = true;
		$conf_file['remove_spaces'] = true;

		$this->load->library( 'upload', $conf_file );

		if( $this->upload->do_upload('upload') ) {
			$CKEditorFuncNum = $this->input->get('CKEditorFuncNum');

			$data = $this->upload->data();
			$filename = $data['file_name'];
			$url = "/misc/upload/sales/notice/image/".$filename;
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('".$CKEditorFuncNum."', '".$url."', '전송에 성공했습니다.')</script>";
		} else {
			echo "<script>alert('업로드에 실패했습니다.".$this->upload->display_errors('','')."')</script>";
			exit;
		}
	}

	function notice_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$data['category'] = $this->STC_Common->get_category();
		$this->load->view( 'sales/notice_input', $data );
	}

	function notice_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$data['category'] = $this->STC_Common->get_category();

		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );

		$data['view_val'] = $this->STC_Board->notice_view($seq);
		$data['seq'] = $seq;

		if($mode == 'view') {
			$this->load->view( 'sales/notice_view', $data );
		} else {
			$this->load->view( 'sales/notice_modify', $data );
		}
	}

	function notice_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');

		$seq = $this->input->get( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_Board->notice_delete($seq);
		}

		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/sales/board/notice_list'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}

	function manual_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		} else {
			$cur_page = 0;
		}
		$no_page_list = 10;

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

		if(isset($_GET['search2'])) {
			$search2 = $_GET['search2'];
		} else {
			$search2 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;
		$data['search2'] = $search2;

		if ( $cur_page <= 0 ) {
			$cur_page = 1;
		}

		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Board->manual_list($search_keyword, $search1, $search2, ( $cur_page -1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Board->manual_list_count($search_keyword, $search1, $search2)->ucount;

		$data['list_val'] = $user_list_data['data'];
		$data['list_val_count'] = $user_list_data['count'];

		$total_page = 1;
		if ( $data['count'] % $no_page_list == 0 ) {
			$total_page = floor( ( $data['count'] / $no_page_list ) );
		} else {
			$total_page = floor( ( $data['count'] / $no_page_list + 1 ) );
		}

		$start_page = floor( ( $cur_page - 1 ) / 10 ) * 10 + 1;
		$end_page = 0;
		if ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ) {
			$end_page = ( floor( ( $cur_page - 1 ) / 10 ) + 1 ) * 10;
		} else {
			$end_page = $total_page;
		}

		$data['category'] = $this->STC_Common->get_category();

		$data['no_page_list'] = $no_page_list;
		$data['total_page'] = $total_page;
		$data['start_page'] = $start_page;
		$data['end_page'] = $end_page;

		$this->load->view( 'sales/manual_list', $data );
	}

	function manual_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$seq  = $this->input->post('seq');
		$type = $this->input->post('type');

		$file_count = $_POST['file_length'];
		if($type == 1){
			$file_realname   = '';
			$file_changename = '';
		} else {
			$file_realname   = $_POST['file_realname'];
			$file_changename = $_POST['file_changename'];
		}

		if($file_count > 0) {
			for($i=0; $i<$file_count; $i++) {
				$f     = "files".$i;
				$cname = $_FILES[$f]["name"];
				$ext   = substr(strrchr($cname,"."),1);
				$ext   = strtolower($ext);

				$upload_dir = "/var/www/html/stc/misc/upload/sales/manual";

				$conf_file['upload_path']   = $upload_dir;
				$conf_file['allowed_types'] = '*';
				$conf_file['overwrite']     = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces'] = true;

				$this->load->library( 'upload', $conf_file );
				$result = $this->upload->do_upload($f);
				if($result) {
					$file_data = array( 'uplaod_data' => $this->upload->data() );
					$file_realname   .= '*/*'.$file_data['upload_data']['orig_name'];
					$file_changename .= '*/*'.$file_data['upload_data']['file_name'];
				} else {
					echo json_encode(false);
					exit;
				}
			}
			$file_realname = trim($file_realname, '*/*');
			$file_changename = trim($file_changename, '*/*');

			$data = array(
				'category_code'   => $this->input->post('category_code'),
				'subject'         => addslashes($this->input->post('subject')),
				'contents'        => $this->input->post('contents'),
				'user_id'         => $this->id,
				'user_name'       => $this->name,
				'file_changename' => $file_changename,
				'file_realname'   => $file_realname,
				'insert_date'     => date("Y-m-d H:i:s"),
				'update_date'     => date("Y-m-d H:i:s")
			);
		} else {
			$data = array(
				'category_code'   => $this->input->post('category_code'),
				'subject'         => addslashes($this->input->post('subject')),
				'contents'        => $this->input->post('contents'),
				'user_id'         => $this->id,
				'user_name'       => $this->name,
				'file_changename' => $file_changename,
				'file_realname'   => $file_realname,
				'insert_date'     => date("Y-m-d H:i:s"),
				'update_date'     => date("Y-m-d H:i:s")
			);
		}

		if ($seq == null) {
			$result = $this->STC_Board->manual_insert($data, $mode = 0);
		} else {
			$result = $this->STC_Board->manual_insert($data, $mode = 1, $seq);
		}

		if($result) {
			echo json_encode(true);
		} else {
			echo json_encode(false);
		}
	}

	function manual_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$data['category'] = $this->STC_Common->get_category();
		$this->load->view( 'sales/manual_input', $data );
	}

	function manual_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$data['category'] = $this->STC_Common->get_category();

		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );

		$data['view_val'] = $this->STC_Board->manual_view($seq);
		$data['seq'] = $seq;

		if($mode == "view") {
			$this->load->view( 'sales/manual/view', $data );
		} else {
			$this->load->view( 'sales/manual_modify', $data );
		}
	}

	function manual_delete_action() {
		if( $this->id === null ){
			redirect( 'account' );
		}

		$this->load->helper('alert');
		$seq = $this->input->get( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_Board->manual_delete($seq);
		}

		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/sales/board/manual_list'</script>";
		} else {
			alert('정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.');
		}
	}

	function edudata_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		} else {
			$cur_page = 0;
		}
		$no_page_list = 10;

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

		if(isset($_GET['search2'])) {
			$search2 = $_GET['search2'];
		} else {
			$search2 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;
		$data['search2'] = $search2;

		if ( $cur_page <= 0 ) {
			$cur_page = 1;
		}

		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Board->edudata_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Board->edudata_list_count($search_keyword, $search1, $search2)->ucount;

		$data['list_val'] = $user_list_data['data'];
		$data['list_val_count'] = $user_list_data['count'];

		$total_page = 1;
		if ( $data['count'] % $no_page_list == 0 ) {
			$total_page = floor( ( $data['count'] / $no_page_list ) );
		} else {
			$total_page = floor( ( $data['count'] / $no_page_list + 1 ) );
		}

		$start_page = floor( ( $cur_page - 1 ) / 10 ) * 10 + 1;
		$end_page = 0;
		if ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ) {
			$end_page = ( floor( ( $cur_page - 1 ) / 10 ) + 1 ) * 10;
		} else {
			$end_page = $total_page;
		}

		$data['category'] = $this->STC_Common->get_category();

		$data['no_page_list'] = $no_page_list;
		$data['total_page'] = $total_page;
		$data['start_page'] = $start_page;
		$data['end_page'] = $end_page;

		$this->load->view( 'sales/edudata_list', $data );
	}

	function edudata_download($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');

		$fdata = $this->STC_Board->edudata_file($seq, $filelcname);

		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/sales/edudata/".$fdata['file_changename']);

		if (!force_download(urlencode($fdata['file_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	function edudata_filedel($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');

		$fdata = $this->STC_Board->edudata_file($seq, $filelcname);

		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		} else {
			$fdata2 = $this->STC_Board->edudata_filedel($seq);
			if($fdata2) {
				unlink("/var/www/html/stc/misc/upload/sales/edudata/".$fdata['file_changename']);
			}
			alert('파일이 정상적으로 삭제되었습니다.', site_url().'/sales/board/edudata_view?seq='.$seq.'&mode=modify');
		}
	}

}
 ?>
