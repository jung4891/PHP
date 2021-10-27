<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

  function __construct() {
    parent::__construct();
  }

  function index() {
    echo 'test페이지';
  }

  function download() {
    $this->load->helper('download');

    // @ 파일에 내용을 써서 다운로드할 경우 (링크 호출하자마자 바로 다운로드창 . 결국 창은 안뜸)
    // $contents = "Sample 텍스트!";
    // $name = 'test.txt';
    // force_download($name, $contents);

    // @ 기존에 있는 파일 다운로드
    $contents = file_get_contents("‪test.txt");
    echo $contents;
    $name = 'test2.txt';
    // force_download($name, $contents);
    echo 'aa';
  }

}
