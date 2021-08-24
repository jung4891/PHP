<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1><a href="index.php">WEB</a></h1>
    <ol>
      <li><a href="index.php?id=HTML">HTML</a></li>
      <li><a href="index.php?id=CSS">CSS</a></li>
      <li><a href="index.php?id=JavaScript">JavaScript</a></li>
    </ol>

    <h2>
      <?php
      if (isset($_GET['id'])) {
        echo $_GET['id'];
      } else {
        echo 'Welcome';
      }
      ?>
    </h2>
    <?php
    if (isset($_GET['id'])) {
      $file = file_get_contents('data/'.$_GET['id']);
      echo $file;             // data/id 값에 해당하는 파일의 내용
    } else {
      echo 'WEB 메인페이지입니다.'; 
    }

     ?>
  </body>
</html>
