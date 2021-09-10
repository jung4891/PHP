<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

      // fopen(파일경로 및 파일명, 파일을 여는 옵션) : 파일 열기
      //  - 옵션  r : 읽기전용, w : 쓰기전용(처음부터 다시 씀), a : 쓰기전용(덧붙여 씀)
      //         r+ : 읽기,쓰기(삭제되고 다시 씀), a+ : 읽기,쓰기(덧붙여 씀)
      $fopen = fopen('hi.txt', 'r+');
      if ($fopen) {
        echo '파일을 열었습니다.<br>';
        fclose($fopen);   // 파일 닫기
      } else {
        echo '파일을 여는데 실패했습니다.<br>';
      }
      echo '<br>';


      // fwrite($fopen, 파일에 쓸 내용) : 파일 쓰기
      //  - fopen했으면 쓰거나 읽고 fclose하고 다시 fopen해서 읽고 쓸수 있는듯.
      //  - fopen했으면 쓰고 그리고 바로 읽으면 안됨.
      // $content = "fwrite 테스트!!!";
      // $fileName = 'hi.txt';
      // $fopen = fopen($fileName, 'w');   // 삭제되고 다시 씀
      // if (fwrite($fopen, $content)) {
      //   echo '파일쓰기 완료!<br>';
      // } else {
      //   echo '파일쓰기 실패..<br>';
      // }
      // fclose($fopen);
      // echo '<br>';


      // fread($fopen, 불러올 용량) : 파일 읽기
      // filesize(파일경로와 파일명) : 파일의 용량 확인. 바이트단위로 용량 반환
      // file_exists(파일명) : 파일 존재유무 (존재시 true, 아니면 false)
      $fileName = 'hi.txt';
      if (file_exists($fileName)) {
        $fopen = fopen($fileName, 'r+');
        if ($fopen) {
          $fread = fread($fopen, filesize($fileName));
          if ($fread) {
            echo $fread.'<br>';      // 내용 출력 (다 출력하고 <br> 먹음)
            fclose($fopen);          // .txt내용에 줄바꿈 있어도 한줄로 출력됨
          } else { echo "파일 읽기에 실패했습니다.";}
        } else { echo "파일 열기에 실패했습니다.";}
      } else { echo "파일이 존재하지 않습니다.";}
      echo '<br>';

      // fgets($fopen, 불러올 용량) : 파일의 내용을 한 라인씩 읽기
      //  - 보통 주소 정보를 최신화 할때 개발자는 한줄씩 읽어들여 자사 db에 최신화
      //  - fread()와는 달리 줄 바뀜을 만나면 가져오는 것을 종료함.
      //  - 불러올 용량은 줄바뀜이 언제 일어날지 모르므로 충분히 제시하는게 좋음
      //  - 더 불러올 내용이 없다면 false를 반환
      $fileName = 'hi.txt';
      if (file_exists($fileName)) {
        $fopen = fopen($fileName, 'r');
        $readByte = 512;
        if($fopen) {
          while ($fgets = fgets($fopen, $readByte)) {
            echo $fgets.'<br>';       // .txt내용에 줄바꿈 있으면 종료.
          }                           // 즉, 한줄씩 <br>먹음
        }
      }


      echo '<br><br>';
      // include "파일경로 및 파일명" : 공통의 기능을 하는 파일을 다른 곳에서 불러올때.
      // include_once : 이전에 불러온적이 없으면 불러오고 한번이라도 있으면 실행안됨.
      // include "./hello.php";
      // include_once "./hello.php";

      // include와 require
      // include는 불러오는 파일명이나 경로에 문제가 있어도 오류안나고 실행은 됨.
      // require는 오류가 발생하여 그 이후로는 로드가 되지 않음.
      // require "./hello.php";


     ?>
  </body>
</html>
