<?php
header("Content-type: text/html; charset=utf-8");

class Home extends CI_Controller {

	var $site_type = '';
	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->lv = $this->phpsession->get( 'lv', 'stc' );
		$this->group = $this->phpsession->get( 'group', 'stc' );
		$this->login_time = $this->phpsession->get( 'login_time', 'stc' );
		$this->seq = $this->phpsession->get( 'seq', 'stc' );
		$this->email = $this->phpsession->get( 'email', 'stc' );
		$this->pGroupName = $this->phpsession->get( 'pGroupName', 'stc' );
		$this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );
		$this->load->helper('alert');
		$this->load->Model(array('STC_Common','biz/STC_Approval', 'biz/STC_Schedule', 'dashboard/STC_Dashboard', 'STC_mail'));

	}

	function index() {
		// if(strpos(site_url(),"biz.durianit.co.kr") === false){
		// 	header( 'Location: http://biz.durianit.co.kr' );
		// }else{
			if( $this->id === null ) {
				redirect( 'account' );
			}
			if( $this->cooperation_yn == 'Y' ) {
				echo "<script>location.href='".site_url()."/tech/tech_board/tech_doc_list?type=Y'</script>";
			}
			$data['category'] = $this->STC_Approval->select_format_category();
			$data['standby_approval'] = $this->STC_Approval->approval_list("standby");
			$data['delegation'] = $this->STC_Approval->delegation_list();
			$data['periodic_inspection']=$this->STC_Common->periodic_inspection();
			$data['fortigate_project'] = $this->STC_Dashboard->fortigate_project();
			$data['work_color'] = $this->STC_Schedule->work_color_list();
			$data['user_name'] = $this->name;
			$data['user_group'] = $this->group;
			$data['login_time'] = $this->login_time;
			$data['approval_list'] = $this->STC_Approval->approval_list('standby');
			if(!empty($data['approval_list'])){
					$data['approval_count'] = count($data['approval_list']);
			}else{
					$data['approval_count'] = 0;
			}
			$data['schedule_count'] = $this->STC_Dashboard->my_schedule($this->name)->cnt;

			$data['start_row'] = 0;
			$data['end_row'] = 5;

			// 결재대기함
			$data['standby'] = $this->STC_Approval->approval_list('standby');
			if(!empty($data['standby'])){
					$data['standby_count'] = count($data['standby']);
			}else{
					$data['standby_count'] = 0;
			}

			// 결재진행함
			$data['progress'] = $this->STC_Approval->approval_list('progress');
			if(!empty($data['progress'])){
					$data['progress_count'] = count($data['progress']);
			}else{
					$data['progress_count'] = 0;
			}

			// 완료문서함
			$data['completion'] = $this->STC_Approval->approval_list('completion');
			if(!empty($data['completion'])){
					$data['completion_count'] = count($data['completion']);
			}else{
					$data['completion_count'] = 0;
			}

			// 반려문서함
			$data['back'] = $this->STC_Approval->approval_list('back');
			if(!empty($data['back'])){
					$data['back_count'] = count($data['back']);
			}else{
					$data['back_count'] = 0;
			}

			// 연봉계약서
			$data['wage'] = $this->STC_Approval->approval_list('wage');
			if(!empty($data['wage'])){
					$data['wage_count'] = count($data['wage']);
			}else{
					$data['wage_count'] = 0;
			}

			$data['no_read_cnt_s'] = $this->STC_Approval->approval_list('standby',$search_keyword = '',$this->seq,'no_read_cnt');//진행중인고
			$data['no_read_cnt_p'] = $this->STC_Approval->approval_list('progress',$search_keyword = '',$this->seq,'no_read_cnt');//진행중인고
			$data['no_read_cnt_c'] = $this->STC_Approval->approval_list('completion',$search_keyword = '',$this->seq,'no_read_cnt');//진행중인고
			$data['no_read_cnt_b'] = $this->STC_Approval->approval_list('back',$search_keyword = '',$this->seq,'no_read_cnt');//진행중인고
			$data['no_read_cnt_w'] = $this->STC_Approval->approval_list('wage',$search_keyword = '',$this->seq,'no_read_cnt');//진행중인고

			// 공지사항
			// $data['notice_list'] = $this->STC_Dashboard->notice_list();
			// $data['notice_list_count'] = $this->STC_Dashboard->notice_list_count()->ucount;

			// 운영공지
			$data['management'] = $this->STC_Dashboard->notice_list('001');
			$data['management_count'] = $this->STC_Dashboard->notice_list_count('001')->ucount;
			$data['management_nread_count'] = $this->STC_Dashboard->notice_list_nread_count('001')->ucount;

			// 개발공지
			$data['development'] = $this->STC_Dashboard->notice_list('002');
			$data['development_count'] = $this->STC_Dashboard->notice_list_count('002')->ucount;
			$data['development_nread_count'] = $this->STC_Dashboard->notice_list_nread_count('002')->ucount;

			// 개발공지
			$data['version'] = $this->STC_Dashboard->notice_list('003');
			$data['version_count'] = $this->STC_Dashboard->notice_list_count('003')->ucount;
			$data['version_nread_count'] = $this->STC_Dashboard->notice_list_nread_count('003')->ucount;

			// 디키타카
			$data['diquitaca'] = $this->STC_Dashboard->diquitaca_qna_list();
			$data['diquitaca_nread_count'] = $this->STC_Dashboard->diquitaca_qna_list_nread_count();

			// 주소록
			$data['user_data'] = $this->STC_Dashboard->user_data();

			// 일정
			$data['schedule'] = $this->STC_Dashboard->schedule();

			// 주간업무
			$data['weekly_report_list'] = $this->STC_Dashboard->weekly_report_list();
			$data['weekly_report_list_count'] = $this->STC_Dashboard->weekly_report_list_count()->cnt;
			$data['weekly_report_nread_count'] = $this->STC_Dashboard->weekly_report_list_nread_count();


			// 근태관리
			$card_num = $this->STC_Dashboard->attendance_info();
			if($card_num){
				$data['attendance_today'] = $this->STC_Dashboard->attendance_today($card_num['card_num']);
				$data['real_work'] = $this->STC_Dashboard->attendance_count($card_num['card_num'],"real");
				$data['normal_work'] = $this->STC_Dashboard->attendance_count($card_num['card_num'],"normal");
				$data['abnormal_work'] = $this->STC_Dashboard->attendance_count($card_num['card_num'],"abnormal");
				// var_dump($data['attendance_today']);
			} else {
				$data['attendance_today'] = $this->STC_Dashboard->attendance_today();
				$data['real_work'] = $this->STC_Dashboard->attendance_count(0,"real");
				$data['normal_work'] = $this->STC_Dashboard->attendance_count(0,"normal");
				$data['abnormal_work'] = $this->STC_Dashboard->attendance_count(0,"abnormal");
			}

			$data['attendance_info'] = $this->STC_Dashboard->attendance_info();

			// $data['attendance_today_count'] = $this->STC_Dashboard->attendance_today_count()->cnt;
			$target_date = date('Ym');
			$data['holiday_list'] = $this->STC_Dashboard->holiday_list($target_date);
			$data['holiday_count'] = $this->STC_Dashboard->holiday_count($target_date)->cnt;
			// 메일 연동
			$data['mail_key'] = $this->STC_mail->mbox_conf($this->email);
			// $connection = imap_open('{mail.durianit.co.kr:143/novalidate-cert}INBOX', 'hbhwang@durianit.co.kr', 'gusqls12');
			// $connection = imap_open('192.168.0.100:110/pop3', 'hbhwang@durianit.co.kr', 'gusqls12');
			// $mail_count = imap_num_msg($connection);
			// $data['subject'] = imap_headerinfo($connection, $mail_count);
			// for($i=1; $i<=$data['mail_count']; $i++){
			// 	$data['subject'][$i] = imap_headerinfo($connection, $i)->subject;
			// 	// $data['body'][$i] = imap_body($connection, $i);
			// }
			// $data['header'] = imap_headerinfo($connection);
			// $data['body'] = imap_body($connection);
			$this->load->library('user_agent');

			$data['title'] = 'BIZ CENTER';

      if ($this->agent->is_mobile()) {
        $this->load->view('dashboard/home_view_main_mobile',$data);
      } else {
			$this->load->view('dashboard/home_view_main',$data);
			}
		// }
	}

	function reservartion_room() {
		$day = $this->input->post('day');

		$result = $this->STC_Dashboard->reservartion_room($day);

		echo json_encode($result);
	}

	function reservartion_car() {
		$day = $this->input->post('day');

		$result = $this->STC_Dashboard->reservartion_car($day);

		echo json_encode($result);
	}

	function holiday_search() {
		$target_date = $this->input->post('target_date');

		$result = $this->STC_Dashboard->holiday_list($target_date);

		echo json_encode($result);
	}

	function sessiton_destroy()
	{
		session_destroy();
	}

	function input_attendance_manual() {
		$ws_time = $this->input->post('ws_time');
		$wc_time = $this->input->post('wc_time');
		$ws_ip_address = $_SERVER['REMOTE_ADDR'];
		$wc_ip_address = $_SERVER['REMOTE_ADDR'];
		if($ws_time==""){
			// $ws_time = NULL;
			$ws_ip_address = NULL;
		}
		if($wc_time==""){
			// $wc_time = NULL;
			$wc_ip_address = NULL;
		}
		$user_seq = $this->seq;
		$card_num = $this->STC_Dashboard->attendance_info();
		if ($card_num==false || $card_num['card_num']==""){
			echo json_encode('nocard');
			return false;
		}

		$card_num = $card_num['card_num'];
		$date = date("Ymd");

		$count = $this->STC_Dashboard->count_attendance_manual($card_num, $date)->ucount;

		if ($count==0){
			$data = array(
				'card_num' => $card_num,
				'ws_time' => $ws_time,
				'wc_time' => $wc_time,
				'date' => $date,
				'ws_ip_address' => $ws_ip_address,
				'wc_ip_address' => $wc_ip_address,
				'write_id' => $this->id
			);
			$result = $this->STC_Dashboard->input_attendance_manual($data);
		} else {
			$info = $this->STC_Dashboard->info_attendance_manual($card_num, $date);
			// echo "info['ws_time']=".$info['ws_time']."<br>";
			// echo "ws_time=".$ws_time."<br>";
			if ($info['ws_time']==''){
				$result = $this->STC_Dashboard->update_attendance_manual($card_num, $date, $ws_time, $ws_ip_address, 'ws_time');
			} else {
				$result = $this->STC_Dashboard->update_attendance_manual($card_num, $date, $wc_time, $wc_ip_address, 'wc_time');
			}
		}

		echo json_encode($result);
	}
}
?>
