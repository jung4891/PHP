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

function list_search(){
   var act = "<?php echo site_url();?>/schedule/tech_schedule";
  $("#searchWord").attr('action', act).submit();
}


// KI1 20210125 고객사 포캐스팅형/유지보수형으로 변경에 적용되는 함수들
function searchFunction(id) {
  if($("#workname").val() == "납품설치" || $("#workname").val() == "미팅" || $("#workname").val() == "데모(BMT)지원" ){
    $("#dropdown_option").html(
      <?php
      echo "'";
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
  var customerCompanyName = ($(customerName).text()).split(' - ')[0];
  var projectName = ($(customerName).text()).split(' - ')[1];
  $("#customerName").val(customerCompanyName);
  $("#project").val(projectName);
  $("#customer").val(seq);
  $("#forcasting_seq").val(forcasting_seq);

  if($("#workname").val() != "납품설치" && $("#workname").val() != "미팅" && $("#workname").val() != "데모(BMT)지원" ){
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
  var popup = window.open('/index.php/tech_board/search_manager?name=' + name+'&mode='+mode, '_blank');
  window.focus();
}

// 외부영역 클릭 시 팝업 닫기
$(document).mouseup(function (e){
  var LayerPopup = $("#dropdown");
  if(LayerPopup.has(e.target).length === 0){
    $("#myDropdown").hide();
  }
});
// KI2 20210125
  </script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/tech_header.php";
?>
  <tr>
    <td align="center" valign="top">
      <!-- //여기부터 -->

      <!-- 일정 추가 팝업 -->
      <div id='addpopup' style="display: none; background-color: white; width: 530px; height: 570px;">
        <!-- KI1 20210125 고객사 담당자를 불러오기 위해 name=cform으로 적용-->
        <form name="cform" id="cform" action="<?php echo site_url();?>/schedule/add_schedule" method="post">
        <!-- KI2 20210125 -->
          <table>
            <thead align="center">
                <h2>일정등록</h2>

            </thead>
            <tbody align="left">
              <!-- KI1 20210125 고객사 담당자 적용을 위한 hidden input 적용, 프로젝트 input 추가 -->
              <input type="hidden" name="customer_manager" id="customer_manager" class="input2">
              <input type="hidden" name="maintain_end" id="maintain_end" class="input2">

              <input type="hidden" id="row_max_index" name="row_max_index" value="0" />
              <input type="hidden" id="customer_tmp" name="customer_tmp" value="" />
              <!-- ↑customerName과 동일 -->
              <input type="hidden" id="forcasting_seq" name="forcasting_seq" value="" />
              <input type="hidden" id="maintain_seq" name="maintain_seq" value="" />
              <!-- <input type="hidden" id="checkListForm" name="checkListForm" value="" /> -->
              <tr>
                <td>
                  기&nbsp;&nbsp;&nbsp;간
                </td>
                <td>
                 <input type="text" name="startDay" id="startDay" size="7" value="" autocomplete="off">
                 <input type="button" name="" id="startBtn" class="dateBtn" value=" " onclick="openStartDate();">
                 <input type="text" name="startTime" id="startTime" size="2" value="" autocomplete="off"> ~
                 <input type="text" name="endDay" id="endDay" size="7" value="" autocomplete="off">
                 <input type="button" name="" id="endBtn" class="dateBtn" value=" " onclick="openEndDate();">
                 <input type="text" name="endTime" id="endTime" size="2" value="" autocomplete="off">
                 <label><input type="checkbox" name="alldayCheck" value="" onChange="hideTime();">종일</label>
                </td>
              </tr>
              <tr>
                <td>구&nbsp;&nbsp;&nbsp;분</td>
                <td>
                  <select name="workname" id="workname">
                    <option value="" selected disabled hidden>선택하세요</option>
<?php
foreach ($work_name as $val) {
  echo "<option value = '{$val->work_name}'>{$val->work_name}</option>";
}
?>
                  </select>
                  &nbsp;지원방법
                  <select name="supportMethod" id="supportMethod">
                    <option value="" selected disabled hidden>선택하세요</option>
                    <option value="현장지원">현장지원</option>
                    <option value="원격지원">원격지원</option>
                  </select>
                </td>

              </tr>
              <tr>
                <td>고객사</td>
                <!-- KI1 20210125 고객사를 포캐스팅형/유지보수형으로 변경-->
                <td >
                  <div class="dropdown" id="dropdown">
                    <p onclick="searchFunction(this.id)" id="dropbtn" class="dropbtn">검색</p>
                    <input id="customerName" name ="customerName" type="text" class="input5 " style="border:none;width:200px;font-weight:bold;text-align:center;" onchange="customerNameChange(this.value);" readonly>
                    <!-- forcasting_seq -->
                    <input type="hidden" id="customer" name="customer" value="" style="border:none" readonly>
                    <div id="myDropdown" class="dropdown-content">
                      <input type="text" name="0" placeholder="고객사를 입력하세요" id="searchInput" class="searchInput" onkeyup="filterFunction(this)" ;>
                      <div id="dropdown_option" style="overflow:scroll; width:277px; height:300px;">

                      </div>
                    </div>
                  </div>
                </td>
                <!-- KI2 20210125 -->
              </tr>
              <tr>
                <td>프로젝트명</td>
                <td>
                  <input type="text" id="project" name="project" value="" size='40' readonly>
                <td>
              </tr>
              <!-- KI2 20210125 -->
              <tr>
                <td>참석자</td>
                <td>
                  <input type="text" name="participant" id="participant" value="<?php echo $name; ?>" placeholder="" size='40' multiple="multiple">
                  <!-- KI1 20210125 참여자 추가버튼 이미지로 수정 -->
                  <input type="image" src="/misc/img/participant_add.jpg" name="addUserBtn" id="addUserBtn" class="btn" style="width:25px; height:25px; vertical-align:middle;" onclick="addUser_Btn();return false;">
                  <!-- KI2 20210125 -->
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
                  <!-- KI1 20210125 빈값이 있을 때 일정이 등록되지 않도록 onClick함수 추가-->
                  <button type="button" name="scheduleAdd" id="scheduleAdd" onclick="checkAll();">등록</button>
                  <!-- KI2 20210125 -->
                </td>
              </tr>

            </tbody>
          </table>
        </form>
      </div>
<!-- 팝업 끝 -->

<!-- KI1 20210125 참여자 추가 형태를 검색 참여자 추가 형태로 변경  -->
<!-- 참여자 팝업 추가 -->
<div id="addUserpopup">
  <span id="addUserpopupCloseBtn" class="btn" onclick="closeBtn()"style="margin:0% 0% 0% 96%; color:white;">X</span>
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
        <div id="btnDiv">
          <input type="button" style="float:right;" id="insertUserBtn" name="" value="적용" onclick="addUser(this.id)">
        </div>
      </div>
    </div>
    <!-- 참여자 팝업 끝 -->
    <!-- KI2 20210125 -->

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
<div id="unwrittenpopup" >
  <a style="margin:0% 0% 0% 96%;cursor:pointer;"><span id="unwrittenpopupCloseBtn" onclick="report_closeBtn()"><span style="color:black;">X</span></span></a>
  <input type="hidden" id="session_name" value= "<?php echo $session_name?>"/>
</div>
<!-- 기술지원보고서 알림 팝업 끝 -->
      <div id='updateform' style="display: none; background-color: white; width: 450px; height: 500px;">
        <form name="hiddenSeq" action="<?php echo site_url();?>/schedule/tech_schedule_detail" method="GET">
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
                  <select class="" id="customerSelect" style="height:22px;" onfocus="onFoc(this.id)" onmouseover="select2(this);">
                    <option value="" selected disabled hidden >선택하세요</option>
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
