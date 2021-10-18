<!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>

     <!-- 이해 안됨.. -->
     <?php

     // EUC-KR (KS X 1001) 'C0 A7' -> '위' (Hex String)
     // UTF-8 '\uc704' -> '위' (Unicode Escape)
     //       '\u26d4' -> 금지 이모지
     //       ''\u2605' -> 까만별


     // $str = "Ludwigstra\u00c3\u009fe 51";
     // echo utf8_decode(implode(json_decode('["' . $str . '"]')));
     //
     //  $test = 'C0 A7';
     //  echo iconv('euc-kr', 'utf-8', $test).'<br>';   // C0 A7  왜???
     //  echo '<br>';
      ?>


      <!-- charset, encoding -->
      <?php
      // decbin(10진수) -> 2진수
      echo decbin(4).'<br>';      // 100

      // bindec(2진수) -> 10진수
      echo bindec(100).'<br>';    // 4

      // chr(아스키코드) -> 문자열
      echo chr(97).'<br>';   // a  ('97'도 결과 같음)

      // ord(문자열) -> 아스키코드
      echo ord('a').'<br>';   // 97

      echo utf8_encode('\xE0').'<br>';


      echo '<br>';
       ?>
   </body>
 </html>
