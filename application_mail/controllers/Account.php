<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	function __construct() {
			parent::__construct();
			if(!isset($_SESSION)){
					session_start();
			}
			$this->load->helper('url');
			$this->load->Model('M_account');
			$this->load->library('email');

	}

    // public function index(){
    //
    //   $this->load->view('login');
    //
    // }


		public function login(){
			$mode = '';
			$userid = '';
			$password = '';
      if(isset($_POST['login_mode']) && $_POST['login_mode'] == 'admin'){
        if (isset ($_POST['inputId'])) $userid = $_POST['inputId'];
        if (isset ($_POST['inputPass'])) $password = $_POST['inputPass'];
        $check_id = $this->M_account->admin_check($userid);
				if(!$check_id){
         echo "<script>alert('이메일 주소나 패스워드가 정확하지 않습니다.');history.go(-1);</script>";
				}else{
					$db_pass = $check_id['password'];
					if (hash_equals($db_pass, crypt($password, $db_pass))) {
						$check_domain = $this->M_account->domain_check($userid);
						// $_SESSION['roles'] = array();
						// $_SESSION['roles']['domain'] = 'admin';
						$_SESSION['userid'] = $check_domain['username'];
						$_SESSION['roles'] = "admin";
						$_SESSION['domain'] = $check_domain['domain'];
						// var_dump($check_domain);
						// session_regenerate_id();
						// $session_data["sessid"] = array(
						// 	"userid" => $check_domain['username'],
						// 	"roles" => "admin",
						// 	"domain" => $check_domain['domain'],
						// 	"loged_in" =>TRUE
						// );
						// $this->session->set_userdata($session_data);
						// $url = site_url()."/admin/main";
						// echo $url;
						// header('Location: http://dev.mail.durianit.co.kr/index.php/admin/main');
						// exit;
						echo "<script>location.href='".site_url()."/admin/main'</script>";
					}else{
						echo "<script>alert('이메일 주소나 패스워드가 정확하지 않습니다.');history.go(-1);</script>";
					}

				}
      }else{
				if( (isset($_POST['login_mode']) && $_POST['login_mode'] == 'general') ) {
					if (isset ($_POST['inputId'])) $userid = $_POST['inputId'];
					if (isset ($_POST['inputPass'])) $password = $_POST['inputPass'];

						$check_id = $this->M_account->user_check($userid);

						if(!$check_id){
						 echo "<script>alert('이메일 주소나 패스워드가 정확하지 않습니다.');history.go(-1);</script>";
						}else{
							$db_pass = $check_id['password'];
							if (hash_equals($db_pass, crypt($password, $db_pass))) {

								$key_pass = $this->db->password;
								$key_pass = substr(hash('sha256', $key_pass, true), 0, 32);

								$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

								$encrypted = base64_encode(openssl_encrypt($password, 'aes-256-cbc', $key_pass, 1, $iv));
								$create_key = $this->M_account->aes_key($check_id['username'], $encrypted);
								if($create_key){
									$_SESSION['userid'] = $check_id['username'];
									$_SESSION['roles'] = "user";
									$_SESSION['name'] =  $check_id['name'];
									$_SESSION['s_width'] = $check_id['side_width'];

									echo "<script>location.href='".site_url()."/mailbox/mail_list'</script>";

									// echo "<script>location.href='".site_url()."/mail/main'</script>";
								}




							}else{
								echo "<script>alert('이메일 주소나 패스워드가 정확하지 않습니다.');history.go(-1);</script>";
							}

						}
				}
      }

		}

		function biz_login(){
			// newForm.append($('<input>', {type: 'hidden', name: 'login_mode', value: 'general'}));
		  //       newForm.append($('<input>', {type: 'hidden', name: 'inputId', value: mail_address }));
		  //       newForm.append($('<input>', {type: 'hidden', name: 'inputPass', value:data.pkey }));
		  //       newForm.append($('<input>', {type: 'hidden', name: 'biz_mode', value:'y' }));
		  //       newForm.append($('<input>', {type: 'hidden', name: 'mailbox', value:mailbox }));
			$mode = '';
			$userid = '';
			$password = '';
			if(isset($_POST['biz_mode']) && $_POST['biz_mode'] == 'y'){
				$uid = $this->input->post("inputId");
				$pkey = $this->input->post("inputPass");
				$mailbox = $this->input->post("mailbox");
				$mailid = $this->input->post("mailid");
				$check = $this->M_account->check_key($uid, $pkey);
				if($check){
					$check_id = $this->M_account->user_check($uid);
					$_SESSION['userid'] = $check_id['username'];
					$_SESSION['roles'] = "user";
					$_SESSION['name'] =  $check_id['name'];
					$_SESSION['s_width'] = $check_id['side_width'];

					$mailserver = "192.168.0.100";
					$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
					$key = $this->db->password;
		      $key = substr(hash('sha256', $key, true), 0, 32);
					$decrypted = openssl_decrypt(base64_decode($pkey), 'aes-256-cbc', $key, 1, $iv);
					$host = "{" . $mailserver . ":143/imap/novalidate-cert}$mailbox";
					$mails = @imap_open($host, $check_id['username'], $decrypted);
					$msg_num = imap_msgno($mails, $mailid);
					$mbox2 = str_replace('&', '%26', $mailbox);
					$mbox2 = str_replace(' ', '+', $mbox2);

					if ($mailbox == "" || $mailid == "") {
							echo "<script>location.href='".site_url()."/mailbox/mail_list'</script>";
						} else {
							echo "<script>location.href='".site_url()."/mailbox/mail_detail?boxname={$mbox2}&mailno={$msg_num}'</script>";

						}
				} else {
					echo "<script>alert('인증에 실패하였습니다.');</script>";
				}
			} else {

				redirect("");

			}


		}


		public function logout(){
			session_unset();
			session_destroy();
			redirect('');
		}

		function password_change(){
			if(isset($_SESSION['userid']) && ($_SESSION['userid'] != "")){
				redirect("");
			}

			// if(!isset($_POST['username'])){
			// 	echo "<script>history.back();</script>";
			// }

			$user_id = $this->input->post('username');
			$password = $this->input->post('password');
			$check_pass = $this->input->post('chk_pass');
			$rand = $this->getRandStr();
			$hash_salt = "$1$".$rand."$";
			$hashed_password = crypt($password, $hash_salt);

			$modify_array = array(
				'password' => $hashed_password
			);
			var_dump($modify_array);
			exit;
			$result = $this->M_account->change_password($modify_array, $user_id);
			if($result){
				var_dump($result);
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


}
