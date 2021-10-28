<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Upload Form</title>
  </head>
  <body>

    <h3>Your file was successfully uploaded!</h3>

    <ul>
      <?php foreach($upload_data as $item => $value):?>
      <li><?php echo $item;?>: <?php echo $value;?></li>
      <?php endforeach; ?>
    </ul>

    <p><?php echo anchor('file/upload', 'Upload Another File!'); ?></p> 
  </body>
</html>
