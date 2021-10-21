<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>
<div id="main_contents">

  <?php
  // 테스트용
  // echo '<pre>';
  // var_dump($mails_info);
  // echo '</pre>'
  ?>

  <?php echo $test_msg; ?>
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
        <?php
        // 발신자 이름이 따로 명시된 경우 (personal이란 속성이 있다. 객체 요소갯수를 빼내오질 못해 보류..)
        // echo count($head[$num]->from, COUNT_RECURSIVE);
        // $personal = imap_utf8($head[$num]->from[0]->personal);
        // if (empty($personal)) {
        //   $personal = imap_utf8($head[$num]->fromaddress);
        // }
        // echo $personal;
        ?>
        <!-- 발신자 메일주소만 or 발신자 이름(있는경우만) <메일주소> -->
        <!-- mb_decode_mimeheader() : MIME 인코드(암호화)되어있는 메일의 제목을 디코드(복호화)해야함 -->
        <!-- htmlspecialchars() : 제목에 포함된 HTML태그를 무효로 처리함 -->
        <!-- <td><?=imap_utf8($head[$num]->fromaddress)?></td>  ->  hjsong@durianit.co.kr -->
        <!-- <td><?=htmlspecialchars(mb_decode_mimeheader($head[$num]->fromaddress))?></td> -> 송혁중 <go_go_ssing@naver.com>  -->

        <?php 	// Outlook 테스트 메시지에서 date 오류나서 애러처리함
        if (isset($head[$num]->date)) {
          $date = $head[$num]->date;
        } else {
          $date = '';
        }
        ?>
        <td><?=$num?></td>
        <td><?=htmlspecialchars(mb_decode_mimeheader($head[$num]->fromaddress))?></td>
        <td><a href="/index.php/mailbox/mail_detail/<?=$num?>"><?=imap_utf8($head[$num]->subject)?></a></td>
        <td nowrap><?=$date?></td>
        <td nowrap><?=$head[$num]->Size?> bytes</td>
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
