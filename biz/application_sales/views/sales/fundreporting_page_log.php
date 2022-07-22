<?php
   include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/fundReporting.css">
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style media="screen">
.paging strong {
  color:#0575E6;
}
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

  } else {
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
  <?php
    include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
  ?>
  <div align="center">
    <div class="dash1-1">
      <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
        <tr>
          <td class="dash_title">접속로그</td>
        </tr>
        <tr>
          <td style="font-size:14px;vertical-align:middle">
            <form style="margin-top:75px;" id="logSearch" action="<?php echo site_url();?>/sales/fundreporting/logsearch?company=HIS_USER" method="post">
              <input type="text" id="" name="" value="접속기간" class="input-common" style="text-align:center;width:100px;" readonly>
              <input type="text" id="fromModify" name="fromModify" class="input-common" maxlength="19" placeholder="  연-월-일 시:분:초" onkeyup="auto_datetime_format(event, this); onlyNumHipenCol(this);" onkeypress="auto_datetime_format(event, this)" style="width:140px;">부터
              <input type="text" id="toModify" name="toModify" class="input-common" maxlength="19" placeholder="  연-월-일 시:분:초" onkeyup="auto_datetime_format(event, this); onlyNumHipenCol(this);" onkeypress="auto_datetime_format(event, this)" style="width:140px;">까지
              <input type="text" id="search1" name="search1" class="input-common" value="접속자" style="text-align:center;width:80px;" readonly>
              <select name="keyword1" id="keyword1" class="select-common select-style1" style="width:130px;">
                 <?php
                 foreach ($user as $user) {
                   echo '<option value = "'.$user->user_id.'">'.$user->user_name.'</option>';
                 }
                 echo '<option value selected disabled hidden>선택하세요</option>';
                 ?>
              </select>
              <input type="text" id="search2" name="search2" class="input-common" value="접속페이지" size="6" style="text-align:center;width:100px;" readonly>
              <select name="keyword2" id="keyword2" class="select-common select-style1" style="width:130px;">
                <option value = "DUIT">두리안정보기술</option>
                <option value = "DUICT">두리안정보통신기술</option>
                <option value = "MG">더망고</option>
                <option value = "DBS">두리안정보기술부산지점</option>
                <option value = "his_list">거래내역로그</option>
                <option value = "his_bank">은행관리로그</option>
                <option value = "his_user">접속로그</option>
                <option value selected disabled hidden>선택하세요</option>
              </select>
              <!-- <input class="btn-primary fundBtn" type="submit" id="search_btn" name="submit" value="검색" height="23"> -->
              <input class="btn-common btn-style2" type="submit" id="search_btn" name="submit" value="검색">
            </form>
          </td>
        </tr>
        <tr>
          <td>
            <div class="his-container" style="width:100%">
              <div id="hisTblHead">
                <table style="width:100%;border-top:none;margin-top:20px;" class="list_tbl list">
                  <colgroup>
                    <col style="width: 10%">
                    <col style="width: 20%">
                    <col style="width: 20%">
                    <col style="width: 15%">
                    <col style="width: 15%">
                  </colgroup>
                  <thead>
                    <tr height="40" bgcolor="" class="t_top his_top row-color1">
                      <td align="center">ID</td>
                      <td align="center">접속 시간</td>
                      <td align="center">접속 종료 시간</td>
                      <!-- <td align="center" class="t_border">접속 기간</td> -->
                      <td align="center">접속 페이지</td>
                      <td align="center">상태</td>

                    </tr>
                  </tdead>
                </table>
              </div>
              <div id="hisTbl">
                <table style="width:100%;" class="list_tbl list">
                  <colgroup>
                    <col style="width: 10%">
                    <col style="width: 20%">
                    <col style="width: 20%">
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
                                 <td height="30" align="center" class="hcell2"><?php echo $userId ?></td>
            										 <td height="30" align="center" class="hcell3"><?php echo $login_time ?></td>
                                 <td height="30" align="center" class="hcell4"><?php echo $logout_time ?></td>
                                 <!-- <td height="30" align="center" class="t_border hcell5" id='insLog'><?php echo $log_term ?></td> -->
                                                      <!-- <td height="30" align="center" class="t_border hcell5" id='insLog'></td> -->
                                 <td height="30" align="center" class="hcell5"><?php echo $page ?></td>
                                 <td height="30" align="center" class="hcell6"><?php echo $con ?></td>
                              </tr>
                    <?php
                      };
                    };
                    ?>
                  </tbody>
                </table>
              </div>
              <div align="center" class="paging" style="padding-top:20px;margin-top:10px;">
                  <?php echo $pagination;?>
              </div>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <!--하단-->
  <?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
  <!--하단-->
  <script type="text/javascript" src="/misc/js/fundReporting.js"></script>
</body>
