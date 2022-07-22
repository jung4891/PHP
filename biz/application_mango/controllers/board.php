<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Board extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'mango' );
		$this->name = $this->phpsession->get( 'name', 'mango' );
		$this->seq = $this->phpsession->get( 'seq', 'mango' );
		$this->admin = $this->phpsession->get( 'admin', 'mango' );

		$this->load->Model(array('STC_Board', 'STC_Common'));
		$this->load->library('user_agent');
	}

	//공지사항 리스트(공통)
	function notice_list() {
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

		$user_list_data = $this->STC_Board->notice_list($search_keyword, $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Board->notice_list_count($search_keyword, $search1)->ucount;

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

		$this->load->view( 'notice/notice_list', $data );
	}

	function notice_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$seq = $this->input->get('seq');
		$mode = $this->input->get('mode');

		$data['view_val'] = $this->STC_Board->notice_view($seq);
		$data['seq'] = $seq;

		$read = array(
			'target'    => 'notice',
			'table_seq' => $seq,
			'user_seq'  => $this->seq
		);
		$this->STC_Common->board_read_insert($read);

		if($mode == 'view') {
			$this->load->view( 'notice/notice_view', $data );
		} else {
			$this->load->view( 'notice/notice_modify', $data );
		}
	}

	// 공지사항 쓰기 뷰
	function notice_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->view( 'notice/notice_input');
	}

	//공지사항 입력/수정 처리
	function notice_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$seq = $this->input->post('seq');
		$type = $this->input->post( 'type' );


		$file_count = $_POST['file_length'];
		if($type == 1){
				$file_realname='';
				$file_changename='';
		}else{
				$file_realname = $_POST['file_realname'];
				$file_changename = $_POST['file_changename'];
		}

		if($file_count > 0){
			for($i=0; $i<$file_count; $i++){
				// $csize = $_FILES["files".$i]["size"];
				$f = "files".$i;
				$cname = $_FILES[$f]["name"];
				$ext = substr(strrchr($cname,"."),1);
				$ext = strtolower($ext);
				// if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp" && $ext != "xlsm") {
				//     echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				//     exit;
				// }
				$upload_dir = "/var/www/html/stc/misc/upload_mango/notice";
				// $upload_dir = "c:/xampp/htdocs/biz/misc/upload_mango/notice";
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = '*';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library('upload', $conf_file );
				$result = $this->upload->do_upload($f);
				if($result) {
						$file_data = array('upload_data' => $this->upload->data());
						$file_realname .= '*/*'.$file_data['upload_data']['orig_name'];
						$file_changename .= '*/*'.$file_data['upload_data']['file_name'];
				} else {
						// alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
						echo json_encode(false);
						exit;
				}
			}
			$file_realname = trim($file_realname,'*/*');
			$file_changename = trim($file_changename,'*/*');

			$data = array(
				'subject'         => addslashes($this->input->post('subject')),
				'contents'        => $this->input->post('contents'),
				'user_id'         => $this->id,
				'user_name'       => $this->name,
				'file_changename' => $file_changename,
				'file_realname'   => $file_realname,
				'update_date'     => date('Y-m-d H:i:s')
			);

		} else {
			$data = array(
				'subject'         => addslashes($this->input->post('subject')),
				'contents'        => $this->input->post('contents'),
				'user_id'         => $this->id,
				'user_name'       => $this->name,
				'file_changename' => $file_changename,
				'file_realname'   => $file_realname,
				'update_date'     => date('Y-m-d H:i:s')
			 );
		}


			if ($seq == null) {
				$data['insert_date'] = date('Y-m-d H:i:s');
				$result = $this->STC_Board->notice_insert($data, $mode = 0);
			} else {
				$result = $this->STC_Board->notice_insert($data, $mode = 1, $seq);
			}

			if($result) {
					echo json_encode(true);
				} else {
					echo json_encode(false);
			}
	}

	// 공지사항 삭제
	function notice_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		// $this->load->Model( 'STC_Board' );
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

}
?>
