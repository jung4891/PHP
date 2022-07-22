<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
   .basic_td{
      padding:0px 10px 0px 10px;
      border:1px solid;
      border-color:#d7d7d7;
   }
   .basic_table{
      border-collapse:collapse;
      border:1px solid;
      border-color:#d7d7d7;
   }

   .basic_table td{
      padding:0px 10px 0px 10px;
      border:1px solid;
      border-color:#d7d7d7;
   }

   .basicBtn2{
      cursor:pointer;
      height:31px;
      background-color:#fff;
      vertical-align:top;
      font-weight:bold;
      border : .5px solid;
   }
   ul{
      list-style:none;
      padding-left:0px;
   }

   li{
      list-style:none;
      padding-left:0px;
   }

</style>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<body>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php"; ?>
<input type="hidden" id="click_user_seq" name="click_user_seq" />
<!-- <form id="cform" name="cform" action="<?php echo site_url(); ?>/approval/electronic_approval_doc_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm('request');return false;"> -->
<div align="center">
  <div class="dash1-1">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
      <tbody>
        <tr height="5%">
          <td class="dash_title">
            <!-- img title -->
            결재선관리
          </td>
        </tr>
        <tr height="13%">
        </tr>
        <tr style="max-height:45%">
          <td colspan="2" valign="top" style="padding:10px 0px;">
            <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top">
                  <tr>
                    <td>
                      <div id="select_approval_modal" >
                               <div style="margin-top:40px;text-align:left;">
                                  <?php
                                  if(isset($_GET['seq'])){
                                     foreach($view_val as $val){
                                        if($val['seq'] == $_GET['seq']){
                                           $line_name = $val['approval_line_name'];
                                        }
                                     }
                                  }
                                  ?>
                                  &nbsp;&nbsp; 사용자 결재선명
                                  <input type="text" id="approval_line_name" name="approval_line_name" class="input-common" value= "<?php if(isset($_GET['seq'])){echo $line_name;} ?>" style="margin-left:15px;">
                                  <div style="float:right;">
                                     <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeModal();"/> -->
                                     <input type="button" class="btn-common btn-color1" value="삭제" onClick="closeModal();">
                                     <?php if(isset($_GET['seq'])){
                                        // echo "<img src='{$misc}img/dashboard/btn/btn_adjust.png' style='cursor:pointer;float:right;margin-top:5px;' border=0 onClick='user_approval_line_save(2);'/><br>";
                                        echo '<input type="button" class="btn-common btn-color2" value="수정" onclick="user_approval_line_save(2);">';
                                     }else{
                                        // echo "<img src='{$misc}img/dashboard/btn/btn_add.png' style='cursor:pointer;float:right;margin-top:5px;' border=0 onClick='user_approval_line_save(1);'/><br>";
                                        echo '<input type="button" class="btn-common btn-color2" value="수정" onclick="user_approval_line_save(1);">';
                                     }?>

                                  </div>
                               </div>
                               <div style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
                                  <!-- <input type="button" value="조직원 전체 선택" style="float:right;margin-bottom:5px;" onclick="select_user_add('all');" > -->
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
                                                    foreach ( $group_val as $parentGroup ) {
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
                                           결재방법
                                           <div>
                                              <input type="radio" name="approval_type" value="결재" checked />결재<br>
                                              <input type="radio" name="approval_type" value="합의" />합의<br><br>
                                              <img src="<?php echo $misc;?>img/btn_right.jpg" style="cursor:pointer;width:22px;height:22px;" border="0" onClick="approver_add();"/><br><br>
                                              <img src="<?php echo $misc;?>img/btn_left.jpg" style="cursor:pointer;width:22px;height:22px;" border="0" onClick="approver_del();"/><br><br>
                                           </div>
                                        </td>
                                        <td class ="basic_td" width="30%" align="center" style="position: relative;">
                                           <!-- <div style="background-color:#f8f8f9;margin-top:20px;text-align:left;position: absolute;top:5px;">
                                           &nbsp;&nbsp; 사용자 결재선
                                           <select id="select_user_approval_line" name="select_user_approval_line" class="input5" style="margin-left:15px;" onchange="click_user_approval_line();">
                                              <option value="">-- 선택 --</option>
                                              <?php
                                              if(!empty($user_approval_line)){
                                              foreach($user_approval_line as $ual){
                                                 echo "<option value='{$ual['seq']}'>{$ual['approval_line_name']}</option>";
                                              }}?>
                                           </select>
                                           <img src="<?php echo $misc;?>img/btn_delete.jpg" style="cursor:pointer;vertical-align:middle;width:50px;margin-left:15px;" border="0" onClick="user_approval_line_save();"/>
                                           </div> -->
                                           <table id="select_approver" width="90%" class="basic_table sortable">
                                              <!-- <tr bgcolor="f8f8f9">
                                                 <td height="30"></td>
                                                 <td height="30">결재</td>
                                                 <td height="30"><?php echo $name." ".$duty." ".$group; ?></td>
                                              </tr> -->
                                           </table>
                                        </td>
                                     </tr>
                                  </table>
                               </div>

                      </div>
                    </td>
                  </tr>
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
<!-- </form> -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script> -->
<script>
   <?php
   if(isset($_GET['seq'])){?>
      click_user_approval_line(<?php echo $_GET['seq']; ?>);
   <?php } ?>
   //사용자 선택
   // function select_user(s_id){
   //    $("#click_user").remove();
   //    $("#group_tree_modal").show();
   //    $("#select_user_id").val(s_id);
   //    if($("input[name="+$("#select_user_id").val()+"]").val() != ""){
   //       var select_user = ($("#"+$("#select_user_id").val()).val()).split(',');
   //       var txt = '';
   //       for(i=0; i<select_user.length; i++){
   //          txt += "<div class='select_user' onclick='click_user("+'"'+select_user[i]+'"'+",this)'>"+select_user[i]+"</div>";
   //       }
   //       $("#select_user").html(txt);
   //    }else{
   //       $("#select_user").html('');
   //    }
   // }

   //사용자 선택 저장
   function saveUserModal(){
      var txt ='';
      for(i=0; i <$(".select_user").length; i++){
         var val = $(".select_user").eq(i).text().split(' ');
         if(i == 0){
            txt += val[0]+" "+val[1];
         }else{
            txt += "," + val[0]+" "+val[1];
         }
         $("input[name="+$("#select_user_id").val()+"]").val(txt);
         $("#group_tree_modal").hide();
      }
   }


   //상위 그룹에서 하위 그룹 보기
   function viewMore(button){
   var parentGroup = (button.id).replace('Btn','');
   if($(button).attr("src")==="<?php echo $misc; ?>img/btn_add.jpg"){
      var src = "<?php echo $misc; ?>img/btn_del0.jpg";
      $.ajax({
         type: "POST",
         cache: false,
         url: "<?php echo site_url(); ?>/ajax/childGroup",
         dataType: "json",
         async: false,
         data: {
             parentGroup:parentGroup
         },
         success: function (data) {
            var text = '<ul id="'+parentGroup+'Group" class="'+parentGroup+'" >';
            for(i=0; i<data.length; i++){
                  text += '<li><ins>&nbsp;</ins><span style="cursor:pointer;" id="'+data[i].groupName+'" onclick="groupView(this)"><ins>&nbsp;</ins>'+data[i].groupName+'</span></li>';
            }
            text += '</ul>'
            //   $("#"+parentGroup).html($("#"+parentGroup).html()+text);
            $("#"+parentGroup).after(text);
         }
      });
   }else{
      var src = "<?php echo $misc; ?>img/btn_add.jpg";
      $("#"+parentGroup+"Group").hide();
      $("."+parentGroup).remove();
   }
   $("#"+parentGroup+"Btn").attr('src', src);
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
   function click_user(seq,name,obj){
      $(".click_user").css('background-color','');
      $(".select_user").css('background-color','');
      $(".select_approver").css('background-color','');
      $(".click_user").attr('id','');
      $(".select_user").attr('id','');
      $(".select_approver").attr('id','');
      $(obj).css('background-color','#f8f8f9');
      $(obj).attr('id','click_user');
      $("#click_user_seq").val(seq);
   }


   //user 추가
   function select_user_add(type){
      if(type == 'all'){
         var result = confirm("회사 내 전체 조직원을 선택하시겠습니까?");
         if(result){
            $.ajax({
               type: "POST",
               cache: false,
               url: "<?php echo site_url(); ?>/ajax/groupView",
               dataType: "json",
               async :false,
               data: {
                  group: 'all'
               },
               success: function (data) {
                  var html = '';
                  for (i = 0; i < data.length; i++) {
                     html += "<div class='select_user' onclick='click_user("+data[i].seq+'"'+data[i].user_name+'"'+",this)'>"+data[i].user_name+" "+data[i].user_duty+" "+data[i].user_group+"</div>";
                  }
                  $("#select_user").html(html);
               }
            });
         }else{
         return false;
         }
      }else{
         var duplicate_check = false;
         for(i=0; i<$(".select_user").length; i++){
            if($("#click_user").html() == $(".select_user").eq(i).text()){
               duplicate_check = true
            }
         }
         if(duplicate_check == true || $("#click_user").html() == undefined){
            return false;
         }else{
            var html = "<div class='select_user' onclick='click_user("+'"'+$("#click_user").html()+'"'+",this)'>"+$("#click_user").html()+"</div>";
            $("#select_user").html($("#select_user").html()+html);
         }
      }

   }

   //추가된 user 중에 삭제
   function select_user_del(type){
      if(type == "all"){
         $(".select_user").remove();
      }else{
         if($("#click_user").attr('class') == 'select_user'){
            $("#click_user").remove();
         }
      }
   }

   //사용자 선택 모달 닫아
   function closeModal(){
      var check = confirm("이 페이지에서 나가시겠습니까? 작성중인 내용은 저장 되지 않습니다.")
      if(check == true){
         window.history.back();
      }else{
         return false;
      }
   }

   function select_approval_modal(){
      $("#click_user").css('background-color','');
      $("#click_user").attr('id','');
      $("#select_approval_modal").show();
   }

   //결재선 추가
   function approver_add(){
      var duplicate_check = false;
      for(i=0; i<$(".select_approver").length; i++){
         if($(".select_approver").eq(i).html().indexOf($("#click_user").html())!= -1){
            duplicate_check = true
         }
      }

      var approval_type = $('input:radio[name=approval_type]:checked').val();

      if(duplicate_check == true || $("#click_user").html() == undefined){
         return false;
      }else{
         for(i=0; i < $("#select_approver").find($("td")).length; i++){
            if($("#select_approver").find($("td")).eq(i).html() == "최종"){
               $("#select_approver").find($("td")).eq(i).html("");
            }
         }
         var html = "<tr class='select_approver' onclick='click_user("+$("#click_user_seq").val()+',"'+$("#click_user").html()+'"'+",this)'>";
         html += "<td height=30>최종</td><td onclick='change_approval_type(this);' style='cursor:pointer;'>"+approval_type+"</td><td>"+$("#click_user").html()+"<input type='hidden' name='approval_line_seq' value='"+$("#click_user_seq").val()+"' /><input type='hidden' name='approval_line_type' value='"+approval_type+"' /></td>";
         html += "</tr>";
         $("#select_approver").html($("#select_approver").html()+html);
      }
   }

   //결재선 삭제
   function approver_del(){
      if($("#click_user").attr('class') == 'select_approver'){
         $("#click_user").remove();
         finalReferrer();
      }
   }

   //sortable tr 상하이동
   $(".sortable").sortable({
      start: function(event, ui) {
         finalReferrer();
      },
      stop: function(event, ui) {
         finalReferrer();
      },
   });

   //결재선 마지막 줄 최종으로 표시
   function finalReferrer(){
      for(i=0; i < $("#select_approver").find($("td")).length; i++){
         if($("#select_approver").find($("td")).eq(i).html() == "최종"){
            $("#select_approver").find($("td")).eq(i).html("");
         }else if(i == ($("#select_approver").find($("td")).length)-3){
            $("#select_approver").find($("td")).eq(i).html("최종");
         }
      }
   }

   //결재 <-> 합의 바꿔
   function change_approval_type(obj){
      var approval_line_type = $(obj).parent().find($("input[name=approval_line_type]"));
      if($(obj).html()=="결재"){
         $(obj).html("합의");
         approval_line_type.val("합의");
      }else{
         $(obj).html("결재");
         approval_line_type.val("결재");
      }
   }

   //사용자 결재선 저장
   function user_approval_line_save(type){
      if($("#approval_line_name").val() == ""){
         $("#approval_line_name").focus();
         alert("결재선명을 입력하세요");
         return false;
      }
      var approval_line_seq = '';
      var approval_line_type = '';
      for(i=0; i<$("input[name = approval_line_seq]").length; i++){
         approval_line_seq += ','+$("input[name=approval_line_seq]").eq(i).val();
         approval_line_type += ','+$("input[name=approval_line_type]").eq(i).val();
      }

      if(approval_line_seq != ""){
         approval_line_seq = approval_line_seq.replace(',','');
      }

      if(approval_line_type != ""){
         approval_line_type = approval_line_type.replace(',','');
      }
      if(type == 1){ // 등록
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/user_approval_line_save",
            dataType: "json",
            async :false,
            data: {
               type:type,
               approval_line_name: $("#approval_line_name").val(),
               approver_seq: approval_line_seq,
               approval_type: approval_line_type,
               user_id : "admin"
            },
            success: function (result) {
               if(result){
                  alert("결재선 저장되었습니다.");
                  location.href='<?php echo site_url(); ?>/biz/approval/electronic_approver_line_list';
               }else{
                  alert("결재선 저장에 실패하였습니다.");
               }
            }
         });
      }else{ //수정
         <?php if(isset($_GET['seq'])){?>
            $.ajax({
               type: "POST",
               cache: false,
               url: "<?php echo site_url(); ?>/biz/approval/user_approval_line_save",
               dataType: "json",
               async :false,
               data: {
                  type: type,
                  seq: <?php echo $_GET['seq'] ;?>,
                  approval_line_name: $("#approval_line_name").val(),
                  approver_seq: approval_line_seq,
                  approval_type: approval_line_type,
                  user_id : "admin"
               },
               success: function (result) {
                  if(result){
                     alert("결재선 저장되었습니다.");
                     location.href='<?php echo site_url(); ?>/biz/approval/electronic_approver_line_list';
                  }else{
                     alert("결재선 저장에 실패하였습니다.");
                  }
               }
            });
         <?php }?>
      }
   }

    //사용자 결재선 선택
    function click_user_approval_line(seq){
      $("#select_approver").html("");
      var select_seq = seq
      var approver_seq ="";
      var approval_type ="";
      <?php
         if(empty($view_val) != true){
            foreach($view_val as $ual){ ?>
               if("<?php echo $ual['seq']; ?>" == select_seq){
                  approver_seq = "<?php echo $ual['approver_seq'];?>";
                  approval_type= "<?php echo $ual['approval_type'];?>";
               }
      <?php }
       } ?>

      approver_seq = approver_seq.split(',');
      approval_type = approval_type.split(',');
      for(i=0; i<approver_seq.length; i++){
         var html = '';
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/user_approval_line_approver",
            dataType: "json",
            async :false,
            data: {
               user_seq: approver_seq[i]
            },
            success: function (data) {
               html += "<tr class='select_approver' onclick='click_user("+data['seq']+',"'+data['user_name']+' '+data['user_duty']+' '+data['user_group']+'"'+",this)'>";
               html += "<td height=30></td><td onclick='change_approval_type(this);' style='cursor:pointer;'>"+approval_type[i]+"</td><td>"+data['user_name']+' '+data['user_duty']+' '+data['user_group']+"<input type='hidden' name='approval_line_seq' value='"+data['seq']+"' /><input type='hidden' name='approval_line_type' value='"+approval_type[i]+"' /></td>";
               html += "</tr>";
               $("#select_approver").html($("#select_approver").html()+html);
            }
         });
      }
      finalReferrer();
   }

   //취소버튼
   function cancel(){
      if(confirm("이 페이지에서 나가시겠습니까? 작성중인 내용은 저장 되지 않습니다.")){
         location.href='<?php echo site_url(); ?>/biz/approval/electronic_approver_line_list';
      }else{
         return false;
      }
   }
</script>
</body>
</html>
