<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
  // tech_doc_list 김수성
?>
<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
<?php if ($this->agent->is_mobile()==false){ ?>
  <!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
  <link rel="stylesheet" href="/misc/css/view_page_common.css">
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
      font-size: 14px;
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
    .car_input_btn {
      width:95%;
      height:2000px;
      font-weight:bold;
      background-color:#41beeb;
      color:#fff;
      border-radius:10px;
      border:none;
    }
    .container{
      width:100%;
    }
    .modal-btn-box{
      width:100%;
      text-align:center;
    }
    .modal-btn-box button{
      display:inline-block;
      width:150px;
      height:50px;
      background-color:#ffffff;
      border:1px solid #e1e1e1;
      cursor:pointer;
      padding-top:8px;
    }
    .popup-wrap{
      background-color:rgba(0,0,0,.3);
      justify-content:center;
      align-items:center;
      position:fixed;
      top:0;
      left:0;
      right:0;
      bottom:0;
      display:none;
      padding:15px;
    }
    .popup{
      width:100%;
      max-width:400px;
      background-color:#ffffff;
      border-radius:10px;
      overflow:hidden;
      background-color:#41beeb;
      box-shadow: 5px 10px 10px 1px rgba(0,0,0,.3);
    }
    .popup-head{
      width:100%;
      height:50px;
      display:flex;
      align-items:center;
      justify-content:center;
    }
    .head-title {
        font-size: 30px;
        /* font-style: italic; */
        font-weight: 700;
        text-align: center;
    }
    .popup-body{
      width:100%;
      background-color:#ffffff;
    }
    .body-content{
      width:100%;
      padding-top:15px;
      padding-bottom:15px;
    }
    .body-titlebox{
      text-align:center;
      width:100%;
      height:40px;
      margin-bottom:10px;
    }
    .body-contentbox{
      word-break:break-word;
      overflow-y:auto;
      min-height:100px;
      max-height:200px;
    }
    .popup-foot{
      width:100%;
      height:50px;
    }
    .pop-btn{
      display:inline-flex;
      width:100%;
      height:100%;
      float:left;
      justify-content:center;
      align-items:center;
      font-size: 20px;
      /* font-style: italic; */
      font-weight: 700;
      text-align: center;
    }
    .input_btn{
      display:inline-flex;
      width:50%;
      height:100%;
      float:left;
      justify-content:center;
      align-items:center;
      font-size: 20px;
      /* font-style: italic; */
      font-weight: 700;
      text-align: center;
    }
    .input-close {
      background-color: #FF6666;
    }
    .pop-btn.confirm{
      border-right:1px solid #3b5fbf;
    }
    .popup_tbl {
      margin: 0 auto;
    }
    .popup_tbl th {
      font-weight: bold;
      margin-top:10px;
      text-align:left;
      font-size: 16px;
    }
    .mobile_input {
      border: 1px solid #b4b4b4;
      width: 90%;
      margin-top: 1px;
      height: 20px;
      font-size: 16px
    }
    .mobile_input2 {
      border: 1px solid #b4b4b4;
      width: 95%;
      margin-top: 1px;
      height: 20px;
      font-size: 16px
    }
    /* .popup_tbl td {
      padding: 5px;
    } */
  }

  .input-common {
    width: 100px;
  }
  .select-common {
    width: 105px;
  }
@media screen and (min-width:1700px) {
  .input-common {
    width: 155px;
  }
  .select-common {
    width: 160px;
  }
}

#input_tbl td {
  padding-right: 10px;
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

  $('.datepicker').datepicker({
    clearBtn : false
  });

  var date = new Date();
  date = getFormatDate(date);
  $('#add_drive_date').val(date);

  $('.timepicker').timepicker({
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
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<form name="mform" action="<?php echo site_url();?>/biz/durian_car/car_drive_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">
<tbody height="100%">
<tr height="5%">
  <td class="dash_title none_mobile">
    <!-- <img class="none_mobile" src="<?php echo $misc;?>img/dashboard/title_car_drive_list.png"/> -->
    차량운행일지
  </td>
</tr>
<?php if($mobile=="true"){ ?>
  <tr>
    <td valign="top" align="center" style="padding:15px 0px 0px 0px">
      <img src="<?php echo $misc;?>img/mobile/mobile_input_btn.svg" width="100%" onclick="input_popup();"/>
      <!-- <input type="button" id="car_input_btn" name="car_input_btn" value="글쓰기" style="width:95%; height:40%; font-weight:bold; background-color:#41beeb; color:#fff; border-radius:10px; border:none;" onclick="input_popup();"> -->
  </tr>
<?php } ?>
<!-- 검색창 -->
<tr height="10%">
  <td align="left" valign="bottom">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" id="search_table" style="margin-top:70px;">
      <tr>
        <td>
          <select name="search1" id="search1" class="select-common select-style1" width="100">
            <option value="001" <?php if($search1 == "001"){ echo "selected";}?>>차번</option>
            <option value="002" <?php if($search1 == "002"){ echo "selected";}?>>출발지</option>
            <option value="003" <?php if($search1 == "003"){ echo "selected";}?>>목적지</option>
            <option value="004" <?php if($search1 == "004"){ echo "selected";}?>>운행자</option>
            <option value="005" <?php if($search1 == "005"){ echo "selected";}?>>운행일</option>
          </select>
        <span>
          <input type="text" size="25" class="input-common" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
        </span>
        <span>
          <!-- <input type="image" style='cursor:hand; margin-bottom:8px;' onClick="return GoSearch();" src="<?php echo $misc;?>img/dashboard/btn/btn_search.png" width="20px" height="20px" align="middle" border="0" /> -->
          <input type="button" class="btn-common btn-style1" value="검색" onClick="return GoSearch();">
        </span>
        </td>
      </tr>
    </table>
  </td>
</tr>
</form>
<!-- 입력창 -->
<?php if($mobile == 'false'){ ?>
<tr height="10%">
  <td align="left" valign="bottom">
    <table id="input_tbl" border="0" cellspacing="0" cellpadding="0" class="none_mobile" style="font-weight:bold;margin-top:30px;">
      <tr>
        <td>차종</td>
        <td>
          <select class="select-common select-style1" id="add_carname" name="add_carname" onchange="find_add_car_a_km();" style="">
            <?php foreach($car_list as $cl){ ?>
              <option value="<?php echo $cl->type."-".$cl->number; ?>"><?php echo $cl->type." / ".$cl->number; ?></option>
            <?php } ?>
          </select>
        </td>
        <td>출발지</td>
        <td>
          <input type="text" class="input-common" style="margin-right:20px" id="add_d_point" name="add_d_point">
        </td>
        <td>출발시km</td>
        <td>
          <input type="text" class="input-common" style="margin-right:20px" id="add_d_km" name="add_d_km">
        </td>
        <td>주행거리</td>
        <td>
          <input type="text" class="input-common" style="margin-right:20px" id="add_total_km" name="add_total_km" value="" readonly>
        </td>
        <td>운행일</td>
        <td>
          <input type="text" class="input-common datepicker" style="margin-right:20px" id="add_drive_date" name="add_drive_date">
        </td>
        <td>출발시</td>
        <td>
          <input type="text" class="input-common timepicker" style="margin-right:20px" id="add_d_time" name="add_d_time">
        </td>
        <td>주유비</td>
        <td>
          <input type="text" class="input-common" style="" id="add_oil" name="add_oil">
        </td>
      </tr>
      <tr>
        <td>등록자</td>
        <td>
          <input type="text" class="input-common" style="margin-right:20px" value="<?php echo $this->name; ?>" readonly>
        </td>
        <td>목적지</td>
        <td>
          <input type="text" class="input-common" style="margin-right:20px" id="add_a_point" name="add_a_point">
        </td>
        <td>도착시km</td>
        <td>
          <input type="text" class="input-common" style="margin-right:20px" id="add_a_km" name="add_a_km" onkeyup="input_a_km();">
        </td>
        <td>운행자</td>
        <td>
          <input type="text" class="input-common" style="margin-right:20px" id="add_driver" name="add_driver">
        </td>
        <td>운행목적</td>
        <td>
          <input type="text" class="input-common" style="margin-right:20px" id="add_drive_purpose" name="add_drive_purpose">
        </td>
        <td>도착시</td>
        <td>
          <input type="text" class="input-common timepicker" style="margin-right:20px" id="add_a_time" name="add_a_time">
        </td>
        <td>기타</td>
        <td>
          <input type="text" class="input-common" style="" id="add_etc" name="add_etc">
        </td>
        <td>
          <input type="button" class="btn-common btn-color2" value="저장" onclick="save_action()" style="width:60px;">
        </td>
      </tr>
    </table>
  </td>
</tr>
<?php } ?>

<!-- 콘텐트시작 -->
<tr height="45%">
<td valign="top" style="padding:15px 0px 15px 0px">
    <table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
          <td align="center" valign="top">
            <tr>
              <td>
              <table class="drive_list" width="100%" border="0" cellspacing="0" cellpadding="0" id="car_list_table" style="<?php if($mobile=="false"){ echo 'margin-top:20px;'; }?>">
                <colgroup>
                <?php if($mobile=="false"){ ?>
                  <col width="4%">
                  <col width="9%">
                  <col width="9%">
                  <col width="9%">
                  <col width="7%">
                  <col width="7%">
                  <col width="6%">
                  <col width="4%">
                  <col width="4%">
                  <col width="8%">
                  <col width="4%">
                  <col width="4%">
                  <col width="5%">
                  <col width="6%">
                  <col width="6%">
                  <col width="3%">
                <?php } else { ?>
                  <col width="30%">
                  <col width="30%">
                  <col width="17%">
                  <col width="23%">
                <?php } ?>
                </colgroup>

                <tr class="t_top none_mobile row-color1">
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
                </tr>

    <?php
      if ($count > 0) {
        $i = $count - $no_page_list * ( $cur_page - 1 );
        $icounter = 0;
        foreach ( $list_val as $item ) {
    ?>
                <tr id="tr_<?php echo $item['seq'];?>" seq="<?php echo $item['seq'];?>" name="tr_list" <?php if($mobile=='true'){echo 'onclick="detail(this);"';} ?>>
                  <td height="40" align="center" class="none_mobile"><?php echo $i;?></td>
                  <td align="center">
                    <!-- <select class="input_border" id="carname" name="carname" style="width:140px; height:23px;"> -->
                    <?php if ($mobile == "false"){ ?>
                    <select class="input_border" id="carname" name="carname" onChange="modifyInput(this);find_car_a_km(this);" style="width:140px; height:23px;">
                    <!-- <select class="input_border" id="carname" name="carname" onChange="changekm();modifyInput(this);find_car_a_km();" style="width:140px; height:23px;"> -->
                      <?php foreach($car_list as $cl){ ?>
                        <option value="<?php echo $cl->type."-".$cl->number; ?>" <?php if($item['carname'] == $cl->type && $item['carnum'] == $cl->number ){
                          echo 'selected';} ?> ><?php echo $cl->type." / ".$cl->number; ?></option>
                        <?php } ?>
                      </select>
                    <?php } else echo $item['carname'].'<br>'.$item['carnum']; ?>
                    <input type="hidden" id="hidden_carname" name="hidden" value="<?php echo $item['carname']."-".$item['carnum']; ?>">
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" id="d_point" name="d_point" value="<?php echo $item['d_point'];?>" style="width:135px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);" onchange="modifyInput(this);" title="<?php echo $item['d_point'];?>">
                    <input type="hidden" id="hidden_d_point" name="hidden" value="<?php echo $item['d_point'];?>">
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" id="a_point" name="a_point" value="<?php echo $item['a_point'];?>" style="width:135px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);" onchange="modifyInput(this);" title="<?php echo $item['a_point'];?>">
                    <input type="hidden" id="hidden_a_point" name="hidden" value="<?php echo $item['a_point'];?>">
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" id="d_km" name="d_km" value="<?php echo $item['d_km'];?>" style="width:70px; height:18px; text-align:right; outline:none;" title="<?php echo $item['d_km'];?>" readonly >km
                    <input type="hidden" id="hidden_d_km" name="hidden" value="<?php echo $item['d_km'];?>">
                  </td>
                  <td align="center">
                    <?php if($mobile=="false"){ ?>
                    <input type="text" class="input_border" id="a_km" name="a_km" value="<?php echo $item['a_km'];?>" style="width:70px; height:18px; text-align:right;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);" onchange="modifyInput(this);change_km(this);" title="<?php echo $item['a_km'];?>">km
                  <?php } else {
                    echo $item['a_km'].'km';
                  }?>
                    <input type="hidden" id="hidden_a_km" name="hidden" value="<?php echo $item['a_km'];?>">
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" id="total_km" name="total_km" value="<?php echo $item['a_km']-$item['d_km'];?>" style="width:70px; height:18px; text-align:right; outline:none;" title="<?php echo $item['a_km']-$item['d_km'];?>" readonly >km
                    <input type="hidden" id="hidden_total_km" name="hidden" value="<?php echo $item['a_km']-$item['a_km'];?>">
                  </td>
                  <td align="center" align="center">
                    <?php if($mobile=="false"){ ?>
                    <input type="text" class="input_border" id="driver" name="driver" value="<?php echo $item['driver'];?>" style="width:50px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);" onchange="modifyInput(this);" title="<?php echo $item['driver'];?>">
                  <?php } else {
                    echo $item['driver'];
                  } ?>
                    <input type="hidden" id="hidden_driver" name="hidden" value="<?php echo $item['driver'];?>">
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" id="writer" name="writer" value="<?php echo $item['writer'];?>" style="width:50px; height:18px; text-align:center; outline:none;" readonly>
                  </td>
                  <td align="center">
                    <?php if($mobile=="false"){ ?>
                    <input type="text" class="input_border datepicker" id="drive_date" name="drive_date" value="<?php echo $item['drive_date'];?>" style="width:90px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);" onchange="modifyInput(this);" title="<?php echo $item['drive_date'];?>">
                  <?php } else {
                    echo $item['drive_date'];
                  } ?>
                    <input type="hidden" id="hidden_drive_date" name="hidden" value="<?php echo $item['drive_date'];?>">
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border timepicker" name="d_time" id="d_time" value="<?php echo $item['d_time'];?>" style="width:40px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);" title="<?php echo $item['d_time'];?>">
                    <!-- <input type="text" class="input_border" name="d_time" id="d_time" value="<?php echo $item['d_time'];?>" style="width:40px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);" onchange="modifyInput(this);" title="<?php echo $item['d_time'];?>"> -->
                    <input type="hidden" id="hidden_d_time" name="hidden" value="<?php echo $item['d_time'];?>">
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border timepicker" name="a_time" id="a_time" value="<?php echo $item['a_time'];?>" style="width:40px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);"title="<?php echo $item['a_time'];?>">
                    <!-- <input type="text" class="input_border" name="a_time" id="a_time" value="<?php echo $item['a_time'];?>" style="width:40px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);" onchange="modifyInput(this);" title="<?php echo $item['a_time'];?>"> -->
                    <input type="hidden" id="hidden_a_time" name="hidden" value="<?php echo $item['a_time'];?>">
                  </td>
                  <td align="center" align="center" class="none_mobile">
                    <input type="text" class="input_border" name="oil" id="oil" value="<?php if($item['oil'] != ''){echo number_format($item['oil']);}?>" style="width:60px; height:18px; text-align:center;"  onchange="modifyInput(this);" onFocus="deCommaStr(this);" onfocusin="in_text_align(this);" onfocusout="out_text_align(this);commaStr(this);" onkeyup="onlyNumber(this)" title="<?php if($item['oil'] != ''){echo number_format($item['oil']);}?>">
                    <input type="hidden" id="hidden_oil" name="hidden" value="<?php echo $item['oil'];?>">
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" name="drive_purpose" id="drive_purpose" value="<?php echo $item['drive_purpose'];?>" style="width:100px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this)" onchange="modifyInput(this);" title="<?php echo $item['drive_purpose'];?>">
                    <input type="hidden" id="hidden_drive_purpose" name="hidden" value="<?php echo $item['drive_purpose'];?>">
                  </td>
                  <td align="center" class="none_mobile">
                    <input type="text" class="input_border" name="etc" id="etc" value="<?php echo $item['etc'];?>" style="width:100px; height:18px; text-align:center;" onfocusin="in_text_align(this);" onfocusout="out_text_align(this)" onchange="modifyInput(this);" title="<?php echo $item['etc'];?>">
                    <input type="hidden" id="hidden_etc" name="hidden" value="<?php echo $item['etc'];?>">
                  </td>
                  <td class="none_mobile">
                    <!-- <input type="button" name="" value="X" style="text-align:center; cursor:pointer; align:center; font-weight:bold; color:#fff; border-radius:8px; border:none; background-color:#41beeb;" onMouseOver="this.style.backgroundColor='#DBDBDb',this.style.color='#333333'" onMouseOut="this.style.backgroundColor='#41beeb', this.style.color='#fff'" onclick="delete_input(<?php echo $item['seq']; ?>);"> -->
                    <img src="<?php echo $misc; ?>img/btn_x_red.svg" alt="" onclick="delete_input(<?php echo $item['seq']; ?>);" style="cursor:pointer">
                  </td>
                </tr>
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
    <!-- </form> -->
</table>
  </div>
</div>

<?php if($mobile=="true"){ ?>
  <div class="popup-wrap" id="input_popup">
    <div class="popup">
      <div class="popup-head">
        <span class="head-title">차량운행일지 등록</span>
      </div>
      <div class="popup-body">
        <div class="body-content">
          <table class="popup_tbl">
            <colgroup>
              <col width="50%">
              <col width="50%">
            </colgroup>
            <tr>
              <th>차량</th>
              <th>운행일</th>
            </tr>
            <tr>
              <td>
                <select class="mobile_input" id="add_carname" name="add_carname" onchange="find_add_car_a_km();">
                <!-- <select class="input_border" id="carname" name="carname" onChange="changekm();modifyInput(this);find_car_a_km();" style="width:140px; height:23px;"> -->
                <?php foreach($car_list as $cl){ ?>
                  <option value="<?php echo $cl->type."-".$cl->number; ?>"><?php echo $cl->type." / ".$cl->number; ?></option>
                <?php } ?>
                  </select>
              </td>
              <td>
                <input type="date" class="mobile_input" id="add_drive_date" name="add_drive_date" value="">
              </td>
            </tr>
            <tr>
              <th>출발지</th>
              <th>목적지</th>
            </tr>
            <tr>
              <td>
                <input type="text" class="mobile_input" id="add_d_point" name="add_d_point" value="">
              </td>
              <td>
                <input type="text" class="mobile_input" id="add_a_point" name="add_a_point" value="">
              </td>
            </tr>
            <tr>
              <th>출발시간</th>
              <th>도착시간</th>
            </tr>
            <tr>
              <td>
                <input type="time" class="mobile_input" id="add_d_time" name="add_d_time" value="">
              </td>
              <td>
                <input type="time" class="mobile_input" id="add_a_time" name="add_a_time" value="">
              </td>
            </tr>
            <tr>
              <th>출발km</th>
              <th>도착시km</th>
            </tr>
            <tr>
              <td>
                <input type="number" class="mobile_input" id="add_d_km" name="add_d_km" value="" readonly>
              </td>
              <td>
                <input type="number" class="mobile_input" id="add_a_km" name="add_a_km" value="" onkeyup="input_a_km();">
              </td>
            </tr>
            <tr>
              <th>주행거리</th>
              <th>운전자</th>
            </tr>
            <tr>
              <td>
                <input type="number" class="mobile_input" id="add_total_km" name="add_total_km" value="" readonly>
              </td>
              <td>
                <input type="text" class="mobile_input" id="add_driver" name="add_driver" value="">
              </td>
            </tr>
            <tr>
              <th colspan="2">운행목적</th>
            </tr>
            <tr>
              <td colspan="2">
                <input type="text" class="mobile_input2" id="add_drive_purpose" name="add_drive_purpose" value="">
              </td>
            </tr>
            <tr>
              <th>주유비</th>
              <th>기타</th>
            </tr>
            <tr>
              <td>
                <input type="number" class="mobile_input" id="add_oil" name="add_oil" value="">
              </td>
              <td>
                <input type="text" class="mobile_input" id="add_etc" name="add_etc" value="">
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="popup-foot">
        <span class="input_btn input-confirm" id="confirm" onclick="save_action();">등록</span>
        <span class="input_btn input-close" id="confirm" onclick="modalClose('input_popup');">취소</span>
      </div>
    </div>
  </div>
  <div class="popup-wrap" id="detail_popup">
    <div class="popup">
      <div class="popup-head">
        <span class="head-title">운행기록</span>
      </div>
      <div class="popup-body">
        <div class="body-content">
          <table class="popup_tbl">
            <colgroup>
              <col width="50%">
              <col width="50%">
            </colgroup>
            <tr>
              <th>차량</th>
              <th>운행일</th>
            </tr>
            <tr>
              <td id="de_carname"></td>
              <td id="de_drive_date"></td>
            </tr>
            <tr>
              <th>출발지</th>
              <th>목적지</th>
            </tr>
            <tr>
              <td id="de_d_point"></td>
              <td id="de_a_point"></td>
            </tr>
            <tr>
              <th>출발시간</th>
              <th>도착시간</th>
            </tr>
            <tr>
              <td id="de_d_time"></td>
              <td id="de_a_time"></td>
            </tr>
            <tr>
              <th>출발km</th>
              <th>도착시km</th>
            </tr>
            <tr>
              <td id="de_d_km"></td>
              <td id="de_a_km"></td>
            </tr>
            <tr>
              <th colspan="2">운행목적</th>
            </tr>
            <tr>
              <td id="de_drive_purpose"></td>
            </tr>
            <tr>
              <th>운전자</th>
              <th>등록자</th>
            </tr>
            <tr>
              <td id="de_driver"></td>
              <td id="de_writer"></td>
            </tr>
            <tr>
              <th>주유비</th>
              <th>기타</th>
            </tr>
            <tr>
              <td id="de_oil"></td>
              <td id="de_etc"></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="popup-foot">
        <span class="pop-btn confirm" id="confirm" onclick="modalClose('detail_popup');">확인</span>
      </div>
    </div>
  </div>
<?php } ?>

<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<script>
// function changekm(){
//   var car_name = $('#carname').val();
//   var car_num = car_name.split('-')[1];
//   // console.log(car_num);
//   $.ajax({
//     url : "<?php echo site_url(); ?>/biz/durian_car/check_km",
//     type : "POST",
//     dataType : "json",
//     data : {
//       car_num: car_num,
//       seq: seq
//     },
//     success : function(data) {
//       // console.log(data.max_km);
//       $('#d_km').val(data.max_km);
//     }
//   });
// }

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

// function save_action(){
//   var table_tr_length = $('#car_list_table').find('tr').length;
//   for(var i = 1; i< table_tr_length; i++){
//     var table_tr = $('#car_list_table').find('tr').eq(i);
//     var table_carname = table_tr.find('#carname').val();
//     var table_d_point = table_tr.find('#d_point').val();
//     var table_a_point = table_tr.find('#a_point').val();
//     var table_d_km = table_tr.find('#d_km').val();
//     var table_a_km = table_tr.find('#a_km').val();
//     var table_total_km = table_tr.find('#total_km').val();
//     var table_driver = table_tr.find('#driver').val();
//     var table_writer = table_tr.find('#writer').val();
//     var table_drive_date = table_tr.find('#drive_date').val();
//     var table_d_time = table_tr.find('#d_time').val();
//     var table_a_time = table_tr.find('#a_time').val();
//     console.log(table_d_km);
//
//     if(table_carname == '' || table_d_point == '' || table_a_point == '' || table_d_km == '' || table_a_km == '' || table_total_km == '' || table_driver == '' || table_drive_date == '' || table_d_time == '' || table_a_time == ''){
//       alert('입력되지 않은 공란이 있습니다. 확인 후 저장해주세요.');
//       return false;
//       break;
//     }
//   }
// }

function save_action(){
  // modify_close(e);
  // var seq = $(e).attr('seq');
  // console.log(wrong_total_km_arr);

  var table_tr_length = $('#car_list_table').find('tr').length;
  for(var i = 1; i< table_tr_length; i++){
    var table_tr = $('#car_list_table').find('tr').eq(i);
    var table_carname = table_tr.find('#carname').val();
    var table_d_point = table_tr.find('#d_point').val();
    var table_a_point = table_tr.find('#a_point').val();
    var table_d_km = table_tr.find('#d_km').val();
    var table_a_km = table_tr.find('#a_km').val();
    var table_total_km = table_tr.find('#total_km').val();
    var table_driver = table_tr.find('#driver').val();
    var table_writer = table_tr.find('#writer').val();
    var table_drive_date = table_tr.find('#drive_date').val();
    var table_d_time = table_tr.find('#d_time').val();
    var table_a_time = table_tr.find('#a_time').val();
    // console.log(table_d_km);

    if(table_carname == '' || table_d_point == '' || table_a_point == '' || table_d_km == '' || table_a_km == '' || table_total_km == '' || table_driver == '' || table_drive_date == '' || table_d_time == '' || table_a_time == ''){
      alert('입력되지 않은 공란이 있습니다. 확인 후 저장해주세요.');
      return false;
      break;
    }
  }

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
      var oil = tr.find('#oil').val().replace(/,/g, "");
      var etc = tr.find('#etc').val();

      if(carname == null){
        var seq = modify_list_arr[i];
        $.ajax({
          url : "<?php echo site_url(); ?>/biz/durian_car/find_modify_seq",
          type : "POST",
          dataType : "json",
          data : {
            seq: seq
          },
          success : function(data) {
            var prev_seq = '';
            $.ajax({
              url : "<?php echo site_url(); ?>/biz/durian_car/find_before_seq",
              type : "POST",
              dataType : "json",
              data : {
                seq: seq,
                carname: data.carname,
                carnum: data.carnum
              },
              async:false, // 동기 방식으로 변경하면 ajax 결과값을 전역변수에 담으로 수 있다.(지금은 prev_seq에 data2를 담으려고 한다.)
              success : function(data2) {
                prev_seq = data2;
              }
            });

            var carname = data.carname+'-'+data.carnum;
            var d_point = data.d_point;
            var a_point = data.a_point;
            var d_time = data.d_time;
            var a_time = data.a_time;
            var d_km = $('#tr_'+prev_seq).find('#a_km').val();
            var a_km = data.a_km;
            var driver = data.driver;
            var drive_date = data.drive_date;
            var drive_purpose = data.drive_purpose;
            var oil = data.oil;
            var etc = data.etc;
            alert(a_km - d_km);

            val_arr.push({'seq':seq, 'carname':carname, 'd_point':d_point, 'a_point':a_point, 'd_time':d_time, 'a_time':a_time, 'd_km':d_km, 'a_km':a_km, 'driver':driver, 'drive_date':drive_date, 'drive_purpose':drive_purpose, 'oil':oil, 'etc':etc});
          }
        });

      }else{

        val_arr.push({'seq':seq, 'carname':carname, 'd_point':d_point, 'a_point':a_point, 'd_time':d_time, 'a_time':a_time, 'd_km':d_km, 'a_km':a_km, 'driver':driver, 'drive_date':drive_date, 'drive_purpose':drive_purpose, 'oil':oil, 'etc':etc});
      }

      // val_arr.push({'seq':seq, 'carname':carname, 'd_point':d_point, 'a_point':a_point, 'd_time':d_time, 'a_time':a_time, 'd_km':d_km, 'a_km':a_km, 'driver':driver, 'drive_date':drive_date, 'drive_purpose':drive_purpose, 'oil':oil, 'etc':etc});
      // // val_arr.push({'seq':seq, 'carname':carname, 'd_point':d_point, 'a_point':a_point, 'd_time':d_time, 'a_time':a_time, 'd_km':d_km, 'a_km':a_km, 'driver':driver, 'drive_date':drive_date, 'drive_purpose':drive_purpose, 'oil':oil, 'etc':etc});
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
      // console.log(val_arr);

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

// function re_modifyInput(obj){
//   // console.log(obj.id);
//   if(obj.id === 'carname'){
//     $(obj).closest('tr').
//   }else if(obj.id === 'a_km'){
//
//   }
//   var change_val = $(obj).val();
//   var original_val = $(obj).siblings('input[name=hidden]').val();
//   // alert('change_val:'+change_val+' original_val:'+original_val);
//   if(change_val == original_val){
//     $(obj).css('background-color','#fff');
//   }
// }

//새로 입력하는 창 - 도착km 입력시 자동으로 주행거리 계산
function input_a_km(){
  var d_km = $('#add_d_km').val();
  var a_km = $('#add_a_km').val();
  $('#add_total_km').val(a_km - d_km);
}

//해당 차종의 마지막 도착km 기록가져오기
function find_add_car_a_km(){
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
      console.log(data);
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

// $('#carname').change(function(){
//   alert(1);
//   console.log($(this).val());
// })
//해당 차종의 현재 seq 이전의 도착km 기록가져오기
function find_car_a_km(e){
  var seq = $(e).closest('tr').attr('seq');
  var modify_carname = $(e).val();
  var split_carname = modify_carname.split('-');
  var carname = split_carname[0];
  var carnum = split_carname[1];
  $.ajax({
    type: 'POST',
    dataType : "json",
    url: "<?php echo site_url(); ?>/biz/durian_car/find_before_a_km",
    data:{
      seq:seq,
      carname: carname,
      carnum: carnum
    },
    // cache:false,
    // async:false,
    success: function(data) {
      if(data != 'false' && data != null){
        $('#tr_'+seq).find('#d_km').val(data);
        $('#tr_'+seq).find('#d_km').css('background-color','#F08080');
        $('#tr_'+seq).find('#total_km').css('background-color','#F08080');
        $('#tr_'+seq).find('#d_km').attr('readonly',true);
      }else{
        $('#tr_'+seq).find('#d_km').val('');
        $('#tr_'+seq).find('#d_km').css('background-color','#F08080');
        $('#tr_'+seq).find('#total_km').css('background-color','#F08080');
        $('#tr_'+seq).find('#d_km').attr('readonly',false);
      }

      change_km(e)
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

// var wrong_total_km_arr = [];
// function change_km(e){
//   var this_seq = $(e).closest('tr').attr('seq');
//   var this_car = $(e).closest('tr').find('#carname').val();
//   var this_d_km = $(e).closest('tr').find('#d_km').val();
//   var this_a_km = $(e).closest('tr').find('#a_km').val();
//   // var this_a_km = val;
//   var this_total_km = this_a_km - this_d_km;
//   // var prev_d_km = $(e).closest('tr').prevUntil('#carname',this_car);
//
//   var count = ($(e).closest('tr').prevAll().length)-1; //자신을 뺀 나머지 tr의 길이를 구해야 하기에 -1을 해준다
//   var e_count = 0;
//   if(count > 0){
//     for(var i=0; i<count; i++){
//       var prev_seq = $(e).closest('tr').prevAll('tr').eq(i).attr('seq');
//       var prev_car = $(e).closest('tr').prevAll('tr').eq(i).find('#carname').val();
//
//       if(prev_car == this_car){
//         e_count++;
//         var prev_d_km = this_a_km;
//         // var prev_d_km = val;
//         var prev_a_km = $(e).closest('tr').prevAll('tr').eq(i).find('#a_km').val();
//         var prev_total_km = prev_a_km - prev_d_km;
//
//         // alert(prev_d_km+'-'+prev_a_km+'-'+prev_total_km);
//         if(prev_total_km > 0 && this_total_km > 0){
//           $(e).closest('tr').find('#total_km').val(this_total_km);
//
//           $(e).closest('tr').prevAll('tr').eq(i).find('#d_km').val(prev_d_km);
//           // $(e).closest('tr').prevAll('tr').eq(i).find('#d_km').val(val);
//           $(e).closest('tr').prevAll('tr').eq(i).find('#total_km').val(prev_total_km);
//           $(e).closest('tr').prevAll('tr').eq(i).find('#total_km').css('background','#fff');
//           $(e).closest('tr').find('#total_km').css('background','#fff');
//
//           modify_list_arr.push(prev_seq);
//           modify_list_arr = unique(modify_list_arr);
//
//           // 필터함수로 wrong_total_km_arr에서 삭제할 seq를 제거
//           wrong_total_km_arr = wrong_total_km_arr.filter(function(element){return element !== this_seq});
//           wrong_total_km_arr = wrong_total_km_arr.filter(function(element){return element !== prev_seq});
//         }else{
//           alert('주행거리가 0km 이하인 기록이 발생합니다. 다시 확인해주세요.');
//
//           $(e).closest('tr').find('#total_km').val(this_total_km);
//
//           $(e).closest('tr').prevAll('tr').eq(i).find('#d_km').val(prev_d_km);
//           // $(e).closest('tr').prevAll('tr').eq(i).find('#d_km').val(val);
//           $(e).closest('tr').prevAll('tr').eq(i).find('#total_km').val(prev_total_km);
//           if(prev_total_km <= 0){
//             $(e).closest('tr').prevAll('tr').eq(i).find('#total_km').css('background','#7abcfa');
//             wrong_total_km_arr.push(prev_seq);
//           }else if(this_total_km <= 0){
//             $(e).closest('tr').find('#total_km').css('background','#7abcfa');
//             wrong_total_km_arr.push(this_seq);
//           }
//         }
//         break;
//       }
//
//     }
//     if(e_count == 0){ //중간에 차종이 변경되고, 이후에 같은 차종으로 입력된 값이 없고 주행거리가 계산되어야 할 때
//       if(this_total_km < 0){
//         alert('주행거리가 0km 이하인 기록이 발생합니다. 다시 확인해주세요.');
//         $(e).closest('tr').find('#total_km').val(this_total_km);
//         $(e).closest('tr').find('#total_km').css('background','#7abcfa');
//         wrong_total_km_arr.push(this_seq);
//       }else{
//         $(e).closest('tr').find('#total_km').val(this_total_km);
//         $(e).closest('tr').find('#total_km').css('background','#fff');
//         wrong_total_km_arr = wrong_total_km_arr.filter(function(element){return element !== this_seq});
//       }
//     }
//   }else{
//     $(e).closest('tr').find('#total_km').val(this_total_km);
//
//   }
//
// }

var wrong_total_km_arr = [];
function change_km(e){
  var this_seq = $(e).closest('tr').attr('seq');
  var this_car = $('#tr_'+this_seq).find('#carname').val();
  var this_car_name = this_car.split('-')[0];
  var this_car_num = this_car.split('-')[1];
  var this_d_km = $('#tr_'+this_seq).find('#d_km').val();
  var this_a_km = $('#tr_'+this_seq).find('#a_km').val();
  var this_total_km = this_a_km - this_d_km;

  $.ajax({
    url : "<?php echo site_url(); ?>/biz/durian_car/change_km",
    type : "POST",
    dataType : "json",
    data : {
      seq: this_seq,
      carname: this_car_name,
      carnum: this_car_num
    },
    success : function(data) {
      // console.log(data);
      // alert(this_total_km);
      if(data === 'false'){

        if(this_total_km < 0){
          alert('주행거리가 0km 이하인 기록이 발생합니다. 입력하신 km를 다시 확인해주세요.');
          $('#tr_'+this_seq).find('#total_km').val(this_total_km);
          $('#tr_'+this_seq).find('#total_km').css('background-color','#7abcfa');
          wrong_total_km_arr.push(this_seq);
        }else{
          $('#tr_'+this_seq).find('#total_km').val(this_total_km);
          $('#tr_'+this_seq).find('#total_km').css('background-color','#fff');
          wrong_total_km_arr = wrong_total_km_arr.filter(function(element){return element !== this_seq});
        }

      }else{

        var prev_seq = data.seq;
        var prev_d_km = this_a_km;
        var prev_a_km = data.a_km;
        var prev_total_km = prev_a_km - prev_d_km;

        if(prev_total_km > 0 && this_total_km > 0){
          $('#tr_'+prev_seq).find('#d_km').val(prev_d_km);
          $('#tr_'+prev_seq).find('#d_km').css('background-color','#F08080');

          $('#tr_'+this_seq).find('#total_km').val(this_total_km);
          $('#tr_'+this_seq).find('#total_km').css('background-color','#F08080');
          $('#tr_'+prev_seq).find('#total_km').val(prev_total_km);
          $('#tr_'+prev_seq).find('#total_km').css('background-color','#F08080');
          // 수정할 seq 리스트에 prev_seq 추가
          modify_list_arr.push(prev_seq);
          modify_list_arr = unique(modify_list_arr);

          // 필터함수로 wrong_total_km_arr에서 삭제할 seq를 제거
          wrong_total_km_arr = wrong_total_km_arr.filter(function(element){return element !== this_seq});
          wrong_total_km_arr = wrong_total_km_arr.filter(function(element){return element !== prev_seq});
        }else{
          alert('주행거리가 0km 이하인 기록이 발생합니다. 다시 확인해주세요.');

          $('#tr_'+prev_seq).find('#d_km').val(prev_d_km);
          $('#tr_'+prev_seq).find('#d_km').css('background-color','#F08080');

          $('#tr_'+this_seq).find('#total_km').val(this_total_km);
          $('#tr_'+prev_seq).find('#total_km').val(prev_total_km);
          if(prev_total_km <= 0){
            $('#tr_'+prev_seq).find('#total_km').css('background-color','#7abcfa');
            wrong_total_km_arr.push(prev_seq);
          }else if(this_total_km <= 0){
            $('#tr_'+this_seq).find('#total_km').css('background-color','#7abcfa');
            wrong_total_km_arr.push(this_seq);
          }

        }

      }

        // alert(prev_d_km+'-'+prev_a_km+'-'+prev_total_km);
    }
  });
}

function detail(el){
  var seq = $(el).attr('seq');

  $.ajax({
    url: '<?php echo site_url(); ?>/biz/durian_car/find_modify_seq',
    type : "POST",
    dataType : "json",
    data: {
      seq:seq
    },
    success: function(data){
      $("#de_carname").html(data.carname+'('+data.carnum+')');
      $("#de_drive_date").html(data.drive_date);
      $("#de_d_point").html(data.d_point);
      $("#de_a_point").html(data.a_point);
      $("#de_d_time").html(data.d_time);
      $("#de_a_time").html(data.a_time);
      $("#de_d_km").html(data.d_km);
      $("#de_a_km").html(data.a_km);
      $("#de_drive_purpose").html(data.drive_purpose);
      $("#de_driver").html(data.driver);
      $("#de_writer").html(data.writer);
      $("#de_oil").html(data.oil);
      $("#de_etc").html(data.etc);
    }
  })

  $("#detail_popup").css('display','flex').hide().fadeIn();

}

function input_popup() {
  $("#input_popup").find('input').val('');
  find_add_car_a_km();
  $("#input_popup").css('display','flex').hide().fadeIn();
}

function modalClose(tbl){
  $("#"+tbl+"").fadeOut();
}
// function modify(val){
//   var tr = val.parentNode.parentNode;
//   var td_length = tr.childNodes.length;
//   for(i=0;i<td_length;i++){
//     var td = tr.childNodes[i].querySelectorAll().innerText ;
//     console.log(td);
//   }
// }

function commaStr(el) {
  var n = $(el).val();
  var reg = /(^[+-]?\d+)(\d{3})/;
  n += '';

  while (reg.test(n))
    n = n.replace(reg, '$1' + ',' + '$2');
  $(el).val(n);
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

// 숫자만 입력 함수
function onlyNumber(obj) {
  var val = obj.value;
  var re = /[^0-9]/gi;
  obj.value = val.replace(re, "");
}
</script>
</body>
</html>
