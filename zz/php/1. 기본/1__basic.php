
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
  echo '<br><br>';

  // print
  print "print도 echo와 사용방법은 같다.";
  print '<br>';
  print 777;
  print '<br><br>';
 ?>


<!-- 연산자(Operator) -->
<?php

  // 삼항연산자
  $grade = 69;
  echo $grade > 70 ? 'Passed' : "Failed";
  $res = $grade < 60 ? '그냥 탈락' : $grade < 65 ? '아쉽게 탈락' : $grade < 70 ? '아주 아쉽게 탈락' : '통과';
  echo '<br>'."결과: $res";
  echo '<br><br>';


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
