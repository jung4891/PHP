<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
  // tech_device_view 김수성  170209
?>
<script language="javascript">
  function chkForm( type ) {
    if(type == 1) {
      if (confirm("정말 삭제하시겠습니까?") == true){
        var mform = document.cform;
        mform.action="<?php echo site_url();?>/tech_board/tech_device_delete_action";
        mform.submit();
        return false;
      }
    } else {
      var mform = document.cform;
      mform.action="<?php echo site_url();?>/tech_board/tech_device_view";
      mform.submit();
      return false;
    }
  }

//$(document).ready(function() {
//   $('li > ul').show();
//});
</script>


<body>
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<!--    <form name="cform" method="post">
      <<input type="hidden" name="seq" value="<?php //echo $seq;?>">
      <input type="hidden" name="mode" value="modify">-->
      <tr>
        <td height="203" align="center" background="<?php echo $misc;?>img/customer06_bg.jpg">
          <table width="1130" cellspacing="0" cellpadding="0" >
            <tr>
              <td width="197" height="30" background="<?php echo $misc;?>img/customer_t.png"></td>
              <td align="right"><table width="15%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="right"><?php if( $id != null ) {?>
                    <a href="<?php echo site_url();?>/account/modify_view"><?php echo $name;?></a> 님 | <a href="<?php echo site_url();?>/account/logout"><img src="<?php echo $misc;?>img/btn_logout.jpg" align="absmiddle" /></a>
                    <?php } else {?>
                    <a href="<?php echo site_url();?>/account"><img src="<?php echo $misc;?>img/btn_login.jpg" align="absmiddle" /></a>
                    <?php }?></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="173"><a href="<?php echo site_url();?>"><img src="<?php echo $misc;?>img/customer_title.png" width="197" height="173" /></a></td>
                <td align="center" class="title1">고객의 미래를 생각하는 기업
                  <p class="title2">두리안정보기술센터에 오신것을 환영합니다.</p></td>
                </tr>
              </table>
            </td>
          </tr>
	  <tr style="height: 0px;">
		<td width="197" valign="top" style="background-color: #666666;">
              
             <div id='cssmenu'>
              <ul>
               <li style="float: left;"><a href='<?php echo site_url();?>/board/notice_list'><span>공지사항</span></a></li>
				<li style="float: left;"><a href='<?php echo site_url();?>/board/eduevent_list'><span>교육 &amp; 행사</span></a></li>
               <li class='has-sub' style="float: left;"><a href='<?php echo site_url();?>/board/manual_list'><span>제조사</span></a>
                <ul>
                 <li style="float: left;"><a href='<?php echo site_url();?>/board/manual_list'><span>자료실</span></a>
                 </li>
			     <li style="float: left;"><a href='<?php echo site_url();?>/board/faq_list'><span>FAQ</span></a></li>
                 <li style="float: left;"><a href='<?php echo site_url();?>/board/edudata_list'><span>교육자료</span></a>
				 <li style="float: left;"><a href='<?php echo site_url();?>/board/release_note_list'><span>릴리즈노트</span></a></li>
				 <li style="float: left;"><a href='<?php echo site_url();?>/tech_board/tech_device_list'><span class="point">장비/시스템 등록</span></a></li>
                 </li>
               </ul>
             </li>
           
<!--             <li><a href='<?php echo site_url();?>/board/qna_list'><span>QnA</span></a></li>-->
            
             <!-- 김수성 추가 2017-02-01 -->
	  		 <li class='has-sub' style="float: left;"><a href='<?php echo site_url();?>/maintain/maintain_list'><span>고객사</span></a>
	 		 <ul>
             <?php if( $this->company == 2118872631 ) {?>
	  		<li style="float: left;"><a href='<?php echo site_url();?>/maintain/maintain_list'><span>유지보수</span></a></li>
          	 <li style="float: left;"><a href='<?php echo site_url();?>/board/network_map_list'>구성도</span></a></li>
             <?php } ?><!-- 김수성 끝 나중에 다 고쳐야됨 -->
 			<li style="float: left;"><a href='<?php echo site_url();?>/tech_board/tech_doc_list'><span>기술지원보고서</span></a></li>
			</ul>
			<li style="float: left;"><a href='<?php echo site_url();?>/durian_car/car_drive_list'>차량운행일지</span></a></li>
             <li class='last' style="float: left;"><a href='<?php echo site_url();?>/board/suggest_list'><span>건의사항</span></a></li>

           </ul>
		</li>
         </div>
       </td>
</tr>
          <tr>
            <td align="center" valign="top">

              <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
                <tr>
                  
             <td width="923" align="center" valign="top">


              <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
                <tr>
                  <td class="title3">장비/시스템 보기</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>

                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="4" height="2" bgcolor="#797c88"></td>
                    </tr>
                    <tr>
                     <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">고객사</td>
                     <td class="t_border" style="padding-left:10px;"><?php //echo $view_val['customer_companyname'];?></td>
                     <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">프로젝트명</td>
                     <td width="35%" class="t_border" style="padding-left:10px;"><?php //echo $view_val['project_name'];?></td>
                   </tr>
                   <tr>
                    <td width="15%" height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비명</td>
                    <td width="35%" class="t_border" style="padding-left:10px;"><?php //echo $view_val['product_name'];?>

                    </select></td>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td>
                    <td width="35%" height="40" class="t_border" style="padding-left:10px;"><?php //echo $view_val['product_item'];?></td>
                  </tr>
                  <tr>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제조사</td>
                    <td width="35%" height="40" class="t_border" style="padding-left:10px;"><?php //echo $view_val['product_company'];?></td>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">Serial Number</td>
                    <td width="35%" height="40" class="t_border" style="padding-left:10px;"><?php //echo $view_val['product_serial'];?></td>
                  </tr>
                  <tr>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">Version</td>
                    <td width="35%" height="40" class="t_border" align="center" ><?php //echo //$view_val['product_version'];?></td>
                    <td idth="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">상태</td>
                    <td width="35%" height="40" class="t_border" align="center"><?php //echo //$view_val['product_state'];?></td>
                  </tr>
                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
              </tr>              
              <td align="right"><img src="<?php echo $misc;?>img/btn_list.jpg" border="0" style="cursor:pointer" onClick="javascript:history.go(-1);"/> <?php //if($name == $view_val['writer'] || $lv == 3) {?><img src="<?php echo $misc;?>img/btn_adjust.jpg" style="cursor:pointer" border="0" onClick="javascript:chkForm(0);return false;"/> <img src="<?php echo $misc;?>img/btn_delete.jpg" style="cursor:pointer" border="0" onClick="javascript:chkForm(1);return false;"/><?php }?></td>
            </tr>              
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>

        </td>
        
      </tr>
    </table>
<!--  </form>-->

</td>
</tr>
<tr>
  <td align="center" height="100" bgcolor="#CCCCCC"><table width="1130" cellspacing="0" cellpadding="0" >      
    <tr>
      <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img src="<?php echo $misc;?>img/f_ci.png"/></td>
      <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/customer_bottom.php"; ?></td>
    </tr>
  </table></td>
</tr>
</table>

</body>
</html>
