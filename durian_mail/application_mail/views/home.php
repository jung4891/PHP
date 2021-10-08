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

        $username = "test2@durianict.co.kr";
        $password = "durian12#";
        $mailserver = "192.168.0.50";

        // $username = "hjsong@durianit.co.kr";
        // $password = "durian12#";
        // $mailserver = "192.168.0.100";

        // $username = "go_go_ssing";
        // $password = "gurwnd12#";
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
                   echo "{$count} 건~<br><br>";
                   // print_r($mailbox)
                   // var_dump($mails)
                   // var_dump($mails->Mailbox)
                   // string(77) "{192.168.0.50:143/imap/tls/novalidate-cert/user="test2@durianict.co.kr"}INBOX"
                   ?>

                     <?php
                      // 테스트용
                      $head = imap_header($mailbox, 1);             // 1번 메일의 head정보 알기위한 테스트
                      $body = imap_body($mailbox, 4);               // 1번 메일의 body정보 알기위한 테스트
                      $struct = imap_fetchstructure($mailbox, 4);   // 1번 메일의 구조를 알기위한 테스트
                      echo '<pre>';
                      // var_dump($head);
                       // var_dump($body);
                       // echo '<hr>';
                       // var_dump($struct);
                       // echo '<hr>';
                       $subtype_1 = $struct->subtype;               // 일반메일은 ALTERNATIVE / 첨부는 MIXED
                       switch($subtype_1) {
                         case "ALTERNATIVE":                                  // MIXED
                         $subtype_2 = $struct->parts[1]->subtype;             // parts(2)
                         break;                                               //  - parts(2)
                                                                              //     - 제목
                                                                              //     - 내용
                         case "MIXED":                                        //  - file
                         $subtype_2 = $struct->parts[0]->parts[1]->subtype;
                         break;
                       }
                      echo $subtype_2;
                      echo '</pre>';
                      echo '<hr>';
                      // echo imap_utf8($head->from[0]->personal);   // 발신자 이름
                      // echo htmlspecialchars(mb_decode_mimeheader($head->fromaddress));   발신자이름 <발신자 주소>
                      ?>
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
                          $struct = imap_fetchstructure($mailbox, $num);
                          $subtype = $struct->subtype;
                          switch($subtype) {
                            case "ALTERNATIVE":
                            $content = imap_fetchbody($mailbox, $num, 1);
                            break;
                            case "MIXED":
                            $content = imap_fetchbody($mailbox, $num, '1.1');
                            break;
                          }
                          ?>
                          <tr>
                              <td><?= $num ?></td>
                              <td nowrap><?= imap_utf8($head->subject)?></td>
                              <td><?= imap_base64($content)?></td>
                              <td nowrap><?= imap_utf8($head->from[0]->personal)?></td>
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
