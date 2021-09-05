<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

      // switch문
      // 하나의 대상을 기준으로 여러 조건문을 사용할 경우
      $num = 'two';
      switch($num) {
        case 'one':
          echo 1;
          break;    // break 없을경우 12로 출력됨
        case 'two':
          echo 2;
          break;
        default:    // if문의 else 역
          echo 'null';
          break;
      }
      echo '<br><br>';


      // else switch (여탕내 남자아이 5세이하만 입장가능한 경우)
      $gender = 'man';
      $age = 6;
      if($gender == 'woman') {
        echo '환영합니다~!';
      } else switch($age){
          case ($age <= 5):
            echo '입장가능합니다!';
            break;
          default:
            echo '5세 이하 어린이만 입장가능!';
            break;
      }


     ?>
  </body>
</html>
