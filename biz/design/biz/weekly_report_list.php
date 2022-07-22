<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
?>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script language="javascript">
function search(){
  if($("#search1").val() == "002"){
    $("#searchPlace2").show();
  }else{
    $("#searchPlace2").hide();
  }
}
function GoSearch(){
    var searchkeyword = document.mform.searchkeyword.value;
    var searchkeyword = searchkeyword.trim();
    document.mform.searchkeyword.value = searchkeyword;
    var searchkeyword2 = document.mform.searchkeyword2.value;
    var searchkeyword2 = searchkeyword2.trim();
    document.mform.searchkeyword2.value = searchkeyword2;

    if(searchkeyword == ""){
      alert( "검색어를 입력해 주세요." );
      return false;
    }

  document.mform.action = "<?php echo site_url();?>/biz/weekly_report/weekly_report_list";
  document.mform.cur_page.value = "";
  document.mform.submit();
}
</script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
<div class="dash1-1">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
  <form name="mform" action="<?php echo site_url();?>/biz/weekly_report/weekly_report_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
  <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
  <input type="hidden" name="seq" value="">
  <input type="hidden" name="mode" value="">
  <tbody height="100%">
    <tr height="5%">
      <td class="dash_title">
        주간업무보고
      </td>
    </tr>
    <!-- <tr>
      <td height="10"></td>
    </tr> -->
    <!-- 검색창 -->
    <tr>
      <td align="left" valign="bottom">
      <!-- <td width="100%" style="align:left; float:left"> -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:70px;">
          <tr>
            <td>
              <select name="search1" id="search1" class="select-common select-style1" onchange="search();">
                <option value="001" <?php if($search1 == "001"){ echo "selected";}?>>관리팀</option>
                <option value="002" <?php if($search1 == "002"){ echo "selected";}?>>주차</option>
                <option value="003" <?php if($search1 == "003"){ echo "selected";}?>>보고자</option>
              </select>
              <span id="searchPlace">
                <input type="text" size="25" class="input-common" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
              </span>
              <span id="searchPlace2" <?php if($search_keyword2 == ""){echo "style='display:none'";} ?>>월<input type="text" class="input-common" name="searchkeyword2" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword2);?>"/>주차</span>
              <span>
                <input type="button" class='btn-common btn-style1' onClick="return GoSearch();" value="검색" />
              </span>
              <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_write.png" width="90" height="35" style="cursor:pointer;" onClick="$('#weekly_report_input').bPopup();"/> -->
              <input type="button" class="btn-common btn-color2" value="글쓰기" onClick="$('#weekly_report_input').bPopup();" style="float:right;">
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <!-- <tr>
      <td height="10"></td>
    </tr> -->
    <tr height="45%">
      <td colspan="2" valign="top" style="padding:10px 0px;">
        <table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top">
              <tr>
                <td>
                  <table class="list_tbl" style="margin-top:20px;" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <colgroup>
                      <col width="15%">
                      <col width="5%">
                      <col width="10%">
                      <col width="35%">
                      <col width="5%">
                      <col width="10%">
                      <col width="5%">
                      <col width="15%">
                    </colgroup>

                    <tr class="t_top row-color1">
                      <th></th>
                      <th height="40" align="center">No.</th>
                      <th align="center">관리팀</th>
                      <th align="center">제목</th>
                      <th align="center">보고자</th>
                      <th align="center">작성일</th>
                      <th align="center">결재</th>
                      <th></th>
                    </tr>
<?php
  if ($count > 0) {
    $i = $count - $no_page_list * ( $cur_page - 1 );
    $icounter = 0;

    foreach ( $list_val as $item ) {
?>
                    <tr onMouseOver="this.style.backgroundColor='#EAEAEA'" onMouseOut="this.style.backgroundColor='#fff'">
                      <td></td>
                      <td height="40" align="center"><?php echo $i;?></td>
                      <td align="center">
                        <a href="JavaScript:ViewBoard('<?php echo $item['seq'];?>')">
                          <?php echo $item['group_name']; ?>
                        </a>
                      </td>
                      <td align="center" onclick="ViewBoard('<?php echo $item['seq'];?>')" style="cursor:pointer;">
<?php
	$tmp=explode(" ",$item['s_date']);
	$tmp2=explode("-",$tmp[0]);
  echo $tmp2[0]."년 ".$item['month']."월 ".$item['week']."주차 주간업무보고" ;
?>
                      </td>
                      <td align="center">
                       <?php echo $item['writer'];?>
                      </td>
                      <td align="center">
                         <?php echo substr($item['update_time'],0,10);?>
                      </td>
                      <td align="center">
                        <?php if($item['approval_yn'] == "Y"){echo "승인"; }else{echo "미승인";} ?>
                      </td>
                      <td></td>
                    </tr>
<?php
      $i--;
      $icounter++;
    }
  } else {
?>
                    <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
                      <td width="100%" height="40" align="center" colspan="6">등록된 게시물이 없습니다.</td>
                    </tr>
                    <tr>
                      <td height="10"></td>
                    </tr>
<?php
  }
?>
                  </table>
                </td>
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
  document.mform.action = "<?php echo site_url();?>/biz/weekly_report/weekly_report_view";
  document.mform.seq.value = seq;
  document.mform.mode.value = "view";

  document.mform.submit();
}
</script>
            </td>
          </tr>
        </table>
      </tr>
      <!-- <tr>
        <td height="10"></td>
      </tr> -->
      <tr height="20%">
        <td align="center" valign="top">
<?php
if ($count > 0) {
?>
          <table width="400" border="0" cellspacing="0" cellpadding="0">
            <tr>
<?php
  if ($cur_page > 10){
?>
              <td width="19">
                <a href="JavaScript:GoFirstPage()">
                  <img src="<?php echo $misc;?>img/dashboard/btn/btn_first.png"  width="20" height="20"/>
                </a>
              </td>
              <td width="2"></td>
              <td width="19">
                <a href="JavaScript:GoPrevPage()">
                  <img src="<?php echo $misc;?>img/dashboard/btn/btn_left.png" width="20" height="20" />
                </a>
              </td>
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
?>
              </td>
<?php
  if ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
?>
              <td width="19">
                <a href="JavaScript:GoNextPage()">
                  <img src="<?php echo $misc;?>img/dashboard/btn/btn_right.png" width="20" height="20"/>
                </a>
              </td>
              <td width="2"></td>
              <td width="19">
                <a href="JavaScript:GoLastPage()">
                  <img src="<?php echo $misc;?>img/dashboard/btn/btn_last.png" width="20" height="20"/>
                </a>
              </td>
<?php
  } else {
?>
              <td width="19"></td>
              <td width="2"></td>
              <td width="19"></td>
<?php
}
?>
            <tr>
              <td height="10"></td>
            </tr>
          </table>
<?php
}
?>
        </td>
       </tr>
      </form>
     </td>
    </tr>
   </tbody>
  </table>
 </div>
</div>


<!-- 주간업무 등록 시작 -->
<div id="weekly_report_input" style="display:none; position: absolute; background-color: white; width: auto; height: auto;">
  <form name="cform" id="cform" method="post" enctype="multipart/form-data">
    <table width="100%" height="100%" style="padding:20px 18px;" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="4" align="left" valign="top" style="padding-bottom:20px; font-weight:bold; font-size:17px;">주간업무보고 등록</td>
      </tr>
      <tr>
        <th colspan="4" height="2"></th>
        <tr height="40">
          <td align="left" style="padding:0 8px 5px; font-weight:bold;">
            관리팀
          </td>
          <td>
            <select name="group" id="group" class="select-common" style="width:150px; height:25px;">
              <?php foreach($tech_group as $tg){
                echo "<option value='{$tg['groupName']}'>{$tg['groupName']}</option>";
              }?>
            </select>
          </td>
          <td align="left" style="padding:0 8px 5px; font-weight:bold;">
            주차
          </td>
          <td>
            <select name="week" id="week" class="select-common" style="width:150px; height:25px;">
              <?php for($k=1; $k<=5; $k++){
                echo "<option value={$k}>{$k}주차</option>";
              }?>
            </select>
          </td>
        </tr>
        <tr height="40">
          <td align="left" style="padding:0 8px 5px; font-weight:bold;">
            시작일
          </td>
          <td>
            <input type="date" id="s_date" name="s_date" value="" class="input-common input-style1" style="width:150px; height:25px;">
          </td>
          <td align="left" style="padding:0 8px 5px; font-weight:bold;">
            종료일
          </td>
          <td>
            <input type="date" id="e_date" name="e_date" value="" class="input-common input-style1" style="width:150px; height:25px;">
          </td>
        </tr>
      </tr>
      <tr>
        <td colspan="4" align="center" style="padding-top:30px;">
          <!--지원내용 추가 버튼-->
          <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_add.png" width="64" height="31" style="cursor:pointer; padding:0 5px;" onClick="report_input_action();"/>

          <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" width="64" height="31" style="cursor:pointer; padding:0 5px;" onClick="$('#weekly_report_input').bPopup().close();" /> -->
          <input type="button" class="btn-common btn-color2" name="" value="등록" onClick="report_input_action();" style="float:right;">
          <input type="button" class="btn-common btn-color1" name="" value="취소" onClick="$('#weekly_report_input').bPopup().close();" style="float:right;margin-right:10px;">
        </td>
      </tr>
    </table>
  </form>
</div>
<!-- 폼 끝 -->


<!-- 주간업무 등록 시작 -->
<!-- <div id="weekly_report_input" style="display:none; position: absolute; background-color: white; width: auto; height: auto;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top">
      <table width="1130" height="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td width="923" align="center" valign="top">
            <form name="cform" id="cform" method="post" enctype="multipart/form-data">
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
                    <img src="<?php echo $misc;?>img/btn_ok.jpg" width="64" height="31" style="cursor:pointer;" onClick="report_input_action();"/>

                    <img src="<?php echo $misc;?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer" onClick="$('#weekly_report_input').bPopup().close();" />
                  </td>
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
  </form> -->
  <!-- 폼 끝 -->
</table>
</div>
<script>
function report_input_action(){
  var group_name = $('#group').val();
  var s_date = $('#s_date').val();
  var e_date = $('#e_date').val();
  var week = $('#week').val();
  var split_date = e_date.split('-');
  var year = split_date[0];
  var month = split_date[1];
  // console.log(group_name + s_date + week + year + month);
  if(s_date =='' || e_date ==''){
    alert('날짜를 선택해주세요.');
    return false;
  }
  $.ajax({
    url : "<?php echo site_url(); ?>/biz/weekly_report/weekly_report_duplcheck",
    type : "POST",
    dataType : "json",
    data : {
      group_name : group_name,
      year: year,
      month: month,
      week: week
    },
    success : function(data) {
      // console.log(data);
      if(data == 'dupl'){
        alert("중복되는 주간업무보고서가 존재합니다. 다시 입력해 주세요.");
      }else{
        var act = "<?php echo site_url();?>/biz/weekly_report/weekly_report_input_action";
        $("#cform").attr('action', act);
        $("#cform").submit();
      }
    }

});
}
</script>
<!-- 주간업무등록 끝 -->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
</html>
