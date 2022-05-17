<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mobile/mail_header_mobile.php";
 ?>
<style media="screen">
.option-main{
  width: 100vw;
  height: calc(100vh - 75px);
  text-align: center;
  /* position: relative; */
  /* top:75px; */
  /* padding:10px; */
}

.text-field{
  height:30px;
  color:#1C1C1C;
  font-size: 14px;
  text-align: left;
  padding-top: 20px;
  padding-left: 30px;
}

.input-field{
  height:40px;
  font-size: 16px;
  padding-left: 30px;
  padding-right:30px;
}
.input-field input{
  width:100%;
  height: 40px;
  font-size: 18px;
  outline: none;
  border:1px solid #F4F4F4;
  border-radius: 5px;
}
</style>
<div class="option-main">
<form class="" id="password_change_form" action="" method="post" autocomplete="off">

  <div class="text-field">
    이름
  </div>
  <div class="input-field">
    <input type="hidden" id="modify_id" name="modify_id" value="<?php echo $_SESSION["userid"]; ?>">
    <input type="text" id="modify_name" name="modify_name" style="" value="<?php echo $_SESSION['name']; ?>" autocomplete="off"/>
  </div>
  <div class="text-field">
    패스워드
  </div>
  <div class="input-field">
    <input type="hidden" id="cert_pass" value="false">
    <input type="password" class="" id="mail_password" name="mail_password" value="" style="" placeholder="패스워드 입력" autocomplete="off" />
  </div>

  <div class="text-field">
    패스워드 확인
  </div>
  <div class="input-field">
    <input type="password" class="" id="chk_password" name="chk_password" value="" style="" placeholder="패스워드 확인 입력" autocomplete="off" />
  </div>
  <div class="" id="PassSpanTd" style="display:none;">
    <span id="password_span"></span>
  </div>
  <div class="" style="padding-top:15px;">
    <span style="background-color:#F4F4F4;color:#6D6D6D;">
      <img src="/misc/img/mobile/느낌표.svg" style="width:18px;position: relative;top: 2px;left: 2px;">
      이름과 패스워드를 따로 변경할 수 있습니다.</span>
  </div>
  <div class="" style="text-align: center;display:flex;justify-content: space-evenly;width: 100%;padding-top:30px;">
    <button type="button" name="button" class="btn_basic btn_sky"  style="width:40%;height:60px;" onclick="close_div();">취소</button>
    <button type="button" name="button" class="btn_basic btn_blue"  style="width:40%;height:60px;" onclick="password_change();">변경</button>
  </div>
</form>
</div>
</body>

<script type="text/javascript">
// $(function (){
//
// })
function name_update(){
  var id = $("#modify_id").val();
  var name = $("#modify_name").val();

  $.ajax({
      url: "<?php echo site_url(); ?>/option/change_name",
      type: "POST",
      dataType : "json",
      data: {
        id: id,
        name: name
      },
      success: function(result){
        if(result == "true"){
          alert("변경되었습니다.");
          location.reload();
        }
      }
    })
}

function password_change(){

  var name = $("#modify_name").val();
  var id = $("#modify_id").val();
  var password = $("#mail_password").val();
  var chk_pass = $("#chk_password").val();
  if (name == "") {
    alert("이름을 입력하세요.");
    return false;
  }
  if(password == "" && chk_pass =="" && name !=""){
    $("#PassSpanTd").hide();
    name_update();
    return false;
  }

  if($("#cert_pass").val() == "false"){
    alert("비밀번호를 확인하세요.");
    return false;
  }else{
    if(password != chk_pass){
      alert("비밀번호를 확인하세요.");
      $("#cert_pass").val("false");
      return false;
    }else{
      // var act = "<?php echo site_url(); ?>/account/password_change";
      // $("#password_change_form").attr("action",act);
      // $("#password_change_form").submit();
        $.ajax({
            url: "<?php echo site_url(); ?>/option/change_password",
            type: "POST",
            dataType : "json",
            data: {
              username: id,
              password: password,
              chk_pass: chk_pass
            },
            success: function(result){
              if(result == "true"){
                alert("변경되었습니다.");
                close_div();
              }
            }
          })
    }
  }
}

function password_popup(){
  $("#pass_div").bPopup({
    modalClose: false
  })
  $("#mail_password").focus();
}

function close_div(){
  $("#mail_password").val("");
  $("#chk_password").val("");
  $("#PassSpanTd").hide();
  $('#pass_div').bPopup().close();
}

$("#mail_password, #chk_password").blur(function(){
  // var passlength = $("#add_pass").val().length;

  var password = $("#mail_password").val();
  var chk_pass = $("#chk_password").val();
  if(password == "" && chk_pass ==""){
    $("#PassSpanTd").hide();
    $("#cert_pass").val("false");
    return false;
  }
  if(password == "" && chk_pass !=""){
    $("#PassSpanTd").show();
    $("#password_span").html("비밀번호를 입력하세요");
    $("#password_span").css({"color":"red"});
    $("#cert_pass").val("false");
    return false;
  }

  var passwordRules = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,16}$/;
  if(!passwordRules.test(password)){
    $("#PassSpanTd").show();
    $("#password_span").html("숫자, 특문 각 1자 포함하여 8~16자리로 입력하세요");
    $("#password_span").css({"color":"red"});
    $("#cert_pass").val("false");
  }else{
    $("#PassSpanTd").hide();
    $("#password_span").html("");
    $("#cert_pass").val("true");
  }
})


</script>
</html>
