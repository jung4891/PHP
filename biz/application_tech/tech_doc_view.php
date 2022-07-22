<?php
  // 김수성 추가
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";

?>

<script language="javascript">
  function chkForm( type ) {
    if(type == 1) {
      if (confirm("정말 삭제하시겠습니까?") == true){
        var mform = document.cform;
        mform.action="<?php echo site_url();?>/tech_board/tech_doc_delete_action";
        mform.submit();
        return false;
      }
    }
    else if(type == 2) {
      var mform = document.cform;
      mform.action="<?php echo site_url();?>/tech_board/tech_doc_print_action";
      //window.open("<?php echo site_url();?>/tech_board/tech_doc_print_action", 'cform', 'width=300, height=400'); 
      mform.submit();
      return false;
    } else {
      var mform = document.cform;
      mform.action="<?php echo site_url();?>/tech_board/tech_doc_view";
      mform.submit();
      return false;
    }
  }

</script>
<body>
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <script src="<?php echo $misc;?>ckeditor/ckeditor.js"></script>
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
  <tr>
    <td align="center" valign="top">

      <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
          <td width="197" valign="top" background="<?php echo $misc;?>img/customer_m_bg.png" style="min-height:620px;">

           <div id='cssmenu'>
            <ul>
             <li><a href='<?php echo site_url();?>/board/notice_list'><span>공지사항</span></a></li>
             <li class='has-sub'><a href='<?php echo site_url();?>/board/manual_list'><span>자료실</span></a>
              <ul>
               <li><a href='<?php echo site_url();?>/board/manual_list'><span>매뉴얼</span></a>
               </li>
               <li><a href='<?php echo site_url();?>/board/edudata_list'><span>교육자료</span></a>
               </li>
             </ul>
           </li>
           <li><a href='<?php echo site_url();?>/board/eduevent_list'><span>교육 &amp; 행사</span></a></li>
           <li><a href='<?php echo site_url();?>/board/qna_list'><span>QnA</span></a></li>
           <li><a href='<?php echo site_url();?>/board/faq_list'><span>FAQ</span></a></li>
           <!-- 김수성 추가 2017-02-01 -->
           <?php if( $lv == 2 || $lv == 3 ) {?>
           <li><a href='<?php echo site_url();?>/tech_board/tech_doc_list'><span class="point">기술지원보고서</span></a></li>
           <li><a href='<?php echo site_url();?>/tech_board/tech_device_list'><span>장비/시스템 등록</span></a></li>
           <?php } ?><!-- 김수성 끝 나중에 다 고쳐야됨 -->
           <li class='last'><a href='<?php echo site_url();?>/board/suggest_list'><span>건의사항</span></a></li>

         </ul>
       </div>

     </td>
     <td width="923" align="center" valign="top">

      <!-- 시작합니다. 여기서 부터  -->
      <form name="cform" method="get">
        <input type="hidden" name="seq" value="<?php echo $seq;?>">
        <input type="hidden" name="mode" value="modify">
        <table width="890" border="0" style="margin-top:20px;">
          <tr>
            <td class="title3">기술지원보고서 보기</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="5" height="2" bgcolor="#797c88"></td>
              </tr>
              <tr>
               <tr>
                 <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border"  >고객사</td>
                 <td width="35%" style="padding-left:10px;"  class="t_border" ><?php echo $view_val['customer'];?></td>
                 <td idth="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border"  >등록자</td>
                 <td width="35%" align="center"class="t_border"  ><?php echo $view_val['writer'];?></td>
               </tr>
               <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>

              <tr>
                <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >작업명(종류)</td>
                <td width="35%" style="padding-left:10px;"class="t_border"><?php echo $view_val['work_name'];?></td>
                <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >작업일</td>
                <td width="35%" style="padding-left:10px;" class="t_border" ><?php echo substr($view_val['income_time'], 0, 10);?></td>
              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>

              <!-- 여기서부터 해야되는데 -->
              <tr>
                <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >담당자명</td>
                <td width="35%" style="padding:10px;"class="t_border" ><?php echo $view_val['customer_manager'];?></td>
                <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border"  >투입시간</td>
                <td width="35%" style="padding:10px;" class="t_border" ><?php echo $view_val['total_time'];?></td>
              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
              <tr>
                <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >시작시간</td>
                <td  style="padding-left:10px;" class="t_border" ><?php echo substr($view_val['start_time'],0,5);?></td>
                <td align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border" >종료시간</td>
                <td  style="padding:10px;" class="t_border" ><?php echo substr($view_val['end_time'],0,5);?></td>
              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8" class="t_border" ></td>
              </tr>
              <tr>
                <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >담당SE</td>
                <td  style="padding-left:10px;" class="t_border" ><?php echo $view_val['engineer'];?></td>
                <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >지원방법</td>
                <td width="35%" style="padding-left:10px;" class="t_border" ><?php echo $view_val['handle'];?></td>
              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
              <tr>
                <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >제품명</td>
                <td  style="padding-left:10px;" class="t_border" ><?php echo $view_val['produce'];?></td>
                <td align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border" >버전정보</td>
                <td  style="padding-left:10px;" class="t_border" ><?php echo $view_val['version'];?></td>
              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
              <tr>
               <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >서버</td>
               <td  style="padding-left:10px;" class="t_border" ><?php echo $view_val['hardware'];?></td>
               <td align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border" >라이선스</td>
               <td  style="padding-left:10px;" class="t_border" ><?php echo $view_val['license'];?></td>
             </tr>
             <tr>
              <td colspan="5" height="1" bgcolor="#797c88"></td>
            </tr>
            <tr>
              <td colspan="2" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >지원내용</td>
              <td colspan="3"  style="padding-left:10px;" class="t_border" ><?php echo $view_val['subject'];?>
              </td>
            </tr>
            <tr>
              <td colspan="5" height="1" bgcolor="#797c88"></td>
            </tr>
            <tr>
              <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">시간</td>
              <td height="40" colspan="3" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">지원내역</td>

            </tr>
            <tr>
              <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
            </tr>

            <?php
            $tmp = explode(";;", $view_val['work_process_time']);
            $process_txt =  explode(";;", $view_val['work_process']);

            for($i=0;$i<count($tmp)-1;$i++){

              $time = explode("-",$tmp[$i]);

              ?>
              <tr>
                <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">
                  <?php echo $time[0];?>
                </td>
                <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">
                  <?php echo $time[1];?>
                </td>
                <td colspan="4" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">
                  <?php echo $process_txt[$i];?>
                </td>
              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>


              <?php
            }

            ?>

<!-- 백업
                <tr>
                  <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">
                        <?php //echo $view_val['work_process_time'];?>
                  </td>
                  <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">
                        <?php //echo $view_val['work_process_time'];?>
                  </td>
                  <td colspan="4" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">
                        <?php //echo $view_val['work_process'];?>
                  </td>
                </tr>
              -->



              <tr>
                <td colspan="5" height="1" bgcolor="#797c88"></td>
              </tr>
              <tr>
                <td colspan="2" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >지원결과</td>
                <td colspan="3" style="padding-left:10px;" class="t_border" ><?php echo $view_val['result'];?></td>
              </tr>


              <tr>
                <td colspan="5" height="2" bgcolor="#797c88"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="right">

              <img src="<?php echo $misc;?>img/btn_list.jpg" border="0" style="cursor:pointer" onClick="javascript:history.go(-1);"/>
              <img src="<?php echo $misc;?>img/btn_print.jpg" border="0" style="cursor:pointer" onClick="chkForm(2);return false;"/>
              <?php if($name == $view_val['writer'] || $lv == 3) {?><img src="<?php echo $misc;?>img/btn_adjust.jpg" style="cursor:pointer" border="0" onClick="javascript:chkForm(0);return false;"/> <img src="<?php echo $misc;?>img/btn_add_column4.jpg" style="cursor:pointer" border="0" onClick="javascript:chkForm(1);return false;"/><?php }?></td>



              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>


          </td>
          <td width="8" background="<?php echo $misc;?>img/right_bg.png"></td>
        </tr>
      </table>

    </td>
  </tr>
</form>

<!-- 폼 끝 -->

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

