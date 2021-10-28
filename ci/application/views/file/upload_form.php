<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Upload Form</title>
  </head>
  <body>
    <?php echo $error;?>
    <!-- 파일업로드는 multipart form을 필요로 하므로 form 헬퍼는 적당한 태그를 자동으로 작성해줍니다. -->
    <!-- 'file/do_upload' -> 자동으로 만들어지는 form의 action속성값에 들어가게됨. -->
    <!-- action 경로가 index.php가 두개로 나와서 그냥 수동설정 -->
    <!-- <?php // echo form_open_multipart('do_upload');?> -->
    <form action="/index.php/file/do_upload" enctype="multipart/form-data" method="post" accept-charset="utf-8">
      <input type="file" name="userfile" size="">
      <!-- size는 뭐지?? 원래는 20 있었음 -->
      <br><br>
      <input type="submit" value="업로드">
    </form>
  </body>
</html>
