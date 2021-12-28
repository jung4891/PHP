<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dbmailtest2 extends CI_Controller {
  function __construct() {

    if (isset($_SERVER['REQUEST_URI'])) {
    $req_uri = explode('/',$_SERVER['REQUEST_URI']);
    // if ($req_uri[1] == API_URI) {
    // echo $req_uri[1];
        get_config(array('csrf_protection' => false));
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
    // }
  }
      parent::__construct();
      if(!isset($_SESSION)){
          session_start();
      }
      $this->load->helper(array('url', 'download'));
      $this->load->library('pagination', 'email');
      $this->load->Model('M_account');
      // $this->load->Model('M_dbmail');

      // $this->mail = $this->input->get("mail_address");
      // $this->password = $this->input->get("password");
      // $this->mailbox = $this->input->get("mailbox");
      $this->mail = "test4@durianict.co.kr";
      $this->password = "durian12#";
      $this->mailbox = "INBOX";
      $this->mailserver = "192.168.0.50";

      // $encryp_password = $this->M_account->mbox_conf($_SESSION['userid']);
			// $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
      // $key = $this->db->password;
      // $key = substr(hash('sha256', $key, true), 0, 32);
			// $decrypted = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);
      // $this->mailserver = "192.168.0.50";
      // $this->user_id = $_SESSION["userid"];
      // $this->user_pwd = $decrypted;
      // $this->defalt_folder = array(
      //   "INBOX",
      //   "&vPSwuA- &07jJwNVo-",
      //   "&x4TC3A- &vPStANVo-",
      //   "&yBXQbA- &ulTHfA-",
      //   "&ycDGtA- &07jJwNVo-"
      // );
  }

  function get_threads(){
    $stream = $this->connect_mailserver();
    $attach = $this->_get_attachments(729, imap_fetchstructure($stream, 729));

    var_dump($attach);
  }


  public function get_attachment(int $uid, int $index = 0)
	{

		$id         = imap_msgno($this->stream, $uid);
		$structure  = imap_fetchstructure($this->stream, $id);
		$attachment = $this->_get_attachments($uid, $structure, '', $index);

		$this->set_cache($cache_id, $attachment);

		if (empty($attachment))
		{
			return false;
		}

		return $attachment;
	}

  public function get_attachments(int $uid, array $indexes = [])
	{
		$attachments = [];

		foreach ($indexes as $index)
		{
			$attachments[] = $this->get_attachment($uid, (int)$index);
		}

		return $attachments;
	}

	/**
	 * [_get_attachments description]
	 *
	 * @param integer      $uid
	 * @param object       $structure
	 * @param string       $part_number
	 * @param integer|null $index
	 * @param boolean      $with_content
	 *
	 * @return array
	 */
	protected function _get_attachments(int $uid, $structure, string $part_number = '',	int $index = null)
	{
		$id          = imap_msgno($this->connect_mailserver(), $uid);
		$attachments = [];

		if (isset($structure->parts))
		{
			foreach ($structure->parts as $key => $sub_structure)
			{
				$new_part_number = empty($part_number) ? $key + 1 : $part_number . '.' . ($key + 1);

				$results = $this->_get_attachments($uid, $sub_structure, $new_part_number);

				if (count($results))
				{
					if (isset($results[0]['name']))
					{
						foreach ($results as $result)
						{
							array_push($attachments, $result);
						}
					}
					else
					{
						array_push($attachments, $results);
					}
				}

				// If we already have the given indexes return here
				if (! is_null($index) && isset($attachments[$index]))
				{
					return $attachments[$index];
				}
			}
		}
		else
		{
			$attachment = [];

			if (isset($structure->dparameters[0]))
			{
				$bodystruct   = imap_bodystruct($this->connect_mailserver(), $id, $part_number);
				$decoded_name = imap_mime_header_decode($bodystruct->dparameters[0]->value);
				$filename     = $this->convert_to_utf8($decoded_name[0]->text);
				$content      = imap_fetchbody($this->connect_mailserver(), $id, $part_number);
				$content      = (string)$this->struc_decoding($content, $bodystruct->encoding);

				$attachment = [
					'name'         => (string)$filename,
					'part_number'  => (string)$part_number,
					'encoding'     => (int)$bodystruct->encoding,
					'size'         => (int)$structure->bytes,
					'reference'    => isset($bodystruct->id) ? (string)$bodystruct->id : '',
					'disposition'  => (string)strtolower($structure->disposition),
					'type'         => (string)strtolower($structure->subtype),
					'content'      => $content,
					'content_size' => strlen($content),
				];
			}

			return $attachment;
		}

		return $attachments;
	}

	/**
	 * [struc_decoding description]
	 *
	 * @param string  $text
	 * @param integer $encoding
	 *
	 * @see http://php.net/manual/pt_BR/function.imap-fetchstructure.php
	 *
	 * @return string
	 */
 function struc_decoding(string $text, int $encoding = 5)
	{
		switch ($encoding)
		{
			case ENC7BIT: // 0 7bit
				return $text;
			case ENC8BIT: // 1 8bit
				return imap_8bit($text);
			case ENCBINARY: // 2 Binary
				return imap_binary($text);
			case ENCBASE64: // 3 Base64
				return imap_base64($text);
			case ENCQUOTEDPRINTABLE: // 4 Quoted-Printable
				return quoted_printable_decode($text);
			case ENCOTHER: // 5 other
				return $text;
			default:
				return $text;
		}
	}


  function convert_to_utf8(string $str)
  {
    if (mb_detect_encoding($str, 'UTF-8, ISO-8859-1, GBK') !== 'UTF-8')
    {
      $str = utf8_encode($str);
    }

    $str = iconv('UTF-8', 'UTF-8//IGNORE', $str);

    return $str;
  }
    // $thread = $this->imap_sort();
    // $arr1 = array();
    // foreach ($thread as $key) {
    // //   // code...
    //
    //   $a1 = imap_uid ( $this->connect_mailserver() , $key );
    //   $a2 = array("no"=>$key, "uid"=>$a1);
    //   array_push($arr1, $a2);
    // }
		// $thread = imap_thread($this->connect_mailserver(), SE_UID);
		// $items  = [];
    //
		// foreach ($thread as $key => $uid)
		// {
		// 	$item = explode('.', $key);
    //
		// 	$node = (int)$item[0];
    //
		// 	$items[$node]['node'] = $node;
    //
    //
		// 	switch ($item[1]) {
		// 		case 'num':
		// 			$items[$node]['num'] = $uid;
		// 			$message = $this->get_message($uid);
		// 			$items[$node]['msg'] = $message['subject'] . ' - ' . $message['date'];
		// 			break;
		// 		case 'next':
		// 			$items[$node]['next'] = $uid; // node id
		// 			break;
		// 		case 'branch':
		// 			$items[$node]['branch'] = $uid; // node id
		// 			break;
		// 	}
		// }
    // var_dump($structure);
		// return $items;
	// }


  public function connect_mailserver($mbox="") {

    // 접속정보 설정
    $mailserver = $this->mailserver;
    $host = "{" . $mailserver . ":143/imap/novalidate-cert}$mbox";
    $user_id = $this->mail;
    $user_pwd = $this->password;
    // 메일함 접속
    // imap_open() : 메일서버에 접속하기 위한 함수 (접속에 성공하면 $mailbox에 IMAP 스트림(mailstream)이 할당됨)
    // (@ : 오류메시지를 무효로 처리하여 경고 문구가 표시되지 않게함)
    return @imap_open($host, $user_id, $user_pwd);
  }

  function test() {
    $subject_target = "업무";
    $subject_target = iconv('utf-8', 'euc-kr', $subject_target);
    // $mailno_arr_target = imap_sort($mails, SORTDATE, 1, 0, "SUBJECT $subject_target", 'KS_C_5601-1987');
    $mailno_arr_target = imap_sort($this->connect_mailserver('INBOX'), SORTDATE, 1, 0, "BODY $subject_target");
    // $mailno_arr_target = imap_search($mails, "SUBJECT $subject_target", SE_FREE, 'KS_C_5601-1987');
    // $mailno_arr_target = imap_search($mails, "SUBJECT $subject_target", SE_FREE);
    var_dump($mailno_arr_target);
  }

  function insert_test(){
    // $mailno_arr = $this->imap_sort();
    $uid = imap_uid($this->connect_mailserver(), 340);
    echo $uid;
 //    $mail_head = array();
 //    if(count($mailno_arr) > 0){
 //      echo count($mailno_arr);
 //      // $mail_count = (count($mailno_arr) >= 7)?7:count($mailno_arr);
 //      for ($i=0; $i < 100 ; $i++) {
 //        $msg_no = $mailno_arr[$i];
 //        $head_info = imap_headerinfo($this->connect_mailserver(), $msg_no);
 //
	// 			$from = isset($head_info->from[0]) ? (array)$this->to_address($head_info->from[0]) : array();
 //        $decode_head = array(
 //           'uid' => $msg_no,
 //           // 'mail_id' => imap_uid($this->connect_mailserver(), $msg_no),
	// 				 'mbox' => "INBOX",
	// 				 'address' => $this->mail,
 //           'from_name' => $from['name'],
	// 				 'from_mail' => $from['email'],
 //           // 'to' => isset($head_info->to) ? (array)$this->array_to_address($head_info->to) : array(),
 //           // 'cc' => isset($head_info->cc) ? (array)$this->array_to_address($head_info->cc) : array(),
 //           // 'bcc' => isset($head_info->bcc) ? (array)$this->array_to_address($head_info->bcc) : array(),
 //           // 'date' => $head_info->date,
 //           'udate' => date("Y-m-d H:i:s", $head_info->udate),
 //           'subject' => isset($head_info->subject) ? imap_utf8($head_info->subject) : '(제목 없음)',
 //           'size' => (int)$head_info->Size,
	// 				 // 'read' => $head_info->Unseen
 //           'read' => (strlen(trim($head_info->Unseen)) < 1)?1:0
 //        );
 //        $this->load->Model('M_dbmail');
 //        // $insert_mailhead = $this->M_dbmail->mailhead_insert($decode_head);
 // // vim /home/vmail/durianict.co.kr/bhkim/dovecot-uidlist
	// 			// $insert_mailhead = $this->STC_mail->mailhead_insert($decode_head);
	// 			array_push($mail_head, $decode_head);
 //      }
      // $output = null;
      // $return_var = null;
      // exec("id", $output);
      // echo '$output : ';
      // print_r($output);
      // var_dump($output);
      // echo '<br>';
      // print_r($return_var);
      // var_dump($return_var);
//       if($fp = fopen('/home/vmail/durianict.co.kr/bhkim/dovecot-uidlist', 'r')){
//     // 바이너리로 읽기
//     // 파일 포인터로 지정된 파일에서 최대 길이 1024*100 만큼 브라우저로 출력합니다.
//      print(fread($fp,1024*100));
//      flush();
//      // 파일을 오픈하면, 다른 스크립트에서  이용할 수 있도록 반드시 파일 포인터를 닫아야 합니다.
//      fclose($fp);
// }
      // var_dump($mail_head);

    //
    // } else {
    //
    //   echo "empty";
    //
    // }
    // echo json_encode($mail);
  }


  function imap_sort($sort_by = 'date', $descending = 1, $search_criteria = "ALL"){
  // SORTDATE - 메시지 날짜
  // SORTARRIVAL - 도착 일
  // SORTFROM - 첫 번째 보낸 사람 주소의 사서함
  // SORTSUBJECT - 메시지 제목
  // SORTTO - 첫 번째 받는 사람 주소의 사서함
  // SORTCC - 첫 번째 참조 주소의 사서함
  // SORTSIZE - 옥텟의 메시지 크기
  $mail = $this->connect_mailserver();
    $criterias = array(
        'date'    => SORTDATE,
        'arrival' => SORTARRIVAL,
        'from'    => SORTFROM,
        'subject' => SORTSUBJECT,
        'to'      => SORTTO,
        'cc'      => SORTCC,
        'size'    => SORTSIZE,
    );

    // $search_criteria = "UNSEEN";

    return imap_sort($mail, $criterias[$sort_by], $descending, 0, $search_criteria);
}


 function array_to_address($addresses){
  $formated = array();
  foreach ($addresses as $address)
  {
    $formated[] = $this->to_address($address);
  }

  return $formated;
 }


 function to_address($headerinfos){
  $from = array(
    'email' => '',
    'name'  => '',
  );

  if (isset($headerinfos->mailbox) && isset($headerinfos->host))
  {
    $from['email'] = $headerinfos->mailbox . '@' . $headerinfos->host;
  }

  if (! empty($headerinfos->personal))
  {
    // imap_mime_header_decode는 인코딩된 문자열의 charset => 인코딩 양식과 text => 디코딩된 값으로 배열이 반환된다.
    // $name         = imap_mime_header_decode($headerinfos->personal);
    // $name         = $name[0]->text;
    // $from['name'] = empty($name) ? '' : imap_utf8($name);

    $name         = imap_utf8($headerinfos->personal);
    // $name         = $name[0]->text;
    $from['name'] = empty($name) ? '' : $name;
  }

  return $from;
}

}


 ?>
