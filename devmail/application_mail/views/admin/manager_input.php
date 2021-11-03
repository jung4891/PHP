<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/admin_side.php";
 ?>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/style.css" type="text/css" charset="utf-8"/>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/admin.css" type="text/css" charset="utf-8"/>


 <div id="main_contents" align="center">
   <form id="mform" name="mform" method="post">
     <input type="hidden" id="cert_id" value="">
     <input type="hidden" id="cert_pass" value="">

  <div class="main_div">
    <table class="contents_tbl"  border="0" cellspacing="0" cellpadding="0" style="width:50%;">
      <colgroup>
        <col width="30%">
        <col width="40%">
        <col width="30%">
      </colgroup>
      <tr>
        <th colspan="3">관리자 등록</th>
      </tr>
      <tr>
        <td align="right">계정이름</td>
        <td align="center">
          <input type="text" class="input_basic input_search" id="mail_id" name="mail_id" value="" style="width:90%">
        </td>
        <td align="left">
          @
          <select class="select_basic" id="mail_domain" name="mail_domain">
  <?php foreach ($domain_list as $dl) { ?>

              <option value="<?php echo $dl->domain; ?>"><?php echo $dl->domain; ?></option>
  <?php } ?>
          </select>
        </td>
      </tr>
      <tr id="IdSpanTd" style="display:none;">
        <td></td>
        <td colspan="2">
          <span id="id_span"></span>
        </td>
      </tr>
      <tr>
        <td align="right">패스워드</td>
        <td align="center">
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
        <td></td>
        <td colspan="2">
          <span id="password_span"></span>
        </td>
      </tr>
      <tr>
        <td align="right">이름</td>
        <td align="center">
          <input type="text" class="input_basic input_search" name="user_name" value="" style="width:90%">
        </td>
        <td></td>
      </tr>
      <!-- <tr>
        <td align="right">도메인</td>
        <td>
        <label><input type="checkbox" id="allcheck_domain" name="check_domain" value="" onclick='selectAll(this)'>ALL</label><br>
  <?php foreach ($domain_list as $dl) { ?>
    <label><input type="checkbox" name="check_domain" value="<?php echo $dl->domain; ?>"><?php echo $dl->domain; ?></label><br>
  <?php } ?>

        </td>
      </tr> -->
      <tr>
        <td colspan="3" align="center">
          <button type="button" class="btn_basic btn_blue" style="width:60px;height:30px;" name="button" onclick="mailbox_submit();">등록</button>
          <button type="button"class="btn_basic btn_sky"  style="width:60px;height:30px;" onclick="history.back();">취소</button>
        </td>
      </tr>
    </table>
  </div>
  </form>
</div>
<script type="text/javascript">
$("#mail_id").keyup(function(){
  var inputVal = $(this).val();
  $(this).val(inputVal.replace(/[^a-z0-9]/gi,''));
})

function dupl_mailcheck(){
  var char_length = $("#mail_id").val().length;
  if($("#mail_id").val()==""){
    $("#IdSpanTd").hide();
    return false;
  }
  if(char_length < 3 || char_length > 20){
    $("#IdSpanTd").show();
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
        url: "<?php echo site_url();?>/admin/manager/dupl_id",
        data: {
          username: mailadress
        },
        success: function(result){
          if(result == "dupl"){
            $("#IdSpanTd").show();
            $("#id_span").html("이미 사용 중인 메일입니다.");
            $("#id_span").css({"color":"red"});
            $("#cert_id").val("false");
          }else{
            $("#IdSpanTd").show();
            $("#id_span").html("사용 가능한 메일입니다.");
            $("#id_span").css({"color":"blue"});
            $("#cert_id").val("true");
          }
        }
})
}
}

function selectAll(selectAll){
  var name = selectAll.name
  const checkboxes
       = document.getElementsByName(name);

  checkboxes.forEach((checkbox) => {
    checkbox.checked = selectAll.checked;
  })
}

function getCheckboxValue(name){
  // 선택된 목록 가져오기
  const query = "input[name='"+name+"']:checked";
  const selectedEls =
      document.querySelectorAll(query);

  // 선택된 목록에서 value 찾기
  let result = '';
  selectedEls.forEach((el) => {
    result += el.value + ' ';
  });

  return result;
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
  var input_pass = $("#mail_password").val();
  var check_pass = $("#chk_password").val();
  var cert_id = $("#cert_id").val();
  var cert_pass = $("#cert_pass").val();


  if(input_id ==""){
    alert("아이디를 입력해주세요");
    return false;
  }

  if(input_pass ==""){
    alert("패스워드를 입력해주세요");
    return false;
  }

  if(check_pass ==""){
    alert("패스워드확인을 입력해주세요");
    return false;
  }

  if(check_pass != input_pass){
    alert("패스워드가 일치하지 않습니다.");
    return false;
  }

  if(cert_id =="false"){
    alert("아이디를 확인해주세요.")
    return false;
  }
  if(cert_pass =="false"){
    alert("패스워드를 확인해주세요.")
    return false;
  }

  var act = "<?php echo site_url();?>/admin/manager/add_admin_action";
  $("#mform").attr('action', act);
  $("#mform").submit();
}



</script>


<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_footer.php";
 ?>
