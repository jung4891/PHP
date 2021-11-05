<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
  </head>
  <body>
    <br>
    <form name="form_test">
      이름: <input type="text" name="name" value=""> <br><br>
      살고있는 지역 :
      <input type="radio" name="city" value="seoul" checked>seoul
      <input type="radio" name="city" value="경기">경기 <br><br>
      좋아하는 음악 :
      <input type="checkbox" name="music" value="팝" checked> 팝
      <input type="checkbox" name="music" value="Jazz"> Jazz
      <input type="checkbox" name="music" value="가요"> 가요 <br><br>
      <input type="submit" id="test" value="전송">
    </form>
    <p id="here"></p>

    <script type="text/javascript">

      // $('#test').click(function(event) {
      //   alert('테스트1');
      //   // console.log(event);    event의 정체가 정확히 뭐지?
      // })

      // 잘 모르겟음...
      // serialize() : Ajax에서는 서버와의 비동기식 통신을 위해 form 요소를 통해 입력받은 데이터를 직렬화하여 전송
      //               직렬화란 입력받은 여러 데이터를 하나의 쿼리 문자열로 만드는 것을 말함
      //               이렇게 함으로써 form 요소를 통해 입력받은 데이터를 한 번에 서버로 보낼 수 있게 됩니다.]
      // serializeArray() 메소드는 serialize() 메소드와는 달리 입력된 데이터를 문자열이 아닌 배열 객체로 변환합니다.
      // (한글이 포함된 입력 데이터가 쿼리 문자열로 변환될 때는 퍼센트 인코딩(percent-encoding)을 통해 변환됨.
      //  이때 모든 한글 문자는 퍼센트 기호(%)를 포함한 16진수 값으로 변환됩니다.)
      $('form').on("submit", function(event) {  // <form>요소에 "submit" 이벤트가 발생할 때,
        // event.preventDefault();                 // 서버로 전송하지 않음.
        // alert('bb');
        // $('#here').html($(this).serialize());   // 입력받은 데이터를 직렬화하여 나타냄.
        var datas = $('#form_test').serialize();
        console.log(datas);
        $.ajax({
          url: "test_post.php",
          data: datas,
          method: "POST"
        })
        .done(function(data) {
          // alert('음.. ' + data);
          $('#here').html(data);
        })
      })

    </script>
  </body>
</html>
