<!-- 변수 -->
<?php

  /*
    변수명 규칙
    1. 변수명 앞에 숫자 x ($7num)
    2. _외에 특수문자 사용 안됨 ($num#)
    3. 변수명은 대소문자 구별!! ($num과 $Num은 다르다.)

    + 한자나 한글은 인코딩 호환이 안될 수 있으므로 주로 알파벳 사용
    + 두개의 단어를 붙여 사용할때는 카멜표기법(myHome) 주로 사용.
    + 문자열 내부에 따옴표 사용시 \사용. ($str = "문자열에 \"따옴표\"사용하기")
  */

  // @ 초기화되지 않은 변수의 타입별 기본값 (Notice 경고메시지 뜨긴함)
  // 변수 선언시 가능하면 초기화를 하면 좋다. 하지만 필수는 아니다.
  echo gettype($varr);        // NULL
  echo (int)$varr;            // 0
  echo (float)$varr;          // 0
  echo (string)$varr;         // ''
  var_dump((boolean)$varr);   // bool(false)
  echo $varr? "true":"false"; // false
  echo '<br>';
  $varr[1] = "index1";
  var_dump($varr);            // array(1) { [1]=> string(6) "index1" }
  echo $varr[0];              // Undefined offset: 0 in ~~
  echo '<br><br>';


  // @ 문자열 내에서 변수 사용시 {} 사용 (★ 쌍따옴표만 됨!! 홑따옴표 안됨!!)
  // 근데 {}없어도 사용은 되나 안쓰면 아래에선 ''$num입니다''로 변수인식되니 꼭 쓰도록.
  // ''내부에서 변수사용은 .으로 연결
  $num = 11;
  $num = 111;
  echo "변수 num의 값은 {$num}입니다.<br>";   // 출력값: 111


  // @ 변수 선언시 타입은 따로 명시하지 않는다.
  // 타입은 변수에 대입하는 값에 따라 자동으로 결정되고 타입변환도 일어난다.
  $var = 10;
  $var = 1.0;
  $var = "PHP";
  echo $var.'<br>';   // PHP


  // @ 연결연산자
  // 데이터를 서로 연결할 때 사용하며 기호는 .이다
  // 변수-변수, 변수-문자열, 문자열-문자열간 연결이 가능하다.
  $str = "굿";
  $str2 = "모닝";
  echo $str.$str2.'~!'.'<br><br>';    // 출력값 : 굿모닝~!
 ?>


 <!-- 변수의 종류 -->
 <?php

  // @ 지역변수 (local variable)
  // 함수 내부에 선언된 변수로 오직 함수 내부에서만 접근 가능
  // 함수 호출이 종료되면 메모리에서 제거됨
  function varFunc() {
    $a = 10;
    echo "지역변수 a 값: {$a} <br><br>";   // 지역변수 a 값: 10
  }
  varFunc();

  // @ 전역변수 (global variable)
  // 함수 밖에서 선언된 함수로 함수 밖에서만 접근할 수 있다.
  // 함수 내에서 접근할때는 global키워드를 사용해야함.
  $b = 20;
  function varFunc2() {
    global $b;    // 함수 내에서 사용할 전역 변수를 명시함
    echo "전역변수 b: {$b} <br>";
  }
  varFunc2();     // 전역변수 b: 20
  echo "전역변수 b: {$b} <br><br>";

  // @ $GLOBALS 배열을 활용한 전역변수로의 접근
  // PHP는 모든 전역변수를 $GLOBALS배열에 저장함
  // 이 배열에 인덱스로 변수의 이름을 사용하면 함수내부에서 전역변수의 값에 접근 및 변경 가능
  $c = 300;
  function varFunc3() {
    echo "전역변수 c: {$GLOBALS['c']} <br>";
    $GLOBALS['c'] = 30;
  }
  varFunc3();                    // 전역변수 c: 300
  echo "전역변수 c: {$c} <br>";  // 전역변수 c: 30

  // @ 슈퍼 글로벌 변수 (superglobal)
  // 미리 정의된 전역변수로 특별한 선언 없이 스크립트 내의 어디에도 바로 사용가능.
  // 1번 제외한 나머지는 Form과 쿠기 및 세션수업에서 확인
  // 1. $GLOBALS
  // 2. $_SERVER
  // 3. $_GET
  // 4. $_POST
  // 5. $_FILES
  // 6. $_COOKIE
  // 7. $_SESSION
  // 8. $_REQUEST
  // 9. $_ENV

  // @ 정적 변수 (static variable)
  // 함수 내부에서 static 키워드로 선언한 함수.
  // 함수 호출이 종료되더라도 메모리상에서 사라지진 않지만 함수내부에서만 접근가능
  function counter() {
    static $cnt = 0;
    echo "cnt: {$cnt} <br>";
    $cnt++;
  }
  counter();    // cnt: 0
  counter();    // cnt: 1
  counter();    // cnt: 2

  ?>
