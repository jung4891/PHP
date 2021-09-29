<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    zzzzzzzzzzzzzzzzzzzz
    <?php
    // var_dump($user);

    foreach ($user as $u) {
      echo $u['user_name'];
    }

echo "<br>";
     ?>

     <br>

<?php
foreach ($group as $gr) {
  echo $gr->groupName;
}

 ?>
  </body>
</html>
