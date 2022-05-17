<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/admin_side.php";
 ?>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/style.css" type="text/css" charset="utf-8"/>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/admin.css" type="text/css" charset="utf-8"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/poshytip/1.2/tip-darkgray/tip-darkgray.min.css" type="text/css" charset="utf-8"/>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/poshytip/1.2/jquery.poshytip.min.js"></script>
 <script language="javascript">
 function GoSearch(){
   var searchkeyword = document.mform.searchkeyword.value;
   var searchkeyword = searchkeyword.trim();
   var searchdomain = document.mform.searchdomain.value;
   var searchdomain = searchdomain.trim();

 	// if (searchkeyword.replace(/,/g, "") == "") {
 	// 	 alert("검색어가 없습니다.");
 	// 	 location.href="<?php echo site_url();?>/admin/alias/alias_list";
 	// 	 return false;
 	// }

 	document.mform.action = "<?php echo site_url();?>/admin/main/viewlog";
 	document.mform.cur_page.value = "";
 	document.mform.submit();
 }

 function GoFirstPage (){
 	document.mform.cur_page.value = 1;
 	document.mform.submit();
 }

 function GoPrevPage (){
 	var	cur_start_page = <?php echo $cur_page;?>;

 	document.mform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
 	document.mform.submit( );
 }

 function GoPage(nPage){
 	document.mform.cur_page.value = nPage;
 	document.mform.submit();
 }

 function GoNextPage (){
 	var	cur_start_page = <?php echo $cur_page;?>;

 	document.mform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
 	document.mform.submit();
 }

 function GoLastPage (){
 	var	total_page = <?php echo $total_page;?>;
 //	alert(total_page);

 	document.mform.cur_page.value = total_page;
 	document.mform.submit();
 }


 </script>

<div id="main_contents" align="center">
  <div class="sub_div" align="left" style="">
    <span style="font-size:20px;font-weight:bold;">로그</span>
  </div>
  <form name="mform" action="<?php echo site_url(); ?>/admin/main/viewlog" method="get">
  <div class="main_div">
    <div id="search_div" align="left" style="width:95%;">
      <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
      <select class="select_basic" name="searchdomain">
          <option value="">전체</option>
<?php foreach ($domain_list as $dl) {
$selected = $search_domain == $dl->domain ? "selected" : "" ;
?>

          <option value="<?php echo $dl->domain; ?>" <?php echo $selected; ?>><?php echo $dl->domain; ?></option>
<?php } ?>
      </select>


			  <input  type="text" size="25" class="input_basic input_search" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
			  <input type="button" class="btn_basic btn_gray" style="height:30px;width:50px;" value="검색" onClick="return GoSearch();">
    </div>
    <div class="" style="overflow-y:scroll;max-height:50vh;min-height:400px;">
      <table class="contents_tbl"  border="0" cellspacing="0" cellpadding="0" style="table-layout: fixed">
        <colgroup>
          <col width="20%">
          <col width="20%">
          <col width="20%">
          <col width="10%">
          <col width="30%">
        </colgroup>
        <tr>
          <th>시간</th>
          <th>관리자</th>
          <th>도메인</th>
          <th>Action</th>
          <th>Data</th>
        </tr>
<?php
if ($count > 0) {
  $i = $count - $no_page_list * ( $cur_page - 1 );
  $icounter = 0;
foreach ($log_list as $ll) {
?>

<tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style="" onclick="showdata(this);">
  <td align="center" height="100"><?php echo $ll->timestamp; ?></td>
  <td align="center" height="100"><?php echo $ll->username; ?></td>
  <td align="center"><?php echo $ll->domain; ?></td>
  <td align="center"><?php echo $ll->action; ?></td>
  <td name="data_td" align="center" height="100" title="<?php echo $ll->data; ?>" style="overflow:hidden;text-overflow: ellipsis;">
      <?php echo $ll->data; ?>
  </td>
</tr>

<?php
$i--;
$icounter++;
  }
}else{
?>
  <tr>
   <td width="100%" height="40" align="center" colspan="5">등록된 게시물이 없습니다.</td>
  </tr>
<?php } ?>
      </table>
    </div>

    <div class="paging_div" style="margin-top:10px;">
      <?php if ($count > 0) {?>
        <table width="400" border="0" cellspacing="0" cellpadding="0">
            <tr>
        <?php
        if ($cur_page > 10){
        ?>
              <td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/btn/btn_first.png" width="20" height="20"/></a></td>
              <td width="2"></td>
              <td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/btn/btn_left.png" width="20" height="20"/></a></td>
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
        }

        if  ( $i == $cur_page ) {
          echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\"><font color=\"#6C6C6C\">".$i."</font></a>".$strSection;
        } else {
          echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\"><font color=\"#B0B0B0\">".$i."</font></a>".$strSection;
        }
        }
        ?></td>
              <?php
        if   ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
        ?>
        <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/btn/btn_right.png" width="20" height="20"/></a></td>
              <td width="2"></td>
              <td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/btn/btn_last.png" width="20" height="20"/></a></td>
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
    </div>
  </div>
  </form>
</div>
<form id="modify_form" name="modify_form" action="<?php echo site_url();?>/admin/alias/alias_add" method="get">
  <input type="hidden" id="modify_id" name="modify_id" value="">
  <input type="hidden" id="input_mode" name="input_mode" value="modify">
  <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
</form>
<script type="text/javascript">
  function showdata(ths){
    var datatext = $(ths).find("td[name='data_td']").attr('title');
    var datatext = datatext.trim();
    alert(datatext);
  }
 function mailbox_add(){
   location.href = "<?php echo site_url(); ?>/admin/alias/alias_add";
 }

 function alias_modify(id, mode){
   if(mode == "del"){
     var con_test = confirm("정말 삭제하시겠습니까?");
     if(con_test == true){
       location.href="<?php echo site_url(); ?>/admin/alias/del_alias?id="+id;
     }
   }else{
     $("#modify_id").val(id);
     $("#modify_form").submit();
   }
 }

// $("td[name='gotolist']").on("mouseover", function () {
//   var title = $(this).attr('title');
//   console.log(title);
//   $(this).poshytip({
//
//   });
// })
$("td[name='gotolist']").poshytip({
  className: 'tip-darkgray',
	bgImageFrameSize: 11,
	offsetX: -25
  });
</script>

<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>
