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
    <div class="" align="left" style="margin-left: 45px;">
      <select class="top_button" id="selected_box" style="background-color: #F0F0F0; height: 25px;">
        <option value="">메일함 추가</option>
        <?php
          $my_mbox_cnt = count($mbox_info)-5;
          for($i=5; $i<5+$my_mbox_cnt-1; $i++) {
        ?>
            <option value= "<?php echo $mbox_info[$i]['boxname_kor']?>"><?php echo $mbox_info[$i]['boxname_kor']?></option>";
        <?php
          }
         ?>
      </select>
      <input type="text" id="new_mbox" style="width: 70px; height: 19px"> &nbsp;
      <button type="button" name="button" onclick="add_mailbox()">추가</button>

    <br><br>
    <table style="width: 95%;">
      <colgroup>
        <col width="12%">
        <col width="20%">
        <col width="17%">
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
        <td><span onclick="del_ever();" style="cursor: pointer">비우기</span><span class="pipe">|</span><span onclick="set_seen('지운 편지함');" style="cursor: pointer">모두 읽음</span></td>
      </tr>
      <tr>
        <td colspan="4" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <?php
        $my_mbox_cnt = count($mbox_info)-5;
        $subfolder_arr = array();
        $subfolder_i_arr = array();

        for($i=5; $i<5+$my_mbox_cnt-1; $i++) {
          $mbox_kor = $mbox_info[$i]["boxname_kor"];
          $mbox_kor_next = $mbox_info[$i+1]["boxname_kor"];
          $mbox_parent_next = substr($mbox_kor_next, 0, strpos($mbox_kor_next, '.'));

          // subfolder가 없을경우
          if( strpos($mbox_kor, '.') == null && $mbox_kor != $mbox_parent_next) {
          ?>
         <tr align="center">
           <td rowspan="1"><?php echo $mbox_info[$i]["boxname_kor"] ?></td>
           <td></td>
           <td><?php echo $mbox_info[$i]["unseen_cnt"].'/'.$mbox_info[$i]["mails_cnt"];?></td>
           <td>
             <span onclick="del_trash('<?php echo $mbox_info[$i]["boxname_kor"] ?>');" style="cursor: pointer">비우기 </span><span class="pipe">|</span>
             <span onclick="set_seen('<?php echo $mbox_info[$i]["boxname_kor"] ?>');" style="cursor: pointer">모두 읽음 </span><span class="pipe">|</span>
             <span onclick="show_modify(this, <?php echo $i; ?>)" style="cursor: pointer">수정 </span><span class="pipe">|</span>
             <span onclick="del_mailbox('<?php echo $mbox_info[$i]["boxname_kor"] ?>');" style="cursor: pointer">삭제</span>
             <div style="display: none; border: solid 1px silver; border-radius: 7px; margin: 8px; text-align: left; font-size: 0.7em; padding: 5px 20px; line-height: 20px; width: 250px">
               <table>
                 <tr>
                   <td width="30%"></td>
                   <td width="54%"></td>
                   <td width="*"></td>
                 </tr>
                 <tr>
                   <td>기존메일함</td>
                   <td><span id="old_modify_<?php echo $i;?>"><?php echo $mbox_info[$i]["boxname_kor"] ?></span></td>
                   <td rowspan="2">
                     <button onclick="modify_mbox(<?php echo $i;?>)" style="width: 38px; font-size: 0.4em">수정</button>
                     <button onclick="modify_close(<?php echo $i;?>)" style="width: 38px; font-size: 0.4em">취소</button>
                   </td>
                 </tr>
                 <tr>
                   <td>새메일함</td>
                   <td><input type="text" id="new_modify_<?php echo $i;?>" style="width:60px"></td>
                 </tr>
               </table>
             </div>
           </td>
         </tr>
         <tr>
           <td colspan="4" style="border-bottom: 2px solid lightgray; "></td>
         </tr>

         <!-- subfolder가 있는경우 -->
       <?php
          }else{
           if(strpos($mbox_kor, '.') != null) {
             $mbox_parent = substr($mbox_kor, 0, strpos($mbox_kor, '.'));
             $mbox_parent_next = substr($mbox_kor_next, 0, strpos($mbox_kor_next, '.'));
             $mbox_child = substr($mbox_kor, strpos($mbox_kor, '.')+1);

             if($mbox_parent == $mbox_parent_next) {
               array_push($subfolder_arr, $mbox_child);
               array_push($subfolder_i_arr, $i);
             } else {
               if(!isset($subfolder_arr[0])) {
               ?>
               <!-- subfolder가 1개 -> 배열에 안넣고 바로 출력함 -->
               <tr align="center">
                 <td rowspan="1"><?php echo $mbox_parent ?></td>
                 <td><?php echo $mbox_child ?></td>
                 <td><?php echo $mbox_info[$i]["unseen_cnt"].'/'.$mbox_info[$i]["mails_cnt"];?></td>
                 <td>
                   <span onclick="del_trash('<?php echo $mbox_info[$i]["boxname_kor"] ?>');" style="cursor: pointer">비우기 </span><span class="pipe">|</span>
                   <span onclick="set_seen('<?php echo $mbox_info[$i]["boxname_kor"] ?>');" style="cursor: pointer">모두 읽음 </span><span class="pipe">|</span>
                   <span onclick="show_modify(this, <?php echo $i; ?>)" style="cursor: pointer">수정 </span><span class="pipe">|</span>
                   <span onclick="del_mailbox('<?php echo $mbox_info[$i]["boxname_kor"] ?>');" style="cursor: pointer">삭제</span>
                   <div style="display: none; border: solid 1px silver; border-radius: 7px; margin: 8px; text-align: left; font-size: 0.7em; padding: 5px 20px; line-height: 20px; width: 250px">
                     <table>
                       <tr>
                         <td width="30%"></td>
                         <td width="54%"></td>
                         <td width="*"></td>
                       </tr>
                       <tr>
                         <td>기존메일함</td>
                         <span id="parent_<?php echo $i; ?>" style="display:none"><?php echo $mbox_parent; ?></span>
                         <td><span id="old_modify_<?php echo $i; ?>"><?php echo $mbox_child; ?></span></td>
                         <td rowspan="2">
                           <button onclick="modify_mbox(<?php echo $i; ?>, 2)" style="width: 38px; font-size: 0.4em">수정</button>
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
               <tr>
                 <td colspan="4" style="border-bottom: 2px solid lightgray; "></td>
               </tr>

              <?php
              // subfolder가 2개이상
            } else {
              array_push($subfolder_arr, $mbox_child);
              array_push($subfolder_i_arr, $i);
              $subfolder_cnt = count($subfolder_arr);
              ?>
              <tr align="center">
                <td rowspan="<?php echo(1 + 2*($subfolder_cnt-1)) ?>"><?php echo $mbox_parent; ?></td>
                <td><?php echo $subfolder_arr[0] ?></td>
                <td><?php echo $mbox_info[$subfolder_i_arr[0]]["unseen_cnt"].'/'.$mbox_info[$subfolder_i_arr[0]]["mails_cnt"];?></td>
                <td>
                  <span onclick="del_trash('<?php echo $mbox_info[$subfolder_i_arr[0]]["boxname_kor"] ?>');" style="cursor: pointer">비우기 </span><span class="pipe">|</span>
                  <span onclick="set_seen('<?php echo $mbox_info[$subfolder_i_arr[0]]["boxname_kor"] ?>');" style="cursor: pointer">모두 읽음 </span><span class="pipe">|</span>
                  <span onclick="show_modify(this, <?php echo $subfolder_i_arr[0]; ?>)" style="cursor: pointer">수정 </span><span class="pipe">|</span>
                  <span onclick="del_mailbox('<?php echo $mbox_info[$subfolder_i_arr[0]]["boxname_kor"] ?>');" style="cursor: pointer">삭제</span>
                  <div style="display: none; border: solid 1px silver; border-radius: 7px; margin: 8px; text-align: left; font-size: 0.7em; padding: 5px 20px; line-height: 20px; width: 250px">
                    <table>
                      <tr>
                        <td width="30%"></td>
                        <td width="54%"></td>
                        <td width="*"></td>
                      </tr>
                      <tr>
                        <td>기존메일함</td>
                        <span id="parent_<?php echo $i; ?>" style="display:none"><?php echo $mbox_parent; ?></span>
                        <td><span id="old_modify_<?php echo $subfolder_i_arr[0]; ?>"><?php echo $subfolder_arr[0] ?></span></td>
                        <td rowspan="2">
                          <button onclick="modify_mbox(<?php echo $subfolder_i_arr[0]; ?>, 2)" style="width: 38px; font-size: 0.4em">수정</button>
                          <button onclick="modify_close(<?php echo $subfolder_i_arr[0]; ?>)" style="width: 38px; font-size: 0.4em">취소</button>
                        </td>
                      </tr>
                      <tr>
                        <td>새메일함</td>
                        <td><input type="text" id="new_modify_<?php echo $subfolder_i_arr[0]; ?>" style="width:60px"></td>
                      </tr>
                    </table>
                  </div>
                </td>
              </tr>
              <?php for($j=1; $j<$subfolder_cnt; $j++) { ?>
                  <tr>
                    <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
                  </tr>
                  <tr align="center">
                    <td><?php echo $subfolder_arr[$j] ?></td>
                    <td><?php echo $mbox_info[$subfolder_i_arr[$j]]["unseen_cnt"].'/'.$mbox_info[$subfolder_i_arr[$j]]["mails_cnt"];?></td>
                    <td>
                      <span onclick="del_trash('<?php echo $mbox_info[$subfolder_i_arr[$j]]["boxname_kor"] ?>');" style="cursor: pointer">비우기 </span><span class="pipe">|</span>
                      <span onclick="set_seen('<?php echo $mbox_info[$subfolder_i_arr[$j]]["boxname_kor"] ?>');" style="cursor: pointer">모두 읽음 </span><span class="pipe">|</span>
                      <span onclick="show_modify(this, <?php echo $subfolder_i_arr[$j]; ?>)" style="cursor: pointer">수정 </span><span class="pipe">|</span>
                      <span onclick="del_mailbox('<?php echo $mbox_info[$subfolder_i_arr[$j]]["boxname_kor"] ?>');" style="cursor: pointer">삭제</span>
                      <div style="display: none; border: solid 1px silver; border-radius: 7px; margin: 8px; text-align: left; font-size: 0.7em; padding: 5px 20px; line-height: 20px; width: 250px">
                        <table>
                          <tr>
                            <td width="30%"></td>
                            <td width="54%"></td>
                            <td width="*"></td>
                          </tr>
                          <tr>
                            <td>기존메일함</td>
                            <span id="parent_<?php echo $i; ?>" style="display:none"><?php echo $mbox_parent; ?></span>
                            <td><span id="old_modify_<?php echo $subfolder_i_arr[$j]; ?>"><?php echo $subfolder_arr[$j]; ?></span></td>
                            <td rowspan="2">
                              <button onclick="modify_mbox(<?php echo $subfolder_i_arr[$j]; ?>, 2)" style="width: 38px; font-size: 0.4em">수정</button>
                              <button onclick="modify_close(<?php echo $subfolder_i_arr[$j]; ?>)" style="width: 38px; font-size: 0.4em">취소</button>
                            </td>
                          </tr>
                          <tr>
                            <td>새메일함</td>
                            <td><input type="text" id="new_modify_<?php echo $subfolder_i_arr[$j]; ?>" style="width:60px"></td>
                          </tr>
                        </table>
                      </div>
                    </td>
                  </tr>
              <?php } ?>
              <tr>
                <td colspan="4" style="border-bottom: 2px solid lightgray; "></td>
              </tr>

              <?php
              // echo $mbox_parent.' '.$mbox_child.'<br>';
              // var_dump($subfolder_i_arr);
              unset($subfolder_arr);
              unset($subfolder_i_arr);
              $subfolder_arr = array();
              $subfolder_i_arr = array();
            }
          }
        }
      }

    } // for

      ?>
    </table>
    </div>

    <br>
    <!-- <pre align="left">
      메일함 수: <?php echo count($mbox_info)-5 ?>
      <br>
      <?php // var_dump($mbox_info[5]); ?>
    </pre> -->
</div>

<script type="text/javascript">

  function show_modify(ths, i) {
    let divTag = ths.parentNode.childNodes[12];
    divTag.id = 'mbox_modify_' + i;
    $('#'+divTag.id)[0].style.display = "block";

    // divTag.style.display = "block";
  }

  function modify_mbox(i, mode='1') {
    old_mbox = $('#old_modify_'+i).text();
    new_mbox = $('#new_modify_'+i).val();

    if(mode == '2') {
      parent_mbox = $('#parent_'+i).text();
      old_mbox = parent_mbox + '.' + $('#old_modify_'+i).text();
      new_mbox = parent_mbox + '.' + $('#new_modify_'+i).val();
    }
    // alert(old_mbox + ' ' + new_mbox);
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

  function add_mailbox() {
    const s = document.getElementById('selected_box');
    const parent_mbox = s.options[s.selectedIndex].value;
    let new_mbox = $('#new_mbox').val();
    if(parent_mbox != "")  new_mbox = parent_mbox + '.' + new_mbox;
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
