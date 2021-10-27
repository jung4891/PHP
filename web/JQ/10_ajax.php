<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
  </head>
  <body>
    <!--
      Ajax (Asynchronous JavaScript and XML)
      - 웹페이지 전체를 다시 로딩하지 않고도 웹 페이지의 일부분만을 갱신할 수 있게함
        백그라운드 영역에서 서버와 데이터를 교환하여 웹 페이지에 표시해줌
      - jQuery는 가장 대표적인 Ajax 프레임워크로 여러 메소드를 제공하여
        ajax기능을 손쉽게 사용할 수 있다.
    -->
    <h5>jQuery & Ajax</h5>
    <p id="test">이 단락에 다른 텍스트가 불러와짐</p>
    <button type="button" id="req_btn">1. 데이터 불러오기!</button> <br><br>
    <button type="button" id="post_btn">2. $.post</button>
    <button type="button" id="post_btn2">2. $.post(json받기)</button> <br><br>
    <button type="button" id="ajax_btn">3. $.ajax</button>
    <h3 id="ajax1"></h3> <span class="ajax2">이곳에 가져온 json 출력됨</span> <br><br>
    <button type="button" id="load_btn">4. load()</button>
    <span id="load"></span>

    <script type="text/javascript">

    // 1. jQuery 기본
    $('#req_btn').on('click', function() {
      // $('#test').load('a.txt');
      // $('#test').text('<b>이렇게도 되겠지요~?</b>');
      var a = 'aaa';
      $('#test').html('<b>이렇게도 되겠지요~?</b>').append(a);  // 태그 적용되서 출력됨
    })

    // 2. $.post(URL, data, callback할 함수);
    $('#post_btn').click(function() {
      // POST 방식으로 서버에 HTTP Request를 보냄
      $.post("test.php",
      {
        "name":"Song",
        city:"Seoul"
      }, function(data, status){
        // data: test.php에 데이터를 보내고 반환된 결과(echo로 출력된것)임.
        alert(data + "\n" + status);
        $('#test_post').text(data);
      });
    });

    // 2. $.post(URL, callback할 함수, "json");
    $('#post_btn2').click(function() {
      $.post("test_post2.php", function(json){
        alert(json.b);
        console.log(json.b);
      }, "json");
    });

    // 3. $.ajax(URL[, 옵션]);
    // $.ajax() 메소드는 모든 제이쿼리 Ajax 메소드의 핵심이 되는 메소드
    // 옵션은 HTTP 요청을 구성하는 키와 값의 쌍으로 구성되는 헤더의 집합
    $('#ajax_btn').click(function() {
      $.ajax({
        url: "test_ajax.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: { name: "혁중" },     // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",             // HTTP 요청 방식(GET, POST)
        dataType: "json"            // 서버에서 보내줄 데이터의 타입
      })
      // HTTP 요청이 성공하면 요청한 데이터가 done() 메소드로 전달됨.
      .done(function(json) {
        alert("요청 성공");
        $('.ajax2').text(json.name).appendTo('#ajax1');
      })
      // HTTP 요청이 실패하면 오류와 상태에 관한 정보가 fail() 메소드로 전달됨.
      .fail(function(xhr, status, errorThrown) {
        alert("요청 실패");
        $(".ajax2").html("오류가 발생했습니다.<br>")
        .append("오류명: " + errorThrown + "<br>")
        .append("상태: " + status);
      })
      // HTTP 요청이 성공하거나 실패하는 것에 상관없이 언제나 always() 메소드가 실행됨.
      .always(function(xhr, status) {
        alert("요청 완료");
      });
    });

    // 4. load() 메소드
    // 서버에서 데이터를 읽은 후, 읽어 들인 HTML 코드를 선택한 요소에 배치함
    // 선택자를 URL 주소와 함께 전송하면, HTML에서 선택자와 일치하는 요소만을 배치함
    $('#load_btn').click(function() {
      // $('#load').load("test_load.html");
      // $('#load').load("test_load.html p");
      $('#load').load("test_load.html .abc");
    });

    </script>
  </body>
</html>
