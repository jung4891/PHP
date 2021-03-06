<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
   .basic_td{
      /* border:1px solid; */
      /* border-color:#d7d7d7; */
      padding:0px 10px 0px 10px;
   }
   .basic_table{
      border-collapse:collapse;
      border:1px solid;
      border-color:#d7d7d7;

   }

   /* 모달 css */
   .searchModal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 10; /* Sit on top */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
      z-index: 1002;
   }
      /* Modal Content/Box */
   .search-modal-content {
      background-color: #fefefe;
      margin: 15% auto; /* 15% from the top and centered */
      padding: 20px;
      border: 1px solid #888;
      width: 70%; /* Could be more or less, depending on screen size */
      z-index: 1002;
   }

</style>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">

<script>
</script>
<body>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php"; ?>
<form name="cform" action="<?php echo site_url(); ?>/biz/approval/electronic_approval_delegation_management" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
   <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
</form>
<div align="center">
  <div class="dash1-1">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
      <tbody>
        <tr>
          <td class="dash_title">
            위임관리
          </td>
        </tr>
        <tr style="max-height:45%">
          <td colspan="2" valign="top" style="padding:10px 0px;">
            <table class="content_dash_tbl" style="border:none" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td style="float:right;">
                  <!-- <img src="<?php echo $misc; ?>img/dashboard/btn/btn_add.png" style="cursor:pointer;margin-top:70px;margin-bottom:10px;" onclick="delegation_save();"> -->
                  <input type="button" class="btn-common btn-color2" value="등록" style="cursor:pointer;margin-top:70px;margin-bottom:10px;" onclick="delegation_save();">
                </td>
              </tr>
              <tr>
                <td align="center" valign="top">
                  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
                        <!-- <input type="hidden" id="seq" name="seq" value=""> -->
                        <input type="hidden" id="select_user_id" name="select_user_id" value="">
                        <input type="hidden" id="click_user_seq" name="click_user_seq" value="">
                        <tr>
                           <td align="center" valign="top">
                             <!--내용-->
                                  <table class="list_tbl list" width="100%" style="font-family:Noto Sans KR" border="0" cellspacing="0" cellpadding="0">
                                    <colgroup>
                                      <col width="15%">
                                      <col width="15%">
                                      <col width="15%">
                                      <col width="15%">
                                    </colgroup>
                                     <tr class="row-color1">
                                        <th height=40 align="center" class="basic_td t_top"><span style="color:red"> * </span>위임할 대상부서</th>
                                        <th height=40 align="center" class="basic_td t_top"><span style="color:red"> * </span>위임기간</th>
                                        <th height=40 align="center" class="basic_td t_top"><span style="color:red"> * </span>수임자</td>
                                        <th height=40 align="center" class="basic_td t_top"><span style="color:red"> * </span>위임사유</th>
                                     </tr>
                                     <tr>
                                       <td height=40 class="basic_td" align="center">
                                         <?php echo $group; ?>
                                         <input type="hidden" id="delegate_group" name="delegate_group" value="<?php echo $group; ?>">
                                       </td>
                                        <td class="basic_td" align="center">
                                           <input id="start_date" name="start_date" type="date" class="input-common input-style1" style="width:120px"> ~ <input type="date" id="end_date" name="end_date" class="input-common input-style1" style="width:120px">
                                        </td>
                                        <td class="basic_td" align="center">
                                           <input type="text" id="mandatary" name="mandatary" class="input-common" onclick="select_user('mandatary');" onfocus="select_user('mandatary');"/>
                                           <input type="hidden" id="mandatary_seq" name="mandatary_seq" />
                                           <img src="<?php echo $misc;?>img/dashboard/dash_detail.png" style="cursor:pointer;vertical-align:middle;" border="0" onClick="select_user('mandatary');" width="20"/>
                                        </td>
                                        <td class="basic_td" align="center">
                                          <input type="text" id="delegation_reason" name="delegation_reason" class="input-common" style="width:410px">
                                        </td>
                                     </tr>
                                     <tr>
                                     </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td style="float:right;">
                                  <!-- <img src="<?php echo $misc; ?>img/dashboard/btn/btn_unset.png" style="cursor:pointer;margin-top:100px;" onclick="unset();"> -->
                                  <input type="button" class="btn-common btn-color5" value="설정해제" style="cursor:pointer;margin-top:100px;margin-bottom:10px;" onclick="unset();">
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <table class="list_tbl list" width="100%" style="font-family:Noto Sans KR;text-align:center;"  border="0" cellspacing="0" cellpadding="0">
                                     <tr class="row-color1">
                                        <th height="40px" class="basic_td t_top"><input type="checkbox" id='allCheck'></th>
                                        <th class="basic_td t_top">NO</th>
                                        <th class="basic_td t_top">위임할 대상부서</th>
                                        <th class="basic_td t_top">위임기간</th>
                                        <th class="basic_td t_top">수임자</th>
                                        <th class="basic_td t_top">위임사유</th>
                                        <th class="basic_td t_top">설정</th>
                                        <th class="basic_td t_top">결재내역</th>
                                     </tr>
                                     <?php
                                     if(empty($view_val) != true){
                                        $idx = $count-$start_row;
                                        for($i = $start_row; $i<$start_row+$end_row; $i++){
                                           if(!empty( $view_val[$i])){
                                              $val = $view_val[$i];

                                              echo "<tr>";
                                              echo "<td height='40px' class='basic_td'>";
                                              if($val['status'] == "Y"){
                                                 echo "<input type='checkbox' name='delegation_check' value='{$val['seq']}' />";
                                              }
                                              echo "</td>";
                                              echo "<td height='40px' class='basic_td'>{$idx}</td>";
                                              echo "<td height='40px' class='basic_td'>{$val['delegate_group']}</td>";
                                              echo "<td height='40px' class='basic_td'>{$val['start_date']} ~ {$val['end_date']}</td>";
                                              echo "<td height='40px' class='basic_td'>{$val['mandatary']}</td>";
                                              echo "<td height='40px' class='basic_td'>{$val['delegation_reason']}</td>";
                                              if($val['status'] == "Y"){
                                                 echo "<td height='40px' class='basic_td'>설정</td>";
                                              }else{
                                                 echo "<td height='40px' class='basic_td'>설정해제</td>";
                                              }?>
                                              <td height='40px' class='basic_td' onclick="detail_view(<?php echo $val['seq']; ?>,'<?php echo $val['mandatary']; ?>','<?php echo $val['start_date'].'~'.$val['end_date']; ?>','<?php echo $val['delegation_reason']; ?>');" style='cursor:pointer;'>상세보기</td>
                                              </tr>
                                              <?php
                                              $idx--;
                                           }
                                        }
                                     }else{
                                        echo "<tr align='center'><td height='40' colspan=8 class='basic_td'>검색 결과가 존재하지 않습니다.</td></tr>";
                                     }
                                     ?>
                                  </table>
                                </td>
                              </tr>
                            <!-- 페이징처리 -->
                            <tr>
                               <td align="center">
                               <?php if ($count > 0) {?>
                                     <table width="400" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px;">
                                           <tr>
                                     <?php
                                        if ($cur_page > 10){
                                     ?>
                                           <td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last_left.svg" width="20" height="20"/></a></td>
                                           <td width="2"></td>
                                           <td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_left.svg" width="20" /></a></td>
                                     <?php
                                        } else {
                                     ?>
                                        <td width="19"></td>
                                           <td width="2"></td>
                                           <td width="19"></td>
                                     <?php
                                        }
                                     ?>
                                           <td align="center">
                                        <?php
                                           for  ( $i = $start_page; $i <= $end_page ; $i++ ){
                                              if( $i == $end_page ) {
                                                 $strSection = "";
                                              } else {
                                                 $strSection = "&nbsp;<span class=\"section\">|</span>&nbsp;";
                                              }

                                              if  ( $i == $cur_page ) {
                                                 echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\"><font color=\"#33ccff\">".$i."</font></a>".$strSection;
                                              } else {
                                                 echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\">".$i."</a>".$strSection;
                                              }
                                           }
                                        ?></td>
                                           <?php
                                           if   ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
                                        ?>
                                        <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.svg" width="20"/></a></td>
                                           <td width="2"></td>
                                           <td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last_right.svg" width="20" /></a></td>
                                        <?php
                                           } else {
                                        ?>
                                        <td width="19"></td>
                                           <td width="2"></td>
                                           <td width="19"></td>
                                        <?php
                                           }
                                        ?>
                                           </tr>
                                        </table>
                               <?php }?>

                                     </td>
                               </tr>
                            <!-- 페이징처리끝 -->
                         <!--내용-->
                       </td>
                    </tr>
                  </table>
                  <!-- 모달시작@ -->
                  <div id="group_tree_modal" class="searchModal">
                     <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                        <h2>사용자 선택</h2>
                           <div style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
                              <table class="basic_table" style="width:100%;height:300px;vertical-align:middle;">
                                 <tr>
                                    <td class ="basic_td" width="30%">
                                       <div id="groupTree">
                                          <ul>
                                             <li>
                                             <span style="cursor:pointer;" id="all" onclick="groupView(this)">
                                                (주)두리안정보기술
                                             </span>
                                             <ul>
                                             <?php
                                             foreach ( $group_data as $parentGroup ) {
                                                if($parentGroup['childGroupNum'] <= 1){
                                                ?>
                                                   <li>
                                                      <ins>&nbsp;</ins>
                                                      <span style="cursor:pointer;" id="<?php echo $parentGroup['groupName'];?>" onclick="groupView(this)">
                                                      <ins>&nbsp;</ins>
                                                      <?php echo $parentGroup['groupName'];?>
                                                      </span>
                                                   </li>
                                                <?php
                                                }else{
                                                ?>
                                                   <li>
                                                      <img src="<?php echo $misc; ?>img/btn_add.jpg" id="<?php echo $parentGroup['groupName'];?>Btn" width="13" style="cursor:pointer;" onclick="viewMore(this)">
                                                      <span style="cursor:pointer;" id="<?php echo $parentGroup['groupName'];?>" onclick="groupView(this)">
                                                      <?php echo $parentGroup['groupName'];?>
                                                      </span>
                                                   </li>
                                                <?php
                                                }
                                             }
                                             ?>
                                             </ul>
                                             </li>
                                          </ul>
                                       </div>
                                    </td>
                                    <td class ="basic_td" width="30%" align="center">
                                       <div class="click_group_user"></div>
                                    </td>
                                    <td class ="basic_td" width="10%" align="center">
                                       <div id="user_select_delete">
                                          <img src="<?php echo $misc;?>img/btn_right.jpg" style="cursor:pointer;width:22px;height:22px;" border="0" onClick="select_user_add();"/><br><br>
                                          <img src="<?php echo $misc;?>img/btn_left.jpg" style="cursor:pointer;width:22px;height:22px;" border="0" onClick="select_user_del();"/><br><br>
                                          <img src="<?php echo $misc;?>img/btn_del.jpg" style="cursor:pointer;width:22px;height:22px;" border="0" onClick="select_user_del('all');"/>
                                       </div>
                                    </td>
                                    <td class ="basic_td" width="30%" align="center">
                                       <div id="select_user">
                                       </div>
                                    </td>
                                 </tr>
                              </table>
                           </div>
                           <div>
                              <img src="<?php echo $misc;?>img/btn_cancel.jpg" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeUserModal();"/>
                              <img src="<?php echo $misc;?>img/btn_ok.jpg" style="cursor:pointer;float:right;margin-top:5px;" border="0" onClick="saveUserModal();"/><br>
                           </div>
                     </div>
                  </div>
                  <!-- 상세보기 모달시작@ -->
                  <div id="detail_view_modal" class="searchModal">
                     <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                        <h2>결재내역</h2>
                           <div style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
                              <div style="text-align:left;">
                                 수임자 : <span id='detail_view_mendatary'></span><br>
                                 위임기간 : <span id='detail_view_date'></span> <br>
                                 위임 사유 : <span id='detail_view_reason'></span> <br>
                              </div>
                              <table id="detail_view_table" class="basic_table" style="width:100%;vertical-align:middle;margin-top:20px;">
                                 <tr bgcolor="f8f8f9">
                                    <td height="30" class ="basic_td">NO</td>
                                    <td class ="basic_td">서식함</td>
                                    <td class ="basic_td">유형</td>
                                    <td class ="basic_td">문서제목</td>
                                    <td class ="basic_td">기안자</td>
                                    <td class ="basic_td">기안일</td>
                                    <td class ="basic_td">문서상태</td>
                                 </tr>
                              </table>
                           </div>
                           <div>
                              <input type="button" class="basicBtn" value="닫기" style="width:61px;cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeModal();"/>
                              <!-- <img src="<?php echo $misc;?>img/btn_cancel.jpg" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeUserModal();"/> -->
                           </div>
                     </div>
                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<script>
 //사용자 선택
 function select_user(s_id) {
    $("#click_user").attr('id','');
    $("#group_tree_modal").show();
    $("#select_user_id").val(s_id);
    if ($("#" + $("#select_user_id").val()).val() != "") {
       var select_user = ($("#" + $("#select_user_id").val()).val()).split(',');
       var txt = '';
       for (i = 0; i < select_user.length; i++) {
          txt += "<div class='select_user' onclick='click_user(" + '"' + select_user[i] + '"' + ",this)'>" + select_user[i] + "</div>";
       }
       $("#select_user").html(txt);
    }
 }

 //사용자 선택 저장
 function saveUserModal() {
    var txt = '';
    for (i = 0; i < $(".select_user").length; i++) {
       var val = $(".select_user").eq(i).text().split(' ');
       if (i == 0) {
          txt += val[0] + " " + val[1];
       } else {
          txt += "," + val[0] + " " + val[1];
       }
       $("#" + $("#select_user_id").val()).val(txt);
       $("#group_tree_modal").hide();
    }
 }

 // groupView();

 //상위 그룹에서 하위 그룹 보기
 function viewMore(button) {
    var parentGroup = (button.id).replace('Btn', '');
    if ($(button).attr("src") === "<?php echo $misc; ?>img/btn_add.jpg") {
       var src = "<?php echo $misc; ?>img/btn_del0.jpg";
       $.ajax({
          type: "POST",
          cache: false,
          url: "<?php echo site_url(); ?>/ajax/childGroup",
          dataType: "json",
          async: false,
          data: {
             parentGroup: parentGroup
          },
          success: function (data) {
             var text = '<ul id="' + parentGroup + 'Group" class="' + parentGroup + '" >';
             for (i = 0; i < data.length; i++) {
                text += '<li><ins>&nbsp;</ins><span style="cursor:pointer;" id="' + data[i].groupName + '" onclick="groupView(this)"><ins>&nbsp;</ins>' + data[i].groupName + '</span></li>';
             }
             text += '</ul>'
             //   $("#"+parentGroup).html($("#"+parentGroup).html()+text);
             $("#" + parentGroup).after(text);

          }
       });
    } else {
       var src = "<?php echo $misc; ?>img/btn_add.jpg";
       $("#" + parentGroup + "Group").hide();
       $("." + parentGroup).remove();
    }
    $("#" + parentGroup + "Btn").attr('src', src);
 }

 //그룹 클릭했을 떄 해당하는 user 보여주기
 function groupView(group) {
    if (group == undefined) {
       var groupName = "all";
    } else {
       var groupName = $(group).attr("id");
    }

    $.ajax({
       type: "POST",
       cache: false,
       url: "<?php echo site_url(); ?>/ajax/groupView",
       dataType: "json",
       async: false,
       data: {
          group: groupName
       },
       success: function (data) {
          var txt = '';
          for (i = 0; i < data.length; i++) {
             txt += "<div class='click_user' onclick='click_user(" + data[i].seq + ',"' + data[i].user_name + '",this' + ");'>" + data[i].user_name + " " + data[i].user_duty + " " + data[i].user_group + "</div>";
          }
          $(".click_group_user").html(txt);
       }
    });
 }

 //user || approver 선택
 function click_user(seq, name, obj) {
    $(".click_user").css('background-color', '');
    $(".select_user").css('background-color', '');
    $(".select_approver").css('background-color', '');
    $(".click_user").attr('id', '');
    $(".select_user").attr('id', '');
    $(".select_approver").attr('id', '');
    $(obj).css('background-color', '#f8f8f9');
    $(obj).attr('id', 'click_user');
    $("#click_user_seq").val(seq);
 }

 //user 추가
 function select_user_add(type) {
    if (type == 'all') {
       var result = confirm("회사 내 전체 조직원을 선택하시겠습니까?");
       if (result) {
          $.ajax({
             type: "POST",
             cache: false,
             url: "<?php echo site_url(); ?>/ajax/groupView",
             dataType: "json",
             async: false,
             data: {
                group: 'all'
             },
             success: function (data) {
                var html = '';
                for (i = 0; i < data.length; i++) {
                   html += "<div class='select_user' onclick='click_user(" + data[i].seq + '"' + data[i].user_name + '"' + ",this)'>" + data[i].user_name + " " + data[i].user_duty + " " + data[i].user_group + "</div>";
                }
                $("#select_user").html(html);
             }
          });
       } else {
          return false;
       }
    } else {
       var duplicate_check = false;
       if ($(".select_user").length > 0) {
          alert("수임자는 한명만 선택 가능합니다.");
          return false;
       } else {
          for (i = 0; i < $(".select_user").length; i++) {
             if ($("#click_user").html() == $(".select_user").eq(i).text()) {
                duplicate_check = true
             }
          }
          if (duplicate_check == true || $("#click_user").html() == undefined) {
             return false;
          } else {
             var html = "<div class='select_user' onclick='click_user(-1," + '"' + $("#click_user").html() + '"' + ",this)'>" + $("#click_user").html() + "</div>";
             $("#select_user").html($("#select_user").html() + html);
             $("#mandatary_seq").val($("#click_user_seq").val());
          }
       }
    }
 }

 //추가된 user 중에 삭제
 function select_user_del(type) {
    if (type == "all") {
       $(".select_user").remove();
    } else {
       if ($("#click_user").attr('class') == 'select_user') {
          $("#click_user").remove();
       }
    }
 }

 //사용자 선택 모달 닫아
 function closeUserModal() {
    var check = confirm("이 페이지에서 나가시겠습니까? 작성중인 내용은 저장 되지 않습니다.")
    if (check == true) {
       $(".searchModal").hide();
    } else {
       return false;
    }
 }

 ////////////////////////////////////////////////////////////여기까지 사용자 관련함수////////////////////////////

 function delegation_save(){
   if($("#start_date").val() == ""){
      $("#start_date").focus();
      alert("위임기간을 선택해주세요");
      return false;
   }
   if($("#end_date").val() == ""){
      $("#end_date").focus();
      alert("위임기간을 선택해주세요");
      return false;
   }
   if($("#mandatary").val() == ""){
      $("#mandatary").focus();
      alert("수임자를 선택해주세요");
      return false;
   }
   if($("#delegation_reason").val() == ""){
      $("#delegation_reason").focus();
      alert("위임사유를 입력해주세요");
      return false;
   }

   var result = confirm("위임 하시겠습니까?");
       if (result) {
          $.ajax({
             type: "POST",
             cache: false,
             url: "<?php echo site_url(); ?>/biz/approval/delegation_save",
             dataType: "json",
             async: false,
             data: {
               delegate_group: $("#delegate_group").val(),
               start_date: $("#start_date").val(),
               end_date: $("#end_date").val(),
               mandatary:$("#mandatary").val(),
               mandatary_seq:$("#mandatary_seq").val(),
               delegation_reason:$("#delegation_reason").val()
             },
             success: function (result) {
               if(result){
                  alert("위임 저장 완료");
                  location.reload();
               }else{
                  alert("위임 저장 실패");
               }
             }
          });
      }
 }


 $(function () { //전체선택 체크박스 클릭
    $("#allCheck").click(function () { //만약 전체 선택 체크박스가 체크된상태일경우
       if ($("#allCheck").prop("checked")) { //해당화면에 전체 checkbox들을 체크해준다
          $("input[name=delegation_check]").prop("checked", true); // 전체선택 체크박스가 해제된 경우
       } else { //해당화면에 모든 checkbox들의 체크를해제시킨다.
          $("input[name=delegation_check]").prop("checked", false);
       }
    })
 })

//설정해제
 function unset(){
   var check_seq = '';
   $('input:checkbox[name="delegation_check"]').each(function() {
      if(this.checked == true){
         if(check_seq == "") {
            check_seq += this.value;
         }else{
            check_seq += "," +this.value;
         }
      }
   });

   if(check_seq != ""){
      $.ajax({
         type: "POST",
         cache: false,
         url: "<?php echo site_url(); ?>/biz/approval/delegation_unset",
         dataType: "json",
         async: false,
         data: {
            check_seq: check_seq
         },
         success: function (result) {
         if(result){
            alert("위임 설정해제 완료");
            location.reload();
         }else{
            alert("위임 설정해제 실패");
         }
         }
      });
   }
 }

//상세보기
function detail_view(seq,mendatary,date,reason){
   $("#detail_view_table").html('<tr bgcolor="f8f8f9"><td height="30" class ="basic_td">NO</td><td class ="basic_td">서식함</td><td class ="basic_td">유형</td><td class ="basic_td">문서제목</td><td class ="basic_td">기안자</td><td class ="basic_td">기안일</td><td class ="basic_td">문서상태</td></tr>');
   $('#detail_view_mendatary').html(mendatary);
   $('#detail_view_date').html(date);
   $('#detail_view_reason').html(reason);
   $.ajax({
      type: "POST",
      cache: false,
      url: "<?php echo site_url(); ?>/biz/approval/delegation_detail_view",
      dataType: "json",
      async: false,
      data: {
         seq: seq
      },
      success: function (data) {
         if(data){
            var html ='';
            for(i=0; i<data.length; i++){
               html += "<tr>";
               html += "<td height=30 class='basic_td'>"+(i+1)+"</td>";
               html += "<td class ='basic_td'>";
               <?php foreach($category as $format_categroy){ ?>
                  if(data[i].template_category == "<?php echo $format_categroy['seq'];?>"){
                     html += "<?php echo $format_categroy['category_name']; ?>";
                  }
                <?php } ?>
               html += "</td>";
               html += "<td class ='basic_td'>"+"유형"+"</td>";
               html += "<td class ='basic_td' onclick='doc_view("+data[i].seq+");' style='cursor:pointer;' >"+data[i].approval_doc_name+"</td>";
               html += "<td class ='basic_td'>"+data[i].writer_name+"</td>";
               html += "<td class ='basic_td'>"+data[i].write_date+"</td>";
               if(data[i].approval_doc_status == "001"){
                  html += "<td class ='basic_td'>진행중</td>";
               }else if(data[i].approval_doc_status == "002"){
                  html += "<td class ='basic_td'>완료</td>";
               }else if(data[i].approval_doc_status == "003"){"+data[i].approval_doc_status+"
                  html += "<td class ='basic_td'>반려</td>";
               }else if(data[i].approval_doc_status == "004"){
                  html += "<td class ='basic_td'>회수</td>";
               }else if(data[i].approval_doc_status == "005"){
                  html += "<td class ='basic_td'>임시저장</td>";
               }else if(data[i].approval_doc_status == "006"){
                  html += "<td class ='basic_td'>회수</td>";
               }else{
                  html += "<td class ='basic_td'></td>";
               }
               html += "</tr>";
            }
            $("#detail_view_table").html($("#detail_view_table").html()+html)
         }
         $("#detail_view_modal").show();
      }
   });
}

//모달 외부 클릭시 모달 close
$(document).mouseup(function (e) {
   var container = $('.searchModal');
   if (container.has(e.target).length === 0) {
      container.css('display', 'none');
   }
});

//사용자 선택 모달 닫아
function closeModal(){
   var check = confirm("이 페이지에서 나가시겠습니까? 작성중인 내용은 저장 되지 않습니다.")
   if(check == true){
      $(".searchModal").hide();
   }else{
      return false;
   }
}


//기안문보기
function doc_view(seq){
   window.open("<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_view?type=completion&seq="+seq, "popup_window", "width = 1200, height = 500, top = 100, left = 400, location = no,status=no,status=no,toolbar=no,scrollbars=no");
}

function GoFirstPage (){
      document.cform.cur_page.value = 1;
      document.cform.submit();
}

function GoPrevPage (){
   var	cur_start_page = <?php echo $cur_page;?>;

   document.cform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
   document.cform.submit( );
}

function GoPage(nPage){
   document.cform.cur_page.value = nPage;
   document.cform.submit();
}

function GoNextPage (){
   var	cur_start_page = <?php echo $cur_page;?>;

   document.cform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
   document.cform.submit();
}

function GoLastPage (){
   var	total_page = <?php echo $total_page;?>;
   document.cform.cur_page.value = total_page;
   document.cform.submit();
}
</script>
</body>
</html>
