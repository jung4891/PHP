<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
  // tech_device_view 김수성  170209
?>
<script language="javascript">
  function chkForm( type ) {
    if(type == 1) {
      if (confirm("정말 삭제하시겠습니까?") == true){
        var mform = document.cform;
        mform.action="<?php echo site_url();?>/tech_board/tech_device_delete_action";
        mform.submit();
        return false;
      }
    } else {
      var mform = document.cform;
      // var seq = document.cform.seq.value;
       mform.action="<?php echo site_url();?>/tech_board/tech_device_view";
      mform.submit();
      return false;
    }
  }


//$(document).ready(function() {
//   $('li > ul').show();
//});
</script>


<body>
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <form name="cform" method="get">
      <input type="hidden" name="seq" value="<?php echo $seq;?>">
      <input type="hidden" name="mode" value="modify">
      <?php
        include $this->input->server('DOCUMENT_ROOT')."/include/tech_header.php";
      ?>
          <tr>
            <td align="center" valign="top">

              <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
                <tr>
                  
             <td width="923" align="center" valign="top">


              <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
                <tr>
                  <td class="title3">장비/시스템 보기</td>
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
                     <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">고객사</td>
                     <td class="t_border" style="padding-left:10px;"><?php echo $view_val['customer_companyname'];?></td>
                     <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">프로젝트명</td>
                     <td width="35%" class="t_border" style="padding-left:10px;"><?php echo $view_val['project_name'];?></td>
                   </tr>
                   <tr>
                    <td width="15%" height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비명</td>
                    <td width="35%" class="t_border" style="padding-left:10px;"><?php echo $view_val['product_name'];?>

                    </select></td>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td>
                    <td width="35%" height="40" class="t_border" style="padding-left:10px;"><?php echo $view_val['product_item'];?></td>
                  </tr>
                  <tr>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제조사</td>
                    <td width="35%" height="40" class="t_border" style="padding-left:10px;"><?php echo $view_val['product_company'];?></td>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">Serial Number</td>
                    <td width="35%" height="40" class="t_border" style="padding-left:10px;"><?php echo $view_val['product_serial'];?></td>
                  </tr>
                  <tr>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">Version</td>
                    <td width="35%" height="40" class="t_border" style="padding-left:10px;"><?php echo $view_val['product_version'];?></td>
                    <td idth="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">상태</td>
                    <td width="35%" height="40" class="t_border" style="padding-left:10px;">
                      <?php if($view_val['product_state'] == "0") { echo "미입력상태"; }
														else if($view_val['product_state'] == "001") { echo "입고 전"; }
														else if($view_val['product_state'] == "002") { echo "창고"; }
														else if($view_val['product_state'] == "003") { echo "고객사 출고"; }
														else if($view_val['product_state'] == "004") { echo "장애 반납"; }
                      ?></td>
                  </tr>
                  <tr>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">라이선스</td>
                    <td width="35%" height="40" class="t_border" style="padding-left:10px;"><?php echo $view_val['product_licence'];?></td>
                    <td idth="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">용도</td>
                    <td width="35%" height="40" class="t_border" style="padding-left:10px;"><?php echo $view_val['product_purpose'];?></td>
                  </tr>
                  <tr>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">host</td>
                    <td width="35%" height="40" class="t_border" align="left" >
                      <div style="margin: 10px 10px 10px 10px;">
                        <?php echo $view_val['product_host']; ?>
                      </div>
                    </td>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">점검항목 리스트</td>
                    <td width="35%" height="40" class="t_border" align="left" >
                      <div style="margin: 10px 10px 10px 10px;">
                        <?php 
                            foreach($check_list as $check_item){
                              if( $view_val['product_check_list'] == $check_item['seq'] ){
                                echo $check_item['product_name'];
                              }
                            }
                        ?>
                      </div>
                    </td>
                  </tr>
<!--
<?php

$tmp = explode(';;',$view_val['custom_title']);
$tmp2 = explode(';;',$view_val['custom_detail']);

for($i = 0 ; $i<count($tmp); $i++){



?>

                  <tr>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">커스터마이징 제목</td>
                    <td width="85%" height="40" class="t_border" align="center" colspan="3" ><?php echo $tmp[$i];?></td>
                  </tr>
                  <tr>
                    <td width="100%" height="20" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;" colspan="4">상세내역</td>
                  </tr>
                  <tr>
                    <td width="100%" height="40" class="t_border" colspan="4"><?php echo $tmp2[$i];?></td>
                  </tr>


                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
<?php

}

?>-->

   <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>

                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
              </tr>
              <td align="right"><img src="<?php echo $misc;?>img/btn_list.jpg" border="0" style="cursor:pointer" onClick="javascript:history.go(-1);"/> <?php if(/*$name == $view_val['writer'] ||*/ $lv == 2 || $lv == 3 ) {?><img src="<?php echo $misc;?>img/btn_adjust.jpg" style="cursor:pointer" border="0" onClick="javascript:chkForm(0);return false;"/><?php }?></td>
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
