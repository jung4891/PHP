<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>

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
 <div id="" style="width:100%; max-height:100%; margin:20px 0px 80px 0px; padding-left: 20px; ">
     <input type="hidden" id="reply_from" name="reply_from" value="<?php echo $mail_info["from"]["email"]; ?>">
     <input type="hidden" id="reply_to" name="reply_to" value="<?php echo $reply_to_input["input"]; ?>">
     <input type="hidden" id="reply_cc" name="reply_cc" value="<?php echo $reply_cc_input["input"]; ?>">
   <form class="" id="reply_form" name="reply_form" action="" method="post">
     <input type="hidden" id="reply_mode" name="reply_mode" value="">
     <input type="hidden" id="reply_target_to" name="reply_target_to" value="">
     <input type="hidden" id="reply_target_cc" name="reply_target_cc" value="">
     <input type="hidden" id="reply_title" name="reply_title" value="">
     <input type="hidden" id="reply_content" name="reply_content" value="">
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
           <!-- <button type="button" class="btn_basic btn_white" style="width:60px; height: 25px" onclick="go_list()">목록</button> -->
         </td>
       </tr>
       <!-- <tr style="text-align: right">
         <td><?php echo date("Y-m-d H:i", $mail_info["udate"]); ?></td>
       </tr> -->
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

      <?php if ($attachments != "") { ?>
       <tr>
         <td colspan="2">
           <hr style="border: 1px solid #dedede;">
         </td>
       </tr>
       <tr><td style="font-weight: bold; padding-bottom: 3px; ">첨부파일</td></tr>
       <tr>
         <td bgcolor="#F7F7F7" style="width: 530px">
           <?php echo $attachments; ?>
         </td>
       </tr>
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
         <?php  //var_dump($struct); ?>
       </pre> -->
       <!-- <pre>
         <?php // var_dump($body); ?>
       </pre> -->
     </tr>
   </table>
 </div>
</div>


<script type="text/javascript">

  function go_list() {
    alert('구현중..');
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
      var re_title = " RE: "+title;
      $("#reply_title").val(re_title);
    }else if (mode == 2) {
      var exp_to = to.split(",");
      for(var i = 0; i < exp_to.length; i++) {
        if(exp_to[i] == from)  {
          exp_to.splice(i, 1);
          i--;
        }
      }
      var exp_cc = cc.split(",");
      for(var i = 0; i < exp_cc.length; i++) {
        if(exp_cc[i] == from)  {
          exp_cc.splice(i, 1);
          i--;
        }
      }
      $("#reply_target_to").val(exp_to.join(","));
      $("#reply_target_cc").val(exp_cc.join(","));
      var re_title = " RE: "+title;
      $("#reply_title").val(re_title);
    }else{
      $("#reply_target_to").val("");
      $("#reply_target_cc").val("");
      var re_title = " FW: "+title;
      $("#reply_title").val(re_title);
    }

    $("#reply_form").attr("method","post");
    $("#reply_form").attr("action", "<?php echo site_url(); ?>/mail_write/page");
    $("#reply_form").submit();


  }


</script>

<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
?>
