<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/admin_side.php";
 ?>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/style.css" type="text/css" charset="utf-8"/>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/admin.css" type="text/css" charset="utf-8"/>
<style>
#selected_div li{
  list-style: none;
}

#selected_div input{
  width:50px;
  max-width:90%;
  box-sizing : border-box;
}

#select_tbl tr:hover {
  background-color: #f5ffff;
}
/* .mail_selected{
  background-color:#c9f2f5;

} */
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

<?php
isset($mail_address)?$input_mode="modify" : $input_mode = "insert";
 ?>
 <div id="main_contents" align="center">
   <form id="mform" name="mform" method="post">
     <input type="hidden" id="cert_id" value="">
     <input type="hidden" name="input_mode" value="<?php echo $input_mode; ?>">
  <div class="main_div">
    <table class="contents_tbl"  border="0" cellspacing="0" cellpadding="0" style="width:70%;">
      <colgroup>
        <col width="30%">
        <col width="40%">
        <col width="30%">
      </colgroup>
      <tr>
        <th colspan="3">
          <?php echo ($input_mode=="modify") ? "그룹메일 수정" : "그룹메일 등록"; ?>
        </th>
      </tr>
      <tr>
        <td colspan="3" align="left">계정이름
<?php
  if($input_mode == "modify"){
      echo " : ".$mail_address;

      ($alias_active == 1) ? $check_active = " checked" : $check_active = "";

?>
  <input type="hidden" name="mail_id" value="<?php echo $mail_address; ?>">
  <span style="margin-left:20px;">활성화 :</span>
  <label class="switch">
  <input type="checkbox" id="check_active" name="check_active" value="" <?php echo $check_active ?>>
  <span class="slider round"></span>
  </label>

<?php
  }else{
?>
<input type="text" class="input_basic input_search" id="mail_id" name="mail_id" value="" style="width:10vw">@
<select class="select_basic" id="mail_domain" name="mail_domain" >
  <?php foreach ($domain_list as $dl) { ?>

    <option value="<?php echo $dl->domain; ?>"><?php echo $dl->domain; ?></option>
  <?php } ?>
</select>
<span id="id_span"></span>
<?php
  }
?>

        </td>
      </tr>
      <!-- <tr id="IdSpanTd" style="display:none;">
        <td></td>
        <td colspan="2">
        </td>
      </tr> -->

      <!-- <tr>
        <td align="right">이름</td>
        <td align="center">
          <input type="text" name="user_name" value="" style="width:90%">
        </td>
        <td></td>
      </tr> -->
      <tr>
        <td colspan="3">
            <table width="100%" border="1" cellspacing="0" cellpadding="0">
              <colgroup>
                <col width="47%">
                <col width="47%">
              </colgroup>
            <tr>
              <td>
                <button type="button" class="btn_basic btn_white" name="button">MailBox</button>
                <!-- <button type="button" name="button">Biz</button> -->
                <input type="text" class="input_basic input_search" id ="serarch_input" name="" value="" placeholder="검색하세요">
                <div style="max-height:30vh;min-height:30vh; overflow-y:scroll;" id="selecting_div">
                  <table id="select_tbl" cellspacing="0">
                    <colgroup>
                      <col width="80%">
                      <col width="20%">
                    </colgroup>
<?php foreach ($goto_list as $gl) { ?>
                      <tr>
                        <td style="height:30px;"><?php echo $gl->address; ?></td>
                        <td style="height:30px;"><?php echo $gl->name; ?></td>
                      </tr>
<?php } ?>

                  </table>
                </div>
              </td>
              <td style="vertical-align:top;">
                <div class="">
                <button type="button" class="btn_basic btn_white" name="button" style="cursor:default;">대상</button>
                </div>
                <div style="max-height:30vh; width:100%;overflow-y:scroll;" id="selected_div">
<?php
if($input_mode == "modify"){
  foreach ($goto as $go) {
?>
                    <input type="text" name="selected_input[]" value="<?php echo $go; ?>">
<?php
  }
  ?>
                    <input type="text" name="selected_input[]" value="">
  <?php
}else{
?>
                    <input type="text" name="selected_input[]" value="">
<?php } ?>

                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="3" align="center">
          <button type="button" class="btn_basic btn_blue" name="button" style="width:60px;" onclick="mailbox_submit();">
            <?php echo ($input_mode=="modify") ? "수정" : "등록"; ?>
          </button>
          <button type="button" style="width:60px;" class="btn_basic btn_sky" onclick="history.back();">취소</button>
        </td>
      </tr>
    </table>
  </div>
  </form>
</div>
<script type="text/javascript">
<?php if($input_mode == "modify"){ ?>
$(function(){
  $("input[name='selected_input[]']").each(function(){
    $(this).keydown();
  });
});
<?php
}
?>

$("#mail_id").keyup(function(){
  var inputVal = $(this).val();
  $(this).val(inputVal.replace(/[^a-z0-9_-]/gi,''));
})

function dupl_mailcheck(){
  var char_length = $("#mail_id").val().length;
  if($("#mail_id").val()==""){
    $("#id_span").hide();
    return false;
  }
  if(char_length < 3 || char_length > 20){
    $("#id_span").show();
    $("#id_span").html("3~20자의 영문, 숫자만 사용 가능합니다.");
    $("#id_span").css({"color":"red"});
    $("#cert_id").val("false");
    return false;
  }else{
    var mail = $("#mail_id").val().trim();
    var domain = $("#mail_domain option:selected").val();
    var mailadress = mail+"@"+domain;
    $.ajax({
        type: "POST",
        dataType : "json",
        url: "<?php echo site_url();?>/admin/mailbox/dupl_mailbox",
        data: {
          username: mailadress
        },
        success: function(result){
          if(result == "dupl"){
            $("#id_span").show();
            $("#id_span").html("이미 사용 중인 메일입니다.");
            $("#id_span").css({"color":"red"});
            $("#cert_id").val("false");
          }else{
            $("#id_span").show();
            $("#id_span").html("사용 가능한 메일입니다.");
            $("#id_span").css({"color":"blue"});
            $("#cert_id").val("true");
          }
        }
})
}
}

$("#mail_id").blur(function(){
  dupl_mailcheck();
})

$("#mail_domain").change(function(){
  dupl_mailcheck();
})



$("#mail_password, #chk_password").blur(function(){
  // var passlength = $("#add_pass").val().length;

  var password = $("#mail_password").val();
  var chk_pass = $("#chk_password").val();
  if(password == "" && chk_pass ==""){
    $("#PassSpanTd").hide();
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
  var input_id = $("#mail_id").val();
  var cert_id = $("#cert_id").val();


  if(input_id ==""){
    alert("계정이름을 입력해주세요");
    return false;
  }

  if(cert_id =="false"){
    alert("계정이름을 확인해주세요.")
    return false;
  }
  var mail_length = $("input[name='selected_input[]']").length;
  if(mail_length <= 1 && $("input[name='selected_input[]']").val() == ""){
    alert("수신메일을 입력해주세요.");
    return false;
  }

  $("input[name='selected_input[]']").each(function(){
     var address = $(this).val();
     if(address ==""){
       $(this).val(null);
     }else{
       var mail_regexp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
       if(!mail_regexp.test(address)){
         alert("수신메일을 확인해주세요.");
         $(this).focus();
         return false;
       }
     }
  })
<?php if($input_mode == "modify"){ ?>
  var checked = $("#check_active").is(":checked");
  if(checked){
    $("#check_active").val(1);
  }else{
    $("#check_active").val(0);
  }

<?php } ?>
  var act = "<?php echo site_url();?>/admin/alias/alias_add_action";
  $("#mform").attr('action', act);
  $("#mform").submit();
}

$(document).on("keydown", "#selected_div input", function (){
    var value = $(this).val();
    $("#mform").append('<div id="virtual_dom" style="display: inline-block">' + value + '</div>');

      var inputWidth =  $('#virtual_dom').width() + 10;
      if(inputWidth > 50){
        $(this).css('width', inputWidth);

      }
      $('#virtual_dom').remove();

});

$(document).on("blur", "#selected_div input", function () {
  // var value = $(this).val();
  // if(value != ""){
  //   var input = "<li><input type='text' name='selected_input' value=''></li>"
  //
  //   var par = $(this).closest("div");
  //   par.append(input);
  //   $("input[name=selected_input]").last().focus();
  // }else{
  //
  // }
  input_check();
})

function input_check(){
  var input_val = $("input[name='selected_input[]']").last().val();

  if(input_val !=""){
    var input = "<input type='text' name='selected_input[]' value=''>";
    $("#selected_div").append(input);
    $("input[name='selected_input[]']").last().focus();
  }

}

$(document).on("keyup", "#selected_div input:not(:first)", function (event) {
  var value = $(this).val();
  if(value == ""){
        if(event.keycode == 8 || event.which == 8){
          var prev = $(this).prev();
          var prevval = prev.val();
          $(this).remove();

          prev.focus();
          prev.val("");
          prev.val(prevval);
          // $("input[name=selected_input]").last().focus();

    }

  }
})

$(document).on("keydown", "#selected_div input", function (event) {

  if(event.keycode == 13 || event.which == 13 || event.keycode == 188 || event.which == 188){
    input_check();
  }
})

$(document).on("click", "#select_tbl tr", function () {
    var mailaddress = $(this).find("td:first-child").html();
    $("#mform").append('<div id="virtual_dom" style="display: inline-block">' + mailaddress + '</div>');
    var inputWidth =  $('#virtual_dom').width() + 10;
    $('#virtual_dom').remove();
    var input = "<input type='text' name='selected_input[]' value='"+mailaddress+"' style='width:"+inputWidth+"px;' autofocus>";
    var lastinput = $("#selected_div input:last");
    lastinput.before(input);
    lastinput.focus();
  });

$("#serarch_input").keyup(function(){
  var keyword = $(this).val();
  $.ajax({
      type: "POST",
      dataType : "json",
      url: "<?php echo site_url();?>/admin/alias/search_alias",
      data: {
        keyword: keyword
      },
      success: function(result){
        console.log(result);
        if(result.length >= 1){
          $("#select_tbl tr").remove();
          for (var i = 0; i < result.length; i++) {
            var html = "<tr><td style='height:30px;width:80vw;'>"+result[i].address+"</td><td style='height:30px;width:20vw;'>"+result[i].name +"</td></tr>";
            $("#select_tbl tbody").append(html);
          }
        }

      }
    })
})

</script>


<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_footer.php";
 ?>
