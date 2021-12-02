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

   .tabs {position: relative;margin: 35px auto;width: 600px;}
   .tabs_input {position: absolute;z-index: 1000;width: 120px;height: 35px;left: 0px;top: 0px;opacity: 0;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";filter: alpha(opacity=0);}
   .tabs_input:not(:checked) {cursor: pointer;}
   .tabs_input:not(:checked) + label {color:#fff;}
   .tabs_input:not(:checked) + label {background: #f8f8f9;color:#777;}
   .tabs_input:hover + label {background: #666666;color:#fff;}
   .tabs_input#tab-2{left: 120px;}
   .tabs_input#tab-3{left: 240px;}
   .tabs_input#tab-4{left: 360px;}
   .tabs_input#tab-5{left: 480px;}
   .tabs label {background:#666666;color:#fff;font-size: 14px;line-height: 35px;height: 35px;position: relative;padding: 0 20px;float: left;display: block;width: 80px;letter-spacing: 0px;text-align: center;border-radius: 12px 12px 0 0;box-shadow: 2px 0 2px rgba(0,0,0,0.1), -2px 0 2px rgba(0,0,0,0.1);}
   .tabs label:after {content: '';background: #fff;position: absolute;bottom: -2px;left: 0;width: 100%;height: 2px;display: block;}
   .tabs label:first-of-type {z-index: 4;box-shadow: 1px 0 3px rgba(0,0,0,0.1);}

</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet"> 
  
<script>
</script>
<body>
<form name="cform" action="<?php echo site_url(); ?>/approval/electronic_approval_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
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
                     <table width="100%" border="0" style="margin-top:20px; margin-bottom: 50px;">
                        <!--타이틀-->
                        <?php if ($type != "admin"){?>
                        <tr>
                           <td>
                              <section class="tabs" style="width:100%">
                                 <input id="tab-1" type="radio" name="radio-set" class="tab-selector-1 tabs_input" <?php if($type == "standby"){echo 'checked="checked"';}?> onclick ="moveList('standby')" >
                                 <label for="tab-1" class="tab-label-1">결재대기함</label>
                                 <input id="tab-2" type="radio" name="radio-set" class="tab-selector-2 tabs_input" <?php if($type == "progress"){echo 'checked="checked"';}?> onclick ="moveList('progress')">
                                 <label for="tab-2" class="tab-label-2">결재진행함</label>
                                 <input id="tab-3" type="radio" name="radio-set" class="tab-selector-3 tabs_input" <?php if($type == "completion"){echo 'checked="checked"';}?> onclick ="moveList('completion')">
                                 <label for="tab-3" class="tab-label-3">완료문서함</label>
                                 <input id="tab-4" type="radio" name="radio-set" class="tab-selector-4 tabs_input" <?php if($type == "back"){echo 'checked="checked"';}?> onclick ="moveList('back')">
                                 <label for="tab-4" class="tab-label-4">반려문서함</label>
                                 <input id="tab-5" type="radio" name="radio-set" class="tab-selector-5 tabs_input" style="width: 130px;" <?php if($type == "reference"){echo 'checked="checked"';}?> onclick ="moveList('reference')">
                                 <label for="tab-5" class="tab-label-5" style="width:130px;">참조/열람문서함</label>
                              </section>
                           </td>
                        </tr>
                        <?php }?>
                        <tr>
                           <td height=40></td>
                        </tr>
                        <tr>
                           <?php if($type == "standby"){?>
                              <td class="title3">결재대기함</td>
                           <?php }else if($type == "progress"){?>
                              <td class="title3">결재진행함</td>
                           <?php }else if($type == "completion"){?>
                              <td class="title3">완료문서함</td>
                           <?php } else if($type == "back"){?>
                              <td class="title3">반려문서함</td>
                           <?php } else if($type == "reference"){?>
                              <td class="title3">참조/열람문서함</td>
                           <?php } else if ($type == "admin"){?>
                              <td class="title3">결재문서관리</td>
                           <?php }?>
                        </tr>
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                           <td> 
                              <table class="basic_table" width="100%" style="font-family:Noto Sans KR">
                                 <tr class="t_top" align="center" bgcolor="f8f8f9" >
                                    <td height=50 class="basic_td">NO</td>
                                    <td class="basic_td">서식함</td>
                                    <td class="basic_td">문서번호</td>
                                    <?php if($type == "standby" || $type == "completion" || $type == "back" || $type == "reference"){?>
                                    <td class="basic_td">유형</td>
                                    <?php } ?>
                                    <td class="basic_td">문서제목</td>
                                    <td class="basic_td">기안자</td>
                                    <td class="basic_td">기안부서</td>
                                    <td class="basic_td">기안일</td>

                                    <?php if($type == "standby"){?>
                                       <td class="basic_td">배정일</td>
                                    <?php }else if($type == "progress"){?>
                                       <td class="basic_td">결재일</td>
                                    <?php }else if($type == "completion" || $type == "back" ||$type == "reference" || $type == "admin"){?>
                                       <td class="basic_td">완료일</td>
                                    <?php } ?>

                                    <?php if($type == "admin"){ ?>
                                       <td class="basic_td">보안설정</td>
                                    <?php } ?>

                                    <!-- <td class="basic_td">배정일</td> -->
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
                                          echo "<td class='basic_td'>문서번호아직없음</td>";
                                          if($type == "standby" || $type == "completion" || $type == "back" || $type == "reference"){
                                          echo "<td class='basic_td'>{$doc['approval_type']}</td>";
                                          }
                                          if($doc['approval_doc_hold'] == "N"){
                                             echo "<td width='15%' class='basic_td'>{$doc['approval_doc_name']}</td>";
                                          }else{
                                             echo "<td width='15%' class='basic_td'>{$doc['approval_doc_name']} (보류)</td>";
                                          }
                                          
                                          echo "<td class='basic_td'>{$doc['writer_name']}</td>";
                                          echo "<td class='basic_td'>{$doc['writer_group']}</td>";
                                          echo "<td class='basic_td'>{$doc['write_date']}</td>";

                                       if($type == "standby"){
                                             echo "<td class='basic_td'>{$doc['assignment_date']}</td>";
                                       }else if($type == "progress"){
                                             echo "<td class='basic_td'>";
                                             if($doc['assignment_date'] != ""){
                                                echo $doc['assignment_date'];
                                             }else{
                                                echo $doc['write_date'];
                                             }
                                             echo "</td>";
                                       }else if($type == "completion" || $type == "back" ||$type == "reference" || $type=="admin"){
                                             echo "<td class='basic_td'>{$doc['completion_date']}</td>";
                                       }

                                      if($type == "admin"){ 
                                          echo "<td class='basic_td'>";
                                          if($doc['approval_doc_security'] == "Y"){
                                             echo "<img src='{$misc}img/security.png' width=15' />";
                                          }
                                          echo "</td>";
                                      }

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
                                          }else if($doc['approval_doc_status'] == "006"){
                                             echo "보류";
                                          }else{
                                             echo "";
                                          }
                                          echo "</td>";
                                          echo "</tr>";
                                          $idx --;
                                       }
                                    }
                                 }else{
                                    echo "<tr><td align='center' colspan=10 height='40' class='basic_td'>검색 결과가 존재하지 않습니다.</td></tr>";
                                 }
                                 ?>
                              </table>
                              <?php if(!empty($delegation)){ ?>
                              <br>
                              <h3> 위임 </h3>
                              <!-- 위임문서 -->
                              <table class="basic_table" width="100%" style="font-family:Noto Sans KR">
                                 <tr class="t_top" align="center" bgcolor="f8f8f9" >
                                    <td height=50 class="basic_td">NO</td>
                                    <td class="basic_td">서식함</td>
                                    <td class="basic_td">문서번호</td>
                                    <?php if($type == "standby" || $type == "completion" || $type == "back" || $type == "reference"){?>
                                    <td class="basic_td">유형</td>
                                    <?php } ?>
                                    <td class="basic_td">문서제목</td>
                                    <td class="basic_td">기안자</td>
                                    <td class="basic_td">기안부서</td>
                                    <td class="basic_td">기안일</td>

                                    <?php if($type == "standby"){?>
                                       <td class="basic_td">배정일</td>
                                    <?php }else if($type == "progress"){?>
                                       <td class="basic_td">결재일</td>
                                    <?php }else if($type == "completion" || $type == "back" ||$type == "reference"){?>
                                       <td class="basic_td">완료일</td>
                                    <?php } ?>

                                    <!-- <td class="basic_td">배정일</td> -->
                                    <td class="basic_td">문서상태</td>
                                 </tr>
                                 <?php 
                                 $idx = 1;
                                    foreach($delegation as $doc){
                                       echo "<tr align='center' onmouseover='this.style.backgroundColor=".'"'."#FAFAFA".'"'."' onmouseout='this.style.backgroundColor=".'"'.'#fff'.'"'."' style='cursor:pointer;' onclick='eletronic_approval_view({$doc['seq']})'>";
                                       echo "<td height='40' class='basic_td'>{$idx}</td>";
                                       echo "<td class='basic_td'>";
                                       foreach($category as $format_categroy){
                                          if($doc['template_category'] == $format_categroy['seq']){
                                             echo $format_categroy['category_name'];
                                          }
                                       }
                                       echo"</td>";
                                       echo "<td class='basic_td'>문서번호아직없음</td>";
                                       if($type == "standby" || $type == "completion" || $type == "back" || $type == "reference"){
                                       echo "<td class='basic_td'>{$doc['approval_type']}</td>";
                                       }
                                       if($doc['approval_doc_hold'] == "N"){
                                          echo "<td width='15%' class='basic_td'>{$doc['approval_doc_name']}(위임)</td>";
                                       }else{
                                          echo "<td width='15%' class='basic_td'>{$doc['approval_doc_name']} (보류)</td>";
                                       }
                                       
                                       echo "<td class='basic_td'>{$doc['writer_name']}</td>";
                                       echo "<td class='basic_td'>{$doc['writer_group']}</td>";
                                       echo "<td class='basic_td'>{$doc['write_date']}</td>";

                                    if($type == "standby"){
                                          echo "<td class='basic_td'>{$doc['assignment_date']}</td>";
                                    }else if($type == "progress"){
                                          echo "<td class='basic_td'>";
                                          if($doc['assignment_date'] != ""){
                                             echo $doc['assignment_date'];
                                          }else{
                                             echo $doc['write_date'];
                                          }
                                          echo "</td>";
                                    }else if($type == "completion" || $type == "back" ||$type == "reference"){
                                          echo "<td class='basic_td'>{$doc['completion_date']}</td>";
                                    }

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
                                       }else if($doc['approval_doc_status'] == "006"){
                                          echo "보류";
                                       }else{
                                          echo "";
                                       }
                                       echo "</td>";
                                       echo "</tr>";
                                       $idx ++;
                                    }

                             echo "</table>";
                           }
                           ?>
                           </td>
                        </tr>
                        <!-- 페이징처리 -->
                        <tr>
                           <td align="center" style="padding-top:50px;">
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
      if("<?php echo $type ;?>" == "admin"){
         location.href="<?php echo site_url(); ?>/approval/electronic_approval_doc_view?seq="+seq+"&type=<?php echo $type; ?>&type2="+status;
      }else{
         location.href="<?php echo site_url(); ?>/approval/electronic_approval_doc_view?seq="+seq+"&type=<?php echo $type; ?>";
      }
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

   function moveList(type){
      location.href="<?php echo site_url();?>/approval/electronic_approval_list?type="+type;
   }

</script>
</body>
</html>