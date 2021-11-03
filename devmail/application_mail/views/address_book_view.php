<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">

  </head>

  <style>
  #group_view tr:hover {
    background-color: #e4f6f7;
  }

  .td_input{
    align:center;
    }

  </style>

  <body>
    <!--모달창-->
    <div id="detail_address_info" style="display:none;background-color: white; width: 40vw;  height: 70vh;">

      <div id="address_modal_h">
        <p>연락처 상세보기</p>
      </div>


      <form class="address_detail_info" action="" id="detail_address_info" name="address_detail_info" method="post">

       <div class="address_detail_info" id="address_deti_insert">
          이름  : <input type="text" name="detail_address_name" id="detail_address_name" value=""><br><br>
         이메일 : <input type="text" name="detail_address_email" id="detail_address_email" value=""><br><br>
          부서  : <input type="text" name="detail_address_department" id="detail_address_department" value=""><br><br>
          그룹  : <input type="text" name="detail_address_group" id="detail_address_group" value=""><br><br>
         아이디 : <input type="text" name="detail_address_id" id="detail_address_id" value=""><br><br>
         코멘트 : <input type="text" name="detail_address_comment" id="detail_address_comment" value=""><br><br>
         <button type="button" id="detail_address_inputBtn" name="button">수정</button>
         <button type="button" id="detail_address_inputBtn" name="button">삭제</button>
         <button type="button" id="detail_address_inputBtn_delete" name="button" onclick="$('#detail_address_info').bPopup().close();">닫기</button>
       </div>

     </form>

    </div>

    <div>
      <button type="button" id="address_deletetBtn" name="button" style="float:right">삭제</button>
    </div>

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
       </tr>


       <?php
       $i=count(($group_list));
       foreach ($group_list as $gl) {
         ?>
       <tr onclick="address_detail_open(<?php echo $gl['seq']; ?>);">

         <td onclick='event.cancelBubble=true;'>
           <input type="checkbox" name="checked" value="">
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
        </tr>
     <?php
        $i--;
   }
   ?>
      </tbody>
    </table>

      <script>

      function address_detail_open(seq){
        $("#detail_address_info").bPopup();
        // alert(seq);
      }

      function detail_address_click(){
       $.ajax({
              url:"<?php echo site_url();?>/group/detail_address_click",
              type:"get",
              dataType : 'json',
              data:{s:seq},
              success: function(result){
                if(result != ""){
                  alert("ㅋㅋ");
                }
                else{
                  console.log("실패");
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
