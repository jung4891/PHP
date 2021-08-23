<!DOCTYPE html>
<html lang="en" dir="ltr">
  <body>
    <?php
    $a = 1;       // a = 2; 안됨.
    echo $a+1;

    $name = "jungggggg";
    echo "Lorem ipsum dolor sit amet, ".$name." consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis ".$name." nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia ".$name." deserunt mollit anim id est laborum. ".$name."<br><br>";

    echo "이렇게도 쓸수 있다. $name 이렇게 그냥 결합연산자인 .안써도됨"



     ?>
  </body>



</html>

<!--
  변수
   - php는 변수 앞에 반드시 $를 붙인다.

 -->
