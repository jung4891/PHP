
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>메일 리스트</title>
  </head>
  <body>

 <html>
 <body bgcolor="#FFFFFF" leftmargin=5 topmargin=20 marginwidth=5 marginheight=20>
   <form name=frm method=post>
   <?php
     // $box = $BOX;
     // if($box == "") $box = "INBOX";
     //
     // switch($box) {
     //   case "INBOX":
     //    $box_name="받은 편지함";
     //    break;
     //   case "sent":
     //    $box_name="보낸 편지함";
     //    break;
     // }
     $user_id = "hjsong@durianit.co.kr";
     $user_pass = "durian12#";
     $mailserver = "192.168.0.100";

     // $user_id = "test2@durianict.co.kr";
     // $user_pass = "durian12#";
     // $mailserver = "192.168.0.50";
     $box = "INBOX";

     $mailstream= @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $user_id, $user_pass);

     if ($mailstream == 0) {
     echo "Error!";
     exit;
     }
   ?>
   <input type=hidden name=BOX value ="<?echo $box;?>">
   <table width="610" border=0 bgcolor=#527900 cellpadding=4 cellspacing=0>
     <tr>
       <td align=center width="25" bgcolor="#334600">
         <font face="Wingdings" size="4" color="#FFCC33">.</font></td>
       <td width="95%"><font size="3" color="#FFFFFF"><b>편지읽기</b></font></td>
     </tr>
   </table>
   <table width="610" border="0" cellpadding="4" cellspacing="0">
     <tr>
       <td class="tk3">새편지 <?php echo imap_num_recent($mailstream);?>개    <!-- 새로온 메일 수 -->
          총 <?php echo imap_num_msg($mailstream);?>개 </td>                  <!-- 총 메일 수 -->
       <td align=right class="tk3"></td>
     </tr>
   </table>

   <table width="610" border="0" cellpadding="2" cellspacing="1">
     <tr bgcolor="#E8E8E8">
       <td class="tk1" align="right" width="8%">선택</td>
       <td class="tk4" align="center" width=20%>받는이</td>
       <td class="tk4" align="center" width=52%>제 목</td>
       <td class="tk4" align="center" width=20%>날 짜</td>
     </tr>
     <?php
     $mailno = imap_sort($mailstream, SORTDATE, 1);     // 메일을 날짜순으로 내림차순(1)/오름차순(1)하여 정렬된 메일번호가 배열에 담겨 변수에 들어감

     // 메일이 없는 경우
     if(count($mailno) == 0) {
     ?>
     <tr bordercolor="#383838" height=35>
       <td colspan=4 align=center class=tk1>편지함이 비어 있습니다.</td>
     </tr>
     <?php
     }
     // 메일이 있는 경우
     for ($i=0; $i<count($mailno); $i++) {
       $no = $mailno[$i];                       // 가장 최근 메일의 번호부터 가져옴
       $head = imap_header($mailstream, $no);   // 해당 메일의 헤더를 읽습니다.
       $recent = $head->Recent;                 // 새메일 여부를 리턴
       $unseen = $head->Unseen;                 // 메일을 읽었는지 여부를 리턴
       $msgno = trim($head->Msgno);             // 메일번호

       $date = date("Y/m/d H:i", $head->udate); // 메일의 날짜를 얻고
       $subject = $head->Subject;               // 제목을 얻습니다.
       // echo '$subject: '.$subject.'<br>';
       $subject = decode($subject);
       // $subject = imap_utf8($subject);          // 제목의 경우 OUT LOOK에서 보내면 인코딩을 자동으로 하기에 이를 디코딩해야함.

       $from_obj = $head->from[0];              // 보낸 사람의 이름 또는 메일주소를 얻기위함
       $from_addr = decode($from_obj->mailbox.'@'.$from_obj->host);
       if (isset($from_obj->personal)) {
         $from_name = decode($from_obj->personal);      // 송혁중 (이름이 명시되어 있는 메일)
       } else {
         $from_name = $from_addr;                          // 이름이 명시되어 있지 않은 메일은 메일주소 그대로 출력
       }
       // if(strlen($from_name) > 13) $from_name = substr($from_name, 0, 10) . "...";   // 메일주소가 길 경우 뒷부분 ...으로 생락하는 부분

       // echo '$no: '.$no.'<br>';
       // echo '$recent: '.$recent.'<br>';
       // echo '$unseen: '.$unseen.'<br>';
       // echo '$msgno: '.$msgno.'<br>';
       // echo '$date: '.$date.'<br>';
       // echo '$subject: '.$subject.'<br>';
       // echo '$from_name: '.$from_name.'<br>';
       // echo '===========================<br>';

       // echo '<pre>';
       // echo var_dump($head);
       // echo '</pre>';
       ?>

       <tr>
         <td nowrap align=right ><?php echo $unseen;?> <input type=checkbox name=NO[] value=<?php echo $msgno;?>></td>
         <td nowrap><?php echo "<a href=mailto:$from_addr>$from_name</a>";?></td>
         <td nowrap><a href="/mail/index.php/mail/mail_detail/<?php echo $box;?>/<?php echo $no;?>"><?php echo $subject;?></a></td>
         <!-- <td nowrap><a href="/mail_detail.php?BOX=<?php echo $box;?>&MSG_NO=<?php echo $no;?>"><?php echo $subject;?></a></td> -->
         <td nowrap><?php echo $date;?></td>
       </tr>


      <?php
      }
       imap_close($mailstream);
       ?>
   </table>

 <SCRIPT LANGUAGE="JavaScript">
 var selectVal = true;

 function setSelected(button) {
   for(var i=0; i<document.frm.length; i++)
    if(document.frm[i].name == 'NO[]') document.frm[i].checked = selectVal;
   selectVal = selectVal ? false: true;
   if (selectVal) {
     button.value = '전체선택';
   } else {
     button.value = '전체해제';
   }
   return false;    // 없어도 실행은 됨
 }

 function delete(){
   var count = 0;
   for(var i=0;i<document.frm.length;i++){
     if(document.frm[i].name == "NO[]" && document.frm[i].checked == true){count++; }
   }
   if ( count != 0 ){
   document.frm.action = "mail_cmd.php?CMD=del";
   document.frm.submit();
   } else {
     alert('삭제할 항목을 선택하세요!');
   }
 }
 </SCRIPT>

   <table width=900 border="0" bgcolor="#E8E8E8" cellspacing=0 cellpadding=3>
     <tr>
       <td class="tk3"><input type="button" name="Sub2" value="전체선택" onClick="setSelected(this);"></td>
       <td align="right">
         <input type=button name=HOWTO22 value="삭 제" class="tk1" onClick="delete();"> </td>
     </tr>
   </table>
   <br>

  </form>
 </body>
 </html>


  <?php
    function decode($val) {
      if(substr($val,0,2) == "=?") {   // 인코딩 되었는지 여부
        $val_lower = strtolower($val);
        if(strpos($val_lower, "utf-8") || strpos($val_lower, "ks_c_5601-1987")) {  // 제목은 이 두가지 형태로 출력됨
          return imap_utf8($val);
        }
        return imap_base64($val);
      }
      else {
        return $val;
      }
    }
  ?>
