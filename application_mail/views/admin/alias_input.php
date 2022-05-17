<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/admin_side.php";
 ?>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/style.css" type="text/css" charset="utf-8"/>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/admin.css" type="text/css" charset="utf-8"/>
  <link rel="stylesheet" href="<?php echo $misc; ?>css/jquery.tag-editor.css" type="text/css" charset="utf-8"/>
 <script src="<?php echo $misc; ?>js/jquery.caret.min.js" type="text/javascript" charset="utf-8"></script>
 <script src="<?php echo $misc; ?>js/jquery.tag-editor.js" type="text/javascript" charset="utf-8"></script>
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

#select_tbl td{
  border-bottom: 1px solid #DFDFDF;
}

#select_tbl td:not(:first-child){
  border-left: 1px solid #DFDFDF;
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

/* input.ui-autocomplete-input{
  outline: 1px solid black;
} */

/* color tags */
.tag-editor .red-tag .tag-editor-tag { color: #c65353; background: #ffd7d7; }
.tag-editor .red-tag .tag-editor-delete { background-color: #ffd7d7; }
.tag-editor .green-tag .tag-editor-tag { color: #45872c; background: #e1f3da; }
.tag-editor .green-tag .tag-editor-delete { background-color: #e1f3da; }

.ui-autocomplete {
max-height: 200px;
overflow-y: auto;
/* prevent horizontal scrollbar */
overflow-x: hidden;
}
/* IE 6 doesn't support max-height
* we use height instead, but this forces the menu to always be this tall
*/
* html .ui-autocomplete {
height: 200px;
}

.tag-editor{
  border: 1px solid #DFDFDF;
}

</style>

<?php
isset($mail_address)?$input_mode="modify" : $input_mode = "insert";
 ?>
 <div id="main_contents" align="center">
   <div class="sub_div" align="left" style="">
     <span style="font-size:20px;font-weight:bold;"><?php echo ($input_mode=="modify") ? "그룹메일 수정" : "그룹메일 등록"; ?></span>
   </div>
   <form id="mform" name="mform" method="post">
     <input type="hidden" id="cert_id" value="">
     <input type="hidden" name="input_mode" value="<?php echo $input_mode; ?>">
  <div class="main_div">
    <table class="add_tbl"  border="0" cellspacing="0" cellpadding="0" style="width:90%;">
      <colgroup>
        <col width="10%">
        <col width="90%">
      </colgroup>
      <tr>
        <th align="left">&nbsp;&nbsp;&nbsp;계정 이름</th>
        <td align="left">&nbsp;&nbsp;&nbsp;
<?php
  if($input_mode == "modify"){
      echo $mail_address;

      ($alias_active == 1) ? $check_active = " checked" : $check_active = "";

?>
  <input type="hidden" name="mail_id" value="<?php echo $mail_address; ?>">
  <span style="margin-left:20px;">활성화 :&nbsp;&nbsp;</span>
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
    </table>
  </div>
  <div class="">
    <table width="90%" border="0" cellspacing="0" cellpadding="0" style="width:90%;border-bottom:1px solid #DFDFDF;">
      <colgroup>
        <col width="47%">
        <col width="47%">
      </colgroup>
    <tr>
      <td>
        <button type="button" class="btn_basic btn_white" name="button">MailBox</button>
        <!-- <button type="button" name="button">Biz</button> -->
        <input type="text" class="input_basic input_search" id ="serarch_input" name="" value="" placeholder="검색하세요" autocomplete="off">
        <div style="max-height:30vh;min-height:30vh; overflow-y:scroll;" id="selecting_div">
          <table id="select_tbl" cellspacing="0" style="width:100%;">
            <colgroup>
              <col width="70%">
              <col width="30%">
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
          <input type="text" name="goto_mail" id="goto_mail" value="<?php echo ($input_mode=="modify") ? $goto_text : ""; ?>">
        </div>
      </td>
    </tr>
  </table>
  </div>
  <div class="" align="right" style="width:90%;margin-top:30px;">
    <button type="button" class="btn_basic btn_blue" name="button" style="width:60px;" onclick="mailbox_submit();">
      <?php echo ($input_mode=="modify") ? "수정" : "등록"; ?>
    </button>
    <button type="button" style="width:60px;" class="btn_basic btn_sky" onclick="history.back();">취소</button>
  </div>
  </form>
</div>
<script type="text/javascript">


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
    console.log(mailadress);
    $.ajax({
        type: "POST",
        dataType : "json",
        url: "<?php echo site_url();?>/admin/mailbox/dupl_mailbox",
        data: {
          username: mailadress
        },
        success: function(result){
          console.log(result);
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
  // var mail_length = $("input[name='selected_input[]']").length;
  // if(mail_length <= 1 && $("input[name='selected_input[]']").val() == ""){
  //   alert("수신메일을 입력해주세요.");
  //   return false;
  // }

  // $("input[name='selected_input[]']").each(function(){
  //    var address = $(this).val();
  //    if(address ==""){
  //      $(this).val(null);
  //    }else{
  //      var mail_regexp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
  //      if(!mail_regexp.test(address)){
  //        alert("수신메일을 확인해주세요.");
  //        $(this).focus();
  //        return false;
  //      }
  //    }
  // })
  var red_length = $(".red-tag").length;
  if(red_length > 0){
    alert("대상 메일 주소를 확인해주세요.");
    return false;
  }
  var goto_mail = $('#goto_mail').tagEditor('getTags')[0].tags;
  $("#goto_mail").val(goto_mail);
  if(goto_mail == ""){
    alert("대상 메일 주소를 입력해주세요.");
    return false;
  }

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






$(document).on("click", "#select_tbl tr", function () {
  var mailaddress = $(this).find("td:first-child").html();

$('#goto_mail').tagEditor('addTag', mailaddress);
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

const lmtp_mail = ["durianit.co.kr", "durianit.com", "durianict.co.kr", "the-mango.co.kr", "the-mango.com"];
const mailRegExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
<?php
 $mailbox_arr = array();
 foreach ($goto_list as $gl) {
   array_push($mailbox_arr, $gl->address);
} ?>
var addtag = $('#goto_mail').tagEditor({
    autocomplete: {
        delay: 0, // show suggestions immediately
        position: { collision: 'flip' }, // automatic menu position up/down
        // source: ['bhkim@durianit.co.kr', 'test2@durianict.co.kr', 'test3@durianict.co.kr', 'asf', 'test']
        source: <?php echo json_encode($mailbox_arr); ?>

    },
    forceLowercase: false,
    removeDuplicates: false,
//     onChange: function(field, editor, tags, val) {
//       console.log(field);
//       console.log(editor);
//       console.log(tags);
//       console.log($(this));
//       // $(editor).find('.tag-editor-tag').addClass('red-tag');
//     //   $(editor).each(function(){
//     //     var li = $(this);
//     //     li.addClass('red-tag');
//     // });
//     // $('#response').prepend(
//     //     'Tags changed to: ' + (tags.length ? tags.join(', ') : '----') + '<hr>'
//     // );
//       alert("zzzz");
// },
    onChange: email_check
    // beforeTagSave: function(field, editor, tags, tag, val) {
    //   if(tag != ""){
    //     $(editor).find('.active').addClass('red-tag');
    //   }
    // }
});

$(".tag-editor").on("focus", "input", function () {
  $(this).closest("li").removeClass('check-y');
});

function email_check(field, editor, tags) {
    const err1 = "메일 형식에 맞지 않습니다.";
    const err2 = "해당 메일박스가 존재하지 않습니다.";
    $(editor).find('li:not(".check-y")').each(function(index){
        if(index == 0){
          return true;
        }
        var li = $(this);
        var li_val = li.find('.tag-editor-tag').text();
        if (li_val.indexOf("<") !== -1){
          li_val = li_val.split("<")[1];
          li_val = li_val.substr(0, li_val.length-1);
        }

        if (li_val.match(mailRegExp) != null) {
          var split = li_val.split("@")[1].trim();
          if (lmtp_mail.indexOf(split) !== -1) {
            console.log(li_val);
            $.ajax({
                 url: "<?php echo site_url(); ?>/mail_write/lmtp_valid",
                 type: 'post',
                 dataType: 'json',
                 data: {
                   mail : li_val
                 },
                 async: false,
                 success: function (result) {
                   // console.log(result);
                   // console.log(`cnt는 ${result}`);
                    if (result == 1) {
                      li.removeClass('red-tag');
                      li.addClass('check-y');


                    } else {
                      li.removeClass('check-y');
                      li.addClass('red-tag');
                      li.attr('title', err2);
                    }
                 }
              });

          } else {
            li.removeClass('red-tag');
            li.addClass('check-y');
          }
        } else {
          li.removeClass('check-y');
          li.addClass('red-tag');
          li.attr('title', err1);
        }

    });
}

//jquery ui type MSIE 에러 잡는 코드
jQuery.browser = {};
  (function () {
      jQuery.browser.msie = false;
      jQuery.browser.version = 0;
      if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
          jQuery.browser.msie = true;
          jQuery.browser.version = RegExp.$1;
      }
  })();

</script>


<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>
