<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      // 세션
      // 유저로그인시 일정시간동안 데이터를 유지하기 위해 사용하는 기능
      // 웹 페이지에서 세션을 생성하면 다른 웹 페이지에서 데이터를 가져다 사용할 수 있다.
      // 웹 종료 되면 파괴되며, 코드상으로도 세션을 파괴할 수 있다.

      //  - 쿠키와 비슷하나 정보를 사용자 컴퓨터가 아닌 서버에 저장함.
      //  - 웹브라우저 설정시 쿠키를 차단하면 쿠키는 무용지물이됨.
      //  - 그래서 쿠키보단 세션을 사용하는 경우가 많고 보안면에서도
      //    사용자의 웹브라우저에 저장하지 않으므로 쿠키보다 더욱 좋다.


      // 세션 생성 : session_start()
      // 세션을 사용하는 페이지는 session_start() 함수가 작동해야 한다.
      // 이 함수가 호출되기 이전에 어떤 형태의 출력문도 있으면 안된다. 무조건 최상단.
      // 이 함수는 주로 head나 lib파일 같이 고정적으로 include 되는 파일에 포함되어 있다.
      session_start();
      $_SESSION['id'] = 'songDurian';   // 세션등록
      $_SESSION['id2'] = 'songDurian2';
      if (isset($_SESSION['id']) && isset($_SESSION['id2'])) {
        echo "세션 생성완료. id : {$_SESSION['id']}".'<br>';      // 세션 생성완료. id : songDurian
        echo "세션 생성완료. id2 : {$_SESSION['id2']}".'<br>';    // 세션 생성완료. id2 : songDurian2
      } else {
        echo "세션 생성실패...".'<br>';
      }
      echo "<br>";
    ?>
    <a href="/10. 기타\session_2.php">session_2 페이지로 이동</a>
  </body>
</html>
