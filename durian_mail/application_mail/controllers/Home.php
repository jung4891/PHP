<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
			parent::__construct();
			$this->load->helper('url');
			// $this->load->helper('form');
			// $this->load->helper('url');
			// $this->load->Model('m_login');
			//
			// $this->load->library('email');
			// $config['protocol'] = 'smtp';
			// $config['mailpath'] = '/usr/sbin/sendmail';
			// $config['charset'] = 'UTF-8';
			// $config['wordwrap'] = TRUE;
			// $config['newline'] = '\r\n';
			// $config['smtp_host'] = '';
			// $config['smtp_user'] = '';
			// $config['smtp_pass'] = '';
			// $configuration = $this->m_login->get_configuration();
			// if(!empty($configuration)){
			// 	$config['smtp_host'] = $configuration['mail_ip'];
			// 	$config['smtp_user'] = $configuration['mail_address'];
			// 	$config['smtp_pass'] = $configuration['mail_password'];
			// }
			// $config['mailtype'] = 'html';
			//
			// $this->email->initialize($config);

			// $username = "bhkim@durianit.co.kr";
			// $password = "durian12#";
			// $mailserver = "192.168.0.100";

			// $username = "test1@durianict.co.kr";
			// $password = "durian12#";
			// $mailserver = "192.168.0.50";

			// POP3 서버
			//$mailbox = @imap_open("{" . $mailserver . ":110/pop3}INBOX", $username, $password);

			// IMAP 서버
			// $mailbox = @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $username, $password);



	}


		public function index(){
			$this->load->view('login');

			
		}


}
