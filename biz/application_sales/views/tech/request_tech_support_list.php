<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

  // 체크해놓은 seq 가져오기
  $checkSeq ='';
  if(isset($_GET['check_seq']) && $_GET['check_seq']!=''){
    $checkSeq = explode(',',$_GET['check_seq']);
  }
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style>
.person_item{

  height:33%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family:"Noto Sans KR", sans-serif;
}
</style>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script language="javascript">

window.onload=function(){
   change();
}

function change() {
  var search1 = document.getElementById("search1").value;

  if (search1 == '007') {
    $("#searchkeyword").prop("type", "date");
  } else {
    $("#searchkeyword").prop("type", "text");
  }

  if(search1 == '006'){
    $("#searchkeyword").attr("placeholder", "승인: y , 미승인: n");
  }else{
    $("#searchkeyword").attr("placeholder", "검색하세요.");
  }

  if (search1 == '004') { //장비명
    $("#searchkeyword2").prop("type", "text");
  } else {
    $("#searchkeyword2").prop("type", "hidden");
  }


}

function GoSearch(){
  var searchkeyword = document.mform.searchkeyword.value;
  var searchkeyword = searchkeyword.trim();

  var searchkeyword2 = document.mform.searchkeyword2.value;
  var searchkeyword2 = searchkeyword2.trim();

  if(searchkeyword == ""){
    alert( "검색어를 입력해 주세요." );
    return false;
  }

  document.mform.action = "<?php echo site_url();?>/tech/tech_board/request_tech_support_list";
  document.mform.cur_page.value = "";
  document.mform.submit();
}

</script>
<script language="javascript">
function GoFirstPage (){
  $("input[name=check]").attr("disabled",true);
  document.mform.cur_page.value = 1;
  document.mform.submit();
}

function GoPrevPage (){
  $("input[name=check]").attr("disabled",true);
  var cur_start_page = <?php echo $cur_page;?>;

  document.mform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
  document.mform.submit( );
}

function GoPage(nPage){
  $("input[name=check]").attr("disabled",true);
  document.mform.cur_page.value = nPage;
  document.mform.submit();
}

function GoNextPage (){
  $("input[name=check]").attr("disabled",true);
  var cur_start_page = <?php echo $cur_page;?>;
  document.mform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
  document.mform.submit();
}

function GoLastPage (){
  $("input[name=check]").attr("disabled",true);
  var total_page = <?php echo $total_page;?>;
  document.mform.cur_page.value = total_page;
  document.mform.submit();
}

function ViewBoard(seq){
  $("input[name=cur_page]").attr("disabled",true);
  $("#search1").attr("disabled",true);
  $("input[name=searchkeyword]").attr("disabled",true);
  $("input[name=searchkeyword2]").attr("disabled",true);
  document.mform.action = "<?php echo site_url();?>/tech/tech_board/request_tech_support_view";
  document.mform.seq.value = seq;
  document.mform.mode.value = "view";

  document.mform.submit();
}
</script>
<body>
  <?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
<div class="dash1-1">
  <form name="mform" action="<?php echo site_url();?>/tech/tech_board/request_tech_support_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" id ="seq" name="seq" value="">
<input type="hidden" name="mode" value="">
<input type="hidden" id="check_seq" name="check_seq" value="<?php if(isset($_GET['check_seq'])){ echo $_GET['check_seq']; } ?>"/>
<input type="hidden" id="file_change_name" name="file_change_name" value="<?php if(isset($_GET['file_change_name'])){ echo $_GET['file_change_name']; } ?>"/>
<tbody height="100%">
  <!-- 타이틀 이미지 자리요 -->
  <tr height="5%">
    <td class="dash_title">
      기술지원요청
    </td>
  </tr>
<!-- 타이틀 자리 끝이요 -->
<!-- 여기는 검색 자리요 -->
<tr height="10%">
  <td align="left" valign="bottom">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:70px;">
      <tr>
        <td>
          <select name="search1" id="search1" class="select-common select-style1" onChange="change();" style="margin-right:10px;">
          <option value="001" <?php if($search1 == "001"){ echo "selected";}?>>고객사</option>
          <option value="002" <?php if($search1 == "002"){ echo "selected";}?>>협력사</option>
          <option value="003" <?php if($search1 == "003"){ echo "selected";}?>>사업장명</option>
          <option value="004" <?php if($search1 == "004"){ echo "selected";}?>>장비명</option>
          <option value="009" <?php if($search1 == "009"){ echo "selected";}?>>serial</option>
          <option value="005" <?php if($search1 == "005"){ echo "selected";}?>>진행단계</option>
          <option value="006" <?php if($search1 == "006"){ echo "selected";}?>>최종승인</option>
          <option value="007" <?php if($search1 == "007"){ echo "selected";}?>>설치일자</option>
          <!-- <option value="009" <?php if($search1 == "009"){ echo "selected";}?>>serial</option> -->
        </select>

        <span>
        <input  type="text" size="25" class="input-common" id="searchkeyword" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>" style="margin-right:10px;"/>
        </span>
<span>
  <input  type="hidden" size="25" class="input-common" name="searchkeyword2" id="searchkeyword2" placeholder="버전명을 입력하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword2 );?>" style="margin-right:10px;" />
</span>
        <span>
          <input type="button" class="btn-common btn-style2" value="검색" onClick="return GoSearch();">
        </span>
        <!-- <span>
        <input type="text" id="tax_num" style="float:right;display:none;" class="select7">
        </span> -->
        </td>

        <!-- <td align="right">
        </td> -->
        <td align="right" style="position:relative;left:5%;">
          <?php if($tech_lv == 3){ ?>
          <input type="button" class="btn-common btn-color4" value="삭제" style="margin-right:5px;" onclick="delete_request_tech_support();" />
          <input type="button" class="btn-common btn-color7" value="품의서 작성" style="margin-right:5px;" onclick="write_approval();" />
          <input type="button" class="btn-common btn-color7" value="최종승인" style="margin-right:5px;" onclick="finalApproval();" />
          <button class="btn-common btn-style5" type="button" name="button" style="margin-right:5px;" onclick="personopen();">담당자 설정</button>
        <?php } ?>
        <?php if($tech_lv > 0) {?>
          <a href="<?php echo site_url();?>/tech/tech_board/request_tech_support_input">
            <input type="button" class="btn-common btn-color2" value="글쓰기">
          </a>
        <?php } ?>
        </td>
        <td width="5%" align="right">

        </td>

      </tr>
    </table>
  </td>
</tr>
<!-- 검색 끝이요 -->
<!-- 본문 자리요 -->
<tr height="45%">
<td valign="top" style="padding:10px 0px;">
    <table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
          <table class="list_tbl list" style="margin-top:20px;" width="100%" border="0" cellspacing="0" cellpadding="0">
            <colgroup>
              <col width="4%">
              <col width="5%">
              <col width="8%">
              <col width="8%">
              <col width="8%">
              <col width="8%">
              <col width="10%">
              <col width="10%">
              <col width="6%">
              <col width="9%">
              <col width="5%">
              <col width="5%">
              <col width="5%">
              <col width="5%">
              <col width="4%">
            </colgroup>

            <tr class="t_top row-color1">
              <th></th>
              <th height="40" align="center">NO</th>
              <th align="center">고객사</th>
              <th align="center">협력사</th>
              <th align="center">사업장명</th>
              <th align="center">장비명</th>
              <th align="center">설치요청일</th>
              <th align="center">기술지원 횟수</th>
              <th align="center">설치일</th>
              <th align="center">장비배송일</th>
              <th align="center">진행단계</th>
              <th align="center">세금계산서</th>
              <th align="center">최종승인</th>
              <th align="center">첨부</th>
              <th></th>
            </tr>
            <?php
            if ($count > 0) {
              $i = $count - $no_page_list * ( $cur_page - 1 );
              $icounter = 0;

              foreach ( $list_val as $item ) {

                if($item['file_change_name']) {
                  $strFile = "<img src='".$misc."img/add.png' width='20' height='20' />";
                } else {
                  $strFile = "-";
                }
                ?>
                <tr onMouseOver="this.style.backgroundColor='#EAEAEA'" onMouseOut="this.style.backgroundColor='#fff'">
                  <td></td>
                  <td height="40" align="center">
                    <?php if($tech_lv == 3 && ($item['approval_doc_status'] != '001' && $item['approval_doc_status'] != '002')){ ?>
                      <input type="checkbox" name="check" class="<?php if($item['final_approval']=="Y"){echo "app_Y";}else{echo "app_N";} ?>" value="<?php echo $item['seq'];?>" onchange="checkSeq(this,<?php echo $item['seq'];?>,'<?php echo $item['file_change_name'];?>')" <?php if($checkSeq <> ""){if(in_array($item['seq'],$checkSeq)){echo "checked";};} ?> />
                    <?php } ?>
                    <?php echo $i;?>
                  </td>

                  <td align="center">
                    <a class="list" href="JavaScript:ViewBoard('<?php echo $item['seq'];?>')">
                      <?php echo $item['customer_company'];?>
                    </a>
                  </td>
                  <td align="center">
                    <?php echo $item['cooperative_company'];?>
                  </td>
                  <td align="center">
                    <?php echo $item['workplace_name'];?>
                  </td>
                  <td align="center">
                    <?php echo $item['produce'];?>
                  </td>
                  <td align="center">
                    <?php if($item['installation_request_date'] != "0000-00-00"){echo $item['installation_request_date'];}else{echo "일정협의";}?>
                  </td>
                  <td align="center">
                    <?php if($item['visit_count']!='' && $item['visit_count'] != 0){echo $item['visit_count'].'회';} ?>
                  </td>
                  <td align="center">
                    <?php echo $item['installation_date'];?>
                  </td>
                  <td align="center">
                    <?php echo $item['delivery_date'];?>
                  </td>
                  <td align="center">
                    <?php echo $item['result'];?>
                  </td>
                  <td align="center" class="<?php if($item['approval_doc_status']=='001'||$item['approval_doc_status']=='002'){echo 'tax_td';} ?>" name="<?php echo 'approval_seq_'.$item['approval_seq']; ?>">
                    <?php
                    if($item['approval_doc_status']=='001') {
                      echo "결재 진행 중";
                    } else if ($item['approval_doc_status']=='002') {
                      ?>
                      <input type="button" name="" value="<?php if($item['issuance_status']=="Y"){echo '발행완료';}else{echo "미발행";} ?>" class="tax_btn" onclick="tax_modal('<?php echo $item['approval_seq']; ?>');">
                      <?php
                    }
                    ?>
                  </td>
                  <td align="center">
                    <?php if($item['final_approval'] =='N'){echo "미승인";}else{echo "승인";} ?>
                  </td>
                  <td align="center">
                    <?php echo $strFile; ?>
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
                <td width="100%" height="40" align="center" colspan="14">등록된 게시물이 없습니다.</td>
              </tr>
              <?php
            }
            ?>
          </table>
        </td>
      </tr>
    </table>
</td>
</tr>

<!-- 본문 끝이요 -->
<!-- 페이징 들어갈 자리요 -->
<tr height="40%">
  <td align="left" valign="top">
    <table width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td width="19%">

        <tr height="20%">
          <td align="center" valign="top">
<?php if ($count > 0) {?>
<table width="400" border="0" cellspacing="0" cellpadding="0">
    <tr>
<?php
if ($cur_page > 10){
?>
      <td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last_left.svg" width="20" height="20"/></a></td>
      <td width="2"></td>
      <td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_left.svg" width="20" height="20"/></a></td>
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
?></td>
      <?php
if   ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
?>
<!-- <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/page_next.png" width="20" height="20"/></a></td> -->
      <td width="2"></td>
      <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.svg" width="20" height="20"/></a></td>
      <td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last_right.svg" width="20" height="20"/></a></td>
<?php
} else {
?>
<td width="19"></td>
      <td width="2"></td>
      <td width="19"></td>
<?php
}
?>


</tr>
</table>
<?php }?>
</td>
</tr>
</td>
</tr>
</table>
</td>
</tr>
<!-- 페이징 끝이오 -->

</tbody>
</table>
</form>
</div>
</div>

<!-- 창 -->
<div id="person_div" style="height:30%;width:30%;background-color:#ffffff; border-radius:2em;display:none;">

    <div class="person_item" style="font-size:24px;font-weight:bold;">
     담당자 설정
     <input type="hidden" name="person_seq" id="person_seq" value="<?php echo $responsibility->seq ?>">
    </div>
    <div class="person_item" style="font-size:18px; color:#a19d9d;font-weight:bold;">
			<form method="post" id="qform">
      담당자1
      <select class="select-common" name="person1" id="person1">
        <option value="">선택하세요</option>
        <?php
        $select_seq = $responsibility->person1;
        foreach ($durian_engineer as $eng){
          $selected = $select_seq == $eng['seq'] ? " selected" : "";
          echo "<option value='{$eng['seq']}'{$selected}>{$eng['user_name']}</option>";
       }
       ?>
      </select><br>
      담당자2
      <select class="select-common" name="person2" id="person2">
        <option value="">선택하세요</option>
        <?php
        $select_seq = $responsibility->person2;
        foreach ($durian_engineer as $eng){
          $selected = $select_seq == $eng['seq'] ? " selected" : "";
          echo "<option value='{$eng['seq']}'{$selected}>{$eng['user_name']}</option>";
       }
       ?>
      </select>
		</form>
    </div>
    <div class="person_item">
			<!-- <label for="copy_submit"> -->
      <button type="button" name="button" class="btn-common btn-color2" style="width:70px" onclick="change_person();">확인</button>
		<!-- </label> -->
      <button type="button" name="button" class="btn-common btn-color2" style="background-color:#FF6666;width:70px" onclick="$('#person_div').bPopup().close();">취소</button>
    </div>
</div>

<!-- 세금계산서 입력창 -->
<div id="tax_div" style="height:30%;width:70%;background-color:#ffffff; border-radius:1em;display:none;">
  <table style="width:90%;margin-left: auto; margin-right: auto;">
    <colgroup>
      <col width="8%" />
      <col width="10%" />
      <col width="10%" />
      <col width="10%" />
      <col width="20%" />
      <col width="10%" />
      <col width="8%" />
      <col width="8%" />
      <col width="8%" />
      <col width="8%" />
    </colgroup>
    <thead>
      <tr>
        <th height="40" class="basic_td apply-filter no-sort" filter_column="3" align="center" bgcolor="f8f8f9" style="font-weight:bold;"><input type="hidden" class="filter_n" value="all">발행예정일</th>
        <th height="40" class="basic_td apply-filter no-sort" filter_column="4" align="center" bgcolor="f8f8f9" style="font-weight:bold;"><input type="hidden" class="filter_n" value="all">발행금액</th>
        <th height="40" class="basic_td apply-filter no-sort" filter_column="5" align="center" bgcolor="f8f8f9" style="font-weight:bold;"><input type="hidden" class="filter_n" value="all">세액</th>
        <th height="40" class="basic_td apply-filter no-sort" filter_column="6" align="center" bgcolor="f8f8f9" style="font-weight:bold;"><input type="hidden" class="filter_n" value="all">합계</th>
        <th height="40" class="basic_td apply-filter no-sort" filter_column="7" align="center" bgcolor="f8f8f9" style="font-weight:bold;"><input type="hidden" class="filter_n" value="all">국세청 승인번호</th>
        <th height="40" class="basic_td apply-filter no-sort" filter_column="8" align="center" bgcolor="f8f8f9" style="font-weight:bold;"><input type="hidden" class="filter_n" value="all">발행월</th>
        <th height="40" class="basic_td apply-filter no-sort" filter_column="9" align="center" bgcolor="f8f8f9" style="font-weight:bold;"><input type="hidden" class="filter_n" value="all">발행일자</th>
        <th height="40" class="basic_td apply-filter no-sort" filter_column="10" align="center" bgcolor="f8f8f9" style="font-weight:bold;"><input type="hidden" class="filter_n" value="all">발행여부</th>
        <th height="40" class="basic_td apply-filter no-sort" filter_column="11" align="center" bgcolor="f8f8f9" style="font-weight:bold;"><input type="hidden" class="filter_n" value="all">입금일자</th>
        <th height="40" class="basic_td apply-filter no-sort" filter_column="12" align="center" bgcolor="f8f8f9" style="font-weight:bold;"><input type="hidden" class="filter_n" value="all">입금여부</th>
        <!-- <th height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">
        <img src="<?php echo $misc; ?>img/btn_add.jpg" class="drop" onclick="addRow('sales_issuance_amount_insert_line','sales_contract_total_amount',0);" />
      </th> -->
      </tr>
    </thead>
    <tbody>
      <tr>
        <input type="hidden" id="bill_seq" name="bill_seq" class="input7" value="" />
        <input type="hidden" id="annual_doc_seq" name="annual_doc_seq" class="input7" value="" />
        <input type="hidden" id="issuance_status" name="issuance_status" class="input7" value="N" />
        <input type="hidden" id="deposit_status" name="deposit_status" class="input7" value="N" />
        <td>
          <input type="date" class="input7" id="issue_schedule_date" name="issue_schedule_date" value="" style="text-align:right;">
        </td><!-- 발행예정일 -->
        <td>
          <input type="text" class="input7" id="issuance_amount" name="issuance_amount" value="" style="text-align:right;" onchange="numberFormat(this);" readonly>
        </td><!-- 발행금액 -->
        <td>
          <input type="text" class="input7" id="tax_amount" name="tax_amount" value="" style="text-align:right;" onchange="numberFormat(this);" readonly>
        </td><!-- 세액 -->
        <td>
          <input type="text" class="input7" id="total_amount" name="total_amount" value="" style="text-align:right;" onchange="numberFormat(this);" readonly>
        </td><!-- 합계 -->
        <td>
          <input type="text" class="input7" id="tax_approval_number" name="tax_approval_number" value="" onchange="taxApprovalNumer(this);">
          <span type="text" id="tax_approval_number_span" name="tax_approval_number_sapn" value=""></span>
        </td><!-- 국세청승인번호 -->
        <td>
          <input type="text" class="input7" id="issuance_month" name="issuance_month" value="" readonly>
        </td><!-- 발행월 -->
        <td>
          <input type="date" class="input7" id="issuance_date" name="issuance_date" value="" onchange="issuance_date_change(this);" readonly>
        </td><!-- 발행일자 -->
        <td>
          <span id="issuance_YN" name="issuance_YN">미완료</span>
        </td><!-- 발행여부 -->
        <td>
          <input type="date" class="input7" id="deposit_date" name="deposit_date" value="" onchange="deposit_date_change(this);">
        </td><!-- 입금일자 -->
        <td>
          <span id="deposit_YN" name="deposit_YN">미완료</span>
        </td><!-- 입금여부 -->
      </tr>
    </tbody>
  </table>
  <div align="center" style="margin-top:10px;">
    <input type="image" src="<?php echo $misc; ?>img/btn_adjust.jpg" width="64" height="31" style="cursor:pointer" onclick="save_request_support_bill();" />
    <input type="image" src="<?php echo $misc; ?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer" onclick="$('#tax_div').bPopup().close();" />
  </div>
</div>
<script>
function personopen(){
	$("#person_div").bPopup({
		speed: 450,
		transition: 'slideDown'
	})
}

function change_person(){
  $.ajax({
    type: "POST",
    cache: false,
    url: "<?php echo site_url(); ?>/tech/tech_board/change_function",
    dataType: "json",
    async: false,
    data: {
      seq: $("#person_seq").val(),
      person1:$("#person1").val(),
      person2:$("#person2").val()
    },
    success: function (data) {
      console.log(data);
      if(data == '실패'){
        alert("저장하지 못했습니다. 다시 처리해 주시기 바랍니다.");
      }else{
        alert("저장하였습니다.");
        $("#person_div").bPopup().close();
      }
    }
  });
}

  function checkSeq(obj,seq,filename){
    if($(obj).is(":checked")==true){
      $(obj).closest('tr').attr('onMouseOver', "");
      $(obj).closest('tr').attr('onMouseOut', "");
      $(obj).closest('tr').css('backgroundColor','#EAEAEA');
      if($("#check_seq").val() == ""){
        $("#check_seq").val($("#check_seq").val()+seq);
        $("#file_change_name").val($("#file_change_name").val()+filename);
      }else{
        $("#check_seq").val($("#check_seq").val()+","+seq);
        $("#file_change_name").val($("#file_change_name").val()+","+filename);
      }
    }else{
      $(obj).closest('tr').attr('onMouseOver', "this.style.backgroundColor='#EAEAEA'");
      $(obj).closest('tr').attr('onMouseOut', "this.style.backgroundColor='#fff'");
      $(obj).closest('tr').css('backgroundColor','#fff');
      if($("#check_seq").val().indexOf(","+seq) != -1) {
        $("#check_seq").val($("#check_seq").val().replace(","+seq,''));
        $("#file_change_name").val($("#file_change_name").val().replace(","+filename,''));
      }else if($("#check_seq").val().indexOf(seq+",") != -1){
        $("#check_seq").val($("#check_seq").val().replace(seq+",",''));
        $("#file_change_name").val($("#file_change_name").val().replace(filename+",",''));
      }else{
        $("#check_seq").val($("#check_seq").val().replace(seq,''));
        $("#file_change_name").val($("#file_change_name").val().replace(filename,''));
      }
    }
  }

  function finalApproval(){
    var result = confirm("최종승인 하시겠습니까?");
    if(result){
      $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url(); ?>/tech/tech_board/finalApproval",
        dataType: "json",
        async: false,
        data: {
          seq: $("#check_seq").val()
        },
        success: function (data) {
          if(data){
            alert('승인완료');
            location.href = "<?php echo site_url(); ?>/tech/tech_board/request_tech_support_final_approval_mail?seq="+$("#check_seq").val();
          }else{
            alert('승인오류');
          }
        }
      });
    }else{
      location.href = "<?php echo site_url(); ?>/tech/tech_board/request_tech_support_list";
    }
  }

  function tax(){
    if($("#check_seq").val() == ''){
      alert("승인번호를 입력 할 게시물을 선택해주세요.");
    }else{
      var result = confirm("세금계산서 승인번호를 저장하시겠습니까?");
      if(result){
        $.ajax({
          type: "POST",
          cache: false,
          url: "<?php echo site_url(); ?>/tech/tech_board/taxNumber",
          dataType: "json",
          async: false,
          data: {
            seq: $("#check_seq").val(),
            tax: $("#tax_num").val()
          },
          success: function (data) {
            if(data){
              alert('세금계산서 승인번호 저장');
              location.href = "<?php echo site_url(); ?>/tech/tech_board/request_tech_support_list";
            }else{
              alert('세금계산서 승인번호 저장오류');
            }
          }
        });
      }else{
        location.href = "<?php echo site_url(); ?>/tech/tech_board/request_tech_support_list";
      }
    }
  }

  function changeBtn(obj){
    $(obj).hide();
    $("#tax_num").show();
    $("#taxBtn").show();
  }

  function delete_request_tech_support(){
    if (confirm("정말 삭제하시겠습니까?") == true){
        var mform = document.cform;
        location.href = "<?php echo site_url();?>/tech/tech_board/request_tech_support_delete_action?seq="+$("#check_seq").val()+"&file_change_name="+$("#file_change_name").val();
        // mform.submit();
        // return false;
    }
  }

  function write_approval() {
    var req_seq = '';
    var count = 0;
    var app_yn = '';
    $("input:checkbox[name=check]").each(function() {
      if ($(this).is(":checked")==true) {
        if ($(this).attr('class')=="app_N"){
          alert('최종 승인되지 않은 리스트는 품의서 작성이 불가능 합니다.');
          // $("input:checkbox[name=check]").prop("checked", false);
          app_yn = "n";
          return false;
        }
        req_seq += $(this).val()+'_';
        count ++;
      }
    });
    if (req_seq == '' && app_yn != 'n') {
      alert('품의서 작성을 할 항목을 선택하세요');
    } else if (req_seq != '' && app_yn != 'n') {
      if (confirm(count + '건이 선택되었습니다.\n품의서 작성 하시겠습니까?')) {
        location.href = "<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_input?seq=46&req_support_seq="+req_seq;
      }
    }

  }

  $(".first").each(function() {
  var rows = $(".first:contains('" + $(this).text() + "')");
  if (rows.length > 1) {
    rows.eq(0).attr("rowspan", rows.length);
    rows.not(":eq(0)").remove();
  }
});

  $(function(){
    $(".tax_td").each(function() {
      var rows = $('.tax_td[name='+ $(this).attr('name') +']');
      if (rows.length > 1) {
        rows.eq(0).attr('rowspan', rows.length);
        rows.not(':eq(0)').remove();
      }
    });
    $(".tax_btn").each(function() {
      $(this).closest('td').css('backgroundColor', '#eceaea');
    })
  })

  function tax_modal(annual_seq) {
    $.ajax({
      type: "POST",
      cache: false,
      url: "<?php echo site_url(); ?>/tech/tech_board/annual_bill_data",
      dataType: "json",
      async: false,
      data: {
        seq: annual_seq
      },
      success: function (result) {
        console.log(result.result.req_support_data);
        if(result.cnt == 0) {
          var req_support_data = result.result.req_support_data;
          data_arr = req_support_data.split("*/*");
          $("#tax_div input[name=bill_seq]").val("");
          $("#tax_div input[name=annual_doc_seq]").val(annual_seq);
          $("#tax_div input[name=issuance_status]").val("N");
          $("#tax_div input[name=deposit_status]").val("N");
          $("#tax_div input[name=issue_schedule_date]").val("");
          $("#tax_div input[name=issuance_amount]").val(data_arr[0]);
          $("#tax_div input[name=tax_amount]").val(data_arr[1]);
          $("#tax_div input[name=total_amount]").val(data_arr[2]);
          $("#tax_div input[name=tax_approval_number]").val('');
          $("#tax_div input[name=issuance_month]").val('');
          $("#tax_div input[name=issuance_date]").val('');
          $("#tax_div input[name=deposit_date]").val('');
          $("#issuance_YN").text('미완료');
          $("#deposit_YN").text('미완료');
          $("#tax_approval_number").show();
          $("#tax_approval_number_span").hide();
        } else {
          var data = result.result;
          $("#tax_div input[name=bill_seq]").val(data.seq);
          $("#tax_div input[name=annual_doc_seq]").val(data.annual_doc_seq);
          $("#tax_div input[name=issuance_status]").val(data.issuance_status);
          $("#tax_div input[name=deposit_status]").val(data.deposit_status);
          $("#tax_div input[name=issue_schedule_date]").val(data.issue_schedule_date);
          $("#tax_div input[name=issuance_amount]").val(commaStr(data.issuance_amount));
          $("#tax_div input[name=tax_amount]").val(commaStr(data.tax_amount));
          $("#tax_div input[name=total_amount]").val(commaStr(data.total_amount));
          $("#tax_div input[name=tax_approval_number]").val(data.tax_approval_number);
          $("#tax_approval_number_span").text(data.tax_approval_number);
          $("#tax_div input[name=issuance_month]").val(data.issuance_month);
          $("#tax_div input[name=issuance_date]").val(data.issuance_date);
          $("#tax_div input[name=deposit_date]").val(data.deposit_date);
          if (data.issuance_status == "Y") {
            $("#issuance_YN").text('완료');
            $("#tax_approval_number").hide();
            $("#tax_approval_number_span").show();
          } else {
            $("#issuance_YN").text('미완료');
            $("#tax_approval_number").show();
            $("#tax_approval_number_span").hide();
          }
          if (data.deposit_status == "Y") {
            $("#deposit_YN").text('완료');
          } else if (data.deposit_status == 'L') {
            $('#deposit_YN').text('부족');
          } else if (data.deposit_status == 'O') {
            $('#deposit_YN').text('과잉');
          } else {
            $("#deposit_YN").text('미완료');
          }
        }
        $("#tax_div").bPopup({
          speed: 450,
          transition: 'slideDown'
        })
      }
    });

    // $("#tax_div").bPopup({
  	// 	speed: 450,
  	// 	transition: 'slideDown'
  	// })
  }

  // 금액 부분 콤마 추가
  function commaStr(n) {
    var reg = /(^[+-]?\d+)(\d{3})/;
    n += "";

    while (reg.test(n))
      n = n.replace(reg, "$1" + "," + "$2");
    return n;
  }

  //금액 천단위 마다 ,
  function numberFormat(obj) {
  	if (obj.value == "") {
  		obj.value = 0;
  	}
  	var inputText = obj.value.replace(/[^-?0-9]/gi,"") // 숫자와 - 가능
  	var inputNumber = inputText.replace(/,/g, "");
  	var fomatnputNumber = inputNumber.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
  	obj.value = fomatnputNumber;
  }

  //국세청 승인번호
  function taxApprovalNumer(obj){
  	$(obj).val($(obj).val().replace(/ /gi, "")); //공백제거
  	if($(obj).val().length > 26 || $(obj).val().length < 26){
  		alert("국세청 승인번호는 26자리로 입력하셔야합니다.");
  		$(obj).val("");

			$("#issuance_date").val("");
			$("#issuance_month").val("");
			$("#issuance_status").val("N");
			$("#issuance_YN").text("미완료");

  		return false;
  	}
  	var date = $(obj).val().split("-")[0];
  	date = date.replace(/(\d{4})(\d{2})(\d{2})/, '$1-$2-$3');

		$("#issuance_date").val(date);
		$("#issuance_date").change();
		if($(obj).val() == ""){//국세청 승인번호 빈칸일때
			$("#issuance_status").val("N");
			$("#issuance_YN").text("미완료");
		}

  }

  //발행일자 change
  function issuance_date_change(obj) {
		var val = $(obj).val();
		val = val.substring(0, val.length - 3);
		$('#issuance_month').val(val);
		if($("#issuance_status").val() != "C" && $("#issuance_status").val() != "M" ){
			$("#issuance_status").val("Y");
			$("#issuance_YN").text("완료");
		}
  }

  //입금일자 change
  function deposit_date_change(obj) {
		$("#deposit_status").val("Y");
		$("#deposit_YN").text("완료");
  }

  function save_request_support_bill() {

    $.ajax({
      type: "POST",
      cache: false,
      url: "<?php echo site_url(); ?>/tech/tech_board/save_request_support_bill",
      dataType: "json",
      async: false,
      data: {
        bill_seq : $("#bill_seq").val(),
        annual_doc_seq : $("#annual_doc_seq").val(),
        issuance_status : $("#issuance_status").val(),
        deposit_status : $("#deposit_status").val(),
        issue_schedule_date : $("#issue_schedule_date").val(),
        issuance_amount : $("#issuance_amount").val(),
        tax_amount : $("#tax_amount").val(),
        total_amount : $("#total_amount").val(),
        tax_approval_number : $("#tax_approval_number").val(),
        issuance_month : $("#issuance_month").val(),
        issuance_date : $("#issuance_date").val(),
        deposit_date : $("#deposit_date").val()
      },
      success: function(result) {
        if(result) {
          alert('저장되었습니다.');
          location.href = "<?php echo site_url(); ?>/tech/tech_board/request_tech_support_list";
        }
      }
    })
  }
</script>
<?php
 include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php";
?>
</body>
</html>
