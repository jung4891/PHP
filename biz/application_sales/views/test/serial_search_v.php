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
      <table width="99%" border="0" cellspacing="0" cellpadding="0" style="border-collapse : collapse">
      <colgroup>
        <!-- <col width="2.37%" />  번    호-->
        <col width="2.37%" />	<!--종    류-->
        <col width="8%" />	<!--고 객 사-->
        <col width="11.58%" />	<!--프로젝트-->
        <col width="5.58%" />	<!--매 출 처-->
        <col width="5.58%" />	<!--제 조 사-->
        <col width="8.58%" />	<!--제 품 명 5%-->
        <col width="5.58%" />	<!--예 상 월-->
        <col width="5.58%" />	<!--진척단계-->
        <col width="5.58%" />	<!--계산서발행-->
        <col width="5.58%" />	<!--매출금액 6%-->
        <col width="5.58%" />	<!--매입금액 6%-->
        <col width="6.58%" />	<!--마진금액 6%-->
        <col width="4.08%" />	<!--마 진 율-->
        <col width="5.58%" />	<!--업    체-->
        <col width="4.08%" />	<!--담당부서-->
        <col width="5.72%" />	<!--담 당 자-->
        <col width="3.37%" /> <!--제품시리얼-->
      </colgroup>

      <tr class="" style="background-color: #F4F4F4; height:40px ">
        <!-- <th align="center">번호</th> -->
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
        <th align="center">시리얼번호</th>
      </tr>

<?php
if ($order_completed_count > 0) {
// $i = $count - $no_page_list * ( $cur_page - 1 );
// $icounter = 0;

foreach ( $order_completed_list as $item ) {

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
       <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer; border-bottom:1px solid lightgray" onclick="ViewBoard('<?php echo $item['seq'];?>')" onmousedown="copy_div(event, this, '<?php echo $item['seq'];?>');" ><?php } else {?>
         <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="border-bottom:1px solid lightgray"><?php } ?>
        <!-- <td height="40" align="center"><?php echo $i;?></td> -->
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
        <td align="center"><?php echo $item['product_serial'];?></td></a>
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
    </div><br><br>

    <div class="">
      <h3>유지보수</h3>
      <table width="99%" border="0" cellspacing="0" cellpadding="0" style="border-collapse : collapse">
        <colgroup>
          <!-- <col width="2.51%" />  번    호-->
          <col width="2.72%" />  <!--종    류-->
          <col width="8.14%" />	<!--고 객 사-->
          <col width="10.72%" />	<!--프로젝트-->
          <col width="5.52%" />	<!--제조사-->
          <col width="5.52%" />	<!--품목-->
          <col width="8.52%" />	<!--제품명-->
          <col width="5.52%" />	<!--유지보수시작일-->
          <col width="5.52%" />	<!--유지보수종료일-->
          <col width="5.52%" />	<!--매출금액-->
          <col width="5.52%" />	<!--매입금액-->
          <col width="5.52%" />	<!--마진금액-->
          <col width="6.52%" />	<!--마진율-->
          <col width="4.02%" />	<!--점검주기-->
          <col width="5.72%" />	<!--관리팀-->
          <col width="4%" />	<!--영업부서-->
          <col width="3.22%" />	<!--점검여부-->
          <col width="3.86%" />	<!--알림-->
          <col width="3.37%" /> <!--제품시리얼-->
        </colgroup>
        <tr class="t_top row-color1" style="background-color: #F4F4F4; height:40px ">
          <!-- <th height="40" align="center">번호</th> -->
          <th align="center">종류</th>
          <th align="center">고객사</th>
          <th align="center">프로젝트</th>
          <th align="center">제조사</th>
          <th align="center">품목</th>
          <th align="center">제품</th>
          <th align="center">유지보수시작일</th>
          <th align="center">유지보수종료일</th>
          <th align="center">매출금액</th>
          <th align="center">매입금액</th>
          <th align="center">마진금액</th>
          <th align="center">마진율</th>
          <th align="center">점검주기</th>
          <th align="center">관리팀</th>
          <th align="center">영업부서</th>
          <th align="center">점검여부</th>
          <th align="center">알림</th>
          <th align="center">시리얼번호</th>
        </tr>
<?php
if ($maintain_count > 0) {
// $i = $count - $no_page_list * ( $cur_page - 1 );
// $icounter = 0;

foreach ( $maintain_list as $item ) {
if($item['manage_team']=="1"){
  $strstep ="기술1팀";
}else if($item['manage_team']=="2"){
  $strstep ="기술2팀";
}else if($item['manage_team']=="3"){
  $strstep ="기술3팀";
}else{
  $strstep ="없음";
}
if($cnum == $item['company_num'] || $sales_lv >= 1) {
?>
        <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer; border-bottom:1px solid lightgray" onclick="ViewBoard('<?php echo $item['seq'];?>')">
<?php
} else {
?>
        <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="border-bottom:1px solid lightgray">
<?php
}
?>
          <!-- <td height="40" align="center"><?php echo $i;?></td> -->
          <td align="center">
            <?php
            if($item['generate_type'] != '') {
              echo $item['generate_type'];
            }
            ?>
          </td>
          <td align="center"><?php echo $item['customer_companyname'];?></td>
          <td align="center"><?php echo $item['project_name'];?></td>
          <td align="center"><?php echo $item['product_company'];?></td>
          <td align="center"><?php echo $item['product_item'];?></td>
          <td align="center"><?php echo $item['product_name'];?></td>
          <td align="center"><?php echo $item['exception_saledate2'];?></td>
          <td align="center"><?php echo $item['exception_saledate3'];?></td>
          <td align="center">
            <?php
              echo number_format($item['forcasting_sales']);
            ?>
          </td>
          <td align="center">
            <?php
              echo number_format($item['forcasting_purchase']);
            ?>
          </td>
          <td align="center">
            <?php
              if($item['forcasting_profit']!=0) {
                echo number_format($item['forcasting_profit']);
              }else{
                echo 0;
              }
            ?>
          </td>
          <td align="center">
            <?php
              if($item['forcasting_profit']!=0 && $item['forcasting_profit'] > 0) {
                echo number_format($item['forcasting_profit']*100/$item['forcasting_sales'],1)."%";
              }
            ?>
          </td>
          <td align="center">
            <?php
              if ($item['maintain_cycle'] == "1") {
                echo "월점검";
              }else if ($item['maintain_cycle'] == "3") {
                echo "분기점검";
              }else if ($item['maintain_cycle'] == "6") {
                echo "반기점검";
              }else if ($item['maintain_cycle'] == "0") {
                echo "장애시";
              }else if ($item['maintain_cycle'] == "7") {
                echo "미점검";
              }else{
                echo "미선택";
              }
            ?>
          </td>
          <td align="center"><?php echo $strstep;?></td>
          <td align="center"><?php echo $item['dept']; ?></td>
          <td align="center">
            <?php
              switch($item['maintain_result']){
                case 0:
                  echo "미완료";
                  break;
                case 1:
                  echo "완료";
                  break;
                case 2:
                  echo "미해당";
                  break;
                case 9:
                  echo "예정";
                  break;
                default:
                  echo "미선택";
                  break;
              }
              ?>
            </td>
            <?php
              $end_date = strtotime($item['exception_saledate3']);
              $today = strtotime(date('Y-m-d'));
              if ($today > $end_date) {
                $m = '기간만료';
              } else {
                $m = '진행';
              }
              if ($item['exception_saledate3'] == '') {
                $m = '';
              }
            ?>
            <td align="center"><?php echo $m; ?></td>
            <td align="center"><?php echo $item['product_serial'];?></td>

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
            <td colspan="16" height="1" bgcolor="#e8e8e8"></td>
          </tr>
<?php
}
?>
        </table>
    </div><br><br>



    <div class="">
      <h3>기술지원보고서</h3>
      <pre>
<?php
        // var_dump($tech_doc_count);
    		// echo '==================<br><br>';
    		// var_dump($tech_doc_list);
?>
      </pre>
    </div>

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
