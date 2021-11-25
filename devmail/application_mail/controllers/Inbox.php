<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Inbox extends CI_Controller {


  function __construct() {
      parent::__construct();
      // mail helper는 따로 만든것임
      // $this->load->helper(array('url', 'download', 'mail'));
      if(!isset($_SESSION)){
					session_start();
			}
      $this->load->helper('url');
      $this->load->library('email');

      $this->imap_conf['encrypto'] = 'imap';
      $this->imap_conf['validate'] = false;
      $this->imap_conf['host']     = '192.168.0.100';
      $this->imap_conf['port']     = 143;
      $this->imap_conf['username'] = 'hjsong@durianit.co.kr';
      $this->imap_conf['password'] = 'durian12#';
      $this->imap_conf['folders'] = array(
      	'inbox'  => 'INBOX',
      	'sent'   => 'Sent',
      	'trash'  => 'Trash',
      	'spam'   => 'Spam',
      	'drafts' => 'Drafts'
      );
      $this->imap_conf['expunge_on_disconnect'] = false;
      $this->imap_conf['cache'] = array(
      	'active'     => false,
      	'adapter'    => 'file',
      	'backup'     => 'file',
      	'key_prefix' => 'imap:',
      	'ttl'        => 60
      );

      $this->stream = $this->imap_connect($this->imap_conf);
      $this->mailbox = "";
  }

  public function index(){
    $this->library_test();
  }


  function library_test(){

    // var_dump($this->imap_conf);
    // $con = $this->imap_connect($this->imap_conf);
    // var_dump($con);
    // $fold = $this->get_folders();
    $this->load->view('tpl');
  }

  function imap_connect($imap_conf){
		// $config       = array_replace_recursive($this->config, $config);

		if ($imap_conf['cache']['active'] === true)
		{
			$this->CI->load->driver('cache',
				[
				'adapter'    => $imap_conf['cache']['adapter'],
				'backup'     => $imap_conf['cache']['backup'],
				'key_prefix' => $imap_conf['cache']['key_prefix'],
				]);
		}

		$enc = '';

		if (isset($imap_conf['port']))
		{
			$enc .= ':' . $imap_conf['port'];
		}

		if (isset($imap_conf['encrypto']))
		{
			$enc .= '/' . $imap_conf['encrypto'];
		}

		if (isset($imap_conf['validate']) && $imap_conf['validate'] === false)
		{
			$enc .= '/novalidate-cert';
		}

		$this->mailbox = '{' . $imap_conf['host'] . $enc . '}';
    // return $mailbox;
		$stream  = @imap_open($this->mailbox, $imap_conf['username'], $imap_conf['password']);

		//show_error($this->get_last_error());

		return is_resource($stream);
	}

  public function get_folders()
  {
    $folders = imap_list($this->stream, $this->mailbox, '*');
    $folders = $this->get_subfolders(str_replace($this->mailbox, '', $folders));

    sort($folders);

    return $folders;
  }

  protected function get_subfolders($folders)
  {
    for ($i = 0; $i < count($folders); $i++)
    {
      if (isset(explode('.', $folders[$i])[1]))
      {
        $folders[$i] = $this->get_subfolders($folders[$i]);
      }
    }

    // for ($i = 0; $i < count($folders); $i++)
    // {
    // 	if (strpos($folders[$i],'.') !== false)
    // 	{
    // 		$folders[$folders[$i]] = $this->static_dot_notation($folders[$i]);
    // 	}
    // }

    return $folders;
  }


}


 ?>
