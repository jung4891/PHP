<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}

   .basic_td{
      border:1px solid;
      border-color:#d7d7d7;
   }
   .basic_table{
      border-collapse:collapse;
      border:1px solid;
      border-color:#d7d7d7;
   }

   .popupLayer {
      position: absolute;
      display: none;
      background-color: #ffffff;
      border: solid 2px #d0d0d0;
      width: 200px;
      height: 200px;
      padding: 10px;
      z-index: 1001;
   }
   .popup_menu:hover{
      color:#d0d0d0;
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
   .basic_table td{
      padding:0px 10px 0px 10px;
      border:1px solid;
      border-color:#d7d7d7;
   }
   #form_table td{
      padding:0px 0px 0px 0px;
   }

   #form_table span{
      display:inline-block;
      width:100%;
      height:30px;
      padding:10px 0px 0px 0px;
   }

   .form_btn {
     margin-right: 5px;
     border: 2px solid black;
     background-color: white;
     width:60px;
     border-radius: 50px;
     background:white;
     border-color:#626262;
     color:rgb(98, 98, 98);
     cursor:pointer;
   }
   .form_btn:hover {
     background:#626262;
     color:white;
   }
</style>
<link rel="stylesheet" href="/misc/css/dashboard.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<script>
   //이게모냐면 팝업창 닫을때 이벤트실행
   function test() {
      window.onbeforeunload = function (e) {
         opener.parent.open_preview = null;
      };
   }
</script>

<body onload="test();">
<div id="form_preview" align="center" style="padding:50px 50px;">
   <table id="html" width="100%" border="0" style='font-family: "Noto Sans KR";border-collapse:collapse;'><?php echo $preview_html_val;?></table>
</div>

<script>
   function multi_calculation(expression,changeInput,eq){
      if(eq == 'all'){
         var class_name = expression.replace(/\[/gi,'').replace(/\]/gi,'');
         class_name = class_name.split(',');
         expression='';
         for(i=0; i<class_name.length; i++){
            if(isNaN(class_name[i]) == true && /[+-/)(*]/g.test(class_name[i]) == false){
               class_name[i] = $('.'+class_name[i]);
               var sum = 0;
               for(j=0; j<class_name[i].length; j++){
                  sum += Number(class_name[i].eq(j).val().replace(/,/gi, ""));
               }
               class_name[i] = "("+sum+")";
            }
            expression += class_name[i];
         }
         var html_input = $("#html").find($("."+changeInput)).eq(0);
         html_input.val(eval(expression));
         html_input.trigger("change");
      }else{
         var class_name = $(eq).attr("class").replace("input7","");
         var index = $("."+class_name).index($(eq));
         expression=expression.split("eq(0)").join("eq("+index+")");
         var html_input = $("#html").find($("."+changeInput)).eq(index);
         html_input.val(eval(expression));
         html_input.trigger("change");
      }

   }

   function multi_sum(multi_id){
      var multi_input = multi_id + "_sum"
      var sum_value = 0;

      for(j=0; j < $("."+multi_id).length; j++){
         sum_value += Number($("."+multi_id).eq(j).val().replace(/,/gi, ""));
      }
      $("#"+multi_input).val(sum_value);
      $("#"+multi_input).change();
   }

   //사용자 선택
   function select_user(s_id){
      // $("#group_tree_modal").show();
      $("#click_user").remove();
      $("#group_tree_modal").show();
      $("#select_user_id").val(s_id);
      if($("#"+$("#select_user_id").val()).val() != ""){
         var select_user = ($("#"+$("#select_user_id").val()).val()).split(',');
         var txt = '';
         for(i=0; i<select_user.length; i++){
            txt += "<div class='select_user' onclick='click_user("+'"'+select_user[i]+'"'+",this)'>"+select_user[i]+"</div>";
         }
         $("#select_user").html(txt);
      }
   }

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
         $("#"+$("#select_user_id").val()).val(txt);
         $("#"+$("#select_user_id").val()).change();
         $("#group_tree_modal").hide();
      }
   }

   // groupView();

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
   function groupView(group){
   if(group == undefined){
      var groupName = "all";
   }else{
      var groupName = $(group).attr("id");
   }

   $.ajax({
         type: "POST",
         cache: false,
         url: "<?php echo site_url(); ?>/ajax/groupView",
         dataType: "json",
         async: false,
         data: {
         group:groupName
         },
         success: function (data) {
            var txt = '';
            for(i=0; i<data.length; i++){
                  txt +=  "<div class='click_user' onclick='click_user("+'"'+data[i].user_name+'",this'+");'>"+data[i].user_name+" "+data[i].user_duty+" "+data[i].user_group+ "</div>";
            }
            $("#click_group_user").html(txt);
         }
   });

   }

   //user 선택
   function click_user(name,obj){
      $(".click_user").css('background-color','');
      $(".select_user").css('background-color','');
      $(".click_user").attr('id','');
      $(".select_user").attr('id','');
      $(obj).css('background-color','#f8f8f9');
      $(obj).attr('id','click_user');
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
                     html += "<div class='select_user' onclick='click_user("+'"'+data[i].user_name+'"'+",this)'>"+data[i].user_name+" "+data[i].user_duty+" "+data[i].user_group+"</div>";
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
         if(duplicate_check == true){
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

   //반올림 올림 , 내림
   function round(obj,n,type){
      if(n != 0){
         if(type == "round"){//반올림
            var num = Number(obj.value);
            $(obj).val(num.toFixed(n));
         }else if(type == "down"){//내림
            var decimal_point = obj.value.indexOf('.');
            var num = (obj.value).substring(0,(decimal_point+n+1));
            $(obj).val(num);
         }else if(type == "up"){//올림
            var decimal_point = obj.value.indexOf('.');
            var num = (obj.value).substring(0,(decimal_point+n+1));
            var up_value = String(Number(num[(decimal_point+n)])+1);
            up_value = num.substr(0,(decimal_point+n)) + up_value + num.substr((decimal_point+n)+ up_value.length);
            $(obj).val(up_value);
         }
      }else{
         if(type == "round"){//반올림
            var num = Math.round(obj.value);
            $(obj).val(num);
         }else if(type == "down"){//내림
            var num = Math.floor(obj.value);
            $(obj).val(num);
         }else if(type == "up"){//올림
            var num = Math.ceil(obj.value);
            $(obj).val(num);
         }
      }
   }



   //정규표현식
   function regex(obj,type){
      if(type == "money"){
         // val = $(obj).val().replace(/^0+|\D+/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
         val = $(obj).val().replace(/[^0-9-]/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
         $(obj).val(val);
      }else if (type == "number"){
         // val = $(obj).val().replace(/^0+|\D+/g, '');
         val = $(obj).val().replace(/[^0-9-]/g, '');
         $(obj).val(val);
      }else if (type=="decimal_point"){
         val = $(obj).val().replace(/[^0-9.-]/g, "");
         $(obj).val(val);
      }else if (type=="phone_num"){
         val = $(obj).val().replace(/(^02.{0}|^01.{1}|[0-9]{3})([0-9]+)([0-9]{4})/,"$1-$2-$3");
         $(obj).val(val);
      }else if (type =="email"){
         var regex =  /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
         if(regex.test($(obj).val()) === false){
            $(obj).focus();
            alert("email 형식이 틀렸습니다.")
            return false
         }
      }else if (type == "post_num"){
         var regex =  /^[0-9]{1,6}$/
         if(regex.test($(obj).val()) === false){
            $(obj).focus();
            alert("우편번호는 숫자 6자리만 입력해주세요")
            return false;
         }
      }
   }

   //기안문양식 삭제
   function template_delete(){
      if(confirm("기안문 양식을 삭제하시겠습니까?")){
         $.ajax({
               type: "POST",
               cache: false,
               url: "<?php echo site_url(); ?>/biz/approval/template_delete",
               dataType: "json",
               async :false,
               data: {
                  seq : $("#seq").val()
               },
               success: function (data) {
                if(data){
                   alert("삭제완료");
                   location.href= "<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list?mode=admin";
                }else{
                   alert("삭제실패")
                }
               }
            });
      }
   }
</script>
</body>
</html>
