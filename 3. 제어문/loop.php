<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    /*
      # for문
      for(초기값; 조건식; 증감식){
        실행 코드
        break는 바로 종료
        continue는 스킵
      }
    */

    // 짝수 구구단 출력
    // for ($i = 1; $i <= 9; $i++) {
    //   if($i % 2 == 0) {
    //     echo "{$i}단<br>";
    //     for ($j = 1; $j <= 9; $j++) {
    //       $mul = $i * $j;
    //       echo "{$i} x {$j} = {$mul} <br>";
    //     }
    //     echo "<br>";
    //   }
    // }
    // echo '<br><br>';

    /*
      # foreach문
      foreach(배열 변수 as 배열의 값을 대입할 변수) {
        실행코드;
    }
    */

    // foreach문 기본
    $arr = ['a', 'b', 'c'];
    foreach($arr as $z) {
      echo $z.'.';        // a.b.c.
    }
    echo '<br><br>';

    // 배열의 요소가 인덱스가 문자인 배열일 경우 값 출력하기
    $memberList2[0] = ['name'=>'하나', 'id'=>'one'];
    $memberList2[1] = ['name'=>'둘', 'id'=>'two'];

    foreach($memberList2 as $ml) {
      echo "이름: ".$ml['name'].'<br>';
      echo "아이디: ".$ml['id'].'<br>';
    }
    echo '<br>';

    // 인덱스가 문자인 배열의 인덱스와 값 출력하기
    $memberList = ['name'=>'하나', 'id'=>'one'];
    foreach($memberList as $idx => $val) {
      echo "인덱스: {$idx} / 값: {$val} <br>";
    }
    echo '<br>';

    // 배열의 요소가 인덱스가 문자인 배열일 경우 인덱스와 값 출력하기
    $memberList3[0] = ['name'=>'하나', 'id'=>'one'];
    $memberList3[1] = ['name'=>'둘', 'id'=>'two'];

    foreach($memberList3 as $index => $value) {
      // $index : 0, $value : ['name'=>'하나', 'id'=>'one']
      echo "외부인덱스: {$index} / 값: ";
      echo print_r($value).'<br>';
      foreach($value as $index2 => $value2) {
        // $index2 : 'name', $value2 : '하나'
        // $index2 : 'id', $value2 : 'one'
        echo "내부인덱스: {$index2} / 값: {$value2} <br>";
      }
      echo '<br>';
    }


    /*
      # while문

      초기식;
      while(조건식) {
        실행문;
        증감식;
      }
    */

    // 1부터 10까지의 누적합 구하기
    $sum = 0;
    $i = 1;
    while($i < 11) {
      $sum += $i;
      $i++;
    }
    echo $sum.'<br>';   // 55

    /*
      # do-while문 (조건식이 거짓이더라도 일단 최초1회는 실행할때)

      do {
        명령문;
      }
      while(조건식);
    */

    // do-while 실험
    do {
      echo "do-while 테스트";    // 그대로 출력됨
    }
    while(false);
     ?>

  </body>
</html>

<!--

while(expr) {
  statement
}

프로그래밍의 양대축.
- expr -> 값 또는 최종적으로 값이 되는 것.
          while(expr)에서 expr은 boolean값이 들어옴.
- statement -> while문 if문 처럼 값이 되는게 아닌것.
 -->
