<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mobile/mail_header_mobile.php";

$encryp_password = $this->M_account->mbox_conf($_SESSION['userid']);
$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
$key = $this->db->password;
$key = substr(hash('sha256', $key, true), 0, 32);
$decrypted = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);
$mailserver = "192.168.0.100";
// $mailserver = "192.168.0.50";
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
  $mbox_status = imap_status($mails, "{" . $mailserver . "}".$fid, SA_ALL);
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
    "id" => $fid,
    "parent" => $parent_folder,
    "text" => $text,
    "child_num" => $substr_count,
    "unseen" => $mbox_status->unseen,
    "folderkey" => $folderkey,
    "state" => array("opened" => true),
    "messages" => $mbox_status->messages
  );
  array_push($mailbox_tree, $tree);
}
 ?>

<style media="screen">
.mailbox_container{

  height: calc(100% - 75px);


}

.mailbox_main{
  height: 100%;
  width:100%;
  display: grid;
  grid-template-rows: 40px 0px auto 50px;
}

.mailbox_main div{

  overflow-y: scroll;
}
</style>
<div class="mailbox_container">
  <div class="mailbox_main">
    <div class="btn_div" style="width:95%;margin-left: 10px;">
      <select class="top_button" id="selected_box" style="background-color: #white; height: 30px; outline:none;width:35%;">
        <option value="#">메일함 추가</option>
<?php
        foreach ($mailbox_tree as $b) {
          $id = $b["id"];
          $text = $b["text"];
          $dept = $b["child_num"];
          $blanks = '';
          for($j=0; $j<$dept; $j++) {
            $blanks .= '&nbsp;&nbsp;&nbsp;';
          }
          $sub_sign = '<span style="color: silver; font-size: 0.9em">ㄴ </span>';
          $text_indented = ($dept!=0)? $blanks.$sub_sign.$text : $text;
?>
            <option value= "<?php echo $id?>"><?php echo $text_indented?></option>";
<?php
          }
?>
      </select>
      <input type="text" id="new_mbox" style="height: 30px;width:35%; background-color:#F4F4F4;outline:none; border:none;" placeholder="메일함명">
      <button type="button" class="tn_basic btn_blue" name="button" onclick="add_mailbox()" style="height:30px;width:45px;">추가</button>
    </div>

    <div class="select_div">

    </div>

    <div class="mail_div" style="width:95%;margin-left: 10px;">
      <table style="width: 100%; line-height: 30px" cellspacing="0" cellpadding="0">
        <colgroup>
          <col width="40%">
          <col width="15%">
          <col width="45%">
        </colgroup>
        <!-- <tr style="background-color: lightgray; height: 30px;">
          <th>메일함명</th>
          <th>읽지않음/총메일</th>
          <th>관리</th>
        </tr> -->
        <tr>
          <td colspan="3" style="border-bottom:solid 1px #DEDEDE;"></td>
        </tr>
  <?php
        $i = 0;
        foreach ($mailbox_tree as $b) {
          $id = $b["id"];
          $id = addslashes($id);
          $text = $b["text"];
          $dept = $b["child_num"];
          $blanks = '';
          for($j=0; $j<$dept; $j++) {
            $blanks .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
          }
          $sub_sign = '<span style="color: silver; font-size: 0.9em">ㄴ </span>';
          $text_indented = ($dept!=0)? $blanks.$sub_sign.$text : $text;
   ?>
        <tr align="center">
          <td align="left" style="height:50px;background-color:#F4F4F4;text-align:left;padding-left:5px;border-right:solid 1px #DEDEDE;border-bottom:solid 1px #DEDEDE;"><?php echo $text_indented ?></td>
          <td style="border-bottom:solid 1px #DEDEDE;"><?php echo $b["unseen"].'/'.$b["messages"];?></td>
          <td style="border-bottom:solid 1px #DEDEDE;">
            <span onclick="<?php if($b["text"] == "지운 편지함") echo 'del_ever()'; else echo "del_trash('$id')"; ?>" style="cursor: pointer">비우기</span><span class="pipe">|</span>
            <span onclick="set_seen('<?php echo $id ?>');" style="cursor: pointer">모두 읽음</span>
  <?php     if($b["folderkey"] == "custom") { ?>
  <br>
              <span onclick="del_mailbox('<?php echo $id ?>')"; style="cursor: pointer">삭&nbsp;&nbsp;&nbsp;&nbsp;제</span>
              <span class="pipe">|</span>
              <span onclick="show_modify(this, <?php echo $i; ?>)" style="cursor: pointer"><span class="pipe"></span>이름 변경</span>
              <div id="mbox_modify_div_<?php echo $i; ?>" class="" style="display: none; border: solid 1px silver; border-radius: 7px; margin: 8px; text-align: left; font-size: 12px; padding: 5px 20px; line-height: 25px; width: 250px;">
                <table>
                  <tr>
                    <td width="35%"></td>
                    <td width="50%"></td>
                    <td width="*"></td>
                  </tr>
                  <tr>
                    <td>기존메일함</td>
  <?php
                    $mbox_parent = '';
                    if(substr_count($id, '.') != 0) {
                      $mbox_parent = implode('.', explode('.', $b["id"], -1));
                    }
   ?>
                    <span id="mbox_parent_<?php echo $i;?>" style="display: none;"><?php echo $mbox_parent ?></span>
                    <td><span id="old_modify_<?php echo $i;?>"><?php echo $text ?></span></td>
                    <td>
                      <button onclick="modify_mbox(<?php echo $i;?>)" class="except_event" style="width: 42px; height: 28px;  font-size: 11px; padding-left: 8px; padding-right: 8px; padding-top: 1px; ">수정</button>

                    </td>
                  </tr>
                  <tr>
                    <td>새메일함</td>
                    <td><input type="text" id="new_modify_<?php echo $i;?>" class="except_event" style="width:60px"></td>
                    <td>
                      <button onclick="modify_close(<?php echo $i;?>)" style="width: 42px; height: 28px;  font-size: 11px; padding-left: 8px; padding-right: 8px; padding-top: 1px">취소</button>
                    </td>
                  </tr>
                </table>
              </div>
  <?php     } ?>
          </td>
        </tr>
  <?php
        $i++;
      }
   ?>
        </table>
    </div>

    <div class="">

    </div>

  </div>

  <div class="" id="rename_box" style="background:white;width:100%;height:220px;display:none;">
    <div class="">
      <h2 id="modal_title" align="center">이름 변경</h2>
    </div>
    <div class="" align="center">
      변경할 메일박스 이름을 입력하세요.<br>
      <input type="hidden" id="rename_parent" name="" value="">
      <input type="hidden" id="rename_idx" name="" value="">
      <input type="hidden" id="rename_oldbox" name="" value="">
      <input type="text" id="rename_input" name="" value="" style="width:90%;height:40px;">
    </div>
    <div class="" align="center" style="margin-top:10px;">
      <button type="button" name="button" class="btn_basic btn_blue" style="width:70px;" onclick="rename_act();">변경</button>
      <button type="button" name="button" class="btn_basic btn_sky" style="width:70px;" onclick="$('#rename_box').bPopup().close();">취소</button>
    </div>
  </div>
</div>


</body>

<script type="text/javascript">

  function show_modify(ths, i) {
    // divTag = $('#mbox_modify_div_' + i);
    // divTag[0].style.display = "block";
    // divTag.addClass("click_event_display");
    var old_text = $("#old_modify_"+i).text();
    var parent_box = $("#mbox_parent_"+i).text();
    $("#rename_idx").val(i);
    $("#rename_parent").val(parent_box);
    $("#rename_oldbox").val(old_text);
    $("#rename_input").val(old_text);
    $("#rename_box").bPopup({
      position: [0, 0] //x, y
    });
  }

  function rename_act(){
    var idx = $("#rename_idx").val();
    modify_mbox(idx);
  };

  function add_mailbox() {
    const s = document.getElementById('selected_box');
    const parent_mbox = s.options[s.selectedIndex].value;
    let new_mbox = $('#new_mbox').val();

    var pattern = /[,\.]/;
    if(pattern.test(new_mbox)) {
      alert('메일함 이름에 ,와 .는 포함할 수 없습니다.');
      $('#new_mbox').select();
      return;
    }

    let mbox_tree = `<?php echo json_encode($mailbox_tree) ?>`;
    mbox_tree = JSON.parse(mbox_tree);
    let children = [];
    $.each(mbox_tree, function(index, el) {
      if(el['parent'] == parent_mbox) {
        children.push(el['text']);
      }
    });
    if($.inArray(new_mbox, children) != -1) {
      alert("이미 동일한 이름의 메일함이 존재합니다.");
      $('#new_mbox').select();
      return;
    }
    $.ajax({
      url: "<?php echo site_url(); ?>/option/add_mailbox",
      type : "post",
      data : {parent_mbox: parent_mbox, new_mbox: new_mbox},
      success: function (res) {
        if(res=='o')  alert("메일함 생성완료");
        else alert("메일함 생성 실패");
        location.reload();
      }
    });
  }

  function modify_popup(i){
// modify_mbox(<?php echo $i;?>)
  }

  function modify_mbox(i) {
    // old_mbox = $('#old_modify_'+i).text();
    // new_mbox = $('#new_modify_'+i).val();
    // parent_mbox = $('#mbox_parent_'+i).text();
    // $("#rename_idx").val(i);
    // $("#rename_parent").val(parent_box);
    // $("#rename_input").val(old_text);
    old_mbox = $("#rename_oldbox").val();
    new_mbox = $("#rename_input").val();
    parent_mbox = $("#rename_parent").val();


    var pattern = /[,\.]/;
    if(pattern.test(new_mbox)) {
      alert('메일함 이름에 ,와 .는 포함할 수 없습니다.');
      // $('#new_modify_'+i).select();
      return;
    }

    let mbox_tree = `<?php echo json_encode($mailbox_tree) ?>`;
    mbox_tree = JSON.parse(mbox_tree);
    let children = [];
    $.each(mbox_tree, function(index, el) {
      if(el['parent'] == parent_mbox) {
        children.push(el['text']);
      }
    });
    if($.inArray(new_mbox, children) != -1) {
      alert("이미 동일한 이름의 메일함이 존재합니다.");
      $('#new_modify_'+i).select();
      return;
    }else {
      $.ajax({
        url: "<?php echo site_url(); ?>/option/rename_mailbox",
        type : "post",
        data : {parent: parent_mbox, old_mbox: old_mbox, new_mbox: new_mbox},
        success: function (res) {
          if(res=='o') {
            alert("메일함명이 수정되었습니다.");
            location.reload();
          }  else alert("수정 실패..");
        }
      });
    }
  }

  function modify_close(i) {
    divTag = $('#mbox_modify_div_' + i);
    divTag[0].style.display = "none";
  }

  $('html').on('mousedown', function(e){
    if(!$(e.target).hasClass('except_event')) {
      $('.click_event_display').hide();
    }
  });

  function del_mailbox(mbox) {
    mbox = mbox.split("\\").join("");
    let mbox_tree = `<?php echo json_encode($mailbox_tree) ?>`;
    mbox_tree = JSON.parse(mbox_tree);
    let children = [];
    $.each(mbox_tree, function(index, el) {
      if( el['parent'].indexOf(mbox) == 0) {
        children.push(el['id']);
      }
    });

    var confirm_txt = '';
    if(children.length == 0) {
      children.push(mbox);
      confirm_txt = "메일함을 삭제합니다. \n메일함의 모든 메일은 휴지통으로 이동됩니다. \n\n계속하시겠습니까?";
    }else {
      children.push(mbox);
      confirm_txt = "메일함을 삭제합니다. \n단, 선택한 메일함 및 그 하위 메일함의 모든 메일은 휴지통으로 이동됩니다. \n\n계속하시겠습니까?";
    }

    if(confirm(confirm_txt) == true) {
      $.ajax({
        url: "<?php echo site_url(); ?>/option/del_mailbox",
        type : "post",
        data : {folders: children},
        success: function (res) {
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
    if(confirm("메일함의 모든 메일을 휴지통으로 삭제합니다. \n\n계속하시겠습니까?") == true) {
      mbox = mbox.split("\\").join("");
      $.ajax({
        url: "<?php echo site_url(); ?>/option/trash_all_mails",
        type : "post",
        data : {mbox: mbox},
        success: function (res) {
          if(res==1)  alert("메일함의 모든 메일이 삭제되었습니다.");
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
    if(confirm("메일함의 모든 메일을 읽음으로 처리하겠습니까?") == true) {
      mbox = mbox.split("\\").join("");
      $.ajax({
        url: "<?php echo site_url(); ?>/option/set_seen",
        type : "post",
        data : {mbox: mbox},
        success: function (res) {
          if(res==1)  alert("메일함의 모든 메일이 읽음으로 처리되었습니다.");
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
</html>
