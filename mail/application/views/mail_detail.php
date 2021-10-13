<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>메일 상세화면</title>
  </head>

<?php

// 메일의 구조를 분석하는 함수
function checkstruct($mailstream, $MSG_NO) {
  $struct = imap_fetchstructure($mailstream, $MSG_NO);
  // 메일의 구조를 객체로 리턴함. 인자는 메일스트림과 해당 메일번호임.

  // echo '<pre>';
  // echo var_dump($struct);
  // echo '</pre>';

  $type = $struct->subtype;
  /*
  메일의 타입을 얻음. 크게 PLAIN, MIXED, ALTERNATIVE, RELATED 이렇게 있음
   - PLAIN : 그냥 텍스트 메일. 이건 그냥 출력만 해주면됨
   - MIXED : 첨부파일이 있는 메일. 이게 가장 복잡. 아래 switch문 참고
   - ALTERNATIVE : HTML 형식으로 메일을 보내면 이게 됩니다.
   - RELATED : HTML 형식으로 보낼때 보면 메일안에 이미지를 삽입해서 보낼 수 있습니다.
  */

  switch($type) {
  //   case "PLAIN": // 일반텍스트 메일
  //     echo str_replace("\n", "<br>", imap_fetchbody($mailstream, $MSG_NO, "1"));
  //     // 그냥 본문을 얻어서 출력해 주면 됩니다.
  //     // 본문을 얻는 방법은 위처럼 imap_fetchbody 함수를 사용하는데.. 여기서 세번째
  //     // 인자가 "1" 이렇게 되어 있죠. 이것은 몌일의 body가 boundary라는 것으로 구분
  //     // 되어 여러개가 올 수 있는데 그 중 첫번째 것이란 겁니다.. 당연 텍스트 메일은
  //     // body가 하나밖에 없기에 그냥 무조건 위처럼 하면 됩니다.
  //     break;
  //   case "MIXED": // 첨부파일 있는 메일
  //     /*
  //     이게 좀 복잡하죠. 먼저 위에서 말했듯 첨부파일이 있는 것은 body가 여러개입니다.
  //     즉 첨부파일이 두개인 text 메일일 경우 body는 세개로 나뉘죠..
  //     이 세개의 body를 각각 표현하는 것이 되겠습니다.
  //     */
  //     for($i=0;$i<count($struct->parts);$i++) {
  //       // parts라는 속성에는 boundary로 구분된 body의 개체들이 들어 가게 됩니다.
  //       // 이것의 갯수를 알아서 루프를 돌리는 거죠.
  //
  //       $part = $struct->parts[$i];
  //       $param = $part->parameters[0];
  //       $file_name = Decode($param->value);
  //       // 첨부파일일 경우 파일명 Decode 함수는 어제 말한 제가 만든 거죠...
  //       $mime = $part->subtype; // MIME 타입 혹은 메일의 종류가 리턴됩니다.
  //       $encode = $part->encoding; // encoding
  //
  //       /*
  //       아래 부분을 보면 $mime 이란 변수에 ALTERNATIVE 라는 것이 올수 있게 되어
  //       있습니다.. 즉 OUTLOOK에서 HTML 형식으로 첨부파일을 보내면 대략
  //       -메세지
  //       -첨부파일1
  //       -첨부파일2
  //       -첨부파일3
  //       이렇게 나뉘고 다시 메세지는
  //       ---PLAN
  //       ---HTML
  //       이렇게 나뉘게 됩니다.. 이경우 메세지에 해당하는 부분이 ALTERNATIVE인 거죠..
  //       */
  //       if($mime == "ALTERNATIVE") {
  //         $val = imap_fetchbody($mailstream, $MSG_NO, (string)($numpart+1));
  //         // 해당 part의 번호로 body에서 그 부분만 빼옵니다. 그리곤 이것을
  //         // 화면에 출력하죠.. 아래 함수로.. 이것은 제가 만든 건데.. 나중에 설명하죠.
  //         printOutLook($val);
  //       } else {
  //         printbody($mailstream, $MSG_NO, $i, $encode, $mime, $file_name);
  //         // 첨부파일일 경우 printbody함수를 호출합니다.. 이건 바로 밑에 있는 함수인
  //         // 데 거기서 설명하죠..
  //       }
  //     }
  //     break;

        if($mime == "HTML") {
          $val = imap_fetchbody($mailstream, $MSG_NO, (string)(2));
          echo decode($val).'<br>';
          var_dump($val);
          printbody($mailstream, $MSG_NO, $i, $encode, $mime, $file_name);

        }
      }
    case "ALTERNATIVE":                     // outlook html
      for($i=0; $i<count($struct->parts); $i++) {
        $part = $struct->parts[$i];             // parts[0]은 제목부분, parts[1]은 내용부분
        $param = $part->parameters[0];          // 위 부분이 $param->value에 담겨 있음
        $file_name = decode($param->value);     // 첨부파일일 경우 파일명
        $mime = $part->subtype;                 // 제목은 "PLAIN", 내용은 "HTML"
        $encode = $part->encoding;              // 둘다 3

        // echo '$file_name: '.$file_name.'<br>';  // utf-8 / utf-8
        // echo '$mime: '.$mime.'<br>';            // PLAIN / HTML
        // echo '$encode: '.$encode.'<br><br>';    // 3     /  3
    
        if($mime == "HTML") {
          printbody($mailstream, $MSG_NO, $i, $encode, $mime, $file_name);
        //             mailbox      80     1      3    "HTML"
        }
      }
      break;
  //   case "RELATED": // outlook 본문에 이미지 삽입
  //     for($i=0;$i<count($struct->parts);$i++) {
  //       $part = $struct->parts[$i];
  //       $param = $part->parameters[0];
  //       $file_name = Decode($param->value); // 첨부파일일 경우 파일명
  //       $mime = $part->subtype; // MIME 타입
  //       $encode = $part->encoding; // encoding
  //       if($mime == "ALTERNATIVE") {
  //         $val = imap_fetchbody($mailstream, $MSG_NO, (string)($numpart+1));
  //         printOutLook($val);
  //       } else {
  //         printbody($mailstream, $MSG_NO, $i, $encode, $mime, $file_name);
  //       }
  //     }
  //   break;
  } // switch($type)
} // function checkstruct

// 메일 내용을 출력하는 함수
function printbody($mailstream, $MSG_NO, $numpart, $encode, $mime, $file_name) {
//   $val = imap_fetchbody($mailstream, $MSG_NO, (string)($numpart+1));
//   // 먼저 해당 part의 본문을 받아 옵니다.
//   // 그리고 인자값으로 넘어온 $encode 에 의해 먼저 본문을 decoding 해줍니다.
//   switch($encode) {
//     case 0: // 7bit
//     case 1: // 8bit
//       $val = imap_base64(imap_binary(imap_qprint(imap_8bit($val))));
//       break;
//     case 2: // binary
//       $val = imap_base64(imap_binary($val));
//       break;
//     case 3: // base64
//       $val = imap_base64($val);
//       break;
//     case 4: // quoted-print
//       $val = imap_base64(imap_binary(imap_qprint($val)));
//       break;
//     case 5: // other
//       echo "알수없는 Encoding 방식.";
//       exit;
//   }
//
//   // mime type 에 따라 출력합니다.
//   switch($mime) {
//     case "PLAIN":
//       echo str_replace("\n", "<br>", $val);
//       break;
//     case "HTML":
//       echo $val;
//       break;
//     default:
//       // 첨부파일인 경우이므로 다운로드 할 수 있게 링크를 걸어 줍니다.
//       // echo "<br>첨부: <a href=".mail_down.php?MSG_NO=".$MSG_NO."&PART_NO=".$numpart."" >".$file_name."</a>";   주석풀면 php 안끝남.. ㅡㅡㅋ
//   }
}

// ----------------------
// 메인 시작
// include 선언
// ----------------------

// include ("mail_lib.php"); // 라이브러리 파일엔 지난번 강좌에 있던 Decode라는 함수가 있죠.

$BOX = $this->uri->segment(3);
$MSG_NO = $this->uri->segment(4);

$box = $BOX; // 메일 박스명
if($box == "") $box = "INBOX";
switch($box) {
  case "INBOX":
    $box_name="받은 편지함";
    break;
  case "sent":
    $box_name="보낸 편지함";
    break;
}
?>

  <body bgcolor="#FFFFFF" leftmargin=5 topmargin=20 marginwidth=5 marginheight=20>
    <table width="610" border=0 bgcolor=#527900 cellpadding=4 cellspacing=0>
      <tr>
        <td align=center width="25" bgcolor="#334600"><font face="Wingdings" size="4" color="#FFCC33">.</font></td>
        <td width=95%><font size="3" color="#FFFFFF"><b>편지읽기</b></font></td>
      </tr>
    </table>

    <table width=610 border=0 cellpadding=4 cellspacing=0 bgcolor=#D8D8D8>
      <tr>
        <td class="tk1" width=40%>  </td>
        <td align="right" class="tk1" width=60% height=20%>
        </td>
      </tr>
    </table>

<?php
// $mailserver = "192.168.0.50";
//  $user_id = "test2@durianict.co.kr";
// $user_pass = "durian12#";
  $user_id = "hjsong@durianit.co.kr";
  $user_pass = "durian12#";
  $mailserver = "192.168.0.100";
  $mailstream= @imap_open("{" . $mailserver . ":143/imap/novalidate-cert}INBOX", $user_id, $user_pass);

  if ($mailstream == 0) {
    echo "Error!";
    exit;
  }

  // 메일 헤더 분석
  $head = imap_header($mailstream,$MSG_NO);
  $head->Unseen = "U";

  $date = date("Y년 m월 d일 H시 i분", $head->udate);
  $subject = $head->Subject;
  $subject = decode($subject);

  $from_obj = $head->from[0];                      // 보낸 사람의 이름 또는 메일주소를 얻기위함
  $from_addr = decode($from_obj->mailbox.'@'.$from_obj->host);
  if (isset($from_obj->personal)) {
    $from_name = decode($from_obj->personal);      // 송혁중 (이름이 명시되어 있는 메일)
  } else {
    $from_name = $from_addr;                       // 이름이 명시되어 있지 않은 메일은 메일주소 그대로 출력
  }
  // 여기까지는 mail_list.php와 동일
  ?>

  <table width=610 border=0 cellpadding=2 cellspacing=0 bordercolor=#E8E8E8>
    <tr>
      <td class="tk1" align="center" bgcolor="#EEEEEE" width="100">보낸날짜</td>
      <td class="tk1" bgcolor="#F7F7F7"><?php echo $date;?></td>
    </tr>
    <tr>
      <td class="tk1" align="center" bgcolor="#EEEEEE">보낸이</td>
      <td class="tk1" bgcolor="#F7F7F7"><?php echo "<a href=mailto:$from_addr>$from_name</a>";?></td>
    </tr>
    <tr>
      <td class="tk1" align="center" bgcolor="#EEEEEE">제 &nbsp; 목</td>
      <td class="tk1" bgcolor="#F7F7F7"><?php echo $subject;?></td>
    </tr>
  </table>

  <table width="610" border="0" cellpadding="4">
    <tr>
      <td class="tk1">
        <?php
        checkstruct($mailstream, $MSG_NO);
        imap_close($mailstream);
        ?>
      </td>
    </tr>
  </table>

  <table width=610 border=0 cellpadding=4 cellspacing=0 bgcolor=#D8D8D8>
    <tr>
      <td class="tk1" width=40%></td>
      <td align="right" class="tk1" width=60%>
        <a href="mail_cmd.php?BOX=<?php echo $box;?>&CMD=del&NO[]=<?php echo $MSG_NO;?>">삭제</a>&nbsp;&nbsp;&nbsp;&nbsp;
        [<a href="mail_list.php?BOX=<?php echo $box;?>">목록</a>]
      </td>
    </tr>
  </table>

  <br>

  </body>
</html>

<?php
  function decode($val) {
    if(substr($val,0,2) == "=?") {   // 인코딩 되었는지 여부
      $val_lower = strtolower($val);
      if(strpos($val_lower, "utf-8") || strpos($val_lower, "ks_c_5601-1987")) {  // 제목은 이 두가지 형태로 출력됨
        return imap_utf8($val);
      }
    }
    else {
      return imap_base64($val);
    }
  }
?>
