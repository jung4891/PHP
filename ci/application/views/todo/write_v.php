<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>Todo 쓰기</h1>
    <!-- action주소가 비어있을 경우 현재 뷰를 호출한 주소(http://local/todo/index.php/main/write)로 전송됨 -->
    <!-- input태그의 name은 db의 필드명과 같게 작업하는게 좋다. -->
    <form action="" method="post">
      내용:
      <input type="text" name="content" value=""><br>
      시작일:
      <input type="text" name="created_on" value=""><br>
      종료일:
      <input type="text" name="due_date" value=""><br>
      <br><br>
      <input type="submit" name="" value="작성">&nbsp
      <input type="button" onclick="location.href='/index.php/todo'" value="취소">
    </form>

  </body>
</html>
