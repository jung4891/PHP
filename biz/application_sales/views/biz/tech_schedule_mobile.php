<?php // TODO: 월, 주, 일 추가 ?>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<body>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	  ?>
	<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
	<script src="<?php echo $misc; ?>js/touch-punch.js"></script>
  <link rel="stylesheet" href="/misc/css/view_page_common.css">
  <link rel="stylesheet" href="/misc/css/simple-calendar_mobile.css">
  <script type="text/javascript" src="/misc/js/jquery.simple-calendar_mobile.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.0/moment.min.js"></script>
  <link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css"> <!-- 달력 표시 css (datepicker) -->
	<script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script> <!--  달력 표시 js (datepicker) -->
	<style>
  input:not([type='checkbox']), textarea, button {
    appearance: none; -moz-appearance: none; -webkit-appearance: none; border-radius: 0; -webkit-border-radius: 0; -moz-border-radius: 0;font-size:16px;
  }
  select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background:url(<?php echo $misc; ?>img/mobile/select_icon.svg) no-repeat 98% 50% #fff;
    font-size: 16px;
    height:20px;
    width:100%;
  }
  .input-common {
    width: 95%;
  }
  .dayBtn, .timeBtn {
    width: 43%;
		height: 30px;
		background-color: white;
  }
	.dayBtn {
		background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
	.timeBtn {
		background:url(<?php echo $misc; ?>img/mobile/icon_time.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
	.btn-user {
		font-size: 14px;
		width:auto;
	}
	html, body {
	  max-width: 100%;
	  height: 100%;
	  min-width: 100%;
		font-family: "Noto Sans KR", sans-serif !important;
		background-color: #F9F9F9;
		line-height: normal;
	}

  .calendar, .schedule {
    width: 95%;
    margin: 0 auto;
  }

  .schedule {
    margin-top: 20px;
  }

  .schedule input {
    margin-right: 10px;
  }

  .line {
    border-bottom: thin solid #DEDEDE;
  }
  .schedule_tbl {
    margin-top: 20px;
    width:100%;
  }
  .sch_date {
    font-size: 20px;
    font-weight: bold;
    height:40px;
  }
  .sch_list {
    font-size: 16px;
    font-weight: bold;
  }
  .sch_time {
    font-size: 14px;
    color:#A1A1A1;
  }
  .mobile-content {
    padding-top: 20px;
    padding-bottom: 60px;
  }

  .modal_contain{
    height:100%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family:"Noto Sans KR", sans-serif;
  }

  .select-common {
    background-color: #fff !important;
  }

	/* Dropdown Button */
	.dropbtn {
	  font-size: 13px;
	  border: none;
	  cursor: pointer;
	  border-radius: 5px;
	  background-color: #eee;
	  margin: 0px 0px 0px 0px;
	  width: 100px;
	  display: inline-block;
	  text-align: center;
	  border: 4px solid #eee;
	}

	/* Dropdown button on hover & focus */
	.dropbtn:hover,
	.dropbtn:focus {
	  /* background-color: #3e8e41; */
	}

	/* The search field */
	.searchInput {
	  box-sizing: border-box;
	  background-position: 14px 12px;
	  background-repeat: no-repeat;
	  font-size: 16px;
	  padding: 14px 20px 12px 45px;
	  border: none;
	  border-bottom: 1px solid #ddd;
	}

	/* The search field when it gets focus/clicked on */
	.searchInput:focus {
	  outline: 3px solid #ddd;
	}

	/* The container <div> - needed to position the dropdown content */
	.dropdown {
	  position: relative;
	  display: inline-block;
	}

	/* Dropdown Content (Hidden by Default) */
	.dropdown-content {
	  display: none;
	  position: absolute;
	  background-color: #f6f6f6;
	  min-width: 230px;
	  border: 1px solid #ddd;
	  z-index: 1;
	}

	/* Links inside the dropdown */
	.dropdown-content a {
	  color: black;
	  padding: 12px 16px;
	  text-decoration: none;
	  display: block;
	}

	/* Change color of dropdown links on hover */
	.dropdown-content a:hover {
	  background-color: #f1f1f1
	}

	/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
	.show {
	  display: block;
	}

	.select_time  {
	  border-collapse:collapse;
	  border-spacing:0;
	  font-size: 20px;
	}
	.select_time td{
	  border-color:#DEDEDE;
	  border-style:solid;
	  border-width:1px;
	  overflow:hidden;
	  word-break:normal;
	  padding: 10px;
	}
	.select_time th{
	  background-color: #F9F9F9;
	  border-color:#DEDEDE;
	  border-style:solid;
	  border-width:1px;
	  font-weight:bold;
	  overflow:hidden;
	  word-break:normal;
	  padding: 10px;
	}

	.td_item{
	  font-size:0;
	}

	.reserved{
	  font-size:0;
	  background: #FFEDED;
	  color: white;
	  /* pointer-events: none; */
	}

	.selected_room{
	  font-size:0;
	  background: #52b1fa;
	  color: white;
	}

	.td_item #selectedroom{
	  /* font-size:0; */
	  background: #52b1fa;
	  color: white;
	}

	#add_conference_btn,#add_car_btn{
    margin:20px 0px  !important;
  }
  .select_time{
    font-size:14px;
    display:flex;
    display: -webkit-box;
    display: -ms-flexbox;
    overflow-x: auto;
    overflow-y: hidden;
  }
  .select_time_th{
    width:100% !important;
  }
  .select_time tbody{
    display:flex
  }
  .select_time th:first-child{
    display:block;
    height:30px !important;
  }
  .select_time th:not(:first-child){
    display:block;
    height:22px !important;
  }
  .select_time td{
    display:block;
  }
  .select_time td:first-child{
    height:30px !important;
  }

  .select_time td:not(:first-child){
    height:0px !important;
  }



  #select_date,#select_car_date{
    width:220px !important;
    float: none !important;
    margin:20px 0px !important;
  }

  #select_table,#select_car_table{
    display:inline-block  !important;
    width:100% !important;
    margin:0px !important;
  }

  #conference_div{
    width:100% !important;
  }

  #car_reservation_div{
    width:100% !important;
  }

  li{
    list-style: none;
  }
  #addpopup, #updateSchedule{
    width:100% !important;
    margin-left: 100px !important;
  }
  #addpopup input:not(#room_name,#car_name,.dayBtn,.timeBtn,.dateBtn,.basicBtn,.add_weekly_report,.btn-common),#addpopup textarea,
  #updateSchedule input:not(#de_room_name,#de_car_name,.dayBtn,.timeBtn,.dateBtn,.basicBtn,.add_weekly_report,.btn-common),#updateSchedule textarea{
    width:70% !important;
  }
  #room_name,#car_name,#de_room_name,#de_car_name{
    width:50% !important;
  }

	#feedback { font-size: 1.4em; }
	#selectable .ui-selecting { background: #80dfff; }
	#selectable .ui-selected { background: #E1F3FF; color: white; }

	#select_car_tbody .ui-selecting { background: #80dfff; }
	#select_car_tbody .ui-selected { background: #E1F3FF; color: white; }

	.input-common, .select-common, .textarea-common, .btn-common {
		border-radius: 3px !important;
	}
	.btn-common {
		text-align:center !important;
	}

	.parentGroup {
		font-size: 17px;
	}
	.userGroup {
		font-size: 16px;
		padding-left: 10px;
	}
	.btn-style3 {
		color:#B0B0B0;
	}
	.btn-user {
		width:95px;margin-right:10px;margin-bottom:10px;border-radius:3px;
		border-width: thin;text-align:center;
		font-size:14px !important;
	}
	.dept2-user {
		padding-left:10px;
	}

	/* 첨부파일 */
  .box-file-input label{
  display:inline-block;
  background:#a9abac;
  color:#fff;
  padding:0px 15px;
  line-height:30px;
  cursor:pointer;
  border-radius: 3px;
 }

 .box-file-input label:after{
  content:"파일 선택";
 }

 .box-file-input .file-input{
  display:none;
 }

 .box-file-input .filename{
  display:inline-block;
  padding-left:10px;
 }

 .btn-file {
   width:50px;
 }
 .btn-file-left {
   float:left;
   border: 1px solid #B6B6B6;
   background: white;
   color: #565656;
 }
 .btn-file-right {
   /* right:0; */
   float:right;
   margin-right: 40px;
 }
 .file_span {
   color: #B6B6B6;
   max-width: 200px;
 }

 .layerpop {
     display: none;
     z-index: 1000;
     border: 2px solid #ccc;
     background: #fff;
     /* cursor: move;  */
     cursor: default;
    }

 .layerpop_area .modal_title {
     padding: 10px 10px 10px 10px;
     border: 0px solid #aaaaaa;
     background: #f1f1f1;
     color: #3eb0ce;
     font-size: 1.3em;
     font-weight: bold;
     line-height: 24px;
    }

 .layerpop_area .layerpop_close {
     width: 25px;
     height: 25px;
     display: block;
     position: absolute;
     top: 10px;
     right: 10px;
     background: transparent url('btn_exit_off.png') no-repeat;
   }

 .layerpop_area .layerpop_close:hover {
     background: transparent url('btn_exit_on.png') no-repeat;
     cursor: pointer;
   }

 .layerpop_area .content {
     width: 96%;
     margin: 2%;
     color: #828282;
   }

	</style>
	<script src='/misc/js/exif.js'></script>
  <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=be899438c615f0b45f7b6f838aa7cef3"></script>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
	  ?>
	<input type="hidden" id="session_name" value= "<?php echo $session_name?>"/>
	<input type="hidden" id="session_id" value= "<?php echo $session_id;?>"/>
  <div class="mobile-content">
    <div class="calendar">
      <div style="width:90%;margin:0 auto;text-align:left;font-weight:bold;font-size:20px;vertical-align:middle;">
        <span id="calendar_month" style="top:0"></span>
        <input type="text" id="month_input" value="<?php if(isset($_GET['month'])){echo $_GET['month'];}else if (isset($_GET['date'])){echo $_GET['date'];}else{echo date('Y-m-d');} ?>" onchange="change_date('main',this.value);" style="visibility:hidden;position:absolute;">
        <img id="btn_down" src="<?php echo $misc; ?>img/mobile/btn_down.svg" style="margin-left:10px;" onclick="$('#month_input').focus();">
        <img src="<?php echo $misc; ?>img/mobile/add_schedule.svg" style="float:right;" onclick="addopen();">
        <img src="<?php echo $misc; ?>img/mobile/participant.svg" style="float:right;margin-right:10px;" onclick="selUserOpen();">
      </div>
      <div id="calendar"></div>
    </div>
    <div class="line"></div>
    <div class="schedule">
      <input type="button" id="today" class="btn-common btn-color2" value="오늘" style="width:70px" onclick="go_sch_page('today');">
      <input type="button" id="month" class="btn-common btn-color1" value="월" style="width:40px" onclick="go_sch_page('month');">
      <input type="button" id="day" class="btn-common btn-color1" value="일" style="width:40px;" onclick="go_sch_page('day');">
      <table id="schedule_tbl" class="schedule_tbl" border="0" cellspacing="10" cellpadding="0">
	<?php if (isset($_GET['month'])) {
				$sch_date = '';
				foreach($schedule_list as $sl) {?>
	<?php if ($sl['start_day'] != $sch_date) {
				if($sl['start_day'] == $sl['end_day']) {
					$sch_date = $sl['start_day'];
				} else {
					$sch_date = $sl['start_day'].' ~ '.$sl['end_day'];
				} ?>
				<tr>
					<td class="sch_date" colspan="2"><?php echo $sch_date; ?></td>
				</tr>
	<?php foreach($schedule_list as $sl2) {
				if ($sl2['start_day'] == $sl2['end_day']) {
					$sch_date2 = $sl2['start_day'];
				} else {
					$sch_date2 = $sl2['start_day'].' ~ '.$sl2['end_day'];
				}
				if ($sch_date == $sch_date2) { ?>
					<?php $participant = explode(',',$sl2['participant']);
					if (count($participant) > 1) {
						$participant = $participant[0].' 외 '.(count($participant)-1).'명';
					} else {
						$participant = $participant[0];
					}
					if($sl2['work_type']=='tech') {
						$title = $sl2['customer'].'/'.$sl2['work_name'].'/'.$sl2['support_method'];
					} else {
						$title = $sl2['work_name'].'/'.$sl2['title'];
					}
					?>
					<tr onclick="sch_modify(this,'modify');" seq="<?php echo $sl2['seq']; ?>">
            <td style="vertical-align:top;padding-top:10px;">
              <img src="<?php echo $misc; ?>img/mobile/schedule_mobile_icon/<?php echo $sl2['work_name']; ?>.svg">
            </td>
            <td class="sch_list">
              <div>
                <?php echo '['.$participant.'] '.$title; ?>
              </div>
              <div class="sch_time">
                <?php echo $sl2['start_time'].' ~ '.$sl2['end_time']; ?>
              </div>
            </td>
          </tr>
	<?php	} ?>
	<?php } ?>
	<?php } ?>
	<?php } ?>

	<?php } else { ?>
        <tr>
          <td class="sch_date" colspan="2"><?php if(isset($_GET['date'])){echo $_GET['date'];}else{echo date("m.d");} ?></td>
        </tr>
        <?php foreach($schedule_list as $sl) { ?>
          <?php $participant = explode(',',$sl['participant']);
          if (count($participant) > 1) {
            $participant = $participant[0].' 외 '.(count($participant)-1).'명';
          } else {
            $participant = $participant[0];
          }
          if($sl['work_type']=='tech') {
            $title = $sl['customer'].'/'.$sl['work_name'].'/'.$sl['support_method'];
          } else {
            $title = $sl['work_name'].'/'.$sl['title'];
          }
          ?>
          <tr onclick="sch_modify(this,'modify');" seq="<?php echo $sl['seq']; ?>">
            <td style="vertical-align:top;padding-top:10px;">
              <img src="<?php echo $misc; ?>img/mobile/schedule_mobile_icon/<?php echo $sl['work_name']; ?>.svg">
            </td>
            <td class="sch_list">
              <div>
                <?php echo '['.$participant.'] '.$title; ?>
              </div>
              <div class="sch_time">
                <?php echo $sl['start_time'].' ~ '.$sl['end_time']; ?>
              </div>
            </td>
          </tr>
        <?php } ?>
			<?php } ?>
      </table>
    </div>
  </div>

	<!-- 참석자 모달 시작 (일정 선택) -->
  <div id="select_user_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:18px; color:#1C1C1C;font-weight:bold;">
      <table style="width:100%;padding:5%;">
				<tr>
					<td>(주)두리안정보기술</td>
				</tr>
				<tr>
					<td height="10"></td>
				</tr>
<?php foreach($user_parents_group as $upg) { ?>
				<tr>
					<td class="parentGroup"><?php echo $upg['parentGroupName']; ?></td>
				</tr>
<?php if(isset($depth1_user[$upg['parentGroupName']])){ ?>
				<tr>
					<td class='user'>
<?php foreach($depth1_user[$upg['parentGroupName']] as $du) { ?>
						<input type="button" seq="<?php echo $du['seq']; ?>" class="btn-common btn-style3 btn-user" value="<?php echo $du['user_name'].' '.mb_substr($du['user_duty'],0,2); ?>" onclick="select_user(this);">
<?php } ?>
					</td>
				</tr>
<?php } ?>
<?php for ($i=0; $i<count($user_group); $i++) { ?>
<?php if($upg['parentGroupName'] == $user_group[$i]['parentGroupName'] && $user_group[$i]['groupName'] != $user_group[$i]['parentGroupName']){ ?>
				<tr>
					<td class="userGroup"><?php echo $user_group[$i]['groupName']; ?></td>
				</tr>
<?php if(isset($depth2_user[$user_group[$i]['groupName']])){ ?>
				<tr>
					<td class='user dept2-user'>
<?php foreach($depth2_user[$user_group[$i]['groupName']] as $du) { ?>
						<input type="button" seq="<?php echo $du['seq']; ?>" class="btn-common btn-style3 btn-user" value="<?php echo $du['user_name'].' '.mb_substr($du['user_duty'],0,2); ?>" onclick="select_user(this);">
<?php } ?>
					</td>
				</tr>
<?php } ?>
<?php } ?>
<?php } ?>
<?php } ?>
				<tr>
					<td align="center">
						<input type="button" class="btn-common btn-color1" value="취소" onclick="$('#select_user_div').bPopup().close();" style="width:130px;">
						<input type="button" class="btn-common btn-color2" value="선택" onclick="selUser_submit();" style="width:130px;">
					</td>
				</tr>
      </table>
    </div>
  </div>
	<!-- 참석자 모달 끝 -->


	<!-- 참석자 모달 시작 (일정 등록) -->
  <div id="select_user_add_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:18px; color:#1C1C1C;font-weight:bold;">
			<input type="hidden" id="participant_mode" value="">
      <table style="width:100%;padding:5%;">
				<tr>
					<td>(주)두리안정보기술</td>
				</tr>
				<tr>
					<td height="10"></td>
				</tr>
<?php foreach($user_parents_group as $upg) { ?>
				<tr>
					<td class="parentGroup"><?php echo $upg['parentGroupName']; ?></td>
				</tr>
<?php if(isset($depth1_user[$upg['parentGroupName']])){ ?>
				<tr>
					<td class='user'>
<?php foreach($depth1_user[$upg['parentGroupName']] as $du) { ?>
						<input type="button" seq="<?php echo $du['seq']; ?>" name="<?php echo $du['user_name']; ?>" class="btn-common btn-style3 btn-user" value="<?php echo $du['user_name'].' '.mb_substr($du['user_duty'],0,2); ?>" onclick="select_user(this);">
<?php } ?>
					</td>
				</tr>
<?php } ?>
<?php for ($i=0; $i<count($user_group); $i++) { ?>
<?php if($upg['parentGroupName'] == $user_group[$i]['parentGroupName'] && $user_group[$i]['groupName'] != $user_group[$i]['parentGroupName']){ ?>
				<tr>
					<td class="userGroup"><?php echo $user_group[$i]['groupName']; ?></td>
				</tr>
<?php if(isset($depth2_user[$user_group[$i]['groupName']])){ ?>
				<tr>
					<td class='user dept2-user'>
<?php foreach($depth2_user[$user_group[$i]['groupName']] as $du) { ?>
						<input type="button" seq="<?php echo $du['seq']; ?>" name="<?php echo $du['user_name']; ?>" class="btn-common btn-style3 btn-user" value="<?php echo $du['user_name'].' '.mb_substr($du['user_duty'],0,2); ?>" onclick="select_user(this);">
<?php } ?>
					</td>
				</tr>
<?php } ?>
<?php } ?>
<?php } ?>
<?php } ?>
				<tr>
					<td align="center">
						<input type="button" class="btn-common btn-color1" value="취소" onclick="$('#select_user_add_div').bPopup().close();" style="width:130px;">
						<input type="button" class="btn-common btn-color2" value="선택" onclick="add_participant('select_user_add_div');" style="width:130px;">
					</td>
				</tr>
      </table>
    </div>
  </div>
	<!-- 참석자 모달 끝 -->



	<!-- 일정등록 모달 시작 -->
  <div id="add_sch_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <form name="cform" id="cform" action="<?php echo site_url();?>/biz/schedule/add_schedule" method="post">
      <div class="modal_contain" style="font-size:18px; color:#1C1C1C;font-weight:bold;">
        <table style="width:100%;padding:5%;" cellspacing="0">
          <input type="hidden" name="customer_manager" id="customer_manager" class="input2">
          <input type="hidden" id="forcasting_seq" name="forcasting_seq" value="" />
          <input type="hidden" id="maintain_seq" name="maintain_seq" value="" />
          <input type="hidden" id="work_type" name="work_type" value="" />
          <input type="hidden" id="tech_report" name="tech_report" value="" />
        	<tr class="basic_tr">
        		<td align="left" colspan="2" height="40">구분</td>
        	</tr>
          <tr class="basic_tr">
            <td colspan="2">
              <select name="workname" id="workname" class="select-common" onchange="change_workname(this.value, '');">
                <option value="">선택하세요.</option>
                <?php
                if ($this->group == '기술연구소') {
                  echo "<option value='기술연구소'>기술연구소</option>";
                }
                foreach ($work_name as $val) {
                  echo "<option value='{$val->work_name}' >{$val->work_name}</option>";
                }
                ?>
              </select>
            </td>
          </tr>
          <tr class="normal_tr tech_tr">
            <td height="10"></td>
          </tr>
        	<tr class="normal_tr tech_tr">
        		<td align="left" colspan="2" height="40">지원방법</td>
        	</tr>
          <tr class="normal_tr tech_tr">
            <td colspan="2">
              <select name="supportMethod" id="supportMethod" class="select-common" name="" value="">
                <option value="" selected disabled hidden>선택하세요</option>
                <option value="현장지원">현장지원</option>
                <option value="원격지원">원격지원</option>
              </select>
            </td>
          </tr>
          <tr class="basic_tr2 except_nondisclosure_div">
            <td height="10"></td>
          </tr>
        	<tr class="basic_tr2 except_nondisclosure_div">
        		<td align="left" colspan="2" height="40">회의실예약</td>
        	</tr>
          <tr class="basic_tr2 except_nondisclosure_div">
            <td colspan="2">
              <input class="input-common" onclick="open_conference('insert');" type="text" id="room_name" name="room_name" value="" style="width:85%" readonly>
              <img src="<?php echo $misc; ?>/img/x-box.svg" style="width:20px;margin-left:5px;vertical-align:middle;" onclick="$('#room_name').val('');">
            </td>
          </tr>
          <tr class="basic_tr2 except_nondisclosure_div">
            <td height="10"></td>
          </tr>
        	<tr class="basic_tr2 except_nondisclosure_div">
        		<td align="left" colspan="2" height="40">차량예약</td>
        	</tr>
          <tr class="basic_tr2 except_nondisclosure_div">
            <td colspan="2">
              <input class="input-common" onclick="open_car_reservation('insert');" type="text" id="car_name" name="car_name" value="" style="width:85%" readonly>
              <img src="<?php echo $misc; ?>/img/x-box.svg" style="width:20px;margin-left:5px;vertical-align:middle;" onclick="$('#car_name').val('');">
            </td>
          </tr>
          <tr class="basic_tr2">
            <td height="10"></td>
          </tr>
          <tr class="basic_tr2">
            <td align="left" colspan="2" height="40">시작일자</td>
          </tr>
          <tr class="basic_tr2">
            <td colspan="2">
              <input class="input-common dayBtn" type="date" name="startDay" id="startDay" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" onchange="conference_room_del('insert'); date_compare('');recurring_form('', this.value);" style="vertical-align:middle;margin-right:1%;">
              <input class="input-common timeBtn" type="time" name="startTime" id="startTime" value="" autocomplete="off" style="vertical-align:middle;">
            </td>
          </tr>
          <tr class="basic_tr2">
            <td height="10"></td>
          </tr>
          <tr class="basic_tr2">
            <td align="left" colspan="2" height="40">종료일자</td>
          </tr>
          <tr class="basic_tr2">
            <td colspan="2">
              <input class="input-common dayBtn" type="date" name="endDay" id="endDay" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" onchange="conference_room_del('insert'); date_compare('');" style="vertical-align:middle;margin-right:1%;">
              <input class="input-common timeBtn" type="time" name="endTime" id="endTime" value="" autocomplete="off" style="vertical-align:middle;">
            </td>
          </tr>
          <tr class="basic_tr2">
            <td height="10"></td>
          </tr>
          <tr class="basic_tr2">
            <td align="left" colspan="2" height="40">반복일정
              <input type="checkbox" name="recurring_check" id="recurring_check" value="" onchange="change_recurring_check('');">
            </td>
          </tr>
          <tr class="recurring_div">
            <td colspan="2">
              <select class="select-common" name="recurring_select" id="recurring_select">
                <option value="" num = "1" id="recurring_day"></option>
                <option value="" num = "2" id="recurring_week"></option>
                <option value="" num = "3" id="recurring_month_day"></option>
                <option value="" num = "4" id="recurring_month"></option>
              </select>
            </td>
          </tr>
          <tr class="recurring_div">
            <td colspan="2">
              <select class="select-common" name="recurring_select_ex" id="recurring_select_ex" onchange="change_recurring_select_ex('');" style="width:100%;">
                <option value="recurring_endDay" num = "1" id="recurring_endDay_opt">종료일자</option>
                <option value="recurring_count" num = "2" id="recurring_count_opt">반복횟수</option>
              </select>
            </td>
          </tr>
          <tr class="recurring_div">
            <td colspan="2">
              <input type="date" name="recurring_endDay" id="recurring_endDay" class="dayBtn input_ex input-common" value="<?php echo date('Y-12-31'); ?>" autocomplete="off" onchange="conference_room_del('insert'); date_compare('');">
            </td>
          </tr>
          <tr class="recurring_div">
            <td colspan="2">
              <input type="number" name="recurring_count" id="recurring_count" class="input_ex input-common" value="" placeholder="숫자로 입력">
            </td>
          </tr>

          <tr class="normal_tr notice_tr general_tr">
            <td height="10"></td>
          </tr>
          <tr class="normal_tr notice_tr general_tr">
            <td align="left" colspan="2" height="40">제목</td>
          </tr>
          <tr class="normal_tr notice_tr general_tr">
            <td colspan="2">
              <input class="input-common" type="text" name="title" id="title" value="">
            </td>
          </tr>
          <tr class="normal_tr notice_tr general_tr">
            <td height="10"></td>
          </tr>
          <tr class="normal_tr notice_tr general_tr">
            <td align="left" colspan="2" height="40">장소</td>
          </tr>
          <tr class="normal_tr notice_tr general_tr">
            <td colspan="2">
              <input class="input-common" type="text" name="place" id="place" value="">
            </td>
          </tr>
          <tr class="normal_tr customer_tr general_tr">
            <td height="10"></td>
          </tr>
          <tr class="normal_tr customer_tr general_tr">
            <td align="left" colspan="2" height="40">고객사</td>
          </tr>
          <tr class="normal_tr customer_tr general_tr">
            <td colspan="2">
              <div class="dropdown tech_div" id="dropdown">
                <p onclick="searchFunction(this.id)" id="dropbtn" class="dropbtn">검색</p>
                <input id="customerName" name ="customerName" type="text" class="customerName" value="" style="border:none;width:200px;font-weight:bold;text-align:center;">
                <input type="hidden" id="customer" name="customer" value="" style="border:none" readonly>
                <div id="myDropdown" class="dropdown-content">
                  <input type="text" name="0" placeholder="고객사를 입력하세요" id="searchInput" class="searchInput" onkeyup="filterFunction(this)" autocomplete="off">
                  <div id="dropdown_option" style="overflow:scroll; width:277px; height:300px;">
                  </div>
                </div>
              </div>
              <div class="general_div except_company_div">
                <input class="input-common" type="text" id="customerName2" name="customerName2" value="">
              </div>
            </td>
          </tr>
          <tr class="normal_tr sales_tr">
            <td height="10"></td>
          </tr>
          <tr class="normal_tr sales_tr">
            <td align="left" colspan="2" height="40">방문업체</td>
          </tr>
          <tr class="normal_tr sales_tr">
            <td colspan="2">
              <input class="input-common" type="text" id="visitCompany" name="visitCompany" value="">
            </td>
          </tr>
          <tr class="normal_tr tech_tr">
            <td height="10"></td>
          </tr>
          <tr class="normal_tr tech_tr">
            <td align="left" colspan="2" height="40">프로젝트</td>
          </tr>
          <tr class="normal_tr tech_tr">
            <td colspan="2">
              <input class="input-common" type="text" id="project" name="project" value="">
            </td>
          </tr>
          <tr class="normal_tr tech_tr general_tr">
            <td height="10"></td>
          </tr>
          <tr class="normal_tr tech_tr general_tr">
            <td align="left" colspan="2" height="40">참석자</td>
          </tr>
          <tr class="normal_tr tech_tr general_tr">
            <td colspan="2">
              <li>
                <div class="" style="padding:5px 0;">
                  <input class="input-common" type="text" name="participant_input" id="participant_input" value="" placeholder="" onkeypress="keypress(event,this.value,'participant')" autocomplete="off" style="width:80%;" disabled>
                  <input type="hidden" name="participant" id="participant" value="" placeholder="">
                  <img src="<?php echo $misc; ?>/img/participant_add.svg" id="addUserBtn" class="btn" style="width:25px;margin-left:5px;vertical-align:middle;" onclick="addUser_Btn('add');return false;">
                  <!-- <input type="image" src="<?php echo $misc; ?>/img/participant_add.jpg" id="addUserBtn" class="btn" style="width:25px; height:25px; vertical-align:middle;" onclick="addUser_Btn();return false;"> -->
                </div>
              </li>
              <li style="margin-top:5px;margin-bottom:5px;">
                <div id="participant_box" name="participant_box">
                </div>
              </li>
            </td>
          </tr>

          <tr class="normal_tr tech_tr notice_tr general_tr">
            <td height="10"></td>
          </tr>
          <tr class="normal_tr tech_tr notice_tr general_tr">
            <td align="left" colspan="2" height="40">내용</td>
          </tr>
          <tr class="normal_tr general_tr explanation_div">
            <td colspan="2">
              <div class="" style="float:left; width:50%; text-align:left;">
                <span style="font-size:10px; font-weight:bold;">주간업무</span>
              </div>
              <div class="" style="display:inline-block; width:50%; text-align:right;">
                <span style="font-size:10px; font-weight:bold;">추가/삭제</span>
              </div>
            </td>
          </tr>
          <tr id="contents_tr_0" class="normal_tr tech_tr notice_tr general_tr">
            <td colspan="2" align="center">
              <input type="checkbox" class="add_weekly_report" id="add_weekly_report_0" name="add_weekly_report" value="" style="vertical-align:middle;width:10%;float:left" onclick="nondisclosure_weekly_report('nondisclosure')">
              <textarea class="textarea-common" rows="2" name='contents' id="contents_0" placeholder="상세내용" style="resize:none; vertical-align:middle; width:75%;float:left;margin-top:10px;margin-bottom:10px;" maxlength="300"></textarea>
              <input type="hidden" name="contents_num" id="contents_num_0" value="0">
              <img src="<?php echo $misc; ?>img/btn_add.jpg" id="contents_add" name="contents_add" onclick="contents_add_action('contents');return false;" style="cursor:pointer;vertical-align:middle;float:right" />
            </td>
          </tr>

          <tr class="normal_tr lab_tr">
            <td height="10"></td>
          </tr>
          <tr class="normal_tr lab_tr">
            <td align="left" colspan="2" height="40">개발구분</td>
          </tr>
          <tr class="normal_tr lab_tr">
            <td colspan="2">
              <select class="select-common" id="dev_type" name="dev_type">
                <option value="" selected disabled hidden>선택하세요</option>
                <option value="신규개발">신규개발</option>
                <option value="기능개선">기능개선</option>
                <option value="버그수정">버그수정</option>
              </select>
            </td>
          </tr>
          <tr class="normal_tr lab_tr">
            <td height="10"></td>
          </tr>
          <tr class="normal_tr lab_tr">
            <td align="left" colspan="2" height="40">페이지</td>
          </tr>
          <tr class="normal_tr lab_tr">
            <td colspan="2">
              <input class="input-common" type="text" id="dev_page" name="dev_page" value="">
            </td>
          </tr>
          <tr class="normal_tr lab_tr">
            <td height="10"></td>
          </tr>
          <tr class="normal_tr lab_tr">
            <td align="left" colspan="2" height="40">요청자</td>
          </tr>
          <tr class="normal_tr lab_tr">
            <td colspan="2">
              <input class="input-common" type="text" id="dev_requester" name="dev_requester" value="">
            </td>
          </tr>
          <tr class="normal_tr lab_tr">
            <td height="10"></td>
          </tr>
          <tr class="normal_tr lab_tr">
            <td align="left" colspan="2" height="40">개발사항</td>
          </tr>
          <tr class="normal_tr lab_tr">
            <td colspan="2">
              <textarea class="textarea-common" id="dev_develop" name="dev_develop" rows="5" cols="52" style="resize:none; vertical-align:middle;width:95%;float:left;"></textarea>
            </td>
          </tr>
          <tr class="normal_tr lab_tr">
            <td height="10"></td>
          </tr>
          <tr class="normal_tr lab_tr">
            <td align="left" colspan="2" height="40">완료여부</td>
          </tr>
          <tr class="normal_tr lab_tr">
            <td colspan="2">
              <input type="checkbox" id="dev_complete" name="dev_complete" value="">
            </td>
          </tr>


          <tr class="normal_tr general_tr">
            <td height="10"></td>
          </tr>
          <tr class="normal_tr general_tr">
            <td align="left" colspan="2" height="40">비공개</td>
          </tr>
          <tr class="normal_tr general_tr">
            <td colspan="2">
              <input type="checkbox" id="nondisclosure_sch" name="nondisclosure_sch" value="" onclick="nondisclosure_form('nondisclosure')">
            </td>
          </tr>




          <tr class="basic_tr">
            <td height="10"></td>
          </tr>
  				<tr class="basic_tr">
  					<td align="center">
              <input type="button" class="btn-common btn-color1" value="취소" style="width:90%;height:40px;" onclick="$('#add_sch_div').bPopup().close();">
            </td>
  					<td align="center">
              <input type="button" class="btn-common btn-color2" value="등록" style="width:90%;height:40px;" onclick="sch_insert('');">
            </td>
  				</tr>
        </table>
      </div>
    </form>
  </div>
	<!-- 일정등록 모달 끝 -->

	<!-- 일정수정 모달 시작 -->
  <div id="de_sch_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:18px; color:#1C1C1C;font-weight:bold;">
      <table style="width:100%;padding:5%;" cellspacing="0">
				<input type="hidden" name="de_seq" id="de_seq" value="">
				<input type="hidden" id ="de_work_type" name="de_work_type" value="">
				<input type="hidden" id="de_mode" name="de_mode" value="">
				<input type="hidden" id="de_link" name="de_link" value="">
				<input type="hidden" name="de_customer_manager" id="de_customer_manager" class="input2" value="">
				<input type="hidden" id="de_forcasting_seq" name="de_forcasting_seq" value="" />
				<input type="hidden" id="de_maintain_seq" name="de_maintain_seq" value="" />
      	<tr class="basic_tr">
      		<td align="left" colspan="2" height="40">구분</td>
      	</tr>
        <tr class="basic_tr">
          <td colspan="2">
            <select name="de_workname" id="de_workname" class="select-common" onchange="change_workname(this.value, 'de_');">
              <option value="">선택하세요.</option>
              <?php
              if ($this->group == '기술연구소') {
                echo "<option value='기술연구소'>기술연구소</option>";
              }
              foreach ($work_name as $val) {
                echo "<option value='{$val->work_name}' >{$val->work_name}</option>";
              }
              ?>
            </select>
          </td>
        </tr>
        <tr class="normal_tr tech_tr">
          <td height="10"></td>
        </tr>
      	<tr class="normal_tr tech_tr">
      		<td align="left" colspan="2" height="40">지원방법</td>
      	</tr>
        <tr class="normal_tr tech_tr">
          <td colspan="2">
            <select name="de_supportMethod" id="de_supportMethod" class="select-common" name="">
              <option value="" selected disabled hidden>선택하세요</option>
              <option value="현장지원">현장지원</option>
              <option value="원격지원">원격지원</option>
            </select>
          </td>
        </tr>
        <tr class="basic_tr2 de_except_nondisclosure_div">
          <td height="10"></td>
        </tr>
      	<tr class="basic_tr2 de_except_nondisclosure_div">
      		<td align="left" colspan="2" height="40">회의실예약</td>
      	</tr>
        <tr class="basic_tr2 de_except_nondisclosure_div">
          <td colspan="2">
            <input class="input-common" onclick="open_conference('detail');" type="text" id="de_room_name" name="de_room_name" value="" style="width:85%" readonly>
            <img src="<?php echo $misc; ?>/img/x-box.svg" style="width:20px;margin-left:5px;vertical-align:middle;" onclick="$('#de_room_name').val('');">
          </td>
        </tr>
        <tr class="basic_tr2 de_except_nondisclosure_div">
          <td height="10"></td>
        </tr>
      	<tr class="basic_tr2 de_except_nondisclosure_div">
      		<td align="left" colspan="2" height="40">차량예약</td>
      	</tr>
        <tr class="basic_tr2 de_except_nondisclosure_div">
          <td colspan="2">
            <input class="input-common" onclick="open_car_reservation('detail');" type="text" id="de_car_name" name="de_car_name" value="" style="width:85%" readonly>
            <img src="<?php echo $misc; ?>/img/x-box.svg" style="width:20px;margin-left:5px;vertical-align:middle;" onclick="$('#de_car_name').val('');">
          </td>
        </tr>

				<form id="img_file_form" method="post" enctype="multipart/form-data">
	        <tr class="basic_tr2">
	          <td height="10"></td>
	        </tr>
	        <tr class="basic_tr2">
	          <td align="left" colspan="2" height="40">시작일자</td>
	        </tr>
	        <tr class="basic_tr2">
	          <td colspan="2">
	            <input class="input-common dayBtn" type="date" name="de_startDay" id="de_startDay" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" onchange="conference_room_del('update'); date_compare('de_');" style="vertical-align:middle;margin-right:1%;">
	            <input class="input-common timeBtn" type="time" name="de_startTime" id="de_startTime" value="" autocomplete="off" style="vertical-align:middle;">
	          </td>
	        </tr>
	        <tr class="basic_tr2 img_tr">
	          <td height="10"></td>
					<tr class="img_tr">
						<td align="left" colspan="2" height="40">사진</td>
					</tr>
					<tr class="img_tr">
						<td align="left" colspan="2">
							<div style="margin-top:5px;">
								<input class="input-common" type="text" name="de_s_reason" id="de_start_reason" value="" style="width:88%;" placeholder="첨부할 사진이 없을 경우에 사유를 입력해주세요.">
							</div>
							<div style="margin-top:5px;margin-bottom:5px;">
								<div class="box-file-input s_file_input_box">
									<label>
											<input type="file" name="de_start_img" class="file-input" accept="image/*" id="de_start_img" onchange="timeImgChk('start');">
									</label>
									<span class="de_start_img file_span">파일을 선택해주세요
								</div>
								<div class="s_file_view_box">
									<input id="s_img_del" type="button" class="btn-common btn-file btn-file-left" value="삭제">
									<span class="s_file_img file_span" style="float:left;margin-left:10px;text-overflow:ellipsis;"></span>
									<input id="s_img_detail" type="button" class="btn-common btn-style1 btn-file btn-file-right" value="보기">
								</div>
						</td>
					</tr>
	        <tr class="basic_tr2">
	          <td height="10"></td>
	        </tr>
	        <tr class="basic_tr2">
	          <td align="left" colspan="2" height="40">종료일자</td>
	        </tr>
	        <tr class="basic_tr2">
	          <td colspan="2">
	            <input class="input-common dayBtn" type="date" name="de_endDay" id="de_endDay" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" onchange="conference_room_del('update'); date_compare('de_');" style="vertical-align:middle;margin-right:1%;">
	            <input class="input-common timeBtn" type="time" name="de_endTime" id="de_endTime" value="" autocomplete="off" style="vertical-align:middle;">
	          </td>
	        </tr>
					<tr class="basic_tr2 img_tr">
	          <td height="10"></td>
					<tr class="img_tr">
						<td align="left" colspan="2" height="40">사진</td>
					</tr>
					<tr class="img_tr">
						<td align="left" colspan="2">
							<div style="margin-top:5px;">
								<input class="input-common" type="text" name="de_e_reason" id="de_end_reason" value="" style="width:88%;" placeholder="첨부할 사진이 없을 경우에 사유를 입력해주세요.">
							</div>
							<div style="margin-top:5px;margin-bottom:5px;">
								<div class="box-file-input e_file_input_box">
									<label>
											<input type="file" name="de_end_img" class="file-input" accept="image/*" id="de_end_img" onchange="timeImgChk('end');">
									</label>
									<span class="de_end_img file_span">파일을 선택해주세요
								</div>
								<div class="e_file_view_box">
									<input id="e_img_del" type="button" class="btn-common btn-file btn-file-left" value="삭제">
									<span class="e_file_img file_span" style="float:left;margin-left:10px;"></span>
									<input id="e_img_detail" type="button" class="btn-common btn-style1 btn-file btn-file-right" value="보기">
								</div>
						</td>
					</tr>
				</form>

        <tr class="basic_tr2">
          <td height="10"></td>
        </tr>
        <tr class="basic_tr2">
          <td align="left" colspan="2" height="40">반복일정
            <input type="checkbox" name="de_recurring_check" id="de_recurring_check" value="" onchange="change_recurring_check('de_');">
          </td>
        </tr>
        <tr class="recurring_div">
          <td colspan="2">
            <select class="select-common" name="de_recurring_select" id="de_recurring_select">
              <option value="" num = "1" id="recurring_day"></option>
              <option value="" num = "2" id="recurring_week"></option>
              <option value="" num = "3" id="recurring_month_day"></option>
              <option value="" num = "4" id="recurring_month"></option>
            </select>
          </td>
        </tr>
        <tr class="recurring_div">
          <td colspan="2">
            <select class="select-common" name="de_recurring_select_ex" id="de_recurring_select_ex" onchange="change_recurring_select_ex('de_');" style="width:100%;">
              <option value="de_recurring_endDay" num = "1" id="recurring_endDay_opt">종료일자</option>
              <option value="de_recurring_count" num = "2" id="recurring_count_opt">반복횟수</option>
            </select>
          </td>
        </tr>
        <tr class="recurring_div">
          <td colspan="2">
            <input type="date" name="de_recurring_endDay" id="de_recurring_endDay" class="dayBtn input_ex input-common" value="<?php echo date('Y-12-31'); ?>" autocomplete="off" onchange="conference_room_del('update'); date_compare('de_');">
          </td>
        </tr>
        <tr class="recurring_div">
          <td colspan="2">
            <input type="number" name="de_recurring_count" id="de_recurring_count" class="input_ex input-common" value="" placeholder="숫자로 입력">
          </td>
        </tr>

        <tr class="normal_tr notice_tr general_tr">
          <td height="10"></td>
        </tr>
        <tr class="normal_tr notice_tr general_tr">
          <td align="left" colspan="2" height="40">제목</td>
        </tr>
        <tr class="normal_tr notice_tr general_tr">
          <td colspan="2">
            <input class="input-common" type="text" name="de_title" id="de_title" value="">
          </td>
        </tr>
        <tr class="normal_tr notice_tr general_tr">
          <td height="10"></td>
        </tr>
        <tr class="normal_tr notice_tr general_tr">
          <td align="left" colspan="2" height="40">장소</td>
        </tr>
        <tr class="normal_tr notice_tr general_tr">
          <td colspan="2">
            <input class="input-common" type="text" name="de_place" id="de_place" value="">
          </td>
        </tr>
        <tr class="normal_tr tech_tr general_tr">
          <td height="10"></td>
        </tr>
        <tr class="normal_tr tech_tr general_tr">
          <td align="left" colspan="2" height="40">고객사</td>
        </tr>
        <tr class="normal_tr tech_tr general_tr">
          <td colspan="2">
            <div class="dropdown tech_div" id="de_dropdown">
              <p onclick="searchFunction(this.id)" id="de_dropbtn" class="dropbtn">검색</p>
              <input id="de_customerName" name ="de_customerName" type="text" class="customerName" value="" style="border:none;width:200px;font-weight:bold;text-align:center;">
              <input type="hidden" id="de_customer" name="de_customer" value="" style="border:none" readonly>
              <div id="de_myDropdown" class="dropdown-content">
                <input type="text" name="0" placeholder="고객사를 입력하세요" id="de_searchInput" class="searchInput" onkeyup="filterFunction(this)" autocomplete="off">
                <div id="de_dropdown_option" style="overflow:scroll; width:277px; height:300px;">
                </div>
              </div>
            </div>
            <div class="general_div except_company_div">
              <input class="input-common" type="text" id="de_customerName2" name="de_customerName2" value="" style="width:80%;display:none;">
            </div>
          </td>
        </tr>
        <tr class="normal_tr sales_tr">
          <td height="10"></td>
        </tr>
        <tr class="normal_tr sales_tr">
          <td align="left" colspan="2" height="40">방문업체</td>
        </tr>
        <tr class="normal_tr sales_tr">
          <td colspan="2">
            <input class="input-common" type="text" id="de_visitCompany" name="de_visitCompany" value="" style="width:100%;">
          </td>
        </tr>
        <tr class="normal_tr tech_tr">
          <td height="10"></td>
        </tr>
        <tr class="normal_tr tech_tr">
          <td align="left" colspan="2" height="40">프로젝트</td>
        </tr>
        <tr class="normal_tr tech_tr">
          <td colspan="2">
            <input class="input-common" type="text" id="de_project" name="de_project" value="" style="width:100%;">
          </td>
        </tr>
        <tr class="normal_tr tech_tr general_tr">
          <td height="10"></td>
        </tr>
        <tr class="normal_tr tech_tr general_tr">
          <td align="left" colspan="2" height="40">참석자</td>
        </tr>
        <tr class="normal_tr tech_tr general_tr">
          <td colspan="2">
            <li>
              <div class="" style="padding:5px 0;">
                <input class="input-common" type="text" name="de_participant_input" id="de_participant_input" value="" placeholder="" onkeypress="keypress(event,this.value,'de_participant')" autocomplete="off" style="width:80%;" disabled>
                <input type="hidden" name="de_participant" id="de_participant" value="" placeholder="">
                <img src="<?php echo $misc; ?>/img/participant_add.svg" id="de_addUserBtn" class="btn" style="width:25px;margin-left:5px;vertical-align:middle;" onclick="addUser_Btn('update');return false;">
                <!-- <input type="image" src="<?php echo $misc; ?>/img/participant_add.jpg" id="addUserBtn" class="btn" style="width:25px; height:25px; vertical-align:middle;" onclick="addUser_Btn();return false;"> -->
              </div>
            </li>
            <li style="margin-top:5px;margin-bottom:5px;">
              <div id="participant_box" name="participant_box">
              </div>
            </li>
          </td>
        </tr>

        <tr class="normal_tr tech_tr notice_tr general_tr">
          <td height="10"></td>
        </tr>
        <tr class="normal_tr tech_tr notice_tr general_tr">
          <td align="left" colspan="2" height="40">내용</td>
        </tr>
        <tr class="normal_tr general_tr explanation_div">
          <td colspan="2">
            <div class="" style="float:left; width:50%; text-align:left;">
              <span style="font-size:10px; font-weight:bold;">주간업무</span>
            </div>
            <div class="" style="display:inline-block; width:50%; text-align:right;">
              <span style="font-size:10px; font-weight:bold;">추가/삭제</span>
            </div>
          </td>
        </tr>
        <tr id="de_contents_tr_0" class="normal_tr tech_tr notice_tr general_tr">
          <td colspan="2" align="center">
            <input type="checkbox" class="add_weekly_report" id="de_add_weekly_report_0" name="de_add_weekly_report" value="" style="vertical-align:middle;width:10%;float:left" onclick="nondisclosure_weekly_report('de_nondisclosure')">
            <textarea class="textarea-common" rows="2" name='de_contents' id="de_contents_0" placeholder="상세내용" style="resize:none; vertical-align:middle; width:75%;float:left;margin-top:10px;margin-bottom:10px;" maxlength="300"></textarea>
            <input type="hidden" name="de_contents_num" id="de_contents_num_0" value="0">
            <img src="<?php echo $misc; ?>img/btn_add.jpg" id="de_contents_add" name="de_contents_add" onclick="contents_add_action('de_contents');return false;" style="cursor:pointer;vertical-align:middle;float:right" />
          </td>
        </tr>

        <tr class="normal_tr lab_tr">
          <td height="10"></td>
        </tr>
        <tr class="normal_tr lab_tr">
          <td align="left" colspan="2" height="40">개발구분</td>
        </tr>
        <tr class="normal_tr lab_tr">
          <td colspan="2">
            <select class="select-common" id="de_dev_type" name="de_dev_type">
              <option value="" selected disabled hidden>선택하세요</option>
              <option value="신규개발">신규개발</option>
              <option value="기능개선">기능개선</option>
              <option value="버그수정">버그수정</option>
            </select>
          </td>
        </tr>
        <tr class="normal_tr lab_tr">
          <td height="10"></td>
        </tr>
        <tr class="normal_tr lab_tr">
          <td align="left" colspan="2" height="40">페이지</td>
        </tr>
        <tr class="normal_tr lab_tr">
          <td colspan="2">
            <input class="input-common" type="text" id="de_dev_page" name="de_dev_page" value="">
          </td>
        </tr>
        <tr class="normal_tr lab_tr">
          <td height="10"></td>
        </tr>
        <tr class="normal_tr lab_tr">
          <td align="left" colspan="2" height="40">요청자</td>
        </tr>
        <tr class="normal_tr lab_tr">
          <td colspan="2">
            <input class="input-common" type="text" id="de_dev_requester" name="de_dev_requester" value="">
          </td>
        </tr>
        <tr class="normal_tr lab_tr">
          <td height="10"></td>
        </tr>
        <tr class="normal_tr lab_tr">
          <td align="left" colspan="2" height="40">개발사항</td>
        </tr>
        <tr class="normal_tr lab_tr">
          <td colspan="2">
            <textarea class="textarea-common" id="de_dev_develop" name="de_dev_develop" rows="5" cols="52" style="resize:none; vertical-align:middle;width:95%;float:left;"></textarea>
          </td>
        </tr>
        <tr class="normal_tr lab_tr">
          <td height="10"></td>
        </tr>
        <tr class="normal_tr lab_tr">
          <td align="left" colspan="2" height="40">완료여부</td>
        </tr>
        <tr class="normal_tr lab_tr">
          <td colspan="2">
            <input type="checkbox" id="de_dev_complete" name="de_dev_complete" value="">
          </td>
        </tr>


        <tr class="normal_tr general_tr">
          <td height="10"></td>
        </tr>
        <tr class="normal_tr general_tr">
          <td align="left" colspan="2" height="40">비공개</td>
        </tr>
        <tr class="normal_tr general_tr">
          <td colspan="2">
            <input type="checkbox" id="de_nondisclosure_sch" name="de_nondisclosure_sch" value="" onclick="nondisclosure_form('de_nondisclosure')">
          </td>
        </tr>




        <tr class="report_tr">
          <td height="10"></td>
        </tr>
				<tr class="report_tr">
					<td>
						<input type="button" id="techReportInsert" class="btn-common btn-color2" value="기술지원보고서 작성" style="float:right;width:150px;" onclick="modify('report')" style="display:none;">
						<input type="button" id="techReportModify" class="btn-common btn-color2" value="기술지원보고서 수정" style="float:right;width:150px;" onclick="modify('modify')" style="display:none;">
					</td>
				</tr>
				<tr class="basic_tr">
					<td align="right">
            <input type="button" class="btn-common btn-color1" id="btn_cancel" value="취소" style="width:50px;height:40px;margin-right:10px;" onclick="$('#de_sch_div').bPopup().close();">
						<input type="button" id="delSubmit" class="btn-common btn-color1" value="삭제" style="width:50px;height:40px;margin-right:10px;" onclick="modify('schedule_delete');">
						<input type="button" id="updateSubmit" class="btn-common btn-color1" value="수정" style="width:50px;height:40px;" onclick="modify('schedule_modify');">
          </td>
				</tr>
      </table>
    </div>
  </div>
	<!-- 일정수정 모달 끝 -->


	<!-- 회의실 예약 시작 -->
	<div id="conference_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
		<div style="text-align: center; font-size:20px; font-weight:bold;">회의실예약</div>
		<div class="date_div" style="margin-top:20px;margin-bottom:30px;margin-left:30px;">
			<span id="room_date" style="top:0;font-weight:bold;font-size:20px;"></span>
			<input type="text" id="select_date" value="<?php echo date('Y-m-d'); ?>" onchange="change_date('room',this.value);" style="visibility:hidden;position:absolute;">
			<img id="btn_down" src="<?php echo $misc; ?>img/mobile/btn_down.svg" style="margin-left:10px;" onclick="$('#select_date').focus();">
		</div>
	    <input type="hidden" id="select_room_day" name="select_room_day" value="">
	    <input type="hidden" id ="selected_room_name" name="selected_room_name" value="">
	    <div style="margin-left:30px;">
	      <table class="select_time" style="width:98%;" border="0" cellspacing="0" cellpadding="0">
	      <!-- <table class="select_time"> -->
	        <thead class="select_time_th">
	        <tr>
	          <th style="background-color:#F4F4F4">회의실명</th>
	          <th colspan="2">08</th>
	          <th colspan="2">09</th>
	          <th colspan="2">10</th>
	          <th colspan="2">11</th>
	          <th colspan="2">12</th>
	          <th colspan="2">13</th>
	          <th colspan="2">14</th>
	          <th colspan="2">15</th>
	          <th colspan="2">16</th>
	          <th colspan="2">17</th>
	          <th colspan="2">18</th>
	          <th colspan="2">19</th>
	          <th colspan="2">20</th>
	          <th colspan="2">21</th>
	        </tr>
	        </thead>
	        <tbody class="select_time_tb" id="selectable">
	          <?php
	            function plus_time($start){
	              $last = strtotime('22:00');
	              if($start < $last){
	                $start_time = date("H:i", $start);
	                $end = strtotime('+30 minutes', $start);
	                $end_time = date("H:i", $end);
	                $id_time = (int)str_replace(':','',$start_time);
	                echo "<td class = 'td_item' style='cursor:pointer;' id='{$id_time}' onmouseover='tooltip(this);' onmouseout='tooltip_remove(this);'>{$start_time}{$end_time}<div class='tooltip-content'></div></td>";
	                plus_time($end);
	              }
	            }
	                   foreach ($rooms as $room) {

	                     echo "<tr id='{$room->room_name}'>";
	                     $start = strtotime('08:00');
	                     echo "<td class='dragable' id='room_name_td' style='cursor:s-resize;font-weight:bold;background-color:#F4F4F4'>{$room->room_name}</td>";
	                     plus_time($start);
	                     echo "</tr>";

	                   }
	           ?>

	        </tbody>
	      </table>
	    </div>
	    <div align="center">
	      <p id="feedback" style="display:none;">
	        <span>You&apos;ve selected:</span> <span id="select_room_result">none</span>
	        <!-- <span id="select_room_name">/</span> -->
	      </p>
				<input type="button" class="btn-common btn-color1" value="취소" style="margin-right:10px;" onclick="$('#conference_div').bPopup().close();">
	      <button type="button" id="add_conference_btn" name="add_conference_btn" onclick="add_conference(this.name);" class="btn-common btn-color2">등록</button>
	    </div>
	</div>
	<!-- 회의실 예약 끝 -->

	<!-- 차량 예약 시작 -->
	<div id="car_reservation_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
		<div style="text-align: center; font-size:20px; font-weight:bold;">차량예약</div>
		<div class="date_div" style="margin-top:20px;margin-bottom:30px;margin-left:30px;">
			<span id="car_date" style="top:0;font-weight:bold;font-size:20px;"></span>
			<input type="text" id="select_car_date" value="<?php echo date('Y-m-d'); ?>" onchange="change_date('car',this.value);" style="visibility:hidden;position:absolute;">
			<img id="btn_down" src="<?php echo $misc; ?>img/mobile/btn_down.svg" style="margin-left:10px;" onclick="$('#select_car_date').focus();">
		</div>
	  <div id="select_car_table" style="width: 80%; height:90%; float:right; border: none; margin-bottom:20px;margin-top:20px;">
	    <input type="hidden" id="select_car_day" name="select_car_day" value="">
	    <input type="hidden" id ="selected_car_name" name="selected_car_name" value="">
	    <div style="margin-left:30px;">
	      <table class="select_time" style="width:98%;" border="0" cellspacing="0" cellpadding="0">
	        <thead class="select_time_th">
	        <tr>
	          <th style="background-color:#F4F4F4">차종</th>
	          <!-- <th>번호</th> -->
	          <th colspan="2">08</th>
	          <th colspan="2">09</th>
	          <th colspan="2">10</th>
	          <th colspan="2">11</th>
	          <th colspan="2">12</th>
	          <th colspan="2">13</th>
	          <th colspan="2">14</th>
	          <th colspan="2">15</th>
	          <th colspan="2">16</th>
	          <th colspan="2">17</th>
	          <th colspan="2">18</th>
	          <th colspan="2">19</th>
	          <th colspan="2">20</th>
	          <th colspan="2">21</th>
	        </tr>
	        </thead>
	        <tbody class="select_time_tb" id="select_car_tbody">
	          <?php

	           foreach ($cars as $car) {

	             echo "<tr id='{$car->type}{$car->number}'>";
	             $start = strtotime('08:00');
	             echo "<td name='car_info' id='car_name_td' style='font-weight:bold;background-color:#F4F4F4'>{$car->type}<br>{$car->number}</td>";
	            //  echo "<td name='car_info' id='car_num_td'>{$car->number}</td>";
	             plus_time($start);
	             echo "</tr>";

	           }
	           ?>

	        </tbody>
	      </table>
	    </div>
	    <div align="center" style="bottom: 0;">
	      <p id="feedback" style="display:none;">
	        <span>You&apos;ve selected:</span> <span id="select_car_result">none</span>
	      </p>
	      <button type ="button" class="btn-common btn-color1" style="margin-right:10px;" onclick="$('#car_reservation_div').bPopup().close();">취소</button>
	      <button type ="button" id ="add_car_btn" name = "add_car_btn" onclick="add_car(this.name);" class="btn-common btn-color2">등록</button>
	    </div>
	  </div>
	</div>

	<div id="wrap-loading" style="z-index: 10000;display:none;">
    <img src="<?php echo $misc; ?>img/loading_img.gif" alt="Loading..." style="width:50px;border:0; position:absolute; left:50%; top:50%;" />
	</div>
	<!-- 차량 예약 끝 -->

	<!-- 사진 상세 -->
	<div id='img_detail' class="layerpop" >
	  <article class="layerpop_area">
	    <div align="left" class="modal_title">사진 상세
	    </div>
	    <a onclick="$('#img_detail').bPopup().close();" class="layerpop_close" id="layerbox_close"><img src="/misc/img/btn_del2.jpg"/></a>
	    <table border="0" cellspacing="0" cellpadding="0" width="95%" class="modal-input-tbl">
	      <colgroup>
	        <col width="25%" />
	        <col width="75%" />
	      </colgroup>
	      <tr>
	        <td style="font-weight:bold;">제조사</td>
	        <td id="imgMake"></td>
	      </tr>
	      <tr>
	        <td style="font-weight:bold;">모델명</td>
	        <td id="imgModel"></td>
	      </tr>
	      <tr>
	        <td class="non-border" style="font-weight:bold;">찍은 날짜</td>
	        <td class="non-border" id="imgDateTime"></td>
	      </tr>
	      <tr>
	        <td></td>
	        <td><div id="thumbnail" class="thumbnail" style="margin: 0 auto;margin-bottom:10px;"></div></td>
	      </tr>
	      <tr>
	        <td style="font-weight:bold;vertical-align:top;padding-top:30px;">위치</td>
	        <td>
	          <div id="map" style="width:250px;height:250px;"></div>
	        </td>
	      </tr>
	    </table>
	  </article>
	</div>

	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>
	<?php include $this->input->server('DOCUMENT_ROOT')."/misc/js/tech_schedule/tech_schedule_mobile_js.php"; ?>



</body>
