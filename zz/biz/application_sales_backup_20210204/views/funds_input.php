<?php

	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

//print_r($_POST);

?>
<script language="javascript">


function GoSearch(){
	var year = document.mform.search1.value;
	var company = document.mform.search1.value;
	
	document.mform.action = "<?php echo site_url();?>/funds/funds_input";
	document.mform.submit();
}
</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="mform" action="<?php echo site_url();?>/funds/funds_list" method="post" onkeydown="if(event.keyCode==13) return GoSearch();">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
	<tr>
    <td align="center" valign="top">
    <table width="90%" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
            <td width="100%" align="center" valign="top">
            <!--내용-->
            <table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <!--타이틀-->
              <tr>
                <td class="title3">매출현황 <?php  


if($search2=="IT")
	echo "(두리안정보기술- ".$search1.")";
else if($search2=="D_1")
	echo "(사업1부- ".$search1.")";
else if($search2=="D_2")
	echo "(사업2부- ".$search1.")";
else if($search2=="ICT")
	echo "(두리안정보통신기술- ".$search1.")";
else if($search2=="MG")
	echo "(더망고- ".$search1.")";
else
	echo "";


?></td>
              </tr>
              <!--타이틀-->
              <tr>
                <td>&nbsp;</td>
              </tr>
              <!--선택/찾기-->
              <tr>
                <td><table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>
                    <select name="search1" id="search1" class="input">
		     <option value="0"> 연도 선택</option>
                     <option value="2019" <?php if($search1 == "2019"){ echo "selected";}?>>2019</option>
                     <option value="2020" <?php if($search1 == "2020"){ echo "selected";}?>>2020</option>
		     <option value="2021" <?php if($search1 == "2021"){ echo "selected";}?>>2021</option>
		     <option value="2022" <?php if($search1 == "2022"){ echo "selected";}?>>2022</option>
		     <option value="2023" <?php if($search1 == "2023"){ echo "selected";}?>>2023</option>
                     </select>
                    <select name="search2" id="search2" class="input">
		     <option value="0"> 업체 선택</option>
                     <option value="IT" <?php if($search2 == "D_1"){ echo "selected";}?>>두리안정보기술</option>
                     <option value="D_1" <?php if($search2 == "D_1"){ echo "selected";}?>>사업1부</option>
		     <option value="D_2" <?php if($search2 == "D_2"){ echo "selected";}?>>사업2부</option>
		     <option value="ICT" <?php if($search2 == "ICT"){ echo "selected";}?>>두리안정보통신기술</option>
		     <option value="MG" <?php if($search2 == "MG"){ echo "selected";}?>>더망고</option>
                     </select>
                    </td>
                    <td style="padding-left:10px;"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td style="padding-left:2px;"><input type="image" style='cursor:hand' onclick="return GoSearch();" src="<?php echo $misc;?>img/btn_search.jpg" align="middle" border="0" />
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
              <!--선택/찾기-->
              <tr>
                <td>&nbsp;</td>
              </tr>
              <!--리스트-->
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <colgroup>
                    <col width="4%" /> <!-- 연 -->
                    <col width="8%" /> <!-- 1 -->
                    <col width="8%" /> <!-- 2  -->
                    <col width="8%" /> <!-- 3  -->
                    <col width="8%" /> <!-- 4 -->
                    <col width="8%" /> <!-- 5 -->
                    <col width="8%" /> <!-- 6 -->
                    <col width="8%" /> <!-- 7 -->
                    <col width="8%" /> <!-- 8 -->
                    <col width="8%" /> <!-- 9 -->
                    <col width="8%" /> <!--10 -->
                    <col width="8%" /> <!--11 -->
                    <col width="8%" /> <!--12 -->
                  </colgroup>
                  <tr>
                    <td colspan="13" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <tr bgcolor="f8f8f9" class="t_top">
                    <td align="center">월</td>
                    <td align="center" class="t_border">1월</td>
                    <td align="center" class="t_border">2월</td>
                    <td align="center" class="t_border">3월</td>
                    <td align="center" class="t_border">4월</td>
                    <td align="center" class="t_border">5월</td>
                    <td align="center" class="t_border">6월</td>
                    <td align="center" class="t_border">7월</td>
                    <td align="center" class="t_border">8월</td>
                    <td align="center" class="t_border">9월</td>
                    <td align="center" class="t_border">10월</td>
                    <td align="center" class="t_border">11월</td>
                    <td align="center" class="t_border">12월</td>
                  </tr>
                  <tr>
                    <td colspan="13" height="1" bgcolor="#797c88"></td>
                  </tr>
<!-- 목표 금액 -->
                  <tr>
                    <td align="center">목표</td>
                    <td align="center" class="t_border"><input type="text" id="purpose_1" name="purpose_1" class="input5" value=<?php echo $item[0]['purpose_1'];?>></td>
                    <td align="center" class="t_border"><input type="text" id="purpose_2" name="purpose_2" class="input5" value=<?php echo $item[0]['purpose_2'];?>></td>
                    <td align="center" class="t_border"><input type="text" id="purpose_3" name="purpose_3" class="input5" value=<?php echo $item[0]['purpose_3'];?>></td>
                    <td align="center" class="t_border"><input type="text" id="purpose_4" name="purpose_4" class="input5" value=<?php echo $item[0]['purpose_4'];?>></td>
                    <td align="center" class="t_border"><input type="text" id="purpose_5" name="purpose_5" class="input5" value=<?php echo $item[0]['purpose_5'];?>></td>
                    <td align="center" class="t_border"><input type="text" id="purpose_6" name="purpose_6" class="input5" value=<?php echo $item[0]['purpose_6'];?>></td>
                    <td align="center" class="t_border"><input type="text" id="purpose_7" name="purpose_7" class="input5" value=<?php echo $item[0]['purpose_7'];?>></td>
                    <td align="center" class="t_border"><input type="text" id="purpose_8" name="purpose_8" class="input5" value=<?php echo $item[0]['purpose_8'];?>></td>
                    <td align="center" class="t_border"><input type="text" id="purpose_9" name="purpose_9" class="input5" value=<?php echo $item[0]['purpose_9'];?>></td>
                    <td align="center" class="t_border"><input type="text" id="purpose_10" name="purpose_10" class="input5" value=<?php echo $item[0]['purpose_10'];?>></td>
                    <td align="center" class="t_border"><input type="text" id="purpose_11" name="purpose_11" class="input5" value=<?php echo $item[0]['purpose_11'];?>></td>
                    <td align="center" class="t_border"><input type="text" id="purpose_12" name="purpose_12" class="input5" value=<?php echo $item[0]['purpose_12'];?>></td>
                  </tr>
                    <td colspan="13" height="2" bgcolor="#797c88"></td>
                  </tr>
                </table></td>
              </tr>
              <!--리스트-->
<script language="javascript">

function GoModify(){

	document.mform.action = "<?php echo site_url();?>/funds/funds_input_action";

	document.mform.submit();
}
</script>
              <tr>
                <td height="15"></td>
              </tr>
              <!--버튼-->
              <tr>
                <td align="right"><img src="<?php echo $misc;?>img/btn_adjust.jpg" onclick="return GoModify();"width="64" height="31" /></a></td>
              </tr>
              <!--버튼-->

              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
            <!--내용-->

            </td>
        </tr>
     </table>

    </td>
  </tr>
  <!--하단-->
  <tr>
  	<td align="center" height="100" bgcolor="#CCCCCC"><table width="1130" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img src="<?php echo $misc;?>img/f_ci.png"/></td>
        <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?></td>
      </tr>
    </table></td>
  </tr>
  <!--하단-->
</form>
</table>

</body>
</html>