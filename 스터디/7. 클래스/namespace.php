<?php

  // namespace와 use
  // namespace agroup
  // use \aGroup\aClass as aa;
  // $a = new \agroup\a;      // 인스턴스 생성
  // $aa = new aa;            // use를 사용한 인스턴스 생성
  // echo \agroup\print();    // 함수만 호출
  // echo $a->printTest();    // 클래스의 메소드 호출
  //  - 동일한 이름의 클래스나 함수를 사용할수 있게 한다.
  //  - 폴더 개념이며 다른 코드를 가져와 사용시 이름이 겹치지 않게 할 수 있다.
  //  - 골때리게 위에 <?php 이 코드 위에 어떤것도 오면 안된다. 엔터도 안되고 html 형식도 안된다.

  namespace aGroup;
  class aClass{
    function printTest() {
      return '첫번째 클래스의 메소드';
    }
  }
  namespace bGroup;
    class aClass{
      function printTest() {
        return '두번째 클래스의 메소드';
      }
    }

  use \aGroup\aClass as aa;
  use \bGroup\aClass as ba;
  $aa = new aa;
  echo $aa->printTest();
  echo '<br>';
  $ba = new ba;
  echo $ba->printTest();
?>
