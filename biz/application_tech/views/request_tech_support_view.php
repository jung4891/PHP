<?php
// 김수성 추가
$cnt = 0;
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/customer_top.php";

$this->cooperative_id = $this->phpsession->get( 'cooperative_id', 'stc' );
if(strpos($view_val['cooperative_email'],$this->cooperative_id) === false && strpos($view_val['engineer_email'],$this->cooperative_id) === false && !$id){
  echo '<script>alert("해당 글을 볼 수 있는 권한이 없습니다.");location.href="'.site_url().'/tech_board/request_tech_support_list"</script>';
}
?>
<style>
    td {
        word-break: break-all;
        word-break: break-word;
    }
</style>
<body>
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <?php
    include $this->input->server('DOCUMENT_ROOT')."/include/tech_header.php";
  ?>
    <tr>
      <td align="center" valign="top">

        <table width="1130" height="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="<?php echo $misc; ?>img/btn_left.jpg" id="leftBtn" style="cursor:pointer;display:none;float:right;" onclick="changePage('left')"/></td>
            <td width="923" align="center" valign="top">
              <form name="cform" method="get">
                <input type="hidden" name="seq" value="<?php echo $seq; ?>">
                <input type="hidden" name="file_change_name" value="<?php echo $view_val['file_change_name']; ?>">
                <table width="890" border="0" style="margin-top:20px;">
                  <tr>
                    <td class="title3">기술지원요청 보기</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>
                      <table id="input_table" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td colspan="5" height="2" bgcolor="#797c88"></td>
                        </tr>
                        <tr>
                        <tr name="test_c" id="test_c">
                          <td colspan="2" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">구분</td>
                          <td style="padding-left:10px;" class="t_border">
                            <?php echo $view_val['sortation']; ?>
                          </td>
                          <td size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">지원유형</td>
                          <td style="padding-left:10px;" class="t_border">
                            <?php echo $view_val['support_type']; ?>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">고객사</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <?php echo $view_val['customer_company'];?>
                          </td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">등록자</td>
                          <td width="35%" style="padding-left:10px;" class="t_border"><?php echo $view_val['writer']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                            <td height=35 align="center" style="font-weight:bold;">* 기술 담당자</td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" rowspan="3" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">담당자</td>
                          <td rowspan="3" width="35%" style="padding-left:10px;" class="t_border">김갑진</td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">연락처</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">01024354987</td>  
                        </tr>
                        <tr>
                          <td colspan="3" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">e-mail</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">kkj@durianit.co.kr</td>  
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" rowspan="3" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">담당자</td>
                          <td rowspan="3" width="35%" style="padding-left:10px;" class="t_border">박유석</td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">연락처</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">01029133223</td>
                        </tr>
                        <tr>
                          <td colspan="3" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">e-mail</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">yspark@durianit.co.kr</td>  
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                            <td height=35 align="center" style="font-weight:bold;">* 협력사 정보</td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">협력사</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <?php echo $view_val['cooperative_company'] ;?>
                          </td>
                          <td  width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">담당자</td>
                          <td width="35%" style="padding-left:10px;" class="t_border"><?php echo $view_val['cooperative_manager'];?></td>  
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">연락처</td>
                          <td width="35%" style="padding-left:10px;" class="t_border"><?php echo $view_val['cooperative_tel'];?></td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">e-mail</td>
                          <td width="35%" style="padding-left:10px;" class="t_border"><?php echo $view_val['cooperative_email'];?></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                            <td height=35 align="center" style="font-weight:bold;">* 엔지니어 정보</td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">엔지니어</td>
                          <td width="35%" style="padding-left:10px;" class="t_border"><?php echo $view_val['engineer_name']; ?></td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">지사</td>
                          <td width="35%" style="padding-left:10px;" class="t_border"><?php echo $view_val['engineer_branch']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">연락처</td>
                          <td width="35%" style="padding-left:10px;" class="t_border"><?php echo $view_val['engineer_tel']; ?></td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">e-mail</td>
                          <td width="35%" style="padding-left:10px;" class="t_border"><?php echo $view_val['engineer_email'];?></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                            <td height=35 align="center" style="font-weight:bold;">* 사업장 정보</td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr id="err_row2">
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">사업장명</td>
                          <td width="35%" style="padding-left:10px;" class="t_border"><?php echo $view_val['workplace_name']; ?></td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">주소</td>
                          <td width="35%" style="padding-left:10px;" class="t_border"><?php echo $view_val['workplace_address']; ?></td>
                        </tr>
                        <tr id="err_row3">
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr id="err_row4">
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">담당자</td>
                          <td width="35%" style="padding-left:10px;" class="t_border"><?php echo $view_val['workplace_manager']; ?></td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">연락처</td>
                          <td width="35%" style="padding-left:10px;" class="t_border"><?php echo $view_val['workplace_tel']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">신규 장비</td>
                          <td width="35%" style="padding:10px;" class="t_border"><?php echo $view_val['produce']; ?></td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">serial</td>
                          <td width="35%" style="padding:10px;" class="t_border"><?php echo $view_val['serial']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">버전</td>
                          <td style="padding-left:10px;" class="t_border"><?php echo $view_val['version']; ?></td>
                          <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">host</td>
                          <td style="padding-left:10px;" class="t_border"><?php echo $view_val['host']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">내부 IP</td>
                          <td width="35%" style="padding:10px;" class="t_border" id="internalIP">
                            <?php if(strpos($view_val['internal_ip'],'|')!== false){
                                echo str_replace('|','<br>',$view_val['internal_ip']);
                            }else{
                                echo $view_val['internal_ip'];
                            } ?>
                          </td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">외부 고정 IP</td>
                          <td width="35%" style="padding:10px;" class="t_border"><?php echo $view_val['external_ip']; ?></td>
                        </tr>
                        <tr id='manager_input_field'>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">설치 요청일</td>
                          <td style="padding-left:10px;" class="t_border"><?php if(substr($view_val['installation_request_date'], 0, 10) != "0000-00-00"){echo substr($view_val['installation_request_date'], 0, 10);}else{echo "일정협의";} ?></td>
                          <td align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">접수 일자</td>
                          <td style="padding:10px;" class="t_border"><?php echo substr($view_val['reception_date'], 0, 10); ?></td>
                        </tr>
                        <tr id='manager_input_field'>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">설치 일자</td>
                          <td style="padding-left:10px;" class="t_border"><?php echo substr($view_val['installation_date'], 0, 10); ?></td>
                          <td align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">장비 배송일</td>
                          <td style="padding:10px;" class="t_border"><?php echo substr($view_val['delivery_date'], 0, 10); ?></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <?php if($view_val['support_type'] == "장애지원"){ ?>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">기존 장비/serial</td>
                          <td width="35%" style="padding:10px;" class="t_border"><?php echo $view_val['old_produce'].' / '.$view_val['old_serial']; ?></td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">장비회수완료</td>
                          <td width="35%" style="padding:10px;" class="t_border"><?php if($view_val['recovery_status'] == 'Y'){echo "완료"; }else{echo "미완료"; } ?></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">기타 특이사항</td>
                          <td colspan="3" style="padding-left:10px;" class="t_border"><?php echo $view_val['etc']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">진행단계</td>
                          <td style="padding-left:10px;word-break:break-all;" class="t_border"><?php echo $view_val['result']; ?></td>
                          <td align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">최종승인</td>
                          <td style="padding-left:10px;" class="t_border">
                            <?php if($view_val['final_approval']=='N'){echo '미승인';}else{ echo '승인';} ?>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">첨부파일</td>
                          <td class="t_border" style="padding-left:10px;">
                            <?php if($view_val['file_change_name']) {?><a href="<?php echo site_url();?>/tech_board/request_tech_support_download/<?php echo $seq;?>/<?php echo $view_val['file_change_name'];?>"><?php echo $view_val['file_real_name'];?></a><?php } else {?>파일없음<?php }?> </td>
                          <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">tax</td>
                          <td class="t_border" style="padding-left:10px;" colspan="3" class="t_border">
                            <!-- <?php if($view_val['tax']=='N'){echo "미발행";}else{echo "발행";} ?>        -->
                            <?php echo $view_val['tax']; ?> 
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="2" bgcolor="#797c88"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right">
                        <img src="<?php echo $misc;?>img/btn_list.jpg" border="0" style="cursor:pointer" onClick="requestTechSupportListGo();"/>
                        <img src="<?php echo $misc;?>img/btn_adjust.jpg" style="cursor:pointer" border="0" onClick="javascript:chkForm(0);return false;"/>
                        <?php if($lv == 3){ ?> 
                        <img src="<?php echo $misc;?>img/btn_add_column4.jpg" style="cursor:pointer;width:64px;hight:31px;" border="0" onClick="javascript:chkForm(1);return false;"/>
                        <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>


            </td>
            <td><img src="<?php echo $misc; ?>img/btn_right.jpg" id="rightBtn" onclick="changePage('right');" style="cursor:pointer;display:none"/></td>
          </tr>
        </table>

      </td>
    </tr>
    </form>

    <!-- 폼 끝 -->

    <tr>
      <td align="center" height="100" bgcolor="#CCCCCC">
        <table width="1130" cellspacing="0" cellpadding="0">
          <tr>
            <td width="197" height="100" align="center" background="<?php echo $misc; ?>img/customer_f_bg.png"><img src="<?php echo $misc; ?>img/f_ci.png" /></td>
            <td><?php include $this->input->server('DOCUMENT_ROOT') . "/include/customer_bottom.php"; ?></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

</body>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
<script>
  function chkForm( type ) {
    if(type == 1) {
      if (confirm("정말 삭제하시겠습니까?") == true){
        var mform = document.cform;
        mform.action="<?php echo site_url();?>/tech_board/request_tech_support_delete_action";
        mform.submit();      
        return false;
      }
    }else {
      var mform = document.cform;
      mform.action="<?php echo site_url();?>/tech_board/request_tech_support_view";
      mform.submit();
      return false;
    }
  }

  function requestTechSupportListGo(){
    location.href='<?php echo site_url(); ?>/tech_board/request_tech_support_list';
  }

</script>



</html>