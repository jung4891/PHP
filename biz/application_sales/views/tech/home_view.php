<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
//	include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
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
.searchModal {
display: none; /* Hidden by default */
position: fixed; /* Stay in place */
z-index: 10; /* Sit on top */
left: 0;
top: 0;
width: 100%; /* Full width */
height: 100%; /* Full height */
overflow: auto; /* Enable scroll if needed */
background-color: rgb(0,0,0); /* Fallback color */
background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
/* Modal Content/Box */
.search-modal-content {
background-color: #fefefe;
margin: 15% auto; /* 15% from the top and centered */
padding: 20px;
border: 1px solid #888;
width: 70%; /* Could be more or less, depending on screen size */
}

/*** Login form ***/

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
<body style=" background:url(../../misc/img/tech_bg.jpg) no-repeat;" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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
            <td><a href="<?php echo site_url();?>"><img src="<?php echo $misc;?>img/m_login_ci.png"></a></td>
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
            <td><a href="<?php echo site_url();?>/board/eduevent_list"><img src="<?php echo $misc;?>img/customer_m_ic03.png" width="228" height="229"></a></td>
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
            <td colspan="3" valign="top" style="position:relative;"><table width="100%" height="222" border="0" cellspacing="0" cellpadding="0" >
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
              <!--다운로드-->
              <div style="position:absolute; width:145px; height:50px; right:15px; top:155px;">
              <a href="download.php"><img src="../../misc/img/tech_down.jpg" title="다운로드받기"/></a>
              </div>
              <!--//다운로드-->
            </table></td>
            <td></td>
            <td><a href="<?php echo site_url();?>/board/qna_list"><?php if(trim($qna_new) != "") {?><img src="<?php echo $misc;?>img/customer_m_ic05_new.png" width="228" height="229"><?php } else {?><img src="<?php echo $misc;?>img/customer_m_ic05.png" width="228" height="229"><?php }?></a></td>
            <td></td>
            <td><a href="<?php echo site_url();?>/board/suggest_list"><?php if(trim($suggest_new) != "") {?><img src="<?php echo $misc;?>img/customer_m_ic06_new.png" width="228" height="229"><?php } else {?><img src="<?php echo $misc;?>img/customer_m_ic06.png" width="228" height="229"><?php }?></a></td>
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
<div id="modal" class="searchModal">
  <div class="search-modal-content">
    <!-- <button onClick="closeModal();" style="float:right;">닫기</button> -->
    <div class="page-header">
      <h1>MODAL</h1>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-12">
            <h2>정기점검 미완료</h2>
          </div>
          <div>
            <table  width="100%" border="1" cellspacing="0" cellpadding="0" style="font-weight:bold;font-size:13px;">
                <tr width="100%" height=30>
                    <td align="center" width="10%" bgcolor="f8f8f9" >idx</td>
                    <td align="center" width="20%" bgcolor="f8f8f9" >고객사</td>
                    <td align="center" width="20%" bgcolor="f8f8f9" >프로젝트명</td>
                    <td align="center" width="10%" bgcolor="f8f8f9" >점검주기</td>
                    <td align="center" width="10%" bgcolor="f8f8f9" >마지막점검일</td>
                    <td align="center" width="10%" bgcolor="f8f8f9" >관리팀</td>
                    <td align="center" width="10%" bgcolor="f8f8f9" >점검자</td>
                    <td align="center" width="10%" bgcolor="f8f8f9" >코멘트</td>
                </tr>

                <?php
                $idx=1; 
                foreach($view_val as $val){
                  $font_color='';
                  if($val['maintain_result']==9){
                    $font_color="style='color:red'";
                  }
                    echo "<tr height=30 align='center'><td>{$idx}</td>";
                    echo "<td>{$val['customer_companyname']}</td>";
                    echo "<td>{$val['project_name']}</td>";
                    echo "<td>";
                    if ($val['maintain_cycle'] == "1") {
                        echo "월점검";
                    }else if ($val['maintain_cycle'] == "3") {
                        echo "분기점검";
                    }else if ($val['maintain_cycle'] == "6") {
                        echo "반기점검";
                    }else if ($val['maintain_cycle'] == "0") {
                        echo "장애시";
                    }else if ($val['maintain_cycle'] == "7") {
                        echo "미점검";
                    }else{
                        echo "";
                    }
                    echo "</td>";
                    echo "<td {$font_color}>{$val['maintain_date']}</td>";
                    echo "<td>";
                    if ($val['manage_team'] == "1") {
                      echo "기술 1팀";
                    }else if ($val['manage_team'] == "2") {
                        echo "기술 2팀";
                    }else if ($val['manage_team'] == "3") {
                        echo "기술 3팀";
                    }else{
                        echo "";
                    } 
                    echo "</td>";
                    echo "<td>{$val['maintain_user']}</td>";
                    echo "<td>{$val['maintain_comment']}</td></tr>";
                    
                    $idx=$idx+1;
                }
                ?>
            </table>
          </div>
        </div>
      </div>
    </div>
      <div style="cursor:pointer;background-color:#DDDDDD;text-align: center;padding-bottom: 10px;padding-top: 10px;margin-top:20px;" onClick="closeModal();">
        <span class="pop_bt modalCloseBtn" style="font-size: 13pt;">닫기</span>
      </div>
  </div>
</div>
<script>
if(<?php echo isset($_GET['login']); ?>){
  jQuery(document).ready(function () {
    $("#modal").show();
  });

  function closeModal() {
    $('.searchModal').hide();
  };
}
</script>

</body>
</html>
