<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/admin_side.php";
 ?>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/style.css" type="text/css" charset="utf-8"/>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/admin.css" type="text/css" charset="utf-8"/>
<style media="screen">
.switch {
  position: relative;
  display: inline-block;
  width: 55px;
  height: 27px;
  vertical-align:middle;
}

/* Hide default HTML checkbox */
.switch input {
  display:none;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

 <div id="main_contents" align="center">
   <form id="mform" name="mform" method="post">


  <div class="main_div">
    <table class="contents_tbl"  border="0" cellspacing="0" cellpadding="0" style="width:50%;">
      <colgroup>
        <col width="30%">
        <col width="40%">
        <col width="30%">
      </colgroup>
      <tr>
        <th colspan="3">메일박스 수정</th>
      </tr>
      <tr>
        <td align="right">계정이름</td>
        <td align="center" conspan="2">
          <input type="hidden" id="modify_id" name="modify_id" value="<?php echo $modify_data->username; ?>">
          <?php echo $modify_data->username; ?>
        </td>
      </tr>
      <tr>
        <td></td>
        <td align="center">
          <button type="button" class="btn_basic btn_gray" name="button" style="width:95%" onclick="password_popup();">비밀번호 재발급</button>
        </td>
        <td></td>
      </tr>
      <tr>
        <td align="right">이름</td>
        <td align="center">
          <input type="text" class="input_basic input_search" name="user_name" value="<?php echo $modify_data->name; ?>" style="width:90%">
        </td>
        <td></td>
      </tr>
      <tr>
        <td align="right">용량</td>
        <td align="center">
          <input type="number" class="input_basic input_search" id="quota" name="quota" min='10000' max='100000' step='10000' value="<?php echo $modify_data->quota / 1024000; ?>" style="width:90%">
        </td>
        <td>mb</td>
      </tr>
      <tr>
        <?php if($modify_data->active == 1){
          $active = " checked";
        } else {
          $active ="";
        }?>
        <td align="right">활성화</td>
        <td>
          <label class="switch" style="margin-left:10px;">
  <input type="checkbox" id="chk_active" name="chk_active" value="" <?php echo $active; ?>>
          <span class="slider round"></span>
          </label>
        <td>

      </tr>
      <tr>
        <td colspan="3" align="center">
          <button type="button" name="button" class="btn_basic btn_blue"  style="width:60px;height:30px;" onclick="mailbox_submit();">수정</button>
          <button type="button" class="btn_basic btn_sky"  style="width:60px;height:30px;" onclick="history.back();">뒤로</button>
        </td>
      </tr>
    </table>
  </div>
  </form>
</div>


<div id="pass_div" align="center" style="display:none;background-color:white;width:25vw;">
  <table class="contents_tbl"  border="0" cellspacing="0" cellpadding="0" style="width:80%;align:center;">
    <tr>
      <th colspan="3" align="center">
        패스워드 변경
      </th>
    </tr>
    <tr>
      <td align="right">패스워드</td>
      <td align="center">
        <input type="hidden" id="cert_pass" value="false">
        <input type="password" class="input_basic input_search" id="mail_password" name="mail_password" value="" style="width:90%">
      </td>
      <td></td>
    </tr>
    <tr>
      <td align="right">패스워드 확인</td>
      <td align="center">
        <input type="password" class="input_basic input_search" id="chk_password" name="chk_password" value="" style="width:90%">
      </td>
      <td></td>
    </tr>
    <tr id="PassSpanTd" style="display:none;">
      <td colspan="3" align="center">
        <span id="password_span"></span>
      </td>
    </tr>
    <tr>
      <td colspan="3" align="center">
        <button type="button" name="button" class="btn_basic btn_blue"  style="width:60px;height:30px;" onclick="change_pass();">확인</button>
        <button type="button" name="button" class="btn_basic btn_sky"  style="width:60px;height:30px;" onclick="close_div();">취소</button>
      </td>
    </tr>
  </table>
</div>
<script type="text/javascript">


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


function mailbox_submit(){
  if($("#chk_active").is(":checked")){
    $("#chk_active").val(1);
  }else{
    $("#chk_active").val(0);
  }

  if($("#quota").val() == ""){
    $("#quota").val(30000);
  }
  var act = "<?php echo site_url();?>/admin/mailbox/mail_modify_action";
  $("#mform").attr('action', act);
  $("#mform").submit();
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

function change_pass(){
  var id = $("#modify_id").val();
  var password = $("#mail_password").val();
  var chk_pass = $("#chk_password").val();
  if($("#cert_pass").val() == "false"){
    alert("비밀번호를 확인하세요.");
    return false;
  }else{
    if(password != chk_pass){
      alert("비밀번호를 확인하세요.");
      $("#cert_pass").val("false");
      return false;
    }else{
        $.ajax({
            type: "POST",
            dataType : "json",
            url: "<?php echo site_url();?>/admin/mailbox/change_password",
            data: {
              username: id,
              password: password,
              chk_pass: chk_pass
            },
            success: function(result){
              if(result){
                alert("변경되었습니다.");
                close_div();
              }
            }
          })
    }
  }

}


</script>


<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>
