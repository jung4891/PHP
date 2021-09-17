<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    $phone = '0107124891';
    $phone_length = strlen($phone);
    if ( $phone_length == 10 OR $phone_length  == 11) {
      $head = substr($phone, 0, 3);       // 010
      $mid = substr($phone, 3, -4);       // 7124 or 712(3자)
      $tail = substr($phone, -4);         // 4891
      $phone = $head.'-'.$mid.'-'.$tail;
      echo $phone.'<br>';
    }

     ?>
  </body>
</html>
