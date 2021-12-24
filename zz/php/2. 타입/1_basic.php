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
       - resource : 리소스 (PHP 외부에 존재하는 외부 자원을 의미)
       - NULL : 없는값(값: null)
    */


    // # empty() : 변수가 선언되지 않았거나 선언된 변수가 비어있으면 true
    // # isset() : 변수가 메모리에 할당되어 있다면(선언되었다면) true
    $var = '1';
    var_dump(empty($var));    // bool(false) ★
    var_dump(isset($var));    // bool(true)
    echo '<br>';
    $var = '';                // 값이 빈 문자
    var_dump(empty($var));    // bool(true)
    var_dump(isset($var));    // bool(true)
    echo '<br>';
    var_dump(empty($varr));   // bool(true)  ☆
    var_dump(isset($varr));   // bool(false) ★
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
    echo '<br><br>============================ empty( ), isset( ) <br><br>';



    // # unset() : 인수로 전달받은 변수를 메모리에서 삭제함.
    var_dump(isset($strr));       // bool(false)
    $strr = 'test';
    var_dump(isset($strr));       // bool(true)
    echo isset($strr).'<br>';     // 1 / 없다면 null
    unset($strr);
    var_dump(isset($strr));       // bool(false)
    $arr = array('1' => 'a', '2' => 'b');
    var_dump($arr);
    echo '<br>';
    unset($arr);
    var_dump($arr);     // undefined.
    echo '<br><br>============================ unset( ) <br><br>';



    // # gettype(변수) : 데이터형 확인
    // (PHP는 JAVA와 다르게 값을 확인한 후 데이터형을 자동으로 지정해준다.)
    $num = 7;
    echo "\$num 데이터형: ".gettype($num)." (값: $num) <br>";        // integer (값: 7)
    var_dump(gettype($num));    // string(7) "integer"
    echo '<br>';
    $num2 = 7.7;
    echo "\$num2 데이터형: ".gettype($num2)." (값: {$num2}) <br>";   // double (값: 7.7)
    $str = "문자열";
    echo "\$str 데이터형: ".gettype($str)." (값: {$str}) <br>";      // string (값: 문자열)
    $arr = array();
    echo "\$arr의 데이터형: ".gettype($arr)."<br>";                  // array
    $nothing = null;
    echo "\$nothing의 데이터형: ".gettype($nothing)." (값: {$nothing}) <br>";   // NULL (값: )
    $bool = true;   // false면 위 null처럼 echo시 값이 아무것도 안뜸.
    echo "\$bool의 데이터형: ".gettype($bool)." (값: {$bool})";       // boolean (값: 1)
    echo '<br><br>============================ gettype( ) <br><br>';



    // # settype(): 변수에 데이터형 지정
    $val = "true";
    settype($val, 'bool');       // boolean도 무관
    echo gettype($val).'<br>';   // boolean
    $val = 10;
    settype($val, 'string');
    echo gettype($val).'<br>';   // string
    settype($val, 'float');
    echo gettype($val).'<br>';   // double
    settype($val, 'int');
    echo gettype($val).'<br>';   // integer
    settype($val, 'array');
    echo gettype($val).'<br>';   // array
    var_dump($val);              // array(1) { [0]=> int(10) }
    settype($val, 'bool');
    echo gettype($val).'<br>';   // boolean
    echo '<br><br>============================ settype( ) <br><br>';



    // 데이터형 변환
    // 1) 숫자로된 string -> int
    $str = "123";
    $num = (int) $str;
    echo gettype($num)." (값: {$num}) <br>";   // integer (값: 123)
    // 2) string -> int
    $str = "테스트";
    $num = (int) $str;
    echo gettype($num)." (값: {$num}) <br>";   // integer (값: 0)
    $str = "2테1스1트2";
    $num = (int) $str;
    echo gettype($num)." (값: {$num}) <br>";   // integer (값: 2)
    // 3) double -> int
    $num = 3.8;
    $num2 = (int) $num;
    echo gettype($num2)." (값: {$num2}) ";     // integer (값: 3)
    $num2 = (double) $num2;
    echo gettype($num2)." (값: {$num2})";      // double (값: 3)
    echo '<br><br>============================ type casting <br><br>';



    // @ boolean
    // false, "", 0, "0", 0.0, 빈배열, NULL : 불리언 타입으로 변환시 false로 인식하는 것들
    // 이외 모든값은 true로 인식됨

    // 죄다 false
    var_dump(false);
    var_dump('');         // string(0) ""
    var_dump((bool)'');
    if('')  echo 'a'; else echo 'b';    // b
    var_dump(0);          // int(0)
    var_dump((bool)0);
    var_dump('0');        // string(1) "0"
    var_dump((bool)'0');
    var_dump(0.0);        // float(0)
    var_dump((bool)0.0);
    var_dump('0.0');      // string(3) "0.0"
    var_dump((bool)array());
    var_dump((bool)null);
    echo '<br>';
    // 이 아랜 true
    var_dump((bool)'0.0');
    var_dump((bool)-1);
    var_dump((bool)'false');
    echo '<br><br>============================ boolean <br><br>';



    // @ NULL
    // NULL 타입의 변수란 아직 어떠한 값도 대입되지 않은 변수를 의미
    // NULL은 오직 한 가지 값(NULL 상수)만을 가질 수 있는 특별한 타입
    $var_01;
	  var_dump($var_01);	          // NULL (초기화되지 않은 변수를 참조)
    var_dump($var_01 === null);   // true
    echo "<br>";
    $var_01 = 100;
    var_dump($var_01);             // int(100) ($var_01 변수를 초기화함)
    var_dump($var_01 === null);    // false
    echo "<br>";
    $var_01 = 0;
    var_dump($var_01 == null);     // true
    echo "<br>";
    unset($var_01);		             // $var_01 변수를 삭제함.
    var_dump($var_01);	           // NULL (삭제된 변수를 참조)
    echo '<br><br>============================ NULL <br><br>';



    // @ string
    // PHP에서 문자열 리터럴은 큰따옴표("")나 작은따옴표('')로 감싸서 표현합니다.
    // 오랫동안 사용되어 온 아스키(ASCII) 인코딩 환경에서 영문자는 한 글자당 1바이트, 한글은 2바이트로 표현됩니다.
    // 하지만 UTF-8 인코딩 환경에서는 영문자는 한 글자당 1바이트, 한글은 한 문자당 3바이트로 표현됩니다.
    $str_01 = "PHP";
  	$str_02 = "호호호";
  	echo strlen($str_01)."<br>";	// 3
  	echo strlen($str_02);		     	// 9
    echo '<br><br>============================ string <br><br>';



    // @ int
    // PHP에서는 부호가 없는 정수(unsigned integer)는 지원하지 않습니다.
    // 또한, 정수는 10진수, 8진수(0으로 시작), 16진수(0x로 시작)로도 표현할 수 있습니다.
    echo 'integer 타입의 크기: '.PHP_INT_SIZE.'byte <br>';    // 8byte
    $int_02 = PHP_INT_MAX;		// integer가 표현할 수 있는 최대값
    var_dump($int_02);        // int(9223372036854775807)
    echo "<br>";
    $int_03 = PHP_INT_MAX + 1;	// integer가 표현할 수 있는 범위를 넘는 값을 대입하면 자동으로 실수형으로 인식됨
    var_dump($int_03);          // float(9.2233720368548E+18)
    echo gettype($int_03);      // double    (즉, php에선 float, double은 차이가 없다.)
    echo '<br><br>============================ int <br><br>';



    // @ float, double
    // PHP에서 실수의 표현 범위는 운영체제에 따라 달라지지만 대략 ~1.8e307까지 표현할 수 있습니다.
    // 하지만 컴퓨터에서 실수를 표현하는 방식은 반드시 오차가 존재하는 한계를 지니므로,
    // 실수형끼리 직접 값을 비교하는 것은 피하는 것이 좋습니다.
    $float_01 = 3.14;
    var_dump($float_01);  // float(3.14)
    echo "<br>";
  	$float_03 = 1.8E307;	// float이 표현할 수 있는 범위를 넘지 않는 값을 대입함.
  	var_dump($float_03);  // float(1.8E+307)
    echo "<br>";
  	$float_04 = 1.8e308;	// float이 표현할 수 있는 범위를 넘는 값을 대입함.
  	var_dump($float_04);  // float(INF)    미리 정의된 상수인 INF는 무한(infinite)이라는 값을 의미합니다.
    echo '<br><br>============================ float <br><br>';



    // @ array
    // PHP에서 배열(array)은 한 쌍의 키(key)와 값(value)으로 이루어진 맵(map)으로 구성되는 순서가 있는 집합을 의미
    // 맵의 키로는 정수와 문자열만이 가능함 (키 1과 "1"은 같은 것으로 인식됨!)
    // 만약 정수와 문자열 이외에 다른 타입의 값을 키로 사용하면, 내부적으로 다음과 같이 타입 변환이 됨
    /*
      - 불리언은 true는 1로, false는 0으로 자동 타입 변환됩니다.
      - 유효한 숫자로만 이루어진 문자열은 정수나 실수(-> floor되서 정수됨)로 자동 타입 변환됩니다.
      - 실수는 소수 부분이 제거되고, 정수로 자동 타입 변환됩니다.
      - 배열과 객체는 배열의 키값으로 사용할 수 없습니다.
    */
    $arr = array(1 => "a", '1' => "b");
    var_dump($arr);   // array(1) { [1]=> string(1) "b" }
    echo "<br>";
    $arr = array(2 => "2", 3 => 3);
    var_dump($arr);   // array(2) { [2]=> string(1) "2" [3]=> int(3) }
    echo "<br>";
    $arr = array(true => 'a', 'a' => true);
    var_dump($arr);   // array(2) { [1]=> string(1) "a" ["a"]=> bool(true) }
    echo "<br>";
    $arr = array(1.1 => 'a', 2.9 => 2.9);
    var_dump($arr);   // array(2) { [1]=> string(1) "a" [2]=> float(2.9) }
    echo "<br>";
    echo '<br><br>============================ array <br><br>';



    // @ 객체 (object)
    // 객체는 클래스의 인스턴스를 저장하기 위한 타입
    // 이러한 객체는 properties와 methods를 포함할 수 있다.
    class Lecture
    {
      public $lec_02 = "MySQL";

      function Lecture()
      {
          $this->lec_01 = "PHP";
      }
    }
    $lec = new Lecture;       // 객체 생성
    echo $lec->lec_01.' ';    // PHP (객체의 속성 접근)
    echo $lec->lec_02;        // MySQL (속성에 접근할 때는 $를 안붙이는군)
    echo '<br><br>============================ object <br><br>';



     ?>
  </body>
</html>
