<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <!-- 필수입력값이 아닌건 공백으로 값이 전해짐. 받는 php에서 trim쓴후 null로 변경해야함. -->
    <form name="test" method="POST" action="./4. insert.php">
      <input type="text" name="id" maxlength="12" placeholder="아이디" required>
      <input type="password" name="pw" maxlength="12" placeholder="비밀번호" required> <br><br>
      <input type="text" name="name" placeholder="이름" required>
      <input type="email" name="email" placeholder="이메일" required>
      <input type="text" name="phone" maxlength="13" placeholder="휴대폰번호" required> <br><br>
      생일 :
      <input type="date" name="date"> <br><br>
      <!-- <select name="birth_year" required>
        <?php
          // $this_year = date('Y', time());
          // for ($i=1960; $i <= $this_year; $i++) {
          //   echo "<option value='{$i}''>{$i}</option>";
          // }
         ?>
      </select>년 <br><br> -->
      성별 :
      남<input type="radio" name="gender" value="m" required>
      여<input type="radio" name="gender" value="w" required> <br><br>
      <input type="submit" value="입력"> <br><br>

      <input type="url" name="url" placeholder="(사이트 url)"> <br><br>
      <textarea name="longtext" rows="2" cols="30"></textarea> <br><br>
      음악 <input type="checkbox" name="hobby" value="music" checked>
      영화 <input type="checkbox" name="hobby" value="movie"> |
      파일 : <input type="file" name="attachedFile"> <br><br>
    </form>

    <?php
    $sql = "abc
            efg";
    echo $sql;
     ?>
  </body>
</html>
