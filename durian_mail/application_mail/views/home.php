<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>메일</title>
  </head>
  <body>

        <?php
        // $username = "bhkim@durianit.co.kr";
        // $password = "durian12#";
        // $password = "$1$B877FIPR$jqqd0ABXb8p/UfREQlCpl.";
        // $mailserver = "192.168.0.100";

        // $username = "test2@durianict.co.kr";
        // $password = "durian12#";
        // $mailserver = "192.168.0.50";

        $username = "hjsong@durianit.co.kr";
        $password = "durian12#";
        $mailserver = "192.168.0.100";

        // $username = "go_go_ssing";
        // $password = "gurwndA!23";
        // $mailserver = "imap.naver.com";

            // POP3 서버
            //$mailbox = @imap_open("{" . $mailserver . ":110/pop3}INBOX", $username, $password);

            // IMAP 서버
             $mailbox = @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $username, $password);

            // Gmail/Naver 서버
            // $mailbox = imap_open("{" . $mailserver . ":993/imap/novalidate-cert/ssl}INBOX", $username, $password);

            if($mailbox){
                $mails = imap_check($mailbox);
                $count = $mails->Nmsgs;
                if($count >= 1){
                   echo "{$count} 건~<br>";
                   // print_r($mailbox)
                   // var_dump($mails)
                   // var_dump($mails->Mailbox)
                   // string(77) "{192.168.0.50:143/imap/tls/novalidate-cert/user="test2@durianict.co.kr"}INBOX"
                   ?>
                   <pre>
                     <?php
                      $head = imap_header($mailbox, 1);   // 1번 메일의 head정보 알기위한 테스트
                      $body = imap_body($mailbox, 1);    // 1번 메일의 body정보 알기위한 테스트
                      var_dump($head);
                      echo '<hr>';
                      var_dump($body);
                      echo '<hr>';
                      ?>
                   </pre>
                    <table border=1 style="margin-top:20px;margin-bottom:50px;">
                      <tr>
                          <td>No</td>
                          <td>제목</td>
                          <td>날짜</td>
                          <td>발신자</td>
                          <td>크기</td>
                      </tr>
                      <?php
                        for($num = 1; $num <= $count; $num ++){
                          $head = imap_header($mailbox, $num);
                          $body = trim(substr(imap_body($mailbox, $num), 0, 300));
                          $content = imap_fetchbody($mailbox, $num, 1);     // text/plain
                          $content2 = imap_fetchbody($mailbox, $num, 1.1);  // multipart/alternative
                          ?>
                          <tr>
                              <td><?= $num ?></td>
                              <td nowrap><?= imap_utf8($head->subject)?></td>
                              <td><?= base64_decode($content2)?></td>
                              <td><?= $body ?></td>
                              <!-- <td nowrap><?= htmlspecialchars(mb_decode_mimeheader($head->fromaddress))?></td> -->
                              <td nowrap><?= $head->Size ?></td>
                          </tr>
                          <?php
                        }
                      ?>
                    </table>
                    <?php
                }else{
                    ?>
                    새로운 메일이 없습니다.<br>
                    <?php
                }
                imap_close($mailbox);
            }else{
                ?>
                사용자명 또는 패스워드가 틀립니다.
                <?php
            }
        ?>


        <?php

    // $inbox = @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $username, $password);
    //
    // $emails = imap_search($inbox,'ALL');
    //
    // if($emails) {
    //     $output = '';
    //     rsort($emails);
    //
    //     foreach($emails as $email_number) {
    //         $overview = imap_fetch_overview($inbox,$email_number,0);
    //         $structure = imap_fetchstructure($inbox, $email_number);
    //
    //         if(isset($structure->parts) && is_array($structure->parts) && isset($structure->parts[1])) {
    //             $part = $structure->parts[1];
    //             $message = imap_fetchbody($inbox,$email_number,2);
    //
    //             if($part->encoding == 3) {
    //                 $message = imap_base64($message);
    //             } else if($part->encoding == 1) {
    //                 $message = imap_8bit($message);
    //             } else {
    //                 $message = imap_qprint($message);
    //             }
    //         }
    //
    //         $output.= '<br><br><br><span class="subject">제목('.$part->encoding.'): '.htmlspecialchars(mb_decode_mimeheader($overview[0]->subject)).'</span> ';
    //         $output.= '<div style="margin-top:20px;" class="toggle'.($overview[0]->seen ? 'read' : 'unread').'">';
    //         $output.= '<span class="from">발신자: '.htmlspecialchars(mb_decode_mimeheader($overview[0]->from)).'</span>';
    //         $output.= '<span class="date" style="margin-left:10px;">날짜: '.utf8_decode(imap_utf8($overview[0]->date)).'</span>';
    //         $output.= '</div>';
    //
    //         $output.= '<div class="body">'.$message.'</div><hr/>';
    //     }
    //
    //     echo $output;
    // }
    //
    // imap_close($inbox);
    ?>
  </body>
</html>
