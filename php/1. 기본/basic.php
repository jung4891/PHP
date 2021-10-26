
<!-- phpinfo();  PHP 설정 정보들 출력됨 -->


<!--  HTML주석와 PHP 주석  -->
<!--  웹브라우저의 코드보기(f12 > Elements)에서 HTML의 주석은
      사용자가 볼 수 있지만 PHP 주석은 표시되지 않는다. -->


<!-- 문자열 출력하기 -->
<?php
  // echo
  echo "문자열 출력시";   // 명령뒤엔 ;을 꼭 찍어야함\
  echo '<br>';
  echo '작은따옴표도 가능하다';
  echo '<br>';    // HTML의 줄바꿈 태크
  echo 123;       // 숫자만 출력할때는 따옴표를 사용하지 않는다.
  echo '<br>';

  // print
  print "print도 echo와 사용방법은 같다.";
  print '<br>';
  print 777;
  print '<br><br>';
 ?>


<!-- 기본연산자와 대입연산자 -->
<?php
  // 기본연산자
  // 연산 우선순위 : () > *, /, % > +, -
  echo 7+3;   // 10
  echo "<br>";
  echo 7-3;   // 4
  echo "<br>";
  echo 7*3;   // 21
  echo "<br>";
  echo 7/3;   // 2.3333
  echo "<br>";
  print 7%3;  // 1        나머지 연산
  print "<br><br>";

  // 대입연산자
  $num = 1;
  $num += 2;   // $num = $num + 2
  echo $num.'<br>';   // 3
  $num -= 1;
  echo $num.'<br>';   // 2
  $num *= 3;
  echo $num.'<br>';   // 6
  $num /= 2;
  echo $num.'<br>';   // 3
  $num %= 2;
  echo $num.'<br>';   // 1
  $num .= '234';   // $num = $num.'234';
  print $num.'<br><br>';   // 1234

  // 증감연산자
  //  - ++변수 : 현재 값에 1을 더한 후 값을 반환
  //  - 변수++ : 현재 값 반환 후 1을 더함. (--도 동일하게 작동함.)
  $num = 10;
  echo ++$num.'<br>';    // 11
  echo $num++.'<br>';    // 11 (11이 반환된 후 1이 더해짐)
  echo $num.'<br><br>';  // 12

  $num2 = 1;
  $num2++;    // 1
  $num2++;    // 2
  echo $num2.'<br>';    // 3 !!!!!
 ?>


<!-- 상수(constant)-->
<?php

  // @ 상수
  //  - 선언: define(상수이름, 상숫값, 대소문자구분여부(기본값 false는 대소문자 구분함))
  //  - 상수는 변수와 마찬가지로 데이터를 저장할 수 있는 메모리 공간으로
  //    한번 선언되면 스크립트가 실행되는 동안 데이터를 변경하거나 해제(undefined)할 수 없다.
  //  - 관례적으로 상수는 대문자를 사용하고 두단어 이상은 _를 사용한다.

  // 변하지 않는 상수
  define("MY_HOME", "제천");
  define("MY_HOME", "서울");
  echo "내 고향은 ".MY_HOME."입니다.<br><br>";   // 출력값 : 내 고향은 제천입니다.

  // 대소문자를 구분할 수도 있고
  define("MY_HOME2", "구암동");
  echo MY_HOME2.'<br>';   // 구암동
  echo my_HOME2.'<br>';   // my_HOME2
  define("MY_HOME3", "월계동", true);    // 대소문자 구분하지 않음
  echo my_HOME3.'<br>';   // 월계동

  // 함수내부에서 선언되어도 바깥에서 사용할 수 있다.
  function const_func() {
    define("AA", "AA테스트");
  }
  const_func();
  echo AA.'<br><br>';   // AA테스트


  // @ 마법 상수 (magic constants)
  // 어떤 스크립트에서도 사용할 수 있는 미리 정의된 상수로 대소문자 구분을 하지 않음

  // 미리 정의된 모든 상수 출력
  // echo '<pre>';
  // print_r(get_defined_constants(true));
  // echo '</pre>';

  // 미리 정의된 상수 이외에 어디에 사용하느냐에 따라 용도가 변경되는 마법상
  echo __LINE__.'<br>';  // 111, 현재 줄변호 반환
  echo __FILE__.'<br>';  // C:\xampp\htdocs\php\1. 기본\basic.php, 파일의 전체 경로와 이름을 반환
  echo __DIR__.'<br>';   // C:\xampp\htdocs\php\1. 기본, 파일의 디렉터리 반환(= dirname(__FILE__))
  function test(){
    echo __FUNCTION__.'<br>';   // test, 함수의 이름을 반환함.
    echo __METHOD__.'<br>';   // 클래스의 메소드 이름을 반환함.
  } test();
  echo __CLASS__.'<br>';   // 클래스의 이름을 반환함. 클래스 이름은 대소문자를 구분함.
  echo __TRAIT__.'<br>';   // 트레이트?(trait)의 이름을 반환함.(트레이트를 선언한 네임스페이스를 포함)
  echo __NAMESPACE__.'<br>';   // 현재 네임스페이스의 이름을 반환함.


 ?>
