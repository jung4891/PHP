<?php
// 김수성 추가
$cnt = 0;
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

$this->cooperative_id = $this->phpsession->get( 'cooperative_id', 'stc' );
if ($this->cooperative_id != '') {
  if(strpos($view_val['cooperative_email'],$this->cooperative_id) === false && strpos($view_val['engineer_email'],$this->cooperative_id) === false && !$id){
    echo '<script>alert("해당 글을 볼 수 있는 권한이 없습니다.");location.href="'.site_url().'/tech/tech_board/request_tech_support_list"</script>';
  }
}
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style>
    td {
        word-break: break-all;
        word-break: break-word;
    }
</style>
<body>
  <?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
  $visit_date = explode('/*/',$view_val['visit_date']);
  $visit_remark = explode('/*/',$view_val['visit_remark']);
  $visit_count = count($visit_date) - 1;
?>
<div align="center">
	<div class="dash1-1">
		<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<tr height="5%">
				<td class="dash_title">
					기술지원요청
				</td>
			</tr>
			<tr>
				<td height="40"></td>
			</tr>
			<tr>
				<td align="right" style="padding-right:15%;">
          <?php if($tech_lv > 0){ ?>
					<input type="button" class="btn-common btn-color4" value="삭제" onClick="javascript:chkForm(1);return false;">
          <?php } ?>
					<input type="button" class="btn-common btn-color4" value="수정" onClick="javascript:chkForm(0);return false;">
					<input type="button" class="btn-common btn-color2" value="목록" onClick="requestTechSupportListGo();">
				</td>
			</tr>
      <tr>
				<td height="40"></td>
			</tr>
  		<tr>
    		<td width="100%" align="center" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
              <td>
                <form name="cform" method="get">
                  <input type="hidden" name="seq" value="<?php echo $seq; ?>">
                  <input type="hidden" name="file_change_name" value="<?php echo $view_val['file_change_name']; ?>">
                  <table id="input_table" width="70%" border="0" cellspacing="0" cellpadding="0" style="margin-left:12%;">
                    <colgroup>
                      <col width="20%">
                      <col width="30%">
                      <col width="20%">
                      <col width="30%">
                    </colgroup>
                    <tr>
      								<td colspan="4" height="1" bgcolor="#F4F4F4"></td>
      							</tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">구분</td>
                      <td class="tbl-cell"><?php echo $view_val['sortation'];?></td>
                      <td class="tbl-title">지원유형</td>
                      <td class="tbl-cell"><?php echo $view_val['support_type'];?></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">고객사</td>
                      <td class="tbl-cell"><?php echo $view_val['customer_company'];?></td>
                      <td class="tbl-title">등록자</td>
                      <td class="tbl-cell"><?php echo $view_val['writer'];?></td>
                    </tr>
                    <tr>
      								<td colspan="4" height="1" bgcolor="#F4F4F4"></td>
      							</tr>

      							<tr><td height=30></td></tr>

      							<tr>
      								<td class="tbl-sub-title">기술 담당자</td>
      							</tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
            <?php foreach ($durian_engineer as $de) { ?>
                    <tr class="tbl-tr">
                      <td class="tbl-title" rowspan="3">담당자</td>
                      <td class="tbl-cell" rowspan="3"><?php echo $de['user_name'];?></td>
                      <td class="tbl-title">연락처</td>
                      <td class="tbl-cell"><?php echo $de['user_tel'];?></td>
                    </tr>
                    <tr>
      								<td colspan="2" height="1" bgcolor="#F4F4F4"></td>
      							</tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">e-mail</td>
                      <td class="tbl-cell"><?php echo $de['user_email'];?></td>
                    </tr>
                    <tr>
      								<td colspan="4" height="1" bgcolor="#F4F4F4"></td>
      							</tr>
            <?php } ?>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>

      							<tr><td height=30></td></tr>

      							<tr>
      								<td class="tbl-sub-title">협력사 정보</td>
      							</tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">협력사</td>
                      <td class="tbl-cell"><?php echo $view_val['cooperative_company'];?></td>
                      <td class="tbl-title">담당자</td>
                      <td class="tbl-cell"><?php echo $view_val['cooperative_manager'];?></td>
                    </tr>
                    <tr>
      								<td colspan="4" height="1" bgcolor="#F4F4F4"></td>
      							</tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">연락처</td>
                      <td class="tbl-cell"><?php echo $view_val['cooperative_tel'];?></td>
                      <td class="tbl-title">e-mail</td>
                      <td class="tbl-cell"><?php echo $view_val['cooperative_email'];?></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>

      							<tr><td height=30></td></tr>

      							<tr>
      								<td class="tbl-sub-title">엔지니어 정보</td>
      							</tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">엔지니어</td>
                      <td class="tbl-cell"><?php echo $view_val['engineer_name'];?></td>
                      <td class="tbl-title">지사</td>
                      <td class="tbl-cell"><?php echo $view_val['engineer_branch'];?></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">연락처</td>
                      <td class="tbl-cell"><?php echo $view_val['engineer_tel'];?></td>
                      <td class="tbl-title">e-mail</td>
                      <td class="tbl-cell"><?php echo $view_val['engineer_email'];?></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>

      							<tr><td height=30></td></tr>

      							<tr>
      								<td class="tbl-sub-title">사업장 정보</td>
      							</tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">사업장명</td>
                      <td class="tbl-cell"><?php echo $view_val['workplace_name'];?></td>
                      <td class="tbl-title">주소</td>
                      <td class="tbl-cell"><?php echo $view_val['workplace_address'];?></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">담당자</td>
                      <td class="tbl-cell"><?php echo $view_val['workplace_manager'];?></td>
                      <td class="tbl-title">연락처</td>
                      <td class="tbl-cell"><?php echo $view_val['workplace_tel'];?></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">신규 장비</td>
                      <td class="tbl-cell"><?php echo $view_val['produce'];?></td>
                      <td class="tbl-title">serial</td>
                      <td class="tbl-cell"><?php echo $view_val['serial'];?></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">버전</td>
                      <td class="tbl-cell"><?php echo $view_val['version'];?></td>
                      <td class="tbl-title">host</td>
                      <td class="tbl-cell"><?php echo $view_val['host'];?></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">내부 IP</td>
                      <td class="tbl-cell">
                        <?php if(strpos($view_val['internal_ip'],'|')!== false){
                            echo str_replace('|','<br>',$view_val['internal_ip']);
                        }else{
                            echo $view_val['internal_ip'];
                        } ?>
                      </td>
                      <td class="tbl-title">외부 고정 IP</td>
                      <td class="tbl-cell"><?php echo $view_val['external_ip'];?></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">설치 요청일</td>
                      <td class="tbl-cell"><?php if(substr($view_val['installation_request_date'], 0, 10) != "0000-00-00"){echo substr($view_val['installation_request_date'], 0, 10);}else{echo "일정협의";} ?></td>
                      <td class="tbl-title">접수 일자</td>
                      <td class="tbl-cell"><?php echo substr($view_val['reception_date'], 0, 10); ?></td>
                    </tr>
                    <?php
                    for ($i=0; $i<$visit_count; $i++) {
                    ?>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">방문 일자</td>
                      <td class="tbl-cell"><?php echo $visit_date[$i]; ?></td>
                      <td class="tbl-title">비고</td>
                      <td class="tbl-cell"><?php echo $visit_remark[$i]; ?></td>
                    </tr>
                    <?php
                    }
                     ?>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">설치 일자</td>
                      <td class="tbl-cell"><?php echo substr($view_val['installation_date'], 0, 10); ?></td>
                      <td class="tbl-title">장비 배송일</td>
                      <td class="tbl-cell"><?php echo substr($view_val['delivery_date'], 0, 10); ?></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
            <?php if($view_val['support_type'] == "장애지원"){ ?>
                    <tr class="tbl-tr">
                      <td class="tbl-title">기존 장비/serial</td>
                      <td class="tbl-cell"><?php echo $view_val['old_produce'].' / '.$view_val['old_serial']; ?></td>
                      <td class="tbl-title">장비회수완료</td>
                      <td class="tbl-cell"><?php if($view_val['recovery_status'] == 'Y'){echo "완료"; }else{echo "미완료"; } ?></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
            <?php } ?>
                    <tr class="tbl-tr">
                      <td class="tbl-title">기타 특이사항</td>
                      <td class="tbl-cell" colspan="3"><?php echo $view_val['etc']; ?></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">진행단계</td>
                      <td class="tbl-cell"><?php echo $view_val['result']; ?></td>
                      <td class="tbl-title">최종승인</td>
                      <td class="tbl-cell"><?php if($view_val['final_approval']=='N'){echo '미승인';}else{ echo '승인';} ?></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">첨부파일</td>
                      <td class="tbl-cell">
                        <?php if($view_val['file_change_name']) {?><a href="<?php echo site_url();?>/tech/tech_board/request_tech_support_download/<?php echo $seq;?>/<?php echo $view_val['file_change_name'];?>"><?php echo $view_val['file_real_name'];?></a><?php } else {?>파일없음<?php }?>
                      </td>
                      <td class="tbl-title">tax</td>
                      <td class="tbl-cell"></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>

                  </table>
                </form>
              </td>
            </tr>
					</table>
				</td>
			</tr>
			<tr>
				<td height="50"></td>
			</tr>

		</table>
	</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
<script>
  function chkForm( type ) {
    if(type == 1) {
      if (confirm("정말 삭제하시겠습니까?") == true){
        var mform = document.cform;
        mform.action="<?php echo site_url();?>/tech/tech_board/request_tech_support_delete_action";
        mform.submit();
        return false;
      }
    }else {
      var mform = document.cform;
      mform.action="<?php echo site_url();?>/tech/tech_board/request_tech_support_view";
      mform.submit();
      return false;
    }
  }

  function requestTechSupportListGo(){
    location.href='<?php echo site_url(); ?>/tech/tech_board/request_tech_support_list';
  }

</script>
</html>
