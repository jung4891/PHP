<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
?>
<script language="javascript">
  function GoSearch(){
   var searchkeyword = document.mform.searchkeyword.value;
   var searchkeyword = searchkeyword.trim();
   
//	if(searchkeyword == ""){
//		alert( "검색어를 입력해 주세요." );
//		return false;
//	}

document.mform.action = "<?php echo site_url();?>/board/qna_list";
document.mform.cur_page.value = "";
//	document.mform.search_keyword.value = searchkeyword;
document.mform.submit();
}

//$(document).ready(function() {
//   $('li > ul').show();
//});
</script>
<body>
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <form name="mform" action="<?php echo site_url();?>/board/qna_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
      <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
      <input type="hidden" name="seq" value="">
      <input type="hidden" name="mode" value="">
      <?php
        include $this->input->server('DOCUMENT_ROOT')."/include/tech_header.php";
      ?>
		<tr style="height: 0px;">
		 <td width="197" valign="top" style="background-color: #666666">
              
             <div id='cssmenu'>
              <ul>
               <li style="float: left;"><a href='<?php echo site_url();?>/board/notice_list'><span>공지사항</span></a></li>
				<li style="float: left;"><a href='<?php echo site_url();?>/board/eduevent_list'><span>교육 &amp; 행사</span></a></li>
               <li class='has-sub' style="float: left;"><a href='<?php echo site_url();?>/board/manual_list'><span>제조사</span></a>
                <ul>
                 <li style="float: left;"><a href='<?php echo site_url();?>/board/manual_list'><span>자료실</span></a>
                 </li>
			     <li style="float: left;"><a href='<?php echo site_url();?>/board/faq_list'><span>FAQ</span></a></li>
                 <li style="float: left;"><a href='<?php echo site_url();?>/board/edudata_list'><span>교육자료</span></a>
				 <li style="float: left;"><a href='<?php echo site_url();?>/board/release_note_list'>릴리즈노트</span></a></li>
				 <li style="float: left;"><a href='<?php echo site_url();?>/tech_board/tech_device_list'><span>장비/시스템 등록</span></a></li>
                 </li>
               </ul>
             </li>
           
<!--             <li><a href='<?php echo site_url();?>/board/qna_list'><span>QnA</span></a></li>-->
            
             <!-- 김수성 추가 2017-02-01 -->
	  		 <li class='has-sub' style="float: left;"><a href='<?php echo site_url();?>/maintain/maintain_list'><span>고객사</span></a>
	 		 <ul>
             <?php if( $this->company == 2118872631 ) {?>
	  		<li style="float: left;"><a href='<?php echo site_url();?>/maintain/maintain_list'><span>유지보수</span></a></li>
          	 <li style="float: left;"><a href='<?php echo site_url();?>/board/network_map_list'>구성도</span></a></li>
             <?php } ?><!-- 김수성 끝 나중에 다 고쳐야됨 -->
 			<li style="float: left;"><a href='<?php echo site_url();?>/tech_board/tech_doc_list'><span>기술지원보고서</span></a></li>
			</ul>
			<li style="float: left;"><a href='<?php echo site_url();?>/durian_car/car_drive_list'>차량운행일지</span></a></li>
             <li class='last' style="float: left;"><a href='<?php echo site_url();?>/board/suggest_list'><span>건의사항</span></a></li>
			<li class='last' style="float: left;"><a href='<?php echo site_url();?>/board/qua_list'><span class="point">QnA</span></a></li>
           </ul>
		</li>
         </div>
       </td>
	</tr>
  <tr>
    <td align="center" valign="top">
      
      <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
          
     <td width="923" align="center" valign="top">
      
      
      <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
        <tr>
          <td class="title3">QnA</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="48%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>
                <select name="search1" id="search1" class="input">
                  <option value="000">제조사별</option>
                  <?php
                  foreach ($category  as $val) {
                    echo '<option value="'.$val['code'].'"';
                    if( $search1 && ( $val['code'] == $search1 ) ) {
                     echo ' selected';
                   }
                   
                   echo '>'.$val['code_name'].'</option>';
                 }
                 ?>
               </select>
             </td>
             <td>
              <select name="search2" id="search2" class="input">
                <option value="001" <?php if($search2 == "001"){ echo "selected";}?>>제목</option>
                <option value="002" <?php if($search2 == "002"){ echo "selected";}?>>등록자</option>
              </select>
            </td>
            <td><table width="95%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><input  type="text" size="25" class="input" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/></td>
                <td><input type="image" style='cursor:hand' onClick="return GoSearch();" src="<?php echo $misc;?>img/btn_search.jpg" align="middle" border="0" />
                </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="5" height="2" bgcolor="#797c88"></td>
          </tr>
          <tr bgcolor="f8f8f9" class="t_top">
            <td width="10%" height="40" align="center">No.</td>
            <td width="60%" align="center" class="t_border">제목</td>
            <td width="10%" align="center" class="t_border">등록자</td>
            <td width="10%" align="center" class="t_border">날짜</td>
            <td width="10%" align="center" class="t_border">첨부</td>
          </tr>
          <tr>
            <td colspan="5" height="1" bgcolor="#797c88"></td>
          </tr>
          <?php
          if ($count > 0) {
           $i = $count - $no_page_list * ( $cur_page - 1 );
           $icounter = 0;
           
           foreach ( $list_val as $item ) {
            if($item['file_changename']) {
             $strFile = "<img src='".$misc."img/add.png' width='20' height='20' />";
           } else {
             $strFile = "-";
           }
           ?>
           <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
            <td width="10%" height="40" align="center"><?php echo $i;?></td>
            <td width="60%" class="t_border" style="padding-left:10px;"><a href="JavaScript:ViewBoard('<?php echo $item['seq'];?>')"><?php echo $this->common->trim_text(stripslashes($item['subject']), 100);?></a><?php if($item['cnum'] > 0) { ?><span class="point2">(<?php echo $item['cnum'];?>)</span><?php } ?></td>
            <td width="10%" align="center" class="t_border"><?php echo $item['user_name'];?></td>
            <td width="10%" align="center" class="t_border"><?php echo substr($item['insert_date'], 0, 10);?></td>
            <td width="10%" align="center" class="t_border"><?php echo $strFile;?></td>
          </tr>
          <tr>
            <td colspan="7" height="1" bgcolor="#e8e8e8"></td>
          </tr>
          <?php
          $i--;
          $icounter++;
        }
      } else {
       ?>
       <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
        <td width="100%" height="40" align="center" colspan="5">등록된 게시물이 없습니다.</td>
      </tr>
      <tr>
        <td colspan="7" height="1" bgcolor="#e8e8e8"></td>
      </tr>
      <?php
    }	
    ?>
    <tr>
      <td colspan="5" height="2" bgcolor="#797c88"></td>
    </tr>
  </table></td>
</tr>
<script language="javascript">
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

function ViewBoard (seq){
	document.mform.action = "<?php echo site_url();?>/board/qna_view";
	document.mform.seq.value = seq;
	document.mform.mode.value = "view";

	document.mform.submit();
}
</script>
<!---------------------------------- 글쓰기 버튼넣기------------------------------>
<tr>
  <td height="10"></td>
</tr>
<tr>
  <td align="right"><a href="<?php echo site_url();?>/board/qna_input"><img src="<?php echo $misc;?>img/btn_write.jpg" width="64" height="31" /></td>
</tr>
<tr>
  <td height="10"></td>
</tr>
<!---------------------------------- 글쓰기 버튼넣기------------------------------>
<tr>
  <td align="center">
    <?php if ($count > 0) {?>
    <table width="400" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <?php
        if ($cur_page > 10){
          ?>
          <td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/btn_prev.jpg" /></a></td>
          <td width="2"></td>
          <td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/btn_left.jpg" /></a></td>
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
            $strSection = "&nbsp;<span class=\"section\">|</span>&nbsp;";
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
         <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/btn_right.jpg"/></a></td>
         <td width="2"></td>
         <td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/btn_next.jpg" /></a></td>
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
<tr>
  <td>&nbsp;</td>
</tr>
</table>


</td>
</tr>
</table>

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
</form>
</table>
</body>
</html>
