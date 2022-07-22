<?php
header("Content-type: text/html; charset=utf-8");

class Mail extends CI_Controller {

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

		$this->load->Model(array('STC_mail'));

    // $mail_address = $this->email;
    // $encryp_password = $this->STC_mail->mbox_conf($mail_address);
    // $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
    // $key = $this->db->password;
    // $key = substr(hash('sha256', $key, true), 0, 32);
    // $mail_pkey = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);

	}


	function make_key(){
		$password = $this->input->post("input_pass");
		// $key_pass = $this->db->password;
		$key_pass = "durian12#";
		$key_pass = substr(hash('sha256', $key_pass, true), 0, 32);
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		$encrypted = base64_encode(openssl_encrypt($password, 'aes-256-cbc', $key_pass, 1, $iv));
		echo json_encode($encrypted);
	}

	function update_key(){
		$uid = $this->email;
		$password = $this->input->post("input_pass");
		$result = $this->STC_mail->aes_key($uid, $password, 1);
		echo json_encode($result);
	}

	function get_pkey(){
		$uid = $this->email;
		$result = $this->STC_mail->mbox_conf($uid);
		echo json_encode($result);
	}



}
?>
