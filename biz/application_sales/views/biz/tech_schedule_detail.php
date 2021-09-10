<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>

<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>

  <link href='/misc/css/tech_schedule/tech_schedule.css' rel='stylesheet' />
  <link href='/misc/css/tech_schedule/main.css' rel='stylesheet' />
  <link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="/misc/css/bootstrap-timepicker.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> <!-- 조직도 생성 -->
  <link rel="stylesheet" href="/misc/css/tech_schedule/proton/style.min.css" /> <!-- 조직도 생성 -->
  <link rel="stylesheet" href="/misc/css/tech_schedule/jquery.minicolors.css" />
  <link rel="stylesheet" href="/misc/css/chosen.css">
  <!-- <link rel="stylesheet" href="/misc/css/bootstrap.css"> -->
  <script src='/misc/js/tech_schedule/main.js'></script>
  <script src='/misc/js/tech_schedule/ko.js'></script>
  <script src='/misc/js/chosen.jquery.js'></script>
  <script src='/misc/js/tech_schedule/tech_schedule.js'></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <!-- <script src='/misc/js/select2.min.js'></script> -->
  <script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="/misc/js/bootstrap-timepicker.js"></script>
  <script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.0/moment.min.js"></script>
  <script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
  <script src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script> <!-- 조직도 생성 -->
  <script type="text/javascript" src="/misc/js/tech_schedule/jquery.minicolors.js"></script>



<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top">
      <!-- //여기부터 -->



      <!-- 일정 추가 팝업 -->
<div>
</div>

  <div id="sd_contain">
    <div id="scheduleTop"></div>
    <div id="scheduleSidebar" style="text-align: left;">

      <!-- @@ ↑ -->
    </div>
    <div id='calendar'>
      <li style="list-style-type : none; text-align: right; font-size:15px; font-wieght:bold; text-decoration : underline;">
        <a href="<?php echo site_url();?>/biz/schedule/tech_schedule">돌아가기</a>
      </li>

        <div id = 'updateSchedule'>
          <table>
            <!-- KI1 20210125 고객사 담당자 선택을 위한 name=cform 적용-->
            <form id="hiddenSeq" name="cform" method="GET">
              <!-- KI2 20210125 -->
              <!-- <form name="hiddenSeq" action="<?php echo site_url();?>/schedule/modify" method="post"> -->
              <input type="hidden" name="seq" id="seq" value="<?php echo $details->seq;?>">
              <input type="hidden" id="mode" name="mode" value="">
              <input type="hidden" id="link" name="link" value="">
            <tbody>
              <!-- KI1 20210125 고객사 담당자 적용을 위한 hidden input 적용, 프로젝트 input 추가 -->
              <input type="hidden" name="customer_manager" id="customer_manager" class="input2" value="<?php echo $details->customer_manager;?>">
              <input type="hidden" name="maintain_end" id="maintain_end" class="input2">

              <input type="hidden" id="row_max_index" name="row_max_index" value="0" />
              <input type="hidden" id="customer_tmp" name="customer_tmp" value="" />
              <!-- ↑customerName과 동일 -->
              <input type="hidden" id="forcasting_seq" name="forcasting_seq" value="<?php echo $details->forcasting_seq;?>" />
              <input type="hidden" id="maintain_seq" name="maintain_seq" value="<?php echo $details->maintain_seq;?>" />
              <!-- <input type="hidden" id="checkListForm" name="checkListForm" value="" /> -->
              <!-- KI1 20210208 -->
              <input type="hidden" id="tech_report" name="tech_report" value="<?php echo $details->tech_report; ?>" />
              <!-- KI2 20210208 -->
              <tr>
                <td>
                  기&nbsp;&nbsp;&nbsp;간
                </td>
<?php
$check = ($details->start_time == '00:00:00' && $details->end_time == '00:00:00')?"checked":"";
?>
                <td>
                 <input type="text" name="startDay" id="startDay" size="7" value="<?php echo $details->start_day;?>" autocomplete="off">
                 <input type="button" name="" id="startBtn" class="dateBtn" value=" " onclick="openStartDate();">
                 <input type="text" name="startTime" id="startTime" class="timeBtn" size="2" value="<?php echo $details->start_time;?>" autocomplete="off">
                 <!-- <input type="button" name="" id="startTimeBtn" class="timeBtn" value=" " onclick="">  -->
                 ~
                 <input type="text" name="endDay" id="endDay" size="7" value="<?php echo $details->end_day;?>" autocomplete="off">
                 <input type="button" name="" id="endBtn" class="dateBtn" value=" " onclick="openEndDate();">
                 <input type="text" name="endTime" id="endTime" size="2" class="timeBtn" value="<?php echo $details->end_time;?>" autocomplete="off">
                 <!-- <input type="button" name="" id="endTimeBtn" class="timeBtn" value=" " onclick=""> -->
                 <label><input type="checkbox" id="alldayCheck" name="alldayCheck" value="" onChange="hideTime();" <?php echo $check;?>>종일</label>
                </td>
              </tr>
<?php if ($details->title !=''){?>
              <tr>
                <td>제&nbsp;&nbsp;&nbsp;목</td>
                <td><input type="text" name="title" id="title" value="<?php echo $details->title?>" placeholder="제목" size='45'></td>
              </tr>
<?php } ?>
              <tr>
                <td>구&nbsp;&nbsp;&nbsp;분</td>
                <td>
                  <select name="workname" id="workname">
                    <option value="" selected disabled hidden>선택하세요</option>
<?php
foreach ($work_name as $val) {
  $work= $val->work_name;
  $selectWork = $details->work_name;
  $selected = ($work == $selectWork)?"selected":"";
  echo "<option value = '{$work}' {$selected}>{$work}</option>";
}
?>
                  </select>
                  &nbsp;지원방법
                  <select name="supportMethod" id="supportMethod">
                    <option value="" selected disabled hidden>선택하세요</option>
                    <option value="현장지원" <?php if($details->support_method =="현장지원"){echo "selected";}?>>현장지원</option>
                    <option value="원격지원" <?php if($details->support_method =="원격지원"){echo "selected";}?>>원격지원</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>고객사</td>
                <!-- KI1 20210125 고객사를 포캐스팅형/유지보수형으로 변경 -->
                <td >
                  <div class="dropdown" id="dropdown">
                    <p onclick="searchFunction(this.id)" id="dropbtn" class="dropbtn">검색</p>
                    <input id="customerName" name ="customerName" type="text" class="customerName" value="<?php echo $details->customer;?>" style="border:none;width:200px;font-weight:bold;text-align:center;" onchange="customerNameChange(this.value);" <?php if($details->forcasting_seq != '' && $details->maintain_seq !=''){echo "readonly";}?>>
                    <input type="hidden" id="customer" name="customer" value="
                    <?php
                    if($details->work_name == '납품설치' || $details->work_name == '미팅' || $details->work_name == '데모(BMT)지원'){
                      echo $details->forcasting_seq;
                    }else{
                      echo $details->maintain_seq;
                    }
                    ?>" style="border:none" readonly>
                    <div id="myDropdown" class="dropdown-content">
                      <input type="text" name="0" placeholder="고객사를 입력하세요" id="searchInput" class="searchInput" onkeyup="filterFunction(this)">
                      <div id="dropdown_option" style="overflow:scroll; width:277px; height:300px;">
                        <?php
                        // foreach ($customer  as $val) {
                        //   if (strtotime(date("Y-m-d")) > strtotime(date($val['maintain_end']))) {
                        //     echo '<a style="color:red;" ';
                        //     echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['forcasting_seq'].')" >' . $val['customer'].' - '.$val['project_name'].'</a>';
                        //   } else {
                        //     echo '<a ';
                        //     echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.$val['project_name'].'</a>';
                        //   }
                        // }
                        ?>
                      </div>
                    </div>
                  </div>
                </td>
                <!-- KI2 20210125 -->
              </tr>
              <tr>
                <td>프로젝트명</td>
                <td>
                  <input type="text" id="project" name="project" value="<?php echo $details->project;?>" size='45' <?php if($details->forcasting_seq != '' && $details->maintain_seq !=''){echo "readonly";}?>>
                <td>
              </tr>
              <!-- KI2 20210125 -->
              <tr>
                <td>참석자</td>
                <td>
                  <input type="text" name="participant" id="participant" value="<?php echo $details->participant;?>" placeholder="" size='45'>
                  <!-- KI1 20210125 참여자 추가버튼 이미지로 수정 -->
                  <!-- <button type="button" id="addUserBtn2" name="addUserBtn2" onclick="addUser_Btn()">추가</button> -->

                  <input type="image" src="/misc/img/participant_add.jpg" id="addUserBtn" class="btn" style="width:25px; height:25px; vertical-align:middle;" onclick="addUser_Btn();return false;">
                  <!-- <img src="/misc/img/participant_add.jpg" id="addUserBtn" class="btn" style="width:25px; height:25px; vertical-align:middle;" onclick="addUser_Btn()"> -->

                  <!-- KI2 20210125 -->
                </td>
              </tr>
              <tr>
                <td>내&nbsp;&nbsp;&nbsp;용</td>
                <td>
                  <textarea cols="58" rows="25" name='contents' id="contents" placeholder="상세내용"><?php echo $details->contents;?></textarea>
                </td>
              </tr>
              <tr>
                <td>
                </td>
                <td>
                  <!-- <input type="submit" name="updateSubmit" id="updateSubmit" value="수정"> -->
                  <!-- <input type="submit" name="delSubmit" id="delSubmit" value="삭제"> -->
                  <input type="submit" name="updateSubmit" id="updateSubmit" class="detail_btn" onclick="modify()" value="수정">
                  <input type="submit" name="delSubmit" id="delSubmit" class="detail_btn" onclick="modify()" value="삭제">
                  <!-- KI -->
                  <?php
                  if($details->tech_report == "Y" && $details->forcasting_seq != '' && $details->maintain_seq !='' ){
                    // echo 'tech_report:'.$details->tech_report.' '.'forcasting_seq:'.$details->forcasting_seq.' '.'maintain_seq'.$details->maintain_seq;

                    echo '<input type="button" id="techReportSubmit" name="techReportSubmit" class="techReportSubmit" onclick="modify('."'modify'".')" value="기술지원보고서 수정">';
                    // echo '<input type="button" id="techReportSubmit" name="techReportSubmit" onclick="modify(`modify`)" value="기술지원보고서 수정">';
                  }else if($details->tech_report == "Y" && $details->forcasting_seq == '' && $details->maintain_seq ==''){
                  // }else if($details->tech_report == "Y" && $details->forcasting_seq == '' && $details->maintain_seq =='' && $details->start_day >'2021-01-31'){

                    // echo 'tech_report:'.$details->tech_report.' '.'forcasting_seq:'.$details->forcasting_seq.' '.'maintain_seq'.$details->maintain_seq;

                    echo '';
                  }else{
                    // echo 'tech_report:'.$details->tech_report.' '.'forcasting_seq:'.$details->forcasting_seq.' '.'maintain_seq'.$details->maintain_seq;

                    echo '<input type="submit" id="techReportSubmit" name="techReportSubmit" class="techReportSubmit" onclick="modify('."'report'".')" value="기술지원보고서 작성">';
                    // echo '<input type="submit" id="techReportSubmit" name="techReportSubmit" onclick="modify(`report`)" value="기술지원보고서 작성">';
                  }
                  ?>
                  <!-- <input type="button" id="techReportSubmit" name="button" onclick="connectTechRepot()" value="기술지원보고서"> -->
                  <!-- <input type="submit" id="techReportSubmit" name="techReportSubmit" onclick="modify('report')" value="기술지원보고서"> -->
                </td>
              </tr>
              </tbody>
              </form>
            </table>
          </div>

        </div>

      </div>
      <!-- KI1 20210125 참여자 추가 형태를 검색 참여자 추가 형태로 변경  -->
      <!-- 참여자 팝업 추가 -->
      <div id="addUserpopup">
        <span id="addUserpopupCloseBtn" class="btn" onclick="closeBtn()"style="margin:0% 0% 0% 96%; color:white;">X</span>
        <!-- <a style="margin:0% 0% 0% 96%;cursor:pointer;"><span id="addUserpopupCloseBtn" onclick="closeBtn()"><span style="color:white;">X</span></span></a> -->
        <div id="modal-body">
          <div id="modal-grouptree">
            <div id="usertree">
              <ul>
                <li>(주)두리안정보기술
                  <ul>
                  <?php
                  foreach ($parentGroup as $pg){
                  ?>

                  <?php
                  if ($pg->childGroupNum==1 && $pg->depth==1){
                  ?>
                    <li>
                      <?php echo $pg->parentGroupName;
                        foreach ($userInfo as $ui){
                            if ($pg->groupName==$ui->user_group){
                      ?>
                      <ul>
                        <li id="<?php echo $ui->user_name; ?>"><?php echo $ui->user_name." ".$ui->user_duty; ?></li>
                      </ul>
                      <?php
                            }
                        }
                      ?>
                    </li>
                    <?php
                    } else if ($pg->childGroupNum>1 && $pg->depth==1){
                    ?>
                    <li>
                    <?php echo $pg->parentGroupName;
                    foreach ($user_group as $ug) {
                      if ($pg->parentGroupName==$ug->parentGroupName){
                    ?>
                      <ul>
                        <?php
                        foreach ($userDepth as $ud){
                            if ($ug->groupName == $ud->groupName){
                              echo '<li id="'.$ud->user_name.'">'.$ud->user_name." ".$ud->user_duty.'</li>';
                            }
                        }
                        if ($ug->groupName != $ud->groupName){
                          echo "<li>".$ug->groupName;
                        }
                        ?>
                          <ul>
                          <?php
                            foreach($userInfo as $ui) {
                              if ($ug->groupName==$ui->user_group){
                                echo '<li id="'.$ui->user_name.'">'.$ui->user_name." ".$ui->user_duty.'</li>';
                              }
                            }
                          ?>
                          </ul>
                        </li>
                      </ul>
                    <?php
                      }
                    }
                    ?>
                    </li>
                    <?php
                    }
                    ?>
                  <?php
                  }
                  ?>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
          <!-- <div id="modal-btn">
              <ul class="kipark">
                <li><a style="cursor:pointer;" onclick="insertUser()"><img src="/misc/img/btn_right2.jpg" id="insertUserBtn"></a></li>
                <li><a style="cursor:pointer;" onclick="deleteUser()"><img src="/misc/img/btn_left2.jpg" id="insertUserBtn"></a></li>
                <li><a style="cursor:pointer;" onclick="reset()"><img src="/misc/img/btn_return.jpg" id="insertUserBtn"></a></li>
              </ul>
            </div>
            <div id="modal-participant">
              <ul id="insertParticipant">
              </ul>
            </div> -->
            <div id="btnDiv">
            <input type="button" style="float:right;" id="chosenBtn" name="" value="적용" onclick="addUser(this.id)">
            <!-- <input type="button" style="float:right;" id="chosenBtn" name="" value="적용" onclick="addUser()"> -->
            </div>
          </div>
        </div>
        <!-- 참여자 팝업 끝 -->
        <!-- KI2 20210125 -->
      <!-- </div> -->
      <script>

      //오늘 날짜 가져오기
      let today = new Date();
      let year = today.getFullYear(); // 년도
      let month = today.getMonth() + 1;  // 월
      let date = today.getDate();  // 날짜
      let day = today.getDay();  // 요일


      // 종일 체크 해두기
        if ($("input:checkbox[name='alldayCheck']").is(":checked") == true){
          $(".timeBtn").hide();
        };

        // $('#customer').change(function(){
        //   if($(this).val()=="직접입력"){
        //     // alert($(this).val());
        //     $('.insertDirect').show();
        //   }else{
        //     $('.insertDirect').hide();
        //   }
        // });




      var register ="<?php echo $details->user_id?>";
      var regGroup ="<?php echo $details->group?>";
      var regPgruop ="<?php echo $details->p_group?>"
      //KI1 20210125
      var regParticipant ="<?php echo $details->participant?>";

      var session_name ="<?php echo $name ?>";
      // alert('regParticipant='+regParticipant+' session_name='+session_name+' indexOf='+regParticipant.indexOf(session_name));
      //KI2 20210125

      var session_id ="<?php echo $id ?>";
      var login_gruop = "<?php  echo $login_gruop?>";
      var login_pgroup ="<?php  echo $login_pgroup?>";
      var login_user_duty ="<?php  echo $login_user_duty?>";

      if((register == session_id)||(login_user_duty=='팀장'&&login_gruop==regGroup)||(login_user_duty=='이사'&&login_pgroup==regPgruop) || (regParticipant.indexOf(session_name) > -1)){ //indexOf값이 -1이 아니면 regParticipant 안에 본인이 들어가 있다는 것
        $("#updateSchedule").find("input, select, button, textarea").prop("disabled", false);

        //KI1 20210125 팀장,이사 직급 외에 참가자들은 기술지원 보고서 작성가능
      // }else if((regParticipant.indexOf(session_name) > -1)){ //indexOf값이 -1이 아니면 regParticipant 안에 본인이 들어가 있다는 것, 기지보 작성 가능하게 보인다.
        // $("#updateSchedule").find("input, select, button, textarea").not("techReportSubmit, .detail_btn").prop("readonly",true);
        // $("#updateSchedule").find(".detail_btn").prop("disabled",true);
      }else{ //
        $("#updateSchedule").find("input, select, button, textarea").prop("disabled",true);
      }

      //KI2 20210125


      // KI1 20210125 고객사 포캐스팅형/유지보수형으로 변경에 적용되는 함수들
      function searchFunction(id) {
        if($("#workname").val() == "납품설치" || $("#workname").val() == "미팅" || $("#workname").val() == "데모(BMT)지원" ){
          $("#dropdown_option").html(
            <?php
            echo "'";
            //KI1 20210208
            echo '<a onClick="show_input_customerName()" value="">직접입력</a>';
            //KI2 20210208
            foreach ($customer2 as $val) {
                echo '<a ';
                echo 'onclick ="clickCustomerName(this,0,'.$val['forcasting_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.$val['project_name'].'</a>';
            }
            echo "'";
            ?>
          );
        }else if($("#workname").val() ==''){
          $("#myDropdown").toggle();
          alert('작업구분을 먼저 선택해주세요.');
          $("#workname").focus();
        }else{
          $("#dropdown_option").html(
          <?php
             echo "'";
             //KI1 20210208
             echo '<a onClick="show_input_customerName()" value="">직접입력</a>';
             //KI2 20210208
            foreach ($customer as $val) {
              if (strtotime(date("Y-m-d")) > strtotime(date($val['maintain_end']))) {
                echo '<a style="color:red;" ';
                echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['maintain_seq'].','.$val['forcasting_seq'].')" >' . $val['customer'].' - '.$val['project_name'].'</a>';
              } else {
                echo '<a ';
                echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['maintain_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.$val['project_name'].'</a>';
              }
            }
            echo "'";
            ?>
          );
        }
        var myDropdown = $("#" + id).parent().find('div').attr('id');
        $("#myDropdown").toggle();
        $(".searchInput").focus();
      }

      //고객사 선택
      function clickCustomerName(customerName, maintainEnd, seq , forcasting_seq) {
        //KI1 20210208
        $('#customerName').attr('readonly',true);
        $('#project').attr('readonly',true);
        $('#tech_report').val('N');
        //KI2 20210208

        var customerCompanyName = ($(customerName).text()).split(' - ')[0];
        var projectName = ($(customerName).text()).split(' - ')[1];
        $("#customerName").val(customerCompanyName);
        $("#project").val(projectName);
        $("#customer").val(seq);
        $("#forcasting_seq").val(forcasting_seq);

        if($("#workname").val() != "납품설치" && $("#workname").val() != "미팅" && $("#workname").val() != "데모(BMT)지원" ){
          // alert('here?');
          test3(document.cform.customer.value,'maintain');
          if (<?php echo strtotime(date("Y-m-d")) ?> > maintainEnd) {
            $("#customer").val('');
            $("#customerName").val('');
            $("#project").val('');
          }
        }else{
          test3(document.cform.customer.value,'forcasting');
        }
        $("#myDropdown").toggle();
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
        var popup = window.open('/index.php/tech/tech_board/search_manager?name=' + name+'&mode='+mode, '_blank');
        window.focus();
      }

      // 외부영역 클릭 시 팝업 닫기
      $(document).mouseup(function (e){
        var LayerPopup = $("#dropdown");
        if(LayerPopup.has(e.target).length === 0){
          $("#myDropdown").hide();
        }
      });

//KI1 20210208
      function show_input_customerName(){
        $('#customerName').attr('readonly',false);
        $('#project').attr('readonly',false);
        $('#customerName').css('border','2px solid');
        $('#customerName').css('border-color','black');
        $('#customerName').css('border-radius','5px');
        $('#customerName').val('');
        $('#project').val('');
        $('#forcasting_seq').val('');
        $('#maintain_seq').val('');
        $('#tech_report').val('Y');
        $("#myDropdown").toggle();
      }
//KI2 20210208

      // KI2 20210125
      function modify(mode){
        if(mode == 'report'){
          //KI1 20210125 입력시 빈칸이 있으면 넘어가지 않도록 조건제한
          if($('#startDay').val() == ''){
            alert('시작날짜를 입력해주세요.');
            $('#startDay').focus();
            return false;
          }
          if($('#endDay').val() == ''){
            alert('종료날짜를 입력해주세요.');
            $('#endDay').focus();
            return false;
          }
          if($('#workname').val() == ''){
            alert('작업구분을 입력해주세요.');
            $('#workname').focus();
            return false;
          }
          if($('#supportMethod').val() == ''){
            alert('지원방법을 입력해주세요.');
            $('#supportMethod').focus();
            return false;
          }
          if($('#customerName').val() == ''){
            alert('고객사를 선택해주세요.');
            $('#customerName').focus();
            return false;
          }
          if($('#participant').val() == ''){
            alert('참석자를 선택해주세요.');
            $('#participant').focus();
            return false;
          }
          //KI2 20210125
          var act = "<?php echo site_url();?>/tech/tech_board/tech_doc_input";
          $("#hiddenSeq").attr('action', act).submit();
        }else if(mode == 'modify'){

          var schedule_seq = $('#seq').val();
          sessionStorage.setItem("schedule_seq",schedule_seq);
          // var sessionSchSeq = sessionStorage.getItem("schedule_seq");
          $.ajax({
            type: "POST",
            url:"<?php echo site_url();?>/biz/schedule/tech_seq_find",
            dataType:"json",
            data:{
              schedule_seq:schedule_seq
            },
            success: function(data) {
              // alert(JSON.stringify(data ));
              // var obj = JSON.parse(data);
              // console.log(data[0]);
              var tech_doc_seq = data[0].seq;
              $('#seq').val(tech_doc_seq);
              $('#mode').val('view');
              $('#link').val('sch_modify');
              var act = "<?php echo site_url();?>/tech/tech_board/tech_doc_view";
              sessionStorage.setItem("schedule_detail","true");
              // console.log(act);
              $("#hiddenSeq").attr('action', act).submit();
            }
            });
        }else{
          //KI1 20210125 입력시 빈칸이 있으면 넘어가지 않도록 조건 제한
          if($('#startDay').val() == ''){
            alert('시작날짜를 입력해주세요.');
            $('#startDay').focus();
            return false;
          }
          if($('#endDay').val() == ''){
            alert('종료날짜를 입력해주세요.');
            $('#endDay').focus();
            return false;
          }
          if($('#workname').val() == ''){
            alert('작업구분을 입력해주세요.');
            $('#workname').focus();
            return false;
          }
          if($('#supportMethod').val() == ''){
            alert('지원방법을 입력해주세요.');
            $('#supportMethod').focus();
            return false;
          }
          if($('#customerName').val() == ''){
            alert('고객사를 선택해주세요.');
            $('#customerName').focus();
            return false;
          }
          if($('#participant').val() == ''){
            alert('참석자를 선택해주세요.');
            $('#participant').focus();
            return false;
          }
          //KI2 20210125

          var act = "<?php echo site_url();?>/biz/schedule/modify"
          $("#hiddenSeq").attr('action', act).submit();
        }
      }

      </script>
      <!-- //여기까지 -->
    </td>
  </tr>
  <!--하단-->

  </table>
  <?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
</html>
