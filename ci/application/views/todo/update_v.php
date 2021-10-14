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
      <input type="text" name="id" value="<?= $row->id?>" style="display:none;"><br>
      내용:
      <input type="text" name="content" value="<?= $row->content?>"><br>
      시작일:
      <input type="text" name="created_on" value="<?= $row->created_on?>"><br>
      종료일:
      <input type="text" name="due_date" value="<?= $row->due_date?>"><br>
      <br><br>
      <input type="submit" name="" value="수정하기">&nbsp
      <input type="button" onclick="location.href='/todo/lists'" value="취소">
    </form>

  </body>
</html>
