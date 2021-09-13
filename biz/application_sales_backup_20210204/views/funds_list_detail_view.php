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
                <?php echo $company_name.' '.$_GET['year'].'-'.$_GET['month']; ?> 매출현황
                <input type="button" class="basicBtn" value="excel_download" style="float:right;vertical-align:middle;" onclick="excelDownload('funds_list_detail_view','<?php echo $company_name.' '.$_GET['year'].'-'.$_GET['month']; ?> 매출현황')"/>
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
            <col width="12%" />	<!--고 객 사-->
            <col width="13%" />	<!--프로젝트-->
            <col width="5%" />	<!--매 출 처-->
            <col width="5%" />	<!--제 조 사-->
            <col width="5%" />	<!--제 품 명-->
            <col width="5%" />	<!--예 상 월-->
            <col width="5%" />	<!--진척단계-->
            <col width="7%" />	<!--매출금액-->
            <col width="7%" />	<!--매입금액-->
            <col width="8%" />	<!--마진금액-->
            <col width="4%" />	<!--마 진 율-->
            <col width="8%" />	<!--업    체-->
            <col width="5%" />	<!--담당부서-->
            <col width="5%" />	<!--담 당 자-->
            </colgroup>
            <tr>
            <td colspan="16" height="2" bgcolor="#797c88"></td>
            </tr>
            <tr bgcolor="f8f8f9" class="t_top">
            <td rowspan="2" align="center" class="t_border">번호</td>
            <td rowspan="2" align="center" class="t_border">종류</td>
            <td rowspan="2" align="center" class="t_border">고객사</td>
            <td rowspan="2" align="center" class="t_border">프로젝트</td>
            <td rowspan="2" align="center" class="t_border">매출처</td>
            <td colspan="2" align="center" class="t_border" style="height:30px;">제안제품</td>
            <td rowspan="2" align="center" class="t_border">예상월</td>
            <td rowspan="2" align="center" class="t_border">진척단계</td>
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
            foreach ( $list_val as $item ) {
                if($item['type']==1){
                    $strType = "판매";
                }else if($item['type']==2){
                    $strType = "용역";
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
    
                if (substr($item['division_month'], 0, 1) === "m") {
                    $sum += $item['forcasting_sales'] / substr($item['division_month'], 1);
                } else {
                    $sum +=$item['forcasting_sales'] / (12 / $item['division_month']);
                } 
    ?>
            <?php if($lv == "3") { ?><tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $item['seq'];?>')"><?php } else {?><tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'"><?php } ?>
            <td align="center" class="t_border" height="40" ><?php echo $num;?></td>
            <td align="center" class="t_border"><?php echo $strType;?></td>
            <td align="center" class="t_border"><?php echo $item['customer_companyname'];?></td>
            <td align="center" class="t_border"><?php echo $item['project_name'];?></td>
            <td align="center" class="t_border"><?php echo $item['sales_companyname'];?></td>
            <td align="center" class="t_border"><?php echo $item['product_company'];?></td>
            <td align="center" class="t_border"><?php echo $item['product_name'];?></td>
            <td align="center" class="t_border"><?php echo $item['exception_saledate'];?></td>
            <td align="center" class="t_border"><?php echo $strStep;?></td>
            <td align="center" class="t_border" bgcolor="#f8f8f9"><?php if(substr($item['division_month'], 0, 1) === "m"){echo number_format($item['forcasting_sales']/(substr($item['division_month'],1)));}else{echo number_format($item['forcasting_sales']/(12/$item['division_month']));}?></td>
            <td align="center" class="t_border"><?php if(substr($item['division_month'], 0, 1) === "m"){echo number_format($item['forcasting_purchase']/(substr($item['division_month'],1)));}else{echo number_format($item['forcasting_purchase']/(12/$item['division_month']));}?></td>
            <td align="center" class="t_border"><?php if($item['forcasting_profit'] != 0){if(substr($item['division_month'], 0, 1) === "m"){echo number_format($item['forcasting_profit']/(substr($item['division_month'],1)));}else{echo number_format($item['forcasting_profit']/(12/$item['division_month']));}}else{echo 0;}?></td>
            <td align="center" class="t_border"><?php if($item['forcasting_profit'] != 0 && $item['forcasting_profit'] > 0){ echo number_format($item['forcasting_profit']*100/$item['forcasting_sales'],1)."%";}?></td>
            <td align="center" class="t_border"><?php echo $item['cooperation_companyname'];?></td></a>
            <td align="center" class="t_border"><?php echo $item['dept'];?></td>
            <td align="center" class="t_border"><?php echo $item['cooperation_username'];?></td>
            </tr>
    <?php
                $num++;
            }
    ?>
        </table></td>
        <tr>
        <td height="15"></td>
        </tr>

        <tr>
        <td height=50 align="center" style="font-size:15px;">
        <?php echo $company_name.' '.$_GET['year'].'-'.$_GET['month']; ?> 총매출가 : <?php echo number_format($sum); ?>
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


</script>
</body>
</html>