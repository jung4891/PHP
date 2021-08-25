<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    echo '1<br>';
    $i = 1;
    while($i < 4) {
      $j = $i;
      while($j > 0) {
        echo $i.'<br>';
        $j = $j - 1;
      }
      $i = $i + 1;
    }
    echo '4<br>';
     ?>

  </body>
</html>

<!--

while(expr) {
  statement
}

프로그래밍의 양대축.
- expr -> 값 또는 최종적으로 값이 되는 것.
          while(expr)에서 expr은 boolean값이 들어옴.
- statement -> while문 if문 처럼 값이 되는게 아닌것.
 -->
