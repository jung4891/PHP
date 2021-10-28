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

  // 파일 업로드 (이미지는 되는데 txt는 안됨)
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

  // 그리고 이건 $_POST로 받아오는게 아닌거 같음.
  // enctype은 전송되는 데이터 형식을 설정
  function do_upload($tmp=1) {
    $this->file_list();
    echo
    ' <br><br>
    <form action="/index.php/file/do_upload/2" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
      <input type="file" name="userfile" size="" multiple>
      <!-- size는 뭐지?? 원래는 20 있었음 -->
      <br><br>
      <input type="submit" value="업로드">
    </form>
    ';
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
      if (! $this->upload->do_upload()) {
        // $error = array('error' => '애러~~!'.$this->upload->display_errors().'<br>');
        // $this->load->view('file/upload_form', $error);
        if ($tmp == 2)
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
