<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->load->helper(array('download', 'form', 'url', 'file'));
  }

  // 곧장 다운로드창
  function index() {
    echo 'test페이지';
  }

  function download() {
    // $this->load->helper('download');

    // @ 파일에 내용을 써서 다운로드할 경우 (링크 호출하자마자 바로 다운로드창 . 결국 창은 안뜸)
    // $contents = "Sample 텍스트!";
    // $name = 'test.txt';
    // force_download($name, $contents);

    // @ 기존에 있는 파일 다운로드 (이미지로 해봄~)
    // echo getcwd();     // 현재 디렉토리 확인
    // $contents = file_get_contents("./misc/img/mylove.png");

    // @ 서버에 업로드된 파일 다운로드
    // echo $_POST['f_name'].'<br>';
    // echo $_POST['f_path'];
    $contents = file_get_contents($_POST['f_path']);
    $name = $_POST['f_name'];
    force_download($name, $contents);
  }

  // 파일 업로드 (기존 view파일 연결)
  function upload() {
    // $this->load->helper(array('form', 'url'));
    // $this->load->view('file/upload_form', array('error'=>''));
    // echo
    // '
    // <form action="/index.php/file/do_upload" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    //   <input type="file" name="userfile" size="">
    //   <!-- size는 뭐지?? 원래는 20 있었음 -->
    //   <br><br>
    //   <input type="submit" value="업로드">
    // </form>
    // ';
  }

  // 파일 업로드 (컨트롤러에서 싹다)
  /*
    - 이건 $_POST로 받아오는게 아닌거 같음.
    - 파일 업로드시 enctype="multipart/form-data"라는 속성과 값을 추가해야함.
      이는 파일 업로드의 경우 인코딩을 별도 수행하지 않도록함
    - 업로드 다중선택(하나도 가능)시 input의 multiple속성이 적용되어야 하고
      가장 중요한게 input의 name속성값이 배열([])로 해서 배열로 전달되게 해아함!
      근데 하나만 전달할 때는 name속성값이 userfile이어야함.
    - 근데 찾아보니 jQuery MultiFile 플러그인이 있음
      https://m.blog.naver.com/PostView.naver?isHttpsRedirect=true&blogId=javaking75&logNo=220087280269
      플러그인 다운 받아서 플러그인 js파일을 올려주고 사용

  */
  function do_upload($tmp=1) {
    $this->file_list();
    echo
    ' <br><br>
    <form action="/index.php/file/do_upload/2" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
      <!-- <input type="file" name="userfile[]" size="" multiple> -->
      <!-- <input type="file" name="userfile[]" class="multi" maxlength="3"> -->
      <!-- <input type="file" class="afile1" /> -->
      <input type="file" name="userfile[]" class="afile3" >
      <div id="afile3-list" style="border:2px solid #c9c9c9; margin-top:5px; min-height:50px; width:500px"></div>
      <br>
      <input type="submit" value="업로드">
    </form>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="/misc/js/jquery.MultiFile.min.js"></script>
    <script>
      $(function() {
        // 2개까지만 업로드할수있도록 설정
        // $("input.afile1").MultiFile(2);

        $("input.afile3").MultiFile({
          max: 3, //업로드 최대 파일 갯수 (지정하지 않으면 무한대)
          // accept: "jpg|png|gif", //허용할 확장자(지정하지 않으면 모든 확장자 허용)
          // maxfile: 1024, //각 파일 최대 업로드 크기
          // maxsize: 3024,  //전체 파일 최대 업로드 크기
          STRING: { //Multi-lingual support : 메시지 수정 가능
            remove : "", //추가한 파일 제거 문구, 이미태그를 사용하면 이미지사용가능
            duplicate : "$file 은 이미 선택된 파일입니다.",
            denied : "$ext 는(은) 업로드 할수 없는 파일확장자입니다.",
            selected: "$file 을 선택했습니다.",
            toomuch: "업로드할 수 있는 최대크기를 초과하였습니다.($size)",
            toomany: "업로드할 수 있는 최대 갯수는 $max개 입니다.",
            toobig: "$file 은 크기가 매우 큽니다. (max $size)"
          },
          list:"#afile3-list" //파일목록을 출력할 요소 지정가능
        })
      })
    </script>
    ';

    // 업로드 실행
    if ($tmp == 2) {
      // 업로드 설정 세팅 ( function set_upload_options() )
      $config = array();
      $config['upload_path'] = './uploads/';
      // 업로드를 허용할 파일의 마임타입(mime types)을 설정합니다.
      // 보통 파일 확장자는 마임타입으로 사용될수 있습니다. 멀티플타입은 파이프를 이용하여 구분합니다.
      $config['allowed_types'] = '*';
      // 원래 'gif|jpg|png' 였는데 txt파일이 전송이 안되서 확인해보니
      // - *로 설정하면 모든게 다됨 (동영상도 됨!!!!)
      // - 'txt'로 설정시 *로 해서 $upload_data를 찍어보면 ["file_type"]이 나옴
      //   이걸 config>mimes.php에서 txt => 여기에 추가를 해야함.
      // $config['max_size'] = '200';    // KB, 아래까지 전부 디폴트가 0으로 제한없음으로 설정됨
      // $config['max_width'] = '1024';
      // $config['max_height'] = '768';

      $this->load->library('upload', $config);

      $files = $_FILES;
      $f_cnt = count($_FILES['userfile']['name']);
      $cnt = 0;
      for($i=0; $i<$f_cnt; $i++) {
        $_FILES['userfile']['name']= $files['userfile']['name'][$i];
        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
        $_FILES['userfile']['size']= $files['userfile']['size'][$i];
        $do_upload = $this->upload->do_upload();
        if($do_upload) $cnt++;
      }

      if ($f_cnt == $cnt)
        echo
        '
        <h5>Your files was successfully uploaded!</h5>
        <script>
          $(function() {
            $("h5").css("color", "red");
            $("h5").fadeOut(2000);
            setTimeout(function(){
              location.href="/index.php/file/do_upload";
            }, 2000);
          })
        </script>
        ';

      else
        echo '<h5>어딘가 문제가 생김</h5>';
    }

      // 파일 한개만 할때 결과 출력화면
      if (false)
      if (! $do_upload) {
        // $error = array('error' => '애러~~!'.$this->upload->display_errors().'<br>');
        // $this->load->view('file/upload_form', $error);
        if ($this->upload->display_errors())
          echo '애러~~!'.$this->upload->display_errors().'<br>';
      }
      else {
        // $data = array('upload_data' => $this->upload->data());
        // $this->load->view('file/upload_success', $data);

        $upload_data = $this->upload->data();
        // echo '<pre>';
        // var_dump($upload_data);
        // echo '</pre>';
        echo '<h5>Your file was successfully uploaded!</h5>';
        echo
        '
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="/misc/js/jquery.MultiFile.min.js"></script>
        <script>
          $(function() {
            $("h5").css("color", "red");
            $("h5").fadeOut(3000);
            setTimeout(function(){
              location.href="/index.php/file/do_upload";
              // history.back();
              // location.reload();
            }, 3000);
          })
        </script>
        ';
      }
  }

  function file_list() {
    $file_list = get_dir_file_info('./uploads/');
    echo '<table border="1" width="500"><tr><th>파일명</th><th>크기</th></tr>';
    foreach($file_list as $f) {
      $size = $f['size']>1024000 ? round($f['size']/1024000, 2).'MB' : ($f['size']>1024 ? round($f['size']/1024).'KB' : $f['size'].'B');
      $name = $f['name'];
      $path = $f['server_path'];
      $path = str_replace('\\', '/', $path);
      echo '<tr>';
      echo "<td><a href='javascript:file_down(\"{$name}\", \"{$path}\")'>".$name.'</a></td>';
      echo '<td>'.$size.'</td>';
      echo '</tr>';
    }
    echo '</table>';
    // echo '<pre>';
    // var_dump($file_list);
    // echo '</pre>';
    echo
    '
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
      function file_down(name, path) {
        var newForm = $("<form></form>");
        newForm.attr("method","post");
        newForm.attr("action", "/index.php/file/download");
        newForm.append($("<input>", {type: "hidden", name: "f_name", value: name}));
        newForm.append($("<input>", {type: "hidden", name: "f_path", value: path}));

        newForm.appendTo("body");
        newForm.submit();
      }
    </script>
    ';
  }

}
