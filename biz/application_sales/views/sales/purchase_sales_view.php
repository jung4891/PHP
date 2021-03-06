<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script type="text/javascript" src="/misc/js/mousetrap.js"></script> <!--  단축키 js -->
<link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css"> <!-- 달력 표시 css (datepicker) -->
<script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script> <!--  달력 표시 js (datepicker) -->
<style>
  .dash_tbl1-1{
    margin:20px;
    display:grid;
  }
  .item_div{
    width: 100%;
    max-height: 800px;
    overflow: auto;
    -ms-overflow-style: none; /*ie, edge*/
    scrollbar-width: none; /*파이어폭스란다*/
  }
  .item_div::-webkit-scrollbar{ /*롬크*/
    display:none;
   }
  .contents_tbl{
    width: 95%;
    /* border-color:black; */
    /* border-style:solid; */
    /* border-width:2px; */
    text-align:center;
    position: relative;
  }
  .contents_tbl thead td{
    font-size:14px;
    font-weight:bold;
    /* border-bottom: 1px solid black; */
    /* background-color:#e8e8e8; */
    position: sticky;
    top:40px;
  }
  .total_sum {
    /* border-top: 1px double black; */
  }
  .contents_tbl:not(.total_tbl) th {
    /* height:30px; */
    font-size: 16px;
    /* background-color: #d4d4d4; */
    /* border-bottom: 1px solid black; */
    position: sticky;
    top:0px;
  }
  .contents_tbl td, .total_tbl th{
    /* border-left-color:black; */
    /* border-left-style:solid; */
    /* border-left-width:1px; */
    /* font-size: 7px; */
    word-break:break-all;
    /* border-bottom: 1px solid; */
  }
  .project_division td{
    /* border-top-color:black; */
    /* border-top-style:solid; */
    /* border-top-width:1px; */
  }
  .fixed_tr td{
    position: sticky;
    bottom:0px;
    /* background-color: #c1e7f7; */
  }
  .fixed_tr3 td{
    position: sticky;
    bottom:80px;
  }
  .fixed_tr2 td {
    position: sticky;
    bottom:40px;
  }
  .blank_td {
    background-color: white;
  }
  #operating_div input, #dbs_ma_div input{
    text-align:center;
    width:90%;
  }
  input:disabled {
    background: white;
    border:none;
  }
  .minus_tr{
    color: red;
  }
  .minus_tr input{
    color: red;
  }
  #operating_div button{
    display:none;
  }
  #dbs_ma_div button{
    display:none;
  }
  .td_input{
    display:none;
  }
  .p_tax_approval_number, .s_tax_approval_number{
    cursor:pointer;
  }

  .operating_td {
    font-size: 10px !important;
  }

/* 세금계산서 우클릭 메모입력 선택 */
  .contextmenu {
  display: none;
  position: absolute;
  min-width: 200px;
  margin: 0;
  padding: 0;
  background: #FFFFFF;
  border-radius: 5px;
  list-style: none;
  box-shadow:
    0 15px 35px rgba(50,50,90,0.1),
    0 5px 15px rgba(0,0,0,0.07);
  overflow: hidden;
  z-index: 999999;
}
.contextmenu li {
  border-left: 3px solid transparent;
  transition: ease .2s;
}
.contextmenu li a {
  display: block;
  padding: 10px;
  color: #B0BEC5;
  text-decoration: none;
  transition: ease .2s;
}
.contextmenu li:hover {
  background: #CE93D8;
  border-left: 3px solid #9C27B0;
}
.contextmenu li:hover a {
  color: #FFFFFF;
}
.is_memo {
  border-left: 5px solid #007BCB;
  border-right: 5px solid #007BCB;
}

.is_memo {
  position: relative;
  /* display: inline-block; */
  /* border-bottom: 1px dotted black; */
}

.is_memo .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: #e1f5f5;
  /* color: #fff; */
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;

  /* Position the tooltip */
  position: absolute;
  z-index: 1;
}

.is_memo:hover .tooltiptext {
  visibility: visible;
}
</style>
<body>
  <?php
    include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
  ?>

  <!-- <div align="center"> -->
  <div class="dash1-1" align="center">
	  <div>
      <table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
		    <tr height="5%">
        	<td class="dash_title">
          	월별 매입매출장
          </td>
        </tr>
        <tr>
          <td height="70"></td>
        </tr>
      </table>
		</div>

    <div style="margin-bottom:30px;">
      <table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
        <tr style="width:100%;">
          <td style="width:50%;">
            <form class="month_form" name="month_form" action="<?php echo site_url();?>/sales/purchase_sales/purchase_sales_view" method="get">
              <select class="select-common" id="company" name="company" onchange="quarter_change();" style="width: 160px;margin-right:10px;">
<?php
  if(isset($_GET['company'])){
    $get_company = $_GET['company'];
  }else {
    $get_company = "DUIT";
  }
?>
                <option value="DUIT" <?php if ($get_company == "DUIT") { echo "selected"; }?>>두리안정보기술</option>
                <option value="ICT" <?php if ($get_company == "ICT") { echo "selected"; }?>>두리안정보통신기술</option>
                <option value="MG" <?php if ($get_company == "MG") { echo "selected"; }?>>더망고</option>
                <option value="DBS" <?php if ($get_company == "DBS") { echo "selected"; }?>>두리안정보기술부산지점</option>
              </select>
              <select class="select-common" name="year" id="select_year" style="margin-right:10px;width:100px;">
<?php
  if(isset($_GET['year'])){
    $toYear = $_GET['year'];
  }else{
    $toYear =date('Y');
  }
?>
                <!-- <option value="<?php echo $toYear ?>" selected><?php echo $toYear ?>년</option> -->
                <?php for($i = 2020; $i < date('Y')+2; $i ++) { ?>
                  <option value="<?php echo $i; ?>" <?php if($i == $toYear){echo 'selected';} ?>><?php echo $i ?>년</option>
                <?php } ?>
              </select>
              <select class="select-common" name="month" id="select_month" style="margin-right:10px;width:100px;">
<?php
  if(isset($_GET['month'])){
    $month = $_GET['month'];
  }else{
    $month = date('m');
  }
  for($i=1; $i<=12; $i++){
?>
                <option value="<?php echo sprintf('%02d',$i); ?>" <?php echo $month == $i ? 'selected': ''?>><?php echo $i; ?>월</option>
<?php } ?>
              </select>
              <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_search.svg" height="23" onclick ="return GoSearch();" style="cursor:pointer;vertical-align:top;" > -->
              <input class="btn-common btn-style2" type="button" onclick="return GoSearch();" value="검색" >
            </form>
          </td>
          <td style="width:50%; text-align:right;">
            <!-- <img src="<?php echo $misc; ?>/img/dashboard/btn/excel_download.png" alt="" style="margin-right: 5%; cursor: pointer;" onclick="excel_export();"> -->
            <input class="btn-common btn-updownload" type="button" onclick="excel_export();" value="엑셀 다운로드" style="width:150px;padding-left:20px;width:auto;position: relative;left: 20px;">
            <img src="/misc/img/download_btn.svg" style="width:12px;position:relative;top: 6px;right: 90px;padding: 2px;">
          </td>
        </tr>
      </table>
    </div>

    <!-- 합계 황현빈 추가 -->

    <span align="left" style="float:left;margin-left:2.5%;margin-bottom:10px;">
      <img width="25" name="hide_img" src="<?php echo $misc; ?>/img/btn_up_box.svg" onclick="div_toggle('to_div', this);" style="cursor:pointer;">
    </span>
    <div class="item_div" id="to_div">
      <table class="contents_tbl total_tbl" id="total_table" cellspacing=0 cellpadding=0>
        <colgroup>
          <col width="5%" /><!-- 구분-->
          <col width="7%" /> <!-- 공급가액-->
          <col width="7%" /> <!-- 세액-->
          <col width="7%" /> <!-- 합계 -->
          <col width="5%" /> <!-- 구분 -->
          <col width="8%" /> <!--국세청전송건수-->
          <col width="5%" /> <!--구분-->
          <col width="8%" /> <!--국세청전송건수-->
          <col width="9%" /> <!--공백-->
          <col width="5%" /> <!--구분-->
          <col width="7%" /> <!--공급가액-->
          <col width="7%" /> <!-- 세액 -->
          <col width="7%" /> <!--합계-->
          <col width="5%" /> <!--구분-->
          <col width="8%" /> <!--국세청전송건수-->
        </colgroup>
        <thead>
          <th class="row-color6">구분</th>
          <th class="row-color6">공급가액</th>
          <th class="row-color6">세액</th>
          <th class="row-color6">합계</th>
          <th class="row-color6">구분</th>
          <th class="row-color6">국세청전송건수</th>
          <th class="row-color6">구분</th>
          <th class="row-color6">국세청전송건수</th>
          <th class="row-color6" style="border-bottom:none"></th>
          <th class="row-color6">구분</th>
          <th class="row-color6">공급가액</th>
          <th class="row-color6">세액</th>
          <th class="row-color6">합계</th>
          <th class="row-color6">구분</th>
          <th class="row-color6">국세청전송건수</th>
        </thead>
        <tbody>
<?php
  // var_dump($maintain_ext);
  $sum_type = array('forcasting', 'maintain', 'procurement', 'operating');
  $category = array('상품', '용역', '조달', '운영비');
  $category2 = array('전자계산서', '종이계산서', '', '');
  for ($i=0; $i<count($category); $i++){
    $data = array();
?>
          <tr>
            <td>
              <?php echo $category[$i]; if($i<3){echo '매입';} ?>
            </td>
            <td class="total_num iss_in" id="<?php echo $sum_type[$i]."_sum_iss_in"; ?>" align="right" style="padding-right:5px"></td>
            <td class="total_num tax_in" id="<?php echo $sum_type[$i]."_sum_tax_in"; ?>" align="right" style="padding-right:5px"></td>
            <td class="total_num sum_in" id="<?php echo $sum_type[$i]."_sum_total_in"; ?>" align="right" style="padding-right:5px"></td>
            <td>
              <?php echo $category[$i]; if($i<3){echo '매입';} ?>
            </td>
            <td class="total_num cnt_in" id="<?php echo $sum_type[$i]."_p_cnt"; ?>" align="right" style="padding-right:5px"></td>
            <td>
              <?php echo $category2[$i]; ?>
            </td>
            <td <?php if($i<2){echo 'class="total_num" align="right" style="padding-right:5px"';} ?>>
              <?php if(isset($sum_bill_cnt[$i])){echo $sum_bill_cnt[$i]['cnt'];} ?>
            </td>
            <td></td>
            <td>
              <?php echo $category[$i]; if($i<3){echo '매출';} ?>
            </td>
            <td class="total_num iss_out" id="<?php echo $sum_type[$i]."_sum_iss_out"; ?>" align="right" style="padding-right:5px"></td>
            <td class="total_num tax_out" id="<?php echo $sum_type[$i]."_sum_tax_out"; ?>" align="right" style="padding-right:5px"></td>
            <td class="total_num sum_out" id="<?php echo $sum_type[$i]."_sum_total_out"; ?>" align="right" style="padding-right:5px"></td>
            <td>
              <?php echo $category[$i]; if($i<3){echo '매출';} ?>
            </td>
            <td class="total_num cnt_out" id="<?php echo $sum_type[$i]."_s_cnt"; ?>" align="right" style="padding-right:5px"></td>
          </tr>
<?php
  }
?>
          <tr>
            <td class="total_sum row-color4">매입액</td>
            <td class="total_sum row-color4" id="total_sum_iss_in" align="right" style="padding-right:5px;"></td>
            <td class="total_sum row-color4" id="total_sum_tax_in" align="right" style="padding-right:5px;"></td>
            <td class="total_sum row-color4" id="total_sum_sum_in" align="right" style="padding-right:5px;"></td>
            <td class="total_sum" style="padding-right:5px">총계</td>
            <td class="total_sum" id="total_sum_count_in" align="right" style="padding-right:5px"></td>
            <td colspan="2"></td>
            <td></td>
            <td class="total_sum row-color3">매출액</td>
            <td class="total_sum row-color3" id="total_sum_iss_out" align="right" style="padding-right:5px;"></td>
            <td class="total_sum row-color3" id="total_sum_tax_out" align="right" style="padding-right:5px;"></td>
            <td class="total_sum row-color3" id="total_sum_sum_out" align="right" style="padding-right:5px;"></td>
            <td class="total_sum" style="padding-right:5px">총계</td>
            <td class="total_sum" id="total_sum_count_out" align="right" style="padding-right:5px"></td>
          </tr>
        </tbody>
      </table>
    </div>

<?php
  if($get_company != 'DBS') {
?>
<!-- 매입매출 (상품) -->
    <span align="left" style="float:left;margin-left:2.5%;margin-bottom:10px;margin-top:20px;">
      <img width="25" name="hide_img" src="<?php echo $misc;?>img/btn_up_box.svg" onclick="div_toggle('fo_div', this);" style="cursor:pointer;">
    </span>
    <div class="item_div" id="fo_div">
      <table id="forcasting_purchase_sales" class="contents_tbl" cellspacing=0 cellpadding=5>
        <colgroup>
          <col width="3%" /><!-- 사업부-->
          <col width="10%" /> <!-- 계삼서no-->
          <col width="5%" /> <!-- 일자-->
          <col width="5%" /> <!-- 매입처 -->
          <col width="9%" /> <!-- 품목 -->
          <col width="5%" /> <!--공급가액-->
          <col width="5%" /> <!--세액-->
          <col width="5%" /> <!--합계-->
          <col width="9%" /> <!--엔드유저-->
          <col width="5%" /> <!--일자-->
          <col width="5%" /> <!--매출처-->
          <col width="9%" /> <!-- 품목 -->
          <col width="5%" /> <!--공급가액-->
          <col width="5%" /> <!--세액-->
          <col width="5%" /> <!--합계-->
          <col width="10%" /> <!--세금계산서넘버-->
        </colgroup>
        <thead>
          <tr>
            <!-- type 002 -->
            <th colspan="8">매입(상품)</th>
            <th></th>
            <!-- type 001 -->
            <th colspan="7">매출(상품)</th>
          </tr>
          <tr>
            <td class="row-color6">사업부</td>
            <td class="row-color6">세금계산서No.</td>
            <td class="row-color6">일자</td>
            <td class="row-color6">매입처</td>
            <td class="row-color6">품목</td>
            <td class="row-color6">공급가액</td>
            <td class="row-color6">세액</td>
            <td class="row-color6">합계</td>
            <td class="row-color6">End-User</td>
            <td class="row-color6">일자</td>
            <td class="row-color6">매출처</td>
            <td class="row-color6">품목</td>
            <td class="row-color6">공급가액</td>
            <td class="row-color6">세액</td>
            <td class="row-color6">합계</td>
            <td class="row-color6">세금계산서No</td>
          </tr>
        </thead>
        <tbody>
<?php
  $idx=0;
  foreach($distinct_forcasting_seq as $dms){
    $p_n=0;
    for($i=0; $i<count($forcasting_val); $i++){
      if($dms['rseq'] == $forcasting_val[$i]['rseq']){
        $p_n++;
      }
    }
    $s_n=0;
    for($i=0; $i<count($forcasting_val2); $i++){
      if($dms['rseq'] == $forcasting_val2[$i]['s_rseq']){
        $s_n++;
      }
    }
    $row_cnt = $p_n >= $s_n ? $p_n : $s_n;
    $purchase_row =array();
    $purchase_cnt =0;
    $sales_row = array();
    $sales_cnt = 0;
    for($i=0; $i<count($forcasting_val); $i++){
      if($dms['rseq'] == $forcasting_val[$i]['rseq']){
        $style="";
        $class="";
        if($toYear."-".$month != date('Y-m',strtotime($forcasting_val[$i]['issuance_date'])) && $forcasting_val[$i]['issuance_status'] == "M"){
          $style ="style='background-color:#FFFFF2;color:red;'";
          $class = "no";
        }else if($toYear."-".$month != date('Y-m',strtotime($forcasting_val[$i]['issuance_date'])) && $forcasting_val[$i]['issuance_status'] != "M"){
          $style="style='background-color:#FFFFF2;'";
          $class = "no";
        }else if($toYear."-".$month == date('Y-m',strtotime($forcasting_val[$i]['issuance_date'])) && $forcasting_val[$i]['issuance_status'] == "M"){
          $style="style='color:red;'";
        }
          // $style = $toYear."-".$month != date('Y-m',strtotime($forcasting_val[$i]['issuance_date'])) ? "style='background-color:#FFFFF2'" : "" ;
          $issuance_amount = $forcasting_val[$i]['issuance_amount'] == "" ? "" : number_format($forcasting_val[$i]['issuance_amount']);
          $tax_amount = $forcasting_val[$i]['tax_amount'] == "" ? "" : number_format($forcasting_val[$i]['tax_amount']);
          $total_amount = $forcasting_val[$i]['total_amount'] == "" ? "" : number_format($forcasting_val[$i]['total_amount']);
          $text ="<td class='p_tax_approval_number' {$style} seq='{$dms['rseq']}' onclick='go_detail(this);'><p>{$forcasting_val[$i]['tax_approval_number']}</p></td>
          <td class='p_issuance_date' {$style}>{$forcasting_val[$i]['issuance_date']}</td>
          <td class='p_company_name' {$style} >{$forcasting_val[$i]['company_name']}</td>
          <td class='p_project_name' {$style} >{$dms['project_name']}</td>";
          if($class != "no"){
            $text.="<td class='p_issuance_amount' {$style} >{$issuance_amount}</td>";
          }else{
            $text.="<td {$style}>{$issuance_amount}</td>";
          }

          if($class != "no"){
            $text.="<td class='p_tax_amount' {$style} >{$tax_amount}</td>";
          }else{
            $text.="<td {$style}>{$tax_amount}</td>";
          }

          if($class != "no"){
            $text.="<td class='p_total_amount' {$style} >{$total_amount}</td>";
          }else{
            $text.="<td {$style}>{$total_amount}</td>";
          }

          $purchase_row[$purchase_cnt] = $text;
          $purchase_cnt++;
      }
    }
    for($i=0; $i<count($forcasting_val2); $i++){
      if($dms['rseq'] == $forcasting_val2[$i]['s_rseq']){
        $style="";
        $class="";
        if($toYear."-".$month != date('Y-m',strtotime($forcasting_val2[$i]['s_issuance_date'])) && $forcasting_val2[$i]['s_issuance_status'] == "M"){
          $style ="style='background-color:#FFFFF2;color:red;'";
          $class="no";
        }else if($toYear."-".$month != date('Y-m',strtotime($forcasting_val2[$i]['s_issuance_date'])) && $forcasting_val2[$i]['s_issuance_status'] != "M"){
          $style="style='background-color:#FFFFF2;'";
          $class="no";
        }else if($toYear."-".$month == date('Y-m',strtotime($forcasting_val2[$i]['s_issuance_date'])) && $forcasting_val2[$i]['s_issuance_status'] == "M"){
          $style="style='color:red;'";
        }
        // $style = $toYear."-".$month != date('Y-m',strtotime($forcasting_val2[$i]['s_issuance_date'])) && $forcasting_val2[$i]['s_issuance_status']  ? "style='background-color:#FFFFF2'" : "" ;
        $issuance_amount = $forcasting_val2[$i]['s_issuance_amount'] == "" ? "" : number_format($forcasting_val2[$i]['s_issuance_amount']);
        $tax_amount = $forcasting_val2[$i]['s_tax_amount'] == "" ? "" : number_format($forcasting_val2[$i]['s_tax_amount']);
        $total_amount = $forcasting_val2[$i]['s_total_amount'] == "" ? "" : number_format($forcasting_val2[$i]['s_total_amount']);

        $text="<td class='s_issuance_date'{$style}>{$forcasting_val2[$i]['s_issuance_date']} </td>
          <td class='s_company_name' {$style}>{$forcasting_val2[$i]['s_company_name']} </td>
          <td class='s_project_name' {$style}>{$dms['project_name']} </td>";
          if($class != "no"){
            $text.="<td class='s_issuance_amount' {$style}>{$issuance_amount}</td>";
          }else{
            $text.="<td {$style}>{$issuance_amount}</td>";
          }

          if($class != "no"){
            $text.="<td class='s_tax_amount' {$style} >{$tax_amount}</td>";
          }else{
            $text.="<td {$style}>{$tax_amount}</td>";
          }

          if($class != "no"){
            $text.="<td class='s_total_amount' {$style} >{$total_amount}</td>";
          }else{
            $text.="<td {$style}>{$total_amount}</td>";
          }

          $text .= "<td class='s_tax_approval_number' {$style} seq='{$dms['rseq']}' onclick='go_detail(this);'><p>{$forcasting_val2[$i]['s_tax_approval_number']}</p></td>";
          $sales_row[$sales_cnt] = $text;
          $sales_cnt++;
      }
    }
    if ($sales_cnt == 0){
        for($j=0; $j<$row_cnt; $j++){
          echo "<tr>";
          echo "<td class='dept'>{$dms['dept']}</td>";
          if(isset($purchase_row[$j])){
            echo $purchase_row[$j];
          }else{
            echo "<td colspan=7></td>";
          }
          echo "<td class='customer_companyname row-color6'>{$dms['customer_companyname']}</td>";
          if(isset($sales_row[$j])){
            echo $sales_row[$j];
          }else{
            if(strpos($dms['exception_saledate'],$toYear."-".$month) === false){
              echo "<td colspan=7 style='background-color:#FFFFF2'>";
              echo date('Y-m',strtotime($dms['exception_saledate']));
              echo " 매출</td>";
            }else{
              echo "<td colspan=7>";
              echo "</td>";
            }
          }
          echo "</tr>";
        }
      } else {
        for($j=0; $j<$row_cnt; $j++){
          echo "<tr>";
          echo "<td class='dept'>{$dms['dept']}</td>";
          if(isset($purchase_row[$j])){
            echo $purchase_row[$j];
          }else{
            echo "<td colspan=7></td>";
          }
          echo "<td class='customer_companyname row-color6'>{$dms['customer_companyname']}</td>";

          if(isset($sales_row[$j])){
            echo $sales_row[$j];
          }else{
              echo "<td colspan=7></td>";
          }
          echo "</tr>";
        }
      }

        $i = $i+$sales_cnt+$purchase_cnt;
    $idx++;
  }
?>
          <tr class="project_division fixed_tr">
            <td colspan= "5" class="row-color4">합 계</td>
            <td class="p_sum_issuance_amount row-color4">공급가액더하기</td>
            <td class="p_sum_tax_amount row-color4">세액더하기</td>
            <td class="p_sum_total_amount row-color4">합계더하기</td>
            <td class="row-color5"></td>
            <td colspan="3" class="row-color3">합 계</td>
            <td class="s_sum_issuance_amount row-color3">공급가액더하기</td>
            <td class="s_sum_tax_amount row-color3">세액더하기</td>
            <td class="s_sum_total_amount row-color3">합계더하기</td>
            <td class="row-color3"></td>
          </tr>
        </tbody>
      </table>
    </div>

    <span align="left" style="float:left;margin-left:2.5%;margin-bottom:10px;margin-top:20px;">
      <img width="25" name="hide_img" src="<?php echo $misc;?>img/btn_up_box.svg" onclick="div_toggle('ma_div', this);" style="cursor:pointer;">
    </span>
    <div class="item_div" id="ma_div">
      <table id="maintain_purchase_sales" class="contents_tbl" cellspacing=0 cellpadding=5>
        <colgroup>
          <col width="5%" /><!-- 사업부-->
          <col width="9%" /> <!-- 계삼서no-->
          <col width="5%" /> <!-- 일자-->
          <col width="5%" /> <!-- 매입처 -->
          <col width="9%" /> <!-- 품목 -->
          <col width="5%" /> <!--공급가액-->
          <col width="5%" /> <!--세액-->
          <col width="5%" /> <!--합계-->
          <col width="9%" /> <!--엔드유저-->
          <col width="5%" /> <!--일자-->
          <col width="5%" /> <!--매출처-->
          <col width="9%" /> <!-- 품목 -->
          <col width="5%" /> <!--공급가액-->
          <col width="5%" /> <!--세액-->
          <col width="5%" /> <!--합계-->
          <col width="9%" /> <!--세금계산서넘버-->
        </colgroup>
        <thead>
          <tr>
            <th colspan="8">매입(용역)</th>
            <th></th>
            <th colspan="7">매출(용역)</th>
          </tr>
          <tr>
            <td class="row-color6">사업부</td>
            <td class="row-color6">세금계산서No.</td>
            <td class="row-color6">일자</td>
            <td class="row-color6">매입처</td>
            <td class="row-color6">품목</td>
            <td class="row-color6">공급가액</td>
            <td class="row-color6">세액</td>
            <td class="row-color6">합계</td>
            <td class="row-color6">End-User</td>
            <td class="row-color6">일자</td>
            <td class="row-color6">매출처</td>
            <td class="row-color6">품목</td>
            <td class="row-color6">공급가액</td>
            <td class="row-color6">세액</td>
            <td class="row-color6">합계</td>
            <td class="row-color6">세금계산서No</td>
          </tr>
        </thead>
        <tbody>
<?php
  $idx=0;
  foreach($distinct_maintain_seq as $dms){
    $row_cnt = 0;
    $purchase_row =array();
    $purchase_cnt =0;
    $sales_row =array();
    $sales_cnt =0;
    for($i=0; $i<count($maintain_val); $i++){
      if($dms['rseq'] == $maintain_val[$i]['rseq']){
        if($row_cnt < $maintain_val[$i]['cnt']){
          $row_cnt = $maintain_val[$i]['cnt'] ;
        }
        if($maintain_val[$i]['type'] == "002"){
          $issuance_amount = $maintain_val[$i]['issuance_amount'] == "" ? "" : number_format($maintain_val[$i]['issuance_amount']);
          $tax_amount = $maintain_val[$i]['tax_amount'] == "" ? "" : number_format($maintain_val[$i]['tax_amount']);
          $total_amount = $maintain_val[$i]['total_amount'] == "" ? "" : number_format($maintain_val[$i]['total_amount']);
          $purchase_row[$purchase_cnt] =
          "<td class='p_tax_approval_number' seq='{$dms['rseq']}' onclick='go_detail(this);'><p>{$maintain_val[$i]['tax_approval_number']}</p></td>
          <td class='p_issuance_date'>{$maintain_val[$i]['issuance_date']}</td>
          <td class='p_company_name'>{$maintain_val[$i]['company_name']}</td>
          <td class='p_project_name'>{$dms['project_name']}</td>
          <td class='p_issuance_amount'>{$issuance_amount}</td>
          <td class='p_tax_amount'>{$tax_amount}</td>
          <td class='p_total_amount'>{$total_amount}</td>";
          $purchase_cnt++;
        }

        if($maintain_val[$i]['type'] == "001"){
          $issuance_amount = $maintain_val[$i]['issuance_amount'] == "" ? "" : number_format($maintain_val[$i]['issuance_amount']);
          $tax_amount = $maintain_val[$i]['tax_amount'] == "" ? "" : number_format($maintain_val[$i]['tax_amount']);
          $total_amount = $maintain_val[$i]['total_amount'] == "" ? "" : number_format($maintain_val[$i]['total_amount']);
          $sales_row[$sales_cnt] =
           "<td class='s_issuance_date'>{$maintain_val[$i]['issuance_date']} </td>
            <td class='s_company_name'>{$maintain_val[$i]['company_name']} </td>
            <td class='s_project_name'>{$dms['project_name']} </td>
            <td class='s_issuance_amount'>{$issuance_amount}</td>
            <td class='s_tax_amount'>{$tax_amount}</td>
            <td class='s_total_amount'>{$total_amount}</td>
            <td class='s_tax_approval_number' seq='{$dms['rseq']}' onclick='go_detail(this);'><p>{$maintain_val[$i]['tax_approval_number']}</p></td>";
            $sales_cnt++;
        }
      }
    }
    // echo "<script>console.log('{$idx},{$dms['customer_companyname']},{$row_cnt},{$purchase_cnt},{$sales_cnt}')</script>";
    for($i=0; $i<count($maintain_val); $i++){


      if($dms['rseq'] == $maintain_val[$i]['rseq']){
        for($j=0; $j<$row_cnt; $j++){
          echo "<tr>";
          echo "<td class='dept'>{$dms['dept']}</td>";
          if(isset($purchase_row[$j])){
            echo $purchase_row[$j];
          }else{
            echo "<td colspan=7></td>";
          }
          echo "<td class='customer_companyname row-color6'>{$dms['customer_companyname']}</td>";
          if(isset($sales_row[$j])){
            echo $sales_row[$j];
          }else{
            echo "<td colspan=7></td>";
          }
          echo "</tr>";
        }
        $i = $i+$sales_cnt+$purchase_cnt;
      }
    }
    $idx++;
  }
  foreach ($req_maintain_val as $rmv) {
    $issuance_amount = $rmv['issuance_amount'] == "" ? "" : number_format($rmv['issuance_amount']);
    $tax_amount = $rmv['tax_amount'] == "" ? "" : number_format($rmv['tax_amount']);
    $total_amount = $rmv['total_amount'] == "" ? "" : number_format($rmv['total_amount']);
    if (strpos($rmv['approval_doc_name'], ']') !== false) {
      $approval_doc_name = explode(']',$rmv['approval_doc_name']);
      $approval_doc_name = $approval_doc_name[1];
    } else {
      $approval_doc_name = $rmv['approval_doc_name'];
    }
    echo "<tr>";
    echo "<td class='dept'>{$rmv['dept']}</td>";
    echo "<td class='p_tax_approval_number' onclick='go_requset();'><p>{$rmv['tax_approval_number']}</p></td>";
    echo "<td class='p_issuance_date'>{$rmv['issuance_date']}</td>";
    echo "<td class='p_company_name'>{$rmv['cooperative_company']}</td>";
    echo "<td class='p_project_name'>{$approval_doc_name}</td>";
    echo "<td class='p_issuance_amount'>{$issuance_amount}</td>";
    echo "<td class='p_tax_amount'>{$tax_amount}</td>";
    echo "<td class='p_total_amount'>{$total_amount}</td>";
    echo "<td class='customer_companyname row-color6'>{$rmv['customer_company']}</td>";
    echo "<td colspan=7></td>";
    echo "</tr>";
  }
?>

          <tr class="project_division fixed_tr">
            <td colspan= "5" class="row-color4">합 계</td>
            <td class="p_sum_issuance_amount row-color4">공급가액더하기</td>
            <td class="p_sum_tax_amount row-color4">세액더하기</td>
            <td class="p_sum_total_amount row-color4">합계더하기</td>
            <td class="row-color5"></td>
            <td colspan= "3" class="row-color3">합 계</td>
            <td class="s_sum_issuance_amount row-color3">공급가액더하기</td>
            <td class="s_sum_tax_amount row-color3">세액더하기</td>
            <td class="s_sum_total_amount row-color3">합계더하기</td>
            <td class="row-color3"></td>
          </tr>
        </tbody>
      </table>
    </div>

    <span align="left" style="float:left;margin-left:2.5%;margin-bottom:10px;margin-top:20px;">
      <img width="25" name="hide_img" src="<?php echo $misc;?>img/btn_up_box.svg" onclick="div_toggle('procure_div', this);" style="cursor:pointer;">
    </span>
    <div class="item_div" id="procure_div">
      <table id="procurement_purchase_sales" class="contents_tbl" cellspacing=0 cellpadding=5>
        <colgroup>
          <col width="5%" /><!-- 사업부-->
          <col width="9%" /> <!-- 계삼서no-->
          <col width="5%" /> <!-- 일자-->
          <col width="5%" /> <!-- 매입처 -->
          <col width="9%" /> <!-- 품목 -->
          <col width="5%" /> <!--공급가액-->
          <col width="5%" /> <!--세액-->
          <col width="5%" /> <!--합계-->
          <col width="9%" /> <!--엔드유저-->
          <col width="5%" /> <!--일자-->
          <col width="5%" /> <!--매출처-->
          <col width="9%" /> <!-- 품목 -->
          <col width="5%" /> <!--공급가액-->
          <col width="5%" /> <!--세액-->
          <col width="5%" /> <!--합계-->
          <col width="9%" /> <!--세금계산서넘버-->
        </colgroup>
        <thead>
          <tr>
            <!-- type 002 -->
            <th colspan="8">매입(조달)</th>
            <th></th>
            <!-- type 001 -->
            <th colspan="7">매출(조달)</th>
          </tr>
          <tr>
            <td class="row-color6">사업부</td>
            <td class="row-color6">세금계산서No.</td>
            <td class="row-color6">일자</td>
            <td class="row-color6">매입처</td>
            <td class="row-color6">품목</td>
            <td class="row-color6">공금가액</td>
            <td class="row-color6">세액</td>
            <td class="row-color6">합계</td>
            <td class="row-color6">End-User</td>
            <td class="row-color6">일자</td>
            <td class="row-color6">매출처</td>
            <td class="row-color6">품목</td>
            <td class="row-color6">공급가액</td>
            <td class="row-color6">세액</td>
            <td class="row-color6">합계</td>
            <td class="row-color6">세금계산서No</td>
          </tr>
        </thead>
        <tbody>
        <?php
  $idx=0;
  foreach($distinct_procurement_seq as $dms){
    $p_n=0;
    for($i=0; $i<count($procurement_val); $i++){
      if($dms['rseq'] == $procurement_val[$i]['rseq']){
        $p_n++;
      }
    }
    $s_n=0;
    for($i=0; $i<count($procurement_val2); $i++){
      if($dms['rseq'] == $procurement_val2[$i]['s_rseq']){
        $s_n++;
      }
    }
    $row_cnt = $p_n >= $s_n ? $p_n : $s_n;
    $purchase_row =array();
    $purchase_cnt =0;
    $sales_row = array();
    $sales_cnt = 0;
    for($i=0; $i<count($procurement_val); $i++){
      if($dms['rseq'] == $procurement_val[$i]['rseq']){
        $style="";
        $class="";
        if($toYear."-".$month != date('Y-m',strtotime($procurement_val[$i]['issuance_date'])) && $procurement_val[$i]['issuance_status'] == "M"){
          $style ="style='background-color:#FFFFF2;color:red;'";
          $class="no";
        }else if($toYear."-".$month != date('Y-m',strtotime($procurement_val[$i]['issuance_date'])) && $procurement_val[$i]['issuance_status'] != "M"){
          $style="style='background-color:#FFFFF2;'";
          $class="no";
        }else if($toYear."-".$month == date('Y-m',strtotime($procurement_val[$i]['issuance_date'])) && $procurement_val[$i]['issuance_status'] == "M"){
          $style="style='color:red;'";
        }
        // $style = $toYear."-".$month != date('Y-m',strtotime($procurement_val[$i]['issuance_date'])) ? "style='background-color:#FFFFF2'" : "" ;
          $issuance_amount = $procurement_val[$i]['issuance_amount'] == "" ? "" : number_format($procurement_val[$i]['issuance_amount']);
          $tax_amount = $procurement_val[$i]['tax_amount'] == "" ? "" : number_format($procurement_val[$i]['tax_amount']);
          $total_amount = $procurement_val[$i]['total_amount'] == "" ? "" : number_format($procurement_val[$i]['total_amount']);
          $text ="<td class='p_tax_approval_number' {$style} seq='{$dms['rseq']}' onclick='go_detail(this);'><p>{$procurement_val[$i]['tax_approval_number']}</p></td>
          <td class='p_issuance_date' {$style}>{$procurement_val[$i]['issuance_date']}</td>
          <td class='p_company_name' {$style} >{$procurement_val[$i]['company_name']}</td>
          <td class='p_project_name' {$style} >{$dms['project_name']}</td>";
          if($class != "no"){
            $text.="<td class='p_issuance_amount' {$style} >{$issuance_amount}</td>";
          }else{
            $text.="<td {$style}>{$issuance_amount}</td>";
          }

          if($class != "no"){
            $text.="<td class='p_tax_amount' {$style} >{$tax_amount}</td>";
          }else{
            $text.="<td {$style}>{$tax_amount}</td>";
          }

          if($class != "no"){
            $text.="<td class='p_total_amount' {$style} >{$total_amount}</td>";
          }else{
            $text.="<td {$style}>{$total_amount}</td>";
          }

          $purchase_row[$purchase_cnt] = $text;
          $purchase_cnt++;
      }
    }
    for($i=0; $i<count($procurement_val2); $i++){
      if($dms['rseq'] == $procurement_val2[$i]['s_rseq']){
        $style="";
        $class="";
        if($toYear."-".$month != date('Y-m',strtotime($procurement_val2[$i]['s_issuance_date'])) && $procurement_val2[$i]['s_issuance_status'] == "M"){
          $style ="style='background-color:#FFFFF2;color:red;'";
          $class = "no";
        }else if($toYear."-".$month != date('Y-m',strtotime($procurement_val2[$i]['s_issuance_date'])) && $procurement_val2[$i]['s_issuance_status'] != "M"){
          $style="style='background-color:#FFFFF2;'";
          $class = "no";
        }else if($toYear."-".$month == date('Y-m',strtotime($procurement_val2[$i]['s_issuance_date'])) && $procurement_val2[$i]['s_issuance_status'] == "M"){
          $style="style='color:red;'";
        }
        // $style = $toYear."-".$month != date('Y-m',strtotime($procurement_val2[$i]['s_issuance_date'])) ? "style='background-color:#FFFFF2'" : "" ;
        $issuance_amount = $procurement_val2[$i]['s_issuance_amount'] == "" ? "" : number_format($procurement_val2[$i]['s_issuance_amount']);
        $tax_amount = $procurement_val2[$i]['s_tax_amount'] == "" ? "" : number_format($procurement_val2[$i]['s_tax_amount']);
        $total_amount = $procurement_val2[$i]['s_total_amount'] == "" ? "" : number_format($procurement_val2[$i]['s_total_amount']);

        $text="<td class='s_issuance_date'{$style}>{$procurement_val2[$i]['s_issuance_date']} </td>
          <td class='s_company_name' {$style}>{$procurement_val2[$i]['s_company_name']} </td>
          <td class='s_project_name' {$style}>{$dms['project_name']} </td>";
          if($class != "no"){
            $text.="<td class='s_issuance_amount' {$style}>{$issuance_amount}</td>";
          }else{
            $text.="<td {$style}>{$issuance_amount}</td>";
          }

          if($class != "no"){
            $text.="<td class='s_tax_amount' {$style} >{$tax_amount}</td>";
          }else{
            $text.="<td {$style}>{$tax_amount}</td>";
          }

          if($class != "no"){
            $text.="<td class='s_total_amount' {$style} >{$total_amount}</td>";
          }else{
            $text.="<td {$style}>{$total_amount}</td>";
          }

          $text .= "<td class='s_tax_approval_number' {$style} seq='{$dms['rseq']}' onclick='go_detail(this);'><p>{$procurement_val2[$i]['s_tax_approval_number']}</p></td>";
          $sales_row[$sales_cnt] = $text;
          $sales_cnt++;
      }
    }
    if ($sales_cnt == 0) {
      for($j=0; $j<$row_cnt; $j++){
        echo "<tr>";
        echo "<td class='dept'>{$dms['dept']}</td>";
        if(isset($purchase_row[$j])){
          echo $purchase_row[$j];
        }else{
          echo "<td colspan=7></td>";
        }
        echo "<td class='customer_companyname row-color6'>{$dms['customer_companyname']}</td>";
        if(isset($sales_row[$j])){
          echo $sales_row[$j];
        }else{
          if(strpos($dms['exception_saledate'],$toYear."-".$month) === false){
            echo "<td colspan=7 style='background-color:#FFFFF2'>";
            echo date('Y-m',strtotime($dms['exception_saledate']));
            echo " 매출</td>";
          }else{
            echo "<td colspan=7>";
            echo "</td>";
          }
        }
        echo "</tr>";
      }
    } else {
      for($j=0; $j<$row_cnt; $j++){
        echo "<tr>";
        echo "<td class='dept'>{$dms['dept']}</td>";
        if(isset($purchase_row[$j])){
          echo $purchase_row[$j];
        }else{
          echo "<td colspan=7></td>";
        }
        echo "<td class='customer_companyname row-color6'>{$dms['customer_companyname']}</td>";
        if(isset($sales_row[$j])){
          echo $sales_row[$j];
        }else{
          echo "<td colspan=7>";
          echo "</td>";
        }
        echo "</tr>";
      }
    }
    $i = $i+$sales_cnt+$purchase_cnt;
    $idx++;
  }
?>

          <tr class="project_division fixed_tr">
            <td colspan= "5" class="row-color4">합 계</td>
            <td class="p_sum_issuance_amount row-color4">공급가액더하기</td>
            <td class="p_sum_tax_amount row-color4">세액더하기</td>
            <td class="p_sum_total_amount row-color4">합계더하기</td>
            <td class="row-color5"></td>
            <td colspan= "3" class="row-color3">합 계</td>
            <td class="s_sum_issuance_amount row-color3">공급가액더하기</td>
            <td class="s_sum_tax_amount row-color3">세액더하기</td>
            <td class="s_sum_total_amount row-color3">합계더하기</td>
            <td class="row-color3"></td>
          </tr>
        </tbody>
      </table>
    </div>
<?php }else{ ?>

    <span align="left" style="float:left;margin-left:2.5%;margin-bottom:10px;margin-top:20px;">
      <img width="25" name="hide_img" src="<?php echo $misc;?>img/btn_up_box.svg" onclick="div_toggle('dbs_ma_div', this);" style="cursor:pointer;">
        <!-- <button class="skyBtn" type="button" name="button" onclick="operating_edit(this);">수정</button> -->
        <!-- <button class="skyBtn" type="button" name="button" id="save_btn" onclick="operating_save();" style="display:none;">저장</button> -->
        <input class="btn-common btn-color4" type="button" onclick="operating_edit(this);" value="수정" style="margin-left:20px;">
        <input class="btn-common btn-color2" id="save_btn" style="display:none;margin-left:20px;" type="button" onclick="operating_save();" value="저장" >
    </span>
    <form class="" id="operating_form" name="operating_form" method="post">
      <div class="item_div" id="dbs_ma_div">
        <table class="contents_tbl" id="dbs_ma_tbl" cellspacing=0 cellpadding=5>
          <colgroup>
            <col width="10%" /><!-- enduser-->
            <col width="10%" /> <!-- 일자-->
            <col width="10%" /> <!-- 매출처 -->
            <col width="10%" /> <!-- 품목 -->
            <col width="10%" /> <!--공급가액-->
            <col width="10%" /> <!--세액-->
            <col width="10%" /> <!--합계-->
            <col width="10%" /> <!-- 계삼서no-->
            <col width="10%" /> <!--바튼-->
          </colgroup>
        <thead>
          <tr>
                  <!-- type 002 -->
            <th colspan="9">매출(용역)</th>
          </tr>
          <tr>
            <td class="row-color6">일자</td>
            <td class="row-color6">End-User</td>
            <td class="row-color6">매출처</td>
            <td class="row-color6">품목</td>
            <td class="row-color6">공금가액</td>
            <td class="row-color6">세액</td>
            <td class="row-color6">합계</td>
            <td class="row-color6">세금계산서No</td>
            <td class="row-color6"><button type="button" name="button" onclick="plus_content(this, 'head');" style="float:right;">+</button></td>
          </tr>
        </thead>
        <tbody>
          <tr>
<?php
  foreach ($operating_val as $ov){
    if(number_format((int)$ov->total_amount) < 0 ){
      $class = " minus_tr";
    }else{
      $class = " project_division";
   }
   if($ov->oper_yn == 'N'){
?>
          <tr class="old_tr<?php echo $class ?>">
            <td>
              <p class="td_text"><?php echo $ov->issuance_date ?></p>
              <input class="td_input" type="text" name="issuance_month[]" value="<?php echo $ov->issuance_date ?>" title="<?php echo $ov->issuance_date ?>" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);">
            </td>
            <td>
              <p class="td_text"><?php echo $ov->customer_name ?></p>
              <input class="td_input" type="text" name="customer[]" value="<?php echo $ov->customer_name ?>" title ="<?php echo $ov->customer_name ?>">
            </td>
            <td>
              <p class="td_text"><?php echo $ov->end_user ?></p>
              <input class="td_input" type="text" name="enduser[]" value="<?php echo $ov->end_user ?>" title ="<?php echo $ov->end_user ?>">
            </td>
            <td>
              <p class="td_text"><?php echo $ov->item ?></p>
              <input class="td_input" type="text" name="project_name[]" value="<?php echo $ov->item ?>" title ="<?php echo $ov->item ?>">
            </td>
            <td>
              <p class="td_text"><?php echo number_format($ov->issuance_amount) ?></p>
              <input class="td_input issuance" type="text" name="issuance[]" value="<?php echo number_format($ov->issuance_amount) ?>" title ="<?php echo number_format($ov->issuance_amount) ?>" onfocus='deCommaStr(this);' onBlur='this.value=commaStr(this.value)' onKeyup='onlyNumHipen(this);' onchange='calc_money(this);'>
            </td>
            <td>
              <p class="td_text"><?php echo number_format($ov->tax_amount) ?></p>
              <input class="td_input tax" type="text" name="tax[]" value="<?php echo number_format($ov->tax_amount) ?>" title = "<?php echo number_format($ov->tax_amount) ?>" onfocus='deCommaStr(this);' onBlur='this.value=commaStr(this.value)' onKeyup='onlyNumHipen(this);' onchange='calc_money(this);' >
            </td>
            <td>
              <p class="td_text"><?php echo number_format($ov->total_amount) ?></p>
              <input class="td_input tr_sum" type="text" name="sum[]" value="<?php echo number_format($ov->total_amount) ?>" title = "<?php echo number_format($ov->total_amount) ?>" readonly>
            </td>
            <td>
              <p class="td_text"><?php echo $ov->bill_type ?></p>
              <input class="td_input" type="text" class='tax_type' name="tax_type[]" value="<?php echo $ov->bill_type ?>" title = "<?php echo $ov->bill_type ?>" onchange='calc_money(this);'>
            </td>
            <td class="blank_td">
              <input type="hidden" class="operating_seq" name="operating_seq[]" value="<?php echo $ov->seq ?>">
              <input type="hidden" class="type" name="type[]" value="<?php echo $ov->type ?>">
              <input type="hidden" name="oper_yn[]" value="<?php echo $ov->oper_yn ?>">
              <input type="hidden" name="comment[]" value="">
              <button type='button' name='button' onclick='del_content(this);' style="float:right;">-</button>
              <!-- <button type='button' name='button' onclick='plus_content(this,"tbody");'>+</button> -->
              <!-- <button type='button' name='minus_button' onclick='minus_tax(this);'>D</button> -->
            </td>
          </tr>
<?php }
   }
?>
          </tr>
          <tr class="project_division fixed_tr">
            <td colspan= "4" class="row-color4">합 계</td>
            <td name=total_issuance class="row-color4"></td>
            <td name=total_tax class="row-color4"></td>
            <td name=total_sum class="row-color4"></td>
            <td class="row-color4"></td>
            <td class="row-color4"></td>
          </tr>
        </tbody>
      </table>
    </div>
<?php } ?>
    <div align="left" style="float:left;margin-left:2.5%;margin-bottom:10px;margin-top:20px;">
      <img width="25" name="hide_img" src="<?php echo $misc;?>img/btn_up_box.svg" onclick="div_toggle('operating_div', this);" style="cursor:pointer;">
      <?php if ($get_company != "DBS") {  ?>
      <!-- <button class="skyBtn" type="button" name="button" onclick="operating_edit(this);">수정</button> -->
      <!-- <button class="skyBtn" type="button" name="button" id="save_btn" onclick="operating_save();" style="display:none;">저장</button> -->
      <input class="btn-common btn-color4" type="button" onclick="operating_edit(this);" value="수정" style="margin-left:20px;" >
      <input class="btn-common btn-color2" type="button" id="save_btn" onclick="operating_save();" style="display:none;margin-left:20px;" value="저장" >
<?php } ?>
    </div>
<?php if ($get_company != "DBS") {  ?>
    <form class="" id="operating_form" name="operating_form" method="post">
<?php } ?>
      <div class="item_div" id="operating_div">
        <input type="hidden" name="dept" value="<?php echo $company ?>">
        <div id="operating_p_div">
          <table class="contents_tbl" id="operating_p_tbl" cellspacing=0 style="max-width:46%; float:left; margin-left:5vh;">
            <colgroup>
              <col width="7%" /><!-- 일자-->
              <col width="15%" /> <!-- 거래처-->
              <col width="14%" /> <!-- 엔유-->
              <col width="18%" /> <!-- 품목 -->
              <col width="8%" /> <!--공급가액-->
              <col width="8%" /> <!--세액-->
              <col width="8%" /> <!--합계-->
              <col width="6%" /> <!-- 종류 -->
              <col width="16%"/> <!-- 코멘트, 버튼-->
            </colgroup>
            <thead>
              <tr>
                <!-- type 002 -->
                <th class="blank_th" colspan="8">매입세금계산서(운영비)</th>
                <th></th>
                <!-- type 001 -->
              </tr>
              <tr>
                <td class="row-color6">일자</td>
                <td class="row-color6">거래처</td>
                <td class="row-color6">End-user</td>
                <td class="row-color6">품목</td>
                <td class="row-color6">공금가액</td>
                <td class="row-color6">세액</td>
                <td class="row-color6">합계</td>
                <td class="row-color6">종류</td>
                <td class="row-color6">비고<button type="button" name="button" onclick="plus_content(this, 'head');" style="float:right;">+</button></td>
              </tr>
            </thead>
            <tbody>
<?php
  foreach ($operating_val as $ov){
    if(number_format((int)$ov->total_amount) < 0 ){
      $class = " minus_tr";
    }else{
      $class = " project_division";
    }
    if($ov->type == '002' && $ov->oper_yn == 'Y'){
?>
              <tr class="old_tr<?php echo $class ?> oper_p_tr">
                <td>
                  <p class="td_text operating_td"><?php echo $ov->issuance_date ?></p>
                  <input class="td_input operating_td" type="text" name="issuance_month[]" value="<?php echo $ov->issuance_date ?>" title="<?php echo $ov->issuance_date ?>" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);">
                </td>
                <td>
                  <p class="td_text operating_td"><?php echo $ov->customer_name ?></p>
                  <input class="td_input operating_td" type="text" name="customer[]" value="<?php echo $ov->customer_name ?>" title ="<?php echo $ov->customer_name ?>">
                </td>
                <td>
                  <p class="td_text operating_td"><?php echo $ov->end_user ?></p>
                  <input class="td_input operating_td" type="text" name="enduser[]" value="<?php echo $ov->end_user ?>" title ="<?php echo $ov->end_user ?>">
                </td>
                <td>
                  <p class="td_text operating_td"><?php echo $ov->item ?></p>
                  <input class="td_input operating_td" type="text" name="project_name[]" value="<?php echo $ov->item ?>" title ="<?php echo $ov->item ?>">
                </td>
                <td>
                  <p class="td_text operating_td"><?php echo number_format($ov->issuance_amount) ?></p>
                  <input class="td_input issuance operating_td" type="text" name="issuance[]" value="<?php echo number_format($ov->issuance_amount) ?>" title ="<?php echo number_format($ov->issuance_amount) ?>" onfocus='deCommaStr(this);' onBlur='this.value=commaStr(this.value)' onKeyup='onlyNumHipen(this);' onchange='calc_money(this);'>
                </td>
                <td>
                  <p class="td_text operating_td"><?php echo number_format($ov->tax_amount) ?></p>
                  <input class="td_input tax operating_td" type="text" name="tax[]" value="<?php echo number_format($ov->tax_amount) ?>" title = "<?php echo number_format($ov->tax_amount) ?>" onfocus='deCommaStr(this);' onBlur='this.value=commaStr(this.value)' onKeyup='onlyNumHipen(this);' onchange='calc_money(this);'>
                </td>
                <td>
                  <p class="td_text operating_td"><?php echo number_format($ov->total_amount) ?></p>
                  <input class="td_input tr_sum operating_td" type="text" name="sum[]" value="<?php echo number_format($ov->total_amount) ?>" title = "<?php echo number_format($ov->total_amount) ?>" readonly>
                </td>
                <td>
                  <p class="td_text operating_td"><?php echo $ov->bill_type ?></p>
                  <input class="td_input tax_type" type="hidden" name="tax_type[]" value="<?php echo $ov->bill_type ?>" title = "<?php echo $ov->bill_type ?>" onchange='calc_money(this);'>
                  <select class="td_input tax_type operating_td" name="tax_type[]" title = "<?php echo $ov->bill_type ?>" onchange='tax_type_select_change(this);'>
                    <option value="" <?php if($ov->bill_type == ''){echo 'selected';} ?>></option>
                    <option value="종" <?php if($ov->bill_type == '종'){echo 'selected';} ?>>종</option>
                    <option value="전" <?php if($ov->bill_type == '전'){echo 'selected';} ?>>전</option>
                    <option value="계" <?php if($ov->bill_type == '계'){echo 'selected';} ?>>계</option>
                  </select>
                </td>
                <td>
                  <p class="td_text operating_td"><?php if ($ov->comment!=""){echo number_format($ov->comment);} ?></p>
                  <input type="hidden" class="operating_seq" name="operating_seq[]" value="<?php echo $ov->seq ?>">
                  <input type="hidden" class="type" name="type[]" value="<?php echo $ov->type ?>">
                  <input type="hidden" name="oper_yn[]" value="<?php echo $ov->oper_yn ?>">
                  <!-- <button type='button' name='button' onclick="open_comment_input('<?php echo $ov->seq; ?>');">m</button> -->
                  <input class="td_input operating_td" type="text" name="comment[]" value="<?php if ($ov->comment!=""){echo number_format($ov->comment);} ?>" title ="<?php echo $ov->comment ?>" style="width:65%" onchange="this.value = commaStr(this.value);" onkeyup="onlyNumber(this);">
                  <button type='button' name='button' onclick='del_content(this);' style="float:right;">-</button>
                  <!-- <button type='button' name='button' onclick='plus_content(this,"tbody");'>+</button> -->
                  <!-- <button type='button' name='minus_button' onclick='minus_tax(this);'>D</button> -->
                </td>
              </tr>
<?php }
  }
?>
            </tbody>
            <tfoot class="oper_p_tfoot">
              <tr class="project_division fixed_tr3 oper_p_tfoot_tr1">
                <td class="operating_td row-color4" colspan= "4">합 계</td>
                <td class="operating_td row-color4" name=total_issuance id="operating_iss_in"></td>
                <td class="operating_td row-color4" name=total_tax id="operating_tax_in"></td>
                <td class="operating_td row-color4" name=total_sum id="operating_total_in"></td>
                <td class="row-color4"></td>
                <td class="row-color4"></td>
              </tr>
              <tr class="project_division fixed_tr2 oper_p_tfoot_tr2">
                <td colspan= "4" class="row-color4"></td>
                <td class="operating_td row-color4" colspan= "2">계산서 합계</td>
                <td class="operating_td row-color4" name=bill_sum></td>
                <td class="row-color4"></td>
                <td class="row-color4"></td>
              </tr>
              <tr class="project_division fixed_tr oper_p_tfoot_tr3">
                <td colspan= "4" class="row-color4"></td>
                <td class="operating_td row-color4" colspan= "2">전자 계산서 합계</td>
                <td class="operating_td row-color4" name=elec_bill_sum></td>
                <td class="row-color4"></td>
                <td class="row-color4"></td>
              </tr>
            </tfoot>
          </table>
        </div>

        <div id="operating_s_div">
          <table class="contents_tbl" id="operating_s_tbl" cellspacing=0 style="max-width:46%;float:right;margin-right:5vh;">
            <colgroup>
              <col width="7%" /><!-- 일자-->
              <col width="15%" /> <!-- 거래처-->
              <col width="14%" /> <!-- 엔유-->
              <col width="18%" /> <!-- 품목 -->
              <col width="8%" /> <!--공급가액-->
              <col width="8%" /> <!--세액-->
              <col width="8%" /> <!--합계-->
              <col width="6%" /> <!-- 종류 -->
              <col width="16%"/> <!-- 코멘트, 버튼-->
            </colgroup>
            <thead>
              <tr>
                <!-- type 002 -->
                <th class="blank_th" colspan="8">매출세금계산서(운영비)</th>
                <th></th>
                <!-- type 001 -->
              </tr>
              <tr>
                <td class="row-color6">일자</td>
                <td class="row-color6">거래처</td>
                <td class="row-color6">End-user</td>
                <td class="row-color6">품목</td>
                <td class="row-color6">공금가액</td>
                <td class="row-color6">세액</td>
                <td class="row-color6">합계</td>
                <td class="row-color6">종류</td>
                <td class="row-color6">비고<button type="button" name="button" onclick="plus_content(this, 'head');" style="float:right;">+</button></td>
              </tr>
            </thead>
            <tbody>
<?php
  foreach ($operating_val as $ov){
    if(number_format((int)$ov->total_amount) < 0 ){
      $class = " minus_tr";
    }else{
      $class = " project_division";
    }
    if($ov->type == '001' && $ov->oper_yn == 'Y'){
?>
              <tr class="old_tr<?php echo $class ?> oper_s_tr">
                <td>
                  <p class="td_text operating_td"><?php echo $ov->issuance_date ?></p>
                  <input class="td_input operating_td" type="text" name="issuance_month[]" value="<?php echo $ov->issuance_date ?>" title="<?php echo $ov->issuance_date ?>" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);">
                </td>
                <td>
                  <p class="td_text operating_td"><?php echo $ov->customer_name ?></p>
                  <input class="td_input operating_td" type="text" name="customer[]" value="<?php echo $ov->customer_name ?>" title ="<?php echo $ov->customer_name ?>">
                </td>
                <td>
                  <p class="td_text operating_td"><?php echo $ov->end_user ?></p>
                  <input class="td_input operating_td" type="text" name="enduser[]" value="<?php echo $ov->end_user ?>" title ="<?php echo $ov->end_user ?>">
                </td>
                <td>
                  <p class="td_text operating_td"><?php echo $ov->item ?></p>
                  <input class="td_input operating_td" type="text" name="project_name[]" value="<?php echo $ov->item ?>" title ="<?php echo $ov->item ?>">
                </td>
                <td>
                  <p class="td_text operating_td"><?php echo number_format($ov->issuance_amount) ?></p>
                  <input class="td_input issuance operating_td" type="text" name="issuance[]" value="<?php echo number_format($ov->issuance_amount) ?>" title ="<?php echo number_format($ov->issuance_amount) ?>" onfocus='deCommaStr(this);' onBlur='this.value=commaStr(this.value)' onKeyup='onlyNumHipen(this);' onchange='calc_money(this);'>
                </td>
                <td>
                  <p class="td_text operating_td"><?php echo number_format($ov->tax_amount) ?></p>
                  <input class="td_input tax operating_td" type="text" name="tax[]" value="<?php echo number_format($ov->tax_amount) ?>" title = "<?php echo number_format($ov->tax_amount) ?>" onfocus='deCommaStr(this);' onBlur='this.value=commaStr(this.value)' onKeyup='onlyNumHipen(this);' onchange='calc_money(this);'>
                </td>
                <td>
                  <p class="td_text operating_td"><?php echo number_format($ov->total_amount) ?></p>
                  <input class="td_input tr_sum operating_td" type="text" name="sum[]" value="<?php echo number_format($ov->total_amount) ?>" title = "<?php echo number_format($ov->total_amount) ?>" readonly>
                </td>
                <td>
                  <p class="td_text operating_td"><?php echo $ov->bill_type ?></p>
                  <input class="td_input tax_type" type="hidden" name="tax_type[]" value="<?php echo $ov->bill_type ?>" title = "<?php echo $ov->bill_type ?>" onchange='calc_money(this);'>
                  <select class="td_input tax_type operating_td" name="tax_type[]" title = "<?php echo $ov->bill_type ?>" onchange='tax_type_select_change(this);'>
                    <option value="" <?php if($ov->bill_type == ''){echo 'selected';} ?>></option>
                    <option value="종" <?php if($ov->bill_type == '종'){echo 'selected';} ?>>종</option>
                    <option value="전" <?php if($ov->bill_type == '전'){echo 'selected';} ?>>전</option>
                    <option value="계" <?php if($ov->bill_type == '계'){echo 'selected';} ?>>계</option>
                  </select>
                </td>
                <td>
                  <p class="td_text operating_td"><?php if ($ov->comment!=""){echo number_format($ov->comment);} ?></p>
                  <input type="hidden" class="operating_seq" name="operating_seq[]" value="<?php echo $ov->seq ?>">
                  <input type="hidden" class="type" name="type[]" value="<?php echo $ov->type ?>">
                  <input type="hidden" name="oper_yn[]" value="<?php echo $ov->oper_yn ?>">
                  <input class="td_input operating_td" type="text" name="comment[]" value="<?php if ($ov->comment!=""){echo number_format($ov->comment);} ?>" title ="<?php echo $ov->comment ?>" style="width:65%" onchange="this.value = commaStr(this.value);" onkeyup="onlyNumber(this);">
                  <button type='button' name='button' onclick='del_content(this);' style="float:right;">-</button>
                  <!-- <button type='button' name='button' onclick='plus_content(this,"tbody");'>+</button> -->
                  <!-- <button type='button' name='minus_button' onclick='minus_tax(this);'>D</button> -->
                </td>
              </tr>
<?php }
   }
?>
            </tbody>
            <tfoot>
              <tr class="project_division fixed_tr3 oper_s_tfoot_tr1">
                <td class="operating_td row-color3" colspan= "4">합 계</td>
                <td class="operating_td row-color3" name=total_issuance id="operating_iss_out"></td>
                <td class="operating_td row-color3" name=total_tax id="operating_tax_out"></td>
                <td class="operating_td row-color3" name=total_sum id="operating_total_out"></td>
                <td class="row-color3"></td>
                <td class="row-color3"></td>
              </tr>
              <tr class="project_division fixed_tr2 oper_s_tfoot_tr2">
                <td colspan= "4" class="row-color3"></td>
                <td class="operating_td row-color3" colspan= "2">계산서 합계</td>
                <td class="operating_td row-color3" name=bill_sum></td>
                <td class="row-color3"></td>
                <td class="row-color3"></td>
              </tr>
              <tr class="project_division fixed_tr oper_s_tfoot_tr3">
                <td colspan= "4" class="row-color3"></td>
                <td class="operating_td row-color3" colspan= "2">전자 계산서 합계</td>
                <td class="operating_td row-color3" name=elec_bill_sum></td>
                <td class="row-color3"></td>
                <td class="row-color3"></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <input type="hidden" id="operating_del_seq" name="operating_del_seq" value="">
      </div>
    </form>

  <!-- 사업부별 합계 -->
  <?php
    if(isset($_GET['company'])==false || $_GET['company'] == 'DUIT'){
      $d_1_001 = $d_1_002 = $d_2_001 = $d_2_002 = $t_001 = $t_002 = 0;
      foreach($dept_sum as $ds) {
        if($ds->dept == '사업1부') {
          if($ds->type == '001') {
            $d_1_001 += $ds->issuance_amount;
          } else if ($ds->type == '002') {
            $d_1_002 += $ds->issuance_amount;
          }
        }
        if($ds->dept == '사업2부') {
          if($ds->type == '001') {
            $d_2_001 += $ds->issuance_amount;
          } else if ($ds->type == '002') {
            $d_2_002 += $ds->issuance_amount;
          }
        }
        if($ds->dept == '기술지원부') {
          if($ds->type == '001') {
            $t_001 += $ds->issuance_amount;
          } else if ($ds->type == '002') {
            $t_002 += $ds->issuance_amount;
          }
        }
      }
    ?>
    <span align="left" style="float:left;margin-left:2.5%;margin-bottom:10px;margin-top:20px;">
      <img width="25" name="hide_img" src="<?php echo $misc;?>img/btn_up_box.svg" onclick="div_toggle('dept_sum_div', this);" style="cursor:pointer;">
    </span>

    <div class="item_div" id="dept_sum_div">
      <table id="dept_sum_tbl" class="contents_tbl" cellspacing=0 cellpadding=0>
        <colgroup>
        </colgroup>
        <thead>
          <tr>
            <th colspan="2">1사업부</th>
            <th colspan="2">2사업부</th>
            <th colspan="2">기술지원부</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1사업부 매출금액</td>
            <td align="right" style="padding-right:10px;">
             <?php echo number_format($d_1_001); ?>
            </td>
            <td>2사업부 매출금액</td>
            <td align="right" style="padding-right:10px;">
             <?php echo number_format($d_2_001); ?>
            </td>
            <td>기술지원부 매출금액</td>
            <td align="right" style="padding-right:10px;">
             <?php echo number_format($t_001); ?>
            </td>
          </tr>
          <tr>
            <td>1사업부 매입금액</td>
            <td align="right" style="padding-right:10px;">
             <?php echo number_format($d_1_002); ?>
            </td>
            <td>2사업부 매입금액</td>
            <td align="right" style="padding-right:10px;">
             <?php echo number_format($d_2_002); ?>
            </td>
            <td>기술지원부 매입금액</td>
            <td align="right" style="padding-right:10px;">
             <?php echo number_format($t_002); ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
<?php } ?>
  </div>

  <!-- excel export table -->
  <div class="excel_div" style="display:none;">
    <table class="excel_table">

    </table>
  </div>

    <ul class="contextmenu">
      <li class="memo_menu" id="memo_select_li"><a onclick="$('#memo_select_li').hide();$('#memo_delete_li').hide();$('#memo_input_li').show();" style="cursor:pointer;">메모입력</a></li>
      <li class="memo_menu" id="memo_delete_li"><a onclick="del_memo();" style="cursor:pointer;">메모삭제</a></li>
      <div class="memo_menu" id="memo_input_li" style="display:none;">
        <input type="hidden" id="memo_tax_num" value="">
        <input type="text" class="input-common" id="memo_input" name="" value="" style="width:200px;">
        <input class="btn-common btn-color2" type="button" onclick="save_memo();" value="저장" style="width:50px;margin-left:20px;" >
        <input class="btn-common btn-color4" type="button" onclick="close_save_memo();" value="취소" style="width:50px;">
      </div>
    </ul>
  <!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
  <!--하단-->
<script>
  sum_calculation("maintain_purchase_sales");
  sum_calculation("forcasting_purchase_sales");
  sum_calculation("procurement_purchase_sales");
  function sum_calculation(table_id){
    var p_issuance_amount = 0;
    var p_tax_amount = 0;
    var p_total_amount = 0;
    var s_issuance_amount = 0;
    var s_tax_amount = 0;
    var s_total_amount = 0;
    var p_issuance_cnt = 0;
    var s_issuance_cnt = 0;
    $('#'+table_id+' .p_issuance_amount').each(function(index) {
      p_issuance_amount += Number($(this).text().replace(/,/g, ""));
      p_issuance_cnt ++;
    });
    p_issuance_amount = String(p_issuance_amount).replace(/[^0-9-]/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
    $('#'+table_id+' .p_tax_amount').each(function(index) {
      p_tax_amount += Number($(this).text().replace(/,/g, ""));
    });
    p_tax_amount = String(p_tax_amount).replace(/[^0-9-]/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
    $('#'+table_id+' .p_total_amount').each(function(index) {
      p_total_amount += Number($(this).text().replace(/,/g, ""));
    });
    p_total_amount = String(p_total_amount).replace(/[^0-9-]/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');

    $('#'+table_id+' .s_issuance_amount').each(function(index) {
      s_issuance_amount += Number($(this).text().replace(/,/g, ""));
      s_issuance_cnt ++;
    });
    s_issuance_amount = String(s_issuance_amount).replace(/[^0-9-]/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
    $('#'+table_id+' .s_tax_amount').each(function(index) {
      s_tax_amount += Number($(this).text().replace(/,/g, ""));
    });
    s_tax_amount = String(s_tax_amount).replace(/[^0-9-]/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
    $('#'+table_id+' .s_total_amount').each(function(index) {
      s_total_amount += Number($(this).text().replace(/,/g, ""));
    });
    s_total_amount = String(s_total_amount).replace(/[^0-9-]/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');

    var table_id_split = table_id.split("_")[0];

    $("#"+table_id_split+"_p_cnt").text(p_issuance_cnt);
    $("#"+table_id_split+"_s_cnt").text(s_issuance_cnt);

    $("#"+table_id+" .p_sum_issuance_amount").text(p_issuance_amount);
    $("#"+table_id_split+"_sum_iss_in").text(p_issuance_amount);
    $("#"+table_id+" .p_sum_tax_amount").text(p_tax_amount);
    $("#"+table_id_split+"_sum_tax_in").text(p_tax_amount);
    $("#"+table_id+" .p_sum_total_amount").text(p_total_amount);
    $("#"+table_id_split+"_sum_total_in").text(p_total_amount);

    $("#"+table_id+" .s_sum_issuance_amount").text(s_issuance_amount);
    $("#"+table_id_split+"_sum_iss_out").text(s_issuance_amount);
    $("#"+table_id+" .s_sum_tax_amount").text(s_tax_amount);
    $("#"+table_id_split+"_sum_tax_out").text(s_tax_amount);
    $("#"+table_id+" .s_sum_total_amount").text(s_total_amount);
    $("#"+table_id_split+"_sum_total_out").text(s_total_amount);
  }


  function GoSearch() {
    var year = document.month_form.year.value;
    var month = document.month_form.month.value;

    document.month_form.submit();
  }

   /* 합계 황현빈 추가 */
  $(document).ready(function(){
    $(".total_num, .total_sum").each(function(){
      if($.trim($(this).text()) == '' || $.trim($(this).text()) == '0'){
        $(this).text('-');
      }
    })
  })

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

  function lpad(str, padLen, padStr) {
    if (padStr.length > padLen) {
      return str;
    }
    str += ""; // 문자로
    padStr += ""; // 문자로
    while (str.length < padLen)
      str = padStr + str;
    str = str.length >= padLen ? str.substring(0, padLen) : str;
    return str;
  }

  // 숫자와 '-' 입력 함수
  function onlyNumHipen(obj) {
    var val = obj.value;
    var re = /[^0-9-]/gi;
    obj.value = val.replace(re, "");
  }

  // 금액 부분 콤마 추가
  function commaStr(n) {
    var reg = /(^[+-]?\d+)(\d{3})/;
    n += "";

    while (reg.test(n))
      n = n.replace(reg, "$1" + "," + "$2");
    return n;
  }

  // 금액 부분 콤마 제거
  function deCommaStr(obj) {
    num = obj.value + "";
    if (obj.value != "") {
      obj.value = obj.value.replace(/,/g, "");
    }
    if (typeof obj.selectionStart == "number") {
      obj.selectionStart = obj.selectionEnd = obj.value.length;
    } else if (typeof obj.createTextRange != "undefined") {
      obj.focus();
      var range = obj.createTextRange();
      range.collapse(false);
      range.select();
    }
  }

  function calculator(table){
    var issuance = 0;
    var sum_tax = 0;
    var cnt = 0;
     // $("."+table).find('.issuance').each(function(){
    $("#"+table).find('.issuance').each(function(){
      cnt ++;
      issuance += Number($(this).val().replace(/,/g, ""));
      // var issuance += Number($(this).val().replace(",", ""));
      $(this).closest('table').find('td[name=total_issuance]').html(commaStr(issuance));
    });

    $("#"+table).find('.tax').each(function(){
      sum_tax += Number($(this).val().replace(/,/g, ""));
      // var issuance += Number($(this).val().replace(",", ""));
      $(this).closest('table').find('td[name=total_tax]').html(commaStr(sum_tax));
    });
    var total_sum = issuance + sum_tax;
    $("#"+table).find('td[name=total_sum]').html(commaStr(total_sum));
    // $('td[name=total_issuance]').html(commaStr(issuance));


    var bill_tax = 0;
    var elec_tax = 0;
    $("#"+table).find('select.tax_type').each(function(){
      if($(this).val()=="계"){
        bill_tax += Number($(this).closest('tr').find('.tr_sum').val().replace(/,/g, ""));
      }else if($(this).val()=="전"){
        elec_tax += Number($(this).closest('tr').find('.tr_sum').val().replace(/,/g, ""));
      }
    });
    $("#"+table).find('td[name=bill_sum]').html(commaStr(bill_tax));
    $("#"+table).find('td[name=elec_bill_sum]').html(commaStr(elec_tax));

    var t = table.replace("_tbl", '');
    $("#"+t+'_cnt').html(cnt);

  }



  $(document).ready(function(){

    calculator('operating_s_tbl');
    calculator('operating_p_tbl');
    calculator('dbs_ma_tbl');

    // 운영비 합계
    $("#operating_sum_iss_in").text($("#operating_iss_in").text());
    $("#operating_sum_tax_in").text($("#operating_tax_in").text());
    $("#operating_sum_total_in").text($("#operating_total_in").text());
    $("#operating_sum_iss_out").text($("#operating_iss_out").text());
    $("#operating_sum_tax_out").text($("#operating_tax_out").text());
    $("#operating_sum_total_out").text($("#operating_total_out").text());

    // 전체 합계 총합 구하기
    cal_total_sum();
  });

  function cal_total_sum() {
    var a = ['iss', 'tax', 'sum'];
    var b = ['in', 'out'];
    for(i=0; i<a.length; i++) {
      for(j=0; j<b.length; j++) {
        var t = 0;
        $("."+a[i]+"_"+b[j]+"").each(function(){
          if($(this).text() == '-'){
            t += 0;
          } else {
            t += Number($(this).text().replace(/,/g, ""));
          }
        })
        $("#total_sum_"+a[i]+"_"+b[j]+"").text(commaStr(t));
      }
    }
    for(i=0; i<b.length; i++){
      var f = 0;
      $(".cnt_"+b[i]+"").each(function(){
        if($(this).text() == '-'){
          f += 0;
        } else {
          f += Number($(this).text().replace(/,/g, ""));
        }
        $("#total_sum_count_"+b[i]+"").text(commaStr(f));
      })
    }
  }

  //돈계산
  function calc_money(ths){
    var tr = $(ths).closest('tr');
    var amount = tr.find('.issuance').val();
    amount = amount.replace(/,/g, "");
    var tax = tr.find('.tax').val();
    tax = tax.replace(/,/g, "");
    var sum = Number(amount) + Number(tax);
    // console.log(sum);
    sum = commaStr(sum);
    tr.find('.tr_sum').val(sum);

    var table = $(ths).closest('table').attr('id');
    calculator(table);
  }

  // 운영비 플라쓰
  function plus_content(td, position){
    // var td=$(td).closest('tr');
    var year = $('#select_year').val();
    var month = $('#select_month').val();
    var month = lpad(month, 2, 0);

    var first_date = year + "-" + month + "-01";
    var last_day = (new Date(year, month, 0)).getDate();
    var last_date = year + "-" + month + "-" + last_day;

    var table_id = $(td).closest('table').attr('id');
    console.log(table_id);
    if(table_id == 'operating_p_tbl'){
      var type = '002';
    }else{
      var type = '001';
    }

    if (table_id == 'dbs_ma_tbl') {
      var oper_yn = "N";
      var oper_class = "";
      var tax_type = "<td><input type='text' class='tax_type' name='new_tax_type[]' onchange='calc_money(this);'/></td>";
      var comment = "<td><input type='hidden' name='new_type[]' value='"+type+"'><input type='hidden' name='new_oper_yn[]' value='"+oper_yn+"'><input type='hidden' name='new_comment[]' value=''><button type='button' name='button' onclick='del_content(this);' style='float:right;'>-</button></td>";
    } else {
      var oper_yn = "Y";
      var oper_class = " operating_td";
      var tax_type = "<td><select class='tax_type"+oper_class+"' name='new_tax_type[]' onchange='calc_money(this);'><option value=''></option><option value='종'>종</option><option value='전'>전</option><option value='계'>계</option></select></td>";
      var comment = "<td><input type='hidden' name='new_type[]' value='"+type+"'><input type='hidden' name='new_oper_yn[]' value='"+oper_yn+"'><input class='"+oper_class+"' type='text' name='new_comment[]' value='' style='width:65%' onchange='this.value = commaStr(this.value);' onkeyup='onlyNumber(this);'><button type='button' name='button' onclick='del_content(this);' style='float:right;'>-</button></td>"
    }

    var contents = '';
    contents += "<tr class='project_division new_tr'><td>";
    contents += '<input class="'+oper_class+'" type="text" name="new_issuance_month[]" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);">';
    contents += "</td>";
    contents += "<td><input class='"+oper_class+"' type='text' name='new_customer[]'/></td>";
    contents += "<td><input class='"+oper_class+"' type='text' name='new_enduser[]'/></td>";
    contents += "<td><input class='"+oper_class+"' type='text' name='new_project_name[]'/></td>";
    contents += "<td><input class='"+oper_class+" issuance' type='text' name='new_issuance[]' onfocus='deCommaStr(this);' onBlur='this.value=commaStr(this.value)' onKeyup='onlyNumHipen(this);' onchange='calc_money(this);'/></td>";
    contents += "<td><input class='"+oper_class+" tax' type='text' name='new_tax[]' onfocus='deCommaStr(this);' onBlur='this.value=commaStr(this.value)' onKeyup='onlyNumHipen(this);' onchange='calc_money(this);'/></td>";
    contents += "<td><input class='"+oper_class+" tr_sum' type='text' name='new_sum[]' readonly/></td>";
    contents += tax_type
    contents += comment;
    // contents += "<button type='button' name='button' onclick='plus_content(this,\"tbody\");'>+</button>";
    contents += "</tr>";

    if(position == "head"){
      var tr_len = $(td).closest('table').find('tbody tr').length;
      if(tr_len == 0){
        $(td).closest('table').find('tbody').append(contents);
      }else{
        $(td).closest('table').find('tbody tr:first').before(contents);
      }
     // $("#operating_p_tbl tbody tr:first").before(contents);
     // var td = $(this).closest('tbody');
     // td.find('tr:first').before(contents);

    }else{
      var tr=$(td).closest('tr');
      tr.after(contents);
    }
    $("#operating_div button").css("display","inline-block");
    $("#dbs_ma_div button").css("display","inline-block");

    $("#sidebar_left").height($("#main_contents").height());
    $(".sidebar_sub_on").height($("#main_contents").height());
  }

  // tr 삭제
  function del_content(td){
    var seq = $(td).closest('tr').find('.operating_seq').val();
    var del = $("#operating_del_seq").val();
    seq = del + ","+ seq;
    $("#operating_del_seq").val(seq);

    $(td).closest('tr').find('input').each(function(){
      $(this).val("");
    });

    calc_money(td);

    $(td).closest('tr').remove();

    $("#sidebar_left").height($("#main_contents").height());
    $(".sidebar_sub_on").height($("#main_contents").height());
  }

  // 마이너스 계산서
  function minus_tax(td){
    var tr = $(td).closest('tr');
    var clone = tr.clone();
    clone.addClass('minus_tr');
    // clone.find('input').css({'color', 'red'});
    for (var i = 4; i < 7; i++) {
       var money = clone.find('input:eq('+i+')').val().replace(/,/g, "");
       money = commaStr(money *-1)
       clone.find('input:eq('+i+')').val;
    }
    // clone.find('button[name=minus_button]').css('display', 'none');
    tr.after(clone);
    calc_money(td);
  }


  function operating_edit(ths){
    $(ths).css("display","none");
    $("#save_btn").show();
    $(".td_input").show();
    $(".td_text").hide();
    // $('#operating_p_tbl tbody input, #operating_s_tbl tbody input, #dbs_ma_tbl tbody input').each(function(){
    //    $(this).removeAttr('disabled');
    // })

    $("#operating_div button, #dbs_ma_div button").css("display","inline-block");
  }

  $(".old_tr").find('input').change(function(){
    $(this).closest('tr').find('input').each(function(){
      var inputname = "modify_";
      var org_name = $(this).attr("name");
      if(org_name.indexOf(inputname)== -1){
         var new_name = inputname + org_name;
         $(this).attr("name", new_name);
      }
    })
    $(this).closest('tr').find('select').each(function(){
      var inputname = "modify_";
      var org_name = $(this).attr("name");
      if(org_name.indexOf(inputname)== -1){
         var new_name = inputname + org_name;
         $(this).attr("name", new_name);
      }
    })
  })

  function tax_type_select_change(el) {
    $(el).prev().val($(el).val());
    $(el).prev().change();
  }

  function operating_save(){

    // var newtr = $("#operating_div").find('.new_tr').length;
    // if (newtr > 0) {
      // $("#operating_sales_form").attr('action', act);
      // $("#operating_sales_form").submit();
    // }
    var datenull = true;
    $('input[name="new_issuance_month[]"]').each(function(){
      if($(this).val() ==""){
        alert("날짜를 입력해주세요.");
        datenull = false;
        return false;
      }
    })

    $('input[name="modify_issuance_month[]"]').each(function(){
      if($(this).val() ==""){
        alert("날짜를 입력해주세요.");
        datenull = false;
        return false;
      }
    })

    if (datenull) {
      var act = "<?php echo site_url();?>/sales/purchase_sales/operating_insert";
      $("#operating_form").attr('action', act);
      $("#operating_form").submit();
    }
  }

<?php if($get_company == 'DBS') { ?>
  function dbs_total_table(){
    var ma_issuance = $("#dbs_ma_tbl").find("td[name=total_issuance]").html().replace(/,/g, "");;
    var ma_tax = $("#dbs_ma_tbl").find("td[name=total_tax]").html().replace(/,/g, "");;
    var ma_sum = $("#dbs_ma_tbl").find("td[name=total_sum]").html().replace(/,/g, "");;
    // console.log(ma_issuance+"/"+ma_tax+"/"+ma_sum);
    var oper_issuance = $("#operating_s_tbl").find("td[name=total_issuance]").html().replace(/,/g, "");;
    var oper_tex = $("#operating_s_tbl").find("td[name=total_tax]").html().replace(/,/g, "");;
    var oper_sum = $("#operating_s_tbl").find("td[name=total_sum]").html().replace(/,/g, "");;
    // console.log(oper_issuance+"/"+oper_tex+"/"+oper_sum);

    var total_issuance = Number(ma_issuance) + Number(oper_issuance);
    var total_tax = Number(ma_tax) + Number(oper_tex);
    var total_sum = Number(ma_sum) + Number(oper_sum);
    // console.log(total_issuance+"/"+total_tax+"/"+total_sum);
    $(".iss_out").eq(1).html(commaStr(ma_issuance));
    $(".tax_out").eq(1).html(commaStr(ma_tax));
    $(".to_out").eq(1).html(commaStr(ma_sum));

    $(".iss_out").eq(3).html(commaStr(oper_issuance));
    $(".tax_out").eq(3).html(commaStr(oper_tex));
    $(".to_out").eq(3).html(commaStr(oper_sum));

    $("#total_sum_iss_out").val(commaStr(total_issuance));
    $("#total_sum_tax_out").val(commaStr(total_tax));
    $("#total_sum_sum_out").val(commaStr(total_sum));


    var ma_count = $("#dbs_ma_tbl").find(".old_tr").length;
    var oper_count = $("#operating_s_tbl").find(".old_tr").length;
    var total_count = Number(ma_count) + Number(oper_count);
    $(".cnt_outcome").eq(1).html(ma_count);
    $(".cnt_outcome").eq(3).html(ma_count);
    $("#total_sum_count_out").html(total_count);
  }

  $(document).ready(function(){
  	dbs_total_table();
    cal_total_sum();
  });
<?php } ?>

function check_minus_bill(){
  $(".p_total_amount, .s_total_amount").each(function(){
    var bill_val = $(this).text();
    bill_val = bill_val.replace(/,/gi,"");
    if(bill_val < 0 ){
      // $(this).closest("tr").find("td:not(.customer_companyname)").css("color","red");
    }
  })
}

  $(window).load(function(){
    $(".total_num").each(function(){
      if($(this).text() == '' || $(this).text() == '0'){
        $(this).text('-');
      }
    })
    check_minus_bill();
  })

  $(document).ready(function(){
    //excel_table
    $('.excel_table').html(''); //엑셀 출력용 테이블을 비워놓기(분기를 바꿀 때마다 테이블이 중첩되지 않도록)
    excel_table();
  });

  function excel_table(){
    var total_table = $('#to_div').html();
    var forcasting_table = $('#fo_div').html();
    var maintain_table = $('#ma_div').html();
    var procurement_table = $('#procure_div').html();

    // var operating_table = $('#operating_div').html();
    var operating_p_table = $('#operating_p_div').html();
    var operating_s_table = $('#operating_s_div').html();

    // var operating_table = '<table class="contents_tbl" id="operating_s_tbl" cellspacing=0 style="max-width:46%;float:right;margin-right:5vh;"><colgroup><col width="5%"/><col width="8%"/><col width="8%"/><col width="11%"/><col width="5%"/><col width="3%"/><col width="6%"/><col width="3%"/><col width="2%"/><col width="5%"/><col width="8%"/><col width="8%"/><col width="11%"/><col width="5%"/><col width="3%"/><col width="6%"/><col width="3%"/></colgroup><thead><tr><th colspan="8">매입세금계산서(운영비)</th><th></th><th colspan="8">매출세금계산서(운영비)</th></tr><tr><td>일자</td><td>거래처</td><td>End-user</td><td>품목</td><td>공급가액</td><td>세액</td><td>합계</td><td>종류</td><td></td><td>일자</td><td>거래처</td><td>End-user</td><td>품목</td><td>공급가액</td><td>세액</td><td>합계</td><td>종류</td></tr></thead><tbody><tr>';
    // if($('.oper_p_tr').html() == undefined ){
    //   var oper_p_tr = '';
    // }else{
    //   var oper_p_tr = $('.oper_p_tr').html();
    // }
    // if($('.oper_s_tr').html() == undefined ){
    //   var oper_s_tr = '';
    // }else{
    //   var oper_s_tr = $('.oper_s_tr').html();
    // }
    // operating_table += oper_p_tr + oper_s_tr + '</tr><tboby><tfoot><tr>' + $('.oper_p_tfoot_tr1').html() + '<td></td>' + $('.oper_s_tfoot_tr1').html() + '<tr>' + $('.oper_p_tfoot_tr2').html() + '<td></td>' + $('.oper_s_tfoot_tr2').html() + '</tr><tr>' + $('.oper_p_tfoot_tr3').html() + '<td></td>' + $('.oper_s_tfoot_tr3').html() + '</tr></tfoot></tboby></table>';

    if($('#company').val() == 'DUIT'){
      var dept_sum_table = $('#dept_sum_div').html();
    }else{
      var dept_sum_table = '';
    }


    // var excel_download_table = total_table + "<br><br>" + forcasting_table + "<br><br>" + maintain_table + "<br><br>" + procurement_table + "<br><br>" + operating_table + "<br><br>" + dept_sum_table;
    var excel_download_table = total_table + "<br><br>" + forcasting_table + "<br><br>" + maintain_table + "<br><br>" + procurement_table + "<br><br>" + operating_p_table + "<br><br>" + operating_s_table + "<br><br>" + dept_sum_table;

  	$(".excel_table").append(excel_download_table);
  };

  function excel_export(){

    var date = $("#select_year").val() + '년 ' + $("#select_month").val() + '월';
    if($("#company").val() == 'DUIT'){
      var company = '두리안정보기술 ';
    }else if($("#company").val() == 'DBS'){
      var company = '두리안정보기술 부산지점 ';
    }else if($("#company").val() == 'ICT'){
      var company = '두리안정보통신기술 ';
    }else if($("#company").val() == 'MG'){
      var company = '더망고 ';
    }
    var title = company + date;

    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
    tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
    tab_text = tab_text + '<x:Name>'+title+'</x:Name>';
    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
    tab_text = tab_text + "<table border='1px'>";

    var exportTable = $('.excel_table').clone();
    exportTable.find('#total_table').css('border','solid');
    // exportTable.find('#total_table').find('td').css('border','1px');
    exportTable.find('#forcasting_purchase_sales').css('border','solid');
    exportTable.find('#maintain_purchase_sales').css('border','solid');
    exportTable.find('#procurement_purchase_sales').css('border','solid');
    exportTable.find('#operating_p_tbl').css('border','solid');
    exportTable.find('#operating_s_tbl').css('border','solid');

    // exportTable.find('#operating_p_tbl').css('float','left');
    // exportTable.find('#operating_s_tbl').css('float','right');

    exportTable.find('#dept_sum_tbl').css('border','solid');
    exportTable.find('.blank_td').remove();
    exportTable.find('button[name=button]').remove(); //operation 내용 안에 있는 + - 버튼 제거
    exportTable.find('.blank_th').prop('colspan','7');
    // $("tr td:last-child").attr("align","left").css({"padding-left":"10px","background":"red"});

    exportTable.find('input').each(function (index, elem) {
      $(elem).remove();
    });

    tab_text = tab_text + exportTable.html();
    tab_text = tab_text + '</table></body></html>';

    var data_type = 'data:application/vnd.ms-excel';
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    var fileName = title + '.xls';
    //Explorer 환경에서 다운로드
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

  function go_requset() {
    location.href = '<?php echo site_url(); ?>/tech/tech_board/request_tech_support_list';
  }

  function go_detail(el) {
    var t_id = $(el).closest('table').attr('id');
    t_id = t_id.split('_')[0];
    var seq = $(el).attr('seq');
    if (t_id == 'forcasting' || t_id == 'procurement' || seq.indexOf('f') != -1) {
      seq = seq.replace('f','');
      location.href = '<?php echo site_url(); ?>/sales/forcasting/order_completed_view?seq='+seq;
    } else if (t_id == 'maintain') {

      $.ajax({
        type: "POST",
        dataType: "json",
        async: false,
        url: "<?php echo site_url(); ?>/sales/purchase_sales/check_maintain",
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

  // 날짜 입력 자동 포맷
  function auto_datetime_format(e, oThis) {
    var num_arr = [
      97, 98, 99, 100, 101, 102, 103, 104, 105, 96,
      48, 49, 50, 51, 52, 53, 54, 55, 56, 57
    ]
    var key_code = (e.which) ? e.which : e.keyCode;
    if (num_arr.indexOf(Number(key_code)) != -1) {
      var len = oThis.value.length;
      if (len == 4) oThis.value += "-";
      if (len == 7) oThis.value += "-";
      if (len == 10) oThis.value += " ";
      if (len == 13) oThis.value += ":";
      if (len == 16) oThis.value += ":";
    }
  }

  // datepicker 생성
  function genDatepicker(el) {
    var year = $('#select_year').val();
    var month = $('#select_month').val();
    var month = lpad(month, 2, 0);

    var first_date = year + "-" + month + "-01";
    var last_day = (new Date(year, month, 0)).getDate();
    var last_date = year + "-" + month + "-" + last_day;
    $(el).datepicker({
      startDate: new Date(first_date),
      endDate: new Date(last_date)
    });
  }

  function open_comment_input(seq) {
    var open_popup_id = 'comment_popup';
    popupOpen(open_popup_id); //레이어 팝업창 오픈
    wrapWindowByMask(); //화면 마스크 효과
  }

	function wrapWindowByMask() {
			 //화면의 높이와 너비를 구한다.
			 var maskHeight = $(document).height();
			 var maskWidth = $(window).width();

			 //마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
			 $('#mask').css({
					 'width' : maskWidth,
					 'height' : maskHeight
			 });
			 $('#mask').fadeTo("slow", 0.5);
	 }

   // 숫자만 입력 함수
   function onlyNumber(obj) {
     var val = obj.value;
     var re = /[^0-9]/gi;
     obj.value = val.replace(re, "");
   }

   function save_memo() {
     var month = '<?php echo $toYear."-".$month; ?>';
     // alert(month);

     var tex_num = $("#memo_tax_num").val();
     var memo = $("#memo_input").val();

     $.ajax({
       url: "<?php echo site_url(); ?>/sales/purchase_sales/save_memo",
       type: "POST",
       dataType: "json",
       data: {
         tex_num: tex_num,
         month: month,
         memo: memo
       },
       success: function(data) {
         if(data) {
           alert('저장되었습니다.');
           location.reload();
         }
       }
     })
   }

   function del_memo() {
     var month = '<?php echo $toYear."-".$month; ?>';

     var tex_num = $("#memo_tax_num").val();

     $.ajax({
       url: "<?php echo site_url(); ?>/sales/purchase_sales/del_memo",
       type: "POST",
       dataType: "json",
       data: {
         tex_num: tex_num,
         month: month
       },
       success: function(data) {
         if(data) {
           alert('삭제되었습니다.');
           location.reload();
         }
       }
     })
   }

   function close_save_memo() {
     $("#memo_select_li").show();
     $("#memo_input_li").hide();
     $(".contextmenu").hide();
   }

// 우클릭 시 메모 입력 메뉴창
   $(document).ready(function(){

     var month = '<?php echo $toYear."-".$month; ?>';

     $.ajax({
       url: "<?php echo site_url(); ?>/sales/purchase_sales/memo_list",
       type: "POST",
       dataType: "json",
       data: {
         month: month
       },
       success: function(data) {
         $("[class*='tax_approval_number']").each(function() {
           if (data.length == 0) {
             return false;
           }
           for(var i=0; i<data.length; i++) {
             if($(this).text() == data[i].tex_num) {
               var tooltip = '<span class="tooltiptext">'+data[i].memo+'</span>';
               $(this).append(tooltip);
               $(this).attr('name', data[i].memo);
               $(this).addClass('is_memo');
               data.splice(i,1);
             }
           }
         })
       }
     })
   //Show contextmenu:
   $(".p_tax_approval_number, .s_tax_approval_number").contextmenu(function(e){
     $("#memo_select_li").show();
     $("#memo_input_li").hide();
     $("#memo_tax_num").val($(this).find('p').text());
     if ($(this).attr('name')=="") {
       $("#memo_input").val('');
     } else {
       $("#memo_input").val($(this).attr('name'));
     }
     if ($(this).hasClass('is_memo')) {
       $("#memo_delete_li").show();
     } else {
       $("#memo_delete_li").hide();
     }
     //Get window size:
     var winWidth = $(document).width();
     var winHeight = $(document).height();
     //Get pointer position:
     var posX = e.pageX;
     var posY = e.pageY;
     //Get contextmenu size:
     var menuWidth = $(".contextmenu").width();
     var menuHeight = $(".contextmenu").height();
     //Security margin:
     var secMargin = 10;
     //Prevent page overflow:
     if(posX + menuWidth + secMargin >= winWidth
     && posY + menuHeight + secMargin >= winHeight){
       //Case 1: right-bottom overflow:
       posLeft = posX - menuWidth - secMargin;
       posTop = posY - menuHeight - secMargin;
     }
     else if(posX + menuWidth + secMargin >= winWidth){
       //Case 2: right overflow:
       posLeft = posX - menuWidth - secMargin;
       posTop = posY + secMargin;
     }
     else if(posY + menuHeight + secMargin >= winHeight){
       //Case 3: bottom overflow:
       posLeft = posX + secMargin;
       posTop = posY - menuHeight - secMargin;
     }
     else {
       //Case 4: default values:
       posLeft = posX + secMargin;
       posTop = posY + secMargin;
     };
     //Display contextmenu:
     $(".contextmenu").css({
       "left": posLeft - 60 + "px",
       "top": posTop - 80 + "px"
     }).show();
     //Prevent browser default contextmenu.
     return false;
   });
   // Hide contextmenu:
   // $(document).not("ul.contextmenu").click(function(){
   //   $(".contextmenu").hide();
   // });
   $(document).mouseup(function (e){
      var LayerPopup = $(".contextmenu");
      if(LayerPopup.has(e.target).length === 0){
        $(".contextmenu").hide();
      }
    });
   Mousetrap.bind('esc', function(e) {
     $(".contextmenu").hide();
   });
 });

  </script>
</body>
</html>
