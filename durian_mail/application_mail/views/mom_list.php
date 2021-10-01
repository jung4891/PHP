<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>
<div id="main_contents">
  <table border="1" width="1000">
    <thead>
      <tr>
        <th>번호</th>
        <th>제목</th>
        <th>작성자</th>
        <th>그룹</th>
        <th>참석자</th>
        <th>작성일</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $cnt = 0;
        foreach($biz_mom as $row) {
       ?>
          <tr>
            <td><?php echo $row->seq; ?></td>
            <td><?php echo $row->title; ?></td>
            <td><?php echo $row->user_name; ?></td>
            <td><?php echo $row->user_group; ?></td>
            <td><?php echo $name_arr[$cnt]; ?></td>
            <td><?php echo $row->insert_day; ?></td>
          </tr>
      <?php
          $cnt++;
        }
       ?>
    </tbody>
  </table>

</div>


<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>
