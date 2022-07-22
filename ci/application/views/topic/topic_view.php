
  <?php
  // pre태그 있으면 부트스트랩 span2, span10 적용안됨!!
  // echo '<pre>';
  // var_dump($topics);     // 전체데이터 출력

  // 테이블의 첫번째 ROW의 'title'만 출력
  // var_dump($topics[0]->title);       // (객체배열로 받앋을 경우 / result())
  // var_dump($topics[0]['title']);     // (배열로 받았을 경우 / result_array())
  // echo '</pre>';
  ?>

<!--Sidebar content-->
<div class="span2">
  <!-- 부트스트랩 홈페이지 > nav > Stacked tabs (메뉴바) -->
  <ul class="nav nav-tabs nav-stacked">
    <?php
    // 전체 title들 출력
    foreach($topics as $row) {
      // echo "<li><a href=\"/index.php/topic/{$row->id}\">".$row->title.'</a></li>';  // URI Routing 적용
      echo "<li><a href=\"/index.php/topic/get/{$row->id}\">".$row->title.'</a></li>';
      // href="topic~ " 이렇게 하면 처음 접속은 되는데 다음부터는 주소 뒤에 덧붙이기됨.
      // echo $row['title'];
    }
    echo "<li><a href=\"/index.php/topic/pagination\">Pagination</a></li>";
    ?>
  </ul>
</div>
