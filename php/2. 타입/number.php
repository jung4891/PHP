<!doctype html>
<html>
<body>
  <h4>Number & Arithmetic Operator</h4>
  <?php

    // round(반올림할 수(실수), 표시할 소수점 위치)
    // round(반올림할 수(정수), 반올림할 자리)
    echo round(23.118, 2).'<br>';  // 23.12 (2번째 소수점 자리까지 살림)
    echo round(1254, -3).'<br>';   // 1000 (끝에서 3번째 자리에서 반올림)
    echo '<br>';

    // floor(내림할 실수) : 소수점은 버림 (<-> ceil())
    echo floor(142.112).'<br>';   // 142
    echo ceil(142.112).'<br>';    // 143
    echo '<br>';

    // number_format(표시할 수) : 세자리마다 , 표시함
    // number_format(표시할 실수, 표시할 소수점 자리수) -> 반올림됨
    // number_format(실수, 소수점 자릿수, 소수점 표시문자, 콤마 표시문자)
    echo number_format(5325235123).'<br>';   // 5,325,235,123
    echo number_format(2135612.13362, 3).'<br>';  // 2,135,612.134
    echo number_format(4235125.5942, 1, '^', '_').'<br>';  // 4_235_125^6
    echo '<br>';

    // rand(시작값, 끝값) : 랜덤수 반환
    $n = rand(1, 10);
    echo "1~10중 랜덤숫자 : {$n} <br>";
    echo '<br>';

   ?>

</body>
</html>
