<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

 // 컨트롤러는 URL과 php파일을 매핑시켜준다.
 // http://localhost/ci/index.php -> 기본설정되어있는 컨트롤러의 welcome.php가 실행됨.
 // (index.php > 기본폴더로 application 설정 >
 //  routes.php > 기본 컨트롤러로 welcome.php 설정)

 class Topic extends CI_Controller{

   function __construct() {
     parent::__construct();                     // 원래 아래 메소드마다 db 라이브러리 블러오고 모델 로드했는데 이렇게 하면 클래스 호출되면 바로 자동 로드됨
     $this->load->database();                   //   데이터베이스 라이브러리(데이터베이스를 다루기 위한 도구) 로드
     $this->load->model('topic_model', 'm');    //   모델인 topic_model 클래스를 가져옴 (가져온 모델 객체를 m이란 별칭으로 받음)

     $this->load->helper('url');
     $this->load->library('pagination');   // 페이지네이션 라이브러리 로딩

     /*
     helper : 자주 사용하는 로직을 재활용 할 수 있게 만든 일종의 라이브러리
     헬퍼는 객체지향이 아닌 독립된 함수, 라이브러리는 객체지향인 클래스인점 다르다!
     헬퍼를 로드한 뒤 Cntroller,View,Model에서 url 핼퍼와 관련된 함수를 호출하면 된다.
     */
   }

  // http://localhost/ci/index.php/topic (URL에 클래스명만 있으면 index() 반드시 구현)
 	public function index() {

    $this->load->view('templates/header');

    $data = $this->m->gets();   // 가져온 topic_model 클래스(object/인스턴스)의 gets()메서드 실행
    $this->load->view('topic/topic_view', array('topics'=>$data));  // $data객체나 배열을 새로운 배열의 topics키에 넣는다
    $data2['msg'] = '메인페이지~';

    $this->load->view('topic/main', $data2);
    $this->load->view('templates/footer');
    // 이건 결국 $data라는 객체배열을 새로운 배열에 담아 그 인덱스가 view에선 $인덱스(topics)가 되고 그 안에 $data가 있다.
    // 결국 배열을 사용해 인덱스명('topics')으로 컨트롤러가 데이터를 전달하면 뷰는 $topics로 데이터를 받게 된다.
    // echo $this->uri->segment(1);      // topic (http://ci/topic)

    // 컨트롤러에서 foreach문으로 데이터들을 띄워봄
    // foreach($data as $row) {
    //   echo '<pre>';
    //   var_dump($row);            // 전체 데이터 가져옴
    //   var_dump($row->title);     // 제목들만 가져옴 (result()로 object로 받았을 때)
    //                              // $row가 객체라 -> 가 가능한것임 즉, 속성을 가리켜서 속성의 값이 나오는것인듯
    //   var_dump($row['title']);   // result_array()로 array형태로 받았을 경우
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
    //     <h1>제목1 테스트</h1>
    //   </body>
    // </html>
    // ';
 	}

  public function get($id){
    // $this->index();
    $data = $this->m->gets();
    $topic = $this->m->get($id);
    // $data = array('topic'=>$topic, 'id'=>$id);
    // var_dump($data);

    $this->load->view('templates/header');
    $this->load->view('topic/topic_view', array('topics'=>$data));
    $this->load->view('topic/get_view', array('topic'=>$topic, 'id'=>$id));   // 아래 주석부분 참고
    $this->load->view('templates/footer');

  }
  /*
    내부구조(ㅈㄴ 헷갈리네..)
    array(2) {
      ["topic"]=> object(stdClass)#23 (4) { ["id"]=> "1" ["title"]=> "JavaScript란" ["description"]=> "~~" ["created"]=> "2021-09-29 09:27:30" }
      ["id"]=> string(1) "1" }
  */

  public function pagination() {
    $this->load->view('templates/header');

    $data = $this->m->gets();
    $this->load->view('topic/topic_view', array('topics'=>$data));
    $data2['msg'] = 'Pagination 연습';

    // 동적으로 설정할 부분들만 설정함. 정적인 부분은 config>pagination에 넣음
    $config['total_rows'] = 20;
    $config['per_page'] = 5;
    $this->pagination->initialize($config);
    // 위에서 배열로 설정한 설정을 Pagination 라이브러리의 설정으로 초기화하여 아래에서 링크들을 만들어냄
    $data2['links'] = $this->pagination->create_links();
    // ex) http://ci/index.php/topic/pagination/5

    $page = ($this->uri->segment(3))? $this->uri->segment(3):0;
    $data2['res'] = $this->m->fetch_users($config['per_page'], $page);  // ($limit, $start)

    $this->load->view('topic/main', $data2);
    $this->load->view('templates/footer');
  }

  // http://localhost/ci/index.php/topic/get_test/11/22 (클래스명/메소드/아규먼트)
  public function get_test($num, $num2)
  {
    $data = array('num1'=>$num);   // 키 이름인 num1이 HTML에서 $num1으로 변수명이되어 값이 들어감
    $data['num2'] = $num2;         // 배열은 그저 전달자 역할만 할 뿐임
    $this->load->view('templates/header');
    // $this->load->view('topic/get_test_view', $data);                            // 미리 배열로 만들어 전달
    $this->load->view('topic/get_test_view', array('n1'=>$num, 'n2'=>$num2));   // 전달할 때 배열로 만듬
    $this->load->view('templates/footer');                                      // (하나만 전달해도 됨)
    // echo 'get_test '.$num.$num2;    // get_test 1122
  }

  // 애러페이지 출력
  public function error() {
    $this->load->view('templates/header');
    $msg = '페이지가 없습니다~!';
    $this->load->view('topic/main', array('msg'=>$msg));
    $this->load->view('templates/footer');
  }

 }
