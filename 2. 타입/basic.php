<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      /*
        # 데이터형의 종류
         - int, integer : 정수
         - double : 소수
         - string : 문자열
         - boolean : 논리값(값: true, false)
         - NULL : 없는값(값: null)
         - array : 배열
      */


      // # 데이터형 확인
      // (PHP는 JAVA와 다르게 값을 확인한 후 데이터형을 자동으로 지정해준다.)
      $num = 7;
      echo "\$num 데이터형: ".gettype($num)." (값: {$num}) <br>";
      $num2 = 7.7;
      echo "\$num2 데이터형: ".gettype($num2)." (값: {$num2}) <br>";
      $str = "문자열";
      echo "\$str 데이터형: ".gettype($str)." (값: {$str}) <br>";
      $arr = array();
      echo "\$arr의 데이터형: ".gettype($arr)."<br>";
      $nothing = null;
      echo "\$nothing의 데이터형: ".gettype($nothing)." (값: {$nothing}) <br>";
      $bool = true;   // false면 위 null처럼 값이 아무것도 안뜸.
      echo "\$bool의 데이터형: ".gettype($bool)." (값: {$bool}) <br>";
      echo "-------------------<br>";


      // # 데이터형 변환

      // 1) 숫자로된 string -> int
      $str = "123";
      $num = (int) $str;
      echo gettype($num)." (값: {$num}) <br>";

      // 2) string -> int
      $str = "테스트";
      $num = (int) $str;
      echo gettype($num)." (값: {$num}) <br>";   // 0
      $str = "2테1스1트2";
      $num = (int) $str;
      echo gettype($num)." (값: {$num}) <br>";   // 2

      // 3) double -> int
      $num = 3.8;
      $num2 = (int) $num;
      echo gettype($num2)." (값: {$num2}) <br>"  // 3
     ?>
  </body>
</html>
