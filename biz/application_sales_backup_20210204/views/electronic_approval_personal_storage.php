<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
   .basic_td{
      border:1px solid;
      border-color:#d7d7d7;
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

   ul{
      list-style:none;
      padding-left:0px;
   }

   li{
      list-style:none;
      padding-left:0px;
   }


</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet"> 
  
<script>
</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <input type="hidden" id="seq" name="seq" value="">
      <?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php"; ?>
      <tr>
         <td align="center" valign="top">
            <table width="90%" height="100%" cellspacing="0" cellpadding="0">
               <tr>
                  <td width="100%" align="center" valign="top">
                     <!--내용-->
                     <table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
                        <!--타이틀-->
                        <tr>
                           <td class="title3">개인보관함 관리</td>
                        </tr>
                        <!--타이틀-->
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                           <!-- 내용 -->
                           <td>
                              <div style="background-color:#f8f8f9;padding:10px 10px 10px 10px;margin-bottom:30px;">
                                 개인보관함 생성 방법 : 트리에서 상위 개인보관함을 선택하고 마우스 우측 버튼을 클릭하여 '추가' 메뉴를 선택합니다. <br>
                                 개인보관함 수정 방법 : 트리에서 수정할 개인보관함을 선택하고 우측에 표시되는 정보를 확인/수정한 후 ‘저장’ 버튼을 클릭합니다. <br>
                                 개인보관함 삭제 방법 : 트리에서 삭제할 개인보관함을 선택하고 마우스 우측 버튼을 클릭하여 ‘삭제’메뉴를 선택합니다. <br>
                                 <!-- 개인보관함 이동 방법 : 트리에서 이동할 개인보관함을 선택하여 Drag & Drop으로 이동할 수 있습니다. *아직 미완성* -->
                              </div> 
                              <table class="basic_table" width="100%" height="100%" style="font-family:Noto Sans KR">
                                 <tr>
                                    <td width="30%" height="300" class="basic_td">
                                       <div>
                                          <ul>
                                             <li>
                                                <span style="cursor:pointer;" id="category" onmousedown="rightClick(event,'category')">
                                                   CATEGORY
                                                </span>
                                                <table class="basic_table">
                                                   <tr><td class="basic_td categoryBtn" onclick="storageBtn(1,0,'');" style="cursor:pointer;display:none;width:120px;">추가</td></tr>
                                                </table>
                                                <ul>
                                                   <?php
                                                   if(!empty($view_val)){
                                                      foreach($view_val as $val){
                                                         if($val['parent_id'] == 0 && $val['cnt'] == 0){ ?>
                                                            <div id="<?php echo $val['storage_name']; ?>">
                                                               <li onmousedown="rightClick(event,'<?php echo $val['storage_name']; ?>')">
                                                                  <ins>&nbsp;</ins>
                                                                  <span style="cursor:pointer;" id="" onclick=""><ins>&nbsp;</ins>&nbsp;&nbsp;<?php echo $val['storage_name']; ?></span>
                                                               </li>
                                                               <table class="basic_table">
                                                                  <tr><td class="basic_td <?php echo $val['storage_name']; ?>Btn" onclick="storageBtn(1,<?php echo $val['seq']; ?>,'');" style="cursor:pointer;display:none;width:120px;">추가</td></tr>
                                                                  <tr><td class="basic_td <?php echo $val['storage_name']; ?>Btn" onclick="storageBtn(2,<?php echo $val['seq']; ?>,'<?php echo $val['storage_name']; ?>');" style="cursor:pointer;display:none;width:120px;">수정</td></tr>
                                                                  <tr><td class="basic_td <?php echo $val['storage_name']; ?>Btn" onclick="storageBtn(3,<?php echo $val['seq']; ?>,'');" style="cursor:pointer;display:none;width:120px;">삭제</td></tr>
                                                               </table>
                                                            </div>
                                                      <?php 
                                                         }else if($val['parent_id'] == 0 && $val['cnt'] > 0){ ?>
                                                            <div id="<?php echo $val['storage_name']; ?>" >
                                                               <li onmousedown="rightClick(event,'<?php echo $val['storage_name']; ?>')">
                                                                  <img src="<?php echo $misc; ?>img/btn_add.jpg" class="Btn" width="13" style="cursor:pointer;" onclick="viewMore('<?php echo $val['seq']; ?>','<?php echo $val['storage_name']; ?>',this)">
                                                                  <span style="cursor:pointer;" id="" onclick=""><?php echo $val['storage_name']; ?></span>
                                                               </li>
                                                               <table class="basic_table">
                                                                  <tr><td class="basic_td <?php echo $val['storage_name']; ?>Btn" onclick="storageBtn(1,<?php echo $val['seq']; ?>,'');" style="cursor:pointer;display:none;width:120px;">추가</td></tr>
                                                                  <tr><td class="basic_td <?php echo $val['storage_name']; ?>Btn" onclick="storageBtn(2,<?php echo $val['seq']; ?>,'<?php echo $val['storage_name']; ?>');" style="cursor:pointer;display:none;width:120px;">수정</td></tr>
                                                                  <tr><td class="basic_td <?php echo $val['storage_name']; ?>Btn" onclick="storageBtn(3,<?php echo $val['seq']; ?>,'');" style="cursor:pointer;display:none;width:120px;">삭제</td></tr>
                                                               </table>
                                                         </div>
                                                      <?php
                                                         }
                                                      } 
                                                   } 
                                                   ?>
                                                </ul>
                                             </li>
                                          </ul>
                                       </div>
                                    </td>
                                    <td colspan="3" class="basic_td">
                                       <input type="hidden" id="save_type" name="save_type" value="" />
                                       <input type="hidden" id="storage_seq" name="storage_seq" value="" />
                                       <input type="hidden" id="parent_id"  name="parent_id" value="" />
                                       <div id="storage_name_input" style="display:none;">보관함명  : <input type="text" class="input2" id="storage_name" name="storage_name" value="" /></div>
                                    </td>
                                 </tr>
                              </table>
                              <input type="button" class="basicBtn" value="저장" style="width:61px;cursor:pointer;float:right;margin-top:20px;" onclick="storageSave();"/>                          
                           </td>
                           <!--내용-->
                        </tr>
                     </table>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
      <!--하단-->
      <tr>
         <td align="center" height="100" bgcolor="#CCCCCC">
            <table width="1130" cellspacing="0" cellpadding="0">
               <tr>
                  <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img
                        src="<?php echo $misc;?>img/f_ci.png" /></td>
                  <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?></td>
               </tr>
            </table>
         </td>
      </tr>
</table>
<script>
   //보관함 전체열어!!!!!!!!
   $(".Btn").trigger("click");


   //오른쪽 마우스 클릭
   function rightClick(e,id){
      // console.log(e)
      document.addEventListener('contextmenu', function() {
         event.preventDefault();
      });
      if ((e.button == 2) || (e.which == 3)) {
         $("."+id+"Btn").show();
      } else {
         $("."+id+"Btn").hide();
      }
   }

   //보관함 추가/수정/삭제버튼클릭
   function storageBtn(type,value,storage_name){
      if(type == 1){ //추가버튼 클뤽
         $("#save_type").val(type);
         $("#parent_id").val(value);
         $("#storage_name").val(storage_name);
         $("#storage_name_input").show();
      }else if(type == 2){ //수정버튼 클뤽
         $("#save_type").val(type);
         $("#storage_seq").val(value);
         $("#storage_name").val(storage_name);
         $("#storage_name_input").show();
      }else{
         $("#save_type").val(type);
         $("#storage_seq").val(value);
         $("#storage_name").val();
         storageSave()
         // $("#storage_name_input").show();
      }

   }

   //보관함 추가/수정/삭제
   function storageSave(){
      var t = $("#save_type").val();
      if( t == 1 ) { // 추가
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/approval/storageSave",
            dataType: "json",
            async :false,
            data: {
               type : t,
               storage_name: $("#storage_name").val(),
               parent_id: $("#parent_id").val()
            },
            success: function (result) {
               if(result){
                  alert("저장");
                  location.reload();
               }else{
                  alert("저장 실패");
               }
               
            }
         });
      }else if(t == 2){ // 수정
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/approval/storageSave",
            dataType: "json",
            async :false,
            data: {
               type : t,
               storage_name: $("#storage_name").val(),
               seq: $("#storage_seq").val()
            },
            success: function (result) {
               if(result){
                  alert("수정 완료");
                  location.reload();
               }else{
                  alert("수정 실패");
               }
            }
         });
      }else if(t == 3){ // 삭제
         alert($("#storage_seq").val());
         if (confirm("하위 보관함까지 모두 삭제됩니다. 삭제하시겠습니니까?")) {
            $.ajax({
               type: "POST",
               cache: false,
               url: "<?php echo site_url(); ?>/approval/storageSave",
               dataType: "json",
               async: false,
               data: {
                  type: t,
                  seq: $("#storage_seq").val()
               },
               success: function (result) {
                  if (result) {
                     alert("삭제 완료");
                     location.reload();
                  } else {
                     alert("삭제 실패");
                  }
               }
            });
         }
      }
   }

   //개인보관함 열기 +버튼 눌러서 하위 목록 보기
   function viewMore(seq,id,obj){
      var src = "<?php echo $misc; ?>img/btn_del0.jpg";
      $(obj).attr('src', src);
      console.log($(obj).attr('onclick'))
      $(obj).attr('onclick',"viewHide('"+id+"',this)"); 
      $.ajax({
         type: "POST",
         cache: false,
         url: "<?php echo site_url(); ?>/approval/storageView",
         dataType: "json",
         async :false,
         data: {
            seq:seq
         },
         success: function (result) {
            var html = "<ul style='margin-left:20px;'>";
            for(i=0; i<result.length; i++){
               if(result[i].cnt > 0){
                  html += "<div id='"+result[i].storage_name+"'>"
                  html += "<li onmousedown='rightClick(event,"+'"'+result[i].storage_name+'"'+");'>";
                  html += "<img src='<?php echo $misc; ?>img/btn_add.jpg' class='Btn' width='13' style='cursor:pointer;' onclick='viewMore("+result[i].seq+","+'"'+result[i].storage_name+'"'+",this)'>";
                  html += "<span style='cursor:pointer;' id='' onclick=''>"+result[i].storage_name+"</span></li>";
                  html += "<table class='basic_table'>";
                  html += "<tr><td class='basic_td "+result[i].storage_name+"Btn' onclick='storageBtn(1,"+result[i].seq+","+'""'+");' style='cursor:pointer;width:120px;display:none;'>추가</td></tr>";
                  html += "<tr><td class='basic_td "+result[i].storage_name+"Btn' onclick='storageBtn(2,"+result[i].seq+","+'"'+result[i].storage_name+'"'+");' style='cursor:pointer;width:120px;display:none;'>수정</td></tr>";
                  html += "<tr><td class='basic_td "+result[i].storage_name+"Btn' onclick='storageBtn(3,"+result[i].seq+","+'""'+");' style='cursor:pointer;width:120px;display:none;'>삭제</td></tr>";
                  html += "</table>";
                  html += "</div>";
               }else{
                  html += "<div id='"+result[i].storage_name+"'>"
                  html += "<li onmousedown='rightClick(event,"+'"'+result[i].storage_name+'"'+");'>";
                  html += "<ins>&nbsp;</ins>";
                  html += "<span style='cursor:pointer;' id='' onclick=''><ins>&nbsp;</ins>&nbsp;&nbsp;"+result[i].storage_name+"</span></li>";
                  html += "<table class='basic_table'>";
                  html += "<tr><td class='basic_td "+result[i].storage_name+"Btn' onclick='storageBtn(1,"+result[i].seq+","+'""'+");' style='cursor:pointer;width:120px;display:none;'>추가</td></tr>";
                  html += "<tr><td class='basic_td "+result[i].storage_name+"Btn' onclick='storageBtn(2,"+result[i].seq+","+'"'+result[i].storage_name+'"'+");' style='cursor:pointer;width:120px;display:none;'>수정</td></tr>";
                  html += "<tr><td class='basic_td "+result[i].storage_name+"Btn' onclick='storageBtn(3,"+result[i].seq+","+'""'+");' style='cursor:pointer;width:120px;display:none;'>삭제</td></tr>";
                  html += "</table>";   
                  html += "</div>";
               }
            }
            html += "</ul>"
            $("#"+id).html($("#"+id).html()+html);
            for(i=0; i<$("#"+id).find($("img")).length; i++){
               if($("#"+id).find($("img")).eq(i).attr('src') == '<?php echo $misc; ?>img/btn_add.jpg'){
                  $("#"+id).find($("img")).eq(i).trigger("click");
               }
            }
         }
      });
   }

   //개인보관함 숨기기
   function viewHide(id,obj){
      var src = "<?php echo $misc; ?>img/btn_add.jpg";
      $(obj).attr('src', src);
      $(obj).attr('onclick',"viewShow('"+id+"',this)"); 
      $("#"+id).find($("div")).hide();
   }

   //개인보관함 다시열어!
   function viewShow(id,obj){
      var src = "<?php echo $misc; ?>img/btn_del0.jpg";
      $(obj).attr('src', src);
      $(obj).attr('onclick',"viewHide('"+id+"',this)"); 
      $("#"+id).find($("div")).show();
   }

   
</script>
</body>
</html>