<div class="sidebar_contents" style="text-align:center;vertical-align:middle;width:200px;">
  <div class="menulist" name="biz" id="biz_side" style="width:200px;text-align:left;">
    <div style="height:80px;text-align:center;">
      <a href="<?php echo site_url(); ?>">
        <img src="/misc/img_mango/logo.jpg" style="margin-top:20px">
      </a>
    </div>
    <ul class="menu_wrap" style="width:200px;margin-top:30px;">
      <li style="height:40px;padding-left:15px;">
        <a href="<?php echo site_url();?>/schedule/schedule_list" style="width:100%;">
    <?php if(strpos($_SERVER['REQUEST_URI'],'schedule/') !== false) { ?>
            <img src="/misc/img_mango/side_icon/schedule_on.svg" style="width:20px;margin-right:3px;">
            <span style="font-size:13px;vertical-align:top;font-weight:bold;">일정</span>
    <?php } else { ?>
            <img src="/misc/img_mango/side_icon/schedule_off.svg" style="width:20px;margin-right:3px;">
            <span style="font-size:13px;vertical-align:top;">일정</span>
    <?php } ?>
        </a>
      </li>
      <li style="height:40px;padding-left:15px;">
        <a href="<?php echo site_url();?>/document/document_list" style="width:100%;">
    <?php if(strpos($_SERVER['REQUEST_URI'],'document/') !== false) { ?>
            <img src="/misc/img_mango/side_icon/document_on.svg" style="width:20px;margin-right:3px;">
            <span style="font-size:13px;vertical-align:top;font-weight:bold;">내부서류</span>
    <?php } else { ?>
            <img src="/misc/img_mango/side_icon/document_off.svg" style="width:20px;margin-right:3px;">
            <span style="font-size:13px;vertical-align:top;">내부서류</span>
    <?php } ?>
        </a>
      </li>

      <li style="height:40px;padding-left:15px;">
        <a href="<?php echo site_url();?>/user/user_list" style="width:100%;">
    <?php if(strpos($_SERVER['REQUEST_URI'],'user/') !== false) { ?>
            <img src="/misc/img_mango/side_icon/user_on.svg" style="width:20px;margin-right:3px;">
            <span style="font-size:13px;vertical-align:top;font-weight:bold;">회원관리</span>
    <?php } else { ?>
            <img src="/misc/img_mango/side_icon/user_off.svg" style="width:20px;margin-right:3px;">
            <span style="font-size:13px;vertical-align:top;">회원관리</span>
    <?php } ?>
        </a>
      </li>

      <li style="height:40px;padding-left:15px;">
        <a href="<?php echo site_url();?>/health_certificate/doc_list" style="width:100%;">
    <?php if(strpos($_SERVER['REQUEST_URI'],'health_certificate/') !== false) { ?>
            <img src="/misc/img_mango/side_icon/health_certificate_on.svg" style="width:20px;margin-right:3px;">
            <span style="font-size:13px;vertical-align:top;font-weight:bold;">건강검진 관리대장</span>
    <?php } else { ?>
            <img src="/misc/img_mango/side_icon/health_certificate_off.svg" style="width:20px;margin-right:3px;">
            <span style="font-size:13px;vertical-align:top;">건강검진 관리대장</span>
    <?php } ?>
        </a>
      </li>


      <li style="height:40px;padding-left:15px;">
        <a href="<?php echo site_url();?>/board/notice_list" style="width:100%;">
    <?php if(strpos($_SERVER['REQUEST_URI'],'board/notice') !== false) { ?>
            <img src="/misc/img_mango/side_icon/notice_on.svg" style="width:20px;margin-right:3px;">
            <span style="font-size:13px;vertical-align:top;font-weight:bold;">공지사항</span>
    <?php } else { ?>
            <img src="/misc/img_mango/side_icon/notice_off.svg" style="width:20px;margin-right:3px;">
            <span style="font-size:13px;vertical-align:top;">공지사항</span>
    <?php } ?>
        </a>
      </li>
    </ul>
  </div>

</div>
