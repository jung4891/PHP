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
   .basic_table td{
      padding:0px 10px 0px 10px;
      border:1px solid;
      border-color:#d7d7d7;
   }
   /* 모달 css */
   .searchModal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 10; /* Sit on top */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
      z-index: 1002;
   }
      /* Modal Content/Box */
   .search-modal-content {
      background-color: #fefefe;
      margin: 15% auto; /* 15% from the top and centered */
      padding: 20px;
      border: 1px solid #888;
      width: 70%; /* Could be more or less, depending on screen size */
      z-index: 1002;
   }

</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet"> 
<script>
</script>
<body>
<form name="cform" action="<?php echo site_url(); ?>/approval/electronic_approver_line_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
   <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
</form>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
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
                           <td class="title3">결재선 관리</td>
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
                                    <td width="15%" height=50 class="basic_td"><input type="checkbox" id="allCheck" /></td>
                                    <td width="15%" class="basic_td">번호</td>
                                    <td width="30%" class="basic_td">결재선명</td>
                                    <td width="20%" class="basic_td">등록일</td>
                                    <td width="20%" class="basic_td">미리보기</td>
                                 </tr>
                                 <?php 
                                 if(empty($view_val) != true){
                                    $idx = $count-$start_row;
                                    for($i = $start_row; $i<$start_row+$end_row; $i++){
                                       if(!empty( $view_val[$i])){
                                          $val = $view_val[$i];
                                          echo "<tr align='center' onmouseover='this.style.backgroundColor=".'"'."#FAFAFA".'"'."' onmouseout='this.style.backgroundColor=".'"'.'#fff'.'"'."' style='cursor:pointer;' onclick='approver_line_view(event,{$val['seq']})'>";
                                          echo "<td height=50 class='basic_td'><input type='checkbox' id='seq' name='seq' class='seq' value='{$val['seq']}' /></td>";
                                          echo "<td height=50 class='basic_td'>{$idx}</td>";
                                          echo "<td height=50 class='basic_td'>{$val['approval_line_name']}</td>";
                                          echo "<td height=50 class='basic_td'>{$val['insert_date']}</td>";
                                          echo "<td height=50 class='basic_td'><img class='preview' src='{$misc}img/btn_search.jpg' style='cursor:pointer;' onclick='click_user_approval_line({$val['seq']})' ></td>";
                                          echo "</tr>";
                                          $idx--;
                                       }
                                    }
                                 }
                                 ?>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <div style='float:right;margin:20px 0px 20px 0px;'>
                                 <input type="button" class="basicBtn" value="등록" style="width:61px;" onclick="location.href='<?php echo site_url();?>/approval/electronic_approver_line_management';" />
                                 <input type="button" class="basicBtn" value="삭제" style="width:61px;" onclick="approver_line_delete();" />
                              </div>
                           </td>
                        </tr>
                        <!-- 페이징처리 -->
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
                        <!-- 페이징처리끝 -->
                     </table>
                     <!--내용-->
                     <!-- 모달 -->
                     <div id="select_approval_modal" class="searchModal">
                        <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                           <h2>결재선미리보기</h2>
                              <div style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
                                 <table id="select_approver" width="90%" class="basic_table sortable" style='text-align:center;'>
                                    <!-- <tr bgcolor="f8f8f9">
                                       <td height="30"></td>
                                       <td height="30">결재</td>
                                       <td height="30"><?php echo $name." ".$duty." ".$group; ?></td>
                                    </tr> -->
                                 </table>
                              </div>
                              <div>
                                 <input type='button' class="basicBtn" value='닫기' style="cursor:pointer;float:right;" onClick="$('#select_approval_modal').hide();"/>
                              </div>
                        </div>
                     </div>
                     <!-- 모달 -->
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
   $(function () { //전체선택 체크박스 클릭 
      $("#allCheck").click(function () { //만약 전체 선택 체크박스가 체크된상태일경우 
         if ($("#allCheck").prop("checked")) { //해당화면에 전체 checkbox들을 체크해준다
            $("input[name=seq]").prop("checked", true); // 전체선택 체크박스가 해제된 경우 
         } else { //해당화면에 모든 checkbox들의 체크를해제시킨다. 
            $("input[name=seq]").prop("checked", false);
         }
      })
   })

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
   
   //결재선 삭제
   function approver_line_delete(){
      if($('input:checkbox[name="seq"]:checked').length < 1){
         alert("체크할 항목을 선택해 주세요.");
         return false;
      }else{
         var seq = '';
         $('input:checkbox[name="seq"]').each(function () {
            if (this.checked == true) {
               if (seq == "") {
                  seq += this.value;
               } else {
                  seq += ',' + this.value;
               }
            }
         });
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/approval/user_approval_line_save",
            dataType: "json",
            async: false,
            data: {
               type:3,
               seq :seq
            },
            success: function (result) {
               if(result){
                  alert("삭제되었습니다.");
                  location.reload();
               }else{
                  alert("삭제 실패");
                  return false;
               }
            }
         });
      }
   }

   //사용자 결재선 선택
   function click_user_approval_line(seq){
      $("#select_approver").html("");
      var html = '';
      var select_seq = seq
      var approver_seq ="";
      var approval_type ="";
      <?php
         if(empty($view_val) != true){
            foreach($view_val as $ual){ ?>
               if("<?php echo $ual['seq']; ?>" == select_seq){
                  approver_seq = "<?php echo $ual['approver_seq'];?>";
                  approval_type= "<?php echo $ual['approval_type'];?>";
               }
      <?php } 
         } ?>
      
      approver_seq = approver_seq.split(',');
      approval_type = approval_type.split(',');
      for(i=0; i<approver_seq.length; i++){
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/approval/user_approval_line_approver",
            dataType: "json",
            async :false,
            data: {
               user_seq: approver_seq[i]
            },
            success: function (data) {
               html += "<tr class='select_approver' onclick='click_user("+data['seq']+',"'+data['user_name']+' '+data['user_duty']+' '+data['user_group']+'"'+",this)'>";
               html += "<td height=30></td><td onclick='change_approval_type(this);' style='cursor:pointer;'>"+approval_type[i]+"</td><td>"+data['user_name']+' '+data['user_duty']+' '+data['user_group']+"<input type='hidden' name='approval_line_seq' value='"+data['seq']+"' /><input type='hidden' name='approval_line_type' value='"+approval_type[i]+"' /></td>";
               html += "</tr>";
            }
         });
      }
      $("#select_approver").html(html);
      finalReferrer();   
      $("#select_approval_modal").show();
   }

   //결재선 마지막 줄 최종으로 표시
   function finalReferrer(){
      for(i=0; i < $("#select_approver").find($("td")).length; i++){
         if($("#select_approver").find($("td")).eq(i).html() == "최종"){
            $("#select_approver").find($("td")).eq(i).html("");
         }else if(i == ($("#select_approver").find($("td")).length)-3){
            $("#select_approver").find($("td")).eq(i).html("최종");
         }
      }
   }

   //모달 외부 클릭시 모달 close
   $(document).mouseup(function (e) {
      var container = $('.searchModal');
      if (container.has(e.target).length === 0) {
         container.css('display', 'none');
      }
   });

   //결재선 뷰
   function approver_line_view(e,seq){
      if(!$(e.target).hasClass("preview") && !$(e.target).hasClass("seq") ){
         location.href = "<?php echo site_url();?>/approval/electronic_approver_line_management?seq="+seq;
      }
   }

</script>
</body>
</html>