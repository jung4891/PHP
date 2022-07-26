<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <br>
    <form id="mform" action="<?php echo site_url(); ?>/test/test/serial_search" method="get" onsubmit="chkForm() return false;">
      <input type="text" name="serial_num" value="<?php echo $serial_num; ?>" placeholder="시리얼번호 입력">
      <input type="button" name="" value="검색" onclick="chkForm(); ">
    </form>
    <br><br>

    <div class="">
      <h3>수주완료</h3>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <colgroup>
        <col width="2.37%" />  <!--번    호-->
        <col width="2.37%" />	<!--종    류-->
        <col width="9%" />	<!--고 객 사-->
        <col width="11.58%" />	<!--프로젝트-->
        <col width="5.58%" />	<!--매 출 처-->
        <col width="5.58%" />	<!--제 조 사-->
        <col width="8.58%" />	<!--제 품 명 5%-->
        <col width="5.58%" />	<!--예 상 월-->
        <col width="5.58%" />	<!--진척단계-->
        <col width="5.58%" />	<!--진척단계-->
        <col width="5.58%" />	<!--매출금액 6%-->
        <col width="5.58%" />	<!--매입금액 6%-->
        <col width="6.58%" />	<!--마진금액 6%-->
        <col width="4.08%" />	<!--마 진 율-->
        <col width="7.58%" />	<!--업    체-->
        <col width="4.08%" />	<!--담당부서-->
        <col width="4.72%" />	<!--담 당 자-->
      </colgroup>

      <tr class="t_top row-color1">
        <th align="center">번호</th>
        <th align="center">종류</th>
        <th align="center">고객사</th>
        <th align="center">프로젝트</th>
        <th align="center">매출처</th>
        <th align="center">제조사</th>
        <th align="center">제품명</th>
        <!-- <td colspan="2" align="center" style="height:30px;">제안제품</td> -->
        <th align="center">예상월</th>
        <th align="center">진척단계</th>
        <th align="center">계산서발행</th>
        <th align="center">매출금액</th>
        <th align="center">매입금액</th>
        <th align="center">마진금액</th>
        <th align="center">마진율</th>
        <th align="center">업체</th>
        <th align="center">사업부</th>
        <th align="center">영업담당자</th>
      </tr>

<?php
$count = 1;
if ($count > 0) {
// $i = $count - $no_page_list * ( $cur_page - 1 );
// $icounter = 0;

foreach ( $list_val as $item ) {

if($item['type']==1){
  $strType = "판매";
}else if($item['type']==2){
  $strType = "용역";
}else if($item['type']==3){
  $strType = "유지보수";
}else if($item['type']==4){
  $strType = "조달";
}else{
  $strType = "";
}

if($item['progress_step'] == "001") {
  $strStep = "영업보류(0%)";
} else if($item['progress_step'] == "002") {
  $strStep = "고객문의(5%)";
} else if($item['progress_step'] == "003") {
  $strStep = "영업방문(10%)";
} else if($item['progress_step'] == "004") {
  $strStep = "일반제안(15%)";
} else if($item['progress_step'] == "005") {
  $strStep = "견적제출(20%)";
} else if($item['progress_step'] == "006") {
  $strStep = "맞춤제안(30%)";
} else if($item['progress_step'] == "007") {
  $strStep = "수정견적(35%)";
} else if($item['progress_step'] == "008") {
  $strStep = "RFI(40%)";
} else if($item['progress_step'] == "009") {
  $strStep = "RFP(45%)";
} else if($item['progress_step'] == "010") {
  $strStep = "BMT(50%)";
} else if($item['progress_step'] == "011") {
  $strStep = "DEMO(55%)";
} else if($item['progress_step'] == "012") {
  $strStep = "가격경쟁(60%)";
} else if($item['progress_step'] == "013") {
  $strStep = "Spen in(70%)";
} else if($item['progress_step'] == "014") {
  $strStep = "수의계약(80%)";
} else if($item['progress_step'] == "015") {
  $strStep = "수주완료(85%)";
} else if($item['progress_step'] == "016") {
  $strStep = "매출발생(90%)";
} else if($item['progress_step'] == "017") {
  $strStep = "미수잔금(95%)";
} else if($item['progress_step'] == "018") {
  $strStep = "수금완료(100%)";
}
?>
     <?php if($cnum == $item['company_num'] || $sales_lv >= 1 ) { ?>
       <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $item['seq'];?>')" onmousedown="copy_div(event, this, '<?php echo $item['seq'];?>');"><?php } else {?>
         <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'"><?php } ?>
        <td height="40" align="center"><?php echo $i;?></td>
        <td align="center"><?php echo $strType;?></td>
        <td align="center"><?php echo $item['customer_companyname'];?></td>
        <td align="center"><?php echo $item['project_name'];?></td>
        <td align="center"><?php echo $item['sales_companyname'];?></td>
        <td align="center"><?php echo $item['product_company'];?></td>
        <td align="center"><?php echo $item['product_name'];?></td>
        <td align="center"><?php echo $item['exception_saledate'];?></td>
        <td align="center"><?php echo $strStep;?></td>
        <td align="center">
          <?php if($item['bill_progress_step'] == ""){
            echo "미발행";

          }else if($item['bill_progress_step'] == 100){
            echo "발행완료<br>({$item['bill_progress_step']}%)";
          }else if($item['bill_progress_step'] > 0){
            echo "발행중<br>(".round($item['bill_progress_step'], 5)."%)";
          }?>
        </td>
        <td align="center"><?php if(substr($item['division_month'], 0, 1) === "m"){echo number_format($item['forcasting_sales']/(substr($item['division_month'],1)));}else{echo number_format($item['forcasting_sales']/(12/$item['division_month']));}?></td>
        <td align="center"><?php if(substr($item['division_month'], 0, 1) === "m"){echo number_format($item['forcasting_purchase']/(substr($item['division_month'],1)));}else{echo number_format($item['forcasting_purchase']/(12/$item['division_month']));}?></td>
        <td align="center"><?php if($item['forcasting_profit'] != 0){if(substr($item['division_month'], 0, 1) === "m"){echo number_format($item['forcasting_profit']/(substr($item['division_month'],1)));}else{echo number_format($item['forcasting_profit']/(12/$item['division_month']));}}else{echo 0;}?></td>
        <td align="center"><?php if($item['forcasting_profit'] != 0 && $item['forcasting_profit'] > 0){ echo number_format($item['forcasting_profit']*100/$item['forcasting_sales'],1)."%";}?></td>
        <td align="center"><?php echo $item['cooperation_companyname'];?></td></a>
        <td align="center"><?php echo $item['dept'];?></td></a>
        <td align="center"><?php echo $item['cooperation_username'];?></td></a>
      </tr>

<?php
// $i--;
// $icounter++;
}
} else {
?>
<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
        <td width="100%" height="40" align="center" colspan="18">등록된 게시물이 없습니다.</td>
      </tr>
      <tr>
        <td colspan="17" height="1" bgcolor="#e8e8e8"></td>
      </tr>
<?php
}
?>


</table>
    </div>
<!--
    <div class="">
      <h3>유지보수</h3>

    </div>

    <div class="">
      <h3>기술지원보고서</h3>

    </div> -->

  </body>

  <script type="text/javascript">
    function chkForm() {
      document.getElementById('mform').submit();
    }
  </script>
</html>


<!--

<table>
  <?php foreach($user_list as $ul) { ?>
    <tr>
      <td><?php echo $ul['user_name']; ?></td>
    </tr>
  <?php } ?>
</table>



변경사항

 v -> test2.php > serial_search_v.php

 질문>
  onsubmit="chkForm() return false;" === onsubmit="return chkForm();"
 -->
