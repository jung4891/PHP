<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      session_start();
      echo "현재 세션 확인 -> <br>";
      echo "<pre>";
      var_dump($_SESSION);  // 생성된 세션 확인
      echo '</pre>';
      /*
        array(2) {
          ["id2"]=>
          string(11) "songDurian2"
          ["id3"]=>
          string(11) "songDurian3"
        }
      */

      // 세션의 완전한 소멸 : session_destroy() -> 세션의 값 뿐만아니라 세션 파일들까지 지워버림
      // 세션은 대부분 시간이 지나면 자동으로 소멸한다. 하지만 여러이유로 찌꺼기처럼 남아있는 세션들 또한 많이 존재함
      // 그런 세션들을 지울때 해당 함수를 사용한다.
      // 로그아웃 처리를 하거나 임시적으로 세션을 사용할 때에는 대부분 개별적으로 unset()을 활용한다.
      $_SESSION['id4'] = 'songDurian4';
      session_destroy();
      echo "===================== id4 생성후 session_destroy(); <br>";
     ?>
     <a href="/10. 기타/session_4.php">session_4 이동</a>
  </body>
</html>
