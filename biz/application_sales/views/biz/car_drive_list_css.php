<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
  // tech_doc_list 김수성
?>
<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
<?php if ($this->agent->is_mobile()==false){ ?>
  <link rel="stylesheet" href="/misc/css/dashboard.css">
<?php } ?>
<link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="/misc/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/misc/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<style>
  @media (max-width: 575px) {
    .none_mobile, #search_table {
      display:none;
    }
    .dash_title {
      height:2vh;
    }
    .drive_list {
      width:95%;
      margin-left: 9px;
      /* margin-right: 3px; */
      border-radius:12px;
      box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.36);
      font-family:"Noto Sans KR", sans-serif !important;
      font-weight: bold;
    }
    .drive_list tr {
      height:10vh;
    }
    .drive_list td {
      border-bottom: 1.5px solid rgba(0, 0, 0, 0.19);
    }
    .drive_list tr:last-child > td {
      border-bottom: none;
    }
  }
</style>
<script language="javascript">
function GoSearch(){
  var searchkeyword = document.mform.searchkeyword.value;
  var searchkeyword = searchkeyword.trim();

//  if(searchkeyword == ""){
//    alert( "검색어를 입력해 주세요." );
//    return false;
//  }

  document.mform.action = "<?php echo site_url();?>/biz/durian_car/car_drive_list";
  document.mform.cur_page.value = "";
//  document.mform.search_keyword.value = searchkeyword;
  document.mform.submit();
}

$(function(){
  $('#drive_date, #add_drive_date').datepicker({
    clearBtn : false
  });
  var date = new Date();
  date = getFormatDate(date);
  $('#add_drive_date').val(date);
  $('#d_time, #add_d_time, #a_time, #add_a_time').timepicker({
      minuteStep: 10,
      // template: 'modal',
      // appendWidgetTo: 'body',
      // showSeconds: true,
      showMeridian: false
      // defaultTime: false
  });
  $('#d_time, #a_time').attr( "onchange","modifyInput(this);" );
})

function getFormatDate(date){
    var year = date.getFullYear();              //yyyy
    var month = (1 + date.getMonth());          //M
    month = month >= 10 ? month : '0' + month;  //month 두자리로 저장
    var day = date.getDate();                   //d
    day = day >= 10 ? day : '0' + day;          //day 두자리로 저장
    return  year + '-' + month + '-' + day;       //'-' 추가하여 yyyy-mm-dd 형태 생성 가능
}


$(function(){
  find_add_car_a_km();
});

//$(document).ready(function() {
//   $('li > ul').show();
//});
</script>
<style media="screen">
  .input_border{
    border: none;
    font-size: 12px;
  }
</style>
<body>
<?php
  if ($this->agent->is_mobile()){
    include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  } else {
    include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
  }
?>
<div align="center">
<div class="dash1-1">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<form name="mform" action="<?php echo site_url();?>/biz/durian_car/car_drive_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">
<tbody height="100%">
<tr height="5%">
  <td class="dash_title"><img class="none_mobile" src="<?php echo $misc;?>img/dashboard/title_car_drive_list.png"/></td>
</tr>

<!-- 검색창 -->
<tr height="10%">
  <td align="left" valign="bottom">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" id="search_table">
      <tr>
        <td class="none_mobile" width="10%"></td>
        <td>
          <select name="search1" id="search1" class="select7">
            <option value="001" <?php if($search1 == "001"){ echo "selected";}?>>차번</option>
            <option value="002" <?php if($search1 == "002"){ echo "selected";}?>>출발지</option>
            <option value="003" <?php if($search1 == "003"){ echo "selected";}?>>목적지</option>
            <option value="004" <?php if($search1 == "004"){ echo "selected";}?>>운행자</option>
            <option value="005" <?php if($search1 == "005"){ echo "selected";}?>>운행일</option>
          </select>
        <span>
          <input type="text" size="25" class="input2" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
        </span>
        <span>
          <input type="image" style='cursor:hand; margin-bottom:8px;' onClick="return GoSearch();" src="<?php echo $misc;?>img/dashboard/btn/btn_search.png" width="20px" height="20px" align="middle" border="0" />
        </span>
        </td>
      </tr>
    </table>
  </td>
</tr>

<!-- 입력창 -->
<tr height="10%">
  <td align="left" valign="bottom">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="none_mobile">
      <colgroup>
        <col width="10%">
        <col width="8%">
        <col width="8%">
        <col width="8%">
        <col width="6%">
        <col width="6%">
        <col width="5%">
        <col width="4%">
        <col width="4%">
        <col width="7%">
        <col width="4%">
        <col width="4%">
        <col width="4%">
        <col width="6%">
        <col width="6%">
        <col width="10%">
      </colgroup>

      <tr class="t_top">
        <th class="none_mobile"></th>
        <th align="center">차종</th>
        <th align="center">출발지</th>
        <th align="center">목적지</th>
        <th align="center">출발시km</th>
        <th align="center">도착시km</th>
        <th align="center">주행거리</th>
        <th align="center">운행자</th>
        <th align="center">등록자</th>
        <th align="center">운행일</th>
        <th align="center">출발시</th>
        <th align="center">도착시</th>
        <th align="center">주유비</th>
        <th align="center">운행목적</th>
        <th align="center">기타</th>
        <th></th>
      </tr>

      <tr>
        <td class="none_mobile"></td>
        <td align="center" style="padding:0 5px;">
          <select class="select7" id="add_carname" name="add_carname" style="width:160px; height:23px;" onchange="find_car_a_km();">
            <?php foreach($car_list as $cl){ ?>
              <option value="<?php echo $cl->type."-".$cl->number; ?>"><?php echo $cl->type." / ".$cl->number; ?></option>
            <?php } ?>
          </select>
        </td>
        <td align="center" style="padding:0 5px;">
          <input type="text" class="input5" id="add_d_point" name="add_d_point" style="width:100%; height:18px;">
        </td>
        <td align="center" style="padding:0 5px;">
          <input type="text" class="input5" id="add_a_point" name="add_a_point" style="width:100%; height:18px;">
        </td>
        <td align="center" style="padding:0 5px;">
          <input type="text" class="input5" id="add_d_km" name="add_d_km" style="width:100%; height:18px;" readonly>
        </td>
        <td align="center" style="padding:0 5px;">
          <input type="text" class="input5" id="add_a_km" name="add_a_km" style="width:100%; height:18px;" onkeyup="input_a_km();">
        </td>
        <td align="center" style="padding:0 5px;">
          <input type="text" class="input5" id="add_total_km" name="add_total_km" style="width:100%; height:18px;" value="" readonly>
        </td>
        <td align="center" style="padding:0 5px;">
          <input type="text" class="input5" id="add_driver" name="add_driver" style="width:100%; height:18px;">
        </td>
        <td align="center" style="padding:0 5px;">
          <input type="text" class="input5" style="width:100%; height:18px;" value="<?php echo $this->name; ?>" readonly>
        </td>
        <td align="center" style="padding:0 5px;">
          <input type="text" class="input5" id="add_drive_date" name="add_drive_date" style="width:100%; height:18px;">
        </td>
        <td align="center" style="padding:0 5px;">
          <input type="text" class="input5" id="add_d_time" name="add_d_time" style="width:100%; height:18px;">
        </td>
        <td align="center" style="padding:0 5px;">
          <input type="text" class="input5" id="add_a_time" name="add_a_time" style="width:100%; height:18px;">
        </td>
        <td align="center" style="padding:0 5px;">
          <input type="text" class="input5" id="add_oil" name="add_oil" style="width:100%; height:18px;">
        </td>
        <td align="center" style="padding:0 5px;">
          <input type="text" class="input5" id="add_drive_purpose" name="add_drive_purpose" style="width:100%; height:18px;">
        </td>
        <td align="center" style="padding:0 5px;">
          <input type="text" class="input5" id="add_etc" name="add_etc" style="width:100%; height:18px;">
        </td>
        <td style="padding:0 5px;">
          <input type="button" style="text-align:center; cursor:pointer; align:center; font-weight:bold; color:#fff; border-radius:8px; border:none; background-color:#41beeb; width:45px; height:22px;" onMouseOver="this.style.backgroundColor='#DBDBDb',this.style.color='#333333'" onMouseOut="this.style.backgroundColor='#41beeb', this.style.color='#fff'" onclick="save_action()" value="저장">
        </td>
      </tr>
    </table>
  </td>
</tr>

<!-- 콘텐트시작 -->
<tr height="45%">
<td valign="top" style="padding:15px 0px 15px 0px">
    <table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
          <td align="center" valign="top">
            <tr>
              <td>
              <table class="drive_list" width="100%" border="0" cellspacing="0" cellpadding="0" id="car_list_table">
                <colgroup>
                <?php if($mobile=="false"){ ?>
                  <col width="8%">
                  <col width="3%">
                  <col width="8%">
                  <col width="8%">
                  <col width="8%">
                  <col width="6%">
                  <col width="6%">
                  <col width="5%">
                  <col width="3%">
                  <col width="3%">
                  <col width="7%">
                  <col width="3%">
                  <col width="3%">
                  <col width="4%">
                  <col width="6%">
                  <col width="6%">
                  <col width="2%">
                  <col width="8%">
                <?php } else { ?>
                  <col width="30%">
                  <col width="30%">
                  <col width="17%">
                  <col width="23%">
                <?php } ?>
                </colgroup>

                <tr class="t_top none_mobile">
                  <th></th>
                  <th height="40" align="center">No.</th>
                  <th align="center">차종</th>
                  <th align="center">출발지</th>
                  <th align="center">목적지</th>
                  <th align="center">출발시km</th>
                  <th align="center">도착시km</th>
                  <th align="center">주행거리</th>
                  <th align="center">운행자</th>
                  <th align="center">등록자</th>
                  <th align="center">운행일</th>
                  <th align="center">출발시</th>
                  <th align="center">도착시</th>
                  <th align="center">주유비</th>
                  <th align="center">운행목적</th>
                  <th align="center">기타</th>
                  <th></th>
                  <th></th>
                </tr>

    <?php
      if ($count > 0) {
        $i = $count - $no_page_list * ( $cur_page - 1 );
        $icounter = 0;
        foreach ( $list_val as $item ) {
          if($mobile=='true'){
    ?>
                <tr id="tr_<?php echo $item['seq'];?>" seq="<?php echo $item['seq'];?>">
                  <td class="none_mobile"></td>
                  <td height="40" align="center" class="none_mobile"><?php echo $i;?></td>
                  <td align="center">
                    <?php if ($mobile == "false"){ ?>
                    <select class="input_border" id="carname" name="carname" onChange="changekm();modifyInput(this);" style="width:140px; height:23px;">
                      <?php foreach($car_list as $cl){ ?>
                        <option value="<?php echo $cl->type."-".$cl->number; ?>" <?php if($item['carname'] == $cl->type && $item['carnum'] == $cl->number ){
                          echo 'selected';} ?> ><?php echo $cl->type." / ".$cl->number; ?></option>
                      <?php } ?>
                    </select>
                  <?php } else echo $item['carname'].'<br>'.$item['carnum']; ?>
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" id="d_point" name="d_point" value="<?php echo $item['d_point'];?>" style="width:135px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);" onchange="modifyInput(this);" title="<?php echo $item['d_point'];?>">
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" id="a_point" name="a_point" value="<?php echo $item['a_point'];?>" style="width:135px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);" onchange="modifyInput(this);" title="<?php echo $item['a_point'];?>">
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" id="d_km" name="d_km" value="<?php echo $item['d_km'];?>" style="width:70px; height:18px; text-align:center; outline:none;" title="<?php echo $item['d_km'];?>" readonly >km
                  </td>
                  <td align="center">
                    <?php if($mobile=="false"){ ?>
                    <input type="text" class="input_border" id="a_km" name="a_km" value="<?php echo $item['a_km'];?>" style="width:70px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);" onchange="modifyInput(this);change_km(this,value);" title="<?php echo $item['a_km'];?>">km
                  <?php } else {
                    echo $item['a_km'].'km';
                  }?>
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" id="total_km" name="total_km" value="<?php echo $item['a_km']-$item['d_km'];?>" style="width:70px; height:18px; text-align:center; outline:none;" title="<?php echo $item['a_km']-$item['d_km'];?>" readonly >km
                  </td>
                  <td align="center" align="center">
                    <?php if($mobile=="false"){ ?>
                    <input type="text" class="input_border" id="driver" name="driver" value="<?php echo $item['driver'];?>" style="width:50px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);" onchange="modifyInput(this);" title="<?php echo $item['driver'];?>">
                  <?php } else {
                    echo $item['driver'];
                  } ?>
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" id="writer" name="writer" value="<?php echo $item['writer'];?>" style="width:50px; height:18px; text-align:center; outline:none;" readonly>
                  </td>
                  <td align="center">
                    <?php if($mobile=="false"){ ?>
                    <input type="text" class="input_border" id="drive_date" name="drive_date" value="<?php echo $item['drive_date'];?>" style="width:90px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);" onchange="modifyInput(this);" title="<?php echo $item['drive_date'];?>">
                  <?php } else {
                    echo $item['drive_date'];
                  } ?>
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" name="d_time" id="d_time" value="<?php echo $item['d_time'];?>" style="width:40px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);" title="<?php echo $item['d_time'];?>">
                    <!-- <input type="text" class="input_border" name="d_time" id="d_time" value="<?php echo $item['d_time'];?>" style="width:40px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);" onchange="modifyInput(this);" title="<?php echo $item['d_time'];?>"> -->
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" name="a_time" id="a_time" value="<?php echo $item['a_time'];?>" style="width:40px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);"title="<?php echo $item['a_time'];?>">
                    <!-- <input type="text" class="input_border" name="a_time" id="a_time" value="<?php echo $item['a_time'];?>" style="width:40px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);" onchange="modifyInput(this);" title="<?php echo $item['a_time'];?>"> -->
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" name="oil" id="oil" value="<?php echo $item['oil'];?>" style="width:60px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this)" onchange="modifyInput(this)" title="<?php echo $item['oil'];?>">
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" name="drive_purpose" id="drive_purpose" value="<?php echo $item['drive_purpose'];?>" style="width:100px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this)" onchange="modifyInput(this)" title="<?php echo $item['drive_purpose'];?>">
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" name="etc" id="etc" value="<?php echo $item['etc'];?>" style="width:100px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this)" onchange="modifyInput(this)" title="<?php echo $item['etc'];?>">
                  </td>
                  <td class="none_mobile">
                    <input type="button" name="" value="X" style="text-align:center; cursor:pointer; align:center; font-weight:bold; color:#fff; border-radius:8px; border:none; background-color:#41beeb;" onMouseOver="this.style.backgroundColor='#DBDBDb',this.style.color='#333333'" onMouseOut="this.style.backgroundColor='#41beeb', this.style.color='#fff'" onclick="delete_input(<?php echo $item['seq']; ?>);">
                  </td>
                  <td class="none_mobile"></td>
                </tr>
              <?php }else { ?>
                <tr height="50">
                  <td style="margin-left:10px">
                    <div style="margin-left:10px">
                    <?php echo $item['carname'].$item['carnum'].'<br>'.$item['a_km'].'km'; ?>
                    </div>
                  </td>
                  <td align="right" style="margin-right:10px">
                    <div style="margin-right:10px;">
                    <?php echo $item['driver'].'<br>'.$item['drive_date']; ?>
                    </div>
                  </td>
                </tr>
              <?php } ?>
    <?php
          $i--;
          $icounter++;
        }
      } else {
    ?>
    <tr>
      <td width="100%" height="40" align="center" colspan="15">등록된 게시물이 없습니다.</td>
    </tr>

    <?php
      }
    ?>
              </table></td>
            </tr>
<script language="javascript">
function GoFirstPage (){
  document.mform.cur_page.value = 1;
  document.mform.submit();
}

function GoPrevPage (){
  var cur_start_page = <?php echo $cur_page;?>;

  document.mform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
  document.mform.submit( );
}

function GoPage(nPage){
  document.mform.cur_page.value = nPage;
  document.mform.submit();
}

function GoNextPage (){
  var cur_start_page = <?php echo $cur_page;?>;

  document.mform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
  document.mform.submit();
}

function GoLastPage (){
  var total_page = <?php echo $total_page;?>;
  //  alert(total_page);

  document.mform.cur_page.value = total_page;
  document.mform.submit();
}

function ViewBoard (seq){
  document.mform.action = "<?php echo site_url();?>/biz/durian_car/car_drive_view";
  document.mform.seq.value = seq;
  document.mform.mode.value = "view";

  document.mform.submit();
}
</script>
          </td>

      </tr>
   </table>
</td>
</tr>
<!-- 컨텐트 테이블 끝 -->
<!-- 페이징 버튼 시작 -->
<tr height="40%">
  <td align="left" valign="top">
    <table width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td width="19%">

        <tr height="20%">
          <td align="center" valign="top">
<?php if ($count > 0 && $this->agent->is_mobile()==false) {?>
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
  // $strSection = "&nbsp;<span class=\"section\">|</span>&nbsp;";
}

if  ( $i == $cur_page ) {
  echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\"><font color=\"#33ccff\">".$i."</font></a>".$strSection;
} else {
  echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\">".$i."</a>".$strSection;
}
}
?></td>
      <?php
if   ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
?>
<!-- <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/page_next.png" width="20" height="20"/></a></td> -->
      <td width="2"></td>
      <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.png" width="20" height="20"/></a></td>
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
</td>
</tr>
</td>
</tr>

<tr>
  <td width="19%">
    <tr>
      <td height="10"></td>
    </tr>
<tr>
  <td height="10"></td>
</tr>
</td>
</tr>
</table>
</td>
</tr>

      </tbody>
    </form>
</table>
  </div>
</div>

<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<script>
function changekm(){
  var car_name = $('#carname').val();
  var car_num = car_name.split('-')[1];
  console.log(car_num);
  $.ajax({
    url : "<?php echo site_url(); ?>/biz/durian_car/check_km",
    type : "POST",
    dataType : "json",
    data : {
      car_num: car_num
    },
    success : function(data) {
      console.log(data.max_km);
      $('#d_km').val(data.max_km);
    }

});
}

function cardrive_input(){
  // var act = "<?php echo site_url();?>/biz/weekly_report/weekly_report_input_action";
  // $("#cform").attr('action', act);
  var arrive = $("#a_km").val();
  if(arrive == ''){
    alert("도착시km를 입력해주세요");
    return false;
  }

  $("#cform").submit();
}

// function modify_open(e){
//   $(e).closest('tr').find('.input_div').show();
//   $(e).closest('tr').find('.text_div').hide();
//   $(e).val('저장');
//   $(e).attr('onClick','save_action(this)');
// }
// function modify_close(e){
//   $(e).closest('tr').find('.input_div').hide();
//   $(e).closest('tr').find('.text_div').show();
//   $(e).val('수정');
//   $(e).attr('onClick','modify_open(this)');
// }

function save_action(){
  // modify_close(e);
  // var seq = $(e).attr('seq');
  // console.log(wrong_total_km_arr);
  if($('#add_total_km').val() <= 0 && $('#add_total_km').val() != ''){
    alert('주행거리가 올바르지 않은 입력값이 있습니다. 다시 확인해주세요.')
    $('#add_a_km').focus();
    return false;
  }
  if(wrong_total_km_arr.length > 0){
    alert('주행거리가 올바르지 않은 입력값이 있습니다. 다시 확인해주세요.')
    return false;
  }else{
  //내용 수정
    var val_arr = [];
    for(var i=0; i<modify_list_arr.length; i++){
      var tr = $('#tr_'+modify_list_arr[i]);
      var seq = modify_list_arr[i];
      var carname = tr.find('#carname').val();
      var d_point = tr.find('#d_point').val();
      var a_point = tr.find('#a_point').val();
      var d_time = tr.find('#d_time').val();
      var a_time = tr.find('#a_time').val();
      var d_km = tr.find('#d_km').val();
      var a_km = tr.find('#a_km').val();
      // var d_km = tr.find('#d_km').val().replace(' km','');
      // var a_km = tr.find('#a_km').val().replace(' km','');
      var driver = tr.find('#driver').val();
      var drive_date = tr.find('#drive_date').val();
      var drive_purpose = tr.find('#drive_purpose').val();
      var oil = tr.find('#oil').val();
      var etc = tr.find('#etc').val();
      val_arr.push({'seq':seq, 'carname':carname, 'd_point':d_point, 'a_point':a_point, 'd_time':d_time, 'a_time':a_time, 'd_km':d_km, 'a_km':a_km, 'driver':driver, 'drive_date':drive_date, 'drive_purpose':drive_purpose, 'oil':oil, 'etc':etc});
      // val_arr.push({'seq':seq, 'carname':carname, 'd_point':d_point, 'a_point':a_point, 'd_time':d_time, 'a_time':a_time, 'd_km':d_km, 'a_km':a_km, 'driver':driver, 'drive_date':drive_date, 'drive_purpose':drive_purpose, 'oil':oil, 'etc':etc});
    }

    //내용 입력
      var add_carname = $('#add_carname').val();
      var add_d_point = $('#add_d_point').val();
      var add_a_point = $('#add_a_point').val();
      var add_d_time = $('#add_d_time').val();
      var add_a_time = $('#add_a_time').val();
      var add_d_km = $('#add_d_km').val();
      var add_a_km = $('#add_a_km').val();
      var add_driver = $('#add_driver').val();
      var add_drive_date = $('#add_drive_date').val();
      var add_drive_purpose = $('#add_drive_purpose').val();
      var add_oil = $('#add_oil').val();
      var add_etc = $('#add_etc').val();
      if((add_carname != '') && (add_d_point != '') && (add_a_point != '') && (add_d_time != '') && (add_a_time != '') && (add_d_km != '') && (add_a_km != '') && (add_driver != '') && (add_drive_date != '')){
        val_arr.push({'carname':add_carname, 'd_point':add_d_point, 'a_point':add_a_point, 'd_time':add_d_time, 'a_time':add_a_time, 'd_km':add_d_km, 'a_km':add_a_km, 'driver':add_driver, 'drive_date':add_drive_date, 'drive_purpose':add_drive_purpose, 'oil':add_oil, 'etc':add_etc});
      }
    // console.log(val_arr);
    if(val_arr.length <= 0){
      alert('저장 혹은 수정할 내용이 없습니다.');
      return false;
    }else{

      $.ajax({
        url : "<?php echo site_url(); ?>/biz/durian_car/car_drive_input_action",
        type : "POST",
        dataType : "json",
        data : {
          val_arr: val_arr
        },
        success : function(data) {
          // console.log('?'+data.max_km);
          // $('#d_km').val(data.max_km);
          // modify_close(e);
          alert('정상적으로 처리되었습니다.');
          // var link = document.location.href;
          // console.log(String(link));
          // console.log('<?php echo site_url(); ?>/biz/durian_car/car_drive_list');
          // if(String(link) = '<?php echo site_url(); ?>/biz/durian_car/car_drive_list'){
          //   alert(1);
            location.href='<?php echo site_url(); ?>/biz/durian_car/car_drive_list';
          // }else{
          //   alert(2);
          //   history.go(-1);
          // }

        }
      });
    }
  }
}

function in_text_align(e){
  $(e).css('text-align','left');
}
function out_text_align(e){
  $(e).css('text-align','center');
}

var modify_list_arr = [];
function modifyInput(obj) {
  $(obj).css('background-color','#F08080');
  var seq = $(obj).closest('tr').attr('seq');
  modify_list_arr.push(seq);
  modify_list_arr = unique(modify_list_arr);
  // console.log(modify_list_arr);
}
//배열 중복제거 함수
function unique(array) {
  var result = [];
  $.each(array, function(index, element) {
    if ($.inArray(element, result) == -1) {
      result.push(element);
    }
  });
  return result;
}

//새로 입력하는 창 - 도착km 입력시 자동으로 주행거리 계산
function input_a_km(){
  var d_km = $('#add_d_km').val();
  var a_km = $('#add_a_km').val();
  $('#add_total_km').val(a_km - d_km);
}

//해당 차종의 마지막 도착km 기록가져오기
function find_car_a_km(){
  var add_carname = $('#add_carname').val();
  var split_carname = add_carname.split('-');
  var carname = split_carname[0];
  var carnum = split_carname[1];
  $.ajax({
    type: 'POST',
    dataType : "json",
    url: "<?php echo site_url(); ?>/biz/durian_car/find_last_a_km",
    data:{
      carname: carname,
      carnum: carnum
    },
    // cache:false,
    // async:false,
    success: function(data) {
      if(data != 'false' && data != null){
        $('#add_d_km').val(data);
        $('#add_d_km').attr('readonly',true);
      }else{
        $('#add_d_km').val('');
        $('#add_d_km').attr('readonly',false);
      }
    }
  });
}

function delete_input(seq){
  var result = confirm("정말 삭제 하시겠습니까?");
  if(result){
    $.ajax({
      type: 'POST',
      dataType : "json",
      url: "<?php echo site_url(); ?>/biz/durian_car/car_drive_delete_action",
      data:{
        seq: seq
      },
      // cache:false,
      // async:false,
      success: function(data) {
        alert('정상적으로 삭제되었습니다.');
        location.href='<?php echo site_url(); ?>/biz/durian_car/car_drive_list';
      }
    });
  }else{
    return false;
  }
}

var wrong_total_km_arr = [];
function change_km(e,val){
  var this_seq = $(e).closest('tr').attr('seq');
  var this_car = $(e).closest('tr').find('#carname').val();
  var this_d_km = $(e).closest('tr').find('#d_km').val();
  var this_a_km = val;
  var this_total_km = this_a_km - this_d_km;
  // var prev_d_km = $(e).closest('tr').prevUntil('#carname',this_car);

  var count = ($(e).closest('tr').prevAll().length)-1; //자신을 뺀 나머지 tr의 길이를 구해야 하기에 -1을 해준다
  if(count > 0){
    for(var i=0; i<count; i++){
      var prev_seq = $(e).closest('tr').prevAll('tr').eq(i).attr('seq');
      var prev_car = $(e).closest('tr').prevAll('tr').eq(i).find('#carname').val();

      if(prev_car == this_car){
        var prev_d_km = val;
        var prev_a_km = $(e).closest('tr').prevAll('tr').eq(i).find('#a_km').val();
        var prev_total_km = prev_a_km - prev_d_km;

        // alert(prev_d_km+'-'+prev_a_km+'-'+prev_total_km);
        if(prev_total_km > 0 && this_total_km > 0){
          $(e).closest('tr').find('#total_km').val(this_total_km);

          $(e).closest('tr').prevAll('tr').eq(i).find('#d_km').val(val);
          $(e).closest('tr').prevAll('tr').eq(i).find('#total_km').val(prev_total_km);
          $(e).closest('tr').prevAll('tr').eq(i).find('#total_km').css('background','#fff');
          $(e).closest('tr').find('#total_km').css('background','#fff');

          modify_list_arr.push(prev_seq);
          modify_list_arr = unique(modify_list_arr);

          // 필터함수로 wrong_total_km_arr에서 삭제할 seq를 제거
          wrong_total_km_arr = wrong_total_km_arr.filter(function(element){return element !== this_seq});
          wrong_total_km_arr = wrong_total_km_arr.filter(function(element){return element !== prev_seq});
        }else{
          alert('주행거리가 0km 이하인 기록이 발생합니다. 다시 확인해주세요.');

          $(e).closest('tr').find('#total_km').val(this_total_km);

          $(e).closest('tr').prevAll('tr').eq(i).find('#d_km').val(val);
          $(e).closest('tr').prevAll('tr').eq(i).find('#total_km').val(prev_total_km);
          if(prev_total_km <= 0){
            $(e).closest('tr').prevAll('tr').eq(i).find('#total_km').css('background','#7abcfa');
            wrong_total_km_arr.push(prev_seq);
          }else if(this_total_km <= 0){
            $(e).closest('tr').find('#total_km').css('background','#7abcfa');
            wrong_total_km_arr.push(this_seq);
          }
        }
        break;
      }

    }
  }else{
    $(e).closest('tr').find('#total_km').val(this_total_km);

  }

}

// function modify(val){
//   var tr = val.parentNode.parentNode;
//   var td_length = tr.childNodes.length;
//   for(i=0;i<td_length;i++){
//     var td = tr.childNodes[i].querySelectorAll().innerText ;
//     console.log(td);
//   }
// }
</script>
</body>
</html>
