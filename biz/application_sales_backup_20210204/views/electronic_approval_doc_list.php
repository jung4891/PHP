<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
   .basic_td{
      border:1px solid;
      border-color:#d7d7d7;
   }
   .basic_table{
      border-collapse:collapse;
      border:1px solid;
      border-color:#d7d7d7;
   }

</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet"> 
  
<script>
</script>
<body>
<form name="cform" action="<?php echo site_url();?>/approval/electronic_approval_doc_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
   <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
   <input type="hidden" name="type" value="<?php echo $type; ?>">
</form>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <input type="hidden" id="seq" name="seq" value="">
      <?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php"; ?>
      <tr>
         <td align="center" valign="top">
            <table width="90%" height="100%" cellspacing="0" cellpadding="0">
               <tr>
                  <td width="100%" align="center" valign="top">
                     <!--내용-->
                     <table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
                        <!--타이틀-->
                        <tr>
                           <?php if($type == "request"){?>
                              <td class="title3">결재요청함</td>
                           <?php }else{?>
                              <td class="title3">임시저장함</td>
                           <?php }?>
                        </tr>
                        <!--타이틀-->
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                           <!-- 내용 -->
                           <td> 
                              <table class="basic_table" width="100%" style="font-family:Noto Sans KR">
                                 <tr class="t_top" align="center" bgcolor="f8f8f9" >
                                    <td height=50 class="basic_td">NO</td>
                                    <td class="basic_td">서식함</td>
                                    <td class="basic_td">문서제목</td>
                                    <td class="basic_td">기안일</td>
                                    <td class="basic_td">완료일</td>
                                    <td class="basic_td">문서상태</td>
                                 </tr>
                                 <?php 
                                 if(empty($view_val) != true){
                                    $idx = $count-$start_row;
                                    for($i = $start_row; $i<$start_row+$end_row; $i++){
                                       if(!empty( $view_val[$i])){
                                          $doc = $view_val[$i];
                                       echo "<tr align='center' onmouseover='this.style.backgroundColor=".'"'."#FAFAFA".'"'."' onmouseout='this.style.backgroundColor=".'"'.'#fff'.'"'."' style='cursor:pointer;' onclick='eletronic_approval_view({$doc['seq']},".'"'.$doc['approval_doc_status'].'"'.")'>";
                                       echo "<td height='40' class='basic_td'>{$idx}</td>";
                                       echo "<td class='basic_td'>";
                                       if($doc['template_category'] == ""){
                                          echo "연차";
                                       }else{
                                          foreach($category as $format_categroy){
                                             if($doc['template_category'] == $format_categroy['seq']){
                                                echo $format_categroy['category_name'];
                                             }
                                          }
                                       }

                                       echo "</td>";
                                       if($doc['approval_doc_hold'] == "N"){
                                          echo "<td class='basic_td'>{$doc['approval_doc_name']}</td>";
                                       }else{
                                          echo "<td class='basic_td'>{$doc['approval_doc_name']} (보류)</td>";
                                       }
                                       
                                       echo "<td class='basic_td'>{$doc['write_date']}</td>";
                                       echo "<td class='basic_td'>{$doc['completion_date']}</td>";
                                       echo "<td class='basic_td'>";
                                       if($doc['approval_doc_status'] == "001"){
                                          echo "진행중";
                                       }else if($doc['approval_doc_status'] == "002"){
                                          echo "완료";
                                       }else if($doc['approval_doc_status'] == "003"){
                                          echo "반려";
                                       }else if($doc['approval_doc_status'] == "004"){
                                          echo "회수";
                                       }else if($doc['approval_doc_status'] == "005"){
                                          echo "임시저장";
                                       }
                                       echo "</td>";
                                       // echo "<td class='basic_td'></td>";
                                       // echo "<td class='basic_td'></td>";
                                       echo "</tr>";
                                       }
                                       $idx --;
                                    }
                                 }else{
                                    echo "<tr><td align='center' colspan=6 height='40' class='basic_td'>검색 결과가 존재하지 않습니다.</td></tr>";
                                 }
                                 ?>

                              </table>
                           </td>
                        </tr>
                        <!-- <tr align="right">
                           <td>
                              <input type="button" class="basicBtn" value="등록" style="margin-top:15px;height:31px;width:61px;" onclick="location.href='<?php echo site_url();?>/approval/electronic_approval_form_list?mode=user'" />
                           </td>
                        </tr> -->
                        <!-- 페이징처리 -->
                        <tr>
                           <td align="center">
                           <?php if ($count > 0) {?>
                                 <table width="400" border="0" cellspacing="0" cellpadding="0" style="margin-top:50px;">
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
                        <!-- 페이징처리끝 -->
                     </table>
                     <!--내용-->
                  </td>
               </tr>
            </table>
         </td>
      </tr>
      <!--하단-->
      <tr>
         <td align="center" height="100" bgcolor="#CCCCCC">
            <table width="1130" cellspacing="0" cellpadding="0">
               <tr>
                  <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img
                        src="<?php echo $misc;?>img/f_ci.png" /></td>
                  <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?></td>
               </tr>
            </table>
         </td>
      </tr>
</table>
<script>
   function eletronic_approval_view(seq,status){
        location.href="<?php echo site_url(); ?>/approval/electronic_approval_doc_view?seq="+seq+"&type=<?php echo $_GET['type']; ?>&type2="+status;
   }

   function GoFirstPage (){
      document.cform.cur_page.value = 1;
      document.cform.submit();
   }

   function GoPrevPage (){
      var	cur_start_page = <?php echo $cur_page;?>;

      document.cform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
      document.cform.submit( );
   }

   function GoPage(nPage){
      document.cform.cur_page.value = nPage;
      document.cform.submit();
   }

   function GoNextPage (){
      var	cur_start_page = <?php echo $cur_page;?>;

      document.cform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
      document.cform.submit();
   }

   function GoLastPage (){
      var	total_page = <?php echo $total_page;?>;
   //	alert(total_page);

      document.cform.cur_page.value = total_page;
      document.cform.submit();
   }

</script>
</body>
</html>