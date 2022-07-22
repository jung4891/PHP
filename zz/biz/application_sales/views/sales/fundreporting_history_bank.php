<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/fundReporting.css">
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style media="screen">
  .log_ins{
    color:#007BCB;
    background-color: #F2FCFF;
  }
  .log_del{
    color:#E53737;
    background-color: #FFEDED;
  }
  .log_mod{
    background-color: #FFFFF2;
  }
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
  $company = "?company=HIS_BANK";
?>
<div align="center">
  <div class="dash1-1">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
      <tr>
        <td class="dash_title">은행관리로그</td>
      </tr>
      <tr>
        <td style="font-size:14px;vertical-align:middle">
          <form style="margin-top:75px;" id="fundSearch" action="<?php echo site_url();?>/sales/fundreporting/banksearch<?php echo $company;?>" method="post">
            <select name="cud" id="cud" class="select-common select-style1" style="width:100px;">
              <option value="">전체보기</option>
              <option value="insert">입력</option>
              <option value="update">수정</option>
              <option value="delete">삭제</option>
            </select>
            <select name="old_company" id="old_company" class="select-common select-style1" style="width:100px;">
              <option value="">전체회사</option>
              <option value="DUIT">DUIT</option>
              <option value="DUICT">DUICT</option>
              <option value="MG">MG</option>
              <option value="DBS">DBS</option>
            </select>
            <input type="text" id="" name="" value="수정시간" class="input-common" style="text-align:center;width:100px;" readonly>
            <input type="text" id="fromModify" name="fromModify" class="input-common" maxlength="19" placeholder="  연-월-일 시:분:초" onkeyup="auto_datetime_format(event, this); onlyNumHipenCol(this);" onkeypress="auto_datetime_format(event, this)" style="width:140px;">부터
            <input type="text" id="toModify" name="toModify" maxlength="19" placeholder="  연-월-일 시:분:초" class="input-common" onkeyup="auto_datetime_format(event, this); onlyNumHipenCol(this);" onkeypress="auto_datetime_format(event, this)" style="width:140px;">까지

            <select name="search1" id="search1" class="select-common select-style1" style="width:100px;">
              <option value = "id">ID</option>
              <option value = "type">예금종류</option>
              <option value = "bank">은행</option>
              <option value = "banktype">은행구분</option>
              <option value = "account">계좌번호</option>
              <option value = "breakdown">내역</option>
            </select>
            <input type="text" id="keyword1" name="keyword1" value="" class="input-common" style="width:100px;">
            <select name="search2" id="search2" class="select-common select-style1" style="width:100px;">
              <option value = "type">예금종류</option>
              <option value = "bank">은행</option>
              <option value = "banktype">은행구분</option>
              <option value = "account">계좌번호</option>
              <option value = "breakdown">내역</option>
              <option value = "id">ID</option>
            </select>
            <input type="text" id="keyword2" name="keyword2" value="" class="input-common" style="width:250px;">
            <input class="btn-common btn-style2" type="submit" id="search_btn" name="submit" value="검색">
          </form>
        </td>
      </tr>
      <tr>
        <td>
          <div class="his-container" style="width:100%">
            <div id="hisTblHead">
              <table style="width:100%;border-top:none;margin-top:20px;" class="list_tbl">
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
                  <tr height="40" bgcolor="" class="t_top his_top row-color1">
          					<td align="center">구분</td>
                    <td align="center">예금 종류</td>
                    <td align="center">은행</td>
                    <td align="center">은행 구분</td>
                    <td align="center">계좌 번호</td>
                    <td align="center">내역</td>
          					<td align="center">금액</td>
      							<td align="center">회사</td>
                    <td align="center">수정한 ID</td>
                    <td align="center">수정 시간</td>
                  </tr>
                </tdead>
              </table>
            </div>
            <div id="hisTbl">
               <table style="width:100%;" class="list_tbl">
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
                              <td height="30" align="center" class="hcell1 log_ins"><span style="font-weight:bold"><?php echo $cud ?></span></td>
                              <td height="30" align="center" class="hcell2"><?php echo $hisbankbook->new_type ?></td>
         										 <td height="30" align="center" class="hcell3"><?php echo $hisbankbook->new_bank ?></td>
                              <td height="30" align="center" class="hcell4"><?php echo $hisbankbook->new_banktype ?></td>
                              <td height="30" align="center" class="hcell5"><?php echo $hisbankbook->new_account ?></td>
                              <td height="30" align="center" class="hcell6"><?php echo $hisbankbook->new_breakdown ?></td>
                              <td height="30" align="center" class="hcell7" style="text-align:right;"><?php echo $new_balance ?></td>
                              <td height="30" align="center" class="hcell8"><?php echo $company?></td>
                              <td height="30" align="center" class="hcell9"><?php echo $hisbankbook->new_id ?></td>
                              <td height="30" align="center" class="hcell10"><?php echo $insertdate ?></td>
                           </tr>
                        <?php
                     } ?>
                        <?php
                        if ($cud == '삭제'){ ?>
                           <tr>
                              <td height="30" align="center" class="hcell1 log_del"><span style="font-weight:bold"><?php echo $cud ?></span></td>
                              <td height="30" align="center" class="hcell2"><?php echo $hisbankbook->old_type ?></td>
                              <td height="30" align="center" class="hcell3"><?php echo $hisbankbook->old_bank ?></td>
                              <td height="30" align="center" class="hcell4"><?php echo $hisbankbook->old_banktype ?></td>
                              <td height="30" align="center" class="hcell5"><?php echo $hisbankbook->old_account ?></td>
                              <td height="30" align="center" class="hcell6"><?php echo $hisbankbook->old_breakdown ?></td>
                              <td height="30" align="center" class="hcell10" style="text-align:right;"><?php echo $old_balance ?></td>
                              <td height="30" align="center" class="hcell9"><?php echo $company ?></td>
                              <td height="30" align="center" class="hcell13"><?php echo $hisbankbook->new_id ?></td>
                              <td height="30" align="center" class="hcell14"><?php echo $old_modifydate ?></td>
                           </tr>
                        <?php
                     } ?>
                     <?php
                        if ($cud == '수정'){ ?>
                           <tr>
                              <td align="center" class="hcell1 log_mod" rowspan="2"><span style="font-weight:bold"><?php echo $cud ?></span></td>
                              <td height="30" align="center" class="hcell2"><?php echo $hisbankbook->old_type ?></td>
         										 <td height="30" align="center" class="hcell3"><?php echo $hisbankbook->old_bank ?></td>
                              <td height="30" align="center" class="hcell4"><?php echo $hisbankbook->old_banktype ?></td>
                              <td height="30" align="center" class="hcell5"><?php echo $hisbankbook->old_account ?></td>
                              <td height="30" align="center" class="hcell6"><?php echo $hisbankbook->old_breakdown ?></td>
                              <td height="30" align="center" class="hcell7" style="text-align:right;"><?php echo $old_balance ?></td>
                              <td height="30" align="center" class="hcell8"><?php echo $company ?></td>
                              <td height="30" align="center" class="hcell9"><?php echo $hisbankbook->old_id ?></td>
                              <td height="30" align="center" class="hcell10"><?php echo $old_modifydate ?></td>
                           </tr>
                           <tr>
                              <td height="30" align="center" class="hcell2 <?php if($hisbankbook->old_type != $hisbankbook->new_type){echo ' log_mod';} ?>"><?php echo $hisbankbook->new_type ?></td>
                              <td height="30" align="center" class="hcell3 <?php if($hisbankbook->old_bank != $hisbankbook->new_bank){echo 'log_mod';} ?>"><?php echo $hisbankbook->new_bank ?></td>
                              <td height="30" align="center" class="hcell4 <?php if($hisbankbook->old_banktype != $hisbankbook->new_banktype){echo 'log_mod';} ?>"><?php echo $hisbankbook->new_banktype ?></td>
                              <td height="30" align="center" class="hcell5 <?php if($hisbankbook->old_account != $hisbankbook->new_account){echo 'log_mod';} ?>"><?php echo $hisbankbook->new_account ?></td>
                              <td height="30" align="center" class="hcell6 <?php if($hisbankbook->old_breakdown != $hisbankbook->new_breakdown){echo 'log_mod';} ?>"><?php echo $hisbankbook->new_breakdown ?></td>
         											 <td height="30" align="center" class="hcell7 <?php if($old_balance != $new_balance){echo 'log_mod';} ?>" style="text-align:right;"><?php echo $new_balance ?></td>
                              <td height="30" align="center" class="hcell8"><?php echo $company ?></td>
                              <td height="30" align="center" class="hcell9"><?php echo $hisbankbook->new_id ?></td>
                              <td height="30" align="center" class="hcell10"><?php echo $insertdate ?></td>
                           </tr>
                        <?php
                     } ?>
                     <?php }
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
