<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_side.php";
 ?>

 <style media="screen">

  <?php if($head[$mailno_arr[$i]]->Unseen == "U") { ?>
   a.visit {color: blue;}
  <?php } else { ?>
   a.visit {color: black;}
   a.visit:visited {color: black}
  <?php }   // 위 2개 다 black해줘야 읽은 페이지 링크 보라색으로 안뜸 ?>
   /* a.visit:link {color: black};
   a.visit:visited {color: black}; */
   a.visit:hover {text-decoration: underline;};
 </style>

<div id="main_contents" style="margin:unset;">
  <div class="main_div" >
  <!-- <?php // echo $test_msg; ?> <br><br> -->

  <!-- mailboxes 테스트용 -->
  <!-- <?php // echo'<pre>'; var_dump($test); echo '</pre>' ?> <br> -->
  <table border="0" width="98%" style="border-spacing: 7px;">
    <colgroup>
      <col width="5%" >
      <col width="25%" >
      <col width="*" >
      <col width="5%" >
      <col width="5%" >
    </colgroup>
    <thead>
      <tr>
        &nbsp;   <!-- 검색창 -->
        <!-- <pre>
          <?php
            // // 메일박스 가져오기
            // $arr_boxname = array();
            // foreach($mailboxes as $mailbox) {
            //   array_push($arr_boxname, mb_convert_encoding(substr($mailbox, 19), 'UTF-8', 'UTF7-IMAP'));
            // }
            // sort($arr_boxname);
            // // print_r($arr_boxname);
            //
            // // 메일박스명 변경
            // $arr_boxname_side = array();
            // for($i=0; $i<count($arr_boxname); $i++) {
            //   if($arr_boxname[$i] == 'INBOX') $arr_boxname_side[$i] = '전체메일';
            //   elseif($arr_boxname[$i] == '보낸 편지함') $arr_boxname_side[$i] = '보낸메일함';
            //   elseif($arr_boxname[$i] == '임시 보관함') $arr_boxname_side[$i] = '임시보관함';
            //   elseif($arr_boxname[$i] == '정크 메일') $arr_boxname_side[$i] = '스팸메일함';
            //   elseif($arr_boxname[$i] == '지운 편지함') $arr_boxname_side[$i] = '휴지통';
            //   else $arr_boxname_side[$i] = $arr_boxname[$i];
            // }
            // $arr_boxname_side_sorted = $arr_boxname_side;
            // // print_r($arr_boxname_side);
            // sort($arr_boxname_side_sorted);
            // // print_r($arr_boxname_side_sorted);
           ?>
           </pre> -->
      </tr>
      <tr>
        <!-- <th>U</th> -->
        <!-- <th>No</th> -->
        &nbsp;
        <input type="checkbox" onClick="check_all(this);">
        &nbsp;
        <?php if($mbox == "&ycDGtA- &07jJwNVo-") {  // 휴지통?>
        <button type="button" class="top_button" onclick="del_ever();" disabled="disabled">영구삭제</button>
        <?php }else {?>
        <button type="button" class="top_button" onclick="del_trash();" disabled="disabled">삭제</button>
        <?php } ?>

        &nbsp;&nbsp;
        <select class="top_button" id="selected_box" style="background-color: #F0F0F0; height: 25px;" disabled="disabled" >
          <option value="">이동할 메일함</option>
          <?php
            for($i=0; $i<count($arr_boxname_side_sorted); $i++) {
              foreach($arr_boxname_side as $index => $value) {
                if($value == $arr_boxname_side_sorted[$i]) {
                  echo "<option value=\"$arr_boxname[$index]\">$arr_boxname_side_sorted[$i]</option>";
                  break;
                }
              }
            }
          ?>
        </select>

        &nbsp;&nbsp;
        <button type="button" class="top_button" onclick="move();" disabled="disabled">이동</button>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <select onchange="mails_cnt(this);" style="background-color: #F0F0F0;" >
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
      for($i=$page-1; $i<$page+($per_page-1); $i++) {
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
        <!-- <td><?php // echo $head[$mailno_arr[$i]]->Unseen   // 메일 클릭해서 읽으면 "U" -> ""로 바뀜?></td> -->
        <!-- <td><?php // echo $msg_no?></td> -->
        <td><input type="checkbox" name="checkbox" onClick="check_one();" value=<?php echo $msg_no;?>>
          <!-- 메일크기로 첨부파일 유무 파악 -->
          <?php if($head[$mailno_arr[$i]]->Size > 30000) { ?>
          <img src="/devmail/misc/img/icon/attachment.png" alt="ss" style="margin-top: 10px">
          <?php } ?>
        </td>
        <td><a class="visit" onclick="change_href(event, '<?php echo $from_addr; ?>')"
            href="<?php echo site_url(); ?>/mailbox/mail_detail/<?php echo $mbox ?>/<?php echo $mailno_arr[$i] ?>">
            <?php echo $from_name; ?></a></td>
        <td><a class="visit" href="<?php echo site_url(); ?>/mailbox/mail_detail/<?php echo $mbox ?>/<?php echo $mailno_arr[$i] ?>">
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
  <p style="text-align: center; letter-spacing: 7px"><?php echo $links.'<br>' ?></p>
</div>
</div>

<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_footer.php";
 ?>

 <script type="text/javascript">

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
      data : {box: '<?php echo $mbox ?>', to_box: '지운 편지함', mail_arr: arr},
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
        data : {box: '<?php echo $mbox ?>', mail_arr: arr},
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
      data : {box: '<?php echo $mbox ?>', to_box: to_box, mail_arr: arr},
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
    var newForm = $('<form></form>');
    newForm.attr("method","post");
    newForm.attr("action", "<?php echo site_url(); ?>/mailbox/mail_list");
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


 // 나중에 삭제부분
 // <input type=button name=HOWTO22 value="삭 제" class="tk1" onClick="delete();">
 // function delete(){
 //   var count = 0;
 //   for(var i=0;i<document.frm.length;i++){
 //     if(document.frm[i].name == "NO[]" && document.frm[i].checked == true){count++; }
 //   }
 //   if ( count != 0 ){
 //   document.frm.action = "mail_cmd.php?CMD=del";
 //   document.frm.submit();
 //   } else {
 //     alert('삭제할 항목을 선택하세요!');
 //   }
 // }

 </script>
