<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

      // 함수
      // Argument : 함수에 전달하는 값 (10과 20)
      // Parameter : 함수에서 값을 받는 부분 (num1과 num2)
      // 세번째 파라미터가 값을 받지 못할경우 기본값 설정

      function sumTest($num1, $num2, $num3 = 100) {
        $sum = $num1 + $num2 + $num3;
        echo "합 : {$sum} <br>";
        return $sum;    // 함수를 호출한 곳으로 값을 전달(반환)
      }
      echo "sumTest(10,20) : ".sumTest(10, 20).'<br>';      // 함수 호출
      echo "sumTest(10,20,30) : ".sumTest(10,20,30).'<br>';
      echo '<br>';


     ?>

     <?php
     function sum2($left, $right) {
       return $left + $right;
     }
     print(sum2(2,8));
     file_put_contents('res2.txt', sum2(3,4));
      // 결과값을 이 파일의 디렉토리에 res.txt에 담아 저장
      // 함수는 이처럼 하나의 기능만 담당하는게 좋다. 다양하게 쓰일수 있기 때문.
      // sum()은 합, 출력을 모두 담당하는데 그러면 쓰임이 제한적이다.

      // function 전체는 값이 되는게 아니므로 statement
      // $left + $right는 값이 되므로 표현식이다.

      ?>
  </body>
</html>
