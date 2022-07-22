<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  include $this->input->server('DOCUMENT_ROOT')."/misc/js/tech_schedule/mango_schedule.php";
?>
<html>
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1, maximum-scale = 1, viewport-fit = cover, user-scalable = no, shrink-to-fit = no ">
    <title></title>

  </head>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="<?php echo $misc; ?>js/touch-punch.js"></script>
  <link href='/misc/css/tech_schedule/tech_schedule_1.0.css' rel='stylesheet' />
  <link href='/misc/css_mango/view_page_common_mango.css' rel='stylesheet' />
  <link href='/misc/css/tech_schedule/main.css' rel='stylesheet' />
  <link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="/misc/css/bootstrap-timepicker.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> <!-- 조직도 생성 -->
  <link rel="stylesheet" href="/misc/css/tech_schedule/proton/style.min.css" /> <!-- 조직도 생성 -->
  <link rel="stylesheet" href="/misc/css/chosen.css">
  <link rel="stylesheet" href="/misc/css_mango/mango_schedule.css">
  <script src='/misc/js/tech_schedule/main.js'></script>
  <script src='/misc/js/tech_schedule/ko.js'></script>
  <script src='/misc/js/chosen.jquery.js'></script>
  <script src='https://cdn.jsdelivr.net/npm/rrule@2.6.4/dist/es5/rrule.min.js'></script>
  <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/rrule@5.5.0/main.global.min.js'></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
  <script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="/misc/js/bootstrap-timepicker.js"></script>
  <script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.0/moment.min.js"></script>
  <script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
  <script src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script> <!-- 조직도 생성 -->
  <style media="screen">
  <?php foreach($work_color as $wc){ ?>
  <?php echo '.event_class_type'.$wc->seq; ?> { border: 1px solid #474889; border-radius: 50%; background: <?php echo $wc->color; ?> !important; color: #fff !important;
   -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
   -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
   box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
  }
  <?php } ?>
  .select2-search__field {
    font-family:"Noto Sans KR", sans-serif !important;
    border: 1px solid #DEDEDE !important;
    outline: none !important;
    width:100%!important;
  }
  .select2-container {
    z-index: 10000;
  }
  .dayBtn {
    background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
    background-size: 20px;
  }
  .timeBtn {
		background:url(<?php echo $misc; ?>img/mobile/icon_time.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
  .select2-container .select2-selection--single .select2-selection__rendered {
    height: 35px !important;
    border-color: #DDDDDD !important;
    border-radius: 3px !important;
    color: #A6A6A6 !important;
    vertical-align: middle !important;
}
.select2 {
  width: 100% !important;
}
select[readonly].select2-hidden-accessible + .select2-container {
  pointer-events: none;
  touch-action: none;
}

select[readonly].select2-hidden-accessible + .select2-container .select2-selection {
  background: #eee;
  box-shadow: none;
}

select[readonly].select2-hidden-accessible + .select2-container .select2-selection__arrow,
select[readonly].select2-hidden-accessible + .select2-container .select2-selection__clear {
  display: none;
}
.main_content_extend {
  height: calc(100% - 80px) !important;
  overflow: auto !important;
}
  </style>
  <script>
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
// KI2 20210125
function popupClose(close_popup_id) {
 $("#show_day_select_popup").bPopup().close();
}
function show_day_select() {
  $("#show_day_select_popup").bPopup();
}
  </script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/mango_header.php";
?>
<table id="zg" width="100%" style="height:500px;" border="0" cellspacing="0" cellpadding="0">
  <input type="hidden" name="session_name" id="session_name" value="<?php echo $session_name; ?>">
  <input type="hidden" name="session_id" id="session_id" value="<?php echo $session_id; ?>">
  <input type="hidden" name="session_admin" id="session_admin" value="<?php echo $session_admin; ?>">
  <tr>
    <td align="center" valign="top">
      <div id='addpopup' style=" width:30%; height: auto;">
        <article class="layerpop_area">
          <form name="cform" id="cform" action="<?php echo site_url();?>/biz/schedule/add_schedule" method="post">
            <div align="left" class="modal_title">일정등록</div>
              <input type="hidden" name="seq" id="seq" value="">
              <table width="100%" border="0" callspacing="0" cellspacing="0">
                <tbody align="left">
                  <tr>
                    <td>
                      <td align="center">
                        <table border="0" cellspacing="0" cellpadding="0" width="95%" class="modal-input-tbl">
                          <colgroup>
                            <col width="50%" />
                            <col width="50%" />
                          </colgroup>
                          <tbody>
                            <tr>
                              <td class="sub_title">구분</td>
                            </tr>
                            <tr>
                              <td colspan="2">
                                <select name="schedule_type" id="schedule_type" class="select-common select-style1" style="float:left;margin-right:10%;background-color:white;width:100%;" onchange="change_schedule_type(this);">
                                  <option value="" selected disabled hidden>선택하세요</option>
                                  <?php
                                  foreach ($work_name as $val) {
                                    if($val->schedule_type == 'confirmation') {
                                      $schedule_type = '확정';
                                    } else if($val->schedule_type == 'actual') {
                                      $schedule_type = '자동';
                                    } else if($val->schedule_type == 'scheduled') {
                                      $schedule_type = '예정';
                                    }
                                    if($val->schedule_type != 'actual') {
                                      echo "<option value='{$val->schedule_type}' >{$schedule_type}</option>";
                                    }
                                  }
                                  ?>
                                  <option value="scheduled_batch">예정(일괄 등록)</option>
                                </select>
                              </td>
                            </tr>
                            <tr class="add_common">
                              <td class="sub_title">근무시작</td>
                            </tr>
                            <tr class="add_common">
                              <td align="left">
                                <input class="input-common dayBtn datepicker" type="text" name="startDay" id="startDay" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" onchange="date_compare('');" style="width:98%;" readonly>
                              </td>
                              <td align="right">
                                <input class="input-common timeBtn timepicker" type="text" name="startTime" id="startTime" value="" autocomplete="off" style="width:98%;" readonly>
                              </td>
                            </tr>
                            <tr class="add_common">
                              <td class="sub_title">종료일자</td>
                            </tr>
                            <tr class="add_common">
                              <td align="left">
                                <input class="input-common dayBtn datepicker" type="text" name="endDay" id="endDay" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" onchange="date_compare('');" style="width:98%;" readonly>
                              </td>
                              <td align="right">
                                <input class="input-common timeBtn timepicker" type="text" name="endTime" id="endTime" value="" autocomplete="off" style="width:98%;" readonly>
                              </td>
                            </tr>
                            <tr class="scheduled_batch">
                              <td class="sub_title">일괄 등록 월</td>
                            </tr>
                            <tr class="scheduled_batch">
                              <td align="left" colspan="2">
                                <input type="text" class="input-common monthPicker dayBtn" id="scheduled_batch_month" name="scheduled_batch_month" style="width:100%" placeholder="등록 월을 선택해주세요" value="" readonly>
                              </td>
                            </tr>
                            <tr>
                              <td class="sub_title">근무자</td>
                            </tr>
                            <tr>
                              <td colspan="2">
                                <input type="hidden" id="participant" name="participant" class="input2" required readonly />
                                <select id="participant_select" class="user_select" name="participant_select" onchange="participantSelect('participant',this);make_timeTable(this);" style="width:100%;">
                                  <option value=""></option>
                                  <?php foreach ($user_info as $ui) {
                                    echo "<option value='{$ui['user_name']}'>{$ui['user_name']}</option>";
                                  } ?>
                                </select>
                              </td>
                            </tr>
                            <tr class="scheduled_batch">
                              <td class="sub_title">근무시간</td>
                            </tr>
                            <tr class="time_table scheduled_batch">
                              <td colspan="2">
<?php
$w = ['월', '화', '수', '목', '금'];
for($i=0; $i<count($w); $i++) { ?>
                        <?php if($i == 0 || $i == 3) { ?>
                                <div style="float:left;width:48%;">
                        <?php } ?>
                                  <p class="sub_title"><?php echo $w[$i].'요일'; ?></p>
                                  <input type="text" class="input-common timeBtn timepicker" style="width:40%;height:30px;" id="user_work_start_<?php echo $i; ?>" name="work_start[]" value="" autocomplete="off">
                                  ~
                                  <input type="text" class="input-common timeBtn timepicker" style="width:40%;height:30px;" id="user_work_end_<?php echo $i; ?>" name="work_end[]" value="" autocomplete="off">
                        <?php if($i == 2 || $i == 4) { ?>
                                </div>
                        <?php } ?>
<?php } ?>
                              </td>
                            </tr>

                            <tr>
                              <td class="sub_title">내용</td>
                            </tr>
                            <tr>
                              <td colspan="2">
                                <textarea class="textarea-common" rows="4" name='contents' id="contents" placeholder="내용을 입력하세요" style="resize:none; vertical-align:middle;width:100%;float:left;box-sizing:border-box;" maxlength="300"></textarea>
                              </td>
                            </tr>
                            </tbody>
                          </table>
                          <div style="margin-top:30px;">
                            <button type="button" name="scheduleAdd" id="scheduleAdd" class="btn-common btn-color2" onClick="sch_insert('')" style="float:right;margin-right:14px;width:auto;padding:0 15px;">등록</button>
                            <button type="button" class="btn-common btn-color1" onClick="$('#addpopup').bPopup().close();" style="float:right;margin-right:14px;width:auto;padding:0 15px;">취소</button>
                          </div>
                        </td>
                      </td>
                    </tr>
                  </table>
                </form>
              </article>
            </div>
<!-- 팝업 끝 -->
            <!-- 참여자 팝업 추가 -->
            <div id="addUserpopup">
              <img id="addUserpopupCloseBtn" src="<?php echo $misc;?>img/btn_del2.jpg" onclick="closeBtn()" width=25  style="cursor:pointer;margin:0% 0% 0% 92%"/>
              <!-- <span id="addUserpopupCloseBtn" class="btn" onclick="closeBtn()" style="margin:0% 0% 0% 96%; color:white;">X</span> -->
              <div id="modal-body">
                <div id="modal-grouptree">
                  <div id="usertree">

                  </div>
                </div>
                <div id="btnDiv">
                  <input type="button" style="float:right;" class="basicBtn" id="insertUserBtn" name="" value="적용" onclick="addUser(this.id)">
                </div>
              </div>
            </div>
    <!-- 참여자 팝업 끝 -->

      <div id="body_contain">
      <div id="sd_contain">
        <div id="scheduleSidebar" style="text-align: left;width:210px;">
          <div class="" style="text-align:left;height:auto;padding-top:5px;padding-bottom:10px;" id="company_schedule">
            <input type="checkbox" id="company_schedule_scheduled" onclick="company_schedule_check('scheduled')" checked><span class="notice_text">예정 근무 일정<span><br>
            <input type="checkbox" id="company_schedule_actual" onclick="company_schedule_check('actual')" checked><span class="notice_text">자동 근무 일정<span><br>
            <input type="checkbox" id="company_schedule_confirmation" onclick="company_schedule_check('confirmation')" checked><span class="notice_text">확정 근무 일정<span>
          </div>
          <!-- <h2>sidebar</h2> -->
          <!-- @@ ↓ -->

          <div id="tree">
            <ul>
              <li>전체(<?php echo count($work_user_list); ?>)
                <ul>
          <?php foreach($work_user_list as $wul){ ?>
                  <li id="<?php echo $wul['user_name']; ?>"><?php echo $wul['user_name']; ?></li>
          <?php } ?>
                </ul>
              </li>
            </ul>
          </div>
          <!-- @@ ↑ -->
        </div>
        <div id='calendar' style="padding-bottom:100px;">
          <!-- 여기 달력뷰 -->
        </div>
      </div>
      <!-- <div id="scheduleBottom"> </div> -->
      <!-- ↑sd 컨테인 끝 -->

      <div id = 'updateSchedule' style="width:30%; height: auto;" class="layerpop" >
        <article class="layerpop_area">
            <div align="left" class="modal_title">일정 상세</div>
                  <table width="100%" border="0" callspacing="0" cellspacing="0">
                    <input type="hidden" name="de_seq" id="de_seq" value="">
                     <tr>
                       <td>
                         <td align="center">
                           <table border="0" cellspacing="0" cellpadding="0" width="95%" class="modal-input-tbl">
                           <colgroup>
                             <col width="50%" />
                             <col width="50%" />
                          </colgroup>
                              <tbody>
                                <tr>
                                  <td class="sub_title">구분</td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    <select name="de_schedule_type" id="de_schedule_type" class="select-common select-style1" onchange="" style="float:left;margin-right:10%;background-color:white;width:100%;" disabled>
                                      <option value="" selected disabled hidden>선택하세요</option>
                                      <?php
                                      foreach ($work_name as $val) {
                                        if($val->schedule_type == 'confirmation') {
                                          $schedule_type = '확정';
                                        } else if($val->schedule_type == 'actual') {
                                          $schedule_type = '자동';
                                        } else if($val->schedule_type == 'scheduled') {
                                          $schedule_type = '예정';
                                        }
                                        echo "<option value='{$val->schedule_type}' >{$schedule_type}</option>";
                                      }
                                      ?>
                                    </select>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="sub_title">근무시작</td>
                                </tr>
                                <tr>
                                  <td align="left">
                                    <input class="input-common dayBtn datepicker" type="text" name="de_startDay" id="de_startDay" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" onchange="date_compare('');" style="width:98%;" readonly>
                                  </td>
                                  <td align="right">
                                    <input class="input-common timeBtn timepicker" type="text" name="de_startTime" id="de_startTime" value="" autocomplete="off" style="width:98%;" readonly>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="sub_title">종료일자</td>
                                </tr>
                                <tr>
                                  <td align="left">
                                    <input class="input-common dayBtn datepicker" type="text" name="de_endDay" id="de_endDay" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" onchange="date_compare('');" style="width:98%;" readonly>
                                  </td>
                                  <td align="right">
                                    <input class="input-common timeBtn timepicker" type="text" name="de_endTime" id="de_endTime" value="" autocomplete="off" style="width:98%;" readonly>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="sub_title">근무자</td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    <input type="hidden" id="de_participant" name="de_participant" class="input2" required readonly />
                                    <select id="de_participant_select" class="user_select" name="de_participant_select" onchange="participantSelect('de_participant',this);" style="width:80%;">
                                      <option value=""></option>
                                      <?php foreach ($user_info as $ui) {
                                        echo "<option value='{$ui['user_name']}'>{$ui['user_name']}</option>";
                                      } ?>
                                    </select>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="sub_title">내용</td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    <textarea class="textarea-common" rows="4" name='de_contents' id="de_contents" placeholder="내용을 입력하세요" style="resize:none; vertical-align:middle;width:100%;float:left;box-sizing:border-box;" maxlength="300"></textarea>
                                  </td>
                                </tr>
                             </tbody>
                           </table>
                           <div id="schdule_contoller_btn2" style="margin-top:30px; <?php if($session_admin != 'Y'){echo 'display:none;';} ?>">
                             <input type="button" name="updateSubmit" id="updateSubmit" class="btn-common btn-color2 modify_btn" onclick="sch_insert('de_')" style="float:right;margin-right:10px;width:auto;padding:0 15px;" value="수정">
                             <input type="button" name="confirmSubmit" id="confirmSubmit" class="btn-common btn-color2 modify_btn" onclick="sch_insert('de_', 'confirm')" style="float:right;margin-right:10px;width:auto;padding:0 15px;" value="근무시간 확정">
                             <input type="button" name="delSubmit" id="delSubmit" class="btn-common btn-color1 modify_btn" onclick="delete_schedule()" style="float:right;margin-right:10px;width:auto;padding:0 15px;" value="삭제">
                             <button type="button" class="btn-common btn-color1" onClick="$('#updateSchedule').bPopup().close();" style="float:right;margin-right:10px;width:auto;padding:0 15px;">취소</button>
                           </div>
                         </td>
                       </td>
                     </tr>
                   </table>
              <!-- </form> -->
            </article>
          </div>
    <!-- 디테일 디브 끝 -->
      </div>


      <!-- //여기까지 -->
    </td>
  </tr>
  <!--하단-->
</table>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/mango_bottom.php"; ?>
<script>
window.onload = function() {
  $("#scheduleSidebar").css('height', $("#calendar").height()-2);
}
$(window).resize(function() {
  setTimeout(function() {
    $("#scheduleSidebar").css('height', $("#calendar").height()-2);
  },500);
})

var option = '<option value=""></option>';
<?php foreach ($user_info as $ui) {?>
option += "<option value='<?php echo $ui['user_name'].' '.$ui['seq'];?>'><?php echo $ui['user_name']; ?></option>";
<?php } ?>

$('.user_select').html(option);

$(".user_select").select2({
   placeholder: '검색어 입력'
});

function participantSelect(name, obj) {
  var selected = $('#'+name+'_select').val();
  $("input[name="+name+"]").val(selected);
}

</script>
</body>
<style media="screen">
.fc-daygrid-more-link {
  float: right !important;
}
</style>
</html>
