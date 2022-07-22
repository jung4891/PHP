<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script type="text/javascript" src="/misc/js/mousetrap.js"></script> <!--  단축키 js -->
<link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css"> <!-- 달력 표시 css (datepicker) -->
<script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script> <!--  달력 표시 js (datepicker) -->
<style>
.item_div{
  width: 95%;
  max-height: 800px;
  -ms-overflow-style: none; /*ie, edge*/
  scrollbar-width: none; /*파이어폭스란다*/ */

}
  /* .item_div::-webkit-scrollbar{ /*롬크*/
    display:bolck;

   } */

.scroll_div{
  width: 95%;
  overflow-y: scroll;
  -ms-overflow-style: none; /*ie, edge*/
  scrollbar-width: none; /*파이어폭스란다*/
}
  .scroll_div::-webkit-scrollbar{ /*롬크*/
  display:none;

 }
  .contents_tbl{
    width: 100%;
    text-align:center;
    position: relative;
  }
  .contents_tbl thead td{
    font-size:14px;
    font-weight:bold;
    position: sticky;
    top:38px;
  }
  .contents_tbl:not(.total_tbl) th {
    font-size: 16px;
    position: sticky;
    top:0px;
  }
  .contents_tbl td, .total_tbl th{
    word-break:break-all;
  }
  .fixed_tr1 td{
    position: sticky;
    bottom:40px;
  }
  .fixed_tr3 td{
    position: sticky;
    bottom:80px;
  }
  .fixed_tr2 td {
    position: sticky;
    bottom:0px;
  }
  .blank_td {
    background-color: white;
  }
  input:disabled {
    background: white;
    border:none;
  }
  .tax_approval_number{
    cursor:pointer;
  }
  .endUser {
    background-color: #F4F4F4;
  }
  .contents_tbl th, .contents_tbl td {
    height:38px;
    padding-top:0px;
    padding-bottom:0px;
  }
  .contents_tbl td {
    font-size: 12px !important;
  }
  .mg td { color:rgb(74, 203, 160);}
  .toggle_span {
    position: relative;
    float:left;
    padding: 0 2.5%;
  }
</style>
<body>
  <?php
    include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";

    $today = new DateTime();
  ?>

  <!-- <div align="center"> -->
  <div class="dash1-1" align="center">
	  <div>
      <table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
		    <tr height="5%">
        	<td class="dash_title">
          	미수금-미지급목록
          </td>
        </tr>
        <tr>
          <td height="70"></td>
        </tr>
      </table>
		</div>

    <div style="">
      <table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
        <tr style="width:100%;">
          <td style="width:50%;">
            <input type="button" class="btn-common <?php if($sort_condition=='endUser'){echo 'btn-style2';}else{echo 'btn-style1';} ?>" style="width:100px;" value="endUser" onclick="sort('endUser');">
            <input type="button" class="btn-common <?php if($sort_condition=='endUser'){echo 'btn-style1';}else{echo 'btn-style2';} ?>" style="width:100px" value="결제일" onclick="sort('deposit_date');">
            <form class="mform" name="mform" action="<?php echo site_url();?>/sales/accounts_receivable_unpaid/accounts_receivable_unpaid_view" method="get">
              <input type="hidden" name="sort_condition" value="<?php echo $sort_condition; ?>">
<!-- 검색 창 -->
            </form>
          </td>
          <td style="width:50%; text-align:right;">
            <!-- <img src="<?php echo $misc; ?>/img/dashboard/btn/excel_download.png" alt="" style="margin-right: 5%; cursor: pointer;" onclick="excel_export();"> -->
            <input class="btn-common btn-updownload" type="button" onclick="excel_export();" value="엑셀 다운로드" style="float:right;padding-left:20px;width:auto;position:relative;">
            <img src="/misc/img/download_btn.svg" style="width:12px;position:relative;top:11px;left:19px;">
          </td>
        </tr>
      </table>
    </div>

<!-- 매입매출 (상품) -->
    <span align="left" class="toggle_span">
      <img width="25" name="hide_img" src="<?php echo $misc;?>/img/btn_up_box.svg" onclick="div_toggle('fo_div', this);" style="cursor:pointer;padding-top: 20px;padding-bottom: 10px;">
    </span>
    <div class="item_div" id="fo_div" style="overflow:auto;">
      <div class="scroll_div">
        <table id="forcasting_purchase_sales" class="contents_tbl" cellspacing=0 cellpadding=5>
          <colgroup>
            <col width="10.75%" /> <!-- 계삼서no -->
            <col width="4.5%" /> <!-- 매출일자-->
            <col width="7%" /> <!-- 매출업체 -->
            <col width="12%" /> <!-- 품목/내역 -->
            <col width="6.5%" /> <!--금액-->
            <col width="5%" /> <!--결제일-->
            <col width="9%" /> <!--엔드유저-->
            <col width="4.5%" /> <!--매입일자-->
            <col width="7%" /> <!--매입업체-->
            <col width="12%" /> <!--품목/내역-->
            <col width="6.5%" /> <!-- 금액 -->
            <col width="4.5%" /> <!-- 결제일 -->
            <col width="10.75%" /> <!--계산서no-->
          </colgroup>
          <thead>
            <tr>
              <!-- type 002 -->
              <th colspan="7">매출(상품)</th>
              <th></th>
              <!-- type 001 -->
              <th colspan="6">매입(상품)</th>
            </tr>
            <tr>
              <td class="row-color6">세금계산서No.</td>
              <td class="row-color6">매출일자</td>
              <td class="row-color6">매출업체</td>
              <td class="row-color6">품목/내역</td>
              <td class="row-color6">금액</td>
              <td class="row-color6">결제일</td>
              <td class="row-color6">End-User</td>
              <td class="row-color6">매입일자</td>
              <td class="row-color6">매입업체</td>
              <td class="row-color6">품목/내역</td>
              <td class="row-color6">금액</td>
              <td class="row-color6">결제일</td>
              <td class="row-color6">세금계산서No.</td>
            </tr>
          </thead>
          <tbody>
        <?php
        if(!empty($distinct_forcasting_seq)) {
          foreach($distinct_forcasting_seq as $dfs) { ?>
    <?php for($i=0; $i<$bill_data_count[$dfs['rseq']]; $i++){ ?>
            <tr seq="<?php echo $dfs['rseq']; ?>" class="<?php if($dfs['cooperation_companyname'] == '더망고'){echo 'mg';} ?>">
      <?php if(isset($forcasting_sales_data[$dfs['rseq']][$i])){
              $fs = $forcasting_sales_data[$dfs['rseq']][$i];
              if($fs['rseq'] == 'null') { ?>
                <td colspan="6">N</td>
        <?php } else {
                $color = '';
                if ($fs['deposit_status'] != 'Y') {
                  $t_date = new DateTime($fs['issuance_date']);
                  $diff = date_diff($t_date, $today);
                  if($diff->days > 60) {
                    $color = 'color:red;';
                  }
                }
                ?>
                <td style="<?php echo $color; ?>" class="tax_approval_number" onclick="go_page('<?php echo $dfs['rseq']; ?>')">
                  <?php echo $fs['tax_approval_number']; ?>
                </td>
                <td style="<?php echo $color; ?>"><?php echo $fs['issuance_date']; ?></td>
                <td style="<?php echo $color; ?>"><?php echo $fs['company_name']; ?></td>
                <td style="<?php echo $color; ?>"><?php echo $fs['project_name']; ?></td>
                <td style="<?php echo $color; ?>" class="<?php if($fs['deposit_status']!='Y'){echo 'none_money_s';} ?>"><?php echo number_format($fs['total_amount']); ?></td>
                <td style="<?php echo $color; ?>"><?php if($fs['deposit_status'] == 'Y'){echo $fs['deposit_date'];} ?></td>
        <?php }
            } else { ?>
              <td colspan="6"></td>
      <?php } ?>
              <td class="endUser"><?php echo $dfs['customer_companyname']; ?></td>
      <?php if(isset($forcasting_purchase_data[$dfs['rseq']][$i])){
              $fp = $forcasting_purchase_data[$dfs['rseq']][$i];
              if($fp['rseq'] == 'null') { ?>
                <td colspan="6">N</td>
        <?php } else {
                $color = '';
                if ($fp['deposit_status'] != 'Y') {
                  $t_date = new DateTime($fp['issuance_date']);
                  $diff = date_diff($t_date, $today);
                  if($diff->days > 60) {
                    $color = 'color:blue;';
                  }
                } ?>
                <td style="<?php echo $color; ?>"><?php echo $fp['issuance_date']; ?></td>
                <td style="<?php echo $color; ?>"><?php echo $fp['company_name']; ?></td>
                <td style="<?php echo $color; ?>"><?php echo $fp['project_name']; ?></td>
                <td style="<?php echo $color; ?>" class="<?php if($fp['deposit_status']!='Y'){echo 'none_money_p';} ?>"><?php echo number_format($fp['total_amount']); ?></td>
                <td style="<?php echo $color; ?>"><?php if($fp['deposit_status'] == 'Y'){echo $fp['deposit_date'];} ?></td>
                <td style="<?php echo $color; ?>" class="tax_approval_number" onclick="go_page('<?php echo $dfs['rseq']; ?>')">
                  <?php echo $fp['tax_approval_number']; ?>
                </td>
        <?php }
            } else { ?>
              <td colspan="6"></td>
      <?php } ?>
            </tr>
    <?php } ?>
    <?php }
        }
        ?>
            <tr class="fixed_tr1">
              <td style="background-color:#F2FCFF;font-weight:bold;color:#007BCB;height:40px;" colspan="4">IT 미수금 합계</td>
              <td style="background-color:#F2FCFF;font-weight:bold;color:#007BCB;" id="forcasting_sum_s_it">1,000</td>
              <td style="background-color:#F2FCFF"></td>
              <td style="background-color:white;"></td>
              <td style="background-color:#FFEDED;font-weight:bold;color:#E53737;" colspan="3">IT 미지급 합계</td>
              <td style="background-color:#FFEDED;font-weight:bold;color:#E53737;" id="forcasting_sum_p_it">1,000</td>
              <td style="background-color:#FFEDED" colspan="2"></td>
            </tr>
            <tr class="fixed_tr2">
              <td style="background-color:#F2FCFF;font-weight:bold;color:#007BCB;height:40px;" colspan="4">MG 미수금 합계</td>
              <td style="background-color:#F2FCFF;font-weight:bold;color:#007BCB;" id="forcasting_sum_s_mg">1,000</td>
              <td style="background-color:#F2FCFF"></td>
              <td style="background-color:white;"></td>
              <td style="background-color:#FFEDED;font-weight:bold;color:#E53737;" colspan="3">MG 미지급 합계 미지금합계 </td>
              <td style="background-color:#FFEDED;font-weight:bold;color:#E53737;" id="forcasting_sum_p_mg">1,000</td>
              <td style="background-color:#FFEDED" colspan="2"></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <span align="left" class="toggle_span">
      <img width="25" name="hide_img" src="<?php echo $misc;?>/img/btn_up_box.svg" onclick="div_toggle('ma_div', this);" style="cursor:pointer;padding-top: 20px;padding-bottom: 10px;">
    </span>
    <div class="item_div" id="ma_div" style="overflow:auto;">
      <div class="scroll_div">
        <table id="maintain_purchase_sales" class="contents_tbl" cellspacing=0 cellpadding=5 style="width:100%">
          <colgroup>
            <col width="10.75%" /> <!-- 계삼서no -->
            <col width="4.5%" /> <!-- 매출일자-->
            <col width="7%" /> <!-- 매출업체 -->
            <col width="12%" /> <!-- 품목/내역 -->
            <col width="6.5%" /> <!--금액-->
            <col width="5%" /> <!--결제일-->
            <col width="9%" /> <!--엔드유저-->
            <col width="4.5%" /> <!--매입일자-->
            <col width="7%" /> <!--매입업체-->
            <col width="12%" /> <!--품목/내역-->
            <col width="6.5%" /> <!-- 금액 -->
            <col width="4.5%" /> <!-- 결제일 -->
            <col width="10.75%" /> <!--계산서no-->
          </colgroup>
          <thead>
            <tr>
              <!-- type 002 -->
              <th colspan="7">매출(용역)</th>
              <th></th>
              <!-- type 001 -->
              <th colspan="6">매입(용역)</th>
            </tr>
            <tr>
              <td class="row-color6">세금계산서No.</td>
              <td class="row-color6">매출일자</td>
              <td class="row-color6">매출업체</td>
              <td class="row-color6">품목/내역</td>
              <td class="row-color6">금액</td>
              <td class="row-color6">결제일</td>
              <td class="row-color6">End-User</td>
              <td class="row-color6">매입일자</td>
              <td class="row-color6">매입업체</td>
              <td class="row-color6">품목/내역</td>
              <td class="row-color6">금액</td>
              <td class="row-color6">결제일</td>
              <td class="row-color6">세금계산서No.</td>
            </tr>
          </thead>
          <tbody>
        <?php
        if(!empty($distinct_maintain_seq)) {
          foreach($distinct_maintain_seq as $dms) { ?>
    <?php for($i=0; $i<$bill_data_count[$dms['rseq']]; $i++){ ?>
      <?php if(isset($maintain_sales_data[$dms['rseq']][$i]) || isset($maintain_purchase_data[$dms['rseq']][$i])){ ?>
            <tr seq="<?php echo $dms['rseq']; ?>" class="<?php if($dms['cooperation_companyname'] == '더망고'){echo 'mg';} ?>">
      <?php if(isset($maintain_sales_data[$dms['rseq']][$i])){
              $ms = $maintain_sales_data[$dms['rseq']][$i];
              if($ms['rseq'] == 'null') { ?>
                <td colspan="6">N</td>
        <?php } else if($ms['tax_approval_number'] == '20220131-41000096-08714527') { ?>
                <td colspan="6"></td>
        <?php } else {
                $color = '';
                if ($ms['deposit_status'] != 'Y') {
                  $t_date = new DateTime($ms['issuance_date']);
                  $diff = date_diff($t_date, $today);
                  if($diff->days > 60) {
                    $color = 'color:red;';
                  }
                } ?>
                <td style="<?php echo $color; ?>" class="tax_approval_number" onclick="go_page('<?php echo $dms['rseq']; ?>')">
                  <?php echo $ms['tax_approval_number']; ?>
                </td>
                <td style="<?php echo $color; ?>"><?php echo $ms['issuance_date']; ?></td>
                <td style="<?php echo $color; ?>"><?php echo $ms['company_name']; ?></td>
                <td style="<?php echo $color; ?>"><?php echo $ms['project_name']; ?>
                <?php if(isset($ms['pay_session']) && $ms['pay_session'] != '') {echo ' ('.$ms['pay_session'].'회차)';} ?></td>
                <td style="<?php echo $color; ?>" class="<?php if($ms['deposit_status']!='Y'){echo 'none_money_s';} ?>"><?php echo number_format($ms['total_amount']); ?></td>
                <td style="<?php echo $color; ?>"><?php if($ms['deposit_status'] == 'Y'){echo $ms['deposit_date'];} ?></td>
      <?php   }
            } else { ?>
              <td colspan="6"></td>
      <?php } ?>
              <td class="endUser"><?php echo $dms['customer_companyname']; ?></td>
      <?php if(isset($maintain_purchase_data[$dms['rseq']][$i])){
              $mp = $maintain_purchase_data[$dms['rseq']][$i];
              if($mp['rseq'] == 'null') { ?>
                <td colspan="6">N</td>
        <?php } else {
                $color = '';
                if ($mp['deposit_status'] != 'Y') {
                  $t_date = new DateTime($mp['issuance_date']);
                  $diff = date_diff($t_date, $today);
                  if($diff->days > 60) {
                    $color = 'color:blue;';
                  }
                } ?>
                <td style="<?php echo $color; ?>"><?php echo $mp['issuance_date']; ?></td>
                <td style="<?php echo $color; ?>"><?php echo $mp['company_name']; ?></td>
                <td style="<?php echo $color; ?>"><?php echo $mp['project_name']; ?>
                  <?php if(isset($mp['pay_session']) && $mp['pay_session'] != '') {echo ' ('.$mp['pay_session'].'회차)';} ?>
                </td>
                <td style="<?php echo $color; ?>" class="<?php if($mp['deposit_status']!='Y'){echo 'none_money_p';} ?>"><?php echo number_format($mp['total_amount']); ?></td>
                <td style="<?php echo $color; ?>"><?php if($mp['deposit_status'] == 'Y'){echo $mp['deposit_date'];} ?></td>
                <td style="<?php echo $color; ?>" class="tax_approval_number" onclick="go_page('<?php echo $dms['rseq']; ?>')">
                  <?php echo $mp['tax_approval_number']; ?>
                </td>
        <?php }
            } else { ?>
              <td colspan="6"></td>
      <?php } ?>
            </tr>
    <?php } ?>
    <?php } ?>
    <?php }
        }
        ?>
            <tr class="fixed_tr1">
              <td style="background-color:#F2FCFF;font-weight:bold;color:#007BCB;height:40px;" colspan="4">IT 미수금 합계</td>
              <td style="background-color:#F2FCFF;font-weight:bold;color:#007BCB;" id="maintain_sum_s_it">1,000</td>
              <td style="background-color:#F2FCFF"></td>
              <td style="background-color:white;"></td>
              <td style="background-color:#FFEDED;font-weight:bold;color:#E53737;" colspan="3">IT 미지급 합계</td>
              <td style="background-color:#FFEDED;font-weight:bold;color:#E53737;" id="maintain_sum_p_it">1,000</td>
              <td style="background-color:#FFEDED" colspan="2"></td>
            </tr>
            <tr class="fixed_tr2">
              <td style="background-color:#F2FCFF;font-weight:bold;color:#007BCB;height:40px;" colspan="4">MG 미수금 합계</td>
              <td style="background-color:#F2FCFF;font-weight:bold;color:#007BCB;" id="maintain_sum_s_mg">1,000</td>
              <td style="background-color:#F2FCFF"></td>
              <td style="background-color:white;"></td>
              <td style="background-color:#FFEDED;font-weight:bold;color:#E53737;" colspan="3">MG 미지급 합계</td>
              <td style="background-color:#FFEDED;font-weight:bold;color:#E53737;" id="maintain_sum_p_mg">1,000</td>
              <td style="background-color:#FFEDED" colspan="2"></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <span align="left" class="toggle_span">
      <img width="25" name="hide_img" src="<?php echo $misc;?>/img/btn_up_box.svg" onclick="div_toggle('procure_div', this);" style="cursor:pointer;padding-top: 20px;padding-bottom: 10px;">
    </span>
    <div class="item_div" id="procure_div" style="overflow:auto;">
      <div class="scroll_div">
        <table id="procurement_purchase_sales" class="contents_tbl" cellspacing=0 cellpadding=5 style="margin-bottom:50px;">
          <colgroup>
            <col width="10.75%" /> <!-- 계삼서no -->
            <col width="4.5%" /> <!-- 매출일자-->
            <col width="7%" /> <!-- 매출업체 -->
            <col width="12%" /> <!-- 품목/내역 -->
            <col width="6.5%" /> <!--금액-->
            <col width="5%" /> <!--결제일-->
            <col width="9%" /> <!--엔드유저-->
            <col width="4.5%" /> <!--매입일자-->
            <col width="7%" /> <!--매입업체-->
            <col width="12%" /> <!--품목/내역-->
            <col width="6.5%" /> <!-- 금액 -->
            <col width="4.5%" /> <!-- 결제일 -->
            <col width="10.75%" /> <!--계산서no-->
          </colgroup>
          <thead>
            <tr>
              <!-- type 002 -->
              <th colspan="7">매출(조달)</th>
              <th></th>
              <!-- type 001 -->
              <th colspan="6">매입(조달)</th>
            </tr>
            <tr>
              <td class="row-color6">세금계산서No.</td>
              <td class="row-color6">매출일자</td>
              <td class="row-color6">매출업체</td>
              <td class="row-color6">품목/내역</td>
              <td class="row-color6">금액</td>
              <td class="row-color6">결제일</td>
              <td class="row-color6">End-User</td>
              <td class="row-color6">매입일자</td>
              <td class="row-color6">매입업체</td>
              <td class="row-color6">품목/내역</td>
              <td class="row-color6">금액</td>
              <td class="row-color6">결제일</td>
              <td class="row-color6">세금계산서No.</td>
            </tr>
          </thead>
          <tbody>
        <?php
        if(!empty($distinct_procurement_seq)) {
          foreach($distinct_procurement_seq as $dps) { ?>
    <?php for($i=0; $i<$bill_data_count[$dps['rseq']]; $i++){ ?>
            <tr seq="<?php echo $dps['rseq']; ?>" class="<?php if($dps['cooperation_companyname'] == '더망고'){echo 'mg';} ?>">
      <?php if(isset($procurement_sales_data[$dps['rseq']][$i])){
              $ps = $procurement_sales_data[$dps['rseq']][$i];
              if($ps['rseq'] == 'null') { ?>
                <td colspan="6">N</td>
        <?php } else {
                $color = '';
                if ($ps['deposit_status'] != 'Y') {
                  $t_date = new DateTime($ps['issuance_date']);
                  $diff = date_diff($t_date, $today);
                  if($diff->days > 60) {
                    $color = 'color:red;';
                  }
                } ?>
                <td style="<?php echo $color; ?>" class="tax_approval_number" onclick="go_page('<?php echo $dps['rseq']; ?>')">
                  <?php echo $ps['tax_approval_number']; ?>
                </td>
                <td style="<?php echo $color; ?>"><?php echo $ps['issuance_date']; ?></td>
                <td style="<?php echo $color; ?>"><?php echo $ps['company_name']; ?></td>
                <td style="<?php echo $color; ?>"><?php echo $ps['project_name']; ?></td>
                <td style="<?php echo $color; ?>" class="<?php if($ps['deposit_status']!='Y'){echo 'none_money_s';} ?>"><?php echo number_format($ps['total_amount']); ?></td>
                <td style="<?php echo $color; ?>"><?php if($ps['deposit_status'] == 'Y'){echo $ps['deposit_date'];} ?></td>
        <?php }
            } else { ?>
              <td colspan="6"></td>
      <?php } ?>
              <td class="endUser"><?php echo $dps['customer_companyname']; ?></td>
      <?php if(isset($procurement_purchase_data[$dps['rseq']][$i])){
              $pp = $procurement_purchase_data[$dps['rseq']][$i];
              if($pp['rseq'] == 'null') { ?>
                <td colspan="6">N</td>
        <?php } else {
                $color = '';
                if ($ps['deposit_status'] != 'Y') {
                  $t_date = new DateTime($ps['issuance_date']);
                  $diff = date_diff($t_date, $today);
                  if($diff->days > 60) {
                    $color = 'color:blue;';
                  }
                } ?>
                <td style="<?php echo $color; ?>"><?php echo $pp['issuance_date']; ?></td>
                <td style="<?php echo $color; ?>"><?php echo $pp['company_name']; ?></td>
                <td style="<?php echo $color; ?>"><?php echo $pp['project_name']; ?></td>
                <td style="<?php echo $color; ?>" class="<?php if($pp['deposit_status']!='Y'){echo 'none_money_p';} ?>"><?php echo number_format($pp['total_amount']); ?></td>
                <td style="<?php echo $color; ?>"><?php if($pp['deposit_status'] == 'Y'){echo $pp['deposit_date'];} ?></td>
                <td style="<?php echo $color; ?>" class="tax_approval_number" onclick="go_page('<?php echo $dps['rseq']; ?>')">
                  <?php echo $pp['tax_approval_number']; ?>
                </td>
        <?php }
            } else { ?>
              <td colspan="6"></td>
      <?php } ?>
            </tr>
    <?php } ?>
    <?php }
        }
        ?>
            <tr class="fixed_tr1">
              <td style="background-color:#F2FCFF;font-weight:bold;color:#007BCB;height:40px;" colspan="4">IT 미수금 합계</td>
              <td style="background-color:#F2FCFF;font-weight:bold;color:#007BCB;" id="procurement_sum_s_it">1,000</td>
              <td style="background-color:#F2FCFF"></td>
              <td style="background-color:white;"></td>
              <td style="background-color:#FFEDED;font-weight:bold;color:#E53737;" colspan="3">IT 미지급 합계</td>
              <td style="background-color:#FFEDED;font-weight:bold;color:#E53737;" id="procurement_sum_p_it">1,000</td>
              <td style="background-color:#FFEDED" colspan="2"></td>
            </tr>
            <tr class="fixed_tr2">
              <td style="background-color:#F2FCFF;font-weight:bold;color:#007BCB;height:40px;" colspan="4">MG 미수금 합계</td>
              <td style="background-color:#F2FCFF;font-weight:bold;color:#007BCB;" id="procurement_sum_s_mg">1,000</td>
              <td style="background-color:#F2FCFF"></td>
              <td style="background-color:white;"></td>
              <td style="background-color:#FFEDED;font-weight:bold;color:#E53737;" colspan="3">MG 미지급 합계</td>
              <td style="background-color:#FFEDED;font-weight:bold;color:#E53737;" id="procurement_sum_p_mg">1,000</td>
              <td style="background-color:#FFEDED" colspan="2"></td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
<!--
    <div style="height:100px;">
    </div> -->

  <!-- excel export table -->
  <div class="excel_div" style="display:none;">
    <table class="excel_table">

    </table>
  </div>

  <!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
  <!--하단-->
<script>

  function sort(mode) {
    document.mform.sort_condition.value = mode;
    document.mform.submit();
  }

  // div별 접었다 펴기
  function div_toggle(div, name){
    $('#'+div).slideToggle('slow');
    var img_name = $(name).attr('name');
    if(img_name == 'hide_img'){
      $(name).attr('name','show_img');
      $(name).attr("src", "<?php echo $misc;?>img/btn_down_box.svg");
    }else{
      $(name).attr('name','hide_img');
      $(name).attr("src", "<?php echo $misc;?>img/btn_up_box.svg");
    }
  }

  function go_page(seq) {
    if(seq.indexOf('f_') != -1) {
      seq = seq.replace('f_', '');
      location.href = '<?php echo site_url(); ?>/sales/forcasting/order_completed_view?seq=' + seq;
    } else if(seq.indexOf('r_') != -1) {
      location.href = '<?php echo site_url(); ?>/tech/tech_board/request_tech_support_list';
    } else if (seq.indexOf('m_') != -1) {
      seq = seq.replace('m_', '');

      $.ajax({
        type: 'POST',
        dataType: 'json',
        async: false,
        url: '<?php echo site_url(); ?>/sales/accounts_receivable_unpaid/check_maintain',
        data: {
          seq: seq
        },
        success: function(data) {
          var cnt = data[0]['cnt'];
          if (cnt > 0) {
            var type = '002';
          } else {
            var type = '001';
          }
          location.href = '<?php echo site_url(); ?>/sales/maintain/maintain_view?seq='+seq+'&type='+type;
        }
      })
    }
  }

  // 금액 부분 콤마 추가
  function commaStr(n) {
    var reg = /(^[+-]?\d+)(\d{3})/;
    n += "";

    while (reg.test(n))
      n = n.replace(reg, "$1" + "," + "$2");
    return n;
  }

  function sum_amount(table) {
    var sum_p_it = 0;
    var sum_s_it = 0;
    var sum_p_mg = 0;
    var sum_s_mg = 0;

    $('#'+table+'_purchase_sales').find('.none_money_s').each(function() {
      var m = $.trim($(this).text()).replace(/,/g, "");
      if($(this).closest('tr').attr('class') == 'mg') {
        sum_s_mg += Number(m);
      } else {
        sum_s_it += Number(m);
      }
    });

    $('#'+table+'_purchase_sales').find('.none_money_p').each(function() {
      var m = $.trim($(this).text()).replace(/,/g, "");
      if($(this).closest('tr').attr('class') == 'mg') {
        sum_p_mg += Number(m);
      } else {
        sum_p_it += Number(m);
      }
    });

    $('#'+table+'_sum_s_it').text(commaStr(sum_s_it));
    $('#'+table+'_sum_p_it').text(commaStr(sum_p_it));
    $('#'+table+'_sum_s_mg').text(commaStr(sum_s_mg));
    $('#'+table+'_sum_p_mg').text(commaStr(sum_p_mg));
  }

  $(function() {
    sum_amount('forcasting');
    sum_amount('maintain');
    sum_amount('procurement');

    $('.excel_table').html('');
    excel_table();
  })

  function excel_table() {
    var forcasting_table = $('#fo_div').html();
    var maintain_table = $('#ma_div').html();
    var procurement_table = $('#procure_div').html();

    var excel_download_table = forcasting_table + "<br><br>" + maintain_table + "<br><br>" + procurement_table;

    $('.excel_table').append(excel_download_table);

    $('.excel_table').find('.mg').each(function() {
      $(this).find('td').each(function() {
        $(this).css('color', 'color:rgb(74, 203, 160)');
      })
    })
  }

  function getToday() {
    var date = new Date();
    var year = date.getFullYear();
    var month = ('0' + (1 + date.getMonth())).slice(-2);
    var day = ('0' + date.getDate()).slice(-2);

    return year + '-' + month + '-' + day;
  }

  function excel_export() {
    var title = "미수금미지급" + getToday();

    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
    tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
    tab_text = tab_text + '<x:Name>'+title+'</x:Name>';
    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
    tab_text = tab_text + "<table border='1px'>";

    var exportTable = $('.excel_table').clone();

    exportTable.find('#forcasting_purchase_sales').css('border','solid');
    exportTable.find('#maintain_purchase_sales').css('border','solid');
    exportTable.find('#procurement_purchase_sales').css('border','solid');

    tab_text = tab_text + exportTable.html();
    tab_text = tab_text + '</table></body></html>';

    var data_type = 'data:application/vnd.ms-excel';
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    var fileName = title + '.xls';

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
      if (window.navigator.msSaveBlob) {
        var blob = new Blob([tab_text], {
          type: "application/csv;charset=utf-8;"
        });
        navigator.msSaveBlob(blob, fileName);
      }
    } else {
      var blob2 = new Blob([tab_text], {
        type: "application/csv;charset=utf-8;"
      });
      var filename = fileName;
      var elem = window.document.createElement('a');
      elem.href = window.URL.createObjectURL(blob2);
      elem.download = filename;
      document.body.appendChild(elem);
      elem.click();
      document.body.removeChild(elem);
    }
  }
  </script>
</body>
</html>
