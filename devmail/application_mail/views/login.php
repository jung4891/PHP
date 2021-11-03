<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/base.php";
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="<?php echo $misc; ?>css/main.css" type="text/css" rel="stylesheet" >
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>

    <style>


    /* 전체div id */
    #login{
      /* 주석처리하니까 가운데정렬 됨 */
      /* display: inline-block; */

      display: flex;
      /* text-align: center; */
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .container{
      width:30vw;
    }

    /* 각각 input창 div로 감싼 class */
    .loginClass{
      display: block;
      width: 100%;
      margin-bottom: 15px;
    }

    /* 아이디 id */
      .login_input{
        width:100%;
        height: 60px;
        border: 1px solid #DEDEDE;
        border-radius: 5px;
        opacity: 1;
        /* margin: 10px; */
      }

      /* 로그인버튼 id */
      #loginBtn{
        width:100%;
        height: 60px;
        font-size: 16px;
        letter-spacing: 5px;
        text-align: center;
        background: #0575E6 0% 0% no-repeat padding-box;
        border-radius: 5px;
        opacity: 1;
        color: #FFFFFF;
        opacity: 1;
        cursor: pointer;
        border: none;
        outline:none;
      }
    </style>

  </head>
  <body>
    <div class="login" id="login">
      <div class="container">
      <form class="loginForm" name="loginForm" action="" method="post">
        <div class="loginClass" style="float: unset;display: flex;justify-content: space-between;
    align-items: center;">
            <span id="mailLogo">D-mail</span>
            <span>
              <label><input type="radio" name="login_mode" value="general">사용자 모드</label>
              <label><input type="radio" name="login_mode" value="admin" checked>관리자 모드<br></label>
            </span>
        </div>

        <div class="loginClass">
          <input type="text" class="login_input" name="inputId" id="inputId" value="" placeholder="아이디를 입력하세요."><br>
        </div>

        <div class="loginClass">
          <input type="password" class="login_input" name="inputPass" id="inputPass" value="" placeholder="패스워드를 입력하세요.">
        </div>

        <div class="loginClass">
          <!-- <button type="button" name="button" id="loginBtn">로그인</button> -->
          <input type="text" class="login_input" name="button" id="loginBtn" value="로그인" readonly>
        </div>
      </form>
      </div>
     </div>
  </body>
  <script type="text/javascript">

    $("#loginBtn").on("click", function(){
      // let mode = $(':radio[name="login_mode"]:checked').val();
      // if(mode == "general"){
      //   // alert("준비중입니다.");
      //   // return false;
      // var request_url = "<?php echo site_url();?>/account/login";
      //
      // }else{
        var request_url = "<?php echo site_url();?>/account/login";
        let input_id = $("#inputId").val();
        let input_pass = $("#inputPass").val();
        if(input_id ==""){
          alert("아이디를 입력해주세요");
          $("#inputId").focus();
          return false;
        }

        if(input_pass ==""){
          alert("비밀번호를 입력해주세요");
          $("#inputPass").focus();
          return false;
        }

        if(input_id.indexOf("@") == -1) {
          input_id = input_id.trim() + "@durianit.co.kr";
        }

        // let mode = $(':radio[name="login_mode"]:checked').val();
        // if(mode == "admin"){
        //   var request_url = "<?php echo site_url();?>/account/login";
        // }else{
        //   var request_url = "<?php echo site_url();?>";
        // }
        let mform = document.loginForm;
        mform.inputId.value = input_id.trim();
        mform.inputPass.value = input_pass.trim();
        mform.action = request_url;
        mform.submit();


      // }

    })

    document.addEventListener('keydown', function(e){
   const keyCode = e.keyCode;

   if(keyCode == 13){ // Enter key
     $("#loginBtn").click();
   }
 })

  </script>

</html>
