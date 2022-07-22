<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>


<link rel="stylesheet" href="/misc/css/fundReporting.css">
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css">
<script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script>
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
  	$company = '?company=HIS_LIST';
  ?>
  <div align="center">
    <div class="dash1-1">
      <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
        <tr>
          <td class="dash_title">거래리스트로그</td>
        </tr>
        <tr>
          <td style="font-size:14px;vertical-align:middle">
            <form style="margin-top:75px;" id="fundSearch" action="<?php echo site_url();?>/sales/fundreporting/historysearch<?php echo $company;?>" method="post">
              <div class="" style="float:left">
                <select name="modifyType" id="modifyType" class="select-common select-style1" style="width:106px;">
                  <option value="">전체보기</option>
                  <option value="입력">입력</option>
                  <option value="수정">수정</option>
                  <option value="삭제">삭제</option>
                </select>
                <select name="company" id="company" class="select-common select-style1" style="width:106px;">
                  <option value="">전체회사</option>
                  <option value="DUIT">DUIT</option>
                  <option value="DUICT">DUICT</option>
                  <option value="MG">MG</option>
                  <option value="DBS">DBS</option>
                </select>
                <input type="text" id="" name="" value="수정시간" class="input-common" style="text-align:center;width:100px;margin-left:10px;" readonly>
                <input type="text" id="fromModify" name="fromModify" class="input-common" style="text-align:center;width:140px;" maxlength="19" placeholder="  연-월-일 시:분:초" onkeyup="auto_datetime_format(event, this); onlyNumHipenCol(this);" onkeypress="auto_datetime_format(event, this)">부터
                <input type="text" id="toModify" name="toModify" class="input-common" style="text-align:center;width:140px;" maxlength="19" placeholder="  연-월-일 시:분:초" onkeyup="auto_datetime_format(event, this); onlyNumHipenCol(this);" onkeypress="auto_datetime_format(event, this)">까지

                <select name="selectDate" id="selectDate" class="select-common select-style1" style="width:106px;margin-left:10px;">
                  <option value="dueDate">확정일</option>
                  <option value="fixedDate">예정일</option>
                  <option value="dateOfIssue">발행일</option>
                </select>
                <input type="text" id="fromDate" name="fromDate" class="input-common tInput_datepick" style="text-align:center;width:100px;"  autocomplete="off" maxlength="10" onkeyup="auto_date_format(event, this)" onkeypress="auto_date_format(event, this)">
                <input type="button" name="" id="fromBtn" class="dateBtn" value=" ">~
                <input type="text" id="toDate" name="toDate"  autocomplete="off" class="input-common tInput_datepick" style="text-align:center;width:100px;" maxlength="10" onkeyup="auto_date_format(event, this)" onkeypress="auto_date_format(event, this)">
                <input type="button" name="" id="toBtn" class="dateBtn" value=" ">
              </div>
              <div class="" style="float:left;">
                <select name="search1" id="search1" class="select-common select-style1" style="width:106px;">
                  <option value = "id">ID</option>
                  <option value = "type">대구분</option>
                  <option value = "customer">거래처</option>
                  <option value = "endUser">END-USER</option>
                  <option value = "bankType">은행구분</option>
                  <option value = "breakdown">내역</option>
                </select>
                <input type="text" id="keyword1" name="keyword1" value="" class="input-common" style="width:100px;">
                <select name="search2" id="search2" class="select-common select-style1" style="width:106px;margin-left:10px;">
                  <option value = "type">대구분</option>
                  <option value = "customer">거래처</option>
                  <option value = "endUser">END-USER</option>
                  <option value = "bankType">은행구분</option>
                  <option value = "breakdown">내역</option>
                  <option value = "id">ID</option>
                </select>
                <input type="text" id="keyword2" name="keyword2" value="" class="input-common" style="width:100px;">
                <input class="btn-common btn-style2" type="submit" id="search_btn" name="submit" value="검색">
              </div>
            </form>
          </td>
        </tr>
        <tr>
          <td>
            <div class="his-container" style="width:100%">
              <div id="hisTblHead">
                <table style="width:100%;border-top:none;margin-top:20px;" class="list_tbl">
                  <colgroup>
            				<col style="width: 2.9%">
                    <col style="width: 4.5%">
                    <col style="width: 4.5%">
                    <col style="width: 4.5%">
                    <col style="width: 3.9%">
                    <col style="width: 4.5%">
                    <col style="width: 11.7%">
                    <col style="width: 11.7%">
                    <col style="width: 18.2%">
                    <col style="width: 5.2%">
                    <col style="width: 5.2%">
                    <col style="width: 5.2%">
            				<col style="width: 3.2%">
                    <col style="width: 4.5%">
                    <col style="width: 9.7%">
                  </colgroup>
                  <thead>
                    <tr bgcolor="f8f8f9" class="t_top his_top row-color1">
                      <td align="center" class="log_modhcell1">구분</td>
                      <td align="center" class="log_modhcell2">발행일</td>
                      <td align="center" class="log_modhcell3">예정일</td>
                      <td align="center" class="log_modhcell4">확정일</td>
                      <td align="center" class="log_modhcell5">대구분</td>
                      <td align="center" class="log_modhcell6">은행구분</td>
                      <td align="center" class="log_modhcell7">거래처</td>
                      <td align="center" class="log_modhcell8">END-USER</td>
                      <td align="center" class="log_modhcell9">내역</td>
                      <td align="center" class="log_modhcell10">청구금액</td>
                      <td align="center" class="log_modhcell11">입금</td>
                      <td align="center" class="log_modhcell12">출금</td>
            					<td align="center" class="log_modhcell12">회사</td>
                      <td align="center" class="log_modhcell13">ID</td>
                      <td align="center" class="log_modhcell14">수정 시간</td>
                    </tr>
                  </tdead>
                </table>
              </div>
              <div id="hisTbl">
                <table style="width:100%" class="list_tbl">
                  <colgroup>
            				<col style="width: 2.9%">
                    <col style="width: 4.5%">
                    <col style="width: 4.5%">
                    <col style="width: 4.5%">
                    <col style="width: 3.9%">
                    <col style="width: 4.5%">
                    <col style="width: 11.7%">
                    <col style="width: 11.7%">
                    <col style="width: 18.2%">
                    <col style="width: 5.2%">
                    <col style="width: 5.2%">
                    <col style="width: 5.2%">
            				<col style="width: 3.2%">
                    <col style="width: 4.5%">
                    <col style="width: 9.7%">
                  </colgroup>
                  <tbody>
                    <?php
            				foreach ($list as $list) {
            					$requisition = number_format($list->requisition);
            					$deposit = number_format($list->deposit);
            					$withdraw = number_format($list->withdraw);
            					$newRequisition = number_format($list->new_requisition);
            					$newDeposit = number_format($list->new_deposit);
            					$newWithdraw = number_format($list->new_withdraw);
            					$company = $list->company;
            					if ($requisition == 0){
            						$requisition = '';
            					}
            					if ($deposit == 0){
            						$deposit = '';
            					}
            					if ($withdraw == 0){
            						$withdraw = '';
            					}
            					if ($newRequisition == 0){
            						$newRequisition = '';
            					}
            					if ($newDeposit == 0){
            						$newDeposit = '';
            					}
            					if ($newWithdraw == 0){
            						$newWithdraw = '';
            					}
            					if ($company == 'DBS'){
            						$company = 'DUITBS';
            					}

            					if ($list->modifyType == '입력'){ ?>
            						<tr>
            							<td height="30" align="center" class="hcell1 log_ins"><span style="font-weight:bold"><?php echo $list->modifyType ?></span></td>
            							<td height="30" align="center" class="hcell2"><?php echo $list->dateOfIssue ?></td>
            							<td height="30" align="center" class="hcell3"><?php echo $list->fixedDate ?></td>
            							<td height="30" align="center" class="hcell4"><?php echo $list->dueDate ?></td>
            							<td height="30" align="center" class="hcell5"><?php echo $list->TYPE ?></td>
            							<td height="30" align="center" class="hcell6"><?php echo $list->bankType ?></td>
            							<td height="30" align="center" class="hcell7"><?php echo $list->customer ?></td>
            							<td height="30" align="center" class="hcell8"><?php echo $list->endUser ?></td>
            							<td height="30" align="center" class="hcell9"><?php echo $list->breakdown ?></td>
            							<td height="30" align="center" class="hcell10" style="text-align:right;"><?php echo $requisition ?></td>
            							<td height="30" align="center" class="hcell11" style="text-align:right;"><?php echo $deposit ?></td>
            							<td height="30" align="center" class="hcell12" style="text-align:right;"><?php echo $withdraw ?></td>
            							<td height="30" align="center" class="hcell9"><?php echo $company ?></td>
            							<td height="30" align="center" class="hcell13"><?php echo $list->id ?></td>
            							<td height="30" align="center" class="hcell14"><?php echo $list->modifyDate ?></td>
            						</tr>
            					<?php
            				} ?>
            					<?php
            					if ($list->modifyType == '삭제'){ ?>
            						<tr>
            							<td height="30" align="center" class="hcell1 log_del"><span style="font-weight:bold"><?php echo $list->modifyType ?></span></td>
            							<td height="30" align="center" class="hcell2"><?php echo $list->dateOfIssue ?></td>
            							<td height="30" align="center" class="hcell3"><?php echo $list->fixedDate ?></td>
            							<td height="30" align="center" class="hcell4"><?php echo $list->dueDate ?></td>
            							<td height="30" align="center" class="hcell5"><?php echo $list->TYPE ?></td>
            							<td height="30" align="center" class="hcell6"><?php echo $list->bankType ?></td>
            							<td height="30" align="center" class="hcell7"><?php echo $list->customer ?></td>
            							<td height="30" align="center" class="hcell8"><?php echo $list->endUser ?></td>
            							<td height="30" align="center" class="hcell9"><?php echo $list->breakdown ?></td>
            							<td height="30" align="center" class="hcell10" style="text-align:right;"><?php echo $requisition ?></td>
            							<td height="30" align="center" class="hcell11" style="text-align:right;"><?php echo $deposit ?></td>
            							<td height="30" align="center" class="hcell12" style="text-align:right;"><?php echo $withdraw ?></td>
            							<td height="30" align="center" class="hcell9"><?php echo $company ?></td>
            							<td height="30" align="center" class="hcell13"><?php echo $list->id ?></td>
            							<td height="30" align="center" class="hcell14"><?php echo $list->modifyDate ?></td>
            						</tr>
            					<?php
            				} ?>
            				<?php
            					if ($list->modifyType == '수정'){ ?>
            						<tr>
            							<td align="center" class="hcell1 log_mod" rowspan="2"><span style="font-weight:bold"><?php echo $list->modifyType ?></span></td>
            							<td height="30" align="center" class="hcell2"><?php echo $list->dateOfIssue ?></td>
            							<td height="30" align="center" class="hcell3"><?php echo $list->fixedDate ?></td>
            							<td height="30" align="center" class="hcell4"><?php echo $list->dueDate ?></td>
            							<td height="30" align="center" class="hcell5"><?php echo $list->TYPE ?></td>
            							<td height="30" align="center" class="hcell6"><?php echo $list->bankType ?></td>
            							<td height="30" align="center" class="hcell7"><?php echo $list->customer ?></td>
            							<td height="30" align="center" class="hcell8"><?php echo $list->endUser ?></td>
            							<td height="30" align="center" class="hcell9"><?php echo $list->breakdown ?></td>
            							<td height="30" align="center" class="hcell10" style="text-align:right;"><?php echo $requisition ?></td>
            							<td height="30" align="center" class="hcell11" style="text-align:right;"><?php echo $deposit ?></td>
            							<td height="30" align="center" class="hcell12" style="text-align:right;"><?php echo $withdraw ?></td>
            							<td height="30" align="center" class="hcell9"><?php echo $company ?></td>
            							<td height="30" align="center" class="hcell13"><?php echo $list->id ?></td>
            							<td height="30" align="center" class="hcell14"><?php echo $list->insertDate ?></td>
            						</tr>
            						<tr>
            							<td height="30" align="center" class="hcell2<?php if($list->dateOfIssue != $list->new_dateOfIssue){echo ' log_mod';} ?>"><?php echo $list->new_dateOfIssue ?></td>
            							<td height="30" align="center" class="hcell3<?php if($list->fixedDate != $list->new_fixedDate){echo ' log_mod';} ?>"><?php echo $list->new_fixedDate ?></td>
            							<td height="30" align="center" class="hcell4<?php if($list->dueDate != $list->new_dueDate){echo ' log_mod';} ?>"><?php echo $list->new_dueDate ?></td>
            							<td height="30" align="center" class="hcell5<?php if($list->TYPE != $list->new_type){echo ' log_mod';} ?>"><?php echo $list->new_type ?></td>
            							<td height="30" align="center" class="hcell6<?php if($list->bankType != $list->new_bankType){echo ' log_mod';} ?>"><?php echo $list->new_bankType ?></td>
            							<td height="30" align="center" class="hcell7<?php if($list->customer != $list->new_customer){echo ' log_mod';} ?>"><?php echo $list->new_customer ?></td>
            							<td height="30" align="center" class="hcell8<?php if($list->endUser != $list->new_endUser){echo ' log_mod';} ?>"><?php echo $list->new_endUser ?></td>
            							<td height="30" align="center" class="hcell9<?php if($list->breakdown != $list->new_breakdown){echo ' log_mod';} ?>"><?php echo $list->new_breakdown ?></td>
            							<td height="30" align="center" class="hcell10<?php if($requisition != $newRequisition){echo ' log_mod';} ?>" style="text-align:right;"><?php echo $newRequisition ?></td>
            							<td height="30" align="center" class="hcell11<?php if($deposit != $newDeposit){echo ' log_mod';} ?>" style="text-align:right;"><?php echo $newDeposit ?></td>
            							<td height="30" align="center" class="hcell12<?php if($withdraw != $newWithdraw){echo ' log_mod';} ?>" style="text-align:right;"><?php echo $newWithdraw ?></td>
            							<td height="30" align="center" class="hcell13"><?php echo $company ?></td>
            							<td height="30" align="center" class="hcell13"><?php echo $list->new_id ?></td>
            							<td height="30" align="center" class="hcell14"><?php echo $list->modifyDate ?></td>
            						</tr>
            					<?php
            				} ?>
            				<?php } ?>
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
<script type="text/javascript">
$(function(){
  $("#fromDate, #toDate").datepicker();

});
</script>
