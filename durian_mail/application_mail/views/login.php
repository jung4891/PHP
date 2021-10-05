<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
  </head>
  <body>
    <?php echo site_url(); ?><br>
    <form class="" name="loginForm" action="" method="post">
      아디<input type="text" name="inputId" id="inputId" value=""><br>
      비번<input type="password" name="inputPass" id="inputPass" value="">
      <button type="button" name="button" id="loginBtn">로긴</button>
    </form>
    <?php echo 'DOCUMENT_ROOT -> '.$_SERVER['DOCUMENT_ROOT'].'<br>'; ?>
  </body>
  <script type="text/javascript">

    $("#loginBtn").on("click", function(){
      var mform = document.loginForm;
      mform.inputId.value = mform.inputId.value.trim();
      mform.inputPass.value = mform.inputPass.value.trim();
      mform.action = "<?php echo site_url();?>/mail/mail_test";
      mform.submit();
    })

  </script>
</html>
