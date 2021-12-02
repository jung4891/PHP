<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>
 <style>
   #nav_tbl td{
     min-width: 100px;
     height: 30px;
     border: 1px solid black;
     text-align: center;
     cursor: pointer;
   }

   .sign_selected{
     background-color: #e3e3e3;
   }

   .nav_btn{
     -webkit-appearance: none;
     -moz-appearance: none;
     appearance: none;
     border:1px solid #B0B0B0;
     border-bottom: none;
     height: 30px;
     width: 100px;
     cursor: pointer;
     background-color: #FFFFFF;
     color: #1C1C1C;
     border-radius: 10px 10px 0px 0px;
   }

   .select_btn{
     border:none;
     background-color: #1A8DFF;
     color: #FFFFFF;
   }

   .pipe {
     color: lightgrey;
     margin-left: 5px;
     margin-right: 5px;
   }
</style>

  <div id="main_contents" align="center">
    <form name="mform" action="" method="post">
      <div class="" align="left" width=100% style="border-bottom:1px solid #1A8DFF;margin:-10px 40px 10px 40px;">
        <button type="button" name="button" class="nav_btn" style="margin-left:10px;"onclick="location.href='<?php echo site_url(); ?>/option/account'">계정설정</button>
        <button type="button" name="button" class="nav_btn select_btn" onclick="location.href='<?php echo site_url(); ?>/option/mailbox'">메일함설정</button>
        <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/address_book'">주소록관리</button>
        <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/singnature'">서명관리</button>
      </div>
    </form>

    <div class="main_div" align="left" style="margin-left: 45px;">
      <select class="top_button" id="selected_box" style="background-color: #F0F0F0; height: 25px;">
        <option value="">메일함 추가</option>
        <?php
          $my_mbox_cnt = count($mbox_info)-5;
          for($i=5; $i<5+$my_mbox_cnt; $i++) {
        ?>
            <option value= "<?php echo $mbox_info[$i]['boxname_kor']?>"><?php echo $mbox_info[$i]['boxname_kor']?></option>";
        <?php
          }
         ?>
      </select>
      <input type="text" id="new_mbox" style="width: 70px; height: 19px"> &nbsp;
      <button type="button" name="button" onclick="add_mailbox()">추가</button>

    <br><br>
    <table style="width: 95%; line-height: 30px" >
      <colgroup>
        <col width="11%">
        <col width="24%">
        <col width="17%">
        <col width="28%">
      </colgroup>
      <tr style="background-color: lightgray; height: 30px;">
        <th>구분</th>
        <th>메일함명</th>
        <th>읽지않음/총메일</th>
        <th>관리</th>
      </tr>
      <tr align="center">
        <td rowspan="9">기본메일함</td>
        <td align="left">받은메일함</td>
        <td><?php echo $mbox_info[0]["unseen_cnt"].'/'.$mbox_info[0]["mails_cnt"];?></td>
        <td><span onclick="del_trash('INBOX');" style="cursor: pointer">비우기</span><span class="pipe">|</span><span onclick="set_seen('INBOX');" style="cursor: pointer">모두 읽음</span></td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td align="left">보낸메일함</td>
        <td><?php echo $mbox_info[1]["unseen_cnt"].'/'.$mbox_info[1]["mails_cnt"];?></td>
        <td><span onclick="del_trash('보낸 편지함');" style="cursor: pointer">비우기</span><span class="pipe">|</span><span onclick="set_seen('보낸 편지함');" style="cursor: pointer">모두 읽음</span></td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td align="left">임시보관함</td>
        <td><?php echo $mbox_info[2]["unseen_cnt"].'/'.$mbox_info[2]["mails_cnt"];?></td>
        <td><span onclick="del_trash('임시 보관함');" style="cursor: pointer">비우기</span><span class="pipe">|</span><span onclick="set_seen('임시 보관함');" style="cursor: pointer">모두 읽음</span></td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td align="left">스팸메일함</td>
        <td><?php echo $mbox_info[3]["unseen_cnt"].'/'.$mbox_info[3]["mails_cnt"];?></td>
        <td><span onclick="del_trash('정크 메일');" style="cursor: pointer">비우기</span><span class="pipe">|</span><span onclick="set_seen('정크 메일');" style="cursor: pointer">모두 읽음</span></td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td align="left">휴지통</td>
        <td><?php echo $mbox_info[4]["unseen_cnt"].'/'.$mbox_info[4]["mails_cnt"];?></td>
        <td><span onclick="del_ever();" style="cursor: pointer">비우기</span><span class="pipe">|</span><span onclick="set_seen('지운 편지함');" style="cursor: pointer">모두 읽음</span></td>
      </tr>
      <tr>
        <td colspan="4" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <?php
        $my_mbox_cnt = count($mbox_info)-5;
        // echo 'my_mbox_cnt: '.$my_mbox_cnt.'<br>';
      ?>
      <tr align="center">
        <td rowspan="<?php echo ($my_mbox_cnt == 0)? 1: 2*$my_mbox_cnt ?>">내메일함</td>
      </tr>
      <?php

        for($i=5; $i<5+$my_mbox_cnt; $i++) {
          $mbox_parent = '';
          $mbox_kor = $mbox_info[$i]["boxname_kor"];
          $mbox_kor_next = $mbox_info[($i+1 != 5+$my_mbox_cnt)? $i+1:$i]["boxname_kor"];
          // echo 'mbox_kor: '.$mbox_kor.' / ';
          $dot_cnt = substr_count($mbox_kor, '.');
          $dot_cnt_next = substr_count($mbox_kor_next, '.');
          // echo 'dot_cnt: '.$dot_cnt.'<br>';

          // 하위 폴더가 있는 경우에 해당폴더 + 하위폴더 싹다 배열에 담음.
          $sub_folders_arr = array();
          if($dot_cnt_next > $dot_cnt) {
            array_push($sub_folders_arr, $mbox_kor);
            for($j=$i+1; $j<5+$my_mbox_cnt; $j++) {
              $dot_cnt_next = substr_count($mbox_info[$j]["boxname_kor"], '.');
              if($dot_cnt_next > $dot_cnt) {
                array_push($sub_folders_arr, $mbox_info[$j]["boxname_kor"]);
              } else {
                break;
              }
            }
          }

          // 중간 가로줄 삽입
          if($i>5) {
            echo
            ' <tr>
                <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
              </tr>';
          }

          // 하위폴더 이름만 가져온후 단계에 따른 ㄴ 삽입
          if($dot_cnt != 0) {
            // $sub_pos = strpos($mbox_kor, '.', $dot_cnt) + 1;
            $folders = explode('.', $mbox_kor);
            $folders_parent = explode('.', $mbox_kor, -1);

            $mbox_kor = $folders[count($folders) -1];             // 하위폴더
            $mbox_parent = implode('.', $folders_parent);         // 상위폴더
            $sub_sign = '<span style="color: silver; font-size: 0.9em">ㄴ </span>';
            $blanks = '';
            for($j=1; $j<$dot_cnt; $j++) {
              $blanks .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            }
            $mbox_kor_span = $blanks.$sub_sign.$mbox_kor;
          }

          ?>
          <tr align="center">
            <td align="left"><?php echo (isset($mbox_kor_span))? $mbox_kor_span : $mbox_kor ?></td>
            <td><?php echo $mbox_info[$i]["unseen_cnt"].'/'.$mbox_info[$i]["mails_cnt"];?></td>
            <td>
              <span onclick="del_trash('<?php echo $mbox_info[$i]["boxname_kor"] ?>');" style="cursor: pointer">비우기 </span><span class="pipe">|</span>
              <span onclick="set_seen('<?php echo $mbox_info[$i]["boxname_kor"] ?>');" style="cursor: pointer">모두 읽음 </span><span class="pipe">|</span>
              <span onclick="show_modify(this, <?php echo $i; ?>)" style="cursor: pointer">수정 </span><span class="pipe">|</span>
              <span id="json_str_folders_<?php echo $i;?>" style="display: none;"><?php echo json_encode($sub_folders_arr); ?></span>
              <span onclick="del_mailbox('<?php echo $mbox_info[$i]["boxname_kor"] ?>', '<?php echo count($sub_folders_arr)?>', <?php echo $i; ?>)"; style="cursor: pointer">삭제</span>
              <div id="mbox_modify_div_<?php echo $i; ?>" style="display: none; border: solid 1px silver; border-radius: 7px; margin: 8px; text-align: left; font-size: 0.8em; padding: 5px 20px; line-height: 20px; width: 250px">
                <table>
                  <tr>
                    <td width="30%"></td>
                    <td width="54%"></td>
                    <td width="*"></td>
                  </tr>
                  <tr>
                    <td>기존메일함</td>
                    <span id="mbox_parent_<?php echo $i;?>" style="display: none;"><?php echo $mbox_parent ?></span>
                    <td><span id="old_modify_<?php echo $i;?>"><?php echo $mbox_kor ?></span></td>
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
          <?php
          unset($mbox_parent);
          unset($mbox_kor_span);
        } // for

      ?>
      <tr>
        <td colspan="4" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
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
    // let divTag = ths.parentNode.childNodes[12];
    // divTag.id = 'mbox_modify_' + i;
    // $('#'+divTag.id)[0].style.display = "block";

    divTag = $('#mbox_modify_div_' + i)[0];
    divTag.style.display = "block";
  }

  function modify_mbox(i) {
    old_mbox = $('#old_modify_'+i).text();
    new_mbox = $('#new_modify_'+i).val();
    parent_mbox = $('#mbox_parent_'+i).text();
    if(parent_mbox != "") {
      old_mbox = parent_mbox + '.' + old_mbox;
      new_mbox = parent_mbox + '.' + new_mbox;
    }
    $.ajax({
      url: "<?php echo site_url(); ?>/option/rename_mailbox",
      type : "post",
      data : {old_mbox: old_mbox, new_mbox: new_mbox},
      success: function (res) {
        if(res=='o') {
          alert("메일함명이 수정되었습니다.");
          location.reload();
        }  else  alert("메일함명이 이미 존재합니다.");
      }
    });
  }

  function modify_close(i) {
    // id = 'mbox_modify_' + i;
    // divTag = $('#'+id)[0];
    // divTag.style.display = "none";
    divTag = $('#mbox_modify_div_' + i)[0];
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

  function del_mailbox(mbox, cnt_sub, i) {
    // alert(mbox+' '+cnt_sub+' '+i);

    if(cnt_sub ==0) {
        if(confirm("메일함을 삭제합니다. \n메일함["+mbox+"]의 모든 메일은 완전삭제됩니다. \n\n계속하시겠습니까?") == true) {
          $.ajax({
            url: "<?php echo site_url(); ?>/option/del_mailbox",
            type : "post",
            data : {mbox: mbox, mode: '1'},
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
    }else {
      let json_str = $('#json_str_folders_'+i).text();
      // let folders_arr = JSON.parse(json_str);
        if(confirm("메일함을 삭제합니다. \n단, 메일함["+mbox+"] 및 그 하위 메일함을 포함하여 메일함에 있던 모든 메일은 완전삭제됩니다. \n\n계속하시겠습니까?") == true) {
          $.ajax({
            url: "<?php echo site_url(); ?>/option/del_mailbox",
            type : "post",
            data : {mbox: mbox, mode: '2', folders: json_str},
            success: function (res) {
              if(res=="o")  alert("메일함 [" + mbox + "] 및 그 하위 메일함들이 삭제되었습니다.");
              else  alert("메일 삭제실패");
              location.reload();
            },
            error : function(request, status, error){
              console.log(error);
            }
          });
        }else {
          return;
        }
    }


    // if(mode == '1') {

    // }else {
    //   if(confirm("메일함을 삭제합니다. \n단, 메일함["+mbox+"] 및 그 하위 메일함을 포함하여 메일함에 있던 모든 메일은 완전삭제됩니다. \n\n계속하시겠습니까?") == true) {
    //     $.ajax({
    //       url: "<?php echo site_url(); ?>/option/del_mailbox",
    //       type : "post",
    //       data : {mbox: mbox, mode: mode},
    //       success: function (res) {
    //         alert(res);
    //         // if(res=="o")  alert("메일함 [" + mbox + "]이 삭제되었습니다.");
    //         // else  alert("메일 삭제실패");
    //         // location.reload();
    //       },
    //       // error : function(request, status, error){
    //       //   console.log(error);
    //       // }
    //     });
    //   }else {
    //     return;
    //   }
    // }



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
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>