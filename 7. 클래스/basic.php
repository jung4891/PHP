<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

      // class
      // class pen {}
      //  - 여러기능(데이터 입력/수정/삭제등등)을 하나로 모아놓을 수 있음
      //  - class로 객체(컴퓨터상에서의 사물화 - 가상의 pen)를 생성하여 객체지향 프로그래밍이라함
      //  - 같은 이름의 class를 2개 이상 만들 수 없다.

      // property (속성)
      // public $color;
      //  - 데이터를 대입하기 위한 변수, class의 속성을 넣어줌

      // method(기능)
      // function write($contents) { echo "{$contents}을 쓰다." }
      //  - 접근 제한자는 function 앞에 사용. 사용안할시 public 기본 설정됨
      //  - 같은 클래스에서 property 혹은 method 사용시 $this(해당 클래스 자신을 의미)를 사용함.

      // 생성자
      // function __construct(){}
      //  - 생성자는 인스턴스를 생성하면 자동으로 호출됨
      //  - 생성자는 파라미터 있는거 선언하면 기본생성자는 사용안되는듯. 중복안됨

      // 소멸자
      // function __destruct(){}
      //  - 인스턴스의 사용이 끝날 때 작동함.

      // 클래스의 인스턴스(객체) 생성 및 메소드 호출하기
      // new pen();
      // $pen = new pen();
      // $pen->write('일기');

      class pen {
        public $color = '노랑색';
        public $price;

        function __construct($param) {
          echo "parameter로 전달받은 팬 색상: {$param} <br>";
          echo "지정되어있는 property 팬 색상: {$this->color} <br>";
          $this->color = $param;    // 전달받은 색으로 property 변경
        }

        public function write($contents) {
          echo "{$this->color}팬으로 {$contents}를 쓰다.<br>";
        }

        public function __destruct() {
          echo "pen 객체 사용이 끝남.<br>";
        }
      }
      $pen = new pen('파랑색');
      $pen->write('일기');


     ?>
  </body>
</html>
