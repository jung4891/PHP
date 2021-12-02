<?php
    if(strpos($_SERVER['REQUEST_URI'],'/account/user') !== false){
        $headImg = 'customer04_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/company/companynum') !== false){
        $headImg = 'customer05_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/company/product') !== false){
        $headImg = 'customer07_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/customer/customer') !== false){
        $headImg = 'customer08_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/customer/sourcing') !== false){
        $headImg = 'customer06_bg';
    }else if(strpos($_SERVER['REQUEST_URI'],'/account/group_tree_management') !== false){
        $headImg = 'customer04_bg';
    }
?>
<tr>
    <td height="203" align="center" background="<?php echo $misc;?>img/<?php echo $headImg ?>.jpg">
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
                <td height="173"><a href="<?php echo site_url();?>"><img src="<?php echo $misc;?>img/admin_title.png"
                            width="197" height="173" /></a></td>
                <td align="center" class="title1">고객의 미래를 생각하는 기업
                    <p class="title2">두리안정보기술센터에 오신것을 환영합니다.</p>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr style="height: 0px;">
    <td width="197" valign="top" style="background-color: #666666">
        <div id='cssmenu'>
            <ul>
            <?php if($id){ ?>
                <li style="float: left"><a href='<?php echo site_url();?>/account/user'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/account/user') !== false){echo "class='point'";} ?> >회원정보</span></a></li>
                <li style="float: left"><a href='<?php echo site_url();?>/company/companynum_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/company/companynum') !== false){echo "class='point'";} ?>>사업자등록번호</span></a></li>
                <li style="float: left"><a href='<?php echo site_url();?>/company/product_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/company/product') !== false){echo "class='point'";} ?>>제품명</span></a></li>
            <?php } ?>
                <li style="float: left"><a href='<?php echo site_url();?>/customer/customer_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/customer/customer') !== false){echo "class='point'";} ?>>거래처</span></a></li>
            <?php if($id){ ?>
                <li class="last" style="float: left"><a href='<?php echo site_url();?>/customer/sourcing_list'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/customer/sourcing') !== false){echo "class='point'";} ?>>Sourcing Group</span></a></li>
                <li class="last" style="float: left"><a href='<?php echo site_url();?>/account/group_tree_management'><span <?php if(strpos($_SERVER['REQUEST_URI'],'/account/group_tree_management') !== false){echo "class='point'";} ?>>조직도관리</span></a></li>
            <?php } ?>
            </ul>
        </div>
        <!-- 점검모달 -->
        <div id="notice_modal" class="searchModal">
            <div class="search-modal-content">
                <!-- <img src="<?php echo $misc;?>img/btn_del2.jpg" style="cursor:pointer;float:right;" border="0" onClick="preview_close();"/> -->
                <h2>* 점검공지 *</h2>
                <div style="margin:30px 0px 30px 0px;font-size:14px;">
                점검내용 : 아래와 같이 점검을 진행할 예정이오니 이용에 참고해주세요.<br><br>
                점검 일시 : <?php echo date("Y-m-d");?> 13:30 ~ <?php echo date("Y-m-d");?> 15:00
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
