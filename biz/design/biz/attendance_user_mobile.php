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
  .calendar td {
    padding: 1em .1em !important;
  }

	</style>
	<link rel="stylesheet" href="/misc/css/view_page_common.css">
  <link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css"> <!-- 달력 표시 css (datepicker) -->
  <script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script> <!--  달력 표시 js (datepicker) -->
  <link rel="stylesheet" href="/misc/css/simple-calendar_mobile.css">
  <style media="screen">
  .selected {
    border: none !important;
  }
  </style>
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
   		<a class="menu_list" onclick ="moveList('attendance_user')" style='color:#0575E6'>출근기록</a>
   		<a class="menu_list" onclick ="moveList('attendance_working_hours')" style='color:#B0B0B0'>통계</a>
   		<a class="menu_list" onclick ="moveList('annual_usage_status')" style='color:#B0B0B0'>휴가사용현황</a>
   		<a class="menu_list" onclick ="moveList('annual_usage_status_list')" style='color:#B0B0B0'>휴가사용내역</a>
   	</div>

    <div style="padding-bottom:60px;width:90%;margin:0 auto;margin-top:30px;">
      <span id="calendar_month" style="top:0;color:#3C3C3C;font-weight:bold;font-size:20px;"></span>
      <input type="text" id="month_input" value="<?php if(isset($_GET['month'])){echo $_GET['month'];}else if (isset($_GET['date'])){echo $_GET['date'];}else{echo date('Y-m-d');} ?>" onchange="change_date('main',this.value);" style="visibility:hidden;position:absolute;">
      <img id="btn_down" src="<?php echo $misc; ?>img/mobile/btn_down.svg" style="margin-left:10px;" onclick="$('#month_input').focus();">
      <input type="button" id="today" class="btn-common btn-color2" value="오늘" style="float:right;width:auto;" onclick="go_sch_page();"><br><br>
      <div id="calendar"></div>
      <div id="annual_list"></div>
    </div>

	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>
  <script type="text/javascript">

  $(document).ready(function() {
    $("#calendar").simpleCalendar({
      fixedStartDay: 0, // begin weeks by sunday
      // disableEmptyDetails: true,
      events: [],
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
    var val_list = <?php echo json_encode($list_val); ?>;
    console.log(val_list);
    $('.day').each(function() {
      var c_date = $(this).attr('data-date').substring(0,10);
      for (var i = 0; i < val_list.length; i++) {
        if(c_date == val_list[i].e_date) {

          var wstime = val_list[i].go_time;
          if(wstime != '' && wstime != null) {
            wstime = wstime.substring(0, 4);
            wstime = wstime.replace(/(.{2})/, '$1:');
          } else {
            wstime = '00:00';
          }
          var wctime = val_list[i].leave_time;
          if(wctime != '' && wctime != null) {
            wctime = wctime.substring(0, 4);
            wctime = wctime.replace(/(.{2})/, '$1:');
          } else {
            wctime = '00:00';
          }

          var ws_font_color = ' style="color:black;"';
          var wc_font_color = ' style="color:black;"';
          if (wstime >= val_list[i].ws_time) {
            ws_font_color = ' style="color:red;"';
          }
          if (wctime < val_list[i].wc_time) {
            wc_font_color = ' style="color:red;"';
          }

          var txt = '<div style="line-height:1"><span '+ws_font_color+'>'+wstime+'</span><br><span '+wc_font_color+'>'+wctime+'</span></div>';

          $(this).append(txt);

        }
      }
    })
  })

  function change_date(mode, month) {
    month_txt = month.split('-');
    t_month = month_txt[0]+'-'+month_txt[1];
    month_url = '&month=' + t_month;
    month_txt = month_txt[0]+'.'+month_txt[1];
    $('#calendar_month').html(month_txt);

    if (getParam('month')=='' || (t_month != getParam('month'))) {
      location.href = "<?php echo site_url(); ?>/biz/attendance/attendance_user?" + month_url;
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
    location.href = "<?php echo site_url(); ?>/biz/attendance/attendance_user?";
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
</body>
