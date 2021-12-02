<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/admin_side.php";
 ?>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/style.css" type="text/css" charset="utf-8"/>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/admin.css" type="text/css" charset="utf-8"/>
<div id="main_contents" align="center">
  <div class="main_div">
  <table class="contents_tbl" style="width:70%;" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
        <col width="5%">
        <col width="30%">
        <col width="10%">
        <col width="8%">
        <col width="27%">
        <col width="5%">
        <col width="5%">
      </colgroup>
      <tr>
        <th height="40" align="center">No.</th>
        <th align="center">관리자</th>
        <th align="center">도메인</th>
        <th align="center">활성화</th>
        <th align="center">최종수정일</th>
        <th colspan="2" align="center"></th>
			</tr>
      <?php
				if ($count > 0) {
					$i = 1;

					foreach ( $list_val as $item ) {
            if($item->domain == "ALL"){
              $domain = "최고 관리자";
            }else{
              $domain = $item->domain;
            }

            if($item->active == 1){
              $active = "O";
            }else{
              $active = "X";
            }
			?>

        <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style="">
          <td height="40" align="center"><?php echo $i;?></a></td>
          <td style="padding-left:10px;" align="center"><?php echo $item->username;?></td>
          <td align="center"><?php echo $domain;?></td>
          <td align="center"><?php echo $active;?></td>
          <td align="center"><?php echo $item->modified;?></td>
          <td align="right">
            <button type="button" class="btn_basic btn_blue" name="button" onclick="admin_modify('<?php echo $item->username;?>', 'modi')">수정</button>
          </td>
          <td align="left">

             <button type="button" class="btn_basic btn_sky" name="button" onclick="admin_modify('<?php echo $item->username;?>', 'del')">삭제</button>

          </td>
        </tr>
			<?php
						$i++;
					}
				} else {
			?>

				<tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
          <td width="100%" height="40" align="center" colspan="10">등록된 게시물이 없습니다.</td>
        </tr>
      <?php
        }
       ?>
       <tr>
         <td colspan="7" align="center">
           <button type="button" class="btn_basic btn_blue" name="button" onclick="manager_add();">등록</button>
         </td>
       </tr>
      </table>
    </div>
</div>



<div id="modify_admin" style="width:40vw;height:50vh;display:none;background:white;">
  <form id="modify_form" name="modify_form" method="get">
    <input type="hidden" id="modi_id" name="modi_id" value="">
</form>
</div>

<script type="text/javascript">
function manager_add(){
  location.href = "<?php echo site_url(); ?>/admin/manager/add_admin";
}


$("#add_id").keyup(function(){
  var inputVal = $(this).val();
  $(this).val(inputVal.replace(/[^a-z0-9]/gi,''));
})

$("#add_id").blur(function(){
  var char_length = $(this).val().length;
  if(char_length < 3 || char_length > 20){
    $("#id_span").html("3~20자의 영문, 숫자만 사용 가능합니다.");
    $("#id_span").css({"color":"red"});
    $("#cert_id").val("false");
    return false;
  }else{
    var mail = $(this).val().trim();
    var domain = $("#add_domain option:selected").val();
    var mailadress = mail+"@"+domain;
    $.ajax({
        type: "POST",
        dataType : "json",
        url: "<?php echo site_url();?>/admin/manager/dupl_id",
        data: {
          username: mailadress
        },
        success: function(result){
          if(result == "dupl"){
            $("#id_span").html("이미 사용 중인 메일입니다.");
            $("#id_span").css({"color":"red"});
            $("#cert_id").val("false");
          }else{
            $("#id_span").html("사용 가능한 메일입니다.");
            $("#id_span").css({"color":"blue"});
            $("#cert_id").val("true");
          }
        }
})
}
});


$("#add_pass, #check_pass").blur(function(){
  var passlength = $("#add_pass").val().length;
  var passwordRules = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,16}$/;
  var password = $("#add_pass").val();
  if(!passwordRules.test(password)){
    $("#password_span").html("숫자, 특문 각 1자 포함하여 8~16자리로 입력하세요");
    $("#password_span").css({"color":"red"});
    $("#cert_pass").val("false");
  }else{
    $("#password_span").html("");
    $("#cert_pass").val("true");
  }
})


// $("#add_pass, #check_pass").blur(function(){
//   var passlength = $("#add_pass").val().length;
//   var passwordRules = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,16}$/;
//   var password = $("#add_pass").val();
//   if(!passwordRules.test(password)){
//     $("#password_span").html("숫자, 특문 각 1자 포함하여 8~16자리로 입력하세요");
//     $("#password_span").css({"color":"red"});
//     $("#cert_pass").val("false");
//   }else{
//     $("#password_span").html("");
//     $("#cert_pass").val("true");
//   }
// })

function selectAll(selectAll){
  var name = selectAll.name
  const checkboxes
       = document.getElementsByName(name);

  checkboxes.forEach((checkbox) => {
    checkbox.checked = selectAll.checked;
  })
}

function getCheckboxValue(name){
  // 선택된 목록 가져오기
  const query = "input[name='"+name+"']:checked";
  const selectedEls =
      document.querySelectorAll(query);

  // 선택된 목록에서 value 찾기
  let result = '';
  selectedEls.forEach((el) => {
    result += el.value + ' ';
  });

  return result;
}




function admin_modify(id, mode){
  if(mode == "del"){
    var con_test = confirm("정말 삭제하시겠습니까?");
    if(con_test == true){
      location.href="<?php echo site_url(); ?>/admin/manager/del_admin?id="+id;
    }
  }else{
    // $("#modify_id").html(id);
    // $("#modify_user").val(id);
    // $("#modify_admin").bPopup();
    $("#modi_id").val(id);
    var act = "<?php echo site_url(); ?>/admin/manager/modify_admin"
    $("#modify_form").attr('action', act);
    $("#modify_form").submit();
  }
}




</script>
<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>
