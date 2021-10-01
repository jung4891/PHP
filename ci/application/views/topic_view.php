
  <!-- &lt;views&gt; <br>
  컨트롤러의 topic클래스의 index()메소드 -->

  <?php
  echo '<pre>';
  // var_dump($topics);     // 전체데이터 출력

  // 테이블의 첫번째 ROW의 'title'만 출력
  // var_dump($topics[0]->title);       // (객체배열로 받앋을 경우 / result())
  // var_dump($topics[0]['title']);     // (배열로 받았을 경우 / result_array())

  echo '</pre>';
  ?>


<ul>
  <?php
  // 전체 title들 출력
  foreach($topics as $row) {
    echo "<li><a href=\"/index.php/topic/get/{$row->id}\">".$row->title.'</a></li>';
    // echo $row['title'];
  }
  ?>
</ul>
