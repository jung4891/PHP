<!DOCTYPE html>
<html>
  <body>
    <?php
      echo date('Y-m-d H:i:s');   // 현재 시간을 출력해라!
     ?>
  </body>
</html>

<!-- http://localhost/1. 기본/static.html
     http://localhost/1. 기본/dynamic.php
     php파일로 요청시 f12로 소스보면 새로고침 할때마다 시간이 동적으로 변경됨
     즉 브라우저가 dynamic.php를 아파치 웹서버에 요청시 웹서버는 처리를 못하므로
     그대로 PHP(html공장)으로 넘어가져서 그 공장에서 php처리후 나온
     php코드가 없는 순수한 html정보를 서버에 보내고 그게 브라우저에 보이게 된다.

     html은 html파일이 만들어지면 언제나 똑같이 정적으로 동작하지만
     php는 html를 동적으로(프로그래밍적) 생산할 수 있다.
 -->
