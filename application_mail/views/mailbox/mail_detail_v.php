<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";

$mbox_urlencode = urlencode($mbox);

// 방문한 메일 표시처리
$visited_arr = array("boxname" => $_GET["boxname"], "mailno" => $_GET['mailno']);
$_SESSION['visited_arr'] = $visited_arr;

// 목록으로 이동시 detail로 들어왔을때의 url정보를 세션에 저장.
//  + 상세페이지 보다가 다른메일함 이동후 다시 되돌아왔을때 그 다른 메일함이 들어가는걸 방지
if(strpos($_SESSION['list_page_url_tmp'], $mbox_urlencode) && !strpos($_SESSION['list_page_url_tmp'], $mbox_urlencode.'.')) {
  $_SESSION['list_page_url'] = $_SESSION['list_page_url_tmp'];
}

 ?>
<style media="screen">
#detail_all_div {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
}

#detail_all_div::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera*/
}


</style>
 <?php
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

// echo '<pre>';
// var_dump($mail_info);
// echo '</pre>';
  ?>
 <link rel="stylesheet" href="<?php echo $misc; ?>/css/style.css" type="text/css" charset="utf-8"/>
 <div id="detail_all_div" style="width:100%; max-height:100%; margin:20px 0px 80px 0px; padding-left: 20px; overflow-x: hidden;overflow-y: auto;">
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
   <div id="send_top" align="left" style="width:95%; padding-bottom:10px;">
     <button type="button" class="btn_basic btn_blue" name="button" id="submit_button" enctype="multipart/form-data" style="width:80px" onclick="reply_mail(1)">회신</button>
     <button type="button" class="btn_basic btn_white" name="" style="width:80px" onclick="reply_mail(2)">전체회신</button>
     <button type="button" class="btn_basic btn_white" style="width:80px" onclick="reply_mail(3)">전달</button>
     <hr style="width:110%; border: 1px solid #dedede; margin: 15px 0px 0px -20px">
   </div>

     <div class="" style="max-height: 100%; overflow-y: auto; overflow-x: hidden">
     <table width="98%" border="0" cellpadding="0" cellspacing="3">
       <tr align="left">
         <th style="font-size: 18px; padding-bottom: 10px;">
           <?php
           echo $mail_info["subject"];
           ?>
         </th>
         <td align="right">
           <?php // echo 'mbox: '.$mbox.'<br>'; ?>
           <?php $mailno = isset($mailname)? $mailname : $mailno;   // 첨부/대표검색은 mailname으로 스크립트에서 처리함 ?>
           <!-- <?php // var_dump($mailno); ?> -->
           <button type="button" class="btn_basic btn_white" style="width:60px" onclick="go_list(`<?php echo $mailno ?>`)">목록</button>
           <img src="<?php echo $misc;?>img/icon/위2.svg" style="position:relative; width:28px; top:7px; cursor:pointer;" onclick="go_up(`<?php echo $mailno; ?>`)">
           <img src="<?php echo $misc;?>img/icon/아래2.svg" style="position:relative; width:28px; top:7px; cursor:pointer;" onclick="go_down(`<?php echo $mailno; ?>`)">
         </td>
       </tr>
       <tr>
         <td><span style="font-weight: bold">보낸사람 &nbsp;</span>
           <?php
            // 보낸사람에서 ks_c_5601-1987 출력 애러 제거
            if(strpos($mail_info["from"]["email"], 'ks_c_5601-1987')) {
              $target = substr($mail_info["from"]["email"], 0, strpos($mail_info["from"]["email"], '?=')+2);
              $rest = substr($mail_info["from"]["email"], strpos($mail_info["from"]["email"], '?=')+2);
              $target = imap_utf8($target);
              $mail_info["from"]["email"] = $target.$rest;
            };
            ?>
           <span id="from_td">
             <?php if($mail_info["from"]["email"] == "")
                      echo "(이름 없음)";
                   else
                      echo $mail_info["from"]["name"]."&lt;".$mail_info["from"]["email"]."&gt;"; ?>
           </span>
         </td>
       </tr>
       <tr>
         <td>
           <span style="font-weight: bold">받는사람 &nbsp;</span>
           <span id="to_td"><?php echo $reply_to_input["text"]; ?></span>
         </td>
       </tr>
       <tr>
        <td>
           <span style="font-weight: bold">참&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;조 &nbsp;</span>
           <span id="cc_td"><?php echo $reply_cc_input["text"]; ?></span>
        </td>
        <td style="color: gray; text-align: right">
          <?php
           $day_arr = [ "일" , "월" , "화" , "수" , "목" , "금" , "토" ];
           $day = $day_arr[date("w", $mail_info["udate"])];
           echo date("y.m.d ($day) H:i", $mail_info["udate"]);
           ?>
        </td>
       </tr>

      <?php if (!empty($attachments)) { ?>
       <tr>
         <td colspan="2">
           <hr style="border: 1px solid #dedede;">
         </td>
       </tr>
       <tr><td style="font-weight: bold; padding-bottom: 3px; ">첨부파일</td></tr>
       <?php foreach ($attachments as $att) {
         $param = "'{$att['mbox']}','{$att['msgno']}','{$att['part_num']}','{$att['encoding']}','".addslashes($att['filename'])."'";

         ?>
         <tr>
          <td>
            <a href="JavaScript:download(<?php echo $param; ?>);"><?php echo $att["filename"]; ?></a><span style='color: silver;margin-left:10px;'><?php echo $att["size"]; ?></span>
          </td>
        </tr>
       <?php
       } ?>
     <?php } ?>
     </table>
   <hr style="width: 98%; border: 1px solid #dedede; margin-left: -10px; margin-bottom: 30px">

   <table class="" width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td id="mail_contents">
         <?php echo $contents; ?>
       </td>
     </tr>
     <tr>
       <!-- <pre>
         <?php // var_dump($flattenedParts); ?>
       </pre> -->
       <!-- <pre>
         <?php  // var_dump($struct); ?>
       </pre> -->
       <!-- <pre>
         <?php // var_dump($body); ?>
       </pre> -->
     </tr>
   </table>
 </div>
</div>


<script type="text/javascript">

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
    var title = "<?php echo $mail_info["subject"]; ?>";
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
