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
  <script type="text/javascript" src="/misc/js/xlsx.full.min.js"></script>
  <script type="text/javascript" src="/misc/js/excelImport.js"></script>
   <script type="text/javascript" src="/misc/js/jquery.table2excel.js"></script>
   <script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />


<body>
  <input type="hidden" id="pGroupName" value="<?php echo $pGroupName ?>">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr width="100%">
    <td align="center" valign="top">
    <!-- 여기여기 -->
      <?php
      if (empty($_GET['company'])){
         $company = 'DUIT';
      } else {
         $company = $_GET['company'];
      }
      switch ($company) {
         case 'DUIT':
            $companyName = '두리안정보기술';
            break;
         case 'DUICT':
            $companyName = '두리안정보통신기술';
            break;
         case 'MG':
            $companyName = '더망고';
            break;
         case 'DBS':
            $companyName = '두리안정보기술부산지점';
            break;
      }
      $company = '?company='.$company;
      ?>

  <div class="content" style="margin-left:10px; margin-right:10px;">





      <?php


isset($total_rows)?$total_rows:$total_rows = "";
isset($sumDeposit)?$sumDeposit:$sumDeposit = "";
isset($sumWithdraw)?$sumWithdraw:$sumWithdraw = "";
isset($nsDeposit)?$nsDeposit:$nsDeposit = "";
isset($nsWithdraw)?$nsWithdraw:$nsWithdraw = "";
isset($selectDate)?$selectDate:$selectDate = "";
isset($search1)?$search1:$search1 = "";
isset($search2)?$search2:$search2 = "";
isset($keyword1)?$keyword1:$keyword1 = "";
isset($keyword2)?$keyword2:$keyword2 = "";

switch ($selectDate) {
   case 'dueDate':
      $selectDate = "확정일";
      break;

   case 'fixedDate':
      $selectDate = "예정일";
      break;

   case 'dateOfIssue':
      $selectDate = "발행일";
      break;
}


switch ($search1) {
   case 'customer':
        $search1 = "거래처";
      break;

   case 'endUser':
      $search1 = "END-USER";
   break;

   case 'type':
      $search1 = "대구분";
   break;

   case 'bankType':
      $search1 = "은행구분";
   break;

   case 'breakdown':
      $search1 = "내역";
   break;
}

switch ($search2) {
   case 'customer':
        $search2 = "거래처";
      break;

   case 'endUser':
      $search2 = "END-USER";
   break;

   case 'type':
      $search2 = "대구분";
   break;

   case 'bankType':
      $search2 = "은행구분";
   break;

   case 'breakdown':
      $search2 = "내역";
   break;
}
$period ="";
$condition1 = "";
$condition2 = "";

if($fromDate != "" || $toDate != ""){
   $period = $selectDate." 기준 : ".$fromDate." ~ ".$toDate;
}
if($keyword1 != ""){
   $condition1 = $search1." : ".$keyword1;
}

if($keyword2 != ""){
   $condition2 = $search2." : ".$keyword2;
}
?>
<h5 style ="color: black;"><?php echo  $companyName; ?> &nbsp;&nbsp; <?php echo  $period; ?> &nbsp;&nbsp; <?php echo  $condition1; ?> &nbsp;&nbsp; <?php echo  $condition2; ?> </h5>
<div id="searchResult">

    <?php if($total_rows == 0){?>
       <div>
          <h5 style ="color: black;">검색결과가 없습니다.</h5>
       </div>
<?php }else{?>
 <h5 style ="color: black;">검색건수 : <?php echo number_format($total_rows); ?>건 /    입금총액 : <?php echo  number_format($sumDeposit); ?>원 /  출금총액 : <?php echo  number_format($sumWithdraw); ?>원 / 미지급입금총액 : <?php echo  number_format($nsDeposit); ?>원 / 미지급출금총액 : <?php echo  number_format($nsWithdraw); ?>원</h5>
<?php }; ?>

</div>
      <!-- 버튼 시작 -->

    <button style="float: right;" type="button" class="hideButton" id="update">저장</button>
    <button style="float: right;" type="button" class="hideButton" id='delBtn' name="button">삭제</button>
    <button class="moveBottom" style="float: right;" type="button" name="button">▼</button>
    <button class="moveTop" style="float: right;" type="button" name="button">▲</button>
      <div>

         <form action="<?php echo site_url();?>/sales/fundreporting/search<?php echo $company;?>" method="post">
         <select name="selectDate" id="selectDate">
            <option value="dueDate">확정일</option>
            <option value="fixedDate">예정일</option>
            <option value="dateOfIssue">발행일</option>
            <input type="text" id="fromDate" name="fromDate" size="7" maxlength="10" onkeyup="auto_date_format(event, this)" onkeypress="auto_date_format(event, this)" class="tInput_datepick">부터
             <input type="text" id="toDate" name="toDate" size="7" maxlength="10" onkeyup="auto_date_format(event, this)" onkeypress="auto_date_format(event, this)" class="tInput_datepick">까지
               <select name="search1" id="search1" >
                  <option value = "customer">거래처</option>
                  <option value = "endUser">END-USER</option>
                  <option value = "type">대구분</option>
                  <option value = "bankType">은행구분</option>
                  <option value = "breakdown">내역</option>
               <input type="text" id="keyword1" name="keyword1" value="" size="8">
               <select name="search2" id="search2" name="search2">
                  <option value = "type">대구분</option>
                  <option value = "customer">거래처</option>
                  <option value = "endUser">END-USER</option>
                  <option value = "bankType">은행구분</option>
                  <option value = "breakdown">내역</option>
               <input type="text" id="keyword2" name="keyword2" value="" size="8">
            <input class="btn-primary" type="submit" id="search_btn2" name="submit" value="검색">

         </form>

      </div>
      <!-- 버튼 끝 -->

      <div class="table-container" id="table-container" style="width: 100%;">
      <div class="table-box">


      <table id = "accountlist" class="accountlist" style="width: 100%;">               <colgroup>
                 <col style="width:1%">
                 <col style="width:5%">
                 <col style="width:5%">
                 <col style="width:5%">
                 <col style="width:5.3%">
                 <col style="width:5.4%">
                 <col style="width:10.7%">
                 <col style="width:10.7%">
                 <col style="width:21.9%">
                 <col style="width:6%">
                 <col style="width:6%">
                 <col style="width:6%">
                 <col style="width:6%">
                 <col style="width:6%;">
               </colgroup>
            <thead>
                     <tr class="fixed_top2">
                        <th class="noExl" scope="col"></th>
                        <th class="cell1" scope="col">발행일</th>
                        <th class="cell2" scope="col">예정일</th>
                        <th class="cell3" scope="col">확정일</th>
                        <th class="cell4" scope="col">대구분</th>
                        <th class="cell5" scope="col">은행구분</th>
                        <th class="cell6" scope="col">거래처</th>
                        <th class="cell7" scope="col">END-USER</th>
                        <th class="cell8" scope="col">내역</th>
                        <th class="cell9" scope="col">청구금액</th>
                        <th class="cell10" scope="col">입금</th>
                        <th class="cell11" scope="col">출금</th>
                        <th class="cell12" scope="col">잔액</th>
                        <th class="cell13" scope="col">가용금액</th>
                     </tr>
            </thead>
            <tbody id="AddOption">
                <?php
            if ($pagingBalance==0){
               $balance=0;
            } else {
               $balance = $pagingBalance[0]->pagingBalance;
            }
            ?>
            <input type="hidden" id="saveBalance" value="<?php echo $balance?>">
            <?php

            $selectBankTypeArr = array();
            $selectBankTypeHidden = array();
               if(!empty($selectBankTypeList)){
                foreach ($selectBankTypeList as $selectBankTypeList) {
                      array_push($selectBankTypeArr,$selectBankTypeList->banktype);
                            array_push($selectBankTypeHidden,$selectBankTypeList->banktype);
                }
               };


            echo form_hidden("bankTypeArr", $selectBankTypeArr);

            foreach ($selectBankTypeHidden as $selectBankTypeHidden) {
               echo "<tr class='bankTypeHidden'>";
               echo "<input type='hidden' value='$selectBankTypeHidden'>";
               echo "</tr>";
            }

        foreach(array_reverse($list) as $key => $list) {

          $balance=$balance-$list->withdraw+$list->deposit;
               $bankType = $list->bankType;
               if ($bankType==null){
                  $bankType = 'noBankType';
               }
               $deposit = number_format($list->deposit);
               $withdraw = number_format($list->withdraw);
               $balance = number_format($balance);
               $requisition = number_format($list->requisition);
               if ($requisition == 0){
                  $requisition = '';
               }
               if ($deposit == 0){
                  $deposit = '';
               }
               if ($withdraw == 0){
                  $withdraw = '';
               }
               // if ($balance == 0){
               //    $balance = '';
               // }



        ?>
                <tr class="row" name = "<?php echo $key?>">
                    <input type="hidden" style="color:red" name="idx" value="<?php echo $list->idx?>" />
                    <td class="noExl"><input type="checkbox" name="delRow"></td>
                    <td scope="row"><input class="input" style="width:100%; text-align:left;" type="text" name="dateOfIssue"
                            value="<?php echo $list->dateOfIssue?>" maxlength="10" onchange="modifyInput(this);" onkeyup="auto_date_format(event, this); onlyNumHipen(this);" onkeypress="auto_date_format(event, this); onlyNumHipen(this)"/></td>
                    <td scope="row"><input class="input" style="width:100%; text-align:left;" type="text" name="fixedDate"
                            value="<?php echo $list->fixedDate?>" maxlength="10" onchange="modifyInput(this);" onkeyup="auto_date_format(event, this); onlyNumHipen(this);" onkeypress="auto_date_format(event, this); onlyNumHipen(this)"/></td>
                    <td scope="row"><input class="input" style="width:100%; text-align:left;" type="text" name="dueDate"
                            value="<?php echo $list->dueDate?>" maxlength="10" onchange="modifyInput(this);" onkeyup="auto_date_format(event, this); onlyNumHipen(this);" onkeypress="auto_date_format(event, this); onlyNumHipen(this)"/></td>
                              <td scope="row">
                                <?php
          											if ($pGroupName == '영업본부') {
          											    echo '<input type="text" name="" value="'.$list->type.'"style="width:100%; text-align:left; border:none;">';
          											} else {
          											  echo '<select id="list_select" style="width:100%; text-align:left; border:none;" name="type" onchange="modifyInput(this);"/>';
          											  echo '<option value=""';
          											  if($list->type== null){
          											    echo 'selected';
          											  }
          											  echo '></option>';
          											  echo '<option value="매입채무"';
          											  if($list->type=="매입채무"){
          											    echo 'selected';
          											  }
          											  echo '>매입채무</option>';
          											  echo '<option value="매출채권"';
          											  if($list->type=="매출채권"){
          											    echo 'selected';
          											  }
          											  echo '>매출채권</option>';
          											  echo '<option value="운영비용"';
          											  if($list->type=="운영비용"){
          											    echo 'selected';
          											  }
          											  echo '>운영비용</option>';
          											  echo '</select>';
          											}
          											?>
                            </td>
                              <td scope="row">
                                <?php
      													if ($pGroupName == '영업본부') {
      													    echo '<input type="text" name="" value="'.$list->bankType.'"style="width:100%; text-align:left; border:none;">';
      													} else {
      														echo '<select id="list_select" name="bankType" style="width:100%; text-align:left; border:none;" onchange="modifyInput(this);">';
      									            if($list->bankType != null){
      																echo "123";
      									                echo "<option value=''></option>";
      									                for($i=0; $i<count($selectBankTypeArr); $i++){
      									                    echo "<option value='".$selectBankTypeArr[$i]."' ";
      									                    if(($list->bankType) == ($selectBankTypeArr[$i])){
      									                            echo "selected='selected'";
      									                    }
      									                    echo ">".$selectBankTypeArr[$i]."</option>";
      									                }
      									            }else{
      									                echo "<option value='' selected></option>";
      									                for($i=0; $i<count($selectBankTypeArr); $i++){
      									                    echo "<option value='".$selectBankTypeArr[$i]."' ";
      									                    echo ">".$selectBankTypeArr[$i]."</option>";
      									                }
      									            }
      															echo '</select>';
      														}
      									        ?>
                           </td>
                    <td scope="row"><input class="input" style="width:100%; text-align:left;" type="text" name="customer"
                            value="<?php echo $list->customer?>" onchange="modifyInput(this);"/></td>
                    <td scope="row"><input class="input" style="width:100%; text-align:left;" type="text" name="endUser"
                            value="<?php echo $list->endUser?>" onchange="modifyInput(this);"/></td>
                    <td scope="row"><input class="input" style="width:100%; text-align:left;" type="text" name="breakdown"
                            value="<?php echo $list->breakdown?>" onchange="modifyInput(this);"/></td>
                    <td scope="row"><input class="input" style="width:70%; text-align:right;" type="text" name="requisition"
                            value="<?php echo $requisition?>" onchange="modifyInput(this);" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" /></td>
                    <td scope="row"><input class="input" style="width:70%; text-align:right;" type="text" name="deposit"
                            class="deposit" name="money" value="<?php echo $deposit?>" onchange="calcBalance(); modifyInput(this);" onFocus="deCommaStr(this); oldVal(this);" onBlur="this.value = commaStr(this.value);" /></td>
                    <td scope="row"><input class="input" style="width:70%; text-align:right;" type="text" name="withdraw"
                            class="withdraw" name="money" value="<?php echo $withdraw?>" onchange="calcBalance(); modifyInput(this);" onFocus="deCommaStr(this); oldVal(this);" onBlur="this.value = commaStr(this.value);"/></td>
                    <td scope="row"><input class="input" style="width:70%; text-align:right;" type="text" name="balance"
                            class="balance" name="money" value="<?php echo $balance?>" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" readonly/></td>
                    <td scope="row"><input class="input" style="width:70%; text-align:right;" type="text" name="balance2"
                            class="balance2" name="money" value="<?php echo $balance?>" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" readonly/></td>
                </tr>
                </tr>
                <?php
                        $deposit = filter_var($deposit, 519);
                        $withdraw = filter_var($withdraw, 519);
                        $balance = filter_var($balance, 519);
                        $requisition = filter_var($requisition, 519);
        }
         ?>
            </tbody>
        </table>

    </div>
      <div>
          <?php echo $pagination;?>
      </div>
    <input style="float: left;" class="hideInput" type="button" value="추가" id="itemAdd" />
        <input style="float: left;" class="hideInput" type="button" value="한줄복사" id="itemPaste" />
         <input type='button' class='btn btn-inverse' value='excel 다운' onclick="ReportToExcelConverter()" style="float: right;"/>
         </div>
    </div>
    <!-- 여기여기끝 -->
    </td>
  </tr>
  <!--하단-->

  <!--하단-->
</table>
<script type="text/javascript" src="/misc/js/fundReporting.js"></script>
</body>
</html>
