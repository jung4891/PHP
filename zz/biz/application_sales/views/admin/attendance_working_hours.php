<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">

<style>
.contents_tbl th{
		/* border-color:#c0c0c0;
		border-style:solid;
		border-width:1px;
		height:40px;
		background-color: #efefef; */
		text-align:center;
		font-size: 16px;
		font-weight:bold;

}

.contents_tbl td{
		/* border-color:#c0c0c0;
		border-style:solid;
		border-width:1px; */
		height:40px;
		font-size: 14px;
		text-align:center;
}
</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.9.2/i18n/jquery.ui.datepicker-ko.min.js"></script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div class="contents_container" align="center">
  <!-- 타이틀 -->
  <div class="contents_item dash_title" style="margin-top:30px;display:flex;">
    <p align="left">
      근로시간
    </p>
  </div>
  <!-- 기간 검색창 -->
  <div class="contents_item" align="left">
		<form name="mform" action="" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
	<!-- 부서 -->
	<select class="select-common" name="search_group">
		<option value="">전체</option>
<?php
		if (isset($_GET['search_group'])) {
			$search_group = $_GET['search_group'];
		} else {
			$search_group = '';
		}
				foreach ($pgroup_name as $pn){
					if($search_group == $pn['pgroup']){
						$select = "selected";
					}else{
						$select = "";
					}
?>
		<option value="<?php echo $pn['pgroup'] ?>" <?php echo $select ?>><?php echo $pn['pgroup'] ?></option>
<?php
	}
?>
	</select>
  <!-- <span style="color:red;font-size:15px;margin-left:20px">*</span>검색일 -->
    <input class="input-common" type="text" name="search_month" id="search_month" value="<?php
    if (isset($_GET['search_month'])){
      echo $_GET['search_month'];
    } else {
      echo date("Y-m");
    }
    ?>" style="width:55px;" readonly>
    <select class="select-common" name="search_week" id="search_week" style="width:180px">
      <?php
      if (isset($_GET['search_week'])){
        $today = explode(' ~ ', $_GET['search_week']);
        $today = date($today[1]);
      } else {
        $today = date("Y-m-d");
      }
      foreach($week_array as $wa){ ?>
        <option value="<?php echo $wa['start']." ~ ".$wa['end']; ?>" <?php if(($today>=$wa['start'])&&($today<=$wa['end'])){echo 'selected';} ?>><?php echo $wa['start']." ~ ".$wa['end']; ?></option>
      <?php } ?>
    </select>
		<button type="submit" name="button" class="btn-common btn-style1">검색</button>

    <!-- <span>
      <input type="image" style='cursor:hand; margin-bottom:8px;' onclick="return GoSearch();" src="<?php echo $misc;?>img/dashboard/btn/btn_search.png" width="20px" height="20px" align="middle" border="0"/>
    </span> -->
		</form>
  </div>
  <div class="contents_item" valign="top" style="margin-top:10px;">

		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="contents_tbl">
											<colgroup>
												<col width="8.75%" />
												<col width="8.75%" />
												<col width="8.75%" />
												<col width="8.75%" />
												<col width="8.75%" />
												<col width="8.75%" />
												<col width="8.75%" />
												<col width="8.75%" />
											</colgroup>
											<tr>
												<th colspan="6">누적 근로시간</th>
												<th colspan="2">잔여 근로시간</th>
											</tr>
											<tr style="background-color:#F4F4F4">
												<td height="60">성명</td>
												<td>소속</td>
												<td>소정근로시간</td>
												<td>소정외근로시간</td>
												<td colspan="2">총근로시간</td>
												<!-- <th class="border_l">통계</th> -->
												<td>소정근로시간</td>
												<td>소정외근로시간</td>
											</tr>
										<?php if(empty($work_data)){ ?>
												<tr>
													<td colspan="8">조회 결과가 없습니다.</td>
												</tr>
										<?php
									}else{
										 foreach ($work_data as $wd) {
											 ?>

											<tr>

												<td align="center"><?php echo $wd['user_name'] ?></td>
												<td align="center"><?php echo $wd['pgroup'] ?></td>
												<td align="center"><?php echo $wd['work_hour'] ?></td>
												<td align="center"><?php echo $wd['over_time'] ?></td>
												<td align="center"><?php echo $wd['total_time'] ?></td>
												<td align="center">
													<div style="display:flex;width:100%;height:60%;">
														<div style="width:75%;height:100%;background-color:#d4d2d2;border-right:solid 2px;">
															<div style="max-width: 100%;width:<?php  echo $wd['work_per'] ?>%;height:100%;background-color:#007BCB"></div>
														</div>
														<div style="width:25%;height:100%;background-color:#d4d2d2;">
															<div style="max-width: 100%;width:<?php  echo $wd['over_per'] ?>%;height:100%;background-color:#E53737"></div>
														</div>
													</div>
												</td>
												<td align="center"><?php echo $wd['rest_worktime'] ?></td>
											  <td align="center"><?php echo $wd['rest_overtime'] ?></td>


											</tr>
									<?php }
								}
									?>
		</table>

  </div>


</div>


<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->
</body>
<script type="text/javascript">
$("#search_month").datepicker({
  dateFormat: 'yy-mm',
  changeMonth: true,
  changeYear: true,
  showButtonPanel: true,
  closeText:'선택',
  onClose: function(dateText, inst) {
    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
    $(this).datepicker('setDate', new Date(year, month, 1));
    $(".ui-datepicker-calendar").css("display","none");
    $("#search_month").val(this.value);
    var target_month = this.value;

    $.ajax({
      type: "POST",
      async: false,
      url: "/index.php/admin/attendance_admin/get_week_array",
      dataType: "json",
      data: {
        target_month : target_month
      },
      success: function(data){
        var options = "";
        for(var i=0;i<data.length;i++){
          var value = data[i].start+" ~ "+data[i].end;
          options += "<option value='"+value+"'>"+value+"</option>";
        }
        $("#search_week").html(options);
      }
    })
  }
});
$("#search_month").focus(function () {
  $(".ui-datepicker-calendar").css("display","none");
  $("#ui-datepicker-div").position({
    my: "center top",
    at: "center bottom",
    of: $(this)
  });
});
</script>
</html>
