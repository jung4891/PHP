<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css_mango/view_page_common_mango.css">
<style media="screen">
@import url(//fonts.googleapis.com/earlyaccess/notosanskr.css);
html,body{
  font-family:"Noto Sans KR", sans-serif !important;
}
  .register_main{
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .login_input{
    box-sizing: border-box;
    width: 100%;
    height: 40px;
    border-radius: 3px;
    border: 1px solid #DEDEDE;
  }
  .login_table td {
    font-size: 12px;
  }
  .sign_up{
    position: absolute;
    left: 38%;
    transform:translateX(-38%);;
    bottom: 20%
  }
  select{
    box-sizing: border-box;
    width: 128.9px;
    height: 40px;
    border-radius: 3px;
    border: 1px solid #DEDEDE;
  }
  .sign_up_button{
    width: 100%;
    height: 60px;
    border-radius: 5px;
    border: none;
    background-color: #FFC705;
    color: #FFFFFF;
    font-weight:bold;
  }
	.dayBtn {
		background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
	.timeBtn {
		background:url(<?php echo $misc; ?>img/mobile/icon_time.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
</style>
<script language="javascript">
var chkForm = function chkForm() {
  var rv = true;

  var mform = document.cform;
  mform.user_id.value = mform.user_id.value.trim();
  mform.user_password.value = mform.user_password.value.trim();

  if (mform.user_password.value == "") {
    alert("패스워드를 입력하세요.");
    mform.user_password.focus();
    return rv = false;
  }
  if ( !passwordvalidcheck( mform.user_password.value ) ){		//	패스워드 길이가 6보다 작거나, 숫자만 입력된 경우
    alert( "보안수준이 안전한 비밀번호를 입력해 주세요.\n\n(6자 이상의 영문,숫자,특수문자 조합)" );
    mform.user_password.value = "";
    mform.user_passwordconfirm.value = "";
    mform.user_password.focus();
    return rv = false;
  }
  if ( mform.user_passwordconfirm.value == "" ){				//	비밀번호 확인값이 입력되어 있지 않을 경우
    alert( "비밀번호 확인을 입력해 주세요." );
    mform.user_passwordconfirm.value = "";
    mform.user_passwordconfirm.focus();
    return rv = false;
  }

  if ( mform.user_password.value != mform.user_passwordconfirm.value ){	//	비밀번호 값이 다르게 입력된 경우
    alert( "비밀번호 확인이 일치하지 않습니다." );
    mform.user_passwordconfirm.value = "";
    mform.user_passwordconfirm.focus();
    return rv = false;
  }
  if (mform.user_email.value == "") {
    alert("e-mail을 입력하세요.");
    mform.user_email.focus();
    return rv = false;
  }
  if (mform.user_name.value == "") {
    alert("이름을 입력하세요.");
    mform.user_name.focus();
    return rv = false;
  }
  if (mform.user_tel2.value == '') {
    alert('전화번호를 입력하세요.');
    mform.user_tel2.focus();
    return rv = false;
  }

  if(rv) {
    mform.submit();
    return false;
  }
}

$(document).ready(function() {
  $("#user_id, #user_password").keydown(function(key) {
    if (key.keyCode == 13) {
      chkForm();
    }
  });
});

function pw_check() {
  userpassword = document.cform.user_password.value.trim();
  if  ( !passwordvalidcheck( userpassword ) ){		//	패스워드 길이가 6보다 작거나, 숫자만 입력된 경우
    document.getElementById("pw_message").innerHTML = "<span class='error_1'>* 보안낮음</span> <span class='error'>: 6자 이상의 영문,숫자,특수문자 조합만 가능</span>";
  } else{
    document.getElementById("pw_message").innerHTML = "<font color=green><span class='error_2'>* 보안안전</span></font> <span class='error'>: 6자 이상의 영문,숫자,특수문자 조합만 가능</span>";
  }
}


$(document).ready(function(){
var now = new Date();
var year = now.getFullYear();
var mon = (now.getMonth() + 1) > 9 ? ''+(now.getMonth() + 1) : '0'+(now.getMonth() + 1);
var day = (now.getDate()) > 9 ? ''+(now.getDate()) : '0'+(now.getDate());

//년도 selectbox만들기
for(var i = 1900 ; i <= year ; i++) {
  $('#year').append('<option value="' + i + '">' + i + '년</option>');
}
$('#year').append('<option value="test_year" selected="selected">년도</option>');


// 월별 selectbox 만들기
for(var i=1; i <= 12; i++) {
    var mm = i > 9 ? i : "0"+i ;
    $('#month').append('<option value="' + mm + '">' + mm + '월</option>');
}

// 일별 selectbox 만들기
for(var i=1; i <= 31; i++) {
    var dd = i > 9 ? i : "0"+i ;
    $('#day').append('<option value="' + dd + '">' + dd+ '일</option>');
}
$("#year  > option[value="+year+"]").attr("selected", "true");
$("#month  > option[value="+mon+"]").attr("selected", "true");
$("#day  > option[value="+day+"]").attr("selected", "true");

})

// 전화번호 - 자동입력
function inputPhoneNumber(obj) {


  var number = obj.value.replace(/[^0-9]/g, "");
  var phone = "";

  if(number.length < 4) {
    return number;
  } else if(number.length < 7) {
    phone += number.substr(0, 4);
    phone += "-";
    phone += number.substr(4);
  } else {
    phone += number.substr(0, 4);
    phone += "-";
    phone += number.substr(4, 4);
  }
  obj.value = phone;
}
</script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/mango_header.php";
?>
<div align="center">
<div class="dash1-1">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
  <div class="register_main">
    <input type="hidden" id="validate_check" name="" value="false">
    <!-- <?php echo validation_errors();  ?> -->
    <form name="cform" action="<?php echo site_url().'/account/personal_modify_action';?>" method="post" onSubmit="javascript:chkForm();return false;">
      <input type="hidden" name="seq" id="seq" value="<?php echo $seq; ?>">
      <div class="user_info">
        <table class="login_table">
          <tr>
            <th align="left" style="font-size:19px;padding-bottom:20px;padding-top:20px;">회원수정</th>
          </tr>
          <tr>
            <td style="padding-top:10px;font-weight:bold;">아이디</td>
          </tr>
          <tr>
            <td>
              <input type="text" id="user_id" name="user_id" class="login_input" placeholder="3자~12자의 영문,숫자만 사용" autocomplete="off" value="<?php echo $view_val['user_id']; ?>" readonly>
            </td>
          </tr>
          <tr>
            <td>
              <span id="id_message"></span>
            </td>
          </tr>
          <tr>
            <td style="padding-top:10px;font-weight:bold;">비밀번호</td>
          </tr>
          <tr>
            <td>
              <input type="password" id="user_password" name="user_password" class="login_input" placeholder="6자 이상의 영문,숫자,특수문자 조합" onKeyUp="pw_check();" autocomplete="off">
            </td>
          </tr>
          <tr>
            <td>
              <span id="pw_message" style="display:inline"><span class="error_1">* 보안낮음</span> <span class="error">: 6자 이상의 영문,숫자,특수문자 조합만 가능</span></span>
            </td>
          </tr>
          <tr>
            <td height="10" colspan="2"></td>
          </tr>
          <tr>
            <td style="font-weight:bold;">비밀번호 재확인</td>
          </tr>
          <tr>
            <td>
              <input type="password" name="user_passwordconfirm" class="login_input" value="" autocomplete="off" placeholder="비밀번호를 다시 입력하세요.">
            </td>
          </tr>
          <tr>
            <td style="padding-top:10px;font-weight:bold;">이름</td>
          </tr>
          <tr>
            <td><input type="text" name="user_name" class="login_input" value="<?php echo $view_val['user_name']; ?>" placeholder="이름을 입력하세요."></td>
          </tr>
          <!-- <tr>
            <td style="padding-top:10px;font-weight:bold;">생년월일</td>
          </tr>
          <tr>
            <td>
              <select name="yy" id="year"></select>
              <select name="mm" id="month"></select>
              <select name="dd" id="day"></select>
            </td>
          </tr> -->
          <tr>
           <td style="padding-top:10px;font-weight:bold;">연락처</td>
         </tr>
         <tr>
           <td>
             <select class="" id="user_tel1" name="user_tel1" style="width:100px;">
               <option value="010" selected>010</option>
               <option value="011" >011</option>
             </select>
             <input type="text" id="user_tel2" name="user_tel2" placeholder="'-'제외하고 입력" onkeyup="inputPhoneNumber(this);" maxlength="13" class="login_input" style="width:290px;" value="<?php echo substr($view_val['user_tel'], 4); ?>">
           </td>
         </tr>
          <tr>
            <td style="padding-top:10px;font-weight:bold;">e-mail</td>
          </tr>
          <tr>
            <td><input type="text" name="user_email" class="login_input" value="<?php echo $view_val['user_email']; ?>" placeholder="e-mail"></td>
          </tr>


					<tr>
						<td style="padding-top:10px;font-weight:bold;font-size:13px;">근무 시간</td>
					</tr>
<?php
$stime_arr = explode('*/*', $view_val['work_start']);
$etime_arr = explode('*/*', $view_val['work_end']);
$day = ['월요일', '화요일', '수요일', '목요일', '금요일'];
?>

<?php for($i = 0; $i < 5; $i++) { ?>
					<tr>
						<td style="padding-top:10px;font-weight:bold;"><?php echo $day[$i]; ?></td>
					</tr>
					<tr>
						<td>
							<input type="text" name="work_start[]" class="login_input timepicker timeBtn" style="width:48%;float:left;" value="<?php if(isset($stime_arr[$i])){echo $stime_arr[$i];} ?>" placeholder="시작시간" readonly>
							<input type="text" name="work_end[]" class="login_input timepicker timeBtn" style="width:48%;float:right;" value="<?php if(isset($etime_arr[$i])){echo $etime_arr[$i];} ?>" placeholder="종료시간" readonly>
						</td>
					</tr>
<?php } ?>


          <tr>
            <td style="padding-top:10px;">
              <div>
                <button type="submit" class="sign_up_button" name="sign_up_button" onclick="javascript:chkForm();return false;">수정하기</button>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </form>
  </div>
</table>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/mango_bottom.php"; ?>
</body>
<link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="/misc/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/misc/js/bootstrap-timepicker.js"></script>
<script language="javascript">
$(function() {
	$('.timepicker').timepicker({
			minuteStep: 10,
			showMeridian: false,
			defaultTime: null
	});
})

	function change_lpp(){
		var lpp = $("#listPerPage").val();
		document.mform.lpp.value = lpp;
		document.mform.cur_page.value = 1;
		document.mform.submit();
	}
</script>
</html>
