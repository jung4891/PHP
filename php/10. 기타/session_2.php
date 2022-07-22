<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      // echo "이렇게 하면 세션 안된다구?<br><br>";   // 되는디?
      // 그리고 웹 종료하고 다시 켜도 유지되어 있고 컴터 재부팅후엔 없어져있음
      session_start();
      echo "현재 세션 확인 -> <br>";
      echo "<pre>";
      var_dump($_SESSION);
      echo '</pre>';
      /*
        array(2) {
          ["id"]=>
          string(10) "songDurian"
          ["id2"]=>
          string(11) "songDurian2"
        }
      */

      // 세션 삭제 : unset(세션) -> 배열의 값을 삭제한다.
      // 모든 세션 삭제 : session_unset() -> 세션 배열의 모든 값들을 비움. 세션을 지우는건 아님(잘안씀)
      //                   = $_SESSION = array();
      unset($_SESSION['id']);
      $_SESSION['id3'] = 'songDurian3';
      $_SESSION{'array_test'} = array('key_1'=>'value_1', 'key_2'=>'value_2');
      $_SESSION{'array_test'} = array('key_3'=>'value_3', 'key_4'=>'value_4');
      echo "===================== id session 삭제 및 id3와 array_test 추가<br>";
      echo '<br>';
     ?>
     <a href="/10. 기타/session_3.php">session_3 이동</a>
  </body>
</html>
