<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<script language="javascript">

function chkForm () {
	var mform = document.cform;

	if (mform.type.value == "") {
		mform.type.focus();
		alert("차종을 입력해 주세요.");
		return false;
	}
	if (mform.number.value == "") {
		mform.number.focus();
		alert("차량번호를 입력해 주세요.");
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
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="cform" action="<?php echo site_url();?>/admin/equipment/car_input_action" method="post" onSubmit="javascript:chkForm();return false;">
  <tr>
    <td align="center" valign="top">
    <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
            <td width="923" align="center" valign="top">
            <!--내용-->
            <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <!--타이틀-->
              <tr>
                <td class="title3">차량</td>
              </tr>
              <!--//타이틀-->
              <tr>
                <td>&nbsp;</td>
              </tr>
             <!--등록-->
              <tr>
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <colgroup>
                  	<col width="20%" />
                    <col width="80%" />

                  </colgroup>
                  <!--시작라인-->
                  <tr>
                    <td colspan="2" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//시작라인-->

                  <tr>
                  	<td height="60" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*차종</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="type" type="text" class="input7" id="type"/></td>
                 </tr>
                 <tr>
                    <td colspan="2" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                 <tr>
                    <td height="60" align="center" bgcolor="f8f8f9" style="font-weight:bold;">*차량 번호</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="number" type="text" class="input7" id="number"  maxlength="10"/></td>
                  </tr>

                  <!--마지막라인-->
                  <tr>
                    <td colspan="2" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->
                </table></td>
              </tr>
              <!--//등록-->

              <tr>
                <td height="10"></td>
              </tr>
              <!--버튼-->
              <tr>
                <td align="right"><input type="image" src="<?php echo $misc;?>img/btn_ok.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;"/> <img src="<?php echo $misc;?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:history.go(-1)"/></td>
              </tr>
              <!--//버튼-->
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
            <!--//내용-->

            </td>

        </tr>
     </table>

    </td>
  </tr>
</form>
</table>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->
</body>
</html>
