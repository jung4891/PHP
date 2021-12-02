<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>

.contents_tbl th{
		/* border-color:#c0c0c0; */
		text-align:center;
		/* border-style:solid; */
		/* border-width:1px; */
		font-size: 16px;
		font-weight:bold;
		height:40px;
		/* background-color: #efefef; */

}

.contents_tbl td{
		/* border-color:#c0c0c0; */
		text-align:center;
		/* border-style:solid; */
		/* border-width:1px; */
		font-size: 14px;
		height:40px;
}

li{
	padding-top: 10px;
	font-size: 14px;
}
</style>

<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.9.2/i18n/jquery.ui.datepicker-ko.min.js"></script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>

<div class="contents_container" align="center">
	<!-- 타이틀 -->
	<div class="contents_item dash_title" style="display:flex;">
		<p align="left">
			통계
		</p>
	</div>
	<div class="contents_item" align="left">
		<form name="mform" action="" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
			 <span style="color:red;font-size:15px;margin-left:20px">*</span>검색일
			 <input type="text" class="input-common" name="search_month" id="search_month" value="<?php
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
				 <span>
					 <!-- <input type="image" style='cursor:hand; margin-bottom:8px;' onclick="return GoSearch();" src="<?php echo $misc;?>img/dashboard/btn/btn_search.png" width="20px" height="20px" align="middle" border="0"/>
				 </span> -->
				 <button type="submit" class="btn-common btn-style1" name="button" onclick="return GoSearch();">검색</button>
			 </form>
	</div>
	<div class="contents_item" style="margin-top:10px;">
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
					<th colspan="6">누적근무시간</th>
					<th colspan="2">잔여근무시간</th>
				</tr>
				<tr style="background-color:#F4F4F4">
					<td>성명</td>
					<td>소속</td>
					<td>소정근로시간</td>
					<td>소정외근로시간</td>
					<td>차감근로시간</td>
					<td>총근로시간</td>
					<td>소정근로시간</td>
					<td>소정외근로시간</td>
				</tr>
				<tr>
					<td><?php echo $attendance_info['user_name']; ?></td>
					<td><?php echo $user_group; ?></td>
					<td><?php echo $work_on_time; ?></td>
					<td><?php echo $overtime; ?></td>
					<td><?php echo $deducted; ?></td>
					<td><?php echo $total_work_time; ?></td>
					<td><?php echo $residue_work_on_time; ?></td>
					<td><?php echo $residue_overtime; ?></td>
				</tr>
		</table>
  </div>
	<div class="contents_item" align="left" style="padding-top:15vh;">
		<button type="button" name="button" class="btn-common btn-color3" style="cursor:default">참 조</button>
		 <li>· 52시간(주당 최대 근로시간) 기준, 해당 주 월요일부터 일요일까지의 근로시간이 표시됩니다(검색일이 이번주일 경우 이번주 월요일부터 오늘까지의 근로시간이 표시됩니다.)</li>
		 <li>· 소정근로시간: ‘(1일 출퇴근설정시간-휴게시간) x 출근일수’를 나타냅니다(1일 평균 8시간, 1주 기준 최대 40시간)</li>
		 <li>· 소정외근로시간: ‘소정근로시간 외의 근로시간’을 나타냅니다(1주 기준 최대 12시간).</li>
		 <li>· 차감근로시간: ‘소정근로시간 - 지각, 자리비움 등으로 인해 발생한 업무 공백 시간’을 나타냅니다.</li>
		 <li>· 총근로시간: ‘소정근로시간 + 소정외근로시간 – 차감근로시간’을 나타냅니다.</li>
		 <li>· 잔여근로시간: 근로기준법 기준 최대 소정근로시간(40시간)/소정외근로시간(12시간)에서 남은 근로시간이 표시됩니다.</li>
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
      url: "/index.php/biz/attendance/get_week_array",
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
