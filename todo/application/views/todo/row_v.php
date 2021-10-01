
<article>
  <header>
    <h1>Todo 조회</h1>
  </header>
  <hr>
  <table cellspacing="20">
    <thead>
      <tr>
        <th scope="col"><?php echo $row->id; ?> 번 할일</th>
        <th scope="col">시작일: <?php echo $row->created_on; ?></th>
        <th scope="col">종료일: <?php echo $row->due_date; ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th colspan="1" class="content"><?php echo $row->content; ?></th>
      </tr>
    </tbody>
    <tfoot>
      <th>
        <a class="btn blue" href="/todo/index.php/main/write">쓰기 blue</a>
      </th>
    </tfoot>
  </table>
  <hr>
</article>
