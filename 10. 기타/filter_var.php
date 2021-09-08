<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      // filter_Var(검사할 값, 검사관련 상수)
      // 정규표현식을 사용하지않고 간단하게 유효성 검사가 가능
      $email = "go_go_ssing@naver.com";
      echo FILTER_VALIDATE_EMAIL;                      // 274 (뭔가 내부적으로 세팅된 듯)
      echo filter_Var($email, FILTER_VALIDATE_EMAIL);  // 유효:메일주소 그대로, 무효: null
      echo '<br>';
      if (filter_Var($email, FILTER_VALIDATE_EMAIL)) {
        echo "유효한 이메일!";
      } else {
        echo "유효하지 않은 이메일~";
      }
      echo '<br>';

      // URL 유효성 검사
      $url = "https://www.naver.com";
      if (filter_Var($url, FILTER_VALIDATE_URL)) {
        echo "유효한 URL!";
      } else {
        echo "유효하지 않은 URL~";
      }
      echo '<br>';

      // IP주소 유효성 검사
      $ip = "192.168.0.";
      if (filter_Var($ip, FILTER_VALIDATE_IP)) {
        echo "유효한 URL!";
      } else {
        echo "유효하지 않은 URL~";
      }
      echo '<br>';

      // 정수 유효성 검사
      $int = 100.1;
      if (filter_Var($int, FILTER_VALIDATE_INT)) {
        echo " 정수!";
      } else {
        echo "정수가 아님!";
      }
      echo '<br>';

      // 실수 유효성 검사
      $float = 100.1;
      if (filter_Var($float, FILTER_VALIDATE_FLOAT)) {
        echo " 실수!";
      } else {
        echo "실수가 아님!";
      }
      echo '<br>';


     ?>
  </body>
</html>
