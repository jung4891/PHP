<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

      // 상속
      // class b extends a{}
      // - 이미 선언된 클래스 내용을 다른 클래스에서 사용할 수 있는 기능
      // - 상속을 사용하면 클래스와 클래스간에 부모 자식 관계가 형성됨(public, protected만)
      // - 2개 이상의 클래스를 상속받을순 없다.
      //   즉, 부모는 여러 자식을 둘 순 있지만 자식은 여러 부모를 가질 순 없다.

      // 접근제한자
      //  - public : 클래스 내부/외부 접근가능, 상속 가능. 다 쌉가능
      //  - protected : 클래스 내부 접근가능, 상속 가능.
      //  - private : 클래스 내부 접근 가능, 상속 불가.

      class a{
        private function hi(){
          echo "hi PHP~! (from a class)<br>";
        }
        public function nihao(){
          $this->hi();      // hi()메소드가 private이라 같은 클래스내에서만 호출가능.
        }
      }
      class b extends a{}
      class c extends a{}
      $c = new c();
      $c->nihao();


      session_start();  // session_start()함수는 무조건 최상단. 이 위에 어떤 코드도 x
      if (isset($_SESSION['id'])) {
        echo "세션 생성완료. id : {$_SESSION['id']}";
      } else {
        echo "세션 생성실패...";
      }

     ?>
  </body>
</html>
