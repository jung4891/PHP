<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/dashboard.css">
<body>
  <?php
    include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
  ?>
<!-- 유지보수 -->
  <div align="center">
    <div class="dash2">
      <table id="maintain" class="dash_tbl2" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="dash_title" align="left"><img src="<?php echo $misc;?>img/dashboard/title_maintain.png"/></td>
          <td align="right" style="padding-right:10px;"><img src="<?php echo $misc;?>img/dashboard/dash_detail.png" width="20" onclick="go_detail(this)" style="cursor:pointer;"/></td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <td colspan="2" valign="top">
            <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
              <colgroup>
                <col width="5%" />
                <col width="15%" />
                <col width="30%" />
                <col width="15%" />
                <col width="10%" />
                <col width="5%" />
                <col width="5%" />
                <col width="10%" />
              </colgroup>
              <tr class="t_top">
                <th height="40" align="center">NO</th>
                <th height="40" align="center">고객사</th>
                <th height="40" align="center">프로젝트</th>
                <th height="40" align="center">유지보수종료일</th>
                <th height="40" align="center">점검주기</th>
                <th height="40" align="center">관리팀</th>
                <th height="40" align="center">점검자</th>
                <th height="40" align="center">점검여부</th>
              </tr>
              <?php
                if ($maintain_list_count > 0) {
                  $i = $maintain_list_count;
                  $icounter = 0;

                  foreach ( $maintain_list as $item ) {


                    if($item['manage_team']=="1"){
                        $strstep ="기술1팀";
                    }else if($item['manage_team']=="2"){
                        $strstep ="기술2팀";
                    }else if($item['manage_team']=="3"){
                        $strstep ="기술3팀";
                    }else{
                        $strstep ="없음";
                    }
                    ?>
              <tr>
               <td height="40" align="center"><?php echo $i;?></td>
               <td align="center"><?php echo $item['customer_companyname'];?></td>
               <td align="center"><?php echo $item['project_name'];?></td>
               <td align="center"><?php echo $item['exception_saledate3'];?></td>
               <td align="center">
                 <?php
                 switch($item['maintain_cycle']){
                  case 0:
                    echo "장애시";
                    break;
                  case 1:
                    echo "월점검";
                    break;
                  case 3:
                    echo "분기점검";
                    break;
                  case 6:
                    echo "반기점검";
                    break;
                  case 7:
                    echo "미점검";
                    break;
                  default:
                    echo "미선택";
                    break;
                }
                ?>
               </td>
               <td align="center"><?php echo $strstep;?></td>
               <td align="center"><?php echo $item['maintain_user'];?></td>
               <td align="center">
                 <?php
                 switch($item['maintain_result']){
                  case 0:
                    echo "미완료";
                    break;
                  case 1:
                    echo "완료";
                    break;
                  case 3:
                    echo "미해당";
                    break;
                  case 9:
                    echo "예정";
                    break;
                  default:
                    echo "미선택";
                    break;
                }
                ?>
             </tr>
                 <?php
          				$i--;
          				$icounter++;
          			}
          		} else {
          	?>
              <tr>
                <td width="100%" height="40" align="center" colspan="9">등록된 게시물이 없습니다.</td>
              </tr>
	<?php
		}
	?>
            </table>
          </td>
        </tr>
      </table>
    </div>

<!-- 구성도 -->
    <div class="dash2">
      <table id="network" class="dash_tbl2" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="dash_title"><img src="<?php echo $misc;?>img/dashboard/title_network.png"/></td>
          <td align="right" style="padding-right:10px;"><img src="<?php echo $misc;?>img/dashboard/dash_detail.png" width="20" onclick="go_detail(this)" style="cursor:pointer;"/></td>
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
                <col width="40%">
                <col width="10%">
                <col width="15%">
                <col width="10%">
              </colgroup>
              <tr class="t_top">
                <th height="40" align="center">NO</th>
                <th align="center">고객사</th>
                <th align="center">제목</th>
                <th align="center">등록자</th>
                <th align="center">날짜</th>
                <th align="center">첨부</th>
              </tr>
              <?php
              if ($network_map_list_count > 0) {
               $i = $network_map_list_count;
               $icounter = 0;

              foreach ( $network_map_list as $item ) {
               if($item['file_changename']) {
                $strFile = "<img src='".$misc."img/add.png' width='20' height='20' />";
              } else {
                $strFile = "-";
              }
              ?>
              <tr>
               <td height="40" align="center"><?php echo $i;?></td>
               <td height="40" align="center"><?php echo $item['category_code']?></td>
               <td align="center"><?php echo $this->common->trim_text(stripslashes($item['subject']), 100);?></td>
               <td align="center"><?php echo $item['user_name'];?></td>
               <td align="center"><?php echo substr($item['insert_date'], 0, 10);?></td>
               <td align="center"><?php echo $strFile;?></td>
               </tr>
               <?php
               $i--;
               $icounter++;
               }
               } else {
               ?>
               <tr>
                 <td width="100%" height="40" align="center" colspan="5">등록된 게시물이 없습니다.</td>
               </tr>
               <?php
               }
               ?>
            </table>
          </td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
      </table>
    </div>

<!-- 기술지원보고서 -->
    <div class="dash2">
      <table id="tech_doc" class="dash_tbl2" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top">
          <td class="dash_title"><img src="<?php echo $misc;?>img/dashboard/title_tech_doc.png"/></td>
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
                <col width="35%">
                <col width="10%">
                <col width="10%">
                <col width="15%">
                <col width="5%">
              </colgroup>
              <tr class="t_top">
                <th height="40" align="center">NO</th>
                <th align="center">고객사</th>
                <th align="center">작업명</th>
                <th align="center">작성자</th>
                <th align="center">작성일</th>
                <th align="center">결과</th>
                <th align="center">첨부</th>
              </tr>
              <?php
              if ($tech_doc_list_count > 0) {
                $i = $tech_doc_list_count;
                $icounter = 0;

                foreach ($tech_doc_list as $item) {
                  if($item['file_changename']) {
                    $strFile = "<img src='".$misc."img/add.png' width='20' height='20' />";
                  } else {
                    $strFile = "-";
                  }
                ?>
              <tr>
                <td height="40" align="center"><?php echo $i;?></td>
                <td align="center"><?php echo $item['customer'];?></td>
                <td align="center"><?php echo $item['subject'];?></td>
                <td align="center"><?php echo $item['writer'];?></td>
                <td align="center"><?php echo substr($item['income_time'], 0, 10);?></td>
                <td align="center"><?php echo $item['result'];?></td>
                <td align="center"><?php echo $strFile;?></td>
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

<!-- 기술지원요청 -->
    <div class="dash2">
      <table id="tech_support" class="dash_tbl2" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top">
          <td class="dash_title"><img src="<?php echo $misc;?>img/dashboard/title_tech_support.png"/></td>
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
  </div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
  function go_detail(el) {
    var page = $(el).closest('table').attr('id');
    if (page=="maintain") {
      location.href = "<?php echo site_url();?>/tech/maintain/maintain_list";
    } else if (page=="network") {
      location.href = "<?php echo site_url();?>/tech/board/network_map_list";
    } else if (page=="tech_doc") {
      location.href = "<?php echo site_url();?>/tech/tech_board/tech_doc_list";
    } else if (page=="tech_support") {
      location.href = "<?php echo site_url();?>/tech/tech_board/request_tech_support_list";
    }
  }
</script>
</html>
