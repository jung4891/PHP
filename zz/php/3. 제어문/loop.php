<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

    /*
      # foreach문
      foreach(배열 변수 as 배열의 값을 대입할 변수) {
        실행코드;
    }
    */

    // foreach문 기본
    $arr = ['a', 'b', 'c'];
    foreach($arr as $i => $z) {
      echo $i.' '.$z.'<br>';
    }
    // ->
    // 0 a
    // 1 b
    // 2 c

    // 이미 있는 배열에 이렇게 해서 배열을 넣을 수도 있군.
    // $arr[0] = ['name'=>'하나', 'id'=>'one'];
    // echo '<pre>';
    // print_r($arr);
    // echo '</pre>';
    // ->
    // Array
    // (
    //     [0] => Array
    //         (
    //             [name] => 하나
    //             [id] => one
    //         )
    //
    //     [1] => b
    //     [2] => c
    // )
    echo '<br>';

    // foreach에서 요소들의 키만 출력하기
    $array = array("key1"=>"val1", "key2"=>"val2");
    foreach($array as $key => $value) {
      echo $key.' ';    // key1 key2
    }
    echo '<br><br>';

    // 배열의 요소가 인덱스(key)가 문자인 배열일 경우 특정 key의 value만 출력하기
    $arr2[0] = ['kor'=>'하나', 'eng'=>'one'];
    $arr2[1] = ['kor'=>'둘', 'eng'=>'two', 'chn'=>'er']; // chn은 아래에서 불러오지 않아도 선언은 가능.
    // $arr2[2] = ['kor2'=>'둘', 'eng2'=>'two'];         // 다만 이처럼 가져올 키가 없으면 아래 loop에서 애러남.
    foreach($arr2 as $element) {
      echo "한글: ".$element['kor'].'<br>';
      echo "영어: ".$element['eng'].'<br>';
    }
    // ->
    // 한글: 하나
    // 영어: one
    // 한글: 둘
    // 영어: two
    echo "<br>";

    // foreach 이중으로 사용하여 해당 key와 value 모두 가져오기
    foreach($arr2 as $key1 => $val1) {
      echo "외부인덱스: $key1 / 값: ";
      print_r($val1);
      echo '<br>';
      foreach($val1 as $key2 => $val2) {
        echo "내부인덱스: $key2 / 값: $val2 <br>";
      }
      if($key1 !== array_key_last($arr2)) echo '----<br>';
    }
    echo '<br>';
    // ->
    // kor: 하나
    // eng: one
    // kor: 둘
    // eng: two
    // chn: er

    // foreach에서 카운터 사용하여 처음과 끝 항목 얻기
    $array = array("cat", "rabbit", "horse", "dog");
    $x = 1;
    $length = count($array);
    foreach($array as $animal) {
      if($x === 1) {
        echo '처음: '.$animal.'<br>';
      }else if($x === $length) {
        echo '마지막: '.$animal.'<br>';
      }else {
        echo '중간: '.$animal.'<br>';
      }
      $x++;
    }
    echo '<br>';

    // 내장함수 사용하여 처음과 끝 항목 얻기 (PHP Version 7.3 이상)
    echo PHP_VERSION.'<br>';  // 7.4.23
    foreach($array as $index => $animal) {
      if($index === array_key_first($array)) {
        echo '처음: '.$animal.'<br>';
      }else if($index === array_key_last($array)) {
        echo '마지막: '.$animal.'<br>';
      }else {
        echo '중간: '.$animal.'<br>';
      }
      $x++;
    }
    echo '<br>';


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
