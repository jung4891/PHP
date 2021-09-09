<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
<?php

  // 쿠키
  //  - 사용자의 컴퓨터(웹브라우저)에 저장되어있는 사용자 관련 데이터
  //  - 검색어 저장기능이 있고 사이트 로그인시 사용자 컴퓨터에 쿠키를 저장하여
  //    회원인지 아닌지를 판단한다.쿠키의 총 용량은 4kb이다.

  // 쿠키 생성
  // setcookie("쿠키명", "쿠키 값", "폐기 시간", "경로")
  //  - 다섯번째 아규먼트에는 적용할 도메인. 가령, everdevel.com을 입력시 그 도메인 실행시에만 작동.
  //  - 여섯번째 아규먼트에는 프로토콜이 http에서 작동할지 또는 https에서 작동할지를 지정
  // setcookie('name', 'HyukJung', time()+3600, '/');
  // 쿠키 폐기시간 : 1시간 후
  // 쿠키 생성여부는 크롬 인스펙터(F12)로 확인가능
  echo date('Y년 m월 d일 H시 i분 s초', time()).'<br>';

  // 생성한 쿠키 값 보기
  // $_COOKIE[쿠키명]
  if (isset($_COOKIE['name'])) {
    echo $_COOKIE['name'].'<br>';   // HyukJung
  } else {
    echo '쿠키가 존재하지 않음.';
  }

  // 쿠키 적용범위 (testPHP폴더 내부에서만 쿠키가 적용됨)
  // setcookie('namePHP', 'HyukJungPHP', time()+3600, '/testPHP/');

  // 쿠키 삭제
  setcookie('namePHP', 'HyukJungPHP', time()-100, '/testPHP/')
 ?>
  </body>
</html>
