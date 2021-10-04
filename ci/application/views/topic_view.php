
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

<div id="bpopup">
  bpopup 테스트
</div>

<button id="btn1" type="button">버튼1</button>

<div class="wrap">
<input type="button" id="btn_open" value="레이어 팝업 열기">
</div>

<!--팝업 영역 시작 -->
<div id="popup" class="Pstyle">

  <table>
    <tr>
      <th>bPopup를 이용한 레이어 팝업입니다</th>
    </tr>
    <tr>
      <td style="height:100px">jquery bPopup 팝업 플러그인은<br><br> https://plugins.jquery.com/bpopup/에서 버젼별로 다운로드 받으실 수 있습니다</td>
    </tr>
  </table>
  <br>
  <input type="button" id="btn_close" value="닫 기">

</div>
<!--팝업 영역 끝 -->



<script type="text/javascript">
$(function(){
   $("#btn1").click(function(){
      $('#bpopup').bPopup();
      // alert("버튼1");
   });
});
</script>




<style>
 	body{margin:0;padding:0;max-height:800px}
	.wrap	{position:absolute;top:50%;left:50%;width:200px;height:100px;margin-top:-50px;margin-left:-100px;}

	table {width:100%;border-collapse:collapse; border:0; empty-cells:show; border-spacing:0; padding:0;}
	table th {height:24px; padding:4px 10px; border:1px solid #DDD; font-weight:bold; text-align:left; background:#ecf5fc;}
	table td {height:22px; padding:5px 10px; border:1px solid #DDD;}
	#btn_close{float:right}

	/*레이어 팝업 영역*/
	.Pstyle {
	 opacity: 0;
	 display: none;
	 position: relative;
	 width: auto;
	 border: 5px solid #fff;
	 padding: 20px;
	 background-color: #fff;
	}
	</style>

	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bPopup/0.11.0/jquery.bpopup.js"></script>
	<script>
		$(function(){
			$("#btn_open").click(function(){ //레이어 팝업 열기 버튼 클릭 시
				$('#popup').bPopup(); //
			});

			$("#btn_close").click(function(){ //닫기
				$('#popup').bPopup().close();
			});
		});
	</script>
