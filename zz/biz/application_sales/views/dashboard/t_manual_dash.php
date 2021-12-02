<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/dashboard.css">
<body>
  <?php
    include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
  ?>
<!-- 자료실 -->
  <div align="center">
    <div class="dash2">
      <table id="manual" class="dash_tbl2" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="dash_title" align="left"><img src="<?php echo $misc;?>img/dashboard/title_manual.png"/></td>
          <td align="right" style="padding-right:10px;"><img src="<?php echo $misc;?>img/dashboard/dash_detail.png" width="20" onclick="go_detail(this)" style="cursor:pointer;"/></td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <td colspan="2" valign="top">
            <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
              <colgroup>
                <col width="10%" />
                <col width="60%" />
                <col width="10%" />
                <col width="10%" />
                <col width="10%" />
              </colgroup>
              <tr class="t_top">
                <th height="40" align="center">NO</th>
                <th height="40" align="center">제목</th>
                <th height="40" align="center">등록자</th>
                <th height="40" align="center">날짜</th>
                <th height="40" align="center">첨부</th>
              </tr>
              <?php
                if ($manual_list_count > 0) {
                  $i = $manual_list_count;
                  $icounter = 0;

                  foreach ( $manual_list as $item ) {
                    if($item['file_changename']) {
                     $strFile = "<img src='".$misc."img/add.png' width='20' height='20' />";
                   } else {
                     $strFile = "-";
                   }
                    ?>
              <tr>
               <td height="40" align="center"><?php echo $i;?></td>
               <td align="center"><?php echo $this->common->trim_text(stripslashes($item['subject']), 100);?></td>
               <td align="center"><?php echo $item['user_name'];?></td>
               <td align="center"><?php echo $item['insert_date'];?></td>
               <td align="center"><?php echo $strFile;?></td>
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

<!-- faq -->
    <div class="dash2">
      <table id="faq" class="dash_tbl2" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="dash_title"><img src="<?php echo $misc;?>img/dashboard/title_faq.png"/></td>
          <td align="right" style="padding-right:10px;"><img src="<?php echo $misc;?>img/dashboard/dash_detail.png" width="20" onclick="go_detail(this)" style="cursor:pointer;"/></td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <td colspan="2" valign="top">
            <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
              <colgroup>
                <col width="10%" />
                <col width="60%" />
                <col width="10%" />
                <col width="10%" />
                <col width="10%" />
              </colgroup>
              <tr class="t_top">
                <th height="40" align="center">NO</th>
                <th align="center">고객사</th>
                <th align="center">제목</th>
                <th align="center">등록자</th>
                <th align="center">날짜</th>
              </tr>
              <?php
              if ($faq_list_count > 0) {
               $i = $faq_list_count;
               $icounter = 0;

              foreach ( $faq_list as $item ) {
               if($item['file_changename']) {
                $strFile = "<img src='".$misc."img/add.png' width='20' height='20' />";
              } else {
                $strFile = "-";
              }
              ?>
              <tr>
               <td height="40" align="center"><?php echo $i;?></td>
               <td align="center"><?php echo $this->common->trim_text(stripslashes($item['subject']), 100);?></td>
               <td align="center"><?php echo $item['user_name'];?></td>
               <td align="center"><?php echo $item['insert_date'];?></td>
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
  </div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
  function go_detail(el) {
    var page = $(el).closest('table').attr('id');
    if (page=="manual") {
      location.href = "<?php echo site_url();?>/tech/board/manual_list";
    } else if (page=="faq") {
      location.href = "<?php echo site_url();?>/tech/board/faq_list";
    }
  }
</script>
</html>
