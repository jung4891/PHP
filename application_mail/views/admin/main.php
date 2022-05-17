<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/admin_side.php";
 ?>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.css"/>
 <script src="https://d3js.org/d3.v3.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.js"></script>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/style.css" type="text/css" charset="utf-8"/>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/admin.css" type="text/css" charset="utf-8"/>
<style media="screen">
  #mainContent{
    width: 100%;
    max-height: 100%;
    margin: 0px 0px 80px 0px;
  }

  .mainDiv{
    padding: 20px 20px 0px 20px;
    width: 100%;
    max-height: 100%;
  }

  .mainSelect{
    width:220px;
    height: 40px;
    outline: none;
    border: none;
    font-size: 20px;
    font-weight: 600;
  }

  #search_div{
    background-color: #FAFAFA;
    padding: 15px;
    border-top: 1px solid #565656;
    border-bottom: 1px solid #565656;
  }
</style>
<script language="javascript">
function GoSearch(){

 var searchdomain = document.mform.searchdomain.value;
 var searchdomain = searchdomain.trim();

 document.mform.action = "<?php echo site_url();?>/admin/main";
 document.mform.cur_page.value = "";
 document.mform.submit();
}

function GoFirstPage (){
 document.mform.cur_page.value = 1;
 document.mform.submit();
}

function GoPrevPage (){
 var	cur_start_page = <?php echo $cur_page;?>;

 document.mform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
 document.mform.submit( );
}

function GoPage(nPage){
 document.mform.cur_page.value = nPage;
 document.mform.submit();
}

function GoNextPage (){
 var	cur_start_page = <?php echo $cur_page;?>;

 document.mform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
 document.mform.submit();
}

function GoLastPage (){
 var	total_page = <?php echo $total_page;?>;
//	alert(total_page);

 document.mform.cur_page.value = total_page;
 document.mform.submit();
}


</script>
<div id="main_contents" align="center" style="margin: 30px 0px 50px 0px;">
  <form name="mform" action="<?php echo site_url(); ?>/admin/main" method="get">
  <div class="main_div">
    <div id="search_div" align="left" style="width:95%;">
      <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
        <select class="select_basic" id="searchdomain" name="searchdomain" style="width:150px;">
<?php foreach ($domain_list as $dl) {
  $selected = $search_domain == $dl->domain ? "selected" : "" ;
?>

            <option value="<?php echo $dl->domain; ?>" <?php echo $selected; ?>><?php echo $dl->domain; ?></option>
<?php } ?>
        </select>
<input type="button" class="btn_basic btn_blue" value="GO" style="height:30px;width:50px;" onClick="return GoSearch();">
<span style="margin-left:15px;">
  메일박스 개수 : <?php echo number_format($cnt_domain->cntbox); ?> 개
</span>
<span style="margin-left:15px;">
  그룹메일 개수 : <?php echo $cnt_domain->cntalias; ?> 개
</span>
    </div>
    <div class="infodiv" align="left" style="padding:15px;width:95%;border-bottom:1px solid black">
      <!-- <span style="margin-left:15px;">
        메일 서버 사용량:
      </span> -->
      <span style="">
        메일 박스 평균 용량 : <?php echo number_format($avg_domain->avgbytes);?> MB
      </span>
      <span style="margin-left:15px;">
        메일 박스 평균 메세지 수 : <?php echo number_format($avg_domain->avgmsg);?> 개
      </span>
    </div>
    <div class="" style="width:95%;margin-top:15px;display:flex;">
      <div class="" style="height: 80%;width:50%;display:flex;flex-direction: column;">
        <div class="">
          <div class="" align="left">
            <span id="" style="font-weight:bold;">
              메일 서버 사용량
            </span>

          </div>
          <div class="quotachart">

          </div>
          <div class="">
            <span id="total_span"></span>

          </div>
        </div>
        <div class="">
          <div class="" align="left">
            <span id="" style="font-weight:bold;">
              메일 용량 TOP5
            </span>

          </div>
          <div class="barchart">

          </div>
          <div class="">
            <span id=""></span>

          </div>
        </div>


      </div>
      <div class="" style="width:50%;display:flex;flex-direction: column;">
        <div class="" style="margin-top:5px;">
          <table class="contents_tbl"  border="0" cellspacing="0" cellpadding="0">
            <colgroup>
              <col width="40%">
              <col width="20%">
              <col width="25%">
              <col width="15%">
            </colgroup>
            <tr>
              <th>계정</th>
              <th>이름</th>
              <th>용량(Mb)</th>
              <th>메세지수(개)</th>
            </tr>
    <?php
    if ($count > 0) {
      $i = $count - $no_page_list * ( $cur_page - 1 );
      $icounter = 0;
    foreach ($mail_list as $mail) {
    ?>

    <tr style="">
      <td align="center"><?php echo $mail->username; ?></td>
      <td align="center"><?php echo $mail->name; ?></td>
      <td align="center"><?php echo round($mail->bytes/1024000,2); ?> / <?php echo round($mail->quota/1024000); ?></td>
      <td align="center"><?php echo $mail->messages; ?></td>
    </tr>

    <?php
    $i--;
    $icounter++;
      }
    }else{
    ?>
      <tr>
       <td width="100%" height="40" align="center" colspan="8">등록된 메일박스가 없습니다.</td>
      </tr>
    <?php } ?>
          </table>
        </div>

        <div class="paging_div" style="margin-top:5px;">
          <?php if ($count > 0) {?>
            <table width="400" border="0" cellspacing="0" cellpadding="0">
                <tr>
            <?php
            if ($cur_page > 10){
            ?>
                  <td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_first.png" width="20" height="20"/></a></td>
                  <td width="2"></td>
                  <td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_left.png" width="20" height="20"/></a></td>
            <?php
            } else {
            ?>
            <td width="19"></td>
                  <td width="2"></td>
                  <td width="19"></td>
            <?php
            }
            ?>
                  <td align="center">
            <?php
            for  ( $i = $start_page; $i <= $end_page ; $i++ ){
            if( $i == $end_page ) {
              $strSection = "";
            } else {
              $strSection = "&nbsp;<span class=\"section\">&nbsp&nbsp</span>&nbsp;";
            }

            if  ( $i == $cur_page ) {
              echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\"><font color=\"#6C6C6C\">".$i."</font></a>".$strSection;
            } else {
              echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\"><font color=\"#B0B0B0\">".$i."</font></a>".$strSection;
            }
            }
            ?></td>
                  <?php
            if   ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
            ?>
            <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.png" width="20" height="20"/></a></td>
                  <td width="2"></td>
                  <td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last.png" width="20" height="20"/></a></td>
            <?php
            } else {
            ?>
            <td width="19"></td>
                  <td width="2"></td>
                  <td width="19"></td>
            <?php
            }
            ?>

                </tr>
              </table>
            <?php }?>
        </div>
      </div>
    </div>
  </div>
  </form>
</div>


<script type="text/javascript">

$(function (){
  // $("#main_domain").change();
  selectDomain();
  topFive();
})
function selectDomain(){
  var selectDomain = $("#searchdomain").val();
  $.ajax({
    url: "<?php echo site_url(); ?>/admin/main/total_info",
    type: 'POST',
    dataType: 'json',
    data: {selectDomain:selectDomain},
    success: function (result) {
      percent_volume = (result[0].bytes/result[0].maxquota) * 100;
      percent_volume = percent_volume.toFixed(1);
      drawTotalChart(percent_volume);
      var tot_byte = result[0].bytes;
      var tot_quota = result[0].maxquota;
      $("#total_span").text(Number(tot_byte).toLocaleString()+" / "+Number(tot_quota).toLocaleString()+" MB");
      // $("#total_span").text(result[0].bytes+" / "+result[0].maxquota+" MB");
    }
  });
}

function drawTotalChart(data){
  var chart = c3.generate({
      bindto: ".quotachart",
      data: {
          columns: [
              ['사용량', data]
              // ['사용량', 30]
          ],
          type: 'gauge',
          // onclick: function (d, i) { console.log("onclick", d, i); },
          // onmouseover: function (d, i) { console.log("onmouseover", d, i); },
          // onmouseout: function (d, i) { console.log("onmouseout", d, i); }
      },
      gauge: {
         label: {
             // format: function(value, ratio) {
             //     return value;
             // },
             show: false // to turn off the min/max labels.
         },
  //    min: 0, // 0 is default, //can handle negative min e.g. vacuum / voltage / current flow / rate of change
  //    max: 100, // 100 is default
  //    units: ' %',
  //    width: 39 // for adjusting arc thickness
      },
      color: {
          pattern: ['#369BFF', '#fcf883', '#FF5D5D'], // the three color levels for the percentage values.
          threshold: {
  //            unit: 'value', // percentage is default
  //            max: 200, // 100 is default
              values: [50, 75, 90]
          }
      },
      size: {
          height: 120,
          width: 350
      }
  });
}


function topFive(){
  var selectDomain = $("#searchdomain").val();
  $.ajax({
    url: "<?php echo site_url(); ?>/admin/main/top_five",
    type: 'POST',
    dataType: 'json',
    data: {selectDomain:selectDomain},
    success: function (result) {
      drawTopChart(result);
    }
  });
}

function drawTopChart(data){
  var chart2 = c3.generate({
      bindto: ".barchart",
      data: {
          columns: [
              data.top_quota,
              data.top_msg
          ],
          type: 'bar',
          // axes: {
          //     용량: 'y',
          //     메세지수: 'y2'
          // }
      },
      bar: {
          width: {
              ratio: 0.5 // this makes bar width 50% of length between ticks
          }
          // or
          //width: 100 // this makes bar width 100px
      },
      axis: {
      x: {
          type: 'category',
          categories: data.top_name
      },
      // y2: {
      //         show: true
      //     }
  },
  color: {
      pattern: ['#369BFF', '#FF5D5D']
  },
  // size: {
  //     height: 250,
  //     width: 300
  // }
  });
};

// var chart = c3.generate({
//     bindto: ".barchart2",
//     data: {
//         columns: [
//             ['data1', 30, 200, 100, 400, 150, 250],
//             ['data2', 130, 100, 140, 200, 150, 50]
//         ],
//         type: 'bar'
//     },
//     bar: {
//         width: {
//             ratio: 0.5 // this makes bar width 50% of length between ticks
//         }
//         // or
//         //width: 100 // this makes bar width 100px
//     }
// });

</script>
<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>
