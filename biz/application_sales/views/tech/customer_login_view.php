<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
?>
<html>
<head>
<title><?php echo $this->config->item('site_title');?></title>
<link href="<?php echo $misc;?>css/styles.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="generator" content="WebEditor">
<style type="text/css">

</style>
<script language="javascript">
var chkForm = function chkForm() {
    var mform = document.customer_login;
    mform.user_otp.value = mform.user_otp.value.trim();

    if(mform.user_otp.value == ""){
        alert("인증번호를 입력하세요.");
        mform.user_id.focus();
        return false;
    }
    mform.submit();
    mform.user_otp.value = ''; 
    return false;
}
</script>
</head>
<?php
$seq = explode('?',$_SERVER['REQUEST_URI']);
$seq = $seq[1];
$otpRand = sprintf('%06d',rand(000000,999999));
?>

<body style=" background:url(../../misc/img/tech_bg.jpg) no-repeat;" leftmargin="0" topmargin="0" marginwidth="0"
  marginheight="0">
  <table id="__01" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <form name="customer_login" method="post" action="<?php echo site_url().'/account/customer_login2';?>"
      onSubmit="javascript:chkForm();return false;">
      <tr>
        <td align="center" height="100"></td>
      </tr>
      <tr>
        <td align="center" valign="middle">
          <table style="background-color:#FFF; padding:20px; opacity:0.85;" width="485" border="0" cellspacing="0"
            cellpadding="0">
            <tr>
              <td height="80" align="center"><a href="<?php echo site_url();?>"><img
                    src="<?php echo $misc;?>img/m_login_ci.png"></a></td>
            </tr>
            <tr>
              <td height="5" bgcolor="#0277c3"></td>
            </tr>
            <tr>
              <td height="30"></td>
            </tr>
            <tr>
              <td align="center">
                <table width="460" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>
                      <input type="hidden" name="viewSeq" id="viewSeq" value="<?php echo $seq ;?>">
                      <input type="hidden" name="otp" id="otp" value="<?php echo $otpRand;?>">
                      <input type="hidden" name="loginName" id="loginName" value="">
                      <input type="text" name="user_email" id="user_email" placeholder="e-mail을 입력하세요." class="login_input">
                      <input type="text" name="user_otp" id="user_otp" placeholder="인증 번호를 입력하세요." class="login_input">
                    </td>
                  </tr>
                  <tr>
                    <td height="5"></td>
                  </tr>
                  <tr>
                    <td height="30"></td>
                  </tr>
                  <tr>
                    <td><input type="image" src="<?php echo $misc;?>img/m_btn_login.jpg" width="460" height="61"
                        style="cursor:pointer" onClick='return chkForm();'></td>
                  </tr>
                </table>
              </td>
            </tr>
    </form>
    <tr>
      <td height="30"></td>
    </tr>
    <tr>
      <td align="center">
        <table width="460" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <form name="otpSend" method="post" target="_blank" action="<?php echo site_url();?>/account/customer_otp_send">
              <td align="center">
                <input type="hidden" name="otp" id="otp" value="<?php echo $otpRand;?>">
                <input type="hidden" name="loginMail" id="loginMail" value="">
                <input type="button" value="인증번호 발급" onclick="otptest();"><p id ="otpTime"> </p></td>
            </form>
            <td width="10"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td height="30"></td>
    </tr>
    <tr>
      <td height="1" bgcolor="#b7b7b7"></td>
    </tr>
    <tr>
      <td height="60" align="center" class="text_copyright">Copyright ©<span class="style1"> DurianIT</span>
        All rights Reserved</td>
    </tr>
  </table>
  </td>
  </tr>
  <tr>
    <td align="center" height="200"></td>
  </tr>
  </table>
</body>
<script>
  console.log("<?php echo $otpRand; ?>");
  
  function otptest(){
    var mailInfo = "<?php echo $view_val['manager_mail']; ?>";
    var regExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
    var text = $("#user_email").val();
    var loginName ='';
    if(text == null) {
      alert("email주소를 입력하지 않았습니다.");
    }else if(text.match(regExp) == null){
      alert("email 형식이 맞지 않습니다.");
    }else {
      if(mailInfo.indexOf(text) != -1){
        document.otpSend.loginMail.value = text;
        document.otpSend.submit();
        // alert(text+"로 인증번호 메일이 발송되었습니다.");
        var time ="100";
        var min ="";
        var sec = "";

        var x= setInterval(function(){
          min = parseInt(time/60);
          sec = time % 60;

          document.getElementById("otpTime").innerHTML = min+"분"+sec+"초";
          time--;

          if(time<0){
            clearInterval(x);
            alert('인증번호 유효시간 초과');
            location.reload(true);
          }
        }, 1000);

        //로그인 하는 사람 이름 가져오기
        <?php
        $manager_mail = explode(';',$view_val['manager_mail']);
        $customer_manager = explode(';',$view_val['customer_manager']);
        ?>

        var manager_mail = <?php echo json_encode($manager_mail);?>;
        
        var customer_manager = <?php echo json_encode($customer_manager);?>;

        for(i=0; i<manager_mail.length; i++){
          if(manager_mail[i] == text){
            loginName = customer_manager[i];
          }
        }
        document.customer_login.loginName.value = loginName; 
      }else{
        alert(text+"는 지정된 승인자가 아닙니다.");
      }
      
    }
  }
</script>
</html>