<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mobile/mail_header_mobile.php";
 ?>
<style media="screen">

/* select {
  -webkit-appearance:none;
  -moz-appearance:none;
  appearance:none;
  background-color: black;
  color: white;

  border: none;
  text-align: center;
  font-size: 1em;
  padding-bottom: 28px;

  font-size: 0.8em;
  display: block;
  padding-top: 3px;
  width: 100%;
  height: 55px;
  opacity: 0;
  position: relative;
  top: -52px;
} */
/* select:focus {
  outline: none;
} */

input[type=checkbox] {
  transform : scale(1.2);
}

.div_footer {
  width: 20%;
  color: white;
  text-align: center;
}
.div_footer > div {
  height: 22px;
  text-align: center;
}
.div_footer > span {
  font-size: 0.8em;
}

.address_contain{
  height: calc(100% - 75px);
  /* height: 100%; */
}
.address_main{
  height: 100%;
  width:100%;
  display: grid;
  grid-template-rows: 0px 1fr 25px 75px;
}

.address_footer{
  display: flex; background-color: black;
  align-items: center;
}

.address_div{
  overflow-y: scroll;
  /* text-align: center; */
  /* display: flex;
  justify-content: space-around; */
}

#add_address {
  display:none;
  width:100%;
  height: 310px;
  background-color:#ffffff;
  border-radius: 20px 20px 20px 20px;
}

#modify_address {
  display:none;
  width:100%;
  height: 310px;
  background-color:#ffffff;
  border-radius: 20px 20px 20px 20px;
}

#add_addr_tbl {
  width:100%;
  border-spacing: 5px;
  padding-top: 10px;
  padding-left: 25px;
  /* color: gray; */
}
#add_addr_tbl input[type="text"]{
  width: 85%;
  height: 18px;
  border: none;
  border-bottom: 1px solid rgb(212, 213, 219);
  outline: none;
}
#add_addr_tbl tr>td:nth-child(2) {
  padding-bottom: 5px;
}


</style>

  <div class="address_contain">
    <div class="address_main">


      <div class="search_div">

      </div>
      <div class="address_div" align="center" style="">

        <table id="" border="0" cellspacing="0" cellpadding="0" style="width:90%;">
          <colgroup>
            <col width="5%">
            <col width="45%">
            <col width="50%">
        </colgroup>
          <?php
          foreach ($address_group as $group) {
            $select_group = ($group['seq'] == $group_name)?"select_group":"";
          ?>
          <tr height=30 class="group_tr <?php echo $select_group; ?>" data-groupseq = "<?php echo $group['seq']; ?>">
            <td colspan="2" height="30" style="font-weight: bold;height:40px;font-size:20px;" onclick="show_modifygroup(this);">
              <?php echo $group["group_name"]; ?>
            </td>

            <td align="right">
              <img src="<?php echo $misc;?>img/icon/아래3.svg" class="down_btn" style="" onclick="updown(this, 'down');">
            </td>
          </tr>
          <?php
            foreach ($address_list as $addr) {
              if($group['seq'] === $addr['group_seq']) {
          ?>
                <tr height=30 addr-groupseq="<?php echo $group['seq']; ?>" onclick="show_modify_addr(this);">
                  <td style="height:40px;" onclick="event.cancelBubble=true">
                    <input type="checkbox" id="" name="" value="">
                  </td>
                  <td style="font-size:16px;font-weight:bold;padding-left:10px;">
                    <?php echo $addr['name']; ?>
                  </td>
                  <td align="right" style="color:#B0B0B0;">
                    <?php echo $addr['email']; ?>
                  </td>
                  <td>
                    <input type="hidden" name="modal_seq" name="" value="<?php echo $addr['seq']; ?>">
                    <input type="hidden" name="addr_name" value="<?php echo $addr['name']; ?>">
                    <input type="hidden" name="addr_email" value="<?php echo $addr['email']; ?>" >
                    <input type="hidden" name="addr_group" value="<?php echo $addr['group_seq'] ?>">
                    <input type="hidden" name="addr_dept" value="<?php echo $addr['department']; ?>">
                    <input type="hidden" name="addr_dept_group" value="<?php echo $addr['group']; ?>">
                    <input type="hidden" name="addr_comment" value="<?php echo $addr['comment']; ?>">
                  </td>
                </tr>
          <?php
              }
            }
          }
           ?>

          <tr height=30  data-groupseq="all">
            <td colspan="2" style="font-weight: bold;font-size:20px;">
              기타
            </td>

            <td align="right">
              <img src="<?php echo $misc;?>img/icon/아래3.svg" class="down_btn" style="" onclick="updown(this, 'down');">
            </td>
          </tr>
          <?php
            foreach ($address_list as $addr) {
              if($addr['group_seq'] == NULL || $addr['group_seq'] == 0) {
          ?>
                <tr height=30 addr-groupseq="all" onclick="show_modify_addr(this);">
                  <td style="height:40px;">
                    <input type="checkbox" id="" name="" value="">
                  </td>
                  <td style="font-size:16px;font-weight:bold;padding-left:10px;">
                    <?php echo $addr['name']; ?>
                  </td>
                  <td align="right" style="color:#B0B0B0;">
                    <?php echo $addr['email']; ?>
                  </td>
                  <td>
                    <input type="hidden" name="modal_seq" name="" value="<?php echo $addr['seq']; ?>">
                    <input type="hidden" name="addr_name" value="<?php echo $addr['name']; ?>">
                    <input type="hidden" name="addr_email" value="<?php echo $addr['email']; ?>" >
                    <input type="hidden" name="addr_group" value="">
                    <input type="hidden" name="addr_dept" value="<?php echo $addr['department']; ?>">
                    <input type="hidden" name="addr_dept_group" value="<?php echo $addr['group']; ?>">
                    <input type="hidden" name="addr_comment" value="<?php echo $addr['comment']; ?>">
                  </td>
                </tr>

          <?php
              }
            }
          ?>
       </table>

      </div>
      <div class="paging_div">

      </div>
      <div class="address_footer" style="">

          <div class="" style="width: 5%">
          </div>
          <div class="div_footer" onclick="check_all();">
            <div>
              <img src="<?php echo $misc;?>img/mobile/전체선택.svg" style="cursor:pointer;">
            </div>
            <span>전체선택</span>
          </div>
          <div class="div_footer" onclick="show_addgroup();">
            <div>
              <img src="<?php echo $misc;?>img/mobile/플러스2.svg" style="width:20px; margin-top: 2px;">
            </div>
            <span>그룹추가</span>
          </div>
          <div id="add_address_pop"  class="div_footer">
            <div>
              <img src="<?php echo $misc;?>img/mobile/주소추가2.svg" style="cursor:pointer;">
            </div>
            <span>주소추가</span>
          </div>
          <div class="div_footer" style="width: 16%;">
            <div>
              <img src="<?php echo $misc;?>img/mobile/이동.svg" style="cursor:pointer;">
            </div>
            <span>이동</span>
          </div>
          <div class="div_footer" style="width: 16%;">
            <div>
              <img src="<?php echo $misc;?>img/mobile/휴지통.svg" style="cursor:pointer;">
            </div>
            <span>삭제</span>
          </div>
          <div class="" style="width: 5%">
          </div>
      </div>

    </div>
  </div>
  <div class="" id="group_add_div" style="background:white;width:100%;height:220px;display:none;">
    <div class="">
      <h2 id="modal_title" align="center">그룹 추가</h2>
    </div>
    <div class="" align="center">
      그룹명을 입력하세요.<br>
      <input type="hidden" id="rename_parent" name="" value="">
      <input type="hidden" id="rename_idx" name="" value="">
      <input type="hidden" id="rename_oldbox" name="" value="">
      <input type="text" id="add_group_input" name="" value="" style="width:90%;height:40px;">
    </div>
    <div class="" align="center" style="margin-top:10px;">
      <button type="button" name="button" class="btn_basic btn_blue" style="width:70px;" onclick="add_group_act()">등록</button>
      <button type="button" name="button" class="btn_basic btn_sky" style="width:70px;" onclick="$('#group_add_div').bPopup().close();">취소</button>
    </div>
  </div>

  <div class="" id="group_modify_div" style="background:white;width:100%;height:220px;display:none;">
    <div class="">
      <h2 id="modal_title" align="center">이름 변경</h2>
    </div>
    <div class="" align="center">
      그룹명을 입력하세요.<br>
      <input type="text" id="rename_group_input" name="" value="" style="width:90%;height:40px;">
    </div>
    <div class="" align="center" style="margin-top:10px;">
      <button type="button" name="button" class="btn_basic btn_blue" style="width:70px;" onclick="add_group_act()">이름변경</button>
      <button type="button" name="button" class="btn_basic btn_blue" style="width:70px;" onclick="">그룹삭제</button>
      <button type="button" name="button" class="btn_basic btn_sky" style="width:70px;" onclick="$('#group_modify_div').bPopup().close();">취소</button>
    </div>
  </div>

  <div id="add_address">
   <form action="" id="address_info" name="address_info" method="post">
    <table id="add_addr_tbl">
      <tr>
        <td width="25%"></td>
        <td width="75%"></td>
      </tr>
      <tr>
        <td>이름</td>
        <td><input type="text" id="address_name" name="address_name" placeholder="이름 입력"></td>
      </tr>
      <tr>
        <td>이메일</td>
        <td><input type="text" id="address_email" name="address_email" placeholder="이메일 입력"></td>
      </tr>
      <tr>
        <td>그룹</td>
        <td>
          <select class="" name="group_seq" id="group_seq" style="width:87%; border: none; border-bottom: 1px solid rgb(212, 213, 219); background-color: #fff;">
            <option value="">선택없음</option>
            <?php
            foreach ($address_group as $group) {
            ?>
              <option value="<?php echo $group['seq']; ?>"><?php echo $group["group_name"]; ?></option>
            <?php
            }
             ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>회사</td>
        <td><input type="text" id="address_department" name="address_department" placeholder="회사 입력"></td>
      </tr>
      <tr>
        <td>부서</td>
        <td><input type="text" id="address_group" name="address_group" placeholder="부서 입력"></td>
      </tr>
      <tr>
        <td>코멘트</td>
        <td><input type="text" id="address_comment" name="address_comment" placeholder="코멘트 입력"></td>
      </tr>

    </table>

      <div style="display: flex;  justify-content: center; padding: 15px;">
        <button id="address_inputBtn" class="btn_basic btn_blue" type="button" name="button" style="width: 60px;">등록</button>
        <button id="pop_close_btn" class="btn_basic btn_sky"  type="button" name="button" style="margin-left: 15px; width: 60px;" onclick="$('#add_address').bPopup().close();">
          취소
        </button>
      </div>
     </form>
    </div>

    <!-- 수정모달 -->
    <div id="modify_address">
     <form action="" id="address_info" name="address_info" method="post">
      <input type="hidden" id="modal_seq" name="" value="">
      <table id="add_addr_tbl">
        <tr>
          <td width="25%"></td>
          <td width="75%"></td>
        </tr>
        <tr>
          <td>이름</td>
          <td><input type="text" id="detail_address_modify_name" name="detail_address_modify_name" value="test"></td>
        </tr>
        <tr>
          <td>이메일</td>
          <td><input type="text" id="detail_address_modify_email" name="detail_address_modify_email" placeholder="이메일 입력"></td>
        </tr>
        <tr>
          <td>그룹</td>
          <td>
            <select class="" name="detail_group_seq" id="detail_group_seq" style="width:87%; border: none; border-bottom: 1px solid rgb(212, 213, 219); background-color: #fff;">
              <option value="">선택없음</option>
              <?php
              foreach ($address_group as $group) {
              ?>
                <option value="<?php echo $group['seq']; ?>"><?php echo $group["group_name"]; ?></option>
              <?php
              }
               ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>회사</td>
          <td><input type="text" id="detail_address_modify_department" name="detail_address_modify_department" placeholder="회사 입력"></td>
        </tr>
        <tr>
          <td>부서</td>
          <td><input type="text" id="detail_address_modify_group" name="detail_address_modify_group" placeholder="부서 입력"></td>
        </tr>
        <tr>
          <td>코멘트</td>
          <td><input type="text" id="detail_address_modify_comment" name="detail_address_modify_comment" placeholder="코멘트 입력"></td>
        </tr>

      </table>

        <div style="display: flex;  justify-content: center; padding: 15px;">
          <button class="btn_basic btn_blue" type="button" name="button" style="width: 60px; " onclick="address_detail_save();">수정</button>
          <button id="pop_close_btn" class="btn_basic btn_sky"  type="button" name="button" style="margin-left: 15px; width: 60px;" onclick="$('#modify_address').bPopup().close();">
            취소
          </button>
        </div>
       </form>
      </div>

  </body>

  <script type="text/javascript">

  $(function() {
    $("#add_address_pop").click(function(){
      $("#add_address").bPopup({
        position: [0, 0], //x, y
        speed: 500,
        transition: 'slideDown',
        transitionClose: 'slideDown'
      });
    });

    $("#address_inputBtn").on("click", function(){
      var addressName = $("#address_name").val();
      var addressEmail = $("#address_email").val();
      var addressDepartment = $("#address_department").val();
      var addressGroup = $("#address_group").val();
      var addressId = $("#address_id").val();
      var addressComment = $("#address_comment").val();
      var group_seq = $("#group_seq").val();
      if(addressName==""){
        alert("사용자의 이름을 입력해주세요.");
        $("#address_name").focus();
        return false;
      }
      if(addressEmail==""){
        alert("사용자의 이메일을 입력해주세요.");
        $("#address_email").focus();
        return false;
      }
      $.ajax({
        url: "<?php echo site_url(); ?>/group/address_action",
        data: {
          name:addressName,
          email:addressEmail,
          group_seq:group_seq,
          department:addressDepartment,
          group:addressGroup,
          id:addressId,
          comment:addressComment
        },
        type: 'POST',
        dataType: 'json',
        cache: false,
        success: function (result) {
          location.reload();
        }
      });
    })

    // $("#pop_close_btn").click(function(){
    //   $("#add_address").bPopup().close();
    // });

  });


  function updown(el, type) {
    if(type === "down") {
      $(el).attr("src", "<?php echo $misc;?>img/icon/오른쪽.svg");
      $(el).attr("onclick", "updown(this, 'up')");
      let groupSeq = $(el).parents('tr').attr('data-groupseq');
      $(`tr[addr-groupseq='${groupSeq}']`).hide();
    }else {
      $(el).attr("src", "<?php echo $misc;?>img/icon/아래3.svg");
      $(el).attr("onclick", "updown(this, 'down')");
      let groupSeq = $(el).parents('tr').attr('data-groupseq');
      $(`tr[addr-groupseq='${groupSeq}']`).show();
    }

  }

  function show_modify_addr(ths) {
    $("#modify_address").bPopup({
      position: [0, 0] //x, y
    });
    $('#modal_seq').val($(ths).children('td').children('input[name="modal_seq"]').val());
    $('#detail_address_modify_name').val($(ths).children('td').children('input[name="addr_name"]').val());
    $('#detail_address_modify_email').val($(ths).children('td').children('input[name="addr_email"]').val());
    $("#detail_group_seq").val($(ths).children('td').children('input[name="addr_group"]').val()).prop("selected", true);
    $('#detail_address_modify_department').val($(ths).children('td').children('input[name="addr_dept"]').val());
    $('#detail_address_modify_group').val($(ths).children('td').children('input[name="addr_dept_group"]').val());
    $('#detail_address_modify_comment').val($(ths).children('td').children('input[name="addr_comment"]').val());
  }

  // 연락처 상세보기 저장버튼 -> 수정됨
  function address_detail_save(){
    // alert("zz");
    var seq = $("#modal_seq").val();
    var name = $("#detail_address_modify_name").val(); // 값 가져오려면 val 창 비워
    // $("#detail_address_modify_departments").val('name'); // 값 내용 변경하려면 val에 변경값 입력해
    var email = $("#detail_address_modify_email").val();
    var department = $("#detail_address_modify_department").val();
    var group = $("#detail_address_modify_group").val();
    var group_seq = $("#detail_group_seq").val();
    // var id = $("#detail_address_modify_id").val();
    var comment = $("#detail_address_modify_comment").val();
    if(name==""){
      alert("사용자의 이름을 입력해주세요.");
      $("#detail_address_modify_name").focus();
      return false;
    }
    if(email==""){
      alert("사용자의 이메일을 입력해주세요.");
      $("#detail_address_modify_email").focus();
      return false;
    }
    $.ajax({
           url:"<?php echo site_url();?>/group/detail_address_save",
           type:'post',
           dataType : 'json',
           data:{
             seq:seq,
             name:name,
             email:email,
             department:department,
             group:group,
             group_seq: group_seq,
             // id:id,
             comment:comment
           },
           success: function(result){
             if(result){
               $("#modal_seq").val();
               alert("수정되었습니다.");
               location.reload();

             }else{
               alert("실패하였습니다.");
               return false;
             }
            }
          });

    // 버튼 누르면 값 updade하고 저장되는 로직 짜면 된답니다
  }

    function show_addgroup() {

      $("#group_add_div").bPopup({
        position: [0, 0] //x, y
      });
    }

    function show_modifygroup(ths) {
      $("#group_modify_div").bPopup({
        position: [0, 0] //x, y
      });
    }

    function add_group_act(){
      var group_name = $("#add_group_input").val();
      if (group_name == "") {
        return false;
      }
      $.ajax({
        url: "<?php echo site_url(); ?>/group/add_group_action",
        data: {
          group_name :group_name
        },
        type: 'POST',
        dataType: 'json',
        success: function (result) {
          // console.log(result);
          // ths.closest('td').append(group_name);
          // ths.remove();
          location.reload();
        }
      });

    }


    // var mboxtoggle = sessionStorage.getItem("mboxtoggle");
    // if(mboxtoggle != null && mboxtoggle !=""){
    //   var downarr = mboxtoggle.split(",");
    // }else{
    //   var downarr = [];
    //
    // }
    // var tr = $(el).closest('tr');
    // var child_num = $(el).closest('tr').attr('child_num');
    // var id = $(el).closest('tr').attr('id');
    //
    // if(type == 'down') {
    //   $('.box_tr').each(function() {
    //     var box_id = $(this).attr('id');
    //     if(box_id.indexOf(id+'.') != -1) {
    //       $(this).hide();
    //     }
    //   })
    //
    //   if(downarr.indexOf(id) == -1) {
    //     downarr.push(id);
    //   }
    //   sessionStorage.setItem("mboxtoggle", downarr);
    //   tr.find('.up_btn').show();
    //   tr.find('.down_btn').hide();
    // }
    // else {
    //   $('.box_tr').each(function() {
    //     var box_id = $(this).attr('id');
    //     if(box_id.indexOf(id+'.') != -1) {
    //       $(this).show();
    //     }
    //   })
    //
    //   if(downarr.indexOf(id) != -1) {
    //     for(let i = 0; i < downarr.length; i++) {
    //       if(downarr[i] === id)  {
    //         downarr.splice(i, 1);
    //         i--;
    //       }
    //     }
    //   }
    //
    //   tr.find('.down_btn').show();
    //   tr.find('.up_btn').hide();
    //   sessionStorage.setItem("mboxtoggle", downarr);
    // }
  </script>
</html>
