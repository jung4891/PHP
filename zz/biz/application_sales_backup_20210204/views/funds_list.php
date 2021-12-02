<?php

	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

//print_r($_POST);

?>
<script language="javascript">

window.onload = function () {
  change();
}

function GoSearch() {
  var year = document.mform.search1.value;
  var company = document.mform.search1.value;

  document.mform.action = "<?php echo site_url();?>/funds/funds_list";
  document.mform.submit();
}

function change() {
  var search2 = document.getElementById("search2").selectedIndex;

  var searchkeyword2 = document.getElementById("searchkeyword2");

  if (search2 == 8) {
    searchkeyword2.style = "width:130px;";
  } else {
    searchkeyword2.style = "display:none;";
  }
}
</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="mform" action="<?php echo site_url();?>/maintain/maintain_list" method="post" onkeydown="if(event.keyCode==13) return GoSearch();">
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
if($search2=="IT"){
	echo "(두리안정보기술-".$search1.")";
}else if($search2=="D_1")
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
                <td><table border="0" cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                    <td>
                      <select name="search1" id="search1" class="input">
                        <option  option value="0"> 연도 선택</option>
                        <option value="2019" <?php if($search1 == "2019"){ echo "selected";}?>>2019</option>
                        <option value="2020" <?php if($search1 == "2020"){ echo "selected";}?>>2020</option>
                        <option value="2021" <?php if($search1 == "2021"){ echo "selected";}?>>2021</option>
                        <option value="2022" <?php if($search1 == "2022"){ echo "selected";}?>>2022</option>
                        <option value="2023" <?php if($search1 == "2023"){ echo "selected";}?>>2023</option>
                      </select>
                      <select name="search2" id="search2" class="input">
                        <option value="0"> 업체 선택</option>
                        <option value="IT" <?php if($search2 == "IT"){ echo "selected";}?>>두리안정보기술</option>
                        <option value="D_1" <?php if($search2 == "D_1"){ echo "selected";}?>>사업1부</option>
                        <option value="D_2" <?php if($search2 == "D_2"){ echo "selected";}?>>사업2부</option>
                        <option value="ICT" <?php if($search2 == "ICT"){ echo "selected";}?>>두리안정보통신기술</option>
                        <option value="MG" <?php if($search2 == "MG"){ echo "selected";}?>>더망고</option>
                      </select>
                      <input type="image" style='cursor:hand;vertical-align:middle' onclick="return GoSearch();" src="<?php echo $misc;?>img/btn_search.jpg" align="middle" border="0" />
                    </td>
                    <td width="75%" align="right">
                      <select id="detail_view_month" class="input" style="margin:5px 10px 0px 0px;">
                        <option value="">해당월 선택</option>
                        <?php for($i=1; $i<=12; $i++){ ?>
                          <option value="<?php echo $i; ?>"><?php echo $i; ?>월</option>
                        <?php } ?>
                      </select>
                      <input type="button" class="basicBtn" value="상세내역보기" style="float:right" onclick="detailView();" ></td>
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
                    <col width="5.1%" /> <!-- 연 -->
                    <col width="7.2%" /> <!-- 1 -->
                    <col width="7.2%" /> <!-- 2  -->
                    <col width="7.2%" /> <!-- 3  -->
                    <col width="7.2%" /> <!-- 4 -->
                    <col width="7.2%" /> <!-- 5 -->
                    <col width="7.2%" /> <!-- 6 -->
                    <col width="7.2%" /> <!-- 7 -->
                    <col width="7.2%" /> <!-- 8 -->
                    <col width="7.2%" /> <!-- 9 -->
                    <col width="7.2%" /> <!--10 -->
                    <col width="7.2%" /> <!--11 -->
                    <col width="7.2%" /> <!--12 -->
                    <col width="8.5%" /> <!--총합 -->
                  </colgroup>
                  <tr>
                    <td colspan="14" height="2" bgcolor="#797c88"></td>
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
                    <td align="center" class="t_border">합계</td>
                  </tr>
                  <tr>
                    <td colspan="14" height="1" bgcolor="#797c88"></td>
                  </tr>
<!-- 목표 금액 -->
                  <tr>
                    <td align="center">목표</td>
                    <td align="center" class="t_border"><?php echo number_format($item[0]['purpose_1']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($item[0]['purpose_2']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($item[0]['purpose_3']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($item[0]['purpose_4']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($item[0]['purpose_5']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($item[0]['purpose_6']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($item[0]['purpose_7']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($item[0]['purpose_8']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($item[0]['purpose_9']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($item[0]['purpose_10']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($item[0]['purpose_11']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($item[0]['purpose_12']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($sum_purpose);?></td>
                  </tr>
                  <tr>
                    <td colspan="14" height="1" bgcolor="#797c88"></td>
                  </tr>

                  <tr>
                    <td align="center">달성</td>
                    <td align="center" class="t_border"><?php echo number_format($achieve_1[0]['sum']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($achieve_2[0]['sum']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($achieve_3[0]['sum']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($achieve_4[0]['sum']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($achieve_5[0]['sum']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($achieve_6[0]['sum']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($achieve_7[0]['sum']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($achieve_8[0]['sum']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($achieve_9[0]['sum']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($achieve_10[0]['sum']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($achieve_11[0]['sum']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($achieve_12[0]['sum']);?></td>
                    <td align="center" class="t_border"><?php echo number_format($sum_achieve);?></td>
                  </tr>
                  <tr>
                    <td colspan="14" height="1" bgcolor="#797c88"></td>
                  </tr>

                  <tr>
                    <td align="center">달성률</td>
		    <?php if($item[0]['purpose_1']==0){ ?>
        	            <td align="center" class="t_border"> - </td>
		    <?php }else{?>
	                    <td align="center" class="t_border"><?php echo round($achieve_1[0]['sum']*100/$item[0]['purpose_1'],1) ;?>%</td>
		    <?php }?>

		    <?php if($item[0]['purpose_2']==0){ ?>
        	            <td align="center" class="t_border"> - </td>
		    <?php }else{?>
	                    <td align="center" class="t_border"><?php echo round($achieve_2[0]['sum']*100/$item[0]['purpose_2'],1) ;?>%</td>
		    <?php }?>

		    <?php if($item[0]['purpose_3']==0){ ?>
        	            <td align="center" class="t_border"> - </td>
		    <?php }else{?>
	                    <td align="center" class="t_border"><?php echo round($achieve_3[0]['sum']*100/$item[0]['purpose_3'],1) ;?>%</td>
		    <?php }?>

		    <?php if($item[0]['purpose_4']==0){ ?>
        	            <td align="center" class="t_border"> - </td>
		    <?php }else{?>
	                    <td align="center" class="t_border"><?php echo round($achieve_4[0]['sum']*100/$item[0]['purpose_4'],1) ;?>%</td>
		    <?php }?>

		    <?php if($item[0]['purpose_5']==0){ ?>
        	            <td align="center" class="t_border"> - </td>
		    <?php }else{?>
	                    <td align="center" class="t_border"><?php echo round($achieve_5[0]['sum']*100/$item[0]['purpose_5'],1) ;?>%</td>
		    <?php }?>

		    <?php if($item[0]['purpose_6']==0){ ?>
        	            <td align="center" class="t_border"> - </td>
		    <?php }else{?>
	                    <td align="center" class="t_border"><?php echo round($achieve_6[0]['sum']*100/$item[0]['purpose_6'],1) ;?>%</td>
		    <?php }?>

		    <?php if($item[0]['purpose_7']==0){ ?>
        	            <td align="center" class="t_border"> - </td>
		    <?php }else{?>
	                    <td align="center" class="t_border"><?php echo round($achieve_7[0]['sum']*100/$item[0]['purpose_7'],1) ;?>%</td>
		    <?php }?>

		    <?php if($item[0]['purpose_8']==0){ ?>
        	            <td align="center" class="t_border"> - </td>
		    <?php }else{?>
	                    <td align="center" class="t_border"><?php echo round($achieve_8[0]['sum']*100/$item[0]['purpose_8'],1) ;?>%</td>
		    <?php }?>

		    <?php if($item[0]['purpose_9']==0){ ?>
        	            <td align="center" class="t_border"> - </td>
		    <?php }else{?>
	                    <td align="center" class="t_border"><?php echo round($achieve_9[0]['sum']*100/$item[0]['purpose_9'],1) ;?>%</td>
		    <?php }?>

		    <?php if($item[0]['purpose_10']==0){ ?>
        	            <td align="center" class="t_border"> - </td>
		    <?php }else{?>
	                    <td align="center" class="t_border"><?php echo round($achieve_10[0]['sum']*100/$item[0]['purpose_10'],1) ;?>%</td>
		    <?php }?>

		    <?php if($item[0]['purpose_11']==0){ ?>
        	            <td align="center" class="t_border"> - </td>
		    <?php }else{?>
	                    <td align="center" class="t_border"><?php echo round($achieve_11[0]['sum']*100/$item[0]['purpose_11'],1) ;?>%</td>
		    <?php }?>

		    <?php if($item[0]['purpose_12']==0){ ?>
        	            <td align="center" class="t_border"> - </td>
		    <?php }else{?>
	                    <td align="center" class="t_border"><?php echo round($achieve_12[0]['sum']*100/$item[0]['purpose_12'],1) ;?>%</td>
		    <?php }?>

		    <?php if($sum_purpose==0){ ?>
        	            <td align="center" class="t_border"> - </td>
		    <?php }else{?>
	                    <td align="center" class="t_border"><?php echo round($sum_achieve*100/$sum_purpose,1) ;?>%</td>
		    <?php }?>
                  </tr>
<!-- -->
                    <td colspan="14" height="2" bgcolor="#797c88"></td>
                  </tr>
                </table></td>
              </tr>
              <!--리스트-->
<script language="javascript">

function ViewBoard (seq){
	document.mform.action = "<?php echo site_url();?>/maintain/maintain_view";
	document.mform.seq.value = seq;
	document.mform.mode.value = "modify";

	document.mform.submit();
}
</script>
              <tr>
                <td height="15"></td>
              </tr>
              <!--버튼-->
              <tr>
                <td align="right"><a href="<?php echo site_url();?>/funds/funds_input" title="작성하기"><img src="<?php echo $misc;?>img/btn_make.jpg" width="64" height="31" /></a></td>
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
<script>
  function detailView(){
    if($("#detail_view_month").val() == ""){
      alert("해당월을 선택해주세요");
      $("#detail_view_month").focus();
      return false;
    }else{
      var year = $("#search1").val();
      var month = $("#detail_view_month").val();
      var company = $("#search2").val();

      window.open("<?php echo site_url();?>/funds/funds_list_detail_view?year="+year+"&month="+month+"&company="+company);
    }
  }
</script>
</body>
</html>