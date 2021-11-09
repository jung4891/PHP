<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_side.php";
 ?>

 <style media="screen">
   a.visit:visited {color: black}
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
      </tr>
      <tr>
        <!-- <th>U</th> -->
        <!-- <th>No</th> -->
        <td><input type="checkbox" onClick="check_all(this);"> </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <!-- <td><?php // echo $head[$mailno_arr[$i]]->Unseen?></td>      메일 클릭해서 읽으면 "U" -> ""로 바뀜 -->
        <!-- <td><?php // echo $msg_no?></td> -->
        <td><input type="checkbox" name="chk" value=<?php echo $msg_no;?>></td>
        <td><a class="visit" onclick="test(event, '<?php echo $from_addr; ?>')" href="<?php echo site_url(); ?>/mailbox/mail_detail/<?php echo $box ?>/<?php echo $mailno_arr[$i] ?>">
          <?php echo $from_name; ?></a></td>
        <td><a class="visit" href="<?php echo site_url(); ?>/mailbox/mail_detail/<?php echo $box ?>/<?php echo $mailno_arr[$i] ?>">
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
 var checked = true;
 function check_all(button) {
   // console.log('aa');
   for(var i=0; i<document.frm.length; i++)
    if(document.frm[i].name == 'chk') document.frm[i].checked = checked;
   checked = checked?  false : true;
 };

 // 보낸사람 링크 변경
 function test(e, addr) {
   e.preventDefault();    // a태그 href 이동 이벤트 막음
   location.href='<?php echo site_url(); ?>/mail_write/page';
 };
 // const from_name = document.getElementById('from_name')

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
