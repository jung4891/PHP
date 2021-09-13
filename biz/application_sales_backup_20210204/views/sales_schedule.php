<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";

?>

<html>
  <head>

    <meta charset="utf-8">
    <title></title>

  </head>

  <!-- <script type="text/javascript" src="/misc/js/jquery-1.8.3.min"></script> -->
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


  <script>
  //오늘 날짜 가져오기
  let today = new Date();
  let year = today.getFullYear(); // 년도
  let month = today.getMonth() + 1;  // 월
  let date = today.getDate();  // 날짜
  let day = today.getDay();  // 요일
  var session_id ="<?php echo $session_id?>";
  sessionStorage.setItem('reload','false');

  document.addEventListener('DOMContentLoaded', function() {
      if(sessionStorage.getItem('workColor')!=null){
        $('#customPop').bPopup({follow:[false,false],position:["auto",0]});
      }
      sessionStorage.removeItem('workColor');

      checked_schedule();

      $('.demo').each( function() {
        $(this).minicolors({
          control: $(this).attr('data-control') || 'hue',
          defaultValue: $(this).attr('data-defaultValue') || '',
          format: $(this).attr('data-format') || 'hex',
          keywords: $(this).attr('data-keywords') || '',
          inline: $(this).attr('data-inline') === 'true',
          letterCase: $(this).attr('data-letterCase') || 'lowercase',
          opacity: $(this).attr('data-opacity'),
          position: $(this).attr('data-position') || 'bottom',
          swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
          change: function(value, opacity) {
            if( !value ) return;
            if( opacity ) value += ', ' + opacity;
            if( typeof console === 'object' ) {
              // console.log(value);
            }
          },
          theme: 'bootstrap'
        });

      });
    });

    $(".fc-prev-button").click(function() {
        alert(1);
      });

// <h4><?php date("Y-n-j");?></h4>

  </script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
  <tr>
    <td align="center" valign="top">
      <!-- //여기부터 -->

      <!-- 일정 추가 팝업 -->
        <div id='addpopup' style="display: none; background-color: white; width: 530px; height: 570px;">
          <table>
            <thead align="center">
                <h2>일정등록</h2>

            </thead>
            <tbody align="left">

            <tbody>
              <tr>
                <td>
                  기&nbsp;&nbsp;&nbsp;간
                </td>
                <td>
                 <input type="text" name="startDay" id="startDay" size="7" value="" autocomplete="off">
                 <input type="button" name="" id="startBtn" class="dateBtn" value=" " onclick="openStartDate();">
                 <input type="text" name="startTime" id="startTime" size="2" value="" autocomplete="off"> ~
                 <!-- <input type="button" name="" id="startTimeBtn" class="timeBtn" value=" " onclick=""> ~ -->
                 <input type="text" name="endDay" id="endDay" size="7" value="" autocomplete="off">
                 <input type="button" name="" id="endBtn" class="dateBtn" value=" " onclick="openEndDate();">
                 <input type="text" name="endTime" id="endTime" size="2" value="" autocomplete="off">
                 <!-- <input type="button" name="" id="endTimeBtn" class="timeBtn" value=" " onclick=""> -->
                 <label><input type="checkbox" name="alldayCheck" value="" onChange="hideTime();">종일</label>
                </td>
              </tr>
              <tr>
                <td>제목</td>
                <td>
                  <input type="text" name="title" id="title" value="" placeholder="제목" size='40' multiple="multiple">
                </td>
              </tr>
              <tr>
                <td>참석자</td>
                <td>
                  <input type="text" name="participant" id="participant" value="<?php echo $name; ?>" placeholder="" size='40' multiple="multiple">
                  <button type="button" id="addUserBtn" name="addUserBtn" onclick="addUserBtn()">추가</button>
                  <!-- <select name="adduser" id='adduser'> -->
                    <!-- <option value=""></option> -->
<?php
// foreach ($select_user as $val) {
  // echo "<option value = '{$val->user_name}'>{$val->user_name}</option>";
// }
?>
                  <!-- </select> -->
                <!-- <button type="button" id="addUser" name="addUser" onclick="addUser();">추가</button> -->
                </td>
              </tr>
              <tr>
                <td>내&nbsp;&nbsp;&nbsp;용</td>
                <td>
                  <textarea cols="54" rows="22" name='contents' id="contents" placeholder="상세내용"></textarea>
                </td>
              </tr>
              <tr>
                <td>
                </td>
                <td>
                  <button type="button" name="scheduleAdd" id="scheduleAdd"  onclick="scheduleAdd();">등록</button>
                </td>
              </tr>

            </tbody>
          </table>
        </div>
<!-- 팝업 끝 -->

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
            <li><img src="/misc/img/btn_right2.jpg" id="insertUserBtn" class="btn" onclick="insertUser()"></li>
            <li><img src="/misc/img/btn_left2.jpg" id="insertUserBtn" class="btn" onclick="deleteUser()"></li>
            <li><img src="/misc/img/btn_return.jpg" id="insertUserBtn" class="btn" onclick="reset()"></li>
          </ul>
        </div>
        <div id="modal-participant">
          <ul id="insertParticipant">
          </ul>
        </div>
        <div id="btnDiv">
        <input type="button" style="float:right;" id="chosenBtn" name="" value="적용" onclick="addUser(this.id)">
        </div>
      </div>
    </div>
    <!-- 참여자 팝업 끝 -->

    <!-- 검색 참여자 팝업 추가 -->
    <div id="searchAddUserpopup">
      <span id="searchAddUserpopupCloseBtn" class="btn" onclick="searchCloseBtn()" style="margin:0% 0% 0% 96%; color:white;">X</span>
      <div id="search-modal-body">
        <div id="search-modal-grouptree">
          <div id="search-usertree">
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
        <div id="search-btnDiv">
        <input type="button" style="float:right;" id="searchChosenBtn" name="" value="적용" onclick="addUser(this.id)">
        </div>
      </div>
    </div>
        <!-- 검색 참여자 팝업 끝 -->

<!-- 색상 커스터미이징 팝업 -->

      <div id='customPop' style="display : none; background-color: white; width: 500px; height: 700px;">
        <h3 style="text-align:center; color:#aaa;">작업별 색상 설정</h3>
        <div class="well">
          <div class="row">
            <table id="workColor_tbl">
              <tbody style="width:100%">


<?php
foreach($work_color as $val){
  echo '<tr id="'.$val->seq.'" style="border-bottom: 30px solid #f5f5f5; width:100%; height:90%;">';
  echo '<td style="width:30%"><label for="hue-demo">'.$val->work_name.'</label>';
  echo '<input style="height:30px" type="text" name="work_color" class="form-control demo work_color" data-control="hue" value="'.$val->color.'" onchange="colorCustom(this);"/></td>';
  echo '<td style="width:30%"><label for="saturation-demo">글자색</label>';
  echo '<input style="height:30px" type="text" name="text_color" class="form-control demo text_color" data-control="saturation" value="'.$val->textColor.'" onchange="colorCustom(this);"/></td>';
  echo '<td style="width:30%"><label for="saturation-demo">출력</label>';
  echo '<input type="text" class="form-control printDemo" data-control="saturation" value="'.$val->work_name.'" style="background-color:'.$val->color.'; color:'.$val->textColor.'; height:30px"/></td></tr>';
}
 ?>
            </tbody>
          </table>
          <button style="float:right" type="button" class="btn" name="button" onclick="save_workColor_close();">닫기</button>
          <button style="float:right" type="button" class="btn" name="button" onclick="save_workColor();">저장</button>

          </div>
        </div>
      </div>
<!-- 색상 커스터미이징 팝업 끝-->

<!-- 기술지원보고서 알림 팝업 시작 -->
<!-- <div id="unwrittenpopup" >
  <a href="#" style="margin:0% 0% 0% 96%;"><span id="unwrittenpopupCloseBtn" onclick="report_closeBtn()"><span style="color:black;">X</span></span></a>
  <input type="hidden" id="session_name" value= "<?php echo $session_name?>"/>
</div> -->
<!-- 기술지원보고서 알림 팝업 끝 -->
      <div id='updateform' style="display: none; background-color: white; width: 450px; height: 500px;">
        <form name="hiddenSeq" action="<?php echo site_url();?>/schedule/sales_schedule_detail" method="post">
          <input type="text" name="hiddenSeq" id="hiddenSeq" value="">
          <input type="text" id="login_pgroup" name="login_pgroup" value= "<?php echo $pGroupName?>"/>
          <input type="text" id="login_group" name="login_group" value= "<?php echo $login_group?>"/>
          <input type="text" id="login_user_duty" name="login_user_duty" value= "<?php echo $login_user_duty?>"/>
          <input type="submit" name="seqBtn" id="seqBtn" >
        </form>
        <input type="text" id="session_id" value= "<?php echo $session_id?>"/>
      </div>

      <div id="body_contain">
      <div id="sd_contain">
        <div id="scheduleTop">
              <button <?php if($session_id!='kkj'){echo 'style="display:none;"';} ?> type="button" name="button" onclick="customPop();" class="fc-addSchedule-button fc-button fc-button-primary">색상 설정</button>
              <form id="searchWord" method="POST">
                <br>
                <div class="searchbox searchDiv" id="searchDiv">
                  <select class="" id="searchSelect" style="height:22px;"  onchange="searchSelFunc()">
                    <option value="participant">참석자</option>
                    <option value="user_name">등록자</option>
                    <option value="work_name">구분</option>
                    <option value="support_method">지원방법</option>
                    <option value="customer">고객사</option>
                    <option value="contents">내용</option>
                  </select>
                </div>
                <div class="searchbox changeDiv" id="changeDiv">
                  <input type="text" id="searchText" name="" value="" placeholder="검색어를 입력하세요." autocomplete="off" onfocus="onFoc(this.id)" onClick="searchAddUserBtn()" readonly>
                  <!-- onkeyup="this.value = onlyKor(this.value);"  -->
                  <!-- onkeyup="onlyKor(this);" -->
                  <!-- style="width: 270px;" -->
                  <img src="/misc/img/participant_add.jpg" id="selectParticipantBtn" class="btn" style="width:25px; height:25px; vertical-align:middle;" onclick="searchAddUserBtn()">
                </div>
                <div class="searchbox changeDiv2" id="changeDiv2" style="display:none;">
                  <select class="" id="work_nameSelect" style="height:22px;" onfocus="onFoc(this.id)" >
                    <!-- style="width: 275px;" -->
                    <option value="" selected disabled hidden>선택하세요</option>
                    <?php
                      foreach ($work_name as $val2) {
                        echo "<option value = '{$val2->work_name}'>{$val2->work_name}</option>";
                      }
                    ?>
                </select>
                </div>
                <div class="searchbox changeDiv3" id="changeDiv3" style="display:none;">
                  <select class="" id="support_methodSelect" style="height:22px;" onfocus="onFoc(this.id)" >
                    <!-- style="width: 275px;" -->
                    <option value="" selected disabled hidden>선택하세요</option>
                    <option value="현장지원">현장지원</option>
                    <option value="원격지원">원격지원</option>
                  </select>
                </div>
                <div class="searchbox changeDiv4" id="changeDiv4" style="display:none;">
                  <select class="" id="customerSelect" style="height:22px;" onfocus="onFoc(this.id)">
                    <option value="" selected disabled hidden>선택하세요</option>
                    <?php
                    foreach ($customer as $val) {
                      echo "<option value = '{$val->customer}'>{$val->customer}</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="searchbox searchBtnDiv" id="searchBtnDiv">
                  <button type="button" name="submit" id="searchBtn" style="height:23px; text-align:middle;" onclick="func_search()">검색</button>
                  <input class="btn-primary" type="submit" id="searchReset" style="display:none" onclick="list_search()" value="초기화">
                  <button type="button" name="button" onclick="excelExport();" class="fc-addSchedule-button fc-button fc-button-primary" id="excelDownload" style="display:none;">엑셀 다운</button>
              </div>
            </form><br><br>
          <script text='text/javascript'>
          // function func_search(){
          //   var searchOpt = $('#searchSelect').val();
          //   if($('#searchText').val() != ''){
          //     var segment = $('#searchText').val();
          //   }else if($('#work_nameSelect').val() != ''){
          //     var segment = $('#work_nameSelect').val();
          //   }else if($('#support_methodSelect').val() != ''){
          //     var segment = $('#support_methodSelect').val();
          //   }else if ($('#customerSelect').val() != '') {
          //     var segment = $('#customerSelect').val();
          //   }else{
          //     alert('검색어를 입력하세요.');
          //     stopPropagation();
          //   }
          //   var act = "<?php echo site_url();?>/schedule/tech_schedule?search_target="+searchOpt+"&search_keyword="+segment;
          // 	$("#searchWord").attr('action', act).submit();
          // }
          function list_search(){
        	   var act = "<?php echo site_url();?>/schedule/sales_schedule";
	          $("#searchWord").attr('action', act).submit();
          }
          // $(function(){
          //   if($('#searchSelect').val() == 'participant'){
          //     $('#searchText').attr("readonly",true);
          //     $('#searchText').attr("onClick","searchAddUserBtn()");
          //   }
            // <?php
            // if($listview == 'true'){
            //   ?>
            //   $('#excelDownload').show();
            //   $('#searchReset').show();
            // <?php
            // }
            // ?>
          });
          </script>
        </div>
        <div id="scheduleSidebar" style="text-align: left;">
          <h2>sidebar</h2>
          <!-- @@ ↓ -->

          <div id="tree">
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
          <!-- @@ ↑ -->
        </div>
        <div id='calendar'></div>
        </div>
      </div>

      </div>
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