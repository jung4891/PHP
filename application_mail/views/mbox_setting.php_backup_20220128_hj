<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";

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


// $mbox="";
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
    // "name" => $folders[$i],
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
        <button type="button" name="button" class="nav_btn" style="margin-left:10px;"onclick="location.href='<?php echo site_url(); ?>/option/user'">계정설정</button>
        <button type="button" name="button" class="nav_btn select_btn" onclick="location.href='<?php echo site_url(); ?>/option/mailbox'">메일함설정</button>
        <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/address_book'">주소록관리</button>
        <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/singnature'">서명관리</button>
      </div>
    </form>

    <div class="main_div" align="left" style="margin-left: 45px;">
      <select class="top_button" id="selected_box" style="background-color: #F0F0F0; height: 25px;">
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
      <input type="text" id="new_mbox" style="width: 70px; height: 19px"> &nbsp;
      <button type="button" name="button" onclick="add_mailbox()">추가</button>
      <!-- <pre align="left">
        메일함 수: <?php echo count($mbox_info)-5 ?>
        <br>
        <?php var_dump($mailbox_tree); ?>
      </pre> -->

    <br><br>
    <table style="width: 90%; line-height: 30px">
      <colgroup>
        <col width="35%">
        <col width="25%">
        <col width="40%">
      </colgroup>
      <tr style="background-color: lightgray; height: 30px;">
        <th>메일함명</th>
        <th>읽지않음/총메일</th>
        <th>관리</th>
      </tr>
<?php
      $i = 0;
      foreach ($mailbox_tree as $b) {
        $id = $b["id"];
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
        <td align="left"><?php echo $text_indented ?></td>
        <td><?php echo $b["unseen"].'/'.$b["messages"];?></td>
        <td>
          <span onclick="<?php if($b["text"] == "지운 편지함") echo 'del_ever()'; else echo "del_trash('$id')"; ?>" style="cursor: pointer">비우기 </span><span class="pipe">|</span>
          <span onclick="set_seen('<?php echo $id ?>');" style="cursor: pointer">모두 읽음 </span>
<?php     if($b["folderkey"] == "custom") { ?>
            <span onclick="show_modify(this, <?php echo $i; ?>)" style="cursor: pointer"><span class="pipe">|</span> 수정 </span><span class="pipe">|</span>
            <span onclick="del_mailbox('<?php echo $id ?>')"; style="cursor: pointer">삭제</span>

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
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
<?php
      $i++;
    }
 ?>
      </table>
    </div>
  </div>

<script type="text/javascript">

  function show_modify(ths, i) {
    // let divTag = ths.parentNode.childNodes[12];
    // divTag.id = 'mbox_modify_' + i;
    // $('#'+divTag.id)[0].style.display = "block";
    divTag = $('#mbox_modify_div_' + i);
    // console.log(divTag);
    divTag[0].style.display = "block";
    divTag.addClass("click_event_display");
  }

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

    let mbox_tree = '<?php echo json_encode($mailbox_tree) ?>';
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

  function modify_mbox(i) {
    old_mbox = $('#old_modify_'+i).text();
    new_mbox = $('#new_modify_'+i).val();
    parent_mbox = $('#mbox_parent_'+i).text();

    var pattern = /[,\.]/;
    if(pattern.test(new_mbox)) {
      alert('메일함 이름에 ,와 .는 포함할 수 없습니다.');
      $('#new_modify_'+i).select();
      return;
    }

    let mbox_tree = '<?php echo json_encode($mailbox_tree) ?>';
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
    // id = 'mbox_modify_' + i;
    // divTag = $('#'+id)[0];
    // divTag.style.display = "none";
    divTag = $('#mbox_modify_div_' + i);
    divTag[0].style.display = "none";
  }

  $('html').on('mousedown', function(e){
    if(!$(e.target).hasClass('except_event')) {
      $('.click_event_display').hide();
    }
  });

  function del_mailbox(mbox) {
    let mbox_tree = '<?php echo json_encode($mailbox_tree) ?>';
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
          // if(res=="o") {
          //   alert("메일함이 삭제되었습니다.");
          // }else{
          //   console.log(res);
          //   alert("메일함 삭제실패");
          // }
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

<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>
