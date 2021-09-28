<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    abc
  <?php
    // var_dump($user);

    // $user는 컨트롤러(Mail.php)에서 배열의 인덱스값이다.
    foreach ($user as $u) {
      echo $u['user_name'];
    }
    echo "<br>";
   ?>
  <?php
    foreach ($group as $gr) {
      echo $gr->groupName;
    }
   ?>
  </body>
</html>
