 <?php
  // 김수성 추가
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";

$title = substr($view_val['s_date'],0,4)."년_".$view_val['month']."월_".$view_val['week']."주차_{$view_val['group_name']}_주간 업무 보고";

//정기점검2 count
if(!empty($current_cnt)){
  foreach($current_cnt as $cnt){
    if($cnt['work_name']=="정기점검2"){
      $cnt2=$cnt['cnt'];
      $cnt2_month=$cnt['month_cnt'];
    }
  }

}
if(!empty($next_cnt)){
  foreach($next_cnt as $cnt){
    if($cnt['work_name']=="정기점검2"){
      $n_cnt2=$cnt['cnt'];
    }
  }
}
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style>
  /* .td1{
    border-bottom:1px solid;
    border-bottom-color:#d7d7d7;
  }
  .td2{
    border-bottom:solid;
    border-bottom-color:#797c88;
  } */
  .dash_subTitle{
    padding-top: 15px;
    font-size: 16px;
    color: #626262;
    font-weight: bold;
  }
  #totalTable{
    font-family:"Noto Sans KR", sans-serif !important;
  }

  .list_tbl td{
    border: solid #DFDFDF;
    border-width: thin;
    height: 40px;
  }

  .row-color7{
    font-size: 14px;
  }

</style>
<script language="javascript">
  function chkForm( type ) {
    if(type == 1) {
      if (confirm("정말 삭제하시겠습니까?") == true){
        var mform = document.cform;
        mform.action="<?php echo site_url();?>/biz/weekly_report/weekly_report_delete_action";
        mform.submit();
        return false;
      }
    }
     else {
      var mform = document.cform;
      mform.action="<?php echo site_url();?>/biz/weekly_report/weekly_report_view";
      mform.submit();
      return false;
    }
  }
</script>
<body>
<?php
include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
<div class="dash1-1">
  <table id="totalTable" width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
    <script src="<?php echo $misc;?>ckeditor/ckeditor.js">
    </script>
    <tr height="5%">
      <td class="dash_title">
        주간업무보고
      </td>
    </tr>
    <tr>
      <td class="dash_subTitle">
        <?php echo substr($view_val['s_date'],0,4)."년 ".$view_val['month']."월 ".$view_val['week']."주차 {$view_val['group_name']} 주간 업무 보고";?>
      </td>
    </tr>
    <!-- 시작합니다. 여기서 부터  -->
    <form name="cform" method="get">
    <input type="hidden" name="seq" value="<?php echo $seq;?>">
    <input type="hidden" name="mode" value="modify">
    <?php if($group == "CEO" || $group =="기술연구소"){?>
    <tr>
      <td align=right>
        <div style="border:2px solid #d7d7d7; width:140px;padding:20px;background-color:#F4F4F4;" align="center">
          <div style="font-size:20px;font-weight:bold;">결재승인</div>
          <div style="margin-top:20px;">
            <input type="radio" name="approval_yn" value="Y" onchange="approval(this);" <?php if($view_val['approval_yn'] == "Y"){echo "checked";} ?> >승인
            <input type="radio" name="approval_yn" value="N" onchange="approval(this);"  <?php if($view_val['approval_yn'] == "N"){echo "checked";} ?>>미승인
          </div>
        </div>
      </td>
    </tr>
    <?php } ?>
    <tr>
      <td style="padding:10px 0px 10px 0px;">
        <input type="button" class="btn-common btn-style1" style="width:100px;" value="엑셀 다운" onclick="excel_download('excelTable','<?php echo $title ;?>');" />
        <div style="float:right;">
          <?php if($name == $view_val['writer'] || $tech_lv == 3) {?>

            <button type="button" class="btn-common btn-color1" name="button" onClick="javascript:chkForm(0);return false;"/>수정</button>
            <button type="button" class="btn-common btn-color1" name="button" onClick="javascript:chkForm(1);return false;"/>삭제</button>

          <?php }?>
          <button type="button" name="button"  class="btn-common btn-color2" onClick="<?php if (isset($_GET['dash'])){echo "go_list('dash');";}else{echo "go_list('weekly');";} ?>"/>목록</button>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding-bottom:10vh;">
                      <table id="excelTable" width="100%" border="0" cellspacing="0" cellpadding="0" class="list_tbl">
                        <colgroup>
                            <?php
                              if(strpos($view_val['group_name'], '사업') !== false || $view_val['group_name'] == '경영지원실'){
                                $max_i = 15;
                              }else if($view_val['group_name'] == '기술연구소'){
                                $max_i = 18;
                              }else{
                                $max_i = 20;
                              }
                              for($i = 1; $i <= $max_i; $i++){
                              // for($i=1; $i<=20; $i++){
                            ?>
                                <col width="<?php echo (100/20); ?>%" />

                            <?php
                              }
                            ?>
                        </colgroup>
                        <tr class="t_top row-color7">
                        <?php
                          if(strpos($view_val['group_name'], '사업') !== false || $view_val['group_name'] == '경영지원실'){
                            echo '<td colspan="15" height="15" align="center" style="font-weight:bold;">';
                          }else if($view_val['group_name'] == '기술연구소'){
                            echo '<td colspan="18" height="15" align="center" style="font-weight:bold;">';
                          }else{
                            echo '<td colspan="20" height="15" align="center" style="font-weight:bold;" >';
                          }
                        ?>

                          <?php echo $view_val['year']."년 ".$view_val['month']."월 ".$view_val['week']."주차 실적 보고 (".substr($view_val['s_date'],5,5)." ~ ".substr($view_val['e_date'],5,5).")";?>
                        </td>
                      </tr>

<?php if (strpos($view_val['group_name'],"기술") !== false && $view_val['group_name'] <> '기술연구소'){ ?>
                        <tr class="t_top row-color1">
                        <?php
                         if($current_cnt){
                         foreach($current_cnt as $cnt){
                          if( $cnt['work_name'] != "정기점검2"){
                        ?>
                          <td colspan="2" width="11%" height="30" align="center" style="font-weight:bold;" class="td1" >
                            <?php echo $cnt['work_name'];?>
                          </td>
                          <?php }}}?>
                          <td colspan="2" width="11%" height="30" align="center" style="font-weight:bold;" class="td1" >전체 지원 건수</td>
                        </tr>
                        <!-- <tr>
                          <td colspan="20" height="1" bgcolor="#e8e8e8">
                          </td>
                        </tr> -->
                        <tr>
<?php for($i=0; $i<10; $i++){ ?>
                          <td height="30" width="<?php echo (100/20); ?>%" align="center" style="font-weight:bold;" class="td1" ><?php echo "금주";?></td>
                          <td height="30" width="<?php echo (100/20); ?>%" align="center" style="font-weight:bold;" class="td1" ><?php echo "금월";?></td>
<?php } ?>
                      </tr>

                          <tr>
                          <?php
$current_sum=0;
$month_current_sum =0;
if($current_cnt){
foreach($current_cnt as $cnt){
if($cnt['month_cnt'] == null){ $cnt['month_cnt'] =0; }
if($cnt['cnt'] == null){ $cnt['cnt'] =0; }
if($cnt['work_name'] != "정기점검2"){
if($cnt['work_name'] == "정기점검"){
?>
                          <td td  height="30" align="center"  style="font-weight:bold;" class="td2" ><?php echo $cnt['cnt']+$cnt2;?></td>
                          <td  height="30" align="center" style="font-weight:bold;" class="td2" ><?php echo $cnt['month_cnt']+$cnt2_month ;?></td>
<?php }else{
?>
                         <td  height="30" align="center" style="font-weight:bold;" class="td2" ><?php echo $cnt['cnt'];?></td>
                         <td  height="30" align="center" style="font-weight:bold;" class="td2" ><?php echo $cnt['month_cnt'] ;?></td>
<?php
}
}
$month_current_sum += $cnt['month_cnt'];
$current_sum+=$cnt['cnt'];
}}
?>
                          <td height="30" align="center" style="font-weight:bold;" class="td2" >
                            <?php echo $current_sum;?>
                          </td>
                          <td height="30" align="center" style="font-weight:bold;" class="td2" >
                            <?php echo $month_current_sum;?>
                          </td>
                        </tr>

                        <tr class="t_top row-color1">
                          <td height="20" align="center" style="font-weight:bold;" class="td2" >구분</td>
                          <td colspan="2" align="center" style="font-weight:bold;" class="td2" >작업일</td>
                          <td colspan="2"  height="20" align="center" style="font-weight:bold;" class="td2" >고객사</td>
                          <td colspan="6" height="20" align="center" style="font-weight:bold;" class="td2" >제품명/host/버전/서버/라이선스</td>
                          <td colspan="4" height="20" align="center" style="font-weight:bold;" class="td2" >주요내용</td>
                          <td colspan="4" height="20" align="center" style="font-weight:bold;" class="td2" >결과</td>
                          <td height="20" align="center" style="font-weight:bold;" class="td2 ">담당SE</td>
                        </tr>
                        <!-- 반복 구간 -->
                        <?php
if(!empty($current_doc)){
foreach($current_doc as $key){
  if($key['hide'] == "N"){?>
                        <tr>
                          <td height="20" align="center"    style="font-weight:bold;" class="td1" >
                            <?php echo $key['work_name'];?>
                          </td>
                          <td colspan="2" height="20" align="center" style="font-weight:bold;" class="td1" >
                            <!-- <input type="date" class="input7" value="<?php echo substr($key['income_time'], 0, 10); ?>"> -->
                            <?php echo substr($key['income_time'], 0, 10); ?>
                          </td>
                          <td colspan="2"  height="20" align="center" style="font-weight:bold;" class="td1" >
                            <?php echo $key['customer'];?>
                          </td>
                          <td colspan="6" height="20" align="center" style="font-weight:bold;" class="td1" >
                            <?php echo nl2br($key['produce']); ?>
                          </td>
                          <td colspan="4" height="20" align="center" style="font-weight:bold;" class="td1" >
                            <?php echo nl2br($key['subject']);?>
                          </td>
                          <td colspan="4" height="20" align="center" style="font-weight:bold;" class="td1" >
                            <?php echo nl2br($key['result']); ?>
                          </td>
                          <td height="20" align="center" style="font-weight:bold;" class="td1" >
                            <?php echo $key['writer'];?>
                          </td>
                          <?php }
  }
}?>
                        <tr>
                          <td colspan="20" height="45" align="center"    style="font-weight:bold;" class="t_border" >
                          </td>
                        </tr>
                          <!-- 반복구간 끝 -->

                        <!-- 차주 보고 -->

                        <tr class="t_top row-color7">
                          <td colspan="20" align="center" style="font-weight:bold;" class="td2"  >
                            <?php echo date("Y",strtotime("+7 day",strtotime($view_val['s_date'])))."년 ".date("m",strtotime("+7 day",strtotime($view_val['s_date'])))."월 "?>
                            <span id="next_week"></span>
                            <?php echo "주차 계획 보고 (".date("m-d",strtotime("+7 day",strtotime($view_val['s_date'])))." ~ ".date("m-d",strtotime("+7 day",strtotime($view_val['e_date']))).")";?>
                          </td>
                        </tr>
                        <!-- <tr>
                          <td colspan="20" height="2" bgcolor="#797c88">
                          </td>
                        </tr> -->
                        <tr class="t_top row-color1">
                          <?php
                          foreach($next_cnt as $cnt){
                          if( $cnt['work_name'] != "정기점검2"){
                          ?>
                          <td colspan="2" width="11%" height="30" align="center"    style="font-weight:bold;" class="td1" >
                            <?php echo $cnt['work_name'];?>
                          </td>
                          <?php }}?>
                          <td colspan="2" height="30" align="center"  style="font-weight:bold;" class="td1" >전체 지원 건수</td>
                        </tr>
                        <!-- <tr>
                          <td colspan="20" height="1" bgcolor="#e8e8e8">
                          </td>
                        </tr> -->
                        <tr>
                          <?php
$n_sum=0;
foreach($next_cnt as $cnt){
if($cnt['cnt'] == null){
  $cnt['cnt'] = 0;
}
if( $cnt['work_name'] != "정기점검2"){
if($cnt['work_name'] == "정기점검"){
?>
                          <td colspan="2" width="11%"  height="30" align="center" style="font-weight:bold;" class="td2" >
                            <?php echo ($cnt['cnt'])+($n_cnt2);?>
                          </td>
<?php
}else{
?>
                          <td colspan="2" width="11%"  height="30" align="center"  style="font-weight:bold;" class="td2" >
                            <?php echo $cnt['cnt'];?>
                          </td>
                          <?php
}
}
$n_sum+=$cnt['cnt'];
}
?>
                          <td colspan="2" height="30" align="center" style="font-weight:bold;" class="td2" >
                            <?php echo $n_sum; ?>
                          </td>
                        </tr>
                        <tr class="t_top row-color1">
                          <td height="20" align="center" style="font-weight:bold;" class="td2" >구분</td>
                          <td colspan="2" align="center" style="font-weight:bold;" class="td2" >작업일</td>
                          <td colspan="2"  height="20" align="center" style="font-weight:bold;" class="td2" >고객사</td>
                          <td colspan="6" height="20" align="center" style="font-weight:bold;" class="td2" >제품명/host/버전/서버/라이선스</td>
                          <td colspan="4" height="20" align="center" style="font-weight:bold;" class="td2" >주요내용</td>
                          <td colspan="4" height="20" align="center" style="font-weight:bold;" class="td2" >준비사항</td>
                          <td height="20" align="center" style="font-weight:bold;" class="td2" >담당SE</td>
                        <!-- <tr>
                          <td colspan="20" height="2" bgcolor="#797c88"></td>
                        </tr> -->
                        <!-- 반복 구간 -->
                        <?php
if(!empty($next_doc)){
foreach($next_doc as $key){
  if($key['hide'] == "N"){ ?>
                        <!-- <tr>
                          <td colspan="20" height="1" bgcolor="#e8e8e8">
                          </td>
                        </tr> -->
                        <tr>
                          <td height="20" align="center"    style="font-weight:bold;" class="td1" >
                            <?php echo $key['work_name'];?>
                          </td>
                          <td colspan="2" height="20" align="center"    style="font-weight:bold;" class="td1" >
                            <?php echo substr($key['income_time'], 0, 10); ?>
                          </td>
                          <td colspan="2"  height="20" align="center"    style="font-weight:bold;" class="td1" >
                            <?php echo $key['customer'];?>
                          </td>
                          <td colspan="6" height="20" align="center"    style="font-weight:bold;" class="td1" >
                            <?php echo nl2br($key['produce']);?>
                          </td>
                          <td colspan="4" height="20" align="center"    style="font-weight:bold;" class="td1" >
                            <?php echo nl2br($key['subject']);?>
                          </td>
                          <td colspan="4" height="20" align="center"    style="font-weight:bold;" class="td1" >
                            <?php echo nl2br($key['preparations']);?>
                          </td>
                          <td height="20" align="center"    style="font-weight:bold;" class="td1" >
                            <?php echo $key['writer'];?>
                          </td>
                          <?php }
  }
}?>
                        </tr>
<!-- 반복구간 끝 -->


<!-- 여기서부터 기술연구소 -->
<?php }else if(($view_val['group_name'] == '기술연구소' )){ ?>

                    <tr class="t_top row-color1">
                        <td colspan="4" height="30" align="center"    style="font-weight:bold;" class="td1">
                            신규개발
                        </td>
                        <td colspan="4" height="30" align="center"    style="font-weight:bold;" class="td1">
                            버그수정
                        </td>
                        <td colspan="4" height="30" align="center"    style="font-weight:bold;" class="td1">
                            기능개선
                        </td>
                        <td colspan="6" height="30" align="center"    style="font-weight:bold;" class="td1">
                            전체 개발 건수
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" height="30" width="<?php echo (100/18)*2; ?>%" align="center"    style="font-weight:bold;" class="td1"><?php echo "금월";?></td>
                        <td colspan="2" height="30" width="<?php echo (100/18)*2; ?>%" align="center"    style="font-weight:bold;" class="td1"><?php echo "금주";?></td>
                        <td colspan="2" height="30" width="<?php echo (100/18)*2; ?>%" align="center"    style="font-weight:bold;" class="td1"><?php echo "금월";?></td>
                        <td colspan="2" height="30" width="<?php echo (100/18)*2; ?>%" align="center"    style="font-weight:bold;" class="td1"><?php echo "금주";?></td>
                        <td colspan="2" height="30" width="<?php echo (100/18)*2; ?>%" align="center"    style="font-weight:bold;" class="td1"><?php echo "금월";?></td>
                        <td colspan="2" height="30" width="<?php echo (100/18)*2; ?>%" align="center"    style="font-weight:bold;" class="td1"><?php echo "금주";?></td>
                        <td colspan="3" height="30" width="<?php echo (100/18)*3; ?>%"align="center"    style="font-weight:bold;" class="td1"><?php echo "금월";?></td>
                        <td colspan="3" height="30" width="<?php echo (100/18)*3; ?>%"align="center"    style="font-weight:bold;" class="td1"><?php echo "금주";?></td>
                    </tr>

<?php
$month_total_cnt=0;
$week_total_cnt=0;
$improvement=array();
$new=array();
$bug=array();
if(!empty($current_cnt)){
foreach($current_cnt as $cnt){
    if($cnt['work_name']=='신규개발'){
        $new['cnt']=$cnt['cnt'];
        $new['month_cnt']=$cnt['month_cnt'];
        $week_total_cnt+= (int)$cnt['cnt'];
        $month_total_cnt+=(int)$cnt['month_cnt'];
    }else if($cnt['work_name']=='버그수정'){
        $bug['cnt']=$cnt['cnt'];
        $bug['month_cnt']=$cnt['month_cnt'];
        $week_total_cnt+=(int)$cnt['cnt'];
        $month_total_cnt+=(int)$cnt['month_cnt'];
    }else if($cnt['work_name']== '기능개선'){
        $improvement['cnt']=$cnt['cnt'];
        $improvement['month_cnt']=$cnt['month_cnt'];
        $week_total_cnt+=(int)$cnt['cnt'];
        $month_total_cnt+=(int)$cnt['month_cnt'];
    }
}
}
?>
                    <tr>
                      <td colspan="2" height="30" align="center"    style="font-weight:bold;" class="td2"><?php if(!isset($new['month_cnt'])){echo 0;} else {echo $new['month_cnt'];} ?></td>
                      <td colspan="2" height="30" align="center"    style="font-weight:bold;" class="td2"><?php if(!isset($new['cnt'])){echo 0;} else {echo $new['cnt'];} ?></td>
                      <td colspan="2" height="30" align="center"    style="font-weight:bold;" class="td2"><?php if(!isset($bug['month_cnt'])){echo 0;} else {echo $bug['month_cnt'];} ?></td>
                      <td colspan="2" height="30" align="center"    style="font-weight:bold;" class="td2"><?php if(!isset($bug['cnt'])){echo 0;} else {echo $bug['cnt'];} ?></td>
                      <td colspan="2"height="30" align="center"    style="font-weight:bold;" class="td2"><?php if(!isset($improvement['month_cnt'])){echo 0;} else {echo $improvement['month_cnt'];} ?></td>
                      <td colspan="2" height="30" align="center"    style="font-weight:bold;" class="td2"><?php if(!isset($improvement['cnt'])){echo 0;} else {echo $improvement['cnt'];} ?></td>
                      <td colspan="3" height="30" align="center"    style="font-weight:bold;" class="td2"><?php echo $month_total_cnt;?></td>
                      <td colspan="3" height="30" align="center"    style="font-weight:bold;" class="td2"><?php echo $week_total_cnt;?></td>
                  </tr>
                  <tr class="t_top row-color1">
                    <td colspan="1"  height="20" align="center"    style="font-weight:bold;" class="td2" >구분</td>
                    <td colspan="1"  height="20" align="center"    style="font-weight:bold;" class="td2" >요청일자</td>
                    <td colspan="1"  height="20" align="center"    style="font-weight:bold;" class="td2" >페이지</td>
                    <td colspan="1"  height="20" align="center"    style="font-weight:bold;" class="td2" >요청자</td>
                    <!-- <td colspan="6" height="20" align="center"    style="font-weight:bold;" class="t_border" >제품명/host/버전/서버/라이선스</td> -->
                    <td colspan="5" height="20" align="center"    style="font-weight:bold;" class="td2" >요청사항</td>
                    <td colspan="5" height="20" align="center"    style="font-weight:bold;" class="td2" >개발사항</td>
                    <td colspan="2" height="20" align="center"    style="font-weight:bold;" class="td2" >결과</td>
                    <td colspan="1" height="20" align="center"    style="font-weight:bold;" class="td2" >완료일자</td>
                    <td colspan="1" height="20" align="center"    style="font-weight:bold;" class="td2">담당 </td>
                  </tr>
                  <!-- 반복 구간 -->
                        <?php
if(!empty($current_doc)){
foreach($current_doc as $key){
  if($key['hide'] == "N"){ ?>
                  <tr>
                    <td colspan="1" height="20" align="center"    style="font-weight:bold;" class="td1" >
                      <?php echo $key['work_name'];?>
                    </td>
                    <td colspan="1" height="20" align="center"    style="font-weight:bold;" class="td1" >
                      <?php echo substr($key['income_time'], 0, 10); ?>
                    </td>
                    <td colspan="1"  height="20" align="center"    style="font-weight:bold;" class="td1" >
                      <?php echo $key['customer'];?>
                    </td>
                    <td colspan="1"  height="20" align="center"    style="font-weight:bold;" class="td1" >
                      <?php echo $key['type'];?>
                    </td>
                    <td colspan="5" height="20"    style="font-weight:bold;" class="td1" >
                      <?php echo nl2br($key['produce']);?>
                    </td>
                    <td colspan="5" height="20"    style="font-weight:bold;" class="td1" >
                      <?php echo nl2br($key['subject']);?>
                    </td>
                    <td colspan="2" height="20"    style="font-weight:bold;text-align:center;" class="td1" >
                      <?php echo nl2br($key['result']); ?>
                    </td>
                    <td colspan="1" height="20" align="center"    style="font-weight:bold;" class="td1" >
                      <?php echo substr($key['completion_time'], 0, 10); ?>
                    </td>
                    <td colspan="1" height="20" align="center"    style="font-weight:bold;" class="td1" >
                      <?php echo $key['writer'];?>
                    </td>
                          <?php }
 }
}?>
                          <!-- 반복구간 끝 -->
                  <tr>
                    <td colspan="18" height="45" align="center"    style="font-weight:bold;" class="t_border" >
                    </td>
                  </tr>
                  <!-- 차주 보고 -->
                  <tr class="t_top row-color7">
                    <td colspan="18" height="15" align="center" style="font-weight:bold;" class="td2"  >
                    <!-- <td colspan="20" height="15" align="center" style="font-weight:bold;" class="td2"  > -->
                      <?php echo date("Y",strtotime("+7 day",strtotime($view_val['s_date'])))."년 ".date("m",strtotime("+7 day",strtotime($view_val['s_date'])))."월 "?>
                      <span id="next_week"></span>
                      <?php echo "주차 계획 보고 (".date("m-d",strtotime("+7 day",strtotime($view_val['s_date'])))." ~ ".date("m-d",strtotime("+7 day",strtotime($view_val['e_date']))).")";?>
                    </td>
                  </tr>
                  <!-- <tr>
                    <td colspan="20" height="2" bgcolor="#797c88">
                    </td>
                  </tr> -->
                  <tr class="t_top row-color1">
                      <td colspan="4" height="30" align="center"    style="font-weight:bold;" class="td1">
                          신규개발
                      </td>
                      <td colspan="4" height="30" align="center"    style="font-weight:bold;" class="td1">
                          버그수정
                      </td>
                      <td colspan="4" height="30" align="center"    style="font-weight:bold;" class="td1">
                          기능개선
                      </td>
                      <td colspan="6" height="30" align="center"    style="font-weight:bold;" class="td1">
                          전체 개발 건수
                      </td>
                  </tr>
                  <!-- <tr>
                      <td colspan="20" height="1" bgcolor="#e8e8e8"></td>
                  </tr>                                                      -->
<?php
$week_total_cnt=0;
$improvement=array();
$new=array();
$bug=array();
if(!empty($next_cnt)){
foreach($next_cnt as $cnt){
    if($cnt['work_name']=='신규개발'){
        $new['cnt']=$cnt['cnt'];
        $week_total_cnt+= (int)$cnt['cnt'];
    }else if($cnt['work_name']=='버그수정'){
        $bug['cnt']=$cnt['cnt'];
        $week_total_cnt+=(int)$cnt['cnt'];
    }else if($cnt['work_name']== '기능개선'){
        $improvement['cnt']=$cnt['cnt'];
        $week_total_cnt+=(int)$cnt['cnt'];
    }
}
}
?>
                  <tr>
                    <td colspan="4" height="30" align="center"    style="font-weight:bold;" class="td2"><?php if(!isset($new['cnt'])){echo 0;} else {echo $new['cnt'];} ?></td>
                    <td colspan="4" height="30" align="center"    style="font-weight:bold;" class="td2"><?php if(!isset($bug['cnt'])){echo 0;} else {echo $bug['cnt'];} ?></td>
                    <td colspan="4" height="30" align="center"    style="font-weight:bold;" class="td2"><?php if(!isset($improvement['cnt'])){echo 0;} else {echo $improvement['cnt'];} ?></td>
                    <td colspan="6" height="30" align="center"    style="font-weight:bold;" class="td2"><?php echo $week_total_cnt;?></td>
                  </tr>

                  <tr class="t_top row-color1">
                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="td2" >구분</td>
                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="td2" >요청일자</td>
                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="td2" >페이지</td>
                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="td2" >요청자</td>
                    <td colspan="5" height="20" align="center" style="font-weight:bold;" class="td2" >요청사항</td>
                    <td colspan="7" height="20" align="center" style="font-weight:bold;" class="td2" >개발예정사항</td>
                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="td2" >예정일자</td>
                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="td2" >담당자</td>
                  <!-- <tr>
                    <td colspan="20" height="2" bgcolor="#797c88"></td>
                  </tr> -->
                  <!-- 반복 구간 -->
                        <?php
if(!empty($next_doc)){
foreach($next_doc as $key){
  if($key['hide'] == "N"){?>
                  <!-- <tr>
                    <td colspan="20" height="1" bgcolor="#e8e8e8">
                    </td>
                  </tr> -->
                  <tr>
                    <td colspan="1" height="20" align="center"    style="font-weight:bold;" class="td1" >
                      <?php echo $key['work_name'];?>
                    </td>
                    <td colspan="1" height="20" align="center"    style="font-weight:bold;" class="td1" >
                      <?php echo substr($key['income_time'], 0, 10); ?>
                    </td>
                    <td colspan="1"  height="20" align="center"    style="font-weight:bold;" class="td1" >
                      <?php echo $key['customer'];?>
                    </td>
                    <td colspan="1"  height="20" align="center"    style="font-weight:bold;" class="td1" >
                      <?php echo $key['type'];?>
                    </td>
                    <td colspan="5" height="20"    style="font-weight:bold;" class="td1" >
                      <?php echo nl2br($key['produce']);?>
                    </td>
                    <td colspan="7" height="20"    style="font-weight:bold;" class="td1" >
                      <?php echo nl2br($key['subject']);?>
                    </td>
                    <td colspan="1" height="20" align="center"    style="font-weight:bold;" class="td1" >
                      <?php echo substr($key['completion_time'], 0, 10); ?>
                    </td>
                    <td colspan="1" height="20" align="center"    style="font-weight:bold;" class="td1" >
                      <?php echo $key['writer'];?>
                    </td>
                  </tr>
<?php }
  }
}?>

<!-- 여기서부터 영업본부,경영지원실 -->
<?php }else if(($view_val['group_name'] == '영업본부' ) || ($view_val['group_name'] == '사업1부' ) || ($view_val['group_name'] == '사업2부' ) || ($view_val['group_name'] == '경영지원실' )){ ?>
                <tr class="t_top row-color1">
                  <td colspan="2"  height="20" width="<?php echo (100/15)*2; ?>%" align="center"    style="font-weight:bold;" class="td2" >일자</td>
        <?php if(($view_val['group_name'] == '경영지원실' )){ ?>
                  <td colspan="3"  height="20" width="<?php echo (100/15)*3; ?>%" align="center"    style="font-weight:bold;" class="td2" >업체명</td>
                  <td colspan="8" height="20" width="<?php echo (100/15)*8; ?>%" align="center"    style="font-weight:bold;" class="td2" >내용</td>
        <?php } else { ?>
                  <td colspan="2"  height="20" width="<?php echo (100/15)*3; ?>%" align="center"    style="font-weight:bold;" class="td2" >고객사</td>
                  <td colspan="2"  height="20" width="<?php echo (100/15)*3; ?>%" align="center"    style="font-weight:bold;" class="td2" >방문 업체</td>
                  <td colspan="7" height="20" width="<?php echo (100/15)*8; ?>%" align="center"    style="font-weight:bold;" class="td2" >내용</td>
        <?php } ?>
                  <td colspan="2" height="20" width="<?php echo (100/15)*2; ?>%" align="center"    style="font-weight:bold;" class="td2">담당자</td>
                </tr>
                <!-- 반복 구간 -->
                        <?php
if(!empty($current_doc)){
foreach($current_doc as $key){
  if($key['hide'] == "N"){ ?>
                <tr>
                  <td colspan="2" height="20" align="center"    style="font-weight:bold;" class="td1" >
                    <?php echo substr($key['income_time'], 0, 10); ?>
                  </td>
        <?php if(($view_val['group_name'] == '경영지원실' )){ ?>
                  <td colspan="3"  height="20" align="center"    style="font-weight:bold;" class="td1" >
                    <?php echo $key['customer'];?>
                  </td>
                  <td colspan="8" height="20"    style="font-weight:bold;" class="td1" >
                    <?php echo nl2br($key['subject']);?>
                  </td>
        <?php } else { ?>
                  <td colspan="2"  height="20" align="center"    style="font-weight:bold;" class="td1" >
                    <?php echo $key['customer'];?>
                  </td>
                  <td colspan="2"  height="20" align="center"    style="font-weight:bold;" class="td1" >
                    <?php echo $key['visit_company'];?>
                  </td>
                  <td colspan="7" height="20"    style="font-weight:bold;" class="td1" >
                    <?php echo nl2br($key['subject']);?>
                  </td>
        <?php } ?>
                  <td colspan="2" height="20" align="center"    style="font-weight:bold;" class="td1" >
                    <?php echo $key['writer'];?>
                  </td>
<?php }
 }
}?>
                          <!-- 반복구간 끝 -->
                <tr>
                  <td colspan="15" height="45" align="center"    style="font-weight:bold;" class="t_border" >
                  <!-- <td colspan="20" height="45" align="center"    style="font-weight:bold;" class="t_border" > -->
                  </td>
                </tr>
                <!-- 차주 보고 -->
                <tr class="t_top row-color7">
                  <td colspan="15" height="15" align="center" style="font-weight:bold;" class="td2"  >
                  <!-- <td colspan="20" height="15" align="center" style="font-weight:bold;" class="td2"  > -->
                    <?php echo date("Y",strtotime("+7 day",strtotime($view_val['s_date'])))."년 ".date("m",strtotime("+7 day",strtotime($view_val['s_date'])))."월 "?>
                    <span id="next_week"></span>
                    <?php echo "주차 계획 보고 (".date("m-d",strtotime("+7 day",strtotime($view_val['s_date'])))." ~ ".date("m-d",strtotime("+7 day",strtotime($view_val['e_date']))).")";?>
                  </td>
                </tr>
                <tr class="t_top row-color1">
                  <td colspan="2" height="20" align="center"    style="font-weight:bold;" class="td2" >일자</td>
<?php if(($view_val['group_name'] == '경영지원실' )){ ?>
                  <td colspan="3" height="20" align="center"    style="font-weight:bold;" class="td2" >업체명</td>
                  <td colspan="8" height="20" align="center"    style="font-weight:bold;" class="td2" >내용</td>
<?php } else { ?>
                  <td colspan="2" height="20" align="center"    style="font-weight:bold;" class="td2" >고객사</td>
                  <td colspan="2" height="20" align="center"    style="font-weight:bold;" class="td2" >방문 업체</td>
                  <td colspan="7" height="20" align="center"    style="font-weight:bold;" class="td2" >내용</td>
<?php } ?>
                  <td colspan="2" height="20" align="center"    style="font-weight:bold;" class="td2" >담당자</td>
                <!-- 반복 구간 -->
                        <?php
if(!empty($next_doc)){
foreach($next_doc as $key){
  if($key['hide'] == "N"){?>
                <tr>
                  <td colspan="2" height="20" align="center"    style="font-weight:bold;" class="td1" >
                    <?php echo substr($key['income_time'], 0, 10); ?>
                  </td>
<?php if(($view_val['group_name'] == '경영지원실' )){ ?>
                  <td colspan="3"  height="20" align="center"    style="font-weight:bold;" class="td1" >
                    <?php echo $key['customer'];?>
                  </td>
                  <td colspan="8" height="20"    style="font-weight:bold;" class="td1" >
                    <?php echo nl2br($key['subject']);?>
                  </td>
<?php } else { ?>
                  <td colspan="2"  height="20" align="center"    style="font-weight:bold;" class="td1" >
                    <?php echo $key['customer'];?>
                  </td>
                  <td colspan="2"  height="20" align="center"    style="font-weight:bold;" class="td1" >
                    <?php echo $key['visit_company'];?>
                  </td>
                  <td colspan="7" height="20"    style="font-weight:bold;" class="td1" >
                    <?php echo nl2br($key['subject']);?>
                  </td>
<?php } ?>
                  <td colspan="2" height="20" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="td1" >
                    <?php echo $key['writer'];?>
                  </td>
                </tr>
<?php }
  }
}?>

<?php } ?>

                        <tr class="t_top row-color7">
                          <?php
                            if(strpos($view_val['group_name'], '사업') !== false || $view_val['group_name'] == '경영지원실'){
                              echo '<td colspan="15" height="15" align="center" style="font-weight:bold;" class="td2">';
                            }else if($view_val['group_name'] == '기술연구소'){
                              echo '<td colspan="18" height="15" align="center" style="font-weight:bold;" class="td2">';
                            }else{
                              echo '<td colspan="20" height="15" align="center" style="font-weight:bold;" class="td2">';
                            }
                          ?>

                            보고 및 이슈사항
                          </td>
                        </tr>

                        <tr>
                          <?php
                            if(strpos($view_val['group_name'], '사업') !== false || $view_val['group_name'] == '경영지원실'){
                              echo '<td colspan="15" height="40" align="left" style="font-weight:bold;" class="t_border">';
                            }else if($view_val['group_name'] == '기술연구소'){
                              echo '<td colspan="18" height="40" align="left" style="font-weight:bold;" class="t_border">';
                            }else{
                              echo '<td colspan="20" height="40" align="left" style="font-weight:bold;" class="t_border">';
                            }
                          ?>
                          <!-- <td colspan="20" height="40" align="left" style="font-weight:bold;" class="t_border"> -->
                          <?php if ($view_val['comment'] == "" || $view_val['comment'] == null ){?>
                          - 특이사항 없음
                          <?php }else{
                            echo nl2br($view_val['comment']);
                          } ?>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
        </table>
      </td>
    </tr>
    </form>
  <!-- 폼 끝 -->
  </table>
</div>
</div>
  <?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
  <script>
  $("#next_week").text((Math.ceil((new Date(<?php echo date("Y",strtotime("+7 day",strtotime($view_val['s_date']))); ?>, <?php echo date("m",strtotime("+7 day",strtotime($view_val['s_date']))); ?>, <?php echo date("d",strtotime("+7 day",strtotime($view_val['s_date']))); ?>).getDate()+1)/7)).toString());

  function excel_download(id, title){
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
  function go_list(page){
		if (page=="dash") {
			window.location = "<?php echo site_url(); ?>/biz/weekly_report/weekly_report_list";
		} else {
			history.go(-1);
		}
	}

  //대표님 결재 할때
  function approval(obj){
    var val = $(obj).val();
    var text = "";
    if(val == "Y"){
      text = "승인";
    }else{
      text = "미승인";
    }

    if(confirm("결재를 "+text+ " 하시겠습니까?")){
      $.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url();?>/biz/weekly_report/report_approval",
			dataType: "json",
			async: false,
			data: {
        seq : "<?php echo $_GET['seq']; ?>",
				val : val
			},
			success: function (data) {
				if(data){
          alert("저장완료");
          location.reload();
        }else{
          alert("저장 실패");
        }
			}
		});

    }else{
      return false;
    }
  }
  </script>
</body>
</html>
