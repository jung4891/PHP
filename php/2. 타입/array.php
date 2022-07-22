<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

    echo "<h4>< 배열에 값 넣기 ></h4>";
    // PHP에서는 인덱스를 키라고 부르기도 한다.

    // 1) 인덱스(키)로 값 넣기
    $country = array();      // 배열 선언
    $country[0] = 'korea';
    echo $country[0].'<br>'; // korea

    // 2) 문자열로 값 넣기
    $country['name'] = 'koreaa';
    echo $country['name'].'<br>';   // koreaa

    // 3) =>로 값을 추가
    $country = array('name2' => 'korea2', 1 => '테스트1');    // 초기화되면서 값 들어감
    echo $country['name2'].' '.$country['1'].'<br>';         // korea2 테스트1 ('1'이나 1이나 결국 인덱스는 1로 됨)

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
    var_dump($arr);   // 1, 3, 5
    echo '</pre>';


    echo "<h4>< 배열 출력하기 ></h4>";
    $arr = array();
    $arr = ['aa', 'bb', 'cc'];

    // 1) var_dump()  (pre태그와 함께 사용하면 보기 좋게 표시됨)
    echo '<pre>';
    var_dump($arr);  // 자료형까지 함께 출력
    echo '</pre>';
    echo '배열 arr의 값의 수: '.count($arr).'<br>';   // 3
    // print($arr);  // 안됨

    // 2) list()
    // ex) 배열arr의 인덱스 0의 값을 변수 a에 대입
    list($a, $b, $c) = $arr;    // list($a, $b)도 됨
    echo $b;    // bb

    // 3) print_r()   (자료형과 크기는 생략하고 출력됨)
    echo '<pre>';
    print_r($arr);   // Array ( [0] => a [1] => b [2] => c [3] => d [4] => e )
    echo '</pre>';
    echo '<br><hr>';


    echo "<h4>< 배열에 값 추가/삭제 ></h4>";
    $arr = array('a', 'b');

    // 1) array_push(배열, 값) : 값 추가
    array_push($arr, 'c');
    print $arr[2].'<br>';    // c
    $arr[2] = 'd';
    print $arr[2].'<br>';    // d (c가 바뀜)
    $arr[] = 'e';            // 요런식으로도 값을 추가할 수 있다.
    print_r($arr);           // Array ( [0] => a [1] => b [2] => d [3] => e )
    echo '<br><br>============================ array_push( ) <br><br>';

    // 2) unset($arr[i]) : 배열의 인덱스와 값 삭제. 인덱스 값은 유지됨 (한번에 하나의 요소만 삭제가능)
    $arr = ['a', 'b', 'c'];
    unset($arr[1]);
    print_r($arr);          // [0] => a [2] => c
    unset($arr);
    print_r($arr);          // $arr이 아예 사라져서 undefined뜸
    echo '<br>';

    // 3) array_splice(삭제될 배열, 삭제 시작 인덱스, [개수, 추가할 배열] ) : 자동으로 키(인덱스)를 다시 색인화함
    $arr = array('a', 'b', 'c');
    array_splice($arr, 1, 2, array('d', 'e'));  // 1번 인덱스부터 2개 요소 삭제 후 배열 추가됨
    print_r($arr);          // [0] => a [1] => d [2] => e
    echo '<br><br>============================ array_splice( ) <br><br>';

    // 4) array_diff(arr1, arr2...) : arr1에서 뒤에 나오는 배열들의 값들과 다른 값들만 배열에 담아 반환함
    $arr = array('a', 'b', 'c', 'd', 'e');
    $arr1 = ['a', 'b', 'f'];
    $arr = array_diff($arr, $arr1, array('d'), ['e']);
    print_r($arr);    // [2] => c  (역시나 인덱스는 변하지 않음)
    echo '<br>';
    // +
    var_dump(isset($arr['test']));    // false
    echo '<br>';
    $arr['test'] = array();
    var_dump(isset($arr['test']));    // true
    echo gettype($arr['test']);       // array
    echo '<br><br>============================ array_diff( ) <br><br>';

    echo "<h4>< 배열 ↔ 문자열 ></h4>";
    $str = 'jwjung,sylim,hbhwang,kipark,bhkim';

    // explode() : 문자열을 구분자를 기준으로 나눈 값들을 배열로 생성
    $tmpArr = explode(',', $str);
    foreach($tmpArr as $id) {
      echo $id.' ';
    }
    echo '<br>';
    $tmpArr2 = explode(',', $str, 3);   // 파라미터인 limit을 넣어주면 배열의 크기를 제한할 수 있다.
    print_r($tmpArr2);                  // [0] => jwjung, [1] => sylim, [2] => hbhwang,kipark,bhkim
    echo '<br>';
    $tmpArr3 = explode(',', $str, -1);  // 5개가 아닌 4개인 배열생성(제일뒤의 bhkim은 빠짐)
    print_r($tmpArr3);
    print_r(explode('.', 'test'));      // Array ( [0] => test )
    echo '<br>';

    // implode() : 반대로 배열에 구분자를 넣어 문자열 생성
    $arr = array( 'one', 'two', 'three' );
    $impArr = implode( '/', $arr );
    echo $impArr;    // one/two/three
    echo '<br><br><hr>';


    echo "<h4>< 기타 배열관련 함수 ></h4>";
    // max/min(배열 변수) : 배열에서 가장 큰(작은) 수를 반환
    $arr = range(1, 55);
    echo max($arr).'<br>';    // 55
    $arr = [3, 11, 22];
    echo min($arr).'<br>';    // 3
    echo '<br>';

     ?>
  </body>
</html>
