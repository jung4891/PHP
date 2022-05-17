<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testmail_write extends CI_Controller {

   function __construct() {
         parent::__construct();
				 if(!isset($_SESSION)){
						 session_start();
				 }
         $this->load->helper('url');
         // $this->load->helper('form');
         // $this->load->helper('url');
         // $this->load->Model('m_login');
         $this->load->Model('M_addressbook');
				 $this->load->Model('M_account');
         $this->load->Model('M_write');
         $this->load->library('email');
         $this->load->library('user_agent');
				 $encryp_password = $this->M_account->mbox_conf($_SESSION['userid']);
	 		 	 $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
	       $key = $this->db->password;
	       $key = substr(hash('sha256', $key, true), 0, 32);
	 			 $this->decrypted = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);

   }


      public function index(){
        if(!isset($_SESSION['userid']) && ($_SESSION['userid'] == "")){
          redirect("");
        }

        $this->page();

      }


      public function mail_test(){
         // $user_id = $this->input->post('inputId');
         // $user_pass = $this->input->post('inputPass');
         $mailserver = "192.168.0.100";
         $user_id = $this->input->post('inputId');
         $user_pass = $this->input->post('inputPass');
         $user_id = "bhkim@durianit.co.kr";
         $mailserver = "192.168.0.100";
      	 $user_id = "test2@durianict.co.kr";
         $user_pass = "durian12#";
         $mailbox = @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $user_id, $user_pass);
         // $folders = imap_listmailbox($mailbox, "{". $mailserver .":143}", "*");
      $folders = imap_getmailboxes($mailbox, "{". $mailserver .":143}", "*");
      // var_dump($folders);
         if ($folders == false) {
          echo "no";
         } else {
          foreach ($folders as $fd) {
         //       // $a = mb_convert_encoding($fd, 'UTF7-IMAP', mb_detect_encoding($fd, 'UTF-8, ISO-8859-1, ISO-8859-15', true));
         // //       // $a = mb_convert_encoding($fd, 'ISO-8859-1', 'UTF7-IMAP');
      //      $a = imap_utf7_decode($fd);
         // //       // $a = utf8_encode($a);
         //       echo $a;
         // //       echo mb_convert_encoding(imap_utf7_decode($fd), "ISO-8859-1", "UTF-8");
      echo mb_convert_encoding($fd->name, 'UTF-8', 'UTF7-IMAP');
          }
         }
         // echo ".&ycDGtA- &07jJwNVo-";
         // echo imap_utf7_decode(".&ycDGtA- &07jJwNVo-");
         // echo mb_convert_encoding(".&ycDGtA- &07jJwNVo-", "UTF-8", "EUC-KR");
      // $this->load->view('read');
         // echo mb_convert_encoding(".&ycDGtA- &07jJwNVo-", 'EUC-KR', 'UTF7-IMAP');

      }

      // 메일쓰기
     function page(){
       if(!isset($_SESSION['userid']) && ($_SESSION['userid'] == "")){
         redirect("");
       }
       $uid = $_SESSION["userid"];
       $data['sign_list'] = $this->M_write->get_signlist($uid);
       $data['mygroup_list'] = $this->M_write->get_mygroup($uid);

       $recent_arr = $this->M_write->get_recentmail($uid);
       $recent_list = array();
       foreach ($recent_arr as $ra) {
         array_push($recent_list, $ra['goto']);
       }
       $data['recentmail_list'] = $recent_list;
       $data['mode'] = 0;
       if(isset($_POST["reply_mode"])){
         $data['mode'] = $this->input->post("reply_mode");
         if ($_POST["reply_mode"] == 2) {
           // code...
           $reply_to = explode(",", $this->input->post("reply_target_to"));
           $reply_cc = explode(",", $this->input->post("reply_target_cc"));
           $reply_cc = array_diff($reply_cc, $reply_to);
           // $reply_to = array_unique($reply_to);
           // $result_search = array_search($uid, $reply_to);
           //
           // if($result_search || $result_search == 0){
           //   array_splice( $reply_to, $result_search, 1 );
           // }
           $data['reply_to'] = implode( ',', $reply_to );
           $data['reply_cc'] = implode( ',', $reply_cc );

           // $data['reply_cc'] = $this->input->post("reply_target_cc");
         } else {
           $data['reply_to'] = $this->input->post("reply_target_to");
           $data['reply_cc'] = $this->input->post("reply_target_cc");

         }
         $data['reply_title'] = $this->input->post("reply_title");
         $data['reply_content'] = htmlspecialchars($this->input->post("reply_content"));
         $reply_file = $this->input->post("reply_file");
         if (!empty($reply_file)) {
           // $reply_file = htmlspecialchars_decode($reply_file);
           // $reply_file = preg_replace('/[\x00-\x1F\x7F]/u', '', $reply_file);
           // $reply_file = substr($reply_file, 1, -1);
           $data['reply_file'] = json_decode($reply_file);
           // var_dump($data['reply_file']);
           // exit;
         }
       }

       if(isset($_POST["self_write"])){
         $data['mode'] = $this->input->post("self_write");
         $data['reply_to'] = $_SESSION["userid"];

       }

       if ($this->agent->is_mobile()) {
         $this->load->view('mobile/mail_write_mobile', $data);
       } else {

         $this->load->view('mail_write_page', $data);
       }

     }


     function mail_write_action(){
				 $config['useragent'] = '';
				 $config['protocol'] = 'smtp';
				 // $config['smtp_host'] = '192.168.0.100';
				 // $config['smtp_user'] = 'bhkim@durianit.co.kr';
				 // $config['smtp_pass'] = 'durian12#';
				 $config['smtp_host'] = '192.168.0.100';
				 $config['smtp_user'] = $_SESSION["userid"];
				 $config['smtp_pass'] = $this->decrypted;
				 $config['smtp_port'] = 25;
				 $config['smtp_timeout'] = 5;
				 $config['wordwrap'] = TRUE;
				 $config['wrapchars'] = 76;
				 $config['mailtype'] = 'html';
				 $config['charset'] = 'utf-8';
				 $config['validate'] = FALSE;
				 $config['priority'] = 3;
				 $config['crlf'] = "\r\n";
				 $config['newline'] = "\r\n";
				 $config['bcc_batch_mode'] = FALSE;
				 $config['bcc_batch_size'] = 200;
         $contents = "";
         $bigfile_name = $this->input->post("bigfileName");
         $bigfile_upname = $this->input->post("bigfileUpName");
         $bigfile_size = $this->input->post("bigfileSize");
         $expiration = strtotime("+2 months");
         $expiration_date = date("Y-m-d", $expiration);
         if (isset($bigfile_name)) {
           $bigfiletable = "<table>";
           $bigfiletable.= "<tr><td colspan='2' style='font-weight:bold;border-bottom:1px solid black;'>대용량 첨부파일</td></tr>";
           for ($i=0; $i < count($bigfile_name); $i++) {
             $insert_arr = array(
               "filename" => $bigfile_upname[$i],
               "insert_date" => date("Y-m-d"),
               "insert_id" => $_SESSION['userid']
             );
             $this->M_write->insert_bigfile($insert_arr);
             $bigfiletable.= "<tr><td>";
             $bigfiletable.= "<a href='https://mail.durianit.co.kr/misc/upload/bigfile/{$bigfile_upname[$i]}' download='{$bigfile_name[$i]}'>";
             $bigfiletable.= "{$bigfile_name[$i]}<img src='https://mail.durianit.co.kr/misc/img/download.svg' style='width:15px;vertical-align:middle;cursor:pointer;margin:5px 0px 5px 10px;'></td>";
             $bigfiletable.= "<td>{$bigfile_size[$i]}</td></tr>";
           }
           $bigfiletable.= "<tr><td colspan='2' style='border-top:1px solid black;'>다운로드 만료기간 : ~{$expiration_date}</td></tr>";
           $bigfiletable.="</table>";
           $contents .= $bigfiletable;
         }

         $contents .= $this->input->post("contents"); //뷰에서 ck에디터 textarea의 name값 가져온다!!!!!!!
		     $recipient=$this->input->post("recipient");

		     $title=$this->input->post("title");
         $title = trim($title);
		     $cc=$this->input->post("cc");
		     $bcc=$this->input->post("bcc");
         // $attachment=$this->input->post('attachment'); //뷰에서 첨부파일  name값 가져와
// echo $_FILES['attachment']['name'].'<br><br>';
// var_dump($_FILES['attachment']).'<br><br>';

			   if(isset($_FILES['files']['name'])){
			      $file_num = count($_FILES['files']['name']);
			   }

         $this->email->initialize($config);
         $to_address = $this->input->post('recipient');
         // if($to_address){
         //
         // }

         $this->email->clear();
         $this->email->from($config['smtp_user']);

         // $recipients = array($to_address);
         $recipients = preg_replace("/\s+/", "", $to_address);
         $recipients = explode(',' ,$recipients);
         $recipients = array_filter($recipients);
         $this->email->to($recipients);  //$recipient

         $to_cc = $this->input->post('cc');
         // $cc = array($to_cc);
         $cc = preg_replace("/\s+/", "", $to_cc);
         $cc = explode(',' ,$cc);
         $cc = array_filter($cc);
         $this->email->cc($cc);

         $to_bcc = $this->input->post('bcc');
         $bcc = preg_replace("/\s+/", "", $to_bcc);
         $bcc = explode(',' ,$bcc);
         $bcc = array_filter($bcc);
         // $bcc = array($to_bcc);
         // $this->email->bcc(implod(',' ,$bcc));
         $this->email->bcc($bcc);

         $this->email->subject($title);
         $this->email->message($contents);

         // 메일 전달 시 첨부파일 있는 경우
         if(isset($_POST["fw_mbox"])){
           $fw_mbox = $this->input->post("fw_mbox");
           $fw_msgno = $this->input->post("fw_msgno");
           $part_info = $this->input->post("fw_part");


           $mailserver = "192.168.0.100";
           $host = "{" . $mailserver . ":143/imap/novalidate-cert}{$fw_mbox}";
           $imap = @imap_open($host, $_SESSION["userid"], $this->decrypted);
           for ($i=0; $i < count($part_info); $i++) {
             $part_arr = explode(",", $part_info[$i]);
             $part_num = $part_arr[0];
             $content_type = $part_arr[1];
             $encode = $part_arr[2];
             $subtype = $part_arr[3];
             $disposition = $part_arr[4];
             $realname = $part_arr[5];

             $attach_source = imap_fetchbody($imap, $fw_msgno, $part_num);
             $result_fw = $this->email->_fw_attachfile($content_type, $encode, $subtype, $disposition, $realname, $attach_source);

           }
         }

		      if(isset($file_num)){
		         for ($i=0; $i < $file_num; $i++) {
		            $att_real = $_FILES['files']['name'][$i];
		            $this->email->attach($_FILES['files']['tmp_name'][$i], 'attachment', $att_real);
		         	}
		      	}
           $result = $this->email->send(FALSE);
           $raw_data = $this->email->append_rawdata();
           // echo $raw_data;
           // exit;
           if(!$result){
              $err_msg = $this->email->print_debugger();
              // echo $err_msg;
              // echo json_encode($err_msg);
              // $this->email->clear(TRUE);
              echo $err_msg;
           }else{
             $recentmail = array();
             foreach ($recipients as $re) {
               $insert_data = array(
                 'goto' => $re,
                 'uid' => $_SESSION["userid"],
                 'insert_date' => date("Y-m-d H:i:s")
               );
               array_push($recentmail, $insert_data);
             }

             foreach ($cc as $c) {
               $insert_data = array(
                 'goto' => $c,
                 'uid' => $_SESSION["userid"],
                 'insert_date' => date("Y-m-d H:i:s")
               );
               array_push($recentmail, $insert_data);
             }
             $this->M_write->insert_recentmail($recentmail);
             $raw_data = $this->email->append_rawdata();
             // echo $raw_data;
             // exit;
             $this->email->clear(TRUE);
             $dmy = date("Y-m-d h:i:s");
             $mailserver = "192.168.0.100";
             $sendmail_classify = $this->M_write->sendmail_classify($to_address);
             // var_dump($sendmail_classify);
             if($sendmail_classify == "default"){
               $send_dir = "&vPSwuA- &07jJwNVo-";
             }else{
               $send_dir = $sendmail_classify;
             }
             $host = "{" . $mailserver . ":143/imap/novalidate-cert}".$sendmail_classify;
             $imap = @imap_open($host, $_SESSION["userid"], $this->decrypted);
             $mail_msg = "From: {$_SESSION["userid"]}\r\n"
             . "Date:{$dmy}\r\n"
             . "To: {$to_address}\r\n"
             . "cc: {$to_cc}\r\n"
             . "bcc: {$to_bcc}\r\n"
             . "Subject: {$title}\r\n"
             . "MIME-Version: 1.0\r\n"
             // . "Content-Type: text/html; charset=".$charset."; format=flowed\r\n"
             // . "Content-Transfer-Encoding: quoted-printable \r\n"
             . "{$raw_data}\r\n";
             $append = imap_append($imap, $host, $raw_data, "\\SEEN");

              echo json_encode("success");
           }

         }

     // 보낸 메일함 함수
     function mail_outbox(){
        $this->load->view('mail_outbox');
     }


     // 주소록 그룹버튼(ajax사용, db에서 모든 데이터 가져오기)
     function group_button(){
        $keyword = $this->input->get('g_name');
        $result= $this->M_addressbook->group_button($keyword);
        echo json_encode($result);
     }

     function lmtp_valid(){
       $mail = $this->input->post("mail");
       $result = $this->M_addressbook->check_lmtp($mail);
       echo json_encode($result->cnt);
     }

}
