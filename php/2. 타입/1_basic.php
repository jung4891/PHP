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
       - double : 소수  (float은??)
       - string : 문자열
       - boolean : 논리값(값: true, false)
       - array : 배열
       - object : 객체
       - resource : 리소스
       - NULL : 없는값(값: null)
    */

    // @ boolean
    // false, 0, 0.0, "", "0", 빈배열, NULL : 불리언 타입으로 변환시 false로 인식하는 것들
    // 이외 모든값은 true로 인식됨

    // 죄다 false
    var_dump(false);
    var_dump((bool)0);
    var_dump((bool)0.0);
    var_dump((bool)'');
    var_dump((bool)'0');
    var_dump((bool)array());
    var_dump((bool)null);

    echo '<br>';
    var_dump((bool)-1);   // true
    var_dump((bool)'false');   // true
    echo "<br>------------------- 0 <br><br>";


    // @ int
    // PHP에서는 부호가 없는 정수(unsigned integer)는 지원하지 않습니다.
    // 또한, 정수는 10진수, 8진수(0으로 시작), 16진수(0x로 시작)로도 표현할 수 있습니다.
    echo 'integer 타입의 크기: '.PHP_INT_SIZE.'byte. <br>';    // 8byte
    $int_02 = PHP_INT_MAX;		// integer가 표현할 수 있는 최대값
    var_dump($int_02);        // int(9223372036854775807)
    echo "<br>";
    $int_03 = PHP_INT_MAX + 1;	// integer가 표현할 수 있는 범위를 넘는 값을 대입하면 자동으로 실수형으로 인식됨
    var_dump($int_03);          // float(9.2233720368548E+18)
    echo gettype($int_03);      // double    (즉, php에선 float, double은 차이가 없다.)
    echo "<br>------------------- 0.1 <br><br>";

    // @ float, double




    // gettype(변수) : 데이터형 확인
    // (PHP는 JAVA와 다르게 값을 확인한 후 데이터형을 자동으로 지정해준다.)
    $num = 7;
    echo "\$num 데이터형: ".gettype($num)." (값: {$num}) <br>";
    $num2 = 7.7;
    echo "\$num2 데이터형: ".gettype($num2)." (값: {$num2}) <br>";   // double (값: 7.7)
    $str = "문자열";
    echo "\$str 데이터형: ".gettype($str)." (값: {$str}) <br>";
    $arr = array();
    echo "\$arr의 데이터형: ".gettype($arr)."<br>";
    $nothing = null;
    echo "\$nothing의 데이터형: ".gettype($nothing)." (값: {$nothing}) <br>";
    $bool = true;   // false면 위 null처럼 값이 아무것도 안뜸.
    echo "\$bool의 데이터형: ".gettype($bool)." (값: {$bool}) <br>";
    echo "------------------- 1 <br><br>";

    // settype(): 변수에 데이터형 지정
    $val = "true";
    settype($val, 'bool');       // boolean도 무관
    echo gettype($val).'<br>';   // boolean
    $val = 10;
    settype($val, 'string');
    echo gettype($val).'<br>';   // string
    echo "------------------- 2 <br><br>";

    // empty() : 변수의 값이 비어있으면 true (☆ 초기회되지 않았어도 true다.)
    // isset() : 변수가 메모리에 할당되어 있다면 true
    $var = '';                // 값이 빈 문자
    var_dump(empty($var));    // bool(true)
    var_dump(isset($var));    // bool(true)
    echo '<br>';
    var_dump(empty($varr));   // bool(true)  ☆
    var_dump(isset($varr));   // bool(false)
    echo '<br>';
    $var = array();           // 값이 빈 배열, []도 무관
    var_dump(empty($var));    // bool(true)
    $var = NULL;              // null도 무관
    var_dump(empty($var));    // bool(true)
    $var = 0;
    var_dump(empty($var));    // bool(true) ☆  (1이면 false)
    $var = '0';
    var_dump(empty($var));    // bool(true) ☆
    $var = false;
    var_dump(empty($var));    // bool(true)
    $var = 'a';
    var_dump(empty($var));    // bool(false)
    $var = true;
    var_dump(empty($var));    // bool(false)
    echo "<br>------------------- 3 <br><br>";

    // unset : 변수내부 값 비워줌, 배열 역시 배워줌. 그냥 다 비워줌
    var_dump(isset($strr));       // bool(false)
    $strr = 'test';
    var_dump(isset($strr));       // bool(true)
    echo isset($strr).'<br>';     // 1(true) / 없다면 null(false)
    unset($strr);
    var_dump(isset($strr));       // bool(false)
    $arr = array('1' => 'a', '2' => 'b');
    var_dump($arr);
    echo '<br>';
    unset($arr);
    var_dump($arr);     // undefined.
    echo "------------------- 4 <br><br>";

    // ~~>


    // 데이터형 변환

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
