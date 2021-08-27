<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <h4>test()</h4>
    <?php
      function test() {
        print("test1<br>");
        echo "test2";
      }
      test();
     ?>

    <h4>sum()</h4>
    <?php
      function sum($left, $right) {
        print($left + $right);
        print("<br>");
      }
      sum(3, 7);
      // 입력한 실제 값 (3, 7) -> argument
      // 매개변수로 값을 받아 함수 내부에서 쓰이는 것($left) -> parameter
     ?>

     <h4>return</h4>
     <?php
     function sum2($left, $right) {
       return $left + $right;
     }
     print(sum2(2,8));
     file_put_contents('res.txt', sum2(3,4));
      // 결과값을 이 파일의 디렉토리에 res.txt에 담아 저장
      // 함수는 이처럼 하나의 기능만 담당하는게 좋다. 다양하게 쓰일수 있기 때문.
      // sum()은 합, 출력을 모두 담당하는데 그러면 쓰임이 제한적이다.

      // function 전체는 값이 되는게 아니므로 statement
      // $left + $right는 값이 되므로 표현식이다.

      ?>
  </body>
</html>
