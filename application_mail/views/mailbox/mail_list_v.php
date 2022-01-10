<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";

$mbox = urldecode($mbox);

 ?>

 <!-- IE에서 input date 입력가능하게 설정 (jQuery에서 제공하는 datepicker 기능) -->
 <!-- jQuery에서 제공하는 css 와 js 파일 -->
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>
 <!-- <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script> -->
 <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
 <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.min.js"></script>

 <link rel="stylesheet" href="<?php echo $misc; ?>/css/style.css" type="text/css" charset="utf-8"/>
 <style media="screen">
  .mlist_tbl{
    width:90%;
    table-layout: fixed;
  }
  .mlist_tbl td{
    height: 40px;
    border-top: solid 1px #DFDFDF;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

   a.unseen {
     color: #0575E6;
   }
   a.seen {color: black;}

   a.visit:visited {color: black}
   /* 위 2개 다 black해줘야 읽은 페이지 링크 보라색으로 안뜸 */

   a.unseen:hover {
     text-decoration: underline;
   }

   a.seen:hover {
     text-decoration: underline;
   }

   /* .top_button[disabled=disabled] {
     -webkit-appearance: none;
     -moz-appearance: none;
     appearance: none;
     border:1px solid #B0B0B0;
     border-radius: 5px;
     height: 30px;
     cursor: pointer;
   } */

   .send_context{
     display:none;
     position: absolute;
     background: white;
     width: 120px;
     z-index: 100;
     font-size: 14px;
     color: black;
     text-align:center;
   }

  .context_tbl{
    width:100%;
    border: #dedede solid 1px;
    text-align: left;
  }

  .context_tbl tr:hover{
    background-color: #dedede;
  }

  .context_tbl td{
    border-top:1px solid #dedede;
  }


  .input{
    border: 1px solid lightgray;
  }
 </style>

<div id="main_contents" align="center">
  <div class="main_div">
  <form name="mform" action="" method="post">
      <table style="width:90%; padding-bottom:10px; " border="0" cellspacing="0" cellpadding="0">
        <colgroup>
          <col width="3%" >
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
            <td><input type="checkbox" id="total" onClick="check_all(this);"></td>
            <td colspan="3">
            <?php if($mbox == "&ycDGtA- &07jJwNVo-") {  // 휴지통 ?>
            <button type="button" class="top_button" onclick="del_ever();" disabled="disabled">영구삭제</button>
            <?php }else {?>
            <button type="button" class="top_button" onclick="del_trash();" disabled="disabled" style="height: 25px; ">삭제</button>
            <?php } ?>
            &nbsp;&nbsp;
            <select class="top_button" id="selected_box" style="background-color: #F0F0F0; height: 25px; padding-top: 1px" disabled="disabled" >
              <option value="">이동할 메일함</option>
              <?php
                foreach($mailbox_tree as $b) {
                  echo "<option value='{$b["id"]}'>{$b['text']}</option>";
                }
              ?>
            </select>
            <button type="button" class="top_button" onclick="move();" disabled="disabled" style="height: 25px;">이동</button>
            </td>
            <td>
              <div style="display: inline-block; width: 190px; height: 25px;  border: solid 1px lightgray;">
                <input type="text" id="search" style="outline: none; margin: 3px; margin-left: 6px; width: 79%; height: 20px; border: none; color: green; font-weight: bold; font-size:1em" >
                <a href="javascript:void(0)" onclick="search_mail(this);">
                <img style="width: 17px; position:Arelative; top:3px " src="<?php echo $misc; ?>/img/icon/search.png" alt="">
                </a>
              </div>
              <div style="display: inline-block; cursor: pointer; width: 55px; height: 25px; position: relative; top: -1px; left: 5px; border: solid 1px lightgray; background-color: rgb(220,220,220); text-align: center">
                <a onclick="search_detail(this);" style="position: relative; top: 0px; font-weight: 300; color: grey; font-size: 14px">
                  상세 <img style="position: relative; top: 2px; width: 15px" src="<?php echo $misc; ?>/img/icon/아래.svg" alt="">
                </a>
              </div>
            </td>
            <td></td>
            <td>
            <select id="show_cnt" class="input" onchange="mails_cnt(this);" style="background-color: #F0F0F0; height: 25px; " >
              <option value="">보기설정</option>
              <option value="10">10개</option>
              <option value="20">20개</option>
              <option value="30">30개</option>
            </select>
            </td>
          </tr>
          <tr>
            <td colspan="5"></td>
            <td colspan="3">
              <div id="search_detail"  style="display:none; position: absolute; margin-top: 4px; background-color: white; border: 2px solid lightgray; width: 254px; z-index: 1">
                <form>
                  <table style="border-spacing: 5px; padding-top: 10px; padding-left: 15px; color: gray;">
                    <tr>
                      <td width="31%"></td>
                      <td width="69%"></td>
                    </tr>
                    <tr>
                      <td>보낸이</td>
                      <td><input type="text" id="from" class="input" name="from" size="16"></td>
                    </tr>
                    <tr>
                      <td>받는이</td>
                      <td><input type="text" id="to" class="input" name="to" size="16"></td>
                    </tr>
                    <tr>
                      <td>제목</td>
                      <td><input type="text" id="subject" class="input" name="subject" size="16"></td>
                    </tr>
                    <tr>
                      <td>내용</td>
                      <td><input type="text" id="contents" class="input" name="contents" size="16"></td>
                    </tr>
                    <tr>
                      <td>기간</td>
                      <td><input type="text" id="start_date" class="input" style="width:57px; font-size: 9pt; text-align: center" /> ~ <input type="text" id="end_date" class="input" style="width:57px; font-size: 9pt; text-align: center" /></td>
                    </tr>
                  </table>
                  <div class="" style="margin: 10px; text-align: center;">
                    <button type="button" id="search_detail_submit" style="width: 45px; cursor: pointer;">검색</button>
                    <!-- <button type="button" id="" style="width: 45px; ">취소</button> -->
                  </div>
                </form>
              </div>
            </td>
          </tr>
      </table>
  </form>

  <!-- <?php // echo $test_msg; ?> <br><br> -->
  <table class="mlist_tbl" border="0" cellspacing="0" cellpadding="0" style="table-layout: fixed;">
    <colgroup>
      <col width="3%" >
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
          if (isset($mailno_arr[$i])) {
            // echo "<pre align='left'>";
            // var_dump($head[$mailno_arr[$i]] -> subject);
            // echo '<br>';
            // echo "</pre>";

        // 발신자 이름 or 메일주소 가져오기
        /*
          이름+메일주소(송혁중 <go_go_ssing@naver.com>) 으로 출력하려면
          htmlspecialchars(mb_decode_mimeheader($head[$num]->fromaddress))
          - mb_decode_mimeheader() : MIME 인코드(암호화)되어있는 메일의 제목을 디코드(복호화)함
          - htmlspecialchars() : 제목에 포함된 HTML태그를 무효로 처리함
        */
          if (isset($head[$mailno_arr[$i]]->from[0])) {
            $from_obj = $head[$mailno_arr[$i]]->from[0];     // 보낸 사람의 이름 또는 메일주소를 얻기위함
            $from_addr = imap_utf8($from_obj->mailbox).'@'.imap_utf8($from_obj->host);      // hjsong@durianit.co.kr
            $from_name_full = $from_addr;
            if (isset($from_obj->personal)) {
              $from_name = imap_utf8($from_obj->personal);   // 송혁중 (이름이 명시되어 있는 메일)
              $from_name_full = $from_name.' <'.$from_addr.'>';
            } else {
              $from_name = $from_addr;          // 이름이 명시되어 있지 않은 메일은 메일주소 그대로 출력
            }
          }
          if(isset($head[$mailno_arr[$i]]->toaddress)) {     // 보낸메일함의 경우 받는 사람 표기 (이름있으면 이름만 없으면 메일주소만 출력됨)
            $to_address = imap_utf8($head[$mailno_arr[$i]]->toaddress);
          }

          if(isset($head[$mailno_arr[$i]]->to[0])) {
            $to_obj = $head[$mailno_arr[$i]]->to[0];
            if(isset($to_obj->host))
              $to_addr = imap_utf8($to_obj->mailbox).'@'.imap_utf8($to_obj->host);    // host없는경우 애러처리
            else
              $to_addr = imap_utf8($to_obj->mailbox);
            if (isset($to_obj->personal)) {
              $to_name = imap_utf8($to_obj->personal);
              $to_name_full = $to_name.' <'.$to_addr.'>';
            } else {
              $to_name_full = $to_addr;
            }
          }
          $msg_no = trim($head[$mailno_arr[$i]]->Msgno);            // 메일번호
        ?>

        <tr onclick="detail_mailview(<?php echo $msg_no?>);">

        <!-- 메일목록 출력 -->
        <!-- <td><?php // echo $head[$mailno_arr[$i]]->Unseen ?></td> -->
        <td name="msg_no_td" style="display:none;"><?php echo $msg_no?></td>
        <td>
<?php
if ($ipinfo[$mailno_arr[$i]]["country"] !="") {
?>
    <img width="25" src="<?php echo $misc; ?>/img/flag/<?php echo $ipinfo[$mailno_arr[$i]]['country']; ?>.png" alt="">
<?php
}
?>
        </td>
        <td onclick="event.cancelBubble=true">
          <input type="checkbox" name="chk" value=<?php echo $msg_no;?>>
        </td>
        <td onclick="event.cancelBubble=true">
          <a href="javascript:void(0);" onclick="starClick(this); " >
            <?php if($head[$mailno_arr[$i]]->Flagged == "F") {?>
              <img class="fullStar" src="/misc/img/icon/star2.png" alt="" width="15px">
            <?php   }else {?>
              <img class="emptyStar" src="/misc/img/icon/star1.png" alt="" width="15px">
            <?php   } ?>
          </a>
        </td>
        <td>
          <!-- 첨부파일 유무 파악 -->
          <?php if($attached[$mailno_arr[$i]]) { ?>
          <img src="/misc/img/icon/attachment.png" alt="ss">
          <?php }?>
        </td>
        <?php
        // get방식으로 데이터를 직접 url에 적으면 &가 데이터 구별기호로 인식되서 바꿔줘야함
        $mbox2 = str_replace('&', '%26', $mbox);
        $mbox2 = str_replace(' ', '+', $mbox2);

        // 메일 읽은경우/읽지 않은경우 class명 지정하여 색 변경 (메일 읽으면 "U" -> ""로 바뀜)
        $unseen = $head[$mailno_arr[$i]]->Unseen;
        $unseen = ($unseen == "U")? "unseen":"seen";
        ?>
        <td>
          <a class= <?php echo $unseen ?> href="javascript:void(0);" onclick="event.cancelBubble=true;send_context(this);">
            <?php
            // 보낸메일함은 받는사람 표기
            if(strpos($mbox, '&vPSwuA- &07jJwNVo-') === 0) {
              echo (isset($to_address))? $to_address : '(이름 없음)' ;
            // 그외 메일함은 보낸사람 표기
            }else {
              echo (isset($from_name))? imap_utf8($from_name) : '(이름 없음)' ;
            }
            ?>
          </a>
          <span style="display: none">
            <?php
            if(strpos($mbox, '&vPSwuA- &07jJwNVo-') === 0) {
              echo htmlspecialchars($to_name_full);
            }else {
              echo htmlspecialchars($from_name_full);
            }
            ?>
          </span>
        </td>
        <td style="text-overflow:ellipsis; overflow:hidden; white-space:nowrap;">
          <a class=<?php echo $unseen ?> href="<?php echo site_url(); ?>/mailbox/mail_detail?boxname=<?php echo $mbox2 ?>&mailno=<?php echo $mailno_arr[$i] ?>">

            <?php echo $subject_decoded[$mailno_arr[$i]]?>
          </a>
        </td>
        <td style="color: darkgray; font-weight: 400;"><?php echo isset($head[$mailno_arr[$i]]->udate)? date("y.m.d", $head[$mailno_arr[$i]]->udate) : '' ?></td>
        <!-- 시, 분은 H:i -->
        <?php
          if(isset($head[$mailno_arr[$i]]->Size)) {
            $size = round(($head[$mailno_arr[$i]]->Size)/1024, 1);
            ($size < 1000)? $size .= 'KB' : $size = round($size/1000, 1).'MB';
          } else {
            $size = '';
          }
         ?>
        <td><?php echo $size ?></td>
      </tr>
      <?php
        }
      }
      ?>
       </form>
    </tbody>
  </table>
</div>

<div class="" style="text-align: center; margin-top: 20px">
  <?php echo $links; ?>
</div>

</div>


<div id="move_mbox" style="display:none;position: absolute; background: #000; width: 30px; height: 30px; opacity: 0.4; border-radius: 100%;font-size: 20px;color: white; text-align:center;">
<span id="movebox_len"></span>
</div>

<div class="send_context" id="send_context">
  <table class="context_tbl" border="1" cellspacing="0" cellpadding="5">
    <form class="" id="reply_form" name="reply_form" action="" method="post">
      <input type="hidden" id="reply_mode" name="reply_mode" value="">
      <input type="hidden" id="reply_target_to" name="reply_target_to" value="">
      <input type="hidden" id="reply_target_cc" name="reply_target_cc" value="">
      <input type="hidden" id="reply_title" name="reply_title" value="">
      <input type="hidden" id="reply_content" name="reply_content" value="">
    </form>
    <tr>
      <td onclick="reply_mail(3)">
        메일쓰기
      </td>
    </tr>
    <!-- <tr>
      <td onclick="reply_mail(1)">
        회신
      </td>
    </tr> -->
  </table>
</div>
<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>


 <script type="text/javascript">

// function detail_mailview(){
//   var mid = $(this).find("input[name='chk']").val();
//   console.log(mid);
// }

 function mboxmove(x) {
   var positionLeft = x.clientX;
   var positionTop = x.clientY;
   document.getElementById('move_mbox').style.left = positionLeft + 5 + "px";
   document.getElementById('move_mbox').style.top = positionTop - 65 +"px";
 }

// $(".mlist_tbl tr").click(function(){
  // alert("이건클릭");
// })

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
     // console.log(tr_checkbox);
     var chk_yn = tr_checkbox.is(":checked");
     // console.log(chk_yn);

   $(document).on("mousemove.mboxshift",function(e){
     if (!chk_yn) {
       $('input[type="checkbox"]').prop('checked', false);
       tr_checkbox.prop('checked', true);
       $('.top_button').prop('disabled', false);
     }
     var chk_lenth = $('input[name="chk"]:checked').length;
     $("#movebox_len").html(chk_lenth);
     $("#move_mbox").show();
     // $(document).unbind('click');
     mboxmove(e);
   }).on("mouseup.mboxsft",function(e){
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
           (data == 1)? alert("이동되었습니다.") :  alert("애러발생");
         },
         error : function(request, status, error){
             console.log("AJAX_ERROR");
         },
         complete : function() {
           location.reload();
         }
       });
     }
     $(document).unbind('mousemove.mboxshift');
     $(document).unbind('mouseup.mboxsft');
     // $(document).bind('click');
 });
 });

 function send_context(ths){
   $(ths).next().attr('id', 'reply_target');
   // console.log($(ths).next()[0]);
   // console.log($(ths).next()[0].innerText);
   event.preventDefault();
   var positionLeft = event.clientX;
   var positionTop = event.clientY;
   document.getElementById('send_context').style.left = positionLeft + 5 + "px";
   document.getElementById('send_context').style.top = positionTop - 65 +"px";
   $("#send_context").show();
   $("#send_context").addClass("select_context");
 }

 $(document).click(function(e){
   if($("#send_context").hasClass("select_context")){
     if($(e.target).parents('#send_context').length < 1){
       console.log('팝업 외 부분이 맞습니다') //실행 이벤트 부분
       // console.log("!11");
       $("#send_context").removeClass("select_context");
       $("#send_context").hide();
     }
   }
 });

 $(function() {
   // 검색 input창 초기화
   var search_word = '<?php if(isset($search_word)) echo $search_word; ?>';
   if(search_word != "")   $('#search').val(search_word);
   // $('input[name=from]').val('');
   // $('input[name=to]').val('');
   // $('input[name=subject]').val('');
   // $('input[name=contents]').val('');

  // 보기설정 개수 선택시 새로고침된 페이지에서 옵션 selected 설정
  var per_page = '<?php echo $per_page; ?>';
  $('#show_cnt option[value='+per_page+']').attr('selected', true);
 })

 // jquery datepicker 설정
 $.datepicker.setDefaults($.datepicker.regional['ko']); //한국어 설정
 $(function() {
    $('#start_date').datepicker({    // #input 태그 아이디와 동일해야 함. 여러개 구분사용 가능
      showOtherMonths: true,
      selectOtherMonths: true,
      dateFormat:"y-mm-dd",    // 날짜 출력폼 설정(y: 22, yy: 2022)
    });
    $('#end_date').datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      dateFormat:"y-mm-dd",
      // onSelect:function(selectedDate){    // 날짜가 선택되었을때 실행하는 함수
      // }
    });
 });

 // 검색
 function search_mail(ths) {
   let search_word = $('#search').val();
   if(search_word == "") {
     alert('검색어를 입력하세요');
     $('#search').focus();
   }else {
     // let parent_tr = ths.parentNode;
     // let subject = parent_tr.childNodes[1].value;
     var newForm = $('<form></form>');
     newForm.attr("method","get");
     newForm.attr("action", "<?php echo site_url(); ?>/mailbox/mail_list");
     newForm.append($('<input>', {type: 'hidden', name: 'boxname', value: '<?php echo $mbox ?>'}));
     newForm.append($('<input>', {type: 'hidden', name: 'type', value: 'search' }));
     newForm.append($('<input>', {type: 'hidden', name: 'search_word', value: search_word }));
     newForm.appendTo('body');
     newForm.submit();
   }
 }

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
       newForm.append($('<input>', {type: 'hidden', name: 'search_word', value: search_word }));
       newForm.appendTo('body');
       newForm.submit();
     }
   }
 })

 // 상세검색
 function search_detail(ths) {
   if ($('#search_detail').css('display') == 'block') {
       $('#search_detail').css('display', 'none');
       $(ths).children()[0].src = '<?php echo $misc; ?>img/icon/아래.svg';
       ths.childNodes[0].nodeValue = " 상세 ";
   }else {
       $('#search_detail').css('display', 'block');
       $(ths).children()[0].src = '<?php echo $misc; ?>img/icon/위.svg';
       ths.childNodes[0].nodeValue = " 접기 ";
    }
 }


 $('#search_detail_submit').click(function() {
   if($('#from').val() == "" && $('#to').val() == "" && $('#subject').val() == "" && $('#contents').val() == "" && $('#start_date').val() == "" && $('#end_date').val() == "") {
     alert('검색어를 입력하세요');
     $('#from').focus();
     return;
   }
   // get방식이므로 주소창에 검색하는 애들만 출력되게끔
   var mbox = '<?php echo $mbox; ?>';
   var type = 'search_detail';
   var newForm = $('<form></form>');
   newForm.attr("method","get");
   newForm.attr("action", "<?php echo site_url(); ?>/mailbox/mail_list");
   newForm.append($('<input>', {type: 'hidden', name: 'boxname', value: mbox }));
   newForm.append($('<input>', {type: 'hidden', name: 'type', value: type }));
   if($('#from').val() != "") newForm.append($('<input>', {type: 'hidden', name: 'from', value: $('#from').val() }));
   if($('#to').val() != "")   newForm.append($('<input>', {type: 'hidden', name: 'to', value: $('#to').val() }));
   if($('#subject').val() != "")  newForm.append($('<input>', {type: 'hidden', name: 'subject', value: $('#subject').val() }));
   if($('#contents').val() != "")   newForm.append($('<input>', {type: 'hidden', name: 'contents', value: $('#contents').val() }));
   if($('#start_date').val() != "")   newForm.append($('<input>', {type: 'hidden', name: 'start_date', value: $('#start_date').val() }));
   if($('#end_date').val() != "") {
     var end_date = $('#end_date').val().split('-');  // 22-01-10
     end_date[0] = parseInt(end_date[0]) + 2000;
     end_date = end_date.join('-');                   // 2022-01-10

     var selectedDate = new Date(end_date);
     selectedDate.setDate(selectedDate.getDate() + 1);    // 미만으로 검색되어 하루 더하기 (20210110 형태로만 Date객체 형성 가능)
     selectedDate = selectedDate.getFullYear() + "-" + (selectedDate.getMonth() + 1) + "-" + selectedDate.getDate();
     newForm.append($('<input>', {type: 'hidden', name: 'end_date', value: selectedDate }));
   }
   newForm.appendTo('body');
   newForm.submit();
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
  var type = '<?php if(isset($type)) echo $type; else echo ""; ?>';
  var search_word = '<?php if(isset($search_word)) echo $search_word; else echo ""; ?>';
  var from = '<?php if(isset($from)) echo $from; else echo ""; ?>';
  var to = '<?php if(isset($to)) echo $to; else echo ""; ?>';
  var subject = '<?php if(isset($subject)) echo $subject; else echo ""; ?>';
  var contents = '<?php if(isset($contents)) echo $contents; else echo ""; ?>';
  var start_date = '<?php if(isset($start_date)) echo $start_date; else echo ""; ?>';
  var end_date = '<?php if(isset($end_date)) echo $end_date; else echo ""; ?>';
  var newForm = $('<form></form>');
  newForm.attr("method","get");
  newForm.attr("action", "<?php echo site_url(); ?>/mailbox/mail_list");
  newForm.append($('<input>', {type: 'hidden', name: 'boxname', value: mbox }));
  newForm.append($('<input>', {type: 'hidden', name: 'type', value: type }));
  newForm.append($('<input>', {type: 'hidden', name: 'curpage', value: page }));
  newForm.append($('<input>', {type: 'hidden', name: 'mail_cnt_show', value: per_page }));
  if(search_word != "") newForm.append($('<input>', {type: 'hidden', name: 'search_word', value: search_word }));
  if(from != "") newForm.append($('<input>', {type: 'hidden', name: 'from', value: from }));
  if(to != "")   newForm.append($('<input>', {type: 'hidden', name: 'to', value: to }));
  if(subject != "")  newForm.append($('<input>', {type: 'hidden', name: 'subject', value: subject }));
  if(contents != "")  newForm.append($('<input>', {type: 'hidden', name: 'contents', value: contents }));
  if(start_date != "")  newForm.append($('<input>', {type: 'hidden', name: 'start_date', value: start_date }));
  if(end_date != "")  newForm.append($('<input>', {type: 'hidden', name: 'end_date', value: end_date }));
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
    var type = '<?php if(isset($type)) echo $type; else echo ""; ?>';
    var search_word = '<?php if(isset($search_word)) echo $search_word; else echo ""; ?>';
    var from = '<?php if(isset($from)) echo $from; else echo ""; ?>';
    var to = '<?php if(isset($to)) echo $to; else echo ""; ?>';
    var subject = '<?php if(isset($subject)) echo $subject; else echo ""; ?>';
    var contents = '<?php if(isset($contents)) echo $contents; else echo ""; ?>';
    var start_date = '<?php if(isset($start_date)) echo $start_date; else echo ""; ?>';
    var end_date = '<?php if(isset($end_date)) echo $end_date; else echo ""; ?>';
    var newForm = $('<form></form>');
    newForm.attr("method","get");
    newForm.attr("action", "<?php echo site_url(); ?>/mailbox/mail_list");
    newForm.append($('<input>', {type: 'hidden', name: 'boxname', value: mbox }));
    newForm.append($('<input>', {type: 'hidden', name: 'type', value: type }));
    newForm.append($('<input>', {type: 'hidden', name: 'curpage', value: curpage }));
    newForm.append($('<input>', {type: 'hidden', name: 'mail_cnt_show', value: cnt }));
    if(search_word != "") newForm.append($('<input>', {type: 'hidden', name: 'search_word', value: search_word }));
    if(from != "") newForm.append($('<input>', {type: 'hidden', name: 'from', value: from }));
    if(to != "")   newForm.append($('<input>', {type: 'hidden', name: 'to', value: to }));
    if(subject != "")  newForm.append($('<input>', {type: 'hidden', name: 'subject', value: subject }));
    if(contents != "")  newForm.append($('<input>', {type: 'hidden', name: 'contents', value: contents }));
    if(start_date != "")  newForm.append($('<input>', {type: 'hidden', name: 'start_date', value: start_date }));
    if(end_date != "")  newForm.append($('<input>', {type: 'hidden', name: 'end_date', value: end_date }));
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

   function reply_mail(mode){
     $("#reply_form").attr("method","post");
     $("#reply_target_to").attr("value", $('#reply_target')[0].innerText.trim());
     // $("#reply_target_to").val($('#reply_target')[0].innerText);
     $("#reply_form").attr("action", "<?php echo site_url(); ?>/mail_write/page");
     $("#reply_form").submit();
   }

   function detail_mailview(msgno){
     location.href="<?php echo site_url(); ?>/mailbox/mail_detail?boxname=<?php echo $mbox2 ?>&mailno="+msgno;
   }

 </script>
