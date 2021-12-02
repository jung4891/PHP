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
                           <td class="title3">서식함 관리</td>
                        </tr>
                        <!--타이틀-->
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                        <td>
                              <div style="background-color:#f8f8f9;padding:10px 10px 10px 10px;margin-bottom:30px;">
                                 서식함 생성 방법 : '추가 + ' 버튼 클릭 후 서식함명을 작성 후 ‘저장’ 버튼을 클릭합니다.. <br>
                                 서식함 수정 방법 : 수정할 서식함을 선택하고 우측에 표시되는 정보를 확인/수정한 후 ‘저장’ 버튼을 클릭합니다. <br>
                                 서식함 삭제 방법 : 삭제할 서식함을 선택하고 ‘삭제’ 버튼을 클릭합니다. <br>
                                 서식함 이동 방법 : 이동할 서식함함을 선택하여 Drag & Drop으로 이동할 수 있습니다.
                                 <br>
                              </div> 
                              <table class="basic_table" width="100%" height="100%" style="font-family:Noto Sans KR;font-size:13px;">
                                 <tr>
                                    <td width="30%" height="300" class="basic_td">
                                       <div class="sortable">
                                          <?php
                                             foreach($category as $ct){
                                                echo "<div class='category' value='{$ct['seq']}' onclick='modify(1,{$ct['seq']},".'"'.$ct['category_name'].'"'.")' style='cursor:pointer;'>{$ct['category_name']}</div>";
                                             } 
                                          ?>
                                       </div>
                                    </td>
                                    <td colspan="3" class="basic_td" style='position:relative;'>
                                       <div onclick='modify(0,0,"")' style='position:absolute;top:5px;right:15px;'>추가 <img src='<?php echo $misc;?>img/btn_add.jpg' style='vertical-align:middle'></div>
                                       <input type="hidden" id="save_type" name="save_type" value="" />
                                       <input type="hidden" id="category_seq" name="category_seq" value="" />
                                       <div id="category_name_input" style="display:none;"> 서식함명  : <input type="text" class="input2" id="category_name" name="category_name" value="" /></div>
                                    </td>
                                 </tr>
                              </table>
                              <div style='float:right;margin-top:20px;'>
                                 <input type="button" class="basicBtn" value="저장" style="width:61px;cursor:pointer;" onclick="categorySave(0);"/>
                                 <input type="button" class="basicBtn" value="삭제" style="width:61px;cursor:pointer;" onclick="categorySave(2);"/>  
                              </div>                
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
//sortable tr 상하이동
$(".sortable").sortable({
   update: function (event, ui) {
      if (confirm("변경된 순서를 저장하시겠습니까?")) {
         var result = false;
         for (i = 0; i < $(".category").length; i++) {
            var seq = $(".category").eq(i).attr('value');
            $.ajax({
               type: "POST",
               cache: false,
               url: "<?php echo site_url(); ?>/approval/format_category_modify",
               dataType: "json",
               async: false,
               data: {
                  type: 3,
                  seq: seq,
                  idx: i
               },
               success: function (data) {
                  if(data){
                     result = true;
                  }else{
                     result = false;
                  }
               }
            });
         }
         if(result){
            alert("변경되었습니다.");
            location.reload();
         }else{
            alert("변경 실패.");
         }
      }
   }
});

function modify(type,seq,category_name){
   $("#save_type").val(type);//수정
   $("#category_seq").val(seq);
   $("#category_name").val(category_name);
   $("#category_name_input").show();
}

function categorySave(type){
   if(type != 2){
      type = $("#save_type").val();
   }
   
   if(type == 0){ // 추가
      $.ajax({
         type: "POST",
         cache: false,
         url: "<?php echo site_url(); ?>/approval/format_category_modify",
         dataType: "json",
         async :false,
         data: {
            type:type,
            category_name:$("#category_name").val()
         },
         success: function (data) {
            if(data){
               alert("서식함명 추가 완료");
               location.reload();
            }else{
               alert("서식함명 추가 실패");
            }
         }
      });
   }else if (type == 1){//수정
      $.ajax({
         type: "POST",
         cache: false,
         url: "<?php echo site_url(); ?>/approval/format_category_modify",
         dataType: "json",
         async :false,
         data: {
            type:type,
            seq: $("#category_seq").val(),
            category_name:$("#category_name").val()
         },
         success: function (data) {
            if(data){
               alert("서식함명 수정 완료");
               location.reload();
            }else{
               alert("서식함명 수정 실패");
            }
         }
      });
   }else{//삭제
      if(confirm("서식함을 삭제하시겠습니까?")){
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/approval/format_category_modify",
            dataType: "json",
            async :false,
            data: {
               type:type,
               seq: $("#category_seq").val(),
            },
            success: function (data) {
               if(data){
                  alert("서식함 삭제 완료");
                  location.reload();
               }else{
                  alert("서식함 삭제 실패");
               }
            }
         });
      }
   }
   
}
</script>
</body>
</html>