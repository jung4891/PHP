<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>
 <link rel="stylesheet" href="<?php echo $misc; ?>/css/style.css" type="text/css" charset="utf-8"/>

 <style>
   #nav_tbl td{
     min-width: 100px;
     height: 30px;
     border: 1px solid black;
     text-align: center;
     cursor: pointer;
   }
   #sign_list{
     width: 100%;
   }


   #sign_list td{
     border-bottom: 1px solid #e2e2e2;
   }

   .sign_tr{
     cursor: pointer;
   }
   /* .sign_tr:hover{
     background-color: #FAFAFA;
   } */

   .sign_selected{
     background-color: #e3e3e3;
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

  <div id="main_contents" align="center">
    <form name="mform" action="" method="post">
      <div class="" align="left" width=100% style="border-bottom:1px solid #1A8DFF;margin:-10px 40px 10px 40px;">
        <!-- <button type="button" name="button" class="nav_btn select_btn" style="margin-left:10px;"onclick="location.href='<?php echo site_url(); ?>/option/account'">계정설정</button> -->
        <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/mailbox'">메일함설정</button>
        <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/address_book'">주소록관리</button>
        <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/singnature'">서명관리</button>
      </div>
    </form>
      <div class="main_div">
        <table class="contents_tbl"  border="0" cellspacing="0" cellpadding="0" style="width:50%;margin-top:50px;">
          <colgroup>
            <col width="30%">
            <col width="40%">
            <col width="30%">
          </colgroup>
          <tr>
            <th colspan="3"><?php echo $_SESSION["userid"]; ?></th>
          </tr>
          <tr>
            <td align="right">이름</td>
            <td align="center">
              <input type="hidden" id="modify_id" name="modify_id" value="<?php echo $_SESSION["userid"]; ?>">
              <input type="text" name="" style="width:90%;height: 25px;" value="<?php echo $_SESSION['name']; ?>">
            </td>
            <td>
              <button type="button" name="button" class="btn_basic btn_blue"  style="width:60px;height:30px;" onclick="mailbox_submit();">변경</button>
            </td>
          </tr>
          <tr>
            <td></td>
            <td align="center">
              <button type="button" class="btn_basic btn_gray" name="button" style="width:95%" onclick="password_popup();">비밀번호 변경</button>
            </td>
            <td></td>
          </tr>
        </table>
      </div>

      <div id="pass_div" align="center" style="display:none;background-color:white;width:25vw;">
        <form class="" id="password_change_form" action="" method="post">
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
              <button type="button" name="button" class="btn_basic btn_blue"  style="width:60px;height:30px;" onclick="password_change();">확인</button>
              <button type="button" name="button" class="btn_basic btn_sky"  style="width:60px;height:30px;" onclick="close_div();">취소</button>
            </td>
          </tr>
        </table>
      </form>
      </div>

  </div>



<script type="text/javascript">
// $(function (){
//
// })
function password_change(){
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
      $("#password_change_form").attr("action","<?php echo site_url(); ?>/account/password_change");
      $("#password_change_form").submit();
        // $.ajax({
        //     url: "<?php echo site_url(); ?>/account/password_change",
        //     type: "POST",
        //     dataType : "json",
        //     data: {
        //       username: id,
        //       password: password,
        //       chk_pass: chk_pass
        //     },
        //     success: function(result){
        //       console.log(result);
        //       if(result){
        //         alert("변경되었습니다.");
        //         close_div();
        //       }
        //     }
        //   })
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

<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>