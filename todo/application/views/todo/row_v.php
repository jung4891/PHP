
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
      <tr style="background-color:lightgray">
        <th colspan="1" class="content"><?php echo $row->content; ?></th>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td><a class="btn blue" href="/todo/index.php/main/update/<?php echo $this->uri->segment(3); ?>">수정</a></td>
        <td><a class="btn blue" href="/todo/index.php/main/delete/<?php echo $this->uri->segment(3); ?>">삭제</a></td>
        <td><a class="btn blue" href="/todo/index.php/main/lists">목록</a></td>
      </tr>
    </tfoot>
  </table>
  <hr>
</article>
