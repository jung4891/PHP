<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

    // 배열에 값 넣기
    // PHP에서는 인덱스를 키라고 부르기도 한다.
    $country = array();      // 배열 선언
    $country[0] = 'korea';   // 1) 인덱스(키)로 값 넣기
    echo $country[0].'<br>'; // korea
    $country['name'] = 'koreaa';    // 2) 문자열로 값 넣기
    echo $country['name'].'<br>';   // koreaa
    $country = array('name2' => 'korea2', 1 => '테스트1');   // 3) =>로 값을 추가
    echo $country['name2'].' '.$country['1'].'<br>';         // korea2 테스트1
    $country['nation'] = array();   // 4) 값으로 배열을 선언
    $country['nation'][0] = '서울';
    $country['nation'][1] = '대전';
    echo $country['nation'][0].' '.$country['nation'][1];   // 서울 대전
    echo '<br><br>';

    // 배열에 값 추가하기
    $arr = array('a', 'b', 'c');
    array_push($arr, 'd', 'e');

    var_dump(count($arr));    // int(3)
    // print($arr);           // 안됨
    array_push($arr, 'd', 'e');
    print('<br>');
    print_r($arr);   // Array ( [0] => a [1] => b [2] => c [3] => d [4] => e )
    echo '<br>';
    var_dump($arr);
    // array(5) { [0]=> string(1) "a" [1]=> string(1) "b" [2]=> string(1) "c
    //            [3]=> string(1) "d" [4]=> string(1) "e" }

    // 페이지 소스보기에서 더 깔끔하게 볼 수 있다.

     ?>
  </body>
</html>
