<div class="span10">
  <?php echo $msg; ?> <br><br>
  <p>
  <?php
    if (isset($res)) {
      // var_dump($res);
      foreach ($res as $row) {
        echo $row->name.' / '.$row->email.'<br>';
      }
      echo "</p><p style=\"letter-spacing:7px;\">{$links}</p>";
    }
  ?>
  <p>Page rendered in <strong>{elapsed_time}</strong> seconds</p>

  <p><?php echo $js_test; ?></p>

  <?php $a = 'aaa'; ?>

  <?php
  echo
  "
  <script src='https://code.jquery.com/jquery-1.12.4.js'></script>
  <script type='text/javascript'>
    $(function() {
      var test = '$js_test';
      alert(test);
    })
  </script>
  ";


   ?>
</div>
<!-- 왜 제이쿼리 선언을 헤더나 푸터에 하고 본 페이지는 안하면 안되지? -->
<!-- 그리고 저 위에 스크립트 문을 아래로 내리면 아예 안됨. 서버스크립트언어라서 같이 보내줘야 하는듯? -->
