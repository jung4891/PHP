
  <div class="span10">
    <!-- id:<?=$id?><br> -->

    <?php
    // id에 해당하는 description 출력
    // var_dump($topics[0]->description);    // result()로 받은경우
    // echo $topics->description;            // row()로 받은경우
    ?>

    <article> <!-- HTML5부터 추가된, 본문을 의미하는 태그 -->
      <h1><?=$topic->title?></h1>
      <div>
        <div>
          <?php
            // stamp값을 php date 함수로 해당 형식으로 출력 (근데 db랑 시간이 안맞음)
            // echo date('o년 n월 j일, G시 i분 s초', $topic->created);

            // 내가 만든 헬퍼의 함수
            echo kdate($topic->created);

           ?>
        </div>
        <?php
        // auto_link : url 헬퍼 함수로 문자열에 포함되어있는 URL 및email 주소를 링크로 변환함
        echo auto_link($topic->description)?>
      </div> <br><br>
      <?php

      // anchor() : 표준 HTML 앵커 링크(anchor link)를 사이트 URL 에 맞도록 생성해 줌
      // anchor(uri segments, text, attributes)
      echo anchor('topic/get/2', 'anchor 테스트', 'title="오호~~"').'<br><br>';
      echo anchor('topic/get/3', 'anchor 테스트2', array('title'=>'히히~~')).'<br><br>';


      // anchor_popup() : anchor() 함수와 같으나 URL을 팝업으로 띄움
      // $atts 그냥 array()로 보내면 기본 브라우저 설정으로 팝업 띄어짐
      $atts = array(
              'width'      => '500',
              'height'     => '300',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0',
              'title' => '이것도 되는군~'
            );
      echo anchor_popup('topic/pagination', 'anchor_popup 테스트', $atts);

       ?>
    </article>
  </div>
