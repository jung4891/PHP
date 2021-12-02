<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  $mode = $_GET['mode'];
  if($mode == "user"){
     //즐겨찾기 때문에 배열 순서 앞으로 땡겨
     for($i =0; $i<count($view_val); $i++){
        $form = $view_val[$i];
         if(strpos($form['bookmark'],','.$id)!== false){
            array_splice($view_val, $i, 1);
            array_unshift($view_val, $form);
         }
     }
  }
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
<form name="cform" action="<?php echo site_url(); ?>/approval/electronic_approval_form_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
   <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
   <input type="hidden" name="mode" value="<?php echo $mode; ?>">    
</form>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <input type="hidden" id="seq" name="seq" value="">
      <!-- <input type="hidden" name="mode" value=""> -->
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
                           <?php if($mode == "admin"){
                              echo '<td class="title3">양식 관리</td>';
                           }else{
                              echo '<td class="title3">기안문작성</td>';
                           }?>
                        </tr>
                        <!--타이틀-->
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                           <td height="60">
                              <select class="input2" onchange="categoryFilter(this.value);">
                                 <option value="">서식함</option>
                                 <?php foreach( $category as $ct){
                                    echo "<option value='{$ct['seq']}'";
                                    if(isset($_GET['category'])){
                                       if($ct['seq'] == $_GET['category']){
                                          echo "selected";
                                       }
                                    }
                                    echo ">{$ct['category_name']}</option>";
                                 }?>
                              </select>
                           </td>
                        </tr>                       
                        <tr>
                           <td height="30">
                              <h3>전자결재 양식 목록</h3>
                           </td>
                        </tr>
                        <tr>
                           <!-- 내용 -->
                           <td> 
                              <table class="basic_table" width="100%" style="font-family:Noto Sans KR">
                                 <tr class="t_top" align="center" bgcolor="f8f8f9" >
                                    <td height=50 class="basic_td">NO</td>
                                    <td class="basic_td">시스템</td>
                                    <td class="basic_td">서식함</td>
                                    <?php if($mode != 'admin'){
                                       echo '<td class="basic_td">즐겨찾기</td>';
                                    } ?>
                                    <td class="basic_td">양식명</td>
                                 </tr>
                                 <?php 
                                 if(empty($view_val) != true){
                                    $idx = $count-$start_row;
                                    for($i = $start_row; $i<$start_row+$end_row; $i++){
                                       if(!empty( $view_val[$i])){
                                          $form = $view_val[$i];
                                          echo "<tr align='center' onmouseover='this.style.backgroundColor=".'"'."#FAFAFA".'"'."' onmouseout='this.style.backgroundColor=".'"'.'#fff'.'"'."' style='cursor:pointer;' onclick='eletronic_approval_view({$form['seq']},event)'>";
                                          echo "<td height='40' class='basic_td'>{$idx}</td>";
                                          echo "<td class='basic_td'>{$form['template_type']}</td>";
                                          echo "<td class='basic_td'>";
                                          foreach($category as $format_categroy){
                                             if($form['template_category'] == $format_categroy['seq']){
                                                echo $format_categroy['category_name'];
                                             }
                                          }
                                          echo "</td>";
                                          if($mode != 'admin'){
                                             echo "<td class='basic_td'>";
                                             if(strpos($form['bookmark'],','.$id)!== false){
                                                echo "<img class='bookmark' src='{$misc}img/star2.png' width='20' onclick='bookmark({$form['seq']},1)'>";
                                             }else{
                                                echo "<img class='bookmark' src='{$misc}img/star.png' width='20' onclick='bookmark({$form['seq']},0)'>";
                                             }
                                             echo "</td>";
                                          }
                                          echo "<td class='basic_td'>{$form['template_name']}</td>";
                                          echo "</tr>";
                                          $idx--;
                                       }
                                    }
                                 }else{
                                    echo "<tr align='center'><td height='40' colspan=5 class='basic_td'>검색 결과가 존재하지 않습니다.</td></tr>";
                                 }
                                 ?>

                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td>
                           <?php if($mode == "user"){
                              echo '<input type="button" class="basicBtn" value="연차신청서 작성" style="cursor:pointer;margin:20px 0px 20px 0px;" onclick="annual_input_view();" >';
                           } ?>
                           <?php if($mode == "admin"){ ?>
                           <input type="button" class="basicBtn" value="양식작성" style="float:right;margin:20px 0px 20px 0px;" onclick="approval_form_input();" />
                           <?php } ?>
                           </td>
                        </tr>
                        <!-- 페이징처리 -->
                        <tr>
                           <td align="center">
                           <?php if ($count > 0) {?>
                                 <table width="400" border="0" cellspacing="0" cellpadding="0" >
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
   function eletronic_approval_view(seq,e){
      if(!$(e.target).hasClass("bookmark")){
         <?php if($mode == "admin"){ ?>
         location.href="<?php echo site_url(); ?>/approval/electronic_approval_form?seq="+seq+"&mode=modify";
         <?php }else{ ?>
         location.href="<?php echo site_url(); ?>/approval/electronic_approval_doc_input?seq="+seq;
         <?php }?>
      }
   }
   
   function bookmark(seq,type){
      if(type == 0){
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/approval/form_bookmark",
            dataType: "json",
            async :false,
            data: {
               seq: seq,
               type:type
            },
            success: function (data) {
               alert("즐겨찾기 설정");
               location.reload();
            }
         });
      }else{
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/approval/form_bookmark",
            dataType: "json",
            async :false,
            data: {
               seq: seq,
               type:type
            },
            success: function (data) {
               alert("즐겨찾기 설정 해제");
               location.reload();
            }
         });
      }
   }

   function approval_form_input(){
      location.href="<?php echo site_url(); ?>/approval/electronic_approval_form?mode=input";
   }

   function categoryFilter(val){
      location.href="<?php echo site_url(); ?>/approval/electronic_approval_form_list?mode=<?php echo $mode; ?>&category="+val;
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
      document.cform.cur_page.value = total_page;
      document.cform.submit();
   }

   //연차신청서 쓰러가깅
   function annual_input_view(){
      location.href='<?php echo site_url();?>/approval/electronic_approval_doc_input?seq=annual';
   }
 
</script>
</body>
</html>