<?php
   include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="/misc/css/fundReporting.css">
  </head>
  <style type="text/css">

  </style>

<script type="text/javascript">
var sl = 0;
$(function() {
            $.fn.hasYScrollBar = function() {
                return (this.prop("scrollHeight") == 0 && this.prop("clientHeight") == 0) || (this.prop("scrollHeight") > this.prop("clientHeight"));
            };
            $.fn.hasXScrollBar = function() {
                return (this.prop("scrollWidth") == 0 && this.prop("clientWidth") == 0) || (this.prop("scrollWidth") > this.prop("clientWidth"));
            };
                  // 변경
            $("#hisTbl").scroll(function(event) { // data 테이블 x축 스크롤을 움직일 때header 테이블 x축 스크롤을 똑같이 움직인다
                     if (sl != $("#hisTbl").scrollLeft()) {
                        sl = $("#hisTbl").scrollLeft();
                        $("#hisTblHead").scrollLeft(sl);
                     }
                  });

                  var agent = navigator.userAgent.toLowerCase();

                     if ( (navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ) {

                       if ($("#hisTbl").hasYScrollBar()) { // 변경
       									//y축 스크롤이 있으면 스크롤 넓이인 17px만큼 header 마지막 열 크기를 늘린다
       									$("#hisTblHead colgroup col:last-child").width($("#hisTbl colgroup col:last-child").width() + 100px);
       								} else {
       									$("#hisTblHead colgroup col:last-child").width($("#hisTbl colgroup col:last-child").width());
       								}

       							}

       							else {

       								if ($("#hisTbl").hasYScrollBar()) {
       									//y축 스크롤이 있으면 스크롤 넓이인 17px만큼 header 마지막 열 크기를 늘린다
       									$("#hisTblHead colgroup col:last-child").width($("#hisTbl colgroup col:last-child").width() + 50px);
       								} else {
       									$("#hisTblHead colgroup col:last-child").width($("#hisTbl colgroup col:last-child").width());
                        }

                     }


               });
</script>

<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
  <tr width="100%">
    <td align="center" valign="top">
      <div class="content" style="margin-left:10px; margin-right:10px; margin-top:30px;">
    <!-- 여기여기 -->
    <div style="margin-bottom:30px;">
     <form id="logSearch" action="<?php echo site_url();?>/fundreporting/logsearch?company=HIS_USER" method="post">
  <input type="text" id="" name="" value="접속기간" size="4" style="text-align:center;" readonly>
        <input type="text" id="fromModify" name="fromModify" size="15" maxlength="19" placeholder="  연-월-일 시:분:초" onkeyup="auto_datetime_format(event, this); onlyNumHipenCol(this);" onkeypress="auto_datetime_format(event, this)">부터
  <input type="text" id="toModify" name="toModify" size="15" maxlength="19" placeholder="  연-월-일 시:분:초" onkeyup="auto_datetime_format(event, this); onlyNumHipenCol(this);" onkeypress="auto_datetime_format(event, this)">까지
  &nbsp&nbsp&nbsp&nbsp&nbsp

  <input type="text" id="search1" name="search1" value="접속자" size="6" style="text-align:center;" readonly>
  <select name="keyword1" id="keyword1">
    <?php
    foreach ($user as $user) {
      echo '<option value = "'.$user->user_id.'">'.$user->user_name.'</option>';
    }
    echo '<option value selected disabled hidden>선택하세요</option>';
    ?>
  </select>

  <input type="text" id="search2" name="search2" value="접속페이지" size="6" style="text-align:center;" readonly>
    <select name="keyword2" id="keyword2">
      <option value = "DUIT">두리안정보기술</option>
      <option value = "DUICT">두리안정보통신기술</option>
      <option value = "MG">더망고</option>
      <option value = "DBS">두리안정보기술부산지점</option>
      <option value = "his_list">거래내역로그</option>
      <option value = "his_bank">은행관리로그</option>
      <option value = "his_user">접속로그</option>
      <option value selected disabled hidden>선택하세요</option>
  </select>

     <input class="btn-primary" type="submit" id="search_btn" name="submit" value="검색">
     </form>

  <div>
    <div class="his-container" style="width:90%">
         <div id="hisTblHead">
    <table style="width:100%;">
      <colgroup>
        <col style="width: 10%">
        <col style="width: 20%">
        <col style="width: 20%">
        <!-- <col style="width: 20%"> -->
        <col style="width: 15%">
        <col style="width: 15%">
      </colgroup>
      <thead>
        <tr bgcolor="f8f8f9" class="t_top his_top">
          <td align="center" class="t_border">ID</td>
          <td align="center" class="t_border">접속 시간</td>
          <td align="center" class="t_border">접속 종료 시간</td>
          <!-- <td align="center" class="t_border">접속 기간</td> -->
          <td align="center" class="t_border">접속 페이지</td>
          <td align="center" class="t_border">상태</td>

        </tr>
      </tdead>
      </table>
   </div>
   <div id="hisTbl">
      <table style="width:100%;">
         <colgroup>
           <col style="width: 10%">
           <col style="width: 20%">
           <col style="width: 20%">
           <!-- <col style="width: 20%"> -->
           <col style="width: 15%">
           <col style="width: 15%">
      </colgroup>
      <tbody>
        <?php
				if(!empty($pagelog)){
            foreach ($pagelog as $pagelog) {

               $userId = $pagelog->id;
							 $login_time = $pagelog->login_time;
							 $logout_time = $pagelog->logout_time;
               // $$log_term = $pagelog->$log_term;
							 $page = $pagelog->page;
							 $con = $pagelog->con;

               // if ($page == 'DBS'){
               //    $page = 'DUITBS';
               // }
               if ($page == 'DUIT'){
                  $page = '두리안정보기술';
               }
               if ($page == 'DUICT'){
                  $page = '두리안정보통신기술';
               }
               if ($page == 'MG'){
                  $page = '더망고';
               }
               if ($page == 'DBS'){
                  $page = '두리안정보기술부산지점';
               }
               if ($page == 'HIS_LIST'){
                  $page = '거래내역로그';
               }
               if ($page == 'HIS_BANK'){
                  $page = '은행관리로그';
               }
               if ($page == 'HIS_USER'){
                  $page = '페이지접속로그';
               }
               ?>
                  <tr>
                     <!-- <td height="30" align="center" class="t_border hcell1" id='insLog'><span style="color:#39acff"><?php echo $cud ?></span></td> -->
                     <td height="30" align="center" class="t_border hcell2" id='insLog'><?php echo $userId ?></td>
										 <td height="30" align="center" class="t_border hcell3" id='insLog'><?php echo $login_time ?></td>
                     <td height="30" align="center" class="t_border hcell4" id='insLog'><?php echo $logout_time ?></td>
                     <!-- <td height="30" align="center" class="t_border hcell5" id='insLog'><?php echo $log_term ?></td> -->
                                          <!-- <td height="30" align="center" class="t_border hcell5" id='insLog'></td> -->
                     <td height="30" align="center" class="t_border hcell5" id='insLog'><?php echo $page ?></td>
                     <td height="30" align="center" class="t_border hcell6" id='insLog'><?php echo $con ?></td>
                  </tr>
        <?php
          };
        };
        ?>
      </tbody>
    </table>
</div>
<div>
      <?php echo $pagination;?>
</div>
    <!-- 여기여기끝 -->
  </div>
    </td>
  </tr>
  <!--하단-->
  <tr>
     <td align="center" height="100" bgcolor="#CCCCCC"><table width="1130" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img src="<?php echo $misc;?>img/f_ci.png"/></td>
        <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?></td>
      </tr>
    </table></td>
  </tr>
  <!--하단-->
</table>
<script type="text/javascript" src="/misc/js/fundReporting.js"></script>
</body>
</html>