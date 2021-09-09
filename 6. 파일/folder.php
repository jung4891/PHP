<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

      // mkdir(경로와 디렉토리명, 권한 설정값) : 폴더 생성
      // 권한설정값 : 생성자/그룹/사용자, 읽기(4)/쓰기(2)/실행(1)
      $folderName = 'test';
      if (mkdir('../'.$folderName, '777')) {
        echo "폴더 생성 완료<br>";
      } else {
        echo "폴더 생성 실패<br>";
      }
      echo '<br>';


      // rmdir(경로와 디렉토리명) : 폴더 삭제 (디렉토리 비워져 있어야 삭제됨)
      // rmdir('../'/$folderName);


      // is_dir(폴더명) : 폴더의 존재유무 확인
      if (is_dir('../'.$folderName)) {
        echo '폴더가 존재합니다.';
      } else {
        echo '폴더가 존재하지 않습니다.';
      }
      echo '<br><br>';


      // opendir(폴더명) : 폴더 열기
      if (opendir('../'.$folderName)) {
        echo '폴더를 열었습니다.';
      } else {
        echo '폴더를 여는데 실패했습니다.';
      }
      echo opendir('../'.$folderName);
        // -> Resource id #4 (핸들이라 부르고 사용자에게 표시되지 않는다.)
      echo '<br><br>';


      // readdir(opendir() 반환값) : 폴더 읽기
      // 호출할 때 마다 폴더 내부내용(폴더명, 파일명)을 하나씩 반환
      // 하지만 내부에 있는 폴더의 내부까진 안감. 딱 $opendir 위치까지만.
      // 불러올 파일이 없으면 false를 반환
      $folderName = 'test';
      if (is_dir('../'.$folderName)) {
        echo 'test폴더 존재함<br>';
        $opendir = opendir('../'.$folderName);
        if ($opendir) {
          echo 'test폴더 열고<br>';
          while($readdir = readdir($opendir)) {
            echo $readdir.'<br>';
          }
          closedir($opendir);   // 폴더 닫기
        } else {
          echo 'test폴더를 열지 못함';
        }
      } else {
        echo 'test폴더 없음';
      }


      // rewinddir($opendir) : readdir()함수의 데이터를 처음으로 되돌림
      // readdir()함수는 실행할때마다 데이터를 하나씩 반환. but 되돌아가진 않음
      $folderName = 'test';
      $opendir = opendir('../'.$folderName);
      if ($opendir) {
        echo readdir($opendir).'<br>';
        echo readdir($opendir).'<br>';
        echo readdir($opendir).'<br>';
        rewinddir($opendir);
        echo '<br>rewinddir() 함수 실행됨 <br>';
        echo readdir($opendir).'<br>';
        echo readdir($opendir).'<br>';
        echo readdir($opendir).'<br>';
      }





     ?>
  </body>
</html>
