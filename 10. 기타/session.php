<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

      // 세션
      //  - 쿠키와 비슷하나 정보를 사용자 컴퓨터가 아닌 서버에 저장함.
      //  - 웹브라우저 설정시 쿠키를 차단하면 쿠키는 무용지물이됨.
      //  - 그래서 쿠키보단 세션을 사용하는 경우가 많고 보안면에서도
      //    사용자의 웹브라우저에 저장하지 않으므로 쿠키보다 더욱 좋다.

      // 세션 생성
      // session_start();
      // $_SESSION['id'] = 'songDurian';
      //  - 세션을 사용하는 페이지는 session_start() 함수가 작동해야 한다.
      session_start();  // session_start()함수는 무조건 최상단. 이 위에 어떤 코드도 x
      $_SESSION['id'] = 'songDurian';
      if (isset($_SESSION['id'])) {
        echo "세션 생성완료. id : {$_SESSION['id']}";
      } else {
        echo "세션 생성실패...";
      }

      // 세션 삭제
      // session_start()
      // unset($_SESSION['id']);
      //  - session_start() 함수가 없으면 세션을 불러올 수 없어서 세션을 삭제할 수도 없다.
      unset($_SESSION['id']);
      if (isset($_SESSION['id'])) {
        echo "세션 존재함. id : {$_SESSION['id']}";
      } else {
        echo "세션 존재하지 않음";
      }

      // // 모든 세션 삭제
      // // session_destory()
      $_SESSION['id_1'] = 'song_1';
      $_SESSION['id_2'] = 'song_2';
      $_SESSION['id_3'] = 'song_3';

      echo "<pre>";
      var_dump($_SESSION);  // 생성된 세션 확인
      echo '</pre>';

      if (session_destroy()) {
        echo "세션 삭제완료";
      } else {
        echo "세션 삭제실패..";
      }

      // 동시 실행하지 말고 위 싹다 주석시키고 확인.
      echo "<pre>";
      var_dump($_SESSION);  // 세션 삭제되었는지 확인
      echo '</pre>';

     ?>
  </body>
</html>
