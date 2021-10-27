<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>
<div id="main_contents" style="margin:unset;">
  <div class="main_div" >
  <?php echo $test_msg; ?> <br><br>
  <!-- <?php echo'<pre>'; var_dump($test); echo '</pre>' ?> <br> -->

  <table border="1" width="1000" >
    <thead>
      <tr>
        <th>U</th>
        <th>No</th>
        <th><input type="checkbox" onClick="check_all(this);"> </th>
        <th>발신자</th>
        <th>제목</th>
        <th>날짜</th>
        <th>크기</th>
      </tr>
    </thead>
    <tbody>
      <form name="frm" method="post">
      <?php
      for($i=$page-1; $i<$page+($per_page-1); $i++) {
        if (isset($mailno[$i])) {
      ?>
      <tr>
        <?php
        /*
         참고
         - 이름+메일주소(송혁중 <go_go_ssing@naver.com>) 으로 출력하려면
           htmlspecialchars(mb_decode_mimeheader($head[$num]->fromaddress))
           - mb_decode_mimeheader() : MIME 인코드(암호화)되어있는 메일의 제목을 디코드(복호화)함
           - htmlspecialchars() : 제목에 포함된 HTML태그를 무효로 처리함
         - $recent = $head->Recent; -> 새메일 여부를 리턴
         -
        */

        // 발신자 이름 or 메일주소 표시
        $from_obj = $head[$mailno[$i]]->from[0];              // 보낸 사람의 이름 또는 메일주소를 얻기위함
        $from_addr = $from_obj->mailbox.'@'.$from_obj->host;  // hjsong@durianit.co.kr
        if (isset($from_obj->personal)) {
          $from_name = imap_utf8($from_obj->personal);        // 송혁중 (이름이 명시되어 있는 메일)
        } else {
          $from_name = $from_addr;          // 이름이 명시되어 있지 않은 메일은 메일주소 그대로 출력
        }
        $msg_no = trim($head[$mailno[$i]]->Msgno);               // 메일번호

        // echo '<pre>';
        // var_dump($head[$mailno[$i]]);
        // echo '</pre>';

        ?>
        <!-- 메일목록 출력 -->
        <td><?php echo $head[$mailno[$i]]->Unseen?></td>   <!-- 메일 클릭해서 읽으면 "U" -> ""로 바뀜 -->
        <td><?php echo $msg_no?></td>
        <td><input type="checkbox" name="chk" value=<?php echo $msg_no;?>></td>
        <td><?php echo "<a href=mailto:$from_addr>$from_name</a>";?></td>
        <td><a href="/index.php/mailbox/mail_detail/<?php echo $mbox ?>/<?php echo $mailno[$i] ?>"><?php echo imap_utf8($head[$mailno[$i]]->subject)?></a></td>
        <td nowrap><?php echo date("Y/m/d H:i", $head[$mailno[$i]]->udate)?></td>
        <td nowrap><?php echo $head[$mailno[$i]]->Size?> bytes</td>
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
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>


 <script type="text/javascript">

 // 상단 체크박스 클릭시 전체선택/해제 설정
 var checked = true;
 function check_all(button) {
   // console.log('aa');
   for(var i=0; i<document.frm.length; i++)
    if(document.frm[i].name == 'chk') document.frm[i].checked = checked;
   checked = checked?  false : true;
 }

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
