<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script language="javascript">
function GoSearch(){
  var searchkeyword = document.mform.searchkeyword.value;
  var searchkeyword = searchkeyword.trim();

//  if(searchkeyword == ""){
//    alert( "검색어를 입력해 주세요." );
//    return false;
//  }

  document.mform.action = "<?php echo site_url();?>/tech/tech_board/tech_device_list";
  document.mform.cur_page.value = "";
//  document.mform.search_keyword.value = searchkeyword;
  document.mform.submit();
}

//$(document).ready(function() {
//   $('li > ul').show();
//});
</script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
<div class="dash1-1">
<form name="mform" action="<?php echo site_url();?>/tech/tech_board/tech_device_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">
<tbody height="100%">
<!-- 타이틀 이미지 자리요 -->
<tr height="5%">
  <td class="dash_title">
    장비/시스템
  </td>
</tr>
<!-- 타이틀 자리 끝이요 -->
<!-- 여기는 검색 자리요 -->
<tr height="10%">
<td align="left" valign="bottom">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:70px;">
    <tr>
      <td>
        <select name="search1" id="search1" class="select-common select-style1" style="margin-right:10px;">
        <option value="002" <?php if($search1 == "002"){ echo "selected";}?>>고객사</option>
        <option value="001" <?php if($search1 == "001"){ echo "selected";}?>>장비/시스템명</option>
        <option value="003" <?php if($search1 == "003"){ echo "selected";}?>>S/N</option>
      </select>
      <span>
      <input  type="text" size="25" class="input-common" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
      </span>
      <!-- </td>
      <td> -->
      <span>
        <input type="button" class="btn-common btn-style2" value="검색" onClick="return GoSearch();">
      </span>
      </td>
      <td align="right">
        <span>
          <input type="button" class="btn-common btn-style4" value="제품별 점검항목 보기" style="margin-right:10px;width:150px;" onclick="productCheckList();"/>
          <input type="button" class="btn-common btn-color6" value="제품별 점검항목 추가" style="width:150px;" onclick="productCheckListInput();" />
        </span>
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
            <col width="7%">
            <col width="10%">
            <col width="20%">
            <col width="12%">
            <col width="8%">
            <col width="12%">
            <col width="8%">
            <col width="8%">
            <col width="8%">
            <col width="7%">
          </colgroup>

          <tr class="t_top row-color1">
            <th></th>
            <th height="40" align="center">NO</th>
            <th align="center">고객사 (프로젝트)</th>
            <th align="center">제품명</th>
            <th align="center">버전</th>
            <th align="center">Serial</th>
            <th align="center">host</th>
            <th align="center">제품상태</th>
            <th align="center">점검항목 리스트</th>
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
                  <a class="list" href="JavaScript:ViewBoard('<?php echo $item['seq'];?>')">
                    <?php echo $item['customer_companyname'];?> (<?php echo $item['project_name']; ?>)
                  </a>
                </td>
                <td align="center">
                  <?php echo $item['product_name'];?>
                </td>
                <td align="center">
                  <?php echo $item['product_version'];?>
                </td>
                <td align="center"><?php echo $item['product_serial'];?></td>
                <td align="center"><?php echo $item['product_host'];?></td>
                <td align="center">
                  <?php if($item['product_state'] == "0") { echo "미입력상태"; }
                  else if($item['product_state'] == "001") { echo "입고 전"; }
                  else if($item['product_state'] == "002") { echo "창고"; }
                  else if($item['product_state'] == "003") { echo "고객사 출고"; }
                  else if($item['product_state'] == "004") { echo "장애 반납"; }
                  ?>
                </td>
                <td align="center">
                  <?php
                  foreach($check_list as $check_item){
                    if( $item['product_check_list'] == $check_item['seq'] ){
                      echo $check_item['product_name'];
                    }
                  }
                  ?>
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
              <td width="100%" height="40" align="center" colspan="10">등록된 게시물이 없습니다.</td>
            </tr>
            <tr>

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
  document.mform.action = "<?php echo site_url();?>/tech/tech_board/tech_device_view";
  document.mform.seq.value = seq;
  document.mform.mode.value = "view";

  document.mform.submit();
}
</script>
<script>
  function productCheckListInput(){
    window.open('/index.php/tech/tech_board/product_check_list_input');
  }
  function productCheckList(){
    window.open('/index.php/tech/tech_board/product_check_list');
  }
  function coverUpload(){
    window.open('/index.php/tech/tech_board/cover_upload');
  }
</script>
<?php
 include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php";
?>
</body>
</html>
