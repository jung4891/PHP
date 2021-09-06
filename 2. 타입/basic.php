<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
        // settype(변수명, 변경할 데이터형) : 변수에 데이터형 지정
        $val = "true";
        echo gettype($val).'<br>';   // string
        settype($val, 'bool');    // boolean도 무관
        echo gettype($val).'<br>';   // boolean
        $val = 10;
        echo gettype($val).'<br>';   // integer
        settype($val, 'string');
        echo gettype($val).'<br>';   // string
        echo '<br>';

        // empty(변수) : 변수의 값이 비어있으면 true
        $var = '';    // 값이 빈 문자
        var_dump(empty($var));    // bool(true)
        $var = array(); // 값이 빈 배열, []도 무관
        var_dump(empty($var));    // bool(true)
        $var = NULL;    // null도 무관
        var_dump(empty($var));    // bool(true)
        $var = 0;
        var_dump(empty($var));    // bool(true)   1이면 false
        $var = '0';
        var_dump(empty($var));    // bool(true)
        $var = false;
        var_dump(empty($var));    // bool(true)
        $var = 'a';
        var_dump(empty($var));    // bool(false)
        $var = true;
        var_dump(empty($var));    // bool(false)
        echo '<br><br>';

        // isset(변수) : 변수의 선언여부
        var_dump(isset($strr));         // bool(false)
        $strr = 'test';
        var_dump(isset($strr));         // bool(true)
        echo isset($strr).'<br><br>';   // 1(true) / 없다면 null(false)


      /*
        # 데이터형의 종류
         - int, integer : 정수
         - double : 소수
         - string : 문자열
         - boolean : 논리값(값: true, false)
         - NULL : 없는값(값: null)
         - array : 배열
      */


      // # gettype(변수) : 데이터형 확인
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
