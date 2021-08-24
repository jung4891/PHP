<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    echo '1<br>';
    if(false) {
      echo '2-1<br>';
    } else {
      echo '2-2<br>';   // if가 false이므로 else가 실행
    };
    if(0) {
      echo '3-1<br>';   // if(1)이면 이게 출력됨.
    } else {
      echo '3-2<br>';   // 역시 3-2가 출력됨.
    }
    if(null) {
      echo '4-1<br>';
    } else {
      echo '4-2<br>';   // 역시 4-2가 출력됨.
    }
    echo '10<br>';
     ?>
  </body>
</html>
