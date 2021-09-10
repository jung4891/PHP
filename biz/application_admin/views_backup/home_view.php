<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
//	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<html>
<head>
<title><?php echo $this->config->item('site_title');?></title>
<link href="<?php echo $misc;?>css/styles.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="generator" content="WebEditor">
<style type="text/css">
 <!--

/*** Login form ***/

-->
 </style>
</head>
<body bgcolor="#eeeeee" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table id="__01" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td align="center" height="100"></td>
  </tr>
  
  <tr>
    <td align="center" valign="middle">
    
    <table width="989" border="0" cellspacing="0" cellpadding="0">
      
      <tr>
        <td height="80" align="right" class="text_copyright"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><a href="<?php echo site_url();?>"><img src="<?php echo $misc;?>img/m_login_ci2.png" width="307" height="66"></a></td>
            <td align="right"><table width="105" border="0" cellspacing="0" cellpadding="0">
              <tr>
			  <?php if( $id != null ) {?>
                <td><a href="<?php echo site_url();?>/account/modify_view" class="login"><?php echo $name;?></a></td>
                <td><a href="<?php echo site_url();?>/account/logout"><img src="<?php echo $misc;?>img/btn_logout.jpg" width="50" height="18"></a></td>
			  <?php } else {?>
				<td></td>
                <td align="right"><a href="<?php echo site_url();?>/account"><img src="<?php echo $misc;?>img/btn_login.jpg"></a></td>
			  <?php }?>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="228"><a href="<?php echo site_url();?>/board/notice_list"><img src="<?php echo $misc;?>img/customer_m_ic01_new.png" width="228" height="228"></a></td>
            <td width="25"></td>
            <td><a href="<?php echo site_url();?>/board/manual_list"><img src="<?php echo $misc;?>img/customer_m_ic02.png" width="228" height="228"></a></td>
            <td width="26"></td>
            <td><a href="<?php echo site_url();?>/forcasting/forcasting_list"><img src="<?php echo $misc;?>img/sales_m_ic_forecast.png" width="228" height="229"></a></td>
            <td width="26"></td>
            <td><a href="<?php echo site_url();?>/board/faq_list"><img src="<?php echo $misc;?>img/customer_m_ic04.png" width="228" height="229"></a></td>
          </tr>
          <tr>
            <td height="22"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td colspan="3" valign="top"><table width="100%" height="222" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td bgcolor="#333333" class="f_white" style="padding:20px;" valign="top"><p class="f_white0">경기도 성남시 분당구 판교로 255번길 9-22(삼평동 618번지) <br>
                  판교우림더블유시티 603호</p>
                  <p class="f_white0">Phone. 02-542-4987 | Fax. 02-6455-3987</p></td>
              </tr>
              <tr>
                <td height="80" bgcolor="#333333" class="f_white" style="padding-left:20px;">
                <table width="60%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>
                      <select name="select" id="select" class="main_input">
                        <option>관계사</option>
                        <option>모두스원</option>
                        <option>시큐아이</option>
                        <option>SK 인포섹</option>
                        <option>베일리테크</option>
                        관계사
                      
                      </select></td>
                    <td><img src="<?php echo $misc;?>img/btn_go.png" width="34" height="21"></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
            <td></td>
            <td><a href="<?php echo site_url();?>/board/qna_list"><img src="<?php echo $misc;?>img/customer_m_ic05.png" width="228" height="229"></a></td>
            <td></td>
            <td><a href="#"><img src="<?php echo $misc;?>img/sales_m_ic_customer.png" width="228" height="229"></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
      <tr>
        <td height="60" align="right" class="text_copyright">Copyright ©<span class="style1"> DurianIT</span> All rights Reserved</td>
      </tr>
    </table></td>
  </tr>
   <tr>
    <td align="center" height="200"></td>
  </tr>
</table>
</body>
</html>