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
		$this->seq = $this->phpsession->get( 'seq', 'stc' );
		$this->group = $this->phpsession->get( 'group', 'stc' );
		$this->pGroupName = $this->phpsession->get( 'pGroupName', 'stc' );
		$this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );

		if($this->cooperation_yn == 'Y') {
			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
		}

		$this->load->Model(array('biz/STC_Board', 'STC_Common'));
		$this->load->library('user_agent');
	}

	//공지사항 리스트(공통)
	function notice_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$category= $_GET['category'];
		// $this->load->Model(array('STC_Board', 'STC_Common'));
//		$cur_page = $this->input->get( 'cur_page' );			//	현재 페이지
		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		} else {
			$cur_page = 0;
		}														//	현재 페이지
		$no_page_list = 10;										//	한페이지에 나타나는 목록 개수

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

		if(isset($_GET['hide_yn'])) {
			$hide_yn = $_GET['hide_yn'];
		} else {
			$hide_yn = 'N';
		}

		if(isset($_GET['temporary'])) {
			$temporary = $_GET['temporary'];
		} else {
			$temporary = 'N';
		}
		// echo $hide_yn;

		$data['temporary'] = $temporary;
		$data['hide_yn'] = $hide_yn;
		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;
		if  ( $cur_page <= 0 )
			$cur_page = 1;

		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Board->notice_list($category, $search_keyword, $search1, $hide_yn, $temporary, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Board->notice_list_count($category, $search_keyword, $search1, $hide_yn, $temporary)->ucount;

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

		// $data['category'] = $this->STC_Common->get_category();

		$data['no_page_list'] = $no_page_list;
		$data['total_page'] = $total_page;
		$data['start_page'] = $start_page;
		$data['end_page'] = $end_page;

		$data['category'] = $category;

		if($this->agent->is_mobile()) {
			$data['title'] = "공지사항";
			$this->load->view( 'biz/notice_list_mobile', $data );
		} else {
			$this->load->view( 'biz/notice_list', $data );
		}
	}

	//공지사항 입력/수정 처리
	function notice_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		if($this->agent->is_mobile()) {
			$is_mobile = 'Y';
		} else {
			$is_mobile = 'N';
		}
		// $this->load->Model( 'STC_Board' );
		$seq = $this->input->post('seq');
		$category_code = $this->input->post('category_code');
		$type = $this->input->post( 'type' );
		$hide_btn = $this->input->post('hide_btn'); // 숨김버튼 추가?
		if($hide_btn == '') {
			$hide_btn = 'N';
		}

		if($category_code == 001) { //운영공지 외에 임시저장 사용안함
			$temporary = $this->input->post('temporary');
		} else {
			$temporary = 'N';
		}

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
				$upload_dir = "/var/www/html/stc/misc/upload/sales/notice";
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
				'category_code'   => $category_code,
				'subject'         => addslashes($this->input->post('subject')),
				'contents'        => $this->input->post('contents'),
				'user_id'         => $this->id,
				'user_name'       => $this->name,
				'file_changename' => $file_changename,
				'file_realname'   => $file_realname,
				'insert_date'     => date("Y-m-d H:i:s"),
				'update_date'     => date("Y-m-d H:i:s"),
				'is_mobile'       => $is_mobile,
				'hide_btn'        => $hide_btn,
				'temporary'       => $temporary
			);

		} else {
			$data = array(
				'category_code'   => $category_code,
				'subject'         => addslashes($this->input->post('subject')),
				'contents'        => $this->input->post('contents'),
				'user_id'         => $this->id,
				'user_name'       => $this->name,
				'file_changename' => $file_changename,
				'file_realname'   => $file_realname,
				'insert_date'     => date("Y-m-d H:i:s"),
				'update_date'     => date("Y-m-d H:i:s"),
				'is_mobile'       => $is_mobile,
				'hide_btn'        => $hide_btn,
				'temporary'       => $temporary
			 );
		}


			if ($seq == null) {
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
// 개발부 내용 인서트
	function lab_input_action(){

			$notice_seq = $this->STC_Board->get_notice_seq();

			$dev_type = $this->input->post('dev_type');
			$page = $this->input->post('page');
			$r_date = $this->input->post('r_date');
			$receiver = $this->input->post('receiver');
			$develope = $this->input->post('develope');
			$request = $this->input->post('request');
			$plan = $this->input->post('plan');
			$c_date = $this->input->post('c_date');
			$complete = $this->input->post('complete');
			$tr_num = $this->input->post('tr_num');

			$insert_arr = array();
			// echo count($tr_num);
			for ($i=0; $i < count($tr_num); $i++) {
						$check_dev_type = $dev_type[$i] =="" ? null:$dev_type[$i];
						$check_page = $page[$i] =="" ? null:$page[$i];
						$check_r_date = $r_date[$i] =="" ? null:$r_date[$i];
						$check_receiver = $receiver[$i] =="" ? null:$receiver[$i];
						$check_develope = $develope[$i] =="" ? null:$develope[$i];
						$check_request = $request[$i] =="" ? null:$request[$i];
						$check_plan = $plan[$i] =="" ? null:$plan[$i];
						$check_c_date = $c_date[$i] =="" ? null:$c_date[$i];
						$check_complete = $complete[$i] =="" ? null:$complete[$i];
						$check_tr_num = $tr_num[$i]=="" ? null:$tr_num[$i];
					$contents_arr = array(
						'notice_seq' => $notice_seq,
						'dev_type' => $check_dev_type,
						'page' => $check_page,
						'receive_date' => $check_r_date,
						'receiver' => $check_receiver,
						'develope' => $check_develope,
						'request' => $check_request,
						'dev_plan' => $check_plan,
						'complete_date' =>$check_c_date,
						'complete_yn' =>$check_complete,
						'tr_index' =>$check_tr_num
					);
					array_push($insert_arr, $contents_arr);
			}
// var_dump($insert_arr);
				$result = $this->STC_Board->notice_insert_lab($insert_arr);
				if($result){
	        echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/biz/board/notice_list?category=002'</script>";
				}else{
					$this->STC_Board->notice_delete($notice_seq);
		      echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');location.href='".site_url()."/biz/board/notice_input_lab'</script>";
				}


}

function lab_modify_action(){
	$notice_seq = $this->input->post('notice_seq');
	// 기존꺼 수정
	$dev_type = $this->input->post('dev_type');
	$page = $this->input->post('page');
	$r_date = $this->input->post('r_date');
	$receiver = $this->input->post('receiver');
	$develope = $this->input->post('develope');
	$request = $this->input->post('request');
	$plan = $this->input->post('plan');
	$c_date = $this->input->post('c_date');
	$complete = $this->input->post('complete');
	$tr_num = $this->input->post('tr_num');
	$contents_seq = $this->input->post('contents_seq');

if(!empty($tr_num)){
		for ($i=0; $i <count($tr_num); $i++) {
			$check_dev_type = $dev_type[$i] =="" ? null:$dev_type[$i];
			$check_page = $page[$i] =="" ? null:$page[$i];
			$check_r_date = $r_date[$i] =="" ? null:$r_date[$i];
			$check_receiver = $receiver[$i] =="" ? null:$receiver[$i];
			$check_develope = $develope[$i] =="" ? null:$develope[$i];
			$check_request = $request[$i] =="" ? null:$request[$i];
			$check_plan = $plan[$i] =="" ? null:$plan[$i];
			$check_c_date = $c_date[$i] =="" ? null:$c_date[$i];
			$check_complete = $complete[$i] =="" ? null:$complete[$i];
			$check_tr_num = $tr_num[$i]=="" ? null:$tr_num[$i];

			$update_arr = array(
				'dev_type' => $check_dev_type,
				'page' => $check_page,
				'receive_date' => $check_r_date,
				'receiver' => $check_receiver,
				'develope' => $check_develope,
				'request' => $check_request,
				'dev_plan' => $check_plan,
				'complete_date' =>$check_c_date,
				'complete_yn' =>$check_complete,
				'tr_index' =>$check_tr_num
			);
			$con_seq = $contents_seq[$i];
			$result = $this->STC_Board->notice_content_update($update_arr, $con_seq);
			if(!$result){
				echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
				exit;
			}
		}
	}

	// 새로운거 추가
	$new_dev_type = $this->input->post('new_dev_type');
	$new_page = $this->input->post('new_page');
	$new_r_date = $this->input->post('new_r_date');
	$new_receiver = $this->input->post('new_receiver');
	$new_develope = $this->input->post('new_develope');
	$new_request = $this->input->post('new_request');
	$new_plan = $this->input->post('new_plan');
	$new_c_date = $this->input->post('new_c_date');
	$new_complete = $this->input->post('new_complete');
	$new_tr_num = $this->input->post('new_tr_num');
	if(!empty($new_tr_num)){
			$insert_arr = array();
			for ($i=0; $i <count($new_tr_num); $i++) {
				$new_check_dev_type = $new_dev_type[$i] =="" ? null:$new_dev_type[$i];
				$new_check_page = $new_page[$i] =="" ? null:$new_page[$i];
				$new_check_r_date = $new_r_date[$i] =="" ? null:$new_r_date[$i];
				$new_check_receiver = $new_receiver[$i] =="" ? null:$new_receiver[$i];
				$new_check_develope = $new_develope[$i] =="" ? null:$new_develope[$i];
				$new_check_request = $new_request[$i] =="" ? null:$new_request[$i];
				$new_check_plan = $new_plan[$i] =="" ? null:$new_plan[$i];
				$new_check_c_date = $new_c_date[$i] =="" ? null:$new_c_date[$i];
				$new_check_complete = $new_complete[$i] =="" ? null:$new_complete[$i];
				$new_check_tr_num = $new_tr_num[$i]=="" ? null:$new_tr_num[$i];

				$contents_arr = array(
					'notice_seq' => $notice_seq,
					'dev_type' => $new_check_dev_type,
					'page' => $new_check_page,
					'receive_date' => $new_check_r_date,
					'receiver' => $new_check_receiver,
					'develope' => $new_check_develope,
					'request' => $new_check_request,
					'dev_plan' => $new_check_plan,
					'complete_date' =>$new_check_c_date,
					'complete_yn' =>$new_check_complete,
					'tr_index' =>$new_check_tr_num
				);
				array_push($insert_arr, $contents_arr);
			}
			$result = $this->STC_Board->notice_insert_lab($insert_arr);
			if(!$result){
				echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
				exit;
			}
		}

		// 없어진거는 삭제
		$del_seq = $this->input->post('del_row_seq');
		if(!empty($del_seq) && $del_seq != ""){
			 $del_arr = explode("," , $del_seq);
			 for ($i=0; $i < count($del_arr) -1; $i++) {
				 $content_seq = $del_arr[$i];
				 $result3 = $this->STC_Board->notice_content_del($content_seq, 'contents');
				 if(!$result3){
					 echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
					 exit;
				 }
			 }
 	 }
	        echo "<script>alert('정상적으로 처리되었습니다.');history.go(-2);</script>";

}

function notice_lab_delete_action(){
	if( $this->id === null ) {
		redirect( 'account' );
	}

	$this->load->helper('alert');
	// $this->load->Model( 'STC_Board' );
	$seq = $this->input->get( 'seq' );
	$category = $this->input->get( 'category' );

	if ($seq != null) {
		$this->STC_Board->notice_content_del($seq, 'all');
		$tdata = $this->STC_Board->notice_delete($seq);
	}

	if ($tdata) {
		echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/biz/board/notice_list?category=".$category."'</script>";
	} else {
		alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
	}
}


	// 공지사항 쓰기 뷰
	function notice_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		if($this->agent->is_mobile()) {
			$data['title'] = '전체공지사항';
			$this->load->view( 'biz/notice_input_mobile', $data);
		} else {
			$this->load->view( 'biz/notice_input');
		}
	}

	// 공지사항 쓰기 뷰
	function notice_input_lab() {
		if( $this->id === null ) {
			redirect( 'account' );
		}
		$this->load->view( 'biz/notice_input_lab');
	}

	// 공지사항 보기/수정 뷰
	function notice_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );
		$category = $this->input->get( 'category' );

		$data['view_val'] = $this->STC_Board->notice_view($seq);
		$data['seq'] = $seq;
		$data['category'] = $category;

		$read_count = $this->STC_Board->notice_read_count($seq, $this->seq);
		if ($read_count['cnt'] == 0) {
			$read = array(
				'notice_seq' => $seq,
				'user_seq'   => $this->seq
			);
			$this->STC_Board->notice_read_insert($seq, $this->seq, $read);
		}

		if($mode == "view") {
			if($this->agent->is_mobile()) {
				$data['title'] = '전체공지사항';
				$this->load->view( 'biz/notice_view_mobile', $data );
			} else {
				$this->load->view( 'biz/notice_view', $data );
			}
		} else {
			if($this->agent->is_mobile()) {
				$data['title'] = '전체공지사항';
				$this->load->view( 'biz/notice_modify_mobile', $data );
			} else {
				$this->load->view( 'biz/notice_modify', $data );
			}
		}
	}

	function lab_notice_view(){
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );
		$category = $this->input->get( 'category' );
		$data['seq'] = $seq;
		$data['view_val'] = $this->STC_Board->notice_view($seq);
		$data['lab_val'] = $this->STC_Board->notice_view_lab($seq);
		$data['category'] = $category;
		$data['type_count'] = $this->STC_Board->notice_type_count($seq);

		$read_count = $this->STC_Board->notice_read_count($seq, $this->seq);
		if ($read_count['cnt'] == 0) {
			$read = array(
				'notice_seq' => $seq,
				'user_seq'   => $this->seq
			);
			$this->STC_Board->notice_read_insert($seq, $this->seq, $read);
		}


		if($mode == "view") {
			$this->load->view( 'biz/notice_view_lab', $data );

		} else {
			$this->load->view( 'biz/notice_modify_lab', $data );
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
		$category = $this->input->get( 'category' );

		if ($seq != null) {
			$tdata = $this->STC_Board->notice_delete($seq);
		}

		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/biz/board/notice_list?category=".$category."'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}

	function reader_list() {
		$notice_seq = $this->input->post('notice_seq');

		$result = $this->STC_Board->reader_list($notice_seq);

		echo json_encode($result);
	}


}
?>
