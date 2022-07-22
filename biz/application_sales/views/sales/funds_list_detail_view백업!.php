<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  $sum = 0;
  $company_name = '';
  if($_GET['company'] == "IT"){
        $company_name = "두리안정보기술";
    }else if($_GET['company']=="D_1"){
        $company_name = "사업1부";
    }else if($_GET['company']=="D_2"){
        $company_name = "사업2부";
    }else if($_GET['company'] == "ICT"){
        $company_name = "두리안정보통신기술";
    }else if($_GET['company']== "MG"){
        $company_name = "더망고";
    }
?>
<style>
 #funds_list_detail_view td{
    border-bottom:1px solid;
    border-bottom-color:#d7d7d7;
 }

</style>
<body>
    <table width="100%" border="0" style="padding:50px;">
        <tr>
            <td class="title3">
              <?php if(isset($_GET['month'])){
                $title = $company_name.' '.$_GET['year'].'년 '.$_GET['month'].'월';
              } else if (isset($_GET['division'])){
                $title = $company_name.' '.$_GET['year'].'년 '.$_GET['division'].'분기';
              } ?>
                <?php echo $title; ?> 매출현황
                <input type="button" class="basicBtn" value="excel_download" style="float:right;vertical-align:middle;" onclick="excelDownload('funds_list_detail_view','<?php echo $title; ?> 매출현황')"/>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
        <td>
            <table id="funds_list_detail_view" width="100%" border="0" cellspacing="0" cellpadding="0">
            <colgroup>
            <col width="3%" />  <!--번    호-->
            <col width="3%" />	<!--종    류-->
            <col width="10%" />	<!--고 객 사-->
            <col width="10%" />	<!--프로젝트-->
            <col width="5%" />	<!--매 출 처-->
            <col width="5%" />	<!--제 조 사-->
            <col width="5%" />	<!--제 품 명-->
            <col width="5%" />	<!--계산서발행일자-->
            <col width="5%" />	<!--진척단계-->
            <col width="5%" />	<!--발행회차-->
            <col width="7%" />	<!--매출금액-->
            <col width="7%" />	<!--매입금액-->
            <col width="8%" />	<!--마진금액-->
            <col width="4%" />	<!--마 진 율-->
            <col width="8%" />	<!--업    체-->
            <col width="5%" />	<!--사업부-->
            <col width="5%" />	<!--영업담당자-->
            </colgroup>
            <tr>
            <td colspan="17" height="2" bgcolor="#797c88"></td>
            </tr>
            <tr bgcolor="f8f8f9" class="t_top">
            <td rowspan="2" align="center" class="t_border">번호</td>
            <td rowspan="2" align="center" class="t_border">종류</td>
            <td rowspan="2" align="center" class="t_border">고객사</td>
            <td rowspan="2" align="center" class="t_border">프로젝트</td>
            <td rowspan="2" align="center" class="t_border">매출처</td>
            <td colspan="2" align="center" class="t_border" style="height:30px;">제안제품</td>
            <td rowspan="2" align="center" class="t_border">계산서발행일자</td>
            <td rowspan="2" align="center" class="t_border">진척단계</td>
            <td rowspan="2" align="center" class="t_border">발행회차</td>
            <td rowspan="2" align="center" class="t_border">매출금액</td>
            <td rowspan="2" align="center" class="t_border">매입금액</td>
            <td rowspan="2" align="center" class="t_border">마진금액</td>
            <td rowspan="2" align="center" class="t_border">마진율</td>
            <!-- <td rowspan="2" align="center" class="t_border">월별매출가</td> -->
            <td rowspan="2" align="center" class="t_border">업체</td>
            <td rowspan="2" align="center" class="t_border">사업부</td>
            <td rowspan="2" align="center" class="t_border">영업담당자</td>
            </tr>
                    <tr>
            <td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">제조사</td>
            <td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">제품명</td>
            </tr>
    <?php
            $num = 1;
            for ( $i=0; $i< count($list_val); $i++ ) {
                for ($j=0; $j<count($list_val[$i]); $j++) {
                $item = $list_val[$i][$j];
                  if($item['type']==1){
                      $strType = "판매";
                  }else if($item['type']==2){
                      $strType = "용역";
                  }else if($item['type']==3){
                      $strType = "유지보수";
                  }else if($item['type']==4){
                      $strType = "조달";
                  }else{
                      $strType = "미지정";
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
              <?php
              if(count($list_val[$i]) > 1){ ?>
          <?php   if ($item['bill_type']=='001'){ ?>
            <?php  if($sales_lv >= "1") { ?>
              <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="view_board('<?php echo $item['seq']; ?>');">
              <?php } else {?>
                <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
                <?php } ?>
                  <td align="center" class="t_border" height="40" ><?php echo $num;$num++;?></td>
                  <td align="center" class="t_border"><?php echo $strType;?></td>
                  <td align="center" class="t_border"><?php echo $item['customer_companyname'];?></td>
                  <td align="center" class="t_border"><?php echo $item['project_name'];?></td>
                  <td align="center" class="t_border"><?php echo $item['company_name'];?></td>
                  <td align="center" class="t_border"><?php echo $item['product_company'];?></td>
                  <td align="center" class="t_border"><?php echo $item['product_name'];?></td>
                  <td align="center" class="t_border"><?php echo $item['issuance_date'];?></td>
                  <td align="center" class="t_border"><?php echo $strStep;?></td>
                  <td align="center" class="t_border" bgcolor="#f8f8f9"><?php echo $item['pay_session'] ?></td>
                  <td align="right" class="t_border" style="padding-right:5px"><?php if($item['bill_type']=='001'){echo number_format($item['issuance_amount']);$sum+=$item['issuance_amount'];} ?></td>

                <?php if($j==0){
                  $sales_sum = 0;
                  $purchase_sum = 0;
                  $p_count = 0;
                  foreach($list_val[$i] as $k){
                    if($k['bill_type']=="001"){
                      $sales_sum += $k['issuance_amount'];
                    } else if($k['bill_type']=="002"){
                      $purchase_sum += $k['issuance_amount'];
                      $p_count++;
                    }
                  }
                  $margin = $sales_sum - $purchase_sum;
                  ?>
                  <td align="right" style="padding-right:5px" rowspan="<?php echo count($list_val[$i])-$p_count; ?>" class="t_border">
                    <?php if($purchase_sum!=0){echo number_format($purchase_sum);} ?>
                  </td>
                  <td align="right" style="padding-right:5px" rowspan="<?php echo count($list_val[$i])-$p_count; ?>" class="t_border"><?php echo number_format($margin);?></td>
                  <td align="right" style="padding-right:5px" rowspan="<?php echo count($list_val[$i])-$p_count; ?>" class="t_border"><?php
                  echo round($margin/$sales_sum*100)."%";
                  ?></td></a>
                <?php } ?>


                  <td align="center" class="t_border"><?php echo $item['cooperation_companyname'];?></td>
                  <td align="center" class="t_border"><?php echo $item['dept'];?></td>
                  <td align="center" class="t_border"><?php echo $item['cooperation_username'];?></td>
                  </tr>
                <?php } ?>

            <?php } else {

              if($sales_lv >= "1") { ?>
                <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="view_board('<?php echo $item['seq']; ?>');" >
              <?php } else {?>
                <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
              <?php } ?>
              <td align="center" class="t_border" height="40" ><?php echo $num;$num++;?></td>
              <td align="center" class="t_border"><?php echo $strType;?></td>
              <td align="center" class="t_border"><?php echo $item['customer_companyname'];?></td>
              <td align="center" class="t_border"><?php echo $item['project_name'];?></td>
              <td align="center" class="t_border"><?php echo $item['company_name'];?></td>
              <td align="center" class="t_border"><?php echo $item['product_company'];?></td>
              <td align="center" class="t_border"><?php echo $item['product_name'];?></td>
              <td align="center" class="t_border"><?php echo $item['issuance_date'];?></td>
              <td align="center" class="t_border"><?php echo $strStep;?></td>
              <td align="center" class="t_border" bgcolor="#f8f8f9"><?php if($item['bill_type']=='001'){echo $item['pay_session'];} ?></td>
              <td align="right" style="padding-right:5px" class="t_border"><?php if($item['bill_type']=='001'){echo number_format($item['issuance_amount']);$sum+=$item['issuance_amount'];} ?></td>
              <td align="right" style="padding-right:5px" class="t_border"><?php if($item['bill_type']=='002'){echo number_format($item['issuance_amount']);} ?></td>
              <td align="center" class="t_border"></td>
              <td align="center" class="t_border"></td></a>
              <td align="center" class="t_border"><?php echo $item['cooperation_companyname'];?></td>
              <td align="center" class="t_border"><?php echo $item['dept'];?></td>
              <td align="center" class="t_border"><?php echo $item['cooperation_username'];?></td>
              </tr>

            <?php } ?>
      <?php
              }
              // $num++;
            }
    ?>
        </table></td>
        <tr>
        <td height="15"></td>
        </tr>

        <tr>
        <td height=50 align="center" style="font-size:15px;">
        <?php echo $title; ?> 총매출가 : <?php echo number_format($sum); ?>
        </td>
        </tr>
        <!--페이징-->
        <tr>
        <td>&nbsp;</td>
        </tr>
    </table>

<script>
  function excelDownload(id, title) {
    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
    tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
    tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
    tab_text = tab_text + "<table border='1px'>";
    var exportTable = $('#' + id).clone();
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

  function view_board(seq){
    // alert(seq);
    if (seq.indexOf('m_')!=-1){
      var seq = seq.replace('m_','');

      $.ajax({
        type: "POST",
        // async: false,
        url: "<?php echo site_url(); ?>/sales/funds/maintain_type",
        dataType:"json",
        data: {
          seq:seq
        },
        success: function(data) {
          if (data>1){
            location.href = "<?php echo site_url(); ?>/sales/maintain/maintain_view?mode=modify&type=002&seq="+seq;
          } else {
            location.href = "<?php echo site_url(); ?>/sales/maintain/maintain_view?mode=modify&type=001&seq="+seq;
          }
        }
      })

    } else if (seq.indexOf('f_')!=-1){
      var seq = seq.replace('f_','');

      location.href = "<?php echo site_url(); ?>/sales/forcasting/order_completed_view?seq="+seq;
    }

    // http://biz.durianit.co.kr/index.php/sales/forcasting/order_completed_view?seq=899
  }


</script>
</body>
</html>
