<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
//	include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
?>
<html>

<head>
  <title><?php echo $this->config->item('site_title');?></title>
  <link href="<?php echo $misc;?>css/styles.css" type="text/css" rel="stylesheet">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="generator" content="WebEditor">
  <style type="text/css">
  </style>
</head>
<body style=" background:url(../../misc/img/tech_bg.jpg) no-repeat;" leftmargin="0" topmargin="0" marginwidth="0"
  marginheight="0">
  <table id="__01" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
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
                  <!-- <tr>
                    <td><input type="text" name="user_id" id="user_id" placeholder="아이디를 입력하세요." class="login_input">
                    </td>
                  </tr>
                  <tr>
                    <td height="5"></td>
                  </tr>
                  <tr>
                    <td><input type="password" name="user_password" id="user_password" placeholder="패스워드를 입력하세요."
                        class="login_input"></td>
                  </tr>
                  <tr>
                    <td height="30"></td>
                  </tr> -->
                  <tr align='center'>
                    <td>
                      <a href='<?php echo site_url();?>/account/login_view'>고객사 로그인</a>
                    </td>
                  </tr>
                  <tr>
                    <td height="30"></td>
                  </tr>
                  <tr align='center'>
                    <td>
                      <a href='<?php echo site_url();?>/account/cooperative_login_view'>협력사 로그인</a>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td height="30"></td>
            </tr>
            <!-- <tr>
              <td align="center">
                <table width="460" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><a href="<?php echo site_url().'/account/join';?>">
                      <img src="<?php echo $misc;?>img/m_btn_newg.jpg" width="225" height="44"></a></td>
                    <td width="10"></td>
                    <td><a href="#" onClick="window.open('<?php echo site_url();?>/account/cnum_view/2','','width=550,height=220,scrollbars=no,left=100,top=200');return false" target="space">
                    <img src="<?php echo $misc;?>img/m_btn_find.jpg" width="225" height="44"></a>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td height="30"></td>
            </tr> -->
            <tr>
              <td height="1" bgcolor="#b7b7b7"></td>
            </tr>
            <tr>
              <td height="60" align="center" class="text_copyright">Copyright ©<span class="style1">
                  DurianIT</span> All rights Reserved</td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align="center" height="200"></td>
      </tr>
  </table>
</body>


</html>