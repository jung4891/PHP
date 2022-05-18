<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
// include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
// include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";

$mbox_urlencode = urlencode($mbox);

// 방문한 메일 표시처리
$visited_arr = array("boxname" => $_GET["boxname"], "mailno" => $_GET['mailno']);
$_SESSION['visited_arr'] = $visited_arr;

// 목록으로 이동시 detail로 들어왔을때의 url정보를 세션에 저장.
//  + 상세페이지 보다가 다른메일함 이동후 다시 되돌아왔을때 그 다른 메일함이 들어가는걸 방지
if(strpos($_SESSION['list_page_url_tmp'], $mbox_urlencode) && !strpos($_SESSION['list_page_url_tmp'], $mbox_urlencode.'.')) {
  $_SESSION['list_page_url'] = $_SESSION['list_page_url_tmp'];
}

function address_text($address){
  if(!empty($address) || count($address)!=0){
    $address_text = "";
    $address_input = "";
    foreach ($address as $ar) {
      $name = $ar["name"];
      $mail = $ar["email"];
      $text = $name."&lt;".$mail."&gt;,";
      $address_text .= $text;
      $address_input .= "{$mail},";
    }

    return array(
      "text" => substr($address_text, 0, -1),
      "input" => substr($address_input, 0, -1)
    );

  }else{
    return array(
      "text" => "",
      "input" => ""
    );
  }
}

$reply_to_input = address_text($mail_info["to"]);
$reply_cc_input = address_text($mail_info["cc"]);

// mailbox_tree 가져오기
$encryp_password = $this->M_account->mbox_conf($_SESSION['userid']);
$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
$key = $this->db->password;
$key = substr(hash('sha256', $key, true), 0, 32);
$decrypted = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);
$mailserver = "192.168.0.100";
// $mailserver = "mail.durianit.co.kr";
$user_id = $_SESSION["userid"];
$user_pwd = $decrypted;
$default_folder = array(
  "INBOX",
  "&vPSwuA- &07jJwNVo-",
  "&x4TC3A- &vPStANVo-",
  "&yBXQbA- &ulTHfA-",
  "&ycDGtA- &07jJwNVo-"
);
// $defalt_fkey = array(
//   "inbox",
//   "sent",
//   "draft",
//   "spam",
//   "trash"
// );

$host = "{" . $mailserver . ":143/imap/novalidate-cert}";
$mails = @imap_open($host, $user_id, $user_pwd);
$folders = imap_list($mails, "{" . $mailserver . "}", '*');
$folders = str_replace("{" . $mailserver . "}", "", $folders);
sort($folders);

$folders_root = $default_folder;
$folders_sub = array();

foreach($folders as $f) {
  if(substr_count($f, '.') == 0) {
    if(in_array($f,$folders_root )){
        continue;
    }
    array_push($folders_root, $f);
  } else {
    array_push($folders_sub, $f);
  }
}
$folders_sorted = array();
foreach($folders_root as $root) {
  array_push($folders_sorted, $root);
  foreach($folders_sub as $sub) {
    $pos_dot = strpos($sub, '.');
    $sub_root = substr($sub, 0, $pos_dot);
    if($sub_root == $root) {
      array_push($folders_sorted, $sub);
    }
  }
}
$folders = $folders_sorted;
$mailbox_tree = array();
for ($i=0; $i < count($folders); $i++) {
  $fid = $folders[$i];
  $mbox_status = imap_status($mails, "{" . $mailserver . "}".$fid, SA_UNSEEN);
  $exp_folder = explode(".", $folders[$i]);
  $length = count($exp_folder);
  $text = mb_convert_encoding($exp_folder[$length-1], 'UTF-8', 'UTF7-IMAP');
  $folderkey = "custom";
  switch($text) {
    case "INBOX":  $text="받은 편지함"; $folderkey="inbox";  break;
    case "보낸 편지함": $folderkey="sent"; break;
    case "임시 보관함": $folderkey="draft";  break;
    case "정크 메일":   $folderkey="spam";  break;
    case "지운 편지함": $folderkey="trash";  break;
  }

  $substr_count = substr_count($folders[$i], ".");
  if($substr_count > 1){
    $parent_folder = implode(".", explode(".", $folders[$i], -1));
  }elseif ($substr_count == 1) {
    $parent_folder = $exp_folder[0];
  }else{
    $parent_folder = "#";
  }
  $tree = array(
    // "name" => $folders[$i],
    "id" => addslashes($fid),
    "parent" => addslashes($parent_folder),
    "text" => $text,
    "child_num" => $substr_count,
    "unseen" => $mbox_status->unseen,
    "folderkey" => $folderkey
    // "state" => array("opened" => true)
  );
  array_push($mailbox_tree, $tree);
}
  ?>

 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 <link rel="stylesheet" href="<?php echo $misc; ?>/css/style.css" type="text/css" charset="utf-8"/>
 <style media="screen">
   #detail_all_div {
       -ms-overflow-style: none; /* IE and Edge */
       scrollbar-width: none; /* Firefox */
   }
   #detail_all_div::-webkit-scrollbar {
       display: none; /* Chrome, Safari, Opera*/
   }
   select {
     -webkit-appearance:none; /* 크롬 화살표 없애기 */
     -moz-appearance:none; /* 파이어폭스 화살표 없애기 */
     appearance:none; /* 화살표 없애기 */
     background-color: black;
     color: white;
     border: none;
     text-align: center;
     font-size: 0.8em;
     width: 30px;
     height: 30px;
     opacity: 0;
     position: relative;
     top: -27px;
     margin-bottom: -30px
   }
   select:focus {
     outline: none;
   }
   #reply_div {
    display: none;
    width: 74px;
    height: 125px;
    padding-left: 8px;
    position: absolute;
    left: 61%;
    top: 9%;
    background-color: white;
    border: 1px solid gray;
    z-index: 1;
   }
 </style>

 <div id="detail_all_div" style="width:100%; max-height:100%; margin:10px 0px 80px 0px; padding-left: 5px; overflow-x: hidden;overflow-y: auto;">
     <input type="hidden" id="reply_from" name="reply_from" value="<?php echo $mail_info["from"]["email"]; ?>">
     <input type="hidden" id="reply_to" name="reply_to" value="<?php echo $reply_to_input["input"]; ?>">
     <input type="hidden" id="reply_cc" name="reply_cc" value="<?php echo $reply_cc_input["input"]; ?>">
   <form class="" id="reply_form" name="reply_form" action="" method="post">
     <input type="hidden" id="reply_mode" name="reply_mode" value="">
     <input type="hidden" id="reply_target_to" name="reply_target_to" value="">
     <input type="hidden" id="reply_target_cc" name="reply_target_cc" value="">
     <input type="hidden" id="reply_title" name="reply_title" value="">
     <input type="hidden" id="reply_content" name="reply_content" value="">
     <input type="hidden" id="reply_file" name="reply_file" value="">
   </form>
   <div id="send_top" style="display:flex; width:95%; margin-left: 5px; justify-content: flex-end">
     <div onClick="go_list(`<?php echo $mailno ?>`)" style="position:absolute; left: 15px;">
       <img src="/misc/img/back.svg" style="width:28px; ">
     </div>
     <div onClick="" style="">
         <div>
           <img src="<?php echo $misc;?>img/mobile/메일확인_이동.svg" style="width:28px">
         </div>
         <select id="selected_box" onchange="move();">
           <option value="" >이동할 메일함 선택</option>
           <?php
           foreach($mailbox_tree as $b) {
             $indent = "";
             for($i=0; $i<$b['child_num']; $i++) {
               $indent .= "&nbsp;";
             }
             echo "<option value=\"{$b["id"]}\">{$indent}{$b['text']}</option>";
           }
           ?>
         </select>
     </div>

     <div onClick="show_reply_div();" style="">
       <img src="/misc/img/mobile/메일확인_답장.svg" style="width:28px; margin-left: 20px">
     </div>
     <div id="reply_div">
       <p enctype="multipart/form-data" onclick="reply_mail(1)">회신</p>
       <p onclick="reply_mail(2)">전체회신</p>
       <p onclick="reply_mail(3)">전달</p>
     </div>

     <?php if($mbox == "&yBXQbA- &ulTHfA-") {  ?>
       <div onClick="" style="">
         <img src="/misc/img/mobile/스팸해제2.svg" style="width:28px; margin-left: 20px;">
       </div>
     <?php }else { ?>
       <div onClick="move_spam();" style="">
         <img src="/misc/img/mobile/스팸_이동.svg" style="width:28px; margin-left: 20px;">
       </div>
     <?php } ?>

     <?php if($mbox == "&ycDGtA- &07jJwNVo-") {  ?>
       <div onClick="del_ever()" style="">
         <img src="/misc/img/mobile/영구삭제2.svg" style="width:28px; margin-left: 15px; margin-right:7px">
       </div>
     <?php }else { ?>
       <div onClick="del_trash()" style="">
         <img src="/misc/img/mobile/휴지통_이동.svg" style="width:28px; margin-left: 15px; margin-right: 7px">
       </div>
     <?php } ?>
   </div>
   <hr style="width: 98%; border: 1px solid #dedede; margin: 8px 0px 15px">

   <div class="" style="max-height: 100%; overflow-y: auto; overflow-x: auto; width: 97%; margin: 0 5px;">
     <table width="98%">
       <tr align="left">
         <th style="font-size: 18px; padding-bottom: 10px; width: 86%">
           <?php
           echo $mail_info["subject"];
           ?>
         </th>
         <td align="right" rowspan="2" style="vertical-align: top">
           <?php // echo 'mbox: '.$mbox.'<br>'; ?>
           <?php $mailno = isset($mailname)? $mailname : $mailno;   // 첨부/대표검색은 mailname으로 스크립트에서 처리함 ?>
           <!-- <?php // var_dump($mailno); ?> -->
           <img src="<?php echo $misc;?>img/icon/위2.svg" style="position:relative; width:25px; cursor:pointer;" onclick="go_up(`<?php echo $mailno; ?>`)">
           <img src="<?php echo $misc;?>img/icon/아래2.svg" style="position:relative; width:25px; top:3px; cursor:pointer;" onclick="go_down(`<?php echo $mailno; ?>`)">
         </td>
       </tr>
       <tr>
        <td style="color: gray; text-align: left">
         <div class="" style="position:relative; top:-5px; padding-bottom: 6px">
             <?php
             $day_arr = [ "일" , "월" , "화" , "수" , "목" , "금" , "토" ];
             $day = $day_arr[date("w", $mail_info["udate"])];
             echo date("y.m.d ($day) H:i", $mail_info["udate"]);
             ?>
         </div>
        </td>
        <td></td>
       </tr>
     </table>
     <table width="98%" style="word-break:break-all; border-spacing:0 3px;">
       <tr>
         <td style="width: 23%">
           <span style="font-size: 15px; color: silver">보낸사람 &nbsp;</span>
         </td>
         <td>
           <?php
            // 보낸사람에서 ks_c_5601-1987 출력 애러 제거
            if(strpos($mail_info["from"]["email"], 'ks_c_5601-1987')) {
              $target = substr($mail_info["from"]["email"], 0, strpos($mail_info["from"]["email"], '?=')+2);
              $rest = substr($mail_info["from"]["email"], strpos($mail_info["from"]["email"], '?=')+2);
              $target = imap_utf8($target);
              $mail_info["from"]["email"] = $target.$rest;
            };
            ?>
           <span id="from_td" style="font-size: 15px;">
             <?php if($mail_info["from"]["email"] == "")
                      echo "(이름 없음)";
                   else
                      echo $mail_info["from"]["name"]."&lt;".$mail_info["from"]["email"]."&gt;"; ?>
           </span>
         </td>
       </tr>
       <tr>
         <td>
           <span style="font-size: 15px; color: silver">받는사람 &nbsp;</span>
         </td>
         <td>
           <span id="to_td" style="font-size: 15px"><?php echo $reply_to_input["text"]; ?></span>
         </td>
       </tr>
       <tr>
         <td>
           <span style="font-size: 15px; color: silver">참&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;조 &nbsp;</span>
         </td>
         <td>
          <span id="cc_td" style="font-size: 15px"><?php echo $reply_cc_input["text"]; ?></span>
         </td>
       </tr>
      </table>
      <table>
      <?php if (!empty($attachments)) { ?>
      <hr style="width: 96%; border: 1px solid #dedede; margin: 7px 0px">
       <tr><td style="font-size: 15px; color: silver; padding-bottom: 3px; ">첨부파일</td></tr>
       <?php foreach ($attachments as $att) {
         $param = "'{$att['mbox']}','{$att['msgno']}','{$att['part_num']}','{$att['encoding']}','".addslashes($att['filename'])."'";
         ?>
         <tr>
          <td style="font-size: 15px;">
            <a href="JavaScript:download(<?php echo $param; ?>);"><?php echo $att["filename"]; ?></a>
            <span style='color: silver;margin-left:10px;'><?php echo $att["size"]; ?></span>
          </td>
        </tr>
       <?php
       } ?>
     <?php } ?>
     </table>
     <hr style="width: 96%; border: 1px solid #dedede; margin: 7px 0px">

     <table width="98%" style="margin-top: 22px;">
       <tr>
         <td id="mail_contents">
           <?php echo $contents; ?>
         </td>
       </tr>
       <tr>
         <!-- <pre>
           <?php // var_dump($flattenedParts); ?>
           <?php // var_dump($struct); ?>
           <?php // var_dump($body); ?>
         </pre> -->
       </tr>
     </table>
   </div>
  </div>


<script type="text/javascript">

function show_reply_div() {
  if($("#reply_div").css("display") == "none"){
      $("#reply_div").show();
  } else {
      $("#reply_div").hide();
  }
}

// 메일함 이동
function move() {
  const s = document.getElementById('selected_box');
  let to_box = s.options[s.selectedIndex].value;
  to_box = to_box.split("\\").join("");

  let arr = [];
  arr.push(`<?php echo $mailno ?>`);
  $.ajax({
    url : "<?php echo site_url(); ?>/mailbox/mail_move",
    type : "post",
    data : {mbox: `<?php echo $mbox ?>`, to_box: to_box, mail_arr: arr},
    success : function() {
      alert('메일이 이동되었습니다.');
      go_list();
    }
  });
}

function move_spam(){
  let arr = [];
  arr.push(`<?php echo $mailno ?>`);

  $.ajax({
    url : "<?php echo site_url(); ?>/mailbox/mail_move",
    type : "post",
    data : {mbox: `<?php echo $mbox ?>`, to_box: '&yBXQbA- &ulTHfA-', mail_arr: arr},
    success : function(data){
      alert('스팸메일로 처리되었습니다.');
      go_list();
    }
  });
}

function del_trash(){
  let arr = [];
  arr.push(`<?php echo $mailno ?>`);

  $.ajax({
    url : "<?php echo site_url(); ?>/mailbox/mail_move",
    type : "post",
    data : {mbox: `<?php echo $mbox ?>`, to_box: '&ycDGtA- &07jJwNVo-', mail_arr: arr},
    success : function(data){
      alert('삭제되었습니다.');
      go_list();
    }
    // complete : function() {
    //   location.reload();
    // }
  });
}

function del_ever() {
    if (confirm("정말 삭제하시겠습니까??") == true) {
      let arr = [];
      arr.push(`<?php echo $mailno ?>`);

      $.ajax({
        url : "<?php echo site_url(); ?>/mailbox/mail_delete",
        type : "post",
        data : {mbox: `<?php echo $mbox ?>`, mail_arr: arr},
        success : function(data){
          alert('영구삭제 되었습니다.');
          go_list();
        }
      });
    } else {
      return;
    }
}

// 목록으로 이동
function go_list(mailno) {

  // mailno -> index + mail_cnt_show -> curpage (ajax로 안보내고 스크립트에서 바로 처리)
  <?php
    // mailno -> index
    $mailno_arr = $_SESSION['mailno_arr'];
    $index_now = array_search($mailno, $mailno_arr);

    // index + mail_cnt_show -> curpage
    $list_page_url = isset($_SESSION['list_page_url'])? $_SESSION['list_page_url'] : '/mailbox/mail_list?'; // biz -> 상세페이지 애러처리
    $pattern = '/mail_cnt_show=[0-9]+/';
    $reg = preg_match($pattern, $list_page_url, $res);
    if($reg) {
      $mail_cnt_show = (int)str_replace('mail_cnt_show=', '', $res[0]);
    }else {
      $mail_cnt_show = 15;
    }
    $curpage = floor($index_now / $mail_cnt_show) + 1;

    // url에 curpage 파라미터 추가
    $pattern = '/&curpage=[0-9]+/';
    $reg = preg_match($pattern, $list_page_url, $res);
    if($reg) {
      $list_page_url = str_replace($res[0], '', $list_page_url);
    }
    $list_page_url .= "&curpage=$curpage";
   ?>

  // console.log(`<?php // echo $list_page_url ?>`);
  var list_page_url = `<?php echo site_url().$list_page_url ?>`;
  location.href = list_page_url;
}

  // 상위메일(최근에 온것)로 이동
  function go_up(mailno) {
    // 첨부/대표검색인 경우
    if(mailno.length > 10) {
      $.ajax({
        url : "<?php echo site_url(); ?>/mailbox/get_next_no_name",
        type : "post",
        data : {mbox: `<?php echo $mbox_urlencode ?>`, mail_name: mailno, way: 'up'},
        success : function(res){
          if(res == "x") {
            alert("메일함의 첫번째 메일입니다.");
          }else {
            var next_arr = res.split(' ');
            var next_no = next_arr[1];
            var mail_name = next_arr[0];
            location.href = "<?php echo site_url(); ?>/mailbox/mail_detail?boxname=<?php echo $mbox_urlencode ?>&mailno="+next_no+"&mailname="+mail_name;
          }
        },
        error : function(request, status, error){
          console.log("AJAX_ERROR");
        }
      });
    // 그외 일반적인 경우
    }else {
      $.ajax({
        url : "<?php echo site_url(); ?>/mailbox/get_next_mailno",
        type : "post",
        data : {mbox: `<?php echo $mbox_urlencode ?>`, mail_no: mailno, way: 'up'},
        success : function(next_no){
          if(next_no == "x") {
            alert("메일함의 첫번째 메일입니다.");
          }else {
            location.href = "<?php echo site_url(); ?>/mailbox/mail_detail?boxname=<?php echo $mbox_urlencode ?>&mailno="+next_no;
          }
        },
        error : function(request, status, error){
          console.log("AJAX_ERROR");
        }
      });
    }
  }

  // 하위메일(나중에 온것)로 이동
  function go_down(mailno) {
    // 첨부/대표검색인 경우
    if(mailno.length > 10) {
      $.ajax({
        url : "<?php echo site_url(); ?>/mailbox/get_next_no_name",
        type : "post",
        data : {mbox: `<?php echo $mbox_urlencode ?>`, mail_name: mailno, way: 'down'},
        success : function(res){
          if(res == "x") {
            alert("메일함의 마지막 메일입니다.");
          }else {
            var next_arr = res.split(' ');
            var next_no = next_arr[1];
            var mail_name = next_arr[0];
            location.href = "<?php echo site_url(); ?>/mailbox/mail_detail?boxname=<?php echo $mbox_urlencode ?>&mailno="+next_no+"&mailname="+mail_name;
          }
        },
        error : function(request, status, error){
          console.log("AJAX_ERROR");
        }
      });
    // 그외 일반적인 경우
    }else {
      $.ajax({
        url : "<?php echo site_url(); ?>/mailbox/get_next_mailno",
        type : "post",
        data : {mbox: `<?php echo $mbox_urlencode ?>`, mail_no: mailno, way: 'down'},
        success : function(next_no){
          if(next_no == "x") {
            alert("메일함의 마지막 메일입니다.");
          }else {
            location.href = "<?php echo site_url(); ?>/mailbox/mail_detail?boxname=<?php echo $mbox_urlencode ?>&mailno="+next_no;
          }
        },
        error : function(request, status, error){
          console.log("AJAX_ERROR");
        }
      });
    }
  }

  function download(box, msg_no, part_no, encoding, f_name) {
    var newForm = $('<form></form>');
    newForm.attr("method","post");
    newForm.attr("action", "<?php echo site_url(); ?>/mailbox/download");
    // site_url() : http://dev.mail.durianit.co.kr/index.php

    newForm.append($('<input>', {type: 'hidden', name: 'box', value: box }));
    newForm.append($('<input>', {type: 'hidden', name: 'msg_no', value: msg_no }));
    newForm.append($('<input>', {type: 'hidden', name: 'part_no', value: part_no }));
    newForm.append($('<input>', {type: 'hidden', name: 'encoding', value: encoding }));
    newForm.append($('<input>', {type: 'hidden', name: 'f_name', value: f_name }));
    newForm.appendTo('body');
    newForm.submit();
  }

  function reply_mail(mode){

    var from_text = $("#from_td").text();
    var to_text = $("#to_td").text();
    var cc_text = $("#cc_td").text();
    from_text = from_text.replace(/</g, '&lt;').replace(/>/g, '&gt;');
    to_text = to_text.replace(/</g, '&lt;').replace(/>/g, '&gt;');
    cc_text = cc_text.replace(/</g, '&lt;').replace(/>/g, '&gt;');
    var title = `<?php echo $mail_info["subject"]; ?>`;
    var plus_content = "";
    plus_content += "<div style='border:none;border-top:solid #E1E1E1 1.0pt;padding:3.0pt 0cm 0cm 0cm'>";
    plus_content += "<p><span style='font-size:10px;'>-----Original Message-----<br>";
    plus_content += "<b>From : </b>"+from_text+"<br>";
    plus_content += "<b>Sent: </b><?php echo $mail_info["date"] ?>";
    plus_content += "<br>";
    plus_content += "<b>To: </b>"+to_text+"<br>";
    plus_content += "<b>Cc: </b>"+cc_text+"<br>";
    plus_content += "<b>Subject: </b>"+title+"<br>";
    plus_content += "</span></p></div>";

    var contents = $("#mail_contents").html();
    plus_content += contents;
    $("#reply_content").val(plus_content);
    var from = $("#reply_from").val();
    var to = $("#reply_to").val();
    var cc = $("#reply_cc").val();

    $("#reply_mode").val(mode);
    if(mode == 1){
      $("#reply_target_to").val(from);
      $("#reply_target_cc").val("");
      var re_title = "RE: "+title;
      $("#reply_title").val(re_title);
    }else if (mode == 2) {
      // var exp_to = to.split(",");
      // for(var i = 0; i < exp_to.length; i++) {
      //   if(exp_to[i] == from)  {
      //     exp_to.splice(i, 1);
      //     i--;
      //   }
      // }
      // var exp_cc = cc.split(",");
      // for(var i = 0; i < exp_cc.length; i++) {
      //   if(exp_cc[i] == from)  {
      //     exp_cc.splice(i, 1);
      //     i--;
      //   }
      // }
      // $("#reply_target_to").val(exp_to.join(","));
      // $("#reply_target_cc").val(exp_cc.join(","));
      var mymail = "<?php echo $_SESSION["userid"]; ?>";
      if(mymail != from){
        to = from + "," + to;
      }
      $("#reply_target_to").val(to);
      $("#reply_target_cc").val(cc);
      var re_title = "RE: "+title;
      $("#reply_title").val(re_title);
    }else{
      $("#reply_target_to").val("");
      $("#reply_target_cc").val("");
      var re_title = "FW: "+title;
      $("#reply_title").val(re_title);
      <?php if (!empty($attachments)) { ?>
      // var fw_attach = new Object();
      var fw_attach = '<?php echo addslashes(json_encode($attachments)); ?>';
      $("#reply_file").val(fw_attach);
      <?php } ?>

    }

    $("#reply_form").attr("method","post");
    $("#reply_form").attr("action", "<?php echo site_url(); ?>/mail_write/page");
    $("#reply_form").submit();


  }


</script>

<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
?>