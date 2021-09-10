<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<script language="javascript">
  var chkForm = function () {
   var mform = document.cform;

   if (mform.produce.value == "") {
    mform.produce.focus();
    alert("장비/시스템을 입력해주세요.");
    return false
  }

  if (mform.customer.value == "") {
    mform.customer.focus();
    alert("고객사(등록Site)정보를 입력해주세요.");
    return false
  }

  mform.submit();
  return false;
}
</script>
<body>
  <?php
    include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
  ?>
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <form name="cform" action="<?php echo site_url();?>/tech/tech_board/tech_device_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
    <tr>
      <td align="center" valign="top">

        <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
          <tr>

       <td width="923" align="center" valign="top">


        <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
          <tr>
            <td class="title3">장비/시스템 등록</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="4" height="2" bgcolor="#797c88"></td>
              </tr>
              <tr>
               <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">장비/시스템 명</td>
               <td width="35%" class="t_border" style="padding-left:10px;"><input type="text" name="produce" id="produce" class="input2"/></td>
               <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">서버정보</td>
               <td width="35%" class="t_border" style="padding-left:10px;"><input type="text" name="hardware" id="hardware" class="input2"/></td>
             </tr>
             <tr>
              <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">고객사</td>
              <td width="35%" class="t_border" style="padding-left:10px;"><select name="customer" id="customer" class="input2">
               <?php
               foreach ($customer  as $val) {
                echo '<option value="'.$val['customer'].'"';
                echo '>'.$val['customer'].'</option>';
              }
              ?>

            </select></td>
            <td width="15%" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >Version</td>
            <td width="35%" class="t_border" style="padding-left:10px;"><input type="text" name="version" id="version" class="input2"/></td>
          </tr>
          <tr>
            <td height="40" width="15%" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">Serial Number</td>
            <td width="35%" style="padding-left:10px;" class="t_border"><input type="text" name="sn" id="sn" class="input2"/></td>
            <td width="15%" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">license</td>
            <td width="35%" style="padding-left:10px;" class="t_border"><input type="text" name="license" id="license" class="input2"/></td>
          </tr>
          <tr>
            <td width="15%" height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">날짜(최종수정일)</td>
            <td width="35%" align="center" class="t_border"><?php echo date("Y-m-d");?></td>
            <td idth="15%" height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">등록자</td>
            <td width="35%" align="center" class="t_border"><?php echo $name;?></td>
          </tr>
          <tr>
            <td colspan="4" height="2" bgcolor="#797c88"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right"><input type="image" src="<?php echo $misc;?>img/btn_ok.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:chkForm();return false;"/>  <img src="<?php echo $misc;?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:history.go(-1)"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>


  </td>

</tr>
</table>
</form>

</td>
</tr>
</table>
<?php
 include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php";
?>
</body>
</html>
