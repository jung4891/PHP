<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

      // phpinfo();  -> PHP 설정 보기
      // xampp/php/php.ini에서 timezone 'Asia/Seoul'로 수정


      // 타임스탬프 : 1970.1.1 0시0분0초부터 세기 시작한 시간(초)
      echo time().'<br>';    // 1630995087 ()


      // date() : 타임스탬프 -> 특정시간
      // date(시간 포맷, 타임스탬프값)
      echo date('Y년 m월 d일 H시 i분 s초', time()).'<br>';
          // 2021년 09월 07일 15시 20분 12초


      // mktime(시, 분, 초, 월, 일, 년) : 특정시간 -> 타임스탬프
      $timeStamp = mktime(15, 20, 12, 9, 7, 2021);
      echo $timeStamp.'<br>';


      // 타임스탬프를 활용한 특정시간 이벤트
      // 시작시간 : 2021년 09월 07일 15시 32분 00초
      // 종료시간 : 2021년 09월 07일 15시 32분 05초
      $startTime = mktime(15, 32, 0, 9, 7, 2021);
      $endTime = mktime(15, 32, 5, 9, 7, 2021);
      $nowTime = time();

      if ($nowTime >= $startTime && $nowTime <= $endTime) {
        echo "백신 접종예약 페이지로 이동합니다.";
      } else {
        echo "현재 접종예약이 가능한 시간이 아닙니다.";
      }
      echo '<br>';


      // 특정 날짜가 있는 주의 월요일/일요일 날짜 구하기
      $year = 2021;
      $month = 9;
      $day = 7;
      $second_of_oneday = 24 * 60 * 60;

      // 특정날짜 > 타임스탬프
      $targetDateTimeStamp = mktime(0, 0, 0, $month, $day, $year);
      // 타임스탬프 > 요일(0~6)
      $dayOfWeek = date('w',$targetDateTimeStamp);

      // 월요일, 일요일 타임스탬프 계산
      switch($dayOfWeek) {
        case 0:   // 일요일
          $monday = $targetDateTimeStamp - ($second_of_oneday * 6);
          $sunday = $targetDateTimeStamp;
          break;
        case 1:   // 월요일
          $monday = $targetDateTimeStamp;
          $sunday = $targetDateTimeStamp + ($second_of_oneday * 6);
          break;
        case 2:   // 화요일
          $monday = $targetDateTimeStamp - ($second_of_oneday * 1);
          $sunday = $targetDateTimeStamp + ($second_of_oneday * 5);
          break;
        case 3:   // 수요일
          $monday = $targetDateTimeStamp - ($second_of_oneday * 2);
          $sunday = $targetDateTimeStamp + ($second_of_oneday * 4);
          break;
        case 4:   // 목요일
          $monday = $targetDateTimeStamp - ($second_of_oneday * 3);
          $sunday = $targetDateTimeStamp + ($second_of_oneday * 3);
          break;
        case 5:   // 금요일
          $monday = $targetDateTimeStamp - ($second_of_oneday * 4);
          $sunday = $targetDateTimeStamp + ($second_of_oneday * 2);
          break;
        case 6:   // 토요일
          $monday = $targetDateTimeStamp - ($second_of_oneday * 5);
          $sunday = $targetDateTimeStamp + ($second_of_oneday * 1);
          break;
      }

      if (isset($monday) && isset($sunday)) {
        echo "{$year}년 {$month}월 {$day}일이 있는 주의 월요일, 일요일 날짜 <br>";
        echo '월요일: '.date('Y-m-d', $monday).'<br>';
        echo '일요일: '.date('Y-m-d', $sunday).'<br>';
      } else {
        echo "내부오류";
      }
      echo '<br><br>'; 


      // getdate() : 현재 시간정보를 배열로 보내줌
      $nowTime = getdate();
      echo "현재 년도 : ".$nowTime['year']."<br>";
      echo "현재 월 : ".$nowTime['mon']."<br>";
      echo "현재 일 : ".$nowTime['mday']."<br>";
      echo "현재 시 : ".$nowTime['hours']."<br>";
      echo "현재 분 : ".$nowTime['minutes']."<br>";
      echo "현재 초 : ".$nowTime['seconds']."<br>";
      echo "현재 요일 숫자 : ".$nowTime['wday']."<br>";
      echo "현재 월 문자 : ".$nowTime['weekday']."<br>";
      echo "현재 시간 타임스탬프 : ".$nowTime[0]."<br>";
      echo "올해의 일차 : ".$nowTime['yday']."<br><br>";


      // checkdate(월, 일, 년) : 날짜값이 유효한지 확인
      $isDateCheck = checkdate(2, 29, 2019);
      if ($isDateCheck) {
        echo "유효한 날짜입니다.";
      } else {
        echo "유효하지 않은 날짜입니다.";
      }
      echo "<br><br>";


      // microtime() : 1초 이하의 마이크로초를 표시
      echo time().'<br>';           // 1631019732
      echo microtime().'<br>';      // 0.74864900 1631019732 (소수 정수)
      echo microtime(true).'<br>';  // 1631019732.7487




     ?>

  </body>
</html>
