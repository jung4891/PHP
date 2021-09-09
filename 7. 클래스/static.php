<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

      // static
      // public static function write(){ echo '글씨를 씁니다.'}
      // a::write();    -> 호출
      //  - 인스턴스 생성 없이 메소드를 호출하는 법.
      //  - 접근 제한자를 사용할시 접근 제한자 다음에 stataic을 기입함

      class a {
        public static function write($word) {
          echo $word;
        }
      }

      a::write("집에 갈 시간");


     ?>
  </body>
</html>
