<div class="span10">
  <?php echo $msg; ?> <br><br>
  <?php
    // var_dump($res);
    foreach ($res as $row) {
      echo $row->name.' / '.$row->email.'<br>';
    }
  ?>
</div>
