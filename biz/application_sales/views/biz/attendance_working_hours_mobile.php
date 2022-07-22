<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<body>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	  ?>
	<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
	<style>
	.menu_div {
		margin-top:10px;
		padding: 10px;
		border-bottom: thin #EFEFEF solid;
		overflow-x: scroll;
		white-space:nowrap;
	}
	.menu_div::-webkit-scrollbar {
		display: none;
	}
	.menu_list {
		cursor:pointer;margin:10px;font-weight:bold;font-size:15px;
	}
	.basic_table{
		width:100%;
		 border-collapse:collapse;
		 border:1px solid;
		 border-color:#DEDEDE;
		 table-layout: auto !important;
		 border-left:none;
		 border-right:none;
	}

	.basic_table td{
		height:35px;
		 padding:0px 10px 0px 10px;
		 border:1px solid;
		 border-color:#DEDEDE;
	}
	.border_n {
		border:none;
	}
	.border_n td {
		border:none;
	}
	.basic_table tr > td:first-child {
		border-left:none;
	}
	.basic_table tr > td:last-child {
		border-right:none;
	}
	.contents_div {
		overflow-x: scroll;
		white-space: nowrap;
	}
	.input-common, .select-common, .btn-common {
		height: 35px !important;
		border-radius: 3px !important;
		box-sizing: border-box;
	}
	.dayBtn {
		background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
	.ui-datepicker .ui-datepicker-title select {
		font-size: 16px !important;
	}
	</style>
	<link rel="stylesheet" href="/misc/css/view_page_common.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.9.2/i18n/jquery.ui.datepicker-ko.min.js"></script>
  <script language="javascript">
  function moveList(page){
     location.href="<?php echo site_url();?>/biz/attendance/"+page;
  }
  </script>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  ?>
     <div class="menu_div">
   		<a class="menu_list" onclick ="moveList('attendance_user')" style='color:#B0B0B0'>출근기록</a>
   		<a class="menu_list" onclick ="moveList('attendance_working_hours')" style='color:#0575E6'>통계</a>
   		<a class="menu_list" onclick ="moveList('annual_usage_status')" style='color:#B0B0B0'>휴가사용현황</a>
   		<a class="menu_list" onclick ="moveList('annual_usage_status_list')" style='color:#B0B0B0'>휴가사용내역</a>
   	</div>

	<div style="max-width:90%;margin: 0 auto;margin-top:30px;">
		<table class="basic_table">
			<colgroup>
				<col width="30%">
				<col width="70%">
			</colgroup>
			<tbody>
<?php if(empty($work_data)){ ?>
				<tr>
					<td colspan="2">조회 결과가 없습니다.</td>
				</tr>
<?php	}else{
		 		foreach ($work_data as $wd) { ?>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">성명</td>
					<td><?php echo $wd['user_name'] ?></td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">소속</td>
					<td><?php echo $wd['pgroup'] ?></td>
				</tr>
				<tr>
					<td colspan="2" style="font-weight:bold;height:40px;font-size:16px;padding-left:0px;">누적근로시간</td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">소정근로시간</td>
					<td><?php echo $wd['work_hour'] ?></td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">소정외근로시간</td>
					<td><?php echo $wd['over_time'] ?></td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">총근로시간</td>
					<td><?php echo $wd['total_time'] ?></td>
				</tr>
				<tr>
					<td colspan="2" style="font-weight:bold;height:40px;font-size:16px;padding-left:0px;">잔여근로시간</td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">소정근로시간</td>
					<td><?php echo $wd['rest_worktime'] ?></td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">소정외근로시간</td>
					<td><?php echo $wd['rest_overtime'] ?></td>
				</tr>
	<?php } ?>
<?php } ?>
			</tbody>
		</table>
	</div>

	<!-- 검색 모달 시작 -->
  <div id="search_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:16px; color:#1C1C1C;font-weight:bold;">
			<form name="mform" action="" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
				<table style="width:100%;padding:5%;" cellspacing="0">
					<colgroup>
						<col width="50%">
						<col width="50%">
					</colgroup>
					<tr>
						<td colspan="2" align="left" height="40">
							<input class="input-common" type="text" name="search_month" id="search_month" value="<?php
					    if (isset($_GET['search_month'])){
					      echo $_GET['search_month'];
					    } else {
					      echo date("Y-m");
					    }
					    ?>" style="width:100%;" readonly>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<select class="select-common" name="search_week" id="search_week" style="width:100%">
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
						</td>
					</tr>
					<tr>
						<td height="20"></td>
					</tr>
					<tr>
						<td>
							<input type="button" class="btn-common btn-color1" style="width:95%" value="취소" onclick="$('#search_div').bPopup().close();">
						</td>
						<td align="right">
							<input type="submit" class="btn-common btn-color2" style="width:95%" value="검색">
						</td>
					</tr>
				</table>
			</form>
    </div>
  </div>
	<!-- 검색 모달 끝 -->

	<div style="width:90%;margin:0 auto;margin-bottom:10px;">
    <?php if($tech_lv == 3) { ?>
			<!-- <a href="<?php echo site_url();?>/tech/board/manual_input"> -->
				<!-- <input style="width:100%" type="button" class="btn-common btn-color2" value="글쓰기"> -->
			<!-- </a> -->
    <?php } ?>
	</div>
	<div style="width:90%;padding-left:10px;padding-bottom:60px;">
		<span style="color:red;margin-right:5px;">*</span><?php echo $title; ?> 검색 시 우측 하단에 검색 아이콘을 눌러주세요.
	</div>
	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>
  <script language="javascript">
  function open_search() {
  	$('#search_div').bPopup();
  }
  $(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        document.location.reload();
    }
  });
  </script>
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
</body>
