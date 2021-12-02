<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

      // json_encode() : Array 또는 String 따위를 JSON 문자열로 변환하는 함수
      $arr = array('k1'=>'v1', '2'=>2, '3'=>'3');
      echo json_encode($arr).'<br>';   // {"k1":"v1","2":2,"3":"33"}
      $str = json_encode(['a'=>1, 'b'=>2]);   // {"a":1,"b":2}
      echo $str.'<br>';
      echo json_encode(['a','b']).'<br>';   // ["a","b"]
      echo json_encode(true).'<br>';   // "true"    (bool -> string)
      var_dump(json_encode(array("opened" => true)));  // string(15) "{"opened":true}"
      echo '<br>';


      // json_decode() : JSON형식의 문자열을 배열 또는 객체로 변환하는 함수
      // 1) 객체로 변환
      $arr = json_decode($str);
      echo '<pre>';
      print_r($arr);
      echo '</pre>';
      /*
        stdClass Object
        (
            [a] => 1
            [b] => 2
        )
      */

      // 2) 배열로 변환(두번째 인수를 true로)
      $arr = json_decode($str, true);
      echo '<pre>';
      print_r($arr);
      echo '</pre>';
      /*
        Array
        (
            [a] => 1
            [b] => 2
        )
      */

      // 자료형 문자열 -> bool
      echo json_decode("true").'<br>';       // 1
      var_dump(json_decode("true"));  // bool(true)

     ?>
  </body>
</html>
