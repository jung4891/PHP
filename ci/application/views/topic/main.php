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

</div>
