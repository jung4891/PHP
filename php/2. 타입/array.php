<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

    echo "<br>";
    // # 배열에 값 넣기
    // PHP에서는 인덱스를 키라고 부르기도 한다.

    // 1) 인덱스(키)로 값 넣기
    $country = array();      // 배열 선언
    $country[0] = 'korea';
    echo $country[0].'<br>'; // korea

    // 2) 문자열로 값 넣기
    $country['name'] = 'koreaa';
    echo $country['name'].'<br>';   // koreaa
    // 3) =>로 값을 추가
    $country = array('name2' => 'korea2', 1 => '테스트1');
    echo $country['name2'].' '.$country['1'].'<br>';         // korea2 테스트1

    // 4) 값으로 배열을 선언
    $country['nation'] = array();
    $country['nation'][0] = '서울';
    $country['nation'][1] = '대전';
    echo $country['nation'][0].' '.$country['nation'][1];   // 서울 대전
    echo '<br>';

    // 5) 인덱스를 지정하지 않고 값 입력하기
    $arr = array('a', 'b', 'c');
    echo $arr[2].'<br>';    // c
    $arr2 = [1, 2, 3];  // 요렇게도 가능함
    echo $arr2[2].'<br>';  // 3

    // 6) 특정 범위의 수(알파벳)를 배열로 만들기
    $arr = range(3, 5);
    echo '<pre>';
    var_dump($arr);   // 3, 4, 5가 들어감. range(b, d)면 b, c, d 들어감.
    $arr = range(1, 5, 2);    // 2 간격으로 1부터 5까지 출력
    echo '<pre>';
    var_dump($arr);   // 1, 3, 5
    echo '--------------------------------------------------- 1<br>';


    // # 배열에 값 추가하기
    $arr = array('a', 'b');
    array_push($arr, 'c');
    print $arr[2].'<br>';    // c
    $arr[2] = 'd';
    print $arr[2].'<br>';    // d (c가 바뀜)
    print_r($arr);

    echo '--------------------------------------------------- 2<br>';


    // # 배열 출력하기
    $arr = array();
    $arr = ['aa', 'bb', 'cc'];

    // 1) var_dump()
    // (pre태그와 함꼐 사용하면 보기 좋게 표시됨)
    echo '<pre>';
    var_dump($arr);  // 자료형까지 함께 출력
    echo '</pre>';
    echo '배열 arr의 값의 수: '.count($arr).'<br>';   // 3
    // print($arr);  // 안됨

    // 2) list()
    // ex) 배열arr의 인덱스 0의 값을 변수 a에 대입
    list($a, $b, $c) = $arr;
    echo $b;    // bb

    // 3) print_r()
    echo '<pre>';
    print_r($arr);   // Array ( [0] => a [1] => b [2] => c [3] => d [4] => e )
    echo '</pre>';
    echo '<br>';


    // max/min(배열 변수) : 배열에서 가장 큰(작은) 수를 반환
    $arr = range(1, 55);
    echo max($arr).'<br>';    // 55
    $arr = [3, 11, 22];
    echo min($arr).'<br>';    // 3

    // explode() : 문자열을 구분자를 기준으로 나눈 값들을 배열로 생성
    // 파라미터인 limit을 넣어주면 배열의 크기를 제한할 수 있다.
    $str = 'jwjung,sylim,hbhwang,kipark,bhkim';
    $tmpArr = explode(',', $str);
    foreach($tmpArr as $id) {
      echo $id.' ';
    }
    echo '<br>';
    $tmpArr2 = explode(',', $str, 3);
    print_r($tmpArr2);    //     [0] => jwjung, [1] => sylim, [2] => hbhwang,kipark,bhkim
    echo '<br>';
    $tmpArr3 = explode(',', $str, -1);    // 5개가 아닌 4개인 배열생성(제일뒤의 bhkim은 빠짐)
    print_r($tmpArr3);
    echo '<br>';

    // implode() : 반대로 배열에 구분자를 넣어 문자열 생성
    $jbary = array( 'one', 'two', 'three' );
    $jbstr = implode( '/', $jbary );
    echo $jbstr;    // one/two/three


     ?>
  </body>
</html>
