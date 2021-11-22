<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_side.php";
 ?>

 <style media="screen">
   a.unseen {color: blue;}
   a.seen {color: black;}
   a.visit:visited {color: black}
   /* 위 2개 다 black해줘야 읽은 페이지 링크 보라색으로 안뜸 */
   a.unseen:hover {text-decoration: underline;};
   a.seen:hover {text-decoration: underline;};
 </style>

<div id="main_contents" style="margin:unset;">
  <div class="main_div" >
  <!-- <?php // echo $test_msg; ?> <br><br> -->
  <table border="0" width="98%" style="border-spacing: 7px;">
    <colgroup>
      <col width="12%" >
      <col width="25%" >
      <col width="*" >
      <col width="5%" >
      <col width="5%" >
    </colgroup>
    <thead>
      <tr>
        <div class="" style="width: 210px; height: 40px; position: relative; top: 10px; left: 10px;">
          <div class="" style="border: solid 1px lightgray;">
            <input type="text" style="outline: none; margin: 3px; margin-left: 10px; width: 77%; height: 25px; border: none; color: green; font-weight: bold; font-size:1em" >
            <a href="javascript:void(0)" onclick="search_mail(this);">
            <img style="width: 20px; position: relative; top:5px " src="/devmail/misc/img/icon/search.png" alt="">
            </a>
          </div>
        </div>
        <br>
      </tr>
      <tr>
        <!-- <th>U</th> -->
        <!-- <th>No</th> -->
        &nbsp;
        <input type="checkbox" onClick="check_all(this);">
        &nbsp;
        <?php if($mbox == "&ycDGtA- &07jJwNVo-") {  // 휴지통 ?>
        <button type="button" class="top_button" onclick="del_ever();" disabled="disabled">영구삭제</button>
        <?php }else {?>
        <button type="button" class="top_button" onclick="del_trash();" disabled="disabled">삭제</button>
        <?php } ?>

        &nbsp;&nbsp;
        <select class="top_button" id="selected_box" style="background-color: #F0F0F0; height: 25px;" disabled="disabled" >
          <option value="">이동할 메일함</option>
          <?php
            foreach($boxname_arr as $name => $encoded) {
              echo "<option value=\"$encoded\">$name</option>";
            }
          ?>
        </select>
        &nbsp;&nbsp;
        <button type="button" class="top_button" onclick="move();" disabled="disabled">이동</button>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <select onchange="mails_cnt(this);" style="background-color: #F0F0F0; height: 25px" >
          <option value="">보기설정</option>
          <option value="10">10개</option>
          <option value="20">20개</option>
          <option value="30">30개</option>
        </select>
      </tr>
      <tr>
        <td colspan="6" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
    </thead>
    <tbody>
      <form name="frm" method="post">
      <?php
      for($i=$start_row; $i<$start_row+$per_page; $i++) {
        if (isset($mailno_arr[$i])) {
      ?>
      <tr>
        <?php
        // 발신자 이름 or 메일주소 가져오기
        /*
          이름+메일주소(송혁중 <go_go_ssing@naver.com>) 으로 출력하려면
          htmlspecialchars(mb_decode_mimeheader($head[$num]->fromaddress))
          - mb_decode_mimeheader() : MIME 인코드(암호화)되어있는 메일의 제목을 디코드(복호화)함
          - htmlspecialchars() : 제목에 포함된 HTML태그를 무효로 처리함
        */
        if (isset($head[$mailno_arr[$i]]->from[0])) {
          $from_obj = $head[$mailno_arr[$i]]->from[0];              // 보낸 사람의 이름 또는 메일주소를 얻기위함
          $from_addr = $from_obj->mailbox.'@'.$from_obj->host;      // hjsong@durianit.co.kr
          if (isset($from_obj->personal)) {
            $from_name = imap_utf8($from_obj->personal);            // 송혁중 (이름이 명시되어 있는 메일)
          } else {
            $from_name = $from_addr;          // 이름이 명시되어 있지 않은 메일은 메일주소 그대로 출력
          }
        }
        $msg_no = trim($head[$mailno_arr[$i]]->Msgno);            // 메일번호
        ?>

        <!-- 메일목록 출력 -->
        <!-- <td><?php // echo $head[$mailno_arr[$i]]->Unseen ?></td> -->
        <td style="display:none;"><?php echo $msg_no?></td>
        <td>
          <!-- 메일크기로 첨부파일 유무 파악 -->
          <?php if($head[$mailno_arr[$i]]->Size > 30000) { ?>
          <img src="/devmail/misc/img/icon/attachment.png" alt="ss" style="margin-top: 10px">
          <?php }else { ?>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <?php } ?>
          <input type="checkbox" name="checkbox" onClick="check_one();" value=<?php echo $msg_no;?>>
          &nbsp;
          <a href="javascript:void(0);" onclick="starClick(this); " >
            <?php if($head[$mailno_arr[$i]]->Flagged == "F") {?>
              <img class="fullStar" src="/devmail/misc/img/btn/star2.png" alt="" width="15px">
            <?php   }else {?>
              <img class="emptyStar" src="/devmail/misc/img/btn/star1.png" alt="" width="15px">
            <?php   } ?>
          </a>
        </td>
        <?php
        // get방식으로 데이터를 직접 url에 적으면 &가 데이터 구별기호로 인식되서 바꿔줘야함
        $mbox2 = str_replace('&', '%26', $mbox);
        $mbox2 = str_replace(' ', '+', $mbox2);

        // 메일 읽은경우/읽지 않은경우 class명 지정하여 색 변경 (메일 읽으면 "U" -> ""로 바뀜)
        $unseen = $head[$mailno_arr[$i]]->Unseen;
        $unseen = ($unseen == "U")? "unseen":"seen";
        ?>
        <td><a class= <?php echo $unseen ?> onclick="change_href(event, '<?php echo $from_addr; ?>')"
            href="<?php echo site_url(); ?>/mailbox/mail_detail?boxname=<?php echo $mbox2 ?>&mailno=<?php echo $mailno_arr[$i] ?>">
            <?php echo $from_name; ?></a></td>
        <td><a class=<?php echo $unseen ?> href="<?php echo site_url(); ?>/mailbox/mail_detail?boxname=<?php echo $mbox2 ?>&mailno=<?php echo $mailno_arr[$i] ?>">
            <!-- <?php // echo '<pre>'; var_dump($head[$mailno_arr[$i]]); echo '</pre>';?></a></td> -->
            <?php echo imap_utf8($head[$mailno_arr[$i]]->subject)?></a></td>
        <td style="color: darkgray; font-weight: 400;"><?php echo date("y.m.d", $head[$mailno_arr[$i]]->udate)?></td>
        <!-- 시, 분은 H:i -->
        <?php
          $size = round(($head[$mailno_arr[$i]]->Size)/1024, 1);
          ($size < 1000)? $size .= 'KB' : $size = round($size/1000, 1).'MB';
         ?>
        <td style="color: darkgray; font-weight: 400; padding-left: 20px"><?php echo $size ?></td>
      </tr>
      <tr>
        <td colspan="6" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <?php
        } // if
      } // for
       ?>
       </form>
    </tbody>
  </table>
  <div class="" style="text-align: center">
    <?php echo $links.'<br><br>' ?>
  </div>
  <!-- <p style="text-align: center; letter-spacing: 7px"><?php echo $links.'<br>' ?></p> -->
</div>
</div>

<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_footer.php";
 ?>

 <script type="text/javascript">

 // 테스트
 // $(function() {
 //   let arr = [];
 //   $.ajax({
 //     url: "<?php // echo site_url(); ?>/mailbox/decode_mailbox",
 //     type: 'POST',
 //     dataType: 'json',
 //     success: function (result) {
 //       for(let i=0; i<result.length; i++) {
 //         arr.push(result[i].text);
 //       }
 //     }
 //   });
 //   console.log(arr);
 // })

 // 검색
 function search_mail(ths) {
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

 // 상단 체크박스 클릭시 전체선택/해제 설정
 function check_all(chk_all) {
   let top_buttons = document.getElementsByClassName('top_button');
   for(var i = 0; i < top_buttons.length; i++ ){
     top_buttons[i].disabled = (chk_all.checked)? false : "disabled";
   }
   for(var i=0; i<document.frm.length; i++)
    if(document.frm[i].name == 'checkbox') document.frm[i].checked = chk_all.checked;
 };

 // 체크박스 하나 클릭시
 function check_one() {
   let checked = false;
   let top_buttons = document.getElementsByClassName('top_button');
   for(var i=0; i<document.frm.length; i++) {
    if(document.frm[i].checked) {
      for(var i = 0; i < top_buttons.length; i++ ){
        top_buttons[i].disabled = false;
      }
      checked = true;
    }
   }
   if(!checked)
    for(var i = 0; i < top_buttons.length; i++ )  top_buttons[i].disabled = "disabled";
   //  if(document.frm[i].name == 'checkbox') document.frm[i].checked = chk_all.checked;
 };

 // 중요메일 체크
 function starClick(ths) {
   let childNodes = ths.childNodes;
   let imgTag = childNodes[1];
   let className = imgTag.className;
   if(className == "emptyStar") {
     imgTag.src = "/devmail/misc/img/btn/star2.png";
     imgTag.className = "fullStar";
   }else {
     imgTag.src = "/devmail/misc/img/btn/star1.png";
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
