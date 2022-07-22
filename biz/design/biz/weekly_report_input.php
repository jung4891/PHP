<?php
 // 김수성 추가
$cnt=0;
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
?>
<script language="javascript">

/// 제출전 확인할것들
var chkForm = function () {
  mform.submit();
  return false;
}

</script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center" valign="top">
        <table width="1130" height="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td width="923" align="center" valign="top">
              <form name="cform" action="<?php echo site_url();?>/biz/weekly_report/weekly_report_input_action"
                method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
                <table width="890" border="0" style="margin-top:20px;">
                  <tr>
                    <td class="title3">주간업무보고 등록</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>
                      <table id="input_table" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td colspan="4" height="2" bgcolor="#797c88"></td>
                        </tr>
                        <tr>
                        <tr>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;"
                            class="t_border">관리팀</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <select name="group" id="group" class="input2">
                              <?php foreach($tech_group as $tg){
                                echo "<option value='{$tg['groupName']}'>{$tg['groupName']}</option>";
                              }?>
                            </select>
                          </td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">주차</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                          <!-- <input name="week" id="week" class="input2"> -->
                            <select name="week" id="week" class="input2">
                                <?php for($k=1; $k<=5; $k++){
                                  echo "<option value={$k}>{$k}주차</option>";
                                }?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                        </tr>

                        <tr>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;"
                            class="t_border">시작일</td>
                          <td width="35%" style="padding-left:10px;" class="t_border"><input type="date" id="s_date"
                              name="s_date" value="" class="input2"></td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;"
                            class="t_border">종료일</td>
                          <td width="35%" style="padding-left:10px;" class="t_border"><input type="date" id="e_date"
                              name="e_date" value="" class="input2"></td>
                        </tr>
                        <tr>
                          <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="4" height="2" bgcolor="#797c88"></td>
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
                      <input type="image" src="<?php echo $misc;?>img/btn_ok.jpg" width="64" height="31"
                        style="cursor:pointer" onClick="javascript:chkForm();return false;" />
                      <img src="<?php echo $misc;?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer"
                        onClick="javascript:history.go(-1)" /></td>
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
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
</html>
