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
    $mbox = mb_convert_encoding('inbox', 'UTF7-IMAP', 'UTF-8');
    echo $mbox;
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
    echo '<br><br><br>';
     ?>

    <!-- 함수 -->
    <?php

    // htmlspecialchars() : html의 특수 문자들을 그대로 보이게 변환함.
    echo '<h3>htmlspecialchars()</h3>';
    $test = '<p><b>p태그</b></p>';
    echo $test;                   // p태그
    echo htmlspecialchars($test); // "<p><b>p태그</b></p>"
    echo '<br><br><br>';


    // nl2br() : 개행 문자 \n을 <br>태그로 변환해 주어 실제로 페이지 상에서 줄 바꿈이 일어나도록 합니다.
    echo '<h3>nl2br()</h3>';
    $test = "개행문자 \n을 &lt;br태그&gt;로 변환해준다.";
    echo $test.'<br>';                     // 개행문자 을 <br태그>로 변환해준다.
    echo htmlspecialchars($test).'<br>';   // 개행문자 을 &lt;br태그&gt;로 변환해준다.
    echo nl2br($test);                     // 개행문자
    echo '<br><br>';                       // 을 <br태그>로 변환해준다.

    $test = '개행문자 \n을 &lt;br태그&gt;로 변환해준다.';
    echo $test.'<br>';                     // 개행문자 \n을 <br태그>로 변환해준다.
    echo htmlspecialchars($test).'<br>';   // 개행문자 \n을 &lt;br태그&gt;로 변환해준다.
    echo nl2br($test);                     // 개행문자 \n을 <br태그>로 변환해준다.
    echo '<br><br><br>';


    // strpos(전체 문자열, 찾을 문자) : 특정 문자의 인덱스 반환(없으면 false 반환)
    echo '<h3>strpos()</h3>';
    $str = "web developer";
    $findStr = 'e';              // 'develop'은 'd'랑 결과가 같다.
    $pos = strpos($str, $findStr);
    echo '$pos:    '.$pos.'<br>';       // 1  (뒤에 있어도 앞 인덱스 반환)
    $pos = strpos($str, $findStr, 2);   // 2는 offset으로 index 2부터 검색됨
    echo '$pos: '.$pos.'<br>';   // 5
    $pos = strpos($str, $findStr, -6);  // -1이면 제일 뒷 인덱스임('r'). -2이면 'er'에서 검색됨.
    echo '$pos: '.$pos.'<br>';   // 5

    if ($pos == null) {          // 찾는 문자가 없으면 null임
      echo '111 <br>';           // ★ isset($pos)는 근데 참임.
    } else {
      echo '222 <br>';
    }
    var_dump(0 == null);             // bool(true)
    var_dump(0 === null);            // bool(false)
    echo '<br>';

    // substr_count(전체 문자열, 찾을 문자) : 특정 문자가 몇번 나왔는지 반환
    $cnt = substr_count("일이삼일이삼삼", "이");
    echo $cnt.'<br>';   // 2

    echo '<br>';
    // substr(대상 문자열, 자르기 시작위치, 자를 문자열 수(한글은 3개 먹음..))
    $str = "abcde";
    echo $str[1].'<br>';      // b
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
    $str = "가나.다라";
    $cutStr = substr($str, 0, 6);   // 가나 (한글은 3바이트로. 이런식으로 해야 출력됨.)
    echo strpos($str, ".").'<br>';  // 6
    echo $str[6].'<br>';            // .
    echo $cutStr.'<br><br>';

    // str_replace('치환할 문자열', '대체할 문자열', 대상 문자열변수)
    $str = "welcome to korea!";
    $str2 = str_replace('korea', 'china', $str);
    echo $str2.'<br><br>';      // welcome to china!

    echo '<h3>strlen()</h3>';
    // strlen() : 문자열의 글자수
    $str = ' ab cd ';
    echo strlen($str)."<br>";   // 7
    $test = 'a';
    var_dump($test);    // string(1) "a"
    $test = 'ㄱ';
    var_dump($test);    // string(3) "ㄱ"
    $test = '각';
    var_dump($test);    // string(3) "각"
    $test = '?=';
    var_dump($test);    // string(2) "?="
    $test = '=?utf-8?B?WElPUy0yLjAucjI5Mjc2LTIwMTEzMDE2MjMt7J247LKc6rOE7JaR6rOg6rCd7IS87YSwLg==?= =?utf-8?B?VlBO?=';
    var_dump($test[82]);  // string(1) "?"
    echo '<br><br><br>';

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
    echo '<br><br>';

    var_dump('a' == 'a');   // true
    var_dump('a' === 'a');  // true
    var_dump('a' != 'a');   // false
    var_dump('a' !== 'a');  // false
    var_dump('1' == 1);     // true
    var_dump('1' === 1);    // false
    var_dump('1' != 1);     // false
    var_dump('1' !== 1);    // true
     ?>

</body>
</html>
