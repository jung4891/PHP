<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Option extends CI_Controller {

	function __construct() {
			parent::__construct();
			if(!isset($_SESSION)){
					session_start();
			}
			$this->load->helper('url');
			$this->load->model('M_option');
			$this->load->Model('M_account');

			$encryp_password = $this->M_account->mbox_conf($_SESSION['userid']);
			$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
      $key = $this->db->password;
      $key = substr(hash('sha256', $key, true), 0, 32);
			$decrypted = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);
      $this->mailserver = "192.168.0.100";
      $this->user_id = $_SESSION["userid"];
      $this->user_pwd = $decrypted;
	}


		public function index(){
			if(isset($_SESSION['userid']) && ($_SESSION['userid'] != "")){
        $this->load->view('option_list');
			}else{
				$this->load->view('login');
			}
		}

	  public function connect_mailserver($mbox="") {
	    $mailserver = $this->mailserver;
	    $host = "{" . $mailserver . ":143/imap/novalidate-cert}$mbox";
	    $user_id = $this->user_id;
	    $user_pwd = $this->user_pwd;
	    return @imap_open($host, $user_id, $user_pwd);
	  }

		public function get_mbox_info(){
			$mails= $this->connect_mailserver();
			$mailserver = $this->mailserver;
			$folders_tmp = imap_list($mails, "{" . $mailserver . "}", '*');
			$folders_tmp = str_replace("{" . $mailserver . "}", "", $folders_tmp);
			sort($folders_tmp);

			$folders = array();
			$folders[0] = "INBOX";
			$folders[1] = "&vPSwuA- &07jJwNVo-";   // 보낸메일함
			$folders[2] = "&x4TC3A- &vPStANVo-";   // 임시보관함
			$folders[3] = "&yBXQbA- &ulTHfA-";     // 스팸메일함
			$folders[4] = "&ycDGtA- &07jJwNVo-";   // 휴지통
			foreach($folders_tmp as $f) {
				if($f == "INBOX") continue;
				elseif($f == "&vPSwuA- &07jJwNVo-") continue;
				elseif($f == "&x4TC3A- &vPStANVo-") continue;
				elseif($f == "&yBXQbA- &ulTHfA-") continue;
				elseif($f == "&ycDGtA- &07jJwNVo-") continue;
				array_push($folders, $f);
			}
			$mailbox_info = array();
			for($i=0; $i<count($folders); $i++) {
				$folder = $folders[$i];
				$folder_kor = mb_convert_encoding($folder, 'UTF-8', 'UTF7-IMAP');
				switch($folder_kor) {
					case "INBOX":  $folder_kor="전체메일";  break;
					case "보낸 편지함":  $folder_kor="보낸메일함";  break;
					case "임시 보관함":  $folder_kor="임시보관함";  break;
					case "정크 메일":  $folder_kor="스팸메일함";  break;
					case "지운 편지함":  $folder_kor="휴지통";  break;
				}
				$mails = $this->connect_mailserver($folder);
				$mbox_status = imap_status($mails, "{" . $mailserver . "}".$folder, SA_ALL);
				$mails_cnt = 0;
				$unseen_cnt = 0;
				if($mbox_status) {
					$mails_cnt = $mbox_status->messages;
					$unseen_cnt = $mbox_status->unseen;
					// $recent_cnt = $mbox_status->recent;
				}
				$mbox_info[$i]['boxname'] = $folder;
				$mbox_info[$i]['boxname_kor'] = $folder_kor;
				$mbox_info[$i]['mails_cnt'] = $mails_cnt;
				$mbox_info[$i]['unseen_cnt'] = $unseen_cnt;
				// $quota = imap_get_quotaroot($mails, "inbox");				// 현재 사용자의 메일사용량/총할당량 (KB)
				// $quota = imap_get_quota($mails, "user.inbox");		   	// imap메일 관리자 가능
				// $mbox_info["quota"] = $quota;

			}
			imap_close($mails);
			return $mbox_info;
		}

		function mailbox() {
			$mbox_info = $this->get_mbox_info();
			$data['mbox_info'] = $mbox_info;
			$this->load->view('mailbox/mailbox_set', $data);
		}

		function add_mybox() {
			$mails= $this->connect_mailserver();
			$mailserver = $this->mailserver;
			$host = "{" . $mailserver . ":143/imap/novalidate-cert}";
			$encoded = mb_convert_encoding("내메일함", 'UTF7-IMAP', 'UTF-8');
			$create = imap_createmailbox($mails, $host.$encoded);
			if($create) echo "o"; else echo "x";
			imap_close($mails);
		}

		function add_mailbox() {
			$new_mbox = $this->input->post('mbox');
			$mails= $this->connect_mailserver();
			$mailserver = $this->mailserver;
			$host = "{" . $mailserver . ":143/imap/novalidate-cert}";
			$encoded = mb_convert_encoding('내메일함.'.$new_mbox, 'UTF7-IMAP', 'UTF-8');
			$create = imap_createmailbox($mails, $host.$encoded);
			if($create) echo "o"; else echo "x";
			imap_close($mails);
		}

		function rename_mailbox() {
			$old_mbox = $this->input->post('old_mbox');
			$new_mbox = $this->input->post('new_mbox');
			$old_mbox = mb_convert_encoding($old_mbox, 'UTF7-IMAP', 'UTF-8');
			$new_mbox = mb_convert_encoding($new_mbox, 'UTF7-IMAP', 'UTF-8');
			$mails = $this->connect_mailserver();
			$mailserver = $this->mailserver;
			$host = "{" . $mailserver . ":143/imap/novalidate-cert}";
			$res = imap_renamemailbox($mails, $host.$old_mbox, $host.$new_mbox);
			if($res) echo "o"; else echo "x";
			imap_close($mails);
		}

		function del_mailbox() {
			$mbox = $this->input->post('mbox');
			$mbox = mb_convert_encoding($mbox, 'UTF7-IMAP', 'UTF-8');
			$mails = $this->connect_mailserver();
			$mailserver = $this->mailserver;
			$host = "{" . $mailserver . ":143/imap/novalidate-cert}";
			$res = imap_deletemailbox($mails, $host.$mbox);
			if($res) echo "o"; else echo "x";
			imap_close($mails);
		}

		function trash_all_mails() {
			$mbox = $this->input->post("mbox");
			$mbox = mb_convert_encoding($mbox, 'UTF7-IMAP', 'UTF-8');
			$trash = mb_convert_encoding('지운 편지함', 'UTF7-IMAP', 'UTF-8');
			$mails= $this->connect_mailserver($mbox);

			$mailno_arr = imap_sort($mails, SORTDATE, 1);
			$arr_str = implode(',', $mailno_arr);
			$res = imap_mail_move($mails, $arr_str, $trash);
			imap_expunge($mails);
			imap_close($mails);
			echo $res;
		}

 		function del_all_mails() {
			$trash = mb_convert_encoding('지운 편지함', 'UTF7-IMAP', 'UTF-8');
			$mails= $this->connect_mailserver($trash);

			$mailno_arr = imap_sort($mails, SORTDATE, 1);
			$arr_str = implode(',', $mailno_arr);
			$res = imap_delete($mails, $arr_str);
			imap_expunge($mails);
			imap_close($mails);
			echo $res;
		}

 		function set_seen() {
			$mbox = $this->input->post("mbox");
			$mbox = mb_convert_encoding($mbox, 'UTF7-IMAP', 'UTF-8');
			$mails= $this->connect_mailserver($mbox);

			$mailno_arr = imap_sort($mails, SORTDATE, 1);
			$arr_str = implode(',', $mailno_arr);
			$res = imap_setflag_full($mails, $arr_str, "\\Seen");
			imap_expunge($mails);
			imap_close($mails);
			echo $res;
		}



		function sign_list(){
			$user_id = $_SESSION["userid"];
			$result = $this->M_option->get_signlist($user_id);
			echo json_encode($result);
		}

		function sign_input(){
			$sign_seq = $this->input->post("seq");
			$sign_name = $this->input->post("sign_name");
			if($sign_seq == "new"){
				$user_id = $_SESSION["userid"];
				$s_count = $this->M_option->get_signcount($user_id)->s_count;
				$active = ($s_count > 0)?"N":"Y";

				$data = array(
					'usermail' => $user_id,
					'sign_name' => $sign_name,
					'active' => $active
				);
				$result = $this->M_option->sign_input_action($data);
			}else{
				$data = array("sign_name" => $sign_name);
				$result = $this->M_option->sign_save($data, $sign_seq);
			}
			echo json_encode($result);
		}

		function get_signcontent(){
			$user_id = $_SESSION["userid"];
			$sign_seq = $this->input->post("seq");
			$result = $this->M_option->get_signcontent($sign_seq, $user_id);
			echo json_encode($result);
		}

		function sign_save(){
			$content = $this->input->post("content");
			$seq = $this->input->post("seq");
			$data = array("sign_content" => $content);
			$result = $this->M_option->sign_save($data, $seq);
			echo json_encode($result);
		}

		function sign_del(){
			$seq = $this->input->post("seq");
			$result = $this->M_option->sign_del($seq);
			echo json_encode($result);
		}



}

?>
