<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      // https://openwiki.kr/tech/regex
      
      // 정규표현식
      // - 값이 한글로만 혹은 영어로만 구성되어 있는지, 메일주소/전화번호가 올바른지
      //   체크하기위해 사용한다. 패턴을 사용하려면 preg_match()함수를 사용한다.
      // - preg_match(패턴, 검사할 텍스트, 반환할 일치결과를 받을 변수)
      // - 패턴은 $pattern = '/패턴 입력/'; 형식으로 사용한다.
      // ^ : 첫 번째 글자를 적용하는 기호
      // $ : 끝나는 글자를 적용하는 기호

      // 문자열의 값이 s인지 확인
      // 패턴식은 검사할 바이트 수를 지정하지 않으면 기본적으로 1byte를 검사한다.
      // 영문과 특수문자는 1byte의 용량을 사용 / 한글은 3byte
      // + : 1byte 이상을 검사하는 기호
      $pattern = '/^s.+a$/';
      $str = 'a saaasab ssa';
      // echo preg_match($pattern, $str, $res);  // 적합하면 1, 부적합이면 0 출력됨
      if (preg_match($pattern, $str, $res)) {
        echo '문자열 s+ 검사 적합';
        echo '<pre>';
        var_dump($res);
        echo '<pre>';
      } else {
        echo '문자열 s+ 검사 부적합';
      }
      echo '<br>';

      // preg_match_all : 정규표현식에 맞는 것을 모두 추출하는 함수
      $str = 'abc bc abbbaa cabz ab ';
      preg_match_all('/ab./', $str, $matches);  // .은 모든문자 한개를 의미
      echo '<pre>';
      print_r($matches);      // [0] => abc, [1] => abb, [2] => abz, [3] => ab( )
      echo '</pre>';

      $str = 'src="cid:image001.png@1234512.1Agsd1243"> ';
      preg_match_all('/"cid:.+"/', $str, $matches);  // .은 모든문자 한개를 의미
      echo '<pre>';
      print_r($matches);      // [0] => abc, [1] => abb, [2] => abz, [3] => ab( )
      echo '</pre>';

      echo '<br>';

      // 문자열의 값이 한글/영어/기타 특수문자 인지 검사
      // 한글은 가 ~ 힣로 끝남. '/^[가-힣]$/'
      // [-] : 간격을 지정함
      // [-]{3} : 패턴 검사할 byte는 {}안에 byte수 지정. 한글 1글자만 검사.
      // [-]{3,} : 1글자 이상 검사
      // [-]{9} : 3글자(9byte) 검사
      // [-]+ : 1바이트 이상 검사    {+} 아님
      // [a-zA-Z가-힣] : 영어소문자/영어대문자/한글 허용
      // [,. ] : ',', '.', ' ' 허용
      $pattern = '/^[a-zA-Z가-힣,._ ]+$/';
      $str = '신나는 웹코딩aA.,_ ';
      if (preg_match($pattern, $str, $res)) {
        echo '한글 검사 적합';
        echo '<pre>';
        var_dump($res);
        echo '<pre>';
      } else {
        echo '한글 검사 부적합';
      }
      echo '<br>';

      // 휴대폰 전화번호 검사 (010-1234-4891)
      // ^[0-9]+$/ : 0-9까지 숫자 하나 이상 포함
      // (010|011) : OR기호를 사용하기 위해선 ()와 |를 활용
      // 010-   (앞 3자리-)
      //  -> /^(010|011|016|017|018|019)-
      // [^] : 처음에 위치하면 안되는 문자를 지정 (ex. [^0])
      // 1234-  (중간 3~4자리, 제일 앞에 0이 오면안됨.)
      //  -> [^0][0-9]{3,4}-
      // 4891   (끝 4자리. 앞에 0이 와도 됨)
      //  -> [0-9]{4}
      $pattern = '/^(010|011|016|017|018|019)-[^0][0-9]{2,3}-[0-9]{4}$/';
      $str = '010-2222-3412';
      if (preg_match($pattern, $str, $res)) {
        echo '폰번 검사 적합';
        echo '<pre>';
        var_dump($res);
        echo '<pre>';
      } else {
        echo '폰번 검사 부적합';
      }
      echo '<br>';


    // 이메일 주소 유효성 검사하기
    // - go_go_ssing@naver.com
    // - @앞에 아이디는 영어대소문자, 숫자, _, -, .이 섞여들어감
    // - 아이디 앞에는 _, -, .이 위치하지 않음
    // [\-] : 간격이 아닌 문자로 사용
    // \.[] : .은 []밖에선 모든 문자를 의미 \.은 문자열 .을 의미
    // $pattern = '/^[^\-_.]/';
    // $pattern = '/^[a-zA-Z]{1}/' -> 첫글자는 영어 대소문자만.
    // $pattern = '/[a-zA-Z0-9.\-_]+/'  -> 첫글자 이후 아아디 패턴식
    // go_go_ssing@
    //    -> '/^[a-zA-Z]{1}[a-zA-Z0-9.\-_]+@'
    // naver.
    //    -> '[a-z0-9]{1}[a-z0-9\-]+[a-z0-9]{1}\.'
    // com (or co.kr)
    //    -> (([a-z]+)|([a-z]{1}[a-z.]+[a-z]{1}))$
    $pattern = '/^[a-zA-Z]{1}[a-zA-Z0-9.\-_]+@[a-z0-9]{1}[a-z0-9\-]+[a-z0-9]{1}\.(([a-z]+)|([a-z]{1}[a-z.]+[a-z]{1}))$/';
    $str = 'go_go_ssing@naver.com';
    if (preg_match($pattern, $str, $res)) {
      echo '이메일 적합';
      echo '<pre>';
      var_dump($res);
      echo '<pre>';
    } else {
      echo '이메일 부적합';
    }
    echo '<br>';
























     ?>
  </body>
</html>
