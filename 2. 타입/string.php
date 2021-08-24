<!doctype html>
<html>
<body>
   <h4>String & String Operator</h4>
   <?php
    echo 'Hello World';
    echo "Hello World'2'";
    echo 'Hello World"3"';
    echo 'Hello World\'3\'';
    echo "Hello World\"2\"";
    ?>

    <h5>- 결합연산자(concatenation operator) .</h5>
    <?php
    echo "Hello"." World";    // +는 안된다.
     ?>

    <!-- 함수 -->
    <?php
     // strlen()
     $str = ' ab cd ';
     echo strlen($str)."<br>";   // 7

     // nl2br() : new line에 br태그 삽입함.
     $str = 'aaa
     bbb';
     echo $str."<br>";   // 줄개행 안됨
     $str = 'ccc
     ddd';
     echo nl2br($str)    // 줄개행 됨 (페이지소스보면 ccc뒤에 <br /> 생성됨)
     ?>

    <!-- 기타 -->
    <br>
    <?php
    echo "aaa<br>bbb"    // 브라우저는 개행되고 소스코드보기에선 <br>로 보임
     ?>

</body>
</html>
