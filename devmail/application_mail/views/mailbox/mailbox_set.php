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
      <button type="button" name="button" onclick="add_mybox()">내메일함 추가</button>
      <?php if(count($mbox_info) == 5) {?>
      <button type="button" name="button" onclick="add_mybox()">내메일함 추가</button>
      <?php }else { ?>
      새 메일함 &nbsp;<input type="text" name="" value="">
      <button type="button" name="button">추가</button>
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
        <td>비우기 | 모두 읽음표시</td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td>보낸메일함</td>
        <td><?php echo $mbox_info[1]["unseen_cnt"].'/'.$mbox_info[1]["mails_cnt"];?></td>
        <td>비우기 | 모두 읽음표시</td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td>임시보관함</td>
        <td><?php echo $mbox_info[2]["unseen_cnt"].'/'.$mbox_info[2]["mails_cnt"];?></td>
        <td>비우기 | 모두 읽음표시</td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td>스팸메일함</td>
        <td><?php echo $mbox_info[3]["unseen_cnt"].'/'.$mbox_info[3]["mails_cnt"];?></td>
        <td>비우기 | 모두 읽음표시</td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td>휴지통</td>
        <td><?php echo $mbox_info[4]["unseen_cnt"].'/'.$mbox_info[4]["mails_cnt"];?></td>
        <td>비우기 | 모두 읽음표시</td>
      </tr>
      <tr>
        <td colspan="4" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <?php
        // $my_mbox_cnt = count($mbox_info)-6;
        // if(count($mbox_info)>)

       ?>
      <!-- <tr align="center">
        <td rowspan="3">내메일함</td>
        <td>테스트1</td>
        <td>10/100</td>
        <td>수정 | 삭제 | 비우기 | 모두 읽음표시</td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td>테스트2</td>
        <td>10/100</td>
        <td>수정 | 삭제 | 비우기 | 모두 읽음표시</td>
      </tr> -->
      <!-- <tr>
        <td colspan="4" style="border-bottom: 2px solid lightgray; "></td>
      </tr> -->
    </table>

    <br>
    <pre align="left">
      <?php var_dump($mbox_info[5]); ?>
    </pre>
</div>

<script type="text/javascript">
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
</script>

<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_footer.php";
 ?>
