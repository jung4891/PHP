<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>메일테스트</title>
  </head>
  <body>

    <?php
    $username = "hjsong@durianit.co.kr";
    $password = "durian12#";
    $mailserver = "192.168.0.100";
    $mailbox = @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $username, $password);

    if($mailbox){
      $mails = imap_check($mailbox);
      $count = $mails->Nmsgs;
      if($count >= 1){

        $head = imap_header($mailbox, 1);                // 1번 메일의 head정보 알기위한 테스트
        // $body = imap_body($mailbox, 4);               // 1번 메일의 body정보 알기위한 테스트
        // $struct = imap_fetchstructure($mailbox, 4);   // 1번 메일의 구조를 알기위한 테스트

        echo '최근 메일개수?: '.imap_num_recent($mailbox).'<br>';     // 최근 메일수 인듯?
        echo '전체 메일수: '.imap_num_msg($mailbox).'<br><br>';       // 전체 메일개수
        echo 'num: 1'.'<br>';
        echo '제목: '.imap_utf8($head->subject).'<br>';
        echo '받는 사람: '.imap_utf8($head->toaddress).'<br>';
        echo '보낸 사람: '.imap_utf8($head->fromaddress).'<br>';
        echo '날짜: '.date("Y/m/d H:i", $head->udate).'<br>';
        echo '크기: '.$head->Size.' Bytes <br>';

        echo '<br>';

        // echo '$head ->';
        // echo '<pre>';
        // var_dump($head);
        // echo '</pre>';
        // echo '<hr>';

        // echo '$struct ->';
        // echo '<pre>';
        //  // var_dump($struct);
        // echo '</pre>';
        // echo '<hr>';

        // echo '$body ->';
        // echo '<pre>';
        // var_dump($body);
        // echo '</pre>';
        // echo '<hr>';
      }
    }
  ?>

  <?php
    // 연구할 것
    // $emails = imap_search($mailbox,'ALL');
    // rsort($emails);
    // imap_fetch_overview($mailbox,$email_number,0);
    ?>
  </body>
</html>
