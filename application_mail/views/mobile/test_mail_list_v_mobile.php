<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mobile/test_mail_header_mobile.php";
// include $this->input->server('DOCUMENT_ROOT')."/include/mobile/mail_side_mobile.php";

// echo 'decode 전:'.$mbox.'<br>';
// $mbox2 = str_replace(array('#', '&', ' '), array('%23', '%26', '+'), $mbox);   // 아래 함수로 대체함
$mbox_urlencode = urlencode($mbox);
// echo 'decode 후:'.$mbox_urlencode.'<br>';

$request_url = $_SERVER['REQUEST_URI'];
if(!strpos($request_url, 'boxname')) $request_url .= '?boxname=INBOX';   // 로그인한후에는 뒤에 파라미터가 없어서 넣어줌
$_SESSION['list_page_url_tmp'] = substr($request_url, strpos($request_url, '/', 1));    // url에서 /index.php 부분 제외시킴
// $_SERVER['REQUEST_URI'] -> /index.php/mailbox/mail_list?curpage=&searchbox=&boxname=INBOX

 ?>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">

 <!-- IE에서 input date 입력가능하게 설정 (jQuery에서 제공하는 datepicker 기능) -->
 <!-- jQuery에서 제공하는 css 와 js 파일 -->
 <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>
 <!-- <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script> -->
 <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.min.js"></script>

 <!-- toasr을 사용하기 위해 필요한 css와 js파일 -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

 <link rel="stylesheet" href="<?php echo $misc; ?>/css/style.css" type="text/css" charset="utf-8"/>
 <style media="screen">
  .mlist_tbl{
    width:90%;
    table-layout: fixed;
  }
  .mlist_tbl td{
    height: 30px;
    /* border-top: solid 1px #DFDFDF; */
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

  #loading {
  	width: 100%;
  	height: 100%;
  	top: 0;
  	left: 0;
  	position: fixed;
  	display: block;
  	opacity: 0.8;
  	background: white;
  	z-index: 99;
  	text-align: center;
  }

  #loading > img {
  	position: absolute;
  	top: 38%;
  	left: 33%;
  	z-index: 100;
  }

  #visited {
    display: inline-block;
    width: 5px;
    height: 26px;
    background: #b6dbff;
    position: relative;
    top: 4px;
  }

  /* toast 사이즈 및 투명도 설정*/
  #toast-container > div {
      width: 10em;
      opacity: 1;
  }

  /* toast 위치 세부설정 */
  .toast-bottom-right {
    bottom: 9vh;
    left: 53vw;
  }
 </style>

<div id="main_contents" align="center" style="height: 100vh; width: 100vw; display: grid; grid-template-rows: 6vh auto 20vh; ">
  <div class="search_div">
  <!-- <form name="mform" action="" method="post"> -->
      <table style="width:90%; padding-bottom:10px; " border="0" cellspacing="0" cellpadding="0">
        <colgroup>
          <col width="6%" >
          <col width="3%" >
          <col width="3%" >
          <col width="3%" >
          <col width="25%" >
          <col width="*" >
          <col width="10%" >
          <col width="12%" >
        </colgroup>
          <tr>
            <td colspan="8" align="center">
              <div style="display: inline-block; width: 240px; height: 29px; border-radius: 5px; border: solid 1px lightgray;">
                <input type="text" id="search" style="outline: none; margin: 3px; margin-left: 0px; width: 79%; height: 20px; border: none; color: #0575E6; font-size: 16px; font-weight: bold" >
                <a href="javascript:void(0)" onclick="search_mail(this);">
                <img style="width: 17px; position:relative; top:3px " src="<?php echo $misc; ?>/img/icon/search.png" alt="">
                </a>
              </div>

              <div id="loading" style="display:none">
                <img src="<?php echo $misc; ?>/img/icon/loading.svg" alt="loading.." style="width: 130px">
              </div>

              <!-- div의 z-index가 이전엔 -1이여서 아래 a태그의 onclick까지 먹통이 되어서 0으로 수정함  -->
              <div style="display: inline-block; cursor: pointer; width: 60px; height: 27px; border-radius: 5px; position: relative; top: -1px; left: 5px; border: solid 1px lightgray; background-color: rgb(220,220,220); text-align: center; z-index: 0">
                <a onclick="search_detail(this);" style="position: relative; top: 0px; font-weight: 400; color: gray; font-size: 14px">
                  상세 <img style="position: relative; top: 2px; left: 2px; width: 15px" src="<?php echo $misc; ?>/img/icon/아래.svg" alt="">
                </a>
              </div>
            </td>

            <!-- <td></td> -->
            <!-- <td>
            <select id="show_cnt" class="input" onchange="mails_cnt(this);" style="background-color: rgb(220,220,220); width: 85px; height: 28px; border-radius: 5px; font-weight: bold; color: gray; font-size: 12px; cursor: pointer; float:right;"  >
              <option value="" style="text-align: center">보기설정</option>
              <option value="10">10개</option>
              <option value="20">20개</option>
              <option value="30">30개</option>
            </select>
            </td> -->
          </tr>

          <tr>
            <td colspan="5"></td>
            <td colspan="3">
              <div id="search_detail"  style="display:none; position: absolute; left: 80px; margin-top: 4px; background-color: white; border: 2px solid lightgray; width: 254px; z-index: 1">
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
  <!-- </form> -->
  </div>

  <div class="main_div">
  <!-- <?php // echo $test_msg; ?> <br><br> -->
  <table class="mlist_tbl" border="0" cellspacing="0" cellpadding="0" style="table-layout: fixed;" >
    <colgroup>
      <col width="8%" >
      <col width="70%">
      <col width="15%" >
      <!-- <col width="3%" >
      <col width="3%" >
      <col width="3%" >
      <col width="25%" >
      <col width="*" >
      <col width="10%" >
      <col width="12%" > -->
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
          if(!isset($mail_list_info[$i])) break;        // offset 애러처리
          $msg_no = trim($mail_list_info[$i]['mail_no']);
          $mail_name = $mail_list_info[$i]['mail_name'];
      ?>

        <tr data-msgno="<?php echo $msg_no; ?>">

          <!-- 메일목록 출력 -->
          <!-- <td><?php // echo $head[$mailno_arr[$i]]->Unseen ?></td> -->
          <td name="msg_no_td" style="display:none;"><?php echo $msg_no?></td>
          <!-- <td name="ipcountry_td" style="text-align:center;"></td> -->
          <td onclick="event.cancelBubble=true">
            <input type="checkbox" name="chk" value=<?php echo $msg_no;?>>
          </td>

          <?php
          // get방식으로 데이터를 직접 url에 적으면 &가 데이터 구별기호로 인식되서 바꿔줘야함
          // (위에서 아싸리 바꿔줌 함수 사용해서.)
          // $mbox2 = str_replace(array('#', '&', ' '), array('%23', '%26', '+'), $mbox);

          // 메일 읽은경우/읽지 않은경우 class명 지정하여 색 변경 (메일 읽으면 "U" -> ""로 바뀜)
          $unseen = ($mail_list_info[$i]['unseen'] == "U")? "unseen":"seen";
          ?>
          <td>
            <div style="position:relative; top:-3px">
              <a class= <?php echo $unseen ?> href="javascript:void(0);" onclick="detail_mailview(<?php echo $msg_no?>, '<?php echo $mail_name ?>');" style="font-weight: bold">
                <?php
                $from_name = $mail_list_info[$i]['from']['from_name'];
                $to_name = $mail_list_info[$i]['to']['to_name'];
                // 보낸메일함은 받는사람 표기
                if(strpos($mbox, '&vPSwuA- &07jJwNVo-') === 0) {
                  echo (isset($to_name))? $to_name : '(이름 없음)' ;
                // 그외 메일함은 보낸사람 표기
                }else {
                  echo (isset($from_name))? $from_name : '(이름 없음)' ;
                }
                ?>
              </a>
          </div>
            <span style="display: none">
              <?php
              $from_name_full = $mail_list_info[$i]['from']['from_name_full'];
              $to_name_full = $mail_list_info[$i]['to']['to_name_full'];
              // 요부분은 회신할때 보낸사람 받는사람 이름<주소> 형식으로 출력되도록 처리함
              if(strpos($mbox, '&vPSwuA- &07jJwNVo-') === 0) {
                echo htmlspecialchars($to_name_full);
              }else {
                echo htmlspecialchars($from_name_full);
              }
              ?>
            </span>
          </td>
          <td style="color: darkgray; font-weight: 400; font-size: 10px;" align="center">
            <?php echo $mail_list_info[$i]['date'];?>
          </td>
          <!-- <td><?php echo $mail_list_info[$i]['size'] ?></td> -->
        </tr>
        <tr>
          <td></td>
          <td style="text-overflow:ellipsis; overflow:hidden; white-space:nowrap; font-size: 12px;"  onclick="detail_mailview(<?php echo $msg_no?>, '<?php echo $mail_name ?>');">
            <div style="position:relative; top:-7px">
              <span id="<?php echo $msg_no.'_span' ?>" ></span>
              <a class=<?php echo $unseen ?> href="javascript:void(0)" title="<?php echo $mail_list_info[$i]['subject']?>">
                <?php
                  $subject = $mail_list_info[$i]['subject'];
                  if(strlen($subject) > 45) {
                    $subject = iconv_substr($subject, 0, 20, "utf-8").'...';  // 한글깨짐 방지해서 잘라내기
                    // $subject = substr($subject, 0, 45).'...';        // 그냥 영문/한글/띄어쓰기 모두 1임
                  }
                  echo $subject?>
              </a>
          </div>
          </td>
          <td align="center">
            <div style="position:initial; margin:-17px">

              <?php if($mail_list_info[$i]['attached']) { ?>
                <img src="/misc/img/icon/첨부(본문)2.svg" alt="ss" width="20px">
              <?php }else {?>
                <img src="/misc/img/icon/첨부(본문).svg" alt="ss">
              <?php } ?>

              <a href="javascript:void(0);" onclick="starClick(this); " >
                <?php if($mail_list_info[$i]['flagged'] == "F") {?>
                  <img class="fullStar" src="/misc/img/icon/중요(본문)2.svg" alt="" width="20px">
                <?php   }else {?>
                  <img class="emptyStar" src="/misc/img/icon/중요(본문).svg" alt="" width="20px">
                <?php   } ?>
              </a>

            </div>
          </td>
        </tr>
        <?php
        }
        ?>
      </form>
    </tbody>
  </table>
</div>

<div class="paging_div" style="text-align: center; padding-top: 15px">
  <?php echo $links; ?>
</div>

<div class="choose_div" style="display: none; background-color: black; padding-top: 5%;">
  <div class="" style="width: 5%">
  </div>
  <div class="" style="width: 20%; color: white;" onclick="check_all();">
    <div height=30 align="center">
      <img src="<?php echo $misc;?>img/mobile/전체선택.svg" style="cursor:pointer;">
    </div>
    <span style="font-size: 0.8em; display: block;">전체선택</span>
  </div>
  <div class="" style="width: 20%; color: white">
    <div height=30 align="center">
      <!-- <img src="<?php echo $misc;?>img/mobile/이동.svg" style="cursor:pointer;"> -->
    </div>
    <span>
      <label for="selected_box">
        이동
        <select id="selected_box" onchange="move();" style="font-size: 0.8em; display: block;">
          <option hidden="" disabled="disabled" selected="selected" value="" >선택</option>
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
      </label>
    </span>
  </div>
  <style media="screen">
    #selected_box {
      height: 100%;
      width: 100%;
    }
    select {
      -webkit-appearance:none; /* 크롬 화살표 없애기 */
      -moz-appearance:none; /* 파이어폭스 화살표 없애기 */
      appearance:none; /* 화살표 없애기 */
      background-color: black;
      color: white;

      border: none;
      text-align: center;
      font-size: 1em;
      padding-bottom: 28px;
    }
    select:focus {
      outline: none;
    }
  </style>

  <div class="" style="width: 20%; color: white">
    <div height=30 align="center">
      <img src="<?php echo $misc;?>img/mobile/답장.svg" style="cursor:pointer;">
    </div>
    <span style="font-size: 0.8em; display: block;">답장</span>
  </div>
  <div class="" style="width: 20%; color: white" onclick="move_spam();">
    <div height=30 align="center">
      <img src="<?php echo $misc;?>img/mobile/스팸.svg" style="cursor:pointer;">
    </div>
    <span style="font-size: 0.8em; display: block;">스팸</span>
  </div>
  <?php if($mbox == "&ycDGtA- &07jJwNVo-") {  // 휴지통 ?>
    <div class="" style="width: 20%; color: white" onclick="del_ever();">
      <div height=30 align="center">
        <img src="<?php echo $misc;?>img/mobile/영구삭제.svg" style="cursor:pointer;">
      </div>
      <span style="font-size: 0.8em; display: block;">영구삭제</span>
    </div>
  <?php }else {?>
    <div class="" style="width: 20%; color: white" onclick="del_trash();">
      <div height=30 align="center">
        <img src="<?php echo $misc;?>img/mobile/휴지통.svg" style="cursor:pointer;">
      </div>
      <span style="font-size: 0.8em; display: block;">삭제</span>
    </div>
  <?php } ?>
  <div class="" style="width: 5%">
  </div>
</div>





<!-- <div class="move_div" style="display:none; border: 1px solid red">
  <select class="top_button" id="selected_box" style="background-color: #ddf428; height: 20px; padding-top: 1px;  border-radius: 10px; " onchange="move();" >
    <option value="" style="text-align: center;">이동할 메일함</option>
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
</div> -->

</div>

<!-- <div id="mobile_footer" style="width: 100vw; height: 8vh; bottom: 0px; border: 1px solid red; background-color: darkgray">
test
</div> -->


<!-- <div id="move_mbox" style="display:none;position: absolute; background: #000; width: 30px; height: 30px; opacity: 0.4; border-radius: 100%;font-size: 20px;color: white; text-align:center;">
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
    </tr> -->

    <!-- <tr>
      <td onclick="reply_mail(1)">
        회신
      </td>
    </tr> -->

  <!-- </table>
</div> -->
<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>


<script type="text/javascript">

 var ip_yn = 1;
 function ip_check(){
   if(ip_yn == 0){

     return false;
   }
   var ip_arr = [];
   var mail_box = "<?php echo $mbox; ?>";
   $('#loading').show();
   $("td[name=ipcountry_td]").each(function(){
     var msg_no = $(this).closest("tr").attr("data-msgno");
     ip_arr.push(msg_no);
   });
   $.ajax({
     type : "post",
     url : "<?php echo site_url(); ?>/mailbox/get_senderip2",
     dataType:"json",
     data : {
       ip_arr: ip_arr,
       mail_box : mail_box
   },
     success : function(result){
       var i = 0;
       $("td[name=ipcountry_td]").each(function(){
         var country = result[i].country;
         var ip = result[i].ip;
         var img = "<img width='25' src='<?php echo $misc; ?>/img/flag/"+country+".png' alt='"+country+"'>";
         $(this).append(img);
         i++;
       });
       ip_yn = 0;
       $("#ip_checkBtn").hide();
       $('#loading').hide();
     },
     error : function(request, status, error){
         console.log("AJAX_ERROR");
         $('#loading').hide();
     }
   });

 }

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
       $('.top_button').css('cursor', 'pointer');
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
       tobox = tobox.replace(/\\'/g, "'");    // 메일함에 '있는경우 애러처리

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

   // 방금 전 읽었던 메일 표시처리하기
   var visited_no = '<?php echo isset($visited_no)? $visited_no : 0 ?>'+'_span';
   if(visited_no !== "") {
     // $("#"+visited_no).attr("id","visited");
   }
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
     var newForm = $('<form id="search_form"></form>');
     newForm.attr("method","get");
     newForm.attr("action", "<?php echo site_url(); ?>/testmailbox/mail_list");
     newForm.append($('<input>', {type: 'hidden', name: 'boxname', value: `<?php echo $mbox ?>`}));
     newForm.append($('<input>', {type: 'hidden', name: 'type', value: 'search' }));
     newForm.append($('<input>', {type: 'hidden', name: 'search_word', value: search_word }));
     newForm.appendTo('body');
     $('#loading').show();
     // setTimeout(function() {
     //  alert('검색결과가 너무 많습니다.\n페이지가 새로고침됩니다.');
     //  location.reload();
     // }, 6000);
     newForm.submit();
   }
 }

 // 대표검색창에 검색어 입력후 엔터키로 검색
 const input = document.querySelector('#search');
 input.addEventListener('keyup', function(e){
   if(e.key === 'Enter') {
     let search_word = $('#search').val();
     if(search_word == "") {
       alert('검색어를 입력하세요');
       $('#search').focus();
     }else {
       var newForm = $('<form id="search_form"></form>');
       newForm.attr("method","get");
       newForm.attr("action", "<?php echo site_url(); ?>/testmailbox/mail_list");
       newForm.append($('<input>', {type: 'hidden', name: 'boxname', value: `<?php echo $mbox ?>`}));
       newForm.append($('<input>', {type: 'hidden', name: 'type', value: 'search' }));
       newForm.append($('<input>', {type: 'hidden', name: 'search_word', value: search_word }));
       newForm.appendTo('body');
       $('#loading').show();
       // setTimeout(function() {
       //  alert('검색결과가 너무 많습니다.\n페이지가 새로고침됩니다.');
       //  location.reload();
       // }, 6000);
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
   var mbox = `<?php echo $mbox; ?>`;
   var type = 'search_detail';
   var newForm = $('<form id="search_form"></form>');
   newForm.attr("method","get");
   newForm.attr("action", "<?php echo site_url(); ?>/testmailbox/mail_list");
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
   $('#loading').show();
  //  setTimeout(function() {
  //   alert('검색결과가 너무 많습니다.\n페이지가 새로고침됩니다.');
  //   location.href = location.href;
  //   // location.href = "" + $(location).attr('href')+ "";
  //   // location.reload();
  //   // location.href = "https://mail.durianict.co.kr/index.php/mailbox/mail_list";
  //   // history.back();
  //   // location.href = "<?php echo site_url(); ?>/mailbox/mail_list?boxname=INBOX";
  // }, 3000);
  newForm.submit();
  })

  // 상세검색창에 검색어 입력후 엔터키로 검색
  const input_detail = document.querySelector('#search_detail');
  input_detail.addEventListener('keyup', function(e){
    if(e.key === 'Enter') {
      if($('#from').val() == "" && $('#to').val() == "" && $('#subject').val() == "" && $('#contents').val() == "" && $('#start_date').val() == "" && $('#end_date').val() == "") {
        alert('검색어를 입력하세요');
        $('#from').focus();
        return;
      }
      // get방식이므로 주소창에 검색하는 애들만 출력되게끔
      var mbox = `<?php echo $mbox; ?>`;
      var type = 'search_detail';
      var newForm = $('<form id="search_form"></form>');
      newForm.attr("method","get");
      newForm.attr("action", "<?php echo site_url(); ?>/testmailbox/mail_list");
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
      $('#loading').show();
     newForm.submit();
    }
  })


 // 상단 체크박스 클릭시 전체선택/해제 설정
 function check_all() {
   chk_cnt = $('input[name="chk"]').length;
   if($('input[name="chk"]:checked').length == chk_cnt) {
     $('input[type="checkbox"]').prop('checked', false);
     $(".paging_div").css('display', 'block');
     $(".choose_div").css('display', 'none');
   }else {
     $('input[type="checkbox"]').prop('checked', true);
   }
 };

 // 체크박스 하나 클릭시
 $('input[name="chk"]').on('click', function(){
   if(this.checked) {
     $(".paging_div").css('display', 'none');
     $(".choose_div").css('display', 'flex');
   }else {
     if($('input').is(":checked") == false){    // 하나라도 체크되어있지 않은 경우
      $(".paging_div").css('display', 'block');
      $(".choose_div").css('display', 'none');
    }
   }
 })

 // 하단창 메일 이동
 function move_mail() {
   // $(".choose_div").css('display', 'none');
   // $('.move_div').css('display', 'block');
 }

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
     url : "<?php echo site_url(); ?>/testmailbox/set_flag",
     type : "get",
     data : {boxname: `<?php echo $mbox ?>`, mailno: mailno, state: className},
   });
 }

 // 페이지 이동
 function go_page(page) {
  var mbox = `<?php echo $mbox; ?>`;
  var per_page = '<?php echo $per_page; ?>';
  var type = '<?php if(isset($type)) echo $type; else echo ""; ?>';
  var search_word = `<?php if(isset($search_word)) echo $search_word; else echo ""; ?>`;
  var from = `<?php if(isset($from)) echo $from; else echo ""; ?>`;
  var to = `<?php if(isset($to)) echo $to; else echo ""; ?>`;
  var subject = `<?php if(isset($subject)) echo $subject; else echo ""; ?>`;
  var contents = `<?php if(isset($contents)) echo $contents; else echo ""; ?>`;
  var start_date = `<?php if(isset($start_date)) echo $start_date; else echo ""; ?>`;
  var end_date = `<?php if(isset($end_date)) echo $end_date; else echo ""; ?>`;
  var newForm = $('<form></form>');
  newForm.attr("method","get");
  newForm.attr("action", "<?php echo site_url(); ?>/testmailbox/mail_list");
  newForm.append($('<input>', {type: 'hidden', name: 'boxname', value: mbox }));
  newForm.append($('<input>', {type: 'hidden', name: 'curpage', value: page }));
  newForm.append($('<input>', {type: 'hidden', name: 'mail_cnt_show', value: per_page }));
  if(type != "") newForm.append($('<input>', {type: 'hidden', name: 'type', value: type }));
  if(search_word != "") newForm.append($('<input>', {type: 'hidden', name: 'search_word', value: search_word }));
  if(from != "") newForm.append($('<input>', {type: 'hidden', name: 'from', value: from }));
  if(to != "")   newForm.append($('<input>', {type: 'hidden', name: 'to', value: to }));
  if(subject != "")  newForm.append($('<input>', {type: 'hidden', name: 'subject', value: subject }));
  if(contents != "")  newForm.append($('<input>', {type: 'hidden', name: 'contents', value: contents }));
  if(start_date != "")  newForm.append($('<input>', {type: 'hidden', name: 'start_date', value: start_date }));
  if(end_date != "")  newForm.append($('<input>', {type: 'hidden', name: 'end_date', value: end_date }));
  if(type == "attachments" || type == "search" || type == "search_detail")
    newForm.append($('<input>', {type: 'hidden', name: 'session', value: 'on' }));
  newForm.appendTo('body');
  newForm.submit();
}

// toast창 위치설정
toastr.options.positionClass = "toast-bottom-right";

// 스팸으로 처리 (우선 정크 메일로 이동. 추후 해당 메일의 보낸사람이 또 보낼경우 스팸메일함으로 자동분류 설정)
 function move_spam(){
   let arr = [];
   for(var i=0; i<document.frm.length; i++) {
    if(document.frm[i].checked) {
      arr.push(document.frm[i].value)
    }
   }
   $.ajax({
     url : "<?php echo site_url(); ?>/testmailbox/mail_move",
     type : "post",
     data : {mbox: `<?php echo $mbox ?>`, to_box: '&yBXQbA- &ulTHfA-', mail_arr: arr},
     success : function(data){
     },
     error : function(request, status, error){
         console.log("AJAX_ERROR");
     },
     complete : function() {
       toastr.success('스팸처리 완료');
       setTimeout('location.reload()', 300);
     }
   });
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
      url : "<?php echo site_url(); ?>/testmailbox/mail_move",
      type : "post",
      data : {mbox: `<?php echo $mbox ?>`, to_box: '&ycDGtA- &07jJwNVo-', mail_arr: arr},
      success : function(data){
        // (data == 1)? alert("삭제되었습니다.") : alert("애러발생");
      },
      error : function(request, status, error){
          console.log("AJAX_ERROR");
      },
      complete : function() {
        toastr.success('삭제완료');
        setTimeout('location.reload()', 300);
        // location.reload();
      }
    });
  }

 // 휴지통에서 완전삭제
  function del_ever(){
    if (confirm("정말 삭제하시겠습니까?") == true) {
      let arr = [];
      for(var i=0; i<document.frm.length; i++) {
        if(document.frm[i].checked) {
          arr.push(document.frm[i].value)
        }
      }
      $.ajax({
        url : "<?php echo site_url(); ?>/testmailbox/mail_delete",
        type : "post",
        data : {mbox: `<?php echo $mbox ?>`, mail_arr: arr},
        complete : function() {
          toastr.success('완전삭제 완료');
          setTimeout('location.reload()', 300);
          // location.reload();
        }
      });
    } else {
      return;
    }
  }

  // 메일함 이동
  function move() {
    const s = document.getElementById('selected_box');
    let to_box = s.options[s.selectedIndex].value;
    to_box = to_box.split("\\").join("");

    let arr = [];
    for(var i=0; i<document.frm.length; i++) {
     if(document.frm[i].checked) {
       arr.push(document.frm[i].value)
     }
    }
    $.ajax({
      url : "<?php echo site_url(); ?>/testmailbox/mail_move",
      type : "post",
      data : {mbox: `<?php echo $mbox ?>`, to_box: to_box, mail_arr: arr},
      complete : function() {
        toastr.success('이동완료');
        setTimeout('location.reload()', 300);
        // location.reload();
      }
    });
 }

   // 보기개수 설정
  //  function mails_cnt(s) {
  //   const cnt = s.options[s.selectedIndex].value;
  //   var mbox = `<?php echo $mbox; ?>`;
  //   var curpage = '<?php echo $curpage; ?>';
  //   var type = '<?php if(isset($type)) echo $type; else echo ""; ?>';
  //   var search_word = '<?php if(isset($search_word)) echo $search_word; else echo ""; ?>';
  //   var from = '<?php if(isset($from)) echo $from; else echo ""; ?>';
  //   var to = '<?php if(isset($to)) echo $to; else echo ""; ?>';
  //   var subject = '<?php if(isset($subject)) echo $subject; else echo ""; ?>';
  //   var contents = '<?php if(isset($contents)) echo $contents; else echo ""; ?>';
  //   var start_date = '<?php if(isset($start_date)) echo $start_date; else echo ""; ?>';
  //   var end_date = '<?php if(isset($end_date)) echo $end_date; else echo ""; ?>';
  //   var newForm = $('<form></form>');
  //   newForm.attr("method","get");
  //   newForm.attr("action", "<?php echo site_url(); ?>/testmailbox/mail_list");
  //   newForm.append($('<input>', {type: 'hidden', name: 'boxname', value: mbox }));
  //   newForm.append($('<input>', {type: 'hidden', name: 'curpage', value: curpage }));
  //   newForm.append($('<input>', {type: 'hidden', name: 'mail_cnt_show', value: cnt }));
  //   if(type != "") newForm.append($('<input>', {type: 'hidden', name: 'type', value: type }));
  //   if(search_word != "") newForm.append($('<input>', {type: 'hidden', name: 'search_word', value: search_word }));
  //   if(from != "") newForm.append($('<input>', {type: 'hidden', name: 'from', value: from }));
  //   if(to != "")   newForm.append($('<input>', {type: 'hidden', name: 'to', value: to }));
  //   if(subject != "")  newForm.append($('<input>', {type: 'hidden', name: 'subject', value: subject }));
  //   if(contents != "")  newForm.append($('<input>', {type: 'hidden', name: 'contents', value: contents }));
  //   if(start_date != "")  newForm.append($('<input>', {type: 'hidden', name: 'start_date', value: start_date }));
  //   if(end_date != "")  newForm.append($('<input>', {type: 'hidden', name: 'end_date', value: end_date }));
  //   if(type == "attachments" || type == "search" || type == "search_detail")
  //     newForm.append($('<input>', {type: 'hidden', name: 'session', value: 'on' }));
  //   newForm.appendTo('body');
  //   newForm.submit();
  // }

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

   function detail_mailview(msg_no, mail_name){
     var mailname_param = (mail_name === "")? "" : "&mailname="+mail_name;  // 상세페이지에서 목록/상위메일이동시 필요
     location.href="<?php echo site_url(); ?>/testmailbox/mail_detail?boxname=<?php echo $mbox_urlencode ?>&mailno="+msg_no+mailname_param;
   }

 </script>
