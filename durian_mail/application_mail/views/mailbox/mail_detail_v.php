<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>
<style media="screen">
  body {

  }
</style>
 <div id="main_contents" style="padding-left: 20px; padding-top: 20px;">
   <table width="90%" border="0" cellpadding="4" cellspacing="0">
     <tr>
       <td align="center" bgcolor="#E7E7E7" width="100">보낸날짜</td>
       <td bgcolor="#F7F7F7">&nbsp;<?php echo $date;?></td>
     </tr>
     <tr>
       <td align="center" bgcolor="#E7E7E7">보낸이</td>
       <td bgcolor="#F7F7F7">&nbsp;<?php echo $from_addr;?></td>
     </tr>
     <tr>
       <td align="center" bgcolor="#E7E7E7">받는이</td>
       <td bgcolor="#F7F7F7">&nbsp;<?php echo $to_addr;?></td>
     </tr>
     <tr>
       <td align="center" bgcolor="#E7E7E7">제 &nbsp; 목</td>
       <td bgcolor="#F7F7F7">&nbsp;<?php echo $title;?></td>
     </tr>
     <tr>
      <td colspan="2"><br><?php echo $contents ?> </td>
     </tr>
     <!-- struct 테스트용 -->
     <!-- <tr>
      <td colspan="2">
        <h3>$struct</h3>
        <pre>
          <?php // var_dump($struct);?>
        </pre>
      </td>
     </tr> -->
     <!-- body 테스트용 -->
     <!-- <tr>
       <td colspan="2">
         <h3>$body</h3>
         <pre>
           <?php // var_dump($body); ?>
         </pre>
       </td>
     </tr> -->
     <?php

     // 메일함 목록 테스트
     // $user_id = "hjsong@durianit.co.kr";
     // $user_pwd = "durian12#";
     // $mailserver = "192.168.0.100";
     // $mails= @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}{$mbox}", $user_id, $user_pwd);
     //
     // $mailboxes = imap_list($mails, "{" . $mailserver . ":143}", '*');
     // echo '<pre>';
     // var_dump($mailboxes);
     // echo '</pre>';
      ?>
   </table>
 </div>

<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
?>
