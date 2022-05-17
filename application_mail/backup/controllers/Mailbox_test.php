<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailbox_test extends CI_Controller {

  public function naver_test() {
    $mailserver = "imap.naver.com";
    $user_id = "go_go_ssing";
    $user_pwd = "gurwnd4891!!";
    $mailbox = imap_open("{" . $mailserver . ":993/imap/novalidate-cert/ssl}INBOX", $user_id, $user_pwd);
    $folders = imap_list($mailbox, "{" . $mailserver . "}", '*');
    $mailno_arr = imap_sort($mailbox, SORTDATE, 1);
    foreach($mailno_arr as $no) {
      $info = imap_headerinfo($mailbox, $no);
      echo '<pre>';
      echo imap_utf8($info->subject);
      echo '</pre>';
      echo '<br>';
    }
  }

}



?>
