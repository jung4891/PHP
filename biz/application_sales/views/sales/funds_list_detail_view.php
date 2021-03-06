<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  $total_sales = 0;
  $total_purchase = 0;
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
<link rel="stylesheet" href="/misc/css/view_page_common.css">
</style>
<script src="<?php echo $misc;?>js/excel/excel-bootstrap-table-filter-bundle.js"></script>
<link rel="stylesheet" href="<?php echo $misc;?>js/excel/excel-bootstrap-table-filter-style.css" />
<body>
    <table width="100%" border="0" style="padding:50px;">
        <tr>
            <td class="dash_title" style="font-size:30px;">
              <?php if(isset($_GET['month'])){
                $title = $company_name.' '.$_GET['year'].'년 '.$_GET['month'].'월';
              } else if (isset($_GET['division'])){
                $title = $company_name.' '.$_GET['year'].'년 '.$_GET['division'].'분기';
              } ?>
                <?php echo $title; ?> 매출현황

            </td>
        </tr>
        <tr>
          <td align="left" style="height:40px;font-size:18px;color:#626262;">
          <?php echo $title; ?> 총매출가 : <span class="total_sales"></span> 총매입가 : <span class="total_purchase"></span>
          </td>
        </tr>
        <tr>
          <td>
            <input type="button" class="btn-common btn-style1" value="엑셀 다운" style="float:right;width:100px;" onclick="excelDownload('funds_list_detail_view','<?php echo $title; ?> 매출현황')"/>
            <img src="<?php echo $misc;?>/img/filter_refresh.png" onclick="filter_reset('funds_list_detail_view');" width=20 style="float:right;cursor:pointer;margin-right:20px;margin-top:5px;"/>
          </td>
        </tr>
        <tr>
        <td>
            <table id="funds_list_detail_view" width="100%" border="0" cellspacing="0" cellpadding="0" class="list_tbl">
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
            <thead>
              <tr class="row-color1">
                <th rowspan="2" align="center" class="">번호</th>
                <th rowspan="2" align="center" class="apply-filter no-sort">종류</th>
                <th rowspan="2" align="center" class="apply-filter no-sort">고객사</th>
                <th rowspan="2" align="center" class="apply-filter no-sort">프로젝트</th>
                <th rowspan="2" align="center" class="apply-filter no-sort">매출처</th>
                <th colspan="2" align="center" class="" style="height:30px;">제안제품</th>
                <th rowspan="2" align="center" class="apply-filter no-sort" filter_column="1">계산서발행일자</th>
                <th rowspan="2" align="center" class="">진척단계</th>
                <th rowspan="2" align="center" class="apply-filter no-sort" filter_column="2">발행회차</th>
                <th rowspan="2" align="center" class="">매출금액</th>
                <th rowspan="2" align="center" class="">매입금액</th>
                <th rowspan="2" align="center" class="">마진금액</th>
                <th rowspan="2" align="center" class="">마진율</th>
                <!-- <td rowspan="2" align="center" class="">월별매출가</td> -->
                <th rowspan="2" align="center" class="">업체</th>
                <th rowspan="2" align="center" class="apply-filter no-sort last-th" filter_column="3">사업부</th>
                <th rowspan="2" align="center" class="apply-filter no-sort last-th" filter_column="4">영업담당자</th>
              </tr>
                    <tr>
            <th style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="">제조사</th>
            <th style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="">제품명</th>
            </tr>
          </thead>
            <tbody>
            <?php
            $num = 1;
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
                } else if($item['progress_step'] == '') {
                  $strStep = '';
                }
        ?>

            <?php if($sales_lv >= "1") { ?><tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="view_board('<?php echo $item['seq']; ?>');"><?php } else {?><tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'"><?php } ?>
            <td align="center" class="" height="40" ><?php echo $num;?></td>
            <td align="center" class=""><?php echo $strType;?></td>
            <td align="center" class=""><?php echo $item['customer_companyname'];?></td>
            <td align="center" class=""><?php echo $item['project_name'];?></td>
            <td align="center" class=""><?php echo $item['sales_companyname'];?></td>
            <td align="center" class=""><?php echo $item['product_company'];?></td>
            <td align="center" class=""><?php echo $item['product_name'];?></td>
            <td align="center" class="" filter_column="1"><?php echo $item['issuance_date'];?></td>
            <td align="center" class=""><?php echo $strStep;?></td>
            <td align="center" class="" bgcolor="#FFFFF2" filter_column="2"><?php echo $item['pay_session'] ?></td>
            <td align="right" style="padding-right:5px" class="outcome"><?php if($item['bill_type']=='001'){echo number_format($item['issuance_amount']);$total_sales+=$item['issuance_amount'];} ?></td>
            <td align="right" style="padding-right:5px" class="income"><?php
            if(isset($item['sum_purchase'])){
              echo number_format($item['sum_purchase']);
              $total_purchase+=$item['sum_purchase'];
            } else if ($item['bill_type']=='002'){
              echo number_format($item['issuance_amount']);
              $total_purchase+=$item['issuance_amount'];
            }
            ?></td>
            <td align="center" class=""><?php
            if($item['bill_type']=="001"&&isset($item['sum_purchase'])){
              $margin = $item['issuance_amount']-$item['sum_purchase'];
              echo number_format($margin);
            }
             ?></td>
            <td align="center" class=""><?php
            if($item['bill_type']=="001"&&isset($item['sum_purchase'])){
              echo round($margin/$item['issuance_amount']*100)."%";
              // echo "margin=".$margin." amount=".$item['issuance_amount'];
            }
             ?></td>
            <td align="center" class=""><?php echo $item['cooperation_companyname'];?></td>
            <td align="center" class="" filter_column="3"><?php echo $item['dept'];?></td>
            <td align="center" class="" filter_column="4"><?php echo $item['cooperation_username'];?></td>

            </tr>
        <?php
                $num++;
            }
        ?>
      </tbody>
        </table></td>
        <tr>
        <td height="15"></td>
        </tr>

        <tr>
        <td align="left" style="height:40px;font-size:18px;color:#626262;">
        <?php echo $title; ?> 총매출가 : <span class="total_sales"></span> 총매입가 : <span class="total_purchase"></span>
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
    exportTable.find('.dropdown-filter-item').each(function (index, elem) {
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
    } else if (seq.indexOf('r_')!=-1) {
      location.href = "<?php echo site_url(); ?>/tech/tech_board/request_tech_support_list";
    }

    // http://biz.durianit.co.kr/index.php/sales/forcasting/order_completed_view?seq=899
  }

  //엑셀필터 적용
    $(function () {
      // Apply the plugin
      $('#funds_list_detail_view').excelTableFilter({
        columnSelector: '.apply-filter',
        captions :{a_to_z: '오름차순',
            z_to_a: '내림차순',
            search: 'Search',
            select_all: '전체'}
    });
  });

  //필터 다시 돌려
  function filter_reload(target,e){
    if(e != undefined){
      if($(e.target).attr('class').indexOf('drop') === -1){
        $('#'+target).find($(".dropdown-filter-dropdown")).remove();
        $('#'+target).excelTableFilter({
          columnSelector: '.apply-filter',
          captions :{a_to_z: '오름차순',
          z_to_a: '내림차순',
          search: 'Search',
          select_all: '전체'}
        });
      }
    }else{
      $('#'+target).find($(".dropdown-filter-dropdown")).remove();
      $('#'+target).excelTableFilter({
        columnSelector: '.apply-filter',
        captions :{a_to_z: '오름차순',
        z_to_a: '내림차순',
        search: 'Search',
        select_all: '전체'}
      });
    }
  }

  //엑셀필터 초기화
	function filter_reset(target){
		$("#"+target).find($(".오름차순:first")).trigger("click");
		$("#"+target).find("tr").show();
		$("#"+target).find("td").show();
		$("#"+target).find($(".filter_n")).val('');
		if(target.indexOf("product") !== -1){
			for (var i = 0; i <$("td[name=product_sales]").length; i++) {
				$("td[name=product_sales]").eq(i).show();
				$("td[name=product_sales]").eq(i).parent().show();
			}
			$("#filter_sales").hide();
		}
		filter_reload(target);
		$("#"+target).find($(".select-all:not(:checked)")).trigger("click");
	}

  function sum_in_out_come() {
    var sum_income = 0;
    var sum_outcome = 0;
    $(".income").each(function(){
      if($(this).is(':visible')==true){
        sum_income += Number($(this).text().replace(/,/g, ''));
      }
    })
    $(".outcome").each(function(){
      if($(this).is(':visible')==true){
        sum_outcome += Number($(this).text().replace(/,/g, ''));
      }
    })
    $(".total_purchase").text(commaStr(sum_income));
    $(".total_sales").text(commaStr(sum_outcome));
  }

  sum_in_out_come();

  // 금액 부분 콤마 추가
  function commaStr(n) {
    var reg = /(^[+-]?\d+)(\d{3})/;
    n += "";

    while (reg.test(n))
      n = n.replace(reg, "$1" + "," + "$2");
    return n;
  }


</script>
</body>
</html>
