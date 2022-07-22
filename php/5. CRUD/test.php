<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
<?php
  if ($_POST) {
    $testDate = $_POST [ "testDate" ];
    echo $testDate;

    $testDate2 = $_POST [ "data1" ];
    echo $testDate2;
  }
 ?>
  </body>
</html>
