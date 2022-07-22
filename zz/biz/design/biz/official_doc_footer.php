<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
    .main {
      text-align:center;
      border-bottom: thin black solid;
      padding-bottom: 30px;
    }
    .stamp {
      position: static;
      background:url('/misc/img/duit_stamp.png');
      background-size:127px;
      background-position: right bottom;
      background-repeat:no-repeat;
      padding-top:30px;
      padding-bottom:30px;
      padding-right:10px;
      padding-left:10px;
    }
    .footer {
      color: #B0B0B0;
      padding-top: 10px;
      font-size: 9pt;
    }
    </style>
  </head>
  <body>
    <div class="main">
      <!-- <div class="stamp">
        <p>(주)두리안정보기술</p>
        <p>대 표 이 사&nbsp;&nbsp;정 재 욱</p>
        <img style="position:absolute;width:40px;" src="/misc/img/duit_stamp.png">
      </div> -->
      <div class="<?php if(isset($view_val['approval_doc_status']) && $view_val['approval_doc_status'] == '002'){echo 'stamp';} ?>" style="font-size: 25pt;vertical-align: middle;width:340px;margin: 0 auto;">
        (주)두리안정보기술<br>
        대 표 이 사&nbsp;&nbsp;정 재 욱
      </div>
    </div>
    <div class="footer">
      <?php if($view_val['footer_text'] != '') {
        echo nl2br($view_val['footer_text']);
      } ?>
    </div>
  </body>
</html>
