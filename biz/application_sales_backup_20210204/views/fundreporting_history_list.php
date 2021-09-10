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
	<link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css">
	<script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script>
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
	$company = '?company=HIS_LIST';
?>
  <tr width="100%">
    <td align="center" valign="top">
      <div class="content" style="margin-left:10px; margin-right:10px; margin-top:30px;">
    <!-- 여기여기 -->
		<div style="margin-bottom:30px;">
			<!-- <button type="button" style="float: left; margin-left:95px;" onclick="location.href='<?php echo site_url()?>/fundreporting/fundreporting_history_bank?company=HIS_BANK'">은행관리 로그</button> -->
         <form id="fundSearch" action="<?php echo site_url();?>/fundreporting/historysearch<?php echo $company;?>" method="post">
            <select name="modifyType" id="modifyType">
               <option value="">전체보기</option>
               <option value="입력">입력</option>
               <option value="수정">수정</option>
               <option value="삭제">삭제</option>
       </select>
      <select name="company" id="company">
        <option value="">전체회사</option>
        <option value="DUIT">DUIT</option>
        <option value="DUICT">DUICT</option>
        <option value="MG">MG</option>
        <option value="DBS">DBS</option>
      </select>
            <input type="text" id="" name="" value="수정시간" size="4" readonly>
						<input type="text" id="fromModify" name="fromModify" size="15" maxlength="19" placeholder="  연-월-일 시:분:초" onkeyup="auto_datetime_format(event, this); onlyNumHipenCol(this);" onkeypress="auto_datetime_format(event, this)">부터
            <input type="text" id="toModify" name="toModify" size="15" maxlength="19" placeholder="  연-월-일 시:분:초" onkeyup="auto_datetime_format(event, this); onlyNumHipenCol(this);" onkeypress="auto_datetime_format(event, this)">까지

         <select name="selectDate" id="selectDate">
            <option value="dueDate">확정일</option>
            <option value="fixedDate">예정일</option>
            <option value="dateOfIssue">발행일</option>
      </select>
				<input type="text" id="fromDate" name="fromDate" size="7"  autocomplete="off" maxlength="10" onkeyup="auto_date_format(event, this)" onkeypress="auto_date_format(event, this)" class="tInput_datepick">
				<input type="button" name="" id="fromBtn" class="dateBtn" value=" "> ~
				<input type="text" id="toDate" name="toDate"  autocomplete="off" size="7" maxlength="10" onkeyup="auto_date_format(event, this)" onkeypress="auto_date_format(event, this)" class="tInput_datepick">
				<input type="button" name="" id="toBtn" class="dateBtn" value=" ">
        <select name="search1" id="search1" >
            <option value = "id">ID</option>
            <option value = "type">대구분</option>
            <option value = "customer">거래처</option>
            <option value = "endUser">END-USER</option>
            <option value = "bankType">은행구분</option>
            <option value = "breakdown">내역</option>
      </select>
        <input type="text" id="keyword1" name="keyword1" value="" size="8">
        <select name="search2" id="search2">
            <option value = "type">대구분</option>
            <option value = "customer">거래처</option>
            <option value = "endUser">END-USER</option>
            <option value = "bankType">은행구분</option>
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
        <tr bgcolor="f8f8f9" class="t_top his_top">
          <td align="center" class="t_border hcell1">구분</td>
          <td align="center" class="t_border hcell2">발행일</td>
          <td align="center" class="t_border hcell3">예정일</td>
          <td align="center" class="t_border hcell4">확정일</td>
          <td align="center" class="t_border hcell5">대구분</td>
          <td align="center" class="t_border hcell6">은행구분</td>
          <td align="center" class="t_border hcell7">거래처</td>
          <td align="center" class="t_border hcell8">END-USER</td>
          <td align="center" class="t_border hcell9">내역</td>
          <td align="center" class="t_border hcell10">청구금액</td>
          <td align="center" class="t_border hcell11">입금</td>
          <td align="center" class="t_border hcell12">출금</td>
					<td align="center" class="t_border hcell12">회사</td>
          <td align="center" class="t_border hcell13">ID</td>
          <td align="center" class="t_border hcell14">수정 시간</td>
        </tr>
      </tdead>
		</table>
	</div>
	<div id="hisTbl">
		<table style="width:100%;">
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

					if ($list->modifytype == '입력'){ ?>
						<tr>
							<td height="30" align="center" class="t_border hcell1" id='insLog'><span style="color:#39acff"><?php echo $list->modifytype ?></span></td>
							<td height="30" align="center" class="t_border hcell2" id='insLog'><?php echo $list->dateofissue ?></td>
							<td height="30" align="center" class="t_border hcell3" id='insLog'><?php echo $list->fixeddate ?></td>
							<td height="30" align="center" class="t_border hcell4" id='insLog'><?php echo $list->duedate ?></td>
							<td height="30" align="center" class="t_border hcell5" id='insLog'><?php echo $list->type ?></td>
							<td height="30" align="center" class="t_border hcell6" id='insLog'><?php echo $list->banktype ?></td>
							<td height="30" align="center" class="t_border hcell7" id='insLog'><?php echo $list->customer ?></td>
							<td height="30" align="center" class="t_border hcell8" id='insLog'><?php echo $list->enduser ?></td>
							<td height="30" align="center" class="t_border hcell9" id='insLog'><?php echo $list->breakdown ?></td>
							<td height="30" align="center" class="t_border hcell10" id='insLog' style="text-align:right;"><?php echo $requisition ?></td>
							<td height="30" align="center" class="t_border hcell11" id='insLog' style="text-align:right;"><?php echo $deposit ?></td>
							<td height="30" align="center" class="t_border hcell12" id='insLog' style="text-align:right;"><?php echo $withdraw ?></td>
							<td height="30" align="center" class="t_border hcell9" id='insLog'><?php echo $company ?></td>
							<td height="30" align="center" class="t_border hcell13" id='insLog'><?php echo $list->id ?></td>
							<td height="30" align="center" class="t_border hcell14" id='insLog'><?php echo $list->modifydate ?></td>
						</tr>
					<?php
				} ?>
					<?php
					if ($list->modifytype == '삭제'){ ?>
						<tr>
							<td height="30" align="center" class="t_border hcell1" id='delLog'><span style="color:#f95b5b"><?php echo $list->modifytype ?></span></td>
							<td height="30" align="center" class="t_border hcell2" id='delLog'><?php echo $list->dateofissue ?></td>
							<td height="30" align="center" class="t_border hcell3" id='delLog'><?php echo $list->fixeddate ?></td>
							<td height="30" align="center" class="t_border hcell4" id='delLog'><?php echo $list->duedate ?></td>
							<td height="30" align="center" class="t_border hcell5" id='delLog'><?php echo $list->type ?></td>
							<td height="30" align="center" class="t_border hcell6" id='delLog'><?php echo $list->banktype ?></td>
							<td height="30" align="center" class="t_border hcell7" id='delLog'><?php echo $list->customer ?></td>
							<td height="30" align="center" class="t_border hcell8" id='delLog'><?php echo $list->enduser ?></td>
							<td height="30" align="center" class="t_border hcell9" id='delLog'><?php echo $list->breakdown ?></td>
							<td height="30" align="center" class="t_border hcell10" id='delLog' style="text-align:right;"><?php echo $requisition ?></td>
							<td height="30" align="center" class="t_border hcell11" id='delLog' style="text-align:right;"><?php echo $deposit ?></td>
							<td height="30" align="center" class="t_border hcell12" id='delLog' style="text-align:right;"><?php echo $withdraw ?></td>
							<td height="30" align="center" class="t_border hcell9" id='delLog'><?php echo $company ?></td>
							<td height="30" align="center" class="t_border hcell13" id='delLog'><?php echo $list->id ?></td>
							<td height="30" align="center" class="t_border hcell14" id='delLog'><?php echo $list->modifydate ?></td>
						</tr>
					<?php
				} ?>
				<?php
					if ($list->modifytype == '수정'){ ?>
						<tr>
							<td align="center" class="t_border hcell1" rowspan="2" id='modLog'><span style="color:#85ff3b"><?php echo $list->modifytype ?></span></td>
							<td height="30" align="center" class="t_border hcell2" style="background-color:#d4d0d0"><?php echo $list->dateofissue ?></td>
							<td height="30" align="center" class="t_border hcell3" style="background-color:#d4d0d0"><?php echo $list->fixeddate ?></td>
							<td height="30" align="center" class="t_border hcell4" style="background-color:#d4d0d0"><?php echo $list->duedate ?></td>
							<td height="30" align="center" class="t_border hcell5" style="background-color:#d4d0d0"><?php echo $list->type ?></td>
							<td height="30" align="center" class="t_border hcell6" style="background-color:#d4d0d0"><?php echo $list->banktype ?></td>
							<td height="30" align="center" class="t_border hcell7" style="background-color:#d4d0d0"><?php echo $list->customer ?></td>
							<td height="30" align="center" class="t_border hcell8" style="background-color:#d4d0d0"><?php echo $list->enduser ?></td>
							<td height="30" align="center" class="t_border hcell9" style="background-color:#d4d0d0"><?php echo $list->breakdown ?></td>
							<td height="30" align="center" class="t_border hcell10" style="background-color:#d4d0d0; text-align:right;"><?php echo $requisition ?></td>
							<td height="30" align="center" class="t_border hcell11" style="background-color:#d4d0d0; text-align:right;"><?php echo $deposit ?></td>
							<td height="30" align="center" class="t_border hcell12" style="background-color:#d4d0d0; text-align:right;"><?php echo $withdraw ?></td>
							<td height="30" align="center" class="t_border hcell9" style="background-color:#d4d0d0"><?php echo $company ?></td>
							<td height="30" align="center" class="t_border hcell13" style="background-color:#d4d0d0"><?php echo $list->id ?></td>
							<td height="30" align="center" class="t_border hcell14" style="background-color:#d4d0d0"><?php echo $list->lastdate ?></td>
						</tr>
						<tr>
							<td height="30" align="center" class="t_border hcell2" id='modLog'<?php if($list->dateofissue != $list->new_dateofissue){echo 'style="background-color:#facdcd"';} ?>><?php echo $list->new_dateofissue ?></td>
							<td height="30" align="center" class="t_border hcell3" id='modLog'<?php if($list->fixeddate != $list->new_fixeddate){echo 'style="background-color:#facdcd"';} ?>><?php echo $list->new_fixeddate ?></td>
							<td height="30" align="center" class="t_border hcell4" id='modLog'<?php if($list->duedate != $list->new_duedate){echo 'style="background-color:#facdcd"';} ?>><?php echo $list->new_duedate ?></td>
							<td height="30" align="center" class="t_border hcell5" id='modLog'<?php if($list->type != $list->new_type){echo 'style="background-color:#facdcd"';} ?>><?php echo $list->new_type ?></td>
							<td height="30" align="center" class="t_border hcell6" id='modLog'<?php if($list->banktype != $list->new_banktype){echo 'style="background-color:#facdcd"';} ?>><?php echo $list->new_banktype ?></td>
							<td height="30" align="center" class="t_border hcell7" id='modLog'<?php if($list->customer != $list->new_customer){echo 'style="background-color:#facdcd"';} ?>><?php echo $list->new_customer ?></td>
							<td height="30" align="center" class="t_border hcell8" id='modLog'<?php if($list->enduser != $list->new_enduser){echo 'style="background-color:#facdcd"';} ?>><?php echo $list->new_enduser ?></td>
							<td height="30" align="center" class="t_border hcell9" id='modLog'<?php if($list->breakdown != $list->new_breakdown){echo 'style="background-color:#facdcd"';} ?>><?php echo $list->new_breakdown ?></td>
							<td height="30" align="center" class="t_border hcell10" style="text-align:right;<?php if($requisition != $newRequisition){echo 'background-color:#facdcd;';} ?>" id='modLog'><?php echo $newRequisition ?></td>
							<td height="30" align="center" class="t_border hcell11" style="text-align:right;<?php if($deposit != $newDeposit){echo 'background-color:#facdcd;';} ?>" id='modLog'><?php echo $newDeposit ?></td>
							<td height="30" align="center" class="t_border hcell12" style="text-align:right;<?php if($withdraw != $newWithdraw){echo 'background-color:#facdcd;';} ?>" id='modLog'><?php echo $newWithdraw ?></td>
							<td height="30" align="center" class="t_border hcell13" id='modLog'><?php echo $company ?></td>
							<td height="30" align="center" class="t_border hcell13" id='modLog'><?php echo $list->new_id ?></td>
							<td height="30" align="center" class="t_border hcell14" id='modLog'><?php echo $list->modifydate ?></td>
						</tr>
					<?php
				} ?>
				<?php } ?>
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
