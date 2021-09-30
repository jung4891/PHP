
    id:<?=$id?><br>

    <?php
    // id에 해당하는 description 출력
    //v ar_dump($topics[0]->description);    // result()로 받은경우
    // echo $topics->description;            // row()로 받은경우
    ?>

  <article> <!-- HTML5부터 추가된, 본문을 의미하는 태그 -->
    <h1><?=$topic->title?></h1>
    <div>
      <?=$topic->description?>
    </div>
  </article>
