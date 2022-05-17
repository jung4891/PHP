<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";

$encryp_password = $this->M_account->mbox_conf($_SESSION['userid']);
$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
$key = $this->db->password;
$key = substr(hash('sha256', $key, true), 0, 32);
$decrypted = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);
// $mailserver = "mail.durianit.co.kr";
$mailserver = "192.168.0.100";
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
 <link rel="stylesheet" href="<?php echo $misc; ?>css/style.css" type="text/css" charset="utf-8"/>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/admin.css" type="text/css" charset="utf-8"/>


 <div id="main_contents" align="center">
   <div class="sub_div" align="left" style="">
     <span style="font-size:20px;font-weight:bold;">메일분류 규칙 등록</span>
   </div>
   <form id="mform" name="mform" method="post">
     <input type="hidden" id="cert_id" value="">
     <input type="hidden" id="cert_pass" value="">

  <div class="main_div">
    <table class="add_tbl"  border="0" cellspacing="0" cellpadding="0" style="width:90%;">
      <colgroup>
        <col width="10%">
        <col width="90%">
      </colgroup>
      <tr>
        <th align="left">&nbsp;&nbsp;&nbsp;규칙</th>
        <td align="left">&nbsp;&nbsp;&nbsp;
<select class="select_basic" name="usertype" id="usertype" onchange="usertype_change(this);">
  <option value="0">특정인</option>
  <option value="1">특정 도메인</option>
</select>
<span id="typespan">
  으로 부터
</span>
<select class="select_basic" name="senttype" id="senttype" onchange="sendtype_change(this);">
  <option value="0">받는 메일</option>
  <option value="1">보내는 메일</option>
</select>
        </td>
      </tr>

      <tr>
        <th align="left">&nbsp;&nbsp;&nbsp;메일 주소</th>
        <td align="left">&nbsp;&nbsp;&nbsp;
          <input type="text" class="input_basic input_search" name="user_name" id="user_name" value="" style="width:120px;">@
          <input type="text" class="input_basic input_search" name="domain_name" id="domain_name" value="" style="width:120px;">
        </td>
      </tr>

      <tr>
        <th align="left">&nbsp;&nbsp;&nbsp;저장할 메일함</th>
        <td align="left">&nbsp;&nbsp;&nbsp;
          <select class="select_basic" name="save_box" id="save_box">
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

        </td>
      </tr>

    </table>
  </div>
  <div class="" align="right" style="width:90%;margin-top:30px;">
    <button type="button" class="btn_basic btn_blue" style="width:60px;height:30px;" name="button" onclick="category_submit();">등록</button>
    <button type="button"class="btn_basic btn_sky"  style="width:60px;height:30px;" onclick="history.back();">취소</button>
  </div>
  </form>
</div>
<script type="text/javascript">



function category_submit(){
  var user_type = $("#usertype").val();
  var send_type = $("#senttype").val();
  var user_name = $("#user_name").val();
  var domain_name = $("#domain_name").val();
  var box_name = $("#save_box").val();
  if(domain_name == ""){
    alert("메일주소를 입력해주세요.");
    return false;
  }

  if (user_type == 0) {
    if(user_name == ""){
      alert("메일주소를 입력해주세요.");
      return false;
    }
    var mail_pattern = user_name + "@" + domain_name;
  } else {
    var mail_pattern = "example@" + domain_name;

  }


  var regEmail = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/;
  if (regEmail.test(mail_pattern) === false) {
    alert('메일 형식을 확인해주세요.');
    return false;
  }

  if(send_type == 0 && box_name == "INBOX"){
    alert('받은 편지함은 기본 메일함입니다.');
    return false;
  }

  if(send_type == 1 && box_name == "&vPSwuA- &07jJwNVo-"){
    alert('보낸 편지함은 기본 메일함입니다.');
    return false;
  }


  var act = "<?php echo site_url();?>/option/categorize_input_action";
  $("#mform").attr('action', act);
  $("#mform").submit();
}


function usertype_change(el){

  var type_val = $(el).val();
  if (type_val == 0) {
    $("#user_name").show();
  } else {
    $("#user_name").hide();
  }
}

function sendtype_change(el){

  var type_val = $(el).val();
  if (type_val == 0) {
    $("#typespan").text("으로 부터");
    $("#save_box").val("INBOX").prop("selected", true);
  } else {
    $("#typespan").text("으로 ");
    $("#save_box").val("&vPSwuA- &07jJwNVo-").prop("selected", true);
  }
}


</script>


<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>
