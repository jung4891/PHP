<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/admin_side.php";
 ?>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/style.css" type="text/css" charset="utf-8"/>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/admin.css" type="text/css" charset="utf-8"/>


 <div id="main_contents" align="center">
   <div class="sub_div" align="left" style="">
     <span style="font-size:20px;font-weight:bold;">도메인 등록</span>
   </div>
   <form id="mform" name="mform" method="post">
     <input type="hidden" id="cert_id" value="">
     <input type="hidden" id="cert_pass" value="">

  <div class="main_div">
    <table class="add_tbl"  border="0" cellspacing="0" cellpadding="0" style="width:90%;">
      <colgroup>
        <col width="10%">
        <col width="90%">
      </colgroup>
      <tr>
        <th align="left">&nbsp;&nbsp;&nbsp;도메인</th>
        <td align="left">&nbsp;&nbsp;&nbsp;
          <input type="text" class="input_basic input_search" id="domain_id" name="domain_id" value="" style="width:300px;">
        </td>

      </tr>
      <tr id="IdSpanTd" style="display:none;">

        <td colspan="2">
          <span id="id_span"></span>
        </td>
      </tr>
      <tr>
        <th align="left">&nbsp;&nbsp;&nbsp;설명</th>
        <td align="left">&nbsp;&nbsp;&nbsp;
          <input type="text" class="input_basic input_search" id="description" name="description" value="" style="width:300px;">
        </td>

      </tr>
      <tr>
        <th align="left">&nbsp;&nbsp;&nbsp;Aliases 개수</th>
        <td align="left">&nbsp;&nbsp;&nbsp;
          <input type="number" class="input_basic input_search" name="alias_len" value="500" min='0' max='1000' step='100' style="width:300px;">
        </td>

      </tr>
      <tr id="PassSpanTd" style="display:none;">
        <td colspan="2">
          <span id="password_span"></span>
        </td>
      </tr>
      <tr>
        <th align="left">&nbsp;&nbsp;&nbsp;메일박스 개수</th>
        <td align="left">&nbsp;&nbsp;&nbsp;
          <input type="number" class="input_basic input_search" name="box_len" value="500" min='0' max='1000' step='100' style="width:300px">
        </td>
      </tr>
      <tr>
        <th align="left">&nbsp;&nbsp;&nbsp;최대 용량</th>
        <td align="left">&nbsp;&nbsp;&nbsp;
          <input type="number" class="input_basic input_search" name="maxquota" value="50000" min='0' max='1000000' step='10000' style="width:300px;">&nbsp;MB
        </td>
      </tr>
      <!-- <tr>
        <td align="right">전달방식</td>
        <td align="center">
          <select name="delivery" class="select_basic" style="width:92%">
            <option value="virtual">virtual</option>
            <option value="local">local</option>
            <option value="relay">relay</option>
          </select>
        </td>
        <td></td>
      </tr> -->

    </table>
  </div>
  <div class="" align="right" style="width:90%;margin-top:30px;">
    <button type="button" class="btn_basic btn_blue" style="width:60px;height:30px;" name="button" onclick="domain_submit();">등록</button>
    <button type="button"class="btn_basic btn_sky"  style="width:60px;height:30px;" onclick="history.back();">취소</button>
  </div>
  </form>
</div>
<script type="text/javascript">
$("#domain_id").keyup(function(){
  var inputVal = $(this).val();
  $(this).val(inputVal.replace(/[^a-z0-9-_.]/gi,''));
})

function dupl_domaincheck(){
  var char_length = $("#domain_id").val().length;
  if($("#domain_id").val()==""){
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
    var domain = $("#domain_id").val().trim();
    $.ajax({
        type: "POST",
        dataType : "json",
        url: "<?php echo site_url();?>/admin/domain/dupl_domain",
        data: {
          domain: domain
        },
        success: function(result){
          if(result == "dupl"){
            $("#IdSpanTd").show();
            $("#id_span").html("이미 등록된 도메인입니다.");
            $("#id_span").css({"color":"red"});
            $("#cert_id").val("false");
          }else{
            $("#IdSpanTd").hide();
            // $("#id_span").html("사용 가능한 도메인입니다.");
            // $("#id_span").css({"color":"blue"});
            // $("#cert_id").val("true");
          }
        }
})
}
}

$("#domain_id").blur(function(){
  dupl_domaincheck();
})



// $("#mail_password, #chk_password").blur(function(){
//   // var passlength = $("#add_pass").val().length;
//
//   var password = $("#mail_password").val();
//   var chk_pass = $("#chk_password").val();
//   if(password == "" && chk_pass ==""){
//     $("#PassSpanTd").hide();
//     return false;
//   }
//   if(password == "" && chk_pass !=""){
//     $("#PassSpanTd").show();
//     $("#password_span").html("비밀번호를 입력하세요");
//     $("#password_span").css({"color":"red"});
//     $("#cert_pass").val("false");
//     return false;
//   }
//
//   var passwordRules = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,16}$/;
//   if(!passwordRules.test(password)){
//     $("#PassSpanTd").show();
//     $("#password_span").html("숫자, 특문 각 1자 포함하여 8~16자리로 입력하세요");
//     $("#password_span").css({"color":"red"});
//     $("#cert_pass").val("false");
//   }else{
//     $("#PassSpanTd").hide();
//     $("#password_span").html("");
//     $("#cert_pass").val("true");
//   }
// })


function domain_submit(){
  var domain_id = $("#domain_id").val();
  var cert_id = $("#cert_id").val();


  if(domain_id ==""){
    alert("도메인을 입력해주세요");
    return false;
  }


  if(cert_id =="false"){
    alert("도메인을 확인해주세요.")
    return false;
  }


  var act = "<?php echo site_url();?>/admin/domain/domain_add_action";
  $("#mform").attr('action', act);
  $("#mform").submit();
}



</script>


<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>
