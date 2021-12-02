<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
//	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<html>
<head>
<title><?php echo $this->config->item('site_title');?></title>
<link href="/misc/css/styles.css" type="text/css" rel="stylesheet">
<link href="/misc/css/m_styles.css" type="text/css" rel="stylesheet">
<script src="/misc/js/m_script.js"></script>
<script type="text/javascript" src="/misc/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/misc/js/jquery.min.js"></script>
<link rel="stylesheet" href="/misc/css/jquery-ui.css">
<script src="/misc/js/jquery-ui.js"></script>
<script src="http://dmaps.daum.net/map_js_init/postcode.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="generator" content="WebEditor">
<style type="text/css">
 <!--

/*** Login form ***/

-->
 </style>
 <script>
    $(function(){
      // bind change event to select
      $('#dynamic_select').bind('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });
    });
</script>
</head>
<body style=" background:url(../../misc/img/sales_bg.jpg) no-repeat;" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

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
            <td width="228"><a href="<?php echo site_url();?>/board/notice_list"><?php if(trim($notice_new) != "") {?><img src="<?php echo $misc;?>img/customer_m_ic01_new.png" width="228" height="228"><?php } else {?><img src="<?php echo $misc;?>img/customer_m_ic01.png" width="228" height="228"><?php }?></a></td>
            <td width="25"></td>
            <td><a href="<?php echo site_url();?>/board/manual_list"><?php if(trim($manual_new) != "") {?><img src="<?php echo $misc;?>img/customer_m_ic02_new.png" width="228" height="228"><?php } else {?><img src="<?php echo $misc;?>img/customer_m_ic02.png" width="228" height="228"><?php }?></a></td>
            <td width="26"></td>
            <td><a href="<?php echo site_url();?>/forcasting/forcasting_list"><?php if(trim($forcasting_new) != "") {?><img src="<?php echo $misc;?>img/sales_m_ic_forecast_new.png" width="228" height="229"><?php } else {?><img src="<?php echo $misc;?>img/sales_m_ic_forecast.png" width="228" height="229"><?php }?></a></td>
            <td width="26"></td>
            <td><a href="<?php echo site_url();?>/board/faq_list"><?php if(trim($faq_new) != "") {?><img src="<?php echo $misc;?>img/customer_m_ic04_new.png" width="228" height="229"><?php } else {?><img src="<?php echo $misc;?>img/customer_m_ic04.png" width="228" height="229"><?php }?></a></td>
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
                      <select name="dynamic_select" id="dynamic_select" class="main_input">
                       <option>벤더사</option>
						<option value="http://www.modoosone.com"/>모두스원</option>
						<option value="http://www.monitorapp.com/kr">모니터랩</option>
						<option value="http://www.skinfosec.com/">SK 인포섹</option>
						<option value="https://www.secui.com">시큐아이</option>
						<option value="http://www.ebailey.co.kr">베일리테크</option>
						<option value="http://www.secuwiz.co.kr">시큐위즈</option>
						<option value="http://www.seculayer.co.kr">시큐레이어</option>
						<option value="http://www.secuever.com">시큐에버</option>
                      </select></td>
                    <!-- <td><img src="<?php echo $misc;?>img/btn_go.png" width="34" height="21"></td> -->
                  </tr>
                </table></td>
              </tr>
            </table></td>
            <td></td>
            <td><a href="<?php echo site_url();?>/board/qna_list"><?php if(trim($qna_new) != "") {?><img src="<?php echo $misc;?>img/customer_m_ic05_new.png" width="228" height="229"><?php } else {?><img src="<?php echo $misc;?>img/customer_m_ic05.png" width="228" height="229"><?php }?></a></td>
            <td></td>
            <td><a href="<?php echo site_url();?>/customer/customer_view"><img src="<?php echo $misc;?>img/sales_m_ic_customer.png" width="228" height="229"></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
      <tr>
        <td height="60" align="right" class="text_copyright2">Copyright © DurianIT All rights Reserved</td>
      </tr>
    </table></td>
  </tr>
   <tr>
    <td align="center" height="200"></td>
  </tr>
</table>
</body>
</html>
