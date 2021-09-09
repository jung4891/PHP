<?php
  // namespace
  // namespace agroup
  // echo \agroup\print();
  //  - 동일한 이름의 클래스나 함수를 사용할수 있게 한다.
  //  - 폴더 개념이며 다른 코드를 가져와 사용시 이름이 겹치지 않게 할 수 있다.
  //  - 골때리게 위에 <?php 이 코드 위에 어떤것도 오면 안된다. 엔터도 안되고 html 형식도 안된다.
  namespace agroup;
  class a{
    function printTest() {
      return '첫번째 클래스의 메소드';
    }
  }
  namespace bgroup;
    class a{
      function printTest() {
        return '두번째 클래스의 메소드';
      }
    }

  $a = new \agroup\a;   // 객체생성
  echo $a->printTest();
  echo '<br>';
  $a2 = new \bgroup\a;
  echo $a2->printTest();
?>
