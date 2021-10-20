
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
    // href="topic~ " 이렇게 하면 처음 접속은 되는데 다음부터는 주소 뒤에 덧붙이기됨.
    // echo $row['title'];
  }
  ?>
</ul>

<!-- <div id="bpopup">
  bpopup 테스트
</div>

<button id="btn1" type="button">버튼1</button>

<script type="text/javascript">
$(function(){
   $("#btn1").click(function(){
      $('#bpopup').bPopup();
      // alert("버튼1");
   });
});
</script>


<div class="wrap">
<input type="button" id="btn_open" value="레이어 팝업 열기">
</div>

<!--팝업 영역 시작 -->
<!-- <div id="popup" class="Pstyle">

  <table>
    <tr>
      <th>bPopup를 이용한 레이어 팝업입니다</th>
    </tr>
    <tr>
      <td style="height: 200px">jquery bPopup 팝업 플러그인은<br><br> https://plugins.jquery.com/bpopup/에서 버젼별로 다운로드 받으실 수 있습니다</td>
    </tr>
  </table>
  <br>
  <input type="button" id="btn_close" value="닫 기">

</div> -->
<!--팝업 영역 끝 -->

<!-- <br><br>
<button>모달창</button>
<div class="modal">
  <div class="modal_content" title="클릭하면 창이 닫힙니다.">
    여기에 모달창 내용을 적어줍니다.<br> 이미지여도 좋고 글이어도 좋습니다.
  </div>
</div>

<style media="screen">
.modal{ position:absolute; width:100%; height:100%; background: rgba(0,0,0,0.7); top:0; left:0;
        display:none; }
.modal_content{
  width:400px; height:200px;
  background:#fff; border-radius:10px;
  position:relative; top:50%; left:50%;
  margin-top:-100px; margin-left:-200px;
  text-align:center;
  box-sizing:border-box; padding:74px 0;
  line-height:23px; cursor:pointer;
}
</style>

<script type="text/javascript">
$(function(){
  $("button").click(function(){
    $(".modal").fadeIn();
  });
  $(".modal_content").click(function(){
    $(".modal").fadeOut();
  });
});
</script> -->
