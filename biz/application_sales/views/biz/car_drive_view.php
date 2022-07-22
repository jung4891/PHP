<?php
  // 김수성 추가
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
?>
<link rel="stylesheet" href="/misc/css/dashboard.css">
<script language="javascript">
  function chkForm( type ) {
    if(type == 1) {
      if (confirm("정말 삭제하시겠습니까?") == true){
        var mform = document.cform;
        mform.action="<?php echo site_url();?>/biz/durian_car/car_drive_delete_action";
        mform.submit();
        return false;
      }
    } else {
      var mform = document.cform;
      mform.action="<?php echo site_url();?>/biz/durian_car/car_drive_view";
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
      <form name="cform" method="get">
        <input type="hidden" name="seq" value="<?php echo $seq;?>">
        <input type="hidden" name="mode" value="modify">
        <table width="890" border="0" style="margin-top:20px;">

          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <!-- <td colspan="5" height="2" bgcolor="#797c88"></td> -->
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
               <tr>
                 <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border"  >차량</td>
                 <td width="35%" style="padding-left:10px;"  class="t_border" ><?php echo $view_val['carname']."(".$view_val['carnum'].")";?></td>
                 <td idth="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border"  >운행일</td>
                 <td width="35%" align="center"class="t_border"  ><?php echo $view_val['drive_date'];?></td>
               </tr>
               <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>

              <tr>
                <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >출발지</td>
                <td width="35%" style="padding-left:10px;"class="t_border"><?php echo $view_val['d_point'];?></td>
                <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >목적지</td>
                <td width="35%" style="padding-left:10px;" class="t_border" ><?php echo $view_val['a_point'];?></td>
              </tr>
             <tr>
              <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
            </tr>

              <tr>
                <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >출발시간</td>
                <td width="35%" style="padding:10px;"class="t_border" ><?php echo $view_val['d_time'];?></td>
                <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border"  >도착시간</td>
                <td width="35%" style="padding:10px;" class="t_border" ><?php echo $view_val['a_time'];?></td>
              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
              <tr>
                <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >출발시km</td>
                <td  style="padding-left:10px;" class="t_border" ><?php echo $view_val['d_km'];?> km</td>
                <td align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border" >도착시km</td>
                <td  style="padding:10px;" class="t_border" ><?php echo $view_val['a_km'];?> km</td>
              </tr>
             <tr>
              <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
            </tr>

              <tr>
                <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >주행자</td>
                <td  style="padding-left:10px;" class="t_border" ><?php echo $view_val['driver'];?></td>
                <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >등록자</td>
                <td width="35%" style="padding-left:10px;" class="t_border" ><?php echo $view_val['writer'];?></td>
              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
              <tr>
              </tr>
              <tr>
                <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >주유비</td>
                <td  style="padding-left:10px;" class="t_border" ><?php echo $view_val['oil'];?></td>
                <td align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border" >기타</td>
                <td  style="padding-left:10px;" class="t_border" ><?php echo $view_val['etc'];?></td>
              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
            <tr>
              <td colspan="2" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >운행목적</td>
              <td colspan="3"  style="padding-left:10px;" class="t_border" ><?php echo $view_val['drive_purpose'];?>
              </td>
            </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center">
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_list.png" border="0" style="cursor:pointer" onClick="javascript:history.go(-1);"/>
              <img src="<?php echo $misc;?>img/dashboard/btn/btn_adjust.png" id="modifyBtn" style="cursor:pointer" border="0" onClick="javascript:chkForm(0);return false;"/> <img src="<?php echo $misc;?>img/dashboard/btn/btn_delete.png" id="deleteBtn" style="cursor:pointer" border="0" onClick="javascript:chkForm(1);return false;"/></td>
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
