<!DOCTYPE html>
<html lang = "kr" >
<head>
<meta charset = "utf-8" >
<title> 테스트페이지 </title>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</head>
<body>
  <?php

    echo '$_SERVER["DOCUMENT_ROOT"] -> '.$_SERVER['DOCUMENT_ROOT'];   // C:/xampp/htdocs/php
    echo '<br>';
    echo '$_SERVER[ "PHP_SELF" ] -> '.$_SERVER['PHP_SELF'];   // /5. CRUD/$_POST.php
    echo '<br><br>';

    // action 경로가 이 페이지일 경우
    if ($_POST) {
      $testDate = $_POST [ "testDate" ];
      echo $testDate ;
    }
  ?>

  <!-- <form method = "POST" action = "<?php echo $_SERVER [ 'PHP_SELF' ]; // action=""과 동일?>" >    -->
  <form method = "POST" action = "test.php" >
    <input type = "date" name = "testDate">
    <!-- <input type = "date" name = "testDate" value =<?php echo $testDate ?> > -->
    <input type = "submit" value = "전송" />
  </form> <br><br>

  <button type="button" onclick="dynamic_form()">동적 form</button>


  <script type="text/javascript">

  // 동적 form
  // 문서 내에 form태그 없이 동적으로 생성하여 submit이 가능함
  function dynamic_form() {
      var newForm = $('<form></form>');
      // newForm.attr("name","newForm");
      newForm.attr("method","post");
      newForm.attr("action", "test.php");
      // newForm.attr("target","_blank");   // 새창으로 열림

      newForm.append($('<input>', {type: 'hidden', name: 'data1', value:'히히' }));
      newForm.append($('<input>', {type: 'hidden', name: 'data2', value:'value2' }));

      newForm.appendTo('body');
      newForm.submit();
  }
  </script>
</body>
</html>
