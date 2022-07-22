<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/dashboard.css">
<body>
  <?php
    include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
  ?>
  <div align="center">
    <?php
      include "b_electronic_dash_1.php";
      include "b_electronic_dash_2.php";
    ?>
<!-- 환경설정 -->
    <div class="dash2">
      <table id="tech_doc" class="dash_tbl2" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top">
          <td class="dash_title"><img src="<?php echo $misc;?>img/dashboard/title_delegation_management.png"/></td>
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

<!-- 개인보관함 -->
    <?php include "b_electronic_dash_4.php"; ?>
    <?php include "b_electronic_dash_5.php"; ?>


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

  function change_tbl(id) {
    var btn_id = id.split(":");
    var id = btn_id[0];
    $(".btn_on").hide();
    $(".btn_off").show();
    $("#"+id+"\\:on").show();
    $("#"+id+"\\:off").hide();
    var cname = id.split("-")[0];
    $("."+cname+"").hide();
    $("."+cname+"").closest('tr').hide();
    $("#tbl_"+id+"").show();
    $("#tbl_"+id+"").closest('tr').show();
  }
</script>
</html>
