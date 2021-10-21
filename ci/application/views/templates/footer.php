
      </div>
    </div>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="/misc/lib/bootstrap/js/bootstrap.min.js"></script>

  <!-- <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script> -->
  <!-- <script src="\misc\js\jquery.bpopup-0.1.1.min.js"></script> -->
  <!-- <script src="jquery.bpopup-0.1.1.min.js"></script> 이렇게 하면 안됨 -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bPopup/0.11.0/jquery.bpopup.js"></script> -->
  </body>
</html>

<!-- 푸터를 내용보다 먼저 불러와도 내용 뒤에 붙는다. -->

<!-- src 경로설정시 주의!!  -->
<!-- 경로를 application안으로는 접근이 안된다. CI 내부구조가 그렇게 되어 있는듯
     아예 최상위 아래 application폴더와 같은 위치에 폴더를 만들어 접근해야 함
     위 스크립트처럼(7line) 이 파일 위치하는 곳에 가져올 js파일 두고 가져와도 소용없음 -->

<!-- 외부 js, css파일에 접근되는지 브라우저에서 확인  -->
<!-- C:/xampp/htdocs/ci/misc/css/topic.css   ->  드라이브에 접근해서 확인
    http://ci/misc/css/topic.css    ->  서버가 해당 파일 오픈 (index.php 제외!) -->

<!-- 외부 css파일 연동하기 -->
<!-- 간혹가다 경로 잘 되어있는데 가져오지 못하는 경우엔 헤더에 직접 style태그 사용해서
    적용여부 보고 다시 해보면 되는경우 있음. or ★ f12 > 새로고침 우클릭 > 캐시비우기 및 강력새로고침!! -->
<!-- 잘 연동되었는지 확인은 개발자도구 > 네트워크 탭에서 열어놓고 새로고침해보면 나옴
    가령 topic.css 눌러보면 요청 URL이 나오는데 그게 불러오는 주소임.
    즉, topic.css 더블클릭 해보면 바로 해당 파일로 접근해서 브라우저에 출력확인 가능함
    보니까 href에 "misc/~" 는 ci/index.php/misc로 접근되고 (컨트롤러로 인식됨)
                  "/misc~" 는 ci/misc로 접근됨. (경로로 인식됨)  이래서 그동안 헷갈렸던거임... -->
