<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

 class Topic extends CI_Controller {

  // 컨트롤러는 URL과 php파일을 매핑시켜준다.
  // http://localhost/ci/index.php -> 기본설정되어있는 컨트롤러의  welcome.php가 실행됨.

  // http://localhost/ci/index.php/topic (클래스명만 있으면 index() 반드시 구현)
 	public function index()
 	{
    $this->load->view('topic_view');

    // echo '
    // <!DOCTYPE html>
    // <html>
    //   <head>
    //     <meta charset="utf-8">
    //   </head>
    //   <body>
    //     컨트롤러의 topic클래스의 index()메소드
    //   </body>
    // </html>
    // ';
 	}

  // http://localhost/ci/index.php/topic/get_test/11/22 (클래스명/메소드/아규먼트)
  public function get_test($num, $num2)
  {
    $data = array('num'=>$num);
    $data['num2'] = $num2;
    $this->load->view('templates/header');
    $this->load->view('get_test_view', $data);
    $this->load->view('templates/footer');
    // echo 'get_test '.$num.$num2;    // get_test 1122
  }

 }
