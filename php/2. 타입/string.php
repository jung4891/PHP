<!doctype html>
<html>
<head>
  <style media="screen">
    body{
      background-color: black;
      color: white;
    }
  </style>
</head>
<body>

   <?php
    // echo 'Hello World';
    // echo "Hello World'2'";
    // echo 'Hello World"3"';
    // echo 'Hello World\'3\'';
    // echo "Hello World\"2\"";
    // echo "Hello"." World <br>";    // +는 안된다.
     ?>

    <!-- Null과 '' -->
    <?php
    $s = '';
    var_dump($s);          // string(0) ""
    var_dump(isset($s));   // true
    var_dump($s == '');    // true
    var_dump($s === '');   // true
    var_dump($s == null);  // true
    var_dump($s === null); // false
    echo '<br>';

    $n = null;
    var_dump($n);           // NULL
    var_dump(isset($n));    // false
    var_dump($n == '');     // true
    var_dump($n === '');    // true
    var_dump($n == null);   // true
    var_dump($n === null);  // true
    echo '<br>';
     ?>

    <!-- 함수 -->
    <?php

    // strpos(전체 문자열, 찾을 문자) : 특정 문자의 인덱스 반환
    $str = "web developer";
    $findStr = 'e';              // 'develop'은 'd'랑 결과가 같다.
    $pos = strpos($str, $findStr);
    echo '$pos: '.$pos.'<br>';   // 1  (뒤에 있어도 앞 인덱스 반환)
    $pos = strpos($str, $findStr, 2);   // 2는 2번째 e를 찾음
    echo '$pos: '.$pos.'<br>';   // 5
    if ($pos == null) {          // 찾는 문자가 없으면 null임
      echo '111 <br>';           // ★ isset($pos)는 근데 참임.
    } else {
      echo '222';
    }


    echo '<br>';
    // substr(대상 문자열, 자르기 시작위치, 자를 문자열 수)
    $str = "abcde";
    $cutStr = substr($str, 2);
    echo $cutStr.'<br>';      // cde (인덱스2부터 쫙 출력)
    $cutStr = substr($str, 2, 2);
    echo $cutStr.'<br>';      // cd
    $cutStr = substr($str, -2);
    echo $cutStr.'<br>';      // de (인덱스-2부터 쫙 출력)
    $cutStr = substr($str, -3, 2);    // 제일 뒤가 -1
    echo $cutStr.'<br><br>';  // cd
    $cutStr = substr($str, 1, -1);    // 제일 뒤가 -1
    echo $cutStr.'<br><br>';  // bcd (인덱스1부터 인덱스-1 앞까지. 중간부분 출력시)

    // str_replace('치환할 문자열', '대체할 문자열', 대상 문자열변수)
    $str = "welcome to korea!";
    $str2 = str_replace('korea', 'china', $str);
    echo $str2.'<br><br>';      // welcome to china!

    // strlen() : 문자열의 글자수
    $str = ' ab cd ';
    echo strlen($str)."<br>";   // 7
    echo '<br>';

    // strtoupper(), strtolower()
    $str = "test";
    echo strtoupper($str).'<br>';   // TEST
    $str = "TEST";
    echo strtolower($str).'<br>';   // test
    echo '<br>';

    // ucfirst() : 첫글자만 대문자로 (only 첫글자가 영문일 경우)
    $str = "test test";
    echo ucfirst($str).'<br>';      // Test test
    // ucwords() : 문자열에 있는 영단어의 첫 글자를 대문자로
    echo ucwords($str).'<br><br>';  // Test Test

    // trim()
    $str = " 공백 테스트 ";
    echo '|'.trim($str).'| <br>';   // |공백 테스트|
    echo '|'.ltrim($str).'| <br>';  // |공백 테스트 |
    echo '|'.rtrim($str).'| <br>';  // | 공백 테스트|
    echo '<br>';

     // nl2br() : new line에 br태그 삽입함.
     $str = 'aaa
     bbb';
     echo $str."<br>";   // 줄개행 안됨
     $str = 'ccc ddd';
     echo nl2br($str)    // 줄개행 됨 (페이지소스보면 ccc뒤에 <br /> 생성됨)
     ?>

    <!-- 기타 -->
    <br>
    <?php
    echo "aaa<br>bbb";    // 브라우저는 개행되고 소스코드보기에선 <br>로 보임
    echo '5'+'5';         // 10임
     ?>

</body>
</html>
