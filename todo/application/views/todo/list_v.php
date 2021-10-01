<nav>  <!-- 다른페이지의 링크에 사용. 메뉴, 목차 등등 -->
  <ul>
    <li><a rel="help" href="/todo/index.php/main/lists">todo 애플리케이션 프로그램</a> </li>
  </ul>
</nav>
<article>
  <header>
    <h1>Todo 목록</h1>
  </header>
  <hr>
  <table cellspacing="20">
    <thead>
      <tr>
        <th scope="col">번호</th>
        <th scope="col">내용</th>
        <th scope="col">시작일</th>
        <th scope="col">종료일</th>
      </tr>
    </thead>
    <tbody>
<?php
  foreach($list as $row) {
 ?>
    <tr>
      <td><?php echo $row->id; ?></td>
      <td><a rel="external" href="/todo/index.php/main/view_row/<?php echo $row->id; ?>">
          <?php echo $row->content; ?></a></td>
      <td><?php echo $row->created_on; ?></td>
      <td><?php echo $row->due_date; ?></td>
    </tr>
<?php
}
 ?>
    </tbody>
    <tfoot>
      <th>
        <a href="/todo/index.php/main/write">쓰기</a>
      </th>
    </tfoot>
  </table>
  <hr>
</article>
