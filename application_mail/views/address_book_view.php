<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>
  <style>
  #group_view tr:hover {
    background-color: #e4f6f7;
  }

  .td_input{
    align:center;
    }

  </style>

  <script language="javascript">
  // function GoSearch(){
  // 	// var searchkeyword = document.mform.searchkeyword.value;
  // 	// var searchkeyword = searchkeyword.trim();
  //  // var searchdomain = document.mform.searchdomain.value;
  //  // var searchdomain = searchdomain.trim();
  // 	// if (searchkeyword.replace(/,/g, "") == "") {
  // 	// 	 // alert("검색어가 없습니다.");
  // 	// 	 location.href="<?php echo site_url();?>/admin/mailbox/mail_list";
  // 	// 	 return false;
  // 	// }
  //
  // 	document.mform.action = "<?php echo site_url();?>/group/address_book_view";
  // 	document.mform.cur_page.value = "";
  // 	document.mform.submit();
  // }

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
  <form name="" action="" method="post">
    <div class="" align="left" width=100% style="border-bottom:1px solid #1A8DFF;margin:-10px 40px 10px 40px;">
      <button type="button" name="button" class="nav_btn" style="margin-left:10px;"onclick="location.href='<?php echo site_url(); ?>/option/account'">계정설정</button>
      <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/mailbox'">메일함설정</button>
      <button type="button" name="button" class="nav_btn select_btn" onclick="location.href='<?php echo site_url(); ?>/option/address_book'">주소록관리</button>
      <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/singnature'">서명관리</button>
    </div>
  </form>
  <form name="mform" action="<?php echo site_url(); ?>/group/address_book_view" method="get">
  <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
  <div class="main_div">
    <div>
      <button type="button" id="address_deletetBtn" name="button" style="float:right" onclick="address_delete();">삭제</button>
    </div>
    <div class="">
      <table id="group_view">
        <tbody>
          <tr onclick="detail_address_click();">
          <th> </th>
          <th>No.</th>
          <th>name</th>
          <th>email</th>
          <th>department</th>
          <th>group</th>
          <th>id</th>
          <th>comment</th>
          <th>date</th>
         </tr>


         <tbody>

         <?php
       if ($count > 0) {
         $i = $count - $no_page_list * ( $cur_page - 1 );
         $icounter = 0;
         foreach ($group_list as $gl) {
           ?>
         <tr onclick="address_detail_open(<?php echo $gl['seq']; ?>);">

           <td onclick='event.cancelBubble=true;'>
             <input type="checkbox" name="checked_address" value="<?php echo $gl['seq']; ?>">
           </td>

           <td>
             <?php echo $i; ?>
           </td>

           <td>
             <?php echo $gl["name"]; ?>
           </td>

           <td>
             <?php echo $gl["email"]; ?>
           </td>

           <td>
             <?php echo $gl["department"]; ?>
           </td>

           <td>
             <?php echo $gl["group"]; ?>
           </td>

           <td>
             <?php echo $gl["id"]; ?>
           </td>

           <td>
             <?php echo $gl["comment"]; ?>
           </td>

           <td>
             <?php echo $gl["insert_date"]; ?>
           </td>

          </tr>
       <?php
       $i--;
       $icounter++;
     }
   }else{
    ?>
    <tr>
     <td width="100%" height="40" align="center" colspan="8">등록된 게시물이 없습니다.</td>
    </tr>

    <?php
   }
     ?>

        </tbody>
      </table>
    </div>
    <div class="paging_div">
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
          echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\"><font color=\"#33ccff\">".$i."</font></a>".$strSection;
        } else {
          echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\">".$i."</a>".$strSection;
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

  </form>
  </div>

  <!--모달창-->
  <div id="detail_address_info" style="display:none;background-color: white; width: 40vw;  height: 70vh;">
    <div id="address_modal_h">
      <p>연락처 상세보기</p>
    </div>


    <form class="address_detail_info" action="" id="detail_address_info" name="address_detail_info" method="post">

     <div class="address_detail_info" id="address_deti_insert">
       <input type="text" id="modal_seq" name="" value="">
        <!-- 이름  : <input type="hidden" name="detail_address_name" id="detail_address_name" value=""><br><br> -->
        <!-- <p name="detail_address_name" id="detail_address_name" value="">이름 : </p> -->
       <!-- 이메일 : <input type="text" name="detail_address_email" id="detail_address_email" value=""><br><br> -->
       <li class="detail_address_name">이름
         <span id="detail_address_name"></span>
       </li>
       <li class="detail_address_email">이메일
         <span id="detail_address_email"></span>
       </li>
       <li class="detail_address_department">부서
         <span id="detail_address_department"></span>
       </li>
       <li class="detail_address_group">그룹
         <span id="detail_address_group"></span>
       </li>
       <li class="detail_address_comment">코멘트
         <span id="detail_address_comment"></span>
       </li>
        <!-- 부서  : <input type="text" name="detail_address_department" id="detail_address_department" value=""><br><br>
        그룹  : <input type="text" name="detail_address_group" id="detail_address_group" value=""><br><br>
       코멘트 : <input type="text" name="detail_address_comment" id="detail_address_comment" value=""><br><br> -->
       <button type="button" id="detail_address_modifyBtn" name="button" onclick="$('#detail_address_info').bPopup().close();$('#detail_address_modify').bPopup();">수정</button>
       <button type="button" id="detail_address_saveBtn" name="button" onclick="address_detail_save();">저장</button>
       <button type="button" id="detail_address_closeBtn" name="button" onclick="$('#detail_address_info').bPopup().close();">닫기</button>
     </div>

        </form>
        <!-- 두번째 모달 -->
        <div class="address_detail_modify" id="detail_address_modify" style="display:none;background-color:white;">
          <input type="hidden" id="modal_seq" name="" value=""><br><br>
          이름  : <input type="text" name="detail_address_modify_name" id="detail_address_modify_name" value=""><br><br>

          이메일 : <input type="text" name="detail_address_modify_email" id="detail_address_modify_email" value=""><br><br>

          부서  : <input type="text" name="detail_address_modify_department" id="detail_address_modify_department" value=""><br><br>

          그룹  : <input type="text" name="detail_address_modify_group" id="detail_address_modify_group" value=""><br><br>

          코멘트 : <input type="text" name="detail_address_modify_comment" id="detail_address_modify_comment" value=""><br><br>
          <button type="button" name="button">adsadsad</button>

          <!-- <button type="button" id="detail_address_modifyBtn" name="button" onclick="detail_address_modify();">수정</button>
          <button type="button" id="detail_address_saveBtn" name="button" onclick="address_detail_save();">저장</button>
          <button type="button" id="detail_address_closeBtn" name="button" onclick="$('#detail_address_info').bPopup().close();">닫기</button> -->
        </div>
       </div>

        </div>





   </form>
  </div>


  <!-- <div id="detail_address_info" style="display:none;background-color: white; width: 40vw;  height: 70vh;">
    <div id="address_modal_h">
      <p>연락처 수정하기</p>
    </div>


    <form class="address_detail_info" action="" id="detail_address_info" name="address_detail_info" method="post">

     <div class="address_detail_info" id="address_deti_insert">
       <input type="text" id="modal_seq" name="" value="">
        이름  : <input type="hidden" name="detail_address_name" id="detail_address_name" value=""><br><br>

       이메일 : <input type="text" name="detail_address_email" id="detail_address_email" value=""><br><br>

       부서  : <input type="text" name="detail_address_department" id="detail_address_department" value=""><br><br>

        그룹  : <input type="text" name="detail_address_group" id="detail_address_group" value=""><br><br>

       코멘트 : <input type="text" name="detail_address_comment" id="detail_address_comment" value=""><br><br>

       <button type="button" id="detail_address_modifyBtn" name="button" onclick="detail_address_modify();">수정</button>
       <button type="button" id="detail_address_saveBtn" name="button" onclick="address_detail_save();">저장</button>
       <button type="button" id="detail_address_closeBtn" name="button" onclick="$('#detail_address_info').bPopup().close();">닫기</button>
     </div>

   </form>
  </div> -->
</div>


      <script>


      // 연락처 상세보기 모달창 open
      function address_detail_open(seq){
       $.ajax({
              url:"<?php echo site_url();?>/group/detail_address_click",
              type:"get",
              dataType : 'json',
              data:{seq:seq},
              success: function(result){
                if(result){
                  // console.log(result);
                  $("#detail_address_info").bPopup();
                    $("#modal_seq").val(seq);
                   // detail_address_name이 id값인 value자리에 result.name값 담김
                  // $("#detail_address_email").val(result.email); -> input창은 value있어서 val값 가져올 수 있더
                  $("#detail_address_name").html(result.name);
                  $("#detail_address_email").html(result.email);
                  $("#detail_address_department").html(result.department);
                  $("#detail_address_group").html(result.group);
                  $("#detail_address_comment").html(result.comment);
                  //수정 input창
                  $("#detail_address_modify_name").val(result.name);
                  $("#detail_address_modify_email").val(result.email);
                  $("#detail_address_modify_department").val(result.department);
                  $("#detail_address_modify_group").val(result.department);
                  $("#detail_address_modify_comment").val(result.comment);
                }else{
                  alert("실패하였습니다.");
                  return false;
                }
               }
             });
     }

     //연락처 상세보기 "수정"버튼 눌렀을 때
     function detail_address_modify(){
       alert("zz");
     }

     // 연락처 상세보기 모달창 수정
     $("#detail_address_modifyBtn").on("click", function(value){
       if(value){
         $("#detail_address_modify_name").val(value.name);
         $("#detail_address_modify_email").val(value.email);
         $("#detail_address_modify_department").val(value.department);
         $("#detail_address_modify_group").val(value.group);
         $("#detail_address_modify_comment").val(value.comment);


           // var detail_address_name = $("#detail_address_name").text();
           // var a="<input id="a">"+detail_address_name+"</iput>";
           // var detail_address_name = $("#detail_address_name").text();
           // var a = "<input>$("#detail_address_name")</input>"
           // $("#detail_address_name").replaceWith("<input></input>");
           // $("#detail_address_email").replaceWith("<input></input>");
           // $("#detail_address_department").replaceWith("<input></input>");
           // $("#detail_address_group").replaceWith("<input></input>");
           // $("#detail_address_comment").replaceWith("<input></input>");


       }else{
         alert("실패");
         return false;
       }

     })

     function address_detail_save(){
       // alert("zz");
       // 버튼 누르면 값 updade하고 저장되는 로직 짜면 된답니다
     }


     function address_delete(){
    var checkboxArr = [];
    $("input:checkbox[name='checked_address']:checked").each(function(){
      checkboxArr.push($(this).val());
      console.log(checkboxArr);
    })

    $.ajax({
           url:"<?php echo site_url();?>/group/address_delete",
           type:"post",
           data:{checkboxArr:checkboxArr},
           success: function(result){
             if(result){
               console.log(result);

             }else{
               alert("실패하였습니다.");
               return false;
             }
            }
          });
     }

      </script>

  </body>
</html>


<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>
