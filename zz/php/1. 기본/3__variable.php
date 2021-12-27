<!-- 변수 -->
<?php

  /*
    변수명 규칙 (php는 변수 앞에 반드시 $를 붙인다)
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


  // @ 연결연산자 (echo에만 되는듯. print_r이나 var_dump에선 안먹음)
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
  echo '<br><br>============================ 전역변수 <br><br>';


  // @ 가변변수 : 변수명을 동적으로 변경할 수 있는 변수.
  $a = 'b';
  $$a = 'c';
  $$$a = "\$c입니다.";
  echo $c;
  echo '<br><br>============================ 가변변수 <br><br>';


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
