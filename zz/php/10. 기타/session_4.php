<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      session_start();
      echo "destroy된 세션 확인 -> <br>";
      echo "<pre>";
      var_dump($_SESSION);
      echo '</pre>';
      /*
        array(0) {
        }
      */
     ?>
  </body>
</html>
