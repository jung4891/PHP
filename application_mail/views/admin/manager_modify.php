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
   <form id="modify_form" name="modify_form" method="post">
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
        <th colspan="3">관리자 수정</th>
      </tr>
      <tr>
        <td align="right">계정이름</td>
        <td align="center">
          <?php echo $admin_info->username; ?>
          <input type="hidden" class="input_basic input_search" id="modify_user" name="modify_user" value="<?php echo $admin_info->username; ?>" style="width:90%">
        </td>
        <td align="left">
        </td>
      </tr>

      <tr>
        <td align="right">패스워드</td>
        <td align="center">
          <input type="password" class="input_basic input_search" id="modify_pass" name="modify_pass" value="" style="width:90%">
        </td>
        <td></td>
      </tr>
      <tr>
        <td align="right">패스워드 확인</td>
        <td align="center">
          <input type="password" class="input_basic input_search" id="chk_pass" name="chk_pass" value="" style="width:90%">
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
        <?php if($admin_info->active == 1){
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
      <!-- <tr>
        <td align="right">이름</td>
        <td align="center">
          <input type="text" class="input_basic input_search" name="user_name" value="" style="width:90%">
        </td>
        <td></td>
      </tr> -->
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
          <button type="button" class="btn_basic btn_blue" style="width:60px;height:30px;" name="button" onclick="modify_action();">수정</button>
          <button type="button"class="btn_basic btn_sky"  style="width:60px;height:30px;" onclick="history.back();">취소</button>
        </td>
      </tr>
    </table>
  </div>
  </form>
</div>
<script type="text/javascript">



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



$("#modify_pass, #chk_pass").blur(function(){
  // var passlength = $("#add_pass").val().length;

  var password = $("#modify_pass").val();
  var chk_pass = $("#chk_pass").val();
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


function modify_action(){

  var input_pass = $("#modify_pass").val();
  var check_pass = $("#chk_pass").val();
  var cert_pass = $("#cert_pass").val();
  if($("#chk_active").is(":checked")){
    $("#chk_active").val("1");
  }else{
    $("#chk_active").val("0");
  }

  if($("#chk_domain").is(":checked")){
    $("#hidden_domain").val("all");
  }else{
    $("#hidden_domain").val("");
  }
  if(input_pass!=""){
    if(check_pass != input_pass){
      alert("패스워드가 일치하지 않습니다.");
      return false;
    }

    if(cert_pass == ""){
      alert("패스워드를 확인하세요.");
      return false;
    }

  }

  var act = "<?php echo site_url();?>/admin/manager/modify_action";
  $("#modify_form").attr('action', act);
  $("#modify_form").submit();
}



</script>


<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>
