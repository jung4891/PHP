<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";

$mbox = urldecode($mbox);
 ?>


 <link rel="stylesheet" href="<?php echo $misc; ?>/css/style.css" type="text/css" charset="utf-8"/>
 <style media="screen">
  .mlist_tbl{
    width:90%;
  }
  .mlist_tbl td{
    height: 40px;
    border-top: solid 1px #DFDFDF;
  }

   a.unseen {
     color: #0575E6;
   }
   a.seen {color: black;}
   a.visit:visited {color: black}
   /* 위 2개 다 black해줘야 읽은 페이지 링크 보라색으로 안뜸 */
   a.unseen:hover {text-decoration: underline;};
   a.seen:hover {text-decoration: underline;};

 </style>

<div id="main_contents" align="center">
  <form name="mform" action="" method="post">
    <div id="" align="left" style="width:100%;padding-bottom:10px;">
      <table style="width:90%">
        <colgroup>
          <col width="3%" >
          <col width="3%" >
          <col width="3%" >
          <col width="25%" >
          <col width="*" >
          <col width="10%" >
          <col width="10%" >
        </colgroup>
          <tr>
            <td></td>
            <td>
            <input type="checkbox" id="total" onClick="check_all(this);">
            </td>
            <td colspan="2">
            <?php if($mbox == "&ycDGtA- &07jJwNVo-") {  // 휴지통 ?>
            <button type="button" class="top_button" onclick="del_ever();" disabled="disabled">영구삭제</button>
            <?php }else {?>
            <button type="button" class="top_button" onclick="del_trash();" disabled="disabled" style="height: 25px;">삭제</button>
            <?php } ?>
            &nbsp;&nbsp;
            <select class="top_button" id="selected_box" style="background-color: #F0F0F0; height: 25px;" disabled="disabled" >
              <option value="">이동할 메일함</option>
              <?php
                foreach($mailbox_tree as $b) {
                  echo "<option value='{$b["id"]}'>{$b['text']}</option>";
                }
              ?>
            </select>
            <button type="button" class="top_button" onclick="move();" disabled="disabled" style="height: 25px;">이동</button>
            </td>
            <td colspan="2">
              <div style="display: inline-block; width: 180px; height: 25px;  border: solid 1px lightgray;">
                <input type="text" id="search" style="outline: none; margin: 3px; margin-left: 6px; width: 77%; height: 20px; border: none; color: green; font-weight: bold; font-size:1em" >
                <a href="javascript:void(0)" onclick="search_mail(this);">
                <img style="width: 17px; position: relative; top:3px " src="<?php echo $misc; ?>/img/icon/search.png" alt="">
                </a>
              </div>


            </td>
            <td>
            <select id="show_cnt" onchange="mails_cnt(this);" style="background-color: #F0F0F0; height: 25px" >
              <option value="">보기설정</option>
              <option value="10">10개</option>
              <option value="20">20개</option>
              <option value="30">30개</option>
            </select>
            </td>
          </tr>
      </table>
    </div>
  </form>
  <div class="main_div" style="height:90%;">
  <!-- <?php // echo $test_msg; ?> <br><br> -->
  <table class="mlist_tbl" border="0" cellspacing="0" cellpadding="0">
    <colgroup>
      <col width="3%" >
      <col width="3%" >
      <col width="3%" >
      <col width="25%" >
      <col width="*" >
      <col width="10%" >
      <col width="10%" >
    </colgroup>
    <tbody>

      <form name="frm" method="post">

      <?php
        // 메일이 없는 경우
        if(count($mailno_arr) == 0)
          echo '<tr><td colspan="7" style="text-align: center;"><br>메일함에 메일이 없습니다.<br><br></td></tr>'
       ?>

      <?php

        for($i=$start_row; $i<$start_row+$per_page; $i++) {
          if (isset($mailno_arr[$i]["no"])) {

        // 발신자 이름 or 메일주소 가져오기
        /*
          이름+메일주소(송혁중 <go_go_ssing@naver.com>) 으로 출력하려면
          htmlspecialchars(mb_decode_mimeheader($head[$num]->fromaddress))
          - mb_decode_mimeheader() : MIME 인코드(암호화)되어있는 메일의 제목을 디코드(복호화)함
          - htmlspecialchars() : 제목에 포함된 HTML태그를 무효로 처리함
        */
        if (isset($head[$mailno_arr[$i]["no"]]->from[0])) {
          $from_obj = $head[$mailno_arr[$i]["no"]]->from[0];              // 보낸 사람의 이름 또는 메일주소를 얻기위함
          $from_addr = imap_utf8($from_obj->mailbox).'@'.imap_utf8($from_obj->host);      // hjsong@durianit.co.kr
          if (isset($from_obj->personal)) {
            $from_name = imap_utf8($from_obj->personal);            // 송혁중 (이름이 명시되어 있는 메일)
          } else {
            $from_name = $from_addr;          // 이름이 명시되어 있지 않은 메일은 메일주소 그대로 출력
          }
        }
        $msg_no = trim($head[$mailno_arr[$i]["no"]]->Msgno);            // 메일번호
        ?>

        <tr>

        <!-- 메일목록 출력 -->
        <!-- <td><?php // echo $head[$mailno_arr[$i]]->Unseen ?></td> -->
        <td name="msg_no_td" style="display:none;"><?php echo $msg_no?></td>
        <td>
          <input type="checkbox" name="chk" value=<?php echo $msg_no;?>>
        </td>
        <td>
          <a href="javascript:void(0);" onclick="starClick(this); " >
            <?php if($head[$mailno_arr[$i]["no"]]->Flagged == "F") {?>
              <img class="fullStar" src="/misc/img/icon/star2.png" alt="" width="15px">
            <?php   }else {?>
              <img class="emptyStar" src="/misc/img/icon/star1.png" alt="" width="15px">
            <?php   } ?>
          </a>
        </td>
        <td>
          <!-- 메일크기로 첨부파일 유무 파악 -->
          <?php if($mailno_arr[$i]["attachments"] == "1") { ?>
          <img src="/misc/img/icon/attachment.png" alt="ss">
          <?php }else { ?>
          <?php } ?>
        </td>
        <?php
        // get방식으로 데이터를 직접 url에 적으면 &가 데이터 구별기호로 인식되서 바꿔줘야함
        $mbox2 = str_replace('&', '%26', $mbox);
        $mbox2 = str_replace(' ', '+', $mbox2);

        // 메일 읽은경우/읽지 않은경우 class명 지정하여 색 변경 (메일 읽으면 "U" -> ""로 바뀜)
        $unseen = $head[$mailno_arr[$i]["no"]]->Unseen;
        $unseen = ($unseen == "U")? "unseen":"seen";
        ?>
        <td><a class= <?php echo $unseen ?> onclick="change_href(event, '<?php echo $from_addr; ?>')"
            href="<?php echo site_url(); ?>/mailbox/mail_detail?boxname=<?php echo $mbox2 ?>&mailno=<?php echo $mailno_arr[$i]["no"] ?>">
            <?php echo (isset($from_name))? imap_utf8($from_name) : '(이름 없음)' ?></a></td>
        <td><a class=<?php echo $unseen ?> href="<?php echo site_url(); ?>/mailbox/mail_detail?boxname=<?php echo $mbox2 ?>&mailno=<?php echo $mailno_arr[$i]["no"] ?>">
            <?php echo (isset($head[$mailno_arr[$i]["no"]]->subject) && $head[$mailno_arr[$i]["no"]]->subject != "")? imap_utf8($head[$mailno_arr[$i]["no"]]->subject) : '(제목 없음)' ?></a></td>
        <td style="color: darkgray; font-weight: 400;"><?php echo isset($head[$mailno_arr[$i]["no"]]->udate)? date("y.m.d", $head[$mailno_arr[$i]["no"]]->udate) : '' ?></td>
        <!-- 시, 분은 H:i -->
        <?php
          if(isset($head[$mailno_arr[$i]["no"]]->Size)) {
            $size = round(($head[$mailno_arr[$i]["no"]]->Size)/1024, 1);
            ($size < 1000)? $size .= 'KB' : $size = round($size/1000, 1).'MB';
          } else {
            $size = '';
          }
         ?>
        <td><?php echo $size ?></td>
      </tr>
      <!-- <pre align="left">
        <?php // var_dump($head[$mailno_arr[$i]]); ?>
      </pre> -->
      <?php
        }
      }
      ?>
       </form>
    </tbody>
  </table>

</div>
<div class="" style="text-align: center;  margin-top: 20px">
  <?php echo $links; ?>
</div>

</div>
<div id="move_mbox" style="display:none;position: absolute; background: #000; width: 30px; height: 30px; opacity: 0.4; border-radius: 100%;font-size: 20px;color: white; text-align:center;">
<span id="movebox_len"></span>
</div>
<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>

<!-- 상세검색 -->
<style media="screen">
.modal{ position:absolute; width:100%; height:100%; background: rgba(0,0,0,0.1); top:0; left:0;
        display:none; }
.modal_content{
  width:350px; height:300px;
  background:#fff; border-radius:10px;
  position:relative; top:18%; left:58%;
  margin-top:-100px; margin-left:-200px;
  text-align:center;
  box-sizing:border-box; padding:20px 0;
  line-height:30px; cursor:pointer;
}
</style>

 <script type="text/javascript">


 function mboxmove(x) {
   var positionLeft = x.clientX;
   var positionTop = x.clientY;
   document.getElementById('move_mbox').style.left = positionLeft + 5 + "px";
   document.getElementById('move_mbox').style.top = positionTop - 65 +"px";
 }

$(".mlist_tbl tr").click(function(){
  // alert("이건클릭");
})

$(".mlist_tbl tr").on("mousedown", function(){
   // var chk_len = $('input[name="chk"]:checked').length;

     // $(document).unbind('click');
     event.preventDefault();
     // var mail_arr = [];
     // var msg_id = $(this).find("td[name='msg_no_td']").text();
     // mail_arr.push(msg_id);
     // console.log(mail_arr);
     // $(this).mouseleave(function(){
     //   console.log("asfaf");
     // })
     var tr_checkbox = $(this).find("input[name='chk']");
     console.log(tr_checkbox);
     var chk_yn = tr_checkbox.is(":checked");
     console.log(chk_yn);


   $(document).on("mousemove",function(e){
     if (!chk_yn) {
       $('input[type="checkbox"]').prop('checked', false);
       tr_checkbox.prop('checked', true);
       $('.top_button').prop('disabled', false);

     }

     var chk_lenth = $('input[name="chk"]:checked').length;
     $("#movebox_len").html(chk_lenth);
     $("#move_mbox").show();
     $(document).unbind('click');
     mboxmove(e);


   })

    $(document).mouseup(function(e) {
      $("#move_mbox").hide();
      var target_div = $(event.target).closest("div").attr("id");


      if(target_div == "side_mbox"){
        var mail_arr = [];
        $('input[name="chk"]:checked').each(function(){
          var msg_id = $(this).val();
          mail_arr.push(msg_id);
        })

        // mail_arr.push(msg_id);
        var tobox = $(event.target).closest("tr").attr("id");
        var frombox = "<?php echo $mbox ?>";
        $.ajax({
          url : "<?php echo site_url(); ?>/mailbox/mail_move",
          type : "post",
          data : {
            mbox: frombox,
            to_box: tobox,
            mail_arr: mail_arr
        },
          success : function(data){
            (data == 1)? alert("이동되었습니다.") : alert("애러발생");
          },
          error : function(request, status, error){
              console.log("AJAX_ERROR");
          },
          complete : function() {
            location.reload();
          }
        });
      }
      $(document).unbind('mousemove');
      $(document).unbind('mouseup');
  });


 });


 $(function() {
   // 검색창에 검색어 입력후 엔터키로 검색
   const input = document.querySelector('#search');
   input.addEventListener('keyup', function(e){
     if(e.key === 'Enter') {
       let search_word = $('#search').val();
       if(search_word == "") {
         alert('검색어를 입력하세요');
         $('#search').focus();
       }else {
         var newForm = $('<form></form>');
         newForm.attr("method","get");
         newForm.attr("action", "<?php echo site_url(); ?>/mailbox/mail_list");
         newForm.append($('<input>', {type: 'hidden', name: 'boxname', value: '<?php echo $mbox ?>'}));
         newForm.append($('<input>', {type: 'hidden', name: 'type', value: 'search' }));
         newForm.append($('<input>', {type: 'hidden', name: 'subject', value: search_word }));
         newForm.appendTo('body');
         newForm.submit();
       }
     }
   })

  // 보기설정 개수 선택시 새로고침된 페이지에서 옵션 selected 설정
  var per_page = '<?php echo $per_page; ?>';
  $('#show_cnt option[value='+per_page+']').attr('selected', true);
 })

 // 검색
 function search_mail(ths) {
   let search_word = $('#search').val();
   if(search_word == "") {
     alert('검색어를 입력하세요');
     $('#search').focus();
   }else {
     let parent_tr = ths.parentNode;
     let subject = parent_tr.childNodes[1].value;
     var newForm = $('<form></form>');
     newForm.attr("method","get");
     newForm.attr("action", "<?php echo site_url(); ?>/mailbox/mail_list");
     newForm.append($('<input>', {type: 'hidden', name: 'boxname', value: '<?php echo $mbox ?>'}));
     newForm.append($('<input>', {type: 'hidden', name: 'type', value: 'search' }));
     newForm.append($('<input>', {type: 'hidden', name: 'subject', value: subject }));
     newForm.appendTo('body');
     newForm.submit();
   }
 }

 // 상세검색
 function search_detail() {
   $(".modal").fadeIn();
 }
 $('#modal_form_submit').click(function() {
   // console.log($('[name=contents]').val());
 })
 $('#modal_form_close').click(function() {
   $(".modal").fadeOut();
 })

 // 상단 체크박스 클릭시 전체선택/해제 설정
 function check_all(chk_all) {
   if(chk_all.checked) {
     $('.top_button').prop('disabled', false);
     $('input[type="checkbox"]').prop('checked', true);
   }else {
     $('.top_button').prop('disabled', "disabled");
     $('input[type="checkbox"]').prop('checked', false);
   }
 };

 // 체크박스 하나 클릭시
 $('input[name="chk"]').on('click', function(){
   chk_cnt = $('input[name="chk"]').length;
   if($('input[name="chk"]:checked').length == chk_cnt) {
     $('#total').prop('checked', true);
   }else {
     $('#total').prop('checked', false);
   }
   if(this.checked) {
     $('.top_button').prop('disabled', false);
   }else {
      if($('input[name="chk"]:checked').length == 0)
        $('.top_button').prop('disabled', 'disabled');
    }
 })

 // 중요메일 체크
 function starClick(ths) {
   let childNodes = ths.childNodes;
   let imgTag = childNodes[1];
   let className = imgTag.className;
   if(className == "emptyStar") {
     imgTag.src = "/misc/img/icon/star2.png";
     imgTag.className = "fullStar";
   }else {
     imgTag.src = "/misc/img/icon/star1.png";
     imgTag.className = "emptyStar";
   }

   let parent_tr = ths.parentNode.parentNode;
   let mailno = parent_tr.childNodes[5].innerText;
   $.ajax({
     url : "<?php echo site_url(); ?>/mailbox/set_flag",
     type : "get",
     data : {boxname: '<?php echo $mbox ?>', mailno: mailno, state: className},
   });
 }

 // 페이지 이동
 function go_page(page) {
  var mbox = '<?php echo $mbox; ?>';
  var per_page = '<?php echo $per_page; ?>';
  var type = '<?php if(isset($type)) echo $type; else echo "original"; ?>';
  var subject = '<?php if(isset($subject)) echo $subject; else echo ""; ?>';
  var newForm = $('<form></form>');
  newForm.attr("method","get");
  newForm.attr("action", "<?php echo site_url(); ?>/mailbox/mail_list");
  newForm.append($('<input>', {type: 'hidden', name: 'boxname', value: mbox }));
  newForm.append($('<input>', {type: 'hidden', name: 'type', value: type }));
  newForm.append($('<input>', {type: 'hidden', name: 'subject', value: subject }));
  newForm.append($('<input>', {type: 'hidden', name: 'curpage', value: page }));
  newForm.append($('<input>', {type: 'hidden', name: 'mail_cnt_show', value: per_page }));
  newForm.appendTo('body');
  newForm.submit();
}

 // 휴지통으로 삭제
  function del_trash(){
    let arr = [];
    for(var i=0; i<document.frm.length; i++) {
     if(document.frm[i].checked) {
       arr.push(document.frm[i].value)
     }
    }
    $.ajax({
      url : "<?php echo site_url(); ?>/mailbox/mail_move",
      type : "post",
      data : {mbox: '<?php echo $mbox ?>', to_box: '&ycDGtA- &07jJwNVo-', mail_arr: arr},
      success : function(data){
        (data == 1)? alert("삭제되었습니다.") : alert("애러발생");
      },
      error : function(request, status, error){
          console.log("AJAX_ERROR");
      },
      complete : function() {
        location.reload();
      }
    });
    // console.log(arr);
    // console.log(arr.length);
  }

 // 휴지통에서 완전삭제
  function del_ever(){
    if (confirm("정말 삭제하시겠습니까??") == true) {
      let arr = [];
      for(var i=0; i<document.frm.length; i++) {
        if(document.frm[i].checked) {
          arr.push(document.frm[i].value)
        }
      }
      $.ajax({
        url : "<?php echo site_url(); ?>/mailbox/mail_delete",
        type : "post",
        data : {mbox: '<?php echo $mbox ?>', mail_arr: arr},
        success : function(data){
          (data == 1)? alert("영구삭제 되었습니다.") : alert("애러발생");
        },
        error : function(request, status, error){
          console.log("AJAX_ERROR");
        },
        complete : function() {
          location.reload();
        }
      });
    } else {
      return;
    }
    // console.log(arr);
    // console.log(arr.length);
  }

  // 메일함 이동
  function move() {
    const s = document.getElementById('selected_box');
    const to_box = s.options[s.selectedIndex].value;
    let arr = [];
    for(var i=0; i<document.frm.length; i++) {
     if(document.frm[i].checked) {
       arr.push(document.frm[i].value)
     }
    }
    $.ajax({
      url : "<?php echo site_url(); ?>/mailbox/mail_move",
      type : "post",
      data : {mbox: '<?php echo $mbox ?>', to_box: to_box, mail_arr: arr},
      success : function(data){
        (data == 1)? alert("이동되었습니다.") : alert("애러발생");
      },
      error : function(request, status, error){
          console.log("AJAX_ERROR");
      },
      complete : function() {
        location.reload();
      }
    });
 }

   // 보기 설정
   function mails_cnt(s) {
    const cnt = s.options[s.selectedIndex].value;
    var mbox = '<?php echo $mbox; ?>';
    var curpage = '<?php echo $curpage; ?>';
    var type = '<?php if(isset($type)) echo $type; else echo "original"; ?>';
    var newForm = $('<form></form>');
    newForm.attr("method","get");
    newForm.attr("action", "<?php echo site_url(); ?>/mailbox/mail_list");
    newForm.append($('<input>', {type: 'hidden', name: 'boxname', value: mbox }));
    newForm.append($('<input>', {type: 'hidden', name: 'type', value: type }));
    newForm.append($('<input>', {type: 'hidden', name: 'curpage', value: curpage }));
    newForm.append($('<input>', {type: 'hidden', name: 'mail_cnt_show', value: cnt }));
    newForm.appendTo('body');
    newForm.submit();
  }

   // 보낸사람 링크 변경
   function change_href(e, addr) {
     e.preventDefault();    // a태그 href 이동 이벤트 막고 아래로 addr post로 보냄.
     var newForm = $('<form></form>');
     newForm.attr("method","post");
     newForm.attr("action", "<?php echo site_url(); ?>/mail_write/page");
     newForm.append($('<input>', {type: 'hidden', name: 'addr', value: addr }));
     newForm.appendTo('body');
     newForm.submit();
   };

 </script>
