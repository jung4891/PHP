
<style media="screen">

</style>
  <article id="a">

    <table>
      <thead>
        <tr>
          <th scope="col">번호</th>
          <th scope="col">제목</th>
          <th scope="col">작성자</th>
          <th scope="col">조회수</th>
          <th scope="col">작성일</th>
        </tr>
      </thead>
      <tbody>
<?php
foreach ($list as $lt) {
 ?>
        <tr>
          <th scope="row"><?php echo $lt->board_id; ?></th>
          <td><?php echo $lt->subject; ?></td>
          <td><?php echo $lt->user_name; ?></td>
          <td><?php echo $lt->hits; ?></td>
          <td><?php echo $lt->reg_date; ?></td>
          <!-- <td><time datetime="<?php // echo mdate("%Y-%M-%j", $list[3]->reg_date); ?>">
            <?php // echo mdate("%M. %j, %Y", $list[3]->reg_date); ?></time></td> -->
        </tr>
<?php
}
 ?>
      </tbody>
    </table>

</article>
