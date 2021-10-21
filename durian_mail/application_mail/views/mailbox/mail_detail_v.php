<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>
<style media="screen">
  body {

  }
</style>
 <div id="main_contents" style="padding-left: 20px;">
   <p>제목: <?php echo $title;?></p>
   <p>발신자: <?php echo $from_addr;?></p>
   <p>수신자: <?php echo $to_addr;?></p>
   <hr>
   <p>내용: <br><br> <?php echo $contents;?></p>
 </div>

<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
?>
