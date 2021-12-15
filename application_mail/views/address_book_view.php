<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>
  <style>
  #group_view tr:hover {
    background-color: #e4f6f7;
  }

  #group_view td {
    border-top:1px solid #dedede;
  }

  .td_input{
    align:center;
    }


    .nav_btn{
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      border:1px solid #B0B0B0;
      border-bottom: none;
      height: 30px;
      width: 100px;
      cursor: pointer;
      background-color: #FFFFFF;
      color: #1C1C1C;
      border-radius: 10px 10px 0px 0px;
    }

    .select_btn{
      border:none;
      background-color: #1A8DFF;
      color: #FFFFFF;
    }

  </style>

  <script language="javascript">
  // function GoSearch(){
  //    // var searchkeyword = document.mform.searchkeyword.value;
  //    // var searchkeyword = searchkeyword.trim();
  //  // var searchdomain = document.mform.searchdomain.value;
  //  // var searchdomain = searchdomain.trim();
  //    // if (searchkeyword.replace(/,/g, "") == "") {
  //    //     // alert("검색어가 없습니다.");
  //    //     location.href="<?php echo site_url();?>/admin/mailbox/mail_list";
  //    //     return false;
  //    // }
  //
  //    document.mform.action = "<?php echo site_url();?>/group/address_book_view";
  //    document.mform.cur_page.value = "";
  //    document.mform.submit();
  // }

  function GoFirstPage (){
     document.mform.cur_page.value = 1;
     document.mform.submit();
  }

  function GoPrevPage (){
     var   cur_start_page = <?php echo $cur_page;?>;

     document.mform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
     document.mform.submit( );
  }

  function GoPage(nPage){
     document.mform.cur_page.value = nPage;
     document.mform.submit();
  }

  function GoNextPage (){
     var   cur_start_page = <?php echo $cur_page;?>;

     document.mform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
     document.mform.submit();
  }

  function GoLastPage (){
     var   total_page = <?php echo $total_page;?>;
  //   alert(total_page);

     document.mform.cur_page.value = total_page;
     document.mform.submit();
  }


  </script>


<div id="main_contents" align="center">
    <form name="" action="" method="post">
      <div class="" align="left" width=100% style="border-bottom:1px solid #1A8DFF;margin:-10px 40px 10px 40px;">
        <!-- <button type="button" name="button" class="nav_btn" style="margin-left:10px;"onclick="location.href='<?php echo site_url(); ?>/option/account'">계정설정</button> -->
        <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/mailbox'">메일함설정</button>
        <button type="button" name="button" class="nav_btn select_btn" onclick="location.href='<?php echo site_url(); ?>/option/address_book'">주소록관리</button>
        <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/singnature'">서명관리</button>
      </div>
    </form>

  <form name="mform" action="<?php echo site_url(); ?>/group/address_book_view" method="get">
  <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
  <div style="width:80%;margin:20px 0px 20px 0px;">
    <button type="button" id="address_addBtn" class="btn_basic btn_blue" name="button" style="float:right" onclick="address_open();">주소록 추가</button>
    <!-- <button type="button" id="" name="button" style="float:right">수정</button> -->
    <button type="button" id="address_deletetBtn" class="btn_basic btn_sky" name="button" style="float:right" onclick="address_delete();">삭제</button>
  </div>
  <div class="main_div" style="margin-top:20px;">
      <table id="" border="0" cellspacing="0" cellpadding="0" style="width:80%">
        <colgroup>
          <col width="5%">
          <col width="5%">
          <col width="15%">
          <col width="20%">
          <col width="15%">
          <col width="10%">
          <col width="15%">
          <col width="15%">
        </colgroup>
        <tr onclick="detail_address_click();">
          <th></th>
          <th>No.</th>
          <th>이름</th>
          <th>이메일</th>
          <th>회사</th>
          <th>부서</th>
          <th>코멘트</th>
          <th>최종수정일</th>
        </tr>


         <tbody id="group_view">

         <?php
       if ($count > 0) {
         $i = $count - $no_page_list * ( $cur_page - 1 );
         $icounter = 0;
         foreach ($group_list as $gl) {
           ?>
         <tr onclick="address_detail_open(<?php echo $gl['seq']; ?>);">

           <td height="40" align="center" onclick='event.cancelBubble=true;'>
             <input type="checkbox" name="checked_address" value="<?php echo $gl['seq']; ?>">
           </td>

           <td align="center">
             <?php echo $i; ?>
           </td>

           <td align="center">
             <?php echo $gl["name"]; ?>
           </td>

           <td align="center">
             <?php echo $gl["email"]; ?>
           </td>

           <td align="center">
             <?php echo $gl["department"]; ?>
           </td>

           <td align="center">
             <?php echo $gl["group"]; ?>
           </td>

           <td align="center">
             <?php echo $gl["comment"]; ?>
           </td>

           <td align="center">
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
     <td width="100%" height="40" align="center" colspan="8">등록된 주소가 없습니다.</td>
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
        <?php } ?>
    </div>

  </form>
  </div>

  <div id="address_modal" style="display:none;background-color: white; width: auto; height: auto;">
    <div id="address_modal_h" align="center" style="border-bottom:1px solid #dedede;">
      <p style="font-weight:bold;font-size:16px;">연락처 추가</p>
    </div>

   <form action="" id="address_info" name="address_info" method="post">
    <div class="address_info" id="address_insert" align="center" style="margin:0px 30px 30px 20px;">
      <table>
        <tr>
          <td align="right">
            이름  :
          </td>
          <td>
            <input type="text" name="address_name" id="address_name" value="">
          </td>
        </tr>
        <tr>
          <td align="right">
            이메일  :
          </td>
          <td>
            <input type="text" name="address_email" id="address_email" value="">
          </td>
        </tr>
        <tr>
          <td align="right">
            회사  :
          </td>
          <td>
             <input type="text" name="address_department" id="address_department" value="">
          </td>
        </tr>
        <tr>
          <td align="right">
            부서  :
          </td>
          <td>
            <input type="text" name="address_group" id="address_group" value="">
          </td>
        </tr>
        <tr>
          <td align="right">
            코멘트  :
          </td>
          <td>
            <input type="text" name="address_comment" id="address_comment" value="">
          </td>
        </tr>
      </table>

      <button type="button" class="btn_basic btn_sky" id="address_inputBtn_delete" name="button" onclick="$('#address_modal').bPopup().close();">취소</button>
      <button type="button" class="btn_basic btn_blue" id="address_inputBtn" name="button">등록</button>
    </div>
  </form>

  </div>


  <!--모달창-->
  <div id="detail_address_info" style="display:none;background-color: white; width:auto; height:auto;">
    <div id="address_modal_h" align="center">
      <p style="font-weight:bold;font-size:16px;">연락처 상세보기</p>
    </div>

    <form class="address_detail_info" action="" id="detail_address_info" name="address_detail_info" method="post">

     <div class="address_detail_info" id="address_detail_insert" align="center" style="margin:0px 30px 30px 20px;">
       <input type="hidden" id="modal_seq" name="" value="">

       <table>
         <tr>
           <td align="right">
             이름  :
           </td>
           <td>
              <span id="detail_address_name"></span>
           </td>
         </tr>
         <tr>
           <td align="right">
             이메일  :
           </td>
           <td>
             <span id="detail_address_email"></span>
           </td>
         </tr>
         <tr>
           <td align="right">
             회사  :
           </td>
           <td>
                <span id="detail_address_department"></span>
           </td>
         </tr>
         <tr>
           <td align="right">
             부서  :
           </td>
           <td>
              <span id="detail_address_group"></span>
           </td>
         </tr>

         <tr>
           <td align="right">
             코멘트  :
           </td>
           <td>
             <span id="detail_address_comment"></span>
           </td>
         </tr>
       </table>

       <button type="button" class="btn_basic btn_sky" id="detail_address_closeBtn" name="button" onclick="$('#detail_address_info').bPopup().close();">닫기</button>
       <button type="button" class="btn_basic btn_blue" id="detail_address_modifyBtn" name="button" onclick="$('#detail_address_info').bPopup().close();$('#detail_address_modify').bPopup();">수정</button>
       <!-- <button type="button" id="detail_address_saveBtn" name="button" onclick="address_detail_save();">저장</button> -->
     </div>
        </form>

        <!-- 두번째 모달 (수정모달)-->
        <div class="address_detail_modify" id="detail_address_modify" style="display:none;background-color: white; width:auto; height:auto;">

          <div id="address_modal_h" align="center">
            <p style="font-weight:bold;font-size:16px;">연락처 수정</p>
          </div>

          <form class="address_detail_modify" action="" id="address_detail_modify" name="address_detail_modify" method="post">

          <div class="address_detail_modify" id="address_detail_modify" align="center" style="margin:0px 30px 30px 20px;">

            <table>
              <tr>
                <td align="right">
                  이름  :
                </td>
                <td>
                  <input type="text" name="detail_address_modify_name" id="detail_address_modify_name" value="">
                </td>
              </tr>
              <tr>
                <td align="right">
                  이메일  :
                </td>
                <td>
                  <input type="text" name="detail_address_modify_email" id="detail_address_modify_email" value="">
                </td>
              </tr>
              <tr>
                <td align="right">
                  회사  :
                </td>
                <td>
                   <input type="text" name="detail_address_modify_department" id="detail_address_modify_department" value="">
                </td>
              </tr>
              <tr>
                <td align="right">
                  부서  :
                </td>
                <td>
                  <input type="text" name="detail_address_modify_group" id="detail_address_modify_group" value="">
                </td>
              </tr>
              <tr>
                <td align="right">
                  코멘트  :
                </td>
                <td>
                  <input type="text" name="detail_address_modify_comment" id="detail_address_modify_comment" value="">
                </td>
              </tr>
            </table>

            <button type="button" class="btn_basic btn_blue" id="detail_address_saveBtn" name="button" onclick="address_detail_save();">저장</button>
             <button type="button" class="btn_basic btn_sky" id="detail_address_closeBtn" name="button" onclick="$('#detail_address_modify').bPopup().close();">닫기</button>

            </form>
         </div>
        </div>
     </div>

      <script>
      // 모든페이지에서 주소록추가 모달창이 띄워져야하기때문에 footer에 넣기 -> footer include된다
        function address_open(){
          $("#address_modal").bPopup();
        }

        $("#address_inputBtn").on("click", function(){
          var addressName = $("#address_name").val();
          var addressEmail = $("#address_email").val();
          var addressDepartment = $("#address_department").val();
          var addressGroup = $("#address_group").val();
          var addressId = $("#address_id").val();
          var addressComment = $("#address_comment").val();
          if(addressName==""){
            alert("사용자의 이름을 입력해주세요.");
            $("#address_name").focus();
            return false;
          }
          if(addressEmail==""){
            alert("사용자의 이메일을 입력해주세요.");
            $("#address_email").focus();
            return false;
          }


            $.ajax({
              url: "<?php echo site_url(); ?>/group/address_action",
              data: {
                name:addressName,
                email:addressEmail,
                department:addressDepartment,
                group:addressGroup,
                id:addressId,
                comment:addressComment
              },
              type: 'POST',
              dataType: 'json',
              cache: false,
              success: function (result) {

                // $("#address_name").val('');
                // $("#address_email").val('');
                // $("#address_department").val('');
                // $("#address_group").val('');
                // $("#address_id").val('');
                // $("#address_comment").val('');
                location.reload();

                // var input = document.getElementById('#address_info');
                // input.value = null;
              }
            });


        })


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
                  $("#detail_address_modify_group").val(result.group);
                  $("#detail_address_modify_comment").val(result.comment);
                }else{
                  alert("실패하였습니다.");
                  return false;
                }
               }
             });
     }

     // 연락처 상세보기 모달창 수정
     $("#detail_address_modifyBtn").on("click", function(value){
       if(value){
         $("#detail_address_modify_name").val(result.name);
         $("#detail_address_modify_email").val(result.email);
         $("#detail_address_modify_department").val(result.department);
         $("#detail_address_modify_group").val(result.department);
         $("#detail_address_modify_comment").val(result.comment);


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

     // //연락처 상세보기 "수정"버튼 눌렀을 때
     // function detail_address_modify(){
     //   alert("zz");
     // }



     // 연락처 상세보기 저장버튼 -> 수정됨
     function address_detail_save(){
       // alert("zz");
       var seq = $("#modal_seq").val();
       var name = $("#detail_address_modify_name").val(); // 값 가져오려면 val 창 비워
       // $("#detail_address_modify_departments").val('name'); // 값 내용 변경하려면 val에 변경값 입력해
       var email = $("#detail_address_modify_email").val();
       var department = $("#detail_address_modify_department").val();
       var group = $("#detail_address_modify_group").val();
       // var id = $("#detail_address_modify_id").val();
       var comment = $("#detail_address_modify_comment").val();
       if(name==""){
         alert("사용자의 이름을 입력해주세요.");
         $("#detail_address_modify_name").focus();
         return false;
       }
       if(email==""){
         alert("사용자의 이메일을 입력해주세요.");
         $("#detail_address_modify_email").focus();
         return false;
       }
       $.ajax({
              url:"<?php echo site_url();?>/group/detail_address_save",
              type:'post',
              dataType : 'json',
              data:{
                seq:seq,
                name:name,
                email:email,
                department:department,
                group:group,
                // id:id,
                comment:comment
              },
              success: function(result){
                if(result){
                  $("#modal_seq").val();
                  alert("수정되었습니다.");
                  location.reload(); // 비동기식이랑서 화면 새로고침 해준다

                }else{
                  alert("실패하였습니다.");
                  return false;
                }
               }
             });

       // 버튼 누르면 값 updade하고 저장되는 로직 짜면 된답니다
     }



     // function address_detail_save(){
     //   var seq = $("#modal_seq").val();
     // }


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
               location.reload();

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
