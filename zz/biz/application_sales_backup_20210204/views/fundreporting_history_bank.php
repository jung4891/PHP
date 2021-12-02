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
  $company = "?company=HIS_BANK";
?>
  <tr width="100%">
    <td align="center" valign="top">
      <div class="content" style="margin-left:10px; margin-right:10px; margin-top:30px;">
    <!-- 여기여기 -->
    <div style="margin-bottom:30px;">
      <!-- <button type="button" style="float: left; margin-left:95px;" onclick="location.href='<?php echo site_url()?>/fundreporting/fundreporting_history?company=HIS_LIST'">예금내역 로그</button> -->
     <form id="fundSearch" action="<?php echo site_url();?>/fundreporting/banksearch<?php echo $company;?>" method="post">
        <select name="cud" id="cud">
           <option value="">전체보기</option>
           <option value="insert">입력</option>
           <option value="update">수정</option>
           <option value="delete">삭제</option>
   </select>
  <select name="old_company" id="old_company">
    <option value="">전체회사</option>
    <option value="DUIT">DUIT</option>
    <option value="DUICT">DUICT</option>
    <option value="MG">MG</option>
    <option value="DBS">DBS</option>
  </select>
        <input type="text" id="" name="" value="수정시간" size="4" readonly>
              <input type="text" id="fromModify" name="fromModify" size="15" maxlength="19" placeholder="  연-월-일 시:분:초" onkeyup="auto_datetime_format(event, this); onlyNumHipenCol(this);" onkeypress="auto_datetime_format(event, this)">부터
        <input type="text" id="toModify" name="toModify" size="15" maxlength="19" placeholder="  연-월-일 시:분:초" onkeyup="auto_datetime_format(event, this); onlyNumHipenCol(this);" onkeypress="auto_datetime_format(event, this)">까지

    <select name="search1" id="search1" >
        <option value = "id">ID</option>
        <option value = "type">예금종류</option>
        <option value = "bank">은행</option>
        <option value = "banktype">은행구분</option>
        <option value = "account">계좌번호</option>
        <option value = "breakdown">내역</option>
  </select>
    <input type="text" id="keyword1" name="keyword1" value="" size="8">
    <select name="search2" id="search2">
      <option value = "type">예금종류</option>
      <option value = "bank">은행</option>
      <option value = "banktype">은행구분</option>
      <option value = "account">계좌번호</option>
      <option value = "breakdown">내역</option>
      <option value = "id">ID</option>
  </select>
    <input type="text" id="keyword2" name="keyword2" value="" size="8">
     <input class="btn-primary" type="submit" id="search_btn" name="submit" value="검색">
     </form>

  <div>
    <div class="his-container" style="width:90%">
         <div id="hisTblHead">
    <table style="width:100%;">
      <colgroup>
				<col style="width: 3.8%">
        <col style="width: 6%">
        <col style="width: 6%">
        <col style="width: 6%">
        <col style="width: 12.9%">
				<col style="width: 24.2%">
        <col style="width: 15.5%">
        <col style="width: 6%">
        <col style="width: 6%">
        <col style="width: 12.9%">
      </colgroup>
      <thead>
        <tr bgcolor="f8f8f9" class="t_top his_top">
					<td align="center" class="t_border">구분</td>
          <td align="center" class="t_border">예금 종류</td>
          <td align="center" class="t_border">은행</td>
          <td align="center" class="t_border">은행 구분</td>
          <td align="center" class="t_border">계좌 번호</td>
          <td align="center" class="t_border">내역</td>
					<td align="center" class="t_border">금액</td>
							<td align="center" class="t_border">회사</td>
          <td align="center" class="t_border">수정한 ID</td>
          <td align="center" class="t_border">수정 시간</td>

        </tr>
      </tdead>
      </table>
   </div>
   <div id="hisTbl">
      <table style="width:100%;">
         <colgroup>
           <col style="width: 3.8%">
           <col style="width: 6%">
           <col style="width: 6%">
           <col style="width: 6%">
           <col style="width: 12.9%">
   				<col style="width: 24.2%">
           <col style="width: 15.5%">
           <col style="width: 6%">
           <col style="width: 6%">
           <col style="width: 12.9%">
      </colgroup>
      <tbody>
        <?php
				if(!empty($hisbankbook)){
            foreach ($hisbankbook as $hisbankbook) {

							 $insertdate = $hisbankbook->insertdate;
							 $old_modifydate = $hisbankbook->old_modifydate;
               $old_balance = number_format($hisbankbook->old_balance);
							 $new_balance = number_format($hisbankbook->new_balance);
							 $cud = $hisbankbook->cud;
               $company = $hisbankbook->old_company;
               if ($old_balance == 0){
                  $old_balance = '';
               }
               if ($new_balance == 0){
                  $new_balance = '';
               }
               if ($company == 'DBS'){
                  $company = 'DUITBS';
               }
							 if($cud == 'insert'){
								 $cud = '입력';
							 }
							 if($cud == 'update'){
								 $cud = '수정';
							 }
							 if($cud == 'delete'){
								 $cud = '삭제';
							 }

               if ($cud == '입력'){ ?>
                  <tr>
                     <td height="30" align="center" class="t_border hcell1" id='insLog'><span style="color:#39acff"><?php echo $cud ?></span></td>
                     <td height="30" align="center" class="t_border hcell2" id='insLog'><?php echo $hisbankbook->new_type ?></td>
										 <td height="30" align="center" class="t_border hcell3" id='insLog'><?php echo $hisbankbook->new_bank ?></td>
                     <td height="30" align="center" class="t_border hcell4" id='insLog'><?php echo $hisbankbook->new_banktype ?></td>
                     <td height="30" align="center" class="t_border hcell5" id='insLog'><?php echo $hisbankbook->new_account ?></td>
                     <td height="30" align="center" class="t_border hcell6" id='insLog'><?php echo $hisbankbook->new_breakdown ?></td>
                     <td height="30" align="center" class="t_border hcell7" id='insLog' style="text-align:right;"><?php echo $new_balance ?></td>
                     <td height="30" align="center" class="t_border hcell8" id='insLog'><?php echo $company?></td>
                     <td height="30" align="center" class="t_border hcell9" id='insLog'><?php echo $hisbankbook->new_id ?></td>
                     <td height="30" align="center" class="t_border hcell10" id='insLog'><?php echo $insertdate ?></td>
                  </tr>
               <?php
            } ?>
               <?php
               if ($cud == '삭제'){ ?>
                  <tr>
                     <td height="30" align="center" class="t_border hcell1" id='delLog'><span style="color:#f95b5b"><?php echo $cud ?></span></td>
                     <td height="30" align="center" class="t_border hcell2" id='delLog'><?php echo $hisbankbook->old_type ?></td>
                     <td height="30" align="center" class="t_border hcell3" id='delLog'><?php echo $hisbankbook->old_bank ?></td>
                     <td height="30" align="center" class="t_border hcell4" id='delLog'><?php echo $hisbankbook->old_banktype ?></td>
                     <td height="30" align="center" class="t_border hcell5" id='delLog'><?php echo $hisbankbook->old_account ?></td>
                     <td height="30" align="center" class="t_border hcell6" id='delLog'><?php echo $hisbankbook->old_breakdown ?></td>
                     <td height="30" align="center" class="t_border hcell10" id='delLog' style="text-align:right;"><?php echo $old_balance ?></td>
                     <td height="30" align="center" class="t_border hcell9" id='delLog'><?php echo $company ?></td>
                     <td height="30" align="center" class="t_border hcell13" id='delLog'><?php echo $hisbankbook->new_id ?></td>
                     <td height="30" align="center" class="t_border hcell14" id='delLog'><?php echo $old_modifydate ?></td>
                  </tr>
               <?php
            } ?>
            <?php
               if ($cud == '수정'){ ?>
                  <tr>
                     <td align="center" class="t_border hcell1" rowspan="2" id='modLog'><span style="color:#85ff3b"><?php echo $cud ?></span></td>
                     <td height="30" align="center" class="t_border hcell2" style="background-color:#d4d0d0"><?php echo $hisbankbook->old_type ?></td>
										 <td height="30" align="center" class="t_border hcell3" style="background-color:#d4d0d0"><?php echo $hisbankbook->old_bank ?></td>
                     <td height="30" align="center" class="t_border hcell4" style="background-color:#d4d0d0"><?php echo $hisbankbook->old_banktype ?></td>
                     <td height="30" align="center" class="t_border hcell5" style="background-color:#d4d0d0"><?php echo $hisbankbook->old_account ?></td>
                     <td height="30" align="center" class="t_border hcell6" style="background-color:#d4d0d0"><?php echo $hisbankbook->old_breakdown ?></td>
                     <td height="30" align="center" class="t_border hcell7" style="background-color:#d4d0d0; text-align:right;"><?php echo $old_balance ?></td>
                     <td height="30" align="center" class="t_border hcell8" style="background-color:#d4d0d0"><?php echo $company ?></td>
                     <td height="30" align="center" class="t_border hcell9" style="background-color:#d4d0d0"><?php echo $hisbankbook->old_id ?></td>
                     <td height="30" align="center" class="t_border hcell10" style="background-color:#d4d0d0"><?php echo $old_modifydate ?></td>
                  </tr>
                  <tr>
                     <td height="30" align="center" class="t_border hcell2" id='modLog'<?php if($hisbankbook->old_type != $hisbankbook->new_type){echo 'style="background-color:#facdcd"';} ?>><?php echo $hisbankbook->new_type ?></td>
                     <td height="30" align="center" class="t_border hcell3" id='modLog'<?php if($hisbankbook->old_bank != $hisbankbook->new_bank){echo 'style="background-color:#facdcd"';} ?>><?php echo $hisbankbook->new_bank ?></td>
                     <td height="30" align="center" class="t_border hcell4" id='modLog'<?php if($hisbankbook->old_banktype != $hisbankbook->new_banktype){echo 'style="background-color:#facdcd"';} ?>><?php echo $hisbankbook->new_banktype ?></td>
                     <td height="30" align="center" class="t_border hcell5" id='modLog'<?php if($hisbankbook->old_account != $hisbankbook->new_account){echo 'style="background-color:#facdcd"';} ?>><?php echo $hisbankbook->new_account ?></td>
                     <td height="30" align="center" class="t_border hcell6" id='modLog'<?php if($hisbankbook->old_breakdown != $hisbankbook->new_breakdown){echo 'style="background-color:#facdcd"';} ?>><?php echo $hisbankbook->new_breakdown ?></td>
											 <td height="30" align="center" class="t_border hcell7" style="text-align:right;<?php if($old_balance != $new_balance){echo 'background-color:#facdcd;';} ?>" id='modLog'><?php echo $new_balance ?></td>
                     <td height="30" align="center" class="t_border hcell8" id='modLog'><?php echo $company ?></td>
                     <td height="30" align="center" class="t_border hcell9" id='modLog'><?php echo $hisbankbook->new_id ?></td>
                     <td height="30" align="center" class="t_border hcell10" id='modLog'><?php echo $insertdate ?></td>
                  </tr>
               <?php
            } ?>
            <?php }
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