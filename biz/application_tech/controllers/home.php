<?php
header("Content-type: text/html; charset=utf-8");

class Home extends CI_Controller {

	var $site_type = '';
	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->load->helper('alert');
	}

	function index() {
		$this->load->Model(array('STC_Board', 'STC_Common'));
		$check_time = time() - 48*3600;

		//공지사항 new체크
		$notice_new_data = $this->STC_Board->notice_new();
		
		$notice_new = "";
		foreach($notice_new_data as $val) {
			$updateTime = strtotime($val['update_date']);

			if($check_time < $updateTime) {
				$notice_new .= "1";
			} else {
				$notice_new .= "";
			}
		}
		$data['notice_new'] = $notice_new;

		//자료실 new체크
		$manual_new_data = $this->STC_Board->manual_new();
		
		$manual_new = "";
		foreach($manual_new_data as $val) {
			$updateTime = strtotime($val['update_date']);

			if($check_time < $updateTime) {
				$manual_new .= "1";
			} else {
				$manual_new .= "";
			}
		}
		$data['manual_new'] = $manual_new;

		//FAQ new체크
		$faq_new_data = $this->STC_Board->faq_new();
		
		$faq_new = "";
		foreach($faq_new_data as $val) {
			$updateTime = strtotime($val['update_date']);

			if($check_time < $updateTime) {
				$faq_new .= "1";
			} else {
				$faq_new .= "";
			}
		}
		$data['faq_new'] = $faq_new;

		//QNA new체크
		$qna_new_data = $this->STC_Board->qna_new();
		
		$qna_new = "";
		foreach($qna_new_data as $val) {
			$updateTime = strtotime($val['update_date']);

			if($check_time < $updateTime) {
				$qna_new .= "1";
			} else {
				$qna_new .= "";
			}
		}
		$data['qna_new'] = $qna_new;
		
		//건의사항 new체크
		$suggest_new_data = $this->STC_Board->suggest_new();
		
		$suggest_new = "";
		foreach($suggest_new_data as $val) {
			$updateTime = strtotime($val['update_date']);

			if($check_time < $updateTime) {
				$suggest_new .= "1";
			} else {
				$suggest_new .= "";
			}
		}
		$data['suggest_new'] = $suggest_new;
		$this->load->model( 'STC_User' );
		$data['group'] = $this->input->get('group');
		$data['view_val']=$this->STC_User->periodic_inspection($data['group']);

		$this->load->view( 'home_view', $data);
	}

	function sessiton_destroy()
	{
		session_destroy();
	}
}
?>