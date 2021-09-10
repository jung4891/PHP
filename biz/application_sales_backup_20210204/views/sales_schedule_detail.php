<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";

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
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
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
              <a href="<?php echo site_url();?>/schedule/sales_schedule">돌아가기</a>
            </li>

            <div id = 'updateSchedule'>
            <table>
            <thead>
              <tr>
                <td>
                  <form name="hiddenSeq" action="<?php echo site_url();?>/schedule/modify" method="post">
                  <input type="hidden" name="seq" id="seq" value="<?php echo $details->seq?>">
                </td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  기&nbsp;&nbsp;&nbsp;간
                </td>
<?php
$check = ($details->start_time == '00:00:00' && $details->end_time == '00:00:00')?"checked":"";
?>
                <td>
                 <input type="text" name="startDay" id="startDay" size="7" value="<?php echo $details->start_day?>" autocomplete="off">
                 <input type="button" name="" id="startBtn" class="dateBtn" value=" " onclick="openStartDate();">
                 <input type="text" name="startTime" id="startTime" class="timeBtn" size="2" value="<?php echo $details->start_time?>" autocomplete="off">
                 <input type="button" name="" id="startTimeBtn" class="timeBtn" value=" " onclick=""> ~
                 <input type="text" name="endDay" id="endDay" size="7" value="<?php echo $details->end_day?>" autocomplete="off">
                 <input type="button" name="" id="endBtn" class="dateBtn" value=" " onclick="openEndDate();">
                 <input type="text" name="endTime" id="endTime" size="2" class="timeBtn" value="<?php echo $details->end_time?>" autocomplete="off">
                 <input type="button" name="" id="endTimeBtn" class="timeBtn" value=" " onclick="">
                 <label><input type="checkbox" id="alldayCheck" name="alldayCheck" value="" onChange="hideTime();" <?php echo $check;?>>종일</label>
                </td>
              </tr>
              <tr>
                <td>제&nbsp;&nbsp;&nbsp;목</td>
                <td><input type="text" name="title" id="title" value="<?php echo $details->title?>" placeholder="제목" size='45'></td>
              </tr>
              <tr>
                <td>구&nbsp;&nbsp;&nbsp;분</td>
                <td>
                  <select name="workname" id="workname">
                    <option value="">선택하세요</option>
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
                    <option value="">------------</option>
                    <option value="방문지원" <?php if($details->support_method =="방문지원"){echo "selected";}?>>방문지원</option>
                    <option value="원격지원" <?php if($details->support_method =="정기점검2"){echo "selected";}?>>원격지원</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>고객사</td>
                <td>
                  <select name="customer" id="customer" onmouseover="select2(this);" onchange="insertDirect(this);">
                    <option value=""></option>
                    <option value="직접입력">직접입력</option>
<?php
$selectCustomer = $details->customer;
foreach ($customer as $val) {
  $customer = $val->customer;
  $selected = ($customer == $selectCustomer)?"selected":"";
  echo "<option value = '{$customer}' {$selected}>{$customer}</option>";
}

?>
                  </select>
                    <input style="width:80%; border:solid 1px black; display:none;" type="text" name="insertDirect" id="insertDirect" class="insertDirect" value="">
                </td>
              </tr>
              <tr>
                <td>참석자</td>
                <td>
                  <input type="text" name="participant" id="participant" value="<?php echo $details->participant?>" placeholder="" size='45'>
                  <button type="button" id="addUserBtn2" name="addUserBtn2" onclick="addUserBtn()">추가</button>
                  <!-- <select name="adduser" id='adduser'>
                    <option value=""></option>
<?php
foreach ($select_user as $val) {
  echo "<option value = '{$val->user_name}'>{$val->user_name}</option>";
}
?>
                  </select>
                <button type="button" id="addUser" name="addUser" onclick="addUser();">추가</button> -->
                </td>
              </tr>
              <tr>
                <td>내&nbsp;&nbsp;&nbsp;용</td>
                <td>
                  <textarea cols="58" rows="25" name='contents' id="contents" placeholder="상세내용"><?php echo $details->contents?></textarea>
                </td>
              </tr>
              <tr>
                <td>
                </td>
                <td>
                  <input type="submit" name="updateSubmit" id="updateSubmit" value="수정">
                  <input type="submit" name="delSubmit" id="delSubmit" value="삭제">
                </td>
              </tr>
              </tbody>
              </form>
            </table>
          </div>

        </div>

      </div>
      <!-- 참여자 팝업 추가 -->
      <div id="addUserpopup">
        <a href="#" style="margin:0% 0% 0% 96%;"><span id="addUserpopupCloseBtn" onclick="closeBtn()"><span style="color:white;">X</span></span></a>
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
          <div id="modal-btn">
              <ul class="kipark">
                <li><a href="#" onclick="insertUser()"><img src="/misc/img/btn_right2.jpg" id="insertUserBtn"></a></li>
                <li><a href="#" onclick="deleteUser()"><img src="/misc/img/btn_left2.jpg" id="insertUserBtn"></a></li>
                <li><a href="#" onclick="reset()"><img src="/misc/img/btn_return.jpg" id="insertUserBtn"></a></li>
              </ul>
            </div>
            <div id="modal-participant">
              <ul id="insertParticipant">
              </ul>
            </div>
            <div id="btnDiv">
            <input type="button" style="float:right;" id="chosenBtn" name="" value="적용" onclick="addUser()">
            </div>
          </div>
        </div>
        <!-- 참여자 팝업 끝 -->
      </div>
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

        $('#customer').change(function(){
          if($(this).val()=="직접입력"){
            // alert($(this).val());
            $('.insertDirect').show();
          }else{
            $('.insertDirect').hide();
          }
        });




      var register ="<?php echo $details->user_id?>";
      var regGroup ="<?php echo $details->group?>";
      var regPgruop ="<?php echo $details->p_group?>"

      var session_id ="<?php echo $id ?>";
      var login_gruop = "<?php  echo $login_gruop?>";
      var login_pgroup ="<?php  echo $login_pgroup?>";
      var login_user_duty ="<?php  echo $login_user_duty?>";

      if((register == session_id)||(login_user_duty=='팀장'&&login_gruop==regGroup)||(login_user_duty=='이사'&&login_pgroup==regPgruop)){
        $("#updateSchedule").find("input, select, button, textarea").prop("disabled", false);

      }else{
                $("#updateSchedule").find("input, select, button, textarea").prop("disabled", true);
      }

      if(login_pgroup!="기술본부"){
        $("#workname, #supportMethod, #customer").attr("disabled", true);
      }

      </script>
      <!-- //여기까지 -->
    </td>
  </tr>
  <!--하단-->
  <tr>
    <td align="center" height="100" bgcolor="#CCCCCC"><table width="1130" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img src="<?php echo $misc;?>img/f_ci.png"/></td>
        <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/customer_bottom.php"; ?></td>
        </tr>
        </table></td>
        </tr>
        </table>

        </body>
        </html>
