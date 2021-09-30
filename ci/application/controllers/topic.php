<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

 class Topic extends CI_Controller {

  // 컨트롤러는 URL과 php파일을 매핑시켜준다.
  // http://localhost/ci/index.php -> 기본설정되어있는 컨트롤러의 welcome.php가 실행됨.
  // (index.php > 기본폴더로 application 설정 >
  //  routes.php > 기본 컨트롤러로 welcome.php 설정)

  // http://localhost/ci/index.php/topic (클래스명만 있으면 index() 반드시 구현)
 	public function index()
 	{
    $this->load->database();   // 데이터베이스 라이브러리(데이터베이스를 다루기 위한 도구) 로드
    $this->load->model('topic_model', 'm');    // 모델인 topic_model 클래스를 가져옴 (가져온 모델 객체를 m이란 별칭으로 받음)
    $data = $this->m->gets();   // 가져온 topic_model 클래스(object/인스턴스)의 gets()메서드 실행

    $this->load->view('topic_view', array('topics'=>$data));  // $data객체나 배열을 새로운 배열의 topics키에 넣는다.
    // 이건 결국 $data라는 객체/베열을 새로운 배열에 담아 그 인덱스가 view에선 $인덱스가 된고 그 안에 $data가 있다.
    // 결국 배열을 사용해 인덱스명('topics')으로 컨트롤러가 데이터를 전달하면 뷰는 $topics로 데이터를 받게 된다.


    // 컨트롤러에서 foreach문으로 데이터들을 띄워봄
    // foreach($data as $row) {
    //   echo '<pre>';
    //   // var_dump($row);         // 전체 데이터 가져옴
    //   // var_dump($row->title);  // 제목들만 가져옴 (result()로 object로 받았을 때)
    //                              // $row가 객체라 -> 가 가능한것임 즉, 속성을 가리켜서 속성의 값이 나오는것인듯
    //   var_dump($row['title']);   // result_array()로 array형태로 받았을 경우
    //
    //   echo '</pre>';
    // }

    // 컨트롤러에서 view를 띄워보기
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
  public function get($id)
  {
    $this->load->view('templates/header');
    $this->load->view('get_view', array('id'=>$id));
    $this->load->view('templates/footer');
  }

  // http://localhost/ci/index.php/topic/get_test/11/22 (클래스명/메소드/아규먼트)
  public function get_test($num, $num2)
  {
    $data = array('num1'=>$num);   // 키 이름인 num1이 HTML에서 $num1으로 변수명이되어 값이 들어감
    $data['num2'] = $num2;
    $this->load->view('templates/header');
    $this->load->view('get_test_view', $data);                               // 미리 배열로 만들어 전달
    $this->load->view('get_test_view', array('num1'=>$num, 'num2'=>$num2));  // 전달할 때 배열로 만듬
    $this->load->view('templates/footer');                                   // (하나만 전달해도 됨)
    // echo 'get_test '.$num.$num2;    // get_test 1122
  }

 }