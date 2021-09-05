<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

    /*
      # if문
      if (조건문) {
        조건문이 참일때 실행
      } else if (조건문2) {
        조건문이 거짓이고 조건문2가 참일때 실행
      } else {
        두 조건문 모두 거짓일때 실행
      }

      # 조건문 판별 기호
        >, >=, <, <=, ==, !=

      # AND(&&) 와 OR(||)
        (조건문1 && 조건문2) -> 둘다 참이여야 참
        (조건문1 || 조건문2) -> 둘중 하나만 참이면 참
        &&, ||를 주로 쓰지만 AND, OR를 직접 써도 작동함.
     */

    // if문
    $gender = "woman";
    $age = 32;
    if ($gender == "man") {
      if ($age >= 18 && $age <= 49) {
        echo "해당 남성은 코로나 10부제 예방접종 대상자입니다.";
      } else {
        echo "해당 남성은 코로나 10부제 예방접종 대상자가 아닙니다.";
      }
    } else if ($gender == "woman"){
      if ($age >= 18 && $age <= 49) {
        echo "해당 여성은 코로나 10부제 예방접종 대상자입니다.";
      } else {
        echo "해당 여성은 코로나 10부제 예방접종 대상자가 아닙니다.";
      }
    } else {
      echo "성별을 잘못 입력하셨습니다."
    }
    echo '<br><br>';


    // 조건값의 성향
    if(false || null || 0) {
      echo '실행안됨<br>';
    } else {
      echo '거짓 성향의 값<br>';
    };
    if(true && 1 && "한국") {
      echo '참 성향의 값';
    } else {
      echo "실행 안됨";
    }
     ?>
  </body>
</html>
