<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_side.php";
 ?>
<style media="screen">
  body {

  }
</style>
 <div id="main_contents" style=" padding-left: 20px; ">
  <div class="main_div" >
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
       <td align="center" bgcolor="#E7E7E7">첨부파일</td>
       <td bgcolor="#F7F7F7">
         <?php echo $attachments; ?>
       </td>
     </tr>
     <tr>
       <?php

      function getPart($connection, $messageNumber, $partNumber, $encoding, $charset) {
      	$data = imap_fetchbody($connection, $messageNumber, $partNumber);
        $body = imap_body($connection, $messageNumber);
        // echo '<pre>';
        // var_dump($body);
        // echo '<br>여기까지가 body<br>';
        // echo '</pre>';
      	switch($encoding) {
      		case 0: return $data; // 7BIT
      		case 1: return $data; // 8BIT
      		case 2: return $data; // BINARY
      		case 3: return base64_decode($data); // BASE64
      		case 4:
          // echo $data;
            $data = quoted_printable_decode($data);    // QUOTED_PRINTABLE

            if ($charset == 'ks_c_5601-1987')          // else는 charset이 utf-8로 iconv 불필요
              $data = iconv('euc-kr', 'utf-8', $data);
            return $data;

      		case 5: return $data; // OTHER
      	}
      }

      function getFilenameFromPart($part) {
      	$filename = '';
    		foreach($part->parameters as $object) {
    			if(strtolower($object->attribute) == 'name') {
    				$filename = $object->value;
    			}
    		}

      	// if(!$filename && $part->ifparameters) {
      	// 	foreach($part->parameters as $object) {
      	// 		if(strtolower($object->attribute) == 'name') {
      	// 			$filename = $object->value;
      	// 		}
      	// 	}
      	// }
      	return imap_utf8($filename);   // 한글일 경우 ?ks_c_5601-1987?여서 디코딩 해야함
      }

    ?>
     <td colspan="2"><?php echo $contents; ?> </td>
     </tr>

     <?php
      ?>

      <!-- 아래 pre태그를 이용해서 간편하게 조회하기 위해 만든 헬퍼 함수 -->
      <!-- ★ 헬퍼 로드 안하고 아래 실행하면 internal 서버오류나고 자바스크립트 실행 안되게됨~~~!!!  -->
      <!-- <?php // var_pre($struct); ?> -->

     <!-- struct 테스트용 -->
     <!-- <tr>
      <td colspan="2">
        <h3>$struct</h3>
        <pre>
          <?php // var_dump($struct);?>
        </pre>
      </td>
     </tr> -->

     <!-- flattenedParts 테스트용 -->
    <!-- <tr>
     <td colspan="2">
       <h3>$flattenedParts</h3>
       <pre>
         <?php // var_dump($flattenedParts);?>
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
</div>

<script type="text/javascript">
  function show_image() {
    alert('aa');
    // var imgArr = $('img').length;
    // var imgArr = $("img").eq(14).attr("src");
    // console.log(image);
  }

  function download(mbox, msg_no, part_no, f_name) {
    var newForm = $('<form></form>');
    newForm.attr("method","post");
    newForm.attr("action", "<?php echo site_url(); ?>/mailbox/download");
    // site_url() : http://dev.mail.durianit.co.kr/devmail/index.php

    newForm.append($('<input>', {type: 'hidden', name: 'mbox', value: mbox }));
    newForm.append($('<input>', {type: 'hidden', name: 'msg_no', value: msg_no }));
    newForm.append($('<input>', {type: 'hidden', name: 'part_no', value: part_no }));
    newForm.append($('<input>', {type: 'hidden', name: 'f_name', value: f_name }));

    newForm.appendTo('body');
    newForm.submit();
  }
</script>

<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_footer.php";
?>
