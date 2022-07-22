<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
?>
<style>
@charset "utf-8";

@font-face{font-family:NanumGothicWeb; font-style: normal; font-weight: normal; src:url(/share/font/NanumGothic.eot) format('eot');src:local(※), url(/misc/fonts/NanumGothic.woff) format('woff')}
body,h1,h2,h3,h4,input,button,textarea{font-family:nanumgothicweb, nanumgothic,'나눔고딕',gulim, '굴림',dotum,Helvetica,sans-serif;font-size:12px;line-height:140%;}

div, span, h1, h2, h3, h4, h5, h6, dl, dt, dd, ol, ul, li, a, p, img {margin:0; padding:0; border:0; vertical-align:middle;}


body  {overflow-x:auto; overflow-y:scroll; *overflow-x:auto; *overflow-y:auto;}

h1,h2,h3,h4,h5,h6 {font-size:100%; }

object {display:block; }

address, caption, cite, code, dfn, em, var {font-style:normal; font-weight:normal}

ol, ul {list-style:none}

img{ font-size:0; line-height:0; }


/* tables still need 'cellspacing="0"' in the markup */
caption {width:0; height:0; font-size:0; line-height:0; overflow:hidden; visibility:hidden;  }
table {border-collapse:collapse; }

button	{display:inline-block; margin:0; padding:0; background:none; border:none; text-align:center; vertical-align:middle; white-space:nowrap; cursor:pointer;}
*+html button	{margin:0 2px; overflow:visible;}
button > span, .btn > span, button > span > span, .btn > span > span {display:block; position:relative; z-index:1;}
button::-moz-focus-inner {padding:0; border:0;} /* 파이어폭스 버튼 내부 여백 제거 */



/* Link Style
--------------------------------------------------*/
a:link, a:visited {color:#333; text-decoration: none;}
a:active, a:hover {color: #4eaa1a; text-decoration: none; }
a { text-decoration:none; color:#333; }


/* Common Style */
.invisible {position:absolute; left:-10000px; top:0; }
.selector { position:absolute; width:0; height:0; font-size:0; line-height:0; overflow:hidden; visibility:hidden; } /* ?⑥? ?쒕ぉ ?쒓났 湲곕쾿 */
.hide{visibility:hidden}

/* ?ㅻ낫?쒕쭔?쇰줈 ?묎렐?쒖뿉??嫄대꼫?곌린 ?ъ슫 硫붾돱 嫄대꼫?곌린 */
#skip-go dt {left:-1000px; top:0px; position:absolute;}
#skip-go dd a {left:-1000px; top:0px; text-align:center; font-size:120%; font-weight:bold; display:block; position:absolute; z-index:1000; background-color: rgb(0, 0, 0);}

#skip-go dd a:hover, #skip-go dd a:active, #skip-go dd a:focus
{left:0px; width:100%; height:40px; color:#fff !important; line-height:40px;}

/* CSS Document */
/* ----------------------------------------------------------------

- Title : Cascading Style Sheets

- Author : eun jung kim

- Date : 2014-12-30

- Description : 더망고_layout.css
---------------------------------------------------------------- */

/* body ---------------------------------------------------------*/
body {margin:0; padding:0;}

/* wrap -----------------------------------------*/
#wrap { width:100%; min-width:1000px; overflow:hidden; position:relative;}

#header {position:absolute; left:0; top:0; width:100%; min-height:90px;  z-index:1;}
#con_wrap {width:100%; min-height:880px; margin:0 auto; overflow:hidden;   z-index:2;}
#footer {width:100%; height:70px; overflow:hidden; }



/* header_gnb --------------------------------------------------------*/
#header #gnb_wrap {width:100%; max-height:90px; margin:0 auto; background:#FFF; overflow:hidden;}
/* #gnb_wrap {border-bottom:1px solid #ddd} */
.gnb_menu {width:100%; max-height:90px; margin:0 auto; overflow:hidden;}
.gnb_menu h1 { float:left; width:129px; min-height:90px; border-right:1px solid #ddd; border-left:1px solid #ddd; margin-right:128px; }
.gnb_menu h1 a {display:block; width:129px; min-height:85px; background:url("/misc/img_mango/logo.jpg") center no-repeat; text-indent:-10000px;}
.gnb_menu h1 a:hover { border-bottom:5px solid #fa4c06;}
.logo_on .gnb_menu h1 a { border-bottom:5px solid #fa4c06;}
.gnb_menu .menu {float:left; width:601px; min-height:90px; overflow:hidden;}
.gnb_menu .menu li {float:left; width:149px; min-height:90px; border-right:1px }
.gnb_menu .menu li.first {border-left:1px}
.menu li.gnb_m1 a,
.menu li.gnb_m2 a,
.menu li.gnb_m3 a,
.menu li.gnb_m4 a,
.menu li.gnb_m5 a  { min-height:85px; line-height:85px; font-size:20px; text-align:center; }
/* .menu li.gnb_m1 a:hover,.menu li.gnb_m2 a:hover,.menu li.gnb_m3 a:hover,.menu li.gnb_m4 a:hover,.menu li.gnb_m5 a:hover {color:#333; border-bottom:5px solid #fa4c06;} */
.gnb_on_m1 .menu li.gnb_m1 a,
.gnb_on_m2 .menu li.gnb_m2 a,
.gnb_on_m3 .menu li.gnb_m3 a,
.gnb_on_m4 .menu li.gnb_m4 a,
.gnb_on_m5 .menu li.gnb_m5 a { border-bottom:5px solid #fa4c06; font-weight:bold; }


/* main_img --------------------------------------------------------*/
#main_bg {position: absolute; top:90px; left:50%; min-height:860px; width:2000px; margin-left:-1000px; z-index:-100; overflow: hidden;}
#main_bg img {display:block;}

/* main_text --------------------------------------------------------*/
.main_text {width:1000px; margin:0 auto; position:relative;}
.main_text p {position:absolute; width:650px; height:398px; padding-top:100px; right: 600px; top:450px; margin-left:-249px; text-align:center; vertical-align:middle; line-height:35px; font-size:22px; color:#fff; font-family: 'Nanum Myeongjo', serif; text-align: left; font-weight: 500; letter-spacing: -1.5px;}

/* sub_img --------------------------------------------------------*/
.sub_bg_about {position: absolute; top:1070px; left: 0px; min-width:100%; min-height:200px; width:auto; overflow: hidden;}
.sub_bg_about img {display:block;}
.sub_map {position: absolute; bottom:130px; left: 0px; min-width:100%; min-height:370px; width:auto; overflow: hidden;}
.sub_bg_business {position: absolute; top:440px; left: 0px; min-width:100%; min-height:200px; width:auto; overflow: hidden;}
.sub_bg_business img {display:block;}

/* sub_con --------------------------------------------------------*/
.sub_warp {width:100%; margin-top:90px; background-color:#f4f4f4; border-top:1px solid #ddd; overflow:hidden;}
.sub_warp .sub_con {width:1000px; min-height:660px; margin:0 auto; padding:100px 0; overflow:hidden; }


/* footer --------------------------------------------------------*/
.copyright {background-image:url(../../img/foor_bg.png);}
.copyright .copyright_cont {width:1000px; height:35px; padding:17px 0 18px 0; margin:0 auto;}
.copyright .copyright_cont .copy{line-height:35px; text-align:left; font-size:12px; font-weight:normal; color:#ccc;}
.copyright .copyright_cont .family {position:absolute; width:300px; height:35px; bottom:18px; left:50%; margin-left:400px; }
.copyright .copyright_cont .family a {display:block;}
.copyright .copyright_cont .family_list {position:absolute; width:298px; min_height:35px; border:1px solid #ccc; bottom:52px; left:50%; margin-left:400px; background-color:#fff; display:none; margin-bottom: 0px;}
.copyright .copyright_cont .family_list li {height:35px; border-bottom:0px solid #ccc; padding-left:15px; }
.copyright .copyright_cont .family_list li a {display:block; line-height:35px; font-size:12px; font-weight:normal; color:#666;}
/* .copyright .copyright_cont .family_list li a:hover {color:#333;} */
.main_content_extend {display:inline-block;height:calc(100% - 81px);position:absolute;left:200px;right:0px;overflow:auto;}
.menu a:hover {color:#fa4c06;}
.menu li {width:150px;text-align: center;float:left;}
</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<script type="text/javascript" src="/misc/js/mousetrap.js"></script> <!--  단축키 js -->
<script src="https://cdn.jsdelivr.net/npm/inko@1.1.1/inko.min.js"></script>
<!--글로벌메뉴-->

        <!--//글로벌메뉴-->
<div class="container" style="position:relative;width:100%;height:100%;box-sizing:border-box;min-height:100%;display:flex;">
  <div id="sidebar_left" style="display:inline-block;max-width:200px;z-index:1003;background-color:#fff;float:left;position:relative;">
    <?php include $this->input->server('DOCUMENT_ROOT')."/include/mango_sidebar.php"; ?>
    <div style="position:absolute;bottom:0;border-top:1px solid #ddd;width:100%;padding-top:25px;">
      <p style="padding-left:20px;">
        <a href="<?php echo site_url(); ?>/account/personal_modify">
          <img src="/misc/img_mango/side_icon/icon_user_modify.svg" style="margin-right:3px;">
          <span style="padding-top:2px;">정보수정</span>
        </a>
      </p>
      <p style="padding-left:20px;margin-top:10px;">
        <a href="<?php echo site_url(); ?>/account/logout">
          <img src="/misc/img_mango/side_icon/icon_logout.svg" style="margin-right:3px;">
          <span style="padding-top:2px;">로그아웃</span>
        </a>
      </p>
    </div>
  </div>
  <div class="header" style="flex-grow:1;height:80px;border-left:1px solid #ddd;background-color:#fff;">
    <ul class="menu">
      <li class="gnb_m1"><a href="http://www.the-mango.co.kr/about/about.php" title="about">about</a></li>
      <li class="gnb_m2"><a href="http://www.the-mango.co.kr/business/business.php" title="business">business</a></li>
      <li class="gnb_m3"><a href="http://www.the-mango.co.kr/project/project.php" title="project">project</a></li>
      <li class="gnb_m4"><a href="http://www.the-mango.co.kr/recruit/recruit.php" title="recruit">recruit</a></li>
      <li class="gnb_m5"><a href="<?php echo site_url(); ?>" title="admin" style="color:#fa4c06;">admin</a></li>
    </ul>
    <div style="float:right;line-height:85px;font-weight:bold;font-size:14px;">
      <span style="margin-right:10px;"><?php echo $this->name; ?></span>
      <span style="margin-right:10px;color:#DFDFDF;">|</span>
      <span style="margin-right:10px;"><?php if($this->admin == 'Y'){echo '관리자';}else{echo '근무자';} ?></span>
      <span style="margin-right:30px;"><img src="/misc/img_mango/side_icon/icon_user_online.svg" width="30"></span>
    </div>
    <span></span>
  </div>
  <div id="main_contents" class="main_content_extend" style="border-top:1px solid #ddd;border-left:1px solid #ddd;top:80px;">

<script type="text/javascript">
  function logout() {
    location.href = "<?php echo site_url(); ?>/account/logout";
  }

  function modify_user() {
    location.href = "<?php echo site_url(); ?>/account/personal_modify";
  }
</script>
