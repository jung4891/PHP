<?php
 // 김수성 추가
$cnt=0;
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
?>
<script language="javascript">




//차정보 가져오는 함수
function test1(){

  var settings ='height=500,width=1000,left=0,top=0';

  window.open('/index.php/tech_board/search_se','_blank');

    window.focus();

}
//운전자 가져오는 함수
function test2(){

  var settings ='height=500,width=1000,left=0,top=0';

  window.open('/index.php/tech_board/search_se','_blank');

    window.focus();

}

function changekm(){

  var select = document.getElementById('carname');
  var car_value = document.getElementById('carname').value;

  var car_tmp = car_value.split('-');
 

  var settings ='height=500,width=1000,left=0,top=0';

  var popup =  window.open('/index.php/durian_car/search_car?carnum='+car_tmp[1]);
  window.focus();

}

/// 제출전 확인할것들
var chkForm = function () {
  mform.submit();
  return false;
}

</script>
<body>
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <?php
  include $this->input->server('DOCUMENT_ROOT')."/include/tech_header.php";
  ?>
  <tr>
    <td align="center" valign="top">
      <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr> 
   <td width="923" align="center" valign="top">
    <form name="cform" action="<?php echo site_url();?>/durian_car/car_drive_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
     <table width="890" border="0" style="margin-top:20px;">
      <tr>
        <td class="title3">차량운행일지 등록</td>
      </tr>
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
            <td width="35%" style="padding-left:10px;" class="t_border" >
              <select name="carname" id="carname"  class="input2" onChange="changekm();">
                  <option value="카니발-37부1107">카니발(37부1107)</option>
                  <option value="그랜져-60마6527">그랜져(60마6527)</option>
                  <option value="코나-59무6956">코나(59무6956)</option>
                  <!--<option value="레이-19너7990">레이(19너7990)</option>-->
              </select>
            </td>
            <td idth="15%" height="40" align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border" >운행일</td>
            <td width="35%" style="padding-left:10px;" class="t_border" ><input type="date" id="drive_date" name="drive_date" value="" class="input2"></td>
          </tr>
          <tr>
            <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
          </tr>

          <tr>
            <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">출발지</td>
            <td width="35%" style="padding-left:10px;" class="t_border">
              <input name="d_point" id="d_point" class="input2">
            </td>
            <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">목적지</td>
            <td width="35%" style="padding-left:10px;" class="t_border"><input name="a_point" id="a_point" class="input2"/></td>
          </tr>
          <tr>
            <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
          </tr>
          <tr>
            <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">출발시간</td>
            <td width="35%" style="padding-left:10px;" class="t_border">
              <input type="time" name="d_time" id="d_time" class="input2" >
            </td>
            <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">도착시간</td>
            <td width="35%" style="padding-left:10px;" class="t_border">
              <input type="time" name="a_time" id="a_time" class="input2" >
             </td>
          </tr>
          <tr>
            <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
          </tr>
          <tr>
            <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">출발시km</td>
            <td width="35%" style="padding-left:10px;" class="t_border">
              <input name="d_km" id="d_km" class="input2" value="<?php echo $view_val['max_km'];?>" readonly>km
            </td>
            <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">도착시km</td>
            <td width="35%" style="padding-left:10px;" class="t_border">
              <input name="a_km" id="a_km" class="input2"/></td>
             </td>
          </tr>

          <tr>
            <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
          </tr>
          <tr>
            <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;"class="t_border" >운행목적</td>
            <td colspan="3" style="padding:10px;" class="t_border"><input size="93" name="drive_purpose" id="drive_purpose"/></td>
          </tr>


          <tr>
            <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
          </tr>
          <tr>
            <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;"class="t_border" >운전자</td>
            <td width="35%" style="padding:10px;" class="t_border"><input name="driver" id="customer_manager" class="input2"/></td>
            <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">등록자</td>
            <td width="35%" style="padding:10px;" class="t_border"><input type="hidden" name="writer" id="writer" value="<?php echo $name;?>"/><?php echo $name;?></td>
          </tr>
          <tr>
            <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
          </tr>
          <tr>
            <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">주유비</td>
            <td  style="padding-left:10px;" class="t_border"><input name="oil" id="oil" class="input2"/></td>
            <td align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border">기타</td>
            <td  style="padding:10px;" class="t_border" ><input name="etc" id="etc" class="input2"></td>
          </tr>
          <tr>
           <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
         </tr>
      <tr>
        <td colspan="5" height="2" bgcolor="#797c88"></td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td align="right">
    <!--지원내용 추가 버튼-->
    <input type="image" src="<?php echo $misc;?>img/btn_ok.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:chkForm();return false;"/>
    <img src="<?php echo $misc;?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:history.go(-1)"/></td>
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

<tr>
 <td align="center" height="100" bgcolor="#CCCCCC"><table width="1130" cellspacing="0" cellpadding="0" >
  <tr>
    <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img src="<?php echo $misc;?>img/f_ci.png"/></td>
    <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/customer_bottom.php"; ?></td>
  </tr>
</table></td>
</tr>
</table>
</body>
</html>
