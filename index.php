
<?php
  function print_title(){
    if (isset($_GET['id'])) {
      echo $_GET['id'];
    } else {
      echo 'Welcome';
    }
  }

  function print_list(){
    $dir = './data';
    $files = scandir($dir);   // 디렉토리에 있는 파일명들을 담아 배열로 리턴
    $i = 0;
    while($i < count($files)) {
      if($files[$i] != '.' && $files[$i] != '..' ) {
        echo "<li><a href=\"index.php?id=$files[$i]\">$files[$i]</a></li>\n";
      }
      $i = $i + 1;
    }
    // "" 안에 $가 오면 그 담에 오는게 변수명으로 인식한다. ''는 안됨. ``도 안됨.
    // \n은 HTML이 아닌 일반텍스트문서에서 줄바꿈. (페이지소스페이 )
    // <!-- <li><a href=index.php?id=$files[3]>$files[3]</a></li> -->
  }

  function print_description(){
    if (isset($_GET['id'])) {
      $file = file_get_contents('data/'.$_GET['id']);
      echo $file;             // data/id 값에 해당하는 파일의 내용
    } else {
      echo 'Hello, PHP~!';
    }
  }
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>
      <?php
      print_title();
      ?>
    </title>
  </head>
  <body>
    <h1><a href="index.php">WEB</a></h1>
    <ol>
      <?php
        print_list();
       ?>
    </ol>
    <h2>
      <?php
        print_title();
      ?>
    </h2>
    <?php
      print_description();
     ?>
  </body>
</html>
