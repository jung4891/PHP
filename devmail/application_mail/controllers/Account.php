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

								$encrypted = base64_encode(openssl_encrypt($password, 'aes-256-cbc', $key_pass, OPENSSL_RAW_DATA, $iv));
								$create_key = $this->M_account->aes_key($check_id['username'], $encrypted);
								if($create_key){
									$_SESSION['userid'] = $check_id['username'];
									$_SESSION['roles'] = "user";
									$_SESSION['name'] =  $check_id['name'];

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


		public function logout(){
			session_unset();
			session_destroy();
			redirect('');
		}


}
