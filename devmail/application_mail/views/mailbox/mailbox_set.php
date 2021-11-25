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
    <div class="" align="left" style="margin-left: 55px">
      새 메일함 &nbsp;<input type="text" name="" value="">
      <button type="button" name="button">추가</button>
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
        <td>10/100</td>
        <td>비우기 | 모두 읽음표시</td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td>보낸메일함</td>
        <td>10/100</td>
        <td>비우기 | 모두 읽음표시</td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td>임시보관함</td>
        <td>10/100</td>
        <td>비우기 | 모두 읽음표시</td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td>스팸메일함</td>
        <td>10/100</td>
        <td>비우기 | 모두 읽음표시</td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
        <td>휴지통</td>
        <td>10/100</td>
        <td>비우기 | 모두 읽음표시</td>
      </tr>
      <tr>
        <td colspan="4" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
      <tr align="center">
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
      </tr>
      <tr>
        <td colspan="4" style="border-bottom: 2px solid lightgray; "></td>
      </tr>
    </table>
</div>





<script type="text/javascript">

</script>

<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_footer.php";
 ?>
