<div class="dash2">
  <table id="tech_support" class="dash_tbl2" border="0" cellspacing="0" cellpadding="0">
    <tr valign="top">
      <td class="dash_title"><img src="<?php echo $misc;?>img/dashboard/title_personal_storage.png"/></td>
      <td align="right" style="padding-right:10px; padding-top:10px"><img src="<?php echo $misc;?>img/dashboard/dash_detail.png" width="20" onclick="go_detail(this)" style="cursor:pointer;"/></td>
    </tr>
    <tr>
      <td height="10"></td>
    </tr>
    <tr>
      <td colspan="2" valign="top">
        <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
          <colgroup>
            <col width="5%">
            <col width="20%">
            <col width="20%">
            <col width="15%">
            <col width="5%">
            <col width="10%">
            <col width="5%">
            <col width="5%">
            <col width="5%">
            <col width="5%">
            <col width="5%">
          </colgroup>
          <tr class="t_top">
            <th height="40" align="center">NO</th>
            <th align="center">고객사</th>
            <th align="center">협력사</th>
            <th align="center">사업장명</th>
            <th align="center">장비명</th>
            <th align="center">설치요청일</th>
            <th align="center">설치일</th>
            <th align="center">장비배송일</th>
            <th align="center">진행단계</th>
            <th align="center">세금계산서</th>
            <th align="center">최종승인</th>
          </tr>
          <?php
          if ($request_tech_support_list_count > 0) {
            $i = $request_tech_support_list_count;
            $icounter = 0;

            foreach ($request_tech_support_list as $item) {
              if($item['file_change_name']) {
                $strFile = "<img src='".$misc."img/add.png' width='20' height='20' />";
              } else {
                $strFile = "-";
              }
            ?>
          <tr>
            <td height="40" align="center"><?php echo $i;?></td>
            <td align="center"><?php echo $item['customer_company'];?></td>
            <td align="center"><?php echo $item['cooperative_company'];?></td>
            <td align="center"><?php echo $item['workplace_name'];?></td>
            <td align="center"><?php echo $item['produce'];?></td>
            <td align="center"><?php if($item['installation_request_date'] != "0000-00-00"){echo $item['installation_request_date'];}else{echo "일정협의";}?></td>
            <td align="center"><?php echo $item['installation_date'];?></td>
            <td align="center"><?php echo $item['delivery_date'];?></td>
            <td align="center"><?php echo $item['result'];?></td>
            <td align="center"><?php echo $item['tax'];?></td>
            <td align="center"><?php if($item['final_approval'] =='N'){echo "미승인";}else{echo "승인";} ?></td>
          </tr>
            <?php
            $i--;
            $icounter++;
            }
          } else {
          ?>
          <tr>
            <td width="100%" height="40" align="center" colspan="6">등록된 게시물이 없습니다.</td>
          </tr>
          <?php
          }?>
        </table>
      </td>
    </tr>
  </table>
</div>
