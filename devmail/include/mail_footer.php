</div>
<div id="footer">

  <div id="address_modal" style="display:none;background-color: white; width: 40vw; height: 70vh;">
    <div id="address_modal_h">
      <p>연락처 추가</p>
    </div>

   <form class="address_info" action="" id="address_info" name="address_info" method="post">
    <div class="address_info" id="address_insert">
       이름  : <input type="text" name="address_name" id="address_name" value=""><br><br>
      이메일 : <input type="text" name="address_email" id="address_email" value=""><br><br>
       부서  : <input type="text" name="address_department" id="address_department" value=""><br><br>
       그룹  : <input type="text" name="address_group" id="address_group" value=""><br><br>
      아이디 : <input type="text" name="address_id" id="address_id" value=""><br><br>
      코멘트 : <input type="text" name="address_comment" id="address_comment" value=""><br><br>
      <button type="button" id="address_inputBtn_delete" name="button" onclick="$('#address_modal').bPopup().close();">취소</button>
      <button type="button" id="address_inputBtn" name="button">확인</button>
    </div>
  </form>

  </div>

</div>

<script type="text/javascript">
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

          $("#address_name").val(' ');
          $("#address_email").val(' ');
          $("#address_department").val(' ');
          $("#address_group").val(' ');
          $("#address_id").val(' ');
          $("#address_comment").val(' ');
          $('#address_modal').bPopup().close();

          // var input = document.getElementById('#address_info');
          // input.value = null;
        }
      });


  })


</script>
</body>
</html>
