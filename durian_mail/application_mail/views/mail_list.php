<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>
<div id="main_contents">
  <?php print_r($test_msg); ?>
  <table border="1" width="1000">
    <thead>
      <tr>
        <th>No</th>
        <th>발신자</th>
        <th>제목</th>
        <th>날짜</th>
        <th>크기</th>
      </tr>
    </thead>
    <tbody>
      <?php
        for($num=1; $num<=$mails_cnt; $num++) {
      ?>
      <tr>
        <td><?=$num?></td>
        <td nowrap><?=htmlspecialchars(mb_decode_mimeheader($head[$num]->fromaddress))?></td>
        <!-- mb_decode_mimeheader() : MIME 인코드(암호화)되어 메일의 제목을 디코드(복호화)해야함 -->
        <!-- htmlspecialchars() : 제목에 포함된 HTML태그를 무효로 처리함 -->
        <td nowrap><?=htmlspecialchars(mb_decode_mimeheader($head[$num]->subject))?></td>
        <?php 	// Outlook 테스트 메시지에서 date 오류나서 애러처리함
          if (isset($head[$num]->date)) {
            $date = $head[$num]->date;
          } else {
            $date = '';
          }
         ?>
        <td nowrap><?=$date?></td>
        <td nowrap><?=$head[$num]->Size?></td>
      </tr>
      <?php
        }
       ?>

    </tbody>
  </table>
</div>

<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>
