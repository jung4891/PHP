<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/dashboard.css">
<body>
  <?php
    include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
  ?>
<!-- 차량 -->
  <div align="center">
    <div class="dash2">
      <table id="car" class="dash_tbl2" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="dash_title" align="left"><img src="<?php echo $misc;?>img/dashboard/title_car.png"/></td>
          <td align="right" style="padding-right:10px;"><img src="<?php echo $misc;?>img/dashboard/dash_detail.png" width="20" onclick="go_detail(this)" style="cursor:pointer;"/></td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <td colspan="2" valign="top">
            <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
              <colgroup>
                <col width="20%" />
                <col width="20%" />
                <col width="40%" />
                <col width="20%" />
              </colgroup>
              <tr class="t_top">
                <th height="40" align="center">NO</th>
                <th height="40" align="center">차종</th>
                <th height="40" align="center">번호</th>
                <th height="40" align="center">등록일</th>
              </tr>
              <?php
                if ($car_list_count > 0) {
                  $i = $car_list_count;
                  $icounter = 0;

                  foreach ( $car_list as $item ) {
                    ?>
              <tr>
               <td height="40" align="center"><?php echo $i;?></td>
               <td align="center"><?php echo $item['type'];?></td>
               <td align="center"><?php echo $item['number'];?></td>
               <td align="center"><?php echo substr($item['insert_date'], 0, 10);?></td>
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

<!-- 미팅룸 -->
    <div class="dash2">
      <table id="meeting_room" class="dash_tbl2" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="dash_title"><img src="<?php echo $misc;?>img/dashboard/title_meeting_room.png"/></td>
          <td align="right" style="padding-right:10px;"><img src="<?php echo $misc;?>img/dashboard/dash_detail.png" width="20" onclick="go_detail(this)" style="cursor:pointer;"/></td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <td colspan="2" valign="top">
            <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
              <colgroup>
                <col width="20%" />
                <col width="20%" />
                <col width="40%" />
                <col width="20%" />
              </colgroup>
              <tr class="t_top">
                <th height="40" align="center">NO</th>
                <th align="center">회의실명</th>
                <th align="center">위치</th>
                <th align="center">등록일</th>
              </tr>
              <?php
              if ($meeting_room_list_count > 0) {
               $i = $meeting_room_list_count;
               $icounter = 0;

              foreach ( $meeting_room_list as $item ) {
              ?>
              <tr>
               <td height="40" align="center"><?php echo $i;?></td>
               <td align="center"><?php echo $item['room_name'];?></td>
               <td align="center"><?php echo $item['location'];?></td>
               <td align="center"><?php echo substr($item['insert_date'], 0, 10);?></td>
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
    if (page=="car") {
      location.href = "<?php echo site_url();?>/admin/equipment/car_list";
    } else if (page=="meeting_room") {
      location.href = "<?php echo site_url();?>/admin/equipment/meeting_room_list";
    }
  }
</script>
</html>
