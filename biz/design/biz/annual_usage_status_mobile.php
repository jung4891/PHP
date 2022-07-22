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
  <link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css"> <!-- 달력 표시 css (datepicker) -->
  <script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script> <!--  달력 표시 js (datepicker) -->
  <link rel="stylesheet" href="/misc/css/simple-calendar_mobile.css">
  <script type="text/javascript" src="/misc/js/jquery.simple-calendar_mobile.js"></script>
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
   		<a class="menu_list" onclick ="moveList('attendance_working_hours')" style='color:#B0B0B0'>통계</a>
   		<a class="menu_list" onclick ="moveList('annual_usage_status')" style='color:#0575E6'>휴가사용현황</a>
   		<a class="menu_list" onclick ="moveList('annual_usage_status_list')" style='color:#B0B0B0'>휴가사용내역</a>
   	</div>

	<div style="max-width:90%;margin: 0 auto;margin-top:30px;">
		<table class="basic_table">
			<colgroup>
				<col width="40%">
				<col width="60%">
			</colgroup>
			<tbody>
<?php
if (count($annual_status) > 0) {
  foreach($annual_status as $val){?>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">성명</td>
					<td><?php echo $val['user_name'] ?></td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">부서</td>
					<td><?php echo $val['user_group'] ?></td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">입사일</td>
					<td><?php echo $val['join_company_date'] ?></td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">근속년수</td>
					<td><?php if($val['annual_period']-substr($val['join_company_date'],0,4)-1 < 0){echo 0;}else{
            echo $val['annual_period']-substr($val['join_company_date'],0,4)-1;
          } ?></td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">기준연도</td>
					<td><?php echo $val['annual_period']; ?></td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">연차사용기간</td>
					<td><?php echo $val['annual_period'];?>-01-01 ~ <?php echo $val['annual_period'];?>-12-31</td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">발생연차</td>
					<td><?php echo ($val['month_annual_cnt']+$val['annual_cnt']+$val['adjust_annual_cnt']);?></td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">사용연차(승인)</td>
					<td><?php echo $val['use_annual_cnt'] ?></td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">잔여연차</td>
					<td><?php echo $val['remainder_annual_cnt'] ?></td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">사용연차(결재중)</td>
					<td><?php echo $val['approval_cnt'] ?></td>
				</tr>
	<?php } ?>
<?php } ?>
			</tbody>
		</table>
	</div>
  <div style="width:90%;margin:0 auto;margin-bottom:10px;margin-top:20px;">
    <a href="<?php echo site_url();?>/biz/approval/electronic_approval_doc_input?seq=annual">
      <input style="width:100%" type="button" class="btn-common btn-color2" value="연차신청서 작성">
    </a>
  </div>
  <div style="padding-bottom:60px;width:90%;margin:0 auto;">
    <span id="calendar_month" style="top:0;color:#3C3C3C;font-weight:bold;font-size:20px;"></span>
    <input type="text" id="month_input" value="<?php if(isset($_GET['month'])){echo $_GET['month'];}else if (isset($_GET['date'])){echo $_GET['date'];}else{echo date('Y-m-d');} ?>" onchange="change_date('main',this.value);" style="visibility:hidden;position:absolute;">
    <img id="btn_down" src="<?php echo $misc; ?>img/mobile/btn_down.svg" style="margin-left:10px;" onclick="$('#month_input').focus();">
    <input type="button" id="today" class="btn-common btn-color2" value="오늘" style="float:right;width:auto;" onclick="go_sch_page();"><br><br>
  <div id="calendar"></div>
  <div id="annual_list"></div>
</div>
	<!-- 검색 모달 끝 -->
	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>
</body>
<script type="text/javascript">
$(document).ready(function() {
  $("#calendar").simpleCalendar({
    fixedStartDay: 0, // begin weeks by sunday
    // disableEmptyDetails: true,
    events: [
      // generate new event after tomorrow for one hour
      <?php
      if(!empty($view_val)){
      foreach ($view_val as $v) {
        echo "{startDate:'".$v['annual_start_date']."',";
        echo "endDate:'".$v['annual_end_date']."'";
        echo "},";
      }
      }
       ?>
    ],
    months : ['01','02','03','04','05','06','07','08','09','10','11','12'],
    days: ['일','월','화','수','목','금','토']
  });

  $('#month_input').change();
  $('#month_input').datepicker({
    minViewMode: "months"
  });

  $('#select_user_div .btn-user').each(function () {
    var user_seq = $(this).attr('seq');

    if ($.inArray(user_seq, my_seq) != -1) {
      $(this).removeClass('btn-style3');
      $(this).addClass('btn-style2');
    }
  });
})

function change_date(mode, month) {
  month_txt = month.split('-');
  t_month = month_txt[0]+'-'+month_txt[1];
  month_url = '&month=' + t_month;
  month_txt = month_txt[0]+'.'+month_txt[1];
  $('#calendar_month').html(month_txt);

  if (getParam('month')!='' && (t_month != getParam('month'))) {
  location.href = "<?php echo site_url(); ?>/biz/attendance/annual_usage_status?" + month_url;
  }
}

$('#month_input').change();
$('#month_input').datepicker({
  minViewMode: "months"
});

function getParam(sname) {
  var params = location.search.substr(location.search.indexOf('?') + 1);
  var sval = '';
  params = params.split('&');
  for (var i = 0; i < params.length; i++) {
    temp = params[i].split('=');
    if ([temp[0]] == sname) {
      sval = temp[1];
    }
  }
  return sval;
}

function go_sch_page(mode) {
  location.href = "<?php echo site_url(); ?>/biz/attendance/annual_usage_status?";
}

function refresh_sch(date) {
  var list = '';
  $.ajax({
    type: "POST",
    dataType: 'json',
    url: '/index.php/biz/attendance/annual_usage_status_day',
    data: {
      date: date
    },
    success: function(data) {
      if(data) {
        list += '<h3>'+date+'</h3>';
        for(var i=0; i<data.length; i++) {
          if(data[i].annual_type == '001') {
            var type = '보건휴가';
          } else if(data[i].annual_type == '002') {
            var type = '출산휴가';
          } else if(data[i].annual_type == '003') {
            var type = '연/월차 휴가';
          } else if(data[i].annual_type == '004') {
            var type = '특별유급 휴가';
          } else if(data[i].annual_type == '005') {
            var type = '공가';
          }
          if(data[i].annual_type2 == '001') {
            var type2 = '전일';
          } else if(data[i].annual_type2 == '002') {
            var type2 = '오전반차';
          } else if(data[i].annual_type2 == '003') {
            var type2 = '오후반차';
          }
          list += '<span style="font-size:15px;">['+type+'] ['+type2+'] '+data[i].annual_reason+'</span>';
        }
      }
      $('#annual_list').html(list);
      $('html, body').scrollTop( $(document).height() );
    }
  })
}
</script>
