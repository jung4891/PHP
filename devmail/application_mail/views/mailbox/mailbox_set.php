<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_side.php";
 ?>
 <style>
   #nav_tbl td{
     min-width: 100px;
     height: 30px;
     border: 1px solid black;
     text-align: center;
     cursor: pointer;
   }
   .pipe {
     color: lightgrey;
     margin-left: 5px;
     margin-right: 5px;
   }
</style>

  <div id="main_contents" align="center">
    <form name="mform" action="" method="post">
      <div class="main_div">
      <table id="nav_tbl" align="left" cellspacing=0>
        <tr>
          <td id="set_mailbox"><a href="<?php echo site_url(); ?>/option/mailbox">메일함 관리</a></td>
          <td id="set_address">주소록 관리</td>
          <td id="set_sign">서명 관리</td>
        </tr>
      </table>
      </div>
    </form>

    <br><br>
    <div class="" align="left" style="margin-left: 45px">
      <?php if(count($mbox_info) == 5) {?>
      <button type="button" name="button" onclick="add_mybox()">내메일함 추가</button>
      <?php }else { ?>
      새 메일함 &nbsp;<input type="text" id="new_mbox" value="">
      <button type="button" name="button" onclick="add_mailbox()">추가</button>
      <?php } ?>
    </div>
    <br>
    <table width="87%">
      <colgroup>
        <col width="15%">
        <col width="25%">
        <col width="20%">
        <col width="40%">
      </colgroup>
      <tr style="background-color: lightgray; height: 30px;">
        <th>구분</th>
        <th>메일함명</th>
        <th>읽지않음/총메일</th>
        <th>관리</th>
      </tr>
      <tr align="center">
        <td rowspan="9">기본메일함</td>
        <td>전체메일</td>
        <td><?php echo $mbox_info[0]["unseen_cnt"].'/'.$mbox_info[0]["mails_cnt"];?></td>
        <td><span onclick="del_trash('INBOX');" style="cursor: pointer">비우기</span><span class="pipe">|</span><span onclick="set_seen('INBOX');" style="cursor: pointer">모두 읽음</span></td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td>보낸메일함</td>
        <td><?php echo $mbox_info[1]["unseen_cnt"].'/'.$mbox_info[1]["mails_cnt"];?></td>
        <td><span onclick="del_trash('보낸 편지함');" style="cursor: pointer">비우기</span><span class="pipe">|</span><span onclick="set_seen('보낸 편지함');" style="cursor: pointer">모두 읽음</span></td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td>임시보관함</td>
        <td><?php echo $mbox_info[2]["unseen_cnt"].'/'.$mbox_info[2]["mails_cnt"];?></td>
        <td><span onclick="del_trash('임시 보관함');" style="cursor: pointer">비우기</span><span class="pipe">|</span><span onclick="set_seen('임시 보관함');" style="cursor: pointer">모두 읽음</span></td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td>스팸메일함</td>
        <td><?php echo $mbox_info[3]["unseen_cnt"].'/'.$mbox_info[3]["mails_cnt"];?></td>
        <td><span onclick="del_trash('정크 메일');" style="cursor: pointer">비우기</span><span class="pipe">|</span><span onclick="set_seen('정크 메일');" style="cursor: pointer">모두 읽음</span></td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td>휴지통</td>
        <td><?php echo $mbox_info[4]["unseen_cnt"].'/'.$mbox_info[4]["mails_cnt"];?></td>
        <td><span onclick="del_ever();" style="cursor: pointer">완전삭제</span><span class="pipe">|</span><span onclick="set_seen('지운 편지함');" style="cursor: pointer">모두 읽음</span></td>
      </tr>
      <tr>
        <td colspan="4" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <?php
        $my_mbox_cnt = count($mbox_info)-6;
        if($my_mbox_cnt == 0) {
       ?>
         <!-- 0 -->
         <tr align="center">
           <td rowspan="1">내메일함</td>
         </tr>
         <tr>
           <td colspan="4" style="border-bottom: 2px solid lightgray; "></td>
         </tr>
       <?php } ?>

       <?php if($my_mbox_cnt == 1) { ?>
         <!-- 1 -->
         <tr align="center">
           <td rowspan="1">내메일함</td>
           <td><?php echo substr($mbox_info[6]["boxname_kor"], 13) ?></td>
           <td><?php echo $mbox_info[6]["unseen_cnt"].'/'.$mbox_info[6]["mails_cnt"];?></td>
           <td>
             <span onclick="del_trash('<?php echo $mbox_info[6]["boxname_kor"] ?>');" style="cursor: pointer">비우기</span><span class="pipe">|</span><span onclick="set_seen('<?php echo $mbox_info[6]["boxname_kor"] ?>');" style="cursor: pointer">모두 읽음</span><span class="pipe">|</span><span onclick="show_modify(this, 6)" style="cursor: pointer">수정</span><span class="pipe">|</span><span onclick="del_mailbox('<?php echo $mbox_info[6]["boxname_kor"] ?>');" style="cursor: pointer">삭제</span>
             <div style="display: none; border: solid 1px silver; border-radius: 7px; margin: 8px; text-align: left; font-size: 0.7em; padding: 5px 20px; line-height: 20px; width: 250px">
               <table>
                 <tr>
                   <td width="30%"></td>
                   <td width="54%"></td>
                   <td width="*"></td>
                 </tr>
                 <tr>
                   <td>기존메일함</td>
                   <td><span id="old_modify_6"><?php echo substr($mbox_info[6]["boxname_kor"], 13) ?></span></td>
                   <td rowspan="2">
                     <button onclick="modify_mbox(6)" style="width: 38px; font-size: 0.4em">수정</button>
                     <button onclick="modify_close(6)" style="width: 38px; font-size: 0.4em">취소</button>
                   </td>
                 </tr>
                 <tr>
                   <td>새메일함</td>
                   <td><input type="text" id="new_modify_6" style="width:60px"></td>
                 </tr>
               </table>
             </div>
           </td>
         </tr>
         <tr>
           <td colspan="4" style="border-bottom: 2px solid lightgray; "></td>
         </tr>
       <?php } ?>

       <?php if($my_mbox_cnt >= 2) { ?>
         <tr align="center">
           <td rowspan="<?php echo(1 + 2*($my_mbox_cnt-1)) ?>">내메일함</td>
           <td><?php echo substr($mbox_info[6]["boxname_kor"], 13) ?></td>
           <td><?php echo $mbox_info[6]["unseen_cnt"].'/'.$mbox_info[6]["mails_cnt"];?></td>
           <td>
             <span onclick="del_trash('<?php echo $mbox_info[6]["boxname_kor"] ?>');" style="cursor: pointer">비우기</span><span class="pipe">|</span><span onclick="set_seen('<?php echo $mbox_info[6]["boxname_kor"] ?>');" style="cursor: pointer">모두 읽음</span><span class="pipe">|</span><span onclick="show_modify(this, 6)" style="cursor: pointer">수정</span><span class="pipe">|</span><span onclick="del_mailbox('<?php echo $mbox_info[6]["boxname_kor"] ?>');" style="cursor: pointer">삭제</span>
             <div style="display: none; border: solid 1px silver; border-radius: 7px; margin: 8px; text-align: left; font-size: 0.7em; padding: 5px 20px; line-height: 20px; width: 250px">
               <table>
                 <tr>
                   <td width="30%"></td>
                   <td width="54%"></td>
                   <td width="*"></td>
                 </tr>
                 <tr>
                   <td>기존메일함</td>
                   <td><span id="old_modify_6"><?php echo substr($mbox_info[6]["boxname_kor"], 13) ?></span></td>
                   <td rowspan="2">
                     <button onclick="modify_mbox(6)" style="width: 38px; font-size: 0.4em">수정</button>
                     <button onclick="modify_close(6)" style="width: 38px; font-size: 0.4em">취소</button>
                   </td>
                 </tr>
                 <tr>
                   <td>새메일함</td>
                   <td><input type="text" id="new_modify_6" style="width:60px"></td>
                 </tr>
               </table>
             </div>
           </td>
         </tr>
         <?php for($i=7; $i<count($mbox_info); $i++) { ?>
             <tr>
               <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
             </tr>
             <tr align="center">
               <td><?php echo substr($mbox_info[$i]["boxname_kor"], 13) ?></td>
               <td><?php echo $mbox_info[$i]["unseen_cnt"].'/'.$mbox_info[$i]["mails_cnt"];?></td>
               <td>
                 <span onclick="del_trash('<?php echo $mbox_info[$i]["boxname_kor"] ?>');" style="cursor: pointer">비우기</span><span class="pipe">|</span><span onclick="set_seen('<?php echo $mbox_info[$i]["boxname_kor"] ?>');" style="cursor: pointer">모두 읽음</span><span class="pipe">|</span><span onclick="show_modify(this, <?php echo $i; ?>)" style="cursor: pointer">수정</span><span class="pipe">|</span><span onclick="del_mailbox('<?php echo $mbox_info[$i]["boxname_kor"] ?>');" style="cursor: pointer">삭제</span>
                 <div style="display: none; border: solid 1px silver; border-radius: 7px; margin: 8px; text-align: left; font-size: 0.7em; padding: 5px 20px; line-height: 20px; width: 250px">
                   <table>
                     <tr>
                       <td width="30%"></td>
                       <td width="54%"></td>
                       <td width="*"></td>
                     </tr>
                     <tr>
                       <td>기존메일함</td>
                       <td><span id="old_modify_<?php echo $i; ?>"><?php echo substr($mbox_info[$i]["boxname_kor"], 13) ?></span></td>
                       <td rowspan="2">
                         <button onclick="modify_mbox(<?php echo $i; ?>)" style="width: 38px; font-size: 0.4em">수정</button>
                         <button onclick="modify_close(<?php echo $i; ?>)" style="width: 38px; font-size: 0.4em">취소</button>
                       </td>
                     </tr>
                     <tr>
                       <td>새메일함</td>
                       <td><input type="text" id="new_modify_<?php echo $i; ?>" style="width:60px"></td>
                     </tr>
                   </table>
                 </div>
               </td>
             </tr>
         <?php } ?>
         <tr>
           <td colspan="4" style="border-bottom: 2px solid lightgray; "></td>
         </tr>
       <?php } ?>

    </table>

    <pre align="left">
      <?php // var_dump($mbox_info); ?>
    </pre>
</div>

<script type="text/javascript">

  function show_modify(ths, i) {
    let divTag = ths.parentNode.childNodes[9];
    divTag.id = 'mbox_modify_' + i;
    $('#'+divTag.id)[0].style.display = "block";
    // divTag.style.display = "block";
  }

  function modify_mbox(i) {
    old_mbox = $('#old_modify_'+i).text();
    new_mbox = $('#new_modify_'+i).val();
    old_mbox = '내메일함.' + old_mbox;
    new_mbox = '내메일함.' + new_mbox;
    $.ajax({
      url: "<?php echo site_url(); ?>/option/rename_mailbox",
      type : "post",
      data : {old_mbox: old_mbox, new_mbox: new_mbox},
      success: function (res) {
        if(res=='o')  alert("메일함명이 수정되었습니다.");
        else  alert("메일함명 수정 실패");
        location.reload();
      }
    });
  }

  function modify_close(i) {
    id = 'mbox_modify_' + i;
    divTag = $('#'+id)[0];
    divTag.style.display = "none";
  }

  function add_mybox() {
      $.ajax({
        url: "<?php echo site_url(); ?>/option/add_mybox",
        success: function (res) {
          if(res=='o')  alert("내메일함이 생성되었습니다.");
          else  alert("내메일함 생성 실패");
          location.reload();
        }
      });
  }

  function add_mailbox() {
      new_mbox = $('#new_mbox').val();
      $.ajax({
        url: "<?php echo site_url(); ?>/option/add_mailbox",
        type : "post",
        data : {mbox: new_mbox},
        success: function (res) {
          if(res=='o')  alert("메일함 [" + new_mbox + "] 생성완료");
          else  alert("메일함 생성 실패");
          location.reload();
        }
      });
  }

  function del_mailbox(mbox) {
    if(confirm("["+mbox+"] 메일함을 삭제합니다.. \n\n계속하시겠습니까?") == true) {
      $.ajax({
        url: "<?php echo site_url(); ?>/option/del_mailbox",
        type : "post",
        data : {mbox: mbox},
        success: function (res) {
          if(res=="o")  alert("메일함 [" + mbox + "]이 삭제되었습니다.");
          else  alert("메일 삭제실패");
          location.reload();
        },
        error : function(request, status, error){
            console.log(error);
        }
      });
    } else {
      return;
    }
  }

  function del_trash(mbox) {
    if(confirm("["+mbox+"] 메일함의 모든 메일을 휴지통으로 삭제합니다. \n\n계속하시겠습니까?") == true) {
      $.ajax({
        url: "<?php echo site_url(); ?>/option/trash_all_mails",
        type : "post",
        data : {mbox: mbox},
        success: function (res) {
          if(res==1)  alert("메일함 [" + mbox + "]의 모든 메일이 삭제되었습니다.");
          else  alert("메일 삭제실패");
          location.reload();
        },
        error : function(request, status, error){
            console.log(error);
        }
      });
    } else {
      return;
    }
  }

  function del_ever() {
    if (confirm("휴지통을 비우면 복구가 불가능합니다.\n\n계속하시겠습니까?") == true) {
      $.ajax({
        url: "<?php echo site_url(); ?>/option/del_all_mails",
        type : "post",
        success: function (res) {
          if(res==1)  alert("휴지통을 모두 비웠습니다.");
          else  alert("휴지통 비우기 실패");
          location.reload();
        },
        error : function(request, status, error){
            console.log(error);
        }
      });
    } else {
      return;
    }
  }

  function set_seen(mbox) {
    if(confirm("["+mbox+"] 메일함의 모든 메일을 읽음으로 처리하겠습니까?") == true) {
      $.ajax({
        url: "<?php echo site_url(); ?>/option/set_seen",
        type : "post",
        data : {mbox: mbox},
        success: function (res) {
          if(res==1)  alert("메일함 [" + mbox + "]의 모든 메일이 읽음으로 처리되었습니다.");
          else  alert("메일 읽음처리 실패");
          location.reload();
        },
        error : function(request, status, error){
          console.log(error);
        }
      });
    } else {
      return;
    }
  }
</script>

<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_footer.php";
 ?>
