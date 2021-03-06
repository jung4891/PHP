<script type="text/javascript">
var today = getTimeStamp();
var sessionName = $('#session_name').val();

function getTimeStamp() {
  var d = new Date();
  var s =
    leadingZeros(d.getFullYear(), 4) + '-' +
    leadingZeros(d.getMonth() + 1, 2) + '-' +
    leadingZeros(d.getDate(), 2);
  return s;
}

function leadingZeros(n, digits) {
  var zero = '';
  n = n.toString();
  if (n.length < digits) {
    for (i = 0; i < digits - n.length; i++) {
      zero += '0';
    }
  }
  return zero + n;
}

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


  $(document).ready(function() {
    $("#calendar").simpleCalendar({
      fixedStartDay: 0, // begin weeks by sunday
      // disableEmptyDetails: true,
      events: [
        // generate new event after tomorrow for one hour
        <?php
        foreach ($schedule as $v) {
          echo "{startDate:'".$v['start_day']."T".$v['start_time']."',";
          echo "endDate:'".$v['end_day']."T".$v['end_time']."'";
          echo "},";
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

    if (getParam('selUser') == '') {
      var my_seq = ['<?php echo $sel_user; ?>'];
    } else {
      var my_seq = getParam('selUser');
      my_seq = my_seq.split(',');
    }

    $('#select_user_div .btn-user').each(function () {
      var user_seq = $(this).attr('seq');

      if ($.inArray(user_seq, my_seq) != -1) {
        $(this).removeClass('btn-style3');
        $(this).addClass('btn-style2');
      }
    });

    if(getParam('month')!='') {
      $('#month_input').change();
      $('#month').removeClass('btn-color1');
      $('#month').addClass('btn-color2');
      $('#month').attr('onclick', '');
      $('.day').css('cursor', 'default');
      $('.day').attr('onclick','').unbind('click');
    } else {
      $('#day').removeClass('btn-color1');
      $('#day').addClass('btn-color2');
      $('#day').attr('onclick', '');
    }
    if(getParam('date')!='') {
      var t_day = getParam('date').split('-');
      t_day = t_day[2];
      $('.day').each(function() {
        var dd = $(this).text();
        // 8월 1일은 데이터가 올바르지 않아서 강제로 적용 시킴
        if (dd < 10) {
          dd = '0'+dd;
        }
        if (t_day == dd) {
          $(this).addClass('selected');
          return false;
        }
      })
    }

  })

  function select_user(el) {
    // 선택 되어있지 않을때
    if($(el).hasClass('btn-style3')) {

      $(el).removeClass('btn-style3');
      $(el).addClass('btn-style2');

    // 선택 되어있을때
    } else if($(el).hasClass('btn-style2')) {

      $(el).removeClass('btn-style2');
      $(el).addClass('btn-style3');

    }
  }

  function selUser_submit() {
    var selUser = '';
    $('#select_user_div .btn-style2').each(function () {
      selUser += $(this).attr('seq')+',';
    })
    selUser = selUser.replace(/,$/,'');

    if (getParam('month') != '') {
      var get = '&month='+getParam('month');
    } else {
      var get = '';
    }

    location.href = '<?php echo site_url(); ?>/biz/schedule/tech_schedule_mobile?selUser=' + selUser+get;
  }

  function addUser_Btn(mode) {
    // 초기화
    $("#select_user_add_div .btn-user").each(function() {
      if($(this).hasClass('btn-style2')) {
        $(this).removeClass('btn-style2');
        $(this).addClass('btn-style3');
      }
    })

    if (mode == 'add') {
      var participant = $('#participant').val();
    } else if (mode == 'update') {
      var participant = $('#de_participant').val();
    }
    participant = participant.replace(/[^0-9,]/g, '');
    participant = participant.split(',');

    $('#select_user_add_div .btn-user').each(function() {
      var seq = $(this).attr('seq');

      if($.inArray(seq, participant) != -1) {
        $(this).removeClass('btn-style3');
        $(this).addClass('btn-style2');
      }
    })

    if (mode == 'add') {
      $('#select_user_add_div').bPopup({
  			follow: [false,false]
      })
      $('#participant_mode').val('add');
    }
    if (mode == 'update') {
      $('#select_user_add_div').bPopup({
  			follow: [false,false]
      })
      $('#participant_mode').val('update');
    }
  }

  function add_participant() {
    var participant_val = '';
    var participant_text = '';
    var mode = $('#participant_mode').val();

    $('#select_user_add_div .btn-user').each(function() {
      if($(this).hasClass('btn-style2')) {
        participant_val += $(this).attr('name') + '_' + $(this).attr('seq') + ',';
        participant_text += $(this).attr('name') + ', ';
      }
    })
    participant_val = participant_val.replace(/,\s*$/, "");
    participant_text = participant_text.replace(/,\s*$/, "");
    if (mode == 'add') {
      $('#participant').val(participant_val);
      $('#participant_input').val(participant_text);
    }
    if (mode == 'update') {
      $('#de_participant').val(participant_val);
      $('#de_participant_input').val(participant_text);
    }
    $('#select_user_add_div').bPopup().close();
  }

  // get 값 가져오는 함수
  function getParam(sname) {
    var params = location.search.substr(location.search.indexOf("?") + 1);
    var sval = "";
    params = params.split("&");
    for (var i = 0; i < params.length; i++) {
      temp = params[i].split("=");
      if ([temp[0]] == sname) {
        sval = temp[1];
      }
    }
    return sval;
  }

  function refresh_sch(date) {
    $.ajax({
      type: "POST",
      dataType: 'json',
      url: '/index.php/biz/schedule/schedule_list_mobile',
      data: {
        date: date,
        selUser: getParam('selUser')
      },
      success: function (data) {
        date = date.split('-');
        date = date[1]+'.'+date[2];

        var text = '';

        text += '<tr><td class="sch_date" colspan="2">'+date+'</td></tr>';

        for(i=0; i<data.length; i++) {
          var text2 = '';
          // TODO: 기지보 date 와 비교해서 이전일경우 빨간색으로 출력
          // tech_schedule_mobile 에서도 수정해야함
          // if(data[i].tech_report > 0 || data[i].endDate) {
          //   text2 = "style='color:red'";
          // }

          var participant = data[i].participant.split(',');

          if (participant.length > 1) {
            participant = participant[0] + ' 외 ' + (participant.length - 1) + '명';
          } else {
            participant = participant[0];
          }

          if(data[i].work_type == 'tech') {
            var title = data[i].customer + '/' + data[i].work_name + '/' + data[i].support_method;
          } else {
            var title = data[i].work_name + '/' + data[i].title;
          }

          text += '<tr onclick="sch_modify(this, '+"'"+'modify'+"'"+')" seq="'+data[i].seq+'" '+text2+'><td style="vertical-align:top;padding-top:10px;"><img src="<?php echo $misc; ?>img/mobile/schedule_mobile_icon/'+data[i].work_name+'.svg"></td>';
          text += '<td class="sch_list"><div>[' + participant + '] ' + title + '</div>';
          text += '<div class="sch_time">' + data[i].start_time + ' ~ ' + data[i].end_time + '</div></td></tr>';


        }

        $('#schedule_tbl').html(text);
      }
    })
  }

  function change_date(mode, month) {
    if(mode == 'main') {
      month_txt = month.split('-');
      t_month = month_txt[0]+'-'+month_txt[1];
      month_url = '&month=' + t_month;
      month_txt = month_txt[0]+'.'+month_txt[1];
      $('#calendar_month').html(month_txt);

      if (getParam('month')!='' && (t_month != getParam('month'))) {
        if (getParam('selUser') != '') {
          var selUser = 'selUser=' + getParam('selUser');
        } else {
          var selUser = '';
        }

        // 월 버튼 눌렀을 시점 첫 화면에서 리스트만 필요하기 때문에 해당 월만 GET 으로 넘김
        // 월 변경 시에는 refresh_sch 함수로 동작
        location.href = "<?php echo site_url(); ?>/biz/schedule/tech_schedule_mobile?" + selUser + month_url;
      }
    } else if (mode == 'room') {
      month = month.replace(/\-/g,'.');
      $('#room_date').html(month);
    } else if (mode == 'car') {
      month = month.replace(/\-/g,'.');
      $('#car_date').html(month);
    }
  }

  function selUserOpen() {
    $("#select_user_div").bPopup({
			follow: [false,false],
			position: [0, 0]
    })
  }

  function addopen(){
		$('#add_sch_div tr').each(function() {
			if (!$(this).hasClass('basic_tr')) {
				$(this).hide();
			}
      if ($(this).hasClass('recurring_div')) {
        $(this).hide();
      }
		})

    recurring_form('', new Date());

    $('.recurring_div').hide();

    $('#customer_manager').val('');
    $('#forcasting_seq').val('');
    $('#maintain_seq').val('');

    $('#workname').val('');
    $('#supportMethod').val('');
    $('#room_name').val('');
    $('#car_name').val('');
    // $('#startDay').val('');
    $('#startTime').val('');
    // $('#endDay').val('');
    $('#endTime').val('');
    $('input:checkbox[name=recurring_check]').prop('checked',false);
    $('#title').val('');
    $('#customerName').val('');
    $('#customer').val('');
    $('#searchInput').val('');
    $('#customerName2').val('');
    $('#visitCompany').val('');
    $('#project').val('');

    $('#participant_input').val('<?php echo $this->name; ?>');
    $('#participant').val('<?php echo $this->name."_".$this->seq; ?>');

    $('input:checkbox[name=add_weekly_report]').prop('checked',false);
    $('#contents').val('');
    $('#dev_type').val('');
    $('#dev_page').val('');
    $('#dev_requester').val('');
    $('#dev_develop').val('');
    $('input:checkbox[name=dev_complete]').prop('checked',false);

    if($("#myDropdown").is(':visible')){ //드롭박스가 열려있을 경우(true)
     $("#myDropdown").toggle();
   }
   $('#nondisclosure_sch').prop('checked',false);

    $("#add_sch_div").bPopup({
			follow: [false,false],
			position: [0, 0]
    })
  }

  //반복일정 recurring
  function change_recurring_select_ex(mode){
    var id = $('#'+mode+'recurring_select_ex').val();
    $('.input_ex').hide();
    $('#'+id).show();
  }

	//반복일정 recurring
	function change_recurring_check(mode){
	  if($('#'+mode+'recurring_check').is(':checked') == true){
	    $('.recurring_div').show();
	  }else{
	    $('.recurring_div').hide();
	  }
	}

	function date_compare(type) {
	  var startDate = $('#' + type + 'startDay').val();
	  var endDate = $('#' + type + 'endDay').val();

	  if (startDate == '' && endDate != '') {
	    alert("시작일자를 먼저 작성해 주세요.");
	    $('#' + type + 'endDay').val('');
	    return false;
	  }

	  var startArray = startDate.split('-');
	  var endArray = endDate.split('-');
	  var start_date = new Date(startArray[0], startArray[1], startArray[2]);
	  var end_date = new Date(endArray[0], endArray[1], endArray[2]);
	  if (start_date.getTime() > end_date.getTime()) {
	    alert("종료일자가 시작일자보다 이전입니다.");
	    $('#' + type + 'endDay').val('');
	    return false;
	  }
	}

	// 회의실 등록하고 날짜바꾸면 등록없애
	function conference_room_del(mode) {
	  if (mode == 'insert') {
	    var start_day = $('#startDay').val();
	    var end_day = $('#endDay').val();
	    var room_name = $('#room_name').val();

	    if (room_name != '' && start_day != end_day) {
	      $('#room_name').val('');
	    }
	  } else {
	    var start_day = $('#de_startDay').val();
	    var end_day = $('#de_endDay').val();
	    var room_name = $('#de_room_name').val();

	    if (room_name != '' && start_day != end_day) {
	      $('#de_room_name').val('');
	    }
	  }
	}

  //반복일정 recurring
  function recurring_form(mode,start){
    dayOfTheWeek_in_week(start);
    dayOfTheWeek_num_in_month(start);
    everyday(start);
    day_in_month(start);
    // week_num_in_month(startStr);
    var recurring_year = moment(start).format('YYYY');
    var recurring_month = moment(start).format('MM');
    var recurring_day = moment(start).format('DD');

    change_recurring_check(mode);
  }

  function dayOfTheWeek_in_week(target_date) {

      var week = new Array('일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일');

      var today = new Date(target_date).getDay();
      var todayLabel = week[today];

      $('#recurring_week, #de_recurring_week').text('매주 '+todayLabel);

      var start = target_date;
      var start_date = new Date(start);
      var finish_date = new Date('2021-12-31');
      var recurring_dayOfweek_arr = [];
      var week = new Array('일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일');
      var today = new Date(start).getDay();
      var start_today = new Date(start).getDay();
      var todayLabel = week[today];
      while(start_date < finish_date){ //해당 일부터 YYYY-12-30 까지 출력
          if(week[start_today] == todayLabel){
              var strDate = moment(start_date).format('YYYY-MM-DD');
              recurring_dayOfweek_arr.push(strDate);
              start_date.setDate(start_date.getDate() + 7);
  	          start_today = start_date.getDay();
          }
      }
      $('#recurring_week, #de_recurring_week').val(recurring_dayOfweek_arr);
  }

  //반복일정 recurring
  function dayOfTheWeek_num_in_month(target_date){
    var week = new Array('일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일');
    var week2 = new Array('.fc-day-sun', '.fc-day-mon', '.fc-day-tue', '.fc-day-wed', '.fc-day-thu', '.fc-day-fri', '.fc-day-sat');

    var today = new Date(target_date).getDay();
    var todayLabel = week[today];
    var todayLabel2 = week2[today];

    var present_days = $('tbody').find(todayLabel2).not('.fc-day-other').not('.fc-col-header-cell');
    var present_days_length = present_days.length;
    for(i = 0; i < present_days_length; i++){
      var present_date = present_days.eq(i).attr('data-date');
      if(present_date == target_date){
        var present_day_date = moment(present_date).format('DD');
        var present_count_date =  Math.ceil(present_day_date/7);
        break;
      }else{
        continue;
      }
    }

    var future_days = $('tbody').find(todayLabel2 + '.fc-day-other.fc-day-future').not('.fc-col-header-cell');
    var future_days_length = future_days.length;
    for(k = 0; k < future_days_length; k++){
      var future_date = future_days.eq(k).attr('data-date');
      if(present_date == target_date){
        var future_day_date = moment(future_date).format('DD');
        var future_count_date =  Math.ceil(future_day_date/7);
        break;
      }else{
        continue;
      }
    }

    var past_days = $('tbody').find(todayLabel2 + '.fc-day-other.fc-day-past').not('.fc-col-header-cell');
    var past_date = past_days.eq(0).attr('data-date');
    var past_day_date = moment(past_date).format('DD');
    var past_count_date =  Math.ceil(past_day_date/7);

    // var test = getWeek(4,target_date);
    // var test = weekNumberByMonth(target_date);
    // console.log(test);

    if(present_count_date != undefined){
      var present_count_date_text = '매월 ' + present_count_date + '번째 '+ todayLabel;
      $('#recurring_month, #de_recurring_month').text(present_count_date_text);
    }else{
      if(future_count_date != undefined){
        var future_count_date_text = '매월 ' + future_count_date + '번째 '+ todayLabel;
        $('#recurring_month, #de_recurring_month').text(future_count_date_text);
      }else{
        var past_count_date_text = '매월 ' + past_count_date + '번째 '+ todayLabel;
        $('#recurring_month, #de_recurring_month').text(past_count_date_text);
      }
    }

    var recurring_year = moment(target_date).format('YYYY'); // new Date().getFullYear();
    var recurring_month = moment(target_date).format('MM');  // new Date().getMonth() + 1;

    var recurring_dayOfweek_num_arr = [];
    var fake_recurring_dayOfweek_num_arr = [];
    for(var i = Number(recurring_month); i < 13; i++){ //남은 월 돌리기
      var str_month = numFormat(i);
      //해당 월 마지막 일 구하기 30 or 31
      var last = new Date( recurring_year, str_month );
      last = new Date( last - 1 );
      var last_day = last.getDate();

      for(j = 1; j <= Number(last_day); j++){ //해당 월의 모든 일의 요일을 구해서 해당일과 같은 요일인 날짜만 배열에 담는다.
        var fake_date =  recurring_year + '-' + str_month + '-' + j;
        var fake_today = new Date(fake_date).getDay();
        var fake_todayLabel = week[fake_today];
        if(fake_todayLabel == todayLabel){
          var fake_recurring_day = numFormat(j);
          var fake_date_push = recurring_year + '-' + str_month + '-' + fake_recurring_day;
          fake_recurring_dayOfweek_num_arr.push(fake_date_push);
        }
      }
      //해당월에 같은 요일인 일들만 담은 배열에서 클릭 날짜의 n번째 순서와 같은 날짜를 골라내 따로 배열에 다시 담는다.
      if(present_count_date != undefined){
        var date_push = fake_recurring_dayOfweek_num_arr[present_count_date-1];
      }else{
        if(future_count_date != undefined){
          var date_push = fake_recurring_dayOfweek_num_arr[future_count_date-1];
        }else{
          var date_push = fake_recurring_dayOfweek_num_arr[past_count_date-1];
        }
      }
      if(date_push != null && date_push != ''){
        recurring_dayOfweek_num_arr.push(date_push);
      }
      fake_recurring_dayOfweek_num_arr = [];

    }
    $('#recurring_month, #de_recurring_month').val(recurring_dayOfweek_num_arr);
  }

  function everyday(target_date) {
    var recurring_year = moment(target_date).format('YYYY');
    var recurring_month = moment(target_date).format('MM');
    var recurring_day = moment(target_date).format('DD');

    $('#recurring_day, #de_recurring_day').text('매일');
    var start_date = new Date(target_date);
    var finish_date = new Date(recurring_year+'-12-31');
    var recurring_day_arr = [];
    while(start_date < finish_date){ //해당 일부터 YYYY-12-30 까지 출력
        var strDate = moment(start_date).format('YYYY-MM-DD');
        recurring_day_arr.push(strDate);
        start_date.setDate(start_date.getDate() + 1);
    }
    if(start_date == finish_date){
      last_date = moment(start_date).format('YYYY-MM-DD'); //YYYY-12-31 출력
      recurring_day_arr.push(last_date);
    }
    $('#recurring_day, #de_recurring_day').val(recurring_day_arr);
  }


  function day_in_month(target_date) {
    var recurring_year = moment(target_date).format('YYYY');
    var recurring_month = moment(target_date).format('MM');
    var recurring_day = moment(target_date).format('DD');

    //매월 n일
    $('#recurring_month_day, #de_recurring_month_day').text('매월 '+recurring_day+'일');
    var recurring_month_day_arr = [];
    for(var i = Number(recurring_month); i < 13; i++){
      var str_month = numFormat(i);
      var val = recurring_year + '-' + str_month + '-' + recurring_day;
      recurring_month_day_arr.push(val);
    }
    $('#recurring_month_day, #de_recurring_month_day').val(recurring_month_day_arr);
  }

  //숫자를 두자리 정수로 만들기
  function numFormat(variable) {
    variable = Number(variable).toString();
    if(Number(variable) < 10 && variable.length == 1)
    variable = "0" + variable;
    return variable;
  }

	function change_workname(val, mode) {
		$('.normal_tr').hide();
		$('.basic_tr2').show();

		var tech_work = ['납품설치', '설치지원', '장애지원', '기술지원', '정기점검', '데모(BMT)지원', '교육지원', '미팅', '정기점검2', '교육참석'];

		if (val == '기술연구소') {
			$('.lab_tr').show();
      $('#'+mode+'work_type').val('lab');
		} else if($.inArray(val, tech_work) != -1){
			$('.tech_tr, .customer_tr, .tech_div').show();
      $('.except_company_div').hide();
      $('#'+mode+'work_type').val('tech');
      contents_split_type('1');
		} else if (val == '공지사항') {
			$('.notice_tr').show();
      $('#'+mode+'work_type').val('company');
      contents_split_type('1');
		} else {
      $('#'+mode+'work_type').val('general');
      $('.except_company_div').show();
      $('.tech_div').hide();
      contents_split_type('2');
			if (val == '영업활동') {
				$('.sales_tr').show();
			}
			$('.general_tr').show();
		}
	}

  //내용분할1
  contents_split_type = function (mode) {
    //구조가 변경된 DOM에서 onclick등으로 실행되는 함수는 작동이 되지 않는다. 그래서 위처럼 함수를 써줘야한다.
    // function contents_split_type(mode){

    if (mode == '1') {
      //tech와 company는 기존 내용 형식 쓰기
      $('.explanation_div, .de_explanation_div').hide();
      $('textarea[name=contents], textarea[name=de_contents]').prop({
        'rows': '5',
        'cols': '52'
      });
      $('textarea[name=contents], textarea[name=de_contents]').css('width', '95%');
      $('textarea[name=contents], textarea[name=de_contents]').closest('tr').not('#contents_tr_0, #de_contents_tr_0').find('img, textarea, input:checkbox').prop('disabled', true);
      $('textarea[name=contents], textarea[name=de_contents]').closest('tr').not('#contents_tr_0, #de_contents_tr_0').css('display', 'none');
      $('img[name=contents_add], img[name=de_contents_add], img[name=contents_remove], img[name=de_contents_remove], input:checkbox[name=add_weekly_report], input:checkbox[name=de_add_weekly_report]').hide();
      // $('input:checkbox[name=add_weekly_report], input:checkbox[name=de_add_weekly_report]').css('display','none');
    } else if (mode = '2') {
      //general은 내용분할 형식 쓰기
      $('textarea[name=contents], textarea[name=de_contents]').prop({
        'rows': '2',
        'cols': '41'
      });
      $('textarea[name=contents], textarea[name=de_contents]').css('width', '75%');
      $('.explanation_div, .de_explanation_div').show();
      $('textarea[name=contents], textarea[name=de_contents]').closest('tr').not('#contents_tr_0, #de_contents_tr_0').find('img, textarea, input:checkbox').prop('disabled', false);
      $('textarea[name=contents], textarea[name=de_contents]').closest('tr').not('#contents_tr_0, #de_contents_tr_0').css('display', '');
      $('img[name=contents_add], img[name=de_contents_add], img[name=contents_remove], img[name=de_contents_remove], input:checkbox[name=add_weekly_report], input:checkbox[name=de_add_weekly_report]').show();
      // $('input:checkbox[name=add_weekly_report], input:checkbox[name=de_add_weekly_report]').css('display','');
    }

  }

  // // KI1 20210125 고객사 포캐스팅형/유지보수형으로 변경에 적용되는 함수들
  function searchFunction(id) {
    var myDropdown = $("#" + id).parent().find('div').attr('id');
    if(myDropdown == 'de_myDropdown'){
      var workname = 'de_workname';
      var dropdown_option = 'de_dropdown_option';
    }else{
      var workname = 'workname';
      var dropdown_option = 'dropdown_option';
    }

    if( $("#"+workname).val() == "납품설치" || $("#"+workname).val() == "미팅" || $("#"+workname).val() == "데모(BMT)지원" ){
      $("#"+dropdown_option).html(
        <?php
        echo "'";
        //KI1 20210208
        echo '<a onClick="show_input_customerName(this)" value="">직접입력</a>';
        //KI2 20210208
        foreach ($customer2 as $val) {
            echo '<a ';
            echo 'onclick ="clickCustomerName(this,0,'.$val['forcasting_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.addslashes($val['project_name']).'</a>';
        }
        echo "'";
        ?>
      );
    }else if(workname ==''){
      $("#"+myDropdown).toggle();
      alert('작업구분을 먼저 선택해주세요.');
      $("#"+workname).focus();
    }else{
      $("#"+dropdown_option).html(
      <?php
         echo "'";
         //KI1 20210208
         echo '<a onClick="show_input_customerName(this)" value="">직접입력</a>';
         //KI2 20210208
        foreach ($customer as $val) {

          if($val['maintain_seq'] == null){
            echo '<a ';
            echo 'onclick ="clickCustomerName(this, 0 ,'.$val['forcasting_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.addslashes($val['project_name']).'</a>';
          }else{
            echo '<a ';
            echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['maintain_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.addslashes($val['project_name']).'</a>';
          }
        }
        echo "'";
        ?>
      );
    }
    $("#"+myDropdown).toggle();
    $(".searchInput").focus();
  }

  //고객사 선택
  function clickCustomerName(customerName, maintainEnd, seq , forcasting_seq) {
    var parent_id = $(customerName).closest("div").attr("id");

    if(parent_id == 'de_dropdown_option'){
      var customerName_id = 'de_customerName';
      var project_id = 'de_project';
      var customer_id = 'de_customer';
      var forcasting_seq_id = 'de_forcasting_seq';
      var maintain_seq_id = 'de_maintain_seq';
      var workname_id = 'de_workname';
      var myDropdown = 'de_myDropdown';
    }else{
      var customerName_id = 'customerName';
      var project_id = 'project';
      var customer_id = 'customer';
      var forcasting_seq_id = 'forcasting_seq';
      var maintain_seq_id = 'maintain_seq';
      var workname_id = 'workname';
      var myDropdown = 'myDropdown';
    }
    //KI1 20210208
    $('#'+customerName_id).attr('readonly',true);
    $('#'+project_id).attr('readonly',true);
    //KI2 20210208

    var customerCompanyName = ($(customerName).text()).split(' - ')[0];
    var projectName = ($(customerName).text()).split(' - ')[1];
    $('#'+customerName_id).val(customerCompanyName);
    $('#'+project_id).val(projectName);
    $("#"+customer_id).val(seq);
    $("#"+forcasting_seq_id).val('');
    $("#"+forcasting_seq_id).val(forcasting_seq);
    $("#"+maintain_seq_id).val('');
    $("#"+maintain_seq_id).val(seq);

    if($("#"+workname_id).val() != "납품설치" && $("#"+workname_id).val() != "미팅" && $("#"+workname_id).val() != "데모(BMT)지원" ){

      if(maintainEnd != '0'){
        test3($("#"+customer_id).val(),'maintain');
        if (<?php echo strtotime(date("Y-m-d")) ?> > maintainEnd) {
          $("#"+customer_id).val('');
          $('#'+customerName_id).val('');
          $('#'+project_id).val('');
        }
      }else{
        test3($("#"+customer_id).val(),'forcasting');
        $("#"+maintain_seq_id).val('');
      }
    }else{ //포캐스팅
      test3($("#"+customer_id).val(),'forcasting');
      $("#"+maintain_seq_id).val('');
    }
    $("#"+myDropdown).toggle();
  }

  //고객사 입력 검색
  function filterFunction(customerName) {
    var input, filter, ul, li, a, i;
    input = document.getElementById(customerName.id);
    filter = input.value.toUpperCase();
    myDropDown = $(customerName).parent().attr('id');
    div = document.getElementById(myDropDown);
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
      txtValue = a[i].textContent || a[i].innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        a[i].style.display = "";
      } else {
        a[i].style.display = "none";
      }
    }
  }

  // 고객사 담당자 가져오는 함수
  function test3(name,mode) {
    var settings = 'height=500,width=1000,left=0,top=0';
    var popup = window.open('/index.php/tech/tech_board/search_manager?name=' + name+'&mode='+mode+'&page=sch', '_blank');
    window.focus();
  }

  // 외부영역 클릭 시 팝업 닫기
  $(document).mouseup(function (e){
    var LayerPopup = $("#dropdown");
    if(LayerPopup.has(e.target).length === 0){
      $("#myDropdown").hide();
    }

    var de_LayerPopup = $("#de_dropdown");
    if(de_LayerPopup.has(e.target).length === 0){
      $("#de_myDropdown").hide();
    }
  });

  function show_input_customerName(customerName){
    var parent_id = $(customerName).closest("div").attr("id");
    if(parent_id == 'de_dropdown_option'){
      var customerName_id = 'de_customerName';
      var project_id = 'de_project';
      var customer_manager_id = 'de_customer_manager';
      // var customer_tmp_id = 'de_customer_tmp';
      var forcasting_seq_id = 'de_forcasting_seq';
      var maintain_seq_id = 'de_maintain_seq';
      var tech_report_id = 'de_tech_report';
      var myDropdown = 'de_myDropdown';
    }else{
      var customerName_id = 'customerName';
      var project_id = 'project';
      var customer_manager_id = 'customer_manager';
      // var customer_tmp_id = 'customer_tmp';
      var forcasting_seq_id = 'forcasting_seq';
      var maintain_seq_id = 'maintain_seq';
      var tech_report_id = 'tech_report';
      var myDropdown = 'myDropdown';
    }
    $('#'+customerName_id).attr('readonly',false);
    $('#'+project_id).attr('readonly',false);
    $('#'+customerName_id).css('border','2px solid');
    $('#'+customerName_id).css('border-color','black');
    $('#'+customerName_id).css('border-radius','5px');
    $('#'+customerName_id).val('');
    $('#'+customer_manager_id).val('');
    // $('#'+customer_tmp_id).val('');
    $('#'+project_id).val('');
    $('#'+forcasting_seq_id).val('');
    $('#'+maintain_seq_id).val('');
    $('#'+tech_report_id).val('Y');
    $("#"+myDropdown).toggle();
  }

  // 회의실 예약 창 띄운 후 달력이랑 타임피커 그리기
  function open_conference(mode) {
    $('#conference_div').bPopup({
      //스크롤 안따라가도록 고정
      follow: [false, false]
    });
    conference_select_day(mode);
    select_meeting_room(mode);

    // 회의실에 값이 있을 때 날짜 시간에 맞게 그려주기
    if (mode == 'insert') {
      $('#add_conference_btn').attr({
        'name': 'add_conference_btn'
      });
      var room_val = $('#room_name').val();
      var start = $('#startTime').val();
      var start_time = parseInt(start.replace(":", ""));
      var end = $('#endTime').val();
      var end_time = parseInt(end.replace(":", ""));
    } else {
      $('#add_conference_btn').attr({
        'name': 'update_conference_btn'
      });
      var room_val = $('#de_room_name').val();
      var start = $('#de_startTime').val();
      var start_time = parseInt(start.replace(":", ""));
      var end = $('#de_endTime').val();
      var end_time = parseInt(end.replace(":", ""));
    }

    if (room_val != '') {
      var room_arr = room_val.split("+");
      for (var i = 0; i < room_arr.length; i++) {
        var room_name = room_arr[i];
        $("#selectable tr[id=" + room_name + "] td").each(function () {
          var td_id = $(this).attr('id');
          if (td_id >= start_time && td_id <= end_time - 30) {
            $(this).addClass("ui-selected");
          }
        });

      }
      $("#selected_room_name").val(room_val);
      $("#select_room_result").append(start + end);
    }
  }

  // 달력 날짜 바뀔 때 마다 그 날의 회의실 일정 가져와야되는거 추가
  function conference_select_day(mode) {
    if (mode == 'insert') {
      var day = $('#startDay').val();
    } else {
      var day = $('#de_startDay').val();
    }
    // var day = $('#de_startDay').val();
    $('#select_room_day').val(day);
    var day = day.replace(/-/g, '/');
    $('#select_date').datepicker({
      clearBtn: false
    })

    // $('.datepicker').css('width','90%');
    // $('.datepicker').css('height','98%');


    $('#select_date').datepicker('setDate', day).on("changeDate", function (e) {
      var select_day = moment(e.date).format('YYYY-MM-DD');
      // console.log(select_day);
      $('#select_room_day').val(select_day);

      select_meeting_room(mode);
    });
  }


  function select_meeting_room(mode) {
    //  날짜가 바뀔 때 마다 새로운 타임피커 만들어주기 위해 초기화시킨다
    $("#select_room_result").empty();
    $('#selected_room_name').val('');
    $("#selectable tr td[class='reserved']").each(function () {
      $(this).removeClass("reserved ui-selected");
      $(this).addClass("td_item ui-selectee");
    })

    $("#selectable td[id != 'room_name_td']").each(function () {
      $(this).removeClass("ui-selected");
      $(this).addClass("td_item ui-selectee");
    });

    $('#selectable').sortable({
      filter: ".dragable",
      item: ".dragable",
      cancel: ".reserved, .td_item",
    });

    // 셀렉터블 타임피커 만들기
    $('#selectable').selectable({
      filter: ".td_item",
      cancel: ".dragable, .reserved",
      stop: function () {

        var tr = $(this).closest('tr');
        var tr_id = tr.attr('id');
        $('#selected_room_name').val(tr_id);
        //   $("#selectable tr[id!="+tr_id+"] td").each(function(){
        //   $(this).removeClass("ui-selected");
        // })

        $(".selected_room").each(function () {
          $(this).removeClass("selected_room");
        });


        // var result = $( "#select_room_result" ).empty();
        // var index = $(this).find(".ui-selected").text();
        // result.append( index );
        // $('#selected_room_name').val(tr_id);
        // var a = $('.ui-selected').closest('tr').attr('id');
        $("#select_room_result").empty();
        // $("#select_room_name").empty();
        var selected_room = [];
        var selected_time = [];
        // $('.ui-selected').closest('tbody').attr('id')
        $('.ui-selected').each(function () {
          // $("#selectable td[class ='ui-selected']").each(function(){
          var body = $(this).closest('tbody').attr('id');
          if (body == "selectable") {
            var id = $(this).closest('tr').attr('id');
            // console.log(id);
            if (selected_room.indexOf(id) == -1) {
              selected_room.push(id);
            }
            var time = $(this).text();
            if (selected_time.indexOf(time) == -1) {
              selected_time.push(time);
            }
          }
        })
        // $("#select_room_name").append(selected_room);
        $("#select_room_result").append(selected_time);

        var tr_id = selected_room.join("+");
        // console.log(tr_id);
        $('#selected_room_name').val("");
        $('#selected_room_name').val(tr_id);

        // $("#selectable td[class ='ui-selected']").each(function(){
        //   var a = $('.ui-selected').closest('tr').attr('id');
        //   console.log(a);
        //   $("#select_room_name").append(a);

        // })
      }
    })

    // 그 날의 예약된 회의실이 있는지 조회 후 reserved 클래스로 만들어주기
    var select_day = $('#select_room_day').val();
    // console.log(select_day);
    $.ajax({
      type: "GET",
      url: "/index.php/biz/schedule/search_conference_room",
      dataType: "json",
      data: {
        select_day: select_day
      },
      cache: false,
      async: false,
      success: function (data) {
        //console.log(data);
        if (data != 'false') {
          var schedule_seq = 'nan';
          if (mode == 'detail') {
            schedule_seq = $('#de_seq').val();

          }
          //////////////////////////
          for (var i = 0; i < data.length; i++) {
            // var room_name = data[i].room_name;
            var reserve_room = data[i].room_name;
            var room_arr = reserve_room.split("+");
            for (var j = 0; j < room_arr.length; j++) {
              var room_name = room_arr[j];
              // console.log(room_name);

              var seq = data[i].seq;
              var start_time = data[i].start_time.substring(0, 5);
              var end_time = data[i].end_time.substring(0, 5);
              var id_start_time = parseInt(start_time.replace(":", ""));
              var id_end_time = parseInt(end_time.replace(":", ""));
              if (schedule_seq == seq) {
                $("#selectable tr[id=" + room_name + "] td").each(function () {
                  var td_id = $(this).attr('id');
                  if (td_id >= id_start_time && td_id <= id_end_time - 30) {
                    $(this).addClass("ui-selected");
                    if (start_time != $('#de_startTime').val() || end_time != $('#de_endTime').val() || reserve_room != $('#de_room_name').val()) {
                      $(this).removeClass("ui-selected");
                    }
                  }
                })
              } else {
                var title = data[i].title;
                var participant = data[i].participant;
                // var tip = title + "<br/>" + participant + "<br/>" + "["+reserve_room+"]"+ start_time +"~"+end_time;
                $("#selectable tr[id=" + room_name + "] td").each(function () {
                  var td_id = $(this).attr('id');
                  if (td_id >= id_start_time && td_id <= id_end_time - 30) {
                    $(this).removeClass("td_item ui-selectee ui-selected");
                    $(this).addClass("reserved");
                    var userName = data[i].user_name + " (" + data[i].insert_date + ")";
                    var tooltip_text = "<h3>" + data[i].title + "</h3>";
                    tooltip_text += "<div><span class='text-point'>[구 분]<span class='text-normal'>&nbsp;" + data[i].work_name + "</span></span><br>";
                    tooltip_text += "<span class='text-point'>[참석자]<span class='text-normal'>&nbsp;" + data[i].participant + "</span></span><br>";
                    tooltip_text += "<span class='text-point'>[등록자]<span class='text-normal'>&nbsp;" + userName + "</span></span></div>";
                    $(this).find('.tooltip-content').html(tooltip_text);
                  }
                })
              }
            }
          }
          // ///////////////////////////
        }
      }
    });
  }

  function tooltip(el) {
    var tdClass = $(el).attr('class');
    if (tdClass == "reserved") {
      var tooltip = $(el).find(".tooltip-content");
      tooltip.css('visibility', 'visible');
    }
  }

  function tooltip_remove(el) {
    var tdClass = $(el).attr('class');
    if (tdClass == "reserved") {
      var tooltip = $(el).find(".tooltip-content");
      tooltip.css('visibility', 'hidden');
    }
  }

  // 등록 버튼 눌렀을 때
  function add_conference(name) {
    if (name == 'update_conference_btn') {
      var schedule_seq = $('#de_seq').val();
      $('#de_car_name').val('');
    } else {
      var schedule_seq = 'nan';
      $('#car_name').val('');
    }

    var select_day = $('#select_room_day').val();
    var list = $("#select_room_result").text();
    var start = list.substring(0, 5);
    var end = list.substring(list.length - 5);
    var room_name = $('#selected_room_name').val();
    var type = 'room_name';
    if (room_name != "" && start == end) {
      alert('이미 예약된 회의실입니다.')
      // return false;
      stopPropagation();
    }

    $.ajax({
      type: "POST",
      url: "/index.php/biz/schedule/duplicate_check",
      dataType: "json",
      data: {
        schedule_seq: schedule_seq,
        select_day: select_day,
        start: start,
        end: end,
        name: room_name,
        type: type
      },
      cache: false,
      success: function (data) {
        if (data == 'dupl') {
          alert('이미 예약된 회의실입니다.')
        } else {
          var list = $("#select_room_result").text();
          var start = list.substring(0, 5);
          //  if(mobile){
          //   var end = list.substring(list.length - 5);
          //   end = Number(end.substring(0,2))+1+":00";
          //  }else{
            var end = list.substring(list.length - 5);
          //  }
          var select_day = $('#select_room_day').val();
          if (name = 'update_conference_btn') {
            $('#de_startTime').val(start);
            $('#de_endTime').val(end);
            // var room_name =($(".ui-selected").closest('tr').attr('id'));
            $('#de_room_name').val(room_name);
            // console.log($('.active day').html());
            // console.log(select_day);
            $('#de_startDay').val(select_day);
            $('#de_endDay').val(select_day);
          }
          if (name = 'add_conference_btn') {
            $('#startTime').val(start);
            $('#endTime').val(end);
            // }
            // var room_name =($(".ui-selected").closest('tr').attr('id'));
            $('#room_name').val(room_name);
            // console.log($('.active day').html());
            // console.log(select_day);
            $('#startDay').val(select_day);
            $('#endDay').val(select_day);
          }
          $('#conference_div').bPopup().close();
        }
      }
    });
  }

  // 회의실 등록하고 날짜바꾸면 등록없애
  function conference_room_del(mode) {
    if (mode == 'insert') {
      var start_day = $('#startDay').val();
      var end_day = $('#endDay').val();
      var room_name = $('#room_name').val();

      if (room_name != '' && start_day != end_day) {
        $('#room_name').val('');
      }
    } else {
      var start_day = $('#de_startDay').val();
      var end_day = $('#de_endDay').val();
      var room_name = $('#de_room_name').val();

      if (room_name != '' && start_day != end_day) {
        $('#de_room_name').val('');
      }
    }
  }

  function open_car_reservation(mode) {
    $('#car_reservation_div').bPopup({
      //스크롤 안따라가도록 고정
      follow: [false, false]
    });
    car_select_day(mode);
    select_car(mode);
    // 차량에 값이 있을 때 날짜 시간에 맞게 그려주기
    if (mode == 'insert') {
      $('#add_car_btn').attr({
        'name': 'add_car_btn'
      });
      var car_val = $('#car_name').val();
      var start = $('#startTime').val();
      var start_time = parseInt(start.replace(":", ""));
      var end = $('#endTime').val();
      var end_time = parseInt(end.replace(":", ""));
    } else {
      $('#add_car_btn').attr({
        'name': 'update_car_btn'
      });
      var car_val = $('#de_car_name').val();
      var start = $('#de_startTime').val();
      var start_time = parseInt(start.replace(":", ""));
      var end = $('#de_endTime').val();
      var end_time = parseInt(end.replace(":", ""));
    }
    if (car_val != '') {
      $("#select_car_tbody tr[id=" + car_val + "] td").each(function () {
        var td_id = $(this).attr('id');
        if (td_id >= start_time && td_id <= end_time - 30) {
          $(this).addClass("ui-selected");
        }
      });
      $("#selected_car_name").val(car_val);
      $("#select_car_result").append(start + end);
    }
  }

  // 달력 날짜 바뀔 때 마다 그 날의 차량 일정 가져와야되는거 추가
  function car_select_day(mode) {
    if (mode == 'insert') {
      var day = $('#startDay').val();
    } else {
      var day = $('#de_startDay').val();
    }
    // var day = $('#de_startDay').val();
    $('#select_car_day').val(day);
    var day = day.replace(/-/g, '/');
    $('#select_car_date').datepicker({
      clearBtn: false
    })
    $('#select_car_date').datepicker('setDate', day).on("changeDate", function (e) {
      var select_car_day = moment(e.date).format('YYYY-MM-DD');
      $('#select_car_day').val(select_car_day);
      select_car(mode);
    });
  }

  function select_car(mode) {
    //  날짜가 바뀔 때 마다 새로운 타임피커 만들어주기 위해 초기화시킨다
    $("#select_car_result").empty();
    $('#selected_car_name').val('');
    $("#select_car_tbody tr td[class='reserved']").each(function () {
      $(this).removeClass("reserved ui-selected");
      $(this).addClass("td_item ui-selectee");
    })

    $("#select_car_tbody td[name != 'car_info']").each(function () {
      $(this).removeClass("ui-selected");
      $(this).addClass("td_item ui-selectee");
    });
    // 셀렉터블 타임피커 만들기
    $('#select_car_tbody tr').selectable({
      filter: ".td_item",
      cancel: ".reserved",
      stop: function () {
        var tr = $(this).closest('tr');
        var tr_id = tr.attr('id');
        $('#selected_car_name').val(tr_id);
        $("#select_car_tbody tr[id!=" + tr_id + "] td").each(function () {
          $(this).removeClass("ui-selected");
        })
        $(".selected_car").each(function () {
          $(this).removeClass("selected_car");
        });
        var result = $("#select_car_result").empty();
        var index = tr.find(".ui-selected").text();
        result.append(index);
        $('#selected_car_name').val(tr_id);
      }
    });

    // 그 날의 예약된 회의실이 있는지 조회 후 reserved 클래스로 만들어주기
    var select_car_day = $('#select_car_day').val();
    $.ajax({
      type: "GET",
      url: "/index.php/biz/schedule/search_car",
      dataType: "json",
      data: {
        select_car_day: select_car_day
      },
      cache: false,
      async: false,
      success: function (data) {
        // console.log(data);
        if (data != 'false') {
          var schedule_seq = 'nan';
          if (mode == 'detail') {
            schedule_seq = $('#de_seq').val();
          }
          for (var i = 0; i < data.length; i++) {
            var seq = data[i].seq;
            var car_name = data[i].car_name;
            var start_time = data[i].start_time.substring(0, 5);
            var end_time = data[i].end_time.substring(0, 5);
            var id_start_time = parseInt(start_time.replace(":", ""));
            var id_end_time = parseInt(end_time.replace(":", ""));
            if (schedule_seq == seq) {
              $("#select_car_tbody tr[id=" + car_name + "] td").each(function () {
                var td_id = $(this).attr('id');
                if (td_id >= id_start_time && td_id <= id_end_time - 30) {
                  $(this).addClass("ui-selected");
                  if (start_time != $('#de_startTime').val() || end_time != $('#de_endTime').val() || car_name != $('#de_car_name').val()) {
                    $(this).removeClass("ui-selected");
                  }
                }
              })
            } else {
              $("#select_car_tbody tr[id=" + car_name + "] td").each(function () {
                var td_id = $(this).attr('id');
                if (td_id >= id_start_time && td_id <= id_end_time - 30) {
                  $(this).removeClass("td_item ui-selectee ui-selected");
                  $(this).addClass("reserved");
                  var userName = data[i].user_name + " (" + data[i].insert_date + ")";
                  var tooltip_text = "<h3>" + data[i].title + "</h3>";
                  tooltip_text += "<div><span class='text-point'>[구 분]<span class='text-normal'>&nbsp;" + data[i].work_name + "</span></span><br>";
                  tooltip_text += "<span class='text-point'>[참석자]<span class='text-normal'>&nbsp;" + data[i].participant + "</span></span><br>";
                  tooltip_text += "<span class='text-point'>[등록자]<span class='text-normal'>&nbsp;" + userName + "</span></span></div>";
                  $(this).find('.tooltip-content').html(tooltip_text);
                }
              })
            }
          }
        }
      }
    });
  }

  // 등록 버튼 눌렀을 때
  function add_car(name) {
    if (name == 'update_car_btn') {
      var schedule_seq = $('#de_seq').val();
      $('#de_room_name').val('');
    } else {
      var schedule_seq = 'nan';
      $('#room_name').val('');
    }

    var select_car_day = $('#select_car_day').val();
    var list = $("#select_car_result").text();
    var start = list.substring(0, 5);
    var end = list.substring(list.length - 5);
    var car_name = $('#selected_car_name').val();
    var type = 'car_name';
    // alert(start+"~"+end+"/"+car_name);
    // return false;
    // stopPropagation();
    $.ajax({
      type: "POST",
      url: "/index.php/biz/schedule/duplicate_check",
      dataType: "json",
      data: {
        schedule_seq: schedule_seq,
        select_day: select_car_day,
        start: start,
        end: end,
        name: car_name,
        type: type
      },
      cache: false,
      // async:false,
      success: function (data) {
        // console.log(data);
        if (data == 'dupl') {
          alert('이미 예약된 차량입니다.')
        } else {
          var list = $("#select_car_result").text();
          var start = list.substring(0, 5);
          var end = list.substring(list.length - 5);
          var select_car_day = $('#select_car_day').val();
          if (name = 'update_car_btn') {
            $('#de_startTime').val(start);
            $('#de_endTime').val(end);
            $('#de_car_name').val(car_name);
            $('#de_startDay').val(select_car_day);
            $('#de_endDay').val(select_car_day);
          }
          if (name = 'add_car_btn') {
            $('#startTime').val(start);
            $('#endTime').val(end);
            $('#car_name').val(car_name);
            $('#startDay').val(select_car_day);
            $('#endDay').val(select_car_day);
          }
          $('#car_reservation_div').bPopup().close();
        }
      }
    });
  }

  // 차량 등록하고 날짜바꾸면 등록없애
  function car_reservation_del(mode) {
    if (mode == 'insert') {
      var start_day = $('#startDay').val();
      var end_day = $('#endDay').val();
      var car_name = $('#car_name').val();

      if (car_name != '' && start_day != end_day) {
        $('#car_name').val('');
      }
    } else {
      var start_day = $('#de_startDay').val();
      var end_day = $('#de_endDay').val();
      var car_name = $('#de_car_name').val();

      if (car_name != '' && start_day != end_day) {
        $('#de_car_name').val('');
      }
    }
  }

  //일정 내용 영역 추가하기
  function contents_add_action(mode){
    var length = $("textarea[name=" + mode + "]").length;
    var before_id = mode + "_tr_" + (length-1);
    var after_id = mode + "_tr_" + length;
    var split_mode = mode.split('_');
    if(split_mode.length > 1){
      var mode2 = 'de_';
    }else{
      var mode2 = '';
    }

    var html = "<tr id="+ after_id +">";
    html += "<td  colspan='2'><input type='checkbox' class='add_weekly_report' id='" + mode2 + "add_weekly_report_" + length + "' name='" + mode2 + "add_weekly_report' value='' style='vertical-align:middle;width:10%;float:left' onClick='nondisclosure_weekly_report("+'"'+mode2+"nondisclosure"+'"'+")'>";
    html += "<textarea class='textarea-common' rows='2' name='" + mode + "' id='" + mode + "_" + length + "' placeholder='상세내용' style='resize:none; vertical-align:middle;width:75%;float:left;margin-bottom:10px;' maxlength='300'></textarea>";
    html += "<input type='hidden' name='" + mode + "_num' id='" + mode + "_num_" + length + "' value='" + length + "'><img src='<?php echo $misc; ?>img/btn_del0.jpg' style='cursor:pointer; vertical-align:middle;float:right' id='" + mode2 + "contents_remove_" + length + "' name='" + mode2 + "contents_remove' onclick='contents_del(" + length + ',' + '"' + mode + '"' + ");return false;'/></td></tr>";

    $('#'+before_id).after(html);
  }

  //일정 내용 추가한 영역 삭제하기
  function contents_del(idx, mode) {

    var split_mode = mode.split('_');
    if (split_mode.length > 1) {
      var mode2 = 'de_';
    } else {
      var mode2 = '';
    }

    var length = $("textarea[name=" + mode + "]").length;
    $("#" + mode + "_tr_" + idx).remove();
    var i = 1;
    for (j = 1; j < length; j++) {
      if ($('#' + mode + '_tr_' + j).length > 0) {
        $('#' + mode + '_tr_' + j).attr('id', mode + '_tr_' + i);
        $('#' + mode + '_tr_' + i).find('img').attr('onclick', 'contents_del(' + i + ',"' + mode + '"' + ')');
        $('#' + mode + '_tr_' + i).find('input:checkbox').attr('id', mode2 + 'add_weekly_report_' + i);
        $('#' + mode + '_tr_' + i).find('textarea').attr('id', mode + '_' + i);
        $('#' + mode + '_tr_' + i).find('input:hidden').attr({
          'id': mode + '_num_' + i,
          'value': i
        });
        i++;
      } else {
        continue;
      }
    }
    // k--;
  }

  function nondisclosure_weekly_report(mode){
    var split_mode = mode.split('_');
    if (split_mode.length > 1) {
      var mode2 = 'de_';
    } else {
      var mode2 = '';
    }
    if ($('#' + mode + '_sch').is(":checked") == true) {
      alert('비공개 일정은 주간업무보고를 작성할 수 없습니다.');
      $('input:checkbox[name=' + mode2 + 'add_weekly_report]').prop('checked',false);
      return false;
    }
  };

  //일정 등록
  sch_insert = function (mode) {
    if ($('#'+mode+'work_type').val() == 'tech' && $('#'+mode+'supportMethod').val() == '') {
      alert('지원방법을 입력해주세요.');
      $('#'+mode+'supportMethod').focus();
      return false;
    }
    if ($('#'+mode+'startDay').val() == '') {
      alert('시작날짜를 입력해주세요.');
      $('#'+mode+'startDay').focus();
      return false;
    }
    if ($('#'+mode+'endDay').val() == '') {
      alert('종료날짜를 입력해주세요.');
      $('#'+mode+'endDay').focus();
      return false;
    }
    if ($('#'+mode+'startTime').val() == '') {
      alert('시작시간을 입력해주세요.');
      $('#'+mode+'startTime').focus();
      return false;
    }
    if ($('#endTime').val() == '') {
      alert('종료시간을 입력해주세요.');
      $('#endTime').focus();
      return false;
    }
    if ($('#'+mode+'workname').val() == '') {
      alert('작업구분을 입력해주세요.');
      $('#'+mode+'workname').focus();
      return false;
    }
    if ($('#'+mode+'work_type').val() == 'tech' && $('#'+mode+'customerName').val() == '') {
      alert('고객사를 선택해주세요.');
      $('#'+mode+'customerName').focus();
      return false;
    }
    if ($('#'+mode+'work_type').val() == 'general' && $('#'+mode+'title').val() == '') {
      alert('제목을 입력해주세요.');
      $('#'+mode+'title').focus();
      return false;
    }
    if ($('#'+mode+'work_type').val() == 'lab' && $('#'+mode+'dev_type').val() == '') {
      alert('개발구분을 선택해주세요.');
      $('#'+mode+'work_type').focus();
      return false;
    }
    if ($('#'+mode+'work_type').val() == 'lab' && $('#'+mode+'dev_page').val() == '') {
      alert('개발 페이지를 입력해주세요.');
      $('#'+mode+'dev_page').focus();
      return false;
    }
    if ($('#'+mode+'work_type').val() == 'lab' && $('#'+mode+'dev_develop').val() == '') {
      alert('개발사항을 입력해주세요.');
      $('#'+mode+'dev_develop').focus();
      return false;
    }
    if(($('#'+mode+'participant').val() == '') && $('#'+mode+'work_type').val() != 'company'){
      alert('참석자를 선택해주세요.');
      $('#'+mode+'participant').focus();
      return false;
    }

    //내용분할1
    //일정 내용 분할 값과 주간보고 여부를 배열로 만들어서 보내기
    var contents = [];
    if ($('#'+mode+'work_type').val() != 'lab') {
      var length = $('textarea[name='+mode+'contents]').length;
      if (length > 1) {
        for (var j = 1; j < length; j++) {
          //contents_0을 제외하고 나머지 contents들이 빈값인 상태일때는 해당 칸을 삭제하고 입력한다.
          if (($('#'+mode+'contents_' + j).val() == "") || ($('#'+mode+'contents_' + j).val() == "undefined")) {
            alert(j + 1 + "번째 내용이 비었습니다.");
            return false;
          }
        }
      }

      for (var i = 0; i < length; i++) { //내용이 분할 안된 것들도 0번 한번은 돌게 되어있기에 내용이 입력된다.
        // if (($('#contents_'+i).val()== "") || ($('#contents_'+i).val()== "undefined")) {
        //   alert("새로 추가한 " + i + "번째 내용이 비었습니다.");
        // }else{
        var contents_val = $('#'+mode+'contents_' + i).val();
        var contents_num_val = $('#'+mode+'contents_num_' + i).val();
        if ($('#'+mode+'add_weekly_report_' + i).is(':checked') == true) {
          var weekly_report_val = 'Y';
        } else {
          var weekly_report_val = 'N';
        }
        if ($('#'+mode+'work_type').val() == 'tech' ){
          var weekly_report_val = 'Y';
        }
        contents.push({
          'contents': contents_val,
          'contents_num': contents_num_val,
          'weekly_report': weekly_report_val
        })
        // }
      }
    } else {
      var dev_type = $("#"+mode+"dev_type").val();
      var dev_page = $("#"+mode+"dev_page").val();
      var dev_requester = $(""+mode+"#dev_requester").val();
      var dev_develop = $(""+mode+"#dev_develop").val();
      if ($("#"+mode+"dev_complete").is(':checked')==true){
        var dev_complete = 'Y';
      } else {
        var dev_complete = 'N';
      }

      var contents_val = "dev_type:::"+dev_type+",,,dev_page:::"+dev_page+",,,dev_requester:::"+dev_requester+",,,dev_develop:::"+dev_develop+",,,dev_complete:::"+dev_complete;
      contents.push({
        'contents': contents_val,
        'contents_num': 0,
        'weekly_report': 'Y'
      })
    }
    //내용분할2

    var startDay = $('#'+mode+'startDay').val();
    var startTime = $('#'+mode+'startTime').val();
    var endDay = $('#'+mode+'endDay').val();
    var endTime = $('#'+mode+'endTime').val();
    var workname = $('#'+mode+'workname').val();
    //KI1@@@@@
    // var customer = $('#customer').val();
    var work_type = $('#'+mode+'work_type').val();
    var customer = $('#'+mode+'customerName').val();
    var customer2 = $('#'+mode+'customerName2').val();
    var visitCompany = $('#'+mode+'visitCompany').val();
    var project = $('#'+mode+'project').val();
    var forcasting_seq = $('#'+mode+'forcasting_seq').val();
    //KI2@@@@@
    var supportMethod = $('#'+mode+'supportMethod').val();
    var participant = $('#'+mode+'participant').val();
    // var contents = $('#contents').val();
    // var insertDirect = $('#insertDirect').val();
    var title = $('#'+mode+'title').val();
    var place = $('#'+mode+'place').val();
    var maintain_seq = $('#'+mode+'maintain_seq').val();
    // var customer_manager = $('#customer_manager').val();

    var room_name = $('#'+mode+'room_name').val();
    var car_name = $('#'+mode+'car_name').val();
    if (room_name == '' && car_name != '') {
      var type = 'car_name';
      var name = car_name;
    } else {
      var type = 'room_name';
      var name = room_name;
    }
    // if($('#add_weekly_report').is(":checked") == true){
    //   var weekly_report = 'Y';
    // }else{
    //   var weekly_report = 'N';
    // }
    if ($('#'+mode+'nondisclosure_sch').is(":checked") == true) {
      var nondisclosure = 'Y';
    } else {
      var nondisclosure = 'N';
    }

    var seq = "nan";

    //반복일정 recurring
    var recurring_date = [];
    var recurring_setting = '';
    if($('#'+mode+'recurring_check').is(':checked') == true){

      var cycle_eq_val = $('#'+mode+'recurring_select option').index($('#'+mode+'recurring_select option:selected')); //selected된 option의 index값 구하기
      var cycle_num_val = $('#'+mode+'recurring_select option:eq('+cycle_eq_val+')').attr('num'); //option에 num요소 값 가져오기
      var cycle_ex_eq_val = $('#'+mode+'recurring_select_ex option').index($('#'+mode+'recurring_select_ex option:selected')); //selected된 option의 index값 구하기
      var cycle_ex_num_val = $('#'+mode+'recurring_select_ex option:eq('+cycle_ex_eq_val+')').attr('num'); //option에 num요소 값 가져오기
      recurring_setting = 'cycle:' + cycle_num_val + ';;;cycle_ex:' + cycle_ex_num_val;

      var recurring_val= $('#'+mode+'recurring_select').val();
      var recurring_val_arr = recurring_val.split(',');

      var recurring_ex_opt_id = $('#'+mode+'recurring_select_ex').val();
      var recurring_ex_val = $('#'+recurring_ex_opt_id).val();

      if(recurring_ex_opt_id == mode+'recurring_endDay'){
        for(i = 0; i < recurring_val_arr.length; i++){
          if(recurring_val_arr[i] > recurring_ex_val){
            recurring_val_arr.splice(i);
          }
        }
        recurring_date = recurring_val_arr;

        recurring_setting += ';;;endday:' + recurring_ex_val;

      }else if(recurring_ex_opt_id == mode+'recurring_count'){
        if(recurring_val_arr.length < recurring_ex_val){
          alert('반복 일자가 해당 년을 벗어났습니다.');
          return;
        }
        for(j = 0; j < recurring_ex_val; j++){
          recurring_date.push(recurring_val_arr[j]);
        }

        recurring_setting += ';;;count:' + recurring_ex_val;

      };

    }

    var startTime_2 = moment(startTime, 'HH:mm').format('HH:mm');
    var endTime_2 = moment(endTime, 'HH:mm').format('HH:mm');
    if (startTime_2 == '' && endTime_2 != '') {
      alert("시작시간을 먼저 작성해 주세요.");
      $('#endTime').val('');
      return false;
    }
    if ((startDay == endDay) && (startTime_2 > endTime_2)) {
      alert("종료시간이 시작시간보다 이전입니다.");
      $('#endTime').val('');
      return false;
      stopPropagation();
    }

    $.ajax({
      type: "POST",
      url: "/index.php/biz/schedule/duplicate_check",
      dataType: "json",
      data: {
        schedule_seq: seq,
        select_day: startDay,
        start: startTime,
        end: endTime,
        name: name,
        type: type
      },
      cache: false,
      async: false,
      success: function (data) {
        if (data == 'dupl') {
          alert('중복되는 차량 혹은 회의실이 있습니다.');
          stopPropagation();
        }
      }
    });

    $.ajax({
      type: "POST",
      url: "/index.php/biz/schedule/add_schedule",
      dataType: "json",
      data: {
        startDay: startDay,
        startTime: startTime,
        endDay: endDay,
        endTime: endTime,
        work_type: work_type,
        workname: workname,
        room_name: room_name,
        car_name: car_name,
        //KI1@@@@@
        // customer:customer,
        customer: customer,
        customer2: customer2,
        visitCompany: visitCompany,
        project: project,
        forcasting_seq: forcasting_seq,
        //KI2@@@@@
        supportMethod: supportMethod,
        participant: participant,
        contents: contents,
        title: title,
        place: place,
        maintain_seq: maintain_seq,
        // customer_manager:customer_manager,
        // weekly_report:weekly_report,
        nondisclosure: nondisclosure,
        recurring_date: recurring_date,
        recurring_setting:recurring_setting
      },
      cache: false,
      async: false,
      success: function (data) {
        if (data == 'false') {
          result = 'false';
        }
        alert("등록되었습니다.");
        if(mode == ''){
          $('#de_sch_div').bPopup().close();
        }else{
          $('#de_sch_div').bPopup().close();
        }
        duple_sch_chk = 'false';
        location.reload();
      },
      error: function (request, status, error) {
        alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
      }
    });
  };

function sch_modify(el,mode){
  $("#wrap-loading").bPopup({modalClose:false,opacity:0});
  if(mode == 'modify') {
    var seq = $(el).attr('seq');
  } else {
    var seq = el;
  }

  $('#de_startDay').val('');
  $('#de_endDay').val('');
  $('#de_startDay').css('background-color','#FFF');
  $('#de_endDay').css('background-color','#FFF');
  $('#de_startTime').css('background-color','#FFF');
  $('#de_endTime').css('background-color','#FFF');
  $('#de_startDay, #de_endDay, #de_startTime, #de_endTime').attr('readonly', false);
  $('#de_start_img').val('');
  $('#de_start_img').change();
  $('#de_end_img').val('');
  $('#de_end_img').change();
  $('#de_recurring_seq').val('');
  $('#recurring_mode').val('');
  $('#recurring_modify_choose').val('');

  $.ajax({
    type: 'GET',
    dataType: 'json',
    url: '/index.php/biz/schedule/tech_schedule_detail',
    data: {
      seq: seq
    },
    cache: false,
  }).done(function (result) {
    if (result) {

      $('#de_sch_div tr').each(function() {
  			if (!$(this).hasClass('basic_tr')) {
  				$(this).hide();
  			}
        if ($(this).hasClass('recurring_div')) {
          $(this).hide();
        }
  		})

      $('.recurring_div').hide();

      var details = result.details;
      var contents = result.contents;

      var seq = details.seq;
      var customer_manager = details.customer_manager;
      var forcasting_seq = details.forcasting_seq;
      var maintain_seq = details.maintain_seq;

      var start_day = details.start_day;
      var start_time = moment(details.start_time, 'HH:mm').format('HH:mm');
      // var start_time = details.start_time;
      var end_day = details.end_day;
      var end_time = moment(details.end_time, 'HH:mm').format('HH:mm');
      // var end_time = details.end_time;
      var work_name = details.work_name;
      var title = details.title;
      var place = details.place;
      var support_method = details.support_method;
      var customer = details.customer;
      var visitCompany = details.visit_company;
      var project = details.project;
      var tech_report = details.tech_report;
      var user_id = details.user_id;
      var user_name = details.user_name;
      var work_type = details.work_type;
      var room_name = details.room_name;
      var car_name = details.car_name;
      var nondisclosure = details.nondisclosure;


      var recurring_seq = details.recurring_seq;
      var recurring_setting = details.recurring_setting;

      var participant_val = details.participant;
      var participant = '';

      var start_reason = details.start_reason;
      var end_reason = details.end_reason;

      var s_file_changename = details.s_file_changename;
      var s_file_realname = details.s_file_realname;
      var e_file_changename = details.e_file_changename;
      var e_file_realname = details.e_file_realname;

      $('#de_workname').val(work_name);

      // $('#de_workname').change();
      change_workname($.trim(work_name));

      var before_textarea = $('textarea[name=de_contents]').length;
      if(before_textarea > 1){
        for(i=0; i<before_textarea; i++){
          //아래 함수를 사용하면 자동으로 순번이 재정렬 되기에(1,2,3,4에서 1삭제 -> 1,2,3) 계속 1번을 삭제해도 for문으로 돌면서 전부 삭제된다.
          contents_del(1,"de_contents");
        }
      }

      //참석자seq 받아오기
      $.ajax({
        type: "POST",
        dataType : "json",
        url: "<?php echo site_url();?>/biz/schedule/find_participant_seq",
        data: {
          participant: participant_val,
        },
        cache:false,
        async:false,
        success: function(result) {
          participant = result;
        }
      });

      var contents_length = contents.length;

      for (var i = 0; i < contents_length; i++) {
        if (work_type!='lab'){
          if ($('#de_contents_' + i).length <= 0) {
            contents_add_action('de_contents')
          }

          for (j = 0; j < contents_length; j++) {
            var contents_val = contents[j].contents;
            var contents_num_val = contents[j].contents_num;
            var weekly_report_val = contents[j].weekly_report;

            if (i == contents_num_val) {
              $('#de_contents_' + i).val(contents_val);
              if (weekly_report_val == 'Y') {
                $('#de_add_weekly_report_' + i).attr('checked', true);
              } else {
                $('#de_add_weekly_report_' + i).attr('checked', false);
              }
            }

          }
          $('#de_workname > option[value="기술연구소"]').remove();
        } else {
          if($('#de_workname > option[value="기술연구소"]').length == 0){
            var lab_option = "<option value='기술연구소'>기술연구소</option>";
            $('#de_workname').append(lab_option);
          }
          var content = contents[0].contents;
          content = content.split(',,,');
          for(var i=0;i<content.length;i++){
            var content2 = content[i].split(':::');
            if (content2[0]=='dev_type') {
              $("#de_dev_type > option[value="+content2[1]+"]").attr("selected","true");
            } else if (content2[0]=='dev_complete'){
              if(content2[1]=="Y"){
                $("#de_dev_complete").attr("checked","true");
              }
            } else {
              $('#de_'+content2[0]).val(content2[1]);
            }
          }
        }
      }

      if (nondisclosure == "Y") {
        $('#de_nondisclosure_sch').attr('checked', true);
        $('.de_except_nondisclosure_div').hide();
      } else {
        $('#de_nondisclosure_sch').attr('checked', false);
        $('.de_except_nondisclosure_div').show();
      }

      $('#de_seq').val(seq);
      $('#de_work_type').val(work_type);
      $('#de_customer_manager').val(customer_manager);
      $('#de_forcasting_seq').val(forcasting_seq);
      $('#de_maintain_seq').val(maintain_seq);
      $('#de_room_name').val(room_name);
      $('#de_car_name').val(car_name);
      $('#de_startDay').val(start_day);

      $('#de_startTime').val(start_time);
      $('#de_endDay').val(end_day);

      $('#de_endTime').val(end_time);
      $('#de_title').val(title);
      $('#de_place').val(place);
      $('#de_customerName').val(customer);
      $('#de_customerName2').val(customer);
      $('#de_visitCompany').val(visitCompany);
      $('#de_project').val(project);
      $('#de_start_reason').val(start_reason);
      $('#de_end_reason').val(end_reason);

      if(recurring_seq == null){
        $('#de_recurring_check').prop('checked', false);
        $("#de_recurring_select option:eq(0)").prop("selected", true);
        $("#de_recurring_select_ex option:eq(0)").prop("selected", true);
        $('#de_recurring_count').val('');
        $('#de_recurring_endDay').val('');
        change_recurring_select_ex('de_');
        recurring_form('de_', start_day);
        $('#de_recurring_seq').val('');
      }else{
        $('#de_recurring_check').prop('checked', true);
        $('#de_recurring_check').change();
        recurring_form('de_', start_day);
        $('#de_recurring_seq').val(recurring_seq);

        var recurring_split = recurring_setting.split(';;;');
        var recurring_split_arr = [];

        recurring_split.forEach(function(item, index){
          var recurring_split2 = item.split(':');
          recurring_split_arr[recurring_split2[0]] = recurring_split2[1];
        });
        var sel_opt_length = $('#de_recurring_select option').length;
        for(i = 0; i < sel_opt_length; i++){
          var sel_opt_num = $('#de_recurring_select option:eq('+i+')').attr('num');
          if(sel_opt_num == recurring_split_arr.cycle){
            $('#de_recurring_select option:eq('+i+')').prop('selected', true);
            $('#de_recurring_select_before_val').val(recurring_split_arr.cycle);
          }
        }
        var sel_opt_length = $('#de_recurring_select_ex option').length;
        for(i = 0; i < sel_opt_length; i++){
          var sel_opt_num = $('#de_recurring_select_ex option:eq('+i+')').attr('num');
          if(sel_opt_num == recurring_split_arr.cycle_ex){
            $('#de_recurring_select_ex option:eq('+i+')').prop('selected', true);
            $('#de_recurring_select_ex_before_val').val(recurring_split_arr.cycle_ex);
          }
        }
        change_recurring_select_ex('de_');

        if(recurring_split_arr.count != undefined){
          $('#de_recurring_count').val(recurring_split_arr.count);
          $('#de_recurring_input_before_val').val(recurring_split_arr.count);
        }else if(recurring_split_arr.endday != undefined){
          $('#de_recurring_endDay').val(recurring_split_arr.endday);
          $('#de_recurring_input_before_val').val(recurring_split_arr.endday);
        }
      }

      var participant_input = participant.replace(/[0-9_]/g, '');

      $('#de_participant').val(participant);
      $('#de_participant_input').val(participant_input);

      $("#de_supportMethod").val(support_method).prop("selected", true);
      $("#de_workname").val(work_name).prop("selected", true);
      if (work_name == '납품설치' || work_name == '미팅' || work_name == '데모(BMT)지원') {
        $('#de_customer').val(forcasting_seq);
      } else {
        //포캐스팅+유지보수
        if(maintain_seq == null){
          $('#de_customer').val(forcasting_seq);
        }else{
          $('#de_customer').val(maintain_seq);
        }
      }

      if (start_time == '00:00:00' && end_time == '00:00:00') {
        $("#de_startTime, #de_startTimeBtn, #de_endTime, #de_endTimeBtn").hide();
        $("input:checkbox[id='de_alldayCheck']").prop("checked", true);
      }

      if ($('#de_forcasting_seq').val() != "" && $('#de_maintain_seq').val()) {
        $('#de_customerName').attr('readonly', true);
        $('#de_project').attr('readonly', true);
      }

      var register = details.user_id;
      var regGroup = details.group;
      var regPgruop = details.p_group;
      //KI1 20210125
      var regParticipant = details.participant;
      var session_name = result.session_name;
      var session_id = result.session_id;
      var login_gruop = result.login_gruop;
      var login_pgroup = result.login_pgroup;
      var login_user_duty = result.login_user_duty;

      //선영추가 20210326
      var approval_yn = details.approval_yn;

      if (((register == session_id) || (login_user_duty == '팀장' && login_gruop == regGroup) || (login_user_duty == '이사' && login_pgroup == regPgruop) || (regParticipant.indexOf(session_name) > -1)) && approval_yn != "Y") { //indexOf값이 -1이 아니면 regParticipant 안에 본인이 들어가 있다는 것
        $("#de_sch_div").find("input, select, button, textarea").prop("disabled", false);
        $("#schdule_contoller_btn").show();
        $("#schdule_contoller_btn2").hide();
      } else {
        $("#de_sch_div").find("input, select, button, textarea, date").not('#btn_cancel').prop("disabled", true);
        $("#updateSubmit").prop("disabled", false);
        $("#de_participant_input").prop("disabled", false);
        $("#de_participant").prop("disabled", false);
        $("#schdule_contoller_btn").hide();
        $("#schdule_contoller_btn2").show();
      }

      var sday = details.start_day;
      sday = new Date(sday);
      var eday = details.end_day;
      eday = new Date(eday);
      var today = new Date();

      var dateDiff = Math.ceil((eday.getTime() - sday.getTime()) / (1000 * 3600 * 24)) + 1;

      $('#de_startTime, #de_endTime, #de_startDay, #de_endDay').attr('disabled',false);



      //다른사람 일정 내용 추가클릭 못하게
      if(regParticipant.indexOf(session_name) != -1 || user_name.indexOf(session_name) != -1){
        $('#de_sch_div').find('#de_contents_add').attr('onclick',"contents_add_action('de_contents');");
      } else {
        $('#de_sch_div').find('#de_contents_add').attr('onclick','').unbind('click');
        $('#de_sch_div').find('.de_contents_remove').attr('onclick','').unbind('click');
      }

      if (work_type == 'tech') {
        if (support_method == '원격지원') {
          $('.img_tr').hide();
        } else {
          $('.img_tr').show();
        }
        if ((start_reason != null || s_file_changename != null)) {
          var workDate = $("#de_startDay");
          var workTime = $("#de_startTime");

          workDate.attr('readonly',true);
          workDate.css('background-color','rgb(199, 199, 199)');
          workTime.attr('readonly',true);
          workTime.css('background-color','rgb(199, 199, 199)');
          workDate.datepicker("destroy");
          var clone = workTime.clone();
          var parent = workTime.parent();
          <?php if($this->agent->is_mobile()){?>
            workDate.attr('disabled', true);
            clone.attr('disabled', true);
            <?php } ?>
          workTime.remove();
          parent.append(clone);
        }
        if ((end_reason != null || e_file_changename != null)) {
          var workDate = $("#de_endDay");
          var workTime = $("#de_endTime");

          workDate.attr('readonly',true);
          workDate.css('background-color','rgb(199, 199, 199)');
          workTime.attr('readonly',true);
          workTime.css('background-color','rgb(199, 199, 199)');
          workDate.datepicker("destroy");
          var clone = workTime.clone();
          var parent = workTime.parent();
        <?php if($this->agent->is_mobile()){?>
          workDate.attr('disabled', true);
          clone.attr('disabled', true);
          <?php } ?>
          workTime.remove();
          parent.append(clone);
        }
        if (s_file_realname != null) {
          $('.s_file_input_box').hide();
          $('.s_file_view_box').show();
          if(s_file_realname.length >= 14){
            s_file_realname = s_file_realname.substr(0,14)+"...";
          }
          $('.s_file_img').text(s_file_realname);

          $('#s_img_detail').attr('onclick',"img_detail('"+s_file_changename+"')");
          $('#s_img_del').attr('onclick', 'del_img("'+s_file_changename+'", "s")');
        }
        if (s_file_realname == null) {
          $('.s_file_input_box').show();
          $('.s_file_view_box').hide();
        }
        if (e_file_realname != null) {
          $('.e_file_input_box').hide();
          $('.e_file_view_box').show();
          if(e_file_realname.length >= 14){
            e_file_realname = e_file_realname.substr(0,14)+"...";
          }
          $('.e_file_img').text(e_file_realname);

          $('#e_img_detail').attr('onclick',"img_detail('"+e_file_changename+"')");
          $('#e_img_del').attr('onclick', 'del_img("'+e_file_changename+'", "e")');
        }
        if (e_file_realname == null) {
          $('.e_file_input_box').show();
          $('.e_file_view_box').hide();
        }
      }


      if ( (start_reason != null || s_file_changename != null) && (end_reason != null || e_file_changename != null) || support_method == '원격지원' ) {
        if (tech_report == 0 && work_type == 'tech' && sday <= today) {
          $('.report_tr').show();
          $('#techReportModify').show();
          $('#techReportInsert').hide();
        } else if (tech_report > 0 && work_type == 'tech' && sday <= today && dateDiff < 3) {
          $('.report_tr').show();
          $('#techReportInsert').show();
          $('#techReportModify').hide();
        }
      }





      $('#de_sch_div').bPopup({
        follow: [false, false]
      });
      $("#wrap-loading").bPopup().close();


    }
  })
}

$(document).on("change", ".file-input", function(){
  $filename = $(this).val().replace(/.*(\/|\\)/, '');
  var target = $(this).attr('name');
  if($filename == "") {
    $filename = "파일을 선택해주세요.";
  } else {
    if ($filename.length >= 14) {
      $filename = $filename.substr(0,14) + "...";
    }
  }
  $(this).closest("div").find("."+target+"").text($filename);
})

function timeImgChk(mode, callback) {
  const fileInfo = document.getElementById( 'de_' + mode + '_img' ).files[0];
  // alert(fileInfo);

  const reader = new FileReader();

  reader.onload = function() {
    EXIF.getData(fileInfo, function() {
      const tags = EXIF.getAllTags( fileInfo );

      if (mode == 'start') {
        var workDate = $("#de_startDay");
        var workTime = $("#de_startTime");
        var m = '시작';
      } else {
        var workDate = $("#de_endDay");
        var workTime = $("#de_endTime");
        var m = '종료';
      }
      if(tags.DateTime == undefined) {
        alert('사진 정보를 읽을 수 없습니다.\n원본 사진을 첨부해주세요.');
        $('#de_'+mode+"_img").val('');
        $('#de_'+mode+"_img").change();
        return false;
      }
      // alert('|'+tags.DateTime+'|');
      var img_date = tags.DateTime.split(" ")[0];

      var varUA = navigator.userAgent.toLowerCase();

      if ( varUA.indexOf("iphone") > -1||varUA.indexOf("ipad") > -1||varUA.indexOf("ipod") > -1 || (navigator.appName == 'Netscape' && varUA.indexOf('trident') != -1) || (varUA.indexOf("msie") != -1)) {
        img_date = img_date.replace(/:/gi,'/');
        var wd = workDate.val().replace(/-/gi,'/');
      } else {
        img_date = img_date.replace(/:/gi,'-');
        var wd = workDate.val();
      }
      var img_time = tags.DateTime.split(" ")[1];
      var st = new Date(wd + " " + workTime.val());
      var it = new Date(img_date + " " + img_time);

      console.log(st);
      console.log(it);

      var gepSec = it.getTime() - st.getTime();
      var gepMin = gepSec / 1000 / 60;
// alert(it.getTime() + st.getTime());
      // console.log(gepMin);

      if (gepMin < 0) {
        alert('작업'+m+' 시간이 사진보다 이후입니다.\n작업'+m+' 시간을 수정해주세요.\n작업'+m+'일 : '+workDate.val()+" "+workTime.val()+"\n사진 찍은 날짜 : "+img_date+" "+img_time);
        $('#de_'+mode+"_img").val('');
        $('#de_'+mode+"_img").change();
        return false;
      }
      if (gepMin > 30) {
        alert('작업'+m+' 시간과 30분 이상 차이나는 사진입니다.\n작업'+m+' 시간을 수정해주세요.\n작업'+m+'일 : '+workDate.val()+" "+workTime.val()+"\n사진 찍은 날짜 : "+img_date+" "+img_time);
        $('#de_'+mode+"_img").val('');
        $('#de_'+mode+"_img").change();
        return false;
      }
      alert(m+' 시간 일치');
      // if (mode == 'start') {
      //   timeImgChk('end');
      // }
      workDate.attr('readonly',true);
      workDate.css('background-color','rgb(199, 199, 199)');
      workTime.attr('readonly',true);
      workTime.css('background-color','rgb(199, 199, 199)');
      workDate.datepicker("destroy");
      var clone = workTime.clone();
      var parent = workTime.parent();
      workTime.remove();
      parent.append(clone);

      return true;
    });
  };

  if( fileInfo ) {
    reader.readAsDataURL( fileInfo );
  }
}

function del_img(change_filename, type) {
  var seq = $("#de_seq").val();

  $.ajax({
    type: "POST",
    dataType: "json",
    url: "<?php echo site_url(); ?>/biz/schedule/tech_img_del",
    data: {
      seq: seq,
      type: type,
      change_filename: change_filename
    },
    cache: false,
    async: false,
    success: function(result) {
      alert('삭제되었습니다.');
      sch_modify(seq,'detail');
    }
  })
}

function img_detail(fileName) {
  var img = '<img id="detail_img" src="<?php echo $misc; ?>upload/biz/schedule/'+fileName+'" style="width:150px;margin-top:10px;">';
  $("#thumbnail").html(img);


  var t = 2000;

  $("#wrap-loading").bPopup({modalClose:false,opacity:0});

  $("#detail_img").load(function() {
    get_exif();
  })
}

function get_exif() {
  var detail_img = document.getElementById("detail_img");
  EXIF.getData(detail_img, function() {
    var allMetaData = EXIF.getAllTags(this);
    var make = allMetaData.Make;
    var model = allMetaData.Model;
    var dateTime = allMetaData.DateTime;
    var latitude = allMetaData.GPSLatitude;
    var longitude = allMetaData.GPSLongitude;

    $("#imgMake").text(make);
    $("#imgModel").text(model);
    $("#imgDateTime").text(dateTime);

    latitude_map = dmsToDec(latitude[0],latitude[1],latitude[2]);
    longitude_map = dmsToDec(longitude[0],longitude[1],longitude[2]);

    drawMap(latitude_map, longitude_map);
  });

  $("#wrap-loading").bPopup().close();
  $("#img_detail").bPopup();
}

function dmsToDec(deg, min, sec) {
  return deg+(((min*60)+(sec))/3600);
}

function drawMap(lat, lng) {

  var mapContainer = document.getElementById('map'), // 지도를 표시할 div
      mapOption = {
          center: new kakao.maps.LatLng(lat, lng), // 지도의 중심좌표
          level: 5 // 지도의 확대 레벨
      };

  var map = new kakao.maps.Map(mapContainer, mapOption); // 지도를 생성합니다

  // 마커가 표시될 위치입니다
  var markerPosition  = new kakao.maps.LatLng(lat, lng);

  // 마커를 생성합니다
  var marker = new kakao.maps.Marker({
      position: markerPosition
  });

  // 마커가 지도 위에 표시되도록 설정합니다
  map.relayout();
  marker.setMap(map);

}

function supportMethod_change(el) {
  var support_method = $("#de_supportMethod").val();
  if(support_method=="원격지원"){
    $('.de_tech_img_div').hide();
  } else if (support_method=='현장지원'){
    $('.de_tech_img_div').show();
  }
}

function modify(mode){
  // alert(mode);

  var seq = $("#de_seq").val();
  var work_type = $('#de_work_type').val();
  // var customer_manager = $("#de_customer_manager").val();
  var start_day = $("#de_startDay").val();
  var start_time = $("#de_startTime").val();
  var end_day = $("#de_endDay").val();
  var end_time = $("#de_endTime").val();
  var work_name = $("#de_workname").val();
  var customerName = $("#de_customerName").val();
  var customerName2 = $("#de_customerName2").val();
  var visitCompany = $("#de_visitCompany").val();
  var forcasting_seq = $("#de_forcasting_seq").val();
  var maintain_seq = $("#de_maintain_seq").val();
  var project = $("#de_project").val();
  var tech_report = $("#de_tech_report").val();
  var support_method = $("#de_supportMethod").val();
  var participant = $("#de_participant").val();
  // var contents = $("#de_contents").val();
  var title = $("#de_title").val();
  var place = $("#de_place").val();
  var sday = $('#de_startDay').val();
  var eday = $('#de_endDay').val();
  var room_name = $('#de_room_name').val();
  var car_name = $('#de_car_name').val();
  if(room_name == '' && car_name != ''){
    var name = car_name;
    var type = 'car_name';
  }else{
    var name = room_name;
    var type = "room_name";
  }
  // if($('#de_add_weekly_report').is(":checked") == true){
  //   var weekly_report = "Y";
  // }else{
  //   var weekly_report = "N";
  // }
  // if($('#de_old_weekly_report').val() != null){
  //
  // }
  if($('#de_nondisclosure_sch').is(":checked") == true){
    var nondisclosure = "Y";
  }else{
    var nondisclosure = "N";
  }

  //반복 일정 recurring
  var recurring_modify_choose = $('#recurring_modify_choose').val();
  var recurring_seq = $('#de_recurring_seq').val();
  var recurring_count = $('#de_recurring_count').val();
  //반복일정 수정되는지 확인하기 위해 수정 전 val값을 받아놓은 것을 가져옴
  var recurring_select_before_val = $('#de_recurring_select_before_val').val();
  var recurring_select_ex_before_val = $('#de_recurring_select_ex_before_val').val();
  var recurring_input_before_val = $('#de_recurring_input_before_val').val();

  //내용분할1
  //일정 내용 분할 값과 주간보고 여부를 배열로 만들어서 보내기
  var contents= [];
  if(work_type != 'lab'){

    var length = $('textarea[name=de_contents]').length;

    if(length > 1){
      for(var j = 1; j < length; j++){
        //contents_0을 제외하고 나머지 contents들이 빈값인 상태일때는 해당 칸을 삭제하고 입력한다.
        if (($('#de_contents_'+j).val()== "") || ($('#de_contents_'+j).val()== "undefined")) {
          alert(j+1 + "번째 내용이 비었습니다.");
          return false;
        }
      }
    }

    for(var i = 0; i < length; i++){ //내용이 분할 안된 것들도 0번 한번은 돌게 되어있기에 내용이 수정된다.
      var contents_val = $('#de_contents_'+i).val();
      var contents_num_val = $('#de_contents_num_'+i).val();
      if($('#de_add_weekly_report_'+i).is(':checked') == true){
        var weekly_report_val = 'Y';
      }else{
        var weekly_report_val = 'N';
      }
      if(work_type == 'tech'){
        var weekly_report_val = 'Y';
      }
      contents.push({
        'contents':contents_val,
        'contents_num':contents_num_val,
        'weekly_report':weekly_report_val
      })
    }

  }else{
    var dev_type = $("#de_dev_type").val();
    var dev_page = $("#de_dev_page").val();
    var dev_requester = $("#de_dev_requester").val();
    var dev_develop = $("#de_dev_develop").val();
    if ($("#de_dev_complete").is(':checked')==true){
      var dev_complete = 'Y';
    } else {
      var dev_complete = 'N';
    }

    var contents_val = "dev_type:::"+dev_type+",,,dev_page:::"+dev_page+",,,dev_requester:::"+dev_requester+",,,dev_develop:::"+dev_develop+",,,dev_complete:::"+dev_complete;
    contents.push({
      'contents': contents_val,
      'contents_num': 0,
      'weekly_report': 'Y'
    })
  }
  //내용분할2


  if(mode == 'schedule_delete'){
    // alert(recurring_modify_choose + '-' +recurring_seq);
    //recurring
    if(recurring_modify_choose == '' && recurring_seq != ''){
      // alert('recurring_modify_choose: '+recurring_modify_choose+' recurring_seq:'+recurring_seq);
      recurring_setting_change('3', null);
      // $('#recurring_sch_popup').bPopup();
      // $('#recurring_mode').val('schedule_delete');
      return;
    }else if(recurring_modify_choose == '' && recurring_seq == ''){
      recurring_modify_choose = null;
      recurring_seq = null;
    }

    var result = confirm("정말 삭제 하시겠습니까?");
    if(result){
      var seq = $('#de_seq').val();
      $.ajax({
        type: "POST",
        dataType : "json",
        url: "<?php echo site_url();?>/biz/schedule/delete",
        data: {
          seq: seq,
          recurring_modify_choose: recurring_modify_choose,
          recurring_seq: recurring_seq
        },
        success: function(result){
          // console.log(result);
          if (result == "report_written"){
            alert('보고서가 작성된 일정은 삭제할 수 없습니다.\n작성된 기술지원보고서를 먼저 삭제해주세요.');
            calendar.refetchEvents();
          }

          if(result == "true"){
            location.reload();
            // $('#detail_contain').hide();
            // $('#sd_contain').show();
            $('#updateSchedule').bPopup().close();
          }
          $('#de_recurring_seq').val('');
          $('#recurring_mode').val('');
          $('#recurring_modify_choose').val('');
        }
      });
    }else{
      $('#recurring_mode').val('');
      $('#recurring_modify_choose').val('');
    }
  }

  if(mode == 'schedule_modify'){
    var start_reason = $('#de_start_reason').val();
    var end_reason = $('#de_end_reason').val();
    //KI1 20210125 입력시 빈칸이 있으면 넘어가지 않도록 조건 제한
    if( $('#de_work_type').val() == 'tech' ){

      if($('#de_startDay').val() == ''){
        alert('시작날짜를 입력해주세요.');
        $('#de_startDay').focus();
        return false;
      }
      if($('#de_endDay').val() == ''){
        alert('종료날짜를 입력해주세요.');
        $('#de_endDay').focus();
        return false;
      }
      if($('#de_startTime').val() == ''){
        alert('시작시간을 입력해주세요.');
        $('#de_startTime').focus();
        return false;
      }
      if($('#de_endTime').val() == ''){
        alert('종료시간을 입력해주세요.');
        $('#de_endTime').focus();
        return false;
      }
      if($('#de_workname').val() == ''){
        alert('작업구분을 입력해주세요.');
        $('#de_workname').focus();
        return false;
      }
      if($('#de_supportMethod').val() == ''){
        alert('지원방법을 입력해주세요.');
        $('#de_supportMethod').focus();
        return false;
      }
      if($('#de_customerName').val() == ''){
        alert('고객사를 선택해주세요.');
        $('#de_customerName').focus();
        return false;
      }
      if($('#de_project').val() == ''){
        alert('프로젝트란이 비어있습니다. 고객사를 다시 선택해주세요.');
        $('#de_customerName').val('');
        $('#de_customerName').focus();
        // $('#de_project').focus();
        return false;
      }
      if(($('#de_participant').val() == '') && ($('#de_work_type').val() != 'company')){
        alert('참석자를 선택해주세요.');
        $('#de_participant').focus();
        return false;
      }
    } else if ( $('#de_work_type').val() == 'lab' ) {
      if ($('#de_dev_type').val() == '') {
        alert('개발구분을 선택해주세요.');
        $('#de_work_type').focus();
        return false;
      }
      if ($('#de_dev_page').val() == '') {
        alert('개발 페이지를 입력해주세요.');
        $('#de_work_page').focus();
        return false;
      }
      if ($('#de_dev_develop').val() == '') {
        alert('개발사항을 입력해주세요.');
        $('#de_dev_develop').focus();
        return false;
      }
    } else{
      if($('#de_title').val() == ''){
        alert('제목을 입력해주세요.');
        $('#de_title').focus();
        return false;
      }
      if($('#de_endDay').val() == ''){
        alert('종료날짜를 입력해주세요.');
        $('#de_endDay').focus();
        return false;
      }
      if($('#de_endTime').val() == ''){
        alert('종료시간을 입력해주세요.');
        $('#de_endTime').focus();
        return false;
      }
      // if($('#de_place').val() == ''){
      //   alert('장소를 입력해주세요.');
      //   $('#de_place').focus();
      //   return false;
      // }
      if(($('#de_participant').val() == '') && ($('#de_work_type').val() != 'company')){
        alert('참석자를 선택해주세요.');
        $('#de_participant').focus();
        return false;
      }
    }
    //KI2 20210125
    var start_time_2 = moment(start_time,'HH:mm').format('HH:mm');
    var end_time_2 = moment(end_time,'HH:mm').format('HH:mm');
    if (start_time == '' && end_time != ''){
      alert("시작시간을 먼저 작성해 주세요.");
      $('#de_endTime').val('');
      return false;
    }
    if((start_day == end_day) && (start_time_2 > end_time_2)) {
        alert("종료시간이 시작시간보다 이전입니다.");
        $('#de_endTime').val('');
        return false;
    }

// alert('forcasting_seq:'+forcasting_seq+' maintain_seq:'+maintain_seq)

    // var act = "<?php echo site_url();?>/biz/schedule/modify"
    // $("#de_hiddenSeq").attr('action', act).submit();
    // var seq = $('#de_seq').val();


    //반복일정 recurring
    var recurring_setting = '';
    var recurring_date = [];
    var recurring_val = '';
    if($('#de_recurring_check').is(':checked') == true){

      if(recurring_modify_choose == '' && recurring_seq != ''){
        recurring_setting_change('1', null);
        return;

      // }else if(recurring_modify_choose == '' && recurring_seq == ''){ //반복일정 아닌 일정을 반복일정으로 체크 후 저장
        // sch_insert('de_');
        //해당 일정도 수정하고 반복일정 나머지 새로 insert한다.
      }else{ //모든 일정

        var cycle_eq_val = $('#de_recurring_select option').index($('#de_recurring_select option:selected')); //selected된 option의 index값 구하기
        var cycle_num_val = $('#de_recurring_select option:eq('+cycle_eq_val+')').attr('num'); //option에 num요소 값 가져오기
        var cycle_ex_eq_val = $('#de_recurring_select_ex option').index($('#de_recurring_select_ex option:selected')); //selected된 option의 index값 구하기
        var cycle_ex_num_val = $('#de_recurring_select_ex option:eq('+cycle_ex_eq_val+')').attr('num'); //option에 num요소 값 가져오기
        recurring_setting = 'cycle:' + cycle_num_val + ';;;cycle_ex:' + cycle_ex_num_val;

        if(recurring_modify_choose == '' && recurring_seq == ''){
          recurring_seq = seq;
          recurring_val= $('#de_recurring_select').val();
        }else{

          if(recurring_modify_choose == 'all_sch'){ //모든 일정
            //이 일정의 re_seq와 일치하는 모든 일정 update
            $.ajax({
              type: "POST",
              url:"<?php echo site_url();?>/biz/schedule/find_recurring_original_sch",
              dataType:"json",
              data:{
                recurring_seq: recurring_seq,
                seq: null
              },
              cache:false,
              async:false,
              success: function(data) {
                if(cycle_num_val == 1){
                  everyday(data.start_day);
                  recurring_val = $('#de_recurring_day').val();
                }else if(cycle_num_val == 2){
                  dayOfTheWeek_in_week(data.start_day);
                  recurring_val = $('#de_recurring_week').val();
                }else if(cycle_num_val == 3){
                  day_in_month(data.start_day);
                  recurring_val = $('#de_recurring_month_day').val();
                }else if(cycle_num_val == 4){
                  dayOfTheWeek_num_in_month(data.start_day);
                  recurring_val = $('#de_recurring_month').val();
                }
                // end_day = data.end_day;
              }
            });

          }else if(recurring_modify_choose == 'forward_sch'){ // 이 일정 및 향후 일정
            //   //이 일정의 re_seq와 일치하는 일정들을 seq로 정렬해서 이 일정과 그 이후의 모든 일정 update
            // recurring_val= $('#de_recurring_select').val();
            $.ajax({
              type: "POST",
              url:"<?php echo site_url();?>/biz/schedule/find_recurring_original_sch",
              dataType:"json",
              data:{
                recurring_seq: recurring_seq,
                seq: seq
              },
              cache:false,
              async:false,
              success: function(data) {
                if(cycle_num_val == 1){
                  everyday(data.start_day);
                  recurring_val = $('#de_recurring_day').val();
                }else if(cycle_num_val == 2){
                  dayOfTheWeek_in_week(data.start_day);
                  recurring_val = $('#de_recurring_week').val();
                }else if(cycle_num_val == 3){
                  day_in_month(data.start_day);
                  recurring_val = $('#de_recurring_month_day').val();
                }else if(cycle_num_val == 4){
                  dayOfTheWeek_num_in_month(data.start_day);
                  recurring_val = $('#de_recurring_month').val();
                }
                // end_day = data.end_day;
              }
            });

          }else if(recurring_modify_choose == 'only_this_sch'){ //이 일정만
            //이 일정의 seq만 가져가서 해당 일정만 update
            recurring_val= $('#de_recurring_select').val();
            //반복세팅 수정 안된 상태
            // sch_insert('de_');
            // return;
          }
        }
        var recurring_val_arr = recurring_val.split(',');

        var recurring_ex_opt_id = $('#de_recurring_select_ex').val();
        var recurring_ex_val = $('#'+recurring_ex_opt_id).val();

        if(recurring_ex_opt_id == 'de_recurring_endDay'){ //반복일자만큼 자르기
            for(i = 0; i < recurring_val_arr.length; i++){
                if(recurring_val_arr[i] > recurring_ex_val){
                  recurring_val_arr.splice(i);
                }
            }
            recurring_date = recurring_val_arr;
            recurring_setting += ';;;endday:' + recurring_ex_val;

        }else if(recurring_ex_opt_id == 'de_recurring_count'){  //반복횟수만큼 자르기
          // if(recurring_val_arr.length < recurring_ex_val){
          //   console.log(recurring_val_arr.length+'-'+recurring_ex_val);
          //   alert('반복 일자가 해당 년을 벗어났습니다.');
          //   return;
          // }
          for(j = 0; j < recurring_ex_val; j++){
            recurring_date.push(recurring_val_arr[j]);
          }
          recurring_setting += ';;;count:' + recurring_ex_val;
        };
      }

    }else{
      recurring_setting = null;
      recurring_date = null;
      recurring_seq = null;
      recurring_modify_choose = null;
      recurring_count = null;
    }

    $.ajax({
      type: "POST",
      url:"<?php echo site_url();?>/biz/schedule/duplicate_check",
      // url:"<?php //echo site_url();?>/biz/schedule/duplicate_checkroom",
      dataType:"json",
      data:{
        schedule_seq: seq,
        select_day: start_day,
        start:start_time,
        end:end_time,
        name: name,
        type: type
      },
      cache:false,
      async:false,
      success: function(data) {
        // console.log(data);
        if(data == 'dupl'){
          alert('중복되는 차량 혹은 회의실 일정이 있습니다.');
          stopPropagation();
        }
      }
    });

    $.ajax({
      type: "POST",
      url:"<?php echo site_url();?>/biz/schedule/sch_report_approval",
      dataType:"json",
      data:{
        schedule_seq: seq
      },
      cache:false,
      async:false,
      success: function(data) {
        // alert(data['approval_yn']);
        if(data === 'Y'){
          alert('주간업무보고 결제가 완료된 일정은 수정할 수 없습니다.');
          stopPropagation();
        }
      }
    });

    if ($("#de_start_img").val() != '' || $("#de_end_img").val() != '') {
      $("#wrap-loading").bPopup({modalClose:false,opacity:0});

      var formData = new FormData(document.getElementById("img_file_form"));

      var fileCount = 0;
      var fileType = [];
      $(".file-input").each(function() {
        if ($(this).val()!='') {
          formData.append('file_'+fileCount, $(this)[0].files[0]);
          var id = $(this).attr('id');
          type = id.split('_')[1];
          fileType.push(type.charAt(0));
          fileCount++;
        }
      })

      formData.append('fileType', fileType);
      formData.append('seq', $('#de_seq').val());
      formData.append('fileCount', fileCount);
      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: '<?php echo site_url(); ?>/biz/schedule/tech_img_upload',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {
          $.ajax({
            type: "GET",
            dataType : "json",
            url: "<?php echo site_url();?>/biz/schedule/modify",
            data: {
              seq: seq, //#
              work_type : work_type,
              // customer_manager: customer_manager,
              startDay: start_day,
              startTime: start_time,
              endDay: end_day,
              endTime: end_time,
              workname: work_name,
              customerName: customerName,
              customerName2: customerName2,
              visitCompany: visitCompany,
              forcasting_seq: forcasting_seq,
              maintain_seq: maintain_seq,
              project: project,
              supportMethod: support_method,
              tech_report: tech_report, //#
              participant: participant,
              contents: contents,
              title: title,
              place: place,
              room_name: room_name,
              car_name: car_name,
              // weekly_report:weekly_report,
              nondisclosure:nondisclosure,
              recurring_seq: recurring_seq, //#
              recurring_date: recurring_date,
              recurring_setting: recurring_setting,
              recurring_modify_choose: recurring_modify_choose, //#
              recurring_count: recurring_count, //#
              start_reason: start_reason,
              end_reason: end_reason
            },
            cache:false,
            async:false,
            success: function(result) {
              if (result == "report_written"){
                alert('보고서가 작성된 일정은 수정할 수 없습니다.');
                calendar.refetchEvents();
                $("#wrap-loading").bPopup().close();
              }
              if(result == "true"){
                location.reload();
                alert('수정되었습니다.');
                $('#updateSchedule').bPopup().close();
                $('#de_recurring_seq').val(''); //이 값이 존재하냐 마냐로 반복 일정 등록할 때 recurring_seq를 생성할지 말지 결정하기에 미리 비워두는 것
                $("#wrap-loading").bPopup().close();
              }else{
                alert('오류가 발생했습니다.');
                $('#updateSchedule').bPopup().close();
                $('#de_recurring_seq').val(''); //이 값이 존재하냐 마냐로 반복 일정 등록할 때 recurring_seq를 생성할지 말지 결정하기에 미리 비워두는 것
                $("#wrap-loading").bPopup().close();
              }
            }
          });
        },
        error: function(e) {
          alert("ERROR:",e);
          $("#wrap-loading").bPopup().close();
        }
      })
    } else {
      $.ajax({
        type: "GET",
        dataType : "json",
        url: "<?php echo site_url();?>/biz/schedule/modify",
        data: {
          seq: seq, //#
          work_type : work_type,
          // customer_manager: customer_manager,
          startDay: start_day,
          startTime: start_time,
          endDay: end_day,
          endTime: end_time,
          workname: work_name,
          customerName: customerName,
          customerName2: customerName2,
          visitCompany: visitCompany,
          forcasting_seq: forcasting_seq,
          maintain_seq: maintain_seq,
          project: project,
          supportMethod: support_method,
          tech_report: tech_report, //#
          participant: participant,
          contents: contents,
          title: title,
          place: place,
          room_name: room_name,
          car_name: car_name,
          // weekly_report:weekly_report,
          nondisclosure:nondisclosure,
          recurring_seq: recurring_seq, //#
          recurring_date: recurring_date,
          recurring_setting: recurring_setting,
          recurring_modify_choose: recurring_modify_choose, //#
          recurring_count: recurring_count, //#
          start_reason: start_reason,
          end_reason: end_reason
        },
        cache:false,
        async:false,
        success: function(result) {
          if (result == "report_written"){
            alert('보고서가 작성된 일정은 수정할 수 없습니다.');
            calendar.refetchEvents();
          }
          if(result == "true"){
            location.reload();
            alert('수정되었습니다.');
            $('#updateSchedule').bPopup().close();
            $('#de_recurring_seq').val(''); //이 값이 존재하냐 마냐로 반복 일정 등록할 때 recurring_seq를 생성할지 말지 결정하기에 미리 비워두는 것
          }else{
            alert('오류가 발생했습니다.');
            $('#updateSchedule').bPopup().close();
            $('#de_recurring_seq').val(''); //이 값이 존재하냐 마냐로 반복 일정 등록할 때 recurring_seq를 생성할지 말지 결정하기에 미리 비워두는 것
          }
        }
      });
    }

    $('#de_recurring_seq').val('');
    $('#recurring_mode').val('');
    $('#recurring_modify_choose').val('');
  }

  if(mode == 'report'){ //기술지원보고서 작성
    //KI1 20210125 입력시 빈칸이 있으면 넘어가지 않도록 조건제한
    if($('#de_startDay').val() == ''){
      alert('시작날짜를 입력해주세요.');
      $('#startDay').focus();
      return false;
    }
    if($('#de_endDay').val() == ''){
      alert('종료날짜를 입력해주세요.');
      $('#de_endDay').focus();
      return false;
    }
    if($('#de_workname').val() == ''){
      alert('작업구분을 입력해주세요.');
      $('#de_workname').focus();
      return false;
    }
    if($('#de_supportMethod').val() == ''){
      alert('지원방법을 입력해주세요.');
      $('#de_supportMethod').focus();
      return false;
    }
    if($('#de_customerName').val() == ''){
      alert('고객사를 선택해주세요.');
      $('#de_customerName').focus();
      return false;
    }
    if(($('#de_participant').val() == '') && ($('#de_work_type').val() != 'company')){
      alert('참석자를 선택해주세요.');
      $('#de_participant').focus();
      return false;
    }

    var schedule_seq = $('#de_seq').val();
    move(schedule_seq, sday, eday);

  }

//@@@
  if(mode == 'modify'){ //기술지원보고서 수정
    var schedule_seq = $('#de_seq').val();
    $.ajax({
      type : "POST",
      url : "<?php echo site_url(); ?>/biz/schedule/tech_seq_find",
      dataType : "json",
      data : {
        schedule_seq : schedule_seq,
        start_day: start_day,
        customer: customerName,
        type : "Y"
      },
      success : function(data){
        var seq = data[0].seq;

        location.href = "<?php echo site_url(); ?>/tech/tech_board/tech_doc_view?mode=view&seq="+seq+"&type=Y";
      }
    })

  }
}

function move(schedule_seq, income_day, end_work_day){

  $.ajax({
    url : "<?php echo site_url(); ?>/biz/schedule/find_seq_in_tech_doc_basic_temporary_save",
    type : "POST",
    dataType : "json",
    data : {
      seq : schedule_seq,
      income_time : income_day
    },
    cache : false,
    async : false,
    success : function(data){
      console.log(data);
      if(data != null){
        var con = confirm("임시저장된 기술지원보고서가 존재합니다.\n\n저장 내용을 불러오려면 확인 버튼을 눌러주세요.\n\n저장 내용을 삭제하고 새로 작성하려면 취소 버튼을 눌러주세요.");
        if(con){
          location.href = "<?php echo site_url(); ?>/tech/tech_board/tech_doc_view?mode=view&seq="+data+"&type=N";

        }else{
          $.ajax({
            url:"<?php echo site_url(); ?>/biz/schedule/tech_doc_basic_temporary_save_delete",
            type : "POST",
            dataType : "json",
            data : {
              schedule_seq : schedule_seq
            },
            success: function(data){
              if(data == 'true'){
                alert('임시저장된 보고서가 삭제되었습니다.');
                location.href= "<?php echo site_url();?>/tech/tech_board/tech_doc_input?schedule_seq="+schedule_seq+"&income_day="+income_day+"&end_work_day="+end_work_day;
              }
            }
          });
        }
      }else{ //data == null
        location.href= "<?php echo site_url();?>/tech/tech_board/tech_doc_input?schedule_seq="+schedule_seq+"&income_day="+income_day+"&end_work_day="+end_work_day;
      }
    }
  });
}

//비공개 일정 체크부분 표시/숨기기
function nondisclosure_form(mode) {

  var split_mode = mode.split('_');
  if (split_mode.length > 1) {
    var mode2 = 'de_';
  } else {
    var mode2 = '';
  }

  if ($('#' + mode + '_sch').is(":checked") == true) {
    $('.' + mode2 + 'except_nondisclosure_div').hide();
  } else {
    $('.' + mode2 + 'except_nondisclosure_div').show();
  }
}

function go_sch_page(mode) {

  if (getParam('selUser') != '') {
    var selUser = 'selUser=' + getParam('selUser');
  } else {
    var selUser = '';
  }

  if (mode == 'month') {
    var month = $("#calendar_month").text();
    month = month.replace('.', '-');
    month = '&month=' + month;
    // 월 버튼 눌렀을 시점 첫 화면에서 리스트만 필요하기 때문에 해당 월만 GET 으로 넘김
    // 월 변경 시에는 refresh_sch 함수로 동작
    location.href = "<?php echo site_url(); ?>/biz/schedule/tech_schedule_mobile?" + selUser + month;
  } else if (mode == 'day') {
    if (getParam('month')!='') {
      var date = $("#calendar_month").text();
      date = date.replace('.', '-');
      date = '&date=' + date+'-01';
      location.href = "<?php echo site_url(); ?>/biz/schedule/tech_schedule_mobile?" + selUser + date;
    }
  } else {
    location.href = "<?php echo site_url(); ?>/biz/schedule/tech_schedule_mobile?" + selUser;
  }

}
</script>
