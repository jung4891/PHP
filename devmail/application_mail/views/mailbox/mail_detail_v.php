<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_side.php";
 ?>

 <div id="main_contents" style=" padding-left: 20px; ">
  <div class="main_div" >
   <table width="100%" border="0" cellpadding="4" cellspacing="0">
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
       <?php if ($attachments != "") { ?>
       <td align="center" bgcolor="#E7E7E7">첨부파일</td>
       <td bgcolor="#F7F7F7">
         <?php echo $attachments; ?>
       </td>
       <?php } ?>
     </tr>
     <tr>
       <td colspan="2"><?php echo $contents; ?> </td>
     </tr>

     <!-- struct 테스트용 -->
     <tr>
      <td colspan="2">
        <h3>$struct</h3>
        <pre>
          <?php var_dump($struct);?>
        </pre>
      </td>
     </tr>

     <!-- body 테스트용 -->
     <!-- <tr>
       <td colspan="2">
         <h3>$body</h3>
         <pre>
           <?php // var_dump($body); ?>
         </pre>
       </td>
     </tr> -->

   </table>
 </div>
</div>

<script type="text/javascript">

  function download(box, msg_no, part_no, f_name) {
    var newForm = $('<form></form>');
    newForm.attr("method","post");
    newForm.attr("action", "<?php echo site_url(); ?>/mailbox/download");
    // site_url() : http://dev.mail.durianit.co.kr/devmail/index.php

    newForm.append($('<input>', {type: 'hidden', name: 'box', value: box }));
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
