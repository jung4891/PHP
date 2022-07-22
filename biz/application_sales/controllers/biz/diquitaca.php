<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Diquitaca extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->lv = $this->phpsession->get( 'lv', 'stc' );
		$this->cnum = $this->phpsession->get( 'cnum', 'stc' );
		$this->seq = $this->phpsession->get( 'seq', 'stc' );
		$this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );

		if($this->cooperation_yn == 'Y') {
			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
		}
		$this->load->Model('biz/STC_diquitaca');
		$this->load->library('user_agent');
	}


function qna_list() {
	if( $this->id === null ) {
		redirect( 'account' );
	}

	if(isset($_GET['cur_page']) && $_GET['cur_page'] != '') {
		$cur_page = $_GET['cur_page'];
	} else {
		$cur_page = 1;
	}

	if(!isset($_GET['lpp']) || $_GET['lpp'] == '') {
		$no_page_list = 10;
	} else {
		$no_page_list = (int)$_GET['lpp'];
	}

	if(isset($_GET['searchkeyword'])) {
		$search_keyword = $_GET['searchkeyword'];
	} else {
		$search_keyword = '';
	}

	if(isset($_GET['search1'])) {
		$search1 = $_GET['search1'];
	} else {
		$search1 = '';
	}

	$data['cur_page'] = $cur_page;
	$data['lpp'] = $no_page_list;
	$data['search_keyword'] = $search_keyword;
	$data['search1'] = $search1;

	$data['list_val'] = $this->STC_diquitaca->qna_list('list', $search_keyword, $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
	$data['count'] = $this->STC_diquitaca->qna_list('count', $search_keyword, $search1)->ucount;

	$total_page = 1;
	if( $data['count'] % $no_page_list == 0 ) {
		$total_page = floor( ( $data['count'] / $no_page_list ) );
	} else {
		$total_page = floor( ( $data['count'] / $no_page_list + 1 ) );
	}

	$start_page = floor( ( $cur_page - 1 ) / 10 ) * 10 + 1;
	$end_page = 0;
	if( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ) {
		$end_page = ( floor( ( $cur_page - 1 ) / 10 ) + 1 ) * 10;
	} else {
		$end_page = $total_page;
	}

	$data['total_page'] = $total_page;
	$data['start_page'] = $start_page;
	$data['end_page']   = $end_page;

	if($this->agent->is_mobile()) {
		$data['title'] = '<span style="float:left;">디키타카</span><img style="cursor:pointer;vertical-align:middle;margin-left:5px;float:left;" src="/misc/img/dashboard/btn/btn_info.svg" width="25" onclick="open_inf(this);"/><img style="cursor:pointer;vertical-align:middle;margin-right:15px;float:right;" src="/misc/img/mobile/write_board.svg" width="25" onclick="go_input();"/>';
		$this->load->view("biz/diquitaca/qna_list_mobile", $data);
	} else {
		$this->load->view("biz/diquitaca/qna_list", $data);
	}
}

function qna_view() {

	$seq = $this->input->get('seq');

	$data['seq']          = $seq;
	$data['qna_val']      = $this->STC_diquitaca->qna_val($seq);
	$data['vote_val']     = $this->STC_diquitaca->vote_val($seq);
	$data['vote_content'] = $this->STC_diquitaca->vote_content($seq);
	$data['vote_list']    = $this->STC_diquitaca->vote_list($seq);
	$data['my_vote']      = $this->STC_diquitaca->my_vote_list($seq, $this->seq);
	$data['clist_val']    = $this->STC_diquitaca->qna_comment($seq);
	$data['user_count']   = $this->STC_diquitaca->user_count();

	$read_count = $this->STC_diquitaca->qna_read_count($seq, $this->seq);
	if ($read_count['cnt'] == 0) {
		$read = array(
			'notice_seq' => $seq,
			'user_seq'   => $this->seq
		);
		$this->STC_diquitaca->qna_read_insert($seq, $this->seq, $read);
	}

	if($this->agent->is_mobile()) {
		$data['title'] = '<span style="float:left;">디키타카</span>';
		$this->load->view('biz/diquitaca/qna_view_mobile', $data);
	} else {
		$this->load->view('biz/diquitaca/qna_view', $data);
	}
}

function qna_input() {
	if( $this->id === null ) {
		redirect( 'account' );
	};

	$data['category'] = $this->STC_diquitaca->qna_category();

	if($this->agent->is_mobile()) {
		$data['title'] = '<span style="float:left;">글쓰기</span>';
		$this->load->view("biz/diquitaca/qna_input_mobile", $data);
	} else {
		$this->load->view("biz/diquitaca/qna_input", $data);
	}
}

function qna_modify() {

	$seq = $this->input->post('seq');

	$data['seq']          = $seq;
	$data['qna_val']      = $this->STC_diquitaca->qna_val($seq);
	$data['vote_val']     = $this->STC_diquitaca->vote_val($seq);
	$data['vote_content'] = $this->STC_diquitaca->vote_content($seq);
	$data['vote_list']    = $this->STC_diquitaca->vote_list($seq);
	$data['my_vote']      = $this->STC_diquitaca->my_vote_list($seq, $this->seq);
	$data['clist_val']    = $this->STC_diquitaca->qna_comment($seq);
	$data['user_count']   = $this->STC_diquitaca->user_count();
	$data['category']     = $this->STC_diquitaca->qna_category();

	if($this->agent->is_mobile()) {
		$data['title'] = '<span style="float:left;">수정</span>';
		$this->load->view('biz/diquitaca/qna_modify_mobile', $data);
	} else {
		$this->load->view('biz/diquitaca/qna_modify', $data);
	}
}

function qna_input_action() {
	$seq = $this->input->post('seq');
	$type = $this->input->post('type');

	$already_voted = false;

	$file_count = $_POST['file_length'];
	if($type == 1) {
		$file_realname = '';
		$file_changename = '';
	} else {
		$file_realname = $_POST['file_realname'];
		$file_changename = $_POST['file_changename'];
	}

	if($file_count > 0) {
		for($i=0; $i<$file_count; $i++){
			// $csize = $_FILES["files".$i]["size"];
			$f = "files".$i;
			$cname = $_FILES[$f]["name"];
			$ext = substr(strrchr($cname,"."),1);
			$ext = strtolower($ext);

			$upload_dir = "/var/www/html/stc/misc/upload/biz/diquitaca";
			// $upload_dir = "C:/xampp/htdocs/biz/misc/upload/biz/diquitaca";
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
				echo json_encode(false);
				exit;
			}
		}
		$file_realname = trim($file_realname, '*/*');
		$file_changename = trim($file_changename, '*/*');
	}

	$vote_yn = $this->input->post('vote_yn');

	$data = array(
		'title'           => addslashes($this->input->post('title')),
		'category'        => $this->input->post('category'),
		'contents'        => $this->input->post('contents'),
		'vote_yn'         => $vote_yn,
		'file_realname'   => $file_realname,
		'file_changename' => $file_changename
	);

	if($vote_yn == 'Y') {
		$data['vote_deadline'] = date('Y-m-d H:i:s', strtotime($_POST['deadline_day'].' '.$_POST['deadline_time']));
	} else {
		$data['vote_deadline'] = null;
	}

	if($seq == null) {
		$data['insert_id'] = $this->id;
		$data['insert_date'] = date('Y-m-d H:i:s');
		$result = $this->STC_diquitaca->qna_insert($data, $mode = 0);
		if($vote_yn == 'Y') {
			$multi_choice = $this->input->post('multi_choice');
			$anonymous = $this->input->post('anonymous');
			if($multi_choice == '') {
				$multi_choice = 'N';
			}
			if($anonymous == '') {
				$anonymous = 'N';
			}
			$data2 = array(
				'qna_seq'      => $result,
				'title'        => $this->input->post('vote_title'),
				'multi_choice' => $multi_choice,
				'anonymous'    => $anonymous,
				'result_check' => $this->input->post('result_check')
			);
			$result2 = $this->STC_diquitaca->vote_insert($data2);

			$vote_content = $this->input->post('vote_content');
			foreach($vote_content as $vc) {
				$data3 = array(
					'vote_seq' => $result2,
					'content'  => $vc
				);
				$result3 = $this->STC_diquitaca->vote_content_insert($data3);
			}
		}
	} else {
		$data['modify_date'] = date('Y-m-d H:i:s');
		$result = $this->STC_diquitaca->qna_insert($data, $mode = 1, $seq);
		if($vote_yn == 'Y') {
			$vote_list = $this->STC_diquitaca->vote_list($seq);

			if(empty($vote_list)) {
				$multi_choice = $this->input->post('multi_choice');
				$anonymous = $this->input->post('anonymous');
				if($multi_choice == '') {
					$multi_choice = 'N';
				}
				if($anonymous == '') {
					$anonymous = 'N';
				}
				$data2 = array(
					'qna_seq'      => $result,
					'title'        => $this->input->post('vote_title'),
					'multi_choice' => $multi_choice,
					'anonymous'    => $anonymous,
					'result_check' => $this->input->post('result_check')
				);
				$result2 = $this->STC_diquitaca->vote_insert($data2, $mode = 1);

				$vote_content = $this->input->post('vote_content');
				foreach($vote_content as $vc) {
					$data3 = array(
						'vote_seq' => $result2,
						'content'  => $vc
					);
					$result3 = $this->STC_diquitaca->vote_content_insert($data3);
				}
			} else {
				$already_voted = true;
			}
		} else if ($vote_yn == 'N') {
			$result2 = $this->STC_diquitaca->delete_vote($seq);
		}
	}

	if($result) {
		if($already_voted) {
			echo json_encode('already_voted');
		} else {
			echo json_encode(true);
		}
	} else {
		echo json_encode(false);
	}
}

function qna_delete_action() {
	if( $this->id === null ) {
		redirect( 'account' );
	}

	$seq = $this->input->post('seq');

	$result = $this->STC_diquitaca->qna_delete($seq);

	if($result) {
		echo "<script>alert('정상적으로 삭제되었습니다.');location.href='".site_url()."/biz/diquitaca/qna_list';</script>";
	} else {
		echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
	}
}

function insert_qna_comment() {
	if( $this->id === null ) {
		redirect( 'account' );
	}

	$data = array(
		'qna_seq'     => $this->input->post('seq'),
		'user_id'     => $this->id,
		'contents'    => $this->input->post('comment'),
		'insert_date' => date('Y-m-d H:i:s')
	);

	$result = $this->STC_diquitaca->insert_qna_comment($data);

	if($result) {
		echo "<script>alert('정상적으로 처리되었습니다.');history.go(-1);</script>";
	} else {
		echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
	}
}

function delete_qna_comment() {
	if( $this->id === null ) {
		redirect( 'account' );
	}

	$this->load->helper('alert');
	$cseq = $this->input->post( 'cseq' );

	$result = $this->STC_diquitaca->delete_qna_comment($cseq);

	if ($result) {
		echo "<script>alert('삭제완료 되었습니다.');history.go(-1);</script>";
	} else {
		alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
	}
}

function select_vote() {
	if( $this->id === null ) {
		redirect( 'account' );
	}

	$vseq = $this->input->post('vseq');

	$chk_vote_content = $this->STC_diquitaca->chk_vote_content($vseq);

	if($chk_vote_content['cnt'] == 0) {
		echo "<script>alert('투표 내용이 변경되었습니다.\다시 선택해주세요.');history.go(-1);</script>";
	} else {
		$data = array(
			'content_seq' => $vseq,
			'user_seq'    => $this->seq,
			'insert_time' => date('Y-m-d H:i:s')
		);

		$result = $this->STC_diquitaca->select_vote($data);

		if ($result) {
			echo "<script>alert('투표 처리 되었습니다.');history.go(-1);</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}
}

function cancel_vote() {
	if( $this->id === null ) {
		redirect( 'account' );
	}

	$vseq = $this->input->post('vseq');

	$result = $this->STC_diquitaca->cancel_vote($vseq, $this->seq);

	if ($result) {
		echo "<script>alert('투표 취소 되었습니다.');history.go(-1);</script>";
	} else {
		alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
	}
}

function vote_progress() {
	$seq = $this->input->post('seq');

	$result = $this->STC_diquitaca->vote_progress($seq);

	echo json_encode($result);
}

function voter_list() {
	$content_seq = $this->input->post('content_seq');

	$result = $this->STC_diquitaca->voter_list($content_seq);

	echo json_encode($result);
}

}
?>
