<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

    // 배열 기초
    $country = array();   // 배열 선언
    $country[0] = 'korea';
    echo $country[0];

    echo '<br><br>';
    $arr = array('a', 'b', 'c');
    echo $arr[1].'<br>';
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
