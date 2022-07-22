<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/dashboard.css">
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
    border-color:black;
    border-style:solid;
    border-width:2px;
    text-align:center;
    position: relative;
  }
  .contents_tbl thead td{
    font-size:14px;
    font-weight:bold;
    border-bottom: 1px solid black;
    background-color:#e8e8e8;
    position: sticky;
    top:35px;
  }
  .total_sum {
    border-top: 1px double black;
  }
  .contents_tbl:not(.total_tbl) th {
    height:30px;
    font-size: 16px;
    background-color: #d4d4d4;
    border-bottom: 1px solid black;
    position: sticky;
    top:0px;
  }
  .contents_tbl td, .total_tbl th{
    border-left-color:black;
    border-left-style:solid;
    border-left-width:1px;
    /* font-size: 7px; */
    word-break:break-all;
    border-bottom: 1px solid;
  }
  .project_division td{
    border-top-color:black;
    border-top-style:solid;
    border-top-width:1px;
  }
  .fixed_tr td{
    position: sticky;
    bottom:0px;
    background-color: #c1e7f7;
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
</style>
<body>
  <?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
  ?>
  <div class="dash_tbl1-1" align="center">
    <div>
      <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
        <tr height="5%">
          <td class="dash_title">
            <img src="<?php echo $misc; ?>img/dashboard/title_purchase_sales.png">
          </td>
        </tr>
      </table>
    </div>

    <div align="left" style="margin:40px">
      <form class="month_form" name="month_form" action="<?php echo site_url();?>/sales/purchase_sales/purchase_sales_view" method="get">
        <select class="select7" id="company" name="company" onchange="quarter_change();" style="width:150px;">
<?php
  if(isset($_GET['company'])) {
    $get_company = $_GET['company'];
  } else {
    $get_company = "DUIT";
  }
?>
          <option value="DUIT" <?php if ($get_company == "DUIT") { echo "selected"; }?>>두리안정보기술</option>
          <option value="ICT" <?php if ($get_company == "ICT") { echo "selected"; }?>>두리안정보통신기술</option>
          <option value="MG" <?php if ($get_company == "MG") { echo "selected"; }?>>더망고</option>
          <option value="DBS" <?php if ($get_company == "DBS") { echo "selected"; }?>>두리안정보기술부산지점</option>
        </select>
        <select class="select7" name="year" id="select_year">
<?php
  if(isset($_GET['year'])) {
    $toYear = $_GET['year'];
  } else {
    $toYear = date('Y');
  }
?>
          <option value="<?php echo $toYear ?>" selected><?php echo $toYear ?>년</option>
        </select>
        <select class="select7" name="month" id="select_month">
<?php
  if(isset($_GET['month'])) {
    $month = $_GET['month'];
  } else {
    $month = date('m');
  }

  for($i=1; $i<=12; $i++) { ?>
          <option value="<?php echo sprintf('%02d',$i); ?>" <?php echo $month == $i ? 'selected': ''?>><?php echo $i; ?>월</option>
<?php } ?>
        </select>
        <img src="<?php echo $misc;?>img/dashboard/btn/btn_search.png" width="20" onclick ="return GoSearch();" >
      </form>
    </div>

    <span align="left" style="margin-left:5vh;">
      <img width="30" name="hide_img" src="<?php echo $misc; ?>/img/dashboard/btn/btn_top.png" onclick="div_toggle('to_div', this);" style="cursor:pointer;">
    </span>

    <div class="item_div" id="to_div">
      <table class="contents_tbl total_tbl" cellspacing=0 cellpadding=0>
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
          <th>구분</th>
          <th>공급가액</th>
          <th>세액</th>
          <th>합계</th>
          <th>구분</th>
          <th>국세청전송건수</th>
          <th>구분</th>
          <th>국세청전송건수</th>
          <th style="border-bottom:none"></th>
          <th>구분</th>
          <th>공급가액</th>
          <th>세액</th>
          <th>합계</th>
          <th>구분</th>
          <th>국세청전송건수</th>
        </thead>
        <tbody>
<?php
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
            <td style="background-color:#e8e8e8"></td>
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
<?php } ?>
          <tr>
            <td class="total_sum" style="background-color:#c1e7f7">매입액</td>
            <td class="total_sum" id="total_sum_iss_in" align="right" style="padding-right:5px;background-color:#c1e7f7"></td>
            <td class="total_sum" id="total_sum_tax_in" align="right" style="padding-right:5px;background-color:#c1e7f7"></td>
            <td class="total_sum" id="total_sum_sum_in" align="right" style="padding-right:5px;background-color:#c1e7f7"></td>
            <td class="total_sum" style="padding-right:5px">총계</td>
            <td class="total_sum" id="total_sum_count_in" align="right" style="padding-right:5px"></td>
            <td colspan="2" style="border-top: 1px double black;"></td>
            <td style="background-color:#e8e8e8"></td>
            <td class="total_sum" style="background-color:#c1e7f7;">매출액</td>
            <td class="total_sum" id="total_sum_iss_out" align="right" style="padding-right:5px;background-color:#c1e7f7"></td>
            <td class="total_sum" id="total_sum_tax_out" align="right" style="padding-right:5px;background-color:#c1e7f7"></td>
            <td class="total_sum" id="total_sum_sum_out" align="right" style="padding-right:5px;background-color:#c1e7f7"></td>
            <td class="total_sum" style="padding-right:5px">총계</td>
            <td class="total_sum" id="total_sum_count_out" align="right" style="padding-right:5px"></td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</body>
