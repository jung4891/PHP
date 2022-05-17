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

 	document.mform.action = "<?php echo site_url();?>/admin/alias/alias_list";
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
    <span style="font-size:20px;font-weight:bold;">그룹메일 리스트</span>
  </div>
  <form name="mform" action="<?php echo site_url(); ?>/admin/alias/alias_list" method="get">
  <div class="" style="height:80%;">
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
    <div class="" style="overflow-y:scroll;max-height:50vh;min-height:300px;">
      <table class="contents_tbl"  border="0" cellspacing="0" cellpadding="0">
        <colgroup>
          <col width="30%">
          <col width="30%">
          <col width="10%">
          <col width="20%">
          <col width="5%">
          <col width="5%">
          <!-- <col width="10%">
          <col width="10%"> -->
        </colgroup>
        <tr>
          <th>그룹메일계정</th>
          <th>대상</th>
          <!-- <th>이름</th> -->
          <!-- <th>용량</th> -->
          <th>활성화</th>
          <th>최종수정일</th>
          <th colspan="2"></th>
        </tr>
<?php
if ($count > 0) {
  $i = $count - $no_page_list * ( $cur_page - 1 );
  $icounter = 0;
foreach ($alias_list as $al) {

  if($al->active == 1){
    $active = "O";
  }else{
    $active = "X";
  }

  $goto_list = str_replace(",", "<br>", $al->goto);
?>

<tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style="">
  <td align="center" height="100"><?php echo $al->address; ?></td>
  <td name="gotolist" align="center" height="100" title="<?php echo $goto_list; ?>">
    <div class="" style="height:100%;">
      <?php echo $goto_list; ?>

    </div>
  </td>
  <!-- <td align="center"><?php echo $al->domain; ?></td> -->
  <td align="center"><?php echo $active; ?></td>
  <td align="center"><?php echo $al->modified; ?></td>
  <td align="center">
    <input type="button" class="admin_btn white_btn" style="width:80%;" name="button" onclick="alias_modify('<?php echo $al->address; ?>', 'update');" value="수정">
  </td>
  <td align="center" style="border-left:unset;">
    <input type="button" class="admin_btn grey_btn" name="button" style="width:80%;" onclick="alias_modify('<?php echo $al->address; ?>', 'del');" value="삭제">
  </td>
</tr>

<?php
$i--;
$icounter++;
  }
}else{
?>
  <tr>
   <td width="100%" height="40" align="center" colspan="6">등록된 게시물이 없습니다.</td>
  </tr>
<?php } ?>
      </table>
    </div>

    <div class="paging_div" style="margin-top:30px;">
      <?php if ($count > 0) {?>
        <table width="400" border="0" cellspacing="0" cellpadding="0">
            <tr>
        <?php
        if ($cur_page > 10){
        ?>
              <td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_first.png" width="20" height="20"/></a></td>
              <td width="2"></td>
              <td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_left.png" width="20" height="20"/></a></td>
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
        <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.png" width="20" height="20"/></a></td>
              <td width="2"></td>
              <td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last.png" width="20" height="20"/></a></td>
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
    <div class="sub_div" style="margin-top:20px;" align="center">
      <table style="width:100%;" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="right">
            <input type="button" style="width:70px;height:40px;" class="admin_btn blue_btn" name="button" onclick="mailbox_add();" value="등록">

          </td>
        </tr>
    </table>
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
