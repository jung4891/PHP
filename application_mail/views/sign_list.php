<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>
 <link rel="stylesheet" href="<?php echo $misc; ?>/daumeditor-7.4.9/css/editor.css" type="text/css" charset="utf-8"/>
 <link rel="stylesheet" href="<?php echo $misc; ?>/css/style.css" type="text/css" charset="utf-8"/>
 <script src="<?php echo $misc; ?>/daumeditor-7.4.9/js/editor_loader.js" type="text/javascript" charset="utf-8"></script>
 <style>
   #nav_tbl td{
     min-width: 100px;
     height: 30px;
     border: 1px solid black;
     text-align: center;
     cursor: pointer;
   }
   #sign_list{
     width: 100%;
   }


   #sign_list td{
     border-bottom: 1px solid #e2e2e2;
   }

   .sign_tr{
     cursor: pointer;
   }
   /* .sign_tr:hover{
     background-color: #FAFAFA;
   } */

   .sign_selected{
     background-color: #e3e3e3;
   }

   .nav_btn{
     -webkit-appearance: none;
     -moz-appearance: none;
     appearance: none;
     border:1px solid #B0B0B0;
     border-bottom: none;
     height: 30px;
     width: 100px;
     cursor: pointer;
     background-color: #FFFFFF;
     color: #1C1C1C;
     border-radius: 10px 10px 0px 0px;
   }

   .select_btn{
     border:none;
     background-color: #1A8DFF;
     color: #FFFFFF;
   }


</style>

  <div id="main_contents" align="center">
    <form name="mform" action="" method="post">
      <div class="" align="left" width=100% style="border-bottom:1px solid #1A8DFF;margin:-10px 40px 10px 40px;">
        <button type="button" name="button" class="nav_btn" style="margin-left:10px;"onclick="location.href='<?php echo site_url(); ?>/option/user'">계정설정</button>
        <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/mailbox'">메일함설정</button>
        <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/address_book'">주소록관리</button>
        <button type="button" name="button" class="nav_btn select_btn" onclick="location.href='<?php echo site_url(); ?>/option/singnature'">서명관리</button>
        <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/categorize'">메일분류</button>
      </div>
    </form>
      <div class="main_div">


<form action="" method="post" enctype="multipart/form-data" id="tx_editor_form" name="tx_editor_form">
<table style="width:90%;">
  <colgroup>
    <col width="80%">
    <col width="20%">
  </colgroup>
  <tr>
    <td colspan="2">
      편집할 서명 선택
    </td>
  </tr>
  <tr>
    <td>
      <div class="" style="height: 15vh;max-height:15vh; width:100%;overflow-y:scroll;border:1px solid
#e2e2e2;">
        <table id="sign_list">

        </table>
      </div>
    </td>
    <td>
<button type="button" class="btn_basic" name="button" style="width:99%" onclick="sign_open(0);">서명 추가</button><br>
<button type="button" class="btn_basic" name="button" style="width:99%" onclick="sign_open(1);" >이름 변경</button><br>
<button type="button" class="btn_basic" name="button" style="width:99%" onclick="sign_del();">서명 삭제</button><br>
<button type="button" class="btn_basic" name="button" style="width:99%" onclick="sign_save();">내용 저장</button><br>
    </td>
  </tr>
  <tr>
    <td colspan="2">
				<textarea name="content" id="content" style="display:none;"></textarea>
        <!-- <input type="text" name="content" id="content" value=""> -->
        <input type="hidden" name="contents" id="contents" value="">
        <?php include $this->input->server('DOCUMENT_ROOT')."/misc/daumeditor-7.4.9/editor.php"; ?>
    </td>
  </tr>
</table>
</form>
      </div>

  </div>


<div id="sign_modal" style="background-color:white;width:400px;height:200px;display:none;">
  <div class="">
    <h2 id="modal_title" align="center"></h2>
  </div>
  <div class="" align="center">
    <input type="hidden" name="" id="sign_seq" value="">
    이 서명의 이름을 입력하세요.<br>
    <input type="text" id="sign_name" name="" style="height:25px;width:200px;" value="">
  </div>
  <div class="" align="center" style="margin-top:10px;">
    <button type="button" name="button" class="btn_basic btn_blue" style="width:70px;" onclick="sign_submit();">확인</button>
    <button type="button" name="button" class="btn_basic btn_sky" style="width:70px;" onclick="$('#sign_modal').bPopup().close();">취소</button>
  </div>
</div>

<script type="text/javascript">
$(function (){
  sign_list();
})


function sign_list(){
  $.ajax({
    url: "<?php echo site_url(); ?>/option/sign_list",
    type: 'POST',
    dataType: 'json',
    success: function (result) {
      $("#sign_list tr").remove();
      for (var i = 0; i < result.length; i++) {
        if(result[i].active == "Y"){
          var content = result[i].sign_content;
          if(content == null){
            content = "<p><br></p>";
            // $("#content").text("").html();
          }
          $("#content").text(content).html();
          loadContent();

          var select_class = " sign_selected";
        }else{
          var select_class = "";
        }
        var signList = "<tr class='sign_tr"+select_class+"' onclick='change_sign(this);' data-seq='"+result[i].seq+"'><td>";
        signList += result[i].sign_name + "</td></tr>";

        $("#sign_list").append(signList);
      }

    }
  });
}

function change_sign(ths){
  $("#sign_list tr").removeClass("sign_selected");
  $(ths).addClass("sign_selected");
  var seq = $(ths).attr("data-seq");
  $.ajax({
    url: "<?php echo site_url(); ?>/option/get_signcontent",
    type: 'POST',
    dataType: 'json',
    data: {seq:seq},
    success: function (result) {
      var content = result.sign_content;
      if(content == null){
        content = "<p><br></p>";
      }
      // content = content.replaceAll("\u0020", "&nbsp;");
      // console.log(content);
      $("#content").text(content).html();
      // console.log($("#content").val());
      loadContent();
    }
  });
}

function sign_save(){
  var seq = $(".sign_selected").attr("data-seq");
  var content = Editor.getContent();
  $.ajax({
    url: "<?php echo site_url(); ?>/option/sign_save",
    type: 'POST',
    dataType: 'json',
    data: {
      seq:seq,
      content:content
    },
    success: function (result){
      if(result){
        alert("저장되었습니다.");
      }
    }
  });
}

function sign_del(){
  var seq = $(".sign_selected").attr("data-seq");
  $.ajax({
    url: "<?php echo site_url(); ?>/option/sign_del",
    type: 'POST',
    dataType: 'json',
    data: {
      seq:seq
    },
    success: function (result){
      if(result){
        alert("삭제되었습니다.");
        sign_list();
      }
    }
  });
}

function sign_open(mode){
  if(mode == 0){
    $("#modal_title").html("서명 추가");
    $("#sign_seq").val("new");
    $("#sign_name").val("");
  }else{
    $("#modal_title").html("이름 변경");
    var seq = $(".sign_selected").attr("data-seq");
    $("#sign_seq").val(seq);
    var sign_name = $(".sign_selected td").html();
    $("#sign_name").val(sign_name);
  }
  $("#sign_modal").bPopup();
  $("#sign_name").select();
}

function sign_submit(){
  var seq = $("#sign_seq").val();
  var sign_name = $("#sign_name").val();
  if(sign_name == ""){
    alert("서명 이름을 입력해주세요.");
    return false;
  }
  $.ajax({
    url: "<?php echo site_url(); ?>/option/sign_input",
    type: 'POST',
    dataType: 'json',
    data:{
      seq:seq,
      sign_name:sign_name
    },

    success: function (result) {
      if(result){
        $("#sign_modal").bPopup().close();
        alert("처리되었습니다.");
        sign_list();
      }
    }
  });

}

</script>

<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>
