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

   #icon_inf p {
     font-size: 14px;
     line-height: 0.7;
   }

   #icon_inf .title {
     font-weight: bold;
     font-size: 16px;
   }

   #icon_inf .content {
     color: #B0B0B0;
     padding-left: 10px;
     padding-bottom: 10px;
   }

</style>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">

<script>
</script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<body>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php"; ?>

<div align="center">
  <div class="dash1-1">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
      <tbody>
        <tr>
          <td class="dash_title">
            서식함관리
            <img style="cursor:pointer;vertical-align:middle;" src="/misc/img/dashboard/btn/btn_info.svg" width="25" onclick="open_inf(this);"/>
          </td>
        </tr>
        <tr>
          <td style="float:right;margin-top:30px;">
            <!-- <img src="<?php echo $misc; ?>img/dashboard/btn/btn_save.png" onclick="categorySave(0);" style="cursor:pointer"/>
            <img src="<?php echo $misc; ?>img/dashboard/btn/btn_delete.png" onclick="categorySave(2);" style="cursor:pointer"/> -->
            <input type="button" class="btn-common btn-color4" value="삭제" onclick="categorySave(2);" style="cursor:pointer;margin-right:10px;">
            <input type="button" class="btn-common btn-color2" value="저장" onclick="categorySave(0);" style="cursor:pointer">
          </td>
        </tr>
        <tr style="max-height:45%">
          <td colspan="2" valign="top" style="padding:10px 0px;">
            <table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top">
                  <table class="basic_table" width="100%" height="100%" style="font-family:Noto Sans KR;font-size:13px;margin-top:10px;">
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

<!-- 아이콘 모달 -->
<div id="icon_inf" style="display: none; position: absolute;background-color: white;border: 2px solid grey;
border-radius: 3px; font-size: medium;">
<!-- <div id="car_input" style="display:none; position: absolute; background-color: white; width: auto; height: auto;"> -->
<span style="cursor: pointer;float: right;margin-right: 10px;margin-top: 10px;" onclick="$('#icon_inf').bPopup().close();">×</span>
    <div style="padding: 20px 20px 15px 20px;">
      <!-- 개인보관함 이동 방법 : 트리에서 이동할 개인보관함을 선택하여 Drag & Drop으로 이동할 수 있습니다. *아직 미완성* -->
      <p class="title">· 서식함 생성 방법</p>
      <p class="content">'추가 + ' 버튼 클릭 후 서식함명을 작성 후 ‘저장’ 버튼을 클릭합니다.</p>

      <p class="title">· 서식함 수정 방법</p>
      <p class="content">수정할 서식함을 선택하고 우측에 표시되는 정보를 확인/수정한 후 ‘저장’ 버튼을 클릭합니다.</p>

      <p class="title">· 서식함 삭제 방법</p>
      <p class="content">삭제할 서식함을 선택하고 ‘삭제’ 버튼을 클릭합니다.</p>

      <p class="title">· 서식함 이동 방법</p>
      <p class="content">이동할 서식함을 선택하여 Drag & Drop으로 이동할 수 있습니다.</p>
    </div>
</div>

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
               url: "<?php echo site_url(); ?>/biz/approval/format_category_modify",
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
         url: "<?php echo site_url(); ?>/biz/approval/format_category_modify",
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
         url: "<?php echo site_url(); ?>/biz/approval/format_category_modify",
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
            url: "<?php echo site_url(); ?>/biz/approval/format_category_modify",
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

//아이콘 클릭
function open_inf(el){
  var position = $(el).offset();

 $('#icon_inf').bPopup({
   opacity:0,
   follow:[false,false],
   modalClose: false,
   position:[position.left+25, position.top+25]
 });
}

</script>
</body>
</html>
