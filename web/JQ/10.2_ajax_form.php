<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
  </head>
  <body>
    <br>
    <form name="frm" id="form_id">
      이름: <input type="text" name="name" id="name" value=""> <br><br>
      나이: <input type="text" name="age" id="age" value=""> <br><br>
      살고있는 지역 :
      <input type="radio" name="city" value="seoul" checked>seoul
      <input type="radio" name="city" value="경기">경기 <br><br>
      좋아하는 음악 :
      <input type="checkbox" name="music[]" value="팝" checked> 팝
      <input type="checkbox" name="music[]" value="Jazz"> Jazz
      <input type="checkbox" name="music[]" value="가요"> 가요 <br><br>
      <input type="submit" id="test" value="전송">
    </form> <br>
    <input type="submit" id="test2" value="전송2">
    <p id="here"></p>

    <script type="text/javascript">

    $(function() {
      // document.getElementById('here').innerText="요렇게 해야 되는군";
      // document.getElementById('here').innerHTML="<b>js가 jq보다 까다롭군</b>";
    })

    // ajax 기본 연습용
    $('#test').click(function(event) {
      let user_name = document.getElementById('name').value;
      let user_age = $('#age').val();
      let dataStr = $('form[name=frm]').serialize();

      // 클릭할 버튼이 form 안에 들어있으면 버튼 누르고 다시 로드되서 아래 테스트 어려움.
      // let dataStr = $('#form_id').serialize();
      // event.preventDefault();   // 하지만 요걸 넣어주면 서버로 가질 않게되어 테스트됨
      // document.getElementById('here').innerHTML = dataStr;

      $.ajax({
        // 연습용 1 (출력된거 그대로 문자열로 가져옴)
        // url: "test_ajax.php",
        // data: { name: 'song1'},
        // method: "POST",
        // success: function(a) {
        //   alert(a);
        // },

        // 연습용 1_1 (서버에서 이름(song만 유효) 체크후 결과값 가져옴)
        // url: "test_ajax.php",
        // data: { name: user_name },
        // method: "POST",
        // success: function(res) {
        //   if (res)  alert("name 유효함");  else alert("name 무효!");
        // },

        // 연습용 2 (입력한 이름과 나이를 서버로 보낸뒤 json으로 가져옴)
        // url: "test_ajax.php",
        // data: { name: user_name, age: user_age },
        // method: "POST",
        // dataType: "json",
        // success: function(json) {
        //   console.log(json);
        //   alert("이름: " + json.name);
        //   alert("나이: " + json[1]);
        //   (json.res)? alert("이름 유효") : alert("이름 무효");
        // },

        // 연습용 3 (serialize())
        // serialize()
        // Ajax에서는 서버와의 비동기식 통신을 위해 form 요소를 통해 입력받은 데이터를
        // 직렬화(입력받은 여러 데이터를 하나의 쿼리 문자열로 만듬)하여 전송.
        // 이렇게 함으로써 form 요소를 통해 입력받은 데이터를 한 번에 서버로 보낼 수 있게 됩니다.
        // serializeArray()
        // serialize() 메소드와는 달리 입력된 데이터를 문자열이 아닌 배열 객체로 변환합니다.
        // (한글이 포함된 입력 데이터가 쿼리 문자열로 변환될 때는
        //  퍼센트 인코딩을 통해 한글 문자는 퍼센트 기호(%)를 포함한 16진수 값으로 변환됨.)
        // let datas = $('#form_id').serialize();
        url: "test_ajax.php",
        data: $('form').serialize(),      // 이렇게도 되는군
        // data: $('form[name=frm]').serialize(),
        method: "POST",
        dataType: "json",
        success: function(json) {
          console.log(json);
          alert("도시: " + json.city);
          alert("음악: " + json.music);   // music은 여러개 선택시 name을 배열로 해야 된다.
          // alert("음악: " + json.music[1]);
        },
        error: function(err) {
          alert(err);
        }
      })
    })

    // form은 요런 식으로도 가능하다.
    // $('form').on("submit", function(event) {  // <form>요소에 "submit" 이벤트가 발생할 때,
    //   event.preventDefault();                 // 서버주소로 전송하지 않음.
    //                                           // (이걸해야 페이지가 넘어가지 않고 콘솔에 테스트 찍어볼 수 있다.)
    //   // $('#here').html($(this).serialize());   // 입력받은 데이터를 직렬화하여 나타냄.
    // })

    </script>
  </body>
</html>
