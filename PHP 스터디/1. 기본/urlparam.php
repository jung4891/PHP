<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    안녕하세요. <?php echo $_GET['name'];?>님 <br>
                     <!-- url로 넘어온 name의 값 -->
    버전: <?php echo $_GET['version'];?>
  </body>
</html>

<!--
  URL에 파라미터 넣기.
  (이게 없다면 html파일을 hyuk.html, jung.html~~~ 등등을 다 만들어야 되고
   수정시 굉장히 말도 안되게 슬퍼진다.)
  https://localhost/urlparam.php?name=hyuk 처럼 name에 값을 넣어
  수많은 html를 만들 필요 없이 바로바로 동적으로 변하게 할 수 있다.

  출력예시
  http://localhost/basic/urlparam.php?name=순이&version=1.1
  안녕하세요. 순이님
  버전: 1.1
  (?이후로는 파라미터(전달값)들이 오고 &는 파라미터 구분자다.)
-->
