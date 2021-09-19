<!DOCTYPE html>
<html lang = "kr" >
<head>
<meta charset = "utf-8" > 
<title> 테스트페이지 </title>
</head>
<body>
  <?php
    $testDate = $_POST [ "testDate" ];
    echo $testDate ;
    print_r( "<br><br>" );
  ?>
  <form method = "POST" action = "<?php echo $_SERVER [ 'PHP_SELF' ];?>" >
    <input type = "date" name = "testDate" value =<?php echo $testDate ?> >
    <input type = "submit" value = "전송" />
  </form>
</body>
</html>
