<?php
  // 김수성 추가
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
?>
<link rel="stylesheet" href="/misc/css/dashboard.css">
<script language="javascript">
//장비 정보 가져오는 함수

var err_mode=1;
var k =24;
var row_min=32;

var table = null;
var rowCount = null;
var row= null;
var row_count=null;

window.onload = function() {


};




//담당 SE 가져오는 함수
function test2(){

  var settings ='height=500,width=1000,left=0,top=0';

  window.open('/index.php/tech/tech_board/search_se','_blank');
}

/// 제출전 확인할것들
var chkForm = function () {
  var mform = document.cform;
  var arrive = $("#a_km").val();

  if(arrive == ''){
    alert("도착시km를 입력해주세요");
    return false;
  }


  mform.submit();

  return false;
}

</script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
<div class="dash1-1">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
    <script src="<?php echo $misc;?>ckeditor/ckeditor.js"></script>
    <tr height="5%">
      <td class="dash_title"><img src="<?php echo $misc;?>img/dashboard/title_car_drive_list.png"/></td>
    </tr>
        <tr>
          <td align="center" valign="top">

            <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
              <tr>

           <td width="923" align="center" valign="top">
            <!-- 시작합니다. 여기서 부터  -->

            <form name="cform" action="<?php echo site_url();?>/biz/durian_car/car_drive_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
              <input type="hidden" name="seq" value="<?php echo $seq;?>">

              <table width="890" border="0" style="margin-top:20px;">
                <!-- <tr>
                  <td class="title3">차량운행일지 수정</td>
                </tr> -->
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><table id="input_table" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="5" height="2" bgcolor="#797c88"></td>
                    </tr>
                    <tr>
                     <tr>
                      <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >차량</td>
                      <td width="35%"  style="padding-left:10px;" class="t_border" align="center">
                      <input type="hidden" name="carname" id="carname" class="input2" value="<?php echo $view_val['carname']."-".$view_val['carnum'];?>" ><?php echo $view_val['carname']."(".$view_val['carnum'].")";?>
                        <!-- <select name="carname" id="carname" class="input2">
                        <?php foreach($car_list as $cl){ ?>
                          <option value="<?php echo $cl->type."-".$cl->number; ?>" <?php if($view_val['carnum']==$cl->number){echo 'selected';} ?>><?php echo $cl->type."(".$cl->number.")" ?></option>
                        <?php } ?>
                      </select> -->
                    </td>
                      <td idth="15%" height="40" align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border">운행일</td>
                      <td width="35%" align="center" class="t_border"><input type="hidden" id="drive_date" name="drive_date" value="<?php echo $view_val['drive_date'];?>"><?php echo $view_val['drive_date'];?></td>
                    </tr>
                    <tr>
                      <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                    </tr>

                    <tr>
                      <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >출발지</td>
                      <td width="35%" style="padding-left:10px;"class="t_border" >

                        <input name="d_point" id="d_point" class="input2" value="<?php echo $view_val['d_point'];?>" >
                     </td>
                     <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >목적지</td>
                     <td width="35%" style="padding-left:10px;" class="t_border"><input name="a_point" id="a_point" class="input2" value="<?php echo $view_val['a_point'];?>"></td>
                   </tr>
                   <tr>
                    <td colspan="5" height="1" bgcolor="#e8e8e8" class="t_border" ></td>
                  </tr>
                  <tr>
                    <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">출발시간</td>
                    <td width="35%" style="padding:10px;"class="t_border" class="t_border">
                      <input type="time" name="d_time" id="d_time" class="input2" value="<?php echo $view_val['d_time'];?>"  >
                    </td>
                    <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">도착시간</td>
                    <td width="35%" style="padding:10px;"class="t_border" class="t_border">
                      <input type="time" name="a_time" id="a_time" class="input2" value="<?php echo $view_val['a_time'];?>"  >
                    </td>
                  </tr>
                  <tr>
                    <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">출발시km</td>
		   <td width="35%" style="padding-left:10px;" class="t_border"><input name="d_km" id="d_km" class="input2" value="<?php echo $view_val['d_km'];?>"> km</td>

                    </td>
                    <td align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border">도착시km</td>
                    <td  style="padding:10px;" class="t_border">
<input name="a_km" id="a_km" class="input2" value="<?php echo $view_val['a_km'];?>" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">km
                    </td>
                  </tr>
                  <tr>
                    <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
          <tr>
            <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;"class="t_border" >운행목적</td>
            <td colspan="3" style="padding:10px;" class="t_border"><input size="93" name="drive_purpose" id="drive_purpose" style="border: 1px solid #DEDEDE !important;border-radius: 19px !important;opacity: 1 !important;outline: none !important;height:23px;"  value="<?php echo $view_val['drive_purpose'];?>"/> </td>
          </tr>


          <tr>
            <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
          </tr>


                  <tr>
                    <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">주행자</td>
                    <td  style="padding-left:10px;" class="t_border">
                      <input type="text" name="driver" id="driver" class="input2" value="<?php echo $view_val['driver'];?>">
                    </td>
                    <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">등록자</td>
 <input type="hidden" name="writer" id="writer" class="input2" value="<?php echo $name;?>">
                <td width="35%" style="padding:10px;" class="t_border"><?php echo $name;?></td>
                 </tr>
                 <tr>
                  <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                </tr>
                <tr>
                  <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">주유비</td>
                  <td  style="padding-left:10px;" class="t_border">
                    <input type="text" name="oil" id="oil" class="input2" value="<?php echo $view_val['oil'];?>" >원
                  </td>
                  <td align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border">기타</td>
                  <td  style="padding-left:10px;" class="t_border">
                    <input type="text" name="etc" id="etc" class="input2" value="<?php echo $view_val['etc'];?>">
                  </td>
                </tr>
                <tr>
                  <td colspan="5" height="1" bgcolor="#e8e8e8" ></td>
                </tr>
                <tr>
                  <td colspan="5" height="2" bgcolor="#797c88"></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="center">
                <!--지원내용 추가 버튼-->

                <input type="image" src="<?php echo $misc;?>img/dashboard/btn/btn_adjust.png" width="70" height="35" style="cursor:pointer" onClick="javascript:chkForm();return false;"/>
                <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" width="70" height="35" style="cursor:pointer" onClick="javascript:history.go(-1)"/></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
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
</body>
</html>
