
<?php

  echo 'post.php 페이지 입니다.<br><br>';

  // $msg = $this->input->get('fruit');     // 이건 코드이그나이터....

  // $msg = $_GET['fruit'];
  $msg = $_POST['message'];

  echo $msg;
 ?>
