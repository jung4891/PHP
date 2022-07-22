<?php
$parent_group = $this->phpsession->get( 'pGroupName', 'stc' );
$group = $this->phpsession->get( 'group', 'stc' );

    if(strpos($_SERVER['REQUEST_URI'],'/board/notice') !== false){
        $headImg = 'customer01_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/maintain/maintain') !== false){
        $headImg = 'customer07_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/board/manual') !== false){
        $headImg = 'customer02_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/tech_board') !== false){
        $headImg = 'customer06_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/board/edudata') !== false){
        $headImg = 'customer02_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/board/eduevent') !== false){
        $headImg = 'customer03_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/board/faq') !== false){
    $headImg = 'customer05_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/board/network_map') !== false){
        $headImg = 'customer05_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/board/qna') !== false){
        $headImg = 'customer04_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/board/release') !== false){
        $headImg = 'customer04_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/board/suggest') !== false){
        $headImg = 'customer06_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/durian_car') !== false){
        $headImg = 'customer06_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/weekly_report')!== false){
        $headImg = 'customer06_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/schedule')!== false){
        $headImg = 'customer06_bg';
    }
?>
<style>
   /* 모달 css */
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
      z-index: 1002;
   }
      /* Modal Content/Box */
   .search-modal-content {
      background-color: #fefefe;
      margin: 15% auto; /* 15% from the top and centered */
      padding: 20px;
      border: 1px solid #888;
      width: 70%; /* Could be more or less, depending on screen size */
      z-index: 1002;
   }
</style>
<tr>
    <td height="203" align="center" background="<?php echo $misc;?>img/<?php echo $headImg; ?>.jpg">
        <table width="1130" cellspacing="0" cellpadding="0">
            <tr>
                <td width="197" height="30" background="<?php echo $misc;?>img/customer_t.png"></td>
                <td align="right">
                    <table width="15%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="right">
                                <?php if( $id != null ) {?>
                                    <a href="<?php echo site_url();?>/account/modify_view"><?php echo $name;?></a> 님 | <a href="<?php echo site_url();?>/account/logout"><img src="<?php echo $misc;?>img/btn_logout.jpg" align="absmiddle" /></a>
                                <?php }else if( $this->cooperative_id != null ) {?>
                                    <?php echo  $this->cooperative_id; ?>님 <a href="<?php echo site_url();?>/account/logout"><img src="<?php echo $misc;?>img/btn_logout.jpg" align="absmiddle" /></a>
                                <?php } else {?>
                                    <a href="<?php echo site_url();?>/account"><img src="<?php echo $misc;?>img/btn_login.jpg" align="absmiddle" /></a>
                                <?php }?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td height="173"><a href="<?php echo site_url();?>"><img src="<?php echo $misc;?>img/customer_title.png"
                            width="197" height="173" /></a></td>
                <td align="center" class="title1">고객의 미래를 생각하는 기업
                    <p class="title2">두리안정보기술센터에 오신것을 환영합니다.</p>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr style="height: 0px;">
    <td width="197" valign="top" style="background-color: #666666;">
        <div id='cssmenu'>
            <ul>
                <?php if($id){ ?>
                    <li style="float: left;"><a href='<?php echo site_url();?>/board/notice_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/board/notice') !== false){echo "class='point'";} ?> >공지사항</span></a></li>
                    <li style="float: left;"><a href='<?php echo site_url();?>/board/eduevent_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/board/eduevent') !== false){echo "class='point'";} ?>>교육 &amp;행사</span></a></li>
                    <li class='has-sub' style="float: left;"><a href='<?php echo site_url();?>/board/manual_list'><span>제조사</span></a>
                        <ul>
                            <li style="float: left;"><a href='<?php echo site_url();?>/board/manual_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/board/manual') !== false){echo "class='point'";} ?>>자료실</span></a></li>
                            <li style="float: left;"><a href='<?php echo site_url();?>/board/faq_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/board/faq') !== false){echo "class='point'";} ?>>FAQ</span></a></li>
                            <li style="float: left;"><a href='<?php echo site_url();?>/board/edudata_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/board/edudata') !== false){echo "class='point'";} ?>>교육자료</span></a></li>
                            <li style="float: left;"><a href='<?php echo site_url();?>/board/release_note_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/board/release_note') !== false){echo "class='point'";} ?>>릴리즈노트</span></a></li>
                            <li style="float: left;"><a href='<?php echo site_url();?>/tech_board/tech_device_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/board/tech_device') !== false){echo "class='point'";} ?>>장비/시스템 등록</span></a></li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if($id || $this->cooperative_id){ ?>
                    <li class='has-sub' style="float: left;"><a href='<?php echo site_url();?>/maintain/maintain_list'><span>고객사</span></a>
                        <ul>
                            <?php if($id){ ?>
                                <?php if( $this->company == 2118872631 ) {?>
                                <li style="float: left;"><a href='<?php echo site_url();?>/maintain/maintain_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/maintain/maintain') !== false){echo "class='point'";} ?>>유지보수</span></a></li>
                                <li style="float: left;"><a href='<?php echo site_url();?>/board/network_map_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/board/network_map') !== false){echo "class='point'";} ?>>구성도</span></a></li>
                                <?php } ?>
                                <li style="float: left;"><a href='<?php echo site_url();?>/tech_board/tech_doc_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/tech_board/tech_doc') !== false){echo "class='point'";} ?>>기술지원보고서</span></a></li>
                            <?php } ?>
                                <li style="float: left;"><a href='<?php echo site_url();?>/tech_board/request_tech_support_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/tech_board/request') !== false){echo "class='point'";} ?>>기술지원요청</span></a></li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if($id){ ?>
                    <li class='has-sub' style="float: left;"><a href='<?php echo site_url();?>/board/manual_list'><span>관리</span></a>
                        <ul>
                            <li style="float: left;"><a href='<?php echo site_url();?>/durian_car/car_drive_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/durian_car/car') !== false){echo "class='point'";} ?>>차량운행일지</span></a></li>
                            <li style="float: left;"><a href='<?php echo site_url();?>/weekly_report/weekly_report_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/weekly_report') !== false){echo "class='point'";} ?>>주간업무보고</span></a></li>
                        </ul>
                    </li>
                    <li class='last' style="float: left;"><a href='<?php echo site_url();?>/board/suggest_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/board/suggest') !== false){echo "class='point'";} ?>>건의사항</span></a></li>
                    <?php if ($parent_group == '기술본부' || $parent_group == 'CEO'){ ?>
                    <li class='last' style="float: left;"><a href='<?php echo site_url();?>/schedule/tech_schedule'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/schedule/tech_schedule') !== false){echo "class='point'";} ?>>일정관리</span></a></li>
                  <?php } ?>
                <?php } ?>
            </ul>
        </div>
        <!-- 점검모달 -->
        <div id="notice_modal" class="searchModal">
            <div class="search-modal-content">
                <!-- <img src="<?php echo $misc;?>img/btn_del2.jpg" style="cursor:pointer;float:right;" border="0" onClick="preview_close();"/> -->
                <h2>* 공지 *</h2>
                <div style="margin:30px 0px 30px 0px;font-size:14px;">
                <!-- 점검내용 : 아래와 같이 점검을 진행할 예정이오니 이용에 참고해주세요.<br><br>
                점검 일시 : <?php echo date("Y-m-d");?> 13:30 ~ <?php echo date("Y-m-d");?> 15:00 -->
                sales.durianit.co.kr 로 접속해주세요
                </div>
            </div>
        </div>
        <!-- 점검모달 끝 -->
    </td>
</tr>
<script type="text/javascript">
//점검 공지 띄울때 주석 제거
<?php if( $group != "기술연구소"){ ?>
$("#notice_modal").show();
<?php } ?>
</script>
