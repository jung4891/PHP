<?php
  echo "<p>제목 : ".$_GET['title']."</p>";
  echo "<p>내용 : ".$_GET['description']."</p>";

  file_put_contents('../data/'.$_GET['title'], $_GET['description']);
 ?>
