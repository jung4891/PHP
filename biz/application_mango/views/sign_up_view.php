<!-- <?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
//	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?> -->
<html>
  <head>
    <title><?php echo $this->config->item('site_title');?></title>
    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- <script type="text/javascript" src="/misc/js/jquery.validate.js"></script> -->
    <!-- <link href="<?php echo $misc;?>css/styles.css" type="text/css" rel="stylesheet"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="generator" content="WebEditor">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="/misc/js/common.js"></script>
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
      .login_table{
        position: absolute;
    		left: 50%;
    		transform:translateX(-50%);
        width:400px;
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

    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
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
    var chkForm = function chkForm() {
      var rv = true;

    	var mform = document.cform;
    	mform.user_id.value = mform.user_id.value.trim();
    	mform.user_password.value = mform.user_password.value.trim();

    	if (mform.user_id.value == "") {
    		alert("???????????? ???????????????.");
    		mform.user_id.focus();
    		return rv = false;
    	}
      if (mform.user_password.value == "") {
    		alert("??????????????? ???????????????.");
    		mform.user_password.focus();
    		return rv = false;
    	}
      if ( !passwordvalidcheck( mform.user_password.value ) ){		//	???????????? ????????? 6?????? ?????????, ????????? ????????? ??????
    		alert( "??????????????? ????????? ??????????????? ????????? ?????????.\n\n(6??? ????????? ??????,??????,???????????? ??????)" );
    		mform.user_password.value = "";
    		mform.user_passwordconfirm.value = "";
    		mform.user_password.focus();
    		return rv = false;
    	}
      if ( mform.user_passwordconfirm.value == "" ){				//	???????????? ???????????? ???????????? ?????? ?????? ??????
    		alert( "???????????? ????????? ????????? ?????????." );
    		mform.user_passwordconfirm.value = "";
    		mform.user_passwordconfirm.focus();
    		return rv = false;
    	}

    	if ( mform.user_password.value != mform.user_passwordconfirm.value ){	//	???????????? ?????? ????????? ????????? ??????
    		alert( "???????????? ????????? ???????????? ????????????." );
    		mform.user_passwordconfirm.value = "";
    		mform.user_passwordconfirm.focus();
    		return rv = false;
    	}
      if (mform.user_email.value == "") {
    		alert("e-mail??? ???????????????.");
    		mform.user_email.focus();
    		return rv = false;
    	}
      if (mform.user_name.value == "") {
        alert("????????? ???????????????.");
        mform.user_name.focus();
        return rv = false;
      }
      if (mform.user_tel2.value == '') {
        alert('??????????????? ???????????????.');
        mform.user_tel2.focus();
        return rv = false;
      }

      var valid = $("#validate_check").val();
      if(valid == "false") {
        alert("????????? ??????");
        $("input[name=user_id]").focus();
        return rv = false;
      } else if (valid == 'length') {
        alert('???????????? 3~12?????? ??????, ????????? ?????? ???????????????.')
        $("input[name=user_id]").focus();
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

    function id_check(){

      var uid = $("#user_id").val();
      $('#validate_check').val('true');
      document.getElementById("id_message").innerHTML = "<font color=red><span id='id_message'><span class=''>* 3~12?????? ??????, ????????? ?????? ???????????????.</span></span></font>";
      if(uid.length > 12 || uid.length < 3){
        $("#validate_check").val("length");
      } else {
        $.ajax({
          type: "POST",
          cache:false,
          url: "<?php echo site_url();?>/account/duplicate_id",
          dataType: "json",
          async: false,
          data: {id: uid},
          success: function (result){
            console.log(result);
            if(result == "dupl") {
              document.getElementById("id_message").innerHTML = "<font color=red><span id='id_message'><span class=''>* ???????????? ???????????? ????????????</span></span></font>";
              $("#validate_check").val("false");
            } else {
              document.getElementById("id_message").innerHTML = "";
            }
          }
        });

      }
    }

    function pw_check() {
      userpassword = document.cform.user_password.value.trim();
    	if  ( !passwordvalidcheck( userpassword ) ){		//	???????????? ????????? 6?????? ?????????, ????????? ????????? ??????
    		document.getElementById("pw_message").innerHTML = "<span class='error_1'>* ????????????</span> <span class='error'>: 6??? ????????? ??????,??????,???????????? ????????? ??????</span>";
    	} else{
    		document.getElementById("pw_message").innerHTML = "<font color=green><span class='error_2'>* ????????????</span></font> <span class='error'>: 6??? ????????? ??????,??????,???????????? ????????? ??????</span>";
    	}
    }


    $(document).ready(function(){
    var now = new Date();
    var year = now.getFullYear();
    var mon = (now.getMonth() + 1) > 9 ? ''+(now.getMonth() + 1) : '0'+(now.getMonth() + 1);
    var day = (now.getDate()) > 9 ? ''+(now.getDate()) : '0'+(now.getDate());

    //?????? selectbox?????????
    for(var i = 1900 ; i <= year ; i++) {
      $('#year').append('<option value="' + i + '">' + i + '???</option>');
    }
    $('#year').append('<option value="test_year" selected="selected">??????</option>');


    // ?????? selectbox ?????????
    for(var i=1; i <= 12; i++) {
        var mm = i > 9 ? i : "0"+i ;
        $('#month').append('<option value="' + mm + '">' + mm + '???</option>');
    }

    // ?????? selectbox ?????????
    for(var i=1; i <= 31; i++) {
        var dd = i > 9 ? i : "0"+i ;
        $('#day').append('<option value="' + dd + '">' + dd+ '???</option>');
    }
    $("#year  > option[value="+year+"]").attr("selected", "true");
    $("#month  > option[value="+mon+"]").attr("selected", "true");
    $("#day  > option[value="+day+"]").attr("selected", "true");

    })

    // ???????????? - ????????????
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

  </head>
  <body>
    <div class="register_main">
      <input type="hidden" id="validate_check" name="" value="false">
      <!-- <?php echo validation_errors();  ?> -->
      <form name="cform" action="<?php echo site_url().'/account/sign_up_action';?>" method="post" onSubmit="javascript:chkForm();return false;">
        <div class="user_info">
          <table class="login_table">
            <tr>
              <th align="left" style="font-size:19px;padding-bottom:20px;padding-top:20px;">????????????</th>
            </tr>
            <tr>
              <td style="padding-top:10px;font-weight:bold;">?????????</td>
            </tr>
            <tr>
              <td>
                <input type="text" id="user_id" name="user_id" class="login_input" placeholder="3???~12?????? ??????,????????? ??????" onKeyUp="id_check();" autocomplete="off">
              </td>
            </tr>
            <tr>
              <td>
                <span id="id_message"></span>
              </td>
            </tr>
            <tr>
              <td style="padding-top:10px;font-weight:bold;">????????????</td>
            </tr>
            <tr>
              <td>
                <input type="password" id="user_password" name="user_password" class="login_input" placeholder="6??? ????????? ??????,??????,???????????? ??????" onKeyUp="pw_check();" autocomplete="off">
              </td>
            </tr>
            <tr>
              <td>
                <span id="pw_message" style="display:inline"><span class="error_1">* ????????????</span> <span class="error">: 6??? ????????? ??????,??????,???????????? ????????? ??????</span></span>
              </td>
            </tr>
            <tr>
              <td height="10" colspan="2"></td>
            </tr>
            <tr>
              <td style="font-weight:bold;">???????????? ?????????</td>
            </tr>
            <tr>
              <td>
                <input type="password" name="user_passwordconfirm" class="login_input" value="" autocomplete="off" placeholder="??????????????? ?????? ???????????????.">
              </td>
            </tr>
            <tr>
              <td style="padding-top:10px;font-weight:bold;">??????</td>
            </tr>
            <tr>
              <td><input type="text" name="user_name" class="login_input" value="" placeholder="????????? ???????????????."></td>
            </tr>
            <!-- <tr>
              <td style="padding-top:10px;font-weight:bold;">????????????</td>
            </tr>
            <tr>
              <td>
                <select name="yy" id="year"></select>
                <select name="mm" id="month"></select>
                <select name="dd" id="day"></select>
              </td>
            </tr> -->
            <tr>
             <td style="padding-top:10px;font-weight:bold;">?????????</td>
           </tr>
           <tr>
             <td>
               <select class="" id="user_tel1" name="user_tel1" style="width:100px;">
                 <option value="010" selected>010</option>
                 <option value="011" >011</option>
               </select>
               <input type="text" id="user_tel2" name="user_tel2" value="" placeholder="'-'???????????? ??????" onkeyup="inputPhoneNumber(this);" maxlength="13" class="login_input" style="width:290px;">
             </td>
           </tr>
            <tr>
              <td style="padding-top:10px;font-weight:bold;">e-mail</td>
            </tr>
            <tr>
              <td><input type="text" name="user_email" class="login_input" value="" placeholder="e-mail"></td>
            </tr>
            <!-- <tr>
              <td style="padding-top:10px;font-weight:bold;">?????? ????????????</td>
            </tr>
            <tr>
              <td><input type="text" name="work_start" class="login_input timepicker" value="" placeholder="?????? ????????????"></td>
            </tr>
            <tr>
              <td style="padding-top:10px;font-weight:bold;">?????? ????????????</td>
            </tr>
            <tr>
              <td><input type="text" name="work_end" class="login_input timepicker" value="" placeholder="?????? ????????????"></td>
            </tr> -->
            <tr>
              <td style="padding-top:10px;font-weight:bold;font-size:13px;">?????? ??????</td>
            </tr>
<?php
$day = ['?????????', '?????????', '?????????', '?????????', '?????????'];
?>

<?php for($i = 0; $i < 5; $i++) { ?>
            <tr>
              <td style="padding-top:10px;font-weight:bold;"><?php echo $day[$i]; ?></td>
            </tr>
            <tr>
              <td>
                <input type="text" name="work_start[]" class="login_input timepicker timeBtn" style="width:48%;float:left;" value="" placeholder="????????????" readonly>
                <input type="text" name="work_end[]" class="login_input timepicker timeBtn" style="width:48%;float:right;" value="" placeholder="????????????" readonly>
              </td>
            </tr>
<?php } ?>
            <tr>
              <td style="padding-top:10px;">
                <div>
                  <button type="submit" class="sign_up_button" name="sign_up_button" onclick="javascript:chkForm();return false;" style="cursor:pointer;">????????????</button>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </form>
    </div>
  </body>
</html>
