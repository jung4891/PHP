<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
    body {
      font-family: sans-serif !important;
      font-size: 16px !important;
    }
    .doc_content2 span {
      font-family: sans-serif !important;
    }
    * {
      font-family: sans-serif !important;
    }
    .main {
      padding-top:20px;
      width: 100%;
      height: 100%;
    }
    .doc_title {
      text-align: center;
      font-weight: 600;
      font-size: 36px;
      height: 60pt;
    }
    .doc_content1 {
      padding-top: 10px;
      padding-bottom: 10px;
      border-top: black 3px solid;
      border-bottom: black 3px solid;
    }
    .doc_content1 p {
      font-size: 16px !important;
    }
    .doc_content2 {
      margin-top: 20px;
      font-size: 16px !important;
    }
    .doc_content2 p {
      line-height: 130% !important;
    }
    li {
      line-height: 130% !important;
    }
    .doc_content2 span {
      font-size: 16px !important;
    }
    .stamp {
      /* position: absolute; */
      text-align: center;
      font-size: 25px;
    }
    .txc-table {
      width: 96% !important;
      font-size: 16px !important;
    }
    .txc-table td {
      height: 20px !important;
    }
    .txc-table p {
      line-height: 0.5 !important;
    }
    </style>
  </head>
  <body>
    <div class="main">
      <div class="doc_title">
        <?php echo $view_val['doc_name']; ?>
      </div>
      <div class="doc_content1">
        <p>
          <?php
          if(isset($view_val['doc_num']) && $view_val['doc_num']!=''){
            echo '문서번호 : '.$view_val['doc_num'].substr_replace($view_val['doc_num2'], '-', 4, 0);
          }else{
            echo '문서번호 : 자동입력 (결재완료시 생성)';
          } ?>
        </p>
        <p>일&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;자 : <?php echo date('Y년 m월 d일', strtotime($view_val['doc_date'])); ?></p>
        <p>수&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;신 : <?php echo $view_val['to']; ?></p>
        <p>참&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;조 : <?php echo $view_val['cc']; ?></p>
        <p>발&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;신 : <?php echo $view_val['from']; ?></p>
        <p>제&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;목 : <span style="font-weight:600;"><?php echo $view_val['subject']; ?><span></p>
      </div>
      <div class="doc_content2">
        <?php echo $view_val['content']; ?>
      </div>
    </div>
  </body>
</html>
