<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Option extends CI_Controller {

	function __construct() {
			parent::__construct();
			if(!isset($_SESSION)){
					session_start();
			}

			$this->load->helper('url');
			$this->load->Model('M_option');
			$this->load->Model('M_account');
			$this->load->Model('M_group');
			$this->load->Model('M_categori');
			$this->load->library('user_agent');
			if(!isset($_SESSION['userid']) && ($_SESSION['userid'] == "")){
				redirect("");
			}

			$encryp_password = $this->M_account->mbox_conf($_SESSION['userid']);
			$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
      $key = $this->db->password;
      $key = substr(hash('sha256', $key, true), 0, 32);
			$decrypted = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);
			$this->mailserver = "192.168.0.100";
      // $this->mailserver = "mail.durianit.co.kr";
      $this->user_id = $_SESSION["userid"];
      $this->user_pwd = $decrypted;
	}

	function list_mobile(){
		if ($this->agent->is_mobile()) {
			$this->load->view('mobile/option_list_mobile');
		} else {

			$this->user();
		}
	}


	function user() {
		if(isset($_SESSION['userid']) && ($_SESSION['userid'] != "")){

			if ($this->agent->is_mobile()) {
				$this->load->view('mobile/mobile_account_info');
			} else {

				$this->load->view('account_info');

			}
		}else{
			// $this->load->view('login');
			redirect("");
		}

	}

	function change_name(){
		$user_id = $this->input->post('id');
		$name = $this->input->post('name');
		$modify_array = array(
			'name' => $name
		);
		$result = $this->M_account->change_name($modify_array, $user_id);
		if($result){
			$_SESSION['name'] =  $name;
			echo json_encode("true");
		} else {
			echo json_encode("false");
		}
	}

	function change_password(){

		$user_id = $this->input->post('username');
		$password = $this->input->post('password');
		$check_pass = $this->input->post('chk_pass');
		$rand = $this->getRandStr();
		$hash_salt = "$1$".$rand."$";
		$hashed_password = crypt($password, $hash_salt);

		$modify_array = array(
			'password' => $hashed_password
		);

		$key_pass = $this->db->password;
		$key_pass = substr(hash('sha256', $key_pass, true), 0, 32);

		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

		$encrypted = base64_encode(openssl_encrypt($password, 'aes-256-cbc', $key_pass, 1, $iv));

		$result = $this->M_account->change_password($modify_array, $user_id, $encrypted);
		if($result){
			echo json_encode("true");
		} else {
			echo json_encode("false");
		}

	}

	function getRandStr($length = 8) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; $charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}


	function address_book() {


		if(isset($_SESSION['userid']) && ($_SESSION['userid'] != "")){
			$user_id = $_SESSION['userid'];
			if(isset($_GET['group_name'])) {
				$group_name = $_GET['group_name'];
			} else {
				$group_name = 'all';
			}
			$data['group_name'] = $group_name;

			if(isset($_GET['cur_page'])) {
				$cur_page = $_GET['cur_page'];
			} else {
				$cur_page = 0;
			}

																	//	현재 페이지
			$no_page_list = 10;										//	한페이지에 나타나는 목록 개수

			if  ( $cur_page <= 0 ){
				$cur_page = 1;
			}

			$data['cur_page'] = $cur_page;
			$data['count'] = $this->M_group->address_book_count($user_id, $group_name)->totalCount;

			$data['address_group'] = $this->M_group->group_list($user_id);
			$data['address_list'] = $this->M_group->address_book_view($user_id ,$group_name, ( $cur_page - 1 ) * $no_page_list, $no_page_list); // 값을 보내는  것, 아규먼트

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

			if ($this->agent->is_mobile()) {
				$data['address_list'] = $this->M_group->address_book_view($user_id ,$group_name);
				$this->load->view('mobile/addressbook_mobile', $data);
			} else {
				$this->load->view('address_book_view', $data);

			}

		}else{
			// $this->load->view('login');
			redirect("");
		}
	}


	function address_book_test() {


		if(isset($_SESSION['userid']) && ($_SESSION['userid'] != "")){
			$user_id = $_SESSION['userid'];
			if(isset($_GET['group_name'])) {
				$group_name = $_GET['group_name'];
			} else {
				$group_name = 'all';
			}
			$data['group_name'] = $group_name;

			if(isset($_GET['cur_page'])) {
				$cur_page = $_GET['cur_page'];
			} else {
				$cur_page = 0;
			}

																	//	현재 페이지
			$no_page_list = 10;										//	한페이지에 나타나는 목록 개수

			if  ( $cur_page <= 0 ){
				$cur_page = 1;
			}

			$data['cur_page'] = $cur_page;
			$data['count'] = $this->M_group->address_book_count($user_id, $group_name)->totalCount;

			$data['address_group'] = $this->M_group->group_list($user_id);
			$data['address_list'] = $this->M_group->address_book_view($user_id ,$group_name, ( $cur_page - 1 ) * $no_page_list, $no_page_list); // 값을 보내는  것, 아규먼트

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

			if ($this->agent->is_mobile()) {
				$this->load->view('mobile/addressbook_mobile_test', $data);
			} else {
				$this->load->view('address_book_view', $data);

			}

		}else{
			// $this->load->view('login');
			redirect("");
		}
	}


		// public function index(){
		// 	if(isset($_SESSION['userid']) && ($_SESSION['userid'] != "")){
		// 		echo "<script>location.href='".site_url()."/option/account'</script>";
		// 	}else{
		// 		$this->load->view('login');
		// 	}
		// }

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
			// var_dump($folders_tmp);
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
			if(isset($_SESSION['userid']) && ($_SESSION['userid'] != "")){
				$mbox_info = $this->get_mbox_info();
				$length = count($mbox_info);
				// $mbox_info[$length]['boxname_kor'] = "";		// 메일함 관리에서 배열 마지막 임시데이터
				$data['mbox_info'] = $mbox_info;

				if ($this->agent->is_mobile()) {
					$this->load->view('mobile/mailbox_setting_mobile', $data);
				} else {

					$this->load->view('mbox_setting', $data);

				}
			}else{
				// $this->load->view('login');
				redirect("");
			}
		}

		function add_mailbox() {							  // mail_side에서 우클릭 메일함 추가시
		   $parent = $this->input->post('parent_mbox');
			 if(strpos($parent, '&') === false)		// 메일함 설정에서 메일함 추가시
			 		$parent = mb_convert_encoding($parent, 'UTF7-IMAP', 'UTF-8');
		   $child = $this->input->post('new_mbox');
			 $child = mb_convert_encoding($child, 'UTF7-IMAP', 'UTF-8');
			 $new_mbox = ($parent == "#")? $child : $parent.'.'.$child;
		   $mails= $this->connect_mailserver();
		   $mailserver = $this->mailserver;
		   $host = "{" . $mailserver . ":143/imap/novalidate-cert}";
		   $create = imap_createmailbox($mails, $host.$new_mbox);
		   if($create) echo "o"; else echo "x";
		   imap_close($mails);
		}

		function rename_mailbox() {			// mail_side에서 우클릭 메일함명 수정시
			$parent = $this->input->post('parent');
			$old_mbox = $this->input->post('old_mbox');
			$new_mbox = $this->input->post('new_mbox');
			$old_mbox = mb_convert_encoding($old_mbox, 'UTF7-IMAP', 'UTF-8');
			$old_mbox = ($parent == "")? $old_mbox : $parent.'.'.$old_mbox;		// 메일함 설정에서 메일함 추가시
			$new_mbox = mb_convert_encoding($new_mbox, 'UTF7-IMAP', 'UTF-8');
			$new_mbox = ($parent == "")? $new_mbox : $parent.'.'.$new_mbox;
			$mails = $this->connect_mailserver();
			$mailserver = $this->mailserver;
			$host = "{" . $mailserver . ":143/imap/novalidate-cert}";
			$res = imap_renamemailbox($mails, $host.$old_mbox, $host.$new_mbox);
			if($res) echo "o"; else echo "x";
			imap_close($mails);
		}

		function del_mailbox() {			// mail_side에서 우클릭 메일함명 삭제시
			$folders = $this->input->post('folders');
			$mails = $this->connect_mailserver();
			$mailserver = $this->mailserver;
			$host = "{" . $mailserver . ":143/imap/novalidate-cert}";
			$res = true;
			foreach($folders as $f) {
				$this->trash_all_mails($f);
				if(!imap_deletemailbox($mails, $host.$f))	$res = false;
			}
			if($res) echo "o"; else echo "x";
			imap_close($mails);
		}

		function trash_all_mails($f = "") {		// 여기서부터 아래 set_seen까지는 mbox_setting부분임.(+ side에서 메일함삭제시 실행)
			$mbox = ($f == "")? $this->input->post("mbox") : $f;
			// $mbox = mb_convert_encoding($mbox, 'UTF7-IMAP', 'UTF-8');
			$trash = mb_convert_encoding('지운 편지함', 'UTF7-IMAP', 'UTF-8');
			$mails= $this->connect_mailserver($mbox);
			$mailno_arr = imap_sort($mails, SORTDATE, 1);
			$arr_str = implode(',', $mailno_arr);
			$res = imap_mail_move($mails, $arr_str, $trash);
			imap_expunge($mails);
			imap_close($mails);
			if($f == "")	echo $res;
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
			// $mbox = mb_convert_encoding($mbox, 'UTF7-IMAP', 'UTF-8');
			$mails= $this->connect_mailserver($mbox);
			$mailno_arr = imap_sort($mails, SORTDATE, 1);
			$arr_str = implode(',', $mailno_arr);
			$res = imap_setflag_full($mails, $arr_str, "\\Seen");
			imap_expunge($mails);
			imap_close($mails);
			echo $res;
		}


		function singnature(){
			if(isset($_SESSION['userid']) && ($_SESSION['userid'] != "")){
				$this->load->view('sign_list');
			}else{
				// $this->load->view('login');
				redirect("");
			}
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

		function categorize() {


			if(isset($_SESSION['userid']) && ($_SESSION['userid'] != "")){
				$user_id = $_SESSION['userid'];
				if(isset($_GET['group_name'])) {
					$group_name = $_GET['group_name'];
				} else {
					$group_name = 'all';
				}
				$data['group_name'] = $group_name;

				if(isset($_GET['cur_page'])) {
					$cur_page = $_GET['cur_page'];
				} else {
					$cur_page = 0;
				}

																		//	현재 페이지
				$no_page_list = 10;										//	한페이지에 나타나는 목록 개수

				if  ( $cur_page <= 0 ){
					$cur_page = 1;
				}

				$data['cur_page'] = $cur_page;
				$data['count'] = $this->M_categori->category_list_count($user_id)->totalCount;
				$data['category_list'] = $this->M_categori->category_list($user_id , ( $cur_page - 1 ) * $no_page_list, $no_page_list); // 값을 보내는  것, 아규먼트

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

				$this->load->view('categori_list', $data);
			}else{
				// $this->load->view('login');
				redirect("");
			}
		}

		function categorize_add(){
			if(isset($_SESSION['userid']) && ($_SESSION['userid'] != "")){

				$this->load->view('categori_input');
			}else{
				// $this->load->view('login');
				redirect("");
			}

		}

		function categorize_input_action(){
			if(isset($_SESSION['userid']) && ($_SESSION['userid'] != "")){
				$user_id = $_SESSION["userid"];
				$user_type = $this->input->post("usertype");
				$send_type = $this->input->post("senttype");
				$address = $this->input->post("user_name");
				$domain = $this->input->post("domain_name");
				$mailbox = $this->input->post("save_box");
				if($user_type == 0){
					$address = $address."@".$domain;
				} else {
					$address = $domain;
				}
				$insert_data = array(
					"userid" => $user_id,
					"usertype" => $user_type,
					"sendtype" => $send_type,
					"address" => $address,
					"mailbox" => $mailbox
				);
				$result = $this->M_categori->add_category_act($insert_data);
				if($result){
					echo "<script>alert('등록되었습니다.');location.href='".site_url()."/option/categorize';</script>";
				}

			}else{

				redirect("");
			}
		}

		function categorize_delete(){
			$seq = $this->input->get("id");
			$result = $this->M_categori->category_delete($seq);
			if($result){
				echo "<script>alert('삭제되었습니다.');window.history.back();</script>";
			}
		}

		function categorize_modify(){
			if(isset($_SESSION['userid']) && ($_SESSION['userid'] != "")){
				$seq = $this->input->get("seq");
				$data["modify_data"] = $this->M_categori->get_detail_category($seq);

				$this->load->view('categori_modify',$data);
			}else{
				// $this->load->view('login');
				redirect("");
			}

		}

		function categorize_modify_action(){
			if(isset($_SESSION['userid']) && ($_SESSION['userid'] != "")){
				$user_id = $_SESSION["userid"];
				$seq = $this->input->post("seq");
				$user_type = $this->input->post("usertype");
				$send_type = $this->input->post("senttype");
				$address = $this->input->post("user_name");
				$domain = $this->input->post("domain_name");
				$mailbox = $this->input->post("save_box");
				if($user_type == 0){
					$address = $address."@".$domain;
				} else {
					$address = $domain;
				}
				$modify_data = array(
					"userid" => $user_id,
					"usertype" => $user_type,
					"sendtype" => $send_type,
					"address" => $address,
					"mailbox" => $mailbox
				);
				$result = $this->M_categori->modify_category_act($modify_data, $seq);
				if($result){
					echo "<script>alert('수정되었습니다.');location.href='".site_url()."/option/categorize';</script>";
				}

			}else{

				redirect("");
			}
		}


}

?>
