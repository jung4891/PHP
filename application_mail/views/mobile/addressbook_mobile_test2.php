<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mobile/mail_header_mobile.php";
 ?>
<style media="screen">

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

  font-size: 0.8em;
  display: block;
  padding-top: 3px;
  width: 100%;
  height: 55px;
  opacity: 0;
  position: relative;
  top: -52px;
}
select:focus {
  outline: none;
}

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

#add_address {
  display:none;
  width:100%;
  height: 285px;
  background-color:#ffffff;
  border-radius: 20px 20px 20px 20px;
}

#add_addr_tbl {
  width:100%;
  border-spacing: 5px;
  padding-top: 10px;
  padding-left: 25px;
  color: gray;
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

    <div class="address_main">
      <div class="search_div">

      </div>
      <div class="address_div" style="height: 74vh; overflow-y: scroll">

        <table id="" border="0" cellspacing="0" cellpadding="25" style="width:100%;">
          <?php
          foreach ($address_group as $group) {
            $select_group = ($group['seq'] == $group_name)?"select_group":"";
          ?>
          <tr height=30 class="group_tr <?php echo $select_group; ?>" data-groupseq = "<?php echo $group['seq']; ?>">
            <td style="font-weight: bold">
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
                <tr height=30 addr-groupseq="<?php echo $group['seq']; ?>">
                  <td style="padding-left: 35px; padding-top: 0px;">
                    <?php echo $addr['name']; ?>
                  </td>
                  <td align="right" style="color:silver;  padding-top: 0px; font-size: 0.8em;">
                    <?php echo $addr['email']; ?>
                  </td>
                </tr>
          <?php
              }
            }
          }
           ?>

          <tr height=30  data-groupseq="all">
            <td style="font-weight: bold">
              기타
            </td>
            <td align="right">
              <img src="<?php echo $misc;?>img/icon/아래3.svg" class="down_btn" style="" onclick="updown(this, 'down');">
            </td>
          </tr>
          <?php
            foreach ($address_list as $addr) {
              if($addr['group_seq'] === null) {
          ?>
                <tr height=30 addr-groupseq="all">
                  <td style="padding-left: 35px; padding-top: 0px;">
                    <?php echo $addr['name']; ?>
                  </td>
                  <td align="right" style="color:silver;  padding-top: 0px; font-size: 0.8em;">
                    <?php echo $addr['email']; ?>
                  </td>
                </tr>
          <?php
              }
            }
          ?>
       </table>

        <!-- <pre>
        <?php
          var_dump($address_list);
         ?>
       </pre> -->
      </div>
      <div class="address_footer">
        <div class="choose_div" style="display: flex; background-color: black; padding-top: 4%;">
          <div class="" style="width: 5%">
          </div>
          <div class="div_footer" onclick="check_all();">
            <div>
              <img src="<?php echo $misc;?>img/mobile/전체선택.svg">
            </div>
            <span>전체선택</span>
          </div>
          <div class="div_footer">
            <div>
              <img src="<?php echo $misc;?>img/mobile/플러스2.svg" style="width:20px; margin-top: 2px;">
            </div>
            <span>그룹추가</span>
          </div>
          <div class="div_footer">
            <div >
              <img src="<?php echo $misc;?>img/mobile/주소추가2.svg">
            </div>
            <span>주소추가</span>
          </div>
          <div class="div_footer" onclick="move_spam();" style="width: 16%;">
            <div>
              <img src="<?php echo $misc;?>img/mobile/이동.svg">
            </div>
            <span>이동</span>
          </div>
          <div class="div_footer" onclick="del_trash();" style="width: 16%;">
            <div>
              <img src="<?php echo $misc;?>img/mobile/휴지통.svg">
            </div>
            <span>삭제</span>
          </div>
          <div class="" style="width: 5%">
          </div>
        </div>
      </div>
    </div>

    <div id="add_address">
      <table id="add_addr_tbl">
        <tr>
          <td width="25%"></td>
          <td width="75%"></td>
        </tr>
        <tr>
          <td>이름</td>
          <td><input type="text" id="from" name="from" placeholder="이름 입력"></td>
        </tr>
        <tr>
          <td>이메일</td>
          <td><input type="text" id="to" name="to" placeholder="이메일 입력"></td>
        </tr>
        <tr>
          <td>그룹</td>
          <td><input type="text" id="subject" name="subject" placeholder="그룹 입력"></td>
        </tr>
        <tr>
          <td>회사</td>
          <td><input type="text" id="contents" name="contents" placeholder="회사 입력"></td>
        </tr>
        <tr>
          <td>부서</td>
          <td><input type="text" id="contents" name="contents" placeholder="부서 입력"></td>
        </tr>
        <tr>
          <td>코멘트</td>
          <td><input type="text" id="contents" name="contents" placeholder="코멘트 입력"></td>
        </tr>

      </table>

        <div style="display: flex;  justify-content: center; padding: 15px;">
          <button id="add_address_submit" class="btn_basic btn_blue" type="button" name="button">검색</button>
          <button id="pop_close_btn" class="btn_basic btn_sky"  type="button" name="button" style="margin-left: 15px;">
            취소
          </button>
        </div>
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

    $("#pop_close_btn").click(function(){
      $("#add_address").bPopup().close();
    });

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
  }
  </script>
</html>
